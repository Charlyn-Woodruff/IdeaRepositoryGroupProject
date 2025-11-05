<!-- Displays a (ugly) table of all users, for testing purposes -->
<?php
    session_start();
    require_once("/var/www/html/idea-repository/php/ideaRepo.php");
    $ideaRepo = new IdeaRepoApp();
    $ideaRepo->log("Page load: userlist-test.php");
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "/var/www/html/idea-repository/templates/head.php" ?>
    <body>
        <?php include "/var/www/html/idea-repository/templates/header.php" ?>
        <main id="main" aria-labelledby="admin-test">
            <h2 id="admin-test">Home</h2>
            <?php
                $ideaRepo = new IdeaRepoApp();
                //echo $ideaRepo->generateAllIdeasTable();
            ?>
        </main>
        <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
    </body>
</html>