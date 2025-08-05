<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGarantiaOperacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGarantiaOperacion {

    public $GopId;
	public $GarId;

	public $GopNumero;
	
	public $GopTiempo;
	public $GopValor;
    public $GopCosto;
	public $GopComprobanteNumero;
	
	public $GopEstado;	
	public $GopTiempoCreacion;
	public $GopTiempoModificacion;
    public $GopEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	private function MtdGenerarGarantiaOperacionId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(GopId,5),unsigned)) AS "MAXIMO"
		FROM tblgopgarantiaoperacion';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->GopId = "GOP-10000";
		}else{
			$fila['MAXIMO']++;
			$this->GopId = "GOP-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerGarantiaOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GopId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGarantia=NULL,$oEstado=NULL) {

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
			$garantia = ' AND gop.GarId = "'.$oGarantia.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND gop.GopEstado = '.$oEstado.' ';
		}
			
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			gop.GopId,			
			gop.GarId,

			gop.GopNumero,

			gop.GopTiempo,
			gop.GopValor,
			gop.GopCosto,
			
			gop.GopTransaccionNumero,
			DATE_FORMAT(gop.GopTransaccionFecha, "%d/%m/%Y") AS "NGopTransaccionFecha",
			DATE_FORMAT(gop.GopFechaAprobacion, "%d/%m/%Y") AS "NGopFechaAprobacion",
			DATE_FORMAT(gop.GopFechaPago, "%d/%m/%Y") AS "NGopFechaPago",
			gop.GopComprobanteNumero,
			
			gop.GopEstado,
			DATE_FORMAT(gop.GopTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGopTiempoCreacion",
	        DATE_FORMAT(gop.GopTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGopTiempoModificacion"
			
			FROM tblgopgarantiaoperacion gop
			WHERE  1 = 1 '.$garantia.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGarantiaOperacion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GarantiaOperacion = new $InsGarantiaOperacion();
                    $GarantiaOperacion->GopId = $fila['GopId'];
                    $GarantiaOperacion->GarId = $fila['GarId'];

					$GarantiaOperacion->GopNumero = $fila['GopNumero'];  

					$GarantiaOperacion->GopTiempo = $fila['GopTiempo'];  
					$GarantiaOperacion->GopValor = $fila['GopValor'];
			        $GarantiaOperacion->GopCosto = $fila['GopCosto'];
					
					$GarantiaOperacion->GopTransaccionNumero = $fila['GopTransaccionNumero'];
					$GarantiaOperacion->GopTransaccionFecha = $fila['NGopTransaccionFecha'];
					$GarantiaOperacion->GopFechaAprobacion = $fila['NGopFechaAprobacion'];
					$GarantiaOperacion->GopFechaPago = $fila['NGopFechaPago'];
					$GarantiaOperacion->GopComprobanteNumero = $fila['GopComprobanteNumero'];
					
					$GarantiaOperacion->GopEstado = $fila['GopEstado'];
					$GarantiaOperacion->GopTiempoCreacion = $fila['NGopTiempoCreacion'];  
					$GarantiaOperacion->GopTiempoModificacion = $fila['NGopTiempoModificacion']; 					

                    $GarantiaOperacion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GarantiaOperacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarGarantiaOperacion($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (GopId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GopId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblgopgarantiaoperacion 
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
	
	
	public function MtdRegistrarGarantiaOperacion() {
	
			$this->MtdGenerarGarantiaOperacionId();
			
			
			$sql = 'INSERT INTO tblgopgarantiaoperacion (
			GopId,
			GarId,
			FaeId,
			
			GopNumero,
			
			GopTiempo,			
			GopValor,
			GopCosto,
			
			GopTransaccionNumero,
			GopTransaccionFecha,
			GopFechaAprobacion,
			GopFechaPago,
			GopComprobanteNumero,
			
			GopEstado,
			GopTiempoCreacion,
			GopTiempoModificacion) 
			VALUES (
			"'.($this->GopId).'", 
			"'.($this->GarId).'", 			
			'.(empty($this->FaeId)?'NULL,':'"'.$this->FaeId.'",').'	
			
			"'.($this->GopNumero).'", 

			'.($this->GopTiempo).', 
			'.($this->GopValor).', 	
			'.($this->GopCosto).',
			
			"'.($this->GopTransaccionNumero).'", 
			'.(empty($this->GopTransaccionFecha)?'NULL,':'"'.$this->GopTransaccionFecha.'",').'	
			'.(empty($this->GopFechaAprobacion)?'NULL,':'"'.$this->GopFechaAprobacion.'",').'	
			'.(empty($this->GopFechaPago)?'NULL,':'"'.$this->GopFechaPago.'",').'	
			"'.($this->GopComprobanteNumero).'", 
			
			'.($this->GopEstado).',
			"'.($this->GopTiempoCreacion).'",
			"'.($this->GopTiempoModificacion).'");';
		
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
	
	public function MtdEditarGarantiaOperacion() {

			$sql = 'UPDATE tblgopgarantiaoperacion SET 	
			
			GopNumero = "'.($this->GopNumero).'",

			GopTiempo = '.($this->GopTiempo).',			 
			GopValor = '.($this->GopValor).',
			GopCosto = '.($this->GopCosto).',
			
			GopTransaccionNumero = "'.($this->GopTransaccionNumero).'",
			'.(empty($this->GopTransaccionFecha)?'GopTransaccionFecha = NULL, ':'GopTransaccionFecha = "'.$this->GopTransaccionFecha.'",').'
			'.(empty($this->GopFechaAprobacion)?'GopFechaAprobacion = NULL, ':'GopFechaAprobacion = "'.$this->GopFechaAprobacion.'",').'
			'.(empty($this->GopFechaPago)?'GopFechaPago = NULL, ':'GopFechaPago = "'.$this->GopFechaPago.'",').'
			GopComprobanteNumero = "'.($this->GopComprobanteNumero).'",
			
			GopTiempoModificacion = "'.($this->GopTiempoModificacion).'"
			 
			WHERE GopId = "'.($this->GopId).'";';
					
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
		
		
		
		public function MtdEditarGarantiaOperacionDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblgopgarantiaoperacion SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			GopTiempoModificacion = NOW()
			WHERE GopId = "'.($oId).'";';
			
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