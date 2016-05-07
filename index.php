<?php
$err= "";
session_start();
include 'db_connect.php';
$time= time();
$date = date('Y-m-d H:i:s',$time);
if(isset($_POST['uname']))
{
    $user = $_POST['uname'];
    $pass = $_POST['pass'];
    $pass = md5($pass);
    $stmt = $conn->prepare("select U_Id,Username from Login where username = ? and password = ?");
  $stmt->bind_param("ss",$user,$pass);
   $stmt->execute();
$stmt->bind_result($var1,$var2);
    /* fetch value */

   if( $stmt->fetch())
   {
      $_SESSION['userid']= $var1;
     $_SESSION['userkanaam'] = $var2;
        header('location:afterlogin.php');
    }
    else $err= "wrong username/password";
}
if(isset($_POST['signupname']))
{
 // echo $_POST['signuppass'];
  //echo $_POST['signuppassre'];
  if($_POST['signuppass'] == $_POST['signuppassre'])
  {
    
  $tempuname = $_POST['signupname'];
  $tmeppass = $_POST['signuppass'];
    $tmeppass= md5($tmeppass);
  $tempemail = $_POST['signupemail'];
  $query = "select * from Login where username = '$tempuname'";
  $res = $conn->query($query);
  if($res->num_rows>0)
  {
    $err ="This username is existing, please choose another one";
  //echo $msg;
  }else{
    $stmt = $conn->prepare("insert into Login (Username,Password,Time_of_Signup,Email)values (?,?,?,?)");
    $stmt->bind_param("ssss",$tempuname,$tmeppass,$date,$tempemail);
//    $query = "insert into Login (Username,Password,Time_of_Signup,Email)values ('$tempuname','$tmeppass','$date','$tempemail')";
  //  if($conn->query($query))
    if($stmt->execute())
      $err=  "signed up sucessfully";
    else echo "there is some error in the query";
//     $query = $conn->prepare("insert into Login (Username,Password,Time_of_Signup,Email)values (?,?,?,?)");
//    $query->bind_param("ssss",$tempuname,$tmeppass,$date,$tempemail);
//    if($query-> execute())
//      $err=  "signed up sucessfully";
//    else echo "there is some error in the query";  
  }
  }
  else  $err ="passwords not matching";
}

?>
<html>
<head>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <link rel="stylesheet" href="bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
  <style>
    .myheader{
      position: relative;
      top: 20px;
      left: 350px;
    }
    .modal-content
    {
      border-radius: 30px;
    }
  .modal-header, h4, .close {
      background-color: #5cb85c;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
    div.bot_shadow{
	height:12px;
	background: #999;
	opacity:0.3;
	border-radius:100%;
	margin:10px 5px 0px 0px;
      padding-bottom: 5px;
      width: 500px;
      position: absolute;
      left: 540px;
}
    div.bot_shadow1{
	height:12px;
	background: #999;
	opacity:0.3;
	border-radius:100%;
	margin:10px 5px 0px 0px;
      padding-bottom: 5px;
      width: 500px;
      position: absolute;
      left: 35px;
}
    
    
    
  </style>
</head>
<body background="img.jpg">
<!-- <marquee scrollamount	= 30> <h1 class="myheader">Welcome to My_Neighborhood</h1><br><br></marquee>-->
<h1 class="myheader">Welcome to My_Neighborhood</h1>
<div class="container">
  <br>
  <br>

  
  <button type="button" class="btn btn-primary btn-lg " id="myBtn1">Login</button>
    <div class="bot_shadow1"></div>
  
   <button type="button" class="btn btn-success btn-lg" id="myBtn2">SignUp</button>
  <div class="bot_shadow"></div>
  <!-- Modal -->
  <div class="modal fade" id="myModallogin" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" method="post" action="">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter username" name = "uname" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password" name="pass" required>
            </div>
           
              <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
          </form>
          
        </div>
      </div>
    </div>
  </div> 
  
  <div class="modal fade" id="myModalsignup" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> SignUp</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" method="post" action="">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username:</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter username" name = "signupname" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password:</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password" name="signuppass" pattern="[A-Za-z0-9]{8}" title = "enter 8 digits" required></div><div class="form-group" >
               <label for="psw"><span class="glyphicon glyphicon-eye-open"></span>  Re-enter Password:</label>
              <input type="password" class="form-control" id="repsw" placeholder="Enter password" name="signuppassre" pattern="[A-Za-z0-9]{8}" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-envelope"></span> E-Mail:</label>
              <input type="email" class="form-control" id="psw" placeholder="Enter email" name="signupemail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
              
            </div>
              <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> SignUp</button>
          </form>
        </div>
      </div>
    </div>
  </div> 
</div>
<script>
$(document).ready(function(){
    $("#myBtn1").click(function(){
        $("#myModallogin").modal();
    });
      $("#myBtn2").click(function(){
        $("#myModalsignup").modal();
    });
});
  function myfun()
  {
    $("#myModal").close;
  }
</script>

</body>
</html>
<?php
echo $err;
?>


