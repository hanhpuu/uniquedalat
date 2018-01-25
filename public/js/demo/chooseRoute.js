$(document).ready(function () {
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var index = $(this).attr('data-index');
    var data = myJSON[index].data;   
    var elementId = 'map_' + index;
    initialize(elementId, data);
  });

  function initializeMap() {
    
    for(var agenda of myJSON) {
      agenda.data.unshift({name: 'Điểm xuất phát',lat:lat, lng: lng,hour:0});
    }
    var elementId = 'map_' + 0;
    initialize(elementId, myJSON[0].data);
  }
  
  function initialize(elementId, data) {
    var map = new window.google.maps.Map(document.getElementById(elementId));
    console.log(elementId);
    console.log(data);
    // new up complex objects before passing them around
    var directionsDisplay = new window.google.maps.DirectionsRenderer({suppressMarkers: true});
    var directionsService = new window.google.maps.DirectionsService();
    Tour_startUp(data);

    window.tour.loadMap(map, directionsDisplay);
    window.tour.fitBounds(map);

    if (data.length > 1)
      window.tour.calcRoute(directionsService, directionsDisplay);
    return map;

  }
  initializeMap();
});