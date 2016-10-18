<?php
/**
 * Clase AdministradoresController
 *
 * @copyright	(c) 2007 LedTec
 * @link			www.ledtec.com.mx
 */

/**
 * Controlador de administradores
 *
 * @author Jorge Orpinel
 */
class AdministradoresController extends AppController
{
  var $name = 'Administradores';
  var $uses = array('Administrador');
  var $components = array('Authentification');
  
  
  // Autentificación:
	
	function login() {
//pr($_SESSION);
	  $this->layout = 'admin';
	  
	  if (empty($this->data))
	  {
	    $this->render();
	    return;
	  }
	  
	  // Prepara texto de user y pass:
	  if (isset($this->data['Usuario']['email']))
	    $this->data['Administrador']['email'] = $this->_preparaTexto($this->data['Administrador']['email'], 'sql');
	  if (isset($this->data['Administrador']['contrasena']))
	    $this->data['Administrador']['contrasena'] = $this->_preparaTexto($this->data['Administrador']['contrasena'], 'sql');
	  
	  $options = array(  // Authentification component options
			'userModelPtr' => &$this->Administrador,
			'username' => 'email',
			'password' => 'contrasena',
			'encoding' => 'md5',
			'avoidReturn' => true,
			'failed' => array(
				'invalidate' => 'data',
				'renderView' => true
			),
			'succeded' => array(
			  'postLogin' => '_postLogin'
			),
			'sessionVar' => 'adminId'
		);
		$this->Authentification->login($options);
	}
	function _postLogin() {  // XXX No hace na'.
//		$adminId = $this->Session->read('adminId');
//		$usuario = $this->Administrador->findById($adminId, 'email', null, -1);
//		$this->Session->write('email', $usuario['Administrador']['email']);
	}
	
	function logout() {
	  if ($this->Session->check('adminId'))
	  {
		  $options = array(
		    'avoidReturn' => true
		  );
		  $this->Authentification->logout($options);
	  }
	  else $this->redirect('/');
	}
  
  
}
?>
