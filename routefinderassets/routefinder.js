var startAddr;
var endAddr;
var directionsService;
var directionsRenderer;
var map;
var geocoder;
var markers = [];
/*if((sessionStorage.getItem("savedRouteParams") == null)){
    sessionStorage.setItem("savedRouteParams", routeParams);
}*/

//savedRouteParams = sessionStorage.getItem("savedRouteParams");

/*function initMap() {
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer();
  var center = new google.maps.LatLng( 41.8781, -87.6298); 
  //var oceanBeach = new google.maps.LatLng(37.7683909618184, -122.51089453697205);
  var mapOptions = {
    zoom: 8,
    center: center
  }
  var map = new google.maps.Map(document.getElementById('map'), mapOptions);
  directionsRenderer.setMap(map);
} */

function initMap() {
  var chicago = new google.maps.LatLng( 41.8781, -87.6298); 
  map = new google.maps.Map(document.getElementById('map'), {
    mapTypeControl: false,
    center: chicago,
    zoom: 8
  });
  geocoder = new google.maps.Geocoder();

  new AutocompleteDirectionsHandler(map);
}

/**
 * @constructor
 */
function AutocompleteDirectionsHandler(map) {
  this.map = map;
  this.originPlaceId = null;
  this.destinationPlaceId = null;
  this.travelMode = 'DRIVING';
  this.directionsService = new google.maps.DirectionsService;
  this.directionsRenderer = new google.maps.DirectionsRenderer;
  this.directionsRenderer.setMap(map);

  var originInput = document.getElementById('origin-input');
  var destinationInput = document.getElementById('destination-input');
  var modeSelector = document.getElementById('mode-selector');

  var originAutocomplete = new google.maps.places.Autocomplete(originInput);
  // Specify just the place data fields that you need.
  originAutocomplete.setFields(['place_id']);

  var destinationAutocomplete =
      new google.maps.places.Autocomplete(destinationInput);
  // Specify just the place data fields that you need.
  destinationAutocomplete.setFields(['place_id']);

  this.setupClickListener('changemode-walking', 'WALKING');
  //this.setupClickListener('changemode-transit', 'TRANSIT');
  this.setupClickListener('changemode-driving', 'DRIVING');

  this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
  this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

  this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
  this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(
      destinationInput);
  this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
}

// Sets a listener on a radio button to change the filter type on Places
// Autocomplete.
AutocompleteDirectionsHandler.prototype.setupClickListener = function(
    id, mode) {
  var radioButton = document.getElementById(id);
  var me = this;

  radioButton.addEventListener('click', function() {
    me.travelMode = mode;
    me.route();
  });
};

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(
    autocomplete, mode) {
  var me = this;
  autocomplete.bindTo('bounds', this.map);

  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();

    if (!place.place_id) {
      window.alert('Please select an option from the dropdown list.');
      return;
    }
    if (mode === 'ORIG') {
      me.originPlaceId = place.place_id;
    } else {
      me.destinationPlaceId = place.place_id;
    }
    me.route();
  });
};

AutocompleteDirectionsHandler.prototype.route = function() {
  if (!this.originPlaceId || !this.destinationPlaceId) {
    return;
  }
  var me = this;

  this.directionsService.route(
      {
        origin: {'placeId': this.originPlaceId},
        destination: {'placeId': this.destinationPlaceId},
        travelMode: this.travelMode
      },
      function(response, status) {
        if (status === 'OK') {
          me.directionsRenderer.setDirections(response);
          getNearbyAccidents(response);
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      });
};

function getStreetName(){
    var geocoder = new google.maps.Geocoder;
}

function getNearbyAccidents(response){
    console.log(JSON.stringify(response.routes[0].legs[0].steps));
    var steps = response.routes[0].legs[0].steps;
    //var path = response.routes[0].legs[0].steps[i];
    var i;
    var j;
    var startLats = [];
    var startLongs = [];
    var endLats = [];
    var endLongs = [];
    var streetNames = [];
    
    for(i = 0; i < Object.keys(steps).length; i++){
        var instructions; 
        var streetName;
        
        try{
            var instructions = JSON.stringify(response.routes[0].legs[0].steps[i].instructions);
            /*if("Turn" == instructions.substring(1,5) || "Head"==instructions.substring(1,5) || "Slight"==instructions.substring(1,7) || "Take exit" == instructions.substring(1,10)){
                streetName = instructions.split('<b>')[2].split('</b>')[0].split('<div>')[0].split(' ');
            }
            else */
            if("Merge" == instructions.substring(1,6) || "Take" == instructions.substring(1,5) || "Continue" == instructions.substring(1,8)){
                streetName = instructions.split('<b>')[1].split('</b>')[0].split('<div>')[0].split(' ');
            }
            else{
                streetName = instructions.split('<b>')[2].split('</b>')[0].split('<div>')[0].split(' ');
            }
            streetName = getStreetSpec(streetName);
        }
        catch(err){
            streetName = "";
        }
        
        streetName = streetName.toUpperCase();
        
        
        console.log(instructions);
        console.log(streetName);
        
        try{
            var pathLength = Object.keys(response.routes[0].legs[0].steps[i].path).length;
            var latStart = parseFloat(parseFloat(JSON.stringify(response.routes[0].legs[0].steps[i].path[0].lat())).toFixed(3));
            var longStart = parseFloat(parseFloat(JSON.stringify(response.routes[0].legs[0].steps[i].path[0].lng())).toFixed(3));
            var latEnd = parseFloat(parseFloat(JSON.stringify(response.routes[0].legs[0].steps[i].path[pathLength - 1].lat())).toFixed(3));
            var longEnd = parseFloat(parseFloat(JSON.stringify(response.routes[0].legs[0].steps[i].path[pathLength - 1].lng())).toFixed(3));

            //based on which lat & long val is larger for the range, put it as start or end lat
            if(latStart >= latEnd){
                startLats.push(latStart-.003);
                endLats.push(latEnd+.003);
            }
            else if(latEnd > latStart){
                startLats.push(latEnd-.003);
                endLats.push(latStart+.003);
            }
        
            if(longStart >= longEnd){
                startLongs.push(longStart-.003);
                endLongs.push(longEnd+.003);
            }
            else if(longEnd > longStart){
                    startLongs.push(longEnd-.003);
                    endLongs.push(longStart+.003);
                }
                streetNames.push(streetName);
            }
            catch(err){
                console.log("Invalid path from google api");
            }
    }
    console.log("Steps arr length: "+Object.keys(steps).length);
    console.log("StreetNames: "+streetNames+"\n");
    console.log("START_LATS: "+startLats+"\nSTART_LONGS: "+startLongs+"\nEND_LATS: "+endLats+"\nEND_LONGS: "+endLongs);
    getFromDB(startLats,startLongs,endLats,endLongs,streetNames);
}

function getStreetSpec(street){
    var streetName;
    if(street[0].length == 1){
        streetName = street[1] 
        if(street.length > 2){
            streetName = streetName +" "+ street[2];
        }
    }
    else{
        streetName = street[0];
        if(street.length > 1){
            streetName = streetName +" "+ street[1];
        }
    }
    return streetName;
}
        
        //for(j = 0; j < Object.keys(response.routes[0].legs[0].steps[i].path).length; j++){
            /*var lat = parseFloat(JSON.stringify(response.routes[0].legs[0].steps[i].path[j].lat())).toFixed(3);
            var long = parseFloat(JSON.stringify(response.routes[0].legs[0].steps[i].path[j].lng())).toFixed(3);
            
            console.log("STEPS-"+i+" PATH-"+j+" :"+" LAT- "+lat+" LONG- "+long);
            console.log("Path arr length: "+Object.keys(response.routes[0].legs[0].steps[i].path).length);
            
            var latIndex = lats.indexOf(lat)
            var longIndex = longs.indexOf(long);
            
            var search;
            var found = false;*/
            //if the lat and long does not already exist in array, then add
            /*for(search = 0; search < lats.length; search++){
                if((lats[search] == lat) && (longs[search] == long)){
                    found = true;
                }
            }
            
            if(!found){
                lats.push(lat);
                longs.push(long);
            }*/
            
        //}
    //}

    
function getFromDB(startLats,startLongs,endLats,endLongs,streetNames){
     jQuery.ajax({
                type: "POST",
                url: 'http://dontcrash.web.illinois.edu/routefinderassets/route_getaccidentsinfo.php',
                dataType: 'json',
                data: {
                    start_lats: startLats,
                    start_longs: startLongs,
                    end_lats: endLats,
                    end_longs: endLongs,
                    streets: streetNames
                },
                success: function (obj) {
                  //if( !('error' in obj) ) {
                     // yourVariable = obj.result;
                      console.log(JSON.stringify(obj));
                      setMarkers(obj,startLats,startLongs,endLats,endLongs);
                 // }
                  //else {
                   //   console.log(obj.error);
                  //}
                }
            });
}

function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
        markers = [];
      }

function setMarkers(JSONObj,startLats,startLongs,endLats,endLongs){
    console.log("Length of markers arr: "+Object.keys(JSONObj).length);
    //console.log("First marker "+JSONObj[0][0].latitude);
    var i;
    var j;

    
    for(i = 0; i < Object.keys(JSONObj).length; i++){
        //for(j = 0; j < Object.keys(JSONObj[i]).length; j++){
            //var lat = parseFloat(JSONObj[i][j].latitude);
            //var long = parseFloat(JSONObj[i][j].longitude);
            if(Object.keys(JSONObj[i]).length == 0){
                continue;
            }
            
            //get middle point between start and end lats & longs
            var lat = (startLats[i] - endLats[i])/2 + endLats[i];
            var long = (startLongs[i] - endLongs[i])/2 + endLongs[i];
            var label = (Object.keys(JSONObj[i]).length).toString();
            markers.push(new google.maps.Marker({position: {lat: lat, lng: long},
                                        map: map,
                                        label: {text: label, color: '#FFFFFF'},
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 22,
                                            fillColor: "#EB4335",
                                            fillOpacity: 1,
                                            strokeWeight: 0.6,
                                            strokeColor: '#FFFFFF'
                                        }}));
            //markers.push(marker);
        //}
    }
    
    //setMapOnAll(map);
   
    //new google.maps.Marker({position: {lat: JSONObj.latitude, lng: JSONObj.longitude}, map: map});
} 

/*function getStreetName(lat,long) {
    geocoder.geocode( {lat: lat, lng: long}, function(results, status) {
      if (status == 'OK') {
        console.log(JSON.stringify(results);
  
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }*/
    
    /*String response = getResponseFromGoogleMaps(); //this function will fetch the response. write it in your way
ArrayList<Bundle> list = new ArrayList<Bundle>();
try {
        JSONObject json = new JSONObject(response);
        JSONArray routes = json.getJSONArray("route");
        JSONArray legs = routes.getJSONArray(0);
        JSONArray steps = legs.getJSONArray(0);
        for(int i=0;i<steps.length();i++) {
            JSONObject singleStep = steps.getJSONObject(i);
            JSONObject duration = singleStep.getJSONObject("duration");
            Bundle dur = new Bundle();
            dur.putString("text", duration.getString("text"));
            dur.putString("value", duration.getString("value"));
            JSONObject distance = singleStep.getJSONObject("distance");
            Bundle dis = new Bundle();
            dis.putString("text", distance.getString("text"));
            dis.putString("value", distance.getString("value"));
            Bundle data = new Bundle();
            data.putBundle("duration", dur);
            data.putBundle("distance", dis);
            list.add(data);
        }
} catch (JSONException e1) {
        // TODO Auto-generated catch block
        e1.printStackTrace();
}*/
//}



function saveRouteParams(){
    startAddr = document.getElementById("start_addr").value;
    sessionStorage.setItem("startAddr", startAddr);
    endAddr = document.getElementById("end_addr").value;
    sessionStorage.setItem("startAddr", startAddr);
    
    //getPlace(startAddr);
    getRoute();
}