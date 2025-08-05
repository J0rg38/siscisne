<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPedidoCompraDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoCotizacionProductoSeguimiento {

	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdObtenerCotizacionProductoPedidos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false) {

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
		
		if(!empty($oPedidoCompra)){
			$amovimiento = ' AND pcd.PcoId = "'.$oPedidoCompra.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND pcd.PcdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (pcd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'" AND DATE('.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oFecha.')>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oOrdenCompra)){
			$ocompra = ' AND (pco.OcoId = "'.$oOrdenCompra.'") ';
		}

		
		
		
		if(!empty($oCliente)){
			$cliente = ' AND (pco.CliId = "'.$oCliente.'") ';
		}
		
		
				
			switch($oConOrdenCompra){
			
			case 1:
			
				$cocompra = ' AND pco.OcoId IS NOT NULL ';
				
			break;
			
			case 2:

				$cocompra = ' AND pco.OcoId IS NULL ';
				
			break;
			
			default:
			
			break;
		}
		
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetalle = ' AND (pcd.VddId = "'.$oVentaDirectaDetalleId.'") ';
		}
		
		
		if(!empty($oPedidoCompraEstado)){
			$pcestado = ' AND (pco.PcoEstado = '.$oPedidoCompraEstado.') ';
		}
		
		
		if(($oValidarRecibido)){
			$recibida = ' AND ( 
			
				IFNULL(pcd.PcdCantidad,0) - IFNULL(
				
				
				(SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amo.AmoEstado = 3
					AND amd.AmdEstado = 3
				LIMIT 1),0
				
				) 
				
			)  > 0  ';
		}
			
			
		if(($oConFichaIngreso)){
			$fingreso = ' AND EXISTS(
			
			SELECT  

			cpr.FinId

			FROM tblvdiventadirecta vdi
			
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
				
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE 
					pco.VdiId = vdi.VdiId					
					AND cpr.FinId IS NOT NULL
					
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			
			) ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pcd.PcdId,			
			pcd.PcoId,
			pcd.ProId,
			pcd.UmeId,
			pcd.VddId,
			
			pcd.PcdPrecio,
			pcd.PcdCantidad,
			
			pcd.PcdAno,
			pcd.PcdModelo,
			pcd.PcdCodigo,

			pcd.PcdImporte,
			
			DATE_FORMAT(pcd.PcdBOTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdBOTiempoCarga",
			DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y") AS "NPcdBOFecha",
			pcd.PcdBOEstado,
			
			DATE_FORMAT(pcd.PcdAPTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdAPTiempoCarga",
			pcd.PcdAPCantidad,
			
			DATE_FORMAT(pcd.PcdBSTiempoCarga, "%d/%m/%Y %H:%i:%s") AS "NPcdBSTiempoCarga",
			pcd.PcdBSCantidad,
			
			pcd.PcdEstado,
			DATE_FORMAT(pcd.PcdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoCreacion",
	        DATE_FORMAT(pcd.PcdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcdTiempoModificacion",
			
			
			DATE_FORMAT(pco.PcoFecha, "%d/%m/%Y") AS "NPcoFecha",
			
			cli.CliNombreCompleto,			
			cli.CliNumeroDocumento,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,

			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			ume.UmeNombre,

			pro.UmeId AS "UmeIdOrigen",
			
			pco.OcoId,
			DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
			DATEDIFF(DATE(NOW()),oco.OcoFecha) AS OcoDiaTranscurrido,
			oco.OcoTipo,			
			DATE_FORMAT(oco.OcoFechaLlegadaEstimada, "%d/%m/%Y") AS "NOcoFechaLlegadaEstimada",
			
			pco.VdiId,
			pco.PcoTipoCambio,
			
			DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
			
			vdi.CprId,			
			vdi.VdiOrdenCompraNumero,
			
			cpr.FinId,
			
			ein.EinVIN,
			
			vve.VveNombre,
			vmo.VmoNombre,
			vma.VmaNombre,
			
			amo.AmoId,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			
			(SELECT 
				(ple.PleId)
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1				
			) AS PleId,
			
			(SELECT 
				DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1				
			) AS PleFecha
			
			
			
					
			FROM tblpcdpedidocompradetalle pcd
			
				LEFT JOIN tblpcopedidocompra pco
				ON pcd.PcoId = pco.PcoId
					
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
						
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
					
					LEFT JOIN tblvdiventadirecta vdi
					ON pco.VdiId = vdi.VdiId
						
						LEFT JOIN tblcprcotizacionproducto cpr
						ON vdi.CprId = cpr.CprId
							
							LEFT JOIN tblfinfichaingreso fin
							ON cpr.FinId = fin.FinId
								
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
								
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId 
										
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
											
											LEFT JOIN tblvmavehiculomarca vma
											ON vmo.VmaId = vma.VmaId
											
											
										
						
							LEFT JOIN tblclicliente cli
							ON cpr.CliId = cli.CliId
								
								LEFT JOIN tblocoordencompra oco
								ON pco.OcoId = oco.OcoId
							
									LEFT JOIN tblproproducto pro
									ON pcd.ProId = pro.ProId
									
										LEFT JOIN tblumeunidadmedida ume
										ON pcd.UmeId = ume.UmeId

			WHERE cpr.FinId IS NOT NULL
		
			AND NOT EXISTS(

				SELECT 
				fim.FimId 
				FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = cpr.FinId 
				AND fim.MinId <> "MIN-10002"

			)
			'.$amovimiento.$estado.$producto.$filtrar.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$recibida.$fingreso.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPedidoCompraDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PedidoCompraDetalle = new $InsPedidoCompraDetalle();
                    $PedidoCompraDetalle->PcdId = $fila['PcdId'];
                    $PedidoCompraDetalle->PcoId = $fila['PcoId'];
					$PedidoCompraDetalle->ProId = $fila['ProId'];
					
					$PedidoCompraDetalle->UmeId = $fila['UmeId'];
					$PedidoCompraDetalle->VddId = $fila['VddId'];
					
					$PedidoCompraDetalle->PcdAno = $fila['PcdAno'];  
					$PedidoCompraDetalle->PcdModelo = $fila['PcdModelo'];  
					$PedidoCompraDetalle->PcdCodigo = $fila['PcdCodigo'];  
			
					$PedidoCompraDetalle->PcdPrecio = $fila['PcdPrecio'];  
			        $PedidoCompraDetalle->PcdCantidad = $fila['PcdCantidad'];  
					$PedidoCompraDetalle->PcdImporte = $fila['PcdImporte'];

					$PedidoCompraDetalle->PcdBOTiempoCarga = $fila['NPcdBOTiempoCarga'];
					$PedidoCompraDetalle->PcdBOFecha = $fila['NPcdBOFecha'];
					$PedidoCompraDetalle->PcdBOEstado = $fila['PcdBOEstado'];
					
					
					$PedidoCompraDetalle->PcdAPTiempoCarga = $fila['NPcdAPTiempoCarga'];
					$PedidoCompraDetalle->PcdAPCantidad = $fila['PcdAPCantidad'];
					
					$PedidoCompraDetalle->PcdBSTiempoCarga = $fila['NPcdBSTiempoCarga'];
					$PedidoCompraDetalle->PcdBSCantidad = $fila['PcdBSCantidad'];
										
					$PedidoCompraDetalle->PcdEstado = $fila['PcdEstado'];
														
					$PedidoCompraDetalle->PcdTiempoCreacion = $fila['NPcdTiempoCreacion'];  
					$PedidoCompraDetalle->PcdTiempoModificacion = $fila['NPcdTiempoModificacion']; 	
					
					$PedidoCompraDetalle->PcoFecha = $fila['NPcoFecha']; 
						
					$PedidoCompraDetalle->CliNombreCompleto = $fila['CliNombreCompleto']; 	
					$PedidoCompraDetalle->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$PedidoCompraDetalle->CliNombre = $fila['CliNombre']; 	
					$PedidoCompraDetalle->CliApellidoPaterno = $fila['CliApellidoPaterno']; 	
					$PedidoCompraDetalle->CliApellidoMaterno = $fila['CliApellidoMaterno']; 	
					
							
					$PedidoCompraDetalle->ProId = $fila['ProId'];	
                    $PedidoCompraDetalle->ProNombre = (($fila['ProNombre']));
					$PedidoCompraDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$PedidoCompraDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$PedidoCompraDetalle->RtiId = (($fila['RtiId']));
					
					$PedidoCompraDetalle->UmeNombre = (($fila['UmeNombre']));
					
					$PedidoCompraDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$PedidoCompraDetalle->OcoId = (($fila['OcoId']));
					$PedidoCompraDetalle->OcoFecha = (($fila['NOcoFecha']));
					
					$PedidoCompraDetalle->OcoDiaTranscurrido = (($fila['OcoDiaTranscurrido']));
					$PedidoCompraDetalle->OcoTipo = (($fila['OcoTipo']));
					
					$PedidoCompraDetalle->OcoFechaLlegadaEstimada = (($fila['NOcoFechaLlegadaEstimada']));
					
					$PedidoCompraDetalle->VdiId = (($fila['VdiId']));
					$PedidoCompraDetalle->PcoTipoCambio = (($fila['PcoTipoCambio']));
					
					$PedidoCompraDetalle->CprId = (($fila['CprId']));
					$PedidoCompraDetalle->CprFecha = (($fila['NCprFecha']));
					
					$PedidoCompraDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
						$PedidoCompraDetalle->FinId = (($fila['FinId']));
						
					$PedidoCompraDetalle->EinVIN = (($fila['EinVIN']));
					
					$PedidoCompraDetalle->VveNombre = (($fila['VveNombre']));
					$PedidoCompraDetalle->VmoNombre = (($fila['VmoNombre']));
					$PedidoCompraDetalle->VmaNombre = (($fila['VmaNombre']));
					
					$PedidoCompraDetalle->AmoId = (($fila['AmoId']));
					$PedidoCompraDetalle->AmoComprobanteFecha = (($fila['NAmoComprobanteFecha']));
				
					
					$PedidoCompraDetalle->PleId = (($fila['PleId']));
					$PedidoCompraDetalle->PleFecha = (($fila['PleFecha']));
										
				
				
				     $PedidoCompraDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
		public function MtdObtenerCotizacionProductoNoPedidos2($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacion=NULL,$oEstado=NULL,$oProducto=NULL) {

		
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
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			crd.CrdId,			
			crd.CprId,
			crd.ProId,
			crd.UmeId,
			
			crd.CrdCodigo,
			crd.CrdDescripcion,
			

			crd.CrdCosto,
			crd.CrdPrecio,
			
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
			
				cpr.FinId,
			
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre
			
					
			
			FROM tblcrdcotizacionproductodetalle crd
			
				LEFT JOIN tblcprcotizacionproducto cpr
				ON crd.CprId = cpr.CprId
					
					LEFT JOIN tblclicliente cli
					ON cpr.CliId = cli.CliId
				
						LEFT JOIN tblfinfichaingreso fin
						ON cpr.FinId = fin.FinId
						
					LEFT JOIN tblproproducto pro
					ON crd.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON crd.UmeId = ume.UmeId
							
							LEFT JOIN tblvddventadirectadetalle vdd
							ON vdd.CrdId = crd.CrdId
								
								LEFT JOIN tblpcdpedidocompradetalle pcd
								ON pcd.VddId = vdd.VddId
								
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
									
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
										
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
												LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId
			WHERE 
			
			cpr.FinId IS NOT NULL
		
			AND NOT EXISTS(

				SELECT 
				fim.FimId 
				FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = cpr.FinId 
				AND fim.MinId <> "MIN-10002"

			)
			
			AND vdd.VddId IS NULL
			AND pcd.PcdId IS NULL

			
			'.$amovimiento.$estado.$producto.$filtrar.$orden.$paginacion;	
		
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
			
					$CotizacionProductoDetalle->CrdCosto = $fila['CrdCosto'];
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
					
					$CotizacionProductoDetalle->FinId = (($fila['FinId']));
					
					$CotizacionProductoDetalle->CprFecha = (($fila['NCprFecha']));
					$CotizacionProductoDetalle->CliNombre = (($fila['CliNombre']));
					$CotizacionProductoDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
					$CotizacionProductoDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
					
					$CotizacionProductoDetalle->VmaNombre = (($fila['VmaNombre']));
					$CotizacionProductoDetalle->VmoNombre = (($fila['VmoNombre']));
					$CotizacionProductoDetalle->VveNombre = (($fila['VveNombre']));
			
                    $CotizacionProductoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionProductoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;	
		
		
		
			
		}
		
		
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function MtdObtenerCotizacionProductoNoPedidos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'CprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oFichaIngreso=NULL,$oVehiculoIngreso=NULL,$oPersonal=NULL,$oCliente=NULL) {

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
					crd.CrdId
					FROM tblcrdcotizacionproductodetalle crd
						LEFT JOIN tblproproducto pro
						ON crd.ProId = pro.ProId
						
					WHERE 
						crd.CprId = cpr.CprId AND
						(
						crd.CrdDescripcion LIKE "%'.$oFiltro.'%" OR
						pro.ProNombre LIKE "%'.$oFiltro.'%" OR
						crd.CrdCodigo  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoOriginal  LIKE "%'.$oFiltro.'%" OR
						pro.ProCodigoAlternativo  LIKE "%'.$oFiltro.'%" 
						
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
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'" AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cpr.CprFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cpr.CprFecha)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oEstado)){
			$estado = ' AND cpr.CprEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND cpr.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND cpr.FinId = "'.$oFichaIngreso.'"';
		}
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND cpr.EinId = "'.$oVehiculoIngreso.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND cpr.PerId = "'.$oPersonal.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND cpr.CliId = "'.$oCliente.'"';
		}
				

		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cpr.CprId,	
				
				cpr.CliId,
				cpr.LtiId,
				
				cpr.CliIdSeguro,
				
				DATE_FORMAT(cpr.CprFecha, "%d/%m/%Y") AS "NCprFecha",
				
				cpr.EinId,
				cpr.PerId,
				cpr.FinId,
				
				cpr.CprMarca,
				cpr.CprModelo,
				cpr.CprPlaca,
				cpr.CprAnoModelo,
				
				cpr.MonId,
				cpr.CprTipoCambio,
				
				cpr.CprIncluyeImpuesto,
				cpr.CprPorcentajeImpuestoVenta,
				cpr.CprMargenUtilidad,
				
				cpr.CprObservacion,

				cpr.CprTelefono,
				cpr.CprDireccion,
				cpr.CprEmail,
				cpr.CprRepresentante,
				cpr.CprAsegurado,
				
				cpr.CprManoObra,
				cpr.CprPorcentajeDescuento,
				cpr.CprVigencia,
				cpr.CprTiempoEntrega,
				DATE_FORMAT(adddate(cpr.CprFecha,cpr.CprTiempoEntrega), "%d/%m/%Y") AS CprFechaEntrega,
			
				cpr.CprPlanchadoTotal,
				cpr.CprPintadoTotal,
				cpr.CprProductoTotal,
					
				cpr.CprDescuento,
				cpr.CprSubTotal,
				cpr.CprImpuesto,				
				cpr.CprTotal,
				
				cpr.CprFirmaDigital,
				cpr.CprVerificar,
				
				cpr.CprNotificar,
				cpr.CprEstado,
				DATE_FORMAT(cpr.CprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoCreacion",
	        	DATE_FORMAT(cpr.CprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCprTiempoModificacion",
				
				(SELECT COUNT(crd.CrdId) FROM tblcrdcotizacionproductodetalle crd WHERE crd.CprId = cpr.CprId ) AS "CprTotalItems",
		
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				
				cli.CliNombre,
				cli.CliNumeroDocumento,
				tdo.TdoNombre,
				lti.LtiNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				ein.EinVIN,
				ein.EinPlaca,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno
				
				FROM tblcprcotizacionproducto cpr
					LEFT JOIN tblclicliente cli
					ON cpr.CliId = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbllticlientetipo lti
							ON cpr.LtiId = lti.LtiId
							
							LEFT JOIN tblclicliente seg
								ON cpr.CliIdSeguro = seg.CliId
						
						
								LEFT JOIN tblmonmoneda mon
								ON cpr.MonId = mon.MonId
									LEFT JOIN	tbleinvehiculoingreso ein
									ON cpr.EinId = ein.EinId
								
										LEFT JOIN tblvmavehiculomarca vma
										ON ein.VmaId = vma.VmaId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON ein.VmoId = vmo.VmoId
												LEFT JOIN tblvvevehiculoversion vve
												ON ein.VveId = vve.VveId
												
												
													LEFT JOIN tblperpersonal per
													ON cpr.PerId = per.PerId
									
				WHERE  cpr.FinId IS NOT NULL 
				
				
			AND NOT EXISTS(

				SELECT 
				fim.FimId 
				FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = cpr.FinId 
				AND fim.MinId <> "MIN-10002"

			)
			
		
			AND NOT EXISTS(

 SELECT vdd.CrdId 
FROM tblvddventadirectadetalle vdd
LEFT JOIN tblcrdcotizacionproductodetalle crd
ON vdd.CrdId =crd.CrdId
WHERE crd.CprId = cpr.CprId

 ) 


			
				
				'.$filtrar.$fecha.$tipo.$stipo.$estado.$moneda.$fingreso.$vingreso.$cliente .$tfingreso .$personal.$orden.$paginacion;	/*AND NOT EXISTS(
				SELECT vdd.CrdId 
				
				FROM tblcrdcotizacionproductodetalle crd
					
					LEFT JOIN tblvddventadirectadetalle vdd

				WHERE crd.CprId = cpr.CprId
				
						ON vdd.CrdId = crd.CrdId
						)*/
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionProducto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionProducto = new $InsCotizacionProducto();
                    $CotizacionProducto->CprId = $fila['CprId'];
					
					
					$CotizacionProducto->CliId = $fila['CliId'];
					$CotizacionProducto->LtiId = $fila['LtiId'];
					$CotizacionProducto->CprFecha = $fila['NCprFecha'];
					
					$CotizacionProducto->EinId = $fila['EinId'];
					$CotizacionProducto->PerId = $fila['PerId'];
					$CotizacionProducto->FinId = $fila['FinId'];
					
					$CotizacionProducto->CprMarca = $fila['CprMarca'];
					$CotizacionProducto->CprModelo = $fila['CprModelo'];
					$CotizacionProducto->CprPlaca = $fila['CprPlaca'];
					$CotizacionProducto->CprAnoModelo = $fila['CprAnoModelo'];
					
					$CotizacionProducto->MonId = $fila['MonId'];
					$CotizacionProducto->CprTipoCambio = $fila['CprTipoCambio'];
					
					$CotizacionProducto->CprIncluyeImpuesto = $fila['CprIncluyeImpuesto'];
					$CotizacionProducto->CprPorcentajeImpuestoVenta = $fila['CprPorcentajeImpuestoVenta'];
					$CotizacionProducto->CprMargenUtilidad = $fila['CprMargenUtilidad'];				
					$CotizacionProducto->CprObservacion = $fila['CprObservacion'];
					
					$CotizacionProducto->CprTelefono = $fila['CprTelefono'];
					$CotizacionProducto->CprDireccion = $fila['CprDireccion'];
					$CotizacionProducto->CprEmail = $fila['CprEmail'];
					$CotizacionProducto->CprRepresentante = $fila['CprRepresentante'];
					$CotizacionProducto->CprAsegurado = $fila['CprAsegurado'];



					$CotizacionProducto->CprManoObra = $fila['CprManoObra'];
					$CotizacionProducto->CprPorcentajeDescuento = $fila['CprPorcentajeDescuento'];							
					$CotizacionProducto->CprVigencia = $fila['CprVigencia'];
					$CotizacionProducto->CprTiempoEntrega = $fila['CprTiempoEntrega'];
					$CotizacionProducto->CprFechaEntrega = $fila['CprFechaEntrega'];
				
					$CotizacionProducto->CprPlanchadoTotal = $fila['CprPlanchadoTotal'];
					$CotizacionProducto->CprPintadoTotal = $fila['CprPintadoTotal'];
					$CotizacionProducto->CprProductoTotal = $fila['CprProductoTotal'];
					
					$CotizacionProducto->CprDescuento = $fila['CprDescuento'];
					$CotizacionProducto->CprSubTotal = $fila['CprSubTotal'];			
					$CotizacionProducto->CprImpuesto = $fila['CprImpuesto'];
					$CotizacionProducto->CprTotal = $fila['CprTotal'];

					$CotizacionProducto->CprFirmaDigital = $fila['CprFirmaDigital'];
					$CotizacionProducto->CprVerificar = $fila['CprVerificar'];
				
				
				
					$CotizacionProducto->CprNotificar = $fila['CprNotificar'];
					$CotizacionProducto->CprEstado = $fila['CprEstado'];
					$CotizacionProducto->CprTiempoCreacion = $fila['NCprTiempoCreacion'];  
					$CotizacionProducto->CprTiempoModificacion = $fila['NCprTiempoModificacion']; 
					$CotizacionProducto->CprTotalItems = $fila['CprTotalItems'];
					
					$CotizacionProducto->CprRepuesto = $fila['CprRepuesto'];
					$CotizacionProducto->CprRepuestoVerificado = $fila['CprRepuestoVerificado'];
					$CotizacionProducto->CprPlanchado = $fila['CprPlanchado'];
					$CotizacionProducto->CprPlanchadoVerificado = $fila['CprPlanchadoVerificado'];
					$CotizacionProducto->CprPintado = $fila['CprPintado'];
					$CotizacionProducto->CprPintadoVerificado = $fila['CprPintadoVerificado'];
					$CotizacionProducto->CprCentrado = $fila['CprCentrado'];
					$CotizacionProducto->CprCentradoVerificado = $fila['CprCentradoVerificado'];
					$CotizacionProducto->CprTarea = $fila['CprTarea'];
					$CotizacionProducto->CprTareaVerificado = $fila['CprTareaVerificado'];
					
					$CotizacionProducto->CprVentaDirecta = $fila['CprVentaDirecta'];
					
					$CotizacionProducto->VdiGenerarVentaDirecta = $fila['VdiGenerarVentaDirecta'];

				
					$CotizacionProducto->TdoId = $fila['TdoId']; 
					$CotizacionProducto->CliNombre = $fila['CliNombre']; 
					$CotizacionProducto->CliNumeroDocumento = $fila['CliNumeroDocumento']; 

					$CotizacionProducto->TdoNombre = $fila['TdoNombre']; 
					$CotizacionProducto->LtiNombre = $fila['LtiNombre']; 

					$CotizacionProducto->MonSimbolo = $fila['MonSimbolo']; 
					$CotizacionProducto->MonNombre = $fila['MonNombre']; 

					$CotizacionProducto->EinVIN = $fila['EinVIN'];
					$CotizacionProducto->EinPlaca = $fila['EinPlaca'];
					
					$CotizacionProducto->VmaNombre = $fila['VmaNombre'];
					$CotizacionProducto->VmoNombre = $fila['VmoNombre'];
					$CotizacionProducto->VveNombre = $fila['VveNombre'];
					
					$CotizacionProducto->PerNombre = $fila['PerNombre'];
					$CotizacionProducto->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$CotizacionProducto->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$CotizacionProducto->CliNombreSeguro = $fila['CliNombreSeguro'];
					$CotizacionProducto->CliApellidoPaternoSeguro = $fila['CliApellidoPaternoSeguro'];
					$CotizacionProducto->CliApellidoMaternoSeguro = $fila['CliApellidoMaternoSeguro'];
	
					switch($CotizacionProducto->CprEstado){
						
					  case 1:
						  $Estado = "Emitido";
					  break;
					  
					  case 2:
						  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Enviado]";
					  break;
				  
					  case 3:
						  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisando]";
					  break;	
					  
					  case 4:
						  $Estado = "<img src='imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Por Facturar]";
					  break;

					  
					  case 5:
						  $Estado = "<img src='imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";
					  break;
					  
					   case 6:
				 		 $Estado = "<img src='imagenes/iconos/anulado.png' alt='ANULADO' border='0' width='20' height='20' title='ANULADO' > [Anulado]";
					  break;

					  default:
						  $Estado = "";
					  break;					
	
					}
					$CotizacionProducto->CprEstadoDescripcion = $Estado;
				
				
                    $CotizacionProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
}
?>