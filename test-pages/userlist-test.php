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
                //echo $ideaRepo->generateAllUsersTable();
            ?>
        </main>
        <?php include "/var/www/html/idea-repository/templates/footer.php" ?>
    </body>
</html>

<!--function generateAllUsersTable(): string {
        $htmlTable = '<figure class="table-scrolling"><table><caption>All Users</caption><thead><tr><th>User ID</th><th>Username</th><th>Password hash</th><th>Join date</th><th>First name</th><th>Last name</th><th>PFP upload</th><th>Bio</th><th>Email</th></tr></thead><tbody>';
        foreach($this->ideaRepo->getAllUsers() as $user) {
            $htmlTable .= "<tr><td><a href=\"http://cit.wvncc.edu/idea-repository/profile.php?id=$user->userId\">$user->userId</a></td><td>$user->username</td><td>$user->passwordHash</td><td>".date_format($user->joinDate, "D, d M Y")."</td><td>$user->firstName</td><td>$user->lastName</td><td>$user->profilePictureUploadId</td><td>$user->bio</td><td><a href=".'"'."mailto:$user->email".'">'."$user->email</a></td></tr>";
        }
        $htmlTable .= "</tbody></table></figure>";
        return $htmlTable;
    }
    function generateAllIdeasTable(): string {
        $htmlTable = '<figure class="table-scrolling"><table><caption>All Ideas</caption><thead><tr><th>Idea ID</th><th>Creator ID</th><th>Title</th><th>Summary</th><th>Creation date</th><th>Modified date</th><th>Public</th></tr></thead><tbody>';
        foreach($this->ideaRepo->getAllIdeas() as $idea) {
            $htmlTable .= "<tr><td><a href=\"http://cit.wvncc.edu/idea-repository/idea.php?id=$idea->ideaId\">$idea->ideaId</a></td><td><a href=\"http://cit.wvncc.edu/idea-repository/profile.php?id=$idea->creatorUserId\">$idea->creatorUserId</a></td><td>$idea->title</td><td>$idea->summary</td><td>".date_format($idea->creationDate, "D, d M Y")."</td><td>".date_format($idea->modifiedDate, "D, d M Y")."</td><td>$idea->isPublic</td></tr>";
        }
        $htmlTable .= "</tbody></table></figure>";
        return $htmlTable;
    }