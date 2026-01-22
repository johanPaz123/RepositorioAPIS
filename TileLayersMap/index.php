<?php
$config = [
    "lat"  => 42.3309281,
    "lng"  => -7.8770686,
    "zoom" => 14
];

$capas = [
    "Mapa" => [
        "url" => 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
        "attr" => '&copy; OpenStreetMap'
    ],
    "Satélite" => [
        "url" => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        "attr" => 'Tiles © Esri'
    ],
    "Topográfico" => [
        "url" => 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
        "attr" => 'OpenTopoMap'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mapa Dinámico PHP-Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>#map { height: 60vh; border-radius: 10px; }</style>
</head>
<body>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const config = <?= json_encode($config) ?>;
    const capasData = <?= json_encode($capas) ?>;

    const map = L.map('map').setView([config.lat, config.lng], config.zoom);

    const baseLayers = {};

    Object.keys(capasData).forEach((nombre, index) => {
        const capa = L.tileLayer(capasData[nombre].url, {
            maxZoom: 19,
            attribution: capasData[nombre].attr
        });

        baseLayers[nombre] = capa;

        if (index === 0) {
            capa.addTo(map);
        }
    });

    L.control.layers(baseLayers).addTo(map);
</script>

</body>
</html>