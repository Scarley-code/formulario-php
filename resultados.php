<?php
    session_start();

    require_once __DIR__ . '/vendor/autoload.php';

    $conexion_exitosa = false;
    $error_conexion = "";

    $respuesta = array(3);
    $respuesta[0] = '';
    $respuesta[1] = '';
    $respuesta[2] = '';
    switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $nombre = $_POST['Nombre'];
            $apellidos = $_POST['Apellidos'];
            $correo = $_POST['Correo'];

            $uri = 'mongodb+srv://mariobg_db_user:JaGaW9EZcUuHt6OF@cluster0.q9wfhgy.mongodb.net/?appName=Cluster0';
            $cliente = new MongoDB\Client($uri);
                
            $admin = $cliente->admin;
            $command = ['ping' => 1];
            $result = $admin->command($command)->toArray();
            echo json_encode($result), PHP_EOL;
            echo "Conectado a MongoDB Atlas\n";
                
            $conexionExitosa = true;

            if(empty($nombre)) {
                $respuesta[0] = "Introduce un nombre";
            }
            if(empty($apellidos)) {
                $respuesta[1] = "Introduce los apellidos";
            }
            if(empty($correo)) {
                $respuesta[2] = "Introduce un correo electrónico";
            } else {
                $respuesta[0] = $nombre;
                $respuesta[1] = $apellidos;
                if(filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                    $respuesta[2] = $correo;
                } else {
                    $respuesta[2] = "Correo electrónico inválido";
                }
            }
        break;
    }
    $_SESSION['Usuario'] = [
        "Nombre" => $respuesta[0],
        "Apellidos" => $respuesta[1],
        "Correo" => $respuesta[2],
    ];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css" />
    <title>Resultados</title>
</head>
<body>
    <p><?php echo $_SESSION['Usuario']['Nombre']; ?></p>
    <p><?php echo $_SESSION['Usuario']['Apellidos']; ?></p>
    <p><?php echo $_SESSION['Usuario']['Correo']; ?></p>
</body>
</html>