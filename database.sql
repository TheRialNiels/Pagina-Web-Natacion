#CREATE DATABASE proyecto_natacion;
USE proyecto_natacion;

#horarios

#######################################################################################################################

#####################
### CREATE TABLES ###
#####################

# Table structure for "usuarios"
DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_padre` int(11) NOT NULL,
  `id_maestro` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apaterno` varchar(60) NOT NULL,
  `amaterno` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(60) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_padre` (`id_padre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

# Table structure for 'sesiones_activas'
DROP TABLE IF EXISTS `sesiones_activas`;
CREATE TABLE `sesiones_activas` (
  `id_sesion` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `hora_ini_sesion` datetime NOT NULL,
  `hora_fin_sesion` datetime NOT NULL,
  `origen` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_sesion`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

# MAESTROS
DROP TABLE IF EXISTS `maestros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maestros` (
  `id_maestro` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apaterno` varchar(60) NOT NULL,
  `amaterno` varchar(60) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `nivel` INT NOT NULL,
  PRIMARY KEY (`id_maestro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

# NINOS
DROP TABLE IF EXISTS `ninos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ninos` (
  `id_nino` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_nino` varchar(60) DEFAULT NULL,
  `apaterno_nino` varchar(60) DEFAULT NULL,
  `amaterno_nino` varchar(60) DEFAULT NULL,
  `tel_emergencia` varchar(10) NOT NULL,
  `nivel` int(11) NOT NULL,
  `role_nino` varchar(60) DEFAULT NULL,
  `estado_nino` varchar(60) DEFAULT NULL,
  `id_padre` int(11) NOT NULL,
  PRIMARY KEY (`id_nino`),
  KEY `id_padre` (`id_padre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

# PADRES
DROP TABLE IF EXISTS `padres`;
CREATE TABLE `padres` (
  `id_padre` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apaterno` varchar(60) NOT NULL,
  `amaterno` varchar(60) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `id_nino` int(11) NOT NULL,
  PRIMARY KEY (`id_padre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

# HORARIOS
DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) DEFAULT NULL,
  `hora_visita` varchar(100) DEFAULT NULL,
  `dia_visita` varchar(100) DEFAULT NULL,
  `motivo_visita` varchar(100) DEFAULT NULL,
  `numero_semana` varchar(100) DEFAULT NULL,
  `fecha_operacion` date DEFAULT NULL,
  `numero_anio` int(11) DEFAULT NULL,
  `estado` enum('1','0') DEFAULT '1',
	`id_nino` INT NOT NULL,
    FOREIGN KEY (`id_nino`) REFERENCES ninos(id_nino) ON DELETE CASCADE,
  PRIMARY KEY (`id_horario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

#######################################################################################################################

##########################
### SEE DATA OF TABLES ###
##########################

SELECT * FROM usuarios;
SELECT * FROM sesiones_activas;
SELECT * FROM horarios;
SELECT * FROM maestros;
SELECT * FROM ninos;
SELECT * FROM padres;

#######################################################################################################################

###################
### DROP TABLES ###
###################

-- !!! 
-- COMMENT ALL THE LINES OF THIS SECTION
-- !!!

#DROP TABLE usuarios;
#DROP TABLE sesiones_activas;

#######################################################################################################################

###################################
### CREATION OF DATA FOR TABLES ###
###################################

# USUARIOS
INSERT INTO `usuarios` VALUES
(0,0,0,'Ninguno',' ',' ',' ','','','',0),
(1,0,0,'Admin','','','','admin','1234','Admin',1);

# HORARIOS
INSERT INTO `horarios` VALUES ('1', 'Hola', '9a-10a', 'Lunes', '...', '10', '2022-06-14', '2022', '1', '1');

#######################################################################################################################


#######################################################################################################################


#######################################################################################################################
