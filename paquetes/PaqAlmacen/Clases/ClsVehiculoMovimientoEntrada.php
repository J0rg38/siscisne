<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoMovimientoEntrada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoMovimientoEntrada {

    public $VmvId;
	public $VmvTipo;
	public $VmvSubTipo;
	public $PrvId;
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
	public $PrvNombre;
	public $PrvNumeroDocumento;
	
	public $TdoNombre;
	
	public $MonSimbolo;
	
	public $VehiculoMovimientoEntradaDetalle;
	public $VehiculoMovimientoEntradaExtorno;
	public $OrdenCompraPedido;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarVehiculoMovimientoEntradaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(vmv.VmvId,5),unsigned)) AS "MAXIMO"
		FROM tblvmvvehiculomovimiento vmv
		WHERE vmv.VmvTipo = 1
		';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->VmvId = "VME-10000";
		}else{
			$fila['MAXIMO']++;
			$this->VmvId = "VME-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerVehiculoMovimientoEntrada(){

        $sql = 'SELECT 
        vmv.VmvId,  
		vmv.SucId,
	
		vmv.PrvId,
        vmv.CliId,
        
		vmv.CtiId,
		vmv.TopId,
		
        vmv.OvvId,
       
		
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
		
		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		
		prv.PrvNumeroDocumento,
		prv.TdoId,
				
		mon.MonSimbolo
		
        FROM tblvmvvehiculomovimiento vmv
		
			LEFT JOIN tblcticomprobantetipo cti
			ON vmv.CtiId = cti.CtiId
				LEFT JOIN tblprvproveedor prv
				ON vmv.PrvId = prv.PrvId
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
						LEFT JOIN tblmonmoneda mon
						ON vmv.MonId = mon.MonId		

        WHERE vmv.VmvId = "'.$this->VmvId.'" ';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->VmvId = $fila['VmvId'];
			$this->SucId = $fila['SucId'];		
			
			$this->PrvId = $fila['PrvId'];
            $this->CliId = $fila['CliId'];
            
            		
			$this->CtiId = $fila['CtiId'];		
			$this->TopId = $fila['TopId'];
            
            $this->OvvId = $fila['OvvId'];		
			
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

			$this->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
			$this->PrvNombre = $fila['PrvNombre']; 	
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId']; 	
			$this->TdoNombre = $fila['TdoNombre'];

			$this->MonSimbolo = $fila['MonSimbolo']; 	

			
			$InsVehiculoMovimientoEntradaDetalle = new ClsVehiculoMovimientoEntradaDetalle();
			//MtdObtenerVehiculoMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoEntrada=NULL,$oEstado=NULL,$oVehiculo=NULL)
			$ResVehiculoMovimientoEntradaDetalle =  $InsVehiculoMovimientoEntradaDetalle->MtdObtenerVehiculoMovimientoEntradaDetalles(NULL,NULL,NULL,"VmdId","ASC",NULL,$this->VmvId);				
			$this->VehiculoMovimientoEntradaDetalle = 	$ResVehiculoMovimientoEntradaDetalle['Datos'];	


			switch($this->VmvEstado){
			
				case 1:
					$Estado = "No Realizado";
				break;
			
				case 3:
					$Estado = "Realizado";						
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

    public function MtdObtenerVehiculoMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oSubTipo=NULL) {

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
			$einveedor = ' AND vmv.PrvId = "'.$oProveedor.'"';
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
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vmv.VmvId,				
				vmv.SucId,
				
				vmv.PrvId,
                vmv.CliId,
                
				vmv.CtiId,
				vmv.TopId,
				vmv.OvvId,
                
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
				
				(SELECT COUNT(vmd.VmdId) FROM tblvmdvehiculomovimientodetalle vmd WHERE vmd.VmvId = vmv.VmvId ) AS "VmvTotalItems",

				cti.CtiNombre,
				
				prv.TdoId,

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre,				
				mon.MonSimbolo,				
				npa.NpaNombre,
				
				suc.SucNombre				

				FROM tblvmvvehiculomovimiento vmv
					
					LEFT JOIN tblnpacondicionpago npa
					ON vmv.NpaId = npa.NpaId
						LEFT JOIN tblcticomprobantetipo cti
						ON vmv.CtiId = cti.CtiId
							LEFT JOIN tblprvproveedor prv
							ON vmv.PrvId = prv.PrvId
								LEFT JOIN tbltdotipodocumento tdo
								ON prv.TdoId = tdo.TdoId
									LEFT JOIN tblmonmoneda mon
									ON vmv.MonId = mon.MonId
										LEFT JOIN tblsucsucursal suc
										ON vmv.SucId = suc.SucId
	
				WHERE 1 = 1 AND vmv.VmvTipo = 1 '.$filtrar.$sucursal.$fecha.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoEntrada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoEntrada = new $InsVehiculoMovimientoEntrada();
                    $VehiculoMovimientoEntrada->VmvId = $fila['VmvId'];
					$VehiculoMovimientoEntrada->SucId = $fila['SucId'];
					
					$VehiculoMovimientoEntrada->PrvId = $fila['PrvId'];	
                    $VehiculoMovimientoEntrada->CliId = $fila['CliId'];		
					$VehiculoMovimientoEntrada->CtiId = $fila['CtiId'];	
					$VehiculoMovimientoEntrada->TopId = $fila['TopId'];	
                    $VehiculoMovimientoEntrada->OvvId = $fila['OvvId'];
					
					$VehiculoMovimientoEntrada->NpaId = $fila['NpaId'];
					$VehiculoMovimientoEntrada->VmvCantidadDia = $fila['VmvCantidadDia'];							
				
					$VehiculoMovimientoEntrada->AlmId = $fila['AlmId'];
					$VehiculoMovimientoEntrada->VmvFecha = $fila['NVmvFecha'];
					$VehiculoMovimientoEntrada->VmvDocumentoOrigen = $fila['VmvDocumentoOrigen'];
					
					$VehiculoMovimientoEntrada->VmvGuiaRemisionNumero = $fila['VmvGuiaRemisionNumero'];
					list($VehiculoMovimientoEntrada->VmvGuiaRemisionNumeroSerie,$VehiculoMovimientoEntrada->VmvGuiaRemisionNumeroNumero) = explode("-",$VehiculoMovimientoEntrada->VmvGuiaRemisionNumero);
					$VehiculoMovimientoEntrada->VmvGuiaRemisionFecha = $fila['NVmvGuiaRemisionFecha'];
					$VehiculoMovimientoEntrada->VmvGuiaRemisionFoto = $fila['VmvGuiaRemisionFoto'];
					
					
					$VehiculoMovimientoEntrada->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];
					list($VehiculoMovimientoEntrada->VmvComprobanteNumeroSerie,$VehiculoMovimientoEntrada->VmvComprobanteNumeroNumero) = explode("-",$VehiculoMovimientoEntrada->VmvComprobanteNumero);					
					$VehiculoMovimientoEntrada->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];
					
					$VehiculoMovimientoEntrada->MonId = $fila['MonId'];
					$VehiculoMovimientoEntrada->VmvTipoCambio = $fila['VmvTipoCambio'];
					$VehiculoMovimientoEntrada->VmvTipoCambioComercial = $fila['VmvTipoCambioComercial'];
					
					$VehiculoMovimientoEntrada->VmvIncluyeImpuesto = $fila['VmvIncluyeImpuesto'];
					$VehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta = $fila['VmvPorcentajeImpuestoVenta'];
					
					$VehiculoMovimientoEntrada->VmvFoto = $fila['VmvFoto'];
					$VehiculoMovimientoEntrada->VmvObservacion = $fila['VmvObservacion'];
		
					$VehiculoMovimientoEntrada->VmvSubTotal = $fila['VmvSubTotal'];			
					$VehiculoMovimientoEntrada->VmvImpuesto = $fila['VmvImpuesto'];
					$VehiculoMovimientoEntrada->VmvTotal = $fila['VmvTotal'];
					
					$VehiculoMovimientoEntrada->VmvCancelado = $fila['VmvCancelado'];	
					$VehiculoMovimientoEntrada->VmvRevisado = $fila['VmvRevisado'];
					$VehiculoMovimientoEntrada->VmvCierre = $fila['VmvCierre'];	
					
		
					$VehiculoMovimientoEntrada->VmvTipo = $fila['VmvTipo'];
					$VehiculoMovimientoEntrada->VmvSubTipo = $fila['VmvSubTipo'];	
								
					$VehiculoMovimientoEntrada->VmvEstado = $fila['VmvEstado'];
					$VehiculoMovimientoEntrada->VmvTiempoCreacion = $fila['NVmvTiempoCreacion'];  
					$VehiculoMovimientoEntrada->VmvTiempoModificacion = $fila['NVmvTiempoModificacion']; 

					$VehiculoMovimientoEntrada->VmvFechaVencimiento = $fila['VmvFechaVencimiento']; 
					$VehiculoMovimientoEntrada->VmvDiaTranscurrido = $fila['VmvDiaTranscurrido']; 

					$VehiculoMovimientoEntrada->VmvNotaCreditoCompra = $fila['VmvNotaCreditoCompra']; 
					
					$VehiculoMovimientoEntrada->VmvTotalItems = $fila['VmvTotalItems']; 
					
					$VehiculoMovimientoEntrada->CtiNombre = $fila['CtiNombre']; 
					
					$VehiculoMovimientoEntrada->TdoId = $fila['TdoId']; 
					
					$VehiculoMovimientoEntrada->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$VehiculoMovimientoEntrada->PrvNombre = $fila['PrvNombre']; 
					$VehiculoMovimientoEntrada->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$VehiculoMovimientoEntrada->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					
					$VehiculoMovimientoEntrada->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					
					$VehiculoMovimientoEntrada->TdoNombre = $fila['TdoNombre']; 

					$VehiculoMovimientoEntrada->MonSimbolo = $fila['MonSimbolo']; 
					
					$VehiculoMovimientoEntrada->NpaNombre = $fila['NpaNombre']; 
					
					$VehiculoMovimientoEntrada->SucNombre = $fila['SucNombre']; 
					
				
					switch($VehiculoMovimientoEntrada->VmvEstado){
					
						case 1:
							$Estado = "No Realizado";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
						
					$VehiculoMovimientoEntrada->VmvEstadoDescripcion = $Estado;
					
					switch($VehiculoMovimientoEntrada->VmvRevisado){
					
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
						
					$VehiculoMovimientoEntrada->VmvRevisadoDescripcion = $Revisado;
					
                    $VehiculoMovimientoEntrada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoMovimientoEntrada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		



    public function MtdObtenerVehiculoMovimientoEntradasValor($oFuncion="SUM",$oParametro="VmvTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL) {

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
			$einveedor = ' AND vmv.PrvId = "'.$oProveedor.'"';
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
						LEFT JOIN tblprvproveedor prv
						ON vmv.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
								LEFT JOIN tblmonmoneda mon
								ON vmv.MonId = mon.MonId
	
							
						
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$sucursal.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarVehiculoMovimientoEntrada($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsVehiculoMovimientoEntradaDetalle = new ClsVehiculoMovimientoEntradaDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
					
					//MtdObtenerVehiculoMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoEntrada=NULL,$oEstado=NULL,$oVehiculo=NULL)
					$ResVehiculoMovimientoEntradaDetalle = $InsVehiculoMovimientoEntradaDetalle->MtdObtenerVehiculoMovimientoEntradaDetalles(NULL,NULL,NULL,'VmdId','DESC',NULL,$elemento,NULL,NULL,NULL);
					$ArrVehiculoMovimientoEntradaDetalles = $ResVehiculoMovimientoEntradaDetalle['Datos'];

					if(!empty($ArrVehiculoMovimientoEntradaDetalles)){
						$vmdetalle = '';

						foreach($ArrVehiculoMovimientoEntradaDetalles as $DatVehiculoMovimientoEntradaDetalle){
							$vmdetalle .= '#'.$DatVehiculoMovimientoEntradaDetalle->VmdId;
						}

						if(!$InsVehiculoMovimientoEntradaDetalle->MtdEliminarVehiculoMovimientoEntradaDetalle($vmdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
						$this->VmvId = $elemento;
						$this->MtdObtenerVehiculoMovimientoEntrada();

						$sql = 'DELETE FROM tblvmvvehiculomovimiento WHERE  (VmvId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							
							$this->MtdAuditarVehiculoMovimientoEntrada(3,"Se elimino el Compra de Vehiculo",$aux);		
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
	public function MtdActualizarEstadoVehiculoMovimientoEntrada($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsVehiculoMovimientoEntrada = new ClsVehiculoMovimientoEntrada();
		//$InsVehiculoMovimientoEntradaDetalles = new ClsVehiculoMovimientoEntradaDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblvmvvehiculomovimiento SET VmvEstado = '.$oEstado.' WHERE VmvId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarVehiculoMovimientoEntrada(2,"Se actualizo el Estado del Compra de Vehiculo",$elemento);
				
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
	
	
	
	public function MtdActualizarRevisadoVehiculoMovimientoEntrada($oElementos,$oRevisado) {

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
	
	public function MtdVerificarExisteVehiculoMovimientoEntrada($oCampo,$oDato,$oProveedor=NULL){

		$Respuesta =   NULL;

		if($oProveedor){
			$einveedor = ' AND PrvId = "'.$oProveedor.'"';
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
	
	
	
	public function MtdRegistrarVehiculoMovimientoEntrada() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarVehiculoMovimientoEntradaId();
			
			

			$VehiculoMovimientoEntradaId = $this->MtdVerificarExisteVehiculoMovimientoEntrada("VmvComprobanteNumero",$this->VmvComprobanteNumero,$this->PrvId);
	
			if(!empty($VehiculoMovimientoEntradaId)){
				$error = true;
				$Resultado.='#ERR_VME_601';
			}
			
			
			
			$sql = 'INSERT INTO tblvmvvehiculomovimiento (
			VmvId,	
			SucId,
			
			PrvId,
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
			
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
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
			'.(empty($this->VmvTipoCambio)?'NULL, ':''.$this->VmvTipoCambio.',').'
			
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
			
			1,
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
//				$Resultado.='#ERR_VME_110';
//			}


			if(!$error){			
			
				if (!empty($this->VehiculoMovimientoEntradaDetalle)){		
						
					$validar = 0;				
					$InsVehiculoMovimientoEntradaDetalle = new ClsVehiculoMovimientoEntradaDetalle();		
					
					foreach ($this->VehiculoMovimientoEntradaDetalle as $DatVehiculoMovimientoEntradaDetalle){
					
						$InsVehiculoMovimientoEntradaDetalle->VmvId = $this->VmvId;
						$InsVehiculoMovimientoEntradaDetalle->EinId = $DatVehiculoMovimientoEntradaDetalle->EinId;
						$InsVehiculoMovimientoEntradaDetalle->UmeId = $DatVehiculoMovimientoEntradaDetalle->UmeId;
						$InsVehiculoMovimientoEntradaDetalle->VehId = $DatVehiculoMovimientoEntradaDetalle->VehId;
						$InsVehiculoMovimientoEntradaDetalle->AlmId = $DatVehiculoMovimientoEntradaDetalle->AlmId;
						
						$InsVehiculoMovimientoEntradaDetalle->VmdFecha = $DatVehiculoMovimientoEntradaDetalle->VmdFecha;
				
						$InsVehiculoMovimientoEntradaDetalle->VmdIdAnterior = $DatVehiculoMovimientoEntradaDetalle->VmdIdAnterior;
						$InsVehiculoMovimientoEntradaDetalle->VmdValorTotal = $DatVehiculoMovimientoEntradaDetalle->VmdValorTotal;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoPromedio = $DatVehiculoMovimientoEntradaDetalle->VmdCostoPromedio;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoExtraUnitario = $DatVehiculoMovimientoEntradaDetalle->VmdCostoExtraUnitario;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoExtraTotal = $DatVehiculoMovimientoEntradaDetalle->VmdCostoExtraTotal;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoAnterior = $DatVehiculoMovimientoEntradaDetalle->VmdCostoAnterior;
						$InsVehiculoMovimientoEntradaDetalle->VmdCosto = $DatVehiculoMovimientoEntradaDetalle->VmdCosto;				
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoIngreso = $DatVehiculoMovimientoEntradaDetalle->VmdCostoIngreso;	
						
						$InsVehiculoMovimientoEntradaDetalle->VmdCantidad = $DatVehiculoMovimientoEntradaDetalle->VmdCantidad;
						$InsVehiculoMovimientoEntradaDetalle->VmdImporte = $DatVehiculoMovimientoEntradaDetalle->VmdImporte;
						
						$InsVehiculoMovimientoEntradaDetalle->VmdUbicacion = $DatVehiculoMovimientoEntradaDetalle->VmdUbicacion;
						$InsVehiculoMovimientoEntradaDetalle->VmdObservacion = $DatVehiculoMovimientoEntradaDetalle->VmdObservacion;
						
						
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica1 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica1;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica2 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica2;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica3 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica3;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica4 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica4;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica5 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica5;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica6 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica6;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica7 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica7;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica8 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica8;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica9 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica9;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica10 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica10;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica11 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica11;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica12 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica12;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica13 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica13;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica14 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica14;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica15 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica15;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica16 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica16;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica17 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica17;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica18 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica18;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica19 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica19;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica20 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica20;

						$InsVehiculoMovimientoEntradaDetalle->VmdEstado = $DatVehiculoMovimientoEntradaDetalle->VmdEstado;									
						$InsVehiculoMovimientoEntradaDetalle->VmdTiempoCreacion = $DatVehiculoMovimientoEntradaDetalle->VmdTiempoCreacion;
						$InsVehiculoMovimientoEntradaDetalle->VmdTiempoModificacion = $DatVehiculoMovimientoEntradaDetalle->VmdTiempoModificacion;						
						$InsVehiculoMovimientoEntradaDetalle->VmdEliminado = $DatVehiculoMovimientoEntradaDetalle->VmdEliminado;
						
						if($InsVehiculoMovimientoEntradaDetalle->MtdRegistrarVehiculoMovimientoEntradaDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_VME_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoMovimientoEntradaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
					
				
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarVehiculoMovimientoEntrada(1,"Se registro el Compra de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarVehiculoMovimientoEntrada() {

		global $Resultado;
		$error = false;

			
			$sql = 'UPDATE tblvmvvehiculomovimiento SET
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
            '.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
			'.(empty($this->NpaId)?'NpaId = NULL, ':'NpaId = "'.$this->NpaId.'",').'
			
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
//				$Resultado.='#ERR_VME_110';
//			}
			
			
			if(!$error){
			
				if (!empty($this->VehiculoMovimientoEntradaDetalle)){		
						
						
					$validar = 0;				
					$InsVehiculoMovimientoEntradaDetalle = new ClsVehiculoMovimientoEntradaDetalle();
							
					foreach ($this->VehiculoMovimientoEntradaDetalle as $DatVehiculoMovimientoEntradaDetalle){
										
						$InsVehiculoMovimientoEntradaDetalle->VmdId = $DatVehiculoMovimientoEntradaDetalle->VmdId;
						$InsVehiculoMovimientoEntradaDetalle->VmvId = $this->VmvId;
						$InsVehiculoMovimientoEntradaDetalle->EinId = $DatVehiculoMovimientoEntradaDetalle->EinId;
						$InsVehiculoMovimientoEntradaDetalle->UmeId = $DatVehiculoMovimientoEntradaDetalle->UmeId;
						$InsVehiculoMovimientoEntradaDetalle->VehId = $DatVehiculoMovimientoEntradaDetalle->VehId;
						$InsVehiculoMovimientoEntradaDetalle->AlmId = $DatVehiculoMovimientoEntradaDetalle->AlmId;
						$InsVehiculoMovimientoEntradaDetalle->VmdFecha = $DatVehiculoMovimientoEntradaDetalle->VmdFecha;
						
						$InsVehiculoMovimientoEntradaDetalle->VmdIdAnterior = $DatVehiculoMovimientoEntradaDetalle->VmdIdAnterior;
						$InsVehiculoMovimientoEntradaDetalle->VmdValorTotal = $DatVehiculoMovimientoEntradaDetalle->VmdValorTotal;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoPromedio = $DatVehiculoMovimientoEntradaDetalle->VmdCostoPromedio;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoExtraUnitario = $DatVehiculoMovimientoEntradaDetalle->VmdCostoExtraUnitario;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoExtraTotal = $DatVehiculoMovimientoEntradaDetalle->VmdCostoExtraTotal;
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoAnterior = $DatVehiculoMovimientoEntradaDetalle->VmdCostoAnterior;
						$InsVehiculoMovimientoEntradaDetalle->VmdCosto = $DatVehiculoMovimientoEntradaDetalle->VmdCosto;						
						$InsVehiculoMovimientoEntradaDetalle->VmdCostoIngreso = $DatVehiculoMovimientoEntradaDetalle->VmdCostoIngreso;						
						$InsVehiculoMovimientoEntradaDetalle->VmdCantidad = $DatVehiculoMovimientoEntradaDetalle->VmdCantidad;
						$InsVehiculoMovimientoEntradaDetalle->VmdImporte = $DatVehiculoMovimientoEntradaDetalle->VmdImporte;
						$InsVehiculoMovimientoEntradaDetalle->VmdUbicacion = $DatVehiculoMovimientoEntradaDetalle->VmdUbicacion;
						$InsVehiculoMovimientoEntradaDetalle->VmdObservacion = $DatVehiculoMovimientoEntradaDetalle->VmdObservacion;
						
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica1 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica1;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica2 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica2;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica3 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica3;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica4 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica4;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica5 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica5;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica6 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica6;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica7 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica7;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica8 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica8;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica9 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica9;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica10 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica10;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica11 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica11;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica12 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica12;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica13 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica13;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica14 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica14;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica15 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica15;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica16 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica16;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica17 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica17;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica18 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica18;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica19 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica19;
						$InsVehiculoMovimientoEntradaDetalle->VmdCaracteristica20 = $DatVehiculoMovimientoEntradaDetalle->VmdCaracteristica20;
						
						$InsVehiculoMovimientoEntradaDetalle->VmdEstado = $DatVehiculoMovimientoEntradaDetalle->VmdEstado;		
						$InsVehiculoMovimientoEntradaDetalle->VmdTiempoCreacion = $DatVehiculoMovimientoEntradaDetalle->VmdTiempoCreacion;
						$InsVehiculoMovimientoEntradaDetalle->VmdTiempoModificacion = $DatVehiculoMovimientoEntradaDetalle->VmdTiempoModificacion;
						$InsVehiculoMovimientoEntradaDetalle->VmdEliminado = $DatVehiculoMovimientoEntradaDetalle->VmdEliminado;
						
						
						if(empty($InsVehiculoMovimientoEntradaDetalle->VmdId)){
							if($InsVehiculoMovimientoEntradaDetalle->VmdEliminado<>2){
								if($InsVehiculoMovimientoEntradaDetalle->MtdRegistrarVehiculoMovimientoEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VME_201';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoMovimientoEntradaDetalle->VmdEliminado==2){
								if($InsVehiculoMovimientoEntradaDetalle->MtdEliminarVehiculoMovimientoEntradaDetalle($InsVehiculoMovimientoEntradaDetalle->VmdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_VME_203';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoMovimientoEntradaDetalle->MtdEditarVehiculoMovimientoEntradaDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_VME_202';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoMovimientoEntradaDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
			
				
				
				
				
				
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarVehiculoMovimientoEntrada(2,"Se edito el Compra de Vehiculo",$this);		
				return true;
			}	
				
		}
		
		
	
		public function MtdEditarVehiculoMovimientoEntradaDato($oCampo,$oDato,$oId) {

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



		private function MtdAuditarVehiculoMovimientoEntrada($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
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
		
		
	public function MtdNotificarVehiculoMovimientoEntradaRegistro($oVehiculoMovimientoEntrada,$oDestinatario){
			
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->VmvId = $oVehiculoMovimientoEntrada;
			$this->MtdObtenerVehiculoMovimientoEntrada();
		
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Ingreso de Vehiculos .";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->VmvId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Proveedor: <b>".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->VmvFecha."</b>";	
			$mensaje .= "<br>";	
		
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			$mensaje .= "Datos del documento";	
			$mensaje .= "<br>";
			$mensaje .= "Tipo: <b>".$this->CtiNombre."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Numero : <b>".$this->VmvComprobanteNumero."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Fecha : <b>".$this->VmvComprobanteFecha."</b>";				
			$mensaje .= "<br>";
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";

		
					

					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "VIN";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Marca";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Modelo";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Version";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Observaciones";
						$mensaje .= "</td>";
		
		
						$mensaje .= "<td>";
						$mensaje .= "Estado";
						$mensaje .= "</td>";
						
						
		
					$mensaje .= "</tr>";

					
					$i = 1;
					if(!empty($this->VehiculoMovimientoDetalle)){
						foreach($this->VehiculoMovimientoDetalle as $DatVehiculoMovimientoDetalle){
							
							$mensaje .= "<tr>";

								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatVehiculoMovimientoDetalle->EinVIN;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatVehiculoMovimientoDetalle->VmaNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= $DatVehiculoMovimientoDetalle->VmoNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= $DatVehiculoMovimientoDetalle->VveNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= ($DatVehiculoMovimientoDetalle->VmdObservacion);
								$mensaje .= "</td>";
				
							
							$mensaje .= "</tr>";
							$i++;							
						}
					}
					
					$mensaje .= "</table>";
					

			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			///echo $mensaje;
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO DE VEHICULO: ".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno,$mensaje);
			
				
			
		}
		
//		//MtdNotificarAlmacennMovimientoEntradaOrdenCompra
//		public function MtdNotificarVehiculoMovimientoEntradaVencimiento($oDestinatario,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL,$oProveedor=NULL){
//		
//			global $EmpresaMonedaId;
//			global $SistemaCorreoUsuario;
//		global $SistemaCorreoRemitente;
//		global $SistemaNombreAbreviado;
//		
//			$Enviar = false;
//			
//			$ProveedorNombre = "";
//			$ProveedorNumeroDocumento = "";
//			
//			if(!empty($oProveedor)){
//				
//				$InsProveedor = new ClsProveedor();
//				$InsProveedor->PrvId = $oProveedor;
//				$InsProveedor->MtdObtenerProveedor();
//				
//				$ProveedorNombre = $InsProveedor->PrvNombre." ".$InsProveedor->PrvApellidoPaterno." ".$InsProveedor->PrvApellidoMaterno;
//				$ProveedorNumeroDocumento = $InsProveedor->PrvNumeroDocumento;
//				$ProveedorTipoDocumento = $InsProveedor->TdoNombre;
//				
//			}
//			
//			$mensaje .= "AVISO DE VENCIMIENTO DE FACTURAS:";	
//			$mensaje .= "<br>";	
//			$mensaje .= "<br>";	
//
//		
//			$mensaje .= "Fecha de aviso: <b>".date("d/m/Y")."</b>";	
//			$mensaje .= "<br>";	
//			
//			if(!empty($oProveedor)){
//				
//				$mensaje .= "Proveedor: <b>".$ProveedorNombre."</b>";	
//				$mensaje .= "<br>";
//				
//				$mensaje .= "Num.Doc.: <b>".$ProveedorTipoDocumento."/".$ProveedorNumeroDocumento."</b>";	
//				$mensaje .= "<br>";		
//							
//			}
//			
//			
//			$mensaje .= "<hr>";
//			$mensaje .= "<br>";
//			
//			
//			
//			$InsMoneda = new ClsMoneda();
//			$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL,NULL,NULL,"MonId","DESC",NULL);
//			$ArrMonedas = $ResMoneda['Datos'];
//
//			foreach($ArrMonedas as $DatMoneda){
//			
//				$mensaje .= "<br>";
//				//MtdObtenerVehiculoMovimientoEntradas($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'VmvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="VmvFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL) {
//				$ResVehiculoMovimientoEntrada = $this->MtdObtenerVehiculoMovimientoEntradas(NULL,NULL,NULL,"VmvComprobanteFecha","ASC",NULL,FncCambiaFechaAMysql($oFechaInicio),FncCambiaFechaAMysql($oFechaFin),NULL,NULL,$DatMoneda->MonId,NULL,NULL,NULL,NULL,"VmvComprobanteFecha",0,2,$oProveedor,NULL,$oCondicionPago);
//				$ArrVehiculoMovimientoEntradas = $ResVehiculoMovimientoEntrada['Datos'];
//
//				if(!empty($ArrVehiculoMovimientoEntradas)){
//				
//					$mensaje .= "<b>RELACION DE FACTURAS EN ".$DatMoneda->MonNombre." (".$DatMoneda->MonSimbolo.") </b>" ;
//					$mensaje .= "<br>";
//					
//					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";
//					
//					$mensaje .= "<tr>";
//					
//						$mensaje .= "<td width='2%'>";
//						$mensaje .= "<b>#</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='10%'>";
//						$mensaje .= "<b>COND. PAGO</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td>";
//						$mensaje .= "<b>NUM. COMPROB.</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='10%'>";
//						$mensaje .= "<b>FECHA COMPROB.</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='10%'>";
//						$mensaje .= "<b>NUM. DOC.</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='60%'>";
//						$mensaje .= "<b>PROVEEDOR</b>";
//						$mensaje .= "</td>";
//
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>MONEDA</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>ORD. COMPRA</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>CRED. CANT. DIAS</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>FECHA VENC.</b>";
//						$mensaje .= "</td>";
//						
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>TOTAL</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>VMERT.</b>";
//						$mensaje .= "</td>";
//						
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>SALDO</b>";
//						$mensaje .= "</td>";
//						
//						$mensaje .= "<td width='5%'>";
//						$mensaje .= "<b>VENCIMIENTO</b>";
//						$mensaje .= "</td>";
//						
//						
//					$mensaje .= "</tr>";
//					
//					
//							
//				$c = 1;	
//				
//				foreach($ArrVehiculoMovimientoEntradas as $DatVehiculoMovimientoEntrada){
//
//
//					$DatVehiculoMovimientoEntrada->VmvTotal = (($EmpresaMonedaId==$DatMoneda->MonId or empty($DatMoneda->MonId))?$DatVehiculoMovimientoEntrada->VmvTotal:($DatVehiculoMovimientoEntrada->VmvTotal/$DatVehiculoMovimientoEntrada->VmvTipoCambio));
//				
//					$DatVehiculoMovimientoEntrada->VmvTotal = round($DatVehiculoMovimientoEntrada->VmvTotal,2);
//					
//					$Mostrar = true;
//
//					if($DatVehiculoMovimientoEntrada->NpaId == "NPA-10001"){
//						
//						settype($DatVehiculoMovimientoEntrada->VmvTotal ,"float");
//						settype($ProveedorPagoMontoTotal ,"float");
//						
//						
//						if(($ProveedorPagoMontoTotal+1000) < ($DatVehiculoMovimientoEntrada->VmvTotal+1000)){
//							if($DatVehiculoMovimientoEntrada->VmvCantidadDia<$DatVehiculoMovimientoEntrada->VmvDiaTranscurrido){
//								
//							}else if ( ($DatVehiculoMovimientoEntrada->VmvCantidadDia - $DatVehiculoMovimientoEntrada->VmvDiaTranscurrido) >= 1 and ($DatVehiculoMovimientoEntrada->VmvCantidadDia - $DatVehiculoMovimientoEntrada->VmvDiaTranscurrido) <=3 ){
//				
//							}else{
//								
//								$Mostrar = false;
//								
//							}
//						}
//						
//					}
//	
//				if($Mostrar){
//						
//					$mensaje .= "<tr>";
//									
//					$mensaje .= "<td>";
//					$mensaje .= $c;
//					$mensaje .= "</td>";
//	
//					$mensaje .= "<td>";
//					$mensaje .= $DatVehiculoMovimientoEntrada->NpaNombre;
//					$mensaje .= "</td>";
//					
//					$mensaje .= "<td>";
//					$mensaje .= "<span title='".$DatVehiculoMovimientoEntrada->VmvId."'>".$DatVehiculoMovimientoEntrada->VmvComprobanteNumero."</span>";
//					$mensaje .= "</td>";
//
//					$mensaje .= "<td>";
//					$mensaje .= $DatVehiculoMovimientoEntrada->VmvComprobanteFecha;
//					$mensaje .= "</td>";
//					
//					$mensaje .= "<td>";
//					$mensaje .= $DatVehiculoMovimientoEntrada->PrvNumeroDocumento;
//					$mensaje .= "</td>";
//
//					
//					$mensaje .= "<td>";
//					$mensaje .= $DatVehiculoMovimientoEntrada->PrvNombreCompleto;
//					$mensaje .= "</td>";
//
//					$mensaje .= "<td>";
//					$mensaje .= $DatVehiculoMovimientoEntrada->MonSimbolo;
//					$mensaje .= "</td>";
//					
//					
//					$mensaje .= "<td>";
//					$mensaje .= $DatVehiculoMovimientoEntrada->OcoId;
//					$mensaje .= "</td>";
//							
//					$mensaje .= "<td>";
//					
//					if($DatVehiculoMovimientoEntrada->NpaId == "NPA-10001"){
//					
//						$mensaje .= $DatVehiculoMovimientoEntrada->VmvCantidadDia;
//						
//						if($DatVehiculoMovimientoEntrada->VmvCantidadDia <=30){
//							$TotalCredito30 += $DatVehiculoMovimientoEntrada->VmvTotal;
//						}else{
//							$TotalCredito30Mas += $DatVehiculoMovimientoEntrada->VmvTotal;
//						}
//					
//					}else{
//						$TotalContado += $DatVehiculoMovimientoEntrada->VmvTotal;
//					}
//					
//					$mensaje .= "</td>";
//					
//					$mensaje .= "<td>";
//					$mensaje .= $DatVehiculoMovimientoEntrada->VmvFechaVencimiento;
//					$mensaje .= "</td>";
//								
//					$mensaje .= "<td>";
//					$mensaje .= number_format($DatVehiculoMovimientoEntrada->VmvTotal,2);
//					$mensaje .= "</td>";
//								
//
//		
//					$ProveedorPagoMontoTotal = 0;
//
//					switch($DatVehiculoMovimientoEntrada->VmvCancelado){
//					
//						case 1:
//							$ProveedorPagoMontoTotal = $DatVehiculoMovimientoEntrada->VmvTotal;					
//						break;
//					
//						case 2:
//									
//						break;	
//
//					}
//				
//					$mensaje .= "<td>";
//					$mensaje .= $ProveedorPagoMontoTotal;
//					$mensaje .= "</td>";
//					
//					settype($DatVehiculoMovimientoEntrada->VmvTotal ,"float");
//					settype($ProveedorPagoMontoTotal ,"float");
//					
//					$VehiculoMovimientoEntradaSaldo = round($DatVehiculoMovimientoEntrada->VmvTotal,2) - round($ProveedorPagoMontoTotal,2);
//		
//						
//					$mensaje .= "<td>";
//					$mensaje .= number_format($VehiculoMovimientoEntradaSaldo,2);
//					$mensaje .= "</td>";
//					
//					
//		
//					$mensaje .= "<td>";
//
//	
//					if($DatVehiculoMovimientoEntrada->NpaId == "NPA-10001"){
//						
//						settype($DatVehiculoMovimientoEntrada->VmvTotal ,"float");
//						settype($ProveedorPagoMontoTotal ,"float");
//						
//						
//						if(($ProveedorPagoMontoTotal+1000) < ($DatVehiculoMovimientoEntrada->VmvTotal+1000)){
//							if($DatVehiculoMovimientoEntrada->VmvCantidadDia<$DatVehiculoMovimientoEntrada->VmvDiaTranscurrido){
//								
//								$mensaje .= "VENCIDO ";
//								$mensaje .= ($DatVehiculoMovimientoEntrada->VmvDiaTranscurrido - $DatVehiculoMovimientoEntrada->VmvCantidadDia)." dias";
//								
//							}else if ( ($DatVehiculoMovimientoEntrada->VmvCantidadDia - $DatVehiculoMovimientoEntrada->VmvDiaTranscurrido) >= 1 and ($DatVehiculoMovimientoEntrada->VmvCantidadDia - $DatVehiculoMovimientoEntrada->VmvDiaTranscurrido) <=3 ){
//								
//								$mensaje .= "POR VENCER ";				
//								$mensaje .= ($DatVehiculoMovimientoEntrada->VmvCantidadDia - $DatVehiculoMovimientoEntrada->VmvDiaTranscurrido)." dias";
//				
//							}else{
//								
//								$mensaje .= "VIGENTE ";
//								
//							}
//						}
//						
//					}
//	
//					$mensaje .= "</td>";
//	
//	
//					$mensaje .= "</tr>";
//
//					$c++;			
//					
//				
//					$Enviar = true;
//					
//					}
//					
//					
//							
//				}
//				
//
//					
//						
//					$mensaje .= "</table>";
//					
//					
//				}
//				
//			}
//			
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
//			
//			
//			echo $mensaje;
//			
//			if($Enviar){
//				
//				$InsCorreo = new ClsCorreo();	
//				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"AVISO: FACTURAS C/ CREDITO - ".$ProveedorNombre,$mensaje);
//				
//			}
//				
//				
//				
//				
//		}
//
//		
		/*public function MtdEditarVehiculoMovimientoEntradaDato($oCampo,$oDato,$oId) {

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