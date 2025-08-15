<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaDebito
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaDebito {

    public $NdbId;
	public $NdtId;
    public $UsuId;
	
	public $CliId;		

	public $FacId;
	public $FtaId;
	public $BolId;
	public $BtaId;
	
	public $DocId;
	public $DtaId;
	public $DtaNumero;
	
	public $NdbTipo;
	public $NdbEstado;
	public $NdbFechaEmision;
	
	public $MonId;
	public $NdbTipoCambio;
	
	public $NdbPorcentajeImpuestoVenta;
	public $NdbSubTotal;
	public $NdbImpuesto;
	public $NdbTotal;	
	public $NdbObservacion;
	public $NdbObservacionImpresa;
	public $NdbMotivo;

	public $NdbCierre;
	
    public $NdbTiempoCreacion;
    public $NdbTiempoModificacion;
    public $NdbEliminado;
	
	public $NdbTotalItems;
	public $NotaDebitoDetalle;

	public $NdtNumero;	

	public $SucId;

	public $CliNombre;
	public $TdoId;
	public $CliNumeroDocumento;
	public $CliTelefono;
	public $CliEmail;
	public $CliCelular;
	public $CliFax;
	
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

	public function MtdGenerarNotaDebitoId() {

			
			$sql = 'SELECT	

			MAX(SUBSTR(ndb.NdbId,1)) AS "MAXIMO",
			
			ndt.NdtInicio
			FROM tblndbnotadebito ndb
				LEFT JOIN tblndtnotadebitotalonario ndt
				ON ndb.NdtId = ndt.NdtId
					WHERE ndt.NdtId = "'.$this->NdtId.'"';

			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

			if(empty($fila['MAXIMO'])){	
				if(empty($fila['NdtInicio'])){
					$this->NdbId = "0000001";
				}else{
					$this->NdbId = str_pad($fila['NdtInicio'], 6, "0", STR_PAD_LEFT);
				}
			}else{
				$fila['MAXIMO']++;
				$this->NdbId = str_pad($fila['MAXIMO'], 6, "0", STR_PAD_LEFT);	
			}
			
		}
		
	public function MtdGenerarNotaDebitoBajaId() {
	
		
		$sql = 'SELECT	
			MAX(CONVERT(ndb.NdbSunatRespuestaBajaId,unsigned)) AS "MAXIMO"
	
		FROM tblndbnotadebito ndb ';			

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){	
			$this->NdbSunatRespuestaBajaId = "1";			
		}else{
			$fila['MAXIMO']++;
			$this->NdbSunatRespuestaBajaId = ($fila['MAXIMO']);	
		}

	}

    public function MtdObtenerNotaDebito($oCompleto=true){

			$sql = 'SELECT 
				ndb.NdbId,
				ndb.NdtId,
				ndb.SucId,
				
				cli.CliId,
				DATE_FORMAT(ndb.NdbFechaEmision, "%d/%m/%Y") AS "NNdbFechaEmision",
DATE_FORMAT(ndb.NdbTiempoCreacion, "%H:%i:%s") AS "NdbHoraEmision",
				
				
				ndb.NdbDireccion,
				
				
				CASE ndb.NdbTipo
				WHEN 2 THEN (ndb.FacId)
				WHEN 3 THEN (ndb.BolId)
				WHEN 4 THEN (ndb.NcrId)
				
				ELSE NULL
				END AS "DocId",					
			
				CASE ndb.NdbTipo
				WHEN 2 THEN (ndb.FtaId)
				WHEN 3 THEN (ndb.BtaId)
				WHEN 4 THEN (ndb.NctId)
				
				ELSE NULL
				END AS "DtaId" ,
				
				CASE ndb.NdbTipo
				
				WHEN 2 THEN (fta.FtaNumero)
				WHEN 3 THEN (bta.BtaNumero)
				
				WHEN 4 THEN (nct.NctNumero)
				
				ELSE NULL
				END AS "DtaNumero",				
				
				CASE ndb.NdbTipo
				WHEN 2 THEN DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
				WHEN 3 THEN DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
				
				WHEN 4 THEN DATE_FORMAT(ncr.NcrFechaEmision, "%d/%m/%Y")
				
				ELSE NULL
				END AS "DocFechaEmision",
				
				
				CASE ndb.NdbTipo
				WHEN 2 THEN (fac.OvvId)
				WHEN 3 THEN (bol.OvvId)
				ELSE NULL
				END AS "OvvId",		
				
				ndb.NdbIncluyeImpuesto,					
				ndb.NdbPorcentajeImpuestoVenta,
				ndb.NdbPorcentajeImpuestoSelectivo,
				
				ndb.MonId,
				ndb.NdbTipoCambio,
				
				ndb.NdbTipo,
				
				ndb.NdbDatoAdicional1,
				ndb.NdbDatoAdicional2,
				ndb.NdbDatoAdicional3,
				ndb.NdbDatoAdicional4,
				ndb.NdbDatoAdicional5,
				ndb.NdbDatoAdicional6,
				ndb.NdbDatoAdicional7,
				ndb.NdbDatoAdicional8,
				ndb.NdbDatoAdicional9,
				ndb.NdbDatoAdicional10,
				
				ndb.NdbDatoAdicional11,
				ndb.NdbDatoAdicional12,
				ndb.NdbDatoAdicional13,
				ndb.NdbDatoAdicional14,
				ndb.NdbDatoAdicional15,
				ndb.NdbDatoAdicional16,
				ndb.NdbDatoAdicional17,
				ndb.NdbDatoAdicional18,
				ndb.NdbDatoAdicional19,
				ndb.NdbDatoAdicional20,
				
				ndb.NdbDatoAdicional21,
				ndb.NdbDatoAdicional22,
				ndb.NdbDatoAdicional23,
				ndb.NdbDatoAdicional24,
				ndb.NdbDatoAdicional25,
				ndb.NdbDatoAdicional26,
				
				
				ndb.NdbEstado,	
				ndb.NdbTotalImpuestoSelectivo,
				ndb.NdbTotalGravado,
				ndb.NdbTotalDescuento,
				ndb.NdbTotalGratuito,
				ndb.NdbTotalExonerado,
				ndb.NdbTotalPagar,
				
				ndb.NdbSubTotal,
				ndb.NdbImpuesto,
				ndb.NdbTotal,
				

				ndb.NdbObservacion,
				ndb.NdbMotivo,
				ndb.NdbMotivoCodigo,				
				
				ndb.NdbSunatRespuestaTicket,
				ndb.NdbSunatRespuestaTicketEstado,
				ndb.NdbSunatRespuestaObservacion,
				
				ndb.NdbSunatRespuestaEnvioTicket,
				ndb.NdbSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaEnvioFecha",
				ndb.NdbSunatRespuestaEnvioHora,
				ndb.NdbSunatRespuestaEnvioCodigo,
				ndb.NdbSunatRespuestaEnvioContenido,
				
				ndb.NdbSunatRespuestaBajaTicket,
				ndb.NdbSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaBajaFecha",
				ndb.NdbSunatRespuestaBajaHora,
				ndb.NdbSunatRespuestaBajaCodigo,
				ndb.NdbSunatRespuestaBajaContenido,
				ndb.NdbSunatRespuestaBajaId,
				
				ndb.NdbSunatRespuestaConsultaCodigo,
				ndb.NdbSunatRespuestaConsultaContenido,
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaConsultaFecha",
				ndb.NdbSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaBajaTiempoCreacion",
				
				ndb.NdbSunatRespuestaTicket,
				ndb.NdbSunatRespuestaTicketEstado,
				ndb.NdbSunatRespuestaObservacion,
				
				ndb.NdbSunatRespuestaEnvioTicket,
				ndb.NdbSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaEnvioFecha",
				ndb.NdbSunatRespuestaEnvioHora,
				ndb.NdbSunatRespuestaEnvioCodigo,
				ndb.NdbSunatRespuestaEnvioContenido,
				
				ndb.NdbSunatRespuestaBajaTicket,
				ndb.NdbSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaBajaFecha",
				ndb.NdbSunatRespuestaBajaHora,
				ndb.NdbSunatRespuestaBajaCodigo,
				ndb.NdbSunatRespuestaBajaContenido,
				ndb.NdbSunatRespuestaBajaId,
				
				ndb.NdbSunatRespuestaConsultaCodigo,
				ndb.NdbSunatRespuestaConsultaContenido,
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaConsultaFecha",
				ndb.NdbSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaBajaTiempoCreacion",
				
				ndb.NdbSunatUltimaAccion,
				ndb.NdbSunatUltimaRespuesta,
				
				ndb.NdbSunatRespuestaEnvioDigestValue,	
				ndb.NdbSunatRespuestaEnvioSignatureValue,	
				
				ndb.NdbUsuario,	
				ndb.NdbVendedor,	
				ndb.NdbNumeroPedido,	
				
				ndb.NdbCierre,				
				DATE_FORMAT(ndb.NdbTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbTiempoCreacion",
                DATE_FORMAT(ndb.NdbTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNdbTiempoModificacion",

				ndt.NdtNumero,
				
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
				suc.SucCodigoUbigeo
					
					
				FROM tblndbnotadebito ndb
				
				LEFT JOIN tblndtnotadebitotalonario ndt
				ON ndb.NdtId = ndt.NdtId				
				
					LEFT JOIN tblfacfactura fac 
					ON (ndb.FacId = fac.FacId AND ndb.FtaId = fac.FtaId)
						
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
						
					LEFT JOIN tblbolboleta bol
					ON (ndb.BolId = bol.BolId AND ndb.BtaId = bol.BtaId)
					
						LEFT JOIN tblbtaboletatalonario bta
						ON ndb.BtaId = bta.BtaId

				LEFT JOIN tblncrnotacredito ncr
				ON (ndb.NcrId = ncr.NcrId AND ndb.NctId = ncr.NctId)
				 
			LEFT JOIN tblnctnotacreditotalonario nct
			ON ncr.NctId = nct.NctId
				
					
				LEFT JOIN tblclicliente cli
				ON (ndb.CliId = cli.CliId)
				
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
					LEFT JOIN tblmonmoneda mon
					ON ndb.MonId = mon.MonId
					
					LEFT JOIn tblscasunatcatalogo sca
					ON ndb.NdbMotivoCodigo = sca.ScaCodigo
					
						LEFT JOIN tblsucsucursal suc
						ON ndb.SucId = suc.SucId		
					
				WHERE ndb.NdbId = "'.$this->NdbId.'" AND ndb.NdtId= "'.$this->NdtId.'";';
		

        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {	
		
			
			
				
				
			$this->NdbId = $fila['NdbId'];
			$this->NdtId = $fila['NdtId'];
			$this->SucId = $fila['SucId'];

			$this->CliId = $fila['CliId'];
			$this->NdbFechaEmision = $fila['NNdbFechaEmision'];
			$this->NdbHoraEmision = $fila['NdbHoraEmision'];
			
			$this->NdbDireccion = $fila['NdbDireccion'];

			$this->DocId = $fila['DocId'];
			$this->DtaId = $fila['DtaId'];
			$this->DtaNumero = $fila['DtaNumero'];
			$this->DocFechaEmision = $fila['DocFechaEmision'];			
			
			$this->NdbIncluyeImpuesto = $fila['NdbIncluyeImpuesto']; 
			$this->NdbPorcentajeImpuestoVenta = $fila['NdbPorcentajeImpuestoVenta'];
									
			$this->MonId = $fila['MonId'];
			$this->NdbTipoCambio = $fila['NdbTipoCambio'];			
	
			$this->NdbTipo = $fila['NdbTipo'];
			$this->OvvId = $fila['OvvId'];
			
			$this->NdbDatoAdicional1 = $fila['NdbDatoAdicional1'];
			$this->NdbDatoAdicional2 = $fila['NdbDatoAdicional2'];
			$this->NdbDatoAdicional3 = $fila['NdbDatoAdicional3'];
			$this->NdbDatoAdicional4 = $fila['NdbDatoAdicional4'];
			$this->NdbDatoAdicional5 = $fila['NdbDatoAdicional5'];
			$this->NdbDatoAdicional6 = $fila['NdbDatoAdicional6'];
			$this->NdbDatoAdicional7 = $fila['NdbDatoAdicional7'];
			$this->NdbDatoAdicional8 = $fila['NdbDatoAdicional8'];
			$this->NdbDatoAdicional9 = $fila['NdbDatoAdicional9'];
			$this->NdbDatoAdicional10 = $fila['NdbDatoAdicional10'];
			
			$this->NdbDatoAdicional11 = $fila['NdbDatoAdicional11'];
			$this->NdbDatoAdicional12 = $fila['NdbDatoAdicional12'];
			$this->NdbDatoAdicional13 = $fila['NdbDatoAdicional13'];
			$this->NdbDatoAdicional14 = $fila['NdbDatoAdicional14'];
			$this->NdbDatoAdicional15 = $fila['NdbDatoAdicional15'];
			$this->NdbDatoAdicional16 = $fila['NdbDatoAdicional16'];
			$this->NdbDatoAdicional17 = $fila['NdbDatoAdicional17'];
			$this->NdbDatoAdicional18 = $fila['NdbDatoAdicional18'];
			$this->NdbDatoAdicional19 = $fila['NdbDatoAdicional19'];
			$this->NdbDatoAdicional20 = $fila['NdbDatoAdicional20'];
			
			$this->NdbDatoAdicional21 = $fila['NdbDatoAdicional21'];
			$this->NdbDatoAdicional22 = $fila['NdbDatoAdicional22'];
			$this->NdbDatoAdicional23 = $fila['NdbDatoAdicional23'];
			$this->NdbDatoAdicional24 = $fila['NdbDatoAdicional24'];
			$this->NdbDatoAdicional25 = $fila['NdbDatoAdicional25'];
			$this->NdbDatoAdicional26 = $fila['NdbDatoAdicional26'];
			
    		$this->NdbEstado = $fila['NdbEstado'];
			
			$this->NdbTotalImpuestoSelectivo = $fila['NdbTotalImpuestoSelectivo']; 
			$this->NdbTotalGravado = $fila['NdbTotalGravado']; 
			$this->NdbTotalDescuento = $fila['NdbTotalDescuento']; 
			$this->NdbTotalGratuito = $fila['NdbTotalGratuito']; 
			$this->NdbTotalExonerado = $fila['NdbTotalExonerado']; 
			$this->NdbTotalPagar = $fila['NdbTotalPagar']; 
			
			$this->NdbSubTotal = ($fila['NdbSubTotal']); 
			$this->NdbDescuento = ($fila['NdbDescuento']); 
			$this->NdbImpuesto = ($fila['NdbImpuesto']); 			
			$this->NdbTotal = ($fila['NdbTotal']); 
			list($this->NdbObservacion,$this->NdbObservacionImpresa) = explode("###",$fila['NdbObservacion']);
			
			$this->NdbMotivo = $fila['NdbMotivo']; 
			$this->NdbMotivoCodigo = $fila['NdbMotivoCodigo']; 
			
			
			$this->NdbSunatRespuestaTicket = $fila['NdbSunatRespuestaTicket']; 	
			$this->NdbSunatRespuestaTicketEstado = $fila['NdbSunatRespuestaTicketEstado']; 			
			$this->NdbSunatRespuestaObservacion = $fila['NdbSunatRespuestaObservacion']; 	
			
			$this->NdbSunatRespuestaEnvioTicket = $fila['NdbSunatRespuestaEnvioTicket']; 	
			$this->NdbSunatRespuestaEnvioTicketEstado = $fila['NdbSunatRespuestaEnvioTicketEstado']; 	
			$this->NdbSunatRespuestaEnvioFecha = $fila['NNdbSunatRespuestaEnvioFecha']; 	
			$this->NdbSunatRespuestaEnvioHora = $fila['NdbSunatRespuestaEnvioHora']; 	
			$this->NdbSunatRespuestaEnvioCodigo = $fila['NdbSunatRespuestaEnvioCodigo']; 	
			$this->NdbSunatRespuestaEnvioContenido = $fila['NdbSunatRespuestaEnvioContenido']; 	
			
			$this->NdbSunatRespuestaBajaTicket = $fila['NdbSunatRespuestaBajaTicket']; 	
			$this->NdbSunatRespuestaBajaTicketEstado = $fila['NdbSunatRespuestaBajaTicketEstado']; 				
			$this->NdbSunatRespuestaBajaFecha = $fila['NNdbSunatRespuestaBajaFecha']; 	
			$this->NdbSunatRespuestaBajaHora = $fila['NdbSunatRespuestaBajaHora']; 				
			$this->NdbSunatRespuestaBajaCodigo = $fila['NdbSunatRespuestaBajaCodigo']; 	
			$this->NdbSunatRespuestaBajaContenido = $fila['NdbSunatRespuestaBajaContenido']; 	
			$this->NdbSunatRespuestaBajaId = $fila['NdbSunatRespuestaBajaId']; 	
			
			$this->NdbSunatRespuestaConsultaCodigo = $fila['NdbSunatRespuestaConsultaCodigo']; 	
			$this->NdbSunatRespuestaConsultaContenido = $fila['NdbSunatRespuestaConsultaContenido']; 	
			$this->NdbSunatRespuestaConsultaFecha = $fila['NNdbSunatRespuestaConsultaFecha']; 	
			$this->NdbSunatRespuestaConsultaHora = $fila['NdbSunatRespuestaConsultaHora']; 	
			
			$this->NdbSunatRespuestaEnvioTiempoCreacion = $fila['NNdbSunatRespuestaEnvioTiempoCreacion']; 	
			$this->NdbSunatRespuestaConsultaTiempoCreacion = $fila['NNdbSunatRespuestaConsultaTiempoCreacion']; 	
			$this->NdbSunatRespuestaBajaTiempoCreacion = $fila['NNdbSunatRespuestaBajaTiempoCreacion']; 	
			
			$this->NdbSunatUltimaAccion = $fila['NdbSunatUltimaAccion']; 	
			$this->NdbSunatUltimaRespuesta = $fila['NdbSunatUltimaRespuesta']; 	

				$this->NdbSunatRespuestaEnvioDigestValue = $fila['NdbSunatRespuestaEnvioDigestValue']; 
				$this->NdbSunatRespuestaEnvioSignatureValue = $fila['NdbSunatRespuestaEnvioSignatureValue']; 
				
				
				$this->NdbUsuario = $fila['NdbUsuario']; 
			$this->NdbVendedor = $fila['NdbVendedor'];
			$this->NdbNumeroPedido = $fila['NdbNumeroPedido'];
				
			$this->NdbCierre = $fila['NdbCierre']; 
			$this->NdbTiempoCreacion = $fila['NNdbTiempoCreacion'];
			$this->NdbTiempoModificacion = $fila['NNdbTiempoModificacion']; 

			$this->NotaDebitoDetalle = $ResNotaDebitoDetalle['Datos'];

			$this->NdtNumero = $fila['NdtNumero']; 

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
				
			
			if($oCompleto){
				
				$InsNotaDebitoDetalle = new ClsNotaDebitoDetalle($this->InsMysql);
				$ResNotaDebitoDetalle =  $InsNotaDebitoDetalle->MtdObtenerNotaDebitoDetalles(NULL,NULL,NULL,NULL,1,NULL,$this->NdbId,$this->NdtId);
				
				$this->NotaDebitoDetalle = $ResNotaDebitoDetalle['Datos'];
				if(!empty($this->OvvId)){
				  
				  $InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario($this->InsMysql);
				  $ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','ASC',NULL,$this->OvvId);
				  $this->OrdenVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];
				  
				  //$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();
	//					$InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,'OvoId','ASC',NULL,$this->OvvId,NULL);
	//					$this->OrdenVentaVehiculoObsequio = $ResOrdenVentaVehiculoObsequio['Datos'];
			  
			  }
				
			}					 
		
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerNotaDebitos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oDocumentoId=NULL,$oDocumentoTalonarioId=NULL,$oSucursal=NULL) {
	
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
		
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (ndb.NdbEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ndb.NdbFechaEmision)>="'.$oFechaInicio.'" AND DATE(ndb.NdbFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ndb.NdbFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ndb.NdbFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
				
		if(!empty($oTalonario)){
			$talonario = ' AND ndb.NdtId = "'.$oTalonario.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ndb.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oDocumentoId)){
			$did = ' AND (ndb.FacId = "'.$oDocumentoId.'" OR ndb.BolId = "'.$oDocumentoId.'" OR ndb.NcrId = "'.$oDocumentoId.'")';
		}
		
		if(!empty($oDocumentoTalonarioId)){
			$dtalonario = ' AND (ndb.FtaId = "'.$oDocumentoTalonarioId.'" OR ndb.BtaId = "'.$oDocumentoTalonarioId.'" OR ndb.NdtId = "'.$oDocumentoTalonarioId.'")';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND (ndb.MonId = "'.$oMoneda.'")';
		}
		
			
		if(!empty($oSucursal)){
			$sucursal = ' AND (ndb.SucId = "'.$oSucursal.'")';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ndb.NdbId,
				ndb.NdtId,
				ndb.SucId,
				
				cli.CliId,
				DATE_FORMAT(ndb.NdbFechaEmision, "%d/%m/%Y") AS "NNdbFechaEmision",
DATE_FORMAT(ndb.NdbTiempoCreacion, "%H:%i:%s") AS "NdbHoraEmision",
				ndb.NdbDireccion,
				
				
				
				
				
				
				
				
				
				
				CASE ndb.NdbTipo
				WHEN 2 THEN (ndb.FacId)
				WHEN 3 THEN (ndb.BolId)
				WHEN 4 THEN (ndb.NcrId)
				
				ELSE NULL
				END AS "DocId",					
			
				CASE ndb.NdbTipo
				WHEN 2 THEN (ndb.FtaId)
				WHEN 3 THEN (ndb.BtaId)
				WHEN 4 THEN (ndb.NctId)
				
				ELSE NULL
				END AS "DtaId" ,
				
				CASE ndb.NdbTipo
				
				WHEN 2 THEN (fta.FtaNumero)
				WHEN 3 THEN (bta.BtaNumero)
				
				WHEN 4 THEN (nct.NctNumero)
				
				ELSE NULL
				END AS "DtaNumero",				
				
				CASE ndb.NdbTipo
				WHEN 2 THEN DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
				WHEN 3 THEN DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
				
				WHEN 4 THEN DATE_FORMAT(ncr.NcrFechaEmision, "%d/%m/%Y")
				
				ELSE NULL
				END AS "DocFechaEmision",
				
				
				
				
				
				ndb.NdbIncluyeImpuesto,
				ndb.NdbPorcentajeImpuestoVenta,
				ndb.NdbPorcentajeImpuestoSelectivo,
							
				ndb.MonId,
				ndb.NdbTipoCambio,
				ndb.NdbTipoCambioAux,
				
				ndb.NdbTipo,
				
								ndb.NdbDatoAdicional1,
				ndb.NdbDatoAdicional2,
				ndb.NdbDatoAdicional3,
				ndb.NdbDatoAdicional4,
				ndb.NdbDatoAdicional5,
				ndb.NdbDatoAdicional6,
				ndb.NdbDatoAdicional7,
				ndb.NdbDatoAdicional8,
				ndb.NdbDatoAdicional9,
				ndb.NdbDatoAdicional10,
				
				ndb.NdbDatoAdicional11,
				ndb.NdbDatoAdicional12,
				ndb.NdbDatoAdicional13,
				ndb.NdbDatoAdicional14,
				ndb.NdbDatoAdicional15,
				ndb.NdbDatoAdicional16,
				ndb.NdbDatoAdicional17,
				ndb.NdbDatoAdicional18,
				ndb.NdbDatoAdicional19,
				ndb.NdbDatoAdicional20,
				
				ndb.NdbDatoAdicional21,
				ndb.NdbDatoAdicional22,
				ndb.NdbDatoAdicional23,
				ndb.NdbDatoAdicional24,
				ndb.NdbDatoAdicional25,
ndb.NdbDatoAdicional26,
				
				ndb.NdbEstado,					
				
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalImpuestoSelectivo) AS "NdbTotalImpuestoSelectivo",
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalGravado) AS "NdbTotalGravado",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalDescuento) AS "NdbTotalDescuento",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalGratuito) AS "NdbTotalGratuito",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalExonerado) AS "NdbTotalExonerado",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotalPagar) AS "NdbTotalPagar",	
				
				
				IF(ndb.NdbEstado=6,0.00,ndb.NdbSubTotal) AS "NdbSubTotal",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbImpuesto) AS "NdbImpuesto",	
				IF(ndb.NdbEstado=6,0.00,ndb.NdbTotal) AS "NdbTotal",	
							
				ndb.NdbObservacion,
				ndb.NdbMotivo,
				ndb.NdbMotivoCodigo,
				
				ndb.NdbSunatRespuestaTicket,
				ndb.NdbSunatRespuestaTicketEstado,
				ndb.NdbSunatRespuestaObservacion,
				
				ndb.NdbSunatRespuestaEnvioTicket,
				ndb.NdbSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaEnvioFecha",
				ndb.NdbSunatRespuestaEnvioHora,
				ndb.NdbSunatRespuestaEnvioCodigo,
				ndb.NdbSunatRespuestaEnvioContenido,
				
				ndb.NdbSunatRespuestaBajaTicket,
				ndb.NdbSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaBajaFecha",
				ndb.NdbSunatRespuestaBajaHora,				
				ndb.NdbSunatRespuestaBajaCodigo,
				ndb.NdbSunatRespuestaBajaContenido,
				ndb.NdbSunatRespuestaBajaId,
				
				ndb.NdbSunatRespuestaConsultaCodigo,
				ndb.NdbSunatRespuestaConsultaContenido,
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NNdbSunatRespuestaConsultaFecha",
				ndb.NdbSunatRespuestaConsultaHora,
				
				DATE_FORMAT(ndb.NdbSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(ndb.NdbSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbSunatRespuestaBajaTiempoCreacion",
				
				ndb.NdbSunatUltimaAccion,
				ndb.NdbSunatUltimaRespuesta,
				
				ndb.NdbCierre,
			
				DATE_FORMAT(ndb.NdbTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNdbTiempoCreacion",
                DATE_FORMAT(ndb.NdbTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNdbTiempoModificacion",

				(SELECT COUNT(ndd.NddId) FROM tblnddnotadebitodetalle ndd WHERE ndd.NdbId = ndb.NdbId AND ndd.NdtId = ndb.NdtId ) AS "NdbTotalItems",
	
				ndt.NdtNumero,
				
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
				
				FROM tblndbnotadebito ndb
				
				
					LEFT JOIN tblsucsucursal suc
					ON ndb.SucId = suc.SucId
				
				LEFT JOIN tblndtnotadebitotalonario ndt
				ON ndb.NdtId = ndt.NdtId
				
					LEFT JOIN tblfacfactura fac
					ON (ndb.FacId = fac.FacId AND ndb.FtaId = fac.FtaId)
					
						LEFT JOIN tblftafacturatalonario fta 
						ON fac.FtaId = fta.FtaId
						
					LEFT JOIN tblbolboleta bol
					ON (ndb.BolId = bol.BolId AND ndb.BtaId = bol.BtaId)
						
						LEFT JOIN tblbtaboletatalonario bta 
						ON ndb.BtaId = bta.BtaId
								
						LEFT JOIN tblncrnotacredito ncr
				ON (ndb.NcrId = ncr.NcrId AND ndb.NctId = ncr.NctId)
				 
			LEFT JOIN tblnctnotacreditotalonario nct
			ON ncr.NctId = nct.NctId
				
								
				LEFT JOIN tblclicliente cli
				  ON (ndb.CliId = cli.CliId)
					
					LEFT JOIN tblmonmoneda mon
					ON ndb.MonId = mon.MonId
					
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
					
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$did.$dtalonario.$fecha.$moneda.$talonario.$credito.$regimen.$npago.$orden.$paginacion;
				/*LEFT JOIN tblclicliente cli
				  ON (ndb.CliId = cli.CliId OR bol.CliId = cli.CliId)*/
					
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaDebito = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$NotaDebito = new $InsNotaDebito();
                    $NotaDebito->NdbId = $fila['NdbId'];
					$NotaDebito->NdtId = $fila['NdtId'];
					$NotaDebito->SucId = $fila['SucId'];
					
					$NotaDebito->CliId= $fila['CliId'];
					$NotaDebito->NdbDireccion = $fila['NdbDireccion'];	
					$NotaDebito->NdbFechaEmision = $fila['NNdbFechaEmision'];
					$NotaDebito->NdbHoraEmision = $fila['NdbHoraEmision'];
					
					
					$NotaDebito->DocId= $fila['DocId'];
					$NotaDebito->DtaId= $fila['DtaId'];
					$NotaDebito->DtaNumero= $fila['DtaNumero'];

					$NotaDebito->NdbIncluyeImpuesto = $fila['NdbIncluyeImpuesto'];
					$NotaDebito->NdbPorcentajeImpuestoVenta = $fila['NdbPorcentajeImpuestoVenta'];
					$NotaDebito->NdbPorcentajeImpuestoSelectivo = $fila['NdbPorcentajeImpuestoSelectivo'];
							
					$NotaDebito->MonId = $fila['MonId'];
					$NotaDebito->NdbTipoCambio = $fila['NdbTipoCambio'];
					$NotaDebito->NdbTipoCambioAux = $fila['NdbTipoCambioAux'];

					$NotaDebito->NdbTipo = $fila['NdbTipo'];
										
					$NotaDebito->NdbDatoAdicional1 = $fila['NdbDatoAdicional1'];
					$NotaDebito->NdbDatoAdicional2 = $fila['NdbDatoAdicional2'];
					$NotaDebito->NdbDatoAdicional3 = $fila['NdbDatoAdicional3'];
					$NotaDebito->NdbDatoAdicional4 = $fila['NdbDatoAdicional4'];
					$NotaDebito->NdbDatoAdicional5 = $fila['NdbDatoAdicional5'];
					$NotaDebito->NdbDatoAdicional6 = $fila['NdbDatoAdicional6'];
					$NotaDebito->NdbDatoAdicional7 = $fila['NdbDatoAdicional7'];
					$NotaDebito->NdbDatoAdicional8 = $fila['NdbDatoAdicional8'];
					$NotaDebito->NdbDatoAdicional9 = $fila['NdbDatoAdicional9'];
					$NotaDebito->NdbDatoAdicional10 = $fila['NdbDatoAdicional10'];
					
					$NotaDebito->NdbDatoAdicional11 = $fila['NdbDatoAdicional11'];
					$NotaDebito->NdbDatoAdicional12 = $fila['NdbDatoAdicional12'];
					$NotaDebito->NdbDatoAdicional13 = $fila['NdbDatoAdicional13'];
					$NotaDebito->NdbDatoAdicional14 = $fila['NdbDatoAdicional14'];
					$NotaDebito->NdbDatoAdicional15 = $fila['NdbDatoAdicional15'];
					$NotaDebito->NdbDatoAdicional16 = $fila['NdbDatoAdicional16'];
					$NotaDebito->NdbDatoAdicional17 = $fila['NdbDatoAdicional17'];
					$NotaDebito->NdbDatoAdicional18 = $fila['NdbDatoAdicional18'];
					$NotaDebito->NdbDatoAdicional19 = $fila['NdbDatoAdicional19'];
					$NotaDebito->NdbDatoAdicional20 = $fila['NdbDatoAdicional20'];
					
					$NotaDebito->NdbDatoAdicional21 = $fila['NdbDatoAdicional21'];
					$NotaDebito->NdbDatoAdicional22 = $fila['NdbDatoAdicional22'];
					$NotaDebito->NdbDatoAdicional23 = $fila['NdbDatoAdicional23'];
					$NotaDebito->NdbDatoAdicional24 = $fila['NdbDatoAdicional24'];
					$NotaDebito->NdbDatoAdicional25 = $fila['NdbDatoAdicional25'];
					$NotaDebito->NdbDatoAdicional26 = $fila['NdbDatoAdicional26'];
					
					$NotaDebito->NdbEstado = $fila['NdbEstado'];

					$NotaDebito->NdbTotalImpuestoSelectivo = $fila['NdbTotalImpuestoSelectivo']; 
					$NotaDebito->NdbTotalGravado = $fila['NdbTotalGravado']; 
					$NotaDebito->NdbTotalDescuento = $fila['NdbTotalDescuento']; 
					$NotaDebito->NdbTotalGratuito = $fila['NdbTotalGratuito']; 
					$NotaDebito->NdbTotalExonerado = $fila['NdbTotalExonerado']; 
					$NotaDebito->NdbTotalPagar = $fila['NdbTotalPagar'];

					$NotaDebito->NdbSubTotal = $fila['NdbSubTotal']; 
					$NotaDebito->NdbDescuento = $fila['NdbDescuento']; 
					$NotaDebito->NdbImpuesto = $fila['NdbImpuesto']; 
					$NotaDebito->NdbTotal = $fila['NdbTotal']; 

					list($NotaDebito->NdbObservacion,$NotaDebito->NdbObservacionImpresa) = explode("###",$fila['NdbObservacion']);								
					$NotaDebito->NdbMotivo = $fila['NdbMotivo'];
					$NotaDebito->NdbMotivoCodigo = $fila['NdbMotivoCodigo'];
					
					$NotaDebito->NdbSunatRespuestaTicket = $fila['NdbSunatRespuestaTicket'];
					$NotaDebito->NdbSunatRespuestaTicketEstado = $fila['NdbSunatRespuestaTicketEstado'];
					$NotaDebito->NdbSunatRespuestaObservacion = $fila['NdbSunatRespuestaObservacion'];

					$NotaDebito->NdbSunatRespuestaEnvioTicket = $fila['NdbSunatRespuestaEnvioTicket'];
					$NotaDebito->NdbSunatRespuestaEnvioTicketEstado = $fila['NdbSunatRespuestaEnvioTicketEstado'];
					$NotaDebito->NdbSunatRespuestaEnvioFecha = $fila['NNdbSunatRespuestaEnvioFecha'];
					$NotaDebito->NdbSunatRespuestaEnvioHora = $fila['NdbSunatRespuestaEnvioHora'];
					$NotaDebito->NdbSunatRespuestaEnvioCodigo = $fila['NdbSunatRespuestaEnvioCodigo'];
					$NotaDebito->NdbSunatRespuestaEnvioContenido = $fila['NdbSunatRespuestaEnvioContenido'];
					
					$NotaDebito->NdbSunatRespuestaBajaTicket = $fila['NdbSunatRespuestaBajaTicket']; 	
					$NotaDebito->NdbSunatRespuestaBajaTicketEstado = $fila['NdbSunatRespuestaBajaTicketEstado'];
					$NotaDebito->NdbSunatRespuestaBajaFecha = $fila['NNdbSunatRespuestaBajaFecha'];
					$NotaDebito->NdbSunatRespuestaBajaHora = $fila['NdbSunatRespuestaBajaHora']; 	
					$NotaDebito->NdbSunatRespuestaBajaCodigo = $fila['NdbSunatRespuestaBajaCodigo']; 	
					$NotaDebito->NdbSunatRespuestaBajaContenido = $fila['NdbSunatRespuestaBajaContenido']; 	
					$NotaDebito->NdbSunatRespuestaBajaId = $fila['NdbSunatRespuestaBajaId']; 	
					
					$NotaDebito->NdbSunatRespuestaConsultaCodigo = $fila['NdbSunatRespuestaConsultaCodigo']; 	
					$NotaDebito->NdbSunatRespuestaConsultaContenido = $fila['NdbSunatRespuestaConsultaContenido']; 	
					$NotaDebito->NdbSunatRespuestaConsultaFecha = $fila['NNdbSunatRespuestaConsultaFecha']; 	
					$NotaDebito->NdbSunatRespuestaConsultaHora = $fila['NdbSunatRespuestaConsultaHora']; 	
					
					$NotaDebito->NdbSunatRespuestaEnvioTiempoCreacion = $fila['NNdbSunatRespuestaEnvioTiempoCreacion']; 	
					$NotaDebito->NdbSunatRespuestaConsultaTiempoCreacion = $fila['NNdbSunatRespuestaConsultaTiempoCreacion']; 	
					$NotaDebito->NdbSunatRespuestaBajaTiempoCreacion = $fila['NNdbSunatRespuestaBajaTiempoCreacion']; 	
					
					$NotaDebito->NdbSunatUltimaAccion = $fila['NdbSunatUltimaAccion']; 	
					$NotaDebito->NdbSunatUltimaRespuesta = $fila['NdbSunatUltimaRespuesta']; 	
															
					$NotaDebito->NdbCierre = $fila['NdbCierre'];					
                   	$NotaDebito->NdbTiempoCreacion = $fila['NNdbTiempoCreacion'];
                    $NotaDebito->NdbTiempoModificacion = $fila['NNdbTiempoModificacion'];
					
					$NotaDebito->NdbTotalItems = $fila['NdbTotalItems'];
					
					$NotaDebito->NdtNumero = $fila['NdtNumero'];
					
					$NotaDebito->CliNombreCompleto = $fila['CliNombreCompleto'];
					$NotaDebito->CliNombre = $fila['CliNombre'];
					$NotaDebito->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$NotaDebito->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$NotaDebito->TdoId = $fila['TdoId'];
					$NotaDebito->CliNumeroDocumento = $fila['CliNumeroDocumento'];					
					$NotaDebito->CliTelefono = $fila['CliTelefono'];
					$NotaDebito->CliEmail = $fila['CliEmail'];
					$NotaDebito->CliCelular = $fila['CliCelular'];
					$NotaDebito->CliFax = $fila['CliFax'];
					
					
					$NotaDebito->MonSigla = $fila['MonSigla'];
					$NotaDebito->MonNombre = $fila['MonNombre'];
					$NotaDebito->MonSimbolo = $fila['MonSimbolo'];

$NotaDebito->TdoNombre = $fila['TdoNombre'];
					$NotaDebito->TdoCodigo = $fila['TdoCodigo'];
	
	$NotaDebito->SucNombre = $fila['SucNombre'];
	$NotaDebito->SucSiglas = $fila['SucSiglas'];
	
				
					$NotaDebito->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $NotaDebito;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		public function MtdObtenerNotaDebitosValor($oFuncion="SUM",$oParametro="NdbId",$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'NdbId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oMes=NULL,$oAno=NULL)  {


		if(!empty($oCampo) && !empty($oFiltro)){

			$oFiltro = str_replace(" ","%",$oFiltro);
			
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

		
		if(!empty($oSucursal)){
			$sucursal = ' AND ndt.SucId = "'.$oSucursal.'"';
		}
				
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (ndb.NdbEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ndb.NdbFechaEmision)>="'.$oFechaInicio.'" AND DATE(ndb.NdbFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ndb.NdbFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ndb.NdbFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(ndb.NdbFechaEmision) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(ndb.NdbFechaEmision) ="'.($oAno).'"';
		}
		
		$sql = 'SELECT

		
				'.$funcion.' AS "RESULTADO"
				FROM tblndbnotadebito ndb
				
				LEFT JOIN tblndtnotadebitotalonario ndt
				ON ndb.NdtId = ndt.NdtId
								
				LEFT JOIN tblclicliente cli
				ON ndb.CliId = cli.CliId
				

				
				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$fecha.$mes.$ano.$orden.$paginacion;


			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}
		
		
		
	public function MtdActualizarEstadoNotaDebito($oElementos,$oEstado) {
		
		$accion = '';
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
				
					/*if($i==count($elementos)){						
						$accion .= '  (NdbId = "'.($aux[0]).'" AND NdtId = "'.($aux[1]).'")';	
					}else{
						$accion .= '  (NdbId = "'.($aux[0]).'" AND NdtId = "'.($aux[1]).'")  OR';	
					}	*/
					
					
					$sql = 'UPDATE tblndbnotadebito SET NdbEstado = '.$oEstado.' WHERE   (NdbId = "'.($aux[0]).'" AND NdtId = "'.($aux[1]).'")';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->NdbId = $aux[0];
						$this->NdtId = $aux[1];
						$this->MtdAuditarNotaDebito(2,"Se actualizo el Estado de la Nota de Debito",$aux);	
					}
				}
			$i++;
	
			}
		
			/*$sql = 'UPDATE tblndbnotadebito SET NdbEstado = '.$oEstado.' WHERE '.$accion;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	*/	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}

	//Accion eliminar	 
	
	public function MtdEliminarNotaDebito($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
					/*		
					if($i==count($elementos)){						
						$eliminar .= '  (NdbId = "'.($aux[0]).'" AND NdtId = "'.($aux[1]).'")';	
					}else{
						$eliminar .= '  (NdbId = "'.($aux[0]).'" AND NdtId = "'.($aux[1]).'")  OR';	
					}	*/
					
					$sql = 'DELETE FROM tblndbnotadebito WHERE (NdbId = "'.($aux[0]).'" AND NdtId = "'.($aux[1]).'")';
				
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
					if(!$resultado) {						
						$error = true;
					}else{
						$this->NdbId = $aux[0];
						$this->NdtId = $aux[1];
						$this->MtdAuditarNotaDebito(3,"Se elimino la Nota de Debito",$aux);	
					}
				}
			$i++;
	
			}
		
		
/*			$sql = 'DELETE FROM tblndbnotadebito WHERE '.$eliminar;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		*/
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarNotaDebito() {
	
		global $Resultado;
		$error = false;

		//if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->NdbFechaEmision))){
//			$error = true;
//			$Resultado.='#ERR_NDB_400';
//		}else{
			
			$this->NdbId = trim($this->NdbId);

			$this->InsMysql->MtdTransaccionIniciar();
				
//deb($this->NdbTipo." aaa");
			
				switch($this->NdbTipo){
					case 2:
						$detalle ='"'.$this->DocId.'", "'.$this->DtaId.'", NULL, NULL, NULL, NULL,';
					break;
					
					case 3:
						$detalle ='NULL, NULL, "'.$this->DocId.'", "'.$this->DtaId.'", NULL, NULL,';
					break;
					
					case 4:
						$detalle ='NULL, NULL, NULL, NULL,"'.$this->DocId.'", "'.$this->DtaId.'",';
					break;
					
					default:
						$detalle ='NULL,NULL,NULL,NULL,NULL, NULL,';
					break;
					
	
				}
	
				//$this->MtdGenerarNotaDebitoId();
			
				$sql = 'INSERT INTO tblndbnotadebito (
				NdbId,
				NdtId,
				SucId,
				
				FacId,
				FtaId,
				BolId,
				BtaId,
				
				NcrId,
				NctId,
				
				CliId,
				NdbTipo,
				NdbEstado,
				NdbFechaEmision,
				NdbDireccion,
				
				NdbTotalPagar,	
				NdbTotalImpuestoSelectivo,
				NdbTotalExonerado,	
				NdbTotalDescuento,	
				NdbTotalGratuito,	
				NdbTotalGravado,
				
				NdbSubTotal,
				NdbImpuesto,
				NdbTotal,
				
				NdbObservacion,
				NdbMotivo,
				NdbMotivoCodigo,

				NdbIncluyeImpuesto,
				NdbPorcentajeImpuestoVenta,
				NdbPorcentajeImpuestoSelectivo,
				
				MonId,
				NdbTipoCambio,
				
				NdbDatoAdicional1,
				NdbDatoAdicional2,
				NdbDatoAdicional3,
				NdbDatoAdicional4,
				NdbDatoAdicional5,
				NdbDatoAdicional6,
				NdbDatoAdicional7,
				NdbDatoAdicional8,
				NdbDatoAdicional9,
				NdbDatoAdicional10,
				
				NdbDatoAdicional11,
				NdbDatoAdicional12,
				NdbDatoAdicional13,
				NdbDatoAdicional14,
				NdbDatoAdicional15,
				NdbDatoAdicional16,
				NdbDatoAdicional17,
				NdbDatoAdicional18,
				NdbDatoAdicional19,
				NdbDatoAdicional20,
				
				NdbDatoAdicional21,
				NdbDatoAdicional22,
				NdbDatoAdicional23,
				NdbDatoAdicional24,
				NdbDatoAdicional25,
				NdbDatoAdicional26,
				
				NdbCierre,
				NdbTiempoCreacion,
				NdbTiempoModificacion
				) 
				VALUES (
				"'.($this->NdbId).'", 
				"'.($this->NdtId).'",
				"'.($this->SucId).'",

				'.$detalle.'

				"'.($this->CliId).'",
				'.($this->NdbTipo).',				
				'.($this->NdbEstado).',				
				"'.($this->NdbFechaEmision).'",
				"'.($this->NdbDireccion).'",

				'.($this->NdbTotalPagar).',
				'.($this->NdbTotalImpuestoSelectivo).',
				'.($this->NdbTotalExonerado).',
				'.($this->NdbTotalDescuento).',
				'.($this->NdbTotalGratuito).',
				'.($this->NdbTotalGravado).',

				'.($this->NdbSubTotal).',
				'.($this->NdbImpuesto).',
				'.($this->NdbTotal).',

				"'.($this->NdbObservacion).'", 
				"'.addslashes($this->NdbMotivo).'", 
				"'.($this->NdbMotivoCodigo).'", 

				'.($this->NdbIncluyeImpuesto).', 
				'.($this->NdbPorcentajeImpuestoVenta).', 	
				'.($this->NdbPorcentajeImpuestoSelectivo).', 				
				
				"'.($this->MonId).'", 
				'.(empty($this->NdbTipoCambio)?'NULL, ':''.$this->NdbTipoCambio.',').'
				
				"'.($this->NdbDatoAdicional1).'", 
				"'.($this->NdbDatoAdicional2).'", 
				"'.($this->NdbDatoAdicional3).'", 
				"'.($this->NdbDatoAdicional4).'", 
				"'.($this->NdbDatoAdicional5).'", 
				"'.($this->NdbDatoAdicional6).'", 
				"'.($this->NdbDatoAdicional7).'", 
				"'.($this->NdbDatoAdicional8).'", 
				"'.($this->NdbDatoAdicional9).'", 
				"'.($this->NdbDatoAdicional10).'", 
				
				"'.($this->NdbDatoAdicional11).'", 
				"'.($this->NdbDatoAdicional12).'", 
				"'.($this->NdbDatoAdicional13).'", 
				"'.($this->NdbDatoAdicional14).'", 
				"'.($this->NdbDatoAdicional15).'", 
				"'.($this->NdbDatoAdicional16).'", 
				"'.($this->NdbDatoAdicional17).'", 
				"'.($this->NdbDatoAdicional18).'", 
				"'.($this->NdbDatoAdicional19).'", 
				"'.($this->NdbDatoAdicional20).'", 
				
				"'.($this->NdbDatoAdicional21).'", 
				"'.($this->NdbDatoAdicional22).'", 
				"'.($this->NdbDatoAdicional23).'", 
				"'.($this->NdbDatoAdicional24).'", 
				"'.($this->NdbDatoAdicional25).'", 
				"'.($this->NdbDatoAdicional26).'", 
				
				2, 
				"'.($this->NdbTiempoCreacion).'", 
				"'.($this->NdbTiempoModificacion).'");';
	
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;				
					} 
				}
				
				if(!$error){			
				
					if (!empty($this->NotaDebitoDetalle)){		
							
						$validar = 0;				
						$InsNotaDebitoDetalle = new ClsNotaDebitoDetalle($this->InsMysql);		
								
						foreach ($this->NotaDebitoDetalle as $DatNotaDebitoDetalle){
						
							$InsNotaDebitoDetalle->NdbId = $this->NdbId;
							$InsNotaDebitoDetalle->NdtId = $this->NdtId;
							
							$InsNotaDebitoDetalle->NddCodigo= $DatNotaDebitoDetalle->NddCodigo;
							$InsNotaDebitoDetalle->NddDescripcion = $DatNotaDebitoDetalle->NddDescripcion;
							$InsNotaDebitoDetalle->NddUnidadMedida = $DatNotaDebitoDetalle->NddUnidadMedida;
						
							$InsNotaDebitoDetalle->NddPrecio = $DatNotaDebitoDetalle->NddPrecio;
							$InsNotaDebitoDetalle->NddCantidad = $DatNotaDebitoDetalle->NddCantidad;
							$InsNotaDebitoDetalle->NddImporte = $DatNotaDebitoDetalle->NddImporte;
							
							$InsNotaDebitoDetalle->NddValorVenta = $DatNotaDebitoDetalle->NddValorVenta;
							$InsNotaDebitoDetalle->NddImpuesto = $DatNotaDebitoDetalle->NddImpuesto;
							$InsNotaDebitoDetalle->NddImpuestoSelectivo = $DatNotaDebitoDetalle->NddImpuestoSelectivo;
							
							$InsNotaDebitoDetalle->NddDescuento = $DatNotaDebitoDetalle->NddDescuento;
							$InsNotaDebitoDetalle->NddGratuito = $DatNotaDebitoDetalle->NddGratuito;
							$InsNotaDebitoDetalle->NddExonerado = $DatNotaDebitoDetalle->NddExonerado;
							$InsNotaDebitoDetalle->NddIncluyeSelectivo = $DatNotaDebitoDetalle->NddIncluyeSelectivo;
							
							$InsNotaDebitoDetalle->NddEstado = $this->NdbEstado;
							$InsNotaDebitoDetalle->NddTiempoCreacion = $DatNotaDebitoDetalle->NddTiempoCreacion;
							$InsNotaDebitoDetalle->NddTiempoModificacion = $DatNotaDebitoDetalle->NddTiempoModificacion;						
							$InsNotaDebitoDetalle->NddEliminado = $DatNotaDebitoDetalle->NddEliminado;
							
							if($InsNotaDebitoDetalle->MtdRegistrarNotaDebitoDetalle()){
								$validar++;					
							}else{
								$Resultado.='#ERR_NDB_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->NotaDebitoDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
				
				
	
	
		//}

		if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarNotaDebito(1,"Se registro la Nota de Debito",$this);			
				return true;
			}			
			
	}
	
	public function MtdEditarNotaDebito() {
		
		global $Resultado;
		$error = false;

		//if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->NdbFechaEmision))){
//			$error = true;
//			$Resultado.='#ERR_NDB_400';
//		}else{
			
		switch($this->NdbTipo){
				
				case 2:
					$detalle ='FacId = "'.$this->DocId.'", FtaId = "'.$this->DtaId.'", BolId = NULL, BtaId = NULL, NcrId = NULL, NctId = NULL, ';
				break;
				
				case 3:
					$detalle ='FacId = NULL, FtaId = NULL, BolId = "'.$this->DocId.'", BtaId = "'.$this->DtaId.'", NcrId = NULL, NctId = NULL,';
				break;
				
				case 4:
					$detalle ='FacId = NULL, FtaId = NULL, BolId = NULL, BtaId = NULL, NcrId = "'.$this->DocId.'", NctId = "'.$this->DtaId.'",';
				break;
				
				
				default:
					$detalle ='NULL,NULL,NULL,NULL,';
				break;
			
			}
				
			$this->InsMysql->MtdTransaccionIniciar();

//	'.$detalle.'
				$sql = 'UPDATE tblndbnotadebito SET 
			
				CliId = "'.($this->CliId).'",
				NdbEstado = "'.($this->NdbEstado).'",
				NdbFechaEmision = "'.($this->NdbFechaEmision).'",
				NdbDireccion = "'.($this->NdbDireccion).'",

				NdbTotalPagar = '.($this->NdbTotalPagar).',
				NdbTotalImpuestoSelectivo = '.($this->NdbTotalImpuestoSelectivo).',
				NdbTotalExonerado = '.($this->NdbTotalExonerado).',
				NdbTotalDescuento = '.($this->NdbTotalDescuento).',
				NdbTotalGratuito = '.($this->NdbTotalGratuito).',
				NdbTotalGravado = '.($this->NdbTotalGravado).',
				
				NdbSubTotal = '.($this->NdbSubTotal).',
				NdbImpuesto = '.($this->NdbImpuesto).',
				NdbTotal = '.($this->NdbTotal).',	
						
				NdbObservacion = "'.($this->NdbObservacion).'",
				NdbMotivo = "'.addslashes($this->NdbMotivo).'",
				NdbMotivoCodigo = "'.($this->NdbMotivoCodigo).'",
				
				NdbIncluyeImpuesto = '.($this->NdbIncluyeImpuesto).',
				NdbPorcentajeImpuestoVenta = '.($this->NdbPorcentajeImpuestoVenta).',	
				NdbPorcentajeImpuestoSelectivo = '.($this->NdbPorcentajeImpuestoSelectivo).',	
				
				MonId = "'.($this->MonId).'",
				'.(empty($this->NdbTipoCambio)?'NdbTipoCambio = NULL, ':'NdbTipoCambio = "'.$this->NdbTipoCambio.'",').'
				
				NdbDatoAdicional1 = "'.($this->NdbDatoAdicional1).'",
				NdbDatoAdicional2 = "'.($this->NdbDatoAdicional2).'",
				NdbDatoAdicional3 = "'.($this->NdbDatoAdicional3).'",
				NdbDatoAdicional4 = "'.($this->NdbDatoAdicional4).'",
				NdbDatoAdicional5 = "'.($this->NdbDatoAdicional5).'",
				NdbDatoAdicional6 = "'.($this->NdbDatoAdicional6).'",
				NdbDatoAdicional7 = "'.($this->NdbDatoAdicional7).'",
				NdbDatoAdicional8 = "'.($this->NdbDatoAdicional9).'",
				NdbDatoAdicional9 = "'.($this->NdbDatoAdicional10).'",
				NdbDatoAdicional10 = "'.($this->NdbDatoAdicional1).'",

				NdbDatoAdicional11 = "'.($this->NdbDatoAdicional11).'",
				NdbDatoAdicional12 = "'.($this->NdbDatoAdicional12).'",
				NdbDatoAdicional13 = "'.($this->NdbDatoAdicional13).'",
				NdbDatoAdicional14 = "'.($this->NdbDatoAdicional14).'",
				NdbDatoAdicional15 = "'.($this->NdbDatoAdicional15).'",
				NdbDatoAdicional16 = "'.($this->NdbDatoAdicional16).'",
				NdbDatoAdicional17 = "'.($this->NdbDatoAdicional17).'",
				NdbDatoAdicional18 = "'.($this->NdbDatoAdicional18).'",
				NdbDatoAdicional19 = "'.($this->NdbDatoAdicional19).'",
				NdbDatoAdicional20 = "'.($this->NdbDatoAdicional20).'",

				NdbDatoAdicional21 = "'.($this->NdbDatoAdicional21).'",
				NdbDatoAdicional22 = "'.($this->NdbDatoAdicional22).'",
				NdbDatoAdicional23 = "'.($this->NdbDatoAdicional23).'",
				NdbDatoAdicional24 = "'.($this->NdbDatoAdicional24).'",
				NdbDatoAdicional25 = "'.($this->NdbDatoAdicional25).'",
				NdbDatoAdicional26 = "'.($this->NdbDatoAdicional26).'",

				NdbTiempoModificacion = "'.($this->NdbTiempoModificacion).'"			
				WHERE NdbId = "'.($this->NdbId).'"
				AND NdtId = "'.$this->NdtId.'";';
				
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
					} 
				}
				
				if(!$error){
				
					if (!empty($this->NotaDebitoDetalle)){		
							
						$validar = 0;				
						$InsNotaDebitoDetalle = new ClsNotaDebitoDetalle($this->InsMysql);		
								
						foreach ($this->NotaDebitoDetalle as $DatNotaDebitoDetalle){
											
							$InsNotaDebitoDetalle->NddId = $DatNotaDebitoDetalle->NddId;
							$InsNotaDebitoDetalle->NdbId = $this->NdbId;
							$InsNotaDebitoDetalle->NdtId = $this->NdtId;
							
							$InsNotaDebitoDetalle->NddCodigo= $DatNotaDebitoDetalle->NddCodigo;
							$InsNotaDebitoDetalle->NddDescripcion = $DatNotaDebitoDetalle->NddDescripcion;
							$InsNotaDebitoDetalle->NddUnidadMedida = $DatNotaDebitoDetalle->NddUnidadMedida;
						
							$InsNotaDebitoDetalle->NddPrecio = $DatNotaDebitoDetalle->NddPrecio;
							$InsNotaDebitoDetalle->NddCantidad = $DatNotaDebitoDetalle->NddCantidad;
							$InsNotaDebitoDetalle->NddImporte = $DatNotaDebitoDetalle->NddImporte;
							
							$InsNotaDebitoDetalle->NddValorVenta = $DatNotaDebitoDetalle->NddValorVenta;
							$InsNotaDebitoDetalle->NddImpuesto = $DatNotaDebitoDetalle->NddImpuesto;
							$InsNotaDebitoDetalle->NddImpuestoSelectivo = $DatNotaDebitoDetalle->NddImpuestoSelectivo;
							$InsNotaDebitoDetalle->NddDescuento = $DatNotaDebitoDetalle->NddDescuento;
							
							$InsNotaDebitoDetalle->NddGratuito = $DatNotaDebitoDetalle->NddGratuito;
							$InsNotaDebitoDetalle->NddExonerado = $DatNotaDebitoDetalle->NddExonerado;
							$InsNotaDebitoDetalle->NddIncluyeSelectivo = $DatNotaDebitoDetalle->NddIncluyeSelectivo;
															
							$InsNotaDebitoDetalle->NddEstado = $this->NdbEstado;
							$InsNotaDebitoDetalle->NddTiempoCreacion = $DatNotaDebitoDetalle->NddTiempoCreacion;
							$InsNotaDebitoDetalle->NddTiempoModificacion = $DatNotaDebitoDetalle->NddTiempoModificacion;
							$InsNotaDebitoDetalle->NddEliminado = $DatNotaDebitoDetalle->NddEliminado;
							
							if(empty($InsNotaDebitoDetalle->NddId)){
								if($InsNotaDebitoDetalle->NddEliminado<>2){
									if($InsNotaDebitoDetalle->MtdRegistrarNotaDebitoDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_NDB_201';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}else{
									$validar++;		
								}
							}else{						
								if($InsNotaDebitoDetalle->NddEliminado==2){
									if($InsNotaDebitoDetalle->MtdEliminarNotaDebitoDetalle($InsNotaDebitoDetalle->NddId)){
										$validar++;					
									}else{
										$Resultado.='#ERR_NDB_203';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}else{
									if($InsNotaDebitoDetalle->MtdEditarNotaDebitoDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_NDB_202';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}
							}									
						}
						
						
						if(count($this->NotaDebitoDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
			
			
		//}
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarNotaDebito(2,"Se edito la Nota de Debito",$this);				
				return true;
			}
				
		}	
		
	
	public function MtdEditarIdNotaDebito() {
			
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();
				
			$sql = 'UPDATE tblndbnotadebito SET 
			NdbId = "'.($this->NNdbId).'",
			NdbTiempoModificacion = "'.($this->NdbTiempoModificacion).'"
			WHERE NdbId = "'.($this->NdbId).'"
			AND NdtId = "'.$this->NdtId.'";';

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			if(!$resultado) {							
				$error = true;
			} 

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();
				
				$this->MtdAuditarNotaDebito(2,"Se edito el Codigo de la Nota de Debito",$this);	
					
				return true;
			}
						
		}
		
	
		private function MtdAuditarNotaDebito($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->NdbId;
			$InsAuditoria->AudCodigoExtra = $this->NdtId;
			$InsAuditoria->UsuId = $this->UsuId;
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
		
		
			public function MtdEditarNotaDebitoDato($oCampo,$oDato,$oId,$oTalonario) {

			$sql = 'UPDATE tblndbnotadebito SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			NdbTiempoModificacion = NOW()
			WHERE NdbId = "'.($oId).'"
			AND NdtId = "'.($oTalonario).'"
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





		
	
		public function MtdNotaDebitoGenerarArchivoXML($oTalonario,$oId,$oRuta="") {
		
			global $EmpresaCodigo;
			global $EmpresaNombre;
			global $EmpresaDireccion;
			global $EmpresaMonedaId;
			
			if(!empty($oTalonario) and !empty($oId)){
				
					
				$this->NdbId = $oId;
				$this->NdtId = $oTalonario;
				$this->MtdObtenerNotaDebito(true);
				
					
					
					$InsNotaDebito = $this;
					
					
					
					
					
					
					
//deb($InsNotaDebito->NdbTipoCambio);
if($InsNotaDebito->MonId<>$EmpresaMonedaId){
	
	$InsNotaDebito->NdbTotalGravado = round($InsNotaDebito->NdbTotalGravado/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalExonerado = round($InsNotaDebito->NdbTotalExonerado/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalGratuito = round($InsNotaDebito->NdbTotalGratuito/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalDescuento = round($InsNotaDebito->NdbTotalDescuento/$InsNotaDebito->NdbTipoCambio,2);

	
	$InsNotaDebito->NdbTotalPagar = round($InsNotaDebito->NdbTotalPagar/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotalDescuento = round($InsNotaDebito->NdbTotalDescuento/$InsNotaDebito->NdbTipoCambio,2);
	
	$InsNotaDebito->NdbSubTotal = round($InsNotaDebito->NdbSubTotal/$InsNotaDebito->NdbTipoCambio,2);	
	$InsNotaDebito->NdbImpuesto = round($InsNotaDebito->NdbImpuesto/$InsNotaDebito->NdbTipoCambio,2);
	$InsNotaDebito->NdbTotal = round($InsNotaDebito->NdbTotal/$InsNotaDebito->NdbTipoCambio,2);	
	
}



$InsNotaDebito->NdbTotal = round($InsNotaDebito->NdbTotal,2);
list($parte_entero,$parte_decimal) = explode(".",$InsNotaDebito->NdbTotal);

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

$NotaDebitoTotalLetras = "SON ".$numalet->letra()." CON ".$parte_decimal."/100 ".$InsNotaDebito->MonNombre;


$NOMBRE = $EmpresaCodigo.'-08-'.$InsNotaDebito->NdtNumero.'-'.$InsNotaDebito->NdbId;
$ARCHIVO = $NOMBRE.'.xml';


$domtree = new DOMDocument('1.0', 'ISO-8859-1');
//$domtree->preserveWhiteSpace = false;
$domtree->formatOutput = true;
$domtree->xmlStandalone = false;

/* create the root element of the xml tree */
$xmlRoot = $domtree->createElement("DebitNote");
/* append it to the document created */
$xmlRoot = $domtree->appendChild($xmlRoot);

$xmlRoot->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2');
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
$UBLVersionID = $domtree->createElement("cbc:UBLVersionID","2.1");
$UBLVersionID = $xmlRoot->appendChild($UBLVersionID);

//ext:CustomizationID
$CustomizationID = $domtree->createElement("cbc:CustomizationID","2.0");
$CustomizationID = $xmlRoot->appendChild($CustomizationID);


//cbc:ID
$ID = $domtree->createElement("cbc:ID",$InsNotaDebito->NdtNumero."-".$InsNotaDebito->NdbId);
$ID = $xmlRoot->appendChild($ID);

//cbc:IssueDate
$IssueDate = $domtree->createElement("cbc:IssueDate",FncCambiaFechaAMysql($InsNotaDebito->NdbFechaEmision));
$IssueDate = $xmlRoot->appendChild($IssueDate);
//cbc:IssueTime
$IssueTime = $domtree->createElement("cbc:IssueTime",($InsNotaDebito->NdbHoraEmision));
$IssueTime = $xmlRoot->appendChild($IssueTime);

//cbc:Note
//$Note = $domtree->createElement("cbc:Note",$domtree->createCDATASection($NotaDebitoTotalLetras));
$Note = $domtree->createElement("cbc:Note",($NotaDebitoTotalLetras));
$Note->setAttribute('languageLocaleID', "1000");
$Note = $xmlRoot->appendChild($Note);

//cbc:DocumentCurrencyCode
$DocumentCurrencyCode = $domtree->createElement("cbc:DocumentCurrencyCode",$InsNotaDebito->MonSigla);
$DocumentCurrencyCode = $xmlRoot->appendChild($DocumentCurrencyCode);


//cbc:DiscrepancyResponse
$DiscrepancyResponse = $domtree->createElement("cac:DiscrepancyResponse");
$DiscrepancyResponse = $xmlRoot->appendChild($DiscrepancyResponse);

	//cbc:ReferenceID
	$ReferenceID = $domtree->createElement("cbc:ReferenceID",$InsNotaDebito->DtaNumero."-".$InsNotaDebito->DocId);
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
	$ResponseCode = $domtree->createElement("cbc:ResponseCode",$InsNotaDebito->NdbMotivoCodigo);
	$ResponseCode = $DiscrepancyResponse->appendChild($ResponseCode);
	
	//cac:ResponseCode
	$Description = $domtree->createElement("cbc:Description",$InsNotaDebito->NdbMotivo);
	$Description = $DiscrepancyResponse->appendChild($Description);



//cbc:BillingReference
$BillingReference = $domtree->createElement("cac:BillingReference");
$BillingReference = $xmlRoot->appendChild($BillingReference);

	//cac:InvoiceDocumentReference
	$InvoiceDocumentReference = $domtree->createElement("cac:InvoiceDocumentReference");
	$InvoiceDocumentReference = $BillingReference->appendChild($InvoiceDocumentReference);
	
		//cac:ResponseCode
		$ID = $domtree->createElement("cbc:ID",$InsNotaDebito->DtaNumero."-".$InsNotaDebito->DocId);
		$ID = $InvoiceDocumentReference->appendChild($ID);
		
		switch($InsNotaDebito->NdbTipo){
			
			case "2": //NOTA DE DEBITO
		
				//cac:DocumentTypeCode
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","01");
				$DocumentTypeCode = $InvoiceDocumentReference->appendChild($DocumentTypeCode);
					
			break;
			
			case "3"://BOLETA
				//cac:DocumentTypeCode
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode","03");
				$DocumentTypeCode = $InvoiceDocumentReference->appendChild($DocumentTypeCode);
				
			break;
			
		}
		
		if(!empty($InsNotaDebito->NdbOtroDocumento	)){
				
			//cbc:BillingReference
			$AdditionalDocumentReference = $domtree->createElement("cac:AdditionalDocumentReference");
			$AdditionalDocumentReference = $xmlRoot->appendChild($AdditionalDocumentReference);	
				
				$ID = $domtree->createElement("cbc:ID",$InsNotaDebito->NdbOtroDocumento);
				$ID = $AdditionalDocumentReference->appendChild($ID);
				
				$DocumentTypeCode = $domtree->createElement("cbc:DocumentTypeCode",$InsNotaDebito->NdbOtroDocumentoCodigo);
				$DocumentTypeCode = $AdditionalDocumentReference->appendChild($DocumentTypeCode);
				
		}

	



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
			$CompanyID = $domtree->createElement("cbc:ID",($InsNotaDebito->CliNumeroDocumento));
			$CompanyID->setAttribute('schemeID', round($InsNotaDebito->TdoCodigo,0));
			$CompanyID->setAttribute('schemeName', "SUNAT:Identificador de Documento de Identidad");
			$CompanyID->setAttribute('schemeAgencyName', "PE:SUNAT");
			$CompanyID->setAttribute('schemeURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06");
			$CompanyID = $PartyIdentification->appendChild($CompanyID);	

						
		//cac:PartyLegalEntity
		$PartyLegalEntity = $domtree->createElement("cac:PartyLegalEntity");
		$PartyLegalEntity = $Party->appendChild($PartyLegalEntity);
			
			 //cbc:RegistrationName		
			$RegistrationName = $PartyLegalEntity->appendChild($domtree->createElement('cbc:RegistrationName')); 
			$RegistrationName->appendChild($domtree->createCDATASection( $InsNotaDebito->CliNombre." ".$InsNotaDebito->CliApellidoPaterno." ".$InsNotaDebito->CliApellidoMaterno)); 
		
		
		
		
	
	//DATOS DE INMPUESTOS		
//cac:TaxTotal
$TaxTotal = $domtree->createElement("cac:TaxTotal");
$TaxTotal = $xmlRoot->appendChild($TaxTotal);

	//cbc:TaxAmount
	//SUMA TOTAL IGV
	$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaDebito->NdbImpuesto,2, '.', ''));
	$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	$TaxAmount = $TaxTotal->appendChild($TaxAmount);
			
	//cac:TaxSubtotal
	$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
	$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
		
		//cbc:TaxableAmount 
		//SUMA TOTAL GRAVADOS
		$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsNotaDebito->NdbTotalGravado,2, '.', ''));
		$TaxableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
		$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
		
		//cbc:TaxAmount 
		$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($InsNotaDebito->NdbImpuesto,2, '.', ''));
		$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
				
				
				
	if($InsNotaDebito->NdbTotalExonerado>0){
	
		//SUMA TOTAL EXONERADOS
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsNotaDebito->NdbTotalExonerado,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
	
		
					
	if($InsNotaDebito->NdbTotalGratuito>0){
	
		//SUMA TOTAL INAFECTO (GRATUITO)
		//cac:TaxSubtotal
		$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
		$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
			
			//cbc:TaxableAmount 
			$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($InsNotaDebito->NdbTotalGratuito,2, '.', ''));
			$TaxableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
			$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
			
			//cbc:TaxAmount 
			$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
			$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
					$ID = $domtree->createElement("cbc:ID","9998");
					$ID->setAttribute('schemeID', "UN/ECE 5153");
					$ID->setAttribute('schemeAgencyID', "6");
					$ID = $TaxScheme->appendChild($ID);
	
					//cbc:Name
					$Name = $domtree->createElement("cbc:Name","INAFECTO");
					$Name = $TaxScheme->appendChild($Name);
	
					//cbc:TaxTypeCode
					$TaxTypeCode = $domtree->createElement("cbc:TaxTypeCode","FRE");
					$TaxTypeCode = $TaxScheme->appendChild($TaxTypeCode);	
					
							
	}		
	
	
 
//cac:LegalMonetaryTotal
$LegalMonetaryTotal = $domtree->createElement("cac:LegalMonetaryTotal");
$LegalMonetaryTotal = $xmlRoot->appendChild($LegalMonetaryTotal);

	//cbc:AllowanceTotalAmount 
	//SUMA TOTAL DESCUENTOS GENERAL + ITEMS
	$AllowanceTotalAmount = $domtree->createElement("cbc:AllowanceTotalAmount",number_format($InsNotaDebito->NdbTotalDescuento,2, '.', ''));
	$AllowanceTotalAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	$AllowanceTotalAmount = $LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
	
	//cbc:PayableAmount currencyID="PEN"
	$PayableAmount = $domtree->createElement("cbc:PayableAmount",number_format($InsNotaDebito->NdbTotal,2, '.', ''));
	$PayableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
	$PayableAmount = $LegalMonetaryTotal->appendChild($PayableAmount);


$fila = 1;
if(!empty($InsNotaDebito->NotaDebitoDetalle)){
	foreach($InsNotaDebito->NotaDebitoDetalle as $DatNotaDebitoDetalle){
		
		if($InsNotaDebito->MonId<>$EmpresaMonedaId){
			
			$DatNotaDebitoDetalle->NddValorVenta = round($DatNotaDebitoDetalle->NddValorVenta/$InsNotaDebito->NdbTipoCambio,2);
			$DatNotaDebitoDetalle->NddValorVentaUnitario = round($DatNotaDebitoDetalle->NddValorVentaUnitario/$InsNotaDebito->NdbTipoCambio,2);
			
			$DatNotaDebitoDetalle->NddPrecio = round($DatNotaDebitoDetalle->NddPrecio/$InsNotaDebito->NdbTipoCambio,2);
			$DatNotaDebitoDetalle->NddImpuesto = round($DatNotaDebitoDetalle->NddImpuesto/$InsNotaDebito->NdbTipoCambio,2);
			
		}
		
			
			
		//cac:InvoiceLine
		$InvoiceLine = $domtree->createElement("cac:DebitNoteLine");
		$InvoiceLine = $xmlRoot->appendChild($InvoiceLine);	
			
			//cbc:ID
			$ID = $domtree->createElement("cbc:ID",$fila);
			$ID = $InvoiceLine->appendChild($ID);	
			
			//cbc:DebitedQuantity unitCode="NIU"
			$DebitedQuantity = $domtree->createElement("cbc:DebitedQuantity",number_format($DatNotaDebitoDetalle->NddCantidad,2, '.', ''));
			
			if($DatNotaDebitoDetalle->NddValidarStock==2){
				$DebitedQuantity->setAttribute('unitCode', 'ZZ');
			}else{
				$DebitedQuantity->setAttribute('unitCode', 'NIU');	
			}
			$DebitedQuantity->setAttribute('unitCodeListID', 'UN/ECE rec 20');
			$DebitedQuantity->setAttribute('unitCodeListAgencyName', 'Europe');
			$DebitedQuantity = $InvoiceLine->appendChild($DebitedQuantity);	
			
			//cbc:LineExtensionAmount currencyID="PEN"
			$LineExtensionAmount = $domtree->createElement("cbc:LineExtensionAmount",number_format($DatNotaDebitoDetalle->NddValorVenta,2, '.', ''));
			$LineExtensionAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
			$LineExtensionAmount = $InvoiceLine->appendChild($LineExtensionAmount);	
				
			//cac:PricingReference
			$PricingReference = $domtree->createElement("cac:PricingReference");
			$PricingReference = $InvoiceLine->appendChild($PricingReference);	
				
				
			//VALOR REFERENCIAL UNITARIO POR ITEM EN OPERACIONES NO ONEROSAS
			
			if($DatNotaDebitoDetalle->NddGratuito==1){
				
				//cac:AlternativeConditionPrice
				$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
				$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
				
					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
					//cbc:PriceTypeCode
					$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","02");
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
			}else if($DatNotaDebitoDetalle->NddGratuito==2){
			
				//cac:AlternativeConditionPrice
				$AlternativeConditionPrice = $domtree->createElement("cac:AlternativeConditionPrice");
				$AlternativeConditionPrice = $PricingReference->appendChild($AlternativeConditionPrice);
						

					//cbc:PriceAmount currencyID="PEN"
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddPrecio,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$PriceAmount = $AlternativeConditionPrice->appendChild($PriceAmount);	
	
					//cbc:PriceTypeCode
					$PriceTypeCode = $domtree->createElement("cbc:PriceTypeCode","01");
					$PriceTypeCode->setAttribute('listName', "SUNAT:Indicador de Tipo de Precio");
					$PriceTypeCode->setAttribute('listAgencyName', "PE:SUNAT");
					$PriceTypeCode->setAttribute('listURI', "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16");
					$PriceTypeCode = $AlternativeConditionPrice->appendChild($PriceTypeCode);
				
			}
			
			//DESCUENTOS POR ITEM	
		
			if($DatNotaDebitoDetalle->NddDescuento>0){
				
				$DatNotaDebitoDetalle->NddPorcentajeDescuento = round($DatNotaDebitoDetalle->NddPorcentajeDescuento/100,2);
				
				//cac:AllowanceCharge
				$AllowanceCharge = $domtree->createElement("cac:AllowanceCharge");
				$AllowanceCharge = $InvoiceLine->appendChild($AllowanceCharge);					
								
					//cbc:ChargeIndicator
					$ChargeIndicator = $domtree->createElement("cbc:ChargeIndicator","false");
					$ChargeIndicator = $AllowanceCharge->appendChild($ChargeIndicator);
					
					//cbc:AllowanceChargeReasonCode
					$AllowanceChargeReasonCode = $domtree->createElement("cbc:AllowanceChargeReasonCode","00");//X
					$AllowanceChargeReasonCode = $AllowanceCharge->appendChild($AllowanceChargeReasonCode);
								
					////cbc:MultiplierNdbtorNumeric
//					$MultiplierNdbtorNumeric = $domtree->createElement("cbc:MultiplierNdbtorNumeric",$DatNotaDebitoDetalle->NddPorcentajeDescuento);//X
//					$MultiplierNdbtorNumeric = $AllowanceCharge->appendChild($MultiplierNdbtorNumeric);
									
					//cbc:Amount
					$Amount = $domtree->createElement("cbc:Amount",$DatNotaDebitoDetalle->NddDescuento);
					$Amount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$Amount = $AllowanceCharge->appendChild($Amount);		
					
					//cbc:BaseAmount
					$BaseAmount = $domtree->createElement("cbc:BaseAmount",$InsNotaDebitoDetalle1->NddValorVentaBruto);
					$BaseAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$BaseAmount = $AllowanceCharge->appendChild($BaseAmount);		
					
					
			}
					
		
			
			
			
			
			
				
		//cac:TaxTotal
		$TaxTotal = $domtree->createElement("cac:TaxTotal");
		$TaxTotal = $InvoiceLine->appendChild($TaxTotal);
		
		
			if($DatNotaDebitoDetalle->NddExonerado == "1"){
				
				//cbc:TaxAmount
				$TaxAmount = $domtree->createElement("cbc:TaxAmount","0.00");
				$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount","0.00");
					$TaxableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					//cbc:TaxAmount 
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddValorVenta,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
						$Percent = $domtree->createElement("cbc:Percent",$InsNotaDebito->NdbPorcentajeImpuestoVenta);
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
							
							
			}else if($DatNotaDebitoDetalle->NddExonerado == "2"){
				
				
				//cbc:TaxAmount
				$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
				$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
				$TaxAmount = $TaxTotal->appendChild($TaxAmount);
						
				//cac:TaxSubtotal
				$TaxSubtotal = $domtree->createElement("cac:TaxSubtotal");
				$TaxSubtotal = $TaxTotal->appendChild($TaxSubtotal);
					
					//cbc:TaxableAmount 
					$TaxableAmount = $domtree->createElement("cbc:TaxableAmount",number_format($DatNotaDebitoDetalle->NddValorVenta,2, '.', ''));
					$TaxableAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$TaxableAmount = $TaxSubtotal->appendChild($TaxableAmount);
					
					//cbc:TaxAmount 
					$TaxAmount = $domtree->createElement("cbc:TaxAmount",number_format($DatNotaDebitoDetalle->NddImpuesto,2, '.', ''));
					$TaxAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
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
						
						//cbc:Percent
						$Percent = $domtree->createElement("cbc:Percent",$InsNotaDebito->NdbPorcentajeImpuestoVenta);
						$Percent = $TaxCategory->appendChild($Percent);
						
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
							
							
							
			}else{
				
			}
			
						

			//cac:Item
			$Item = $domtree->createElement("cac:Item");
			$Item = $InvoiceLine->appendChild($Item);	

					//cac:PartyName
					$Description = $domtree->createElement("cbc:Description");
					$Description = $Item->appendChild($Description);

					$Description->appendChild($domtree->createCDATASection($DatNotaDebitoDetalle->NddDescripcion )); 

				//cac:SellersItemIdentification		
				$SellersItemIdentification = $domtree->createElement("cac:SellersItemIdentification");
				$SellersItemIdentification = $Item->appendChild($SellersItemIdentification);

					$ID = $domtree->createElement("cbc:ID");
					$ID = $SellersItemIdentification->appendChild($ID);
					$ID->appendChild($domtree->createCDATASection($DatNotaDebitoDetalle->NddCodigo )); 
					
				if(!empty($DatNotaDebitoDetalle->NddCodigoGeneral)){
					
					//cac:CommodityClassification		
					$CommodityClassification = $domtree->createElement("cac:CommodityClassification");
					$CommodityClassification = $Item->appendChild($CommodityClassification);
					
						//cbc:PriceAmount currencyID="PEN"
						$ItemClassificationCode = $domtree->createElement("cbc:ItemClassificationCode",$DatNotaDebitoDetalle->NddCodigoGeneral);
						$ItemClassificationCode->setAttribute('listID', "UNSPSC");
						$ItemClassificationCode->setAttribute('listAgencyName', "GS1 US");
						$ItemClassificationCode->setAttribute('listName', "Item Classification");
						$ItemClassificationCode = $CommodityClassification->appendChild($ItemClassificationCode);	
					
				}
				
				
			//cac:Price
			$Price = $domtree->createElement("cac:Price");
			$Price = $InvoiceLine->appendChild($Price);	
				
				if($DatNotaDebitoDetalle->NddGratuito==1){
					
					//cbc:PriceAmount 
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
				
				}elseif($DatNotaDebitoDetalle->NddGratuito==2){
					
					//cbc:PriceAmount
					$PriceAmount = $domtree->createElement("cbc:PriceAmount",number_format($DatNotaDebitoDetalle->NddValorVentaUnitario,2, '.', ''));
					$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
					
				}else{
					
					//cbc:PriceAmount
					$PriceAmount = $domtree->createElement("cbc:PriceAmount","0.00");
					$PriceAmount->setAttribute('currencyID', $InsNotaDebito->MonSigla);
					$PriceAmount = $Price->appendChild($PriceAmount);	
						
				}
				
				
				
				
				
		
		$fila++;
	}
}
					
					
					
					 
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
