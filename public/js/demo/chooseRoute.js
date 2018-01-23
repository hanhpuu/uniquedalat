var map = [];
function initializeMap() {

    for (const index in myJSON) {
        var data = myJSON[index].data;
        data.unshift(['Your hotel', lat, lng, 0]);
        var elementId = 'map_' + index;

        map[elementId] = initialize(elementId, data);
    }

}




function initialize(id, data) {
    var directionsService = new google.maps.DirectionsService();

    var directionsDisplay = new google.maps.DirectionsRenderer();
    var mapDiv = document.getElementById(id);
    var map = new google.maps.Map(mapDiv, {
        zoom: 10,
        center: new google.maps.LatLng(lat, lng),
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

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent(data[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));

        if (i == 0)
            request.origin = marker.getPosition();
        else if (i == data.length - 1)
            request.destination = marker.getPosition();
        else {
            if (!request.waypoints)
                request.waypoints = [];
            request.waypoints.push({
                location: marker.getPosition(),
                stopover: true
            });
        }

    }
    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
        }
    });
    return map;

    
}
google.maps.event.addDomListener(window, "load", initializeMap);

$(document).ready(function () {
//    $('.agenda').change(function () {
//        $('input:checkbox').not(this).prop('checked', false);
//        $.uniform.update();
//    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var index = $(this).attr('data-index');
        var elementId = 'map_' + index;
        var gMap = map[elementId]
        google.maps.event.trigger(gMap, 'resize');
        gMap.setZoom(12);      // This will trigger a zoom_changed on the map
        gMap.setCenter(new google.maps.LatLng(lat, lng));
        gMap.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    });
});



