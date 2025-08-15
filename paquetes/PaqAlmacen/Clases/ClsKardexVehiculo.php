<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsKardexVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsKardexVehiculo {

    public $KdvId;
	public $KdvFecha;
	public $VehId;
	public $UmeId;
    public $KdvCantidad;	
	public $KdvCostoUnitario;
	public $KdvCostoTotal;
	public $KdvTiempoCreacion;
	
	public $VehNombre;
	public $UmeNombre;

	public $TopCodigo;
	public $TopNombre;
	
	public $KdvComprobanteNumero;
	public $CtiCodigo;
	public $CtiNombre;
	
	public $RtiNombre;

	
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


		

    public function MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL,$oVehiculoId=NULL,$oVehiculoIngresoId=NULL) {

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
		
		//if(!empty($oVehducto)){
//			$vehiculo = ' AND (vmd.VehId = "'.$oVehducto.'") ';
//		}
		
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
//			vmd.VmdCostoTotal AS KdvCostoUnitario,		
//			vmd.VmdCostoTotal * vmd.VmdCantidadReal AS KdvCostoTotal,

//			ROUND(vmd.VmdCosto/vmd.VmdCantidadReal,3) AS KdvCostoUnitario,
//			
//			vmd.VmdCantidadReal AS KdvCantidad,
//			(ROUND(vmd.VmdCosto/vmd.VmdCantidadReal,3) * vmd.VmdCantidadReal) AS KdvCostoTotal,

//		if($oUso==1){
//			$uso = '
//			(vmd.VmdImporte/vmd.VmdCantidadReal) AS KdvCostoUnitario,
//			vmd.VmdCantidadReal AS KdvCantidad,
//			((vmd.VmdImporte/vmd.VmdCantidadReal) * vmd.VmdCantidadReal) AS KdvCostoTotal,
//			
//			';	
//			
//		}else{
//			$uso = '
//			(vmd.VmdImporte/vmd.VmdCantidad) AS KdvCostoUnitario,
//			vmd.VmdCantidad AS KdvCantidad,
//			((vmd.VmdImporte/vmd.VmdCantidad) * vmd.VmdCantidad) AS KdvCostoTotal,
//			';	
//		}

//
        if($oUso==3){
			//vmd.VmdCantidad AS KdvCantidad,
			
			$uso = '
			
			( vmd.vmd.VmdValorTotal / vmd.VmdCantidad ) AS KdvCostoUnitario,
			
			(  vmd.VmdCantidad ) AS KdvCantidad,
			
			( (vmd.VmdValorTotal / vmd.VmdCantidad ) * ( vmd.VmdCantidad ) ) AS KdvCostoTotal,
			
			';	
			
		}else{
			
			/*$uso = '
			
			( IF( top.TopCodigo="05", vmd.VmdValorTotal*-1, vmd.VmdValorTotal) ) AS KdvCostoUnitario,
			
			( (IF( top.TopCodigo="05", vmd.VmdCantidad*-1, vmd.VmdCantidad))/umc.UmcEquivalente) AS KdvCantidad,
			
            ( (IF( top.TopCodigo="05", vmd.VmdValorTotal*-1, vmd.VmdValorTotal) ) * ((IF(top.TopCodigo="05", vmd.VmdCantidad*-1, vmd.VmdCantidad))/umc.UmcEquivalente) ) AS KdvCostoTotal,
            
			';	*/
			
			$uso = '
			
			( vmd.VmdValorTotal  ) AS KdvCostoUnitario,
			
			( (IF( top.TopCodigo="05", vmd.VmdCantidad*-1, vmd.VmdCantidad)) / umc.UmcEquivalente ) AS KdvCantidad,
			
            ( vmd.VmdValorTotal  * (vmd.VmdCantidad / umc.UmcEquivalente) ) AS KdvCostoTotal,
            
			';	
			
		}

//		if($oUso==3){
//			
//			$uso = '
//			(vmd.VmdValorTotal/(vmd.VmdCantidad)) AS KdvCostoUnitario,
//			vmd.VmdCantidad AS KdvCantidad,
//			((VmdValorTotal/(vmd.VmdCantidad)) * vmd.VmdCantidad) AS KdvCostoTotal,
//			
//			';	
//			
//		}else{
//			
//			$uso = '
//			(VmdValorTotal) AS KdvCostoUnitario,
//			(vmd.VmdCantidad/umc.UmcEquivalente) AS KdvCantidad,
//			((VmdValorTotal) * (vmd.VmdCantidad/umc.UmcEquivalente) ) AS KdvCostoTotal,
//			';	
//			
//		}

		if(!empty($oMoneda)){
			$moneda = ' AND (vmv.MonId = "'.$oMoneda.'") ';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (vmd.AlmId = "'.$oSucursal.'") ';
			$stipo = "";
		}else{
			$stipo = ' AND (vmv.VmvSubTipo = 1 OR vmv.VmvSubTipo = 2 OR vmv.VmvSubTipo = 3 OR vmv.VmvSubTipo = 4 OR vmv.VmvSubTipo = 7 OR vmv.VmvSubTipo = 5)';
		}
		
		if(!empty($oVehiculoId)){
			$vehiculo = ' AND (vmd.VehId = "'.$oVehiculoId.'") ';
		}
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND (vmd.EinId = "'.$oVehiculoIngresoId.'") ';
		}

//
//		if(!empty($oSucursalMovimientoSubTipo)){
//
//			$elementos = explode(",",$oSucursalMovimientoSubTipo);
//
//			$i=1;
//			$amstipo .= ' AND (
//			(';
//			$elementos = array_filter($elementos);
//			foreach($elementos as $elemento){
//				$amstipo .= '  (vmv.VmvSubTipo = "'.($elemento).'" )';
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



//vmd.VmdCostoIngreso AS KdvCostoIngreso,

//  (IF(top.TopCodigo="05", vmd.VmdCostoIngreso*-1, vmd.VmdCostoIngreso)) AS KdvCostoIngreso,
		$sql = '

			SELECT
			SQL_CALC_FOUND_ROWS 
			vmd.VmvId AS KdvId,
			
         	(IF(top.TopCodigo="05", vmd.VmdCostoIngreso*-1, vmd.VmdCostoIngreso)) AS KdvCostoIngreso,
            
			vmv.VmvFoto AS "KdvFoto",			
			
			DATE_FORMAT('.$oFechaTipo.', "%d/%m/%Y") AS "KdvFecha",
			vmd.VehId,
			vmd.UmeId,
			
			'.$uso.'			
			
			/* IF(top.TopCodigo="05",2,vmv.VmvTipo) AS "KdvMovimientoTipo",*/ 
			
			IF( top.TopCodigo="05", 2, vmv.VmvTipo ) AS "KdvMovimientoTipo",

			vmv.VmvSubTipo AS "KdvMovimientoSubTipo",
			
			DATE_FORMAT(vmd.VmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS KdvTiempoCreacion,
			veh.VehNombre,

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
						WHERE fam.VmvId = vmd.VmvId
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
						LIMIT 1
					
					),
						IFNULL(	
							(
							SELECT
							CONCAT("01")
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol
								ON bam.BolId = bol.BolId AND bam.BtaID = bol.BtaId
							WHERE bam.VmvId = vmd.VmvId
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
						WHERE fam.VmvId = vmd.VmvId
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
						 LIMIT 1
						
					),
						IFNULL(	
							(
							SELECT
							CONCAT("Venta")
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol
								ON bam.BolId = bol.BolId AND bam.BtaID = bol.BtaId
							WHERE bam.VmvId = vmd.VmvId
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
							
							LIMIT 1
							),
							"-"
						)
				)
				
			
			) AS TopNombre,
			
			

			IFNULL(
			vmv.VmvComprobanteNumero,
	
				(
					IFNULL(
						(
						SELECT 
						CONCAT(fta.FtaNumero,"-",fac.FacId) 
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblfacfactura fac
							ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE fam.VmvId = vmd.VmvId
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
							LIMIT 1
					),
					IFNULL(		
						(
							SELECT 
							CONCAT(bta.BtaNumero,"-",bol.BolId) 
							FROM tblbamboletaalmacenmovimiento bam
								LEFT JOIN tblbolboleta bol
								ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
									LEFT JOIN tblbtaboletatalonario bta
									ON bol.BtaId = bta.BtaId
								WHERE bam.VmvId = vmd.VmvId
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
								
								LIMIT 1
						),
						IFNULL(
						(
							SELECT 
							CONCAT(nct.NctNumero,"-",ncr.NcrId) 
							FROM tblncrnotacredito ncr
								LEFT JOIN tblnctnotacreditotalonario nct
								ON ncr.NctId = nct.NctId
								WHERE ncr.OvvId = vmv.OvvId
								LIMIT 1
						)
						,"000-000000"
						)
					)
				)				
								
			)
					
				
			) AS KdvComprobanteNumero,
			
			


	DATE_FORMAT(

			IFNULL(
			vmv.VmvComprobanteFecha,

				IFNULL(
					(

						SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
									LEFT JOIN tblfdefacturadetalle fde
									ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
									
							WHERE vmd.VmdId = fde.VmdId
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
							LIMIT 1
							
					),
						IFNULL(
						(
							
							SELECT 
							fac.FacFechaEmision
							FROM tblfacfactura fac
								LEFT JOIN tblftafacturatalonario fta
								ON fac.FtaId = fta.FtaId
							WHERE vmd.VmvId = fac.VmvId
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
									WHERE fam.VmvId = vmd.VmvId
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
										
									)*/ 
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
													
											WHERE vmd.VmdId = bde.VmdId
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
												WHERE vmd.VmvId = bol.VmvId
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
													LIMIT 1
											),

											IFNULL(
											
												(
												SELECT 
												bol.BolFechaEmision
												FROM tblbamboletaalmacenmovimiento bam
													LEFT JOIN tblbolboleta bol
													ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
														LEFT JOIN tblbtaboletatalonario bta
														ON bol.BtaId = bta.BtaId
													WHERE bam.VmvId = vmd.VmvId
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
													LIMIT 1
													),
													
													IFNULL(
													
														(
															SELECT 
															ncr.NcrFechaEmision
															FROM tblncrnotacredito ncr
																LEFT JOIN tblnctnotacreditotalonario nct
																ON ncr.NctId = nct.NctId
																WHERE ncr.OvvId = vmv.OvvId
																LIMIT 1
														),
														"0000-00-00"
													)
											)
										)
									)


								
							)
						
						)
					)
				
			)

, "%d/%m/%Y") AS "KdvComprobanteFecha",
			
			
			
			




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
									
							WHERE vmd.VmdId = fde.VmdId
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
							WHERE vmd.VmvId = fac.VmvId
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
									WHERE fam.VmvId = vmd.VmvId
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
													
											WHERE vmd.VmdId = bde.VmdId
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
												WHERE vmd.VmvId = bol.VmvId
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
												WHERE bam.VmvId = vmd.VmvId
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
									
							WHERE vmd.VmdId = fde.VmdId
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
							WHERE vmd.VmvId = fac.VmvId
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
									WHERE fam.VmvId = vmd.VmvId
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
													
											WHERE vmd.VmdId = bde.VmdId
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
												WHERE vmd.VmvId = bol.VmvId
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
												WHERE bam.VmvId = vmd.VmvId
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
			
			veh.VehCodigoIdentificador,
			
			vmv.TopId,
			
			vmv.VmvTipoCambio AS KdvTipoCambio,
			vmv.MonId,
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,
			prv.PrvNumeroDocumento,
		
			umc.UmcEquivalente,
			
			ein.EinVIN	,
			
			veh.VehNombre,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
			
			suc.SucNombre,
			
			
			ume.UmeCodigo	
			
			FROM tblvmdvehiculomovimientodetalle vmd
				
				LEFT JOIN tbleinvehiculoingreso ein
				ON vmd.EinId = ein.EinId
				
				LEFT JOIN tblvehvehiculo veh
				ON vmd.VehId = veh.VehId
					
					LEFT JOIN tblumcunidadmedidaconversion umc
					ON vmd.UmeId = umc.UmeId2 AND  veh.UmeId = umc.UmeId1
					
						
							LEFT JOIN tblumeunidadmedida ume
							ON vmd.UmeId = ume.UmeId	
											
								LEFT  JOIN tblvmvvehiculomovimiento vmv
								ON vmd.VmvId = vmv.VmvId
								
									LEFT JOIN tbltoptipooperacion top
									ON vmv.TopId = top.TopId
									
										LEFT JOIN tblcticomprobantetipo cti
										ON vmv.CtiId = cti.CtiId
								
				LEFT JOIN tblclicliente cli
				ON vmv.CliId = cli.CliId
				
				LEFT JOIN tblprvproveedor prv
				ON vmv.PrvId = prv.PrvId
				
				LEFT JOIN tblvvevehiculoversion vve
				ON veh.VveId = vve.VveId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON vve.VmoId = vmo.VmoId
				
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
					
					LEFT JOIN tblsucsucursal suc
					ON vmv.SucId = suc.SucId
					
					
			WHERE  vmd.VmdEstado = 3 
			
				
			'.$fecha.$vehiculo.$filtrar.$vingreso.$moneda.$sucursal.$stipo.$orden.$paginacion;	
	
		//MK0EH6453
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsKardexVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$KardexVehiculo = new $InsKardexVehiculo();
                    $KardexVehiculo->KdvId = $fila['KdvId'];
					$KardexVehiculo->KdvCostoIngreso = $fila['KdvCostoIngreso'];
					
				$KardexVehiculo->KdvFoto = $fila['KdvFoto'];
	
                    $KardexVehiculo->KdvFecha = $fila['KdvFecha'];
					$KardexVehiculo->VehId = $fila['VehId'];
					$KardexVehiculo->UmeId = $fila['UmeId'];
					$KardexVehiculo->KdvCostoUnitario = $fila['KdvCostoUnitario'];
			        $KardexVehiculo->KdvCantidad = $fila['KdvCantidad'];  
					$KardexVehiculo->KdvCostoTotal = $fila['KdvCostoTotal'];  
					$KardexVehiculo->KdvMovimientoTipo = $fila['KdvMovimientoTipo'];
					$KardexVehiculo->KdvMovimientoSubTipo = $fila['KdvMovimientoSubTipo'];
					
					$KardexVehiculo->KdvTiempoCreacion = $fila['KdvTiempoCreacion'];
					
					$KardexVehiculo->VehNombre = $fila['VehNombre'];

				
					$KardexVehiculo->UmeNombre = $fila['UmeNombre'];
					
					$KardexVehiculo->TopCodigo = $fila['TopCodigo'];
					$KardexVehiculo->TopNombre = $fila['TopNombre'];
					
					$KardexVehiculo->KdvComprobanteNumero = $fila['KdvComprobanteNumero'];
					$KardexVehiculo->KdvComprobanteNumero2 = $fila['KdvComprobanteNumero2'];
					$KardexVehiculo->KdvComprobanteFecha = $fila['KdvComprobanteFecha'];
					
					
					$KardexVehiculo->CtiNombre = $fila['CtiNombre'];
					$KardexVehiculo->CtiCodigo = $fila['CtiCodigo'];
					
					$KardexVehiculo->VehCodigoIdentificador = $fila['VehCodigoIdentificador'];
					
				
					$KardexVehiculo->TopId = $fila['TopId'];
					
					$KardexVehiculo->KdvTipoCambio = $fila['KdvTipoCambio'];
					$KardexVehiculo->MonId = $fila['MonId'];
					
					$KardexVehiculo->CliNombre = $fila['CliNombre'];
					$KardexVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$KardexVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$KardexVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					
					$KardexVehiculo->PrvNombre = $fila['PrvNombre'];
					$KardexVehiculo->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$KardexVehiculo->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$KardexVehiculo->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					
				
					$KardexVehiculo->UmcEquivalente = $fila['UmcEquivalente'];
					
					$KardexVehiculo->EinVIN = $fila['EinVIN'];
				
					
					$KardexVehiculo->VehNombre = $fila['VehNombre'];
					$KardexVehiculo->VmaNombre = $fila['VmaNombre'];
					$KardexVehiculo->VmoNombre = $fila['VmoNombre'];
					$KardexVehiculo->VveNombre = $fila['VveNombre'];
					
					
					$KardexVehiculo->SucNombre = $fila['SucNombre'];
					$KardexVehiculo->UmeCodigo = $fila['UmeCodigo'];
					
                    $KardexVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $KardexVehiculo;
                }
						
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	  public function MtdObtenerVehiculoMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'" AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		
		
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vmd.VmdId,
			vmv.TveId,
			vmv.VmvTipo,
			vmv.VmvSubTipo,
			
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
			
			veh.VehCodigoIdentificador,
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno		

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
							
							
							LEFT JOIN tblcticomprobantetipo cti
							ON vmv.CtiId = cti.CtiId
								
								LEFT JOIN tblclicliente cli
								ON vmv.CliId = cli.CliId
								
									LEFT JOIN tblprvproveedor prv
									ON vmv.PrvId = prv.PrvId
									
			WHERE  vmv.VmvTipo = 1  '.$amovimiento.$estado.$producto.$ctipo.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$sucursal.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoEntradaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoEntradaDetalle = new $InsVehiculoMovimientoEntradaDetalle();
                    $VehiculoMovimientoEntradaDetalle->VmdId = $fila['VmdId'];
					$VehiculoMovimientoEntradaDetalle->TveId = $fila['TveId'];
					$VehiculoMovimientoEntradaDetalle->VmvTipo = $fila['VmvTipo'];
					$VehiculoMovimientoEntradaDetalle->VmvSubTipo = $fila['VmvSubTipo'];
					
					
			
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


					
					$VehiculoMovimientoEntradaDetalle->CliNombre = (($fila['CliNombre']));
					$VehiculoMovimientoEntradaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VehiculoMovimientoEntradaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$VehiculoMovimientoEntradaDetalle->PrvNombre = (($fila['PrvNombre']));
					$VehiculoMovimientoEntradaDetalle->PrvApellidoPaterno = (($fila['PrvApellidoPaterno']));
					$VehiculoMovimientoEntradaDetalle->PrvApellidoMaterno = (($fila['PrvApellidoMaterno']));


                    $VehiculoMovimientoEntradaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoMovimientoEntradaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
	
	
	  public function MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCompraVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL,$oTipo=NULL,$oSucursal=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
		
		
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'" AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';		
			}			
		}
	
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vmd.VmdId,		
			vmv.TveId,
			vmv.VmvTipo,
			vmv.VmvSubTipo,
			
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

			) AS VmvFechaUltimaSalida,
			
			
			
			(
			SELECT 

			CONCAT(fta.FtaNumero,"-",fac.FacId)
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
					LEFT JOIN tblfamfacturaalmacenmovimiento fam
					ON fac.FacId = fam.FacId AND fac.FtaId = fam.FtaId
			WHERE fam.VmvId = vmd.VmvId
			LIMIT 1
			) AS VmdFactura,
			

			(
			SELECT 
			DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
					LEFT JOIN tblfamfacturaalmacenmovimiento fam
					ON fac.FacId = fam.FacId AND fac.FtaId = fam.FtaId
					
			WHERE fam.VmvId = vmd.VmvId
			LIMIT 1
			) AS VmdFacturaFechaEmision,
			
			
			(
			SELECT 

			CONCAT(bta.BtaNumero,"-",bol.BolId)
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
					LEFT JOIN tblbamboletaalmacenmovimiento bam
					ON bol.BolId = bam.BolId AND bol.BtaId = bam.BtaId
			WHERE bam.VmvId = vmd.VmvId
			LIMIT 1
			) AS VmdBoleta,
			
			(
			SELECT 

			DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
					LEFT JOIN tblbamboletaalmacenmovimiento bam
					ON bol.BolId = bam.BolId AND bol.BtaId = bam.BtaId
					
			WHERE bam.VmvId = vmd.VmvId 
			LIMIT 1
			) AS VmdBoletaFechaEmision,
			
			

			(TIMESTAMPDIFF(DAY, @VmvFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS VmvUltimaSalidaDiaTranscurridos,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
		
			veh.VehCodigoIdentificador,
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno
				
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
							
							
								LEFT JOIN tblclicliente cli
								ON vmv.CliId = cli.CliId
								
									LEFT JOIN tblprvproveedor prv
									ON vmv.PrvId = prv.PrvId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON vmv.CtiId = cti.CtiId
							
			WHERE  vmv.VmvTipo = 2  '.$amovimiento.$estado.$producto.$sucursal.$ctipo.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$almacen .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoSalidaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoSalidaDetalle = new $InsVehiculoMovimientoSalidaDetalle();
                    $VehiculoMovimientoSalidaDetalle->VmdId = $fila['VmdId'];
					$VehiculoMovimientoSalidaDetalle->TveId = $fila['TveId'];
					$VehiculoMovimientoSalidaDetalle->VmvTipo = $fila['VmvTipo'];
					$VehiculoMovimientoSalidaDetalle->VmvSubTipo = $fila['VmvSubTipo'];
					
					
                    $VehiculoMovimientoSalidaDetalle->VmvId = $fila['VmvId'];
					$VehiculoMovimientoSalidaDetalle->UmeId = $fila['UmeId'];
					
					$VehiculoMovimientoSalidaDetalle->VmdIdAnterior = $fila['VmdIdAnterior'];
					$VehiculoMovimientoSalidaDetalle->VmdCosto = $fila['VmdCosto'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoIngreso = $fila['VmdCostoIngreso'];
					
					$VehiculoMovimientoSalidaDetalle->VmdCostoAnterior = $fila['VmdCostoAnterior'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoExtraTotal = $fila['VmdCostoExtraTotal'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoExtraUnitario = $fila['VmdCostoExtraUnitario'];
					$VehiculoMovimientoSalidaDetalle->VmdValorTotal = $fila['VmdValorTotal'];
			        $VehiculoMovimientoSalidaDetalle->VmdCantidad = $fila['VmdCantidad'];  
					$VehiculoMovimientoSalidaDetalle->VmdObservacion = $fila['VmdObservacion'];  
					
					$VehiculoMovimientoSalidaDetalle->VmdImporte = $fila['VmdImporte'];
					$VehiculoMovimientoSalidaDetalle->VmdCostoPromedio = $fila['VmdCostoPromedio'];
					
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica1 = $fila['VmdCaracteristica1'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica2 = $fila['VmdCaracteristica2'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica3 = $fila['VmdCaracteristica3'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica4 = $fila['VmdCaracteristica4'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica5 = $fila['VmdCaracteristica5'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica6 = $fila['VmdCaracteristica6'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica7 = $fila['VmdCaracteristica7'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica8 = $fila['VmdCaracteristica8'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica9 = $fila['VmdCaracteristica9'];					
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica10 = $fila['VmdCaracteristica10'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica11 = $fila['VmdCaracteristica11'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica12 = $fila['VmdCaracteristica12'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica13 = $fila['VmdCaracteristica13'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica14 = $fila['VmdCaracteristica14'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica15 = $fila['VmdCaracteristica15'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica16 = $fila['VmdCaracteristica16'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica17 = $fila['VmdCaracteristica17'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica18 = $fila['VmdCaracteristica18'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica19 = $fila['VmdCaracteristica19'];
					$VehiculoMovimientoSalidaDetalle->VmdCaracteristica20 = $fila['VmdCaracteristica20'];
					
					$VehiculoMovimientoSalidaDetalle->VmdEstado = $fila['VmdEstado'];  
					$VehiculoMovimientoSalidaDetalle->VmdTiempoCreacion = $fila['NVmdTiempoCreacion'];  
					$VehiculoMovimientoSalidaDetalle->VmdTiempoModificacion = $fila['NVmdTiempoModificacion']; 	
									
					$VehiculoMovimientoSalidaDetalle->EinId = $fila['EinId'];	
					
					$VehiculoMovimientoSalidaDetalle->VmvFecha = $fila['NVmvFecha'];	
					$VehiculoMovimientoSalidaDetalle->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];	
					$VehiculoMovimientoSalidaDetalle->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];	
					
					$VehiculoMovimientoSalidaDetalle->CtiNombre = $fila['CtiNombre'];
					
					$VehiculoMovimientoSalidaDetalle->VmvSubTotal = $fila['VmvSubTotal'];
	
                    $VehiculoMovimientoSalidaDetalle->EinVIN = (($fila['EinVIN']));
					$VehiculoMovimientoSalidaDetalle->EinNumeroMotor = (($fila['EinNumeroMotor']));
					$VehiculoMovimientoSalidaDetalle->EinColor = (($fila['EinColor']));					
					$VehiculoMovimientoSalidaDetalle->EinColorInterno = (($fila['EinColorInterno']));
					$VehiculoMovimientoSalidaDetalle->EinAnoFabricacion = (($fila['EinAnoFabricacion']));
					$VehiculoMovimientoSalidaDetalle->EinAnoModelo = (($fila['EinAnoModelo']));
					
					$VehiculoMovimientoSalidaDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$VehiculoMovimientoSalidaDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$VehiculoMovimientoSalidaDetalle->TopNombre = (($fila['TopNombre']));

					$VehiculoMovimientoSalidaDetalle->VmvComprobanteNumero = (($fila['VmvComprobanteNumero']));
					$VehiculoMovimientoSalidaDetalle->VmvComprobanteFecha = (($fila['NVmvComprobanteFecha']));

					$VehiculoMovimientoSalidaDetalle->TopId = (($fila['TopId']));
					
					$VehiculoMovimientoSalidaDetalle->VmvFechaUltimaSalida = (($fila['VmvFechaUltimaSalida']));
					$VehiculoMovimientoSalidaDetalle->VmvUltimaSalidaDiaTranscurridos = (($fila['VmvUltimaSalidaDiaTranscurridos']));

					$VehiculoMovimientoSalidaDetalle->VmaNombre = (($fila['VmaNombre']));
					$VehiculoMovimientoSalidaDetalle->VmoNombre = (($fila['VmoNombre']));
					$VehiculoMovimientoSalidaDetalle->VveNombre = (($fila['VveNombre']));
					
					$VehiculoMovimientoSalidaDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$VehiculoMovimientoSalidaDetalle->VehCodigoIdentificador = (($fila['VehCodigoIdentificador']));

					
					$VehiculoMovimientoSalidaDetalle->CliNombre = (($fila['CliNombre']));
					$VehiculoMovimientoSalidaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VehiculoMovimientoSalidaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$VehiculoMovimientoSalidaDetalle->PrvNombre = (($fila['PrvNombre']));
					$VehiculoMovimientoSalidaDetalle->PrvApellidoPaterno = (($fila['PrvApellidoPaterno']));
					$VehiculoMovimientoSalidaDetalle->PrvApellidoMaterno = (($fila['PrvApellidoMaterno']));

                    $VehiculoMovimientoSalidaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoMovimientoSalidaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}
		
		
}
?>