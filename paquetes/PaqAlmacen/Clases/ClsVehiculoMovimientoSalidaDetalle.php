<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoMovimientoSalidaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoMovimientoSalidaDetalle {

	public $VmdId;
	public $VmvId;
	public $EinId;
	public $UmeId;
    public $VmdCantidad;	

	public $VmdIdAnterior;
	public $VmdCosto;
	public $VmdCostoAnterior;
	public $VmdCostoExtraTotal;
	public $VmdCostoExtraUnitario;
	public $VmdImporte;	
	public $VmdCostoPromedio;

	public $VmdCaracteristica1;
	public $VmdCaracteristica2;
	public $VmdCaracteristica3;
	public $VmdCaracteristica4;
	public $VmdCaracteristica5;
	public $VmdCaracteristica6;
	public $VmdCaracteristica7;
	public $VmdCaracteristica8;
	public $VmdCaracteristica9;

	public $VmdCaracteristica10;
	public $VmdCaracteristica11;
	public $VmdNacionalTotalOtroCosto;	

	public $VmdEstado;	
	public $VmdTiempoCreacion;
	public $VmdTiempoModificacion;
	public $VmdEliminado;

	public $EinVIN;
	public $EinNumeroMotor;
	public $EinColor;
	public $EinColorInterno;
	public $EinAnoFabricacion;
	public $UmeNombre;
	public $UmeAbreviacion;

	public $VmvFecha;
	public $VmvComprobanteNumero;
	public $VmvComprobanteFecha;
	public $CtiNombre;
	
	public $VmvTotalNacional;
	public $VmvTotalInternacional;
	
	public $VmvSubTotal;
	
	public $PrvNombreCompleto;
	public $PrvNumeroDocumento;
	
	public $TopNombre;
	

	
	// public $VmdId;
//	public $VmvId;
//	public $EinId;
//	public $UmeId;
//    public $VmdCantidad;	
//	public $VmdCantidadReal;
//	public $VmdCosto;
//	public $VmdCostoAnterior;
//	public $VmdCostoTotal;
//	public $VmdImporte;	
//	public $VmdEstado;	
//	public $VmdTiempoCreacion;
//	public $VmdTiempoModificacion;
//    public $VmdEliminado;
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

	private function MtdGenerarVehiculoMovimientoSalidaDetalleId() {

		
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VmdId,5),unsigned)) AS "MAXIMO"
			FROM tblvmdvehiculomovimientodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VmdId = "VMD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VmdId = "VMD-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL) {

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
			$amovimiento = ' AND vmd.VmvId = "'.$oCompraVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vmd.VmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehiculo)){
			$producto = ' AND (vmd.VehId = "'.$oVehiculo.'") ';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (vmv.SucId = "'.$oSucursal.'") ';
		}
		
		if(!empty($oTipo)){

			$elementos = explode(",",$oTipo);

			$i=1;
			$cltipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$cltipo .= '  (vmv.VmvTipo = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$cltipo .= ' OR ';	
				}
			$i++;		
			}

			$cltipo .= ' ) 
			)
			';

		}
		
	
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vmd.VmdId,			
			vmd.VmvId,
			vmd.EinId,
			vmd.VehId,
			
			vmd.UmeId,			
			vmd.VmdIdAnterior,
			
			vmd.VmdCosto,
			vmd.VmdCostoIngreso,
			vmd.VmdCostoAnterior,
			vmd.VmdCostoExtraTotal,
			vmd.VmdCostoExtraUnitario,
			vmd.VmdValorTotal,
			vmd.VmdCantidad,
			vmd.VmdObservacion,
			
			vmd.VmdImporte,
			vmd.VmdCostoPromedio,

			vmd.VmdCaracteristica1,
			vmd.VmdCaracteristica2,
			vmd.VmdCaracteristica3,
			vmd.VmdCaracteristica4,
			vmd.VmdCaracteristica5,
			vmd.VmdCaracteristica6,
			vmd.VmdCaracteristica7,
			vmd.VmdCaracteristica8,
			vmd.VmdCaracteristica9,
			vmd.VmdCaracteristica10,
			vmd.VmdCaracteristica12,
			vmd.VmdCaracteristica13,
			vmd.VmdCaracteristica14,
			vmd.VmdCaracteristica15,
			vmd.VmdCaracteristica16,
			vmd.VmdCaracteristica17,
			vmd.VmdCaracteristica18,
			vmd.VmdCaracteristica19,
			vmd.VmdCaracteristica20,
			
			vmd.VmdEstado,
			DATE_FORMAT(vmd.VmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmdTiempoCreacion",
	        DATE_FORMAT(vmd.VmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmdTiempoModificacion",
			
			ein.EinVIN,
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ein.EinAnoModelo,

			ume.UmeNombre,
			ume.UmeAbreviacion,

			DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
			vmv.VmvComprobanteNumero,
			DATE_FORMAT(vmv.VmvComprobanteFecha, "%d/%m/%Y") AS "NVmvComprobanteFecha",
			cti.CtiNombre,

			vmv.VmvSubTotal,

			prv.PrvNombreCompleto,
			prv.PrvNumeroDocumento,

			top.TopNombre,

			vmv.VmvComprobanteNumero,
			DATE_FORMAT(vmv.VmvComprobanteFecha, "%d/%m/%Y") AS "NVmvComprobanteFecha",

			vmv.TopId,

			(
				SELECT 
				DATE_FORMAT(vmv2.VmvFecha, "%d/%m/%Y") 
				FROM tblvmdvehiculomovimientodetalle vmd2
					LEFT JOIN tblvmvvehiculomovimiento vmv2
					ON vmd2.VmvId = vmv2.VmvId
						WHERE  vmd2.EinId = vmd.EinId
				ORDER BY vmv2.VmvFecha DESC
				LIMIT 1

			) AS VmvFechaUltimaSalida,

			(TIMESTAMPDIFF(DAY, @VmvFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS VmvUltimaSalidaDiaTranscurridos,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
		
			veh.VehCodigoIdentificador
				
			FROM tblvmdvehiculomovimientodetalle vmd
				
					LEFT JOIN tblvehvehiculo veh
				ON vmd.VehId = veh.VehId
				
				LEFT JOIN tbleinvehiculoingreso ein
				ON vmd.EinId = ein.EinId
					
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
				
					LEFT JOIN tblumeunidadmedida ume
					ON vmd.UmeId = ume.UmeId							
									
						LEFT  JOIN tblvmvvehiculomovimiento vmv
						ON vmd.VmvId = vmv.VmvId
						
							LEFT JOIN tbltoptipooperacion top
							ON vmv.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON vmv.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON vmv.CtiId = cti.CtiId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$sucursal.$ctipo.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoSalidaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoSalidaDetalle = new $InsVehiculoMovimientoSalidaDetalle();
                    $VehiculoMovimientoSalidaDetalle->VmdId = $fila['VmdId'];
                    $VehiculoMovimientoSalidaDetalle->VmvId = $fila['VmvId'];
					$VehiculoMovimientoSalidaDetalle->UmeId = $fila['UmeId'];
					
					$VehiculoMovimientoSalidaDetalle->VmdIdAnterior = $fila['VmdIdAnterior'];
					$VehiculoMovimientoSalidaDetalle->VmdCosto = $fila['VmdCosto'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoIngreso = $fila['VmdCostoIngreso'];
					
					$VehiculoMovimientoSalidaDetalle->VmdCostoAnterior = $fila['VmdCostoAnterior'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoExtraTotal = $fila['VmdCostoExtraTotal'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoExtraUnitario = $fila['VmdCostoExtraUnitario'];
					$VehiculoMovimientoSalidaDetalle->VmdValorTotal = $fila['VmdValorTotal'];
			        $VehiculoMovimientoSalidaDetalle->VmdCantidad = $fila['VmdCantidad'];  
					$VehiculoMovimientoSalidaDetalle->VmdObservacion = $fila['VmdObservacion'];  
					
					$VehiculoMovimientoSalidaDetalle->VmdImporte = $fila['VmdImporte'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoPromedio = $fila['VmdCostoPromedio'];
					
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica1 = $fila['VmdCaracteristica1'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica2 = $fila['VmdCaracteristica2'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica3 = $fila['VmdCaracteristica3'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica4 = $fila['VmdCaracteristica4'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica5 = $fila['VmdCaracteristica5'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica6 = $fila['VmdCaracteristica6'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica7 = $fila['VmdCaracteristica7'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica8 = $fila['VmdCaracteristica8'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica9 = $fila['VmdCaracteristica9'];					
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica10 = $fila['VmdCaracteristica10'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica11 = $fila['VmdCaracteristica11'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica12 = $fila['VmdCaracteristica12'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica13 = $fila['VmdCaracteristica13'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica14 = $fila['VmdCaracteristica14'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica15 = $fila['VmdCaracteristica15'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica16 = $fila['VmdCaracteristica16'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica17 = $fila['VmdCaracteristica17'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica18 = $fila['VmdCaracteristica18'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica19 = $fila['VmdCaracteristica19'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica20 = $fila['VmdCaracteristica20'];
					
					$VehiculoMovimientoSalidaDetalle->VmdEstado = $fila['VmdEstado'];  
					$VehiculoMovimientoSalidaDetalle->VmdTiempoCreacion = $fila['NVmdTiempoCreacion'];  
					$VehiculoMovimientoSalidaDetalle->VmdTiempoModificacion = $fila['NVmdTiempoModificacion']; 	
									
					$VehiculoMovimientoSalidaDetalle->EinId = $fila['EinId'];	
					
					$VehiculoMovimientoSalidaDetalle->VmvFecha = $fila['NVmvFecha'];	
					$VehiculoMovimientoSalidaDetalle->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];	
					$VehiculoMovimientoSalidaDetalle->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];	
					
					$VehiculoMovimientoSalidaDetalle->CtiNombre = $fila['CtiNombre'];
					
					$VehiculoMovimientoSalidaDetalle->VmvSubTotal = $fila['VmvSubTotal'];
	
                    $VehiculoMovimientoSalidaDetalle->EinVIN = (($fila['EinVIN']));
					$VehiculoMovimientoSalidaDetalle->EinNumeroMotor = (($fila['EinNumeroMotor']));
					$VehiculoMovimientoSalidaDetalle->EinColor = (($fila['EinColor']));					
					$VehiculoMovimientoSalidaDetalle->EinColorInterno = (($fila['EinColorInterno']));
					$VehiculoMovimientoSalidaDetalle->EinAnoFabricacion = (($fila['EinAnoFabricacion']));
					$VehiculoMovimientoSalidaDetalle->EinAnoModelo = (($fila['EinAnoModelo']));
					
					$VehiculoMovimientoSalidaDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$VehiculoMovimientoSalidaDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$VehiculoMovimientoSalidaDetalle->TopNombre = (($fila['TopNombre']));

					$VehiculoMovimientoSalidaDetalle->VmvComprobanteNumero = (($fila['VmvComprobanteNumero']));
					$VehiculoMovimientoSalidaDetalle->VmvComprobanteFecha = (($fila['NVmvComprobanteFecha']));

					$VehiculoMovimientoSalidaDetalle->TopId = (($fila['TopId']));
					
					$VehiculoMovimientoSalidaDetalle->VmvFechaUltimaSalida = (($fila['VmvFechaUltimaSalida']));
					$VehiculoMovimientoSalidaDetalle->VmvUltimaSalidaDiaTranscurridos = (($fila['VmvUltimaSalidaDiaTranscurridos']));

					$VehiculoMovimientoSalidaDetalle->VmaNombre = (($fila['VmaNombre']));
					$VehiculoMovimientoSalidaDetalle->VmoNombre = (($fila['VmoNombre']));
					$VehiculoMovimientoSalidaDetalle->VveNombre = (($fila['VveNombre']));
					
					$VehiculoMovimientoSalidaDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$VehiculoMovimientoSalidaDetalle->VehCodigoIdentificador = (($fila['VehCodigoIdentificador']));

                    $VehiculoMovimientoSalidaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoMovimientoSalidaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
  public function MtdObtenerVehiculoMovimientoSalidaDetallesValor($oFuncion="SUM",$oParametro="VmvTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculoId=NULL) {

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
			$amovimiento = ' AND vmd.VmvId = "'.$oCompraVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vmd.VmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehiculoId)){
			$vehiculo = ' AND vmd.VehId = '.$oVehiculoId.' ';
		}
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(vmv.VmvFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(vmv.VmvFecha) ="'.($oAno).'"';
		}
		
	
			$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			FROM tblvmdvehiculomovimientodetalle vmd
				
				LEFT JOIN tbleinvehiculoingreso ein
				ON vmd.EinId = ein.EinId
				
					LEFT JOIN tblumeunidadmedida ume
					ON vmd.UmeId = ume.UmeId	
						
						LEFT  JOIN tblvmvvehiculomovimiento vmv
						ON vmd.VmvId = vmv.VmvId
				
							LEFT JOIN tbltoptipooperacion top
							ON vmv.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON vmv.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON vmv.CtiId = cti.CtiId

			WHERE  1 = 1 '.$ano.$mes.$amovimiento.$producto.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$amestado.$vehiculo.$vmarca.$ptipo.$dinactivo.$orden.$paginacion;	
					
					
//							(
//				SELECT 
//				DATE_FORMAT(vmv2.VmvFecha, "%d/%m/%Y") 
//				FROM tblvmdvehiculomovimientodetalle vmd2
//					LEFT JOIN tblvmvvehiculomovimiento vmv2
//					ON vmd2.VmvId = vmv2.VmvId
//						WHERE vmv2.VmvTipo = 2
//						AND vmd2.EinId = vmd.EinId
//				ORDER BY vmv2.VmvFecha DESC
//				LIMIT 1
//
//			) AS VmvFechaUltimaSalida,
//			
//
//
//
//			IFNULL(
//				(SELECT 
//				DATE_FORMAT(vmv2.VmvFecha, "%d/%m/%Y") 
//				FROM tblvmdvehiculomovimientodetalle vmd2
//					LEFT JOIN tblvmvvehiculomovimiento vmv2
//					ON vmd2.VmvId = vmv2.VmvId
//						WHERE vmv2.VmvTipo = 2
//						AND vmd2.EinId = vmd.EinId
//				ORDER BY vmv2.VmvFecha DESC
//				LIMIT 1),NOW()
//			) 
//			
//						
//			(TIMESTAMPDIFF(DAY, @VmvFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS VmvUltimaSalidaDiaTranscurridos
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
	
	public function MtdEliminarVehiculoMovimientoSalidaDetalle($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
//					if($i==count($elementos)){						
//						$eliminar .= '  (VmdId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (VmdId = "'.($elemento).'")  OR';	
//					}	

					if(!$error) {		
						$sql = 'DELETE FROM tblvmdvehiculomovimientodetalle WHERE  (VmdId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}
					}

				}
			$i++;
	
			}
		
//				$sql = 'DELETE FROM tblvmdvehiculomovimientodetalle 
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
	


	public function MtdRegistrarVehiculoMovimientoSalidaDetalle() {
	
			$this->MtdGenerarVehiculoMovimientoSalidaDetalleId();
			
			$sql = 'INSERT INTO tblvmdvehiculomovimientodetalle (
			VmdId,
			VmvId,	
			EinId,
			UmeId,
			VehId,
			AlmId,
			VmdFecha,
						
			VmdIdAnterior,
			
			VmdValorTotal,
			VmdCostoPromedio,
			VmdCostoExtraUnitario,
			VmdCostoExtraTotal,
			VmdCostoAnterior,
			VmdCosto,	
			VmdCostoIngreso,
					
			VmdCantidad,
			VmdImporte,
			VmdUbicacion,
			VmdObservacion,
			
			VmdCaracteristica1,
			VmdCaracteristica2,
			VmdCaracteristica3,
			VmdCaracteristica4,
			VmdCaracteristica5,
			VmdCaracteristica6,
			VmdCaracteristica7,
			VmdCaracteristica8,
			VmdCaracteristica9,
			VmdCaracteristica10,
			VmdCaracteristica11,
			VmdCaracteristica12,
			VmdCaracteristica13,
			VmdCaracteristica14,
			VmdCaracteristica15,
			VmdCaracteristica16,
			VmdCaracteristica17,
			VmdCaracteristica18,
			VmdCaracteristica19,
			VmdCaracteristica20,
						
			VmdCierre,
			VmdEstado,
			VmdTiempoCreacion,
			VmdTiempoModificacion
			) 
			VALUES (
			"'.($this->VmdId).'", 
			"'.($this->VmvId).'", 
			"'.($this->EinId).'",
			"'.($this->UmeId).'",
			"'.($this->VehId).'",
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			
			"'.($this->VmdFecha).'",
			'.(empty($this->VmdIdAnterior)?'NULL, ':'"'.$this->VmdIdAnterior.'",').'
			
			'.($this->VmdValorTotal).',
			'.($this->VmdCostoPromedio).',
			'.($this->VmdCostoExtraUnitario).',
			'.($this->VmdCostoExtraTotal).',
			'.($this->VmdCostoAnterior).',
			'.($this->VmdCosto).',
			'.($this->VmdCostoIngreso).',
			
			
			'.($this->VmdCantidad).',
			'.($this->VmdImporte).',
			"'.($this->VmdUbicacion).'",
			"'.($this->VmdObservacion).'",

			"'.($this->VmdCaracteristica1).'",
			"'.($this->VmdCaracteristica2).'",
			"'.($this->VmdCaracteristica3).'",
			"'.($this->VmdCaracteristica4).'",
			"'.($this->VmdCaracteristica5).'",
			"'.($this->VmdCaracteristica6).'",
			"'.($this->VmdCaracteristica7).'",
			"'.($this->VmdCaracteristica8).'",
			"'.($this->VmdCaracteristica9).'",
			"'.($this->VmdCaracteristica10).'",
			"'.($this->VmdCaracteristica11).'",
			"'.($this->VmdCaracteristica12).'",
			"'.($this->VmdCaracteristica13).'",
			"'.($this->VmdCaracteristica14).'",
			"'.($this->VmdCaracteristica15).'",
			"'.($this->VmdCaracteristica16).'",
			"'.($this->VmdCaracteristica17).'",
			"'.($this->VmdCaracteristica18).'",
			"'.($this->VmdCaracteristica19).'",
			"'.($this->VmdCaracteristica20).'",
						
			2,
			'.($this->VmdEstado).',
			"'.($this->VmdTiempoCreacion).'",
			"'.($this->VmdTiempoModificacion).'");';					
		
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
	
	public function MtdEditarVehiculoMovimientoSalidaDetalle() {

			$sql = 'UPDATE tblvmdvehiculomovimientodetalle SET 	
			
			EinId = "'.trim($this->EinId).'",
			UmeId = "'.trim($this->UmeId).'",
			'.(empty($this->VehId)?'VehId = NULL, ':'VehId = "'.$this->VehId.'",').'
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'

			VmdFecha = "'.($this->VmdFecha).'",
			
			'.(empty($this->VmdIdAnterior)?'VmdIdAnterior = NULL, ':'VmdIdAnterior = "'.$this->VmdIdAnterior.'",').'
			VmdValorTotal = '.($this->VmdValorTotal).',
			VmdCostoPromedio = '.($this->VmdCostoPromedio).',
			VmdCostoExtraUnitario = '.($this->VmdCostoExtraUnitario).',
			VmdCostoExtraTotal = '.($this->VmdCostoExtraTotal).',
			VmdCostoAnterior = '.($this->VmdCostoAnterior).',			
			VmdCosto = '.($this->VmdCosto).',
			VmdCostoIngreso = '.($this->VmdCostoIngreso).',
			
			VmdCantidad = '.($this->VmdCantidad).',		
			VmdImporte = '.($this->VmdImporte).',
			
			VmdUbicacion = "'.($this->VmdUbicacion).'",
			VmdObservacion = "'.($this->VmdObservacion).'",
			
			VmdCaracteristica1 = "'.($this->VmdCaracteristica1).'",
			VmdCaracteristica2 = "'.($this->VmdCaracteristica2).'",
			VmdCaracteristica3 = "'.($this->VmdCaracteristica3).'",
			VmdCaracteristica4 = "'.($this->VmdCaracteristica4).'",
			VmdCaracteristica5 = "'.($this->VmdCaracteristica5).'",
			VmdCaracteristica6 = "'.($this->VmdCaracteristica6).'",
			VmdCaracteristica7 = "'.($this->VmdCaracteristica7).'",
			VmdCaracteristica8 = "'.($this->VmdCaracteristica8).'",
			VmdCaracteristica9 = "'.($this->VmdCaracteristica9).'",
			VmdCaracteristica10 = "'.($this->VmdCaracteristica10).'",
			VmdCaracteristica11 = "'.($this->VmdCaracteristica11).'",
			VmdCaracteristica12 = "'.($this->VmdCaracteristica12).'",
			VmdCaracteristica13 = "'.($this->VmdCaracteristica13).'",
			VmdCaracteristica14 = "'.($this->VmdCaracteristica14).'",
			VmdCaracteristica15 = "'.($this->VmdCaracteristica15).'",
			VmdCaracteristica16 = "'.($this->VmdCaracteristica16).'",
			VmdCaracteristica17 = "'.($this->VmdCaracteristica17).'",
			VmdCaracteristica18 = "'.($this->VmdCaracteristica18).'",
			VmdCaracteristica19 = "'.($this->VmdCaracteristica19).'",
			VmdCaracteristica20 = "'.($this->VmdCaracteristica20).'",
			
			VmdEstado = '.($this->VmdEstado).'
			WHERE VmdId = "'.($this->VmdId).'";';
					
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


	public function MtdEditarVehiculoMovimientoSalidaDetalleDato($oCampo,$oDato,$oVehiculoMovimientoSalidaDetalleId) {

			$sql = 'UPDATE tblvmdvehiculomovimientodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE VmdId = "'.($oVehiculoMovimientoSalidaDetalleId).'";';
					
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
			
		
		 public function MtdObtenerUltimoVehiculoMovimientoSalidaDetalleId($oProductoId,$oFecha){

		$sql = 'SELECT
			 
			vmd.VmdId,			
			vmd.VmvId,
			vmd.EinId,
			vmd.UmeId,
			
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinVIN,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ume.UmeNombre,
	        DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha"
			
			FROM tblvmdvehiculomovimientodetalle vmd
				LEFT JOIN tbleinvehiculoingreso ein
				ON vmd.EinId = ein.EinId
					LEFT JOIN tblumeunidadmedida ume
					ON vmd.UmeId = ume.UmeId				
						LEFT JOIN tblvmvvehiculomovimiento vmv
						ON vmd.VmvId = vmv.VmvId
							

		WHERE vmd.EinId = "'.$oProductoId.'" 
		AND 1 = 1
		AND vmv.VmvFecha < "'.$oFecha.'"
		ORDER BY vmv.VmvFecha DESC LIMIT 1';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			$Respuesta = $fila['VmdId'];

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
		
		
	 public function MtdVerificarExisteUltimoVehiculoMovimientoSalidaDetalleId($oVehiculoMovimientoSalidaDetalleId){
		
		$Existe = false;
		
		$sql = 'SELECT
			 
			vmd.VmdId,			
			vmd.VmvId,
			vmd.EinId,
			vmd.UmeId,
			
			ein.EinNumeroMotor,
			ein.EinColor,
			ein.EinVIN,
			ein.EinColorInterno,
			ein.EinAnoFabricacion,
			ume.UmeNombre,
	        DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha"
			
			FROM tblvmdvehiculomovimientodetalle vmd
				LEFT JOIN tbleinvehiculoingreso ein
				ON vmd.EinId = ein.EinId
					LEFT JOIN tblumeunidadmedida ume
					ON vmd.UmeId = ume.UmeId				
						LEFT JOIN tblvmvvehiculomovimiento vmv
						ON vmd.VmvId = vmv.VmvId
							
		WHERE vmd.VmdId = "'.$oVehiculoMovimientoSalidaDetalleId.'" 
	
		';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			
			if(!empty($fila['VmdId'])){
				$Existe = true;		
			}

		}
		
        
		return $Existe;

    }
		
		/*public function MtdEditarVehiculoMovimientoSalidaDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblvmdvehiculomovimientodetalle SET 
			'.(empty($oDato)?$oCampo.' = NULL  ':$oCampo.' = "'.$oDato.'" ').'
		
			WHERE VmdId = "'.($oId).'";';
			
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