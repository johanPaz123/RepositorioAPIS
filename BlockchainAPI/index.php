<?php

$ch_list = curl_init();

curl_setopt($ch_list, CURLOPT_URL, "https://api.blockchain.com/v3/exchange/tickers");
curl_setopt($ch_list, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_list, CURLOPT_USERAGENT,'PHP-Scanner');

$response_list =curl_exec($ch_list);

$opciones = json_decode($response_list, true) ?? [];

$precio_actual = 0;
$conversion = null;
$error = null;
$simbolo_eleccion = $_POST['simbolo'] ?? '';

if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['simbolo'])){
    $cantidad = (float)$_POST['cantidad'];
    $simbolo_eleccion = $_POST['simbolo'];

    $ch_price = curl_init();
    curl_setopt($ch_price, CURLOPT_URL, "https://api.blockchain.com/v3/exchange/tickers/" . $simbolo_eleccion);
    curl_setopt($ch_price, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_price, CURLOPT_USERAGENT, 'PHP-Conversor');
    $response_price = curl_exec($ch_price);
    $http_code = curl_getinfo($ch_price, CURLINFO_HTTP_CODE);
    curl_close($ch_price);

    if($http_code === 200){
        $data = json_decode($response_price, true);
        $precio_actual = $data['last_trade_price'];
        if($precio_actual > 0){
            $conversion = $cantidad / $precio_actual;
        }
        else {
            $error = "Esta opcion no cuenta con un precio actual para realizar el calculo: ($precio_actual) " . $simbolo_eleccion . ", Prueba con otra opcion de conversion";
        }
    }
    else $error = "No se puede obtener el precio de $simbolo_eleccion.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Conversor Exchange Automático</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding: 20px; background-color: #f8f9fa; }
        .card { background: white; padding: 25px; border-radius: 10px; shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 450px; border: 1px solid #ddd; }
        select, input, button { width: 100%; padding: 12px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; font-weight: bold; cursor: pointer; }
        button:hover { background: #0056b3; }
        .res-box { background: #e9ecef; padding: 15px; border-radius: 5px; margin-top: 15px; border-left: 4px solid #007bff; }
    </style>
</head>
<body>

<div class="card">
    <h2>Conversor con Tickers Reales</h2>
    
    <form method="post">
        <label>Selecciona un par del Exchange:</label>
        <select name="simbolo" required>
            <option value="">-- Selecciona un símbolo --</option>
            <?php 
            foreach ($opciones as $ticker) {
                $s = $ticker['symbol'];
                $selected = ($simbolo_eleccion == $s) ? 'selected' : '';
                echo "<option value=\"$s\" $selected>$s</option>";
            }
            ?>
        </select>

        <label>Cantidad a convertir:</label>
        <input type="number" step="any" name="cantidad" value="
        <?php echo $_POST['cantidad'] ?? ''; ?>
        " required>
        
        <button type="submit">Calcular</button>
    </form>

    <?php if ($conversion !== null): ?>

        <div class="res-box">
            <small>Precio actual (<?php echo $simbolo_eleccion; ?>): <?php echo $precio_actual; ?></small><br>
            <strong>Resultado: <?php echo number_format($conversion, 8); ?> <?php echo explode('-', $simbolo_eleccion)[0]; ?></strong>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <p id="errorMensaje" style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <script>
        let mensajeError = document.getElementById("errorMensaje");
        setTimeout(() => {
            mensajeError.style.display = "none"
        }, 4000);
    </script>
</div>

</body>
</html>