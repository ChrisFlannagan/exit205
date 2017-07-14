function initMap() {

    var mapdiv = document.getElementById(exit205_map.map_id);
    var myLatLng = {lat: Number(exit205_map.map_lat), lng: Number(exit205_map.map_lng)};
    mapdiv.style.height = "500px";

    var map = new google.maps.Map(mapdiv, {
        zoom: Number(exit205_map.zoom),
        center: myLatLng
    });

    var i, content, infowindow;
    var markers = [];
    var infowindows = [];

    for (i = 0; i < exit205_map.markers.length; i++) {

        markers[i] = new google.maps.Marker({
            position: {lat: Number(exit205_map.markers[i].lat), lng: Number(exit205_map.markers[i].lng)},
            map: map,
            title: exit205_map.markers[i].title,
            id: i
        });

        content = '<div>' +
            '<h3>' + exit205_map.markers[i].title + '</h3>' +
            '<p>' + exit205_map.markers[i].address + '</p>' +
            '<p><a style="color:blue;" href="' + exit205_map.markers[i].website + '" target="_blank">Visit Website</a></p>';
        if (exit205_map.markers[i].thumbnail) {
            console.log(exit205_map.markers[i].thumbnail);
            content += '<p style="text-align: center;"><img src="' + exit205_map.markers[i].thumbnail + '" /></p>';
        }

        infowindows[i] = new google.maps.InfoWindow({
            content: content,
            id: i
        });

        google.maps.event.addListener(markers[i], 'click', function () {
            infowindows[this.id].open(map, markers[this.id]);
        });
    }
}