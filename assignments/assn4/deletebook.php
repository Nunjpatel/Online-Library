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
$booktitle = '';
$author = '';
$errors = [];
// Check if form was submitted
if (isset($_POST['submit'])) {
    // Get username and password
    $booktitle = $_POST['booktitle'] ?? null;
    $author = $_POST['author'] ?? null;

    // Validate inputs
    $errors = [];
    if (empty($booktitle)) {
        $errors[] = 'title is is required';
    }
    if (empty($author)) {
        $errors[] = 'author is required';
    }

    // If no errors, delete book
    if (empty($errors)) {
        require_once 'includes/library.php';
        $pdo = connectDB();

        // Delete book
        $sql = "DELETE FROM books WHERE booktitle = '$booktitle'";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            // book deleted successfully
            session_destroy(); // Destroy session
            header('Location: index.php'); // Redirect to index page
            exit();
        } else {
            // book deletion failed
            echo 'Error deleting account';
        }
    }
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="styles/design.css" > 
    <script defer src="scripts/deletebook.js"></script>
    <title>Delete Book</title>
</head>
<body>
<?php include 'includes/header.php'?>
<p></p>
<form method="post" action="deletebook.php">
    <h1>Delete Book</h1>
    <!-- displays erros if available-->
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
    <p>Are you sure you want to delete your book?</p>
    
    <div>
                <label for="booktitle">booktitle:</label>
                <input type="text" name="booktitle" id="booktitle" placeholder="booktitle"  value="<?=$booktitle;?>">
            </div>
            <div>
                <label for="author">Author:</label>
                <input type="author" name="author" id="author" placeholder="author">
            </div>
        <input type="submit" name="submit" value="Delete Book">
    </form>
    <?php include 'includes/footer.php'?>
</body>

</html>