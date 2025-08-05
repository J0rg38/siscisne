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

class ClsReporteVentaPerdidaProducto {

    public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}


    public function MtdObtenerVentaPerdidaProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacion=NULL,$oEstado=NULL,$oProducto=NULL,$oSucursal=NULL) {

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
		
		if(!empty($oCotizacion)){
			$amovimiento = ' AND crd.CprId = "'.$oCotizacion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND crd.CrdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (crd.ProId = "'.$oProducto.'") ';
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (cpr.SucId = "'.$oSucursal.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			crd.CrdId,			
			crd.CprId,
			crd.ProId,
			crd.UmeId,
			
			crd.CrdCodigo,
			crd.CrdDescripcion,
			
			crd.CrdPorcentajeUtilidad,
			crd.CrdPorcentajeOtroCosto,
			crd.CrdPorcentajeManoObra,
			crd.CrdPorcentajePedido,
			
			crd.CrdPorcentajeAdicional,
			crd.CrdPorcentajeDescuento,
			
			crd.CrdCosto,
			
			crd.CrdPrecioBruto,
			(crd.CrdPrecioBruto*crd.CrdCantidad) AS CrdImporteBruto,
				
			crd.CrdDescuento,
			(crd.CrdDescuento/crd.CrdCantidad) AS CrdDescuentoUnitario,
				
			crd.CrdAdicional,
			(crd.CrdAdicional/crd.CrdCantidad) AS CrdAdicionalUnitario,
			
			crd.CrdPrecio,	
			(crd.CrdPrecio * ((crd.CrdDescuentoPorcentaje/100)+1)) AS CrdPrecioNeto,
			crd.CrdValorVenta,
			
			crd.CrdCantidad,
			crd.CrdCantidadReal,
			crd.CrdImporte,
			
			crd.CrdTipoPedido,
			crd.CrdEstado,
			
			DATE_FORMAT(crd.CrdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrdTiempoCreacion",
	        DATE_FORMAT(crd.CrdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCrdTiempoModificacion",
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			pro.ProStock,
			pro.ProStockReal,
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
			(
				SELECT 
				vdd.VddId 
				FROM tblvddventadirectadetalle vdd
				
					LEFT JOIN tblvdiventadirecta vdi
					ON vdd.VdiId = vdi.VdiId
						
				WHERE vdd.CrdId = crd.CrdId
					AND vdi.VdiEstado = 3
				LIMIT 1
			) AS VddId,

			@Cantidad:=(
				SELECT 
				SUM(vdd.VddCantidad)
				FROM tblvddventadirectadetalle vdd
				
					LEFT JOIN tblvdiventadirecta vdi
					ON vdd.VdiId = vdi.VdiId
						
				WHERE vdd.CrdId = crd.CrdId
					AND vdi.VdiEstado = 3
				LIMIT 1
			) AS VddCantidad ,
			
			(
			IFNULL(crd.CrdCantidad,0) - IFNULL(@Cantidad,0)
			) AS CrdCantidadPendiente,
			
			cpr.CprVentaPerdidaMotivo	,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
			
			ein.EinVIN,
			
			cpr.CprVIN,
			cpr.CprMarca,
			cpr.CprModelo,
			cpr.CprPlaca,
			cpr.CprAnoModelo	,
			
			suc.SucNombre,
			
			cpr.CprTipoCambio,
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha"
			
			FROM tblcrdcotizacionproductodetalle crd
			LEFT JOIN tblcprcotizacionproducto cpr
			ON crd.CprId = cpr.CprId
				LEFT JOIN tbleinvehiculoingreso ein
				ON cpr.EinId = ein.EinId
					LEFT JOIN tblvvevehiculoversion vve
					ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
							
				LEFT JOIN tblproproducto pro
				ON crd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON crd.UmeId = ume.UmeId
						LEFT JOIN tblsucsucursal suc
						ON cpr.SucId = suc.SucId
						
						
			WHERE cpr.CprVentaPerdida = 1 '.$amovimiento.$estado.	$sucursal.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionProductoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionProductoDetalle = new $InsCotizacionProductoDetalle();
                    $CotizacionProductoDetalle->CrdId = $fila['CrdId'];
                    $CotizacionProductoDetalle->CprId = $fila['CprId'];
					$CotizacionProductoDetalle->UmeId = $fila['UmeId'];

					$CotizacionProductoDetalle->CrdCodigo = $fila['CrdCodigo'];  
					$CotizacionProductoDetalle->CrdDescripcion = $fila['CrdDescripcion'];  
					
					$CotizacionProductoDetalle->CrdMargenPorcentaje = $fila['CrdMargenPorcentaje'];  
					$CotizacionProductoDetalle->CrdMantenimientoPorcentaje = $fila['CrdMantenimientoPorcentaje'];  
					$CotizacionProductoDetalle->CrdFletePorcentaje = $fila['CrdFletePorcentaje'];  
					$CotizacionProductoDetalle->CrdDescuentoPorcentaje = $fila['CrdDescuentoPorcentaje'];  
					
					$CotizacionProductoDetalle->CrdPorcentajeUtilidad = $fila['CrdPorcentajeUtilidad'];  
					$CotizacionProductoDetalle->CrdPorcentajeOtroCosto = $fila['CrdPorcentajeOtroCosto'];  
					$CotizacionProductoDetalle->CrdPorcentajeManoObra = $fila['CrdPorcentajeManoObra'];  
					$CotizacionProductoDetalle->CrdPorcentajePedido = $fila['CrdPorcentajePedido'];  
					
					$CotizacionProductoDetalle->CrdPorcentajeAdicional = $fila['CrdPorcentajeAdicional'];  
					$CotizacionProductoDetalle->CrdPorcentajeDescuento = $fila['CrdPorcentajeDescuento'];  

					$CotizacionProductoDetalle->CrdCosto = $fila['CrdCosto'];
					$CotizacionProductoDetalle->CrdPrecio = $fila['CrdPrecio'];
					$CotizacionProductoDetalle->CrdPrecioNeto = $fila['CrdPrecioNeto'];
					
					$CotizacionProductoDetalle->CrdPrecioBruto = $fila['CrdPrecioBruto'];
					$CotizacionProductoDetalle->CrdImporteBruto = $fila['CrdImporteBruto'];
					
					$CotizacionProductoDetalle->CrdDescuento = $fila['CrdDescuento'];
					$CotizacionProductoDetalle->CrdDescuentoUnitario = $fila['CrdDescuentoUnitario'];
					
					$CotizacionProductoDetalle->CrdAdicional = $fila['CrdAdicional'];
					$CotizacionProductoDetalle->CrdAdicionalUnitario = $fila['CrdAdicionalUnitario'];
					
					$CotizacionProductoDetalle->CrdPrecio = $fila['CrdPrecio'];
						
					$CotizacionProductoDetalle->CrdValorVenta = $fila['CrdValorVenta'];
					
			        $CotizacionProductoDetalle->CrdCantidad = $fila['CrdCantidad'];  
					$CotizacionProductoDetalle->CrdCantidadReal = $fila['CrdCantidadReal'];  
					$CotizacionProductoDetalle->CrdImporte = $fila['CrdImporte'];
					
					$CotizacionProductoDetalle->CrdTipoPedido = $fila['CrdTipoPedido'];
					$CotizacionProductoDetalle->CrdEstado = $fila['CrdEstado'];
					
					$CotizacionProductoDetalle->CrdTiempoCreacion = $fila['NCrdTiempoCreacion'];  
					$CotizacionProductoDetalle->CrdTiempoModificacion = $fila['NCrdTiempoModificacion']; 					
					$CotizacionProductoDetalle->ProId = $fila['ProId'];	
                    $CotizacionProductoDetalle->ProNombre = (($fila['ProNombre']));
					$CotizacionProductoDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$CotizacionProductoDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$CotizacionProductoDetalle->RtiId = (($fila['RtiId']));
					$CotizacionProductoDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$CotizacionProductoDetalle->ProStock = (($fila['ProStock']));
					$CotizacionProductoDetalle->ProStockReal = (($fila['ProStockReal']));
					
					$CotizacionProductoDetalle->UmeNombre = (($fila['UmeNombre']));
					$CotizacionProductoDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$CotizacionProductoDetalle->VddId = (($fila['VddId']));
					
					$CotizacionProductoDetalle->VddCantidad = (($fila['VddCantidad']));
					
					$CotizacionProductoDetalle->CrdCantidadPendiente = (($fila['CrdCantidadPendiente']));
				
					
					$CotizacionProductoDetalle->CprVentaPerdidaMotivo = (($fila['CprVentaPerdidaMotivo']));
					$CotizacionProductoDetalle->VmaNombre = (($fila['VmaNombre']));
					$CotizacionProductoDetalle->VmoNombre = (($fila['VmoNombre']));
					$CotizacionProductoDetalle->VveNombre = (($fila['VveNombre']));
					$CotizacionProductoDetalle->EinVIN = (($fila['EinVIN']));
					
					$CotizacionProductoDetalle->CprVIN = (($fila['CprVIN']));
					$CotizacionProductoDetalle->CprMarca = (($fila['CprMarca']));
					$CotizacionProductoDetalle->CprModelo = (($fila['CprModelo']));
					$CotizacionProductoDetalle->CprPlaca = (($fila['CprPlaca']));
					$CotizacionProductoDetalle->CprAnoModelo = (($fila['CprAnoModelo']));
					
					
			
					$CotizacionProductoDetalle->SucNombre = (($fila['SucNombre']));
					
					$CotizacionProductoDetalle->CprTipoCambio = (($fila['CprTipoCambio']));
					$CotizacionProductoDetalle->CprFecha = (($fila['NCprFecha']));
					
					
                    $CotizacionProductoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionProductoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	

}
?>