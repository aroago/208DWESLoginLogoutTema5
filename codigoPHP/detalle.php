  



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
            table{
                margin-left: auto;
                margin-right: auto;
            }
            td,tr{
                border: solid 3px cadetblue;
            }
        </style>
    </head>
    <body>
        <div class="topnav">
            <a href="../codigoPHP/loginOut.php">&#8666;</a>
            <a href="https://github.com/aroago/208DWESProyectoTema5">GitHub</a>
           
            <a href="../../index.php">&#127968;</a>
        </div>

        <h1>Mostrar el contenido de las variables superglobales</h1>
        <!–– Muestra del contenido de la variable $_SERVER con foreach()––>

        <?php
        /*
         * @author: Aroa Granero Omañas
         * @version: v1
         * Created on: 30/11/2021
         * Last modification: 30/11/2021
         */
        if (!empty($_SERVER)) {
            ?>
            <h2>Mostrar $_SERVER con foreach()</h2>
            <table><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_SERVER as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>

        <!–– Muestra del contenido de la variable $_REQUEST con foreach()––>
        <?php if (!empty($_REQUEST)) { ?>
            <h2>Mostrar $_REQUEST con foreach()</h2>
            <table><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_REQUEST as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>

        <!–– Muestra del contenido de la variable $_GET con foreach()––>
        <?php if (!empty($_GET)) { ?>
            <h2>Mostrar $_GET con foreach()</h2>
            <table><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_GET as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>

        <!–– Muestra del contenido de la variable $_FILES con foreach()––>
        <?php if (!empty($_FILES)) { ?>
            <h2>Mostrar $_FILES con foreach()</h2>
            <table><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_FILES as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>

        <!–– Muestra del contenido de la variable $_ENV con foreach()––>
        <?php if (!empty($_ENV)) { ?>
            <h2>Mostrar $_ENV con foreach()</h2>
            <table><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_ENV as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>

        <!–– Muestra del contenido de la variable $_POST con foreach()––>
        <?php if (!empty($_POST)) { ?>
            <h2>Mostrar $_POST con foreach()</h2>
            <table><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_POST as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>

        <!–– Muestra del contenido de la variable $_COOKIE con foreach()––>
        <?php if (!empty($_COOKIE)) { ?>
            <h2>Mostrar $_COOKIE con foreach()</h2>
            <table ><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_COOKIE as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>

        <!–– Muestra del contenido de la variable $_SESSION con foreach()––>
        <?php if (!empty($_SESSION)) { ?>
            <h2>Mostrar $_SESSION con foreach()</h2>
            <table><tr><th>Clave</th><th>Valor</th></tr>
                <?php foreach ($_SESSION as $clave => $valor) { ?>
                    <tr>
                        <td><strong><?php echo $clave ?></strong></td>
                        <td><?php echo $valor ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br>
            <?php
        }
        ?>
        //mostrar phpInfo
        <h1>Mostrar PHPINFO()</h1>
        <?php
        //phpinfo() utilizada para saber todala informacion y todo lo que contiene mi php.
        phpinfo();
        ?>
    </body>
</html>