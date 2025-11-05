<?php
require_once("/var/www/html/idea-repository/php/ideaRepo.php");
$ideaRepo = new IdeaRepoApp();
header("Content-Type: text/xml");
echo "<?xml version=\"1.0\"?>";
echo "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">";
echo "<channel>";
echo "<title>The Idea Repository</title>";
echo "<link>http://cit.wvncc.edu/idea-repository/</link>";
echo "<description>All ideas published on The Idea Repository.</description>";
foreach($ideaRepo->getAllIdeas() as $idea) {
    if($idea->isPublic) {
        $ideaId = $idea->ideaId;
        $title = $idea->title;
        $summary = $idea->summary;
        $createdDate = date_format($idea->creationDate, "D, d M Y H:i");
        $author = $ideaRepo->users->getUserByUserId($idea->creatorUserId)->username;
        $content = $idea->content;
        echo "<item>";
        echo "<title>$title</title>";
        echo "<link>http://cit.wvncc.edu/idea-repository/idea.php?id=$ideaId</link>";
        echo "<author>$author</author>";
        echo "<description>$summary</description>";
        echo "<pubDate>$createdDate</pubDate>";
        echo "<content:encoded><![CDATA[$idea->content]]></content:encoded>";
        echo "</item>";
    }
}
echo "</channel>";
echo "</rss>";