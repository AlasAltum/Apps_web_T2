var mymap = L.map('mapid').setView([-33.44, -70.67], 10);
var marker = L.marker([-33.44, -70.67]).addTo(mymap);
marker.bindPopup("<b>Santiago</b><br> <a href=\"publicar_solicitud_de_atencion.php\">Publicar Solicitud de Atención</a> ").openPopup();
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1
}).addTo(mymap);

var mymap = L.map('mapid').setView([-33.44, -70.67], 10);
var marker = L.marker([-33.44, -70.67]).addTo(mymap);
marker.bindPopup("<b>Santiago</b><br> <a href=\"publicar_solicitud_de_atencion.php\">Publicar Solicitud de Atención</a> ").openPopup();
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1
}).addTo(mymap);

var json = <?php echo(json_encode($json_comuna_ubication));?>;
console.log(json);
alert(json);



