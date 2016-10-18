<?php
/**
 * Clase ProductosController
 *
 * @copyright	(c) 2007 LedTec
 * @link			www.ledtec.com.mx
 */

/**
 * Controlador de productos
 *
 * @author Jorge Orpinel
 */
class ProductosController extends AppController
{
  var $name = 'Productos';


  // Público en general:

  function inicio()  {  // Es la vista con el footer.
    $this->pageTitle = 'Iluminación LED';

    $categoriaId = 1;
    $categoria = $this->Producto->Categoria->findById($categoriaId, 'nombre', null, 1);
    if(!$categoria) $categoriaId = null;
    $_SESSION['Cat'] = array(
      'id'=>$categoriaId,
      'nom'=>$categoria?$categoria['Categoria']['nombre']:null
    );

    $productoDeCat = 0;
    $productos = $this->Producto->Categoria->allProducts($categoriaId ,'', 'id, nombre', null, 1);
    if (isset($productos[$productoDeCat]['id'])) $producto = $productos[$productoDeCat];
    $_SESSION['Prod'] = array(
      'id'=>$producto?$producto['id']:null,
      'num'=>$producto?$productoDeCat:null,
      'nom'=>$producto?$producto['nombre']:null
    );
  }

  function categoria($categoriaId=null) {  // Inicio en cierta categoría (sin producto).
    if (!$categoriaId || !is_numeric($categoriaId) || $categoriaId<1) {$this->redirect('/');return;}
    $categoria = $this->Producto->Categoria->findById($categoriaId, 'Categoria.id, Categoria.nombre', null, -1);
    if (!$categoria) {$this->redirect('/');return;}

    $_SESSION['Cat'] = array(
      'id'=>$categoriaId,
      'nom'=>$categoria['Categoria']['nombre']
    );
    $_SESSION['Prod'] = array(
      'id'=>-1,
      'num'=>null,
      'nom'=>null
    );

    $this->render('inicio');
  }

  function producto($productoId=null) {  // Inicio en cierto producto.
    if (!$productoId || !is_numeric($productoId) || $productoId<1) {$this->redirect('/');return;}
    $producto = $this->Producto->findById($productoId, null, null, 1);
    if (!$producto) {$this->redirect('/');return;}

    $_SESSION['Cat'] = array(
      'id'=>$producto['Categoria'][0]['id'],
      'nom'=>$producto['Categoria'][0]['nombre']
    );
    $_SESSION['Prod'] = array(
      'id'=>$producto['Producto']['id'],
      'num'=>null,
      'nom'=>$producto['Producto']['nombre']
    );

    $this->render('inicio');
  }

  // TODO Validar datos con JS en vista:
  // XXX Escuchar ESC para cerrar la ventanita voladora (general).
  function ajaxContacto() {
    if (empty($this->data)) {
      $this->render();
      return;
    }

//die(pr($this->data));
    // Envía el mensaje:
    $this->set('data', $this->data);
    if ($this->_emailRender($this->data['Contacto']['email'], 'LedTec: Mensaje recibido', 'mensaje_recibido'))
	    // TODO Cambiar email:
	    $this->_emailRender('poj12@hotmail.com', 'LedTec: Mensaje de '.$this->data['Contacto']['nombre'], 'mensaje_enviado');
	  // XXX No se sabe si los envió o no. Podría escupir '1' si sí para verificar
    exit;
  }

  function ajaxCategorias($catID=1) {
    if (is_numeric($catID) && $catID>0);
    else $catID = isset($_SESSION['Cat']['id'])?$_SESSION['Cat']['id']:1;

    $this->Producto->Categoria->belongsTo = array();  // para que no salga el padre.
    $this->Producto->Categoria->hasAndBelongsToMany = array();  // para que no salgan los productos.
    $this->set('categorias', $this->Producto->Categoria->findAll('ISNULL(Categoria.cat_superior_id)', null, 'Categoria.nombre', null, 1, 1));

    $this->set('catSelected', $catID);

    // RSS:
    if ($this->layout === 'xml') $this->render('rss_categorias');
  }

  function ajaxProductosEn($categoriaId, $productoId=null) {
    if (is_numeric($categoriaId) && $categoriaId>0);
    else $categoriaId = isset($_SESSION['Cat']['id'])?$_SESSION['Cat']['id']:1;
    if (is_numeric($productoId) && $productoId>0);

    $categoria = $this->Producto->Categoria->findById($categoriaId, 'nombre', null, -1);
    if (!$categoria) die('ERROR: No existe la categoría.');
    $_SESSION['Cat'] = array(
      'id'=>$categoriaId,
      'nom'=>$categoria?$categoria['Categoria']['nombre']:null
    );

    $productos = $this->Producto->Categoria->allProducts($categoriaId);

    $this->set('productos', $productos);
    $this->set('prodSelected', $productoId?$productoId:$_SESSION['Prod']['id']); // XXX Undefined index: Prod

    // RSS:
    if ($this->layout === 'xml') $this->render('rss');
  }

  function ajaxDetallesDe($productoId) {
    if (is_numeric($productoId) && $productoId>0);
    else $productoId = isset($_SESSION['Prod']['id'])?$_SESSION['Prod']['id']:1;

    $producto = $this->Producto->findById($productoId, null, null, 1);
    if (!$producto) {$this->render('ajax_elige_producto');return;}
    $_SESSION['Prod'] = array(
      'id'=>$producto['Producto']['id'],
      'num'=>null,
      'nom'=>$producto['Producto']['nombre']
    );

    $this->set('producto', $producto);
  }

  // TODO Validar con JS que no esté vacío el campo:
  // XXX Escuchar ENTER en la forma:
  function ajaxBuscar() { // TODO Resultados de búsqueda en la ventanita:
    if (empty($this->data)) return;

    $this->data['Busqueda']['texto'] = $this->_preparaTexto($this->data['Busqueda']['texto'], 'sql');

    $productos = $this->Producto->buscarPalabrasClave($this->data['Busqueda']['texto'], 'nombre, descripcion', null, null, null, 1, 1);
    $categorias = $this->Producto->Categoria->buscarPalabrasClave($this->data['Busqueda']['texto'], 'nombre');

    $this->set('productos', $productos);
    $this->set('categorias', $categorias);
  }

  function rss($categoriaId=null) {
    loadHelper('Time');
    $this->set('time', new TimeHelper());
    Configure::write('debug', 0); // XXX Remove?
    $this->layout = 'xml';

    if(!$categoriaId || !is_numeric($categoriaId) || $categoriaId<1) $this->ajaxCategorias($categoriaId);
    else $this->ajaxProductosEn($categoriaId);
  }

  // Administradores:

  // XXX Solo hay 1 nivel de subcategorías.
  function ajaxEditarCat($categoriaId=null, $borrar=false) {
    $categoria = $this->Producto->Categoria->findById($categoriaId, null, null, 0);

    if ($borrar && $categoria) {$this->Producto->Categoria->del($categoriaId);return;}

    $this->set('categorias', $this->Producto->Categoria->generateList(($categoria?"Categoria.id != $categoriaId AND ":'').'ISNULL(Categoria.cat_superior_id)', null, null, '{n}.Categoria.id', '{n}.Categoria.nombre'));

    if (empty($this->data)) {  // Vista:
      if ($categoria) {
        $this->set('titulo', 'Editar la Categoría "'.$categoria['Categoria']['nombre'].'"');
        $this->data = $categoria;
      } else $this->set('titulo', 'Nueva Categoría');
      $this->render();
      return;
    }

    // Edita/crea la categoría:
    $this->data['Categoria']['id'] = $categoria ? $categoriaId : null;
    if ($this->data['Categoria']['cat_superior_id'] == $this->data['Categoria']['id']) unset($this->data['Categoria']['cat_superior_id']);
    if (empty($this->data['Categoria']['cat_superior_id'])) $this->data['Categoria']['cat_superior_id'] = null;

    if ($this->Producto->Categoria->save($this->data))
      die('<script type="text/javascript">esconderVentana(); ajaxLoad(\'categorias\', \'/categorias/\'+catId, \'catsLoading\');</script>');
    else {
      $this->set('titulo', 'Nueva Categoría');
      $this->Producto->Categoria->invalidate('data');
    }
  }

  function admin_editarIframe($productoId=null) {
    $this->layout = 'ajax';

    if ($productoId && is_numeric($productoId) && $productoId>1)
      $this->set('prodId', $productoId);
  }
  // TODO strip & trim campos numéricos:
  function admin_editar($productoId=null, $borrar=false) {
    $this->layout = 'iframe';

    $producto = $this->Producto->findById($productoId, null, null, 1);
    $catsDelProd = array();
    if ($producto) foreach($producto['Categoria'] as $categoria)
      $catsDelProd[] = $categoria['id'];
    if (isset($_SESSION['Cat']['id']) && !in_array($_SESSION['Cat']['id'], $catsDelProd))
      $catsDelProd[] = $_SESSION['Cat']['id'];

    if ($borrar && $producto) {$this->Producto->del($productoId);return;}

    $this->set('categorias', $this->Producto->Categoria->generateList(null, null, null, '{n}.Categoria.id', '{n}.Categoria.nombre'));
    if ($catsDelProd) $this->set('catsDelProd', $catsDelProd);

    if (empty($this->data)) {  // Vista:
      if ($producto) {
        $this->set('titulo', 'Editar el Producto "'.$producto['Producto']['nombre'].'"');
        $this->data = $producto;
      } else $this->set('titulo', 'Nuevo Producto');
      $this->render();
      return;
    }

    // Edita/crea el producto:
    $this->data['Producto']['id'] = $producto?$productoId:null;
    if (empty($this->data['Producto']['imagen_principal'])) unset($this->data['Producto']['imagen_principal']);
    if ($this->Producto->save($this->data)) {
	    $pId = $this->data['Producto']['id'];

      // Si se editó la imagen principal:
      if (!empty($this->data['Producto']['imagen_principal']) && (!isset($this->data['Producto']['imagen_principal']['error'])||(isset($this->data['Producto']['imagen_principal']['error'])&&$this->data['Producto']['imagen_principal']['error']!=4))) {
	      // Determina la imagen principal:
	      if (!$pId) $pId = $this->Producto->getLastInsertId();
	      $producto = $this->Producto->findById($pId, 'Producto.imagen_principal', null, -1);

	      // Inserta la relación:
		    $this->Producto->execute("INSERT INTO productos_imagenes VALUES (NULL, $pId, ".$producto['Producto']['imagen_principal'].');');
		    // XXX ¿Se puede entrometer otro insert aquí (otro usuario)?
		    $lastProdImgId = mysql_insert_id();
		    // Vuelve a leer todo el producto:
	      $producto = $this->Producto->findById($pId, null, null, 1);

		    $imagenPrincipal = null;
		    foreach($producto['Imagen'] as $i=>$imagen) {
		      if ($imagenPrincipal) break;
		      if ($imagen['id'] == $producto['Producto']['imagen_principal'])
		        $imagenPrincipal = $i;
		    }

		    // Guarda el número de imagen principal:
		    if (is_numeric($imagenPrincipal)) // XXX Asume que no habrá error:
		      $this->Producto->execute("UPDATE productos SET `imagen_principal` = $imagenPrincipal WHERE id IN ($pId)");
      }

		  die(
	'<script type="text/javascript">'.
"window.parent.esconderVentana();
window.parent.ajaxLoad('elementos', '/productos/'+".$producto['Categoria'][0]['id']."+'/'+$pId, 'prodsLoading');
window.parent.ajaxLoad('detalles', '/producto/'+$pId, 'prodLoading');
$('categoria_'+catId).removeClassName('selected');
$('categoria_'+".$producto['Categoria'][0]['id'].").addClassName('selected');
catId = ".$producto['Categoria'][0]['id'].';
</script>'
	    );

    } else {
      // XXX Rollback: imagen_principal (borrar archivo y modelo) y archivo_specs (borrar archivo)
      $this->set('titulo', 'Nuevo Producto');
      unset($this->data['Producto']['archivo_specs']);
      $this->Producto->invalidate('data');
    }
  }

  // XXX Edita las fotos del producto:
  function ajaxEditarFotos($productoId=null) {
    unset($this->Producto->hasAndBelongsToMany['Categoria']);
    $producto = $this->Producto->findById($productoId, null, null, 1);
    if(!$producto) return;

    if (empty($this->data)) {  // Vista:
      $this->set('titulo', 'Fotos del Producto "'.$producto['Producto']['nombre'].'"');
      $this->data = $producto['Imagen'];
      $this->render();
      return;
    }

    // XXX Edita/agrega foto(s) del producto:
    die($this->data);
  }


}
?>
