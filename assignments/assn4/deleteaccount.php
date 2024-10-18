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
$username = '';
$password = '';
$errors = [];
// Check if form was submitted
if (isset($_POST['submit'])) {
    // Get username and password
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    // Validate inputs
    $errors = [];
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    if (empty($password)) {
        $errors[] = 'Password is required';
    }

    // If no errors, delete user account
    if (empty($errors)) {
        require_once 'includes/library.php';
        $pdo = connectDB();

        // Delete user account
        $sql = "DELETE FROM ass3_users WHERE username = '$username'";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            // Account deleted successfully
            session_destroy(); // Destroy session
            header('Location: login.php'); // Redirect to login page
            exit();
        } else {
            // Account deletion failed
            echo 'Error deleting account';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="styles/design.css" > 
    <title>Delete Account</title>
</head>
<body>
<?php include 'includes/header.php'?>
<p></p>
<form method="post" action="deleteaccount.php">
    <h1>Delete Account</h1>
    <!-- displays erros if available-->
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
    <p>Are you sure you want to delete your account?</p>
    
    <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Username"  value="<?=$username;?>">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
        <input type="submit" name="submit" value="Delete Account">
    </form>
    <?php include 'includes/footer.php'?>
</body>

</html>
