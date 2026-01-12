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

class ClsReporteVentaDirecta
{

	public $InsMysql;


	public function __construct($oInsMysql = NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}
	}

	public function __destruct() {}

	public function MtdObtenerReporteVentaDirectas($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'ProId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFecha = NULL, $oCliente = NULL, $oPedidoCompra = NULL)
	{

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fecha = '';
		$cliente = '';
		$pedidoCompra = '';

		if (!empty($oCampo) and !empty($oFiltro)) {

			$oFiltro = str_replace(" ", "%", $oFiltro);

			$elementos = explode(",", $oCampo);

			$i = 1;
			$filtrar .= '  AND (';
			foreach ($elementos as $elemento) {
				if (!empty($elemento)) {
					if ($i == count($elementos)) {

						$filtrar .= ' (';
						switch ($oCondicion) {

							case "esigual":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '"';
								break;

							case "noesigual":
								$filtrar .= '  ' . ($elemento) . ' <> "' . ($oFiltro) . '"';
								break;

							case "comienza":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;

							case "termina":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '"';
								break;

							case "contiene":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '%"';
								break;

							case "nocontiene":
								$filtrar .= '  ' . ($elemento) . ' NOT LIKE "%' . ($oFiltro) . '%"';
								break;

							default:
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;
						}

						$filtrar .= ' )';
					} else {


						$filtrar .= ' (';
						switch ($oCondicion) {

							case "esigual":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '"';
								break;

							case "noesigual":
								$filtrar .= '  ' . ($elemento) . ' <> "' . ($oFiltro) . '"';
								break;

							case "comienza":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;

							case "termina":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '"';
								break;

							case "contiene":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '%"';
								break;

							case "nocontiene":
								$filtrar .= '  ' . ($elemento) . ' NOT LIKE "%' . ($oFiltro) . '%"';
								break;

							default:
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;
						}

						$filtrar .= ' ) OR';
					}
				}
				$i++;
			}

			$filtrar .= '  ) ';
		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}


		if (!empty($oCliente)) {
			$cliente = ' AND vdi.CliId = "' . $oCliente . '" ';
		}


		if (!empty($oPedidoCompra)) {

			$pcompra = ' 
			AND EXISTS(
				SELECT 
				pco.PcoId 
				FROM tblpcopedidocompra pco
					WHERE pco.VdiId = vdi.VdiId
					AND pco.PcoId = "' . $oPedidoCompra . '"
				LIMIT 1
			)';
		}

		$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					vdd.VddId,
					vdd.VdiId,
					
					DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",
					vdi.VdiOrdenCompraNumero,
					DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
					
					pro.ProCodigoOriginal,
					pro.ProNombre,
					cli.CliNombre
							
					FROM tblvddventadirectadetalle vdd
					
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
							LEFT JOIN tblclicliente cli
							ON vdi.CliId = cli.CliId	
								LEFT JOIN tblproproducto pro
								ON vdd.ProId = pro.ProId
									
				WHERE 1 = 1 ' . $filtrar . $fecha . $cliente . $pcompra . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsReporteVentaDirectaDespacho = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteVentaDirectaDespacho = new $InsReporteVentaDirectaDespacho();


			$ReporteVentaDirectaDespacho->VddId = $fila['VddId'];
			$ReporteVentaDirectaDespacho->VdiId = $fila['VdiId'];
			$ReporteVentaDirectaDespacho->VdiFecha = $fila['NVdiFecha'];
			$ReporteVentaDirectaDespacho->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
			$ReporteVentaDirectaDespacho->VdiOrdenCompraFecha = $fila['NVdiOrdenCompraFecha'];
			$ReporteVentaDirectaDespacho->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$ReporteVentaDirectaDespacho->ProNombre = $fila['ProNombre'];
			$ReporteVentaDirectaDespacho->CliNombre = $fila['CliNombre'];
			$ReporteVentaDirectaDespacho->RvdDespacho = $fila['RvdDespacho'];

			$ReporteVentaDirectaDespacho->OcoId = $fila['OcoId'];

			$ReporteVentaDirectaDespacho->InsMysql = NULL;
			$Respuesta['Datos'][] = $ReporteVentaDirectaDespacho;
		}



		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}


	public function MtdObtenerReporteVentaDirectaDespachos2($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'ProId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oProductoTipo = NULL, $oConVentaDirecta = 0, $oConFichaIngreso = 0)
	{

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$productoTipo = '';
		$conVentaDirecta = '';
		$conFichaIngreso = '';

		if (!empty($oCampo) and !empty($oFiltro)) {

			$oFiltro = str_replace(" ", "%", $oFiltro);

			$elementos = explode(",", $oCampo);

			$i = 1;
			$filtrar .= '  AND (';
			foreach ($elementos as $elemento) {
				if (!empty($elemento)) {
					if ($i == count($elementos)) {

						$filtrar .= ' (';
						switch ($oCondicion) {

							case "esigual":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '"';
								break;

							case "noesigual":
								$filtrar .= '  ' . ($elemento) . ' <> "' . ($oFiltro) . '"';
								break;

							case "comienza":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;

							case "termina":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '"';
								break;

							case "contiene":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '%"';
								break;

							case "nocontiene":
								$filtrar .= '  ' . ($elemento) . ' NOT LIKE "%' . ($oFiltro) . '%"';
								break;

							default:
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;
						}

						$filtrar .= ' )';
					} else {


						$filtrar .= ' (';
						switch ($oCondicion) {

							case "esigual":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '"';
								break;

							case "noesigual":
								$filtrar .= '  ' . ($elemento) . ' <> "' . ($oFiltro) . '"';
								break;

							case "comienza":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;

							case "termina":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '"';
								break;

							case "contiene":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '%"';
								break;

							case "nocontiene":
								$filtrar .= '  ' . ($elemento) . ' NOT LIKE "%' . ($oFiltro) . '%"';
								break;

							default:
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;
						}

						$filtrar .= ' ) OR';
					}
				}
				$i++;
			}

			$filtrar .= '  ) ';
		}




		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}



		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(amo.AmoFecha)>="' . $oFechaInicio . '" AND DATE(amo.AmoFecha)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(amo.AmoFecha)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(amo.AmoFecha)<="' . $oFechaFin . '"';
			}
		}


		if (!empty($oProductoTipo)) {
			$ptipo = ' AND pro.RtiId = "' . $oProductoTipo . '"';
		}



		if (!empty($oConVentaDirecta)) {
			$cvdirecta = ' AND amo.VdiId IS NOT NULL';
		}


		if (!empty($oConFichaIngreso)) {
			$cfingreso = ' AND amo.FccId IS NOT NULL';
		}


		$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					pro.ProId,
					pro.ProCodigoOriginal,
					pro.ProNombre,
					
					IFNULL(amo.VdiId,SUM(amd.AmdCantidad)) AS VdpVentaDirecta,
					
					SUM(amd.AmdCantidad) AS VdpCantidad,
					
					ume.UmeNombre,
					rti.RtiNombre
				
					FROM tblamdalmacenmovimientodetalle amd
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
						
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
							
							LEFT JOIN tblrtiproductotipo rti
							ON pro.RtiId = rti.RtiId
									
				WHERE amo.AmoEstado = 3 AND amo.AmoTipo = 2 ' . $filtrar . $fecha . $ptipo . $cvdirecta . $cfingreso . " GROUP BY amd.ProId " . $orden . " " . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsReporteVentaDirectaDespacho = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteVentaDirectaDespacho = new $InsReporteVentaDirectaDespacho();
			$ReporteVentaDirectaDespacho->ProId = $fila['ProId'];
			$ReporteVentaDirectaDespacho->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$ReporteVentaDirectaDespacho->ProNombre = $fila['ProNombre'];

			$ReporteVentaDirectaDespacho->VdpCantidad = $fila['VdpCantidad'];

			$ReporteVentaDirectaDespacho->UmeNombre = $fila['UmeNombre'];
			$ReporteVentaDirectaDespacho->RtiNombre = $fila['RtiNombre'];

			$ReporteVentaDirectaDespacho->InsMysql = NULL;
			$Respuesta['Datos'][] = $ReporteVentaDirectaDespacho;
		}



		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}



	public function MtdObtenerVentaDirectaDetalles($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'VddId', $oSentido = 'Desc', $oPaginacion = '0,10', $oVentaDirecta = NULL, $oEstado = NULL, $oProducto = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oMoneda = NULL, $oCliente = NULL, $oConOrdenCompraReferencia = NULL, $oConDespacho = NULL, $oConPendiente = false, $oPersonal = NULL)
	{

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$ventadirecta = '';
		$estado = '';
		$producto = '';
		$fechainicio = '';
		$fechafin = '';
		$moneda = '';
		$cliente = '';
		$conordencomprareferencia = '';
		$condespacho = '';
		$conpendiente = '';
		$personal = '';

		if (!empty($oCampo) and !empty($oFiltro)) {

			$oFiltro = str_replace(" ", "%", $oFiltro);
			$elementos = explode(",", $oCampo);

			$i = 1;
			$filtrar .= '  AND (';
			foreach ($elementos as $elemento) {
				if (!empty($elemento)) {
					if ($i == count($elementos)) {

						$filtrar .= ' (';
						switch ($oCondicion) {

							case "esigual":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '"';
								break;

							case "noesigual":
								$filtrar .= '  ' . ($elemento) . ' <> "' . ($oFiltro) . '"';
								break;

							case "comienza":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;

							case "termina":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '"';
								break;

							case "contiene":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '%"';
								break;

							case "nocontiene":
								$filtrar .= '  ' . ($elemento) . ' NOT LIKE "%' . ($oFiltro) . '%"';
								break;

							default:
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;
						}

						$filtrar .= ' )';
					} else {

						$filtrar .= ' (';
						switch ($oCondicion) {

							case "esigual":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '"';
								break;

							case "noesigual":
								$filtrar .= '  ' . ($elemento) . ' <> "' . ($oFiltro) . '"';
								break;

							case "comienza":
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;

							case "termina":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '"';
								break;

							case "contiene":
								$filtrar .= '  ' . ($elemento) . ' LIKE "%' . ($oFiltro) . '%"';
								break;

							case "nocontiene":
								$filtrar .= '  ' . ($elemento) . ' NOT LIKE "%' . ($oFiltro) . '%"';
								break;

							default:
								$filtrar .= '  ' . ($elemento) . ' LIKE "' . ($oFiltro) . '%"';
								break;
						}

						$filtrar .= ' ) OR';
					}
				}
				$i++;
			}

			$filtrar .= '  ) ';
		}




		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oVentaDirecta)) {
			$amovimiento = ' AND vdd.VdiId = "' . $oVentaDirecta . '"';
		}

		if (!empty($oEstado)) {
			$estado = ' AND vdd.VddEstado = ' . $oEstado . ' ';
		}

		if (!empty($oProducto)) {
			$producto = ' AND (vdd.ProId = "' . $oProducto . '") ';
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(vdi.VdiFecha)>="' . $oFechaInicio . '" AND DATE(vdi.VdiFecha)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(vdi.VdiFecha)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(vdi.VdiFecha)<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND vdi.MonId = "' . $oMoneda . '"';
		}


		if (!empty($oCliente)) {
			$cliente = ' AND vdi.CliId = "' . $oCliente . '"';
		}


		switch ($oConOrdenCompraReferencia) {

			case 1:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NOT NULL AND vdi.VdiOrdenCompraNumero <> "") ';
				break;

			case 2:
				$coreferencia = ' AND (vdi.VdiOrdenCompraNumero IS NULL OR vdi.VdiOrdenCompraNumero = "") ';
				break;

			default:

				break;
		}


		switch ($oConDespacho) {

			case 1:
				$cdespacho = ' AND EXISTS (
				
				SELECT 
				(pld.PldId)
				FROM tblpldpedidocomprallegadadetalle pld
						
						LEFT JOIN tblplepedidocomprallegada ple
						ON pld.PleId = ple.PleId
						
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pld.PcdId = pcd.PcdId
					
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
						
					WHERE 
						pco.PcoEstado = 3
					AND pcd.VddId = vdd.VddId
					LIMIT 1	
				
				) ';
				break;

			case 2:
				$cdespacho = ' AND NOT EXISTS (
						
						SELECT 
				(pld.PldId)
				FROM tblpldpedidocomprallegadadetalle pld
						
						LEFT JOIN tblplepedidocomprallegada ple
						ON pld.PleId = ple.PleId
						
						LEFT JOIN tblpcdpedidocompradetalle pcd
						ON pld.PcdId = pcd.PcdId
					
							LEFT JOIN tblpcopedidocompra pco
							ON pcd.PcoId = pco.PcoId
						
					WHERE 
						pco.PcoEstado = 3
					AND pcd.VddId = vdd.VddId
					LIMIT 1	
					
				) ';
				break;

			default:

				break;
		}


		if (($oConPendiente)) {

			$cpendiente = ' AND 
			
			IFNULL((

				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			),0) < vdd.VddCantidad 
			
			';
		}

		if (!empty($oPersonal)) {
			$personal = ' AND vdi.PerId = "' . $oPersonal . '"';
		}


		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vdd.VddId,			
			vdd.VdiId,
			vdd.ProId,
			vdd.UmeId,
			vdd.CrdId,

			vdd.VddCantidad,
			vdd.VddCosto,
			vdd.VddValorTotal,
			vdd.VddUtilidad,
			
			vdd.VddPrecioBruto,
			vdd.VddDescuento,
			vdd.VddPrecioVenta,

			vdd.VddImporte,
			vdd.VddCodigoExterno,
			
			vdd.VddCantidadPedir,
			DATE_FORMAT(vdd.VddCantidadPedirFecha, "%d/%m/%Y") AS "NVddCantidadPedirFecha",
			
			vdd.VddPorcentajeUtilidad,
			vdd.VddPorcentajeOtroCosto,
			vdd.VddPorcentajeManoObra,
			vdd.VddPorcentajePedido,
			
			vdd.VddPorcentajeAdicional,
			vdd.VddPorcentajeDescuento,
			
			(vdd.VddPrecioBruto*vdd.VddCantidad) AS VddImporteBruto,
			(vdd.VddDescuento/vdd.VddCantidad) AS VddDescuentoUnitario,
			
			vdd.VddAdicional,
			
			vdd.VddTipoPedido,
			vdd.VddNota,
			vdd.VddEstado,
			DATE_FORMAT(vdd.VddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoCreacion",
	        DATE_FORMAT(vdd.VddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVddTiempoModificacion",
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
	        DATE_FORMAT(vdi.VdiFecha, "%d/%m/%Y") AS "NVdiFecha",

			ein.VveId,

			(
				SELECT 
				pcd.PcdId 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdId,
			

			(
				SELECT 
				pcd.PcdBOEstado 
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOEstado,
			
			(
				SELECT 
				DATE_FORMAT(pcd.PcdBOFecha, "%d/%m/%Y")
				FROM tblpcdpedidocompradetalle pcd
				WHERE pcd.VddId = vdd.VddId
				LIMIT 1
			) AS PcdBOFecha,

			(
				SELECT 
				amd.AmdId 
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amo.AmoEstado = 3
				LIMIT 1
			) AS AmdId,



			@ProIdPedido:=(
				SELECT 
				amd.ProId
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
					
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProIdPedido,

			@ProCodigoOriginalPedido:=(
				SELECT 
				pro.ProCodigoOriginal
				FROM tblpcdpedidocompradetalle pcd
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON amd.PcdId = pcd.PcdId
						LEFT JOIN tblproproducto pro
						ON amd.ProId = pro.ProId
						
					WHERE pcd.VddId = vdd.VddId
					
				LIMIT 1
			) AS ProCodigoOriginalPedido,

			IF(IFNULL(@ProIdPedido,vdd.ProId)<>vdd.ProId,"Si","No") AS VddReemplazo,


			@AmdCantidad:=(

				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
				
					LEFT JOIN tblamoalmacenmovimiento amo
					ON amd.AmoId = amo.AmoId
						
				WHERE amd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidad,
			
			@AmdCantidadEntrada:=(
			
				SELECT 
				SUM(amd.AmdCantidad)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId
					AND amd.AmdEstado = 3
				LIMIT 1

			) AS AmdCantidadEntrada,
			
			
			@PcdCantidad:=(
			
				SELECT 
				SUM(pcd.PcdCantidad)
				FROM tblpcdpedidocompradetalle pcd
				
					LEFT JOIN tblpcopedidocompra pco
					ON pcd.PcoId = pco.PcoId
						
				WHERE pcd.VddId = vdd.VddId
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)
					AND pcd.PcdEstado <> 10
				LIMIT 1

			) AS PcdCantidad,


			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0) - IFNULL(@PcdCantidad,0) 				
			) AS VddCantidadPendiente,
		
			(
			IFNULL(vdd.VddCantidad,0) - IFNULL(@AmdCantidad,0)
			) AS VddCantidadPendiente2,
			

			
			(SELECT 
			SUM(amd.AmdCantidad)
			FROM tblamdalmacenmovimientodetalle amd

				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
			
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE amo.AmoTipo = 1
					AND amd.AmdEstado = 3
					AND (pco.PcoEstado = 3 OR pco.PcoEstado = 31)

				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadLlegada,
			
			
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					ple.PleEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegar,
			
		
			(
			SELECT 
			SUM(pld.PldCantidad)
			FROM tblpldpedidocomprallegadadetalle pld
						
				LEFT JOIN tblplepedidocomprallegada ple
				ON pld.PleId  = ple.PleId

					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId

				WHERE 
					pld.PldEstado = 3
				AND pcd.VddId = vdd.VddId
				
			) AS VddCantidadPorLlegarReal,
		
		
			(SELECT 
			DATE_FORMAT(ple.PleFecha, "%d/%m/%Y")
			FROM tblpldpedidocomprallegadadetalle pld
					
					LEFT JOIN tblplepedidocomprallegada ple
					ON pld.PleId = ple.PleId
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON pld.PcdId = pcd.PcdId
				
						LEFT JOIN tblpcopedidocompra pco
						ON pcd.PcoId = pco.PcoId
					
				WHERE 
					pco.PcoEstado = 3
				AND pcd.VddId = vdd.VddId
				LIMIT 1					
			) AS VddFechaPorLlegar,
			
			
			(
				SELECT 
				(amd.AmdEstado)
				FROM tblamdalmacenmovimientodetalle amd
					
					LEFT JOIN tblpcdpedidocompradetalle pcd
					ON amd.PcdId = pcd.PcdId
					
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId

				WHERE pcd.VddId = vdd.VddId

					AND amo.AmoEstado = 3
					ORDER BY amd.AmdTiempoCreacion DESC
				LIMIT 1

			) AS AmdEstado,
			
			
			cli.CliNombreCompleto,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliNumeroDocumento,

			cli.CliDireccion,
			cli.CliDepartamento,
			cli.CliProvincia,
			cli.CliDistrito,
		  
			cli.CliTelefono,
			cli.CliCelular,
			cli.CliEmail,
			
			cli.TdoId,
			tdo.TdoNombre,
			
			mon.MonNombre,
			mon.MonSimbolo,
			
			vdi.VdiTipoCambio,
			vdi.VdiTotal,
			DATE_FORMAT(vdi.VdiOrdenCompraFecha, "%d/%m/%Y") AS "NVdiOrdenCompraFecha",
			vdi.VdiOrdenCompraNumero,
			
			lti.LtiNombre,
			lti.LtiAbreviatura,
			
			vdi.VdiIncluyeImpuesto,
			vdi.VdiTipoPedido,
			
			pro.ProUbicacion,
			suc.SucNombre

			FROM tblvddventadirectadetalle vdd
				LEFT JOIN tblproproducto pro
				ON vdd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON vdd.UmeId = ume.UmeId				
						LEFT JOIN tblvdiventadirecta vdi
						ON vdd.VdiId = vdi.VdiId
								LEFT JOIN tbleinvehiculoingreso ein
								ON vdi.EinId = ein.EinId								
								LEFT JOIN tblclicliente cli
								ON vdi.CliId = cli.CliId								
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId									
									LEFT JOIN tbltdotipodocumento tdo
									ON cli.TdoId = tdo.TdoId									
										LEFT JOIN tblmonmoneda mon
										ON vdi.MonId = mon.MonId
											LEFT JOIN tblsucsucursal suc
											ON vdi.SucId = suc.SucId
								
			WHERE  1 = 1 ' . $amovimiento . $estado . $producto . $fecha . $cpendiente . $moneda . $cliente . $coreferencia . $cdespacho . $filtrar . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsVentaDirectaDetalle = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$VentaDirectaDetalle = new $InsVentaDirectaDetalle();
			$VentaDirectaDetalle->VddId = $fila['VddId'];
			$VentaDirectaDetalle->VdiId = $fila['VdiId'];
			$VentaDirectaDetalle->UmeId = $fila['UmeId'];
			$VentaDirectaDetalle->CrdId = $fila['CrdId'];

			$VentaDirectaDetalle->VddCantidad = $fila['VddCantidad'];
			$VentaDirectaDetalle->VddCosto = $fila['VddCosto'];
			$VentaDirectaDetalle->VddValorTotal = $fila['VddValorTotal'];
			$VentaDirectaDetalle->VddUtilidad = $fila['VddUtilidad'];

			$VentaDirectaDetalle->VddPrecioBruto = $fila['VddPrecioBruto'];
			$VentaDirectaDetalle->VddDescuento = $fila['VddDescuento'];
			$VentaDirectaDetalle->VddPrecioVenta = $fila['VddPrecioVenta'];

			$VentaDirectaDetalle->VddImporte = $fila['VddImporte'];
			$VentaDirectaDetalle->VddCodigoExterno = $fila['VddCodigoExterno'];

			$VentaDirectaDetalle->VddCantidadPedir = $fila['VddCantidadPedir'];
			$VentaDirectaDetalle->VddCantidadPedirFecha = $fila['NVddCantidadPedirFecha'];


			$VentaDirectaDetalle->VddEstado = $fila['VddEstado'];
			$VentaDirectaDetalle->VddTiempoCreacion = $fila['NVddTiempoCreacion'];
			$VentaDirectaDetalle->VddTiempoModificacion = $fila['NVddTiempoModificacion'];
			$VentaDirectaDetalle->ProId = $fila['ProId'];
			$VentaDirectaDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
			$VentaDirectaDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
			$VentaDirectaDetalle->ProNombre = (($fila['ProNombre']));
			$VentaDirectaDetalle->RtiId = (($fila['RtiId']));
			$VentaDirectaDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));

			$VentaDirectaDetalle->UmeNombre = (($fila['UmeNombre']));

			$VentaDirectaDetalle->VdiFecha = (($fila['NVdiFecha']));

			$VentaDirectaDetalle->VveId = (($fila['VveId']));




			$VentaDirectaDetalle->PcdId = (($fila['PcdId']));

			$VentaDirectaDetalle->PcdBOEstado = (($fila['PcdBOEstado']));
			$VentaDirectaDetalle->PcdBOFecha = (($fila['PcdBOFecha']));



			$VentaDirectaDetalle->PcdCantidad = (($fila['PcdCantidad']));

			$VentaDirectaDetalle->ProIdPedido = (($fila['ProIdPedido']));
			$VentaDirectaDetalle->ProCodigoOriginalPedido = (($fila['ProCodigoOriginalPedido']));
			$VentaDirectaDetalle->VddReemplazo = (($fila['VddReemplazo']));
			//deb($VentaDirectaDetalle->VddReemplazo);

			$VentaDirectaDetalle->AmdId = (($fila['AmdId']));
			$VentaDirectaDetalle->AmdCantidad = (($fila['AmdCantidad']));
			$VentaDirectaDetalle->AmdCantidadEntrada = (($fila['AmdCantidadEntrada']));


			$VentaDirectaDetalle->VddCantidadPendiente = (($fila['VddCantidadPendiente']));
			$VentaDirectaDetalle->VddCantidadPendiente2 = (($fila['VddCantidadPendiente2']));
			//$VentaDirectaDetalle->VddCantidadConcretar = (($fila['VddCantidadConcretar']));
			$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));

			$VentaDirectaDetalle->VddCantidadLlegada = (($fila['VddCantidadLlegada']));
			$VentaDirectaDetalle->VddCantidadPorLlegar = (($fila['VddCantidadPorLlegar']));
			$VentaDirectaDetalle->VddCantidadPorLlegarReal = (($fila['VddCantidadPorLlegarReal']));

			$VentaDirectaDetalle->VddFechaPorLlegar = (($fila['VddFechaPorLlegar']));
			$VentaDirectaDetalle->AmdEstado = (($fila['AmdEstado']));

			$VentaDirectaDetalle->CliNombreCompleto = (($fila['CliNombreCompleto']));
			$VentaDirectaDetalle->CliNombre = (($fila['CliNombre']));
			$VentaDirectaDetalle->CliApellidoPaterno = (($fila['CliApellidoPaterno']));
			$VentaDirectaDetalle->CliApellidoMaterno = (($fila['CliApellidoMaterno']));
			$VentaDirectaDetalle->CliNumeroDocumento = (($fila['CliNumeroDocumento']));

			$VentaDirectaDetalle->CliDireccion = (($fila['CliDireccion']));
			$VentaDirectaDetalle->CliDepartamento = (($fila['CliDepartamento']));
			$VentaDirectaDetalle->CliProvincia = (($fila['CliProvincia']));
			$VentaDirectaDetalle->CliDistrito = (($fila['CliDistrito']));

			$VentaDirectaDetalle->CliTelefono = (($fila['CliTelefono']));
			$VentaDirectaDetalle->CliCelular = (($fila['CliCelular']));
			$VentaDirectaDetalle->CliEmail = (($fila['CliEmail']));



			$VentaDirectaDetalle->TdoId = (($fila['TdoId']));
			$VentaDirectaDetalle->TdoNombre = (($fila['TdoNombre']));

			$VentaDirectaDetalle->MonNombre = (($fila['MonNombre']));
			$VentaDirectaDetalle->MonSimbolo = (($fila['MonSimbolo']));

			$VentaDirectaDetalle->VdiTipoCambio = (($fila['VdiTipoCambio']));
			$VentaDirectaDetalle->VdiTotal = (($fila['VdiTotal']));

			$VentaDirectaDetalle->VdiOrdenCompraFecha = (($fila['NVdiOrdenCompraFecha']));
			$VentaDirectaDetalle->VdiOrdenCompraNumero = (($fila['VdiOrdenCompraNumero']));


			$VentaDirectaDetalle->LtiNombre = (($fila['LtiNombre']));
			$VentaDirectaDetalle->LtiAbreviatura = (($fila['LtiAbreviatura']));

			$VentaDirectaDetalle->VdiIncluyeImpuesto = (($fila['VdiIncluyeImpuesto']));
			$VentaDirectaDetalle->VdiTipoPedido = (($fila['VdiTipoPedido']));

			$VentaDirectaDetalle->ProUbicacion = (($fila['ProUbicacion']));
			$VentaDirectaDetalle->SucNombre = (($fila['SucNombre']));

			$VentaDirectaDetalle->InsMysql = NULL;
			$Respuesta['Datos'][] = $VentaDirectaDetalle;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}
}
