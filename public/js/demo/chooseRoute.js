function initializeMap() {
    for (const prop in myJSON) {
        var data = myJSON[prop];
        var name = 'map['+ prop +']';
        initialize(name, data);
    }
}

var geocoder;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();


function initialize(name, data) {
  directionsDisplay = new google.maps.DirectionsRenderer();
  
  var mapDiv = document.getElementById(map[agendaName]);
  var map = new google.maps.Map(mapDiv, {
    zoom: 10,
    center: new google.maps.LatLng(11.824717, 108.334160),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  directionsDisplay.setMap(map);
  var infowindow = new google.maps.InfoWindow();

  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };
  for (i = 0; i < data.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(data[i][1], data[i][2]),
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(data[i][0]);
        infowindow.open(map, marker);
      }
    })(marker, i));

    if (i == 0) request.origin = marker.getPosition();
    else if (i == data.length - 1) request.destination = marker.getPosition();
    else {
      if (!request.waypoints) request.waypoints = [];
      request.waypoints.push({
        location: marker.getPosition(),
        stopover: true
      });
    }

  }
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });
}
google.maps.event.addDomListener(window, "load", initializeMap);

$( document ).ready(function() {
    $('.agenda').change(function(){
        $('input:checkbox').not(this).prop('checked', false);    
        $.uniform.update();
    });    
});



