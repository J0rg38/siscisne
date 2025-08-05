<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionVehiculoObsequio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionVehiculoObsequio {

    public $CvoId;
	public $CveId;
	public $ObsId;
	public $CvoAprobado;
	
	public $CvoEstado;
	public $CvoTiempoCreacion;
	public $CvoTiempoModificacion;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarCotizacionVehiculoObsequioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CvoId,5),unsigned)) AS "MAXIMO"
			FROM tblcvocotizacionvehiculoobsequio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CvoId = "CVO-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CvoId = "CVO-".$fila['MAXIMO'];					
			}
				
	}

    public function MtdObtenerCotizacionVehiculoObsequios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CvoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionVehiculo=NULL,$oEstado=NULL) {

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
			$ovvehiculo = ' AND cvo.CveId = "'.$oCotizacionVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND cvo.CvoEstado = "'.$oEstado.'"';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			cvo.CvoId,			
			cvo.CveId,
			cvo.ObsId,
			cvo.ObsId AS CvoObsequio,
			cvo.CvoAprobado,
			
			cvo.CvoObsequio,
			cvo.CvoEstado,
			DATE_FORMAT(cvo.CvoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCvoTiempoCreacion",
			DATE_FORMAT(cvo.CvoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCvoTiempoModificacion",
			
			obs.ObsNombre,
			obs.ObsUso
			
			FROM tblcvocotizacionvehiculoobsequio cvo		
				LEFT JOIN tblobsobsequio obs
				ON cvo.ObsId = obs.ObsId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$ovvehiculo.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionVehiculoObsequio = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionVehiculoObsequio = new $InsCotizacionVehiculoObsequio();
                    $CotizacionVehiculoObsequio->CvoId = $fila['CvoId'];
                    $CotizacionVehiculoObsequio->CveId = $fila['CveId'];
                    $CotizacionVehiculoObsequio->ObsId = (($fila['ObsId']));
					$CotizacionVehiculoObsequio->CvoObsequio = (($fila['CvoObsequio']));
					$CotizacionVehiculoObsequio->CvoAprobado = (($fila['CvoAprobado']));
					
					$CotizacionVehiculoObsequio->CvoObsequio = (($fila['CvoObsequio']));					
					$CotizacionVehiculoObsequio->CvoEstado = (($fila['CvoEstado']));
					$CotizacionVehiculoObsequio->CvoTiempoCreacion = (($fila['NCvoTiempoCreacion']));
					$CotizacionVehiculoObsequio->CvoTiempoModificacion = (($fila['NCvoTiempoModificacion']));
					
					$CotizacionVehiculoObsequio->ObsNombre = (($fila['ObsNombre']));
					$CotizacionVehiculoObsequio->ObsUso = (($fila['ObsUso']));
					
                    $CotizacionVehiculoObsequio->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionVehiculoObsequio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionVehiculoObsequio($oElementos) {
		
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (CvoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CvoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblcvocotizacionvehiculoobsequio 
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
	
	
	public function MtdRegistrarCotizacionVehiculoObsequio() {
	
			$this->MtdGenerarCotizacionVehiculoObsequioId();
			
			$sql = 'INSERT INTO tblcvocotizacionvehiculoobsequio (
			CvoId,
			CveId,
			ObsId,
			CvoAprobado,
			
			CvoObsequio,
			CvoEstado,
			CvoTiempoCreacion,
			CvoTiempoModificacion
			) 
			VALUES (
			"'.($this->CvoId).'", 
			"'.($this->CveId).'", 
			"'.($this->ObsId).'", 
			'.($this->CvoAprobado).', 
			
			"'.($this->CvoObsequio).'", 			
			'.($this->CvoEstado).', 
			"'.($this->CvoTiempoCreacion).'", 
			"'.($this->CvoTiempoModificacion).'");';
		
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
	
	public function MtdEditarCotizacionVehiculoObsequio() {

			$sql = 'UPDATE tblcvocotizacionvehiculoobsequio SET 	
			 CvoObsequio = "'.($this->CvoObsequio).'",
			
			 CvoTiempoCreacion = "'.($this->CvoTiempoCreacion).'",
			 CvoTiempoModificacion = "'.($this->CvoTiempoModificacion).'"
			 WHERE CvoId = "'.($this->CvoId).'";';
					
					 //CvoEstado = '.($this->CvoEstado).',
					 
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