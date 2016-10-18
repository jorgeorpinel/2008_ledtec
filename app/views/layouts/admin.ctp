<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Administración | LedTec </title>
  <link rel="icon" href="<?php echo $this->webroot.'favicon.ico'; ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo $this->webroot.'favicon.ico'; ?>" type="image/x-icon" />
  <style type="text/css">
  	* {font-family: "Century Gothic" arial; padding: 0; margin: 0;}
		a {color: #fff;}
		a:link {text-decoration: none;}
		a:hover {color: #000; background: #a9bee3;}
		a:visited {color: #000; text-decoration: none;}
		
		html, body{min-width: 900px; height: 100%;}
		body {behavior: url("/js/csshover.htc");}	/* Behaivior para habilitar :hover en IE6 */
		img {border: none; vertical-align: middle;}
		
		#login_box {
			position: absolute; top: 30%; left: 30%;
			width: 40%; height: 40%; min-height: 300px;
			border: 8px solid #fff;
			background: #7faddc;
		}
			#login_box .error-message {
				color: #600;
				text-align: center;
				background: #fee;
				border: 1px solid #f00;
				margin-bottom: 1em;
			}
			#login_box .input {
				margin-bottom: .5em;
			}
				#login_box .input label {float: left; width: 100px; text-align: right; padding-right: .5em;}
				#login_box .input input {
					width: 240px;
				}
			#login_box button {float: right; margin: .5em 1em 0 0;}
  </style>
</head>
<body style="background: #666;">
	<div id="login_box">
		<?php echo $content_for_layout; ?>
	</div>
</body>
</html>