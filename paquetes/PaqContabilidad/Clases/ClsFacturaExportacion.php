<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFacturaExportacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFacturaExportacion
{

	public $FexId;
	public $FetId;
	public $UsuId;

	public $CliId;

	public $NpaId;

	public $AmoId;


	public $MonId;
	public $FexTipoCambio;

	public $FexCancelado;

	public $FexCantidadDia;
	public $FexObsequio;
	public $FexEstado;
	public $FexFechaEmision;
	public $FexPorcentajeImpuestoVenta;
	public $FexDireccion;

	public $FexTotalBruto;
	public $FexDescuento;
	public $FexTotal;
	public $FexTotalReal;

	public $FexObservacion;
	public $FexObservacionImpresa;
	public $FexCierre;



	public $FexTiempoCreacion;
	public $FexTiempoModificacion;
	public $FexEliminado;

	public $FexTotalItems;
	public $FacturaExportacionDetalle;


	public $NpaNombre;

	public $FetNumero;


	public $CliNombre;
	public $TdoId;
	public $CliNumeroDocumento;
	public $CliTelefono;
	public $CliEmail;
	public $CliCelular;
	public $CliFax;

	public $FinVehiculoKilometraje;

	public $CliDepartamento;
	public $CliProvincia;
	public $CliDistrito;

	public $MonNombre;
	public $MonSimbolo;

	public $FinId;
	public $CprId;


	public $EinVIN;
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $EinAnoFabricacion;
	public $EinPlaca;
	public $VehColor;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;

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

	public function MtdGenerarFacturaExportacionId()
	{

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(fex.FexId,5),unsigned)) AS "MAXIMO",
		fet.FetInicio
		FROM tblfexfacturaexportacion fex 
		LEFT JOIN tblfetfacturaexportaciontalonario fet
		ON fex.FetId = fet.FetId 
		WHERE fet.FetId = "' . $this->FetId . '"';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			if (empty($fila['FetInicio'])) {
				$this->FexId = "0000001";
			} else {
				$this->FexId = str_pad($fila['FetInicio'], 7, "0", STR_PAD_LEFT);
			}
		} else {
			$fila['MAXIMO']++;
			$this->FexId = str_pad($fila['MAXIMO'], 7, "0", STR_PAD_LEFT);
		}
	}

	public function MtdObtenerFacturaExportacion($oCompleto = true)
	{


		$sql = 'SELECT 
				fex.FexId,
				fex.FetId,
				fex.UsuId,
				fex.CliId,
				
				fex.NpaId,
				
				fex.AmoId,
							
				
				DATE_FORMAT(fex.FexFechaEmision, "%d/%m/%Y") AS "NFexFechaEmision",
				fex.FexPorcentajeImpuestoVenta,
				fex.FexDireccion,

				IF(fex.FexEstado=6,0.00,fex.FexSubTotal) AS "FexSubTotal",	
				IF(fex.FexEstado=6,0.00,fex.FexImpuesto) AS "FexImpuesto",
				IF(fex.FexEstado=6,0.00,fex.FexTotal) AS "FexTotal",	

				fex.FexTotal AS "FexTotalReal",

				fex.FexObservacion,
				fex.FexCancelado,
				fex.FexCantidadDia,
				fex.MonId,
				fex.FexTipoCambio,
				fex.FexObsequio,
				fex.FexEstado,	
				fex.FexCierre,				
				DATE_FORMAT(fex.FexTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFexTiempoCreacion",
                DATE_FORMAT(fex.FexTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFexTiempoModificacion",


		
				@PagMonto:=(SELECT 
				
				SUM(pag.PagMonto)
				
				FROM tblpagpago pag
				WHERE 
					
					EXISTS(
						SELECT
						pac.PacId
						FROM tblpacpagocomprobante pac
							WHERE pac.PagId = pag.PagId
							AND pac.FexId = fex.FexId
							AND pac.FetId = fex.FetId
					)
					
				) AS FexAbonado,
				
				(fex.FexTotal - IFNULL(@PagMonto,0)) AS FexSaldo,

				fet.FetNumero,
				
			
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.TdoId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				
				fin.FinVehiculoKilometraje,
				
				mon.MonNombre,
				mon.MonSimbolo,

				fim.FinId,
				amo.CprId,
				
				
				ein.EinVIN,
				ein.VmaId,
				ein.VmoId,
				ein.VveId,
				ein.EinAnoFabricacion,
				ein.EinPlaca,
				veh.VehColor,
				ein.EinNombre,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				
				@Amortizado:=(
					SELECT 
					SUM(pag.PagMonto)
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.FexId = fex.FexId
						AND pac.FetId = fex.FetId)
				) AS FexMontoAmortizado,
				
				(
					fex.FexTotal - IFNULL(@Amortizado,0)
				) AS FexMontoPendiente,

				IF(IFNULL((
					fex.FexTotal - IFNULL(@Amortizado,0)
				),0)>0,2,1) AS NFexCancelado,
				
				amo.VdiId,
				vdi.VdiArchivo
				
				FROM tblfexfacturaexportacion fex
					LEFT JOIN tblfetfacturaexportaciontalonario fet
					ON fex.FetId = fet.FetId
						
							LEFT JOIN tblclicliente cli
							ON fex.CliId = cli.CliId
								LEFT JOIN tblmonmoneda mon
									ON fex.MonId = mon.MonId
										LEFT JOIN tblamoalmacenmovimiento amo
										ON fex.AmoId = amo.AmoId
											
											LEFT JOIN tblvdiventadirecta vdi
											ON amo.VdiId = vdi.VdiId
											
											LEFT JOIN tblfccfichaaccion fcc
											ON amo.FccId = fcc.FccId
												LEFT JOIN tblfimfichaingresomodalidad fim
												ON fcc.FimId = fim.FimId
												
														LEFT JOIN tblfinfichaingreso fin
														ON fim.FinId = fin.FinId
																											
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
							
								LEFT JOIN tblvehvehiculo veh
								ON ein.VehId = veh.VehId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON ein.VmoId = vmo.VmoId
											LEFT JOIN tblvmavehiculomarca vma
											ON vmo.Vmaid = vma.VmaId
											
											
											
																						
											
				WHERE fex.FexId = "' . $this->FexId . '" AND fex.FetId = "' . $this->FetId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

				$this->FexId = $fila['FexId'];
				$this->FetId = $fila['FetId'];
				$this->UsuId = $fila['UsuId'];

				$this->CliId = $fila['CliId'];

				$this->NpaId = $fila['NpaId'];

				$this->AmoId = $fila['AmoId'];

				$this->FexAlmacenMovimiento = $fila['FexAlmacenMovimiento'];

				$this->FexFechaEmision = $fila['NFexFechaEmision'];
				$this->FexPorcentajeImpuestoVenta = $fila['FexPorcentajeImpuestoVenta'];
				$this->FexDireccion = $fila['FexDireccion'];

				$this->FexTotal = $fila['FexTotal'];
				$this->FexTotalReal = $fila['FexTotalReal'];

				list($this->FexObservacion, $this->FexObservacionImpresa) = explode("###", $fila['FexObservacion']);

				$this->FexCancelado = $fila['FexCancelado'];
				$this->FexCantidadDia = $fila['FexCantidadDia'];

				$this->MonId = $fila['MonId'];
				$this->FexTipoCambio = $fila['FexTipoCambio'];

				$this->FexObsequio = $fila['FexObsequio'];
				$this->FexEstado = $fila['FexEstado'];

				$this->FexCierre = $fila['FexCierre'];

				$this->FexTiempoCreacion = $fila['NFexTiempoCreacion'];
				$this->FexTiempoModificacion = $fila['NFexTiempoModificacion'];

				$this->FexAbonado = $fila['FexAbonado'];
				$this->FexSaldo = $fila['FexSaldo'];


				$this->FetNumero = $fila['FetNumero'];


				$this->CliNombreCompleto = $fila['CliNombreCompleto'];
				$this->CliNombre = $fila['CliNombre'];
				$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];


				$this->TdoId = $fila['TdoId'];
				$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
				$this->CliTelefono = $fila['CliTelefono'];
				$this->CliEmail = $fila['CliEmail'];
				$this->CliCelular = $fila['CliCelular'];
				$this->CliFax = $fila['CliFax'];



				$this->CliDepartamento = $fila['CliDepartamento'];
				$this->CliProvincia = $fila['CliProvincia'];
				$this->CliDistrito = $fila['CliDistrito'];


				$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];

				$this->MonNombre = $fila['MonNombre'];
				$this->MonSimbolo = $fila['MonSimbolo'];

				$this->FinId = $fila['FinId'];
				$this->CprId = $fila['CprId'];


				$this->EinVIN = $fila['EinVIN'];
				$this->VmaId = $fila['VmaId'];
				$this->VmoId = $fila['VmoId'];
				$this->VveId = $fila['VveId'];
				$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
				$this->EinPlaca = $fila['EinPlaca'];
				$this->VehColor = $fila['VehColor'];
				$this->EinNombre = $fila['EinNombre'];

				$this->VmaNombre = $fila['VmaNombre'];
				$this->VmoNombre = $fila['VmoNombre'];
				$this->VveNombre = $fila['VveNombre'];


				$this->FexMontoAmortizado = $fila['FexMontoAmortizado'];
				$this->FexMontoPendiente = $fila['FexMontoPendiente'];
				$this->FexCancelado = $fila['NFexCancelado'];

				$this->VdiId = $fila['VdiId'];
				$this->VdiArchivo = $fila['VdiArchivo'];





				if ($oCompleto) {

					$InsFacturaExportacionDetalle = new ClsFacturaExportacionDetalle();
					$ResFacturaExportacionDetalle =  $InsFacturaExportacionDetalle->MtdObtenerFacturaExportacionDetalles(NULL, NULL, NULL, NULL, NULL, $this->FexId, $this->FetId);
					$this->FacturaExportacionDetalle = $ResFacturaExportacionDetalle['Datos'];

					// MtdObtenerFacturaExportacionAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFacturaExportacion=NULL,$oFacturaExportacionTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL)
					$InsFacturaExportacionAlmacenMovimiento = new ClsFacturaExportacionAlmacenMovimiento();
					$ResFacturaExportacionAlmacenMovimiento =  $InsFacturaExportacionAlmacenMovimiento->MtdObtenerFacturaExportacionAlmacenMovimientos(NULL, NULL, NULL, NULL, NULL, $this->FexId, $this->FetId);
					$this->FacturaExportacionAlmacenMovimiento = $ResFacturaExportacionAlmacenMovimiento['Datos'];
				}


				switch ($this->FexEstado) {
					case 1:
						$this->FexEstadoDescripcion = "Pendiente";
						break;

					case 5:
						$this->FexEstadoDescripcion = "Entregado";
						break;

					case 6:
						$this->FexEstadoDescripcion = "Anulado";

						break;

					case 7:
						$this->FexEstadoDescripcion = "Reservado";
						break;
				}


				switch ($this->FexEstado) {
					case 1:
						$this->FexEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
						break;

					case 5:
						$this->FexEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
						break;

					case 6:
						$this->FexEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';

						break;

					case 7:
						$this->FexEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
						break;
				}
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerFacturaExportaciones($oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'FexId', $oSentido = 'Desc', $oPaginacion = '0,10', $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oTalonario = NULL, $oCondicionPago = NULL, $oMoneda = NULL, $oAlmacenMovimiento = NULL, $oCliente = NULL, $oOrdenVentaVehiculo = NULL, $oVentaDirecta = NULL)
	{



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


			$filtrar .= '  OR EXISTS( 
					
					SELECT 
					bde.FedId
					FROM tblfedfacturaexportaciondetalle bde
						
					WHERE 
						bde.FexId = fex.FexId AND
						bde.FetId = fex.FetId AND
						
						(
						bde.FedDescripcion LIKE "%' . $oFiltro . '%" 
						
						)
						
					) ';


			$filtrar .= '  ) ';
		}


		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oEstado)) {

			$elementos = explode(",", $oEstado);

			$i = 1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$estado .= '  (fex.FexEstado = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$estado .= ' OR ';
				}
				$i++;
			}

			$estado .= ' ) ';
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fex.FexFechaEmision)>="' . $oFechaInicio . '" AND DATE(fex.FexFechaEmision)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fex.FexFechaEmision)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fex.FexFechaEmision)<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oTalonario)) {
			$talonario = ' AND fex.FetId = "' . $oTalonario . '"';
		}

		if (!empty($oCondicionPago)) {
			$npago = ' AND fex.NpaId = "' . $oCondicionPago . '"';
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND fex.MonId = "' . $oMoneda . '"';
		}


		if (!empty($oAlmacenMovimiento)) {
			$amovimiento = ' AND fex.AmoId = "' . $oAlmacenMovimiento . '"';
		}


		if (!empty($oCliente)) {
			$cliente = ' AND fex.CliId = "' . $oCliente . '"';
		}



		if (!empty($oVentaDirecta)) {
			$vdirecta = ' AND amo.VdiId = "' . $oVentaDirecta . '"';
		}


		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fex.FexId,
				fex.FetId,
				fex.UsuId,
				fex.CliId,
				
				fex.NpaId,
				
				fex.AmoId,
				
			
				DATE_FORMAT(fex.FexFechaEmision, "%d/%m/%Y") AS "NFexFechaEmision",
				fex.FexPorcentajeImpuestoVenta,
				fex.FexDireccion,
			
				IF(fex.FexEstado=6,0.00,fex.FexSubTotal) AS "FexSubTotal",	
				IF(fex.FexEstado=6,0.00,fex.FexImpuesto) AS "FexImpuesto",
				IF(fex.FexEstado=6,0.00,fex.FexTotal) AS "FexTotal",
		
				fex.FexTotal AS "FexTotalReal",
		
				fex.FexObservacion,

				fex.FexCancelado,
				fex.FexCantidadDia,
				
				fex.MonId,
				fex.FexTipoCambio,
				fex.MonId,
				fex.FexTipoCambio,
				fex.FexObsequio,
				fex.FexEstado,	
				fex.FexCierre,	
				
				DATE_FORMAT(fex.FexTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFexTiempoCreacion",
                DATE_FORMAT(fex.FexTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFexTiempoModificacion",
				
				(SELECT COUNT(bde.FedId) FROM tblfedfacturaexportaciondetalle bde WHERE bde.FexId = fex.FexId AND bde.FetId = fex.FetId ) AS "FexTotalItems",
				
				npa.NpaNombre,
				
				fet.FetNumero,
				
				cli.TdoId,
				
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,			
				
				
				IF(fex.FexEstado=6,"ANULADO",cli.CliNombre) AS "NCliNombre",
				IF(fex.FexEstado=6,"-",cli.CliNumeroDocumento) AS "NCliNumeroDocumento",	
							
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				fim.FinId,
				amo.CprId,
				
				
				@Amortizado:=(
					SELECT 
					SUM(pag.PagMonto)
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.FexId = fex.FexId
						AND pac.FetId = fex.FetId)
				) AS FexMontoAmortizado,
				
				(
					fex.FexTotal - IFNULL(@Amortizado,0)
				) AS FexMontoPendiente,
				
				
				IF(IFNULL((
					fex.FexTotal - IFNULL(@Amortizado,0)
				),0)>0,2,1) AS NFexCancelado,
								
				vdi.VdiId,
				vdi.VdiOrdenCompraNumero,	
				vdi.VdiArchivo
								
				FROM tblfexfacturaexportacion fex
					LEFT JOIN tblnpacondicionpago npa
					ON fex.NpaId = npa.NpaId
						LEFT JOIN tblfetfacturaexportaciontalonario fet
						ON fex.FetId = fet.FetId
							
								LEFT JOIN tblclicliente cli
								ON fex.CliId = cli.CliId
									LEFT JOIN tblmonmoneda mon
									ON fex.MonId = mon.MonId
										LEFT JOIN tblamoalmacenmovimiento amo
										ON fex.AmoId = amo.AmoId
											LEFT JOIN tblvdiventadirecta vdi
											ON amo.VdiId = vdi.VdiId
											
											LEFT JOIN tblfccfichaaccion fcc
											ON amo.FccId = fcc.FccId
												
												LEFT JOIN tblfimfichaingresomodalidad fim
												ON fcc.FimId = fim.FimId
												
				WHERE 1 = 1 ' . $filtrar . $sucursal . $estado . $fecha . $talonario . $credito . $regimen . $npago . $moneda . $amovimiento . $cliente . $ovvehiculo . $vdirecta . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsFacturaExportacion = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$FacturaExportacion = new $InsFacturaExportacion();
			$FacturaExportacion->FexId = $fila['FexId'];
			$FacturaExportacion->FetId = $fila['FetId'];
			$FacturaExportacion->UsuId = $fila['UsuId'];
			$FacturaExportacion->CliId = $fila['CliId'];

			$FacturaExportacion->NpaId = $fila['NpaId'];
			$FacturaExportacion->AmoId = $fila['AmoId'];

			$FacturaExportacion->FexFechaEmision = $fila['NFexFechaEmision'];
			$FacturaExportacion->FexPorcentajeImpuestoVenta = $fila['FexPorcentajeImpuestoVenta'];
			$FacturaExportacion->FexDireccion = $fila['FexDireccion'];

			$FacturaExportacion->FexSubTotal = $fila['FexSubTotal'];
			$FacturaExportacion->FexImpuesto = $fila['FexImpuesto'];
			$FacturaExportacion->FexTotal = $fila['FexTotal'];
			$FacturaExportacion->FexTotalReal = $fila['FexTotalReal'];

			list($FacturaExportacion->FexObservacion, $FacturaExportacion->FexObservacionImpresa) = explode("###", $fila['FexObservacion']);

			$FacturaExportacion->FexCancelado = $fila['FexCancelado'];
			$FacturaExportacion->FexCantidadDia = $fila['FexCantidadDia'];

			$FacturaExportacion->MonId = $fila['MonId'];
			$FacturaExportacion->FexTipoCambio = $fila['FexTipoCambio'];
			$FacturaExportacion->FexObsequio = $fila['FexObsequio'];
			$FacturaExportacion->FexEstado = $fila['FexEstado'];
			$FacturaExportacion->FexCierre = $fila['FexCierre'];

			$FacturaExportacion->FexTiempoCreacion = $fila['NFexTiempoCreacion'];
			$FacturaExportacion->FexTiempoModificacion = $fila['NFexTiempoModificacion'];

			$FacturaExportacion->FexTotalItems = $fila['FexTotalItems'];

			$FacturaExportacion->NpaNombre = $fila['NpaNombre'];

			$FacturaExportacion->FetNumero = $fila['FetNumero'];


			$FacturaExportacion->CliNombreCompleto = $fila['CliNombreCompleto'];
			$FacturaExportacion->CliNombre = $fila['CliNombre'];
			$FacturaExportacion->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$FacturaExportacion->CliApellidoMaterno = $fila['CliApellidoMaterno'];

			$FacturaExportacion->TdoId = $fila['TdoId'];
			$FacturaExportacion->CliNumeroDocumento = $fila['NCliNumeroDocumento'];
			$FacturaExportacion->CliTelefono = $fila['CliTelefono'];
			$FacturaExportacion->CliEmail = $fila['CliTelefono'];
			$FacturaExportacion->CliCelular = $fila['CliCelular'];
			$FacturaExportacion->CliFax = $fila['CliFax'];

			$FacturaExportacion->MonNombre = $fila['MonNombre'];
			$FacturaExportacion->MonSimbolo = $fila['MonSimbolo'];

			$FacturaExportacion->FinId = $fila['FinId'];
			$FacturaExportacion->CprId = $fila['CprId'];


			$FacturaExportacion->FexMontoAmortizado = $fila['FexMontoAmortizado'];
			$FacturaExportacion->FexMontoPendiente = $fila['FexMontoPendiente'];
			$FacturaExportacion->FexCancelado = $fila['NFexCancelado'];

			$FacturaExportacion->VdiId = $fila['VdiId'];
			$FacturaExportacion->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
			$FacturaExportacion->VdiArchivo = $fila['VdiArchivo'];

			switch ($FacturaExportacion->FexEstado) {
				case 1:
					$FacturaExportacion->FexEstadoDescripcion = "Pendiente";
					break;

				case 5:
					$FacturaExportacion->FexEstadoDescripcion = "Entregado";
					break;

				case 6:
					$FacturaExportacion->FexEstadoDescripcion = "Anulado";

					break;

				case 7:
					$FacturaExportacion->FexEstadoDescripcion = "Reservado";
					break;
			}


			switch ($FacturaExportacion->FexEstado) {
				case 1:
					$FacturaExportacion->FexEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;

				case 5:
					$FacturaExportacion->FexEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;

				case 6:
					$FacturaExportacion->FexEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';

					break;

				case 7:
					$FacturaExportacion->FexEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
			}


			$FacturaExportacion->InsMysql = NULL;

			$Respuesta['Datos'][] = $FacturaExportacion;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}



	public function MtdObtenerFacturaExportacionesValor($oFuncion = "SUM", $oParametro = "FexId", $oMes = NULL, $oAno = NULL, $oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'FexId', $oSentido = 'Desc', $oPaginacion = '0,10', $oSucursal = NULL, $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oTalonario = NULL, $oRegimen = NULL, $oCondicionPago = NULL, $oMoneda = NULL, $oAlmacenMovimiento = NULL, $oCliente = NULL, $oClienteClasificacion = NULL, $oFichaIngresoMantenimientoKilometraje = NULL, $oModalidadIngreso = NULL, $oVehiculoMarca = NULL, $oVehiculoModelo = NULL, $oClienteTipo = NULL, $oTecnico = NULL)
	{

		if (!empty($oCampo) && !empty($oFiltro)) {
			$oFiltro = str_replace("*", "%", $oFiltro);
			switch ($oCondicion) {
				case "esigual":
					$filtrar = ' AND ' . ($oCampo) . ' LIKE "' . ($oFiltro) . '"';
					break;

				case "noesigual":
					$filtrar = ' AND ' . ($oCampo) . ' <> "' . ($oFiltro) . '"';
					break;

				case "comienza":
					$filtrar = ' AND ' . ($oCampo) . ' LIKE "' . ($oFiltro) . '%"';
					break;

				case "termina":
					$filtrar = ' AND ' . ($oCampo) . ' LIKE "%' . ($oFiltro) . '"';
					break;

				case "contiene":
					$filtrar = ' AND ' . ($oCampo) . ' LIKE "%' . ($oFiltro) . '%"';
					break;

				case "nocontiene":
					$filtrar = ' AND ' . ($oCampo) . ' NOT LIKE "%' . ($oFiltro) . '%"';
					break;

				default:
					$filtrar = ' AND ' . ($oCampo) . ' LIKE "' . ($oFiltro) . '%"';
					break;
			}
		}



		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}


		if (!empty($oSucursal)) {
			$sucursal = ' AND fet.SucId = "' . $oSucursal . '"';
		}

		if (!empty($oEstado)) {

			$elementos = explode(",", $oEstado);

			$i = 1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$estado .= '  (fex.FexEstado = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$estado .= ' OR ';
				}
				$i++;
			}

			$estado .= ' ) ';
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fex.FexFechaEmision)>="' . $oFechaInicio . '" AND DATE(fex.FexFechaEmision)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fex.FexFechaEmision)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fex.FexFechaEmision)<="' . $oFechaFin . '"';
			}
		}


		if (!empty($oTalonario)) {
			$talonario = ' AND fex.FetId = "' . $oTalonario . '"';
		}



		if (!empty($oCondicionPago)) {
			$npago = ' AND fex.NpaId = "' . $oCondicionPago . '"';
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND fex.MonId = "' . $oMoneda . '"';
		}

		if (!empty($oAlmacenMovimiento)) {
			$amovimiento = ' AND fex.AmoId = "' . $oAlmacenMovimiento . '"';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND fex.CliId = "' . $oCliente . '"';
		}


		if (!empty($oClienteClasificacion)) {
			$clasificacion = ' AND cli.CliClasificacion = ' . $oClienteClasificacion . ' ';
		}



		if (!empty($oModalidadIngreso)) {
			$mingreso = ' 
			AND 
			
			(
			
				EXISTS (
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblbamfexetaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
					WHERE fex.FexId = bam.FexId AND fex.FetId = bam.FetId
					AND fim.MinId = "' . $oModalidadIngreso . '"
					
				)
			
				OR
				
				EXISTS (
				
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfexfacturaexportacion fex2
								ON fex2.AmoId = amo.AmoId
								
					WHERE fex.FexId = fex2.FexId AND fex.FetId = fex2.FetId
					AND fim.MinId = "' . $oModalidadIngreso . '"
					
				)	
						
			)
			';
		}



		if (!empty($oFichaIngresoMantenimientoKilometraje)) {

			$mkilometraje = ' 
			AND 
			
			(
			
				EXISTS (
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblbamfexetaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
					WHERE fex.FexId = bam.FexId AND fex.FetId = bam.FetId
					AND fin.FinMantenimientoKilometraje = "' . $oFichaIngresoMantenimientoKilometraje . '"
					
				)
				
				OR
				
				EXISTS (
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfexfacturaexportacion fex2
								ON fex2.AmoId = amo.AmoId
								
					WHERE fex.FexId = fex2.FexId AND fex.FetId = fex2.FetId
					AND fin.FinMantenimientoKilometraje = "' . $oFichaIngresoMantenimientoKilometraje . '"
					
				)
							
			)
			';
		}

		if (!empty($oVehiculoMarca)) {

			$vmarca = ' 
			AND 
			(
				
				EXISTS (
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblbamfexetaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE fex.FexId = bam.FexId AND fex.FetId = bam.FetId
					AND vmo.VmaId = "' . $oVehiculoMarca . '"
					
				)
				
				OR
				
				EXISTS (
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfexfacturaexportacion fex2
								ON fex2.AmoId = amo.AmoId
								
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE fex.FexId = fex2.FexId AND fex.FetId = fex2.FetId
					AND vmo.VmaId = "' . $oVehiculoMarca . '"
					
				)
			
			)
			';
		}

		if (!empty($oVehiculoModelo)) {

			$vmodelo = ' 
			AND 
			
			(
				EXISTS (
				SELECT fin.FinId FROM tblfinfichaingreso fin
				LEFT JOIN tblfimfichaingresomodalidad fim
				ON fim.FinId = fin.FinId
					LEFT JOIN tblfccfichaaccion fcc
					ON fcc.FimId = fim.FimId
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amo.FccId = fcc.FccId
							LEFT JOIN tblbamfexetaalmacenmovimiento bam
							ON bam.AmoId = amo.AmoId
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
										
				WHERE fex.FexId = bam.FexId AND fex.FetId = bam.FetId
				AND vve.VmoId = "' . $oVehiculoModelo . '"
				
				)
				
				OR
				
				EXISTS (
				SELECT fin.FinId FROM tblfinfichaingreso fin
				LEFT JOIN tblfimfichaingresomodalidad fim
				ON fim.FinId = fin.FinId
					LEFT JOIN tblfccfichaaccion fcc
					ON fcc.FimId = fim.FimId
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amo.FccId = fcc.FccId
							LEFT JOIN tblfexfacturaexportacion fex2
							ON fex2.AmoId = amo.AmoId
							
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
										
				WHERE fex.FexId = fex2.FexId AND fex.FetId = fex2.FetId
				AND vve.VmoId = "' . $oVehiculoModelo . '"
				
				)
				
					
			)
			';
		}



		if (!empty($oTecnico)) {

			$tecnico = ' 
			AND 
			
			(
			
				EXISTS (
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblbamfexetaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
					WHERE fex.FexId = bam.FexId AND fex.FetId = bam.FetId
					AND fin.PerId = "' . $oTecnico . '"
					
				)
				
				OR
				
				EXISTS (
					SELECT fin.FinId FROM tblfinfichaingreso fin
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fim.FinId = fin.FinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfexfacturaexportacion fex2
								ON fex2.AmoId = amo.AmoId
								
					WHERE fex.FexId = fex2.FexId AND fex.FetId = fex2.FetId
					AND fin.PerId = "' . $oTecnico . '"
					
				)
							
			)
			';
		}



		if (!empty($oFuncion) & !empty($oParametro)) {
			$funcion = $oFuncion . '(' . $oParametro . ')';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fex.FexFechaEmision) ="' . ($oMes) . '"';
		}

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fex.FexFechaEmision) ="' . ($oAno) . '"';
		}

		if (!empty($oClienteTipo)) {
			$ctipo = ' AND cli.LtiId = "' . $oClienteTipo . '" ';
		}


		$sql = 'SELECT

				' . $funcion . ' AS "RESULTADO"
				
				FROM tblfexfacturaexportacion fex
					LEFT JOIN tblfetfacturaexportaciontalonario fet
					ON fex.FetId = fet.FetId
						LEFT JOIN tblclicliente cli
						ON fex.CliId = cli.CliId
				
				WHERE 1 = 1
				' . $$filtrar . $sucursal . $estado . $fecha . $credito . $regimen . $npago . $moneda . $mes . $ano . $amovimiento . $cliente . $clasificacion . $ctipo . $mkilometraje . $vmarca . $vmodelo . $tecnico . $mingreso . $orden . $paginacion;




		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		settype($fila['RESULTADO'], "float");

		return $fila['RESULTADO'];
	}




	public function MtdActualizarEstadoFacturaExportacion($oElementos, $oEstado)
	{

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$accion = '';
		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$aux = explode("%", $elemento);

				//$this->FexId = $aux[0];
				//$this->FetId = $aux[1];

				$sql = 'UPDATE tblfexfacturaexportacion SET FexEstado = ' . $oEstado . ' WHERE   (FexId = "' . ($aux[0]) . '" AND FetId = "' . ($aux[1]) . '")';

				$resultado = $this->InsMysql->MtdEjecutar($sql, false);

				if (!$resultado) {
					$error = true;
				} else {

					$this->MtdAuditarFacturaExportacion(2, "Se actualizo el Estado de la FacturaExportacion", $aux);
				}
			}
			$i++;
		}

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}
	}


	//Accion eliminar	
	public function MtdEliminarFacturaExportacion($oElementos)
	{

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$aux = explode('%', $elemento);

				if (!$error) {

					$sql = 'DELETE FROM tblfexfacturaexportacion WHERE (FexId = "' . ($aux[0]) . '" AND FetId = "' . ($aux[1]) . '")';
					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {


						$this->MtdAuditarFacturaExportacion(3, "Se elimino la FacturaExportacion", $aux);
					}
				}
			}
			$i++;
		}

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}
	}


	public function MtdRegistrarFacturaExportacion()
	{

		global $Resultado;
		$error = false;

		$this->FexId = trim($this->FexId);

		$this->InsMysql->MtdTransaccionIniciar();


		/*			$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->CcaId = "CCA-10000";
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->FexDireccion;
				$InsCliente->CliEstado = 1;//En actividad
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
				$InsCliente->CliEliminado = 1;
			
				if(empty($InsCliente->CliId)){
					
					$InsCliente->MtdGenerarClienteId();	

					if(!$InsCliente->MtdRegistrarClienteDeFacturaExportacion()){
						$error = true;
						$Resultado.='#ERR_FEX_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
					
				}else{
					
					
				}
*/

		$sql = 'INSERT INTO tblfexfacturaexportacion (
				FexId,
				FetId,
				UsuId, 
				CliId,
	
				NpaId,
				AmoId,
				
				FccId,
				
				FexFechaEmision,
				FexPorcentajeImpuestoVenta,
				FexDireccion,
				FexTotalBruto,			
				FexSubTotal,
				FexImpuesto,
				FexTotal,			
				FexObservacion,
				FexCantidadDia,
				MonId,
				FexTipoCambio,	
				FexObsequio,	
				FexEstado,
				FexCierre,			

				FexTiempoCreacion,
				FexTiempoModificacion

				) 
				VALUES (
				"' . ($this->FexId) . '", 
				"' . ($this->FetId) . '",
				"' . ($this->UsuId) . '",
				"' . ($this->CliId) . '",

				"' . ($this->NpaId) . '",

				' . (empty($this->AmoId) ? 'NULL, ' : '"' . $this->AmoId . '",') . '

				' . (empty($this->FccId) ? 'NULL, ' : '"' . $this->FccId . '",') . '

				"' . ($this->FexFechaEmision) . '",
				' . ($this->FexPorcentajeImpuestoVenta) . ',
				"' . ($this->FexDireccion) . '",
				' . ($this->FexTotalBruto) . ',			
				' . ($this->FexSubTotal) . ',
				' . ($this->FexImpuesto) . ',
				' . ($this->FexTotal) . ',			
				"' . ($this->FexObservacion) . '", 
				' . ($this->FexCantidadDia) . ',
				"' . ($this->MonId) . '",
				' . (empty($this->FexTipoCambio) ? 'NULL, ' : '' . $this->FexTipoCambio . ',') . '
				' . ($this->FexObsequio) . ',
				' . ($this->FexEstado) . ',
				' . ($this->FexCierre) . ', 

				"' . ($this->FexTiempoCreacion) . '", 
				"' . ($this->FexTiempoModificacion) . '");';

		if (!$error) {
			$resultado = $this->InsMysql->MtdEjecutar($sql, false);
			if (!$resultado) {
				$error = true;

				switch ($this->InsMysql->MtdObtenerErrorCodigo()) {
					case 1062:
						$Resultado .= "#ERR_FEX_402";
						break;
				}
			}
		}

		if (!$error) {

			if (!empty($this->FacturaExportacionDetalle)) {

				$validar = 0;
				$InsFacturaExportacionDetalle = new ClsFacturaExportacionDetalle();

				foreach ($this->FacturaExportacionDetalle as $DatFacturaExportacionDetalle) {
					$InsFacturaExportacionDetalle->FexId = $this->FexId;
					$InsFacturaExportacionDetalle->FetId = $this->FetId;
					$InsFacturaExportacionDetalle->VdeId = $DatFacturaExportacionDetalle->VdeId;

					$InsFacturaExportacionDetalle->FedTipo = $DatFacturaExportacionDetalle->FedTipo;

					$InsFacturaExportacionDetalle->AmdId = $DatFacturaExportacionDetalle->AmdId;
					$InsFacturaExportacionDetalle->FedDescripcion = $DatFacturaExportacionDetalle->FedDescripcion;
					$InsFacturaExportacionDetalle->FedUnidadMedida = $DatFacturaExportacionDetalle->FedUnidadMedida;
					$InsFacturaExportacionDetalle->FedPrecio = $DatFacturaExportacionDetalle->FedPrecio;
					$InsFacturaExportacionDetalle->FedCantidad = $DatFacturaExportacionDetalle->FedCantidad;
					$InsFacturaExportacionDetalle->FedPrecio = $DatFacturaExportacionDetalle->FedPrecio;
					$InsFacturaExportacionDetalle->FedImporte = $DatFacturaExportacionDetalle->FedImporte;
					$InsFacturaExportacionDetalle->FedEstado = $this->FexEstado;
					$InsFacturaExportacionDetalle->FedTiempoCreacion = $DatFacturaExportacionDetalle->FedTiempoCreacion;
					$InsFacturaExportacionDetalle->FedTiempoModificacion = $DatFacturaExportacionDetalle->FedTiempoModificacion;
					$InsFacturaExportacionDetalle->FedEliminado = $DatFacturaExportacionDetalle->FedEliminado;

					if ($InsFacturaExportacionDetalle->MtdRegistrarFacturaExportacionDetalle()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_FEX_201';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->FacturaExportacionDetalle) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FacturaExportacionAlmacenMovimiento)) {

				$validar = 0;
				$InsFacturaExportacionAlmacenMovimiento = new ClsFacturaExportacionAlmacenMovimiento();

				foreach ($this->FacturaExportacionAlmacenMovimiento as $DatFacturaExportacionAlmacenMovimiento) {

					$InsFacturaExportacionAlmacenMovimiento->FexId = $this->FexId;
					$InsFacturaExportacionAlmacenMovimiento->FetId = $this->FetId;
					$InsFacturaExportacionAlmacenMovimiento->AmoId = $DatFacturaExportacionAlmacenMovimiento->AmoId;
					$InsFacturaExportacionAlmacenMovimiento->BamEstado = $DatFacturaExportacionAlmacenMovimiento->BamEstado;
					$InsFacturaExportacionAlmacenMovimiento->BamTiempoCreacion = $DatFacturaExportacionAlmacenMovimiento->BamTiempoCreacion;
					$InsFacturaExportacionAlmacenMovimiento->BamTiempoModificacion = $DatFacturaExportacionAlmacenMovimiento->BamTiempoModificacion;
					$InsFacturaExportacionAlmacenMovimiento->BamEliminado = $DatFacturaExportacionAlmacenMovimiento->BamEliminado;

					if ($InsFacturaExportacionAlmacenMovimiento->MtdRegistrarFacturaExportacionAlmacenMovimiento()) {
						$validar++;
					} else {
						//$Resultado.='#ERR_FAC_201';
						//$Resultado.='#Item Numero: '.($validar+1);
					}
				}

				if (count($this->FacturaExportacionAlmacenMovimiento) <> $validar) {
					$error = true;
				}
			}
		}


		if ($error) {

			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {

			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarFacturaExportacion(1, "Se registro la FacturaExportacion", $this);
			return true;
		}
	}

	public function MtdEditarFacturaExportacion()
	{

		global $Resultado;
		$error = false;

		//if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->FexFechaEmision))){
		//			$error = true;
		//			$Resultado.='#ERR_FEX_400';
		//		}else{

		$this->InsMysql->MtdTransaccionIniciar();
		/*
				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->CcaId = "CCA-10000";
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->FexDireccion;
				$InsCliente->CliEstado = 1;//En actividad
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
				$InsCliente->CliEliminado = 1;
			
				if(empty($InsCliente->CliId)){
					
					$InsCliente->MtdGenerarClienteId();	

					if(!$InsCliente->MtdRegistrarClienteDeFacturaExportacion()){
						$error = true;
						$Resultado.='#ERR_FEX_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
					
				}else{
					
					
				}	*/

		$sql = 'UPDATE tblfexfacturaexportacion SET 
				CliId = "' . ($this->CliId) . '",
				NpaId = "' . ($this->NpaId) . '",
				
				FexFechaEmision = "' . ($this->FexFechaEmision) . '",	
				FexPorcentajeImpuestoVenta = ' . ($this->FexPorcentajeImpuestoVenta) . ',
				FexDireccion = "' . ($this->FexDireccion) . '",
				MonId = "' . ($this->MonId) . '",
				' . (empty($this->FexTipoCambio) ? 'FexTipoCambio = NULL, ' : 'FexTipoCambio = "' . $this->FexTipoCambio . '",') . '
				
				FexTotalBruto = ' . ($this->FexTotalBruto) . ',
				FexSubTotal = ' . ($this->FexSubTotal) . ',
				FexImpuesto = ' . ($this->FexImpuesto) . ',
				FexTotal = ' . ($this->FexTotal) . ',
				FexObservacion = "' . ($this->FexObservacion) . '",
				FexCantidadDia = "' . ($this->FexCantidadDia) . '",	
				FexObsequio = ' . ($this->FexObsequio) . ',		
				FexEstado = ' . ($this->FexEstado) . ',
				
				FexTiempoModificacion = "' . ($this->FexTiempoModificacion) . '"			
				WHERE FexId = "' . ($this->FexId) . '"
				AND FetId = "' . $this->FetId . '";';





		if (!$error) {
			$resultado = $this->InsMysql->MtdEjecutar($sql, false);
			if (!$resultado) {
				$error = true;
			}
		}

		if (!$error) {

			if (!empty($this->FacturaExportacionDetalle)) {


				$validar = 0;
				$InsFacturaExportacionDetalle = new ClsFacturaExportacionDetalle($this->InsMysql);

				foreach ($this->FacturaExportacionDetalle as $DatFacturaExportacionDetalle) {

					$InsFacturaExportacionDetalle->FedId = $DatFacturaExportacionDetalle->FedId;
					$InsFacturaExportacionDetalle->FexId = $this->FexId;
					$InsFacturaExportacionDetalle->FetId = $this->FetId;
					$InsFacturaExportacionDetalle->VdeId = $DatFacturaExportacionDetalle->VdeId;

					$InsFacturaExportacionDetalle->FedTipo = $DatFacturaExportacionDetalle->FedTipo;

					$InsFacturaExportacionDetalle->FedDescripcion = $DatFacturaExportacionDetalle->FedDescripcion;
					$InsFacturaExportacionDetalle->FedUnidadMedida = $DatFacturaExportacionDetalle->FedUnidadMedida;

					$InsFacturaExportacionDetalle->FedPrecio = $DatFacturaExportacionDetalle->FedPrecio;
					$InsFacturaExportacionDetalle->FedCantidad = $DatFacturaExportacionDetalle->FedCantidad;
					$InsFacturaExportacionDetalle->FedPrecio = $DatFacturaExportacionDetalle->FedPrecio;
					$InsFacturaExportacionDetalle->FedImporte = $DatFacturaExportacionDetalle->FedImporte;
					$InsFacturaExportacionDetalle->FedTiempoCreacion = $DatFacturaExportacionDetalle->FedTiempoCreacion;
					$InsFacturaExportacionDetalle->FedTiempoModificacion = $DatFacturaExportacionDetalle->FedTiempoModificacion;
					$InsFacturaExportacionDetalle->FedEliminado = $DatFacturaExportacionDetalle->FedEliminado;

					if (empty($InsFacturaExportacionDetalle->FedId)) {
						if ($InsFacturaExportacionDetalle->FedEliminado <> 2) {
							if ($InsFacturaExportacionDetalle->MtdRegistrarFacturaExportacionDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FEX_201';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFacturaExportacionDetalle->FedEliminado == 2) {
							if ($InsFacturaExportacionDetalle->MtdEliminarFacturaExportacionDetalle($InsFacturaExportacionDetalle->FedId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FEX_203';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsFacturaExportacionDetalle->MtdEditarFacturaExportacionDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FEX_202';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}


				if (count($this->FacturaExportacionDetalle) <> $validar) {
					$error = true;
				}
			}
		}




		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			$this->MtdAuditarFacturaExportacion(2, "Se edito la FacturaExportacion", $this);
			return true;
		}
	}

	public function MtdEditarIdFacturaExportacion()
	{


		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblfexfacturaexportacion SET 
			FexId = "' . ($this->NFexId) . '",
			FexTiempoModificacion = "' . ($this->FexTiempoModificacion) . '"
			WHERE FexId = "' . ($this->FexId) . '"
			AND FetId = "' . $this->FetId . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);
		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();


			$this->MtdAuditarFacturaExportacion(2, "Se edito el Codigo de la FacturaExportacion", $this);
			return true;
		}
	}





	public function MtdVerificarExisteAlmacenMovimientoSalidaId($oAlmacenMovimientoSalidaId)
	{

		$FacturaExportacion = array();

		$sql = 'SELECT 
		fex.FexId,
		fex.FetId
        FROM tblfexfacturaexportacion fex
        WHERE  fex.AmoId = "' . $oAlmacenMovimientoSalidaId . '" 
		AND fex.FexEstado <> 6
		LIMIT 1;';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$FacturaExportacion[]  = $fila['FexId'];
				$FacturaExportacion[]  = $fila['FetId'];
			}
		}
		return $FacturaExportacion;
	}








	private function MtdAuditarFacturaExportacion($oAccion, $oDescripcion, $oDatos, $oCodigo = NULL, $oUsuario = NULL, $oPersonal = NULL)
	{

		$InsAuditoria = new ClsAuditoria($this->InsMysql);
		$InsAuditoria->AudCodigo = $this->FexId;
		$InsAuditoria->AudCodigoExtra = $this->FetId;
		$InsAuditoria->UsuId = $this->UsuId;
		$InsAuditoria->SucId = $this->SucId;
		$InsAuditoria->AudAccion = $oAccion;
		$InsAuditoria->AudDescripcion = $oDescripcion;
		$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
		$InsAuditoria->AudDatos = $oDatos;
		$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");

		if ($InsAuditoria->MtdAuditoriaRegistrar()) {
			return true;
		} else {
			return false;
		}
	}
}
