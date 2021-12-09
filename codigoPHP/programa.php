<?php
/*
 * @author: Aroa Granero Omañas
 * @version: v1
 * Created on: 30/11/2021
 * Last modification: 09/12/2021
 */

session_start(); //Creo una nueva sesion o recupero una existente

if (!isset($_SESSION['usuarioDAW208AppLoginLogout'])) { //Coimprobar si el usuario no se ha autentificado
    header('Location: login.php'); //Redirijo al usuario al login.php para que se autentifique
    exit;
}

if (isset($_REQUEST['logout'])) { //Comprobar si se ha pulsado el boton volver
    session_destroy(); //Elimino todos los datos que contiene la sesion
    header('Location: ../indexProyectoLoginLogoutTema5.php'); //Vuelvo al login
    exit;
}

if (isset($_REQUEST['editar'])) { //Comprobar si se ha pulsado el boton editarperfil
    header('Location: editarPerfil.php'); //Entro a editar perfil
    exit;
}

if (isset($_REQUEST['detalle'])) { //Comprobar si se ha pulsado el boton detalle
    header('Location: detalle.php'); //Entro a detalle
    exit;
}


require_once '../core/libreriaValidacion.php'; //Incluyo la libreria de validacion
require_once '../config/configDBPDO.php'; //Incluyo las variables de la conexion

try{
    $mydb = new PDO(HOST, USER, PASSWORD); //Hago la conexion con la base de datos
    $mydb -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
        
    $consulta = "SELECT T01_DescUsuario, T01_NumConexiones FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario"; //Consulta para seleccionar la descripcion del usuario y el numero total de conexiones
    $resultadoConsulta = $mydb->prepare($consulta); //Preparo la consulta antes de ejecutarla
    $parametros = [ //guardo en un parametro el usuario obtenido en la sesion del login
        ":CodUsuario" => $_SESSION['usuarioDAW208AppLoginLogout']
    ];
    $resultadoConsulta->execute($parametros);//Ejecuto la consulta con el array de parametros
    
    $oUsuario = $resultadoConsulta->fetchObject(); //Obtengo el primer registro de la consulta
    $nombreUsuario = $oUsuario->T01_DescUsuario; //Guardo en la variable nombreUsuario el nombre del usuario logeado con exito
    $conexionesUsuario = $oUsuario->T01_NumConexiones; //Guardo en la variable conexionesUsuario el total de conexiones realizadas del usuario logeado con exito
    
    $ultimaConexionUsuario = $_SESSION['fechaHoraUltimaConexionAnterior']; //Guardo en la variable ultimaConexionUsuario la fecha de la ultima conexion del usuario logeado con exito
    
}catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
    $errorExcepcion = $excepcion->getCode();//Obtengo el codigo del error y lo almaceno en la variable errorException
    $mensajeException = $excepcion->getMessage();//Obtengo el mensaje del error y lo almaceno en la variable mensajeException
    echo "<p style='color: red'>Codigo del error: </p>" . $errorExcepcion;//Muestro el codigo del error
    echo "<p style='color: red'>Mensaje del error: </p>" . $mensajeException;//Muestro el mensaje del error
}finally{
    unset($mydb);//Cierro la conexion
}
?>

<!DOCTYPE html>
<!--Aroa Granero Omañas 
Fecha Creacion: 30/11/2021
Fecha Modificacion: 09/12/2021 -->
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
<header>
            <h1>Programa</h1>
        </header>
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
            <input class="button" type="submit" value="EDITAR PERFIL" name="editar">
        </form>
        <footer class="piepagina">
                <a href="https://github.com/aroago/208DWESLoginLogoutTema5" target="_blank"><img src="../webroot/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a><a href="https://daw208.ieslossauces.es/">2021 Todos los derechos reservados AroaGO.</a> Fecha Modificación:09/12/2021</p> 
            </footer>
    </body>
</html>