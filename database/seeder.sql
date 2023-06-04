use `planilla-app`;

insert into rol (descripcion, estado, created_at, updated_at) values ('root', 1, now(), now());

insert into usuario (rol_id, dni, nombres, apellidos, direccion, telefono, usuario, contrasenia) values (1, 123456789, 'Admin', 'admin admin', 'Av. general', 981233445, 'root', '1234');