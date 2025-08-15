<?php


/**
 * Description of ClsConexionLocal
 *
 * @author Jonathan
 */
class ClsConexion
{
	//put your code here

	public $CloBdHost;
	public $CloBdPuerto;

	public $CloBdNombre;
	public $CloBdUsuario;
	public $CloBdContrasena;

	public $CloConexion;

	public $CloConectado;

	function __construct($oDatoConexion = 'local')
	{
		//@session_start();

		global $ConexionBdHost;
		global $ConexionBdPuerto;
		global $ConexionBdUsuario;
		global $ConexionBdContrasena;
		global $ConexionBdNombre;

		$this->CloBdHost = $ConexionBdHost[$oDatoConexion];
		$this->CloBdPuerto = $ConexionBdPuerto[$oDatoConexion];
		$this->CloBdNombre = $ConexionBdNombre[$oDatoConexion];
		$this->CloBdUsuario = $ConexionBdUsuario[$oDatoConexion];
		$this->CloBdContrasena = $ConexionBdContrasena[$oDatoConexion];
	}

	function __destruct()
	{
		//	mysql_close($this->Conexion);
		//$this->MtdDesconectar();
	}

	public function MtdConectar()
	{

		$this->CloConectado = false;

		try {
			// Crear conexión mysqli
			$this->CloConexion = new mysqli(
				$this->CloBdHost,
				$this->CloBdUsuario,
				$this->CloBdContrasena,
				$this->CloBdNombre,
				$this->CloBdPuerto
			);

			// Verificar conexión
			if ($this->CloConexion->connect_error) {
				throw new Exception("Error de conexión: " . $this->CloConexion->connect_error);
			}
			/*
			// Configurar charset
			if (!$this->CloConexion->set_charset($config['charset'])) {
				throw new Exception("Error al establecer charset: " . $this->CloConexion->error);
			}*/

			// Configurar modo SQL
			$this->CloConexion->query("SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO'");

			$this->CloConectado = true;
		} catch (Exception $e) {
			die("Error de conexión: " . $e->getMessage());
		}


		return $this->CloConectado;
	}

	public function MtdDesconectar()
	{

		if ($this->CloConectado) {
			if ($this->CloConexion) {
				$this->CloConexion->close();
			}
		}
	}
}
