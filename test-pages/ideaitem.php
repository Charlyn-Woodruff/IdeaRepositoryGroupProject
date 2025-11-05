
<?php
    session_start();
    require_once("/var/www/html/idea-repository/php/idea.php");
    $ideaitem = new Idea();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "/var/www/html/idea-repository/templates/head.php" ?>
    <body>
        <?php include "/var/www/html/idea-repository/templates/header.php" ?>
        <main id="main">
            <h2>Idea Item test</h2>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    $idea = new Idea (
                        null,
                        $_POST["ideaId"],
                        $_POST["itemIndex"],
                        $_POST["itemType"],
                        $_POST["content"],
                        null,
                        null,
                        null,

                    );
                    
                } 
                ?>
        </main>
        <?php include "/var/www/html/idea-repository/templates/footer.php"?>
    </body>
</html>
