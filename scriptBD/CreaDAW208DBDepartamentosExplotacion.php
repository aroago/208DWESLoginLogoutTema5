
<?php

/*
 * Configuracion  ENTORNO EXPLOTACION 1&1
 * @author Aroa Granero Omañas
 * Fecha Creacion:  19/11/2021
 * Última modificación: 22/11/2021
 *  Crear tabla Departamento con los campos (PK)CodDepartamento (3 letras mayusculas), 
 *  DescDepartamento (max. 255 caracteres),FechaBaja, VolumenNegocio (float-€)
 */
require_once '../config/confDBPDO.php';

try {
    //Establecimiento de la conexión 
    $mydb = new PDO(HOST, USER, PASSWORD);
    $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Configuramos las excepciones
    // Array de atributos de la conexión.
    /* Usar base de datos dbs4868804*/
    $consulta = $mydb->prepare(<<<SQL
    CREATE TABLE Departamento (
    CodDepartamento VARCHAR(3) PRIMARY KEY,
    DescDepartamento VARCHAR(255) NOT NULL,
    FechaBaja DATE NULL,
    VolumenNegocio FLOAT DEFAULT NULL
    ) ENGINE = INNODB;
    SQL);
    $consulta->execute(); //Ejecuto la consulta
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