<!-- Self-processing login form. -->
<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ideaRepo->log("Someone is submitting a login form...");
    $sanitizedPost = sanitizeAssocArray($_POST);
    $loginAttempt = $ideaRepo->login($sanitizedPost["username"], $sanitizedPost["current-password"]);
    $message = $loginAttempt->message;
    if($loginAttempt->isSuccess) {
        $ideaRepo->log("Login form worked, redirecting...");
        // Redirect to home
        Header('Location: http://cit.wvncc.edu/idea-repository');
    } else {
        $ideaRepo->log("Login failed: $message");
        echo $htmlGeneration->generateDocument("Login", generateUserForm(UserFormPurpose::LOGIN, null), null);
    }
} else {
    echo $htmlGeneration->generateDocument("Login", generateUserForm(UserFormPurpose::LOGIN, null), null);
}