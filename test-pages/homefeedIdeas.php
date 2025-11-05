<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "/var/www/html/idea-repository/templates/head.php" ?>
    <body>
        <?php include "/var/www/html/idea-repository/templates/header.php" ?>
        <main id="main" aria-labelledby="home">           
	
            <?php 		
		echo generateIdeasByCreatorId();
	    ?>
       </main>
        <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
    </body>
</html>

<?php
    function connectDatabase(){
        global $db_serverName,$db_userName,$db_passWord,$db_Name;
        $db_serverName = 'maria';
        $db_userName = 'cpwoodruff';
        $db_passWord = 'Char67';
        $db_Name = 'idea_repository';
        $connect_db = mysqli_connect($db_serverName, $db_userName, $db_passWord, $db_Name);
        return($connect_db);    
    }
?>

<?php
    function generateIdeasByCreatorId(){
	$db = connectDatabase();
	$sql = "SELECT * FROM ideas ORDER BY creationDate DESC LIMIT 10";
	$result = mysqli_query($db, $sql);

 	if (mysqli_num_rows($result) > 0) {
	    echo "<br><h3>Home Feed ~ Top 10 Newest Ideas</h3>";
		while($row = mysqli_fetch_assoc($result)) {
		    echo "<li class='ideaPeek sectionStyle'>IdeaId: " .$row['ideaId']. " &emsp;  Title:  " . $row['title']."</li><br>";
		
		}    	
        } else {
		echo "<h4>No results found</h4>";
        }                  
    }
?>
