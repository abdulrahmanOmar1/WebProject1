<?php
session_start();
include "db.php";
$msgserror="";

if($_SESSION["boolean"] == true){
    $teamid = $_GET["idteam"];
    $name = $_GET["teamname"];
    
    $skill = $_GET["skill"];
    $game_day = $_GET["game_day"];
    $emailForgin = $_GET["email"];
    $photo=$_GET["photo"];
    echo'
    <html>
    <head>
        <link rel="stylesheet" href="descriptin.css">
    </head>
    <body>
    <div id="wrapper">
            <header>
            <figure>
            <img src="WebLogo.png" alt="WebLogo">
            </figure>
            <strong>THE KING</strong>
            <figure>
            <img src="myphoto.jpg" alt="Photo" id="profilepic" style="width: 50px; height: 50px;">
            </figure>
            <a href="logout.php">Log Out</a>
            <a href="aboutus.html">About Us</a>
            <b>' . $_SESSION["username"] . '</b>
            </header>
            <div id="container">
                <div id="main">

                        <p><h1>Team Details</h1></p>
                        <a href="dashboard.php">dashboard</a><br><br>
                        <table border="1">
                            <thead>
                                <th>Team Name</th>
                                <th>Skill Level</th>
                                <th>Game Day</th>
                                <th>Players</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>'.$name.'</td>
                                    <td>'.$skill.'</td>
                                    <td>'.$game_day.'</td>
                                    <td>';
                                    $run = $db->prepare("SELECT p.name, t.emailFK FROM player AS p JOIN team AS t on p.teamID = t.id WHERE p.teamID = :id");
                                    $run->bindValue(":id", $teamid);
                                    $run->execute();
                                    $result = $run->fetchAll(PDO::FETCH_ASSOC);
                                    if (!empty($result)) {
                                        echo "<ul>";
                                        foreach ($result as $playertable) {
                                            echo "<li>{$playertable["name"]}</li>";
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo "No player in team";
                                    }
                                    echo'</td>
                                </tr>
                            </tbody>
                        </table></div>
                        <nav>
                        <ul>
                            <li>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li>
                            <a href="newteam.php" >Create Team</a>
                        </li>
                        <li>
                            <a href="update.php?id='.$teamid.'&name='.$name.'&skill='.$skill.'&game_day='.$game_day.'">Edit Team</a>
                        </li>
                        </ul>
                        </nav>        
                        <div>
                        ';
                        
    if($emailForgin == $_SESSION["email"]){
        echo '<br>
        <div id="ll">
        <form method="post">
                <table border="1" cellspacing="0">
                    <tr>
                        <td>please inter player name:</td>
                        <td>
                            <input type="text" name="namePlayer" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                        <input type="submit" value="Add"  id="sendButtom">';
                        if($msgserror == "num of player must less or equale 9"){ 
                            echo'<span class="msgserror">';
                            echo $msgserror;
                        
                            echo'</span>';
                        }
                    echo' </td>
                    </tr>
                </table>
            </form>
            <a href="update.php?id='.$teamid.'&name='.$name.'&skill='.$skill.'&game_day='.$game_day.'">Edit</a><br>
            <a href="delete.php?id='.$teamid.'">Delete</a></div>
            <footer>
            <img src="WebLogo.png" alt="WebLogo">
            <p>&copy;2003 - 2023 The King. All Rights Reserved<br>Email: aboodomaral@gmail.com<br> Telephone number: +970-592-678-090 <br><a href="aboutus.html">About Us</a></p>
            </footer>
            </div>
            </body>
            </html>';


        if((isset($_POST["namePlayer"]))){
            $check = $db->prepare("select numofplayer from team where id=:id");
            $check->bindValue(":id", $teamid);
            $check->execute();
            $arr=$check->fetch(PDO::FETCH_ASSOC);

            if($arr["numofplayer"] <= 8){
            $namePlayer=$_POST["namePlayer"];
            $run = $db->prepare("INSERT INTO player (name,teamID) VALUES (:name, :teamID)");
            $run->bindValue(":name", $namePlayer);
            $run->bindValue(":teamID", $teamid);
            $run->execute();
            $updtae = $db->prepare("UPDATE  team set numofplayer=numofplayer + 1 where id=:teamID");
            $updtae->bindValue(":teamID", $teamid);
            $updtae->execute();
            }else{
                $msgserror ="num of player must less or equale 9";
                echo "num of player must less or equale 9";
            }
        }


    }else{
        echo '<br><footer>
        <img src="WebLogo.png" alt="WebLogo">
        <p>&copy;2003 - 2023 The King. All Rights Reserved<br>Email: aboodomaral@gmail.com<br> Telephone number: +970-592-678-090 <br><a href="aboutus.html">About Us</a></p>
        </footer>
        </body>
        </html>';
    }
    
}else{
    echo "Please login !";
}
