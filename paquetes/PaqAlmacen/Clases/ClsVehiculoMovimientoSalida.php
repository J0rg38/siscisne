<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoMovimientoSalida
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoMovimientoSalida {

    public $VmvId;
	public $VmvTipo;
	public $VmvSubTipo;
	public $CliId;
	public $CtiId;
	public $TopId;
	
	public $NpaId;
	public $VmvCantidadDia;
	
	public $AlmId;
	public $VmvFecha;
	public $VmvDocumentoOrigen;
	
	public $VmvGuiaRemisionNumero;
	public $VmvGuiaRemisionNumeroSerie;
	public $VmvGuiaRemisionNumeroNumero;
	public $VmvGuiaRemisionFecha;
	public $VmvGuiaRemisionFoto;
	
	public $VmvComprobanteNumero;
	public $VmvComprobanteNumeroSerie;
	public $VmvComprobanteNumeroNumero;
	public $VmvComprobanteFecha;

	public $MonId;
	public $VmvTipoCambio;

	public $VmvIncluyeImpuesto;
	public $VmvPorcentajeImpuestoVenta;
	
	public $VmvFoto;
    public $VmvObservacion;
	
		
		
	public $VmvSubTotal;
	public $VmvImpuesto;
	public $VmvTotal;
	

	public $VmvCancelado;
	
	public $VmvRevisado;
	
	public $VmvEstado;
	public $VmvTiempoCreacion;
	public $VmvTiempoModificacion;
    public $VmvEliminado;

	public $CtiNombre;
	
	public $TdoId;
	public $CliNombre;
	public $CliNumeroDocumento;
	
	public $TdoNombre;
	
	public $MonSimbolo;
	
	public $VehiculoMovimientoSalidaDetalle;
	public $VehiculoMovimientoSalidaExtorno;
	public $OrdenCompraPedido;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarVehiculoMovimientoSalidaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(vmv.VmvId,5),unsigned)) AS "MAXIMO"
		FROM tblvmvvehiculomovimiento vmv
		WHERE vmv.VmvTipo = 2
		';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->VmvId = "VMS-10000";
		}else{
			$fila['MAXIMO']++;
			$this->VmvId = "VMS-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerVehiculoMovimientoSalida(){

        $sql = 'SELECT 
        vmv.VmvId,  
		vmv.SucId,
		vmv.SucIdDestino,
		vmv.OvvId,
		
		vmv.CliId,
		vmv.CtiId,
		vmv.TopId,
		
		
		vmv.NpaId,
		vmv.VmvCantidadDia,
		
		vmv.AlmId,
		DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
		vmv.VmvDocumentoOrigen,

		vmv.VmvGuiaRemisionNumero,
		DATE_FORMAT(vmv.VmvGuiaRemisionFecha, "%d/%m/%Y") AS "NVmvGuiaRemisionFecha",
		vmv.VmvGuiaRemisionFoto,
		
		vmv.VmvComprobanteNumero,
		DATE_FORMAT(vmv.VmvComprobanteFecha, "%d/%m/%Y") AS "NVmvComprobanteFecha",
		
		vmv.MonId,
		vmv.VmvTipoCambio,
		
		vmv.VmvIncluyeImpuesto,
		vmv.VmvPorcentajeImpuestoVenta,
	
		vmv.VmvFoto,
		vmv.VmvObservacion,

		vmv.VmvSubTotal,
		vmv.VmvImpuesto,
		vmv.VmvTotal,
	
		vmv.VmvCancelado,
		vmv.VmvRevisado,
		
		vmv.VmvTipo,
		vmv.VmvSubTipo,
		vmv.VmvEstado,
		DATE_FORMAT(vmv.VmvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmvTiempoCreacion",
        DATE_FORMAT(vmv.VmvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmvTiempoModificacion",
		
		cti.CtiNombre,
		
		cli.CliNombreCompleto,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		cli.CliNumeroDocumento,
		cli.TdoId,
				
		mon.MonSimbolo,
		
		suc.SucNombre,
		suc.SucDireccion,
		suc.SucDepartamento,
		suc.SucProvincia,
		suc.SucDistrito,
		suc.SucCodigoUbigeo,
		
		sucd.SucNombre AS SucNombreDestino,
		sucd.SucDireccion AS SucDireccionDestino,
		sucd.SucDepartamento AS SucDepartamentoDestino,
		sucd.SucProvincia AS SucProvinciaDestino,
		sucd.SucDistrito AS SucDistritoDestino,
		sucd.SucCodigoUbigeo AS SucCodigoUbigeoDestino,
		
		
		
				(
				SELECT
				grt.GrtNumero
				FROM tblgreguiaremision gre
					LEFT JOIN tblgrtguiaremisiontalonario grt
					ON gre.GrtId = grt.GrtId
				LEFT JOIN tblgamguiaremisionalmacenmovimiento gam
				ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
				WHERE gam.VmvId = vmv.VmvId
				AND gre.GreEstado <> 6
				ORDER BY gre.GreFechaEmision DESC
				LIMIT 1
				) AS VmvGuiaRemisionSerie,
				
				(
				SELECT
				gre.GreId
				FROM tblgreguiaremision gre
					LEFT JOIN tblgrtguiaremisiontalonario grt
					ON gre.GrtId = grt.GrtId
				LEFT JOIN tblgamguiaremisionalmacenmovimiento gam
				ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
				WHERE gam.VmvId = vmv.VmvId
				AND gre.GreEstado <> 6
				ORDER BY gre.GreFechaEmision DESC
				LIMIT 1
				) AS VmvGuiaRemisionNumero,
				
					(
				SELECT
				DATE_FORMAT(gre.GreFechaEmision, "%d/%m/%Y") 
				FROM tblgreguiaremision gre
					LEFT JOIN tblgrtguiaremisiontalonario grt
					ON gre.GrtId = grt.GrtId
				LEFT JOIN tblgamguiaremisionalmacenmovimiento gam
				ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
				WHERE gam.VmvId = vmv.VmvId
				AND gre.GreEstado <> 6
				ORDER BY gre.GreFechaEmision DESC
				LIMIT 1
				) AS VmvGuiaRemisionFecha
		
        FROM tblvmvvehiculomovimiento vmv
		
			LEFT JOIN tblcticomprobantetipo cti
			ON vmv.CtiId = cti.CtiId
				LEFT JOIN tblclicliente cli
				ON vmv.CliId = cli.CliId
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
						LEFT JOIN tblmonmoneda mon
						ON vmv.MonId = mon.MonId	
							LEFT JOIN tblsucsucursal suc
							ON vmv.SucId = suc.SucId
								LEFT JOIN tblsucsucursal sucd
								ON vmv.SucIdDestino = sucd.SucId	
						

        WHERE vmv.VmvId = "'.$this->VmvId.'" ';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->VmvId = $fila['VmvId'];
			$this->SucId = $fila['SucId'];
			$this->SucIdDestino = $fila['SucIdDestino'];
			$this->OvvId = $fila['OvvId'];		
			
			$this->CliId = $fila['CliId'];		
			$this->CtiId = $fila['CtiId'];		
			$this->TopId = $fila['TopId'];		
			
			$this->NpaId = $fila['NpaId'];
			$this->VmvCantidadDia = $fila['VmvCantidadDia'];

			$this->AlmId = $fila['AlmId'];
			$this->VmvFecha = $fila['NVmvFecha'];

			$this->VmvDocumentoOrigen = $fila['VmvDocumentoOrigen'];
			
			$this->VmvGuiaRemisionNumero = $fila['VmvGuiaRemisionNumero'];
			list($this->VmvGuiaRemisionNumeroSerie,$this->VmvGuiaRemisionNumeroNumero) = explode("-",$this->VmvGuiaRemisionNumero);
			$this->VmvGuiaRemisionFecha = $fila['NVmvGuiaRemisionFecha'];
			$this->VmvGuiaRemisionFoto = $fila['VmvGuiaRemisionFoto'];
			
			$this->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];
			list($this->VmvComprobanteNumeroSerie,$this->VmvComprobanteNumeroNumero) = explode("-",$this->VmvComprobanteNumero);
			$this->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];

			$this->MonId = $fila['MonId'];
			$this->VmvTipoCambio = $fila['VmvTipoCambio'];
			$this->VmvTipoCambioComercial = $fila['VmvTipoCambioComercial'];
			
			$this->VmvIncluyeImpuesto = $fila['VmvIncluyeImpuesto'];
			$this->VmvPorcentajeImpuestoVenta = $fila['VmvPorcentajeImpuestoVenta'];
			
			$this->VmvFoto = $fila['VmvFoto'];
			$this->VmvObservacion = $fila['VmvObservacion'];
		
			$this->VmvSubTotal = $fila['VmvSubTotal'];
			$this->VmvImpuesto = $fila['VmvImpuesto'];
			$this->VmvTotal = $fila['VmvTotal'];
					
			$this->VmvCancelado = $fila['VmvCancelado'];
			$this->VmvRevisado = $fila['VmvRevisado'];
			$this->VmvTipo = $fila['VmvTipo'];
			$this->VmvSubTipo = $fila['VmvSubTipo'];
		
			$this->VmvEstado = $fila['VmvEstado'];
			$this->VmvTiempoCreacion = $fila['NVmvTiempoCreacion']; 
			$this->VmvTiempoModificacion = $fila['NVmvTiempoModificacion']; 	
			
			
			
			$this->CtiNombre = $fila['CtiNombre']; 	

			$this->CliNombreCompleto = $fila['CliNombreCompleto']; 	
			$this->CliNombre = $fila['CliNombre']; 	
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 	
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 	
			
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoId = $fila['TdoId']; 	
			$this->TdoNombre = $fila['TdoNombre'];

			$this->MonSimbolo = $fila['MonSimbolo']; 	
		
			$this->SucNombre = $fila['SucNombre'];
			$this->SucDireccion = $fila['SucDireccion']; 	
			$this->SucDepartamento = $fila['SucDepartamento'];
			$this->SucProvincia = $fila['SucProvincia'];
			$this->SucDistrito = $fila['SucDistrito']; 	
			$this->SucCodigoUbigeo = $fila['SucCodigoUbigeo'];

			$this->SucNombreDestino = $fila['SucNombreDestino'];
			$this->SucDireccionDestino = $fila['SucDireccionDestino']; 	
			$this->SucDepartamentoDestino = $fila['SucDepartamentoDestino'];
			$this->SucProvinciaDestino = $fila['SucProvinciaDestino'];
			$this->SucDistritoDestino = $fila['SucDistritoDestino'];
			$this->SucCodigoUbigeoDestino = $fila['SucCodigoUbigeoDestino'];
			
			$this->VmvGuiaRemisionSerie = $fila['VmvGuiaRemisionSerie'];
			$this->VmvGuiaRemisionNumero = $fila['VmvGuiaRemisionNumero'];
			$this->VmvGuiaRemisionFecha = $fila['VmvGuiaRemisionFecha'];
		
			$InsVehiculoMovimientoSalidaDetalle = new ClsVehiculoMovimientoSalidaDetalle();
			//MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoSalida=NULL,$oEstado=NULL,$oVehiculo=NULL)
			$ResVehiculoMovimientoSalidaDetalle =  $InsVehiculoMovimientoSalidaDetalle->MtdObtenerVehiculoMovimientoSalidaDetalles(NULL,NULL,NULL,"VmdId","ASC",NULL,$this->VmvId);				
			$this->VehiculoMovimientoSalidaDetalle = 	$ResVehiculoMovimientoSalidaDetalle['Datos'];	


			switch($this->VmvEstado){
			
				case 1:
					$Estado = "En Transito";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	
				
				case 6:
					$Estado = "Anulado";						
				break;

				default:
					$Estado = "";
				break;
			
			}
				
			$this->VmvEstadoDescripcion = $Estado;
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoMovimientoSalidas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oSubTipo=NULL,$oOrdenVentaVehiculoId=NULL,$oSucursalDestino=NULL) {

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
				
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					vmd.VmdId

					FROM tblvmdvehiculomovimientodetalle vmd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON vmd.EinId = ein.EinId

					WHERE 
						vmd.VmvId = vmv.VmvId  
						
						AND 
						(
						ein.EinVIN LIKE "%'.$oFiltro.'%" OR
						ein.EinNumeroMotor LIKE "%'.$oFiltro.'%"
					
						)
						
					) ';
					
									
				$filtrar .= '  ) ';

			

				
					
					
		}


		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
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
		

		if(!empty($oEstado)){
			$estado = ' AND vmv.VmvEstado = '.$oEstado;
		}
		

		if(!empty($oOrigen)){
			$origen = ' AND vmv.VmvDocumentoOrigen = '.$oOrigen;
		}
		

		if(!empty($oMoneda)){
			$moneda = ' AND vmv.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND vmv.CliId = "'.$oCliente.'"';
		}	
		
		if($oCancelado){
			$cancelado = ' AND vmv.VmvCancelado = '.$oCancelado;
		}
		
		if(!empty($oProveedor)){
			$einveedor = ' AND vmv.CliId = "'.$oProveedor.'"';
		}
		
		if(!empty($oCondicionPago)){
			$cpago = ' AND vmv.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND vmv.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oAlmacen)){
			$almacen = ' AND vmv.AlmId = "'.$oAlmacen.'"';
		}
			
		if(!empty($oSubTipo)){
			$stipo = ' AND vmv.VmvSubTipo = "'.$oSubTipo.'"';
		}
		
				
		if(!empty($oOrdenVentaVehiculoId)){
			$ovvehiculo = ' AND vmv.OvvId = "'.$oOrdenVentaVehiculoId.'"';
		}
		
		if(!empty($oSucursalDestino)){
			$sdestino = ' AND vmv.SucIdDestino = "'.$oSucursalDestino.'"';
		}
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vmv.VmvId,				
				vmv.SucId,
				
				vmv.CliId,
				vmv.CtiId,
				vmv.TopId,
				
				vmv.NpaId,	
				vmv.VmvCantidadDia,	
				
				vmv.AlmId,
				DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
				vmv.VmvDocumentoOrigen,
				
				vmv.VmvGuiaRemisionNumero,
				DATE_FORMAT(vmv.VmvGuiaRemisionFecha, "%d/%m/%Y") AS "NVmvGuiaRemisionFecha",
				vmv.VmvGuiaRemisionFoto,
				
				vmv.VmvComprobanteNumero,
				DATE_FORMAT(vmv.VmvComprobanteFecha, "%d/%m/%Y") AS "NVmvComprobanteFecha",
				
				vmv.MonId,
				vmv.VmvTipoCambio,
				vmv.VmvTipoCambioComercial,
				
				vmv.VmvIncluyeImpuesto,
				vmv.VmvPorcentajeImpuestoVenta,
						
				vmv.VmvFoto,
				vmv.VmvObservacion,
				
				vmv.VmvSubTotal,
				vmv.VmvImpuesto,				
				vmv.VmvTotal,
				
				vmv.VmvCancelado,
				vmv.VmvRevisado,
				vmv.VmvCierre,
				
				vmv.VmvTipo,
				vmv.VmvSubTipo,
				vmv.VmvEstado,
				DATE_FORMAT(vmv.VmvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmvTiempoCreacion",
	        	DATE_FORMAT(vmv.VmvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmvTiempoModificacion",
				
				DATE_FORMAT(adddate(vmv.VmvComprobanteFecha,vmv.VmvCantidadDia), "%d/%m/%Y") AS VmvFechaVencimiento,
				DATEDIFF(DATE(NOW()),vmv.VmvComprobanteFecha) AS VmvDiaTranscurrido,

				CASE
				WHEN EXISTS (
					SELECT 
					vmv.VmvId 
					FROM tblnccnotacreditocompra ncc
					WHERE ncc.NccId = vmv.VmvId
					AND ncc.NccEstado = 3 
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS VmvNotaCreditoCompra,
				
				
				(
				SELECT
				grt.GrtNumero
				FROM tblgreguiaremision gre
					LEFT JOIN tblgrtguiaremisiontalonario grt
					ON gre.GrtId = grt.GrtId
				LEFT JOIN tblgamguiaremisionalmacenmovimiento gam
				ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
				WHERE gam.VmvId = vmv.VmvId
				AND gre.GreEstado <> 6
				ORDER BY gre.GreFechaEmision DESC
				LIMIT 1
				) AS VmvGuiaRemisionSerie,
				
				(
				SELECT
				gre.GreId
				FROM tblgreguiaremision gre
					LEFT JOIN tblgrtguiaremisiontalonario grt
					ON gre.GrtId = grt.GrtId
				LEFT JOIN tblgamguiaremisionalmacenmovimiento gam
				ON gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId
				WHERE gam.VmvId = vmv.VmvId
				AND gre.GreEstado <> 6
				ORDER BY gre.GreFechaEmision DESC
				LIMIT 1
				) AS VmvGuiaRemisionNumero,
				
				(SELECT COUNT(vmd.VmdId) FROM tblvmdvehiculomovimientodetalle vmd WHERE vmd.VmvId = vmv.VmvId ) AS "VmvTotalItems",

				cti.CtiNombre,
				
				cli.TdoId,

				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				
				tdo.TdoNombre,				
				mon.MonSimbolo,				
				npa.NpaNombre,
				
				ovv.OvvTotal,
				ovv.OvvTipoCambio,
				
				ovv.OvvColor,
				ovv.OvvGLP,
				
				suc.SucNombre,
				suc2.SucNombre AS SucNombreDestino

				FROM tblvmvvehiculomovimiento vmv
					
					LEFT JOIN tblovvordenventavehiculo ovv
					ON vmv.OvvId = ovv.OvvId
					
					
					LEFT JOIN tblnpacondicionpago npa
					ON vmv.NpaId = npa.NpaId
						LEFT JOIN tblcticomprobantetipo cti
						ON vmv.CtiId = cti.CtiId
							LEFT JOIN tblclicliente cli
							ON vmv.CliId = cli.CliId
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
									LEFT JOIN tblmonmoneda mon
									ON vmv.MonId = mon.MonId
										LEFT JOIN tblsucsucursal suc
										ON vmv.SucId = suc.SucId
											LEFT JOIN tblsucsucursal suc2
											ON vmv.SucIdDestino = suc2.SucId
	
				WHERE 1 = 1 AND vmv.VmvTipo = 2 '.$filtrar.$fecha.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$sdestino .$einveedor.$ovvehiculo.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoSalida = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoSalida = new $InsVehiculoMovimientoSalida();
                    $VehiculoMovimientoSalida->VmvId = $fila['VmvId'];
					$VehiculoMovimientoSalida->SucId = $fila['SucId'];
					
					$VehiculoMovimientoSalida->CliId = $fila['CliId'];		
					$VehiculoMovimientoSalida->CtiId = $fila['CtiId'];	
					$VehiculoMovimientoSalida->TopId = $fila['TopId'];	
					
					$VehiculoMovimientoSalida->NpaId = $fila['NpaId'];
					$VehiculoMovimientoSalida->VmvCantidadDia = $fila['VmvCantidadDia'];							
				
					$VehiculoMovimientoSalida->AlmId = $fila['AlmId'];
					$VehiculoMovimientoSalida->VmvFecha = $fila['NVmvFecha'];
					$VehiculoMovimientoSalida->VmvDocumentoOrigen = $fila['VmvDocumentoOrigen'];
					
					$VehiculoMovimientoSalida->VmvGuiaRemisionNumero = $fila['VmvGuiaRemisionNumero'];
					list($VehiculoMovimientoSalida->VmvGuiaRemisionNumeroSerie,$VehiculoMovimientoSalida->VmvGuiaRemisionNumeroNumero) = explode("-",$VehiculoMovimientoSalida->VmvGuiaRemisionNumero);
					$VehiculoMovimientoSalida->VmvGuiaRemisionFecha = $fila['NVmvGuiaRemisionFecha'];
					$VehiculoMovimientoSalida->VmvGuiaRemisionFoto = $fila['VmvGuiaRemisionFoto'];
					
					
					$VehiculoMovimientoSalida->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];
					list($VehiculoMovimientoSalida->VmvComprobanteNumeroSerie,$VehiculoMovimientoSalida->VmvComprobanteNumeroNumero) = explode("-",$VehiculoMovimientoSalida->VmvComprobanteNumero);					
					$VehiculoMovimientoSalida->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];
					
					$VehiculoMovimientoSalida->MonId = $fila['MonId'];
					$VehiculoMovimientoSalida->VmvTipoCambio = $fila['VmvTipoCambio'];
					$VehiculoMovimientoSalida->VmvTipoCambioComercial = $fila['VmvTipoCambioComercial'];
					
					$VehiculoMovimientoSalida->VmvIncluyeImpuesto = $fila['VmvIncluyeImpuesto'];
					$VehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta = $fila['VmvPorcentajeImpuestoVenta'];
					
					$VehiculoMovimientoSalida->VmvFoto = $fila['VmvFoto'];
					$VehiculoMovimientoSalida->VmvObservacion = $fila['VmvObservacion'];
		
					$VehiculoMovimientoSalida->VmvSubTotal = $fila['VmvSubTotal'];			
					$VehiculoMovimientoSalida->VmvImpuesto = $fila['VmvImpuesto'];
					$VehiculoMovimientoSalida->VmvTotal = $fila['VmvTotal'];
					
					$VehiculoMovimientoSalida->VmvCancelado = $fila['VmvCancelado'];	
					$VehiculoMovimientoSalida->VmvRevisado = $fila['VmvRevisado'];
					$VehiculoMovimientoSalida->VmvCierre = $fila['VmvCierre'];	
					
		
					$VehiculoMovimientoSalida->VmvTipo = $fila['VmvTipo'];
					$VehiculoMovimientoSalida->VmvSubTipo = $fila['VmvSubTipo'];	
								
					$VehiculoMovimientoSalida->VmvEstado = $fila['VmvEstado'];
					$VehiculoMovimientoSalida->VmvTiempoCreacion = $fila['NVmvTiempoCreacion'];  
					$VehiculoMovimientoSalida->VmvTiempoModificacion = $fila['NVmvTiempoModificacion']; 

					$VehiculoMovimientoSalida->VmvFechaVencimiento = $fila['VmvFechaVencimiento']; 
					$VehiculoMovimientoSalida->VmvDiaTranscurrido = $fila['VmvDiaTranscurrido']; 

					$VehiculoMovimientoSalida->VmvNotaCreditoCompra = $fila['VmvNotaCreditoCompra']; 
					
					$VehiculoMovimientoSalida->VmvTotalItems = $fila['VmvTotalItems']; 
					
					$VehiculoMovimientoSalida->VmvGuiaRemisionSerie = $fila['VmvGuiaRemisionSerie']; 
					$VehiculoMovimientoSalida->VmvGuiaRemisionNumero = $fila['VmvGuiaRemisionNumero']; 
					
					$VehiculoMovimientoSalida->CtiNombre = $fila['CtiNombre']; 
					
					$VehiculoMovimientoSalida->TdoId = $fila['TdoId']; 
					
					$VehiculoMovimientoSalida->CliNombreCompleto = $fila['CliNombreCompleto']; 
					$VehiculoMovimientoSalida->CliNombre = $fila['CliNombre']; 
					$VehiculoMovimientoSalida->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$VehiculoMovimientoSalida->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
					
					$VehiculoMovimientoSalida->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					
					$VehiculoMovimientoSalida->TdoNombre = $fila['TdoNombre']; 

					$VehiculoMovimientoSalida->MonSimbolo = $fila['MonSimbolo']; 
					
					$VehiculoMovimientoSalida->NpaNombre = $fila['NpaNombre']; 
					
					$VehiculoMovimientoSalida->OvvTotal = $fila['OvvTotal']; 
					$VehiculoMovimientoSalida->OvvTipoCambio = $fila['OvvTipoCambio'];
					$VehiculoMovimientoSalida->OvvColor = $fila['OvvColor']; 
					$VehiculoMovimientoSalida->OvvGLP = $fila['OvvGLP']; 
					
					$VehiculoMovimientoSalida->SucNombre = $fila['SucNombre']; 
					$VehiculoMovimientoSalida->SucNombreDestino = $fila['SucNombreDestino']; 
					
						
							
					switch($VehiculoMovimientoSalida->VmvEstado){
					
						case 1:
					$Estado = "En Transito";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	
				
				case 6:
					$Estado = "Anulado";						
				break;
		
						default:
							$Estado = "";
						break;
					
					}
						
					$VehiculoMovimientoSalida->VmvEstadoDescripcion = $Estado;
					
					switch($VehiculoMovimientoSalida->VmvRevisado){
					
						case 1:
							$Revisado = "Revisado";
						break;
					
						case 3:
							$Revisado = "No Revisado";						
						break;	
		
						default:
							$Revisado = "";
						break;
					
					}
						
					$VehiculoMovimientoSalida->VmvRevisadoDescripcion = $Revisado;
					
                    $VehiculoMovimientoSalida->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoMovimientoSalida;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		



    public function MtdObtenerVehiculoMovimientoSalidasValor($oFuncion="SUM",$oParametro="VmvTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL) {

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
				
				

				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					vmd.VmdId

					FROM tblvmdvehiculomovimientodetalle vmd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON vmd.EinId = ein.EinId

							LEFT JOIN tblpcdpedidocompradetalle pcd
							ON vmd.PcdId = pcd.PcdId
								
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
								
									LEFT JOIN tblclicliente cli
									ON pco.CliId = cli.CliId

					WHERE 
						vmd.VmvId = vmv.VmvId AND 
						(
						ein.ProNombre LIKE "%'.$oFiltro.'%" OR
						ein.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						ein.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" OR
						
						cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" OR
						cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%" OR
						cli.CliNumeroDocumento  LIKE "%'.$oFiltro.'%"
						
						)
						
						
						
					) ';
					
									
				$filtrar .= '  ) ';

			

				
					
					
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
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
		

		if(!empty($oEstado)){
			$estado = ' AND vmv.VmvEstado = '.$oEstado;
		}
		

		if(!empty($oOrigen)){
			$origen = ' AND vmv.VmvDocumentoOrigen = '.$oOrigen;
		}
		

		if(!empty($oMoneda)){
			$moneda = ' AND vmv.MonId = "'.$oMoneda.'"';
		}
		
	
		
		
		if(!empty($oCliente)){
			$cliente = ' AND vmv.CliId = "'.$oCliente.'"';
		}	
		
		
		if($oCancelado){
			$cancelado = ' AND vmv.VmvCancelado = '.$oCancelado;
		}
		
		
		if(!empty($oProveedor)){
			$einveedor = ' AND vmv.CliId = "'.$oProveedor.'"';
		}
	
		if(!empty($oCondicionPago)){
			$cpago = ' AND vmv.NpaId = "'.$oCondicionPago.'"';
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND vmv.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oAlmacen)){
			$almacen = ' AND vmv.AlmId = "'.$oAlmacen.'"';
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
		
		
		
			 $sql = 'SELECT
				'.$funcion.' AS "RESULTADO" 

				FROM tblvmvvehiculomovimiento vmv
					
						LEFT JOIN tblnpacondicionpago npa
						ON vmv.NpaId = npa.NpaId
						
					LEFT JOIN tblcticomprobantetipo cti
					ON vmv.CtiId = cti.CtiId
						LEFT JOIN tblclicliente cli
						ON vmv.CliId = cli.CliId
							LEFT JOIN tbltdotipodocumento tdo
							ON cli.TdoId = tdo.TdoId
								LEFT JOIN tblmonmoneda mon
								ON vmv.MonId = mon.MonId
	
							
						
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$sucursal.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarVehiculoMovimientoSalida($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsVehiculoMovimientoSalidaDetalle = new ClsVehiculoMovimientoSalidaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
					
					//MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoSalida=NULL,$oEstado=NULL,$oVehiculo=NULL)
					$ResVehiculoMovimientoSalidaDetalle = $InsVehiculoMovimientoSalidaDetalle->MtdObtenerVehiculoMovimientoSalidaDetalles(NULL,NULL,NULL,'VmdId','DESC',NULL,$elemento,NULL,NULL,NULL);
					$ArrVehiculoMovimientoSalidaDetalles = $ResVehiculoMovimientoSalidaDetalle['Datos'];

					if(!empty($ArrVehiculoMovimientoSalidaDetalles)){
						$vmdetalle = '';

						foreach($ArrVehiculoMovimientoSalidaDetalles as $DatVehiculoMovimientoSalidaDetalle){
							$vmdetalle .= '#'.$DatVehiculoMovimientoSalidaDetalle->VmdId;
						}

						if(!$InsVehiculoMovimientoSalidaDetalle->MtdEliminarVehiculoMovimientoSalidaDetalle($vmdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
						$this->VmvId = $elemento;
						$this->MtdObtenerVehiculoMovimientoSalida();

						$sql = 'DELETE FROM tblvmvvehiculomovimiento WHERE  (VmvId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							
							$this->MtdAuditarVehiculoMovimientoSalida(3,"Se elimino el Compra de Vehiculo",$aux);		
						}
					}
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoVehiculoMovimientoSalida($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
		//$InsVehiculoMovimientoSalidaDetalles = new ClsVehiculoMovimientoSalidaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblvmvvehiculomovimiento SET VmvEstado = '.$oEstado.' WHERE VmvId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarVehiculoMovimientoSalida(2,"Se actualizo el Estado del Compra de Vehiculo",$elemento);
				
					}

					
				}
			$i++;
	
			}

		

	
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				
						
				return true;
			}									
	}
	
	
	
	public function MtdActualizarRevisadoVehiculoMovimientoSalida($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tblcvecompravehiculo SET VmvRevisado = '.$oRevisado.' WHERE VmvId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}

					
				}
			$i++;
	
			}

	
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	public function MtdVerificarExisteVehiculoMovimientoSalida($oCampo,$oDato,$oProveedor=NULL){

		$Respuesta =   NULL;

		if($oProveedor){
			$einveedor = ' AND CliId = "'.$oProveedor.'"';
		}

			$sql = 'SELECT 
			VmvId
			FROM tblvmvvehiculomovimiento
			WHERE '.$oCampo.' = "'.$oDato.'" '.$einveedor.' LIMIT 1;';

			$resultado = $this->InsMysql->MtdConsultar($sql);

			if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
				
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);
				//$this->EinId = $fila['EinId'];
				$Respuesta = $fila['VmvId'];
	
			}
			
			return $Respuesta;
	
		}
	
	
	
	public function MtdRegistrarVehiculoMovimientoSalida() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarVehiculoMovimientoSalidaId();
			
			

		/*	$VehiculoMovimientoSalidaId = $this->MtdVerificarExisteVehiculoMovimientoSalida("VmvComprobanteNumero",$this->VmvComprobanteNumero,$this->CliId);
	
			if(!empty($VehiculoMovimientoSalidaId)){
				$error = true;
				$Resultado.='#ERR_VMS_601';
			}*/
			
			
			
			$sql = 'INSERT INTO tblvmvvehiculomovimiento (
			VmvId,	
			SucId,
			SucIdDestino,
			
			CliId,
			CtiId,
			TopId,
			OvvId,
			
			NpaId,
			VmvCantidadDia,

			AlmId,
			VmvFecha,
			
			VmvGuiaRemisionNumero,
			VmvGuiaRemisionFecha,
			VmvGuiaRemisionFoto,
			
			VmvComprobanteNumero,
			VmvComprobanteFecha,
			MonId,
			VmvTipoCambio,
			
			VmvIncluyeImpuesto,
			VmvPorcentajeImpuestoVenta,
					
			VmvFoto,
			VmvObservacion,
			
			VmvSubTotal,
			VmvImpuesto,				
			VmvTotal,
				
			VmvCancelado,
			VmvRevisado,
			VmvFacturable,
			
			VmvCierre,
			
			
			VmvTipo,
			VmvSubTipo,
		
			VmvEstado,			
			VmvTiempoCreacion,
			VmvTiempoModificacion) 
			VALUES (
			"'.($this->VmvId).'", 
			"'.($this->SucId).'", 			
			'.(empty($this->SucIdDestino)?'NULL, ':'"'.$this->SucIdDestino.'",').'
			
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			'.(empty($this->CtiId)?'NULL, ':'"'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
			'.(empty($this->OvvId)?'NULL, ':'"'.$this->OvvId.'",').'
					
			'.(empty($this->NpaId)?'NULL, ':'"'.$this->NpaId.'",').'	
			'.($this->VmvCantidadDia).',
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			"'.($this->VmvFecha).'", 
		
			"'.($this->VmvGuiaRemisionNumero).'", 
			'.(empty($this->VmvGuiaRemisionFecha)?'NULL, ':'"'.$this->VmvGuiaRemisionFecha.'",').'
			"'.($this->VmvGuiaRemisionFoto).'", 
			
			'.(empty($this->VmvComprobanteNumero)?'NULL, ':'"'.$this->VmvComprobanteNumero.'",').'
			'.(empty($this->VmvComprobanteFecha)?'NULL, ':'"'.$this->VmvComprobanteFecha.'",').'
			"'.($this->MonId).'",
			'.(empty($this->VmvTipoCambio)?'NULL, ':'"'.$this->VmvTipoCambio.'",').'
			
			'.($this->VmvIncluyeImpuesto).',
			'.($this->VmvPorcentajeImpuestoVenta).',

			"'.($this->VmvFoto).'",
			"'.($this->VmvObservacion).'",

			'.($this->VmvSubTotal).',
			'.($this->VmvImpuesto).',
			'.($this->VmvTotal).',
			
			2,
			2,
			1,
			
			2,
			
			2,
			'.($this->VmvSubTipo).',
			
			'.($this->VmvEstado).',
			"'.($this->VmvTiempoCreacion).'", 			
			"'.($this->VmvTiempoModificacion).'");';			
		
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			
			if(!$resultado) {							
				$error = true;
			} 


//			if(round($this->VmvValorTotal) <> round($this->VmvSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_VMS_110';
//			}


			if(!$error){			
			
				if (!empty($this->VehiculoMovimientoSalidaDetalle)){		
						
					$validar = 0;				
					$InsVehiculoMovimientoSalidaDetalle = new ClsVehiculoMovimientoSalidaDetalle();		
					
					foreach ($this->VehiculoMovimientoSalidaDetalle as $DatVehiculoMovimientoSalidaDetalle){
					
						$InsVehiculoMovimientoSalidaDetalle->VmvId = $this->VmvId;
						$InsVehiculoMovimientoSalidaDetalle->EinId = $DatVehiculoMovimientoSalidaDetalle->EinId;
						$InsVehiculoMovimientoSalidaDetalle->UmeId = $DatVehiculoMovimientoSalidaDetalle->UmeId;
						$InsVehiculoMovimientoSalidaDetalle->VehId = $DatVehiculoMovimientoSalidaDetalle->VehId;
						$InsVehiculoMovimientoSalidaDetalle->AlmId = $DatVehiculoMovimientoSalidaDetalle->AlmId;
						
						$InsVehiculoMovimientoSalidaDetalle->VmdFecha = $DatVehiculoMovimientoSalidaDetalle->VmdFecha;
				
						$InsVehiculoMovimientoSalidaDetalle->VmdIdAnterior = $DatVehiculoMovimientoSalidaDetalle->VmdIdAnterior;
						$InsVehiculoMovimientoSalidaDetalle->VmdValorTotal = $DatVehiculoMovimientoSalidaDetalle->VmdValorTotal;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoPromedio = $DatVehiculoMovimientoSalidaDetalle->VmdCostoPromedio;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoExtraUnitario = $DatVehiculoMovimientoSalidaDetalle->VmdCostoExtraUnitario;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoExtraTotal = $DatVehiculoMovimientoSalidaDetalle->VmdCostoExtraTotal;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoAnterior = $DatVehiculoMovimientoSalidaDetalle->VmdCostoAnterior;
						$InsVehiculoMovimientoSalidaDetalle->VmdCosto = $DatVehiculoMovimientoSalidaDetalle->VmdCosto;					
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoIngreso = $DatVehiculoMovimientoSalidaDetalle->VmdCostoIngreso;					
						
						
						
							
						$InsVehiculoMovimientoSalidaDetalle->VmdCantidad = $DatVehiculoMovimientoSalidaDetalle->VmdCantidad;
						$InsVehiculoMovimientoSalidaDetalle->VmdImporte = $DatVehiculoMovimientoSalidaDetalle->VmdImporte;
						
						$InsVehiculoMovimientoSalidaDetalle->VmdUbicacion = $DatVehiculoMovimientoSalidaDetalle->VmdUbicacion;
						$InsVehiculoMovimientoSalidaDetalle->VmdObservacion = $DatVehiculoMovimientoSalidaDetalle->VmdObservacion;
						
						
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica1 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica1;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica2 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica2;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica3 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica3;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica4 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica4;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica5 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica5;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica6 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica6;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica7 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica7;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica8 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica8;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica9 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica9;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica10 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica10;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica11 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica11;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica12 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica12;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica13 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica13;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica14 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica14;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica15 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica15;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica16 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica16;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica17 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica17;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica18 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica18;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica19 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica19;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica20 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica20;

						$InsVehiculoMovimientoSalidaDetalle->VmdEstado = $DatVehiculoMovimientoSalidaDetalle->VmdEstado;									
						$InsVehiculoMovimientoSalidaDetalle->VmdTiempoCreacion = $DatVehiculoMovimientoSalidaDetalle->VmdTiempoCreacion;
						$InsVehiculoMovimientoSalidaDetalle->VmdTiempoModificacion = $DatVehiculoMovimientoSalidaDetalle->VmdTiempoModificacion;						
						$InsVehiculoMovimientoSalidaDetalle->VmdEliminado = $DatVehiculoMovimientoSalidaDetalle->VmdEliminado;
						
						if($InsVehiculoMovimientoSalidaDetalle->MtdRegistrarVehiculoMovimientoSalidaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VMS_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoMovimientoSalidaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
					
				
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarVehiculoMovimientoSalida(1,"Se registro el Compra de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarVehiculoMovimientoSalida() {

		global $Resultado;
		$error = false;

			
			$sql = 'UPDATE tblvmvvehiculomovimiento SET
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
			'.(empty($this->NpaId)?'NpaId = NULL, ':'NpaId = "'.$this->NpaId.'",').'
			'.(empty($this->SucIdDestino)?'SucIdDestino = NULL, ':'SucIdDestino = "'.$this->SucIdDestino.'",').'
			
			VmvCantidadDia = '.($this->VmvCantidadDia).',
			
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
			
			VmvFecha = "'.($this->VmvFecha).'",
		
			VmvGuiaRemisionNumero = "'.($this->VmvGuiaRemisionNumero).'",
			'.(empty($this->VmvGuiaRemisionFecha)?'VmvGuiaRemisionFecha = NULL, ':'VmvGuiaRemisionFecha = "'.$this->VmvGuiaRemisionFecha.'",').'
			VmvGuiaRemisionFoto = "'.($this->VmvGuiaRemisionFoto).'",
			
			'.(empty($this->VmvComprobanteNumero)?'VmvComprobanteNumero = NULL, ':'VmvComprobanteNumero = "'.$this->VmvComprobanteNumero.'",').'
			
			'.(empty($this->VmvComprobanteFecha)?'VmvComprobanteFecha = NULL, ':'VmvComprobanteFecha = "'.$this->VmvComprobanteFecha.'",').'
			MonId = "'.($this->MonId).'",
			VmvTipoCambio = '.($this->VmvTipoCambio).',
			
			VmvIncluyeImpuesto = '.($this->VmvIncluyeImpuesto).',
			VmvPorcentajeImpuestoVenta = '.($this->VmvPorcentajeImpuestoVenta).',						
			
			VmvFoto = "'.($this->VmvFoto).'",
			VmvObservacion = "'.($this->VmvObservacion).'",

			VmvSubTotal = '.($this->VmvSubTotal).',
			VmvImpuesto = '.($this->VmvImpuesto).',
			VmvTotal = '.($this->VmvTotal).',
			
			VmvEstado = '.($this->VmvEstado).'
			WHERE VmvId = "'.($this->VmvId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			


			//if(round($this->VmvValorTotal) <> round($this->VmvSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_VMS_110';
//			}
			
			
			if(!$error){
			
				if (!empty($this->VehiculoMovimientoSalidaDetalle)){		
						
						
					$validar = 0;				
					$InsVehiculoMovimientoSalidaDetalle = new ClsVehiculoMovimientoSalidaDetalle();
							
					foreach ($this->VehiculoMovimientoSalidaDetalle as $DatVehiculoMovimientoSalidaDetalle){
										
						$InsVehiculoMovimientoSalidaDetalle->VmdId = $DatVehiculoMovimientoSalidaDetalle->VmdId;
						$InsVehiculoMovimientoSalidaDetalle->VmvId = $this->VmvId;
						$InsVehiculoMovimientoSalidaDetalle->EinId = $DatVehiculoMovimientoSalidaDetalle->EinId;
						$InsVehiculoMovimientoSalidaDetalle->UmeId = $DatVehiculoMovimientoSalidaDetalle->UmeId;
						$InsVehiculoMovimientoSalidaDetalle->VehId = $DatVehiculoMovimientoSalidaDetalle->VehId;
						$InsVehiculoMovimientoSalidaDetalle->AlmId = $DatVehiculoMovimientoSalidaDetalle->AlmId;
						$InsVehiculoMovimientoSalidaDetalle->VmdFecha = $DatVehiculoMovimientoSalidaDetalle->VmdFecha;
						
						$InsVehiculoMovimientoSalidaDetalle->VmdIdAnterior = $DatVehiculoMovimientoSalidaDetalle->VmdIdAnterior;
						$InsVehiculoMovimientoSalidaDetalle->VmdValorTotal = $DatVehiculoMovimientoSalidaDetalle->VmdValorTotal;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoPromedio = $DatVehiculoMovimientoSalidaDetalle->VmdCostoPromedio;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoExtraUnitario = $DatVehiculoMovimientoSalidaDetalle->VmdCostoExtraUnitario;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoExtraTotal = $DatVehiculoMovimientoSalidaDetalle->VmdCostoExtraTotal;
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoAnterior = $DatVehiculoMovimientoSalidaDetalle->VmdCostoAnterior;
						$InsVehiculoMovimientoSalidaDetalle->VmdCosto = $DatVehiculoMovimientoSalidaDetalle->VmdCosto;				
						$InsVehiculoMovimientoSalidaDetalle->VmdCostoIngreso = $DatVehiculoMovimientoSalidaDetalle->VmdCostoIngreso;						
						
						
						
						
						$InsVehiculoMovimientoSalidaDetalle->VmdCantidad = $DatVehiculoMovimientoSalidaDetalle->VmdCantidad;
						$InsVehiculoMovimientoSalidaDetalle->VmdImporte = $DatVehiculoMovimientoSalidaDetalle->VmdImporte;
						$InsVehiculoMovimientoSalidaDetalle->VmdUbicacion = $DatVehiculoMovimientoSalidaDetalle->VmdUbicacion;
						$InsVehiculoMovimientoSalidaDetalle->VmdObservacion = $DatVehiculoMovimientoSalidaDetalle->VmdObservacion;
						
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica1 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica1;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica2 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica2;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica3 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica3;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica4 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica4;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica5 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica5;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica6 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica6;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica7 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica7;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica8 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica8;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica9 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica9;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica10 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica10;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica11 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica11;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica12 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica12;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica13 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica13;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica14 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica14;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica15 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica15;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica16 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica16;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica17 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica17;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica18 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica18;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica19 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica19;
						$InsVehiculoMovimientoSalidaDetalle->VmdCaracteristica20 = $DatVehiculoMovimientoSalidaDetalle->VmdCaracteristica20;
						
						$InsVehiculoMovimientoSalidaDetalle->VmdEstado = $DatVehiculoMovimientoSalidaDetalle->VmdEstado;		
						$InsVehiculoMovimientoSalidaDetalle->VmdTiempoCreacion = $DatVehiculoMovimientoSalidaDetalle->VmdTiempoCreacion;
						$InsVehiculoMovimientoSalidaDetalle->VmdTiempoModificacion = $DatVehiculoMovimientoSalidaDetalle->VmdTiempoModificacion;
						$InsVehiculoMovimientoSalidaDetalle->VmdEliminado = $DatVehiculoMovimientoSalidaDetalle->VmdEliminado;
						
						
						if(empty($InsVehiculoMovimientoSalidaDetalle->VmdId)){
							if($InsVehiculoMovimientoSalidaDetalle->VmdEliminado<>2){
								if($InsVehiculoMovimientoSalidaDetalle->MtdRegistrarVehiculoMovimientoSalidaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VMS_201';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoMovimientoSalidaDetalle->VmdEliminado==2){
								if($InsVehiculoMovimientoSalidaDetalle->MtdEliminarVehiculoMovimientoSalidaDetalle($InsVehiculoMovimientoSalidaDetalle->VmdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VMS_203';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoMovimientoSalidaDetalle->MtdEditarVehiculoMovimientoSalidaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VMS_202';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoMovimientoSalidaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarVehiculoMovimientoSalida(2,"Se edito el Compra de Vehiculo",$this);		
				return true;
			}	
				
		}
		
		
	
		public function MtdEditarVehiculoMovimientoSalidaDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblvmvvehiculomovimiento SET 
			'.$oCampo.' = "'.($oDato).'",
			VmvTiempoModificacion = NOW()
			WHERE VmvId = "'.($oId).'";';
			
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



		private function MtdAuditarVehiculoMovimientoSalida($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->VmvId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		public function MtdNotificarAlmacennMovimientoSalidaOrdenCompra($oVehiculoMovimientoSalida,$oDestinatario,$oImportante=false){
			
global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->VmvId = $oVehiculoMovimientoSalida;
			$this->MtdObtenerVehiculoMovimientoSalida();
			
			$InsOrdenCompra = new ClsOrdenCompra();
			$InsOrdenCompra->OcoId = $this->OcoId;
			$InsOrdenCompra->MtdObtenerOrdenCompra();
			

							
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Ingreso a almacen c/ Orden de Compra .";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->VmvId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Proveedor: <b>".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->VmvFecha."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Orden de Compra: <b>".$this->OcoId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			$mensaje .= "Datos del comeinbante";	
			$mensaje .= "<br>";
			$mensaje .= "Tipo: <b>".$this->CtiNombre."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Numero : <b>".$this->VmvComprobanteNumero."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Fecha : <b>".$this->VmvComprobanteFecha."</b>";				
			$mensaje .= "<br>";
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";

			if(!empty($InsOrdenCompra->OrdenCompraPedido)){
				foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
					

			
					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra->MtdObtenerPedidoCompra();
					
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
					$mensaje .= "<table>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Cliente: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno." ".$InsPedidoCompra->CliApellidoMaterno;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Fecha: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->PcoFecha;
						$mensaje .= "</b></td>";
						
						
						$mensaje .= "<td>";
						$mensaje .= "Ord. Ven.: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiId;
						$mensaje .= "</b></td>";
						
						
						$mensaje .= "<td>";
						$mensaje .= "O/C Ref: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiOrdenCompraNumero." - ".$InsPedidoCompra->VdiOrdenCompraFecha;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
									
					$mensaje .= "</table>";
									
									
									


					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cod. Original";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Nombre";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Cantidad";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Estado";
						$mensaje .= "</td>";
						
						
		
					$mensaje .= "</tr>";

					
					$i = 1;
					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
							$mensaje .= "<tr>";


								if(empty($DatPedidoCompraDetalle->VmdCantidad)){
									$fondo = "#F30";
								}else if($DatPedidoCompraDetalle->VmdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$fondo = "#6F3";
								}else if($DatPedidoCompraDetalle->VmdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
									$fondo = "#FC0";		
								}else{
									$fondo = "";	
								}
								
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
								$mensaje .= "</td>";
				
								$mensaje .= "<td bgcolor='".$fondo."'>";
								
								if(empty($DatPedidoCompraDetalle->VmdCantidad)){
									$mensaje .= "No Atendido";
								}else if($DatPedidoCompraDetalle->VmdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Ya llego";
								}else if($DatPedidoCompraDetalle->VmdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Incompleto, aun faltan (".($DatPedidoCompraDetalle->PcdCantidad - $DatPedidoCompraDetalle->VmdCantidad).") items";
								}else{
									$mensaje .= "</td>";
								}
								
								$mensaje .= "</td>";

							$mensaje .= "</tr>";
							$i++;							
						}
					}
					
					$mensaje .= "</table>";
					

					
				}
			}
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			///echo $mensaje;
			
			if($oImportante){
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->CliNombre." ".$this->CliApellidoPaterno." [IMPORTANTE]".$this->CliApellidoMaterno,$mensaje);
						
			}else{
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
					
			}
			
				
				
			
		}
		
//		MtdNotificarAlmacennMovimientoSalidaOrdenCompra
		public function MtdNotificarVehiculoMovimientoSalidaVencimiento($oDestinatario,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL,$oProveedor=NULL){
		
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$Enviar = false;
			
			$ProveedorNombre = "";
			$ProveedorNumeroDocumento = "";
			
			if(!empty($oProveedor)){
				
				$InsProveedor = new ClsProveedor();
				$InsProveedor->CliId = $oProveedor;
				$InsProveedor->MtdObtenerProveedor();
				
				$ProveedorNombre = $InsProveedor->CliNombre." ".$InsProveedor->CliApellidoPaterno." ".$InsProveedor->CliApellidoMaterno;
				$ProveedorNumeroDocumento = $InsProveedor->CliNumeroDocumento;
				$ProveedorTipoDocumento = $InsProveedor->TdoNombre;
				
			}
			
			$mensaje .= "AVISO DE VENCIMIENTO DE FACTURAS:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

		
			$mensaje .= "Fecha de aviso: <b>".date("d/m/Y")."</b>";	
			$mensaje .= "<br>";	
			
			if(!empty($oProveedor)){
				
				$mensaje .= "Proveedor: <b>".$ProveedorNombre."</b>";	
				$mensaje .= "<br>";
				
				$mensaje .= "Num.Doc.: <b>".$ProveedorTipoDocumento."/".$ProveedorNumeroDocumento."</b>";	
				$mensaje .= "<br>";		
							
			}
			
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
			
			$InsMoneda = new ClsMoneda();
			$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","DESC",NULL);
			$ArrMonedas = $ResMoneda['Datos'];

			foreach($ArrMonedas as $DatMoneda){
			
				$mensaje .= "<br>";
				//MtdObtenerVehiculoMovimientoSalidas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL) {
				$ResVehiculoMovimientoSalida = $this->MtdObtenerVehiculoMovimientoSalidas(NULL,NULL,NULL,"VmvComprobanteFecha","ASC",NULL,FncCambiaFechaAMysql($oFechaInicio),FncCambiaFechaAMysql($oFechaFin),NULL,NULL,$DatMoneda->MonId,NULL,NULL,NULL,NULL,"VmvComprobanteFecha",0,2,$oProveedor,NULL,$oCondicionPago);
				$ArrVehiculoMovimientoSalidas = $ResVehiculoMovimientoSalida['Datos'];

				if(!empty($ArrVehiculoMovimientoSalidas)){
				
					$mensaje .= "<b>RELACION DE FACTURAS EN ".$DatMoneda->MonNombre." (".$DatMoneda->MonSimbolo.") </b>" ;
					$mensaje .= "<br>";
					
					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td width='2%'>";
						$mensaje .= "<b>#</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>COND. PAGO</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "<b>NUM. COMPROB.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>FECHA COMPROB.</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='10%'>";
						$mensaje .= "<b>NUM. DOC.</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='60%'>";
						$mensaje .= "<b>PROVEEDOR</b>";
						$mensaje .= "</td>";

						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>MONEDA</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>ORD. COMPRA</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>CRED. CANT. DIAS</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>FECHA VENC.</b>";
						$mensaje .= "</td>";
						
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>TOTAL</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>VMSRT.</b>";
						$mensaje .= "</td>";
						
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>SALDO</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>VENCIMIENTO</b>";
						$mensaje .= "</td>";
						
						
					$mensaje .= "</tr>";
					
					
							
				$c = 1;	
				
				foreach($ArrVehiculoMovimientoSalidas as $DatVehiculoMovimientoSalida){


					$DatVehiculoMovimientoSalida->VmvTotal = (($EmpresaMonedaId==$DatMoneda->MonId or empty($DatMoneda->MonId))?$DatVehiculoMovimientoSalida->VmvTotal:($DatVehiculoMovimientoSalida->VmvTotal/$DatVehiculoMovimientoSalida->VmvTipoCambio));
				
					$DatVehiculoMovimientoSalida->VmvTotal = round($DatVehiculoMovimientoSalida->VmvTotal,2);
					
					$Mostrar = true;

					if($DatVehiculoMovimientoSalida->NpaId == "NPA-10001"){
						
						settype($DatVehiculoMovimientoSalida->VmvTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatVehiculoMovimientoSalida->VmvTotal+1000)){
							if($DatVehiculoMovimientoSalida->VmvCantidadDia<$DatVehiculoMovimientoSalida->VmvDiaTranscurrido){
								
							}else if ( ($DatVehiculoMovimientoSalida->VmvCantidadDia - $DatVehiculoMovimientoSalida->VmvDiaTranscurrido) >= 1 and ($DatVehiculoMovimientoSalida->VmvCantidadDia - $DatVehiculoMovimientoSalida->VmvDiaTranscurrido) <=3 ){
				
							}else{
								
								$Mostrar = false;
								
							}
						}
						
					}
	
				if($Mostrar){
						
					$mensaje .= "<tr>";
									
					$mensaje .= "<td>";
					$mensaje .= $c;
					$mensaje .= "</td>";
	
					$mensaje .= "<td>";
					$mensaje .= $DatVehiculoMovimientoSalida->NpaNombre;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= "<span title='".$DatVehiculoMovimientoSalida->VmvId."'>".$DatVehiculoMovimientoSalida->VmvComprobanteNumero."</span>";
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatVehiculoMovimientoSalida->VmvComprobanteFecha;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatVehiculoMovimientoSalida->CliNumeroDocumento;
					$mensaje .= "</td>";

					
					$mensaje .= "<td>";
					$mensaje .= $DatVehiculoMovimientoSalida->CliNombreCompleto;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatVehiculoMovimientoSalida->MonSimbolo;
					$mensaje .= "</td>";
					
					
					$mensaje .= "<td>";
					$mensaje .= $DatVehiculoMovimientoSalida->OcoId;
					$mensaje .= "</td>";
							
					$mensaje .= "<td>";
					
					if($DatVehiculoMovimientoSalida->NpaId == "NPA-10001"){
					
						$mensaje .= $DatVehiculoMovimientoSalida->VmvCantidadDia;
						
						if($DatVehiculoMovimientoSalida->VmvCantidadDia <=30){
							$TotalCredito30 += $DatVehiculoMovimientoSalida->VmvTotal;
						}else{
							$TotalCredito30Mas += $DatVehiculoMovimientoSalida->VmvTotal;
						}
					
					}else{
						$TotalContado += $DatVehiculoMovimientoSalida->VmvTotal;
					}
					
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatVehiculoMovimientoSalida->VmvFechaVencimiento;
					$mensaje .= "</td>";
								
					$mensaje .= "<td>";
					$mensaje .= number_format($DatVehiculoMovimientoSalida->VmvTotal,2);
					$mensaje .= "</td>";
								

		
					$ProveedorPagoMontoTotal = 0;

					switch($DatVehiculoMovimientoSalida->VmvCancelado){
					
						case 1:
							$ProveedorPagoMontoTotal = $DatVehiculoMovimientoSalida->VmvTotal;					
						break;
					
						case 2:
									
						break;	

					}
				
					$mensaje .= "<td>";
					$mensaje .= $ProveedorPagoMontoTotal;
					$mensaje .= "</td>";
					
					settype($DatVehiculoMovimientoSalida->VmvTotal ,"float");
					settype($ProveedorPagoMontoTotal ,"float");
					
					$VehiculoMovimientoSalidaSaldo = round($DatVehiculoMovimientoSalida->VmvTotal,2) - round($ProveedorPagoMontoTotal,2);
		
						
					$mensaje .= "<td>";
					$mensaje .= number_format($VehiculoMovimientoSalidaSaldo,2);
					$mensaje .= "</td>";
					
					
		
					$mensaje .= "<td>";

	
					if($DatVehiculoMovimientoSalida->NpaId == "NPA-10001"){
						
						settype($DatVehiculoMovimientoSalida->VmvTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatVehiculoMovimientoSalida->VmvTotal+1000)){
							if($DatVehiculoMovimientoSalida->VmvCantidadDia<$DatVehiculoMovimientoSalida->VmvDiaTranscurrido){
								
								$mensaje .= "VENCIDO ";
								$mensaje .= ($DatVehiculoMovimientoSalida->VmvDiaTranscurrido - $DatVehiculoMovimientoSalida->VmvCantidadDia)." dias";
								
							}else if ( ($DatVehiculoMovimientoSalida->VmvCantidadDia - $DatVehiculoMovimientoSalida->VmvDiaTranscurrido) >= 1 and ($DatVehiculoMovimientoSalida->VmvCantidadDia - $DatVehiculoMovimientoSalida->VmvDiaTranscurrido) <=3 ){
								
								$mensaje .= "POR VENCER ";				
								$mensaje .= ($DatVehiculoMovimientoSalida->VmvCantidadDia - $DatVehiculoMovimientoSalida->VmvDiaTranscurrido)." dias";
				
							}else{
								
								$mensaje .= "VIGENTE ";
								
							}
						}
						
					}
	
					$mensaje .= "</td>";
	
	
					$mensaje .= "</tr>";

					$c++;			
					
				
					$Enviar = true;
					
					}
					
					
							
				}
				

					
						
					$mensaje .= "</table>";
					
					
				}
				
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
			echo $mensaje;
			
			if($Enviar){
				
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"AVISO: FACTURAS C/ CREDITO - ".$ProveedorNombre,$mensaje);
				
			}
				
				
				
				
		}

		
		/*public function MtdEditarVehiculoMovimientoSalidaDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblnccnotacreditocompra SET 
			'.(empty($oDato)?$oCampo.' = NULL  ':$oCampo.' = "'.$oDato.'" ').'
		
			WHERE VmvId = "'.($oId).'";';
			
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