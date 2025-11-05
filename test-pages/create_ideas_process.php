<?php
    session_start();
    require_once("/var/www/html/idea-repository/php/ideaRepo.php");
    $ideaRepo = new IdeaRepoApp();
    $ideaRepo->log("Page load: index.php");
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "/var/www/html/idea-repository/templates/head.php" ?>
    <body>
        <?php include "/var/www/html/idea-repository/templates/header.php" ?>

    <main id="main">
	<div style="margin:50px;">

	  <?php
	     insertIdea();
	   ?>		

	</div>

     </main>
      <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
  </body>
</html>

<?php
function insertIdea(){
    $db_serverName = 'maria';
    $db_userName = 'cpwoodruff';
    $db_passWord = 'Char67';
    $db_Name = 'idea_repository';

    //This line creates the server database connection to the MySQL using MySQLi with a username, password and the existing database name
    $conn = new mysqli($db_serverName, $db_userName, $db_passWord, $db_Name);

    //This line checks to see it the database connection is connected if it is not it will exit and send an error message
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }
  
     // This line declares the variables for each form input as an empty string
     $creatorUserId = $title = $creationDate = $modifiedDate = $summary = $isPublic = " ";

     // This is the php function which will test the data input and returns sanitized data
     function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
         }

     // This line checks the server request is equal to post
     if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // These lines declare the new variables with the sanitized data value from the function test_input
        //$userName = test_input($_POST["username"]); 
	
	$creatorUserId = test_input($_POST["userId"]);
        $title = test_input($_POST["title"]);
        $creationDate = test_input($_POST["creationDate"]);
        $modifiedDate = test_input($_POST["modifiedDate"]);
        $summary = test_input($_POST["summary"]);
        $isPublic = $_POST["isPublic"] ? "Congrats! You post is now Public.": "You post is set to Private.";

        //$userId = "SELECT userId FROM users WHERE username ='$userName'";
        
        $sql= "INSERT INTO ideas(creatorUserId,title,creationDate,modifiedDate,summary,isPublic) VALUES('$creatorUserId', '$title','$creationDate','$modifiedDate','summary', '0')";
        if (mysqli_query($conn, $sql)){
            echo "<h4> User idea created successfully! </h4>";
	    echo "$isPublic";
            } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);   
            }
        }             
    mysqli_close($conn);
    }
?> 
