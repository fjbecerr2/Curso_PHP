<?php
	include('funciones.php');	
	
	switch ($_POST['accion']) {
	case 'login':			
		$_SESSION['ps']['user'] = $_POST['user'];		
		$_SESSION['ps']['pass'] = sha1($_POST['pass']);	
	break;
	case 'logout':		
		unset($_SESSION['ps']['user']);
		unset($_SESSION['ps']['pass']);
	break;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Proveedor de identidad</title>
		<link href="estilos.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="main">
			<header>
				<h1>Proveedor de identidad</h1>
			</header>
			<div id="contenido">
<?php		
	$proveedorIdentidad = new miConexionSQL_ProveedorIdentidad;
	if ($proveedorIdentidad->login_correcto()) {
		$ts = time();
		//$firma = sha1($_SESSION['ps']['user'] . $ts . clave_privada);
		$proveedorIdentidad->mensaje('Estás registrado correctamente', false);
		$firma = sha1($_SESSION['ps']['user'].$ts.$proveedorIdentidad->CLAVEPRIVADA);
?>		
	<a href='http://localhost/proveedorservicio/sso.php?email=<?php echo htmlentities($_SESSION['ps']['user']);?>&ts=<?php echo $ts; ?>&firma=<?php echo $firma; ?>' title="Acceder al servicio">Acceder al servicio</a>
<form method="post" action="index.php">
<input type="hidden" name="accion" value="logout">
<button type="submit">Salir</button>
</form>
<?php
	} else {
?>
<form method="post" action="index.php">
<?php
		if ($_POST['accion'] == 'login') {
			$proveedorIdentidad->mensaje('Usuario y/o/ contraseña incorrectos', true);
		}
?>
		<input type="hidden" name="accion" value="login">
		Usuario<br>
		<input type="text" name="user"><br>
		Contraseña<br>
		<input type="password" name="pass"><br>
		<button type="submit">Entrar</button>
</form>
<?php
}
?>
			</div>
		</div>
	</body>
</html>
