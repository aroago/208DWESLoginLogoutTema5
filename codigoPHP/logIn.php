


<!DOCTYPE html>
<!--Aroa Granero Omañas 
Fecha Creacion: 25/11/2021
Fecha Modificacion: 25/11/2021 -->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="aroaGraneroOmañas">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="application-name" content="ejercicio01 Tema5">
        <meta name="description" content="logOut LogIn">
        <meta name="keywords" content=" index, ej01" >
        <meta name="robots" content="index, follow" />
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 01</title>
        <style>
            /* Add a black background color to the top navigation */
            .topnav {
                background-color: #333;
                overflow: hidden;
                margin-bottom: 30px;
            }

            /* Style the links inside the navigation bar */
            .topnav a {
                float: left;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 20px;
            }

            /* Change the color of links on hover */
            .topnav a:hover {
                background-color: rgb(77, 157, 182);
                color: black;
            }
            /* Contenedor del login */


            #login {

                background-color: #77B0C5;

                border-radius: 8px;

                box-shadow: 3px 3px 10px 0px rgba(50, 50, 50, 0.75);

                -moz-box-shadow: 3px 3px 10px 0px rgba(50, 50, 50, 0.75);

                -webkit-box-shadow: 3px 3px 10px 0px rgba(50, 50, 50, 0.75);

                margin-left: auto;

                margin-right: auto;

                margin-top: 10%;

                max-width: 20em;

                padding-bottom: 10px;

                padding-top: 10px;

            }


            /* Etiquetas del formulario */


            label {

                color: white;

                display: block;

                margin-bottom: 6px;

                margin-left: 1.2em;

            }


            /* Campos del formulario */


            input[type="text"],

            input[type="password"] {

                border: none;

                border-radius: 6px;

                display: block;

                font-size: 1em;

                height: 2em;

                text-align: center;

                width: 90%;

                margin-left: auto;

                margin-right: auto;

            }


            /* Botón */


            input[type="submit"] {

                background-color: #A3A0A2;

                border: none;

                border-radius: 6px;

                color: white;

                display: block;

                font-size: 1em;

                height: 3em;

                margin-left: auto;

                margin-right: auto;

                margin-top: -10px;

                text-align: center;

                width: 150px;

            }


            input[type="submit"]:hover {

                cursor: pointer;

                background-color: #A33D41;

                opacity: 0.8;

            }
        </style>
    </head>
    <body>
        <div class="topnav">
            <a href="../indexProyectoLoginLogoutTema5.php">&#8666;</a>
            <a href="https://github.com/aroago/208DWESProyectoTema5">GitHub</a>
            <a href="../../index.php">&#127968;</a>
        </div>
        <div id="login">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">

                <label>Usuario: </label>

                <input type="text" name="user"/><br>

                <label>Contraseña: </label>

                <input type="password" name="password"/><br><br>

                <input type="submit" value="Enviar"/>

            </form>

        </div>

    </body>
</html>

<?php
/*
 * @author: Aroa Granero Omañas
 * @version: v1
 * Created on: 25/11/2021
 * Last modification: 25/11/2021
 */
$user = $_GET['user'];

$password = $_GET['password'];


if (($user == "admin") AND ($password == "paso")) {

    echo "Bienvenido " . $user;
} Else {

    echo "¡Usuario o contraseña incorrectos!";

    echo '<a href="' . $_SERVER['HTTP_REFERER'] . '"><br>Volver</a>';
}
?>