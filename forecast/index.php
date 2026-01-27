<?php
$apiKey = "6e3d22df8f0196f8edef0e0fcbeb139d";
$cityId = "3114965";

$weatherApiUrl = "http://api.openweathermap.org/data/2.5/forecast?id={$cityId}&lang=en&units=metric&APPID={$apiKey}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $weatherApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response);
$currentTime = time();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima de <?php echo $data->city->name; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            background: #eef2f7;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .weather-card {
            background: linear-gradient(135deg, rgba(0,0,0,0.6), rgba(0,0,0,0.3)), 
                        url("https://images.unsplash.com/photo-1504608524841-42fe6f032b4b?auto=format&fit=crop&w=800&q=80");
            background-size: cover;
            background-position: center;
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
            color: #fff;
            width: 100%;
            max-width: 450px;
            padding: 40px 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }

        /* Cabecera */
        .header-info h2 {
            font-weight: 600;
            margin: 0;
            font-size: 2.2rem;
        }
        .header-info small {
            color: rgba(255,255,255,0.7);
            font-size: 1.4rem;
            display: block;
            margin-top: 5px;
        }

        /* Cuerpo Central */
        .current-weather {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 40px 0;
        }

        .temp-main {
            font-size: 7rem;
            font-weight: 300;
            line-height: 1;
        }

        .temp-range {
            font-size: 1.4rem;
            opacity: 0.8;
        }

        .weather-desc {
            text-align: right;
        }
        .weather-desc img {
            width: 80px;
            filter: drop-shadow(0 0 10px rgba(255,255,255,0.2));
        }
        .weather-desc p {
            margin: 0;
            text-transform: capitalize;
            font-size: 1.6rem;
        }

        /* Pronóstico Horario */
        .forecast-grid {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 25px;
            overflow-x: auto;
            gap: 15px;
        }

        .forecast-item {
            text-align: center;
            min-width: 60px;
            transition: all 0.3s ease;
        }

        .forecast-item:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 5px 0;
        }

        .forecast-item span {
            display: block;
            font-size: 1.2rem;
            opacity: 0.7;
            margin-bottom: 5px;
        }

        .forecast-item strong {
            font-size: 1.6rem;
            display: block;
        }

        .forecast-item img {
            width: 40px;
        }

        /* Ocultar scrollbar */
        .forecast-grid::-webkit-scrollbar { display: none; }
    </style>
</head>
<body>

    <div class="weather-card">
        <div class="header-info">
            <h2><?php echo $data->city->name; ?></h2>
            <small><?php echo date("jS F, Y", $currentTime); ?></small>
        </div>

        <div class="current-weather">
            <div class="temp-section">
                <div class="temp-main"><?php echo round($data->list[0]->main->temp); ?>°</div>
                <div class="temp-range">
                    Máx: <?php echo round($data->list[0]->main->temp_max); ?>° / Mín: <?php echo round($data->list[0]->main->temp_min); ?>°
                </div>
            </div>
            <div class="weather-desc">
                <img src="http://openweathermap.org/img/wn/<?php echo $data->list[0]->weather[0]->icon; ?>@2x.png" alt="Icon">
                <p><?php echo $data->list[0]->weather[0]->description; ?></p>
            </div>
        </div>

        <div class="forecast-grid">
            <?php for ($i = 0; $i < 6; $i++) { ?>
                <div class="forecast-item">
                    <span><?php echo date("H:i", $data->list[$i]->dt); ?></span>
                    <img src="http://openweathermap.org/img/wn/<?php echo $data->list[$i]->weather[0]->icon; ?>.png" alt="Icon">
                    <strong><?php echo round($data->list[$i]->main->temp); ?>°</strong>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>