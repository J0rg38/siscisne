<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenStock
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacenStock {

	//public $AstId;
	public $ProId;
	public $AstStock;
	public $AstStockReal;
	public $AstStockIngreado;
	public $AstStockRealIngreado;
	public $AstStockMinimo;
	public $AstUbicacion;
	
	public $AstEstado;	
    public $AstTiempoCreacion;
    public $AstTiempoModificacion;
    public $AstEliminado;
	
	public $ProStockVerificado;
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProValidarUso;
	
	public $UmeNombre;
	
	public $AstIngresos;
	public $AstSalidas;
	public $AstStockCalculado;
	public $AstCostoCalculado;

	public $InsMysql;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	/*
			pro.ProStock AS AstStock,
		pro.ProStockReal AS AstStockReal,
		pro.ProStockIngresado AS AstStockIngresado,
		pro.ProStockRealIngresado AS AstStockRealIngresado,
		
	*/
    public function MtdObtenerAlmacenStock(){

        $sql = 'SELECT 
		pro.ProId,
		pro.ProStock AS AstStock,
		pro.ProStockReal AS AstStockReal,
		pro.ProStockIngresado AS AstStockIngresado,
		pro.ProStockRealIngresado AS AstStockRealIngresado,
		pro.ProUbicacion AS AstUbicacion,
		1 AS AstEstado,
		pro.ProNombre,
		pro.ProCodigoOriginal,
		pro.ProCodigoAlternativo,
		ume.UmeNombre,
		pro.ProReferencia,
		pro.ProStockVerificado,
		
		pro.ProPromedioMensual,
		pro.ProPromedioDiario,
		pro.ProDiasInmovilizado,
		DATE_FORMAT(pro.ProFechaUltimaSalida, "%d/%m/%Y") AS "NProFechaUltimaSalida"
		
	        FROM tblproproducto pro
				LEFT JOIN tblumeunidadmedida ume
				ON pro.UmeId = ume.UmeId
    			    WHERE pro.ProId = "'.$this->ProId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
				
//			MtdObtenerAlmacenMovimientoEntradaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL)
//			$InsAlmacenMovimientoEntradaDetalle = new ClsAlmacenMovimientoEntradaDetalle();
//			$ResAlmacenMovimientoEntradaDetalle['Datos'] = $InsAlmacenMovimientoEntradaDetalle->MtdObtenerAlmacenMovimientoEntradaDetalles(NULL,NULL,'AmoFecha','Desc',1,NULL,NULL,3,$this->ProId);
//			
//			$InsAlmacenMovimientoSalidaDetalle = new ClsAlmacenMovimientoSalidaDetalle();
//			$ResAlmacenMovimientoSalidaDetalle
//			
//			$this->AstId = $fila['AstId'];
			$this->ProId = $fila['ProId'];
			$this->AstStock = $fila['AstStock'];
			$this->AstStockReal = $fila['AstStockReal'];
			$this->AstStockIngresado = $fila['AstStockIngresado'];
			$this->AstStockRealIngresado = $fila['AstStockRealIngresado'];
			
			
			$this->AstStock = 0;
			$this->AstStockReal =  0;
			$this->AstStockIngresado =  0;
			$this->AstStockRealIngresado =  0;
			
			$this->AstUbicacion = $fila['AstUbicacion'];
			$this->AstEstado = $fila['AstEstado'];
			$this->ProNombre = $fila['ProNombre'];
			$this->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$this->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
			$this->UmeNombre = $fila['UmeNombre'];
			$this->ProReferencia = $fila['ProReferencia'];
			
			$this->ProStockVerificado = $fila['ProStockVerificado'];
			
			$this->ProPromedioMensual = $fila['ProPromedioMensual'];
			$this->ProPromedioDiario = $fila['ProPromedioDiario'];
			$this->ProDiasInmovilizado = $fila['ProDiasInmovilizado'];
			$this->ProFechaUltimaSalida = $fila['NProFechaUltimaSalida'];

		
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
		

//    public function MtdObtenerProductos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ProId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL)
	  public function MtdObtenerAlmacenStocks($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AstNombre',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oProductoTipo=NULL,$oVehiculoMarca=NULL,$oReferencia=NULL,$oProducto=NULL,$oProductoCategoria=NULL,$oAlmacen=NULL,$oTieneMovimiento=false,$oSucursal=NULL,$oAno) {

		//		if(!empty($oCampo) && !empty($oFiltro)){
//			$oFiltro = str_replace(" ","%",$oFiltro);
//			switch($oCondicion){
//				case "esigual":
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
//				break;
//
//				case "noesigual":
//					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
//				break;
//				
//				case "comienza":
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//				break;
//				
//				case "termina":
//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
//				break;
//				
//				case "contiene":
//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
//				break;
//				
//				case "nocontiene":
//					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
//				break;
//				
//				default:
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//				break;
//				
//			}
//			
//			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//		}

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			//$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos_buscar = explode(",",$oFiltro);///
			
			$elementos_campo = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos_campo as $elemento_campo){
					if(!empty($elemento_campo)){	
													
						if($i==count($elementos_campo)){	

							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
										
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
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
			$estado = ' AND pro.ProEstado = '.$oEstado;
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
		
		if(!empty($oProductoTipo)){
			$ptipo = ' AND pro.RtiId = "'.$oProductoTipo.'"';
		}	
	
		if(!empty($oVehiculoMarca)){
			
			$vmarca = ' AND (
			
				EXISTS (
					SELECT 
						pvv.PvvId
					FROM tblpvvproductovehiculoversion pvv
						LEFT JOIN tblvvevehiculoversion vve
						ON pvv.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
					WHERE vmo.VmaId = "'.$oVehiculoMarca.'"
					AND pvv.ProId = pro.ProId
				)
				OR pro.ProValidarUso = 2
			) ';
			
		}

		if(!empty($oReferencia)){
			$referencia = ' AND pro.ProReferencia LIKE "%'.$oReferencia.'%"';
		}

		if(!empty($oProducto)){
			$producto = ' AND pro.ProId = "'.$oProducto.'"';
		}
		
		if(!empty($oProductoCategoria)){
			$pcategoria = ' AND pro.PcaId = "'.$oProductoCategoria.'"';
		}
		
		
		if(!empty($oAlmacen)){
			$almacen = '

				(
				SELECT 
				SUM(apr.AprStockReal )
				FROM tblapralmacenproducto apr
					WHERE apr.ProId = pro.ProId
				AND apr.AlmId = "'.$oAlmacen.'"
				AND apr.AprAno = '.$oAno.'
				) AS AstStockReal,

			';	
		}else{
			/*$almacen = '
				pro.ProStockReal AS AstStockReal,
			';	*/
			
			
				if(!empty($oSucursal)){
					
					$almacen = '
						(
						SELECT 
						SUM(apr.AprStockReal )
						FROM tblapralmacenproducto apr
							LEFT JOIN tblalmalmacen alm
							ON apr.AlmId = alm.AlmId
		
						WHERE apr.ProId = pro.ProId
						AND alm.SucId = "'.$oSucursal.'"
						AND apr.AprAno =  '.$oAno.'
						) AS AstStockReal,
					';	
				}else{
					
					
					$almacen = '
						(
						SELECT 
						SUM(apr.AprStockReal)
						FROM tblapralmacenproducto apr
						
						WHERE apr.ProId = pro.ProId
						AND apr.AprAno =  '.$oAno.'
						) AS AstStockReal,
					';	
			
				}
				
				
			
			
		}
		
		
		if($oTieneMovimiento){
			
			
			$tmovimiento = ' AND (
			
				EXISTS (
					SELECT 
					amd2.AmdId
					FROM tblamdalmacenmovimientodetalle amd2
					
						LEFT JOIN tblamoalmacenmovimiento amo2
						ON amd2.AmoId = amo2.AmoId
						
					WHERE amd2.ProId = pro.ProId
					AND amo2.AlmId IS NOT NULL
					
					'.(!empty($oAlmacen)?' AND amo2.AlmId = "'.$oAlmacen.'"':'').'

				)
				
			) ';
			
		}
		
		
		
	//	if(!empty($oSucursal)){
//			
//			$sucursal = '
//
//				(
//				SELECT 
//				SUM(apr.AprStockReal )
//				FROM tblapralmacenproducto apr
//					LEFT JOIN tblalmalmacen alm
//					ON apr.AlmId = alm.AlmId
//						
//					WHERE apr.ProId = pro.ProId
//				AND alm.SucId = "'.$oSucursal.'"
//				AND apr.AprAno = YEAR(NOW())
//				) AS AstStockReal,
//
//			';	
//		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pro.ProId,
				0 AS AstStock,
				'.$almacen.'

				IF(pro.ProStockRealIngresado = 0, 0, ROUND( (pro.ProStockReal*100)/pro.ProStockRealIngresado,2)  ) AS AstStockPorcentaje,				
				pro.ProStockIngresado AS AstStockIngresado,
				pro.ProStockRealIngresado AS AstStockRealIngresado,
				pro.ProStockMinimo AS AstStockMinimo,
				pro.ProUbicacion AS AstUbicacion,
				pro.ProPromedioMensual AS AstPromedioMensual,
				1 AS AstEstado,
				pro.ProNombre,
				pro.ProCodigoOriginal,
				pro.ProCodigoAlternativo,
				pro.ProValidarUso,
				pro.ProStockVerificado,
				pro.ProReferencia,
				pro.ProUbicacion,
				pro.ProPromedioMensual,
				pro.ProPromedioDiario,
				pro.ProCosto,
				
				(
					SELECT 
						lpr.LprPrecio
					FROM tbllprlistaprecio lpr
					WHERE lpr.ProId = pro.ProId
					AND lpr.UmeId = pro.UmeId
					AND lpr.LtiId = "LTI-10011"
					LIMIT 1
				) AS ProListaPrecioPrecio,
				
				ume.UmeNombre,
				rti.RtiNombre,

				@Ingresos:=(
					SELECT 
					SUM(IFNULL(amd.AmdCantidad,0))
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							WHERE amo.AmoEstado = 3 
							AND amo.AmoTipo = 1
							AND amd.ProId = pro.ProId
							
						'.(!empty($oFechaInicio)?' AND DATE(amo.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo.AmoFecha) <= "'.$oFechaFin.'"':'').'
						
				) AS AstIngresos,
				
				@Salidas:=(
					SELECT 
					SUM(IFNULL(amd.AmdCantidad,0))
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							WHERE amo.AmoEstado = 3 
							AND amo.AmoTipo = 2
							AND amd.ProId = pro.ProId
							
						'.(!empty($oFechaInicio)?' AND DATE(amo.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo.AmoFecha) <= "'.$oFechaFin.'"':'').'
						
				) AS AstSalidas,
				
				(
					IFNULL(@Ingresos,0) - IFNULL(@Salidas,0)
				) AS AstStockCalculado,
				
				(
					SELECT 
					amd.AmdCosto
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							WHERE amd.AmdEstado = 3 
							AND amo.AmoTipo = 1
							AND amd.ProId = pro.ProId
							
						'.(!empty($oFechaInicio)?' AND DATE(amo.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo.AmoFecha) <= "'.$oFechaFin.'"':'').'
						
							ORDER BY amo.AmoFecha DESC
							LIMIT 1
				)	AS AstCostoCalculado,


				@IngresosReal:=(
					SELECT 
					SUM(IFNULL(amd.AmdCantidadReal,0))
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							WHERE amo.AmoEstado = 3 
							AND amo.AmoTipo = 1
							AND amd.ProId = pro.ProId
							
						'.(!empty($oFechaInicio)?' AND DATE(amo.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo.AmoFecha) <= "'.$oFechaFin.'"':'').'
						
				) AS AstIngresoReales,
				
				@SalidasReal:=(
					SELECT 
					SUM(IFNULL(amd.AmdCantidadReal,0))
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							WHERE amo.AmoEstado = 3 
							AND amo.AmoTipo = 2
							AND amd.ProId = pro.ProId
							
						'.(!empty($oFechaInicio)?' AND DATE(amo.AmoFecha) >= "'.$oFechaInicio.'"':'').'
						'.(!empty($oFechaFin)?' AND DATE(amo.AmoFecha) <= "'.$oFechaFin.'"':'').'
						
							
				) AS AstSalidaReales,

				(
				IFNULL(@IngresosReal,0) - IFNULL(@SalidasReal,0)
				) AS AstStockCalculadoReal,

				@ProductoPedido:=(
						SELECT 
						SUM( pcd.PcdCantidad )
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha > CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")
					
					) AS AstPedidoCantidad,
					
					
					@ProductoLlego:=(
					
						SELECT 
						SUM( amd.AmdCantidad )
						FROM  tblamdalmacenmovimientodetalle amd
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amd.AmoId = amo.AmoId
					
							LEFT JOIN  tblpcdpedidocompradetalle pcd
							ON amd.PcdId = pcd.PcdId
							
								LEFT JOIN tblpcopedidocompra pco
								ON pcd.PcoId = pco.PcoId
			
						WHERE pcd.ProId = pro.ProId
						
						AND amd.AmdEstado = 3
						AND amo.AmoTipo = 1
						AND amo.AmoFecha >  CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")
						AND pco.PcoFecha >  CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")
					
					) AS AstPedidoLLegoCantidad,
			
					(
						SELECT 
						DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y")
						
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha > CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")
						ORDER BY oco.OcoFecha DESC, oco.OcoTiempoCreacion DESC
						LIMIT 1
					) AS AstPedidoUltimaFecha,
					
					
					(
						SELECT 
					
						oco.OcoTipo					
						
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha >  CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")
						ORDER BY oco.OcoFecha DESC, oco.OcoTiempoCreacion DESC
						LIMIT 1
					) AS AstPedidoTipo,
					
					
					
					(
						SELECT 
					
						
						DATE_FORMAT(DATE_ADD(oco.OcoFechaLlegadaEstimada, INTERVAL 4 DAY), "%d/%m/%Y")
						
						FROM tblpcdpedidocompradetalle pcd
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
					
						WHERE pcd.ProId = pro.ProId
						AND pcd.PcdEstado = 3
						
						AND oco.OcoFecha >  CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")
						ORDER BY oco.OcoFecha DESC, oco.OcoTiempoCreacion DESC
						LIMIT 1
					) AS AstPedidoLlegadaEstimada,

										
					(
					
					IFNULL(@ProductoPedido,0) - IFNULL(@ProductoLlego,0)
					
					) AS AstPedidoPorLLegar,
					
					@ProductoVentaGeneral:=( SELECT IFNULL(SUM(vdd.VddCantidad) ,0) FROM tblvddventadirectadetalle vdd LEFT JOIN tblvdiventadirecta vdi ON vdd.VdiId = vdi.VdiId LEFT JOIN tblclicliente cli ON vdi.CliId = cli.CliId WHERE vdd.VddEstado = 1 	AND vdi.VdiFecha >  CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")	 AND vdd.ProId = pro.ProId AND cli.CliUso <> "CYC" ) AS AstVentaGeneral, 

					
					@ProductoVentaInterno:=( SELECT IFNULL( SUM(vdd.VddCantidad) ,0) FROM tblvddventadirectadetalle vdd LEFT JOIN tblvdiventadirecta vdi ON vdd.VdiId = vdi.VdiId LEFT JOIN tblclicliente cli ON vdi.CliId = cli.CliId WHERE vdd.VddEstado = 1	AND vdi.VdiFecha >  CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")	 AND vdd.ProId = pro.ProId AND cli.CliUso = "CYC" ) AS AstVentaInterno,
					
					
					@ProductoVentaAtendido:=( SELECT IFNULL( SUM(amd.AmdCantidad)  ,0) FROM tblvddventadirectadetalle vdd LEFT JOIN tblamdalmacenmovimientodetalle amd ON amd.VddId = vdd.VddId LEFT JOIN tblvdiventadirecta vdi ON vdd.VdiId = vdi.VdiId LEFT JOIN tblamoalmacenmovimiento amo ON amd.AmoId = amo.AmoId WHERE vdd.VddEstado = 1 AND amd.AmdEstado = 3 	AND vdi.VdiFecha >  CONCAT( YEAR( '.(!empty($oFechaInicio)?'"'.$oFechaInicio.'"':'NOW()').' ),"-01-01")	 AND vdd.ProId = pro.ProId AND amo.AmoTipo = 2 ) AS AstVentaAtendido, 
					
					( 
					
					IFNULL(@ProductoVentaGeneral,0) - IFNULL(@ProductoVentaInterno,0) 
					
					) AS AstVentaCliente,
					
					( 
					
					IF(@ProductoVentaGeneral=0, 0,  IFNULL(@ProductoVentaGeneral,0) - IFNULL(@ProductoVentaInterno,0) - IFNULL(@ProductoVentaAtendido,0) )
					
					) AS AstStockReservado

				FROM tblproproducto pro	
					LEFT  JOIN tblumeunidadmedida ume
					ON pro.UmeId = ume.UmeId
						LEFT JOIN tblrtiproductotipo rti
						ON pro.RtiId = rti.RtiId
					
				WHERE 1 = 1 '.$filtrar.$estado.$ptipo.$vmarca.$sucursal.$referencia.$tmovimiento.$pcategoria.$producto.$orden.$paginacion;

			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenStock = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenStock = new $InsAlmacenStock();				
                    //$AlmacenStock->AstId = $fila['AstId'];
                    $AlmacenStock->ProId= $fila['ProId'];
					$AlmacenStock->AstStock= $fila['AstStock'];
					$AlmacenStock->AstStockReal = $fila['AstStockReal'];
					
					$AlmacenStock->AstStockIngresado = $fila['AstStockIngresado'];
					$AlmacenStock->AstStockRealIngresado = $fila['AstStockRealIngresado'];
					$AlmacenStock->AstStockMinimo = $fila['AstStockMinimo'];
					$AlmacenStock->AstUbicacion = $fila['AstUbicacion'];
					$AlmacenStock->AstPromedioMensual = $fila['AstPromedioMensual'];
					
					$AlmacenStock->AstStockPorcentaje = $fila['AstStockPorcentaje'];
					$AlmacenStock->AstEstado = $fila['AstEstado'];
                    $AlmacenStock->ProNombre = $fila['ProNombre'];
					$AlmacenStock->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$AlmacenStock->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					$AlmacenStock->ProValidarUso = $fila['ProValidarUso'];
					$AlmacenStock->ProStockVerificado = $fila['ProStockVerificado'];
					$AlmacenStock->ProReferencia = $fila['ProReferencia'];
					$AlmacenStock->ProUbicacion = $fila['ProUbicacion'];
					$AlmacenStock->ProCosto = $fila['ProCosto'];

                    $AlmacenStock->UmeNombre = $fila['UmeNombre'];
					$AlmacenStock->RtiNombre = $fila['RtiNombre'];

					$AlmacenStock->AstIngresos = $fila['AstIngresos'];
					$AlmacenStock->AstSalidas = $fila['AstSalidas'];
					$AlmacenStock->AstStockCalculado = $fila['AstStockCalculado'];
					
					$AlmacenStock->AstCostoCalculado = $fila['AstCostoCalculado'];
					
					$AlmacenStock->AstIngresoReales = $fila['AstIngresoReales'];
					$AlmacenStock->AstSalidaReales = $fila['AstSalidaReales'];
					$AlmacenStock->AstStockCalculadoReal = $fila['AstStockCalculadoReal'];

					
					$AlmacenStock->AstPedidoCantidad = $fila['AstPedidoCantidad'];
					$AlmacenStock->AstPedidoLLegoCantidad = $fila['AstPedidoLLegoCantidad'];
					$AlmacenStock->AstPedidoUltimaFecha = $fila['AstPedidoUltimaFecha'];
					$AlmacenStock->AstPedidoTipo = $fila['AstPedidoTipo'];
					$AlmacenStock->AstPedidoLlegadaEstimada = $fila['AstPedidoLlegadaEstimada'];
					$AlmacenStock->AstPedidoPorLLegar = $fila['AstPedidoPorLLegar'];
					
					$AlmacenStock->AstStockReservado = $fila['AstStockReservado'];
					
					$AlmacenStock->ProPromedioMensual = $fila['ProPromedioMensual'];
					$AlmacenStock->ProPromedioDiario = $fila['ProPromedioDiario'];
					$AlmacenStock->ProListaPrecioPrecio = $fila['ProListaPrecioPrecio'];
					
                    $AlmacenStock->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenStock;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	
	
	public function MtdEditarAlmacenStockReal($oAlmacen,$oProducto,$oStock,$oAno) {
	
		global $Resultado;

		$sql = 'UPDATE tblapralmacenproducto SET 
		AprStockReal = '.$oStock.'
		
		WHERE AlmId = "'.($oAlmacen).'"
		AND  ProId = "'.($oProducto).'"
		AND AprAno = "'.$oAno.'"';
		
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 

		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						

	}	
	
	
	public function MtdEditarAlmacenStockRealIngresado($oAlmacen,$oProducto,$oStock,$oAno) {
	
		global $Resultado;

		$sql = 'UPDATE tblapralmacenproducto SET 
		AprStockRealIngresado = '.$oStock.'
		
		WHERE AlmId = "'.($oAlmacen).'"
		AND ProId = "'.($oAlmacen).'"
		AND AprAno = "'.$oAno.'"';
		
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 

		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						

	}	
	
	
}
?>