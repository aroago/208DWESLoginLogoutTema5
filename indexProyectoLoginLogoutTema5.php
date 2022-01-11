<?php
/*
 * @author: Aroa Granero Omañas
 * @version: v1
 * Created on: 30/11/2021
 * Last modification: 30/11/2021
 */
//Comprobar si se ha pulsado el boton salir
if (isset($_REQUEST['salir'])) {
    header('Location: ../208DWESProyectoTema5/indexProyectoTema5.php');
    exit;
}
//Comprobar si se ha pulsado el boton iniciar sesion
if (isset($_REQUEST['iniciarSesion'])) {
    header('Location: ../208DWESLoginLogoutTema5/codigoPHP/login.php');
    exit;
}
if (!isset($_COOKIE['idioma'])) {
    setcookie("idioma", "esp", time() + 2000002); //Pongo el idioma en español y el tiempo de expiracion en +2000002
    header('Location: ../208DWESLoginLogoutTema5/indexProyectoLoginLogoutTema5.php');
    exit;
}
//
if (isset($_REQUEST['idiomaBotonSeleccionado'])) {
    setcookie("idioma", $_REQUEST['idiomaBotonSeleccionado'], time() + 2000002); //Ponemos que el idioma sea el seleccionado en el boton
}

require_once './config/configAPP.php'; //Incluyo el array de idiomas para la COOKIE
?>
<!DOCTYPE html>
<!--Aroa Granero Omañas 
Fecha Creacion: 30/11/2021
Fecha Modificacion: 11/1/2022 -->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="aroaGraneroOma�as">
        <meta name="application-name" content="Sitio web de DAW2">
        <meta name="description" content="Inicio de la pagina web">
        <meta name="keywords" content=" index" >
        <meta name="robots" content="index, follow" />
        <link href="./webroot/css/estilosEjer.css"  rel="stylesheet"  type="text/css" title="Default style">
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AroaGO</title>

    </head>
    <body>
        <header>
            <h1>AROA G.O TEMA 5 LogIn LogOut</h1>
            <?php echo $aIdioma[$_COOKIE['idioma']] ?>
        </header>
        <main>
            <form>
                <button type="submit" value="esp" name="idiomaBotonSeleccionado" ><img src="../208DWESLoginLogoutTema5/webroot/img/esp.png" class="esp" alt="imagenes"></button>
                <button type="submit" value="uk" name="idiomaBotonSeleccionado" ><img src="../208DWESLoginLogoutTema5/webroot/img/uk.png" class="uk" alt="imagenen"></button>
                <button type="submit" value="italia" name="idiomaBotonSeleccionado"><img src="../208DWESLoginLogoutTema5/webroot/img/italia.png" class="italia" alt="imagenes"></button>
                <button type="submit" value="tr" name="idiomaBotonSeleccionado" ><img src="../208DWESLoginLogoutTema5/webroot/img/tr.png" class="tr" alt="imagenen"></button>
            </form>
            <form >
                <input type="submit" value="Iniciar sesión" name="iniciarSesion" class="button"/>
                <?php
                if (empty($_REQUEST['idiomaBotonSeleccionado'])) {
                    echo '<h3 class="buttonidioma">Idioma seleccionado <img src="../208DWESLoginLogoutTema5/webroot/img/' . $_COOKIE['idioma'] . '.png"  alt="imagenes"></h3>';
                } else {
                    echo '<h3 class="buttonidioma">Idioma seleccionado <img src="../208DWESLoginLogoutTema5/webroot/img/' . $_REQUEST['idiomaBotonSeleccionado'] . '.png" alt="imagenes"></h3>';
                }
                ?>
                <input type="submit" value="SALIR" name="salir" class="button"/>
            </form>

        </main>
        <footer id="footerP">
            <footer class="piepagina">
                <a href="https://github.com/aroago/208DWESLoginLogoutTema5" target="_blank"><img src="./webroot/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a><a href="https://daw208.ieslossauces.es/">2021 Todos los derechos reservados AroaGO.</a> Fecha Modificación:09/12/2021</p> 
            </footer>
    </body>
</html>
