<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <link rel="stylesheet" href="styles/design.css" > 
  <title>forgot password</title>
</head>
<body>
  <?php include 'includes/header.php'?>
  
  <form method="post">
  <h2>Password Reset</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <p></p>
    <input type="submit" value="Reset Password">

    <?php
//establishing a connection
include 'includes/library.php';
$pdo = connectDB();

// function to generate random password
function generatePassword($length = 10) {
  //generates a password with the following charactres
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // check if user exists in database
    $stmt = $pdo->prepare("SELECT * FROM ass3_users WHERE username = ? AND email = ?");
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch();
  //checks first if the user name is valid or not, if yes then generates a new password
    if (!$user) {
        echo ("<h2>Invalid username or email.</h2>");
    } else {
        // generate and update password in database
        $password = generatePassword();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE ass3_users SET password = ? WHERE username = ?");
        $stmt->execute([$hashed_password, $username]);
     
        //sending mail to user with new password
        require_once "Mail.php";  //this includes the pear SMTP mail library
        $from = "Password System Reset <noreply@loki.trentu.ca>";
        $to = "<$email>";  //put user's email here
        $subject = "New Password";
        $body = "Your new password is: " . $password;
          $host = "smtp.trentu.ca";
          $headers = array ('From' => $from,
            'To' => $to,
            'Subject' => $subject);
          $smtp = Mail::factory('smtp',
            array ('host' => $host));
            //echo a message telling the user email has been sent 
            $mail = $smtp->send($to, $headers, $body);
            if (PEAR::isError($mail)) {
              echo("<p>" . $mail->getMessage() . "</p>");
            } else {
              echo("<h1>Email successfully sent!</h1>");
            } 
          
 }
}

?>
    
  </form>

 
  <?php include 'includes/footer.php'?>
    
</body>
</html>
