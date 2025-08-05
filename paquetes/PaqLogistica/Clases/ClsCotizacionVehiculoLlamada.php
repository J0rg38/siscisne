<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionVehiculoLlamada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionVehiculoLlamada {

    public $CvlId;
	public $CveId;
	public $CvlNumero;
	public $CvlFecha;
	public $CvlObservacion;
	public $CvlEstado;	
	public $CvlTiempoCreacion;
	public $CvlTiempoModificacion;
    public $CvlEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	private function MtdGenerarCotizacionVehiculoLlamadaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(CvlId,5),unsigned)) AS "MAXIMO"
		FROM tblcvlcotizacionvehiculollamada';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->CvlId = "CVL-10000";
		}else{
			$fila['MAXIMO']++;
			$this->CvlId = "CVL-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerCotizacionVehiculoLlamadas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CvlId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionVehiculo=NULL,$oEstado=NULL) {

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
		
		if(!empty($oCotizacionVehiculo)){
			$garantia = ' AND cvl.CveId = "'.$oCotizacionVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND cvl.CvlEstado = '.$oEstado.' ';
		}
			
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			cvl.CvlId,			
			cvl.CveId,
			cvl.CvlNumero,
			
			
			DATE_FORMAT(cvl.CvlFecha, "%d/%m/%Y") AS "NCvlFecha",
			DATE_FORMAT(cvl.CvlFechaProgramada, "%d/%m/%Y") AS "NCvlFechaProgramada",
			
			cvl.CvlObservacion,
			cvl.CvlEstado,
			DATE_FORMAT(cvl.CvlTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCvlTiempoCreacion",
	        DATE_FORMAT(cvl.CvlTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCvlTiempoModificacion"
			
			FROM tblcvlcotizacionvehiculollamada cvl
			WHERE  1 = 1 '.$garantia.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionVehiculoLlamada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionVehiculoLlamada = new $InsCotizacionVehiculoLlamada();
                    $CotizacionVehiculoLlamada->CvlId = $fila['CvlId'];
                    $CotizacionVehiculoLlamada->CveId = $fila['CveId'];

					$CotizacionVehiculoLlamada->CvlNumero = $fila['CvlNumero'];  

					$CotizacionVehiculoLlamada->CvlFecha = $fila['NCvlFecha'];  
					$CotizacionVehiculoLlamada->CvlFechaProgramada = $fila['NCvlFechaProgramada'];  
					
					$CotizacionVehiculoLlamada->CvlObservacion = $fila['CvlObservacion'];
			      
					$CotizacionVehiculoLlamada->CvlEstado = $fila['CvlEstado'];
					$CotizacionVehiculoLlamada->CvlTiempoCreacion = $fila['NCvlTiempoCreacion'];  
					$CotizacionVehiculoLlamada->CvlTiempoModificacion = $fila['NCvlTiempoModificacion']; 					

                    $CotizacionVehiculoLlamada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionVehiculoLlamada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionVehiculoLlamada($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (CvlId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CvlId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblcvlcotizacionvehiculollamada 
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
	
	
	public function MtdRegistrarCotizacionVehiculoLlamada() {
	
			$this->MtdGenerarCotizacionVehiculoLlamadaId();
			
			
			$sql = 'INSERT INTO tblcvlcotizacionvehiculollamada (
			CvlId,
			CveId,
			
			CvlNumero,
			
			CvlFecha,	
			CvlFechaProgramada,			
			CvlObservacion,
			
			CvlEstado,
			CvlTiempoCreacion,
			CvlTiempoModificacion) 
			VALUES (
			"'.($this->CvlId).'", 
			"'.($this->CveId).'", 
			"'.($this->CvlNumero).'", 

			"'.($this->CvlFecha).'", 
			'.(empty($this->CvlFechaProgramada)?"NULL,":'"'.$this->CvlFechaProgramada.'",').'
			"'.($this->CvlObservacion).'", 	
			
			'.($this->CvlEstado).',
			"'.($this->CvlTiempoCreacion).'",
			"'.($this->CvlTiempoModificacion).'");';
		
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
	
	public function MtdEditarCotizacionVehiculoLlamada() {

			$sql = 'UPDATE tblcvlcotizacionvehiculollamada SET 	
			
			CvlNumero = "'.($this->CvlNumero).'",

			CvlFecha = "'.($this->CvlFecha).'",	
			'.(empty($this->CvlFechaProgramada)?'CvlFechaProgramada = NULL, ':'CvlFechaProgramada = "'.$this->CvlFechaProgramada.'",').'
					 
			CvlObservacion = "'.($this->CvlObservacion).'",
		
			CvlTiempoModificacion = "'.($this->CvlTiempoModificacion).'"
			 
			WHERE CvlId = "'.($this->CvlId).'";';
					
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