<?php
/*
	Student name: Charlyn Woodruff
	File document: upload.php
	Date: Nov 19, 2024
	CIT 253 Web Application PHP
*/
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");
$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
$content = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$ideaRepo->log("Getting a file upload form..");
	$pageTitle = "File Upload Status";
	$filename = $_FILES["file-to-upload"]["name"];
	$fileId = $ideaRepo->uploadFile($_POST, $_FILES, "file-to-upload");
	if($fileId) {
		$content .= $htmlGeneration->fileUploadToHtml($fileId);
	} else {
		$content .= "<p>The file could not be uploaded.</p>";
	}
	if(array_key_exists("is-trix-upload", $_POST)) {
		$newFilename = $ideaRepo->getFilenameOfUpload($fileId);
		echo "http://cit.wvncc.edu/idea-repository/uploads/$newFilename";
		exit();
	}
} else {
	$pageTitle = "Upload File";
	$content .= "<form action=\"upload.php\" method=\"POST\" enctype=\"multipart/form-data\">";
	$content .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"25000000\">";
	$content .= "<label for=\"file-field\">File</label><input id=\"file-field\" type=\"file\" name=\"file-to-upload\" required>";
	$content .= "<label for=\"file-description-field\">Short description</label><input id=\"file-description-field\" type=\"text\" name=\"file-description\" title=\"A short description of the file's contents\" required>";
	$content .= "<input type=\"submit\" value=\"Upload\" name=\"submit\">";
	$content .= "</form>";
}
echo $htmlGeneration->generateDocument($pageTitle, $content, null);