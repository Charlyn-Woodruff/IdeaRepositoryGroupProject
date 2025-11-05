<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$mainContent = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //$sanitizedPost = sanitizeAssocArray($sanitizedPost);

	function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
                }


    $user = $ideaRepo->users->getUserByUserId(($_POST["user-id"]));
    $user->username = test_input($_POST["username"]);
    //$user->password = test_input($_POST["password"]);
    $user->firstName = test_input($_POST["given-name"]);
    $user->lastName = test_input($_POST["family-name"]);
    $user->email = test_input($_POST["email"]);

    if(array_key_exists("profile-picture-upload", $_FILES)) {
        if($_FILES["profile-picture-upload"]["type"]) {
            // Only update if they attached a file.
            // Otherwise they would need to re-upload thier PFP for every account change
            $ideaRepo->log("User is adding a profile picture");
            $user->profilePictureUploadId = $ideaRepo->uploadFile($_POST, $_FILES, "profile-picture-upload");
        }
	$mainContent .= "<h3>Your user account has been updated!</h3>";
    }
    $user->bio = test_input($_POST["bio"]);
    $ideaRepo->users->updateUser($user);
} else {
    if($ideaRepo->getCurrentUser()) {
        $mainContent .= generateUserForm(UserFormPurpose::EDIT, $ideaRepo->getCurrentUser());
    } else {
        // The user must login first before editing
        // Send them away
        Header('Location: http://cit.wvncc.edu/idea-repository/login.php');
    }
}
echo $htmlGeneration->generateDocument("Edit Account", $mainContent, null);