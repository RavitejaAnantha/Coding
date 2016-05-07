<style>
  #backbutton{
    margin-top: 10px;
  }


</style>
&nbsp;&nbsp;<input type="button" value="back" onclick="goback()" class="btn btn-success" id="backbutton">
<link rel="stylesheet" type="text/css" href="bootstrap.css">
<script>
function goback()
  {
     window.location.href = "afterlogin.php";
  }

</script>

<?php
session_start();
//echo ($_SESSION['userid']);
$id = $_SESSION['userid'];
$nameoftheuser = $_SESSION['userkanaam'];
include 'db_connect.php';
echo "<br>&nbsp;<h3>Welcome ".$nameoftheuser.", This is your profile page</h3> <br>";

 $query = "select * from User_profile where U_Id=$id";
    $res = $conn->query($query);
    if($res->num_rows>0)
    {
       $row = $res->fetch_assoc();
       $d= date($row['Date_Of_Birth']);
        $d= explode(" ",$d);
//      echo ('gender is '.$row['Gender']);
//      if($row['Gender']=='male')
//      {
//
//      }
?>
<style>
      #map {
        left: 40px;
        width: 500px;
        height: 400px;
         border: 1px solid black;
      }
  #map:hover
  {
    border: 2px solid gray;
  }
  #myimg{
    position: fixed;
    left: 600px;
    top: 78px;
    width: 270px; 
      height:250px;
    border: 1px solid black;
  }
  #picbutton
  {
    position: fixed;
    left: 690px;
    top: 330px;
  }
  #myimg:hover
  {
    border: 2px solid gray;
  }
  td{
    padding-top: 10px;
  }
  .moveleft
  {
    margin-left: 40px;
  }

    </style>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBfd_t-yCoHmt8Tb3BobKI___rK_QW5Q9A"></script>
    <script>
      function initialize() {
        var mapCanvas = document.getElementById('map');
          var myLatLng = {lat: <?php  echo $row['Latitude'] ?>, lng: <?php  echo $row['Longitude'] ?>};
        var mapOptions = {
          center: myLatLng,          
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions);
          var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    animation:google.maps.Animation.BOUNCE,
    title: 'Hello World!'
  });
        //map onclick listener
         marker.addListener('click', function(event) {
           var infowindow = new google.maps.InfoWindow({
    content: 'This is the location of your home.'
  });
        //   alert("hamayya");
           
    infowindow.open(map, marker);
           
  });
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<body><br>
  <body>
    <div id="boxdiv">
<img src="displaypic.php" alt="Sorry! You have not uploaded your image yet" id="myimg"/>

  
    <div id="map"></div>
    </div>
    </body>
   <br>
  <div class="moveleft">  <input type="button" name="changemap" value="Edit Location" onclick="changeloc()" class="btn btn-success">
<input type="button" value="Edit Profile" onclick="caneditthis()" id="editbutton" class="btn btn-success">
  <input type="button" name="changepic" value="Edit Picture" onclick="changepic()" id="picbutton" class="btn btn-success">
<form method="post" action="manageprofile.php" >
  <br>
  <table>
    <tr>
      <td>Name:</td><td><input type="text" name="name"  id="text1" value="<?php echo $row['Username'];?>" disabled><br></td>
 
    </tr>
    <tr>
      <td>Gender:</td><td><input type="radio" name="gender" value="male" disabled id="radio1" <?php  if($row['Gender']=='male') echo 'checked';?> disabled>&nbsp;Male
<input type="radio" name="gender" value="female" disabled id="radio2"  <?php  if($row['Gender']=='female') echo 'checked';?> disabled>&nbsp;Female
   <br></td>
 
      </tr>
    <tr>   <td>Date of Birth:</td><td> <input type="date" name="dob" id="dobid" value="<?php   
        echo $d[0]; ?>" disabled><br></td>
      </tr>
<tr>
  <td> Description: </td><td><textarea name="desc" rows="4" cols="50"  disabled id="idfortextarea">

   <?php $row['U_Description'] = trim($row['U_Description']); echo $row['U_Description'];?>
</textarea>

   </td>
  </tr>
    <tr>
      <td>
  Apartment No:</td><td><input type="text" name = "aptno" id="aptno"  value="<?php echo $row['Apt_No'];?>" disabled></td>
      </tr>
    <tr>
      <td>
   Building No:</td><td><input type="text"  name = "bno" id="bldno" value="<?php echo $row['Building_No'];?>" disabled ></td>
      </tr>
  </table>
  
  <br>
  <input type="submit" name = "update" value="update" class="btn btn-success">
</form>
    </div>

</body>

<?php
      if($row['Gender']=='Male') { ?><script>
alert("user is male");
document.getElementById('radio1').checked= true;  </script>
<?php }
      if($row['Gender']=='Female'){ ?><script>
alert("user is female");
document.getElementById('radio2').checked= true;  </script>
<?php }
      
          }

else{ echo "no profile yet for the user"; 
    ?>
    <?php
    }
//echo ("<br>Do you want to create a profile now? <input type='button' value='click me!'>");
       ?>

<script>
function caneditthis()
  {
     if( document.getElementById('editbutton').value=='Edit Profile'){
        alert('you clicked me '+document.getElementById('editbutton').value );
     var mytextbox =  document.getElementById('text1');
     mytextbox.disabled=false;
     mytextbox.focus();
     document.getElementById('radio1').disabled=false;
     document.getElementById('radio2').disabled=false;
     document.getElementById('dobid').disabled=false;
     document.getElementById('idfortextarea').disabled=false;
//     document.getElementById('selectidblock').disabled=false;
//     document.getElementById('selectidhood').disabled=false;
     document.getElementById('aptno').disabled=false;
     document.getElementById('bldno').disabled=false;
    // document.getElementById('editbutton').value='lock';
     return;
     }
       if( document.getElementById('editbutton').value=='lock'){
          alert('you clicked me '+document.getElementById('editbutton').value );
     var mytextbox =  document.getElementById('text1');
     mytextbox.disabled=true;
     mytextbox.focus();
     document.getElementById('radio1').disabled=true;
     document.getElementById('radio2').disabled=true;
     document.getElementById('dobid').disabled=true;
     document.getElementById('idfortextarea').disabled=true;
     document.getElementById('aptno').disabled=true;
     document.getElementById('bldno').disabled=true;
     document.getElementById('editbutton').value='Edit Profile';
     return;
     } 
  }
  function submitclicked(){
     var mytextbox =  document.getElementById('text1');
     var radio1 =  document.getElementById('radio1');
     var radio2 =   document.getElementById('radio2');
     var gender='';
     if(radio1.checked == true)  gender='male';
     if(radio2.checked == true ) gender='female';
     var entereddate = document.getElementById('dobid').value;
      var des = document.getElementById('idfortextarea').value;
      var apt = document.getElementById('aptno').value;
      var bld = document.getElementById('bldno').value;
     alert(mytextbox.value+' is ' + gender+ entereddate+ des+ apt+bld);
  }
  function changeloc()
  {window.location.href = "hamayya.php"+ '#' +  '<?php echo $row['Latitude'];?>'+'#'+'<?php echo $row['Longitude'];?>';
    //alert('you clicked me');
  }
  function changepic()
  {
    window.location.href= "yesimage.php";
  }
</script>
<?php

if(isset($_POST['update'])){
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];
  $desc = $_POST['desc'];
  $aptno = $_POST['aptno'];
  $flatno = $_POST['bno'];
  
 // echo $name.$gender.$dob.$desc.$aptno.$flatno;
  $stmt = $conn->prepare("update User_profile set  Username = ?, Gender = ?, Date_Of_Birth = ?, U_Description = ?, Apt_No = ?, Building_No = ?, Time_Of_Updation = now() where U_Id = ?");
$stmt->bind_param("ssssiii", $name,$gender,$dob,$desc,$aptno,$flatno,$id);
if($stmt->execute()) echo ' profile updated sucessesfully';
  else echo 'update failure'; 
}
?>