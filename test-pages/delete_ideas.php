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
        <?php
        $db_serverName = 'maria';
        $db_userName = 'cpwoodruff';
        $db_passWord = 'Char67';
        $db_Name = 'idea_repository';
    
        //This line creates the server database connection to the MySQL using MySQLi with a username, password and the existing database name
        $conn = new mysqli($db_serverName, $db_userName, $db_passWord, $db_Name);
    

        // This line catches the error if is not connected and prints the connection has failed
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // This line print to the webpage if the connection is successful
        echo "<h3> Database Connection Successful! </h3>";
        
        // This line is sql delete statement by ideaId from the ideas tables
        $sql = "DELETE FROM ideas WHERE ideaId ='4'";

        // This if statement checks to see if the user idea has been deleted from the database
        if ($conn->query($sql) === TRUE) {
            echo "<h3> User idea deleted successfully! </h3>";
          } else {
            echo "Error deleting user idea: ". $conn->error;
          }

        // This line closes the server and database connection
        $conn->close();
        ?>
      </main>
      <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
  </body>
</html>