<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$user = $ideaRepo->getCurrentUser();
$mainContent = "<p>Welcome to the Idea Repository.</p></section>";
$mainContent .= "<section class=\"ideas\">";
$mainContent .= "<link rel=\"alternate\" type=\"text/xml\" href=\"http://cit.wvncc.edu/idea-repository/rss-feed.php\">";
$ideas = $ideaRepo->getAllIdeas();
if($ideas) {
    foreach($ideas as $idea) {
        if($idea->isPublic) {
            $mainContent .= $htmlGeneration->generateIdeaPreview($idea->ideaId);
        }
    }
}
$mainContent .= "</section>";
echo $htmlGeneration->generateDocument("Home", $mainContent, null);