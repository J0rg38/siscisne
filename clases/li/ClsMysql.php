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

	function __construct($oDatoConexion = 'local')
	{

		//deb($oDatoConexion );
		parent::__construct($oDatoConexion);
		parent::MtdConectar();

		$this->Debug = $_SESSION['MysqlDeb'];
		$this->Level = $_SESSION['MysqlDebLevel'];

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
	}

	public function MtdConsultar($oConsulta = NULL, $oObtener = false)
	{


		if ($this->CloConectado) {

			$resultado = mysqli_query($this->CloConexion, $oConsulta);

			//var_dump($resultado);

			//var_dump($this->CloConexion->errno);
			//var_dump($this->CloConexion->error);
			//var_dump(mysqli_errno($this->CloConexion));
			//var_dump(mysqli_error($this->CloConexion));

			if (mysqli_errno($this->CloConexion) > 0) {
				echo mysqli_error($this->CloConexion);
			}


			if ($this->Log and $this->LogLvl == 2) {
				$this->MtdMysqlConsultaLog($oConsulta, mysqli_error($this->CloConexion));
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

	private function MtdMysqlConsultaLog($oConsulta = NULL, $oError = NULL)
	{
		global $SistemaAliasSesion;

		@mkdir('log/' . date("d-m-Y"), 0777, true);
		$ddf = @fopen('log/' . date("d-m-Y") . '/' . $_SESSION[$SistemaAliasSesion . 'SisSucId'] . '-' . date("d_m_Y_H") . '-error.txt', 'a');
		$oConsulta = preg_replace('/\t\t+/', '', $oConsulta);
		@fwrite($ddf, "[" . date("d-m-Y H:i:s") . "][" . $_SESSION[$SistemaAliasSesion . 'SesionId'] . "][" . $_SESSION[$SistemaAliasSesion . 'SesionUsuario'] . "] \n Consulta: \n \t\t" . $oConsulta . "\n Resultado: \n \t\t" . $oError . "\n\n");
		@fclose($ddf);
	}

	/*private function MtdMysqlConsultaLog($oConsulta=NULL,$oError=NULL){
		$ddf = @fopen(date("d_m_Y_H").'-error.txt','a');
			
		$oConsulta = preg_replace('/\t\t+/', '', $oConsulta);
//			$oConsulta = preg_replace('/\s+/', '', $oConsulta);
//			$oConsulta = preg_replace('/\n\n+/', '', $oConsulta);
				
		@fwrite($ddf,"[".date("d-m-Y H:i:s")."][".$_SESSION[$SistemaAliasSesion.'SesionId']."][".$_SESSION[$SistemaAliasSesion.'SesionUsuario']."] \n Consulta: \n \t\t".$oConsulta."\n Resultado: \n \t\t".$oError."\n\n");
		@fclose($ddf);
	}*/


	public function MtdTransaccionIniciar()
	{
		mysqli_query($this->CloConexion, "START TRANSACTION");
	}

	public function MtdTransaccionHacer()
	{
		mysqli_query($this->CloConexion, "COMMIT");
	}

	public function MtdTransaccionDeshacer()
	{
		mysqli_query($this->CloConexion, "ROLLBACK");
	}

	public function MtdEjecutar($oConsulta = NULL, $oTransaccion = false)
	{

		$resultado = true;

		if ($this->CloConectado) {

			if ($oTransaccion) {
				//mysqli_query("START TRANSACTION",$this->CloConexion);
				$this->MtdTransaccionIniciar();

				mysqli_query($this->CloConexion, $oConsulta);
				//					$er = mysqli_error($this->CloConexion);

				if ($this->Log) {
					//					if($this->Log and !empty($er)){						
					$this->MtdMysqlConsultaLog($oConsulta, mysqli_error($this->CloConexion));
				}

				if (mysqli_error($this->CloConexion)) {
					//mysqli_query("ROLLBACK",$this->CloConexion);
					$this->MtdTransaccionDeshacer();
					$resultado =  false;
				} else {
					$this->MtdTransaccionHacer();
					//mysqli_query("COMMIT",$this->CloConexion);
				}
			} else {
				mysqli_query($this->CloConexion, $oConsulta);

				if ($this->Log) {
					$this->MtdMysqlConsultaLog($oConsulta, mysqli_error($this->CloConexion));
				}

				if (mysqli_error($this->CloConexion)) {
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
			$id = mysqli_insert_id($this->CloConexion);
		} else {
			$id = -1;
		}

		return $id;
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

	public function MtdObtenerError()
	{

		if ($this->CloConectado) {
			$error = mysqli_error($this->CloConexion);
		} else {
			$error = NULL;
		}

		return $error;
	}

	public function MtdObtenerErrorCodigo() //revisar 16/03/24
	{

		if ($this->CloConectado) {
			$errno = mysqli_errno($this->CloConexion);
		} else {
			$errno = NULL;
		}

		return $errno;
	}

	public function MtdObtenerDatos($oCursor = NULL)
	{

		if ($this->CloConectado) {
			if ($oCursor) {
				$datos = mysqli_fetch_assoc($oCursor);
				//mysqli_free_result($this->CloConexion);
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

		if ($this->CloConectado) {

			if ($oCursor) {
				$filas = mysqli_num_rows($oCursor);
			} else {
				$filas = NULL;
			}
		} else {
			$filas = NULL;
		}

		return $filas;
	}

	public function MtdLimpiarDato($oDato)
	{
		if ($this->CloConectado) {
			$dato = mysqli_real_escape_string($this->CloConexion, $oDato);
		} else {
			$dato = NULL;
		}
		return $dato;
	}


	/*  public static function Instanciar(){
            if(!self::$CloConexionInstancia){
                self::$CloConexionInstancia = new self();
            }
            return self::$CloConexionInstancia;
        }*/

	/*public function MtdConectar(){
           
          $this->CloConectado = true;

            $this->CloConexion = mysql_connect($this->CloHost, $this->CloBdUsuario, $this->CloBdContrasena);

            if (!$this->CloConexion) {
			   $this->CloConectado = false;
              
			} else {
				if(!mysql_select_db($this->CloBdNombre, $this->CloConexion)){                   
					$this->CloConectado = false;
				}
			}
			            
			return $this->CloConectado;
		}*/

	public function MtdDesconectar()
	{
		if ($this->CloConectado) {
			mysqli_close($this->CloConexion);
		}
	}





	/*public function MtdObtenerConexion(){
			return $this->CloConexion;
		}*/
}
?>