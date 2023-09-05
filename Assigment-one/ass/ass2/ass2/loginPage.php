<?php
include "db.inc";

$Emesg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        if ($_POST["email"] == "") {
            $Emesg = "You must enter an email";
        }else{
            session_start();
        
        if (isset($_SESSION["profile_id"]) && isset($_SESSION["profile_name"])) {
            unset($_SESSION["profile_id"]);
            unset($_SESSION["profile_name"]);
            session_destroy();
            session_start();
        }

        $sqlQuery = $pdo->prepare("SELECT email, password FROM signlogin WHERE signlogin.email = :email");
        $sqlQuery->bindValue(":email", $_POST["email"]);
        $sqlQuery->execute();
        $userInfo = $sqlQuery->fetch(PDO::FETCH_ASSOC);

        if ($sqlQuery->rowCount() != 0) {
            $storedUsername = $userInfo["email"];
            $storedPassword = $userInfo["password"];

            if ($storedPassword == $_POST["password"]) {
                $sqlIdProfile = $pdo->prepare("SELECT id,name from userProfile as u JOIN signlogin as l where u.emailFk = :loginEmail");
                $sqlIdProfile->bindValue(":loginEmail", $_POST["email"]);
                $sqlIdProfile->execute();
                $result = $sqlIdProfile->fetch(PDO::FETCH_ASSOC);
                $profileId = $result["id"];
                $profileName = $result["name"];
                $_SESSION["logged_in"] = true;
                $_SESSION["profile_id"] = $profileId;
                $_SESSION["profile_name"] = $profileName;
                
                header("Location: welcomepage.html");
                exit();
                
            } else {
                $Emesg = "Incorrect password !";
            }
        } else {
            $Emesg = "email is incorrect !";
        }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>loginphp 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
    body {
  background-color: burlywood;
}
</style>
</head>
<body>
    <form action="" method="post" style="margin-left: 15px;">
    <center>
    <fieldset>

    <legend><h1>Login</h1></legend>

    <label><strong>Email</strong></label>:<br>
        <input type="email" name="email" placeholder="e-mail"><br><p>
        <label><strong>Password</strong></label>:<br>
        <input type="password" name="password" placeholder="password" required><br><p>
        <?php if ($Emesg) { ?>
            <p style="color: red;"><?php echo $Emesg; ?></p>
        <?php } ?>
        <input type="submit" name="login" value="Login" style="margin-left: 25px;font-size: 17px;"><br><br>
        <label style="font-family: Arial, Helvetica, sans-serif; font-size: small; opacity: 0.5;">Not registered?:</label>
        <a href="signupPage.php">Create an account</a>
        </fieldset>
        </center>
    </form>
</body>
</html>
