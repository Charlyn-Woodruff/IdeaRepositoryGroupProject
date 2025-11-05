<?php
    session_start();
    require_once("/var/www/html/idea-repository/php/ideaRepo.php");
    $ideaRepo = new IdeaRepoApp();
    $ideaRepo->log("Page load: idea-item.php");
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "/var/www/html/idea-repository/templates/head.php" ?>
    <body>
        <?php include "/var/www/html/idea-repository/templates/header.php" ?>
        <main>
            <p>This form exists for testing purposes.</p>
            <form>
                <label for="idea-id-field">Idea ID</label><input id="idea-id-field" type="text" name="idea-id">
                <label for="item-index-field">Item index</label><input id="item-index-field" type="text" name="item-index">
                <label for="item-index-field">Item type</label>
                <select id="item-type-field" name="item-type">
                    <option>--Select type--</option>
                    <option value="heading">Heading</option>
                    <option value="paragraph">Paragraph</option>
                </select>
                <label for="content-field">Content</label><textarea id="content-field" name="content"></textarea>
                <label for="file-attachment-field">Attachment</label><input id="file-attachment-field" type="file" name="file-upload">
                <button type="submit">Add</button>
            </form>
        </main>
        <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
    </body>
</html>