  
<?php
/*
 * @author: Aroa Granero Omañas
 * @version: v1
 * Created on: 1/12/2021
 * Last modification: 1/12/2021
 */
//Recupera la sesión del Login
session_start();
//Si no hay una sesión iniciada te manda al Login
if (!isset($_SESSION['usuarioDAW208AppLoginLogout'])) {
    header('Location: login.php');
}
if (isset($_REQUEST['volver'])) {
    header("Location:programa.php");
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
        <title>Detalle</title>
        <style>
            html { 
                background: url(https://cdn.magdeleine.co/wp-content/uploads/2015/08/SW_Blake-Bronstad.jpg) no-repeat center center fixed; 
                
            }
            table{
                margin-left: auto;
                margin-right: auto;
                background: white;
            }
            td,tr{
                border: solid 3px cadetblue;
            }
            input{
                font-family: 'Open Sans Condensed', sans-serif;
                text-decoration: none;
                position: relative;
                width: 80%;
                display: block;
                margin: 9px auto;
                font-size: 17px;
                color: #fff;
                padding: 8px;
                border-radius: 6px;
                border: none;
                background: rgba(3,3,3,.1);
                -webkit-transition: all 2s ease-in-out;
                -moz-transition: all 2s ease-in-out;
                -o-transition: all 2s ease-in-out;
                transition: all 0.2s ease-in-out;
            }

            input:focus{
                outline: none;
                box-shadow: 3px 3px 10px #333;
                background: rgba(3,3,3,.5);
            }

            /* Placeholders */
            ::-webkit-input-placeholder {
                color: #ddd;  }
            :-moz-placeholder { /* Firefox 18- */
                color: red;  }
            ::-moz-placeholder {  /* Firefox 19+ */
                color: red;  }
            :-ms-input-placeholder {  
                color: #333;  }
            body{
              background-color: rgba(3,3,3,.1);
            }
           
        </style>
    </head>
    <body>
        <form>
            <input type="submit" value="Volver" name="volver" class="volver"/>
        </form>
        <h1>Mostrar el contenido de las variables superglobales</h1>
        <!–– Muestra del contenido de la variable $_SERVER con foreach()––>
        <?php
        echo '<h3>Mostrar el contenido de las variables superglobales:</h3>  ';
        // El contenido de $_SESSION
        echo '<h3>Mostrar el contenido de $_SESSION :</h3>  ';
        echo '<table><tr><th>Clave</th><th>Valor</th></th>';
        foreach ($_SESSION as $Clave => $Valor) {
            echo '<tr>';
            echo "<td>$Clave</td>";
            echo "<td>$Valor</td>";
            echo '</tr>';
        }
        echo '</table>';

        // El contenido de $_COOKIE
        echo '<h3>Mostrar el contenido de $_COOKIE :</h3>  ';
        echo '<table><tr><th>Clave</th><th>Valor</th></th>';
        foreach ($_COOKIE as $Clave => $Valor) {
            echo '<tr>';
            echo "<td>$Clave</td>";
            echo "<td>$Valor</td>";
            echo '</tr>';
        }
        echo '</table>';




        echo '<h3>Mostrar el contenido de $_SERVER :</h3>  ';
        echo '<table><tr><th>Clave</th><th>Valor</th></th>';
        /* usando foreach() */
        foreach ($_SERVER as $Clave => $Valor) {
            echo '<tr>';
            echo "<td>$Clave</td>";
            echo "<td>$Valor</td>";
            echo '</tr>';
        }
        echo '</table>';

        phpinfo();
        ?>
    </body>
</html>