create database `planilla-app`;

use `planilla-app`;

create table
    `rol` (
        `id` int primary key auto_increment,
        `descripcion` varchar(255) not null,
        `estado` bool not null default true,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

create table
    `usuario` (
        `id` int primary key auto_increment,
        `rol_id` int not null,
        `dni` int unique not null,
        `nombres` varchar(255) not null,
        `apellidos` varchar(255) not null,
        `direccion` text,
        `telefono` varchar(55),
        `usuario` varchar(55) not null,
        `contrasenia` text not null,
        `estado` bool not null default true,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        foreign key (`rol_id`) references `rol`(`id`)
    );

create table
    `institucion` (
        `id` int primary key auto_increment,
        `codigo` varchar(55) unique not null,
        `descripcion` varchar(255) unique not null,
        `niveles` text,
        `estado` bool not null default true,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

create table
    `docente` (
        `id` int primary key auto_increment,
        `institucion_id` int not null,
        `dni` int unique not null,
        `nombres` varchar(255) unique not null,
        `apellidos` varchar(255) not null,
        `direccion` text,
        `telefono` varchar(255),
        `asignatura` varchar(255) not null,
        `estado` bool not null default true,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        foreign key (`institucion_id`) references `institucion`(`id`)
    );

create table
    `ciclo_escolar` (
        `id` int primary key auto_increment,
        `description` varchar(255) unique not null,
        `inicio` date not null,
        `fin` date not null,
        `estado` bool not null default true,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    );

create table
    `regi_planilla` (
        `id` int primary key auto_increment,
        `usuario_id` int not null,
        `docente_id` int not null,
        `ciclo_escolar_id` int not null,
        `description` text not null,
        `monto` DECIMAL(14,2) not null,
        `fecha` varchar(560) not null,
        `ruta` varchar(255) not null,
        `observacion` text,
        `estado` bool not null default true,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        foreign key (`usuario_id`) references `usuario`(`id`),
        foreign key (`docente_id`) references `docente`(`id`),
        foreign key (`ciclo_escolar_id`) references `ciclo_escolar`(`id`)
    );

create table
    `pago` (
        `id` int primary key auto_increment,
        `usuario_id` int not null,
        `docente_id` int not null,
        `ciclo_escolar_id` int not null,
        `monto` double(14, 2) not null,
        `observacion` text,
        `fecha` datetime not null,
        `estado` bool not null default true,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        foreign key (`usuario_id`) references `usuario`(`id`),
        foreign key (`docente_id`) references `docente`(`id`),
        foreign key (`ciclo_escolar_id`) references `ciclo_escolar`(`id`)
    );