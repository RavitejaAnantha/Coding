 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<input type="button" value = "back" onclick="back()" class="btn btn-default">

 <link rel="stylesheet" href="bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>
function back()
   {
           window.location.href = "managemessages.php";
   }

</script>
<style>
.messageabstract
 {
  border-radius: 5px;
    
  margin-top: 5px;
  background: #CCCC99;
  margin-left: 5px;
  width: 200px;
  display: fixed;
  color: #000;
  transition: background 0.3s 0s, color 0.5s 0s;
 }
.messageabstract:hover
 {
  background: #666633;
  color: #fff;
/*  border: 2px solid #66a3ff;*/
 }
 body
 {
  background: #fff;
 }
 h2{
  color: #000;
 }
 #hidden{
  display: none;
 }


</style>
<?php
session_start();
include 'db_connect.php';
$currentuserid = $_SESSION['userid'];
$currentusername = $_SESSION['userkanaam'];
echo ("<h2>".$currentusername.", You can see threads here.</h2>");
$query = "select T_Id from Recipient where U_Id = $currentuserid union select T_Id from Thread where Author = $currentuserid";
$res = $conn->query($query);
if($res->num_rows>0)
 while($row = $res->fetch_assoc())
 {
  $threadid = $row['T_Id'];
  
  $query2 = "select Author, Subject, C_Id from Thread where T_Id = $threadid ";
  $res2=$conn->query($query2);
  if($res2->num_rows>0)
  {
   while($row2= $res2->fetch_assoc())
   {
    $idofuser = $row2['Author'];
    $idofcat = $row2['C_Id'];
     $query3 = "select Username from User_profile where U_Id = $idofuser ";
  $res3=$conn->query($query3);
    $row3 =$res3->fetch_assoc(); 
    $query4 = "select C_Name from Category where C_Id = $idofcat ";
  $res4=$conn->query($query4);
    $row4 =$res4->fetch_assoc(); 
    echo ('<div id = "mydiv" class = "messageabstract " onclick="clickedme(this)">Author:<u> '.$row3['Username'].'</u><br> Subject: <u>'.$row2['Subject'].'</u> <br> Category: <u>'.$row4['C_Name'].'</u><u id="hidden">'.$threadid.'</u></div>');
   }
  }
}
?>
<script>
function clickedme(v)
 {
//  alert('clickedme');
 //var v= document.getElementById('mydiv');
   var c = v.children;
    var txt = "";
    for (i = 0; i < c.length; i++) {
        txt = txt + c[i].innerHTML+"!";
    }
  alert(txt);
  
 }


</script>