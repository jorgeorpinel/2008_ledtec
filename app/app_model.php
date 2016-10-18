<?php
/**
 * Clase AppController
 *
 * @copyright	Copyright (c) 2007 Club Bonsái Bunjín
 * @link			http://clubbonsaibunjin.com
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package		cake
 * @subpackage	cake.cake
 */
class AppModel extends Model
{
  /**
   * Busca por palabras clave.
   *
   * @param string/array					$palabrasClave Palabras clave que se buscan.
   * @param string/array	$camposBuscados Campos en donde se buscará.
   * @return array				Resultados en formato de búsqueda de cakephp
   * 
   * @author Jorge Orpinel
   */
  function buscarPalabrasClave($palabrasClave, $camposBuscados,
    $campos = null,
    $orden = null,
    $limite = null,
    $pagina = 1,
    $recursividad = 0)
  {
    
    $condiciones = array();
    $condicion;
    
    // Formato de los parámetros:
    if (!is_array($camposBuscados)) $camposBuscados = explode(',', $camposBuscados);
    if (!is_array($palabrasClave)) $palabrasClave = explode(',', $palabrasClave);

    // Forma las condiciones de la búsqueda:
    foreach ($camposBuscados as $campo) {$campo = trim($campo);
      $condicion = array();
      
      foreach ($palabrasClave as $palabra)
        $condicion[] = "$this->name.$campo LIKE '%$palabra%'";
      
      $condiciones[] = implode(" OR\n", $condicion);
    }

    $condiciones = implode("\nOR\n\n", $condiciones);
    return $this->findAll($condiciones, $campos, $orden, $limite, $pagina, $recursividad);
  }
  
  /**
   * Busca por índidces de texto completo.
   *
   * @param unknown_type $camposBuscados	cadena de texto con los campos a buscar separados por comas.
   * @param unknown_type $cadena					cadena de texto que se buscará
   * @return															arreglo con los resultados en formato de cake
   * 
   * @author Jorge Orpinel
   */
  function fullTextMatch($camposBuscados, $cadena, $relevancia = false,
    $campos = null,
    $orden = null,
    $limite = null,
    $pagina = 1,
    $recursividad = 0)
  {  // TODO cambiar las variables ft de mysql para mejorar:
    $registros = $this->query(
      "SELECT `id`".($relevancia?", MATCH($camposBuscados) AGAINST ('$cadena') AS relevancia":null).' '.
      "FROM $this->useTable AS $this->name ".
      "WHERE MATCH($camposBuscados) AGAINST ('$cadena' IN BOOLEAN MODE)".
      ($relevancia?' ORDER BY relevancia DESC':NULL).';');
    
    $ids = array();
    $relevancias = array();
    foreach ($registros as $registro) {
      $ids[] = $registro[$this->name]['id'];
      if($relevancia) $relevancias[$registro[$this->name]['id']] = $registro[0]['relevancia'];
    }
    
    $resultados = array();
    foreach ($ids as $id)
	    $resultados[] = $this->findById($id, $campos, $orden, $recursividad);
    
    if ($relevancia)
	    foreach ($resultados as $r=>$resultado)
	      $resultados[$r]['relevancia'] = $relevancias[$resultado[$this->name]['id']];
	     
	  return $resultados;
  }
  
  /** Sube archivo al servidor:
   *
   * @param unknown_type $archivo
   * @param unknown_type $destino
   * @param unknown_type $validMimeTypes
   * @return unknown
   */
  function _subeArchivo($archivo, $destino, $validMimeTypes=null) {    
    // Maneja errores de la subida del archivo:
    $uploadError = $this->__errorDeSubida($archivo['error']);
    if ($uploadError['error']) return $uploadError;
    
    // Verifica el tipo de archivo:
    if ($validMimeTypes == 'imagenes')
		  $validMimeTypes = array(
		   'image/bmp',
		   'image/fif',
		   'image/gif',
		   'image/ief',
		   'image/jpeg',
		   'image/pjpeg',  // XX Maldito IE
		   'image/png',
		   'image/tiff'
      );
    if (!empty($validMimeTypes))
      if(!in_array(strtolower($archivo['type']), $validMimeTypes))
        return array('error'=>true, 'mensage'=>'El tipo de archivo no es aceptable.');
    
    // Genera el nuevo nombre de archivo:
    $extension = explode('.', $archivo['name']);
    $archivoNuevo  = md5(microtime()).".".(isset($extension[1])?$extension[1]:$extension[0]);
    
    // Mueve el archivo:
    if (!move_uploaded_file($archivo['tmp_name'], $destino.$archivoNuevo))
      return array('error'=>true, 'mensage'=>'No se pudo subir el archivo. Por favor reintenta.');
    return array('error'=>false, 'archivo'=>$archivoNuevo);
  }
  function __errorDeSubida($error) {
    switch($error) {
    case UPLOAD_ERR_OK:
      return array('error'=>false);
      break;
    case UPLOAD_ERR_INI_SIZE:
      return array('error'=>true, 'mensage'=>"El tamaño del archivo excede el limite de ".ini_get("upload_max_filesize")." bytes.");
      break;
    case UPLOAD_ERR_FORM_SIZE:
      return array('error'=>true, 'mensage'=>"El tamaño del archivo excede el límite permitido.");
      break;
    case UPLOAD_ERR_PARTIAL:
      return array('error'=>true, 'mensage'=>"Se interrumpió la subida del archivo inesperadamente. Por favor reintenta.");
      break;
    case UPLOAD_ERR_NO_FILE:
      return array('error'=>true, 'mensage'=>"No se seleccionó ningún archivo.");
      break;
    case UPLOAD_ERR_NO_TMP_DIR:
    case UPLOAD_ERR_CANT_WRITE:
    case UPLOAD_ERR_EXTENSION:
      return array('error'=>true, 'mensage'=>"Hubo un error al subir el archivo. Por el momento el sistema no puede aceptar archivos.");
      break;
    default:
      return array('error'=>true, 'mensage'=>"Hubo un error desconodico al subir el archivo. Si persiste por favor contacte al webmaster.");
      break;
    }
  }
}
?>
