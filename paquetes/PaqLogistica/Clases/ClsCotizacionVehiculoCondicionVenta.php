<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionVehiculoCondicionVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionVehiculoCondicionVenta {

    public $CcvId;
	public $CveId;
	public $CovId;
	public $CcvEstado;
	public $CcvTiempoCreacion;
	public $CcvTiempoModificacion;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarCotizacionVehiculoCondicionVentaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CcvId,5),unsigned)) AS "MAXIMO"
			FROM tblccvcotizacionvehiculocondicionventa';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CcvId = "CCV-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CcvId = "CCV-".$fila['MAXIMO'];					
			}
				
	}

    public function MtdObtenerCotizacionVehiculoCondicionVentas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CcvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacion=NULL) {

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
		
		if(!empty($oCotizacion)){
			$amovimiento = ' AND ccv.CveId = "'.$oCotizacion.'"';
		}
		
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ccv.CcvId,			
			ccv.CveId,
			ccv.CovId,
			ccv.CcvEstado,
			DATE_FORMAT(ccv.CcvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCcvTiempoCreacion",
			DATE_FORMAT(ccv.CcvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCcvTiempoModificacion",
			
			cov.CovNombre
			
			FROM tblccvcotizacionvehiculocondicionventa ccv		
				LEFT JOIN tblcovcondicionventa cov
				ON ccv.CovId = cov.CovId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionVehiculoCondicionVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionVehiculoCondicionVenta = new $InsCotizacionVehiculoCondicionVenta();
                    $CotizacionVehiculoCondicionVenta->CcvId = $fila['CcvId'];
                    $CotizacionVehiculoCondicionVenta->CveId = $fila['CveId'];
                    $CotizacionVehiculoCondicionVenta->CovId = (($fila['CovId']));
					$CotizacionVehiculoCondicionVenta->CcvEstado = (($fila['CcvEstado']));
					$CotizacionVehiculoCondicionVenta->CcvTiempoCreacion = (($fila['NCcvTiempoCreacion']));
					$CotizacionVehiculoCondicionVenta->CcvTiempoModificacion = (($fila['NCcvTiempoModificacion']));
					
					$CotizacionVehiculoCondicionVenta->CovNombre = (($fila['CovNombre']));
					

                    $CotizacionVehiculoCondicionVenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionVehiculoCondicionVenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionVehiculoCondicionVenta($oElementos) {
		
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (CcvId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CcvId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblccvcotizacionvehiculocondicionventa 
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
	
	
	public function MtdRegistrarCotizacionVehiculoCondicionVenta() {
	
			$this->MtdGenerarCotizacionVehiculoCondicionVentaId();
			
			$sql = 'INSERT INTO tblccvcotizacionvehiculocondicionventa (
			CcvId,
			CveId,
			CovId,
			CcvEstado,
			CcvTiempoCreacion,
			CcvTiempoModificacion
			) 
			VALUES (
			"'.($this->CcvId).'", 
			"'.($this->CveId).'", 
			"'.($this->CovId).'", 
			'.($this->CcvEstado).', 
			"'.($this->CcvTiempoCreacion).'", 
			"'.($this->CcvTiempoModificacion).'");';
		
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
	
	public function MtdEditarCotizacionVehiculoCondicionVenta() {

			$sql = 'UPDATE tblccvcotizacionvehiculocondicionventa SET 	
			 CcvEstado = '.($this->CcvEstado).',
			 CcvTiempoCreacion = "'.($this->CcvTiempoCreacion).'",
			 CcvTiempoModificacion = "'.($this->CcvTiempoModificacion).'"
			 WHERE CcvId = "'.($this->CcvId).'";';
					
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