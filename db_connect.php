<?php
$username = "root";
$password = "";
$server = "localhost";
$database = "Project";

$conn = new mysqli($server,$username,$password,$database);
if($conn->connect_error)echo 'not connected';
//else echo 'connected<br>';
?>