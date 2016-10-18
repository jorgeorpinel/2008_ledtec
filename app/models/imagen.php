<?php
/**
 * Clase Imagen
 *
 * @copyright	(c) 2007 LedTec
 * @link			www.ledtec.com.mx
 */

/**
 * Modelo de imágenes
 *
 * @author Jorge Orpinel
 */
class Imagen extends AppModel
{
	var $name = 'Imagen';
	var $useTable = 'imagenes';
	var $validate = array(
	  'archivo' => array('rule'=>VALID_NOT_EMPTY, 'message'=>'Debe tener un archivo.'),
	);
	
	
	var $hasAndBelongsToMany = array(
	  'Producto' => array('className' => 'Producto',
			'joinTable'   => 'productos_imagenes',
			'foreignKey'  => 'imagen_id',
			'associationForeignKey' => 'producto_id',
			'conditions'  => '',
			'order'       => '',
			'limit'       => '',
			'unique'      => true,
			'finderQuery' => '',
			'deleteQuery' => '',
		)
	);
	
	
	// Cake:
	
	function beforeDelete() { // Borra el archivo:
	  $imagen = $this->read('archivo');
	  $archivo =& $imagen['Imagen']['archivo'];
	  $pathImagen = IMAGES.'productos'.DS.$archivo;
	  
	  if(!empty($archivo) && file_exists($pathImagen))
	    unlink($pathImagen);
	  
	  return true;
	}
	
	
}
?>