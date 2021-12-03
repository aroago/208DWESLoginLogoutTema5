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

    $sql = <<<CONSULTA
                USE dbs4868804;
                INSERT INTO T01_Usuario(T01_CodUsuario, T01_Password, T01_DescUsuario) VALUES
                    ('albertoF',SHA2('albertoFpaso',256),'AlbertoF'),
                    ('outmane',SHA2('outmanepaso',256),'Outmane'),
                    ('rodrigo',SHA2('rodrigopaso',256),'Rodrigo'),
                    ('isabel',SHA2('isabelpaso',256),'Isabel'),
                    ('david',SHA2('davidpaso',256),'David'),
                    ('aroa',SHA2('aroapaso',256),'Aroa'),
                    ('johanna',SHA2('johannapaso',256),'Johanna'),
                    ('oscar',SHA2('oscarpaso',256),'Oscar'),
                    ('sonia',SHA2('soniapaso',256),'Sonia'),
                    ('heraclio',SHA2('heracliopaso',256),'Heraclio'),
                    ('amor',SHA2('amorpaso',256),'Amor'),
                    ('antonio',SHA2('antoniopaso',256),'Antonio'),
                    ('albertoB',SHA2('albertoBpaso',256),'AlbertoB');
                INSERT INTO T01_Usuario(T01_CodUsuario, T01_Password, T01_DescUsuario, T01_Perfil) VALUES
                    ('admin',SHA2('adminpaso',256),'Admin','administrador');
                INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio) VALUES
                    ('INF','Departamento de Informatica',1637700241,1.5),
                    ('BIO','Departamento de Biologia',1637700241,2.5),
                    ('ING','Departamento de Inglés',1637700241,3.5),
                    ('LEN','Departamento de Lengua',1637700241,4.5),
                    ('MUS','Departamento de Musica',1637700241,1.5);
                CONSULTA;
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


