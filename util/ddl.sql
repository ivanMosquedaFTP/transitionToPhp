-- make sure to first insert into table usuario the following
ALTER TABLE usuario MODIFY COLUMN contrasena VARCHAR(50);

insert into usuario(nombre_completo, telefono, contrasena, email) values('administrador', '1234', md5('1234'), 'admin@admin.com');
insert into usuario(nombre_completo, telefono, contrasena, email) values('pruebas', '1234', md5('1234'), 'pruebas@pruebas.com');

-- for permiso table
INSERT INTO permiso (permiso) VALUES ('index'), ('Ver productos'), ('Nuevo producto'), ('Modificar producto'), ('Eliminar producto'), ('Agregar un usuario'), ('Modificar un usuario'), ('Eliminar un usuario');

-- for rol table
insert into rol(rol) values ('cliente'), ('administrador');

-- for table rol_permiso
select * from rol;
select * from permiso;
select * from usuario;

-- giving cliente permissions to see products and index
insert into rol_permiso(id_rol, id_permiso) values(1, 1);
insert into rol_permiso(id_rol, id_permiso) values(1, 2);

-- giving administrador permissions to CRUD for products and users
insert into rol_permiso(id_rol, id_permiso) values(2, 1);
insert into rol_permiso(id_rol, id_permiso) values(2, 2);
insert into rol_permiso(id_rol, id_permiso) values(2, 3);
insert into rol_permiso(id_rol, id_permiso) values(2, 4);
insert into rol_permiso(id_rol, id_permiso) values(2, 5);
insert into rol_permiso(id_rol, id_permiso) values(2, 6);
insert into rol_permiso(id_rol, id_permiso) values(2, 7);
insert into rol_permiso(id_rol, id_permiso) values(2, 8);

-- assigning roles to usuarios
select * from usuario;
select * from rol;
-- giving administrador its role
insert into usuario_rol(id_usuario, id_rol) values(1, 2);

-- giving cliente its role
insert into usuario_rol(id_usuario, id_rol) values(2, 1);

select * from rol_permiso;
select * from usuario_rol;

-- query that returns every grant for a user
select p.permiso, u.email from permiso p inner join rol_permiso rp on p.id_permiso = rp.id_permiso
inner join rol r on r.id_rol = rp.id_rol
inner join usuario_rol ur on ur.id_rol = r.id_rol
inner join usuario u on u.id = ur.id_usuario;

-- query that returns rol for a user
select r.rol, u.email from rol r inner join usuario_rol ur on r.id_rol = ur.id_rol
inner join usuario u on ur.id_usuario = u.id;

-- queries
desc permiso;
desc producto;
desc recompensa;
desc usuario;
desc venta;
select * from producto;
select * from usuario;
select * from rol;
select u.email from usuario u inner join recompensa r on u.id=r.usuario_id;
SELECT u.nombre_completo AS nombre_completo FROM usuario u inner join recompensa r on u.id=r.usuario_id WHERE u.id = 3;

-- ddl
alter table producto add column foto varchar(255);