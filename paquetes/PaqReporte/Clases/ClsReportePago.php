<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReportePago
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReportePago {

   

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
		 
 
    public function MtdObtenerPagoComprobantes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPago=NULL,$oVentaDirecta=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0,$oNoTieneComprobante=false,$oNoTieneComprobanteEstricto=false) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
			
			
			if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (pag.PagEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		
		
		
		if(!empty($oVentaDirecta)){
			
			$vdirecta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.PagId = pag.PagId
				AND pac.VdIId = "'.$oVentaDirecta.'"
			
			)
			';
		}
		
	if(!empty($oPago)){
			$ocobro = ' AND pac.PagId = "'.$oPago.'"';
		}
		
		
	
			
		if(!empty($oMoneda)){
			$moneda = ' AND pag.MonId = "'.$oMoneda.'"';
		}	
		
	
		if(!empty($oFactura) and !empty($oFacturaTalonario)){
			
			$factura = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.PagId = pag.PagId
				AND pac.FacId = "'.$oFactura.'"
				AND pac.FtaId = "'.$oFacturaTalonario.'"
			
			)
			';
		}	
		
		if(!empty($oBoleta) and !empty($oBoletaTalonario)){
			
			$boleta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.PagId = pag.PagId
				AND pac.BolId = "'.$oBoleta.'"
				AND pac.BtaId = "'.$oBoletaTalonario.'"			
			)
			';

		}	
		
			
		if(!empty($oArea)){
			$area = ' AND pag.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pag.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(pag.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(pag.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pag.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oOrigen)){
			
			switch($oOrigen){
				
				case "REPUESTOS":
					
					$origen = ' AND EXISTS(					
					SELECT
					pac.VdiId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.VdiId IS NOT NULL
					ORDER BY pac.VdiId DESC
					LIMIT 1					
					)';
					
				break;
				
				case "VEHICULOS":
				
					$origen = ' AND EXISTS(
						SELECT
						pac.OvvId
						FROM tblpacpagocomprobante pac
						WHERE pac.PagId = pag.PagId
						AND pac.OvvId IS NOT NULL
						ORDER BY pac.OvvId DESC
						LIMIT 1
					) ';
					
				break;
				
				default:
				
				break;
				
			}
			
		}	
		
		
		if(!empty($oFormaPago)){
			$fpago = ' AND pag.FpaId = "'.$oFormaPago.'"';
		}		


		if(!empty($oSucursal)){
			$sucursal = ' AND pag.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oFichaIngresoId)){

			//$personal = ' AND pag.SucId = "'.$oSucursal.'"';
			
			$fingreso = ' AND 
			
					EXISTS(SELECT
					pac.VdiId
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblvdiventadirecta vdi
						ON pac.VdiId = vdi.VdiId
							LEFT JOIN tblfinfichaingreso fin
							ON vdi.FinId = fin.FinId
					WHERE pac.PagId = pag.PagId
						AND pac.VdiId IS NOT NULL
						AND vdi.FinId = "'.$oFichaIngresoId.'"
					ORDER BY pac.VdiId DESC
					LIMIT 1					
					)';
					
			
		}		
		
		if(!empty($oPersonalId)){

			//$personal = ' AND pag.SucId = "'.$oSucursal.'"';
			
			$personal = ' AND 
			
					EXISTS(SELECT
					pac.VdiId
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblvdiventadirecta vdi
						ON pac.VdiId = vdi.VdiId
							LEFT JOIN tblfinfichaingreso fin
							ON vdi.FinId = fin.FinId
					WHERE pac.PagId = pag.PagId
						AND pac.VdiId IS NOT NULL
						AND fin.PerId = "'.$oPersonalId.'"
					ORDER BY pac.VdiId DESC
					LIMIT 1					
					)';
					
			
		}		

		if(!empty($oTipo)){
			$tipo = ' AND pag.PagTipo = "'.$oTipo.'"';
		}
		
		if(!empty($oFacturado)){
			switch($oFacturado){
				case 1:
					$facturado = '
					
					AND 
					
					(
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblfacfactura fac
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
									LEFT JOIN tblamoalmacenmovimiento amo
									ON fam.AmoId = amo.AmoId
										LEFT JOIN tblvdiventadirecta vdi
										ON amo.VdiId = vdi.VdiId
											LEFT JOIN tblpacpagocomprobante pac
											ON pac.VdiId = vdi.VdiId	
							WHERE pac.PagId = pag.PagId
							AND fac.FacEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
						AND
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblbolboleta bol
								LEFT JOIN tblbamboletaalmacenmovimiento bam
								ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
									LEFT JOIN tblamoalmacenmovimiento amo
									ON bam.AmoId = amo.AmoId
										LEFT JOIN tblvdiventadirecta vdi
										ON amo.VdiId = vdi.VdiId
											LEFT JOIN tblpacpagocomprobante pac
											ON pac.VdiId = vdi.VdiId	
							WHERE pac.PagId = pag.PagId
							AND bol.BolEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
												
					)';
					
				break;
				
				case 2:
				
				break;
			}
		}else{
			
		}
		
		
		if(($oNoTieneComprobante)){

			//$personal = ' AND pag.SucId = "'.$oSucursal.'"';
			if($oNoTieneComprobanteEstricto){
				
				
			$tcomprobante = '
					
					AND 
					
					(
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblfacfactura fac
							WHERE fac.PagId = pag.PagId
							AND fac.FacEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
						AND
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblbolboleta bol							
							WHERE bol.PagId = pag.PagId
							AND bol.BolEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
												
					)';
					
			}else{
				
				
			$tcomprobante = '
					
					AND 
					
					(
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblfacfactura fac
							WHERE fac.PagId = pag.PagId
							AND fac.FacEstado <> 6
	
						) 
						
						AND
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblbolboleta bol							
							WHERE bol.PagId = pag.PagId
							AND bol.BolEstado <> 6
	
							
						) 
						
												
					)';
			}
			
			
					
			
		}		
		
		
		
		
		
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pac.PacId,
				pac.PagId,
				pac.OvvId,
				pac.VdiId,
				
				pac.FacId,
				pac.FtaId,
				
				pac.BolId,
				pac.BtaId,
				
				pac.FexId,
				pac.FetId,
				
				pac.PacEstado,
				DATE_FORMAT(pac.PacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPacTiempoCreacion",
				DATE_FORMAT(pac.PacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPacTiempoModificacion",
				
				
				IFNULL(cli.CliNumeroDocumento,IFNULL(cli2.CliNumeroDocumento,IFNULL(cli3.CliNumeroDocumento,IFNULL(cli4.CliNumeroDocumento,"")))) AS CliNumeroDocumento,
				
				
				IFNULL(cli.CliNombre,IFNULL(cli2.CliNombre,IFNULL(cli3.CliNombre,IFNULL(cli4.CliNombre,"")))) AS CliNombre,
				IFNULL(cli.CliApellidoMaterno,IFNULL(cli2.CliApellidoMaterno,IFNULL(cli3.CliApellidoMaterno,IFNULL(cli4.CliApellidoMaterno,"")))) AS CliApellidoMaterno,
				IFNULL(cli.CliApellidoPaterno,IFNULL(cli2.CliApellidoPaterno,IFNULL(cli3.CliApellidoPaterno,IFNULL(cli4.CliApellidoPaterno,"")))) AS CliApellidoPaterno,
				
				
				pag.PagMonto,
				pag.MonId,
				pag.PagTipoCambio,
				
				
				fac.FacTotal,
				fac.FacTipoCambio,
				fac.MonId AS MonIdFactura,
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
				
				fac.FacCantidadDia,
				
				DATE_FORMAT(fac.FacFechaVencimiento, "%d/%m/%Y") AS "NFacFechaVencimiento",
				DATEDIFF(DATE(NOW()),fac.FacFechaEmision) AS FacDiaTranscurrido,
				fta.FtaNumero,
				
				
				bol.BolTotal,
				bol.BolTipoCambio,
				bol.MonId AS MonIdBoleta,
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				
				bol.BolCantidadDia,
				
				DATE_FORMAT(bol.BolFechaVencimiento, "%d/%m/%Y") AS "NBolFechaVencimiento",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				bta.BtaNumero,
				
				IFNULL(suc.SucNombre,IFNULL(suc2.SucNombre,"")) AS SucNombre,
				
				
				
				IFNULL(
				
				amo.VdiId,
				
					IFNULL(vdi2.VdiId,
					
						IFNULL((
						SELECT
						pac.VdiId
						FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						WHERE pag.PagEstado<>6
						AND fac.PagId = pag.PagId
						LIMIT 1
						),IFNULL(
						
						
						(
						SELECT
						pac.VdiId
						FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						WHERE pag.PagEstado<>6
						AND bol.PagId = pag.PagId
						LIMIT 1
						)
						
						,""))
					)
				
				) AS  VdiId,
				
				
				
				
				
					(
					SELECT 
					CONCAT(fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = pac.OvvId 
					AND fac.FacEstado <> 6

								AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					
					
					
					LIMIT 1
				)  AS FacIdOrdenVentaVehiculo,
				
				(
					SELECT 
					CONCAT(fac.FtaId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = pac.OvvId 
					AND fac.FacEstado <> 6 
					
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS FtaIdOrdenVentaVehiculo,
		
			
			
			
			
				(
					SELECT 
					(fac.FacTotal/IFNULL(fac.FacTipoCambio,1))
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = pac.OvvId 
					AND fac.FacEstado <> 6

								AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					
					
					
					LIMIT 1
				)  AS FacTotalRealOrdenVentaVehiculo,
				
				
				
				
				
				
								
				(
					SELECT 
					CONCAT(bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = pac.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS BolIdOrdenVentaVehiculo,	
				
				(
					SELECT 
					CONCAT(bol.BtaId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = pac.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS BtaIdOrdenVentaVehiculo,
				
				
				
				(
					SELECT 
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1))
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = pac.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS BolTotalRealOrdenVentaVehiculo,	
				
				
				
				
				
				ovv.MonId AS MonIdOrdenVentaVehiculo		
				
				
				
				
				FROM tblpacpagocomprobante pac
				
					LEFT JOIN tblpagpago pag
					ON pac.PagId = pag.PagId
					
					LEFT JOIN tblfacfactura fac
					ON pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
							
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
							
							LEFT JOIN tblbolboleta bol
							ON pac.BolId = bol.BolId AND pac.BtaId = bol.BtaId
							
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
									
								LEFT JOIN tblvdiventadirecta vdi
								ON pac.VdiId = vdi.VdiId
									
									LEFT JOIN tblovvordenventavehiculo ovv
									ON pac.OvvId = ovv.OvvId
						
						
				LEFT JOIN tblclicliente cli
				ON fac.CliId = cli.CliId
					
					LEFT JOIN tblclicliente cli2
					ON bol.CliId = cli2.CliId
					
						LEFT JOIN tblclicliente cli3
						ON vdi.CliId = cli3.CliId
							
							LEFT JOIN tblclicliente cli4
							ON ovv.CliId = cli4.CliId


					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
									
						LEFT JOIN tblsucsucursal suc2
						ON bol.SucId = suc2.SucId
									
									
									
							LEFT JOIN tblamoalmacenmovimiento amo
							ON (bol.AmoId = amo.AmoId OR fac.AmoId = amo.AmoId)
										
								LEFT JOIN tblfccfichaaccion fcc
								ON amo.FccId = fcc.FccId
								
									LEFT JOIN tblfimfichaingresomodalidad fim
									ON fcc.FimId = fim.FimId
									
											LEFT JOIN tblfinfichaingreso fin
											ON fim.FinId = fin.FinId
											
												LEFT JOIN tblvdiventadirecta vdi2
												ON vdi2.FinId = fin.FinId			
					
				WHERE  1 = 1 '.$filtrar.$tipo.$estado.$tipo.$facturado.$tcomprobante .$sucursal.$fingreso.$personal.$vdirecta.$ovvehiculo.$cpago.$moneda.$factura.$boleta.$area.$fecha.$origen.$fpago.$ocobro.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPagoComprobante = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$PagoComprobante = new $InsPagoComprobante();
                    $PagoComprobante->PacId = $fila['PacId'];
                    $PagoComprobante->PagId = $fila['PagId'];
					$PagoComprobante->OvvId = $fila['OvvId'];
					$PagoComprobante->VdiId = $fila['VdiId'];
					
					$PagoComprobante->FacId = $fila['FacId'];
					$PagoComprobante->FtaId = $fila['FtaId'];
					
					$PagoComprobante->BolId = $fila['BolId'];
					$PagoComprobante->BtaId = $fila['BtaId'];
					
					$PagoComprobante->FexId = $fila['FexId'];
					$PagoComprobante->FetId = $fila['FetId'];

					$PagoComprobante->PacEstado = $fila['PacEstado'];
					$PagoComprobante->PacTiempoCreacion = $fila['NPacTiempoCreacion'];
					$PagoComprobante->PacTiempoModificacion = $fila['NPacTiempoModificacion'];
					
					
					$PagoComprobante->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					
					$PagoComprobante->CliNombre = $fila['CliNombre'];
					$PagoComprobante->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$PagoComprobante->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					
					
						$PagoComprobante->PagMonto = $fila['PagMonto'];
					$PagoComprobante->MonId = $fila['MonId'];
					$PagoComprobante->PagTipoCambio = $fila['PagTipoCambio'];
				
					
					$PagoComprobante->FacTotal = $fila['FacTotal'];
					$PagoComprobante->FacTipoCambio = $fila['FacTipoCambio'];
					$PagoComprobante->MonIdFactura = $fila['MonIdFactura'];
					$PagoComprobante->FacFechaEmision = $fila['NFacFechaEmision'];
					$PagoComprobante->FacCantidadDia = $fila['FacCantidadDia'];
					$PagoComprobante->FacFechaVencimiento = $fila['NFacFechaVencimiento'];
					$PagoComprobante->FacFechaEmision = $fila['NFacFechaEmision'];
					$PagoComprobante->FtaNumero = $fila['FtaNumero'];
					
					$PagoComprobante->BolTotal = $fila['BolTotal'];
					$PagoComprobante->BolTipoCambio = $fila['BolTipoCambio'];
					$PagoComprobante->MonIdBoleta = $fila['MonIdBoleta'];
					$PagoComprobante->BolFechaEmision = $fila['NBolFechaEmision'];
					
				 	$PagoComprobante->BolCantidadDia = $fila['BolCantidadDia'];
					
					$PagoComprobante->BolFechaVencimiento = $fila['NBolFechaVencimiento'];
					$PagoComprobante->BolDiaTranscurrido = $fila['BolDiaTranscurrido'];
					
					$PagoComprobante->BtaNumero = $fila['BtaNumero'];
					
					$PagoComprobante->SucNombre = $fila['SucNombre'];
				
					$PagoComprobante->VdiId = $fila['VdiId'];
					
					
					$PagoComprobante->FacIdOrdenVentaVehiculo = $fila['FacIdOrdenVentaVehiculo'];
					$PagoComprobante->FtaIdOrdenVentaVehiculo = $fila['FtaIdOrdenVentaVehiculo'];
					$PagoComprobante->BolIdOrdenVentaVehiculo = $fila['BolIdOrdenVentaVehiculo'];
					$PagoComprobante->BtaIdOrdenVentaVehiculo = $fila['BtaIdOrdenVentaVehiculo'];
					
					$PagoComprobante->MonIdOrdenVentaVehiculo = $fila['MonIdOrdenVentaVehiculo'];
					
					
					$PagoComprobante->BolTotalRealOrdenVentaVehiculo = $fila['BolTotalRealOrdenVentaVehiculo'];
					$PagoComprobante->FacTotalRealOrdenVentaVehiculo = $fila['FacTotalRealOrdenVentaVehiculo'];
					
					
                    $PagoComprobante->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PagoComprobante;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

}
?>