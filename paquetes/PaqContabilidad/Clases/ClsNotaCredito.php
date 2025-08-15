<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaCredito
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaCredito
{

	public $NcrId;
	public $NctId;
	public $UsuId;

	public $CliId;

	public $FacId;
	public $FtaId;
	public $BolId;
	public $BtaId;

	public $DocId;
	public $DtaId;
	public $DtaNumero;

	public $NcrTipo;
	public $NcrEstado;
	public $NcrFechaEmision;

	public $MonId;
	public $NcrTipoCambio;

	public $NcrPorcentajeImpuestoVenta;
	public $NcrSubTotal;
	public $NcrImpuesto;
	public $NcrTotal;
	public $NcrObservacion;
	public $NcrObservacionImpresa;
	public $NcrMotivo;

	public $NcrCierre;

	public $NcrTiempoCreacion;
	public $NcrTiempoModificacion;
	public $NcrEliminado;

	public $NcrTotalItems;
	public $NotaCreditoDetalle;

	public $NctNumero;

	public $SucId;

	public $CliNombre;
	public $TdoId;
	public $CliNumeroDocumento;
	public $CliTelefono;
	public $CliEmail;
	public $CliCelular;
	public $CliFax;

	public $InsMysql;

	// Propiedades adicionales para evitar warnings
	public $CliNombreCompleto;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliEmailFacturacion;
	public $CliContactoEmail1;
	public $CliContactoEmail2;
	public $CliContactoEmail3;
	public $CliClaveElectronica;
	public $CliProvincia;
	public $CliDistrito;
	public $CliDepartamento;
	public $FinVehiculoKilometraje;
	public $MonNombre;
	public $MonSimbolo;
	public $MonSigla;
	public $MonCodigo;
	public $FinId;
	public $AmoId;
	public $OvvId;
	public $EinVIN;
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $EinAnoFabricacion;
	public $EinPlaca;
	public $VehColor;
	public $EinNombre;
	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $NcrEstadoDescripcion;
	public $NcrEstadoIcono;
	public $NcrNotaCreditoDetalle;
	public $NcrAlmacenMovimiento;
	public $NcrOrdenVentaVehiculoPropietario;

	// Propiedades adicionales para evitar warnings
	public $NcrSunatRespuestaBajaId;
	public $VdiId;
	public $VmvId;
	public $NcrHoraEmision;
	public $NcrDireccion;
	public $DocFechaEmision;

	public function __construct($oInsMysql = NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}
	}

	public function __destruct() {}

	public function MtdGenerarNotaCreditoId()
	{


		$sql = 'SELECT	

			MAX(SUBSTR(ncr.NcrId,1)) AS "MAXIMO",
			
			nct.NctInicio
			FROM tblncrnotacredito ncr
				LEFT JOIN tblnctnotacreditotalonario nct
				ON ncr.NctId = nct.NctId
					WHERE nct.NctId = "' . $this->NctId . '"';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			if (empty($fila['NctInicio'])) {
				$this->NcrId = "0000001";
			} else {
				$this->NcrId = str_pad($fila['NctInicio'], 6, "0", STR_PAD_LEFT);
			}
		} else {
			$fila['MAXIMO']++;
			$this->NcrId = str_pad($fila['MAXIMO'], 6, "0", STR_PAD_LEFT);
		}
	}

	public function MtdGenerarNotaCreditoBajaId()
	{


		$sql = 'SELECT	
			MAX(CONVERT(ncr.NcrSunatRespuestaBajaId,unsigned)) AS "MAXIMO"
	
		FROM tblncrnotacredito ncr ';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->NcrSunatRespuestaBajaId = "1";
		} else {
			$fila['MAXIMO']++;
			$this->NcrSunatRespuestaBajaId = ($fila['MAXIMO']);
		}
	}

	public function MtdObtenerNotaCredito($oCompleto = true)
	{

		$sql = 'SELECT 
				ncr.NcrId,
				ncr.NctId,
				ncr.SucId,
				
					ncr.OvvId,
				ncr.VdiId,
				
				ncr.AmoId,
				ncr.VmvId,
				
				cli.CliId,
				DATE_FORMAT(ncr.NcrFechaEmision, "%d/%m/%Y") AS "NNcrFechaEmision",
DATE_FORMAT(ncr.NcrTiempoCreacion, "%H:%i:%s") AS "NcrHoraEmision",
				
				
				
				ncr.NcrDireccion,
				
				
				CASE ncr.NcrTipo
				WHEN 2 THEN (ncr.FacId)
				WHEN 3 THEN (ncr.BolId)
				ELSE NULL
				END AS "DocId",					
			
				CASE ncr.NcrTipo
				WHEN 2 THEN (ncr.FtaId)
				WHEN 3 THEN (ncr.BtaId)
				ELSE NULL
				END AS "DtaId" ,
				
				CASE ncr.NcrTipo
				WHEN 2 THEN (fta.FtaNumero)
				WHEN 3 THEN (bta.BtaNumero)
				ELSE NULL
				END AS "DtaNumero",			
				
				CASE ncr.NcrTipo
				WHEN 2 THEN DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
				WHEN 3 THEN DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
				ELSE NULL
				END AS "DocFechaEmision",
		
				CASE ncr.NcrTipo
				WHEN 2 THEN (fac.OvvId)
				WHEN 3 THEN (bol.OvvId)
				ELSE NULL
				END AS "OvvId",	
				
				
				CASE ncr.NcrTipo
				WHEN 2 THEN ("01")
				WHEN 3 THEN ("03")
				ELSE NULL
				END AS "DocTipoDocumentoCodigo",		
				
				ncr.NcrIncluyeImpuesto,					
				ncr.NcrPorcentajeImpuestoVenta,
				ncr.NcrPorcentajeImpuestoSelectivo,
				
				ncr.MonId,
				ncr.NcrTipoCambio,
				
				ncr.NcrTipo,
				
				ncr.NcrDatoAdicional1,
				ncr.NcrDatoAdicional2,
				ncr.NcrDatoAdicional3,
				ncr.NcrDatoAdicional4,
				ncr.NcrDatoAdicional5,
				ncr.NcrDatoAdicional6,
				ncr.NcrDatoAdicional7,
				ncr.NcrDatoAdicional8,
				ncr.NcrDatoAdicional9,
				ncr.NcrDatoAdicional10,
				
				ncr.NcrDatoAdicional11,
				ncr.NcrDatoAdicional12,
				ncr.NcrDatoAdicional13,
				ncr.NcrDatoAdicional14,
				ncr.NcrDatoAdicional15,
				ncr.NcrDatoAdicional16,
				ncr.NcrDatoAdicional17,
				ncr.NcrDatoAdicional18,
				ncr.NcrDatoAdicional19,
				ncr.NcrDatoAdicional20,
				
				ncr.NcrDatoAdicional21,
				ncr.NcrDatoAdicional22,
				ncr.NcrDatoAdicional23,
				ncr.NcrDatoAdicional24,
				ncr.NcrDatoAdicional25,
ncr.NcrDatoAdicional26,
ncr.NcrDatoAdicional27,
ncr.NcrDatoAdicional28,
				
				
				ncr.NcrEstado,	
				ncr.NcrTotalImpuestoSelectivo,
				ncr.NcrTotalGravado,
				ncr.NcrTotalDescuento,
				ncr.NcrTotalGratuito,
				ncr.NcrTotalExonerado,
				ncr.NcrTotalPagar,
				
				ncr.NcrSubTotal,
				ncr.NcrImpuesto,
				ncr.NcrTotal,
				

				ncr.NcrObservacion,
				ncr.NcrMotivo,
				ncr.NcrMotivoCodigo,				
				
				ncr.NcrSunatRespuestaTicket,
				ncr.NcrSunatRespuestaTicketEstado,
				ncr.NcrSunatRespuestaObservacion,
				
				ncr.NcrSunatRespuestaEnvioTicket,
				ncr.NcrSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaEnvioFecha",
				ncr.NcrSunatRespuestaEnvioHora,
				ncr.NcrSunatRespuestaEnvioCodigo,
				ncr.NcrSunatRespuestaEnvioContenido,
				
				ncr.NcrSunatRespuestaBajaTicket,
				ncr.NcrSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaBajaFecha",
				ncr.NcrSunatRespuestaBajaHora,
				ncr.NcrSunatRespuestaBajaCodigo,
				ncr.NcrSunatRespuestaBajaContenido,
				ncr.NcrSunatRespuestaBajaId,
				
				ncr.NcrSunatRespuestaConsultaCodigo,
				ncr.NcrSunatRespuestaConsultaContenido,
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaConsultaFecha",
				ncr.NcrSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaBajaTiempoCreacion",
				
				ncr.NcrSunatRespuestaTicket,
				ncr.NcrSunatRespuestaTicketEstado,
				ncr.NcrSunatRespuestaObservacion,
				
				ncr.NcrSunatRespuestaEnvioTicket,
				ncr.NcrSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaEnvioFecha",
				ncr.NcrSunatRespuestaEnvioHora,
				ncr.NcrSunatRespuestaEnvioCodigo,
				ncr.NcrSunatRespuestaEnvioContenido,
				
				ncr.NcrSunatRespuestaBajaTicket,
				ncr.NcrSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaBajaFecha",
				ncr.NcrSunatRespuestaBajaHora,
				ncr.NcrSunatRespuestaBajaCodigo,
				ncr.NcrSunatRespuestaBajaContenido,
				ncr.NcrSunatRespuestaBajaId,
				
				ncr.NcrSunatRespuestaConsultaCodigo,
				ncr.NcrSunatRespuestaConsultaContenido,
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaConsultaFecha",
				ncr.NcrSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaBajaTiempoCreacion",
				
				ncr.NcrSunatUltimaAccion,
				ncr.NcrSunatUltimaRespuesta,
				
				ncr.NcrSunatRespuestaEnvioDigestValue,	
				ncr.NcrSunatRespuestaEnvioSignatureValue,	
				
				ncr.NcrUsuario,	
				ncr.NcrVendedor,	
				ncr.NcrNumeroPedido,	
				
				ncr.NcrCierre,				
				DATE_FORMAT(ncr.NcrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrTiempoCreacion",
                DATE_FORMAT(ncr.NcrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNcrTiempoModificacion",

				nct.NctNumero,
				
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
				cli.TdoId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliContactoEmail1,
				cli.CliContactoEmail2,
				cli.CliContactoEmail3,
				cli.CliEmailFacturacion,
				
				cli.CliCelular,
				cli.CliFax,
				
				mon.MonSimbolo,
				mon.MonSigla,
				mon.MonNombre,

				tdo.TdoCodigo,
				sca.ScaNombre,
				
					suc.SucNombre,
				suc.SucDireccion,
				suc.SucDistrito,
				suc.SucProvincia,
				suc.SucDepartamento,
				suc.SucCodigoUbigeo,
				suc.SucCodigoAnexo
					
				FROM tblncrnotacredito ncr
				
				LEFT JOIN tblnctnotacreditotalonario nct
				ON ncr.NctId = nct.NctId				
				
					LEFT JOIN tblfacfactura fac 
					ON (ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId)
						
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
						
					LEFT JOIN tblbolboleta bol
					ON (ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId)
					
						LEFT JOIN tblbtaboletatalonario bta
						ON ncr.BtaId = bta.BtaId
					
				LEFT JOIN tblclicliente cli
				ON (ncr.CliId = cli.CliId)
				
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
					LEFT JOIN tblmonmoneda mon
					ON ncr.MonId = mon.MonId
					
					LEFT JOIn tblscasunatcatalogo sca
					ON ncr.NcrMotivoCodigo = sca.ScaCodigo
					
					
						LEFT JOIN tblsucsucursal suc
									ON ncr.SucId = suc.SucId		
					
				WHERE ncr.NcrId = "' . $this->NcrId . '" AND ncr.NctId= "' . $this->NctId . '";';


		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {


				$this->NcrId = $fila['NcrId'];
				$this->NctId = $fila['NctId'];
				$this->SucId = $fila['SucId'];

				$this->OvvId = $fila['OvvId'];
				$this->VdiId = $fila['VdiId'];

				$this->AmoId = $fila['AmoId'];
				$this->VmvId = $fila['VmvId'];

				$this->CliId = $fila['CliId'];
				$this->NcrFechaEmision = $fila['NNcrFechaEmision'];
				$this->NcrHoraEmision = $fila['NcrHoraEmision'];
				$this->NcrDireccion = $fila['NcrDireccion'];

				$this->DocId = $fila['DocId'];
				$this->DtaId = $fila['DtaId'];
				$this->DtaNumero = $fila['DtaNumero'];
				$this->DocFechaEmision = $fila['DocFechaEmision'];
				$this->DocTipoDocumentoCodigo = $fila['DocTipoDocumentoCodigo'];

				$this->NcrIncluyeImpuesto = $fila['NcrIncluyeImpuesto'];
				$this->NcrPorcentajeImpuestoVenta = $fila['NcrPorcentajeImpuestoVenta'];
				$this->NcrPorcentajeImpuestoSelectivo = $fila['NcrPorcentajeImpuestoSelectivo'];

				$this->MonId = $fila['MonId'];
				$this->NcrTipoCambio = $fila['NcrTipoCambio'];

				$this->NcrTipo = $fila['NcrTipo'];
				$this->OvvId = $fila['OvvId'];

				$this->NcrDatoAdicional1 = $fila['NcrDatoAdicional1'];
				$this->NcrDatoAdicional2 = $fila['NcrDatoAdicional2'];
				$this->NcrDatoAdicional3 = $fila['NcrDatoAdicional3'];
				$this->NcrDatoAdicional4 = $fila['NcrDatoAdicional4'];
				$this->NcrDatoAdicional5 = $fila['NcrDatoAdicional5'];
				$this->NcrDatoAdicional6 = $fila['NcrDatoAdicional6'];
				$this->NcrDatoAdicional7 = $fila['NcrDatoAdicional7'];
				$this->NcrDatoAdicional8 = $fila['NcrDatoAdicional8'];
				$this->NcrDatoAdicional9 = $fila['NcrDatoAdicional9'];
				$this->NcrDatoAdicional10 = $fila['NcrDatoAdicional10'];

				$this->NcrDatoAdicional11 = $fila['NcrDatoAdicional11'];
				$this->NcrDatoAdicional12 = $fila['NcrDatoAdicional12'];
				$this->NcrDatoAdicional13 = $fila['NcrDatoAdicional13'];
				$this->NcrDatoAdicional14 = $fila['NcrDatoAdicional14'];
				$this->NcrDatoAdicional15 = $fila['NcrDatoAdicional15'];
				$this->NcrDatoAdicional16 = $fila['NcrDatoAdicional16'];
				$this->NcrDatoAdicional17 = $fila['NcrDatoAdicional17'];
				$this->NcrDatoAdicional18 = $fila['NcrDatoAdicional18'];
				$this->NcrDatoAdicional19 = $fila['NcrDatoAdicional19'];
				$this->NcrDatoAdicional20 = $fila['NcrDatoAdicional20'];

				$this->NcrDatoAdicional21 = $fila['NcrDatoAdicional21'];
				$this->NcrDatoAdicional22 = $fila['NcrDatoAdicional22'];
				$this->NcrDatoAdicional23 = $fila['NcrDatoAdicional23'];
				$this->NcrDatoAdicional24 = $fila['NcrDatoAdicional24'];
				$this->NcrDatoAdicional25 = $fila['NcrDatoAdicional25'];
				$this->NcrDatoAdicional26 = $fila['NcrDatoAdicional26'];

				$this->NcrDatoAdicional27 = $fila['NcrDatoAdicional27'];
				$this->NcrDatoAdicional28 = $fila['NcrDatoAdicional28'];

				$this->NcrEstado = $fila['NcrEstado'];


				$this->NcrTotalImpuestoSelectivo = $fila['NcrTotalImpuestoSelectivo'];
				$this->NcrTotalGravado = $fila['NcrTotalGravado'];
				$this->NcrTotalDescuento = $fila['NcrTotalDescuento'];
				$this->NcrTotalGratuito = $fila['NcrTotalGratuito'];
				$this->NcrTotalExonerado = $fila['NcrTotalExonerado'];
				$this->NcrTotalPagar = $fila['NcrTotalPagar'];

				$this->NcrSubTotal = ($fila['NcrSubTotal']);
				$this->NcrDescuento = ($fila['NcrDescuento']);
				$this->NcrImpuesto = ($fila['NcrImpuesto']);
				$this->NcrTotal = ($fila['NcrTotal']);
				list($this->NcrObservacion, $this->NcrObservacionImpresa) = explode("###", $fila['NcrObservacion']);

				$this->NcrMotivo = $fila['NcrMotivo'];
				$this->NcrMotivoCodigo = $fila['NcrMotivoCodigo'];


				$this->NcrSunatRespuestaTicket = $fila['NcrSunatRespuestaTicket'];
				$this->NcrSunatRespuestaTicketEstado = $fila['NcrSunatRespuestaTicketEstado'];
				$this->NcrSunatRespuestaObservacion = $fila['NcrSunatRespuestaObservacion'];

				$this->NcrSunatRespuestaEnvioTicket = $fila['NcrSunatRespuestaEnvioTicket'];
				$this->NcrSunatRespuestaEnvioTicketEstado = $fila['NcrSunatRespuestaEnvioTicketEstado'];
				$this->NcrSunatRespuestaEnvioFecha = $fila['NNcrSunatRespuestaEnvioFecha'];
				$this->NcrSunatRespuestaEnvioHora = $fila['NcrSunatRespuestaEnvioHora'];
				$this->NcrSunatRespuestaEnvioCodigo = $fila['NcrSunatRespuestaEnvioCodigo'];
				$this->NcrSunatRespuestaEnvioContenido = $fila['NcrSunatRespuestaEnvioContenido'];

				$this->NcrSunatRespuestaBajaTicket = $fila['NcrSunatRespuestaBajaTicket'];
				$this->NcrSunatRespuestaBajaTicketEstado = $fila['NcrSunatRespuestaBajaTicketEstado'];
				$this->NcrSunatRespuestaBajaFecha = $fila['NNcrSunatRespuestaBajaFecha'];
				$this->NcrSunatRespuestaBajaHora = $fila['NcrSunatRespuestaBajaHora'];
				$this->NcrSunatRespuestaBajaCodigo = $fila['NcrSunatRespuestaBajaCodigo'];
				$this->NcrSunatRespuestaBajaContenido = $fila['NcrSunatRespuestaBajaContenido'];
				$this->NcrSunatRespuestaBajaId = $fila['NcrSunatRespuestaBajaId'];

				$this->NcrSunatRespuestaConsultaCodigo = $fila['NcrSunatRespuestaConsultaCodigo'];
				$this->NcrSunatRespuestaConsultaContenido = $fila['NcrSunatRespuestaConsultaContenido'];
				$this->NcrSunatRespuestaConsultaFecha = $fila['NNcrSunatRespuestaConsultaFecha'];
				$this->NcrSunatRespuestaConsultaHora = $fila['NcrSunatRespuestaConsultaHora'];

				$this->NcrSunatRespuestaEnvioTiempoCreacion = $fila['NNcrSunatRespuestaEnvioTiempoCreacion'];
				$this->NcrSunatRespuestaConsultaTiempoCreacion = $fila['NNcrSunatRespuestaConsultaTiempoCreacion'];
				$this->NcrSunatRespuestaBajaTiempoCreacion = $fila['NNcrSunatRespuestaBajaTiempoCreacion'];



				$this->NcrSunatUltimaAccion = $fila['NcrSunatUltimaAccion'];
				$this->NcrSunatUltimaRespuesta = $fila['NcrSunatUltimaRespuesta'];


				$this->NcrSunatRespuestaEnvioDigestValue = $fila['NcrSunatRespuestaEnvioDigestValue'];
				$this->NcrSunatRespuestaEnvioSignatureValue = $fila['NcrSunatRespuestaEnvioSignatureValue'];


				$this->NcrUsuario = $fila['NcrUsuario'];
				$this->NcrVendedor = $fila['NcrVendedor'];
				$this->NcrNumeroPedido = $fila['NcrNumeroPedido'];


				$this->NcrCierre = $fila['NcrCierre'];
				$this->NcrTiempoCreacion = $fila['NNcrTiempoCreacion'];
				$this->NcrTiempoModificacion = $fila['NNcrTiempoModificacion'];

				$this->NotaCreditoDetalle = $ResNotaCreditoDetalle['Datos'];

				$this->NctNumero = $fila['NctNumero'];

				$this->CliNombre = $fila['CliNombre'];
				$this->TdoId = $fila['TdoId'];
				$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
				$this->CliTelefono = $fila['CliTelefono'];
				$this->CliEmail = $fila['CliEmail'];
				$this->CliContactoEmail1 = $fila['CliContactoEmail1'];
				$this->CliContactoEmail2 = $fila['CliContactoEmail2'];
				$this->CliContactoEmail3 = $fila['CliContactoEmail3'];
				$this->CliEmailFacturacion = $fila['CliEmailFacturacion'];


				$this->CliCelular = $fila['CliCelular'];
				$this->CliFax = $fila['CliFax'];

				$this->MonSimbolo = $fila['MonSimbolo'];
				$this->MonSigla = $fila['MonSigla'];
				$this->MonNombre = $fila['MonNombre'];

				$this->TdoCodigo = $fila['TdoCodigo'];
				$this->ScaNombre = $fila['ScaNombre'];

				$this->SucNombre = $fila['SucNombre'];
				$this->SucDireccion = $fila['SucDireccion'];
				$this->SucDistrito = $fila['SucDistrito'];
				$this->SucProvincia = $fila['SucProvincia'];
				$this->SucDepartamento = $fila['SucDepartamento'];
				$this->SucCodigoUbigeo = $fila['SucCodigoUbigeo'];
				$this->SucCodigoAnexo = $fila['SucCodigoAnexo'];



				if ($oCompleto) {

					$InsNotaCreditoDetalle = new ClsNotaCreditoDetalle($this->InsMysql);
					$ResNotaCreditoDetalle =  $InsNotaCreditoDetalle->MtdObtenerNotaCreditoDetalles(NULL, NULL, NULL, NULL, 1, NULL, $this->NcrId, $this->NctId);

					$this->NotaCreditoDetalle = $ResNotaCreditoDetalle['Datos'];
					if (!empty($this->OvvId)) {

						$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario($this->InsMysql);
						$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL, NULL, 'OvpId', 'ASC', NULL, $this->OvvId);
						$this->OrdenVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];

						//$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();
						//					$InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,'OvoId','ASC',NULL,$this->OvvId,NULL);
						//					$this->OrdenVentaVehiculoObsequio = $ResOrdenVentaVehiculoObsequio['Datos'];

					}
				}
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerNotaCreditos($oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'NcrId', $oSentido = 'Desc', $oEliminado = 1, $oPaginacion = '0,10', $oSucursal = NULL, $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oTalonario = NULL, $oMoneda = NULL, $oDocumentoId = NULL, $oDocumentoTalonarioId = NULL, $oSucursal = NULL, $oClienteId = NULL, $oNoProcesdado = false)
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


		if (!empty($oEstado)) {

			$elementos = explode(",", $oEstado);

			$i = 1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$estado .= '  (ncr.NcrEstado = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$estado .= ' OR ';
				}
				$i++;
			}

			$estado .= ' ) ';
		}


		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(ncr.NcrFechaEmision)>="' . $oFechaInicio . '" AND DATE(ncr.NcrFechaEmision)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(ncr.NcrFechaEmision)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(ncr.NcrFechaEmision)<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oTalonario)) {
			$talonario = ' AND ncr.NctId = "' . $oTalonario . '"';
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND ncr.MonId = "' . $oMoneda . '"';
		}


		if (!empty($oDocumentoId)) {
			$did = ' AND (ncr.FacId = "' . $oDocumentoId . '" OR ncr.BolId = "' . $oDocumentoId . '")';
		}

		if (!empty($oDocumentoTalonarioId)) {
			$dtalonario = ' AND (ncr.FtaId = "' . $oDocumentoTalonarioId . '" OR ncr.BtaId = "' . $oDocumentoTalonarioId . '")';
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND (ncr.MonId = "' . $oMoneda . '")';
		}


		if (!empty($oSucursal)) {
			$sucursal = ' AND (ncr.SucId = "' . $oSucursal . '")';
		}

		if (!empty($oClienteId)) {
			$cliente = ' AND (ncr.CliId = "' . $oClienteId . '")';
		}

		if (($oNoProcesdado)) {

			$noprocesado = ' AND	(ncr.NcrSunatRespuestaEnvioContenido NOT LIKE "%aceptad%" 
				OR ncr.NcrSunatRespuestaEnvioContenido IS NULL 
				OR ncr.NcrSunatRespuestaEnvioContenido  = ""
				
				) ';
		}




		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ncr.NcrId,
				ncr.NctId,
				ncr.SucId,
				
				ncr.OvvId,
				ncr.VdiId,
				
				ncr.AmoId,
				ncr.VmvId,
				
				cli.CliId,
				DATE_FORMAT(ncr.NcrFechaEmision, "%d/%m/%Y") AS "NNcrFechaEmision",
DATE_FORMAT(ncr.NcrTiempoCreacion, "%H:%i:%s") AS "NcrHoraEmision",
				DATEDIFF(DATE(NOW()),ncr.NcrFechaEmision) AS NcrDiaTranscurrido,
				ncr.NcrDireccion,
				
				CASE ncr.NcrTipo
				WHEN 2 THEN (ncr.FacId)
				WHEN 3 THEN (ncr.BolId)
				ELSE NULL
				END AS "DocId",					
			
				CASE ncr.NcrTipo
				WHEN 2 THEN (ncr.FtaId)
				WHEN 3 THEN (ncr.BtaId)
				ELSE NULL
				END AS "DtaId" ,
				
				CASE ncr.NcrTipo
				WHEN 2 THEN (fta.FtaNumero)
				WHEN 3 THEN (bta.BtaNumero)
				ELSE NULL
				END AS "DtaNumero" ,
				
				CASE ncr.NcrTipo
				WHEN 2 THEN DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
				WHEN 3 THEN DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
				ELSE NULL
				END AS "DocFechaEmision",
				
					CASE ncr.NcrTipo
				WHEN 2 THEN ("01")
				WHEN 3 THEN ("03")
				ELSE NULL
				END AS "DocTipoDocumentoCodigo",	
				
				ncr.NcrIncluyeImpuesto,
				ncr.NcrPorcentajeImpuestoVenta,
				ncr.NcrPorcentajeImpuestoSelectivo,
							
				ncr.MonId,
				ncr.NcrTipoCambio,
				ncr.NcrTipoCambioAux,
				
				ncr.NcrTipo,
				
								ncr.NcrDatoAdicional1,
				ncr.NcrDatoAdicional2,
				ncr.NcrDatoAdicional3,
				ncr.NcrDatoAdicional4,
				ncr.NcrDatoAdicional5,
				ncr.NcrDatoAdicional6,
				ncr.NcrDatoAdicional7,
				ncr.NcrDatoAdicional8,
				ncr.NcrDatoAdicional9,
				ncr.NcrDatoAdicional10,
				
				ncr.NcrDatoAdicional11,
				ncr.NcrDatoAdicional12,
				ncr.NcrDatoAdicional13,
				ncr.NcrDatoAdicional14,
				ncr.NcrDatoAdicional15,
				ncr.NcrDatoAdicional16,
				ncr.NcrDatoAdicional17,
				ncr.NcrDatoAdicional18,
				ncr.NcrDatoAdicional19,
				ncr.NcrDatoAdicional20,
				
				ncr.NcrDatoAdicional21,
				ncr.NcrDatoAdicional22,
				ncr.NcrDatoAdicional23,
				ncr.NcrDatoAdicional24,
				ncr.NcrDatoAdicional25,
ncr.NcrDatoAdicional26,
ncr.NcrDatoAdicional27,
ncr.NcrDatoAdicional28,
				
				ncr.NcrEstado,					
				
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalImpuestoSelectivo) AS "NcrTotalImpuestoSelectivo",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalGravado) AS "NcrTotalGravado",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalDescuento) AS "NcrTotalDescuento",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalGratuito) AS "NcrTotalGratuito",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalExonerado) AS "NcrTotalExonerado",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotalPagar) AS "NcrTotalPagar",	
				
				
				IF(ncr.NcrEstado=6,0.00,ncr.NcrSubTotal) AS "NcrSubTotal",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrImpuesto) AS "NcrImpuesto",	
				IF(ncr.NcrEstado=6,0.00,ncr.NcrTotal) AS "NcrTotal",	
							
				ncr.NcrObservacion,
				ncr.NcrMotivo,
				ncr.NcrMotivoCodigo,
				
				ncr.NcrSunatRespuestaTicket,
				ncr.NcrSunatRespuestaTicketEstado,
				ncr.NcrSunatRespuestaObservacion,
				
				ncr.NcrSunatRespuestaEnvioTicket,
				ncr.NcrSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaEnvioFecha",
				ncr.NcrSunatRespuestaEnvioHora,
				ncr.NcrSunatRespuestaEnvioCodigo,
				ncr.NcrSunatRespuestaEnvioContenido,
				
				ncr.NcrSunatRespuestaBajaTicket,
				ncr.NcrSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaBajaFecha",
				ncr.NcrSunatRespuestaBajaHora,				
				ncr.NcrSunatRespuestaBajaCodigo,
				ncr.NcrSunatRespuestaBajaContenido,
				ncr.NcrSunatRespuestaBajaId,
				
				ncr.NcrSunatRespuestaConsultaCodigo,
				ncr.NcrSunatRespuestaConsultaContenido,
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNcrSunatRespuestaConsultaFecha",
				ncr.NcrSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ncr.NcrSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ncr.NcrSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrSunatRespuestaBajaTiempoCreacion",
				
				ncr.NcrSunatUltimaAccion,
				ncr.NcrSunatUltimaRespuesta,
				
				ncr.NcrCierre,
			
				DATE_FORMAT(ncr.NcrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcrTiempoCreacion",
                DATE_FORMAT(ncr.NcrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNcrTiempoModificacion",

				(SELECT COUNT(ncd.NcdId) FROM tblncdnotacreditodetalle ncd WHERE ncd.NcrId = ncr.NcrId AND ncd.NctId = ncr.NctId ) AS "NcrTotalItems",
	
				nct.NctNumero,
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.TdoId,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax	,
				
				mon.MonSigla,
				mon.MonNombre,
				mon.MonSimbolo,
				
				tdo.TdoNombre,
				tdo.TdoCodigo,
				
				
				suc.SucNombre,
				suc.SucSiglas
				
				FROM tblncrnotacredito ncr
				
				
					LEFT JOIN tblsucsucursal suc
					ON ncr.SucId = suc.SucId
					
					
				LEFT JOIN tblnctnotacreditotalonario nct
				ON ncr.NctId = nct.NctId
				
					LEFT JOIN tblfacfactura fac
					ON (ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId)
					
						LEFT JOIN tblftafacturatalonario fta 
						ON fac.FtaId = fta.FtaId
						
					LEFT JOIN tblbolboleta bol
					ON (ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId)
						
						LEFT JOIN tblbtaboletatalonario bta 
						ON ncr.BtaId = bta.BtaId
								
				LEFT JOIN tblclicliente cli
				  ON (ncr.CliId = cli.CliId)
					
					LEFT JOIN tblmonmoneda mon
					ON ncr.MonId = mon.MonId
						
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
					
				WHERE 1 = 1 ' . $filtrar . $sucursal . $estado . $did . $dtalonario . $noprocesado . $cliente . $fecha . $moneda . $talonario . $credito . $regimen . $npago . $orden . $paginacion;
		/*LEFT JOIN tblclicliente cli
				  ON (ncr.CliId = cli.CliId OR bol.CliId = cli.CliId)*/


		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsNotaCredito = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$NotaCredito = new $InsNotaCredito();
			$NotaCredito->NcrId = $fila['NcrId'];
			$NotaCredito->NctId = $fila['NctId'];
			$NotaCredito->SucId = $fila['SucId'];

			$NotaCredito->OvvId = $fila['OvvId'];
			$NotaCredito->VdiId = $fila['VdiId'];

			$NotaCredito->AmoId = $fila['AmoId'];
			$NotaCredito->VmvId = $fila['VmvId'];

			$NotaCredito->CliId = $fila['CliId'];
			$NotaCredito->NcrDireccion = $fila['NcrDireccion'];
			$NotaCredito->NcrFechaEmision = $fila['NNcrFechaEmision'];
			$NotaCredito->NcrHoraEmision = $fila['NcrHoraEmision'];
			$NotaCredito->NcrDiaTranscurrido = $fila['NcrDiaTranscurrido'];

			$NotaCredito->DocId = $fila['DocId'];
			$NotaCredito->DtaId = $fila['DtaId'];
			$NotaCredito->DtaNumero = $fila['DtaNumero'];
			$NotaCredito->DocFechaEmision = $fila['DocFechaEmision'];
			$NotaCredito->DocTipoDocumentoCodigo = $fila['DocTipoDocumentoCodigo'];



			$NotaCredito->NcrIncluyeImpuesto = $fila['NcrIncluyeImpuesto'];
			$NotaCredito->NcrPorcentajeImpuestoVenta = $fila['NcrPorcentajeImpuestoVenta'];
			$NotaCredito->NcrPorcentajeImpuestoSelectivo = $fila['NcrPorcentajeImpuestoSelectivo'];

			$NotaCredito->MonId = $fila['MonId'];
			$NotaCredito->NcrTipoCambio = $fila['NcrTipoCambio'];
			$NotaCredito->NcrTipoCambioAux = $fila['NcrTipoCambioAux'];

			$NotaCredito->NcrTipo = $fila['NcrTipo'];

			$NotaCredito->NcrDatoAdicional1 = $fila['NcrDatoAdicional1'];
			$NotaCredito->NcrDatoAdicional2 = $fila['NcrDatoAdicional2'];
			$NotaCredito->NcrDatoAdicional3 = $fila['NcrDatoAdicional3'];
			$NotaCredito->NcrDatoAdicional4 = $fila['NcrDatoAdicional4'];
			$NotaCredito->NcrDatoAdicional5 = $fila['NcrDatoAdicional5'];
			$NotaCredito->NcrDatoAdicional6 = $fila['NcrDatoAdicional6'];
			$NotaCredito->NcrDatoAdicional7 = $fila['NcrDatoAdicional7'];
			$NotaCredito->NcrDatoAdicional8 = $fila['NcrDatoAdicional8'];
			$NotaCredito->NcrDatoAdicional9 = $fila['NcrDatoAdicional9'];
			$NotaCredito->NcrDatoAdicional10 = $fila['NcrDatoAdicional10'];

			$NotaCredito->NcrDatoAdicional11 = $fila['NcrDatoAdicional11'];
			$NotaCredito->NcrDatoAdicional12 = $fila['NcrDatoAdicional12'];
			$NotaCredito->NcrDatoAdicional13 = $fila['NcrDatoAdicional13'];
			$NotaCredito->NcrDatoAdicional14 = $fila['NcrDatoAdicional14'];
			$NotaCredito->NcrDatoAdicional15 = $fila['NcrDatoAdicional15'];
			$NotaCredito->NcrDatoAdicional16 = $fila['NcrDatoAdicional16'];
			$NotaCredito->NcrDatoAdicional17 = $fila['NcrDatoAdicional17'];
			$NotaCredito->NcrDatoAdicional18 = $fila['NcrDatoAdicional18'];
			$NotaCredito->NcrDatoAdicional19 = $fila['NcrDatoAdicional19'];
			$NotaCredito->NcrDatoAdicional20 = $fila['NcrDatoAdicional20'];

			$NotaCredito->NcrDatoAdicional21 = $fila['NcrDatoAdicional21'];
			$NotaCredito->NcrDatoAdicional22 = $fila['NcrDatoAdicional22'];
			$NotaCredito->NcrDatoAdicional23 = $fila['NcrDatoAdicional23'];
			$NotaCredito->NcrDatoAdicional24 = $fila['NcrDatoAdicional24'];
			$NotaCredito->NcrDatoAdicional25 = $fila['NcrDatoAdicional25'];
			$NotaCredito->NcrDatoAdicional26 = $fila['NcrDatoAdicional26'];


			$NotaCredito->NcrDatoAdicional27 = $fila['NcrDatoAdicional27'];
			$NotaCredito->NcrDatoAdicional28 = $fila['NcrDatoAdicional28'];

			$NotaCredito->NcrEstado = $fila['NcrEstado'];

			$NotaCredito->NcrTotalImpuestoSelectivo = $fila['NcrTotalImpuestoSelectivo'];
			$NotaCredito->NcrTotalGravado = $fila['NcrTotalGravado'];
			$NotaCredito->NcrTotalDescuento = $fila['NcrTotalDescuento'];
			$NotaCredito->NcrTotalGratuito = $fila['NcrTotalGratuito'];
			$NotaCredito->NcrTotalExonerado = $fila['NcrTotalExonerado'];
			$NotaCredito->NcrTotalPagar = $fila['NcrTotalPagar'];

			$NotaCredito->NcrSubTotal = $fila['NcrSubTotal'];
			$NotaCredito->NcrDescuento = $fila['NcrDescuento'];
			$NotaCredito->NcrImpuesto = $fila['NcrImpuesto'];
			$NotaCredito->NcrTotal = $fila['NcrTotal'];

			list($NotaCredito->NcrObservacion, $NotaCredito->NcrObservacionImpresa) = explode("###", $fila['NcrObservacion']);
			$NotaCredito->NcrMotivo = $fila['NcrMotivo'];
			$NotaCredito->NcrMotivoCodigo = $fila['NcrMotivoCodigo'];

			$NotaCredito->NcrSunatRespuestaTicket = $fila['NcrSunatRespuestaTicket'];
			$NotaCredito->NcrSunatRespuestaTicketEstado = $fila['NcrSunatRespuestaTicketEstado'];
			$NotaCredito->NcrSunatRespuestaObservacion = $fila['NcrSunatRespuestaObservacion'];

			$NotaCredito->NcrSunatRespuestaEnvioTicket = $fila['NcrSunatRespuestaEnvioTicket'];
			$NotaCredito->NcrSunatRespuestaEnvioTicketEstado = $fila['NcrSunatRespuestaEnvioTicketEstado'];
			$NotaCredito->NcrSunatRespuestaEnvioFecha = $fila['NNcrSunatRespuestaEnvioFecha'];
			$NotaCredito->NcrSunatRespuestaEnvioHora = $fila['NcrSunatRespuestaEnvioHora'];
			$NotaCredito->NcrSunatRespuestaEnvioCodigo = $fila['NcrSunatRespuestaEnvioCodigo'];
			$NotaCredito->NcrSunatRespuestaEnvioContenido = $fila['NcrSunatRespuestaEnvioContenido'];

			$NotaCredito->NcrSunatRespuestaBajaTicket = $fila['NcrSunatRespuestaBajaTicket'];
			$NotaCredito->NcrSunatRespuestaBajaTicketEstado = $fila['NcrSunatRespuestaBajaTicketEstado'];
			$NotaCredito->NcrSunatRespuestaBajaFecha = $fila['NNcrSunatRespuestaBajaFecha'];
			$NotaCredito->NcrSunatRespuestaBajaHora = $fila['NcrSunatRespuestaBajaHora'];
			$NotaCredito->NcrSunatRespuestaBajaCodigo = $fila['NcrSunatRespuestaBajaCodigo'];
			$NotaCredito->NcrSunatRespuestaBajaContenido = $fila['NcrSunatRespuestaBajaContenido'];
			$NotaCredito->NcrSunatRespuestaBajaId = $fila['NcrSunatRespuestaBajaId'];

			$NotaCredito->NcrSunatRespuestaConsultaCodigo = $fila['NcrSunatRespuestaConsultaCodigo'];
			$NotaCredito->NcrSunatRespuestaConsultaContenido = $fila['NcrSunatRespuestaConsultaContenido'];
			$NotaCredito->NcrSunatRespuestaConsultaFecha = $fila['NNcrSunatRespuestaConsultaFecha'];
			$NotaCredito->NcrSunatRespuestaConsultaHora = $fila['NcrSunatRespuestaConsultaHora'];

			$NotaCredito->NcrSunatRespuestaEnvioTiempoCreacion = $fila['NNcrSunatRespuestaEnvioTiempoCreacion'];
			$NotaCredito->NcrSunatRespuestaConsultaTiempoCreacion = $fila['NNcrSunatRespuestaConsultaTiempoCreacion'];
			$NotaCredito->NcrSunatRespuestaBajaTiempoCreacion = $fila['NNcrSunatRespuestaBajaTiempoCreacion'];

			$NotaCredito->NcrSunatUltimaAccion = $fila['NcrSunatUltimaAccion'];
			$NotaCredito->NcrSunatUltimaRespuesta = $fila['NcrSunatUltimaRespuesta'];

			$NotaCredito->NcrCierre = $fila['NcrCierre'];
			$NotaCredito->NcrTiempoCreacion = $fila['NNcrTiempoCreacion'];
			$NotaCredito->NcrTiempoModificacion = $fila['NNcrTiempoModificacion'];

			$NotaCredito->NcrTotalItems = $fila['NcrTotalItems'];

			$NotaCredito->NctNumero = $fila['NctNumero'];

			if ($NotaCredito->NcrEstado == 6) {

				$NotaCredito->CliNombreCompleto = "ANULADO";
				$NotaCredito->CliNombre = "ANULADO";
				$NotaCredito->CliApellidoPaterno = "";
				$NotaCredito->CliApellidoMaterno = "";
			} else {

				$NotaCredito->CliNombreCompleto = $fila['CliNombreCompleto'];
				$NotaCredito->CliNombre = $fila['CliNombre'];
				$NotaCredito->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$NotaCredito->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			}


			$NotaCredito->TdoId = $fila['TdoId'];
			$NotaCredito->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$NotaCredito->CliTelefono = $fila['CliTelefono'];
			$NotaCredito->CliEmail = $fila['CliEmail'];
			$NotaCredito->CliCelular = $fila['CliCelular'];
			$NotaCredito->CliFax = $fila['CliFax'];


			$NotaCredito->MonSigla = $fila['MonSigla'];
			$NotaCredito->MonNombre = $fila['MonNombre'];
			$NotaCredito->MonSimbolo = $fila['MonSimbolo'];

			$NotaCredito->TdoNombre = $fila['TdoNombre'];
			$NotaCredito->TdoCodigo = $fila['TdoCodigo'];

			$NotaCredito->SucNombre = $fila['SucNombre'];
			$NotaCredito->SucSiglas = $fila['SucSiglas'];



			switch ($NotaCredito->NcrEstado) {
				case 1:
					$NotaCredito->NcrEstadoDescripcion = "Pendiente";
					break;

				case 5:
					$NotaCredito->NcrEstadoDescripcion = "Entregado";
					break;

				case 6:
					$NotaCredito->NcrEstadoDescripcion = "Anulado";

					break;

				case 7:
					$NotaCredito->NcrEstadoDescripcion = "Reservado";
					break;
			}



			$NotaCredito->InsMysql = NULL;

			$Respuesta['Datos'][] = $NotaCredito;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}

	public function MtdObtenerNotaCreditosValor($oFuncion = "SUM", $oParametro = "NcrId", $oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'NcrId', $oSentido = 'Desc', $oEliminado = 1, $oPaginacion = '0,10', $oSucursal = NULL, $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oMes = NULL, $oAno = NULL)
	{


		if (!empty($oCampo) && !empty($oFiltro)) {

			$oFiltro = str_replace(" ", "%", $oFiltro);

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
			$sucursal = ' AND nct.SucId = "' . $oSucursal . '"';
		}

		if (!empty($oEstado)) {

			$elementos = explode(",", $oEstado);

			$i = 1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$estado .= '  (ncr.NcrEstado = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$estado .= ' OR ';
				}
				$i++;
			}

			$estado .= ' ) ';
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(ncr.NcrFechaEmision)>="' . $oFechaInicio . '" AND DATE(ncr.NcrFechaEmision)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(ncr.NcrFechaEmision)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(ncr.NcrFechaEmision)<="' . $oFechaFin . '"';
			}
		}

		if (!empty($oFuncion) & !empty($oParametro)) {
			$funcion = $oFuncion . '(' . $oParametro . ')';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(ncr.NcrFechaEmision) ="' . ($oMes) . '"';
		}

		if (!empty($oAno)) {
			$ano = ' AND YEAR(ncr.NcrFechaEmision) ="' . ($oAno) . '"';
		}

		$sql = 'SELECT

		
				' . $funcion . ' AS "RESULTADO"
				FROM tblncrnotacredito ncr
				
				LEFT JOIN tblnctnotacreditotalonario nct
				ON ncr.NctId = nct.NctId
								
				LEFT JOIN tblclicliente cli
				ON ncr.CliId = cli.CliId
				

				
				WHERE 1 = 1 ' . $filtrar . $sucursal . $estado . $fecha . $mes . $ano . $orden . $paginacion;


		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);


		settype($fila['RESULTADO'], "float");

		return $fila['RESULTADO'];
	}



	public function MtdActualizarEstadoNotaCredito($oElementos, $oEstado)
	{

		$accion = '';
		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$aux = explode("%", $elemento);

				/*if($i==count($elementos)){						
						$accion .= '  (NcrId = "'.($aux[0]).'" AND NctId = "'.($aux[1]).'")';	
					}else{
						$accion .= '  (NcrId = "'.($aux[0]).'" AND NctId = "'.($aux[1]).'")  OR';	
					}	*/


				$sql = 'UPDATE tblncrnotacredito SET NcrEstado = ' . $oEstado . ' WHERE   (NcrId = "' . ($aux[0]) . '" AND NctId = "' . ($aux[1]) . '")';

				$resultado = $this->InsMysql->MtdEjecutar($sql, false);

				if (!$resultado) {
					$error = true;
				} else {
					$this->NcrId = $aux[0];
					$this->NctId = $aux[1];
					$this->MtdAuditarNotaCredito(2, "Se actualizo el Estado de la Nota de Credito", $aux);
				}
			}
			$i++;
		}

		/*$sql = 'UPDATE tblncrnotacredito SET NcrEstado = '.$oEstado.' WHERE '.$accion;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	*/

		if ($error) {
			return false;
		} else {
			return true;
		}
	}

	//Accion eliminar	 

	public function MtdEliminarNotaCredito($oElementos)
	{

		$elementos = explode("#", $oElementos);


		$i = 1;
		foreach ($elementos as $elemento) {

			if (!empty($elemento)) {

				$aux = explode("%", $elemento);
				/*		
					if($i==count($elementos)){						
						$eliminar .= '  (NcrId = "'.($aux[0]).'" AND NctId = "'.($aux[1]).'")';	
					}else{
						$eliminar .= '  (NcrId = "'.($aux[0]).'" AND NctId = "'.($aux[1]).'")  OR';	
					}	*/

				$sql = 'DELETE FROM tblncrnotacredito WHERE (NcrId = "' . ($aux[0]) . '" AND NctId = "' . ($aux[1]) . '")';

				$resultado = $this->InsMysql->MtdEjecutar($sql, false);

				if (!$resultado) {
					$error = true;
				} else {
					$this->NcrId = $aux[0];
					$this->NctId = $aux[1];
					$this->MtdAuditarNotaCredito(3, "Se elimino la Nota de Credito", $aux);
				}
			}
			$i++;
		}


		/*			$sql = 'DELETE FROM tblncrnotacredito WHERE '.$eliminar;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		*/

		if ($error) {
			return false;
		} else {
			return true;
		}
	}


	public function MtdRegistrarNotaCredito()
	{

		global $Resultado;
		$error = false;

		//if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->NcrFechaEmision))){
		//			$error = true;
		//			$Resultado.='#ERR_NCR_400';
		//		}else{

		$this->NcrId = trim($this->NcrId);

		$this->InsMysql->MtdTransaccionIniciar();

		//deb($this->NcrTipo." aaa");

		switch ($this->NcrTipo) {
			case 2:
				$detalle = '"' . $this->DocId . '", "' . $this->DtaId . '", NULL, NULL,';
				break;

			case 3:
				$detalle = 'NULL, NULL, "' . $this->DocId . '", "' . $this->DtaId . '",';
				break;

			default:
				$detalle = 'NULL,NULL,NULL,NULL,';
				break;
		}

		//$this->MtdGenerarNotaCreditoId();

		$sql = 'INSERT INTO tblncrnotacredito (
				NcrId,
				NctId,
				SucId,
				 
				FacId,
				FtaId,
				BolId,
				BtaId,
				
				OvvId,
				VdiId,
				
				AmoId,
				VmvId,
				
				CliId,
				NcrTipo,
				NcrEstado,
				NcrFechaEmision,
				NcrDireccion,
				
				NcrTotalImpuestoSelectivo,
				NcrTotalPagar,	
				NcrTotalExonerado,	
				NcrTotalDescuento,	
				NcrTotalGratuito,	
				NcrTotalGravado,
				
				NcrSubTotal,
				NcrImpuesto,
				NcrTotal,
				
				NcrObservacion,
				NcrMotivo,
				NcrMotivoCodigo,

				NcrIncluyeImpuesto,
				NcrPorcentajeImpuestoVenta,
				NcrPorcentajeImpuestoSelectivo,
				
				MonId,
				NcrTipoCambio,
				
				NcrDatoAdicional1,
				NcrDatoAdicional2,
				NcrDatoAdicional3,
				NcrDatoAdicional4,
				NcrDatoAdicional5,
				NcrDatoAdicional6,
				NcrDatoAdicional7,
				NcrDatoAdicional8,
				NcrDatoAdicional9,
				NcrDatoAdicional10,
				
				NcrDatoAdicional11,
				NcrDatoAdicional12,
				NcrDatoAdicional13,
				NcrDatoAdicional14,
				NcrDatoAdicional15,
				NcrDatoAdicional16,
				NcrDatoAdicional17,
				NcrDatoAdicional18,
				NcrDatoAdicional19,
				NcrDatoAdicional20,
				
				NcrDatoAdicional21,
				NcrDatoAdicional22,
				NcrDatoAdicional23,
				NcrDatoAdicional24,
				NcrDatoAdicional25,
				NcrDatoAdicional26,
				
				NcrDatoAdicional27,
				NcrDatoAdicional28,
				
				NcrCierre,
				NcrTiempoCreacion,
				NcrTiempoModificacion
				) 
				VALUES (
				"' . ($this->NcrId) . '", 
				"' . ($this->NctId) . '",
				"' . ($this->SucId) . '",

				' . $detalle . '
				
				' . (empty($this->OvvId) ? 'NULL, ' : '"' . $this->OvvId . '",') . '			
				' . (empty($this->VdiId) ? 'NULL, ' : '"' . $this->VdiId . '",') . '			
				' . (empty($this->AmoId) ? 'NULL, ' : '"' . $this->AmoId . '",') . '			
				' . (empty($this->VmvId) ? 'NULL, ' : '"' . $this->VmvId . '",') . '			

				
				"' . ($this->CliId) . '",
				' . ($this->NcrTipo) . ',				
				' . ($this->NcrEstado) . ',				
				"' . ($this->NcrFechaEmision) . '",
				"' . ($this->NcrDireccion) . '",

				' . ($this->NcrTotalImpuestoSelectivo) . ',
				' . ($this->NcrTotalPagar) . ',
				' . ($this->NcrTotalExonerado) . ',
				' . ($this->NcrTotalDescuento) . ',
				' . ($this->NcrTotalGratuito) . ',
				' . ($this->NcrTotalGravado) . ',

				' . ($this->NcrSubTotal) . ',
				' . ($this->NcrImpuesto) . ',
				' . ($this->NcrTotal) . ',

				"' . ($this->NcrObservacion) . '", 
				"' . addslashes($this->NcrMotivo) . '", 
				"' . ($this->NcrMotivoCodigo) . '", 

				' . ($this->NcrIncluyeImpuesto) . ', 
				' . ($this->NcrPorcentajeImpuestoVenta) . ', 				
				' . ($this->NcrPorcentajeImpuestoSelectivo) . ', 				
				
				"' . ($this->MonId) . '", 
				' . (empty($this->NcrTipoCambio) ? 'NULL, ' : '' . $this->NcrTipoCambio . ',') . '
				
				"' . ($this->NcrDatoAdicional1) . '", 
				"' . ($this->NcrDatoAdicional2) . '", 
				"' . ($this->NcrDatoAdicional3) . '", 
				"' . ($this->NcrDatoAdicional4) . '", 
				"' . ($this->NcrDatoAdicional5) . '", 
				"' . ($this->NcrDatoAdicional6) . '", 
				"' . ($this->NcrDatoAdicional7) . '", 
				"' . ($this->NcrDatoAdicional8) . '", 
				"' . ($this->NcrDatoAdicional9) . '", 
				"' . ($this->NcrDatoAdicional10) . '", 
				
				"' . ($this->NcrDatoAdicional11) . '", 
				"' . ($this->NcrDatoAdicional12) . '", 
				"' . ($this->NcrDatoAdicional13) . '", 
				"' . ($this->NcrDatoAdicional14) . '", 
				"' . ($this->NcrDatoAdicional15) . '", 
				"' . ($this->NcrDatoAdicional16) . '", 
				"' . ($this->NcrDatoAdicional17) . '", 
				"' . ($this->NcrDatoAdicional18) . '", 
				"' . ($this->NcrDatoAdicional19) . '", 
				"' . ($this->NcrDatoAdicional20) . '", 
				
				"' . ($this->NcrDatoAdicional21) . '", 
				"' . ($this->NcrDatoAdicional22) . '", 
				"' . ($this->NcrDatoAdicional23) . '", 
				"' . ($this->NcrDatoAdicional24) . '", 
				"' . ($this->NcrDatoAdicional25) . '", 
				"' . ($this->NcrDatoAdicional26) . '", 
				
				"' . ($this->NcrDatoAdicional27) . '", 
				"' . ($this->NcrDatoAdicional28) . '", 
				
				2, 
				"' . ($this->NcrTiempoCreacion) . '", 
				"' . ($this->NcrTiempoModificacion) . '");';

		if (!$error) {
			$resultado = $this->InsMysql->MtdEjecutar($sql, false);
			if (!$resultado) {
				$error = true;
			}
		}

		if (!$error) {

			if (!empty($this->NotaCreditoDetalle)) {

				$validar = 0;
				$InsNotaCreditoDetalle = new ClsNotaCreditoDetalle($this->InsMysql);

				foreach ($this->NotaCreditoDetalle as $DatNotaCreditoDetalle) {

					$InsNotaCreditoDetalle->NcrId = $this->NcrId;
					$InsNotaCreditoDetalle->NctId = $this->NctId;

					$InsNotaCreditoDetalle->NcdCodigo = $DatNotaCreditoDetalle->NcdCodigo;
					$InsNotaCreditoDetalle->NcdDescripcion = $DatNotaCreditoDetalle->NcdDescripcion;
					$InsNotaCreditoDetalle->NcdUnidadMedida = $DatNotaCreditoDetalle->NcdUnidadMedida;

					$InsNotaCreditoDetalle->NcdPrecio = $DatNotaCreditoDetalle->NcdPrecio;
					$InsNotaCreditoDetalle->NcdCantidad = $DatNotaCreditoDetalle->NcdCantidad;
					$InsNotaCreditoDetalle->NcdImporte = $DatNotaCreditoDetalle->NcdImporte;

					$InsNotaCreditoDetalle->NcdValorVenta = $DatNotaCreditoDetalle->NcdValorVenta;
					$InsNotaCreditoDetalle->NcdImpuesto = $DatNotaCreditoDetalle->NcdImpuesto;
					$InsNotaCreditoDetalle->NcdImpuestoSelectivo = $DatNotaCreditoDetalle->NcdImpuestoSelectivo;

					$InsNotaCreditoDetalle->NcdDescuento = $DatNotaCreditoDetalle->NcdDescuento;
					$InsNotaCreditoDetalle->NcdGratuito = $DatNotaCreditoDetalle->NcdGratuito;
					$InsNotaCreditoDetalle->NcdExonerado = $DatNotaCreditoDetalle->NcdExonerado;
					$InsNotaCreditoDetalle->NcdIncluyeSelectivo = $DatNotaCreditoDetalle->NcdIncluyeSelectivo;

					$InsNotaCreditoDetalle->NcdEstado = $this->NcrEstado;
					$InsNotaCreditoDetalle->NcdTiempoCreacion = $DatNotaCreditoDetalle->NcdTiempoCreacion;
					$InsNotaCreditoDetalle->NcdTiempoModificacion = $DatNotaCreditoDetalle->NcdTiempoModificacion;
					$InsNotaCreditoDetalle->NcdEliminado = $DatNotaCreditoDetalle->NcdEliminado;

					if ($InsNotaCreditoDetalle->MtdRegistrarNotaCreditoDetalle()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_NCR_201';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->NotaCreditoDetalle) <> $validar) {
					$error = true;
				}
			}
		}




		//}

		if ($error) {

			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {

			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarNotaCredito(1, "Se registro la Nota de Credito", $this);
			return true;
		}
	}

	public function MtdEditarNotaCredito()
	{

		global $Resultado;
		$error = false;

		//if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->NcrFechaEmision))){
		//			$error = true;
		//			$Resultado.='#ERR_NCR_400';
		//		}else{
		switch ($this->NcrTipo) {

			case 2:
				$detalle = 'FacId = "' . $this->DocId . '", FtaId = "' . $this->DtaId . '", BolId = NULL, BtaId = NULL,';
				break;

			case 3:
				$detalle = 'FacId = NULL, FtaId = NULL, BolId = "' . $this->DocId . '", BtaId = "' . $this->DtaId . '",';
				break;

			default:
				$detalle = 'NULL,NULL,NULL,NULL,';
				break;
		}

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblncrnotacredito SET 
				' . $detalle . '
				CliId = "' . ($this->CliId) . '",
				NcrEstado = "' . ($this->NcrEstado) . '",
				NcrFechaEmision = "' . ($this->NcrFechaEmision) . '",
				NcrDireccion = "' . ($this->NcrDireccion) . '",

				NcrTotalImpuestoSelectivo = ' . ($this->NcrTotalImpuestoSelectivo) . ',
				NcrTotalPagar = ' . ($this->NcrTotalPagar) . ',
				NcrTotalExonerado = ' . ($this->NcrTotalExonerado) . ',
				NcrTotalDescuento = ' . ($this->NcrTotalDescuento) . ',
				NcrTotalGratuito = ' . ($this->NcrTotalGratuito) . ',
				NcrTotalGravado = ' . ($this->NcrTotalGravado) . ',
				
				NcrSubTotal = ' . ($this->NcrSubTotal) . ',
				NcrImpuesto = ' . ($this->NcrImpuesto) . ',
				NcrTotal = ' . ($this->NcrTotal) . ',	
						
				NcrObservacion = "' . ($this->NcrObservacion) . '",
				NcrMotivo = "' . addslashes($this->NcrMotivo) . '",
				NcrMotivoCodigo = "' . ($this->NcrMotivoCodigo) . '",
				
				NcrIncluyeImpuesto = ' . ($this->NcrIncluyeImpuesto) . ',
				NcrPorcentajeImpuestoVenta = ' . ($this->NcrPorcentajeImpuestoVenta) . ',	
				NcrPorcentajeImpuestoSelectivo = ' . ($this->NcrPorcentajeImpuestoSelectivo) . ',	

				MonId = "' . ($this->MonId) . '",
				' . (empty($this->NcrTipoCambio) ? 'NcrTipoCambio = NULL, ' : 'NcrTipoCambio = "' . $this->NcrTipoCambio . '",') . '

				NcrDatoAdicional1 = "' . ($this->NcrDatoAdicional1) . '",
				NcrDatoAdicional2 = "' . ($this->NcrDatoAdicional2) . '",
				NcrDatoAdicional3 = "' . ($this->NcrDatoAdicional3) . '",
				NcrDatoAdicional4 = "' . ($this->NcrDatoAdicional4) . '",
				NcrDatoAdicional5 = "' . ($this->NcrDatoAdicional5) . '",
				NcrDatoAdicional6 = "' . ($this->NcrDatoAdicional6) . '",
				NcrDatoAdicional7 = "' . ($this->NcrDatoAdicional7) . '",
				NcrDatoAdicional8 = "' . ($this->NcrDatoAdicional9) . '",
				NcrDatoAdicional9 = "' . ($this->NcrDatoAdicional10) . '",
				NcrDatoAdicional10 = "' . ($this->NcrDatoAdicional1) . '",

				NcrDatoAdicional11 = "' . ($this->NcrDatoAdicional11) . '",
				NcrDatoAdicional12 = "' . ($this->NcrDatoAdicional12) . '",
				NcrDatoAdicional13 = "' . ($this->NcrDatoAdicional13) . '",
				NcrDatoAdicional14 = "' . ($this->NcrDatoAdicional14) . '",
				NcrDatoAdicional15 = "' . ($this->NcrDatoAdicional15) . '",
				NcrDatoAdicional16 = "' . ($this->NcrDatoAdicional16) . '",
				NcrDatoAdicional17 = "' . ($this->NcrDatoAdicional17) . '",
				NcrDatoAdicional18 = "' . ($this->NcrDatoAdicional18) . '",
				NcrDatoAdicional19 = "' . ($this->NcrDatoAdicional19) . '",
				NcrDatoAdicional20 = "' . ($this->NcrDatoAdicional20) . '",

				NcrDatoAdicional21 = "' . ($this->NcrDatoAdicional21) . '",
				NcrDatoAdicional22 = "' . ($this->NcrDatoAdicional22) . '",
				NcrDatoAdicional23 = "' . ($this->NcrDatoAdicional23) . '",
				NcrDatoAdicional24 = "' . ($this->NcrDatoAdicional24) . '",
				NcrDatoAdicional25 = "' . ($this->NcrDatoAdicional25) . '",
				NcrDatoAdicional26 = "' . ($this->NcrDatoAdicional26) . '",
				
				NcrDatoAdicional27 = "' . ($this->NcrDatoAdicional27) . '",
				NcrDatoAdicional28 = "' . ($this->NcrDatoAdicional28) . '",
				
				NcrUsuario = "' . ($this->NcrUsuario) . '",
				NcrVendedor = "' . ($this->NcrVendedor) . '",
				NcrNumeroPedido = "' . ($this->NcrNumeroPedido) . '",

				NcrTiempoModificacion = "' . ($this->NcrTiempoModificacion) . '"			
				WHERE NcrId = "' . ($this->NcrId) . '"
				AND NctId = "' . $this->NctId . '";';

		if (!$error) {
			$resultado = $this->InsMysql->MtdEjecutar($sql, false);
			if (!$resultado) {
				$error = true;
			}
		}

		if (!$error) {

			if (!empty($this->NotaCreditoDetalle)) {

				$validar = 0;
				$InsNotaCreditoDetalle = new ClsNotaCreditoDetalle($this->InsMysql);

				foreach ($this->NotaCreditoDetalle as $DatNotaCreditoDetalle) {

					$InsNotaCreditoDetalle->NcdId = $DatNotaCreditoDetalle->NcdId;
					$InsNotaCreditoDetalle->NcrId = $this->NcrId;
					$InsNotaCreditoDetalle->NctId = $this->NctId;

					$InsNotaCreditoDetalle->NcdCodigo = $DatNotaCreditoDetalle->NcdCodigo;
					$InsNotaCreditoDetalle->NcdDescripcion = $DatNotaCreditoDetalle->NcdDescripcion;
					$InsNotaCreditoDetalle->NcdUnidadMedida = $DatNotaCreditoDetalle->NcdUnidadMedida;

					$InsNotaCreditoDetalle->NcdPrecio = $DatNotaCreditoDetalle->NcdPrecio;
					$InsNotaCreditoDetalle->NcdCantidad = $DatNotaCreditoDetalle->NcdCantidad;
					$InsNotaCreditoDetalle->NcdImporte = $DatNotaCreditoDetalle->NcdImporte;

					$InsNotaCreditoDetalle->NcdValorVenta = $DatNotaCreditoDetalle->NcdValorVenta;
					$InsNotaCreditoDetalle->NcdImpuesto = $DatNotaCreditoDetalle->NcdImpuesto;
					$InsNotaCreditoDetalle->NcdImpuestoSelectivo = $DatNotaCreditoDetalle->NcdImpuestoSelectivo;
					$InsNotaCreditoDetalle->NcdDescuento = $DatNotaCreditoDetalle->NcdDescuento;


					$InsNotaCreditoDetalle->NcdGratuito = $DatNotaCreditoDetalle->NcdGratuito;
					$InsNotaCreditoDetalle->NcdExonerado = $DatNotaCreditoDetalle->NcdExonerado;
					$InsNotaCreditoDetalle->NcdIncluyeSelectivo = $DatNotaCreditoDetalle->NcdIncluyeSelectivo;

					$InsNotaCreditoDetalle->NcdEstado = $this->NcrEstado;
					$InsNotaCreditoDetalle->NcdTiempoCreacion = $DatNotaCreditoDetalle->NcdTiempoCreacion;
					$InsNotaCreditoDetalle->NcdTiempoModificacion = $DatNotaCreditoDetalle->NcdTiempoModificacion;
					$InsNotaCreditoDetalle->NcdEliminado = $DatNotaCreditoDetalle->NcdEliminado;

					if (empty($InsNotaCreditoDetalle->NcdId)) {
						if ($InsNotaCreditoDetalle->NcdEliminado <> 2) {
							if ($InsNotaCreditoDetalle->MtdRegistrarNotaCreditoDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_NCR_201';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsNotaCreditoDetalle->NcdEliminado == 2) {
							if ($InsNotaCreditoDetalle->MtdEliminarNotaCreditoDetalle($InsNotaCreditoDetalle->NcdId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_NCR_203';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsNotaCreditoDetalle->MtdEditarNotaCreditoDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_NCR_202';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}


				if (count($this->NotaCreditoDetalle) <> $validar) {
					$error = true;
				}
			}
		}


		//}
		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarNotaCredito(2, "Se edito la Nota de Credito", $this);
			return true;
		}
	}


	public function MtdEditarIdNotaCredito()
	{

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblncrnotacredito SET 
			NcrId = "' . ($this->NNcrId) . '",
			NcrTiempoModificacion = "' . ($this->NcrTiempoModificacion) . '"
			WHERE NcrId = "' . ($this->NcrId) . '"
			AND NctId = "' . $this->NctId . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);
		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarNotaCredito(2, "Se edito el Codigo de la Nota de Credito", $this);

			return true;
		}
	}


	private function MtdAuditarNotaCredito($oAccion, $oDescripcion, $oDatos, $oCodigo = NULL, $oUsuario = NULL, $oPersonal = NULL)
	{

		$InsAuditoria = new ClsAuditoria($this->InsMysql);
		$InsAuditoria->AudCodigo = $this->NcrId;
		$InsAuditoria->AudCodigoExtra = $this->NctId;
		$InsAuditoria->UsuId = $this->UsuId;
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


	public function MtdEditarNotaCreditoDato($oCampo, $oDato, $oId, $oTalonario)
	{

		$sql = 'UPDATE tblncrnotacredito SET 
			' . (empty($oDato) ? $oCampo . ' = NULL, ' : $oCampo . ' = "' . $oDato . '",') . '
			NcrTiempoModificacion = NOW()
			WHERE NcrId = "' . ($oId) . '"
			AND NctId = "' . ($oTalonario) . '"
			;';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			return true;
		}
	}








	public function MtdNotaCreditoGenerarArchivoXML($oTalonario, $oId, $oRuta = "")
	{

		global $EmpresaCodigo;
		global $EmpresaNombre;
		global $EmpresaDireccion;
		global $EmpresaMonedaId;

		if (!empty($oTalonario) and !empty($oId)) {


			$this->NcrId = $oId;
			$this->NctId = $oTalonario;
			$this->MtdObtenerNotaCredito(true);



			$InsNotaCredito = $this;



			//deb($InsNotaCredito->NcrTipoCambio);
			if ($InsNotaCredito->MonId <> $EmpresaMonedaId) {

				$InsNotaCredito->NcrTotalGravado = round($InsNotaCredito->NcrTotalGravado / $InsNotaCredito->NcrTipoCambio, 2);
				$InsNotaCredito->NcrTotalExonerado = round($InsNotaCredito->NcrTotalExonerado / $InsNotaCredito->NcrTipoCambio, 2);
				$InsNotaCredito->NcrTotalGratuito = round($InsNotaCredito->NcrTotalGratuito / $InsNotaCredito->NcrTipoCambio, 2);
				$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento / $InsNotaCredito->NcrTipoCambio, 2);


				$InsNotaCredito->NcrTotalPagar = round($InsNotaCredito->NcrTotalPagar / $InsNotaCredito->NcrTipoCambio, 2);
				$InsNotaCredito->NcrTotalDescuento = round($InsNotaCredito->NcrTotalDescuento / $InsNotaCredito->NcrTipoCambio, 2);

				$InsNotaCredito->NcrSubTotal = round($InsNotaCredito->NcrSubTotal / $InsNotaCredito->NcrTipoCambio, 2);
				$InsNotaCredito->NcrImpuesto = round($InsNotaCredito->NcrImpuesto / $InsNotaCredito->NcrTipoCambio, 2);
				$InsNotaCredito->NcrTotal = round($InsNotaCredito->NcrTotal / $InsNotaCredito->NcrTipoCambio, 2);
			}


			$InsNotaCredito->CliNombre = trim($InsNotaCredito->CliNombre);
			$InsNotaCredito->CliApellidoPaterno = trim($InsNotaCredito->CliApellidoPaterno);
			$InsNotaCredito->CliApellidoMaterno = trim($InsNotaCredito->CliApellidoMaterno);


			$InsNotaCredito->NcrTotal = round($InsNotaCredito->NcrTotal, 2);
			list($parte_entero, $parte_decimal) = explode(".", $InsNotaCredito->NcrTotal);

			if (empty($parte_decimal)) {
				$parte_decimal = 0;
			}

			$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);

			$numalet = new CNumeroaletra;
			$numalet->setNumero($parte_entero);
			$numalet->setMayusculas(1);
			$numalet->setGenero(1);
			$numalet->setMoneda("");
			$numalet->setPrefijo("");
			$numalet->setSufijo("");

			$NotaCreditoTotalLetras = "SON " . $numalet->letra() . " CON " . $parte_decimal . "/100 " . $InsNotaCredito->MonNombre;


			$NOMBRE = $EmpresaCodigo . '-07-' . $InsNotaCredito->NctNumero . '-' . $InsNotaCredito->NcrId;
			$ARCHIVO = $NOMBRE . '.xml';


			$domtree = new DOMDocument('1.0', 'ISO-8859-1');
			//$domtree->preserveWhiteSpace = false;
			$domtree->formatOutput = true;
			$domtree->xmlStandalone = false;

			/* create the root element of the xml tree */
			$xmlRoot = $domtree->createElement("CreditNote");
			/* append it to the document created */
			$xmlRoot = $domtree->appendChild($xmlRoot);

			$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2');
			$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
			$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
			$xmlRoot->setAttribute('xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
			$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
			$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
			$xmlRoot->setAttribute('xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
			$xmlRoot->setAttribute('xmlns:sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');
			$xmlRoot->setAttribute('xmlns:udt', 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2');
			$xmlRoot->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');


			//ext:UBLExtensions
			$UBLExtensions = $domtree->createElement("ext:UBLExtensions");
			$UBLExtensions = $xmlRoot->appendChild($UBLExtensions);

			//ext:UBLExtension1
			$UBLExtension1 = $domtree->createElement("ext:UBLExtension");
			$UBLExtension1 = $UBLExtensions->appendChild($UBLExtension1);

			//sac:ExtensionContent1
			$ExtensionContent1 = $domtree->createElement("ext:ExtensionContent");
			$ExtensionContent1 = $UBLExtension1->appendChild($ExtensionContent1);

			//ext:UBLVersionID
			$UBLVersionID = $domtree->createElement("cbc:UBLVersionID", "2.1");
			$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

			//ext:CustomizationID
			$CustomizationID = $domtree->createElement("cbc:CustomizationID", "2.0");
			$CustomizationID = $xmlRoot->appendChild($CustomizationID);


			//cbc:ID
			$ID = $domtree->createElement("cbc:ID", $InsNotaCredito->NctNumero . "-" . $InsNotaCredito->NcrId);
			$ID = $xmlRoot->appendChild($ID);

			//cbc:IssueDate
			$IssueDate = $domtree->createElement("cbc:IssueDate", FncCambiaFechaAMysql($InsNotaCredito->NcrFechaEmision));
			$IssueDate = $xmlRoot->appendChild($IssueDate);
			//cbc:IssueTime
			$IssueTime = $domtree->createElement("cbc:IssueTime", ($InsNotaCredito->NcrHoraEmision));
			$IssueTime = $xmlRoot->appendChild($IssueTime);

			//cbc:Note
			//$Note = $domtree->createElement("cbc:Note",$domtree->createCDATASection($NotaCreditoTotalLetras));
			$Note = $domtree->createElement("cbc:Note", ($NotaCreditoTotalLetras));
			$Note->setAttribute('languageLocaleID', "1000");
			$Note = $xmlRoot->appendChild($Note);

			//cbc:DocumentCurrencyCode
			$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode", $InsNotaCredito->MonSigla);
			$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);


			//cbc:DiscrepancyResponse
			$DiscrepancyResponse = $domtree->createElement("cac:DiscrepancyResponse");
			$DiscrepancyResponse = $xmlRoot->appendChild($DiscrepancyResponse);

			//cbc:ReferenceID
			$ReferenceID = $domtree->createElement("cbc:ReferenceID", $InsNotaCredito->DtaNumero . "-" . $InsNotaCredito->DocId);
			$ReferenceID = $DiscrepancyResponse->appendChild($ReferenceID);

			/*
	01 - Anulacion de la operacion
02 - Anulacion por error en el RUC
03 - Correcion por error en la descripcion
04 - Descuento global
05 - Descuento por item
06 - Devolucion totla
07 - Devolucion por item
08 - Bonificacion
09 - Disminucion en el valor
10 - Otros conceptos
	*/
			//cac:ResponseCode
			$ResponseCode = $domtree->createElement("cbc:ResponseCode", $InsNotaCredito->NcrMotivoCodigo);
			$ResponseCode = $DiscrepancyResponse->appendChild($ResponseCode);

			//cac:ResponseCode
			$Description = $domtree->createElement("cbc:Description", $InsNotaCredito->NcrMotivo);
			$Description = $DiscrepancyResponse->appendChild($Description);



			//cbc:BillingReference
			$BillingReference = $domtree->createElement("cac:BillingReference");
			$BillingReference = $xmlRoot->appendChild($BillingReference);

			//cac:InvoiceDocumentReference
			$InvoiceDocumentReference = $domtree->createElement("cac:InvoiceDocumentReference");
			$InvoiceDocumentReference = $BillingReference->appendChild($InvoiceDocumentReference);

			//cac:ResponseCode
			$ID = $domtree->createElement("cbc:ID", $InsNotaCredito->DtaNumero . "-" . $InsNotaCredito->DocId);
			$ID = $InvoiceDocumentReference->appendChild($ID);

			switch ($InsNotaCredito->NcrTipo) {

				case "2": //FACTURA

					//cac:DocumentTypeCode
					$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode", "01");
					$DocumentTypeCode = $InvoiceDocumentReference->appendChild($DocumentTypeCode);

					break;

				case "3": //BOLETA
					//cac:DocumentTypeCode
					$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode", "03");
					$DocumentTypeCode = $InvoiceDocumentReference->appendChild($DocumentTypeCode);

					break;
			}

			if (!empty($InsNotaCredito->NcrOtroDocumento)) {

				//cbc:BillingReference
				$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
				$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);

				$ID = $domtree->createElement("cbc:ID", $InsNotaCredito->NcrOtroDocumento);
				$ID = $AdditionalDocumentReference->appendChild($ID);

				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode", $InsNotaCredito->NcrOtroDocumentoCodigo);
				$DocumentTypeCode = $AdditionalDocumentReference->appendChild($DocumentTypeCode);
			}





			//cac:Signature
			$Signature = $domtree->createElement("cac:Signature");
			$Signature = $xmlRoot->appendChild($Signature);

			//cbc:ID
			$ID = $domtree->createElement("cbc:ID", "IDSignSP");
			$ID = $Signature->appendChild($ID);

			//cac:SignatoryParty
			$SignatoryParty = $domtree->createElement("cac:SignatoryParty");
			$SignatoryParty = $Signature->appendChild($SignatoryParty);

			//cac:PartyIdentification
			$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
			$PartyIdentification = $SignatoryParty->appendChild($PartyIdentification);

			//cbc:ID
			$ID = $domtree->createElement("cbc:ID", $EmpresaCodigo);
			$ID = $PartyIdentification->appendChild($ID);

			//cac:PartyName
			$base = $SignatoryParty->appendChild($domtree->createElement('cac:PartyName'));

			//cac:Name		
			$name = $base->appendChild($domtree->createElement('cbc:Name'));
			$name->appendChild($domtree->createCDATASection($EmpresaNombre));

			//cbc:ID
			$DigitalSignatureAttachment = $domtree->createElement("cac:DigitalSignatureAttachment");
			$DigitalSignatureAttachment = $Signature->appendChild($DigitalSignatureAttachment);

			//cac:ExternalReference
			$ExternalReference = $domtree->createElement("cac:ExternalReference");
			$ExternalReference = $DigitalSignatureAttachment->appendChild($ExternalReference);

			//cbc:URI
			$URI = $domtree->createElement("cbc:URI", "#SignatureSP");
			$URI = $ExternalReference->appendChild($URI);


			//DATOS DEL PROVEEDOR
			//cac:AccountingSupplierParty
			$AccountingSupplierParty = $domtree->createElement("cac:AccountingSupplierParty");
			$AccountingSupplierParty = $xmlRoot->appendChild($AccountingSupplierParty);

			//cac:Party
			$Party = $domtree->createElement("cac:Party");
			$Party = $AccountingSupplierParty->appendChild($Party);

			//cac:PartyIdentification
			$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
			$PartyIdentification = $Party->appendChild($PartyIdentification);

			//cbc:Note
			//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
			$CompanyID = $domtree->createElement("cbc:ID", ($EmpresaCodigo));
			$CompanyID->setAttribute('schemeID', "6");
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyIdentification->appendChild($CompanyID);

			//cac:PartyName
			$PartyName = $Party->appendChild($domtree->createElement('cac:PartyName'));

			//cac:Name		
			$Name = $PartyName->appendChild($domtree->createElement('cbc:Name'));
			$Name->appendChild($domtree->createCDATASection($EmpresaNombre));

			//cac:PartyLegalEntity
			$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
			$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);

			//cbc:RegistrationName		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName'));
			$RegistrationName->appendChild($domtree->createCDATASection($EmpresaNombre));

			$RegistrationAddress = $domtree->createElement("cac:RegistrationAddress");
			$RegistrationAddress = $PartyLegalEntity->appendChild($RegistrationAddress);

			// <cbc:AddressTypeCode listAgencyName="PE:SUNAT" listName="Establecimientos anexos">0001</cbc:AddressTypeCode>
			//cbc:AddressTypeCode
			$AddressTypeCode = $domtree->createElement("cbc:AddressTypeCode", $InsNotaCredito->SucCodigoAnexo);
			$AddressTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
			$AddressTypeCode->setAttribute('listName', "Establecimientos anexos");
			$AddressTypeCode = $RegistrationAddress->appendChild($AddressTypeCode);


			//DATOS DEL CLIENTE
			//cac:AccountingCustomerParty
			$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
			$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);

			//cac:Party
			$Party = $domtree->createElement("cac:Party");
			$Party = $AccountingCustomerParty->appendChild($Party);

			//cac:PartyIdentification
			$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
			$PartyIdentification = $Party->appendChild($PartyIdentification);

			//cbc:Note
			//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
			$CompanyID = $domtree->createElement("cbc:ID", ($InsNotaCredito->CliNumeroDocumento));
			$CompanyID->setAttribute('schemeID', round($InsNotaCredito->TdoCodigo, 0));
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyIdentification->appendChild($CompanyID);


			//cac:PartyLegalEntity
			$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
			$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);

			//cbc:RegistrationName		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName'));
			$RegistrationName->appendChild($domtree->createCDATASection(trim($InsNotaCredito->CliNombre . " " . $InsNotaCredito->CliApellidoPaterno . " " . $InsNotaCredito->CliApellidoMaterno)));





			//DATOS DE INMPUESTOS		
			//cac:TaxTotal
			$TaxTotal = $domtree->createElement("cac:TaxTotal");
			$TaxTotal = $xmlRoot->appendChild($TaxTotal);

			//cbc:TaxAmount
			//SUMA TOTAL IGV
			$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($InsNotaCredito->NcrImpuesto, 2, '.', ''));
			$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$TaxAmount = $TaxTotal->appendChild($TaxAmount);

			//cac:TaxSubtotal
			$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
			$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

			//cbc:TaxableAmount 
			//SUMA TOTAL GRAVADOS
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($InsNotaCredito->NcrTotalGravado, 2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($InsNotaCredito->NcrImpuesto, 2, '.', ''));
			$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);

			//cac:TaxCategory
			$TaxCategory = $domtree->createElement("cac:TaxCategory");
			$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);

			//cbc:TaxAmount 
			$ID = $domtree->createElement("cbc:ID", "S");
			$ID->setAttribute('schemeID', "UN/ECE 5305");
			$ID->setAttribute('schemeName', "Tax Category Identifier");
			$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
			$ID = $TaxCategory->appendChild($ID);

			//cac:TaxScheme
			$TaxScheme = $domtree->createElement("cac:TaxScheme");
			$TaxScheme = $TaxCategory->appendChild($TaxScheme);


			//cbc:TaxAmount 
			$ID = $domtree->createElement("cbc:ID", "1000");
			$ID->setAttribute('schemeID', "UN/ECE 5153");
			$ID->setAttribute('schemeAgencyID', "6");
			$ID = $TaxScheme->appendChild($ID);

			//cbc:Name
			$Name = $domtree->createElement("cbc:Name", "IGV");
			$Name = $TaxScheme->appendChild($Name);

			//cbc:TaxTypeCode
			$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode", "VAT");
			$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);



			if ($InsNotaCredito->NcrTotalExonerado > 0) {

				//SUMA TOTAL EXONERADOS
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

				//cbc:TaxableAmount 
				$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($InsNotaCredito->NcrTotalExonerado, 2, '.', ''));
				$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
				$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

				//cbc:TaxAmount 
				$TaxAmount = $domtree->createElement("cbc:TaxAmount", "0.00");
				$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
				$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);

				//cac:TaxCategory
				$TaxCategory = $domtree->createElement("cac:TaxCategory");
				$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);

				//cbc:TaxAmount 
				$ID = $domtree->createElement("cbc:ID", "E");
				$ID->setAttribute('schemeID', "UN/ECE 5305");
				$ID->setAttribute('schemeName', "Tax Category Identifier");
				$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
				$ID = $TaxCategory->appendChild($ID);

				//cac:TaxScheme
				$TaxScheme = $domtree->createElement("cac:TaxScheme");
				$TaxScheme = $TaxCategory->appendChild($TaxScheme);

				//cbc:TaxAmount 
				$ID = $domtree->createElement("cbc:ID", "9997");
				$ID->setAttribute('schemeID', "UN/ECE 5153");
				$ID->setAttribute('schemeAgencyID', "6");
				$ID = $TaxScheme->appendChild($ID);

				//cbc:Name
				$Name = $domtree->createElement("cbc:Name", "EXONERADO");
				$Name = $TaxScheme->appendChild($Name);

				//cbc:TaxTypeCode
				$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode", "VAT");
				$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
			}



			if ($InsNotaCredito->NcrTotalGratuito > 0) {

				//SUMA TOTAL INAFECTO (GRATUITO)
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

				//cbc:TaxableAmount 
				$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($InsNotaCredito->NcrTotalGratuito, 2, '.', ''));
				$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
				$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

				//cbc:TaxAmount 
				$TaxAmount = $domtree->createElement("cbc:TaxAmount", "0.00");
				$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
				$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);

				//cac:TaxCategory
				$TaxCategory = $domtree->createElement("cac:TaxCategory");
				$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);

				//cbc:TaxAmount 
				$ID = $domtree->createElement("cbc:ID", "O");
				$ID->setAttribute('schemeID', "UN/ECE 5305");
				$ID->setAttribute('schemeName', "Tax Category Identifier");
				$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
				$ID = $TaxCategory->appendChild($ID);

				//cac:TaxScheme
				$TaxScheme = $domtree->createElement("cac:TaxScheme");
				$TaxScheme = $TaxCategory->appendChild($TaxScheme);

				//cbc:TaxAmount 
				$ID = $domtree->createElement("cbc:ID", "9998");
				$ID->setAttribute('schemeID', "UN/ECE 5153");
				$ID->setAttribute('schemeAgencyID', "6");
				$ID = $TaxScheme->appendChild($ID);

				//cbc:Name
				$Name = $domtree->createElement("cbc:Name", "INAFECTO");
				$Name = $TaxScheme->appendChild($Name);

				//cbc:TaxTypeCode
				$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode", "FRE");
				$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
			}



			//cac:LegalMonetaryTotal
			$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
			$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

			//cbc:AllowanceTotalAmount 
			//SUMA TOTAL DESCUENTOS GENERAL + ITEMS
			$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount", number_format($InsNotaCredito->NcrTotalDescuento, 2, '.', ''));
			$AllowanceTotalAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);

			//cbc:PayableAmount currencyID="PEN"
			$PayableAmount = $domtree->createElement("cbc:PayableAmount", number_format($InsNotaCredito->NcrTotal, 2, '.', ''));
			$PayableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
			$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);


			$fila = 1;
			if (!empty($InsNotaCredito->NotaCreditoDetalle)) {
				foreach ($InsNotaCredito->NotaCreditoDetalle as $DatNotaCreditoDetalle) {



					if ($InsNotaCredito->MonId <> $EmpresaMonedaId) {

						$DatNotaCreditoDetalle->NcdValorVenta = round($DatNotaCreditoDetalle->NcdValorVenta / $InsNotaCredito->NcrTipoCambio, 2);
						$DatNotaCreditoDetalle->NcdValorVentaUnitario = round($DatNotaCreditoDetalle->NcdValorVentaUnitario / $InsNotaCredito->NcrTipoCambio, 2);

						$DatNotaCreditoDetalle->NcdPrecio = round($DatNotaCreditoDetalle->NcdPrecio / $InsNotaCredito->NcrTipoCambio, 2);
						$DatNotaCreditoDetalle->NcdImpuesto = round($DatNotaCreditoDetalle->NcdImpuesto / $InsNotaCredito->NcrTipoCambio, 2);
					}


					$DatNotaCreditoDetalle->NcdDescripcion  = trim($DatNotaCreditoDetalle->NcdDescripcion);

					//cac:InvoiceLine
					$InvoiceLine = $domtree->createElement("cac:CreditNoteLine");
					$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);

					//cbc:ID
					$ID = $domtree->createElement("cbc:ID", $fila);
					$ID = $InvoiceLine->appendChild($ID);

					//cbc:CreditedQuantity unitCode="NIU"
					$CreditedQuantity = $domtree->createElement("cbc:CreditedQuantity", number_format($DatNotaCreditoDetalle->NcdCantidad, 2, '.', ''));

					if ($DatNotaCreditoDetalle->NcdValidarStock == 2) {
						$CreditedQuantity->setAttribute('unitCode', 'ZZ');
					} else {
						$CreditedQuantity->setAttribute('unitCode', 'NIU');
					}
					$CreditedQuantity->setAttribute('unitCodeListID', 'UN/ECE rec 20');
					$CreditedQuantity->setAttribute('unitCodeListAgencyName', 'Europe');
					$CreditedQuantity = $InvoiceLine->appendChild($CreditedQuantity);

					//cbc:LineExtensionAmount currencyID="PEN"
					$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount", number_format($DatNotaCreditoDetalle->NcdValorVenta, 2, '.', ''));
					$LineExtensionAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
					$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);

					//cac:PricingReference
					$PricingReference = $domtree->createElement("cac:PricingReference");
					$PricingReference = $InvoiceLine->appendChild($PricingReference);


					//VALOR REFERENCIAL UNITARIO POR ITEM EN OPERACIONES NO ONEROSAS

					if ($DatNotaCreditoDetalle->NcdGratuito == 1) {

						//cac:AlternativeConditionPrice
						$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
						$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);

						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario, 2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);

						//cbc:PriceTypeCode
						$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode", "02");
						$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
						$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
						$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
						$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
					} else if ($DatNotaCreditoDetalle->NcdGratuito == 2) {

						//cac:AlternativeConditionPrice
						$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
						$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);


						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", number_format($DatNotaCreditoDetalle->NcdPrecio, 2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);

						//cbc:PriceTypeCode
						$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode", "01");
						$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
						$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
						$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
						$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
					}

					//DESCUENTOS POR ITEM	

					if ($DatNotaCreditoDetalle->NcdDescuento > 0) {

						$DatNotaCreditoDetalle->NcdPorcentajeDescuento = round($DatNotaCreditoDetalle->NcdPorcentajeDescuento / 100, 2);

						//cac:AllowanceCharge
						$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
						$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);

						//cbc:ChargeIndicator
						$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator", "false");
						$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);

						//cbc:AllowanceChargeReasonCode
						$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode", "00"); //X
						$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);

						////cbc:MultiplierNcrtorNumeric
						//					$MultiplierNcrtorNumeric = $domtree->createElement("cbc:MultiplierNcrtorNumeric",$DatNotaCreditoDetalle->NcdPorcentajeDescuento);//X
						//					$MultiplierNcrtorNumeric = $AllowanceCharge->appendChild($MultiplierNcrtorNumeric);

						//cbc:Amount
						$Amount = $domtree->createElement("cbc:Amount", $DatNotaCreditoDetalle->NcdDescuento);
						$Amount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$Amount = $AllowanceCharge->appendChild($Amount);

						//cbc:BaseAmount
						$BaseAmount = $domtree->createElement("cbc:BaseAmount", $InsNotaCreditoDetalle1->NcdValorVentaBruto);
						$BaseAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);
					}








					//cac:TaxTotal
					$TaxTotal = $domtree->createElement("cac:TaxTotal");
					$TaxTotal = $InvoiceLine->appendChild($TaxTotal);


					if ($DatNotaCreditoDetalle->NcdExonerado == "1") {

						//cbc:TaxAmount
						$TaxAmount = $domtree->createElement("cbc:TaxAmount", "0.00");
						$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$TaxAmount = $TaxTotal->appendChild($TaxAmount);

						//cac:TaxSubtotal
						$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
						$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

						//cbc:TaxableAmount 
						$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", "0.00");
						$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

						//cbc:TaxAmount 
						$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatNotaCreditoDetalle->NcdValorVenta, 2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);

						//cac:TaxCategory
						$TaxCategory = $domtree->createElement("cac:TaxCategory");
						$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);

						//cbc:ID 
						$ID = $domtree->createElement("cbc:ID", "E");
						$ID->setAttribute('schemeID', "UN/ECE 5305");
						$ID->setAttribute('schemeName', "Tax Category Identifier");
						$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
						$ID = $TaxCategory->appendChild($ID);

						//cbc:Percent
						$Percent = $domtree->createElement("cbc:Percent", $InsNotaCredito->NcrPorcentajeImpuestoVenta);
						$Percent = $TaxCategory->appendChild($Percent);

						//cbc:TaxExemptionReasonCode 
						$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode", "20");
						$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
						$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
						$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
						$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);

						//cac:TaxScheme
						$TaxScheme = $domtree->createElement("cac:TaxScheme");
						$TaxScheme = $TaxCategory->appendChild($TaxScheme);

						//cbc:TaxAmount 
						$ID = $domtree->createElement("cbc:ID", "1000");
						$ID->setAttribute('schemeID', "UN/ECE 5153");
						$ID->setAttribute('schemeName', "Tax Scheme Identifier");
						$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
						$ID = $TaxScheme->appendChild($ID);

						//cbc:Name
						$Name = $domtree->createElement("cbc:Name", "EXONERADO");
						$Name = $TaxScheme->appendChild($Name);

						//cbc:TaxTypeCode
						$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode", "VAT");
						$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
					} else if ($DatNotaCreditoDetalle->NcdExonerado == "2") {


						//cbc:TaxAmount
						$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatNotaCreditoDetalle->NcdImpuesto, 2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$TaxAmount = $TaxTotal->appendChild($TaxAmount);

						//cac:TaxSubtotal
						$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
						$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

						//cbc:TaxableAmount 
						$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($DatNotaCreditoDetalle->NcdValorVenta, 2, '.', ''));
						$TaxableAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

						//cbc:TaxAmount 
						$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatNotaCreditoDetalle->NcdImpuesto, 2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);

						//cac:TaxCategory
						$TaxCategory = $domtree->createElement("cac:TaxCategory");
						$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);

						//cbc:TaxAmount 
						$ID = $domtree->createElement("cbc:ID", "S");
						$ID->setAttribute('schemeID', "UN/ECE 5305");
						$ID->setAttribute('schemeName', "Tax Category Identifier");
						$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
						$ID = $TaxCategory->appendChild($ID);

						//cbc:Percent
						$Percent = $domtree->createElement("cbc:Percent", $InsNotaCredito->NcrPorcentajeImpuestoVenta);
						$Percent = $TaxCategory->appendChild($Percent);

						//cbc:TaxExemptionReasonCode 
						$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode", "10");
						$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
						$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
						$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
						$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);

						//cac:TaxScheme
						$TaxScheme = $domtree->createElement("cac:TaxScheme");
						$TaxScheme = $TaxCategory->appendChild($TaxScheme);

						//cbc:TaxAmount 
						$ID = $domtree->createElement("cbc:ID", "1000");
						$ID->setAttribute('schemeID', "UN/ECE 5153");
						$ID->setAttribute('schemeName', "Tax Scheme Identifier");
						$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
						$ID = $TaxScheme->appendChild($ID);

						//cbc:Name
						$Name = $domtree->createElement("cbc:Name", "IGV");
						$Name = $TaxScheme->appendChild($Name);

						//cbc:TaxTypeCode
						$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode", "VAT");
						$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
					} else {
					}



					//cac:Item
					$Item = $domtree->createElement("cac:Item");
					$Item = $InvoiceLine->appendChild($Item);

					//cac:PartyName
					$Description = $domtree->createElement("cbc:Description");
					$Description = $Item->appendChild($Description);

					$Description->appendChild($domtree->createCDATASection($DatNotaCreditoDetalle->NcdDescripcion));

					//cac:SellersItemIdentification		
					$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
					$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatNotaCreditoDetalle->NcdCodigo));

					if (!empty($DatNotaCreditoDetalle->NcdCodigoGeneral)) {

						//cac:CommodityClassification		
						$CommodityClassification = $domtree->createElement("cac:CommodityClassification");
						$CommodityClassification = $Item->appendChild($CommodityClassification);

						//cbc:PriceAmount currencyID="PEN"
						$ItemClassificationCode = $domtree->createElement("cbc:ItemClassificationCode", $DatNotaCreditoDetalle->NcdCodigoGeneral);
						$ItemClassificationCode->setAttribute('listID', "UNSPSC");
						$ItemClassificationCode->setAttribute('listAgencyName', "GS1 US");
						$ItemClassificationCode->setAttribute('listName', "Item Classification");
						$ItemClassificationCode = $CommodityClassification->appendChild($ItemClassificationCode);
					}


					//cac:Price
					$Price = $domtree->createElement("cac:Price");
					$Price = $InvoiceLine->appendChild($Price);

					if ($DatNotaCreditoDetalle->NcdGratuito == 1) {

						//cbc:PriceAmount 
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", "0.00");
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);
					} elseif ($DatNotaCreditoDetalle->NcdGratuito == 2) {

						//cbc:PriceAmount
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", number_format($DatNotaCreditoDetalle->NcdValorVentaUnitario, 2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);
					} else {

						//cbc:PriceAmount
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", "0.00");
						$PriceAmount->setAttribute('currencyID', $InsNotaCredito->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);
					}






					$fila++;
				}
			}


			if (file_exists($oRuta . $ARCHIVO)) {
				unlink($oRuta . $ARCHIVO);
			}

			$domtree->save($oRuta . $ARCHIVO, LIBXML_NOEMPTYTAG);



			return true;
		} else {

			return false;
		}
	}
}
