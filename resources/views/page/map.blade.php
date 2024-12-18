  
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <title>Map with Search</title>
    <style>

      #map {
        height: 53vh;
        width: 100%;
        border: 1px solid #ccc;
      }
 

  /* Style for the search bar input field */
  .leaflet-control-geocoder input {
    width: 100%;
    padding: 5px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 3px;
  }
 
</style>

  </head>
  <body>

   
    <div id="map"></div>

<script>  
    var map = L.map('map').setView([51.505, -0.09], 13);  
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {  
    maxZoom: 19,  
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'  
    }).addTo(map);  
    
    navigator.geolocation.watchPosition(success, error);  
    
    let marker, circle, zoomed;  
    
    function success(pos) {  
    const lat = pos.coords.latitude;  
    const lng = pos.coords.longitude;  
    const accuracy = pos.coords.accuracy;  
    
    if (marker) {  
    map.removeLayer(marker);  
    map.removeLayer(circle);  
    }  
    
    marker = L.marker([lat, lng]).addTo(map);  
    circle = L.circle([lat, lng], { radius: accuracy }).addTo(map);  
    
    if (!zoomed){  
    zoomed = map.fitBounds(circle.getBounds());  
    }  
    
    map.setView([lat, lng])  
    }  
    
    function error(err) {  
    if (err.code === 1) {  
    alert("Please allow geolocation access");  
    } else {  
    alert("Cannot get current location");  
    }  
    }  
    
    // Add search bar  
    var geocoder = L.Control.Geocoder.nominatim();  
    var control = L.Control.geocoder({  
    geocoder: geocoder,  
    defaultMarkGeocode: false  
    }).addTo(map);  
    
    control.on('markgeocode', function(e) {  
    var bbox = e.geocode.bbox;  
    var poly = L.polygon([  
    bbox.getSouthEast(),  
    bbox.getNorthEast(),  
    bbox.getNorthWest(),  
    bbox.getSouthWest()  
    ]).addTo(map);  
    map.fitBounds(poly.getBounds());  
      
    // Move the marker and circle to the searched address  
    if (marker) {  
    map.removeLayer(marker);  
    }  
    if (circle) {  
    map.removeLayer(circle);  
    }  
    marker = L.marker([e.geocode.center.lat, e.geocode.center.lng]).addTo(map);  
    circle = L.circle([e.geocode.center.lat, e.geocode.center.lng], { radius: 100 }).addTo(map);  
    });  
  </script> </body>
</html>

