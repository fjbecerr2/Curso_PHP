<?php
	include('funciones.php');
	$proveedorIdentidad = new miConexionSQL_ProveedorIdentidad;
	if ($proveedorIdentidad->login_correcto()) {
		$ts = time();
		$proveedorIdentidad->mensaje('Estás registrado correctamente', false);
		$firma = sha1($_SESSION['ps']['user'].$ts.$proveedorIdentidad->CLAVEPRIVADA);
		$url = 'http://localhost/proveedorservicio/sso.php?email='.htmlentities($_SESSION['ps']['user']).'&ts='.$ts.'&firma='.$firma;
		$proveedorIdentidad->CerrarConexionBBDD();
		header("Location: $url");
	}
	else{
		$proveedorIdentidad->CerrarConexionBBDD();
	}	
	
?>
