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
		
										/*AND NOT EXISTS(
											SELECT 	
											ncr.NcrId
											FROM tblncrnotacredito ncr
											WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.NcrMotivoCodigo<> "04"
											AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
											
										) */
							
							
							ORDER BY fac.FacFechaEmision DESC
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
							
								/*
								AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
								)*/
								
								
							ORDER BY bol.BolFechaEmision DESC
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
		
										/*
										AND NOT EXISTS(
											SELECT 	
											ncr.NcrId
											FROM tblncrnotacredito ncr
											WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.NcrMotivoCodigo<> "04"
											AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
											
										) */
							
							ORDER BY fac.FacFechaEmision DESC			
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
						
						
							/*AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
								)*/
								
							ORDER BY bol.BolFechaEmision DESC		
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
		
										/*AND NOT EXISTS(
											SELECT 	
											ncr.NcrId
											FROM tblncrnotacredito ncr
											WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.NcrMotivoCodigo<> "04"
											AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
											
										) */
							
							ORDER BY fac.FacFechaEmision DESC	
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
							
							/*AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
								)*/
								
							ORDER BY bol.BolFechaEmision DESC	
						
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
		
										/*AND NOT EXISTS(
											SELECT 	
											ncr.NcrId
											FROM tblncrnotacredito ncr
											WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.NcrMotivoCodigo<> "04"
											AND ncr.NcrMotivoCodigo<> "05"
											AND ncr.NcrMotivoCodigo<> "09"
											
										) */
										
							
							ORDER BY fac.FacFechaEmision DESC	
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
							
							/*AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
								)*/
								
								
							ORDER BY bol.BolFechaEmision DESC	
							LIMIT 1
							),""
							)
						)
					 
						
	
					
					)
	
					
					)  <="'.$oFechaFin.'"';		
					}			
				}
				
				
				
				
			
			}else  if($oTipoFecha=="ComprobanteS"){
				 
				 
				 
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
		
							ORDER BY fac.FacFechaEmision DESC				
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
							
							ORDER BY bol.BolFechaEmision DESC	
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
		
							ORDER BY fac.FacFechaEmision DESC			
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
							
							
							ORDER BY bol.BolFechaEmision DESC	
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
		
							ORDER BY fac.FacFechaEmision DESC				
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
							
							ORDER BY bol.BolFechaEmision DESC	
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
		
							ORDER BY fac.FacFechaEmision DESC			
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
							
							ORDER BY bol.BolFechaEmision DESC			
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
	
								/*	AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) */
						
						
						ORDER BY fac.FacFechaEmision DESC
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
						/*AND NOT EXISTS(
								SELECT 	
								ncr.NcrId
								FROM tblncrnotacredito ncr
								WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
								AND ncr.NcrEstado <> 6
								AND ncr.NcrMotivoCodigo<> "04"
								AND ncr.NcrMotivoCodigo<> "05"
								AND ncr.NcrMotivoCodigo<> "09"
							)*/
							
						ORDER BY bol.BolFechaEmision DESC
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
	
									/*AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) */
						
						
						ORDER BY fac.FacFechaEmision DESC
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
						
						/*AND NOT EXISTS(
								SELECT 	
								ncr.NcrId
								FROM tblncrnotacredito ncr
								WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
								AND ncr.NcrEstado <> 6
								AND ncr.NcrMotivoCodigo<> "04"
								AND ncr.NcrMotivoCodigo<> "05"
								AND ncr.NcrMotivoCodigo<> "09"
							)*/
							
						ORDER BY bol.BolFechaEmision DESC
						LIMIT 1
					)
					,""))

				) AS RcvFecha,
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				(
					IFNULL(
					
						(
							SELECT 
							ncr.NcrId
							
							FROM tblncrnotacredito ncr
							
								LEFT JOIN tblnctnotacreditotalonario nct
								ON ncr.NctId = nct.NctId
									LEFT JOIN tblfacfactura fac
									ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
																
							WHERE fac.OvvId = avv.OvvId 
							AND fac.FacEstado <> 6
							AND ncr.NcrEstado <> 6
		
							LIMIT 1
						),
						
						IFNULL(
							(
								SELECT 
								ncr.NcrId
								FROM tblncrnotacredito ncr
									LEFT JOIN tblnctnotacreditotalonario nct
									ON ncr.NctId = nct.NctId
										LEFT JOIN tblbolboleta bol
										ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									
								WHERE bol.OvvId = avv.OvvId
								AND bol.BolEstado <> 6 
								AND ncr.NcrEstado <> 6
								
								LIMIT 1
							)
						,"")
					)
				)  AS NcrId,
				
				
				
				
				(
					IFNULL(
					
						(
							SELECT 
							ncr.NctId
							
							FROM tblncrnotacredito ncr
							
								LEFT JOIN tblnctnotacreditotalonario nct
								ON ncr.NctId = nct.NctId
									LEFT JOIN tblfacfactura fac
									ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
																
							WHERE fac.OvvId = avv.OvvId 
							AND fac.FacEstado <> 6
							AND ncr.NcrEstado <> 6
		
							LIMIT 1
						),
						
						IFNULL(
							(
								SELECT 
								ncr.NctId
								FROM tblncrnotacredito ncr
									LEFT JOIN tblnctnotacreditotalonario nct
									ON ncr.NctId = nct.NctId
										LEFT JOIN tblbolboleta bol
										ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									
								WHERE bol.OvvId = avv.OvvId
								AND bol.BolEstado <> 6 
								AND ncr.NcrEstado <> 6
								
								LIMIT 1
							)
						,"")
					)
				)  AS NctId,
		
		
		(
					IFNULL(
					
						(
							SELECT 
							CONCAT(nct.NctNumero,"-",ncr.NcrId)
							
							FROM tblncrnotacredito ncr
							
								LEFT JOIN tblnctnotacreditotalonario nct
								ON ncr.NctId = nct.NctId
									LEFT JOIN tblfacfactura fac
									ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
																
							WHERE fac.OvvId = avv.OvvId 
							AND fac.FacEstado <> 6
							AND ncr.NcrEstado <> 6
		
							LIMIT 1
						),
						
						IFNULL(
							(
								SELECT 
								CONCAT(nct.NctNumero,"-",ncr.NcrId)
								FROM tblncrnotacredito ncr
									LEFT JOIN tblnctnotacreditotalonario nct
									ON ncr.NctId = nct.NctId
										LEFT JOIN tblbolboleta bol
										ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									
								WHERE bol.OvvId = avv.OvvId
								AND bol.BolEstado <> 6 
								AND ncr.NcrEstado <> 6
								
								LIMIT 1
							)
						,"")
					)
				)  AS RcvNotaCredito,
				
		
		
				
				
					(
					IFNULL(
					
						(
							SELECT 
							ncr.NcrMotivo
							
							FROM tblncrnotacredito ncr
							
								LEFT JOIN tblnctnotacreditotalonario nct
								ON ncr.NctId = nct.NctId
									LEFT JOIN tblfacfactura fac
									ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
																
							WHERE fac.OvvId = avv.OvvId 
							AND fac.FacEstado <> 6
							AND ncr.NcrEstado <> 6
		
							LIMIT 1
						),
						
						IFNULL(
							(
								SELECT 
								ncr.NcrMotivo
								FROM tblncrnotacredito ncr
									LEFT JOIN tblnctnotacreditotalonario nct
									ON ncr.NctId = nct.NctId
										LEFT JOIN tblbolboleta bol
										ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									
								WHERE bol.OvvId = avv.OvvId
								AND bol.BolEstado <> 6 
								AND ncr.NcrEstado <> 6
								
								LIMIT 1
							)
						,"")
					)
				)  AS RcvNotaCreditoMotivo,
				
				
				
				
				(
					IFNULL(
					
						(
							SELECT 
							ncr.NcrTotal
							
							FROM tblncrnotacredito ncr
							
								LEFT JOIN tblnctnotacreditotalonario nct
								ON ncr.NctId = nct.NctId
									LEFT JOIN tblfacfactura fac
									ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
																
							WHERE fac.OvvId = avv.OvvId 
							AND fac.FacEstado <> 6
							AND ncr.NcrEstado <> 6
		
							LIMIT 1
						),
						
						IFNULL(
							(
								SELECT 
								ncr.NcrTotal
								FROM tblncrnotacredito ncr
									LEFT JOIN tblnctnotacreditotalonario nct
									ON ncr.NctId = nct.NctId
										LEFT JOIN tblbolboleta bol
										ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									
								WHERE bol.OvvId = avv.OvvId
								AND bol.BolEstado <> 6 
								AND ncr.NcrEstado <> 6
								
								LIMIT 1
							)
						,"")
					)
				)  AS RcvNotaCreditoTotal,
				
				
				
			
				(
					IFNULL(
					
						(
							SELECT 
							ncr.NcrTipoCambio
							
							FROM tblncrnotacredito ncr
							
								LEFT JOIN tblnctnotacreditotalonario nct
								ON ncr.NctId = nct.NctId
									LEFT JOIN tblfacfactura fac
									ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
																
							WHERE fac.OvvId = avv.OvvId 
							AND fac.FacEstado <> 6
							AND ncr.NcrEstado <> 6
		
							LIMIT 1
						),
						
						IFNULL(
							(
								SELECT 
								ncr.NcrTipoCambio
								FROM tblncrnotacredito ncr
									LEFT JOIN tblnctnotacreditotalonario nct
									ON ncr.NctId = nct.NctId
										LEFT JOIN tblbolboleta bol
										ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
									
								WHERE bol.OvvId = avv.OvvId
								AND bol.BolEstado <> 6 
								AND ncr.NcrEstado <> 6
								
								LIMIT 1
							)
						,"")
					)
				)  AS RcvNotaCreditoTipoCambio,	
				
				
				
				
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
					
					ORDER BY fac.FacFechaEmision DESC
					
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
								
					ORDER BY fac.FacFechaEmision DESC
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
				
					ORDER BY bol.BolFechaEmision DESC
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
						
					ORDER BY bol.BolFechaEmision DESC
					LIMIT 1
				) AS BtaId,	
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				(
					SELECT 
					CONCAT(fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = avv.OvvId 
					AND fac.FacEstado <> 6

					ORDER BY fac.FacFechaEmision DESC
					LIMIT 1
				)  AS FacIdS,
				
				(
					SELECT 
					CONCAT(fac.FtaId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = avv.OvvId 
					AND fac.FacEstado <> 6 
					
					ORDER BY fac.FacFechaEmision DESC
					LIMIT 1
				)  AS FtaIdS,
		
		
								
				(
					SELECT 
					CONCAT(bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = avv.OvvId
					AND bol.BolEstado <> 6 
					
					ORDER BY bol.BolFechaEmision DESC
					LIMIT 1
				) AS BolIdS,	
				
				(
					SELECT 
					CONCAT(bol.BtaId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = avv.OvvId
					AND bol.BolEstado <> 6 
					
					ORDER BY bol.BolFechaEmision DESC
					LIMIT 1
				) AS BtaIdS,	
	
				
				
				
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
		mon.MonSimbolo,
		
		
		DATE_FORMAT(ovv.OvvTiempoSolicitudEnvio, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoSolicitudEnvio"
		
		
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
					
					
					$AsignacionVentaVehiculo->FacIdS = $fila['FacIdS'];
					$AsignacionVentaVehiculo->FtaIdS = $fila['FtaIdS'];
					
					$AsignacionVentaVehiculo->BolIdS = $fila['BolIdS'];
					$AsignacionVentaVehiculo->BtaIdS = $fila['BtaIdS'];
					
					
					
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
			
			$AsignacionVentaVehiculo->OvvTiempoSolicitudEnvio = $fila['NOvvTiempoSolicitudEnvio'];
			$AsignacionVentaVehiculo->RcvNotaCredito = $fila['RcvNotaCredito'];
			$AsignacionVentaVehiculo->RcvNotaCreditoMotivo = $fila['RcvNotaCreditoMotivo'];
			$AsignacionVentaVehiculo->RcvNotaCreditoTotal = $fila['RcvNotaCreditoTotal'];
			$AsignacionVentaVehiculo->RcvNotaCreditoTipoCambio = $fila['RcvNotaCreditoTipoCambio'];
			
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








 public function MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL) {
	
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
					fde.FdeId
					FROM tblfdefacturadetalle fde
						
					WHERE 
						fde.FacId = fac.FacId AND
						fde.FtaId = fac.FtaId AND
						
						(
						fde.FdeDescripcion LIKE "%'.$oFiltro.'%" 
						
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
		
//		if(!empty($oSucursal)){
//			$sucursal = ' AND fta.SucId = "'.$oSucursal.'"';
//		}
//			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (fac.FacEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'" AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fac.FacFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fac.FacFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
		
						
		if(!empty($oTalonario)){
			$talonario = ' AND fac.FtaId = "'.$oTalonario.'"';
		}
		
		
		
		if(!empty($oNotaCredito)){
			switch($oNotaCredito){
				case 1:

					$ncredito = ' AND EXISTS (
							SELECT ncr.NcrId
								FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId 
											AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.FacId IS NULL 
											AND ncr.BtaId IS NULL
				)';

				break;
				
				case 2:

					$ncredito = ' AND NOT EXISTS  (
							SELECT ncr.NcrId
								FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId 
											AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.FacId IS NULL 
											AND ncr.BtaId IS NULL
						)';

				break;
			}
		}
		
		if(!empty($oRegimen)){
			$regimen = ' AND fac.RegId = "'.$oRegimen.'"';
		}
		
		if(!empty($oCondicionPago)){
			$npago = ' AND fac.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND fac.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND fac.CliId = "'.$oCliente.'"';
		}
		
		
		if(!empty($oAlmacenMovimiento)){
			 $amovimiento = ' AND fac.AmoId = "'.$oAlmacenMovimiento.'"';
		}
		
		
		if(!empty($oDiaVencer)){
			$dvencer = ' AND (fac.FacCantidadDia - IFNULL(DATEDIFF(DATE(NOW()),fac.FacFechaEmision),0)) <= '.$oDiaVencer;
		}
		
		if(!empty($oPagado)){
			
			switch($oPagado){
				case 1:
				
					/*$pagado = '
						
						AND
						
						(
							IFNULL((
							SELECT 
							SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) ) 
							FROM tblpacpagocomprobante cpc
								LEFT JOIN tblpagpago pag
								ON cpc.PagId = pag.PagId
								
								WHERE (cpc.FacId = fac.FacId AND cpc.FtaId = fac.FtaId)
							),0) >= fac.FacTotal
						)
						
						
						
						
					';*/
					
					$pagado = '

						AND

						(
							IFNULL((
							SELECT 
								SUM(ROUND(pag.PagMonto/IFNULL(pag.PagTipoCambio,1),2)) 

							FROM tblpacpagocomprobante cpc
								LEFT JOIN tblpagpago pag
								ON cpc.PagId = pag.PagId
								
								WHERE (cpc.FacId = fac.FacId AND cpc.FtaId = fac.FtaId)
							),0) >= (fac.FacTotal/IFNULL(fac.FacTipoCambio,1))
						)

					';

				break;
				
				case 2:

					$pagado = '
						
						AND
						
						(
							IFNULL((
							SELECT 
								SUM(ROUND(pag.PagMonto/IFNULL(pag.PagTipoCambio,1),2)) 

							FROM tblpacpagocomprobante cpc
								LEFT JOIN tblpagpago pag
								ON cpc.PagId = pag.PagId
								
								WHERE (cpc.FacId = fac.FacId AND cpc.FtaId = fac.FtaId)
							),0) < (fac.FacTotal/IFNULL(fac.FacTipoCambio,1))
						)
					';
					
				break;
				
				default:
				
				break;
				
			}
			
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND fac.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}
		
			
		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND amo.VdiId = "'.$oVentaDirecta.'"';
		}
		
		
		if(!empty($oVendedor)){
			$vendedor = ' AND vdi.PerId = "'.$oVendedor.'" OR ovv.PerId = "'.$oVendedor.'" ';
		}
		
		if(!empty($oTieneCodigoExterno)){
			
			
		switch($oTieneCodigoExterno){
				case 1:
					$tcexterno = ' AND 
					EXISTS(
						SELECT 
						fam.FamId
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
						WHERE vdi.VdiCodigoExterno IS NOT NULL
						AND fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId		
						AND  vdi.VdiCodigoExterno != ""				
						
					)					
					';
				break;
				
				case 2:
				$tcexterno = ' AND 
					EXISTS(
						SELECT 
						fam.FamId
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
						WHERE vdi.VdiCodigoExterno IS  NULL
						AND fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId						
						AND  vdi.VdiCodigoExterno = ""		
					)			
					';
				break;
				
				default:
				
				break;
				
			}
		}
		
				
		if(!empty($oSucursal)){
			$sucursal = ' AND fac.SucId = "'.$oSucursal.'"';
		}
		
		if(($oNoProcesdado)){

				$noprocesado = ' 	AND (fac.FacSunatRespuestaEnvioContenido NOT LIKE "%aceptad%" 
				OR fac.FacSunatRespuestaEnvioContenido IS NULL 
				OR fac.FacSunatRespuestaEnvioContenido  = ""
				
				) ';
		}
		
		
		
				
				
				
		if(!empty($oCancelado)){
			switch($oCancelado){
				
				case "Si":
				
					$cancelado = ' HAVING NFacCancelado = 1 ';
					
				break;
				
				case "No":
				
					$cancelado = '  HAVING NFacCancelado = 2 ';
					
				break;
				
			}
			
		}
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fac.FacId,
				fac.FtaId,
				fac.UsuId,
				
				fac.CliId,

				
				fac.GreId,
				fac.GrtId,
				
				fac.NpaId,
				fac.AmoId,
				fac.OvvId,
				fac.FccId,
				
				
				fac.PagId,
				
				CASE
				WHEN EXISTS (
					SELECT ncr.NcrId
						FROM tblncrnotacredito ncr
								WHERE ncr.FacId = fac.FacId 
									AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.BolId IS NULL 
									AND ncr.BtaId IS NULL
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FacNotaCredito,
				
				CASE
				WHEN EXISTS (
					SELECT ndb.NdbId
						FROM tblndbnotadebito ndb
								WHERE ndb.FacId = fac.FacId 
									AND ndb.FtaId = fac.FtaId
									AND ndb.NdbEstado <> 6
									AND ndb.BolId IS NULL 
									AND ndb.BtaId IS NULL
				) THEN "Si"
				ELSE "No"
				END AS FacNotaDebito,
				
				
				fac.FacSIAFNumero,
				fac.FacOrdenNumero,
				DATE_FORMAT(fac.FacOrdenFecha, "%d/%m/%Y") AS "NFacOrdenFecha",
				fac.FacOrdenTipo,
				fac.FacOrdenFoto,
				fac.FacCantidadDia,
				DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) AS FacDiaVencido,
				
				DATE_FORMAT(fac.FacFechaVencimiento, "%d/%m/%Y") AS "NFacFechaVencimiento",
				DATEDIFF(DATE(NOW()),fac.FacFechaEmision) AS FacDiaTranscurrido,
				
				
					
				fac.FacIncluyeImpuesto,
				fac.MonId,
				fac.FacTipoCambio,

				fac.FacCancelado,
				fac.FacObsequio,
				fac.FacSpot,
				
				fac.FacConcepto,
				fac.FacTipo,
				
				
				fac.FacDatoAdicional1,
				fac.FacDatoAdicional2,
				fac.FacDatoAdicional3,
				fac.FacDatoAdicional4,
				fac.FacDatoAdicional5,
				fac.FacDatoAdicional6,
				fac.FacDatoAdicional7,
				fac.FacDatoAdicional8,
				fac.FacDatoAdicional9,
				fac.FacDatoAdicional10,
				
				fac.FacDatoAdicional11,
				fac.FacDatoAdicional12,
				fac.FacDatoAdicional13,
				fac.FacDatoAdicional14,
				fac.FacDatoAdicional15,
				fac.FacDatoAdicional16,
				fac.FacDatoAdicional17,
				fac.FacDatoAdicional18,
				fac.FacDatoAdicional19,
				fac.FacDatoAdicional20,
				
				fac.FacDatoAdicional21,
				fac.FacDatoAdicional22,
				fac.FacDatoAdicional23,
				fac.FacDatoAdicional24,
				fac.FacDatoAdicional25,
				fac.FacDatoAdicional26,
fac.FacDatoAdicional27,
fac.FacDatoAdicional28,
				
				fac.FacObservado,
				fac.FacEstado,	
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
DATE_FORMAT(fac.FacTiempoCreacion, "%H:%i:%s") AS "FacHoraEmision",

				DATE_FORMAT(fac.FacFechaVencimiento, "%d/%m/%Y") AS "NFacFechaVencimiento",

				fac.FacPorcentajeImpuestoVenta,
				fac.FacPorcentajeImpuestoSelectivo,
				fac.FacDireccion,
				
				IF(fac.FacEstado=6,0.00,fac.FacTotalImpuestoSelectivo) AS "FacTotalImpuestoSelectivo",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalGravado) AS "FacTotalGravado",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalDescuento) AS "FacTotalDescuento",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalGratuito) AS "FacTotalGratuito",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalExonerado) AS "FacTotalExonerado",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalPagar) AS "FacTotalPagar",	
				

				IF(fac.FacEstado=6,0.00,fac.FacSubTotal) AS "FacSubTotal",	
				IF(fac.FacEstado=6,0.00,fac.FacImpuesto) AS "FacImpuesto",	
				IF(fac.FacEstado=6,0.00,fac.FacTotal) AS "FacTotal",	

				IF(reg.RegAplicacion=2,fac.FacTotal+IFNULL(fac.FacRegimenMonto,0),fac.FacTotal-IFNULL(fac.FacRegimenMonto,0)) AS "FacTotalReal",
				
											
				fac.FacObservacion,
fac.FacObservacionCaja,
fac.FacLeyenda,
				fac.FacCierre,
			
				fac.RegId,
				fac.FacRegimenPorcentaje,
				fac.FacRegimenMonto,
				fac.FacRegimenComprobanteNumero,
				DATE_FORMAT(fac.FacRegimenComprobanteFecha, "%d/%m/%Y") AS "NFacRegimenComprobanteFecha",
				
				fac.FacSunatRespuestaTicket,
				fac.FacSunatRespuestaTicketEstado,
				fac.FacSunatRespuestaObservacion,
				
				fac.FacSunatRespuestaEnvioTicket,
				fac.FacSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(fac.FacSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NFacSunatRespuestaEnvioFecha",
				fac.FacSunatRespuestaEnvioHora,
				fac.FacSunatRespuestaEnvioCodigo,
				fac.FacSunatRespuestaEnvioContenido,
				
				fac.FacSunatRespuestaBajaTicket,
				fac.FacSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(fac.FacSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NFacSunatRespuestaBajaFecha",
				fac.FacSunatRespuestaBajaHora,				
				fac.FacSunatRespuestaBajaCodigo,
				fac.FacSunatRespuestaBajaContenido,
				fac.FacSunatRespuestaBajaId,
				
				fac.FacSunatRespuestaConsultaCodigo,
				fac.FacSunatRespuestaConsultaContenido,
				DATE_FORMAT(fac.FacSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NFacSunatRespuestaConsultaFecha",
				fac.FacSunatRespuestaConsultaHora,
				
				DATE_FORMAT(fac.FacSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(fac.FacSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(fac.FacSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaBajaTiempoCreacion",
				fac.FacSunatUltimaAccion,
				fac.FacSunatUltimaRespuesta,
				
				
				
				DATE_FORMAT(fac.FacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacTiempoCreacion",
                DATE_FORMAT(fac.FacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFacTiempoModificacion",

				(SELECT COUNT(fde.FdeId) FROM tblfdefacturadetalle fde WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId) AS "FacTotalItems",
				
				npa.NpaNombre,
				
				fta.FtaNumero,
				
				reg.RegAplicacion,
				reg.RegNombre,
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.TdoId,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliEmailFacturacion,
				cli.CliCelular,
				cli.CliFax,		
				cli.CliClaveElectronica,	
				
				mon.MonNombre,
				mon.MonSimbolo,
				mon.MonSigla,
				
				fim.FinId,
				amo.FccId,
				amo.CprId,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					pag.PagId
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.FacId = fac.FacId
						AND cpc.FtaId = fac.FtaId)						
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FacTieneAbono,
				
				
				@Amortizado:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.FacId = fac.FacId
						AND cpc.FtaId = fac.FtaId)
						AND pag.PagEstado = 3
				) AS FacMontoAmortizado,
				
				/*
				@AmortizadoOtro:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS FacMontoAmortizadoOtro,
				*/
				
				
				@AmortizadoOtroVehiculo:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE pac.OvvId = fac.OvvId
					AND pag.PagEstado = 3
				) AS FacMontoAmortizadoOtroVehiculo,
				
				
				(
					(fac.FacTotal/IFNULL(fac.FacTipoCambio,1)) - IFNULL(@Amortizado,0) 
				) AS FacMontoPendiente,
				
				
				IF(IFNULL(	
				( (fac.FacTotal/IFNULL(fac.FacTipoCambio,1)) - IFNULL(@Amortizado,0) - IFNULL(@AmortizadoOtro,0) - IFNULL(@AmortizadoOtroVehiculo,0)  
				),0) > 0 ,2,1) AS NFacCancelado,
				
				
				vdi.VdiId,
				vdi.VdiOrdenCompraNumero,
				vdi.VdiArchivo,
				
				
				amo.AmoTipo,
				amo.AmoSubTipo,
				
				
				(
					SELECT 
					vdi.VdiCodigoExterno
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
							LEFT JOIN tblvdiventadirecta vdi
							ON amo.VdiId = vdi.VdiId
					WHERE vdi.VdiCodigoExterno IS NOT NULL
					AND fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId		
					AND  vdi.VdiCodigoExterno != ""	
					LIMIT 1
				) AS VdiCodigoExterno		,
				
				(
					SELECT 
					eco.EcoPorcentaje
					FROM tblecopersonalcomision eco
					WHERE eco.CliId = fac.CliId
						AND eco.EcoFecha <= vdi.VdiFecha 
						AND eco.MonId = fac.MonId
					ORDER BY eco.EcoFecha DESC
					LIMIT 1
				) AS FacPorcentajeComision,
				
				fac.FacPagoComision,
				
				tdo.TdoNombre,
				tdo.TdoCodigo
			
				
				FROM tblfacfactura fac
					LEFT JOIN tblnpacondicionpago npa
					ON fac.NpaId = npa.NpaId
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							LEFT JOIN tblregregimen reg
							ON fac.RegId = reg.RegId
							
								LEFT JOIN tblclicliente cli
								ON fac.CliId = cli.CliId
								
									LEFT JOIN tblmonmoneda mon
									ON fac.MonId = mon.MonId
									
									LEFT JOIN tblamoalmacenmovimiento amo
										ON fac.AmoId = amo.AmoId
										
											LEFT JOIN tblvdiventadirecta vdi
											ON amo.VdiId = vdi.VdiId
											
											LEFT JOIN tblfccfichaaccion fcc
											ON amo.FccId = fcc.FccId
											
												LEFT JOIN tblfimfichaingresomodalidad fim
												ON fcc.FimId = fim.FimId
												
													LEFT JOIN tblovvordenventavehiculo ovv
													ON fac.OvvId = ovv.OvvId
													
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
					
														LEFT JOIN tblfinfichaingreso fin
														ON fim.FinId = fin.FinId
															
															
															/*LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId*/
															
															
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$fecha.	$noprocesado.$talonario.$tcexterno.$credito.$regimen.$npago.$moneda.$cliente.$ncredito.$amovimiento.$dvencer.$pagado.$ovvehiculo.$ovvehiculo.$vdirecta.$vendedor.$cancelado.$orden.$paginacion;
				
		
		/*
			IF(

					(IFNULL((
						SELECT 
						ROUND(SUM((pag.PagMonto/pag.PagTipoCambio)),0)
						FROM tblpacpagocomprobante pac
							LEFT JOIN tblpagpago pag
							ON pac.PagId = pag.PagId
						WHERE pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
						LIMIT 1
					),0)) >= ROUND(fac.FacTotal,0)
					
					,"SI"
					,"NO"
				
				) AS FacPagado
		*/
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFactura = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Factura = new $InsFactura();
                    $Factura->FacId = $fila['FacId'];
					$Factura->FtaId = $fila['FtaId'];
					$Factura->SucId = $fila['SucId'];
                    $Factura->UsuId= $fila['UsuId'];
					
					$Factura->CliId= $fila['CliId'];

					
					$Factura->GreId= $fila['GreId'];
					$Factura->GrtId= $fila['GrtId'];
					
					$Factura->NpaId= $fila['NpaId'];
					$Factura->AmoId= $fila['AmoId'];
					$Factura->OvvId= $fila['OvvId'];
					$Factura->FccId= $fila['FccId'];
					
					$Factura->PagId = $fila['PagId'];
					
					
					$Factura->FacNotaEntrega = $fila['FacNotaEntrega'];
					$Factura->FacNotaCredito = $fila['FacNotaCredito'];	
					$Factura->FacNotaDebito = $fila['FacNotaDebito'];					
					
					$Factura->FacSIAFNumero = $fila['FacSIAFNumero'];
					$Factura->FacOrdenNumero = $fila['FacOrdenNumero'];
					$Factura->FacOrdenFecha = $fila['NFacOrdenFecha'];
					$Factura->FacOrdenTipo = $fila['FacOrdenTipo'];
					$Factura->FacOrdenFoto = $fila['FacOrdenFoto'];
					$Factura->FacCantidadDia = $fila['FacCantidadDia'];
					$Factura->FacDiaVencido = $fila['FacDiaVencido'];
					
					$Factura->FacFechaVencimiento = $fila['NFacFechaVencimiento'];
					$Factura->FacDiaTranscurrido = $fila['FacDiaTranscurrido'];
				

					$Factura->FacIncluyeImpuesto = $fila['FacIncluyeImpuesto'];
					$Factura->MonId = $fila['MonId'];
					$Factura->FacTipoCambio = $fila['FacTipoCambio'];
					
					
					$Factura->FacCancelado = $fila['FacCancelado'];
					
					$Factura->FacObsequio = $fila['FacObsequio'];
					$Factura->FacSpot = $fila['FacSpot'];
					
					$Factura->FacConcepto = $fila['FacConcepto'];
					$Factura->FacTipo = $fila['FacTipo'];
					
					
								$Factura->FacDatoAdicional1 = $fila['FacDatoAdicional1'];
					$Factura->FacDatoAdicional2 = $fila['FacDatoAdicional2'];
					$Factura->FacDatoAdicional3 = $fila['FacDatoAdicional3'];
					$Factura->FacDatoAdicional4 = $fila['FacDatoAdicional4'];
					$Factura->FacDatoAdicional5 = $fila['FacDatoAdicional5'];
					$Factura->FacDatoAdicional6 = $fila['FacDatoAdicional6'];
					$Factura->FacDatoAdicional7 = $fila['FacDatoAdicional7'];
					$Factura->FacDatoAdicional8 = $fila['FacDatoAdicional8'];
					$Factura->FacDatoAdicional9 = $fila['FacDatoAdicional9'];
					$Factura->FacDatoAdicional10 = $fila['FacDatoAdicional10'];
					
					$Factura->FacDatoAdicional11 = $fila['FacDatoAdicional11'];
					$Factura->FacDatoAdicional12 = $fila['FacDatoAdicional12'];
					$Factura->FacDatoAdicional13 = $fila['FacDatoAdicional13'];
					$Factura->FacDatoAdicional14 = $fila['FacDatoAdicional14'];
					$Factura->FacDatoAdicional15 = $fila['FacDatoAdicional15'];
					$Factura->FacDatoAdicional16 = $fila['FacDatoAdicional16'];
					$Factura->FacDatoAdicional17 = $fila['FacDatoAdicional17'];
					$Factura->FacDatoAdicional18 = $fila['FacDatoAdicional18'];
					$Factura->FacDatoAdicional19 = $fila['FacDatoAdicional19'];
					$Factura->FacDatoAdicional20 = $fila['FacDatoAdicional20'];
					
					$Factura->FacDatoAdicional21 = $fila['FacDatoAdicional21'];
					$Factura->FacDatoAdicional22 = $fila['FacDatoAdicional22'];
					$Factura->FacDatoAdicional23 = $fila['FacDatoAdicional23'];
					$Factura->FacDatoAdicional24 = $fila['FacDatoAdicional24'];
					$Factura->FacDatoAdicional25 = $fila['FacDatoAdicional25'];
					$Factura->FacDatoAdicional26 = $fila['FacDatoAdicional26'];
					
					$Factura->FacDatoAdicional27 = $fila['FacDatoAdicional27'];
					$Factura->FacDatoAdicional28 = $fila['FacDatoAdicional28'];
					
					$Factura->FacEstado = $fila['FacEstado'];
					$Factura->FacFechaEmision = $fila['NFacFechaEmision'];
					$Factura->FacHoraEmision = $fila['FacHoraEmision'];
					
					
					$Factura->FacFechaVencimiento = $fila['NFacFechaVencimiento'];

					$Factura->FacPorcentajeImpuestoVenta = $fila['FacPorcentajeImpuestoVenta']; 
					$Factura->FacPorcentajeImpuestoSelectivo = $fila['FacPorcentajeImpuestoSelectivo']; 
					$Factura->FacDireccion = $fila['FacDireccion']; 

					$Factura->FacTotalBruto = $fila['FacTotalBruto']; 	
					
					
					
				
					$Factura->FacTotalImpuestoSelectivo = $fila['FacTotalImpuestoSelectivo']; 
					$Factura->FacTotalGravado = $fila['FacTotalGravado']; 
					$Factura->FacTotalDescuento = $fila['FacTotalDescuento']; 
					$Factura->FacTotalGratuito = $fila['FacTotalGratuito']; 
					$Factura->FacTotalExonerado = $fila['FacTotalExonerado']; 
					$Factura->FacTotalPagar = $fila['FacTotalPagar']; 
					
					$Factura->FacSubTotal = $fila['FacSubTotal']; 
					$Factura->FacDescuento = $fila['FacDescuento']; 
					$Factura->FacImpuesto = $fila['FacImpuesto']; 
					$Factura->FacTotal = $fila['FacTotal']; 
					$Factura->FacTotalReal = $fila['FacTotalReal']; 

					list($Factura->FacObservacion,$Factura->FacObservacionImpresa) = explode("###",$fila['FacObservacion']);
						$Factura->FacObservacionCaja = $fila['FacObservacionCaja'];								
					$Factura->FacLeyenda = $fila['FacLeyenda'];
					$Factura->FacCierre = $fila['FacCierre'];
					
					$Factura->RegId = $fila['RegId'];
					$Factura->FacRegimenPorcentaje = $fila['FacRegimenPorcentaje'];
					$Factura->FacRegimenMonto = $fila['FacRegimenMonto'];
					$Factura->FacRegimenComprobanteNumero = $fila['FacRegimenComprobanteNumero'];
					$Factura->FacRegimenComprobanteFecha = $fila['NFacRegimenComprobanteFecha'];
				
					$Factura->FacSunatRespuestaTicket = $fila['FacSunatRespuestaTicket'];
					$Factura->FacSunatRespuestaTicketEstado = $fila['FacSunatRespuestaTicketEstado'];
					$Factura->FacSunatRespuestaObservacion = $fila['FacSunatRespuestaObservacion'];

					$Factura->FacSunatRespuestaEnvioTicket = $fila['FacSunatRespuestaEnvioTicket'];
					$Factura->FacSunatRespuestaEnvioTicketEstado = $fila['FacSunatRespuestaEnvioTicketEstado'];
					$Factura->FacSunatRespuestaEnvioCodigo = $fila['FacSunatRespuestaEnvioCodigo'];
					$Factura->FacSunatRespuestaEnvioContenido = $fila['FacSunatRespuestaEnvioContenido'];
					$Factura->FacSunatRespuestaEnvioFecha = $fila['NFacSunatRespuestaEnvioFecha'];
					$Factura->FacSunatRespuestaEnvioHora = $fila['FacSunatRespuestaEnvioHora'];
					
					$Factura->FacSunatRespuestaBajaTicket = $fila['FacSunatRespuestaBajaTicket']; 	
					$Factura->FacSunatRespuestaBajaTicketEstado = $fila['FacSunatRespuestaBajaTicketEstado'];
					$Factura->FacSunatRespuestaBajaFecha = $fila['NFacSunatRespuestaBajaFecha'];
					$Factura->FacSunatRespuestaBajaHora = $fila['FacSunatRespuestaBajaHora']; 	
					$Factura->FacSunatRespuestaBajaCodigo = $fila['FacSunatRespuestaBajaCodigo']; 	
					$Factura->FacSunatRespuestaBajaContenido = $fila['FacSunatRespuestaBajaContenido']; 	
					$Factura->FacSunatRespuestaBajaId = $fila['FacSunatRespuestaBajaId']; 	
					
					$Factura->FacSunatRespuestaConsultaCodigo = $fila['FacSunatRespuestaConsultaCodigo']; 	
					$Factura->FacSunatRespuestaConsultaContenido = $fila['FacSunatRespuestaConsultaContenido']; 	
					$Factura->FacSunatRespuestaConsultaFecha = $fila['NFacSunatRespuestaConsultaFecha']; 	
					$Factura->FacSunatRespuestaConsultaHora = $fila['FacSunatRespuestaConsultaHora']; 	
					
					$Factura->FacSunatRespuestaEnvioTiempoCreacion = $fila['NFacSunatRespuestaEnvioTiempoCreacion']; 	
					$Factura->FacSunatRespuestaConsultaTiempoCreacion = $fila['NFacSunatRespuestaConsultaTiempoCreacion']; 	
					$Factura->FacSunatRespuestaBajaTiempoCreacion = $fila['NFacSunatRespuestaBajaTiempoCreacion']; 	
					
					$Factura->FacSunatUltimaAccion = $fila['FacSunatUltimaAccion']; 	
					$Factura->FacSunatUltimaRespuesta = $fila['FacSunatUltimaRespuesta']; 	
					
					$Factura->FacObservado = $fila['FacObservado']; 
                    $Factura->FacTiempoCreacion = $fila['NFacTiempoCreacion'];
                    $Factura->FacTiempoModificacion = $fila['NFacTiempoModificacion'];
					
					$Factura->FacTotalItems = $fila['FacTotalItems'];
					
					$Factura->NpaNombre = $fila['NpaNombre'];
					
					$Factura->FtaNumero = $fila['FtaNumero'];
					
					$Factura->RegAplicacion = $fila['RegAplicacion'];
					$Factura->RegNombre = $fila['RegNombre'];
					
					if($Factura->FacEstado == 6){

					
						$Factura->CliNombre = "ANULADO";
						$Factura->CliNombreCompleto = "ANULADO";
						$Factura->CliApellidoPaterno = "";
						$Factura->CliApellidoMaterno = "";
							
					}else{
						$Factura->CliNombre = $fila['CliNombre'];
						$Factura->CliNombreCompleto = $fila['CliNombreCompleto'];
						$Factura->CliApellidoPaterno = $fila['CliApellidoPaterno'];
						$Factura->CliApellidoMaterno = $fila['CliApellidoMaterno'];
							
					}
					
					
					
					
					$Factura->TdoId = $fila['TdoId'];
					$Factura->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$Factura->CliTelefono = $fila['CliTelefono'];
					$Factura->CliEmail = $fila['CliEmail'];
					$Factura->CliEmailFacturacion = $fila['CliEmailFacturacion'];
					$Factura->CliCelular = $fila['CliCelular'];
					$Factura->CliFax = $fila['CliFax'];
					$Factura->CliClaveElectronica = $fila['CliClaveElectronica'];
					
					$Factura->MonNombre = $fila['MonNombre'];
					$Factura->MonSimbolo = $fila['MonSimbolo'];
					$Factura->MonSigla = $fila['MonSigla'];
					
					$Factura->FinId = $fila['FinId'];
					$Factura->FccId = $fila['FccId'];
					$Factura->CprId = $fila['CprId'];
					
					$Factura->FacTieneAbono = $fila['FacTieneAbono'];
					
					$Factura->FacMontoAmortizado = $fila['FacMontoAmortizado'];
					$Factura->FacMontoPendiente = $fila['FacMontoPendiente'];
					$Factura->FacCancelado = $fila['NFacCancelado'];
					
					$Factura->VdiId = $fila['VdiId'];
					$Factura->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$Factura->VdiArchivo = $fila['VdiArchivo'];
					
					$Factura->AmoTipo = $fila['AmoTipo'];
					$Factura->AmoSubTipo = $fila['AmoSubTipo'];
					$Factura->VdiCodigoExterno = $fila['VdiCodigoExterno'];
					
					$Factura->FacPagoComision = $fila['FacPagoComision'];
					$Factura->FacPorcentajeComision = $fila['FacPorcentajeComision'];
					$Factura->FacPagado = $fila['FacPagado'];
					
						
$Factura->TdoNombre = $fila['TdoNombre'];
$Factura->TdoCodigo = $fila['TdoCodigo'];
					
				switch($Factura->FacEstado){
					case 1:
						$Factura->FacEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$Factura->FacEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$Factura->FacEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$Factura->FacEstadoDescripcion = "Reservado";
					break;
					
					
				}
				
				
				switch($Factura->FacEstado){
					case 1:
						$Factura->FacEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 5:
						$Factura->FacEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$Factura->FacEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					case 7:
						$Factura->FacEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
					
					
				}
				
				
					$Factura->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $Factura;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	






}
?>