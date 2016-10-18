<?php
/**
 * Clase Producto
 *
 * @copyright	(c) 2007 LedTec
 * @link			www.ledtec.com.mx
 */

/**
 * Modelo de productos
 *
 * @author Jorge Orpinel
 */
class Producto extends AppModel
{
	var $name = 'Producto';
	var $validate = array(
	  'nombre' => array('rule'=>VALID_NOT_EMPTY, 'message'=>'Debe tener un nombre.'),
	  'precio_1000' => array('rule'=>'numeric', 'message'=>'Debe tener un precio de mayoreo válido.')
	);
	
	
	var $hasAndBelongsToMany = array(
	  'Categoria' => array('className' => 'Categoria',
			'joinTable'   => 'productos_categorias',
			'foreignKey'  => 'producto_id',
			'associationForeignKey' => 'categoria_id',
			'conditions'  => '',
			'order'       => '',
			'limit'       => '',
			'unique'      => true,
			'finderQuery' => '',
			'deleteQuery' => '',
		),
	  'Imagen' => array('className' => 'Imagen',
			'joinTable'   => 'productos_imagenes',
			'foreignKey'  => 'producto_id',
			'associationForeignKey' => 'imagen_id',
			'conditions'  => '',
			'order'       => '',
			'limit'       => '',
			'unique'      => true,
			'finderQuery' => '',
			'deleteQuery' => '',
		)
	);
	
	
	// Cake:
	
	function validates() {  // Verifica que se envíe imagen principal en nuevos productos:
	  $producto = &$this->data;
	  $valido = parent::validates();
	  
	  // Si es un prod. nuevo y no se manda imagen principal:
	  if (empty($producto['Producto']['id']) && (empty($producto['Producto']['imagen_principal']) || $producto['Producto']['imagen_principal']['error']==4)) {
	    // Invalida la imagen principal (porque no se envió):
      $this->invalidate('imagen_principal', 'Debe haber una imagen principal.');
      return false;
	  }
	  
	  return $valido;
	}
	
	function beforeSave() {  // Guarda el archivo de specs (borrando el anterior) y la imagen principal (si aplica):
	  $producto = &$this->data;
	  
	  // Procesa la imagen, si existe:	XXX Borrar anterior del image_cache
	  $specsAnterior = false;
	  $valido = true;
	  
	  // Si se está editando:
	  if (!empty($producto['Producto']['id']) && is_numeric($producto['Producto']['id']) && $producto['Producto']['id']>0) {
	    $datosAnteriores = $this->findById($producto['Producto']['id'], 'Producto.archivo_specs', null, -1);
	    if (isset($datosAnteriores['Producto']['archivo_specs']) && file_exists(WWW_ROOT.'files'.DS.'specs'.DS.$datosAnteriores['Producto']['archivo_specs']))
	      $specsAnterior = $datosAnteriores['Producto']['archivo_specs'];
	  }
	  
	  // Sube los archivos:
    
		// ..de imagen principal, si aplica:
    if (!empty($producto['Producto']['imagen_principal']) && !$producto['Producto']['imagen_principal']['error']) {
	    $archivo = $this->_subeArchivo($producto['Producto']['imagen_principal'], IMAGES.DS.'productos'.DS);
	    if ($archivo['error']) {  // Si hubo algún error:
	      $this->invalidate('imagen_principal', $archivo['mensaje']);
	      $valido = false;
	    } else $producto['Producto']['imagen_principal'] = $archivo['archivo'];
	  } else unset($producto['Producto']['imagen_principal']);
	  
    // ..de specs, si se envió:
	  if (!empty($producto['Producto']['archivo_specs']) && !$producto['Producto']['archivo_specs']['error']) {
	    if ($producto['Producto']['archivo_specs']['error']==4) unset($producto['Producto']['archivo_specs']);
	    else {
		    $archivo = $this->_subeArchivo($producto['Producto']['archivo_specs'], WWW_ROOT.'files'.DS.'specs'.DS);
		    if ($archivo['error']) {  // Si hubo algún error:
		      $this->invalidate('archivo_specs', $archivo['mensaje']);
		      $valido = false;
		    } else {
          if ($specsAnterior)  // Borra imagen anterior:
            unlink (WWW_ROOT.'files'.DS.'specs'.DS.$specsAnterior);
		      $producto['Producto']['archivo_specs'] = $archivo['archivo'];
		    }
	    }
	  } else unset($producto['Producto']['archivo_specs']);
	  
	  if (!$valido) return false;
	  
	  if (isset($producto['Producto']['imagen_principal'])) {
	    // Guarda el modelo de la imagen principal:
	    if ($this->Imagen->save(array('id'=>null, 'archivo'=>$producto['Producto']['imagen_principal'], 'tipo'=>'producto')))
	      // Prepara para el afterSave donde se gurdará la relación:
	      $producto['Producto']['imagen_principal'] = $this->Imagen->getLastInsertId();
	    else {
	      $this->invalidate('imagen_principal', 'Hubo un error al guardar la imagen. Reintente por favor.');
	      return false;
	    }
	  }
	  
	  return true;
	}
	
	function beforeDelete() {  // Borra el archivo de specs, si lo(s) hay, y la(s) imagen(es):
	  $producto = null;
	  if (!($producto=$this->findById($this->id))) return false;
	  
	  // Borra el archivo de specs:
	  if (!empty($producto['Producto']['archivo_specs']) && file_exists(WWW_ROOT.'files'.DS.'specs'.DS.$producto['Producto']['archivo_specs']))
	    unlink(WWW_ROOT.'files'.DS.'specs'.DS.$producto['Producto']['archivo_specs']);
	  
	  // Borra las imágenes:
	  foreach ($producto['Imagen'] as $imagen) $this->Imagen->del($imagen['id']);
	  
	  return true;
	}
	
	
}
?>