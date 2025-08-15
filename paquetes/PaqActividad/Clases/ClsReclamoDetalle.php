<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReclamoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReclamoDetalle {

    public $RdeId;
	public $RecId;
	
	public $AmdId;

	public $RdeObservacion;
    public $RdeCantidad;
	public $RdePrecioUnitario;
	public $RdeMonto;
	
	public $RdeEstado;	
	public $RdeTiempoCreacion;
	public $RdeTiempoModificacion;
    public $RdeEliminado;
	
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

	private function MtdGenerarReclamoDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RdeId,5),unsigned)) AS "MAXIMO"
			FROM tblrdereclamodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RdeId = "RDE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->RdeId = "RDE-".$fila['MAXIMO'];					
			}
				
	}

    public function MtdObtenerReclamoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oReclamo=NULL,$oEstado=NULL,$oAlmacenMovimientoDetalle=NULL) {

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
		
		if(!empty($oReclamo)){
			$reclamo = ' AND rde.RecId = "'.$oReclamo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND rde.RdeEstado = '.$oEstado.' ';
		}
		
		if(!empty($oAlmacenMovimientoDetalle)){
			$adetalle = ' AND (rde.AmdId = "'.$oAlmacenMovimientoDetalle.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			rde.RdeId,			
			rde.RecId,
			
			rde.AmdId,
		
			rde.RdeObservacion,

			rde.RdeCantidad,
			rde.RdePrecioUnitario,
			rde.RdeMonto,
	
			rde.RdeEstado,
			DATE_FORMAT(rde.RdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRdeTiempoCreacion",
	        DATE_FORMAT(rde.RdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRdeTiempoModificacion",
			
			amd.AmdCosto,
			amd.AmdCantidad,
			
			pro.ProCodigoOriginal,
			pro.ProNombre,
			
			amo.AmoComprobanteNumero,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			
			oco.OcoTipo
			
			FROM tblrdereclamodetalle rde
				LEFT JOIN tblamdalmacenmovimientodetalle amd
				ON rde.AmdId = amd.AmdId
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
							LEFT JOIN tblocoordencompra oco
							ON amo.OcoId = oco.OcoId
							
			WHERE  1 = 1 '.$reclamo.$estado.$adetalle.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReclamoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReclamoDetalle = new $InsReclamoDetalle();
                    $ReclamoDetalle->RdeId = $fila['RdeId'];
                    $ReclamoDetalle->RecId = $fila['RecId'];
					
					$ReclamoDetalle->AmdId = $fila['AmdId'];
					
					$ReclamoDetalle->RdeObservacion = $fila['RdeObservacion'];  
			
			        $ReclamoDetalle->RdeCantidad = $fila['RdeCantidad'];  
					$ReclamoDetalle->RdePrecioUnitario = $fila['RdePrecioUnitario'];
					$ReclamoDetalle->RdeMonto = $fila['RdeMonto'];
					
					$ReclamoDetalle->RdeEstado = $fila['RdeEstado'];
					$ReclamoDetalle->RdeTiempoCreacion = $fila['NRdeTiempoCreacion'];  
					$ReclamoDetalle->RdeTiempoModificacion = $fila['NRdeTiempoModificacion'];
					
					$ReclamoDetalle->AmdCosto = $fila['AmdCosto'];
					$ReclamoDetalle->AmdCantidad = $fila['AmdCantidad'];
					
					$ReclamoDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ReclamoDetalle->ProNombre = $fila['ProNombre'];
					
					$ReclamoDetalle->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];
					$ReclamoDetalle->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];
					
					$ReclamoDetalle->OcoTipo = $fila['OcoTipo']; 					

                    $ReclamoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReclamoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarReclamoDetalle($oElementos) {
		
//		$InsReclamoDetalleOrigen = new ClsReclamoDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (RdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (RdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblrdereclamodetalle 
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
	
	
	public function MtdRegistrarReclamoDetalle() {
	
			$this->MtdGenerarReclamoDetalleId();
			
			$sql = 'INSERT INTO tblrdereclamodetalle (
			RdeId,
			RecId,
			
			AmdId,
			
			RdeObservacion,
		
			RdeCantidad,
			RdePrecioUnitario,
			RdeMonto,
			
			RdeEstado,
			RdeTiempoCreacion,
			RdeTiempoModificacion) 
			VALUES (
			"'.($this->RdeId).'", 
			"'.($this->RecId).'", 

			'.(empty($this->AmdId)?'NULL,':'"'.$this->AmdId.'",').'	
			
			"'.($this->RdeObservacion).'", 

			'.($this->RdeCantidad).',
			'.($this->RdePrecioUnitario).',
			'.($this->RdeMonto).', 	
			
			'.($this->RdeEstado).',
			"'.($this->RdeTiempoCreacion).'",
			"'.($this->RdeTiempoModificacion).'");';
		
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
	
	public function MtdEditarReclamoDetalle() {

			$sql = 'UPDATE tblrdereclamodetalle SET 	
			
			RdeObservacion = "'.($this->RdeObservacion).'",
			 
			RdeCantidad = '.($this->RdeCantidad).',
			RdePrecioUnitario = '.($this->RdePrecioUnitario).',
			RdeMonto = '.($this->RdeMonto).',
			
			RdeTiempoModificacion = "'.($this->RdeTiempoModificacion).'"
			
			WHERE RdeId = "'.($this->RdeId).'";';
					
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