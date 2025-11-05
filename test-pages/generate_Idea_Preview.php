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
			$ideaId = '3';
			//$idea = 3; 
			echo generateIdeaPreview($ideaId);
			//echo generateIdeaPreview($ideaRepo->getIdeaById($ideaId));
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
    function generateIdeaPreview($ideaId){
  
        $db = connectDatabase();
        $sql = "SELECT * FROM ideas INNER JOIN users ON ideas.creatorUserId = users.userId WHERE ideas.ideaId = '$ideaId' ";
        $result = mysqli_query($db, $sql);


        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
		
		$sectionHtml ="<section class='idea-preview'><h3><a href='http://cit.wvncc.edu/idea-repository/idea.php?id=$ideaId'>Idea Preview</a></h3><h3>".$row['title']."</h3><p>Unveiled by <a href='http://cit.wvncc.edu/idea-repository/profile.php?id=1'>". $row["username"]."</a> on " . $row['creationDate']." <p>Summary: " . $row["summary"]."</p></section>";
		
		return($sectionHtml);
              }
        } else {
            echo "<h4>No results found</h4>";
		$db->close();
        }
    }
?>
