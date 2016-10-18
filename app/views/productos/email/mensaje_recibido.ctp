<pre>Estimado <?php echo '<b>'.$data['Contacto']['nombre'].'</b>'.empty($data['Contacto']['empresa'])?null:' de <b>'.$data['Contacto']['empresa'].'</b>'; ?>:

Tu mensaje:

"<?php echo $data['Contacto']['mensaje']; ?>"

ha sido enviado a el area de contacto de LedTec &lt;contacto@ledtec.com.mx&gt;

Este email es automatizado, por favor no lo contestes. Pronto serás contactado por el equipo de LedTec

Gracias.</pre>