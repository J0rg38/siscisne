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

		// Verificar si $_SESSION existe y tiene los valores necesarios
		$this->Debug = isset($_SESSION['MysqlDeb']) ? $_SESSION['MysqlDeb'] : false;
		$this->Level = isset($_SESSION['MysqlDebLevel']) ? $_SESSION['MysqlDebLevel'] : 1;

		$this->Log = false;
		$this->LogLvl = 2;

		//$this->Debug = true;
		//$this->Level = 1;

		//$this->Debug = false;
		//$this->Level = 1;
	}

	function __destruct()
	{
		//	mysqli_close($this->Conexion);

		$this->MtdDesconectar();
	}


	public function MtdConsultar($oConsulta = NULL, $oObtener = false)
	{

		if ($this->CloConectado) {

			$resultado = $this->CloConexion->query($oConsulta);

			if (mysqli_errno($this->CloConexion) > 0) {
				echo mysqli_error($this->CloConexion);
			}

			if ($this->Log and $this->LogLvl == 2) {
				$this->MtdMysqlConsultaLog($oConsulta, $this->CloConexion->error);
			}

			if (!empty($resultado) and $oObtener) {
				$resultado = $this->MtdObtenerDatos($resultado);
			}

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
		global $SistemaAliasSesion;

		@mkdir('log/' . date("d-m-Y"), 0777, true);
		$ddf = @fopen('log/' . date("d-m-Y") . '/' . $_SESSION[$SistemaAliasSesion . 'SisSucId'] . '-' . date("d_m_Y_H") . '-error.txt', 'a');
		$oConsulta = preg_replace('/\t\t+/', '', $oConsulta);
		@fwrite($ddf, "[" . date("d-m-Y H:i:s") . "][" . $_SESSION[$SistemaAliasSesion . 'SesionId'] . "][" . $_SESSION[$SistemaAliasSesion . 'SesionUsuario'] . "] \n Consulta: \n \t\t" . $oConsulta . "\n Resultado: \n \t\t" . $oError . "\n\n");
		@fclose($ddf);
	}


	private function MtdDebug($oConsulta = NULL, $oResultado = NULL)
	{
?>
		<div align="left">
			<b>Consulta: </b><i><?php echo $oConsulta; ?></i> <br />
			<b>Mysql Error: </b><i><?php echo mysqli_error($this->CloConexion); ?></i><br />
			<b>Mysql Resultado: </b><i>
				<pre><?php echo var_dump($oResultado); ?></pre>
			</i><br><br />
		</div>
<?php
	}
}
?>