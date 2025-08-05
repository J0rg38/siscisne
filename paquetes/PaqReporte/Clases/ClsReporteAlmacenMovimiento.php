<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenProductoStock
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsReporteAlmacenMovimiento {

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
  public function MtdObtenerAlmacenMovimientoEntradaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oCliente=NULL,$oConOrdenCompra=0,$oOrdenCompra=NULL,$oPedidoCompraDetalleId=NULL,$oVentaDirectaDetalleId=NULL,$oAlmacenMovimientoEntradaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oDiasInactivoInicio=NULL,$oDiasInactivoFin=NULL,$oProducto=NULL,$oProductoABCInterno=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
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
		



		if(!empty($oAlmacenMovimientoEntradaEstado)){
			$amestado = ' AND (amo.AmoEstado = "'.$oAlmacenMovimientoEntradaEstado.'") ';
		}
		
		
	
		if(!empty($oVehiculoMarca)){

			$elementos = explode(",",$oVehiculoMarca);

				$i=1;
				$vmarca .= ' AND (';
				$elementos = array_filter($elementos);

				foreach($elementos as $elemento){
						$vmarca .= '  

						(
							EXISTS (
								
								SELECT
								pvv.PvvId
								FROM tblpvvproductovehiculoversion pvv
									LEFT JOIN tblvvevehiculoversion vve
									ON pvv.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
								WHERE vmo.VmaId = "'.$elemento.'"
								AND amd.ProId = pvv.ProId
							)
							
							OR
							
							pro.VmaId = "'.$elemento.'"
						)
			
						
						';	
						if($i<>count($elementos)){						
							$vmarca .= ' OR ';	
						}
				$i++;		
				}
				
				$vmarca .= ' ) ';

		}
		
		
		//
//		if(!empty($oVehiculoMarca)){
//			
//			$vmarca = '
//			AND 
//			
//			(
//				EXISTS (
//					
//					SELECT
//					pvv.PvvId
//					FROM tblpvvproductovehiculoversion pvv
//						LEFT JOIN tblvvevehiculoversion vve
//						ON pvv.VveId = vve.VveId
//							LEFT JOIN tblvmovehiculomodelo vmo
//							ON vve.VmoId = vmo.VmoId
//					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
//					AND amd.ProId = pvv.ProId
//				)
//				
//				OR
//				
//				pro.VmaId = "'.$oVehiculoMarca.'"
//			)
//			';
//		}
		
		
		//if(!empty($oProductoTipo)){
		//	$ptipo = ' AND (pro.RtiId = "'.$oProductoTipo.'") ';
		//}
		

		if(!empty($oProductoTipo)){

			$elementos = explode(",",$oProductoTipo);

				$i=1;
				$ptipo .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$ptipo .= '  (pro.RtiId = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$ptipo .= ' OR ';	
						}
				$i++;		
				}
				
				$ptipo .= ' ) ';

		}
		
		
		//if(!empty($oDiasInactivoInicio)){
//			$dinactivo = ' HAVING AmoUltimaSalidaDiaTranscurridos '.$AmoUltimaSalidaDiaTranscurridos.'") ';
//		}
			
	
		if(!empty($oDiasInactivoInicio)){
			
			if(!empty($oDiasInactivoFin)){
				
				$dinactivo .= ' AND  (
				
				(
					TIMESTAMPDIFF(DAY, 
				
					
						
					IFNULL( 
				
					(		
						
						SELECT 
						amo2.AmoFecha
						FROM tblamdalmacenmovimientodetalle amd2
							LEFT JOIN tblamoalmacenmovimiento amo2
							ON amd2.AmoId = amo2.AmoId
								WHERE amo2.AmoTipo = 2
								AND amd2.ProId = amd.ProId
								
								
				';

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}	
				
				
				$dinactivo .= '
						ORDER BY amo2.AmoFecha DESC
						LIMIT 1
						
						)
					,amo.AmoFecha

 					)
		
					
				
					, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) 
					)
					
				) >="'.$oDiasInactivoInicio.'" AND 
				
				
				(
				
				TIMESTAMPDIFF(DAY, 
			
					
					IFNULL( 
				
					(	
						SELECT 
						amo2.AmoFecha
						FROM tblamdalmacenmovimientodetalle amd2
							LEFT JOIN tblamoalmacenmovimiento amo2
							ON amd2.AmoId = amo2.AmoId
								WHERE amo2.AmoTipo = 2
								AND amd2.ProId = amd.ProId
								
								
					';
	
			if(!empty($oFechaInicio)){
				
				if(!empty($oFechaFin)){
					$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
				}else{
					$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
				}
				
			}else{
				if(!empty($oFechaFin)){
					$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
				}			
			}	
			
			
						$dinactivo .= '					
								
								
						ORDER BY amo2.AmoFecha DESC
						LIMIT 1
		
				
					)
				,amo.AmoFecha

 				)
				
				
				, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) 
				) <="'.$oDiasInactivoFin.'"
				
				';
			}else{
				
				$dinactivo = ' AND  
				
			(TIMESTAMPDIFF(DAY, 
			
					
					IFNULL( 
				
					(	
					
					SELECT 
					amo2.AmoFecha
					FROM tblamdalmacenmovimientodetalle amd2
						LEFT JOIN tblamoalmacenmovimiento amo2
						ON amd2.AmoId = amo2.AmoId
							WHERE amo2.AmoTipo = 2
							AND amd2.ProId = amd.ProId
							
			
			';

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}	
		
		
					$dinactivo .= '			
					
					
							
							
					ORDER BY amo2.AmoFecha DESC
					LIMIT 1
	
				)
				,amo.AmoFecha

 				)
			
				, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) )	
				
				
				 >="'.$oDiasInactivoInicio.'"';
			}
			
		}else{
			
			if(!empty($oDiasInactivoFin)){
				
				$dinactivo = ' AND  
				
				
					(TIMESTAMPDIFF(DAY, 
				
					IFNULL( 
				
					(	
	
						SELECT 
						amo2.AmoFecha
						FROM tblamdalmacenmovimientodetalle amd2
							LEFT JOIN tblamoalmacenmovimiento amo2
							ON amd2.AmoId = amo2.AmoId
								WHERE amo2.AmoTipo = 2
								AND amd2.ProId = amd.ProId
								
			
			
			';

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$dinactivo .= ' AND DATE(amo2.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$dinactivo .= ' AND DATE(amo2.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}	
		
		
					$dinactivo .= '			
					
					
								
								
						ORDER BY amo2.AmoFecha DESC
						LIMIT 1
	)
				,amo.AmoFecha

 				)
					
				
					, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) )
				
					<="'.$oDiasInactivoFin.'"';		
			}
						
		}
			
//			if(!empty($oDiasInactivoInicio)){
//			
//			if(!empty($oDiasInactivoFin)){
//				$dinactivo = ' HAVING  AmoUltimaSalidaDiaTranscurridos >="'.$oDiasInactivoInicio.'" AND AmoUltimaSalidaDiaTranscurridos <="'.$oDiasInactivoFin.'"';
//			}else{
//				$dinactivo = ' HAVING  AmoUltimaSalidaDiaTranscurridos >="'.$oDiasInactivoInicio.'"';
//			}
//			
//		}else{
//			
//			if(!empty($oDiasInactivoFin)){
//				$dinactivo = ' HAVING  AmoUltimaSalidaDiaTranscurridos <="'.$oDiasInactivoFin.'"';		
//			}
//						
//		}	
		
		
		if(!empty($oProducto)){
			$producto = ' AND pro.ProId = "'.$oProducto.'" ';		
		}	
		
			
		
		if(!empty($oProductoABCInterno)){

			$elementos = explode(",",$oProductoABCInterno);

			$i=1;
			$pabcinterno .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$pabcinterno .= '  (pro.ProABCInterno = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$pabcinterno .= ' OR ';	
				}
			$i++;		
			}

			$pabcinterno .= ' ) ';

		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND amo.SucId = "'.$oSucursal.'" ';		
		}	
		
		
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) ="'.($oAno).'"';
		}
		
	/*	@AmoFechaUltimaSalida :=(
				SELECT 
				amo2.AmoFecha
				FROM tblamdalmacenmovimientodetalle amd2
					LEFT JOIN tblamoalmacenmovimiento amo2
					ON amd2.AmoId = amo2.AmoId
						WHERE amo2.AmoTipo = 2
						AND amd2.ProId = amd.ProId
				ORDER BY amo2.AmoFecha DESC
				LIMIT 1

			),
			
			
			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos*/
			$sql = '
			SELECT
			'.$funcion.' AS "RESULTADO"
			
			
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblpcdpedidocompradetalle pcd
				ON amd.PcdId = pcd.PcdId
					
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
					
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

			WHERE  amo.AmoTipo = 1 '.$ano.$mes.$amovimiento.$sucursal.$pabcinterno.$producto.$estado.$producto.$filtrar.$fecha.$cliente.$cocompra.$ocompra.$pcdetalle.$vddetalle.$amestado.$vmarca.$ptipo.$dinactivo.$orden.$paginacion;	
					
					
//							(
//				SELECT 
//				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
//				FROM tblamdalmacenmovimientodetalle amd2
//					LEFT JOIN tblamoalmacenmovimiento amo2
//					ON amd2.AmoId = amo2.AmoId
//						WHERE amo2.AmoTipo = 2
//						AND amd2.ProId = amd.ProId
//				ORDER BY amo2.AmoFecha DESC
//				LIMIT 1
//
//			) AS AmoFechaUltimaSalida,
//			
//
//
//
//			IFNULL(
//				(SELECT 
//				DATE_FORMAT(amo2.AmoFecha, "%d/%m/%Y") 
//				FROM tblamdalmacenmovimientodetalle amd2
//					LEFT JOIN tblamoalmacenmovimiento amo2
//					ON amd2.AmoId = amo2.AmoId
//						WHERE amo2.AmoTipo = 2
//						AND amd2.ProId = amd.ProId
//				ORDER BY amo2.AmoFecha DESC
//				LIMIT 1),NOW()
//			) 
//			
//						
//			(TIMESTAMPDIFF(DAY, @AmoFechaUltimaSalida, "'.(empty($oFechaFin)?date("Y-m-d"):$oFechaFin).' 00:00:00" ) ) AS AmoUltimaSalidaDiaTranscurridos
//			
//			
//			
//			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}		
		
		
		
	public function MtdObtenerTallerPedidoDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oProductoABCInterno=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oTallerPedido)){
			$amovimiento = ' AND amd.AmoId = "'.$oTallerPedido.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}



		if(!empty($oTallerPedidoEstado)){
			$tpestado = ' AND ( amo.AmoEstado = "'.$oTallerPedidoEstado.'" ) ';
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
			$ptipo = ' AND ( pro.RtiId = "'.$oProductoTipo.'" ) ';
		}	
		
//		if(!empty($oProductoABCInterno)){
//			$pabcinterno = ' AND ( pro.ProABCInterno = "'.$oProductoABCInterno.'" ) ';
//		}	

		if(!empty($oProductoABCInterno)){

			$elementos = explode(",",$oProductoABCInterno);

			$i=1;
			$pabcinterno .= ' AND (';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$pabcinterno .= '  (pro.ProABCInterno = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$pabcinterno .= ' OR ';	
				}
			$i++;		
			}

			$pabcinterno .= ' ) ';

		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (amo.SucId)="'.$oSucursal.'"';		
		}	
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) = "'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) = "'.($oAno).'"';
		}
		
		
		
			$sql = '
			SELECT
				'.$funcion.' AS "RESULTADO"

			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfaafichaaccionmantenimiento faa
							ON amd.FaaId = faa.FaaId
							
									LEFT JOIN tblfapfichaaccionproducto fap
									ON fap.FaaId = faa.FaaId

			WHERE  amo.AmoTipo = 2  
				AND amo.AmoSubTipo = 2 
			'.$ano.$mes.$amovimiento.$estado.$fecha.$pabcinterno.$sucursal.$producto.$filtrar.$tpestado.$vmarca.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];			
		}
		
		
		
		
	 public function MtdObtenerVentaConcretadaDetallesValor($oFuncion="SUM",$oParametro="AmoTotal",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oVentaConcretada)){
			$vconcretada = ' AND amd.AmoId = "'.$oVentaConcretada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
	
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (amd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}

		if(!empty($oVentaConcretadaEstado)){
			$vcestado = ' AND (amo.AmoEstado = "'.$oVentaConcretadaEstado.'") ';
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
			
		if(!empty($oSucursal)){
			$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
		}
		
			
			
			
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(amo.AmoFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(amo.AmoFecha) ="'.($oAno).'"';
		}
		
		 $sql = '
			SELECT
				'.$funcion.' AS "RESULTADO"
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblclicliente cli
							ON amo.CliId = cli.CliId
							
			WHERE  amo.AmoTipo = 2  AND amo.AmoSubTipo = 3 '.$ano.$mes.$sucursal.$vconcretada.$estado.$producto.$filtrar.$vddetalle.$vcestado.$vmarca.$ptipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];		
		}	
		
		/*
		* AGREGADO 28/11/2018
		*/
		
		
		    public function MtdObtenerVentaConcretadaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaConcretada=NULL,$oEstado=NULL,$oProducto=NULL,$oVentaDirectaDetalleId=NULL,$oVentaConcretadaEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oVentaConcretada)){
			$vconcretada = ' AND amd.AmoId = "'.$oVentaConcretada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
	
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (amd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}

		if(!empty($oVentaConcretadaEstado)){
			$vcestado = ' AND (amo.AmoEstado = "'.$oVentaConcretadaEstado.'") ';
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
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oSucursal)){
			$sucursal = ' AND DATE(amo.SucId) = "'.$oSucursal.'"';		
		}	
				
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
			amd.VddId,
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,

			amd.AmdReingreso,
			amd.AmdCompraOrigen,
			amd.AmdCierre,
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			
			vdd.VdiId,
			
			


(
		

				IFNULL(
					(
						SELECT 
						CONCAT(fta.FtaNumero,"-",fac.FacId) 
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE amd.AmoId = fac.AmoId
						AND fac.FacEstado <> 6 LIMIT 1
					),
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
							AND fac.FacEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS VcdFactura,
			
			
			
			
			
			
					(
		

				IFNULL(
					(
						SELECT 
						CONCAT(bta.BtaNumero,"-",bol.BolId) 
						FROM tblbolboleta bol
							LEFT JOIN tblbtaboletatalonario bta
							ON bol.BtaId = bta.BtaId
						WHERE amd.AmoId = bol.AmoId
						AND bol.BolEstado <> 6 LIMIT 1
					),
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
							AND bol.BolEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS VcdBoleta,
			
			
			
			
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.ProCosto,
			pro.ProCostoIngreso,
			
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			vdd.ProId AS ProIdReemplazo,
			pro2.ProCodigoOriginal AS ProCodigoOriginalReemplazo,
			
			IF(vdd.ProId<>amd.ProId,"Si","No") AS AmdReemplazo,
			
			
			
			@AmdFacturado:=(
			
				SELECT 
				SUM(fde.FdeCantidad)
				FROM tblfdefacturadetalle fde
					
						LEFT JOIN tblfacfactura fac
						ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)

				WHERE fde.AmdId = amd.AmdId
				
					AND fac.FacEstado <> 6
					
					AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
														AND ncr.NcrEstado <> 6
AND ncr.NcrMotivoCodigo<> "04"
													)
					
					
				LIMIT 1

			) AS AmdFacturado,
			
			
			@AmdFacturado2:=(
			
				SELECT 
				SUM(bde.BdeCantidad)
				FROM tblbdeboletadetalle bde
				
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
						
				WHERE bde.AmdId = amd.AmdId
					AND bol.BolEstado <> 6
					
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
						)
						
				LIMIT 1

			) AS AmdFacturado2,

			(
			amd.AmdCantidad - IFNULL(@AmdFacturado,0) - IFNULL(@AmdFacturado2,0)
			) AS AmdCantidadFacturar,
			
			suc.SucNombre	,
			
			rti.RtiNombre		,
			
			vdi.VdiTipo
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					LEFT JOIN tblrtiproductotipo rti
					ON pro.RtiId = rti.RtiId
					
					LEFT JOIN tblumeunidadmedida ume
					ON amd.UmeId = ume.UmeId				
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblclicliente cli
							ON amo.CliId = cli.CliId
								LEFT JOIN tblvddventadirectadetalle vdd
								ON amd.VddId = vdd.VddId
									LEFT JOIN tblproproducto pro2
									ON vdd.ProId = pro2.ProId
										LEFT JOIN tblsucsucursal suc
										ON amo.SucId = suc.SucId
											LEFT JOIN tblvdiventadirecta vdi
											ON vdd.VdiId = vdi.VdiId
			WHERE amo.AmoTipo = 2 
			AND amo.AmoSubTipo = 3 
				AND pro.ProValidarStock = 1
			'.$vconcretada.$estado.$producto.$filtrar.$vddetalle.$sucursal.$vcestado.$vmarca.$fecha.$ptipo .$orden.$paginacion;	

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsVentaConcretadaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaConcretadaDetalle = new $InsVentaConcretadaDetalle();
                    $VentaConcretadaDetalle->VcdId = $fila['AmdId'];
                    $VentaConcretadaDetalle->VcoId = $fila['AmoId'];
					$VentaConcretadaDetalle->UmeId = $fila['UmeId'];
					
					$VentaConcretadaDetalle->VddId = $fila['VddId'];
					
					$VentaConcretadaDetalle->VcdCosto = $fila['AmdCosto'];  
			        $VentaConcretadaDetalle->VcdCantidad = $fila['AmdCantidad'];  
					$VentaConcretadaDetalle->VcdCantidadReal = $fila['AmdCantidadReal'];  
					
					$VentaConcretadaDetalle->VcdValorTotal = $fila['AmdValorTotal'];  
					$VentaConcretadaDetalle->VcdUtilidad = $fila['AmdUtilidad'];  					
					$VentaConcretadaDetalle->VcdPrecioVenta = $fila['AmdPrecioVenta'];  					

					$VentaConcretadaDetalle->VcdImporte = $fila['AmdImporte'];
					$VentaConcretadaDetalle->VcdReingreso = $fila['AmdReingreso'];
					$VentaConcretadaDetalle->VcdCompraOrigen = $fila['AmdCompraOrigen'];
					
					
					$VentaConcretadaDetalle->VcdCierre = $fila['AmdCierre'];
					$VentaConcretadaDetalle->VcdEstado = $fila['AmdEstado'];
					$VentaConcretadaDetalle->VcdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$VentaConcretadaDetalle->VcdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
				
					
					$VentaConcretadaDetalle->VdiId = $fila['VdiId'];
					
					$VentaConcretadaDetalle->VcdFactura = $fila['VcdFactura'];
					$VentaConcretadaDetalle->VcdBoleta = $fila['VcdBoleta'];
					
					
					$VentaConcretadaDetalle->ProId = $fila['ProId'];
					$VentaConcretadaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$VentaConcretadaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $VentaConcretadaDetalle->ProNombre = (($fila['ProNombre']));
					
					$VentaConcretadaDetalle->ProCosto = $fila['ProCosto'];
                    $VentaConcretadaDetalle->ProCostoIngreso = (($fila['ProCostoIngreso']));
					
			
					$VentaConcretadaDetalle->RtiId = (($fila['RtiId']));
					$VentaConcretadaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$VentaConcretadaDetalle->UmeNombre = (($fila['UmeNombre']));
					$VentaConcretadaDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					
					//$VentaConcretadaDetalle->AmoFecha = (($fila['NAmoFecha']));
					$VentaConcretadaDetalle->VcoFecha = (($fila['NAmoFecha']));
					
					$VentaConcretadaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$VentaConcretadaDetalle->CliNombre = (($fila['CliNombre']));
					$VentaConcretadaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$VentaConcretadaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$VentaConcretadaDetalle->ProIdReemplazo = (($fila['ProIdReemplazo']));
					$VentaConcretadaDetalle->ProCodigoOriginalReemplazo = (($fila['ProCodigoOriginalReemplazo']));
					$VentaConcretadaDetalle->AmdReemplazo = (($fila['AmdReemplazo']));
					
					$VentaConcretadaDetalle->VcdCantidadFacturar = (($fila['AmdCantidadFacturar']));
					
					$VentaConcretadaDetalle->SucNombre = (($fila['SucNombre']));
					
					$VentaConcretadaDetalle->RtiNombre = (($fila['RtiNombre']));
	
	
		$VentaConcretadaDetalle->VdiTipo = (($fila['VdiTipo']));
	
			
                    $VentaConcretadaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaConcretadaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		

    public function MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oVentaDirectaDetalle=NULL,$oFichaAccion=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oTallerPedido)){
			$amovimiento = ' AND amd.AmoId = "'.$oTallerPedido.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND amd.AmdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (amd.ProId = "'.$oProducto.'") ';
		}
		
		
		if(!empty($oTallerPedidoEstado)){
			$amestado = ' AND (amo.AmoEstado = '.$oTallerPedidoEstado.') ';
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
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'" AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(amo.AmoFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(amo.AmoFecha)<="'.$oFechaFin.'"';		
			}			
		}

			if(!empty($oVentaDirectaDetalle)){
				$vdetalle = ' AND (amd.VddId = "'.$oVentaDirectaDetalle.'") ';
			}
			
			if(!empty($oFichaAccion)){
				$faccion = ' AND (amo.FccId = "'.$oFichaAccion.'") ';
			}
			
				
			if(!empty($oSucursal)){
				$sucursal = ' AND (amo.SucId = "'.$oSucursal.'") ';
			}
			
			$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			amd.AmdId,			
			amd.AmoId,
			amd.ProId,
			amd.UmeId,
			
		  	amd.VddId,
			amd.FaaId,
			amd.FapId,
			
			amd.AlmId,
			DATE_FORMAT(amd.AmdFecha, "%d/%m/%Y") AS "NAmdFecha",
			
			amd.AmdCosto,
			amd.AmdCantidad,
			amd.AmdCantidadReal,

			amd.AmdValorTotal,
			amd.AmdUtilidad,
			amd.AmdPrecioVenta,

			amd.AmdImporte,
			amo.AmoCierre,
			amd.AmdEstado,
			DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoCreacion",
	        DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmdTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			pro.ProTienePromocion,
			pro.ProCosto,
			pro.ProCostoIngreso,
			
			ume2.UmeNombre  AS "UmeNombreOrigen",
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
	        DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha",
			
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
		

				IFNULL(
					(
						SELECT 
						CONCAT(fta.FtaNumero,"-",fac.FacId) 
						FROM tblfacfactura fac
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
						WHERE amd.AmoId = fac.AmoId
						AND fac.FacEstado <> 6 LIMIT 1
					),
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
							AND fac.FacEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS AmdFactura,
			
			
			
			
			
			
					(
		

				IFNULL(
					(
						SELECT 
						CONCAT(bta.BtaNumero,"-",bol.BolId) 
						FROM tblbolboleta bol
							LEFT JOIN tblbtaboletatalonario bta
							ON bol.BtaId = bta.BtaId
						WHERE amd.AmoId = bol.AmoId
						AND bol.BolEstado <> 6 LIMIT 1
					),
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
							AND bol.BolEstado <> 6 LIMIT 1
						),
						""
						)
					)
				
			) AS AmdBoleta,
			
			
			
			
			
			
			(
			SELECT 

			CONCAT(fta.FtaNumero,"-",fac.FacId)
			
			FROM tblfacfactura fac
				LEFT JOIN tblftafacturatalonario fta
				ON fac.FtaId = fta.FtaId
			WHERE fac.AmoId = amd.AmoId
			LIMIT 1
			) AS AmdFacturaX,
			

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
			) AS AmdBoletaX,
			
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
					AND NOT EXISTS(
														SELECT 	
														ncr.NcrId
														FROM tblncrnotacredito ncr
														WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
														AND ncr.NcrEstado <> 6
AND ncr.NcrMotivoCodigo<> "04"
													)
													
													
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
					
					AND NOT EXISTS(
						SELECT 	
						ncr.NcrId
						FROM tblncrnotacredito ncr
						WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
						AND ncr.NcrEstado <> 6
						AND ncr.NcrMotivoCodigo<> "04"
					)
					
				LIMIT 1

			) AS BdeCantidad,
			
			
			(
			IFNULL(amd.AmdCantidad,0) - IFNULL(@FdeCantidad,0) - IFNULL(@BdeCantidad,0) 				
			) AS AmdCantidadPendienteFacturar,
			
			amd.AmdReingreso,
			amd.AmdCompraOrigen,
			
			CASE
			
			WHEN (
			
				EXISTS (
					SELECT 
					bde.BdeId
					FROM tblbdeboletadetalle bde
						LEFT JOIN tblbolboleta bol
						ON bol.BolId = bde.BolId AND bol.BtaId = bde.BtaId					
					WHERE bde.AmdId = amd.AmdId
					AND bol.BolEstado <> 6
					LIMIT 1
				) OR 
			
				EXISTS (
					SELECT 
					fde.FdeId
					FROM tblfdefacturadetalle fde
						LEFT JOIN tblfacfactura fac
						ON fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
					WHERE fde.AmdId = amd.AmdId
					AND fac.FacEstado <> 6
					LIMIT 1
				)
				
			)
			
			THEN 1
			ELSE 2
			END AS AmdFacturado,
			
			pro.ProTienePromocion,
			
			suc.SucNombre,
			
			rti.RtiNombre
			
			FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro.ProId
					
					LEFT JOIN tblrtiproductotipo rti
					ON pro.RtiId = rti.RtiId
				
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
									LEFT JOIN tblfapfichaaccionproducto fap
									ON fap.FaaId = faa.FaaId
									
									LEFT JOIN tblpmtplanmantenimientotarea pmt
									ON faa.PmtId = pmt.PmtId
										
										LEFT JOIN tblsucsucursal suc
										ON amo.SucId = suc.SucId
									
			WHERE   amo.AmoTipo = 2 
			AND amo.AmoSubTipo = 2
			AND pro.ProValidarStock = 1
			'.$amovimiento.$fecha.$estado.$producto.$sucursal.$filtrar.$faccion.$amestado.$vmarca.$ptipo.$vdetalle.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTallerPedidoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TallerPedidoDetalle = new $InsTallerPedidoDetalle();
                    $TallerPedidoDetalle->AmdId = $fila['AmdId'];
                    $TallerPedidoDetalle->AmoId = $fila['AmoId'];
					$TallerPedidoDetalle->UmeId = $fila['UmeId'];
					
					
					//deb($fila['FapId']);
					
					$TallerPedidoDetalle->VddId = $fila['VddId'];
					$TallerPedidoDetalle->FaaId = $fila['FaaId'];
					$TallerPedidoDetalle->FapId = $fila['FapId'];
					
					$TallerPedidoDetalle->AlmId = $fila['AlmId'];
					$TallerPedidoDetalle->AmdFecha = $fila['NAmdFecha'];
			
					$TallerPedidoDetalle->AmdCosto = $fila['AmdCosto'];  
			        $TallerPedidoDetalle->AmdCantidad = $fila['AmdCantidad'];  
					$TallerPedidoDetalle->AmdCantidadReal = $fila['AmdCantidadReal'];  
					
					$TallerPedidoDetalle->AmdValorTotal = $fila['AmdValorTotal'];  
					$TallerPedidoDetalle->AmdUtilidad = $fila['AmdUtilidad'];  					
					$TallerPedidoDetalle->AmdPrecioVenta = $fila['AmdPrecioVenta'];  					

					$TallerPedidoDetalle->AmdImporte = $fila['AmdImporte'];
					
					$TallerPedidoDetalle->AmdEstado = $fila['AmdEstado'];
					$TallerPedidoDetalle->AmdTiempoCreacion = $fila['NAmdTiempoCreacion'];  
					$TallerPedidoDetalle->AmdTiempoModificacion = $fila['NAmdTiempoModificacion']; 					
					$TallerPedidoDetalle->ProId = $fila['ProId'];
					$TallerPedidoDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$TallerPedidoDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $TallerPedidoDetalle->ProNombre = (($fila['ProNombre']));
					$TallerPedidoDetalle->RtiId = (($fila['RtiId']));
					$TallerPedidoDetalle->ProTienePromocion = (($fila['ProTienePromocion']));
					
					
					$TallerPedidoDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$TallerPedidoDetalle->UmeNombreOrigen = (($fila['UmeNombreOrigen']));
					
					
					$TallerPedidoDetalle->UmeNombre = (($fila['UmeNombre']));
					$TallerPedidoDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$TallerPedidoDetalle->AmoFecha = (($fila['NAmoFecha']));
					
					$TallerPedidoDetalle->PmtId = (($fila['PmtId']));
					
					$TallerPedidoDetalle->FaaAccion = (($fila['FaaAccion']));
					$TallerPedidoDetalle->FaaNivel = (($fila['FaaNivel']));
					$TallerPedidoDetalle->FaaVerificar1 = (($fila['FaaVerificar1']));
					$TallerPedidoDetalle->FaaVerificar2 = (($fila['FaaVerificar2']));
					
					$TallerPedidoDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
					$TallerPedidoDetalle->CliNombre = (($fila['CliNombre']));
					$TallerPedidoDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$TallerPedidoDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$TallerPedidoDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));
					
					$TallerPedidoDetalle->TopNombre = (($fila['TopNombre']));
					
					$TallerPedidoDetalle->FinId = (($fila['FinId']));
					
					$TallerPedidoDetalle->MinNombre = (($fila['MinNombre']));
					
					$TallerPedidoDetalle->AmdFactura = (($fila['AmdFactura']));
					$TallerPedidoDetalle->AmdFacturaFechaEmision = (($fila['AmdFacturaFechaEmision']));
					
					$TallerPedidoDetalle->AmdBoleta = (($fila['AmdBoleta']));
					$TallerPedidoDetalle->AmdBoletaFechaEmision = (($fila['AmdBoletaFechaEmision']));
			
					$TallerPedidoDetalle->VdiId = (($fila['VdiId']));
					
					$TallerPedidoDetalle->FdeCantidad = (($fila['FdeCantidad']));
					$TallerPedidoDetalle->BdeCantidad = (($fila['BdeCantidad']));
					$TallerPedidoDetalle->AmdCantidadPendienteFacturar = (($fila['AmdCantidadPendienteFacturar']));
			
					$TallerPedidoDetalle->AmdReingreso = (($fila['AmdReingreso']));
					$TallerPedidoDetalle->AmdCompraOrigen = (($fila['AmdCompraOrigen']));
					
					$TallerPedidoDetalle->AmdFacturado = (($fila['AmdFacturado']));
					
					$TallerPedidoDetalle->AmoCierre = (($fila['AmoCierre']));
					
					$TallerPedidoDetalle->ProTienePromocion = (($fila['ProTienePromocion']));
					
					$TallerPedidoDetalle->ProCosto = (($fila['ProCosto']));
					$TallerPedidoDetalle->ProCostoIngreso = (($fila['ProCostoIngreso']));
					
					$TallerPedidoDetalle->SucNombre = (($fila['SucNombre']));
					
					$TallerPedidoDetalle->RtiNombre = (($fila['RtiNombre']));
			
					
                    $TallerPedidoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TallerPedidoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

		
}
?>