
<?php
$query = "select * from pic";
        $username = "root";
$password = "";
$server = "localhost";
$database = "nazeer";
$conn = new mysqli($server,$username,$password,$database);
        $res = $conn->query($query);
        if($res->num_rows>0)
        {
          //  echo '<br>num of rows: '.$res->num_rows.'<br>';
            $row = $res->fetch_assoc();
            $var = $row['img'];
          //  echo '<p>This is your image</p> '.$var;
       
            //echo $var;
        // echo "<img src=".$var." alt='Smiley face' height='42' width='42'/>";
           // var imgsrc = "data:image/png;base64". base64_encode($var);
        //    echo imgsrc;
            //echo '<img src="data:image/png;base64,' . base64_encode($var) .'"/>';
                header("Content-type: image/png");
            echo $var;
            
            
            ?>