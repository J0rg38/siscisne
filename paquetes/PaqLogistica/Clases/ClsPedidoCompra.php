<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPedidoCompra
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPedidoCompra {

    public $PcoId;
	
	public $CliId;
	
	public $VdiId;
	public $OcoId;
	public $FccId;
	public $PerId;
	
	public $PcoFecha;
	
	public $MonId;
	public $PcoTipoCambio;
	
	public $PcoIncluyeImpuesto;
	public $PcoPorcentajeImpuestoVenta;
	
    public $PcoObservacion;
	
	public $PcoSubTotal;
	public $PcoImpuesto;
	public $PcoTotal;
	
	public $PcoOrigen;
	public $PcoEstado;
	public $PcoTiempoCreacion;
	public $PcoTiempoModificacion;
    public $PcoEliminado;
	
	
	public $CprId;
	public $CliNombreCompleto;
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;

		
	public $TdoId;
	public $CliNumeroDocumento;
	
	public $LtiNombre;
	public $TdoNombre;
	
	public $MonNombre;
	public $MonSimbolo;
				
	public $PcoTotalItems;
	public $PedidoCompraDetalle;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarPedidoCompraId() {


		$sql = 'SELECT	
		suc.SucSiglas,
		MAX(CONVERT(SUBSTR(pco.PcoId,9),unsigned)) AS "MAXIMO"
		FROM tblpcopedidocompra pco
			LEFT JOIN tblsucsucursal suc
			ON pco.SucId = suc.SucId
			
			WHERE YEAR(pco.PcoFecha) = '.$this->PcoAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->PcoId = "PC-".$this->PcoAno."-00001-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);
		}else{
			$fila['MAXIMO']++;
			$this->PcoId = "PC-".$this->PcoAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT)."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);
		}
				
	}
		
    public function MtdObtenerPedidoCompra(){

        $sql = 'SELECT 
        pco.PcoId,
		pco.SucId,
		
		pco.CliId,
		
		pco.VdiId,
		pco.OcoId,
		pco.FccId,
		pco.PerId,
		
		
		DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
		DATE_FORMAT(pco.PcoHora, "%H:%i") AS "NPcoHora",
		pco.PcoTipoPedido,
		
		pco.MonId,
		pco.PcoTipoCambio,
		
		pco.PcoIncluyeImpuesto,
		pco.PcoPorcentajeImpuestoVenta,
	
		pco.PcoObservacion,
		pco.PcoObservacionImpresa,
		pco.PcoObservacionCorreo,
		pco.PcoSolicitudAprobacionRespuesta,

		pco.PcoSubTotal,
		pco.PcoImpuesto,
		pco.PcoTotal,

		pco.PcoOrigen,
		pco.PcoEstado,
		DATE_FORMAT(pco.PcoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcoTiempoCreacion",
        DATE_FORMAT(pco.PcoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcoTiempoModificacion",

		(SELECT COUNT(pcd.PcdId) FROM tblpcdpedidocompradetalle pcd WHERE pcd.PcoId = pco.PcoId ) AS "PcoTotalItems",

		
		vdi.CprId,
		DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
		
		DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
		
		vdi.VdiOrdenCompraNumero,
		DATE_FORMAT(vdi.VdiOrdenCompraNumero, "%d/%m/%Y") AS "NVdiOrdenCompraNumero",
		
		DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
		
		cli.CliNombreCompleto,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		cli.TdoId,
		cli.CliNumeroDocumento,
		tdo.TdoNombre,
		
		oco.PrvId,
		oco.OcoEstado,
		oco.OcoTipo,
		
		DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
		oco.OcoHora,
		
		oco.OcoVIN,
		oco.OcoOrdenTrabajo,
		
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		fim.FinId,
		min.MinNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerNumeroDocumento,
		per.PerEmail,
		
		CONCAT(IFNULL(prv.PrvNombre,"")," ",IFNULL(prv.PrvApellidoPaterno,"")," ",IFNULL(prv.PrvApellidoMaterno,"")) AS PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,		
		prv.PrvNumeroDocumento,
		prv.TdoId AS TdoIdProveedor,
		
		ein.EinVIN,
		ein.EinPlaca,
		
		vdi.FinId
		
        FROM tblpcopedidocompra pco
			LEFT JOIN tblvdiventadirecta vdi
			ON pco.VdiId = vdi.VdiId
				LEFT JOIN tbleinvehiculoingreso ein
				ON vdi.EinId = ein.EinId
				
				LEFT JOIN tblperpersonal per
				ON pco.PerId = per.PerId
				
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
				
				LEFT JOIN tblclicliente cli
				ON pco.CliId = cli.CliId
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
						LEFT JOIN tblocoordencompra oco
						ON pco.OcoId = oco.OcoId
						
						
						
							LEFT JOIN tblprvproveedor prv
							ON oco.PrvId = prv.PrvId
							
							LEFT JOIN tblmonmoneda mon
							ON pco.MonId = mon.MonId
							
								LEFT JOIN tblfccfichaaccion fcc
								ON pco.FccId = fcc.FccId
								
									LEFT JOIN tblfimfichaingresomodalidad fim
									ON fcc.FimId = fim.FimId
									
										LEFT JOIN tblminmodalidadingreso min
										ON fim.MinId = min.MinId

        WHERE pco.PcoId = "'.$this->PcoId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
			
				
			$this->PcoId = $fila['PcoId'];
			$this->SucId = $fila['SucId'];
			
			$this->CliId = $fila['CliId'];
			$this->VdiId = $fila['VdiId'];
			$this->OcoId = $fila['OcoId'];
			$this->FccId = $fila['FccId'];
			$this->PerId = $fila['PerId'];
			
			$this->PcoFecha = $fila['NPcoFecha'];
			$this->PcoHora = $fila['NPcoHora'];
			$this->PcoTipoPedido = $fila['PcoTipoPedido'];

			$this->MonId = $fila['MonId'];
			$this->PcoTipoCambio = $fila['PcoTipoCambio'];

			$this->PcoIncluyeImpuesto = $fila['PcoIncluyeImpuesto'];
			$this->PcoPorcentajeImpuestoVenta = $fila['PcoPorcentajeImpuestoVenta'];

			$this->PcoObservacion = $fila['PcoObservacion'];
			$this->PcoObservacionImpresa = $fila['PcoObservacionImpresa'];
			$this->PcoObservacionCorreo = $fila['PcoObservacionCorreo'];
			
			$this->PcoSolicitudAprobacionRespuesta = $fila['PcoSolicitudAprobacionRespuesta'];

			$this->PcoSubTotal = $fila['PcoSubTotal'];
			$this->PcoImpuesto = $fila['PcoImpuesto'];
			$this->PcoTotal = $fila['PcoTotal'];

			$this->PcoOrigen = $fila['PcoOrigen'];
			$this->PcoEstado = $fila['PcoEstado'];
			$this->PcoTiempoCreacion = $fila['NPcoTiempoCreacion']; 
			$this->PcoTiempoModificacion = $fila['NPcoTiempoModificacion']; 	
			
			$this->PcoTotalItems = $fila['PcoTotalItems'];

			$this->CprId = $fila['CprId'];
			$this->CprFecha = $fila['NCprFecha'];

			$this->VdiFecha = $fila['NVdiFecha'];
			
			$this->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
			$this->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];

			$this->CliNombreCompleto = $fila['CliNombreCompleto'];		
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->TdoId = $fila['TdoId'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			
			$this->TdoNombre = $fila['TdoNombre'];

$this->PrvId = $fila['PrvId'];
			$this->OcoEstado = $fila['OcoEstado'];
			$this->OcoTipo = $fila['OcoTipo'];
			$this->OcoFecha = $fila['NOcoFecha'];
			$this->OcoHora = $fila['OcoHora'];
			
			$this->OcoVIN = $fila['OcoVIN'];
			$this->OcoOrdenTrabajo = $fila['OcoOrdenTrabajo'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->FinId = $fila['FinId'];
			$this->MinNombre = $fila['MinNombre'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerNumeroDocumento = $fila['PerNumeroDocumento'];
			$this->PerEmail = $fila['PerEmail'];
			
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvNombreCompleto = $fila['PrvNombreCompleto'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoIdProveedor = $fila['TdoIdProveedor'];
			
			$this->EinVIN = $fila['EinVIN'];
			$this->EinPlaca = $fila['EinPlaca'];
			
			
			$this->FinId = $fila['FinId'];
	
			switch($this->PcoEstado){

				case 1:
					$this->PcoEstadoDescripcion = "Pendiente";
				break;

				case 3:
					$this->PcoEstadoDescripcion = "Listo";
				break;	
				
				case 31:
					$this->PcoEstadoDescripcion = "Correo Enviado";
				break;	

				case 6:
					$this->PcoEstadoDescripcion = "Anulado";
				break;
				
				default:
					$this->PcoEstadoDescripcion = "";
				break;

			}	
			
			switch($this->PcoEstado){
			
				case 1:
					$this->PcoEstadoIcono = '<img width="15" height="15" alt="[Armado]" title="En Armado" src="imagenes/estado/pendiente.png" />';
				break;
			
				case 3:
					$this->PcoEstadoIcono = '<img width="15" height="15" alt="[Listo]" title="Listo" src="imagenes/estado/realizado.png" />';						
				break;	
				
				case 31:
					$this->PcoEstadoIcono = '<img width="15" height="15" alt="[Correo Enviado]" title="Correo Enviado" src="imagenes/estado/correo_enviado.png" />';						
				break;

				case 6:
					$this->PcoEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src=" imagenes/estado/anulado.png" />';						
				break;	

				default:
					$this->PcoEstadoIcono = "";
				break;
			
			}
					
			$ResPedidoCompraDetalle =  $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,NULL,NULL,NULL,$this->PcoId);
			$this->PedidoCompraDetalle = 	$ResPedidoCompraDetalle['Datos'];	

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPedidoCompras($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'PcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oConOrdenCompra=0,$oVentaDirecta=NULL,$oOrdenCompra=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oOrigen=array(),$oSucursal=NULL) {

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
					pcd.PcdId
					
					FROM tblpcdpedidocompradetalle pcd
						
						LEFT JOIN tblproproducto pro
						ON pcd.ProId = pro.ProId
						
							
								
								
					WHERE 
					
						pcd.PcoId = pco.PcoId
						AND
						(
							pro.ProNombre LIKE "%'.$oFiltro.'%" OR
							pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%"  OR
							pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(pco.PcoFecha)>="'.$oFechaInicio.'" AND DATE(pco.PcoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(pco.PcoFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pco.PcoFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND pco.PcoEstado = '.$oEstado;
		}

		if(!empty($oMoneda)){
			$moneda = ' AND pco.MonId = "'.$oMoneda.'"';
		}
		
		switch($oConOrdenCompra){

			case 1:
				$cocompra = ' AND pco.OcoId IS NOT NULL';
			break;

			case 2:
				$cocompra = ' AND pco.OcoId IS  NULL';
			break;
			
			default:
			
			break;

		}

		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND pco.VdiId = "'.$oVentaDirecta.'"';
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND pco.OcoId = "'.$oOrdenCompra.'"';
		}
		
		
		if(!empty($oFichaAccion)){
			$faccion = ' AND pco.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oFichaIngreso)){
			
			$fingreso = ' AND (fim.FinId = "'.$oFichaIngreso.'" OR 
			
				EXISTS (
					SELECT 
					cpr.CprId 
					FROM tblcprcotizacionproducto cpr
					WHERE vdi.CprId  = cpr.CprId
					AND cpr.FinId = "'.$oFichaIngreso.'"
					LIMIT 1
				)
			
			)';
		}
		
		if(!empty($oOrigen)){
			
			$i=1;
			$origen .= ' AND (
			(';
			//$elementos = array_filter($elementos);
			foreach($oOrigen as $elemento){
				
				 if( !next( $oOrigen ) ) {
					 $origen .= '  (pco.PcoOrigen = "'.($elemento).'" )  ';
				 }else{
					 $origen .= '  (pco.PcoOrigen = "'.($elemento).'" ) OR';
				 }
			
			$i++;		
			}

			$origen .= ' ) 
			)
			';
			
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND pco.SucId = "'.$oSucursal.'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pco.PcoId,
				pco.SucId,
				
				pco.CliId,	
				pco.VdiId,
				pco.OcoId,
				pco.FccId,
				pco.PerId,
				
				DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
				DATE_FORMAT(pco.PcoHora, "%H:%i") AS "NPcoHora",
				
				pco.PcoTipoPedido,
				
				pco.MonId,
				pco.PcoTipoCambio,
				
				pco.PcoIncluyeImpuesto,
				pco.PcoPorcentajeImpuestoVenta,
		
				pco.PcoObservacion,
				pco.PcoObservacionImpresa,
				pco.PcoObservacionCorreo,
				
				pco.PcoSubTotal,
				pco.PcoImpuesto,				
				pco.PcoTotal,
				
				pco.PcoOrigen,
				pco.PcoAprobado,
				pco.PcoEstado,
				DATE_FORMAT(pco.PcoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcoTiempoCreacion",
	        	DATE_FORMAT(pco.PcoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcoTiempoModificacion",
				
				(SELECT COUNT(pcd.PcdId) FROM tblpcdpedidocompradetalle pcd WHERE pcd.PcoId = pco.PcoId ) AS "PcoTotalItems",
				
				vdi.CprId,
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.TdoId,
				cli.CliNumeroDocumento,
				
				oco.PrvId,
				oco.OcoEstado,
				
				lti.LtiNombre,
				tdo.TdoNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
				
				oco.OcoProcesadoProveedor,
				
				fim.FinId,
				min.MinNombre,
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId AS TdoIdProveedor,
				prv.PrvLineaCreditoActiva,
				
				ein.EinVIN,
				vdi.FinId,
				
				CASE
				WHEN EXISTS (
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.VdiId = pco.VdiId 
					AND pag.PagEstado = 3
					LIMIT 1
					
				) THEN "Si"
				ELSE "No"
				END AS VdiPago
		
				FROM tblpcopedidocompra pco
				
					LEFT JOIN tblvdiventadirecta vdi
					ON pco.VdiId = vdi.VdiId
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON vdi.EinId = ein.EinId
						
						LEFT JOIN tblmonmoneda mon
						ON pco.MonId = mon.MonId
						
						LEFT JOIN tblclicliente cli
						ON pco.CliId = cli.CliId
							
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
								
									LEFT JOIN tblocoordencompra oco
									ON pco.OcoId = oco.OcoId
									
										LEFT JOIN tblprvproveedor prv
										ON oco.PrvId = prv.PrvId
										
								LEFT JOIN tblfccfichaaccion fcc
								ON pco.FccId = fcc.FccId
								
									LEFT JOIN tblfimfichaingresomodalidad fim
									ON fcc.FimId = fim.FimId
									
										LEFT JOIN tblminmodalidadingreso min
										ON fim.MinId = min.MinId
										
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$sucursal.$stipo.$estado.$moneda.$origen.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPedidoCompra = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PedidoCompra = new $InsPedidoCompra();
                    $PedidoCompra->PcoId = $fila['PcoId'];
					$PedidoCompra->SucId = $fila['SucId'];
					
					$PedidoCompra->CliId = $fila['CliId'];
					$PedidoCompra->VdiId = $fila['VdiId'];
					$PedidoCompra->OcoId = $fila['OcoId'];
					$PedidoCompra->FccId = $fila['FccId'];
					$PedidoCompra->PerId = $fila['PerId'];
										
					$PedidoCompra->PcoFecha = $fila['NPcoFecha'];
					$PedidoCompra->PcoHora = $fila['NPcoHora'];
					$PedidoCompra->PcoTipoPedido = $fila['PcoTipoPedido'];
					
					
					$PedidoCompra->MonId = $fila['MonId'];
					$PedidoCompra->PcoTipoCambio = $fila['PcoTipoCambio'];
					
					$PedidoCompra->PcoIncluyeImpuesto = $fila['PcoIncluyeImpuesto'];
					$PedidoCompra->PcoPorcentajeImpuestoVenta = $fila['PcoPorcentajeImpuestoVenta'];					
					$PedidoCompra->PcoObservacion = $fila['PcoObservacion'];
					$PedidoCompra->PcoObservacionImpresa = $fila['PcoObservacionImpresa'];
					$PedidoCompra->PcoObservacionCorreo = $fila['PcoObservacionCorreo'];

					$PedidoCompra->PcoSubTotal = $fila['PcoSubTotal'];			
					$PedidoCompra->PcoImpuesto = $fila['PcoImpuesto'];
					$PedidoCompra->PcoTotal = $fila['PcoTotal'];

					$PedidoCompra->PcoOrigen = $fila['PcoOrigen'];
					$PedidoCompra->PcoAprobado = $fila['PcoAprobado'];
					$PedidoCompra->PcoEstado = $fila['PcoEstado'];
					$PedidoCompra->PcoTiempoCreacion = $fila['NPcoTiempoCreacion'];  
					$PedidoCompra->PcoTiempoModificacion = $fila['NPcoTiempoModificacion']; 

					$PedidoCompra->PcoTotalItems = $fila['PcoTotalItems']; 

					$PedidoCompra->CprId = $fila['CprId'];

					$PedidoCompra->CliNombreCompleto = $fila['CliNombreCompleto'];
					$PedidoCompra->CliNombre = $fila['CliNombre'];
					$PedidoCompra->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$PedidoCompra->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$PedidoCompra->TdoId = $fila['TdoId'];
					$PedidoCompra->CliNumeroDocumento = $fila['CliNumeroDocumento'];

					$PedidoCompra->PrvId = $fila['PrvId'];
					$PedidoCompra->OcoEstado = $fila['OcoEstado'];

					$PedidoCompra->LtiNombre = $fila['LtiNombre'];
					$PedidoCompra->TdoNombre = $fila['TdoNombre'];
					
					$PedidoCompra->MonNombre = $fila['MonNombre'];
					$PedidoCompra->MonSimbolo = $fila['MonSimbolo'];
					
					$PedidoCompra->OcoFecha = $fila['NOcoFecha'];
					
					$PedidoCompra->OcoProcesadoProveedor = $fila['OcoProcesadoProveedor'];
					
					$PedidoCompra->EinVIN = $fila['EinVIN'];
					$PedidoCompra->FinId = $fila['FinId'];
					
					$PedidoCompra->VdiPago = $fila['VdiPago'];
				
					switch($PedidoCompra->PcoEstado){

						case 1:
							$PedidoCompra->PcoEstadoDescripcion = "Pendiente";
						break;
		
						case 3:
							$PedidoCompra->PcoEstadoDescripcion = "Listo";
						break;	
						
						case 31:
							$PedidoCompra->PcoEstadoDescripcion = "Correo Enviado";
						break;	
		
						case 6:
							$PedidoCompra->PcoEstadoDescripcion = "Anulado";
						break;
						
						default:
							$PedidoCompra->PcoEstadoDescripcion = "";
						break;
		
					}	
			
					switch($PedidoCompra->PcoEstado){
					
						case 1:
							$PedidoCompra->PcoEstadoIcono = '<img width="15" height="15" alt="[Armado]" title="En Armado" src="imagenes/estado/pendiente.png" />';
						break;
					
						case 3:
							$PedidoCompra->PcoEstadoIcono = '<img width="15" height="15" alt="[Listo]" title="Listo" src="imagenes/estado/realizado.png" />';						
						break;	
						
						case 31:
							$PedidoCompra->PcoEstadoIcono = '<img width="15" height="15" alt="[Correo Enviado]" title="Correo Enviado" src="imagenes/estado/correo_enviado.png" />';						
						break;
		
						case 6:
							$PedidoCompra->PcoEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src=" imagenes/estado/anulado.png" />';						
						break;	
		
						default:
							$PedidoCompra->PcoEstadoIcono = "";
						break;
					
					}
					
					$PedidoCompra->FinId = $fila['FinId'];
					$PedidoCompra->MinNombre = $fila['MinNombre'];
					
					$PedidoCompra->PrvNombre = $fila['PrvNombre'];
					$PedidoCompra->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$PedidoCompra->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$PedidoCompra->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$PedidoCompra->TdoIdProveedor = $fila['TdoIdProveedor'];
					$PedidoCompra->PrvLineaCreditoActiva = $fila['PrvLineaCreditoActiva'];


                    $PedidoCompra->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompra;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarPedidoCompra($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					$aux = explode("%",$elemento);	
					
					$ResPedidoCompraDetalle = $InsPedidoCompraDetalle->MtdObtenerPedidoCompraDetalles(NULL,NULL,'PcdId','Desc',NULL,$aux[0]);
					$ArrPedidoCompraDetalles = $ResPedidoCompraDetalle['Datos'];

					if(!empty($ArrPedidoCompraDetalles)){
						$amdetalle = '';

						foreach($ArrPedidoCompraDetalles as $DatPedidoCompraDetalle){
							$amdetalle .= '#'.$DatPedidoCompraDetalle->PcdId;
						}

						if(!$InsPedidoCompraDetalle->MtdEliminarPedidoCompraDetalle($amdetalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblpcopedidocompra WHERE  (PcoId = "'.($aux[0]).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarPedidoCompra(3,"Se elimino el Pedido de Compra",$aux);		
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
	public function MtdActualizarEstadoPedidoCompra($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsPedidoCompra = new ClsPedidoCompra();
		$InsPedidoCompraDetalles = new ClsPedidoCompraDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblpcopedidocompra SET PcoEstado = '.$oEstado.' WHERE PcoId = "'.$aux[0].'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarPedidoCompra(2,"Se actualizo el Estado del Pedido de Compra",$aux);
				
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
	public function MtdActualizarAprobadoPedidoCompra($oElementos,$oAprobado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsPedidoCompra = new ClsPedidoCompra();
		
		$i=1;
		foreach($elementos as $elemento){
		
			if(!empty($elemento)){
		
				$sql = 'UPDATE tblpcopedidocompra SET PcoAprobado = '.$oAprobado.' WHERE PcoId = "'.$elemento.'"';
		
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				}else{
					$this->MtdAuditarPedidoCompra(2,"Se actualizo el Estado Aprobado del Pedido de Compra",$elemento);
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
	
	
	public function MtdRegistrarPedidoCompra($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarPedidoCompraId();
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
				
			
			$sql = 'INSERT INTO tblpcopedidocompra (
			PcoId,
			SucId,
			
			CliId,
			VdiId,				
			OcoId,
			FccId,
			
			PerId,
			
			PcoFecha,
			PcoHora,
			
			PcoTipoPedido,
			
			
			MonId,
			PcoTipoCambio,
			
			PcoIncluyeImpuesto,
			PcoPorcentajeImpuestoVenta,

			PcoObservacion,
			PcoObservacionImpresa,
			PcoObservacionCorreo,
			
			PcoSubTotal,
			PcoImpuesto,				
			PcoTotal,
			PcoOrigen,
			
			PcoAprobado,
			PcoEstado,			
			PcoTiempoCreacion,
			PcoTiempoModificacion) 
			VALUES (
			"'.($this->PcoId).'", 
			"'.($this->SucId).'", 
			
			'.(empty($this->CliId)?"NULL,":'"'.$this->CliId.'",').'
			'.(empty($this->VdiId)?"NULL,":'"'.$this->VdiId.'",').'
			'.(empty($this->OcoId)?"NULL,":'"'.$this->OcoId.'",').'
			'.(empty($this->FccId)?"NULL,":'"'.$this->FccId.'",').'

			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			
			"'.($this->PcoFecha).'", 
			"'.($this->PcoHora).'", 
			
			"'.($this->PcoTipoPedido).'", 
			
			
			
			"'.($this->MonId).'", 
			
			'.(empty($this->PcoTipoCambio)?"NULL,":''.$this->PcoTipoCambio.',').'
			
			'.($this->PcoIncluyeImpuesto).',
			'.($this->PcoPorcentajeImpuestoVenta).',

			"'.($this->PcoObservacion).'",
			"'.($this->PcoObservacionImpresa).'",
			"'.($this->PcoObservacionCorreo).'",
			
			'.($this->PcoSubTotal).',
			'.($this->PcoImpuesto).',
			'.($this->PcoTotal).',
			"'.($this->PcoOrigen).'",
			
			'.($this->PcoAprobado).',
			'.($this->PcoEstado).',
			"'.($this->PcoTiempoCreacion).'", 				
			"'.($this->PcoTiempoModificacion).'");';			
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
				
			//	deb($this->InsMysql->MtdObtenerErrorCodigo());
				
				switch($this->InsMysql->MtdObtenerErrorCodigo()){
				
						case 1452:
							
							$cadena_error = $this->InsMysql->MtdObtenerError();
							$pos = strpos($cadena_error, "tblclicliente");

							if ($pos !== false) {
								$Resultado.="#ERR_PCO_1000";	
							}
							
						break;

				}
					
			} 
						
						
						
			if(!$error){
				
				
				if(!empty( $this->OcoId)){
			
					$InsOrdenCompra = new ClsOrdenCompra();
					
					$InsOrdenCompra->OcoId = $this->OcoId;
					$InsOrdenCompra->MtdObtenerOrdenCompra();
				  	
					$Total = 0;
					
					if(!empty($InsOrdenCompra->OrdenCompraPedido)){
						
						foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
							$Total += $DatOrdenCompraPedido->PcoTotal;
						}
						
						$InsOrdenCompra->MtdEditarOrdenCompraDato("OcoTotal",$Total,$InsOrdenCompra->OcoId);
					}
					
				}
				 
			}


					
			if(!$error){			
			
				if (!empty($this->PedidoCompraDetalle)){		
						
					$validar = 0;				
					$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();		
					
					foreach ($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
					
						$InsPedidoCompraDetalle->PcoId = $this->PcoId;
						$InsPedidoCompraDetalle->ProId = $DatPedidoCompraDetalle->ProId;
						$InsPedidoCompraDetalle->UmeId = $DatPedidoCompraDetalle->UmeId;
						$InsPedidoCompraDetalle->VddId = $DatPedidoCompraDetalle->VddId;
						
						$InsPedidoCompraDetalle->PcdAno = $DatPedidoCompraDetalle->PcdAno;
						$InsPedidoCompraDetalle->PcdModelo = $DatPedidoCompraDetalle->PcdModelo;
						$InsPedidoCompraDetalle->PcdCodigo = $DatPedidoCompraDetalle->PcdCodigo;
		
						$InsPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
						$InsPedidoCompraDetalle->PcdCantidad = $DatPedidoCompraDetalle->PcdCantidad;
						$InsPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte;
						$InsPedidoCompraDetalle->PcdObservacion = $DatPedidoCompraDetalle->PcdObservacion;
						
						$InsPedidoCompraDetalle->PcdEstado = $DatPedidoCompraDetalle->PcdEstado;									
						$InsPedidoCompraDetalle->PcdTiempoCreacion = $DatPedidoCompraDetalle->PcdTiempoCreacion;
						$InsPedidoCompraDetalle->PcdTiempoModificacion = $DatPedidoCompraDetalle->PcdTiempoModificacion;						
						$InsPedidoCompraDetalle->PcdEliminado = $DatPedidoCompraDetalle->PcdEliminado;
						
						if($InsPedidoCompraDetalle->MtdRegistrarPedidoCompraDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_PCO_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->PedidoCompraDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
				
			if($error) {	
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}
				return false;
			} else {		
				if($oTransaccion){		
					$this->InsMysql->MtdTransaccionHacer();		
				}
				$this->MtdAuditarPedidoCompra(1,"Se registro el Pedido de Compra",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarPedidoCompra() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblpcopedidocompra SET
			
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->OcoId)?'OcoId = NULL, ':'OcoId = "'.$this->OcoId.'",').'
			'.(empty($this->FccId)?'FccId = NULL, ':'FccId = "'.$this->FccId.'",').'
			
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			
			PcoFecha = "'.($this->PcoFecha).'",
			PcoHora = "'.($this->PcoHora).'",
			PcoTipoPedido = "'.($this->PcoTipoPedido).'",



			MonId = "'.($this->MonId).'",
			
			'.(empty($this->PcoTipoCambio)?'PcoTipoCambio = NULL, ':'PcoTipoCambio = '.$this->PcoTipoCambio.',').'
			
			PcoIncluyeImpuesto = '.($this->PcoIncluyeImpuesto).',
			PcoPorcentajeImpuestoVenta = '.($this->PcoPorcentajeImpuestoVenta).',	
			PcoObservacion = "'.($this->PcoObservacion).'",
			PcoObservacionImpresa = "'.($this->PcoObservacionImpresa).'",
			PcoObservacionCorreo = "'.($this->PcoObservacionCorreo).'",
			
			PcoOrigen = "'.($this->PcoOrigen).'",
			
			PcoSubTotal = '.($this->PcoSubTotal).',
			PcoImpuesto = '.($this->PcoImpuesto).',
			PcoTotal = '.($this->PcoTotal).',			
			PcoEstado = '.($this->PcoEstado).',
			PcoTiempoModificacion = "'.($this->PcoTiempoModificacion).'"
			WHERE PcoId = "'.($this->PcoId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			
			
			if(!$error){
				
				
				if(!empty( $this->OcoId)){

					$InsOrdenCompra = new ClsOrdenCompra();

					$InsOrdenCompra->OcoId = $this->OcoId;
					$InsOrdenCompra->MtdObtenerOrdenCompra();

					$Total = 0;

					if(!empty($InsOrdenCompra->OrdenCompraPedido)){
						
						foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
							$Total += $DatOrdenCompraPedido->PcoTotal;
						}
						
						$InsOrdenCompra->MtdEditarOrdenCompraDato("OcoTotal",$Total,$InsOrdenCompra->OcoId);
					}
					
				}
				 
			}

							
							
								

			if(!$error){
			
				if (!empty($this->PedidoCompraDetalle)){		
						
						
					$validar = 0;				
					$InsPedidoCompraDetalle = new ClsPedidoCompraDetalle();
							
					foreach ($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
										
						$InsPedidoCompraDetalle->PcdId = $DatPedidoCompraDetalle->PcdId;
						$InsPedidoCompraDetalle->PcoId = $this->PcoId;
						$InsPedidoCompraDetalle->ProId = $DatPedidoCompraDetalle->ProId;
						$InsPedidoCompraDetalle->UmeId = $DatPedidoCompraDetalle->UmeId;
						$InsPedidoCompraDetalle->VddId = $DatPedidoCompraDetalle->VddId;
						
						$InsPedidoCompraDetalle->PcdAno = $DatPedidoCompraDetalle->PcdAno;
						$InsPedidoCompraDetalle->PcdModelo = $DatPedidoCompraDetalle->PcdModelo;
						$InsPedidoCompraDetalle->PcdCodigo = $DatPedidoCompraDetalle->PcdCodigo;
						
						$InsPedidoCompraDetalle->PcdPrecio = $DatPedidoCompraDetalle->PcdPrecio;
						$InsPedidoCompraDetalle->PcdCantidad = $DatPedidoCompraDetalle->PcdCantidad;						
						$InsPedidoCompraDetalle->PcdImporte = $DatPedidoCompraDetalle->PcdImporte;
						$InsPedidoCompraDetalle->PcdObservacion = $DatPedidoCompraDetalle->PcdObservacion;
						
						$InsPedidoCompraDetalle->PcdEstado = $DatPedidoCompraDetalle->PcdEstado;
						$InsPedidoCompraDetalle->PcdTiempoCreacion = $DatPedidoCompraDetalle->PcdTiempoCreacion;
						$InsPedidoCompraDetalle->PcdTiempoModificacion = $DatPedidoCompraDetalle->PcdTiempoModificacion;
						$InsPedidoCompraDetalle->PcdEliminado = $DatPedidoCompraDetalle->PcdEliminado;
						
						if(empty($InsPedidoCompraDetalle->PcdId)){
							if($InsPedidoCompraDetalle->PcdEliminado<>2){
								if($InsPedidoCompraDetalle->MtdRegistrarPedidoCompraDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PCO_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsPedidoCompraDetalle->PcdEliminado==2){
								if($InsPedidoCompraDetalle->MtdEliminarPedidoCompraDetalle($InsPedidoCompraDetalle->PcdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PCO_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsPedidoCompraDetalle->MtdEditarPedidoCompraDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PCO_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->PedidoCompraDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarPedidoCompra(2,"Se edito el Pedido de Compra",$this);		
				return true;
			}	
				
		}	
		
		
		public function MtdEditarPedidoCompraOrdenCompra() {

			$error = false;

			$sql = 'UPDATE tblpcopedidocompra SET
			'.(empty($this->OcoId)?'OcoId = NULL, ':'OcoId = "'.$this->OcoId.'",').'
			PcoTiempoModificacion = "'.($this->PcoTiempoModificacion).'"
			WHERE PcoId = "'.($this->PcoId).'";';			

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
		
		
		public function MtdEditarPedidoCompraDato($oCampo,$oDato,$oPedidoCompraId) {

			$error = false;

			$sql = 'UPDATE tblpcopedidocompra SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			PcoTiempoModificacion = NOW()
			WHERE PcoId = "'.($oPedidoCompraId).'";';			

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
		
		public function FncGenerarOrdenCompraPedidoCompra($oPedidoCompra,$oTipo=NULL){
			
			$this->InsMysql->MtdTransaccionIniciar();
			
			$error = true;
			
			if(!empty($oPedidoCompra)){
				
				$this->PcoId = $oPedidoCompra;
				$this->MtdObtenerPedidoCompra();
				
					$InsOrdenCompra = new ClsOrdenCompra();
					$InsOrdenCompra->UsuId = NULL;	
					
					$InsOrdenCompra->OcoId = NULL;
					$InsOrdenCompra->OcoTipo = $oTipo;
					$InsOrdenCompra->OcoCodigoDealer = "8001200006";
					
					$InsProveedor = new ClsProveedor();
					$ResProveedor = $InsProveedor->MtdObtenerProveedores(NULL,NULL,NULL,'PrvNombre','ASC','1',NULL,"CYC");
					$ArrProveedores = $ResProveedor['Datos'];
					
					if(!empty($ArrProveedores)){
						foreach($ArrProveedores as $DatProveedor){
							$InsOrdenCompra->PrvId = $DatProveedor->PrvId;
						}
					}
				
					$InsTipoCambio = new ClsTipoCambio();
					$InsTipoCambio->MonId = "MON-10001";
					$InsTipoCambio->TcaFecha = date("Y-m-d");
					
					$InsTipoCambio->MtdObtenerTipoCambioActual();
					
					if(empty($InsTipoCambio->TcaId)){
						$InsTipoCambio->MtdObtenerTipoCambioUltimo();
					}
				
					$InsOrdenCompra->OcoTipoCambio = $InsTipoCambio->TcaMontoComercial;
					$InsOrdenCompra->MonId = "MON-10001";
					
					$InsOrdenCompra->OcoFecha = date("Y-m-d");
					
					if(empty($InsOrdenCompra->OcoFechaLlegadaEstimada)){
						
						switch($InsOrdenCompra->OcoTipo){
							
							case "YRUSH":
					
								$FechaEstimadaLlegada = strtotime ( '+2 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
								$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
								$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
					
							break;
							
							case "ZVOR":
							
								$FechaEstimadaLlegada = strtotime ( '+60 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
								$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
								$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
							
							break;
							
							case "STK":
								
								$FechaEstimadaLlegada = strtotime ( '+4 days' , strtotime ( $InsOrdenCompra->OcoFecha) ) ;
								$FechaEstimadaLlegada = date ('Y-m-d' , $FechaEstimadaLlegada );
								$InsOrdenCompra->OcoFechaLlegadaEstimada = $FechaEstimadaLlegada;
					
							break;
							
							default:
							
							break;
											
						}
						
					}
				
					list($InsOrdenCompra->OcoAno,$InsOrdenCompra->OcoMes,$Dia) = explode("-",$InsOrdenCompra->OcoFecha);
					
					$InsOrdenCompra->OcoIncluyeImpuesto = $this->PcoIncluyeImpuesto;
					$InsOrdenCompra->OcoPorcentajeImpuestoVenta = $this->PcoPorcentajeImpuestoVenta;
					
					$InsOrdenCompra->OcoHora = (date("H:i:s"));
					$InsOrdenCompra->OcoObservacion = "Pedido generado automaticamente por sistema el ".date("d/m/Y H:i:s");
					
					$InsOrdenCompra->OcoEstado = 3;
					$InsOrdenCompra->OcoTiempoCreacion = date("Y-m-d H:i:s");
					$InsOrdenCompra->OcoTiempoModificacion = date("Y-m-d H:i:s");
					$InsOrdenCompra->OcoEliminado = 1;
					
					
					$InsOrdenCompra->OrdenCompraDetalle = array();
					$InsOrdenCompra->OrdenCompraPedido = array();
					
					if($InsOrdenCompra->MonId<>$EmpresaMonedaId){
						if(empty($InsOrdenCompra->OcoTipoCambio)){
							$GuardarOrdenCompra = false;
						}
					}
					
					$InsOrdenCompra->OcoSubTotal = 0;
					$InsOrdenCompra->OcoImpuesto = 0;
					$InsOrdenCompra->OcoTotal = 0;
					
					$InsOrdenCompra->OcoTotalBruto = 0;
					
					
					$this->PcoSubTotal = 0;
					$this->PcoImpuesto = 0;
					$this->PcoTotal = 0;
					$this->PcoTotalBruto = 0;
					
					if(!empty($this->PedidoCompraDetalle)){
						foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
						
							$this->PcoTotalBruto += $DatPedidoCompraDetalle->PcdImporte;
							
						}
					}
					
					if($this->PcoIncluyeImpuesto==2){
						$this->PcoSubTotal = round($this->PcoTotalBruto,6);
						$this->PcoImpuesto = round(($this->PcoSubTotal * ($this->PcoPorcentajeImpuestoVenta/100)),6);
						$this->PcoTotal = round($this->PcoSubTotal + $this->PcoImpuesto,6);
					}else{
						$this->PcoTotal = round($this->PcoTotalBruto,6);	
						$this->PcoSubTotal = round($this->PcoTotal / (($this->PcoPorcentajeImpuestoVenta/100)+1),6);
						$this->PcoImpuesto = round(($this->PcoTotal - $this->PcoSubTotal),6);
					}
					
					$InsOrdenCompra->OcoSubTotal += $this->PcoSubTotal;
					$InsOrdenCompra->OcoImpuesto += $this->PcoImpuesto;
					$InsOrdenCompra->OcoTotal += $this->PcoTotal;
				
					$InsOrdenCompra->OrdenCompraPedido[] = $this;
					
					//if($GuardarOrdenCompra){
				
					if($InsOrdenCompra->MtdRegistrarOrdenCompra()){
						$error = false;
					}
	
					//}

			}
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}						
										
		}
	
		public function MtdGenerarExcelPedidoCompra($oPedidoCompra,$oRuta=NULL){
			
			global $EmpresaMonedaId;
			
			$Generado = true;
			
			if(!empty($oPedidoCompra)){

				$this->PcoId = $oPedidoCompra;
				$this->MtdObtenerPedidoCompra();
				
				if($this->OcoTipo=="ALM"){
					
					$objPHPExcel = new PHPExcel();
					
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($oRuta."plantilla/TemOrdenCompra.xls");
					
							$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("PHPExcel Test Document")
									 ->setSubject("PHPExcel Test Document")
									 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Test result file");

							// Miscellaneous glyphs, UTF-8
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F8', 'ORDEN DE COMPRA');
							$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true)->setSize(14);
														   
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F9', $this->OcoId);
							$objPHPExcel->getActiveSheet()->getStyle('F9')->getFont()->setBold(true)->setSize(14);		
							
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('C11', 'CÓDIGO SAP');
					//		$objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//		);
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//		);
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray(
					//		array(
					//			  'borders' => array(
					//									'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//									'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//								)
					//			 )
					//		);
					
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('C12', 'Codigo Dealer');
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('E12', '8001200006');
							$objPHPExcel->getActiveSheet()->getStyle('C13')->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C13', 'Fecha');
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('E13', $this->PcoFecha);
							
							
					//		$objPHPExcel->getActiveSheet()->getStyle('C12')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
					//			
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('D12')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('E12')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
					//			
					//			
					//			
					//			
					//			
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('C13')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('D13')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
					//			
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('E13')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
							
							
								
							
							
							
							$objPHPExcel->getActiveSheet()->getStyle("C12")->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle("D12")->getAlignment()->setWrapText(true);
							
							$objPHPExcel->getActiveSheet()->getStyle("C13")->getAlignment()->setWrapText(true);
							$objPHPExcel->getActiveSheet()->getStyle("D13")->getAlignment()->setWrapText(true);
							
							$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
							
							
							$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
							
							$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
							
							$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
							$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
							
							$objPHPExcel->getActiveSheet()->getStyle('C14')->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C14', 'Hora:');	
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('E14', $this->PcoHora);	
										
					
							$objPHPExcel->getActiveSheet()->getStyle('J11')->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('J11', 'Moneda:');	
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('K11', $this->MonNombre);	
										
															
									
									
						//	$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
					//			
					//			
					//		$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);
					//			
					//		
					//		$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray(
					//			array(
					//				  'borders' => array(
					//										'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
					//										'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
					//									)
					//				 )
					//			);	
					//						
											
											
							$objPHPExcel->getActiveSheet()->getStyle('G13')->getFont()->setBold(true);					
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G13', 'VIN');	
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('H13', $this->OcoVIN);						
													
							$objPHPExcel->getActiveSheet()->getStyle('G14')->getFont()->setBold(true);		
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G14', 'O.T.');	
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('H14', $this->OcoOrdenTrabajo);						
						
						
						
						
						
						
						
						
						
							$objPHPExcel->getActiveSheet()->getStyle('C17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('C17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('C17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								
													
													
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('D17', 'GM PN Replace');		
							$objPHPExcel->getActiveSheet()->getStyle('D17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('D17')->getFont()->setBold(true);	
							$objPHPExcel->getActiveSheet()->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								                             
								
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('E16', 'DEALER');
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('E17', 'Cantidad de Pedido');
							$objPHPExcel->getActiveSheet()->getStyle('E17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('E17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 							   
														  
															
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('F16', 'GM');
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('F17', 'Partes a Atender');
							$objPHPExcel->getActiveSheet()->getStyle('F17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('F17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
														   
																	
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('G16', 'GM');	
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('G17', 'B/O');
							$objPHPExcel->getActiveSheet()->getStyle('G17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							
							$objPHPExcel->getActiveSheet()->getStyle('G17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('G17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							
															
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('H16', 'GM');			
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('H17', 'Descripcion');
							$objPHPExcel->getActiveSheet()->getStyle('H17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('H17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('H17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
														   
														   
																		
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('I17', 'Año');
							$objPHPExcel->getActiveSheet()->getStyle('I17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('I17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('I17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
														   
																		
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('J17', 'Modelo');
							$objPHPExcel->getActiveSheet()->getStyle('J17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('J17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('J17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
														   
								
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('K16', 'GM');	
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('K17', 'Precio');
							$objPHPExcel->getActiveSheet()->getStyle('K17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
							$objPHPExcel->getActiveSheet()->getStyle('K17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('K17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   							   
														   
																		
							//$objPHPExcel->setActiveSheetIndex(0)
							//            ->setCellValue('L17', 'Total');
							$objPHPExcel->getActiveSheet()->getStyle('L17')->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);			
							$objPHPExcel->getActiveSheet()->getStyle('L17')->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->getStyle('L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							
							$objPHPExcel->getActiveSheet()->getStyle('C17:L17')->applyFromArray(
								array('fill' 	=> array(
															'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
															'color'		=> array('rgb' => '8DB4E3')
														)
															
									 )
								);
							
							
							$fila = 18;
							$indice = 1;
							
							$TotalBruto = 0;
							$SubTotal = 0;
							$Impuesto = 0;
							$Total = 0;
										
										
							if(!empty($this->PedidoCompraDetalle)){
								foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
									
									if($this->MonId<>$EmpresaMonedaId){
										$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $DatPedidoCompraDetalle->PcoTipoCambio,2);
										$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $DatPedidoCompraDetalle->PcoTipoCambio,2);
									}
									
									//C
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatPedidoCompraDetalle->PcdCodigo);
									$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//D
										
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
						
						
						
									//E
						
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatPedidoCompraDetalle->PcdCantidad);
									$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//F
									
									$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//G
									
									$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//H
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatPedidoCompraDetalle->ProNombre);
									$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//I
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatPedidoCompraDetalle->PcdAno);
									$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//J
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatPedidoCompraDetalle->PcdModelo);
									$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//K
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatPedidoCompraDetalle->PcdPrecio);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
										
									//L
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $DatPedidoCompraDetalle->PcdImporte);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
										
									$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
									
									$fila++;
									$indice++;
					
									
								}
								
							}
							
							
							if($this->PcoIncluyeImpuesto==2){
								$SubTotal = round($TotalBruto,6);
								$Impuesto = round(($SubTotal * ($this->PcoPorcentajeImpuestoVenta/100)),6);
								$Total = round($SubTotal + $Impuesto,6);
							}else{
								$Total = round($TotalBruto,6);	
								$SubTotal = round($Total / (($this->PcoPorcentajeImpuestoVenta/100)+1),6);
								$Impuesto = round(($Total - $SubTotal),6);
							}
										
										
							
							$objPHPExcel->getActiveSheet()->getStyle('C'.$fila.':K'.$fila)->applyFromArray(
							  array(
									'borders' => array(
														  'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
													  )
								   )
							  );
							$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
							  array('fill' 	=> array(
														  'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
														  'color'		=> array('rgb' => '8DB4E3')
													  )
														  
								   )
								   
							  );
							
							$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getFont()->setBold(true);	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, "Sub Total:");
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $this->MonSimbolo);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, number_format($SubTotal,2));
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
											array(
												  'borders' => array(
																		'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																		'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																		'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																		'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																	)
												 )
											);
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
											array('fill' 	=> array(
																		'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																		'color'		=> array('rgb' => '8DB4E3')
																	)
																		
												 )
											);
											
							$objPHPExcel->getActiveSheet()->getStyle('J'.($fila+1))->getFont()->setBold(true);	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($fila+1), "Impuesto:");
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($fila+1), $this->MonSimbolo);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($fila+1), number_format($Impuesto,2));
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+1))->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
								
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+1))->applyFromArray(
												array('fill' 	=> array(
																			'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																			'color'		=> array('rgb' => '8DB4E3')
																		)
																			
													 )
												);
											
							$objPHPExcel->getActiveSheet()->getStyle('J'.($fila+2))->getFont()->setBold(true);	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($fila+2), "Total:");
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($fila+2), $this->MonSimbolo);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($fila+2), number_format($Total,2));
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+2))->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
								
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+2))->applyFromArray(
												array('fill' 	=> array(
																			'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																			'color'		=> array('rgb' => '8DB4E3')
																		)
																			
													 )
							);

					//$this->MtdEditarOrdenCompraDato("OcoTotal",$TotalReal,$this->OcoId);
					//$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
					//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
					//$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
					// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle($this->OcoId);
					
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save($oRuta."generados/".$this->OcoId.".xls");
					
				}else{
					
					$objPHPExcel = new PHPExcel();
					
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($oRuta."plantilla/TemOrdenCompraGM.xls");
					
					// Set document properties
					$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
												 ->setLastModifiedBy("Maarten Balliauw")
												 ->setTitle("PHPExcel Test Document")
												 ->setSubject("PHPExcel Test Document")
												 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
												 ->setKeywords("office PHPExcel php")
												 ->setCategory("Test result file");

					// Miscellaneous glyphs, UTF-8
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F8', 'ORDEN DE COMPRA PERU - C&C');
					$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true)->setSize(14);
												   
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F9', $this->OcoId);
					$objPHPExcel->getActiveSheet()->getStyle('F9')->getFont()->setBold(true)->setSize(14);		
					
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C11', 'CÓDIGO SAP');
					$objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
						
						
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
								
								
								
								
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C12', 'Codigo Dealer');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E12', '8001200006');
					
					$objPHPExcel->getActiveSheet()->getStyle('C13')->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C13', 'Fecha:');
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E13', $this->OcoFecha);
					
					
					$objPHPExcel->getActiveSheet()->getStyle('C12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('E12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
						
						
						
						
					$objPHPExcel->getActiveSheet()->getStyle('C13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('D13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('E13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					
					
						
					
					
					
					$objPHPExcel->getActiveSheet()->getStyle("C12")->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle("D12")->getAlignment()->setWrapText(true);
					
					$objPHPExcel->getActiveSheet()->getStyle("C13")->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle("D13")->getAlignment()->setWrapText(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
					
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
					
					$objPHPExcel->getActiveSheet()->getStyle('C14')->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C14', 'Hora');	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E14', $this->OcoHora);						
							
							
					$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					
					$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);	
									
									
									
					$objPHPExcel->getActiveSheet()->getStyle('G13')->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G13', 'VIN:');	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('H13', $this->OcoVIN);						
					
					$objPHPExcel->getActiveSheet()->getStyle('G14')->getFont()->setBold(true);
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('G14', 'O.T.:');	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('H14', $this->OcoOrdenTrabajo);						
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
										
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('B17', '#');		
					
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C16', 'DEALER');					
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C17', 'GM Part Number');
					$objPHPExcel->getActiveSheet()->getStyle('C17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('C17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								
													
													
													
						
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('D17', 'GM PN Replace');		
					$objPHPExcel->getActiveSheet()->getStyle('D17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('D17')->getFont()->setBold(true);	
					$objPHPExcel->getActiveSheet()->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								                             
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E16', 'DEALER');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E17', 'Cantidad de Pedido');
					$objPHPExcel->getActiveSheet()->getStyle('E17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('E17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 							   
												  
													
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('F16', 'GM');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('F17', 'Partes a Atender');
					$objPHPExcel->getActiveSheet()->getStyle('F17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('F17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												   
															
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('G16', 'GM');	
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('G17', 'B/O');
					$objPHPExcel->getActiveSheet()->getStyle('G17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					
					$objPHPExcel->getActiveSheet()->getStyle('G17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('G17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
													
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('H16', 'GM');			
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('H17', 'Descripcion');
					$objPHPExcel->getActiveSheet()->getStyle('H17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('H17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('H17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('I17', 'Año');
					$objPHPExcel->getActiveSheet()->getStyle('I17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('I17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('I17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('J17', 'Modelo');
					$objPHPExcel->getActiveSheet()->getStyle('J17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('J17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('J17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
												   
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('K16', 'GM');	
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('K17', 'Precio');
					$objPHPExcel->getActiveSheet()->getStyle('K17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('K17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('K17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   							   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('L17', 'Total');
					$objPHPExcel->getActiveSheet()->getStyle('L17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);			
					$objPHPExcel->getActiveSheet()->getStyle('L17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					$objPHPExcel->getActiveSheet()->getStyle('C17:L17')->applyFromArray(
						array('fill' 	=> array(
													'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
													'color'		=> array('rgb' => '8DB4E3')
												)
													
							 )
						);
					
					
					
					
					$fila = 18;
					$indice = 1;
					
					
					$TotalBruto = 0;
					if(!empty($this->PedidoCompraDetalle)){
						foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
									if($this->MonId<>$EmpresaMonedaId){
										$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $DatPedidoCompraDetalle->PcoTipoCambio,2);
										$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $DatPedidoCompraDetalle->PcoTipoCambio,2);
									}
									
									//C
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatPedidoCompraDetalle->PcdCodigo);
									$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//D
										
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
						
						
						
									//E
						
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatPedidoCompraDetalle->PcdCantidad);
									$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//F
									
									$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//G
									
									$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//H
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatPedidoCompraDetalle->ProNombre);
									$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//I
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatPedidoCompraDetalle->PcdAno);
									$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//J
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatPedidoCompraDetalle->PcdModelo);
									$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//K
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatPedidoCompraDetalle->PcdPrecio);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
										
									//L
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $DatPedidoCompraDetalle->PcdImporte);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
									$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
									
									$fila++;
									$indice++;
								
						}
						
					}
					
					
					
							if($this->PcoIncluyeImpuesto==2){
								$SubTotal = round($TotalBruto,6);
								$Impuesto = round(($SubTotal * ($this->PcoPorcentajeImpuestoVenta/100)),6);
								$Total = round($SubTotal + $Impuesto,6);
							}else{
								$Total = round($TotalBruto,6);	
								$SubTotal = round($Total / (($this->PcoPorcentajeImpuestoVenta/100)+1),6);
								$Impuesto = round(($Total - $SubTotal),6);
							}
										
										
							
							$objPHPExcel->getActiveSheet()->getStyle('C'.$fila.':K'.$fila)->applyFromArray(
							  array(
									'borders' => array(
														  'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
													  )
								   )
							  );
							$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
							  array('fill' 	=> array(
														  'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
														  'color'		=> array('rgb' => '8DB4E3')
													  )
														  
								   )
								   
							  );
							
							$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getFont()->setBold(true);	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, "Sub Total:");
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $this->MonSimbolo);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, number_format($SubTotal,2));
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
											array(
												  'borders' => array(
																		'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																		'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																		'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																		'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																	)
												 )
											);
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
											array('fill' 	=> array(
																		'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																		'color'		=> array('rgb' => '8DB4E3')
																	)
																		
												 )
											);
											
							$objPHPExcel->getActiveSheet()->getStyle('J'.($fila+1))->getFont()->setBold(true);	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($fila+1), "Impuesto:");
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($fila+1), $this->MonSimbolo);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($fila+1), number_format($Impuesto,2));
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+1))->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
								
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+1))->applyFromArray(
												array('fill' 	=> array(
																			'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																			'color'		=> array('rgb' => '8DB4E3')
																		)
																			
													 )
												);
											
							$objPHPExcel->getActiveSheet()->getStyle('J'.($fila+2))->getFont()->setBold(true);	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($fila+2), "Total:");
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($fila+2), $this->MonSimbolo);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($fila+2), number_format($Total,2));
							
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+2))->applyFromArray(
								array(
									  'borders' => array(
															'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
															'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
														)
									 )
								);
								
							$objPHPExcel->getActiveSheet()->getStyle('L'.($fila+2))->applyFromArray(
												array('fill' 	=> array(
																			'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																			'color'		=> array('rgb' => '8DB4E3')
																		)
																			
													 )
							);
					
					//Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle($this->OcoId);
					
					//Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save($oRuta."generados/".$this->OcoId.".xls");
					
				}
				
			}else{
				
				$Generado = false;
					
			}

			return $Generado;
		
		}
		
		public function MtdEnviarCorreoPedidoCompra($oPedidoCompraId,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
			
			$Envio = false;
			
			$this->PcoId = $oPedidoCompraId;
			$this->MtdObtenerPedidoCompra();
			
			if($this->PcoEstado == 1){
			
				if($this->MtdActualizarEstadoPedidoCompra($this->PcoId,3)){
			
					if($this->MtdActualizarEstadoPedidoCompra($this->PcoId,31)){
			
					}
			
				}
			
			}else if($this->PcoEstado == 3){
				
				if($this->MtdActualizarEstadoPedidoCompra($this->PcoId,31)){
					
				}
					
			}
					
					
			//$mensaje = "";
//			$mensaje .= "<br>";
//			$mensaje .= "<b>Estimado Sr. Bernardo.-</b>";
//			$mensaje .= "<br><br>";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			$mensaje .= "Se envia pedido adjunto: <b>".$this->OcoTipo."</b>";
			
			$mensaje .= "<br><br>";
			$mensaje .= "Estare a la espera de su pronta respuesta.";
			$mensaje .= "<br><br>";
			//$mensaje .= "Saludos";
			
			if(!empty($oRemitente)){

				$mensaje .= "<br><br>";
				$mensaje .= "Atte.";
				
				$mensaje .= "<br><br>";
				$mensaje .= $oRemitente;
	
			}

			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";

			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');

			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,"SISTEMA CYC","PEDIDO: ".$this->OcoId,$mensaje,$oRuta."generados/",$this->OcoId.".xls");
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","iquezada@cyc.com.pe",$SistemaCorreoRemitente,"PEDIDO CYC-STK-2015-01-001 2",$Mensaje,"generados/","CYC-STK-2015-01-001.xls");
			
			$Envio = true;
			
			return $Envio;
		}
		
		
		
		public function MtdGenerarExcelPedidoCompraAutorizacion($oPedidoCompra,$oRuta=NULL){
			
			global $EmpresaMonedaId;
			
			$Generado = true;
			
			if(!empty($oPedidoCompra)){

				$this->PcoId = $oPedidoCompra;
				$this->MtdObtenerPedidoCompra();
			
				if($this->OcoTipo=="ALM"){
					
					$objPHPExcel = new PHPExcel();
					
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($oRuta."plantilla/TemPedidoCompraAutorizacionOtro.xls");
					
							$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("PHPExcel Test Document")
									 ->setSubject("PHPExcel Test Document")
									 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Test result file");

						
							// Miscellaneous glyphs, UTF-8
	//						$objPHPExcel->setActiveSheetIndex(0)
//										->setCellValue('D4', $this->PcoId);
//							$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true)->setSize(14);		
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C6', $this->PcoId);
							$objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C7', $this->PcoFecha);
							$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G7', $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('G7')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C8', $this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G8', $this->MonNombre);
							$objPHPExcel->getActiveSheet()->getStyle('G8')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C9', $this->PcoObservacionCorreo);
							$objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G6', $this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('G6')->getFont()->setBold(false)->setSize(12);
							
							
							$fila = 12;
							$indice = 1;
							
							$TotalBruto = 0;
							$SubTotal = 0;
							$Impuesto = 0;
							$Total = 0;
										
							if(!empty($this->PedidoCompraDetalle)){
								foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
									
									
									if($this->MonId<>$EmpresaMonedaId){
										$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $DatPedidoCompraDetalle->PcoTipoCambio,2);
										$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $DatPedidoCompraDetalle->PcoTipoCambio,2);
									}
									
									
										//B
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $DatPedidoCompraDetalle->PcdId);
										$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//C
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatPedidoCompraDetalle->ProCodigoOriginal);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//D
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila, $DatPedidoCompraDetalle->ProNombre);
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
																
										//E
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatPedidoCompraDetalle->UmeNombre);
										$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
										
										//F
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila, $DatPedidoCompraDetalle->ProPromedioAnual);
										$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
											
										//G
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila, $DatPedidoCompraDetalle->ProPromedioTrimestral);
										$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//H
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatPedidoCompraDetalle->PcdPrecio);
										$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//I
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatPedidoCompraDetalle->PcdCantidad);
										$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												
										//J
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatPedidoCompraDetalle->PcdImporte);
										$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//K
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatPedidoCompraDetalle->PcdObservacion);
										$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										
										
									$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
									
									$fila++;
									$indice++;
									
								}
								
							}
							
							
							if($this->PcoIncluyeImpuesto==2){
								$SubTotal = round($TotalBruto,6);
								$Impuesto = round(($SubTotal * ($this->PcoPorcentajeImpuestoVenta/100)),6);
								$Total = round($SubTotal + $Impuesto,6);
							}else{
								$Total = round($TotalBruto,6);	
								$SubTotal = round($Total / (($this->PcoPorcentajeImpuestoVenta/100)+1),6);
								$Impuesto = round(($Total - $SubTotal),6);
							}
										
										
										
										//SUB TOTAL
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('H'.($fila+2)), "SubTotal:");
										$objPHPExcel->getActiveSheet()->getStyle('H'.($fila+2))->applyFromArray(
										array(
											  'borders' => array(
											  						'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+2)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('I'.($fila+2)), number_format($SubTotal,2));
										$objPHPExcel->getActiveSheet()->getStyle('I'.($fila+2))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('I'.($fila+2)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										//IMPUESTO
																				
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('H'.($fila+3)), "Impuesto:");
										$objPHPExcel->getActiveSheet()->getStyle('H'.($fila+3))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+3)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('I'.($fila+3)), number_format($Impuesto,2));
										$objPHPExcel->getActiveSheet()->getStyle('I'.($fila+3))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('I'.($fila+3)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										//TOTAL
																				
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('H'.($fila+4)), "Total:");
										$objPHPExcel->getActiveSheet()->getStyle('H'.($fila+4))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+4)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('I'.($fila+4)), number_format($Total,2));
										$objPHPExcel->getActiveSheet()->getStyle('I'.($fila+4))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+4)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
						
						// Rename worksheet
						$objPHPExcel->getActiveSheet()->setTitle($this->PcoId);
						// Set active sheet index to the first sheet, so Excel opens this as the first sheet
						$objPHPExcel->setActiveSheetIndex(0);
					
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						$objWriter->save($oRuta."generados/pedido_compra/".$this->PcoId.".xls");
				
				
				}else{
					
					$objPHPExcel = new PHPExcel();
					
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($oRuta."plantilla/TemPedidoCompraAutorizacion.xls");
					
							$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("PHPExcel Test Document")
									 ->setSubject("PHPExcel Test Document")
									 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Test result file");

							// Miscellaneous glyphs, UTF-8
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D4', $this->PcoId);
							$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true)->setSize(14);		
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C6', $this->OcoId);
							$objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C7', $this->PcoFecha);
							$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G7', $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('G7')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C8', $this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G8', $this->MonNombre);
							$objPHPExcel->getActiveSheet()->getStyle('G8')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C9', $this->PcoObservacionImpresa);
							$objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(false)->setSize(12);
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G6', $this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('G6')->getFont()->setBold(false)->setSize(12);
							
							
							$fila = 12;
							$indice = 1;
							
							$TotalBruto = 0;
							$SubTotal = 0;
							$Impuesto = 0;
							$Total = 0;
										
										
							if(!empty($this->PedidoCompraDetalle)){
								foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
									
									if($this->MonId<>$EmpresaMonedaId){
										$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $DatPedidoCompraDetalle->PcoTipoCambio,2);
										$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $DatPedidoCompraDetalle->PcoTipoCambio,2);
									}
									
										//B
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $DatPedidoCompraDetalle->PcdId);
										$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//C
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatPedidoCompraDetalle->ProCodigoOriginal);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//D
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila, $DatPedidoCompraDetalle->ProNombre);
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
																
										//E
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatPedidoCompraDetalle->UmeNombre);
										$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										//F
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila, $DatPedidoCompraDetalle->ProPromedioAnual);
										$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
											
										//G
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila, $DatPedidoCompraDetalle->ProPromedioTrimestral);
										$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//H
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatPedidoCompraDetalle->PcdPrecio);
										$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//I
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatPedidoCompraDetalle->PcdCantidad);
										$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												
										//J
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatPedidoCompraDetalle->PcdImporte);
										$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//K
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, $DatPedidoCompraDetalle->PcdObservacion);
										$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										
										
									$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
									
									$fila++;
									$indice++;
					
									
								}
								
							}
							
							
							if($this->PcoIncluyeImpuesto==2){
								$SubTotal = round($TotalBruto,6);
								$Impuesto = round(($SubTotal * ($this->PcoPorcentajeImpuestoVenta/100)),6);
								$Total = round($SubTotal + $Impuesto,6);
							}else{
								$Total = round($TotalBruto,6);	
								$SubTotal = round($Total / (($this->PcoPorcentajeImpuestoVenta/100)+1),6);
								$Impuesto = round(($Total - $SubTotal),6);
							}
										
										
										
										//SUB TOTAL
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('H'.($fila+2)), "SubTotal:");
										$objPHPExcel->getActiveSheet()->getStyle('H'.($fila+2))->applyFromArray(
										array(
											  'borders' => array(
											  						'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+2)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('I'.($fila+2)), number_format($SubTotal,2));
										$objPHPExcel->getActiveSheet()->getStyle('I'.($fila+2))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('I'.($fila+2)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										//IMPUESTO
																				
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('H'.($fila+3)), "Impuesto:");
										$objPHPExcel->getActiveSheet()->getStyle('H'.($fila+3))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+3)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('I'.($fila+3)), number_format($Impuesto,2));
										$objPHPExcel->getActiveSheet()->getStyle('I'.($fila+3))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('I'.($fila+3)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										//TOTAL
																				
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('H'.($fila+4)), "Total:");
										$objPHPExcel->getActiveSheet()->getStyle('H'.($fila+4))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+4)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('I'.($fila+4)), number_format($Total,2));
										$objPHPExcel->getActiveSheet()->getStyle('I'.($fila+4))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('H'.($fila+4)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										

										
										
					//$this->MtdEditarOrdenCompraDato("OcoTotal",$TotalReal,$this->OcoId);
					//$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
					//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
					//$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
					// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle($this->PcoId);
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save($oRuta."generados/pedido_compra/".$this->PcoId.".xls");
				
					
				}
				
				
			}else{
				
				$Generado = false;
					
			}

			return $Generado;
		
		}
		
		
		
		public function MtdGenerarExcelPedidoCompraFormatoGM($oPedidoCompra,$oRuta=NULL,$oDescargar=false){
			
			global $EmpresaMonedaId;
			global $EmpresaCodigoDealer;
			
			$Generado = true;
			
			if(!empty($oPedidoCompra)){

				$this->PcoId = $oPedidoCompra;
				$this->MtdObtenerPedidoCompra();
			
					$objPHPExcel = new PHPExcel();
					
					//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($oRuta."plantilla/TemOrdenCompraGMv3.xls");
					
					$worksheet = $objPHPExcel->getSheet(0);
					
							$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("PHPExcel Test Document")
									 ->setSubject("PHPExcel Test Document")
									 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Test result file");

							// Miscellaneous glyphs, UTF-8
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('L8', $this->PcoId);
							$objPHPExcel->getActiveSheet()->getStyle('L9')->getFont()->setBold(true)->setSize(14);		
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('B5', $this->OcoId);
							$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true)->setSize(12);	
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C8', $this->PcoFecha);
							$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C9', $this->PcoHora);
							$objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C7', $EmpresaCodigoDealer);
							$objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C6', $this->PcoTipoPedido);
							$objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(false)->setSize(12);	
							
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('L9', $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('L9')->getFont()->setBold(false)->setSize(12);
							
							
							$fila = 12;
							$indice = 1;
							
							$TotalBruto = 0;
							$SubTotal = 0;
							$Impuesto = 0;
							$Total = 0;
										
										
							if(!empty($this->PedidoCompraDetalle)){
								foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
									
									if($this->MonId<>$EmpresaMonedaId){
										$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $DatPedidoCompraDetalle->PcoTipoCambio,2);
										$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $DatPedidoCompraDetalle->PcoTipoCambio,2);
									}
									
										
										
										//B
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $DatPedidoCompraDetalle->ProCodigoOriginal);
										$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//C
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatPedidoCompraDetalle->PcdCantidad);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												
										//F
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila, $DatPedidoCompraDetalle->ProNombre);
										$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
																
										//G
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila, $DatPedidoCompraDetalle->PcdAno);
										$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
										//H
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatPedidoCompraDetalle->PcdModelo);
										$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//I
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatPedidoCompraDetalle->PcdPrecio);
										$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//J
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatPedidoCompraDetalle->PcdImporte);
										$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
											
										//K
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, (empty($DatPedidoCompraDetalle->PcdVIN)?$DatPedidoCompraDetalle->EinVIN:$DatPedidoCompraDetalle->PcdVIN));
										$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//L
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, (empty($DatPedidoCompraDetalle->PcdPlaca)?$DatPedidoCompraDetalle->EinPlaca:$DatPedidoCompraDetalle->PcdPlaca));
										$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//M
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila, (empty($DatPedidoCompraDetalle->PcdOT)?$DatPedidoCompraDetalle->FinId:$DatPedidoCompraDetalle->PcdOT));
										$objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('M'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										
									$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
									
									$fila++;
									$indice++;
					
									
								}
								
							}
							
							
							if($this->PcoIncluyeImpuesto==2){
								$SubTotal = round($TotalBruto,6);
								$Impuesto = round(($SubTotal * ($this->PcoPorcentajeImpuestoVenta/100)),6);
								$Total = round($SubTotal + $Impuesto,6);
							}else{
								$Total = round($TotalBruto,6);	
								$SubTotal = round($Total / (($this->PcoPorcentajeImpuestoVenta/100)+1),6);
								$Impuesto = round(($Total - $SubTotal),6);
							}
										
										
										//TOTAL
																				
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('I'.($fila+4)), "Total:");
										$objPHPExcel->getActiveSheet()->getStyle('I'.($fila+4))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )

																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('I'.($fila+4)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue(('J'.($fila+4)), number_format($Total,2));
										$objPHPExcel->getActiveSheet()->getStyle('J'.($fila+4))->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle(('J'.($fila+4)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
										
										

										
										
					//$this->MtdEditarOrdenCompraDato("OcoTotal",$TotalReal,$this->OcoId);
					//$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
					//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
					//$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
					// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle($this->PcoId);
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					
					if($oDescargar){
						$objWriter->save('php://output');	
					}else{
						$objWriter->save($oRuta."generados/pedido_compra/".$this->PcoId.".xls");					
					}
					
				
			}else{
				
				$Generado = false;
					
			}

			return $Generado;
		
		}
		
		
		public function MtdEnviarCorreoConsultaETAPedidoCompra($oOrdenCompra,$oDestinatario,$oRemitente){
			
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$Envio = false;
			
			$this->PcoId = $oOrdenCompra;
			$this->MtdObtenerPedidoCompra();
			
			$mensaje = "";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<b>Estimados Señores.-</b>";
			$mensaje .= "<br><br>";
			
			$mensaje .= "Se solicita nos informen el estado de la siguiente orden de compra <b>".$this->OcoId."</b> con fecha <b>".$this->OcoFecha."</b>";
			$mensaje .= "<br>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
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
						
					$mensaje .= "</tr>";

					$i = 1;
					if(!empty($this->PedidoCompraDetalle)){
						foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
							$mensaje .= "<tr>";
								
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
							
							$mensaje .= "</tr>";
							$i++;							
						}
					}
					
					$mensaje .= "</table>";
					


			
			
			
			
			$mensaje .= "<br><br>";
			$mensaje .= "Estare a la espera de su pronta respuesta.";
			$mensaje .= "<br><br>";
			//$mensaje .= "Saludos";
			
			if(!empty($oRemitente)){

				$mensaje .= "<br><br>";
				$mensaje .= "Atte.";
				
				$mensaje .= "<br><br>";
				$mensaje .= $oRemitente;
	
			}

			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";

			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');

			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,"SISTEMA CYC","ETA: ".$this->OcoId,$mensaje,NULL,NULL);
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","iquezada@cyc.com.pe",$SistemaCorreoRemitente,"PEDIDO CYC-STK-2015-01-001 2",$Mensaje,"generados/","CYC-STK-2015-01-001.xls");
			
			$Envio = true;
			
			return $Envio;
			
		}

		public function MtdEnviarCorreoSolicitarAutorizacionPedidoCompraFormatoGM($oOrdenCompra,$oDestinatario,$CorRemitenteNombre,$oAdjunto=array()){

			//echo "MtdEnviarCorreoSolicitarAutorizacionPedidoCompra";
			//echo "<br>";

		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		global $SistemaCorreoRemitente;
		
		$mensaje = "";
		
	//	$mensaje .= "<html>";
//		$mensaje .= "<head>";
//		$mensaje .= "</head>";
//		
//		$mensaje .= "<body>";
		
		
			$Envio = false;
			
			global $EmpresaMonedaId;
			
			$this->PcoId = $oOrdenCompra;
			$this->MtdObtenerPedidoCompra();
		
				
				
				if(date("A") == "PM"){
					$mensaje .= "Buenas tardes";
				}else{
					$mensaje .= "Buenos dias";
				}
				//
				$mensaje .= "<br>";
				$mensaje .= "<br>";
	//			$mensaje .= "<b>Estimados Señores.-</b>";
	//			$mensaje .= "<br><br>";
				
				$mensaje .= "Se solicita autorizacion de la orden de compra <b>".$this->PcoId."</b> (".$this->OcoId.")";
				$mensaje .= "<br>";
				
				if(!empty($this->OcoId)){
					
					$mensaje .= "<br>";
					$mensaje .= "<b>Num. Orden:</b> ".$this->OcoId;
					
				}
				
				if(!empty($this->PrvNombre)){
				
					$mensaje .= "<br>";
					$mensaje .= "<b>Proveedor:</b> ".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno;
					
				}
				
				
				$mensaje .= "<br>";
				//$mensaje .= "<b>Fecha:</b> ".$this->PcoFecha;
					$mensaje .= "<b>Fecha:</b><span title='".$this->PcoFecha."'> ".date("d/m/Y")."</span>";
				
				if(!empty($this->CliNombre)){
				
					$mensaje .= "<br>";
					$mensaje .= "<b>Cliente:</b> ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
					
				}
				
				
				if(!empty($this->EinVIN)){
				
					$mensaje .= "<br>";
					$mensaje .= "<b>VIN:</b> ".$this->EinVIN;
					
				}
				
					
				if(!empty($InsPedidoCompra->PcoTipoPedido)){
				
					$mensaje .= "<br>";
					$mensaje .= "<b>Tipo de Pedido:</b> ".$InsPedidoCompra->PcoTipoPedido;
					
				}
				
				
				$mensaje .= "<br>";
				$mensaje .= "<b>Solicitante:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno;
				$mensaje .= "<br>";
				
				if(!empty($this->PcoObservacionCorreo)){
					
					$mensaje .= "<br>";
					$mensaje .= "".$this->PcoObservacionCorreo;
					$mensaje .= "<br>";
					
				}
				
				
				$mensaje .= "<br>";
				$mensaje .= "<br>";
				
						$mensaje .= "<table border='1' cellpadding='4' cellspacing='0' width='100%'>";
						
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
							$mensaje .= "Ref.";
							$mensaje .= "</td>";
							
								$mensaje .= "<td>";
							$mensaje .= "Costo";
							$mensaje .= "</td>";
							
							
							$mensaje .= "<td>";
							$mensaje .= "Cantidad";
							$mensaje .= "</td>";
							
								$mensaje .= "<td>";
							$mensaje .= "Costo Total";
							$mensaje .= "</td>";
							
							
							$mensaje .= "<td>";
							$mensaje .= "Dias Imov.";
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= "Ventas Ult. 3m";
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= "Ventas Ult. 6m";
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= "Obs.";
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= "Disponibilidad";
							$mensaje .= "</td>";
							
							$mensaje .= "<td>";
							$mensaje .= "Reemplazos";
							$mensaje .= "</td>";
							
							
							
						$mensaje .= "</tr>";
	
						$i = 1;
						$TotalBruto = 0;
						
						$ArrProductosReemplazos = array();
	
						if(!empty($this->PedidoCompraDetalle)){
							foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
								
								if($this->MonId<>$EmpresaMonedaId){
									$DatPedidoCompraDetalle->PcdImporte = round($DatPedidoCompraDetalle->PcdImporte / $DatPedidoCompraDetalle->PcoTipoCambio,2);
									$DatPedidoCompraDetalle->PcdPrecio = round($DatPedidoCompraDetalle->PcdPrecio  / $DatPedidoCompraDetalle->PcoTipoCambio,2);
								}
										
										
								$mensaje .= "<tr>";
									
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
									$mensaje .= $DatPedidoCompraDetalle->ProReferencia;
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= number_format($DatPedidoCompraDetalle->PcdPrecio,2);
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= number_format($DatPedidoCompraDetalle->PcdImporte,2);
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= number_format($DatPedidoCompraDetalle->ProDiasInmovilizado,2);
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= number_format($DatPedidoCompraDetalle->ProSalidaTotalTrimestral,2);
									$mensaje .= "</td>";
								
									$mensaje .= "<td>";
									$mensaje .= number_format($DatPedidoCompraDetalle->ProSalidaTotalSemestral,2);
									$mensaje .= "</td>";
									
									$mensaje .= "<td>";
									$mensaje .= $DatPedidoCompraDetalle->PcdObservacion;
									$mensaje .= "</td>";
									
									
									
									$Disponibilidad = "";
									
									$InsProductoDisponibilidad = new ClsProductoDisponibilidad();
									$ResProductoDisponibilidad = $InsProductoDisponibilidad->MtdObtenerProductoDisponibilidades("PdiCodigo","esigual",$DatPedidoCompraDetalle->ProCodigoOriginal ,"PdiTiempoCreacion","DESC","1",1);
									$ArrProductoDisponibilidades = $ResProductoDisponibilidad['Datos'];
									
									//$Disponibilidad = "";
									$Disponibilidad = "NO";
									$Cantidad = 0;
									
									if(!empty($ArrProductoDisponibilidades)){
										foreach($ArrProductoDisponibilidades as $DatProductoDisponibilidad){
											
											$Disponibilidad =  ($DatProductoDisponibilidad->PdiDisponible==1)?'SI':'NO';
											$Cantidad =  ($DatProductoDisponibilidad->PdiCantidad);
										
										}
									}


									$mensaje .= "<td>";
									$mensaje .= $Disponibilidad ;
									$mensaje .= "</td>";


									$InsProductoReemplazo = new ClsProductoReemplazo();			
									$ResProductoReemplazo = $InsProductoReemplazo->MtdObtenerProductoReemplazos("PreCodigo1,PreCodigo2,PreCodigo3,PreCodigo4,PreCodigo5,PreCodigo6,PreCodigo7,PreCodigo8,PreCodigo9,PreCodigo10","esigual",$DatPedidoCompraDetalle->ProCodigoOriginal,"PreId","ASC",NULL,1);
									$ArrProductoReemplazos = $ResProductoReemplazo['Datos'];
									
									$reemplazos = "";
									
									if(!empty($ArrProductoReemplazos)){
										foreach($ArrProductoReemplazos as $DatProductoReemplazo){
													
													if(!empty($DatProductoReemplazo->PreCodigo1)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo1;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo2)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo2;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo3)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo3;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo4)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo4;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo5)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo5;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo6)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo6;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo7)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo7;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo8)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo8;	
													}
													
													if(!empty($DatProductoReemplazo->PreCodigo9)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo9;	
													}
													
													
													if(!empty($DatProductoReemplazo->PreCodigo10)){
														$reemplazos.=",".$DatProductoReemplazo->PreCodigo10;	
													}
													
													
													
											}
										}
										
									$lista_reemplazos = "";
									
									
									if(!empty($reemplazos)){
										
										$InsProducto = new ClsProducto();
										$ResProducto = $InsProducto->MtdObtenerProductos("ProCodigoOriginal","esigual",$reemplazos,"ProCodigoOriginal","ASC","10",NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL,false,NULL,NULL);
										$ArrProductos = $ResProducto['Datos'];
	
										$lista_reemplazos = "";
										
										if(!empty($ArrProductos)){
											
											foreach($ArrProductos as $DatProducto){
												
												if($DatProducto->ProCodigoOriginal<>$DatPedidoCompraDetalle->ProCodigoOriginal){
													
													$lista_reemplazos .= "- <b>".$DatProducto->ProCodigoOriginal."</b> | <i>Dias Imov.: </i> ".number_format($DatProducto->ProDiasInmovilizado,2)." | <i>Ventas Ult. 3m: </i> ".number_format($DatProducto->ProSalidaTotalTrimestral,2)." | <i>Ventas Ult. 6m: </i>".number_format($DatProducto->ProSalidaTotalSemestral,2);
													$lista_reemplazos .= "<br>";
													
												}
												
											
												//$lista_reemplazos .= "<a href='#".$DatProducto->ProId."'>".$DatProducto->ProCodigoOriginal."</a> , ";
	//											$ArrProductosReemplazos[] = $DatProducto->ProId;
	
											}
										
										}
									
	
									}else{
										$lista_reemplazos = "No tiene reemplazos";
									}
	
									$mensaje .= "<td>";
									$mensaje .= $lista_reemplazos ;
									$mensaje .= "</td>";
									
									
								
								$mensaje .= "</tr>";
								
								$TotalBruto += $DatPedidoCompraDetalle->PcdImporte;
								
								$i++;							
							}
						}
						
						$mensaje .= "</table>";
						
						/*<a id="example"></a>*/
					
				$mensaje .= "<br>";
				$mensaje .= "<br>";
				
				//if(!empty($ArrProductosReemplazos)){
	//				
	//				$mensaje .= "DETALLE DE REEMPLAZOS";
	//				$mensaje .= "<br>";
	//				$mensaje .= "<br>";
	//				
	//				foreach($ArrProductosReemplazos as $DatProductoReemplazo){
	//					
	//					$InsProducto = new ClsProducto();
	//					$InsProducto->ProId = $DatProductoReemplazo;
	//					$InsProducto->MtdObtenerProducto(FALSE);
	//					
	//					$mensaje .= "<a id='".$DatProductoReemplazo."'></a>";
	//					$mensaje .= $InsProducto->ProCodigoOriginal." - ".$InsProducto->ProNombre;
	//					$mensaje .= "<br>";
	//					
	//				}
	//			}
	
				//if($this->PcoIncluyeImpuesto == 2){
//					
//					$SubTotal = $TotalBruto;
//					$Impuesto = $SubTotal * ($this->PcoPorcentajeImpuestoVenta/100);	
//					$Total = $SubTotal + $Impuesto;
//					
//				}else{
//					
//					$Total = $TotalBruto;
//					$SubTotal = $Total / (($this->PcoPorcentajeImpuestoVenta/100)+1);
//					$Impuesto = $Total - $SubTotal;	
//				
//				}

				$Total = $TotalBruto;
				
				$mensaje .= "<br>";
				$mensaje .= "<br>";
				//
				$mensaje .= "Total:";
				$mensaje .= number_format($Total,2);				
				$mensaje .= "<br>";
				$mensaje .= "<br>";
				$mensaje .= "<br>";
				
				
				
				//$mensaje .= "Sub Total:";
//				$mensaje .= number_format($SubTotal,2);
//				$mensaje .= "<br>";
//				
//				$mensaje .= "Impuesto:";
//				$mensaje .= number_format($Impuesto,2);
//				$mensaje .= "<br>";
				

				
				
				$mensaje .= "<br>";
				$mensaje .= "<br>";
				
				$mensaje .= "Estare a la espera de su pronta respuesta.";
				$mensaje .= "<br><br>";
				//$mensaje .= "Saludos";
				
				if(!empty($oRemitente)){
	
					$mensaje .= "<br><br>";
					$mensaje .= "Atte.";
					
					$mensaje .= "<br><br>";
					$mensaje .= $oRemitente;
		
				}
	
				$mensaje .= "<br>";
				$mensaje .= "<br>";
				$mensaje .= "Gracias";
				$mensaje .= "<br>";
				$mensaje .= "<br>";
	
				$mensaje .= "Resumen: ";
				$mensaje .= "<br>";
				if(!empty($this->PedidoCompraDetalle)){
					foreach($this->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
						$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal." ".$DatPedidoCompraDetalle->ProNombre;
						$mensaje .= "<br>";		
						
					}
				}
				
				$mensaje .= "<br>";
				$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
				
				
				//deb($oAdjunto);
				$InsCorreo = new ClsCorreo();	
				//MMtdEnviarCorreo($CorDestinatario,$CorRemitenteCorreo,$CorRemitenteNombre,$CorAsunto,$CorContenido,$oCorRutaAdjunto=NULL,$oCorAdjunto=NULL)
				//$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"SOLICITUD DE AUTORIZACION: ".$this->PcoId." (".$this->OcoId.")",$mensaje,"","");
				
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario, $SistemaCorreoRemitente,"SOLICITUD DE AUTORIZACION: ".$this->PcoId." (".$this->OcoId.")",$mensaje,"",$oAdjunto);
				
				$Envio = true;
				
			
			
			return $Envio;
			
		}


		//public function MtdEditarPedidoCompraDato($oCampo,$oDato,$oId) {
//
//			$sql = 'UPDATE tblpcopedidocompra SET 
//			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
//			PcoTiempoModificacion = NOW()
//			WHERE PcoId = "'.($oId).'";';
//			
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 	
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}						
//				
//		}

	
		private function MtdAuditarPedidoCompra($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->PcoId;

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
}
?>