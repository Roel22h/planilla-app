use `planilla-app`;

insert into
    rol (
        descripcion,
        estado,
        created_at,
        updated_at
    )
values ('root', 1, now(), now());

insert into
    usuario (
        rol_id,
        dni,
        nombres,
        apellidos,
        direccion,
        telefono,
        usuario,
        contrasenia
    )
values (
        1,
        123456789,
        'Admin',
        'admin admin',
        'Av. general',
        981233445,
        'root',
        '$2y$10$m4Ru6tAzgDo2oTVjKRMijOBavffbNho9my5pvYeEq6jRqJtMxutf.'
    );

CREATE VIEW `jqxgrid_docente` AS
SELECT
    `d`.`id`,
    `institucion_id`,
    `i`.`descripcion` as `intitucion-descripcion`,
    `dni`,
    `nombres`,
    `apellidos`,
    `direccion`,
    `telefono`,
    `asignatura`,
    `d`.`estado`
FROM `docente` `d`
    JOIN `institucion` `i` ON `i`.`id` = `d`.`institucion_id`
