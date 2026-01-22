<?php
	$latitude = 42.343059;
	$longitude = -7.870041;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<base target="_top">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Quick Start - Leaflet</title>
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

	<style>
		html, body {
			height: 100%;
			margin: 0;
		}
		.leaflet-container {
			height: 400px;
			width: 600px;
			max-width: 100%;
			max-height: 100%;
		}
	</style>
</head>
<body>

<div id="map" style="width: 800px; height: 600px;"></div>
<script>
	// Initialize the map
	const map = L.map('map').setView([<?php echo "$latitude"; ?>, <?php echo "$longitude"; ?>], 13);

	// Add the OpenStreetMap tiles
	const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 25,
	}).addTo(map);

	// Read markers from the PHP file
	<?php
		$archivo = fopen('mapFavorites.txt', "r");
		while ($linea = fgets($archivo)) {
			$partes = explode('#', trim($linea)); 
			$lat = $partes[0];
			$lon = $partes[1];
			$text = $partes[2];
			$url = $partes[3];
	?>
		// Add a marker for each line in the file
		var marker = L.marker([<?php echo $lat; ?>, <?php echo $lon; ?>]).addTo(map);
		marker.bindPopup("<b><?php echo $text; ?></b><br><a href='<?php echo $url; ?>' target='_blank'>Web del sitio</a>");
    <?php
		}
		fclose($archivo);
	?>
</script>

</body>
</html>