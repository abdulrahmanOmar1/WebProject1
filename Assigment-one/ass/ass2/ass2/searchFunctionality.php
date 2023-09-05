<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Functionality</title>
    <style>
    body {
  background-color: burlywood;
}
</style>
</head>
<body>
<form method="post" action="" enctype="multipart/form-data">
        <div align="center">
            <article>
                <h1>Search Functionality Page</h1>
                <select name="select" required >
                     <option value="topic">topics</option>
                     <option value="member">Member</option>
                     <option value="keyword">Keyword</option>
                </select>
                Search: <input type="text" name="search" placeholder="About keywords, members or topics" style="width: 220px;" required>
                <input type="submit" value="Search">
            </article>
        </div>
    </form>
</body>
</html>

<?php

session_start();
include "db.inc";

$profileId = $_SESSION["profile_id"];

$proName=$_SESSION["profile_name"]; 

if(isset($_POST["search"])){
    $valueOfSearch = $_POST["search"];


    if($valueOfSearch == ""){
        echo "";
    }else{

        $sql = "SELECT * FROM  file_sharing where Keywords_file LIKE :research OR
        Title_file LIKE :research OR Description_file LIKE :research ";
        $sqlFSharing = $pdo->prepare($sql);
        $sqlFSharing->bindValue(":research", '%' . $valueOfSearch . '%');
        $sqlFSharing->execute();
        $sqlFResult = $sqlFSharing->fetchAll(PDO::FETCH_ASSOC);

        if ($sqlFSharing->rowCount() > 0) {
            echo "<br><hr style='opacity: 0.4;'>";
            echo "<h2 align='center'>File Sharing Results</h2>";
            echo "<table border='3' align='center'>
                <tr>
                    <td colspan='4'>
                        <strong>Title</strong>
                    </td>
                    <td colspan='2'><strong>Author</strong></td>
                    <td colspan='4'><strong>Description</strong></td>
                </tr>";
                foreach ($sqlFResult as $row) {
                    $itemIdF = $row['id'];
                    echo "<tr>
                        <td colspan='4'><a href='FULLdis.php?type=file&id={$itemIdF}'>{$row['Title_file']}</a></td>
                        <td colspan='2'>{$row['ProName']}</td>
                        <td colspan='4'>{$row['Description_file']}</td>
                    </tr>";
                }
        
            echo "</table>";
        }
    }
}

if(isset($_POST["search"])){
    
    if($valueOfSearch == ""){
        echo "";
    }else{

        $sqlKnowledge = "SELECT * FROM   knowledge_base where keyword LIKE :search OR
        title LIKE :search OR description LIKE :search ";
        $sqlKnowledgeResult = $pdo->prepare($sqlKnowledge);
        $sqlKnowledgeResult->bindValue(":search", '%' . $valueOfSearch . '%');
        $sqlKnowledgeResult->execute();
        $sqlKResult = $sqlKnowledgeResult->fetchAll(PDO::FETCH_ASSOC);

        if ($sqlKnowledgeResult->rowCount() > 0) {
            echo "<h2 align='center'>Knowledge Base Results</h2>";
            echo "<table cellspacing='2' border='3' align='center'>
                <tr>
                    <td>
                        <strong>
                            Title
                        </strong>
                    </td>
                    <td><strong>Author</strong></td>
                    <td><strong>Description</strong></td>
                </tr>";
                foreach ($sqlKResult as $row) {
                    $itemIdK = $row['id'];
                    echo "<tr>
                        <td><a href='FULLdis.php?type=knowledge&id={$itemIdK}'>{$row['title']}</a></td>
                        <td>{$row['ProName']}</td>
                        <td>{$row['description']}</td>
                    </tr>";
                }
                echo "</table>";
        }
    }
}


?>