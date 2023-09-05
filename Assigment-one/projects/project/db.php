 <?php
$dbhost = 'localhost';
$dbusername = 'root';
$dbuserpassword = '';
$database = 'webproject';
try{
    $db = new PDO("mysql:host=$dbhost;dbname=$database",$dbusername,$dbuserpassword);
}catch(PDOException $e){
    die($e->getMessage());
}
?> 