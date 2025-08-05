<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenVentaVehiculoObsequio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenVentaVehiculoObsequio {

    public $OvoId;
	public $OvvId;
	public $ObsId;
	public $OvoAprobado;
	
	public $OvoEstado;
	public $OvoTiempoCreacion;
	public $OvoTiempoModificacion;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarOrdenVentaVehiculoObsequioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(OvoId,5),unsigned)) AS "MAXIMO"
			FROM tblovoordenventavehiculoobsequio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->OvoId = "OVO-10000";
			}else{
				$fila['MAXIMO']++;
				$this->OvoId = "OVO-".$fila['MAXIMO'];					
			}
				
	}

    public function MtdObtenerOrdenVentaVehiculoObsequios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL,$oEstado=NULL) {

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
			$ovvehiculo = ' AND ovo.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ovo.OvoEstado = "'.$oEstado.'"';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ovo.OvoId,			
			ovo.OvvId,
			ovo.ObsId,
			ovo.ObsId AS OvoObsequio,
			ovo.OvoAprobado,
			ovo.OvoEstado,
			DATE_FORMAT(ovo.OvoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvoTiempoCreacion",
			DATE_FORMAT(ovo.OvoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvoTiempoModificacion",
			
			obs.ObsNombre,
			obs.ObsUso
			
			FROM tblovoordenventavehiculoobsequio ovo		
				LEFT JOIN tblobsobsequio obs
				ON ovo.ObsId = obs.ObsId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$ovvehiculo.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculoObsequio = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculoObsequio = new $InsOrdenVentaVehiculoObsequio();
                    $OrdenVentaVehiculoObsequio->OvoId = $fila['OvoId'];
                    $OrdenVentaVehiculoObsequio->OvvId = $fila['OvvId'];
                    $OrdenVentaVehiculoObsequio->ObsId = (($fila['ObsId']));
					$OrdenVentaVehiculoObsequio->OvoObsequio = (($fila['OvoObsequio']));
					$OrdenVentaVehiculoObsequio->OvoAprobado = (($fila['OvoAprobado']));
					$OrdenVentaVehiculoObsequio->OvoEstado = (($fila['OvoEstado']));
					$OrdenVentaVehiculoObsequio->OvoTiempoCreacion = (($fila['NOvoTiempoCreacion']));
					$OrdenVentaVehiculoObsequio->OvoTiempoModificacion = (($fila['NOvoTiempoModificacion']));
					
					$OrdenVentaVehiculoObsequio->ObsNombre = (($fila['ObsNombre']));
					$OrdenVentaVehiculoObsequio->ObsUso = (($fila['ObsUso']));
					
                    $OrdenVentaVehiculoObsequio->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculoObsequio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarOrdenVentaVehiculoObsequio($oElementos) {
		
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (OvoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (OvoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblovoordenventavehiculoobsequio 
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
	
	
	public function MtdRegistrarOrdenVentaVehiculoObsequio() {
	
			$this->MtdGenerarOrdenVentaVehiculoObsequioId();
			
			$sql = 'INSERT INTO tblovoordenventavehiculoobsequio (
			OvoId,
			OvvId,
			ObsId,
			OvoAprobado,
			OvoEstado,
			OvoTiempoCreacion,
			OvoTiempoModificacion
			) 
			VALUES (
			"'.($this->OvoId).'", 
			"'.($this->OvvId).'", 
			"'.($this->ObsId).'", 
			'.($this->OvoAprobado).', 
			'.($this->OvoEstado).', 
			"'.($this->OvoTiempoCreacion).'", 
			"'.($this->OvoTiempoModificacion).'");';
		
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
	
	public function MtdEditarOrdenVentaVehiculoObsequio() {

			$sql = 'UPDATE tblovoordenventavehiculoobsequio SET 	
			
			 OvoTiempoCreacion = "'.($this->OvoTiempoCreacion).'",
			 OvoTiempoModificacion = "'.($this->OvoTiempoModificacion).'"
			 WHERE OvoId = "'.($this->OvoId).'";';
					
					 //OvoEstado = '.($this->OvoEstado).',
					 
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