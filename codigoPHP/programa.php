<?php
/*
 * @author: Aroa Granero Omañas
 * @version: v1
 * Created on: 30/11/2021
 * Last modification: 30/11/2021
 */



//Recupera la sesión del Login
session_start();
//Si no hay una sesión iniciada te manda al Login
if (!isset($_SESSION['usuarioDAW208AppLoginLogout'])) {
    header('location: login.php');
}

//En función del botón que se pulse, el programa se redirige a una u otra ventana
if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header('location: login.php');
    exit;
}

if (isset($_POST["detalle"])) {
    header('Location: detalle.php');
    exit;
}

//Fichero de configuración de la BBDD
require_once '../config/confDBPDO.php';
try {
    // Bloque de código que puede tener excepciones en el objeto PDO
    $mydb = new PDO(HOST, USER, PASSWORD);
    $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $consulta = "SELECT T01_DescUsuario, T01_NumConexiones FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario"; //Consulta para actualizar el total de conexiones y la fechahora de la ultima conexion
    $resultadoConsulta = $mydb->prepare($consulta); //Preparo la consulta antes de ejecutarla
    $parametros = [//guardo en un parametro el usuario obtenido en la sesion del login
        ":CodUsuario" => $_SESSION['usuarioDAW208AppLoginLogout']
    ];
    $resultadoConsulta->execute($parametros); //Ejecuto la consulta con el array de parametros

    $oUsuario = $resultadoConsulta->fetchObject(); //Obtengo el primer registro de la consulta
    $nombreUsuario = $oUsuario->T01_DescUsuario; //Guardo en la variable nombreUsuario el nombre del usuario logeado con exito
    $conexionesUsuario = $oUsuario->T01_NumConexiones; //Guardo en la variable conexionesUsuario el total de conexiones realizadas del usuario logeado con exito

    $ultimaConexionUsuario = $_SESSION['FechaHoraUltimaConexionAnterior']; //Guardo en la variable ultimaConexionUsuario la fecha de la ultima conexion del usuario logeado con exito
    //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
} catch (PDOException $mensajeError) {
    echo "<h3>Mensaje de ERROR</h3>";
    echo "Error: " . $mensajeError->getMessage() . "<br>";
    echo "Código de error: " . $mensajeError->getCode();
} finally {
    unset($mydb);
}
?>



<!DOCTYPE html>
<!--Aroa Granero Omañas 
Fecha Creacion: 30/11/2021
Fecha Modificacion: 30/11/2021 -->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="aroaGraneroOmañas">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="application-name" content="ejercicio00 Tema5">
        <meta name="description" content="variasuper glovales">
        <meta name="keywords" content=" index, ej00" >
        <meta name="robots" content="index, follow" />
        <link rel="shortcut icon" href="favicon.ico">
        <link href="../webroot/css/estilosEjer.css"  rel="stylesheet"  type="text/css" title="Default style">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle</title>
    </head>
    <body>

        <?php if ($conexionesUsuario <= 1) { ?>
            <h1><?php echo "Bienvenid@ " . $nombreUsuario ?></h1>
            <h1><?php echo "Esta es la primera vez que te conectas!" ?></h1>
            <?php
        } else {
            ?>
            <h1><?php echo "Bienvenid@ " . $nombreUsuario ?></h1>
            <h1><?php echo "Es la " . $conexionesUsuario . "ª vez que te conectas." ?></h1>
            <h1><?php echo "Tu ultima conexion fue el " . date('d/m/Y H:i:s', $ultimaConexionUsuario) ?></h1>
            <?php
        }
        ?>    
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input class="button" type="submit" name="detalle" value="detalle"/>
            <input class="button" type="submit" name="logout" value="logout"/>
        </form>
        <footer class="piepagina">
            <a href="https://github.com/aroago/208DWESLoginLogoutTema5" target="_blank"><img src="../webroot/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
            <p><a>&copy;</a>2021 Todos los derechos reservados AroaGO<p>
        </footer>
    </body>
</html>