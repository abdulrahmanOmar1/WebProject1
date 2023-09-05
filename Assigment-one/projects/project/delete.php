<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET["id"];
    $sql = "DELETE FROM team WHERE id = :id";
    $statement = $db->prepare($sql);
    $statement->bindValue(":id", $id);
    $statement->execute();
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="delete.css" />

    <title>delete page</title>
</head>

<body>
    <div class="container">
        <h1>Delete Team</h1>
        <form method="post" action="">
            <div class="form-group">
                <label>Are you sure you want to delete the team?</label>
            </div>
            <div class="form-group">
                <input type="submit" name="delete" value="Delete">
            </div>
        </form>
    </div>
</body>

</html>