<?php
	session_start();
	
	class miConexionSQL_ProveedorIdentidad 
	{		
		const CLAVEPRIVADA = 'SOLOPARASUSOJOS';
		
		const TRAZAR = false;
		
		private $servername = 'localhost';
		private $database = 'proveedoridentidad'; 
		private $username = 'root';
		private $password = '';	
					
		//==
		function __construct(){
			$this->AbrirConexionBBDD();	
		}	
		
		function __destruct(){ 
			//$this->CerrarConexionBBDD();
		}	
		
		//====
		public function setServername($pservername){
			$this->servername = $pservername;
		}	
		public function getServername(){			
			return $this->servername;
		}
		
		//===
		public function setDatabase($pdatabase)	{
			$this->database = $pdatabase;	
		}			
		public function getDatabase(){
			return $this->database;
		}
		
		//==
		public function setUsername($pusername){
			$this->username = $pusername;
		}
		public function getUsername(){
			return $this->username;		
		}
		
		//==
		public function setpassword($ppassword){
			$this->$password = $ppassword;
		}	
				
		//==
		public function AbrirConexionBBDD(){
			if (self::TRAZAR == True ){
				$this->Trazar(__FILE__.' - '.__FUNCTION__." -".'CONECTANDO BASE DE DATOS: ', false);				
			}	
			
			$conexionActiva = false;			
	
			try {						
					$GLOBALS['conexion'] = mysqli_connect($this->servername,$this->username,'',$this->database);				
					$GLOBALS['conexion'] -> query('SET NAMES utf8');	
					$conexionActiva = true;							
			}
			catch(Throwable $e){
				$this->Trazar('CONECTANDO A BBDD: '.$e->getMessage(), true);				
			}		
				
			if (self::TRAZAR == True ){
				$this->Trazar('<=== Conexion activa: '.($conexionActiva ? 'true' : 'false'), false);
			}
			
			return $conexionActiva;
		}	
		
		
		
		public function CerrarConexionBBDD(){
			if (self::TRAZAR == True ){
				$this->Trazar(__FILE__.' - '.__FUNCTION__." -".'CERRANDO CONEXION BBDD', false);
				$this->Trazar($this->getServername().':'.$this->getDatabase(), false);
			}
			
			$conexionActiva =  mysqli_close($GLOBALS['conexion']);
			
			if (self::TRAZAR == True ){
				$this->Trazar('<=== Conexion cerrada: '.($conexionActiva ? 'true' : 'false'), false);
			}			
			
			return $conexionActiva;			
		}	
			
	
	public function login_correcto() {
		if (self::TRAZAR == True ){
				$this->Trazar(__FILE__.' - '.__FUNCTION__." -".'LOGEANDO USUARIO', false);				
				$this->Trazar($_SESSION['ps']['user'].'- '.$_SESSION['ps']['pass'],false);			
		}
		
		$usuariologeado = false;
		try{			
			$consulta = 'SELECT * FROM usuarios WHERE user = \'' . addslashes($_SESSION['ps']['user']) . '\' AND pass = \'' . $_SESSION['ps']['pass']. '\'';
			$resultado = $GLOBALS['conexion'] -> query($consulta);
			
			if ($resultado -> num_rows > 0) {
				$usuariologeado=true;				
			} else {
				$usuariologeado=false;
			}				
		}	
		catch(Throwable $e){
				$this->Trazar('CONECTANDO A BBDD: '.$e->getMessage(), true);				
		}		
			
		
		if (self::TRAZAR == True ){
			$this->Trazar('<=== SQL: '.$consulta, false);			
			$this->Trazar('<=== Usuario logeado: '.($usuariologeado ? 'true' : 'false'), false);
		}					
		
		return $usuariologeado;
	}

	public function mensaje($mensaje, $advertencia){
		if ($advertencia == true){
				echo '<font color= "red">'.$mensaje.'</font> <br> <br>';
			}
			else{
				echo '<font color= "green">'.$mensaje.'</font> <br> <br>';
			}
	}	

	public function Trazar($mensaje, $error){
			$fecha = getdate();
			$fechalog = $fecha['mday'].'/'.$fecha['mon'].'/'.$fecha['year'];
			$horalog = $fecha['hours'].':'.$fecha['minutes'].':'.$fecha['seconds'];
			$fechaerr = $fechalog.' - '.$horalog;
			
			if ($error == true){
				echo '<'.$fechaerr.' <font color= "red">ERR :'.$mensaje .'</font>> <br>';
			}
			else{
				echo '<'.$fechaerr.' <font color= "green">INF :'.$mensaje .'</font>> <br>';
			}		
		}
	}
?>
