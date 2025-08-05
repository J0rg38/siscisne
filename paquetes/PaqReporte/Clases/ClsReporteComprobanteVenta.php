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




/*



// public function MtdObtenerFacturas2($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL) {
	
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
				
					$cancelado = ' AND  FacCancelado = 1 ';
					
				break;
				
				case "No":
				
					$cancelado = '  AND FacCancelado = 2 ';
					
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
															
														
															
				 							
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$fecha.	$noprocesado.$talonario.$tcexterno.$credito.$regimen.$npago.$moneda.$cliente.$ncredito.$amovimiento.$dvencer.$pagado.$ovvehiculo.$ovvehiculo.$vdirecta.$vendedor.$cancelado.$orden.$paginacion;
				
		
		
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
					//$Factura->FacCancelado = $fila['NFacCancelado'];
					
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
		}*/
	




   public function MtdObtenerBoletaVentaVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
	


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
					bde.BdeId
					FROM tblbdeboletadetalle bde
						
					WHERE 
						bde.BolId = bol.BolId AND
						bde.BtaId = bol.BtaId AND
						
						(
						bde.BdeDescripcion LIKE "%'.$oFiltro.'%" 
						
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
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (bol.BolEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
						
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oTalonario)){
			$talonario = ' AND bol.BtaId = "'.$oTalonario.'"';
		}
		
		
		if(!empty($oRegimen)){
			$regimen = ' AND bol.RegId = "'.$oRegimen.'"';
		}
		
		
		if(!empty($oCondicionPago)){
			$npago = ' AND bol.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND bol.MonId = "'.$oMoneda.'"';
		}
			

		if(!empty($oAlmacenMovimiento)){
			$amovimiento = ' AND bol.AmoId = "'.$oAlmacenMovimiento.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND bol.CliId = "'.$oCliente.'"';
		}

		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND bol.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}

		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND amo.VdiId = "'.$oVentaDirecta.'"';
		}
		

		
		if(!empty($oVendedor)){
			$vendedor = ' AND vdi.PerId = "'.$oVendedor.'" OR ovv.PerId = "'.$oVendedor.'" ';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND bol.SucId = "'.$oSucursal.'"';
		}
		
		
		if(($oNoProcesdado)){

			$noprocesado = ' AND	(bol.BolSunatRespuestaEnvioContenido NOT LIKE "%aceptad%" 
				OR bol.BolSunatRespuestaEnvioContenido IS NULL 
				OR bol.BolSunatRespuestaEnvioContenido  = ""
				
				) ';
		}
		
							
		if(!empty($oCancelado)){
			switch($oCancelado){
				
				case "Si":
				
					$cancelado = ' AND BolCancelado = 1 ';
					
				break;
				
				case "No":
				
					$cancelado = ' AND BolCancelado = 2 ';
					
				break;
				
			}
			
		}
			
		if(($oSinPago)){

			$sinpago = ' AND 
			
			(
			IFNULL
			
			(
				
				(
			
					SELECT 
					SUM(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						
					WHERE pac.BolId = bol.BolId AND pac.BtaId = bol.BtaId
					AND pag.PagEstado = 3
					
					LIMIT 1
				
				) ,0 
				
			) <  bol.BolTotal/IFNULL(bol.BolTipoCambio,1) 
			
			) AND bol.OvvId IS NULL
			
			';
			
		}
		
		if(!empty($oDiaVencido)){
			
			if($oDiasVencido==-1){
				$oDiasVencido = 0;
			}
			
			$dvencido = ' AND DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) =  ' .$oDiasVencido;
		}
			
			
		if($oVencido){
			$vencido = ' AND DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) > 0 ';
		}
		
						
		if(!empty($oObsequio)){
			$obsequio = ' AND bol.BolObsequio = '.$oObsequio.' ';
		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				bol.BolId,
				bol.BtaId,
				bol.SucId,
				
				bol.UsuId,
				bol.CliId,
				
				bol.NpaId,
				
				bol.AmoId,
				bol.OvvId,
				
				bol.PagId,
				
				CASE
				WHEN EXISTS (
					SELECT ncr.NcrId
						FROM tblncrnotacredito ncr
								WHERE ncr.BolId = bol.BolId 
									AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
								/*	AND ncr.BolId IS NULL 
									AND ncr.BtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaCredito,
				
				
				CASE
				WHEN EXISTS (
					SELECT ndb.NdbId
						FROM tblndbnotadebito ndb
								WHERE ndb.BolId = bol.BolId 
									AND ndb.BtaId = bol.BtaId
									AND ndb.NdbEstado <> 6
									/*AND ndb.FacId IS NULL 
									AND ndb.FtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaDebito,	
				
				
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
DATE_FORMAT(bol.BolTiempoCreacion, "%H:%i:%s") AS "BolHoraEmision",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				bol.BolPorcentajeImpuestoVenta,
				bol.BolPorcentajeImpuestoSelectivo,
				bol.BolDireccion,
				
				IF(bol.BolEstado=6,0.00,bol.BolTotalImpuestoSelectivo) AS "BolTotalImpuestoSelectivo",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalGravado) AS "BolTotalGravado",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalDescuento) AS "BolTotalDescuento",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalGratuito) AS "BolTotalGratuito",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalExonerado) AS "BolTotalExonerado",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalPagar) AS "BolTotalPagar",	
				
				IF(bol.BolEstado=6,0.00,bol.BolSubTotal) AS "BolSubTotal",	
				IF(bol.BolEstado=6,0.00,bol.BolImpuesto) AS "BolImpuesto",
				IF(bol.BolEstado=6,0.00,bol.BolTotal) AS "BolTotal",
		
				IF(reg.RegAplicacion=2,bol.BolTotal+IFNULL(bol.BolRegimenMonto,0),bol.BolTotal-IFNULL(bol.BolRegimenMonto,0)) AS "BolTotalReal",
		
				bol.BolObservacion,
bol.BolObservacionCaja,
				bol.BolLeyenda,
				
				bol.BolCancelado,
				bol.BolCantidadDia,
				DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) AS BolDiaVencido,
				
				DATE_FORMAT(bol.BolFechaVencimiento, "%d/%m/%Y") AS "NBolFechaVencimiento",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				bol.MonId,
				bol.BolTipoCambio,
				bol.MonId,
				bol.BolTipoCambio,
				bol.BolObsequio,
				
					
				bol.BolDatoAdicional1,
				bol.BolDatoAdicional2,
				bol.BolDatoAdicional3,
				bol.BolDatoAdicional4,
				bol.BolDatoAdicional5,
				bol.BolDatoAdicional6,
				bol.BolDatoAdicional7,
				bol.BolDatoAdicional8,
				bol.BolDatoAdicional9,
				bol.BolDatoAdicional10,
				
				bol.BolDatoAdicional11,
				bol.BolDatoAdicional12,
				bol.BolDatoAdicional13,
				bol.BolDatoAdicional14,
				bol.BolDatoAdicional15,
				bol.BolDatoAdicional16,
				bol.BolDatoAdicional17,
				bol.BolDatoAdicional18,
				bol.BolDatoAdicional19,
				bol.BolDatoAdicional20,
				
				bol.BolDatoAdicional21,
				bol.BolDatoAdicional22,
				bol.BolDatoAdicional23,
				bol.BolDatoAdicional24,
				bol.BolDatoAdicional25,
				bol.BolDatoAdicional26,
				
				bol.BolDatoAdicional27,
				bol.BolDatoAdicional28,
				
				bol.BolEstado,	
				bol.BolCierre,	
				
				bol.RegId,
				bol.BolRegimenPorcentaje,
				bol.BolRegimenMonto,
				bol.BolRegimenComprobanteNumero,
				DATE_FORMAT(bol.BolRegimenComprobanteFecha, "%d/%m/%Y") AS "NBolRegimenComprobanteFecha",
				
					
				bol.BolSunatRespuestaTicket,
				bol.BolSunatRespuestaTicketEstado,
				bol.BolSunatRespuestaObservacion,
				
				bol.BolSunatRespuestaEnvioTicket,
				bol.BolSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(bol.BolSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NBolSunatRespuestaEnvioFecha",
				bol.BolSunatRespuestaEnvioHora,
				bol.BolSunatRespuestaEnvioCodigo,
				bol.BolSunatRespuestaEnvioContenido,
				
				bol.BolSunatRespuestaBajaTicket,
				bol.BolSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(bol.BolSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaBajaFecha",
				bol.BolSunatRespuestaBajaHora,				
				bol.BolSunatRespuestaBajaCodigo,
				bol.BolSunatRespuestaBajaContenido,
				bol.BolSunatRespuestaBajaId,
				
				bol.BolSunatRespuestaConsultaCodigo,
				bol.BolSunatRespuestaConsultaContenido,
				DATE_FORMAT(bol.BolSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaConsultaFecha",
				bol.BolSunatRespuestaConsultaHora,
				
				DATE_FORMAT(bol.BolSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaBajaTiempoCreacion",
				bol.BolSunatUltimaAccion,
				bol.BolSunatUltimaRespuesta,
				
				bol.BolObservado,
				DATE_FORMAT(bol.BolTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoCreacion",
                DATE_FORMAT(bol.BolTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoModificacion",
				
				(SELECT COUNT(bde.BdeId) FROM tblbdeboletadetalle bde WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId ) AS "BolTotalItems",
				
				
				npa.NpaNombre,
				
				bta.BtaNumero,
				
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
				cli.CliCelular,
				cli.CliFax,
				
				
				cli.CliDireccion,
				cli.CliDistrito,
				cli.CliProvincia,
				cli.CliDepartamento,
				
				
				mon.MonNombre,
				mon.MonSimbolo,
				mon.MonSigla,
				
				fim.FinId,
				amo.CprId,
				
				
								
				CASE
				WHEN EXISTS (
					SELECT 
					pag.PagId
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.BolId = bol.BolId
						AND cpc.BtaId = bol.BtaId)						
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS BolTieneAbono,
				
			
				
				
				
				@Amortizado:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.BolId = bol.BolId
						AND pac.BtaId = bol.BtaId)
						AND pag.PagEstado = 3
				) AS BolMontoAmortizado,
				
				/*@AmortizadoOtro:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtro,*/
				
				@AmortizadoOtroVehiculo:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE pac.OvvId = bol.OvvId
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtroVehiculo,
				
				
				(
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) 
				) AS BolMontoPendiente,
				
				
				IF(IFNULL((
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) - IFNULL(@AmortizadoOtro,0)  - IFNULL(@AmortizadoOtroVehiculo,0)
				),0)>0,2,1) AS NBolCancelado,
				
				
				vdi.VdiId,
				vdi.VdiOrdenCompraNumero,	
				vdi.VdiArchivo,
				
				amo.AmoTipo,
				amo.AmoSubTipo,
				
				tdo.TdoNombre,
				tdo.TdoCodigo,
				
				suc.SucNombre,
				suc.SucSiglas,
				
				
				ein.EinVIN,
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				ein.EinColor,
				ein.EinAnoFabricacion,
				ein.EinAnoModelo,
				
					
				ncr.NcrId,
				nct.NctNumero,
				ncr.NcrTipoCambio,
				ncr.NcrTotal,
				ncr.NcrMotivo,
				
				
				(
				
				SELECT
				CONCAT( IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoPaterno,"")," ",IFNULL(per.PerApellidoMaterno,"") )
				FROM tblovvordenventavehiculo ovv
				LEFT JOIN tblperpersonal per
				ON ovv.PerId = per.PerId				
				
				WHERE bol.OvvId = ovv.OvvId
				LIMIT  1
				 
				) AS BolAsesorVenta
				
				
								
				FROM tblbolboleta bol
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					
					LEFT JOIN tblnpacondicionpago npa
					ON bol.NpaId = npa.NpaId
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
							LEFT JOIN tblregregimen reg
							ON bol.RegId = reg.RegId
								LEFT JOIN tblclicliente cli
								ON bol.CliId = cli.CliId
									LEFT JOIN tblmonmoneda mon
									ON bol.MonId = mon.MonId
										LEFT JOIN tblamoalmacenmovimiento amo
										ON bol.AmoId = amo.AmoId
											LEFT JOIN tblvdiventadirecta vdi
											ON amo.VdiId = vdi.VdiId
											
											LEFT JOIN tblfccfichaaccion fcc
											ON amo.FccId = fcc.FccId
												LEFT JOIN tblfimfichaingresomodalidad fim
												ON fcc.FimId = fim.FimId
													LEFT JOIN tbltdotipodocumento tdo
													ON cli.TdoId = tdo.TdoId
													
													
														LEFT JOIN tblfinfichaingreso fin
														ON fim.FinId = fin.FinId
															
															/*LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId*/
					LEFT JOIN tblovvordenventavehiculo ovv
					ON bol.OvvId = ovv.OvvId
						LEFT JOIN tbleinvehiculoingreso ein
						ON ovv.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
								
					LEFT JOIN tblncrnotacredito ncr
					ON ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
						LEFT JOIN tblnctnotacreditotalonario nct
						ON ncr.NctId = nct.NctId
																											
				WHERE bol.OvvId  IS NOT NULL 
					AND (ncr.NcrEstado <> 6 OR ncr.NcrEstado IS NULL) '.$filtrar.$sucursal.$estado.$sinpago.$dvencido.$obsequio.$fecha.$vendedor.$dvencido.$vencido.$noprocesado.$talonario.$credito.$regimen.$npago.$moneda.$amovimiento.$cliente.$ovvehiculo.$vdirecta.$cancelado.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsBoleta = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Boleta = new $InsBoleta();
                    $Boleta->BolId = $fila['BolId'];
					$Boleta->BtaId = $fila['BtaId'];
					$Boleta->SucId = $fila['SucId'];
					
                    $Boleta->UsuId= $fila['UsuId'];
					$Boleta->CliId= $fila['CliId'];

					$Boleta->NpaId= $fila['NpaId'];
					$Boleta->AmoId= $fila['AmoId'];
					$Boleta->OvvId= $fila['OvvId'];
					
					$Boleta->PagId= $fila['PagId'];
					
					$Boleta->BolNotaCredito = $fila['BolNotaCredito'];
					$Boleta->BolNotaDebito = $fila['BolNotaDebito'];
					
					$Boleta->BolFechaEmision = $fila['NBolFechaEmision'];
					$Boleta->BolHoraEmision = $fila['BolHoraEmision'];
					
					$Boleta->BolDiaTranscurrido = $fila['BolDiaTranscurrido'];
					
					
					$Boleta->BolPorcentajeImpuestoVenta = $fila['BolPorcentajeImpuestoVenta'];
					$Boleta->BolPorcentajeImpuestoSelectivo = $fila['BolPorcentajeImpuestoSelectivo'];
					$Boleta->BolDireccion = $fila['BolDireccion'];

					$Boleta->BolNotaCredito = $fila['BolNotaCredito'];
					$Boleta->BolNotaDebito = $fila['BolNotaDebito'];

					$Boleta->BolTotalImpuestoSelectivo = $fila['BolTotalImpuestoSelectivo']; 	
					$Boleta->BolTotalGravado = $fila['BolTotalGravado']; 
					$Boleta->BolTotalDescuento = $fila['BolTotalDescuento']; 
					$Boleta->BolTotalGratuito = $fila['BolTotalGratuito']; 
					$Boleta->BolTotalExonerado = $fila['BolTotalExonerado']; 
					$Boleta->BolTotalPagar = $fila['BolTotalPagar']; 
					
					$Boleta->BolSubTotal = $fila['BolSubTotal']; 
					$Boleta->BolImpuesto = $fila['BolImpuesto']; 					
					$Boleta->BolTotal = $fila['BolTotal']; 
					$Boleta->BolTotalReal = $fila['BolTotalReal']; 
					
					list($Boleta->BolObservacion,$Boleta->BolObservacionImpresa) = explode("###",$fila['BolObservacion']);	

					$Boleta->BolObservacionCaja = $fila['BolObservacionCaja'];
					$Boleta->BolLeyenda = $fila['BolLeyenda'];
					$Boleta->BolCancelado = $fila['BolCancelado'];
					$Boleta->BolCantidadDia = $fila['BolCantidadDia'];
					
					
					$Boleta->BolDiaVencido = $fila['BolDiaVencido']; 	
					$Boleta->BolFechaVencimiento = $fila['NBolFechaVencimiento']; 	
					$Boleta->BolDiaTranscurrido = $fila['BolDiaTranscurrido']; 	
			
			
					
					$Boleta->MonId = $fila['MonId'];
					$Boleta->BolTipoCambio = $fila['BolTipoCambio'];
					$Boleta->BolObsequio = $fila['BolObsequio'];
					$Boleta->BolTieneAbono = $fila['BolTieneAbono'];
					
					
								$Boleta->BolDatoAdicional1 = $fila['BolDatoAdicional1'];
					$Boleta->BolDatoAdicional2 = $fila['BolDatoAdicional2'];
					$Boleta->BolDatoAdicional3 = $fila['BolDatoAdicional3'];
					$Boleta->BolDatoAdicional4 = $fila['BolDatoAdicional4'];
					$Boleta->BolDatoAdicional5 = $fila['BolDatoAdicional5'];
					$Boleta->BolDatoAdicional6 = $fila['BolDatoAdicional6'];
					$Boleta->BolDatoAdicional7 = $fila['BolDatoAdicional7'];
					$Boleta->BolDatoAdicional8 = $fila['BolDatoAdicional8'];
					$Boleta->BolDatoAdicional9 = $fila['BolDatoAdicional9'];
					$Boleta->BolDatoAdicional10 = $fila['BolDatoAdicional10'];
					
					$Boleta->BolDatoAdicional11 = $fila['BolDatoAdicional11'];
					$Boleta->BolDatoAdicional12 = $fila['BolDatoAdicional12'];
					$Boleta->BolDatoAdicional13 = $fila['BolDatoAdicional13'];
					$Boleta->BolDatoAdicional14 = $fila['BolDatoAdicional14'];
					$Boleta->BolDatoAdicional15 = $fila['BolDatoAdicional15'];
					$Boleta->BolDatoAdicional16 = $fila['BolDatoAdicional16'];
					$Boleta->BolDatoAdicional17 = $fila['BolDatoAdicional17'];
					$Boleta->BolDatoAdicional18 = $fila['BolDatoAdicional18'];
					$Boleta->BolDatoAdicional19 = $fila['BolDatoAdicional19'];
					$Boleta->BolDatoAdicional20 = $fila['BolDatoAdicional20'];
					
					$Boleta->BolDatoAdicional21 = $fila['BolDatoAdicional21'];
					$Boleta->BolDatoAdicional22 = $fila['BolDatoAdicional22'];
					$Boleta->BolDatoAdicional23 = $fila['BolDatoAdicional23'];
					$Boleta->BolDatoAdicional24 = $fila['BolDatoAdicional24'];
					$Boleta->BolDatoAdicional25 = $fila['BolDatoAdicional25'];
					$Boleta->BolDatoAdicional26 = $fila['BolDatoAdicional26'];
					
					$Boleta->BolDatoAdicional27 = $fila['BolDatoAdicional27'];
					$Boleta->BolDatoAdicional28 = $fila['BolDatoAdicional28'];
					
					$Boleta->BolEstado = $fila['BolEstado'];
					$Boleta->BolCierre = $fila['BolCierre'];	
					
					$Boleta->RegId = $fila['RegId'];	
					$Boleta->BolRegimenPorcentaje = $fila['BolRegimenPorcentaje'];	
					$Boleta->BolRegimenMonto = $fila['BolRegimenMonto'];	
					$Boleta->BolRegimenComprobanteNumero = $fila['BolRegimenComprobanteNumero'];	
					$Boleta->BolRegimenComprobanteFecha = $fila['NBolRegimenComprobanteFecha'];	

					$Boleta->BolSunatRespuestaTicket = $fila['BolSunatRespuestaTicket']; 	
					$Boleta->BolSunatRespuestaTicketEstado = $fila['BolSunatRespuestaTicketEstado']; 			
					$Boleta->BolSunatRespuestaObservacion = $fila['BolSunatRespuestaObservacion']; 	
					
					$Boleta->BolSunatRespuestaEnvioTicket = $fila['BolSunatRespuestaEnvioTicket']; 	
					$Boleta->BolSunatRespuestaEnvioTicketEstado = $fila['BolSunatRespuestaEnvioTicketEstado']; 	
					$Boleta->BolSunatRespuestaEnvioFecha = $fila['NBolSunatRespuestaEnvioFecha']; 	
					$Boleta->BolSunatRespuestaEnvioHora = $fila['BolSunatRespuestaEnvioHora']; 	
					$Boleta->BolSunatRespuestaEnvioCodigo = $fila['BolSunatRespuestaEnvioCodigo']; 	
					$Boleta->BolSunatRespuestaEnvioContenido = $fila['BolSunatRespuestaEnvioContenido']; 	
					
					$Boleta->BolSunatRespuestaBajaTicket = $fila['BolSunatRespuestaBajaTicket']; 
					$Boleta->BolSunatRespuestaBajaTicketEstado = $fila['BolSunatRespuestaBajaTicketEstado'];	
					$Boleta->BolSunatRespuestaBajaFecha = $fila['NBolSunatRespuestaBajaFecha']; 	
					$Boleta->BolSunatRespuestaBajaHora = $fila['BolSunatRespuestaBajaHora']; 	
					$Boleta->BolSunatRespuestaBajaCodigo = $fila['BolSunatRespuestaBajaCodigo']; 	
					$Boleta->BolSunatRespuestaBajaContenido = $fila['BolSunatRespuestaBajaContenido']; 	
					$Boleta->BolSunatRespuestaBajaId = $fila['BolSunatRespuestaBajaId']; 	
					
					$Boleta->BolSunatRespuestaConsultaCodigo = $fila['BolSunatRespuestaConsultaCodigo']; 	
					$Boleta->BolSunatRespuestaConsultaContenido = $fila['BolSunatRespuestaConsultaContenido']; 	
					$Boleta->BolSunatRespuestaConsultaFecha = $fila['NBolSunatRespuestaConsultaFecha']; 	
					$Boleta->BolSunatRespuestaConsultaHora = $fila['BolSunatRespuestaConsultaHora']; 	
					
					$Boleta->BolSunatRespuestaEnvioTiempoCreacion = $fila['NBolSunatRespuestaEnvioTiempoCreacion']; 	
					$Boleta->BolSunatRespuestaConsultaTiempoCreacion = $fila['NBolSunatRespuestaConsultaTiempoCreacion']; 	
					$Boleta->BolSunatRespuestaBajaTiempoCreacion = $fila['NBolSunatRespuestaBajaTiempoCreacion']; 
					
					$Boleta->BolSunatUltimaAccion = $fila['BolSunatUltimaAccion']; 
					$Boleta->BolSunatUltimaRespuesta = $fila['BolSunatUltimaRespuesta']; 
					
					$Boleta->BolObservado = $fila['BolObservado']; 
					$Boleta->BolTiempoCreacion = $fila['NBolTiempoCreacion'];
                    $Boleta->BolTiempoModificacion = $fila['NBolTiempoModificacion'];

                    $Boleta->BolTotalItems = $fila['BolTotalItems'];					

					$Boleta->NpaNombre = $fila['NpaNombre'];
					
					$Boleta->BtaNumero = $fila['BtaNumero'];
					
					$Boleta->RegAplicacion = $fila['RegAplicacion'];
					$Boleta->RegNombre = $fila['RegNombre'];
					
					if($Boleta->BolEstado == 6){

						$Boleta->CliNombreCompleto = "ANULADO";
						$Boleta->CliNombre = "ANULADO";
						$Boleta->CliApellidoPaterno = "";
						$Boleta->CliApellidoMaterno = "";
						
					}else{
					
						$Boleta->CliNombreCompleto = $fila['CliNombreCompleto'];
						$Boleta->CliNombre = $fila['CliNombre'];
						$Boleta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
						$Boleta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
						
					}
					$Boleta->CliDireccion = $fila['CliDireccion'];
						$Boleta->CliDistrito = $fila['CliDistrito'];
						$Boleta->CliProvincia = $fila['CliProvincia'];
						$Boleta->CliDepartamento = $fila['CliDepartamento'];
					
					$Boleta->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$Boleta->TdoId = $fila['TdoId'];
					$Boleta->CliTelefono = $fila['CliTelefono'];
					$Boleta->CliEmail = $fila['CliEmail'];
					$Boleta->CliCelular = $fila['CliCelular'];
					$Boleta->CliFax = $fila['CliFax'];
					
					$Boleta->MonNombre = $fila['MonNombre'];
					$Boleta->MonSimbolo = $fila['MonSimbolo'];
					$Boleta->MonSigla = $fila['MonSigla'];
					
					
					$Boleta->FinId = $fila['FinId'];
					$Boleta->CprId = $fila['CprId'];
					
					
					$Boleta->BolMontoAmortizado = $fila['BolMontoAmortizado'];
					$Boleta->BolMontoPendiente = $fila['BolMontoPendiente'];
					//$Boleta->BolCancelado = $fila['NBolCancelado'];
					
					$Boleta->VdiId = $fila['VdiId'];
					$Boleta->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$Boleta->VdiArchivo = $fila['VdiArchivo'];		

					$Boleta->AmoTipo = $fila['AmoTipo'];	
					$Boleta->AmoSubTipo = $fila['AmoSubTipo'];	

					$Boleta->TdoNombre = $fila['TdoNombre'];
					$Boleta->TdoCodigo = $fila['TdoCodigo'];
						
					$Boleta->SucNombre = $fila['SucNombre'];	
					$Boleta->SucSiglas = $fila['SucSiglas'];	
					
					$Boleta->EinVIN = $fila['EinVIN'];	
					$Boleta->VmaNombre = $fila['VmaNombre'];	
					$Boleta->VmoNombre = $fila['VmoNombre'];	
					$Boleta->VveNombre = $fila['VveNombre'];	
					$Boleta->EinColor = $fila['EinColor'];	
					$Boleta->EinAnoFabricacion = $fila['EinAnoFabricacion'];	
					$Boleta->EinAnoModelo = $fila['EinAnoModelo'];	
					
					
					
					$Boleta->NcrId = $fila['NcrId'];	
					$Boleta->NctNumero = $fila['NctNumero'];	
					$Boleta->NcrTipoCambio = $fila['NcrTipoCambio'];	
					$Boleta->NcrTotal = $fila['NcrTotal'];	
					$Boleta->NcrMotivo = $fila['NcrMotivo'];	
					
					$Boleta->BolAsesorVenta = $fila['BolAsesorVenta'];	
					
					
					
				switch($Boleta->BolEstado){
					case 1:
						$Boleta->BolEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$Boleta->BolEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$Boleta->BolEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$Boleta->BolEstadoDescripcion = "Reservado";
					break;
					
					
				}
				
				
								switch($Boleta->BolEstado){
					case 1:
						$Boleta->BolEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 5:
						$Boleta->BolEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$Boleta->BolEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					case 7:
						$Boleta->BolEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
					
				}
				
				
					$Boleta->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $Boleta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}



    public function MtdObtenerFacturaVentaVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
	
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
				
					$cancelado = ' AND FacCancelado = 1 ';
					
				break;
				
				case "No":
				
					$cancelado = '  AND FacCancelado = 2 ';
					
				break;
				
			}
			
		}
		
		if(($oSinPago)){

			$sinpago = ' AND 
			
			(
			
			IFNULL
			
			(
				
				(
			
					SELECT 
					SUM(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						
					WHERE pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
					AND pag.PagEstado = 3
					
					LIMIT 1
				
				) ,0 
				
			) <  fac.FacTotal/IFNULL(fac.FacTipoCambio,1) 
			
			) AND fac.OvvId IS NULL
			
			';
			
		}
		
		
			
		if(!empty($oDiaVencido)){
			
			if($oDiasVencido==-1){
				$oDiasVencido = 0;
			}
			$dvencido = 'AND DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) = ' .$oDiasVencido;
			
		}
		
		
				
		if($oVencido){
			$vencido = ' AND DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) > 0 ';
		}
		
					
		if(!empty($oObsequio)){
			$obsequio = ' AND fac.FacObsequio = '.$oObsequio.' ';
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
				
				cli.CliDireccion,
				cli.CliDistrito,
				cli.CliProvincia,
				cli.CliDepartamento,
				
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
				tdo.TdoCodigo,
				
				
				suc.SucNombre,
				suc.SucSiglas,
				
				
				
				
				
					ein.EinVIN,
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				ein.EinColor,
				ein.EinAnoFabricacion,
				ein.EinAnoModelo,
				
				
				ncr.NcrId,
				nct.NctNumero,
				ncr.NcrTipoCambio,
				ncr.NcrTotal,
				ncr.NcrMotivo,
				
				
				
					(
				
				SELECT
				CONCAT( IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoPaterno,"")," ",IFNULL(per.PerApellidoMaterno,"") )
				FROM tblovvordenventavehiculo ovv
				LEFT JOIN tblperpersonal per
				ON ovv.PerId = per.PerId				
				
				WHERE fac.OvvId = ovv.OvvId
				LIMIT  1
				 
				) AS FacAsesorVenta
				
			
			
				
				FROM tblfacfactura fac
				
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					
					
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
												
												 
													
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
					
														LEFT JOIN tblfinfichaingreso fin
														ON fim.FinId = fin.FinId
															
															
															/*LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId*/
															
					
					LEFT JOIN tblovvordenventavehiculo ovv
					ON fac.OvvId = ovv.OvvId
						LEFT JOIN tbleinvehiculoingreso ein
						ON ovv.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									
						LEFT JOIN tblncrnotacredito ncr
					ON ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
						LEFT JOIN tblnctnotacreditotalonario nct
						ON ncr.NctId = nct.NctId
						
						
																											
				WHERE fac.OvvId  IS NOT NULL
				AND (ncr.NcrEstado <> 6 OR ncr.NcrEstado IS NULL)
				 '.$filtrar.$sucursal.$estado.$fecha.$sinpago .$dvencido.$vencido.	$obsequio.$noprocesado.$talonario.$tcexterno.$credito.$regimen.$npago.$moneda.$cliente.$ncredito.$amovimiento.$dvencer.$pagado.$ovvehiculo.$ovvehiculo.$vdirecta.$vendedor.$cancelado.$orden.$paginacion;
				
		
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
					
					
					$Factura->CliDireccion = $fila['CliDireccion'];
						$Factura->CliDistrito = $fila['CliDistrito'];
						$Factura->CliProvincia = $fila['CliProvincia'];
						$Factura->CliDepartamento = $fila['CliDepartamento'];
					
					
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
					//$Factura->FacCancelado = $fila['NFacCancelado'];
					
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

$Factura->SucNombre = $fila['SucNombre'];	
					$Factura->SucSiglas = $fila['SucSiglas'];	

					
					$Factura->EinVIN = $fila['EinVIN'];	
					$Factura->VmaNombre = $fila['VmaNombre'];	
					$Factura->VmoNombre = $fila['VmoNombre'];	
					$Factura->VveNombre = $fila['VveNombre'];	
					$Factura->EinColor = $fila['EinColor'];	
					$Factura->EinAnoFabricacion = $fila['EinAnoFabricacion'];	
					$Factura->EinAnoModelo = $fila['EinAnoModelo'];	
					
					$Factura->NcrId = $fila['NcrId'];	
					$Factura->NctNumero = $fila['NctNumero'];	
					$Factura->NcrTipoCambio = $fila['NcrTipoCambio'];	
					$Factura->NcrTotal = $fila['NcrTotal'];	
					$Factura->NcrMotivo = $fila['NcrMotivo'];	
					
					
					$Factura->FacAsesorVenta = $fila['FacAsesorVenta'];	
					
					
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
	
	 public function MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL,$oTieneCodigoExterno=NULL,$oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
	
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
				
					$cancelado = ' AND FacCancelado = 1 ';
					
				break;
				
				case "No":
				
					$cancelado = '  AND FacCancelado = 2 ';
					
				break;
				
			}
			
		}
		
		if(($oSinPago)){

			$sinpago = ' AND 
			
			(
			
			IFNULL
			
			(
				
				(
			
					SELECT 
					SUM(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						
					WHERE pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
					AND pag.PagEstado = 3
					
					LIMIT 1
				
				) ,0 
				
			) <  fac.FacTotal/IFNULL(fac.FacTipoCambio,1) 
			
			) AND fac.OvvId IS NULL
			
			';
			
		}
		
		
			
		if(!empty($oDiaVencido)){
			
			if($oDiasVencido==-1){
				$oDiasVencido = 0;
			}
			$dvencido = 'AND DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) = ' .$oDiasVencido;
			
		}
		
		
				
		if($oVencido){
			$vencido = ' AND DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) > 0 ';
		}
		
					
		if(!empty($oObsequio)){
			$obsequio = ' AND fac.FacObsequio = '.$oObsequio.' ';
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
				fac.FacTipoCambioAux,

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
				
				
				
				
				
				IFNULL(
				
				amo.VdiId,
				
						IFNULL(
					
						(
						SELECT
						pac.VdiId
						FROM tblpacpagocomprobante pac
							LEFT JOIN tblpagpago pag
							ON pac.PagId = pag.PagId
						WHERE pag.PagEstado<>6
						AND fac.PagId = pag.PagId
						LIMIT 1
						)
						,""
						)
				
				) AS  VdiId,
				
				
				
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
				tdo.TdoCodigo,
				
				
				suc.SucNombre,
				suc.SucSiglas
			
				
				FROM tblfacfactura fac
				
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					
					
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

						LEFT JOIN tblfaxfacturaexportar fax
					ON fax.FacId = fac.FacId AND fax.FtaId = fac.FtaId		
					
							
															
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$fecha.$sinpago .$dvencido.$vencido.	$obsequio.$noprocesado.$talonario.$tcexterno.$credito.$regimen.$npago.$moneda.$cliente.$ncredito.$amovimiento.$dvencer.$pagado.$ovvehiculo.$ovvehiculo.$vdirecta.$vendedor.$cancelado.$orden.$paginacion;
				
		
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
					$Factura->FacTipoCambioAux = $fila['FacTipoCambioAux'];
					
					
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
					//$Factura->FacCancelado = $fila['NFacCancelado'];
					
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

$Factura->SucNombre = $fila['SucNombre'];	
					$Factura->SucSiglas = $fila['SucSiglas'];	

					
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
	
	
    public function MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
	


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
					bde.BdeId
					FROM tblbdeboletadetalle bde
						
					WHERE 
						bde.BolId = bol.BolId AND
						bde.BtaId = bol.BtaId AND
						
						(
						bde.BdeDescripcion LIKE "%'.$oFiltro.'%" 
						
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
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (bol.BolEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
						
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oTalonario)){
			$talonario = ' AND bol.BtaId = "'.$oTalonario.'"';
		}
		
		
		if(!empty($oRegimen)){
			$regimen = ' AND bol.RegId = "'.$oRegimen.'"';
		}
		
		
		if(!empty($oCondicionPago)){
			$npago = ' AND bol.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND bol.MonId = "'.$oMoneda.'"';
		}
			

		if(!empty($oAlmacenMovimiento)){
			$amovimiento = ' AND bol.AmoId = "'.$oAlmacenMovimiento.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND bol.CliId = "'.$oCliente.'"';
		}

		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND bol.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}

		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND amo.VdiId = "'.$oVentaDirecta.'"';
		}
		

		
		if(!empty($oVendedor)){
			$vendedor = ' AND vdi.PerId = "'.$oVendedor.'" OR ovv.PerId = "'.$oVendedor.'" ';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND bol.SucId = "'.$oSucursal.'"';
		}
		
		
		if(($oNoProcesdado)){

			$noprocesado = ' AND	(bol.BolSunatRespuestaEnvioContenido NOT LIKE "%aceptad%" 
				OR bol.BolSunatRespuestaEnvioContenido IS NULL 
				OR bol.BolSunatRespuestaEnvioContenido  = ""
				
				) ';
		}
		
							
		if(!empty($oCancelado)){
			switch($oCancelado){
				
				case "Si":
				
					//$cancelado = ' HAVING NBolCancelado = 1 ';
					$cancelado = ' AND bol.BolCancelado = 1 ';
					
				break;
				
				case "No":
				
					$cancelado = '  AND bol.BolCancelado = 2 ';//
					//$cancelado = '  HAVING NBolCancelado = 2 ';
					
				break;
				
			}
			
		}
			
		if(($oSinPago)){

			$sinpago = ' AND 
			
			(
			IFNULL
			
			(
				
				(
			
					SELECT 
					SUM(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						
					WHERE pac.BolId = bol.BolId AND pac.BtaId = bol.BtaId
					AND pag.PagEstado = 3
					
					LIMIT 1
				
				) ,0 
				
			) <  bol.BolTotal/IFNULL(bol.BolTipoCambio,1) 
			
			) AND bol.OvvId IS NULL
			
			';
			
		}
		
		if(!empty($oDiaVencido)){
			
			if($oDiasVencido==-1){
				$oDiasVencido = 0;
			}
			
			$dvencido = ' AND DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) =  ' .$oDiasVencido;
		}
			
			
		if($oVencido){
			$vencido = ' AND DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) > 0 ';
		}
		
						
		if(!empty($oObsequio)){
			$obsequio = ' AND bol.BolObsequio = '.$oObsequio.' ';
		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				bol.BolId,
				bol.BtaId,
				bol.SucId,
				
				bol.UsuId,
				bol.CliId,
				
				bol.NpaId,
				
				bol.AmoId,
				bol.OvvId,
				
				bol.PagId,
				
				CASE
				WHEN EXISTS (
					SELECT ncr.NcrId
						FROM tblncrnotacredito ncr
								WHERE ncr.BolId = bol.BolId 
									AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
								/*	AND ncr.BolId IS NULL 
									AND ncr.BtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaCredito,
				
				
				CASE
				WHEN EXISTS (
					SELECT ndb.NdbId
						FROM tblndbnotadebito ndb
								WHERE ndb.BolId = bol.BolId 
									AND ndb.BtaId = bol.BtaId
									AND ndb.NdbEstado <> 6
									/*AND ndb.FacId IS NULL 
									AND ndb.FtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaDebito,	
				
				
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
DATE_FORMAT(bol.BolTiempoCreacion, "%H:%i:%s") AS "BolHoraEmision",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				bol.BolPorcentajeImpuestoVenta,
				bol.BolPorcentajeImpuestoSelectivo,
				bol.BolDireccion,
				
				IF(bol.BolEstado=6,0.00,bol.BolTotalImpuestoSelectivo) AS "BolTotalImpuestoSelectivo",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalGravado) AS "BolTotalGravado",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalDescuento) AS "BolTotalDescuento",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalGratuito) AS "BolTotalGratuito",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalExonerado) AS "BolTotalExonerado",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalPagar) AS "BolTotalPagar",	
				
				IF(bol.BolEstado=6,0.00,bol.BolSubTotal) AS "BolSubTotal",	
				IF(bol.BolEstado=6,0.00,bol.BolImpuesto) AS "BolImpuesto",
				IF(bol.BolEstado=6,0.00,bol.BolTotal) AS "BolTotal",
		
				IF(reg.RegAplicacion=2,bol.BolTotal+IFNULL(bol.BolRegimenMonto,0),bol.BolTotal-IFNULL(bol.BolRegimenMonto,0)) AS "BolTotalReal",
		
				bol.BolObservacion,
bol.BolObservacionCaja,
				bol.BolLeyenda,
				
				bol.BolCancelado,
				bol.BolCantidadDia,
				DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) AS BolDiaVencido,
				
				DATE_FORMAT(bol.BolFechaVencimiento, "%d/%m/%Y") AS "NBolFechaVencimiento",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				bol.MonId,
				bol.BolTipoCambio,
				bol.BolTipoCambioAux,

				bol.BolObsequio,
				
					
				bol.BolDatoAdicional1,
				bol.BolDatoAdicional2,
				bol.BolDatoAdicional3,
				bol.BolDatoAdicional4,
				bol.BolDatoAdicional5,
				bol.BolDatoAdicional6,
				bol.BolDatoAdicional7,
				bol.BolDatoAdicional8,
				bol.BolDatoAdicional9,
				bol.BolDatoAdicional10,
				
				bol.BolDatoAdicional11,
				bol.BolDatoAdicional12,
				bol.BolDatoAdicional13,
				bol.BolDatoAdicional14,
				bol.BolDatoAdicional15,
				bol.BolDatoAdicional16,
				bol.BolDatoAdicional17,
				bol.BolDatoAdicional18,
				bol.BolDatoAdicional19,
				bol.BolDatoAdicional20,
				
				bol.BolDatoAdicional21,
				bol.BolDatoAdicional22,
				bol.BolDatoAdicional23,
				bol.BolDatoAdicional24,
				bol.BolDatoAdicional25,
				bol.BolDatoAdicional26,
				
				bol.BolDatoAdicional27,
				bol.BolDatoAdicional28,
				
				bol.BolEstado,	
				bol.BolCierre,	
				
				bol.RegId,
				bol.BolRegimenPorcentaje,
				bol.BolRegimenMonto,
				bol.BolRegimenComprobanteNumero,
				DATE_FORMAT(bol.BolRegimenComprobanteFecha, "%d/%m/%Y") AS "NBolRegimenComprobanteFecha",
				
					
				bol.BolSunatRespuestaTicket,
				bol.BolSunatRespuestaTicketEstado,
				bol.BolSunatRespuestaObservacion,
				
				bol.BolSunatRespuestaEnvioTicket,
				bol.BolSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(bol.BolSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NBolSunatRespuestaEnvioFecha",
				bol.BolSunatRespuestaEnvioHora,
				bol.BolSunatRespuestaEnvioCodigo,
				bol.BolSunatRespuestaEnvioContenido,
				
				bol.BolSunatRespuestaBajaTicket,
				bol.BolSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(bol.BolSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaBajaFecha",
				bol.BolSunatRespuestaBajaHora,				
				bol.BolSunatRespuestaBajaCodigo,
				bol.BolSunatRespuestaBajaContenido,
				bol.BolSunatRespuestaBajaId,
				
				bol.BolSunatRespuestaConsultaCodigo,
				bol.BolSunatRespuestaConsultaContenido,
				DATE_FORMAT(bol.BolSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaConsultaFecha",
				bol.BolSunatRespuestaConsultaHora,
				
				DATE_FORMAT(bol.BolSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaBajaTiempoCreacion",
				bol.BolSunatUltimaAccion,
				bol.BolSunatUltimaRespuesta,
				
				bol.BolObservado,
				DATE_FORMAT(bol.BolTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoCreacion",
                DATE_FORMAT(bol.BolTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoModificacion",
				
				(SELECT COUNT(bde.BdeId) FROM tblbdeboletadetalle bde WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId ) AS "BolTotalItems",
				
				
				npa.NpaNombre,
				
				bta.BtaNumero,
				
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
				cli.CliCelular,
				cli.CliFax,
				
				mon.MonNombre,
				mon.MonSimbolo,
				mon.MonSigla,
				
				fim.FinId,
				amo.CprId,
				
				
								
				CASE
				WHEN EXISTS (
					SELECT 
					pag.PagId
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.BolId = bol.BolId
						AND cpc.BtaId = bol.BtaId)						
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS BolTieneAbono,
				
			
				
				
				
				@Amortizado:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.BolId = bol.BolId
						AND pac.BtaId = bol.BtaId)
						AND pag.PagEstado = 3
				) AS BolMontoAmortizado,
				
				/*@AmortizadoOtro:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtro,*/
				
				@AmortizadoOtroVehiculo:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE pac.OvvId = bol.OvvId
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtroVehiculo,
				
				
				(
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) 
				) AS BolMontoPendiente,
				
				
				IF(IFNULL((
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) - IFNULL(@AmortizadoOtro,0)  - IFNULL(@AmortizadoOtroVehiculo,0)
				),0)>0,2,1) AS NBolCancelado,
				
				
				
				IFNULL(
				
				amo.VdiId,
				
						IFNULL(
					
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
						,""
						)
				
				) AS  VdiId,
				
				
				
				vdi.VdiOrdenCompraNumero,	
				vdi.VdiArchivo,
				
				amo.AmoTipo,
				amo.AmoSubTipo,
				
				tdo.TdoNombre,
				tdo.TdoCodigo,
				
				suc.SucNombre,
				suc.SucSiglas
								
				FROM tblbolboleta bol
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					
					LEFT JOIN tblnpacondicionpago npa
					ON bol.NpaId = npa.NpaId
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
							LEFT JOIN tblregregimen reg
							ON bol.RegId = reg.RegId
								LEFT JOIN tblclicliente cli
								ON bol.CliId = cli.CliId
									LEFT JOIN tblmonmoneda mon
									ON bol.MonId = mon.MonId
										LEFT JOIN tblamoalmacenmovimiento amo
										ON bol.AmoId = amo.AmoId
											LEFT JOIN tblvdiventadirecta vdi
											ON amo.VdiId = vdi.VdiId
											
											LEFT JOIN tblfccfichaaccion fcc
											ON amo.FccId = fcc.FccId
												LEFT JOIN tblfimfichaingresomodalidad fim
												ON fcc.FimId = fim.FimId
													LEFT JOIN tbltdotipodocumento tdo
													ON cli.TdoId = tdo.TdoId
													
													
														LEFT JOIN tblfinfichaingreso fin
														ON fim.FinId = fin.FinId
															
															/*LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId*/
															
															
					LEFT JOIN tblfaxfacturaexportar fax
					ON fax.BolId = bol.BolId AND fax.BtaId = bol.BtaId
																										
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$sinpago.$dvencido.$obsequio.$fecha.$vendedor.$dvencido.$vencido.$noprocesado.$talonario.$credito.$regimen.$npago.$moneda.$amovimiento.$cliente.$ovvehiculo.$vdirecta.$cancelado.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsBoleta = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Boleta = new $InsBoleta();
                    $Boleta->BolId = $fila['BolId'];
					$Boleta->BtaId = $fila['BtaId'];
					$Boleta->SucId = $fila['SucId'];
					
                    $Boleta->UsuId= $fila['UsuId'];
					$Boleta->CliId= $fila['CliId'];

					$Boleta->NpaId= $fila['NpaId'];
					$Boleta->AmoId= $fila['AmoId'];
					$Boleta->OvvId= $fila['OvvId'];
					
					$Boleta->PagId= $fila['PagId'];
					
					$Boleta->BolNotaCredito = $fila['BolNotaCredito'];
					$Boleta->BolNotaDebito = $fila['BolNotaDebito'];
					
					$Boleta->BolFechaEmision = $fila['NBolFechaEmision'];
					$Boleta->BolHoraEmision = $fila['BolHoraEmision'];
					
					$Boleta->BolDiaTranscurrido = $fila['BolDiaTranscurrido'];
					
					
					$Boleta->BolPorcentajeImpuestoVenta = $fila['BolPorcentajeImpuestoVenta'];
					$Boleta->BolPorcentajeImpuestoSelectivo = $fila['BolPorcentajeImpuestoSelectivo'];
					$Boleta->BolDireccion = $fila['BolDireccion'];

					$Boleta->BolNotaCredito = $fila['BolNotaCredito'];
					$Boleta->BolNotaDebito = $fila['BolNotaDebito'];

					$Boleta->BolTotalImpuestoSelectivo = $fila['BolTotalImpuestoSelectivo']; 	
					$Boleta->BolTotalGravado = $fila['BolTotalGravado']; 
					$Boleta->BolTotalDescuento = $fila['BolTotalDescuento']; 
					$Boleta->BolTotalGratuito = $fila['BolTotalGratuito']; 
					$Boleta->BolTotalExonerado = $fila['BolTotalExonerado']; 
					$Boleta->BolTotalPagar = $fila['BolTotalPagar']; 
					
					$Boleta->BolSubTotal = $fila['BolSubTotal']; 
					$Boleta->BolImpuesto = $fila['BolImpuesto']; 					
					$Boleta->BolTotal = $fila['BolTotal']; 
					$Boleta->BolTotalReal = $fila['BolTotalReal']; 
					
					list($Boleta->BolObservacion,$Boleta->BolObservacionImpresa) = explode("###",$fila['BolObservacion']);	

					$Boleta->BolObservacionCaja = $fila['BolObservacionCaja'];
					$Boleta->BolLeyenda = $fila['BolLeyenda'];
					$Boleta->BolCancelado = $fila['BolCancelado'];
					$Boleta->BolCantidadDia = $fila['BolCantidadDia'];
					
					
					$Boleta->BolDiaVencido = $fila['BolDiaVencido']; 	
					$Boleta->BolFechaVencimiento = $fila['NBolFechaVencimiento']; 	
					$Boleta->BolDiaTranscurrido = $fila['BolDiaTranscurrido']; 	
			
			
					
					$Boleta->MonId = $fila['MonId'];
					$Boleta->BolTipoCambio = $fila['BolTipoCambio'];
					$Boleta->BolTipoCambioAux = $fila['BolTipoCambioAux'];
					
					
					$Boleta->BolObsequio = $fila['BolObsequio'];
					$Boleta->BolTieneAbono = $fila['BolTieneAbono'];
					
					
								$Boleta->BolDatoAdicional1 = $fila['BolDatoAdicional1'];
					$Boleta->BolDatoAdicional2 = $fila['BolDatoAdicional2'];
					$Boleta->BolDatoAdicional3 = $fila['BolDatoAdicional3'];
					$Boleta->BolDatoAdicional4 = $fila['BolDatoAdicional4'];
					$Boleta->BolDatoAdicional5 = $fila['BolDatoAdicional5'];
					$Boleta->BolDatoAdicional6 = $fila['BolDatoAdicional6'];
					$Boleta->BolDatoAdicional7 = $fila['BolDatoAdicional7'];
					$Boleta->BolDatoAdicional8 = $fila['BolDatoAdicional8'];
					$Boleta->BolDatoAdicional9 = $fila['BolDatoAdicional9'];
					$Boleta->BolDatoAdicional10 = $fila['BolDatoAdicional10'];
					
					$Boleta->BolDatoAdicional11 = $fila['BolDatoAdicional11'];
					$Boleta->BolDatoAdicional12 = $fila['BolDatoAdicional12'];
					$Boleta->BolDatoAdicional13 = $fila['BolDatoAdicional13'];
					$Boleta->BolDatoAdicional14 = $fila['BolDatoAdicional14'];
					$Boleta->BolDatoAdicional15 = $fila['BolDatoAdicional15'];
					$Boleta->BolDatoAdicional16 = $fila['BolDatoAdicional16'];
					$Boleta->BolDatoAdicional17 = $fila['BolDatoAdicional17'];
					$Boleta->BolDatoAdicional18 = $fila['BolDatoAdicional18'];
					$Boleta->BolDatoAdicional19 = $fila['BolDatoAdicional19'];
					$Boleta->BolDatoAdicional20 = $fila['BolDatoAdicional20'];
					
					$Boleta->BolDatoAdicional21 = $fila['BolDatoAdicional21'];
					$Boleta->BolDatoAdicional22 = $fila['BolDatoAdicional22'];
					$Boleta->BolDatoAdicional23 = $fila['BolDatoAdicional23'];
					$Boleta->BolDatoAdicional24 = $fila['BolDatoAdicional24'];
					$Boleta->BolDatoAdicional25 = $fila['BolDatoAdicional25'];
					$Boleta->BolDatoAdicional26 = $fila['BolDatoAdicional26'];
					
					$Boleta->BolDatoAdicional27 = $fila['BolDatoAdicional27'];
					$Boleta->BolDatoAdicional28 = $fila['BolDatoAdicional28'];
					
					$Boleta->BolEstado = $fila['BolEstado'];
					$Boleta->BolCierre = $fila['BolCierre'];	
					
					$Boleta->RegId = $fila['RegId'];	
					$Boleta->BolRegimenPorcentaje = $fila['BolRegimenPorcentaje'];	
					$Boleta->BolRegimenMonto = $fila['BolRegimenMonto'];	
					$Boleta->BolRegimenComprobanteNumero = $fila['BolRegimenComprobanteNumero'];	
					$Boleta->BolRegimenComprobanteFecha = $fila['NBolRegimenComprobanteFecha'];	

					$Boleta->BolSunatRespuestaTicket = $fila['BolSunatRespuestaTicket']; 	
					$Boleta->BolSunatRespuestaTicketEstado = $fila['BolSunatRespuestaTicketEstado']; 			
					$Boleta->BolSunatRespuestaObservacion = $fila['BolSunatRespuestaObservacion']; 	
					
					$Boleta->BolSunatRespuestaEnvioTicket = $fila['BolSunatRespuestaEnvioTicket']; 	
					$Boleta->BolSunatRespuestaEnvioTicketEstado = $fila['BolSunatRespuestaEnvioTicketEstado']; 	
					$Boleta->BolSunatRespuestaEnvioFecha = $fila['NBolSunatRespuestaEnvioFecha']; 	
					$Boleta->BolSunatRespuestaEnvioHora = $fila['BolSunatRespuestaEnvioHora']; 	
					$Boleta->BolSunatRespuestaEnvioCodigo = $fila['BolSunatRespuestaEnvioCodigo']; 	
					$Boleta->BolSunatRespuestaEnvioContenido = $fila['BolSunatRespuestaEnvioContenido']; 	
					
					$Boleta->BolSunatRespuestaBajaTicket = $fila['BolSunatRespuestaBajaTicket']; 
					$Boleta->BolSunatRespuestaBajaTicketEstado = $fila['BolSunatRespuestaBajaTicketEstado'];	
					$Boleta->BolSunatRespuestaBajaFecha = $fila['NBolSunatRespuestaBajaFecha']; 	
					$Boleta->BolSunatRespuestaBajaHora = $fila['BolSunatRespuestaBajaHora']; 	
					$Boleta->BolSunatRespuestaBajaCodigo = $fila['BolSunatRespuestaBajaCodigo']; 	
					$Boleta->BolSunatRespuestaBajaContenido = $fila['BolSunatRespuestaBajaContenido']; 	
					$Boleta->BolSunatRespuestaBajaId = $fila['BolSunatRespuestaBajaId']; 	
					
					$Boleta->BolSunatRespuestaConsultaCodigo = $fila['BolSunatRespuestaConsultaCodigo']; 	
					$Boleta->BolSunatRespuestaConsultaContenido = $fila['BolSunatRespuestaConsultaContenido']; 	
					$Boleta->BolSunatRespuestaConsultaFecha = $fila['NBolSunatRespuestaConsultaFecha']; 	
					$Boleta->BolSunatRespuestaConsultaHora = $fila['BolSunatRespuestaConsultaHora']; 	
					
					$Boleta->BolSunatRespuestaEnvioTiempoCreacion = $fila['NBolSunatRespuestaEnvioTiempoCreacion']; 	
					$Boleta->BolSunatRespuestaConsultaTiempoCreacion = $fila['NBolSunatRespuestaConsultaTiempoCreacion']; 	
					$Boleta->BolSunatRespuestaBajaTiempoCreacion = $fila['NBolSunatRespuestaBajaTiempoCreacion']; 
					
					$Boleta->BolSunatUltimaAccion = $fila['BolSunatUltimaAccion']; 
					$Boleta->BolSunatUltimaRespuesta = $fila['BolSunatUltimaRespuesta']; 
					
					$Boleta->BolObservado = $fila['BolObservado']; 
					$Boleta->BolTiempoCreacion = $fila['NBolTiempoCreacion'];
                    $Boleta->BolTiempoModificacion = $fila['NBolTiempoModificacion'];

                    $Boleta->BolTotalItems = $fila['BolTotalItems'];					

					$Boleta->NpaNombre = $fila['NpaNombre'];
					
					$Boleta->BtaNumero = $fila['BtaNumero'];
					
					$Boleta->RegAplicacion = $fila['RegAplicacion'];
					$Boleta->RegNombre = $fila['RegNombre'];
					
					if($Boleta->BolEstado == 6){

						$Boleta->CliNombreCompleto = "ANULADO";
						$Boleta->CliNombre = "ANULADO";
						$Boleta->CliApellidoPaterno = "";
						$Boleta->CliApellidoMaterno = "";
						
					}else{
					
						$Boleta->CliNombreCompleto = $fila['CliNombreCompleto'];
						$Boleta->CliNombre = $fila['CliNombre'];
						$Boleta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
						$Boleta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
						
					}
					
					$Boleta->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$Boleta->TdoId = $fila['TdoId'];
					$Boleta->CliTelefono = $fila['CliTelefono'];
					$Boleta->CliEmail = $fila['CliTelefono'];
					$Boleta->CliCelular = $fila['CliCelular'];
					$Boleta->CliFax = $fila['CliFax'];
					
					$Boleta->MonNombre = $fila['MonNombre'];
					$Boleta->MonSimbolo = $fila['MonSimbolo'];
					$Boleta->MonSigla = $fila['MonSigla'];
					
					
					$Boleta->FinId = $fila['FinId'];
					$Boleta->CprId = $fila['CprId'];
					
					
					$Boleta->BolMontoAmortizado = $fila['BolMontoAmortizado'];
					$Boleta->BolMontoPendiente = $fila['BolMontoPendiente'];
					//$Boleta->BolCancelado = $fila['NBolCancelado'];
					
					$Boleta->VdiId = $fila['VdiId'];
					$Boleta->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$Boleta->VdiArchivo = $fila['VdiArchivo'];		

					$Boleta->AmoTipo = $fila['AmoTipo'];	
					$Boleta->AmoSubTipo = $fila['AmoSubTipo'];	

					$Boleta->TdoNombre = $fila['TdoNombre'];
					$Boleta->TdoCodigo = $fila['TdoCodigo'];
						
					$Boleta->SucNombre = $fila['SucNombre'];	
					$Boleta->SucSiglas = $fila['SucSiglas'];	



				switch($Boleta->BolEstado){
					case 1:
						$Boleta->BolEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$Boleta->BolEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$Boleta->BolEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$Boleta->BolEstadoDescripcion = "Reservado";
					break;
					
					
				}
				
				
								switch($Boleta->BolEstado){
					case 1:
						$Boleta->BolEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 5:
						$Boleta->BolEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$Boleta->BolEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					case 7:
						$Boleta->BolEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
					
				}
				
				
					$Boleta->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $Boleta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		 public function MtdObtenerNotaCreditos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NcrId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL,$oClienteId=NULL,$oNoProcesdado=false) {
	
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
		
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (ncr.NcrEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ncr.NcrFechaEmision)>="'.$oFechaInicio.'" AND DATE(ncr.NcrFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ncr.NcrFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ncr.NcrFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
				
		if(!empty($oTalonario)){
			$talonario = ' AND ncr.NctId = "'.$oTalonario.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ncr.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oDocumentoId)){
			$did = ' AND (ncr.FacId = "'.$oDocumentoId.'" OR ncr.BolId = "'.$oDocumentoId.'")';
		}
		
		if(!empty($oDocumentoTalonarioId)){
			$dtalonario = ' AND (ncr.FtaId = "'.$oDocumentoTalonarioId.'" OR ncr.BtaId = "'.$oDocumentoTalonarioId.'")';
		}
		
			if(!empty($oMoneda)){
			$moneda = ' AND (ncr.MonId = "'.$oMoneda.'")';
		}
		
			
			if(!empty($oSucursal)){
			$sucursal = ' AND (ncr.SucId = "'.$oSucursal.'")';
		}
		
		if(!empty($oClienteId)){
			$cliente = ' AND (ncr.CliId = "'.$oClienteId.'")';
		}
		
		if(($oNoProcesdado)){

			$noprocesado = ' AND	(ncr.NcrSunatRespuestaEnvioContenido NOT LIKE "%aceptad%" 
				OR ncr.NcrSunatRespuestaEnvioContenido IS NULL 
				OR ncr.NcrSunatRespuestaEnvioContenido  = ""
				
				) ';
		}
		
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ncr.NcrId,
				ncr.NctId,
				ncr.SucId,
				
				ncr.OvvId,
				ncr.VdiId,
				
				ncr.AmoId,
				ncr.VmvId,
				
				cli.CliId,
				DATE_FORMAT(ncr.NcrFechaEmision, "%d/%m/%Y") AS "NNcrFechaEmision",
DATE_FORMAT(ncr.NcrTiempoCreacion, "%H:%i:%s") AS "NcrHoraEmision",
				DATEDIFF(DATE(NOW()),ncr.NcrFechaEmision) AS NcrDiaTranscurrido,
				ncr.NcrDireccion,
				
				CASE ncr.NcrTipo
				WHEN 2 THEN (ncr.FacId)
				WHEN 3 THEN (ncr.BolId)
				ELSE NULL
				END AS "DocId",					
			
				CASE ncr.NcrTipo
				WHEN 2 THEN (ncr.FtaId)
				WHEN 3 THEN (ncr.BtaId)
				ELSE NULL
				END AS "DtaId" ,
				
				CASE ncr.NcrTipo
				WHEN 2 THEN (fta.FtaNumero)
				WHEN 3 THEN (bta.BtaNumero)
				ELSE NULL
				END AS "DtaNumero" ,
				
				CASE ncr.NcrTipo
				WHEN 2 THEN DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
				WHEN 3 THEN DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
				ELSE NULL
				END AS "DocFechaEmision",
				
					CASE ncr.NcrTipo
				WHEN 2 THEN ("01")
				WHEN 3 THEN ("03")
				ELSE NULL
				END AS "DocTipoDocumentoCodigo",	
				
				ncr.NcrIncluyeImpuesto,
				ncr.NcrPorcentajeImpuestoVenta,
				ncr.NcrPorcentajeImpuestoSelectivo,
							
				ncr.MonId,
				ncr.NcrTipoCambio,
				ncr.NcrTipoCambioAux,
				
				ncr.NcrTipo,
				
								ncr.NcrDatoAdicional1,
				ncr.NcrDatoAdicional2,
				ncr.NcrDatoAdicional3,
				ncr.NcrDatoAdicional4,
				ncr.NcrDatoAdicional5,
				ncr.NcrDatoAdicional6,
				ncr.NcrDatoAdicional7,
				ncr.NcrDatoAdicional8,
				ncr.NcrDatoAdicional9,
				ncr.NcrDatoAdicional10,
				
				ncr.NcrDatoAdicional11,
				ncr.NcrDatoAdicional12,
				ncr.NcrDatoAdicional13,
				ncr.NcrDatoAdicional14,
				ncr.NcrDatoAdicional15,
				ncr.NcrDatoAdicional16,
				ncr.NcrDatoAdicional17,
				ncr.NcrDatoAdicional18,
				ncr.NcrDatoAdicional19,
				ncr.NcrDatoAdicional20,
				
				ncr.NcrDatoAdicional21,
				ncr.NcrDatoAdicional22,
				ncr.NcrDatoAdicional23,
				ncr.NcrDatoAdicional24,
				ncr.NcrDatoAdicional25,
ncr.NcrDatoAdicional26,
ncr.NcrDatoAdicional27,
ncr.NcrDatoAdicional28,
				
				ncr.NcrEstado,					
				
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalImpuestoSelectivo) AS "NcrTotalImpuestoSelectivo",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalGravado) AS "NcrTotalGravado",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalDescuento) AS "NcrTotalDescuento",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalGratuito) AS "NcrTotalGratuito",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalExonerado) AS "NcrTotalExonerado",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalPagar) AS "NcrTotalPagar",	
				
				
				IF(ncr.NcrEstado=6,0.00,ncr.NcrSubTotal) AS "NcrSubTotal",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrImpuesto) AS "NcrImpuesto",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotal) AS "NcrTotal",	
							
				ncr.NcrObservacion,
				ncr.NcrMotivo,
				ncr.NcrMotivoCodigo,
				
				ncr.NcrSunatRespuestaTicket,
				ncr.NcrSunatRespuestaTicketEstado,
				ncr.NcrSunatRespuestaObservacion,
				
				ncr.NcrSunatRespuestaEnvioTicket,
				ncr.NcrSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaEnvioFecha",
				ncr.NcrSunatRespuestaEnvioHora,
				ncr.NcrSunatRespuestaEnvioCodigo,
				ncr.NcrSunatRespuestaEnvioContenido,
				
				ncr.NcrSunatRespuestaBajaTicket,
				ncr.NcrSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaBajaFecha",
				ncr.NcrSunatRespuestaBajaHora,				
				ncr.NcrSunatRespuestaBajaCodigo,
				ncr.NcrSunatRespuestaBajaContenido,
				ncr.NcrSunatRespuestaBajaId,
				
				ncr.NcrSunatRespuestaConsultaCodigo,
				ncr.NcrSunatRespuestaConsultaContenido,
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaConsultaFecha",
				ncr.NcrSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaBajaTiempoCreacion",
				
				ncr.NcrSunatUltimaAccion,
				ncr.NcrSunatUltimaRespuesta,
				
				ncr.NcrCierre,
			
				DATE_FORMAT(ncr.NcrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrTiempoCreacion",
                DATE_FORMAT(ncr.NcrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNcrTiempoModificacion",

				(SELECT COUNT(ncd.NcdId) FROM tblncdnotacreditodetalle ncd WHERE ncd.NcrId = ncr.NcrId AND ncd.NctId = ncr.NctId ) AS "NcrTotalItems",
	
				nct.NctNumero,
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.TdoId,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax	,
				
				mon.MonSigla,
				mon.MonNombre,
				mon.MonSimbolo,
				
				tdo.TdoNombre,
				tdo.TdoCodigo,
				
				
				suc.SucNombre,
				suc.SucSiglas
				
				FROM tblncrnotacredito ncr
				
				
					LEFT JOIN tblsucsucursal suc
					ON ncr.SucId = suc.SucId
					
					
				LEFT JOIN tblnctnotacreditotalonario nct
				ON ncr.NctId = nct.NctId
				
					LEFT JOIN tblfacfactura fac
					ON (ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId)
					
						LEFT JOIN tblftafacturatalonario fta 
						ON fac.FtaId = fta.FtaId
						
					LEFT JOIN tblbolboleta bol
					ON (ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId)
						
						LEFT JOIN tblbtaboletatalonario bta 
						ON ncr.BtaId = bta.BtaId
								
				LEFT JOIN tblclicliente cli
				  ON (ncr.CliId = cli.CliId)
					
					LEFT JOIN tblmonmoneda mon
					ON ncr.MonId = mon.MonId
						
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
						
					LEFT JOIN tblfaxfacturaexportar fax
					ON fax.NcrId = ncr.NcrId AND fax.NctId = ncr.NctId
					
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$did.$dtalonario.$noprocesado.$cliente.$fecha.$moneda.$talonario.$credito.$regimen.$npago.$orden.$paginacion;
				/*LEFT JOIN tblclicliente cli
				  ON (ncr.CliId = cli.CliId OR bol.CliId = cli.CliId)*/
					
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaCredito = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$NotaCredito = new $InsNotaCredito();
                    $NotaCredito->NcrId = $fila['NcrId'];
					$NotaCredito->NctId = $fila['NctId'];
					$NotaCredito->SucId = $fila['SucId'];
					
					$NotaCredito->OvvId = $fila['OvvId'];
					$NotaCredito->VdiId = $fila['VdiId'];
					
					$NotaCredito->AmoId = $fila['AmoId'];
					$NotaCredito->VmvId = $fila['VmvId'];
					
					$NotaCredito->CliId= $fila['CliId'];
					$NotaCredito->NcrDireccion = $fila['NcrDireccion'];	
					$NotaCredito->NcrFechaEmision = $fila['NNcrFechaEmision'];
					$NotaCredito->NcrHoraEmision = $fila['NcrHoraEmision'];	
					$NotaCredito->NcrDiaTranscurrido = $fila['NcrDiaTranscurrido'];
					
					$NotaCredito->DocId= $fila['DocId'];
					$NotaCredito->DtaId= $fila['DtaId'];
					$NotaCredito->DtaNumero= $fila['DtaNumero'];
					$NotaCredito->DocFechaEmision= $fila['DocFechaEmision'];
					$NotaCredito->DocTipoDocumentoCodigo= $fila['DocTipoDocumentoCodigo'];



					$NotaCredito->NcrIncluyeImpuesto = $fila['NcrIncluyeImpuesto'];
					$NotaCredito->NcrPorcentajeImpuestoVenta = $fila['NcrPorcentajeImpuestoVenta'];
					$NotaCredito->NcrPorcentajeImpuestoSelectivo = $fila['NcrPorcentajeImpuestoSelectivo'];
							
					$NotaCredito->MonId = $fila['MonId'];
					$NotaCredito->NcrTipoCambio = $fila['NcrTipoCambio'];
					$NotaCredito->NcrTipoCambioAux = $fila['NcrTipoCambioAux'];

					$NotaCredito->NcrTipo = $fila['NcrTipo'];
										
					$NotaCredito->NcrDatoAdicional1 = $fila['NcrDatoAdicional1'];
					$NotaCredito->NcrDatoAdicional2 = $fila['NcrDatoAdicional2'];
					$NotaCredito->NcrDatoAdicional3 = $fila['NcrDatoAdicional3'];
					$NotaCredito->NcrDatoAdicional4 = $fila['NcrDatoAdicional4'];
					$NotaCredito->NcrDatoAdicional5 = $fila['NcrDatoAdicional5'];
					$NotaCredito->NcrDatoAdicional6 = $fila['NcrDatoAdicional6'];
					$NotaCredito->NcrDatoAdicional7 = $fila['NcrDatoAdicional7'];
					$NotaCredito->NcrDatoAdicional8 = $fila['NcrDatoAdicional8'];
					$NotaCredito->NcrDatoAdicional9 = $fila['NcrDatoAdicional9'];
					$NotaCredito->NcrDatoAdicional10 = $fila['NcrDatoAdicional10'];
					
					$NotaCredito->NcrDatoAdicional11 = $fila['NcrDatoAdicional11'];
					$NotaCredito->NcrDatoAdicional12 = $fila['NcrDatoAdicional12'];
					$NotaCredito->NcrDatoAdicional13 = $fila['NcrDatoAdicional13'];
					$NotaCredito->NcrDatoAdicional14 = $fila['NcrDatoAdicional14'];
					$NotaCredito->NcrDatoAdicional15 = $fila['NcrDatoAdicional15'];
					$NotaCredito->NcrDatoAdicional16 = $fila['NcrDatoAdicional16'];
					$NotaCredito->NcrDatoAdicional17 = $fila['NcrDatoAdicional17'];
					$NotaCredito->NcrDatoAdicional18 = $fila['NcrDatoAdicional18'];
					$NotaCredito->NcrDatoAdicional19 = $fila['NcrDatoAdicional19'];
					$NotaCredito->NcrDatoAdicional20 = $fila['NcrDatoAdicional20'];
					
					$NotaCredito->NcrDatoAdicional21 = $fila['NcrDatoAdicional21'];
					$NotaCredito->NcrDatoAdicional22 = $fila['NcrDatoAdicional22'];
					$NotaCredito->NcrDatoAdicional23 = $fila['NcrDatoAdicional23'];
					$NotaCredito->NcrDatoAdicional24 = $fila['NcrDatoAdicional24'];
					$NotaCredito->NcrDatoAdicional25 = $fila['NcrDatoAdicional25'];
					$NotaCredito->NcrDatoAdicional26 = $fila['NcrDatoAdicional26'];
					
					
					$NotaCredito->NcrDatoAdicional27 = $fila['NcrDatoAdicional27'];
					$NotaCredito->NcrDatoAdicional28 = $fila['NcrDatoAdicional28'];
					
					$NotaCredito->NcrEstado = $fila['NcrEstado'];

					$NotaCredito->NcrTotalImpuestoSelectivo = $fila['NcrTotalImpuestoSelectivo']; 
					$NotaCredito->NcrTotalGravado = $fila['NcrTotalGravado']; 
					$NotaCredito->NcrTotalDescuento = $fila['NcrTotalDescuento']; 
					$NotaCredito->NcrTotalGratuito = $fila['NcrTotalGratuito']; 
					$NotaCredito->NcrTotalExonerado = $fila['NcrTotalExonerado']; 
					$NotaCredito->NcrTotalPagar = $fila['NcrTotalPagar'];

					$NotaCredito->NcrSubTotal = $fila['NcrSubTotal']; 
					$NotaCredito->NcrDescuento = $fila['NcrDescuento']; 
					$NotaCredito->NcrImpuesto = $fila['NcrImpuesto']; 
					$NotaCredito->NcrTotal = $fila['NcrTotal']; 

					list($NotaCredito->NcrObservacion,$NotaCredito->NcrObservacionImpresa) = explode("###",$fila['NcrObservacion']);								
					$NotaCredito->NcrMotivo = $fila['NcrMotivo'];
					$NotaCredito->NcrMotivoCodigo = $fila['NcrMotivoCodigo'];
					
					$NotaCredito->NcrSunatRespuestaTicket = $fila['NcrSunatRespuestaTicket'];
					$NotaCredito->NcrSunatRespuestaTicketEstado = $fila['NcrSunatRespuestaTicketEstado'];
					$NotaCredito->NcrSunatRespuestaObservacion = $fila['NcrSunatRespuestaObservacion'];

					$NotaCredito->NcrSunatRespuestaEnvioTicket = $fila['NcrSunatRespuestaEnvioTicket'];
					$NotaCredito->NcrSunatRespuestaEnvioTicketEstado = $fila['NcrSunatRespuestaEnvioTicketEstado'];
					$NotaCredito->NcrSunatRespuestaEnvioFecha = $fila['NNcrSunatRespuestaEnvioFecha'];
					$NotaCredito->NcrSunatRespuestaEnvioHora = $fila['NcrSunatRespuestaEnvioHora'];
					$NotaCredito->NcrSunatRespuestaEnvioCodigo = $fila['NcrSunatRespuestaEnvioCodigo'];
					$NotaCredito->NcrSunatRespuestaEnvioContenido = $fila['NcrSunatRespuestaEnvioContenido'];
					
					$NotaCredito->NcrSunatRespuestaBajaTicket = $fila['NcrSunatRespuestaBajaTicket']; 	
					$NotaCredito->NcrSunatRespuestaBajaTicketEstado = $fila['NcrSunatRespuestaBajaTicketEstado'];
					$NotaCredito->NcrSunatRespuestaBajaFecha = $fila['NNcrSunatRespuestaBajaFecha'];
					$NotaCredito->NcrSunatRespuestaBajaHora = $fila['NcrSunatRespuestaBajaHora']; 	
					$NotaCredito->NcrSunatRespuestaBajaCodigo = $fila['NcrSunatRespuestaBajaCodigo']; 	
					$NotaCredito->NcrSunatRespuestaBajaContenido = $fila['NcrSunatRespuestaBajaContenido']; 	
					$NotaCredito->NcrSunatRespuestaBajaId = $fila['NcrSunatRespuestaBajaId']; 	
					
					$NotaCredito->NcrSunatRespuestaConsultaCodigo = $fila['NcrSunatRespuestaConsultaCodigo']; 	
					$NotaCredito->NcrSunatRespuestaConsultaContenido = $fila['NcrSunatRespuestaConsultaContenido']; 	
					$NotaCredito->NcrSunatRespuestaConsultaFecha = $fila['NNcrSunatRespuestaConsultaFecha']; 	
					$NotaCredito->NcrSunatRespuestaConsultaHora = $fila['NcrSunatRespuestaConsultaHora']; 	
					
					$NotaCredito->NcrSunatRespuestaEnvioTiempoCreacion = $fila['NNcrSunatRespuestaEnvioTiempoCreacion']; 	
					$NotaCredito->NcrSunatRespuestaConsultaTiempoCreacion = $fila['NNcrSunatRespuestaConsultaTiempoCreacion']; 	
					$NotaCredito->NcrSunatRespuestaBajaTiempoCreacion = $fila['NNcrSunatRespuestaBajaTiempoCreacion']; 	
					
					$NotaCredito->NcrSunatUltimaAccion = $fila['NcrSunatUltimaAccion']; 	
					$NotaCredito->NcrSunatUltimaRespuesta = $fila['NcrSunatUltimaRespuesta']; 	
															
					$NotaCredito->NcrCierre = $fila['NcrCierre'];					
                   	$NotaCredito->NcrTiempoCreacion = $fila['NNcrTiempoCreacion'];
                    $NotaCredito->NcrTiempoModificacion = $fila['NNcrTiempoModificacion'];
					
					$NotaCredito->NcrTotalItems = $fila['NcrTotalItems'];
					
					$NotaCredito->NctNumero = $fila['NctNumero'];
					
					if($NotaCredito->NcrEstado == 6){

						$NotaCredito->CliNombreCompleto = "ANULADO";
						$NotaCredito->CliNombre = "ANULADO";
						$NotaCredito->CliApellidoPaterno = "";
						$NotaCredito->CliApellidoMaterno = "";

					}else{
					
						$NotaCredito->CliNombreCompleto = $fila['CliNombreCompleto'];
						$NotaCredito->CliNombre = $fila['CliNombre'];
						$NotaCredito->CliApellidoPaterno = $fila['CliApellidoPaterno'];
						$NotaCredito->CliApellidoMaterno = $fila['CliApellidoMaterno'];
							
					}
					
					
					$NotaCredito->TdoId = $fila['TdoId'];
					$NotaCredito->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$NotaCredito->CliTelefono = $fila['CliTelefono'];
					$NotaCredito->CliEmail = $fila['CliEmail'];
					$NotaCredito->CliCelular = $fila['CliCelular'];
					$NotaCredito->CliFax = $fila['CliFax'];
					
					
					$NotaCredito->MonSigla = $fila['MonSigla'];
					$NotaCredito->MonNombre = $fila['MonNombre'];
					$NotaCredito->MonSimbolo = $fila['MonSimbolo'];
	
	$NotaCredito->TdoNombre = $fila['TdoNombre'];
	$NotaCredito->TdoCodigo = $fila['TdoCodigo'];
	
	$NotaCredito->SucNombre = $fila['SucNombre'];
	$NotaCredito->SucSiglas = $fila['SucSiglas'];
	
	
	
				switch($NotaCredito->NcrEstado){
					case 1:
						$NotaCredito->NcrEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$NotaCredito->NcrEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$NotaCredito->NcrEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$NotaCredito->NcrEstadoDescripcion = "Reservado";
					break;
					
					
				}
				

				
					$NotaCredito->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $NotaCredito;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
    public function MtdObtenerNotaDebitos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL) {
	
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
		
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (ndb.NdbEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ndb.NdbFechaEmision)>="'.$oFechaInicio.'" AND DATE(ndb.NdbFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ndb.NdbFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ndb.NdbFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
				
		if(!empty($oTalonario)){
			$talonario = ' AND ndb.NdtId = "'.$oTalonario.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ndb.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oDocumentoId)){
			$did = ' AND (ndb.FacId = "'.$oDocumentoId.'" OR ndb.BolId = "'.$oDocumentoId.'")';
		}
		
		if(!empty($oDocumentoTalonarioId)){
			$dtalonario = ' AND (ndb.FtaId = "'.$oDocumentoTalonarioId.'" OR ndb.BtaId = "'.$oDocumentoTalonarioId.'")';
		}
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND (ndb.MonId = "'.$oMoneda.'")';
		}
		
			
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (ndb.SucId = "'.$oSucursal.'")';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ndb.NdbId,
				ndb.NdtId,
				ndb.SucId,
				
				cli.CliId,
				DATE_FORMAT(ndb.NdbFechaEmision, "%d/%m/%Y") AS "NNdbFechaEmision",
DATE_FORMAT(ndb.NdbTiempoCreacion, "%H:%i:%s") AS "NdbHoraEmision",
				ndb.NdbDireccion,
				
				CASE ndb.NdbTipo
				WHEN 2 THEN (ndb.FacId)
				WHEN 3 THEN (ndb.BolId)
				ELSE NULL
				END AS "DocId",					
			
				CASE ndb.NdbTipo
				WHEN 2 THEN (ndb.FtaId)
				WHEN 3 THEN (ndb.BtaId)
				ELSE NULL
				END AS "DtaId" ,
				
				CASE ndb.NdbTipo
				WHEN 2 THEN (fta.FtaNumero)
				WHEN 3 THEN (bta.BtaNumero)
				ELSE NULL
				END AS "DtaNumero" ,
				
				CASE ndb.NdbTipo
				WHEN 2 THEN DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
				WHEN 3 THEN DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
				ELSE NULL
				END AS "DocFechaEmision",
				
				ndb.NdbIncluyeImpuesto,
				ndb.NdbPorcentajeImpuestoVenta,
				ndb.NdbPorcentajeImpuestoSelectivo,
							
				ndb.MonId,
				ndb.NdbTipoCambio,
				ndb.NdbTipoCambioAux,
				
				ndb.NdbTipo,
				
								ndb.NdbDatoAdicional1,
				ndb.NdbDatoAdicional2,
				ndb.NdbDatoAdicional3,
				ndb.NdbDatoAdicional4,
				ndb.NdbDatoAdicional5,
				ndb.NdbDatoAdicional6,
				ndb.NdbDatoAdicional7,
				ndb.NdbDatoAdicional8,
				ndb.NdbDatoAdicional9,
				ndb.NdbDatoAdicional10,
				
				ndb.NdbDatoAdicional11,
				ndb.NdbDatoAdicional12,
				ndb.NdbDatoAdicional13,
				ndb.NdbDatoAdicional14,
				ndb.NdbDatoAdicional15,
				ndb.NdbDatoAdicional16,
				ndb.NdbDatoAdicional17,
				ndb.NdbDatoAdicional18,
				ndb.NdbDatoAdicional19,
				ndb.NdbDatoAdicional20,
				
				ndb.NdbDatoAdicional21,
				ndb.NdbDatoAdicional22,
				ndb.NdbDatoAdicional23,
				ndb.NdbDatoAdicional24,
				ndb.NdbDatoAdicional25,
ndb.NdbDatoAdicional26,
				
				ndb.NdbEstado,					
				
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalImpuestoSelectivo) AS "NdbTotalImpuestoSelectivo",
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalGravado) AS "NdbTotalGravado",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalDescuento) AS "NdbTotalDescuento",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalGratuito) AS "NdbTotalGratuito",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalExonerado) AS "NdbTotalExonerado",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalPagar) AS "NdbTotalPagar",	
				
				
				IF(ndb.NdbEstado=6,0.00,ndb.NdbSubTotal) AS "NdbSubTotal",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbImpuesto) AS "NdbImpuesto",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotal) AS "NdbTotal",	
							
				ndb.NdbObservacion,
				ndb.NdbMotivo,
				ndb.NdbMotivoCodigo,
				
				ndb.NdbSunatRespuestaTicket,
				ndb.NdbSunatRespuestaTicketEstado,
				ndb.NdbSunatRespuestaObservacion,
				
				ndb.NdbSunatRespuestaEnvioTicket,
				ndb.NdbSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaEnvioFecha",
				ndb.NdbSunatRespuestaEnvioHora,
				ndb.NdbSunatRespuestaEnvioCodigo,
				ndb.NdbSunatRespuestaEnvioContenido,
				
				ndb.NdbSunatRespuestaBajaTicket,
				ndb.NdbSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaBajaFecha",
				ndb.NdbSunatRespuestaBajaHora,				
				ndb.NdbSunatRespuestaBajaCodigo,
				ndb.NdbSunatRespuestaBajaContenido,
				ndb.NdbSunatRespuestaBajaId,
				
				ndb.NdbSunatRespuestaConsultaCodigo,
				ndb.NdbSunatRespuestaConsultaContenido,
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaConsultaFecha",
				ndb.NdbSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaBajaTiempoCreacion",
				
				ndb.NdbSunatUltimaAccion,
				ndb.NdbSunatUltimaRespuesta,
				
				ndb.NdbCierre,
			
				DATE_FORMAT(ndb.NdbTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbTiempoCreacion",
                DATE_FORMAT(ndb.NdbTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNdbTiempoModificacion",

				(SELECT COUNT(ndd.NddId) FROM tblnddnotadebitodetalle ndd WHERE ndd.NdbId = ndb.NdbId AND ndd.NdtId = ndb.NdtId ) AS "NdbTotalItems",
	
				nct.NdtNumero,
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.TdoId,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax	,
				
				mon.MonSigla,
				mon.MonNombre,
				mon.MonSimbolo,
				
				tdo.TdoNombre,
				tdo.TdoCodigo,
				
				
				suc.SucNombre,
				suc.SucSiglas
				
				FROM tblndbnotadebito ndb
				
				
					LEFT JOIN tblsucsucursal suc
					ON ndb.SucId = suc.SucId
				
				LEFT JOIN tblndtnotadebitotalonario nct
				ON ndb.NdtId = nct.NdtId
				
					LEFT JOIN tblfacfactura fac
					ON (ndb.FacId = fac.FacId AND ndb.FtaId = fac.FtaId)
					
						LEFT JOIN tblftafacturatalonario fta 
						ON fac.FtaId = fta.FtaId
						
					LEFT JOIN tblbolboleta bol
					ON (ndb.BolId = bol.BolId AND ndb.BtaId = bol.BtaId)
						
						LEFT JOIN tblbtaboletatalonario bta 
						ON ndb.BtaId = bta.BtaId
								
				LEFT JOIN tblclicliente cli
				  ON (ndb.CliId = cli.CliId)
					
					LEFT JOIN tblmonmoneda mon
					ON ndb.MonId = mon.MonId
					
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
					LEFT JOIN tblfaxfacturaexportar fax
					ON fax.NdbId = ndb.NdbId AND fax.NdtId = ndb.NdtId
					
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$did.$dtalonario.$fecha.$moneda.$talonario.$credito.$regimen.$npago.$orden.$paginacion;
				/*LEFT JOIN tblclicliente cli
				  ON (ndb.CliId = cli.CliId OR bol.CliId = cli.CliId)*/
					
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaDebito = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$NotaDebito = new $InsNotaDebito();
                    $NotaDebito->NdbId = $fila['NdbId'];
					$NotaDebito->NdtId = $fila['NdtId'];
					$NotaDebito->SucId = $fila['SucId'];
					
					$NotaDebito->CliId= $fila['CliId'];
					$NotaDebito->NdbDireccion = $fila['NdbDireccion'];	
					$NotaDebito->NdbFechaEmision = $fila['NNdbFechaEmision'];
					$NotaDebito->NdbHoraEmision = $fila['NdbHoraEmision'];
					
					
					$NotaDebito->DocId= $fila['DocId'];
					$NotaDebito->DtaId= $fila['DtaId'];
					$NotaDebito->DtaNumero= $fila['DtaNumero'];

					$NotaDebito->NdbIncluyeImpuesto = $fila['NdbIncluyeImpuesto'];
					$NotaDebito->NdbPorcentajeImpuestoVenta = $fila['NdbPorcentajeImpuestoVenta'];
					$NotaDebito->NdbPorcentajeImpuestoSelectivo = $fila['NdbPorcentajeImpuestoSelectivo'];
							
					$NotaDebito->MonId = $fila['MonId'];
					$NotaDebito->NdbTipoCambio = $fila['NdbTipoCambio'];
					$NotaDebito->NdbTipoCambioAux = $fila['NdbTipoCambioAux'];

					$NotaDebito->NdbTipo = $fila['NdbTipo'];
										
					$NotaDebito->NdbDatoAdicional1 = $fila['NdbDatoAdicional1'];
					$NotaDebito->NdbDatoAdicional2 = $fila['NdbDatoAdicional2'];
					$NotaDebito->NdbDatoAdicional3 = $fila['NdbDatoAdicional3'];
					$NotaDebito->NdbDatoAdicional4 = $fila['NdbDatoAdicional4'];
					$NotaDebito->NdbDatoAdicional5 = $fila['NdbDatoAdicional5'];
					$NotaDebito->NdbDatoAdicional6 = $fila['NdbDatoAdicional6'];
					$NotaDebito->NdbDatoAdicional7 = $fila['NdbDatoAdicional7'];
					$NotaDebito->NdbDatoAdicional8 = $fila['NdbDatoAdicional8'];
					$NotaDebito->NdbDatoAdicional9 = $fila['NdbDatoAdicional9'];
					$NotaDebito->NdbDatoAdicional10 = $fila['NdbDatoAdicional10'];
					
					$NotaDebito->NdbDatoAdicional11 = $fila['NdbDatoAdicional11'];
					$NotaDebito->NdbDatoAdicional12 = $fila['NdbDatoAdicional12'];
					$NotaDebito->NdbDatoAdicional13 = $fila['NdbDatoAdicional13'];
					$NotaDebito->NdbDatoAdicional14 = $fila['NdbDatoAdicional14'];
					$NotaDebito->NdbDatoAdicional15 = $fila['NdbDatoAdicional15'];
					$NotaDebito->NdbDatoAdicional16 = $fila['NdbDatoAdicional16'];
					$NotaDebito->NdbDatoAdicional17 = $fila['NdbDatoAdicional17'];
					$NotaDebito->NdbDatoAdicional18 = $fila['NdbDatoAdicional18'];
					$NotaDebito->NdbDatoAdicional19 = $fila['NdbDatoAdicional19'];
					$NotaDebito->NdbDatoAdicional20 = $fila['NdbDatoAdicional20'];
					
					$NotaDebito->NdbDatoAdicional21 = $fila['NdbDatoAdicional21'];
					$NotaDebito->NdbDatoAdicional22 = $fila['NdbDatoAdicional22'];
					$NotaDebito->NdbDatoAdicional23 = $fila['NdbDatoAdicional23'];
					$NotaDebito->NdbDatoAdicional24 = $fila['NdbDatoAdicional24'];
					$NotaDebito->NdbDatoAdicional25 = $fila['NdbDatoAdicional25'];
					$NotaDebito->NdbDatoAdicional26 = $fila['NdbDatoAdicional26'];
					
					$NotaDebito->NdbEstado = $fila['NdbEstado'];

					$NotaDebito->NdbTotalImpuestoSelectivo = $fila['NdbTotalImpuestoSelectivo']; 
					$NotaDebito->NdbTotalGravado = $fila['NdbTotalGravado']; 
					$NotaDebito->NdbTotalDescuento = $fila['NdbTotalDescuento']; 
					$NotaDebito->NdbTotalGratuito = $fila['NdbTotalGratuito']; 
					$NotaDebito->NdbTotalExonerado = $fila['NdbTotalExonerado']; 
					$NotaDebito->NdbTotalPagar = $fila['NdbTotalPagar'];

					$NotaDebito->NdbSubTotal = $fila['NdbSubTotal']; 
					$NotaDebito->NdbDescuento = $fila['NdbDescuento']; 
					$NotaDebito->NdbImpuesto = $fila['NdbImpuesto']; 
					$NotaDebito->NdbTotal = $fila['NdbTotal']; 

					list($NotaDebito->NdbObservacion,$NotaDebito->NdbObservacionImpresa) = explode("###",$fila['NdbObservacion']);								
					$NotaDebito->NdbMotivo = $fila['NdbMotivo'];
					$NotaDebito->NdbMotivoCodigo = $fila['NdbMotivoCodigo'];
					
					$NotaDebito->NdbSunatRespuestaTicket = $fila['NdbSunatRespuestaTicket'];
					$NotaDebito->NdbSunatRespuestaTicketEstado = $fila['NdbSunatRespuestaTicketEstado'];
					$NotaDebito->NdbSunatRespuestaObservacion = $fila['NdbSunatRespuestaObservacion'];

					$NotaDebito->NdbSunatRespuestaEnvioTicket = $fila['NdbSunatRespuestaEnvioTicket'];
					$NotaDebito->NdbSunatRespuestaEnvioTicketEstado = $fila['NdbSunatRespuestaEnvioTicketEstado'];
					$NotaDebito->NdbSunatRespuestaEnvioFecha = $fila['NNdbSunatRespuestaEnvioFecha'];
					$NotaDebito->NdbSunatRespuestaEnvioHora = $fila['NdbSunatRespuestaEnvioHora'];
					$NotaDebito->NdbSunatRespuestaEnvioCodigo = $fila['NdbSunatRespuestaEnvioCodigo'];
					$NotaDebito->NdbSunatRespuestaEnvioContenido = $fila['NdbSunatRespuestaEnvioContenido'];
					
					$NotaDebito->NdbSunatRespuestaBajaTicket = $fila['NdbSunatRespuestaBajaTicket']; 	
					$NotaDebito->NdbSunatRespuestaBajaTicketEstado = $fila['NdbSunatRespuestaBajaTicketEstado'];
					$NotaDebito->NdbSunatRespuestaBajaFecha = $fila['NNdbSunatRespuestaBajaFecha'];
					$NotaDebito->NdbSunatRespuestaBajaHora = $fila['NdbSunatRespuestaBajaHora']; 	
					$NotaDebito->NdbSunatRespuestaBajaCodigo = $fila['NdbSunatRespuestaBajaCodigo']; 	
					$NotaDebito->NdbSunatRespuestaBajaContenido = $fila['NdbSunatRespuestaBajaContenido']; 	
					$NotaDebito->NdbSunatRespuestaBajaId = $fila['NdbSunatRespuestaBajaId']; 	
					
					$NotaDebito->NdbSunatRespuestaConsultaCodigo = $fila['NdbSunatRespuestaConsultaCodigo']; 	
					$NotaDebito->NdbSunatRespuestaConsultaContenido = $fila['NdbSunatRespuestaConsultaContenido']; 	
					$NotaDebito->NdbSunatRespuestaConsultaFecha = $fila['NNdbSunatRespuestaConsultaFecha']; 	
					$NotaDebito->NdbSunatRespuestaConsultaHora = $fila['NdbSunatRespuestaConsultaHora']; 	
					
					$NotaDebito->NdbSunatRespuestaEnvioTiempoCreacion = $fila['NNdbSunatRespuestaEnvioTiempoCreacion']; 	
					$NotaDebito->NdbSunatRespuestaConsultaTiempoCreacion = $fila['NNdbSunatRespuestaConsultaTiempoCreacion']; 	
					$NotaDebito->NdbSunatRespuestaBajaTiempoCreacion = $fila['NNdbSunatRespuestaBajaTiempoCreacion']; 	
					
					$NotaDebito->NdbSunatUltimaAccion = $fila['NdbSunatUltimaAccion']; 	
					$NotaDebito->NdbSunatUltimaRespuesta = $fila['NdbSunatUltimaRespuesta']; 	
															
					$NotaDebito->NdbCierre = $fila['NdbCierre'];					
                   	$NotaDebito->NdbTiempoCreacion = $fila['NNdbTiempoCreacion'];
                    $NotaDebito->NdbTiempoModificacion = $fila['NNdbTiempoModificacion'];
					
					$NotaDebito->NdbTotalItems = $fila['NdbTotalItems'];
					
					$NotaDebito->NdtNumero = $fila['NdtNumero'];
					
					$NotaDebito->CliNombreCompleto = $fila['CliNombreCompleto'];
					$NotaDebito->CliNombre = $fila['CliNombre'];
					$NotaDebito->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$NotaDebito->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$NotaDebito->TdoId = $fila['TdoId'];
					$NotaDebito->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$NotaDebito->CliTelefono = $fila['CliTelefono'];
					$NotaDebito->CliEmail = $fila['CliEmail'];
					$NotaDebito->CliCelular = $fila['CliCelular'];
					$NotaDebito->CliFax = $fila['CliFax'];
					
					
					$NotaDebito->MonSigla = $fila['MonSigla'];
					$NotaDebito->MonNombre = $fila['MonNombre'];
					$NotaDebito->MonSimbolo = $fila['MonSimbolo'];
				
				$NotaDebito->TdoNombre = $fila['TdoNombre'];
				$NotaDebito->TdoCodigo = $fila['TdoCodigo'];
				
				$NotaDebito->SucNombre = $fila['SucNombre'];
				$NotaDebito->SucSiglas = $fila['SucSiglas'];
				
				
					$NotaDebito->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $NotaDebito;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
}
?>