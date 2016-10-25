-- phpMyAdmin SQL Dump
-- version 2.11.9.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 08-01-2009 a las 21:39:27
-- Versión del servidor: 5.0.67
-- Versión de PHP: 5.2.3
--
-- 8 de ENERO 2009
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `clubbons_ledtec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

DROP TABLE IF EXISTS `administradores`;
CREATE TABLE IF NOT EXISTS `administradores` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(255) default NULL,
  `contrasena` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `email`, `contrasena`) VALUES
(1, 'rorpinel@orpinelelectronics.com', '269b141b7ed3618e4ef24f1588f68989');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(255) default NULL,
  `cat_superior_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Volcar la base de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `cat_superior_id`) VALUES
(1, 'Accesorios', NULL),
(2, 'Para instalar', 1),
(18, 'De uso manual', 1),
(17, 'x', NULL),
(8, 'Botellas', NULL),
(9, 'Dicroicos MR16', 8),
(10, 'De Vidrio', 8),
(11, 'Con Atomizador', 8),
(13, 'EDITAME', NULL),
(14, 'a mi también !', 13),
(19, 'sdf', 1),
(20, 'edfcedc', 1),
(21, 'ssss', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
CREATE TABLE IF NOT EXISTS `imagenes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `archivo` varchar(255) default NULL,
  `tipo` enum('producto') default 'producto',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Volcar la base de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `archivo`, `tipo`) VALUES
(11, '60510c86fb54937e5b26cc8cc38ba8dc.JPG', 'producto'),
(3, 'a1_big.jpg', 'producto'),
(13, 'a0088c2a84cef3171876e6f90f07f330.jpg', 'producto'),
(17, '199284ce757846c40479f68782b48b6a.JPG', 'producto'),
(7, 'b2_big.jpg', 'producto'),
(8, 'b3_big.jpg', 'producto'),
(9, 'Staples_Remover.summ.jpg', 'producto'),
(10, 'OP174.jpg', 'producto'),
(12, 'b7b61e093db62154a654f2a0a7c7ae78.jpg', 'producto'),
(14, '09c40323baa4ce00e89052e2e09fde05.JPG', 'producto'),
(15, '4b5a467f45c281147ea5eb7b4d815b84.JPG', 'producto'),
(16, '852fd5c7fd7bb866c0252b6793a54cbe.jpg', 'producto'),
(18, '51cddddfcb4028961470a1b90ccfe784.jpg', 'producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `clave` varchar(255) default NULL,
  `nombre` varchar(255) default NULL,
  `precio_1` float default NULL COMMENT 'Pecio unitario',
  `precio_1000` float default NULL COMMENT 'Precio de mayoreo (1000 unidades)',
  `descripcion` text,
  `imagen_principal` smallint(6) default '0',
  `archivo_specs` varchar(255) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcar la base de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `clave`, `nombre`, `precio_1`, `precio_1000`, `descripcion`, `imagen_principal`, `archivo_specs`, `created`, `modified`) VALUES
(11, '', 'Lámpara LED', 300, 200000, '... que además es un útil llavero.', 0, NULL, '2007-11-20 03:58:20', '2007-11-20 05:00:14'),
(10, 'sku_1112', 'Luz de frente (minero)', 1200, 123000, 'Luz LED que se ajusta a la frente para toda circunstancia.\r\n', 3, '83a0486a59e9da28452bb69f30a5ac7d.jpg', '2007-11-20 03:48:41', '2007-11-20 05:21:39'),
(3, 'sku_1111', 'Quita-grapas', 13, 500, 'Producto de prueba\r\n\r\n¡Con varias fotos!', 0, '200710-cv_en.pdf', '2007-10-06 18:39:32', '2007-11-20 04:59:06'),
(13, 'wer234', 'sdfsd', 234, 234, 'qwerqwer\r\nqwe\r\nr\r\nqwer', 1, NULL, '2008-08-21 22:59:53', '2008-09-03 10:13:18'),
(7, 'x', 'botella 2', 1, 500, 'Descripción de este artículo', 0, NULL, '2007-10-06 18:39:32', NULL),
(8, 'x', 'botella 3', 1, 500, 'Descripción de este artículo', 0, NULL, '2007-10-06 18:39:32', NULL),
(12, 'sku_1113', 'Luz exterior', 150, 100000, 'Con resistencia anti asalto.', 0, NULL, '2007-11-20 05:11:11', '2007-11-20 05:11:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_categorias`
--

DROP TABLE IF EXISTS `productos_categorias`;
CREATE TABLE IF NOT EXISTS `productos_categorias` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `categoria_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Volcar la base de datos para la tabla `productos_categorias`
--

INSERT INTO `productos_categorias` (`id`, `producto_id`, `categoria_id`) VALUES
(32, 10, 18),
(31, 10, 1),
(25, 3, 17),
(30, 12, 2),
(27, 11, 18),
(34, 13, 1),
(7, 7, 10),
(8, 8, 11),
(35, 13, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_imagenes`
--

DROP TABLE IF EXISTS `productos_imagenes`;
CREATE TABLE IF NOT EXISTS `productos_imagenes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `producto_id` int(11) default NULL,
  `imagen_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Volcar la base de datos para la tabla `productos_imagenes`
--

INSERT INTO `productos_imagenes` (`id`, `producto_id`, `imagen_id`) VALUES
(12, 11, 12),
(11, 10, 11),
(3, 3, 3),
(14, 10, 14),
(13, 10, 13),
(18, 13, 17),
(7, 7, 7),
(8, 8, 8),
(9, 3, 9),
(10, 3, 10),
(15, 10, 15),
(17, 12, 16),
(19, 13, 18);
