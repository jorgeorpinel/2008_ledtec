<?php
/* SVN FILE: $Id: routes.php 4410 2007-02-02 13:31:21Z phpnut $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app.config
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 4410 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-02-02 07:31:21 -0600 (Fri, 02 Feb 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */

	Router::connect('/admin', array('controller' => 'administradores', 'action' => 'login'));
	Router::connect('/login', array('controller' => 'administradores', 'action' => 'login'));
	Router::connect('/logout', array('controller' => 'administradores', 'action' => 'logout'));
	
	Router::connect('/', array('controller' => 'productos', 'action' => 'inicio'));
	Router::connect('/cat/*', array('controller' => 'productos', 'action' => 'categoria'));
	Router::connect('/prod/*', array('controller' => 'productos', 'action' => 'producto'));
	Router::connect('/rss/*', array('controller' => 'productos', 'action' => 'rss'));
	Router::connect('/detalles/*', array('controller' => 'productos', 'action' => 'inicio'));
	  Router::connect('/categorias/*', array('controller' => 'productos', 'action' => 'ajaxCategorias'));
	  Router::connect('/productos/*', array('controller' => 'productos', 'action' => 'ajaxProductosEn'));
	  Router::connect('/producto/*', array('controller' => 'productos', 'action' => 'ajaxDetallesDe'));
	  Router::connect('/buscar', array('controller' => 'productos', 'action' => 'ajaxBuscar'));
	  Router::connect('/contacto', array('controller' => 'productos', 'action' => 'ajaxContacto'));
	
	Router::connect('/admin', array('controller' => 'auth', 'action' => 'login'));
	  Router::connect('/admin/categorias/editar/*', array('controller' => 'productos', 'action' => 'ajaxEditarCat'));
	  Router::connect('/admin/productos/fotos/*', array('controller' => 'productos', 'action' => 'ajaxEditarFotos'));
	
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
?>