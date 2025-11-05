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
	  <h3 style="text-align:center"> Idea Creation Form</h3> 
            <form action="create_ideas_process.php" method="POST" style="font-family: Roboto, Helvetica, sans-serif">
                <label>User Id: <input type="text" name="userId" style="border:2px solid black;margin-left:60px" placeholder="User Id" title="Enter User Id" pattern="[A-Za-z0-9 ]{1,30}" required></label><br>
                <label>Idea Title: <input type="text" name="title" style="border:2px solid black;margin-left:48px" title="Idea Title" pattern="[A-Za-z0-9 ]{1,30}" placeholder="Idea Title" required></label><br>
                <label>Creation Date: <input type="date" name="creationDate" style="border:2px solid black;margin-left:15px " title="Creation Date" required></label><br>
                <label>Modified Date: <input type="date" name="modifiedDate" style="border:2px solid black; margin-left:15px" title="Modified Date" required></label><br>
                <label>Idea Summary: </label><br><textarea name="summary" style="margin-left:120px; border:2px solid black;" placeholder="Summary of Idea" title="Summary of Idea" pattern="[A-Za-z0-9 ]" rows="15" cols="35" required></textarea><br><br>
                <label for="isPublic">Check the box for Public viewing: <input type="checkbox" name="isPublic" style="border:2px solid black"></label><br><br>
                    <!-- This is the submit button to submit the information in the form and the reset button to clear all information in the form-->
                <div><input type="submit" value="Submit"style="margin-left:100px"/><input type="reset" value="Reset" style="margin-left:20px;"/></div>
            </form> 		
	</div>

             </main>
      <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
  </body>
</html>
