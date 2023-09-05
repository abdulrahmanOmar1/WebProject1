<?php
session_start();
include "db.inc";

$type = $_GET["type"];
$id = $_GET["id"];

if($type == "knowledge"){
    $sql = "SELECT * FROM knowledge_base WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "<p>Article Title: {$result["title"]}</p>";
        echo "<p>Article Description: {$result["description"]}</p>";
        echo "<p>Article Body: {$result["body_text"]}</p>";
        $filePath = 'images/' . $result["relevant_imgvid"];
        echo "<p>Upload File: <a href='" . $filePath . "' download>" . $result["atricle_imgORvideo"] . "</a></p>";
        echo "<p>Article Author: {$result["ProName"]}</p>";
    } else {
        echo "ERROR";
    }
}else{

    $sql = "SELECT * FROM file_sharing WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $resultFData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultFData) {
        
        echo "<h2>file sharing Details</h2>";
        $filePath = 'images/' . $resultFData["upload_file"];
        echo "<p>Upload File: <a href='" . $filePath . "' download>" . $resultFData["upload_file"] . "</a></p>";
        echo "<p>Title: {$resultFData["Title_file"]}</p>";
        echo "<p>Description: {$resultFData["Description_file"]}</p>";
        echo "<p>Keywords: {$resultFData["Keywords_file"]}</p>";
    } else {
        echo "ERROR ";
    }

}
?>
