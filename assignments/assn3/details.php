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

// Include the database connection file
include 'includes/library.php';

// Get the book ID from the URL
$id = $_GET['id'];

// Query the database to retrieve the book details
$pdo = connectdb();
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = ?');
$stmt->execute([$id]);
$book = $stmt->fetch();


?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="styles/design.css" > 
    <title>Details</title>
  </head>
  <body>
   
    <?php include 'includes/header.php';?>
    <P></P>
    <form>
      
      <h1><article><em><?php echo $book['booktitle']; ?><br>By <?php echo $book['author']; ?></em></article></h1>
      <aside>ISBN:<?php echo $book['isbn']; ?></aside>
      <nav>Rating:<?php echo $book['rating']; ?></nav>
      <nav>Genre:<?php echo $book['genre']; ?></nav>
      <nav>Date Published:<?php echo $book['publicationdate']; ?></nav>
      
      <?php echo '<img src="img/' . $book["format"] . '" alt="book cover">';?>
      <h4>Description</h4>
      <p><cite><?php echo $book['description']; ?></cite></p>

      <p><a href="index.php">Home page</a>.</p>
    </form>
    <?php include 'includes/footer.php'?>
  </body>
</html>
