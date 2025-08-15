<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenVentaVehiculoLlamada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenVentaVehiculoLlamada {

    public $OvlId;
	public $OvvId;
	public $OvlNumero;
	public $OvlFecha;
	public $OvlObservacion;
	public $OvlEstado;	
	public $OvlTiempoCreacion;
	public $OvlTiempoModificacion;
    public $OvlEliminado;
	
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

	private function MtdGenerarOrdenVentaVehiculoLlamadaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(OvlId,5),unsigned)) AS "MAXIMO"
		FROM tblovlordenventavehiculollamada';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->OvlId = "OVL-10000";
		}else{
			$fila['MAXIMO']++;
			$this->OvlId = "OVL-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerOrdenVentaVehiculoLlamadas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvlId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL,$oEstado=NULL) {

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
			$garantia = ' AND ovl.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ovl.OvlEstado = '.$oEstado.' ';
		}
			
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ovl.OvlId,			
			ovl.OvvId,
			ovl.OvlNumero,
			ovl.OvlFecha,
			ovl.OvlObservacion,
			ovl.OvlEstado,
			DATE_FORMAT(ovl.OvlTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvlTiempoCreacion",
	        DATE_FORMAT(ovl.OvlTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvlTiempoModificacion"
			
			FROM tblovlordenventavehiculollamada ovl
			WHERE  1 = 1 '.$garantia.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculoLlamada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculoLlamada = new $InsOrdenVentaVehiculoLlamada();
                    $OrdenVentaVehiculoLlamada->OvlId = $fila['OvlId'];
                    $OrdenVentaVehiculoLlamada->OvvId = $fila['OvvId'];

					$OrdenVentaVehiculoLlamada->OvlNumero = $fila['OvlNumero'];  

					$OrdenVentaVehiculoLlamada->OvlFecha = $fila['OvlFecha'];  
					$OrdenVentaVehiculoLlamada->OvlObservacion = $fila['OvlObservacion'];
			      
					$OrdenVentaVehiculoLlamada->OvlEstado = $fila['OvlEstado'];
					$OrdenVentaVehiculoLlamada->OvlTiempoCreacion = $fila['NOvlTiempoCreacion'];  
					$OrdenVentaVehiculoLlamada->OvlTiempoModificacion = $fila['NOvlTiempoModificacion']; 					

                    $OrdenVentaVehiculoLlamada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculoLlamada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarOrdenVentaVehiculoLlamada($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (OvlId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (OvlId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblovlordenventavehiculollamada 
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
	
	
	public function MtdRegistrarOrdenVentaVehiculoLlamada() {
	
			$this->MtdGenerarOrdenVentaVehiculoLlamadaId();
			
			
			$sql = 'INSERT INTO tblovlordenventavehiculollamada (
			OvlId,
			OvvId,
			
			OvlNumero,
			
			OvlFecha,			
			OvlObservacion,
			
			OvlEstado,
			OvlTiempoCreacion,
			OvlTiempoModificacion) 
			VALUES (
			"'.($this->OvlId).'", 
			"'.($this->OvvId).'", 
			"'.($this->OvlNumero).'", 

			"'.($this->OvlFecha).'", 
			"'.($this->OvlObservacion).'", 	
			
			'.($this->OvlEstado).',
			"'.($this->OvlTiempoCreacion).'",
			"'.($this->OvlTiempoModificacion).'");';
		
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
	
	public function MtdEditarOrdenVentaVehiculoLlamada() {

			$sql = 'UPDATE tblovlordenventavehiculollamada SET 	
			
			OvlNumero = "'.($this->OvlNumero).'",

			OvlFecha = "'.($this->OvlFecha).'",			 
			OvlObservacion = "'.($this->OvlObservacion).'",
		
			OvlTiempoModificacion = "'.($this->OvlTiempoModificacion).'"
			 
			WHERE OvlId = "'.($this->OvlId).'";';
					
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