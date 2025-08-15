<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoVehiculoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoVehiculoDetalle {

	public $TvdId;
	public $TveId;
	public $EinId;
	public $UmeId;
    public $TvdCantidad;	

	public $TvdIdAnterior;
	public $TvdCosto;
	public $TvdCostoAnterior;
	public $TvdCostoExtraTotal;
	public $TvdCostoExtraUnitario;
	public $TvdImporte;	
	public $TvdCostoPromedio;

	public $TvdCaracteristica1;
	public $TvdCaracteristica2;
	public $TvdCaracteristica3;
	public $TvdCaracteristica4;
	public $TvdCaracteristica5;
	public $TvdCaracteristica6;
	public $TvdCaracteristica7;
	public $TvdCaracteristica8;
	public $TvdCaracteristica9;

	public $TvdCaracteristica10;
	public $TvdCaracteristica11;
	public $TvdNacionalTotalOtroCosto;	

	public $TvdEstado;	
	public $TvdTiempoCreacion;
	public $TvdTiempoModificacion;
	public $TvdEliminado;

	public $EinVIN;
	public $EinNumeroMotor;
	public $EinColor;
	public $EinColorInterno;
	public $EinAnoFabricacion;
	public $UmeNombre;
	public $UmeAbreviacion;

	public $TveFecha;
	public $TveComprobanteNumero;
	public $TveComprobanteFecha;
	public $CtiNombre;
	
	public $TveTotalNacional;
	public $TveTotalInternacional;
	
	public $TveSubTotal;
	
	public $PrvNombreCompleto;
	public $PrvNumeroDocumento;
	
	public $TopNombre;
	

	
	// public $TvdId;
//	public $TveId;
//	public $EinId;
//	public $UmeId;
//    public $TvdCantidad;	
//	public $TvdCantidadReal;
//	public $TvdCosto;
//	public $TvdCostoAnterior;
//	public $TvdCostoTotal;
//	public $TvdImporte;	
//	public $TvdEstado;	
//	public $TvdTiempoCreacion;
//	public $TvdTiempoModificacion;
//    public $TvdEliminado;
//	
//	public $EinVIN;
//	public $EinNumeroMotor;
//	public $EinColor;
//	public $EinColorInterno;
//	public $EinAnoFabricacion;
//	
//	public $UmeNombre;
	
	
	
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

	private function MtdGenerarTrasladoVehiculoDetalleId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TvdId,5),unsigned)) AS "MAXIMO"
			FROM tbltvdtrasladovehiculodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TvdId = "TVD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TvdId = "TVD-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerTrasladoVehiculoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoVehiculo=NULL,$oEstado=NULL) {

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
		
		if(!empty($oTrasladoVehiculo)){
			$amovimiento = ' AND tvd.TveId = "'.$oTrasladoVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND tvd.TvdEstado = '.$oEstado.' ';
		}
		
	
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			tvd.TvdId,			
			tvd.TveId,
			tvd.EinId,
			tvd.VehId,
			tvd.UmeId,			

			tvd.TvdCantidad,
			tvd.TvdCosto,
			tvd.TvdImporte,
			
			tvd.TvdDescripcion,
			tvd.TvdObservacion,
			
			tvd.TvdEstado,
			DATE_FORMAT(tvd.TvdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTvdTiempoCreacion",
	        DATE_FORMAT(tvd.TvdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTvdTiempoModificacion",
			
			ein.EinVIN,
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ein.EinAnoModelo,

			ume.UmeNombre,
			ume.UmeAbreviacion,
			
			vve.VveNombre,
			vmo.VmoNombre,
			vma.VmaNombre,
			
			ein.VveId,
			vve.VmoId,
			vmo.VmaId,
			
			veh.VehCodigoIdentificador

			FROM tbltvdtrasladovehiculodetalle tvd
				LEFT JOIN tbleinvehiculoingreso ein
				ON tvd.EinId = ein.EinId
					LEFT JOIN tblvehvehiculo veh
					ON tvd.VehId = veh.VehId
					
					LEFT JOIN tblumeunidadmedida ume
					ON tvd.UmeId = ume.UmeId
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
							
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoVehiculoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoVehiculoDetalle = new $InsTrasladoVehiculoDetalle();
                    $TrasladoVehiculoDetalle->TvdId = $fila['TvdId'];
                    $TrasladoVehiculoDetalle->TveId = $fila['TveId'];
					
					
					$TrasladoVehiculoDetalle->EinId = $fila['EinId'];	
					$TrasladoVehiculoDetalle->VehId = $fila['VehId'];	
					$TrasladoVehiculoDetalle->UmeId = $fila['UmeId'];
					
			        $TrasladoVehiculoDetalle->TvdCosto = $fila['TvdCosto'];  
					$TrasladoVehiculoDetalle->TvdCantidad = $fila['TvdCantidad'];  
					$TrasladoVehiculoDetalle->TvdImporte = $fila['TvdImporte'];  
					
					$TrasladoVehiculoDetalle->TvdDescripcion = $fila['TvdDescripcion'];  
					$TrasladoVehiculoDetalle->TvdObservacion = $fila['TvdObservacion'];  
					
					$TrasladoVehiculoDetalle->TvdEstado = $fila['TvdEstado'];  
					$TrasladoVehiculoDetalle->TvdTiempoCreacion = $fila['NTvdTiempoCreacion'];  
					$TrasladoVehiculoDetalle->TvdTiempoModificacion = $fila['NTvdTiempoModificacion']; 	
									
                    $TrasladoVehiculoDetalle->EinVIN = (($fila['EinVIN']));
					$TrasladoVehiculoDetalle->EinNumeroMotor = (($fila['EinNumeroMotor']));
					$TrasladoVehiculoDetalle->EinColor = (($fila['EinColor']));					
					$TrasladoVehiculoDetalle->EinColorInterno = (($fila['EinColorInterno']));
					$TrasladoVehiculoDetalle->EinAnoFabricacion = (($fila['EinAnoFabricacion']));
					$TrasladoVehiculoDetalle->EinAnoModelo = (($fila['EinAnoModelo']));
					
					$TrasladoVehiculoDetalle->UmeNombre = (($fila['UmeNombre']));
					$TrasladoVehiculoDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
			
					$TrasladoVehiculoDetalle->VveNombre = (($fila['VveNombre']));					
					$TrasladoVehiculoDetalle->VmoNombre = (($fila['VmoNombre']));
					$TrasladoVehiculoDetalle->VmaNombre = (($fila['VmaNombre']));
					$TrasladoVehiculoDetalle->VveId = (($fila['VveId']));
					$TrasladoVehiculoDetalle->VmoId = (($fila['VmoId']));
					$TrasladoVehiculoDetalle->VmaId = (($fila['VmaId']));
					
					$TrasladoVehiculoDetalle->VehCodigoIdentificador = (($fila['VehCodigoIdentificador']));
				
				
                    $TrasladoVehiculoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoVehiculoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
  public function MtdObtenerTrasladoVehiculoDetallesValor($oFuncion="SUM",$oParametro="TveTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoVehiculo=NULL,$oEstado=NULL,$oVehiculoId=NULL) {

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
		
		if(!empty($oTrasladoVehiculo)){
			$amovimiento = ' AND tvd.TveId = "'.$oTrasladoVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND tvd.TvdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehiculoId)){
			$vehiculo = ' AND tvd.VehId = '.$oVehiculoId.' ';
		}
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(cvh.TveFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(cvh.TveFecha) ="'.($oAno).'"';
		}
		
	
			$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			FROM tbltvdtrasladovehiculodetalle tvd
				
				LEFT JOIN tbleinvehiculoingreso ein
				ON tvd.EinId = ein.EinId
				
					LEFT JOIN tblumeunidadmedida ume
					ON tvd.UmeId = ume.UmeId	
						
						LEFT  JOIN tblcvhcompravehiculo cvh
						ON tvd.TveId = cvh.TveId
				
							LEFT JOIN tbltoptipooperacion top
							ON cvh.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON cvh.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON cvh.CtiId = cti.CtiId

			WHERE  1 = 1 '.$ano.$mes.$amovimiento.$producto.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$amestado.$vehiculo.$vmarca.$ptipo.$dinactivo.$orden.$paginacion;	
					
					
//							(
//				SELECT 
//				DATE_FORMAT(cvh2.TveFecha, "%d/%m/%Y") 
//				FROM tbltvdtrasladovehiculodetalle cvd2
//					LEFT JOIN tblcvhcompravehiculo cvh2
//					ON cvd2.TveId = cvh2.TveId
//						WHERE cvh2.TveTipo = 2
//						AND cvd2.EinId = tvd.EinId
//				ORDER BY cvh2.TveFecha DESC
//				LIMIT 1
//
//			) AS TveFechaUltimaSalida,
//			
//
//
//
//			IFNULL(
//				(SELECT 
//				DATE_FORMAT(cvh2.TveFecha, "%d/%m/%Y") 
//				FROM tbltvdtrasladovehiculodetalle cvd2
//					LEFT JOIN tblcvhcompravehiculo cvh2
//					ON cvd2.TveId = cvh2.TveId
//						WHERE cvh2.TveTipo = 2
//						AND cvd2.EinId = tvd.EinId
//				ORDER BY cvh2.TveFecha DESC
//				LIMIT 1),NOW()
//			) 
//			
//						
//			(TIMESTAMPDIFF(DAY, @TveFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS TveUltimaSalidaDiaTranscurridos
//			
//			
//			
//			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}		
		
	//Accion eliminar	 
	
	public function MtdEliminarTrasladoVehiculoDetalle($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
//					if($i==count($elementos)){						
//						$eliminar .= '  (TvdId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (TvdId = "'.($elemento).'")  OR';	
//					}	

					if(!$error) {		
						$sql = 'DELETE FROM tbltvdtrasladovehiculodetalle WHERE  (TvdId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		
//				$sql = 'DELETE FROM tbltvdtrasladovehiculodetalle 
//				WHERE '.$eliminar;
//							
//				$error = false;
//	
//				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//				
//				if(!$resultado) {						
//					$error = true;
//				} 	
//				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	


	public function MtdRegistrarTrasladoVehiculoDetalle() {
	
			$this->MtdGenerarTrasladoVehiculoDetalleId();
			
			$sql = 'INSERT INTO tbltvdtrasladovehiculodetalle (
			TvdId,
			TveId,	
			
			EinId,
			VehId,
			UmeId,
			
			TvdCantidad,
			TvdCosto,
			TvdImporte,
			
			TvdObservacion,
			TvdDescripcion,
		
			TvdEstado,
			TvdTiempoCreacion,
			TvdTiempoModificacion
			) 
			VALUES (
			"'.($this->TvdId).'", 
			"'.($this->TveId).'", 
			
			"'.($this->EinId).'",
			"'.($this->VehId).'",
			"'.($this->UmeId).'",
		
			'.($this->TvdCantidad).',
			'.($this->TvdCosto).',
			'.($this->TvdImporte).',
			
			"'.($this->TvdObservacion).'",
			"'.($this->TvdDescripcion).'",

			'.($this->TvdEstado).',
			"'.($this->TvdTiempoCreacion).'",
			"'.($this->TvdTiempoModificacion).'");';					
		
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
	
	public function MtdEditarTrasladoVehiculoDetalle() {

			$sql = 'UPDATE tbltvdtrasladovehiculodetalle SET 	
			
			EinId = "'.trim($this->EinId).'",
			VehId = "'.trim($this->VehId).'",
			UmeId = "'.trim($this->UmeId).'",
			
			TvdCantidad = '.($this->TvdCantidad).',	
			TvdCosto = '.($this->TvdCosto).',	
			TvdImporte = '.($this->TvdImporte).',	
			
			TvdDescripcion = "'.($this->TvdDescripcion).'",
			TvdObservacion = "'.($this->TvdObservacion).'",
			
			TvdEstado = '.($this->TvdEstado).'
			WHERE TvdId = "'.($this->TvdId).'";';
					
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


	public function MtdEditarTrasladoVehiculoDetalleDato($oCampo,$oDato,$oTrasladoVehiculoDetalleId) {

			$sql = 'UPDATE tbltvdtrasladovehiculodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE TvdId = "'.($oTrasladoVehiculoDetalleId).'";';
					
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