<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin:0;
            padding:0;
        }

        .garciasMobil{
           
            display:none;
        }
        
        .garciasPc{
                
            position: relative;
            width: 100%;
            height:100%;
            /* background-image: url("./poster2.jpg"); */
            background-size:cover;
            background-repeat: no-repeat;
        
        }

        @media (max-width: 800px) {
            .garciasPc{
                display: none  !important;
            }

            .garciasMobil{
                display:block;
                position: relative;
                width: 100%;
                height:100%;
                /* background-image: url("./poster2.jpg"); */
                background-size:cover;
                background-repeat: no-repeat;
            }
        }


    </style>
</head>
<body>

    


<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $celular = htmlspecialchars($_POST['celular']);
    $correo = htmlspecialchars($_POST['correo']);
    $handicap = htmlspecialchars($_POST['handicap']);
    $equipo = htmlspecialchars($_POST['equipo']);
    $campo = htmlspecialchars($_POST['campo']);




    $foto_ticket = $_FILES['foto'];
    $foto_temporal = $foto_ticket['tmp_name'];
    $foto_nombre = $foto_ticket['name'];

        // Comprobar que se haya seleccionado un archivo
    if (empty($foto_temporal) || !is_uploaded_file($foto_temporal)) {
        echo "<p>No se seleccionó ningún archivo.</p>";
    } else {
        // Leer el contenido del archivo
        $foto_contenido = file_get_contents($foto_temporal);
        $foto_tipo = mime_content_type($foto_temporal); // Obtener el tipo MIME del archivo
        $foto_adjunto = chunk_split(base64_encode($foto_contenido));

        // Preparar encabezados para el correo
        $boundary = md5(time()); // delimitador único
        $headers = "From: admin@lightbox.com\r\n";
        $headers .= "Reply-To: $correo\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

        // Preparar cuerpo del mensaje
        $mensaje = "--$boundary\r\n";
        $mensaje .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
        $mensaje .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $mensaje .= "Nombre: $nombre\n";
        $mensaje .= "Celular: $celular\n";
        $mensaje .= "Correo: $correo\n";
        $mensaje .= "Handicap: $handicap\n";
        $mensaje .= "Nombre del equipo: $equipo\n";
        $mensaje .= "Campo en el que juega: $campo\n\r\n";

        // Adjuntar el archivo
        $mensaje .= "--$boundary\r\n";
        $mensaje .= "Content-Type: $foto_tipo; name=\"$foto_nombre\"\r\n";
        $mensaje .= "Content-Transfer-Encoding: base64\r\n";
        $mensaje .= "Content-Disposition: attachment; filename=\"$foto_nombre\"\r\n\r\n";
        $mensaje .= "$foto_adjunto\r\n";
        $mensaje .= "--$boundary--";

        // Enviar correo
        $para = "admin@lightbox.com"; // Añadir más direcciones según sea necesario
        $asunto = "Nuevo formulario enviado con adjunto";

        if (mail($para, $asunto, $mensaje, $headers)) {
            
            echo "<img src='./gracias1.jpg' class='garciasMobil'>";
            echo "<img src='./graciaspc.jpg' class='garciasPc'>";
        } else {
            echo "<img src='./gracias1.jpg' class='garciasMobil'>";
            echo "<img src='./graciaspc.jpg' class='garciasPc'>";
        }
    }
} else {
    // Si el formulario no ha sido enviado correctamente, redirigir al formulario
    header("Location: Cemex.html");
    exit();
}
?>

</body>
</html>