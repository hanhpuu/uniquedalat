var LocsA = [
    {
        lat: 45.9,
        lon: 10.9,
        title: 'Title A1',
        html: '<h3>Content A1<h3>',
        icon: 'http://maps.google.com/mapfiles/markerA.png',
        animation: google.maps.Animation.DROP
    },
    {
        lat: 44.8,
        lon: 1.7,
        title: 'Title B1',
        html: '&lt;h3&gt;Content B1&lt;/h3&gt;',
        icon: 'http://maps.google.com/mapfiles/markerB.png',
        show_infowindow: false
    },
    {
        lat: 51.5,
        lon: -1.1,
        title: 'Title C1',
        html: [
            '&lt;h3&gt;Content C1&lt;/h3&gt;',
            '&lt;p&gt;Lorem Ipsum..&lt;/p&gt;'
        ].join(''),
        zoom: 8,
        icon: 'http://maps.google.com/mapfiles/markerC.png'
    }
];


$(document).ready(function () {
    var myMap = new Maplace({
        locations: LocsA,
        map_div: '#gmap-dropdown',
        controls_title: 'Choose a location:',
        afterShow: function() {
            console.log(123);
        }
    })
    myMap.Load();
});
