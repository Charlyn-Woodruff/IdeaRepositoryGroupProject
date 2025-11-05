<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$user = $ideaRepo->getCurrentUser();
$mainContent = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // These lines declare the new variables with the sanitized data value from the function test_input
    $sanitizedPost = sanitizeAssocArray($_POST);
    $ideaId = $sanitizedPost["idea-id"];
    $creatorUserId = $sanitizedPost["user-id"];
    $title = $sanitizedPost["title"];
    $today = date_format(new DateTime(), "Y-m-d");
    $summary = $sanitizedPost["summary"];
    $content = $_POST["content"];
    if(array_key_exists("is-public", $_POST)) {
        $isPublic = intval($_POST["is-public"] == "on");
    } else {
        $isPublic = 0;
    }
    $query = $ideaRepo->database->prepare("UPDATE ideas SET title=?, modifiedDate=?, summary=?, isPublic=?, content=? WHERE ideaId=?");
    $query->bind_param("sssisi", $title, $today, $summary, $isPublic, $content, $ideaId);
    $query->execute();
    header("Location: http://cit.wvncc.edu/idea-repository/idea.php?id=$ideaId");
    exit();
} else {
    $idea = $ideaRepo->getIdeaById($_GET["id"]);
    if($idea) {
        if($ideaRepo->isLoggedIn()) {
            $user = $ideaRepo->getCurrentUser();
            if($user->userId == $idea->creatorUserId) {
                $mainContent .= "<div role=\"presentaion\" hidden>$idea->content</div>";
                $checkedString = $idea->isPublic ? "checked" : "";
                
		$mainContent .= "<main style=\"border-radius:15px; border:5px solid #284B63; padding:8px;width:80%; margin-left:8%;\">";
		$mainContent .= "<h3 style=\"margin-left:5%;\">Edit Idea Details</h3>";
	    	$mainContent .= "<div class=\"form-group\" style=\"width: 80%; margin-left:10%;\">";
                $mainContent .= "<form action=\"edit-idea.php\" method=\"POST\" style=\"font-family: Roboto, Helvetica, sans-serif\">";
                $mainContent .= "<input id=\"idea-content-field\" type=\"hidden\" name=\"content\" value=\"$idea->content\">";
                $mainContent .= "<input id=\"idea-id-field\" type=\"text\" name=\"idea-id\" hidden value=\"$idea->ideaId\">";
                $mainContent .= "<input id=\"idea-creator-user-id-field\" type=\"text\" name=\"user-id\" hidden value=\"$user->userId\">";
                $mainContent .= "<label for=\"idea-title-field\">Idea Title:</label><input id=\"idea-title-field\" type=\"text\" name=\"title\" title=\"Idea Title\" pattern=\"[A-Za-z0-9 ! ? , .]*\" placeholder=\"Idea Title\" style=\"border-radius:5px\" required value=\"$idea->title\">";
                $mainContent .= "<label for=\"idea-summary-field\">Idea Summary:</label><textarea id=\"idea-summary-field\" name=\"summary\" placeholder=\"Summary of Idea\" title=\"Summary of Idea\" pattern=\"[A-Za-z0-9 ! ? , .]*\" rows=\"15\" style=\"border-radius:5px\" required>$idea->summary</textarea>";
                $mainContent .= "<label for=\"idea-is-public-field\" style=\"margin-left:20%;\">Public?:</label><input id=\"idea-is-public-field\" type=\"checkbox\" name=\"is-public\" $checkedString>";
                // This is the submit button to submit the information in the form and the reset button to clear all information in the form
                $mainContent .= "<input type=\"submit\" value=\"Submit\" style=\"width:40%; margin-left:30%; border-radius:3px;background-color:#284B63;color:white\"/><br>";
                $mainContent .= $htmlGeneration->generateIdeaEditingZone();
                $mainContent .= "</form></div></main>";
            } else {
                $mainContent .= "<h2>Wrong Account</h2><p>This idea belongs to another user.</p><p><a href=\"/idea-repository/login.php\">Switch Accounts</a></p>";
            }
        } else {
            $mainContent .= "<h2>Login Required</h2><p>You need to be logged in to edit this idea.</p><p><a href=\"/idea-repository/login.php\">Sign in</a></p>";
        }
    } else {
        "<h2>Idea Not Found</h2><p>The idea you are looking for does not exist.</p>";
    }
}
echo $htmlGeneration->generateDocument("Edit Idea", $mainContent, null);