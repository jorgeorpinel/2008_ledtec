<h1 class="center" style="font-size: 24px; height: 61px; line-height: 61px; background: url('/img/ledtec/fondo_ventana.jpg') repeat-x; margin-bottom: 15px;"><?php echo $titulo; ?></h1>

<?php echo $form->error('Categoria/data', 'Hubieron los siguientes errores en los datos:'); ?>

<form id="edit_cat" action="" method="post" onsubmit="return false;">
	<div class="campo requerido">
		<sub class="right">*Requerido</sub>
		<?php echo $form->input('Categoria/nombre'); ?> 
	</div> 
	
	<div class="campo">
		<label for="CategoriaCatSuperiorId">En</label>
		<?php echo $form->select('Categoria/cat_superior_id', $categorias, !empty($this->data['Padre']['id'])?$this->data['Padre']['id']:''); ?><br/>
	</div> 
	
	<button id="guardar" onclick="editCat('<?php echo isset($this->data['Categoria']['id'])?$this->data['Categoria']['id']:''; ?>', true);">Guardar</button>
	<div id="guardando" style="display: none;">Guardando ...<br/><?php echo $html->image('loading.gif'); ?></div>
</form>