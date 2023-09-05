<?php

session_start();
include "db.inc";


if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit();
}

if(isset($_POST["keywords_of_file"])){

    $photo_tmp = $_FILES['file_to_share']['tmp_name'];

    $photo_name = $_FILES['file_to_share']['name'];

    move_uploaded_file($photo_tmp, "images/" . $photo_name);

    $profileId = $_SESSION["profile_id"];
    $profileName = $_SESSION["profile_name"];

    $sqlform = "INSERT INTO file_sharing (upload_file, Title_file, 	Description_file, Keywords_file, fileFK , ProName) values(:share_file, :file_title, :file_description, :file_keywords, :userId , :ProName)";
    $stmt = $pdo->prepare($sqlform);
    $stmt->bindValue(":share_file", $_FILES['file_to_share']['name']);
    $stmt->bindValue(":file_title", $_POST["title_of_file"]);
    $stmt->bindValue(":file_description", $_POST["description_textarea"]);
    $stmt->bindValue(":file_keywords", $_POST["keywords_of_file"]);
    $stmt->bindValue(":userId", $profileId);
    $stmt->bindValue(":ProName", $profileName);

    if($stmt->execute()){
        echo "<br> DONE";
    }else{
        echo "ERROR";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Sahring</title>
    <style>
    body {
  background-color: burlywood;
}
</style>
</head>
<body style="text-align: center;">
    <form method="post" enctype="multipart/form-data">
        <div align="center">
            <article>
                <h1>File Sahring Page</h1>
                <table border="3" cellspacing=7>
                    <tr>
                        <td>Upload File:</td>
                        <td><input type = "file" name="file_to_share" required></td>
                    </tr>
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="title_of_file" style="width: 250px;" placeholder="Title here" required></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description_textarea" style="width: 250px; height: 75px;" placeholder="text description here" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Keywords</td>
                        <td><input type="text" name="keywords_of_file" style="width: 250px;" placeholder="your keywords here"></td>
                    </tr>
                </table>
            </article>
            <br>
            <input type="submit" name="submit file" value="Submit File">
        </div>
    </form>
</body>
</html>