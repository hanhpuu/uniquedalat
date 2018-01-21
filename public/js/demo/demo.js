$.fn.datepicker.dates['vn'] = {
  days: ["Chủ nhật", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
  daysShort: ["Chủ nhật", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
  daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
  months: ["Tháng 1", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
  monthsShort: ["Tháng 1", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
  today: "Today",
  clear: "Clear",
  format: "mm/dd/yyyy",
  titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
  weekStart: 0
};

jQuery(document).ready(function () {
  $('.date-picker').datepicker({language: 'vn'});
});

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: {lat: -25.363882, lng: 131.044922}
  });

  map.addListener('click', function (e) {
    placeMarkerAndPanTo(e.latLng, map);
  });
}

function placeMarkerAndPanTo(latLng, map) {
  var marker = new google.maps.Marker({
    position: latLng,
    map: map
  });
  map.panTo(latLng);
}