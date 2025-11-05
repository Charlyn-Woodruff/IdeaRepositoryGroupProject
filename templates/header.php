<header>
    <h1>The Idea Repository</h1>
    <nav aria-label="Site navigation">
        <ul>
            <li><a href="/idea-repository/index.php">Home</a></li>
            <?php
                require_once("/var/www/html/idea-repository/php/ideaRepo.php");
                $ideaRepo = new IdeaRepoApp();                
                if($ideaRepo->isLoggedIn()) {
                    $user = $ideaRepo->getCurrentUser();
                    echo "<li><a href='/idea-repository/epiphany.php'>New Idea</a></li>";
                    echo "<li><a href='/idea-repository/profile.php?id=$user->userId'>My Profile</a></li>";
                    echo "<li><a href='/idea-repository/logout.php'>Log Out</a></li>";
                } else {
                    echo "<li><a href=\"/idea-repository/login.php\">Login</a></li>";
                    echo "<li><a href=\"/idea-repository/register.php\">Register</a></li>";
                }
            ?>
        </ul>
    </nav>
</header>