<?php
session_start(); //Inicializo la sesión existente.

if(!isset($_SESSION["usuarioDAW208AppLoginLogout"])){ //Compruebo que el usuario ha pasado por el login.
    header("Location: login.php"); //Si no se ha autenticado lo redirijo al login.
}
if(isset ($_REQUEST["cancelar"])){ //Si el usuario le da al botón de cancelar.
    header('Location: programa.php'); //Lo redirijo al programa.
}

    require_once '../core/libreriaValidacion.php'; //Incluyo el archivo de la librería de validación para hacer comprobaciones posteriormente.
    require_once '../config/configDBPDO.php'; //Incluyo el archivo de configuración a la base de datos PDO.
    
    define ('OBLIGATORIO',1); //Creo una constante $OBLIGATORIO y le asigno un 1.
    
    $entradaOk=true; //Declaro e inicializo una variable booleana a true.
    
    $aErrores = ["PasswdActual" => null, //Creo un array de errores y los inicializo a null.
                 "PasswdNueva" => null,
                 "PasswdConfirmar" => null];
    
    if(isset($_REQUEST['aceptar'])){ //Si el usuario le da al botón de aceptar.
        //Compruebo que los campos que ha rellenado en el formulario son correctos.
        $aErrores['PasswdActual']= validacionFormularios::validarPassword($_REQUEST["PasswdActual"], 8, 4, 2, OBLIGATORIO); 
        $aErrores['PasswdNueva']= validacionFormularios::validarPassword($_REQUEST["PasswdNueva"], 8, 4, 2, OBLIGATORIO);
        $aErrores['PasswdConfirmar']= validacionFormularios::validarPassword($_REQUEST["PasswdConfirmar"], 8, 4, 2, OBLIGATORIO);
    
        try{
        $miDB = new PDO(HOST, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
        $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.
        
        $campos = "SELECT T01_Password FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario"; //Hago una consulta SQL para sacar la password y el usuario de la base de datos.
        
        $consulta=$miDB->prepare($campos); //Preparo la consulta.
        $consulta -> bindParam(":CodUsuario",$_SESSION["usuarioDAW208AppLoginLogout"]); //Blindeo el parámentro del código de usuario.
        $consulta ->execute(); //Ejecuto la consulta.
            $oRegistro = $consulta->fetchObject(); //Almaceno los objetos que voy a recorres con fetchObject() en una variable que se llama $oRegistro.
            $passwordUsuario = $oRegistro->T01_Password; //Almaceno la contraseña del usuario de la base de datos en una variable que se llama $passwordUsuario.
            $passwordEncriptada=hash('sha256',$_SESSION['usuarioDAW208AppLoginLogout'].$_REQUEST['PasswdActual']); //Encripto la contraseña.
            
        if($passwordEncriptada!=$passwordUsuario){ //Si la contraseña encriptada es distinta de la contraseña del usuario.
            $aErrores['PasswdActual'] = "Error, contraseña incorrecta"; //Contraseña incorrecta.
        }
        if($_REQUEST['PasswdNueva'] != $_REQUEST['PasswdConfirmar']){ //Si la contraseña nueva es distinta a la confirmación de la misma.
            $aErrores['PasswdConfirmar'] = "Error, la contraseña no coincide"; //Contraseña incorrecta.
        }
                     
        }catch(PDOException $miExcepcionPDO){
            echo "<p style='color:red;'>Error ".$miExcepcionPDO->getMessage()."</p>"; //Muestro el mensaje de la excepción de errores.
            echo "<p style='color:red;'>Código de error ".$miExcepcionPDO->getCode()."</p>"; //Muestro el código del error.
        }finally{
            unset($miDB); //Cierro la conexión a la base de datos.
        }
             
        foreach($aErrores as $campo => $error){ //Recorro con un foreach el array de errores.
            if($error != null){ //Si hay errores.
                $entradaOk=false;
                $_REQUEST[$campo]=""; //Muestro el campo del formulario vacío.
            }
        }
    }else{
        $entradaOk=false;
    }
    if($entradaOk){ //Si la entrada es correcta.
        try{
            $miDB = new PDO(HOST, USER, PASSWORD); //Establezco la conexión a la base de datos instanciado un objeto PDO.
            $miDB ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cuando se produce un error lanza una excepción utilizando PDOException.
            
            $actualizacion="UPDATE T01_Usuario SET T01_Password = :Password WHERE T01_CodUsuario = :CodUsuario"; //Hago un update en la base de datos para cambiar la contraseña del usuario.
            
            $consulta=$miDB->prepare($actualizacion); //Preparo la consulta.
            $parametros =[":Password" => hash('sha256',$_SESSION['usuarioDAW208AppLoginLogout'].$_REQUEST['PasswdNueva']), //Creo un array y añado los parámetros correspondientes.
                          ":CodUsuario" => $_SESSION["usuarioDAW208AppLoginLogout"]];
            
            $consulta->execute($parametros); //Ejecuto la consulta pasándole los parámetros.
            
            header('Location: editarPerfil.php'); //Redirijo al usuario al editar perfil.
            
        }catch(PDOException $miExcepcionPDO){
            echo "<p style='color:red;'>Error ".$miExcepcionPDO->getMessage()."</p>"; //Muestro el mensaje de la excepción de errores.
            echo "<p style='color:red;'>Código de error ".$miExcepcionPDO->getCode()."</p>"; //Muestro el código del error.
        }finally{
            unset($miDB);
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
            <title>Cambiar Contraseña</title>
    </head>
    <body>
        <header>
            <h1>Cambiar Contraseña LoginLogout </h1>
        </header>
        <div id="containerRegistro">
            <form name="formulario" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div>
                    <label  for="PasswdActual">Contraseña actual: </label></b>
                    <input  type="password" name="PasswdActual" value="<?php 
                            if($aErrores["PasswdActual"] == null && isset($_REQUEST["PasswdActual"])){ //Compruebo  que los campos del array de errores están vacíos y el usuario le ha dado al botón de enviar.
                                echo $_REQUEST["PasswdActual"]; //Devuelve el campo que ha escrito previamente el usuario.
                            }
                            ?>">
                    <span style="color:red">
                        <?php
                            if ($aErrores["PasswdActual"] != null) { //Compruebo que el array de errores no está vacío.
                                echo $aErrores["PasswdActual"]; //Si hay errores, devuelve el campo vacío y muestra una advertencia de los errores y como tiene que estar escrito ese campo.
                            }
                        ?>
                    </span>
                </div>
                <br>
                    <div>
                        <label  for="PasswdNueva">Contraseña nueva: </label>
                        <input  type="password" name="PasswdNueva" value="<?php 
                                if($aErrores["PasswdNueva"] == null && isset($_REQUEST["PasswdNueva"])){ //Compruebo  que los campos del array de errores están vacíos y el usuario le ha dado al botón de enviar.
                                    echo $_REQUEST["PasswdNueva"]; //Devuelve el campo que ha escrito previamente el usuario.
                                }
                                ?>">
                        <span style="color:red">
                            <?php
                                if ($aErrores["PasswdNueva"] != null) { //Compruebo que el array de errores no está vacío.
                                    echo $aErrores["PasswdNueva"]; //Si hay errores, devuelve el campo vacío y muestra una advertencia de los errores y como tiene que estar escrito ese campo.
                                }
                            ?>
                        </span>
                    </div>
                <br>
                    <div>
                        <label  for="PasswdConfirmar">Repetir contraseña nueva: </label>
                        <input  type="password" name="PasswdConfirmar" value="<?php 
                                if($aErrores["PasswdConfirmar"] == null && isset($_REQUEST["PasswdConfirmar"])){ //Compruebo  que los campos del array de errores están vacíos y el usuario le ha dado al botón de enviar.
                                    echo $_REQUEST["PasswdConfirmar"]; //Devuelve el campo que ha escrito previamente el usuario.
                                }
                                ?>">
                        <span style="color:red">
                            <?php
                                if ($aErrores["PasswdConfirmar"] != null) { //Compruebo que el array de errores no está vacío.
                                    echo $aErrores["PasswdConfirmar"]; //Si hay errores, devuelve el campo vacío y muestra una advertencia de los errores y como tiene que estar escrito ese campo.
                                }
                            ?>
                        </span>
                    </div>
                <br>
                    <input type="submit" name="aceptar" class="btnlogin" value="ACEPTAR">
                   <input style="background: rgba(255, 3, 3, 0.3);" type="submit" name="cancelar" class="btnlogin" value="CANCELAR">
            </fieldset>
        </form>
        </div>
         <footer class="piepagina">
                <a href="https://github.com/aroago/208DWESLoginLogoutTema5" target="_blank"><img src="../webroot/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a><a href="https://daw208.ieslossauces.es/">2021 Todos los derechos reservados AroaGO.</a> Fecha Modificación:14/12/2021</p> 
            </footer>
    </body>
</html>
<?php
    }
?>
