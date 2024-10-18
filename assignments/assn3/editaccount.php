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
$username = $_POST['username'] ?? "";
$email = $_POST['email'] ?? "";
$password = $_POST['password'] ?? "";
$vpassword = $_POST['vpassword'] ?? "";

include "includes/library.php";
$pdo = connectdb();

// Get user information from database
$username = $_SESSION['username']; 
$stmt = $pdo->prepare('SELECT username, email FROM ass3_users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

// Pre-fill form fields with user's current information
if (empty($username)) {
  $username = $user['username'];
}
if (empty($email)) {
  $email = $user['email'];
}

$errors = array();
if ($password !== $vpassword) {
  $errors['password_match'] = true;
}

if (isset($_POST['submit'])) { 
  if (count($errors) === 0) {

    // Update user information in database
    $stmt = $pdo->prepare('UPDATE ass3_users SET username = ?, email = ?, password = ? WHERE username = ?');
    $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $username]);

    header('Location: logout.php');
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
  <title>edit account</title>
</head>

<body>
  <?php include 'includes/header.php';?>
  <p></p>
  <h1>Edit account</h1>
  <form id="form_id" name="editp" action="<?=htmlentities($_SERVER['PHP_SELF']);?>"  method="post" novalidate>
    <div>
      <label for="username">Username: </label>
      <input type="text" name="username" id="username" value="<?=htmlentities($username)?>" placeholder="Create a username" />
      <span class="error <?=!isset($errors['name']) ? 'hidden' : "";?>"><error>Please enter a username</error></span>
      <span class="error <?=!isset($errors['username_exists']) ? 'hidden' : "";?>"><error>Username is already taken</error></span>
    </div>
    <p></p>
    <div>
      <label for="email">Enter your Email: </label>
      <input type="email" name="email" id="email" value="<?=htmlentities($email)?>" placeholder="john@gmail.com" />
      <span class="error <?=!isset($errors['email']) && !isset($errors['email_format']) ? 'hidden' : "";?>"><?=isset($errors['email']) ? 'Please enter an email' : 'Please enter a valid email'?></span>
    </div>
    <p></p>
    <div>
      <label for="password">Password: </label>
      <input type="password" name="password" id="password" value="<?=htmlentities($password)?>" placeholder="create a password" />
      <span class="error <?=!isset($errors['password']) && !isset($errors['password_requirement']) ? 'hidden' : "";?>"><?=isset($errors['password']) ? 'Please enter a password' : 'Please enter minimum 8char password'?></span>
    </div>
    <p></p>
         <div>
             <label for="vpassword">Re-enter Password: </label>
             <input type="password" name="vpassword" id="vpassword"  value="<?php echo $vpassword;?>" placeholder="Re Enter your password" />
             <span class="error <?=!isset($errors['vpassword']) && !isset($errors['password_match']) ? 'hidden' : "";?>"><?=isset($errors['vpassword']) ? 'Please verify password' : 'password doesnt match'?></span>
           </div>
          
          
          
              <button type="submit" name="submit" class="editp">Edit password</button>
            

        </form>
    <?php include 'includes/footer.php';?>
  </body>
</html>
