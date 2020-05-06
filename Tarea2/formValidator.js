function notification_correct(){
    var conf = window.confirm("¿Está seguro de que la información está correcta?");
    if (conf) {
        window.alert("Formulario enviado correctamente");
    }
}

function nameValidation(container) {
    var nombre = document.getElementsByName(container)[0].value;
    var name_regex = /^[a-zA-Z]*$/;
    if (nombre.length > 20 || nombre.length < 3) {
        alert("Su nombre no debe exceder los 20 carácteres");
        return false;
    }
    if (!name_regex.test(nombre)) {
        alert(("Su nombre solo puede contener letras"));
        return false;
    }
    return true;
    }

function textValidation(container, maxlength){
    var cont = document.getElementsByName(container)[0].value;
    //var cont = document.getElementById(container)[0].value;
    if (cont.length > maxlength){
        alert("el texto de descripciòn excede los 500 caracteres.");
        return false;
    }
    return true;
}
    
function especialidadesValidation(container){
    var itemList = document.getElementById(container);
    var selected = itemList.selectedOptions;
    if (selected.length == 0){
        window.alert("Debe especificar al menos una especialidad");
        return false;
    }
    if (selected.length > 5){
        window.alert("Demasiadas especialidades indicadas");
        return false;
    }
    return true;

}

//https://stackoverflow.com/questions/10105411/how-to-limit-the-maximum-files-chosen-when-using-multiple-file-input
function fotos_medicoValidation(){
    if (jQuery("#foto-medico")[0].files.length > 5) {
        alert("No pueden ser más de 5 fotos");
        return false;
    }
    if (jQuery("#foto-medico")[0].files.length == 0) {
        alert("Se debe entregar al menos una foto");
        return false;
    }
    return true;
}


function twitterValidation(container){
    var twitter_nick  = document.getElementsByName(container)[0].value;
    var twitter_regex = /@[A-Za-z0-9_]+/;
    if (twitter_nick.length == 0){
        //case no twitter was given
        return true; 
    }
    if (!twitter_regex.test(twitter_nick)) {
        alert("El twitter entregado no es válido. Recuerde agregar @ al inicio.");
        return false;
    }
    if (twitter_nick.length > 80 || twitter_nick.length < 3) {
        alert("El twitter entregado es muy largo o demasiado corto.");
        return false;
    }
    return true;
}

function emailValidation(container){
    var email  = document.getElementsByName(container)[0].value;
    var email_regex = /[A-Za-z0-9_]+@[A-Za-z0-9_]+.[A-Za-z0-9_]+/;
    if (email.length > 80 || email.length < 3 || !email_regex.test(email)) {
        alert("El email entregado no es válido");
        return false;
    }
    return true;
}

function celularValidation(container){
    var celular  = document.getElementsByName(container)[0].value;
    var number_regex = /[+ 0-9]+/;
    if (celular.length == 0) {
        //Case no number was given.
        return true;
    }
    if (celular.length > 12 || celular.length < 7 || !number_regex.test(celular) ) {
        alert("El número entregado no es válido");
        return false;
    }
    return true;
}

function regionValidation(container){
    var region = jQuery('#region-'+container).val();
    if (region == 'sin-region' || region == ''){
        alert('Región no seleccionada');
        return false;
    }
    var comuna = jQuery('#comun'+container).val();
    if (comuna == 'sin-comuna' || comuna == ''){
        alert('Comuna no seleccionada');
        return false;
    }
    return true;
}


// Main function
function dataValidator() {
    // Validate nombre médico
    if (!nameValidation("nombre-medico")){
        return false;
    }

    // Validate text description
    var maxlength = 500;
    if (!textValidation("experiencia-medico", maxlength)){
        return false;
    }

    // Validate especialidades
    if (!especialidadesValidation("especialidades-medico")){
        return false;
    }

    // Validate fotos médico
    if (!fotos_medicoValidation()){
        return false;
    }

    // Validate twitter médico
    if (!twitterValidation("twitter-medico")){
        return false;
    }

    // Validate email 
    if (!emailValidation("email-medico")){
        return false;
    }
    // Validate número de contacto 
    if (!celularValidation("celular-medico")){
        return false;
    }

    // Validate region medico
    if (!regionValidation('medico')){
        return false;
    }

    notification_correct();
    return true;
}


function solicitudeValidator(){
    /*
    if (!nameValidation("nombre-solicitante")){
        return false;
    }
    */
    // Validate symptoms description
    var maxlength = 500
    if (!textValidation("sintomas-solicitante", maxlength)){
        return false;
    }
    // Validate files 
    if (!archivosValidation()){
        return false;
    }
   // Validate twitter médico
   if (!twitterValidation("twitter-solicitante")){
         return false;
    }
    // Validate email 
    if (!emailValidation("email-solicitante")){
        return false;
    }
    // Validate número de contacto 
    if (!celularValidation("celular-solicitante")){
        return false;
    }    
    notification_correct();
    return true;
    }

function cleanForm() {
    document.getElementById("formulario").reset();
}

    // defining regiones and comunas json like
    var RegionesYcomunas = {
    "regiones": [
    {
        "NombreRegion": "Región Arica y Parinacota",
        "comunas": ["Arica", "Camarones", "Putre", "General Lagos"]
    },
    {
        "NombreRegion": "Región de Tarapacá",
        "comunas": ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
    },
    {
        "NombreRegion": "Región de Antofagasta",
        "comunas": ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
    },
    {
        "NombreRegion": "Región de Atacama",
        "comunas": ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
    },
    {
        "NombreRegion": "Región de Coquimbo",
        "comunas": ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
    },
    {
        "NombreRegion": "Región de Valparaíso",
        "comunas": ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
    },
    {
        "NombreRegion": "Región del Libertador Bernardo Ohiggins",
        "comunas": ["Rancagua (No existe)", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
    },
    {
        "NombreRegion": "Región del Maule",
        "comunas": ["Talca", "Constitución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
    },
    {
        "NombreRegion": "Región del Biobío",
        "comunas": ["Concepción", "Coronel", "Chiguayante", "Florida", "Hualqui", "Lota", "Penco", "San Pedro de la Paz", "Santa Juana", "Talcahuano", "Tomé", "Hualpén", "Lebu", "Arauco", "Cañete", "Contulmo", "Curanilahue", "Los Álamos", "Tirúa", "Los Ángeles", "Antuco", "Cabrero", "Laja", "Mulchén", "Nacimiento", "Negrete", "Quilaco", "Quilleco", "San Rosendo", "Santa Bárbara", "Tucapel", "Yumbel", "Alto Biobío",  "Bulnes", "Cobquecura", "Coelemu"]
    },
    {
        "NombreRegion": "Región de Ñuble",
        "comunas": ["Chillán", "Coihueco", "Chillán Viejo", "El Carmen", "Ninhue", "Ñiquén", "Pemuco", "Pinto", "Portezuelo", "Quillón", "Quirihue", "Ránquil", "San Carlos", "San Fabián", "San Ignacio", "San Nicolás", "Treguaco", "Yungay"]
    },
    {
        "NombreRegion": "Región de La Araucanía",
        "comunas": ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria", ]
    },
    {
        "NombreRegion": "Región de Los Ríos",
        "comunas": ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
    },
    {
        "NombreRegion": "Región de Los Lagos",
        "comunas": ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
    },
    {
        "NombreRegion": "Región Aisén del General Carlos Ibáñez del Campo",
        "comunas": ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
    },
    {
        "NombreRegion": "Región de Magallanes y la Antártica Chilena",
        "comunas": ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
    },
    {
        "NombreRegion": "Región Metropolitana de Santiago",
        "comunas": ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Vitacura", "Puente Alto", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilVl", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor"]
    }
    ]};

    jQuery(document).ready(function () {
        var iRegion = 0;
        var htmlRegion = '<option value="sin-region">Seleccione región</option><option value="sin-region">--</option>';
        var htmlComunas = '<option value="sin-region">Seleccione comuna</option><option value="sin-region">--</option>';

        jQuery.each(RegionesYcomunas.regiones, function () {
        htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '">' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
        iRegion++;
        }
        );

    jQuery('#region-medico').html(htmlRegion);
    jQuery('#comuna-medico').html(htmlComunas);

    jQuery('#region-medico').change(function () {
    var iRegiones = 0;
    var valorRegion = jQuery(this).val();
    var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option><option value="sin-comuna">--</option>';
    jQuery.each(RegionesYcomunas.regiones, function () {
        if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
        var iComunas = 0;
        jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
            htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
            iComunas++;
        });
        }
        iRegiones++;
    });
    jQuery('#comuna-medico').html(htmlComuna);
    });
    jQuery('#comuna-medico').change(function () {
    if (jQuery(this).val() == 'sin-region') {
        alert('seleccionar Región');
    } else if (jQuery(this).val() == 'sin-comuna') {
        alert('seleccionar Comuna');
    }
    });
    jQuery('#regiones').change(function () {
    if (jQuery(this).val() == 'sin-region') {
        alert('seleccionar Región');
    }
    }); 

    }); //fin jquery.ready()  

    // for solicitante
    jQuery(document).ready(function () {
        var iRegion = 0;
        var htmlRegion = '<option value="sin-region">Seleccione región</option><option value="sin-region">--</option>';
        var htmlComunas = '<option value="sin-region">Seleccione comuna</option><option value="sin-region">--</option>';

        jQuery.each(RegionesYcomunas.regiones, function () {
        htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '">' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
        iRegion++;
        }
        );

    jQuery('#region-solicitante').html(htmlRegion);
    jQuery('#comuna-solicitante').html(htmlComunas);

    jQuery('#region-solicitante').change(function () {
    var iRegiones = 0;
    var valorRegion = jQuery(this).val();
    var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option><option value="sin-comuna">--</option>';
    jQuery.each(RegionesYcomunas.regiones, function () {
        if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
        var iComunas = 0;
        jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
            htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
            iComunas++;
        });
        }
        iRegiones++;
    });
    jQuery('#comuna-medico').html(htmlComuna);
    });
    jQuery('#comuna-medico').change(function () {
    if (jQuery(this).val() == 'sin-region') {
        alert('seleccionar Región');
    } else if (jQuery(this).val() == 'sin-comuna') {
        alert('seleccionar Comuna');
    }
    });
    jQuery('#regiones').change(function () {
    if (jQuery(this).val() == 'sin-region') {
        alert('seleccionar Región');
    }
    }); 

    }); //fin jquery.ready()  


function cleanForm() {
    document.getElementById("formulario").reset();
}