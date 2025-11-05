<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$mainContent = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ideaRepo->log("Getting an password change request via POST...");
    $ideaRepo->logout();
    $sanitizedPost = sanitizeAssocArray($_POST);
    $loginAttempt = $ideaRepo->login(($sanitizedPost["username"]), ($sanitizedPost["current-password"]));
    $message = $loginAttempt->message;
    if($loginAttempt->isSuccess) {
        $changeAttempt = $ideaRepo->users->changePassword($ideaRepo->getCurrentUser()->userId, ($sanitizedPost["current-password"]), ($sanitizedPost["new-password"]));
        if($changeAttempt->isSuccess) {
            $ideaRepo->log("Password change worked");
            $mainContent .= "<p>Your password has been changed.</p>";
        }
    } else {
        $mainContent .= generateUserForm(UserFormPurpose::CHANGE_PASSWORD, $ideaRepo->getCurrentUser());
        $mainContent .= "<p>$message</p>";
    }
    
} else {
    $mainContent .= generateUserForm(UserFormPurpose::CHANGE_PASSWORD, $ideaRepo->getCurrentUser());
}
echo $htmlGeneration->generateDocument("Change Password", $mainContent, null);