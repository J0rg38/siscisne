<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoMovimientoEntradaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoMovimientoEntradaDetalle {

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

	private function MtdGenerarVehiculoMovimientoEntradaDetalleId() {

		
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
		

    public function MtdObtenerVehiculoMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL) {

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

			) AS VmvFechaUltimaEntrada,

			(TIMESTAMPDIFF(DAY, @VmvFechaUltimaEntrada, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS VmvUltimaEntradaDiaTranscurridos,
			
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
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$ctipo.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoEntradaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoEntradaDetalle = new $InsVehiculoMovimientoEntradaDetalle();
                    $VehiculoMovimientoEntradaDetalle->VmdId = $fila['VmdId'];
                    $VehiculoMovimientoEntradaDetalle->VmvId = $fila['VmvId'];
					$VehiculoMovimientoEntradaDetalle->EinId = $fila['EinId'];
					$VehiculoMovimientoEntradaDetalle->VehId = $fila['VehId'];
					
					$VehiculoMovimientoEntradaDetalle->UmeId = $fila['UmeId'];
					
					$VehiculoMovimientoEntradaDetalle->VmdIdAnterior = $fila['VmdIdAnterior'];
					$VehiculoMovimientoEntradaDetalle->VmdCosto = $fila['VmdCosto'];
					$VehiculoMovimientoEntradaDetalle->VmdCostoIngreso = $fila['VmdCostoIngreso'];
					$VehiculoMovimientoEntradaDetalle->VmdCostoAnterior = $fila['VmdCostoAnterior'];
					$VehiculoMovimientoEntradaDetalle->VmdCostoExtraTotal = $fila['VmdCostoExtraTotal'];
					$VehiculoMovimientoEntradaDetalle->VmdCostoExtraUnitario = $fila['VmdCostoExtraUnitario'];
					$VehiculoMovimientoEntradaDetalle->VmdValorTotal = $fila['VmdValorTotal'];
			        $VehiculoMovimientoEntradaDetalle->VmdCantidad = $fila['VmdCantidad'];  
					$VehiculoMovimientoEntradaDetalle->VmdObservacion = $fila['VmdObservacion'];  
					
					$VehiculoMovimientoEntradaDetalle->VmdImporte = $fila['VmdImporte'];
					$VehiculoMovimientoEntradaDetalle->VmdCostoPromedio = $fila['VmdCostoPromedio'];
					
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica1 = $fila['VmdCaracteristica1'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica2 = $fila['VmdCaracteristica2'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica3 = $fila['VmdCaracteristica3'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica4 = $fila['VmdCaracteristica4'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica5 = $fila['VmdCaracteristica5'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica6 = $fila['VmdCaracteristica6'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica7 = $fila['VmdCaracteristica7'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica8 = $fila['VmdCaracteristica8'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica9 = $fila['VmdCaracteristica9'];					
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica10 = $fila['VmdCaracteristica10'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica11 = $fila['VmdCaracteristica11'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica12 = $fila['VmdCaracteristica12'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica13 = $fila['VmdCaracteristica13'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica14 = $fila['VmdCaracteristica14'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica15 = $fila['VmdCaracteristica15'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica16 = $fila['VmdCaracteristica16'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica17 = $fila['VmdCaracteristica17'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica18 = $fila['VmdCaracteristica18'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica19 = $fila['VmdCaracteristica19'];
					$VehiculoMovimientoEntradaDetalle->VmdCaracteristica20 = $fila['VmdCaracteristica20'];
					
					$VehiculoMovimientoEntradaDetalle->VmdEstado = $fila['VmdEstado'];  
					$VehiculoMovimientoEntradaDetalle->VmdTiempoCreacion = $fila['NVmdTiempoCreacion'];  
					$VehiculoMovimientoEntradaDetalle->VmdTiempoModificacion = $fila['NVmdTiempoModificacion']; 	
									
					$VehiculoMovimientoEntradaDetalle->EinId = $fila['EinId'];	
					
					$VehiculoMovimientoEntradaDetalle->VmvFecha = $fila['NVmvFecha'];	
					$VehiculoMovimientoEntradaDetalle->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];	
					$VehiculoMovimientoEntradaDetalle->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];	
					
					$VehiculoMovimientoEntradaDetalle->CtiNombre = $fila['CtiNombre'];
					
					$VehiculoMovimientoEntradaDetalle->VmvSubTotal = $fila['VmvSubTotal'];
	
                    $VehiculoMovimientoEntradaDetalle->EinVIN = (($fila['EinVIN']));
					$VehiculoMovimientoEntradaDetalle->EinNumeroMotor = (($fila['EinNumeroMotor']));
					$VehiculoMovimientoEntradaDetalle->EinColor = (($fila['EinColor']));					
					$VehiculoMovimientoEntradaDetalle->EinColorInterno = (($fila['EinColorInterno']));
					$VehiculoMovimientoEntradaDetalle->EinAnoFabricacion = (($fila['EinAnoFabricacion']));
					$VehiculoMovimientoEntradaDetalle->EinAnoModelo = (($fila['EinAnoModelo']));
					
					$VehiculoMovimientoEntradaDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$VehiculoMovimientoEntradaDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$VehiculoMovimientoEntradaDetalle->TopNombre = (($fila['TopNombre']));

					$VehiculoMovimientoEntradaDetalle->VmvComprobanteNumero = (($fila['VmvComprobanteNumero']));
					$VehiculoMovimientoEntradaDetalle->VmvComprobanteFecha = (($fila['NVmvComprobanteFecha']));

					$VehiculoMovimientoEntradaDetalle->TopId = (($fila['TopId']));
					
					$VehiculoMovimientoEntradaDetalle->VmvFechaUltimaEntrada = (($fila['VmvFechaUltimaEntrada']));
					$VehiculoMovimientoEntradaDetalle->VmvUltimaEntradaDiaTranscurridos = (($fila['VmvUltimaEntradaDiaTranscurridos']));

					$VehiculoMovimientoEntradaDetalle->VmaNombre = (($fila['VmaNombre']));
					$VehiculoMovimientoEntradaDetalle->VmoNombre = (($fila['VmoNombre']));
					$VehiculoMovimientoEntradaDetalle->VveNombre = (($fila['VveNombre']));
					
					$VehiculoMovimientoEntradaDetalle->UmeNombre = (($fila['UmeNombre']));
					$VehiculoMovimientoEntradaDetalle->VehCodigoIdentificador = (($fila['VehCodigoIdentificador']));



                    $VehiculoMovimientoEntradaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoMovimientoEntradaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
  public function MtdObtenerVehiculoMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="VmvTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculoId=NULL) {

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
//			) AS VmvFechaUltimaEntrada,
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
//			(TIMESTAMPDIFF(DAY, @VmvFechaUltimaEntrada, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS VmvUltimaEntradaDiaTranscurridos
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
	
	public function MtdEliminarVehiculoMovimientoEntradaDetalle($oElementos) {
		
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
	


	public function MtdRegistrarVehiculoMovimientoEntradaDetalle() {
	
			$this->MtdGenerarVehiculoMovimientoEntradaDetalleId();
			
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
	
	public function MtdEditarVehiculoMovimientoEntradaDetalle() {

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


	public function MtdEditarVehiculoMovimientoEntradaDetalleDato($oCampo,$oDato,$oVehiculoMovimientoEntradaDetalleId) {

			$sql = 'UPDATE tblvmdvehiculomovimientodetalle SET 	
			'.(empty($oDato)?$oCampo.' = NULL ':$oCampo.' = "'.$oDato.'"').'
			 WHERE VmdId = "'.($oVehiculoMovimientoEntradaDetalleId).'";';
					
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
			
		
		 public function MtdObtenerUltimoVehiculoMovimientoEntradaDetalleId($oProductoId,$oFecha){

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
		
		
	 public function MtdVerificarExisteUltimoVehiculoMovimientoEntradaDetalleId($oVehiculoMovimientoEntradaDetalleId){
		
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
							
		WHERE vmd.VmdId = "'.$oVehiculoMovimientoEntradaDetalleId.'" 
	
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
		
		/*public function MtdEditarVehiculoMovimientoEntradaDetalleDato($oCampo,$oDato,$oId) {

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