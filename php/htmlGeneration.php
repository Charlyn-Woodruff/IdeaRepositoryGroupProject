<?php

// Code for dynamically generating HTML code such as tables and forms.
// Created by Sean on 10-23-24
require_once("/var/www/html/idea-repository/php/ideaRepo.php");
require_once("/var/www/html/idea-repository/php/user.php");
require_once("/var/www/html/idea-repository/php/idea.php");

// Maps file types into extensions.
// Taken from https://stackoverflow.com/questions/16511021/convert-mime-type-to-file-extension-php#53662733
function mime2ext($mime) {
    $mime_map = [
        'video/3gpp2'                                                               => '3g2',
        'video/3gp'                                                                 => '3gp',
        'video/3gpp'                                                                => '3gp',
        'application/x-compressed'                                                  => '7zip',
        'audio/x-acc'                                                               => 'aac',
        'audio/ac3'                                                                 => 'ac3',
        'application/postscript'                                                    => 'ai',
        'audio/x-aiff'                                                              => 'aif',
        'audio/aiff'                                                                => 'aif',
        'audio/x-au'                                                                => 'au',
        'video/x-msvideo'                                                           => 'avi',
        'video/msvideo'                                                             => 'avi',
        'video/avi'                                                                 => 'avi',
        'application/x-troff-msvideo'                                               => 'avi',
        'application/macbinary'                                                     => 'bin',
        'application/mac-binary'                                                    => 'bin',
        'application/x-binary'                                                      => 'bin',
        'application/x-macbinary'                                                   => 'bin',
        'image/bmp'                                                                 => 'bmp',
        'image/x-bmp'                                                               => 'bmp',
        'image/x-bitmap'                                                            => 'bmp',
        'image/x-xbitmap'                                                           => 'bmp',
        'image/x-win-bitmap'                                                        => 'bmp',
        'image/x-windows-bmp'                                                       => 'bmp',
        'image/ms-bmp'                                                              => 'bmp',
        'image/x-ms-bmp'                                                            => 'bmp',
        'application/bmp'                                                           => 'bmp',
        'application/x-bmp'                                                         => 'bmp',
        'application/x-win-bitmap'                                                  => 'bmp',
        'application/cdr'                                                           => 'cdr',
        'application/coreldraw'                                                     => 'cdr',
        'application/x-cdr'                                                         => 'cdr',
        'application/x-coreldraw'                                                   => 'cdr',
        'image/cdr'                                                                 => 'cdr',
        'image/x-cdr'                                                               => 'cdr',
        'zz-application/zz-winassoc-cdr'                                            => 'cdr',
        'application/mac-compactpro'                                                => 'cpt',
        'application/pkix-crl'                                                      => 'crl',
        'application/pkcs-crl'                                                      => 'crl',
        'application/x-x509-ca-cert'                                                => 'crt',
        'application/pkix-cert'                                                     => 'crt',
        'text/css'                                                                  => 'css',
        'text/x-comma-separated-values'                                             => 'csv',
        'text/comma-separated-values'                                               => 'csv',
        'application/vnd.msexcel'                                                   => 'csv',
        'application/x-director'                                                    => 'dcr',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/x-dvi'                                                         => 'dvi',
        'message/rfc822'                                                            => 'eml',
        'application/x-msdownload'                                                  => 'exe',
        'video/x-f4v'                                                               => 'f4v',
        'audio/x-flac'                                                              => 'flac',
        'video/x-flv'                                                               => 'flv',
        'image/gif'                                                                 => 'gif',
        'application/gpg-keys'                                                      => 'gpg',
        'application/x-gtar'                                                        => 'gtar',
        'application/x-gzip'                                                        => 'gzip',
        'application/mac-binhex40'                                                  => 'hqx',
        'application/mac-binhex'                                                    => 'hqx',
        'application/x-binhex40'                                                    => 'hqx',
        'application/x-mac-binhex40'                                                => 'hqx',
        'text/html'                                                                 => 'html',
        'image/x-icon'                                                              => 'ico',
        'image/x-ico'                                                               => 'ico',
        'image/vnd.microsoft.icon'                                                  => 'ico',
        'text/calendar'                                                             => 'ics',
        'application/java-archive'                                                  => 'jar',
        'application/x-java-application'                                            => 'jar',
        'application/x-jar'                                                         => 'jar',
        'image/jp2'                                                                 => 'jp2',
        'video/mj2'                                                                 => 'jp2',
        'image/jpx'                                                                 => 'jp2',
        'image/jpm'                                                                 => 'jp2',
        'image/jpeg'                                                                => 'jpeg',
        'image/pjpeg'                                                               => 'jpeg',
        'application/x-javascript'                                                  => 'js',
        'application/json'                                                          => 'json',
        'text/json'                                                                 => 'json',
        'application/vnd.google-earth.kml+xml'                                      => 'kml',
        'application/vnd.google-earth.kmz'                                          => 'kmz',
        'text/x-log'                                                                => 'log',
        'audio/x-m4a'                                                               => 'm4a',
        'audio/mp4'                                                                 => 'm4a',
        'application/vnd.mpegurl'                                                   => 'm4u',
        'audio/midi'                                                                => 'mid',
        'application/vnd.mif'                                                       => 'mif',
        'video/quicktime'                                                           => 'mov',
        'video/x-sgi-movie'                                                         => 'movie',
        'audio/mpeg'                                                                => 'mp3',
        'audio/mpg'                                                                 => 'mp3',
        'audio/mpeg3'                                                               => 'mp3',
        'audio/mp3'                                                                 => 'mp3',
        'video/mp4'                                                                 => 'mp4',
        'video/mpeg'                                                                => 'mpeg',
        'application/oda'                                                           => 'oda',
        'audio/ogg'                                                                 => 'ogg',
        'video/ogg'                                                                 => 'ogg',
        'application/ogg'                                                           => 'ogg',
        'font/otf'                                                                  => 'otf',
        'application/x-pkcs10'                                                      => 'p10',
        'application/pkcs10'                                                        => 'p10',
        'application/x-pkcs12'                                                      => 'p12',
        'application/x-pkcs7-signature'                                             => 'p7a',
        'application/pkcs7-mime'                                                    => 'p7c',
        'application/x-pkcs7-mime'                                                  => 'p7c',
        'application/x-pkcs7-certreqresp'                                           => 'p7r',
        'application/pkcs7-signature'                                               => 'p7s',
        'application/pdf'                                                           => 'pdf',
        'application/octet-stream'                                                  => 'pdf',
        'application/x-x509-user-cert'                                              => 'pem',
        'application/x-pem-file'                                                    => 'pem',
        'application/pgp'                                                           => 'pgp',
        'application/x-httpd-php'                                                   => 'php',
        'application/php'                                                           => 'php',
        'application/x-php'                                                         => 'php',
        'text/php'                                                                  => 'php',
        'text/x-php'                                                                => 'php',
        'application/x-httpd-php-source'                                            => 'php',
        'image/png'                                                                 => 'png',
        'image/x-png'                                                               => 'png',
        'application/powerpoint'                                                    => 'ppt',
        'application/vnd.ms-powerpoint'                                             => 'ppt',
        'application/vnd.ms-office'                                                 => 'ppt',
        'application/msword'                                                        => 'doc',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/x-photoshop'                                                   => 'psd',
        'image/vnd.adobe.photoshop'                                                 => 'psd',
        'audio/x-realaudio'                                                         => 'ra',
        'audio/x-pn-realaudio'                                                      => 'ram',
        'application/x-rar'                                                         => 'rar',
        'application/rar'                                                           => 'rar',
        'application/x-rar-compressed'                                              => 'rar',
        'audio/x-pn-realaudio-plugin'                                               => 'rpm',
        'application/x-pkcs7'                                                       => 'rsa',
        'text/rtf'                                                                  => 'rtf',
        'text/richtext'                                                             => 'rtx',
        'video/vnd.rn-realvideo'                                                    => 'rv',
        'application/x-stuffit'                                                     => 'sit',
        'application/smil'                                                          => 'smil',
        'text/srt'                                                                  => 'srt',
        'image/svg+xml'                                                             => 'svg',
        'application/x-shockwave-flash'                                             => 'swf',
        'application/x-tar'                                                         => 'tar',
        'application/x-gzip-compressed'                                             => 'tgz',
        'image/tiff'                                                                => 'tiff',
        'font/ttf'                                                                  => 'ttf',
        'text/plain'                                                                => 'txt',
        'text/x-vcard'                                                              => 'vcf',
        'application/videolan'                                                      => 'vlc',
        'text/vtt'                                                                  => 'vtt',
        'audio/x-wav'                                                               => 'wav',
        'audio/wave'                                                                => 'wav',
        'audio/wav'                                                                 => 'wav',
        'application/wbxml'                                                         => 'wbxml',
        'video/webm'                                                                => 'webm',
        'image/webp'                                                                => 'webp',
        'audio/x-ms-wma'                                                            => 'wma',
        'application/wmlc'                                                          => 'wmlc',
        'video/x-ms-wmv'                                                            => 'wmv',
        'video/x-ms-asf'                                                            => 'wmv',
        'font/woff'                                                                 => 'woff',
        'font/woff2'                                                                => 'woff2',
        'application/xhtml+xml'                                                     => 'xhtml',
        'application/excel'                                                         => 'xl',
        'application/msexcel'                                                       => 'xls',
        'application/x-msexcel'                                                     => 'xls',
        'application/x-ms-excel'                                                    => 'xls',
        'application/x-excel'                                                       => 'xls',
        'application/x-dos_ms_excel'                                                => 'xls',
        'application/xls'                                                           => 'xls',
        'application/x-xls'                                                         => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
        'application/vnd.ms-excel'                                                  => 'xlsx',
        'application/xml'                                                           => 'xml',
        'text/xml'                                                                  => 'xml',
        'text/xsl'                                                                  => 'xsl',
        'application/xspf+xml'                                                      => 'xspf',
        'application/x-compress'                                                    => 'z',
        'application/x-zip'                                                         => 'zip',
        'application/zip'                                                           => 'zip',
        'application/x-zip-compressed'                                              => 'zip',
        'application/s-compressed'                                                  => 'zip',
        'multipart/x-zip'                                                           => 'zip',
        'text/x-scriptzsh'                                                          => 'zsh',
    ];

    return isset($mime_map[$mime]) ? $mime_map[$mime] : "bin";
}

/**
 * Generates an HTML <input> and it's associated &lt;label&gt;. (It's a pain to use, what an awful function I have created -Sean)
 * @param string $fieldId The "id" attribute of the &lt;input&gt; element
 * @param string $inputType The "type" attribute of the &lt;input&gt; element
 * @param string $fieldName The "name" attribute of the &lt;input&gt; element
 * @param string $label The label text for this field
 * @param string $placeHolder The "placeholder" attribute of the &lt;input&gt; element
 * @param string $defaultValue The "value" attribute of the &lt;input&gt; element
 * @param bool $isRequired The "required" attribute of the &lt;input&gt; element
 * @return string HTML code for a form field
 */
function generateFormField(?string $fieldId, ?string $inputType, ?string $fieldName, ?string $label, ?string $placeHolder, ?string $defaultValue, bool $isRequired): string {

    $result = "<label ";
    if($fieldId) {
        $result .= "for=\"$fieldId\" ";
    }
    $result .= ">";
    if($label) {
        $result .= $label;
    }
    if($isRequired) {
        $result .= "<span class=\"required-symbol\">*</span>";
    }
    $result .= "</label><input ";
    if($fieldId) {
        $result .= "id=\"$fieldId\" ";
    }
    if($inputType) {
        $result .= "type=\"$inputType\" ";
    }
    if($placeHolder) {
        $result .= "placeholder=\"$placeHolder\" ";
    }
    if($defaultValue) {
        $result .= "value=\"$defaultValue\" ";
    }
    if($fieldName) {
        $result .= "name=\"$fieldName\" ";
    }
    if($isRequired) {
        $result .= "required ";
    }
    $result .= ">";
    return $result;
}

function generateUserForm(UserFormPurpose $purpose, ?User $prefillWithUser): string {

    if($purpose == UserFormPurpose::LOGIN) {
        $submitButtonText = "Login";
    } elseif($purpose == UserFormPurpose::REGISTER) {
        $submitButtonText = "Register";
    } else {
        $submitButtonText = "Apply changes";
    }
    if($prefillWithUser) {
        $prefilluserId = $prefillWithUser->userId;
        $prefillUsername = $prefillWithUser->username;
        $prefillFirstName = $prefillWithUser->firstName;
        $prefillLastName = $prefillWithUser->lastName;
        $prefillEmail = $prefillWithUser->email;
	$prefillProfilePic = $prefillWithUser->profilePictureUploadId;
        $prefillBio = $prefillWithUser->bio;
    } else {
        $prefilluserId = null;
        $prefillUsername = null;
        $prefillFirstName = null;
        $prefillLastName = null;
        $prefillEmail = null;
	$prefillProfilePic = null;
        $prefillBio = null;
    }
    $htmlForm = "<form method=\"POST\" enctype=\"multipart/form-data\">";
    $htmlForm .= "<input hidden name=\"user-id\" hidden value=\"$prefilluserId\">";
    $htmlForm .= generateFormField(fieldId: "username-field", inputType: "text", fieldName: "username", label: "Username", placeHolder: "", defaultValue: $prefillUsername, isRequired: true);
    if($purpose != UserFormPurpose::REGISTER) {
        $htmlForm .= generateFormField(fieldId: "password-field", inputType: "password", fieldName: "current-password", label: "Password", placeHolder: "", defaultValue: "", isRequired: true);
    }
    if($purpose == UserFormPurpose::REGISTER || $purpose == UserFormPurpose::CHANGE_PASSWORD) {
        $htmlForm .= generateFormField(fieldId: "new-password-field", inputType: "password", fieldName: "new-password", label: "New password", placeHolder: "", defaultValue: "", isRequired: true);
        $htmlForm .= generateFormField(fieldId: "confirm-password-field", inputType: "password", fieldName: "confirm-password", label: "Confirm password", placeHolder: "", defaultValue: "", isRequired: true);
    }
    if($purpose == UserFormPurpose::REGISTER || $purpose == UserFormPurpose::EDIT) {
        $htmlForm .= generateFormField(fieldId: "first-name-field", inputType: "text", fieldName: "given-name", label: "First name", placeHolder: "", defaultValue: $prefillFirstName, isRequired: false);
        $htmlForm .= generateFormField(fieldId: "last-name-field", inputType: "text", fieldName: "family-name", label: "Last name", placeHolder: "", defaultValue: $prefillLastName, isRequired: false);
        $htmlForm .= generateFormField(fieldId: "email-field", inputType: "email", fieldName: "email", label: "Email", placeHolder: "", defaultValue: $prefillEmail, isRequired: false);
	    $htmlForm .= "<input hidden name=\"file-description\" hidden value=\"$prefillUsername's profile picture\">";
        $htmlForm .= generateFormField(fieldId: "profile-picture-upload-field", inputType: "file", fieldName: "profile-picture-upload", label: "Profile Picture", placeHolder: "", defaultValue: $prefillProfilePic, isRequired: false);
    }
    if($purpose == UserFormPurpose::EDIT) {
        $htmlForm .= "<label for=\"bio-field\">About me</label><textarea name=\"bio\">$prefillBio</textarea>";
    }
    if($purpose == UserFormPurpose::DELETE) {
        $htmlForm .= "<label for=\"confirm-delete-field\">Confirmation</label><input id=\"confirm-delete-field\" type=\"text\" name=\"confirm-delete\" required pattern=\"^DELETE FOREVER$\" placeholder=\"Type: DELETE FOREVER\" title=\"Type: DELETE FOREVER\">";
    }
    $htmlForm .= "<button type=\"submit\">$submitButtonText</button></form>";
    return $htmlForm;
}

/**
 * Takes a user and displays it as a table (for testing purposes)
 * @param ?User $user
 * @return string HTML table
 */
function generateUserDebugTable(?User $user): string {
    if($user == null) {
        return "<p>The user does not exist.<p>";
    }
    $result = "";
    $result .= '<div class="table-scrolling"><table><thead><tr><th>Field</th><th>Value</th></tr></thead><tbody>';
    $result .= "<tr><td>User ID</td><td>".$user->userId."</td></tr>";
    $result .= "<tr><td>Username</td><td>".$user->username."</td></tr>";
    $result .= "<tr><td>Password hash</td><td>".$user->passwordHash."</td></tr>";
    $result .= "<tr><td>Join date</td><td>".date_format($user->joinDate, "D, d M Y H:i:s")."</td></tr>";
    $result .= "<tr><td>First name</td><td>".$user->firstName."</td></tr>";
    $result .= "<tr><td>Last name</td><td>".$user->lastName."</td></tr>";
    $result .= "<tr><td>PFP ID</td><td>".$user->profilePictureUploadId."</td></tr>";
    $result .= "<tr><td>Bio</td><td>".$user->bio."</td></tr>";
    $result .= "<tr><td>Email</td><td>".$user->email."</td></tr>";
    $result .= "</tbody></table></div>";
    return $result;
}



/**
 * This class returns HTML code as strings.
 */
class HtmlGeneration {
    public IdeaRepoApp $ideaRepo;

    function __construct(IdeaRepoApp $ideaRepo) {
        $this->ideaRepo = $ideaRepo;
    }

    function getPathOfUpload(?int $fileUploadId): string {
        if($fileUploadId == null) {
            return "";
        }
        try {
            $queryResult = $this->ideaRepo->database->query("SELECT * FROM fileUploads WHERE fileuploadId = $fileUploadId");
            while($record = $queryResult->fetch_assoc()) {
                $fileExtension = mime2ext($record["fileMimeType"]);
                return "http://cit.wvncc.edu/idea-repository/uploads/$fileUploadId.$fileExtension";
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->ideaRepo->log("ERROR: Could not get the URL of the file with ID $fileUploadId: $errorMessage");
        }

        return "";
    }
    function fileUploadToHtml(?int $fileUploadId) {

        if($fileUploadId == null) {
            return "";
        }
        try {
            $queryResult = $this->ideaRepo->database->query("SELECT * FROM fileUploads WHERE fileuploadId = $fileUploadId");
            while($record = $queryResult->fetch_assoc()) {
                $altText = $record["description"];
                $fileExtension = mime2ext($record["fileMimeType"]);
                $url = $this->getPathOfUpload($fileUploadId);
                if(str_starts_with($record["fileMimeType"], "image")) {
                    return "<img src=\"$url\" alt=\"$altText\">";
                } elseif(str_starts_with($record["fileMimeType"], "video")) {
                    return "<video src=\"$url\" alt=\"$altText\">";
                } elseif(str_starts_with($record["fileMimeType"], "audio")) {
                    return "<audio controls src=\"$url\" alt=\"$altText\">";
                } else {
                    return "<p><a href=\"http://cit.wvncc.edu/idea-repository/uploads/$fileUploadId.$fileExtension\">$altText</a></p>";
                }
            }
        } catch(mysqli_sql_exception $err) {
            $errorMessage = $err->getMessage();
            $this->ideaRepo->log("ERROR: file with ID $fileUploadId could not be converted to HTML: $errorMessage");
        }
        
        return "<p>[File not found]</p>";
    }

    function generateIdeaPreview(int $ideaId){

        $idea = $this->ideaRepo->getIdeaById($ideaId);
        $author = $this->ideaRepo->users->getUserByUserId($idea->creatorUserId);
        if($author) {
            $authorName = $author->username;
        } else {
            $authorName = "???";
        }
        $date = date_format($idea->creationDate, "d M, Y");
        $thumbnailImageId = $this->ideaRepo->getFileUploadIdForIdeaThumbnail($ideaId);
        $ideaLink = "http://cit.wvncc.edu/idea-repository/idea.php?id=$idea->ideaId";
        if($thumbnailImageId) {
            $thumbnailHtml = $this->fileUploadToHtml($thumbnailImageId);
        } else {
            $thumbnailHtml = null;
        }
        
        $creationVerb = $idea->isPublic ? "Unveiled" : "Created";
        $result = "<section class='idea-preview'>";
        $result .= "<header>";
        $result .= "<h3><a href=$ideaLink>$idea->title</a></h3>";
        $result .= "</header>";
        if($thumbnailHtml) {
            $result .= "<a href=$ideaLink>$thumbnailHtml</a>";
        }
        $result .= "<p><a href=$ideaLink>$idea->summary</a></p><hr>";
        $result .= "<p>$creationVerb by <a href='http://cit.wvncc.edu/idea-repository/profile.php?id=$idea->creatorUserId'>$authorName</a> on $date</p>";
        $result .= "</section>";
        return $result;
    }

    function generateIdea(Idea $idea, bool $isViewingOwnIdea): string {

        $user = $this->ideaRepo->users->getUserByUserId($idea->creatorUserId);
        $result = "<article id=\"idea\">";
        $result .= "<hgroup>";
        $result .= "<h2>$idea->title</h2>";
        $date = date_format($idea->creationDate, "d M, Y");
        $result .= "<p>Unveiled by <a href=\"http://cit.wvncc.edu/idea-repository/profile.php?id=$user->userId\"\">$user->username</a> on $date<p>";
        $result .= "</hgroup>";
        if($isViewingOwnIdea) {
            $result .= "<nav>";
            $result .= "<p><a href=\"/idea-repository/edit-idea.php?id=$idea->ideaId\">Edit idea</a></p>";
            $result .= "<p><a href=\"/idea-repository/delete-idea.php?id=$idea->ideaId\">Delete idea</a></p>";
            $result .= "</nav>";
        }
        $result .= "<h3>Summary</h3><p>$idea->summary</p><hr>";
        if($idea->content) {
            $result .= $idea->content;
        }
        
        $result .= "</article id=\"idea\">";
        return $result;
    }
    function generateIdeaEditingZone() {
        return "<trix-editor input=\"idea-content-field\" style=\"height:150px;border:1px solid black; border-radius:8px;\" ></trix-editor><br>";
    }

    function generateHead(string $title, bool $includeEditor): string {
        $result = "<head>";
        $result .= "<title>$title | Idea Repository</title>";
        $result .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
        // Bootrap and Font Awesome
        //$result .= "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\">";
        //$result .= "<script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js\"></script>";
        $result .= "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">";
        // Reset all styles
        $result .= "<link href=\"http://cit.wvncc.edu/idea-repository/css/reset.css\" rel=\"stylesheet\">";
        // Some variable declarations
        $result .= "<link href=\"http://cit.wvncc.edu/idea-repository/css/theme.css\" rel=\"stylesheet\">";
        // Most styles
        $result .= "<link href=\"http://cit.wvncc.edu/idea-repository/css/style.css\" rel=\"stylesheet\">";
        // Styles for site header
        $result .= "<link href=\"http://cit.wvncc.edu/idea-repository/css/header.css\" rel=\"stylesheet\">";
        // Styles for idea.php
        $result .= "<link href=\"http://cit.wvncc.edu/idea-repository/css/idea.css\" rel=\"stylesheet\">";
        // JS code for idea edits
        // Fonts: Sahitya, PT Sans, Crimson Text
        $result .= "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">";
        $result .= "<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>";
        $result .= "<link href=\"https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Sahitya:wght@400;700&display=swap\" rel=\"stylesheet\">";
        if($includeEditor) {
            $result .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"https://unpkg.com/trix@2.0.8/dist/trix.css\"><script src=\"https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js\"></script>";
        }
        $result .= "<script src=\"http://cit.wvncc.edu/idea-repository/js/ideas.js\"></script>";
        $result .= "</head>";
    
        return $result;
    }
    
    function generateNav(): string {
        $result = "<nav aria-label=\"Site map\">";
        $result .= "<ul>";
        $result .= "<li><a class=\"fa fa-home icon\"></a><a href=\"http://cit.wvncc.edu/idea-repository/index.php\">Home</a></li>";
        if($this->ideaRepo->isLoggedIn()) {
            $user = $this->ideaRepo->getCurrentUser();
            $username = $user->username;
            $result .= "<li><a class=\"fa fa-magic icon\"></a><a href='/idea-repository/epiphany.php'>New Idea</a></li>";
            $result .= "<li>";
            $result .= $this->fileUploadToHtml($user->profilePictureUploadId);
            $result .= "<a href='/idea-repository/profile.php?id=$user->userId'>$username</a>";
            $result .= "</li>";
            $result .= "<li><a class=\"fa fa-user-circle icon\"><a href='/idea-repository/logout.php'>Log Out</a></li>";
        } else {
            $result .= "<li><a class=\"fa fa-user-circle icon\"><a href=\"/idea-repository/login.php\">Login</a></li>";
            $result .= "<li><a class=\"fa fa-user-circle icon\"><a href=\"/idea-repository/register.php\">Register</a></li>";
        }
        //$result .= "<li><a class=\"fa fa-upload icon\"></a><a href='/idea-repository/upload.php'>Upload File</a></li>";
        $result .= "</ul>";
        $result .= "</nav>";
    
        return $result;
    }
    function generateDocument(string $title, string $mainContent, ?string $soemthing) {
        $result = "<!DOCTYPE html>";
        $result .= "<html lang=\"en\">";
        $result .= $this->generateHead($title, true);
        $result .= "<body>";
        $result .= "<header>";
        $result .= "<h1>Idea Repository</h1>";
        $result .= "<search>";
        $result .= "<form action=\"search.php\" method=\"POST\" aria-label=\"Search ideas by keyword\">";
        $result .= "<input type=\"text\" name=\"query\" pattern=\"[A-Za-z ]{1,25}\" placeholder=\"Search\" aria-label=\"Search keywords\"required>";
        $result .= "<button type=\"submit\">Search</button>";
        $result .= "</form>";
        $result .= "</search>";
        $result .= "</header>";
        $result .= $this->generateNav();
        $result .= "<main>";
        $result .= "<h2>$title</h2>";
        if($mainContent) {
            $result .= $mainContent;
        }
        $result .= "</main>";
        if($soemthing) {
            $result .= "<aside>$soemthing</aside>";
        }
        $result .= "<footer>";
        $result .= "<p>Brought to you by West Virginia Northern Community College.</p>";
        $result .= "<p>".date_format(new DateTime(), "D, d M Y H:i:s")."</p>";
        $result .= "<p><a href=\"http://cit.wvncc.edu/idea-repository/rss-feed.php\">Subscribe<i class=\"fa fa-rss\" aria-hidden=\"true\"></i></a></p>";
        $result .= "</footer>";
        $result .= "</body>";
        $result .= "</html>";
    
        return $result;
    }
}