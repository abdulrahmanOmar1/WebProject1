<?php

include "db.php";
session_start();
$msgserror = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $PasswordTest = $_POST["Password"];

    $sqlstatment = "select email,password,name from signlogin s where s.email=:email";
    $run = $db->prepare($sqlstatment);
    $run->bindValue(":email", $email);
    $run->execute();
    $arr = $run->fetch(PDO::FETCH_ASSOC);
    if ($run->rowCount() >  0) {
        $Password = $arr["password"];
        $username = $arr["name"];
        if ($PasswordTest === $Password) {
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $_SESSION["boolean"] = true;
            header("Location:dashboard.php");
            exit();
        } else {
            $msgserror = "Password is error !";
        }
    } else {
        $msgserror = "email is not exist!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" />
    <title>Login page</title>
</head>

<body>
    <div class="box">
        <h2>Wlcome to Login page ! </h2>
        <form action="" method="POST">
            <article>
                <fieldset>
                    <legend>Login form</legend>
                    <table cellspacing=0 border="1">
                        <tr>
                            <th colspan="3">Login</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>email:</td>
                                <td colspan="3">
                                    <input type="email" name="email" placeholder="enter your email" required>
                                    <?php if ($msgserror == "email is not exist!") { ?>
                                        <span class="msgserror"><?php echo $msgserror; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="2">password:</td>
                                <td colspan="2">
                                    <input type="password" name="Password" placeholder="enter your Password" required>
                                    <?php if ($msgserror == "Password is error !") { ?>
                                        <span class="msgserror"><?php echo $msgserror; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>



                            <tr>
                                <td colspan="4"><input type="submit" name="submit" value="Send" id="sendButtom"></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>

                <label id="label">Don't have an account?</label>
                <a href="Registration.php">Create an account</a>
            </article>
        </form>
    </div>

</body>

</html>