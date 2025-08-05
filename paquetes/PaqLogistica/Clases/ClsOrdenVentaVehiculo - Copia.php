<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenVentaVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenVentaVehiculo {

    public $OvvId;
	public $SucId;
	public $OvvAno;
	public $OvvMes;
	
	public $PerId;
	public $CliId;
	public $OvvFecha;
	public $OvvFechaVigencia;
	public $OvvFechaEntrega;
	
	public $CveId;
	
	public $MonId;
	public $OvvTipoCambio;
	
	public $MpaId;
	
	public $OvvIncluyeImpuesto;
	public $OvvPorcentajeImpuestoVenta;
	
    public $OvvObservacion;
	
	public $OvvTelefono;
	public $OvvCelular;
	public $OvvDireccion;
	public $OvvEmail;
	public $OvvColor;
	
	public $OvvAnoModelo;
	public $OvvAnoFabricacion;
	
	public $VveId;
	public $EinId;

		
	public $OvvSubTotal;
	public $OvvImpuesto;
	public $OvvTotal;
	
	public $OvvCondicionVentaOtro;
	public $OvvObsequioOtro;
	
	public $OvvComprobanteVenta;
	
	public $OvvActaEntregaFecha;
	public $OvvActaEntregaDescripcion;
	
	public $OvvNota;
	public $OvvPlaca;
	public $OvvEstado;
	public $OvvTiempoCreacion;
	public $OvvTiempoModificacion;
    public $OvvEliminado;


	public $OvvFactura;
	public $OvvBoleta;
	
	public $TdoId;
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliDireccion;
	
	
	public $CliNumeroDocumento;
	public $TdoNombre;

	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $VtiNombre;
	
	public $MonSimbolo;
	public $MonNombre;
	
	public $VveFoto;
	
	public $LtiNombre;
	
	public $EinVIN;
	public $EinNombre;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	
	public $SucNombre;
	
//	public $OrdenVentaVehiculoObsequio;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarOrdenVentaVehiculoId() {

		 $sql = 'SELECT	
		suc.SucSiglas AS SIGLA,
		MAX(CONVERT(SUBSTR(ovv.OvvId,16),unsigned)) AS "MAXIMO"
		FROM tblovvordenventavehiculo ovv
			LEFT JOIN tblsucsucursal suc
			ON ovv.SucId = suc.SucId
		WHERE YEAR(ovv.OvvFecha) = "'.$this->OvvAno.'"
		AND MONTH(ovv.OvvFecha) = "'.$this->OvvMes.'"
		AND ovv.SucId = "'.$this->SucId.'"';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->OvvId = "OV-VEH-".$this->OvvAno."-".$this->OvvMes."-10000-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);
		}else{
			$fila['MAXIMO']++;
			$this->OvvId = "OV-VEH-".$this->OvvAno."-".$this->OvvMes."-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);				
		}

	}
		
    public function MtdObtenerOrdenVentaVehiculo($oCompleto=true){

        $sql = 'SELECT 
        ovv.OvvId,
		ovv.SucId,
		
		ovv.PerId,
ovv.PerIdFirmante,
		ovv.CliId,
		ovv.NpaId,

		DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
		DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega",
		
		DATE_FORMAT(ovv.OvvFecha, "%m") AS "OvvMes",
		DATE_FORMAT(ovv.OvvFecha, "%d") AS "OvvDia",
		
		
		ovv.CveId,
		
		ovv.MonId,
		ovv.OvvTipoCambio,
		
		ovv.MpaId,
		
		ovv.OvvIncluyeImpuesto,
		ovv.OvvPorcentajeImpuestoVenta,
	
		ovv.OvvObservacion,
		ovv.OvvObservacionCorreo,
		
		ovv.OvvTelefono,
		ovv.OvvCelular,
		ovv.OvvDireccion,
		ovv.OvvEmail,
		
		
		ovv.VveId,
		ovv.OvvAnoModelo,
		ovv.OvvAnoFabricacion,
		ovv.OvvColor,
		ovv.OvvVehiculoMarca,
		ovv.OvvVehiculoModelo,
		ovv.OvvVehiculoVersion,
		ovv.OvvGLP,
		ovv.EinId,
		
		ovv.OvvPrecio,
		ovv.OvvDescuento,
		ovv.OvvDescuentoGerencia,
		
		ovv.OvvSubTotal,
		ovv.OvvImpuesto,
		ovv.OvvTotal,
		
		ovv.OvvCondicionVentaOtro,

		ovv.OvvObsequioOtro,
		
		ovv.OvvComprobanteVenta,
		ovv.OvvNota,
		ovv.OvvPlaca,
		
		ovv.OvvAprobacion1,
		ovv.OvvAprobacion2,
		ovv.OvvAprobacion3,
		
		ovv.OvvInmediata,
		ovv.OvvEstado,
		DATE_FORMAT(ovv.OvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoCreacion",
        DATE_FORMAT(ovv.OvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoModificacion",

		DATE_FORMAT(ovv.OvvActaEntregaFecha, "%d/%m/%Y") AS "NOvvActaEntregaFecha",
		DATE_FORMAT(ovv.OvvActaEntregaHora, "%H:%i") AS "NOvvActaEntregaHora",
		ovv.OvvFotoActaEntrega,
		
		DATE_FORMAT(ovv.OvvCartaResponsabilidadFecha, "%d/%m/%Y") AS "NOvvCartaResponsabilidadFecha",
		DATE_FORMAT(ovv.OvvCartaCompromisoFecha, "%d/%m/%Y") AS "NOvvCartaCompromisoFecha",
		DATE_FORMAT(ovv.OvvDeclaracionJuradaFecha, "%d/%m/%Y") AS "NOvvDeclaracionJuradaFecha",
		DATE_FORMAT(ovv.OvvDeclaracionJuradaSUNARPFecha, "%d/%m/%Y") AS "NOvvDeclaracionJuradaSUNARPFecha",
		
						
		ovv.OvvActaEntregaDescripcion,
		
		
		
				
				
				(
					SELECT 
					CONCAT(fta.FtaNumero,"-",fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
								
					LIMIT 1
				)  AS OvvFacturaNumero,
		
		
								
				(
					SELECT 
					CONCAT(bta.BtaNumero,"-",bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS OvvBoletaNumero,	
				
		
		@PagMonto:=(SELECT 
		
		SUM(pag.PagMonto)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			
		) AS OvvAbonado,
		
		
		(ovv.OvvTotal - IFNULL(@PagMonto,0)) AS OvvSaldo,
				
			
		(SELECT 
		
		(pag.PagMonto/IFNULL(pag.PagTipoCambio,1))
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			ORDER BY pag.PagFecha DESC LIMIT 1
		) AS OvvPrimerAbono,
		
		
		cli.TdoId,
		CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCommpleto,
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

		
		cli.CliSexo,
		cli.CliEstadoCivil,
		
		DATE_FORMAT(cli.CliFechaNacimiento, "%d/%m/%Y") AS "NCliFechaNacimiento",
		
		
		tdo.TdoNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		vmo.VmaId,
		vma.VmaNombre,

		vve.VmoId,
		vmo.VmoNombre,
		
		vmo.VtiId,
		vti.VtiNombre,
		
		vve.VveNombre,
		
		vve.VveFoto,
		
		per.PerAbreviatura,
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		per.PerTelefono,
		per.PerCelular,
		per.PerEmail,
		
		cve.CveTotal,
		
		ein.VehId,
		
		ein.EinVIN,
		ein.EinNombre,
		
				ein.EinNumeroMotor,
				ein.EinAnoFabricacion,
				ein.EinAnoModelo,
				ein.EinColor,
				ein.EinDUA,
				ein.EinEstadoVehicular,
		
		ein.EinCostoIngreso,
		ein.MonIdIngreso,
		ein.EinTipoCambioIngreso,
				
				vma2.VmaNombre AS OrdenVentaVehiculoVmaNombre,
				vmo2.VmoNombre AS OrdenVentaVehiculoVmoNombre,
				vve2.VveNombre AS OrdenVentaVehiculoVveNombre,
				
				
				
		ein.EinCaracteristica1,
		ein.EinCaracteristica2,
		ein.EinCaracteristica3,
		ein.EinCaracteristica4,
		ein.EinCaracteristica5,
		ein.EinCaracteristica6,
		ein.EinCaracteristica7,
		ein.EinCaracteristica8,
		ein.EinCaracteristica9,
		ein.EinCaracteristica10,
		
		ein.EinCaracteristica11,
		ein.EinCaracteristica12,
		ein.EinCaracteristica13,
		ein.EinCaracteristica14,
		ein.EinCaracteristica15,
		ein.EinCaracteristica16,
		ein.EinCaracteristica17,
		ein.EinCaracteristica18,
		ein.EinCaracteristica19,
		ein.EinCaracteristica20,
				
				
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
				
				mpa.MpaNombre,
				mpa.MpaAbreviatura,
				
				suc.SucNombre,
				suc2.SucNombre AS EinUbicacion,
				
				per2.PerNombre AS PerNombreFirmante,
				per2.PerApellidoPaterno AS PerApellidoPaternoFirmante,
				per2.PerApellidoMaterno AS PerApellidoMaternoFirmante,
				per2.PerNumeroDocumento AS PerNumeroDocumentoFirmante,
				tdo2.TdoNombre AS TdoNombreFirmante,
				
				veh.UmeId
				
        FROM tblovvordenventavehiculo ovv
	
			LEFT JOIN tblcvecotizacionvehiculo cve
			ON ovv.CveId = cve.CveId
			
			LEFT JOIN tblmpamodalidadpago mpa
			ON ovv.MpaId = mpa.MpaId
			
			LEFT JOIN tblclicliente cli
			ON ovv.CliId = cli.CliId
				LEFT JOIN tbltdotipodocumento tdo
				ON cli.TdoId = tdo.TdoId
					LEFT JOIN tblmonmoneda mon
					ON ovv.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON ovv.VveId = vve.VveId
							
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
										LEFT JOIN tblperpersonal per
										ON ovv.PerId = per.PerId
										
										LEFT JOIN tbleinvehiculoingreso ein
										ON ovv.EinId = ein.EinId
										
											LEFT JOIN tblvehvehiculo veh
											ON ein.VehId = veh.VehId
												
												LEFT JOIN tblvvevehiculoversion vve2
												ON ein.VveId = vve2.VveId
												
													LEFT JOIN tblvmovehiculomodelo vmo2
													ON vve2.VmoId = vmo2.VmoId
													
														LEFT JOIN tblvmavehiculomarca vma2
														ON vmo2.Vmaid = vma2.VmaId
														
		LEFT JOIN tblsucsucursal suc
		ON ovv.SucId = suc.SucId
		
		LEFT JOIN tblsucsucursal suc2
		ON ein.SucId = suc2.SucId
					
					LEFT JOIN tblperpersonal per2
					ON ovv.PerIdFirmante = per2.PerId
						LEFT JOIN tbltdotipodocumento tdo2
						ON per2.TdoId = tdo2.TdoId
						
        WHERE ovv.OvvId = "'.$this->OvvId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			//$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();
			//$ResOrdenVentaVehiculoObsequio =  $InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,NULL,NULL,NULL,$fila['OvvId']);
			$this->OvvId = $fila['OvvId'];
			$this->SucId = $fila['SucId'];
			
			$this->PerId = $fila['PerId'];	
			$this->PerIdFirmante = $fila['PerIdFirmante'];	
				
			$this->CliId = $fila['CliId'];	
			$this->NpaId = $fila['NpaId'];
			
			$this->OvvFecha = $fila['NOvvFecha'];
			$this->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
			$this->OvvMes = $fila['OvvMes'];
			$this->OvvDia = $fila['OvvDia'];
			
			list($this->OvvDia,$this->OvvMes,$this->OvvAno) = explode("/",$this->OvvFecha );
			
			$this->CveId = $fila['CveId'];

			$this->MonId = $fila['MonId'];
			$this->OvvTipoCambio = $fila['OvvTipoCambio'];
			
			$this->MpaId = $fila['MpaId'];

			$this->OvvIncluyeImpuesto = $fila['OvvIncluyeImpuesto'];
			$this->OvvPorcentajeImpuestoVenta = $fila['OvvPorcentajeImpuestoVenta'];
			
			$this->OvvObservacion = $fila['OvvObservacion'];
			$this->OvvObservacionCorreo = $fila['OvvObservacionCorreo'];
			
			$this->OvvTelefono = $fila['OvvTelefono'];
			$this->OvvCelular = $fila['OvvCelular'];
			$this->OvvDireccion = $fila['OvvDireccion'];
			
			$this->CliDepartamento = $fila['CliDepartamento'];
			$this->CliProvincia = $fila['CliProvincia'];
			$this->CliDistrito = $fila['CliDistrito'];

			$this->OvvEmail = $fila['OvvEmail'];

			$this->VveId = $fila['VveId'];
			$this->OvvAnoModelo = $fila['OvvAnoModelo'];
			$this->OvvAnoFabricacion = $fila['OvvAnoFabricacion'];
			$this->OvvColor = $fila['OvvColor'];
			
			$this->OvvVehiculoMarca = $fila['OvvVehiculoMarca'];
			$this->OvvVehiculoModelo = $fila['OvvVehiculoModelo'];
			$this->OvvVehiculoVersion = $fila['OvvVehiculoVersion'];
			$this->OvvGLP = $fila['OvvGLP'];
			
			$this->EinId = $fila['EinId'];

			$this->OvvPrecio = $fila['OvvPrecio'];
			$this->OvvDescuento = $fila['OvvDescuento'];
			$this->OvvDescuentoGerencia = $fila['OvvDescuentoGerencia'];
			
			
			
			
			$this->OvvSubTotal = $fila['OvvSubTotal'];
			$this->OvvImpuesto = $fila['OvvImpuesto'];
			$this->OvvTotal = $fila['OvvTotal'];

			$this->OvvCondicionVentaOtro = $fila['OvvCondicionVentaOtro'];

			$this->OvvObsequioOtro = $fila['OvvObsequioOtro'];


			$this->OvvComprobanteVenta = $fila['OvvComprobanteVenta'];
			
			$this->OvvNota = $fila['OvvNota'];
			$this->OvvPlaca = $fila['OvvPlaca'];
			
			$this->OvvAprobacion1 = $fila['OvvAprobacion1'];
			$this->OvvAprobacion2 = $fila['OvvAprobacion2'];
			$this->OvvAprobacion3 = $fila['OvvAprobacion3'];
			
			$this->OvvInmediata = $fila['OvvInmediata'];
			$this->OvvEstado = $fila['OvvEstado'];
			$this->OvvTiempoCreacion = $fila['NOvvTiempoCreacion']; 
			$this->OvvTiempoModificacion = $fila['NOvvTiempoModificacion'];
			
			$this->OvvActaEntregaFecha= $fila['NOvvActaEntregaFecha'];
			$this->OvvActaEntregaHora = $fila['NOvvActaEntregaHora'];
			$this->OvvActaEntregaDescripcion = $fila['OvvActaEntregaDescripcion'];
			$this->OvvFotoActaEntrega = $fila['OvvFotoActaEntrega'];
			
			$this->OvvCartaResponsabilidadFecha= $fila['NOvvCartaResponsabilidadFecha'];
			$this->OvvCartaCompromisoFecha= $fila['NOvvCartaCompromisoFecha'];
			$this->OvvDeclaracionJuradaFecha= $fila['NOvvDeclaracionJuradaFecha'];
			$this->OvvDeclaracionJuradaSUNARPFecha= $fila['NOvvDeclaracionJuradaSUNARPFecha'];
			
			
		
			
			$this->OvvBoletaNumero = $fila['OvvBoletaNumero'];
			$this->OvvFacturaNumero = $fila['OvvFacturaNumero'];
			
			$this->OvvAbonado = $fila['OvvAbonado'];
			$this->OvvAbonadoTipoCambio = $fila['OvvAbonadoTipoCambio'];
			
			$this->OvvSaldo = $fila['OvvSaldo'];
			$this->OvvPrimerAbono = $fila['OvvPrimerAbono'];
			 	
			//$this->OrdenVentaVehiculoObsequio = 	$ResOrdenVentaVehiculoObsequio['Datos'];	
			$this->TdoId = $fila['TdoId']; 	
			$this->CliNombreCompleto = $fila['CliNombreCompleto'];
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];

			$this->CliDireccion = $fila['CliDireccion'];
			
			$this->CliDistrito = $fila['CliDistrito'];
			$this->CliProvincia = $fila['CliProvincia'];
			$this->CliDepartamento = $fila['CliDepartamento'];
			
			
			$this->CliTelefono = $fila['CliTelefono'];
			$this->CliCelular = $fila['CliCelular'];
			$this->CliEmail = $fila['CliEmail'];
			
			$this->CliSexo = $fila['CliSexo'];
			$this->CliEstadoCivil = $fila['CliEstadoCivil'];
			$this->CliFechaNacimiento = $fila['NCliFechaNacimiento'];
	
			$this->TdoNombre = $fila['TdoNombre'];

			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->VmaId = $fila['VmaId'];
			$this->VmaNombre = $fila['VmaNombre'];
			
			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre'];
			
			$this->VveId = $fila['VveId'];
			$this->VveNombre = $fila['VveNombre'];
			$this->VveFoto = $fila['VveFoto'];

			$this->PerAbreviatura = $fila['PerAbreviatura'];
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
		
			$this->PerTelefono = $fila['PerTelefono'];
			$this->PerCelular = $fila['PerCelular'];
			$this->PerFax = $fila['PerFax'];
			$this->PerEmail = $fila['PerEmail'];
			
			$this->CveTotal = $fila['CveTotal'];
			
			$this->VehId = $fila['VehId'];
			
			$this->EinVIN = $fila['EinVIN'];
			$this->EinNombre = $fila['EinNombre'];
			
			$this->EinNumeroMotor = $fila['EinNumeroMotor'];
			$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$this->EinAnoModelo = $fila['EinAnoModelo'];
			
			
			$this->EinColor = $fila['EinColor'];
			$this->EinDUA = $fila['EinDUA'];
			$this->EinEstadoVehicular = $fila['EinEstadoVehicular'];
			
			$this->EinCostoIngreso = $fila['EinCostoIngreso'];
			$this->MonIdIngreso = $fila['MonIdIngreso'];
			$this->EinTipoCambioIngreso = $fila['EinTipoCambioIngreso'];
		
			$this->OrdenVentaVehiculoVmaNombre = $fila['OrdenVentaVehiculoVmaNombre'];
			$this->OrdenVentaVehiculoVmoNombre = $fila['OrdenVentaVehiculoVmoNombre'];
			$this->OrdenVentaVehiculoVveNombre = $fila['OrdenVentaVehiculoVveNombre'];
			
				$this->EinCaracteristica1 = $fila['EinCaracteristica1'];
			$this->EinCaracteristica2 = $fila['EinCaracteristica2'];
			$this->EinCaracteristica3 = $fila['EinCaracteristica3'];
			$this->EinCaracteristica4 = $fila['EinCaracteristica4'];
			$this->EinCaracteristica5 = $fila['EinCaracteristica5'];
			$this->EinCaracteristica6 = $fila['EinCaracteristica6'];
			$this->EinCaracteristica7 = $fila['EinCaracteristica7'];
			$this->EinCaracteristica8 = $fila['EinCaracteristica8'];
			$this->EinCaracteristica9 = $fila['EinCaracteristica9'];
			$this->EinCaracteristica10 = $fila['EinCaracteristica10'];
			
			$this->EinCaracteristica11 = $fila['EinCaracteristica11'];
			$this->EinCaracteristica12 = $fila['EinCaracteristica12'];
			$this->EinCaracteristica13 = $fila['EinCaracteristica13'];
			$this->EinCaracteristica14 = $fila['EinCaracteristica14'];
			$this->EinCaracteristica15 = $fila['EinCaracteristica15'];
			$this->EinCaracteristica16 = $fila['EinCaracteristica16'];
			$this->EinCaracteristica17 = $fila['EinCaracteristica17'];
			$this->EinCaracteristica18 = $fila['EinCaracteristica18'];
			$this->EinCaracteristica19 = $fila['EinCaracteristica19'];
			$this->EinCaracteristica20 = $fila['EinCaracteristica20'];
				
				
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
			
			$this->MpaNombre = $fila['MpaNombre'];
			$this->MpaAbreviatura = $fila['MpaAbreviatura'];
			
			$this->SucNombre = $fila['SucNombre'];
			$this->EinUbicacion = $fila['EinUbicacion'];
		
			$this->PerNombreFirmante = $fila['PerNombreFirmante'];
			$this->PerApellidoPaternoFirmante = $fila['PerApellidoPaternoFirmante'];
			$this->PerApellidoMaternoFirmante = $fila['PerApellidoMaternoFirmante'];
			$this->PerNumeroDocumentoFirmante = $fila['PerNumeroDocumentoFirmante'];
			$this->TdoNombreFirmante = $fila['TdoNombreFirmante'];
			
			$this->UmeId = $fila['UmeId'];
			
			
			if($oCompleto){
				
				$InsOrdenVentaVehiculoCondicionVenta = new ClsOrdenVentaVehiculoCondicionVenta();
				$ResOrdenVentaVehiculoCondicionVenta = $InsOrdenVentaVehiculoCondicionVenta->MtdObtenerOrdenVentaVehiculoCondicionVentas(NULL,NULL,'OvnId','ASC',NULL,$this->OvvId);
				$this->OrdenVentaVehiculoCondicionVenta = $ResOrdenVentaVehiculoCondicionVenta['Datos'];
				
				$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();
				$ResOrdenVentaVehiculoObsequio = $InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,'OvoId','ASC',NULL,$this->OvvId);
				$this->OrdenVentaVehiculoObsequio = $ResOrdenVentaVehiculoObsequio['Datos'];
				
				
				
				
				
				$InsVehiculoVersionCaracteristica = new ClsVehiculoVersionCaracteristica();
				$ResVehiculoVersionCaracteristica = $InsVehiculoVersionCaracteristica-> MtdObtenerVehiculoVersionCaracteristicas(NULL,NULL,'VvcId','ASC',NULL,$this->VveId,$this->OvvAnoModelo);
				$this->VehiculoVersionCaracteristica = $ResVehiculoVersionCaracteristica['Datos'];
	
				// MtdObtenerOrdenVentaVehiculoPropietarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL)
				$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();
				$ResOrdenVentaVehiculoPropietario = $InsOrdenVentaVehiculoPropietario->MtdObtenerOrdenVentaVehiculoPropietarios(NULL,NULL,'OvpId','ASC',NULL,$this->OvvId);
				$this->OrdenVentaVehiculoPropietario = $ResOrdenVentaVehiculoPropietario['Datos'];
				
				


				
				$InsOrdenVentaVehiculoLlamada = new ClsOrdenVentaVehiculoLlamada();
				$ResOrdenVentaVehiculoLlamada =  $InsOrdenVentaVehiculoLlamada->MtdObtenerOrdenVentaVehiculoLlamadas(NULL,NULL,"OvlId","ASC",NULL,$this->OvvId,NULL);
				$this->OrdenVentaVehiculoLlamada = 	$ResOrdenVentaVehiculoLlamada['Datos'];	
				
				
				//MtdObtenerOrdenVentaVehiculoMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvmId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL,$oEstado=NULL)
				$InsOrdenVentaVehiculoMantenimiento = new ClsOrdenVentaVehiculoMantenimiento();
				$ResOrdenVentaVehiculoMantenimiento =  $InsOrdenVentaVehiculoMantenimiento->MtdObtenerOrdenVentaVehiculoMantenimientos(NULL,NULL,"OvmId","ASC",NULL,$this->OvvId,NULL);
				$this->OrdenVentaVehiculoMantenimiento = $ResOrdenVentaVehiculoMantenimiento['Datos'];	
				
				
				
			}

			
			
			switch($this->OvvEstado){
			
			  case 1:
				  $EstadoDescripcion = "Pendiente";
			  break;
			
			  case 3:
				  $EstadoDescripcion = "Listo";
			  break;	
			  
			  case 4:
				  $EstadoDescripcion = "Por Facturar";			  	
			  break;
			  
			  case 5:
				  $EstadoDescripcion = "Facturado";			  	
			  break;
			  
			  case 6:
				  $EstadoDescripcion = "Anulado";			  	
			  break;
			
			
			  default:
				  $EstadoDescripcion = "";
			  break;					
			
			}
			
			$this->OvvEstadoDescripcion = $EstadoDescripcion;
			
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerOrdenVentaVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oCliente=NULL,$oConCotizacion=0,$oFacturable=NULL,$oCotizacionVehiculo=NULL,$oVehiculoIngreso=NULL,$oSucursal=NULL,$oAprobacion1=NULL,$oAprobacion2=NULL,$oAprobacion3=NULL) {

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
					ovp.OvpId
					FROM tblovpordenventavehiculopropietario ovp
						LEFT JOIN tblclicliente cli
						ON ovp.CliId = cli.CliId
					WHERE 
						ovp.OvvId = ovv.OvvId AND
						(
							cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
							cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
							cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%"  OR
							cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'" AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';		
			}			
		}


		//if(!empty($oEstado)){
//			$estado = ' AND ovv.OvvEstado = '.$oEstado;
//		}
		
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

			$i=1;
			$estado .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$estado .= '  (ovv.OvvEstado = '.($elemento).' )';
				if($i<>count($elementos)){						
					$estado .= ' OR ';	
				}
			$i++;		
			}

			$estado .= ' ) 
			)
			';

		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ovv.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND ovv.PerId = "'.$oPersonal.'"';
		}
		if(!empty($oCliente)){
			$cliente = ' AND ovv.CliId = "'.$oCliente.'"';
		}
		
		switch($oConCotizacion){
			case 1:
				$ccotizacion = ' AND ovv.CveId IS NOT NULL ';
			break;
			
			case 2:
				$ccotizacion = ' AND ovv.CveId IS NULL ';
			break;
			
			default:
				$ccotizacion = '';
			break;	
		}
		
		switch($oFacturable){			
		
			case "FacturableSi":
				$facturable = ' 
				
				AND NOT EXISTS (
					SELECT fac.FacId FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)
				
				AND NOT EXISTS(
					SELECT bol.BolId FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				)
				
				AND (
				ovv.OvvEstado <> 6
				AND ovv.OvvEstado <> 3
				)
				
				';
			break;
			
			case "FacturableNo":
				$facturable = '
				
				AND  (
				
					EXISTS (
					SELECT fac.FacId FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					 LIMIT 1
					)
				
					OR  EXISTS(
					SELECT bol.BolId FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
					)
					
					OR (ovv.OvvEstado = 6 OR ovv.OvvEstado = 3)
				)
				
				';
			break;
			
			default:
				$facturable = "";
			break;
			
		}
			
		if(!empty($oCotizacionVehiculo)){
			$cvehiculo = ' AND ovv.CveId = "'.$oCotizacionVehiculo.'"';
		}
		
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND ovv.EinId = "'.$oVehiculoIngreso.'"';
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ovv.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oAprobacion1)){
			$aprobacion1 = ' AND ovv.OvvAprobacion1 = "'.$oAprobacion1.'"';
		}
		
		if(!empty($oAprobacion2)){
			$aprobacion2 = ' AND ovv.OvvAprobacion2 = "'.$oAprobacion2.'"';
		}
		
			if(!empty($oAprobacion3)){
			$aprobacion3 = ' AND ovv.OvvAprobacion3 = "'.$oAprobacion3.'"';
		}
		
	
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ovv.OvvId,	
			
							
				ovv.PerId,
ovv.PerIdFirmante,
				ovv.CliId,
				ovv.NpaId,
				
				DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				DATE_FORMAT(ovv.OvvFechaEntrega, "%d/%m/%Y") AS "NOvvFechaEntrega",
				
				ovv.CveId,
				
				ovv.MonId,
				ovv.OvvTipoCambio,
				
				ovv.MpaId,
				
				ovv.OvvIncluyeImpuesto,
				ovv.OvvPorcentajeImpuestoVenta,
		
				ovv.OvvObservacion,

				ovv.OvvTelefono,
				ovv.OvvCelular,
				ovv.OvvDireccion,
				ovv.OvvEmail,
		
				ovv.VveId,
				ovv.OvvAnoModelo,
				ovv.OvvAnoFabricacion,
				ovv.OvvColor,
				
				ovv.OvvVehiculoMarca,
		ovv.OvvVehiculoModelo,
		ovv.OvvVehiculoVersion,
		ovv.OvvGLP,
		
				ovv.EinId,
				
				ovv.OvvPrecio,
				ovv.OvvDescuento,
				ovv.OvvDescuentoGerencia,
				
				ovv.OvvSubTotal,
				ovv.OvvImpuesto,				
				ovv.OvvTotal,

				ovv.OvvCondicionVentaOtro,

				ovv.OvvObsequioOtro,
				
				ovv.OvvComprobanteVenta,
				
				ovv.OvvNota,
				ovv.OvvPlaca,
				
				
				ovv.OvvAprobacion1,
				ovv.OvvAprobacion2,
				ovv.OvvAprobacion3,
				
				ovv.OvvInmediata,
				ovv.OvvEstado,
				DATE_FORMAT(ovv.OvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoCreacion",
	        	DATE_FORMAT(ovv.OvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvvTiempoModificacion",
				
				
				DATE_FORMAT(ovv.OvvActaEntregaFecha, "%d/%m/%Y") AS "NOvvActaEntregaFecha",
DATE_FORMAT(ovv.OvvActaEntregaHora, "%H:%i") AS "NOvvActaEntregaHora",
				ovv.OvvActaEntregaDescripcion,
				ovv.OvvFotoActaEntrega,
					
				CASE
				WHEN EXISTS (
					SELECT 
					fac.FacId
					FROM tblfacfactura fac
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvFactura,
		
		
							
				CASE
				WHEN EXISTS (
					SELECT 
					bol.BolId
					FROM tblbolboleta bol
					WHERE bol.OvvId = ovv.OvvId 
					AND bol.BolEstado <> 6
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS OvvBoleta,




			(
					SELECT 
					CONCAT(fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6

								AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					
					
					
					LIMIT 1
				)  AS FacId,
				
				(
					SELECT 
					CONCAT(fac.FtaId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS FtaId,
		
		
								
				(
					SELECT 
					CONCAT(bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS BolId,	
				
				(
					SELECT 
					CONCAT(bol.BtaId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS BtaId,	
				
				
				
				
				
				(
					SELECT 
					CONCAT(fta.FtaNumero,"-",fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
								
					LIMIT 1
				)  AS OvvFacturaNumero,
		
		
								
				(
					SELECT 
					CONCAT(bta.BtaNumero,"-",bol.BolId)
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS OvvBoletaNumero,	
				
				


				(
					SELECT 
					DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaFecha,
				
		
				(
					SELECT 
					DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS OvvBoletaFecha,	
				




				(
					SELECT 
					fac.FacTipoCambio
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaTipoCambio,

				(
					SELECT 
					bol.BolTipoCambio
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS OvvBoletaTipoCambio,
				
				


				(
					SELECT 
					fac.FacTotal
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND fac.FacEstado <> 6 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					LIMIT 1
				)  AS OvvFacturaTotal,

				(
					SELECT 
					bol.BolTotal
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND bol.BolEstado <> 6 
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					LIMIT 1
				) AS OvvBoletaTotal,
				
				
						
						
				(
					SELECT 
					fac.FacEstado
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
					WHERE fac.OvvId = ovv.OvvId 
					AND NOT EXISTS(
									SELECT 	
									ncr.NcrId
									FROM tblncrnotacredito ncr
									WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
									AND ncr.NcrEstado <> 6
									AND ncr.NcrMotivoCodigo<> "04"
									AND ncr.NcrMotivoCodigo<> "05"
									AND ncr.NcrMotivoCodigo<> "09"
									
								) 
					 LIMIT 1
				)  AS OvvFacturaEstado,

				(
					SELECT 
					bol.BolEstado
					FROM tblbolboleta bol
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
					WHERE bol.OvvId = ovv.OvvId
					AND NOT EXISTS(
							SELECT 	
							ncr.NcrId
							FROM tblncrnotacredito ncr
							WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
							AND ncr.NcrEstado <> 6
							AND ncr.NcrMotivoCodigo<> "04"
							AND ncr.NcrMotivoCodigo<> "05"
							AND ncr.NcrMotivoCodigo<> "09"
						)
					 LIMIT 1
				) AS OvvBoletaEstado,
				
				
				
								
	
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
				
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				cli.CliPais,
				cli.CliActividadEconomica,
				
				cli.CliRepresentanteNombre,
				cli.CliRepresentanteNumeroDocumento,
				cli.CliRepresentanteNacionalidad,
				cli.CliRepresentanteActividadEconomica,
				
				cli.CliSexo,
				cli.CliEstadoCivil,
				
				
				(
					SELECT 
					COUNT(ovp.OvpId) 
					FROM tblovpordenventavehiculopropietario ovp 
					WHERE ovp.OvvId = ovv.OvvId
				
				) AS OvvPropietarioCantidad,
				
				

		(SELECT 
		
		(pag.PagMonto)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS OvvAbonoInicial,
		
		
		
		
		(SELECT 
		
		(pag.FpaId)
		
		FROM tblpagpago pag
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaId,
		
		
			(SELECT 
		
		(fpa.FpaAbreviatura)
		
		FROM tblpagpago pag
			LEFT JOIN tblfpaformapago fpa
			ON pag.FpaId = fpa.FpaId
		WHERE 
			
			EXISTS(
				SELECT
				pac.PacId
				FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.Ovvid = ovv.Ovvid
			)
			
		ORDER BY pag.PagId ASC LIMIT 1
		) AS FpaAbreviatura,
		
		
				CASE
				WHEN EXISTS (
					SELECT 
					pac.PacId
					FROM tblpacpagocomprobante pac 
						LEFT JOIN tblpagpago pag
						ON pac.PagId = pag.PagId
					
					WHERE pac.OvvId = ovv.OvvId LIMIT 1
				
				) THEN "Si"
				ELSE "No"
				END AS OvvPago,
				
					
				
				tdo.TdoNombre,
				
				mon.MonNombre,
				mon.MonSimbolo,

				vmo.VmaId,
				vma.VmaNombre,
		
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre,
				
				vve.VveFoto,
				
				lti.LtiNombre,
				
				ein.EinVIN,
				
				
				per.PerAbreviatura,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				mpa.MpaNombre,
				mpa.MpaAbreviatura,
				
				suc.SucNombre
		
				FROM tblovvordenventavehiculo ovv
				
					LEFT JOIN tblmpamodalidadpago mpa
					ON ovv.MpaId = mpa.MpaId
						
						LEFT JOIN tblclicliente cli
						ON ovv.CliId = cli.CliId
						
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
						
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
							LEFT JOIN tbleinvehiculoingreso ein
							ON ovv.EinId = ein.EinId
							
							LEFT JOIN tblmonmoneda mon
							ON ovv.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON ovv.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									
									LEFT JOIN tblperpersonal per
									ON ovv.PerId = per.PerId
									
									LEFT JOIN tblsucsucursal suc
									ON ovv.SucId = suc.SucId
									
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$sucursal.$aprobacion1.$aprobacion2.$aprobacion3.$stipo.$estado.$moneda.$personal.$cliente.$cvehiculo.$ccotizacion.$vingreso.$estado.$facturable.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculo = new $InsOrdenVentaVehiculo();
                    $OrdenVentaVehiculo->OvvId = $fila['OvvId'];
					$OrdenVentaVehiculo->SucId = $fila['SucId'];
					
					
					$OrdenVentaVehiculo->PerId = $fila['PerId'];	
					$OrdenVentaVehiculo->PerIdFirmante = $fila['PerIdFirmante'];	
					
					
					$OrdenVentaVehiculo->CliId = $fila['CliId'];
					$OrdenVentaVehiculo->NpaId = $fila['NpaId'];
					$OrdenVentaVehiculo->OvvFecha = $fila['NOvvFecha'];
					$OrdenVentaVehiculo->OvvFechaEntrega = $fila['NOvvFechaEntrega'];
					
					
					$OrdenVentaVehiculo->CveId = $fila['CveId'];
					
					$OrdenVentaVehiculo->MonId = $fila['MonId'];
					$OrdenVentaVehiculo->OvvTipoCambio = $fila['OvvTipoCambio'];
					
					$OrdenVentaVehiculo->MpaId = $fila['MpaId'];
					
					$OrdenVentaVehiculo->OvvIncluyeImpuesto = $fila['OvvIncluyeImpuesto'];
					$OrdenVentaVehiculo->OvvPorcentajeImpuestoVenta = $fila['OvvPorcentajeImpuestoVenta'];					
					$OrdenVentaVehiculo->OvvObservacion = $fila['OvvObservacion'];
					
					$OrdenVentaVehiculo->OvvTelefono = $fila['OvvTelefono'];
					$OrdenVentaVehiculo->OvvCelular = $fila['OvvCelular'];
					$OrdenVentaVehiculo->OvvDireccion = $fila['OvvDireccion'];
					$OrdenVentaVehiculo->OvvEmail = $fila['OvvEmail'];
					
					
					
					$OrdenVentaVehiculo->CliDireccion = $fila['CliDireccion'];
					$OrdenVentaVehiculo->CliDepartamento = $fila['CliDepartamento'];
					$OrdenVentaVehiculo->CliProvincia = $fila['CliProvincia'];
					$OrdenVentaVehiculo->CliDistrito = $fila['CliDistrito'];
					$OrdenVentaVehiculo->CliPais = $fila['CliPais'];
					$OrdenVentaVehiculo->CliActividadEconomica = $fila['CliActividadEconomica'];
					
					$OrdenVentaVehiculo->CliSexo = $fila['CliSexo'];
					$OrdenVentaVehiculo->CliEstadoCivil = $fila['CliEstadoCivil'];
					
				
					$OrdenVentaVehiculo->CliRepresentanteNombre = $fila['CliRepresentanteNombre'];
					$OrdenVentaVehiculo->CliRepresentanteNumeroDocumento = $fila['CliRepresentanteNumeroDocumento'];
					$OrdenVentaVehiculo->CliRepresentanteNacionalidad = $fila['CliRepresentanteNacionalidad'];
					$OrdenVentaVehiculo->CliRepresentanteActividadEconomica = $fila['CliRepresentanteActividadEconomica'];

				
				
				
					$OrdenVentaVehiculo->VveId = $fila['VveId'];
					$OrdenVentaVehiculo->OvvAnoModelo = $fila['OvvAnoModelo'];	
					$OrdenVentaVehiculo->OvvAnoFabricacion = $fila['OvvAnoFabricacion'];
					
					
					$OrdenVentaVehiculo->OvvColor = $fila['OvvColor'];	
					
					$OrdenVentaVehiculo->OvvVehiculoMarca = $fila['OvvVehiculoMarca'];	
					$OrdenVentaVehiculo->OvvVehiculoModelo = $fila['OvvVehiculoModelo'];	
					$OrdenVentaVehiculo->OvvVehiculoVersion = $fila['OvvVehiculoVersion'];	
					$OrdenVentaVehiculo->OvvGLP = $fila['OvvGLP'];	
					
					
					$OrdenVentaVehiculo->EinId = $fila['EinId'];			

					$OrdenVentaVehiculo->OvvPrecio = $fila['OvvPrecio'];			
					$OrdenVentaVehiculo->OvvDescuento = $fila['OvvDescuento'];			
					$OrdenVentaVehiculo->OvvDescuentoGerencia = $fila['OvvDescuentoGerencia'];	
				
				
					$OrdenVentaVehiculo->OvvSubTotal = $fila['OvvSubTotal'];			
					$OrdenVentaVehiculo->OvvImpuesto = $fila['OvvImpuesto'];
					$OrdenVentaVehiculo->OvvTotal = $fila['OvvTotal'];
					
					$OrdenVentaVehiculo->OvvCondicionVentaOtro = $fila['OvvCondicionVentaOtro'];
					$OrdenVentaVehiculo->OvvObsequioOtro = $fila['OvvObsequioOtro'];
					
					
					
					$OrdenVentaVehiculo->OvvComprobanteVenta = $fila['OvvComprobanteVenta'];
					
					
					
					$OrdenVentaVehiculo->OvvFactura = $fila['OvvFactura'];
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					
					$OrdenVentaVehiculo->FacId = $fila['FacId'];
					$OrdenVentaVehiculo->FtaId = $fila['FtaId'];
					
					$OrdenVentaVehiculo->BolId = $fila['BolId'];
					$OrdenVentaVehiculo->BtaId = $fila['BtaId'];
					
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					$OrdenVentaVehiculo->OvvBoleta = $fila['OvvBoleta'];
					
					$OrdenVentaVehiculo->OvvFacturaNumero = $fila['OvvFacturaNumero'];
					$OrdenVentaVehiculo->OvvBoletaNumero = $fila['OvvBoletaNumero'];
					
					$OrdenVentaVehiculo->OvvFacturaFecha = $fila['OvvFacturaFecha'];
					$OrdenVentaVehiculo->OvvBoletaFecha = $fila['OvvBoletaFecha'];

					$OrdenVentaVehiculo->OvvFacturaTotal = $fila['OvvFacturaTotal'];
					$OrdenVentaVehiculo->OvvBoletaTotal = $fila['OvvBoletaTotal'];
					
					$OrdenVentaVehiculo->OvvFacturaEstado = $fila['OvvFacturaEstado'];
					$OrdenVentaVehiculo->OvvBoletaEstado = $fila['OvvBoletaEstado'];	
					
				
				
				
					$OrdenVentaVehiculo->OvvFacturaTipoCambio = $fila['OvvFacturaTipoCambio'];
					$OrdenVentaVehiculo->OvvBoletaTipoCambio = $fila['OvvBoletaTipoCambio'];				
					
					
					$OrdenVentaVehiculo->OvvNota = $fila['OvvNota'];
					$OrdenVentaVehiculo->OvvPlaca = $fila['OvvPlaca'];
					
					$OrdenVentaVehiculo->OvvAprobacion1 = $fila['OvvAprobacion1'];
					$OrdenVentaVehiculo->OvvAprobacion2 = $fila['OvvAprobacion2'];
					$OrdenVentaVehiculo->OvvAprobacion3 = $fila['OvvAprobacion3'];
					
					$OrdenVentaVehiculo->OvvInmediata = $fila['OvvInmediata'];
					$OrdenVentaVehiculo->OvvEstado = $fila['OvvEstado'];
					$OrdenVentaVehiculo->OvvTiempoCreacion = $fila['NOvvTiempoCreacion'];  
					$OrdenVentaVehiculo->OvvTiempoModificacion = $fila['NOvvTiempoModificacion']; 
					
					$OrdenVentaVehiculo->OvvActaEntregaFecha = $fila['NOvvActaEntregaFecha']; 
					$OrdenVentaVehiculo->OvvActaEntregaHora = $fila['NOvvActaEntregaHora']; 
				
					$OrdenVentaVehiculo->OvvActaEntregaDescripcion = $fila['OvvActaEntregaDescripcion']; 
					$OrdenVentaVehiculo->OvvFotoActaEntrega = $fila['OvvFotoActaEntrega']; 
					
					$OrdenVentaVehiculo->TdoId = $fila['TdoId']; 
					$OrdenVentaVehiculo->CliNombreCompleto = $fila['CliNombreCompleto']; 
					$OrdenVentaVehiculo->CliNombre = $fila['CliNombre']; 
					$OrdenVentaVehiculo->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$OrdenVentaVehiculo->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
					$OrdenVentaVehiculo->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
					
					$OrdenVentaVehiculo->CliTelefono = $fila['CliTelefono']; 
					$OrdenVentaVehiculo->CliCelular = $fila['CliCelular']; 
					$OrdenVentaVehiculo->CliEmail = $fila['CliEmail']; 

					$OrdenVentaVehiculo->OvvPropietarioCantidad = $fila['OvvPropietarioCantidad']; 
					
					$OrdenVentaVehiculo->OvvAbonoInicial = $fila['OvvAbonoInicial'];
					$OrdenVentaVehiculo->FpaId = $fila['FpaId']; 
					$OrdenVentaVehiculo->FpaAbreviatura = $fila['FpaAbreviatura']; 
					$OrdenVentaVehiculo->OvvPago = $fila['OvvPago']; 
				
					$OrdenVentaVehiculo->TdoNombre = $fila['TdoNombre']; 
					
					$OrdenVentaVehiculo->MonNombre = $fila['MonNombre']; 
					$OrdenVentaVehiculo->MonSimbolo = $fila['MonSimbolo']; 
				
		
					$OrdenVentaVehiculo->VmaId = $fila['VmaId'];
					$OrdenVentaVehiculo->VmaNombre = $fila['VmaNombre'];
					
					$OrdenVentaVehiculo->VmoId = $fila['VmoId'];
					$OrdenVentaVehiculo->VmoNombre = $fila['VmoNombre'];
					
					$OrdenVentaVehiculo->VveId = $fila['VveId'];
					$OrdenVentaVehiculo->VveNombre = $fila['VveNombre'];
					
					$OrdenVentaVehiculo->VveFoto = $fila['VveFoto'];
					
					$OrdenVentaVehiculo->LtiNombre = $fila['LtiNombre'];
					
					$OrdenVentaVehiculo->EinVIN = $fila['EinVIN'];
					
					$OrdenVentaVehiculo->PerAbreviatura = $fila['PerAbreviatura'];
					$OrdenVentaVehiculo->PerNombre = $fila['PerNombre'];
					$OrdenVentaVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$OrdenVentaVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno'];

					$OrdenVentaVehiculo->MpaNombre = $fila['MpaNombre'];
					$OrdenVentaVehiculo->MpaAbreviatura = $fila['MpaAbreviatura'];					

					$OrdenVentaVehiculo->SucNombre = $fila['SucNombre'];

					switch($OrdenVentaVehiculo->OvvEstado){
					
					  case 1:
						  $Estado = "Pendiente";
					  break;
					
					  case 3:
						  $Estado = "Listo";
					  break;	
						
					case 4:
							$Estado = "Por Facturar";
					break;
					
					 case 5:
				 		 $Estado = "Facturado";			  	
					  break;
					
					 case 6:
						  $Estado = "Anulado";			  	
					  break;
					
					  default:
						  $Estado = "";
					  break;					
					
					}
					
			switch($OrdenVentaVehiculo->OvvEstado){
				
				case 1:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Pendiente]" title="Pendiente" src="imagenes/estado/pendiente.gif" />';
				break;
				
				case 3:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/realizado.gif" />';
				break;	
				
				case 4:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Emitido]" title="Emitido" src="imagenes/estado/por_facturar.png" />';
				break;	
				
				case 5:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Facturado]" title="Facturado" src="imagenes/estado/facturado.png" />';
				break;
				
				case 6:
					$OrdenVentaVehiculo->OvvEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src="imagenes/estado/anulado.png" />';
				break;

				default:
					$OrdenVentaVehiculo->OvvEstadoIcono = "";
				break;
				
			}
			
			
			
					
					$OrdenVentaVehiculo->OvvEstadoDescripcion = $Estado;
			
                    $OrdenVentaVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
 public function MtdObtenerOrdenVentaVehiculosValor($oFuncion="SUM",$oParametro="OvvId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oPersonal=NULL,$oModelo=NULL,$oMarca=NULL,$oSucursal=NULL) {

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
					ovp.OvpId
					FROM tblovpordenventavehiculopropietario ovp
						LEFT JOIN tblclicliente cli
						ON ovp.CliId = cli.CliId
					WHERE 
						ovp.OvvId = ovv.OvvId AND
						(
							cli.CliNombre  LIKE "%'.$oFiltro.'%" OR
							cli.CliApellidoPaterno  LIKE "%'.$oFiltro.'%" OR
							cli.CliApellidoMaterno  LIKE "%'.$oFiltro.'%"  OR
							cli.CliNombreCompleto  LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'" AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ovv.OvvFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ovv.OvvFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND ovv.OvvEstado = '.$oEstado;
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ovv.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND ovv.PerId = "'.$oPersonal.'"';
		}
		
		
		if(!empty($oModelo)){
			$modelo = ' AND vve.VmoId = "'.$oModelo.'"';
		}
			
					if(!empty($oMarca)){
			$marca = ' AND vmo.VmaId = "'.$oMarca.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ovv.SucId = "'.$oSucursal.'"';
		}
		
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(ovv.OvvFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(ovv.OvvFecha) ="'.($oAno).'"';
		}
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
			$sql = 'SELECT
				'.$funcion.' AS "RESULTADO"
				
				FROM tblovvordenventavehiculo ovv
					LEFT JOIN tblclicliente cli
					ON ovv.CliId = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
						
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
							
							LEFT JOIN tbleinvehiculoingreso ein
							ON ovv.EinId = ein.EinId
							
							LEFT JOIN tblmonmoneda mon
							ON ovv.MonId = mon.MonId

							LEFT JOIN tblvvevehiculoversion vve
							ON ovv.VveId = vve.VveId
								LEFT JOIN tblvmovehiculomodelo vmo
								ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId	
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									
									
									LEFT JOIN tblperpersonal per
									ON ovv.PerId = per.PerId
									
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$sucursal.$fecha.$tipo.$stipo.$modelo.$marca.$estado.$moneda.$personal.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
							
		}
		

	
	//Accion eliminar	 
	public function MtdEliminarOrdenVentaVehiculo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

//		$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					//$aux = explode("%",$elemento);	
					
					
					$this->OvvId = $elemento;
					
					if(!empty($this->OvvId)){
						
						$this->MtdObtenerOrdenVentaVehiculo(true);
						
						if(!empty($this->EinId)){
							
							$InsVehiculoIngreso = new ClsVehiculoIngreso();
							$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","STOCK",$this->EinId);
							
							
							
							

							$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
							$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','ASC',NULL,$this->EinId,NULL);											
							$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
										
							
							if(!empty($this->OrdenVentaVehiculoPropietario)  ){
								
								if(!empty($ArrVehiculoIngresoClientes)){

									foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
										
										foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
												
											if($DatVehiculoIngresoCliente->CliId == $DatOrdenVentaVehiculoPropietario->CliId){
												
																								
												$InsVehiculoIngresoCliente->MtdEliminarVehiculoIngresoCliente($DatVehiculoIngresoCliente->VicId);								
												break;					
												
											}												
												
										}
										
									}
									
								}
								
								
								

//
//						foreach($ArrOrdenVentaVehiculoObsequios as $DatOrdenVentaVehiculoObsequio){
//							$amdetalle .= '#'.$DatOrdenVentaVehiculoObsequio->CvdId;
//						}
//
//						if(!$InsOrdenVentaVehiculoObsequio->MtdEliminarOrdenVentaVehiculoObsequio($amdetalle)){								
//							$error = true;
//						}

								$ovpropietario = '';
								foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
									
									$ovpropietario .= '#'.$DatOrdenVentaVehiculoPropietario->OvpId;
									
								}
								
								$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();	
								
								if(!$InsOrdenVentaVehiculoPropietario->MtdEliminarOrdenVentaVehiculoPropietario($ovpropietario)){	
															
									$error = true;
									
								}	
								
									
									
								
							}
							
									
							$InsCliente = new ClsCliente();
							$ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
							$ArrClientes = $ResCliente['Datos'];
							
							$ClienteId = "";
							
							if(!empty($ArrClientes)){
								foreach($ArrClientes as $DatCliente){
								
									$ClienteId = $DatCliente->CliId;
									
								}
							}
							
							$InsFichaIngreso = new ClsFichaIngreso();
							$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","DESC","1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,2,0,NULL,$this->EinId);
							$ArrFichaIngresos = $ResFichaIngreso['Datos'];
							
							$PreEntregaId = "";
							if(!empty($ArrFichaIngresos)){
								foreach($ArrFichaIngresos as $DatFichaIngreso){
									
									$PreEntregaId = $DatFichaIngreso->FinId;
									
								}
							}

							if(!empty($ClienteId) and !empty($PreEntregaId)){
								
								$InsFichaIngreso->MtdEditarFichaIngresoDato("CliId",$ClienteId,$PreEntregaId);	
								
							}
						
							
							
						}
						
					}
						
						
						
//					$ResOrdenVentaVehiculoObsequio = $InsOrdenVentaVehiculoObsequio->MtdObtenerOrdenVentaVehiculoObsequios(NULL,NULL,'CvdId','Desc',NULL,$aux[0]);
//					$ArrOrdenVentaVehiculoObsequios = $ResOrdenVentaVehiculoObsequio['Datos'];
//
//					if(!empty($ArrOrdenVentaVehiculoObsequios)){
//						$amdetalle = '';
//
//						foreach($ArrOrdenVentaVehiculoObsequios as $DatOrdenVentaVehiculoObsequio){
//							$amdetalle .= '#'.$DatOrdenVentaVehiculoObsequio->CvdId;
//						}
//
//						if(!$InsOrdenVentaVehiculoObsequio->MtdEliminarOrdenVentaVehiculoObsequio($amdetalle)){								
//							$error = true;
//						}
//							
//					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblovvordenventavehiculo WHERE  (OvvId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							
							//$this->OvvId = $aux[0];
//							$this->MtdObtenerOrdenVentaVehiculo(false);
//							
//							if($this->OvvEstado == 5){
//								$this->MtdActualizarEstadoOrdenVentaVehiculo($aux[0],4);
//							}
//							
							
							
							$this->MtdAuditarOrdenVentaVehiculo(3,"Se elimino la Orden de Venta de Vehiculo",$aux);		
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
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoOrdenVentaVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsOrdenVentaVehiculo = new ClsOrdenVentaVehiculo();
//		$InsOrdenVentaVehiculoObsequios = new ClsOrdenVentaVehiculoObsequio();
							
/*	case 1:
$Estado = "Pendiente";
break;

case 3:
$Estado = "Emitido";
break;	

case 4:
  $Estado = "Por Facturar";
break;

case 5:
$Estado = "Facturado";			  	
break;
*/
		
			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
					
				$this->OvvId = $elemento;
				//$aux = explode("%",$elemento);	

					if(!empty($this->OvvId)){
						
						$this->MtdObtenerOrdenVentaVehiculo(true);
						
						if(!empty($this->EinId)){
							
							$InsVehiculoIngreso = new ClsVehiculoIngreso();
							
							//if($oEstado == 5 and $this->OvvEstado == 4){
							if($oEstado == 5){								
								
								//$InsVehiculoIngreso = new ClsVehiculoIngreso();
								//$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","VENDIDO",$this->EinId);					

							}else if($oEstado == 4){
//							}else if($oEstado == 4 and $this->OvvEstado == 5){
								
								//$InsVehiculoIngreso = new ClsVehiculoIngreso();
								//$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","VENDIDO",$this->EinId);
								
//MtdObtenerFichaIngresos( $oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oPrioridad=NULL,$oModalidadIngreso=NULL,$oVIN=NULL,$oClienteId=NULL,$oPersonalId=NULL,$oTrabajoConcluido=0,$oCampana=NULL,$oClienteTipo=NULL,$oTipo=NULL,$oSalidaExterna=0,$oConCampana=NULL,$oVehiculoIngreso=NULL)
								//$InsFichaIngreso = new ClsFichaIngreso();
//								$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","DESC","1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,2,0,NULL,$this->EinId);
//								$ArrFichaIngresos = $ResFichaIngreso['Datos'];
//								
//								$PreEntregaId = "";
//								if(!empty($ArrFichaIngresos)){
//									foreach($ArrFichaIngresos as $DatFichaIngreso){
//										
//										$PreEntregaId = $DatFichaIngreso->FinId;
//										
//									}
//								}
//
//
//								if(!empty($PreEntregaId)){
//	
////									$ClienteId = "";
////									if(!empty($this->OrdenVentaVehiculoPropietario)){
////										foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
////																					
////											$ClienteId = $DatOrdenVentaVehiculoPropietario->CliId;
////											
////											
////											
////											$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
////											$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','ASC',NULL,$this->EinId,$DatOrdenVentaVehiculoPropietario->CliId);											
////											$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
////											
////											if(empty($ArrVehiculoIngresoClientes)){
////	
////												$InsVehiculoIngresoCliente->CliId = $DatOrdenVentaVehiculoPropietario->CliId;
////												$InsVehiculoIngresoCliente->EinId = $this->EinId;
////												$InsVehiculoIngresoCliente->VicEstado = 3;
////												$InsVehiculoIngresoCliente->VicTiempoCreacion = date("Y-m-d H:i:s");
////												$InsVehiculoIngresoCliente->VicTiempoModificacion = date("Y-m-d H:i:s");
////												$InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();
////	
////											}
////	
////											
////										}
////									}
//							
//							
//									if( !empty($ClienteId )){
//										$InsFichaIngreso->MtdEditarFichaIngresoDato("CliId",$ClienteId,$PreEntregaId);							
//									}
//									
//								}else{
//									
//								}
//								
								

								
								
							
							}else if($oEstado == 3){
								
								$InsVehiculoIngreso = new ClsVehiculoIngreso();
								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","RESERVADO",$this->EinId);
								
							//}else if($oEstado == 3 or $oEstado == 1){
							}else if($oEstado == 1){
								
								$InsVehiculoIngreso = new ClsVehiculoIngreso();
								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","STOCK",$this->EinId);
								
								if(!empty($this->EinId)){

									//$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
//									$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','ASC',NULL,$this->EinId,NULL);											
//									$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
//												
//									
//									if(!empty($this->OrdenVentaVehiculoPropietario) and !empty($ArrVehiculoIngresoClientes)){
//										foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
//											
//											foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
//													
//												if($DatVehiculoIngresoCliente->CliId == $DatOrdenVentaVehiculoPropietario->CliId){
//																									
//													$InsVehiculoIngresoCliente->MtdEliminarVehiculoIngresoCliente($DatVehiculoIngresoCliente->VicId);								
//													break;					
//													
//												}												
//													
//											}
//											
//										}
//									}
									
									
											
								  //$InsCliente = new ClsCliente();
//								  $ResCliente = $InsCliente->MtdObtenerClientes(NULL,NULL,NULL,"CliNombre","ASC",1,"1",NULL,"CYC");
//								  $ArrClientes = $ResCliente['Datos'];
//								  
//								  $ClienteId = "";
//								  
//								  if(!empty($ArrClientes)){
//									  foreach($ArrClientes as $DatCliente){
//									  
//										  $ClienteId = $DatCliente->CliId;
//										  
//									  }
//								  }
//									
//									$InsFichaIngreso = new ClsFichaIngreso();
//									$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","DESC","1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,2,0,NULL,$this->EinId);
//									$ArrFichaIngresos = $ResFichaIngreso['Datos'];
//									
//									$PreEntregaId = "";
//									if(!empty($ArrFichaIngresos)){
//										foreach($ArrFichaIngresos as $DatFichaIngreso){
//											
//											$PreEntregaId = $DatFichaIngreso->FinId;
//											
//										}
//									}
//		
//									if(!empty($ClienteId) and !empty($PreEntregaId)){
//										
//										$InsFichaIngreso->MtdEditarFichaIngresoDato("CliId",$ClienteId,$PreEntregaId);	
//										
//									}
									
								}
								
							//}else if($oEstado == 6 and $this->OvvEstado == 5){
							}else if($oEstado == 6){
								
								//$InsVehiculoIngreso = new ClsVehiculoIngreso();
								//$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinEstadoVehicular","STOCK",$this->EinId);
							
							}
							
						}
						
					}
						
						
					$sql = 'UPDATE tblovvordenventavehiculo SET OvvEstado = '.$oEstado.' WHERE OvvId = "'.$elemento.'"';
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

					if(!$resultado) {						
						$error = true;
					}else{

						$this->MtdAuditarOrdenVentaVehiculo(2,"Se actualizo el Estado de la Orden de Venta de Vehiculo",$aux);

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
	
	
	public function MtdRegistrarOrdenVentaVehiculo() {
	
		global $Resultado;
		$error = false;

		$this->MtdGenerarOrdenVentaVehiculoId();
		
		$this->InsMysql->MtdTransaccionIniciar();

/*
		if(empty($this->CliId)){

				$InsCliente = new ClsCliente();	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->LtiId = $this->LtiId;		
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->OvvDireccion;
				$InsCliente->CliTelefono = $this->OvvTelefono;
				$InsCliente->CliCelular = $this->OvvCelular;
				$InsCliente->CliEmail = $this->CprEmail;
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
									
					if(!empty($InsCliente->CliNombre)){

						if(!$InsCliente->MtdRegistrarClienteDeOrdenVentaVehiculo()){
							$error = true;
							$Resultado.='#ERR_OVV_301';
						}else{
							$this->CliId = $InsCliente->CliId;									
						}		
					
					}

			}else{
			
				if(!empty($this->OvvDireccion)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliDireccion",$this->OvvDireccion,$this->CliId);
				}
				
				if(!empty($this->OvvTelefono)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliTelefono",$this->OvvTelefono,$this->CliId);
				}
				
				if(!empty($this->OvvCelular)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliCelular",$this->OvvCelular,$this->CliId);
				}

				if(!empty($this->OvvEmail)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliEmail",$this->OvvEmail,$this->CliId);
				}

		}*/
//			if(empty($this->CliId)){
//				$InsCliente = new ClsCliente();
//				$InsCliente->CliNombre;
//				$InsCliente->CliNumeroDocumento;
//				$InsCliente->MtdVerificarExisteCliente();
//				if(empty($this->CliId)){
//					$InsCliente->CliEstado = 1;
//					$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
//					$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
//					$InsCliente->CliEliminado = 1;
//
//					if(!$InsCliente->MtdClienteRegistrar2()){
//						$error = true;
//						$Resultado.='#ERR_CLI_101';
//					}
//
//				}else{
//
//					$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
//
//					if(!$InsCliente->MtdEditarCliente2()){
//						$error = true;
//						$Resultado.='#ERR_CLI_102';
//					}
//
//					$this->CliId = $InsCliente->CliId;	
//					
//				}
//			}

			$sql = 'INSERT INTO tblovvordenventavehiculo (
			OvvId,
			SucId,
			
			CveId,
			
			PerId,		
			PerIdFirmante,
				
			CliId,
			NpaId,
			
			OvvFecha,
			OvvFechaEntrega,
			
			MonId,
			OvvTipoCambio,
			
			MpaId,
			
			OvvIncluyeImpuesto,
			OvvPorcentajeImpuestoVenta,

			OvvObservacion,
			
			OvvTelefono,
			OvvCelular,
			OvvDireccion,
			OvvEmail,

			VveId,
			OvvAnoModelo,
			OvvAnoFabricacion,
			OvvColor,
			
			OvvVehiculoMarca,
			OvvVehiculoModelo,
			OvvVehiculoVersion,
			OvvGLP,
			
		
			EinId,

			OvvPrecio,
			OvvDescuento,
			OvvDescuentoGerencia,
			
			OvvSubTotal,
			OvvImpuesto,				
			OvvTotal,

			OvvCondicionVentaOtro,

			OvvObsequioOtro,
			
			OvvComprobanteVenta,
			
			
				
					
					OvvActaEntregaFecha,
					OvvActaEntregaHora,
					OvvActaEntregaDescripcion,
					OvvFotoActaEntrega,
					
						OvvCartaResponsabilidadFecha,
							OvvCartaCompromisoFecha,
								OvvDeclaracionJuradaFecha,
									OvvDeclaracionJuradaSUNARPFecha,
	
			OvvNota,	
			OvvPlaca,	
			
			
			OvvAprobacion1,
			OvvAprobacion2,
			OvvAprobacion3,
			
			OvvInmediata,
			OvvEstado,			
			OvvTiempoCreacion,
			OvvTiempoModificacion) 
			VALUES (
			"'.($this->OvvId).'", 
			"'.($this->SucId).'", 
			
		'.(empty($this->CveId)?"NULL,":'"'.$this->CveId.'",').'

			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			'.(empty($this->PerIdFirmante)?"NULL,":'"'.$this->PerIdFirmante.'",').'
			
			'.(empty($this->CliId)?"NULL,":'"'.$this->CliId.'",').'
				'.(empty($this->NpaId)?"NULL,":'"'.$this->NpaId.'",').'
				
			"'.($this->OvvFecha).'", 
			'.(empty($this->OvvFechaEntrega)?"NULL,":'"'.$this->OvvFechaEntrega.'",').'
			
			
			"'.($this->MonId).'",
			'.(empty($this->OvvTipoCambio)?"NULL,":''.$this->OvvTipoCambio.',').'
			
			'.(empty($this->MpaId)?"NULL,":'"'.$this->MpaId.'",').'
			
			'.($this->OvvIncluyeImpuesto).',
			'.($this->OvvPorcentajeImpuestoVenta).',

			"'.($this->OvvObservacion).'",
			
			"'.($this->OvvTelefono).'",
			"'.($this->OvvCelular).'",
			"'.($this->OvvDireccion).'",
			"'.($this->OvvEmail).'",

			"'.($this->VveId).'",
			"'.($this->OvvAnoModelo).'",
			"'.($this->OvvAnoFabricacion).'",
			
			"'.($this->OvvColor).'",
			
			
			"'.($this->OvvVehiculoMarca).'",
			"'.($this->OvvVehiculoModelo).'",
			"'.($this->OvvVehiculoVersion).'",
			"'.($this->OvvGLP).'",
			
				
			
			'.(empty($this->EinId)?"NULL,":'"'.$this->EinId.'",').'

			'.($this->OvvPrecio).',
			'.($this->OvvDescuento).',
			'.($this->OvvDescuentoGerencia).',
			
			
			'.($this->OvvSubTotal).',
			'.($this->OvvImpuesto).',
			'.($this->OvvTotal).',

			"'.($this->OvvCondicionVentaOtro).'",

			"'.($this->OvvObsequioOtro).'",

			"'.($this->OvvComprobanteVenta).'",

			'.(empty($this->OvvActaEntregaFecha)?"NULL,":'"'.$this->OvvActaEntregaFecha.'",').'
			'.(empty($this->OvvActaEntregaHora)?"NULL,":'"'.$this->OvvActaEntregaHora.'",').'
			"'.($this->OvvActaEntregaDescripcion).'",
			"'.($this->OvvFotoActaEntrega).'",
					
			'.(empty($this->OvvCartaResponsabilidadFecha)?"NULL,":'"'.$this->OvvCartaResponsabilidadFecha.'",').'
			'.(empty($this->OvvCartaCompromisoFecha)?"NULL,":'"'.$this->OvvCartaCompromisoFecha.'",').'
			'.(empty($this->OvvDeclaracionJuradaFecha)?"NULL,":'"'.$this->OvvDeclaracionJuradaFecha.'",').'
			'.(empty($this->OvvDeclaracionJuradaSUNARPFecha)?"NULL,":'"'.$this->OvvDeclaracionJuradaSUNARPFecha.'",').'
			
			"'.($this->OvvNota).'",
			"'.($this->OvvPlaca).'",
			
			3,
			3,
			3,
		
			"'.($this->OvvInmediata).'", 		
			'.($this->OvvEstado).',
			"'.($this->OvvTiempoCreacion).'", 				
			"'.($this->OvvTiempoModificacion).'");';			
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
					
					
			if(!$error){			
			
				if (!empty($this->OrdenVentaVehiculoObsequio)){		
						
					$validar = 0;				
					$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();		
					
					foreach ($this->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
					
						$InsOrdenVentaVehiculoObsequio->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoObsequio->ObsId = $DatOrdenVentaVehiculoObsequio->ObsId;
						
						
						$InsOrdenVentaVehiculoObsequio->OvoAprobado = $DatOrdenVentaVehiculoObsequio->OvoAprobado;
						
						
						$InsOrdenVentaVehiculoObsequio->OvoEstado = $DatOrdenVentaVehiculoObsequio->OvoEstado;
						$InsOrdenVentaVehiculoObsequio->OvoTiempoCreacion = $DatOrdenVentaVehiculoObsequio->OvoTiempoCreacion;
						$InsOrdenVentaVehiculoObsequio->OvoTiempoModificacion = $DatOrdenVentaVehiculoObsequio->OvoTiempoModificacion;
						
						$InsOrdenVentaVehiculoObsequio->OvoEliminado = $DatOrdenVentaVehiculoObsequio->OvoEliminado;
						
						if($InsOrdenVentaVehiculoObsequio->OvoEliminado == 1){
							if($InsOrdenVentaVehiculoObsequio->MtdRegistrarOrdenVentaVehiculoObsequio()){
								$validar++;	
							}else{
								$Resultado.='#ERR_OVV_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
							
						}else{
							$validar++;	
						}
						
					}					
					
					if(count($this->OrdenVentaVehiculoObsequio) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if(!$error){			
			
			
				if (!empty($this->OrdenVentaVehiculoCondicionVenta)){		
						
					$validar = 0;				
					$InsOrdenVentaVehiculoCondicionVenta = new ClsOrdenVentaVehiculoCondicionVenta();		
					
					foreach ($this->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta){
					
						$InsOrdenVentaVehiculoCondicionVenta->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoCondicionVenta->CovId = $DatOrdenVentaVehiculoCondicionVenta->CovId;
						$InsOrdenVentaVehiculoCondicionVenta->OvnEstado = $DatOrdenVentaVehiculoCondicionVenta->OvnEstado;
						$InsOrdenVentaVehiculoCondicionVenta->OvnTiempoCreacion = $DatOrdenVentaVehiculoCondicionVenta->OvnTiempoCreacion;
						$InsOrdenVentaVehiculoCondicionVenta->OvnTiempoModificacion = $DatOrdenVentaVehiculoCondicionVenta->OvnTiempoModificacion;
						
						$InsOrdenVentaVehiculoCondicionVenta->OvnEliminado = $DatOrdenVentaVehiculoCondicionVenta->OvnEliminado;
						
						if($InsOrdenVentaVehiculoCondicionVenta->OvnEliminado == 1){
							
							if($InsOrdenVentaVehiculoCondicionVenta->MtdRegistrarOrdenVentaVehiculoCondicionVenta()){
								$validar++;	
							}else{
								$Resultado.='#ERR_OVV_301';
								$Resultado.='#Item Numero: '.($validar+1);
							}
							
						}else{
							$validar++;	
						}
						
					}					
					
					if(count($this->OrdenVentaVehiculoCondicionVenta) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if(!$error){			
			
			
				if (!empty($this->OrdenVentaVehiculoPropietario)){		
						
					$validar = 0;				
					$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();		
					
					foreach ($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
						$InsOrdenVentaVehiculoPropietario->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoPropietario->CliId = $DatOrdenVentaVehiculoPropietario->CliId;
						$InsOrdenVentaVehiculoPropietario->OvpFirmaDJ = $DatOrdenVentaVehiculoPropietario->OvpFirmaDJ;
						$InsOrdenVentaVehiculoPropietario->OvpEstado = $DatOrdenVentaVehiculoPropietario->OvpEstado;
						$InsOrdenVentaVehiculoPropietario->OvpTiempoCreacion = $DatOrdenVentaVehiculoPropietario->OvpTiempoCreacion;
						$InsOrdenVentaVehiculoPropietario->OvpTiempoModificacion = $DatOrdenVentaVehiculoPropietario->OvpTiempoModificacion;
						$InsOrdenVentaVehiculoPropietario->OvpEliminado = $DatOrdenVentaVehiculoPropietario->OvpEliminado;
						
						
						if($InsOrdenVentaVehiculoPropietario->OvpEliminado == 1){

							if($InsOrdenVentaVehiculoPropietario->MtdRegistrarOrdenVentaVehiculoPropietario()){
								
								if(!empty($this->EinId) and $this->OvvEstado == 3){
									
									$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
									
									$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','Desc',"1",$this->EinId,$InsOrdenVentaVehiculoPropietario->CliId);
									$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
									
									if(empty($ArrVehiculoIngresoClientes)){
										
										$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
										$InsVehiculoIngresoCliente->CliId = $InsOrdenVentaVehiculoPropietario->CliId;
										$InsVehiculoIngresoCliente->EinId = $this->EinId;
										$InsVehiculoIngresoCliente->VicFecha = date("Y-m-d");
										$InsVehiculoIngresoCliente->VicEstado = 1;
										$InsVehiculoIngresoCliente->VicTiempoCreacion = date("Y-m-d H:i:s");
										$InsVehiculoIngresoCliente->VicTiempoModificacion = date("Y-m-d H:i:s");
										
										$InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();
				
									}
									
									
									$InsFichaIngreso = new ClsFichaIngreso();
									$ResFichaIngreso = $InsFichaIngreso->MtdObtenerFichaIngresos(NULL,NULL,NULL,"FinTiempoCreacion","DESC","1",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,2,0,NULL,$this->EinId);
									$ArrFichaIngresos = $ResFichaIngreso['Datos'];
									
									$PreEntregaId = "";
									if(!empty($ArrFichaIngresos)){
										foreach($ArrFichaIngresos as $DatFichaIngreso){
											
											$PreEntregaId = $DatFichaIngreso->FinId;
											
										}
									}
	
	
									if(!empty($PreEntregaId)){
		
										$ClienteId = "";
										if(!empty($this->OrdenVentaVehiculoPropietario)){
											foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
																						
												$ClienteId = $DatOrdenVentaVehiculoPropietario->CliId;
												
											}
										}
								
								
										if( !empty($ClienteId )){
											$InsFichaIngreso->MtdEditarFichaIngresoDato("CliId",$ClienteId,$PreEntregaId);							
										}
										
									}

									
								}
								
								$validar++;	
							}else{
								$Resultado.='#ERR_OVV_401';
								$Resultado.='#Item Numero: '.($validar+1);
							}
														
						}else{
							$validar++;	
						}
						

					}					
					
					if(count($this->OrdenVentaVehiculoPropietario) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
//			deb($this->OrdenVentaVehiculoMantenimiento);
				if(!$error){			
			
			
				if (!empty($this->OrdenVentaVehiculoMantenimiento)){		
						
					$validar = 0;				
					$InsOrdenVentaVehiculoMantenimiento = new ClsOrdenVentaVehiculoMantenimiento();		
					
					foreach ($this->OrdenVentaVehiculoMantenimiento as $DatOrdenVentaVehiculoMantenimiento){
					
						$InsOrdenVentaVehiculoMantenimiento->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoMantenimiento->OvmKilometraje = $DatOrdenVentaVehiculoMantenimiento->OvmKilometraje;
						$InsOrdenVentaVehiculoMantenimiento->OvmEstado = $DatOrdenVentaVehiculoMantenimiento->OvmEstado;
						$InsOrdenVentaVehiculoMantenimiento->OvmTiempoCreacion = $DatOrdenVentaVehiculoMantenimiento->OvmTiempoCreacion;
						$InsOrdenVentaVehiculoMantenimiento->OvmTiempoModificacion = $DatOrdenVentaVehiculoMantenimiento->OvmTiempoModificacion;
						
						$InsOrdenVentaVehiculoMantenimiento->OvmEliminado = $DatOrdenVentaVehiculoMantenimiento->OvmEliminado;
						
						if($InsOrdenVentaVehiculoMantenimiento->OvmEliminado == 1){
							
							if($InsOrdenVentaVehiculoMantenimiento->MtdRegistrarOrdenVentaVehiculoMantenimiento()){
								$validar++;	
							}else{
								$Resultado.='#ERR_OVV_601';
								$Resultado.='#Item Numero: '.($validar+1);
							}
							
						}else{
							$validar++;	
						}
						
					}					
					
					if(count($this->OrdenVentaVehiculoMantenimiento) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
	
			/*
				$sql = 'INSERT INTO tblvicvehiculoingresocliente (
				VicId,
				CliId,
				EinId, 
				VicEstado,
				VicTiempoCreacion,
				VicTiempoModificacion) 
				VALUES (
				"'.($this->VicId).'", 
				"'.($this->CliId).'", 
				"'.($this->EinId).'", 
				'.($this->VicEstado).', 
				"'.($this->VicTiempoCreacion).'", 
				"'.($this->VicTiempoModificacion).'");';	
			*/
				
		
	
				
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarOrdenVentaVehiculo(1,"Se registro la Orden de Venta de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarOrdenVentaVehiculo() {

		global $Resultado;
		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();


		/*	if(empty($this->CliId)){

				$InsCliente = new ClsCliente();	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->LtiId = $this->LtiId;		
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->OvvDireccion;
				$InsCliente->CliTelefono = $this->OvvTelefono;
				$InsCliente->CliCelular = $this->OvvCelular;
				$InsCliente->CliEmail = $this->CprEmail;
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
									
				if(!empty($InsCliente->CliNombre)){

					if(!$InsCliente->MtdRegistrarClienteDeOrdenVentaVehiculo()){
					  $error = true;
					  $Resultado.='#ERR_OVV_301';
					}else{
					  $this->CliId = $InsCliente->CliId;									
					}		

				}

			}else{
			
				if(!empty($this->OvvDireccion)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliDireccion",$this->OvvDireccion,$this->CliId);
				}
				
				if(!empty($this->OvvTelefono)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliTelefono",$this->OvvTelefono,$this->CliId);
				}
				
				if(!empty($this->OvvCelular)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliCelular",$this->OvvCelular,$this->CliId);
				}

				if(!empty($this->OvvEmail)){
					$InsCliente = new ClsCliente();
					$InsCliente->MtdEditarClienteDato("CliEmail",$this->OvvEmail,$this->CliId);
				}

			}*/
				
			$sql = 'UPDATE tblovvordenventavehiculo SET
			SucId = "'.($this->SucId).'",
			
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			'.(empty($this->PerIdFirmante)?'PerIdFirmante = NULL, ':'PerIdFirmante = "'.$this->PerIdFirmante.'",').'
			
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->NpaId)?'NpaId = NULL, ':'NpaId = "'.$this->NpaId.'",').'
			
			OvvFecha = "'.($this->OvvFecha).'",
			'.(empty($this->OvvFechaEntrega)?'OvvFechaEntrega = NULL, ':'OvvFechaEntrega = "'.$this->OvvFechaEntrega.'",').'
		
			MonId = "'.($this->MonId).'",
			'.(empty($this->OvvTipoCambio)?'OvvTipoCambio = NULL, ':'OvvTipoCambio = '.$this->OvvTipoCambio.',').'
			
			'.(empty($this->MpaId)?'MpaId = NULL, ':'MpaId = "'.$this->MpaId.'",').'
			
			OvvIncluyeImpuesto = '.($this->OvvIncluyeImpuesto).',
			OvvPorcentajeImpuestoVenta = '.($this->OvvPorcentajeImpuestoVenta).',	
			OvvObservacion = "'.($this->OvvObservacion).'",
			
			OvvTelefono = "'.($this->OvvTelefono).'",
			OvvCelular = "'.($this->OvvCelular).'",
			OvvDireccion = "'.($this->OvvDireccion).'",
			OvvEmail = "'.($this->OvvEmail).'",

			VveId = "'.($this->VveId).'",
			OvvAnoModelo = "'.($this->OvvAnoModelo).'",
			OvvAnoFabricacion = "'.($this->OvvAnoFabricacion).'",
			
			OvvVehiculoMarca = "'.($this->OvvVehiculoMarca).'",
			OvvVehiculoModelo = "'.($this->OvvVehiculoModelo).'",
			OvvVehiculoVersion = "'.($this->OvvVehiculoVersion).'",
			OvvGLP = "'.($this->OvvGLP).'",
			
			
			OvvColor = "'.($this->OvvColor).'",			
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'

			OvvPrecio = '.($this->OvvPrecio).',
			OvvDescuento = '.($this->OvvDescuento).',
			OvvDescuentoGerencia = '.($this->OvvDescuentoGerencia).',

			OvvSubTotal = '.($this->OvvSubTotal).',
			OvvImpuesto = '.($this->OvvImpuesto).',
			OvvTotal = '.($this->OvvTotal).',			
			
			OvvCondicionVentaOtro = "'.($this->OvvCondicionVentaOtro).'",

			OvvObsequioOtro = "'.($this->OvvObsequioOtro).'",
			
			OvvComprobanteVenta = "'.($this->OvvComprobanteVenta).'",
			
			'.(empty($this->OvvActaEntregaFecha)?'OvvActaEntregaFecha = NULL, ':'OvvActaEntregaFecha = "'.$this->OvvActaEntregaFecha.'",').'
			'.(empty($this->OvvActaEntregaHora)?'OvvActaEntregaHora = NULL, ':'OvvActaEntregaHora = "'.$this->OvvActaEntregaHora.'",').'
			
			OvvActaEntregaDescripcion = "'.($this->OvvActaEntregaDescripcion).'",
			OvvFotoActaEntrega = "'.($this->OvvFotoActaEntrega).'",
			
			'.(empty($this->OvvCartaResponsabilidadFecha)?'OvvCartaResponsabilidadFecha = NULL, ':'OvvCartaResponsabilidadFecha = "'.$this->OvvCartaResponsabilidadFecha.'",').'
			'.(empty($this->OvvCartaCompromisoFecha)?'OvvCartaCompromisoFecha = NULL, ':'OvvCartaCompromisoFecha = "'.$this->OvvCartaCompromisoFecha.'",').'
			'.(empty($this->OvvDeclaracionJuradaFecha)?'OvvDeclaracionJuradaFecha = NULL, ':'OvvDeclaracionJuradaFecha = "'.$this->OvvDeclaracionJuradaFecha.'",').'
			'.(empty($this->OvvDeclaracionJuradaSUNARPFecha)?'OvvDeclaracionJuradaSUNARPFecha = NULL, ':'OvvDeclaracionJuradaSUNARPFecha = "'.$this->OvvDeclaracionJuradaSUNARPFecha.'",').'
				
			OvvNota = "'.($this->OvvNota).'",
			OvvPlaca = "'.($this->OvvPlaca).'",
			
			OvvInmediata = "'.($this->OvvInmediata).'",
			OvvEstado = '.($this->OvvEstado).'
			WHERE OvvId = "'.($this->OvvId).'";';			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			if(!$resultado) {							
				$error = true;
			} 			

			if(!$error){
	
				if (!empty($this->OrdenVentaVehiculoObsequio)){		

					$validar = 0;				
					$InsOrdenVentaVehiculoObsequio = new ClsOrdenVentaVehiculoObsequio();
		
					foreach ($this->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){

						$InsOrdenVentaVehiculoObsequio->OvoId = $DatOrdenVentaVehiculoObsequio->OvoId;
						$InsOrdenVentaVehiculoObsequio->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoObsequio->ObsId = $DatOrdenVentaVehiculoObsequio->ObsId;
						$InsOrdenVentaVehiculoObsequio->OvoAprobado = $DatOrdenVentaVehiculoObsequio->OvoAprobado;
						$InsOrdenVentaVehiculoObsequio->OvoEstado = $DatOrdenVentaVehiculoObsequio->OvoEstado;
						$InsOrdenVentaVehiculoObsequio->OvoTiempoCreacion = $DatOrdenVentaVehiculoObsequio->OvoTiempoCreacion;
						$InsOrdenVentaVehiculoObsequio->OvoTiempoModificacion = $DatOrdenVentaVehiculoObsequio->OvoTiempoModificacion;
						$InsOrdenVentaVehiculoObsequio->OvoEliminado = $DatOrdenVentaVehiculoObsequio->OvoEliminado;
						
						
						if(empty($InsOrdenVentaVehiculoObsequio->OvoId)){
							if($InsOrdenVentaVehiculoObsequio->OvoEliminado<>2){
								if($InsOrdenVentaVehiculoObsequio->MtdRegistrarOrdenVentaVehiculoObsequio()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsOrdenVentaVehiculoObsequio->OvoEliminado==2){
								if($InsOrdenVentaVehiculoObsequio->MtdEliminarOrdenVentaVehiculoObsequio($InsOrdenVentaVehiculoObsequio->OvoId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_OVV_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsOrdenVentaVehiculoObsequio->MtdEditarOrdenVentaVehiculoObsequio()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->OrdenVentaVehiculoObsequio) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
				
				
				
				
			if(!$error){
				
				if (!empty($this->OrdenVentaVehiculoCondicionVenta)){		
						
						
					$validar = 0;				
					$InsOrdenVentaVehiculoCondicionVenta = new ClsOrdenVentaVehiculoCondicionVenta();
							
					foreach ($this->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta){
										
						$InsOrdenVentaVehiculoCondicionVenta->OvnId = $DatOrdenVentaVehiculoCondicionVenta->OvnId;
						$InsOrdenVentaVehiculoCondicionVenta->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoCondicionVenta->CovId = $DatOrdenVentaVehiculoCondicionVenta->CovId;
						
						$InsOrdenVentaVehiculoCondicionVenta->OvnEstado = $DatOrdenVentaVehiculoCondicionVenta->OvnEstado;
						$InsOrdenVentaVehiculoCondicionVenta->OvnTiempoCreacion = $DatOrdenVentaVehiculoCondicionVenta->OvnTiempoCreacion;
						$InsOrdenVentaVehiculoCondicionVenta->OvnTiempoModificacion = $DatOrdenVentaVehiculoCondicionVenta->OvnTiempoModificacion;
						
						$InsOrdenVentaVehiculoCondicionVenta->OvnEliminado = $DatOrdenVentaVehiculoCondicionVenta->OvnEliminado;
						
						if(empty($InsOrdenVentaVehiculoCondicionVenta->OvnId)){
							if($InsOrdenVentaVehiculoCondicionVenta->OvnEliminado<>2){
								if($InsOrdenVentaVehiculoCondicionVenta->MtdRegistrarOrdenVentaVehiculoCondicionVenta()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsOrdenVentaVehiculoCondicionVenta->OvnEliminado==2){
								if($InsOrdenVentaVehiculoCondicionVenta->MtdEliminarOrdenVentaVehiculoCondicionVenta($InsOrdenVentaVehiculoCondicionVenta->OvnId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_OVV_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsOrdenVentaVehiculoCondicionVenta->MtdEditarOrdenVentaVehiculoCondicionVenta()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->OrdenVentaVehiculoCondicionVenta) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
	
			if(!$error){
				
				if (!empty($this->OrdenVentaVehiculoPropietario)){	
				
					$validar = 0;				
					$InsOrdenVentaVehiculoPropietario = new ClsOrdenVentaVehiculoPropietario();
							
					foreach ($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
										
						$InsOrdenVentaVehiculoPropietario->OvpId = $DatOrdenVentaVehiculoPropietario->OvpId;
						$InsOrdenVentaVehiculoPropietario->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoPropietario->CliId = $DatOrdenVentaVehiculoPropietario->CliId;
						$InsOrdenVentaVehiculoPropietario->OvpFirmaDJ = $DatOrdenVentaVehiculoPropietario->OvpFirmaDJ;
						$InsOrdenVentaVehiculoPropietario->OvpEstado = $DatOrdenVentaVehiculoPropietario->OvpEstado;
						$InsOrdenVentaVehiculoPropietario->OvpTiempoCreacion = $DatOrdenVentaVehiculoPropietario->OvpTiempoCreacion;
						$InsOrdenVentaVehiculoPropietario->OvpTiempoModificacion = $DatOrdenVentaVehiculoPropietario->OvpTiempoModificacion;

						$InsOrdenVentaVehiculoPropietario->OvpEliminado = $DatOrdenVentaVehiculoPropietario->OvpEliminado;
						
						if(empty($InsOrdenVentaVehiculoPropietario->OvpId)){
							if($InsOrdenVentaVehiculoPropietario->OvpEliminado<>2){
								if($InsOrdenVentaVehiculoPropietario->MtdRegistrarOrdenVentaVehiculoPropietario()){
									
									if(!empty($this->EinId) and $this->OvvEstado == 3){
									
										$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
										
										$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','Desc',"1",$this->EinId,$InsOrdenVentaVehiculoPropietario->CliId);
										$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
										
										if(empty($ArrVehiculoIngresoClientes)){
											
											$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
											$InsVehiculoIngresoCliente->CliId = $InsOrdenVentaVehiculoPropietario->CliId;
											$InsVehiculoIngresoCliente->EinId = $this->EinId;
											$InsVehiculoIngresoCliente->VicEstado = 1;
											$InsVehiculoIngresoCliente->VicTiempoCreacion = date("Y-m-d H:i:s");
											$InsVehiculoIngresoCliente->VicTiempoModificacion = date("Y-m-d H:i:s");
											
											$InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();
											
											$InsVehiculoIngresoCliente->MtdEditarVehiculoIngresoDato("VicObservacion","Desde Orden de Venta de Vehiculo",$InsVehiculoIngresoCliente->VicId);
					
										}
										
									}
								
								
									
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_401';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsOrdenVentaVehiculoPropietario->OvpEliminado==2){
								if($InsOrdenVentaVehiculoPropietario->MtdEliminarOrdenVentaVehiculoPropietario($InsOrdenVentaVehiculoPropietario->OvpId)){
									
									if(!empty($this->EinId)){
										
										$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
										
										$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,'VicId','Desc',"1",$this->EinId,$InsOrdenVentaVehiculoPropietario->CliId);
										$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];
										
										if(!empty($ArrVehiculoIngresoClientes)){
											foreach($ArrVehiculoIngresoClientes as $DatVehiculoIngresoCliente){
												
												$InsVehiculoIngresoCliente->MtdEliminarVehiculoIngresoCliente($DatVehiculoIngresoCliente->VicId);
												
											}
										}
										
									}
									
									



									$validar++;					
								}else{
									$Resultado.='#ERR_OVV_403';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsOrdenVentaVehiculoPropietario->MtdEditarOrdenVentaVehiculoPropietario()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_402';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					
					if(count($this->OrdenVentaVehiculoPropietario) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			
			if(!$error){
				
				if (!empty($this->OrdenVentaVehiculoMantenimiento)){		
						
						
					$validar = 0;				
					$InsOrdenVentaVehiculoMantenimiento = new ClsOrdenVentaVehiculoMantenimiento();
							
					foreach ($this->OrdenVentaVehiculoMantenimiento as $DatOrdenVentaVehiculoMantenimiento){
										
						$InsOrdenVentaVehiculoMantenimiento->OvmId = $DatOrdenVentaVehiculoMantenimiento->OvmId;
						$InsOrdenVentaVehiculoMantenimiento->OvvId = $this->OvvId;
						$InsOrdenVentaVehiculoMantenimiento->OvmKilometraje = $DatOrdenVentaVehiculoMantenimiento->OvmKilometraje;
						$InsOrdenVentaVehiculoMantenimiento->OvmEstado = $DatOrdenVentaVehiculoMantenimiento->OvmEstado;
						$InsOrdenVentaVehiculoMantenimiento->OvmTiempoCreacion = $DatOrdenVentaVehiculoMantenimiento->OvmTiempoCreacion;
						$InsOrdenVentaVehiculoMantenimiento->OvmTiempoModificacion = $DatOrdenVentaVehiculoMantenimiento->OvmTiempoModificacion;
						
						$InsOrdenVentaVehiculoMantenimiento->OvmEliminado = $DatOrdenVentaVehiculoMantenimiento->OvmEliminado;
						
						if(empty($InsOrdenVentaVehiculoMantenimiento->OvmId)){
							if($InsOrdenVentaVehiculoMantenimiento->OvmEliminado<>2){
								if($InsOrdenVentaVehiculoMantenimiento->MtdRegistrarOrdenVentaVehiculoMantenimiento()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_601';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsOrdenVentaVehiculoMantenimiento->OvmEliminado==2){
								if($InsOrdenVentaVehiculoMantenimiento->MtdEliminarOrdenVentaVehiculoMantenimiento($InsOrdenVentaVehiculoMantenimiento->OvmId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_OVV_603';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsOrdenVentaVehiculoMantenimiento->MtdEditarOrdenVentaVehiculoMantenimiento()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_602';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->OrdenVentaVehiculoMantenimiento) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarOrdenVentaVehiculo(2,"Se edito la Orden de Venta de Vehiculo",$this);		
				return true;
			}	
				
		}	
		




	
	public function MtdSeguimientoClienteOrdenVentaVehiculo($oTransaccion=true) {

		global $Resultado;
		$error = false;
						
			if(!$error){

				if (!empty($this->OrdenVentaVehiculoLlamada)){		
						
					$validar = 0;				
					
					$InsOrdenVentaVehiculoLlamada = new ClsOrdenVentaVehiculoLlamada();

					foreach ($this->OrdenVentaVehiculoLlamada as $DatOrdenVentaVehiculoLlamada){

						$InsOrdenVentaVehiculoLlamada->OvlId = $DatOrdenVentaVehiculoLlamada->OvlId;
						$InsOrdenVentaVehiculoLlamada->OvvId = $this->OvvId;
					
						$InsOrdenVentaVehiculoLlamada->OvlFecha = $DatOrdenVentaVehiculoLlamada->OvlFecha;						
						$InsOrdenVentaVehiculoLlamada->OvlObservacion = $DatOrdenVentaVehiculoLlamada->OvlObservacion;						
						$InsOrdenVentaVehiculoLlamada->OvlEstado = $DatOrdenVentaVehiculoLlamada->OvlEstado;
						$InsOrdenVentaVehiculoLlamada->OvlTiempoCreacion = $DatOrdenVentaVehiculoLlamada->OvlTiempoCreacion;
						$InsOrdenVentaVehiculoLlamada->OvlTiempoModificacion = $DatOrdenVentaVehiculoLlamada->OvlTiempoModificacion;
						$InsOrdenVentaVehiculoLlamada->OvlEliminado = $DatOrdenVentaVehiculoLlamada->OvlEliminado;
						
						if(empty($InsOrdenVentaVehiculoLlamada->OvlId)){
							if($InsOrdenVentaVehiculoLlamada->OvlEliminado<>2){
								if($InsOrdenVentaVehiculoLlamada->MtdRegistrarOrdenVentaVehiculoLlamada()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_501';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsOrdenVentaVehiculoLlamada->OvlEliminado==2){
								if($InsOrdenVentaVehiculoLlamada->MtdEliminarOrdenVentaVehiculoLlamada($InsOrdenVentaVehiculoLlamada->OvlId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_OVV_503';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsOrdenVentaVehiculoLlamada->MtdEditarOrdenVentaVehiculoLlamada()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OVV_502';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->OrdenVentaVehiculoLlamada) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
					
				
			if($error) {		
			
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();					
				}
			
				return false;
			} else {			

				if($oTransaccion){
					$this->InsMysql->MtdTransaccionHacer();
				}

				$this->MtdAuditarOrdenVentaVehiculo(2,"Se edito el seguimiento de la Orden de Venta de Vehiculo",$this);		
				return true;
			}	
				
		}	
		
		
		
		
		
	public function MtdConfirmarEntregaOrdenVentaVehiculo() {

		global $Resultado;
		$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

				
			$sql = 'UPDATE tblovvordenventavehiculo SET
		
			'.(empty($this->PerIdActaEntrega)?'PerIdActaEntrega = NULL, ':'PerIdActaEntrega = "'.$this->PerIdActaEntrega.'",').'
			'.(empty($this->OvvActaEntregaFecha)?'OvvActaEntregaFecha = NULL, ':'OvvActaEntregaFecha = "'.$this->OvvActaEntregaFecha.'",').'
			'.(empty($this->OvvActaEntregaHora)?'OvvActaEntregaHora = NULL, ':'OvvActaEntregaHora = "'.$this->OvvActaEntregaHora.'",').'
			OvvActaEntregaDescripcion = "'.($this->OvvActaEntregaDescripcion).'",
			OvvFotoActaEntrega = "'.($this->OvvFotoActaEntrega).'"
			
			WHERE OvvId = "'.($this->OvvId).'";';			
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			if(!$resultado) {							
				$error = true;
			} 			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarOrdenVentaVehiculo(2,"Se edito la Orden de Venta de Vehiculo",$this);		
				return true;
			}	
				
		}	
		
		
		
		
			public function MtdEditarOrdenVentaVehiculoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblovvordenventavehiculo SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			OvvTiempoModificacion = NOW()
			WHERE OvvId = "'.($oId).'";';
			
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
		
		
		

	public function MtdGenerarVehiculoMovimientoSalida($oId) {
		
		
		global $EmpresaImpuestoVenta;
		
		$Respuesta = false;
		$GuardarVehiculoMovimientoSalida = true;
		
		
		if(!empty($oId)){
			
			$this->OvvId = $oId;
			$this->MtdObtenerOrdenVentaVehiculo();

			$InsVehiculoMovimientoSalida = new ClsVehiculoMovimientoSalida();
			$InsVehiculoMovimientoSalida->UsuId = $_SESSION['SesionId'];	
			
			$ComprobanteTipoId = "";

			if($this->OvvComprobanteVenta=="B"){
				$ComprobanteTipoId = "CTI-10001";
			}else if($this->OvvComprobanteVenta=="F"){
				$ComprobanteTipoId = "CTI-10000";
			}

			$InsVehiculoMovimientoSalida->VmvId = NULL;
			$InsVehiculoMovimientoSalida->CliId = $this->CliId;
			$InsVehiculoMovimientoSalida->CtiId = $ComprobanteTipoId;	
			$InsVehiculoMovimientoSalida->TopId = "TOP-10000";	
			$InsVehiculoMovimientoSalida->OcoId = NULL;	
			$InsVehiculoMovimientoSalida->AlmId = NULL;	
			$InsVehiculoMovimientoSalida->OvvId = $this->OvvId;
			
			$InsVehiculoMovimientoSalida->SucId = $_SESSION['SesionSucursal'];	
			$InsVehiculoMovimientoSalida->SucIdDestino = NULL;	

			$InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
			$InsVehiculoMovimientoSalida->VmvFecha = date("Y-m-d");
			$InsVehiculoMovimientoSalida->VmvObservacion = "";
			$InsVehiculoMovimientoSalida->VmvObservacion = $this->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Salida Vehicular autogenerada de Ord. Ven. Veh.: ".$this->OvvId." / Cot.: ".$this->CveId;
			
			$InsVehiculoMovimientoSalida->VmvDocumentoOrigen = NULL;
			
			$InsVehiculoMovimientoSalida->VmvComprobanteNumeroSerie = NULL;
			$InsVehiculoMovimientoSalida->VmvComprobanteNumeroNumero = NULL;
			$InsVehiculoMovimientoSalida->VmvComprobanteNumero = NULL;
			
			$InsVehiculoMovimientoSalida->VmvComprobanteFecha = NULL;
		
			$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroSerie = NULL;
			$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumeroNumero = NULL;
			$InsVehiculoMovimientoSalida->VmvGuiaRemisionNumero = NULL;
			
			$InsVehiculoMovimientoSalida->VmvGuiaRemisionFecha = NULL;
			$InsVehiculoMovimientoSalida->VmvGuiaRemisionFoto = NULL;
		
			$InsVehiculoMovimientoSalida->MonId = $this->MonId;
			$InsVehiculoMovimientoSalida->VmvTipoCambio = $this->OvvTipoCambio;
			$InsVehiculoMovimientoSalida->VmvTipoCambioComercial = $this->OvvTipoCambio;
			
			$InsVehiculoMovimientoSalida->VmvIncluyeImpuesto = 2;
		
			$InsVehiculoMovimientoSalida->VmvMargenUtilidad = 0.00;
			$InsVehiculoMovimientoSalida->VmvTipo = 2;
			$InsVehiculoMovimientoSalida->VmvSubTipo = 1;
		
			$InsVehiculoMovimientoSalida->NpaId = "NPA-10002";
			$InsVehiculoMovimientoSalida->VmvCantidadDia = 0;
			
			$InsVehiculoMovimientoSalida->VmvEstado = 1;
			
			$InsVehiculoMovimientoSalida->VmvTiempoCreacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoSalida->VmvTiempoModificacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoSalida->VmvEliminado = 1;
			
			$InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle = array();
			
			//if($InsVehiculoMovimientoSalida->MonId<>$EmpresaMonedaId){
//				if(empty($InsVehiculoMovimientoSalida->VmvTipoCambio)){
//					$Guardar = false;
//					$Resultado.='#ERR_VMS_600';
//				}
//			}
//			
//			if(empty($InsVehiculoMovimientoSalida->SucId)){
//				$Guardar = false;
//				$Resultado.='#ERR_VMS_602';
//			}
			
			$InsVehiculoMovimientoSalida->VmvTotalBruto = 0;
			$InsVehiculoMovimientoSalida->VmvSubTotal = 0;
			$InsVehiculoMovimientoSalida->VmvImpuesto = 0;
			$InsVehiculoMovimientoSalida->VmvTotal = 0;
			$InsVehiculoMovimientoSalida->VmvValorTotal = 0;
			
			$CostoIngresoReal = 0;
			$CostoIngresoMonedaLocal = 0;
			$CostoIngreso = 0;
			
			if(!empty($this->EinTipoCambioIngreso)){
				
				$CostoIngresoReal = $this->EinCostoIngreso/ $this->EinTipoCambioIngreso;
				
				//echo "aaa";	
				
			}else{
				//echo "bbb";
			}
			
			if($this->MonId == $this->MonIdIngreso){
				//echo "ccc";
				
				//deb($CostoIngresoReal);
				//deb($InsOrdenVentaVehiculo->OvvTipoCambio);
				
				$CostoIngreso = $CostoIngresoReal * $this->OvvTipoCambio;
				
				//deb($CostoIngreso);
				
			}else if($this->MonId == $EmpresaMonedaId and $this->MonIdIngreso == $EmpresaMonedaId){
				//echo "ddd";
				$CostoIngreso = $this->EinCostoIngreso;
				
			}else{
				//echo "eeee";	
			}
			
	//		if(empty($CostoIngreso)){
//				
//			}
			
			
			$InsVehiculoMovimientoSalidaDetalle1 = new ClsVehiculoMovimientoSalidaDetalle();
			$InsVehiculoMovimientoSalidaDetalle1->VmdId = NULL;
			$InsVehiculoMovimientoSalidaDetalle1->EinId = $this->EinId;
			$InsVehiculoMovimientoSalidaDetalle1->VehId = $this->VehId;
			$InsVehiculoMovimientoSalidaDetalle1->UmeId = $this->UmeId;
			
			$InsVehiculoMovimientoSalidaDetalle1->VmdIdAnterior = $InsVehiculoMovimientoSalidaDetalle1->MtdObtenerUltimoVehiculoMovimientoSalidaDetalleId($InsVehiculoMovimientoSalidaDetalle1->VehId,$InsVehiculoMovimientoSalida->VmvFecha);
		
			$InsVehiculoMovimientoSalidaDetalle1->VmdCosto = $this->OvvSubTotal;
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoIngreso = $CostoIngreso;
			$InsVehiculoMovimientoSalidaDetalle1->VmdCantidad = 1;
			$InsVehiculoMovimientoSalidaDetalle1->VmdImporte = $this->OvvSubTotal;;
			$InsVehiculoMovimientoSalidaDetalle1->VmdObservacion = "";

			$InsVehiculoMovimientoSalidaDetalle1->VmdFecha = $InsVehiculoMovimientoSalida->VmvFecha;
		
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior = 0;		
			$InsVehiculoMovimientoSalidaDetalle1->VmdUtilidad = 0;
			$InsVehiculoMovimientoSalidaDetalle1->VmdUtilidadPorcentaje = 0;
			
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraTotal = 0;
			$InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraUnitario = 0;
			
			
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica1 = (empty( $this->EinCaracteristica1)?0: $this->EinCaracteristica1);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica2 = (empty( $this->EinCaracteristica2)?0: $this->EinCaracteristica2);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica3 = (empty( $this->EinCaracteristica3)?0: $this->EinCaracteristica3);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica4 = (empty( $this->EinCaracteristica4)?0: $this->EinCaracteristica4);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica5 = (empty( $this->EinCaracteristica5)?0: $this->EinCaracteristica5);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica6 = (empty( $this->EinCaracteristica6)?0: $this->EinCaracteristica6);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica7 = (empty( $this->EinCaracteristica7)?0: $this->EinCaracteristica7);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica8 = (empty( $this->EinCaracteristica8)?0: $this->EinCaracteristica8);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica9 = (empty( $this->EinCaracteristica9)?0: $this->EinCaracteristica9);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica10 = (empty( $this->EinCaracteristica10)?0: $this->EinCaracteristica10);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica11 = (empty( $this->EinCaracteristica11)?0: $this->EinCaracteristica11);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica12 = (empty( $this->EinCaracteristica12)?0: $this->EinCaracteristica12);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica13 = (empty( $this->EinCaracteristica13)?0: $this->EinCaracteristica13);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica14 = (empty( $this->EinCaracteristica14)?0: $this->EinCaracteristica14);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica15 = (empty( $this->EinCaracteristica14)?0: $this->EinCaracteristica14);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica16 = (empty( $this->EinCaracteristica15)?0: $this->EinCaracteristica15);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica17 = (empty( $this->EinCaracteristica16)?0: $this->EinCaracteristica16);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica18 = (empty( $this->EinCaracteristica17)?0: $this->EinCaracteristica17);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica19 = (empty( $this->EinCaracteristica18)?0: $this->EinCaracteristica18);
			$InsVehiculoMovimientoSalidaDetalle1->VmdCaracteristica20 = (empty( $this->EinCaracteristica19)?0: $this->EinCaracteristica19);

			
			
			//$InsVehiculoMovimientoSalidaDetalle1->VmdEstado = $InsOrdenVentaVehiculo->Parametro25;
			$InsVehiculoMovimientoSalidaDetalle1->VmdEstado = 1;		
			$InsVehiculoMovimientoSalidaDetalle1->VmdTiempoCreacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoSalidaDetalle1->VmdTiempoModificacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoSalidaDetalle1->VmdEliminado = 1;				
			$InsVehiculoMovimientoSalidaDetalle1->InsMysql = NULL;

			$InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal =  round($InsVehiculoMovimientoSalidaDetalle1->VmdCosto + ($InsVehiculoMovimientoSalidaDetalle1->VmdCostoExtraUnitario/(($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100)+1)),6);

			settype($InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior,"float");

			if(empty($InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior)){
				$InsVehiculoMovimientoSalidaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal),6);				
			}else{
				$InsVehiculoMovimientoSalidaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoSalidaDetalle1->VmdValorTotal + $InsVehiculoMovimientoSalidaDetalle1->VmdCostoAnterior)/2,6);				
			}		
						
			$InsVehiculoMovimientoSalida->VehiculoMovimientoSalidaDetalle[] = $InsVehiculoMovimientoSalidaDetalle1;		
			


			$InsVehiculoMovimientoSalida->VmvTotalBruto += $InsVehiculoMovimientoSalidaDetalle1->VmdImporte;
			$InsVehiculoMovimientoSalida->VmvSubTotal = $InsVehiculoMovimientoSalida->VmvTotalBruto;
			$InsVehiculoMovimientoSalida->VmvImpuesto = round( ($InsVehiculoMovimientoSalida->VmvSubTotal + $InsVehiculoMovimientoSalida->VmvNacionalTotalRecargo) * ($InsVehiculoMovimientoSalida->VmvPorcentajeImpuestoVenta/100),3);			
			$InsVehiculoMovimientoSalida->VmvTotal = $InsVehiculoMovimientoSalida->VmvSubTotal + $InsVehiculoMovimientoSalida->VmvImpuesto;
		
			if($GuardarVehiculoMovimientoSalida){
		
				if($InsVehiculoMovimientoSalida->MtdRegistrarVehiculoMovimientoSalida()){
					$Respuesta = true;
				}else{
					
				}
					
			}
			
		}else{
			
		}
		
		return $Respuesta;
		
	}	
		
		
		
	public function MtdGenerarVehiculoMovimientoEntradaDevolucion($oId) {
		
		
		global $EmpresaImpuestoVenta;
        //global $EmpresaImpuestoVenta;
		
		$Respuesta = false;
		$GuardarVehiculoMovimientoEntrada = true;
		
		
		if(!empty($oId)){
			
			$this->OvvId = $oId;
			$this->MtdObtenerOrdenVentaVehiculo(true);
            
           // deb($this);
			$InsVehiculoMovimientoEntrada = new ClsVehiculoMovimientoEntrada();
			$InsVehiculoMovimientoEntrada->UsuId = $_SESSION['SesionId'];	
		
			$InsVehiculoMovimientoEntrada->VmvId = NULL;
			$InsVehiculoMovimientoEntrada->CliId = $this->CliId;
			$InsVehiculoMovimientoEntrada->CtiId = "CTI-10008";
			$InsVehiculoMovimientoEntrada->TopId = "TOP-10004";	
			$InsVehiculoMovimientoEntrada->OcoId = NULL;	
			$InsVehiculoMovimientoEntrada->AlmId = NULL;	
			$InsVehiculoMovimientoEntrada->OvvId = $this->OvvId;
			
			$InsVehiculoMovimientoEntrada->SucId = $_SESSION['SesionSucursal'];	
			$InsVehiculoMovimientoEntrada->SucIdDestino = NULL;	

			$InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta = $EmpresaImpuestoVenta;	
			$InsVehiculoMovimientoEntrada->VmvFecha = date("Y-m-d");
			$InsVehiculoMovimientoEntrada->VmvObservacion = "";
			$InsVehiculoMovimientoEntrada->VmvObservacion = $this->OvvObservacion.chr(13).date("d/m/Y H:i:s")." - Ingreso Vehicular autogenerada de Ord. Ven. Veh.: ".$this->OvvId." / Cot.: ".$this->CveId;
			
			$InsVehiculoMovimientoEntrada->VmvDocumentoOrigen = NULL;
			
			$InsVehiculoMovimientoEntrada->VmvComprobanteNumeroSerie = NULL;
			$InsVehiculoMovimientoEntrada->VmvComprobanteNumeroNumero = NULL;
			$InsVehiculoMovimientoEntrada->VmvComprobanteNumero = NULL;
			
			$InsVehiculoMovimientoEntrada->VmvComprobanteFecha = NULL;
		
			$InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroSerie = NULL;
			$InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumeroNumero = NULL;
			$InsVehiculoMovimientoEntrada->VmvGuiaRemisionNumero = NULL;
			
			$InsVehiculoMovimientoEntrada->VmvGuiaRemisionFecha = NULL;
			$InsVehiculoMovimientoEntrada->VmvGuiaRemisionFoto = NULL;
		
			$InsVehiculoMovimientoEntrada->MonId = $this->MonId;
			$InsVehiculoMovimientoEntrada->VmvTipoCambio = $this->OvvTipoCambio;
			$InsVehiculoMovimientoEntrada->VmvTipoCambioComercial = $this->OvvTipoCambio;
			
			$InsVehiculoMovimientoEntrada->VmvIncluyeImpuesto = 2;
		
			$InsVehiculoMovimientoEntrada->VmvMargenUtilidad = 0.00;
			$InsVehiculoMovimientoEntrada->VmvTipo = 1;
			$InsVehiculoMovimientoEntrada->VmvSubTipo = 3;
		
			$InsVehiculoMovimientoEntrada->NpaId = "NPA-10002";
			$InsVehiculoMovimientoEntrada->VmvCantidadDia = 0;
			
			$InsVehiculoMovimientoEntrada->VmvEstado = 3;
			
			$InsVehiculoMovimientoEntrada->VmvTiempoCreacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoEntrada->VmvTiempoModificacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoEntrada->VmvEliminado = 1;
			
			$InsVehiculoMovimientoEntrada->VehiculoMovimientoEntradaDetalle = array();
			
			//if($InsVehiculoMovimientoEntrada->MonId<>$EmpresaMonedaId){
//				if(empty($InsVehiculoMovimientoEntrada->VmvTipoCambio)){
//					$Guardar = false;
//					$Resultado.='#ERR_VMS_600';
//				}
//			}
//			
//			if(empty($InsVehiculoMovimientoEntrada->SucId)){
//				$Guardar = false;
//				$Resultado.='#ERR_VMS_602';
//			}
			
			$InsVehiculoMovimientoEntrada->VmvTotalBruto = 0;
			$InsVehiculoMovimientoEntrada->VmvSubTotal = 0;
			$InsVehiculoMovimientoEntrada->VmvImpuesto = 0;
			$InsVehiculoMovimientoEntrada->VmvTotal = 0;
			$InsVehiculoMovimientoEntrada->VmvValorTotal = 0;
			
			$CostoIngresoReal = 0;
			$CostoIngresoMonedaLocal = 0;
			$CostoIngreso = 0;
			
			if(!empty($this->EinTipoCambioIngreso)){
				
				$CostoIngresoReal = $this->EinCostoIngreso/ $this->EinTipoCambioIngreso;
				
				//echo "aaa";	
				
			}else{
				//echo "bbb";
			}
			
			if($this->MonId == $this->MonIdIngreso){
				//echo "ccc";
				
				//deb($CostoIngresoReal);
				//deb($InsOrdenVentaVehiculo->OvvTipoCambio);
				
				$CostoIngreso = $CostoIngresoReal * $this->OvvTipoCambio;
				
				//deb($CostoIngreso);
				
			}else if($this->MonId == $EmpresaMonedaId and $this->MonIdIngreso == $EmpresaMonedaId){
				//echo "ddd";
				$CostoIngreso = $this->EinCostoIngreso;
				
			}else{
				//echo "eeee";	
			}
			
	//		if(empty($CostoIngreso)){
//				
//			}
			
			
			$InsVehiculoMovimientoEntradaDetalle1 = new ClsVehiculoMovimientoEntradaDetalle();
			$InsVehiculoMovimientoEntradaDetalle1->VmdId = NULL;
			$InsVehiculoMovimientoEntradaDetalle1->EinId = $this->EinId;
			$InsVehiculoMovimientoEntradaDetalle1->VehId = $this->VehId;
			$InsVehiculoMovimientoEntradaDetalle1->UmeId = $this->UmeId;
			
			$InsVehiculoMovimientoEntradaDetalle1->VmdIdAnterior = $InsVehiculoMovimientoEntradaDetalle1->MtdObtenerUltimoVehiculoMovimientoEntradaDetalleId($InsVehiculoMovimientoEntradaDetalle1->VehId,$InsVehiculoMovimientoEntrada->VmvFecha);
		
			$InsVehiculoMovimientoEntradaDetalle1->VmdCosto = $this->OvvSubTotal;
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoIngreso = $CostoIngreso;
			$InsVehiculoMovimientoEntradaDetalle1->VmdCantidad = 1;
			$InsVehiculoMovimientoEntradaDetalle1->VmdImporte = $this->OvvSubTotal;;
			$InsVehiculoMovimientoEntradaDetalle1->VmdObservacion = "";

			$InsVehiculoMovimientoEntradaDetalle1->VmdFecha = $InsVehiculoMovimientoEntrada->VmvFecha;
		
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior = 0;		
			$InsVehiculoMovimientoEntradaDetalle1->VmdUtilidad = 0;
			$InsVehiculoMovimientoEntradaDetalle1->VmdUtilidadPorcentaje = 0;
			
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoExtraTotal = 0;
			$InsVehiculoMovimientoEntradaDetalle1->VmdCostoExtraUnitario = 0;
			
			
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica1 = (empty( $this->EinCaracteristica1)?0: $this->EinCaracteristica1);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica2 = (empty( $this->EinCaracteristica2)?0: $this->EinCaracteristica2);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica3 = (empty( $this->EinCaracteristica3)?0: $this->EinCaracteristica3);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica4 = (empty( $this->EinCaracteristica4)?0: $this->EinCaracteristica4);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica5 = (empty( $this->EinCaracteristica5)?0: $this->EinCaracteristica5);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica6 = (empty( $this->EinCaracteristica6)?0: $this->EinCaracteristica6);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica7 = (empty( $this->EinCaracteristica7)?0: $this->EinCaracteristica7);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica8 = (empty( $this->EinCaracteristica8)?0: $this->EinCaracteristica8);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica9 = (empty( $this->EinCaracteristica9)?0: $this->EinCaracteristica9);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica10 = (empty( $this->EinCaracteristica10)?0: $this->EinCaracteristica10);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica11 = (empty( $this->EinCaracteristica11)?0: $this->EinCaracteristica11);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica12 = (empty( $this->EinCaracteristica12)?0: $this->EinCaracteristica12);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica13 = (empty( $this->EinCaracteristica13)?0: $this->EinCaracteristica13);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica14 = (empty( $this->EinCaracteristica14)?0: $this->EinCaracteristica14);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica15 = (empty( $this->EinCaracteristica14)?0: $this->EinCaracteristica14);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica16 = (empty( $this->EinCaracteristica15)?0: $this->EinCaracteristica15);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica17 = (empty( $this->EinCaracteristica16)?0: $this->EinCaracteristica16);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica18 = (empty( $this->EinCaracteristica17)?0: $this->EinCaracteristica17);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica19 = (empty( $this->EinCaracteristica18)?0: $this->EinCaracteristica18);
			$InsVehiculoMovimientoEntradaDetalle1->VmdCaracteristica20 = (empty( $this->EinCaracteristica19)?0: $this->EinCaracteristica19);

			
			
			//$InsVehiculoMovimientoEntradaDetalle1->VmdEstado = $InsOrdenVentaVehiculo->Parametro25;
			$InsVehiculoMovimientoEntradaDetalle1->VmdEstado = 3;		
			$InsVehiculoMovimientoEntradaDetalle1->VmdTiempoCreacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoEntradaDetalle1->VmdTiempoModificacion = date("Y-m-d H:i:s");
			$InsVehiculoMovimientoEntradaDetalle1->VmdEliminado = 1;				
			$InsVehiculoMovimientoEntradaDetalle1->InsMysql = NULL;

			$InsVehiculoMovimientoEntradaDetalle1->VmdValorTotal =  round($InsVehiculoMovimientoEntradaDetalle1->VmdCosto + ($InsVehiculoMovimientoEntradaDetalle1->VmdCostoExtraUnitario/(($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100)+1)),6);

			settype($InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior,"float");

			if(empty($InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior)){
				$InsVehiculoMovimientoEntradaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoEntradaDetalle1->VmdValorTotal),6);				
			}else{
				$InsVehiculoMovimientoEntradaDetalle1->VmdCostoPromedio =  round(($InsVehiculoMovimientoEntradaDetalle1->VmdValorTotal + $InsVehiculoMovimientoEntradaDetalle1->VmdCostoAnterior)/2,6);				
			}		
						
			$InsVehiculoMovimientoEntrada->VehiculoMovimientoEntradaDetalle[] = $InsVehiculoMovimientoEntradaDetalle1;		
			


			$InsVehiculoMovimientoEntrada->VmvTotalBruto += $InsVehiculoMovimientoEntradaDetalle1->VmdImporte;
			$InsVehiculoMovimientoEntrada->VmvSubTotal = $InsVehiculoMovimientoEntrada->VmvTotalBruto;
			$InsVehiculoMovimientoEntrada->VmvImpuesto = round( ($InsVehiculoMovimientoEntrada->VmvSubTotal + $InsVehiculoMovimientoEntrada->VmvNacionalTotalRecargo) * ($InsVehiculoMovimientoEntrada->VmvPorcentajeImpuestoVenta/100),3);			
			$InsVehiculoMovimientoEntrada->VmvTotal = $InsVehiculoMovimientoEntrada->VmvSubTotal + $InsVehiculoMovimientoEntrada->VmvImpuesto;
		
			if($GuardarVehiculoMovimientoEntrada){
		
				if($InsVehiculoMovimientoEntrada->MtdRegistrarVehiculoMovimientoEntrada()){
					$Respuesta = true;
				}else{
					
				}
					
			}
			
		}else{
			
		}
		
		return $Respuesta;
		
	}	
	
	

		public function MtdNotificarOrdenVentaVehiculoRegistro($oOrdenVentaVehiculo,$oDestinatario){
		
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->OvvId = $oOrdenVentaVehiculo;
			$this->MtdObtenerOrdenVentaVehiculo();
			
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Orden de Venta de Vehiculo.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->OvvId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Cliente:";
			
			if(!empty($this->OrdenVentaVehiculoPropietario)){
				foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					$mensaje .= "<b>".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno."</b> / ";	
				}
			}
			
			$mensaje .= "<br>";	
			
			if(!empty($this->OrdenVentaVehiculoPropietario)){
				foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					$mensaje .= $DatOrdenVentaVehiculoPropietario->TdoNombre." <b>".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento."</b> / ";	
				}
			}
			
			
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->OvvFecha."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<br>";	
			$mensaje .= "Vendedor: <b>".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			
			

			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top'>";
						$mensaje .= "Direccion:";
						$mensaje .= "</td>";
		
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->CliDireccion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Celular:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->OvvCelular;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Vehiculo:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "VIN:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinVIN;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Color:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->OvvColor;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";



			if($this->MonId<>$EmpresaMonedaId){
				if(!empty($this->OvvTipoCambio)){
					$this->OvvTotal = round($this->OvvTotal / $this->OvvTipoCambio,2);

				}else{
					$this->OvvTotal = 0;
				}
			}
			



					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Precio:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->MonSimbolo." ".number_format($this->OvvTotal,2);
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Abono:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= "";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";	
					

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Obsequios y Accesorios:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						
						$obsequio = '';
						if(!empty($this->OrdenVentaVehiculoObsequio)){
							foreach($this->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
								
								$obsequio .= "- ".$DatOrdenVentaVehiculoObsequio->ObsNombre."<br>";
									
							}
						}
						
						
							if(!empty($this->OvvObsequioOtro)){
								$obsequio .= "- ".$this->OvvObsequioOtro."<br>";
							}else{
								$obsequio .= "Ninguno";
							}
							
						$mensaje .= $obsequio;
						
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";						






				$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Mantenimientos Gratuitos:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						
						$mantenimiento = '';
						if(!empty($this->OrdenVentaVehiculoMantenimiento)){
							foreach($this->OrdenVentaVehiculoMantenimiento as $DatOrdenVentaVehiculoMantenimiento){
								
								$mantenimiento .= "- ".$DatOrdenVentaVehiculoMantenimiento->OvmKilometraje."<br>";
									
							}
						}else{
							
						}
						
						
						$mensaje .= $mantenimiento;
						
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";						


			//$this->OvvCondicionVentaOtro = $fila['OvvCondicionVentaOtro'];

			//$this->OvvObsequioOtro = $fila['OvvObsequioOtro'];




					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Condiciones:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						
						$cventa = '';
						if(!empty($this->OrdenVentaVehiculoCondicionVenta)){
							foreach($this->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta){
								
								$cventa .= "- ".$DatOrdenVentaVehiculoCondicionVenta->CovNombre."<br>";
								
							}
						}else{
							if(!empty($this->OvvCondicionVentaOtro)){
								$cventa .= "- ".$this->OvvCondicionVentaOtro."<br>";
							}else{
								$cventa .= "Ninguno";
							}
						}
						
						$mensaje .= $cventa;
						
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";		
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Fecha de Entrega:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->OvvFechaEntrega;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";		
					
					
			$mensaje .= "</table>";
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje);
				
		}
		
		
		
		
	public function MtdEnviarCorreoConfirmarEntregaOrdenVentaVehiculo($oOrdenVentaVehiculo,$oDestinatario){
		
		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->OvvId = $oOrdenVentaVehiculo;
			$this->MtdObtenerOrdenVentaVehiculo();
			
			$mensaje .= "<b><u>NOTIFICACION DE CONFIRMACION DE ENTREGA</u></b>";
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Descripcion:</b> Confirmacion de entrega de Vehiculo";
$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Cliente:</b>";
			
			if(!empty($this->OrdenVentaVehiculoPropietario)){
				foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					$mensaje .= "".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno." / ";	
				}
			}
			
			$mensaje .= "<br>";	
			
			if(!empty($this->OrdenVentaVehiculoPropietario)){
				foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					$mensaje .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ";	
				}
			}
			
			
			$mensaje .= "<br>";	
			$mensaje .= "<b>Fecha Registro:</b> ".$this->OvvFecha."";	
		
			$mensaje .= "<br>";	
			$mensaje .= "<b>Fecha de Entrega:</b> ".$this->OvvActaEntregaFecha."";	
			
			$mensaje .= "<br>";	
			$mensaje .= "<b>Hora de Entrega:</b> ".$this->OvvActaEntregaHora."";	
			
			$mensaje .= "<br>";	
			$mensaje .= "<b>Observaciones:</b> ".$this->OvvActaEntregaDescripcion."";	
				
			$mensaje .= "<br>";	
			$mensaje .= "<b>Asesor de Ventas:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
					
			$mensaje .= "<br>";	
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
			
			$mensaje .= "<br>";
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "VIN:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinVIN;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Vehiculo:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Color:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->OvvColor;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "Obsequios y Accesorios:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						
						$obsequio = '';
						if(!empty($this->OrdenVentaVehiculoObsequio)){
							foreach($this->OrdenVentaVehiculoObsequio as $DatOrdenVentaVehiculoObsequio){
								
								$obsequio .= "- ".$DatOrdenVentaVehiculoObsequio->ObsNombre."<br>";
									
							}
						}
							
							if(!empty($this->OvvObsequioOtro)){
								$obsequio .= "- ".$this->OvvObsequioOtro."<br>";
							}else{
								$obsequio .= "Ninguno";
							}
							
						
						
						$mensaje .= $obsequio;
						
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";						


					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";					
					
			$mensaje .= "</table>";
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
		//	echo $mensaje;
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: ENTREGA ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje);
				
		}
		
		
		
		
		
	public function MtdNotificarOrdenVentaVehiculoAprobacionAsignacionVIN($oOrdenVentaVehiculo,$oDestinatario){
		
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		global $EmpresaMonedaId;
		
			$this->OvvId = $oOrdenVentaVehiculo;
			$this->MtdObtenerOrdenVentaVehiculo();
			
			$InsPago = new ClsPago();
			
			$ResPago = $InsPago->MtdObtenerPagos(NULL,NULL,NULL,"PagFecha","ASC",NULL,NULL,NULL,$oOrdenVentaVehiculo,NULL,NULL);
			$ArrPagos = $ResPago['Datos'];


			$mensaje = "";
			
			$mensaje .= "<b><u>SOLICITUD DE APROBACION DE VIN</u></b>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<i>Solicitud de aprobacion de VIN para Orden de Venta de Vehiculo.</i>";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->OvvId."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Cliente:</b>";
			
			$clientes = "";
			
			$clientes .= $this->TdoNombre." ".$this->CliNumeroDocumento." / ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno;
			
			if(!empty($this->OrdenVentaVehiculoPropietario)){
				foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
					
					if($this->CliId<>$DatOrdenVentaVehiculoPropietario->CliId){
						$clientes .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno;
					}
					
					//$clientes .= "".$DatOrdenVentaVehiculoPropietario->CliNombre." ".$DatOrdenVentaVehiculoPropietario->CliApellidoPaterno." ".$DatOrdenVentaVehiculoPropietario->CliApellidoMaterno." / ";	
				}
			}
			
		//	$mensaje .= "<br>";	
//			
//			if(!empty($this->OrdenVentaVehiculoPropietario)){
//				foreach($this->OrdenVentaVehiculoPropietario as $DatOrdenVentaVehiculoPropietario){
//					$mensaje .= $DatOrdenVentaVehiculoPropietario->TdoNombre." ".$DatOrdenVentaVehiculoPropietario->CliNumeroDocumento." / ";	
//				}
//			}
			$mensaje .= $clientes;
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Fecha de Orden:</b> ".$this->OvvFecha."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Vendedor:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<b>Sucursal:</b> ".$this->SucNombre."";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					
						$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>VIN</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinVIN;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Vehiculo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Color:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinColor;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Fabricacion:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoFabricacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Año Modelo:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinAnoModelo;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Estado:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinEstadoVehicular;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Ubicacion del vehiculo</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->EinUbicacion;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Fecha de Entrega Estimada(*)</b>:";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->OvvFechaEntrega;
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";
					
					
					
					if($this->MonId<>$EmpresaMonedaId){
						if(!empty($this->OvvTipoCambio)){
							$this->OvvTotal = round($this->OvvTotal / $this->OvvTipoCambio,2);
		
						}else{
							$this->OvvTotal = 0;
						}
					}

					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Precio Total:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						$mensaje .= $this->MonSimbolo." ".number_format($this->OvvTotal,2);
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";					
					
					
					
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Abonos:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						
						$abonos = '';
						$i = 1;
						
						if(!empty($ArrPagos)){
								
								
							foreach($ArrPagos as $DatPago){
								
								$DatPago->PagMonto = (($EmpresaMonedaId==$DatPago->MonId or empty($DatPago->MonId))?$DatPago->PagMonto:($DatPago->PagMonto/$DatPago->PagTipoCambio));
								
								$abonos .= "Abono ".$i.".- ".$DatPago->PagFechaTransaccion." ".$DatPago->MonSimbolo." ".number_format($DatPago->PagMonto,2);
								$abonos .= "<br>";
								
								
								$i++;
							}
							
						}else{
							$abonos = 'Ninguno';
						}
						
						
						$mensaje .= $abonos;
						
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";	
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td valign='top' >";
						$mensaje .= "<b>Condiciones de Venta:</b>";
						$mensaje .= "</td>";
						
						$mensaje .= "<td valign='top' >";
						
						$cventa = '';
						if(!empty($this->OrdenVentaVehiculoCondicionVenta)){
							foreach($this->OrdenVentaVehiculoCondicionVenta as $DatOrdenVentaVehiculoCondicionVenta){
								
								$cventa .= "- ".$DatOrdenVentaVehiculoCondicionVenta->CovNombre."<br>";
								
							}
						}else{
							if(!empty($this->OvvCondicionVentaOtro)){
								$cventa .= "- ".$this->OvvCondicionVentaOtro."<br>";
							}else{
								$cventa .= "Ninguno";
							}
						}
						
						$mensaje .= $cventa;
						
						$mensaje .= "</td>";
		
					$mensaje .= "</tr>";		
					
					
			$mensaje .= "</table>";
			$mensaje .= "<br>";
			
			$mensaje .= "(*) El VIN es propuesto por el sitema y no definitivo.";
			$mensaje .= "<br>";
			
			$mensaje .= "(**) La fecha de entrega es solo referencial.";
			$mensaje .= "<br>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//$mensaje = utf8_decode($mensaje);
			
			$InsCorreo = new ClsCorreo();	
			//$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"SOLICITUD APROBACION VIN: ORD. VEN. VEH. Nro.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje);
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"SOLICITUD APROBACION VIN: ORD. VEN. VEH.: ".$this->OvvId." - ".$this->EinVIN." - ".$this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre,$mensaje);

			return true;			
			
		}
		
		
		
		
		
		
		
			public function MtdGenerarExcelOrdenVentaVehiculoSolicitarVIN($oOrdenVentaVehiculo,$oRuta=NULL){
			
			global $EmpresaMonedaId;
			global $EmpresaMon;
			
			$Generado = true;
			
			if(!empty($oOrdenVentaVehiculo)){

				$this->OvvId = $oOrdenVentaVehiculo;
				$this->MtdObtenerOrdenVentaVehiculo();
			 	
				if($this->MonId<>$EmpresaMonedaId){

					$this->OvvPrecio = round($this->OvvPrecio / $this->OvvTipoCambio,3);
					$this->OvvDescuento = round($this->OvvDescuento / $this->OvvTipoCambio,3);
					
					$this->OvvBonoGM = round($this->OvvBonoGM / $this->OvvTipoCambio,3);
					$this->OvvBonoDealer = round($this->OvvBonoDealer / $this->OvvTipoCambio,3);
					
					$this->OvvDescuentoGerencia = round($this->OvvDescuentoGerencia / $this->OvvTipoCambio,3);
					
					$this->OvvTotal = round($this->OvvTotal / $this->OvvTipoCambio,3);
					$this->OvvImpuesto = round($this->OvvImpuesto / $this->OvvTipoCambio,3);
					$this->OvvSubTotal = round($this->OvvSubTotal / $this->OvvTipoCambio,3);
					
					
				}	
				
					$objPHPExcel = new PHPExcel();
					
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($oRuta."plantilla/TemOrdenVentaVehiculoSolicitudVIN.xls");
					
							$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("PHPExcel Test Document")
									 ->setSubject("PHPExcel Test Document")
									 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Test result file");

						
							// Miscellaneous glyphs, UTF-8
	//						$objPHPExcel->setActiveSheetIndex(0)
//										->setCellValue('D4', $this->OvvId);
//							$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true)->setSize(14);		
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('A2',1);
							$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('B2', $this->OvvMes);
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('C2',$this->OvvDia);
							$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D2', $this->OvvFecha);
							$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('E2', $this->OvvId);
							$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F2', $this->PerAbreviatura);
							$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('G2', $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(false)->setSize(12);
							
									
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('H2', $this->CliNumeroDocumento);
							$objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(false)->setSize(12);
													
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('I2', $this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('J2', $this->CliEmail);
							$objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(false)->setSize(12);
								
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('K2', $this->CliTelefono." ".$this->CliCelular);
							$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(false)->setSize(12);
															
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('L2', $this->CliFechaNacimiento);
							$objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(false)->setSize(12);
								
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('M2', $this->CliSexo);
							$objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('N2', $this->CliEstadoCivil);
							$objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(false)->setSize(12);
								
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('O2', $this->CliDireccion);
							$objPHPExcel->getActiveSheet()->getStyle('O2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('P2', $this->CliDistrito);
							$objPHPExcel->getActiveSheet()->getStyle('P2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('Q2', $this->CliProvincia);
							$objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(false)->setSize(12);
														
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('R2', $this->CliDepartamento);
							$objPHPExcel->getActiveSheet()->getStyle('R2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('S2', $this->VmaNombre." ".$this->VmoNombre);
							$objPHPExcel->getActiveSheet()->getStyle('S2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('T2', $this->OvvColor);
							$objPHPExcel->getActiveSheet()->getStyle('T2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('U2', $this->OvvTotal);
							$objPHPExcel->getActiveSheet()->getStyle('U2')->getFont()->setBold(false)->setSize(12);
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('V2', $this->OvvPrimerAbono);
							$objPHPExcel->getActiveSheet()->getStyle('V2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('W2', $this->OvvGLP);
							$objPHPExcel->getActiveSheet()->getStyle('W2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('X2', (empty($this->EinVIN)?"POR ASIGNAR":$this->EinVIN));
							$objPHPExcel->getActiveSheet()->getStyle('X2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('Y2', $this->SucNombre);
							$objPHPExcel->getActiveSheet()->getStyle('Y2')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('Z2', $this->OvvObservacionesPedido);
							$objPHPExcel->getActiveSheet()->getStyle('Z2')->getFont()->setBold(false)->setSize(12);
						
						// Rename worksheet
						$objPHPExcel->getActiveSheet()->setTitle($this->OvvId);
						// Set active sheet index to the first sheet, so Excel opens this as the first sheet
						$objPHPExcel->setActiveSheetIndex(0);
					
						$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						$objWriter->save($oRuta."generados/orden_venta_vehiculo/".$this->OvvId.".xls");
				
			}else{
				
				$Generado = false;
					
			}

			return $Generado;
		
		}
		
		public function MtdEnviarCorreoSolicitarVINOrdenVentaVehiculo($oOrdenCompra,$oDestinatario,$oRemitente,$oAdjunto=array()){
			
			global $SistemaCorreoUsuario;
			global $SistemaCorreoRemitente;
			global $SistemaNombreAbreviado;
			global $SistemaCorreoRemitente;
			global $EmpresaMonedaId;
			
			$Envio = false;
			
			$this->OvvId = $oOrdenCompra;
			$this->MtdObtenerOrdenVentaVehiculo();
			
				if($this->MonId<>$EmpresaMonedaId){

					$this->OvvPrecio = round($this->OvvPrecio / $this->OvvTipoCambio,3);
					$this->OvvDescuento = round($this->OvvDescuento / $this->OvvTipoCambio,3);
					
					$this->OvvBonoGM = round($this->OvvBonoGM / $this->OvvTipoCambio,3);
					$this->OvvBonoDealer = round($this->OvvBonoDealer / $this->OvvTipoCambio,3);
					
					$this->OvvDescuentoGerencia = round($this->OvvDescuentoGerencia / $this->OvvTipoCambio,3);
					
					$this->OvvTotal = round($this->OvvTotal / $this->OvvTipoCambio,3);
					$this->OvvImpuesto = round($this->OvvImpuesto / $this->OvvTipoCambio,3);
					$this->OvvSubTotal = round($this->OvvSubTotal / $this->OvvTipoCambio,3);
					
					
				}	
				
			$mensaje = "";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<b>Estimados Señores.-</b>";
			$mensaje .= "<br><br>";
			
			$mensaje .= "Se solicita asignacion de VIN para la siguiente orden de venta <b>".$this->OvvId."</b> con fecha <b>".$this->OvvFecha."</b>";
			$mensaje .= "<br>";
			
			if(!empty($this->OvvObservacionCorreo)){
				$mensaje .= "<br>";
				$mensaje .= $this->OvvObservacionCorreo;
				$mensaje .= "<br>";
				
			}
			
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
					$mensaje .= "<table border='1' cellpadding='0' cellspacing='0' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Nª-";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Mes";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Dia";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Fecha";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Nro Pedido";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "AS";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Asesor";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Nº Doc. Iden.";
						$mensaje .= "</td>";
						
						
						
						$mensaje .= "<td>";
						$mensaje .= "Cliente";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "E- MAIL";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Telefono";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Fecha de Nacimiento";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Sexo";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Estado Civil";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Direccion";
						$mensaje .= "</td>";
						
						
						$mensaje .= "<td>";
						$mensaje .= "Distrito";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Provincia";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Departamento";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Modelo";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Color";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Precio Venta U$";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Inicial U$";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "GLP";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td>";
						$mensaje .= "VIN Asignado";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td>";
						$mensaje .= "Local";
						$mensaje .= "</td>";	
						
						$mensaje .= "<td>";
						$mensaje .= "OBSERVACIONES";
						$mensaje .= "</td>";	
						
							
					$mensaje .= "</tr>";

					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "1";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .=  $this->OvvMes;
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .=  $this->OvvDia;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->OvvFecha;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->OvvId;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->PerAbreviatura;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliNumeroDocumento;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliNombre." ". $this->CliApellidoPaterno." ". $this->CliApellidoMaterno;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliEmail;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliTelefono." ".$this->CliCelular;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliFechaNacimiento;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliSexo;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliEstadoCivil;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliDireccion;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliDistrito;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliProvincia;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->CliDepartamento;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->VmaNombre." ".$this->VmoNombre." ".$this->VveNombre;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->OvvColor;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  number_format($this->OvvTotal,2);
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  number_format($this->OvvPrimerAbono,2);
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->OvvGLP;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  (empty($this->EinVIN)?"POR ASIGNAR":$this->EinVIN);
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->SucNombre;
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .=  $this->OvvObservacionPedido;
						$mensaje .= "</td>";
					
					$mensaje .= "</tr>";
					
					$mensaje .= "</table>";
					

			
			$mensaje .= "<br><br>";
			$mensaje .= "Estare a la espera de su pronta respuesta.";
			$mensaje .= "<br><br>";
			//$mensaje .= "Saludos";
			
			if(!empty($oRemitente)){

				$mensaje .= "<br><br>";
				$mensaje .= "Atte.";
				
				$mensaje .= "<br><br>";
				$mensaje .= $oRemitente;
	
			}

			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";

			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');

			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"SOLICITUD VIN:".$this->OvvId,$mensaje,NULL,$oAdjunto);
			
			$Envio = true;
			
			return $Envio;
			
		}
		
		
			
		private function MtdAuditarOrdenVentaVehiculo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->OvvId;

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
		
		
		
	function FncNotificarFacturarOrdenVentaVehiculo($oOrdenVentaVehiculoId,$oTipoComprobante,$oUsuarioId,$oUsuario,$oDescripcionAdicional=NULL,$oPersonalNombre=NULL,$oPersonalFoto=NULL){
	
		$InsNotificacion = new ClsNotificacion();
		$InsNotificacion->UsuId = NULL;
		$InsNotificacion->UsuIdOrigen = $oUsuarioId;
		$InsNotificacion->NfnUsuario = $oUsuario;

		$InsNotificacion->NfnModulo = "ComprobanteVenta";
		$InsNotificacion->NfnFormulario = "MonitoreoOrdenVentaVehiculo";
		$InsNotificacion->NfnDescripcion = "<b>".$oUsuario."</b> te ha enviado una orden de facturacion vehicular. - ".$oDescripcionAdicional;
		$InsNotificacion->NfnEnlace = "principal.phpMod=ComprobanteVenta&Form=MonitoreoOrdenVentaVehiculo&OvvId=".$oOrdenVentaVehiculoId."&Leido=1";
		$InsNotificacion->NfnEnlaceNombre = "Mostrar";
		
		$InsNotificacion->NfnPersonalNombreCompleto = $oPersonalNombre;
		$InsNotificacion->NfnPersonalFoto = $oPersonalFoto;

		$InsNotificacion->NfnTipo = 1;
		$InsNotificacion->NfnEstado = 1;
		$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
		$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");
	
		$InsNotificacion->MtdRegistrarNotificacion();
					
	}
	
}
?>