<?php
$apiKey = "1ff11a55bf2c1927c1dcb0d0146266da";
$cityId = "3114965";
$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forecast Glassmorphism</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(135deg, #a7bfe8, #6190e8);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.2); 
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px); 
            border-radius: 20px; 
            border: 1px solid rgba(255, 255, 255, 0.3); 
            width: 500px;
            padding: 40px;
            color: #fff; 
        }
        .weather-icon-lg {
            width: 120px;
            height: 120px;
            filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.2));
        }
        .temp-display {
            font-size: 5rem;
            font-weight: 300;
            line-height: 1;
        }
        .coordinates, .footer-text {
            font-size: 0.8rem;
            opacity: 0.7;
        }
        .detail-value {
            font-weight: bold;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="glass-card text-center">
            <div class="mb-4 text-start">
                <h2 class="fw-bold mb-0"><?php echo $data->name; ?></h2>
                <p class="text-white-50 mb-1">Estado del Clima</p>
                <p class="small mb-0"><?php echo date("l jS F, g:i a", $currentTime); ?></p>
                <p class="small text-capitalize"><?php echo ucwords($data->weather[0]->description); ?></p>
            </div>
            
            <div class="d-flex flex-column align-items-center mb-4">
                <img src="http://openweathermap.org/img/wn/<?php echo $data->weather[0]->icon; ?>@2x.png"
                    class="weather-icon-lg mb-3" alt="Icono del Clima" />
                
                <p class="temp-display">
                    <?php echo round($data->main->temp); ?>°C
                </p>
                <p class="coordinates mb-0">
                    Lat: <?php echo $data->coord->lat; ?>, Lon: <?php echo $data->coord->lon; ?>
                </p>
            </div>

            <div class="row text-center mt-4 pt-3 border-top border-white border-opacity-25">
                
                <div class="col-6 mb-3">
                    <p class="mb-0 small text-white-50">Máxima</p>
                    <p class="detail-value"><?php echo $data->main->temp_max; ?>°C</p>
                    <p class="mb-0 small text-white-50">Mínima</p>
                    <p class="detail-value"><?php echo $data->main->temp_min; ?>°C</p>
                </div>

                <div class="col-6 mb-3 border-start border-white border-opacity-25">
                    <p class="mb-0 small text-white-50">Humedad</p>
                    <p class="detail-value"><?php echo $data->main->humidity; ?>%</p>
                    <p class="mb-0 small text-white-50">Viento</p>
                    <p class="detail-value"><?php echo $data->wind->speed; ?> m/s</p>
                </div>
            </div>

            <p class="footer-text mt-3">Datos de OpenWeatherMap</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>