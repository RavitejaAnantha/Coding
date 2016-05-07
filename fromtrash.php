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
    $query = "select * from Login where username = '$user' and password = '$pass'";
    $res = $conn->query($query);
    if($res->num_rows>0)
    {$row = $res->fetch_assoc();
      $_SESSION['userid']= $row['U_Id'];
     $_SESSION['userkanaam'] = $row['Username'];
        header('location:afterlogin.php');
       // header('location:nextpage.php');
       // header('location:hamayya.php');
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
    $query = "insert into Login (Username,Password,Time_of_Signup,Email)values ('$tempuname','$tmeppass','$date','$tempemail')";
    if($conn->query($query))
      $err=  "signed up sucessfully";
    else echo "there is some error in the query";
    
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
    
  </style>
</head>
<body background="img.jpg">
 <marquee scrollamount	= 30> <h1 class="myheader">Welcome to My_Neighborhood</h1><br><br></marquee>

<div class="container">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default btn-lg" id="myBtn1">Login</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <button type="button" class="btn btn-default btn-lg" id="myBtn2">SignUp</button>
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
              <input type="password" class="form-control" id="psw" placeholder="Enter password" name="signuppass" required></div><div class="form-group">
               <label for="psw"><span class="glyphicon glyphicon-eye-open"></span>  Re-enter Password:</label>
              <input type="password" class="form-control" id="repsw" placeholder="Enter password" name="signuppassre" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-envelope"></span> E-Mail:</label>
              <input type="text" class="form-control" id="psw" placeholder="Enter email" name="signupemail" required>
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


