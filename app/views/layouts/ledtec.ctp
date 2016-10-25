<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $title_for_layout!='Productos'?$title_for_layout.' | ':null; ?>LedTec (México) - Iluminación con LEDs</title>
  <link rel="icon" href="<?php echo $this->webroot.'favicon.ico'; ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo $this->webroot.'favicon.ico'; ?>" type="image/x-icon" />
  <?php echo $html->css('ledtec'); ?>
  <?php echo $javascript->link('lib/prototype'); ?>
  <?php // echo $javascript->link('src/scriptaculous.js?load=effects'); // XXX Are we really using this? ?>
  <?php echo $javascript->link('ledtec'); ?>
  <?php echo $javascript->link('http://s9.addthis.com/js/widget.php?v=10'); ?>
  <!-- <script src="http://web.chat4support.com/Weboperator/Operator/banner.aspx?sid=1790&sTag=LEDTEC&style=1&online=1&nFloat=1&nInvite=1&nMode=0&nPos=4"></script> -->
</head>
<body><div id="aplicacion">
<?php if ($session->check('adminId')) { ?>
  <div style="position: absolute; top: 0; left: 0; background: #fe6;">
    <b style="font-size: 130%;">Administración |</b>
    <u><?php echo $html->link('logout', '/logout'); ?></u> <b>|</b>
    <?php echo $html->image('iconos/pencil.png'); ?>=editar
    <?php echo $html->image('iconos/delete.png'); ?>=borrar
  </div>

<?php } ?>
  <div id="ventana_contacto" style="display: none;" onclick="esconderVentana();">
    <div id="ventana_cargando" class="center">
      <b style="font-size: 200%;">cargando</b><br/>
      <?php echo $html->image('loading.gif'); ?>
    </div>
  </div>
  <div id="div_cerrar" style="display: none;">
    <div id="boton_cerrar" onclick="esconderVentana();"></div>
  </div>
  <div id="ventana_contenido" style="display: none;">
  </div>

  <div id="noajax" style="position:absolute;top:0;width:100%;height:100%;font-size:200%;text-align:center;background:#fee;display:none;">
    No puedes ver la página con este navegador porque no acepta Javascript o usa una versión muy vieja.
  </div>
  <script type="text/javascript"><!--
    // TODO Checa tener JavaScript y Ajax:
    if(0) $('noajax').show();
  --></script>



  <div id="cabecera">

    <div style="position:absolute; top:50px; left:200px;">
      This is a <b>demo</b>.
      Project code can be seen in
      <b><a href="https://github.com/jorgeorpinel/2008_ledtec">this GirHub repo</a></b>
    </div>

    <div id="logo">
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="400" height="110" id="prueba" align="middle">
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="movie" value="/files/logo.swf" />
        <param name="quality" value="best" />
        <param name="wmode" value="transparent" />
        <param name="bgcolor" value="#99cc99" />
        <embed src="/files/logo.swf" quality="best" wmode="transparent" bgcolor="#99cc99" width="400" height="110" name="prueba" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
    </div>

    <div id="busqueda_rapida"><form action="" method="post" onsubmit="return false;">
      <button type="button" id="boton_buscar" class="right no_border" onclick="buscar();"></button>
      <input name="data[Busqueda][texto]" />
      <div id="barra_buscar"></div>
    </form></div>

  <!-- <div id="live_chat" class="accion_admin">
    <a target="_blank" href="http://srv.chat4support.com/main.asp?sid=1790&sTag=LEDTEC&style=1">
      <img src="http://web.chat4support.com/Weboperator/BtnImage.aspx?sid=1790&sTag=LEDTEC&style=1" border="0" />
    </a>
  </div> -->

  </div>






  <div id="catalogo">

    <div id="categorias" class="area">
<!-- Ajax: productosEn -->
      <div id="catsLoading" style="text-align:center;background:#fff;display:none;">
        Cargando categorías...<br/>
        <?php echo $html->image('loading.gif'); ?>
      </div>
    </div>



    <div id="elementos" class="area">
      <input id="categoriaId" type="hidden" value="<?php echo isset($_SESSION['Cat']['id'])?$_SESSION['Cat']['id']:0;?>" />
<!-- Ajax: productosEn -->
      <div id="prodsLoading" style="text-align:center;background:#fff;display:none;">
        Cargando <b><?php echo $_SESSION['Cat']['nom']; ?></b>...<br/>
        <?php echo $html->image('loading.gif'); ?>
      </div>
    </div>



    <div id="detalles" class="area">
      <input id="productoId" type="hidden" value="<?php echo isset($_SESSION['Prod']['id'])?$_SESSION['Prod']['id']:0;?>" />
<!-- Ajax: productosEn -->
      <div id="prodLoading" style="text-align:center;background:#fff;display:none;">
        Cargando <b><?php echo $_SESSION['Prod']['nom']; ?></b>...<br/>
        <?php echo $html->image('loading.gif'); ?>
      </div>
    </div>

  </div>






  <!-- contacto -->
<?php echo $content_for_layout; ?>
  <!-- /contacto -->

  <script id="last" type="text/javascript"><!--
  init();	// Avisa que ya se cargó todo el DOM 'body'.
  // --></script>
  <noscript>
    <div style="position:absolute;top:0;width:100%;height:100%;font-size:200%;text-align:center;background:#fee;">
      No puedes ver la página con este navegador porque no acepta Javascript.
    </div>
  </noscript>
</div></body></html>
