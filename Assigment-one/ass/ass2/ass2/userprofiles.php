<!DOCTYPE html>
<html>
<head>
    <title>User Profile Form</title>
</head>
<body style="text-align: center;">
    <h1>User Profile</h1>

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="profile">
        <div align="center">
            <table border="2" width="300px" cellpadding="5">
                <caption>Create Profile</caption>
                <tr>
                    <th  nowrap>Name:</th>
                    <td ><input type="text" name="name" size="30" maxlength="30" required></td>
                </tr>
                <tr>
                    <th >Photo:</th>
                    <td> <input type="file" name="photo" accept="image/png, image/gif, image/jpeg" required></td>
                </tr>
                <tr>
                    <th>Bio text:</th>
                    <td><textarea name="bio" rows="4" cols="50" required></textarea></td>
                </tr>
                <tr>
                    <th nowrap>CV (PDF):</th>
                    <td><input type="file" name="CV" accept="application/pdf" required></td>
                </tr>
                <tr>
                    <th nowrap>Experience:</th>
                    <td><input type="text" name="experience" required></td>
                </tr>
                <tr>
                    <th nowrap>Experience:</th>
                    <td ><select name="Experience_level" required>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                        <option value="expert">Expert</option>
                        </select></td>
                </tr>
                <tr>
                    <th  nowrap>Interest:</th>
                    <td > <input type="text" name="interest" required></td>
                </tr>
                <tr>
                    <th colspan="2" align="center">
                        <input type="submit" value="Submit">
                    </th>
                </tr>
            </table>
        </div>
    </form>

</body>
</html>

<?php

session_start();
include "db.inc";

$user_email =$_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $photo = $_FILES["photo"]["name"];
    $bio = $_POST["bio"];
    $cv = $_FILES["CV"]["name"];
    $experience = $_POST["experience"];
    $level_of_experience = $_POST["Experience_level"];
    $interest = $_POST["interest"];

    $phTmp = $_FILES['photo']['tmp_name'];

    $phname = uniqid('photo_', true) . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

    move_uploaded_file($phTmp, "images/" . $phname);

    $sql = "INSERT INTO userprofile (name, photo, bio, CV, experience, LevelExperience, interest, emailFk ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $name);
    $statement->bindValue(2, $photo);
    $statement->bindValue(3, $bio);
    $statement->bindValue(4, $cv);
    $statement->bindValue(5, $experience);
    $statement->bindValue(6, $level_of_experience);
    $statement->bindValue(7, $interest);
    $statement->bindValue(8, $user_email);


    if ($statement->execute()) {
        $sqlIdProfile = $pdo->prepare("SELECT id,name from userprofile as u JOIN signlogin as l where u.emailFk = :loginEmail");
                $sqlIdProfile->bindValue(":loginEmail",$user_email);
                $sqlIdProfile->execute();
                $result = $sqlIdProfile->fetch(PDO::FETCH_ASSOC);//بجيب الداتا الي نفذتها وبحطها بارريه
                $profileId = $result["id"];
                $profileName = $result["name"];
                $_SESSION["profile_id"] = $profileId;
                $_SESSION["profile_name"] = $profileName;
        header(("Location: loginPage.php"));
        exit();
    } else {
        echo "ERROR";
    }
}
?>
