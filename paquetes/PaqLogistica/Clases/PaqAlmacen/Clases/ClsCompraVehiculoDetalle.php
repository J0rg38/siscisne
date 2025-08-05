<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCompraVehiculoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCompraVehiculoDetalle {

	public $CvdId;
	public $CvhId;
	public $EinId;
	public $UmeId;
    public $CvdCantidad;	

	public $CvdIdAnterior;
	public $CvdCosto;
	public $CvdCostoAnterior;
	public $CvdCostoExtraTotal;
	public $CvdCostoExtraUnitario;
	public $CvdImporte;	
	public $CvdCostoPromedio;

	public $CvdCaracteristica1;
	public $CvdCaracteristica2;
	public $CvdCaracteristica3;
	public $CvdCaracteristica4;
	public $CvdCaracteristica5;
	public $CvdCaracteristica6;
	public $CvdCaracteristica7;
	public $CvdCaracteristica8;
	public $CvdCaracteristica9;

	public $CvdCaracteristica10;
	public $CvdCaracteristica11;
	public $CvdNacionalTotalOtroCosto;	

	public $CvdEstado;	
	public $CvdTiempoCreacion;
	public $CvdTiempoModificacion;
	public $CvdEliminado;

	public $EinVIN;
	public $EinNumeroMotor;
	public $EinColor;
	public $EinColorInterno;
	public $EinAnoFabricacion;
	public $UmeNombre;
	public $UmeAbreviacion;

	public $CvhFecha;
	public $CvhComprobanteNumero;
	public $CvhComprobanteFecha;
	public $CtiNombre;
	
	public $CvhTotalNacional;
	public $CvhTotalInternacional;
	
	public $CvhSubTotal;
	
	public $PrvNombreCompleto;
	public $PrvNumeroDocumento;
	
	public $TopNombre;
	

	
	// public $CvdId;
//	public $CvhId;
//	public $EinId;
//	public $UmeId;
//    public $CvdCantidad;	
//	public $CvdCantidadReal;
//	public $CvdCosto;
//	public $CvdCostoAnterior;
//	public $CvdCostoTotal;
//	public $CvdImporte;	
//	public $CvdEstado;	
//	public $CvdTiempoCreacion;
//	public $CvdTiempoModificacion;
//    public $CvdEliminado;
//	
//	public $EinVIN;
//	public $EinNumeroMotor;
//	public $EinColor;
//	public $EinColorInterno;
//	public $EinAnoFabricacion;
//	
//	public $UmeNombre;
	
	
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarCompraVehiculoDetalleId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CvdId,5),unsigned)) AS "MAXIMO"
			FROM tblcvdcompravehiculodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CvdId = "CVD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CvdId = "CVD-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerCompraVehiculoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL) {

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
			$amovimiento = ' AND cvd.CvhId = "'.$oCompraVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND cvd.CvdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehiculo)){
			$producto = ' AND (cvd.VehId = "'.$oVehiculo.'") ';
		}
		
	
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			cvd.CvdId,			
			cvd.CvhId,
			cvd.EinId,
			
			cvd.UmeId,			
			cvd.CvdIdAnterior,
			
			cvd.CvdCosto,
			cvd.CvdCostoAnterior,
			cvd.CvdCostoExtraTotal,
			cvd.CvdCostoExtraUnitario,
			cvd.CvdValorTotal,
			cvd.CvdCantidad,
		
			cvd.CvdImporte,
			cvd.CvdCostoPromedio,

			cvd.CvdCaracteristica1,
			cvd.CvdCaracteristica2,
			cvd.CvdCaracteristica3,
			cvd.CvdCaracteristica4,
			cvd.CvdCaracteristica5,
			cvd.CvdCaracteristica6,
			cvd.CvdCaracteristica7,
			cvd.CvdCaracteristica8,
			cvd.CvdCaracteristica9,
			cvd.CvdCaracteristica10,
			cvd.CvdCaracteristica12,
			cvd.CvdCaracteristica13,
			cvd.CvdCaracteristica14,
			cvd.CvdCaracteristica15,
			cvd.CvdCaracteristica16,
			cvd.CvdCaracteristica17,
			cvd.CvdCaracteristica18,
			cvd.CvdCaracteristica19,
			cvd.CvdCaracteristica20,
			
			cvd.CvdEstado,
			DATE_FORMAT(cvd.CvdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCvdTiempoCreacion",
	        DATE_FORMAT(cvd.CvdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCvdTiempoModificacion",
			
			ein.EinVIN,
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ein.EinAnoModelo,

			ume.UmeNombre,
			ume.UmeAbreviacion,

			DATE_FORMAT(cvh.CvhFecha, "%d/%m/%Y") AS "NCvhFecha",
			cvh.CvhComprobanteNumero,
			DATE_FORMAT(cvh.CvhComprobanteFecha, "%d/%m/%Y") AS "NCvhComprobanteFecha",
			cti.CtiNombre,

			cvh.CvhSubTotal,

			prv.PrvNombreCompleto,
			prv.PrvNumeroDocumento,

			top.TopNombre,

			cvh.CvhComprobanteNumero,
			DATE_FORMAT(cvh.CvhComprobanteFecha, "%d/%m/%Y") AS "NCvhComprobanteFecha",

			cvh.TopId,

			(
				SELECT 
				DATE_FORMAT(cvh2.CvhFecha, "%d/%m/%Y") 
				FROM tblcvdcompravehiculodetalle cvd2
					LEFT JOIN tblcvhcompravehiculo cvh2
					ON cvd2.CvhId = cvh2.CvhId
						WHERE  cvd2.EinId = cvd.EinId
				ORDER BY cvh2.CvhFecha DESC
				LIMIT 1

			) AS CvhFechaUltimaSalida,

			(TIMESTAMPDIFF(DAY, @CvhFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS CvhUltimaSalidaDiaTranscurridos

			FROM tblcvdcompravehiculodetalle cvd

				LEFT JOIN tbleinvehiculoingreso ein
				ON cvd.EinId = ein.EinId
				
					LEFT JOIN tblumeunidadmedida ume
					ON cvd.UmeId = ume.UmeId							
									
						LEFT  JOIN tblcvhcompravehiculo cvh
						ON cvd.CvhId = cvh.CvhId
						
							LEFT JOIN tbltoptipooperacion top
							ON cvh.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON cvh.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON cvh.CtiId = cti.CtiId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCompraVehiculoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CompraVehiculoDetalle = new $InsCompraVehiculoDetalle();
                    $CompraVehiculoDetalle->CvdId = $fila['CvdId'];
                    $CompraVehiculoDetalle->CvhId = $fila['CvhId'];
					$CompraVehiculoDetalle->UmeId = $fila['UmeId'];
					
					$CompraVehiculoDetalle->CvdIdAnterior = $fila['CvdIdAnterior'];
					$CompraVehiculoDetalle->CvdCosto = $fila['CvdCosto'];
					$CompraVehiculoDetalle->CvdCostoAnterior = $fila['CvdCostoAnterior'];
					$CompraVehiculoDetalle->CvdCostoExtraTotal = $fila['CvdCostoExtraTotal'];
					$CompraVehiculoDetalle->CvdCostoExtraUnitario = $fila['CvdCostoExtraUnitario'];
					$CompraVehiculoDetalle->CvdValorTotal = $fila['CvdValorTotal'];
			        $CompraVehiculoDetalle->CvdCantidad = $fila['CvdCantidad'];  
					
					$CompraVehiculoDetalle->CvdImporte = $fila['CvdImporte'];
					$CompraVehiculoDetalle->CvdCostoPromedio = $fila['CvdCostoPromedio'];
					
					$CompraVehiculoDetalle->CvdCaracteristica1 = $fila['CvdCaracteristica1'];
					$CompraVehiculoDetalle->CvdCaracteristica2 = $fila['CvdCaracteristica2'];
					$CompraVehiculoDetalle->CvdCaracteristica3 = $fila['CvdCaracteristica3'];
					$CompraVehiculoDetalle->CvdCaracteristica4 = $fila['CvdCaracteristica4'];
					$CompraVehiculoDetalle->CvdCaracteristica5 = $fila['CvdCaracteristica5'];
					$CompraVehiculoDetalle->CvdCaracteristica6 = $fila['CvdCaracteristica6'];
					$CompraVehiculoDetalle->CvdCaracteristica7 = $fila['CvdCaracteristica7'];
					$CompraVehiculoDetalle->CvdCaracteristica8 = $fila['CvdCaracteristica8'];
					$CompraVehiculoDetalle->CvdCaracteristica9 = $fila['CvdCaracteristica9'];					
					$CompraVehiculoDetalle->CvdCaracteristica10 = $fila['CvdCaracteristica10'];
					$CompraVehiculoDetalle->CvdCaracteristica11 = $fila['CvdCaracteristica11'];
					$CompraVehiculoDetalle->CvdCaracteristica12 = $fila['CvdCaracteristica12'];
					$CompraVehiculoDetalle->CvdCaracteristica13 = $fila['CvdCaracteristica13'];
					$CompraVehiculoDetalle->CvdCaracteristica14 = $fila['CvdCaracteristica14'];
					$CompraVehiculoDetalle->CvdCaracteristica15 = $fila['CvdCaracteristica15'];
					$CompraVehiculoDetalle->CvdCaracteristica16 = $fila['CvdCaracteristica16'];
					$CompraVehiculoDetalle->CvdCaracteristica17 = $fila['CvdCaracteristica17'];
					$CompraVehiculoDetalle->CvdCaracteristica18 = $fila['CvdCaracteristica18'];
					$CompraVehiculoDetalle->CvdCaracteristica19 = $fila['CvdCaracteristica19'];
					$CompraVehiculoDetalle->CvdCaracteristica20 = $fila['CvdCaracteristica20'];
					
					$CompraVehiculoDetalle->CvdEstado = $fila['CvdEstado'];  
					$CompraVehiculoDetalle->CvdTiempoCreacion = $fila['NCvdTiempoCreacion'];  
					$CompraVehiculoDetalle->CvdTiempoModificacion = $fila['NCvdTiempoModificacion']; 	
									
					$CompraVehiculoDetalle->EinId = $fila['EinId'];	
					
					$CompraVehiculoDetalle->CvhFecha = $fila['NCvhFecha'];	
					$CompraVehiculoDetalle->CvhComprobanteNumero = $fila['CvhComprobanteNumero'];	
					$CompraVehiculoDetalle->CvhComprobanteFecha = $fila['NCvhComprobanteFecha'];	
					
					$CompraVehiculoDetalle->CtiNombre = $fila['CtiNombre'];
					
					$CompraVehiculoDetalle->CvhSubTotal = $fila['CvhSubTotal'];
	
                    $CompraVehiculoDetalle->EinVIN = (($fila['EinVIN']));
					$CompraVehiculoDetalle->EinNumeroMotor = (($fila['EinNumeroMotor']));
					$CompraVehiculoDetalle->EinColor = (($fila['EinColor']));					
					$CompraVehiculoDetalle->EinColorInterno = (($fila['EinColorInterno']));
					$CompraVehiculoDetalle->EinAnoFabricacion = (($fila['EinAnoFabricacion']));
					$CompraVehiculoDetalle->EinAnoModelo = (($fila['EinAnoModelo']));
					
					$CompraVehiculoDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$CompraVehiculoDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$CompraVehiculoDetalle->TopNombre = (($fila['TopNombre']));

					$CompraVehiculoDetalle->CvhComprobanteNumero = (($fila['CvhComprobanteNumero']));
					$CompraVehiculoDetalle->CvhComprobanteFecha = (($fila['NCvhComprobanteFecha']));

					$CompraVehiculoDetalle->TopId = (($fila['TopId']));
					
					$CompraVehiculoDetalle->CvhFechaUltimaSalida = (($fila['CvhFechaUltimaSalida']));
					$CompraVehiculoDetalle->CvhUltimaSalidaDiaTranscurridos = (($fila['CvhUltimaSalidaDiaTranscurridos']));

                    $CompraVehiculoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CompraVehiculoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
  public function MtdObtenerCompraVehiculoDetallesValor($oFuncion="SUM",$oParametro="CvhTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculoId=NULL) {

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
			$amovimiento = ' AND cvd.CvhId = "'.$oCompraVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND cvd.CvdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehiculoId)){
			$vehiculo = ' AND cvd.VehId = '.$oVehiculoId.' ';
		}
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(cvh.CvhFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(cvh.CvhFecha) ="'.($oAno).'"';
		}
		
	
			$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			FROM tblcvdcompravehiculodetalle cvd
				
				LEFT JOIN tbleinvehiculoingreso ein
				ON cvd.EinId = ein.EinId
				
					LEFT JOIN tblumeunidadmedida ume
					ON cvd.UmeId = ume.UmeId	
						
						LEFT  JOIN tblcvhcompravehiculo cvh
						ON cvd.CvhId = cvh.CvhId
				
							LEFT JOIN tbltoptipooperacion top
							ON cvh.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON cvh.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON cvh.CtiId = cti.CtiId

			WHERE  1 = 1 '.$ano.$mes.$amovimiento.$producto.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$amestado.$vehiculo.$vmarca.$ptipo.$dinactivo.$orden.$paginacion;	
					
					
//							(
//				SELECT 
//				DATE_FORMAT(cvh2.CvhFecha, "%d/%m/%Y") 
//				FROM tblcvdcompravehiculodetalle cvd2
//					LEFT JOIN tblcvhcompravehiculo cvh2
//					ON cvd2.CvhId = cvh2.CvhId
//						WHERE cvh2.CvhTipo = 2
//						AND cvd2.EinId = cvd.EinId
//				ORDER BY cvh2.CvhFecha DESC
//				LIMIT 1
//
//			) AS CvhFechaUltimaSalida,
//			
//
//
//
//			IFNULL(
//				(SELECT 
//				DATE_FORMAT(cvh2.CvhFecha, "%d/%m/%Y") 
//				FROM tblcvdcompravehiculodetalle cvd2
//					LEFT JOIN tblcvhcompravehiculo cvh2
//					ON cvd2.CvhId = cvh2.CvhId
//						WHERE cvh2.CvhTipo = 2
//						AND cvd2.EinId = cvd.EinId
//				ORDER BY cvh2.CvhFecha DESC
//				LIMIT 1),NOW()
//			) 
//			
//						
//			(TIMESTAMPDIFF(DAY, @CvhFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS CvhUltimaSalidaDiaTranscurridos
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
	
	public function MtdEliminarCompraVehiculoDetalle($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
//					if($i==count($elementos)){						
//						$eliminar .= '  (CvdId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (CvdId = "'.($elemento).'")  OR';	
//					}	

					if(!$error) {		
						$sql = 'DELETE FROM tblcvdcompravehiculodetalle WHERE  (CvdId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		
//				$sql = 'DELETE FROM tblcvdcompravehiculodetalle 
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
	


	public function MtdRegistrarCompraVehiculoDetalle() {
	
			$this->MtdGenerarCompraVehiculoDetalleId();
			
			$sql = 'INSERT INTO tblcvdcompravehiculodetalle (
			CvdId,
			CvhId,	
			EinId,
			UmeId,
			VehId,
			AlmId,
			CvdFecha,
						
			CvdIdAnterior,
			
			CvdValorTotal,
			CvdCostoPromedio,
			CvdCostoExtraUnitario,
			CvdCostoExtraTotal,
			CvdCostoAnterior,
			CvdCosto,			
			CvdCantidad,
			CvdImporte,
			CvdUbicacion,
			CvdObservacion,
			
			CvdCaracteristica1,
			CvdCaracteristica2,
			CvdCaracteristica3,
			CvdCaracteristica4,
			CvdCaracteristica5,
			CvdCaracteristica6,
			CvdCaracteristica7,
			CvdCaracteristica8,
			CvdCaracteristica9,
			CvdCaracteristica10,
			CvdCaracteristica11,
			CvdCaracteristica12,
			CvdCaracteristica13,
			CvdCaracteristica14,
			CvdCaracteristica15,
			CvdCaracteristica16,
			CvdCaracteristica17,
			CvdCaracteristica18,
			CvdCaracteristica19,
			CvdCaracteristica20,
						
			CvdCierre,
			CvdEstado,
			CvdTiempoCreacion,
			CvdTiempoModificacion
			) 
			VALUES (
			"'.($this->CvdId).'", 
			"'.($this->CvhId).'", 
			"'.($this->EinId).'",
			"'.($this->UmeId).'",
			"'.($this->VehId).'",
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			
			"'.($this->CvdFecha).'",
			'.(empty($this->CvdIdAnterior)?'NULL, ':'"'.$this->CvdIdAnterior.'",').'
			
			'.($this->CvdValorTotal).',
			'.($this->CvdCostoPromedio).',
			'.($this->CvdCostoExtraUnitario).',
			'.($this->CvdCostoExtraTotal).',
			'.($this->CvdCostoAnterior).',
			'.($this->CvdCosto).',
			'.($this->CvdCantidad).',
			'.($this->CvdImporte).',
			"'.($this->CvdUbicacion).'",
			"'.($this->CvdObservacion).'",

			"'.($this->CvdCaracteristica1).'",
			"'.($this->CvdCaracteristica2).'",
			"'.($this->CvdCaracteristica3).'",
			"'.($this->CvdCaracteristica4).'",
			"'.($this->CvdCaracteristica5).'",
			"'.($this->CvdCaracteristica6).'",
			"'.($this->CvdCaracteristica7).'",
			"'.($this->CvdCaracteristica8).'",
			"'.($this->CvdCaracteristica9).'",
			"'.($this->CvdCaracteristica10).'",
			"'.($this->CvdCaracteristica11).'",
			"'.($this->CvdCaracteristica12).'",
			"'.($this->CvdCaracteristica13).'",
			"'.($this->CvdCaracteristica14).'",
			"'.($this->CvdCaracteristica15).'",
			"'.($this->CvdCaracteristica16).'",
			"'.($this->CvdCaracteristica17).'",
			"'.($this->CvdCaracteristica18).'",
			"'.($this->CvdCaracteristica19).'",
			"'.($this->CvdCaracteristica20).'",
						
			2,
			'.($this->CvdEstado).',
			"'.($this->CvdTiempoCreacion).'",
			"'.($this->CvdTiempoModificacion).'");';					
		
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
	
	public function MtdEditarCompraVehiculoDetalle() {

			$sql = 'UPDATE tblcvdcompravehiculodetalle SET 	
			
			EinId = "'.trim($this->EinId).'",
			UmeId = "'.trim($this->UmeId).'",
			'.(empty($this->VehId)?'VehId = NULL, ':'VehId = "'.$this->VehId.'",').'
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'

			CvdFecha = "'.($this->CvdFecha).'",
			
			'.(empty($this->CvdIdAnterior)?'CvdIdAnterior = NULL, ':'CvdIdAnterior = "'.$this->CvdIdAnterior.'",').'
			CvdValorTotal = '.($this->CvdValorTotal).',
			CvdCostoPromedio = '.($this->CvdCostoPromedio).',
			CvdCostoExtraUnitario = '.($this->CvdCostoExtraUnitario).',
			CvdCostoExtraTotal = '.($this->CvdCostoExtraTotal).',
			CvdCostoAnterior = '.($this->CvdCostoAnterior).',			
			CvdCosto = '.($this->CvdCosto).',
			CvdCantidad = '.($this->CvdCantidad).',		
			CvdImporte = '.($this->CvdImporte).',
			
			CvdUbicacion = "'.($this->CvdUbicacion).'",
			CvdObservacion = "'.($this->CvdObservacion).'",
			
			CvdCaracteristica1 = "'.($this->CvdCaracteristica1).'",
			CvdCaracteristica2 = "'.($this->CvdCaracteristica2).'",
			CvdCaracteristica3 = "'.($this->CvdCaracteristica3).'",
			CvdCaracteristica4 = "'.($this->CvdCaracteristica4).'",
			CvdCaracteristica5 = "'.($this->CvdCaracteristica5).'",
			CvdCaracteristica6 = "'.($this->CvdCaracteristica6).'",
			CvdCaracteristica7 = "'.($this->CvdCaracteristica7).'",
			CvdCaracteristica8 = "'.($this->CvdCaracteristica8).'",
			CvdCaracteristica9 = "'.($this->CvdCaracteristica9).'",
			CvdCaracteristica10 = "'.($this->CvdCaracteristica10).'",
			CvdCaracteristica11 = "'.($this->CvdCaracteristica11).'",
			CvdCaracteristica12 = "'.($this->CvdCaracteristica12).'",
			CvdCaracteristica13 = "'.($this->CvdCaracteristica13).'",
			CvdCaracteristica14 = "'.($this->CvdCaracteristica14).'",
			CvdCaracteristica15 = "'.($this->CvdCaracteristica15).'",
			CvdCaracteristica16 = "'.($this->CvdCaracteristica16).'",
			CvdCaracteristica17 = "'.($this->CvdCaracteristica17).'",
			CvdCaracteristica18 = "'.($this->CvdCaracteristica18).'",
			CvdCaracteristica19 = "'.($this->CvdCaracteristica19).'",
			CvdCaracteristica20 = "'.($this->CvdCaracteristica20).'",
			
			CvdEstado = '.($this->CvdEstado).'
			WHERE CvdId = "'.($this->CvdId).'";';
					
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


	public function MtdEditarCompraVehiculoDetalleDato($oCampo,$oDato,$oCompraVehiculoDetalleId) {

			$sql = 'UPDATE tblcvdcompravehiculodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE CvdId = "'.($oCompraVehiculoDetalleId).'";';
					
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
			
		
		 public function MtdObtenerUltimoCompraVehiculoDetalleId($oProductoId,$oFecha){

		$sql = 'SELECT
			 
			cvd.CvdId,			
			cvd.CvhId,
			cvd.EinId,
			cvd.UmeId,
			
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinVIN,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ume.UmeNombre,
	        DATE_FORMAT(cvh.CvhFecha, "%d/%m/%Y") AS "NCvhFecha"
			
			FROM tblcvdcompravehiculodetalle cvd
				LEFT JOIN tbleinvehiculoingreso ein
				ON cvd.EinId = ein.EinId
					LEFT JOIN tblumeunidadmedida ume
					ON cvd.UmeId = ume.UmeId				
						LEFT JOIN tblcvhcompravehiculo cvh
						ON cvd.CvhId = cvh.CvhId
							

		WHERE cvd.EinId = "'.$oProductoId.'" 
		AND 1 = 1
		AND cvh.CvhFecha < "'.$oFecha.'"
		ORDER BY cvh.CvhFecha DESC LIMIT 1';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			$Respuesta = $fila['CvdId'];

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
		
		
	 public function MtdVerificarExisteUltimoCompraVehiculoDetalleId($oCompraVehiculoDetalleId){
		
		$Existe = false;
		
		$sql = 'SELECT
			 
			cvd.CvdId,			
			cvd.CvhId,
			cvd.EinId,
			cvd.UmeId,
			
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinVIN,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ume.UmeNombre,
	        DATE_FORMAT(cvh.CvhFecha, "%d/%m/%Y") AS "NCvhFecha"
			
			FROM tblcvdcompravehiculodetalle cvd
				LEFT JOIN tbleinvehiculoingreso ein
				ON cvd.EinId = ein.EinId
					LEFT JOIN tblumeunidadmedida ume
					ON cvd.UmeId = ume.UmeId				
						LEFT JOIN tblcvhcompravehiculo cvh
						ON cvd.CvhId = cvh.CvhId
							
		WHERE cvd.CvdId = "'.$oCompraVehiculoDetalleId.'" 
	
		';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['CvdId'])){
				$Existe = true;		
			}

		}
		
        
		return $Existe;

    }
		
		/*public function MtdEditarCompraVehiculoDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblcvdcompravehiculodetalle SET 
			'.(empty($oDato)?$oCampo.' = NULL  ':$oCampo.' = "'.$oDato.'" ').'
		
			WHERE CvdId = "'.($oId).'";';
			
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
*/
}
?>