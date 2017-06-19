-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.12-log - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para tfg
CREATE DATABASE IF NOT EXISTS `tfg` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tfg`;


-- Volcando estructura para tabla tfg.caso_negocio
CREATE TABLE IF NOT EXISTS `caso_negocio` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  `Objetivo_Estrategico` varchar(250) NOT NULL,
  `Presupuesto` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla tfg.fase_proyecto
CREATE TABLE IF NOT EXISTS `fase_proyecto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla tfg.hoja_horas
CREATE TABLE IF NOT EXISTS `hoja_horas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Recurso` int(11) NOT NULL,
  `Proyecto` int(11) NOT NULL,
  `Anio` int(11) NOT NULL,
  `Semana` int(11) NOT NULL,
  `Horas` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_Hoja_Horas_recurso` (`Recurso`),
  KEY `FK_Hoja_Horas_proyecto` (`Proyecto`),
  CONSTRAINT `FK_Hoja_Horas_proyecto` FOREIGN KEY (`Proyecto`) REFERENCES `proyecto` (`ID`),
  CONSTRAINT `FK_Hoja_Horas_recurso` FOREIGN KEY (`Recurso`) REFERENCES `recurso` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla tfg.plan_recursos
CREATE TABLE IF NOT EXISTS `plan_recursos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Recurso` int(11) NOT NULL,
  `Proyecto` int(11) NOT NULL,
  `Anio` int(11) NOT NULL,
  `Semana` int(11) NOT NULL,
  `Horas` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_Plan_recursos_recurso` (`Recurso`),
  KEY `FK_Plan_recursos_proyecto` (`Proyecto`),
  CONSTRAINT `FK_Plan_recursos_proyecto` FOREIGN KEY (`Proyecto`) REFERENCES `proyecto` (`ID`),
  CONSTRAINT `FK_Plan_recursos_recurso` FOREIGN KEY (`Recurso`) REFERENCES `recurso` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla tfg.proyecto
CREATE TABLE IF NOT EXISTS `proyecto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  `Tipo` int(11) NOT NULL,
  `PM` int(11) NOT NULL,
  `Presupuesto` int(11) NOT NULL,
  `Fase` int(11) NOT NULL,
  `Caso_Negocio` int(11) NOT NULL,
  `Fecha_P_Inicio` date DEFAULT NULL,
  `Fecha_P_Fin` date DEFAULT NULL,
  `Fecha_R_Inicio` date DEFAULT NULL,
  `Fecha_R_Fin` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__tipo_proyecto` (`Tipo`),
  KEY `FK__recurso` (`PM`),
  KEY `FK__fase_proyecto` (`Fase`),
  KEY `FK__caso_negocio` (`Caso_Negocio`),
  CONSTRAINT `FK__caso_negocio` FOREIGN KEY (`Caso_Negocio`) REFERENCES `caso_negocio` (`ID`),
  CONSTRAINT `FK__fase_proyecto` FOREIGN KEY (`Fase`) REFERENCES `fase_proyecto` (`ID`),
  CONSTRAINT `FK__recurso` FOREIGN KEY (`PM`) REFERENCES `recurso` (`ID`),
  CONSTRAINT `FK__tipo_proyecto` FOREIGN KEY (`Tipo`) REFERENCES `tipo_proyecto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla tfg.recurso
CREATE TABLE IF NOT EXISTS `recurso` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Rol` varchar(50) NOT NULL,
  `Coste_Hora` int(11) NOT NULL,
  `Manager` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_recurso_recurso` (`Manager`),
  CONSTRAINT `FK_recurso_recurso` FOREIGN KEY (`Manager`) REFERENCES `recurso` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla tfg.seguimiento_proyecto
CREATE TABLE IF NOT EXISTS `seguimiento_proyecto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Proyecto` int(11) NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Descripcion` varchar(250) NOT NULL,
  `Fecha_Seguimiento` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__proyecto` (`Proyecto`),
  CONSTRAINT `FK__proyecto` FOREIGN KEY (`Proyecto`) REFERENCES `proyecto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla tfg.tipo_proyecto
CREATE TABLE IF NOT EXISTS `tipo_proyecto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
