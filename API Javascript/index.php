<?php
    if(isset($_GET['url_name']) && !empty($_GET['url_name'])){
        $url = htmlspecialchars($_GET['url_name']); 
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar QR</title>
</head>
<body>
    <h1>Generar Un QR de un enlace</h1>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
        <label for="url">Link a convertir:</label>
        <input id="url" name="url_name" type="text" placeholder="Introduce tu url" value="">
        <br><br>
        <input type="submit" value="Enviar Dato">
    </form><br>
    <div id="qrCode">
        
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    // PHP inline variable inside JavaScript
    const qrText = "<?php echo $url; ?>";

    if (qrText !== "") {
        new QRCode(document.getElementById("qrCode"), {
            text: qrText,
            width: 200,
            height: 200
        });
    }
</script>

</body>
</html>