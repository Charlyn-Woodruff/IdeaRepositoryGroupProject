<?php
require_once("/var/www/html/idea-repository/php/htmlGeneration.php");

function searchIdeas(HtmlGeneration $html){
	$conn = connectDatabase();
   	// This line declares the variables for each form input as an empty string
   	$query = "";
	//var_dump($html);

function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
	$lang = test_input($_POST['query']);
       //var_dump($lang);
        }
$returnres = "";
      $query = "SELECT * FROM ideas INNER JOIN users ON users.userId = ideas.creatorUserId WHERE isPublic='1' AND (title LIKE '%$lang%' OR content LIKE '%$lang%' OR username LIKE '%$lang%')";
      $stmt = mysqli_prepare($conn,$query); 
      $result = mysqli_stmt_execute($stmt);
      $result = $stmt->get_result();
     
      // Changed to use generateIdeaPreview, commented out table code -Sean 11-17-24

      if (mysqli_num_rows($result) > 0){
        $returnres .= "<section class=\"ideas\">";

        while($row = mysqli_fetch_assoc($result)) {
            //$returnres .= "<tr style='border:2px solid black; text-align:center; padding:15px;'><td style='border:2px solid black; margin:5px;'>". $row['creatorUserId'] ."</td><td style='border:2px solid black' >".$row['title']."</td><td style='border:2px solid black'>".$row['username']."</td><td style='border:2px solid black'>".$row['creationDate']."</td><td style='border:2px solid black'>".$row['summary']."</td><td style='border:2px solid black'>".$row['content']."</td>";
            $returnres .= $html->generateIdeaPreview($row["ideaId"]);
        } 
        //$returnres .= "</table></div>";
        $returnres .= "</section>";
       
      }else {
    	$returnres .= "<h4>No results found!</h4>";
      }
 	mysqli_close($conn);
    return $returnres;
}

 function connectDatabase(){

  //This line creates the server database connection to the MySQL using MySQLi with a username, password and the existing database name
  $conn = mysqli_connect('maria', 'cpwoodruff', 'Char67','idea_repository');

  //This line checks to see it the database connection is connected if it is not it will exit and send an error message
  if (!$conn) {
      die("Connection failed: " . $conn->connect_error);
  }
 	return($conn);
}

$ideaRepo = new IdeaRepoApp();
$htmlGeneration = new HtmlGeneration($ideaRepo);
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = searchIdeas($htmlGeneration);
} else {
    $content = "<h3>Search Ideas By Title Keyword</h3>";
    $content .= "<form action=\"search.php\" method=\"POST\">";
    $content .= "<label>Search Ideas:</label><input type=\"text\" name=\"query\" title=\"Enter valid type\" pattern=\"[A-Za-z ]{1,25}\" placeholder=\"Search\" required>";
    // This is the submit button to submit the information in the form and the reset button to clear all information in the form
    $content .= "<input type=\"submit\" value=\"Search\" <input type=\"reset\" value=\"Reset\" >";
    $content .= "</form> ";
}

echo $htmlGeneration->generateDocument("Search Ideas", $content, null);