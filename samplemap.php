<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        #map_canvas {height:600px;width:800px}
    </style>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBfd_t-yCoHmt8Tb3BobKI___rK_QW5Q9A"></script>

    <script type="text/javascript">
        var map;
        var markersArray = [];

        function initMap()
        {
            var latlng = new google.maps.LatLng(41, 29);
            var myOptions = {
                zoom: 10,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            // add a click event handler to the map object
            google.maps.event.addListener(map, "click", function(event)
            {
                // place a marker
                alert("clciked");
                placeMarker(event.latLng);

                // display the lat/lng in your form's lat/lng fields
                document.getElementById("latFld").value = event.latLng.lat();
                document.getElementById("lngFld").value = event.latLng.lng();
                document.getElementById("dup").value = markersArray.length;
            });
        }

        
        
        ////////////////
        function placeMarker(location) {
             var v = "lat:"+location.lat()+" lng:"+location.lng();
            // first remove all markers if there are any
            deleteOverlays();

            var marker = new google.maps.Marker({
                position: location, 
                map: map
            });
           
            marker.addListener('click', function() {
                 var infowindow = new google.maps.InfoWindow({
    content: v
  });
                infowindow.open(map, marker);
    
  });

            // add marker in markers array
            markersArray.push(marker);

            //map.setCenter(location);
        }

        // Deletes all markers in the array by removing references to them
        function deleteOverlays() {
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
            markersArray.length = 0;
            }
        }
    </script>
</head>
     

<body onload="initMap()">
    <div id="map_canvas"></div>
    <input type="text" id="latFld"> <input type="text" id="dup">
    <input type="text" id="lngFld">
</body>
</html>