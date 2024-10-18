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

require_once 'includes/library.php';
$pdo = connectDB();

// select all books from the database
$sql = "SELECT * FROM books";
$result = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <link rel="stylesheet" href="styles/design.css" > 
  <title>Index</title>
</head>
<body>
  <?php include 'includes/header.php'?>
  
  <h2>Greetings</h2>

  <form action="/register.php">
    <p><a href="addbook.php">Add a new book</a>.</p>
    <p><a href="search.php">Search a book</a>.</p>
    <h2>Displaying your collection</h2>
    <label for="sort_by">sort by:</label>
    <select name="sort_by" id="sort_by">
      <option value="date_added">date added</option>
      <option value="author">author</option>
      <option value="popular">popular</option>
    </select>

    <label for="itemsno.">no. of items per page</label>
    <select name="itemsno." id="itemsno.">
      <option value="25">25</option>   
    </select>
    <p></p>
    <input type="submit" value="Submit">
    
    <?php
    // output book details in a loop
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      echo '<div>';
      echo '<img src="img/' . $row["format"] . '" alt="book cover">';
      echo '<h3>Title: ' . $row["booktitle"] . '</h3>';
      echo '<h3>Author: ' . $row["author"] . '</h3>';
      echo '<a href="details.php?id=' . $row["id"] . '">View book</a>';
      echo '<a href="editbook.php?id=' . $row["id"] . '">Edit book</a>';
      echo '<a href="deletebook.php?id=' . $row["id"] . '">Delete book</a>';
      echo '</div>';
    }
    ?>
    
  </form> 

  <?php include 'includes/footer.php'?>
    
</body>
</html>
