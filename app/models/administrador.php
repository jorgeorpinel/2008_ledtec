<?php
/**
 * Clase Administrador
 *
 * @copyright	(c) 2007 LedTec
 * @link			www.ledtec.com.mx
 */

/**
 * Modelo de administradores
 *
 * @author Jorge Orpinel
 */
class Administrador extends AppModel
{
	var $name = 'Administrador';
	var $useTable = 'administradores';
	var $validate = array(
	  'email' => array('rule'=>'email', 'message'=>'Email inválido.'),
	);
	
	
	//
	
	//
	
	
	//
	
	//
	
	
}
?>