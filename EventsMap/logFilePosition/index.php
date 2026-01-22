<?php
$latitud = 42.343059;
$longitud = -7.870041;
$logFile = "position.log";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lat'], $_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $fecha = date('Y-m-d H:i:s');
    
    $fileWriter = fopen($logFile, 'a');

    if ($fileWriter) {
        $log_entry = "[$fecha] Latitud : $lat, Longitud : $lng \n";
        fwrite($fileWriter, $log_entry);
        fclose($fileWriter);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos de Mapa</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 400px;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div id="map">
    </div>
    <form id="coordForm" method="POST">
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">
    </form>
    <script>
        let map = L.map('map').setView([<?php echo $latitud; ?>, <?php echo $longitud ?>], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        function logCoordinate(e) {
            const coords = e.latlng;
            document.getElementById('lat').value = coords.lat;
            document.getElementById('lng').value = coords.lng;
            document.getElementById('coordForm').submit();
        }

        map.on('click', logCoordinate)
    </script>
</body>

</html>