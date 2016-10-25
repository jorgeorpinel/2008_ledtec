/*
MySQL Data Transfer
Source Host: localhost
Source Database: clubbons_ledtec
Target Host: localhost
Target Database: clubbons_ledtec
Date: 08/11/2007 03:34:43 a.m.
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for administradores
-- ----------------------------
CREATE TABLE `administradores` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(255) default NULL,
  `contrasena` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
CREATE TABLE `categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) default NULL,
  `cat_superior_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for imagenes
-- ----------------------------
CREATE TABLE `imagenes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `archivo` varchar(255) default NULL,
  `tipo` enum('producto') default 'producto',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for productos
-- ----------------------------
CREATE TABLE `productos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `clave` varchar(255) default NULL,
  `nombre` varchar(255) default NULL,
  `precio_1` float default NULL COMMENT 'Pecio unitario',
  `precio_1000` float default NULL COMMENT 'Precio de mayoreo (1000 unidades)',
  `descripcion` text,
  `archivo_specs` varchar(255) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for productos_categorias
-- ----------------------------
CREATE TABLE `productos_categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `categoria_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for productos_imagenes
-- ----------------------------
CREATE TABLE `productos_imagenes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `imagen_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `administradores` VALUES ('1', 'rorpinel@orpinelelectronics.com', '269b141b7ed3618e4ef24f1588f68989');
INSERT INTO `categorias` VALUES ('1', 'Artículos de Oficina', null);
INSERT INTO `categorias` VALUES ('2', 'Desengrapadoras', '1');
INSERT INTO `categorias` VALUES ('3', 'Folders', '1');
INSERT INTO `categorias` VALUES ('4', 'Lápices', '1');
INSERT INTO `categorias` VALUES ('5', 'Teléfonos', null);
INSERT INTO `categorias` VALUES ('6', 'Celulares', '5');
INSERT INTO `categorias` VALUES ('7', 'Estacionarios', '5');
INSERT INTO `categorias` VALUES ('8', 'Botellas', null);
INSERT INTO `categorias` VALUES ('9', 'De Plástico', '8');
INSERT INTO `categorias` VALUES ('10', 'De Vidrio', '8');
INSERT INTO `categorias` VALUES ('11', 'Con Atomizador', '8');
INSERT INTO `imagenes` VALUES ('1', '1_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('2', '2_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('3', 'a1_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('4', 'a2_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('5', 'a3_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('6', 'b1_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('7', 'b2_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('8', 'b3_big.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('9', 'Staples_Remover.summ.jpg', 'producto');
INSERT INTO `imagenes` VALUES ('10', 'OP174.jpg', 'producto');
INSERT INTO `productos` VALUES ('1', 'x', 'teléfono 1', '1', '500', 'Descripción de este artículo', '200710-cv_en.pdf', '2007-10-06 18:39:32', null);
INSERT INTO `productos` VALUES ('2', 'x', 'teléfono 2', '1', '500', 'Descripción de este artículo', null, '2007-10-06 18:39:32', null);
INSERT INTO `productos` VALUES ('3', 'x', 'artículo 1', '1', '500', 'Descripción de este artículo', '200710-cv_en.pdf', '2007-10-06 18:39:32', null);
INSERT INTO `productos` VALUES ('4', 'x', 'artículo 2', '1', '500', 'Descripción de este artículo', null, '2007-10-06 18:39:32', null);
INSERT INTO `productos` VALUES ('5', 'x', 'artículo 3', '1', '500', 'Descripción de este artículo', null, '2007-10-06 18:39:32', null);
INSERT INTO `productos` VALUES ('6', 'x', 'botella 1', '1', '500', 'Descripción de este artículo', '200710-cv_en.pdf', '2007-10-06 18:39:32', null);
INSERT INTO `productos` VALUES ('7', 'x', 'botella 2', '1', '500', 'Descripción de este artículo', null, '2007-10-06 18:39:32', null);
INSERT INTO `productos` VALUES ('8', 'x', 'botella 3', '1', '500', 'Descripción de este artículo', null, '2007-10-06 18:39:32', null);
INSERT INTO `productos_categorias` VALUES ('1', '1', '6');
INSERT INTO `productos_categorias` VALUES ('2', '2', '7');
INSERT INTO `productos_categorias` VALUES ('3', '3', '2');
INSERT INTO `productos_categorias` VALUES ('4', '4', '3');
INSERT INTO `productos_categorias` VALUES ('5', '5', '4');
INSERT INTO `productos_categorias` VALUES ('6', '6', '9');
INSERT INTO `productos_categorias` VALUES ('7', '7', '10');
INSERT INTO `productos_categorias` VALUES ('8', '8', '11');
INSERT INTO `productos_imagenes` VALUES ('1', '1', '1');
INSERT INTO `productos_imagenes` VALUES ('2', '2', '2');
INSERT INTO `productos_imagenes` VALUES ('3', '3', '3');
INSERT INTO `productos_imagenes` VALUES ('4', '4', '4');
INSERT INTO `productos_imagenes` VALUES ('5', '5', '5');
INSERT INTO `productos_imagenes` VALUES ('6', '6', '6');
INSERT INTO `productos_imagenes` VALUES ('7', '7', '7');
INSERT INTO `productos_imagenes` VALUES ('8', '8', '8');
INSERT INTO `productos_imagenes` VALUES ('9', '3', '9');
INSERT INTO `productos_imagenes` VALUES ('10', '3', '10');
