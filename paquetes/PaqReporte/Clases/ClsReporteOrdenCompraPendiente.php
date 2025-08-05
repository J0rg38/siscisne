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

class ClsReporteOrdenCompraPendiente extends ClsPedidoCompraDetalle {


    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

    
	 public function MtdObtenerReporteOrdenCompraPendientes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oProveedor=NULL,$oDiaTranscurrido=NULL,$oVentaDirectaDetalleEstado=NULL) {

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

					WHERE pco.VdiId = vdi.VdiId AND cpr.FinId IS NOT NULL
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			
			) ';
		}
		
		if(!empty($oProveedor)){
			$proveedor = ' AND (oco.PrvId = "'.$oProveedor.'" ) ';
		}
		
		
		if(!empty($oDiaTranscurrido)){
			$dtranscurrido = ' AND (@DiaTranscurrido > '.$oDiaTranscurrido.' ) ';
		}
		
		if(!empty($oVentaDirectaDetalleEstado)){
			$vddestado = ' AND (@VddEstado = '.$oVentaDirectaDetalleEstado.' ) ';
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
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,

			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			ume.UmeNombre,

			pro.UmeId AS "UmeIdOrigen",

			@AmdCantidad:=(
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amo.AmoEstado = 3
				LIMIT 1
			) AS AmdCantidad,
			
			
			
			@PldCantidad:=(
				SELECT 
				SUM(pld.PldCantidad)
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1
			) AS PldCantidad,

			
			(SELECT 
				DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1				
			) AS PleFecha,
			
			
			(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidad,0)
			) AS PcdCantidadPendiente,

			
			(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PldCantidad,0)
			) AS PcdCantidadPendienteLlegada,
			
			
			
			
			@AmdCantidadReal:=(
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amo.AmoEstado = 3
					AND amd.AmdEstado = 3
				LIMIT 1
			),
			
			
			@PcdCantidadNoRecibida:=(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidadReal,0)
			) AS PcdCantidadNoRecibida,

			@VddEstado:=(
				SELECT 
				vdd.VddEstado
				FROM tblvddventadirectadetalle vdd
				WHERE pcd.VddId = vdd.VddId
				ORDER BY vdd.VddTiempoCreacion DESC
				LIMIT 1
			) AS VddEstado,
			
			


			pco.OcoId,
			DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
			
			@DiaTranscurrido:=DATEDIFF(DATE(NOW()),oco.OcoFecha) AS OcoDiaTranscurrido,
			
			DATE_FORMAT(oco.OcoFechaLlegadaEstimada, "%d/%m/%Y") AS "NOcoFechaLlegadaEstimada",
			
			pco.VdiId,
			pco.PcoTipoCambio,
			
			vdi.VdiOrdenCompraNumero,
			
			(
			SELECT  

			cpr.FinId

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS FinId,
			
			
			(
			SELECT  

			DATE_FORMAT(fin.FinFecha, "%d/%m/%Y")

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS FinFecha
			
			
			FROM tblpcdpedidocompradetalle pcd
			
				LEFT JOIN tblpcopedidocompra pco
				ON pcd.PcoId = pco.PcoId
					
					LEFT JOIN tblvdiventadirecta vdi
					ON pco.VdiId = vdi.VdiId
				
					LEFT JOIN tblocoordencompra oco
					ON pco.OcoId = oco.OcoId
					
					LEFT JOIN tblclicliente cli
					ON pco.CliId = cli.CliId
					
					LEFT JOIN tblproproducto pro
					ON pcd.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON pcd.UmeId = ume.UmeId

			WHERE  @VddEstado = 1 '.$amovimiento.$estado.$producto.$filtrar.$vddestado.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$recibida.$dtranscurrido.$fingreso.$orden.$paginacion;	
		
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
					
					
					
					
					
					$PedidoCompraDetalle->PcoTipoCambio = $fila['PcoTipoCambio'];
					
					$PedidoCompraDetalle->AmdCantidad = (($fila['AmdCantidad']));
					
					$PedidoCompraDetalle->PldCantidad = (($fila['PldCantidad']));
					$PedidoCompraDetalle->PleFecha = (($fila['PleFecha']));

					//$PedidoCompraDetalle->PcdCantidadPorLlegar = (($fila['PcdCantidadPorLlegar']));
					
					$PedidoCompraDetalle->PcdCantidadPendiente = (($fila['PcdCantidadPendiente']));
					
					$PedidoCompraDetalle->PcdCantidadPendienteLlegada = (($fila['PcdCantidadPendienteLlegada']));
					
					$PedidoCompraDetalle->PcdCantidadNoRecibida = (($fila['PcdCantidadNoRecibida']));
					
					$PedidoCompraDetalle->VddEstado = (($fila['VddEstado']));
					
					$PedidoCompraDetalle->OcoId = (($fila['OcoId']));
					$PedidoCompraDetalle->OcoFecha = (($fila['NOcoFecha']));
					
					$PedidoCompraDetalle->OcoDiaTranscurrido = (($fila['OcoDiaTranscurrido']));
					$PedidoCompraDetalle->OcoFechaLlegadaEstimada = (($fila['NOcoFechaLlegadaEstimada']));
					
					$PedidoCompraDetalle->VdiId = (($fila['VdiId']));
					$PedidoCompraDetalle->PcoTipoCambio = (($fila['PcoTipoCambio']));
					
					$PedidoCompraDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));
					
					
					$PedidoCompraDetalle->FinId = (($fila['FinId']));
					$PedidoCompraDetalle->FinFecha = (($fila['FinFecha']));
				
				
				
				
				
				     $PedidoCompraDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	
	
	
	
	
	
    public function MtdObtenerOrdenCompraDetallePendiente($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPedidoCompra=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oOrdenCompra=NULL,$oCliente=NULL,$oConOrdenCompra=NULL,$oVentaDirectaDetalleId=NULL,$oPedidoCompraEstado=NULL,$oFecha="PcoFecha",$oValidarRecibido=false,$oConFichaIngreso=false,$oOrdenCompraEstado=NULL,$oAno=NULL,$oMes=NULL,$oProveedor=NULL) {

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

					WHERE pco.VdiId = vdi.VdiId AND cpr.FinId IS NOT NULL
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			
			) ';
		}
		
		
			if(!empty($oOrdenCompraEstado)){
			$ocestado = ' AND (oco.OcoEstado = '.$oOrdenCompraEstado.') ';
		}
		
		if(!empty($oProveedor)){
			$proveedor = ' AND (oco.PrvId = "'.$oProveedor.'") ';
		}
		
			if(!empty($oAno)){
				$ano = ' AND YEAR(pco.PcoFecha) = "'.$oAno.'"';		
			}			
		
			if(!empty($oMes)){
				$mes = ' AND MONTH(pco.PcoFecha) = "'.$oMes.'"';		
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
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			pro.ProTieneDisponibilidadGM,
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			ume.UmeNombre,

			pro.UmeId AS "UmeIdOrigen",


			@AmdCantidad:=(
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amd.AmdEstado = 3
				LIMIT 1
			) AS AmdCantidad,
			

			@NodCantidad:=(
				SELECT 
				  SUM(nod.NodCantidad)
				  FROM tblnodnotacreditocompradetalle nod

					  LEFT JOIN tblamdalmacenmovimientodetalle amd
					  ON nod.AmdId = amd.AmdId

						  LEFT JOIN tblnccnotacreditocompra ncc
						  ON nod.NccId = ncc.NccId

				  WHERE amd.PcdId = pcd.PcdId
					  AND amd.AmdEstado = 3
					  AND nod.NodEstado = 3
				  LIMIT 1
			) AS NodCantidad,

						
			
			@PldCantidad:=(
				SELECT 
				SUM(pld.PldCantidad)
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1
			) AS PldCantidad,

			
			(SELECT 
				DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
				FROM tblpldpedidocomprallegadadetalle pld
				
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
						
				WHERE pld.PldId = pld.PldId
					AND pld.PcdId = pcd.PcdId
					AND ple.PleEstado = 3
				LIMIT 1				
			) AS PleFecha,
			
			
			(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidad,0)  + IFNULL(@NodCantidad,0)
			) AS PcdCantidadPendiente,

			
			(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PldCantidad,0)
			) AS PcdCantidadPendienteLlegada,
			
			
			
			
			@AmdCantidadReal:=(
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.PcdId = pcd.PcdId
					AND amo.AmoEstado = 3
					AND amd.AmdEstado = 3
				LIMIT 1
			),
			
			
			@PcdCantidadNoRecibida:=(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidadReal,0)
			) AS PcdCantidadNoRecibida,
			
			@PcdCantidadNoDespachada:=(
				IFNULL(pcd.PcdCantidad,0) - IFNULL(@AmdCantidadReal,0) - IFNULL(@PldCantidad,0)
			) AS PcdCantidadNoDespachada,

			(
				SELECT 
				vdd.VddEstado
				FROM tblvddventadirectadetalle vdd
				WHERE pcd.VddId = vdd.VddId
				ORDER BY vdd.VddTiempoCreacion DESC
				LIMIT 1
			) AS VddEstado,
			
			


			pco.OcoId,
			DATE_FORMAT(oco.OcoFecha, "%d/%m/%Y") AS "NOcoFecha",
			DATEDIFF(DATE(NOW()),oco.OcoFecha) AS OcoDiaTranscurrido,
			
			DATE_FORMAT(oco.OcoFechaLlegadaEstimada, "%d/%m/%Y") AS "NOcoFechaLlegadaEstimada",
			
			pco.VdiId,
			pco.PcoTipoCambio,
			
			vdi.VdiOrdenCompraNumero,
			
			(
			SELECT  

			cpr.FinId

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS FinId,
			
			
			(
			SELECT  

			DATE_FORMAT(fin.FinFecha, "%d/%m/%Y")

			FROM tblvdiventadirecta vdi
				LEFT JOIN tblcprcotizacionproducto cpr
				ON vdi.CprId = cpr.CprId
					LEFT JOIN tblfinfichaingreso fin
					ON cpr.FinId = fin.FinId

					WHERE pco.VdiId = vdi.VdiId		
			ORDER BY fin.FinTiempoCreacion DESC
			LIMIT 1	
			) AS FinFecha,
			
			(
			SELECT 
			ple.PleFecha
			FROM tblpldpedidocomprallegadadetalle pld
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId = ple.PleId
			WHERE pld.PcdId = pcd.PcdId
			LIMIT 1
			) AS PleFecha,
			
			(
			SELECT 
			pld.PldComprobanteNumero			
			FROM tblpldpedidocomprallegadadetalle pld
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId = ple.PleId
			WHERE pld.PcdId = pcd.PcdId
			LIMIT 1
			) AS PldComprobanteNumero

			FROM tblpcdpedidocompradetalle pcd
			
				LEFT JOIN tblpcopedidocompra pco
				ON pcd.PcoId = pco.PcoId
					
					LEFT JOIN tblvdiventadirecta vdi
					ON pco.VdiId = vdi.VdiId
				
					LEFT JOIN tblocoordencompra oco
					ON pco.OcoId = oco.OcoId
					
					LEFT JOIN tblclicliente cli
					ON pco.CliId = cli.CliId
					
					LEFT JOIN tblproproducto pro
					ON pcd.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON pcd.UmeId = ume.UmeId

			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$proveedor.$fecha.$ano.$mes.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$recibida.$fingreso.$ocestado.$orden.$paginacion;	
		
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
					
					$PedidoCompraDetalle->CliNombre = $fila['CliNombre']; 	
					$PedidoCompraDetalle->CliApellidoPaterno = $fila['CliApellidoPaterno']; 	
					$PedidoCompraDetalle->CliApellidoMaterno = $fila['CliApellidoMaterno']; 	
					
							
					$PedidoCompraDetalle->ProTieneDisponibilidadGM = $fila['ProTieneDisponibilidadGM'];
					$PedidoCompraDetalle->ProId = $fila['ProId'];	
                    $PedidoCompraDetalle->ProNombre = (($fila['ProNombre']));
					$PedidoCompraDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$PedidoCompraDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$PedidoCompraDetalle->RtiId = (($fila['RtiId']));
					
					$PedidoCompraDetalle->UmeNombre = (($fila['UmeNombre']));
					$PedidoCompraDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					
					
					
					
					$PedidoCompraDetalle->PcoTipoCambio = $fila['PcoTipoCambio'];
					
					$PedidoCompraDetalle->AmdCantidad = (($fila['AmdCantidad']));
					$PedidoCompraDetalle->NodCantidad = (($fila['NodCantidad']));
					
					$PedidoCompraDetalle->PldCantidad = (($fila['PldCantidad']));
					$PedidoCompraDetalle->PleFecha = (($fila['PleFecha']));

					//$PedidoCompraDetalle->PcdCantidadPorLlegar = (($fila['PcdCantidadPorLlegar']));
					
					$PedidoCompraDetalle->PcdCantidadPendiente = (($fila['PcdCantidadPendiente']));
					
					$PedidoCompraDetalle->PcdCantidadPendienteLlegada = (($fila['PcdCantidadPendienteLlegada']));
					
					$PedidoCompraDetalle->PcdCantidadNoRecibida = (($fila['PcdCantidadNoRecibida']));
					
					$PedidoCompraDetalle->PcdCantidadNoDespachada = (($fila['PcdCantidadNoDespachada']));
					
					$PedidoCompraDetalle->VddEstado = (($fila['VddEstado']));
					
					$PedidoCompraDetalle->OcoId = (($fila['OcoId']));
					$PedidoCompraDetalle->OcoFecha = (($fila['NOcoFecha']));
					
					$PedidoCompraDetalle->OcoDiaTranscurrido = (($fila['OcoDiaTranscurrido']));
					$PedidoCompraDetalle->OcoFechaLlegadaEstimada = (($fila['NOcoFechaLlegadaEstimada']));
					
					$PedidoCompraDetalle->VdiId = (($fila['VdiId']));
					$PedidoCompraDetalle->PcoTipoCambio = (($fila['PcoTipoCambio']));
					
					$PedidoCompraDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));

					$PedidoCompraDetalle->FinId = (($fila['FinId']));
					$PedidoCompraDetalle->FinFecha = (($fila['FinFecha']));
					
					$PedidoCompraDetalle->PleFecha = (($fila['PleFecha']));
					$PedidoCompraDetalle->PldComprobanteNumero = (($fila['PldComprobanteNumero']));
				
					$PedidoCompraDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PedidoCompraDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
			

}
?>