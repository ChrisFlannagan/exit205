function initMap() {

    var mapdiv = document.getElementById(exit205_map.map_id);
    var myLatLng = {lat: Number(exit205_map.map_lat), lng: Number(exit205_map.map_lng)};
    mapdiv.style.height = "500px";

    var map = new google.maps.Map(mapdiv, {
        zoom: Number(exit205_map.zoom),
        center: myLatLng
    });

    var marker, i;

    for(i = 0; i < exit205_map.markers.length; i++) {

        marker = new google.maps.Marker({
            position: {lat: Number(exit205_map.markers[i].lat), lng: Number(exit205_map.markers[i].lng)},
            map: map,
            title: exit205_map.markers[i].title
        });

        /**
         google.maps.event.addListener(marker, 'click', (function(marker, i) {
         return function() {
             infowindow.setContent(locations[i][0]);
             infowindow.open(map, marker);
         }
            })(marker, i));
         */
    }
}