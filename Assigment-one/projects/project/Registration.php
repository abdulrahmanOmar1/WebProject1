<?php

include "db.php";
session_start();
$msgserror = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $Password = $_POST["Password"];
    $conpassword = $_POST["confirmpassword"];

    if (isset($username) && isset($email) && isset($Password)) {
        $checkemail = $db->prepare("select email from signlogin s where s.email=:email");
        $checkemail->bindValue(":email", $email);
        $checkemail->execute();
        if ($checkemail->rowCount() > 0) {
            $msgserror = "email already exist!";
        } else {

            $acceptableTypes = ["image/png", "image/jpeg", "image/jpg"];
            $fileType = $_FILES['photo']['type'];

            if (in_array($fileType, $acceptableTypes)) {
                if (strlen($Password) > 8) {
                    $table = "signlogin";
                    $sql = "insert into $table (name, email , password , photo) values (:name , :email , :password ,:photo) ";
                    $run = $db->prepare($sql);
                    $run->bindValue(":name", $username);
                    $run->bindValue(":password", $Password);
                    $run->bindValue(":email", $email);
                    $run->bindValue(":photo", $_FILES['photo']['name']);
                    $_SESSION["photo"] = $_FILES['photo'];

                    if ($Password === $conpassword) {
                        if ($run->execute()) {
                            echo 'Done.';
                            header("Location: login.php");
                            exit();
                        } else {
                            $msgserror = "can't insert your data !";
                        }
                    } else {
                        $msgserror = "password does not match!";
                    }
                } else {
                    $msgserror = "Password must greater than 8 char !";
                }
            } else {
                $msgserror = "please enter Photo jpeg or png !";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Registraion.css">
    <title>Registration page</title>
</head>

<body>
    <div class="box">
        <h2>Wlcome to Registration page !</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Registraion form</legend>
                <article>
                    <table cellspacing=0 border="1">
                        <tr>
                            <th colspan="3">Registration</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>user name:</td>
                                <td><input type="text" name="username" placeholder="enter your name" required></td>
                            </tr>
                            <tr>
                                <td>email:</td>
                                <td colspan="4">
                                    <input type="email" name="email" placeholder="enter your email" required>
                                    <?php if ($msgserror == "email already exist!") { ?>
                                        <span class="msgserror"><?php echo $msgserror; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr colspan="4">
                                <td>profile picture</picture>:</td>
                                <td colspan="4">
                                    <input type="file" name="photo" required>
                                    <?php if ($msgserror == "please enter Photo jpeg or png !") { ?>
                                        <span class="msgserror"><?php echo $msgserror; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>


                            <tr>
                                <td>password:</td>
                                <td colspan="2">
                                    <input type="password" name="Password" placeholder="enter your Password" required>
                                    <?php if ($msgserror == "Password must greater than 8 char !") { ?>
                                        <span class="msgserror"><?php echo $msgserror; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>

                                <td>confirm password:</td>
                                <td colspan="2">
                                    <input type="password" name="confirmpassword" placeholder="confirm your password" required>
                                    <?php if ($msgserror == "password does not match!") { ?>
                                        <span class="msgserror"><?php echo $msgserror; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4"><input type="submit" name="submit" value="Send" id="sendButtom"></td>
                            </tr>
                        </tbody>
                    </table>
                </article>
            </fieldset>
        </form>
    </div>
</body>

</html>