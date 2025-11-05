<?php

class UsersTableRecord {
    public ?int $userId;
    public ?string $username;
    public ?string $passwordHash;
    public ?DateTime $joinDate;
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
}
class UsersTable {

}

class IdeasTableRecord {
    public ?int $ideaId;
    public ?int $creatorUserId;
    public ?string $title;
    public ?string $summary;
    public ?DateTime $creationDate;
    public ?DateTime $modifiedDate;
    public ?bool $isPublic;
    public ?array $items;

    function __construct(?int $ideaId, ?int $creatorUserId, ?string $title, ?string $summary, ?dateTime $creationDate, ?dateTime $modifiedDate, ?bool $isPublic) {
        $this->ideaId = $ideaId;
        $this->creatorUserId = $creatorUserId;
        $this->title = $title;
        $this->summary = $summary;
        $this->creationDate = $creationDate;
        $this->modifiedDate = $modifiedDate;
        $this->isPublic = $isPublic;
        $this->items = array();
    }
}
class IdeasTable {
    
}

class IdeaItemTypesRecord {
    public ?int $typeNameIdString;
    public ?string $htmlTagName;
    public ?string $htmlClassName;
    function __construct(?int $typeNameIdString, ?string $htmlTagName, ?string $htmlClassName) {
        $this->typeNameIdString = $typeNameIdString;
        $this->htmlTagName = $htmlTagName;
        $this->htmlClassName = $htmlClassName;
    }
}

class IdeaItemTypesTable {

}

class IdeaItemsTableRecord {
    public ?int $ideaItemId;
    public ?int $ideaId;
    public ?int $itemIndex;
    public ?string $itemType;
    public ?string $content;
    public ?int $fileUploadId;
    public ?string $htmlTag;
    public ?string $htmlClass;

    function __construct(?int $ideaItemId, int $ideaId, int $itemIndex, string $itemType, string $content, ?int $fileUploadId, ?string $htmlTag, ?string $htmlClass) {
        $this->ideaItemId = $ideaItemId;
        $this->ideaId = $ideaId;
        $this->itemIndex = $itemIndex;
        $this->itemType = $itemType;
        $this->content = $content;
        $this->fileUploadId = $fileUploadId;
        $this->htmlTag = $htmlTag;
        $this->htmlClass = $htmlTag;
    }
}
class IdeaItemsTable {

}

class FileUploadsTableRecord {

}
class FileUploadsTable {

}

class FollowersTableRecord {

}
class FollowersTable {

}

class CommentsTableRecord {

}
class CommentsTable {

}