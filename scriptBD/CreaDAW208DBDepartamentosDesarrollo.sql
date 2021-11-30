-- Crear base de datos DB207DWESProyectoTema5
CREATE DATABASE IF NOT EXISTS DB208DWESProyectoTema5;

-- CREAR Tabla T01_Usuario dentro de la base de datos DB208DWESProyectoTema5
USE DB208DWESProyectoTema5;
create table if not exists T01_Usuario(
    T01_CodUsuario varchar(8) primary key,
    T01_Password varchar(64) not null,
    T01_DescUsuario varchar(255) not null,
    T01_FechaHoraUltimaConexion datetime default now(),
    T01_NumConexiones int unsigned not null default 1,
    T01_Perfil enum('usuario','administrador') default 'usuario',
    T01_ImagenUsuario blob null
)engine=InnoDB;

-- CREAR Tabla T02_Departamento dentro de la base de datos DB208DWESProyectoTema5
create table if not exists T02_Departamento(
    T02_CodDepartamento varchar(3) primary key not null,
    T02_DescDepartamento varchar(255) not null,
    T02_FechaCreacionDepartamento date not null,
    T02_VolumenDeNegocio decimal(6,2) not null,
    T02_FechaBajaDepartamento date
)engine=InnoDB;

/* Crear el usuario usuarioDAW208DBDepartamentos / paso*/

CREATE USER 'User208DWESProyectoTema5'@'%' identified BY 'P@ssw0rd';

/* Dar permisos al usuario usuarioDAW208DBDepartamentos*/

GRANT ALL PRIVILEGES ON DB208DWESProyectoTema5.* TO 'User208DWESProyectoTema5'@'%';
