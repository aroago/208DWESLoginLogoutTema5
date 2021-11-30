/* Base de datos a usar */
    USE DB208DWESProyectoTema5;aroa

insert into T01_Usuario values
('admin', SHA2('adminpaso',256), 'Usuario administrador', now(), 1, 'administrador', null),
('albertoF',SHA2('albertoFpaso',256),'AlbertoF', now(), 1, 'usuario', null),
('outmane',SHA2('outmanepaso',256),'Outmane', now(), 1, 'usuario', null),
('rodrigo',SHA2('rodrigopaso',256),'Rodrigo', now(), 1, 'usuario', null),
('isabel',SHA2('isabelpaso',256),'Isabel', now(), 1, 'usuario', null),
('david',SHA2('davidpaso',256),'David', now(), 1, 'usuario', null),
('aroa',SHA2('aroapaso',256),'Aroa', now(), 1, 'usuario', null),
('johanna',SHA2('johannapaso',256),'Johanna', now(), 1, 'usuario', null),
('oscar',SHA2('oscarpaso',256),'Oscar', now(), 1, 'usuario', null),
('sonia',SHA2('soniapaso',256),'Sonia', now(), 1, 'usuario', null),
('heraclio',SHA2('heracliopaso',256),'Heraclio', now(), 1, 'usuario', null),
('amor',SHA2('amorpaso',256),'Amor', now(), 1, 'usuario', null),
('antonio',SHA2('antoniopaso',256),'Antonio', now(), 1, 'usuario', null),
('albertoB',SHA2('albertoBpaso',256),'AlbertoB', now(), 1, 'usuario', null);

insert into T02_Departamento values
("UNO", "Primer departamento", curdate(), 30.45, null),
("DOS", "Segundo departamento", curdate(), 66.66, null),
("TRE", "Tercer departamento", curdate(), 1.11, null);