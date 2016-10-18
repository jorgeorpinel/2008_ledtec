<script type="text/javascript">
	catId = <?php echo $catSelected; ?>;
</script>

<div id="catsLoading" class="loading" style="display:none;">
	Actualizando <b id="prodsLoading_nombre"></b>...<br/>
	<?php echo $html->image('loading.gif'); ?>
</div>

<div style="position: absolute; top: 0; right: 0; height: 38px; width: 3px; background: #a9bee3; border-bottom: 1px solid #000;"></div>
<div id="titulo">
	<div class="right" style="margin-right: 5px;">
		<?php echo $html->link('RSS '.$html->image('iconos/feed.png'), 'http://www.addthis.com/feed.php?pub=jopaddthiscom&h1='.urlencode('http://feeds.feedburner.com/ledteccategoras').'&t1', array('style'=>'font-size: 130%; font-style: normal;', 'title'=>'Suscríbete con cualquier lector RSS.', 'target'=>'_blank'), null, false); ?>
	</div>
  Categorías
</div>

<?php if ($session->check('adminId')) { ?>
<div class="admin_new" onclick="newCat();"><?php echo $html->image('iconos/add.png'); ?> Nueva Categoría</div>

<?php }
foreach ($categorias as $categoria) { ?>
<div>
<?php
  if ($session->check('adminId')) { ?>
	<div class="accion_admin" style="position: relative; top: -10px; margin-right: 5px;" onclick="delCat(<?php echo $categoria['Categoria']['id']; ?>);"><?php echo $html->image('iconos/delete.png'); ?></div>
	<div class="accion_admin" style="position: relative; top: -10px;" onclick="editCat(<?php echo $categoria['Categoria']['id']; ?>);"><?php echo $html->image('iconos/pencil.png'); ?></div>
<?php
  } ?>
	<h1 id="categoria_<?php echo $categoria['Categoria']['id']; ?>"<?php echo $categoria['Categoria']['id']==$catSelected?' class="selected"':null; ?> onclick="loadProducts(<?php echo $categoria['Categoria']['id']; ?>, '<?php echo $categoria['Categoria']['nombre']; ?>');">
		<?php echo $categoria['Categoria']['nombre']; ?>
	</h1>
</div>

<div id="subcategorias_<?php echo $categoria['Categoria']['id']; ?>" class="subcategorias"><ul>
<?php
  foreach ($categoria['Subcategoria'] as $subcategoria) { ?>
  <li id="categoria_<?php echo $subcategoria['id']; ?>"<?php echo $subcategoria['id']==$catSelected?' class="selected"':null; ?>>
<?php if ($session->check('adminId')) { ?>
		<div class="accion_admin" onclick="delCat(<?php echo $subcategoria['id']; ?>);"><?php echo $html->image('iconos/delete.png'); ?></div>
		<div class="accion_admin" onclick="editCat(<?php echo $subcategoria['id']; ?>);"><?php echo $html->image('iconos/pencil.png'); ?></div>
<?php } ?>
  	<div class="txt" onclick="loadProducts(<?php echo $subcategoria['id']; ?>, '<?php echo $subcategoria['nombre']; ?>');">
  		<?php echo $subcategoria['nombre']; ?>
  	</div>
  </li>
<?
  } ?>
</ul></div>
<?
} ?>