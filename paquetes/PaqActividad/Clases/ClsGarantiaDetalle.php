<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGarantiaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGarantiaDetalle {

    public $GdeId;
	public $GarId;
	
	public $ProId;
	public $UmeId;
	
	public $GdeCodigo;
	public $GdeDescripcion;
	
	public $GdeCosto;
    public $GdeCantidad;
	public $GdeCostoTotal;
	public $GdeMargen;
	public $GdeCostoMagen;
	
	public $GdeEstado;	
	public $GdeTiempoCreacion;
	public $GdeTiempoModificacion;
    public $GdeEliminado;
	
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

	private function MtdGenerarGarantiaDetalleId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(GdeId,5),unsigned)) AS "MAXIMO"
		FROM tblgdegarantiadetalle';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->GdeId = "GDE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->GdeId = "GDE-".$fila['MAXIMO'];					
		}
				
	}

    public function MtdObtenerGarantiaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGarantia=NULL,$oEstado=NULL,$oProducto=NULL) {

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
		
		if(!empty($oGarantia)){
			$garantia = ' AND gde.GarId = "'.$oGarantia.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND gde.GdeEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (gde.ProId = "'.$oProducto.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			gde.GdeId,			
			gde.GarId,
			
			gde.AmdId,
			
			gde.ProId,
			gde.UmeId,
			
			gde.GdeCodigo,
			gde.GdeDescripcion,

			gde.GdeCosto,
			gde.GdeCantidad,
			gde.GdeCostoTotal,
			
			gde.GdeMargen,
			gde.GdeCostoMargen,
			
			gde.GdeEstado,
			DATE_FORMAT(gde.GdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGdeTiempoCreacion",
	        DATE_FORMAT(gde.GdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGdeTiempoModificacion",
			
			pro.ProCodigoOriginal,
			pro.ProNombre,
			ume.UmeNombre
			
			FROM tblgdegarantiadetalle gde
				LEFT JOIN tblproproducto pro
				ON gde.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON gde.UmeId = ume.UmeId
					
			WHERE  1 = 1 '.$garantia.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGarantiaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GarantiaDetalle = new $InsGarantiaDetalle();
                    $GarantiaDetalle->GdeId = $fila['GdeId'];
                    $GarantiaDetalle->GarId = $fila['GarId'];
					
					$GarantiaDetalle->AmdId = $fila['AmdId'];
					
					$GarantiaDetalle->ProId = $fila['ProId'];
					$GarantiaDetalle->UmeId = $fila['UmeId'];

					$GarantiaDetalle->GdeCodigo = $fila['GdeCodigo'];  
					$GarantiaDetalle->GdeDescripcion = $fila['GdeDescripcion'];  
			
					$GarantiaDetalle->GdeCosto = $fila['GdeCosto'];
			        $GarantiaDetalle->GdeCantidad = $fila['GdeCantidad'];  
					$GarantiaDetalle->GdeCostoTotal = $fila['GdeCostoTotal'];
					
					$GarantiaDetalle->GdeMargen = $fila['GdeMargen'];
					$GarantiaDetalle->GdeCostoMargen = $fila['GdeCostoMargen'];
			
					$GarantiaDetalle->GdeEstado = $fila['GdeEstado'];
					$GarantiaDetalle->GdeTiempoCreacion = $fila['NGdeTiempoCreacion'];  
					$GarantiaDetalle->GdeTiempoModificacion = $fila['NGdeTiempoModificacion'];
					
					$GarantiaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$GarantiaDetalle->ProNombre = $fila['ProNombre']; 
					$GarantiaDetalle->UmeNombre = $fila['UmeNombre'];  					
	
                    $GarantiaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GarantiaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarGarantiaDetalle($oElementos) {
		
//		$InsGarantiaDetalleOrigen = new ClsGarantiaDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (GdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblgdegarantiadetalle 
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
	
	
	public function MtdRegistrarGarantiaDetalle() {
	
			$this->MtdGenerarGarantiaDetalleId();
			
			$sql = 'INSERT INTO tblgdegarantiadetalle (
			GdeId,
			GarId,
			
			AmdId,
			
			ProId,
			UmeId,
			
			GdeCodigo,
			GdeDescripcion,
			
			GdeCosto,
			GdeCantidad,
			GdeCostoTotal,
			
			GdeMargen,
			GdeCostoMargen,
			
			GdeEstado,
			GdeTiempoCreacion,
			GdeTiempoModificacion) 
			VALUES (
			"'.($this->GdeId).'", 
			"'.($this->GarId).'", 
			
			'.(empty($this->AmdId)?'NULL,':'"'.$this->AmdId.'",').'	

			'.(empty($this->ProId)?'NULL,':'"'.$this->ProId.'",').'	
			'.(empty($this->UmeId)?'NULL,':'"'.$this->UmeId.'",').'				

			"'.($this->GdeCodigo).'", 
			"'.($this->GdeDescripcion).'", 

			'.($this->GdeCosto).', 	
			'.($this->GdeCantidad).',
			'.($this->GdeCostoTotal).', 	
			
			'.($this->GdeMargen).', 	
			'.($this->GdeCostoMargen).', 	
					
			
			'.($this->GdeEstado).',
			"'.($this->GdeTiempoCreacion).'",
			"'.($this->GdeTiempoModificacion).'");';
		
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
	
	public function MtdEditarGarantiaDetalle() {

			$sql = 'UPDATE tblgdegarantiadetalle SET 	
			
			'.(empty($this->ProId)?'ProId = NULL, ':'ProId = "'.$this->ProId.'",').'
			'.(empty($this->UmeId)?'UmeId = NULL, ':'UmeId = "'.$this->UmeId.'",').'
		
			GdeCodigo = "'.($this->GdeCodigo).'",
			GdeDescripcion = "'.($this->GdeDescripcion).'",
			 
			GdeCosto = '.($this->GdeCosto).',
			GdeCantidad = '.($this->GdeCantidad).',
			GdeCostoTotal = '.($this->GdeCostoTotal).',
			
			GdeMargen = '.($this->GdeMargen).',
			GdeCostoMargen = '.($this->GdeCostoMargen).'
			
			WHERE GdeId = "'.($this->GdeId).'";';
					
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