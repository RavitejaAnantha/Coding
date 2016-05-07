<input type="button" value="back" onclick="goback()">
<script>
function goback()
  {
     window.location.href = "manageprofile.php";
  }

</script>
<?php
include 'db_connect.php';
session_start();

//
error_reporting(E_ALL);

//echo ("post variables are".$_POST['updatedlat']);
if(isset($_POST['updatedlat'])&&isset($_POST['updatedlng'])&&isset($_POST['updatedblock'])&&isset($_POST['updatedzip']))
{
  if($_POST['updatedzip']=='undefined'||$_POST['updatedblock']=='undefined') 
  {
    echo 'Please select a place on one of the blocks, You are given one more chance!';
  }
  else{
  if($_POST['updatedzip']=='Sunset Park') $zip = 2;
  if($_POST['updatedzip']=='Green Point') $zip = 1;
  //echo $zip;
 //echo 'values are set for user'.$_SESSION['userid'].'<br>'; 
  //echo $_POST['updatedlat'].$_POST['updatedlng'];
  $lat=  floatval($_POST['updatedlat']);
  $lng =  floatval($_POST['updatedlng']);
  $blk = $_POST['updatedblock'];
 // echo $lat.$lng;
  $uid = $_SESSION['userid'];
  $stmt = $conn->prepare("update User_profile set Latitude = (?) , Longitude = (?), Block_Id= (?), Hood_Id = (?),Block_Request_Accepted = 0 where U_Id= $uid");
  $stmt->bind_param("ddii", $lat,$lng,$blk,$zip);
  $value = "";
  if($stmt->execute()){ $value = true; //echo $value;
                      }
  if($value){ header('location: manageprofile.php'); }
  else echo '<br>failure';
  }
}
//else echo 'values are not set';
else echo'Please choose the location:<br>';

?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #googleMap {
        height: 80%;
        width: 50%;
        border: 1px solid black;
      }
.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}
s
#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}
      #target {
        width: 345px;
      }
      #googleMap
      {
        border: 1px solid black;
      }
       #googleMap:hover
      {
        border: 2px solid gray;
      }
</style>
    <title>My Website</title>
  </head>
  <body>
     <form method="post" action="hamayya.php" id="myform" >
       <br>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="googleMap"></div>
<!--    <div id="note">Area</div>-->
    
      Lat: <input type = "text" id= "latkiran" name="updatedlat" required >
       Lng: <input type = "text" id= "lngkiran" name="updatedlng" required >
       Block: <input type="text" id="blockkiran" name= "updatedblock" required >
       Neighborhood: <input type="text" id="zipkiran" name="updatedzip" required >

<!--    <input type="button"  value="Update Location" id="buttonid" onclick="changeloc()">-->
        <input type="submit"  value="Update Location" id="buttonid" onclick="changeloc()">
      </form>
      </body>
</html>
    <script>
      
      var marker,markerarray=[];
function initAutocomplete() {
//var userpos = new google.maps.LatLng(part1+','+part2);
 // var userpos = {lat: part1, lng: part2};
  var mapProp = {
    center:{lat:40.67985693941085 ,lng: -73.96991729736328},
  //  center:userpos,
    zoom:12,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById('googleMap'),mapProp);
 // map.setOptions({draggableCursor:'crosshair'});
  
  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });
  ////////////////////
  function placemark(location)
  {
   // console.log(location);
    //delete other markers
      console.clear();
if( google.maps.geometry.poly.containsLocation(location, myarea1)) 
{console.log('inside area1') ;
//document.getElementById('note').innerHTML="block 1";
document.getElementById('latkiran').value= location.lat();
        document.getElementById('lngkiran').value= location.lng();
  document.getElementById('blockkiran').value=1;
document.getElementById('zipkiran').value='Green Point';}
  else  if( google.maps.geometry.poly.containsLocation(location, myarea2)) 
       { console.log('inside area2') ;
      //  document.getElementById('note').innerHTML="block 2";
       document.getElementById('latkiran').value= location.lat();
        document.getElementById('lngkiran').value= location.lng();
        document.getElementById('blockkiran').value=2;
       document.getElementById('zipkiran').value='Green Point';}
     else  if( google.maps.geometry.poly.containsLocation(location, myarea3)) 
     {console.log('inside area3') ;
      //document.getElementById('note').innerHTML="block 3";
     document.getElementById('latkiran').value= location.lat();
        document.getElementById('lngkiran').value= location.lng();
      document.getElementById('blockkiran').value=3;
     document.getElementById('zipkiran').value='Green Point';}
    else  if( google.maps.geometry.poly.containsLocation(location, myarea4)) 
    {console.log('inside area4') ;
     //document.getElementById('note').innerHTML="block 4";
    document.getElementById('latkiran').value= location.lat();
        document.getElementById('lngkiran').value= location.lng();
     document.getElementById('blockkiran').value=4;
    document.getElementById('zipkiran').value='Sunset Park';}
    else  if( google.maps.geometry.poly.containsLocation(location, myarea5)) 
    {console.log('inside area5') ;
     //document.getElementById('note').innerHTML="block 5";
    document.getElementById('latkiran').value= location.lat();
        document.getElementById('lngkiran').value= location.lng();
     document.getElementById('blockkiran').value=5;
    document.getElementById('zipkiran').value='Sunset Park';}
    else  if( google.maps.geometry.poly.containsLocation(location, myarea6)) 
    {console.log('inside area6') ;
     //document.getElementById('note').innerHTML="block 6";
    document.getElementById('latkiran').value= location.lat();
        document.getElementById('lngkiran').value= location.lng();
     document.getElementById('blockkiran').value=6;
    document.getElementById('zipkiran').value='Sunset Park';}
    
    else {console.log('devudaaa') ;
    console.log(location.lat()+ "  "+ location.lng());
        //  document.getElementById('note').innerHTML="not in any block";
          document.getElementById('latkiran').value= location.lat();
        document.getElementById('lngkiran').value= location.lng();
           document.getElementById('blockkiran').value=undefined;
          document.getElementById('zipkiran').value=undefined;
         }
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
  
  
  function deletemarkers()
  {
    for (i in markerarray)
      {
        markerarray[i].setMap(null);
      }
    markerarray.length = 0;
  }
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
  ////////////////////////////
  var markers = [];
  // [START region_getplaces]
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
  // [END region_getplaces]
}
    </script>
    <script>
    var text = window.location.hash.substring(1);
      var part1 = text.substring(0,text.lastIndexOf('#'));
      var part2 =text.substring(text.lastIndexOf('#')+2);
      
      console.log(part1);
      console.log(part2);
    
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfd_t-yCoHmt8Tb3BobKI___rK_QW5Q9A&libraries=places&callback=initAutocomplete"
         async defer></script>
   
