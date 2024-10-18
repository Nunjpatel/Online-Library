<?php
/****************************************
// ENSURES THE USER HAS ACTUALLY LOGGED IN
// IF NOT REDIRECT TO THE LOGIN PAGE HERE
******************************************/
session_start(); //start session
//check session for whatever user info was stored
if(!isset($_SESSION['username'])){
  //no user info, redirect
  header("Location:login.php");
  exit();
}

 // Get form input values
      
      $booktitle = $_POST['booktitle'] ?? "";
      $author = $_POST['author'] ?? "";
      $isbn =  $_POST['isbn'] ?? "";
      $rating = $_POST['rating'] ?? "";
      $genre = $_POST['genre'] ?? "";
      $publicationdate = $_POST['publicationdate'] ?? "";
      $description = $_POST['description'] ?? "";
      $format = $_POST['format'] ?? "";

      include "includes/library.php";
      $pdo = connectdb();

   $errors = array();

    if (isset($_POST['submit'])) { 
//validate user has entered a booktitle
if (!isset($booktitle) === 0) {
    $errors['booktitle'] = true;
}

//validate user has entered an author
if (!isset($author) === 0) {
  $errors['author'] = true;
}

//validate user has entered a isbn no.
if (!isset($isbn) === 0) {
  $errors['isbn'] = true;
}

//validate user has entered a rating
if (!isset($rating)===0) {
  $errors['rating'] = true;
}



//add the user info to the database
$query = "SELECT COUNT(*) FROM books WHERE booktitle = :booktitle";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':booktitle', $booktitle);
$stmt->execute();
$count = $stmt->fetchColumn();

if (count($errors) === 0) {

  $query = "INSERT INTO books (id, booktitle, author, isbn, rating, genre, publicationdate, description, format) 
VALUES (:id, :booktitle, :author, :isbn, :rating, :genre, :publicationdate, :description, :format)";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':booktitle', $booktitle);
$stmt->bindParam(':author', $author);
$stmt->bindParam(':isbn', $isbn);
$stmt->bindParam(':rating', $rating);
$stmt->bindParam(':genre', $genre);
$stmt->bindParam(':publicationdate', $publicationdate);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':format', $format);
$stmt->execute();

//redirect user to login page 
  header("location:index.php");
  exit();
}
}
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="styles/design.css" > 
    <script defer src="scripts/numbercount.js"></script>
    <script defer src="scripts/addbook.js"></script>
    <title>Add Book</title>
  </head>
  <body>
   <?php include 'includes/header.php';?>
    <p></p>
        <form id="addbook" name="addbook" action="<?=htmlentities($_SERVER['PHP_SELF']);?>"  method="post" novalidate>
          <div>
            <label for="booktitle">booktitle: </label>
            <input type="text" name="booktitle" id="booktitle"  value="<?php echo $booktitle; ?>"  placeholder="Enter a book title"  />
            <!-- deisplaying errors-->
            <span class="error <?=!isset($errors['booktitle']) ? 'hidden' : "";?>">Please enter a book title</span>
          </div>
         <p></p>
          <div>
            <label for="author">Enter authors name: </label>
            <input type="text" name="author" id="author" value="<?php echo $author; ?>"  placeholder="author name" />
            <span class="error <?=!isset($errors['author']) ? 'hidden' : "";?>">Please enter authors name</span>
          </div>
          <div>
            <label for="isbn">Enter ISBN no.: </label>
            <input type="text" name="isbn" id="isbn" value="<?php echo $isbn; ?>"  placeholder="enter isbn no." />
            <span class="error <?=!isset($errors['isbn']) ? 'hidden' : "";?>">Please enter isbn no.</span>
          </div>
          <p></p>
          <div>
            <label for="rating">Rating (between 1 and 5):</label>
            <input type="number" name="rating" id="rating" value="<?php echo $rating; ?>"  placeholder="enter rating between 1-5"  >
           <!-- <span class="error <?=!isset($errors['rating']) ? 'hidden' : "";?>">Please enter rating between 1-5</span>
-->
          </div>
          <p></p>
          <div>
            <label for="genre">Genre:</label>
            <select name="genre" id="genre">
            <option value="fiction">fiction</option>
            <option value="novel">novel</option>
            <option value="narrative">narrative</option>
            </select>
          </div>
          
          <div>
            <label for="publicationdate">Publication date:</label>
            <input type="date" id="publicationdate" name="publicationdate">
          </div>
          
          <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" cols="50"></textarea>
            <span id="numbercount"></span>
          </div>
          <div>
            <p>select file for cover img</p>
            <input type="file" name="format" id="format" >
          </div>

          <button type="submit" name="submit" class="addbook">Add book</button>

        </form>
    <?php include 'includes/footer.php';?>
  </body>
</html>
