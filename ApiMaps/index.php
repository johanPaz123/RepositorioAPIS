<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduccion a Generar Mapas</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin="">
    <style>
        #map{
            height: 60vh;
        }
    </style>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

</head>
<body>
    <?php
        $latitud = isset($_POST['latitud']) ? trim(htmlspecialchars($_POST['latitud'])) : '42.33669';

        $longitud = isset($_POST['longitud']) ? trim(htmlspecialchars($_POST['longitud'])) : '-7.86407';
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <label for="lat">Latitud</label><input type="text" id="lat" name="latitud" value="<?php echo $latitud?>">
        <label for="long">Longitud</label><input type="text" id="long" name="longitud" value="<?php echo $longitud?>">
        <input type="submit" value="Buscar">
    </form>
    <div id="map">

    </div>
    <script>
        let map = L.map('map').setView([<?php echo $latitud;?>, <?php echo $longitud?>],15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let marker = L.marker([42.3309281, -7.8770686]).addTo(map);
        marker.bindPopup("<b>C.I.F.P A Carballeira</b><br><a href='https://cifpacarballeira.gal/' target='_blank'>Visitar Sitio</a>").openPopup();

        let circle = L.circle([42.3407091,-7.8758489], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 250
        }).addTo(map);

        let polygonB = L.polygon([
            [42.338179, -7.869550],
            [42.338229, -7.869377],
            [42.334927, -7.867410],
            [42.334887, -7.867539]
        ]).addTo(map);

        let polygonM = L.polygon([
            [42.345912, -7.875412],
            [42.345325, -7.875578],
            [42.344814, -7.868776],
            [42.346959, -7.863396],
            [42.347676, -7.864082],
            [42.345722, -7.868851],
        ]).addTo(map)
    </script>
</body>
</html>