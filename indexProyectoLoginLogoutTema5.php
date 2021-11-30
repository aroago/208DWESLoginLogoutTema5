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
    header('Location: ../208DWESLoginLogoutTema5/codigoPHP/loginOut.php');
    exit;
}
?>
<!DOCTYPE html>
<!--Aroa Granero Omañas 
Fecha Creacion: 30/11/2021
Fecha Modificacion: 30/11/2021 -->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="aroaGraneroOma�as">
        <meta name="application-name" content="Sitio web de DAW2">
        <meta name="description" content="Inicio de la pagina web">
        <meta name="keywords" content=" index" >
        <meta name="robots" content="index, follow" />
        <link href="./webroot/css/estilos.css"  rel="stylesheet"  type="text/css" title="Default style">
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AroaGO</title>
        <style>
            .button{
                height: 57px;
                width: 30%;
                margin-top: 20%;
                border-radius: 20px;
                background: -webkit-linear-gradient(#FF5252, #FF4081); /* For Safari 5.1 to 6.0*/
                background: -o-linear-gradient(#FF5252, #FF4081); /* For Opera 11.1 to 12.0*/    
                background: -moz-linear-gradient(#FF5252, #FF4081); /* For Firefox 3.6 to 15*/
                background: linear-gradient(#FF5252, #FF4081); /*Standard syntax*/             
                border:none;
            }
            .button:hover{
                background: -webkit-linear-gradient(#3794a0, #29a85e); /* For Safari 5.1 to 6.0*/
                background: -o-linear-gradient(#3794a0, #29a85e); /* For Opera 11.1 to 12.0*/    
                background: -moz-linear-gradient(#3794a0, #29a85e); /* For Firefox 3.6 to 15*/
                background: linear-gradient(#3794a0, #29a85e); /*Standard syntax*/  
            }
            form{
                text-align: center;
                display: block;

            }
        </style>
    </head>
    <body>
        <header>
            <h1>AROA G.O TEMA 5 LogIn LogOut</h1>
        </header>
        <main>
            <form >
                <input type="submit" value="Iniciar sesión" name="iniciarSesion" class="button"/>
                <input type="submit" value="SALIR" name="salir" class="button"/>
            </form>
        </main>
        <footer id="footerP">
            <p>&copy;2021 Todos los derechos reservados AroaGO</p>
            <div id="iconos">
                <a type="application/github" href="https://github.com/aroago/208DWESProyectoTema5" target="_blank">
                    <img class="iconoIMG" alt="gitHub" src="./webroot/img/github.png" />
                </a>
            </div>
        </footer>
    </body>
</html>
