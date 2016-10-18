<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title>LedTec | Categorías</title>
    <link>http://ledtec.com.mx/</link>
    <description>Categorías de productos en LedTec: Iluminación con LEDs (México)</description>
    <language>es-mx</language>
    <pubDate><?php echo date("D, j M Y H:i:s", gmmktime()).' GMT';?></pubDate>
    <?php echo $time->nice($time->gmt()).' GMT'; ?>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>LedTec (powered by cakephp.org)</generator>
    <managingEditor>contacto@ledtec.com.mx</managingEditor>
    <webMaster>webmaster@ledtec.com.mx</webMaster>
<?php foreach ($categorias as $categoria) { ?>
    <item>
      <title><?php echo $categoria['Categoria']['nombre']; ?></title>
      <link><?php echo FULL_BASE_URL.'/cat/'.$categoria['Categoria']['id']; ?></link>
      <description></description>
      <author>Orpinel Electronics</author>
      <category></category>
      <pubDate></pubDate>
      <source url="<?php echo $this->here; ?>">LedTec | Categorias</source>
    </item>
<?php } ?>
  </channel>
</rss>