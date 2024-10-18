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
  include 'includes/library.php';
  $pdo = connectdb();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="styles/design.css" > 
    <title>Search page</title>
  </head>
  <body>
  <?php include 'includes/header.php'?>
      <p></p>
      <button type="submit" class="logOut">Log out</button>
      <form id="form_id" name="search" action="search.php" method="get">
      <p><a href="index.php">Home page</a>.</p>
          <p><label for="title">Search by TItle:</label></p>
          <input type="text" id="title" name="title" placeholder="enter title">

          <p><label for="author">Search by Author:</label></p>
          <input type="text" id="author" name="author" placeholder="enter Author">

          <p><label for="ISBN">Search by ISBN:</label></p>
          <input type="text" id="ISBN" name="ISBN" placeholder="enter ISBN no.">

          
          <P><button type="submit" name="submit" id="submit">Submit</button></P>
        
        <?php
          // Check if the search form has been submitted
          if (isset($_GET['submit'])) {
            // Retrieve search parameters from the form submission
            $title = isset($_GET['title']) ? $_GET['title'] : '';
            // Other search fields
            $author = isset($_GET['author']) ? $_GET['author'] : '';
            // Construct the SQL query based on the search parameters
            $sql = "SELECT * FROM books WHERE 1=1";

            if ($title != '') {
              $sql .= " AND booktitle LIKE :booktitle";
            }
            if ($author != '') {
              $sql .= " AND author LIKE :author";
            }
            

            // Prepare the SQL query for execution
            $stmt = $pdo->prepare($sql);

            // Bind the search parameters to the statement
            if ($title != '') {
              $stmt->bindValue(':booktitle', "%$title%");
            }
            if ($author != '') {
              $stmt->bindValue(':author', "%$author%");
            }

            // Execute the prepared statement
            $stmt->execute();

            // Retrieve the search results
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<h3>Below are the results and its details</h3>";
            // Display search results
            if (count($results) > 0) {
              echo "<p>Search Results:</p>";
              echo "<ul>";
              foreach ($results as $row) {
                echo "<li>";
                echo "<nav></nav><h1>{$row['booktitle']}</h1>";
                echo "<h2>By: {$row['author']}</h2>";
                echo "<h3> ISBN No.{$row['isbn']}</h3>";
                echo "<h3> Genre:{$row['genre']}</h3>";
                echo "<h3> rating:{$row['rating']}</h3>";
                echo '<img src="img/' . $row["format"] . '" alt="book cover">';
                echo "</li>";
              }
              echo "</ul>";
            } else {
              echo "<h1>No book found.</h1>";
            }
          }
        ?>
      </form>
        <?php include 'includes/footer.php'?> 
  </body>
</html>