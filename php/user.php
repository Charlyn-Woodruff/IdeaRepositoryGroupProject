<?php

enum UserFormPurpose {
    case LOGIN;
    case REGISTER;
    case EDIT;
    case DELETE;
    case CHANGE_PASSWORD;
}

/**
 * Represents a user that may or not be saved to the database.
 */
class User {
    public ?int $userId;
    public string $username;
    public string $passwordHash;
    public DateTime $joinDate;
    public ?string $firstName;
    public ?string $lastName;
    public ?int $profilePictureUploadId;
    public ?string $bio;
    public ?string $email;

    function __construct($userId, $username, $passwordHash, $joinDate, $firstName, $lastName, $profilePictureUploadId, $bio, $email) {
        $this->userId = $userId;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->joinDate = $joinDate;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->profilePictureUploadId = $profilePictureUploadId;
        $this->bio = $bio;
        $this->email = $email;
    }

    /**
     * Given an a query result, returns an array of users. May throw exceptions.
     * @param mysqli_result $query A sql query that has ->execute() already called
     * @return array An array of users derived from the query
     */
    static function usersFromQuery(mysqli_result|bool $query): array {
        $users = array();
        if($query == false) {
            return $users;
        }
        while($record = $query->fetch_assoc()) {
            $user = new User (
                userId: $record["userId"],
                username: $record["username"],
                passwordHash: $record["passwordHash"],
                joinDate: new DateTime($record["joinDate"]),
                firstName: $record["firstName"],
                lastName: $record["lastName"],
                profilePictureUploadId: $record["profilePictureUploadId"],
                bio: $record["bio"],
                email: $record["email"],
            );
            array_push($users, $user);
        }
        return $users;
    }
}