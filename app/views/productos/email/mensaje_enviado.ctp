<pre>Nuevo mensaje recibido de <?php
  echo '"<b>'.$data['Contacto']['nombre'].
  '</b>" &lt;<a href="mailto:'.$data['Contacto']['email'].'">'.
  $data['Contacto']['email'].'</a>&gt;'.
  (empty($data['Contacto']['empresa'])?null:' (empresa <b>'.$data['Contacto']['empresa'].'</b>)'); ?>:

- <i><?php echo $data['Contacto']['mensaje']; ?></i>

Email automatizado</pre>