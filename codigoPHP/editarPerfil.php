<?php
session_start(); //Inicializo la sesión existente.

if(!isset($_SESSION["usuarioDAW208AppLoginLogout"])){ //Compruebo que el usuario ha pasado por el login.
    header("Location: login.php"); //Si no se ha autenticado lo redirijo al login.
}
if(isset ($_REQUEST["cancelar"])){ //Si el usuario le da al botón de cancelar.
    header('Location: programa.php'); //Lo redirijo al programa.
}
if (isset($_REQUEST["cambiar"])) { //Si el usuario pulsa el boton cambiar Contrasenya
    header("Location: CambiarPassword.php"); //Se redirige a cambiar la contrasenya
    die();
}
    require_once '../core/libreriaValidacion.php'; //Incluyo el archivo de la librería de validación para hacer comprobaciones posteriormente.
    require_once '../config/configDBPDO.php'; //Incluyo el archivo de configuración a la base de datos PDO.
    
    try{
        $miDB = new PDO(HOST, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
        $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.
        
        $campos = "SELECT T01_DescUsuario, T01_NumConexiones, T01_FechaHoraUltimaConexion FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario"; //Hago una consulta SQL para sacar datos de la base de datos. 
        
        $consulta=$miDB->prepare($campos); //Preparo la consulta.
        $consulta -> bindParam(":CodUsuario",$_SESSION["usuarioDAW208AppLoginLogout"]); //Blindeo el codigo del usuario, que en este caso es el nombre de usuario.
        $consulta ->execute(); //Ejecuto la consulta.
            $oRegistro = $consulta->fetchObject(); //Almaceno los objetos que voy a recorres con fetchObject() en una variable que se llama $oRegistro.
            //Los datos que recorro los almaceno en variables para utilizarlos después.
            $descUsuario = $oRegistro->T01_DescUsuario;
            $nConexiones = $oRegistro->T01_NumConexiones;
            $fechaHora = $oRegistro->T01_FechaHoraUltimaConexion;
                     
    }catch(PDOException $miExcepcionPDO){
        echo "<p style='color:red;'>Error ".$miExcepcionPDO->getMessage()."</p>"; //Muestro el mensaje de la excepción de errores.
        echo "<p style='color:red;'>Código de error ".$miExcepcionPDO->getCode()."</p>"; //Muestro el código del error.
    }finally{
        unset($miDB); //Cierro la conexión a la base de datos.
    }
    if(isset($_REQUEST['eliminar'])){
        try{
        $miDB=new PDO(HOST, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
        $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.
        
        $eliminarUsuario="DELETE FROM T01_Usuario where T01_CodUsuario=:CodUsuario"; //Hago una sentencia SQL para cargarme el usuario.
        
        $consulta=$miDB->prepare($eliminarUsuario); //Preparo la consulta.
        $consulta->bindParam(":CodUsuario",$_SESSION["usuarioDAW208AppLoginLogout"]); //Blindeo el código del usuario que es el nombre de usuario de la cuenta.
        $consulta->execute(); //Ejecuto la consulta.
        
        session_destroy(); //Destruyo la sesión.
        header('Location: login.php'); //Redirijo al usuario al login.
        exit();
        
        }catch(PDOException $miExcepcionPDO){
            echo "<p style='color:red;'>Error ".$miExcepcionPDO->getMessage()."</p>"; //Muestro el mensaje de la excepción de errores.
            echo "<p style='color:red;'>Código de error ".$miExcepcionPDO->getCode()."</p>"; //Muestro el código del error.
        } finally {
            unset($miDB); //Cierro la conexión a la base de datos.
        }
    }
    
    define ('OBLIGATORIO',1); //Creo una constante $OBLIGATORIO y le asigno un 1.
    define ('MAX_FLOAT', 3.402823466E+38); //Creo una constante del máximo permitido en un campo float.
    define ('MIN_FLOAT', -3.402823466E+38); //Creo una constante del mínimo permitido en un campo float.
    
    $error = null;
    $entradaOk=true;
    
    if(isset($_REQUEST["aceptar"])){ //Si el usuario le da al botón de aceptar.
        $error= validacionFormularios::comprobarAlfabetico($_REQUEST["DescUsuario"], 50, 4, OBLIGATORIO); //Compruebo que el campo DescUsuario lo ha introducido correctamente.
        
        if($error!=null){
            $entradaOk=false;
        }
    }else{
        $entradaOk=false;
    }
    if($entradaOk){ //Si todo está correcto.
        try{
            $miDB = new PDO(HOST, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
            $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.
            
            $actualizacion="UPDATE T01_Usuario SET T01_DescUsuario = :DescUsuario WHERE T01_CodUsuario = :CodUsuario"; //Hago un update en la base de datos para cambiar el campo de la descripción del usuario.
            
            $consulta=$miDB->prepare($actualizacion); //Preparo la consulta.
            $parametros =[":DescUsuario" => $_REQUEST["DescUsuario"], //Almaceno en una variable los parámetros que le voy a pasar a la consulta previamente preparada.
                          ":CodUsuario" => $_SESSION["usuarioDAW208AppLoginLogout"]];
            $consulta->execute($parametros); //Ejecuto la consulta pasándole los parámetros.
            
            header('Location: programa.php'); //Redirijo al usuario al programa.
            
        }catch(PDOException $miExcepcionPDO){
            echo "<p style='color:red;'>Error ".$miExcepcionPDO->getMessage()."</p>"; //Muestro el mensaje de la excepción de errores.
            echo "<p style='color:red;'>Código de error ".$miExcepcionPDO->getCode()."</p>"; //Muestro el código del error.
        }finally{
            unset($miDB); //Cierro la conexión a la base de datos.
        }
    }else{
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
            <title>Eitar Perfil</title>  
    </head>
    <body>
        <header>
            <h1>Editar Prefil LoginLogout</h1>
        </header>
        <div id="containerRegistro">
            <form name="formulario" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <div>
                        <h3>Código usuario: </h3>
                        <input  type="text" name="CodUsuario" value="<?php echo $_SESSION["usuarioDAW208AppLoginLogout"]; ?>" readonly>
                        <h3>Descripción del usuario: </h3>
                        <input  style="background: rgba(55, 236, 236, 0.51)" type="text" name="DescUsuario" value="<?php 
                                if(isset($_REQUEST["DescUsuario"]) && $error == null){
                                    echo $_REQUEST["DescUsuario"];
                                }else{
                                   echo $descUsuario;
                                }
                                ?>">
                        <span style="color:red">
                            <?php
                                if ($error != null){
                                    echo $error;
                                }
                            ?>
                        </span>
                        <h3>Número de conexiones: </h3>
                        <input  type="text" name="NumConexiones" value="<?php echo $nConexiones?>" readonly>
                          <?php
                            if($nConexiones>1){
                        ?>
                            <h3>Última conexión: </h3>
                            <input type="text" name="FechaHoraUltimaConexion" value="<?php echo date("d-m-Y H:i:s",$_SESSION["fechaHoraUltimaConexionAnterior"])?>" readonly>
                         <?php
                            }
                        ?>
                    </div>
               
                  
                <br>
                <input type="submit" name="cambiar" class="btnlogin" value="Cambiar la contraseña">
                <input type="submit" name="aceptar" class="btnlogin" value="ACEPTAR">
                <input style="background: rgba(255, 3, 3, 0.3);" type="submit" name="cancelar" class="btnlogin" value="CANCELAR">
                 <input style="background: rgba(255, 3, 3, 0.3);" type="submit" name="eliminar" class="btnlogin" value="ELIMINAR USUARIO">
        </form>
            </div>
         <footer class="piepagina">
                <a href="https://github.com/aroago/208DWESLoginLogoutTema5" target="_blank"><img src="../webroot/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a><a href="https://daw208.ieslossauces.es/">2021 Todos los derechos reservados AroaGO.</a> Fecha Modificación:09/12/2021</p> 
            </footer>
    </body>
</html>
<?php
    }
?>
