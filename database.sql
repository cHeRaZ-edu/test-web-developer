CREATE DATABASE IF NOT EXISTS db_personal;

USE db_personal;

CREATE TABLE IF NOT EXISTS personal
(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(70) NULL,
    edad INT(11) NULL,
    genero VARCHAR(70) NULL,
    fecha_nacimiento DATE NULL,
    email VARCHAR(70) NULL
) CHARACTER SET = "latin1";