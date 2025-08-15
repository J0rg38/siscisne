<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCampanaVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCampanaVehiculo {

    public $AveId;
	public $CamId;
	public $AveVIN;
	public $AveEstado;	
	public $AveTiempoCreacion;
	public $AveTiempoModificacion;
    public $AveEliminado;
	
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

	private function MtdGenerarCampanaVehiculoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(AveId,5),unsigned)) AS "MAXIMO"
		FROM tblavecampanavehiculo';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->AveId = "AVE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->AveId = "AVE-".$fila['MAXIMO'];					
		}
				
	}

    public function MtdObtenerCampanaVehiculos($oCampo=NULL,$oCondicion,$oFiltro=NULL,$oOrden = 'AveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCampana=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
		
		if(!empty($oCampana)){
			$campana = ' AND ave.CamId = "'.$oCampana.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ave.AveEstado = '.$oEstado.' ';
		}


		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cam.CamFechaInicio)>="'.$oFechaInicio.'" AND DATE(cam.CamFechaInicio)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cam.CamFechaInicio)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cam.CamFechaInicio)<="'.$oFechaFin.'"';		
			}			
		}


		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ave.AveId,			
			ave.CamId,
			ave.AveVIN,
			ave.AveEstado,
			DATE_FORMAT(ave.AveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAveTiempoCreacion",
	        DATE_FORMAT(ave.AveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAveTiempoModificacion"
			
			FROM tblavecampanavehiculo ave
			
				LEFT JOIN tblcamcampana cam
				ON ave.CamId = cam.CamId
				
			WHERE  1 = 1 '.$campana.$estado.$fecha.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCampanaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CampanaVehiculo = new $InsCampanaVehiculo();
                    $CampanaVehiculo->AveId = $fila['AveId'];
                    $CampanaVehiculo->CamId = $fila['CamId'];
					$CampanaVehiculo->AveVIN = $fila['AveVIN']; 
					$CampanaVehiculo->AveEstado = $fila['AveEstado'];
					$CampanaVehiculo->AveTiempoCreacion = $fila['NAveTiempoCreacion'];  
					$CampanaVehiculo->AveTiempoModificacion = $fila['NAveTiempoModificacion']; 					

                    $CampanaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CampanaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCampanaVehiculo($oElementos) {
		
//		$InsCampanaVehiculoOrigen = new ClsCampanaVehiculoOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (AveId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AveId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblavecampanavehiculo 
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
	
	
	public function MtdEliminarCampanaVehiculoTodo($oCampanaVehiculoId) {
		
	
		$error = false;
		
	
				

					$sql = 'DELETE FROM tblavecampanavehiculo 
					WHERE CamId = "'.$oCampanaVehiculoId.'"';
		
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
	


	public function MtdRegistrarCampanaVehiculo() {
	
			$this->MtdGenerarCampanaVehiculoId();
			
			$sql = 'INSERT INTO tblavecampanavehiculo (
			AveId,
			CamId,
			AveVIN,
			AveEstado,
			AveTiempoCreacion,
			AveTiempoModificacion) 
			VALUES (
			"'.($this->AveId).'", 
			"'.($this->CamId).'", 
			"'.($this->AveVIN).'", 
			'.($this->AveEstado).',
			"'.($this->AveTiempoCreacion).'",
			"'.($this->AveTiempoModificacion).'");';
		
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
	
	/*public function MtdEditarCampanaVehiculo() {

			$sql = 'UPDATE tblavecampanavehiculo SET 	
			
			AveVIN = "'.($this->AveVIN).'",
			AveTiempoModificacion
			AveDescripcion = "'.($this->AveDescripcion).'",
			 
			AveCosto = '.($this->AveCosto).',
			AveCantidad = '.($this->AveCantidad).',
			AveCostoTotal = '.($this->AveCostoTotal).',
			
			AveMargen = '.($this->AveMargen).',
			AveCostoMargen = '.($this->AveCostoMargen).'
			
			WHERE AveId = "'.($this->AveId).'";';
					
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
				
		}	*/
		
	
}
?>