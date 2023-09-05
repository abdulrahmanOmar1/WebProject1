<?php
include "db.php";
session_start();

if ($_SESSION["boolean"] == true) {
    $email = $_SESSION["email"];
    $name = $_SESSION["username"];

    if (isset($email) && isset($name)) {
        $frun = $db->prepare("SELECT photo FROM  signlogin WHERE email = :E");
        $frun->bindValue(":E", $email);
        $frun->execute();
        $fresult = $frun->fetch(PDO::FETCH_ASSOC);
        $photo = $fresult["photo"];
        $_SESSION["photo"] = $fresult["photo"];

        echo '
        <!DOCTYPE html>
        <head>
            <link rel="stylesheet" href="DD.css"/>
            <title>Document</title>
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
                <b>' . $_SESSION["username"] . '</b>
            </header>
            <div id="container">
                <div id="main">';



        echo "<main><h2>Welcome," . $name . "</h2> <br>please select your team to edit :";

        $run = $db->prepare("SELECT * FROM  team");
        $run->execute();
        $result = $run->fetchAll(PDO::FETCH_ASSOC);
        if ($run->rowCount() > 0) {
            echo "
            <table border='1' cellspacing='0'>
            <thead>
                    <th>Team name</th>
                    </thead>
                    ";

            foreach ($result as $tableteam) {
                $id = $tableteam["id"];
                $nameOfTeam = $tableteam["teamname"];
                $game_day = $tableteam["game_day"];
                $skill = $tableteam["skill"];
                $emailFk = $tableteam["emailFk"];
                $numofplayer = $tableteam["numofplayer"];
                echo "
                <tr>
                    <td>
                        <a href='description.php?idteam={$id}&teamname={$nameOfTeam}&skill={$skill}&game_day={$game_day}&email={$emailFk}&photo={$photo}'>
                        {$nameOfTeam}
                        </a>
                    </td>
                </tr>";
            }
            echo "</table>";
            echo "<br>";
        } else {
            echo "<table border='1' cellspacing='0'>
            <tr>
                <th>Team name</th>
                <th>Skill level (1-5)</th>
            </tr> 
            </table>" . "<br>";
        }

        echo "</main></div>
        <nav>
            <ul class='ullist'>
                <li>
                            <a href='dashboard.php'>Dashboard</a>
                        </li>
                        <li>
                            <a href='newteam.php' >Create Team</a>
                        </li>
                        <li>
                            <a href='edit.php'>Edit Team</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <footer>
            <img src='WebLogo.png' alt='WebLogo'>
            <p>&copy;2003 - 2023 The King. All Rights Reserved<br>Email: aboodomaral@gmail.com<br> Telephone number: +970-592-678-090 <br><a href='aboutus.html'>About Us</a></p>
            </footer>
            </div>
            </body>
            </html>
            ";
    }
} else {
    echo " the error because you don't  login!!";
}
