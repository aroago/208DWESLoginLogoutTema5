  
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
     header('Location: ../codigoPHP/programa.php');
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
            
           .button{
     width: 20%;
     background: rgba(6, 187, 211, 0.3);
}
        </style>
    </head>
    <body>
        <header>
            <h1>Detalle</h1>
        </header>
        <form>
            <input type="submit" value="volver" name="volver" class="button"/>
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