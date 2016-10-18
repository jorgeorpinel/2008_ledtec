<?php
/**
 * @version jop 1.1
 * @author Jorge Orpinel modifications | modificaciones
 */
class ImageHelper extends Helper
{
  var $helpers = array('Html');
  var $cacheDir = 'imagecache'; // relative to 'img'.DS

  /**
   * Automatically resizes an image and returns formatted IMG tag
   *
   * @param string $path Path to the image file, relative to the webroot/img/ directory.
   * @param integer $width Image of returned image
   * @param integer $height Height of returned image
   * @param boolean $aspect Maintain aspect ratio (default: true)
   * @param array    $htmlAttributes Array of HTML attributes.
   * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT.
   * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return.
   * @access public
   */
  function resize($path, $width, $height, $aspect = true, $htmlAttributes = array(), $return = false) {
    $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
    if(empty($htmlAttributes['alt'])) $htmlAttributes['alt'] = 'thumb';  // Ponemos alt default
    
    $fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$this->themeWeb.'img'.DS;
    $url = $fullpath.$path;
    
    // Comprueba que exista el archivo:
    $size = 0;  // Declaramos esta variable, no vaya a ser.
    if (!($size = @getimagesize($url))) {
      $path = 'no_image.jpg';
      $url = $fullpath.$path;  // Nuevo archivo de imagen (default)
      if (!($size = @getimagesize($url))) {
        return; 'sin imagen';  // Ahora si: image doesn't exist
      }
    }
    
    // Comprueba que el archivo sea imagen:
    $archivo = @image_type_to_mime_type(exif_imagetype($url));
    if(!ereg('^image', $archivo)) {
	    $url = $fullpath.'no_image.jpg';  // Nuevo archivo de imagen (default)
	    if (!($size = @getimagesize($url))) {
	      return 'sin imagen';
	    }
    }
    
    if ($aspect) { // adjust to aspect.
      if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
      $width = ceil(($size[0]/$size[1]) * $height);
      else
      $height = ceil($width / ($size[0]/$size[1]));
    }


    $relfile = $this->webroot.$this->themeWeb.'img'.'/'.$this->cacheDir.'/'.$width.'x'.$height.'_'.basename($path); // relative file
    $cachefile = $fullpath.$this->cacheDir.DS.$width.'x'.$height.'_'.basename($path);  // location on server

    if (file_exists($cachefile)) {
      $csize = getimagesize($cachefile);
      $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
      if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
      $cached = false;
    } else {
      $cached = false;
    }

    if (!$cached) {
      $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
    } else {
      $resize = false;
    }

    if ($resize) {
      $image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
      if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
        imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
      } else {
        $temp = imagecreate ($width, $height);
        imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
      }
      call_user_func("image".$types[$size[2]], $temp, $cachefile);
      imagedestroy ($image);
      imagedestroy ($temp);
    }

    return $this->output(sprintf($this->Html->tags['image'], $relfile, $this->Html->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
  }
}
?>