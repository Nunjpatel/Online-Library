<?php
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

$errors = [];

if (isset($_POST['submit'])) {
    require_once 'includes/library.php';
    $pdo = connectDB();

    $query = $pdo->prepare('SELECT * FROM ass3_users WHERE username = ?');
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $errors['user'] = true;
    } else {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            if (isset($_POST['rememberme'])) {
              setcookie('username', $username, time() + (86400)); // set cookie for 1 day

          } else {
              setcookie('username', '', time()-3600); // delete cookie
          }

            header('Location: index.php');
            exit();

        } else {
            $errors['login'] = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="stylesheet" href="styles/design.css" > 
    <title>Log in</title>
  </head>
  <body>
  <?php include 'includes/header.php'?>
      <p></p>
        

      <form action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="POST" autocomplete="off">
            <div class="container">
              <h2>Logging In</h2>
              <p>Enter the below requirments to log in.</p>
              <hr>
            </div>
              
              <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Username"  value="<?=$username;?>">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
             
          <div>
            <input type="checkbox" name="rememberme" id="rememberme" value="rememberme" <?php if (isset($_COOKIE['username'])) echo 'checked'; ?>>
            <label for="rememberme">Remember Me</label>
          </div>
          <!--displays errors-->
            <div>
                <span class="<?=!isset($errors['user']) ? 'hidden' : "";?>"><h2>The user doesn't exist</h2></span>
                <span class="<?=!isset($errors['login']) ? 'hidden' : "";?>"><h2>Incorrect password</h2></span>
                
              </div>
            <button id="submit" name="submit">Log In</button>
            
            <p></p>
            <div class="container signin">
              <a href="register.php">Create Account</a>
              <a href="forgot.php">Forgot Password</a>
            </div>
          
      </form>
    <p></p>
     <?php include 'includes/footer.php'?> 
  </body>
</html>