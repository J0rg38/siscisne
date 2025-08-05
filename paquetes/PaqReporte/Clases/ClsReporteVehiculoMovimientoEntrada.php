<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteVehiculoMovimientoEntrada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteVehiculoMovimientoEntrada {

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


		

    public function MtdObtenerReporteVehiculoMovimientoEntradas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="VmvComprobanteFecha") {

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
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmv.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(vmv.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vmv.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmv.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
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
			ein.EinCancelado,
			
			ein.EinCostoIngresoReal,
			ein.EinCostoIngresoReal * ((vmv.VmvPorcentajeImpuestoVenta/100)+1) AS EinCostoIngresoImpuestoReal,
			
			(vmd.VmdCosto/IFNULL(vmv.VmvTipoCambio,1)) AS EinCostoIngresoReal,
			((vmd.VmdCosto/IFNULL(vmv.VmvTipoCambio,1)) * ((vmv.VmvPorcentajeImpuestoVenta/100)+1)) AS EinCostoIngresoImpuestoReal,
			
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

			) AS VmvFechaUltimaEntrada,

			(TIMESTAMPDIFF(DAY, @VmvFechaUltimaEntrada, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS VmvUltimaEntradaDiaTranscurridos,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
			
			veh.VehCodigoIdentificador,
			
			mon.MonNombre,
			mon.MonSimbolo,
			mon.MonSigla
		

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
						
							LEFT JOIN tblmonmoneda mon
							ON vmv.MonId = mon.MonId
							
							LEFT JOIN tbltoptipooperacion top
							ON vmv.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON vmv.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON vmv.CtiId = cti.CtiId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$ctipo.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsReporteVehiculoMovimientoEntrada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ReporteVehiculoMovimientoEntrada = new $InsReporteVehiculoMovimientoEntrada();
                    $ReporteVehiculoMovimientoEntrada->VmdId = $fila['VmdId'];
                    $ReporteVehiculoMovimientoEntrada->VmvId = $fila['VmvId'];
					$ReporteVehiculoMovimientoEntrada->EinId = $fila['EinId'];
					$ReporteVehiculoMovimientoEntrada->VehId = $fila['VehId'];
					
					$ReporteVehiculoMovimientoEntrada->UmeId = $fila['UmeId'];
					
					$ReporteVehiculoMovimientoEntrada->VmdIdAnterior = $fila['VmdIdAnterior'];
					$ReporteVehiculoMovimientoEntrada->VmdCosto = $fila['VmdCosto'];
					$ReporteVehiculoMovimientoEntrada->VmdCostoIngreso = $fila['VmdCostoIngreso'];
					$ReporteVehiculoMovimientoEntrada->VmdCostoAnterior = $fila['VmdCostoAnterior'];
					$ReporteVehiculoMovimientoEntrada->VmdCostoExtraTotal = $fila['VmdCostoExtraTotal'];
					$ReporteVehiculoMovimientoEntrada->VmdCostoExtraUnitario = $fila['VmdCostoExtraUnitario'];
					$ReporteVehiculoMovimientoEntrada->VmdValorTotal = $fila['VmdValorTotal'];
			        $ReporteVehiculoMovimientoEntrada->VmdCantidad = $fila['VmdCantidad'];  
					$ReporteVehiculoMovimientoEntrada->VmdObservacion = $fila['VmdObservacion'];  
					
					$ReporteVehiculoMovimientoEntrada->VmdImporte = $fila['VmdImporte'];
					$ReporteVehiculoMovimientoEntrada->VmdCostoPromedio = $fila['VmdCostoPromedio'];
					
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica1 = $fila['VmdCaracteristica1'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica2 = $fila['VmdCaracteristica2'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica3 = $fila['VmdCaracteristica3'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica4 = $fila['VmdCaracteristica4'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica5 = $fila['VmdCaracteristica5'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica6 = $fila['VmdCaracteristica6'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica7 = $fila['VmdCaracteristica7'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica8 = $fila['VmdCaracteristica8'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica9 = $fila['VmdCaracteristica9'];					
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica10 = $fila['VmdCaracteristica10'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica11 = $fila['VmdCaracteristica11'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica12 = $fila['VmdCaracteristica12'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica13 = $fila['VmdCaracteristica13'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica14 = $fila['VmdCaracteristica14'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica15 = $fila['VmdCaracteristica15'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica16 = $fila['VmdCaracteristica16'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica17 = $fila['VmdCaracteristica17'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica18 = $fila['VmdCaracteristica18'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica19 = $fila['VmdCaracteristica19'];
					$ReporteVehiculoMovimientoEntrada->VmdCaracteristica20 = $fila['VmdCaracteristica20'];
					
					$ReporteVehiculoMovimientoEntrada->VmdEstado = $fila['VmdEstado'];  
					$ReporteVehiculoMovimientoEntrada->VmdTiempoCreacion = $fila['NVmdTiempoCreacion'];  
					$ReporteVehiculoMovimientoEntrada->VmdTiempoModificacion = $fila['NVmdTiempoModificacion']; 	
									
					$ReporteVehiculoMovimientoEntrada->EinId = $fila['EinId'];	
					
					$ReporteVehiculoMovimientoEntrada->VmvFecha = $fila['NVmvFecha'];	
					$ReporteVehiculoMovimientoEntrada->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];	
					$ReporteVehiculoMovimientoEntrada->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];	
					
					$ReporteVehiculoMovimientoEntrada->CtiNombre = $fila['CtiNombre'];
					
					$ReporteVehiculoMovimientoEntrada->VmvSubTotal = $fila['VmvSubTotal'];
	
                    $ReporteVehiculoMovimientoEntrada->EinVIN = (($fila['EinVIN']));
					$ReporteVehiculoMovimientoEntrada->EinNumeroMotor = (($fila['EinNumeroMotor']));
					$ReporteVehiculoMovimientoEntrada->EinColor = (($fila['EinColor']));					
					$ReporteVehiculoMovimientoEntrada->EinColorInterno = (($fila['EinColorInterno']));
					$ReporteVehiculoMovimientoEntrada->EinAnoFabricacion = (($fila['EinAnoFabricacion']));
					$ReporteVehiculoMovimientoEntrada->EinAnoModelo = (($fila['EinAnoModelo']));
					$ReporteVehiculoMovimientoEntrada->EinCancelado = (($fila['EinCancelado']));
					
					
					$ReporteVehiculoMovimientoEntrada->EinCostoIngresoReal = (($fila['EinCostoIngresoReal']));
					$ReporteVehiculoMovimientoEntrada->EinCostoIngresoImpuestoReal = (($fila['EinCostoIngresoImpuestoReal']));
					
					
					
			
					$ReporteVehiculoMovimientoEntrada->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$ReporteVehiculoMovimientoEntrada->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$ReporteVehiculoMovimientoEntrada->TopNombre = (($fila['TopNombre']));

					$ReporteVehiculoMovimientoEntrada->VmvComprobanteNumero = (($fila['VmvComprobanteNumero']));
					$ReporteVehiculoMovimientoEntrada->VmvComprobanteFecha = (($fila['NVmvComprobanteFecha']));

					$ReporteVehiculoMovimientoEntrada->TopId = (($fila['TopId']));
					
					$ReporteVehiculoMovimientoEntrada->VmvFechaUltimaEntrada = (($fila['VmvFechaUltimaEntrada']));
					$ReporteVehiculoMovimientoEntrada->VmvUltimaEntradaDiaTranscurridos = (($fila['VmvUltimaEntradaDiaTranscurridos']));

					$ReporteVehiculoMovimientoEntrada->VmaNombre = (($fila['VmaNombre']));
					$ReporteVehiculoMovimientoEntrada->VmoNombre = (($fila['VmoNombre']));
					$ReporteVehiculoMovimientoEntrada->VveNombre = (($fila['VveNombre']));
					
					$ReporteVehiculoMovimientoEntrada->UmeNombre = (($fila['UmeNombre']));
					$ReporteVehiculoMovimientoEntrada->VehCodigoIdentificador = (($fila['VehCodigoIdentificador']));
					
					$ReporteVehiculoMovimientoEntrada->MonNombre = (($fila['MonNombre']));
					$ReporteVehiculoMovimientoEntrada->MonSimbolo = (($fila['MonSimbolo']));
					$ReporteVehiculoMovimientoEntrada->MonSigla = (($fila['MonSigla']));



                    $ReporteVehiculoMovimientoEntrada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ReporteVehiculoMovimientoEntrada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
}
?>