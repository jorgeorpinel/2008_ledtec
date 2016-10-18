<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title>LedTec | <?php echo $_SESSION['Cat']['nom']; ?> | Productos</title>
    <link>http://ledtec.com.mx/</link>
    <description>Todos los productos en la categoría "<?php echo $_SESSION['Cat']['nom']; ?>" de LedTec: Iluminación con LEDs (México)</description>
    <language>es-mx</language>
    <pubDate><?php echo date("D, j M Y H:i:s", gmmktime()).' GMT';?></pubDate>
    <?php echo $time->nice($time->gmt())." GMT\n"; ?>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>LedTec (powered by cakephp.org)</generator>
    <managingEditor>contacto@ledtec.com.mx</managingEditor>
    <webMaster>webmaster@ledtec.com.mx</webMaster>
<?php foreach ($productos as $producto) { ?>
    <item>
      <title><?php echo $producto['nombre']; ?></title>
      <link><?php echo FULL_BASE_URL.'/prod/'.$producto['id']; ?></link>
      <description><?php echo $producto['descripcion']; ?></description>
      <author>Orpinel Electronics</author>
      <category><?php $_SESSION['Cat']['nom']; ?></category>
      <enclosure url="<?php echo '/img/productos/'.$producto['Imagen'][$producto['imagen_principal']]['archivo']; ?>" length="<?php echo filesize(IMAGES.'productos'.DS.$producto['Imagen'][$producto['imagen_principal']]['archivo']); ?>" type="<?php echo 'image/jpeg';// XXX mime_content_type(IMAGES.'productos'.DS.$producto['Imagen'][$producto['imagen_principal']]['archivo']); ?>"/>
      <?php if (!empty($producto['modified'])) echo 'actualizado el '.date('d \d\e M \d\e\l Y \a \l\a\s H:i', strtotime($producto['modified']))."\n"; ?>
      <pubDate><?php echo $time->nice($time->gmt($producto['created'])).' GMT'; ?></pubDate>
      <?php echo empty($producto['clave'])?null:'<guid>'.$producto['clave']."</guid>\n"; ?>
      <source url="<?php echo $this->here; ?>">LedTec | Productos en <?php echo $_SESSION['Cat']['nom']; ?></source>
    </item>
<?php } ?>
  </channel>
</rss>