`El  listado  debe mostrar  el nombre  del  médico,  especialidades,  twitter
,  email decontacto y un enlace para “ver fotografiás”, al hacer click sobre el enlace,
 este se debe abrir unanueva pestaña o ventana del navegador incluyendo las fotografías 
 en tamaño 320x240 asociadas almédico correspondiente`

var doctor = {nombre:"John", especialidades:"", twitter:"", email:"", enlace_fotografias:""};

function displayDoctor(marker, id, name, especialidades, twitter, email, celular){

    var string =  `<table>
        <!-- intro row -->
        <tr>
        <th>Campo de información</th>
        <th>Información del Médico</th>
        </tr>

        <!-- Nombre row -->
        <tr>
        <th>Nombre del médico</th>
        <th>${name}</th>
        </tr>

        <!-- Especialidad row -->
        <tr>
        <th>Especialidades</th>
        <th>${especialidades} </th>
        </tr>

        <!-- Fotos row -->
        <tr>
        <th>Fotos del Médicos</th>
        <th>  <a href="generador_fotos.php?id=${id}" target="popup")"> Ver fotos </a> </th>
        </tr>

        <!-- Twitter row -->
        <tr>
        <th>Twitter del médico</th>
        <th>${twitter}</th>
        </tr>

        <!-- Email row -->
        <tr>
        <th>Email del médico</th>
        <th>${email}</th>
        </tr>

        <!-- Número row -->
        <tr>
        <th>Número de celular del médico</th>
        <th>${celular} </th>
        </tr>
        </table>
         `;

    return string;
}

var mymap = L.map('mapid').setView([-33.44, -70.67], 8);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1
}).addTo(mymap);


function loadDisplayDoctors(marker, comuna) {
    var xhr = new XMLHttpRequest();
    try {
        xhr = new XMLHttpRequest();
    } catch (e) {
        try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Your browser broke!");
                return false;
            }
        }
    }

    xhr.open("GET", "get_comunas_with_doctors.php?query=" + comuna);
    xhr.send();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                //Json con información de los médicos de la comuna.
                var json = JSON.parse(xhr.responseText);
                //ejemplo json: {
                //   "id": "1",
                //   "nombre": "Javier Jerez",
                //   "twitter": "@jajerez",
                //   "email": "jajaja@gmail.com",
                //   "celular": "94393925",
                //   "nombre_comuna": "Arica"
                //   "especialidades"
                // }
                // cada elemento representa un médico
                var popup_content = "<b>".concat(json[0].nombre_comuna, "</b> <br>");

                json.forEach(element => {
                    var id = element.id;
                    var name = element.nombre;
                    var twitter = element.twitter;
                    var email = element.email;
                    var celular = element.celular;
                    var especialidades = element.especialidades;
                    var string_to_add = displayDoctor(marker, id, name, especialidades, twitter, email, celular);
                    popup_content = popup_content.concat(string_to_add, "<br>");
                });
                marker.bindPopup(popup_content);
            }
        }
    }

}

function loadJSON() {
    var xhr = new XMLHttpRequest();
    try {
        xhr = new XMLHttpRequest();
    } catch (e) {
        try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Your browser broke!");
                return false;
            }
        }
    }
    xhr.open("GET", "get_comunas_with_doctors.php?query=json");
    xhr.send();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var json = JSON.parse(xhr.responseText);
                console.log("returned json");
                console.log(json);

                json.forEach(element => {
                    var marker = L.marker([element.lat, element.long],
                        {title: 'Num doctors: '.concat(element.num_doctors)}).addTo(mymap);
                    loadDisplayDoctors(marker, element.comuna);
                    //var str_comuna = "<b>".concat(element.comuna, "</b> <br>");
                    //marker.bindPopup(str_comuna);
                });
            }
        }
    }

}





loadJSON();
