<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFactura
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFactura
{

	public $FacId;
	public $FtaId;
	public $UsuId;

	public $CliId;

	public $GreId;
	public $GrtId;

	public $NpaId;

	public $FinId;
	public $AmoId;
	public $OvvId;
	public $FccId;


	public $CprId;
	public $VdiId;
	public $PagId;
	public $CveId;
	public $FacNotaCredito;

	public $FacIncluyeImpuesto;
	public $MonId;
	public $FacTipoCambio;

	public $FacCancelado;

	public $FacSIAFNumero;
	public $FacOrdenNumero;
	public $FacOrdenFecha;
	public $FacOrdenTipo;
	public $FacOrdenFoto;
	public $FacCantidadDia;

	public $FacFechaVencimiento;
	public $FacFechaVencimiento2;
	public $FacDiaTranscurrido;

	public $FacObsequio;
	public $FacSpot;

	public $FacConcepto;
	public $FacTipo;
	public $FacEstado;
	public $FacFechaEmision;
	public $FacPorcentajeImpuestoVenta;
	public $FacPorcentajeImpuestoSelectivo;
	public $FacDireccion;

	public $FacTotalBruto;
	public $FacSubTotal;
	public $FacDescuento;
	public $FacImpuesto;
	public $FacTotal;
	public $FacObservacion;
	public $FacObservacionImpresa;
	public $FacObservacionCaja;
	public $FacLeyenda;
	public $FpaId;
	public $FacCierre;

	public $RegId;
	public $FacRegimenPorcentaje;
	public $FacRegimenMonto;
	public $FacRegimenComprobanteNumero;
	public $FacRegimenComprobanteFecha;

	public $FacSunatRespuestaTicket;
	public $FacSunatRespuestaEnvioFecha;
	public $FacSunatRespuestaEnvioHora;
	public $FacSunatRespuestaEnvioCodigo;
	public $FacSunatRespuestaEnvioContenido;
	public $FacSunatRespuestaObservacion;
	public $FacSunatRespuestaTicketEstado;

	public $FacTiempoCreacion;
	public $FacTiempoModificacion;
	public $FacEliminado;

	public $FacAbonado;
	public $FacSaldo;

	public $FacTotalItems;
	public $FacturaDetalle;
	public $FacturaLetra;

	// Propiedades adicionales de la factura
	public $FacUsuario;
	public $FacVendedor;
	public $FacNumeroPedido;
	public $FacProcesar;

	// Propiedades adicionales para evitar warnings
	public $FacSunatRespuestaBajaId;
	public $FacSunatRespuestaBajaTicket;
	public $FacSunatRespuestaBajaTicketEstado;
	public $FacSunatRespuestaBajaFecha;
	public $FacSunatRespuestaBajaHora;
	public $FacSunatRespuestaBajaCodigo;
	public $FacSunatRespuestaBajaContenido;
	public $FacSunatRespuestaConsultaCodigo;
	public $FacSunatRespuestaConsultaContenido;
	public $FacSunatRespuestaConsultaFecha;
	public $FacSunatRespuestaConsultaHora;
	public $FacSunatRespuestaEnvioTiempoCreacion;
	public $FacSunatRespuestaConsultaTiempoCreacion;
	public $FacSunatRespuestaBajaTiempoCreacion;
	public $FacSunatUltimaAccion;
	public $FacSunatUltimaRespuesta;
	public $FacSunatRespuestaEnvioDigestValue;
	public $FacSunatRespuestaEnvioSignatureValue;
	public $FacDiaVencido;
	public $FacTotalGravado;
	public $FacTotalExonerado;
	public $FacTotalGratuito;
	public $FacTotalDescuento;
	public $FacTotalPagar;
	public $FacTotalReal;
	public $FacAbono;
	public $FacMontoAmortizado;
	public $FacMontoPendiente;
	public $FacHoraEmision;
	public $FacDatoAdicional1;
	public $FacDatoAdicional2;
	public $FacDatoAdicional3;
	public $FacDatoAdicional4;
	public $FacDatoAdicional5;
	public $FacDatoAdicional6;
	public $FacDatoAdicional7;
	public $FacDatoAdicional8;
	public $FacDatoAdicional9;
	public $FacDatoAdicional10;
	public $FacDatoAdicional11;
	public $FacDatoAdicional12;
	public $FacDatoAdicional13;
	public $FacDatoAdicional14;
	public $FacDatoAdicional15;
	public $FacDatoAdicional16;
	public $FacDatoAdicional17;
	public $FacDatoAdicional18;
	public $FacDatoAdicional19;
	public $FacDatoAdicional20;
	public $FacDatoAdicional21;
	public $FacDatoAdicional22;
	public $FacDatoAdicional23;
	public $FacDatoAdicional24;
	public $FacDatoAdicional25;
	public $FacDatoAdicional26;
	public $FacDatoAdicional27;
	public $FacDatoAdicional28;
	public $FacEstadoDescripcion;
	public $FacEstadoIcono;
	public $FacAlmacenMovimiento;
	public $FacOrdenVentaVehiculoPropietario;

	// Propiedades adicionales para evitar warnings
	public $SucId;
	public $FacNotaEntrega;
	public $FacNotaDebito;
	public $FacTipoCambioAux;
	public $FacTotalImpuestoSelectivo;
	public $FacSunatRespuestaEnvioTicket;
	public $FacSunatRespuestaEnvioTicketEstado;
	public $FacObservado;
	public $MonSigla;
	public $MonCodigo;



	public $NpaNombre;

	public $FtaNumero;
	public $GrtNumero;

	public $RegAplicacion;
	public $RegNombre;

	public $MonNombre;
	public $MonSimbolo;


	public $CliNombre;
	public $CliNombreCompleto;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $TdoId;
	public $CliNumeroDocumento;
	public $CliTelefono;
	public $CliEmail;
	public $CliEmailFacturacion;
	public $CliContactoEmail1;
	public $CliContactoEmail2;
	public $CliContactoEmail3;
	public $CliCelular;
	public $CliFax;
	public $CliClaveElectronica;
	public $CliProvincia;
	public $CliDistrito;
	public $CliDepartamento;

	public $FinVehiculoKilometraje;

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

	public function MtdGenerarFacturaId()
	{

		$sql = 'SELECT	
		MAX(SUBSTR(fac.FacId,1)) AS "MAXIMO",
		
	
		fta.FtaInicio
		FROM tblfacfactura fac
		LEFT JOIN tblftafacturatalonario fta
		ON fac.FtaId = fta.FtaId
		WHERE fta.FtaId = "' . $this->FtaId . '"';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			if (empty($fila['FtaInicio'])) {
				$this->FacId = "0000001";
			} else {
				$this->FacId = str_pad($fila['FtaInicio'], 6, "0", STR_PAD_LEFT);
			}
		} else {
			$fila['MAXIMO']++;
			$this->FacId = str_pad($fila['MAXIMO'], 6, "0", STR_PAD_LEFT);
		}
	}


	public function MtdGenerarFacturaBajaId()
	{

		$sql = 'SELECT	
		MAX(CONVERT(fac.FacSunatRespuestaBajaId,unsigned)) AS "MAXIMO"
		FROM tblfacfactura fac ';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->FacSunatRespuestaBajaId = "1";
		} else {
			$fila['MAXIMO']++;
			$this->FacSunatRespuestaBajaId = ($fila['MAXIMO']);
		}
	}

	public function MtdVerificarExisteFactura($oId, $oTalonario)
	{

		$Existe = false;

		$sql = 'SELECT 
		fac.FacId,
		fac.FtaId
		FROM tblfacfactura fac
		WHERE fac.FacId = "' . $oId . '" 
		AND fac.FtaId= "' . $oTalonario . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			$Existe = true;
		}

		return $Existe;
	}



	public function MtdObtenerFactura($oCompleto = true)
	{

		$sql = 'SELECT 
				fac.FacId,
				fac.FtaId,
				fac.SucId,
				
				fac.UsuId,

				fac.CliId,

				fac.GreId,
				fac.GrtId,
				
				fac.NpaId,
				fac.AmoId,
				fac.OvvId,
				fac.FccId,
				
				fac.PagId,
				
				CASE
				WHEN EXISTS (
					SELECT ncr.NcrId
						FROM tblncrnotacredito ncr
								WHERE ncr.FacId = fac.FacId 
									AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.BolId IS NULL 
									AND ncr.BtaId IS NULL
				) THEN "Si"
				ELSE "No"
				END AS FacNotaCredito,
				
				
				CASE
				WHEN EXISTS (
					SELECT ndb.NdbId
						FROM tblndbnotadebito ndb
								WHERE ndb.FacId = fac.FacId 
									AND ndb.FtaId = fac.FtaId
									AND ndb.NdbEstado <> 6
									AND ndb.BolId IS NULL 
									AND ndb.BtaId IS NULL
				) THEN "Si"
				ELSE "No"
				END AS FacNotaDebito,
				
				
								
				fac.FacSIAFNumero,
				fac.FacOrdenNumero,
				DATE_FORMAT(fac.FacOrdenFecha, "%d/%m/%Y") AS "NFacOrdenFecha",
				fac.FacOrdenTipo,
				fac.FacOrdenFoto,
				
				fac.FacCantidadDia,
				
				DATE_FORMAT(fac.FacFechaVencimiento, "%d/%m/%Y") AS "NFacFechaVencimiento",
				fac.FacFechaVencimiento AS "FacFechaVencimiento2",
				DATEDIFF(DATE(NOW()),fac.FacFechaEmision) AS FacDiaTranscurrido,
				 

				fac.FacIncluyeImpuesto,
				fac.MonId,
				fac.FacTipoCambio,		
				fac.FacTipoCambioAux,
	
				fac.FacCancelado,
				fac.FacObsequio,
				fac.FacSpot,
				
				fac.FacConcepto,	
				fac.FacTipo,	
	
				fac.FacDatoAdicional1,
				fac.FacDatoAdicional2,
				fac.FacDatoAdicional3,
				fac.FacDatoAdicional4,
				fac.FacDatoAdicional5,
				fac.FacDatoAdicional6,
				fac.FacDatoAdicional7,
				fac.FacDatoAdicional8,
				fac.FacDatoAdicional9,
				fac.FacDatoAdicional10,
				
				fac.FacDatoAdicional11,
				fac.FacDatoAdicional12,
				fac.FacDatoAdicional13,
				fac.FacDatoAdicional14,
				fac.FacDatoAdicional15,
				fac.FacDatoAdicional16,
				fac.FacDatoAdicional17,
				fac.FacDatoAdicional18,
				fac.FacDatoAdicional19,
				fac.FacDatoAdicional20,
				
				fac.FacDatoAdicional21,
				fac.FacDatoAdicional22,
				fac.FacDatoAdicional23,
				fac.FacDatoAdicional24,
				fac.FacDatoAdicional25,
				fac.FacDatoAdicional26,
fac.FacDatoAdicional27,
fac.FacDatoAdicional28,
				
				fac.FacEstado,	
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
DATE_FORMAT(fac.FacTiempoCreacion, "%H:%i:%s") AS "FacHoraEmision",

								
				DATE_FORMAT(fac.FacFechaVencimiento, "%d/%m/%Y") AS "NFacFechaVencimiento",
				fac.FacFechaVencimiento AS "FacFechaVencimiento2",
				fac.FacPorcentajeImpuestoVenta,
				fac.FacPorcentajeImpuestoSelectivo,
				fac.FacDireccion,
				
				fac.FacTotalImpuestoSelectivo,
				fac.FacTotalGravado,
				fac.FacTotalDescuento,
				fac.FacTotalGratuito,
				fac.FacTotalExonerado,
				fac.FacTotalPagar,
				
				fac.FacSubTotal,
				fac.FacImpuesto,
				fac.FacTotal,
				

				IF(reg.RegAplicacion=2,fac.FacTotal+IFNULL(fac.FacRegimenMonto,0),fac.FacTotal-IFNULL(fac.FacRegimenMonto,0)) AS "FacTotalReal",
				

				fac.FacObservacion,
fac.FacObservacionCaja,
fac.FacLeyenda,
				fac.FacCierre,
				fac.RegId,
				fac.FacRegimenPorcentaje,
				fac.FacRegimenMonto,
				fac.FacRegimenComprobanteNumero,
				DATE_FORMAT(fac.FacRegimenComprobanteFecha, "%d/%m/%Y") AS "NFacRegimenComprobanteFecha",
				
				
				fac.FacSunatRespuestaTicket,
				fac.FacSunatRespuestaTicketEstado,
				fac.FacSunatRespuestaObservacion,
				
				fac.FacSunatRespuestaEnvioTicket,
				fac.FacSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(fac.FacSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NFacSunatRespuestaEnvioFecha",
				fac.FacSunatRespuestaEnvioHora,
				fac.FacSunatRespuestaEnvioCodigo,
				fac.FacSunatRespuestaEnvioContenido,
				
				fac.FacSunatRespuestaBajaTicket,
				fac.FacSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(fac.FacSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NFacSunatRespuestaBajaFecha",
				fac.FacSunatRespuestaBajaHora,
				fac.FacSunatRespuestaBajaCodigo,
				fac.FacSunatRespuestaBajaContenido,
				fac.FacSunatRespuestaBajaId,
				
				fac.FacSunatRespuestaConsultaCodigo,
				fac.FacSunatRespuestaConsultaContenido,
				DATE_FORMAT(fac.FacSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NFacSunatRespuestaConsultaFecha",
				fac.FacSunatRespuestaConsultaHora,
				
				DATE_FORMAT(fac.FacSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(fac.FacSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(fac.FacSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaBajaTiempoCreacion",
				
				fac.FacSunatUltimaAccion,
				fac.FacSunatUltimaRespuesta,
				
				fac.FacUsuario,
				fac.FacVendedor,
				fac.FacNumeroPedido,
				fac.FacObservado,
				
				DATE_FORMAT(fac.FacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacTiempoCreacion",
                DATE_FORMAT(fac.FacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFacTiempoModificacion",

				fac.FacSunatRespuestaEnvioDigestValue,
				fac.FacSunatRespuestaEnvioSignatureValue,

				(SELECT 
		
				(pag.PagMonto)
				
				FROM tblpagpago pag
				WHERE 
					
					EXISTS(
						SELECT
						pac.PacId
						FROM tblpacpagocomprobante pac
							WHERE pac.PagId = pag.PagId
							AND (pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId)
					)
					
					ORDER BY pag.PagId ASC LIMIT 1
		
				) AS FacAbono,
				
				@PagMonto:=(SELECT 
				
				SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
				
				FROM tblpagpago pag
				WHERE 
					
					EXISTS(
						SELECT
						pac.PacId
						FROM tblpacpagocomprobante pac
							WHERE pac.PagId = pag.PagId
							AND pac.FacId = fac.FacId
							AND pac.FtaId = fac.FtaId
					)
					
				) AS FacAbonado,
				
				(fac.FacTotal - IFNULL(@PagMonto,0)) AS FacSaldo,
				
			
			
			
				npa.NpaNombre,

				fta.FtaNumero,
				
				grt.GrtNumero,
				
				reg.RegAplicacion,
				reg.RegNombre,
				
				mon.MonSimbolo,
				mon.MonNombre,
				mon.MonSigla,
				mon.MonCodigo,
				
				tdo.TdoCodigo,
				cli.CliNombre,
				cli.CliNombreCompleto,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
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
				
				cli.CliProvincia,
				cli.CliDistrito,
				cli.CliDepartamento,
				
				fin.FinVehiculoKilometraje,
				
				fim.FinId,

				amo.FccId,
				amo.CprId,
				
				IFNULL(ein.EinVIN,IFNULL(ein2.EinVIN,"")) AS EinVIN,
				
				ein.VmaId,
				ein.VmoId,
				ein.VveId,
				ein.EinAnoFabricacion,
				IFNULL(ein.EinPlaca,IFNULL(ein2.EinPlaca,"")) AS EinPlaca,
				veh.VehColor,
				ein.EinNombre,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				
								@Amortizado:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.FacId = fac.FacId
						AND cpc.FtaId = fac.FtaId)
						AND pag.PagEstado = 3
				) AS FacMontoAmortizado,
				
				
				/*@AmortizadoOtro:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS FacMontoAmortizadoOtro,
				*//*
				@AmortizadoOtroVehiculo:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS FacMontoAmortizadoOtroVehiculo,
				*/
				
				(
					(fac.FacTotal/IFNULL(fac.FacTipoCambio,1)) - IFNULL(@Amortizado,0)
				) AS FacMontoPendiente,
				
				
				IF(IFNULL((
					(fac.FacTotal/IFNULL(fac.FacTipoCambio,1)) - IFNULL(@Amortizado,0) - IFNULL(@AmortizadoOtro,0) - IFNULL(@AmortizadoOtroVehiculo,0)
				),0)>0,2,1) AS NFacCancelado,
			
				
				IFNULL(
				amo.VdiId,
					IFNULL(vdi2.VdiId,
						(
						SELECT
						pac.VdiId
						FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						WHERE pag.PagEstado<>6
						AND fac.PagId = pag.PagId
						LIMIT 1
						)
					)
				
				) AS  VdiId,
				
				
				
				vdi.VdiArchivo,
				vdi.VdiOrdenCompraNumero,
				
				
				
				
				ein2.EinVIN AS OrdenVentaVehiculoEinVIN,
				ein2.EinNombre AS OrdenVentaVehiculoEinNombre,
				ein2.EinNumeroMotor AS OrdenVentaVehiculoEinNumeroMotor,
				ein2.EinAnoFabricacion AS OrdenVentaVehiculoEinAnoFabricacion,
				ein2.EinColor AS OrdenVentaVehiculoEinColor,
				ein2.EinDUA AS OrdenVentaVehiculoEinDUA,
				
				vma2.VmaNombre AS OrdenVentaVehiculoVmaNombre,
				vmo2.VmoNombre AS OrdenVentaVehiculoVmoNombre,
				vve2.VveNombre AS OrdenVentaVehiculoVveNombre,
				
				ein2.EinCaracteristica10,
				ein2.EinCaracteristica12,
				ein2.EinCaracteristica13,
				
				vve2.VveCaracteristica1,
				vve2.VveCaracteristica2,
				vve2.VveCaracteristica3,
				vve2.VveCaracteristica4,
				vve2.VveCaracteristica5,
				vve2.VveCaracteristica6,
				vve2.VveCaracteristica7,
				vve2.VveCaracteristica8,
				vve2.VveCaracteristica9,
				vve2.VveCaracteristica10,
				vve2.VveCaracteristica11,
				vve2.VveCaracteristica12,
				vve2.VveCaracteristica13,
				vve2.VveCaracteristica14,
				vve2.VveCaracteristica15,
				vve2.VveCaracteristica16,
				vve2.VveCaracteristica17,
				vve2.VveCaracteristica18,
				vve2.VveCaracteristica19,
				vve2.VveCaracteristica20,
				
					suc.SucNombre,
				suc.SucDireccion,
				suc.SucDistrito,
				suc.SucProvincia,
				suc.SucDepartamento,
				suc.SucCodigoUbigeo,
				suc.SucCodigoAnexo
				
				
				FROM tblfacfactura fac
					LEFT JOIN tblnpacondicionpago npa
					ON fac.NpaId = npa.NpaId
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							LEFT JOIN tblgrtguiaremisiontalonario grt
							ON fac.GrtId = grt.GrtId
								LEFT JOIN tblregregimen reg
								ON fac.RegId = reg.RegId
									LEFT JOIN tblmonmoneda mon
									ON fac.MonId = mon.MonId
										LEFT JOIN tblclicliente cli
										ON fac.CliId = cli.CliId
											LEFT JOIN tbltdotipodocumento tdo
											ON cli.TdoId = tdo.TdoId
											
											LEFT JOIN tblamoalmacenmovimiento amo
											ON fac.AmoId = amo.Amoid
												LEFT JOIN tblvdiventadirecta vdi
												ON amo.VdiId = vdi.VdiId
												
												LEFT JOIN tbleinvehiculoingreso ein2
												ON vdi.EinId = ein2.EinId
							
												
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
											


											LEFT JOIN tblovvordenventavehiculo ovv
											ON fac.OvvId = ovv.OvvId
												
											
												
												LEFT JOIN tblvvevehiculoversion vve2
												ON ein2.VveId = vve2.VveId
												
													LEFT JOIN tblvmovehiculomodelo vmo2
													ON vve2.VmoId = vmo2.VmoId
													
														LEFT JOIN tblvmavehiculomarca vma2
														ON vmo2.Vmaid = vma2.VmaId
							LEFT JOIN tblsucsucursal suc
									ON fac.SucId = suc.SucId
							
							
							
														LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId
															
															
				WHERE fac.FacId = "' . $this->FacId . '" AND fac.FtaId= "' . $this->FtaId . '";';


		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

				$this->FacId = $fila['FacId'];
				$this->FtaId = $fila['FtaId'];
				$this->SucId = $fila['SucId'];

				$this->UsuId = $fila['UsuId'];

				$this->CliId = $fila['CliId'];

				$this->GreId = $fila['GreId'];
				$this->GrtId = $fila['GrtId'];

				$this->NpaId = $fila['NpaId'];

				$this->AmoId = $fila['AmoId'];
				$this->OvvId = $fila['OvvId'];
				$this->FccId = $fila['FccId'];


				$this->PagId = $fila['PagId'];

				$this->FacNotaEntrega = $fila['FacNotaEntrega'];

				$this->FacNotaCredito = $fila['FacNotaCredito'];
				$this->FacNotaDebito = $fila['FacNotaDebito'];

				$this->FacSIAFNumero = $fila['FacSIAFNumero'];
				$this->FacOrdenNumero = $fila['FacOrdenNumero'];
				$this->FacOrdenFecha = $fila['NFacOrdenFecha'];
				$this->FacOrdenTipo = $fila['FacOrdenTipo'];
				$this->FacOrdenFoto = $fila['FacOrdenFoto'];
				$this->FacCantidadDia = $fila['FacCantidadDia'];
				$this->FacFechaVencimiento = $fila['NFacFechaVencimiento'];
				$this->FacFechaVencimiento2 = $fila['FacFechaVencimiento2'];
				$this->FacDiaTranscurrido = $fila['FacDiaTranscurrido'];

				$this->FacIncluyeImpuesto = $fila['FacIncluyeImpuesto'];
				$this->MonId = $fila['MonId'];
				$this->FacTipoCambio = $fila['FacTipoCambio'];
				$this->FacTipoCambioAux = $fila['FacTipoCambioAux'];

				//$this->FacCancelado = $fila['NFacCancelado'];

				$this->FacConcepto = $fila['FacConcepto'];
				$this->FacTipo = $fila['FacTipo'];

				$this->FacDatoAdicional1 = $fila['FacDatoAdicional1'];
				$this->FacDatoAdicional2 = $fila['FacDatoAdicional2'];
				$this->FacDatoAdicional3 = $fila['FacDatoAdicional3'];
				$this->FacDatoAdicional4 = $fila['FacDatoAdicional4'];
				$this->FacDatoAdicional5 = $fila['FacDatoAdicional5'];
				$this->FacDatoAdicional6 = $fila['FacDatoAdicional6'];
				$this->FacDatoAdicional7 = $fila['FacDatoAdicional7'];
				$this->FacDatoAdicional8 = $fila['FacDatoAdicional8'];
				$this->FacDatoAdicional9 = $fila['FacDatoAdicional9'];
				$this->FacDatoAdicional10 = $fila['FacDatoAdicional10'];

				$this->FacDatoAdicional11 = $fila['FacDatoAdicional11'];
				$this->FacDatoAdicional12 = $fila['FacDatoAdicional12'];
				$this->FacDatoAdicional13 = $fila['FacDatoAdicional13'];
				$this->FacDatoAdicional14 = $fila['FacDatoAdicional14'];
				$this->FacDatoAdicional15 = $fila['FacDatoAdicional15'];
				$this->FacDatoAdicional16 = $fila['FacDatoAdicional16'];
				$this->FacDatoAdicional17 = $fila['FacDatoAdicional17'];
				$this->FacDatoAdicional18 = $fila['FacDatoAdicional18'];
				$this->FacDatoAdicional19 = $fila['FacDatoAdicional19'];
				$this->FacDatoAdicional20 = $fila['FacDatoAdicional20'];

				$this->FacDatoAdicional21 = $fila['FacDatoAdicional21'];
				$this->FacDatoAdicional22 = $fila['FacDatoAdicional22'];
				$this->FacDatoAdicional23 = $fila['FacDatoAdicional23'];
				$this->FacDatoAdicional24 = $fila['FacDatoAdicional24'];
				$this->FacDatoAdicional25 = $fila['FacDatoAdicional25'];
				$this->FacDatoAdicional26 = $fila['FacDatoAdicional26'];

				$this->FacDatoAdicional27 = $fila['FacDatoAdicional27'];
				$this->FacDatoAdicional28 = $fila['FacDatoAdicional28'];

				$this->FacEstado = $fila['FacEstado'];
				$this->FacFechaEmision = $fila['NFacFechaEmision'];
				$this->FacHoraEmision = $fila['FacHoraEmision'];
				$this->FacFechaVencimiento = $fila['NFacFechaVencimiento'];
				$this->FacFechaVencimiento2 = $fila['FacFechaVencimiento2'];

				$this->FacPorcentajeImpuestoVenta = $fila['FacPorcentajeImpuestoVenta'];
				$this->FacPorcentajeImpuestoSelectivo = $fila['FacPorcentajeImpuestoSelectivo'];
				$this->FacDireccion = $fila['FacDireccion'];



				$this->FacTotalImpuestoSelectivo = $fila['FacTotalImpuestoSelectivo'];
				$this->FacTotalGravado = $fila['FacTotalGravado'];
				$this->FacTotalDescuento = $fila['FacTotalDescuento'];
				$this->FacTotalGratuito = $fila['FacTotalGratuito'];
				$this->FacTotalExonerado = $fila['FacTotalExonerado'];
				$this->FacTotalPagar = $fila['FacTotalPagar'];


				$this->FacSubTotal = ($fila['FacSubTotal']);
				$this->FacDescuento = ($fila['FacDescuento']);
				$this->FacImpuesto = ($fila['FacImpuesto']);
				$this->FacTotal = ($fila['FacTotal']);
				$this->FacTotalReal = ($fila['FacTotalReal']);

				list($this->FacObservacion, $this->FacObservacionImpresa) = explode("###", $fila['FacObservacion']);
				$this->FacObservacionCaja = $fila['FacObservacionCaja'];
				$this->FacLeyenda = $fila['FacLeyenda'];
				$this->FacCierre = $fila['FacCierre'];

				$this->RegId = $fila['RegId'];
				$this->FacRegimenPorcentaje = $fila['FacRegimenPorcentaje'];
				$this->FacRegimenMonto = $fila['FacRegimenMonto'];
				$this->FacRegimenComprobanteNumero = $fila['FacRegimenComprobanteNumero'];
				$this->FacRegimenComprobanteFecha = $fila['NFacRegimenComprobanteFecha'];

				$this->FacSunatRespuestaTicket = $fila['FacSunatRespuestaTicket'];
				$this->FacSunatRespuestaTicketEstado = $fila['FacSunatRespuestaTicketEstado'];
				$this->FacSunatRespuestaObservacion = $fila['FacSunatRespuestaObservacion'];

				$this->FacSunatRespuestaEnvioTicket = $fila['FacSunatRespuestaEnvioTicket'];
				$this->FacSunatRespuestaEnvioTicketEstado = $fila['FacSunatRespuestaEnvioTicketEstado'];
				$this->FacSunatRespuestaEnvioFecha = $fila['NFacSunatRespuestaEnvioFecha'];
				$this->FacSunatRespuestaEnvioHora = $fila['FacSunatRespuestaEnvioHora'];
				$this->FacSunatRespuestaEnvioCodigo = $fila['FacSunatRespuestaEnvioCodigo'];
				$this->FacSunatRespuestaEnvioContenido = $fila['FacSunatRespuestaEnvioContenido'];

				$this->FacSunatRespuestaBajaTicket = $fila['FacSunatRespuestaBajaTicket'];
				$this->FacSunatRespuestaBajaTicketEstado = $fila['FacSunatRespuestaBajaTicketEstado'];
				$this->FacSunatRespuestaBajaFecha = $fila['NFacSunatRespuestaBajaFecha'];
				$this->FacSunatRespuestaBajaHora = $fila['FacSunatRespuestaBajaHora'];
				$this->FacSunatRespuestaBajaCodigo = $fila['FacSunatRespuestaBajaCodigo'];
				$this->FacSunatRespuestaBajaContenido = $fila['FacSunatRespuestaBajaContenido'];
				$this->FacSunatRespuestaBajaId = $fila['FacSunatRespuestaBajaId'];

				$this->FacSunatRespuestaConsultaCodigo = $fila['FacSunatRespuestaConsultaCodigo'];
				$this->FacSunatRespuestaConsultaContenido = $fila['FacSunatRespuestaConsultaContenido'];
				$this->FacSunatRespuestaConsultaFecha = $fila['NFacSunatRespuestaConsultaFecha'];
				$this->FacSunatRespuestaConsultaHora = $fila['FacSunatRespuestaConsultaHora'];

				$this->FacSunatRespuestaEnvioTiempoCreacion = $fila['NFacSunatRespuestaEnvioTiempoCreacion'];
				$this->FacSunatRespuestaConsultaTiempoCreacion = $fila['NFacSunatRespuestaConsultaTiempoCreacion'];
				$this->FacSunatRespuestaBajaTiempoCreacion = $fila['NFacSunatRespuestaBajaTiempoCreacion'];

				$this->FacSunatRespuestaEnvioDigestValue = $fila['FacSunatRespuestaEnvioDigestValue'];
				$this->FacSunatRespuestaEnvioSignatureValue = $fila['FacSunatRespuestaEnvioSignatureValue'];

				$this->FacSunatUltimaAccion = $fila['FacSunatUltimaAccion'];
				$this->FacSunatUltimaRespuesta = $fila['FacSunatUltimaRespuesta'];

				$this->FacUsuario = $fila['FacUsuario'];
				$this->FacVendedor = $fila['FacVendedor'];
				$this->FacNumeroPedido = $fila['FacNumeroPedido'];
				$this->FacObservado = $fila['FacObservado'];


				$this->FacTiempoCreacion = $fila['NFacTiempoCreacion'];
				$this->FacTiempoModificacion = $fila['NFacTiempoModificacion'];
				$this->FacAbono = $fila['FacAbono'];

				$this->FacAbonado = $fila['FacAbonado'];
				$this->FacSaldo = $fila['FacSaldo'];

				$this->NpaNombre = $fila['NpaNombre'];

				$this->FtaNumero = $fila['FtaNumero'];
				$this->GrtNumero = $fila['GrtNumero'];

				$this->RegAplicacion = $fila['RegAplicacion'];
				$this->RegNombre = $fila['RegNombre'];

				$this->MonNombre = $fila['MonNombre'];
				$this->MonSimbolo = $fila['MonSimbolo'];
				$this->MonSigla = $fila['MonSigla'];
				$this->MonCodigo = $fila['MonCodigo'];

				$this->TdoCodigo = $fila['TdoCodigo'];
				$this->CliNombreCompleto = $fila['CliNombreCompleto'];
				$this->CliNombre = $fila['CliNombre'];
				$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];

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

				$this->CliProvincia = $fila['CliProvincia'];
				$this->CliDistrito = $fila['CliDistrito'];
				$this->CliDepartamento = $fila['CliDepartamento'];

				$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];

				$this->FinId = $fila['FinId'];
				$this->FccId = $fila['FccId'];
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

				$this->FacMontoAmortizado = $fila['FacMontoAmortizado'];
				$this->FacMontoPendiente = $fila['FacMontoPendiente'];

				$this->FacCancelado = $fila['FacCancelado'];

				$this->FacObsequio = $fila['FacObsequio'];
				$this->FacSpot = $fila['FacSpot'];

				$this->VdiId = $fila['VdiId'];
				$this->VdiArchivo = $fila['VdiArchivo'];
				$this->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];


				$this->OrdenVentaVehiculoEinVIN = $fila['OrdenVentaVehiculoEinVIN'];
				$this->OrdenVentaVehiculoEinNombre = $fila['OrdenVentaVehiculoEinNombre'];

				$this->OrdenVentaVehiculoEinNumeroMotor = $fila['OrdenVentaVehiculoEinNumeroMotor'];
				$this->OrdenVentaVehiculoEinAnoFabricacion = $fila['OrdenVentaVehiculoEinAnoFabricacion'];
				$this->OrdenVentaVehiculoEinColor = $fila['OrdenVentaVehiculoEinColor'];
				$this->OrdenVentaVehiculoEinDUA = $fila['OrdenVentaVehiculoEinDUA'];
				$this->OrdenVentaVehiculoVmaNombre = $fila['OrdenVentaVehiculoVmaNombre'];
				$this->OrdenVentaVehiculoVmoNombre = $fila['OrdenVentaVehiculoVmoNombre'];
				$this->OrdenVentaVehiculoVveNombre = $fila['OrdenVentaVehiculoVveNombre'];

				$this->EinCaracteristica10 = $fila['EinCaracteristica10'];
				$this->EinCaracteristica12 = $fila['EinCaracteristica12'];
				$this->EinCaracteristica13 = $fila['EinCaracteristica13'];

				$this->VveCaracteristica1 = $fila['VveCaracteristica1'];
				$this->VveCaracteristica2 = $fila['VveCaracteristica2'];
				$this->VveCaracteristica3 = $fila['VveCaracteristica3'];
				$this->VveCaracteristica4 = $fila['VveCaracteristica4'];
				$this->VveCaracteristica5 = $fila['VveCaracteristica5'];
				$this->VveCaracteristica6 = $fila['VveCaracteristica6'];
				$this->VveCaracteristica7 = $fila['VveCaracteristica7'];
				$this->VveCaracteristica8 = $fila['VveCaracteristica8'];
				$this->VveCaracteristica9 = $fila['VveCaracteristica9'];

				$this->VveCaracteristica10 = $fila['VveCaracteristica10'];
				$this->VveCaracteristica11 = $fila['VveCaracteristica11'];
				$this->VveCaracteristica12 = $fila['VveCaracteristica12'];
				$this->VveCaracteristica13 = $fila['VveCaracteristica13'];
				$this->VveCaracteristica14 = $fila['VveCaracteristica14'];
				$this->VveCaracteristica15 = $fila['VveCaracteristica15'];
				$this->VveCaracteristica16 = $fila['VveCaracteristica16'];
				$this->VveCaracteristica17 = $fila['VveCaracteristica17'];
				$this->VveCaracteristica18 = $fila['VveCaracteristica18'];
				$this->VveCaracteristica19 = $fila['VveCaracteristica19'];
				$this->VveCaracteristica20 = $fila['VveCaracteristica20'];

				$this->SucNombre = $fila['SucNombre'];
				$this->SucDireccion = $fila['SucDireccion'];
				$this->SucDistrito = $fila['SucDistrito'];
				$this->SucProvincia = $fila['SucProvincia'];
				$this->SucDepartamento = $fila['SucDepartamento'];
				$this->SucCodigoUbigeo = $fila['SucCodigoUbigeo'];
				$this->SucCodigoAnexo = $fila['SucCodigoAnexo'];


				switch ($this->FacEstado) {
					case 1:
						$this->FacEstadoDescripcion = "Pendiente";
						break;

					case 5:
						$this->FacEstadoDescripcion = "Entregado";
						break;

					case 6:
						$this->FacEstadoDescripcion = "Anulado";

						break;

					case 7:
						$this->FacEstadoDescripcion = "Reservado";
						break;
				}



				switch ($this->FacEstado) {
					case 1:
						$this->FacEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
						break;

					case 5:
						$this->FacEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
						break;

					case 6:
						$this->FacEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';

						break;

					case 7:
						$this->FacEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
						break;
				}


				if ($oCompleto) {

					$InsFacturaDetalle = new ClsFacturaDetalle($this->InsMysql);

					$ResFacturaDetalle =  $InsFacturaDetalle->MtdObtenerFacturaDetalles(NULL, NULL, NULL, NULL, NULL, $this->FacId, $this->FtaId);
					$this->FacturaDetalle = $ResFacturaDetalle['Datos'];


					//MtdObtenerFacturaAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFactura=NULL,$oFacturaTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL)
					$InsFacturaAlmacenMovimiento = new ClsFacturaAlmacenMovimiento($this->InsMysql);

					$ResFacturaAlmacenMovimiento =  $InsFacturaAlmacenMovimiento->MtdObtenerFacturaAlmacenMovimientos(NULL, NULL, NULL, NULL, NULL, $this->FacId, $this->FtaId, NULL, true, NULL);
					$this->FacturaAlmacenMovimiento = $ResFacturaAlmacenMovimiento['Datos'];


					if (!empty($this->OvvId)) {

						$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario($this->InsMysql);
						$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL, NULL, 'OvpId', 'ASC', NULL, $this->OvvId);
						$this->OrdenVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];

						//$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();
						//					$InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,'OvoId','ASC',NULL,$this->OvvId,NULL);
						//					$this->OrdenVentaVehiculoObsequio = $ResOrdenVentaVehiculoObsequio['Datos'];
						//					
					}
				}
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerFacturas($oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'FacId', $oSentido = 'Desc', $oPaginacion = '0,10', $oSucursal = NULL, $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oTalonario = NULL, $oCredito = NULL, $oRegimen = NULL, $oCondicionPago = NULL, $oNotaCredito = NULL, $oMoneda = NULL, $oCliente = NULL, $oAlmacenMovimiento = NULL, $oDiaVencer = NULL, $oPagado = NULL, $oOrdenVentaVehiculo = NULL, $oVentaDirecta = NULL, $oVendedor = NULL, $oTieneCodigoExterno = NULL, $oNoProcesdado = false, $oCancelado = NULL, $oSinPago = false, $oDiasVencido = NULL, $oVencido = false, $oObsequio = NULL)
	{

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$sucursal = '';
		$estado = '';
		$fecha = '';
		$talonario = '';
		$credito = '';
		$regimen = '';
		$cpago = '';
		$ncredito = '';
		$moneda = '';
		$cliente = '';
		$almacenmovimiento = '';
		$diavencer = '';
		$pagado = '';
		$ovvehiculo = '';
		$ventadirecta = '';
		$vendedor = '';
		$tienecodigoexterno = '';
		$noprocesado = '';
		$cancelado = '';
		$sinpago = '';
		$diasvencido = '';
		$vencido = '';
		$obsequio = '';

		// Variables adicionales que se usan en la consulta SQL
		$ncancelado = '';
		$dvencido = '';
		$tcexterno = '';
		$npago = '';
		$amovimiento = '';
		$dvencer = '';
		$vdirecta = '';

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
					fde.FdeId
					FROM tblfdefacturadetalle fde
						
					WHERE 
						fde.FacId = fac.FacId AND
						fde.FtaId = fac.FtaId AND
						
						(
						fde.FdeDescripcion LIKE "%' . $oFiltro . '%" 
						
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

		//		if(!empty($oSucursal)){
		//			$sucursal = ' AND fta.SucId = "'.$oSucursal.'"';
		//		}
		//			
		if (!empty($oEstado)) {

			$elementos = explode(",", $oEstado);

			$i = 1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$estado .= '  (fac.FacEstado = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$estado .= ' OR ';
				}
				$i++;
			}

			$estado .= ' ) ';
		}


		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fac.FacFechaEmision)>="' . $oFechaInicio . '" AND DATE(fac.FacFechaEmision)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fac.FacFechaEmision)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fac.FacFechaEmision)<="' . $oFechaFin . '"';
			}
		}


		if (!empty($oTalonario)) {
			$talonario = ' AND fac.FtaId = "' . $oTalonario . '"';
		}



		if (!empty($oNotaCredito)) {
			switch ($oNotaCredito) {
				case 1:

					$ncredito = ' AND EXISTS (
							SELECT ncr.NcrId
								FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId 
											AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.FacId IS NULL 
											AND ncr.BtaId IS NULL
				)';

					break;

				case 2:

					$ncredito = ' AND NOT EXISTS  (
							SELECT ncr.NcrId
								FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId 
											AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.FacId IS NULL 
											AND ncr.BtaId IS NULL
						)';

					break;
			}
		}

		if (!empty($oRegimen)) {
			$regimen = ' AND fac.RegId = "' . $oRegimen . '"';
		}

		if (!empty($oCondicionPago)) {
			$npago = ' AND fac.NpaId = "' . $oCondicionPago . '"';
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND fac.MonId = "' . $oMoneda . '"';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND fac.CliId = "' . $oCliente . '"';
		}


		if (!empty($oAlmacenMovimiento)) {
			$amovimiento = ' AND fac.AmoId = "' . $oAlmacenMovimiento . '"';
		}


		if (!empty($oDiaVencer)) {
			$dvencer = ' AND (fac.FacCantidadDia - IFNULL(DATEDIFF(DATE(NOW()),fac.FacFechaEmision),0)) <= ' . $oDiaVencer;
		}

		if (!empty($oPagado)) {

			switch ($oPagado) {
				case 1:

					/*$pagado = '
						
						AND
						
						(
							IFNULL((
							SELECT 
							SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) ) 
							FROM tblpacpagocomprobante cpc
								LEFT JOIN tblpagpago pag
								ON cpc.PagId = pag.PagId
								
								WHERE (cpc.FacId = fac.FacId AND cpc.FtaId = fac.FtaId)
							),0) >= fac.FacTotal
						)
						
						
						
						
					';*/

					$pagado = '

						AND

						(
							IFNULL((
							SELECT 
								SUM(ROUND(pag.PagMonto/IFNULL(pag.PagTipoCambio,1),2)) 

							FROM tblpacpagocomprobante cpc
								LEFT JOIN tblpagpago pag
								ON cpc.PagId = pag.PagId
								
								WHERE (cpc.FacId = fac.FacId AND cpc.FtaId = fac.FtaId)
							),0) >= (fac.FacTotal/IFNULL(fac.FacTipoCambio,1))
						)

					';

					break;

				case 2:

					$pagado = '
						
						AND
						
						(
							IFNULL((
							SELECT 
								SUM(ROUND(pag.PagMonto/IFNULL(pag.PagTipoCambio,1),2)) 

							FROM tblpacpagocomprobante cpc
								LEFT JOIN tblpagpago pag
								ON cpc.PagId = pag.PagId
								
								WHERE (cpc.FacId = fac.FacId AND cpc.FtaId = fac.FtaId)
							),0) < (fac.FacTotal/IFNULL(fac.FacTipoCambio,1))
						)
					';

					break;

				default:

					break;
			}
		}

		if (!empty($oOrdenVentaVehiculo)) {
			$ovvehiculo = ' AND fac.OvvId = "' . $oOrdenVentaVehiculo . '"';
		}


		if (!empty($oVentaDirecta)) {
			$vdirecta = ' AND amo.VdiId = "' . $oVentaDirecta . '"';
		}


		if (!empty($oVendedor)) {
			$vendedor = ' AND vdi.PerId = "' . $oVendedor . '" OR ovv.PerId = "' . $oVendedor . '" ';
		}

		if (!empty($oTieneCodigoExterno)) {


			switch ($oTieneCodigoExterno) {
				case 1:
					$tcexterno = ' AND 
					EXISTS(
						SELECT 
						fam.FamId
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
						WHERE vdi.VdiCodigoExterno IS NOT NULL
						AND fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId		
						AND  vdi.VdiCodigoExterno != ""				
						
					)					
					';
					break;

				case 2:
					$tcexterno = ' AND 
					EXISTS(
						SELECT 
						fam.FamId
						FROM tblfamfacturaalmacenmovimiento fam
							LEFT JOIN tblamoalmacenmovimiento amo
							ON fam.AmoId = amo.AmoId
								LEFT JOIN tblvdiventadirecta vdi
								ON amo.VdiId = vdi.VdiId
						WHERE vdi.VdiCodigoExterno IS  NULL
						AND fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId						
						AND  vdi.VdiCodigoExterno = ""		
					)			
					';
					break;

				default:

					break;
			}
		}


		if (!empty($oSucursal)) {
			$sucursal = ' AND fac.SucId = "' . $oSucursal . '"';
		}

		if (($oNoProcesdado)) {

			$noprocesado = ' 	AND (fac.FacSunatRespuestaEnvioContenido NOT LIKE "%aceptad%" 
				OR fac.FacSunatRespuestaEnvioContenido IS NULL 
				OR fac.FacSunatRespuestaEnvioContenido  = ""
				
				) ';
		}






		if (!empty($oCancelado)) {
			switch ($oCancelado) {

				case "Si":

					//$cancelado = ' HAVING NFacCancelado = 1 ';
					$ncancelado = ' AND FacCancelado = 1 ';

					break;

				case "No":

					//$cancelado = '  HAVING NFacCancelado = 2 ';
					$ncancelado = ' AND FacCancelado = 2 ';
					break;
			}
		}

		if (($oSinPago)) {

			$sinpago = ' AND 
			
			(
			
			IFNULL
			
			(
				
				(
			
					SELECT 
					SUM(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
						
					WHERE pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
					AND pag.PagEstado = 3
					
					LIMIT 1
				
				) ,0 
				
			) <  fac.FacTotal/IFNULL(fac.FacTipoCambio,1) 
			
			) AND fac.OvvId IS NULL
			
			';
		}



		if (!empty($oDiaVencido)) {

			if ($oDiasVencido == -1) {
				$oDiasVencido = 0;
			}
			$dvencido = 'AND DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) = ' . $oDiasVencido;
		}



		if ($oVencido) {
			$vencido = ' AND DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) > 0 ';
		}


		if (!empty($oObsequio)) {
			$obsequio = ' AND fac.FacObsequio = ' . $oObsequio . ' ';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fac.FacId,
				fac.FtaId,
				fac.UsuId,
				
				fac.CliId,

				
				fac.GreId,
				fac.GrtId,
				
				fac.NpaId,
				fac.AmoId,
				fac.OvvId,
				fac.FccId,
				
				
				fac.PagId,
				
				CASE
				WHEN EXISTS (
					SELECT ncr.NcrId
						FROM tblncrnotacredito ncr
								WHERE ncr.FacId = fac.FacId 
									AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.BolId IS NULL 
									AND ncr.BtaId IS NULL
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FacNotaCredito,
				
				CASE
				WHEN EXISTS (
					SELECT ndb.NdbId
						FROM tblndbnotadebito ndb
								WHERE ndb.FacId = fac.FacId 
									AND ndb.FtaId = fac.FtaId
									AND ndb.NdbEstado <> 6
									AND ndb.BolId IS NULL 
									AND ndb.BtaId IS NULL
				) THEN "Si"
				ELSE "No"
				END AS FacNotaDebito,
				
				
				fac.FacSIAFNumero,
				fac.FacOrdenNumero,
				DATE_FORMAT(fac.FacOrdenFecha, "%d/%m/%Y") AS "NFacOrdenFecha",
				fac.FacOrdenTipo,
				fac.FacOrdenFoto,
				fac.FacCantidadDia,
				DATEDIFF(DATE(NOW()),fac.FacFechaVencimiento) AS FacDiaVencido,
				
				DATE_FORMAT(fac.FacFechaVencimiento, "%d/%m/%Y") AS "NFacFechaVencimiento",
				fac.FacFechaVencimiento AS "FacFechaVencimiento2",
				DATEDIFF(DATE(NOW()),fac.FacFechaEmision) AS FacDiaTranscurrido,
				
				
					
				fac.FacIncluyeImpuesto,
				fac.MonId,
				fac.FacTipoCambio,
				fac.FacTipoCambioAux,

				fac.FacCancelado,
				fac.FacObsequio,
				fac.FacSpot,
				
				fac.FacConcepto,
				fac.FacTipo,
				
				
				fac.FacDatoAdicional1,
				fac.FacDatoAdicional2,
				fac.FacDatoAdicional3,
				fac.FacDatoAdicional4,
				fac.FacDatoAdicional5,
				fac.FacDatoAdicional6,
				fac.FacDatoAdicional7,
				fac.FacDatoAdicional8,
				fac.FacDatoAdicional9,
				fac.FacDatoAdicional10,
				
				fac.FacDatoAdicional11,
				fac.FacDatoAdicional12,
				fac.FacDatoAdicional13,
				fac.FacDatoAdicional14,
				fac.FacDatoAdicional15,
				fac.FacDatoAdicional16,
				fac.FacDatoAdicional17,
				fac.FacDatoAdicional18,
				fac.FacDatoAdicional19,
				fac.FacDatoAdicional20,
				
				fac.FacDatoAdicional21,
				fac.FacDatoAdicional22,
				fac.FacDatoAdicional23,
				fac.FacDatoAdicional24,
				fac.FacDatoAdicional25,
				fac.FacDatoAdicional26,
fac.FacDatoAdicional27,
fac.FacDatoAdicional28,
				
				fac.FacObservado,
				fac.FacEstado,	
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
DATE_FORMAT(fac.FacTiempoCreacion, "%H:%i:%s") AS "FacHoraEmision",

				DATE_FORMAT(fac.FacFechaVencimiento, "%d/%m/%Y") AS "NFacFechaVencimiento",
				fac.FacFechaVencimiento AS "FacFechaVencimiento2",

				fac.FacPorcentajeImpuestoVenta,
				fac.FacPorcentajeImpuestoSelectivo,
				fac.FacDireccion,
				
				IF(fac.FacEstado=6,0.00,fac.FacTotalImpuestoSelectivo) AS "FacTotalImpuestoSelectivo",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalGravado) AS "FacTotalGravado",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalDescuento) AS "FacTotalDescuento",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalGratuito) AS "FacTotalGratuito",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalExonerado) AS "FacTotalExonerado",	
				IF(fac.FacEstado=6,0.00,fac.FacTotalPagar) AS "FacTotalPagar",	
				

				IF(fac.FacEstado=6,0.00,fac.FacSubTotal) AS "FacSubTotal",	
				IF(fac.FacEstado=6,0.00,fac.FacImpuesto) AS "FacImpuesto",	
				IF(fac.FacEstado=6,0.00,fac.FacTotal) AS "FacTotal",	

				IF(reg.RegAplicacion=2,fac.FacTotal+IFNULL(fac.FacRegimenMonto,0),fac.FacTotal-IFNULL(fac.FacRegimenMonto,0)) AS "FacTotalReal",
				
											
				fac.FacObservacion,
fac.FacObservacionCaja,
fac.FacLeyenda,
				fac.FacCierre,
			
				fac.RegId,
				fac.FacRegimenPorcentaje,
				fac.FacRegimenMonto,
				fac.FacRegimenComprobanteNumero,
				DATE_FORMAT(fac.FacRegimenComprobanteFecha, "%d/%m/%Y") AS "NFacRegimenComprobanteFecha",
				
				fac.FacSunatRespuestaTicket,
				fac.FacSunatRespuestaTicketEstado,
				fac.FacSunatRespuestaObservacion,
				
				fac.FacSunatRespuestaEnvioTicket,
				fac.FacSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(fac.FacSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NFacSunatRespuestaEnvioFecha",
				fac.FacSunatRespuestaEnvioHora,
				fac.FacSunatRespuestaEnvioCodigo,
				fac.FacSunatRespuestaEnvioContenido,
				
				fac.FacSunatRespuestaBajaTicket,
				fac.FacSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(fac.FacSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NFacSunatRespuestaBajaFecha",
				fac.FacSunatRespuestaBajaHora,				
				fac.FacSunatRespuestaBajaCodigo,
				fac.FacSunatRespuestaBajaContenido,
				fac.FacSunatRespuestaBajaId,
				
				fac.FacSunatRespuestaConsultaCodigo,
				fac.FacSunatRespuestaConsultaContenido,
				DATE_FORMAT(fac.FacSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NFacSunatRespuestaConsultaFecha",
				fac.FacSunatRespuestaConsultaHora,
				
				DATE_FORMAT(fac.FacSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(fac.FacSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(fac.FacSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacSunatRespuestaBajaTiempoCreacion",
				fac.FacSunatUltimaAccion,
				fac.FacSunatUltimaRespuesta,
				
				
				
				DATE_FORMAT(fac.FacTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFacTiempoCreacion",
                DATE_FORMAT(fac.FacTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFacTiempoModificacion",

				(SELECT COUNT(fde.FdeId) FROM tblfdefacturadetalle fde WHERE fde.FacId = fac.FacId AND fde.FtaId = fac.FtaId) AS "FacTotalItems",
				
				npa.NpaNombre,
				
				fta.FtaNumero,
				
				reg.RegAplicacion,
				reg.RegNombre,
				
				cli.CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.TdoId,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliEmailFacturacion,
				cli.CliCelular,
				cli.CliFax,		
				cli.CliClaveElectronica,	
				
				mon.MonNombre,
				mon.MonSimbolo,
				mon.MonSigla,
				
				fim.FinId,
				amo.FccId,
				amo.CprId,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					pag.PagId
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.FacId = fac.FacId
						AND cpc.FtaId = fac.FtaId)						
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FacTieneAbono,
				
				
				@Amortizado:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.FacId = fac.FacId
						AND cpc.FtaId = fac.FtaId)
						AND pag.PagEstado = 3
				) AS FacMontoAmortizado,
				
				/*
				@AmortizadoOtro:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS FacMontoAmortizadoOtro,
				*/
				
				
				@AmortizadoOtroVehiculo:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE pac.OvvId = fac.OvvId
					AND pag.PagEstado = 3
				) AS FacMontoAmortizadoOtroVehiculo,
				
				
				(
					(fac.FacTotal/IFNULL(fac.FacTipoCambio,1)) - IFNULL(@Amortizado,0) 
				) AS FacMontoPendiente,
				
				
				IF(IFNULL(	
				( (fac.FacTotal/IFNULL(fac.FacTipoCambio,1)) - IFNULL(@Amortizado,0) - IFNULL(@AmortizadoOtro,0) - IFNULL(@AmortizadoOtroVehiculo,0)  
				),0) > 0 ,2,1) AS NFacCancelado,
				
				
				vdi.VdiId,
				vdi.VdiOrdenCompraNumero,
				vdi.VdiArchivo,
				
				
				amo.AmoTipo,
				amo.AmoSubTipo,
				
				
				(
					SELECT 
					vdi.VdiCodigoExterno
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
							LEFT JOIN tblvdiventadirecta vdi
							ON amo.VdiId = vdi.VdiId
					WHERE vdi.VdiCodigoExterno IS NOT NULL
					AND fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId		
					AND  vdi.VdiCodigoExterno != ""	
					LIMIT 1
				) AS VdiCodigoExterno		,
				
				(
					SELECT 
					eco.EcoPorcentaje
					FROM tblecopersonalcomision eco
					WHERE eco.CliId = fac.CliId
						AND eco.EcoFecha <= vdi.VdiFecha 
						AND eco.MonId = fac.MonId
					ORDER BY eco.EcoFecha DESC
					LIMIT 1
				) AS FacPorcentajeComision,
				
				fac.FacPagoComision,
				
				tdo.TdoNombre,
				tdo.TdoCodigo,
				
				
				suc.SucNombre,
				suc.SucSiglas
			
				
				FROM tblfacfactura fac
				
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					
					
					LEFT JOIN tblnpacondicionpago npa
					ON fac.NpaId = npa.NpaId
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							LEFT JOIN tblregregimen reg
							ON fac.RegId = reg.RegId
							
								LEFT JOIN tblclicliente cli
								ON fac.CliId = cli.CliId
								
									LEFT JOIN tblmonmoneda mon
									ON fac.MonId = mon.MonId
									
									LEFT JOIN tblamoalmacenmovimiento amo
										ON fac.AmoId = amo.AmoId
										
											LEFT JOIN tblvdiventadirecta vdi
											ON amo.VdiId = vdi.VdiId
											
											LEFT JOIN tblfccfichaaccion fcc
											ON amo.FccId = fcc.FccId
											
												LEFT JOIN tblfimfichaingresomodalidad fim
												ON fcc.FimId = fim.FimId
												
													LEFT JOIN tblovvordenventavehiculo ovv
													ON fac.OvvId = ovv.OvvId
													
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
					
														LEFT JOIN tblfinfichaingreso fin
														ON fim.FinId = fin.FinId
															
															
															/*LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId*/
															
															
				WHERE 1 = 1 ' . $filtrar . $sucursal . $ncancelado . $estado . $fecha . $sinpago . $dvencido . $vencido .	$obsequio . $noprocesado . $talonario . $tcexterno . $credito . $regimen . $npago . $moneda . $cliente . $ncredito . $amovimiento . $dvencer . $pagado . $ovvehiculo . $ovvehiculo . $vdirecta . $vendedor . $cancelado . $orden . $paginacion;


		/*
			IF(

					(IFNULL((
						SELECT 
						ROUND(SUM((pag.PagMonto/pag.PagTipoCambio)),0)
						FROM tblpacpagocomprobante pac
							LEFT JOIN tblpagpago pag
							ON pac.PagId = pag.PagId
						WHERE pac.FacId = fac.FacId AND pac.FtaId = fac.FtaId
						LIMIT 1
					),0)) >= ROUND(fac.FacTotal,0)
					
					,"SI"
					,"NO"
				
				) AS FacPagado
		*/
		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsFactura = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$Factura = new $InsFactura();
			$Factura->FacId = $fila['FacId'];
			$Factura->FtaId = $fila['FtaId'];
			$Factura->SucId = $fila['SucId'];
			$Factura->UsuId = $fila['UsuId'];

			$Factura->CliId = $fila['CliId'];


			$Factura->GreId = $fila['GreId'];
			$Factura->GrtId = $fila['GrtId'];

			$Factura->NpaId = $fila['NpaId'];
			$Factura->AmoId = $fila['AmoId'];
			$Factura->OvvId = $fila['OvvId'];
			$Factura->FccId = $fila['FccId'];

			$Factura->PagId = $fila['PagId'];


			$Factura->FacNotaEntrega = $fila['FacNotaEntrega'];
			$Factura->FacNotaCredito = $fila['FacNotaCredito'];
			$Factura->FacNotaDebito = $fila['FacNotaDebito'];

			$Factura->FacSIAFNumero = $fila['FacSIAFNumero'];
			$Factura->FacOrdenNumero = $fila['FacOrdenNumero'];
			$Factura->FacOrdenFecha = $fila['NFacOrdenFecha'];
			$Factura->FacOrdenTipo = $fila['FacOrdenTipo'];
			$Factura->FacOrdenFoto = $fila['FacOrdenFoto'];
			$Factura->FacCantidadDia = $fila['FacCantidadDia'];
			$Factura->FacDiaVencido = $fila['FacDiaVencido'];

			$Factura->FacFechaVencimiento = $fila['NFacFechaVencimiento'];
			$Factura->FacFechaVencimiento2 = $fila['FacFechaVencimiento2'];
			$Factura->FacDiaTranscurrido = $fila['FacDiaTranscurrido'];


			$Factura->FacIncluyeImpuesto = $fila['FacIncluyeImpuesto'];
			$Factura->MonId = $fila['MonId'];
			$Factura->FacTipoCambio = $fila['FacTipoCambio'];
			$Factura->FacTipoCambioAux = $fila['FacTipoCambioAux'];


			$Factura->FacCancelado = $fila['FacCancelado'];

			$Factura->FacObsequio = $fila['FacObsequio'];
			$Factura->FacSpot = $fila['FacSpot'];

			$Factura->FacConcepto = $fila['FacConcepto'];
			$Factura->FacTipo = $fila['FacTipo'];


			$Factura->FacDatoAdicional1 = $fila['FacDatoAdicional1'];
			$Factura->FacDatoAdicional2 = $fila['FacDatoAdicional2'];
			$Factura->FacDatoAdicional3 = $fila['FacDatoAdicional3'];
			$Factura->FacDatoAdicional4 = $fila['FacDatoAdicional4'];
			$Factura->FacDatoAdicional5 = $fila['FacDatoAdicional5'];
			$Factura->FacDatoAdicional6 = $fila['FacDatoAdicional6'];
			$Factura->FacDatoAdicional7 = $fila['FacDatoAdicional7'];
			$Factura->FacDatoAdicional8 = $fila['FacDatoAdicional8'];
			$Factura->FacDatoAdicional9 = $fila['FacDatoAdicional9'];
			$Factura->FacDatoAdicional10 = $fila['FacDatoAdicional10'];

			$Factura->FacDatoAdicional11 = $fila['FacDatoAdicional11'];
			$Factura->FacDatoAdicional12 = $fila['FacDatoAdicional12'];
			$Factura->FacDatoAdicional13 = $fila['FacDatoAdicional13'];
			$Factura->FacDatoAdicional14 = $fila['FacDatoAdicional14'];
			$Factura->FacDatoAdicional15 = $fila['FacDatoAdicional15'];
			$Factura->FacDatoAdicional16 = $fila['FacDatoAdicional16'];
			$Factura->FacDatoAdicional17 = $fila['FacDatoAdicional17'];
			$Factura->FacDatoAdicional18 = $fila['FacDatoAdicional18'];
			$Factura->FacDatoAdicional19 = $fila['FacDatoAdicional19'];
			$Factura->FacDatoAdicional20 = $fila['FacDatoAdicional20'];

			$Factura->FacDatoAdicional21 = $fila['FacDatoAdicional21'];
			$Factura->FacDatoAdicional22 = $fila['FacDatoAdicional22'];
			$Factura->FacDatoAdicional23 = $fila['FacDatoAdicional23'];
			$Factura->FacDatoAdicional24 = $fila['FacDatoAdicional24'];
			$Factura->FacDatoAdicional25 = $fila['FacDatoAdicional25'];
			$Factura->FacDatoAdicional26 = $fila['FacDatoAdicional26'];

			$Factura->FacDatoAdicional27 = $fila['FacDatoAdicional27'];
			$Factura->FacDatoAdicional28 = $fila['FacDatoAdicional28'];

			$Factura->FacEstado = $fila['FacEstado'];
			$Factura->FacFechaEmision = $fila['NFacFechaEmision'];
			$Factura->FacHoraEmision = $fila['FacHoraEmision'];


			$Factura->FacFechaVencimiento = $fila['NFacFechaVencimiento'];
			$Factura->FacFechaVencimiento2 = $fila['FacFechaVencimiento2'];

			$Factura->FacPorcentajeImpuestoVenta = $fila['FacPorcentajeImpuestoVenta'];
			$Factura->FacPorcentajeImpuestoSelectivo = $fila['FacPorcentajeImpuestoSelectivo'];
			$Factura->FacDireccion = $fila['FacDireccion'];

			$Factura->FacTotalBruto = $fila['FacTotalBruto'];




			$Factura->FacTotalImpuestoSelectivo = $fila['FacTotalImpuestoSelectivo'];
			$Factura->FacTotalGravado = $fila['FacTotalGravado'];
			$Factura->FacTotalDescuento = $fila['FacTotalDescuento'];
			$Factura->FacTotalGratuito = $fila['FacTotalGratuito'];
			$Factura->FacTotalExonerado = $fila['FacTotalExonerado'];
			$Factura->FacTotalPagar = $fila['FacTotalPagar'];

			$Factura->FacSubTotal = $fila['FacSubTotal'];
			$Factura->FacDescuento = $fila['FacDescuento'];
			$Factura->FacImpuesto = $fila['FacImpuesto'];
			$Factura->FacTotal = $fila['FacTotal'];
			$Factura->FacTotalReal = $fila['FacTotalReal'];

			list($Factura->FacObservacion, $Factura->FacObservacionImpresa) = explode("###", $fila['FacObservacion']);
			$Factura->FacObservacionCaja = $fila['FacObservacionCaja'];
			$Factura->FacLeyenda = $fila['FacLeyenda'];
			$Factura->FacCierre = $fila['FacCierre'];

			$Factura->RegId = $fila['RegId'];
			$Factura->FacRegimenPorcentaje = $fila['FacRegimenPorcentaje'];
			$Factura->FacRegimenMonto = $fila['FacRegimenMonto'];
			$Factura->FacRegimenComprobanteNumero = $fila['FacRegimenComprobanteNumero'];
			$Factura->FacRegimenComprobanteFecha = $fila['NFacRegimenComprobanteFecha'];

			$Factura->FacSunatRespuestaTicket = $fila['FacSunatRespuestaTicket'];
			$Factura->FacSunatRespuestaTicketEstado = $fila['FacSunatRespuestaTicketEstado'];
			$Factura->FacSunatRespuestaObservacion = $fila['FacSunatRespuestaObservacion'];

			$Factura->FacSunatRespuestaEnvioTicket = $fila['FacSunatRespuestaEnvioTicket'];
			$Factura->FacSunatRespuestaEnvioTicketEstado = $fila['FacSunatRespuestaEnvioTicketEstado'];
			$Factura->FacSunatRespuestaEnvioCodigo = $fila['FacSunatRespuestaEnvioCodigo'];
			$Factura->FacSunatRespuestaEnvioContenido = $fila['FacSunatRespuestaEnvioContenido'];
			$Factura->FacSunatRespuestaEnvioFecha = $fila['NFacSunatRespuestaEnvioFecha'];
			$Factura->FacSunatRespuestaEnvioHora = $fila['FacSunatRespuestaEnvioHora'];

			$Factura->FacSunatRespuestaBajaTicket = $fila['FacSunatRespuestaBajaTicket'];
			$Factura->FacSunatRespuestaBajaTicketEstado = $fila['FacSunatRespuestaBajaTicketEstado'];
			$Factura->FacSunatRespuestaBajaFecha = $fila['NFacSunatRespuestaBajaFecha'];
			$Factura->FacSunatRespuestaBajaHora = $fila['FacSunatRespuestaBajaHora'];
			$Factura->FacSunatRespuestaBajaCodigo = $fila['FacSunatRespuestaBajaCodigo'];
			$Factura->FacSunatRespuestaBajaContenido = $fila['FacSunatRespuestaBajaContenido'];
			$Factura->FacSunatRespuestaBajaId = $fila['FacSunatRespuestaBajaId'];

			$Factura->FacSunatRespuestaConsultaCodigo = $fila['FacSunatRespuestaConsultaCodigo'];
			$Factura->FacSunatRespuestaConsultaContenido = $fila['FacSunatRespuestaConsultaContenido'];
			$Factura->FacSunatRespuestaConsultaFecha = $fila['NFacSunatRespuestaConsultaFecha'];
			$Factura->FacSunatRespuestaConsultaHora = $fila['FacSunatRespuestaConsultaHora'];

			$Factura->FacSunatRespuestaEnvioTiempoCreacion = $fila['NFacSunatRespuestaEnvioTiempoCreacion'];
			$Factura->FacSunatRespuestaConsultaTiempoCreacion = $fila['NFacSunatRespuestaConsultaTiempoCreacion'];
			$Factura->FacSunatRespuestaBajaTiempoCreacion = $fila['NFacSunatRespuestaBajaTiempoCreacion'];

			$Factura->FacSunatUltimaAccion = $fila['FacSunatUltimaAccion'];
			$Factura->FacSunatUltimaRespuesta = $fila['FacSunatUltimaRespuesta'];

			$Factura->FacObservado = $fila['FacObservado'];
			$Factura->FacTiempoCreacion = $fila['NFacTiempoCreacion'];
			$Factura->FacTiempoModificacion = $fila['NFacTiempoModificacion'];

			$Factura->FacTotalItems = $fila['FacTotalItems'];

			$Factura->NpaNombre = $fila['NpaNombre'];

			$Factura->FtaNumero = $fila['FtaNumero'];

			$Factura->RegAplicacion = $fila['RegAplicacion'];
			$Factura->RegNombre = $fila['RegNombre'];

			if ($Factura->FacEstado == 6) {


				$Factura->CliNombre = "ANULADO";
				$Factura->CliNombreCompleto = "ANULADO";
				$Factura->CliApellidoPaterno = "";
				$Factura->CliApellidoMaterno = "";
			} else {
				$Factura->CliNombre = $fila['CliNombre'];
				$Factura->CliNombreCompleto = $fila['CliNombreCompleto'];
				$Factura->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$Factura->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			}




			$Factura->TdoId = $fila['TdoId'];
			$Factura->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$Factura->CliTelefono = $fila['CliTelefono'];
			$Factura->CliEmail = $fila['CliEmail'];
			$Factura->CliEmailFacturacion = $fila['CliEmailFacturacion'];
			$Factura->CliCelular = $fila['CliCelular'];
			$Factura->CliFax = $fila['CliFax'];
			$Factura->CliClaveElectronica = $fila['CliClaveElectronica'];

			$Factura->MonNombre = $fila['MonNombre'];
			$Factura->MonSimbolo = $fila['MonSimbolo'];
			$Factura->MonSigla = $fila['MonSigla'];

			$Factura->FinId = $fila['FinId'];
			$Factura->FccId = $fila['FccId'];
			$Factura->CprId = $fila['CprId'];

			$Factura->FacTieneAbono = $fila['FacTieneAbono'];

			$Factura->FacMontoAmortizado = $fila['FacMontoAmortizado'];
			$Factura->FacMontoPendiente = $fila['FacMontoPendiente'];
			//$Factura->FacCancelado = $fila['NFacCancelado'];

			$Factura->VdiId = $fila['VdiId'];
			$Factura->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
			$Factura->VdiArchivo = $fila['VdiArchivo'];

			$Factura->AmoTipo = $fila['AmoTipo'];
			$Factura->AmoSubTipo = $fila['AmoSubTipo'];
			$Factura->VdiCodigoExterno = $fila['VdiCodigoExterno'];

			$Factura->FacPagoComision = $fila['FacPagoComision'];
			$Factura->FacPorcentajeComision = $fila['FacPorcentajeComision'];
			$Factura->FacPagado = $fila['FacPagado'];


			$Factura->TdoNombre = $fila['TdoNombre'];
			$Factura->TdoCodigo = $fila['TdoCodigo'];

			$Factura->SucNombre = $fila['SucNombre'];
			$Factura->SucSiglas = $fila['SucSiglas'];


			switch ($Factura->FacEstado) {
				case 1:
					$Factura->FacEstadoDescripcion = "Pendiente";
					break;

				case 5:
					$Factura->FacEstadoDescripcion = "Entregado";
					break;

				case 6:
					$Factura->FacEstadoDescripcion = "Anulado";

					break;

				case 7:
					$Factura->FacEstadoDescripcion = "Reservado";
					break;
			}


			switch ($Factura->FacEstado) {
				case 1:
					$Factura->FacEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;

				case 5:
					$Factura->FacEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;

				case 6:
					$Factura->FacEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';

					break;

				case 7:
					$Factura->FacEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
			}


			$Factura->InsMysql = NULL;

			$Respuesta['Datos'][] = $Factura;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}

	//MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL) 
	public function MtdObtenerFacturasValor($oFuncion = "SUM", $oParametro = "FacId", $oMes = NULL, $oAno = NULL, $oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'FacId', $oSentido = 'Desc', $oEliminado = 1, $oPaginacion = '0,10', $oSucursal = NULL, $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oTalonario = NULL, $oRegimen = NULL, $oCondicionPago = NULL, $oNotaCredito = NULL, $oMoneda = NULL, $oCliente = NULL, $oAlmacenMovimiento = NULL, $oClienteClasificacion = NULL, $oFichaIngresoMantenimientoKilometraje = NULL, $oModalidadIngreso = NULL, $oVehiculoMarca = NULL, $oVehiculoModelo = NULL, $oClienteTipo = NULL, $oTecnico = NULL, $oOrigen = NULL, $oVendedor = NULL)
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


		//	if(!empty($oSucursal)){
		//			$sucursal = ' AND fta.SucId = "'.$oSucursal.'"';
		//		}

		if (!empty($oEstado)) {

			$elementos = explode(",", $oEstado);

			$i = 1;
			$estado .= ' AND (';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$estado .= '  (fac.FacEstado = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$estado .= ' OR ';
				}
				$i++;
			}

			$estado .= ' ) ';
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fac.FacFechaEmision)>="' . $oFechaInicio . '" AND DATE(fac.FacFechaEmision)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(fac.FacFechaEmision)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(fac.FacFechaEmision)<="' . $oFechaFin . '"';
			}
		}


		if (!empty($oTalonario)) {
			$talonario = ' AND fac.FtaId = "' . $oTalonario . '"';
		}



		if (!empty($oNotaCredito)) {
			switch ($oNotaCredito) {
				case 1:

					$ncredito = ' AND EXISTS (
							SELECT ncr.NcrId
								FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId 
											AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.FacId IS NULL 
											AND ncr.BtaId IS NULL
				)';

					break;

				case 2:

					$ncredito = ' AND NOT EXISTS EXISTS (
							SELECT ncr.NcrId
								FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId 
											AND ncr.FtaId = fac.FtaId
											AND ncr.NcrEstado <> 6
											AND ncr.FacId IS NULL 
											AND ncr.BtaId IS NULL
						)';

					break;
			}
		}


		if (!empty($oRegimen)) {
			$regimen = ' AND fac.RegId = "' . $oRegimen . '"';
		}

		if (!empty($oCondicionPago)) {
			$npago = ' AND fac.NpaId = "' . $oCondicionPago . '"';
		}

		if (!empty($oMoneda)) {
			$moneda = ' AND fac.MonId = "' . $oMoneda . '"';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND fac.CliId = "' . $oCliente . '"';
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
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.AmoId = amo.AmoId
					WHERE fac.FacId = fam.FacId AND fac.FtaId = fam.FtaId
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
								LEFT JOIN tblfacfactura fac2
								ON fac2.AmoId = amo.AmoId
					WHERE fac.FacId = fac2.FacId AND fac.FtaId = fac2.FtaId
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
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.AmoId = amo.AmoId
					WHERE fac.FacId = fam.FacId AND fac.FtaId = fam.FtaId
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
								LEFT JOIN tblfacfactura fac2
								ON fac2.AmoId = amo.AmoId
								
					WHERE fac.FacId = fac2.FacId AND fac.FtaId = fac2.FtaId
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
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.AmoId = amo.AmoId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE fac.FacId = fam.FacId AND fac.FtaId = fam.FtaId
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
								LEFT JOIN tblfacfactura fac2
								ON fac2.AmoId = amo.AmoId
								
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE fac.FacId = fac2.FacId AND fac.FtaId = fac2.FtaId
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
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.AmoId = amo.AmoId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE fac.FacId = fam.FacId AND fac.FtaId = fam.FtaId
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
								LEFT JOIN tblfacfactura fac2
								ON fac2.AmoId = amo.AmoId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE fac.FacId = fac2.FacId AND fac.FtaId = fac2.FtaId
					AND vve.VmoId = "' . $oVehiculoModelo . '"
					
				)
				
			)
			';
		}


		if (!empty($oClienteTipo)) {
			$ctipo = ' AND cli.LtiId = "' . $oClienteTipo . '" ';
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
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.AmoId = amo.AmoId
					WHERE fac.FacId = fam.FacId AND fac.FtaId = fam.FtaId
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
								LEFT JOIN tblfacfactura fac2
								ON fac2.AmoId = amo.AmoId
								
					WHERE fac.FacId = fac2.FacId AND fac.FtaId = fac2.FtaId
					AND fin.PerId = "' . $oTecnico . '"
					
				)
			)
			';
		}



		if (!empty($oMes)) {
			$mes = ' AND MONTH(fac.FacFechaEmision) ="' . ($oMes) . '"';
		}

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fac.FacFechaEmision) ="' . ($oAno) . '"';
		}

		if (!empty($oAlmacenMovimiento)) {
			$amovimiento = ' AND fac.AmoId = "' . $oAlmacenMovimiento . '"';
		}


		if (!empty($oOrigen)) {

			switch ($oOrigen) {
				case "FichaIngreso":
					$origen = ' AND fac.FccId IS NOT NULL   ';
					break;

				case "OrdenVentaVehiculo":
					$origen = ' AND fac.OvvId IS NOT NULL ';
					break;

				case "VentaDirecta":
					$origen = ' AND fac.AmoId IS NOT NULL  AND fac.FccId IS NULL ';
					break;

				case "Otros":
					$origen = ' AND fac.FccId IS NULL AND fac.OvvId IS NULL AND fac.AmoId IS NULL ';
					break;

				default:
					$origen = '';
					break;
			}
		}

		if (!empty($oVendedor)) {
			$vendedor = ' AND  
				EXISTS(
					SELECT
					fam.FamId
					FROM tblfamfacturaalmacenmovimiento fam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON fam.AmoId = amo.AmoId
							LEFT JOIN tblvdiventadirecta vdi
							ON amo.VdiId = vdi.VdiId
					WHERE (fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId)
					AND vdi.PerId = "' . $oVendedor . '"
					LIMIT 1

				)
			';
		}



		if (!empty($oFuncion) & !empty($oParametro)) {
			$funcion = $oFuncion . '(' . $oParametro . ')';
		}
		$sql = 'SELECT

		
				' . $funcion . ' AS "RESULTADO"
				FROM tblfacfactura fac
					LEFT JOIN tblftafacturatalonario fta
					ON fac.FtaId = fta.FtaId
						LEFT JOIN tblclicliente cli
						ON fac.CliId = cli.CliId
							LEFT JOIN tblusuusuario usu
							ON fac.UsuId = usu.UsuId
								LEFT JOIN tblperpersonal per
								ON fac.UsuId = per.UsuId

				WHERE 1 = 1 ' . $filtrar . $sucursal . $estado . $fecha . $talonario . $credito . $vendedor . $ncredito . $regimen . $npago . $moneda . $cliente . $ctipo . $mes . $ano . $amovimiento . $clasificacion . $mingreso . $mkilometraje . $vmarca . $vmodelo . $tecnico . $origen . $orden . $paginacion;


		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);


		settype($fila['RESULTADO'], "float");

		return $fila['RESULTADO'];
	}



	public function MtdActualizarEstadoFactura($oElementos, $oEstado)
	{

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$accion = '';
		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$aux = explode("%", $elemento);

				$this->FacId = $aux[0];
				$this->FtaId = $aux[1];


				if (!empty($this->FacId) and !empty($this->FtaId)) {

					$this->MtdObtenerFactura(false);

					if (!empty($this->OvvId)) {

						$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);

						if ($oEstado == 6 and (
							$this->FacEstado == 5 or
							$this->FacEstado == 1 or
							$this->FacEstado == 7)) {

							$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($this->OvvId, 4);
						} else if ($oEstado == 5 and (
							$this->FacEstado == 6 or
							$this->FacEstado == 1 or
							$this->FacEstado == 7)) {

							$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($this->OvvId, 5);
						}
					}
				}



				$sql = 'UPDATE tblfacfactura SET FacEstado = ' . $oEstado . ' WHERE   (FacId = "' . ($aux[0]) . '" AND FtaId = "' . ($aux[1]) . '")';


				$resultado = $this->InsMysql->MtdEjecutar($sql, false);

				if (!$resultado) {
					$error = true;
				} else {



					$this->MtdAuditarFactura(2, "Se actualizo el Estado de la Factura", $aux);
				}
			}
			$i++;
		}


		/*$sql = 'UPDATE tblfacfactura SET FacEstado = '.$oEstado.' WHERE '.$accion;
			$error = false;
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			if(!$resultado) {						
				$error = true;
			} 	*/

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}
	}

	//Accion eliminar	 

	public function MtdEliminarFactura($oElementos)
	{

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#", $oElementos);


		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$aux = explode("%", $elemento);

				$this->FacId = $aux[0];
				$this->FtaId = $aux[1];

				$this->MtdObtenerFactura();

				/*if(!empty($this->FinId)){

						$InsFichaIngreso = new ClsFichaIngreso();
						$InsFichaAccion = new ClsFichaAccion($this->InsMysql);

						if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($this->FinId,75,false)){

							if(!$InsFichaAccion->MtdActualizarEstadoFichaAccion($this->FccId,1)){
								$error = true;	
							}

						}else{
							$error = true;
						}
	
					}*/



				if (!empty($this->OvvId)) {

					$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);
					$InsOrdenVentaVehiculo->OvvId = $this->OvvId;
					$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);

					if ($InsOrdenVentaVehiculo->OvvEstado == 5) {
						$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($this->OvvId, 4);
					}

					//if(!empty($InsOrdenVentaVehiculo->EinId)){
					//								
					//							$InsVehiculoIngreso = new ClsVehiculoIngreso();
					//							$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","RESERVADO",$InsOrdenVentaVehiculo->EinId);
					//								
					//						}

				}




				if (!$error) {

					$sql = 'DELETE FROM tblfacfactura WHERE (FacId = "' . ($aux[0]) . '" AND FtaId = "' . ($aux[1]) . '")';
					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {
						$this->MtdAuditarFactura(3, "Se elimino la Factura", $aux);
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


	public function MtdRegistrarFactura()
	{

		global $Resultado;
		$error = false;

		//		if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->FacFechaEmision))){
		//			$error = true;
		//			$Resultado.='#ERR_FAC_400';
		//		}else{

		$this->FacId = trim($this->FacId);

		$this->InsMysql->MtdTransaccionIniciar();
		/*
				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->CcaId = "CCA-10000";
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->FacDireccion;
				$InsCliente->CliEstado = 1;//En actividad
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
				$InsCliente->CliEliminado = 1;
			
				if(empty($InsCliente->CliId)){
					
					$InsCliente->MtdGenerarClienteId();	

					if(!$InsCliente->MtdRegistrarClienteDeFactura()){
						$error = true;
						$Resultado.='#ERR_FAC_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
				}else{

					//if(!$InsCliente->MtdEditarClienteDato("CliDireccion",$InsCliente->CliDireccion,$InsCliente->CliId)){
//						$error = true;					
//						$Resultado.='#ERR_FAC_302';
//					}

				}	
	*/







		//$InsCliente = new ClsCliente($this->InsMysql);	
		//	
		//				$InsCliente->CliId = $this->CliId;
		//				$InsCliente->CcaId = "CCA-10000";
		//				$InsCliente->TdoId = $this->TdoId;					
		//				$InsCliente->CliNombre = $this->CliNombre;
		//				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
		//				$InsCliente->CliTelefono = $this->CliTelefono;
		//				$InsCliente->CliEmail = $this->CliEmail;
		//				$InsCliente->CliCelular = $this->CliCelular;
		//				$InsCliente->CliFax = $this->CliFax;
		//				$InsCliente->CliEstado = 1;//En actividad
		//				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
		//				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
		//				$InsCliente->CliEliminado = 1;
		//			
		//				if(empty($InsCliente->CliId)){
		//					
		//					$InsCliente->MtdVerificarExisteCliente();
		//	
		//					if(empty($InsCliente->CliId)){
		//						$InsCliente->MtdGenerarClienteId();	
		//						if(!$InsCliente->MtdRegistrarCliente2()){
		//							$error = true;
		//							$Resultado.='#ERR_FAC_301';
		//						}else{
		//							$this->CliId = $InsCliente->CliId;									
		//						}		
		//					}else{
		//						$this->CliId = $InsCliente->CliId;
		//					}
		//					
		//				}else{
		//					if(!$InsCliente->MtdEditarCliente2()){
		//						$error = true;					
		//						$Resultado.='#ERR_FAC_302';
		//					}
		//				}

		//$this->MtdGenerarFacturaId();

		$sql = 'INSERT INTO tblfacfactura (
				FacId,
				FtaId,
				SucId,
				
				UsuId, 
	
				CliId,
				
				GreId,
				GrtId,
				
				NpaId,
				AmoId,
				OvvId,
				FccId,
				
				PagId,
				
				FacSIAFNumero,
				FacOrdenNumero,
				FacOrdenFecha,
				FacOrdenTipo,
				FacOrdenFoto,
				FacCantidadDia,
	
				FacIncluyeImpuesto,
				MonId,
				FacTipoCambio,			
	
				FacCancelado,	
				FacObsequio,
				FacSpot,	
				
			
				FacConcepto,
				FacTipo,
						
				FacEstado,
				FacFechaEmision,
				FacFechaVencimiento,
	
				FacPorcentajeImpuestoVenta,
				FacPorcentajeImpuestoSelectivo,
				FacDireccion,
				FacTotalBruto,
				
				
				
				
				FacTotalImpuestoSelectivo,	
				FacTotalPagar,	
				FacTotalExonerado,	
				FacTotalDescuento,	
				FacTotalGratuito,	
				FacTotalGravado,
				
				FacSubTotal,
				FacImpuesto,
				FacTotal,
				FacTotalReal,
	
				FacObservacion,
				FacObservacionCaja,
				FacLeyenda,
				
				FacCierre,
				RegId,
				FacRegimenPorcentaje,
				FacRegimenMonto,
				FacRegimenComprobanteNumero,
				FacRegimenComprobanteFecha,
				
				
				FacDatoAdicional1,
				FacDatoAdicional2,
				FacDatoAdicional3,
				FacDatoAdicional4,
				FacDatoAdicional5,
				FacDatoAdicional6,
				FacDatoAdicional7,
				FacDatoAdicional8,
				FacDatoAdicional9,
				FacDatoAdicional10,
				
				FacDatoAdicional11,
				FacDatoAdicional12,
				FacDatoAdicional13,
				FacDatoAdicional14,
				FacDatoAdicional15,
				FacDatoAdicional16,
				FacDatoAdicional17,
				FacDatoAdicional18,
				FacDatoAdicional19,
				FacDatoAdicional20,
				
				FacDatoAdicional21,
				FacDatoAdicional22,
				FacDatoAdicional23,
				FacDatoAdicional24,
				FacDatoAdicional25,
				FacDatoAdicional26,
				
				
				FacDatoAdicional27,
				FacDatoAdicional28,
				
				FacUsuario,
				FacVendedor,
				FacNumeroPedido,
				FacObservado,
				
				FacTiempoCreacion,
				FacTiempoModificacion
				
				) 
				VALUES (
				"' . ($this->FacId) . '", 
				"' . ($this->FtaId) . '",
				"' . ($this->SucId) . '",				
				"' . ($this->UsuId) . '",
				"' . ($this->CliId) . '",
				' . (empty($this->GreId) ? 'NULL, ' : '"' . $this->GreId . '",') . '
				' . (empty($this->GrtId) ? 'NULL, ' : '"' . $this->GrtId . '",') . '	
						
				"' . ($this->NpaId) . '",
				' . (empty($this->AmoId) ? 'NULL, ' : '"' . $this->AmoId . '",') . '
				' . (empty($this->OvvId) ? 'NULL, ' : '"' . $this->OvvId . '",') . '
				' . (empty($this->FccId) ? 'NULL, ' : '"' . $this->FccId . '",') . '
				
				' . (empty($this->PagId) ? 'NULL, ' : '"' . $this->PagId . '",') . '
				
				"' . ($this->FacSIAFNumero) . '",
				"' . ($this->FacOrdenNumero) . '",
				' . (empty($this->FacOrdenFecha) ? 'NULL, ' : '"' . $this->FacOrdenFecha . '",') . '
				' . (empty($this->FacOrdenTipo) ? 'NULL, ' : '"' . $this->FacOrdenTipo . '",') . '
				"' . ($this->FacOrdenFoto) . '",
				' . ($this->FacCantidadDia) . ',
				' . ($this->FacIncluyeImpuesto) . ',
				"' . ($this->MonId) . '",
				' . (empty($this->FacTipoCambio) ? 'NULL, ' : '' . $this->FacTipoCambio . ',') . '
				2,
				
				' . ($this->FacObsequio) . ',
				' . ($this->FacSpot) . ',
									
				"' . ($this->FacConcepto) . '",
				' . ($this->FacTipo) . ',	
					
				' . ($this->FacEstado) . ',
				"' . ($this->FacFechaEmision) . '",
				' . (empty($this->FacFechaVencimiento) ? 'NULL, ' : '"' . $this->FacFechaVencimiento . '",') . '
				
				' . ($this->FacPorcentajeImpuestoVenta) . ',
				' . ($this->FacPorcentajeImpuestoSelectivo) . ',
				
				"' . ($this->FacDireccion) . '",
				' . ($this->FacTotalBruto) . ',
				
				' . ($this->FacTotalImpuestoSelectivo) . ',
				' . ($this->FacTotalPagar) . ',
				' . ($this->FacTotalExonerado) . ',
				' . ($this->FacTotalDescuento) . ',
				' . ($this->FacTotalGratuito) . ',
				' . ($this->FacTotalGravado) . ',				
				
				' . ($this->FacSubTotal) . ',
				' . ($this->FacImpuesto) . ',
				' . ($this->FacTotal) . ',
				' . ($this->FacTotalReal) . ',
				"' . ($this->FacObservacion) . '", 
				"' . ($this->FacObservacionCaja) . '", 
				
				"' . ($this->FacLeyenda) . '", 
								
				2, 
				' . (empty($this->RegId) ? 'NULL, ' : '"' . $this->RegId . '",') . '
				' . (empty($this->FacRegimenPorcentaje) ? 'NULL, ' : '' . $this->FacRegimenPorcentaje . ',') . '
				' . (empty($this->FacRegimenMonto) ? 'NULL, ' : '' . $this->FacRegimenMonto . ',') . '
				"' . ($this->FacRegimenComprobanteNumero) . '", 
				' . (empty($this->FacRegimenComprobanteFecha) ? 'NULL, ' : '"' . $this->FacRegimenComprobanteFecha . '",') . '
				
				"' . ($this->FacDatoAdicional1) . '", 
				"' . ($this->FacDatoAdicional2) . '", 
				"' . ($this->FacDatoAdicional3) . '", 
				"' . ($this->FacDatoAdicional4) . '", 
				"' . ($this->FacDatoAdicional5) . '", 
				"' . ($this->FacDatoAdicional6) . '", 
				"' . ($this->FacDatoAdicional7) . '", 
				"' . ($this->FacDatoAdicional8) . '", 
				"' . ($this->FacDatoAdicional9) . '", 
				"' . ($this->FacDatoAdicional10) . '", 
				
				"' . ($this->FacDatoAdicional11) . '", 
				"' . ($this->FacDatoAdicional12) . '", 
				"' . ($this->FacDatoAdicional13) . '", 
				"' . ($this->FacDatoAdicional14) . '", 
				"' . ($this->FacDatoAdicional15) . '", 
				"' . ($this->FacDatoAdicional16) . '", 
				"' . ($this->FacDatoAdicional17) . '", 
				"' . ($this->FacDatoAdicional18) . '", 
				"' . ($this->FacDatoAdicional19) . '", 
				"' . ($this->FacDatoAdicional20) . '", 
				
				"' . ($this->FacDatoAdicional21) . '", 
				"' . ($this->FacDatoAdicional22) . '", 
				"' . ($this->FacDatoAdicional23) . '", 
				"' . ($this->FacDatoAdicional24) . '", 
				"' . ($this->FacDatoAdicional25) . '", 
				"' . ($this->FacDatoAdicional26) . '", 
				
				"' . ($this->FacDatoAdicional27) . '", 
				"' . ($this->FacDatoAdicional28) . '", 
				
				"' . ($this->FacUsuario) . '", 
				"' . ($this->FacVendedor) . '", 
				"' . ($this->FacNumeroPedido) . '", 
				"' . ($this->FacObservado) . '", 
				
				
				"' . ($this->FacTiempoCreacion) . '", 
				"' . ($this->FacTiempoModificacion) . '");';

		if (!$error) {
			$resultado = $this->InsMysql->MtdEjecutar($sql, false);
			if (!$resultado) {
				$error = true;

				switch ($this->InsMysql->MtdObtenerErrorCodigo()) {
					case 1062:
						$Resultado .= "#ERR_FAC_402";
						break;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FacturaDetalle)) {

				$validar = 0;
				$InsFacturaDetalle = new ClsFacturaDetalle($this->InsMysql);

				foreach ($this->FacturaDetalle as $DatFacturaDetalle) {

					$InsFacturaDetalle->FacId = $this->FacId;
					$InsFacturaDetalle->FtaId = $this->FtaId;

					$InsFacturaDetalle->OdeId = $DatFacturaDetalle->OdeId;
					$InsFacturaDetalle->AmdId = $DatFacturaDetalle->AmdId;
					$InsFacturaDetalle->VdeId = $DatFacturaDetalle->VdeId;


					$InsFacturaDetalle->FdeTipo = $DatFacturaDetalle->FdeTipo;

					$InsFacturaDetalle->FdeCodigo = $DatFacturaDetalle->FdeCodigo;
					$InsFacturaDetalle->FdeDescripcion = $DatFacturaDetalle->FdeDescripcion;
					$InsFacturaDetalle->FdeUnidadMedida = $DatFacturaDetalle->FdeUnidadMedida;

					$InsFacturaDetalle->FdePrecio = $DatFacturaDetalle->FdePrecio;
					$InsFacturaDetalle->FdeCantidad = $DatFacturaDetalle->FdeCantidad;
					$InsFacturaDetalle->FdeImporte = $DatFacturaDetalle->FdeImporte;
					$InsFacturaDetalle->FdeImpuestoSelectivo = $DatFacturaDetalle->FdeImpuestoSelectivo;

					$InsFacturaDetalle->FdeValorVenta = $DatFacturaDetalle->FdeValorVenta;
					$InsFacturaDetalle->FdeImpuesto = $DatFacturaDetalle->FdeImpuesto;
					$InsFacturaDetalle->FdeDescuento = $DatFacturaDetalle->FdeDescuento;
					$InsFacturaDetalle->FdeGratuito = $DatFacturaDetalle->FdeGratuito;
					$InsFacturaDetalle->FdeExonerado = $DatFacturaDetalle->FdeExonerado;
					$InsFacturaDetalle->FdeIncluyeSelectivo = $DatFacturaDetalle->FdeIncluyeSelectivo;

					$InsFacturaDetalle->FdeEstado = $this->FacEstado;
					$InsFacturaDetalle->FdeTiempoCreacion = $DatFacturaDetalle->FdeTiempoCreacion;
					$InsFacturaDetalle->FdeTiempoModificacion = $DatFacturaDetalle->FdeTiempoModificacion;
					$InsFacturaDetalle->FdeEliminado = $DatFacturaDetalle->FdeEliminado;

					if ($InsFacturaDetalle->MtdRegistrarFacturaDetalle()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_FAC_201';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->FacturaDetalle) <> $validar) {
					$error = true;
				}
			}
		}

		//				



		if (!$error) {

			if (!empty($this->FacturaAlmacenMovimiento)) {

				$validar = 0;
				$InsFacturaAlmacenMovimiento = new ClsFacturaAlmacenMovimiento($this->InsMysql);

				foreach ($this->FacturaAlmacenMovimiento as $DatFacturaAlmacenMovimiento) {

					$InsFacturaAlmacenMovimiento->FacId = $this->FacId;
					$InsFacturaAlmacenMovimiento->FtaId = $this->FtaId;
					$InsFacturaAlmacenMovimiento->AmoId = $DatFacturaAlmacenMovimiento->AmoId;
					$InsFacturaAlmacenMovimiento->VmvId = $DatFacturaAlmacenMovimiento->VmvId;

					$InsFacturaAlmacenMovimiento->FamEstado = $DatFacturaAlmacenMovimiento->FamEstado;
					$InsFacturaAlmacenMovimiento->FamTiempoCreacion = $DatFacturaAlmacenMovimiento->FamTiempoCreacion;
					$InsFacturaAlmacenMovimiento->FamTiempoModificacion = $DatFacturaAlmacenMovimiento->FamTiempoModificacion;
					$InsFacturaAlmacenMovimiento->FamEliminado = $DatFacturaAlmacenMovimiento->FamEliminado;

					if ($InsFacturaAlmacenMovimiento->MtdRegistrarFacturaAlmacenMovimiento()) {
						$validar++;
					} else {
						//$Resultado.='#ERR_FAC_201';
						//$Resultado.='#Item Numero: '.($validar+1);
					}
				}

				if (count($this->FacturaAlmacenMovimiento) <> $validar) {
					$error = true;
				}
			}
		}



		if ($error) {

			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {

			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarFactura(1, "Se registro la Factura", $this);
			return true;
		}
	}

	public function MtdEditarFactura()
	{

		$error = false;
		global $Resultado;

		//		if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->FacFechaEmision))){
		//			$error = true;
		//			$Resultado.='#ERR_FAC_400';
		//		}else{
		$this->InsMysql->MtdTransaccionIniciar();

		$InsCliente = new ClsCliente($this->InsMysql);

		$InsCliente->CliId = $this->CliId;
		$InsCliente->CcaId = "CCA-10000";
		$InsCliente->TdoId = $this->TdoId;
		$InsCliente->CliNombre = $this->CliNombre;
		$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
		$InsCliente->CliDireccion = $this->FacDireccion;
		$InsCliente->CliEstado = 1; //En actividad
		$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
		$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
		$InsCliente->CliEliminado = 1;

		if (empty($InsCliente->CliId)) {

			$InsCliente->MtdGenerarClienteId();

			if (!$InsCliente->MtdRegistrarClienteDeFactura()) {
				$error = true;
				$Resultado .= '#ERR_FAC_301';
			} else {
				$this->CliId = $InsCliente->CliId;
			}
		} else {

			/*if(!$InsCliente->MtdEditarClienteDato("CliDireccion",$InsCliente->CliDireccion,$InsCliente->CliId)){
						$error = true;					
						$Resultado.='#ERR_FAC_302';
					}*/
		}



		//			$InsCliente = new ClsCliente($this->InsMysql);	
		//			
		//
		//			
		//			$InsCliente->CliId = $this->CliId;
		//					
		//			$InsCliente->CcaId = "CCA-10000";
		//			$InsCliente->TdoId = $this->TdoId;					
		//			$InsCliente->CliNombre = $this->CliNombre;
		//			
		//			$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
		//			
		//			$InsCliente->CliTelefono = $this->CliTelefono;
		//
		//			$InsCliente->CliEmail = $this->CliEmail;
		//			$InsCliente->CliCelular = $this->CliCelular;
		//			$InsCliente->CliFax = $this->CliFax;
		//					
		//			$InsCliente->CliEstado = 1;//En actividad
		//			$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
		//			$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
		//			$InsCliente->CliEliminado = 1;
		//		
		//		
		//			if(empty($InsCliente->CliId)){
		//				
		//				$InsCliente->MtdVerificarExisteCliente();
		//
		//				if(empty($InsCliente->CliId)){
		//					$InsCliente->MtdGenerarClienteId();
		//
		//					if(!$InsCliente->MtdRegistrarCliente2()){
		//						$error = true;
		//						$Resultado.='#ERR_FAC_301';
		//					}else{
		//						$this->CliId = $InsCliente->CliId;									
		//					}		
		//				}else{
		//					$this->CliId = $InsCliente->CliId;
		//				}
		//				
		//			}else{
		//				if(!$InsCliente->MtdEditarCliente2()){
		//					$error = true;					
		//					$Resultado.='#ERR_FAC_302';
		//				}
		//			}



		$sql = 'UPDATE tblfacfactura SET 
			CliId = "' . ($this->CliId) . '",
			' . (empty($this->GreId) ? 'GreId = NULL, ' : 'GreId = "' . $this->GreId . '",') . '
			' . (empty($this->GrtId) ? 'GrtId = NULL, ' : 'GrtId = "' . $this->GrtId . '",') . '			
			NpaId = "' . ($this->NpaId) . '",
			FacSIAFNumero = "' . ($this->FacSIAFNumero) . '",
			FacOrdenNumero = "' . ($this->FacOrdenNumero) . '",
			' . (empty($this->FacOrdenFecha) ? 'FacOrdenFecha = NULL, ' : 'FacOrdenFecha = "' . $this->FacOrdenFecha . '",') . '
			' . (empty($this->FacOrdenTipo) ? 'FacOrdenTipo = NULL, ' : 'FacOrdenTipo = "' . $this->FacOrdenTipo . '",') . '
			FacOrdenFoto = "' . ($this->FacOrdenFoto) . '",
			FacCantidadDia = ' . ($this->FacCantidadDia) . ',			

			FacIncluyeImpuesto = ' . ($this->FacIncluyeImpuesto) . ',
			MonId = "' . ($this->MonId) . '",
			' . (empty($this->FacTipoCambio) ? 'FacTipoCambio = NULL, ' : 'FacTipoCambio = "' . $this->FacTipoCambio . '",') . '
			
			 
	
			FacObsequio = ' . ($this->FacObsequio) . ',
			FacSpot = ' . ($this->FacSpot) . ',	
			
			FacConcepto = "' . ($this->FacConcepto) . '",
			FacTipo = ' . ($this->FacTipo) . ',
			
			FacEstado = ' . ($this->FacEstado) . ',
			FacFechaEmision = "' . ($this->FacFechaEmision) . '",
			' . (empty($this->FacFechaVencimiento) ? 'FacFechaVencimiento = NULL, ' : 'FacFechaVencimiento = "' . $this->FacFechaVencimiento . '",') . '
			FacPorcentajeImpuestoVenta = ' . ($this->FacPorcentajeImpuestoVenta) . ',
			FacPorcentajeImpuestoSelectivo = ' . ($this->FacPorcentajeImpuestoSelectivo) . ',
			
			FacDireccion = "' . ($this->FacDireccion) . '",
			
			FacTotalBruto = "' . ($this->FacTotalBruto) . '",
			
				
					
				
				
			FacTotalImpuestoSelectivo = ' . ($this->FacTotalImpuestoSelectivo) . ',
			FacTotalPagar = ' . ($this->FacTotalPagar) . ',
			FacTotalExonerado = ' . ($this->FacTotalExonerado) . ',
			FacTotalDescuento = ' . ($this->FacTotalDescuento) . ',
			FacTotalGratuito = ' . ($this->FacTotalGratuito) . ',
			FacTotalGravado = ' . ($this->FacTotalGravado) . ',
			
			FacSubTotal = ' . ($this->FacSubTotal) . ',
			FacImpuesto = ' . ($this->FacImpuesto) . ',
			FacTotal = ' . ($this->FacTotal) . ',
			
			FacTotalReal = ' . ($this->FacTotalReal) . ',
			FacObservacion = "' . ($this->FacObservacion) . '",
			FacObservacionCaja = "' . ($this->FacObservacionCaja) . '",
			
			
			FacLeyenda = "' . ($this->FacLeyenda) . '",
			
			' . (empty($this->RegId) ? 'RegId = NULL, ' : 'RegId = "' . $this->RegId . '",') . '
			' . (empty($this->FacRegimenPorcentaje) ? 'FacRegimenPorcentaje = NULL, ' : 'FacRegimenPorcentaje = "' . $this->FacRegimenPorcentaje . '",') . '
			' . (empty($this->FacRegimenMonto) ? 'FacRegimenMonto = NULL, ' : 'FacRegimenMonto = "' . $this->FacRegimenMonto . '",') . '			
			FacRegimenComprobanteNumero = "' . ($this->FacRegimenComprobanteNumero) . '",
			' . (empty($this->FacRegimenComprobanteFecha) ? 'FacRegimenComprobanteFecha = NULL, ' : 'FacRegimenComprobanteFecha = "' . $this->FacRegimenComprobanteFecha . '",') . '
			
			FacDatoAdicional1 = "' . ($this->FacDatoAdicional1) . '",
			FacDatoAdicional2 = "' . ($this->FacDatoAdicional2) . '",
			FacDatoAdicional3 = "' . ($this->FacDatoAdicional3) . '",
			FacDatoAdicional4 = "' . ($this->FacDatoAdicional4) . '",
			FacDatoAdicional5 = "' . ($this->FacDatoAdicional5) . '",
			FacDatoAdicional6 = "' . ($this->FacDatoAdicional6) . '",
			FacDatoAdicional7 = "' . ($this->FacDatoAdicional7) . '",
			FacDatoAdicional8 = "' . ($this->FacDatoAdicional8) . '",
			FacDatoAdicional9 = "' . ($this->FacDatoAdicional9) . '",
			FacDatoAdicional10 = "' . ($this->FacDatoAdicional10) . '",
			
			FacDatoAdicional11 = "' . ($this->FacDatoAdicional11) . '",
			FacDatoAdicional12 = "' . ($this->FacDatoAdicional12) . '",
			FacDatoAdicional13 = "' . ($this->FacDatoAdicional13) . '",
			FacDatoAdicional14 = "' . ($this->FacDatoAdicional14) . '",
			FacDatoAdicional15 = "' . ($this->FacDatoAdicional15) . '",
			FacDatoAdicional16 = "' . ($this->FacDatoAdicional16) . '",
			FacDatoAdicional17 = "' . ($this->FacDatoAdicional17) . '",
			FacDatoAdicional18 = "' . ($this->FacDatoAdicional18) . '",
			FacDatoAdicional19 = "' . ($this->FacDatoAdicional19) . '",
			FacDatoAdicional20 = "' . ($this->FacDatoAdicional20) . '",
			
			FacDatoAdicional21 = "' . ($this->FacDatoAdicional21) . '",
			FacDatoAdicional22 = "' . ($this->FacDatoAdicional22) . '",
			FacDatoAdicional23 = "' . ($this->FacDatoAdicional23) . '",
			FacDatoAdicional24 = "' . ($this->FacDatoAdicional24) . '",
			FacDatoAdicional25 = "' . ($this->FacDatoAdicional25) . '",
			FacDatoAdicional26 = "' . ($this->FacDatoAdicional26) . '",
			
			FacDatoAdicional27 = "' . ($this->FacDatoAdicional27) . '",
			FacDatoAdicional28 = "' . ($this->FacDatoAdicional28) . '",
			
			FacUsuario = "' . ($this->FacUsuario) . '",
			FacVendedor = "' . ($this->FacVendedor) . '",
			FacNumeroPedido = "' . ($this->FacNumeroPedido) . '",
			
			
			
			FacObservado = "' . ($this->FacObservado) . '",
			FacTiempoModificacion = "' . ($this->FacTiempoModificacion) . '"			
			WHERE FacId = "' . ($this->FacId) . '"
			AND FtaId = "' . $this->FtaId . '";';


		if (!$error) {
			$resultado = $this->InsMysql->MtdEjecutar($sql, false);
			if (!$resultado) {
				$error = true;
			}
		}

		if (!$error) {

			if (!empty($this->FacturaDetalle)) {


				$validar = 0;
				$InsFacturaDetalle = new ClsFacturaDetalle($this->InsMysql);

				foreach ($this->FacturaDetalle as $DatFacturaDetalle) {

					$InsFacturaDetalle->FdeId = $DatFacturaDetalle->FdeId;
					$InsFacturaDetalle->FacId = $this->FacId;
					$InsFacturaDetalle->FtaId = $this->FtaId;

					$InsFacturaDetalle->OdeId = $DatFacturaDetalle->OdeId;
					$InsFacturaDetalle->AmdId = $DatFacturaDetalle->AmdId;
					$InsFacturaDetalle->VdeId = $DatFacturaDetalle->VdeId;

					$InsFacturaDetalle->FdeTipo = $DatFacturaDetalle->FdeTipo;

					$InsFacturaDetalle->FdeCodigo = $DatFacturaDetalle->FdeCodigo;
					$InsFacturaDetalle->FdeDescripcion = $DatFacturaDetalle->FdeDescripcion;
					$InsFacturaDetalle->FdeUnidadMedida = $DatFacturaDetalle->FdeUnidadMedida;

					$InsFacturaDetalle->FdeCantidad = $DatFacturaDetalle->FdeCantidad;
					$InsFacturaDetalle->FdePrecio = $DatFacturaDetalle->FdePrecio;
					$InsFacturaDetalle->FdeImporte = $DatFacturaDetalle->FdeImporte;

					$InsFacturaDetalle->FdeValorVenta = $DatFacturaDetalle->FdeValorVenta;
					$InsFacturaDetalle->FdeImpuesto = $DatFacturaDetalle->FdeImpuesto;
					$InsFacturaDetalle->FdeDescuento = $DatFacturaDetalle->FdeDescuento;
					$InsFacturaDetalle->FdeImpuestoSelectivo = $DatFacturaDetalle->FdeImpuestoSelectivo;

					$InsFacturaDetalle->FdeGratuito = $DatFacturaDetalle->FdeGratuito;
					$InsFacturaDetalle->FdeExonerado = $DatFacturaDetalle->FdeExonerado;
					$InsFacturaDetalle->FdeIncluyeSelectivo = $DatFacturaDetalle->FdeIncluyeSelectivo;

					$InsFacturaDetalle->FdeTiempoCreacion = $DatFacturaDetalle->FdeTiempoCreacion;
					$InsFacturaDetalle->FdeTiempoModificacion = $DatFacturaDetalle->FdeTiempoModificacion;
					$InsFacturaDetalle->FdeEliminado = $DatFacturaDetalle->FdeEliminado;

					if (empty($InsFacturaDetalle->FdeId)) {
						if ($InsFacturaDetalle->FdeEliminado <> 2) {
							if ($InsFacturaDetalle->MtdRegistrarFacturaDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FAC_201';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFacturaDetalle->FdeEliminado == 2) {
							if ($InsFacturaDetalle->MtdEliminarFacturaDetalle($InsFacturaDetalle->FdeId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FAC_203';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsFacturaDetalle->MtdEditarFacturaDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FAC_202';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}


				if (count($this->FacturaDetalle) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FacturaAlmacenMovimiento)) {

				$validar = 0;
				foreach ($this->FacturaAlmacenMovimiento as $DatFacturaAlmacenMovimiento) {

					$InsFacturaAlmacenMovimiento = new ClsFacturaAlmacenMovimiento($this->InsMysql);
					$InsFacturaAlmacenMovimiento->FamId = $DatFacturaAlmacenMovimiento->FamId;
					$InsFacturaAlmacenMovimiento->FacId = $this->FacId;
					$InsFacturaAlmacenMovimiento->FtaId = $this->FtaId;

					$InsFacturaAlmacenMovimiento->AmoId = $DatFacturaAlmacenMovimiento->AmoId;
					$InsFacturaAlmacenMovimiento->VmvId = $DatFacturaAlmacenMovimiento->VmvId;

					$InsFacturaAlmacenMovimiento->FamEstado = $DatFacturaAlmacenMovimiento->FamEstado;
					$InsFacturaAlmacenMovimiento->FamTiempoCreacion = $DatFacturaAlmacenMovimiento->FamTiempoCreacion;
					$InsFacturaAlmacenMovimiento->FamTiempoModificacion = $DatFacturaAlmacenMovimiento->FamTiempoModificacion;
					$InsFacturaAlmacenMovimiento->FamEliminado = $DatFacturaAlmacenMovimiento->FamEliminado;

					if (empty($InsFacturaAlmacenMovimiento->FamId)) {
						if ($InsFacturaAlmacenMovimiento->FamEliminado <> 2) {
							if ($InsFacturaAlmacenMovimiento->MtdRegistrarFacturaAlmacenMovimiento()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FAC_211';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFacturaAlmacenMovimiento->FamEliminado == 2) {
							if ($InsFacturaAlmacenMovimiento->MtdEliminarFacturaAlmacenMovimiento($InsFacturaAlmacenMovimiento->FamId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FAC_213';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							//if($InsFacturaAlmacenMovimiento->MtdEditarFacturaAlmacenMovimiento()){
							$validar++;
							//}else{
							//	$Resultado.='#ERR_FAC_212';
							//	$Resultado.='#Item Numero: '.($validar+1);
							///}
						}
					}
				}

				if (count($this->FacturaAlmacenMovimiento) <> $validar) {
					$error = true;
				}
			}
		}


		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarFactura(2, "Se edito la Factura", $this);
			return true;
		}
	}


	public function MtdEditarIdFactura()
	{

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblfacfactura SET 
			FacId = "' . ($this->NFacId) . '",
			FacTiempoModificacion = "' . ($this->FacTiempoModificacion) . '"
			WHERE FacId = "' . ($this->FacId) . '"
			AND FtaId = "' . $this->FtaId . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);
		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			$this->MtdAuditarFactura(2, "Se edito el Codigo de la Factura", $this);
			return true;
		}
	}



	public function MtdVerificarExisteAlmacenMovimientoSalidaId($oAlmacenMovimientoSalidaId)
	{

		$Factura = array();

		$sql = 'SELECT 
		fac.FacId,
		fac.FtaId
        FROM tblfacfactura fac
		
        WHERE  fac.AmoId = "' . $oAlmacenMovimientoSalidaId . '" 
		AND fac.FacEstado <> 6 
		LIMIT 1;';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$Factura[]  = $fila['FacId'];
				$Factura[]  = $fila['FtaId'];
			}
		}
		return $Factura;
	}


	public function MtdVerificarExisteOrdenVentaVehiculoId($oOrdenVentaVehiculoId)
	{

		$Factura = array();

		$sql = 'SELECT 
		fac.FacId,
		fac.FtaId
        FROM tblfacfactura fac
		
        WHERE  fac.OvvId = "' . $oOrdenVentaVehiculoId . '" 
		AND fac.FacEstado <> 6 
		LIMIT 1;';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$Factura[]  = $fila['FacId'];
				$Factura[]  = $fila['FtaId'];
			}
		}
		return $Factura;
	}




	private function MtdAuditarFactura($oAccion, $oDescripcion, $oDatos, $oCodigo = NULL, $oUsuario = NULL, $oPersonal = NULL)
	{

		$InsAuditoria = new ClsAuditoria($this->InsMysql);
		$InsAuditoria->AudCodigo = $this->FacId;
		$InsAuditoria->AudCodigoExtra = $this->FtaId;
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





	public function MtdNotificarFacturaPorVencer($oDestinatario, $oCantidadDia = 5, $oFechaInicio = NULL, $oFechaFin = NULL, $oCondicionPago = NULL)
	{

		global $EmpresaMonedaId;
		global $SistemaNombreAbreviado;

		$Enviar = false;

		$mensaje .= "NOTIFICACION DE ESTADO:";
		$mensaje .= "<br>";
		$mensaje .= "<br>";


		$mensaje .= "Fecha de notificacion: <b>" . date("d/m/Y") . "</b>";
		//$mensaje .= "Facturas por Vencer";	
		$mensaje .= "<br>";

		$mensaje .= "<hr>";
		$mensaje .= "<br>";



		$InsMoneda = new ClsMoneda();


		$ResMoneda = $InsMoneda->MtdObtenerMonedas(NULL, NULL, NULL, "MonId", "ASC", NULL);
		$ArrMonedas = $ResMoneda['Datos'];

		foreach ($ArrMonedas as $DatMoneda) {

			$mensaje .= "<br>";


			// MtdObtenerFacturas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FacId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL)
			$ResFactura = $this->MtdObtenerFacturas(NULL, NULL, NULL, "FacFechaEmision", "DESC", NULL, NULL, NULL, FncCambiaFechaAMysql($oFechaInicio), FncCambiaFechaAMysql($oFechaFin), NULL, NULL, NULL, $oCondicionPago, NULL, $DatMoneda->MonId, NULL, NULL, $oCantidadDia, 2);
			$ArrFacturas = $ResFactura['Datos'];

			if (!empty($ArrFacturas)) {

				$mensaje .= $DatMoneda->MonNombre . " (" . $DatMoneda->MonSimbolo . ")";
				$mensaje .= "<br>";


				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%' border='0'>";

				$mensaje .= "<tr>";

				$mensaje .= "<td width='2%'>";
				$mensaje .= "<b>#</b>";
				$mensaje .= "</td>";

				$mensaje .= "<td width='10%'>";
				$mensaje .= "<b>Factura</b>";
				$mensaje .= "</td>";

				$mensaje .= "<td width='10%'>";
				$mensaje .= "<b>Fecha</b>";
				$mensaje .= "</td>";

				$mensaje .= "<td>";
				$mensaje .= "<b>Cliente</b>";
				$mensaje .= "</td>";

				$mensaje .= "<td width='10%'>";
				$mensaje .= "<b>Total</b>";
				$mensaje .= "</td>";

				$mensaje .= "<td width='10%'>";
				$mensaje .= "<b>Amortizado</b>";
				$mensaje .= "</td>";


				$mensaje .= "<td width='5%'>";
				$mensaje .= "<b>Dias/Cred.</b>";
				$mensaje .= "</td>";

				$mensaje .= "<td width='5%'>";
				$mensaje .= "<b>Dias/Transc.</b>";
				$mensaje .= "</td>";

				$mensaje .= "</tr>";



				$i = 1;

				foreach ($ArrFacturas as $DatFactura) {


					if ($DatFactura->MonId <> $EmpresaMonedaId) {
						$DatFactura->FacTotal = round($DatFactura->FacTotal / $DatFactura->FacTipoCambio, 2);
						$DatFactura->FacMontoAmortizado = round($DatFactura->FacMontoAmortizado / $DatFactura->FacTipoCambio, 2);
					}


					$Dias = $DatFactura->FacCantidadDia - $DatFactura->FacDiaTranscurrido;

					//if($Dias<=$oCantidadDia){


					$mensaje .= "<tr>";


					$mensaje .= "<td>";
					$mensaje .= $i;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FtaNumero . "-" . $DatFactura->FacId;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FacFechaEmision;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatFactura->CliNombre . " " . $DatFactura->CliApellidoPaterno . " " . $DatFactura->CliApellidoMaterno;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FacTotal;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FacMontoAmortizado;
					$mensaje .= "</td>";





					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FacCantidadDia;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatFactura->FacDiaTranscurrido;
					$mensaje .= "</td>";

					$mensaje .= "</tr>";
					$i++;

					//}

					$Enviar = true;
				}




				$mensaje .= "</table>";
			}
		}

		$mensaje .= "<br>";
		$mensaje .= "<br>";
		$mensaje .= "Mensaje autogenerado por sistema " . $SistemaNombreAbreviado . " a las " . date('d/m/Y H:i:s');


		echo $mensaje;

		if ($Enviar) {

			$InsCorreo = new ClsCorreo();
			//$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: FACTURAS C/ CREDITO ",$mensaje);

		}
	}



	public function MtdNotificarFacturaRegistro($oFacturaId, $oFacturaTalonarioId, $oDestinatario)
	{


		$this->FacId = $oFacturaId;
		$this->FtaId = $oFacturaTalonarioId;

		$this->MtdObtenerFactura();

		global $EmpresaMonedaId;
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;

		$mensaje .= "NOTIFICACION DE REGISTRO:";
		$mensaje .= "<br>";
		$mensaje .= "<br>";

		$mensaje .= "Registro de Factura.";
		$mensaje .= "<br>";

		$mensaje .= "<b>Codigo Interno:</b> " . $this->FtaNumero . " - " . $this->FacId . "";
		$mensaje .= "<br>";
		$mensaje .= "<b>Cliente:</b> " . $this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno . "";
		$mensaje .= "<br>";
		$mensaje .= "<b>Fecha de comprobante:</b> " . $this->FacFechaEmision . "";
		$mensaje .= "<br>";
		$mensaje .= "<b>Fecha de vencimiento: </b>" . $this->FacFechaVencimiento . "";
		$mensaje .= "<br>";
		$mensaje .= "<b>Moneda:</b> " . $this->MonSimbolo . "";

		$mensaje .= "<br>";
		$mensaje .= "<b>Observaciones:</b> " . $this->FacObservacionImpresa . "";

		$mensaje .= "<br>";
		$mensaje .= "<b>Leyenda:</b> " . $this->FacLeyenda . "";

		$mensaje .= "<br>";
		$mensaje .= "<b>Usuario:</b> " . $this->UsuUsuario . "";

		$mensaje .= "<hr>";
		$mensaje .= "<br>";


		if ($this->FacTipo == "2") {

			$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";

			$mensaje .= "<tr>";

			$mensaje .= "<td>";
			$mensaje .= "#";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Cant.";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Unidad";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Descripcion";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "P. Unit";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Valor Total";
			$mensaje .= "</td>";

			$mensaje .= "</tr>";

			$mensaje .= "<tr>";

			$mensaje .= "<td>";
			$mensaje .= "1";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= stripslashes($this->FacConcepto);
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "";
			$mensaje .= "</td>";

			$mensaje .= "</tr>";

			$mensaje .= "</table>";

			//
			//					if($this->FacTipo == "2"){
			//						$TotalBruto = $this->FacTotal;
			//					}
			//						
			//					if($this->FacIncluyeImpuesto==2){
			//					
			//						$SubTotal = round($TotalBruto,6);
			//						$Impuesto = round(($SubTotal * ($this->FacPorcentajeImpuestoVenta/100)),6);
			//						$Total = round($SubTotal + $Impuesto,6);
			//					
			//					}else{
			//					
			//						$Total = round($TotalBruto,6);	
			//						$SubTotal = round($Total / (($this->FacPorcentajeImpuestoVenta/100)+1),6);
			//						$Impuesto = round(($Total - $SubTotal),6);
			//					
			//					}

		} else {


			if ($this->MonId <> $EmpresaMonedaId and (!empty($this->FacTipoCambio))) {
				$this->FacSubTotal = round($this->FacSubTotal / $this->FacTipoCambio, 2);
				$this->FacImpuesto = round($this->FacImpuesto  / $this->FacTipoCambio, 2);
				$this->FacTotal = round($this->FacTotal  / $this->FacTipoCambio, 2);
			}


			$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";

			$mensaje .= "<tr>";

			$mensaje .= "<td>";
			$mensaje .= "#";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Cant.";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Unidad";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Descripcion";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "P. Unit";
			$mensaje .= "</td>";

			$mensaje .= "<td>";
			$mensaje .= "Valor Total";
			$mensaje .= "</td>";

			$mensaje .= "</tr>";

			$i = 1;
			$ArrMateriales = array();

			if (!empty($this->FacturaDetalle)) {
				foreach ($this->FacturaDetalle as $DatFacturaDetalle) {



					if ($this->MonId <> $EmpresaMonedaId) {
						$DatFacturaDetalle->FdeImporte = round($DatFacturaDetalle->FdeImporte / $this->FacTipoCambio, 2);
						$DatFacturaDetalle->FdePrecio = round($DatFacturaDetalle->FdePrecio  / $this->FacTipoCambio, 2);
					}


					$mensaje .= "<tr>";

					$mensaje .= "<td>";
					$mensaje .= $i;
					$mensaje .= "</td>";


					$mensaje .= "<td>";
					if ($DatFacturaDetalle->FdeTipo <> "T") {
						$mensaje .= $DatFacturaDetalle->FdeCantidad;
					} else {
						$mensaje .= "-";
					}
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= $DatFacturaDetalle->FdeUnidadMedida;
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					$mensaje .= stripslashes($DatFacturaDetalle->FdeDescripcion);
					$mensaje .= "</td>";


					$mensaje .= "<td>";
					if ($DatFacturaDetalle->FdeTipo <> "T") {
						$mensaje .= number_format(($DatFacturaDetalle->FdePrecio), 2);
					} else {
						$mensaje .= "-";
					}
					$mensaje .= "</td>";

					$mensaje .= "<td>";
					if ($DatFacturaDetalle->FdeTipo <> "T") {
						$mensaje .= number_format(($DatFacturaDetalle->FdeImporte), 2);
					} else {
						$mensaje .= "-";
					}
					$mensaje .= "</td>";

					$mensaje .= "</tr>";
					$i++;
					$TotalBruto = $TotalBruto + $DatFacturaDetalle->FdeImporte;
				}
			}

			$mensaje .= "</table>";






			//	
			//					if($this->FacIncluyeImpuesto==2){
			//				
			//					$SubTotal = round($TotalBruto,6);
			//					$Impuesto = round(($SubTotal * ($this->FacPorcentajeImpuestoVenta/100)),6);
			//					$Total = round($SubTotal + $Impuesto,6);
			//				
			//				}else{
			//				
			//					$Total = round($TotalBruto,6);	
			//					$SubTotal = round($Total / (($this->FacPorcentajeImpuestoVenta/100)+1),6);
			//					$Impuesto = round(($Total - $SubTotal),6);
			//				
			//				}




		}



		if (!empty($this->EinVIN)) {
			$mensaje .= "VIN: " . $this->EinVIN . " - ";
			$mensaje .= " " . $this->EinPlaca . " - ";
			$mensaje .= " " . $this->VmaNombre . " - ";
			$mensaje .= " " . $this->VmoNombre . " - ";
			$mensaje .= " " . $this->VveNombre . " - ";
			$mensaje .= "<br>";
		}



		if (!empty($this->FinId)) {
			$mensaje .= "O.T.: " . $this->FinId . "  ";
			$mensaje .= "Kilom.: " . $this->FinVehiculoKilometraje . " " . (!empty($this->FinVehiculoKilometraje)) ? 'KM' : '';
			$mensaje .= "<br>";
		}


		if (!empty($this->AmoId)) {
			$mensaje .= "Ficha: " . $this->AmoId . " ";
			$mensaje .= "<br>";
		}



		$mensaje .= "<br>";
		$mensaje .= "<br>";

		//	$mensaje .= "SubTotal: ".number_format($SubTotal,2)." ";	
		//					$mensaje .= "<br>";	
		//					
		//					$mensaje .= "Impuesto: ".number_format($Impuesto,2)." ";	
		//					$mensaje .= "<br>";	
		//					
		//					$mensaje .= "Total: ".number_format($Total,2)." ";	
		//					$mensaje .= "<br>";	
		$mensaje .= "SubTotal: " . number_format($this->FacSubTotal, 2) . " ";
		$mensaje .= "<br>";

		$mensaje .= "Impuesto: " . number_format($this->FacImpuesto, 2) . " ";
		$mensaje .= "<br>";

		$mensaje .= "Total: " . number_format($this->FacTotal, 2) . " ";
		$mensaje .= "<br>";


		$mensaje .= "<br>";
		$mensaje .= "<br>";
		$mensaje .= "Mensaje autogenerado por sistema " . $SistemaNombreAbreviado . " a las " . date('d/m/Y H:i:s');


		//	echo $mensaje;
		//echo "----";

		$InsCorreo = new ClsCorreo();
		$InsCorreo->MtdEnviarCorreo($oDestinatario, $SistemaCorreoUsuario, $SistemaCorreoRemitente, "NOTIFICACION: FACTURA Nro.: " . $this->FtaNumero . " - " . $this->FacId . " - " . $this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno, $mensaje);
	}

	public function MtdEditarFacturaDato($oCampo, $oDato, $oId, $oTalonario)
	{

		$sql = 'UPDATE tblfacfactura SET 
			' . (empty($oDato) ? $oCampo . ' = NULL, ' : $oCampo . ' = "' . $oDato . '",') . '
			FacTiempoModificacion = NOW()
			WHERE FacId = "' . ($oId) . '"
			AND FtaId = "' . ($oTalonario) . '"
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

	public function MtdEditarFacturaCancelado($oId, $oTalonario, $oCancelado)
	{

		$sql = 'UPDATE tblfacfactura SET 
			FacCancelado = ' . $oCancelado . ',
			
			
			FacTiempoModificacion = NOW()
			WHERE FacId = "' . ($oId) . '"
			AND FtaId = "' . ($oTalonario) . '"
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



	public function MtdFacturaGenerarArchivoXML($oTalonario, $oId, $oRuta = "")
	{

		global $EmpresaCodigo;
		global $EmpresaNombre;
		global $EmpresaDireccion;
		global $EmpresaMonedaId;

		if (!empty($oTalonario) and !empty($oId)) {


			$this->FacId = $oId;
			$this->FtaId = $oTalonario;
			$this->MtdObtenerFactura(true);

			$InsFactura = $this;



			//deb($InsFactura->FacTipoCambio);
			if ($InsFactura->MonId <> $EmpresaMonedaId) {

				$InsFactura->FacTotalGravado = round($InsFactura->FacTotalGravado / $InsFactura->FacTipoCambio, 2);
				$InsFactura->FacTotalExonerado = round($InsFactura->FacTotalExonerado / $InsFactura->FacTipoCambio, 2);
				$InsFactura->FacTotalGratuito = round($InsFactura->FacTotalGratuito / $InsFactura->FacTipoCambio, 2);
				$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento / $InsFactura->FacTipoCambio, 2);


				$InsFactura->FacTotalPagar = round($InsFactura->FacTotalPagar / $InsFactura->FacTipoCambio, 2);
				//$InsFactura->FacTotalDescuento = round($InsFactura->FacTotalDescuento/$InsFactura->FacTipoCambio,2);

				$InsFactura->FacSubTotal = round($InsFactura->FacSubTotal / $InsFactura->FacTipoCambio, 2);
				$InsFactura->FacImpuesto = round($InsFactura->FacImpuesto / $InsFactura->FacTipoCambio, 2);
				$InsFactura->FacTotal = round($InsFactura->FacTotal / $InsFactura->FacTipoCambio, 2);
				$InsFactura->FacTotalImpuestoSelectivo = round($InsFactura->FacTotalImpuestoSelectivo / $InsFactura->FacTipoCambio, 2);
			}


			$InsFactura->CliNombre = trim($InsFactura->CliNombre);
			$InsFactura->CliApellidoPaterno = trim($InsFactura->CliApellidoPaterno);
			$InsFactura->CliApellidoMaterno = trim($InsFactura->CliApellidoMaterno);



			$InsFactura->FacTotal = round($InsFactura->FacTotal, 2);
			list($parte_entero, $parte_decimal) = explode(".", $InsFactura->FacTotal);

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

			$FacturaTotalLetras = "SON " . $numalet->letra() . " CON " . $parte_decimal . "/100 " . $InsFactura->MonNombre;

			$NOMBRE = $EmpresaCodigo . '-01-' . $InsFactura->FtaNumero . '-' . $InsFactura->FacId;
			$ARCHIVO = $NOMBRE . '.xml';

			$domtree = new DOMDocument('1.0', 'ISO-8859-1');
			//$domtree->preserveWhiteSpace = false;
			$domtree->formatOutput = true;
			$domtree->xmlStandalone = false;

			/* create the root element of the xml tree */
			$xmlRoot = $domtree->createElement("Invoice");
			/* append it to the document created */
			$xmlRoot = $domtree->appendChild($xmlRoot);

			//<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">


			$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
			$xmlRoot->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
			$xmlRoot->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
			$xmlRoot->setAttribute('xmlns:ccts', 'urn:un:unece:uncefact:documentation:2');
			$xmlRoot->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
			$xmlRoot->setAttribute('xmlns:ext', 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
			$xmlRoot->setAttribute('xmlns:qdt', 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2');
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
			//
			////sac:AdditionalInformation

			//$AdditionalInformation = $domtree->createElement("sac:AdditionalInformation");
			//$AdditionalInformation = $ExtensionContent1->appendChild($AdditionalInformation);
			//
			//
			/////'cbc:ID','1001'	//TOTAL VENTAS GRAVADAS
			////sac:AdditionalMonetaryTotal
			//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
			//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
			//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1001'));
			//
			////sac:PayableAmount
			////$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacSubTotal,2, '.', ''));
			//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalGravado,2, '.', ''));
			//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
			//
			/////'cbc:ID','1003'	//TOTAL EXONERADAS
			////sac:AdditionalMonetaryTotal
			//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
			//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
			//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1003'));
			//
			////sac:PayableAmount
			//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalExonerado,2, '.', ''));
			//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
			//
			////'cbc:ID','1004'	//TOTAL GRATUITAS
			////sac:AdditionalMonetaryTotal
			//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
			//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
			//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1004'));
			//
			////sac:PayableAmount
			//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalGratuito,2, '.', ''));
			//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
			//
			////'cbc:ID','2005' //TOTAL DESCUENTOS
			////sac:AdditionalMonetaryTotal
			//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
			//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
			//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','2005'));
			//
			////sac:PayableAmount
			//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
			//$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
			//
			//
			/////'cbc:ID','1000' //TOTAL EN LETRAS
			////sac:AdditionalProperty
			//$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
			//$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
			//$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1000'));
			//
			////cbc:Value
			//$Value = $domtree->createElement("cbc:Value",$FacturaTotalLetras);
			//$Value = $AdditionalProperty->appendChild($Value);
			//
			//
			//if(!empty($InsFactura->FacLeyenda)){
			//
			//
			/////'cbc:ID','1002' //LEYENDA
			////sac:AdditionalProperty
			//$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
			//$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
			//$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1002'));
			//
			////cbc:Value
			//$Value = $domtree->createElement("cbc:Value",$InsFactura->FacLeyenda);
			//$Value = $AdditionalProperty->appendChild($Value);
			//
			//	
			//}


			//
			////ext:UBLExtension2
			//$UBLExtension2 = $domtree->createElement("ext:UBLExtension");
			//$UBLExtension2 = $UBLExtensions->appendChild($UBLExtension2);
			//
			////sac:ExtensionContent2
			//$ExtensionContent2 = $domtree->createElement("ext:ExtensionContent");
			//$ExtensionContent2 = $UBLExtension2->appendChild($ExtensionContent2);
			//
			//


			//ext:UBLVersionID
			$UBLVersionID = $domtree->createElement("cbc:UBLVersionID", "2.1");
			$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

			//ext:CustomizationID
			$CustomizationID = $domtree->createElement("cbc:CustomizationID", "2.0");
			$CustomizationID = $xmlRoot->appendChild($CustomizationID);

			//cbc:ID
			$ID = $domtree->createElement("cbc:ID", $InsFactura->FtaNumero . "-" . $InsFactura->FacId);
			$ID = $xmlRoot->appendChild($ID);

			//cbc:IssueDate
			$IssueDate = $domtree->createElement("cbc:IssueDate", FncCambiaFechaAMysql($InsFactura->FacFechaEmision));
			$IssueDate = $xmlRoot->appendChild($IssueDate);
			//cbc:IssueTime
			$IssueTime = $domtree->createElement("cbc:IssueTime", ($InsFactura->FacHoraEmision));
			$IssueTime = $xmlRoot->appendChild($IssueTime);

			//cbc:InvoiceTypeCode
			//$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
			//$InvoiceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
			//$InvoiceTypeCode->setAttribute('listName', "SUNAT:Identificador de Tipo de Documento");
			//$InvoiceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
			//$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);

			$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode", "01");
			if ($InsFactura->FacSpot == 1) {
				$InvoiceTypeCode->setAttribute('listID', "1001");
			} elseif ($InsFactura->FacSpot == 2) {
				$InvoiceTypeCode->setAttribute('listID', "0101");
			}

			$InvoiceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
			//$InvoiceTypeCode->setAttribute('listName', "SUNAT:Identificador de Tipo de Documento");
			$InvoiceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
			$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);


			////cbc:ProfileID
			//$ProfileID = $domtree->createElement("cbc:ProfileID","0101");
			//$ProfileID->setAttribute('schemeName', "SUNAT:Identificador de Tipo de Operación");
			//$ProfileID->setAttribute('schemeAgencyName', "PE:SUNAT");
			//$ProfileID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17");
			//$ProfileID = $xmlRoot->appendChild($ProfileID);


			////cbc:InvoiceTypeCode
			//$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
			//$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);


			//cbc:Note
			//$Note = $domtree->createElement("cbc:Note",$domtree->createCDATASection($FacturaTotalLetras));
			$Note = $domtree->createElement("cbc:Note", ($FacturaTotalLetras));
			$Note->setAttribute('languageLocaleID', "1000");
			$Note = $xmlRoot->appendChild($Note);

			//DETRACCION
			if ($InsFactura->FacSpot == 1) {

				$Note = $domtree->createElement("cbc:Note", 'Operacion sujeta a detraccion');
				$Note->setAttribute('languageLocaleID', "2006");
				$Note = $xmlRoot->appendChild($Note);
			} elseif ($InsFactura->FacSpot == 2) {
			}

			////cbc:DocumentCurrencyCode
			//$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsFactura->MonSigla);
			//$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);

			//cbc:DocumentCurrencyCode
			$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode", $InsFactura->MonSigla);
			$DocumentCurrencyCode->setAttribute('listID', "ISO 4217 Alpha");
			$DocumentCurrencyCode->setAttribute('listName', "Currency");
			$DocumentCurrencyCode->setAttribute('listAgencyName', "United Nations Economic Commission for Europe");
			$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);



			/*<cac:DespatchDocumentReference>
	<cbc:ID>0001-0000008</cbc:ID>
	<cbc:DocumentTypeCode listAgencyName="PE:SUNAT" listName="SUNAT:Identificador de guíarelacionada" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01">09</cbc:DocumentTypeCode>
</cac:DespatchDocumentReference>
*/


			if (!empty($InsFactura->FacGuiaRemisionNumero)) {

				//cac:DespatchDocumentReference
				$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
				$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);

				//cbc:ID
				$ID = $domtree->createElement("cbc:ID", $InsFactura->FacGuiaRemisionNumero);
				$ID = $DespatchDocumentReference->appendChild($ID);

				//cbc:DocumentTypeCode
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode", ("09"));
				$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
				$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
				$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
				$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);
			}

			if (!empty($InsFactura->FacGuiaRemisionTransportistaNumero)) {

				//cac:DespatchDocumentReference
				$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
				$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);

				//cbc:ID
				$ID = $domtree->createElement("cbc:ID", $InsFactura->FacGuiaRemisionTransportistaNumero);
				$ID = $DespatchDocumentReference->appendChild($ID);

				//cbc:DocumentTypeCode
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode", ("09"));
				$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
				$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
				$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
				$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);
			}
			//if(!empty($InsFactura->FacGuiaRemisionTransportistaNumero)){
			//	
			//	//cac:DespatchDocumentReference
			//	$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
			//	$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);
			//				
			//		//cbc:ID
			//		$ID = $domtree->createElement("cbc:ID",$InsFactura->FacGuiaRemisionTransportistaNumero);
			//		$ID = $DespatchDocumentReference->appendChild($AdditionalDocumentReference);
			//		
			//		//cbc:DocumentTypeCode
			//		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("99"));
			//		$DocumentTypeCode->setAttribute('listName', "Documento Relacionado");
			//		$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
			//		$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo12");
			//		$DocumentTypeCode = $AdditionalDocumentReference->appendChild($DocumentTypeCode);	
			//		
			//}




			/*
<cac:DespatchDocumentReference> 
<cbc:ID>0001-002020</cbc:ID> 
<cbc:DocumentTypeCode>09</cbc:DocumentTypeCode> 
</cac:DespatchDocumentReference>
*/

			/*<?php echo $InsFactura->GrtNumero;?> - <?php echo $InsFactura->GreId;?>
*/
			//if(!empty($InsFactura->GreId)){
			//	
			//	//cac:DespatchDocumentReference
			//	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
			//	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
			//		
			//		//cbc:ID
			//		$ID = $domtree->createElement("cbc:ID",$InsFactura->GrtNumero."-".$InsFactura->GreId);
			//		$ID = $DespatchDocumentReference->appendChild($ID);
			//		
			//		//cbc:ID
			//		$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","09");
			//		$DocumentTypeCode = $DespatchDocumentReference->appendChild($ID);
			//
			//}



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






			//cac:AccountingSupplierParty
			$AccountingSupplierParty = $domtree->createElement("cac:AccountingSupplierParty");
			$AccountingSupplierParty = $xmlRoot->appendChild($AccountingSupplierParty);

			////cbc:CustomerAssignedAccountID
			//	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$EmpresaCodigo);
			//	$CustomerAssignedAccountID = $AccountingSupplierParty->appendChild($CustomerAssignedAccountID);
			//	
			//	//cbc:AdditionalAccountID
			//	$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","6");
			//	$AdditionalAccountID = $AccountingSupplierParty->appendChild($AdditionalAccountID);

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
			$AddressTypeCode = $domtree->createElement("cbc:AddressTypeCode", $InsFactura->SucCodigoAnexo);
			$AddressTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
			$AddressTypeCode->setAttribute('listName', "Establecimientos anexos");
			$AddressTypeCode = $RegistrationAddress->appendChild($AddressTypeCode);



			/*//cac:PartyTaxScheme
		$PartyTaxScheme = $Party->appendChild($domtree->createElement( 'cac:PartyTaxScheme' ));
		
			//cbc:RegistrationName		
			$RegistrationName = $PartyTaxScheme->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
			
			//cbc:Note
			//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
			$CompanyID = $domtree->createElement("cbc:CompanyID",($EmpresaCodigo));
			$CompanyID->setAttribute('schemeID', "6");
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyTaxScheme->appendChild($CompanyID);	
				
		
				
			//cac:RegistrationAddress
			$RegistrationAddress = $PartyTaxScheme->appendChild($domtree->createElement( 'cac:RegistrationAddress' ));
			
				//cbc:ID		
				$AddressTypeCode = $RegistrationAddress->appendChild($domtree->createElement('cbc:AddressTypeCode',"0000")); 
				//$AddressTypeCode->appendChild($domtree->createCDATASection( "0000")); 
				
			//cac:TaxScheme
			$TaxScheme = $PartyTaxScheme->appendChild($domtree->createElement( 'cac:TaxScheme' ));
			
				//cbc:ID		
				$ID = $TaxScheme->appendChild($domtree->createElement('cbc:ID',"-")); 
				//$ID->appendChild($domtree->createCDATASection( "-")); 
				
				*/




			//	//cac:PostalAddress
			//		$PostalAddress = $domtree->createElement("cac:PostalAddress");
			//		$PostalAddress = $Party->appendChild($PostalAddress);
			//		
			//			//cbc:ID
			//			$ID = $domtree->createElement("cbc:ID","230101");
			//			$ID = $PostalAddress->appendChild($ID);
			//			
			//			//cbc:StreetName
			//			$StreetName = $domtree->createElement("cbc:StreetName",$EmpresaDireccion);
			//			$StreetName = $PostalAddress->appendChild($StreetName);
			//	
			//			//cbc:District
			//			$District = $domtree->createElement("cbc:District",$EmpresaDistrito);
			//			$District = $PostalAddress->appendChild($District);
			//			
			//			//cac:Country
			//			$Country = $domtree->createElement("cac:Country");
			//			$Country = $PostalAddress->appendChild($Country);
			//			
			//			//cbc:IdentificationCode
			//			$IdentificationCode = $domtree->createElement("cbc:IdentificationCode","PE");
			//			$IdentificationCode = $Country->appendChild($IdentificationCode);
			//	
			//		//cac:PartyLegalEntity
			//		$base = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
			//		
			//		//cac:Name		
			//		$name = $base->appendChild($domtree->createElement('cbc:RegistrationName')); 
			//		$name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 


			//cac:AccountingCustomerParty
			$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
			$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);

			//	//cbc:CustomerAssignedAccountID
			//	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsFactura->CliNumeroDocumento);
			//	$CustomerAssignedAccountID = $AccountingCustomerParty->appendChild($CustomerAssignedAccountID);	
			//	
			//	//cbc:AdditionalAccountID
			//	$AdditionalAccountID = $domtree->createElement("cbc:AdditionalAccountID","6");
			//	$AdditionalAccountID = $AccountingCustomerParty->appendChild($AdditionalAccountID);

			//cac:Party
			$Party = $domtree->createElement("cac:Party");
			$Party = $AccountingCustomerParty->appendChild($Party);

			//cac:PartyIdentification
			$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
			$PartyIdentification = $Party->appendChild($PartyIdentification);

			//cbc:Note
			//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($EmpresaCodigo));
			$CompanyID = $domtree->createElement("cbc:ID", ($InsFactura->CliNumeroDocumento));
			$CompanyID->setAttribute('schemeID', round($InsFactura->TdoCodigo));
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyIdentification->appendChild($CompanyID);


			//cac:PartyLegalEntity
			$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
			$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);

			//cbc:RegistrationName		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName'));
			$RegistrationName->appendChild($domtree->createCDATASection(trim($InsFactura->CliNombre . " " . $InsFactura->CliApellidoPaterno . " " . $InsFactura->CliApellidoMaterno)));


			/*
			//cac:PartyTaxScheme
			$PartyTaxScheme = $Party->appendChild($domtree->createElement( 'cac:PartyTaxScheme' ));
			
				//cbc:RegistrationName		
				$RegistrationName = $PartyTaxScheme->appendChild($domtree->createElement('cbc:RegistrationName')); 
				$RegistrationName->appendChild($domtree->createCDATASection( $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno)); 
				
				//cbc:Note
				//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($InsFactura->CliNumeroDocumento));
				$CompanyID = $domtree->createElement("cbc:CompanyID",($InsFactura->CliNumeroDocumento));
				$CompanyID->setAttribute('schemeID', "6");
				$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
				$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
				$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
				$CompanyID = $PartyTaxScheme->appendChild($CompanyID);	
					
				//cac:TaxScheme
				$TaxScheme = $PartyTaxScheme->appendChild($domtree->createElement( 'cac:TaxScheme' ));
				
					//cbc:ID		
					$ID = $TaxScheme->appendChild($domtree->createElement('cbc:ID',"-")); 
					//$ID->appendChild(( "-")); 
					*/


			//DESCUENTO GENERAL	
			if ($InsFactura->FacPorcentajeDescuentoGlobal > 0) {

				$InsFactura->FacPorcentajeDescuentoGlobal = round($InsFactura->FacPorcentajeDescuentoGlobal / 100, 2);

				//cac:LegalMonetaryTotal
				$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
				$AllowanceCharge = $xmlRoot->appendChild($AllowanceCharge);

				//cbc:ChargeIndicator
				$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator", "False");
				$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);

				//cbc:AllowanceChargeReasonCode
				$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode", "00");
				$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);

				//cbc:MultiplierFactorNumeric
				$MultiplierFactorNumeric = $domtree->createElement("cbc:MultiplierFactorNumeric", $InsFactura->FacPorcentajeDescuentoGlobal);
				$MultiplierFactorNumeric = $AllowanceCharge->appendChild($MultiplierFactorNumeric);

				//cbc:Amount
				//TOTAL DESCUENTO GLOBAL (NO ITEMS)
				$Amount = $domtree->createElement("cbc:Amount", number_format($InsFactura->FacTotalDescuentoGlobal, 2, '.', ''));
				$Amount->setAttribute('currencyID', $InsFactura->MonSigla);
				$Amount = $AllowanceCharge->appendChild($Amount);

				//cbc:Amount
				//TOTAL SUMA VALORES DE VENTA
				$BaseAmount = $domtree->createElement("cbc:BaseAmount", number_format($InsFactura->FacTotalGravado, 2, '.', ''));
				$BaseAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);
			}





			//	//cac:DeliveryTerms
			//	$DeliveryTerms = $domtree->createElement("cac:DeliveryTerms");
			//	$DeliveryTerms = $xmlRoot->appendChild($DeliveryTerms);
			//	
			//		//cac:DeliveryLocation
			//		$DeliveryLocation = $domtree->createElement("cac:DeliveryLocation");
			//		$DeliveryLocation = $DeliveryTerms->appendChild($DeliveryLocation);
			//		
			//			//cac:Address
			//			$Address = $domtree->createElement("cac:Address");
			//			$Address = $DeliveryLocation->appendChild($Address);
			//						
			//				//cbc:StreetName		
			//				$StreetName = $Address->appendChild($domtree->createElement('cbc:StreetName')); 
			//				$StreetName->appendChild($domtree->createCDATASection( $InsFactura->CliDireccion )); 
			////				
			//
			//				//cbc:IdentificationCode
			//				$IdentificationCode = $domtree->createElement("cbc:IdentificationCode","PE");
			//				$IdentificationCode->setAttribute('listID', "ISO 3166-1");
			//				$IdentificationCode->setAttribute('listAgencyName', "United Nations Economic
			//Commission for Europe");
			//				$IdentificationCode->setAttribute('listName', "Country");
			//				$IdentificationCode = $Address->appendChild($IdentificationCode);
			//				


			//		//cac:PhysicalLocation
			//		$PhysicalLocation = $Party->appendChild($domtree->createElement( 'cac:PhysicalLocation' ));
			//		
			//		//cac:Name		
			//		$Description = $PhysicalLocation->appendChild($domtree->createElement('cbc:Description')); 
			//		$Description->appendChild($domtree->createCDATASection( $InsFactura->CliDireccion )); 
			//			
			//		//cac:PartyLegalEntity
			//		$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
			//		
			//		//cac:Name		
			//		$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
			//		$RegistrationName->appendChild($domtree->createCDATASection( $InsFactura->CliNombre." ".$InsFactura->CliApellidoPaterno." ".$InsFactura->CliApellidoMaterno ));

			//DETALLES DE LA DETRACCION
			$DetraccionTotal = 0;
			if ($InsFactura->FacSpot == 1) {


				$PaymentMeans = $domtree->createElement("cac:PaymentMeans");
				$PaymentMeans = $xmlRoot->appendChild($PaymentMeans);

				$ID = $PaymentMeans->appendChild($domtree->createElement('cbc:ID', 'Detraccion'));
				$ID = $PaymentMeans->appendChild($ID);

				$PaymentMeansCode = $PaymentMeans->appendChild($domtree->createElement('cbc:PaymentMeansCode', '001'));
				$PaymentMeansCode = $PaymentMeans->appendChild($PaymentMeansCode);

				$PayeeFinancialAccount = $domtree->createElement('cac:PayeeFinancialAccount');
				$PayeeFinancialAccount = $PaymentMeans->appendChild($PayeeFinancialAccount);

				$ID = $domtree->createElement("cbc:ID", '00101135748');
				$ID = $PayeeFinancialAccount->appendChild($ID);


				$PaymentTerms = $domtree->createElement("cac:PaymentTerms");
				$PaymentTerms = $xmlRoot->appendChild($PaymentTerms);

				$ID = $PaymentTerms->appendChild($domtree->createElement('cbc:ID', 'Detraccion'));
				$ID = $PaymentTerms->appendChild($ID);

				$PaymentMeansID = $PaymentTerms->appendChild($domtree->createElement('cbc:PaymentMeansID', '020'));
				$PaymentMeansID = $PaymentTerms->appendChild($PaymentMeansID);

				$PaymentPercent = $PaymentTerms->appendChild($domtree->createElement('cbc:PaymentPercent', '12'));
				$PaymentPercent = $PaymentTerms->appendChild($PaymentPercent);

				$DetraccionTotal = ($InsFactura->FacTotal) * 0.12;
				//USAR SOLO CUANDO SEA EN DOLARES
				$DetraccionTotal = $DetraccionTotal * 3.790;
				$DetraccionTotal = round($DetraccionTotal);

				$Amount = $domtree->createElement("cbc:Amount", number_format($DetraccionTotal, 2, '.', ''));
				$Amount->setAttribute('currencyID', 'PEN');
				$Amount = $PaymentTerms->appendChild($Amount);
			} elseif ($InsFactura->FacSpot == 2) {
			}



			/*
				FORMA DE PAGO
				*/

			/*
			
			
			http://190.119.207.171:81/siscisne/formularios/Boleta/acc/AccBoletaGenerarXMLv4.php?BolId=000020&BtaId=BTA-10003
			
			<cac:PaymentTerms>
      <cbc:ID>FormaPago</cbc:ID>
      <cbc:PaymentMeansID>Contado</cbc:PaymentMeansID>
   </cac:PaymentTerms>
   
			*/

			if ($InsFactura->NpaId == 'NPA-10000') {

				//cac:PaymentTerms
				$PaymentTerms = $domtree->createElement("cac:PaymentTerms");
				$PaymentTerms = $xmlRoot->appendChild($PaymentTerms);

				//cbc:RegistrationName		
				$ID = $PaymentTerms->appendChild($domtree->createElement('cbc:ID'));
				$ID->appendChild($domtree->createCDATASection("FormaPago"));

				//cbc:RegistrationName		
				$PaymentMeansID = $PaymentTerms->appendChild($domtree->createElement('cbc:PaymentMeansID'));
				$PaymentMeansID->appendChild($domtree->createCDATASection("Contado"));
			} elseif ($InsFactura->NpaId == 'NPA-10001') {
				//cac:PaymentTerms
				$PaymentTerms = $domtree->createElement("cac:PaymentTerms");
				$PaymentTerms = $xmlRoot->appendChild($PaymentTerms);

				//cbc:ID	
				$ID = $PaymentTerms->appendChild($domtree->createElement('cbc:ID'));
				$ID->appendChild($domtree->createCDATASection("FormaPago"));

				//cbc:PaymentMeansID	
				$PaymentMeansID = $PaymentTerms->appendChild($domtree->createElement('cbc:PaymentMeansID'));
				$PaymentMeansID->appendChild($domtree->createCDATASection("Credito"));

				//cbc:Amount
				$MontoCredito = ($InsFactura->FacTotal) - ($DetraccionTotal / 3.790);
				$Amount = $domtree->createElement("cbc:Amount", number_format($MontoCredito, 2, '.', ''));
				$Amount->setAttribute('currencyID', $InsFactura->MonSigla);
				$Amount = $PaymentTerms->appendChild($Amount);


				//cac:PaymentTerms
				$PaymentTerms2 = $domtree->createElement("cac:PaymentTerms");
				$PaymentTerms2 = $xmlRoot->appendChild($PaymentTerms2);

				//cbc:ID	
				$ID2 = $PaymentTerms2->appendChild($domtree->createElement('cbc:ID'));
				$ID2->appendChild($domtree->createCDATASection("FormaPago"));

				//cbc:PaymentMeansID	
				$PaymentMeansID2 = $PaymentTerms2->appendChild($domtree->createElement('cbc:PaymentMeansID'));
				$PaymentMeansID2->appendChild($domtree->createCDATASection("Cuota001"));

				//cbc:Amount
				$Amount2 = $domtree->createElement("cbc:Amount", number_format($MontoCredito, 2, '.', ''));
				$Amount2->setAttribute('currencyID', $InsFactura->MonSigla);
				$Amount2 = $PaymentTerms2->appendChild($Amount2);

				//cbc:PaymentDueDate
				$PaymentDueDate2 = $PaymentTerms2->appendChild($domtree->createElement('cbc:PaymentDueDate'));
				$PaymentDueDate2->appendChild($domtree->createCDATASection($InsFactura->FacFechaVencimiento2));
			}



			//cac:TaxTotal
			$TaxTotal = $domtree->createElement("cac:TaxTotal");
			$TaxTotal = $xmlRoot->appendChild($TaxTotal);

			//cbc:TaxAmount
			//SUMA TOTAL IGV
			$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($InsFactura->FacImpuesto, 2, '.', ''));
			$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$TaxAmount = $TaxTotal->appendChild($TaxAmount);

			//cac:TaxSubtotal
			$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
			$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

			//cbc:TaxableAmount 
			//SUMA TOTAL GRAVADOS
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($InsFactura->FacTotalGravado, 2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($InsFactura->FacImpuesto, 2, '.', ''));
			$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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



			if ($InsFactura->FacTotalExonerado > 0) {

				//SUMA TOTAL EXONERADOS
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

				//cbc:TaxableAmount 
				$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($InsFactura->FacTotalExonerado, 2, '.', ''));
				$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

				//cbc:TaxAmount 
				$TaxAmount = $domtree->createElement("cbc:TaxAmount", "0.00");
				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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



			if ($InsFactura->FacTotalGratuito > 0) {

				//SUMA TOTAL INAFECTO (GRATUITO)
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

				//cbc:TaxableAmount 
				$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($InsFactura->FacTotalGratuito, 2, '.', ''));
				$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

				//cbc:TaxAmount 
				$TaxAmount = $domtree->createElement("cbc:TaxAmount", "0.00");
				$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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




			//
			//				//cbc:ID
			//				$ID = $domtree->createElement("cbc:ID","1000");
			//				$ID = $TaxScheme->appendChild($ID);
			//				






			//
			//
			//	
			//	
			//	////cbc:TaxInclusiveAmount
			////	$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount",number_format($InsFactura->FacSubTotal,2, '.', ''));
			////	$TaxInclusiveAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			////	$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);
			//
			//	//cbc:AllowanceTotalAmount currencyID="PEN"
			//	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
			//	$AllowanceTotalAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			//	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
			//	
			//	//cbc:PayableAmount currencyID="PEN"
			//	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsFactura->FacTotalPagar,2, '.', ''));
			//	$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			//	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
			//	


			//cac:LegalMonetaryTotal
			$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
			$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

			//cbc:LineExtensionAmount
			$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount", number_format($InsFactura->FacSubTotal, 2, '.', ''));
			$LineExtensionAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$LineExtensionAmount = $LegalMonetaryTotal->appendChild($LineExtensionAmount);

			//cbc:TaxInclusiveAmount
			////SUMA TOTAL DE LA VENTA - OTROS CARGOS
			$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount", number_format($InsFactura->FacTotal, 2, '.', ''));
			$TaxInclusiveAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);

			//cbc:AllowanceTotalAmount 
			//SUMA TOTAL DESCUENTOS GENERAL + ITEMS
			// $AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsFactura->FacTotalDescuento,2, '.', ''));
			// $AllowanceTotalAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			// $AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);

			if ($InsFactura->FacTotalOtrosCargos > 0) {

				//cbc:ChargeTotalAmount 
				//SUMA TOTAL OTROS CARGOS
				$ChargeTotalAmount = $domtree->createElement("cbc:ChargeTotalAmount", number_format($InsFactura->FacTotalOtrosCargos, 2, '.', ''));
				$ChargeTotalAmount->setAttribute('currencyID', $InsFactura->MonSigla);
				$ChargeTotalAmount = $LegalMonetaryTotal->appendChild($ChargeTotalAmount);
			}

			//cbc:PayableAmount currencyID="PEN"
			//SUMA TOTAL DE LA VENTA
			$PayableAmount = $domtree->createElement("cbc:PayableAmount", number_format($InsFactura->FacTotal, 2, '.', ''));
			$PayableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
			$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);

			$fila = 1;
			if (!empty($InsFactura->FacturaDetalle)) {
				foreach ($InsFactura->FacturaDetalle as $DatFacturaDetalle) {

					$DatFacturaDetalle->FdeDescripcion  = trim($DatFacturaDetalle->FdeDescripcion);

					if ($InsFactura->MonId <> $EmpresaMonedaId) {

						$DatFacturaDetalle->FdeImporte = ($DatFacturaDetalle->FdeImporte / $InsFactura->FacTipoCambio);
						$DatFacturaDetalle->FdePrecio = ($DatFacturaDetalle->FdePrecio  / $InsFactura->FacTipoCambio);
						$DatFacturaDetalle->FdeValorVenta = ($DatFacturaDetalle->FdeValorVenta  / $InsFactura->FacTipoCambio);
						$DatFacturaDetalle->FdeValorVentaUnitario = ($DatFacturaDetalle->FdeValorVentaUnitario  / $InsFactura->FacTipoCambio);

						$DatFacturaDetalle->FdeImpuesto = ($DatFacturaDetalle->FdeImpuesto  / $InsFactura->FacTipoCambio);
						$DatFacturaDetalle->FdeValorVentaBruto = ($DatFacturaDetalle->FdeValorVentaBruto  / $InsFactura->FacTipoCambio);
					}

					//cac:InvoiceLine
					$InvoiceLine = $domtree->createElement("cac:InvoiceLine");
					$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);

					//cbc:ID
					$ID = $domtree->createElement("cbc:ID", $fila);
					$ID = $InvoiceLine->appendChild($ID);

					//cbc:InvoicedQuantity unitCode="NIU"
					$InvoicedQuantity = $domtree->createElement("cbc:InvoicedQuantity", number_format($DatFacturaDetalle->FdeCantidad, 2, '.', ''));

					//if($DatFacturaDetalle->FdeValidarStock==2){
					//				$InvoicedQuantity->setAttribute('unitCode', 'ZZ');
					//			}else{
					//				$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
					//			}

					switch ($DatFacturaDetalle->FdeTipo) {

						case "R":
							$InvoicedQuantity->setAttribute('unitCode', 'NIU');
							break;

						case "S":
							$InvoicedQuantity->setAttribute('unitCode', 'ZZ');
							break;

						case "M":
							$InvoicedQuantity->setAttribute('unitCode', 'NIU');
							break;

						case "T":
							$InvoicedQuantity->setAttribute('unitCode', 'NIU');
							break;

						default:
							$InvoicedQuantity->setAttribute('unitCode', 'NIU');
							break;
					}




					$InvoicedQuantity->setAttribute('unitCodeListID', 'UN/ECE rec 20');
					$InvoicedQuantity->setAttribute('unitCodeListAgencyName', 'Europe');
					$InvoicedQuantity = $InvoiceLine->appendChild($InvoicedQuantity);


					//cbc:LineExtensionAmount currencyID="PEN"
					$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount", number_format($DatFacturaDetalle->FdeValorVenta, 2, '.', ''));
					$LineExtensionAmount->setAttribute('currencyID', $InsFactura->MonSigla);
					$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);

					//cac:PricingReference
					$PricingReference = $domtree->createElement("cac:PricingReference");
					$PricingReference = $InvoiceLine->appendChild($PricingReference);


					//VALOR REFERENCIAL UNITARIO POR ITEM EN OPERACIONES NO ONEROSAS

					if ($DatFacturaDetalle->FdeGratuito == 1) {

						//cac:AlternativeConditionPrice
						$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
						$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);

						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", number_format($DatFacturaDetalle->FdeValorVentaUnitario, 2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);

						//cbc:PriceTypeCode
						$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode", "02");
						$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
						$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
						$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
						$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
					} else if ($DatFacturaDetalle->FdeGratuito == 2) {

						//cac:AlternativeConditionPrice
						$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
						$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);

						//cbc:PriceAmount currencyID="PEN"
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", number_format($DatFacturaDetalle->FdePrecio, 2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);

						//cbc:PriceTypeCode
						$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode", "01");
						$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
						$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
						$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
						$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
					}

					//DESCUENTOS POR ITEM	

					if ($DatFacturaDetalle->FdeDescuento > 0) {

						$DatFacturaDetalle->FdePorcentajeDescuento = round($DatFacturaDetalle->FdePorcentajeDescuento / 100, 2);

						//cac:AllowanceCharge
						$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
						$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);

						//cbc:ChargeIndicator
						$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator", "false");
						$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);

						//cbc:AllowanceChargeReasonCode
						$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode", "00"); //X
						$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);

						////cbc:MultiplierFactorNumeric
						//					$MultiplierFactorNumeric = $domtree->createElement("cbc:MultiplierFactorNumeric",$DatFacturaDetalle->FdePorcentajeDescuento);//X
						//					$MultiplierFactorNumeric = $AllowanceCharge->appendChild($MultiplierFactorNumeric);

						//cbc:Amount
						$Amount = $domtree->createElement("cbc:Amount", number_format($DatFacturaDetalle->FdeDescuento, 2, '.', ''));
						$Amount->setAttribute('currencyID', $InsFactura->MonSigla);
						$Amount = $AllowanceCharge->appendChild($Amount);

						//cbc:BaseAmount
						$BaseAmount = $domtree->createElement("cbc:BaseAmount", number_format($DatFacturaDetalle->FdeValorVentaBruto, 2, '.', ''));
						$BaseAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);
					}

					//OTROS CARGOS POR ITEM	
					// NO SE USA
					if ($DatFacturaDetalle->FdeOtroCargo > 0) {

						$DatFacturaDetalle->FdePorcentajeOtroCargo = round($DatFacturaDetalle->FdePorcentajeOtroCargo / 100, 2);

						//cac:AllowanceCharge
						$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
						$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);

						//cbc:ChargeIndicator
						$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator", "true");
						$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);

						//cbc:AllowanceChargeReasonCode
						$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode", "5"); //X
						$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);

						////cbc:MultiplierFactorNumeric
						//					$MultiplierFactorNumeric = $domtree->createElement("cbc:MultiplierFactorNumeric",$DatFacturaDetalle->FdePorcentajeDescuento);//X
						//					$MultiplierFactorNumeric = $AllowanceCharge->appendChild($MultiplierFactorNumeric);

						//cbc:Amount
						$Amount = $domtree->createElement("cbc:Amount", $DatFacturaDetalle->FdeOtroCargo);
						$Amount->setAttribute('currencyID', $InsFactura->MonSigla);
						$Amount = $AllowanceCharge->appendChild($Amount);

						//cbc:BaseAmount
						$BaseAmount = $domtree->createElement("cbc:BaseAmount", $InsFacturaDetalle1->FdeValorVentaBruto); //REVISAR ESTE MONTO
						$BaseAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);
					}










					//cac:TaxTotal
					$TaxTotal = $domtree->createElement("cac:TaxTotal");
					$TaxTotal = $InvoiceLine->appendChild($TaxTotal);


					if ($DatFacturaDetalle->FdeExonerado == "1") {

						//cbc:TaxAmount
						$TaxAmount = $domtree->createElement("cbc:TaxAmount", "0.00");
						$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$TaxAmount = $TaxTotal->appendChild($TaxAmount);

						//cac:TaxSubtotal
						$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
						$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

						//cbc:TaxableAmount 
						$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", "0.00");
						$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);

						//cbc:TaxAmount 


						$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatFacturaDetalle->FdeValorVenta, 2, '.', ''));
						$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
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
						$Percent = $domtree->createElement("cbc:Percent", $InsFactura->FacPorcentajeImpuestoVenta);
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
					} else if ($DatFacturaDetalle->FdeExonerado == "2") {

						if ($DatFacturaDetalle->FdeGratuito == "1") {

							//cbc:TaxAmount
							$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatFacturaDetalle->FdeValorVenta * ($InsFactura->FacPorcentajeImpuestoVenta / 100), 2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
							$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						} else {
							//cbc:TaxAmount
							$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatFacturaDetalle->FdeImpuesto, 2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
							$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						}

						//cac:TaxSubtotal
						$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
						$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);

						//cbc:TaxableAmount 
						$TaxableAmount = $domtree->createElement("cbc:TaxableAmount", number_format($DatFacturaDetalle->FdeValorVenta, 2, '.', ''));
						$TaxableAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);


						if ($DatFacturaDetalle->FdeGratuito == "1") {

							$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatFacturaDetalle->FdeValorVenta * ($InsFactura->FacPorcentajeImpuestoVenta / 100), 2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
						} else {
							//cbc:TaxAmount 
							$TaxAmount = $domtree->createElement("cbc:TaxAmount", number_format($DatFacturaDetalle->FdeImpuesto, 2, '.', ''));
							$TaxAmount->setAttribute('currencyID', $InsFactura->MonSigla);
							$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
						}


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
						$Percent = $domtree->createElement("cbc:Percent", $InsFactura->FacPorcentajeImpuestoVenta);
						$Percent = $TaxCategory->appendChild($Percent);


						if ($DatFacturaDetalle->FdeGratuito == "1") {

							//cbc:TaxExemptionReasonCode 
							$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode", "15");
							$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
							$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
							$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
							$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);

							//cac:TaxScheme
							$TaxScheme = $domtree->createElement("cac:TaxScheme");
							$TaxScheme = $TaxCategory->appendChild($TaxScheme);

							//cbc:TaxAmount 
							$ID = $domtree->createElement("cbc:ID", "9996");
							$ID->setAttribute('schemeID', "UN/ECE 5153");
							$ID->setAttribute('schemeName', "Tax Scheme Identifier");
							$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
							$ID = $TaxScheme->appendChild($ID);

							//cbc:Name
							$Name = $domtree->createElement("cbc:Name", "GRA");
							$Name = $TaxScheme->appendChild($Name);

							//cbc:TaxTypeCode
							$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode", "FRE");
							$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
						} else {


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
						}
					} else {
					}



					//cac:Item
					$Item = $domtree->createElement("cac:Item");
					$Item = $InvoiceLine->appendChild($Item);



					if (!empty($InsFactura->OvvId)) {

						if (!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)) {

							$DatFacturaDetalle->FdeDescripcion .= "( ";
						}

						if (!empty($InsFactura->FacDatoAdicional13)) {

							$DatFacturaDetalle->FdeDescripcion .= "Nro. VIN o CHASIS: " . $InsFactura->FacDatoAdicional13 . ", ";
						}

						if (!empty($InsFactura->FacDatoAdicional7)) {

							$DatFacturaDetalle->FdeDescripcion .= "Nro. Motor: " . $InsFactura->FacDatoAdicional7 . ", ";
						}

						if (!empty($InsFactura->FacDatoAdicional1)) {

							$DatFacturaDetalle->FdeDescripcion .= "Marca: " . $InsFactura->FacDatoAdicional1 . " ";
						}

						if (!empty($InsFactura->FacDatoAdicional13) or !empty($InsFactura->FacDatoAdicional7) or !empty($InsFactura->FacDatoAdicional1)) {

							$DatFacturaDetalle->FdeDescripcion .= " )";
						}
					}


					//cac:PartyName
					$Description = $domtree->createElement("cbc:Description");
					$Description = $Item->appendChild($Description);

					$Description->appendChild($domtree->createCDATASection($DatFacturaDetalle->FdeDescripcion));



					//cac:SellersItemIdentification		
					$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
					$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatFacturaDetalle->FdeCodigo));

					if (!empty($DatFacturaDetalle->FdeCodigoGeneral)) {

						//cac:CommodityClassification		
						$CommodityClassification = $domtree->createElement("cac:CommodityClassification");
						$CommodityClassification = $Item->appendChild($CommodityClassification);

						//cbc:PriceAmount currencyID="PEN"
						$ItemClassificationCode = $domtree->createElement("cbc:ItemClassificationCode", $DatFacturaDetalle->FdeCodigoGeneral);
						$ItemClassificationCode->setAttribute('listID', "UNSPSC");
						$ItemClassificationCode->setAttribute('listAgencyName', "GS1 US");
						$ItemClassificationCode->setAttribute('listName', "Item Classification");
						$ItemClassificationCode = $CommodityClassification->appendChild($ItemClassificationCode);
					}


					//cac:Price
					$Price = $domtree->createElement("cac:Price");
					$Price = $InvoiceLine->appendChild($Price);

					if ($DatFacturaDetalle->FdeGratuito == "1") {

						//cbc:PriceAmount 
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", "0.00");
						$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);
					} elseif ($DatFacturaDetalle->FdeGratuito == "2") {

						//cbc:PriceAmount
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", number_format($DatFacturaDetalle->FdeValorVentaUnitario, 2, '.', ''));
						$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);
					} else {

						//cbc:PriceAmount
						$PriceAmount = $domtree->createElement("cbc:PriceAmount", "0.00");
						$PriceAmount->setAttribute('currencyID', $InsFactura->MonSigla);
						$PriceAmount = $Price->appendChild($PriceAmount);
					}



					if ($fila == 1) {


						//cac:InvoiceLine
						//$InvoiceLineEspecial = $domtree->createElement("cac:InvoiceLine");
						//$InvoiceLineEspecial = $xmlRoot->appendChild($InvoiceLineEspecial);	

						//cac:ItemEspecial
						//$ItemEspecial = $domtree->createElement("cac:Item");
						//$ItemEspecial = $InvoiceLineEspecial->appendChild($Item);	



						if (!empty($InsFactura->EinPlaca)) {

							//cac:AdditionalProperty
							$AdditionalProperty = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalProperty->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Numero de Placa'));

							//cac:Name		
							$Value = $AdditionalProperty->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->EinPlaca));
						}

						if (!empty($InsFactura->FinLicenciaCategoria)) {

							//cac:AdditionalItemProperty2
							$AdditionalItemProperty2 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Categoria'));

							//cac:Name		
							$Value = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FinLicenciaCategoria));
						}

						if (!empty($InsFactura->FacDatoAdicional1)) {

							//cac:AdditionalItemProperty5
							$AdditionalItemProperty5 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Marca'));

							//cac:Name		
							$Value = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional1));
						} else if (!empty($InsFactura->VmaNombre)) {

							//cac:AdditionalItemProperty3
							$AdditionalItemProperty3 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Marca'));

							//cac:Name		
							$Value = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->VmaNombre));
						}

						if (!empty($InsFactura->FacDatoAdicional3)) {

							//cac:AdditionalItemProperty6
							$AdditionalItemProperty6 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Modelo'));

							//cac:Name		
							$Value = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional3));
						} else if (!empty($InsFactura->VmoNombre)) {


							//cac:AdditionalItemProperty4
							$AdditionalItemProperty4 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Modelo'));

							//cac:Name		
							$Value = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->VmoNombre));
						}


						if (!empty($InsFactura->FacDatoAdicional15)) {


							//cac:AdditionalItemProperty7
							$AdditionalItemProperty7 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Color'));

							//cac:Name		
							$Value = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional15));
						}



						if (!empty($InsFactura->FacDatoAdicional7)) {

							//cac:AdditionalItemProperty71
							$AdditionalItemProperty71 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Motor'));

							//cac:Name		
							$Value = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional7));
						}

						//InsFacturaDatoAdicional8
						if (!empty($InsFactura->FacDatoAdicional8)) {


							//cac:AdditionalItemProperty8
							$AdditionalItemProperty8 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Combustible'));

							//cac:Name		
							$Value = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional8));
						}

						if (!empty($InsFactura->FacDatoAdicional888888)) {	//REVISAR

							//cac:AdditionalItemProperty9
							$AdditionalItemProperty9 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Form. Rodante'));

							//cac:Name		
							$Value = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional888888));
						}


						if (!empty($InsFactura->FacDatoAdicional13)) {

							//cac:AdditionalItemProperty10
							$AdditionalItemProperty10 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('VIN'));

							//cac:Name		
							$Value = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional13));
						}

						if (!empty($InsFactura->FacDatoAdicional13)) {

							//cac:AdditionalItemProperty101
							$AdditionalItemProperty101 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Serie/Chasis'));

							//cac:Name		
							$Value = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional13));
						}


						//if(!empty($InsFactura->FacDatoAdicional5)){	
						//				
						//							
						//							//cac:AdditionalItemProperty102
						//							$AdditionalItemProperty102 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
						//							
						//							//cac:Name		
						//							$Name = $AdditionalItemProperty102->appendChild($domtree->createElement('cbc:Name')); 
						//							$Name->appendChild($domtree->createCDATASection( 'Año de Fabricacion')); 
						//							
						//							//cac:Name		
						//							$Value = $AdditionalItemProperty102->appendChild($domtree->createElement('cbc:Value')); 
						//							$Value->appendChild($domtree->createCDATASection( $InsFactura->FacDatoAdicional5)); 
						//							
						//						}

						if (!empty($InsFactura->FacDatoAdicional27)) {	//REVISAR

							//cac:AdditionalItemProperty103
							$AdditionalItemProperty103 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Año Modelo'));

							//cac:Name		
							$Value = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional27));
						}


						if (!empty($InsFactura->FacDatoAdicional5555555555)) {	//REVISAR

							//cac:AdditionalItemProperty104
							$AdditionalItemProperty104 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Version'));

							//cac:Name		
							$Value = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional5555555555));
						}

						if (!empty($InsFactura->FacDatoAdicional11)) {


							//cac:AdditionalItemProperty11
							$AdditionalItemProperty11 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Ejes'));

							//cac:Name		
							$Value = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection(str_pad($InsFactura->FacDatoAdicional11, 2, "0", STR_PAD_LEFT)));
						}

						if (!empty($InsFactura->FacDatoAdicional19)) {

							//cac:AdditionalItemProperty12
							$AdditionalItemProperty12 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Asientos'));

							//cac:Name		
							$Value = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection(str_pad($InsFactura->FacDatoAdicional19, 4, "0", STR_PAD_LEFT)));
						}


						if (!empty($InsFactura->FacDatoAdicional21)) {


							//cac:AdditionalItemProperty13
							$AdditionalItemProperty13 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Pasajeros'));

							//cac:Name		
							$Value = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection(str_pad($InsFactura->FacDatoAdicional21, 4, "0", STR_PAD_LEFT)));
						}

						if (!empty($InsFactura->FacDatoAdicional24)) {

							//cac:AdditionalItemProperty14
							$AdditionalItemProperty14 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Ruedas'));

							//cac:Name		
							$Value = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection(str_pad($InsFactura->FacDatoAdicional24, 2, "0", STR_PAD_LEFT)));
						}


						if (!empty($InsFactura->FacDatoAdicional4)) {


							//cac:AdditionalItemProperty15
							$AdditionalItemProperty15 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Carroceria'));

							//cac:Name		
							$Value = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacDatoAdicional4));
						}


						if (!empty($InsFactura->FacturaDatoAdicional25)) {



							//cac:AdditionalItemProperty16
							$AdditionalItemProperty16 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Potencia'));

							//cac:Name		
							$Value = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($InsFactura->FacturaDatoAdicional25));
						}


						if (!empty($InsFactura->FacDatoAdicional9)) {


							//cac:AdditionalItemProperty17
							$AdditionalItemProperty17 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Cilindros'));

							//cac:Name		
							$Value = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection(str_pad($InsFactura->FacDatoAdicional9, 2, "0", STR_PAD_LEFT)));
						}


						if (!empty($InsFactura->FacDatoAdicional17)) {



							//cac:AdditionalItemProperty18
							$AdditionalItemProperty18 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Cilindrada'));

							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional17);
							$NuevoValor = round($NuevoValor / 1000, 3);
							//cac:Name		
							$Value = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($NuevoValor));
						}

						if (!empty($InsFactura->FacDatoAdicional10)) {


							//cac:AdditionalItemProperty19
							$AdditionalItemProperty19 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Peso Bruto'));

							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional10);
							$NuevoValor = round($NuevoValor / 1000, 3);

							//cac:Name		
							$Value = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($NuevoValor));
						}


						if (!empty($InsFactura->FacDatoAdicional14)) {

							//cac:AdditionalItemProperty20
							$AdditionalItemProperty20 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Peso Neto'));

							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional14);
							$NuevoValor = round($NuevoValor / 1000, 3);

							//cac:Name		
							$Value = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($NuevoValor));
						}



						if (!empty($InsFactura->FacDatoAdicional12)) {


							//cac:AdditionalItemProperty21
							$AdditionalItemProperty21 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Carga Util'));

							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional12);
							$NuevoValor = round($NuevoValor / 1000, 3);

							//cac:Name		
							$Value = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($NuevoValor));
						}

						if (!empty($InsFactura->FacDatoAdicional18)) {

							//cac:AdditionalItemProperty22
							$AdditionalItemProperty22 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Longitud'));

							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional18);
							$NuevoValor = round($NuevoValor / 1000, 3);

							//cac:Name		
							$Value = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($NuevoValor));
						}


						if (!empty($InsFactura->FacDatoAdicional16)) {


							//cac:AdditionalItemProperty23
							$AdditionalItemProperty23 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Altura'));

							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional16);
							$NuevoValor = round($NuevoValor / 1000, 3);

							//cac:Name		
							$Value = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($NuevoValor));
						}


						if (!empty($InsFactura->FacDatoAdicional20)) {

							//cac:AdditionalItemProperty24
							$AdditionalItemProperty24 = $Item->appendChild($domtree->createElement('cac:AdditionalItemProperty'));

							//cac:Name		
							$Name = $AdditionalItemProperty24->appendChild($domtree->createElement('cbc:Name'));
							$Name->appendChild($domtree->createCDATASection('Ancho'));

							$NuevoValor = FncSoloNumeros($InsFactura->FacDatoAdicional20);
							$NuevoValor = round($NuevoValor / 1000, 3);

							//cac:Name		
							$Value = $AdditionalItemProperty24->appendChild($domtree->createElement('cbc:Value'));
							$Value->appendChild($domtree->createCDATASection($NuevoValor));
						}
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
