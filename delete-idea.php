<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$user = $ideaRepo->getCurrentUser();
$mainContent = "";

$db_serverName = 'maria';
$db_userName = 'cpwoodruff';
$db_passWord = 'Char67';
$db_Name = 'idea_repository';

function connectDatabase(){
    global $db_serverName, $db_userName, $db_passWord, $db_Name;
    $db = mysqli_connect($db_serverName, $db_userName, $db_passWord, $db_Name);
    return($db);
 }

if(array_key_exists("id", $_GET)) {
    $ideaId = intval($_GET["id"]);
    $idea = $ideaRepo->getIdeaById($ideaId);
    $user = $ideaRepo->users->getUserByUserId($idea->creatorUserId);

    //$profileId = $ideaRepo->getCurrentUser()->userId;

    if($ideaRepo->getCurrentUser()) {
        $isViewingOwnIdea = $ideaRepo->getCurrentUser()->userId == $idea->creatorUserId;
    } else {
        $isViewingOwnIdea = false;
    }
    if($isViewingOwnIdea) {
        if($_SERVER["REQUEST_METHOD"] == "POST") {

        $conn = connectDatabase();
    	$profileId = $ideaRepo->getCurrentUser()->userId;

        // This line catches the error if is not connected and prints the connection has failed
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
                
        // This line is sql delete statement by ideaId from the ideas tables
        $sql = "DELETE FROM ideas WHERE ideaId =$ideaId";

        // This if statement checks to see if the user idea has been deleted from the database
        if ($conn->query($sql) === TRUE) {
            $mainContent .= "<h3> User idea deleted successfully! </h3>";
          } else {
            $mainContent .= "<h3>Error deleting user idea</h3>";
          }

        // This line closes the server and database connection
        $conn->close();
	
		
        } else {
            $mainContent .= "<form method=\"POST\" action=\"http://cit.wvncc.edu/idea-repository/delete-idea.php?id=$ideaId\">";
            $mainContent .= "<p>Click here if you are sure you <br> would like to delete this idea</p><br>";
	    $mainContent .= "<button style='width:120px;margin-left:25px;'>Delete This Idea</button>";
            $mainContent .= "</form>"; 
        }
    } else {
        $mainContent .= "<p>You cannot edit this idea. Are you logged in to the right account?</p>";
    }
}


echo $htmlGeneration->generateDocument("Delete Idea ?", $mainContent, null);