<div id="contacto_cabeza" style="height: 61px; background: url('/img/ledtec/fondo_ventana.jpg') repeat-x; margin-bottom: 15px;">
	<?php echo $html->image('ledtec/mini-header.jpg'); ?> 
</div>

<form id="mensaje" action="" method="post" onsubmit="return false;">
	<div class="campo">
		<?php echo $form->input('Contacto/nombre'); ?> 
	</div>
	
	<div class="campo">
		<?php echo $form->input('Contacto/empresa'); ?> 
	</div>
	
	<div class="campo">
		<?php echo $form->input('Contacto/email'); ?> 
	</div>
	
	<div class="campo">
		<label for="ContactoMensaje">Mensaje</label>
  	<button type="button" id="enviar_mensaje" onclick="mensaje();"></button>
		<div id="enviando_mensaje" class="center right" style="display: none; width: 118px; height: 121px; margin: 82px 15px 0 0;">
			<b style="font-size: 150%;">enviando</b><br/>
			<?php echo $html->image('loading.gif'); ?>
		</div>
  	
		<?php echo $form->textarea('Contacto/mensaje'); ?> 
	</div>
</form>