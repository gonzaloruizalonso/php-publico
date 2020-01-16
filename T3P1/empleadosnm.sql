-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2020 a las 13:02:17
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `empleadosnm`
--
create database empleadosnm;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE IF NOT EXISTS `departamento` (
  `cod_dpto` varchar(4) NOT NULL DEFAULT '',
  `nombre_dpto` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`cod_dpto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`cod_dpto`, `nombre_dpto`) VALUES
('D001', 'COMPRAS'),
('D002', 'VENTAS'),
('D004', 'INFORMATICA'),
('D005', 'RRHH'),
('D006', 'ID'),
('D007', 'PP'),
('D008', 'RCT3'),
('D009', 'RCT2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `nombre` varchar(40) DEFAULT NULL,
  `apellidos` varchar(40) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `salario` double DEFAULT NULL,
  PRIMARY KEY (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`dni`, `nombre`, `apellidos`, `fecha_nac`, `salario`) VALUES
('10032000F', 'Amaya', 'Pastors', '1977-07-07', 2631),
('11111111P', 'GONZALO', 'RUIZ', '2000-03-25', 3000),
('11111151S', 'Pablo', 'Motos', '1996-09-01', 300000),
('22222222Q', 'ALVARO', 'LOPEZ', '1997-05-20', 2000),
('22222225L', 'PEPE', 'SANCHEZ', '2009-04-04', 499),
('33333333Q', 'Gabriel', 'Rufian', '2000-02-02', 899),
('33333337P', 'MARIANO', 'RAOY', '3332-03-23', 2009),
('66677788P', 'PEPA', 'PIG', '2020-01-08', 3000),
('69696969X', 'Kiko', 'Rivera', '2001-01-01', 96),
('78237832S', 'Celia', 'Cova', '1986-02-03', 488),
('88888989N', 'Alberto', 'Perez', '2000-01-28', 6777);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_departamento`
--

CREATE TABLE IF NOT EXISTS `empleado_departamento` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `cod_dpto` varchar(4) NOT NULL DEFAULT '',
  `fecha_ini` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`dni`,`cod_dpto`,`fecha_ini`),
  KEY `fk_empdep_cd` (`cod_dpto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleado_departamento`
--

INSERT INTO `empleado_departamento` (`dni`, `cod_dpto`, `fecha_ini`, `fecha_fin`) VALUES
('10032000F', 'D001', '2020-01-10 18:59:56', NULL),
('10032000F', 'D004', '2019-12-18 09:50:50', '2020-01-10 18:59:56'),
('11111111P', 'D001', '2007-04-02 00:00:00', NULL),
('11111151S', 'D001', '2020-01-10 12:56:22', NULL),
('22222222Q', 'D002', '2001-10-11 00:00:00', NULL),
('33333333Q', 'D004', '2020-01-10 13:24:09', '2020-01-10 13:42:59'),
('33333333Q', 'D005', '2020-01-10 13:46:54', NULL),
('33333333Q', 'D006', '2020-01-10 13:46:08', '2020-01-10 13:46:54'),
('33333333Q', 'D007', '2020-01-10 13:42:59', '2020-01-10 13:46:08'),
('33333337P', 'D001', '2020-01-10 14:08:07', NULL),
('66677788P', 'D006', '2020-01-10 12:57:22', NULL),
('69696969X', 'D001', '2020-01-13 08:59:36', '2020-01-13 09:00:21'),
('69696969X', 'D001', '2020-01-13 09:01:51', NULL),
('69696969X', 'D002', '2020-01-13 09:00:21', '2020-01-13 09:01:51'),
('78237832S', 'D006', '2019-12-18 09:48:45', NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleado_departamento`
--
ALTER TABLE `empleado_departamento`
  ADD CONSTRAINT `fk_empdep_cd` FOREIGN KEY (`cod_dpto`) REFERENCES `departamento` (`cod_dpto`),
  ADD CONSTRAINT `fk_empdep_dni` FOREIGN KEY (`dni`) REFERENCES `empleado` (`dni`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
