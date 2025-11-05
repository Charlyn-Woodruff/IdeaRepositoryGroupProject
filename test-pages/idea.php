<?php
    session_start();
    require_once("/var/www/html/idea-repository/php/ideaRepo.php");
    $ideaRepo = new IdeaRepoApp();
    $ideaRepo->log("Page load: user.php");
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "/var/www/html/idea-repository/templates/head.php" ?>
    <body>
        <?php include "/var/www/html/idea-repository/templates/header.php" ?>
        <main>
            <h2>Idea: France isn't real</h2>
        </main>
        <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
    </body>
</html>