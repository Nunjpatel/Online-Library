<?php

 // Get form input values
      $username = $_POST['username'] ?? "";
      $email = $_POST['email'] ?? "";
      $password = $_POST['password'] ?? "";
      $vpassword = $_POST['vpassword'] ?? "";

      include "includes/library.php";
      $pdo = connectdb();

   $errors = array();

    if (isset($_POST['submit'])) { 
//validate user has entered a username
if (!isset($username) || strlen($username) === 0) {
    $errors['username'] = true;
}

//validate user has entered an email
if (!isset($email) || strlen($email) === 0) {
  $errors['email'] = true;
}

//validate user has entered a password
if (!isset($password) || strlen($password) === 0) {
  $errors['password'] = true;
}

//validate user has entered a verify password
if (!isset($vpassword) || strlen($vpassword) === 0) {
  $errors['vpassword'] = true;
}

//validate password meets requirements
if (!preg_match('/^(?=.*\d)(?=.{6,}$)/', $password)) {
  $errors['password_requirements'] = true;
}

//validate email is in correct format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors['email_format'] = true;
}

//validate password and verify password match
if ($password !== $vpassword) {
  $errors['password_match'] = true;
}
//add the user info to the database
$query = "SELECT COUNT(*) FROM ass3_users WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$count = $stmt->fetchColumn();

$query = "SELECT COUNT(*) FROM ass3_users WHERE email = :email";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$count = $stmt->fetchColumn();

//check is the username already exists
if ($count > 0) {
  $errors['username_exists'] = true;
}

//check is the email already exists
if ($count > 0) {
  $errors['email_exists'] = true;
}
//password hashing
if (count($errors) === 0) {
  

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO ass3_users (username, email, password) VALUES (:username, :email, :password)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':username', $username);;
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $hashed_password);
  $stmt->execute();
//redirect user to login page 
  header("location:login.php");
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
    
    
    
    <script defer src="scripts/strength.js"></script>
    <title>Register</title>
  </head>
  <body>
   <?php include 'includes/header.php';?>
    <p></p>
        <form id="register" name="register" action="<?=htmlentities($_SERVER['PHP_SELF']);?>"  method="post" novalidate>
          <div>
            <label for="username">Username: </label>
            <input type="text" name="username" id="username"  value="<?php echo $username; ?>"  placeholder="Create a username"  />
            <span class="error <?=!isset($errors['username']) ? 'hidden' : "";?>"><error>Please enter a username</error></span>
            <span class="error <?=!isset($errors['username_exists']) ? 'hidden' : "";?>"><error>Username is already taken</error></span>
          </div>
         <p></p>
          <div>
            <label for="email">Enter your Email: </label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>"  placeholder="john@gmail.com" />
            <span class="error <?=!isset($errors['email']) && !isset($errors['email_exists']) ? 'hidden' : "";?>"><?=isset($errors['email']) ? 'email exists' : 'sorry email exist email'?></span>
          </div>
          <p></p>
          <div>
          <label for="password">Password: </label>
          <input type="password" name="password" id="password"  value="<?php echo $password;?>" placeholder="create a password" />
          <span class="error <?=!isset($errors['password']) && !isset($errors['password_requirements']) ? 'hidden' : "";?>"><?=isset($errors['password']) ? 'Please enter a password' : 'Please enter minimum 6char password'?></span>
          <span id="strength-text"></span>
        </div>
        
        <p></p>
         <div>
             <label for="vpassword">Re-enter Password: </label>
             <input type="password" name="vpassword" id="vpassword"  value="<?php echo $vpassword;?>" placeholder="Re Enter your password" />
             <span class="error <?=!isset($errors['vpassword']) && !isset($errors['password_match']) ? 'hidden' : "";?>"><?=isset($errors['vpassword']) ? 'Please verify password' : 'password doesnt match'?></span>
           </div>
          <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
          
              <button type="submit" name="submit" class="registerbtn">Register</button>
            
            <div class="container signin">
              <p>Already have an account? <a href="login.php">Sign in</a>.</p>
            </div>

        </form>
    <?php include 'includes/footer.php';?>
  </body>
</html>
