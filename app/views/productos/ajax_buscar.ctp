<h1 class="dbl_fnt center" style="background: #7faddc;">RESULTADOS</h1>

<div class="left" style="width: 40%;">
	<h2 class="dbl_fnt">Categorías</h2>
	
<?php if (count($categorias)>0) foreach($categorias as $categoria) { ?>
	<div id="categoria_<?php echo $categoria['Categoria']['id']; ?>" class="producto" onclick="loadProducts(<?php echo $categoria['Categoria']['id']; ?>, '<?php echo $categoria['Categoria']['nombre']; ?>'); esconderVentana();">
		<div class="producto_descripcion"><p class="dbl_fnt bold" style="color: #000;"><?php echo $categoria['Categoria']['nombre']; ?></p></div>
	</div>
<?php } else { ?>
	<center style="margin-top: 1em; font-size: 150%;">Sin resultados</center>
<?php } ?>
</div>

<div class="right" style="width: 50%; margin-right: 1%;">
	<h2 class="dbl_fnt">Productos</h2>

<?php if (count($productos)>0) foreach($productos as $producto) { ?>
	<div class="producto" onclick="loadProduct(<?php echo $producto['Producto']['id']; ?>, '<?php echo $producto['Producto']['nombre']; ?>'); esconderVentana();">
    <div id="la_imagen_<?php echo $producto['Producto']['id']; ?>" class="producto_imagen"></div>
		<?php echo $image->resize('productos/'.$producto['Imagen'][$producto['Producto']['imagen_principal']]['archivo'], 50, 50, true, array('id'=>'el_archivo_'.$producto['Producto']['id'], 'style'=>'display: none;')); ?>
		<script type="text/javascript">
		  $('la_imagen_<?php echo $producto['Producto']['id']; ?>').style.background = '#fff url('+$('el_archivo_<?php echo $producto['Producto']['id']; ?>').src+') center no-repeat';
		</script>
    <div class="producto_descripcion" style="color: #000;">
    	<p>
    		<b><?php echo $producto['Producto']['nombre']; ?></b><br/>
    		<?php echo $text->truncate($producto['Producto']['descripcion'], 100, '...', false); ?>
    	</p>
    </div>
    <div style="clear: both; margin-bottom: 5px;"></div>
  </div>
  <div class="clear"></div>
<?php } else { ?>
	<center style="margin-top: 1em; font-size: 150%;">Sin resultados</center>
<?php } ?>
</div>