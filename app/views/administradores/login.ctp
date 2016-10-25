<h1 style="text-align: center; background: #a9bee3; border-bottom: 1px solid #666; margin-bottom: 1em;">LOGIN</h1>

<?php echo $form->error('Administrador/data', 'Los datos son incorrectos.'); ?>

<form action="<?php echo $html->url('/administradores/login'); ?>" method="post">
	<?php echo $form->input('Administrador/email'); ?> 
	
	<div class="input">
		<label for="AdministradorContrasena">Contraseña</label>
		<?php echo $form->password('Administrador/contrasena'); ?> 
	</div>
	
	<button type="submit">Autentificar</button>
</form>