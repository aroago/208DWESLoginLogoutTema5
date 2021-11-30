<?php
/*
 * @author: Aroa Granero Omañas
 * @version: v1
 * Created on: 30/11/2021
 * Last modification: 30/11/2021
 */
/* Iniciamos la session para alamacenar el codigo de usuario */
session_start();

//Importamos la libreria de validacion
require_once '../core/libreriaValidacion.php';
//Fichero de configuración de la BBDD
require_once '../config/confDBPDO.php';
$aFormulario = [
    'usuario' => '',
    'password' => ''
];

/**
 * Si se ha enviado el formulario, valida la entrada.
 */
if (isset($_REQUEST['btnlogin'])) {
    // Manejador de errores. 
    $bEntradaOK = true;

    

    /** comprueba que el usuario y la contraseña existan y sean correctos en la base de datos.
     */
    if ($bEntradaOK) {
        /* Recogida de información */
        $aFormulario['usuario'] = $_REQUEST['usuario'];
        $aFormulario['password'] = $_REQUEST['password'];

        try {
            /* Establecemos la connection con pdo en global */
            $miDB = new PDO(HOST, USER, PASSWORD);

            /* configurar las excepcion */
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               // Query de selección.
            $sSelect = "SELECT T01_Password FROM T01_Usuario WHERE T01_CodUsuario='{$aFormulario['usuario']}'";

            // Preparación y ejecución de la consulta.
            $oResultadoSelect = $oDB->prepare($sSelect);
            $oResultadoSelect->execute();

            $oResultado = $oResultadoSelect->fetchObject();
        } catch (PDOException $exception) {
            /*
             * Mostrado del código de error y su mensaje.
             */
            echo '<div>Se han encontrado errores:</div><ul>';
            echo '<li>' . $exception->getCode() . ' : ' . $exception->getMessage() . '</li>';
            echo '</ul>';
        } finally {
            unset($oDB);
        }

        if (!$oResultado || $oResultado->T01_Password != hash('sha256', ($aFormulario['usuario'] . $aFormulario['password']))) {
            $bEntradaOK = false;
        }
    }
}
/*
 * Si el formulario no ha sido enviado, pone el manejador de errores
 * a false para poder mostrar el formulario.
 */
else {
    $bEntradaOK = false;
}


if ($bEntradaOK) {
    // Variable de sesión para el usuario.
    $_SESSION['usuarioDAW208AppLoginLogoff'] = $aFormulario['usuario'];
    
    // Añadido al registro de conexiones y última hora de conexión.
    try {
        // Conexión con la base de datos.
        $oDB = new PDO(HOST, USER, PASSWORD);
        $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fecha-hora actual.
        $oDateTime = new DateTime();

        // Query de actualización.
        $sUpdate = <<<QUERY
                    UPDATE T01_Usuario SET T01_NumConexiones=T01_NumConexiones+1,
                    T01_FechaHoraUltimaConexion = '{$oDateTime->format("y-m-d h:i:s")}'
                    WHERE T01_CodUsuario='{$aFormulario['usuario']}'
            QUERY;

        // Preparación y ejecución de la actualización.
        $oResultadoUpdate = $oDB->prepare($sUpdate);
        $oResultadoUpdate->execute();
    } catch (PDOException $exception) {
        /*
         * Mostrado del código de error y su mensaje.
         */
        echo '<div>Se han encontrado errores:</div><ul>';
        echo '<li>' . $exception->getCode() . ' : ' . $exception->getMessage() . '</li>';
        echo '</ul>';
    } finally {
        unset($oDB);
    }

    // Reenvío al usuario a la página de programa.
    header('Location: programa.php');
    exit;
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../webroot/css/estilosEjer.css"  rel="stylesheet"  type="text/css" title="Default style">
        <title>logIn</title>  
        
    </head>
    <body>
        <div id="container">
            <h1>Log In</h1>
            <span class="close-btn">
                <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png"></img>
            </span>

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="Post">
                <input type="text" name="usuario" id="username"  placeholder="username">
                <input type="password" name="password" id="password" placeholder="password">
                <input type="submit" name="btnlogin" id="btnlogin" value="Entrar">
               
            </form>
        </div>
        
    </body>
</html>
