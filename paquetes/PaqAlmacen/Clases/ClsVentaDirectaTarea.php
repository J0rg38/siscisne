<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVentaDirectaTarea
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVentaDirectaTarea {

    public $VdtId;
	public $VdiId;
	public $VdtDescripcion;
    public $VdtCantidad;
	public $VdtPrecio;
	public $VdtImporte;	
	public $VdtTipo;
	public $VdtEstado;	
	public $VdtTiempoCreacion;
	public $VdtTiempoModificacion;
    public $VdtEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarVentaDirectaTareaId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VdtId,5),unsigned)) AS "MAXIMO"
			FROM tblvdtventadirectatarea';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VdtId = "VDT-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VdtId = "VDT-".$fila['MAXIMO'];					
			}
				
	}

	public function MtdObtenerVentaDirectaTarea(){

        $sql = 'SELECT 
			vdt.VdtId,			
			vdt.VdiId,
			vdt.VdtDescripcion,
			vdt.VdtPrecio,
			vdt.VdtCantidad,
			vdt.VdtImporte,
			vdt.VdtTipo,
			vdt.VdtEstado,
			DATE_FORMAT(vdt.VdtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdtTiempoCreacion",
	        DATE_FORMAT(vdt.VdtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdtTiempoModificacion"
			FROM tblvdtventadirectatarea vdt
        WHERE vdt.VdtId = "'.$this->VdtId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			  $this->VdtId = $fila['VdtId'];
			  $this->VdiId = $fila['VdiId'];
			  $this->VdtDescripcion = $fila['VdtDescripcion'];  
			  $this->VdtPrecio = $fila['VdtPrecio'];
			  $this->VdtCantidad = $fila['VdtCantidad'];  
			  $this->VdtImporte = $fila['VdtImporte'];
			  $this->VdtTipo = $fila['VdtTipo'];  
			  $this->VdtEstado = $fila['VdtEstado'];  
			  $this->VdtTiempoCreacion = $fila['NVdtTiempoCreacion'];  
			  $this->VdtTiempoModificacion = $fila['NVdtTiempoModificacion']; 	
					
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
    public function MtdObtenerVentaDirectaTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdtId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$cproducto = '';
		$estado = '';
		$tipo = '';
		$producto = '';

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
			$cproducto = ' AND vdt.VdiId = "'.$oCotizacionProducto.'"';
		}

		if(!empty($oEstado)){
			$estado = ' AND vdt.VdtEstado = '.$oEstado.' ';
		}

		if(!empty($oTipo)){
			$tipo = ' AND vdt.VdtTipo = "'.$oTipo.'" ';
		}

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vdt.VdtId,			
			vdt.VdiId,
			vdt.VdtDescripcion,
			vdt.VdtPrecio,
			vdt.VdtCantidad,
			vdt.VdtImporte,
			vdt.VdtTipo,
			vdt.VdtEstado,
			DATE_FORMAT(vdt.VdtTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdtTiempoCreacion",
	        DATE_FORMAT(vdt.VdtTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdtTiempoModificacion"
			FROM tblvdtventadirectatarea vdt
			WHERE  1 = 1 '.$cproducto.$estado.$producto.$filtrar.$tipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirectaTarea = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirectaTarea = new $InsVentaDirectaTarea();
                    $VentaDirectaTarea->VdtId = $fila['VdtId'];
                    $VentaDirectaTarea->VdiId = $fila['VdiId'];
					$VentaDirectaTarea->VdtDescripcion = $fila['VdtDescripcion'];  
					$VentaDirectaTarea->VdtPrecio = $fila['VdtPrecio'];
			        $VentaDirectaTarea->VdtCantidad = $fila['VdtCantidad'];  
					$VentaDirectaTarea->VdtImporte = $fila['VdtImporte'];
					$VentaDirectaTarea->VdtTipo = $fila['VdtTipo'];  
					$VentaDirectaTarea->VdtEstado = $fila['VdtEstado'];  
					$VentaDirectaTarea->VdtTiempoCreacion = $fila['NVdtTiempoCreacion'];  
					$VentaDirectaTarea->VdtTiempoModificacion = $fila['NVdtTiempoModificacion']; 					
					
                    $VentaDirectaTarea->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirectaTarea;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVentaDirectaTarea($oElementos) {
		

		$error = false;
		
		// Inicializar variable
		$eliminar = '';
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (VdtId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VdtId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblvdtventadirectatarea 
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
	
	
	public function MtdRegistrarVentaDirectaTarea() {
	
			$this->MtdGenerarVentaDirectaTareaId();
			
			$sql = 'INSERT INTO tblvdtventadirectatarea (
			VdtId,
			VdiId,
			VdtDescripcion,
			VdtPrecio,
			VdtCantidad,
			VdtImporte,
			VdtTipo,
			VdtEstado,
			VdtTiempoCreacion,
			VdtTiempoModificacion) 
			VALUES (
			"'.($this->VdtId).'", 
			"'.($this->VdiId).'", 
			"'.($this->VdtDescripcion).'", 
			'.($this->VdtPrecio).',
			'.($this->VdtCantidad).',
			'.($this->VdtImporte).',
			"'.($this->VdtTipo).'",
			'.($this->VdtEstado).',
			"'.($this->VdtTiempoCreacion).'",
			"'.($this->VdtTiempoModificacion).'");';
		
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
	
	public function MtdEditarVentaDirectaTarea() {

		$sql = 'UPDATE tblvdtventadirectatarea SET 	
		VdtDescripcion = "'.($this->VdtDescripcion).'",
		VdtPrecio = '.($this->VdtPrecio).',
		VdtCantidad = '.($this->VdtCantidad).',
		VdtImporte = '.($this->VdtImporte).',
		VdtEstado = '.($this->VdtEstado).'
		WHERE VdtId = "'.($this->VdtId).'";';

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