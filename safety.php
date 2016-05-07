
<!DOCTYPE html>
<html>
<head>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBfd_t-yCoHmt8Tb3BobKI___rK_QW5Q9A"></script>
<script>
  var marker,markerarray=[];
  var myCenter=new google.maps.LatLng(40.67985693941085,  -73.96991729736328);
function initialize() {
  var mapProp = {
    center:myCenter,
    zoom:12,
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
        console.log('inside area1') ;
  else  if( google.maps.geometry.poly.containsLocation(location, myarea2)) 
        console.log('inside area2') ;
     else  if( google.maps.geometry.poly.containsLocation(location, myarea3)) 
        console.log('inside area3') ;
    else  if( google.maps.geometry.poly.containsLocation(location, myarea4)) 
        console.log('inside area4') ;
    else  if( google.maps.geometry.poly.containsLocation(location, myarea5)) 
        console.log('inside area5') ;
    else  if( google.maps.geometry.poly.containsLocation(location, myarea6)) 
        console.log('inside area6') ;
    
    else console.log('devudaaa') ;
    console.log(location.lat()+ "  "+ location.lng());
   // map.setCenter(location);
deletemarkers();
         marker=new google.maps.Marker({
  position:location,
  animation:google.maps.Animation.BOUNCE
  });

marker.setMap(map);
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
</head>

<body>
<div id="googleMap" style="width:500px;height:500px;"></div>
  
  
  
</body>

</html>