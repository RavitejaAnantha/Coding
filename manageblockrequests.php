<link rel="stylesheet" type="text/css" href="bootstrap.css">
<input type="button" value="back" onclick="goback()" class="btn btn-primary">
<script>
function goback()
  {
     window.location.href = "afterlogin.php";
  }

</script>
<?php
session_start();
include 'db_connect.php';
$currentusername = $_SESSION['userkanaam'];
$currentuserid = $_SESSION['userid'];

if(isset($_POST['accepthidden']))
{
   echo 'this is set';
   $touser = $_POST['accepthidden'];
   $query = "select U_Id from Login where Username = '$touser'";
   $result2 = $conn->query($query);
   if($result2->num_rows>0)
   {
      $row5= $result2->fetch_assoc();
      $temp7= $row5['U_Id'];
   }
   echo 'id is '.$temp7;
   $timeofacceptance = date("Y-m-d H:i:s");

   //$time = now();
   $myquery = "update Request_For_Joining_Block set Request_Status = 'accepted', Time_Of_Acceptance = '$timeofacceptance' where  U_Id_Sender = $temp7 and U_Id_Acceptor = $currentuserid ";
   echo $myquery;
   $conn->query($myquery);
   
}
echo '<h3>Welcome '.$currentusername."<br></h3>";
if(isset($_POST['hiddenfield1']))
{
   $touser = $_POST['hiddenfield1'];
   
   $query = "select U_Id from Login where Username = '$touser'";
   $result2 = $conn->query($query);
   if($result2->num_rows>0)
   {
      $row1= $result2->fetch_assoc();
      $temp1= $row1['U_Id'];
   
   $query = "select Block_Id from User_profile where U_Id= $temp1 and Block_Request_Accepted = 1";
    //  echo $query;
      $result1 = $conn->query($query);
      $major1= $result1->num_rows;
      if($major1>0)
      {
         $row = $result1->fetch_assoc();
         $block= $row['Block_Id'];
      
   
   echo 'we need to do something here '.$touser;
//         echo ("<br>".$currentuserid."<br>".$temp1."<br>".$block."<br> end of test");
   //write the insert query
   $stmt3 = $conn->prepare("insert into Request_For_Joining_Block values ($currentuserid,$temp1,$block,'0000-00-00 00:00:00','pending',now())");
   if($stmt3->execute()) echo'single insert successful';
   else 'single insert failure';
   }
     
}
   
}
if(isset($_POST['hiddenfield']))
{
   //count for pending requests
   
   $stmt = $conn->prepare("select U_Id from Login where U_Id in (select U_Id from User_profile where U_id<> '$currentuserid' and Block_Request_Accepted = 1 and Block_Id = (select Block_Id from User_Profile where U_Id = '$currentuserid' ))");
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
   $major = $num_of_rows;
   
   
   
if($num_of_rows>0)
{
  // echo 'number of rows :'.$num_of_rows;
   while($row = $result->fetch_assoc())
   {
     $temp = $row['U_Id'];
     // echo $temp;
      $query = "select Block_Id from User_profile where U_Id= $temp";
    //  echo $query;
      $result1 = $conn->query($query);
      $major1= $result1->num_rows;
      if($major1>0)
      {
         $row = $result1->fetch_assoc();
         $block= $row['Block_Id'];
        // echo $block;
        $query1 = "insert into Request_For_Joining_Block values ($currentuserid,$temp,$block,'0000-00-00 00:00:00','pending',now())";
        // echo "<br>".$query1;
         
         if($conn->query($query1)) $flag = 'true';
         else $flag = 'false';
         
      }   
   }
   if($flag=='true') echo '<br>success';
   else echo '<br>failure';
}
    else echo '<br>There are no users in this block';
   
}
?>
<br>Do you want to send a block joining request to all the block members?
<form method="post" action="manageblockrequests.php" id="formrequest">
   <br>
<input type="button" id="sendtoall" name="sendtoall" onclick="sendtoallmembers()" value="Send Request" class="btn btn-primary">
<input type="hidden" name="hiddenfield" id="hiddenfield">
</form>
<script>
function sendtoallmembers()
   {
     // alert('yuo are about to send requests to all the block members');
      document.getElementById('hiddenfield').value='all';
      document.getElementById('formrequest').submit();
   }

</script>
<?php
$stmt = $conn->prepare("select Username from Login where U_Id in (select U_Id from User_profile where U_id<> '$currentuserid' and Block_Request_Accepted = 1 and Block_Id = (select Block_Id from User_Profile where U_Id = '$currentuserid' ))");
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if($num_of_rows>0)
{
echo ' Members of my block: <select id = "neighborselect"> <option selected>neighbor</option>';
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


<?php
$stmt = $conn->prepare("select Username from Login where U_Id in (select U_Id from User_profile where U_id<> '$currentuserid' and Block_Request_Accepted = 1 and Block_Id = (select Block_Id from User_Profile where U_Id = '$currentuserid')) and U_Id not in (select U_Id_Acceptor from  Request_For_Joining_Block where U_Id_Sender = '$currentuserid') ");
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if($num_of_rows>0)
{
  // echo "<br>Do you want to send a block joining request to a particular block member?";
   echo( "<form method='post' action='manageblockrequests.php' id='formrequest1'>");

echo (" <br>Can Request: <select id = 'neighborselect1'> <option selected>neighbor</option>");
   while ($row = $result->fetch_assoc()) {
        echo "<option>".$row['Username']."</option>";
   }
   /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
echo "</select>";
   echo ("<br><br><input type='button' id='sendtoone' name='sendtoone' onclick='sendtoonemember()' value='Send Request' class='btn btn-primary'>");
echo ("<input type='hidden' name='hiddenfield1' id='hiddenfield1'>");
echo ("</form>");
}
?>

<script>
function sendtoonemember()
  
   {  document.getElementById('hiddenfield1').value=document.getElementById('neighborselect1').value;
      if(document.getElementById('neighborselect1').value=='neighbor')
      {
         alert('please select a neighbor to continue');
      }
    else{
      alert('yuo are about to send request to one of the block member');
       document.getElementById('formrequest1').submit();
     
     // document.getElementById('formrequest1').submit();
    }
   }
</script>

<?php

$query = "select Username from Login where U_Id in (select U_Id_Sender from Request_For_Joining_Block where U_Id_Acceptor = '$currentuserid' and Request_Status = 'pending')";
$result3 = $conn->query($query);
$rowcount = $result3->num_rows;
if($rowcount>0)
{
    echo 'Pending Block Requests: <select id = "pendingrequests"><option>neighbor</option>';
   while($row4 = $result3->fetch_assoc())
   {
   
  echo "<option>".$row4['Username']."</option>";
   
   }
   echo '</select>';
   echo '<br><br><input type="button" value="Accept Request" id= "acceptbutton" name= "acceptbutton" onclick="acceptrequest()" class="btn btn-primary">';
}

?>
<form id="acceptform" name="acceptform" method="post" action="manageblockrequests.php">
<input type="hidden" name="accepthidden" id="accepthidden">
</form>
<!--<input type="button" value="Accept Request" id= "acceptbutton" name= "acceptbutton" onclick="acceptrequest()">-->
<script>
function acceptrequest()
   {
      if(document.getElementById('pendingrequests').value == 'neighbor')
         {
            alert('please choose a request to respond');
         }
      else{
      document.getElementById('accepthidden').value = document.getElementById('pendingrequests').value;
         document.getElementById('acceptform').submit();
   
         }
   }

</script>