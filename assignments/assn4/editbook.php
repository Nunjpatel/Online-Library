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
include "includes/library.php";
$pdo = connectdb();

 // Get form input values
 $booktitle = $_POST['booktitle'] ?? "";
 $author = $_POST['author'] ?? "";
 $isbn =  $_POST['isbn'] ?? "";
 $rating = $_POST['rating'] ?? "";
 $genre = $_POST['genre'] ?? "";
 $publicationdate = $_POST['publicationdate'] ?? "";
 $description = $_POST['description'] ?? "";
 $format = $_POST['format'] ?? "";
$errors = array();


// Get book information from database
$booktitle = $_POST['booktitle'] ?? "";
$stmt = $pdo->prepare('SELECT booktitle, author, isbn, rating FROM books WHERE booktitle = ?');
$stmt->execute([$booktitle]);
$book = $stmt->fetch();

// Pre-fill form fields with book's data
if ($book !== false) {
  if (empty($booktitle)) {
    $booktitle = $book['booktitle'];
  }
  if (empty($author)) {
    $author = $book['author'];
  }
  if (empty($isbn)) {
    $isbn = $book['isbn'];
  }
  if (empty($rating)) {
    $rating = $book['rating'];
  }
}


if (isset($_POST['submit'])) { 
  if (count($errors) === 0) {

   // Update book information in database
  // prepare the SQL statement with named placeholders
  $stmt = $pdo->prepare("UPDATE books SET booktitle=:booktitle, author=:author, isbn=:isbn, rating=:rating, genre=:genre, publicationdate=:publicationdate, description=:description, format=:format WHERE id=:id");
  // pass an array of parameter values to the execute() method using a key-value mapping
  $stmt->execute([
    'booktitle' => $booktitle,
    'author' => $author,
    'isbn' => $isbn,
    'rating' => $rating,
    'genre' => $genre,
    'publicationdate' => $publicationdate,
    'description' => $description,
    'format' => $format,
    'id' => $id
  ]);

    header('Location: index.php');
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
    <title>Edit Book</title>
  </head>
  <body>
   <?php include 'includes/header.php';?>
    <p></p>
        <form id="form_id" name="editbook" action="<?=htmlentities($_SERVER['PHP_SELF']);?>"  method="post" novalidate>
          <div>
            <label for="booktitle">booktitle: </label>
            <input type="text" name="booktitle" id="booktitle"  value="<?php echo $booktitle; ?>"  placeholder="Enter a book title"  />
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
            <span class="error <?=!isset($errors['rating']) ? 'hidden' : "";?>">Please enter rating between 1-5</span>
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
          </div>
          <div>
            <p>select file for cover img</p>
            <input type="file" name="format" id="format" >
          </div>

          <button type="submit" name="submit" class="editbook">Edit book</button>

        </form>
    <?php include 'includes/footer.php';?>
  </body>
</html>
