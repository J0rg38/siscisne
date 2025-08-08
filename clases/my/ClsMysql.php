<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsConexionLocal
 *
 * @author Ing. Jonathan Blanco Alave
 */
 
// set_time_limit(35);
class ClsMysql extends ClsConexion {

	//private $CloHost;
	//private $CloBdNombre;
	//private $CloBdUsuario;
	//private $CloBdContrasena;
    //private $CloConexion;
	//private $CloConectado;
    //private static $CloConexionInstancia;
	private $Debug;
	private $Log;
	
		function __construct(){			
			parent::__construct();       
			parent:: MtdConectar();     
			
			$this->Debug = $_SESSION['MysqlDeb'];
			$this->Level = $_SESSION['MysqlDebLevel'];
			
			$this->Log = true;
			$this->LogLvl =1;
			
//$this->Debug = true;
//$this->Level = 1;
			
			//$this->Debug = false;
//$this->Level = 1;
		}

		function __destruct(){
			//	mysql_close($this->Conexion);
		}
		
		 public function MtdConsultar($oConsulta=NULL,$oObtener=false){
		 
            if($this->CloConectado){
				
				$resultado = mysql_query($oConsulta,$this->CloConexion);
				
				if($this->Log and $this->LogLvl==2){
					$this->MtdMysqlConsultaLog($oConsulta,mysql_error($this->CloConexion));
				}
					
				if(!empty($resultado) & $oObtener){
					$resultado= $this->MtdObtenerDatos($resultado);
				}
			
				if($this->Debug & $this->Level==2){
					$this->MtdDebug($oConsulta,$resultado);					
				}
				
            }else{
                $resultado =  NULL;
            }
            
									
            return $resultado;
        }
		
		
		private function MtdMysqlConsultaLog($oConsulta=NULL,$oError=NULL){
			@mkdir('log/'.date("d-m-Y"),0777,true);
			$ddf = @fopen('log/'.date("d-m-Y").'/'.$_SESSION['SisSucId'].'-'.date("d_m_Y_H").'-error.txt','a');
			$oConsulta = preg_replace('/\t\t+/', '', $oConsulta);
//			$oConsulta = preg_replace('/\s+/', '', $oConsulta);
//			$oConsulta = preg_replace('/\n\n+/', '', $oConsulta);
			@fwrite($ddf,"[".date("d-m-Y H:i:s")."][".$_SESSION['SesionId']."][".$_SESSION['SesionUsuario']."] \n Consulta: \n \t\t".$oConsulta."\n Resultado: \n \t\t".$oError."\n\n");
			@fclose($ddf);
		}

		public function MtdTransaccionIniciar(){
			mysql_query("START TRANSACTION",$this->CloConexion);
		}
		
		public function MtdTransaccionHacer(){
			mysql_query("COMMIT",$this->CloConexion);
		}
		
		public function MtdTransaccionDeshacer(){
			mysql_query("ROLLBACK",$this->CloConexion);
		}		
		
		public function MtdEjecutar($oConsulta=NULL,$oTransaccion=false){
			
			$resultado = true;
			
			if($this->CloConectado){
			 	
				if($oTransaccion){
					//mysql_query("START TRANSACTION",$this->CloConexion);
					$this->MtdTransaccionIniciar();
					
					mysql_query($oConsulta,$this->CloConexion);
//					$er = mysql_error($this->CloConexion);
					
					if($this->Log){
//					if($this->Log and !empty($er)){						
						$this->MtdMysqlConsultaLog($oConsulta,mysql_error($this->CloConexion));
					}
										
					if(mysql_error($this->CloConexion)){
						//mysql_query("ROLLBACK",$this->CloConexion);
						$this->MtdTransaccionDeshacer();
						 $resultado =  false;
					}else{
						$this->MtdTransaccionHacer();
						//mysql_query("COMMIT",$this->CloConexion);
					}				
				}else{					
					mysql_query($oConsulta,$this->CloConexion);
					
					if($this->Log){
						$this->MtdMysqlConsultaLog($oConsulta,mysql_error($this->CloConexion));
					}

					
					if(mysql_error($this->CloConexion)){						
						 $resultado =  false;
					}					
				}
				
				if($this->Debug){
					$this->MtdDebug($oConsulta,$resultado);					
				}
				
            }else{
                $resultado =  false;
            }			
			return $resultado;
		}
		
		private function MtdDebug($oConsulta=NULL,$oResultado=NULL){
?>               
<br /><br /><br />       
            <div align="left">
            <b>Consulta: </b><i><?php echo $oConsulta;?></i> <br /> 
            <b>Mysql Error: </b><i><?php echo mysql_error($this->CloConexion);?></i><br />
            <b>Mysql Resultado: </b><i><pre><?php echo ($oResultado);?></pre></i><br><br />
            </div>
<?php			
		}
		
		public function MtdObtenerError(){

			if($this->CloConectado){
				$error = mysql_error($this->CloConexion);
			}else{
				$error = NULL;
			}
			
			return $error;
		}
		
		public function MtdObtenerErrorCodigo(){

			if($this->CloConectado){
				$errno = mysql_errno($this->CloConexion);
			}else{
				$errno = NULL;
			}
			
			return $errno;
		}

        public function MtdObtenerDatos($oCursor=NULL){
			
			if($this->CloConectado){
				$datos = mysql_fetch_assoc($oCursor);
			}else{
				$datos = NULL;
			}

            return $datos;
        }
		
		public function MtdObtenerDatosTotal($oCursor=NULL){
		
			if($this->CloConectado){
				$filas = mysql_num_rows($oCursor);
			}else{
				$filas = NULL;
			}
			
			return $filas;			
		}
		
        public function MtdLimpiarDato($oDato){
            if($this->CloConectado){
                $dato = mysql_real_escape_string($oDato,$this->CloConexion);
            }else{
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
		
		/*public function MtdDesconectar(){
			if($this->CloConectado){
                mysql_close($this->CloConexion);
            }
		}*/

       
        


		/*public function MtdObtenerConexion(){
			return $this->CloConexion;
		}*/


}
?>
