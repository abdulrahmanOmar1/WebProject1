<?php
session_start();
include "db.php";
$msgs = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameInTable = $db->prepare("SELECT teamname FROM team");
    $nameInTable->execute();
    $r = $nameInTable->fetchAll(PDO::FETCH_ASSOC);
    foreach ($r as $teamtable) {
        if ($_POST["teamname"] == $teamtable["teamname"]) {
            $msgs = "this name already exist !";
            return;
        }
    }
    if (($_POST["skill"] >= 1) && ($_POST["skill"] <= 5)) {
        $id = $_GET["id"];
        $teamname = $_POST["teamname"];
        $skill = $_POST["skill"];
        $game_day = $_POST["game_day"];

        $run = $db->prepare("UPDATE team SET teamname=:teamname, skill=:skill, game_day=:game_day WHERE id = :id");
        $run->bindValue("id", $id);
        $run->bindValue(":teamname", $teamname);
        $run->bindValue(":skill", $skill);
        $run->bindValue(":game_day", $game_day);
        $run->execute();
        $_GET["name"] = $_POST["teamname"];
        $_GET["skill"] = $_POST["skill"];
        $_GET["game_day"] = $_POST["game_day"];
        $msgs = "Updated Successfuly";
    } else {
        $msgs = "skill Level must between 1-5 !";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="update.css" />
</head>

<body>

    <div id="wrapper">
        <header>
            <figure>
            <img src="WebLogo.png" alt="WebLogo">
            </figure>
            <strong>THE KING</strong>
            <a href="logout.php">Log Out</a>
            <a href="aboutus.html">About Us</a>
            <figure>
            <img src="myphoto.jpg" alt="Photo" id="profilepic" style="width: 50px; height: 50px;">
            </figure>
            <b> <?php echo $_SESSION["username"]; ?> </b>

        </header>

        <div id="container">
            <div id="main">
                <h2>Edit Team</h2>

                <form method="post" action="">
                    <a href="dashboard.php">dashboard page</a><br><br>
                    <table border="1" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>Team Name:</td>
                                <td colspan="2">
                                    <input type="text" name="teamname" value="<?php echo $_GET["name"]; ?>" required>
                                    <?php if ($msgs == "this name already exist !") { ?>
                                        <span class="msgserror"><?php echo $msgs; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Skill Level(1-5):</td>
                                <td colspan="2">
                                    <input type="number" name="skill" value="<?php echo $_GET["skill"]; ?>" required>
                                    <?php if ($msgs == "skill Level must between 1-5 !") { ?>
                                        <span class="msgserror"><?php echo $msgs; ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Game Day:</td>
                                <td>
                                    <input type="text" name="game_day" value="<?php echo $_GET["game_day"]; ?>" required>
                                </td>
                            </tr>
                        </tbody>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Update" id="sendButtom">
                            </td>
                        </tr>
                        <?php if ($msgs == "Updated Successfuly") { ?>
                            <span class="msgserror"><?php echo $msgs; ?></span>
                        <?php } ?>
                    </table>
                </form>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="dashboard.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="newteam.php">Create Team</a>
                    </li>
                    <li>
                        <a href="edit.php">Edit Team</a>
                    </li>
                </ul>
            </nav>
        </div>
        <footer>
            <img src="WebLogo.png" alt="WebLogo">
            <p>&copy;2003 - 2023 The King. All Rights Reserved<br>Email: aboodomaral@gmail.com<br> Telephone number: +970-592-678-090 <br><a href="aboutus.html">About Us</a></p>
        </footer>
    </div>
</body>

</html>