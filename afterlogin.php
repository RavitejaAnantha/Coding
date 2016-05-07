<?php
session_start();
echo ' <div class="namediv" onclick="manageprofile()">Welcome: '.$_SESSION['userkanaam']."</div><br>";
//echo "<br>Do you want to manage your profile?";
?>
<br>

 <link rel="stylesheet" href="styles.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<input type="button" value=" Profile" onclick="manageprofile()" class="btn btn-success">
<link rel="stylesheet" type="text/css" href="bootstrap.css">
<style>
  .namediv
  {
    position: absolute;
    top: 10px;
    left: 970px;
  }
  .namediv:hover
  {
    cursor: pointer;
  }
.btn-success {
  position: relative;
  font-size: 20px;
  padding: 100px;
  left: 120px;
  top: 100px;
  margin: 10px;
    color: #fff; 
    background-color: #5cb85c;
    border-color: #4cae4c;
    width: 300px; !important
    height: 10px; !important
}

</style>
  <script>
    
function manageprofile()
  {
    //alert('yes, user wants to edit his profile');
    window.location.href = "manageprofile.php";
  }
</script>
<?php
//echo '<br>Do you want to manage your friends list?';
?>
<input type="button" value="Friends" onclick="managefriends()" class="btn btn-success">
<script>
function managefriends()
  {
    window.location.href = "managefriends.php";
  }
</script>
  
<?php
//echo '<br>Do you want to manage your neighbors';
?>
<input type="button" value=" Neighbors" onclick="manageneighbors()" class="btn btn-success">
<script>
function manageneighbors()
  {
    window.location.href = "manageneighbors.php";
  }
</script>

<?php
//echo '<br>Do you want to manage your block requests';
?>
<input type="button" value="Block Requests" onclick="manageblockrequests()" class="btn btn-success">
<script>
function manageblockrequests()
  {
    window.location.href = "manageblockrequests.php";
  }
</script>

<?php
//echo '<br>Do you want to manage your messages?';
?>
<input type="button" value="Messages" onclick="managemessages()" class="btn btn-success">
<script>
function managemessages()
  {
    window.location.href = "managemessages.php";
  }
</script>

<?php
//echo '<br>Do you want to logout?';
?>
<input type="button" value="Logout" onclick="logout()" class="btn btn-success">
<script>
function logout()
  {
    window.location.href = "index.php";
  }
</script>

