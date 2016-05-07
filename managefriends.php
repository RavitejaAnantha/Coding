<link rel="stylesheet" type="text/css" href="bootstrap.css">
<input type="button" value="back" onclick="goback()" class="btn btn-primary">
<script>
function goback()
  {
     window.location.href = "afterlogin.php";
  }
</script>

<?php
$temp = "";
include 'db_connect.php';
session_start();
$uid = $_SESSION['userid'];
if(isset($_POST['hiddenfriendname'])&& $_POST['hiddenfriendname1']!="")
{
   $name = $_POST['hiddenfriendname1'];
   echo 'reject button is clicked'.$name;
   $query = "update Request_For_friendship set status= 'rejected' where Acceptor= '$uid' and Sender=(select U_Id from Login where Username = '$name')";
   $conn->query($query);
}
if(isset($_POST['hiddenfriendname1'])&& $_POST['hiddenfriendname']!="")
{
   $name = $_POST['hiddenfriendname'];
   echo 'accept button is clicked'.$name;
   $query = "update Request_For_friendship set status= 'accepted' where Acceptor= '$uid' and Sender=(select U_Id from Login where Username = '$name')";
   $conn->query($query);
}

if(isset($_POST['nameofreceiver']))
{
   echo 'request sent to'.$_POST['nameofreceiver']."from " .$_SESSION['userid'];
  $touser = $_POST['nameofreceiver'];
   $query = "select U_Id from Login where Username = '$touser'";
   echo $query;
   $result = $conn->query($query);
   if($result->num_rows>0)
   {
   $row = $result->fetch_assoc();
       echo "iiiiiii".$row['U_Id'];
       $toid= $row['U_Id'];
   $fromid = $_SESSION['userid'];
   $status = 'pending';      
        // we should not resend requests
      $stmt = $conn->prepare("select * from Request_For_friendship where Sender = ? and Acceptor = ? and status!='rejected'");
   $stmt->bind_param("ss",$fromid,$toid);
   $stmt->execute();
   $result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if($num_of_rows>0)
{
   echo 'request already sent';
}
   else{

   $stmt = $conn->prepare("insert into Request_For_friendship (Sender,Acceptor,Request_Sent_Timestamp,Status) values (?,?,now(),?)");
   $stmt->bind_param("iis",$fromid,$toid,$status);
   $stmt->execute();
   }
   }
}

?>
<h3> Welcome <?php echo ($_SESSION['userkanaam']); ?></h3>
<?php
$idofthisuser  = $_SESSION['userid'];
//echo "This page is for managing friend requests<br><br><br><br>";
//$stmt = $conn->prepare("select Username from Login where U_Id <> (?) ");
//$stmt = $conn->prepare("select Username from Login where U_Id <> (?) and U_Id not in (select Acceptor from Request_For_friendship where status='accepted' and Sender = (?))");
$stmt = $conn->prepare("select Username from Login where U_Id <> (?) and U_Id not in (select Acceptor from Request_For_friendship where status='accepted' and Sender = (?)) and U_Id  not in (select Sender from Request_For_friendship where status='accepted' and Acceptor = (?))");
$stmt->bind_param("iii",$idofthisuser,$idofthisuser,$idofthisuser);
$stmt->execute();

$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if($num_of_rows>0)
{
echo ' Add Friend: <select id = "friendselect"> <option selected>friend</option>';
   while ($row = $result->fetch_assoc()) {
        echo "<option>".$row['Username']."</option>";
   }
   /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
echo "</select>";
}
else echo 'All the users of this website are your friends!';
?>
<form method="post" action="managefriends.php" id="myForm">
   <br>
<input type="hidden" name="nameofreceiver" id="nameofreceiver" required >
   Send Friend Request:
<input type="button" value="Send Request" onclick="sendrequest()" name= "submitbutton" class="btn btn-primary">
</form>

<script>
   
function sendrequest()
   {
      if(document.getElementById("friendselect").value=='friend') { alert('please choose a friend');}
      else{
         console.log(document.getElementById("friendselect").value);
      document.getElementById('nameofreceiver').value = document.getElementById("friendselect").value;
      document.getElementById("myForm").submit();
      }
   }

</script>
<?php
//$stmt = $conn->prepare("select Username from Login where U_Id in  (select r.Acceptor from Request_For_friendship r where r.Sender = ? and r.Status= 'accepted') ");
$stmt = $conn->prepare("select Username from Login where U_Id in  (select r.Acceptor from Request_For_friendship r where r.Sender = ? and r.Status= 'accepted' union select r.Sender from Request_For_friendship r where r.Acceptor = ? and r.Status= 'accepted' ) ");
$stmt->bind_param("ii", $idofthisuser,$idofthisuser);
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
echo ' My Friends: <select id = "friendselect"><option>friend</option> ';
   while ($row = $result->fetch_assoc()) {
      echo $row['Username'];
        echo "<option>".$row['Username']."</option>";
   }
   /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
echo "</select>";

echo '<br>';
/////////////////////////////
$stmt = $conn->prepare("select Username from Login where U_Id in  (select r.Sender from Request_For_friendship r where r.Acceptor = ? and r.Status= 'pending') ");
$stmt->bind_param("i", $idofthisuser);
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
echo '<br> Pending Requests: <select id = "friendselect1"><option selected>friend</option> ';
   while ($row = $result->fetch_assoc()) {
      echo $row['Username'];
        echo "<option>".$row['Username']."</option>";
   }
   /* free results */
   $stmt->free_result();
   /* close statement */
   $stmt->close();
echo "</select>";
?>

<br>
<br>
<input type="button" name="acceptrequest" id="acceptid" value="Accept Request" onclick="acceptid()" class="btn btn-primary">
<input type="button" name="rejectrequest" id="rejectid" value="Reject Request" onclick="rejectid()" class="btn btn-primary">
<br>
<form method="post" action="managefriends.php" id="myform2">
<input type="hidden" name="hiddenfriendname" id="hiddenfriendnameid" >
   <input type="hidden" name="hiddenfriendname1" id="hiddenfriendnameid1"  >
   </form>
<script>
function acceptid()
   {
      if(document.getElementById("friendselect1").value=='friend') {
        
         alert('please choose a friend to accept his request');}
      else{
         alert('button clicked');
          document.getElementById("hiddenfriendnameid").value=document.getElementById("friendselect1").value;
          document.getElementById("myform2").submit();
      }
   }
   function rejectid()
   {
      if(document.getElementById("friendselect1").value=='friend') { 
          
         alert('please choose a friend to reject his request');}
      else{
         alert('button clicked');
         document.getElementById("hiddenfriendnameid1").value=document.getElementById("friendselect1").value;
          document.getElementById("myform2").submit();
      }
   }
  

</script>