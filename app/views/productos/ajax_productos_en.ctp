<script type="text/javascript">
	prodId = <?php echo $prodSelected; ?>;
	paginaActual = 1;
</script>

<div id="prodsLoading" class="loading" style="display:none;">
	Cargando <b id="prodsLoading_nombre"></b>...<br/>
	<?php echo $html->image('loading.gif'); ?>
</div>

<h1>
	<div class="right" style="margin-right: 5px;">
	<?php echo $html->link('RSS '.$html->image('iconos/feed.png'), 'http://www.addthis.com/feed.php?pub=jopaddthiscom&h1='.urlencode(FULL_BASE_URL.'/rss/'.$_SESSION['Cat']['id']).'&t1', array('style'=>'font-size: 130%; font-style: normal;', 'title'=>'Suscríbete con cualquier lector RSS.', 'target'=>'_blank'), null, false); ?>
	</div>
  <?php echo $_SESSION['Cat']['nom']; ?>
</h1>

<?php if ($session->check('adminId')) { ?>
<div class="admin_new" onclick="newProd();"><?php echo $html->image('iconos/add.png'); ?> Nuevo Producto</div>

<?php }
$i = 0;
$paginas = 0;
$maxPaginas = 4;
$countProds = count($productos);
if ($countProds > 35) $maxPaginas = ceil($countProds/5);
foreach ($productos as $producto) {
  if ($i%$maxPaginas == 0) { ?>
<div id="pagina_<?php echo (ceil($i/$maxPaginas)) + 1; ?>" class="productos scroll"<?php if ($i) { ?> style="display: none;"<?php } ?>>
<?php
  } if ($session->check('adminId')) { ?>
	<div class="accion_admin" onclick="delProd(<?php echo $producto['id']; ?>);"><?php echo $html->image('iconos/delete.png'); ?></div>
	<div class="accion_admin" onclick="editProd(<?php echo $producto['id']; ?>);"><?php echo $html->image('iconos/pencil.png'); ?></div>
<?php
  } ?>
  <div id="prod_<?php echo $producto['id']; ?>" class="producto<?php if (isset($prodSelected) && $producto['id']===$prodSelected) echo ' selected'; ?>" onclick="loadProduct(<?php echo $producto['id']; ?>, '<?php echo $producto['nombre']; ?>');">
    <div id="la_imagen_<?php echo $producto['id']; ?>" class="producto_imagen"></div>
    <?php
      // TODO Figure out producto.imagen_principal
      if( !isset($producto['imagen_principal']) )
        $imagen_principal =  'default.png';
      else
        $imagen_principal = isset($producto['Imagen'][$imagen_principal]['archivo']) ? 'productos/'.$producto['Imagen'][$imagen_principal]['archivo'] : 'default.png';
      echo $image->resize($imagen_principal, 50, 50, true, array('id'=>'el_archivo_'.$producto['id'], 'style'=>'display: none;'));
    ?>
		<script type="text/javascript">
		  $('la_imagen_<?php echo $producto['id']; ?>').style.background = '#fff url('+$('el_archivo_<?php echo $producto['id']; ?>').src+') center no-repeat';
		</script>
    <div class="producto_descripcion">
    	<p>
    		<b><?php echo $producto['nombre']; ?></b><br/>
    		<?php echo $text->truncate($producto['descripcion'], 100, '...', false); ?>
    	</p>
    </div>
    <div style="clear: both; margin-bottom: 5px;"></div>
  </div>
  <div class="producto_barra"><div class="clear"></div></div>
<?php
  if ((++$i)%$maxPaginas==0 || $i==$countProds) { $paginas++; ?>
</div>

<?php
  }
} ?>

<div id="productos_coneccion">
	<center><div id="img_connect"></div></center>
  <div id="productos_ver_mas">
<?php if ($paginas<2) { ?>
		LedTec
<?php return;} ?>
    Más ....
    <a href="#" onclick="cambiarAPagina(paginaActual-1); return false;">&lt;&lt;</a>
<?php for ($j=1; $j<=$paginas; $j++) { ?>
    <a href="#" onclick="cambiarAPagina(<?php echo $j; ?>); return false;"><?php echo $j; ?></a>
<?php } ?>
    <a href="#" onclick="cambiarAPagina(paginaActual+1); return false;">&gt;&gt;</a>
  </div>
</div>
