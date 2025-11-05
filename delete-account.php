<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$mainContent = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ideaRepo->log("Getting an account deletion request via POST...");
    $ideaRepo->logout();
    $loginAttempt = $ideaRepo->login(sanitizeString($_POST["username"]), sanitizeString($_POST["current-password"]));
    $message = $loginAttempt->message;
    if($loginAttempt->isSuccess) {
        $deleteAttempt = $ideaRepo->users->deleteUser($ideaRepo->getCurrentUser());
        if($deleteAttempt->isSuccess) {
            $ideaRepo->log("Account deletion worked");
		session_unset();
   		session_destroy();
	        echo "<script type='text/javascript'>window.location.href ='http://cit.wvncc.edu/idea-repository/index.php'</script>";
        }
    } else {
        echo generateUserForm(UserFormPurpose::DELETE, $ideaRepo->getCurrentUser());
        $mainContent .= "<p>$message</p>";
    }
    
} else {
    $mainContent .= generateUserForm(UserFormPurpose::DELETE, $ideaRepo->getCurrentUser());
}
echo $htmlGeneration->generateDocument("Delete Account", $mainContent, null);