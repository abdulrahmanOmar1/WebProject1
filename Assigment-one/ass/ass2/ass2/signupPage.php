<?php
include "db.inc";

session_start();

$M = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["email"]) && isset($_POST["password"])) {

                $checkIfExists = $pdo->prepare("select email from signlogin where signlogin.email = :email");
                $checkIfExists->bindValue(":email", $_POST["email"]);
                $checkIfExists->execute();
                if($checkIfExists->rowCount()>0){
                    $M = "Account already exist";
                }else{
                    if(strlen($_POST["password"]) < 8 ) {
                        $M = "Error:"."Password must be at least 8 charchter long" . "<br />";
                    }else{
                        $table = "signlogin";
                        $sql = "insert into $table (email,password) values(:email,:password)";
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(":email",$_POST["email"]);
                        $statement->bindValue(":password",$_POST["password"]);
                        if ($statement->execute()) { // اذا تنفذت بشكل صحيح وكلشي تمام ادخل
                            header("Location: userprofiles.php"); // انقلني لصفحه ثانيه 
                            $_SESSION["email"] = $_POST["email"]; //عباره عن اريه index=email ، بحيث اقدر استخدمها وين ما بدي 
                            exit();
                        } else {
                            $M = "Error";
                        }
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
    <title>Document</title>
    <style>
    body {
  background-color: burlywood;
}
</style>
</head>
<body>
    <form action="" method="post">
    <center>
        <fieldset>
       <legend><h1>Sign Up</h1></legend>

        <label><strong>Email</strong></label>:
        <br><input type="email" name="email" placeholder="Enter Email" required><br><br>
        <label><strong>Password</strong></label>:<br>
        <input type="password" name="password" placeholder="Enter Password" required><br><p>




        <?php if ($M) { ?>
            <p style="color: red;"><?php echo $M;?></p>
        <?php } ?>






        <input type="submit" name="submit" value="Signup" style="font-size: 17px"><br><br>
        <label style="color: blue;">I already have an account!</label><a href="loginPage.php">Login</a>
        </fieldset>
        <center>

    </form>
</body>
</html>