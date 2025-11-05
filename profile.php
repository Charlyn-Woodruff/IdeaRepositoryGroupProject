<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$user = $ideaRepo->getCurrentUser();
$mainContent = "";
$asideContent = "";
if(array_key_exists("id", $_GET)) {
    $user = $ideaRepo->users->getUserByUserId(userId: intval($_GET["id"]));
    if($user) {
        if($ideaRepo->getCurrentUser()) {
            $isViewingOwnProfile = $ideaRepo->getCurrentUser()->userId == $user->userId;
        } else {
            $isViewingOwnProfile = false;
        }
        if($isViewingOwnProfile) {
            $mainContent .= "<br><nav aria=label=\"Account Actions\">";
            $mainContent .= "<p><a href='/idea-repository/delete-account.php'>Delete Account</a></p>";
            $mainContent .= "<p><a href='/idea-repository/edit-account.php'>Edit Account</a></p>";
            $mainContent .= "<p><a href='/idea-repository/change-password.php'>Change Password</a></p>";
            $mainContent .= "</nav>";
        }
        $mainContent .= "<section id='profileBanner'>";
        $fullname = array();
        if($user->firstName) array_push($fullname, $user->firstName);
        if($user->lastName) array_push($fullname, $user->lastName);
        if($fullname) {
            // Who the heck wrote the function names for PHP?
            // They're even more inconsitent than JavaScript, and that is really saying something. -Sean
            $fullNameString = implode(" ", $fullname);
            $mainContent .= "<br><p class='profileContent' id='profileName'>$fullNameString</p>";
        }
        $mainContent .= "<p class='profileContent' id='profileUsername'>$user->username</p>";
        if($user->profilePictureUploadId) {
            $mainContent .= $htmlGeneration->fileUploadToHtml($user->profilePictureUploadId);
        }
        if($user->email) {
            $mainContent .= "<p class='profileContent'><a href=\"mailto:$user->email\">$user->email</a></p>";
        }
        $joinDate = date_format($user->joinDate, "d M, Y");
        $mainContent .= "<p class='profileContent' id='profileJoined'>Joined $joinDate</p>";
        $mainContent .= "</section>";
        if($user->bio) {
            $mainContent .= "<section id='profileBio' aria-labelledby=\"bio\">";
            $mainContent .= "<h3 id=\"bio\">About Me</h3>";
            $mainContent .= "<p>$user->bio</p>";
            $mainContent .= "</section>";
        }
        $asideContent .= "<section aria-labelledby=\"profile-ideas\">";
        $asideContent .= "<h3 id=\"profile-ideas\">Ideas</h3><section class=\"ideas\">";
        if($isViewingOwnProfile) {
            $asideContent .= "<nav aria=label=\"Idea Actions\">";
            $asideContent .= "<p><a href=\"/idea-repository/epiphany.php\">Create new</a></p>";
            $asideContent .= "</nav>";
        }
        $ideas = $ideaRepo->getIdeasFromUser($user->userId);
        if($ideaRepo->getCurrentUser()) {
            $userId = $ideaRepo->getCurrentUser()->userId;
        } else {
            $userId = null;
        }
        if($ideas) {
            foreach($ideas as $idea) {
                if($idea->isPublic || $isViewingOwnProfile) {
                    $asideContent .= $htmlGeneration->generateIdeaPreview($idea->ideaId);
                }
            }
        } else {
            $mainContent .= "</section>";
            $asideContent .= "<p>This person hasn't posted any ideas yet.</p>";
        }
        $mainContent .= "</section>";
    } else {
        $mainContent .= "<p>User not found.</p>";
    }
    
} else {
    $mainContent .= "<p>No user specified.</p>";
}
echo $htmlGeneration->generateDocument("Profile", $mainContent, $asideContent);