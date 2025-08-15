<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenVentaVehiculoPropietario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenVentaVehiculoPropietario {

    public $OvpId;
	public $OvvId;
	public $CliId;
	public $OvpFirmaDJ;
	public $OvpEstado;
	public $OvpTiempoCreacion;
	public $OvpTiempoModificacion;
	
	
	public $TdoId;
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliNumeroDocumento;
	
	public $CliTelefono;
	public $CliCelular;
	public $CliEmail;
	
	public $CliRepresentanteNombre;
	public $CliRepresentanteNumeroDocumento;
	
	public $TdoNombre;
	
	
    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	private function MtdGenerarOrdenVentaVehiculoPropietarioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(OvpId,5),unsigned)) AS "MAXIMO"
			FROM tblovpordenventavehiculopropietario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->OvpId = "OVP-10000";
			}else{
				$fila['MAXIMO']++;
				$this->OvpId = "OVP-".$fila['MAXIMO'];					
			}
				
	}

    public function MtdObtenerOrdenVentaVehiculoPropietarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL,$oFirmaDJ=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){

			$oFiltro = str_replace(" ","%",$oFiltro);			
			$elementos = explode(",",$oCampo);

			$i=1;
			$filtrar .= '  AND (';
			foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				
				
				

				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND ovp.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}
		
		if(!empty($oFirmaDJ)){
			$firma = ' AND ovp.OvpFirmaDJ = '.$oFirmaDJ.'';
		}
		
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ovp.OvpId,			
			ovp.OvvId,
			ovp.CliId,
			ovp.OvpFirmaDJ,
			ovp.OvpEstado,
			DATE_FORMAT(ovp.OvpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvpTiempoCreacion",
			DATE_FORMAT(ovp.OvpTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvpTiempoModificacion",
			
			cli.TdoId,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,
			
			cli.CliTelefono,
			cli.CliCelular,
			cli.CliEmail,
			
			cli.CliRepresentanteNombre,
			cli.CliRepresentanteNumeroDocumento,
			cli.CliDireccion,
			cli.CliActividadEconomica,
			
			tdo.TdoNombre
			
			FROM tblovpordenventavehiculopropietario ovp		
				LEFT JOIN tblclicliente cli
				ON ovp.CliId = cli.CliId
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
			WHERE  1 = 1 '.$ovvehiculo.$estado.$producto.$firma .$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculoPropietario = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculoPropietario = new $InsOrdenVentaVehiculoPropietario();
                    $OrdenVentaVehiculoPropietario->OvpId = $fila['OvpId'];
                    $OrdenVentaVehiculoPropietario->OvvId = $fila['OvvId'];
                    $OrdenVentaVehiculoPropietario->CliId = (($fila['CliId']));
					$OrdenVentaVehiculoPropietario->OvpFirmaDJ = (($fila['OvpFirmaDJ']));
					$OrdenVentaVehiculoPropietario->OvpEstado = (($fila['OvpEstado']));
					$OrdenVentaVehiculoPropietario->OvpTiempoCreacion = (($fila['NOvpTiempoCreacion']));
					$OrdenVentaVehiculoPropietario->OvpTiempoModificacion = (($fila['NOvpTiempoModificacion']));
					
					
					$OrdenVentaVehiculoPropietario->TdoId = (($fila['TdoId']));
					$OrdenVentaVehiculoPropietario->CliNombre = (($fila['CliNombre']));
					$OrdenVentaVehiculoPropietario->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$OrdenVentaVehiculoPropietario->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					$OrdenVentaVehiculoPropietario->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$OrdenVentaVehiculoPropietario->CliTelefono = (($fila['CliTelefono']));
					$OrdenVentaVehiculoPropietario->CliCelular = (($fila['CliCelular']));
					$OrdenVentaVehiculoPropietario->CliEmail = (($fila['CliEmail']));
					
					$OrdenVentaVehiculoPropietario->CliRepresentanteNombre = (($fila['CliRepresentanteNombre']));
					$OrdenVentaVehiculoPropietario->CliRepresentanteNumeroDocumento = (($fila['CliRepresentanteNumeroDocumento']));
					
					
					$OrdenVentaVehiculoPropietario->CliDireccion = (($fila['CliDireccion']));
					$OrdenVentaVehiculoPropietario->CliActividadEconomica = (($fila['CliActividadEconomica']));
					
					$OrdenVentaVehiculoPropietario->TdoNombre = (($fila['TdoNombre']));
	

                    $OrdenVentaVehiculoPropietario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculoPropietario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarOrdenVentaVehiculoPropietario($oElementos) {
		
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (OvpId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (OvpId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblovpordenventavehiculopropietario 
				WHERE '.$eliminar;
							
				$error = false;
	
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarOrdenVentaVehiculoPropietario() {
	
			$this->MtdGenerarOrdenVentaVehiculoPropietarioId();
			
			$sql = 'INSERT INTO tblovpordenventavehiculopropietario (
			OvpId,
			OvvId,
			CliId,
			OvpFirmaDJ,
			OvpEstado,
			OvpTiempoCreacion,
			OvpTiempoModificacion
			) 
			VALUES (
			"'.($this->OvpId).'", 
			"'.($this->OvvId).'", 
			"'.($this->CliId).'", 
			'.($this->OvpFirmaDJ).', 
			'.($this->OvpEstado).', 
			"'.($this->OvpTiempoCreacion).'", 
			"'.($this->OvpTiempoModificacion).'");';
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
		
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarOrdenVentaVehiculoPropietario() {

			$sql = 'UPDATE tblovpordenventavehiculopropietario SET 	
			 OvpFirmaDJ = '.($this->OvpFirmaDJ).',
			 OvpEstado = '.($this->OvpEstado).',
			 OvpTiempoCreacion = "'.($this->OvpTiempoCreacion).'",
			 OvpTiempoModificacion = "'.($this->OvpTiempoModificacion).'"
			 WHERE OvpId = "'.($this->OvpId).'";';
					
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}	
		
	
}
?>