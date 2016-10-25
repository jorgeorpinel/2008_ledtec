-- MySQL dump 10.10
--
-- Host: localhost    Database: clubbons_ledtec
-- ------------------------------------------------------
-- Server version	5.0.24a-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
CREATE TABLE `administradores` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(255) default NULL,
  `contrasena` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administradores`
--


/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
LOCK TABLES `administradores` WRITE;
INSERT INTO `administradores` VALUES (1,'rorpinel@orpinelelectronics.com','269b141b7ed3618e4ef24f1588f68989');
UNLOCK TABLES;
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) default NULL,
  `cat_superior_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorias`
--


/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
LOCK TABLES `categorias` WRITE;
INSERT INTO `categorias` VALUES (1,'Artículos de Oficina',NULL),(2,'Desengrapadoras',1),(3,'Folders',1),(4,'Lápices',1),(5,'Teléfonos',NULL),(6,'Celulares',5),(7,'Estacionarios',5),(8,'Botellas',NULL),(9,'De Plástico',8),(10,'De Vidrio',8),(11,'Con Atomizador',8);
UNLOCK TABLES;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `clave` varchar(255) default NULL,
  `nombre` varchar(255) default NULL,
  `precio_1` float default NULL COMMENT 'Pecio unitario',
  `precio_1000` float default NULL COMMENT 'Precio de mayoreo (1000 unidades)',
  `descripcion` text,
  `archivo_img` varchar(255) default NULL,
  `archivo_specs` varchar(255) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productos`
--


/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
LOCK TABLES `productos` WRITE;
INSERT INTO `productos` VALUES (1,'x','teléfono 1',1,500,'Descripción de este artículo','1_big.jpg','200710-cv_en.pdf','2007-10-06 18:39:32',NULL),(2,'x','teléfono 2',1,500,'Descripción de este artículo','2_big.jpg',NULL,'2007-10-06 18:39:32',NULL),(3,'x','artículo 1',1,500,'Descripción de este artículo','a1_big.jpg','200710-cv_en.pdf','2007-10-06 18:39:32',NULL),(4,'x','artículo 2',1,500,'Descripción de este artículo','a2_big.jpg',NULL,'2007-10-06 18:39:32',NULL),(5,'x','artículo 3',1,500,'Descripción de este artículo','a3_big.jpg',NULL,'2007-10-06 18:39:32',NULL),(6,'x','botella 1',1,500,'Descripción de este artículo','b1_big.jpg','200710-cv_en.pdf','2007-10-06 18:39:32',NULL),(7,'x','botella 2',1,500,'Descripción de este artículo','b2_big.jpg',NULL,'2007-10-06 18:39:32',NULL),(8,'x','botella 3',1,500,'Descripción de este artículo','b3_big.jpg',NULL,'2007-10-06 18:39:32',NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

--
-- Table structure for table `productos_categorias`
--

DROP TABLE IF EXISTS `productos_categorias`;
CREATE TABLE `productos_categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `categoria_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productos_categorias`
--


/*!40000 ALTER TABLE `productos_categorias` DISABLE KEYS */;
LOCK TABLES `productos_categorias` WRITE;
INSERT INTO `productos_categorias` VALUES (1,1,6),(2,2,7),(3,3,2),(4,4,3),(5,5,4),(6,6,9),(7,7,10),(8,8,11);
UNLOCK TABLES;
/*!40000 ALTER TABLE `productos_categorias` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

