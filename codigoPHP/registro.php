<?php
if (isset($_REQUEST['cancelar'])) { //Si el usuario le da al botón de cancelar.
    header('Location: login.php'); //Le redirijo al login.
}

require_once '../core/libreriaValidacion.php'; //Incluyo la libreria de validacion
require_once '../config/confDBPDO.php'; //Incluyo las variables de la conexion

define('OBLIGATORIO', 1); //Creo una constante $OBLIGATORIO y le asigno un 1.

$entradaOk = true;
$aErrores = ['CodUsuario' => null, //Creo un array de errores y lo inicializo a null con los campos correspondientes.
    'DescUsuario' => null,
    'Password' => null,
    'ConfirmarPassword' => null];

if (isset($_REQUEST['aceptar'])) { //Si el usuario le da al botón de aceptar.
    //Compruebo que los campos que ha rellenado en el formulario son correctos mediente la librería de validación.
    $aErrores['CodUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodUsuario'], 10, 3, OBLIGATORIO);
    $aErrores['DescUsuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['DescUsuario'], 50, 3, OBLIGATORIO);
    $aErrores['Password'] = validacionFormularios::validarPassword($_REQUEST['Password'], 8, 4, 2, OBLIGATORIO);
    $aErrores['ConfirmarPassword'] = validacionFormularios::validarPassword($_REQUEST['ConfirmarPassword'], 8, 4, 2, OBLIGATORIO);

    try {
        $miDB = new PDO(HOST, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.

        $sqlUsuario = "SELECT * FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario"; //Hago una consulta SQL.
        $consulta = $miDB->prepare($sqlUsuario); //Preparo la consulta.
        $consulta->bindParam(":CodUsuario", $_REQUEST["CodUsuario"]); //Blideo el código del usuario.
        $consulta->execute(); //Ejecuto la consulta.

        $oRegistro = $consulta->fetchObject(); //Almaceno los objetos que voy a recorres con fetchObject() en una variable que se llama $oRegistro.

        if ($consulta->rowCount() > 0) { //Si hay alguna coincidencia en la base de datos.
            $aErrores['CodUsuario'] = "Ese usuario ya existe, prueba con otro"; //Almaceno en el array de errores un mensaje diciendo que el código del usuario ya existe.
        }
        if ($_REQUEST['Password'] != $_REQUEST['ConfirmarPassword']) { //Si la contraseña que introduce el usuario no coincide con la confirmación de la misma.
            $aErrores['ConfirmarPassword'] = "Las contraseñas no coinciden"; //Almaceno en el array de errores un mensaje diciendo que las contraseñas no coinciden.
        }
    } catch (PDOException $miExcepcionPDO) {
        echo "<p style='color:red;'>Error " . $miExcepcionPDO->getMessage() . "</p>"; //Muestro el mensaje de la excepción de errores.
        echo "<p style='color:red;'>Código de error " . $miExcepcionPDO->getCode() . "</p>"; //Muestro el código del error.
    } finally {
        unset($miDB); //Ciero la conexión a la base de datos.
    }

    foreach ($aErrores as $campo => $error) { //Recorro cada campo del array de errores.
        if ($error != null) { //Si hay algún error.
            $entradaOk = false;
            $_REQUEST[$campo] = ""; //Le muestro al usuario el campo vacío.
        }
    }
} else {
    $entradaOk = false;
}
if ($entradaOk) {
    try {
        $miDB = new PDO(HOST, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.

        $insertarUsuario = "INSERT INTO T01_Usuario (T01_CodUsuario, T01_DescUsuario, T01_Password) values (:CodUsuario, :DescUsuario, :Password)";
        $consulta = $miDB->prepare($insertarUsuario); //Preparo la consulta.
        //Blideo los parámetros.
        $consulta->bindParam(':CodUsuario', $_REQUEST['CodUsuario']);
        $consulta->bindParam(':DescUsuario', $_REQUEST['DescUsuario']);
        $consulta->bindParam(':Password', hash("sha256", ($_REQUEST['CodUsuario'] . $_REQUEST['Password'])));
        $consulta->execute(); //Ejecuto la consulta.

        $nConexiones = 1;
        $actualizarUsuario = "UPDATE T01_Usuario SET T01_NumConexiones = :NumConexiones, T01_FechaHoraUltimaConexion=:FechaHoraUltimaConexion where T01_CodUsuario=:CodUsuario";
        $consulta2 = $miDB->prepare($actualizarUsuario); //Preparo la segunda consulta.
        //Blindeo los parámetros.
        $consulta2->bindParam(':NumConexiones', ($nConexiones));
        $consulta2->bindParam(':FechaHoraUltimaConexion', time());
        $consulta2->bindParam(':CodUsuario', $_REQUEST['CodUsuario']);
        $consulta2->execute(); //Ejecuto la segunda consulta.

        session_start(); //Inicializo la sesión existente.

        $_SESSION["usuarioDAW208AppLoginLogout"] = $_REQUEST['CodUsuario']; //Almaceno en la variable $_session el código del usuario.
        $_SESSION["FechaHoraUltimaConexionAnterior"] = null; //Almaceno en la variable $_session la fecha de la última conexión.

        header("Location: programa.php"); //Redirijo al usuario al programa.
        exit;
    } catch (PDOException $miExcepcionPDO) {
        echo "<p style='color:red;'>Error " . $miExcepcionPDO->getMessage() . "</p>"; //Muestro el mensaje de la excepción de errores.
        echo "<p style='color:red;'>Código de error " . $miExcepcionPDO->getCode() . "</p>"; //Muestro el código del error.
    } finally {
        unset($miDB); //Cierro la conexión de la base de datos.
    }
} else {
    ?>
    <!DOCTYPE html>
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
            <title>Registro</title>  
        </head>
        <body>
            <div id="containerRegistro">
                <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                    <h3>Usuario: </h3>
                    <input  type="text" name="CodUsuario" value="<?php
                    if ($aErrores["CodUsuario"] == null && isset($_REQUEST["CodUsuario"])) { //Compruebo  que los campos del array de errores están vacíos y el usuario le ha dado al botón de enviar.
                        echo $_REQUEST["CodUsuario"]; //Devuelve el campo que ha escrito previamente el usuario.
                    }
                    ?>">
                    <span style="color:red">
                        <?php
                        if ($aErrores["CodUsuario"] != null) { //Compruebo que el array de errores no está vacío.
                            echo $aErrores["CodUsuario"]; //Si hay errores, devuelve el campo vacío y muestra una advertencia de los errores y como tiene que estar escrito ese campo.
                        }
                        ?>
                    </span>

                    <br>

                    <h3>Descripción de usuario: </h3>
                    <input  type="text" name="DescUsuario" value="<?php
                    if ($aErrores["DescUsuario"] == null && isset($_REQUEST["DescUsuario"])) { //Compruebo  que los campos del array de errores están vacíos y el usuario le ha dado al botón de enviar.
                        echo $_REQUEST["DescUsuario"]; //Devuelve el campo que ha escrito previamente el usuario.
                    }
                    ?>">
                    <span style="color:red">
                        <?php
                        if ($aErrores["DescUsuario"] != null) { //Compruebo que el array de errores no está vacío.
                            echo $aErrores["DescUsuario"]; //Si hay errores, devuelve el campo vacío y muestra una advertencia de los errores y como tiene que estar escrito ese campo.
                        }
                        ?>
                    </span>

                    <br>

                    <h3>Contraseña: </h3>
                    <input  type="password" name="Password" value="<?php
                    if ($aErrores["Password"] == null && isset($_REQUEST["Password"])) { //Compruebo  que los campos del array de errores están vacíos y el usuario le ha dado al botón de enviar.
                        echo $_REQUEST["Password"]; //Devuelve el campo que ha escrito previamente el usuario.
                    }
                    ?>">
                    <span style="color:red">
                        <?php
                        if ($aErrores["Password"] != null) { //Compruebo que el array de errores no está vacío.
                            echo $aErrores["Password"]; //Si hay errores, devuelve el campo vacío y muestra una advertencia de los errores y como tiene que estar escrito ese campo.
                        }
                        ?>
                    </span>

                    <br>

                    <h3>Confirmar contraseña: </h3>
                    <input  type="password" name="ConfirmarPassword" value="<?php
                    if ($aErrores["ConfirmarPassword"] == null && isset($_REQUEST["ConfirmarPassword"])) { //Compruebo  que los campos del array de errores están vacíos y el usuario le ha dado al botón de enviar.
                        echo $_REQUEST["ConfirmarPassword"]; //Devuelve el campo que ha escrito previamente el usuario.
                    }
                    ?>">
                    <span style="color:red">
                        <?php
                        if ($aErrores["ConfirmarPassword"] != null) { //Compruebo que el array de errores no está vacío.
                            echo $aErrores["ConfirmarPassword"]; //Si hay errores, devuelve el campo vacío y muestra una advertencia de los errores y como tiene que estar escrito ese campo.
                        }
                        ?>
                    </span>

                    <br>
                    <input type="submit" name="aceptar" class="btnlogin" value="ACEPTAR">
                    <input style="background: rgba(255, 3, 3, 0.3);" type="submit" name="cancelar" class="btnlogin" value="CANCELAR">
                </form>
            </div>
             <footer class="piepagina">
                <a href="https://github.com/aroago/208DWESLoginLogoutTema5" target="_blank"><img src="../webroot/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a>2021 Todos los derechos reservados AroaGO<p>
                    <p>Fecha Modificación:09/12/2021<p>
            </footer>
        </body>
    </html>
    <?php
}
?>
