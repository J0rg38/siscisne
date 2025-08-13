<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsKardex
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsKardex {

    public $KdxId;
	public $KdxFecha;
	public $ProId;
	public $UmeId;
    public $KdxCantidad;	
	public $KdxCostoUnitario;
	public $KdxCostoTotal;
	public $KdxTiempoCreacion;
	
	public $ProNombre;
	public $UmeNombre;

	public $TopCodigo;
	public $TopNombre;
	
	public $KdxComprobanteNumero;
	public $CtiCodigo;
	public $CtiNombre;
	
	public $RtiNombre;

	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


		
    public function MtdObtenerKardexs2($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL,$oSucursal=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$producto = '';
		$fechainicio = '';
		$fechafin = '';
		$uso = '';
		$moneda = '';
		$fechaTipo = '';
		$almacen = '';
		$sucursal = '';

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
		

		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
	
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFechaTipo.')>="'.$oFechaInicio.'" AND DATE('.$oFechaTipo.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oFechaTipo.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFechaTipo.')<="'.$oFechaFin.'"';		
			}			
		}
//			amd.AmdCostoTotal AS KdxCostoUnitario,		
//			amd.AmdCostoTotal * amd.AmdCantidadReal AS KdxCostoTotal,

//			ROUND(amd.AmdCosto/amd.AmdCantidadReal,3) AS KdxCostoUnitario,
//			
//			amd.AmdCantidadReal AS KdxCantidad,
//			(ROUND(amd.AmdCosto/amd.AmdCantidadReal,3) * amd.AmdCantidadReal) AS KdxCostoTotal,

//		if($oUso==1){
//			$uso = '
//			(amd.AmdImporte/amd.AmdCantidadReal) AS KdxCostoUnitario,
//			amd.AmdCantidadReal AS KdxCantidad,
//			((amd.AmdImporte/amd.AmdCantidadReal) * amd.AmdCantidadReal) AS KdxCostoTotal,
//			
//			';	
//			
//		}else{
//			$uso = '
//			(amd.AmdImporte/amd.AmdCantidad) AS KdxCostoUnitario,
//			amd.AmdCantidad AS KdxCantidad,
//			((amd.AmdImporte/amd.AmdCantidad) * amd.AmdCantidad) AS KdxCostoTotal,
//			';	
//		}

		/*if($oUso==3){
			
			$uso = '
			(amd.AmdValorTotal/(amd.AmdCantidadReal/amd.AmdCantidad)) AS KdxCostoUnitario,
			amd.AmdCantidadReal AS KdxCantidad,
			((AmdValorTotal/(amd.AmdCantidadReal/amd.AmdCantidad)) * amd.AmdCantidadReal) AS KdxCostoTotal,
			
			';	
			
		}else{
			
			$uso = '
			(AmdValorTotal) AS KdxCostoUnitario,
			
			(amd.AmdCantidadReal/umc.UmcEquivalente) AS KdxCantidad,
			
			((AmdValorTotal) * (amd.AmdCantidadReal/umc.UmcEquivalente) ) AS KdxCostoTotal,
			';	
			
		}*/


	
			
		
			
		$uso = '
		
			(amd.AmdCosto) AS KdxCostoUnitario,
			
			(amd.AmdCantidad) AS KdxCantidad,
			
			(amd.AmdImporte) AS KdxCostoTotal,
			
			';	
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND (amo.MonId = "'.$oMoneda.'") ';
		}
		
	    /*
		ENTRADS
		
		1 COMPRAS
		2 OTROS CONCEPTOS
		3 
		4 		
		5 
		6 TRASLADOS
		
		SALDIAS
		
		1 
		2 TALLER
		3 VENTAS X MOSTRADOR
		4 OTROS CONCEPTOS
		
		5 NC COMPRA
		6 TRASLADOS
		
		*/
	
		if(!empty($oSucursal)){
			
			$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
			
			$stipo = ' AND (
			
				( 
				amo.AmoTipo = 2 
					AND (
						
						amo.AmoSubTipo = 2 
						OR amo.AmoSubTipo = 3 
						OR amo.AmoSubTipo = 4 
						OR amo.AmoSubTipo = 5
						OR amo.AmoSubTipo = 6
												
						OR (amo.AmoSubTipo = 1 AND amo.TopId = "TOP-10010") 
						OR (amo.AmoSubTipo = 1 AND amo.TopId = "TOP-10015")

					) 
				) 
				
				OR 
				
				(
				 	amo.AmoTipo = 1 AND (
				 
					 amo.AmoSubTipo = 1 
					 OR amo.AmoSubTipo = 2 
					 OR amo.AmoSubTipo = 6
					 
					 ) 
				 
				)
			
			)';
			
			
		}else{
			
			//$stipo = ' AND (
//			amo.AmoSubTipo = 2	OR 
//			amo.AmoSubTipo = 3 OR 
//			(amo.AmoSubTipo = 1 AND amo.TopId = "TOP-10010") OR
//			amo.AmoTipoMovimiento IS NOT NULL
//		
//			)';

			$stipo = ' AND (
			
			( 
			
			amo.AmoTipo = 2 
			
				AND ( 
				
					amo.AmoSubTipo = 2 
					OR amo.AmoSubTipo = 3
					OR amo.AmoSubTipo = 4 
					OR amo.AmoSubTipo = 5 
				)  
				
				AND amo.TopId <> "TOP-10010"
			) 
			
			OR 
			
				(
				
					amo.AmoTipo = 1 
					
					AND (
					
						amo.AmoSubTipo = 1 
						OR amo.AmoSubTipo = 2
						
						
					) 
					
					AND amo.TopId <> "TOP-10010"
					
				)
			
			)';
			
		}

		//TOP-10010 transfernecias
		//TOP-10015 SALDO INICIALES

//		if(!empty($oSucursal)){
//			$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
//		}
//		
//		
//		if(!empty($oAlmacen)){
//			$almacen = ' AND (amd.AlmId = "'.$oAlmacen.'") ';
//			$stipo = "";
//		}else{
//			$stipo = ' AND (
//			amo.AmoSubTipo = 1	OR 
//			amo.AmoSubTipo = 2 OR 
//			amo.AmoSubTipo = 3 OR 
//			amo.AmoSubTipo = 4 OR 
//			amo.AmoSubTipo = 7 OR 
//			amo.AmoSubTipo = 5
//			)';
//		}
//
//
//	if(empty($oSucursal) and empty($oSucursal)){
//		
//		$stipo = ' AND (
//			amo.TopId <> "TOP-10010"
//			)';
//			
//	}
	
	
//
//		if(!empty($oAlmacenMovimientoSubTipo)){
//
//			$elementos = explode(",",$oAlmacenMovimientoSubTipo);
//
//			$i=1;
//			$amstipo .= ' AND (
//			(';
//			$elementos = array_filter($elementos);
//			foreach($elementos as $elemento){
//				$amstipo .= '  (amo.AmoSubTipo = "'.($elemento).'" )';
//				if($i<>count($elementos)){						
//					$amstipo .= ' OR ';	
//				}
//			$i++;		
//			}
//
//			$amstipo .= ' ) 
//			)
//			';
//
//		}
//		
		
//16.746196



		$sql = '

			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmoId AS KdxId,
			amo.TalId,
			amo.PprId,
			
			DATE_FORMAT('.$oFechaTipo.', "%d/%m/%Y") AS "KdxFecha",
			amd.ProId,
			amd.UmeId,
			
			'.$uso.'			
			
			amo.AmoTipo AS "KdxMovimientoTipo",
			amo.AmoSubTipo AS "KdxMovimientoSubTipo",
			
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS KdxTiempoCreacion,
			pro.ProNombre,
pro.ProMarcaReferencia,
			pro.RtiId,
			pro.ProUbicacion AS KdxUbicacion,
			ume.UmeNombre,
		

			IFNULL(
			top.TopCodigo,
			
				IFNULL(
					(	
						
						SELECT
						CONCAT("01")
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblfacfactura fac
							ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
						WHERE fam.AmoId = amd.AmoId
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
					
					),
						IFNULL(	
							(
							SELECT
							CONCAT("01")
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol
								ON bam.BolId = bol.BolId AND bam.BtaID = bol.BtaId
							WHERE bam.AmoId = amd.AmoId
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
							),
							"-"
						)
				)
				
			
			) AS TopCodigo,
				
			IFNULL(
			top.TopNombre,
			
				IFNULL(
					(	
					
						SELECT
						CONCAT("Venta")
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblfacfactura fac
							ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
						WHERE fam.AmoId = amd.AmoId
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
						
					),
						IFNULL(	
							(
							SELECT
							CONCAT("Venta")
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol
								ON bam.BolId = bol.BolId AND bam.BtaID = bol.BtaId
							WHERE bam.AmoId = amd.AmoId
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
							),
							"-"
						)
				)
				
			
			) AS TopNombre,
			
			
			
			

			IFNULL(
			amo.AmoComprobanteNumero,

				IFNULL(
					(

						SELECT 
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
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
							
					),
						IFNULL(
						(
							
							SELECT 
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE amd.AmoId = fac.AmoId
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
							
						),
							IFNULL(
								(
								SELECT 
								CONCAT(fta.FtaNumero,"-",fac.FacId) 
								FROM tblfamfacturaalmacenmovimiento fam
									LEFT JOIN tblfacfactura fac
									ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
										LEFT JOIN tblftafacturatalonario fta
										ON fac.FtaId = fta.FtaId
									WHERE fam.AmoId = amd.AmoId
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
								,
									IFNULL(
										(
											SELECT 
											CONCAT(bta.BtaNumero,"-",bol.BolId) 
											FROM tblbolboleta bol
												LEFT JOIN tblbtaboletatalonario bta
												ON bol.BtaId = bta.BtaId
													LEFT JOIN tblbdeboletadetalle bde
													ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
													
											WHERE amd.AmdId = bde.AmdId
											AND bol.BolEstado <> 6 
											
											AND NOT EXISTS(
												SELECT 	
												ncr.NcrId
												FROM tblncrnotacredito ncr
												WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
												AND ncr.NcrEstado <> 6
												AND ncr.NcrMotivoCodigo <> "04"
												AND ncr.NcrMotivoCodigo <> "05"
												AND ncr.NcrMotivoCodigo <> "09"
											)
											
											
											
											
											LIMIT 1
										)
									,
										IFNULL(
											(
												SELECT 
												CONCAT(bta.BtaNumero,"-",bol.BolId)
												FROM tblbolboleta bol
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE amd.AmoId = bol.AmoId
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
										,

											(
											SELECT 
											CONCAT(bta.BtaNumero,"-",bol.BolId) 
											FROM tblbamboletaalmacenmovimiento bam
												LEFT JOIN tblbolboleta bol
												ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE bam.AmoId = amd.AmoId
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
											
										)
									)


								
							)
						
						)
					)
				
			) AS KdxComprobanteNumero,
			
			








			DATE_FORMAT(
			
						IFNULL(
						
						amo.AmoComprobanteFecha,
			
							IFNULL(
								(
			
									SELECT 
										fac.FacFechaEmision
										FROM tblfacfactura fac
											LEFT JOIN tblftafacturatalonario fta
											ON fac.FtaId = fta.FtaId
												LEFT JOIN tblfdefacturadetalle fde
												ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
												
										WHERE amd.AmdId = fde.AmdId
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
										
								),
									IFNULL(
									(
										
										SELECT 
										fac.FacFechaEmision
										FROM tblfacfactura fac
											LEFT JOIN tblftafacturatalonario fta
											ON fac.FtaId = fta.FtaId
										WHERE amd.AmoId = fac.AmoId
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
										
									),
										IFNULL(
											(
											SELECT 
											fac.FacFechaEmision
											FROM tblfamfacturaalmacenmovimiento fam
												LEFT JOIN tblfacfactura fac
												ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
													LEFT JOIN tblftafacturatalonario fta
													ON fac.FtaId = fta.FtaId
												WHERE fam.AmoId = amd.AmoId
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
											,
												IFNULL(
													(
														SELECT 
														bol.BolFechaEmision
														FROM tblbolboleta bol
															LEFT JOIN tblbtaboletatalonario bta
															ON bol.BtaId = bta.BtaId
																LEFT JOIN tblbdeboletadetalle bde
																ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
																
														WHERE amd.AmdId = bde.AmdId
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
												,
													IFNULL(
														(
															SELECT 
														bol.BolFechaEmision
															FROM tblbolboleta bol
																LEFT JOIN tblbtaboletatalonario bta
																ON bol.BtaId = bta.BtaId
															WHERE amd.AmoId = bol.AmoId
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
													,
			
														IFNULL(
														(
														
															SELECT 
															bol.BolFechaEmision
															FROM tblbamboletaalmacenmovimiento bam
																LEFT JOIN tblbolboleta bol
																ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
																	LEFT JOIN tblbtaboletatalonario bta
																	ON bol.BtaId = bta.BtaId
																WHERE bam.AmoId = amd.AmoId
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
														), 
														
														(amo.AmoFecha)
														
														)
														
													)
												)
			
			
											
										)
									
									)
								)
							
						)
			
			, "%d/%m/%Y") AS "KdxComprobanteFecha",
			
			
			
			
			
			
			
			
			
			
			(
				SELECT 
				gar.GarNumeroComprobante FROM tblgargarantia gar
				LEFT JOIN tblfccfichaaccion fcc
				ON gar.FccId = fcc.FccId
				LEFT JOIN tblamoalmacenmovimiento amo2
				ON amo2.FccId = fcc.FccId
				WHERE amo2.AmoId = amo.AmoId
			) AS KdxComprobanteNumero2,




			IFNULL(
			cti.CtiNombre,

				IFNULL(
					(

						SELECT 
							CONCAT("Factura")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
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
							
					),
						IFNULL(
						(
							
							SELECT 
							CONCAT("Factura")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE amd.AmoId = fac.AmoId
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
							
						),
							IFNULL(
								(
								SELECT 
								CONCAT("Factura")
								FROM tblfamfacturaalmacenmovimiento fam
									LEFT JOIN tblfacfactura fac
									ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
										LEFT JOIN tblftafacturatalonario fta
										ON fac.FtaId = fta.FtaId
									WHERE fam.AmoId = amd.AmoId
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
								,
									IFNULL(
										(
											SELECT 
											CONCAT("Boleta")
											FROM tblbolboleta bol
												LEFT JOIN tblbtaboletatalonario bta
												ON bol.BtaId = bta.BtaId
													LEFT JOIN tblbdeboletadetalle bde
													ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
													
											WHERE amd.AmdId = bde.AmdId
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
									,
										IFNULL(
											(
												SELECT 
												CONCAT("Boleta")
												FROM tblbolboleta bol
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE amd.AmoId = bol.AmoId
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
										,

											(
											SELECT 
											CONCAT("Boleta")
											FROM tblbamboletaalmacenmovimiento bam
												LEFT JOIN tblbolboleta bol
												ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE bam.AmoId = amd.AmoId
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
											
										)
									)


								
							)
						
						)
					)
				
			) AS CtiNombre,



			
			
			
			
			
			
				IFNULL(
			cti.CtiCodigo,

				IFNULL(
					(

						SELECT 
							CONCAT("01")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
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
							
					),
						IFNULL(
						(
							
							SELECT 
							CONCAT("01")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE amd.AmoId = fac.AmoId
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
							
						),
							IFNULL(
								(
								SELECT 
								CONCAT("01")
								FROM tblfamfacturaalmacenmovimiento fam
									LEFT JOIN tblfacfactura fac
									ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
										LEFT JOIN tblftafacturatalonario fta
										ON fac.FtaId = fta.FtaId
									WHERE fam.AmoId = amd.AmoId
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
								,
									IFNULL(
										(
											SELECT 
											CONCAT("03")
											FROM tblbolboleta bol
												LEFT JOIN tblbtaboletatalonario bta
												ON bol.BtaId = bta.BtaId
													LEFT JOIN tblbdeboletadetalle bde
													ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
													
											WHERE amd.AmdId = bde.AmdId
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
									,
										IFNULL(
											(
												SELECT 
												CONCAT("03")
												FROM tblbolboleta bol
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE amd.AmoId = bol.AmoId
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
										,

											(
											SELECT 
											CONCAT("03")
											FROM tblbamboletaalmacenmovimiento bam
												LEFT JOIN tblbolboleta bol
												ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE bam.AmoId = amd.AmoId
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
											
										)
									)


								
							)
						
						)
					)
				
			) AS CtiCodigo,
			
			








			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			
			rti.RtiNombre,
			
			amo.TopId,
			
			amo.AmoTipoCambio AS KdxTipoCambio,
			amo.MonId,
			
			
			amo.AmoTipoMovimiento,
			
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,
			
			pca.PcaNombre,
			
			umc.UmcEquivalente,
			
			suc.SucNombre,
			vma.VmaNombre,
			
			amo.FccId,
			amo.VdiId,
			
			min.MinNombre,
			
			ume.UmeCodigo
			
			
			FROM tblamdalmacenmovimientodetalle amd
				
				
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					
					LEFT JOIN tblumcunidadmedidaconversion umc
					ON amd.UmeId = umc.UmeId2 AND  pro.UmeId = umc.UmeId1
					
							LEFT JOIN tblpcaproductocategoria pca
							ON pro.PcaId = pca.PcaId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
							
							LEFT JOIN tblumeunidadmedida ume
							ON amd.UmeId = ume.UmeId	
											
								LEFT  JOIN tblamoalmacenmovimiento amo
								ON amd.AmoId = amo.AmoId
								
									LEFT JOIN tbltoptipooperacion top
									ON amo.TopId = top.TopId
									
										LEFT JOIN tblcticomprobantetipo cti
										ON amo.CtiId = cti.CtiId
								
				LEFT JOIN tblclicliente cli
				ON amo.CliId = cli.CliId
				
				LEFT JOIN tblprvproveedor prv
				ON amo.PrvId = prv.PrvId
				
					LEFT JOIN tblsucsucursal suc
					ON amo.SucId = suc.SucId
					
						LEFT JOIN tblvmavehiculomarca vma
						ON pro.VmaId = vma.VmaId
						
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
									LEFT JOIN tblminmodalidadingreso min
									ON fim.MinId = min.MinId
								
					
			WHERE  amd.AmdEstado = 3 
			
				
			'.$fecha.$producto.$filtrar.$sucursal.$moneda.$almacen.$stipo.$orden.$paginacion;	
	
/*
UNION ALL 
			
			SELECT 
			
			FROM tblncdnotacreditodetalle ncd
			
				LEFT JOIN tblproproducto ncd
				ON ncd.ProId = pro.ProId
					
					LEFT JOIN tblumeunidadmedida ume
					ON pro.UmeId = ume.UmeId
						LEFT JOIN tblrtiproductotipo rti
						ON pro.RtiId = rti.
						
*/
		//MK0EH6453
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsKardex = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Kardex = new $InsKardex();
                    $Kardex->KdxId = $fila['KdxId'];
					$Kardex->TalId = $fila['TalId'];
					$Kardex->PprId = $fila['PprId'];
				
                    $Kardex->KdxFecha = $fila['KdxFecha'];
					$Kardex->ProId = $fila['ProId'];
					$Kardex->UmeId = $fila['UmeId'];
					$Kardex->KdxCostoUnitario = $fila['KdxCostoUnitario'];
			        $Kardex->KdxCantidad = $fila['KdxCantidad'];  
					$Kardex->KdxCostoTotal = $fila['KdxCostoTotal'];  
					$Kardex->KdxMovimientoTipo = $fila['KdxMovimientoTipo'];
					$Kardex->KdxMovimientoSubTipo = $fila['KdxMovimientoSubTipo'];
					
					$Kardex->KdxTiempoCreacion = $fila['KdxTiempoCreacion'];
					
					$Kardex->ProNombre = $fila['ProNombre'];
$Kardex->ProMarcaReferencia = $fila['ProMarcaReferencia'];
					$Kardex->RtiId = $fila['RtiId'];			
					$Kardex->KdxUbicacion = $fila['KdxUbicacion'];			
					
					
					$Kardex->UmeNombre = $fila['UmeNombre'];
					
					$Kardex->TopCodigo = $fila['TopCodigo'];
					$Kardex->TopNombre = $fila['TopNombre'];
					
					$Kardex->KdxComprobanteNumero = $fila['KdxComprobanteNumero'];
					$Kardex->KdxComprobanteNumero2 = $fila['KdxComprobanteNumero2'];
					$Kardex->KdxComprobanteFecha = $fila['KdxComprobanteFecha'];
					
					
					$Kardex->CtiNombre = $fila['CtiNombre'];
					$Kardex->CtiCodigo = $fila['CtiCodigo'];
					
					$Kardex->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$Kardex->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					
					$Kardex->RtiNombre = $fila['RtiNombre'];
				
					$Kardex->TopId = $fila['TopId'];
					
					$Kardex->KdxTipoCambio = $fila['KdxTipoCambio'];
					$Kardex->MonId = $fila['MonId'];
					$Kardex->KdxTipoMovimiento = $fila['AmoTipoMovimiento'];
					
					$Kardex->CliNombre = $fila['CliNombre'];
					$Kardex->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$Kardex->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$Kardex->PrvNombre = $fila['PrvNombre'];
					$Kardex->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$Kardex->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					
					$Kardex->PcaNombre = $fila['PcaNombre'];
					$Kardex->UmcEquivalente = $fila['UmcEquivalente'];
				
				
					$Kardex->SucNombre = $fila['SucNombre'];
					$Kardex->VmaNombre = $fila['VmaNombre'];
					
					
						$Kardex->FccId = $fila['FccId'];
					$Kardex->VdiId = $fila['VdiId'];
					$Kardex->MinNombre = $fila['MinNombre'];
					
					$Kardex->UmeCodigo = $fila['UmeCodigo'];
					
					if(!empty($Kardex->FccId)){
						
						$Kardex->KdxTipoMovimiento = strtoupper($fila['MinNombre']);
						
					}elseif (!empty($Kardex->VdiId)){
						
						$Kardex->KdxTipoMovimiento = "VENTA X MOSTRADOR";
						
					}elseif (($Kardex->KdxMovimientoTipo == 1 and $Kardex->KdxMovimientoSubTipo == 1)){

						$Kardex->KdxTipoMovimiento = "COMPRA";
						
					}
						
                    $Kardex->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Kardex;
                }
						
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

    public function MtdObtenerKardexs($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="AmoFecha",$oAlmacen=NULL,$oSucursal=NULL) {

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
		

		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
	
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFechaTipo.')>="'.$oFechaInicio.'" AND DATE('.$oFechaTipo.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oFechaTipo.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFechaTipo.')<="'.$oFechaFin.'"';		
			}			
		}
//			amd.AmdCostoTotal AS KdxCostoUnitario,		
//			amd.AmdCostoTotal * amd.AmdCantidadReal AS KdxCostoTotal,

//			ROUND(amd.AmdCosto/amd.AmdCantidadReal,3) AS KdxCostoUnitario,
//			
//			amd.AmdCantidadReal AS KdxCantidad,
//			(ROUND(amd.AmdCosto/amd.AmdCantidadReal,3) * amd.AmdCantidadReal) AS KdxCostoTotal,

//		if($oUso==1){
//			$uso = '
//			(amd.AmdImporte/amd.AmdCantidadReal) AS KdxCostoUnitario,
//			amd.AmdCantidadReal AS KdxCantidad,
//			((amd.AmdImporte/amd.AmdCantidadReal) * amd.AmdCantidadReal) AS KdxCostoTotal,
//			
//			';	
//			
//		}else{
//			$uso = '
//			(amd.AmdImporte/amd.AmdCantidad) AS KdxCostoUnitario,
//			amd.AmdCantidad AS KdxCantidad,
//			((amd.AmdImporte/amd.AmdCantidad) * amd.AmdCantidad) AS KdxCostoTotal,
//			';	
//		}

		/*if($oUso==3){
			
			$uso = '
			(amd.AmdValorTotal/(amd.AmdCantidadReal/amd.AmdCantidad)) AS KdxCostoUnitario,
			amd.AmdCantidadReal AS KdxCantidad,
			((AmdValorTotal/(amd.AmdCantidadReal/amd.AmdCantidad)) * amd.AmdCantidadReal) AS KdxCostoTotal,
			
			';	
			
		}else{
			
			$uso = '
			(AmdValorTotal) AS KdxCostoUnitario,
			
			(amd.AmdCantidadReal/umc.UmcEquivalente) AS KdxCantidad,
			
			((AmdValorTotal) * (amd.AmdCantidadReal/umc.UmcEquivalente) ) AS KdxCostoTotal,
			';	
			
		}*/


	
			
		
			
		$uso = '
		
			(amd.AmdCosto) AS KdxCostoUnitario,
			
			(amd.AmdCantidad) AS KdxCantidad,
			
			(amd.AmdImporte) AS KdxCostoTotal,
			
			';	
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND (amo.MonId = "'.$oMoneda.'") ';
		}
		
	    /*
		ENTRADS
		
		1 COMPRAS
		2 OTROS CONCEPTOS
		3 
		4 		
		5 
		6 TRASLADOS
		
		SALDIAS
		
		1 
		2 TALLER
		3 VENTAS X MOSTRADOR
		4 OTROS CONCEPTOS
		
		5 NC COMPRA
		6 TRASLADOS
		
		*/
	
		if(!empty($oSucursal)){
			
			$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
			
			$stipo = ' AND (
			
				( 
				amo.AmoTipo = 2 
					AND (
						
						amo.AmoSubTipo = 2 
						OR amo.AmoSubTipo = 3 
						OR amo.AmoSubTipo = 4 
						OR amo.AmoSubTipo = 5
						OR amo.AmoSubTipo = 6
												
						OR (amo.AmoSubTipo = 1 AND amo.TopId = "TOP-10010") 
						OR (amo.AmoSubTipo = 1 AND amo.TopId = "TOP-10015")

					) 
				) 
				
				OR 
				
				(
				 	amo.AmoTipo = 1 AND (
				 
					 amo.AmoSubTipo = 1 
					 OR amo.AmoSubTipo = 2 
					 OR amo.AmoSubTipo = 6
					 
					 ) 
				 
				)
			
			)';
			
			
		}else{
			
			//$stipo = ' AND (
//			amo.AmoSubTipo = 2	OR 
//			amo.AmoSubTipo = 3 OR 
//			(amo.AmoSubTipo = 1 AND amo.TopId = "TOP-10010") OR
//			amo.AmoTipoMovimiento IS NOT NULL
//		
//			)';

			$stipo = ' AND (
			
			( 
			
			amo.AmoTipo = 2 
			
				AND ( 
				
					amo.AmoSubTipo = 2 
					OR amo.AmoSubTipo = 3
					OR amo.AmoSubTipo = 4 
					OR amo.AmoSubTipo = 5 
				)  
				
				AND amo.TopId <> "TOP-10010"
			) 
			
			OR 
			
				(
				
					amo.AmoTipo = 1 
					
					AND (
					
						amo.AmoSubTipo = 1 
						OR amo.AmoSubTipo = 2
						
						
					) 
					
					AND amo.TopId <> "TOP-10010"
					
				)
			
			)';
			
		}

		//TOP-10010 transfernecias
		//TOP-10015 SALDO INICIALES

//		if(!empty($oSucursal)){
//			$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
//		}
//		
//		
//		if(!empty($oAlmacen)){
//			$almacen = ' AND (amd.AlmId = "'.$oAlmacen.'") ';
//			$stipo = "";
//		}else{
//			$stipo = ' AND (
//			amo.AmoSubTipo = 1	OR 
//			amo.AmoSubTipo = 2 OR 
//			amo.AmoSubTipo = 3 OR 
//			amo.AmoSubTipo = 4 OR 
//			amo.AmoSubTipo = 7 OR 
//			amo.AmoSubTipo = 5
//			)';
//		}
//
//
//	if(empty($oSucursal) and empty($oSucursal)){
//		
//		$stipo = ' AND (
//			amo.TopId <> "TOP-10010"
//			)';
//			
//	}
	
	
//
//		if(!empty($oAlmacenMovimientoSubTipo)){
//
//			$elementos = explode(",",$oAlmacenMovimientoSubTipo);
//
//			$i=1;
//			$amstipo .= ' AND (
//			(';
//			$elementos = array_filter($elementos);
//			foreach($elementos as $elemento){
//				$amstipo .= '  (amo.AmoSubTipo = "'.($elemento).'" )';
//				if($i<>count($elementos)){						
//					$amstipo .= ' OR ';	
//				}
//			$i++;		
//			}
//
//			$amstipo .= ' ) 
//			)
//			';
//
//		}
//		
		
//16.746196



		$sql = '

			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmoId AS KdxId,
			amo.TalId,
			amo.PprId,
			amo.TptId,
			
			DATE_FORMAT('.$oFechaTipo.', "%d/%m/%Y") AS "KdxFecha",
			amd.ProId,
			amd.UmeId,
			
			'.$uso.'			
			
			amo.AmoTipo AS "KdxMovimientoTipo",
			amo.AmoSubTipo AS "KdxMovimientoSubTipo",
			
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS KdxTiempoCreacion,
			pro.ProNombre,
pro.ProMarcaReferencia,
			pro.RtiId,
			pro.ProUbicacion AS KdxUbicacion,
			ume.UmeNombre,
		

			IFNULL(
			top.TopCodigo,
			
				IFNULL(
					(	
						
						SELECT
						CONCAT("01")
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblfacfactura fac
							ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
						WHERE fam.AmoId = amd.AmoId
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
					
					),
						IFNULL(	
							(
							SELECT
							CONCAT("01")
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol
								ON bam.BolId = bol.BolId AND bam.BtaID = bol.BtaId
							WHERE bam.AmoId = amd.AmoId
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
							),
							"-"
						)
				)
				
			
			) AS TopCodigo,
				
			IFNULL(
			top.TopNombre,
			
				IFNULL(
					(	
					
						SELECT
						CONCAT("Venta")
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblfacfactura fac
							ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
						WHERE fam.AmoId = amd.AmoId
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
						
					),
						IFNULL(	
							(
							SELECT
							CONCAT("Venta")
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol
								ON bam.BolId = bol.BolId AND bam.BtaID = bol.BtaId
							WHERE bam.AmoId = amd.AmoId
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
							),
							"-"
						)
				)
				
			
			) AS TopNombre,
			
			
			
			

			IFNULL(
			amo.AmoComprobanteNumero,

				IFNULL(
					(

						SELECT 
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
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
							
					),
						IFNULL(
						(
							
							SELECT 
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE amd.AmoId = fac.AmoId
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
							
						),
							IFNULL(
								(
								SELECT 
								CONCAT(fta.FtaNumero,"-",fac.FacId) 
								FROM tblfamfacturaalmacenmovimiento fam
									LEFT JOIN tblfacfactura fac
									ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
										LEFT JOIN tblftafacturatalonario fta
										ON fac.FtaId = fta.FtaId
									WHERE fam.AmoId = amd.AmoId
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
								,
									IFNULL(
										(
											SELECT 
											CONCAT(bta.BtaNumero,"-",bol.BolId) 
											FROM tblbolboleta bol
												LEFT JOIN tblbtaboletatalonario bta
												ON bol.BtaId = bta.BtaId
													LEFT JOIN tblbdeboletadetalle bde
													ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
													
											WHERE amd.AmdId = bde.AmdId
											AND bol.BolEstado <> 6 
											
											AND NOT EXISTS(
												SELECT 	
												ncr.NcrId
												FROM tblncrnotacredito ncr
												WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
												AND ncr.NcrEstado <> 6
												AND ncr.NcrMotivoCodigo <> "04"
												AND ncr.NcrMotivoCodigo <> "05"
												AND ncr.NcrMotivoCodigo <> "09"
											)
											
											
											
											
											LIMIT 1
										)
									,
										IFNULL(
											(
												SELECT 
												CONCAT(bta.BtaNumero,"-",bol.BolId)
												FROM tblbolboleta bol
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE amd.AmoId = bol.AmoId
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
										,

											(
											SELECT 
											CONCAT(bta.BtaNumero,"-",bol.BolId) 
											FROM tblbamboletaalmacenmovimiento bam
												LEFT JOIN tblbolboleta bol
												ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE bam.AmoId = amd.AmoId
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
											
										)
									)


								
							)
						
						)
					)
				
			) AS KdxComprobanteNumero,
			
			


			DATE_FORMAT(
			
						IFNULL(
						amo.AmoComprobanteFecha,
			
							IFNULL(
								(
			
									SELECT 
										fac.FacFechaEmision
										FROM tblfacfactura fac
											LEFT JOIN tblftafacturatalonario fta
											ON fac.FtaId = fta.FtaId
												LEFT JOIN tblfdefacturadetalle fde
												ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
												
										WHERE amd.AmdId = fde.AmdId
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
										
								),
									IFNULL(
									(
										
										SELECT 
										fac.FacFechaEmision
										FROM tblfacfactura fac
											LEFT JOIN tblftafacturatalonario fta
											ON fac.FtaId = fta.FtaId
										WHERE amd.AmoId = fac.AmoId
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
										
									),
										IFNULL(
											(
											SELECT 
											fac.FacFechaEmision
											FROM tblfamfacturaalmacenmovimiento fam
												LEFT JOIN tblfacfactura fac
												ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
													LEFT JOIN tblftafacturatalonario fta
													ON fac.FtaId = fta.FtaId
												WHERE fam.AmoId = amd.AmoId
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
											,
												IFNULL(
													(
														SELECT 
														bol.BolFechaEmision
														FROM tblbolboleta bol
															LEFT JOIN tblbtaboletatalonario bta
															ON bol.BtaId = bta.BtaId
																LEFT JOIN tblbdeboletadetalle bde
																ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
																
														WHERE amd.AmdId = bde.AmdId
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
												,
													IFNULL(
														(
															SELECT 
														bol.BolFechaEmision
															FROM tblbolboleta bol
																LEFT JOIN tblbtaboletatalonario bta
																ON bol.BtaId = bta.BtaId
															WHERE amd.AmoId = bol.AmoId
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
													,
			
														(
														SELECT 
													bol.BolFechaEmision
														FROM tblbamboletaalmacenmovimiento bam
															LEFT JOIN tblbolboleta bol
															ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
																LEFT JOIN tblbtaboletatalonario bta
																ON bol.BtaId = bta.BtaId
															WHERE bam.AmoId = amd.AmoId
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
														
													)
												)
			
			
											
										)
									
									)
								)
							
						)
			
			, "%d/%m/%Y") AS "KdxComprobanteFecha",
			
			
			(
				SELECT 
				gar.GarNumeroComprobante FROM tblgargarantia gar
				LEFT JOIN tblfccfichaaccion fcc
				ON gar.FccId = fcc.FccId
				LEFT JOIN tblamoalmacenmovimiento amo2
				ON amo2.FccId = fcc.FccId
				WHERE amo2.AmoId = amo.AmoId
			) AS KdxComprobanteNumero2,




			IFNULL(
			cti.CtiNombre,

				IFNULL(
					(

						SELECT 
							CONCAT("Factura")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
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
							
					),
						IFNULL(
						(
							
							SELECT 
							CONCAT("Factura")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE amd.AmoId = fac.AmoId
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
							
						),
							IFNULL(
								(
								SELECT 
								CONCAT("Factura")
								FROM tblfamfacturaalmacenmovimiento fam
									LEFT JOIN tblfacfactura fac
									ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
										LEFT JOIN tblftafacturatalonario fta
										ON fac.FtaId = fta.FtaId
									WHERE fam.AmoId = amd.AmoId
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
								,
									IFNULL(
										(
											SELECT 
											CONCAT("Boleta")
											FROM tblbolboleta bol
												LEFT JOIN tblbtaboletatalonario bta
												ON bol.BtaId = bta.BtaId
													LEFT JOIN tblbdeboletadetalle bde
													ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
													
											WHERE amd.AmdId = bde.AmdId
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
									,
										IFNULL(
											(
												SELECT 
												CONCAT("Boleta")
												FROM tblbolboleta bol
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE amd.AmoId = bol.AmoId
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
										,

											(
											SELECT 
											CONCAT("Boleta")
											FROM tblbamboletaalmacenmovimiento bam
												LEFT JOIN tblbolboleta bol
												ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE bam.AmoId = amd.AmoId
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
											
										)
									)


								
							)
						
						)
					)
				
			) AS CtiNombre,



			
			
			
				IFNULL(
			cti.CtiCodigo,

				IFNULL(
					(

						SELECT 
							CONCAT("01")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE amd.AmdId = fde.AmdId
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
							
					),
						IFNULL(
						(
							
							SELECT 
							CONCAT("01")
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE amd.AmoId = fac.AmoId
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
							
						),
							IFNULL(
								(
								SELECT 
								CONCAT("01")
								FROM tblfamfacturaalmacenmovimiento fam
									LEFT JOIN tblfacfactura fac
									ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
										LEFT JOIN tblftafacturatalonario fta
										ON fac.FtaId = fta.FtaId
									WHERE fam.AmoId = amd.AmoId
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
								,
									IFNULL(
										(
											SELECT 
											CONCAT("03")
											FROM tblbolboleta bol
												LEFT JOIN tblbtaboletatalonario bta
												ON bol.BtaId = bta.BtaId
													LEFT JOIN tblbdeboletadetalle bde
													ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
													
											WHERE amd.AmdId = bde.AmdId
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
									,
										IFNULL(
											(
												SELECT 
												CONCAT("03")
												FROM tblbolboleta bol
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE amd.AmoId = bol.AmoId
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
										,

											(
											SELECT 
											CONCAT("03")
											FROM tblbamboletaalmacenmovimiento bam
												LEFT JOIN tblbolboleta bol
												ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
													LEFT JOIN tblbtaboletatalonario bta
													ON bol.BtaId = bta.BtaId
												WHERE bam.AmoId = amd.AmoId
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
											
										)
									)


								
							)
						
						)
					)
				
			) AS CtiCodigo,
			
			



			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			
			rti.RtiNombre,
			
			amo.TopId,
			
			amo.AmoTipoCambio AS KdxTipoCambio,
			amo.MonId,
			
			
			amo.AmoTipoMovimiento,
			
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,
			
			pca.PcaNombre,
			
			umc.UmcEquivalente,
			
			suc.SucNombre,
			vma.VmaNombre,
			
			amo.FccId,
			amo.VdiId,
			
			min.MinNombre,
			
			ume.UmeCodigo
			
			
			FROM tblamdalmacenmovimientodetalle amd
				
				
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					
					LEFT JOIN tblumcunidadmedidaconversion umc
					ON amd.UmeId = umc.UmeId2 AND  pro.UmeId = umc.UmeId1
					
							LEFT JOIN tblpcaproductocategoria pca
							ON pro.PcaId = pca.PcaId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
							
							LEFT JOIN tblumeunidadmedida ume
							ON amd.UmeId = ume.UmeId	
											
								LEFT  JOIN tblamoalmacenmovimiento amo
								ON amd.AmoId = amo.AmoId
								
									LEFT JOIN tbltoptipooperacion top
									ON amo.TopId = top.TopId
									
										LEFT JOIN tblcticomprobantetipo cti
										ON amo.CtiId = cti.CtiId
								
				LEFT JOIN tblclicliente cli
				ON amo.CliId = cli.CliId
				
				LEFT JOIN tblprvproveedor prv
				ON amo.PrvId = prv.PrvId
				
					LEFT JOIN tblsucsucursal suc
					ON amo.SucId = suc.SucId
					
						LEFT JOIN tblvmavehiculomarca vma
						ON pro.VmaId = vma.VmaId
						
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
							
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
									LEFT JOIN tblminmodalidadingreso min
									ON fim.MinId = min.MinId
								
					
			WHERE  amd.AmdEstado = 3 
			
				
			'.$fecha.$producto.$filtrar.$sucursal.$moneda.$almacen.$stipo.$orden.$paginacion;	
	
/*
UNION ALL 
			
			SELECT 
			
			FROM tblncdnotacreditodetalle ncd
			
				LEFT JOIN tblproproducto ncd
				ON ncd.ProId = pro.ProId
					
					LEFT JOIN tblumeunidadmedida ume
					ON pro.UmeId = ume.UmeId
						LEFT JOIN tblrtiproductotipo rti
						ON pro.RtiId = rti.
						
*/
		//MK0EH6453
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsKardex = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Kardex = new $InsKardex();
                    $Kardex->KdxId = $fila['KdxId'];
					$Kardex->TalId = $fila['TalId'];
					$Kardex->TptId = $fila['TptId'];
					
					
					$Kardex->PprId = $fila['PprId'];
				
                    $Kardex->KdxFecha = $fila['KdxFecha'];
					$Kardex->ProId = $fila['ProId'];
					$Kardex->UmeId = $fila['UmeId'];
					$Kardex->KdxCostoUnitario = $fila['KdxCostoUnitario'];
			        $Kardex->KdxCantidad = $fila['KdxCantidad'];  
					$Kardex->KdxCostoTotal = $fila['KdxCostoTotal'];  
					$Kardex->KdxMovimientoTipo = $fila['KdxMovimientoTipo'];
					$Kardex->KdxMovimientoSubTipo = $fila['KdxMovimientoSubTipo'];
					
					$Kardex->KdxTiempoCreacion = $fila['KdxTiempoCreacion'];
					
					$Kardex->ProNombre = $fila['ProNombre'];
$Kardex->ProMarcaReferencia = $fila['ProMarcaReferencia'];
					$Kardex->RtiId = $fila['RtiId'];			
					$Kardex->KdxUbicacion = $fila['KdxUbicacion'];			
					
					
					$Kardex->UmeNombre = $fila['UmeNombre'];
					
					$Kardex->TopCodigo = $fila['TopCodigo'];
					$Kardex->TopNombre = $fila['TopNombre'];
					
					$Kardex->KdxComprobanteNumero = $fila['KdxComprobanteNumero'];
					$Kardex->KdxComprobanteNumero2 = $fila['KdxComprobanteNumero2'];
					$Kardex->KdxComprobanteFecha = $fila['KdxComprobanteFecha'];
					
					
					$Kardex->CtiNombre = $fila['CtiNombre'];
					$Kardex->CtiCodigo = $fila['CtiCodigo'];
					
					$Kardex->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$Kardex->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					
					$Kardex->RtiNombre = $fila['RtiNombre'];
				
					$Kardex->TopId = $fila['TopId'];
					
					$Kardex->KdxTipoCambio = $fila['KdxTipoCambio'];
					$Kardex->MonId = $fila['MonId'];
					$Kardex->KdxTipoMovimiento = $fila['AmoTipoMovimiento'];
					
					$Kardex->CliNombre = $fila['CliNombre'];
					$Kardex->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$Kardex->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$Kardex->PrvNombre = $fila['PrvNombre'];
					$Kardex->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$Kardex->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					
					$Kardex->PcaNombre = $fila['PcaNombre'];
					$Kardex->UmcEquivalente = $fila['UmcEquivalente'];
				
				
					$Kardex->SucNombre = $fila['SucNombre'];
					$Kardex->VmaNombre = $fila['VmaNombre'];
					
					
						$Kardex->FccId = $fila['FccId'];
					$Kardex->VdiId = $fila['VdiId'];
					$Kardex->MinNombre = $fila['MinNombre'];
					
					$Kardex->UmeCodigo = $fila['UmeCodigo'];
					
					if(!empty($Kardex->FccId)){
						
						$Kardex->KdxTipoMovimiento = strtoupper($fila['MinNombre']);
						
					}elseif (!empty($Kardex->VdiId)){
						
						$Kardex->KdxTipoMovimiento = "VENTA X MOSTRADOR";
						
					}elseif (($Kardex->KdxMovimientoTipo == 1 and $Kardex->KdxMovimientoSubTipo == 1)){

						$Kardex->KdxTipoMovimiento = "COMPRA";
						
					}
						
                    $Kardex->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Kardex;
                }
						
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	 public function MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oAlmacenMovimientoEntrada)){
			$amovimiento = ' AND amd.AmoId = "'.$oAlmacenMovimientoEntrada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		//if(!empty($oFechaInicio)){
//			
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
//			}else{
//				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
//			}
//			
//		}else{
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
//			}			
//		}

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amd.AmdFecha)>="'.$oFechaInicio.'" AND DATE(amd.AmdFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amd.AmdFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amd.AmdFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oCliente)){
			$cliente = ' AND (pco.CliId = "'.$oCliente.'") ';
		}
		
		switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND amo.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND amo.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND (pco.OcoId = "'.$oOrdenCompra.'") ';
		}	
		
		if(!empty($oPedidoCompraDetalleId)){
			$pcdetalle = ' AND (amd.PcdId = "'.$oPedidoCompraDetalleId.'") ';
		}	
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (pcd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}
		
		//if(!empty($oAlmacenId)){
//			$almacen = ' AND (amo.AlmId = "'.$oAlmacenId.'") ';
//		}	
		
		
		if(!empty($oAlmacenId)){
			$almacen = ' AND (amd.AlmId = "'.$oAlmacenId.'") ';
		}	
		
		
		if(!empty($oAlmacenMovimientoSubTipo)){

			$elementos = explode(",",$oAlmacenMovimientoSubTipo);

			$i=1;
			$amstipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$amstipo .= '  (amo.AmoSubTipo = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$amstipo .= ' OR ';	
				}
			$i++;		
			}

			$amstipo .= ' ) 
			)
			';

		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
		}	
	
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId,			
			amd.AmoId,
			amo.TalId,
			amo.PprId,
			amo.TptId,
			
			amd.ProId,
			amd.UmeId,
			amd.AmdIdAnterior,
			amd.AmdCosto,
			amd.AmdCostoAnterior,
			amd.AmdCostoExtraTotal,
			amd.AmdCostoExtraUnitario,
			amd.AmdValorTotal,
			amd.AmdCantidad,
			amd.AmdCantidadReal,
			amd.AmdImporte,
			amd.AmdCostoPromedio,

			amd.AmdInternacionalTotalAduana,
			amd.AmdInternacionalTotalTransporte,
			amd.AmdInternacionalTotalDesestiba,
			amd.AmdInternacionalTotalAlmacenaje,
			amd.AmdInternacionalTotalAdValorem,
			amd.AmdInternacionalTotalAduanaNacional,
			amd.AmdInternacionalTotalGastoAdministrativo,
			amd.AmdInternacionalTotalOtroCosto1,
			amd.AmdInternacionalTotalOtroCosto2,

			amd.AmdNacionalTotalRecargo,
			amd.AmdNacionalTotalFlete,
			amd.AmdNacionalTotalOtroCosto,
			
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProNombre,
pro.ProMarcaReferencia,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			pro.UmeId AS UmeIdOrigen,
			ume2.UmeNombre AS UmeNombreOrigen,

			ume.UmeNombre,
			ume.UmeAbreviacion,

			DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			amo.AmoComprobanteNumero,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			cti.CtiNombre,

			amo.AmoTotalNacional,
			amo.AmoTotalInternacional,
			amo.AmoSubTotal,

			prv.PrvNombreCompleto,
			prv.PrvNumeroDocumento,

			top.TopNombre,

			amo.AmoComprobanteNumero,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",

			DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
			cli.CliNombreCompleto,

			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,

			pcd.PcoId,

			pcd.PcdAno,
			pcd.PcdModelo,
			
			
			
			pco.OcoId,

			amo.TopId,

			(
				SELECT 
				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			) AS AmoFechaUltimaSalida,

			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos,

			oco.OcoTipo,
			
			amo.AmoTipo,
			amo.AmoSubTipo

			FROM tblamdalmacenmovimientodetalle amd

				LEFT JOIN tblpcdpedidocompradetalle pcd
				ON amd.PcdId = pcd.PcdId
					
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
						LEFT JOIN tblocoordencompra oco
						ON pco.OcoId = oco.OcoId
						
						LEFT JOIN tblclicliente cli
						ON pco.CliId = cli.CliId
				
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId	
						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId
									
						LEFT  JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tbltoptipooperacion top
							ON amo.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON amo.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON amo.CtiId = cti.CtiId
			WHERE  amo.AmoTipo = 1 '.$amovimiento.$estado.$sucursal.$producto.$filtrar.$fecha.$amstipo.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoEntradaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoEntradaDetalle = new $InsAlmacenMovimientoEntradaDetalle();
                    $AlmacenMovimientoEntradaDetalle->AmdId = $fila['AmdId'];
                    $AlmacenMovimientoEntradaDetalle->AmoId = $fila['AmoId'];
					
					 $AlmacenMovimientoEntradaDetalle->TalId = $fila['TalId'];
					  $AlmacenMovimientoEntradaDetalle->PprId = $fila['PprId'];
					  $AlmacenMovimientoEntradaDetalle->TptId = $fila['TptId'];
				
			
					$AlmacenMovimientoEntradaDetalle->UmeId = $fila['UmeId'];
					$AlmacenMovimientoEntradaDetalle->AmdIdAnterior = $fila['AmdIdAnterior'];
					$AlmacenMovimientoEntradaDetalle->AmdCosto = $fila['AmdCosto'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoAnterior = $fila['AmdCostoAnterior'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoExtraTotal = $fila['AmdCostoExtraTotal'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoExtraUnitario = $fila['AmdCostoExtraUnitario'];
					$AlmacenMovimientoEntradaDetalle->AmdValorTotal = $fila['AmdValorTotal'];
			        $AlmacenMovimientoEntradaDetalle->AmdCantidad = $fila['AmdCantidad'];  
					$AlmacenMovimientoEntradaDetalle->AmdCantidadReal = $fila['AmdCantidadReal'];  
					
					$AlmacenMovimientoEntradaDetalle->AmdImporte = $fila['AmdImporte'];
					$AlmacenMovimientoEntradaDetalle->AmdCostoPromedio = $fila['AmdCostoPromedio'];
					
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduana = $fila['AmdInternacionalTotalAduana'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalTransporte = $fila['AmdInternacionalTotalTransporte'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalDesestiba = $fila['AmdInternacionalTotalDesestiba'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAlmacenaje = $fila['AmdInternacionalTotalAlmacenaje'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAdValorem = $fila['AmdInternacionalTotalAdValorem'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalAduanaNacional = $fila['AmdInternacionalTotalAduanaNacional'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalGastoAdministrativo = $fila['AmdInternacionalTotalGastoAdministrativo'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto1 = $fila['AmdInternacionalTotalOtroCosto1'];
					$AlmacenMovimientoEntradaDetalle->AmdInternacionalTotalOtroCosto2 = $fila['AmdInternacionalTotalOtroCosto2'];
					
					$AlmacenMovimientoEntradaDetalle->AmdNacionalTotalRecargo = $fila['AmdNacionalTotalRecargo'];
					$AlmacenMovimientoEntradaDetalle->AmdNacionalTotalFlete = $fila['AmdNacionalTotalFlete'];
					$AlmacenMovimientoEntradaDetalle->AmdNacionalTotalOtroCosto = $fila['AmdNacionalTotalOtroCosto'];
			
					
					$AlmacenMovimientoEntradaDetalle->AmdEstado = $fila['AmdEstado'];  
					$AlmacenMovimientoEntradaDetalle->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$AlmacenMovimientoEntradaDetalle->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
					$AlmacenMovimientoEntradaDetalle->ProId = $fila['ProId'];	
					
					$AlmacenMovimientoEntradaDetalle->AmoFecha = $fila['NAmoFecha'];	
					$AlmacenMovimientoEntradaDetalle->AmoComprobanteNumero = $fila['AmoComprobanteNumero'];	
					$AlmacenMovimientoEntradaDetalle->AmoComprobanteFecha = $fila['NAmoComprobanteFecha'];	
					$AlmacenMovimientoEntradaDetalle->CtiNombre = $fila['CtiNombre'];
					
					$AlmacenMovimientoEntradaDetalle->AmoTotalNacional = $fila['AmoTotalNacional'];
					$AlmacenMovimientoEntradaDetalle->AmoTotalInternacional = $fila['AmoTotalInternacional'];
					$AlmacenMovimientoEntradaDetalle->AmoSubTotal = $fila['AmoSubTotal'];
	
                    $AlmacenMovimientoEntradaDetalle->ProNombre = (($fila['ProNombre']));
					$AlmacenMovimientoEntradaDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$AlmacenMovimientoEntradaDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));					
					$AlmacenMovimientoEntradaDetalle->RtiId = (($fila['RtiId']));
					$AlmacenMovimientoEntradaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$AlmacenMovimientoEntradaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					$AlmacenMovimientoEntradaDetalle->UmeNombre = (($fila['UmeNombre']));
					$AlmacenMovimientoEntradaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$AlmacenMovimientoEntradaDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$AlmacenMovimientoEntradaDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$AlmacenMovimientoEntradaDetalle->TopNombre = (($fila['TopNombre']));

					$AlmacenMovimientoEntradaDetalle->AmoComprobanteNumero = (($fila['AmoComprobanteNumero']));
					$AlmacenMovimientoEntradaDetalle->AmoComprobanteFecha = (($fila['NAmoComprobanteFecha']));

					$AlmacenMovimientoEntradaDetalle->PcoFecha = (($fila['NPcoFecha']));
					$AlmacenMovimientoEntradaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					
					$AlmacenMovimientoEntradaDetalle->CliNombre = (($fila['CliNombre']));
					$AlmacenMovimientoEntradaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$AlmacenMovimientoEntradaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$AlmacenMovimientoEntradaDetalle->PcoId = (($fila['PcoId']));
					
					$AlmacenMovimientoEntradaDetalle->PcdAno = (($fila['PcdAno']));
					$AlmacenMovimientoEntradaDetalle->PcdModelo = (($fila['PcdModelo']));
					
					$AlmacenMovimientoEntradaDetalle->OcoId = (($fila['OcoId']));

					$AlmacenMovimientoEntradaDetalle->TopId = (($fila['TopId']));
					
					$AlmacenMovimientoEntradaDetalle->AmoFechaUltimaSalida = (($fila['AmoFechaUltimaSalida']));
					$AlmacenMovimientoEntradaDetalle->AmoUltimaSalidaDiaTranscurridos = (($fila['AmoUltimaSalidaDiaTranscurridos']));

					$AlmacenMovimientoEntradaDetalle->OcoTipo = (($fila['OcoTipo']));
					
					$AlmacenMovimientoEntradaDetalle->AmoTipo = (($fila['AmoTipo']));
					$AlmacenMovimientoEntradaDetalle->AmoSubTipo = (($fila['AmoSubTipo']));

			
                    $AlmacenMovimientoEntradaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoEntradaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}	
		
	
	
	
	
	  public function MtdObtenerAlmacenMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oAlmacenMovimientoSalida=NULL,$oEstado=NULL,$oProducto=NULL,$oAlmacenMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAlmacenId=NULL,$oAlmacenMovimientoSubTipo=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oAlmacenMovimientoSalida)){
			$amovimiento = ' AND amd.AmoId = "'.$oAlmacenMovimientoSalida.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		
		if(!empty($oAlmacenMovimientoSalidaEstado)){
			$amestado = ' AND (amo.AmoEstado = '.$oAlmacenMovimientoSalidaEstado.') ';
		}



		if(!empty($oVehiculoMarca)){
			
			$vmarca = '
			
			AND 
			
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					
					AND amd.ProId = pvv.ProId
				)
				
				OR
				
				pro.VmaId = "'.$oVehiculoMarca.'"
			)
			';
		}
		

		if(!empty($oProductoTipo)){
			$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
		}
		
		//if(!empty($oFechaInicio)){
//			
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
//			}else{
//				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
//			}
//			
//		}else{
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
//			}			
//		}

if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amd.AmdFecha)>="'.$oFechaInicio.'" AND DATE(amd.AmdFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amd.AmdFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amd.AmdFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
//		
		
		if(!empty($oAlmacenId)){
			$almacen = ' AND (amd.AlmId = "'.$oAlmacenId.'") ';
		}	
		
		/*if(!empty($oAlmacenMovimientoSubTipo)){
			$amtipo = ' AND (amo.AmoSubTipo = "'.$oAlmacenMovimientoSubTipo.'") ';
		}	asddsadas
			*/	
		
		
		if(!empty($oAlmacenMovimientoSubTipo)){

			$elementos = explode(",",$oAlmacenMovimientoSubTipo);

			$i=1;
			$amstipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$amstipo .= '  (amo.AmoSubTipo = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$amstipo .= ' OR ';	
				}
			$i++;		
			}

			$amstipo .= ' ) 
			)
			';

		}
		
			
		if(!empty($oSucursal)){
			$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
		}	
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId,			
			amd.AmoId,
			amo.TalId,
			amo.PprId,
			amo.TptId,
			
			amd.ProId,
			amd.UmeId,
			
			amd.FaaId,
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
pro.ProMarcaReferencia,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume2.UmeNombre  AS "UmeNombreOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			DATE_FORMAT(amd.AmdFecha, "%d/%m/%Y") AS "NAmdFecha",
			
			faa.PmtId,
			
			faa.FaaAccion,
			faa.FaaNivel,
			faa.FaaVerificar1,
			faa.FaaVerificar2,
			
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			cli.CliNumeroDocumento,
			
			top.TopNombre,
			fin.FinId,
			
			min.MinNombre,
			
			(
			SELECT 

			CONCAT(fta.FtaNumero,"-",fac.FacId)
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdFactura,
			

			(
			SELECT 

			DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdFacturaFechaEmision,
			
			
			(
			SELECT 

			CONCAT(bta.BtaNumero,"-",bol.BolId)
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
			WHERE bol.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdBoleta,
			
			(
			SELECT 

			DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
			WHERE bol.AmoId = amd.AmoId 
			LIMIT 1
			) AS AmdBoletaFechaEmision,
			
			vdd.VdiId,
			
			
			@FdeCantidad:=(
			
				SELECT 
				SUM(fde.FdeCantidad)
				FROM tblfdefacturadetalle fde
				
					LEFT JOIN tblfacfactura fac
					ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
						
				WHERE fde.AmdId = amd.AmdId
					AND fac.FacEstado <> 6
				LIMIT 1

			) AS FdeCantidad,
			
			
			@BdeCantidad:=(
			
				SELECT 
				SUM(bde.BdeCantidad)
				FROM tblbdeboletadetalle bde
				
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
						
				WHERE bde.AmdId = amd.AmdId
					AND bol.BolEstado <> 6
				LIMIT 1

			) AS BdeCantidad,
			
			
			(
			IFNULL(amd.AmdCantidad,0) - IFNULL(@FdeCantidad,0) - IFNULL(@BdeCantidad,0) 				
			) AS AmdCantidadPendienteFacturar,
			
			amd.AmdReingreso,
			
			amo.AmoTipo,
			amo.AmoSubTipo
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
				
					LEFT JOIN tblvddventadirectadetalle vdd
					ON amd.VddId = vdd.VddId
					
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId		

						LEFT JOIN tblumeunidadmedida ume2
						ON pro.UmeId = ume2.UmeId

							LEFT JOIN tblamoalmacenmovimiento amo
							ON amd.AmoId = amo.AmoId
							
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
									
										LEFT JOIN tblminmodalidadingreso min
										ON fim.MinId = min.MinId
				
											LEFT JOIN tblclicliente cli
											ON amo.CliId = cli.CliId
								
								LEFT JOIN tbltoptipooperacion top
								ON amo.TopId = top.TopId
	
								LEFT JOIN tblfaafichaaccionmantenimiento faa
								ON amd.FaaId = faa.FaaId
									LEFT JOIN tblpmtplanmantenimientotarea pmt
									ON faa.PmtId = pmt.PmtId
			WHERE   amo.AmoTipo = 2 
		
			'.$amovimiento.$fecha.$estado.$producto.$filtrar.$amestado.$sucursal.$amstipo.$vmarca.$almacen.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoSalidaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoSalidaDetalle = new $InsAlmacenMovimientoSalidaDetalle();
                    $AlmacenMovimientoSalidaDetalle->AmdId = $fila['AmdId'];
                    $AlmacenMovimientoSalidaDetalle->AmoId = $fila['AmoId'];
					
					$AlmacenMovimientoSalidaDetalle->TalId = $fila['TalId'];
					$AlmacenMovimientoSalidaDetalle->PprId = $fila['PprId'];
					$AlmacenMovimientoSalidaDetalle->TptId = $fila['TptId'];
					
			
			
					$AlmacenMovimientoSalidaDetalle->UmeId = $fila['UmeId'];
					
					$AlmacenMovimientoSalidaDetalle->FaaId = $fila['FaaId'];
					$AlmacenMovimientoSalidaDetalle->FapId = $fila['FapId'];
					
					$AlmacenMovimientoSalidaDetalle->AmdCosto = $fila['AmdCosto'];  
			        $AlmacenMovimientoSalidaDetalle->AmdCantidad = $fila['AmdCantidad'];  
					$AlmacenMovimientoSalidaDetalle->AmdCantidadReal = $fila['AmdCantidadReal'];  
					
					$AlmacenMovimientoSalidaDetalle->AmdValorTotal = $fila['AmdValorTotal'];  
					$AlmacenMovimientoSalidaDetalle->AmdUtilidad = $fila['AmdUtilidad'];  					
					$AlmacenMovimientoSalidaDetalle->AmdPrecioVenta = $fila['AmdPrecioVenta'];  					

					$AlmacenMovimientoSalidaDetalle->AmdImporte = $fila['AmdImporte'];
					
					$AlmacenMovimientoSalidaDetalle->AmdEstado = $fila['AmdEstado'];
					$AlmacenMovimientoSalidaDetalle->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$AlmacenMovimientoSalidaDetalle->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
					$AlmacenMovimientoSalidaDetalle->ProId = $fila['ProId'];
					$AlmacenMovimientoSalidaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$AlmacenMovimientoSalidaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $AlmacenMovimientoSalidaDetalle->ProNombre = (($fila['ProNombre']));
					$AlmacenMovimientoSalidaDetalle->RtiId = (($fila['RtiId']));
					$AlmacenMovimientoSalidaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$AlmacenMovimientoSalidaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					
					$AlmacenMovimientoSalidaDetalle->UmeNombre = (($fila['UmeNombre']));
					$AlmacenMovimientoSalidaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$AlmacenMovimientoSalidaDetalle->AmoFecha = (($fila['NAmoFecha']));
					$AlmacenMovimientoSalidaDetalle->AmdFecha = (($fila['NAmdFecha']));
					
					$AlmacenMovimientoSalidaDetalle->PmtId = (($fila['PmtId']));
					
					$AlmacenMovimientoSalidaDetalle->FaaAccion = (($fila['FaaAccion']));
					$AlmacenMovimientoSalidaDetalle->FaaNivel = (($fila['FaaNivel']));
					$AlmacenMovimientoSalidaDetalle->FaaVerificar1 = (($fila['FaaVerificar1']));
					$AlmacenMovimientoSalidaDetalle->FaaVerificar2 = (($fila['FaaVerificar2']));
					
					$AlmacenMovimientoSalidaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$AlmacenMovimientoSalidaDetalle->CliNombre = (($fila['CliNombre']));
					$AlmacenMovimientoSalidaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$AlmacenMovimientoSalidaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$AlmacenMovimientoSalidaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$AlmacenMovimientoSalidaDetalle->TopNombre = (($fila['TopNombre']));
					
					$AlmacenMovimientoSalidaDetalle->FinId = (($fila['FinId']));
					
					$AlmacenMovimientoSalidaDetalle->MinNombre = (($fila['MinNombre']));
					
					$AlmacenMovimientoSalidaDetalle->AmdFactura = (($fila['AmdFactura']));
					$AlmacenMovimientoSalidaDetalle->AmdFacturaFechaEmision = (($fila['AmdFacturaFechaEmision']));
					
					$AlmacenMovimientoSalidaDetalle->AmdBoleta = (($fila['AmdBoleta']));
					$AlmacenMovimientoSalidaDetalle->AmdBoletaFechaEmision = (($fila['AmdBoletaFechaEmision']));
			
			
					$AlmacenMovimientoSalidaDetalle->VdiId = (($fila['VdiId']));
					
					
					$AlmacenMovimientoSalidaDetalle->FdeCantidad = (($fila['FdeCantidad']));
					$AlmacenMovimientoSalidaDetalle->BdeCantidad = (($fila['BdeCantidad']));
					$AlmacenMovimientoSalidaDetalle->AmdCantidadPendienteFacturar = (($fila['AmdCantidadPendienteFacturar']));
			
					$AlmacenMovimientoSalidaDetalle->AmdReingreso = (($fila['AmdReingreso']));
					
					$AlmacenMovimientoSalidaDetalle->AmoTipo = (($fila['AmoTipo']));
					$AlmacenMovimientoSalidaDetalle->AmoSubTipo = (($fila['AmoSubTipo']));
			
                    $AlmacenMovimientoSalidaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoSalidaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
}
?>