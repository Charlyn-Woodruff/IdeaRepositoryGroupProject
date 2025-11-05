<?php
// Functions for managing users in the database.

require_once("/var/www/html/idea-repository/php/databaseConnection.php");
require_once("/var/www/html/idea-repository/php/user.php");
require_once("/var/www/html/idea-repository/php/idea.php");
require_once("/var/www/html/idea-repository/php/log.php");
require_once("/var/www/html/idea-repository/php/sanatize.php");

class UserDatabase {
    public ?mysqli $database;
    public Log $logging;
    function __construct(?mysqli $database, ?Log $logging) {

        $this->database = $database;
        $this->logging = $logging;
    }
        
    /**
        * Gets the user with the specified user ID.
        * @param string $username The ID of the user to select
        * @return User|null The user with the specified ID, or null if non-existent
    */
    function getUserByUserId(int $userId): ?User {
        try {
            $query = $this->database->prepare("SELECT * FROM users WHERE userId = ?");
            $query->bind_param("i", $userId);
            $query->execute();
            $usersWithUsername = User::usersFromQuery($query->get_result());
            if($usersWithUsername) {
                // There can only be one, return if it exists
                return $usersWithUsername[0];
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: could not get user ID $userId: $errorMessage");
        }

        $this->log("Could not find user with ID $userId");
        return null;
    }
    /**
        * Gets the user with the specified username.
        * @param string $username The username of the user to select
        * @return User|null The user with the specified username, or null if non-existent
    */
    function getUserByUserName(string $username): ?User {
       try {
            $query = $this->database->prepare("SELECT * FROM users WHERE username = ?");
            $query->bind_param("s", $username);
            $query->execute();
            $usersWithUsername = User::usersFromQuery($query->get_result());
            if($usersWithUsername) {
                // There can only be one, return if it exists
                return $usersWithUsername[0];
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: could not get user ID $username: $errorMessage");
        }

        $this->log("Could not find user with name $username");
        return null;
    }
    /**
     * Returns an array of all of the users in the database.
     * @return array An array conating all users
     */
    function getAllUsers(): array {
        try {
            $query = $this->database->query("SELECT * FROM users");
            return User::usersFromQuery($query);
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: could not get all users: $errorMessage");
        }
        return array();
    }

    function registerUser(User $user): Status {
        
        $this->log("Signing up a new user...");
        if($user->username == null) {
            $this->log("Failed, a username was not given");
            return new Status(false, "You must supply a username.");
        }
        if($user->passwordHash == null) {
            $this->log("Failed, a password was not given");
            return new Status(false, "you need a password.");
        }
        if($this->getUserByUserName($user->username)) {
            $this->log("Failed, username $user->username already taken");
            return new Status(false, "That username is already taken.");
        }
        if($user->joinDate) {
            $joinDateAsString = date_format($user->joinDate, "Y-m-d");
        } else {
            $this->log("ERROR: user ID $user->userId was created without a join date");
            $joinDateAsString = "2000-01-01";
        }
        $joinDateAsString = date_format($user->joinDate, "Y-m-d");
        try {
            $this->log("Running insert query on users...");
            $sql = "INSERT INTO users (username, passwordHash, joinDate, firstName, lastName, email, profilePictureUploadId) values (?, ?, ?, ?, ?, ?, ?)";
            $query = $this->database->prepare($sql);
            $query->bind_param("ssssssi", $user->username, $user->passwordHash, $joinDateAsString, $user->firstName, $user->lastName, $user->email, $user->profilePictureUploadId);
            $query->execute();
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: failed to execute user insert query: $errorMessage");
            return new Status(true, "Registration failed: $errorMessage.");
        }
        return new Status(true, "Registration successful");
    }

    function deleteUser($user): Status {

        $this->log("Deleteing user with ID $user->userId forever...");
        if($this->getUserByUserId($user->userId) == null) {
            $this->log("Failed, they don't exist");
            return new Status(false, "The user '$user->username' cannot be deleted, as they does not exist.");
        }
        try {
            $sql = "DELETE FROM users WHERE userId = ?";
            $query = $this->database->prepare($sql);
            $query->bind_param("i", $user->userId);
            $query->execute();
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: failed to execute user delete query: $errorMessage");
        }
        return new Status(true, "The user '$user->username' has been deleted.");
    }
    function updateUser(User $updatedUser): Status {

        $this->log("Getting ready to update user ID $updatedUser->userId...");
        if($this->getUserByUserId($updatedUser->userId) == null) {
            $this->log("Failed, they do not exist");
            return new Status(false, "That user does not seem to exist.");
        }
        try {
            $sql = "UPDATE users SET username = ?, passwordHash = ?, firstName = ?, lastName = ?, bio = ?, email = ?, profilePictureUploadId = ? WHERE userId = ?";
            $query = $this->database->prepare($sql);
            $query->bind_param("ssssssii", $updatedUser->username, $updatedUser->passwordHash, $updatedUser->firstName, $updatedUser->lastName, $updatedUser->bio, $updatedUser->email, $updatedUser->profilePictureUploadId, $updatedUser->userId);
            $query->execute();
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: failed to execute user update query: $errorMessage");
            return new Status(false, "Failed to update user information: $errorMessage.");
        }
        return new Status(true, "Account updated.");
    }
    
    function changePassword($userId, $oldPassword, $newPassword): Status {

        $passwordHash = encryptPassword($newPassword);
        try {
            $query = $this->database->prepare("UPDATE users SET passwordHash = ? WHERE userId = ?");
            $query->bind_param("si", $passwordHash, $userId);
            $query->execute();

            return new Status(true, "");
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->log("ERROR: could not change password for user ID $userId: $errorMessage");
        }
        return new Status(false, "");
    }

    // Forwarded for convenience
    function log(string $message) {
        $this->logging->log($message);
    }


}