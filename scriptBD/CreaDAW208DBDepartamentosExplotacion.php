
<?php

/*
 * Configuracion  ENTORNO EXPLOTACION 1&1
 * @author Aroa Granero Omañas
 * Fecha Creacion:  19/11/2021
 * Última modificación: 22/11/2021
 */
require_once '../config/confDBPDO.php';

try {
    //Establecimiento de la conexión 
    $mydb = new PDO(HOST, USER, PASSWORD);
    $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Configuramos las excepciones
    // Array de atributos de la conexión.
    /* Usar base de datos dbs4868804*/
    $consulta = <<<CONSULTA
                CREATE TABLE IF NOT EXISTS dbs4868804.T01_Usuario(
                    T01_CodUsuario varchar(10) PRIMARY KEY,
                    T01_Password varchar(64) NOT NULL,
                    T01_DescUsuario varchar(255) NOT NULL,
                    T01_NumConexiones int DEFAULT 0,
                    T01_FechaHoraUltimaConexion int,
                    T01_Perfil enum('administrador', 'usuario') DEFAULT 'usuario',
                    T01_ImagenUsuario mediumblob NULL
                )engine=innodb;
                CREATE TABLE IF NOT EXISTS T02_Departamento(
                    T02_CodDepartamento varchar(3) PRIMARY KEY,
                    T02_DescDepartamento varchar(255) NOT NULL,
                    T02_FechaCreacionDepartamento int NULL,
                    T02_VolumenDeNegocio float NULL,
                    T02_FechaBajaDepartamento date NULL
                )engine=innodb;
                CONSULTA;
     $mydb->exec($consulta); //Ejecuto la consulta
    echo "<h3>Conexion Establecida con Exito</<h3>";
    
} catch (PDOException $excepcion) {//Código que se ejecutará si se produce alguna excepción
    //Almacenamos el código del error de la excepción en la variable $errorExcepcion
    $errorExcep = $excepcion->getCode();
    //Almacenamos el mensaje de la excepción en la variable $mensajeExcep
    $mensajeExcep = $excepcion->getMessage();

    echo "<span style='color: red;'>Error: </span>" . $mensajeExcep . "<br>"; //Mostramos el mensaje de la excepción
    echo "<span style='color: red;'>Código del error: </span>" . $errorExcep; //Mostramos el código de la excepción
} finally {
    // Cierre de la conexión.
    unset($mydb);
}
?>