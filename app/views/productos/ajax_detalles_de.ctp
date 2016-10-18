<div id="prodLoading" class="loading" style="display:none;">
	Cargando <b id="prodLoading_nombre"></b>...<br/>
	<?php echo $html->image('loading.gif'); ?>
</div>

<script type="text/javascript">
	addthis_url		= '<?php echo urlencode(FULL_BASE_URL.'/prod/'.$_SESSION['Prod']['id']); ?>';
	addthis_title	= '<?php echo $producto['Producto']['nombre']; ?> | LedTec';
	addthis_pub		= 'jopaddthiscom';
</script>

<div id="imagen_principal">
  <a style="position: absolute; top: 215px; right: 8px; width: 160px; height: 24px;" class="accion_admin" href="http://www.addthis.com/bookmark.php" onclick="return addthis_click(this);" target="_blank">
    <img src="http://s9.addthis.com/button2-bm.png" width="160" height="24" border="0" alt="AddThis Social Bookmark Button" />
  </a>
<?php if ($session->check('adminId')) { ?>
	<div class="accion_admin" style="margin-right: 5px;" onclick="editPhotos(<?php echo $_SESSION['Prod']['id']; ?>);"><?php echo $html->image('iconos/picture_edit.png'); ?></div>
<?php } ?>
<?php if (count($producto['Imagen'])>1) { ?>
	<div style="position: absolute; height: 20px; line-height: 20px; top: 214px;">(<?php echo count($producto['Imagen']); ?> imagenes)</div>
<?php } ?>
  <div id="la_imagen"></div>
</div>

<?php foreach($producto['Imagen'] as $i=>$imagen)
  echo $image->resize('productos/'.$imagen['archivo'], 300, 300, true, array('id'=>"el_archivo_$i", 'style'=>'display: none;')); ?>
<script type="text/javascript">
  imagenesDelProducto = new Array();
  imagenEnDetalles = 0;
<?php foreach ($producto['Imagen'] as $i=>$imagen) { ?>
	imagenesDelProducto.push($("el_archivo_<?php echo $i; ?>").src);
<?php } ?>
	setImage();
</script>

<?php if (count($producto['Imagen']) > 1) {?>
<div id="imagen_anterior" onclick="prevImage();"><button>&nbsp;</button></div>

<div id="imagen_siguiente" onclick="nextImage();"><button>&nbsp;</button></div>
<?php } ?>

<div id="informacion_principal">
 	<div class="right" style="font-size: 200%;">unidad $<?php echo sprintf("%.2f",$producto['Producto']['precio_1']); ?></div>
 	En <?php foreach($producto['Categoria'] as $categoria) echo $html->link('<u>'.$categoria['nombre'].'</u>', '#', array('onclick'=>'loadProducts('.$categoria['id'].', "'.$categoria['nombre'].'"); return false;'), null, false).'|'; ?><br/>
 	<b style="font-size: 150%;"><?php echo $producto['Producto']['nombre']; ?></b> <?php echo $producto['Producto']['clave']?'('.$producto['Producto']['clave'].')':null; ?> 
 	
 	<div class="clear"></div>
 	<div class="right" style="font-size:200%">1000u $<?php echo sprintf("%.2f",$producto['Producto']['precio_1000']); ?></div>
<?php if($producto['Producto']['archivo_specs']) { ?>
  Archivo de <u><?php echo $html->link($html->image('iconos/page_save.png').' Especificaciones', '/files/specs/'.$producto['Producto']['archivo_specs'], array(), false, false); ?></u>
<?php } ?>
  <div class="clear"></div>
  <p>
    <?php echo nl2br($producto['Producto']['descripcion']); ?><br/>
  </p>
</div>