<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCompraVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCompraVehiculo {

    public $CvhId;
	public $CvhTipo;
	public $CvhSubTipo;
	public $PrvId;
	public $CtiId;
	public $TopId;
	
	public $NpaId;
	public $CvhCantidadDia;
	
	public $AlmId;
	public $CvhFecha;
	public $CvhDocumentoOrigen;
	
	public $CvhGuiaRemisionNumero;
	public $CvhGuiaRemisionNumeroSerie;
	public $CvhGuiaRemisionNumeroNumero;
	public $CvhGuiaRemisionFecha;
	public $CvhGuiaRemisionFoto;
	
	public $CvhComprobanteNumero;
	public $CvhComprobanteNumeroSerie;
	public $CvhComprobanteNumeroNumero;
	public $CvhComprobanteFecha;

	public $MonId;
	public $CvhTipoCambio;

	public $CvhIncluyeImpuesto;
	public $CvhPorcentajeImpuestoVenta;
	
	public $CvhFoto;
    public $CvhObservacion;
	
		
		
	public $CvhSubTotal;
	public $CvhImpuesto;
	public $CvhTotal;
	

	public $CvhCancelado;
	
	public $CvhRevisado;
	
	public $CvhEstado;
	public $CvhTiempoCreacion;
	public $CvhTiempoModificacion;
    public $CvhEliminado;

	public $CtiNombre;
	
	public $TdoId;
	public $PrvNombre;
	public $PrvNumeroDocumento;
	
	public $TdoNombre;
	
	public $MonSimbolo;
	
	public $CompraVehiculoDetalle;
	public $CompraVehiculoExtorno;
	public $OrdenCompraPedido;
	
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

	public function MtdGenerarCompraVehiculoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(cvh.CvhId,5),unsigned)) AS "MAXIMO"
		FROM tblcvhcompravehiculo cvh
		';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->CvhId = "CVH-10000";
		}else{
			$fila['MAXIMO']++;
			$this->CvhId = "CVH-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerCompraVehiculo(){

        $sql = 'SELECT 
        cvh.CvhId,  
		cvh.SucId,
	
		cvh.PrvId,
		cvh.CtiId,
		cvh.TopId,
		
		
		cvh.NpaId,
		cvh.CvhCantidadDia,
		
		cvh.AlmId,
		DATE_FORMAT(cvh.CvhFecha, "%d/%m/%Y") AS "NCvhFecha",
		cvh.CvhDocumentoOrigen,

		cvh.CvhGuiaRemisionNumero,
		DATE_FORMAT(cvh.CvhGuiaRemisionFecha, "%d/%m/%Y") AS "NCvhGuiaRemisionFecha",
		cvh.CvhGuiaRemisionFoto,
		
		cvh.CvhComprobanteNumero,
		DATE_FORMAT(cvh.CvhComprobanteFecha, "%d/%m/%Y") AS "NCvhComprobanteFecha",
		
		cvh.MonId,
		cvh.CvhTipoCambio,
		
		cvh.CvhIncluyeImpuesto,
		cvh.CvhPorcentajeImpuestoVenta,
	
		cvh.CvhFoto,
		cvh.CvhObservacion,

		cvh.CvhSubTotal,
		cvh.CvhImpuesto,
		cvh.CvhTotal,
	
		cvh.CvhCancelado,
		cvh.CvhRevisado,
		
		cvh.CvhTipo,
		cvh.CvhSubTipo,
		cvh.CvhEstado,
		DATE_FORMAT(cvh.CvhTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCvhTiempoCreacion",
        DATE_FORMAT(cvh.CvhTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCvhTiempoModificacion",
		
		cti.CtiNombre,
		
		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		
		prv.PrvNumeroDocumento,
		prv.TdoId,
				
		mon.MonSimbolo
		
        FROM tblcvhcompravehiculo cvh
		
			LEFT JOIN tblcticomprobantetipo cti
			ON cvh.CtiId = cti.CtiId
				LEFT JOIN tblprvproveedor prv
				ON cvh.PrvId = prv.PrvId
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
						LEFT JOIN tblmonmoneda mon
						ON cvh.MonId = mon.MonId		
						

        WHERE cvh.CvhId = "'.$this->CvhId.'" ';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->CvhId = $fila['CvhId'];
			$this->SucId = $fila['SucId'];		
			
			$this->PrvId = $fila['PrvId'];		
			$this->CtiId = $fila['CtiId'];		
			$this->TopId = $fila['TopId'];		
			
			$this->NpaId = $fila['NpaId'];
			$this->CvhCantidadDia = $fila['CvhCantidadDia'];

			$this->AlmId = $fila['AlmId'];
			$this->CvhFecha = $fila['NCvhFecha'];

			$this->CvhDocumentoOrigen = $fila['CvhDocumentoOrigen'];
			
			$this->CvhGuiaRemisionNumero = $fila['CvhGuiaRemisionNumero'];
			list($this->CvhGuiaRemisionNumeroSerie,$this->CvhGuiaRemisionNumeroNumero) = explode("-",$this->CvhGuiaRemisionNumero);
			$this->CvhGuiaRemisionFecha = $fila['NCvhGuiaRemisionFecha'];
			$this->CvhGuiaRemisionFoto = $fila['CvhGuiaRemisionFoto'];
			
			$this->CvhComprobanteNumero = $fila['CvhComprobanteNumero'];
			list($this->CvhComprobanteNumeroSerie,$this->CvhComprobanteNumeroNumero) = explode("-",$this->CvhComprobanteNumero);
			$this->CvhComprobanteFecha = $fila['NCvhComprobanteFecha'];

			$this->MonId = $fila['MonId'];
			$this->CvhTipoCambio = $fila['CvhTipoCambio'];
			$this->CvhTipoCambioComercial = $fila['CvhTipoCambioComercial'];
			
			$this->CvhIncluyeImpuesto = $fila['CvhIncluyeImpuesto'];
			$this->CvhPorcentajeImpuestoVenta = $fila['CvhPorcentajeImpuestoVenta'];
			
			$this->CvhFoto = $fila['CvhFoto'];
			$this->CvhObservacion = $fila['CvhObservacion'];
		
			$this->CvhSubTotal = $fila['CvhSubTotal'];
			$this->CvhImpuesto = $fila['CvhImpuesto'];
			$this->CvhTotal = $fila['CvhTotal'];
					
			$this->CvhCancelado = $fila['CvhCancelado'];
			$this->CvhRevisado = $fila['CvhRevisado'];
			$this->CvhTipo = $fila['CvhTipo'];
			$this->CvhSubTipo = $fila['CvhSubTipo'];
		
			$this->CvhEstado = $fila['CvhEstado'];
			$this->CvhTiempoCreacion = $fila['NCvhTiempoCreacion']; 
			$this->CvhTiempoModificacion = $fila['NCvhTiempoModificacion']; 	
			
			
			
			$this->CtiNombre = $fila['CtiNombre']; 	

			$this->PrvNombreCompleto = $fila['PrvNombreCompleto']; 	
			$this->PrvNombre = $fila['PrvNombre']; 	
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 	
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 	
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId']; 	
			$this->TdoNombre = $fila['TdoNombre'];

			$this->MonSimbolo = $fila['MonSimbolo']; 	

			
			$InsCompraVehiculoDetalle = new ClsCompraVehiculoDetalle();
			//MtdObtenerCompraVehiculoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL)
			$ResCompraVehiculoDetalle =  $InsCompraVehiculoDetalle->MtdObtenerCompraVehiculoDetalles(NULL,NULL,NULL,"CvhId","ASC",NULL,$this->CvhId);				
			$this->CompraVehiculoDetalle = 	$ResCompraVehiculoDetalle['Datos'];	



			switch($this->CvhEstado){
			
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
				
			$this->CvhEstadoDescripcion = $Estado;
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCompraVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CvhId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="CvhFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL,$oSubTipo=NULL) {

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
					cvd.CvdId

					FROM tblcvdcompravehiculodetalle cvd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON cvd.EinId = ein.EinId

					WHERE 
						cvd.CvhId = cvh.CvhId  
						
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
				$fecha = ' AND DATE(cvh.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(cvh.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cvh.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cvh.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		

		if(!empty($oEstado)){
			$estado = ' AND cvh.CvhEstado = '.$oEstado;
		}
		

		if(!empty($oOrigen)){
			$origen = ' AND cvh.CvhDocumentoOrigen = '.$oOrigen;
		}
		

		if(!empty($oMoneda)){
			$moneda = ' AND cvh.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND cvh.CliId = "'.$oCliente.'"';
		}	
		
		if($oCancelado){
			$cancelado = ' AND cvh.CvhCancelado = '.$oCancelado;
		}
		
		if(!empty($oProveedor)){
			$einveedor = ' AND cvh.PrvId = "'.$oProveedor.'"';
		}
		
		if(!empty($oCondicionPago)){
			$cpago = ' AND cvh.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cvh.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oAlmacen)){
			$almacen = ' AND cvh.AlmId = "'.$oAlmacen.'"';
		}
			
		if(!empty($oSubTipo)){
			$stipo = ' AND cvh.CvhSubTipo = "'.$oSubTipo.'"';
		}
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cvh.CvhId,				
				cvh.SucId,
				
				cvh.PrvId,
				cvh.CtiId,
				cvh.TopId,
				
				cvh.NpaId,	
				cvh.CvhCantidadDia,	
				
				cvh.AlmId,
				DATE_FORMAT(cvh.CvhFecha, "%d/%m/%Y") AS "NCvhFecha",
				cvh.CvhDocumentoOrigen,
				
				cvh.CvhGuiaRemisionNumero,
				DATE_FORMAT(cvh.CvhGuiaRemisionFecha, "%d/%m/%Y") AS "NCvhGuiaRemisionFecha",
				cvh.CvhGuiaRemisionFoto,
				
				cvh.CvhComprobanteNumero,
				DATE_FORMAT(cvh.CvhComprobanteFecha, "%d/%m/%Y") AS "NCvhComprobanteFecha",
				
				cvh.MonId,
				cvh.CvhTipoCambio,
				cvh.CvhTipoCambioComercial,
				
				cvh.CvhIncluyeImpuesto,
				cvh.CvhPorcentajeImpuestoVenta,
						
				cvh.CvhFoto,
				cvh.CvhObservacion,
				
				cvh.CvhSubTotal,
				cvh.CvhImpuesto,				
				cvh.CvhTotal,
				
				cvh.CvhCancelado,
				cvh.CvhRevisado,
				cvh.CvhCierre,
				
				cvh.CvhTipo,
				cvh.CvhSubTipo,
				cvh.CvhEstado,
				DATE_FORMAT(cvh.CvhTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCvhTiempoCreacion",
	        	DATE_FORMAT(cvh.CvhTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCvhTiempoModificacion",
				
				DATE_FORMAT(adddate(cvh.CvhComprobanteFecha,cvh.CvhCantidadDia), "%d/%m/%Y") AS CvhFechaVencimiento,
				DATEDIFF(DATE(NOW()),cvh.CvhComprobanteFecha) AS CvhDiaTranscurrido,

				CASE
				WHEN EXISTS (
					SELECT 
					cvh.CvhId 
					FROM tblnccnotacreditocompra ncc
					WHERE ncc.NccId = cvh.CvhId
					AND ncc.NccEstado = 3 
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CvhNotaCreditoCompra,
				
				(SELECT COUNT(cvd.CvdId) FROM tblcvdcompravehiculodetalle cvd WHERE cvd.CvhId = cvh.CvhId ) AS "CvhTotalItems",

				cti.CtiNombre,
				
				prv.TdoId,

				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre,				
				mon.MonSimbolo,				
				npa.NpaNombre				

				FROM tblcvhcompravehiculo cvh
					
					LEFT JOIN tblnpacondicionpago npa
					ON cvh.NpaId = npa.NpaId
						LEFT JOIN tblcticomprobantetipo cti
						ON cvh.CtiId = cti.CtiId
							LEFT JOIN tblprvproveedor prv
							ON cvh.PrvId = prv.PrvId
								LEFT JOIN tbltdotipodocumento tdo
								ON prv.TdoId = tdo.TdoId
									LEFT JOIN tblmonmoneda mon
									ON cvh.MonId = mon.MonId
	
				WHERE 1 = 1 AND cvh.CvhTipo = 1 '.$filtrar.$fecha.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCompraVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CompraVehiculo = new $InsCompraVehiculo();
                    $CompraVehiculo->CvhId = $fila['CvhId'];
					$CompraVehiculo->SucId = $fila['SucId'];
					
					$CompraVehiculo->PrvId = $fila['PrvId'];		
					$CompraVehiculo->CtiId = $fila['CtiId'];	
					$CompraVehiculo->TopId = $fila['TopId'];	
					
					$CompraVehiculo->NpaId = $fila['NpaId'];
					$CompraVehiculo->CvhCantidadDia = $fila['CvhCantidadDia'];							
				
					$CompraVehiculo->AlmId = $fila['AlmId'];
					$CompraVehiculo->CvhFecha = $fila['NCvhFecha'];
					$CompraVehiculo->CvhDocumentoOrigen = $fila['CvhDocumentoOrigen'];
					
					$CompraVehiculo->CvhGuiaRemisionNumero = $fila['CvhGuiaRemisionNumero'];
					list($CompraVehiculo->CvhGuiaRemisionNumeroSerie,$CompraVehiculo->CvhGuiaRemisionNumeroNumero) = explode("-",$CompraVehiculo->CvhGuiaRemisionNumero);
					$CompraVehiculo->CvhGuiaRemisionFecha = $fila['NCvhGuiaRemisionFecha'];
					$CompraVehiculo->CvhGuiaRemisionFoto = $fila['CvhGuiaRemisionFoto'];
					
					
					$CompraVehiculo->CvhComprobanteNumero = $fila['CvhComprobanteNumero'];
					list($CompraVehiculo->CvhComprobanteNumeroSerie,$CompraVehiculo->CvhComprobanteNumeroNumero) = explode("-",$CompraVehiculo->CvhComprobanteNumero);					
					$CompraVehiculo->CvhComprobanteFecha = $fila['NCvhComprobanteFecha'];
					
					$CompraVehiculo->MonId = $fila['MonId'];
					$CompraVehiculo->CvhTipoCambio = $fila['CvhTipoCambio'];
					$CompraVehiculo->CvhTipoCambioComercial = $fila['CvhTipoCambioComercial'];
					
					$CompraVehiculo->CvhIncluyeImpuesto = $fila['CvhIncluyeImpuesto'];
					$CompraVehiculo->CvhPorcentajeImpuestoVenta = $fila['CvhPorcentajeImpuestoVenta'];
					
					$CompraVehiculo->CvhFoto = $fila['CvhFoto'];
					$CompraVehiculo->CvhObservacion = $fila['CvhObservacion'];
		
					$CompraVehiculo->CvhSubTotal = $fila['CvhSubTotal'];			
					$CompraVehiculo->CvhImpuesto = $fila['CvhImpuesto'];
					$CompraVehiculo->CvhTotal = $fila['CvhTotal'];
					
					$CompraVehiculo->CvhCancelado = $fila['CvhCancelado'];	
					$CompraVehiculo->CvhRevisado = $fila['CvhRevisado'];
					$CompraVehiculo->CvhCierre = $fila['CvhCierre'];	
					
		
					$CompraVehiculo->CvhTipo = $fila['CvhTipo'];
					$CompraVehiculo->CvhSubTipo = $fila['CvhSubTipo'];	
								
					$CompraVehiculo->CvhEstado = $fila['CvhEstado'];
					$CompraVehiculo->CvhTiempoCreacion = $fila['NCvhTiempoCreacion'];  
					$CompraVehiculo->CvhTiempoModificacion = $fila['NCvhTiempoModificacion']; 

					$CompraVehiculo->CvhFechaVencimiento = $fila['CvhFechaVencimiento']; 
					$CompraVehiculo->CvhDiaTranscurrido = $fila['CvhDiaTranscurrido']; 

					$CompraVehiculo->CvhNotaCreditoCompra = $fila['CvhNotaCreditoCompra']; 
					
					$CompraVehiculo->CvhTotalItems = $fila['CvhTotalItems']; 
					
					$CompraVehiculo->CtiNombre = $fila['CtiNombre']; 
					
					$CompraVehiculo->TdoId = $fila['TdoId']; 
					
					$CompraVehiculo->PrvNombreCompleto = $fila['PrvNombreCompleto']; 
					$CompraVehiculo->PrvNombre = $fila['PrvNombre']; 
					$CompraVehiculo->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 
					$CompraVehiculo->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 
					
					$CompraVehiculo->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
					
					$CompraVehiculo->TdoNombre = $fila['TdoNombre']; 

					$CompraVehiculo->MonSimbolo = $fila['MonSimbolo']; 
					
					$CompraVehiculo->NpaNombre = $fila['NpaNombre']; 
					
				
					switch($CompraVehiculo->CvhEstado){
					
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
						
					$CompraVehiculo->CvhEstadoDescripcion = $Estado;
					
					switch($CompraVehiculo->CvhRevisado){
					
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
						
					$CompraVehiculo->CvhRevisadoDescripcion = $Revisado;
					
                    $CompraVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CompraVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		



    public function MtdObtenerCompraVehiculosValor($oFuncion="SUM",$oParametro="CvhTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CvhId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oCliente=NULL,$oFecha="CvhFecha",$oCancelado=0,$oProveedor=NULL,$oCondicionPago=NULL,$oSucursal=NULL,$oAlmacen=NULL) {

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
					cvd.CvdId

					FROM tblcvdcompravehiculodetalle cvd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON cvd.EinId = ein.EinId

							LEFT JOIN tblpcdpedidocompradetalle pcd
							ON cvd.PcdId = pcd.PcdId
								
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
								
									LEFT JOIN tblclicliente cli
									ON pco.CliId = cli.CliId

					WHERE 
						cvd.CvhId = cvh.CvhId AND 
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
				$fecha = ' AND DATE(cvh.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(cvh.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cvh.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cvh.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		

		if(!empty($oEstado)){
			$estado = ' AND cvh.CvhEstado = '.$oEstado;
		}
		

		if(!empty($oOrigen)){
			$origen = ' AND cvh.CvhDocumentoOrigen = '.$oOrigen;
		}
		

		if(!empty($oMoneda)){
			$moneda = ' AND cvh.MonId = "'.$oMoneda.'"';
		}
		
	
		
		
		if(!empty($oCliente)){
			$cliente = ' AND cvh.CliId = "'.$oCliente.'"';
		}	
		
		
		if($oCancelado){
			$cancelado = ' AND cvh.CvhCancelado = '.$oCancelado;
		}
		
		
		if(!empty($oProveedor)){
			$einveedor = ' AND cvh.PrvId = "'.$oProveedor.'"';
		}
	
		if(!empty($oCondicionPago)){
			$cpago = ' AND cvh.NpaId = "'.$oCondicionPago.'"';
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND cvh.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oAlmacen)){
			$almacen = ' AND cvh.AlmId = "'.$oAlmacen.'"';
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
		
		
		
			 $sql = 'SELECT
				'.$funcion.' AS "RESULTADO" 

				FROM tblcvhcompravehiculo cvh
					
						LEFT JOIN tblnpacondicionpago npa
						ON cvh.NpaId = npa.NpaId
						
					LEFT JOIN tblcticomprobantetipo cti
					ON cvh.CtiId = cti.CtiId
						LEFT JOIN tblprvproveedor prv
						ON cvh.PrvId = prv.PrvId
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
								LEFT JOIN tblmonmoneda mon
								ON cvh.MonId = mon.MonId
	
							
						
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$sucursal.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarCompraVehiculo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsCompraVehiculoDetalle = new ClsCompraVehiculoDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
					
					//MtdObtenerCompraVehiculoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL)
					$ResCompraVehiculoDetalle = $InsCompraVehiculoDetalle->MtdObtenerCompraVehiculoDetalles(NULL,NULL,NULL,'CvdId','DESC',NULL,$elemento,NULL,NULL,NULL);
					$ArrCompraVehiculoDetalles = $ResCompraVehiculoDetalle['Datos'];

					if(!empty($ArrCompraVehiculoDetalles)){
						$cvdetalle = '';

						foreach($ArrCompraVehiculoDetalles as $DatCompraVehiculoDetalle){
							$cvdetalle .= '#'.$DatCompraVehiculoDetalle->CvdId;
						}

						if(!$InsCompraVehiculoDetalle->MtdEliminarCompraVehiculoDetalle($cvdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
						$this->CvhId = $elemento;
						$this->MtdObtenerCompraVehiculo();

						$sql = 'DELETE FROM tblcvhcompravehiculo WHERE  (CvhId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							
							$this->MtdAuditarCompraVehiculo(3,"Se elimino el Compra de Vehiculo",$aux);		
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
	public function MtdActualizarEstadoCompraVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsCompraVehiculo = new ClsCompraVehiculo();
		//$InsCompraVehiculoDetalles = new ClsCompraVehiculoDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblcvhcompravehiculo SET CvhEstado = '.$oEstado.' WHERE CvhId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarCompraVehiculo(2,"Se actualizo el Estado del Compra de Vehiculo",$elemento);
				
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
	
	
	
	public function MtdActualizarRevisadoCompraVehiculo($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tblcvecompravehiculo SET CvhRevisado = '.$oRevisado.' WHERE CvhId = "'.$elemento.'"';
		
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
	
	public function MtdVerificarExisteCompraVehiculo($oCampo,$oDato,$oProveedor=NULL){

		$Respuesta =   NULL;

		if($oProveedor){
			$einveedor = ' AND PrvId = "'.$oProveedor.'"';
		}

			$sql = 'SELECT 
			CvhId
			FROM tblcvhcompravehiculo
			WHERE '.$oCampo.' = "'.$oDato.'" '.$einveedor.' LIMIT 1;';

			$resultado = $this->InsMysql->MtdConsultar($sql);

			if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
				
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);
				//$this->EinId = $fila['EinId'];
				$Respuesta = $fila['CvhId'];
	
			}
			
			return $Respuesta;
	
		}
	
	
	
	public function MtdRegistrarCompraVehiculo() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarCompraVehiculoId();
			
			

			$CompraVehiculoId = $this->MtdVerificarExisteCompraVehiculo("CvhComprobanteNumero",$this->CvhComprobanteNumero,$this->PrvId);
	
			if(!empty($CompraVehiculoId)){
				$error = true;
				$Resultado.='#ERR_CVH_601';
			}
			
			
			
			$sql = 'INSERT INTO tblcvhcompravehiculo (
			CvhId,	
			SucId,
			
			PrvId,
			CtiId,
			TopId,
			
			NpaId,
			CvhCantidadDia,

			AlmId,
			CvhFecha,
			
			CvhGuiaRemisionNumero,
			CvhGuiaRemisionFecha,
			CvhGuiaRemisionFoto,
			
			CvhComprobanteNumero,
			CvhComprobanteFecha,
			MonId,
			CvhTipoCambio,
			
			CvhIncluyeImpuesto,
			CvhPorcentajeImpuestoVenta,
					
			CvhFoto,
			CvhObservacion,
			
			CvhSubTotal,
			CvhImpuesto,				
			CvhTotal,
				
			CvhCancelado,
			CvhRevisado,
			CvhFacturable,
			
			CvhCierre,
			
			
			CvhTipo,
			CvhSubTipo,
		
			CvhEstado,			
			CvhTiempoCreacion,
			CvhTiempoModificacion) 
			VALUES (
			"'.($this->CvhId).'", 
			"'.($this->SucId).'", 			
			
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'NULL, ':'"'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'NULL, ':'"'.$this->TopId.'",').'
						
			"'.($this->NpaId).'", 
			'.($this->CvhCantidadDia).',
			
			'.(empty($this->AlmId)?'NULL, ':'"'.$this->AlmId.'",').'
			"'.($this->CvhFecha).'", 
		
			"'.($this->CvhGuiaRemisionNumero).'", 
			'.(empty($this->CvhGuiaRemisionFecha)?'NULL, ':'"'.$this->CvhGuiaRemisionFecha.'",').'
			"'.($this->CvhGuiaRemisionFoto).'", 
			
			
			"'.($this->CvhComprobanteNumero).'", 
			'.(empty($this->CvhComprobanteFecha)?'NULL, ':'"'.$this->CvhComprobanteFecha.'",').'
			"'.($this->MonId).'",
			'.($this->CvhTipoCambio).',
			
			
			'.($this->CvhIncluyeImpuesto).',
			'.($this->CvhPorcentajeImpuestoVenta).',

			"'.($this->CvhFoto).'",
			"'.($this->CvhObservacion).'",

			'.($this->CvhSubTotal).',
			'.($this->CvhImpuesto).',
			'.($this->CvhTotal).',
			
			2,
			2,
			1,
			
			2,
			
			1,
			'.($this->CvhSubTipo).',
			
			'.($this->CvhEstado).',
			"'.($this->CvhTiempoCreacion).'", 			
			"'.($this->CvhTiempoModificacion).'");';			
		
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			
			if(!$resultado) {							
				$error = true;
			} 


//			if(round($this->CvhValorTotal) <> round($this->CvhSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_CVH_110';
//			}


			if(!$error){			
			
				if (!empty($this->CompraVehiculoDetalle)){		
						
					$validar = 0;				
					$InsCompraVehiculoDetalle = new ClsCompraVehiculoDetalle();		
					
					foreach ($this->CompraVehiculoDetalle as $DatCompraVehiculoDetalle){
					
						$InsCompraVehiculoDetalle->CvhId = $this->CvhId;
						$InsCompraVehiculoDetalle->EinId = $DatCompraVehiculoDetalle->EinId;
						$InsCompraVehiculoDetalle->UmeId = $DatCompraVehiculoDetalle->UmeId;
						$InsCompraVehiculoDetalle->VehId = $DatCompraVehiculoDetalle->VehId;
						$InsCompraVehiculoDetalle->AlmId = $DatCompraVehiculoDetalle->AlmId;
						
						$InsCompraVehiculoDetalle->CvdFecha = $DatCompraVehiculoDetalle->CvdFecha;
				
						$InsCompraVehiculoDetalle->CvdIdAnterior = $DatCompraVehiculoDetalle->CvdIdAnterior;
						$InsCompraVehiculoDetalle->CvdValorTotal = $DatCompraVehiculoDetalle->CvdValorTotal;
						$InsCompraVehiculoDetalle->CvdCostoPromedio = $DatCompraVehiculoDetalle->CvdCostoPromedio;
						$InsCompraVehiculoDetalle->CvdCostoExtraUnitario = $DatCompraVehiculoDetalle->CvdCostoExtraUnitario;
						$InsCompraVehiculoDetalle->CvdCostoExtraTotal = $DatCompraVehiculoDetalle->CvdCostoExtraTotal;
						$InsCompraVehiculoDetalle->CvdCostoAnterior = $DatCompraVehiculoDetalle->CvdCostoAnterior;
						$InsCompraVehiculoDetalle->CvdCosto = $DatCompraVehiculoDetalle->CvdCosto;						
						$InsCompraVehiculoDetalle->CvdCantidad = $DatCompraVehiculoDetalle->CvdCantidad;
						$InsCompraVehiculoDetalle->CvdImporte = $DatCompraVehiculoDetalle->CvdImporte;
						
						$InsCompraVehiculoDetalle->CvdUbicacion = $DatCompraVehiculoDetalle->CvdUbicacion;
						$InsCompraVehiculoDetalle->CvdObservacion = $DatCompraVehiculoDetalle->CvdObservacion;
						
						
						$InsCompraVehiculoDetalle->CvdCaracteristica1 = $DatCompraVehiculoDetalle->CvdCaracteristica1;
						$InsCompraVehiculoDetalle->CvdCaracteristica2 = $DatCompraVehiculoDetalle->CvdCaracteristica2;
						$InsCompraVehiculoDetalle->CvdCaracteristica3 = $DatCompraVehiculoDetalle->CvdCaracteristica3;
						$InsCompraVehiculoDetalle->CvdCaracteristica4 = $DatCompraVehiculoDetalle->CvdCaracteristica4;
						$InsCompraVehiculoDetalle->CvdCaracteristica5 = $DatCompraVehiculoDetalle->CvdCaracteristica5;
						$InsCompraVehiculoDetalle->CvdCaracteristica6 = $DatCompraVehiculoDetalle->CvdCaracteristica6;
						$InsCompraVehiculoDetalle->CvdCaracteristica7 = $DatCompraVehiculoDetalle->CvdCaracteristica7;
						$InsCompraVehiculoDetalle->CvdCaracteristica8 = $DatCompraVehiculoDetalle->CvdCaracteristica8;
						$InsCompraVehiculoDetalle->CvdCaracteristica9 = $DatCompraVehiculoDetalle->CvdCaracteristica9;
						$InsCompraVehiculoDetalle->CvdCaracteristica10 = $DatCompraVehiculoDetalle->CvdCaracteristica10;
						$InsCompraVehiculoDetalle->CvdCaracteristica11 = $DatCompraVehiculoDetalle->CvdCaracteristica11;
						$InsCompraVehiculoDetalle->CvdCaracteristica12 = $DatCompraVehiculoDetalle->CvdCaracteristica12;
						$InsCompraVehiculoDetalle->CvdCaracteristica13 = $DatCompraVehiculoDetalle->CvdCaracteristica13;
						$InsCompraVehiculoDetalle->CvdCaracteristica14 = $DatCompraVehiculoDetalle->CvdCaracteristica14;
						$InsCompraVehiculoDetalle->CvdCaracteristica15 = $DatCompraVehiculoDetalle->CvdCaracteristica15;
						$InsCompraVehiculoDetalle->CvdCaracteristica16 = $DatCompraVehiculoDetalle->CvdCaracteristica16;
						$InsCompraVehiculoDetalle->CvdCaracteristica17 = $DatCompraVehiculoDetalle->CvdCaracteristica17;
						$InsCompraVehiculoDetalle->CvdCaracteristica18 = $DatCompraVehiculoDetalle->CvdCaracteristica18;
						$InsCompraVehiculoDetalle->CvdCaracteristica19 = $DatCompraVehiculoDetalle->CvdCaracteristica19;
						$InsCompraVehiculoDetalle->CvdCaracteristica20 = $DatCompraVehiculoDetalle->CvdCaracteristica20;

						$InsCompraVehiculoDetalle->CvdEstado = $DatCompraVehiculoDetalle->CvdEstado;									
						$InsCompraVehiculoDetalle->CvdTiempoCreacion = $DatCompraVehiculoDetalle->CvdTiempoCreacion;
						$InsCompraVehiculoDetalle->CvdTiempoModificacion = $DatCompraVehiculoDetalle->CvdTiempoModificacion;						
						$InsCompraVehiculoDetalle->CvdEliminado = $DatCompraVehiculoDetalle->CvdEliminado;
						
						if($InsCompraVehiculoDetalle->MtdRegistrarCompraVehiculoDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_CVH_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->CompraVehiculoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
					
				
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarCompraVehiculo(1,"Se registro el Compra de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarCompraVehiculo() {

		global $Resultado;
		$error = false;

			
			$sql = 'UPDATE tblcvhcompravehiculo SET
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->CtiId)?'CtiId = NULL, ':'CtiId = "'.$this->CtiId.'",').'
			'.(empty($this->TopId)?'TopId = NULL, ':'TopId = "'.$this->TopId.'",').'
			
			NpaId = "'.($this->NpaId).'",
			CvhCantidadDia = '.($this->CvhCantidadDia).',
			
			'.(empty($this->AlmId)?'AlmId = NULL, ':'AlmId = "'.$this->AlmId.'",').'
			
			CvhFecha = "'.($this->CvhFecha).'",
		
			CvhGuiaRemisionNumero = "'.($this->CvhGuiaRemisionNumero).'",
			'.(empty($this->CvhGuiaRemisionFecha)?'CvhGuiaRemisionFecha = NULL, ':'CvhGuiaRemisionFecha = "'.$this->CvhGuiaRemisionFecha.'",').'
			CvhGuiaRemisionFoto = "'.($this->CvhGuiaRemisionFoto).'",
			
			CvhComprobanteNumero = "'.($this->CvhComprobanteNumero).'",
			'.(empty($this->CvhComprobanteFecha)?'CvhComprobanteFecha = NULL, ':'CvhComprobanteFecha = "'.$this->CvhComprobanteFecha.'",').'
			MonId = "'.($this->MonId).'",
			CvhTipoCambio = '.($this->CvhTipoCambio).',
			
			CvhIncluyeImpuesto = '.($this->CvhIncluyeImpuesto).',
			CvhPorcentajeImpuestoVenta = '.($this->CvhPorcentajeImpuestoVenta).',						
			
			CvhFoto = "'.($this->CvhFoto).'",
			CvhObservacion = "'.($this->CvhObservacion).'",

			CvhSubTotal = '.($this->CvhSubTotal).',
			CvhImpuesto = '.($this->CvhImpuesto).',
			CvhTotal = '.($this->CvhTotal).',
			
			CvhEstado = '.($this->CvhEstado).'
			WHERE CvhId = "'.($this->CvhId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			


			//if(round($this->CvhValorTotal) <> round($this->CvhSubTotal)){
//				$error = true;
//				$Resultado.='#ERR_CVH_110';
//			}
			
			
			if(!$error){
			
				if (!empty($this->CompraVehiculoDetalle)){		
						
						
					$validar = 0;				
					$InsCompraVehiculoDetalle = new ClsCompraVehiculoDetalle();
							
					foreach ($this->CompraVehiculoDetalle as $DatCompraVehiculoDetalle){
										
						$InsCompraVehiculoDetalle->CvdId = $DatCompraVehiculoDetalle->CvdId;
						$InsCompraVehiculoDetalle->CvhId = $this->CvhId;
						$InsCompraVehiculoDetalle->EinId = $DatCompraVehiculoDetalle->EinId;
						$InsCompraVehiculoDetalle->UmeId = $DatCompraVehiculoDetalle->UmeId;
						$InsCompraVehiculoDetalle->VehId = $DatCompraVehiculoDetalle->VehId;
						$InsCompraVehiculoDetalle->AlmId = $DatCompraVehiculoDetalle->AlmId;
						$InsCompraVehiculoDetalle->CvdFecha = $DatCompraVehiculoDetalle->CvdFecha;
						
						$InsCompraVehiculoDetalle->CvdIdAnterior = $DatCompraVehiculoDetalle->CvdIdAnterior;
						$InsCompraVehiculoDetalle->CvdValorTotal = $DatCompraVehiculoDetalle->CvdValorTotal;
						$InsCompraVehiculoDetalle->CvdCostoPromedio = $DatCompraVehiculoDetalle->CvdCostoPromedio;
						$InsCompraVehiculoDetalle->CvdCostoExtraUnitario = $DatCompraVehiculoDetalle->CvdCostoExtraUnitario;
						$InsCompraVehiculoDetalle->CvdCostoExtraTotal = $DatCompraVehiculoDetalle->CvdCostoExtraTotal;
						$InsCompraVehiculoDetalle->CvdCostoAnterior = $DatCompraVehiculoDetalle->CvdCostoAnterior;
						$InsCompraVehiculoDetalle->CvdCosto = $DatCompraVehiculoDetalle->CvdCosto;						
						$InsCompraVehiculoDetalle->CvdCantidad = $DatCompraVehiculoDetalle->CvdCantidad;
						$InsCompraVehiculoDetalle->CvdImporte = $DatCompraVehiculoDetalle->CvdImporte;
						$InsCompraVehiculoDetalle->CvdUbicacion = $DatCompraVehiculoDetalle->CvdUbicacion;
						
						$InsCompraVehiculoDetalle->CvdCaracteristica1 = $DatCompraVehiculoDetalle->CvdCaracteristica1;
						$InsCompraVehiculoDetalle->CvdCaracteristica2 = $DatCompraVehiculoDetalle->CvdCaracteristica2;
						$InsCompraVehiculoDetalle->CvdCaracteristica3 = $DatCompraVehiculoDetalle->CvdCaracteristica3;
						$InsCompraVehiculoDetalle->CvdCaracteristica4 = $DatCompraVehiculoDetalle->CvdCaracteristica4;
						$InsCompraVehiculoDetalle->CvdCaracteristica5 = $DatCompraVehiculoDetalle->CvdCaracteristica5;
						$InsCompraVehiculoDetalle->CvdCaracteristica6 = $DatCompraVehiculoDetalle->CvdCaracteristica6;
						$InsCompraVehiculoDetalle->CvdCaracteristica7 = $DatCompraVehiculoDetalle->CvdCaracteristica7;
						$InsCompraVehiculoDetalle->CvdCaracteristica8 = $DatCompraVehiculoDetalle->CvdCaracteristica8;
						$InsCompraVehiculoDetalle->CvdCaracteristica9 = $DatCompraVehiculoDetalle->CvdCaracteristica9;
						$InsCompraVehiculoDetalle->CvdCaracteristica10 = $DatCompraVehiculoDetalle->CvdCaracteristica10;
						$InsCompraVehiculoDetalle->CvdCaracteristica11 = $DatCompraVehiculoDetalle->CvdCaracteristica11;
						$InsCompraVehiculoDetalle->CvdCaracteristica12 = $DatCompraVehiculoDetalle->CvdCaracteristica12;
						$InsCompraVehiculoDetalle->CvdCaracteristica13 = $DatCompraVehiculoDetalle->CvdCaracteristica13;
						$InsCompraVehiculoDetalle->CvdCaracteristica14 = $DatCompraVehiculoDetalle->CvdCaracteristica14;
						$InsCompraVehiculoDetalle->CvdCaracteristica15 = $DatCompraVehiculoDetalle->CvdCaracteristica15;
						$InsCompraVehiculoDetalle->CvdCaracteristica16 = $DatCompraVehiculoDetalle->CvdCaracteristica16;
						$InsCompraVehiculoDetalle->CvdCaracteristica17 = $DatCompraVehiculoDetalle->CvdCaracteristica17;
						$InsCompraVehiculoDetalle->CvdCaracteristica18 = $DatCompraVehiculoDetalle->CvdCaracteristica18;
						$InsCompraVehiculoDetalle->CvdCaracteristica19 = $DatCompraVehiculoDetalle->CvdCaracteristica19;
						$InsCompraVehiculoDetalle->CvdCaracteristica20 = $DatCompraVehiculoDetalle->CvdCaracteristica20;
						
						$InsCompraVehiculoDetalle->CvdEstado = $DatCompraVehiculoDetalle->CvdEstado;		
						$InsCompraVehiculoDetalle->CvdTiempoCreacion = $DatCompraVehiculoDetalle->CvdTiempoCreacion;
						$InsCompraVehiculoDetalle->CvdTiempoModificacion = $DatCompraVehiculoDetalle->CvdTiempoModificacion;
						$InsCompraVehiculoDetalle->CvdEliminado = $DatCompraVehiculoDetalle->CvdEliminado;
						
						
						if(empty($InsCompraVehiculoDetalle->CvdId)){
							if($InsCompraVehiculoDetalle->CvdEliminado<>2){
								if($InsCompraVehiculoDetalle->MtdRegistrarCompraVehiculoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVH_201';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsCompraVehiculoDetalle->CvdEliminado==2){
								if($InsCompraVehiculoDetalle->MtdEliminarCompraVehiculoDetalle($InsCompraVehiculoDetalle->CvdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CVH_203';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsCompraVehiculoDetalle->MtdEditarCompraVehiculoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_CVH_202';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->CompraVehiculoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarCompraVehiculo(2,"Se edito el Compra de Vehiculo",$this);		
				return true;
			}	
				
		}
		
		
	
		public function MtdEditarCompraVehiculoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblcvhcompravehiculo SET 
			'.$oCampo.' = "'.($oDato).'",
			CvhTiempoModificacion = NOW()
			WHERE CvhId = "'.($oId).'";';
			
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



		private function MtdAuditarCompraVehiculo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->CvhId;

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
		
		
		public function MtdNotificarAlmacennMovimientoEntradaOrdenCompra($oCompraVehiculo,$oDestinatario,$oImportante=false){
			
global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->CvhId = $oCompraVehiculo;
			$this->MtdObtenerCompraVehiculo();
			
			$InsOrdenCompra = new ClsOrdenCompra();
			$InsOrdenCompra->OcoId = $this->OcoId;
			$InsOrdenCompra->MtdObtenerOrdenCompra();
			

							
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Ingreso a almacen c/ Orden de Compra .";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->CvhId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Proveedor: <b>".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->CvhFecha."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Orden de Compra: <b>".$this->OcoId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			$mensaje .= "Datos del comeinbante";	
			$mensaje .= "<br>";
			$mensaje .= "Tipo: <b>".$this->CtiNombre."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Numero : <b>".$this->CvhComprobanteNumero."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Fecha : <b>".$this->CvhComprobanteFecha."</b>";				
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


								if(empty($DatPedidoCompraDetalle->CvdCantidad)){
									$fondo = "#F30";
								}else if($DatPedidoCompraDetalle->CvdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$fondo = "#6F3";
								}else if($DatPedidoCompraDetalle->CvdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
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
								
								if(empty($DatPedidoCompraDetalle->CvdCantidad)){
									$mensaje .= "No Atendido";
								}else if($DatPedidoCompraDetalle->CvdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Ya llego";
								}else if($DatPedidoCompraDetalle->CvdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Incompleto, aun faltan (".($DatPedidoCompraDetalle->PcdCantidad - $DatPedidoCompraDetalle->CvdCantidad).") items";
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
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." [IMPORTANTE]".$this->PrvApellidoMaterno,$mensaje);
						
			}else{
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno,$mensaje);
					
			}
			
				
				
			
		}
		
//		MtdNotificarAlmacennMovimientoEntradaOrdenCompra
		public function MtdNotificarCompraVehiculoVencimiento($oDestinatario,$oFechaInicio=NULL,$oFechaFin=NULL,$oCondicionPago=NULL,$oProveedor=NULL){
		
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$Enviar = false;
			
			$ProveedorNombre = "";
			$ProveedorNumeroDocumento = "";
			
			if(!empty($oProveedor)){
				
				$InsProveedor = new ClsProveedor();
				$InsProveedor->PrvId = $oProveedor;
				$InsProveedor->MtdObtenerProveedor();
				
				$ProveedorNombre = $InsProveedor->PrvNombre." ".$InsProveedor->PrvApellidoPaterno." ".$InsProveedor->PrvApellidoMaterno;
				$ProveedorNumeroDocumento = $InsProveedor->PrvNumeroDocumento;
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
				//MtdObtenerCompraVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CvhId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrigen=NULL,$oMoneda=NULL,$oOrdenCompra=NULL,$oPedidoCompra=NULL,$oPedidoCompraDetalle=NULL,$oCliente=NULL,$oFecha="CvhFecha",$oConOrdenCompra=0,$oCancelado=0,$oProveedor=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL) {
				$ResCompraVehiculo = $this->MtdObtenerCompraVehiculos(NULL,NULL,NULL,"CvhComprobanteFecha","ASC",NULL,FncCambiaFechaAMysql($oFechaInicio),FncCambiaFechaAMysql($oFechaFin),NULL,NULL,$DatMoneda->MonId,NULL,NULL,NULL,NULL,"CvhComprobanteFecha",0,2,$oProveedor,NULL,$oCondicionPago);
				$ArrCompraVehiculos = $ResCompraVehiculo['Datos'];

				if(!empty($ArrCompraVehiculos)){
				
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
						$mensaje .= "<b>CVHRT.</b>";
						$mensaje .= "</td>";
						
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>SALDO</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td width='5%'>";
						$mensaje .= "<b>VENCIMIENTO</b>";
						$mensaje .= "</td>";
						
						
					$mensaje .= "</tr>";
					
					
							
				$c = 1;	
				
				foreach($ArrCompraVehiculos as $DatCompraVehiculo){


					$DatCompraVehiculo->CvhTotal = (($EmpresaMonedaId==$DatMoneda->MonId or empty($DatMoneda->MonId))?$DatCompraVehiculo->CvhTotal:($DatCompraVehiculo->CvhTotal/$DatCompraVehiculo->CvhTipoCambio));
				
					$DatCompraVehiculo->CvhTotal = round($DatCompraVehiculo->CvhTotal,2);
					
					$Mostrar = true;

					if($DatCompraVehiculo->NpaId == "NPA-10001"){
						
						settype($DatCompraVehiculo->CvhTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatCompraVehiculo->CvhTotal+1000)){
							if($DatCompraVehiculo->CvhCantidadDia<$DatCompraVehiculo->CvhDiaTranscurrido){
								
							}else if ( ($DatCompraVehiculo->CvhCantidadDia - $DatCompraVehiculo->CvhDiaTranscurrido) >= 1 and ($DatCompraVehiculo->CvhCantidadDia - $DatCompraVehiculo->CvhDiaTranscurrido) <=3 ){
				
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
					$mensaje .= $DatCompraVehiculo->NpaNombre;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= "<span title='".$DatCompraVehiculo->CvhId."'>".$DatCompraVehiculo->CvhComprobanteNumero."</span>";
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatCompraVehiculo->CvhComprobanteFecha;
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatCompraVehiculo->PrvNumeroDocumento;
					$mensaje .= "</td>";

					
					$mensaje .= "<td>";
					$mensaje .= $DatCompraVehiculo->PrvNombreCompleto;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatCompraVehiculo->MonSimbolo;
					$mensaje .= "</td>";
					
					
					$mensaje .= "<td>";
					$mensaje .= $DatCompraVehiculo->OcoId;
					$mensaje .= "</td>";
							
					$mensaje .= "<td>";
					
					if($DatCompraVehiculo->NpaId == "NPA-10001"){
					
						$mensaje .= $DatCompraVehiculo->CvhCantidadDia;
						
						if($DatCompraVehiculo->CvhCantidadDia <=30){
							$TotalCredito30 += $DatCompraVehiculo->CvhTotal;
						}else{
							$TotalCredito30Mas += $DatCompraVehiculo->CvhTotal;
						}
					
					}else{
						$TotalContado += $DatCompraVehiculo->CvhTotal;
					}
					
					$mensaje .= "</td>";
					
					$mensaje .= "<td>";
					$mensaje .= $DatCompraVehiculo->CvhFechaVencimiento;
					$mensaje .= "</td>";
								
					$mensaje .= "<td>";
					$mensaje .= number_format($DatCompraVehiculo->CvhTotal,2);
					$mensaje .= "</td>";
								

		
					$ProveedorPagoMontoTotal = 0;

					switch($DatCompraVehiculo->CvhCancelado){
					
						case 1:
							$ProveedorPagoMontoTotal = $DatCompraVehiculo->CvhTotal;					
						break;
					
						case 2:
									
						break;	

					}
				
					$mensaje .= "<td>";
					$mensaje .= $ProveedorPagoMontoTotal;
					$mensaje .= "</td>";
					
					settype($DatCompraVehiculo->CvhTotal ,"float");
					settype($ProveedorPagoMontoTotal ,"float");
					
					$CompraVehiculoSaldo = round($DatCompraVehiculo->CvhTotal,2) - round($ProveedorPagoMontoTotal,2);
		
						
					$mensaje .= "<td>";
					$mensaje .= number_format($CompraVehiculoSaldo,2);
					$mensaje .= "</td>";
					
					
		
					$mensaje .= "<td>";

	
					if($DatCompraVehiculo->NpaId == "NPA-10001"){
						
						settype($DatCompraVehiculo->CvhTotal ,"float");
						settype($ProveedorPagoMontoTotal ,"float");
						
						
						if(($ProveedorPagoMontoTotal+1000) < ($DatCompraVehiculo->CvhTotal+1000)){
							if($DatCompraVehiculo->CvhCantidadDia<$DatCompraVehiculo->CvhDiaTranscurrido){
								
								$mensaje .= "VENCIDO ";
								$mensaje .= ($DatCompraVehiculo->CvhDiaTranscurrido - $DatCompraVehiculo->CvhCantidadDia)." dias";
								
							}else if ( ($DatCompraVehiculo->CvhCantidadDia - $DatCompraVehiculo->CvhDiaTranscurrido) >= 1 and ($DatCompraVehiculo->CvhCantidadDia - $DatCompraVehiculo->CvhDiaTranscurrido) <=3 ){
								
								$mensaje .= "POR VENCER ";				
								$mensaje .= ($DatCompraVehiculo->CvhCantidadDia - $DatCompraVehiculo->CvhDiaTranscurrido)." dias";
				
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

		
		/*public function MtdEditarCompraVehiculoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblnccnotacreditocompra SET 
			'.(empty($oDato)?$oCampo.' = NULL  ':$oCampo.' = "'.$oDato.'" ').'
		
			WHERE CvhId = "'.($oId).'";';
			
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