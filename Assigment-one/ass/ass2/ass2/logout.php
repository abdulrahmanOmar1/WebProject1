<?php
session_start();

if (isset($_POST["logout"])) {
    $_SESSION = array();
    session_destroy();
    header("Location: loginPage.php");
    exit();
}
?>


<html>
<head>
   <title>Welcome</title>
</head>
<body>
   <form method="POST">
      <input type="submit" value="Logout" name="logout">
   </form>
</body>
</html>
