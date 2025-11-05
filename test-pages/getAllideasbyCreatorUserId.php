<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <?php include "/var/www/html/idea-repository/templates/head.php" ?>
    
        <?php include "/var/www/html/idea-repository/templates/topInclude.php" ?>
        <div id="main" aria-labelledby="home">
             <div class="container mb-5 main p-5">            

            	<?php 
		$creatorUserId = 1;
		echo allIdeasByUserId($creatorUserId);			
		?>

	   </div>
	</div>
        <?php include "/var/www/html/idea-repository/templates/bottomInclude.php" ?>
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
    function allIdeasByUserId($creatorUserId){
	$connect = connectDatabase();
   
   		if (!$connect) {
        	    die("Connection failed: " . $connect->connect_error);
     		}

    	 	$query = "SELECT * FROM ideas INNER JOIN users ON ideas.creatorUserId = users.userId WHERE creatorUserId = '$creatorUserId' ";
    		$result = mysqli_query($connect,$query);
		


    		if (mysqli_num_rows($result) > 0){         	
	    	   echo "<h1>Ideas by User </h1>";
            	   echo "<table class='table' style='border:3px solid black; border-radius:15px;height:600px;border-collapse: collapse; width:110%;padding:10px;text-align:center'>";
            	   echo "<div class='table responsive'>";
            	   echo "<th style='border-bottom:3px solid black'>Idea Id</th>";
            	   echo "<th style='border-bottom:3px solid black'>Creator User Id</th>";
	   	   echo "<th style='border-bottom:3px solid black'>Title</th>";
            	   echo "<th style='border-bottom:3px solid black' >Summary</th>";
	    	   echo "<th style='border-bottom:3px solid black'>User Name</th>";
            	   echo "<th style='border-bottom:3px solid black' >Creation Date</th>";
            	   echo "<th style='border-bottom:3px solid black'>Modified Date</th>";
            	   echo "<th style='border-bottom:3px solid black'>Public Post</th></thead>";
      
       		while($row = mysqli_fetch_assoc($result)) {
           	    echo "<tr style='border:3px solid black'><td>".$row['ideaId']."</td><td>".$row['creatorUserId']."</td><td> ". $row['title']."</td><td>". $row['summary']."</td><td>". $row['username']."</td><td> ". $row['creationDate']."</td><td> ". $row['modifiedDate']."</td><td> ". $row['isPublic']."</td></tr>";
        	    }
    		} else {
        	    echo "<h2>No results found ~ User id does not exist</h2>";
    		}

	echo "</div></table>";
    	mysqli_close($connect);
    }		
?>

