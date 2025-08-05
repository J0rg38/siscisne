<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsReporteFichaIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteComprobanteVenta {

	public $InsMysql;

	public $Transaccion;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = false;
    }

	public function __destruct(){

	}
	
    public function MtdObtenerAsignacionVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oOrdenVentaVehiculo=NULL,$oConFechaEntrega=false,$oSucursal=NULL,$oTipoFecha="avv.AvvFecha") {

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
				
				//
//				$filtrar .= '  OR EXISTS( 
//					
//					SELECT 
//					ood.OodId
//					
//					FROM tbloodordencotizaciondetalle ood
//						
//						LEFT JOIN tblproproducto pro
//						ON ood.ProId = pro.ProId
//						
//							
//								
//								
//					WHERE 
//					
//						ood.AvvId = avv.AvvId
//						AND
//						(
//							pro.ProNombre LIKE "%'.$oFiltro.'%" OR
//							pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%"  OR
//							pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 
//						)
//						
//
//					) ';
					
					
				$filtrar .= '  ) ';

			
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		//
//		if(!empty($oFechaInicio)){
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(avv.AvvFecha)>="'.$oFechaInicio.'" AND DATE(avv.AvvFecha)<="'.$oFechaFin.'"';
//			}else{
//				$fecha = ' AND DATE(avv.AvvFecha)>="'.$oFechaInicio.'"';
//			}
//		}else{
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(avv.AvvFecha)<="'.$oFechaFin.'"';		
//			}			
//		}
		
		
			if(!empty($oTipoFecha)){
			
			 if($oTipoFecha=="Comprobante"){
			
				if(!empty($oFechaInicio)){
					if(!empty($oFechaFin)){
						
						$fecha = ' AND  
					(
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						) 
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					) >="'.$oFechaInicio.'" 
					
					AND 
					
					
					(
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						) 
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					)
					
					<="'.$oFechaFin.'"';
					
					
					
					}else{
						$fecha = ' AND  
						
						
						
						(
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						) 
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					)
						
	
					
					)
					
						
						>="'.$oFechaInicio.'"';
					}
				}else{
					if(!empty($oFechaFin)){
						$fecha = ' AND  (
					
						 (
					
						IFNULL(
						
						(
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fac.OvvId = avv.OvvId 
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
						) 
						,IFNULL(
							(
							SELECT 
							bol.BolFechaEmision
							FROM tblbolboleta bol
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
							WHERE bol.OvvId = avv.OvvId
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
							),""
							)
						)
					 
						
	
					
					)
	
					
					)  <="'.$oFechaFin.'"';		
					}			
				}
				
			}else{
				
				if(!empty($oFechaInicio)){
					if(!empty($oFechaFin)){
						
						$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'" AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';
					}else{
						$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'"';
					}
				}else{
					if(!empty($oFechaFin)){
						$fecha = ' AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';		
					}			
				}
				
			}
			
		}
		
		
		
		
		if(!empty($oEstado)){
			$estado = ' AND avv.AvvEstado = '.$oEstado;
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND avv.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}

	
		if(($oConFechaEntrega)){
			$entrega = ' AND ovv.OvvActaEntregaFecha IS NOT NULL AND ovv.OvvActaEntregaFecha != "0000-00-00" ';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ovv.SucId = "'.$oSucursal.'"';
		}


			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				avv.AvvId,
				avv.PerId,
				
				avv.OvvId,	
				ovv.EinId,
				
				DATE_FORMAT(avv.AvvFecha, "%d/%m/%Y") AS "NAvvFecha",
				avv.AvvHora,
				
				avv.AvvObservacion,
				avv.AvvSolicitante,
				avv.AvvVehiculoMarca,				
				avv.AvvVehiculoModelo,
				avv.AvvVehiculoVersion,
				avv.AvvColor,
				avv.AvvAnoModelo,				
				
				AvvAprobacion,
				avv.AvvEstado,
				DATE_FORMAT(avv.AvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAvvTiempoCreacion",
	        	DATE_FORMAT(avv.AvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAvvTiempoModificacion",
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.OvvId = ovv.OvvId 
					AND pag.PagEstado = 3
					LIMIT 1
					
				) THEN "Si"
				ELSE "No"
				END AS OvvPago,
				
				
				(
					SELECT 
					(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.OvvId = ovv.OvvId 
					AND pag.PagEstado = 3
					
					ORDER BY pag.PagFechaTransaccion ASC
					LIMIT 1
				
				) AS OvvPagoInicial,
				
				(
					SELECT 
					mon.MonSimbolo
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
							LEFT JOIN tblmonmoneda mon
							ON pag.MonId = mon.MonId
					WHERE pac.OvvId = ovv.OvvId 
					AND pag.PagEstado = 3
					
					ORDER BY pag.PagFechaTransaccion ASC
					LIMIT 1
				
				) AS OvvPagoInicialMonedaSimbolo,
				
				
				
				(
					IFNULL(
					(
						SELECT 
						fta.FtaNumero
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE fac.OvvId = avv.OvvId 
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
					)
					,IFNULL(
						(
						SELECT 
						bta.BtaNumero
						FROM tblbolboleta bol
							LEFT JOIN tblbtaboletatalonario bta
							ON bol.BtaId = bta.BtaId
						WHERE bol.OvvId = avv.OvvId
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
					)
						,""))

				) AS RcvSerie,
				
				
				(
					IFNULL(
					(
						SELECT 
						fac.FacFechaEmision
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE fac.OvvId = avv.OvvId 
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
					)
					,IFNULL(
						(
						SELECT 
						bol.BolFechaEmision
						FROM tblbolboleta bol
							LEFT JOIN tblbtaboletatalonario bta
							ON bol.BtaId = bta.BtaId
						WHERE bol.OvvId = avv.OvvId
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
					)
					,""))

				) AS RcvFecha,
				
				
				(
					SELECT 
					CONCAT(fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = avv.OvvId 
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
				)  AS FacId,
				
				(
					SELECT 
					CONCAT(fac.FtaId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = avv.OvvId 
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
				)  AS FtaId,
		
		
								
				(
					SELECT 
					CONCAT(bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = avv.OvvId
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
				) AS BolId,	
				
				(
					SELECT 
					CONCAT(bol.BtaId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = avv.OvvId
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
				) AS BtaId,	
				
				
				(
			IF(IFNULL((SELECT 
			
			SUM(pag.PagMonto)
			
			FROM tblpagpago pag
			WHERE 
				
				EXISTS(
					SELECT
					pac.PacId
					FROM tblpacpagocomprobante pac
						WHERE pac.PagId = pag.PagId
						AND pac.OvvId = avv.OvvId
						AND pag.PagEstado = 3
						
				)
				
			ORDER BY pag.PagId ASC LIMIT 1
			),0)>=ovv.OvvTotal,"Si","No")
			
		) AS AvvCancelado,
		
		
		
			(
			IF(
			
			IFNULL((SELECT 
			
			SUM(pag.PagMonto)
			
			FROM tblpagpago pag
			WHERE 
				
				EXISTS(
					SELECT
					pac.PacId
					FROM tblpacpagocomprobante pac
						WHERE pac.PagId = pag.PagId
						AND pac.OvvId = avv.OvvId
						AND pag.PagEstado = 3
						
				)
				
			ORDER BY pag.PagId ASC LIMIT 1
			),0) 
			
			+
			
			IFNULL(
			(
			SELECT
			SUM(fac.FacTotal)
			FROM tblfacfactura fac
			WHERE fac.OvvId = avv.OvvId
			AND fac.FacEstado <>  6
			)
			,0)
			
			+
			
			IFNULL(
			(
			SELECT
			SUM(bol.BolTotal)
			FROM tblbolboleta bol
			WHERE bol.OvvId = avv.OvvId
			AND bol.BolEstado <>  6
			)
			,0)
			
			 >=  ovv.OvvTotal,"Si","No")
			
		) AS AvvCancelado2,
				
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,

				ein.EinVIN,
				ein.EinNumeroMotor,
				ein.EinAnoModelo,
				ein.EinAnoFabricacion,
				ein.EinColor,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerEmail,
				
				per2.PerNombre AS PerNombreVendedor,
				per2.PerApellidoPaterno AS PerApellidoPaternoVendedor,
				per2.PerApellidoMaterno AS PerApellidoMaternoVendedor,
				per2.PerEmail AS PerEmailVendedor,
				
				suc.SucNombre,
				
				ovv.CliId,
				
				DATE_FORMAT(ovv.OvvActaEntregaFecha, "%d/%m/%Y") AS "NOvvActaEntregaFecha",
				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				
				ovv.OvvAprobacion1,
				ovv.OvvAprobacion2,
				ovv.OvvAprobacion3,
				
				ovv.OvvTotal,
				ovv.OvvTipoCambio,
				ovv.MonId,
				
				
				DATE_FORMAT(ovv.OvvTiempoSolicitudEnvio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoSolicitudEnvio",
				DATE_FORMAT(ovv.OvvTiempoAprobacion1Envio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAprobacion1Envio",
				DATE_FORMAT(ovv.OvvTiempoAprobacion2Envio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAprobacion2Envio",
				DATE_FORMAT(ovv.OvvTiempoEmitido, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoEmitido",
				DATE_FORMAT(ovv.OvvTiempoAnulado, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoAnulado",
				DATE_FORMAT(ovv.OvvTiempoPorFacturar, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoPorFacturar",
				DATE_FORMAT(ovv.OvvTiempoFacturado, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoFacturado",
				
				
				
								cli.CliNumeroDocumento,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliTelefono,
		cli.CliCelular,
		cli.CliEmail,
		cli.CliDireccion,
		cli.CliDepartamento,
		cli.CliProvincia,
		cli.CliDistrito,
		
		tdo.TdoNombre,
		
		mon.MonNombre,
		mon.MonSimbolo
		
		
				FROM tblavvasignacionventavehiculo avv
			
					LEFT JOIN tblovvordenventavehiculo ovv
					ON avv.OvvId = ovv.OvvId	
									
						LEFT JOIN tblclicliente cli
						ON ovv.CliId = cli.CliId
							LEFT JOIN tbltdotipodocumento tdo
							ON cli.TdoId = tdo.TdoId
					
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON avv.EinId = ein.EinId				
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
								
							LEFT JOIN tblperpersonal per
							ON avv.PerId = per.PerId
							LEFT JOIN tblperpersonal per2
							ON ovv.PerId = per2.PerId
								LEFT JOIN tblsucsucursal suc
								ON ovv.SucId = suc.SucId
					
					LEFT JOIN tblmonmoneda mon
					ON ovv.MonId = mon.MonId
				WHERE 1 = 1  AND ovv.OvvEstado <> 6 '.$filtrar.$fecha.$ovvehiculo.$sucursal.$tipo.$stipo.$entrega.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAsignacionVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AsignacionVentaVehiculo = new $InsAsignacionVentaVehiculo();
                    $AsignacionVentaVehiculo->AvvId = $fila['AvvId'];
					
					$AsignacionVentaVehiculo->PerId = $fila['PerId'];
					$AsignacionVentaVehiculo->OvvId = $fila['OvvId'];
					$AsignacionVentaVehiculo->EinId = $fila['EinId'];
					
					$AsignacionVentaVehiculo->AvvFecha = $fila['NAvvFecha'];
					$AsignacionVentaVehiculo->AvvHora = $fila['AvvHora'];
					
					$AsignacionVentaVehiculo->AvvObservacion = $fila['AvvObservacion'];
					
					$AsignacionVentaVehiculo->AvvSolicitante = $fila['AvvSolicitante'];
					$AsignacionVentaVehiculo->AvvVehiculoMarca = $fila['AvvVehiculoMarca'];					
					$AsignacionVentaVehiculo->AvvVehiculoModelo = $fila['AvvVehiculoModelo'];
					$AsignacionVentaVehiculo->AvvVehiculoVersion = $fila['AvvVehiculoVersion'];										
					$AsignacionVentaVehiculo->AvvColor = $fila['AvvColor'];
					$AsignacionVentaVehiculo->AvvAnoModelo = $fila['AvvAnoModelo'];



					$AsignacionVentaVehiculo->AvvAprobacion = $fila['AvvAprobacion'];
					$AsignacionVentaVehiculo->AvvEstado = $fila['AvvEstado'];
					$AsignacionVentaVehiculo->AvvTiempoCreacion = $fila['NAvvTiempoCreacion'];  
					$AsignacionVentaVehiculo->AvvTiempoModificacion = $fila['NAvvTiempoModificacion']; 
					
					$AsignacionVentaVehiculo->OvvPago = $fila['OvvPago']; 
					$AsignacionVentaVehiculo->OvvPagoInicial = $fila['OvvPagoInicial']; 
					$AsignacionVentaVehiculo->OvvPagoInicialMonedaSimbolo = $fila['OvvPagoInicialMonedaSimbolo']; 
					
						
					$AsignacionVentaVehiculo->FacId = $fila['FacId'];
					$AsignacionVentaVehiculo->FtaId = $fila['FtaId'];
					
					$AsignacionVentaVehiculo->BolId = $fila['BolId'];
					$AsignacionVentaVehiculo->BtaId = $fila['BtaId'];
					
					$AsignacionVentaVehiculo->AvvCancelado = $fila['AvvCancelado'];
					$AsignacionVentaVehiculo->AvvCancelado = $fila['AvvCancelado2'];
					
					if(!empty($AsignacionVentaVehiculo->FacId ) || !empty($AsignacionVentaVehiculo->BolId )){
						$AsignacionVentaVehiculo->AvvFacturado = "Si";
					}else{
						$AsignacionVentaVehiculo->AvvFacturado = "No";
					}
					
					
					$AsignacionVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					$AsignacionVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					$AsignacionVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$AsignacionVentaVehiculo->EinVIN = $fila['EinVIN'];
					$AsignacionVentaVehiculo->EinNumeroMotor = $fila['EinNumeroMotor'];
					$AsignacionVentaVehiculo->EinAnoModelo = $fila['EinAnoModelo'];
					$AsignacionVentaVehiculo->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$AsignacionVentaVehiculo->EinColor = $fila['EinColor'];
					
					
				
				$AsignacionVentaVehiculo->TdoId = $fila['TdoId'];
					$AsignacionVentaVehiculo->PerNombre = $fila['PerNombre'];
					$AsignacionVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$AsignacionVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$AsignacionVentaVehiculo->PerEmail = $fila['PerEmail'];
					
					
					$AsignacionVentaVehiculo->PerNombreVendedor = $fila['PerNombreVendedor'];
					$AsignacionVentaVehiculo->PerApellidoPaternoVendedor = $fila['PerApellidoPaternoVendedor'];
					$AsignacionVentaVehiculo->PerApellidoMaternoVendedor = $fila['PerApellidoMaternoVendedor'];
					$AsignacionVentaVehiculo->PerEmailVendedor = $fila['PerEmailVendedor'];
					
					$AsignacionVentaVehiculo->SucNombre = $fila['SucNombre'];
					
					$AsignacionVentaVehiculo->OvvActaEntregaFecha = $fila['NOvvActaEntregaFecha'];
					$AsignacionVentaVehiculo->OvvFecha = $fila['NOvvFecha'];
					
					
					$AsignacionVentaVehiculo->OvvAprobacion1 = $fila['OvvAprobacion1'];
					$AsignacionVentaVehiculo->OvvAprobacion2 = $fila['OvvAprobacion2'];
					$AsignacionVentaVehiculo->OvvAprobacion3 = $fila['OvvAprobacion3'];
					
					$AsignacionVentaVehiculo->OvvTotal = $fila['OvvTotal'];
					$AsignacionVentaVehiculo->OvvTipoCambio = $fila['OvvTipoCambio'];
					$AsignacionVentaVehiculo->MonId = $fila['MonId'];
					
					$AsignacionVentaVehiculo->OvvTiempoSolicitudEnvio = $fila['NOvvTiempoSolicitudEnvio']; 
					$AsignacionVentaVehiculo->OvvTiempoAprobacion1Envio = $fila['NOvvTiempoAprobacion1Envio'];
					$AsignacionVentaVehiculo->OvvTiempoAprobacion2Envio = $fila['NOvvTiempoAprobacion2Envio'];
					$AsignacionVentaVehiculo->OvvTiempoEmitido = $fila['NOvvTiempoEmitido'];
					$AsignacionVentaVehiculo->OvvTiempoAnulado = $fila['NOvvTiempoAnulado'];
					$AsignacionVentaVehiculo->OvvTiempoPorFacturar = $fila['NOvvTiempoPorFacturar'];
					$AsignacionVentaVehiculo->OvvTiempoFacturado = $fila['NOvvTiempoFacturado'];
					
					$AsignacionVentaVehiculo->CliId = $fila['CliId'];
					$AsignacionVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$AsignacionVentaVehiculo->CliNombre = $fila['CliNombre'];
					$AsignacionVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$AsignacionVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$AsignacionVentaVehiculo->CliTelefono = $fila['CliTelefono'];
					$AsignacionVentaVehiculo->CliCelular = $fila['CliCelular'];
					$AsignacionVentaVehiculo->CliEmail = $fila['CliEmail'];
					$AsignacionVentaVehiculo->CliDireccion = $fila['CliDireccion'];
					
					$AsignacionVentaVehiculo->CliDepartamento = $fila['CliDepartamento'];
					$AsignacionVentaVehiculo->CliProvincia = $fila['CliProvincia'];
					$AsignacionVentaVehiculo->CliDistrito = $fila['CliDistrito'];
					
		
					$AsignacionVentaVehiculo->TdoNombre = $fila['TdoNombre'];
					
					$AsignacionVentaVehiculo->MonNombre = $fila['MonNombre'];
					$AsignacionVentaVehiculo->MonSimbolo = $fila['MonSimbolo'];
			
					switch($AsignacionVentaVehiculo->AvvEstado){
					
					case 1:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "Pendiente";
						break;
					
						case 3:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "Revisado";
						break;	
					
						case 6:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "Anulado";
						break;	
					
						default:
							$AsignacionVentaVehiculo->AvvEstadoDescripcion = "";
						break;
					
					}
						

                    $AsignacionVentaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AsignacionVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}


}
?>