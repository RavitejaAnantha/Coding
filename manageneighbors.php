<link rel="stylesheet" type="text/css" href="bootstrap.css">
<input type="button" value="back" onclick="goback()" class="btn btn-success">
<script>
function goback()
  {
     window.location.href = "afterlogin.php";
  }

</script>
<?php
session_start();
include 'db_connect.php';
$currentuserid = $_SESSION['userid'];
if(isset($_POST['hiddenelement']))
{
   $toname = $_POST['hiddenelement'];
   //echo $toname;
   $stmt = $conn->prepare("select U_Id from Login where Username = ?");
   $stmt->bind_param("s",$toname);
   $stmt->execute();
   $result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if($num_of_rows>0)
{
   $row = $result->fetch_assoc();
   $toid = $row['U_Id'];
   
   $stmt1 = $conn->prepare("insert into Neighborhood values (?,?)");
   $stmt1->bind_param("ii",$currentuserid,$toid);
   if($stmt1->execute()) echo 'you have added him';
}
   
}
if(isset($_POST['hiddenelement1'])&&$_POST['hiddenelement1']!="")
{
   $removename = $_POST['hiddenelement1'];
   echo 'value is set to '.$removename ;
   $stmt = $conn->prepare("select U_Id from Login where Username = ?");
   $stmt->bind_param("s",$removename);
   $stmt->execute();
   $result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if($num_of_rows>0)
{
   $row = $result->fetch_assoc();
   $toid1 = $row['U_Id'];
echo 'value is set to '.$removename."and his id is ".$toid1 ;
    $stmt2 = $conn->prepare("delete from Neighborhood where From_Id = (?) and To_Id = (?)");
   $stmt2->bind_param("ii",$currentuserid,$toid1);
   if($stmt2->execute()) echo 'sucessfully removed from the friend list';   
}
   
}
echo '<h3>Welcome '.$_SESSION['userkanaam'].'</h3>';
//echo '<br>this is to manage neighbors<br>';

$stmt = $conn->prepare("select Username from Login where U_Id in (select U_Id from User_profile where U_id<> '$currentuserid' and Block_Request_Accepted = 1 and Block_Id = (select Block_Id from User_Profile where U_Id = '$currentuserid' )) and U_Id not in (select To_Id from Neighborhood where From_Id = '$currentuserid')");
 //minus (select To_Id from Neighborhood where From_Id = '$currentuserid')
$stmt->execute();

$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
//if($num_of_rows>0)
//{
echo ' Add Neighbor: <select id = "neighborselect"> <option selected>neighbor</option>';
   while ($row = $result->fetch_assoc()) {
        echo "<option>".$row['Username']."</option>";
   }
   /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
echo "</select>";
//}
$stmt = $conn->prepare("select Username from Login where U_Id in (select To_Id from Neighborhood where From_Id='$currentuserid' )");
$stmt->execute();

$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if($num_of_rows>0)
{

echo '<br> <br>My Neighbors: <select id = "neighborselect1"> <option selected>neighbor</option>';
   while ($row = $result->fetch_assoc()) {
        echo "<option>".$row['Username']."</option>";
   }
   /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
echo "</select>";
}
?>
<br>
<form id="neighborform" method="post" action="manageneighbors.php">
   <br>
<input type="button" name="addneighbor" id="addneighbor" value="Add Neighbor" onclick="addneighbors()" class="btn btn-success">
   <input type="button" name="removeneighbor" id="removeneighbor" value="Remove Neighbor" onclick="removeneighbors()" class="btn btn-success">
<input type = "hidden" name="hiddenelement" id="hiddenelement">
   <input type = "hidden" name="hiddenelement1" id="hiddenelement1">
</form>
<script>
function addneighbors()
   {
      if(document.getElementById('neighborselect').value == 'neighbor')
         {
            alert('please select a neighbor to continue');
         }
      else{
      
         document.getElementById('hiddenelement').value = document.getElementById('neighborselect').value;
         document.getElementById('neighborform').submit();
      }
   }
   
   function removeneighbors()
   {
      if(document.getElementById('neighborselect1').value == 'neighbor')
         {
            alert('please select a neighbor to continue');
         }
      else{
      alert (' remove clciked on the button'+document.getElementById('neighborselect').value);
         document.getElementById('hiddenelement1').value = document.getElementById('neighborselect1').value;
         document.getElementById('neighborform').submit();
      }
   }

</script>
