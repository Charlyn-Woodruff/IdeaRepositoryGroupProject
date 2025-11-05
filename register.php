<!-- Self-processing registration form. -->
<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ideaRepo->log("Getting a new registration form via POST...");
    $sanitizedPost = sanitizeAssocArray($_POST);
    $user = new User (
        null,
        $sanitizedPost["username"],
        encryptPassword($sanitizedPost["new-password"]),
        new DateTime(),
        $sanitizedPost["given-name"],
        $sanitizedPost["family-name"],
        null,
        null,
        $sanitizedPost["email"],
    );
    if(array_key_exists("profile-picture-upload", $_FILES)) {
        if($_FILES["profile-picture-upload"]["type"]) {
            // Only update if they attached a file.
            // Otherwise they would need to re-upload thier PFP for every account change
            $ideaRepo->log("User is adding a profile picture");
            $user->profilePictureUploadId = $ideaRepo->uploadFile($_POST, $_FILES, "profile-picture-upload");
        }
    }
    $status = $ideaRepo->users->registerUser($user);
    echo $htmlGeneration->generateDocument("Register", $status->message, null);
} else {
    require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
    echo $htmlGeneration->generateDocument("Register", generateUserForm(UserFormPurpose::REGISTER, null), null);
    $ideaRepo->log("registration form loaded");
}