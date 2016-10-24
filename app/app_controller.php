<?php
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.cake
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 4410 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-02-02 07:31:21 -0600 (Fri, 02 Feb 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		cake
 * @subpackage	cake.cake
 */
class AppController extends Controller {
  var $helpers = array('Javascript', 'Html', 'Form', 'Image', 'Text');
  
  function beforeFilter() {
    // Controla acceso a funciones por ajax:
    if (ereg('^ajax', $this->action) && !(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest")) {
      $this->redirect('/');
      return;
    }
    
    // Controla el acceso a funciones privadas administrativas:
    $soloAdmin = array(
      '/admin/',
      '/productos/ajaxEditarCat',
      '/productos/ajaxEditarFotos'
    );
    
    foreach ($soloAdmin as $ruta)
      if (ereg('^'.$ruta, $this->here) && !$this->Session->check('adminId')) {
        $this->redirect('/');
        return;
      }
  }
  
  function beforeRender() {
    // Ignora todo si ya se determinó un layout:
    if (in_array($this->layout, array('admin', 'ajax', 'xml', 'iframe'))) return;
    
    if (ereg('^ajax', $this->action)) {
      Configure::write('debug', 1);
      $this->layout = 'ajax';
    } else $this->layout = 'ledtec';
  }
  
  
  // Protegidas:
  
  /**
   * Envia email con función mail() usando el rendering de cake.
   *
   * @param unknown_type $to			dirección de email destino
   * @param unknown_type $titulo	título del email
   * @param unknown_type $view		vista de cake que se va a enviar
   */
  function _emailRender($to, $titulo, $view) {
    $layout = $this->layout;
		$this->layout = 'email';
		ob_start();
		$this->render('email/'.$view);
		$contenido = ob_get_contents();
		ob_end_clean();
		$this->layout = $layout;
		
		$headers = "MIME-Version: 1.0\r\n".
		           "Content-type: text/html; charset=utf-8\r\n".
		           "From: no-responder@ledtec.com.mx\r\n".
		           "Reply-To: no-responder@ledtec.com.mx\r\n";
		
		if (mail($to, $titulo, $contenido, $headers))
		  return $contenido;
		else return false;
  }
  
  /**
   * Limpia un texto para que sea seguro al utilizarse como html o SQL
   *
   * @param unknown_type $texto
   * @param unknown_type $tipo
   * @return unknown
   */
  function _preparaTexto($texto, $para=null) {
    uses('sanitize');
    $limpiador = new Sanitize();
    
    // Limpia XSS:
    if ($para === 'sql') $texto = $limpiador->escape($texto);
    elseif ($para === 'html') $texto = $limpiador->html($texto);
    else $texto = $limpiador->paranoid($texto);
    
    return trim($limpiador->stripWhitespace($texto));  // Quita espacios inútiles
  }
  
  /** Sube archivo al servidor:
   *
   * @param unknown_type $archivo
   * @param unknown_type $destino
   * @param unknown_type $validMimeTypes
   * @return unknown
   */
  function _subeArchivo($archivo, $destino, $validMimeTypes = null) {    
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