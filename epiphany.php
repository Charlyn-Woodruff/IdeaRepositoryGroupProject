<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$user = $ideaRepo->getCurrentUser();
$mainContent = "";
$mainContent .= "<section>";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // These lines declare the new variables with the sanitized data value from the function test_input
        //$userName = test_input($_POST["username"]); 
        $sanitizedPost = sanitizeAssocArray($_POST);
	$creatorUserId = $sanitizedPost["user-id"];
        $title = $sanitizedPost["title"];
        $today = date_format(new DateTime(), "Y-m-d");
        $summary = $sanitizedPost["summary"];
        $content = $sanitizedPost["content"];
        if(array_key_exists("is-public", $_POST)) {
            $isPublic = intval($_POST["is-public"] == "on");
        } else {
            $isPublic = 0;
        }
        
        $visibilityMessage = $isPublic ? "Congrats! Your post is now Public.": "Your post is set to Private.";

        $query = $ideaRepo->database->prepare("INSERT INTO ideas(creatorUserId, title, creationDate, modifiedDate, summary, isPublic, content) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("issssis", $creatorUserId, $title, $today, $today, $summary, $isPublic, $content);
        $query->execute();
        $mainContent .= $_POST["content"];
    } else {
        if($ideaRepo->isLoggedIn()) {
            $user = $ideaRepo->getCurrentUser();
	    
	    $mainContent .= "<main style=\"border-radius:15px; border:5px solid #284B63; padding:8px;width:80%; margin-left:8%;\">";
	    $mainContent .= "<div class=\"form-group\" style=\"width: 80%; margin-left:10%;\">";
            $mainContent .= "<form action=\"epiphany.php\" method=\"POST\" style=\"font-family: Roboto, Helvetica, sans-serif\">";
            $mainContent .= "<input id=\"idea-content-field\" type=\"hidden\" name=\"content\" >";
            $mainContent .= "<input type=\"text\" name=\"user-id\" hidden value=\"$user->userId\">";
            $mainContent .= "<label>Idea Title:</label><input type=\"text\" name=\"title\" title=\"Idea Title\" pattern=\"[A-Za-z0-9 ! ? , .]*\" placeholder=\" Idea Title\" style=\"border-radius:5px\" required>";
            $mainContent .= "<label>Idea Summary:</label><textarea name=\"summary\" placeholder=\" Summary of Idea\" title=\"Summary of Idea\" pattern=\"[A-Za-z0-9 ! ? , .]*\" rows=\"15\" style=\"border-radius:5px;border:1px solid black\" required></textarea>";
            $mainContent .= "<label for=\"is-public-field\" style=\"margin-left:20%;\">Public?:</label><input id=\"is-public-field\" type=\"checkbox\" name=\"is-public\">";
            // This is the submit button to submit the information in the form and the reset button to clear all information in the form
            $mainContent .= "<input type=\"submit\" value=\"Submit\" style=\"width:40%; margin-left:30%; border-radius:3px;background-color:#284B63;color:white\"/><input type=\"reset\" value=\"Reset\" style=\"width:40%; margin-left:30%;border-radius:3px;background-color:#284B63;color:white\"/><br>";
            $mainContent .= $htmlGeneration->generateIdeaEditingZone();
            $mainContent .= "</form>";
        } else {
            $mainContent .= "<h2>Login Required</h2><p>You need an account to to create ideas.</p><p><a href=\"/idea-repository/login.php\">Sign in</a></p><p><a href=\"/idea-repository/register.php\">Sign up</a></p>";
        }
    }
    $mainContent .= "</section>";
echo $htmlGeneration->generateDocument("New Idea", $mainContent, null);