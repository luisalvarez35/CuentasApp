-- Adminer 4.8.1 MySQL 8.0.26 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `CuentasApp`;
CREATE DATABASE `CuentasApp` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `CuentasApp`;

DROP TABLE IF EXISTS `Categorias`;
CREATE TABLE `Categorias` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

INSERT INTO `Categorias` (`id`, `nombre`) VALUES
(1,	'Transferencia'),
(2,	'Vestuario'),
(3,	'Vacaciones'),
(4,	'Desplazamientos'),
(5,	'Ocio');

DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int DEFAULT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

INSERT INTO `cuentas` (`id`, `idUsuario`, `descripcion`) VALUES
(16,	1,	'Cuenta1'),
(17,	1,	'Cuenta2'),
(18,	2,	'Cuenta3'),
(19,	2,	'Cuenta4'),
(20,	3,	'Cuenta5'),
(21,	3,	'Cuenta6');

DROP TABLE IF EXISTS `ingresosGastos`;
CREATE TABLE `ingresosGastos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(1) COLLATE utf8_spanish_ci DEFAULT '',
  `idUsuario` int DEFAULT NULL,
  `idCategoria` int DEFAULT NULL,
  `idCuenta` int DEFAULT NULL,
  `fecha` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `importe` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fechaAlta` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `fechaNac` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `usuarios` (`id`, `nombre`, `password`, `email`, `fechaAlta`, `fechaNac`) VALUES
(1,	'Luis Alvarez',	'$2y$10$SlaA0HWpHK.mYekXn7Kps.xGZLvQw9POayIIkY/06gOGVsx8MYsUG',	'LuisAlvarez@gmail.com',	'2021-10-22 13:47:51',	'1993-06-23'),
(2,	'Usuario2',	'$2y$10$jTIWdLpo9G4Z1btY2OZnv.eoVVg5byBmecZxhp98QFz0MmMajMqmC',	'Usuario2@gmail.com',	'2021-10-22 13:48:10',	'2021-10-12'),
(3,	'Usuario3',	'$2y$10$OV7ne51Pw/6kIv9oIS6TbueCiIODKnuqrGlKay9PePMgfRDI5W/pW',	'Usuario3@gmail.com',	'2021-10-22 13:48:22',	'2021-10-07');

-- 2021-10-22 13:51:37
