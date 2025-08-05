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

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


		

    public function MtdObtenerKardexVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oUso=NULL,$oMoneda=NULL,$oFechaTipo="VmvFecha",$oSucursal=NULL) {

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
		

		if(!empty($oVehducto)){
			$vehiculo = ' AND (vmd.VehId = "'.$oVehducto.'") ';
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
			(vmd.vmd.VmdValorTotal/((IF(top.TopCodigo="05",vmd.VmdCantidad*-1,vmd.VmdCantidad)))) AS KdvCostoUnitario,
			(IF(top.TopCodigo="05",vmd.VmdCantidad*-1,vmd.VmdCantidad)) AS KdvCantidad,
			((vmd.VmdValorTotal/(vmd.VmdCantidad)) * (IF(top.TopCodigo="05",vmd.VmdCantidad*-1,vmd.VmdCantidad))) AS KdvCostoTotal,
			
			';	
			
			
		}else{
			
			
			
			$uso = '
			
			(IF(top.TopCodigo="05",vmd.VmdValorTotal*-1,vmd.VmdValorTotal)) AS KdvCostoUnitario,
			
			((IF(top.TopCodigo="05",vmd.VmdCantidad*-1,vmd.VmdCantidad))/umc.UmcEquivalente) AS KdvCantidad,
			((vmd.VmdValorTotal) * ((IF(top.TopCodigo="05",vmd.VmdCantidad*-1,vmd.VmdCantidad))/umc.UmcEquivalente) ) AS KdvCostoTotal,
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





		$sql = '

			SELECT
			SQL_CALC_FOUND_ROWS 
			vmd.VmvId AS KdvId,

			vmd.VmdCostoIngreso AS "KdvCostoIngreso",
			
			vmv.VmvFoto AS "KdvFoto",			
			
			DATE_FORMAT('.$oFechaTipo.', "%d/%m/%Y") AS "KdvFecha",
			vmd.VehId,
			vmd.UmeId,
			
			'.$uso.'			
			
			IF(top.TopCodigo="05",2,vmv.VmvTipo) AS "KdvMovimientoTipo",
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
							),
							"-"
						)
				)
				
			
			) AS TopNombre,
			
			
			
			

			IFNULL(
			vmv.VmvComprobanteNumero,

				IFNULL(
					(

						SELECT 
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
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
							CONCAT(fta.FtaNumero,"-",fac.FacId) 
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
								CONCAT(fta.FtaNumero,"-",fac.FacId) 
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
											CONCAT(bta.BtaNumero,"-",bol.BolId) 
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
											CONCAT(bta.BtaNumero,"-",bol.BolId) 
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
								fac.FacFechaEmision
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
											bol.BolFechaEmision
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
											bol.BolFechaEmision
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
										bol.BolFechaEmision
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
			
			ein.EinVIN			
			
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
				
			WHERE  vmd.VmdEstado = 3 
			
				
			'.$fecha.$vehiculo.$filtrar.$moneda.$sucursal.$stipo.$orden.$paginacion;	
	
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
				
                    $KardexVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $KardexVehiculo;
                }
						
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	 public function MtdObtenerSucursalMovimientoEntradaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursalMovimientoEntrada=NULL,$oEstado=NULL,$oVehducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oSucursalId=NULL,$oSucursalMovimientoSubTipo=NULL) {

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
		
		if(!empty($oSucursalMovimientoEntrada)){
			$vmvvimiento = ' AND vmd.VmvId = "'.$oSucursalMovimientoEntrada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vmd.VmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehducto)){
			$vehiculo = ' AND (vmd.VehId = "'.$oVehducto.'") ';
		}
		
		//if(!empty($oFechaInicio)){
//			
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'" AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';
//			}else{
//				$fecha = ' AND DATE(vmv.VmvFecha)>="'.$oFechaInicio.'"';
//			}
//			
//		}else{
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(vmv.VmvFecha)<="'.$oFechaFin.'"';		
//			}			
//		}

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmd.VmdFecha)>="'.$oFechaInicio.'" AND DATE(vmd.VmdFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vmd.VmdFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmd.VmdFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oCliente)){
			$cliente = ' AND (pco.CliId = "'.$oCliente.'") ';
		}
		
		switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND vmv.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND vmv.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND (pco.OcoId = "'.$oOrdenCompra.'") ';
		}	
		
		if(!empty($oPedidoCompraDetalleId)){
			$pcdetalle = ' AND (vmd.PcdId = "'.$oPedidoCompraDetalleId.'") ';
		}	
		
		if(!empty($oVentaDirectaDetalleId)){
			$ovvetalle = ' AND (pcd.OvvId = "'.$oVentaDirectaDetalleId.'") ';
		}
		
		//if(!empty($oSucursalId)){
//			$sucursal = ' AND (vmv.AlmId = "'.$oSucursalId.'") ';
//		}	
		
		
		if(!empty($oSucursalId)){
			$sucursal = ' AND (vmd.AlmId = "'.$oSucursalId.'") ';
		}	
		
		
		if(!empty($oSucursalMovimientoSubTipo)){

			$elementos = explode(",",$oSucursalMovimientoSubTipo);

			$i=1;
			$amstipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$amstipo .= '  (vmv.VmvSubTipo = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$amstipo .= ' OR ';	
				}
			$i++;		
			}

			$amstipo .= ' ) 
			)
			';

		}
	
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vmd.VmdId,			
			vmd.VmvId,
			
			
			
			vmd.VehId,
			vmd.UmeId,
			vmd.VmdIdAnterior,
			vmd.VmdCosto,
			vmd.VmdCostoAnterior,
			vmd.VmdCostoExtraTotal,
			vmd.VmdCostoExtraUnitario,
			vmd.VmdValorTotal,
			vmd.VmdCantidad,
			vmd.VmdCantidadReal,
			vmd.VmdImporte,
			vmd.VmdCostoVehmedio,

			vmd.VmdEstado,
			DATE_FORMAT(vmd.VmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmdTiempoCreacion",
	        DATE_FORMAT(vmd.VmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmdTiempoModificacion",
			veh.VehNombre,
			veh.VehCodigoIdentificador,

			veh.UmeId AS UmeIdOrigen,
			ume2.UmeNombre AS UmeNombreOrigen,

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

			DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
			cli.CliNombreCompleto,

			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,

			vmv.TopId,

			(
				SELECT 
				DATE_FORMAT(vmv2.VmvFecha, "%d/%m/%Y") 
				FROM tblvmdvehiculomovimientodetalle vmd2
					LEFT JOIN tblvmvvehiculomovimiento vmv2
					ON vmd2.VmvId = vmv2.VmvId
						WHERE vmv2.VmvTipo = 2
						AND vmd2.VehId = vmd.VehId
				ORDER BY vmv2.VmvFecha DESC
				LIMIT 1

			) AS VmvFechaUltimaSalida,

			(TIMESTAMPDIFF(DAY, @VmvFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS VmvUltimaSalidaDiaTranscurridos,

			vmv.VmvTipo,
			vmv.VmvSubTipo

			FROM tblvmdvehiculomovimientodetalle vmd

				LEFT JOIN tblvehvehiculo veh
				ON vmd.VehId = veh.VehId
					LEFT JOIN tblumeunidadmedida ume
					ON vmd.UmeId = ume.UmeId	
						LEFT JOIN tblumeunidadmedida ume2
						ON veh.UmeId = ume2.UmeId
									
						LEFT  JOIN tblvmvvehiculomovimiento vmv
						ON vmd.VmvId = vmv.VmvId
							LEFT JOIN tbltoptipooperacion top
							ON vmv.TopId = top.TopId
							
							LEFT JOIN tblprvproveedor prv
							ON vmv.PrvId = prv.PrvId
							
								LEFT JOIN tbclicliente cli
								ON vmv.CliId = cli.CliId
							
							LEFT JOIN tblcticomprobantetipo cti
							ON vmv.CtiId = cti.CtiId
							
			WHERE  vmv.VmvTipo = 1 '.$vmvvimiento.$estado.$vehiculo.$filtrar.$fecha.$amstipo.$cliente.$cocompra.$ocompra.$pcdetalle.$ovvetalle.$sucursal .$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSucursalMovimientoEntradaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$SucursalMovimientoEntradaDetalle = new $InsSucursalMovimientoEntradaDetalle();
                    $SucursalMovimientoEntradaDetalle->VmdId = $fila['VmdId'];
                    $SucursalMovimientoEntradaDetalle->VmvId = $fila['VmvId'];
					
				
					
					$SucursalMovimientoEntradaDetalle->UmeId = $fila['UmeId'];
					$SucursalMovimientoEntradaDetalle->VmdIdAnterior = $fila['VmdIdAnterior'];
					$SucursalMovimientoEntradaDetalle->VmdCosto = $fila['VmdCosto'];
					$SucursalMovimientoEntradaDetalle->VmdCostoAnterior = $fila['VmdCostoAnterior'];
					$SucursalMovimientoEntradaDetalle->VmdCostoExtraTotal = $fila['VmdCostoExtraTotal'];
					$SucursalMovimientoEntradaDetalle->VmdCostoExtraUnitario = $fila['VmdCostoExtraUnitario'];
					$SucursalMovimientoEntradaDetalle->VmdValorTotal = $fila['VmdValorTotal'];
			        $SucursalMovimientoEntradaDetalle->VmdCantidad = $fila['VmdCantidad'];  
					
					
					$SucursalMovimientoEntradaDetalle->VmdImporte = $fila['VmdImporte'];
					$SucursalMovimientoEntradaDetalle->VmdCostoVehmedio = $fila['VmdCostoVehmedio'];
					
					$SucursalMovimientoEntradaDetalle->VmdEstado = $fila['VmdEstado'];  
					$SucursalMovimientoEntradaDetalle->VmdTiempoCreacion = $fila['NVmdTiempoCreacion'];  
					$SucursalMovimientoEntradaDetalle->VmdTiempoModificacion = $fila['NVmdTiempoModificacion']; 					
					$SucursalMovimientoEntradaDetalle->VehId = $fila['VehId'];	
					
					$SucursalMovimientoEntradaDetalle->VmvFecha = $fila['NVmvFecha'];	
					$SucursalMovimientoEntradaDetalle->VmvComprobanteNumero = $fila['VmvComprobanteNumero'];	
					$SucursalMovimientoEntradaDetalle->VmvComprobanteFecha = $fila['NVmvComprobanteFecha'];	
					$SucursalMovimientoEntradaDetalle->CtiNombre = $fila['CtiNombre'];
					
					$SucursalMovimientoEntradaDetalle->VmvSubTotal = $fila['VmvSubTotal'];
	
                    $SucursalMovimientoEntradaDetalle->VehNombre = (($fila['VehNombre']));
					$SucursalMovimientoEntradaDetalle->VehCodigoIdentificador = (($fila['VehCodigoIdentificador']));

					$SucursalMovimientoEntradaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$SucursalMovimientoEntradaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					$SucursalMovimientoEntradaDetalle->UmeNombre = (($fila['UmeNombre']));
					$SucursalMovimientoEntradaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$SucursalMovimientoEntradaDetalle->PrvNombreCompleto = (($fila['PrvNombreCompleto']));
					$SucursalMovimientoEntradaDetalle->PrvNumeroDocumento = (($fila['PrvNumeroDocumento']));

					$SucursalMovimientoEntradaDetalle->TopNombre = (($fila['TopNombre']));

					$SucursalMovimientoEntradaDetalle->VmvComprobanteNumero = (($fila['VmvComprobanteNumero']));
					$SucursalMovimientoEntradaDetalle->VmvComprobanteFecha = (($fila['NVmvComprobanteFecha']));

					$SucursalMovimientoEntradaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					
					$SucursalMovimientoEntradaDetalle->CliNombre = (($fila['CliNombre']));
					$SucursalMovimientoEntradaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$SucursalMovimientoEntradaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$SucursalMovimientoEntradaDetalle->TopId = (($fila['TopId']));
					
					$SucursalMovimientoEntradaDetalle->VmvFechaUltimaSalida = (($fila['VmvFechaUltimaSalida']));
					$SucursalMovimientoEntradaDetalle->VmvUltimaSalidaDiaTranscurridos = (($fila['VmvUltimaSalidaDiaTranscurridos']));

					$SucursalMovimientoEntradaDetalle->VmvTipo = (($fila['VmvTipo']));
					$SucursalMovimientoEntradaDetalle->VmvSubTipo = (($fila['VmvSubTipo']));

			
                    $SucursalMovimientoEntradaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $SucursalMovimientoEntradaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;					
			
		}	
		
	
	
	
	
	  public function MtdObtenerVehiculoMovimientoSalidaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMovimientoSalida=NULL,$oEstado=NULL,$oVehducto=NULL,$oVehiculoMovimientoSalidaEstado=NULL,$oVehiculoMarca=NULL,$oVehductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursalId=NULL,$oSucursalMovimientoSubTipo=NULL) {

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
		
		if(!empty($oVehiculoMovimientoSalida)){
			$vmvvimiento = ' AND vmd.VmvId = "'.$oVehiculoMovimientoSalida.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND vmd.VmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oVehducto)){
			$vehiculo = ' AND (vmd.VehId = "'.$oVehducto.'") ';
		}
		
		
		if(!empty($oVehiculoMovimientoSalidaEstado)){
			$amestado = ' AND (vmv.VmvEstado = '.$oVehiculoMovimientoSalidaEstado.') ';
		}



		if(!empty($oVehiculoMarca)){
			
			
			/*$vmarca = '
			
			AND 
			
			(
				EXISTS (
					
					SELECT
					pvv.PvvId
					FROM tblpvvvehiculovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					
					AND vmd.VehId = pvv.VehId
				)
				
				OR
				
				veh.VmaId = "'.$oVehiculoMarca.'"
			)
			';*/
		}
		


		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmd.VmdFecha)>="'.$oFechaInicio.'" AND DATE(vmd.VmdFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(vmd.VmdFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(vmd.VmdFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
	if(!empty($oSucursalId)){
			$sucursal = ' AND (vmv.SucId = "'.$oSucursalId.'") ';
		}
		
		
		if(!empty($oSucursalMovimientoSubTipo)){

			$elementos = explode(",",$oSucursalMovimientoSubTipo);

			$i=1;
			$amstipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$amstipo .= '  (vmv.VmvSubTipo = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$amstipo .= ' OR ';	
				}
			$i++;		
			}

			$amstipo .= ' ) 
			)
			';

		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vmd.VmdId,			
			vmd.VmvId,
			
			vmd.VehId,
			vmd.UmeId,
			
			vmd.VmdCosto,
			vmd.VmdCantidad,
			vmd.VmdCantidadReal,

			vmd.VmdValorTotal,
			vmd.VmdUtilidad,
			vmd.VmdPrecioVenta,

			vmd.VmdImporte,
			vmd.VmdEstado,
			DATE_FORMAT(vmd.VmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVmdTiempoCreacion",
	        DATE_FORMAT(vmd.VmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVmdTiempoModificacion",
			veh.VehCodigoIdentificador,

			veh.VehNombre,

			veh.UmeId AS "UmeIdOrigen",
			ume2.UmeNombre  AS "UmeNombreOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(vmv.VmvFecha, "%d/%m/%Y") AS "NVmvFecha",
			DATE_FORMAT(vmd.VmdFecha, "%d/%m/%Y") AS "NVmdFecha",
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			cli.CliNumeroDocumento,
			
			top.TopNombre,
			
			(
			SELECT 

			CONCAT(fta.FtaNumero,"-",fac.FacId)
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.VmvId = vmd.VmvId
			LIMIT 1
			) AS VmdFactura,
			

			(
			SELECT 

			DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.VmvId = vmd.VmvId
			LIMIT 1
			) AS VmdFacturaFechaEmision,
			
			
			(
			SELECT 

			CONCAT(bta.BtaNumero,"-",bol.BolId)
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
			WHERE bol.VmvId = vmd.VmvId
			LIMIT 1
			) AS VmdBoleta,
			
			(
			SELECT 

			DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
			
			FROM tblbolboleta bol
				LEFT JOIN tblbtaboletatalonario bta
				ON bol.BtaId = bta.BtaId
			WHERE bol.VmvId = vmd.VmvId 
			LIMIT 1
			) AS VmdBoletaFechaEmision,
			
			ovv.VdiId,
			
			
			@FdeCantidad:=(
			
				SELECT 
				SUM(fde.FdeCantidad)
				FROM tblfdefacturadetalle fde
				
					LEFT JOIN tblfacfactura fac
					ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
						
				WHERE fac.VmvId = vmv.VmvId
					AND fac.FacEstado <> 6
				LIMIT 1

			) AS FdeCantidad,
			
			
			@BdeCantidad:=(
			
				SELECT 
				SUM(bde.BdeCantidad)
				FROM tblbdeboletadetalle bde
				
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
						
				WHERE bol.VmvId = vmv.VmvId
					AND bol.BolEstado <> 6
				LIMIT 1

			) AS BdeCantidad,
			
			(
			IFNULL(vmd.VmdCantidad,0) - IFNULL(@FdeCantidad,0) - IFNULL(@BdeCantidad,0) 				
			) AS VmdCantidadPendienteFacturar,
			
			vmd.VmdReingreso,
			
			vmv.VmvTipo,
			vmv.VmvSubTipo
			
			FROM tblvmdvehiculomovimientodetalle vmd
				
				LEFT JOIN tblvmvvehiculomovimiento vmv
				ON vmd.VmvId = vmv.VmvId
				
					LEFT JOIN tblvehvehiculo veh
					ON vmd.VehId = veh.VehId
				
						LEFT JOIN tblovvordenventavehiculo ovv
						ON vmd.OvvId = ovv.OvvId
							
							
							LEFT JOIN tblumeunidadmedida ume
							ON vmd.UmeId = ume.UmeId		
		
								LEFT JOIN tblumeunidadmedida ume2
								ON veh.UmeId = ume2.UmeId
		
									LEFT JOIN tblvmvvehiculomovimiento vmv
									ON vmd.VmvId = vmv.VmvId
									
										LEFT JOIN tblclicliente cli
										ON vmv.CliId = cli.CliId
										
										LEFT JOIN tbltoptipooperacion top
										ON vmv.TopId = top.TopId
			
								
			WHERE   vmv.VmvTipo = 2 
		
			'.$vmvvimiento.$fecha.$estado.$vehiculo.$filtrar.$amestado.$amstipo.$vmarca.$sucursal.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoMovimientoSalidaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VehiculoMovimientoSalidaDetalle = new $InsVehiculoMovimientoSalidaDetalle();
                    $VehiculoMovimientoSalidaDetalle->VmdId = $fila['VmdId'];
                    $VehiculoMovimientoSalidaDetalle->VmvId = $fila['VmvId'];
			
					$VehiculoMovimientoSalidaDetalle->UmeId = $fila['UmeId'];
					
					$VehiculoMovimientoSalidaDetalle->VmdCosto = $fila['VmdCosto'];  
			        $VehiculoMovimientoSalidaDetalle->VmdCantidad = $fila['VmdCantidad'];  
				
					
					$VehiculoMovimientoSalidaDetalle->VmdValorTotal = $fila['VmdValorTotal'];  
					$VehiculoMovimientoSalidaDetalle->VmdUtilidad = $fila['VmdUtilidad'];  					
					$VehiculoMovimientoSalidaDetalle->VmdPrecioVenta = $fila['VmdPrecioVenta'];  					

					$VehiculoMovimientoSalidaDetalle->VmdImporte = $fila['VmdImporte'];
					
					$VehiculoMovimientoSalidaDetalle->VmdEstado = $fila['VmdEstado'];
					$VehiculoMovimientoSalidaDetalle->VmdTiempoCreacion = $fila['NVmdTiempoCreacion'];  
					$VehiculoMovimientoSalidaDetalle->VmdTiempoModificacion = $fila['NVmdTiempoModificacion']; 					
					$VehiculoMovimientoSalidaDetalle->VehId = $fila['VehId'];
					$VehiculoMovimientoSalidaDetalle->VehCodigoIdentificador = $fila['VehCodigoIdentificador'];

                    $VehiculoMovimientoSalidaDetalle->VehNombre = (($fila['VehNombre']));

					$VehiculoMovimientoSalidaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$VehiculoMovimientoSalidaDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					
					$VehiculoMovimientoSalidaDetalle->UmeNombre = (($fila['UmeNombre']));
					$VehiculoMovimientoSalidaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$VehiculoMovimientoSalidaDetalle->VmvFecha = (($fila['NVmvFecha']));
					$VehiculoMovimientoSalidaDetalle->VmdFecha = (($fila['NVmdFecha']));
					
					$VehiculoMovimientoSalidaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$VehiculoMovimientoSalidaDetalle->CliNombre = (($fila['CliNombre']));
					$VehiculoMovimientoSalidaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VehiculoMovimientoSalidaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$VehiculoMovimientoSalidaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$VehiculoMovimientoSalidaDetalle->TopNombre = (($fila['TopNombre']));
		
					$VehiculoMovimientoSalidaDetalle->VmdFactura = (($fila['VmdFactura']));
					$VehiculoMovimientoSalidaDetalle->VmdFacturaFechaEmision = (($fila['VmdFacturaFechaEmision']));
					
					$VehiculoMovimientoSalidaDetalle->VmdBoleta = (($fila['VmdBoleta']));
					$VehiculoMovimientoSalidaDetalle->VmdBoletaFechaEmision = (($fila['VmdBoletaFechaEmision']));
			
					$VehiculoMovimientoSalidaDetalle->FdeCantidad = (($fila['FdeCantidad']));
					$VehiculoMovimientoSalidaDetalle->BdeCantidad = (($fila['BdeCantidad']));
					$VehiculoMovimientoSalidaDetalle->VmdCantidadPendienteFacturar = (($fila['VmdCantidadPendienteFacturar']));
			
					$VehiculoMovimientoSalidaDetalle->VmdReingreso = (($fila['VmdReingreso']));
					
					$VehiculoMovimientoSalidaDetalle->VmvTipo = (($fila['VmvTipo']));
					$VehiculoMovimientoSalidaDetalle->VmvSubTipo = (($fila['VmvSubTipo']));
			
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