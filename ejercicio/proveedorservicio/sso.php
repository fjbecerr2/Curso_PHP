<?php
	include('funciones.php');
	
	$proveedorServicio = new miConexionSQL_ProveedorServicio;
	
	$firma = sha1($_GET['email'].$_GET['ts'].$proveedorServicio->CLAVEPRIVADA);		
	$ts = (int)$_GET['ts'];
	$ts = $ts + (15*60);  // 15 minutos de margen
	$proveedorServicio->Trazar('Validando firma',false);		
	if ($firma != $_GET['firma']){ //Validando la firma
		$proveedorServicio->CerrarConexionBBDD();
	}
	else {	
		$proveedorServicio->Trazar('Validando timestamp'.$ts.' - '.time(),false);		
		
		if(time() < $ts )  //Validamos el tiempo
		{
			if ($proveedorServicio->ConsultarUsuario($_GET['email']) == true){
				$usuarioencontrado = $proveedorServicio->getUsuarioencontrado();
				$_SESSION['pi']['user'] = $usuarioencontrado[0];
				$_SESSION['pi']['pass'] = $usuarioencontrado[1];		
				$proveedorServicio->CerrarConexionBBDD();
				
				if($proveedorServicio->TRAZAR){
					$proveedorServicio->Trazar('Session: '.$_SESSION['pi']['user'].'-'.$_SESSION['pi']['pass'],false);		
				}	
				header('Location: index.php');
				
			}	
			else{
				$pass = sha1(rand(1000,9999));
				if ($proveedorServicio->InsertarUsuario($_GET['email'], $pass)==true){
					if ($proveedorServicio->ConsultarUsuario($_GET['email'])==true){
						$usuarioencontrado = $proveedorServicio->getUsuarioencontrado();
						$_SESSION['pi']['user'] = $usuarioencontrado[0];
						$_SESSION['pi']['pass'] = $usuarioencontrado[1];
						if($proveedorServicio->TRAZAR){
							$proveedorServicio->Trazar('Session: '.$_SESSION['pi']['user'].'-'.$_SESSION['pi']['pass'],false);		
						}
						header('Location: index.php');				
					}	
					
				}
				$proveedorServicio->CerrarConexionBBDD();	
			}	
		}	
	}	
	
?>
