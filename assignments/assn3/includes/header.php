
  <header>
        <img src="img/logo1.png " alt="reload" width="100" height="100">
        <h1>STACKS BOOKSTORE</h1>
        <nav>
    <!-- shows links to pages depending if the user is logged in or not-->
      <?php if (isset($_SESSION['username'])): ?>
        <a href="editaccount.php">Edit Account</a>    <a href="logout.php">Logout</a>    <a href="deleteaccount.php">Delete Account</a>
      <?php else: ?>
        <a href="login.php">Login</a>    <a href="register.php">Create Account</a>
        
      <?php endif; ?>
    
      </nav>  
  </header>