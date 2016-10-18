function init() {
	// Carga las areas principales:
	var catId = $('categoriaId').value;
	var prodId = $('productoId').value;
	var paginaActual = -1;
	
	ajaxLoad('categorias', '/categorias/'+catId, 'catsLoading');
	ajaxLoad('elementos', '/productos/'+catId+'/'+prodId, 'prodsLoading');
	ajaxLoad('detalles', '/producto/'+prodId, 'prodLoading');
	
	// TODO Preload hover images:
	if (document.images)
	{
	  var footer_over_png = new Image(796, 122);	footer_over_png.src = '/img/layout/footer-over.png';
	  var foto_anterior_png = new Image(29, 29);	foto_anterior_png.src = '/img/layout/foto-anterior.png';
	  var foto_siguiente_png = new Image(29, 29);	foto_siguiente_png.src = '/img/layout/foto-siguiente.png';
	  var grad_bla_ver_png = new Image(100, 100);	grad_bla_ver_png.src = '/img/grad_bla_ver.png';
	  var loading_gif = new Image(123, 6);				loading_gif.src = '/img/loading.gif';
	  var enviar_down_png = new Image(118, 121);	enviar_down_png.src = '/img/layout/enviar-down.png';
	}
	
	// Imagenes del detalle de productos:
  var imagenesDelProducto = new Array();
  var imagenEnDetalles = 0;
  
  // AddThis vars:
	var addthis_url		= 'http://ledtec.com.mx';
	var addthis_title	= 'LedTec (México)';
	var addthis_pub		= 'jopaddthiscom';
}

function ajaxLoad(update, url, loading) {
	if(loading && $(loading)) $(loading).show();
	new Ajax.Updater(update, url, {evalScripts: true})
}


// VENTANITA:

function mostrarVentana() {
	$('ventana_contacto').show();
	$('div_cerrar').show();
}

function esconderVentana() {
	// TODO SCROLL UP
	$('ventana_contacto').hide();
	$('div_cerrar').hide();
	$('ventana_contenido').hide();
}

function buscar() {
	mostrarVentana();
	new Ajax.Updater('ventana_contenido', '/buscar', {parameters: Form.serialize('busqueda_rapida'), evalScripts: true, onComplete: function(){if ($('ventana_contacto').getStyle('display') != 'none') $('ventana_contenido').show();}});
}

function contacto() {
	mostrarVentana();
	new Ajax.Updater('ventana_contenido', '/contacto', {evalScripts: true, onComplete: function(){if ($('ventana_contacto').getStyle('display') != 'none') $('ventana_contenido').show();}});
}
function mensaje() {
	$('enviar_mensaje').hide();
	$('enviando_mensaje').show();
	new Ajax.Request('/contacto', {parameters: Form.serialize('mensaje'), onComplete: function(transport){enviado();}});
}
function enviado(transport) {
	alert('¡Gracias! El mensaje ha sido enviado.');
	esconderVentana();
}

function newCat() {
	mostrarVentana();
	new Ajax.Updater('ventana_contenido', '/admin/categorias/editar', {evalScripts: true, onComplete: function(){if ($('ventana_contacto').getStyle('display') != 'none') $('ventana_contenido').show();}});
}
function editCat(catToEdit, send) {
	var params = null;
	if (send) params = Form.serialize('edit_cat');
	if (!params) mostrarVentana();
	new Ajax.Updater('ventana_contenido', '/admin/categorias/editar/'+catToEdit, {parameters: params, evalScripts: true, onComplete: function(){if ($('ventana_contacto').getStyle('display') != 'none') $('ventana_contenido').show();}});
	$('guardando').show();
	$('guardar').hide();
}
function delCat(catToDelete) {
	if (confirm('Esto borrará la categoría permanentemente con subcategorías y productos (que no pertenezcan a otras categorías).'))
		new Ajax.Request('/admin/categorias/editar/'+catToDelete+'/1', {onComplete: function(transport){ajaxLoad('categorias', '/categorias', 'catsLoading');}});
}
function newProd() {
	mostrarVentana();
	new Ajax.Updater('ventana_contenido', '/admin/productos/editarIframe', {evalScripts: true, onComplete: function(){if ($('ventana_contacto').getStyle('display') != 'none') $('ventana_contenido').show();}});
}
function editProd(prodId) {
	mostrarVentana();
	new Ajax.Updater('ventana_contenido', '/admin/productos/editarIframe/'+prodId, {evalScripts: true, onComplete: function(){if ($('ventana_contacto').getStyle('display') != 'none') $('ventana_contenido').show();}});
}
function delProd(prodToDelete) {
	if (confirm('Esto borrará el producto permanentemente.'))
		new Ajax.Request('/admin/productos/editar/'+prodToDelete+'/1', {onComplete: function(transport){ajaxLoad('elementos', '/productos/'+catId, 'prodsLoading');}});
}
function editPhotos(prodToEditPh) {
	mostrarVentana();
	new Ajax.Updater('ventana_contenido', '/admin/productos/fotos/'+prodToEditPh, {evalScripts: true, onComplete: function(){if ($('ventana_contacto').getStyle('display') != 'none') $('ventana_contenido').show();}});
}


// CATEGORÍAS:

function loadProducts(nCatId, nombre) {
	if (nombre) $('prodsLoading_nombre').innerHTML = nombre;
	ajaxLoad('elementos', '/productos/'+nCatId, 'prodsLoading');
	
	$('categoria_'+catId).removeClassName('selected');
	$('categoria_'+nCatId).addClassName('selected');
	catId = nCatId;
}


// PRODUCTOS:

function loadProduct(nProdId, nombre) {
	if (nombre) $('prodLoading_nombre').innerHTML = nombre;
	ajaxLoad('detalles', '/producto/'+nProdId, 'prodLoading');
	
	$('prod_'+prodId).removeClassName('selected');
	if ($('prod_'+nProdId)) $('prod_'+nProdId).addClassName('selected');
	prodId = nProdId;
}

function cambiarAPagina(pagina) {
	if (pagina<1 || pagina==paginaActual || !$('pagina_'+pagina)) return;
	$('pagina_'+paginaActual).hide();
	$('pagina_'+pagina).show();
	paginaActual = pagina;
}


// DETALLES:

function setImage() {
	$('la_imagen').style.background = '#fff url('+imagenesDelProducto[imagenEnDetalles]+') center no-repeat';
}

function prevImage() {
	if (imagenEnDetalles < 1)
		imagenEnDetalles = imagenesDelProducto.length - 1;
	else imagenEnDetalles--;
	
	setImage();
}

function nextImage() {
	if (imagenEnDetalles > imagenesDelProducto.length-2)
		imagenEnDetalles = 0;
	else imagenEnDetalles++;
	
	setImage();
}