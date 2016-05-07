<!--<link rel="stylesheet" type="text/css" href="bootstrap.css">-->
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<input type="button" value = "back" onclick="back()" class="btn btn-default">

 <link rel="stylesheet" href="bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>
function back()
   {
           window.location.href = "afterlogin.php";
   }

</script>
<?php
session_start();
include 'db_connect.php';
$currentuserid = $_SESSION['userid'];
$currentusername = $_SESSION['userkanaam'];
echo "<h2>Welcome ".$currentusername."</h2>";
//echo '<br>This page is to model messages';



if(isset($_POST['hiddensub']))
{
  $sub =  $_POST['hiddensub'];
  //echo ("body ".$_POST['hiddenbody']);
 $body = $_POST['hiddenbody'];
  // echo $_POST['hiddencat'];
  $categoryname = $_POST['hiddencat'];
 //echo $_POST['hiddenvisibility'];
  $access = $_POST['hiddenvisibility'];
  //we need to get the category id here
  $stmt = $conn->prepare("select C_Id from Category where C_Name = ?");
  $stmt->bind_param("s",$categoryname);
  $stmt->execute();
  $stmt->bind_result($var1);
    /* fetch value */

   if( $stmt->fetch())
   {
     $catid = $var1;
   }
  $stmt->close();
$time = date("Y-m-d H:i:s");
 
 //echo $currentuserid."    ".$sub."    ".$catid."    ".$access."     ".$time;
  
  $stmt = $conn->prepare("insert into Thread (Author, Subject, C_Id, New_Member_Access, Time_of_Creation) values (?,?,?,?,?)");
  $stmt->bind_param("isiis",$currentuserid,$sub,$catid,$access,$time);
  if($stmt->execute())
    echo 'sucessfully inserted';
  else 'message send failure';
  $stmt->close();
  
   $stmt = $conn->prepare("insert into Message_content  (U_Id, Time_of_Reply, Body) values (?,?,?)");
  $stmt->bind_param("iss",$currentuserid,$time,$body);
  if($stmt->execute())
    echo 'sucessfully inserted';
  else 'message send failure';
  $stmt->close();

$query = "select T_Id from Thread where Time_of_Creation = '$time'";
  $result= $conn->query($query);
  if($result->num_rows>0)
  {
    $row = $result->fetch_assoc();
    $threadvar = $row['T_Id'];
  }
 //echo("<br>thread id is".$threadvar."<br>");
 $choice = $_POST['hiddenfirstoption'];
  if($choice == 'Private')
  {
  $sub_choice = $_POST['hiddenfirstoption1'];
  //echo $sub_choice;
    $var = explode(",",$sub_choice);
    $result = count($var);
    for($i =0;$i<$result-1;$i++)
    {
      $sub_var = explode(";",$var[$i]);
       $result1 = count($sub_var);
       for($j =0;$j<$result1;$j++)
       {
        // echo $sub_var[$j];
       }
     
      $query4 = "select l.U_Id as UID from Login l,User_profile p where l.U_Id = p.U_Id and l.Username = '$sub_var[0]' and p.Username = '$sub_var[1]'";

      $res = $conn->query($query4);
      if($res->num_rows>0)
      {
      $row= $res->fetch_assoc();
        $useridforthisthread = $row['UID'];
        //echo ("User Id is ".$useridforthisthread);
      }
      echo "<br>";

     $stmt3 = $conn->prepare("insert into Recipient values (?,?)");
     $stmt3->bind_param("ii",$threadvar,$useridforthisthread);
    
     if($stmt3->execute())
      echo 'inserted sucessfully';
     else echo 'insert failure';
      $stmt3->close();
    }
  }
  if($choice == 'Block Members')
  {
    
   // echo 'block members selected';
    $query = "select Block_Id from User_profile where U_Id = $currentuserid and Block_Request_Accepted = 1";
    $resultkiran1 = $conn->query($query);
    if($resultkiran1->num_rows>0)
    {
      $row= $resultkiran1->fetch_assoc();
    $userblockid = $row['Block_Id'];
  //  echo 'the user is from block '.$userblockid;
    }
    
    $query = "select U_Id from User_profile where U_Id <> $currentuserid and Block_Request_Accepted = 1 and Block_Id = $userblockid";
    $resultkiran2 = $conn->query($query);
    if($resultkiran2->num_rows>0)
    {
      while($row= $resultkiran2->fetch_assoc())
      {
        $stmt3 = $conn->prepare("insert into Recipient values (?,?)");
     $stmt3->bind_param("ii",$threadvar,$row['U_Id']);
    
     if($stmt3->execute())
      echo 'inserted sucessfully';
     else echo 'insert failure';
      }
      $stmt3->close();
    }
    
    
  }
  if($choice == 'Neighbors')
  {
    $query = "select Block_Id from User_profile where U_Id = $currentuserid and Block_Request_Accepted = 1";
    $resultkiran1 = $conn->query($query);
    if($resultkiran1->num_rows>0)
    {
      $row= $resultkiran1->fetch_assoc();
    $userblockid = $row['Block_Id'];
   // echo 'the user is from block '.$userblockid;
    }
    $query = "select To_Id from Neighborhood where  From_Id = $currentuserid";
    $resultkiran2 = $conn->query($query);
    if($resultkiran2->num_rows>0)
    {
      while($row= $resultkiran2->fetch_assoc())
      {
        $stmt3 = $conn->prepare("insert into Recipient values (?,?)");
     $stmt3->bind_param("ii",$threadvar,$row['To_Id']);
    
     if($stmt3->execute())
      echo 'inserted sucessfully';
     else echo 'insert failure';
      }
      $stmt3->close();
    } 
  }
  if($choice == 'Friends')
  {
      echo 'friends selected';
    $query = "select Block_Id from User_profile where U_Id = $currentuserid and Block_Request_Accepted = 1";
    $resultkiran1 = $conn->query($query);
    if($resultkiran1->num_rows>0)
    {
      $row= $resultkiran1->fetch_assoc();
    $userblockid = $row['Block_Id'];
   // echo 'the user is from block '.$userblockid;
    }
    $query = "select Acceptor from Request_For_Friendship where Sender = $currentuserid and Status = 'accepted'" ;
    $resultkiran2 = $conn->query($query);
    if($resultkiran2->num_rows>0)
    {
      while($row= $resultkiran2->fetch_assoc())
      {
        $stmt3 = $conn->prepare("insert into Recipient values (?,?)");
     $stmt3->bind_param("ii",$threadvar,$row['Acceptor']);
    
     if($stmt3->execute())
      echo 'inserted sucessfully';
     else echo 'insert failure';
      }
      $stmt3->close();
    } 
    
  }
  
  else echo $choice;
  
}
?>

<button type="button" class="btn btn-default" id="myBtn1">Create Thread</button>
<button type="button" class="btn btn-default" id="myBtn2"  onclick="viewthread()">View Thread</button>

<script>
function viewthread()
  {
    window.location.href = "seethreads.php";
  }
</script>

<div class="modal fade" id="myModalsignup" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-envelope"></span> Thread</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" method="post" action="managemessages.php" id="composeform">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-pencil"></span> Subject:</label>
              <input type="text" class="form-control" id="s" placeholder="Enter subject" name = "msgsubject" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-list-alt"></span> category:</label>
              <select class="form-control" id="selectid">
              <?php
              $query = "select C_Name from Category";
              $result= $conn->query($query);
              if($result->num_rows>0)
              {
                while($row = $result->fetch_assoc())
                {
                  echo("<option>". $row['C_Name']."</option>");
                }
              }
              
              ?>
              </select>
              <br>
               </div>
           <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-user"></span> Send to:</label>
              <select class="form-control"  id="selectid1" onchange="onchangefunction()">
             <option>Block Members</option>
               <option> Neighbors</option>
               <option>Friends</option>
               <option>Private</option>
              </select>
              <br>
               </div>
           
           <style>
           #specialblock
 {
  display: none; !important
 }
           
           </style>
           <div class="form-group" id="specialblock">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Select Recepients:</label>
              <select class="form-control" multiple  id="multipleselect">
               <option selected="selected">default</option>
               <?php
               $query = "select l.Username as A,p.Username as B from Login l, User_profile p where l.U_Id= p.U_Id and l.U_Id<>$currentuserid";
               $result= $conn->query($query);
               if($result->num_rows>0)
               {
                while($row=$result->fetch_assoc())
                {
//                 $name1= $row['l.Username'];
//                 $name2 =$row['p.Username'];
                 $name1= $row['A'];
                 $name2 =$row['B'];
                 $cont = "<option>".$name1 .";".$name2."</option>";
                 echo $cont;
               
                }
               }
               
               ?>
              </select>
              <br>
            Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.
               </div>
           
           <script>
           function onchangefunction()
            {
             var v = document.getElementById('selectid1').value;
             var comp = "Private";
             var n = v.localeCompare(comp);
             if(n==0)
             {
              document.getElementById('specialblock').style.display='block';
             }
             else
              {
               document.getElementById('specialblock').style.display='none';
              }
            }
           </script>
           
           
           
           
              <div class="checkbox">
  <label>
    <input type="checkbox" value="" id="check">
     Visible to new members
  </label>
</div>
           
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-tag"></span> Content:</label>
            <textarea rows="4"  id="area" cols="50"  class="form-control" placeholder="Enter message here...(upto 500 characters)" required>

</textarea>
              
            </div>
              <button type="submit" class="btn btn-success btn-block" name="submitbutton" onclick="send()"><span class="glyphicon glyphicon-ok"></span> Post</button>
            <input type="hidden" id="hiddensub" name="hiddensub">
            <input type="hidden" id="hiddenbody" name="hiddenbody">
            <input type="hidden" id="hiddencat" name="hiddencat">
            <input type="hidden" id="hiddenvisibility" name="hiddenvisibility">
           <input type="hidden" id="hiddenfirstoption" name="hiddenfirstoption">
            <input type="hidden" id="hiddenfirstoption1" name="hiddenfirstoption1">
          </form>
        </div>
      </div>
    </div>
  </div> 



<script>
  function send()
  {
  
   
    
    document.getElementById('hiddensub').value = document.getElementById('s').value;
     document.getElementById('hiddenbody').value = document.getElementById('area').value;
    document.getElementById('hiddencat').value = document.getElementById('selectid').value;
   document.getElementById('hiddenfirstoption').value = document.getElementById('selectid1').value;
 
    if(document.getElementById('check').checked)
    document.getElementById('hiddenvisibility').value = 1;
    else
      document.getElementById('hiddenvisibility').value = 0;
       
    

    var multipleoption = document.getElementById('multipleselect');
    var x = multipleoption.length;
    var c = multipleoption.children;
    var txt = "";
    for (i = 0; i < x; i++) {
      if(c[i].selected)
        txt = txt + c[i].value + ",";
    }
 document.getElementById('hiddenfirstoption1').value =txt;   
    
  }
$(document).ready(function(){
    $("#myBtn1").click(function(){
        $("#myModalsignup").modal();
    });
});
  function myfun()
  {
    $("#myModal").close;
  }
</script>