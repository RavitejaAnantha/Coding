<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

  <html>
  <head><title>File Upload To Database</title></head>
  <body>
  <h2>Please Choose a File and click Submit</h2>
  <form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
  <div><input name="userfile" type="file" /></div>
  <div><input type="submit" value="Submit" /></div>
  </form>

</body></html>

<?php
/*** check if a file was submitted ***/
if(!isset($_FILES['userfile']))
    {
    echo '<p>Please select a file</p>';
    }
else
    {
    try    {
        upload();
        echo '<br>upload successful';
        
        
        
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
            header("Content-type: image/jpeg");
echo ($var);
      //  echo '<img src="data:image/jpeg;base64,'.base64_encode($var).'" alt="photo"><br>';

          //  echo '<img src="' . base64_encode($var) .'"/>';
           // echo '<img src="' .$var.'"/>';
        }
    }
       
        
    catch(Exception $e)
        {
        echo '<h4>'.$e->getMessage().'</h4>';
        }
    }

function upload(){
/*** check if a file was uploaded ***/
if(is_uploaded_file($_FILES['userfile']['tmp_name']) && getimagesize($_FILES['userfile']['tmp_name']) != false)
    {
    /***  get the image info. ***/
    $size = getimagesize($_FILES['userfile']['tmp_name']);
    //echo("size is ".$size);
    /*** assign our variables ***/
    $type = $size['mime'];
    echo ("<br>type is ".$type);
    $imgfp = fopen($_FILES['userfile']['tmp_name'], 'rb');
    $size = $size[3];
    $name = $_FILES['userfile']['name'];
    echo ("<br>name is ".$name);
    $maxsize = 99999999;

    if($_FILES['userfile']['size'] < $maxsize )
        {

$username = "root";
$password = "";
$server = "localhost";
$database = "nazeer";
$conn = new mysqli($server,$username,$password,$database);
$stmt = $conn->prepare("INSERT INTO pic (idpic, img) VALUES (? ,?)");
$type = 1;
$stmt->bind_param("ss",$type,$imgfp);
$stmt->execute();
    }
else
    {
    throw new Exception("Unsupported Image Format!");
    }
}
}
?>


