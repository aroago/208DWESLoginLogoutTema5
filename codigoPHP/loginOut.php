<?php
//Importamos la libreria de validacion
require_once '../core/libreriaValidacion.php';
//Fichero de configuración de la BBDD
require_once '../config/confDBPDO.php';

$entradaOK = true;

//Array para almacenar los errores del formulario
$aErrores = [
    'T01_CodUsuario' => null,
    'T01_Password' => null
];


//Si se ha pulsado enviar
if (isset($_POST['enviar'])) {
    //La posición del array de errores recibe el mensaje de error si hubiera
    $aErrores['T01_CodUsuario'] = validacionFormularios::comprobarAlfabetico($_POST['T01_CodUsuario'], 50, 1, 1);
    $aErrores['T01_Password'] = validacionFormularios::comprobarAlfaNumerico($_POST['T01_Password'], 20, 1, 1);
    //Recorre el array en busca de mensajes de error
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            //Cambia la condición de la variable
            $entradaOK = false;
        }
    }
} else {
    //Cambiamos el valor de la variable porque no se ha pulsado el botón
    $entradaOK = false;
}
if ($entradaOK) {
    try {
        // Datos de la conexión a la base de datos
        $mydb = new PDO(HOST, USER, PASSWORD); //Establecer una conexión con la base de datos 
        $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $codUsuario = $_POST['T01_CodUsuario'];
        $T01_Password = $_POST['T01_Password'];
        //Selecciona los datos del usuario que se loguea
        $consultaSQL = "SELECT * FROM T01_Usuario WHERE T01_CodUsuario = :codigo AND T01_Password = :passHash";
        $resultadoSQL = $mydb->prepare($consultaSQL);
        $resultadoSQL->bindValue(':codigo', $T01_CodUsuario);
        $resultadoSQL->bindValue(':passHash', hash('sha256', $T01_CodUsuario.$T01_Password));
        $resultadoSQL->execute();

        //Si el resultado del select devuelve algún valor es que el usuario introducido existe
        if ($resultadoSQL->rowCount() == 1) {
            $usuario = $resultadoSQL->fetchObject();
            session_start();
            $_SESSION['Usuario208DWESLoginLogoutTema5'] = $usuario->T01_CodUsuario;
            //Actualiza el número de conexiones sumándole 1
            $conexionesSQL = "UPDATE T01_Usuario SET T01_NumConexiones = T01_NumConexiones + 1 WHERE T01_CodUsuario = :codigo;";
            $actualizarConexionesSQL = $mydb->prepare($conexionesSQL);
            $actualizarConexionesSQL->bindParam(":codigo", $_SESSION['Usuario208DWESLoginLogoutTema5']);
            $actualizarConexionesSQL->execute();
            //Una vez ejecutadas las sentencias se redirige a programa.php
            header("Location: progrma.php");
        } else {
            //Si el resultado del select no devuelve ningún valor, el usuario no existe, se queda en el login
            header('Location: loginOut.php');
        }
        //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
    } catch (PDOException $mensajeError) {
        echo "<h3>Mensaje de ERROR</h3>";
        echo "Error: " . $mensajeError->getMessage() . "<br>";
        echo "Código de error: " . $mensajeError->getCode();
    } finally {
        unset($mydb);
    }
} else {
    ?>
    <!DOCTYPE html>
    <html>
        <body>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset>
                    <div class="obligatorio">
                        <strong>Nombre: </strong>
                        <input type="text" name="T01_CodUsuario" style="border: 1px solid black" 
                               value="<?php
                               if ($aErrores['T01_CodUsuario'] == NULL && isset($_POST['T01_CodUsuario'])) {
                                   echo $_POST['T01_CodUsuario'];
                               }
                               ?>">            
                    </div>
                    <br>
                    <div class="obligatorio">
                        <strong>Contraseña: </strong>
                        <input type="T01_Password" name="T01_Password" style="border: 1px solid black" 
                               value="<?php
                               if ($aErrores['T01_Password'] == NULL && isset($_POST['T01_Password'])) {
                                   echo $_POST['T01_Password'];
                               }
                               ?>">               
                    </div>
                    <br>
                    <div>                
                        <input type="submit" name="enviar" value="ENTRAR" >
                    </div>
                </fieldset>
            </form>
        <?php } ?>

    </body>
</html>
