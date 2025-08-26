<?php

/**
 * Description of ClsConexionLocal
 *
 * @author Jonathan
 */

// set_time_limit(35);
class ClsMysql extends ClsConexion
{

	//private $CloHost;
	//private $CloBdNombre;
	//private $CloBdUsuario;
	//private $CloBdContrasena;
	//private $CloConexion;
	//private $CloConectado;
	//private static $CloConexionInstancia;

	private $Debug;
	private $Level;

	private $Log;
	private $LogLvl;

	private $inTransaction = false;

	function __construct($oDatoConexion = 'local')
	{


		//deb($oDatoConexion );
		parent::__construct($oDatoConexion);
		parent::MtdConectar();

		//deb($_SESSION['MysqlDeb']);
		//deb($_SESSION['MysqlDebLevel']);

		// Verificar si $_SESSION existe y tiene los valores necesarios
		// Solo acceder a $_SESSION si la sesión está activa
		if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION)) {
			$this->Debug = isset($_SESSION['MysqlDeb']) ? $_SESSION['MysqlDeb'] : false;
			$this->Level = isset($_SESSION['MysqlDebLevel']) ? $_SESSION['MysqlDebLevel'] : 1;
		} else {
			$this->Debug = false;
			$this->Level = 1;
		}

		$this->Log = true;
		$this->LogLvl = 2;

		//$this->Debug = true;
		//$this->Level = 1;

		//$this->Debug = false;
		//$this->Level = 1;
	}

	function __destruct()
	{
		//	mysqli_close($this->Conexion);

		// Solo cerrar la conexión si está conectado
		if ($this->CloConectado && $this->CloConexion) {
			@mysqli_close($this->CloConexion);
		}
	}


	public function MtdConsultar($oConsulta = NULL, $oObtener = false)
	{

		if ($this->CloConectado) {

			$resultado = $this->CloConexion->query($oConsulta);

			/*if (mysqli_errno($this->CloConexion) > 0) {
				echo mysqli_error($this->CloConexion);
			}*/

			// Solo hacer logging si está habilitado y hay una conexión válida
			if ($this->Log and $this->LogLvl == 2 && $this->CloConexion) {
				try {
					$this->MtdMysqlConsultaLog($oConsulta, $this->CloConexion->error);
				} catch (Exception $e) {
					// Si hay error en el logging, no fallar la consulta principal
					error_log("Error en logging MySQL: " . $e->getMessage());
				}
			}

			if (!empty($resultado) and $oObtener) {
				$resultado = $this->MtdObtenerDatos($resultado);
			}

			//deb($oConsulta);
			//deb($this->Debug);
			//deb($this->Level);

			if ($this->Debug and $this->Level == 2) {
				$this->MtdDebug($oConsulta, $resultado);
			}
		} else {
			$resultado =  NULL;
		}

		return $resultado;
	}


	public function MtdTransaccionIniciar()
	{
		if ($this->inTransaction) {
			throw new Exception("Ya hay una transacción activa");
		}

		if (!$this->CloConexion->begin_transaction()) {
			throw new Exception("Error al iniciar transacción: " . $this->CloConexion->error);
		}

		$this->inTransaction = true;
		return true;
	}

	public function MtdTransaccionHacer()
	{
		if (!$this->inTransaction) {
			throw new Exception("No hay transacción activa para confirmar");
		}

		if (!$this->CloConexion->commit()) {
			throw new Exception("Error al confirmar transacción: " . $this->CloConexion->error);
		}

		$this->inTransaction = false;
		return true;
	}


	public function MtdTransaccionDeshacer()
	{
		if (!$this->inTransaction) {
			throw new Exception("No hay transacción activa para revertir");
		}

		if (!$this->CloConexion->rollback()) {
			throw new Exception("Error al revertir transacción: " . $this->CloConexion->error);
		}

		$this->inTransaction = false;
		return true;
	}

	public function MtdEjecutar($oConsulta = NULL, $oTransaccion = false)
	{

		//deb($oConsulta);
		//if ($this->Debug) {
		//$this->MtdDebug($oConsulta, $result);
		//}


		$resultado = true;

		if ($this->CloConectado) {

			if ($oTransaccion) {

				$this->MtdTransaccionIniciar();

				$result = $this->CloConexion->query($oConsulta);

				if ($this->Log) {
					$this->MtdMysqlConsultaLog($oConsulta, $this->CloConexion->error);
				}

				if (!$result) {
					//throw new Exception("Error en consulta: " . $this->CloConexion->error);
					$this->MtdTransaccionDeshacer();
					$resultado =  false;
				} else {
					$this->MtdTransaccionHacer();
				}
			} else {



				$result = $this->CloConexion->query($oConsulta);



				if ($this->Log) {
					$this->MtdMysqlConsultaLog($oConsulta, $this->CloConexion->error);
				}

				if (!$result) {
					//throw new Exception("Error en consulta: " . $this->CloConexion->error);
					$resultado =  false;
				}
			}

			if ($this->Debug) {
				$this->MtdDebug($oConsulta, $resultado);
			}
		} else {
			$resultado =  false;
		}
		return $resultado;
	}

	public function MtdObtenerUltimoId()
	{

		if ($this->CloConectado) {
			$id = $this->CloConexion->insert_id;
		} else {
			$id = -1;
		}

		return $id;
	}

	public function MtdObtenerError()
	{

		if ($this->CloConectado) {
			$error = mysqli_error($this->CloConexion);
		} else {
			$error = NULL;
		}

		return $error;
	}

	public function MtdObtenerErrorCodigo()
	{
		if ($this->CloConectado) {
			return $this->CloConexion ? $this->CloConexion->errno : 0;
		} else {
			return NULL;
		}
	}

	public function MtdObtenerDatos($oCursor = NULL)
	{
		if ($this->CloConectado) {
			if ($oCursor) {
				$datos = $oCursor->fetch_assoc();
			} else {
				$datos = NULL;
			}
		} else {
			$datos = NULL;
		}

		return $datos;
	}

	public function MtdObtenerDatosTotal($oCursor = NULL)
	{
		if ($oCursor instanceof mysqli_result) {
			return $oCursor->num_rows;
		}
		return 0;
	}

	public function MtdLimpiarDato($oDato)
	{
		if ($this->CloConectado) {
			return $this->CloConexion->real_escape_string($oDato);
		} else {
			return NULL;
		}
	}


	/*
	public function MtdDesconectar()
	{
		if ($this->CloConectado) {
			mysqli_close($this->CloConexion);
		}
	}
*/




	private function MtdMysqlConsultaLog($oConsulta = NULL, $oError = NULL)
	{
		if (!isset($_SESSION['SisSucId'])) {
			$_SESSION['SisSucId'] = "";
		}

		if (!isset($_SESSION['SesionId'])) {
			$_SESSION['SesionId'] = "";
		}

		if (!isset($_SESSION['SesionUsuario'])) {
			$_SESSION['SesionUsuario'] = "";
		}

		// Crear directorio de log si no existe
		$logDir = 'log/' . date("d-m-Y");

		// Verificar si el directorio existe y es escribible
		if (!is_dir($logDir)) {
			if (!mkdir($logDir, 0777, true)) {
				// Si no se puede crear el directorio, salir sin error
				return;
			}
		}

		// Verificar permisos de escritura
		if (!is_writable($logDir)) {
			// Si el directorio no es escribible, salir sin error
			return;
		}


		//mkdir('log/' . date("d-m-Y"), 0777, true);
		$ddf = fopen('log/' . date("d-m-Y") . '/' . $_SESSION['SisSucId'] . '-' . date("d_m_Y_H") . '-error.txt', 'a');
		$oConsulta = preg_replace('/\t\t+/', '', $oConsulta);
		//			$oConsulta = preg_replace('/\s+/', '', $oConsulta);
		//			$oConsulta = preg_replace('/\n\n+/', '', $oConsulta);
		fwrite($ddf, "[" . date("d-m-Y H:i:s") . "][" . $_SESSION['SesionId'] . "][" . $_SESSION['SesionUsuario'] . "] \n Consulta: \n \t\t" . $oConsulta . "\n Resultado: \n \t\t" . $oError . "\n\n");
		fclose($ddf);
	}

	/*

	private function MtdMysqlConsultaLog($oConsulta = NULL, $oError = NULL)
	{
		global $SistemaAliasSesion;

		// Verificar que $SistemaAliasSesion esté definido
		if (!isset($SistemaAliasSesion) || empty($SistemaAliasSesion)) {
			$SistemaAliasSesion = '';
		}

		// Verificar que la sesión esté activa antes de acceder a $_SESSION
		if (session_status() !== PHP_SESSION_ACTIVE || !isset($_SESSION)) {
			// Si no hay sesión activa, usar valores por defecto
			$sucursalId = 'default';
			$sesionId = 'no-session';
			$sesionUsuario = 'no-user';
		} else {
			// Verificar que las variables de sesión existan
			if (!isset($_SESSION[$SistemaAliasSesion . 'SisSucId']) || 
				!isset($_SESSION[$SistemaAliasSesion . 'SesionId']) || 
				!isset($_SESSION[$SistemaAliasSesion . 'SesionUsuario'])) {
				// Si no hay sesión válida, usar valores por defecto
				$sucursalId = 'default';
				$sesionId = 'no-session';
				$sesionUsuario = 'no-user';
			} else {
				$sucursalId = $_SESSION[$SistemaAliasSesion . 'SisSucId'];
				$sesionId = $_SESSION[$SistemaAliasSesion . 'SesionId'];
				$sesionUsuario = $_SESSION[$SistemaAliasSesion . 'SesionUsuario'];
			}
		}

		// Crear directorio de log si no existe
		$logDir = 'log/' . date("d-m-Y");
		
		// Verificar si el directorio existe y es escribible
		if (!is_dir($logDir)) {
			if (!@mkdir($logDir, 0777, true)) {
				// Si no se puede crear el directorio, salir sin error
				return;
			}
		}
		
		// Verificar permisos de escritura
		if (!is_writable($logDir)) {
			// Si el directorio no es escribible, salir sin error
			return;
		}

		// Intentar abrir el archivo de log
		$logFile = $logDir . '/' . $sucursalId . '-' . date("d_m_Y_H") . '-error.txt';
		$ddf = @fopen($logFile, 'a');
		
		// Verificar que el archivo se abrió correctamente
		if ($ddf === false) {
			// Si no se puede abrir el archivo, salir sin error
			return;
		}

		$oConsulta = preg_replace('/\t\t+/', '', $oConsulta);
		
		// Escribir en el log solo si el archivo está abierto
		@fwrite($ddf, "[" . date("d-m-Y H:i:s") . "][" . $sesionId . "][" . $sesionUsuario . "] \n Consulta: \n \t\t" . $oConsulta . "\n Resultado: \n \t\t" . $oError . "\n\n");
		@fclose($ddf);
	}
	*/


	private function MtdDebug($oConsulta = NULL, $oResultado = NULL)
	{


?>
		<div align="left">
			<b>Consulta: </b><i><?php echo $oConsulta; ?></i> <br />
			<b>Mysql Error: </b><i><?php echo $this->CloConexion->error; ?></i><br />
			<b>Mysql Resultado: </b><i>
				<pre><?php echo var_dump($oResultado); ?></pre>
			</i><br><br />
		</div>
<?php
	}
}
?>