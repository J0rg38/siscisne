<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionPintado
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionPintado {

    public $CppId;
	public $CprId;
	
	public $CppDescripcion;
	
    public $CppCantidad;
	public $CppPrecio;
	public $CppImporte;	
	public $CppEstado;	
	public $CppTiempoCreacion;
	public $CppTiempoModificacion;
    public $CppEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarCotizacionPintadoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CppId,5),unsigned)) AS "MAXIMO"
			FROM tblcppcotizacionplanchadopintado';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CppId = "CPP-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CppId = "CPP-".$fila['MAXIMO'];					
			}
				
	}

    public function MtdObtenerCotizacionPintados($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CppId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacion=NULL,$oEstado=NULL) {

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
			$cproducto = ' AND cpp.CprId = "'.$oCotizacion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND cpp.CppEstado = '.$oEstado.' ';
		}

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			cpp.CppId,			
			cpp.CprId,
			cpp.CppDescripcion,
			cpp.CppPrecio,
			cpp.CppCantidad,
			cpp.CppImporte,
			DATE_FORMAT(cpp.CppTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCppTiempoCreacion",
	        DATE_FORMAT(cpp.CppTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCppTiempoModificacion"
			FROM tblcppcotizacionplanchadopintado cpp
			WHERE  1 = 1 '.$cproducto.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionPintado = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionPintado = new $InsCotizacionPintado();
                    $CotizacionPintado->CppId = $fila['CppId'];
                    $CotizacionPintado->CprId = $fila['CprId'];
					$CotizacionPintado->CppDescripcion = $fila['CppDescripcion'];  
					$CotizacionPintado->CppPrecio = $fila['CppPrecio'];
			        $CotizacionPintado->CppCantidad = $fila['CppCantidad'];  
					$CotizacionPintado->CppImporte = $fila['CppImporte'];
					$CotizacionPintado->CppTiempoCreacion = $fila['NCppTiempoCreacion'];  
					$CotizacionPintado->CppTiempoModificacion = $fila['NCppTiempoModificacion']; 					
					
                    $CotizacionPintado->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionPintado;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionPintado($oElementos) {
		
//		$InsCotizacionPintadoOrigen = new ClsCotizacionPintadoOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (CppId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CppId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblcppcotizacionplanchadopintado 
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
	
	
	public function MtdRegistrarCotizacionPintado() {
	
			$this->MtdGenerarCotizacionPintadoId();
			
			$sql = 'INSERT INTO tblcppcotizacionplanchadopintado (
			CppId,
			CprId,
			CppDescripcion,
			CppPrecio,
			CppCantidad,
			CppImporte,
			CppTipo,
			CppEstado,
			CppTiempoCreacion,
			CppTiempoModificacion) 
			VALUES (
			"'.($this->CppId).'", 
			"'.($this->CprId).'", 
			"'.($this->CppDescripcion).'", 
			'.($this->CppPrecio).',
			'.($this->CppCantidad).',
			'.($this->CppImporte).',
			"L",
			'.($this->CppEstado).',
			"'.($this->CppTiempoCreacion).'",
			"'.($this->CppTiempoModificacion).'");';
		
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
	
	public function MtdEditarCotizacionPintado() {

		$sql = 'UPDATE tblcppcotizacionplanchadopintado SET 	
		CppDescripcion = "'.($this->CppDescripcion).'",
		CppPrecio = '.($this->CppPrecio).',
		CppCantidad = '.($this->CppCantidad).',
		CppImporte = '.($this->CppImporte).'
		WHERE CppId = "'.($this->CppId).'";';

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