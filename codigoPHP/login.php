<?php
/*
 * @author: Aroa Granero Omañas
 * @version: v1
 * Created on: 30/11/2021
 * Last modification: 09/12/2021
 */

if (isset($_REQUEST['registrate'])) { //Si se ha pulsado entro en registrarme
    header('Location: registro.php'); //Redireccion a registro mediante el header
    exit;
}
require_once '../config/configAPP.php'; //Incluyo el array de idiomas para la COOKIE
require_once '../core/libreriaValidacion.php'; //Incluyo la libreria de validacion
require_once '../config/configDBPDO.php'; //Incluyo las variables de la conexion

define("OBLIGATORIO", 1); //Variable obligatorio inicializada a 1
$entradaOK = true; //Variable de entrada correcta inicializada a true

$aErrores = [//Creo el array de errores y lo inicializo a null
    'CodUsuario' => null,
    'Password' => null
];

$aRespuestas = [//Creo el array de respuestas y lo incializo a null
    'CodUsuario' => null,
    'Password' => null
];

//Comprobar si se ha pulsado el boton entrar
if (isset($_REQUEST['entrar'])) { //Si le ha dado al boton de enviar valido los datos
    $aErrores['CodUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodUsuario'], 200, 1, OBLIGATORIO); //Compruebo si el nombre de usuario esta bien rellenado
    $aErrores['Password'] = validacionFormularios::validarPassword($_REQUEST['Password'], 8, 1, 1, OBLIGATORIO); //Compruebo si la password esta bien rellenada
    if ($aErrores['CodUsuario'] == null || $aErrores['Password'] == null) { //Compruebo que el codUsuario y la Password tienen el formato correcto si el array de errores tiene null
        try {
            $mydb = new PDO(HOST, USER, PASSWORD); //Hago la conexion con la base de datos
            $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION

            $consulta = "SELECT T01_NumConexiones, T01_FechaHoraUltimaConexion FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario AND T01_Password=:Password"; //Creo la consulta y le paso el usuario a la consulta
            $resultadoConsulta = $mydb->prepare($consulta); // Preparo la consulta antes de ejecutarla
            $aParametros1 = [
                ":CodUsuario" => $_REQUEST['CodUsuario'],
                ":Password" => hash("sha256", ($_REQUEST['CodUsuario'] . $_REQUEST['Password']))
            ];
            $resultadoConsulta->execute($aParametros1); //Ejecuto la consulta con el array de parametros
            $oUsuario = $resultadoConsulta->fetchObject(); //Obtengo un objeto con el usuario y su password

            if ($resultadoConsulta->rowCount() == 0) { //Si la consulta no tiene ningun registro es que no esta bien el usuario o la password
                $aErrores['Password'] = "Error en el login."; //Si no es correcto, almaceno el error en el array de errores
            }

            if (!$oUsuario) { //Si la consulta no devuelve ningun resultado, el usuario no existe o la password no coincide con el usuario introducido
                $entradaOK = false; //Le doy el valor false a la entrada
            }
        } catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
            $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
            $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException
            echo "<p style='color: red'>Codigo del error: </p>" . $errorExcepcion; //Muestro el codigo del error
            echo "<p style='color: red'>Mensaje del error: </p>" . $mensajeException; //Muestro el mensaje del error
        } finally {
            unset($mydb); //Cierro la conexion
        }
    }
    //Comprobar si algun campo del array de errores ha sido rellenado
    foreach ($aErrores as $campo => $error) {//recorro el array errores
        if ($error != null) {//Compruebo si hay algun error
            $_REQUEST[$campo] = ''; //Limpio el campo del formulario
            $entradaOK = false; //Le doy el valor false a entradaOK
        }
    }
} else { //Si el usuario no le ha dado al boton de entrar
    $entradaOK = false; //Le doy el valor false a entradaOK y se vuelve a mostrar el formulario
}

if ($entradaOK) { //Si la entrada es correcta
    try {
        $mydb = new PDO(HOST, USER, PASSWORD); //Hago la conexion con la base de datos
        $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION

        $numeroConexiones = $oUsuario->T01_NumConexiones; //Guardo el numero de conexiones que tiene la base de datos en una variable
        $ultimaConexion = $oUsuario->T01_FechaHoraUltimaConexion; //Guardo la fechahora de la ultima conexion que tiene la base de datos en una variable

        $consultaUpdate = "UPDATE T01_Usuario SET T01_NumConexiones=:NumConexiones, T01_FechaHoraUltimaConexion=:FechaHoraUltimaConexion WHERE T01_CodUsuario=:CodUsuario"; //Consulta para actualizar el total de conexiones y la fechahora de la ultima conexion
        $resultadoConsultaUpdate = $mydb->prepare($consultaUpdate); // Preparo la consulta antes de ejecutarla

        $aParametros2 = [//Array de parametros para el update
            ":NumConexiones" => ($numeroConexiones + 1), //Le sumo al total de conexiones una mas para contar la actual
            ":FechaHoraUltimaConexion" => time(), //Asigno hora local actual con una marca temporal usando time()
            ":CodUsuario" => $_REQUEST['CodUsuario'] //El usuario pasado en el formulario
        ];
        $resultadoConsultaUpdate->execute($aParametros2); //Ejecuto la consulta con el array de parametros

        session_start(); //Creo una nueva sesion o recupero una existente
        $_SESSION['usuarioDAW208AppLoginLogout'] = $_REQUEST['CodUsuario']; //Almaceno el usuario en $_SESSION
        $_SESSION['fechaHoraUltimaConexionAnterior'] = $ultimaConexion; //Almaceno la ultima conexion en $_SESSION

        header('Location: programa.php'); //Mando al usuario a la pagina programa.php
        exit;
    } catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
        $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
        $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException
        echo "<p style='color: red'>Codigo del error: </p>" . $errorExcepcion; //Muestro el codigo del error
        echo "<p style='color: red'>Mensaje del error: </p>" . $mensajeException; //Muestro el mensaje del error
    } finally {
        unset($mydb); //Cierro la conexion
    }
} else {
   
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="../webroot/css/estilosEjer.css"  rel="stylesheet"  type="text/css" title="Default style">
            <title>logIn</title>  
        </head>
        <body>
            <div id="container">
                <h1>Log In LoginLogout</h1>
                <span class="close-btn">
                    <a href="../indexProyectoLoginLogoutTema5.php"> <img src="https://cdn4.iconfinder.com/data/icons/miu/22/circle_close_delete_-128.png"></a>
                </span>

                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="Post">
                    <input type="text" name="CodUsuario" id="username"  placeholder="username">
                    <input type="password" name="Password" id="password" placeholder="password">
                    <input type="submit" name="entrar" class="btnlogin" value="ENTRAR">
                    <h2>¿ERES NUEVO?</h2>
                    <input type="submit" class="btnlogin" type="submit" value="Registrate" name="registrate">
                </form>
                <?php
            }
            ?>
        </div>

        <footer class="piepagina">
                <a href="https://github.com/aroago/208DWESLoginLogoutTema5" target="_blank"><img src="../webroot/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a><a href="https://daw208.ieslossauces.es/">2021 Todos los derechos reservados AroaGO.</a> Fecha Modificación:09/12/2021</p> 
            </footer>

    </body>
</html>