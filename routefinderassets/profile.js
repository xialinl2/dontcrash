var startAddr;
var endAddr;
var directionsService;
var directionsRenderer;
var map;
var geocoder;

function initMap() {
  var chicago = new google.maps.LatLng( 41.8781, -87.6298);
  geocoder = new google.maps.Geocoder();
  map = new google.maps.Map(document.getElementById('map'), {
    mapTypeControl: false,
    center: chicago,
    zoom: 10
  });
  
  getFromDB();
}

function getFromDB(){
     jQuery.ajax({
                type: "GET",
                url: 'routefinderassets/profile_getmapdata.php',
                dataType: 'json',
                success: function (obj) {
                      console.log(JSON.stringify(obj));
                      setMarkers(obj);
                }
            });
}

function setMarkers(JSONObj){
    //console.log("First marker "+JSONObj[0].latitude);
    var i;
    var arrLength = Object.keys(JSONObj).length;
    console.log("Length of markers arr: "+arrLength);

    document.getElementById("numAccidents").innerHTML = arrLength;
    document.getElementById("strRecent").innerHTML = JSONObj[arrLength - 1].street_name;
    
    for(i = 0; i < arrLength; i++){
        //var lat = parseFloat(JSONObj[i].latitude);
        //var long = parseFloat(JSONObj[i].longitude);
        var address = JSONObj[i].street_no + ' ' + JSONObj[i].street_name + ' ' + JSONObj[i].street_direction + ' Chicago';

        geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location,
            icon: 'routefinderassets/car_crash_icon.png'
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
        
        //new google.maps.Marker({position: {lat: lat, lng: long}, map: map, icon: 'routefinderassets/car_crash_icon.png'});
    }
}

