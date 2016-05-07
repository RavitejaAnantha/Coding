<?php
 // just so we know it is broken
 error_reporting(E_ALL);
session_start();
$uid = $_SESSION['userid'];

  $host="localhost";
$user="root";
$pass="";
$db="Project";
    $conn = new mysqli($host,$user,$pass,$db);
     $sql = "SELECT img FROM User_profile WHERE U_Id = $uid";

     $result = $conn->query($sql);
$row = $result->fetch_assoc();
     header("Content-type: image/jpeg");
echo $row['img'];
   //  echo mysql_result($result, 0);


//
// header("Content-type: text/plain");
//
// echo ("hi hello");
 ?>
<!--<img src="<?php   echo $row['img'];?>" >-->