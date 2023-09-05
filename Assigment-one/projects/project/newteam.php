<?php 
session_start();
include "db.php";

$msgs="";
if($_SERVER["REQUEST_METHOD"] == "POST" ){
    $teamname=$_POST["teamname"];
    $sqlstatment="select teamname from team t where t.teamname = :teamname";
    $run=$db->prepare($sqlstatment);
    $run->bindValue(":teamname" , $teamname);
    $run->execute();
    if($run->rowCount() >0 ){
        $msgs="Team name is already existed !";
    }else{
        $skillLevel=$_POST["level"];
        $gameday=$_POST["gameday"];
        // echo $gameday;
        $numberofplayer=$db->prepare("update team set numofplayer = 0  where teamname=:teamname");
        $numberofplayer->bindValue(":teamname" , $teamname);
        $numberofplayer->execute();

        if(($skillLevel >=1) && ($skillLevel <=5)){
            $sql="insert into team (teamname ,game_day,skill,emailFk) values (:teamname,:game_day,:skill,:email)";
            $run=$db->prepare($sql);
            $run->bindValue(":teamname" , $teamname);
            $run->bindValue(":game_day" , $gameday);
            $run->bindValue(":skill" , $skillLevel);
            $run->bindValue(":email" , $_SESSION["email"]);
            $run->execute();
            $_SESSION["teamname"]=$teamname;
           echo "Done !";
        }else{
        $msgs="skill Level must between 1-5 !";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newteam.css"/>
    <title>Document</title>
</head>

<body>
<div id="wrapper">
<header>
    <figure>
    <img src="WebLogo.png" alt="WebLogo">
    </figure>    <strong>THE KING</strong>
    <a href="logout.php">Log Out</a>
    <a href="aboutus.html">About Us</a>
    <figure>
    <img src="myphoto.jpg" alt="Photo" id="profilepic" style="width: 50px; height: 50px;">
    </figure>    <b><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></b>
</header>
<div id="container">
    <div id="main">
        <form method="post" action="">
        <h2>New Team</h2>
        <a href="dashboard.php">dash board page</a><br><br>
            <table border="1" cellspacing="0">
                <tbody>
                    <tr>
                        <td>Team Name:</td>
                        <td colspan="2">
                        <input type="text" name="teamname" placeholder="Funny people" required >
                        <?php if($msgs == "Team name is already existed !"){ ?>
                                <span class="msgserror"><?php echo $msgs;?></span>
                                <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td>Skill Level(1-5):</td>
                        <td colspan="2"><input type="number" name="level" placeholder="2" required >
                        <?php if($msgs == "skill Level must between 1-5 !"){ ?>
                                <span class="msgserror"><?php echo $msgs;?></span>
                                <?php }?>
                    </td>
                    </tr>
                    <tr>
                        <td>Game Day:</td>                 
                        <td><input type="text" name="gameday" placeholder="sunday" required ></td>
                    </tr>
                </tbody>
                <tr>
                <td colspan="2"><input type="submit" name="submit" id="sendButtom"></td>
                    </tr>
            </table></div>
        </form>
    

        <nav>
            <ul>
            <li>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li>
                            <a href="newteam.php" >Create Team</a>
                        </li>
                        <li>
                            <a href='edit.php'>Edit Team</a>
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