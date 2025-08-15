<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsBoleta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsBoleta {

    public $BolId;
	public $BtaId;
    public $UsuId;	

	public $CliId;	

	public $NpaId;
	
	public $AmoId;
	public $OvvId;
	
	public $MonId;
	public $BolTipoCambio;
	
	public $BolCancelado;
	
	public $BolCantidadDia;
	public $BolObsequio;
	public $BolEstado;
	public $BolFechaEmision;
	public $BolPorcentajeImpuestoVenta;
	public $BolDireccion;
	
	public $BolTotalBruto;
	public $BolDescuento;
	public $BolTotal;	
	public $BolTotalReal;	
	
	public $BolObservacion;
	public $BolObservacionImpresa;
	public $BolCierre;
	
	public $RegId;
	public $BolRegimenPorcentaje;
	public $BolRegimenMonto;
	public $BolRegimenComprobanteNumero;
	public $BolRegimenComprobanteFecha;
	
	public $BolSunatRespuestaTicket;
	public $BolSunatRespuestaFecha;
	public $BolSunatRespuestaHora;
	public $BolSunatRespuestaCodigo;
	public $BolSunatRespuestaContenido;
	public $BolSunatRespuestaObservacion;
	public $BolSunatRespuestaTicketEstado;
	
	
    public $BolTiempoCreacion;
    public $BolTiempoModificacion;
    public $BolEliminado;
	
	public $BolTotalItems;
	public $BoletaDetalle;

		
	public $NpaNombre;
	
	public $BtaNumero;
	
	public $RegAplicacion;
	public $RegNombre;

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
	

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}

	public function MtdGenerarBoletaId() {

//MAX(CONVERT(SUBSTR(bol.BolId,5),unsigned)) AS "MAXIMO",
		$sql = 'SELECT	
		MAX(SUBSTR(bol.BolId,1)) AS "MAXIMO",
		bta.BtaInicio
		FROM tblbolboleta bol 
		LEFT JOIN tblbtaboletatalonario bta
		ON bol.BtaId = bta.BtaId 
		WHERE bta.BtaId = "'.$this->BtaId.'"';			

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){	
			if(empty($fila['BtaInicio'])){
				$this->BolId = "000001";
			}else{
				$this->BolId = str_pad($fila['BtaInicio'], 6, "0", STR_PAD_LEFT);
			}
		}else{
			$fila['MAXIMO']++;
			$this->BolId = str_pad($fila['MAXIMO'], 6, "0", STR_PAD_LEFT);	
		}


	}


	//public function MtdGenerarBoletaBajaId() {
//
//		$sql = 'SELECT	
//		MAX(bol.BolSunatRespuestaBajaId) AS "MAXIMO"
//		FROM tblbolboleta bol ';			
//
//		$resultado = $this->InsMysql->MtdConsultar($sql);                       
//		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//		
//		if(empty($fila['MAXIMO'])){	
//			$this->BolSunatRespuestaBajaId = "1";			
//		}else{
//			$fila['MAXIMO']++;
//			$this->BolSunatRespuestaBajaId = ($fila['MAXIMO']);	
//		}
//			
//	}
		
		
		
	public function MtdGenerarBoletaBajaId() {

		$sql = 'SELECT	
	
		
		MAX(CONVERT(bol.BolSunatRespuestaBajaId,unsigned)) AS "MAXIMO"
		FROM tblbolboleta bol ';			

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){	
			$this->BolSunatRespuestaBajaId = "1";			
		}else{
			$fila['MAXIMO']++;
			$this->BolSunatRespuestaBajaId = ($fila['MAXIMO']);	
		}
			
	}
	
	
    public function MtdObtenerBoleta($oCompleto=true){


		$sql = 'SELECT 
				bol.BolId,
				bol.BtaId,
				bol.SucId,
				
				bol.UsuId,
				bol.CliId,
				
				bol.NpaId,
				
				bol.AmoId,
				bol.OvvId,
				
				
				bol.PagId,
						
				CASE
				WHEN EXISTS (
					SELECT ncr.NcrId
						FROM tblncrnotacredito ncr
								WHERE ncr.BolId = bol.BolId 
									AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
									/*AND ncr.FacId IS NULL 
									AND ncr.FtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaCredito,	
				
				CASE
				WHEN EXISTS (
					SELECT ndb.NdbId
						FROM tblndbnotadebito ndb
								WHERE ndb.BolId = bol.BolId 
									AND ndb.BtaId = bol.BtaId
									AND ndb.NdbEstado <> 6
									/*AND ndb.FacId IS NULL 
									AND ndb.FtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaDebito,	
				
				
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				DATE_FORMAT(bol.BolTiempoCreacion, "%H:%i:%s") AS "BolHoraEmision",
				bol.BolPorcentajeImpuestoVenta,
				bol.BolPorcentajeImpuestoSelectivo,
				bol.BolDireccion,
				
				bol.BolTotalImpuestoSelectivo,
				bol.BolTotalGravado,
				bol.BolTotalDescuento,
				bol.BolTotalGratuito,
				bol.BolTotalExonerado,
				bol.BolTotalPagar,
								
				bol.BolSubTotal,
				bol.BolImpuesto,
				bol.BolTotal,

				IF(reg.RegAplicacion=2,bol.BolTotal+IFNULL(bol.BolRegimenMonto,0),bol.BolTotal-IFNULL(bol.BolRegimenMonto,0)) AS "BolTotalReal",

				bol.BolObservacion,
bol.BolObservacionCaja,
				bol.BolLeyenda,
				
				bol.BolCancelado,
				bol.BolCantidadDia,
				
				DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) AS BolDiaVencido,
				
				DATE_FORMAT(bol.BolFechaVencimiento, "%d/%m/%Y") AS "NBolFechaVencimiento",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				
				bol.MonId,
				bol.BolTipoCambio,
				bol.BolObsequio,
				
				
							bol.BolDatoAdicional1,
				bol.BolDatoAdicional2,
				bol.BolDatoAdicional3,
				bol.BolDatoAdicional4,
				bol.BolDatoAdicional5,
				bol.BolDatoAdicional6,
				bol.BolDatoAdicional7,
				bol.BolDatoAdicional8,
				bol.BolDatoAdicional9,
				bol.BolDatoAdicional10,
				
				bol.BolDatoAdicional11,
				bol.BolDatoAdicional12,
				bol.BolDatoAdicional13,
				bol.BolDatoAdicional14,
				bol.BolDatoAdicional15,
				bol.BolDatoAdicional16,
				bol.BolDatoAdicional17,
				bol.BolDatoAdicional18,
				bol.BolDatoAdicional19,
				bol.BolDatoAdicional20,
				
				bol.BolDatoAdicional21,
				bol.BolDatoAdicional22,
				bol.BolDatoAdicional23,
				bol.BolDatoAdicional24,
				bol.BolDatoAdicional25,
bol.BolDatoAdicional26,
bol.BolDatoAdicional27,
bol.BolDatoAdicional28,
				
				
				bol.BolObservado,
				bol.BolEstado,	
				bol.BolCierre,				
				bol.RegId,
				bol.BolRegimenPorcentaje,
				bol.BolRegimenMonto,
				bol.BolRegimenComprobanteNumero,
				DATE_FORMAT(bol.BolRegimenComprobanteFecha, "%d/%m/%Y") AS "NBolRegimenComprobanteFecha",								
				
				bol.BolUsuario,
				bol.BolVendedor,
				bol.BolNumeroPedido,
				
				DATE_FORMAT(bol.BolTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoCreacion",
                DATE_FORMAT(bol.BolTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoModificacion",

				bol.BolSunatRespuestaTicket,
				bol.BolSunatRespuestaTicketEstado,
				bol.BolSunatRespuestaObservacion,

				bol.BolSunatRespuestaEnvioTicket,
				bol.BolSunatRespuestaEnvioTicketEstado,				
				DATE_FORMAT(bol.BolSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NBolSunatRespuestaEnvioFecha",
				bol.BolSunatRespuestaEnvioHora,
				bol.BolSunatRespuestaEnvioCodigo,
				bol.BolSunatRespuestaEnvioContenido,

				bol.BolSunatRespuestaBajaTicket,
				bol.BolSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(bol.BolSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaBajaFecha",
				bol.BolSunatRespuestaBajaHora,
				bol.BolSunatRespuestaBajaCodigo,
				bol.BolSunatRespuestaBajaContenido,
				bol.BolSunatRespuestaBajaId,
				
				bol.BolSunatRespuestaConsultaCodigo,
				bol.BolSunatRespuestaConsultaContenido,
				DATE_FORMAT(bol.BolSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaConsultaFecha",
				bol.BolSunatRespuestaConsultaHora,
				
				DATE_FORMAT(bol.BolSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaBajaTiempoCreacion",
				
				bol.BolSunatUltimaAccion,
				bol.BolSunatUltimaRespuesta,
				
				bol.BolSunatRespuestaEnvioDigestValue,
				bol.BolSunatRespuestaEnvioSignatureValue,
				
				(SELECT 
		
				(pag.PagMonto)
				
				FROM tblpagpago pag
				WHERE 
					
					EXISTS(
						SELECT
						pac.PacId
						FROM tblpacpagocomprobante pac
							WHERE pac.PagId = pag.PagId
							AND (pac.BolId = bol.BolId AND pac.BtaId = bol.BtaId)
					)
					
					ORDER BY pag.PagId ASC LIMIT 1
		
				) AS BolAbono,
		
		
		
		
				@PagMonto:=(SELECT 
				
				SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
				
				FROM tblpagpago pag
				WHERE 
					
					EXISTS(
						SELECT
						pac.PacId
						FROM tblpacpagocomprobante pac
							WHERE pac.PagId = pag.PagId
							AND pac.BolId = bol.BolId
							AND pac.BtaId = bol.BtaId
					)
					
				) AS BolAbonado,
				
				(bol.BolTotal - IFNULL(@PagMonto,0)) AS BolSaldo,

				bta.BtaNumero,
				
				reg.RegAplicacion,
				reg.RegNombre,
				
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				
				tdo.TdoCodigo,
				
				cli.CliNombre,
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
				
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				
				
				fin.FinVehiculoKilometraje,
				
				mon.MonNombre,
				mon.MonSimbolo,
				mon.MonSigla,
				mon.MonCodigo,
				
				fim.FinId,
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
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.BolId = bol.BolId
						AND pac.BtaId = bol.BtaId)
						AND pag.PagEstado = 3
				) AS BolMontoAmortizado,
				
				/*@AmortizadoOtro:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtro,
				*/
				
				@AmortizadoOtroVehiculo:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE pac.OvvId = bol.OvvId
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtroVehiculo,
				
				
				(
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) 
				) AS BolMontoPendiente,

				IF(IFNULL((
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) - IFNULL(@AmortizadoOtro,0)   - IFNULL(@AmortizadoOtroVehiculo,0) 	
				),0)>0,2,1) AS NBolCancelado,
				
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
						AND bol.PagId = pag.PagId
						LIMIT 1
						)
					)
				
				) AS  VdiId,
				
			
				vdi.VdiArchivo,
				
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
				
				npa.NpaNombre,
				
				IFNULL(fim.FinId,IFNULL(bol.OvvId,IFNULL(amo.VdiId,""))) AS  BolNumeroPedido,
				
				suc.SucNombre,
				suc.SucDireccion,
				suc.SucDistrito,
				suc.SucProvincia,
				suc.SucDepartamento,
				suc.SucCodigoUbigeo
								
				FROM tblbolboleta bol
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
						LEFT JOIN tblregregimen reg
						ON bol.RegId = reg.RegId
							LEFT JOIN tblclicliente cli
							ON bol.CliId = cli.CliId
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
								
									
								LEFT JOIN tblmonmoneda mon
									ON bol.MonId = mon.MonId
										LEFT JOIN tblamoalmacenmovimiento amo
										ON bol.AmoId = amo.AmoId
											
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
															LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId
																											
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
											ON bol.OvvId = ovv.OvvId
												
												
												LEFT JOIN tblvvevehiculoversion vve2
												ON ein2.VveId = vve2.VveId
												
													LEFT JOIN tblvmovehiculomodelo vmo2
													ON vve2.VmoId = vmo2.VmoId
													
														LEFT JOIN tblvmavehiculomarca vma2
														ON vmo2.Vmaid = vma2.VmaId
											
														LEFT JOIN tblnpacondicionpago npa
														ON bol.NpaId = npa.NpaId			
														
														
														
															
															
															
									LEFT JOIN tblsucsucursal suc
									ON bol.SucId = suc.SucId					
											
				WHERE bol.BolId = "'.$this->BolId.'" AND bol.BtaId = "'.$this->BtaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			$this->BolId = $fila['BolId'];
			$this->BtaId = $fila['BtaId'];
			$this->SucId = $fila['SucId'];
			
            $this->UsuId = $fila['UsuId'];
			
			$this->CliId = $fila['CliId'];

			$this->NpaId = $fila['NpaId'];
			
			$this->AmoId = $fila['AmoId'];
			$this->OvvId = $fila['OvvId'];
			
		$this->PagId = $fila['PagId'];	
			
			
			$this->BolAlmacenMovimiento = $fila['BolAlmacenMovimiento'];
			

			$this->BolFechaEmision = $fila['NBolFechaEmision'];
			$this->BolHoraEmision = $fila['BolHoraEmision'];
			
			$this->BolPorcentajeImpuestoVenta = $fila['BolPorcentajeImpuestoVenta'];
			$this->BolPorcentajeImpuestoSelectivo = $fila['BolPorcentajeImpuestoSelectivo'];
			$this->BolDireccion = $fila['BolDireccion'];
			
			
				$this->BolTotalImpuestoSelectivo = $fila['BolTotalImpuestoSelectivo']; 
			$this->BolTotalGravado = $fila['BolTotalGravado']; 
			$this->BolTotalDescuento = $fila['BolTotalDescuento']; 
			$this->BolTotalGratuito = $fila['BolTotalGratuito']; 
			$this->BolTotalExonerado = $fila['BolTotalExonerado']; 
			$this->BolTotalPagar = $fila['BolTotalPagar']; 
				
			$this->BolSubTotal = $fila['BolSubTotal']; 
			$this->BolImpuesto = $fila['BolImpuesto']; 
			$this->BolTotal = $fila['BolTotal']; 
			$this->BolTotalReal = $fila['BolTotalReal'];
			
			list($this->BolObservacion,$this->BolObservacionImpresa) = explode("###",$fila['BolObservacion']);	
			$this->BolObservacionCaja = $fila['BolObservacionCaja'];

			$this->BolLeyenda = $fila['BolLeyenda'];
			$this->BolCancelado = $fila['BolCancelado'];
			$this->BolCantidadDia = $fila['BolCantidadDia']; 	
			
			
			
			$this->BolDiaVencido = $fila['BolDiaVencido']; 
			$this->BolFechaVencimiento = $fila['NBolFechaVencimiento']; 	
			$this->BolDiaTranscurrido = $fila['BolDiaTranscurrido']; 	
			
		
				
				
			$this->MonId = $fila['MonId'];
			$this->BolTipoCambio = $fila['BolTipoCambio'];	
			
			$this->BolObsequio = $fila['BolObsequio'];	
			
			
			$this->BolDatoAdicional1 = $fila['BolDatoAdicional1'];
			$this->BolDatoAdicional2 = $fila['BolDatoAdicional2'];
			$this->BolDatoAdicional3 = $fila['BolDatoAdicional3'];
			$this->BolDatoAdicional4 = $fila['BolDatoAdicional4'];
			$this->BolDatoAdicional5 = $fila['BolDatoAdicional5'];
			$this->BolDatoAdicional6 = $fila['BolDatoAdicional6'];
			$this->BolDatoAdicional7 = $fila['BolDatoAdicional7'];
			$this->BolDatoAdicional8 = $fila['BolDatoAdicional8'];
			$this->BolDatoAdicional9 = $fila['BolDatoAdicional9'];
			$this->BolDatoAdicional10 = $fila['BolDatoAdicional10'];
			
			$this->BolDatoAdicional11 = $fila['BolDatoAdicional11'];
			$this->BolDatoAdicional12 = $fila['BolDatoAdicional12'];
			$this->BolDatoAdicional13 = $fila['BolDatoAdicional13'];
			$this->BolDatoAdicional14 = $fila['BolDatoAdicional14'];
			$this->BolDatoAdicional15 = $fila['BolDatoAdicional15'];
			$this->BolDatoAdicional16 = $fila['BolDatoAdicional16'];
			$this->BolDatoAdicional17 = $fila['BolDatoAdicional17'];
			$this->BolDatoAdicional18 = $fila['BolDatoAdicional18'];
			$this->BolDatoAdicional19 = $fila['BolDatoAdicional19'];
			$this->BolDatoAdicional20 = $fila['BolDatoAdicional20'];
			
			$this->BolDatoAdicional21 = $fila['BolDatoAdicional21'];
			$this->BolDatoAdicional22 = $fila['BolDatoAdicional22'];
			$this->BolDatoAdicional23 = $fila['BolDatoAdicional23'];
			$this->BolDatoAdicional24 = $fila['BolDatoAdicional24'];
			$this->BolDatoAdicional25 = $fila['BolDatoAdicional25'];
			$this->BolDatoAdicional26 = $fila['BolDatoAdicional26'];
			$this->BolDatoAdicional27 = $fila['BolDatoAdicional27'];
			$this->BolDatoAdicional28 = $fila['BolDatoAdicional28'];
			
			
				
			
			$this->BolEstado = $fila['BolEstado'];

			$this->BolCierre = $fila['BolCierre']; 						
			
			$this->RegId = $fila['RegId']; 
			$this->BolRegimenPorcentaje = $fila['BolRegimenPorcentaje']; 
			$this->BolRegimenMonto = $fila['BolRegimenMonto'];
			$this->BolRegimenComprobanteNumero = $fila['BolRegimenComprobanteNumero']; 
			$this->BolRegimenComprobanteFecha = $fila['NBolRegimenComprobanteFecha']; 
			
			$this->BolSunatRespuestaTicket = $fila['BolSunatRespuestaTicket']; 	
			$this->BolSunatRespuestaTicketEstado = $fila['BolSunatRespuestaTicketEstado']; 			
			$this->BolSunatRespuestaObservacion = $fila['BolSunatRespuestaObservacion']; 	
			
			$this->BolSunatRespuestaEnvioTicket = $fila['BolSunatRespuestaEnvioTicket']; 
			$this->BolSunatRespuestaEnvioTicketEstado = $fila['BolSunatRespuestaEnvioTicketEstado']; 
			$this->BolSunatRespuestaEnvioFecha = $fila['NBolSunatRespuestaEnvioFecha']; 	
			$this->BolSunatRespuestaEnvioHora = $fila['BolSunatRespuestaEnvioHora']; 	
			$this->BolSunatRespuestaEnvioCodigo = $fila['BolSunatRespuestaEnvioCodigo']; 	
			$this->BolSunatRespuestaEnvioContenido = $fila['BolSunatRespuestaEnvioContenido']; 	
			
			$this->BolSunatRespuestaBajaTicket = $fila['BolSunatRespuestaBajaTicket']; 	
			$this->BolSunatRespuestaBajaTicketEstado = $fila['BolSunatRespuestaBajaTicketEstado']; 	
			$this->BolSunatRespuestaBajaFecha = $fila['NBolSunatRespuestaBajaFecha']; 	
			$this->BolSunatRespuestaBajaHora = $fila['BolSunatRespuestaBajaHora']; 				
			$this->BolSunatRespuestaBajaCodigo = $fila['BolSunatRespuestaBajaCodigo']; 	
			$this->BolSunatRespuestaBajaContenido = $fila['BolSunatRespuestaBajaContenido']; 	
			$this->BolSunatRespuestaBajaId = $fila['BolSunatRespuestaBajaId']; 	
			
			$this->BolSunatRespuestaConsultaCodigo = $fila['BolSunatRespuestaConsultaCodigo']; 	
			$this->BolSunatRespuestaConsultaContenido = $fila['BolSunatRespuestaConsultaContenido']; 	
			$this->BolSunatRespuestaConsultaFecha = $fila['NBolSunatRespuestaConsultaFecha']; 	
			$this->BolSunatRespuestaConsultaHora = $fila['BolSunatRespuestaConsultaHora']; 	
			
			$this->BolSunatRespuestaEnvioTiempoCreacion = $fila['NBolSunatRespuestaEnvioTiempoCreacion']; 	
			$this->BolSunatRespuestaConsultaTiempoCreacion = $fila['NBolSunatRespuestaConsultaTiempoCreacion']; 	
			$this->BolSunatRespuestaBajaTiempoCreacion = $fila['NBolSunatRespuestaBajaTiempoCreacion']; 
			
			$this->BolSunatUltimaAccion = $fila['BolSunatUltimaAccion']; 
			$this->BolSunatUltimaRespuesta = $fila['BolSunatUltimaRespuesta']; 
				
			$this->BolSunatRespuestaEnvioDigestValue = $fila['BolSunatRespuestaEnvioDigestValue']; 
			$this->BolSunatRespuestaEnvioSignatureValue = $fila['BolSunatRespuestaEnvioSignatureValue']; 
				
			$this->BolUsuario = $fila['BolUsuario'];
			$this->BolVendedor = $fila['BolVendedor'];
			$this->BolNumeroPedido = $fila['BolNumeroPedido'];
				
			$this->BolObservado = $fila['BolObservado'];	
			$this->BolTiempoCreacion = $fila['NBolTiempoCreacion'];
			$this->BolTiempoModificacion = $fila['NBolTiempoModificacion']; 		
			$this->BolAbono = $fila['BolAbono']; 		

			$this->BolAbonado = $fila['BolAbonado'];
			$this->BolSaldo = $fila['BolSaldo'];
			
			
			$this->BtaNumero = $fila['BtaNumero'];
			
			$this->RegAplicacion = $fila['RegAplicacion'];
			$this->RegNombre = $fila['RegNombre'];

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
				
			$this->CliDepartamento = $fila['CliDepartamento']; 
			$this->CliProvincia = $fila['CliProvincia']; 
			$this->CliDistrito = $fila['CliDistrito'];

			$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje']; 
				
			$this->MonNombre = $fila['MonNombre']; 
			$this->MonSimbolo = $fila['MonSimbolo']; 
			$this->MonSigla = $fila['MonSigla']; 
			$this->MonCodigo = $fila['MonCodigo']; 
			
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
			
			
			$this->BolMontoAmortizado = $fila['BolMontoAmortizado'];
			$this->BolMontoPendiente = $fila['BolMontoPendiente'];
			//$this->BolCancelado = $fila['NBolCancelado'];
			
			$this->VdiId = $fila['VdiId'];
			$this->VdiArchivo = $fila['VdiArchivo'];
			
			
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
			
			$this->NpaNombre = $fila['NpaNombre'];
			
			$this->SucNombre = $fila['SucNombre'];
			$this->SucDireccion = $fila['SucDireccion'];
			$this->SucDistrito = $fila['SucDistrito'];
			$this->SucProvincia = $fila['SucProvincia'];
			$this->SucDepartamento = $fila['SucDepartamento'];
			$this->SucCodigoUbigeo = $fila['SucCodigoUbigeo'];
				
				
				
			if($oCompleto){
				
				$InsBoletaDetalle = new ClsBoletaDetalle($this->InsMysql);
				$ResBoletaDetalle =  $InsBoletaDetalle->MtdObtenerBoletaDetalles(NULL,NULL,NULL,NULL,NULL,$this->BolId,$this->BtaId);
				$this->BoletaDetalle = $ResBoletaDetalle['Datos'];

// MtdObtenerBoletaAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oBoleta=NULL,$oBoletaTalonario=NULL,$oAlmacenMovimiento=NULL,$oAnulado=true,$oTipo=NULL)
				$InsBoletaAlmacenMovimiento = new ClsBoletaAlmacenMovimiento($this->InsMysql);
				$ResBoletaAlmacenMovimiento =  $InsBoletaAlmacenMovimiento->MtdObtenerBoletaAlmacenMovimientos(NULL,NULL,NULL,NULL,NULL,$this->BolId,$this->BtaId);
				$this->BoletaAlmacenMovimiento = $ResBoletaAlmacenMovimiento['Datos'];

				if(!empty($this->OvvId)){
					
					$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario($this->InsMysql);
					$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpTiempoCreacion','ASC',NULL,$this->OvvId);
					$this->OrdenVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];
					
					//$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();
//					$InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,'OvoId','ASC',NULL,$this->OvvId,NULL);
//					$this->OrdenVentaVehiculoObsequio = $ResOrdenVentaVehiculoObsequio['Datos'];
				
				}
				
			}
			

				switch($this->BolEstado){
					case 1:
						$this->BolEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$this->BolEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$this->BolEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$this->BolEstadoDescripcion = "Reservado";
					break;
					
					
				}
				
				
				switch($this->BolEstado){
					case 1:
						$this->BolEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 5:
						$this->BolEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->BolEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					case 7:
						$this->BolEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
					
				}
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerBoletas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL,$oVendedor=NULL, $oSucursal=NULL,$oNoProcesdado=false,$oCancelado=NULL,$oSinPago=false,$oDiasVencido=NULL,$oVencido=false,$oObsequio=NULL) {
	


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
					bde.BdeId
					FROM tblbdeboletadetalle bde
						
					WHERE 
						bde.BolId = bol.BolId AND
						bde.BtaId = bol.BtaId AND
						
						(
						bde.BdeDescripcion LIKE "%'.$oFiltro.'%" 
						
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
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (bol.BolEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
						
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oTalonario)){
			$talonario = ' AND bol.BtaId = "'.$oTalonario.'"';
		}
		
		
		if(!empty($oRegimen)){
			$regimen = ' AND bol.RegId = "'.$oRegimen.'"';
		}
		
		
		if(!empty($oCondicionPago)){
			$npago = ' AND bol.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND bol.MonId = "'.$oMoneda.'"';
		}
			

		if(!empty($oAlmacenMovimiento)){
			$amovimiento = ' AND bol.AmoId = "'.$oAlmacenMovimiento.'"';
		}
		
		
		if(!empty($oCliente)){
			$cliente = ' AND bol.CliId = "'.$oCliente.'"';
		}

		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND bol.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}

		if(!empty($oVentaDirecta)){
			$vdirecta = ' AND amo.VdiId = "'.$oVentaDirecta.'"';
		}
		

		
		if(!empty($oVendedor)){
			$vendedor = ' AND vdi.PerId = "'.$oVendedor.'" OR ovv.PerId = "'.$oVendedor.'" ';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND bol.SucId = "'.$oSucursal.'"';
		}
		
		
		if(($oNoProcesdado)){

			$noprocesado = ' AND	(bol.BolSunatRespuestaEnvioContenido NOT LIKE "%aceptad%" 
				OR bol.BolSunatRespuestaEnvioContenido IS NULL 
				OR bol.BolSunatRespuestaEnvioContenido  = ""
				
				) ';
		}
		
							
		if(!empty($oCancelado)){
			switch($oCancelado){
				
				case "Si":
				
					//$cancelado = ' HAVING NBolCancelado = 1 ';
					$cancelado = ' AND bol.BolCancelado = 1 ';
					
				break;
				
				case "No":
				
					$cancelado = '  AND bol.BolCancelado = 2 ';//
					//$cancelado = '  HAVING NBolCancelado = 2 ';
					
				break;
				
			}
			
		}
			
		if(($oSinPago)){

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
						
					WHERE pac.BolId = bol.BolId AND pac.BtaId = bol.BtaId
					AND pag.PagEstado = 3
					
					LIMIT 1
				
				) ,0 
				
			) <  bol.BolTotal/IFNULL(bol.BolTipoCambio,1) 
			
			) AND bol.OvvId IS NULL
			
			';
			
		}
		
		if(!empty($oDiaVencido)){
			
			if($oDiasVencido==-1){
				$oDiasVencido = 0;
			}
			
			$dvencido = ' AND DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) =  ' .$oDiasVencido;
		}
			
			
		if($oVencido){
			$vencido = ' AND DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) > 0 ';
		}
		
						
		if(!empty($oObsequio)){
			$obsequio = ' AND bol.BolObsequio = '.$oObsequio.' ';
		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				bol.BolId,
				bol.BtaId,
				bol.SucId,
				
				bol.UsuId,
				bol.CliId,
				
				bol.NpaId,
				
				bol.AmoId,
				bol.OvvId,
				
				bol.PagId,
				
				CASE
				WHEN EXISTS (
					SELECT ncr.NcrId
						FROM tblncrnotacredito ncr
								WHERE ncr.BolId = bol.BolId 
									AND ncr.BtaId = bol.BtaId
									AND ncr.NcrEstado <> 6
								/*	AND ncr.BolId IS NULL 
									AND ncr.BtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaCredito,
				
				
				CASE
				WHEN EXISTS (
					SELECT ndb.NdbId
						FROM tblndbnotadebito ndb
								WHERE ndb.BolId = bol.BolId 
									AND ndb.BtaId = bol.BtaId
									AND ndb.NdbEstado <> 6
									/*AND ndb.FacId IS NULL 
									AND ndb.FtaId IS NULL*/
				) THEN "Si"
				ELSE "No"
				END AS BolNotaDebito,	
				
				
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
DATE_FORMAT(bol.BolTiempoCreacion, "%H:%i:%s") AS "BolHoraEmision",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				bol.BolPorcentajeImpuestoVenta,
				bol.BolPorcentajeImpuestoSelectivo,
				bol.BolDireccion,
				
				IF(bol.BolEstado=6,0.00,bol.BolTotalImpuestoSelectivo) AS "BolTotalImpuestoSelectivo",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalGravado) AS "BolTotalGravado",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalDescuento) AS "BolTotalDescuento",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalGratuito) AS "BolTotalGratuito",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalExonerado) AS "BolTotalExonerado",	
				IF(bol.BolEstado=6,0.00,bol.BolTotalPagar) AS "BolTotalPagar",	
				
				IF(bol.BolEstado=6,0.00,bol.BolSubTotal) AS "BolSubTotal",	
				IF(bol.BolEstado=6,0.00,bol.BolImpuesto) AS "BolImpuesto",
				IF(bol.BolEstado=6,0.00,bol.BolTotal) AS "BolTotal",
		
				IF(reg.RegAplicacion=2,bol.BolTotal+IFNULL(bol.BolRegimenMonto,0),bol.BolTotal-IFNULL(bol.BolRegimenMonto,0)) AS "BolTotalReal",
		
				bol.BolObservacion,
bol.BolObservacionCaja,
				bol.BolLeyenda,
				
				bol.BolCancelado,
				bol.BolCantidadDia,
				DATEDIFF(DATE(NOW()),bol.BolFechaVencimiento) AS BolDiaVencido,
				
				DATE_FORMAT(bol.BolFechaVencimiento, "%d/%m/%Y") AS "NBolFechaVencimiento",
				DATEDIFF(DATE(NOW()),bol.BolFechaEmision) AS BolDiaTranscurrido,
				
				bol.MonId,
				bol.BolTipoCambio,
				bol.BolTipoCambioAux,

				bol.BolObsequio,
				
					
				bol.BolDatoAdicional1,
				bol.BolDatoAdicional2,
				bol.BolDatoAdicional3,
				bol.BolDatoAdicional4,
				bol.BolDatoAdicional5,
				bol.BolDatoAdicional6,
				bol.BolDatoAdicional7,
				bol.BolDatoAdicional8,
				bol.BolDatoAdicional9,
				bol.BolDatoAdicional10,
				
				bol.BolDatoAdicional11,
				bol.BolDatoAdicional12,
				bol.BolDatoAdicional13,
				bol.BolDatoAdicional14,
				bol.BolDatoAdicional15,
				bol.BolDatoAdicional16,
				bol.BolDatoAdicional17,
				bol.BolDatoAdicional18,
				bol.BolDatoAdicional19,
				bol.BolDatoAdicional20,
				
				bol.BolDatoAdicional21,
				bol.BolDatoAdicional22,
				bol.BolDatoAdicional23,
				bol.BolDatoAdicional24,
				bol.BolDatoAdicional25,
				bol.BolDatoAdicional26,
				
				bol.BolDatoAdicional27,
				bol.BolDatoAdicional28,
				
				bol.BolEstado,	
				bol.BolCierre,	
				
				bol.RegId,
				bol.BolRegimenPorcentaje,
				bol.BolRegimenMonto,
				bol.BolRegimenComprobanteNumero,
				DATE_FORMAT(bol.BolRegimenComprobanteFecha, "%d/%m/%Y") AS "NBolRegimenComprobanteFecha",
				
					
				bol.BolSunatRespuestaTicket,
				bol.BolSunatRespuestaTicketEstado,
				bol.BolSunatRespuestaObservacion,
				
				bol.BolSunatRespuestaEnvioTicket,
				bol.BolSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(bol.BolSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NBolSunatRespuestaEnvioFecha",
				bol.BolSunatRespuestaEnvioHora,
				bol.BolSunatRespuestaEnvioCodigo,
				bol.BolSunatRespuestaEnvioContenido,
				
				bol.BolSunatRespuestaBajaTicket,
				bol.BolSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(bol.BolSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaBajaFecha",
				bol.BolSunatRespuestaBajaHora,				
				bol.BolSunatRespuestaBajaCodigo,
				bol.BolSunatRespuestaBajaContenido,
				bol.BolSunatRespuestaBajaId,
				
				bol.BolSunatRespuestaConsultaCodigo,
				bol.BolSunatRespuestaConsultaContenido,
				DATE_FORMAT(bol.BolSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NBolSunatRespuestaConsultaFecha",
				bol.BolSunatRespuestaConsultaHora,
				
				DATE_FORMAT(bol.BolSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(bol.BolSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolSunatRespuestaBajaTiempoCreacion",
				bol.BolSunatUltimaAccion,
				bol.BolSunatUltimaRespuesta,
				
				bol.BolObservado,
				DATE_FORMAT(bol.BolTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoCreacion",
                DATE_FORMAT(bol.BolTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBolTiempoModificacion",
				
				(SELECT COUNT(bde.BdeId) FROM tblbdeboletadetalle bde WHERE bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId ) AS "BolTotalItems",
				
				
				npa.NpaNombre,
				
				bta.BtaNumero,
				
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
				cli.CliCelular,
				cli.CliFax,
				
				mon.MonNombre,
				mon.MonSimbolo,
				mon.MonSigla,
				
				fim.FinId,
				amo.CprId,
				
				
								
				CASE
				WHEN EXISTS (
					SELECT 
					pag.PagId
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante cpc
						ON cpc.PagId = pag.PagId 
					WHERE (cpc.BolId = bol.BolId
						AND cpc.BtaId = bol.BtaId)						
						LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS BolTieneAbono,
				
			
				
				
				
				@Amortizado:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.BolId = bol.BolId
						AND pac.BtaId = bol.BtaId)
						AND pag.PagEstado = 3
				) AS BolMontoAmortizado,
				
				/*@AmortizadoOtro:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE (pac.VdiId = IFNULL(amo.VdiId,vdi2.VdiId))
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtro,*/
				
				@AmortizadoOtroVehiculo:=(
					SELECT 
					SUM( (pag.PagMonto/IFNULL(pag.PagTipoCambio,1)) )
					FROM tblpagpago pag
						LEFT JOIN tblpacpagocomprobante pac
						ON pac.PagId = pag.PagId 
					WHERE pac.OvvId = bol.OvvId
					AND pag.PagEstado = 3
				) AS BolMontoAmortizadoOtroVehiculo,
				
				
				(
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) 
				) AS BolMontoPendiente,
				
				
				IF(IFNULL((
					(bol.BolTotal/IFNULL(bol.BolTipoCambio,1)) - IFNULL(@Amortizado,0) - IFNULL(@AmortizadoOtro,0)  - IFNULL(@AmortizadoOtroVehiculo,0)
				),0)>0,2,1) AS NBolCancelado,
				
				
				vdi.VdiId,
				vdi.VdiOrdenCompraNumero,	
				vdi.VdiArchivo,
				
				amo.AmoTipo,
				amo.AmoSubTipo,
				
				tdo.TdoNombre,
				tdo.TdoCodigo,
				
				suc.SucNombre,
				suc.SucSiglas
								
				FROM tblbolboleta bol
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					
					LEFT JOIN tblnpacondicionpago npa
					ON bol.NpaId = npa.NpaId
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
							LEFT JOIN tblregregimen reg
							ON bol.RegId = reg.RegId
								LEFT JOIN tblclicliente cli
								ON bol.CliId = cli.CliId
									LEFT JOIN tblmonmoneda mon
									ON bol.MonId = mon.MonId
										LEFT JOIN tblamoalmacenmovimiento amo
										ON bol.AmoId = amo.AmoId
											LEFT JOIN tblvdiventadirecta vdi
											ON amo.VdiId = vdi.VdiId
											
											LEFT JOIN tblfccfichaaccion fcc
											ON amo.FccId = fcc.FccId
												LEFT JOIN tblfimfichaingresomodalidad fim
												ON fcc.FimId = fim.FimId
													LEFT JOIN tbltdotipodocumento tdo
													ON cli.TdoId = tdo.TdoId
													
													
														LEFT JOIN tblfinfichaingreso fin
														ON fim.FinId = fin.FinId
															
															/*LEFT JOIN tblvdiventadirecta vdi2
															ON vdi2.FinId = fin.FinId*/
																										
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$sinpago.$dvencido.$obsequio.$fecha.$vendedor.$dvencido.$vencido.$noprocesado.$talonario.$credito.$regimen.$npago.$moneda.$amovimiento.$cliente.$ovvehiculo.$vdirecta.$cancelado.$orden.$paginacion;
									
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsBoleta = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Boleta = new $InsBoleta();
                    $Boleta->BolId = $fila['BolId'];
					$Boleta->BtaId = $fila['BtaId'];
					$Boleta->SucId = $fila['SucId'];
					
                    $Boleta->UsuId= $fila['UsuId'];
					$Boleta->CliId= $fila['CliId'];

					$Boleta->NpaId= $fila['NpaId'];
					$Boleta->AmoId= $fila['AmoId'];
					$Boleta->OvvId= $fila['OvvId'];
					
					$Boleta->PagId= $fila['PagId'];
					
					$Boleta->BolNotaCredito = $fila['BolNotaCredito'];
					$Boleta->BolNotaDebito = $fila['BolNotaDebito'];
					
					$Boleta->BolFechaEmision = $fila['NBolFechaEmision'];
					$Boleta->BolHoraEmision = $fila['BolHoraEmision'];
					
					$Boleta->BolDiaTranscurrido = $fila['BolDiaTranscurrido'];
					
					
					$Boleta->BolPorcentajeImpuestoVenta = $fila['BolPorcentajeImpuestoVenta'];
					$Boleta->BolPorcentajeImpuestoSelectivo = $fila['BolPorcentajeImpuestoSelectivo'];
					$Boleta->BolDireccion = $fila['BolDireccion'];

					$Boleta->BolNotaCredito = $fila['BolNotaCredito'];
					$Boleta->BolNotaDebito = $fila['BolNotaDebito'];

					$Boleta->BolTotalImpuestoSelectivo = $fila['BolTotalImpuestoSelectivo']; 	
					$Boleta->BolTotalGravado = $fila['BolTotalGravado']; 
					$Boleta->BolTotalDescuento = $fila['BolTotalDescuento']; 
					$Boleta->BolTotalGratuito = $fila['BolTotalGratuito']; 
					$Boleta->BolTotalExonerado = $fila['BolTotalExonerado']; 
					$Boleta->BolTotalPagar = $fila['BolTotalPagar']; 
					
					$Boleta->BolSubTotal = $fila['BolSubTotal']; 
					$Boleta->BolImpuesto = $fila['BolImpuesto']; 					
					$Boleta->BolTotal = $fila['BolTotal']; 
					$Boleta->BolTotalReal = $fila['BolTotalReal']; 
					
					list($Boleta->BolObservacion,$Boleta->BolObservacionImpresa) = explode("###",$fila['BolObservacion']);	

					$Boleta->BolObservacionCaja = $fila['BolObservacionCaja'];
					$Boleta->BolLeyenda = $fila['BolLeyenda'];
					$Boleta->BolCancelado = $fila['BolCancelado'];
					$Boleta->BolCantidadDia = $fila['BolCantidadDia'];
					
					
					$Boleta->BolDiaVencido = $fila['BolDiaVencido']; 	
					$Boleta->BolFechaVencimiento = $fila['NBolFechaVencimiento']; 	
					$Boleta->BolDiaTranscurrido = $fila['BolDiaTranscurrido']; 	
			
			
					
					$Boleta->MonId = $fila['MonId'];
					$Boleta->BolTipoCambio = $fila['BolTipoCambio'];
					$Boleta->BolTipoCambioAux = $fila['BolTipoCambioAux'];
					
					
					$Boleta->BolObsequio = $fila['BolObsequio'];
					$Boleta->BolTieneAbono = $fila['BolTieneAbono'];
					
					
								$Boleta->BolDatoAdicional1 = $fila['BolDatoAdicional1'];
					$Boleta->BolDatoAdicional2 = $fila['BolDatoAdicional2'];
					$Boleta->BolDatoAdicional3 = $fila['BolDatoAdicional3'];
					$Boleta->BolDatoAdicional4 = $fila['BolDatoAdicional4'];
					$Boleta->BolDatoAdicional5 = $fila['BolDatoAdicional5'];
					$Boleta->BolDatoAdicional6 = $fila['BolDatoAdicional6'];
					$Boleta->BolDatoAdicional7 = $fila['BolDatoAdicional7'];
					$Boleta->BolDatoAdicional8 = $fila['BolDatoAdicional8'];
					$Boleta->BolDatoAdicional9 = $fila['BolDatoAdicional9'];
					$Boleta->BolDatoAdicional10 = $fila['BolDatoAdicional10'];
					
					$Boleta->BolDatoAdicional11 = $fila['BolDatoAdicional11'];
					$Boleta->BolDatoAdicional12 = $fila['BolDatoAdicional12'];
					$Boleta->BolDatoAdicional13 = $fila['BolDatoAdicional13'];
					$Boleta->BolDatoAdicional14 = $fila['BolDatoAdicional14'];
					$Boleta->BolDatoAdicional15 = $fila['BolDatoAdicional15'];
					$Boleta->BolDatoAdicional16 = $fila['BolDatoAdicional16'];
					$Boleta->BolDatoAdicional17 = $fila['BolDatoAdicional17'];
					$Boleta->BolDatoAdicional18 = $fila['BolDatoAdicional18'];
					$Boleta->BolDatoAdicional19 = $fila['BolDatoAdicional19'];
					$Boleta->BolDatoAdicional20 = $fila['BolDatoAdicional20'];
					
					$Boleta->BolDatoAdicional21 = $fila['BolDatoAdicional21'];
					$Boleta->BolDatoAdicional22 = $fila['BolDatoAdicional22'];
					$Boleta->BolDatoAdicional23 = $fila['BolDatoAdicional23'];
					$Boleta->BolDatoAdicional24 = $fila['BolDatoAdicional24'];
					$Boleta->BolDatoAdicional25 = $fila['BolDatoAdicional25'];
					$Boleta->BolDatoAdicional26 = $fila['BolDatoAdicional26'];
					
					$Boleta->BolDatoAdicional27 = $fila['BolDatoAdicional27'];
					$Boleta->BolDatoAdicional28 = $fila['BolDatoAdicional28'];
					
					$Boleta->BolEstado = $fila['BolEstado'];
					$Boleta->BolCierre = $fila['BolCierre'];	
					
					$Boleta->RegId = $fila['RegId'];	
					$Boleta->BolRegimenPorcentaje = $fila['BolRegimenPorcentaje'];	
					$Boleta->BolRegimenMonto = $fila['BolRegimenMonto'];	
					$Boleta->BolRegimenComprobanteNumero = $fila['BolRegimenComprobanteNumero'];	
					$Boleta->BolRegimenComprobanteFecha = $fila['NBolRegimenComprobanteFecha'];	

					$Boleta->BolSunatRespuestaTicket = $fila['BolSunatRespuestaTicket']; 	
					$Boleta->BolSunatRespuestaTicketEstado = $fila['BolSunatRespuestaTicketEstado']; 			
					$Boleta->BolSunatRespuestaObservacion = $fila['BolSunatRespuestaObservacion']; 	
					
					$Boleta->BolSunatRespuestaEnvioTicket = $fila['BolSunatRespuestaEnvioTicket']; 	
					$Boleta->BolSunatRespuestaEnvioTicketEstado = $fila['BolSunatRespuestaEnvioTicketEstado']; 	
					$Boleta->BolSunatRespuestaEnvioFecha = $fila['NBolSunatRespuestaEnvioFecha']; 	
					$Boleta->BolSunatRespuestaEnvioHora = $fila['BolSunatRespuestaEnvioHora']; 	
					$Boleta->BolSunatRespuestaEnvioCodigo = $fila['BolSunatRespuestaEnvioCodigo']; 	
					$Boleta->BolSunatRespuestaEnvioContenido = $fila['BolSunatRespuestaEnvioContenido']; 	
					
					$Boleta->BolSunatRespuestaBajaTicket = $fila['BolSunatRespuestaBajaTicket']; 
					$Boleta->BolSunatRespuestaBajaTicketEstado = $fila['BolSunatRespuestaBajaTicketEstado'];	
					$Boleta->BolSunatRespuestaBajaFecha = $fila['NBolSunatRespuestaBajaFecha']; 	
					$Boleta->BolSunatRespuestaBajaHora = $fila['BolSunatRespuestaBajaHora']; 	
					$Boleta->BolSunatRespuestaBajaCodigo = $fila['BolSunatRespuestaBajaCodigo']; 	
					$Boleta->BolSunatRespuestaBajaContenido = $fila['BolSunatRespuestaBajaContenido']; 	
					$Boleta->BolSunatRespuestaBajaId = $fila['BolSunatRespuestaBajaId']; 	
					
					$Boleta->BolSunatRespuestaConsultaCodigo = $fila['BolSunatRespuestaConsultaCodigo']; 	
					$Boleta->BolSunatRespuestaConsultaContenido = $fila['BolSunatRespuestaConsultaContenido']; 	
					$Boleta->BolSunatRespuestaConsultaFecha = $fila['NBolSunatRespuestaConsultaFecha']; 	
					$Boleta->BolSunatRespuestaConsultaHora = $fila['BolSunatRespuestaConsultaHora']; 	
					
					$Boleta->BolSunatRespuestaEnvioTiempoCreacion = $fila['NBolSunatRespuestaEnvioTiempoCreacion']; 	
					$Boleta->BolSunatRespuestaConsultaTiempoCreacion = $fila['NBolSunatRespuestaConsultaTiempoCreacion']; 	
					$Boleta->BolSunatRespuestaBajaTiempoCreacion = $fila['NBolSunatRespuestaBajaTiempoCreacion']; 
					
					$Boleta->BolSunatUltimaAccion = $fila['BolSunatUltimaAccion']; 
					$Boleta->BolSunatUltimaRespuesta = $fila['BolSunatUltimaRespuesta']; 
					
					$Boleta->BolObservado = $fila['BolObservado']; 
					$Boleta->BolTiempoCreacion = $fila['NBolTiempoCreacion'];
                    $Boleta->BolTiempoModificacion = $fila['NBolTiempoModificacion'];

                    $Boleta->BolTotalItems = $fila['BolTotalItems'];					

					$Boleta->NpaNombre = $fila['NpaNombre'];
					
					$Boleta->BtaNumero = $fila['BtaNumero'];
					
					$Boleta->RegAplicacion = $fila['RegAplicacion'];
					$Boleta->RegNombre = $fila['RegNombre'];
					
					if($Boleta->BolEstado == 6){

						$Boleta->CliNombreCompleto = "ANULADO";
						$Boleta->CliNombre = "ANULADO";
						$Boleta->CliApellidoPaterno = "";
						$Boleta->CliApellidoMaterno = "";
						
					}else{
					
						$Boleta->CliNombreCompleto = $fila['CliNombreCompleto'];
						$Boleta->CliNombre = $fila['CliNombre'];
						$Boleta->CliApellidoPaterno = $fila['CliApellidoPaterno'];
						$Boleta->CliApellidoMaterno = $fila['CliApellidoMaterno'];
						
					}
					
					$Boleta->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$Boleta->TdoId = $fila['TdoId'];
					$Boleta->CliTelefono = $fila['CliTelefono'];
					$Boleta->CliEmail = $fila['CliTelefono'];
					$Boleta->CliCelular = $fila['CliCelular'];
					$Boleta->CliFax = $fila['CliFax'];
					
					$Boleta->MonNombre = $fila['MonNombre'];
					$Boleta->MonSimbolo = $fila['MonSimbolo'];
					$Boleta->MonSigla = $fila['MonSigla'];
					
					
					$Boleta->FinId = $fila['FinId'];
					$Boleta->CprId = $fila['CprId'];
					
					
					$Boleta->BolMontoAmortizado = $fila['BolMontoAmortizado'];
					$Boleta->BolMontoPendiente = $fila['BolMontoPendiente'];
					//$Boleta->BolCancelado = $fila['NBolCancelado'];
					
					$Boleta->VdiId = $fila['VdiId'];
					$Boleta->VdiOrdenCompraNumero = $fila['VdiOrdenCompraNumero'];
					$Boleta->VdiArchivo = $fila['VdiArchivo'];		

					$Boleta->AmoTipo = $fila['AmoTipo'];	
					$Boleta->AmoSubTipo = $fila['AmoSubTipo'];	

					$Boleta->TdoNombre = $fila['TdoNombre'];
					$Boleta->TdoCodigo = $fila['TdoCodigo'];
						
					$Boleta->SucNombre = $fila['SucNombre'];	
					$Boleta->SucSiglas = $fila['SucSiglas'];	



				switch($Boleta->BolEstado){
					case 1:
						$Boleta->BolEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$Boleta->BolEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$Boleta->BolEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$Boleta->BolEstadoDescripcion = "Reservado";
					break;
					
					
				}
				
				
								switch($Boleta->BolEstado){
					case 1:
						$Boleta->BolEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 5:
						$Boleta->BolEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$Boleta->BolEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					case 7:
						$Boleta->BolEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
					
				}
				
				
					$Boleta->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $Boleta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}

	//MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL) {
	public function MtdObtenerBoletasValor($oFuncion="SUM",$oParametro="BolId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'BolId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oAlmacenMovimiento=NULL,$oCliente=NULL,$oClienteClasificacion=NULL,$oFichaIngresoMantenimientoKilometraje=NULL,$oModalidadIngreso=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oClienteTipo=NULL,$oTecnico=NULL,$oOrigen=NULL,$oVendedor=NULL){

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace("*","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			

		}
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		//if(!empty($oSucursal)){
//			$sucursal = ' AND bta.SucId = "'.$oSucursal.'"';
//		}
				
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (bol.BolEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'" AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(bol.BolFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(bol.BolFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oTalonario)){
			$talonario = ' AND bol.BtaId = "'.$oTalonario.'"';
		}
		
		if(!empty($oRegimen)){
			$regimen = ' AND bol.RegId = "'.$oRegimen.'"';
		}
		
		
		if(!empty($oCondicionPago)){
			$npago = ' AND bol.NpaId = "'.$oCondicionPago.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND bol.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oAlmacenMovimiento)){
			$amovimiento = ' AND bol.AmoId = "'.$oAlmacenMovimiento.'"';
		}	
		
		if(!empty($oCliente)){
			$cliente = ' AND bol.CliId = "'.$oCliente.'"';
		}	
				
		if(!empty($oClienteClasificacion)){
			$clasificacion = ' AND cli.CliClasificacion = '.$oClienteClasificacion.' ';
		}

		if(!empty($oModalidadIngreso)){
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
								LEFT JOIN tblbamboletaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
					WHERE bol.BolId = bam.BolId AND bol.BtaId = bam.BtaId
					AND fim.MinId = "'.$oModalidadIngreso.'"
					
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
								LEFT JOIN tblbolboleta bol2
								ON bol2.AmoId = amo.AmoId
								
					WHERE bol.BolId = bol2.BolId AND bol.BtaId = bol2.BtaId
					AND fim.MinId = "'.$oModalidadIngreso.'"
					
				)	
						
			)
			';
		}



		if(!empty($oFichaIngresoMantenimientoKilometraje)){

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
								LEFT JOIN tblbamboletaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
					WHERE bol.BolId = bam.BolId AND bol.BtaId = bam.BtaId
					AND fin.FinMantenimientoKilometraje = "'.$oFichaIngresoMantenimientoKilometraje.'"
					
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
								LEFT JOIN tblbolboleta bol2
								ON bol2.AmoId = amo.AmoId
								
					WHERE bol.BolId = bol2.BolId AND bol.BtaId = bol2.BtaId
					AND fin.FinMantenimientoKilometraje = "'.$oFichaIngresoMantenimientoKilometraje.'"
					
				)
							
			)
			';
		}
		
		if(!empty($oVehiculoMarca)){

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
								LEFT JOIN tblbamboletaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE bol.BolId = bam.BolId AND bol.BtaId = bam.BtaId
					AND vmo.VmaId = "'.$oVehiculoMarca.'"
					
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
								LEFT JOIN tblbolboleta bol2
								ON bol2.AmoId = amo.AmoId
								
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvvevehiculoversion vve
										ON ein.VveId = vve.VveId
											LEFT JOIN tblvmovehiculomodelo vmo
											ON vve.VmoId = vmo.VmoId
											
					WHERE bol.BolId = bol2.BolId AND bol.BtaId = bol2.BtaId
					AND vmo.VmaId = "'.$oVehiculoMarca.'"
					
				)
			
			)
			';
		}		
		
		if(!empty($oVehiculoModelo)){

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
							LEFT JOIN tblbamboletaalmacenmovimiento bam
							ON bam.AmoId = amo.AmoId
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
										
				WHERE bol.BolId = bam.BolId AND bol.BtaId = bam.BtaId
				AND vve.VmoId = "'.$oVehiculoModelo.'"
				
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
							LEFT JOIN tblbolboleta bol2
							ON bol2.AmoId = amo.AmoId
							
								LEFT JOIN tbleinvehiculoingreso ein
								ON fin.EinId = ein.EinId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
										
				WHERE bol.BolId = bol2.BolId AND bol.BtaId = bol2.BtaId
				AND vve.VmoId = "'.$oVehiculoModelo.'"
				
				)
				
					
			)
			';
		}	
				
		if(!empty($oTecnico)){

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
								LEFT JOIN tblbamboletaalmacenmovimiento bam
								ON bam.AmoId = amo.AmoId
					WHERE bol.BolId = bam.BolId AND bol.BtaId = bam.BtaId
					AND fin.PerId = "'.$oTecnico.'"
					
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
								LEFT JOIN tblbolboleta bol2
								ON bol2.AmoId = amo.AmoId
								
					WHERE bol.BolId = bol2.BolId AND bol.BtaId = bol2.BtaId
					AND fin.PerId = "'.$oTecnico.'"
					
				)
							
			)
			';
		}
		
		if(!empty($oOrigen)){

			switch($oOrigen){
				case "FichaIngreso":
					$origen = ' AND bol.FccId IS NOT NULL ';					
				break;
				
				case "OrdenVentaVehiculo":
					$origen = ' AND bol.OvvId IS NOT NULL ';
				break;
				
				case "VentaDirecta":
					$origen = ' AND bol.AmoId IS NOT NULL  AND bol.FccId IS NULL ';
				break;
				
				case "Otros":
					$origen = ' AND bol.FccId IS NULL AND bol.OvvId IS NULL AND bol.AmoId IS NULL ';
				break;
				
				default:
					$origen = '';
				break;
			}
			
		}
		
		if(!empty($oVendedor)){
			$vendedor = ' AND  
				EXISTS(
					SELECT
					bam.BamId
					FROM tblbamboletaalmacenmovimiento bam
						LEFT JOIN tblamoalmacenmovimiento amo
						ON bam.AmoId = amo.AmoId
							LEFT JOIN tblvdiventadirecta vdi
							ON amo.VdiId = vdi.VdiId
					WHERE (bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId)
					AND vdi.PerId = "'.$oVendedor.'"
					LIMIT 1

				)
			';
		}
				
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
	
		if(!empty($oMes)){
			$mes = ' AND MONTH(bol.BolFechaEmision) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(bol.BolFechaEmision) ="'.($oAno).'"';
		}
		
		if(!empty($oClienteTipo)){
			$ctipo = ' AND cli.LtiId = "'.$oClienteTipo.'" ';
		}
		
		$sql = 'SELECT
		'.$funcion.' AS "RESULTADO"
		FROM tblbolboleta bol
			LEFT JOIN tblbtaboletatalonario bta
			ON bol.BtaId = bta.BtaId
				LEFT JOIN tblclicliente cli
				ON bol.CliId = cli.CliId
		
		WHERE 1 = 1
		
		'.$filtrar.$sucursal.$estado.$fecha.$credito.$talonario.$regimen.$npago.$vendedor.$moneda.$mes.$ano.$amovimiento.$cliente.$clasificacion.$ctipo.$mkilometraje.$vmarca.$vmodelo.$tecnico.$mingreso.$origen.$orden.$paginacion;
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}




	public function MtdActualizarEstadoBoleta($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
					$this->BolId = $aux[0];
					$this->BtaId = $aux[1];
					
					
					
					if(!empty($this->BolId) and !empty($this->BtaId)){
							
							$this->MtdObtenerBoleta(false);
							
							if(!empty($this->OvvId)){
								
								$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
								
								
								
								if($oEstado == 6 and (
								$this->BolEstado == 5 or 
								$this->BolEstado == 1 or 
								$this->BolEstado == 7)){
									
									$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($this->OvvId,4);
								
								}else if($oEstado == 5 and (
								$this->BolEstado == 6 or 
								$this->BolEstado == 1 or 
								$this->BolEstado == 7 )){
									
									$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($this->OvvId,5);
								
								}
								
							}
							
					}
						
						
						
						
					$sql = 'UPDATE tblbolboleta SET BolEstado = '.$oEstado.' WHERE   (BolId = "'.($aux[0]).'" AND BtaId = "'.($aux[1]).'")';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{


						
						
						$this->MtdAuditarBoleta(2,"Se actualizo el Estado de la Boleta",$aux);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();								
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}							
	}



	//Accion eliminar	 
	
	public function MtdEliminarBoleta($oElementos) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode('%',$elemento);

					$this->BolId = $aux[0];
					$this->BtaId = $aux[1];
					$this->MtdObtenerBoleta();

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
					
					if(!empty($this->OvvId)){
						
						$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo($this->InsMysql);	
						$InsOrdenVentaVehiculo->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculo->MtdObtenerOrdenVentaVehiculo(false);
							
						if($InsOrdenVentaVehiculo->OvvEstado == 5){
							
							$InsOrdenVentaVehiculo->MtdActualizarEstadoOrdenVentaVehiculo($this->OvvId,4);
							
							//if(!empty($InsOrdenVentaVehiculo->EinId)){
//								
//								$InsVehiculoIngreso = new ClsVehiculoIngreso();
//								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","RESERVADO",$InsOrdenVentaVehiculo->EinId);
//								
//							}
							
						}
							
					}
					
					if(!$error){

						$sql = 'DELETE FROM tblbolboleta WHERE (BolId = "'.($aux[0]).'" AND BtaId = "'.($aux[1]).'")';
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							
						
							$this->MtdAuditarBoleta(3,"Se elimino la Boleta",$aux);		
						}
									
					}

				}
			$i++;
	
			}
		
	
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();							
				return false;
			} else {		
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	public function MtdRegistrarBoleta() {

			global $Resultado;
			$error = false;


			
		//if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->BolFechaEmision))){
//			$error = true;
//			$Resultado.='#ERR_BOL_400';
//		}else{
			
			
			$this->BolId = trim($this->BolId);
			
			$this->InsMysql->MtdTransaccionIniciar();


				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->CcaId = "CCA-10000";
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->BolDireccion;
				$InsCliente->CliEstado = 1;//En actividad
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
				$InsCliente->CliEliminado = 1;
			
				if(empty($InsCliente->CliId)){
					
					$InsCliente->MtdGenerarClienteId();	

					if(!$InsCliente->MtdRegistrarClienteDeBoleta()){
						$error = true;
						$Resultado.='#ERR_BOL_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
					
				}else{
					
					/*if(!$InsCliente->MtdEditarClienteDato("CliDireccion",$InsCliente->CliDireccion,$InsCliente->CliId)){
						$error = true;					
						$Resultado.='#ERR_BOL_302';
					}*/
					
				}
				
				$sql = 'INSERT INTO tblbolboleta (
				BolId,
				BtaId,
				SucId,
				
				UsuId, 
				CliId,
	
				NpaId,
				AmoId,
				OvvId,
				FccId,
				
				PagId,
				
				BolFechaEmision,
				BolFechaVencimiento,
				
				BolPorcentajeImpuestoVenta,
				BolPorcentajeImpuestoSelectivo,
				BolDireccion,
				BolTotalBruto,	
				
				BolTotalImpuestoSelectivo,	
				BolTotalPagar,	
				BolTotalExonerado,	
				BolTotalDescuento,	
				BolTotalGratuito,	
				BolTotalGravado,
						
				BolSubTotal,
				BolImpuesto,
				BolTotal,			
				BolObservacion,
				BolObservacionCaja,
				
				BolLeyenda,
				
				BolCantidadDia,
				MonId,
				BolTipoCambio,	
				BolObsequio,	
				BolEstado,
				BolCierre,			
				RegId,
				BolRegimenPorcentaje,
				BolRegimenMonto,
				BolRegimenComprobanteNumero,
				BolRegimenComprobanteFecha,			
				
					BolDatoAdicional1,
				BolDatoAdicional2,
				BolDatoAdicional3,
				BolDatoAdicional4,
				BolDatoAdicional5,
				BolDatoAdicional6,
				BolDatoAdicional7,
				BolDatoAdicional8,
				BolDatoAdicional9,
				BolDatoAdicional10,
				
				BolDatoAdicional11,
				BolDatoAdicional12,
				BolDatoAdicional13,
				BolDatoAdicional14,
				BolDatoAdicional15,
				BolDatoAdicional16,
				BolDatoAdicional17,
				BolDatoAdicional18,
				BolDatoAdicional19,
				BolDatoAdicional20,
				
				BolDatoAdicional21,
				BolDatoAdicional22,
				BolDatoAdicional23,
				BolDatoAdicional24,
				BolDatoAdicional25,
				BolDatoAdicional26,
				
				BolDatoAdicional27,
				BolDatoAdicional28,
				
				BolUsuario,
				BolVendedor,
				BolNumeroPedido,
				
				BolCancelado,
				
				BolObservado,
				BolTiempoCreacion,
				BolTiempoModificacion
				
				) 
				VALUES (
				"'.($this->BolId).'", 
				"'.($this->BtaId).'",
				"'.($this->SucId).'",
				
				"'.($this->UsuId).'",
				"'.($this->CliId).'",
	
				"'.($this->NpaId).'",
				
				'.(empty($this->AmoId)?'NULL, ':'"'.$this->AmoId.'",').'
				'.(empty($this->OvvId)?'NULL, ':'"'.$this->OvvId.'",').'
				'.(empty($this->FccId)?'NULL, ':'"'.$this->FccId.'",').'
				
				'.(empty($this->PagId)?'NULL, ':'"'.$this->PagId.'",').'
				
				"'.($this->BolFechaEmision).'",
				'.(empty($this->BolFechaVencimiento)?'NULL, ':'"'.$this->BolFechaVencimiento.'",').'
				
				'.($this->BolPorcentajeImpuestoVenta).',
				'.($this->BolPorcentajeImpuestoSelectivo).',
				"'.($this->BolDireccion).'",
				'.($this->BolTotalBruto).',		
				
				'.($this->BolTotalImpuestoSelectivo).',
				'.($this->BolTotalPagar).',
				'.($this->BolTotalExonerado).',
				'.($this->BolTotalDescuento).',
				'.($this->BolTotalGratuito).',
				'.($this->BolTotalGravado).',
					
				'.($this->BolSubTotal).',
				'.($this->BolImpuesto).',
				'.($this->BolTotal).',			
				"'.($this->BolObservacion).'",
				"'.($this->BolObservacionCaja).'",
				
				"'.($this->BolLeyenda).'", 
				
				'.($this->BolCantidadDia).',
				"'.($this->MonId).'",
				'.(empty($this->BolTipoCambio)?'NULL, ':''.$this->BolTipoCambio.',').'
				'.($this->BolObsequio).',
				'.($this->BolEstado).',
				2, 
				
				'.(empty($this->RegId)?'NULL, ':'"'.$this->RegId.'",').'
				'.(empty($this->BolRegimenPorcentaje)?'NULL, ':''.$this->BolRegimenPorcentaje.',').'
				'.(empty($this->BolRegimenMonto)?'NULL, ':''.$this->BolRegimenMonto.',').'
				"'.($this->BolRegimenComprobanteNumero).'", 
				'.(empty($this->BolRegimenComprobanteFecha)?'NULL, ':'"'.$this->BolRegimenComprobanteFecha.'",').'
				
					"'.($this->BolDatoAdicional1).'", 
				"'.($this->BolDatoAdicional2).'", 
				"'.($this->BolDatoAdicional3).'", 
				"'.($this->BolDatoAdicional4).'", 
				"'.($this->BolDatoAdicional5).'", 
				"'.($this->BolDatoAdicional6).'", 
				"'.($this->BolDatoAdicional7).'", 
				"'.($this->BolDatoAdicional8).'", 
				"'.($this->BolDatoAdicional9).'", 
				"'.($this->BolDatoAdicional10).'", 
				
				"'.($this->BolDatoAdicional11).'", 
				"'.($this->BolDatoAdicional12).'", 
				"'.($this->BolDatoAdicional13).'", 
				"'.($this->BolDatoAdicional14).'", 
				"'.($this->BolDatoAdicional15).'", 
				"'.($this->BolDatoAdicional16).'", 
				"'.($this->BolDatoAdicional17).'", 
				"'.($this->BolDatoAdicional18).'", 
				"'.($this->BolDatoAdicional19).'", 
				"'.($this->BolDatoAdicional20).'", 
				
				"'.($this->BolDatoAdicional21).'", 
				"'.($this->BolDatoAdicional22).'", 
				"'.($this->BolDatoAdicional23).'", 
				"'.($this->BolDatoAdicional24).'", 
				"'.($this->BolDatoAdicional25).'", 
				"'.($this->BolDatoAdicional26).'", 
				
				
				"'.($this->BolDatoAdicional27).'", 
				"'.($this->BolDatoAdicional28).'", 
				
				
				
				"'.($this->BolUsuario).'", 
				"'.($this->BolVendedor).'", 
				"'.($this->BolNumeroPedido).'", 
				
				2,
				
				"'.($this->BolObservado).'", 
				"'.($this->BolTiempoCreacion).'", 
				"'.($this->BolTiempoModificacion).'");';
	

			
			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				if(!$resultado) {							
					$error = true;
					
					switch($this->InsMysql->MtdObtenerErrorCodigo()){
						case 1062:					
							$Resultado.="#ERR_BOL_402";
						break;
					}
				} 
			}
			
				
				if(!$error){			
				
					if (!empty($this->BoletaDetalle)){		
							
						$validar = 0;				
						$InsBoletaDetalle = new ClsBoletaDetalle($this->InsMysql);		
								
						foreach ($this->BoletaDetalle as $DatBoletaDetalle){
							$InsBoletaDetalle->BolId = $this->BolId;
							$InsBoletaDetalle->BtaId = $this->BtaId;

							$InsBoletaDetalle->OdeId = $DatBoletaDetalle->OdeId;							
							$InsBoletaDetalle->VdeId = $DatBoletaDetalle->VdeId;																				
							$InsBoletaDetalle->AmdId = $DatBoletaDetalle->AmdId;							
							$InsBoletaDetalle->VmdId = $DatBoletaDetalle->VmdId;
							
							$InsBoletaDetalle->BdeTipo = $DatBoletaDetalle->BdeTipo;							
							
							$InsBoletaDetalle->BdeCodigo= $DatBoletaDetalle->BdeCodigo;
							$InsBoletaDetalle->BdeDescripcion = $DatBoletaDetalle->BdeDescripcion;
							$InsBoletaDetalle->BdeUnidadMedida = $DatBoletaDetalle->BdeUnidadMedida;
							
							$InsBoletaDetalle->BdePrecio = $DatBoletaDetalle->BdePrecio;
							$InsBoletaDetalle->BdeCantidad = $DatBoletaDetalle->BdeCantidad;
							$InsBoletaDetalle->BdeImporte = $DatBoletaDetalle->BdeImporte;
							
							$InsBoletaDetalle->BdeValorVenta = $DatBoletaDetalle->BdeValorVenta;
							$InsBoletaDetalle->BdeImpuesto = $DatBoletaDetalle->BdeImpuesto;
							$InsBoletaDetalle->BdeImpuestoSelectivo = $DatBoletaDetalle->BdeImpuestoSelectivo;
							$InsBoletaDetalle->BdeDescuento = $DatBoletaDetalle->BdeDescuento;																			
							$InsBoletaDetalle->BdeGratuito = $DatBoletaDetalle->BdeGratuito;
							$InsBoletaDetalle->BdeExonerado = $DatBoletaDetalle->BdeExonerado;
							$InsBoletaDetalle->BdeIncluyeSelectivo = $DatBoletaDetalle->BdeIncluyeSelectivo;
							
							$InsBoletaDetalle->BdeEstado = $this->BolEstado;
							$InsBoletaDetalle->BdeTiempoCreacion = $DatBoletaDetalle->BdeTiempoCreacion;
							$InsBoletaDetalle->BdeTiempoModificacion = $DatBoletaDetalle->BdeTiempoModificacion;						
							$InsBoletaDetalle->BdeEliminado = $DatBoletaDetalle->BdeEliminado;
							
							if($InsBoletaDetalle->MtdRegistrarBoletaDetalle()){
								$validar++;					
							}else{
								$Resultado.='#ERR_BOL_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->BoletaDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
				


if(!$error){			
				
					if (!empty($this->BoletaAlmacenMovimiento)){		
							
						$validar = 0;				
						$InsBoletaAlmacenMovimiento = new ClsBoletaAlmacenMovimiento($this->InsMysql);		
								
						foreach ($this->BoletaAlmacenMovimiento as $DatBoletaAlmacenMovimiento){
						
							$InsBoletaAlmacenMovimiento->BolId = $this->BolId;
							$InsBoletaAlmacenMovimiento->BtaId = $this->BtaId;
							
							$InsBoletaAlmacenMovimiento->AmoId = $DatBoletaAlmacenMovimiento->AmoId;
							$InsBoletaAlmacenMovimiento->VmvId = $DatBoletaAlmacenMovimiento->VmvId;
							
							$InsBoletaAlmacenMovimiento->BamEstado = $DatBoletaAlmacenMovimiento->BamEstado;
							$InsBoletaAlmacenMovimiento->BamTiempoCreacion = $DatBoletaAlmacenMovimiento->BamTiempoCreacion;
							$InsBoletaAlmacenMovimiento->BamTiempoModificacion = $DatBoletaAlmacenMovimiento->BamTiempoModificacion;						
							$InsBoletaAlmacenMovimiento->BamEliminado = $DatBoletaAlmacenMovimiento->BamEliminado;
							
							if($InsBoletaAlmacenMovimiento->MtdRegistrarBoletaAlmacenMovimiento()){
								$validar++;					
							}else{								
								//$Resultado.='#ERR_BOL_201';
								//$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->BoletaAlmacenMovimiento) <> $validar ){
							$error = true;
						}					
									
					}				
				}
		

			if($error) {	

				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarBoleta(1,"Se registro la Boleta",$this);			
				return true;
			}			
			
	}
	
	public function MtdEditarBoleta() {
		
			global $Resultado;
			$error = false;

		//if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->BolFechaEmision))){
//			$error = true;
//			$Resultado.='#ERR_BOL_400';
//		}else{
		
			$this->InsMysql->MtdTransaccionIniciar();
			
				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->CcaId = "CCA-10000";
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->BolDireccion;
				$InsCliente->CliEstado = 1;//En actividad
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
				$InsCliente->CliEliminado = 1;
			
				if(empty($InsCliente->CliId)){
					
					$InsCliente->MtdGenerarClienteId();	

					if(!$InsCliente->MtdRegistrarClienteDeBoleta()){
						$error = true;
						$Resultado.='#ERR_BOL_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
					
				}else{
					
				/*	if(!$InsCliente->MtdEditarClienteDato("CliDireccion",$InsCliente->CliDireccion,$InsCliente->CliId)){
						$error = true;					
						$Resultado.='#ERR_BOL_302';
					}*/
					
				}	
			
				$sql = 'UPDATE tblbolboleta SET 
				CliId = "'.($this->CliId).'",
				NpaId = "'.($this->NpaId).'",
				
				BolFechaEmision = "'.($this->BolFechaEmision).'",	
				'.(empty($this->BolFechaVencimiento)?'BolFechaVencimiento = NULL, ':'BolFechaVencimiento = "'.$this->BolFechaVencimiento.'",').'
			
			
				BolPorcentajeImpuestoVenta = '.($this->BolPorcentajeImpuestoVenta).',
				BolPorcentajeImpuestoSelectivo = '.($this->BolPorcentajeImpuestoSelectivo).',
				BolDireccion = "'.($this->BolDireccion).'",
				MonId = "'.($this->MonId).'",
				'.(empty($this->BolTipoCambio)?'BolTipoCambio = NULL, ':'BolTipoCambio = "'.$this->BolTipoCambio.'",').'
				
				BolTotalBruto = '.($this->BolTotalBruto).',
				
				BolTotalImpuestoSelectivo = '.($this->BolTotalImpuestoSelectivo).',
				BolTotalPagar = '.($this->BolTotalPagar).',
				BolTotalExonerado = '.($this->BolTotalExonerado).',
				BolTotalDescuento = '.($this->BolTotalDescuento).',
				BolTotalGratuito = '.($this->BolTotalGratuito).',
				BolTotalGravado = '.($this->BolTotalGravado).',
				
				BolSubTotal = '.($this->BolSubTotal).',
				BolImpuesto = '.($this->BolImpuesto).',
				BolTotal = '.($this->BolTotal).',
				
				BolObservacion = "'.($this->BolObservacion).'",
				BolObservacionCaja = "'.($this->BolObservacionCaja).'",
				BolLeyenda = "'.($this->BolLeyenda).'",
				
				BolCantidadDia = "'.($this->BolCantidadDia).'",	
				BolObsequio = '.($this->BolObsequio).',		
				BolEstado = '.($this->BolEstado).',
				
				'.(empty($this->BolTipoCambio)?'RegId = NULL, ':'RegId = "'.$this->BolTipoCambio.'",').'
				'.(empty($this->BolRegimenPorcentaje)?'BolRegimenPorcentaje = NULL, ':'BolRegimenPorcentaje = "'.$this->BolRegimenPorcentaje.'",').'
				'.(empty($this->BolRegimenMonto)?'BolRegimenMonto = NULL, ':'BolRegimenMonto = "'.$this->BolRegimenMonto.'",').'
			BolRegimenComprobanteNumero = "'.($this->BolRegimenComprobanteNumero).'",
			'.(empty($this->BolRegimenComprobanteFecha)?'BolRegimenComprobanteFecha = NULL, ':'BolRegimenComprobanteFecha = "'.$this->BolRegimenComprobanteFecha.'",').'
			
			
			BolDatoAdicional1 = "'.($this->BolDatoAdicional1).'",
			BolDatoAdicional2 = "'.($this->BolDatoAdicional2).'",
			BolDatoAdicional3 = "'.($this->BolDatoAdicional3).'",
			BolDatoAdicional4 = "'.($this->BolDatoAdicional4).'",
			BolDatoAdicional5 = "'.($this->BolDatoAdicional5).'",
			BolDatoAdicional6 = "'.($this->BolDatoAdicional6).'",
			BolDatoAdicional7 = "'.($this->BolDatoAdicional7).'",
			BolDatoAdicional8 = "'.($this->BolDatoAdicional8).'",
			BolDatoAdicional9 = "'.($this->BolDatoAdicional9).'",
			BolDatoAdicional10 = "'.($this->BolDatoAdicional10).'",
			
			BolDatoAdicional11 = "'.($this->BolDatoAdicional11).'",
			BolDatoAdicional12 = "'.($this->BolDatoAdicional12).'",
			BolDatoAdicional13 = "'.($this->BolDatoAdicional13).'",
			BolDatoAdicional14 = "'.($this->BolDatoAdicional14).'",
			BolDatoAdicional15 = "'.($this->BolDatoAdicional15).'",
			BolDatoAdicional16 = "'.($this->BolDatoAdicional16).'",
			BolDatoAdicional17 = "'.($this->BolDatoAdicional17).'",
			BolDatoAdicional18 = "'.($this->BolDatoAdicional18).'",
			BolDatoAdicional19 = "'.($this->BolDatoAdicional19).'",
			BolDatoAdicional20 = "'.($this->BolDatoAdicional20).'",
			
			BolDatoAdicional21 = "'.($this->BolDatoAdicional21).'",
			BolDatoAdicional22 = "'.($this->BolDatoAdicional22).'",
			BolDatoAdicional23 = "'.($this->BolDatoAdicional23).'",
			BolDatoAdicional24 = "'.($this->BolDatoAdicional24).'",
			BolDatoAdicional25 = "'.($this->BolDatoAdicional25).'",
			BolDatoAdicional26 = "'.($this->BolDatoAdicional26).'",
			
			BolDatoAdicional27 = "'.($this->BolDatoAdicional27).'",
			BolDatoAdicional28 = "'.($this->BolDatoAdicional28).'",
			
			
			BolNumeroPedido = "'.($this->BolNumeroPedido).'",
			BolUsuario = "'.($this->BolUsuario).'",
			BolVendedor = "'.($this->BolVendedor).'",
			
			BolObservado = "'.($this->BolObservado).'",
			
				BolTiempoModificacion = "'.($this->BolTiempoModificacion).'"			
				WHERE BolId = "'.($this->BolId).'"
				AND BtaId = "'.$this->BtaId.'";';
				
				

			
			
			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				if(!$resultado) {							
					$error = true;
				} 
			}
	
				if(!$error){
				
					if (!empty($this->BoletaDetalle)){		
							
							
						$validar = 0;				
						$InsBoletaDetalle = new ClsBoletaDetalle($this->InsMysql);		
								
						foreach ($this->BoletaDetalle as $DatBoletaDetalle){
											
							$InsBoletaDetalle->BdeId = $DatBoletaDetalle->BdeId;
							$InsBoletaDetalle->BolId = $this->BolId;
							$InsBoletaDetalle->BtaId = $this->BtaId;
							
							$InsBoletaDetalle->OdeId = $DatBoletaDetalle->OdeId;
							$InsBoletaDetalle->AmdId = $DatBoletaDetalle->AmdId;
							$InsBoletaDetalle->VmdId = $DatBoletaDetalle->VmdId;
							$InsBoletaDetalle->VdeId = $DatBoletaDetalle->VdeId;
					
							$InsBoletaDetalle->BdeTipo = $DatBoletaDetalle->BdeTipo;
							
							$InsBoletaDetalle->BdeCodigo= $DatBoletaDetalle->BdeCodigo;
							$InsBoletaDetalle->BdeDescripcion = $DatBoletaDetalle->BdeDescripcion;							
							$InsBoletaDetalle->BdeUnidadMedida = $DatBoletaDetalle->BdeUnidadMedida;
							
							$InsBoletaDetalle->BdeCantidad = $DatBoletaDetalle->BdeCantidad;
							$InsBoletaDetalle->BdePrecio = $DatBoletaDetalle->BdePrecio;
							$InsBoletaDetalle->BdeImporte = $DatBoletaDetalle->BdeImporte;
							
							$InsBoletaDetalle->BdeValorVenta = $DatBoletaDetalle->BdeValorVenta;
							$InsBoletaDetalle->BdeImpuesto = $DatBoletaDetalle->BdeImpuesto;
							$InsBoletaDetalle->BdeImpuestoSelectivo = $DatBoletaDetalle->BdeImpuestoSelectivo;
							$InsBoletaDetalle->BdeDescuento = $DatBoletaDetalle->BdeDescuento;
							
							$InsBoletaDetalle->BdeGratuito = $DatBoletaDetalle->BdeGratuito;
							$InsBoletaDetalle->BdeExonerado = $DatBoletaDetalle->BdeExonerado;
							$InsBoletaDetalle->BdeIncluyeSelectivo = $DatBoletaDetalle->BdeIncluyeSelectivo;
							
							$InsBoletaDetalle->BdeEstado = $InsBoleta->BolEstado;							
							$InsBoletaDetalle->BdeTiempoCreacion = $DatBoletaDetalle->BdeTiempoCreacion;
							$InsBoletaDetalle->BdeTiempoModificacion = $DatBoletaDetalle->BdeTiempoModificacion;
							$InsBoletaDetalle->BdeEliminado = $DatBoletaDetalle->BdeEliminado;
							
							if(empty($InsBoletaDetalle->BdeId)){
								if($InsBoletaDetalle->BdeEliminado<>2){
									if($InsBoletaDetalle->MtdRegistrarBoletaDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_BOL_201';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}else{
									$validar++;	
								}
							}else{						
								if($InsBoletaDetalle->BdeEliminado==2){
									if($InsBoletaDetalle->MtdEliminarBoletaDetalle($InsBoletaDetalle->BdeId)){
										$validar++;					
									}else{
										$Resultado.='#ERR_BOL_203';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}else{
									if($InsBoletaDetalle->MtdEditarBoletaDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_BOL_202';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}
							}									
						}
						
						
						if(count($this->BoletaDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
						
					
					




if(!$error){
			
				if (!empty($this->BoletaAlmacenMovimiento)){		
						
					$validar = 0;	
					foreach ($this->BoletaAlmacenMovimiento as $DatBoletaAlmacenMovimiento){
							
						$InsBoletaAlmacenMovimiento = new ClsBoletaAlmacenMovimiento($this->InsMysql);	
						$InsBoletaAlmacenMovimiento->BamId = $DatBoletaAlmacenMovimiento->BamId;
						$InsBoletaAlmacenMovimiento->BolId = $this->BolId;
						$InsBoletaAlmacenMovimiento->BtaId = $this->BtaId;
						
						$InsBoletaAlmacenMovimiento->AmoId = $DatBoletaAlmacenMovimiento->AmoId;
						$InsBoletaAlmacenMovimiento->VmvId = $DatBoletaAlmacenMovimiento->VmvId;
						
						$InsBoletaAlmacenMovimiento->BamEstado = $DatBoletaAlmacenMovimiento->BamEstado;
						$InsBoletaAlmacenMovimiento->BamTiempoCreacion = $DatBoletaAlmacenMovimiento->BamTiempoCreacion;
						$InsBoletaAlmacenMovimiento->BamTiempoModificacion = $DatBoletaAlmacenMovimiento->BamTiempoModificacion;						
						$InsBoletaAlmacenMovimiento->BamEliminado = $DatBoletaAlmacenMovimiento->BamEliminado;
						
						if(empty($InsBoletaAlmacenMovimiento->BamId)){
							if($InsBoletaAlmacenMovimiento->BamEliminado<>2){
								if($InsBoletaAlmacenMovimiento->MtdRegistrarBoletaAlmacenMovimiento()){
									$validar++;					
								}else{
									$Resultado.='#ERR_BOL_211';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;		
							}
						}else{						
							if($InsBoletaAlmacenMovimiento->BamEliminado==2){
								if($InsBoletaAlmacenMovimiento->MtdEliminarBoletaAlmacenMovimiento($InsBoletaAlmacenMovimiento->BamId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_BOL_213';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								//if($InsBoletaAlmacenMovimiento->MtdEditarBoletaAlmacenMovimiento()){
									$validar++;					
								//}else{
								//	$Resultado.='#ERR_BOL_212';
								//	$Resultado.='#Item Numero: '.($validar+1);
								//}
							}
						}									
					}
					
					if(count($this->BoletaAlmacenMovimiento) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
				
				
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				$this->MtdAuditarBoleta(2,"Se edito la Boleta",$this);		
				return true;
			}	
		
			
		
		}	
		
		public function MtdEditarIdBoleta() {
		
			
			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			$sql = 'UPDATE tblbolboleta SET 
			BolId = "'.($this->NBolId).'",
			BolTiempoModificacion = "'.($this->BolTiempoModificacion).'"
			WHERE BolId = "'.($this->BolId).'"
			AND BtaId = "'.$this->BtaId.'";';
						
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			if(!$resultado) {							
				$error = true;
			} 			
	
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();		
				
				
				$this->MtdAuditarBoleta(2,"Se edito el Codigo de la Boleta",$this);							
				return true;
			}	
		
			
		
		}	
		
		
		
		
		
	public function MtdVerificarExisteAlmacenMovimientoSalidaId($oAlmacenMovimientoSalidaId){
		
		$Boleta = array();
		
        $sql = 'SELECT 
		bol.BolId,
		bol.BtaId
        FROM tblbolboleta bol
        WHERE  bol.AmoId = "'.$oAlmacenMovimientoSalidaId.'" 
		AND bol.BolEstado <> 6
		LIMIT 1;';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				$Boleta[]  = $fila['BolId'];
				$Boleta[]  = $fila['BtaId'];
			}
		}
		return $Boleta ;

	}
			
		
		
		
			public function MtdEditarBoletaDato($oCampo,$oDato,$oId,$oTalonario) {

			$sql = 'UPDATE tblbolboleta SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			BolTiempoModificacion = NOW()
			WHERE BolId = "'.($oId).'"
			AND BtaId = "'.($oTalonario).'"
			;';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}
		
		public function MtdEditarBoletaCancelado($oId,$oTalonario,$oCancelado) {

			$sql = 'UPDATE tblbolboleta SET 
			BolCancelado = '.$oCancelado.',
			
			
			BolTiempoModificacion = NOW()
			WHERE BolId = "'.($oId).'"
			AND BtaId = "'.($oTalonario).'"
			;';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}
		
		private function MtdAuditarBoleta($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->BolId;
			$InsAuditoria->AudCodigoExtra = $this->BtaId;
			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		
		
		
		
		
		
		
		public function MtdBoletaGenerarArchivoXML($oTalonario,$oId,$oRuta="") {
		
			global $EmpresaCodigo;
			global $EmpresaNombre;
			global $EmpresaDireccion;
			global $EmpresaMonedaId;
			
			if(!empty($oTalonario) and !empty($oId)){
				
				
				$this->BolId = $oId;
				$this->BtaId = $oTalonario;
				$this->MtdObtenerBoleta(true);
				
				$InsBoleta = $this;

										
				/*
				* CODIGO XML - INICIO
				*/ 
						
				//deb($InsBoleta->BolTipoCambio);
				if($InsBoleta->MonId<>$EmpresaMonedaId){
					
					$InsBoleta->BolTotalGravado = round($InsBoleta->BolTotalGravado/$InsBoleta->BolTipoCambio,2);
					$InsBoleta->BolTotalExonerado = round($InsBoleta->BolTotalExonerado/$InsBoleta->BolTipoCambio,2);
					$InsBoleta->BolTotalGratuito = round($InsBoleta->BolTotalGratuito/$InsBoleta->BolTipoCambio,2);
					$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);
				
					
					$InsBoleta->BolTotalPagar = round($InsBoleta->BolTotalPagar/$InsBoleta->BolTipoCambio,2);
					//$InsBoleta->BolTotalDescuento = round($InsBoleta->BolTotalDescuento/$InsBoleta->BolTipoCambio,2);
					
					$InsBoleta->BolSubTotal = round($InsBoleta->BolSubTotal/$InsBoleta->BolTipoCambio,2);	
					$InsBoleta->BolImpuesto = round($InsBoleta->BolImpuesto/$InsBoleta->BolTipoCambio,2);
					$InsBoleta->BolTotal = round($InsBoleta->BolTotal/$InsBoleta->BolTipoCambio,2);	
					$InsBoleta->BolTotalImpuestoSelectivo = round($InsBoleta->BolTotalImpuestoSelectivo/$InsBoleta->BolTipoCambio,2);
					
				}
				
				$InsBoleta->CliNombre = trim($InsBoleta->CliNombre);
				$InsBoleta->CliApellidoPaterno = trim($InsBoleta->CliApellidoPaterno);
				$InsBoleta->CliApellidoMaterno = trim($InsBoleta->CliApellidoMaterno);
				
				$InsSucursal = new ClsSucursal();
				$InsSucursal->SucId = $InsBoleta->SucId;
				$InsSucursal->MtdObtenerSucursal();
				
				$InsBoleta->BolTotal = round($InsBoleta->BolTotal,2);
				list($parte_entero,$parte_decimal) = explode(".",$InsBoleta->BolTotal);
				
				if(empty($parte_decimal)){
					$parte_decimal = 0;
				}
				
				$parte_decimal = str_pad($parte_decimal, 2, "0", STR_PAD_RIGHT);
				
				$numalet= new CNumeroaletra;
				$numalet->setNumero($parte_entero);
				$numalet->setMayusculas(1);
				$numalet->setGenero(1);
				$numalet->setMoneda("");
				$numalet->setPrefijo("");
				$numalet->setSufijo("");
				
				$BoletaTotalLetras = "SON ".$numalet->letra()." CON ".$parte_decimal."/100 ".$InsBoleta->MonNombre;
				
				$NOMBRE = $EmpresaCodigo.'-03-'.$InsBoleta->BtaNumero.'-'.$InsBoleta->BolId;
				$ARCHIVO = $NOMBRE.'.xml';
				
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
				////$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolSubTotal,2, '.', ''));
				//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalGravado,2, '.', ''));
				//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
				//
				/////'cbc:ID','1003'	//TOTAL EXONERADAS
				////sac:AdditionalMonetaryTotal
				//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
				//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
				//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1003'));
				//
				////sac:PayableAmount
				//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalExonerado,2, '.', ''));
				//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
				//
				////'cbc:ID','1004'	//TOTAL GRATUITAS
				////sac:AdditionalMonetaryTotal
				//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
				//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
				//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','1004'));
				//
				////sac:PayableAmount
				//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalGratuito,2, '.', ''));
				//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				//$PayableAmount = $AdditionalMonetaryTotal->appendChild($PayableAmount);
				//
				////'cbc:ID','2005' //TOTAL DESCUENTOS
				////sac:AdditionalMonetaryTotal
				//$AdditionalMonetaryTotal = $domtree->createElement("sac:AdditionalMonetaryTotal");
				//$AdditionalMonetaryTotal = $AdditionalInformation->appendChild($AdditionalMonetaryTotal);
				//$AdditionalMonetaryTotal->appendChild($domtree->createElement('cbc:ID','2005'));
				//
				////sac:PayableAmount
				//$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
				//$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
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
				//$Value = $domtree->createElement("cbc:Value",$BoletaTotalLetras);
				//$Value = $AdditionalProperty->appendChild($Value);
				//
				//
				//if(!empty($InsBoleta->BolLeyenda)){
				//
				//
				/////'cbc:ID','1002' //LEYENDA
				////sac:AdditionalProperty
				//$AdditionalProperty = $domtree->createElement("sac:AdditionalProperty");
				//$AdditionalProperty = $AdditionalInformation->appendChild($AdditionalProperty);
				//$AdditionalProperty->appendChild($domtree->createElement('cbc:ID','1002'));
				//
				////cbc:Value
				//$Value = $domtree->createElement("cbc:Value",$InsBoleta->BolLeyenda);
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
				$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.1");
				$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);
				
				//ext:CustomizationID
				$CustomizationID = $domtree->createElement("cbc:CustomizationID","2.0");
				$CustomizationID = $xmlRoot->appendChild($CustomizationID);
				
				//cbc:ID
				$ID = $domtree->createElement("cbc:ID",$InsBoleta->BtaNumero."-".$InsBoleta->BolId);
				$ID = $xmlRoot->appendChild($ID);
				
				//cbc:IssueDate
				$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsBoleta->BolFechaEmision));
				$IssueDate = $xmlRoot->appendChild($IssueDate);
				//cbc:IssueTime
				$IssueTime = $domtree->createElement("cbc:IssueTime",($InsBoleta->BolHoraEmision));
				$IssueTime = $xmlRoot->appendChild($IssueTime);
				
				//cbc:InvoiceTypeCode
				//$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","01");
				//$InvoiceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
				//$InvoiceTypeCode->setAttribute('listName', "SUNAT:Identificador de Tipo de Documento");
				//$InvoiceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
				//$InvoiceTypeCode = $xmlRoot->appendChild($InvoiceTypeCode);
				$InvoiceTypeCode = $domtree->createElement("cbc:InvoiceTypeCode","03");
				$InvoiceTypeCode->setAttribute('listID', "0101");
				$InvoiceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
				$InvoiceTypeCode->setAttribute('listName', "SUNAT:Identificador de Tipo de Documento");
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
				//$Note = $domtree->createElement("cbc:Note",$domtree->createCDATASection($BoletaTotalLetras));
				$Note = $domtree->createElement("cbc:Note",($BoletaTotalLetras));
				$Note->setAttribute('languageLocaleID', "1000");
				$Note = $xmlRoot->appendChild($Note);
					
				////cbc:DocumentCurrencyCode
				//$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsBoleta->MonSigla);
				//$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);
				
				//cbc:DocumentCurrencyCode
				$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsBoleta->MonSigla);
				$DocumentCurrencyCode->setAttribute('listID', "ISO 4217 Alpha");
				$DocumentCurrencyCode->setAttribute('listName', "Currency");
				$DocumentCurrencyCode->setAttribute('listAgencyName', "United Nations Economic Commission for Europe");
				$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);
				
				
				
				/*<cac:DespatchDocumentReference>
					<cbc:ID>0001-0000008</cbc:ID>
					<cbc:DocumentTypeCode listAgencyName="PE:SUNAT" listName="SUNAT:Identificador de guíarelacionada" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01">09</cbc:DocumentTypeCode>
				</cac:DespatchDocumentReference>
				*/
				
				
				if(!empty($InsBoleta->BolGuiaRemisionNumero)){
					
					//cac:DespatchDocumentReference
					$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
					$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
								
						//cbc:ID
						$ID = $domtree->createElement("cbc:ID",$InsBoleta->BolGuiaRemisionNumero);
						$ID = $DespatchDocumentReference->appendChild($ID);
						
						//cbc:DocumentTypeCode
						$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("09"));
						$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
						$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
						$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
						$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);	
						
						
				}
				
				if(!empty($InsBoleta->BolGuiaRemisionTransportistaNumero)){
					
					//cac:DespatchDocumentReference
					$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
					$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
								
						//cbc:ID
						$ID = $domtree->createElement("cbc:ID",$InsBoleta->BolGuiaRemisionTransportistaNumero);
						$ID = $DespatchDocumentReference->appendChild($ID);
						
						//cbc:DocumentTypeCode
						$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",("09"));
						$DocumentTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
						$DocumentTypeCode->setAttribute('listName', "SUNAT:Identificador de guía relacionada");
						$DocumentTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01");
						$DocumentTypeCode = $DespatchDocumentReference->appendChild($DocumentTypeCode);	
						
						
				}
//if(!empty($InsBoleta->BolGuiaRemisionTransportistaNumero)){
//	
//	//cac:DespatchDocumentReference
//	$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
//	$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);
//				
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsBoleta->BolGuiaRemisionTransportistaNumero);
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

/*<?php echo $InsBoleta->GrtNumero;?> - <?php echo $InsBoleta->GreId;?>
*/
//if(!empty($InsBoleta->GreId)){
//	
//	//cac:DespatchDocumentReference
//	$DespatchDocumentReference = $domtree->createElement("cac:DespatchDocumentReference");
//	$DespatchDocumentReference = $xmlRoot->appendChild($DespatchDocumentReference);
//		
//		//cbc:ID
//		$ID = $domtree->createElement("cbc:ID",$InsBoleta->GrtNumero."-".$InsBoleta->GreId);
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
	$ID = $domtree->createElement("cbc:ID","IDSignSP");
	$ID = $Signature->appendChild($ID);
	
	//cac:SignatoryParty
	$SignatoryParty = $domtree->createElement("cac:SignatoryParty");
	$SignatoryParty = $Signature->appendChild($SignatoryParty);
	
		//cac:PartyIdentification
		$PartyIdentification = $domtree->createElement("cac:PartyIdentification");
		$PartyIdentification = $SignatoryParty->appendChild($PartyIdentification);
	
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$EmpresaCodigo);
			$ID = $PartyIdentification->appendChild($ID);
		
		//cac:PartyName
		$base = $SignatoryParty->appendChild($domtree->createElement( 'cac:PartyName' ));
			
			//cac:Name		
			$name = $base->appendChild($domtree->createElement('cbc:Name')); 
			$name->appendChild($domtree->createCDATASection( $EmpresaNombre )); 

	//cbc:ID
	$DigitalSignatureAttachment = $domtree->createElement("cac:DigitalSignatureAttachment");
	$DigitalSignatureAttachment = $Signature->appendChild($DigitalSignatureAttachment);

		//cac:ExternalReference
		$ExternalReference = $domtree->createElement("cac:ExternalReference");
		$ExternalReference = $DigitalSignatureAttachment->appendChild($ExternalReference);
			
			//cbc:URI
			$URI = $domtree->createElement("cbc:URI","#SignatureSP");
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
			$CompanyID = $domtree->createElement("cbc:ID",($EmpresaCodigo));
			$CompanyID->setAttribute('schemeID', "6");
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyIdentification->appendChild($CompanyID);	


		
		//cac:PartyName
		$PartyName = $Party->appendChild($domtree->createElement( 'cac:PartyName' ));
		
			//cac:Name		
			$Name = $PartyName->appendChild($domtree->createElement('cbc:Name')); 
			$Name->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
			
			
			
						
		//cac:PartyLegalEntity
		$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
		$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
			
			 //cbc:RegistrationName		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $EmpresaNombre)); 
		
			
			
			
	
			
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
		
		
	
	
			if(count($InsBoleta->OrdenVentaVehiculoPropietario)>1){

				$Propietarios = " / ";
		
				foreach($InsBoleta->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($InsBoleta->CliId<> $DatOrdenVentaVehiculoPropietario->CliId){
		
						$Propietarios .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno."";		
						
						//if(count($InsBoleta->OrdenVentaVehiculoPropietario)-1!=$i){
//							$Propietarios .= " * ";
//						}
						
						$i++;
		
					}			
				}		
				
		
			}

	//cac:AccountingCustomerParty
	$AccountingCustomerParty = $domtree->createElement("cac:AccountingCustomerParty");
	$AccountingCustomerParty = $xmlRoot->appendChild($AccountingCustomerParty);
	
	//	//cbc:CustomerAssignedAccountID
	//	$CustomerAssignedAccountID = $domtree->createElement("cbc:CustomerAssignedAccountID",$InsBoleta->CliNumeroDocumento);
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
				$CompanyID = $domtree->createElement("cbc:ID",($InsBoleta->CliNumeroDocumento));
				$CompanyID->setAttribute('schemeID', round($InsBoleta->TdoCodigo));
				$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
				$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
				$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
				$CompanyID = $PartyIdentification->appendChild($CompanyID);	
	
							
			//cac:PartyLegalEntity
			$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
			$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
				
				 //cbc:RegistrationName		
				$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
				$RegistrationName->appendChild($domtree->createCDATASection($InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno ."".$Propietarios)); 
			
				
			/*
			//cac:PartyTaxScheme
			$PartyTaxScheme = $Party->appendChild($domtree->createElement( 'cac:PartyTaxScheme' ));
			
				//cbc:RegistrationName		
				$RegistrationName = $PartyTaxScheme->appendChild($domtree->createElement('cbc:RegistrationName')); 
				$RegistrationName->appendChild($domtree->createCDATASection( $InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno)); 
				
				//cbc:Note
				//$CompanyID = $domtree->createElement("cbc:CompanyID",$domtree->createCDATASection($InsBoleta->CliNumeroDocumento));
				$CompanyID = $domtree->createElement("cbc:CompanyID",($InsBoleta->CliNumeroDocumento));
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
		if($InsBoleta->BolPorcentajeDescuentoGlobal>0){
			
			$InsBoleta->BolPorcentajeDescuentoGlobal = round($InsBoleta->BolPorcentajeDescuentoGlobal/100,2);
			
			//cac:LegalMonetaryTotal
			$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
			$AllowanceCharge = $xmlRoot->appendChild($AllowanceCharge);
			
				//cbc:ChargeIndicator
				$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","False");
				$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
				
				//cbc:AllowanceChargeReasonCode
				$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");
				$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
				
				//cbc:MultiplierBoltorNumeric
				$MultiplierBoltorNumeric = $domtree->createElement("cbc:MultiplierBoltorNumeric",number_format($InsBoleta->BolPorcentajeDescuentoGlobal,2, '.', ''));
				$MultiplierBoltorNumeric = $AllowanceCharge->appendChild($MultiplierBoltorNumeric);
			
				//cbc:Amount
				//TOTAL DESCUENTO GLOBAL (NO ITEMS)
				$Amount = $domtree->createElement("cbc:Amount",number_format($InsBoleta->BolTotalDescuentoGlobal,2, '.', ''));
				$Amount->setAttribute('currencyID', $InsBoleta->MonSigla);
				$Amount = $AllowanceCharge->appendChild($Amount);
			
				//cbc:Amount
				//TOTAL SUMA VALORES DE VENTA
				$BaseAmount = $domtree->createElement("cbc:BaseAmount",number_format($InsBoleta->BolTotalGravado,2, '.', ''));
				$BaseAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
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
		//				$StreetName->appendChild($domtree->createCDATASection( $InsBoleta->CliDireccion )); 
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
		//		$Description->appendChild($domtree->createCDATASection( $InsBoleta->CliDireccion )); 
		//			
		//		//cac:PartyLegalEntity
		//		$PartyLegalEntity = $Party->appendChild($domtree->createElement( 'cac:PartyLegalEntity' ));
		//		
		//		//cac:Name		
		//		$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
		//		$RegistrationName->appendChild($domtree->createCDATASection( $InsBoleta->CliNombre." ".$InsBoleta->CliApellidoPaterno." ".$InsBoleta->CliApellidoMaterno )); 
				
		//cac:TaxTotal
		$TaxTotal = $domtree->createElement("cac:TaxTotal");
		$TaxTotal = $xmlRoot->appendChild($TaxTotal);
		
			//cbc:TaxAmount
			//SUMA TOTAL IGV
			$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolImpuesto,2, '.', ''));
			$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
			$TaxAmount = $TaxTotal->appendChild($TaxAmount);
					
			//cac:TaxSubtotal
			$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
			$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
				
				//cbc:TaxableAmount 
				//SUMA TOTAL GRAVADOS
				$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsBoleta->BolTotalGravado,2, '.', ''));
				$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
				
				//cbc:TaxAmount 
				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsBoleta->BolImpuesto,2, '.', ''));
				$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
				$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
				
				//cac:TaxCategory
				$TaxCategory = $domtree->createElement("cac:TaxCategory");
				$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
					
					//cbc:TaxAmount 
					$ID = $domtree->createElement("cbc:ID","S");
					$ID->setAttribute('schemeID', "UN/ECE 5305");
					$ID->setAttribute('schemeName', "Tax Category Identifier");
					$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
					$ID = $TaxCategory->appendChild($ID);
					
					//cac:TaxScheme
					$TaxScheme = $domtree->createElement("cac:TaxScheme");
					$TaxScheme = $TaxCategory->appendChild($TaxScheme);
		
		
						//cbc:TaxAmount 
						$ID = $domtree->createElement("cbc:ID","1000");
						$ID->setAttribute('schemeID', "UN/ECE 5153");
						$ID->setAttribute('schemeAgencyID', "6");
						$ID = $TaxScheme->appendChild($ID);
		
							//cbc:Name
						$Name = $domtree->createElement("cbc:Name","IGV");
						$Name = $TaxScheme->appendChild($Name);
		
						//cbc:TaxTypeCode
						$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
						$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
						
									
									
						if($InsBoleta->BolTotalExonerado>0){
						
							//SUMA TOTAL EXONERADOS
							//cac:TaxSubtotal
							$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
							$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
								
								//cbc:TaxableAmount 
								$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsBoleta->BolTotalExonerado,2, '.', ''));
								$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
								$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
								
								//cbc:TaxAmount 
								$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
								$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
								$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
								
								//cac:TaxCategory
								$TaxCategory = $domtree->createElement("cac:TaxCategory");
								$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
									
									//cbc:TaxAmount 
									$ID = $domtree->createElement("cbc:ID","E");
									$ID->setAttribute('schemeID', "UN/ECE 5305");
									$ID->setAttribute('schemeName', "Tax Category Identifier");
									$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
									$ID = $TaxCategory->appendChild($ID);
									
									//cac:TaxScheme
									$TaxScheme = $domtree->createElement("cac:TaxScheme");
									$TaxScheme = $TaxCategory->appendChild($TaxScheme);
						
										//cbc:TaxAmount 
										$ID = $domtree->createElement("cbc:ID","9997");
										$ID->setAttribute('schemeID', "UN/ECE 5153");
										$ID->setAttribute('schemeAgencyID', "6");
										$ID = $TaxScheme->appendChild($ID);
						
										//cbc:Name
										$Name = $domtree->createElement("cbc:Name","EXONERADO");
										$Name = $TaxScheme->appendChild($Name);
						
										//cbc:TaxTypeCode
										$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
										$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);	
										
												
						}
						
							
										
						if($InsBoleta->BolTotalGratuito>0){
						
							//SUMA TOTAL INAFECTO (GRATUITO)
							//cac:TaxSubtotal
							$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
							$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
								
								//cbc:TaxableAmount 
								$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsBoleta->BolTotalGratuito,2, '.', ''));
								$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
								$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
								
								//cbc:TaxAmount 
								$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
								$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
								$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
								
								//cac:TaxCategory
								$TaxCategory = $domtree->createElement("cac:TaxCategory");
								$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
									
									//cbc:TaxAmount 
									$ID = $domtree->createElement("cbc:ID","O");
									$ID->setAttribute('schemeID', "UN/ECE 5305");
									$ID->setAttribute('schemeName', "Tax Category Identifier");
									$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
									$ID = $TaxCategory->appendChild($ID);
									
									//cac:TaxScheme
									$TaxScheme = $domtree->createElement("cac:TaxScheme");
									$TaxScheme = $TaxCategory->appendChild($TaxScheme);
						
										//cbc:TaxAmount 
										$ID = $domtree->createElement("cbc:ID","9996");
										$ID->setAttribute('schemeID', "UN/ECE 5153");
										$ID->setAttribute('schemeAgencyID', "6");
										$ID = $TaxScheme->appendChild($ID);
						
										//cbc:Name
										$Name = $domtree->createElement("cbc:Name","GRA");
										$Name = $TaxScheme->appendChild($Name);
						
										//cbc:TaxTypeCode
										$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","FRE");
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
					////	$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount",number_format($InsBoleta->BolSubTotal,2, '.', ''));
					////	$TaxInclusiveAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					////	$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);
					//
					//	//cbc:AllowanceTotalAmount currencyID="PEN"
					//	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
					//	$AllowanceTotalAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					//	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
					//	
					//	//cbc:PayableAmount currencyID="PEN"
					//	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotalPagar,2, '.', ''));
					//	$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
					//	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
					//	
						
					 
					//cac:LegalMonetaryTotal
					$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
					$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);
					
						//cbc:LineExtensionAmount
						$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($InsBoleta->BolSubTotal,2, '.', ''));
						$LineExtensionAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
						$LineExtensionAmount = $LegalMonetaryTotal->appendChild($LineExtensionAmount);
						
						//cbc:TaxInclusiveAmount
						////SUMA TOTAL DE LA VENTA - OTROS CARGOS
						$TaxInclusiveAmount = $domtree->createElement("cbc:TaxInclusiveAmount",number_format($InsBoleta->BolTotal,2, '.', ''));
						$TaxInclusiveAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
						$TaxInclusiveAmount = $LegalMonetaryTotal->appendChild($TaxInclusiveAmount);
					
						//cbc:AllowanceTotalAmount 
						//SUMA TOTAL DESCUENTOS GENERAL + ITEMS
						$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsBoleta->BolTotalDescuento,2, '.', ''));
						$AllowanceTotalAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
						$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
						
						if($InsBoleta->BolTotalOtrosCargos>0){
							
							//cbc:ChargeTotalAmount 
							//SUMA TOTAL OTROS CARGOS
							$ChargeTotalAmount = $domtree->createElement("cbc:ChargeTotalAmount",number_format($InsBoleta->BolTotalOtrosCargos,2, '.', ''));
							$ChargeTotalAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
							$ChargeTotalAmount = $LegalMonetaryTotal->appendChild($ChargeTotalAmount);
							
						}
						
						//cbc:PayableAmount currencyID="PEN"
						//SUMA TOTAL DE LA VENTA
						$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsBoleta->BolTotal,2, '.', ''));
						$PayableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
						$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);
						
				$fila = 1;
				if(!empty($InsBoleta->BoletaDetalle)){
					foreach($InsBoleta->BoletaDetalle as $DatBoletaDetalle){
							
						$DatBoletaDetalle->BdeDescripcion  = trim($DatBoletaDetalle->BdeDescripcion );
						
						if($InsBoleta->MonId<>$EmpresaMonedaId ){
							
							$DatBoletaDetalle->BdeImporte = ($DatBoletaDetalle->BdeImporte / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdePrecio = ($DatBoletaDetalle->BdePrecio  / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdeValorVenta = ($DatBoletaDetalle->BdeValorVenta  / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdeValorVentaUnitario = ($DatBoletaDetalle->BdeValorVentaUnitario  / $InsBoleta->BolTipoCambio);
							
							$DatBoletaDetalle->BdeImpuesto = ($DatBoletaDetalle->BdeImpuesto  / $InsBoleta->BolTipoCambio);
							$DatBoletaDetalle->BdeValorVentaBruto = ($DatBoletaDetalle->BdeValorVentaBruto  / $InsBoleta->BolTipoCambio);
							
						}
				
						//cac:InvoiceLine
						$InvoiceLine = $domtree->createElement("cac:InvoiceLine");
						$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
							
							//cbc:ID
							$ID = $domtree->createElement("cbc:ID",$fila);
							$ID = $InvoiceLine->appendChild($ID);	
							
							//cbc:InvoicedQuantity unitCode="NIU"
							$InvoicedQuantity = $domtree->createElement("cbc:InvoicedQuantity",number_format($DatBoletaDetalle->BdeCantidad,2, '.', ''));
							
							//if($DatBoletaDetalle->BdeValidarStock==2){
				//				$InvoicedQuantity->setAttribute('unitCode', 'ZZ');
				//			}else{
				//				$InvoicedQuantity->setAttribute('unitCode', 'NIU');	
				//			}
							
							switch($DatBoletaDetalle->BdeTipo){
								
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
							$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatBoletaDetalle->BdeValorVenta,2, '.', ''));
							$LineExtensionAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
							$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
								
							//cac:PricingReference
							$PricingReference = $domtree->createElement("cac:PricingReference");
							$PricingReference = $InvoiceLine->appendChild($PricingReference);	
								
								
							//VALOR REFERENCIAL UNITARIO POR ITEM EN OPERACIONES NO ONEROSAS
							
							if($DatBoletaDetalle->BdeGratuito==1){
								
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
								
									//cbc:PriceAmount currencyID="PEN"
									$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdeValorVentaUnitario,2, '.', ''));
									$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
					
									//cbc:PriceTypeCode
									$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
									$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
									$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
									$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
									$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
								
							}else if($DatBoletaDetalle->BdeGratuito==2){
							
								//cac:AlternativeConditionPrice
								$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
								$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
										
									//cbc:PriceAmount currencyID="PEN"
									$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdePrecio,2, '.', ''));
									$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
					
									//cbc:PriceTypeCode
									$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
									$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
									$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
									$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
									$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
								
							}
							
							//DESCUENTOS POR ITEM	
						
							if($DatBoletaDetalle->BdeDescuento>0){
								
								$DatBoletaDetalle->BdePorcentajeDescuento = round($DatBoletaDetalle->BdePorcentajeDescuento/100,2);
								
								//cac:AllowanceCharge
								$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
								$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
												
									//cbc:ChargeIndicator
									$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","false");
									$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
									
									//cbc:AllowanceChargeReasonCode
									$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");//X
									$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
												
									////cbc:MultiplierBoltorNumeric
				//					$MultiplierBoltorNumeric = $domtree->createElement("cbc:MultiplierBoltorNumeric",$DatBoletaDetalle->BdePorcentajeDescuento);//X
				//					$MultiplierBoltorNumeric = $AllowanceCharge->appendChild($MultiplierBoltorNumeric);
													
									//cbc:Amount
									$Amount = $domtree->createElement("cbc:Amount",number_format($DatBoletaDetalle->BdeDescuento,2, '.', ''));
									$Amount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$Amount = $AllowanceCharge->appendChild($Amount);		
									
									//cbc:BaseAmount
									$BaseAmount = $domtree->createElement("cbc:BaseAmount",number_format($DatBoletaDetalle->BdeValorVentaBruto,2, '.', ''));					
									$BaseAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
									
									
							}
									
						//OTROS CARGOS POR ITEM	
						// NO SE USA
							if($DatBoletaDetalle->BdeOtroCargo>0){
								
								$DatBoletaDetalle->BdePorcentajeOtroCargo = round($DatBoletaDetalle->BdePorcentajeOtroCargo/100,2);
								
								//cac:AllowanceCharge
								$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
								$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
												
									//cbc:ChargeIndicator
									$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","true");
									$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
									
									//cbc:AllowanceChargeReasonCode
									$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","5");//X
									$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
												
									////cbc:MultiplierBoltorNumeric
				//					$MultiplierBoltorNumeric = $domtree->createElement("cbc:MultiplierBoltorNumeric",$DatBoletaDetalle->BdePorcentajeDescuento);//X
				//					$MultiplierBoltorNumeric = $AllowanceCharge->appendChild($MultiplierBoltorNumeric);
													
									//cbc:Amount
									$Amount = $domtree->createElement("cbc:Amount",$DatBoletaDetalle->BdeOtroCargo);
									$Amount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$Amount = $AllowanceCharge->appendChild($Amount);		
									
									//cbc:BaseAmount
									$BaseAmount = $domtree->createElement("cbc:BaseAmount",$InsBoletaDetalle1->BdeValorVentaBruto);//REVISAR ESTE MONTO
									$BaseAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
									
									
							}
							
							
							
							
							
							
							
							
							
								
						//cac:TaxTotal
						$TaxTotal = $domtree->createElement("cac:TaxTotal");
						$TaxTotal = $InvoiceLine->appendChild($TaxTotal);
						
						
							if($DatBoletaDetalle->BdeExonerado == "1"){
								
								//cbc:TaxAmount
								$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
								$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
								$TaxAmount = $TaxTotal->appendChild($TaxAmount);
										
								//cac:TaxSubtotal
								$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
								$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
									
									//cbc:TaxableAmount 
									$TaxableAmount = $domtree->createElement("cbc:TaxableAmount","0.00");
									$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
									
									//cbc:TaxAmount 
				
				
									$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeValorVenta,2, '.', ''));
									$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
									
									//cac:TaxCategory
									$TaxCategory = $domtree->createElement("cac:TaxCategory");
									$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
										
										//cbc:ID 
										$ID = $domtree->createElement("cbc:ID","E");
										$ID->setAttribute('schemeID', "UN/ECE 5305");
										$ID->setAttribute('schemeName', "Tax Category Identifier");
										$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
										$ID = $TaxCategory->appendChild($ID);
										
										//cbc:Percent
										$Percent = $domtree->createElement("cbc:Percent",$InsBoleta->BolPorcentajeImpuestoVenta);
										$Percent = $TaxCategory->appendChild($Percent);
										
										//cbc:TaxExemptionReasonCode 
										$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","20");
										$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
										$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
										$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
										$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
										
										//cac:TaxScheme
										$TaxScheme = $domtree->createElement("cac:TaxScheme");
										$TaxScheme = $TaxCategory->appendChild($TaxScheme);
							
											//cbc:TaxAmount 
											$ID = $domtree->createElement("cbc:ID","1000");
											$ID->setAttribute('schemeID', "UN/ECE 5153");
											$ID->setAttribute('schemeName', "Tax Scheme Identifier");
											$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
											$ID = $TaxScheme->appendChild($ID);
							
												//cbc:Name
											$Name = $domtree->createElement("cbc:Name","EXONERADO");
											$Name = $TaxScheme->appendChild($Name);
							
											//cbc:TaxTypeCode
											$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
											$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
											
											
							}else if($DatBoletaDetalle->BdeExonerado == "2"){
								
								if($DatBoletaDetalle->BdeGratuito=="1"){
									
									//cbc:TaxAmount
									$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeValorVenta*($InsBoleta->BolPorcentajeImpuestoVenta/100),2, '.', ''));
									$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$TaxAmount = $TaxTotal->appendChild($TaxAmount);
									
								}else{
														//cbc:TaxAmount
									$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
									$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$TaxAmount = $TaxTotal->appendChild($TaxAmount);
				
									
								}
								
								//cac:TaxSubtotal
								$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
								$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
									
									//cbc:TaxableAmount 
									$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($DatBoletaDetalle->BdeValorVenta,2, '.', ''));
									$TaxableAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
									
									
									if($DatBoletaDetalle->BdeGratuito=="1"){
								
										$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeValorVenta*($InsBoleta->BolPorcentajeImpuestoVenta/100),2, '.', ''));
										$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
										$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
									}else{
										//cbc:TaxAmount 
										$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatBoletaDetalle->BdeImpuesto,2, '.', ''));
										$TaxAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
										$TaxAmount = $TaxSubtotal->appendChild($TaxAmount);
									}
									
									
									//cac:TaxCategory
									$TaxCategory = $domtree->createElement("cac:TaxCategory");
									$TaxCategory = $TaxSubtotal->appendChild($TaxCategory);
										
										//cbc:TaxAmount 
										$ID = $domtree->createElement("cbc:ID","S");
										$ID->setAttribute('schemeID', "UN/ECE 5305");
										$ID->setAttribute('schemeName', "Tax Category Identifier");
										$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
										$ID = $TaxCategory->appendChild($ID);
										
										//cbc:Percent
										$Percent = $domtree->createElement("cbc:Percent",$InsBoleta->BolPorcentajeImpuestoVenta);
										$Percent = $TaxCategory->appendChild($Percent);
										
										
										if($DatBoletaDetalle->BdeGratuito=="1"){
											
											//cbc:TaxExemptionReasonCode 
											$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","15");
											$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
											$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
											$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
											$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
											
											//cac:TaxScheme
											$TaxScheme = $domtree->createElement("cac:TaxScheme");
											$TaxScheme = $TaxCategory->appendChild($TaxScheme);
								
												//cbc:TaxAmount 
												$ID = $domtree->createElement("cbc:ID","9996");
												$ID->setAttribute('schemeID', "UN/ECE 5153");
												$ID->setAttribute('schemeName', "Tax Scheme Identifier");
												$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
												$ID = $TaxScheme->appendChild($ID);
								
													//cbc:Name
												$Name = $domtree->createElement("cbc:Name","GRA");
												$Name = $TaxScheme->appendChild($Name);
								
												//cbc:TaxTypeCode
												$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","FRE");
												$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
											
										}else{
											
											
											//cbc:TaxExemptionReasonCode 
											$TaxExemptionReasonCode = $domtree->createElement("cbc:TaxExemptionReasonCode","10");
											$TaxExemptionReasonCode->setAttribute('listAgencyName', "PE:SUNAT");
											$TaxExemptionReasonCode->setAttribute('listName', "SUNAT:Codigo de Tipo de Afectación del IGV");
											$TaxExemptionReasonCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07");
											$TaxExemptionReasonCode = $TaxCategory->appendChild($TaxExemptionReasonCode);
											
											//cac:TaxScheme
											$TaxScheme = $domtree->createElement("cac:TaxScheme");
											$TaxScheme = $TaxCategory->appendChild($TaxScheme);
								
												//cbc:TaxAmount 
												$ID = $domtree->createElement("cbc:ID","1000");
												$ID->setAttribute('schemeID', "UN/ECE 5153");
												$ID->setAttribute('schemeName', "Tax Scheme Identifier");
												$ID->setAttribute('schemeAgencyName', "United Nations Economic Commission for Europe");
												$ID = $TaxScheme->appendChild($ID);
								
													//cbc:Name
												$Name = $domtree->createElement("cbc:Name","IGV");
												$Name = $TaxScheme->appendChild($Name);
								
												//cbc:TaxTypeCode
												$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","VAT");
												$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);
												
										}
										
										
										
										
											
											
							}else{
								
							}
							
										
				
							//cac:Item
							$Item = $domtree->createElement("cac:Item");
							$Item = $InvoiceLine->appendChild($Item);	
				
									
				
										if(!empty($InsBoleta->OvvId)){
									
											 if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
												
												$DatBoletaDetalle->BdeDescripcion .= "( ";
											
											  }
											
											  if(!empty($InsBoleta->BolDatoAdicional13)){
												
												$DatBoletaDetalle->BdeDescripcion .= "Nro. VIN o CHASIS: ".$InsBoleta->BolDatoAdicional13.", ";
												
											  }
											
											  if(!empty($InsBoleta->BolDatoAdicional7)){
											 
													$DatBoletaDetalle->BdeDescripcion .= "Nro. Motor: ".$InsBoleta->BolDatoAdicional7.", ";
												
											  }
											  
											  if(!empty($InsBoleta->BolDatoAdicional1)){
											 
													$DatBoletaDetalle->BdeDescripcion .= "Marca: ".$InsBoleta->BolDatoAdicional1." ";
											 
											  }
											
											  if(!empty($InsBoleta->BolDatoAdicional13) or !empty($InsBoleta->BolDatoAdicional7) or !empty($InsBoleta->BolDatoAdicional1)){
												
													$DatBoletaDetalle->BdeDescripcion .= " )";
											   
											  }
									  
										}
				
				
									//cac:PartyName
									$Description = $domtree->createElement("cbc:Description");
									$Description = $Item->appendChild($Description);
				
									$Description->appendChild($domtree->createCDATASection($DatBoletaDetalle->BdeDescripcion )); 
				
				
				
								//cac:SellersItemIdentification		
								$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
								$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);
				
									$ID = $domtree->createElement("cbc:ID");
									$ID = $SellersItemIdentification->appendChild($ID);
									$ID->appendChild($domtree->createCDATASection($DatBoletaDetalle->BdeCodigo )); 
									
								if(!empty($DatBoletaDetalle->BdeCodigoGeneral)){
									
									//cac:CommodityClassification		
									$CommodityClassification = $domtree->createElement("cac:CommodityClassification");
									$CommodityClassification = $Item->appendChild($CommodityClassification);
									
										//cbc:PriceAmount currencyID="PEN"
										$ItemClassificationCode = $domtree->createElement("cbc:ItemClassificationCode",$DatBoletaDetalle->BdeCodigoGeneral);
										$ItemClassificationCode->setAttribute('listID', "UNSPSC");
										$ItemClassificationCode->setAttribute('listAgencyName', "GS1 US");
										$ItemClassificationCode->setAttribute('listName', "Item Classification");
										$ItemClassificationCode = $CommodityClassification->appendChild($ItemClassificationCode);	
									
								}
								
								
							//cac:Price
							$Price = $domtree->createElement("cac:Price");
							$Price = $InvoiceLine->appendChild($Price);	
								
								if($DatBoletaDetalle->BdeGratuito=="1"){
									
									//cbc:PriceAmount 
									$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
									$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$PriceAmount = $Price->appendChild($PriceAmount);	
								
								}elseif($DatBoletaDetalle->BdeGratuito=="2"){
									
									//cbc:PriceAmount
									$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatBoletaDetalle->BdeValorVentaUnitario,2, '.', ''));
									$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$PriceAmount = $Price->appendChild($PriceAmount);	
									
								}else{
									
									//cbc:PriceAmount
									$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
									$PriceAmount->setAttribute('currencyID', $InsBoleta->MonSigla);
									$PriceAmount = $Price->appendChild($PriceAmount);	
										
								}
							
							
							
							if($fila==1){
								
								
								//cac:InvoiceLine
								//$InvoiceLineEspecial = $domtree->createElement("cac:InvoiceLine");
								//$InvoiceLineEspecial = $xmlRoot->appendChild($InvoiceLineEspecial);	
								
								//cac:ItemEspecial
								//$ItemEspecial = $domtree->createElement("cac:Item");
								//$ItemEspecial = $InvoiceLineEspecial->appendChild($Item);	
								
								
								
										if(!empty($InsBoleta->EinPlaca)){	
											
											//cac:AdditionalProperty
											$AdditionalProperty = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalProperty->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Numero de Placa')); 
											
											//cac:Name		
											$Value = $AdditionalProperty->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->EinPlaca)); 
											
											
										}
										
										if(!empty($InsBoleta->FinLicenciaCategoria)){
											
											//cac:AdditionalItemProperty2
											$AdditionalItemProperty2 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Categoria')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty2->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->FinLicenciaCategoria)); 
											
										}
										
										if(!empty($InsBoleta->BolDatoAdicional1)){
								
											//cac:AdditionalItemProperty5
											$AdditionalItemProperty5 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Marca')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty5->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional1)); 
											
									
										}else if(!empty($InsBoleta->VmaNombre)){
								
											//cac:AdditionalItemProperty3
											$AdditionalItemProperty3 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Marca')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty3->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->VmaNombre)); 
											
										}
										
										if(!empty($InsBoleta->BolDatoAdicional3)){	
								
											//cac:AdditionalItemProperty6
											$AdditionalItemProperty6 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Modelo')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty6->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional3)); 
											
											
										}else if(!empty($InsBoleta->VmoNombre)){
											
								
											//cac:AdditionalItemProperty4
											$AdditionalItemProperty4 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Modelo')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty4->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->VmoNombre)); 
											
											
										}
										
										
										if(!empty($InsBoleta->BolDatoAdicional15)){	
								
											
											//cac:AdditionalItemProperty7
											$AdditionalItemProperty7 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Color')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty7->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional15)); 
											
										}
										
										
										
										if(!empty($InsBoleta->BolDatoAdicional7)){	
															
												//cac:AdditionalItemProperty71
												$AdditionalItemProperty71 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
												
												//cac:Name		
												$Name = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Name')); 
												$Name->appendChild($domtree->createCDATASection( 'Motor')); 
												
												//cac:Name		
												$Value = $AdditionalItemProperty71->appendChild($domtree->createElement('cbc:Value')); 
												$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional7)); 
												
											
										}
										
										//InsBoletaDatoAdicional8
										if(!empty($InsBoleta->BolDatoAdicional8)){	
										
								
											//cac:AdditionalItemProperty8
											$AdditionalItemProperty8 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Combustible')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty8->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional8)); 
											
										}
										
										if(!empty($InsBoleta->BolDatoAdicional888888)){	//REVISAR
								
											//cac:AdditionalItemProperty9
											$AdditionalItemProperty9 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Form. Rodante')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty9->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional888888)); 
											
											
										}
										
											
										if(!empty($InsBoleta->BolDatoAdicional13)){	
								
											//cac:AdditionalItemProperty10
											$AdditionalItemProperty10 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'VIN')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty10->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional13)); 
											
											
											
										}
										
										if(!empty($InsBoleta->BolDatoAdicional13)){	
								
											//cac:AdditionalItemProperty101
											$AdditionalItemProperty101 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Serie/Chasis')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty101->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional13)); 
											
										}
										
										
										//if(!empty($InsBoleta->BolDatoAdicional5)){	
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
				//							$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional5)); 
				//							
				//						}
										
										if(!empty($InsBoleta->BolDatoAdicional27)){	//REVISAR
								
											//cac:AdditionalItemProperty103
											$AdditionalItemProperty103 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Año Modelo')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty103->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional27)); 
											
										}
								
								
										if(!empty($InsBoleta->BolDatoAdicional5555555555)){	//REVISAR
								
											//cac:AdditionalItemProperty104
											$AdditionalItemProperty104 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Version')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty104->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional5555555555)); 
											
										}
										
										if(!empty($InsBoleta->BolDatoAdicional11)){	
										
								
											//cac:AdditionalItemProperty11
											$AdditionalItemProperty11 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Ejes')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty11->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional11,2,"0",STR_PAD_LEFT))); 
											
										}
								
										if(!empty($InsBoleta->BolDatoAdicional19)){	
								
											//cac:AdditionalItemProperty12
											$AdditionalItemProperty12 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Asientos')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty12->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional19,4,"0",STR_PAD_LEFT))); 
											
											
										}
										
										
										if(!empty($InsBoleta->BolDatoAdicional21)){	
										
								
											//cac:AdditionalItemProperty13
											$AdditionalItemProperty13 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Pasajeros')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty13->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional21,4,"0",STR_PAD_LEFT))); 
											
											
										}
										
										if(!empty($InsBoleta->BolDatoAdicional24)){	
								
											//cac:AdditionalItemProperty14
											$AdditionalItemProperty14 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Ruedas')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty14->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional24,2,"0",STR_PAD_LEFT))); 
											
										}
										
																
										if(!empty($InsBoleta->BolDatoAdicional4)){	
								
											
											//cac:AdditionalItemProperty15
											$AdditionalItemProperty15 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Carroceria')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty15->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BolDatoAdicional4)); 
											
										}
										
										
										if(!empty($InsBoleta->BoletaDatoAdicional25)){	
										
								
											
											//cac:AdditionalItemProperty16
											$AdditionalItemProperty16 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Potencia')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty16->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $InsBoleta->BoletaDatoAdicional25)); 
											
										}
										
											
										if(!empty($InsBoleta->BolDatoAdicional9)){	
								
											
											//cac:AdditionalItemProperty17
											$AdditionalItemProperty17 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Cilindros')); 
											
											//cac:Name		
											$Value = $AdditionalItemProperty17->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( str_pad($InsBoleta->BolDatoAdicional9,2,"0",STR_PAD_LEFT))); 
											
										}
										
										
										if(!empty($InsBoleta->BolDatoAdicional17)){	
											
								
											
											//cac:AdditionalItemProperty18
											$AdditionalItemProperty18 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Cilindrada')); 
											
											$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional17);
											$NuevoValor = round($NuevoValor/1000,3);
											//cac:Name		
											$Value = $AdditionalItemProperty18->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $NuevoValor)); 
											
											
										}
									
										if(!empty($InsBoleta->BolDatoAdicional10)){	
								
											
											//cac:AdditionalItemProperty19
											$AdditionalItemProperty19 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Peso Bruto')); 
											
											$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional10);
											$NuevoValor = round($NuevoValor/1000,3);
											
											//cac:Name		
											$Value = $AdditionalItemProperty19->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $NuevoValor)); 
											
										}
										
										
										if(!empty($InsBoleta->BolDatoAdicional14)){	
								
											//cac:AdditionalItemProperty20
											$AdditionalItemProperty20 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Peso Neto')); 
											
											$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional14);
											$NuevoValor = round($NuevoValor/1000,3);
											
											//cac:Name		
											$Value = $AdditionalItemProperty20->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $NuevoValor));
											
										}
										
										
										
										if(!empty($InsBoleta->BolDatoAdicional12)){	
								
											
											//cac:AdditionalItemProperty21
											$AdditionalItemProperty21 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Carga Util')); 
											
											$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional12);
											$NuevoValor = round($NuevoValor/1000,3);
											
											//cac:Name		
											$Value = $AdditionalItemProperty21->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $NuevoValor));
											
										}
										
										if(!empty($InsBoleta->BolDatoAdicional18)){	
								
											//cac:AdditionalItemProperty22
											$AdditionalItemProperty22 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Longitud')); 
											
											$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional18);
											$NuevoValor = round($NuevoValor/1000,3);
											
											//cac:Name		
											$Value = $AdditionalItemProperty22->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $NuevoValor));
											
										}
										
																
										if(!empty($InsBoleta->BolDatoAdicional16)){	
											
								
											//cac:AdditionalItemProperty23
											$AdditionalItemProperty23 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Altura')); 
											
											$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional16);
											$NuevoValor = round($NuevoValor/1000,3);
											
											//cac:Name		
											$Value = $AdditionalItemProperty23->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $NuevoValor));
											
										}
										
																
										if(!empty($InsBoleta->BolDatoAdicional20)){	
											
											//cac:AdditionalItemProperty24
											$AdditionalItemProperty24 = $Item->appendChild($domtree->createElement( 'cac:AdditionalItemProperty' ));
											
											//cac:Name		
											$Name = $AdditionalItemProperty24->appendChild($domtree->createElement('cbc:Name')); 
											$Name->appendChild($domtree->createCDATASection( 'Ancho')); 
											
											$NuevoValor = FncSoloNumeros($InsBoleta->BolDatoAdicional20);
											$NuevoValor = round($NuevoValor/1000,3);
											
											//cac:Name		
											$Value = $AdditionalItemProperty24->appendChild($domtree->createElement('cbc:Value')); 
											$Value->appendChild($domtree->createCDATASection( $NuevoValor));
											
										}
														
				
								
							}
							
						
						$fila++;
					}
				}
		
						
				/*
				* CODIGO XML - FIN
				*/ 					
					if(file_exists($oRuta.$ARCHIVO)){
						unlink($oRuta.$ARCHIVO);
					}
					
					$domtree->save($oRuta.$ARCHIVO,LIBXML_NOEMPTYTAG );
					
			
				return true;

			
			}else{
			
				return false;
					
			}
		
		}	
			
			
			
			
			
			
			
			
			
}
?>