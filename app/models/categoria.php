<?php
/**
 * Clase Catgoría
 *
 * @copyright	(c) 2007 LedTec
 * @link			www.ledtec.com.mx
 */

/**
 * Modelo de catgorías
 *
 * @author Jorge Orpinel
 */
class Categoria extends AppModel
{
	var $name = 'Categoria';
	var $validate = array(
	  'nombre' => array('rule'=>VALID_NOT_EMPTY, 'message'=>'Debe tener un nombre.'),
	);
	
	
	// XXX pasar la imagen de categoría a la tabla imagenes, agregar la relación, etc.
	var $hasMany = array(  // Puede ser padre...
	  'Subcategoria' => array('className' => 'Categoria',
			'conditions' => '',
			'order'      => '',
			'dependent'  => true,
			'foreignKey' => 'cat_superior_id'
		)
	);
	var $belongsTo = array(  // ... o subcategoría.
	  'Padre' => array('className' => 'Categoria',
			'conditions' => '',
			'order'      => '',
			'foreignKey' => 'cat_superior_id'
		)
	);
	var $hasAndBelongsToMany = array(
	  'Producto' => array('className' => 'Producto',
			'joinTable'   => 'productos_categorias',
			'foreignKey'  => 'categoria_id',
			'associationForeignKey' => 'producto_id',
			'conditions'  => '',
			'order'       => '',
			'limit'       => '',
			'unique'      => true,
			'finderQuery' => '',
			'deleteQuery' => '',
		)
	);
	
	// Funciones:
	
	function allProducts($categoriaId, $campos=null, $recursividad=0) {  // Encuentra todos los productos bajo esta categoría.
	  $this->id = $categoriaId;
	  unset($this->belongsTo['Padre']);  
	  unset($this->Producto->hasAndBelongsToMany['Categoria']);
	  // XXX Falta respetar campos y recursividad.
	  $this->recursive = 2;
	  $categoria = $this->read();
	  $productos = array();
	  foreach($categoria['Subcategoria'] as $subcat)
	    $productos = array_merge_recursive($productos, $this->allProducts($subcat['id']));
	  
	  $productos = array_merge_recursive($productos, $categoria['Producto']);
	  
	  // Verifica que no se repitan IDs (por artículos pertenecientes a varias subcategorías con padre común):
	  $ids = array();
	  foreach($productos as $p=>$producto) { 
	    if (in_array($producto['id'], $ids)) unset($productos[$p]);
	    else $ids[] = $producto['id'];
	  }
	  
	  return $productos;
	}
	
	
	// Cake:
	
	function afterDelete() {	// Borra los productos sueltos:
	  $productos = $this->query("SELECT id FROM productos as Producto WHERE id NOT IN(SELECT producto_id FROM productos_categorias);");
	  foreach($productos as $producto)
	    $this->Producto->del($producto['Producto']['id']);
	}
	
	
}
?>