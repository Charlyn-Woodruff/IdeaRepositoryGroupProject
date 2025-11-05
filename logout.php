<!-- Visiting this page will instantly log you out. -->
<?php
require_once("/var/www/html/idea-repository/php/ideaRepo.php");
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$ideaRepo->log("Page load: logout.php");
$html = new htmlGeneration($ideaRepo);
$ideaRepo->logout();
// Reload the page
Header('Location: http://cit.wvncc.edu/idea-repository');