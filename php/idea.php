<?php

class Idea {
    public ?int $ideaId;
    public int $creatorUserId;
    public string $title;
    public string $summary;
    public DateTime $creationDate;
    public DateTime $modifiedDate;
    public bool $isPublic;
    public array $items;
    public ?string $content;

    function __construct(?int $ideaId, int $creatorUserId, string $title, string $summary, dateTime $creationDate, dateTime $modifiedDate, bool $isPublic, ?string $content) {
        $this->ideaId = $ideaId;
        $this->creatorUserId = $creatorUserId;
        $this->title = $title;
        $this->summary = $summary;
        $this->creationDate = $creationDate;
        $this->modifiedDate = $modifiedDate;
        $this->isPublic = $isPublic;
        $this->content = $content;
    }

    /**
     * Takes an array from mysqli_result->fetch_assoc() and creates an idea from it.
     * @param array $record
     * @return Idea
     */
    static function fromDbQueryArray(array $record): Idea {
        $idea = new Idea(
            ideaId: $record["ideaId"],
            creatorUserId: $record["creatorUserId"],
            title: $record["title"],
            summary: $record["summary"],
            creationDate: new DateTime($record["creationDate"]),
            modifiedDate: new DateTime($record["modifiedDate"]),
            isPublic: $record["isPublic"],
            content: Idea::processContentFromTrix($record["content"])
        );
        return $idea;
    }
    static function fromHttpPostRequest(): Idea {
        $sanitizedPost = sanitizeAssocArray($_POST);
        $idea = new Idea(
            ideaId: null,
            creatorUserId: $sanitizedPost["user-id"],
            title: $sanitizedPost["title"],
            summary: $sanitizedPost["summary"],
            creationDate: new DateTime(),
            modifiedDate: new DateTime(),
            isPublic: intval(($sanitizedPost["is-public"] == "on")),
            content: $sanitizedPost["content"]
        );
        return $idea;
    }

    static function processContentFromTrix(?string $html): string {
        if($html) {
            $html = str_replace("<div", "<p", $html);
            $html = str_replace("div>", "p>", $html);
            return $html;
        } else {
            return "";
        }
    }

    static function processContentForTrix(string $html): string {
        return $html;
    }
}