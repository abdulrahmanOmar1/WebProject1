<?php
session_start();

if (isset($_POST["logout"])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<html>
<head>
   <title>Log out</title>
   <link rel="stylesheet" href="Logout.css">
</head>
<body>
   <div id="container"> 
   <form method="POST">
      <input type="submit" value="Logout" name="logout" id="submit">
   </form>
   </div>
</body>
</html>
