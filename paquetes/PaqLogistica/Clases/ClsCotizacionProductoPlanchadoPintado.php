<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionProductoPlanchadoPintado
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionProductoPlanchadoPintado {

    public $CppId;
	public $CprId;
	public $CppDescripcion;
    public $CppCantidad;
	public $CppPrecio;
	public $CppImporte;	
	public $CppTipo;
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

	private function MtdGenerarCotizacionProductoPlanchadoPintadoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CppId,5),unsigned)) AS "MAXIMO"
			FROM tblcppcotizacionproductoplanchadopintado';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CppId = "CPP-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CppId = "CPP-".$fila['MAXIMO'];					
			}
				
	}

	public function MtdObtenerCotizacionProductoPlanchadoPintado(){

        $sql = 'SELECT 
			cpp.CppId,			
			cpp.CprId,
			cpp.CppDescripcion,
			cpp.CppPrecio,
			cpp.CppCantidad,
			cpp.CppImporte,
			cpp.CppTipo,
			cpp.CppEstado,
			DATE_FORMAT(cpp.CppTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCppTiempoCreacion",
	        DATE_FORMAT(cpp.CppTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCppTiempoModificacion"
			FROM tblcppcotizacionproductoplanchadopintado cpp
        WHERE cpp.CppId = "'.$this->CppId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			  $this->CppId = $fila['CppId'];
			  $this->CprId = $fila['CprId'];
			  $this->CppDescripcion = $fila['CppDescripcion'];  
			  $this->CppPrecio = $fila['CppPrecio'];
			  $this->CppCantidad = $fila['CppCantidad'];  
			  $this->CppImporte = $fila['CppImporte'];
			  $this->CppTipo = $fila['CppTipo'];  
			  $this->CppEstado = $fila['CppEstado'];  
			  $this->CppTiempoCreacion = $fila['NCppTiempoCreacion'];  
			  $this->CppTiempoModificacion = $fila['NCppTiempoModificacion']; 	
					
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
    public function MtdObtenerCotizacionProductoPlanchadoPintados($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CppId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {

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
		
		if(!empty($oCotizacionProducto)){
			$cproducto = ' AND cpp.CprId = "'.$oCotizacionProducto.'"';
		}

		if(!empty($oEstado)){
			$estado = ' AND cpp.CppEstado = '.$oEstado.' ';
		}

		if(!empty($oTipo)){
			$tipo = ' AND cpp.CppTipo = "'.$oTipo.'" ';
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
			cpp.CppTipo,
			cpp.CppEstado,
			DATE_FORMAT(cpp.CppTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCppTiempoCreacion",
	        DATE_FORMAT(cpp.CppTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCppTiempoModificacion",
			
			cpr.MonId,
			cpr.CprTipoCambio
			
			FROM tblcppcotizacionproductoplanchadopintado cpp
				LEFT JOIN tblcprcotizacionproducto cpr
				ON cpp.CprId = cpr.CprId
			WHERE  1 = 1 '.$cproducto.$estado.$producto.$filtrar.$tipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionProductoPlanchadoPintado = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionProductoPlanchadoPintado = new $InsCotizacionProductoPlanchadoPintado();
                    $CotizacionProductoPlanchadoPintado->CppId = $fila['CppId'];
                    $CotizacionProductoPlanchadoPintado->CprId = $fila['CprId'];
					$CotizacionProductoPlanchadoPintado->CppDescripcion = $fila['CppDescripcion'];  
					$CotizacionProductoPlanchadoPintado->CppPrecio = $fila['CppPrecio'];
			        $CotizacionProductoPlanchadoPintado->CppCantidad = $fila['CppCantidad'];  
					$CotizacionProductoPlanchadoPintado->CppImporte = $fila['CppImporte'];
					$CotizacionProductoPlanchadoPintado->CppTipo = $fila['CppTipo'];  
					$CotizacionProductoPlanchadoPintado->CppEstado = $fila['CppEstado'];  
					$CotizacionProductoPlanchadoPintado->CppTiempoCreacion = $fila['NCppTiempoCreacion'];  
					$CotizacionProductoPlanchadoPintado->CppTiempoModificacion = $fila['NCppTiempoModificacion']; 					
					
					$CotizacionProductoPlanchadoPintado->MonId = $fila['MonId'];
					$CotizacionProductoPlanchadoPintado->CprTipoCambio = $fila['CprTipoCambio'];
					
                    $CotizacionProductoPlanchadoPintado->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionProductoPlanchadoPintado;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionProductoPlanchadoPintado($oElementos) {
		

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
		
				
				$sql = 'DELETE FROM tblcppcotizacionproductoplanchadopintado 
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
	
	
	public function MtdRegistrarCotizacionProductoPlanchadoPintado() {
	
			$this->MtdGenerarCotizacionProductoPlanchadoPintadoId();
			
			$sql = 'INSERT INTO tblcppcotizacionproductoplanchadopintado (
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
			"'.($this->CppTipo).'",
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
	
	public function MtdEditarCotizacionProductoPlanchadoPintado() {

		$sql = 'UPDATE tblcppcotizacionproductoplanchadopintado SET 	
		CppDescripcion = "'.($this->CppDescripcion).'",
		CppPrecio = '.($this->CppPrecio).',
		CppCantidad = '.($this->CppCantidad).',
		CppImporte = '.($this->CppImporte).',
		CppImporte = '.($this->CppImporte).',
		CppTiempoModificacion = "'.($this->CppTiempoModificacion).'"
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