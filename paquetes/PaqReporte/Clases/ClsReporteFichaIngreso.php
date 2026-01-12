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

class ClsReporteFichaIngreso
{

	public $FinId;
	public $CliNombreCompleto;
	public $MinNombre;
	public $VmaNombre;
	public $VmoNombre;

	public $CliCSIIncluir;

	public $MinId;
	public $FinMantenimientoKilometraje;
	public $FinVehiculoKilometraje;

	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;

	public $FinTiempoTallerRevisando;
	public $FinTiempoTrabajoTerminado;
	public $FinTiempoTallerConcluido;

	public $FinTiempoTranscurrido;
	public $FinTiempoTranscurrido2;

	public $FacId;
	public $FacFechaEmision;
	public $FacTotal;
	public $FtaNumero;

	public $BolId;
	public $BolFechaEmision;
	public $BolTotal;
	public $BtaNumero;

	public $Transaccion;

	public function __construct($oInsMysql = NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}
	}

	public function __destruct() {}



	public function MtdObtenerReporteFichaIngresos($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FinId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oModalidadIngreso = NULL, $oAgrupar = NULL, $oCSIIncluir = NULL, $oCliente = NULL, $oUnicos = false, $oVehiculoMarca = NULL, $oModalidadIngresoUnico = false, $oSucursal = NULL, $oFecha = "FinTiempoTrabajoTerminado", $oComprobanteFechaInicio = NULL, $oComprobanteFechaFin = NULL, $oPersonal = NULL, $oVehiculoModelo = NULL)
	{

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$modalidadIngreso = '';
		$agrupar = '';
		$csiIncluir = '';
		$cliente = '';
		$unicos = '';
		$vehiculoMarca = '';
		$modalidadIngresoUnico = '';
		$sucursal = '';
		$fecha = '';
		$comprobanteFechaInicio = '';
		$comprobanteFechaFin = '';
		$personal = '';
		$vehiculoModelo = '';

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
				$fecha = ' AND DATE(fin.' . $oFecha . ')>="' . $oFechaInicio . '" AND DATE(fin.' . $oFecha . ')<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fin.' . $oFecha . ')>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fin.' . $oFecha . ')<="' . $oFechaFin . '"';
			}
		}




		if (!empty($oComprobanteFechaInicio)) {

			if (!empty($oComprobanteFechaFin)) {

				$cfecha = ' AND (DATE(fac.FacFechaEmision)>="' . $oComprobanteFechaInicio . '" AND DATE(fac.FacFechaEmision)<="' . $oComprobanteFechaFin . '" 
					OR DATE(bol.BolFechaEmision)>="' . $oComprobanteFechaInicio . '" AND DATE(bol.BolFechaEmision)<="' . $oComprobanteFechaFin . '")';
			} else {

				$cfecha = ' AND (DATE(fac.FacFechaEmision)>="' . $oComprobanteFechaInicio . '" OR DATE(bol.BolFechaEmision)>="' . $oComprobanteFechaInicio . '")';
			}
		} else {
			if (!empty($oComprobanteFechaFin)) {
				$cfecha = ' AND (DATE(fac.FacFechaEmision)<="' . $oComprobanteFechaInicio . '" OR DATE(bol.BolFechaEmision)<="' . $oComprobanteFechaInicio . '")';
			}
		}

		/*if(!empty($oModalidadIngreso)){
				$mingreso = ' AND fim.MinId = "'.$oModalidadIngreso.'"';		
			}*/

		if (!empty($oModalidadIngreso)) {

			if ($oModalidadIngresoUnico) {

				$mingreso .= ' AND fim.MinId = "' . $oModalidadIngreso . '"';
			} else {



				//cli.LtiId = "'.($elemento).'"


				$elementos = explode(",", $oModalidadIngreso);

				$i = 1;
				$mingreso .= ' AND (
						(';
				$elementos = array_filter($elementos);
				foreach ($elementos as $elemento) {
					$mingreso .= '  (
							
								 fim.MinId = "' . $elemento . '"
							
							)';
					if ($i <> count($elementos)) {
						$mingreso .= ' OR ';
					}
					$i++;
				}

				$mingreso .= ' ) 
						)
						';

				/*$elementos = explode(",",$oModalidadIngreso);
			
						$i=1;
						$mingreso .= ' AND (
						(';
						$elementos = array_filter($elementos);
						foreach($elementos as $elemento){
							$mingreso .= '  (
							
								EXISTS (
									SELECT fim.FimId
										FROM tblfimfichaingresomodalidad fim
										WHERE fim.MinId = "'.$elemento.'"
										AND fim.FinId = fin.FinId
									LIMIT 1
								)
							
							)';
							if($i<>count($elementos)){						
								$mingreso .= ' OR ';	
							}
						$i++;		
						}
			
						$mingreso .= ' ) 
						)
						';*/
			}
		}




		if (!empty($oAgrupar)) {
			$agrupar = ' GROUP BY ' . $oAgrupar . '';
		}

		if (!empty($oCSIIncluir)) {
			$csiincluir = ' AND cli.CliCSIIncluir = ' . $oCSIIncluir . '';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND cli.CliId = "' . $oCliente . '"';
		}


		if (($oUnicos)) {
			$unicos = 'DISTINCT (fin.FinId),';
		} else {
			$unicos = ' (fin.FinId),';
		}

		if (!empty($oVehiculoMarca)) {
			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '"';
		}


		if (!empty($oVehiculoModelo)) {
			$vmodelo = ' AND vve.VmoId = "' . $oVehiculoModelo . '"';
		}


		if (!empty($oSucursal)) {
			$sucursal = ' AND fin.SucId = "' . $oSucursal . '"';
		}


		if (!empty($oPersonal)) {
			$personal = ' AND fin.PerId = "' . $oPersonal . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				' . $unicos . '
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",

				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliTelefono,
				cli.CliCelular,
				
				cli.CliCelular,
				
				cli.CliEmail,
				
				cli.CliContactoEmail1,
				cli.CliContactoEmail2,
				cli.CliContactoEmail3,

				cli.CliEmailFacturacion,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDireccion,
				
				cli.CliCSIIncluir,
				cli.CliCSIExcluirMotivo,
				DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",
				
				min.MinNombre,
				vma.VmaNombre,
				vmo.VmoNombre,
				
				min.MinId,
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				
				per.PerNumeroDocumento,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTrabajoTerminado) /3600) AS FinTiempoTranscurrido,
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTallerConcluido) /3600) AS FinTiempoTranscurrido2,
				
				
				
				fta.FtaNumero,
				fac.FacId,
				fac.FacTotal,
				fac.FacSubTotal,
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
				
				bta.BtaNumero,				
				bol.BolId,
				bol.BolTotal,
				bol.BolSubTotal,
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND (fde.FdeDescripcion LIKE "%MANO DE OBRA%" OR fde.FdeUnidadMedida LIKE "%ZZ%")
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						),
							IFNULL(
							
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							AND (bde.BdeDescripcion LIKE "%MANO DE OBRA%" OR bde.BdeUnidadMedida LIKE "%ZZ%")
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiManoObra,
				
				
				
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND fde.FdeDescripcion NOT LIKE "%MANO DE OBRA%"
						AND fde.FdeUnidadMedida = "UND"
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						)
						,
							IFNULL(
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							AND bde.BdeDescripcion NOT LIKE "%MANO DE OBRA%"
							AND bde.BdeUnidadMedida = "UND"
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiRepuestos,
				
			 
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND fde.FdeDescripcion NOT LIKE "%MANO DE OBRA%"
						AND fde.FdeUnidadMedida <> "UND"
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						),
							IFNULL(
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							-- AND (bde.BdeDescripcion NOT LIKE "%MANO DE OBRA%" AND bde.BdeUnidadMedida NOT LIKE "%ZZ%")
							AND bde.BdeUnidadMedida <> "UND"
							AND bde.BdeUnidadMedida <> "ZZ"
							AND bde.BdeUnidadMedida <> ""
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiLubricantes,
				
			
				
				ein.EinVIN,
				ein.EinPlaca,
				
				
						per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					fin.FinTelefono,
					fin.FinTallerObservacion,
					fin.FinSalidaObservacion,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					min.MinSigla,
					
					
					amo.AmoTotal,
					lti.LtiNombre,
					lti.LtiAbreviatura,
					fcc.FccFacturable,
					fcc.FccCausa,
					fcc.FccId,
					
					suc.SucNombre,
					suc.SucDepartamento,
					suc.SucDistrito,
					fin.FinVehiculoKilometraje,
					
					fin.FinIndicacionTecnico,
					
					cli.CliNumeroDocumento,
					
					fin.FinNota,
					
					ein.EinAnoModelo,
					
					suc.SucNombre
					
		
			
				FROM tblfccfichaaccion fcc

					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
						LEFT JOIN tblfacfactura fac
						ON fac.AmoId = amo.AmoId
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
							
								LEFT JOIN tblbolboleta bol
								ON bol.AmoId = amo.AmoId
									LEFT JOIN tblbtaboletatalonario bta
									ON bol.BtaId = bta.BtaId
																
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
									
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
										
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
												LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId
											
				
							LEFT JOIN tblclicliente cli
							ON	fin.CliId = cli.CliId
								LEFT JOIN tbllticlientetipo lti
								ON cli.LtiId = lti.LtiId
								
								LEFT JOIN tblperpersonal per
								ON fin.PerId = per.PerId
							
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId
												
												LEFT JOIN tbloncconcesionario onc
												ON ein.OncId = onc.OncId
												
												LEFT JOIN tblsucsucursal suc
												ON fin.SucId = suc.SucId
				WHERE fin.FinTipo = 1 ' . $filtrar . $fecha . $mingreso . $sucursal . $personal . $csiincluir . $vmarca . $vmodelo . $personal . $cfecha . $cliente . $agrupar . $orden . "  " . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		//IF(IFNULL(fac.AmoId
		//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,

		$Respuesta['Datos'] = array();

		$InsReporteFichaIngreso = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteFichaIngreso = new $InsReporteFichaIngreso();

			$ReporteFichaIngreso->FinId = $fila['FinId'];
			$ReporteFichaIngreso->CliId = $fila['CliId'];

			$ReporteFichaIngreso->FinFecha = $fila['NFinFecha'];

			$ReporteFichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];

			$ReporteFichaIngreso->CliNombre = $fila['CliNombre'];
			$ReporteFichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];

			$ReporteFichaIngreso->CliTelefono = $fila['CliTelefono'];
			$ReporteFichaIngreso->CliCelular = $fila['CliCelular'];
			$ReporteFichaIngreso->CliDireccion = $fila['CliDireccion'];

			$ReporteFichaIngreso->CliEmail = $fila['CliEmail'];

			$ReporteFichaIngreso->CliContactoEmail1 = $fila['CliContactoEmail1'];
			$ReporteFichaIngreso->CliContactoEmail2 = $fila['CliContactoEmail2'];
			$ReporteFichaIngreso->CliContactoEmail3 = $fila['CliContactoEmail3'];

			$ReporteFichaIngreso->CliEmailFacturacion = $fila['CliEmailFacturacion'];


			$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
			$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
			$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
			$ReporteFichaIngreso->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];
			$ReporteFichaIngreso->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];



			$ReporteFichaIngreso->MinNombre = $fila['MinNombre'];
			$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
			$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];


			$ReporteFichaIngreso->MinId = $fila['MinId'];
			$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
			$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];

			$ReporteFichaIngreso->PerNumeroDocumento = $fila['PerNumeroDocumento'];
			$ReporteFichaIngreso->PerNombre = $fila['PerNombre'];
			$ReporteFichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$ReporteFichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];

			$ReporteFichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
			$ReporteFichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			$ReporteFichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];

			$ReporteFichaIngreso->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
			$ReporteFichaIngreso->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];

			$ReporteFichaIngreso->FacId = $fila['FacId'];
			$ReporteFichaIngreso->FtaNumero = $fila['FtaNumero'];
			$ReporteFichaIngreso->FacFechaEmision = $fila['NFacFechaEmision'];
			$ReporteFichaIngreso->FacTotal = $fila['FacTotal'];
			$ReporteFichaIngreso->FacSubTotal = $fila['FacSubTotal'];



			$ReporteFichaIngreso->BolId = $fila['BolId'];
			$ReporteFichaIngreso->BtaNumero = $fila['BtaNumero'];
			$ReporteFichaIngreso->BolFechaEmision = $fila['NBolFechaEmision'];
			$ReporteFichaIngreso->BolTotal = $fila['BolTotal'];
			$ReporteFichaIngreso->BolSubTotal = $fila['BolSubTotal'];

			$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
			$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];

			$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
			$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
			$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];

			$ReporteFichaIngreso->FinTelefono = $fila['FinTelefono'];
			$ReporteFichaIngreso->FinTallerObservacion = $fila['FinTallerObservacion'];
			$ReporteFichaIngreso->FinSalidaObservacion = $fila['FinSalidaObservacion'];

			$ReporteFichaIngreso->OncCodigoDealer = $fila['OncCodigoDealer'];

			$ReporteFichaIngreso->OncNombre = $fila['OncNombre'];

			$ReporteFichaIngreso->MinSigla = $fila['MinSigla'];

			if (empty($ReporteFichaIngreso->FacId)) {
				if (empty($ReporteFichaIngreso->BolId)) {
					$ReporteFichaIngreso->FinComprobanteVentaTipo = "";
				} else {
					$ReporteFichaIngreso->FinComprobanteVentaTipo = "B";
				}
			} else {
				$ReporteFichaIngreso->FinComprobanteVentaTipo = "F";
			}

			$ReporteFichaIngreso->AmoTotal = $fila['AmoTotal'];
			$ReporteFichaIngreso->LtiNombre = $fila['LtiNombre'];
			$ReporteFichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];
			$ReporteFichaIngreso->FccFacturable = $fila['FccFacturable'];

			$ReporteFichaIngreso->FccCausa = $fila['FccCausa'];
			$ReporteFichaIngreso->FccId = $fila['FccId'];

			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];
			$ReporteFichaIngreso->SucDepartamento = $fila['SucDepartamento'];

			$ReporteFichaIngreso->SucDistrito = $fila['SucDistrito'];

			$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'] + 1 - 1;
			$ReporteFichaIngreso->FinIndicacionTecnico = $fila['FinIndicacionTecnico'];

			$ReporteFichaIngreso->CliNumeroDocumento = $fila['CliNumeroDocumento'];

			$ReporteFichaIngreso->RfiLubricantes = $fila['RfiLubricantes'];
			$ReporteFichaIngreso->RfiRepuestos = $fila['RfiRepuestos'];
			$ReporteFichaIngreso->RfiManoObra = $fila['RfiManoObra'];



			//$ReporteFichaIngreso->RfiOtros = $ReporteFichaIngreso->FacTotal - $ReporteFichaIngreso->BolTotal -   $ReporteFichaIngreso->RfiLubricantes  -   $ReporteFichaIngreso->RfiRepuestos  -   $ReporteFichaIngreso->RfiManoObra;
			$ReporteFichaIngreso->RfiOtros = 0;

			$ReporteFichaIngreso->FinNota = $fila['FinNota'];

			$ReporteFichaIngreso->RfiTotales = $ReporteFichaIngreso->RfiLubricantes  +   $ReporteFichaIngreso->RfiRepuestos +  $ReporteFichaIngreso->RfiManoObra;



			$ReporteFichaIngreso->EinAnoModelo = $fila['EinAnoModelo'];

			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];




			$ReporteFichaIngreso->InsMysql = NULL;

			$Respuesta['Datos'][] = $ReporteFichaIngreso;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}






	public function MtdObtenerReporteFichaIngresoClientes($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FinId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oModalidadIngreso = NULL, $oAgrupar = NULL, $oSucursal = NULL, $oVehiculoMarca = NULL)
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
				$fecha = ' AND DATE(fin.FinFecha)>="' . $oFechaInicio . '" AND DATE(fin.FinFecha)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fin.FinFecha)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fin.FinFecha)<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oModalidadIngreso)) {
			$mingreso = ' AND fim.MinId = "' . $oModalidadIngreso . '"';
		}

		if (!empty($oAgrupar)) {
			$agrupar = ' GROUP BY ' . $oAgrupar . '';
		}


		if (!empty($oSucursal)) {
			$sucursal = ' AND fin.SucId = "' . $oSucursal . '"';
		}

		if (!empty($oVehiculoMarca)) {
			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				
				cli.CliCSIIncluir,
				cli.CliCSIExcluirMotivo,
				DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",
				cli.CliCSIExcluirUsuario,
				
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
				
				min.MinNombre,
				vma.VmaNombre,
				vmo.VmoNombre,
				
				min.MinId,
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTrabajoTerminado) /3600) AS FinTiempoTranscurrido,
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTallerConcluido) /3600) AS FinTiempoTranscurrido2,
				
				
				
				fta.FtaNumero,
				fac.FacId,
				fac.FacTotal,
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
				
				bta.BtaNumero,				
				bol.BolId,
				bol.BolTotal,
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				
				ein.EinVIN,
				ein.EinPlaca,
				
				
						per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					fin.FinTelefono,
					fin.FinObservacionCallcenter,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					min.MinSigla,
					
					lti.LtiAbreviatura,
					
					suc.SucNombre
		
		
			
				FROM tblfccfichaaccion fcc

					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
						LEFT JOIN tblfacfactura fac
						ON fac.AmoId = amo.AmoId
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
							
								LEFT JOIN tblbolboleta bol
								ON bol.AmoId = amo.AmoId
									LEFT JOIN tblbtaboletatalonario bta
									ON bol.BtaId = bta.BtaId
																
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
									
									
										LEFT JOIN tblvmavehiculomarca vma
										ON ein.VmaId = vma.VmaId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON ein.VmoId = vmo.VmoId
				
							LEFT JOIN tblclicliente cli
							ON	fin.CliId = cli.CliId
								LEFT JOIN tblperpersonal per
								ON fin.PerId = per.PerId
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId
												
												LEFT JOIN tbloncconcesionario onc
												ON ein.OncId = onc.OncId
												
												LEFT JOIN tblsucsucursal suc
												ON fin.SucId = suc.SucId
				WHERE 1 = 1 ' . $filtrar . $sucursal . $fecha . $vmarca . $mingreso . $agrupar . " GROUP BY fin.CliId " . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		//IF(IFNULL(fac.AmoId
		//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,

		$Respuesta['Datos'] = array();

		$InsReporteFichaIngreso = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteFichaIngreso = new $InsReporteFichaIngreso();

			$ReporteFichaIngreso->FinId = $fila['FinId'];
			$ReporteFichaIngreso->CliId = $fila['CliId'];

			$ReporteFichaIngreso->FinFecha = $fila['NFinFecha'];

			$ReporteFichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];

			$ReporteFichaIngreso->CliNombre = $fila['CliNombre'];
			$ReporteFichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];


			$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
			$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
			$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
			$ReporteFichaIngreso->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];
			$ReporteFichaIngreso->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];
			$ReporteFichaIngreso->CliCSIExcluirUsuario = $fila['CliCSIExcluirUsuario'];



			$ReporteFichaIngreso->CliTelefono = $fila['CliTelefono'];
			$ReporteFichaIngreso->CliCelular = $fila['CliCelular'];
			$ReporteFichaIngreso->CliEmail = $fila['CliEmail'];

			$ReporteFichaIngreso->MinNombre = $fila['MinNombre'];
			$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
			$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];


			$ReporteFichaIngreso->MinId = $fila['MinId'];
			$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
			$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];


			$ReporteFichaIngreso->PerNombre = $fila['PerNombre'];
			$ReporteFichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$ReporteFichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];

			$ReporteFichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
			$ReporteFichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			$ReporteFichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];

			$ReporteFichaIngreso->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
			$ReporteFichaIngreso->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];

			$ReporteFichaIngreso->FacId = $fila['FacId'];
			$ReporteFichaIngreso->FtaNumero = $fila['FtaNumero'];
			$ReporteFichaIngreso->FacFechaEmision = $fila['NFacFechaEmision'];
			$ReporteFichaIngreso->FacTotal = $fila['FacTotal'];

			$ReporteFichaIngreso->BolId = $fila['BolId'];
			$ReporteFichaIngreso->BtaNumero = $fila['BtaNumero'];
			$ReporteFichaIngreso->BolFechaEmision = $fila['NBolFechaEmision'];
			$ReporteFichaIngreso->BolTotal = $fila['BolTotal'];

			$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
			$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];

			$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
			$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
			$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];

			$ReporteFichaIngreso->FinTelefono = $fila['FinTelefono'];
			$ReporteFichaIngreso->FinObservacionCallcenter = $fila['FinObservacionCallcenter'];



			$ReporteFichaIngreso->OncCodigoDealer = $fila['OncCodigoDealer'];

			$ReporteFichaIngreso->OncNombre = $fila['OncNombre'];

			$ReporteFichaIngreso->MinSigla = $fila['MinSigla'];

			$ReporteFichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];

			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];





			if (empty($ReporteFichaIngreso->FacId)) {
				if (empty($ReporteFichaIngreso->BolId)) {
					$ReporteFichaIngreso->FinComprobanteVentaTipo = "";
				} else {
					$ReporteFichaIngreso->FinComprobanteVentaTipo = "B";
				}
			} else {
				$ReporteFichaIngreso->FinComprobanteVentaTipo = "F";
			}

			$ReporteFichaIngreso->InsMysql = NULL;

			$Respuesta['Datos'][] = $ReporteFichaIngreso;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}






	public function MtdObtenerReporteFichaIngresoPendientes($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FinId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oModalidadIngreso = NULL, $oDiaTranscurrido = NULL, $oEstado = NULL, $oTipo = NULL, $oSucursal = NULL)
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
				$fecha = ' AND DATE(fin.FinFecha)>="' . $oFechaInicio . '" AND DATE(fin.FinFecha)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fin.FinFecha)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fin.FinFecha)<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oModalidadIngreso)) {
			$mingreso = ' AND fim.MinId = "' . $oModalidadIngreso . '"';
		}



		if (!empty($oDiaTranscurrido)) {
			$dtranscurrido = ' AND  DATEDIFF(DATE(NOW()),fin.FinFecha) > ' . $oDiaTranscurrido;
		}


		if (!empty($oEstado)) {

			$elementos = explode(",", $oEstado);

			$i = 1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$estado .= '  (fin.FinEstado = ' . ($elemento) . ')';
				if ($i <> count($elementos)) {
					$estado .= ' OR ';
				}
				$i++;
			}

			$estado .= ' ) 

			)
			';
		}
		if (!empty($oTipo)) {
			$tipo = ' AND fin.FinTipo = ' . $oTipo . '';
		}

		if (!empty($oSucursal)) {
			$sucursal = ' AND fin.SucId = "' . $oSucursal . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliCSIIncluir,
				
				vma.VmaNombre,
				vmo.VmoNombre,
			
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATEDIFF(DATE(NOW()),fin.FinFecha) AS FinDiaTranscurrido,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
			
				ein.EinVIN,
				ein.EinPlaca,
				
					per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					fin.FinTelefono,
					fin.FinNota,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					lti.LtiAbreviatura,
					
					suc.SucNombre
				
					
		
		
			
				FROM tblfinfichaingreso fin

									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
									
										LEFT JOIN tblvmavehiculomarca vma
										ON ein.VmaId = vma.VmaId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON ein.VmoId = vmo.VmoId
				
							LEFT JOIN tblclicliente cli
							ON	fin.CliId = cli.CliId
								LEFT JOIN tblperpersonal per
								ON fin.PerId = per.PerId
									LEFT JOIN tbllticlientetipo lti
									ON cli.LtiId = lti.LtiId
									
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId
												
												LEFT JOIN tbloncconcesionario onc
												ON ein.OncId = onc.OncId
												
												LEFT JOIN tblsucsucursal suc
												ON fin.SucId = suc.SucId
												
												
				WHERE 1 = 1 ' . $filtrar . $fecha . $mingreso . $sucursal . $agrupar . $tipo . $estado . $dtranscurrido . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		//IF(IFNULL(fac.AmoId
		//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,

		$Respuesta['Datos'] = array();

		$InsReporteFichaIngreso = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteFichaIngreso = new $InsReporteFichaIngreso();

			$ReporteFichaIngreso->FinId = $fila['FinId'];
			$ReporteFichaIngreso->CliId = $fila['CliId'];

			$ReporteFichaIngreso->FinFecha = $fila['NFinFecha'];

			$ReporteFichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];

			$ReporteFichaIngreso->CliNombre = $fila['CliNombre'];
			$ReporteFichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$ReporteFichaIngreso->FinDiaTranscurrido = $fila['FinDiaTranscurrido'];


			$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
			$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
			$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];


			$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
			$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];

			$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
			$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];


			$ReporteFichaIngreso->PerNombre = $fila['PerNombre'];
			$ReporteFichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$ReporteFichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$ReporteFichaIngreso->FinDiaTranscurrido = $fila['FinDiaTranscurrido'];

			$ReporteFichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
			$ReporteFichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			$ReporteFichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];

			$ReporteFichaIngreso->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
			$ReporteFichaIngreso->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];



			$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
			$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];

			$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
			$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
			$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];

			$ReporteFichaIngreso->FinTelefono = $fila['FinTelefono'];
			$ReporteFichaIngreso->FinNota = $fila['FinNota'];

			$ReporteFichaIngreso->OncCodigoDealer = $fila['OncCodigoDealer'];
			$ReporteFichaIngreso->OncNombre = $fila['OncNombre'];

			$ReporteFichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];

			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];


			$ReporteFichaIngreso->InsMysql = NULL;

			$Respuesta['Datos'][] = $ReporteFichaIngreso;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}




	public function MtdObtenerReporteFichaIngresoSeguimientoLlamadas($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FinId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oCliente = NULL, $oFichaIngreso = NULL, $oDiasTranscurridos = 0, $oSucursal = NULL, $oModalidadIngreso = NULL, $oConLlamada = false, $oVehiculoMarca = NULL, $oIncluirCSI = NULL, $oDiasTranscurridosTipo = "Mayor", $oFecha = "FinFecha")
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
				$fecha = ' AND DATE(' . $oFecha . ')>="' . $oFechaInicio . '" AND DATE(' . $oFecha . ')<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(' . $oFecha . ')>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(' . $oFecha . ')<="' . $oFechaFin . '"';
			}
		}


		if (!empty($oCliente)) {
			$cliente = ' AND cli.CliId = "' . $oCliente . '"';
		}

		if (!empty($oFichaIngreso)) {
			$fingreso = ' AND fin.FinId = "' . $oFichaIngreso . '"';
		}



		if (!empty($oDiasTranscurridos)) {

			switch ($oDiasTranscurridosTipo) {

				case "Mayor":
					$dtranscurrido = ' AND DATEDIFF(DATE("' . (empty($oFechaFin) ? date("Y-m-d") : $oFechaFin) . '"),' . $oFecha . ') > ' . $oDiasTranscurridos . ' ';
					break;

				case "Menor":
					$dtranscurrido = ' AND DATEDIFF(DATE("' . (empty($oFechaFin) ? date("Y-m-d") : $oFechaFin) . '"),' . $oFecha . ') < ' . $oDiasTranscurridos . ' ';
					break;

				case "MayorIgual":
					$dtranscurrido = ' AND DATEDIFF(DATE("' . (empty($oFechaFin) ? date("Y-m-d") : $oFechaFin) . '"),' . $oFecha . ') >= ' . $oDiasTranscurridos . ' ';
					break;

				case "MenorIgual":
					$dtranscurrido = ' AND DATEDIFF(DATE("' . (empty($oFechaFin) ? date("Y-m-d") : $oFechaFin) . '"),' . $oFecha . ') <= ' . $oDiasTranscurridos . ' ';
					break;

				case "Igual":
					$dtranscurrido = ' AND DATEDIFF(DATE("' . (empty($oFechaFin) ? date("Y-m-d") : $oFechaFin) . '"),' . $oFecha . ') = ' . $oDiasTranscurridos . ' ';
					break;

				default:
					$dtranscurrido = ' AND DATEDIFF(DATE("' . (empty($oFechaFin) ? date("Y-m-d") : $oFechaFin) . '"),' . $oFecha . ') > ' . $oDiasTranscurridos . ' ';

					break;
			}
		}

		if (!empty($oSucursal)) {
			$sucursal = ' AND fin.SucId = "' . $oSucursal . '"';
		}

		if (!empty($oModalidadIngreso)) {
			//cli.LtiId = "'.($elemento).'"
			$elementos = explode(",", $oModalidadIngreso);

			$i = 1;
			$mingreso .= ' AND (
				(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$mingreso .= '  (
					
						EXISTS (
							SELECT fim.FimId
								FROM tblfimfichaingresomodalidad fim
								WHERE fim.MinId = "' . $elemento . '"
								AND fim.FinId = fin.FinId
							LIMIT 1
						)
					
					)';
				if ($i <> count($elementos)) {
					$mingreso .= ' OR ';
				}
				$i++;
			}

			$mingreso .= ' ) 
				)
				';
		}

		if ($oConLlamada) {

			$cllamada = ' 	AND NOT EXISTS(
						SELECT 
						fll.FllId
						FROM tblfllfichaingresollamada fll
						WHERE fll.FinId = fin.FinId
						AND fll.FllEstado = 3
					)
				';
		}


		if ($oVehiculoMarca) {

			$vmarca = ' 	
					AND vmo.VmaId = "' . $oVehiculoMarca . '"
				';
		}



		if ($oIncluirCSI) {

			$icsi = ' 	
					AND cli.CliCSIIncluir = "' . $oIncluirCSI . '"
				';
		}


		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fin.SucId,
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliCSIIncluir,
				
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
			
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
			
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATEDIFF(DATE(NOW()),fin.FinFecha) AS FinDiaTranscurrido,
				DATEDIFF(DATE("' . (empty($oFechaFin) ? date("Y-m-d") : $oFechaFin) . '"),fin.FinTiempoTrabajoTerminado) AS FinDiaTranscurridoTerminado,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTrabajoTerminado) /3600) AS FinTiempoTranscurrido,
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTallerConcluido) /3600) AS FinTiempoTranscurrido2,
								
				ein.EinVIN,
				ein.EinPlaca,
				
				ein.EinColor,
				
				
					per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					suc.SucNombre,
					
					DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",	
					cli.CliCSIExcluirUsuario,
					cli.CliCSIExcluirMotivo
					
					
					
		
							FROM tblfinfichaingreso fin
							LEFT JOIN tblclicliente cli
							ON fin.CliId = cli.CliId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
								LEFT JOIN tblperpersonal per2
								ON fin.PerIdAsesor = per2.PerId
									LEFT JOIN tblperpersonal per
									ON fin.PerId = per.PerId
										LEFT JOIN tblsucsucursal suc
										ON fin.SucId = suc.SucId
												
				WHERE 
				 1 = 1
				 
				

				 ' . $filtrar . $fecha . $fingreso . $sucursal . $cllamada . $icsi . $vmarca . $csiincluir . $mingreso . $sucursal . $cliente . $dtranscurrido . $agrupar . $orden . "  " . $paginacion;

		/* AND
				
				EXISTS(
				
					SELECT 
					fim.FimId 
					FROM tblfimfichaingresomodalidad fim
					WHERE fim.FinId = fin.FinId 
					AND (fim.MinId = "MIN-10003" OR fim.MinId = "MIN-10019" OR fim.MinId = "MIN-10020" OR fim.MinId = "MIN-10021")
				
				
				)*/

		/*
				AND NOT EXISTS(
					SELECT 
					fll.FllId
					FROM tblfllfichaingresollamada fll
					WHERE fll.FinId = fin.FinId
					AND fll.FllEstado = 3
				)
				*/

		$resultado = $this->InsMysql->MtdConsultar($sql);

		//IF(IFNULL(fac.AmoId
		//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,

		$Respuesta['Datos'] = array();

		$InsReporteFichaIngreso = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteFichaIngreso = new $InsReporteFichaIngreso();

			$ReporteFichaIngreso->SucId = $fila['SucId'];

			$ReporteFichaIngreso->FinId = $fila['FinId'];
			$ReporteFichaIngreso->CliId = $fila['CliId'];

			$ReporteFichaIngreso->FinFecha = $fila['NFinFecha'];




			$ReporteFichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];

			$ReporteFichaIngreso->CliNombre = $fila['CliNombre'];
			$ReporteFichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];

			$ReporteFichaIngreso->FinDiaTranscurrido = $fila['FinDiaTranscurrido'];
			$ReporteFichaIngreso->FinDiaTranscurridoTerminado = $fila['FinDiaTranscurridoTerminado'];


			$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
			$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
			$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];

			$ReporteFichaIngreso->CliTelefono = $fila['CliTelefono'];
			$ReporteFichaIngreso->CliCelular = $fila['CliCelular'];
			$ReporteFichaIngreso->CliEmail = $fila['CliEmail'];

			$ReporteFichaIngreso->CliWhatsapp = "51" . $fila['CliCelular'];

			$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
			$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];
			$ReporteFichaIngreso->VveNombre = $fila['VveNombre'];



			$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
			$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];


			$ReporteFichaIngreso->PerNombre = $fila['PerNombre'];
			$ReporteFichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$ReporteFichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];

			$ReporteFichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
			$ReporteFichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			$ReporteFichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];

			$ReporteFichaIngreso->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
			$ReporteFichaIngreso->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];


			$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
			$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];
			$ReporteFichaIngreso->EinColor = $fila['EinColor'];




			$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
			$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
			$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];

			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];

			$ReporteFichaIngreso->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];
			$ReporteFichaIngreso->CliCSIExcluirUsuario = $fila['CliCSIExcluirUsuario'];
			$ReporteFichaIngreso->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];





			$ReporteFichaIngreso->InsMysql = NULL;

			$Respuesta['Datos'][] = $ReporteFichaIngreso;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}






	public function MtdObtenerReporteFichaIngresoPromedioTiempoTallerConcluido($oAno = NULL, $oMes = NULL, $oVehiculoMarca = NULL, $oFichaIngresoModalidadIngreso = NULL, $oSucursal = NULL, $oDia = NULL)
	{

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fin.FinFecha) = "' . $oAno . '" ';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fin.FinFecha) = "' . $oMes . '" ';
		}


		if (!empty($oDia)) {
			$dia = ' AND DAY(fin.FinFecha) = "' . $oDia . '" ';
		}


		if (!empty($oVehiculoMarca)) {

			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '" ';
		}


		if (!empty($oSucursal)) {

			$sucursal = ' AND fin.SucId = "' . $oSucursal . '" ';
		}

		if (!empty($oFichaIngresoModalidadIngreso)) {

			$mingreso = ' AND 
			EXISTS(
			SELECT * FROM tblfimfichaingresomodalidad fim
			WHERE fim.FinId = fin.FinId
			AND fim.MinId = "' . $oFichaIngresoModalidadIngreso . '"
			)
			 ';
		}

		$sql = 'SELECT
		AVG(
		(	

	(
		(
			IF(

				(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)>1,

				TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)),

					IF(
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido))>25200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)) - 7200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido))

					)

				) 
			)/60

		)/60

	)
		) AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE  fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTallerConcluido IS NOT NULL ' . $vmarca . $sucursal . $dia . $ptipo . $ano . $mes . $mingreso . $vmarca . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		//settype($fila['RESULTADO'],"float");

		//return $fila['RESULTADO'];		

		//$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);

		//return $hoursminsandsecs;		
		return $fila['RESULTADO'];
	}

	public function MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminado($oAno = NULL, $oMes = NULL, $oVehiculoMarca = NULL, $oFichaIngresoModalidadIngreso = NULL)
	{

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fin.FinFecha) = (' . $oAno . ') ';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fin.FinFecha) = ' . $oMes . ' ';
		}


		if (!empty($oVehiculoMarca)) {

			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '" ';
		}

		if (!empty($oVehiculoMarca)) {

			$mingreso = ' AND 
			EXISTS(
			SELECT * FROM tblfimfichaingresomodalidad fim
			WHERE fim.FinId = fin.FinId
			AND fim.MinId = "' . $oFichaIngresoModalidadIngreso . '"
			)
			 ';
		}

		$sql = 'SELECT
				AVG(
		(	

	(
		(
			IF(

				(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)>1,

				TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)),

					IF(
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))>25200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)) - 7200,
						(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))

					)

				) 
			)/60

		)/60

	)
		) AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE  fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTrabajoTerminado IS NOT NULL ' . $vmarca . $ptipo . $ano . $mes . $mingreso . $vmarca . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		//settype($fila['RESULTADO'],"float");

		//return $fila['RESULTADO'];		

		//	$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);

		//return $hoursminsandsecs;		
		return $fila['RESULTADO'];
	}






	public function MtdObtenerReporteFichaIngresoPromedioTiempoTrabajoTerminadoBruto($oAno = NULL, $oMes = NULL, $oVehiculoMarca = NULL, $oFichaIngresoModalidadIngreso = NULL, $oSucursal = NULL, $oDia = NULL)
	{

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fin.FinFecha) = (' . $oAno . ') ';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fin.FinFecha) = ' . $oMes . ' ';
		}


		if (!empty($oDia)) {
			$dia = ' AND DAY(fin.FinFecha) = ' . $oDia . ' ';
		}


		if (!empty($oSucursal)) {

			$sucursal = ' AND fin.SucId = "' . $oSucursal . '" ';
		}

		if (!empty($oFichaIngresoModalidadIngreso)) {

			$mingreso = ' AND 
			EXISTS(
			SELECT * FROM tblfimfichaingresomodalidad fim
			WHERE fim.FinId = fin.FinId
			AND fim.MinId = "' . $oFichaIngresoModalidadIngreso . '"
			)
			 ';
		}

		if (!empty($oVehiculoMarca)) {

			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '" ';
		}


		$sql = 'SELECT
		
		AVG(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))
		
		 AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE  fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTrabajoTerminado IS NOT NULL ' . $vmarca . $sucursal . $dia . $ptipo . $ano . $mes . $mingreso . $vmarca . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		//settype($fila['RESULTADO'],"float");

		//return $fila['RESULTADO'];		

		//	$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);

		//return $hoursminsandsecs;		
		return $fila['RESULTADO'];
	}









	public function MtdObtenerReporteFichaIngresoSumaTiempoTrabajoTerminado($oAno = NULL, $oMes = NULL, $oVehiculoMarca = NULL, $oFichaIngresoModalidadIngreso = NULL)
	{

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fin.FinFecha) = (' . $oAno . ') ';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fin.FinFecha) = ' . $oMes . ' ';
		}


		if (!empty($oVehiculoMarca)) {

			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '" ';
		}

		if (!empty($oVehiculoMarca)) {

			$mingreso = ' AND 
				EXISTS(
				SELECT * FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = fin.FinId
				AND fim.MinId = "' . $oFichaIngresoModalidadIngreso . '"
			)
			 ';
		}

		$sql = 'SELECT
			SUM(	

					(
						(
								IF(
					
									(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)>1,
					
									TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)/86400)),
					
										IF(
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado))>25200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)) - 7200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTrabajoTerminado)
										)
					
								)
					
						) 
					)/60
					
				)/60

		) AS "RESULTADO"
		
		
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE   fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTrabajoTerminado IS NOT NULL ' . $vmarca . $ptipo . $ano . $mes . $mingreso . $vmarca . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		///settype($fila['RESULTADO'],"float");
		$hoursminsandsecs = date('H:i:s', $fila['RESULTADO']);

		return $hoursminsandsecs;
	}





	//OK
	public function MtdObtenerReporteFichaIngresoSumaTiempoConcluido($oAno = NULL, $oMes = NULL, $oVehiculoMarca = NULL, $oFichaIngresoModalidadIngreso = NULL, $oSucursal = NULL, $oDia = NULL)
	{

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fin.FinFecha) = (' . $oAno . ') ';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fin.FinFecha) = ' . $oMes . ' ';
		}


		if (!empty($oDia)) {
			$dia = ' AND DAY(fin.FinFecha) = ' . $oDia . ' ';
		}


		if (!empty($oVehiculoMarca)) {

			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '" ';
		}

		if (!empty($oSucursal)) {

			$sucursal = ' AND fin.SucId = "' . $oSucursal . '" ';
		}


		if (!empty($oFichaIngresoModalidadIngreso)) {

			$mingreso = ' AND 
				EXISTS(
				SELECT * FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = fin.FinId
				AND fim.MinId = "' . $oFichaIngresoModalidadIngreso . '"
			)
			 ';
		}

		$sql = 'SELECT
		
		SUM(	

					(
						(
								IF(
					
									(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)>1,
					
									TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido) - (50400) * ((TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)/86400)),
					
										IF(
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido))>25200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)) - 7200,
											(TIMESTAMPDIFF(SECOND, fin.FinTiempoCreacion, fin.FinTiempoTallerConcluido)
										)
					
								)
					
						) 
					)/60
					
				)/60

		) AS "RESULTADO"
		
		FROM tblfinfichaingreso fin
			LEFT JOIN tbleinvehiculoingreso ein
			ON fin.EinId = ein.EinId
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
					LEFT JOIN tblvmovehiculomodelo vmo
					ON vve.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
		
		WHERE   fin.FinTiempoCreacion IS NOT NULL
		AND fin.FinTiempoTallerConcluido IS NOT NULL ' . $vmarca . $sucursal . $dia . $sucursal . $ptipo . $ano . $mes . $mingreso . $vmarca . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		///settype($fila['RESULTADO'],"float");
		//	$hoursminsandsecs = date('H:i:s',$fila['RESULTADO']);

		//return $hoursminsandsecs;	
		return $fila['RESULTADO'];
	}






	public function MtdObtenerFichaIngresoGastos($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FigId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFichaIngreso = NULL, $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oMoneda = NULL, $oFecha = "GasFecha", $oSucursal = NULL)
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



			$filtrar .= '   ';


			$filtrar .= '  ) ';
		}



		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oFichaIngreso)) {
			$fingreso = ' AND fig.FinId = "' . $oFichaIngreso . '"';
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(gas.' . $oFecha . ')>="' . $oFechaInicio . '" AND DATE(gas.' . $oFecha . ')<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(gas.' . $oFecha . ')>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(gas.' . $oFecha . ')<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oEstado)) {
			$estado = ' AND gas.GasEstado = ' . $oEstado;
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND gas.MonId = "' . $oMoneda . '"';
		}

		if (!empty($oSucursal)) {
			$sucursal = ' AND gas.SucId = "' . $oSucursal . '"';
		}

		$sql = '
		
		
			SELECT
			SQL_CALC_FOUND_ROWS 
			fig.FigId,			
			fig.FinId,
			fig.GasId,
			
			fig.FigEstado,
			DATE_FORMAT(fig.FigTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFigTiempoCreacion",
	        DATE_FORMAT(fig.FigTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFigTiempoModificacion",
			
			gas.GasComprobanteNumero,
			DATE_FORMAT(gas.GasComprobanteFecha, "%d/%m/%Y") AS "NGasComprobanteFecha",
			gas.GasTotal,
			gas.GasTipoCambio,
			
			gas.GasConcepto,
			gas.MonId,
			
			mon.MonSimbolo,
			mon.MonNombre,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,
			
			DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
			
			suc.SucNombre,
			
			ein.EinPlaca,
			ein.EinVIN,
			ein.EinColor,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre,
			
			
			per2.PerNombre AS PerNombreAsesor,
			per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
			per2.PerApellidoMaterno AS PerApellidoMaternoAsesor
			
			
			
			FROM tblfigfichaingresogasto fig
				
				LEFT JOIN tblgasgasto gas
				ON fig.GasId = gas.GasId
					LEFT JOIN tblprvproveedor prv
					ON gas.PrvId = prv.PrvId
						LEFT JOIN tblmonmoneda mon
						ON gas.MonId = mon.MonId
							LEFT JOIN tblfinfichaingreso fin
							ON fig.FinId = fin.FinId
								LEFT JOIN tblsucsucursal suc
								ON fin.SucId = suc.SucId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
												LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId
													LEFT JOIN tblperpersonal per2
													ON fin.PerIdAsesor = per2.PerId
													
			WHERE  1 = 1 ' . $fingreso . $estado . $filtrar . $sucursal . $moneda . $sucursal . $$orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsFichaIngresoGasto = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$FichaIngresoGasto = new $InsFichaIngresoGasto();
			$FichaIngresoGasto->FigId = $fila['FigId'];
			$FichaIngresoGasto->FinId = $fila['FinId'];
			$FichaIngresoGasto->GasId = $fila['GasId'];

			$FichaIngresoGasto->FigEstado = $fila['FigEstado'];
			$FichaIngresoGasto->FigTiempoCreacion = $fila['NFigTiempoCreacion'];
			$FichaIngresoGasto->FigTiempoModificacion = $fila['NFigTiempoModificacion'];

			$FichaIngresoGasto->GasComprobanteNumero = $fila['GasComprobanteNumero'];
			$FichaIngresoGasto->GasComprobanteFecha = $fila['NGasComprobanteFecha'];
			$FichaIngresoGasto->GasTotal = $fila['GasTotal'];
			$FichaIngresoGasto->GasTipoCambio = $fila['GasTipoCambio'];


			$FichaIngresoGasto->GasConcepto = $fila['GasConcepto'];
			$FichaIngresoGasto->MonId = $fila['MonId'];

			$FichaIngresoGasto->MonSimbolo = $fila['MonSimbolo'];
			$FichaIngresoGasto->MonNombre = $fila['MonNombre'];

			$FichaIngresoGasto->PrvNombre = $fila['PrvNombre'];
			$FichaIngresoGasto->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$FichaIngresoGasto->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];

			$FichaIngresoGasto->FinFecha = $fila['NFinFecha'];

			$FichaIngresoGasto->SucNombre = $fila['SucNombre'];


			$FichaIngresoGasto->EinPlaca = $fila['EinPlaca'];
			$FichaIngresoGasto->EinVIN = $fila['EinVIN'];
			$FichaIngresoGasto->EinColor = $fila['EinColor'];

			$FichaIngresoGasto->VmaNombre = $fila['VmaNombre'];
			$FichaIngresoGasto->VmoNombre = $fila['VmoNombre'];
			$FichaIngresoGasto->VveNombre = $fila['VveNombre'];


			$FichaIngresoGasto->PerNombreAsesor = $fila['PerNombreAsesor'];
			$FichaIngresoGasto->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
			$FichaIngresoGasto->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];



			$FichaIngresoGasto->InsMysql = NULL;
			$Respuesta['Datos'][] = $FichaIngresoGasto;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}





	/*
	NUEVO REPORTE
	Reporte de Ventas x Taller
	22/11/2025
*/
	public function MtdObtenerReporteFichaIngresosVentaxTaller(
		$oCampo = NULL,
		$oCondicion = "contiene",
		$oFiltro = NULL,
		$oOrden = 'FinId',
		$oSentido = 'Desc',
		$oPaginacion = '0,10',
		$oFechaInicio = NULL,
		$oFechaFin = NULL,
		$oModalidadIngreso = NULL,
		$oAgrupar = NULL,
		$oCSIIncluir = NULL,
		$oCliente = NULL,
		$oUnicos = false,
		$oVehiculoMarca = NULL,
		$oModalidadIngresoUnico = false,
		$oSucursal = NULL,
		$oFecha = "FinTiempoTrabajoTerminado",
		$oComprobanteFechaInicio = NULL,
		$oComprobanteFechaFin = NULL,
		$oPersonal = NULL,
		$oVehiculoModelo = NULL
	) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fechainicio = '';
		$fechafin = '';
		$modalidadIngreso = '';
		$agrupar = '';
		$csiIncluir = '';
		$cliente = '';
		$unicos = '';
		$vehiculoMarca = '';
		$modalidadIngresoUnico = '';
		$sucursal = '';
		$fecha = '';
		$comprobanteFechaInicio = '';
		$comprobanteFechaFin = '';
		$personal = '';
		$vehiculoModelo = '';

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
				$fecha = ' AND DATE(fin.' . $oFecha . ')>="' . $oFechaInicio . '" AND DATE(fin.' . $oFecha . ')<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fin.' . $oFecha . ')>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fin.' . $oFecha . ')<="' . $oFechaFin . '"';
			}
		}




		if (!empty($oComprobanteFechaInicio)) {

			if (!empty($oComprobanteFechaFin)) {

				$cfecha = ' AND (DATE(fac.FacFechaEmision)>="' . $oComprobanteFechaInicio . '" AND DATE(fac.FacFechaEmision)<="' . $oComprobanteFechaFin . '" 
					OR DATE(bol.BolFechaEmision)>="' . $oComprobanteFechaInicio . '" AND DATE(bol.BolFechaEmision)<="' . $oComprobanteFechaFin . '")';
			} else {

				$cfecha = ' AND (DATE(fac.FacFechaEmision)>="' . $oComprobanteFechaInicio . '" OR DATE(bol.BolFechaEmision)>="' . $oComprobanteFechaInicio . '")';
			}
		} else {
			if (!empty($oComprobanteFechaFin)) {
				$cfecha = ' AND (DATE(fac.FacFechaEmision)<="' . $oComprobanteFechaInicio . '" OR DATE(bol.BolFechaEmision)<="' . $oComprobanteFechaInicio . '")';
			}
		}

		/*if(!empty($oModalidadIngreso)){
				$mingreso = ' AND fim.MinId = "'.$oModalidadIngreso.'"';		
			}*/

		if (!empty($oModalidadIngreso)) {

			if ($oModalidadIngresoUnico) {

				$mingreso .= ' AND fim.MinId = "' . $oModalidadIngreso . '"';
			} else {



				//cli.LtiId = "'.($elemento).'"


				$elementos = explode(",", $oModalidadIngreso);

				$i = 1;
				$mingreso .= ' AND (
						(';
				$elementos = array_filter($elementos);
				foreach ($elementos as $elemento) {
					$mingreso .= '  (
							
								 fim.MinId = "' . $elemento . '"
							
							)';
					if ($i <> count($elementos)) {
						$mingreso .= ' OR ';
					}
					$i++;
				}

				$mingreso .= ' ) 
						)
						';

				/*$elementos = explode(",",$oModalidadIngreso);
			
						$i=1;
						$mingreso .= ' AND (
						(';
						$elementos = array_filter($elementos);
						foreach($elementos as $elemento){
							$mingreso .= '  (
							
								EXISTS (
									SELECT fim.FimId
										FROM tblfimfichaingresomodalidad fim
										WHERE fim.MinId = "'.$elemento.'"
										AND fim.FinId = fin.FinId
									LIMIT 1
								)
							
							)';
							if($i<>count($elementos)){						
								$mingreso .= ' OR ';	
							}
						$i++;		
						}
			
						$mingreso .= ' ) 
						)
						';*/
			}
		}




		if (!empty($oAgrupar)) {
			$agrupar = ' GROUP BY ' . $oAgrupar . '';
		}

		if (!empty($oCSIIncluir)) {
			$csiincluir = ' AND cli.CliCSIIncluir = ' . $oCSIIncluir . '';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND cli.CliId = "' . $oCliente . '"';
		}


		if (($oUnicos)) {
			$unicos = 'DISTINCT (fin.FinId),';
		} else {
			$unicos = ' (fin.FinId),';
		}

		if (!empty($oVehiculoMarca)) {
			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '"';
		}


		if (!empty($oVehiculoModelo)) {
			$vmodelo = ' AND vve.VmoId = "' . $oVehiculoModelo . '"';
		}


		if (!empty($oSucursal)) {
			$sucursal = ' AND fin.SucId = "' . $oSucursal . '"';
		}


		if (!empty($oPersonal)) {
			$personal = ' AND fin.PerId = "' . $oPersonal . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				' . $unicos . '
				
				fin.FinId,
				fin.CliId,
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				fin.FinHora,

				DATE_FORMAT(fin.FinFechaEntrega, "%d/%m/%Y") AS "NFinFechaEntrega",
				fin.FinHoraEntrega,
				 
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliTelefono,
				cli.CliCelular,
				
				cli.CliCelular,
				
				cli.CliEmail,
				
				cli.CliContactoEmail1,
				cli.CliContactoEmail2,
				cli.CliContactoEmail3,

				cli.CliEmailFacturacion,
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDireccion,
				
				cli.CliCSIIncluir,
				cli.CliCSIExcluirMotivo,
				DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",
				
				min.MinNombre,
				vma.VmaNombre,
				vmo.VmoNombre,
				
				min.MinId,
				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				
				per.PerNumeroDocumento,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTrabajoTerminado) /3600) AS FinTiempoTranscurrido,
				(TIMESTAMPDIFF(SECOND, FinTiempoTallerRevisando, FinTiempoTallerConcluido) /3600) AS FinTiempoTranscurrido2,
				
				
				
				fta.FtaNumero,
				fac.FacId,
				fac.FacTotal,
				fac.FacSubTotal,
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
				mon.MonNombre AS FacMoneda,
				fac.FacTipoCambio,
				
				bta.BtaNumero,				
				bol.BolId,
				bol.BolTotal,
				bol.BolSubTotal,
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				mon2.MonNombre AS BolMoneda,
				bol.BolTipoCambio,
				
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND (fde.FdeDescripcion LIKE "%MANO DE OBRA%" OR fde.FdeUnidadMedida LIKE "%ZZ%")
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						),
							IFNULL(
							
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							AND (bde.BdeDescripcion LIKE "%MANO DE OBRA%" OR bde.BdeUnidadMedida LIKE "%ZZ%")
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiManoObra,
				
				
				
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND fde.FdeDescripcion NOT LIKE "%MANO DE OBRA%"
						AND fde.FdeUnidadMedida = "UND"
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						)
						,
							IFNULL(
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							AND bde.BdeDescripcion NOT LIKE "%MANO DE OBRA%"
							AND bde.BdeUnidadMedida = "UND"
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiRepuestos,
				
			 
				
				(
				
					IFNULL(
						(
						(
						SELECT
						SUM(fde.FdeImporte)
						FROM tblfdefacturadetalle fde
						WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId
						AND fde.FdeDescripcion NOT LIKE "%MANO DE OBRA%"
						AND fde.FdeUnidadMedida <> "UND"
						LIMIT 1
						)/IF(fac.FacIncluyeImpuesto=1,((fac.FacPorcentajeImpuestoVenta)/100)+1,1)
						),
							IFNULL(
							(
							(
							SELECT
							SUM(bde.BdeImporte)
							FROM tblbdeboletadetalle bde
							WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId
							-- AND (bde.BdeDescripcion NOT LIKE "%MANO DE OBRA%" AND bde.BdeUnidadMedida NOT LIKE "%ZZ%")
							AND bde.BdeUnidadMedida <> "UND"
							AND bde.BdeUnidadMedida <> "ZZ"
							AND bde.BdeUnidadMedida <> ""
							LIMIT 1
							)/IF(1=1,((bol.BolPorcentajeImpuestoVenta)/100)+1,1)
							)
							
							,0)
					)
					
				) AS RfiLubricantes,
				
			
				
				ein.EinVIN,
				ein.EinPlaca,
				
				
						per2.PerNombre AS PerNombreAsesor,
					per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
					per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
					
					fin.FinTelefono,
					fin.FinTallerObservacion,
					fin.FinSalidaObservacion,
					
					onc.OncCodigoDealer,
					onc.OncNombre,
					
					min.MinSigla,
					
					
					amo.AmoTotal,
					lti.LtiNombre,
					lti.LtiAbreviatura,
					fcc.FccFacturable,
					fcc.FccCausa,
					fcc.FccId,
					
					suc.SucNombre,
					suc.SucDepartamento,
					suc.SucDistrito,
					fin.FinVehiculoKilometraje,
					
					fin.FinIndicacionTecnico,
					
					cli.CliNumeroDocumento,
					
					fin.FinNota,
					fin.FinObservacion,
					
					ein.EinAnoModelo,
					
					suc.SucNombre
					
		
			
				FROM tblfccfichaaccion fcc

					LEFT JOIN tblamoalmacenmovimiento amo
					ON amo.FccId = fcc.FccId
					
						LEFT JOIN tblfacfactura fac
						ON fac.AmoId = amo.AmoId
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
								LEFT JOIN tblmonmoneda mon
								ON fac.MonId = mon.MonId

								LEFT JOIN tblbolboleta bol
								ON bol.AmoId = amo.AmoId
									LEFT JOIN tblbtaboletatalonario bta
									ON bol.BtaId = bta.BtaId
										LEFT JOIN tblmonmoneda mon2
										ON bol.MonId = mon2.MonId
																
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId = fin.FinId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
									
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
										
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
												LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId
											
				
							LEFT JOIN tblclicliente cli
							ON	fin.CliId = cli.CliId
								LEFT JOIN tbllticlientetipo lti
								ON cli.LtiId = lti.LtiId
								
								LEFT JOIN tblperpersonal per
								ON fin.PerId = per.PerId
							
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId
												
												LEFT JOIN tbloncconcesionario onc
												ON ein.OncId = onc.OncId
												
												LEFT JOIN tblsucsucursal suc
												ON fin.SucId = suc.SucId
				WHERE fin.FinTipo = 1 ' . $filtrar . $fecha . $mingreso . $sucursal . $personal . $csiincluir . $vmarca . $vmodelo . $personal . $cfecha . $cliente . $agrupar . $orden . "  " . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		//IF(IFNULL(fac.AmoId
		//				,IFNULL(bol.AmoId,"F")) AS FinComprobanteVentaTipo,

		$Respuesta['Datos'] = array();

		$InsReporteFichaIngreso = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteFichaIngreso = new $InsReporteFichaIngreso();

			$ReporteFichaIngreso->FinId = $fila['FinId'];
			$ReporteFichaIngreso->CliId = $fila['CliId'];

			$ReporteFichaIngreso->FinFecha = $fila['NFinFecha'];
			$ReporteFichaIngreso->FinHora = $fila['FinHora'];

			$ReporteFichaIngreso->FinFechaEntrega = $fila['NFinFechaEntrega'];
			$ReporteFichaIngreso->FinHoraEntrega = $fila['FinHoraEntrega'];

			$ReporteFichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];

			$ReporteFichaIngreso->CliNombre = $fila['CliNombre'];
			$ReporteFichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$ReporteFichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];

			$ReporteFichaIngreso->CliTelefono = $fila['CliTelefono'];
			$ReporteFichaIngreso->CliCelular = $fila['CliCelular'];
			$ReporteFichaIngreso->CliDireccion = $fila['CliDireccion'];

			$ReporteFichaIngreso->CliEmail = $fila['CliEmail'];

			$ReporteFichaIngreso->CliContactoEmail1 = $fila['CliContactoEmail1'];
			$ReporteFichaIngreso->CliContactoEmail2 = $fila['CliContactoEmail2'];
			$ReporteFichaIngreso->CliContactoEmail3 = $fila['CliContactoEmail3'];

			$ReporteFichaIngreso->CliEmailFacturacion = $fila['CliEmailFacturacion'];


			$ReporteFichaIngreso->CliDepartamento = $fila['CliDepartamento'];
			$ReporteFichaIngreso->CliProvincia = $fila['CliProvincia'];
			$ReporteFichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];
			$ReporteFichaIngreso->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];
			$ReporteFichaIngreso->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];



			$ReporteFichaIngreso->MinNombre = $fila['MinNombre'];
			$ReporteFichaIngreso->VmaNombre = $fila['VmaNombre'];
			$ReporteFichaIngreso->VmoNombre = $fila['VmoNombre'];


			$ReporteFichaIngreso->MinId = $fila['MinId'];
			$ReporteFichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
			$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];

			$ReporteFichaIngreso->PerNumeroDocumento = $fila['PerNumeroDocumento'];
			$ReporteFichaIngreso->PerNombre = $fila['PerNombre'];
			$ReporteFichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$ReporteFichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];

			$ReporteFichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
			$ReporteFichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];
			$ReporteFichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];

			$ReporteFichaIngreso->FinTiempoTranscurrido = $fila['FinTiempoTranscurrido'];
			$ReporteFichaIngreso->FinTiempoTranscurrido2 = $fila['FinTiempoTranscurrido2'];

			$ReporteFichaIngreso->FacId = $fila['FacId'];
			$ReporteFichaIngreso->FtaNumero = $fila['FtaNumero'];
			$ReporteFichaIngreso->FacFechaEmision = $fila['NFacFechaEmision'];
			$ReporteFichaIngreso->FacTotal = $fila['FacTotal'];
			$ReporteFichaIngreso->FacSubTotal = $fila['FacSubTotal'];
			$ReporteFichaIngreso->FacMoneda = $fila['FacMoneda'];
			$ReporteFichaIngreso->FacTipoCambio = $fila['FacTipoCambio'];



			$ReporteFichaIngreso->BolId = $fila['BolId'];
			$ReporteFichaIngreso->BtaNumero = $fila['BtaNumero'];
			$ReporteFichaIngreso->BolFechaEmision = $fila['NBolFechaEmision'];
			$ReporteFichaIngreso->BolTotal = $fila['BolTotal'];
			$ReporteFichaIngreso->BolSubTotal = $fila['BolSubTotal'];
			$ReporteFichaIngreso->BolMoneda = $fila['BolMoneda'];
			$ReporteFichaIngreso->BolTipoCambio = $fila['BolTipoCambio'];

			$ReporteFichaIngreso->EinVIN = $fila['EinVIN'];
			$ReporteFichaIngreso->EinPlaca = $fila['EinPlaca'];

			$ReporteFichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
			$ReporteFichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
			$ReporteFichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];

			$ReporteFichaIngreso->FinTelefono = $fila['FinTelefono'];
			$ReporteFichaIngreso->FinTallerObservacion = $fila['FinTallerObservacion'];
			$ReporteFichaIngreso->FinSalidaObservacion = $fila['FinSalidaObservacion'];

			$ReporteFichaIngreso->OncCodigoDealer = $fila['OncCodigoDealer'];

			$ReporteFichaIngreso->OncNombre = $fila['OncNombre'];

			$ReporteFichaIngreso->MinSigla = $fila['MinSigla'];

			if (empty($ReporteFichaIngreso->FacId)) {
				if (empty($ReporteFichaIngreso->BolId)) {
					$ReporteFichaIngreso->FinComprobanteVentaTipo = "";
				} else {
					$ReporteFichaIngreso->FinComprobanteVentaTipo = "B";
				}
			} else {
				$ReporteFichaIngreso->FinComprobanteVentaTipo = "F";
			}

			$ReporteFichaIngreso->AmoTotal = $fila['AmoTotal'];
			$ReporteFichaIngreso->LtiNombre = $fila['LtiNombre'];
			$ReporteFichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];
			$ReporteFichaIngreso->FccFacturable = $fila['FccFacturable'];

			$ReporteFichaIngreso->FccCausa = $fila['FccCausa'];
			$ReporteFichaIngreso->FccId = $fila['FccId'];

			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];
			$ReporteFichaIngreso->SucDepartamento = $fila['SucDepartamento'];

			$ReporteFichaIngreso->SucDistrito = $fila['SucDistrito'];

			$ReporteFichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'] + 1 - 1;
			$ReporteFichaIngreso->FinIndicacionTecnico = $fila['FinIndicacionTecnico'];

			$ReporteFichaIngreso->CliNumeroDocumento = $fila['CliNumeroDocumento'];

			$ReporteFichaIngreso->RfiLubricantes = $fila['RfiLubricantes'];
			$ReporteFichaIngreso->RfiRepuestos = $fila['RfiRepuestos'];
			$ReporteFichaIngreso->RfiManoObra = $fila['RfiManoObra'];



			//$ReporteFichaIngreso->RfiOtros = $ReporteFichaIngreso->FacTotal - $ReporteFichaIngreso->BolTotal -   $ReporteFichaIngreso->RfiLubricantes  -   $ReporteFichaIngreso->RfiRepuestos  -   $ReporteFichaIngreso->RfiManoObra;
			$ReporteFichaIngreso->RfiOtros = 0;

			$ReporteFichaIngreso->FinNota = $fila['FinNota'];
			$ReporteFichaIngreso->FinObservacion = $fila['FinObservacion'];

			$ReporteFichaIngreso->RfiTotales = $ReporteFichaIngreso->RfiLubricantes  +   $ReporteFichaIngreso->RfiRepuestos +  $ReporteFichaIngreso->RfiManoObra;

			$ReporteFichaIngreso->EinAnoModelo = $fila['EinAnoModelo'];
			$ReporteFichaIngreso->SucNombre = $fila['SucNombre'];


			$ReporteFichaIngreso->InsMysql = NULL;

			$Respuesta['Datos'][] = $ReporteFichaIngreso;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}

	/*
	NUEVO REPORT
	Reporte de Ventas x Taller (Me y B&P)
	22/11/2025
	*/

	public function MtdObtenerReporteFichaIngresosVentaxTallerDetallado(
		$oCampo = NULL,
		$oCondicion = "contiene",
		$oFiltro = NULL,
		$oOrden = 'RveId',
		$oSentido = 'Desc',
		$oPaginacion = '0,10',
		$oAno = NULL,
		$oMes = NULL,
		$oSucursal = NULL,
		$oFechaInicio = NULL,
		$oFechaFin = NULL,
		$oVehiculoMarca = NULL,
		$oModalidadIngreso = NULL
	) {

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

		if (!empty($oAno)) {
			$ano = ' AND rve.RveAno = "' . $oAno . '"';
		}

		if (!empty($oMes)) {
			$mes = ' AND rve.RveMes = "' . $oMes . '"';
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fechab = ' AND DATE(bol.BolFechaEmision)>="' . $oFechaInicio . '" AND DATE(bol.BolFechaEmision)<="' . $oFechaFin . '"';
				$fechaf = ' AND DATE(fac.FacFechaEmision)>="' . $oFechaInicio . '" AND DATE(fac.FacFechaEmision)<="' . $oFechaFin . '"';
			} else {
				$fechab = ' AND DATE(bol.BolFechaEmision)>="' . $oFechaInicio . '"';
				$fechaf = ' AND DATE(fac.FacFechaEmision)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fechab = ' AND DATE(bol.BolFechaEmision)<="' . $oFechaFin . '"';
				$fechab = ' AND DATE(fac.FacFechaEmision)<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oSucursal)) {
			$sucursalb = ' AND (bol.SucId) = "' . $oSucursal . '"';
			$sucursalf = ' AND (fac.SucId) = "' . $oSucursal . '"';
		}


		if (!empty($oVehiculoMarca)) {
			$vmarcab = ' AND (vmo.VmaId) = "' . $oVehiculoMarca . '"';
			$vmarcaf = ' AND (vmo.VmaId) = "' . $oVehiculoMarca . '"';
		}



		if (!empty($oModalidadIngreso)) {

			$elementos = explode(",", $oModalidadIngreso);

			$i = 1;
			$modalidad .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$modalidad .= '  (fim.MinId = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$modalidad .= ' OR ';
				}
				$i++;
			}

			$modalidad .= ' ) 
			)
			';
		}

		$sql = 'SELECT
			bde.BdeId AS "RfpId",
			CONCAT(bta.BtaNumero,"-",bol.BolId) AS "RfpDoc",
			bol.BolFechaEmision AS "RfpFecha",
			mon.MonSigla AS "RfpTipoMoneda",

			IFNULL((
			SELECT 
			fim.FinId
			FROM tblbamboletaalmacenmovimiento bam
				LEFT JOIN tblamoalmacenmovimiento amo
				ON bam.AmoId = amo.AmoId
					LEFT JOIN tblfccfichaaccion fcc
					ON amo.FccId = fcc.FccId
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
				
			
			WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
			LIMIT 1
			),
			IFNULL(
			(
			SELECT 
			amo.VdiId
			FROM tblbamboletaalmacenmovimiento bam
				LEFT JOIN tblamoalmacenmovimiento amo
				ON bam.AmoId = amo.AmoId
					LEFT JOIN tblvdiventadirecta vdi
					ON amo.VdiId = vdi.VdiId
			WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
			LIMIT 1
			)
			,"")
			) AS "RfpOrdenTrabajo",
			CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS "RfpCliente",

			suc.SucNombre ,
			IFNULL((
			SELECT 
			vma.VmaNombre
			FROM tblbamboletaalmacenmovimiento bam
				LEFT JOIN tblamoalmacenmovimiento amo
				ON bam.AmoId = amo.AmoId
					LEFT JOIN tblfccfichaaccion fcc
					ON amo.FccId = fcc.FccId
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblfinfichaingreso fin
							ON fim.FinId = fin.FinId
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId	
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
											LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId
			
			WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
			LIMIT 1
			),
			IFNULL(
			(
			SELECT 
			vma.VmaNombre
			FROM tblbamboletaalmacenmovimiento bam
				LEFT JOIN tblamoalmacenmovimiento amo
				ON bam.AmoId = amo.AmoId
					LEFT JOIN tblvdiventadirecta vdi
					ON amo.VdiId = vdi.VdiId
						LEFT JOIN tbleinvehiculoingreso ein
						ON vdi.EinId = ein.EinId
							LEFT JOIN tblvvevehiculoversion vve
							ON ein.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
			
			WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId 
			LIMIT 1
			)
			,"")
			) AS "RfpMarca",
			IFNULL((
			SELECT 
			usu.UsuUsuario
			FROM tblbamboletaalmacenmovimiento bam
				LEFT JOIN tblamoalmacenmovimiento amo
				ON bam.AmoId = amo.AmoId
					LEFT JOIN tblfccfichaaccion fcc
					ON amo.FccId = fcc.FccId
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fcc.FimId = fim.FimId
								LEFT JOIN tblfinfichaingreso fin
								ON fim.FinId =  fin.FinId
						LEFT JOIN tblperpersonal per
							ON fin.PerIdAsesor = per.PerId
								LEFT JOIN tblusuusuario usu
								ON per.UsuId = usu.UsuId
			WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
			LIMIT 1
			) ,
			IFNULL(
			(
			SELECT 
			usu.UsuUsuario
			FROM tblbamboletaalmacenmovimiento bam
				LEFT JOIN tblamoalmacenmovimiento amo
				ON bam.AmoId = amo.AmoId
					LEFT JOIN tblvdiventadirecta vdi
					ON amo.VdiId = vdi.VdiId		
						LEFT JOIN tblperpersonal per
							ON vdi.PerId = per.PerId
								LEFT JOIN tblusuusuario usu
								ON per.UsuId = usu.UsuId
			WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
			LIMIT 1
			)
			,"")) AS "RfpVendedor",
			(
			IFNULL(
			(
			SELECT 
			CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoMaterno,"")," ",IFNULL(per.PerApellidoPaterno,""))
			FROM tblbamboletaalmacenmovimiento bam
				LEFT JOIN tblamoalmacenmovimiento amo
				ON bam.AmoId = amo.AmoId
					LEFT JOIN tblfccfichaaccion fcc
					ON amo.FccId = fcc.FccId			
						LEFT JOIN tblperpersonal per
							ON fcc.PerId = per.PerId
			
			WHERE bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
			LIMIT 1
			),"")
			) AS "RfpAsesorAccesorio",
			
			bde.BdeCodigo AS "RfpCodigo",
			bde.BdeDescripcion AS "RfpDescripcion",
			ROUND(bde.BdeCantidad,2) AS "RfpCantidad",
			@CostoDolares:=ROUND(IFNULL(
				(
					SELECT
					lpr.costo
					FROM listaprecios lpr
					WHERE lpr.codigo = REPLACE(bde.BdeCodigo,"-", "")
					LIMIT 1
				)
			,IFNULL(
				(
					SELECT 
					plp.PlpPrecioReal
					FROM tblplpproductolistaprecio plp
					WHERE plp.PlpCodigo = REPLACE(bde.BdeCodigo,"-", "")
					
					LIMIT 1
				),IFNULL(
					(
						SELECT 
						ede.precio_compra
						FROM entradas_detalle ede
						LEFT JOIN entradas ent
						ON ede.id_entrada = ent.id_entrada
						WHERE ede.id_articulo = bde.BdeCodigo
						AND ent.moneda = "02 - US$ - DOLARES AMERICANOS"
						
						LIMIT 1
					),0)
				)
			
			),2) AS "RfpCostoUs",
			
			@CostoIGVDolares:=ROUND((
			@CostoDolares*1.18
			),2) AS "RfpCostoIGV",
			
			@TipoCambio:=IFNULL((
			SELECT
			tca.TcaMontoVenta
			FROM tbltcatipocambio tca
			WHERE tca.TcaFecha = bol.BolFechaEmision
			AND tca.MonId = "MON-10001"
			LIMIT 1
			),
			IFNULL(
			(
			SELECT
			tca.TcaMontoVenta
			FROM tbltcatipocambio tca
			WHERE 1 = 1
			AND tca.MonId = "MON-10001"
			AND tca.TcaFecha <= bol.BolFechaEmision
			
			LIMIT 1
			)
			,0)
			) AS "RfpTipoCambio",
			
			ume.UmeNombre AS "RfpUnidadMedida",
			((IF(bol.MonId="MON-10000",bde.BdePrecio,0))) AS "RfpPrecioSFinal",
			
			((IF(bol.MonId="MON-10000",( (bde.BdeDescuento/bde.BdeCantidad)* ((bol.BolPorcentajeImpuestoVenta/100)+1) ) ,0))) AS "RfpDescuentoSFinal",
			((IF(bol.MonId="MON-10000",bde.BdeImporte,0))) AS "RfpImporteSFinal",
			((IF(bol.MonId="MON-10001",bde.BdePrecio/bol.BolTipoCambio,0))) AS "RfpPrecioUSFinal",
			((IF(bol.MonId="MON-10001",( (bde.BdeDescuento/bde.BdeCantidad)* ((bol.BolPorcentajeImpuestoVenta/100)+1) ) /bol.BolTipoCambio,0))) AS "RfpDescuentoUSFinal",
			((IF(bol.MonId="MON-10001",bde.BdeImporte/bol.BolTipoCambio,0))) AS "RfpImporteUSFinal",
			min.MinNombre ,
			
			(
			SELECT 
			CONCAT(nct.NctNumero,"-",ncr.NcrId)
			FROM tblncrnotacredito ncr
			LEFT JOIN tblnctnotacreditotalonario nct
			ON ncr.NctId = nct.NctId
			WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
			AND ncr.NcrEstado <> 6
			LIMIT 1
			) AS RfpNotaCredito,
			
			
			(
			SELECT 
			( ncr.NcrTotal/IFNULL(ncr.NcrTipoCambio,1) )
			FROM tblncrnotacredito ncr
			LEFT JOIN tblnctnotacreditotalonario nct
			ON ncr.NctId = nct.NctId
			WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
			AND ncr.NcrEstado <> 6
			LIMIT 1
			) AS RfpNotaCreditoTotal,
			
			vma.VmaNombre,
			fim.FinId,
			DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
			fin.FinVehiculoKilometraje,
			fin.FinObservacion,

			ein.EinPlaca,
			ein.EinVin,
			ein.EinNumeroMotor,
		 
			ein.EinColor,
			ein.EinAnoFabricacion,
			ein.EinAnoModelo,
 
			vmo.VmoNombre,

			cli.CliNumeroDocumento,
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			cli.CliCelular,
			cli.CliEmail,
			cli.CliDireccion,
			cli.CliDepartamento,
			cli.CliProvincia,
			cli.CliDistrito,

			mon.MonNombre,

			bde.BdePrecio AS "RfpPrecio",
			bde.BdeCantidad AS "RfpCantidad",
			bde.BdeImporte AS "RfpImporte",
			bde.BdeDescuento AS "RfpDescuento",

				amd.ProId,
					tdo.TdoNombre,
					pro.ProValidarStock
			
			FROM tblbdeboletadetalle bde
				LEFT JOIN tblbolboleta bol
				ON (bde.BolId = bol.BolId AND  bde.BtaId = bol.BtaId)
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
			
						LEFT JOIN tblclicliente cli
						ON bol.CliId = cli.CliId
							LEFT JOIN tbltdotipodocumento tdo
							ON cli.TdoId = tdo.TdoId

							LEFT JOIN tblmonmoneda mon
							ON bol.MonId = mon.MonId
								LEFT  JOIN tblsucsucursal suc
								ON bol.SucId = suc.SucId
									LEFT JOIN tblamdalmacenmovimientodetalle amd
									ON bde.AmdId = amd.AmdId
										LEFT JOIN tblproproducto pro
										ON amd.ProId =  pro .ProId
										LEFT JOIN tblumeunidadmedida ume
										ON amd.UmeId = ume.UmeId
											LEFT JOIN tblrtiproductotipo rti
											ON pro.RtiId = rti.RtiId
											LEFT JOIN tblamoalmacenmovimiento amo
												ON amd.AmoId = amo.AmoId
												
												LEFT JOIN tblfccfichaaccion fcc
												ON amo.FccId = fcc.FccId
													LEFT JOIN tblfimfichaingresomodalidad fim
													ON fcc.FimId = fim.FimId
														LEFT JOIN tblminmodalidadingreso min
														ON fim.MinId = min.MinId
															LEFT JOIN tblfinfichaingreso fin
															ON fim.FinId = fin.FinId
																LEFT JOIN tbleinvehiculoingreso ein
																ON fin.EinId = ein.EinId
																	LEFT JOIN tblvvevehiculoversion vve
																	ON ein.VveId = vve.VveId
																		LEFT JOIN tblvmovehiculomodelo vmo
																		ON vve.VmoId = vmo.VmoId
																			LEFT JOIN tblvmavehiculomarca vma
																			ON vmo.VmaId = vma.VmaId
																			
			WHERE 1 = 1 
			AND bol.BolEstado <> 6 
			AND fim.FinId IS NOT NULL
			' . $fechab . $vmarcab . $sucursalb . '

					UNION ALL 

					SELECT
					fde.FdeId AS "RfpId",

					CONCAT(fta.FtaNumero,"-",fac.FacId) AS "RfpDoc",
					fac.FacFechaEmision AS "RfpFecha",
					mon.MonSigla AS "RfpTipoMoneda",

					IFNULL((
					SELECT 
					fim.FinId
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
					WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
					LIMIT 1
					),
					IFNULL(

						(
						SELECT 
						amo.VdiId
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
						WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
						LIMIT 1
						)

					,"")
					) AS "RfpOrdenTrabajo",

					CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS "RfpCliente",

					suc.SucNombre ,

					IFNULL((
					SELECT 
					vma.VmaNombre
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
									LEFT JOIN tblfinfichaingreso fin
									ON fim.FinId = fin.FinId
										LEFT JOIN tbleinvehiculoingreso ein
										ON fin.EinId = ein.EinId	
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON vve.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
														ON vmo.VmaId = vma.VmaId


					WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
					LIMIT 1
					),
					IFNULL(

						(
						SELECT 
						vma.VmaNombre
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId

									LEFT JOIN tbleinvehiculoingreso ein
									ON vdi.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
												LEFT JOIN tblvmavehiculomarca vma
												ON vmo.VmaId = vma.VmaId


						WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
						LIMIT 1
						)

					,"")
					) AS "RfpMarca",

					IFNULL((
					SELECT 
					usu.UsuUsuario
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
										LEFT JOIN tblfinfichaingreso fin
										ON fim.FinId =  fin.FinId
								LEFT JOIN tblperpersonal per
									ON fin.PerIdAsesor = per.PerId
										LEFT JOIN tblusuusuario usu
										ON per.UsuId = usu.UsuId
					WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
					LIMIT 1
					),
					IFNULL(

					(
					SELECT 
					usu.UsuUsuario
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
								LEFT JOIN tblperpersonal per
									ON vdi.PerId = per.PerId
										LEFT JOIN tblusuusuario usu
										ON per.UsuId = usu.UsuId
					WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
					LIMIT 1
					)

					,""))  AS "RfpVendedor",

					(
					IFNULL(
					(
					SELECT 
					CONCAT(IFNULL(per.PerNombre,"")," ",IFNULL(per.PerApellidoMaterno,"")," ",IFNULL(per.PerApellidoPaterno,""))
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId			
								LEFT JOIN tblperpersonal per
									ON fcc.PerId = per.PerId

					WHERE fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
					LIMIT 1
					),"")
					) AS "RfpAsesorAccesorio",

					fde.FdeCodigo AS "RfpCodigo",
					fde.FdeDescripcion AS "RfpDescripcion",
					ROUND(fde.FdeCantidad,2) AS "RfpCantidad",

					@CostoDolares:=ROUND(IFNULL(
						(
							SELECT
							lpr.costo
							FROM listaprecios lpr
							WHERE lpr.codigo = REPLACE(fde.FdeCodigo,"-", "")
							LIMIT 1
						)
					,IFNULL(
						(
							SELECT 
							plp.PlpPrecioReal
							FROM tblplpproductolistaprecio plp
							WHERE plp.PlpCodigo = REPLACE(fde.FdeCodigo,"-", "")
							LIMIT 1
						),IFNULL(
							(
								SELECT 
								ede.precio_compra
								FROM entradas_detalle ede
								LEFT JOIN entradas ent
								ON ede.id_entrada = ent.id_entrada
								WHERE ede.id_articulo = fde.FdeCodigo
								AND ent.moneda = "02 - US$ - DOLARES AMERICANOS"
								LIMIT 1
							),0)
						)

					),2) AS "RfpCostoUs",
 

					@CostoIGVDolares:=ROUND((
					@CostoDolares*1.18
					),2) AS "RfpCostoIGV",

					@TipoCambio:=IFNULL((
					SELECT
					tca.TcaMontoVenta
					FROM tbltcatipocambio tca
					WHERE tca.TcaFecha = fac.FacFechaEmision
					AND tca.MonId = "MON-10001"
					LIMIT 1
					),
					IFNULL(
					(
					SELECT
					tca.TcaMontoVenta
					FROM tbltcatipocambio tca
					WHERE 1 = 1
					AND tca.MonId = "MON-10001"
					AND tca.TcaFecha <= fac.FacFechaEmision
					LIMIT 1
					)
					,0)
					) AS "RfpTipoCambio",

					ume.UmeNombre AS "RfpUnidadMedida",
					((IF(fac.MonId="MON-10000",fde.FdePrecio,0))) AS "RfpPrecioSFinal",

					((IF(fac.MonId="MON-10000",( (fde.FdeDescuento/fde.FdeCantidad)* ((fac.FacPorcentajeImpuestoVenta/100)+1) ) ,0))) AS "RfpDescuentoSFinal",
					((IF(fac.MonId="MON-10000",fde.FdeImporte,0))) AS "RfpImporteSFinal",
					((IF(fac.MonId="MON-10001",fde.FdePrecio/fac.FacTipoCambio,0))) AS "RfpPrecioUSFinal",
					((IF(fac.MonId="MON-10001",( (fde.FdeDescuento/fde.FdeCantidad)* ((fac.FacPorcentajeImpuestoVenta/100)+1) ) /fac.FacTipoCambio,0))) AS "RfpDescuentoUSFinal",
					((IF(fac.MonId="MON-10001",fde.FdeImporte/fac.FacTipoCambio,0))) AS "RfpImporteUSFinal",

					min.MinNombre  ,

					(
					SELECT 
					CONCAT(nct.NctNumero,"-",ncr.NcrId)
					FROM tblncrnotacredito ncr
					LEFT JOIN tblnctnotacreditotalonario nct
					ON ncr.NctId = nct.NctId
					WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
					AND ncr.NcrEstado <> 6
					LIMIT 1
					) AS RfpNotaCredito,

					(
					SELECT 
					( ncr.NcrTotal/IFNULL(ncr.NcrTipoCambio,1) )
					FROM tblncrnotacredito ncr
					LEFT JOIN tblnctnotacreditotalonario nct
					ON ncr.NctId = nct.NctId
					WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
					AND ncr.NcrEstado <> 6
					LIMIT 1
					) AS RfpNotaCreditoTotal,

					vma.VmaNombre,
					fim.FinId,
					DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
					fin.FinVehiculoKilometraje,
					fin.FinObservacion,

					ein.EinPlaca,
					ein.EinVin,
					ein.EinNumeroMotor,
				
					ein.EinColor,
					ein.EinAnoFabricacion,
					ein.EinAnoModelo,

				 
					vmo.VmoNombre,

					cli.CliNumeroDocumento,
					cli.CliNombre,
					cli.CliApellidoPaterno,
					cli.CliApellidoMaterno,
					cli.CliCelular,
					cli.CliEmail,
					cli.CliDireccion,
					cli.CliDepartamento,
					cli.CliProvincia,
					cli.CliDistrito,

					mon.MonNombre,

					fde.FdePrecio AS "RfpPrecio",
					fde.FdeCantidad AS "RfpCantidad",
					fde.FdeImporte AS "RfpImporte",
					fde.FdeDescuento AS "RfpDescuento",

					amd.ProId,
					tdo.TdoNombre,
					pro.ProValidarStock
 
					FROM tblfdefacturadetalle fde
						LEFT JOIN tblfacfactura fac
						ON (fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId)
							LEFT JOIN tblftafacturatalonario fta
							ON fac.FtaId = fta.FtaId
								LEFT JOIN tblclicliente cli
								ON fac.CliId = cli.CliId

									LEFT JOIN tbltdotipodocumento tdo
									ON cli.TdoId = tdo.TdoId

									LEFT JOIN tblmonmoneda mon
									ON fac.MonId = mon.MonId
										LEFT  JOIN tblsucsucursal suc
										ON fac.SucId = suc.SucId
											LEFT JOIN tblamdalmacenmovimientodetalle amd
											ON fde.AmdId = amd.AmdId
												LEFT JOIN tblproproducto pro
												ON amd.ProId =  pro .ProId
												LEFT JOIN tblumeunidadmedida ume
												ON amd.UmeId = ume.UmeId
													LEFT JOIN tblrtiproductotipo rti
													ON pro.RtiId = rti.RtiId
														LEFT JOIN tblamoalmacenmovimiento amo
														ON amd.AmoId = amo.AmoId
														LEFT JOIN tblfccfichaaccion fcc
														ON amo.FccId = fcc.FccId
															LEFT JOIN tblfimfichaingresomodalidad fim
															ON fcc.FimId = fim.FimId
																LEFT JOIN tblminmodalidadingreso min
																ON fim.MinId = min.MinId
																	LEFT JOIN tblfinfichaingreso fin
																	ON fim.FinId = fin.FinId
																		LEFT JOIN tbleinvehiculoingreso ein
																		ON fin.EinId = ein.EinId
																			LEFT JOIN tblvvevehiculoversion vve
																			ON ein.VveId = vve.VveId
																				LEFT JOIN tblvmovehiculomodelo vmo
																				ON vve.VmoId = vmo.VmoId
																					LEFT JOIN tblvmavehiculomarca vma
																					ON vmo.VmaId = vma.VmaId
																					
					WHERE 1 = 1 AND fac.FacEstado <> 6 
					AND fim.FinId IS NOT NULL
					' . $fechaf . $vmarcaf . $sucursalf . '


				 ' . $orden . $paginacion; //.$filtrar.$fecha.$estado.$vmarca.$vmodelo.$ano.$mes.$cvin.$orden.$paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsReporteResumenVenta = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$ReporteResumenVenta = new $InsReporteResumenVenta();
			$ReporteResumenVenta->RfpId = $fila['RfpId'];
			$ReporteResumenVenta->RfpDoc = $fila['RfpDoc'];
			$ReporteResumenVenta->RfpFecha = $fila['RfpFecha'];
			$ReporteResumenVenta->RfpTipoMoneda = $fila['RfpTipoMoneda'];
			$ReporteResumenVenta->RfpOrdenTrabajo = $fila['RfpOrdenTrabajo'];
			$ReporteResumenVenta->RfpCliente = $fila['RfpCliente'];

			$ReporteResumenVenta->SucNombre = $fila['SucNombre'];
			$ReporteResumenVenta->RfpMarca = $fila['RfpMarca'];

			$ReporteResumenVenta->RfpVendedor = $fila['RfpVendedor'];
			$ReporteResumenVenta->RfpAsesorAccesorio = $fila['RfpAsesorAccesorio'];
			$ReporteResumenVenta->RfpCodigo = $fila['RfpCodigo'];
			$ReporteResumenVenta->RfpDescripcion = $fila['RfpDescripcion'];

			$ReporteResumenVenta->RfpCantidad = $fila['RfpCantidad'];
			$ReporteResumenVenta->RfpCostoUs = $fila['RfpCostoUs'];
			$ReporteResumenVenta->RfpCostoIgv = $fila['RfpCostoIgv'];
			$ReporteResumenVenta->RfpTipoCambio = $fila['RfpTipoCambio'];


			$ReporteResumenVenta->RfpUnidadMedida = $fila['RfpUnidadMedida'];

			$ReporteResumenVenta->RfpPrecioSFinal = $fila['RfpPrecioSFinal'];
			$ReporteResumenVenta->RfpDescuentoSFinal = $fila['RfpDescuentoSFinal'];
			$ReporteResumenVenta->RfpPrecioDescuentoSFinal = $ReporteResumenVenta->RfpPrecioSFinal - $ReporteResumenVenta->RfpDescuentoSFinal;

			$ReporteResumenVenta->RfpImporteSFinal = $fila['RfpImporteSFinal'];
			$ReporteResumenVenta->RfpImporteDescuentoSFinal = $ReporteResumenVenta->RfpImporteSFinal - ($ReporteResumenVenta->RfpDescuentoSFinal * $ReporteResumenVenta->RfpCantidad);

			$ReporteResumenVenta->RfpPrecioUSFinal = $fila['RfpPrecioUSFinal'];
			$ReporteResumenVenta->RfpDescuentoUSFinal = $fila['RfpDescuentoUSFinal'];
			$ReporteResumenVenta->RfpPrecioDescuentoUSFinal = $ReporteResumenVenta->RfpPrecioUSFinal - $ReporteResumenVenta->RfpDescuentoUSFinal;

			$ReporteResumenVenta->RfpImporteUSFinal = $fila['RfpImporteUSFinal'];
			$ReporteResumenVenta->RfpImporteDescuentoUSFinal = $ReporteResumenVenta->RfpImporteUSFinal - ($ReporteResumenVenta->RfpDescuentoUSFinal * $ReporteResumenVenta->RfpCantidad);



			$ReporteResumenVenta->MinNombre = $fila['MinNombre'];
			$ReporteResumenVenta->RfpNotaCredito = $fila['RfpNotaCredito'];
			$ReporteResumenVenta->RfpNotaCreditoTotal = $fila['RfpNotaCreditoTotal'];

			$ReporteResumenVenta->FinId = $fila['FinId'];
			$ReporteResumenVenta->FinFecha = $fila['NFinFecha'];
			$ReporteResumenVenta->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];

			$ReporteResumenVenta->EinPlaca = $fila['EinPlaca'];
			$ReporteResumenVenta->EinVin = $fila['EinVin'];
			$ReporteResumenVenta->EinNumeroMotor = $fila['EinNumeroMotor'];

			$ReporteResumenVenta->EinColor = $fila['EinColor'];
			$ReporteResumenVenta->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$ReporteResumenVenta->EinAnoModelo = $fila['EinAnoModelo'];

			$ReporteResumenVenta->VmaNombre = $fila['VmaNombre'];
			$ReporteResumenVenta->VmoNombre = $fila['VmoNombre'];

			$ReporteResumenVenta->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$ReporteResumenVenta->CliNombre = $fila['CliNombre'];
			$ReporteResumenVenta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$ReporteResumenVenta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$ReporteResumenVenta->CliCelular = $fila['CliCelular'];
			$ReporteResumenVenta->CliEmail = $fila['CliEmail'];
			$ReporteResumenVenta->CliDireccion = $fila['CliDireccion'];
			$ReporteResumenVenta->CliDepartamento = $fila['CliDepartamento'];
			$ReporteResumenVenta->CliProvincia = $fila['CliProvincia'];
			$ReporteResumenVenta->CliDistrito = $fila['CliDistrito'];

			$ReporteResumenVenta->MonNombre = $fila['MonNombre'];

			$ReporteResumenVenta->RfpPrecio = $fila['RfpPrecio'];
			$ReporteResumenVenta->RfpCantidad = $fila['RfpCantidad'];
			$ReporteResumenVenta->RfpImporte = $fila['RfpImporte'];
			$ReporteResumenVenta->RfpDescuento = $fila['RfpDescuento'];

			$ReporteResumenVenta->ProId = $fila['ProId'];
			$ReporteResumenVenta->TdoNombre = $fila['TdoNombre'];
			$ReporteResumenVenta->ProValidarStock = $fila['ProValidarStock'];

			$ReporteResumenVenta->InsMysql = NULL;
			$Respuesta['Datos'][] = $ReporteResumenVenta;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}
}
