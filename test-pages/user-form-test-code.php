function parseUserEditForm(UserFormPurpose $purpose) {

// Is the user adding/changing a password?
$isPasswordChange = $purpose == UserFormPurpose::CHANGE_PASSWORD || $purpose == UserFormPurpose::REGISTER;

// We must have a form to read, this method was called by mistake
if($_SERVER["REQUEST_METHOD"] != "POST") {
    $this->log("ERROR: Cannot parse a non-existing user form");
    return;
}
$userId = $_POST["user-id"];
if($userId) {
    $user = $this->getUserByUserId($userId);
}
if($isPasswordChange) {
    $password = $_POST["new-password"];
    if($_POST["new-password"] != $_POST["confirm-password"]) {
        $this->log("ERROR: new passwords do not match");
        return;
    }
} else {
    $password = $_POST["current-password"];
}
$user = new User (
    $_POST["user-id"],
    $_POST["username"],
    encryptPassword($password),
    new DateTime(),
    $_POST["given-name"],
    $_POST["family-name"],
    null,
    null,
    $_POST["email"],
);
}