<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knwoledge Base</title>
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

                    <table border="2" cellspacing=4 >
                        <caption>Share your knowledge</caption>
                        <tr>
                            <td>Title:</td>
                            <td><input type="text" name="title" style="width: 300px;" required></td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td><textarea name="description" style="width: 300px; height: 75px;" required></textarea></td>
                        </tr>
                        <tr>
                            <td>keyword:</td>
                            <td><input type="text" name="keyword" style="width: 300px;" required></td>
                        </tr>
                        <tr>
                            <td>Body text:</td>
                            <td><textarea name="body_text" style="width: 300px; height: 200px" required></textarea></td>
                        </tr>
                        <tr>
                            <td>relevant images or videos.:</td>
                            <td><input type="file" name="file" required></td>
                        </tr>
                    </table>
                </article>
                <br>
                <input type="submit" name="submit" value="Send" >
        </div>
    </form>
</body>
</html>

<?php

session_start();
include "db.inc";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit();
}


foreach ($_FILES as $fileKey => $array) {
    if ($array["error"] == UPLOAD_ERR_OK) {//اذا فش ايرور
        $acceptableTypes = ["video/mp4","image/png", "image/jpeg", "image/gif"];
        $fileType = $array["type"];

        if(in_array($fileType, $acceptableTypes)){

            $filename = $array["name"];
            $phTmp = $array['tmp_name'];
            $phname = $array['name'];

            move_uploaded_file($phTmp, "images/" . $phname);
        
            $profileId = $_SESSION["profile_id"];
            $profileName = $_SESSION["profile_name"];

            $sql = "INSERT INTO knowledge_base (title, description, keyword, body_text, relevant_imgvid, knowledgeFK , ProName)
            values (:knowledge_base_title, :knowledge_base_description, :knowledge_base_keywords, :knowledge_base_bodytext, :knowledge_base_imgORvideo, :knowledge_base_userId , :knowledge_base_ProName)";
            $result = $pdo->prepare($sql);
            $result->bindValue(":knowledge_base_title",$_POST["title"]);
            $result->bindValue(":knowledge_base_description",$_POST["description"]);
            $result->bindValue(":knowledge_base_keywords",$_POST["keyword"]);
            $result->bindValue(":knowledge_base_bodytext",$_POST["body_text"]);
            $result->bindValue(":knowledge_base_imgORvideo", $filename);
            $result->bindValue(":knowledge_base_userId", $profileId);
            $result->bindValue(":knowledge_base_ProName", $profileName);

            if($result->execute()){
                echo "Done!";

            }else{
                echo "ERROR!!";
            }
        }else{
            echo "<p style='color: red;'>ERROR!!you can upload video or image just!</p>";
        }
    }
}

?>