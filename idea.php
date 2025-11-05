<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$user = $ideaRepo->getCurrentUser();
$mainContent = "";
if(array_key_exists("id", $_GET)) {
    $ideaId = intval($_GET["id"]);
    $idea = $ideaRepo->getIdeaById($ideaId);
    $user = $ideaRepo->users->getUserByUserId($idea->creatorUserId);
    if($ideaRepo->getCurrentUser()) {
        $isViewingOwnIdea = $ideaRepo->getCurrentUser()->userId == $idea->creatorUserId;
    } else {
        $isViewingOwnIdea = false;
    }
    if($idea->isPublic || $isViewingOwnIdea) {
        //$mainContent .= $htmlGeneration->generateIdeaEditingZone();
        $mainContent .= $htmlGeneration->generateIdea($idea, $isViewingOwnIdea);
    } else {
        $mainContent .= "<h2>Coming Soon</h2>";
        $mainContent .= "<p>This idea hasn't been made public yet.</p>";
    }
}
echo $htmlGeneration->generateDocument("Idea:", $mainContent, null);