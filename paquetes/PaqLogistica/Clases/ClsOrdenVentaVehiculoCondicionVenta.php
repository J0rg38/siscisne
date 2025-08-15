<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenVentaVehiculoCondicionVenta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenVentaVehiculoCondicionVenta {

    public $OvnId;
	public $OvvId;
	public $CovId;
	public $OvnEstado;
	public $OvnTiempoCreacion;
	public $OvnTiempoModificacion;
	
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

	private function MtdGenerarOrdenVentaVehiculoCondicionVentaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(OvnId,5),unsigned)) AS "MAXIMO"
			FROM tblovnordenventavehiculocondicionventa';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->OvnId = "OVN-10000";
			}else{
				$fila['MAXIMO']++;
				$this->OvnId = "OVN-".$fila['MAXIMO'];					
			}
				
	}

    public function MtdObtenerOrdenVentaVehiculoCondicionVentas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvnId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacion=NULL) {

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
			$amovimiento = ' AND ovn.OvvId = "'.$oCotizacion.'"';
		}
		
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ovn.OvnId,			
			ovn.OvvId,
			ovn.CovId,
			ovn.OvnEstado,
			DATE_FORMAT(ovn.OvnTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvnTiempoCreacion",
			DATE_FORMAT(ovn.OvnTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvnTiempoModificacion",
			
			cov.CovNombre
			
			FROM tblovnordenventavehiculocondicionventa ovn		
				LEFT JOIN tblcovcondicionventa cov
				ON ovn.CovId = cov.CovId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculoCondicionVenta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculoCondicionVenta = new $InsOrdenVentaVehiculoCondicionVenta();
                    $OrdenVentaVehiculoCondicionVenta->OvnId = $fila['OvnId'];
                    $OrdenVentaVehiculoCondicionVenta->OvvId = $fila['OvvId'];
                    $OrdenVentaVehiculoCondicionVenta->CovId = (($fila['CovId']));
					$OrdenVentaVehiculoCondicionVenta->OvnEstado = (($fila['OvnEstado']));
					$OrdenVentaVehiculoCondicionVenta->OvnTiempoCreacion = (($fila['NOvnTiempoCreacion']));
					$OrdenVentaVehiculoCondicionVenta->OvnTiempoModificacion = (($fila['NOvnTiempoModificacion']));
					
					$OrdenVentaVehiculoCondicionVenta->CovNombre = (($fila['CovNombre']));
					

                    $OrdenVentaVehiculoCondicionVenta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculoCondicionVenta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarOrdenVentaVehiculoCondicionVenta($oElementos) {
		
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (OvnId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (OvnId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblovnordenventavehiculocondicionventa 
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
	
	
	public function MtdRegistrarOrdenVentaVehiculoCondicionVenta() {
	
			$this->MtdGenerarOrdenVentaVehiculoCondicionVentaId();
			
			$sql = 'INSERT INTO tblovnordenventavehiculocondicionventa (
			OvnId,
			OvvId,
			CovId,
			OvnEstado,
			OvnTiempoCreacion,
			OvnTiempoModificacion
			) 
			VALUES (
			"'.($this->OvnId).'", 
			"'.($this->OvvId).'", 
			"'.($this->CovId).'", 
			'.($this->OvnEstado).', 
			"'.($this->OvnTiempoCreacion).'", 
			"'.($this->OvnTiempoModificacion).'");';
		
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
	
	public function MtdEditarOrdenVentaVehiculoCondicionVenta() {

			$sql = 'UPDATE tblovnordenventavehiculocondicionventa SET 	
			 OvnEstado = '.($this->OvnEstado).',
			 OvnTiempoCreacion = "'.($this->OvnTiempoCreacion).'",
			 OvnTiempoModificacion = "'.($this->OvnTiempoModificacion).'"
			 WHERE OvnId = "'.($this->OvnId).'";';
					
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