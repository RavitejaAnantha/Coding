<?php
session_start();
echo ($_SESSION['userid']);
$id = $_SESSION['userid'];
include 'db_connect.php';
echo "<br>this is the profile page <br>";

 $query = "select * from User_profile where U_Id=$id";
    $res = $conn->query($query);
    if($res->num_rows>0)
    {
       $row = $res->fetch_assoc();
       $d= date($row['Date_Of_Birth']);
        $d= explode(" ",$d);
?>
<!DOCTYPE html>
<html>
<head>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBfd_t-yCoHmt8Tb3BobKI___rK_QW5Q9A"></script>
<script>
  var marker,markerarray=[];
  var myCenter=new google.maps.LatLng(40.71343536379427, -73.95240783691406);
function initialize() {
  var mapProp = {
    center:myCenter,
    zoom:15,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
  map.setOptions({draggableCursor:'crosshair'});

   var myrectangle1 = [
   
  {lat:40.718453, lng:-73.952299},
  {lat:40.718843, lng:-73.947063},
  {lat:40.715591, lng:-73.946205},
  {lat:40.714615, lng:-73.951698}
];
 
  
  var myrectangle2 = [
  {lat: 40.715591,lng: -73.946205},
  {lat:  40.714615, lng:-73.951698},
  {lat:  40.711167, lng:-73.951183},
  {lat:  40.712013, lng:-73.945690}
  ];
   
  
  var myrectangle3 = [
 {lat:40.718453,lng: -73.952299},
    {lat:40.711167,lng: -73.951183},

  {lat:40.710637808196715,lng:  -73.95618438720703},
  {lat:40.71597258001334,  lng:-73.95687103271484}
  ];
  
  
   var myrectangle4 = [
 {lat:40.644703,lng: -74.014326},
{lat:40.647829, lng:-74.010464},
{lat:40.645354, lng:-74.006430},
{lat:40.641642, lng:-74.010378}
  ];
  
    var myrectangle5 = [
 {lat: 40.64404735100636,  lng:-74.02167320251465},
{lat:40.644703, lng:-74.014326},
{lat:40.641642, lng:-74.010378},
{lat:40.637339054570226,lng:  -74.01291847229004}
  ];
  
    var myrectangle6 = [
 {lat:40.637339054570226, lng: -74.01291847229004},
{lat:40.641642, lng:-74.010378},
{lat:40.645354, lng:-74.006430},
{lat:40.6355804575753,  lng:-74.00957107543945}
  ];
  
 
  
  
  
  // Construct the polygon.
  var myarea1 = new google.maps.Polygon({
    paths: myrectangle1,
    strokeColor: '#FF0000',
    strokeOpacity: 0.2,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.5
  });
  myarea1.setMap(map);
  
  var myarea2 = new google.maps.Polygon({
    paths: myrectangle2,
    strokeColor: '#FF0000',
    strokeOpacity: 0.2,
    strokeWeight: 2,
    fillColor: '#000000',
    fillOpacity: 0.2
  });
  myarea2.setMap(map);

   var myarea3 = new google.maps.Polygon({
    paths: myrectangle3,
    strokeColor: '#FF0000',
    strokeOpacity: 0.2,
    strokeWeight: 2,
    fillColor: '#0000FF',
    fillOpacity: 0.2
  });
  myarea3.setMap(map);
  
  var myarea4 = new google.maps.Polygon({
    paths: myrectangle4,
    strokeColor: '#FF0000',
    strokeOpacity: 0.2,
    strokeWeight: 2,
    fillColor: '#0000FF',
    fillOpacity: 0.2
  });
  myarea4.setMap(map);
  
  var myarea5 = new google.maps.Polygon({
    paths: myrectangle5,
    strokeColor: '#FF0000',
    strokeOpacity: 0.2,
    strokeWeight: 2,
    fillColor: '#000000',
    fillOpacity: 0.2
  });
  myarea5.setMap(map);
  
  var myarea6 = new google.maps.Polygon({
    paths: myrectangle6,
    strokeColor: '#FF0000',
    strokeOpacity: 0.2,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.5
  });
  myarea6.setMap(map);

  
function placemark(location)
  {
   // console.log(location);
    //delete other markers
      console.clear();
if( google.maps.geometry.poly.containsLocation(location, myarea1)) 
       { console.log('inside area1') ;
    document.getElementById('test').innerHTML='area 1';}
  else  if( google.maps.geometry.poly.containsLocation(location, myarea2)) 
       { console.log('inside area2') ;
       document.getElementById('test').innerHTML='area 2';}
     else  if( google.maps.geometry.poly.containsLocation(location, myarea3)) 
      {  console.log('inside area3') ;
      document.getElementById('test').innerHTML='area 3';}
    else  if( google.maps.geometry.poly.containsLocation(location, myarea4)) 
       { console.log('inside area4') ;
       document.getElementById('test').innerHTML='area 4';}
    else  if( google.maps.geometry.poly.containsLocation(location, myarea5)) 
       { console.log('inside area5') ;
       document.getElementById('test').innerHTML='area 5';}
    else  if( google.maps.geometry.poly.containsLocation(location, myarea6)) 
       { console.log('inside area6') ;
       document.getElementById('test').innerHTML='area 6';}
    
    else {console.log('devudaaa') ;
    document.getElementById('test').innerHTML='Not in any block';
         }
    console.log(location.lat()+ "  "+ location.lng());
   // map.setCenter(location);
deletemarkers();
         marker=new google.maps.Marker({
  position:location,
  animation:google.maps.Animation.BOUNCE
  });

marker.setMap(map);

    google.maps.event.addListener(marker,'click',function(event) {
      var v = 'lat:   '+event.latLng.lat()+'   lng: '+ event.latLng.lng();
        var infowindow = new google.maps.InfoWindow({
    content: v
  });
   // alert('clicked on a marker');
    infowindow.open(map, marker);

  });
    markerarray.push(marker);
  }
  google.maps.event.addListener(myarea1,"mouseover",function(){
 this.setOptions({fillColor: "#00FF00"});

}); 
   google.maps.event.addListener(myarea1,"mouseout",function(){
 this.setOptions({fillColor: "#FF0000"});
}); 
  google.maps.event.addListener(myarea2,"mouseover",function(){
 this.setOptions({fillColor: "#00FF00"});
}); 
   google.maps.event.addListener(myarea2,"mouseout",function(){
 this.setOptions({fillColor: "#000000"});
}); 
    google.maps.event.addListener(myarea3,"mouseover",function(){
 this.setOptions({fillColor: "#00FF00"});

}); 
   google.maps.event.addListener(myarea3,"mouseout",function(){
 this.setOptions({fillColor: "#0000FF"});
}); 
      google.maps.event.addListener(myarea4,"mouseover",function(){
 this.setOptions({fillColor: "#00FF00"});

}); 
   google.maps.event.addListener(myarea4,"mouseout",function(){
 this.setOptions({fillColor: "#0000FF"});
}); 
    google.maps.event.addListener(myarea5,"mouseover",function(){
 this.setOptions({fillColor: "#00FF00"});

}); 
   google.maps.event.addListener(myarea5,"mouseout",function(){
 this.setOptions({fillColor: "#000000"});
}); 
   google.maps.event.addListener(myarea6,"mouseout",function(){
 this.setOptions({fillColor: "#FF0000"});
}); 
  google.maps.event.addListener(myarea6,"mouseover",function(){
 this.setOptions({fillColor: "#00FF00"});
}); 
  
   google.maps.event.addListener(myarea1,'click',function(event) {
    
    placemark(event.latLng);
     
   });
   google.maps.event.addListener(myarea2,'click',function(event) {
    
    placemark(event.latLng);
     
   });
  google.maps.event.addListener(myarea3,'click',function(event) {
  
    placemark(event.latLng);
     
   });
  google.maps.event.addListener(myarea4,'click',function(event) {
    
    placemark(event.latLng);
     
   });
  google.maps.event.addListener(myarea5,'click',function(event) {
     
    
    placemark(event.latLng);
     
   });
  google.maps.event.addListener(myarea6,'click',function(event) {
    
    placemark(event.latLng);
     
   });
  google.maps.event.addListener(map,'click',function(event) {
    
    placemark(event.latLng);

  });
  
  function deletemarkers()
  {
    for (i in markerarray)
      {
        markerarray[i].setMap(null);
      }
    markerarray.length = 0;
  }
}
  

google.maps.event.addDomListener(window, 'load', initialize);
</script>

  <style>
  #googleMap
    {
      border: 1px solid black;
    }
  
  </style>
  </head>

<body>
<div id="googleMap" style="width:800px;height:500px;" class="gm"></div>
<div id="test">Kirankiran</div>
<input type="button" value="Unlock" onclick="caneditthis()" id="editbutton">
<form method="post" action="" >
Name: <input type="text" name="name"  id="text1" value=<?php echo $row['Username'];?> disabled><br>
Gender: <input type="radio" name="gender" value="male" disabled id="radio1" checked >Male
<input type="radio" name="gender" value="female" disabled id="radio2">Female
   <br>
    Date of Birth:<input type="date" name="dob" id="dobid" value="<?php   
        echo $d[0]; ?>" disabled><br>
   Description: <textarea rows="4" cols="50" disabled id="idfortextarea">

   <?php $row['U_Description'] = trim($row['U_Description']); echo $row['U_Description'];?>
</textarea>
   <br>
    Block Name: <select disabled id = "selectidblock" >
   <?php
   $query = "select Block_Name from Block_Details";
   $res = $conn->query($query);
   if($res->num_rows>0)
   {
      while($row1=$res->fetch_assoc())
         echo ("<option>".$row1['Block_Name']."</option>");
   }
   ?>
</select><br>
   Hood Name: <select disabled id = "selectidhood" >
   <?php
   $query = "select Hood_Name from Hood_Details";
   $res = $conn->query($query);
   if($res->num_rows>0)
   {
      while($row2=$res->fetch_assoc())
         echo ("<option>".$row2['Hood_Name']."</option>");
   }
   ?>
</select>
   <br>
  
  Apartment No:<input type="text" id="aptno"  value=<?php echo $row['Apt_No'];?> disabled><br>
   Building No:<input type="text"  id="bldno" value="<?php echo $row['Building_No'];?>" disabled ><br>
  <input type="submit" value="update" onclick="submitclicked()">
</form>
</body>

<?php
          }

else{ echo "no profile yet for the user"; }
       ?>
<?php
if($row['Gender']=='Male') { ?> <script>
document.getElementById('radio1').checked= true;  </script>
<?php }
if($row['Gender']=='Female'){ ?><script> 
document.getElementById('radio2').checked= true;  </script>
<?php }
?>
<script>
function caneditthis()
  {
     if( document.getElementById('editbutton').value=='Unlock'){
        alert('you clicked me '+document.getElementById('editbutton').value );
     var mytextbox =  document.getElementById('text1');
     mytextbox.disabled=false;
     mytextbox.focus();
     document.getElementById('radio1').disabled=false;
     document.getElementById('radio2').disabled=false;
     document.getElementById('dobid').disabled=false;
     document.getElementById('idfortextarea').disabled=false;
     document.getElementById('selectidblock').disabled=false;
     document.getElementById('selectidhood').disabled=false;
     document.getElementById('aptno').disabled=false;
     document.getElementById('bldno').disabled=false;
     document.getElementById('editbutton').value='lock';
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
     document.getElementById('selectidblock').disabled=true;
     document.getElementById('selectidhood').disabled=true;
     document.getElementById('aptno').disabled=true;
     document.getElementById('bldno').disabled=true;
     document.getElementById('editbutton').value='Unlock';
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
</script>
  
  
</body>

</html>