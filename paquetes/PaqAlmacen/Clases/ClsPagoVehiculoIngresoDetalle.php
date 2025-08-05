<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPagoVehiculoIngresoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPagoVehiculoIngresoDetalle {

	public $PvdId;
	public $PviId;
	public $EinId;
	public $UmeId;
    public $PvdCantidad;	

	public $PvdIdAnterior;
	public $PvdCosto;
	public $PvdCostoAnterior;
	public $PvdCostoExtraTotal;
	public $PvdCostoExtraUnitario;
	public $PvdImporte;	
	public $PvdCostoPromedio;

	public $PvdCaracteristica1;
	public $PvdCaracteristica2;
	public $PvdCaracteristica3;
	public $PvdCaracteristica4;
	public $PvdCaracteristica5;
	public $PvdCaracteristica6;
	public $PvdCaracteristica7;
	public $PvdCaracteristica8;
	public $PvdCaracteristica9;

	public $PvdCaracteristica10;
	public $PvdCaracteristica11;
	public $PvdNacionalTotalOtroCosto;	

	public $PvdEstado;	
	public $PvdTiempoCreacion;
	public $PvdTiempoModificacion;
	public $PvdEliminado;

	public $EinVIN;
	public $EinNumeroMotor;
	public $EinColor;
	public $EinColorInterno;
	public $EinAnoFabricacion;
	public $UmeNombre;
	public $UmeAbreviacion;

	public $PviFecha;
	public $PviComprobanteNumero;
	public $PviComprobanteFecha;
	public $CtiNombre;
	
	public $PviTotalNacional;
	public $PviTotalInternacional;
	
	public $PviSubTotal;
	
	public $PrvNombreCompleto;
	public $PrvNumeroDocumento;
	
	public $TopNombre;
	

	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarPagoVehiculoIngresoDetalleId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PvdId,5),unsigned)) AS "MAXIMO"
			FROM tblpvdpagovehiculoingresodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PvdId = "PVD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PvdId = "PVD-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerPagoVehiculoIngresoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oCompraVehiculo)){
			$amovimiento = ' AND pvd.PviId = "'.$oCompraVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pvd.PvdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (pvi.SucId = "'.$oSucursal.'") ';
		}
		
		
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pvd.PvdId,			
			pvd.PviId,
			pvd.EinId,
								
			pvd.PvdCosto,			
			pvd.PvdCantidad,
			pvd.PvdObservacion,			
			pvd.PvdImporte,
			
			pvd.PvdEstado,
			DATE_FORMAT(pvd.PvdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPvdTiempoCreacion",
	        DATE_FORMAT(pvd.PvdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPvdTiempoModificacion",
			
			ein.EinVIN,
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ein.EinAnoModelo,
			
			DATE_FORMAT(pvi.PviFecha, "%d/%m/%Y") AS "NPviFecha",
			pvi.PviComprobanteNumero,
			DATE_FORMAT(pvi.PviComprobanteFecha, "%d/%m/%Y") AS "NPviComprobanteFecha",
			
			pvi.PviSubTotal,

			pvi.PviComprobanteNumero,
			DATE_FORMAT(pvi.PviComprobanteFecha, "%d/%m/%Y") AS "NPviComprobanteFecha",

			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre
			
			FROM tblpvdpagovehiculoingresodetalle pvd
			
				LEFT JOIN tbleinvehiculoingreso ein
				ON pvd.EinId = ein.EinId
					
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
				
						LEFT  JOIN tblpvipagovehiculoingreso pvi
						ON pvd.PviId = pvi.PviId
						
							
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$ctipo.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPagoVehiculoIngresoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PagoVehiculoIngresoDetalle = new $InsPagoVehiculoIngresoDetalle();
                    $PagoVehiculoIngresoDetalle->PvdId = $fila['PvdId'];
                    $PagoVehiculoIngresoDetalle->PviId = $fila['PviId'];
					$PagoVehiculoIngresoDetalle->EinId = $fila['EinId'];
															
					$PagoVehiculoIngresoDetalle->PvdCosto = $fila['PvdCosto'];				
			        $PagoVehiculoIngresoDetalle->PvdCantidad = $fila['PvdCantidad'];  
					$PagoVehiculoIngresoDetalle->PvdObservacion = $fila['PvdObservacion'];  					
					$PagoVehiculoIngresoDetalle->PvdImporte = $fila['PvdImporte'];
									
					$PagoVehiculoIngresoDetalle->PvdEstado = $fila['PvdEstado'];  
					$PagoVehiculoIngresoDetalle->PvdTiempoCreacion = $fila['NPvdTiempoCreacion'];  
					$PagoVehiculoIngresoDetalle->PvdTiempoModificacion = $fila['NPvdTiempoModificacion']; 	
									
					$PagoVehiculoIngresoDetalle->EinId = $fila['EinId'];	
					
					$PagoVehiculoIngresoDetalle->PviFecha = $fila['NPviFecha'];	
					$PagoVehiculoIngresoDetalle->PviComprobanteNumero = $fila['PviComprobanteNumero'];	
					$PagoVehiculoIngresoDetalle->PviComprobanteFecha = $fila['NPviComprobanteFecha'];	
										
					$PagoVehiculoIngresoDetalle->PviSubTotal = $fila['PviSubTotal'];
	
                    $PagoVehiculoIngresoDetalle->EinVIN = (($fila['EinVIN']));
					$PagoVehiculoIngresoDetalle->EinNumeroMotor = (($fila['EinNumeroMotor']));
					$PagoVehiculoIngresoDetalle->EinColor = (($fila['EinColor']));					
					$PagoVehiculoIngresoDetalle->EinColorInterno = (($fila['EinColorInterno']));
					$PagoVehiculoIngresoDetalle->EinAnoFabricacion = (($fila['EinAnoFabricacion']));
					$PagoVehiculoIngresoDetalle->EinAnoModelo = (($fila['EinAnoModelo']));
					
					$PagoVehiculoIngresoDetalle->PviComprobanteNumero = (($fila['PviComprobanteNumero']));
					$PagoVehiculoIngresoDetalle->PviComprobanteFecha = (($fila['NPviComprobanteFecha']));
					
					$PagoVehiculoIngresoDetalle->VmaNombre = (($fila['VmaNombre']));
					$PagoVehiculoIngresoDetalle->VmoNombre = (($fila['VmoNombre']));
					$PagoVehiculoIngresoDetalle->VveNombre = (($fila['VveNombre']));
					
                    $PagoVehiculoIngresoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PagoVehiculoIngresoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
  public function MtdObtenerPagoVehiculoIngresoDetallesValor($oFuncion="SUM",$oParametro="PviTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL) {

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
		
		if(!empty($oCompraVehiculo)){
			$amovimiento = ' AND pvd.PviId = "'.$oCompraVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pvd.PvdEstado = '.$oEstado.' ';
		}
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(pvi.PviFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(pvi.PviFecha) ="'.($oAno).'"';
		}
		
	
			$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			FROM tblpvdpagovehiculoingresodetalle pvd
				
				LEFT JOIN tbleinvehiculoingreso ein
				ON pvd.EinId = ein.EinId
				
					LEFT  JOIN tblpvipagovehiculoingreso pvi
					ON pvd.PviId = pvi.PviId
				
						

			WHERE  1 = 1 '.$ano.$mes.$amovimiento.$producto.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$amestado.$vehiculo.$vmarca.$ptipo.$dinactivo.$orden.$paginacion;	
					
				
	
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}		
		
	//Accion eliminar	 
	
	public function MtdEliminarPagoVehiculoIngresoDetalle($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				

					if(!$error) {		
						$sql = 'DELETE FROM tblpvdpagovehiculoingresodetalle WHERE  (PvdId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	
	
	
	public function MtdActualizarEstadoPagoVehiculoIngresoDetalle($oElementos,$oEstado) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				

					if(!$error) {		
						$sql = 'UPDATE tblpvdpagovehiculoingresodetalle SET PvdEstado = '.$oEstado.' WHERE  (PvdId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	


	public function MtdRegistrarPagoVehiculoIngresoDetalle() {
	
			$this->MtdGenerarPagoVehiculoIngresoDetalleId();
			
			$sql = 'INSERT INTO tblpvdpagovehiculoingresodetalle (
			PvdId,
			PviId,	
			EinId,
		
			PvdCosto,	
			PvdCantidad,
			PvdImporte,		
			PvdObservacion,
					
			PvdEstado,
			PvdTiempoCreacion,
			PvdTiempoModificacion
			) 
			VALUES (
			"'.($this->PvdId).'", 
			"'.($this->PviId).'", 
			"'.($this->EinId).'",
		
			'.($this->PvdCosto).',		
			'.($this->PvdCantidad).',
			'.($this->PvdImporte).',			
			"'.($this->PvdObservacion).'",

			'.($this->PvdEstado).',
			"'.($this->PvdTiempoCreacion).'",
			"'.($this->PvdTiempoModificacion).'");';					
		
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
	
	public function MtdEditarPagoVehiculoIngresoDetalle() {

			$sql = 'UPDATE tblpvdpagovehiculoingresodetalle SET 	
			
			EinId = "'.trim($this->EinId).'",

		
			PvdCosto = '.($this->PvdCosto).',		
			PvdCantidad = '.($this->PvdCantidad).',		
			PvdImporte = '.($this->PvdImporte).',			
		
			PvdObservacion = "'.($this->PvdObservacion).'",
					
			PvdEstado = '.($this->PvdEstado).'
			WHERE PvdId = "'.($this->PvdId).'";';
					
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
		
		
	//public function MtdEditarProductoDato($oCampo,$oDato,$oProductoId) {


	public function MtdEditarPagoVehiculoIngresoDetalleDato($oCampo,$oDato,$oPagoVehiculoIngresoDetalleId) {

			$sql = 'UPDATE tblpvdpagovehiculoingresodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE PvdId = "'.($oPagoVehiculoIngresoDetalleId).'";';
					
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