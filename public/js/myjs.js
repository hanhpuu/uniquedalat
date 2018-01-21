
var LocsA = [
    {
        lat: 11.9331,
        lon: 108.4302,
        title: 'Hanahouse',
        html: '<h3>Hanahouse<h3>',
        icon: 'http://maps.google.com/mapfiles/markerA.png',
        animation: google.maps.Animation.DROP,
        playing_hour: 1,
        visible: true
    },
    {
        lat: 11.947230,
        lon: 108.418782,
        title: 'Flower village',
        html: '<h3>Flower village<h3>',
        icon: 'http://maps.google.com/mapfiles/markerB.png',
        playing_hour: 2,
        visible: true
    },
    {
        lat: 11.937657,
        lon: 108.381188,
        title: 'Hoa Son Dien Trang',
        html: '<h3>Hoa Son Dien Trang<h3>',
        icon: 'http://maps.google.com/mapfiles/markerC.png',
        playing_hour: 3,
        visible: true,
     
    },
    {
        lat: 11.901027,
        lon: 108.351420,
        title: 'Melinh Coffee',
        html: '<h3>Melinh Coffee<h3>',
        icon: 'http://maps.google.com/mapfiles/markerD.png',
        playing_hour: 3,
        visible: true,
   
    }
];
  

var ALen = LocsA.length;
var totalHour = 0;
for (var i = 0; i < ALen; i++) {
    totalHour += LocsA[i].playing_hour;
}
$("#hours").text(totalHour)


$(document).ready(function () {

    var myMap = new Maplace({
        locations: LocsA,
        map_div: '#gmap-route',
        generate_controls: false,
        show_markers: true,
        directions_panel: '#route',
        afterRoute: function(distance) {
        $('#km').text(': '+(distance/1000)+'km');   
    }
    });
    myMap.Load();

    $("#choose").click(function () {
        myMap.ViewOnMap(1);
    });

    $("#del").click(function () {
        var index = 1;
        myMap.RemoveLocations(index, true);
        var hours = LocsA[index].playing_hour;
        totalHour -= hours;
        $("#hours").text(totalHour);
    });

    $("#add").click(function () {
        var index = 1;
        myMap.AddLocation({
            lat: 44.8,
            lon: 1.7,
            title: 'Title B1',
            html: '<h3>Content B1<h3>',
            icon: 'http://maps.google.com/mapfiles/markerB.png',
        }, index, true);
        var hours = LocsA[index].playing_hour;
        totalHour += hours;
        $("#hours").text(totalHour);
    });


});


 