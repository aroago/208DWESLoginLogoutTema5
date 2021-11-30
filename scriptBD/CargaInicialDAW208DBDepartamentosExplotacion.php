<?php

/*
 * Configuracion  ENTORNO EXPLOTACION 1&1
 * @author Aroa Granero Omañas
 * Fecha Creacion:  19/11/2021
 * Última modificación: 23/11/2021
 */
//Incluyo las variables de la conexion
require_once '../config/confDBPDO.php';

try {
    //Hago la conexion con la base de datos
    $mydb = new PDO(HOST, USER, PASSWORD);

    // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
    $mydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql=<<<PDO
            INSERT INTO Departamento (CodDepartamento, DescDepartamento, FechaBaja, VolumenNegocio) VALUES 
            ('INF', 'Departamento de informatica', null, 1000.0),
            ('CIE', 'Departamento de ciencia', null, 2000.0),
            ('HIS', 'Departamento de historia', null, 1000.0);
        PDO;
    $mydb->exec($sql);
    echo '<a class="exitoInsercion">Inserccion en la Tabla creada con éxito.</a>';
} catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
    $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
    $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException
    echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion; //Muestro el codigo del error
    echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException; //Muestro el mensaje del error
} finally {
    //Cierro la conexion
    unset($mydb);
}
?>


