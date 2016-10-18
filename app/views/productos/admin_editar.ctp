<h1 class="center" style="font-size: 24px; height: 61px; line-height: 61px; background: url('/img/ledtec/fondo_ventana.jpg') repeat-x; margin-bottom: 15px;"><?php echo $titulo; ?></h1>

<?php echo $form->error('Producto/data', 'Hubieron los siguientes errores en los datos:'); ?>

<form id="edit_prod" action="<?php echo $this->here; ?>" method="post" enctype="multipart/form-data" target="editar_iframe">
	<div class="campo requerido">
		<sub class="right">*Requerido</sub>
		<?php echo $form->input('Producto/nombre'); ?> 
	</div>
	
	<div class="campo requerido">
		<sub class="right">*Requerido</sub>
		<?php echo $form->input('Producto/precio_1000', array('label'=>'p. 1000u. $')); ?> 
	</div>
	
	<div class="campo requerido">
		<sub class="right">*Requerido</sub>
<?php if (!empty($this->data['Imagen'][$this->data['Producto']['imagen_principal']]['archivo'])) { ?>
		Imagen principal actual: <?php echo $image->resize('productos/'.$this->data['Imagen'][$this->data['Producto']['imagen_principal']]['archivo'], 50, 50, true, array('style'=>'border: 1px solid #666; margin:1px;')); ?>
		<div class="accion_admin" style="margin-right: 5px;" onclick="editPhotos(<?php echo $_SESSION['Prod']['id']; ?>);">Editar las fotos <?php echo $html->image('iconos/picture_edit.png'); ?></div><br/>
		<label for="ProductoImagenPrincipal">Cambiar:</label>
<?php } else { ?>
		<label for="ProductoImagenPrincipal" style="width: auto;">Imagen Principal</label>
<?php } ?>
		<?php echo $form->file('Producto/imagen_principal'); ?> 
  	<?php echo $form->error('Producto/imagen_principal'); ?> 
  	<?php echo $form->error('Producto/data', 'Si había escogido un archivo debe volver a hacerlo.'); ?> 
	</div>
	
	<div class="campo requerido">
		<div class="right" style="width: 40%; font-weight: normal;">
			<sub class="right" style="font-weight: bold;">*Requerido</sub><br/><br/>
			NOTA: Con la tecla <i>Ctrl</i> se puede elegir <b>más de una</b> categoría.<br/><br/>
			<u>No es necesario</u> listar un producto en categorías superiores a una a la que ya pertenece (para que aparezca en las primeras).
		</div>
		<label for="CategoriaCategoria">En</label>
		<?php echo $form->select('Categoria/Categoria', $categorias, isset($catsDelProd)?$catsDelProd:null, array('multiple' => 'multiple')); ?> 
	</div>
	
	<div class="campo">
		<?php echo $form->input('Producto/precio_1', array('label'=>'p. unidad $')); ?> 
	</div>
	
	<div class="campo">
		<?php echo $form->input('Producto/clave'); ?> 
	</div>
	
	<div class="campo">
		<label for="CategoriaCatSuperiorId">Descripción</label>
		<?php echo $form->textarea('Producto/descripcion', array('value'=>!empty($this->data['Producto']['descripcion'])?$this->data['Producto']['descripcion']:null)); ?> 
	</div> 
	
	<div class="campo">
<?php if (!empty($this->data['Producto']['archivo_specs'])) { ?>
		Archivo de especificaciones actual: <?php echo $html->link('<u>'.$html->image('iconos/page_save.png').' abrir / bajar</u>', '/files/specs/'.$this->data['Producto']['archivo_specs'], array(), null, false); ?><br/>
		<label for="CategoriaCatSuperiorId">Cambiar:</label>
<?php } elseif (isset($this->data['Producto'])) { ?>
		Sin archivo de especificaciones actualmente.<br/>
		<label for="CategoriaCatSuperiorId">Elegir uno:</label>
<?php } else { ?>
		<label for="CategoriaCatSuperiorId" style="width: auto;">Archivo de Especificaciones</label>
<?php } ?>
		<?php echo $form->file('Producto/archivo_specs'); ?> 
  	<?php echo $form->error('Producto/archivo_specs'); ?> 
  	<?php echo $form->error('Producto/data', 'Si había escogido un archivo debe volver a hacerlo.'); ?> 
	</div> 
	
	<button type="sumbit" id="guardar" onclick="$('guardando').show(); $('guardar').hide();">Guardar</button>
	<div id="guardando" style="display: none;">Guardando ...<br/><?php echo $html->image('loading.gif'); ?></div>
</form>