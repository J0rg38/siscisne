<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoIngreso {

    public $EinId;
	public $SucId;
	
	public $VprId;
	public $CliId;
	public $VehId;
	public $OncId;
	
	public $EinVIN;
	public $EinFechaVenta;
	
	public $VmaId;
	public $VmoId;
	public $VveId;
	public $VtiId;
	
    public $EinAnoFabricacion;
	public $EinAnoModelo;
	public $EinAnoVehiculo;
	public $EinNumeroMotor;

	public $EinTransmision;
	
	public $EinDUA;
	public $EinGuiaTransporte;
	public $EinGuiaRemision;
	public $EinPlaca;
	public $EinPoliza;
	public $EinZofra;
	public $EinNacionalizado;
	
	public $EinColor;
	
	public $EinTipo;
	
	public $EinNumeroProforma;
	public $EinAnoProforma;
	public $EinMesProforma;
	
	public $PerId;
	public $EinArchivoDAM;
	public $EinArchivoDAM2;
	public $EinArchivoDAM3;
	
	public $EinFechaSalidaDAM;
	public $EinFechaRetornoDAM;
	public $EinEstadoVehicular;
	public $EinSolicitud;
	public $EinEstadoVehicularFechaSalida;
	public $EinEstadoVehicularFechaLlegada;
	public $EinNumeroViaje;
	public $EinUbicacionReferencia;
	public $EinManualPropietario;
	public $EinManualGarantia;
	
	public $EinFoto;
	
	public $EinKilometraje;
	public $EinNombre;
	public $VveCaracteristica1;
	public $VveCaracteristica2;
	public $VveCaracteristica3;
	public $VveCaracteristica4;
	public $VveCaracteristica5;
	public $VveCaracteristica6;
	public $VveCaracteristica7;
	public $VveCaracteristica8;
	public $VveCaracteristica9;
	public $VveCaracteristica10;
	
	public $VveCaracteristica11;
	public $VveCaracteristica12;
	public $VveCaracteristica13;
	public $VveCaracteristica14;
	public $VveCaracteristica15;
	public $VveCaracteristica16;
	public $VveCaracteristica17;
	public $VveCaracteristica18;
	public $VveCaracteristica19;
	public $VveCaracteristica20;
	
	public $MonId;
	public $EinTipoCambio;
	public $EinDescuentoGerencia;
	public $EinClaveAlarma;
	
	public $EinEstado;
    public $EinTiempoCreacion;
    public $EinTiempoModificacion;
    public $EinEliminado;
	
//	public $VmoId;
	public $VmoNombre;
	
//	public $VmaId;
	public $VmaNombre;
	
//	public $VtiId;
	public $VtiNombre;
	
//	public $VveId;
	public $VveNombre;

//	public $VehColor;

		
	public $TdoId;
	public $CliNombre;
	public $CliNumeroDocumento;
	
	public $OncNombre;
	
	public $VehiculoIngresoCliente;
			
    public $InsMysql;
	public $Transaccion;
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		
		$this->Transaccion = true;
    }
	
	public function __destruct(){

	}

	public function MtdGenerarVehiculoIngresoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(EinId,5),unsigned)) AS "MAXIMO"
			FROM tbleinvehiculoingreso';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->EinId = "EIN-10000";

			}else{
				$fila['MAXIMO']++;
				$this->EinId = "EIN-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerVehiculoIngreso($oCompleto=true){

         $sql = 'SELECT 
		ein.EinId,
		ein.SucId,
		
		vpd.VprId,
		ein.CliId,
		ein.OncId,
		ein.VehId,
		
		
		ein.VveId,
		ein.VtiId,
		
		ein.EinVIN,
		DATE_FORMAT(ein.EinFechaVenta, "%d/%m/%Y") AS "NEinFechaVenta",

		ein.EinAnoFabricacion,
		ein.EinAnoModelo,
		ein.EinAnoVehiculo,
		ein.EinNumeroMotor,

		ein.EinTransmision,
		
		ein.EinDUA,
		ein.EinGuiaTransporte,
		ein.EinGuiaRemision,
		ein.EinPlaca,
		ein.EinPoliza,
		ein.EinZofra,
		ein.EinNacionalizado,
		ein.EinColor,
		ein.EinColorInterno,

		
		ein.EinTipo,
		
		ein.EinNotaPedido,
ein.EinNumeroProforma,

		ein.EinAnoProforma,
		ein.EinMesProforma,
		
		ein.PerId,		
		
		ein.EinArchivoDAM,		
		ein.EinArchivoDAM2,		
		ein.EinArchivoDAM3,
	
		DATE_FORMAT(ein.EinFechaSalidaDAM, "%d/%m/%Y") AS "NEinFechaSalidaDAM",
		DATE_FORMAT(ein.EinFechaRetornoDAM, "%d/%m/%Y") AS "NEinFechaRetornoDAM",
		ein.EinEstadoVehicular,
		ein.EinSolicitud,		
		DATE_FORMAT(ein.EinEstadoVehicularFechaSalida, "%d/%m/%Y") AS "NEinEstadoVehicularFechaSalida",
		DATE_FORMAT(ein.EinEstadoVehicularFechaLlegada, "%d/%m/%Y") AS "NEinEstadoVehicularFechaLlegada",		
		ein.EinNumeroViaje,
		ein.EinUbicacionReferencia,
		ein.EinManualPropietario,
		ein.EinManualGarantia,	
	
		ein.EinFoto,
		ein.EinFotoVIN,
		ein.EinFotoFrontal,
		ein.EinFotoCupon,
	
		ein.EinKilometraje,
		ein.EinNombre,
		
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
		
		vve.VveCaracteristica1,
		vve.VveCaracteristica2,
		vve.VveCaracteristica3,
		vve.VveCaracteristica4,
		vve.VveCaracteristica5,
		vve.VveCaracteristica6,
		vve.VveCaracteristica7,
		vve.VveCaracteristica8,
		vve.VveCaracteristica9,
		vve.VveCaracteristica10,
		
		vve.VveCaracteristica11,
		vve.VveCaracteristica12,
		vve.VveCaracteristica13,
		vve.VveCaracteristica14,
		vve.VveCaracteristica15,
		vve.VveCaracteristica16,
		vve.VveCaracteristica17,
		vve.VveCaracteristica18,
		vve.VveCaracteristica19,
		vve.VveCaracteristica20,
		
		ein.MonId,
		ein.EinTipoCambio,
		ein.EinDescuentoGerencia,

		DATE_FORMAT(ein.EinRecepcionFecha, "%d/%m/%Y") AS "NEinRecepcionFecha",
		ein.EinRecepcionZonaComprometida,
		ein.EinRecepcionRepuestoDetalle,
		ein.EinRecepcionSolucion,
		ein.EinRecepcionObservacion,
		ein.EinClaveAlarma,
		
		ein.EinComprobanteCompraNumero,
		DATE_FORMAT(ein.EinComprobanteCompraFecha, "%d/%m/%Y") AS "NEinComprobanteCompraFecha",
		
		ein.EinCostoIngreso,
		ein.MonIdIngreso,
		ein.EinTipoCambioIngreso,
		
		ein.EinObservado,
		ein.EinObservadoMotivo,
		
		DATE_FORMAT(ein.EinControlGuiaRemisionFecha, "%d/%m/%Y") AS "NEinControlGuiaRemisionFecha",
		ein.EinControlGuiaRemisionNumero,
		ein.EinControlEmpresaTransporte,
		DATE_FORMAT(ein.EinControlFechaRecepcion, "%d/%m/%Y") AS "NEinControlFechaRecepcion",
		DATE_FORMAT(ein.EinControlGuiaRemisionFechaOtro, "%d/%m/%Y") AS "NEinControlGuiaRemisionFechaOtro",
		ein.EinControlGuiaRemisionNumeroOtro,
		
		ein.EinCancelado,
		
			
		ein.EinPredictivoObservacion,
		DATE_FORMAT(ein.EinPredictivoFecha, "%d/%m/%Y") AS "NEinPredictivoFecha",
		
		ein.EinEstado,
		DATE_FORMAT(ein.EinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEinTiempoCreacion",
        DATE_FORMAT(ein.EinTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEinTiempoModificacion",
	
		vmo.VmaId,
		vma.VmaNombre,

		vve.VmoId,
		vmo.VmoNombre,
		
		vmo.VtiId,
		vti.VtiNombre,

		ein.VveId,		
		vve.VveNombre,
		
		veh.VehColor,
		
		cli.TdoId,
		CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombre,
		cli.CliNumeroDocumento,
		
		onc.OncNombre,
		
		vpr.VprAno,
		vpr.VprMes,
		
		vpr.VprCodigo,
		vpr.MonId AS VehiculoProformaMonId,
		vpr.VprTipoCambio,
		vpd.VpdCosto,
		
		DATE_FORMAT(ein.EinRecepcionFecha, "%d/%m/%Y") AS "NEinRecepcionFecha",
		(
		
			SELECT 
			ovv.OvvId
			FROM tblovvordenventavehiculo ovv
			WHERE ovv.EinId = ein.EinId
				AND ovv.OvvEstado <> 6
			LIMIT 1
		
		) AS OvvId,
		(
		
			SELECT 
			DATE_FORMAT(ovv.OvvFecha, "%d/%m/%Y")
			FROM tblovvordenventavehiculo ovv
			WHERE ovv.EinId = ein.EinId
				AND ovv.OvvEstado <> 6
			LIMIT 1
		
		) AS OvvFecha,
		
		
		
		
		
		(
					SELECT 
					(suc.SucNombre)
					FROM tblfacfactura fac
					LEFT JOIN tblftafacturatalonario fta
					ON fac.FtaId = fta.FtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON fac.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
				)  OvvFacturaSucursal,

		



			(
					SELECT 
			suc.SucNombre
					FROM tblbolboleta bol
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON bol.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
				) AS OvvBoletaSucursal,
			
		
		
		
		(
					SELECT 
					(fac.FtaId)
					FROM tblfacfactura fac
					LEFT JOIN tblftafacturatalonario fta
					ON fac.FtaId = fta.FtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON fac.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
				)  FtaId,
				
		
		
		
		
		
		(
					SELECT 
					(fac.FacId)
					FROM tblfacfactura fac
					LEFT JOIN tblftafacturatalonario fta
					ON fac.FtaId = fta.FtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON fac.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
				)  FacId,
				
		
		
				(
					SELECT 
				(bol.BolId)
					FROM tblbolboleta bol
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON bol.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
					(bol.BtaId)
					FROM tblbolboleta bol
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON bol.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
					LEFT JOIN tblovvordenventavehiculo ovv
					ON fac.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
				)  OvvFactura,
				
					
		
		
		(
					SELECT 
					DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y")
					FROM tblfacfactura fac
					LEFT JOIN tblftafacturatalonario fta
					ON fac.FtaId = fta.FtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON fac.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON fac.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
				)  OvvFacturaFecha,
				
				

				(
					SELECT 
					CONCAT(bta.BtaNumero,"-",bol.BolId)
					FROM tblbolboleta bol
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON bol.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
				) AS OvvBoleta,
		
		


(
					SELECT 
			DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y")
					FROM tblbolboleta bol
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
					LEFT JOIN tblovvordenventavehiculo ovv
					ON bol.OvvId = ovv.OvvId
					LEFT JOIN tblsucsucursal suc
					ON bol.SucId = suc.SucId
					WHERE ovv.EinId = ein.EinId
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
		IFNULL(bol.BolFechaEmision,fac.FacFechaEmision)
		FROM tblovvordenventavehiculo ovv
			
			LEFT JOIN tblfacfactura fac
			ON fac.OvvId = ovv.OvvId
				LEFT JOIN tblbolboleta bol
				ON bol.OvvId = ovv.OvvId
		WHERE ovv.EinId = ein.EinId
		AND ovv.OvvEstado <> 6
		LIMIT 1
		) AS EinFechaVenta,
	
		(
		SELECT 
			fin.FinVehiculoKilometraje
			FROM tblfinfichaingreso fin
				
			WHERE fin.EinId = ein.EinId
			ORDER BY fin.FinFecha DESC LIMIT 1
			
		) AS EinVehiculoKilometraje,
	
		(
			SELECT 
			fin.FinMantenimientoKilometraje
			FROM tblfinfichaingreso fin
				
			WHERE fin.EinId = ein.EinId
			ORDER BY fin.FinFecha DESC LIMIT 1
			
		) AS EinMantenimientoKilometraje,
	
	
		(
			SELECT 
			COUNT(fin.FinId)
			FROM tblfinfichaingreso fin
			WHERE fin.EinId = ein.EinId
			AND EXISTS (
				SELECT 
				fim.FimId 
				FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = fin.FinId
				AND fim.MinId = "MIN-10001"
			)
			ORDER BY fin.FinFecha DESC LIMIT 1
			
		) AS EinCantidadMantenimientos,
		
		
		(
			SELECT 
			(vic.CliId)
			FROM tblvicvehiculoingresocliente vic
			WHERE vic.EinId = ein.EinId
			ORDER BY vic.VicFecha DESC, vic.VicTiempoCreacion DESC 
			LIMIT 1
			
		) AS CliId,
		
		veh.VehCodigoIdentificador,
		veh.UmeId
	
        FROM tbleinvehiculoingreso ein
		
			LEFT JOIN tblvehvehiculo veh
			ON ein.VehId = veh.VehId
			
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
									LEFT JOIN tblclicliente cli
									ON ein.CliId = cli.CliId
										LEFT JOIN tbloncconcesionario onc
										ON ein.OncId = onc.OncId	
										
											LEFT JOIN tblvpdvehiculoproformadetalle vpd
											ON vpd.EinId = ein.EinId
											
												LEFT JOIN tblvprvehiculoproforma vpr
												ON vpd.VprId = vpr.VprId
																			
        WHERE ein.EinId = "'.$this->EinId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->EinId = $fila['EinId'];
			$this->SucId = $fila['SucId'];
			
			$this->CliId = $fila['CliId'];			
			$this->OncId = $fila['OncId'];
			
			$this->VehId = $fila['VehId'];
			$this->EinVIN = (($fila['EinVIN']));
			$this->EinFechaVenta = (($fila['NEinFechaVenta']));
			
			$this->FacId = (($fila['FacId']));
			$this->FtaId = (($fila['FtaId']));
			
			$this->BolId = (($fila['BolId']));
			$this->BtaId = (($fila['BtaId']));
		
			$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$this->EinAnoModelo = $fila['EinAnoModelo'];		
			$this->EinAnoVehiculo = $fila['EinAnoVehiculo'];
			
			$this->EinNumeroMotor = $fila['EinNumeroMotor'];
			
			$this->EinTransmision = $fila['EinTransmision'];

			$this->EinDUA = $fila['EinDUA'];
			$this->EinGuiaTransporte = $fila['EinGuiaTransporte'];
			$this->EinGuiaRemision = $fila['EinGuiaRemision'];
			$this->EinPlaca = $fila['EinPlaca'];
			$this->EinPoliza = $fila['EinPoliza'];
			$this->EinZofra = $fila['EinZofra'];
			$this->EinNacionalizado = $fila['EinNacionalizado'];
			$this->EinColor = $fila['EinColor'];
			$this->EinColorInterno = $fila['EinColorInterno'];
			
			$this->EinTipo = $fila['EinTipo'];
			
			$this->EinNumeroProforma = $fila['EinNumeroProforma'];
			$this->PerId = $fila['PerId'];
			$this->EinFechaSalidaDAM = $fila['EinFechaSalidaDAM'];
			$this->EinFechaRetornoDAM = $fila['EinFechaRetornoDAM'];
			$this->EinEstadoVehicular = $fila['EinEstadoVehicular'];
			$this->EinSolicitud = $fila['EinSolicitud'];
			$this->EinEstadoVehicularFechaSalida = $fila['EinEstadoVehicularFechaSalida'];
			$this->EinEstadoVehicularFechaLlegada = $fila['EinEstadoVehicularFechaLlegada'];
			$this->EinNumeroViaje = $fila['EinNumeroViaje'];
			
			$this->EinUbicacionReferencia = $fila['EinUbicacionReferencia'];
			$this->EinManualPropietario = $fila['EinManualPropietario'];
			$this->EinManualGarantia = $fila['EinManualGarantia'];

		
			$this->EinFoto = $fila['EinFoto'];
			$this->EinFotoVIN = $fila['EinFotoVIN'];
			$this->EinFotoFrontal = $fila['EinFotoFrontal'];
			$this->EinFotoCupon = $fila['EinFotoCupon'];
			$this->EinFotoMantenimiento = $fila['EinFotoMantenimiento'];
			
	
			$this->EinNotaPedido = $fila['EinNotaPedido'];
			$this->EinNumeroProforma = $fila['EinNumeroProforma'];
			$this->EinAnoProforma = $fila['EinAnoProforma'];
			$this->EinMesProforma = $fila['EinMesProforma'];
			
			$this->PerId = $fila['PerId'];

			$this->EinArchivoDAM = $fila['EinArchivoDAM'];
			$this->EinArchivoDAM2 = $fila['EinArchivoDAM2'];
			$this->EinArchivoDAM3 = $fila['EinArchivoDAM3'];
			
			$this->EinFechaSalidaDAM = $fila['NEinFechaSalidaDAM'];
			$this->EinFechaRetornoDAM = $fila['NEinFechaRetornoDAM'];
			$this->EinEstadoVehicular = $fila['EinEstadoVehicular'];
			$this->EinSolicitud = $fila['EinSolicitud'];
			$this->EinEstadoVehicularFechaSalida = $fila['NEinEstadoVehicularFechaSalida'];
			$this->EinEstadoVehicularFechaLlegada = $fila['NEinEstadoVehicularFechaLlegada'];
			$this->EinNumeroViaje = $fila['EinNumeroViaje'];
			$this->EinUbicacionReferencia = $fila['EinUbicacionReferencia'];
			$this->EinManualPropietario = $fila['EinManualPropietario'];
			$this->EinManualGarantia = $fila['EinManualGarantia'];
			
			
			$this->EinKilometraje = $fila['EinKilometraje'];
			$this->EinNombre = $fila['EinNombre'];
			
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
			$this->VveCaracteristica18 = $fila['VveCaracteristica18'];
			$this->VveCaracteristica19 = $fila['VveCaracteristica19'];
			$this->VveCaracteristica20 = $fila['VveCaracteristica20'];
			
			$this->MonId = $fila['MonId'];
			$this->EinTipoCambio = $fila['EinTipoCambio'];
			$this->EinDescuentoGerencia = $fila['EinDescuentoGerencia'];
			
			$this->EinRecepcionFecha = $fila['NEinRecepcionFecha'];
			$this->EinRecepcionZonaComprometida = $fila['EinRecepcionZonaComprometida'];
			$this->EinRecepcionRepuestoDetalle = $fila['EinRecepcionRepuestoDetalle'];
			$this->EinRecepcionSolucion = $fila['EinRecepcionSolucion'];
			$this->EinRecepcionObservacion = $fila['EinRecepcionObservacion'];
			$this->EinClaveAlarma = $fila['EinClaveAlarma'];		
		
			$this->EinComprobanteCompraFecha = $fila['NEinComprobanteCompraFecha'];
			$this->EinComprobanteCompraNumero = $fila['EinComprobanteCompraNumero'];
			list($this->EinComprobanteCompraNumeroSerie,$this->EinComprobanteCompraNumeroNumero) = explode("-",$this->EinComprobanteCompraNumero);
			
			$this->EinCostoIngreso = $fila['EinCostoIngreso'];					
			$this->MonIdIngreso = $fila['MonIdIngreso'];
			$this->EinTipoCambioIngreso = $fila['EinTipoCambioIngreso']; 
			
			$this->EinObservado = $fila['EinObservado'];
			$this->EinObservadoMotivo = $fila['EinObservadoMotivo']; 

				
			$this->EinControlGuiaRemisionFecha = $fila['NEinControlGuiaRemisionFecha'];	
			$this->EinControlGuiaRemisionNumero = $fila['EinControlGuiaRemisionNumero'];	
			$this->EinControlEmpresaTransporte = $fila['EinControlEmpresaTransporte'];	
			$this->EinControlFechaRecepcion = $fila['NEinControlFechaRecepcion'];	
			$this->EinControlGuiaRemisionFechaOtro = $fila['NEinControlGuiaRemisionFechaOtro'];	
			$this->EinControlGuiaRemisionNumeroOtro = $fila['EinControlGuiaRemisionNumeroOtro'];	
					

			$this->EinPredictivoObservacion = $fila['EinPredictivoObservacion'];	
			$this->EinPredictivoFecha = $fila['NEinPredictivoFecha'];	
			
			
			
			$this->EinCancelado = $fila['EinCancelado'];					
			$this->EinEstado = $fila['EinEstado'];					
			$this->EinTiempoCreacion = $fila['NEinTiempoCreacion'];
			$this->EinTiempoModificacion = $fila['NEinTiempoModificacion']; 
			
			$this->VmaId = $fila['VmaId']; 
			$this->VmaNombre = $fila['VmaNombre']; 

			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre']; 
			
			$this->VtiId = $fila['VtiId']; 			
			$this->VtiNombre = $fila['VtiNombre']; 
			
			$this->VveId = $fila['VveId'];
			$this->VveNombre = $fila['VveNombre']; 
			
			$this->VehColor = $fila['VehColor']; 
	
			$this->TdoId = $fila['TdoId']; 
			$this->CliNombre = $fila['CliNombre']; 
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
			
			$this->OncNombre = $fila['OncNombre']; 
			
			$this->VprAno = $fila['VprAno']; 
			$this->VprMes = $fila['VprMes']; 
			
			$this->VprCodigo = $fila['VprCodigo']; 
			$this->VehiculoProformaMonId = $fila['VehiculoProformaMonId']; 
			$this->VprTipoCambio = $fila['VprTipoCambio']; 
			$this->VpdCosto = $fila['VpdCosto'];

$this->OvvFacturaSucursal = $fila['OvvFacturaSucursal'];
$this->OvvBoletaSucursal = $fila['OvvBoletaSucursal'];

			$this->OvvId = $fila['OvvId'];
			$this->OvvFecha = $fila['OvvFecha'];
			$this->OvvFactura = $fila['OvvFactura']; 
			$this->OvvFacturaFecha = $fila['OvvFacturaFecha'];
			$this->OvvBoleta = $fila['OvvBoleta']; 
			$this->OvvBoletaFecha = $fila['OvvBoletaFecha']; 

			$this->EinFechaVenta = $fila['EinFechaVenta']; 
			$this->EinVehiculoKilometraje = $fila['EinVehiculoKilometraje']; 
			$this->EinMantenimientoKilometraje = $fila['EinMantenimientoKilometraje']; 
			$this->EinCantidadMantenimientos = $fila['EinCantidadMantenimientos']; 
			$this->CliId = $fila['CliId']; 
	
			
			$this->VehCodigoIdentificador = $fila['VehCodigoIdentificador']; 
			$this->UmeId = $fila['UmeId']; 
			
			
	
			if($oCompleto){

				$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
				//MtdObtenerVehiculoIngresoClientes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VicId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL,$oCliente=NULL)
				$ResVehiculoIngreso =  $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL,NULL,"VicId","ASC",NULL,$this->EinId);
				$this->VehiculoIngresoCliente = $ResVehiculoIngreso['Datos'];

				///MtdObtenerVehiculoIngresoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VifId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL)
				$InsVehiculoIngresoFoto = new ClsVehiculoIngresoFoto();
				$ResVehiculoIngresoFoto = $InsVehiculoIngresoFoto->MtdObtenerVehiculoIngresoFotos(NULL,NULL,'VifId','ASC',NULL,$this->EinId);
				$this->VehiculoIngresoFoto = $ResVehiculoIngresoFoto['Datos'];

			}
			
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL,$oOrdenAno=NULL,$oOrdenMes=NULL,$oObservado=NULL,$oFacturaAno=NULL,$oFacturaMes=NULL) {

		// Inicializar variables
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$estado = '';
		$tipo = '';
		$cliente = '';
		$estadoVehicular = '';
		$vehiculoMarca = '';
		$vehiculoModelo = '';
		$vehiculoVersion = '';
		$anoModelo = '';
		$anoFabricacion = '';
		$color = '';
		$conProforma = '';
		$fecha = '';
		$fechainicio = '';
		$fechafin = '';
		$sucursal = '';
		$concesionario = '';
		$ordenAno = '';
		$ordenMes = '';
		$observado = '';
		$facturaAno = '';
		$facturaMes = '';

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
			$estado = ' AND ein.EinEstado = '.$oEstado.' ';
		}
		
		if(!empty($oTipo)){
			$tipo = ' AND ein.EinTipo = '.$oTipo.' ';
		}

		if(!empty($oCliente)){
			$cliente = ' AND ein.CliId = "'.$oCliente.'" ';
		}
		
		/*
		if(!empty($oEstadoVehicular)){
			$evehicular = ' AND ein.EinEstadoVehicular = "'.$oEstadoVehicular.'" ';
		}*/
		
		
		if(!empty($oEstadoVehicular)){

			$elementos = explode(",",$oEstadoVehicular);

			$i=1;
			$evehicular .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$evehicular .= '  (ein.EinEstadoVehicular = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$evehicular .= ' OR ';	
				}
			$i++;		
			}

			$evehicular .= ' ) 
			)
			';

		}
		
		
		
	//	if(!empty($oVehiculoMarca)){
//			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'" ';
//		}
//		
//		if(!empty($oVehiculoModelo)){
//			$vmodelo = ' AND ein.VmoId = "'.$oVehiculoModelo.'" ';
//		}
//		
//		if(!empty($oVehiculoVersion)){
//			$vversion = ' AND ein.VveId = "'.$oVehiculoVersion.'" ';
//		}


	if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'" ';
		}
		
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND ein.VveId = "'.$oVehiculoVersion.'" ';
		}
		
		
			
		if(!empty($oAnoModelo)){
			$amodelo = ' AND ein.EinAnoModelo = "'.$oAnoModelo.'" ';
		}

		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND ein.EinAnoFabricacion = "'.$oAnoFabricacion.'" ';
		}
		
		if(!empty($oColor)){
			$color = ' AND ein.EinColor LIKE "%'.$oColor.'%" ';
		}	
		

		if(!empty($oConProforma)){
			
			switch($oConProforma){
				
				case 1:
					$cproforma = ' AND
					EXISTS(
						SELECT 
						vpd.VpdId
						FROM tblvpdvehiculoproformadetalle vpd
						WHERE vpd.EinId = ein.EinId
					)
			 ';
				break;
				
				case 2:
					$cproforma = ' AND
						NOT EXISTS(
							SELECT 
							vpd.VpdId
							FROM tblvpdvehiculoproformadetalle vpd
							WHERE vpd.EinId = ein.EinId
						)
				 ';
				
				break;
				
				default:
				
				break;
			}
			
		} 
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ein.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(ein.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ein.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ein.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		
		
	//	if(!empty($oSucursal)){
//			$sucursal = ' AND ein.SucId = "'.$oSucursal.'" ';
//		}	
//		
		
		
		
		if(!empty($oSucursal)){

			$elementos = explode(",",$oSucursal);

			$i=1;
			$sucursal .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$sucursal .= '  (ein.SucId = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$sucursal .= ' OR ';	
				}
			$i++;		
			}

			$sucursal .= ' ) 
			)
			';

		}
		
		
		
		
		
		if(!empty($oConcesionario)){
			$concesionario = ' AND ein.OncId = "'.$oConcesionario.'" ';
		}	
		
		
		if(!empty($oOrdenAno)){
			
		
				
					$oano = ' AND
						 EXISTS(
							SELECT 
							ovv.OvvId
							FROM tblovvordenventavehiculo ovv
							WHERE ovv.EinId = ein.EinId
							AND ovv.OvvEstado <> 6
							AND YEAR(ovv.OvvFecha ) = '.$oOrdenAno.'
							LIMIT 1
						)
				 ';
				
			
			
		} 
		
			
		if(!empty($oOrdenMes)){
			
		
				
					$omes = ' AND
						 EXISTS(
							SELECT 
							ovv.OvvId
							FROM tblovvordenventavehiculo ovv
							WHERE ovv.EinId = ein.EinId
							AND ovv.OvvEstado <> 6
							AND MONTH(ovv.OvvFecha ) = '.$oOrdenMes.'
							LIMIT 1
						)
				 ';
				
			
			
		} 
		
		
		
		
		
		if(!empty($oFacturaAno)){
			
		
				
					$fano = ' AND
						YEAR(ein.EinFacturaFecha) = 
				 "'.$oFacturaAno.'"';
				
			
			
		} 
		
			
		if(!empty($oFacturaMes)){
			
		
				
					$fmes = ' AND
						MONTH(ein.EinFacturaFecha) = "'.$oFacturaMes.'"
				 ';
				
				
			
			
		} 
		
		
		
		if(!empty($oObservado)){
			$observado = ' AND ein.EinObservado = "'.$oObservado.'" ';
		}	
		
		

				 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ein.EinId,
				ein.SucId,
				
				ein.CliId,
				ein.OncId,
				
				ein.VehId,
				ein.EinVIN,
				DATE_FORMAT(ein.EinFechaVenta, "%d/%m/%Y") AS "NEinFechaVenta",

				ein.EinAnoFabricacion,
				ein.EinAnoModelo,
				ein.EinAnoVehiculo,				
				ein.EinNumeroMotor,				
				ein.EinTransmision,

				ein.EinDUA,
				ein.EinGuiaTransporte,
				ein.EinGuiaRemision,
				ein.EinPlaca,
				ein.EinPoliza,
				ein.EinZofra,
				ein.EinNacionalizado,
				ein.EinColor,
ein.EinColorInterno,
				
				ein.EinFoto,
				ein.EinFotoVIN,
		ein.EinFotoFrontal,
		ein.EinFotoCupon,
	
	
				ein.EinNotaPedido,
ein.EinNumeroProforma,

				ein.EinAnoProforma,
				ein.EinMesProforma,
				
				ein.PerId,		
				ein.EinArchivoDAM,
				ein.EinArchivoDAM2,
				ein.EinArchivoDAM3,
				
				DATE_FORMAT(ein.EinFechaSalidaDAM, "%d/%m/%Y") AS "NEinFechaSalidaDAM",
				DATE_FORMAT(ein.EinFechaRetornoDAM, "%d/%m/%Y") AS "NEinFechaRetornoDAM",
				ein.EinEstadoVehicular,
				ein.EinSolicitud,		
				DATE_FORMAT(ein.EinEstadoVehicularFechaSalida, "%d/%m/%Y") AS "NEinEstadoVehicularFechaSalida",
				DATE_FORMAT(ein.EinEstadoVehicularFechaLlegada, "%d/%m/%Y") AS "NEinEstadoVehicularFechaLlegada",		
				ein.EinNumeroViaje,
				ein.EinUbicacionReferencia,
				ein.EinManualPropietario,
				ein.EinManualGarantia,	
		
		
				ein.EinTipo,
				
				ein.EinKilometraje,
				ein.EinNombre,
				
				
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
				
				vve.VveCaracteristica1,
				vve.VveCaracteristica2,
				vve.VveCaracteristica3,
				vve.VveCaracteristica4,
				vve.VveCaracteristica5,
				vve.VveCaracteristica6,
				vve.VveCaracteristica7,
				vve.VveCaracteristica8,
				vve.VveCaracteristica9,
				vve.VveCaracteristica10,
				
				vve.VveCaracteristica11,
				vve.VveCaracteristica12,
				vve.VveCaracteristica13,
				vve.VveCaracteristica14,
				vve.VveCaracteristica15,
				vve.VveCaracteristica16,
				vve.VveCaracteristica17,
				vve.VveCaracteristica18,
				vve.VveCaracteristica19,
				vve.VveCaracteristica20,
				vve.VveFoto,
				
				ein.MonId,
				ein.EinTipoCambio,
				ein.EinDescuentoGerencia,
				
				DATE_FORMAT(ein.EinRecepcionFecha, "%d/%m/%Y") AS "NEinRecepcionFecha",
				ein.EinRecepcionZonaComprometida,
				ein.EinRecepcionRepuestoDetalle,
				ein.EinRecepcionSolucion,
				ein.EinRecepcionObservacion,
				ein.EinClaveAlarma,
				
				ein.EinComprobanteCompraNumero,
				DATE_FORMAT(ein.EinComprobanteCompraFecha, "%d/%m/%Y") AS "NEinComprobanteCompraFecha",
			
				DATEDIFF(DATE(NOW()),IFNULL(ein.EinFechaIngreso,NOW())) AS EinDiasinmovilizados,
				
				ein.EinNota,
				ein.EinDatoAdicional,
				DATE_FORMAT(ein.EinFechaUltimoInventario, "%d/%m/%Y") AS "NEinFechaUltimoInventario",
				
				ein.EinObservado,
				ein.EinObservadoMotivo,
				
				DATE_FORMAT(ein.EinControlGuiaRemisionFecha, "%d/%m/%Y") AS "NEinControlGuiaRemisionFecha",
				ein.EinControlGuiaRemisionNumero,
				ein.EinControlEmpresaTransporte,
				DATE_FORMAT(ein.EinControlFechaRecepcion, "%d/%m/%Y") AS "NEinControlFechaRecepcion",
				DATE_FORMAT(ein.EinControlGuiaRemisionFechaOtro, "%d/%m/%Y") AS "NEinControlGuiaRemisionFechaOtro",
				ein.EinControlGuiaRemisionNumeroOtro,

				ein.EinPredictivoObservacion,
				DATE_FORMAT(ein.EinPredictivoFecha, "%d/%m/%Y") AS "NEinPredictivoFecha",
		
		
				ein.EinCancelado,
				ein.EinEstado,
				DATE_FORMAT(ein.EinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEinTiempoCreacion",
                DATE_FORMAT(ein.EinTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEinTiempoModificacion",
				
				
					(
		
			SELECT 
			
			(fac.FtaId)
			
			FROM tblovvordenventavehiculo ovv
				LEFT JOIN tblfacfactura fac
				ON fac.OvvId = ovv.OvvId
					LEFT JOIN tblftafacturatalonario fta
					ON fac.FtaId = fta.FtaId
			WHERE ovv.EinId = ein.EinId
				AND fac.FacEstado <> 6
				AND ovv.OvvEstado <> 6
			LIMIT 1
		
		) AS FtaId,
		
		(
		
			SELECT 
			
			(fac.FacId)
			
			FROM tblovvordenventavehiculo ovv
				LEFT JOIN tblfacfactura fac
				ON fac.OvvId = ovv.OvvId
					LEFT JOIN tblftafacturatalonario fta
					ON fac.FtaId = fta.FtaId
			WHERE ovv.EinId = ein.EinId
				AND fac.FacEstado <> 6
				AND ovv.OvvEstado <> 6
			LIMIT 1
		
		) AS FacId,
		
		
		
		
		(
		
			SELECT 
				(bol.BolId)
			FROM tblovvordenventavehiculo ovv
				LEFT JOIN tblbolboleta bol
				ON bol.OvvId = ovv.OvvId
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
			WHERE ovv.EinId = ein.EinId
				AND bol.BolEstado <> 6
				AND ovv.OvvEstado <> 6
			LIMIT 1
		
		) AS BolId,
		
		
		
		
		(
		
			SELECT 
				(bol.BtaId)
			FROM tblovvordenventavehiculo ovv
				LEFT JOIN tblbolboleta bol
				ON bol.OvvId = ovv.OvvId
					LEFT JOIN tblbtaboletatalonario bta
					ON bol.BtaId = bta.BtaId
			WHERE ovv.EinId = ein.EinId
				AND bol.BolEstado <> 6
				AND ovv.OvvEstado <> 6
			LIMIT 1
		
		) AS BtaId,
		
		
				vmo.VmaId,
				vma.VmaNombre,

				vve.VmoId,
				vmo.VmoNombre,

				ein.VveId,
				vve.VveNombre,

				vmo.VtiId,
				vti.VtiNombre,

				veh.VehColor,
				veh.VehCodigoIdentificador,
				
				onc.OncNombre,
				
				vpr.VprAno,
				vpr.VprMes,
				vpr.VprCodigo,
				
				suc.SucNombre				

				FROM tbleinvehiculoingreso ein		
					
					LEFT JOIN tblvehvehiculo veh
					ON ein.VehId = veh.VehId
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvtivehiculotipo vti
								ON vmo.VtiId = vti.VtiId					
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									LEFT JOIN tbloncconcesionario onc
									ON ein.OncId = onc.OncId

										LEFT JOIN tblvpdvehiculoproformadetalle vpd
										ON vpd.EinId = ein.EinId
					
											LEFT JOIN tblvprvehiculoproforma vpr
											ON vpd.VprId = vpr.VprId
												LEFT JOIN tblsucsucursal suc
												ON ein.SucId = suc.SucId
				WHERE  1 = 1  '.$filtrar.$concesionario.$vtipo.$oano.$omes.$fano.$fmes.$estado.$sucursal .$tipo.$cliente.$evehicular.$vmarca.$vmodelo.$vversion.$amodelo.$afabricacion.$observado .$color.$cproforma.$fecha.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngreso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoIngreso = new $InsVehiculoIngreso();
					
					$VehiculoIngreso->EinId = $fila['EinId'];
					$VehiculoIngreso->SucId = $fila['SucId'];
					
					$VehiculoIngreso->CliId = $fila['CliId'];
					
					$VehiculoIngreso->VehId = $fila['VehId'];
					
					$VehiculoIngreso->EinVIN = (($fila['EinVIN']));
					$VehiculoIngreso->EinFechaVenta = (($fila['NEinFechaVenta']));
					
					$VehiculoIngreso->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$VehiculoIngreso->EinAnoModelo = $fila['EinAnoModelo'];					
					$VehiculoIngreso->EinAnoVehiculo = $fila['EinAnoVehiculo'];

					$VehiculoIngreso->EinNumeroMotor = $fila['EinNumeroMotor'];

					$VehiculoIngreso->EinTransmision = $fila['EinTransmision'];

					$VehiculoIngreso->EinDUA = $fila['EinDUA'];
					$VehiculoIngreso->EinGuiaTransporte = $fila['EinGuiaTransporte'];
					$VehiculoIngreso->EinGuiaRemision = $fila['EinGuiaRemision'];
					$VehiculoIngreso->EinPlaca = $fila['EinPlaca'];
					$VehiculoIngreso->EinPoliza = $fila['EinPoliza'];
					$VehiculoIngreso->EinZofra = $fila['EinZofra'];
					$VehiculoIngreso->EinNacionalizado = $fila['EinNacionalizado'];
					$VehiculoIngreso->EinColor = $fila['EinColor'];
					$VehiculoIngreso->EinColorInterno = $fila['EinColorInterno'];
					
                    $VehiculoIngreso->EinFoto = $fila['EinFoto'];	
					
					$VehiculoIngreso->EinFotoVIN = $fila['EinFotoVIN'];
					$VehiculoIngreso->EinFotoFrontal = $fila['EinFotoFrontal'];
					$VehiculoIngreso->EinFotoCupon = $fila['EinFotoCupon'];
	
	
					$VehiculoIngreso->EinNotaPedido = $fila['EinNotaPedido'];	
					$VehiculoIngreso->EinNumeroProforma = $fila['EinNumeroProforma'];	
					$VehiculoIngreso->EinAnoProforma = $fila['EinAnoProforma'];	
					$VehiculoIngreso->EinMesProforma = $fila['EinMesProforma'];	
					
					$VehiculoIngreso->EinArchivoDAM = $fila['EinArchivoDAM'];	
					$VehiculoIngreso->EinArchivoDAM2 = $fila['EinArchivoDAM2'];	
					$VehiculoIngreso->EinArchivoDAM3 = $fila['EinArchivoDAM3'];	
					
					$VehiculoIngreso->EinFechaSalidaDAM = $fila['NEinFechaSalidaDAM'];	
					$VehiculoIngreso->EinFechaRetornoDAM = $fila['NEinFechaRetornoDAM'];	
					$VehiculoIngreso->EinEstadoVehicular = $fila['EinEstadoVehicular'];	
					$VehiculoIngreso->EinSolicitud = $fila['EinSolicitud'];	
					$VehiculoIngreso->EinEstadoVehicularFechaSalida = $fila['NEinEstadoVehicularFechaSalida'];	
					$VehiculoIngreso->EinEstadoVehicularFechaLlegada = $fila['NEinEstadoVehicularFechaLlegada'];	
					$VehiculoIngreso->EinNumeroViaje = $fila['EinNumeroViaje'];	
					$VehiculoIngreso->EinUbicacionReferencia = $fila['EinUbicacionReferencia'];	
					$VehiculoIngreso->EinManualPropietario = $fila['EinManualPropietario'];	
					$VehiculoIngreso->EinManualGarantia = $fila['EinManualGarantia'];	
					

					$VehiculoIngreso->EinTipo = $fila['EinTipo'];
					
					$VehiculoIngreso->EinKilometraje = $fila['EinKilometraje'];	
					$VehiculoIngreso->EinNombre = $fila['EinNombre'];
					
				$VehiculoIngreso->EinCaracteristica1 = $fila['EinCaracteristica1'];	
				$VehiculoIngreso->EinCaracteristica2 = $fila['EinCaracteristica2'];	
				$VehiculoIngreso->EinCaracteristica3 = $fila['EinCaracteristica3'];	
				$VehiculoIngreso->EinCaracteristica4 = $fila['EinCaracteristica4'];	
				$VehiculoIngreso->EinCaracteristica5 = $fila['EinCaracteristica5'];	
				$VehiculoIngreso->EinCaracteristica6 = $fila['EinCaracteristica6'];	
				$VehiculoIngreso->EinCaracteristica7 = $fila['EinCaracteristica7'];	
				$VehiculoIngreso->EinCaracteristica8 = $fila['EinCaracteristica8'];	
				$VehiculoIngreso->EinCaracteristica9 = $fila['EinCaracteristica9'];	
				$VehiculoIngreso->EinCaracteristica10 = $fila['EinCaracteristica10'];	
				
				$VehiculoIngreso->EinCaracteristica11 = $fila['EinCaracteristica11'];	
				$VehiculoIngreso->EinCaracteristica12 = $fila['EinCaracteristica12'];	
				$VehiculoIngreso->EinCaracteristica13 = $fila['EinCaracteristica13'];	
				$VehiculoIngreso->EinCaracteristica14 = $fila['EinCaracteristica14'];	
				$VehiculoIngreso->EinCaracteristica15 = $fila['EinCaracteristica15'];	
				$VehiculoIngreso->EinCaracteristica16 = $fila['EinCaracteristica16'];	
				$VehiculoIngreso->EinCaracteristica17 = $fila['EinCaracteristica17'];	
				$VehiculoIngreso->EinCaracteristica18 = $fila['EinCaracteristica18'];	
				$VehiculoIngreso->EinCaracteristica19 = $fila['EinCaracteristica19'];	
				$VehiculoIngreso->EinCaracteristica20 = $fila['EinCaracteristica20'];	
				
					$VehiculoIngreso->VveCaracteristica1 = $fila['VveCaracteristica1'];	
					$VehiculoIngreso->VveCaracteristica2 = $fila['VveCaracteristica2'];	
					$VehiculoIngreso->VveCaracteristica3 = $fila['VveCaracteristica3'];	
					$VehiculoIngreso->VveCaracteristica4 = $fila['VveCaracteristica4'];	
					$VehiculoIngreso->VveCaracteristica5 = $fila['VveCaracteristica5'];	
					$VehiculoIngreso->VveCaracteristica6 = $fila['VveCaracteristica6'];	
					$VehiculoIngreso->VveCaracteristica7 = $fila['VveCaracteristica7'];	
					$VehiculoIngreso->VveCaracteristica8 = $fila['VveCaracteristica8'];	
					$VehiculoIngreso->VveCaracteristica9 = $fila['VveCaracteristica9'];	
					$VehiculoIngreso->VveCaracteristica10 = $fila['VveCaracteristica10'];	
					
					$VehiculoIngreso->VveCaracteristica11 = $fila['VveCaracteristica11'];	
					$VehiculoIngreso->VveCaracteristica12 = $fila['VveCaracteristica12'];	
					$VehiculoIngreso->VveCaracteristica13 = $fila['VveCaracteristica13'];	
					$VehiculoIngreso->VveCaracteristica14 = $fila['VveCaracteristica14'];	
					$VehiculoIngreso->VveCaracteristica15 = $fila['VveCaracteristica15'];	
					$VehiculoIngreso->VveCaracteristica16 = $fila['VveCaracteristica16'];	
					$VehiculoIngreso->VveCaracteristica17 = $fila['VveCaracteristica17'];	
					$VehiculoIngreso->VveCaracteristica18 = $fila['VveCaracteristica18'];	
					$VehiculoIngreso->VveCaracteristica19 = $fila['VveCaracteristica19'];	
					$VehiculoIngreso->VveCaracteristica20 = $fila['VveCaracteristica20'];	
					
					$VehiculoIngreso->VveFoto = $fila['VveFoto'];	
	
		
					$VehiculoIngreso->MonId = $fila['MonId'];
					$VehiculoIngreso->EinTipoCambio = $fila['EinTipoCambio'];
					$VehiculoIngreso->EinDescuentoGerencia = $fila['EinDescuentoGerencia'];
			
					$VehiculoIngreso->EinRecepcionFecha = $fila['NEinRecepcionFecha'];	
					$VehiculoIngreso->EinRecepcionZonaComprometida = $fila['EinRecepcionZonaComprometida'];	
					$VehiculoIngreso->EinRecepcionRepuestoDetalle = $fila['EinRecepcionRepuestoDetalle'];	
					$VehiculoIngreso->EinRecepcionSolucion = $fila['EinRecepcionSolucion'];	
					$VehiculoIngreso->EinRecepcionObservacion = $fila['EinRecepcionObservacion'];	
					$VehiculoIngreso->EinClaveAlarma = $fila['EinClaveAlarma'];	
				
				
					$VehiculoIngreso->EinComprobanteCompraNumero = $fila['EinComprobanteCompraNumero'];	
					$VehiculoIngreso->EinComprobanteCompraFecha = $fila['NEinComprobanteCompraFecha'];	
				
					
					$VehiculoIngreso->EinNota = $fila['EinNota'];	
					$VehiculoIngreso->EinDatoAdicional = $fila['EinDatoAdicional'];	
					$VehiculoIngreso->EinFechaUltimoInventario = $fila['NEinFechaUltimoInventario'];	
					
					$VehiculoIngreso->EinObservado = $fila['EinObservado'];	
					$VehiculoIngreso->EinObservadoMotivo = $fila['EinObservadoMotivo'];	
				
					$VehiculoIngreso->EinControlGuiaRemisionFecha = $fila['NEinControlGuiaRemisionFecha'];	
					$VehiculoIngreso->EinControlGuiaRemisionNumero = $fila['EinControlGuiaRemisionNumero'];	
					$VehiculoIngreso->EinControlEmpresaTransporte = $fila['EinControlEmpresaTransporte'];	
					$VehiculoIngreso->EinControlFechaRecepcion = $fila['NEinControlFechaRecepcion'];	
					$VehiculoIngreso->EinControlGuiaRemisionFechaOtro = $fila['NEinControlGuiaRemisionFechaOtro'];	
					$VehiculoIngreso->EinControlGuiaRemisionNumeroOtro = $fila['EinControlGuiaRemisionNumeroOtro'];	
			
					$VehiculoIngreso->EinPredictivoObservacion = $fila['EinPredictivoObservacion'];	
					$VehiculoIngreso->EinPredictivoFecha = $fila['NEinPredictivoFecha'];	
			
					$VehiculoIngreso->EinCancelado = $fila['EinCancelado'];	
					$VehiculoIngreso->EinEstado = $fila['EinEstado'];	
                    $VehiculoIngreso->EinTiempoCreacion = $fila['NEinTiempoCreacion'];
                    $VehiculoIngreso->EinTiempoModificacion = $fila['NEinTiempoModificacion'];
					
					$VehiculoIngreso->FacId = $fila['FacId'];
					$VehiculoIngreso->FtaId = $fila['FtaId'];
					$VehiculoIngreso->BolId = $fila['BolId'];
					$VehiculoIngreso->BtaId = $fila['BtaId'];
					
					
					$VehiculoIngreso->VmaId = $fila['VmaId'];
					$VehiculoIngreso->VmaNombre = $fila['VmaNombre'];

					$VehiculoIngreso->VmoId = $fila['VmoId'];
					$VehiculoIngreso->VmoNombre = $fila['VmoNombre'];

					$VehiculoIngreso->VveId = $fila['VveId'];
					$VehiculoIngreso->VveNombre = $fila['VveNombre'];

					$VehiculoIngreso->VtiId = $fila['VtiId'];
					$VehiculoIngreso->VtiNombre = $fila['VtiNombre'];

					$VehiculoIngreso->VehColor = $fila['VehColor'];
					$VehiculoIngreso->VehCodigoIdentificador = $fila['VehCodigoIdentificador'];
					
					$VehiculoIngreso->OncNombre = $fila['OncNombre'];
					
					$VehiculoIngreso->VprAno = $fila['VprAno'];
					$VehiculoIngreso->VprMes = $fila['VprMes'];
					$VehiculoIngreso->VprCodigo = $fila['VprCodigo'];
					
					$VehiculoIngreso->EinDiasinmovilizados = $fila['EinDiasinmovilizados'];
					
					$VehiculoIngreso->SucNombre = $fila['SucNombre'];
					
					
					switch($VehiculoIngreso->EinEstado){
						
						case 1:
							$VehiculoIngreso->EinEstadoDescripcion = "Activo";
						break;
						
						case 2:
							$VehiculoIngreso->EinEstadoDescripcion = "Inactivo";
						break;
					}

					
                    $VehiculoIngreso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
    public function MtdObtenerVehiculoIngresosValor($oFuncion="SUM",$oParametro="EinId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oCliente=NULL,$oEstadoVehicular=NULL,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oColor=NULL,$oConProforma=NULL,$oFecha="EinFechaRecepcion",$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oConcesionario=NULL) {

		  if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
			$estado = ' AND ein.EinEstado = '.$oEstado.' ';
		}
		
		if(!empty($oTipo)){
			$tipo = ' AND ein.EinTipo = '.$oTipo.' ';
		}

		if(!empty($oCliente)){
			$cliente = ' AND ein.CliId = "'.$oCliente.'" ';
		}
		
		/*
		if(!empty($oEstadoVehicular)){
			$evehicular = ' AND ein.EinEstadoVehicular = "'.$oEstadoVehicular.'" ';
		}*/
		
		
		if(!empty($oEstadoVehicular)){

			$elementos = explode(",",$oEstadoVehicular);

			$i=1;
			$evehicular .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$evehicular .= '  (ein.EinEstadoVehicular = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$evehicular .= ' OR ';	
				}
			$i++;		
			}

			$evehicular .= ' ) 
			)
			';

		}
		
		
		
	//	if(!empty($oVehiculoMarca)){
//			$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'" ';
//		}
//		
//		if(!empty($oVehiculoModelo)){
//			$vmodelo = ' AND ein.VmoId = "'.$oVehiculoModelo.'" ';
//		}
//		
//		if(!empty($oVehiculoVersion)){
//			$vversion = ' AND ein.VveId = "'.$oVehiculoVersion.'" ';
//		}


	if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'" ';
		}
		
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND ein.VveId = "'.$oVehiculoVersion.'" ';
		}
		
		
			
		if(!empty($oAnoModelo)){
			$amodelo = ' AND ein.EinAnoModelo = "'.$oAnoModelo.'" ';
		}

		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND ein.EinAnoFabricacion = "'.$oAnoFabricacion.'" ';
		}
		
		if(!empty($oColor)){
			$color = ' AND ein.EinColor LIKE "%'.$oColor.'%" ';
		}	
		

		if(!empty($oConProforma)){
			
			switch($oConProforma){
				
				case 1:
					$cproforma = ' AND
					EXISTS(
						SELECT 
						vpd.VpdId
						FROM tblvpdvehiculoproformadetalle vpd
						WHERE vpd.EinId = ein.EinId
					)
			 ';
				break;
				
				case 2:
					$cproforma = ' AND
						NOT EXISTS(
							SELECT 
							vpd.VpdId
							FROM tblvpdvehiculoproformadetalle vpd
							WHERE vpd.EinId = ein.EinId
						)
				 ';
				
				break;
				
				default:
				
				break;
			}
			
		} 
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ein.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(ein.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ein.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ein.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ein.SucId = "'.$oSucursal.'" ';
		}	
		
		
		if(!empty($oConcesionario)){
			$concesionario = ' AND ein.OncId = "'.$oConcesionario.'" ';
		}	
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(ein.'.$oFecha.') ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(ein.'.$oFecha.') ="'.($oAno).'"';
		}
		
		
		
			 $sql = 'SELECT
				'.$funcion.' AS "RESULTADO" 

				FROM tbleinvehiculoingreso ein		
					
					LEFT JOIN tblvehvehiculo veh
					ON ein.VehId = veh.VehId
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvtivehiculotipo vti
								ON vmo.VtiId = vti.VtiId					
									LEFT JOIN tblvmavehiculomarca vma
									ON vmo.VmaId = vma.VmaId
									LEFT JOIN tbloncconcesionario onc
									ON ein.OncId = onc.OncId

										LEFT JOIN tblvpdvehiculoproformadetalle vpd
										ON vpd.EinId = ein.EinId
					
											LEFT JOIN tblvprvehiculoproforma vpr
											ON vpd.VprId = vpr.VprId
												LEFT JOIN tblsucsucursal suc
												ON ein.SucId = suc.SucId
					
						
				WHERE  1 = 1  '.$mes.$ano.$filtrar.$concesionario.$vtipo.$estado.$sucursal .$tipo.$cliente.$evehicular.$vmarca.$vmodelo.$vversion.$amodelo.$afabricacion.$color.$cproforma.$fecha.$orden.$paginacion;
					
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];							
		}
		
		
	//Accion eliminar	 
	
//	public function MtdEliminarVehiculoIngreso($oElementos) {
//		
//		$elementos = explode("#",$oElementos);
//		
//			$i=1;
//			foreach($elementos as $elemento){
//				if(!empty($elemento)){
//				
//					if($i==count($elementos)){						
//						$eliminar .= '  (EinId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (EinId = "'.($elemento).'")  OR';	
//					}	
//				}
//			$i++;
//	
//			}
//		
//			$sql = 'DELETE FROM tbleinvehiculoingreso WHERE '.$eliminar;			
//		
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}							
//	}
//	
	
				
	//Accion eliminar	
	public function MtdEliminarVehiculoIngreso($oElementos) {
		
		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				if(!$error) {
					
					$sql = 'DELETE FROM tbleinvehiculoingreso WHERE  (EinId = "'.($elemento).'" ) ';
							
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{

						$this->MtdAuditarVehiculoIngreso(3,"Se elimino el vehiculo",$aux);			
								
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
	public function MtdEditarEstadoVehicularVehiculoIngreso($oElementos,$oEstado) {
		
		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				if(!$error) {
					
					$sql = 'UPDATE tbleinvehiculoingreso SET EinEstadoVehicular = "'.$oEstado.'"WHERE  (EinId = "'.($elemento).'" ) ';
							
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{

						$this->MtdAuditarVehiculoIngreso(3,"Se actualizo el estado del vehiculo",$aux);			
								
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
	public function MtdEditarObservadoVehiculoIngreso($oElementos,$oObservado,$oMotivo=NULL) {
		
		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;
		
		$elementos = explode("#",$oElementos);

		$i=1;
		foreach($elementos as $elemento){
			
			if(!empty($elemento)){
				
				if(!$error) {
					
					$sql = 'UPDATE tbleinvehiculoingreso 
					SET EinObservado = "'.$oObservado.'" ,
					EinObservadoMotivo = "'.$oMotivo.'"
					WHERE  (EinId = "'.($elemento).'" ) ';
							
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
					if(!$resultado) {						
						$error = true;
					}else{

						$this->MtdAuditarVehiculoIngreso(3,"Se actualizo el estado de observado del vehiculo",$aux);			
								
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
	
	
	

		public function MtdRegistrarVehiculoIngresoDeCotizacionProducto() {
			
			$error = false;
					
			$this->MtdGenerarVehiculoIngresoId();
			
			$sql = 'INSERT INTO tbleinvehiculoingreso (
			EinId,
			SucId,
			
			VprId,
			
			CliId,			
			OncId,			
			VehId,
						
			VmaId,
			VmoId,
			VveId,
			VtiId,
			
			EinVIN,
			EinFechaVenta,
			EinAnoFabricacion,
			EinAnoModelo,
			EinAnoVehiculo,
			EinNumeroMotor,
		
			EinTransmision,
			
			EinDUA,
			EinGuiaTransporte,
			EinGuiaRemision,
			EinPlaca,
			EinPoliza,
			EinZofra,
			EinNacionalizado,
			EinColor,
			
			EinFoto,
			
			EinNumeroProforma,
			EinAnoProforma,
			EinMesProforma,
			
			PerId,		
			
			EinArchivoDAM,
			EinArchivoDAM2,
			EinArchivoDAM3,
			
			EinFechaSalidaDAM,
			EinFechaRetornoDAM,
			EinEstadoVehicular,
			EinSolicitud,		
			EinEstadoVehicularFechaSalida,
			EinEstadoVehicularFechaLlegada,
			EinNumeroViaje,
			EinUbicacionReferencia,
			EinManualPropietario,
			EinManualGarantia,
				
			EinTipo,
			
			EinKilometraje,
			EinNombre,
			
			MonId,
			EinTipoCambio,
			EinDescuentoGerencia,
			
			
			EinRecepcionFecha,
			EinRecepcionZonaComprometida,
			EinRecepcionRepuestoDetalle,
			EinRecepcionSolucion,
			EinRecepcionObservacion,
			
			EinClaveAlarma,
			
			EinCancelado,
			EinEstado,
			EinTiempoCreacion,
			EinTiempoModificacion
			) 
			VALUES (
			"'.($this->EinId).'", 
			"'.($this->SucId).'", 
			
			'.(empty($this->VprId)?'NULL,':'"'.$this->VprId.'",').'	
			'.(empty($this->CliId)?'NULL,':'"'.$this->CliId.'",').'	
			NULL,
			
			NULL, 
			
			NULL, 
			NULL, 
			NULL, 
			NULL, 
			
			"'.($this->EinVIN).'", 
			NULL, 
			"'.($this->EinAnoFabricacion).'", 
			"'.($this->EinAnoModelo).'", 
			"'.($this->EinAnoVehiculo).'", 
			"", 
			
			"",
			
			"",			
			"",
			"",			
			"'.($this->EinPlaca).'",
			"",
			2,			
			2,
			"",
			
			"",
			
			"",
			
			"",
			"",
			
			NULL,
			
			"",
			"",
			"",
			NULL,
			NULL,
				
			"",
			"",
			
			NULL,
			NULL,
			
			"",
			"",
			2,
			2,
			
			3,	
			
			0,			
			"'.($this->EinNombre).'", 
			
			NULL,
			NULL,
			0,		
			
			NULL,
			"",
			"",
			"",
			"",
			
			"",
			2,
			1,
			"'.($this->EinTiempoCreacion).'", 
			"'.($this->EinTiempoModificacion).'");';

			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

			if(!$resultado) {							
				$error = true;
			} 

			if($error) {
				$this->InsMysql->MtdTransaccionDeshacer();								
				return false;
			}else {
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}			
			
	}
	
	
		public function MtdVerificarExisteVehiculoIngreso($oCampo,$oDato){
			
			$Respuesta =   NULL;
	
			 $sql = 'SELECT 
			EinId
			FROM tbleinvehiculoingreso
			WHERE '.$oCampo.' = "'.$oDato.'" LIMIT 1;';
	
			$resultado = $this->InsMysql->MtdConsultar($sql);
	
			if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
				
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);
				//$this->EinId = $fila['EinId'];
				$Respuesta = $fila['EinId'];
	
			}
			
			return $Respuesta;
	
		}
	
	public function MtdRegistrarVehiculoIngreso() {
		
		global $Resultado;
		
		$error = false;
		
		$VehiculoIngresoId = $this->MtdVerificarExisteVehiculoIngreso("EinVIN",$this->EinVIN);

		if(!empty($VehiculoIngresoId)){
			$error = true;
			$Resultado.='#ERR_EIN_601';
		}

		$this->MtdGenerarVehiculoIngresoId();

			$this->InsMysql->MtdTransaccionIniciar();

			//'.(empty($this->CliId)?'NULL,':'"'.$this->CliId.'",').'	
			$sql = 'INSERT INTO tbleinvehiculoingreso (
			EinId,
			SucId,
			
			VprId,
			
			CliId,
			
			OncId,
			
			VehId,
			
			VmaId,
			VmoId,
			VveId,
			VtiId,
			
			EinVIN,
			EinFechaVenta,
			EinAnoFabricacion,
			EinAnoModelo,
			EinAnoVehiculo,
			EinNumeroMotor,
		
			EinTransmision,
			
			EinDUA,
			EinGuiaTransporte,
			EinGuiaRemision,
			EinPlaca,
			EinPoliza,
			EinZofra,
			EinNacionalizado,
			EinColor,
			EinColorInterno,
			
			EinFoto,
			
			EinNotaPedido,
			EinNumeroProforma,
			EinAnoProforma,
			EinMesProforma,
			
			PerId,		
			
			EinArchivoDAM,
			EinArchivoDAM2,
			EinArchivoDAM3,
			
			EinFechaSalidaDAM,
			EinFechaRetornoDAM,
			EinEstadoVehicular,
			EinSolicitud,		
			EinEstadoVehicularFechaSalida,
			EinEstadoVehicularFechaLlegada,
			EinNumeroViaje,
			EinUbicacionReferencia,
			EinManualPropietario,
			EinManualGarantia,
			
			EinTipo,
			
			EinKilometraje,
			EinNombre,
				
			MonId,
			EinTipoCambio,
			EinDescuentoGerencia,
			
			EinRecepcionFecha,
			EinRecepcionZonaComprometida,
			EinRecepcionRepuestoDetalle,
			EinRecepcionSolucion,
			EinRecepcionObservacion,
			
			EinCaracteristica1,
			EinCaracteristica2,
			EinCaracteristica3,
			EinCaracteristica4,
			EinCaracteristica5,
			EinCaracteristica6,
			EinCaracteristica7,
			EinCaracteristica8,
			EinCaracteristica9,
			EinCaracteristica10,
			EinCaracteristica11,
			EinCaracteristica12,
			EinCaracteristica13,
			EinCaracteristica14,
			EinCaracteristica15,
			EinCaracteristica16,
			EinCaracteristica17,
			EinCaracteristica18,
			EinCaracteristica19,
			EinCaracteristica20,
			
			EinComprobanteCompraNumero,
			EinComprobanteCompraFecha,
			
			EinClaveAlarma,
			EinCodigoPedido,
			
			EinFacturaNumero,
			EinFacturaValor,
			EinFacturaFecha,
			
			EinProveedor,
			
			EinCancelado,
			EinEstado,			
			EinTiempoCreacion,
			EinTiempoModificacion
			) 
			VALUES (
			"'.($this->EinId).'", 
			"'.($this->SucId).'", 
			
			'.(empty($this->VprId)?'NULL,':'"'.$this->VprId.'",').'	
			'.(empty($this->CliId)?'NULL,':'"'.$this->CliId.'",').'	
			'.(empty($this->OncId)?'NULL,':'"'.$this->OncId.'",').'	
			
			'.(empty($this->VehId)?'NULL,':'"'.$this->VehId.'",').'	
		
			
			"'.($this->VmaId).'", 
			"'.($this->VmoId).'", 
			"'.($this->VveId).'", 
			"'.($this->VtiId).'", 
			
			"'.($this->EinVIN).'", 
			'.(empty($this->EinFechaVenta)?'NULL,':'"'.$this->EinFechaVenta.'",').'	
			"'.($this->EinAnoFabricacion).'", 
			"'.($this->EinAnoModelo).'", 
			"'.($this->EinAnoVehiculo).'", 
			"'.($this->EinNumeroMotor).'", 
			
			"'.($this->EinTransmision).'",			
			
			"'.($this->EinDUA).'",			
			"'.($this->EinGuiaTransporte).'",
			"'.($this->EinGuiaRemision).'",			
			"'.($this->EinPlaca).'",
			"'.($this->EinPoliza).'",
			"'.($this->EinZofra).'",			
			"'.($this->EinNacionalizado).'",
			"'.($this->EinColor).'",
			"'.($this->EinColorInterno).'",
			
			"'.($this->EinFoto).'",
		
			"'.($this->EinNotaPedido).'",
			"'.($this->EinNumeroProforma).'",
			"'.($this->EinAnoProforma).'",
			"'.($this->EinMesProforma).'",
			
			'.(empty($this->PerId)?'NULL,':'"'.$this->PerId.'",').'	
			
			"'.($this->EinArchivoDAM).'",
			"'.($this->EinArchivoDAM2).'",
			"'.($this->EinArchivoDAM3).'",
			
			'.(empty($this->EinFechaSalidaDAM)?'NULL,':'"'.$this->EinFechaSalidaDAM.'",').'	
			'.(empty($this->EinFechaRetornoDAM)?'NULL,':'"'.$this->EinFechaRetornoDAM.'",').'	
				
			"'.($this->EinEstadoVehicular).'",
			"'.($this->EinSolicitud).'",
			
			'.(empty($this->EinEstadoVehicularFechaSalida)?'NULL,':'"'.$this->EinEstadoVehicularFechaSalida.'",').'	
			'.(empty($this->EinEstadoVehicularFechaLlegada)?'NULL,':'"'.$this->EinEstadoVehicularFechaLlegada.'",').'	
			
			"'.($this->EinNumeroViaje).'",
			"'.($this->EinUbicacionReferencia).'",
			'.($this->EinManualPropietario).',
			'.($this->EinManualGarantia).',
			
			'.($this->EinTipo).',		
			
			0,
			"'.($this->EinNombre).'",
			
			'.(empty($this->MonId)?'NULL,':'"'.$this->MonId.'",').'	
			'.(empty($this->EinTipoCambio)?'NULL,':'"'.$this->EinTipoCambio.'",').'	
			'.($this->EinDescuentoGerencia).',
			
			'.(empty($this->EinRecepcionFecha)?'NULL,':'"'.$this->EinRecepcionFecha.'",').'	
			"'.($this->EinRecepcionZonaComprometida).'",
			"'.($this->EinRecepcionRepuestoDetalle).'",
			"'.($this->EinRecepcionSolucion).'",
			"'.($this->EinRecepcionObservacion).'",
			
			"'.($this->EinCaracteristica1).'", 
			"'.($this->EinCaracteristica2).'", 
			"'.($this->EinCaracteristica3).'",
			"'.($this->EinCaracteristica4).'",
			"'.($this->EinCaracteristica5).'",
			"'.($this->EinCaracteristica6).'",
			"'.($this->EinCaracteristica7).'",
			"'.($this->EinCaracteristica8).'",
			"'.($this->EinCaracteristica9).'",
			"'.($this->EinCaracteristica10).'",
			
			"'.($this->EinCaracteristica11).'",
			"'.($this->EinCaracteristica12).'",
			"'.($this->EinCaracteristica13).'",
			"'.($this->EinCaracteristica14).'",
			"'.($this->EinCaracteristica15).'",
			"'.($this->EinCaracteristica16).'",
			"'.($this->EinCaracteristica17).'",
			"'.($this->EinCaracteristica18).'",
			"'.($this->EinCaracteristica19).'", 
			"'.($this->EinCaracteristica20).'",
			
			"'.($this->EinComprobanteCompraNumero).'", 
			"'.($this->EinComprobanteCompraFecha).'", 
		
			"'.($this->EinClaveAlarma).'", 
			"'.($this->EinCodigoPedido).'", 
			
			"'.($this->EinFacturaNumero).'", 
			"'.($this->EinFacturaValor).'", 
			'.(empty($this->EinFacturaFecha)?'NULL,':'"'.$this->EinFacturaFecha.'",').'	
			
			"'.($this->EinProveedor).'", 
			
			'.($this->EinCancelado).',
			'.($this->EinEstado).',
			"'.($this->EinTiempoCreacion).'", 
			"'.($this->EinTiempoModificacion).'");';

			
			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			
			if(!$error){			
			
				if (!empty($this->VehiculoIngresoCliente)){		
						
					$validar = 0;				
					
					
					foreach ($this->VehiculoIngresoCliente as $DatVehiculoIngresoCliente){
						
						$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();		
						$InsVehiculoIngresoCliente->EinId = $this->EinId;
						$InsVehiculoIngresoCliente->CliId = $DatVehiculoIngresoCliente->CliId;
						$InsVehiculoIngresoCliente->VicFecha = $DatVehiculoIngresoCliente->VicFecha;
						$InsVehiculoIngresoCliente->VicEstado = $DatVehiculoIngresoCliente->VicEstado;								
						$InsVehiculoIngresoCliente->VicTiempoCreacion = $DatVehiculoIngresoCliente->VicTiempoCreacion;
						$InsVehiculoIngresoCliente->VicTiempoModificacion = $DatVehiculoIngresoCliente->VicTiempoModificacion;						
						$InsVehiculoIngresoCliente->VicEliminado = $DatVehiculoIngresoCliente->VicEliminado;
						
						if($InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente()){
							$validar++;	
						}else{
							$Resultado.='#ERR_EIN_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoIngresoCliente) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			
			
			if(!$error){			
			
				if (!empty($this->VehiculoIngresoFoto)){		
						
					$validar = 0;				
					
					
					foreach ($this->VehiculoIngresoFoto as $DatVehiculoIngresoFoto){
						
						$InsVehiculoIngresoFoto = new ClsVehiculoIngresoFoto();		
						$InsVehiculoIngresoFoto->EinId = $this->EinId;
						$InsVehiculoIngresoFoto->VifArchivo = $DatVehiculoIngresoFoto->VifArchivo;								
						$InsVehiculoIngresoFoto->VifEstado = $DatVehiculoIngresoFoto->VifEstado;								
						$InsVehiculoIngresoFoto->VifTiempoCreacion = $DatVehiculoIngresoFoto->VifTiempoCreacion;
						$InsVehiculoIngresoFoto->VifTiempoModificacion = $DatVehiculoIngresoFoto->VifTiempoModificacion;						
						$InsVehiculoIngresoFoto->VifEliminado = $DatVehiculoIngresoFoto->VifEliminado;
						
						if($InsVehiculoIngresoFoto->MtdRegistrarVehiculoIngresoFoto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_EIN_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoIngresoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			

			if(!$error and $this->Predeterminar==true){
				
				// MtdEditarVehiculoVersionDato($oCampo,$oDato,$oId) {
				if(!empty($this->VveCaracteristica1) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica1",$this->VveCaracteristica1,$this->VveId);

				}

				if(!empty($this->VveCaracteristica2) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica2",$this->VveCaracteristica2,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica3) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica3",$this->VveCaracteristica3,$this->VveId);

				}							
				
				if(!empty($this->VveCaracteristica4) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica4",$this->VveCaracteristica4,$this->VveId);

				}				
				
				if(!empty($this->VveCaracteristica5) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica5",$this->VveCaracteristica5,$this->VveId);

				}					
				
				if(!empty($this->VveCaracteristica6) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica6",$this->VveCaracteristica6,$this->VveId);

				}	
				
				if(!empty($this->VveCaracteristica7) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica7",$this->VveCaracteristica7,$this->VveId);

				}					
								
				if(!empty($this->VveCaracteristica8) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica8",$this->VveCaracteristica8,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica9) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica9",$this->VveCaracteristica9,$this->VveId);

				}				
					
				if(!empty($this->VveCaracteristica10) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica10",$this->VveCaracteristica10,$this->VveId);

				}				
				



				if(!empty($this->VveCaracteristica11) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica11",$this->VveCaracteristica11,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica12) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica12",$this->VveCaracteristica12,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica13) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica13",$this->VveCaracteristica13,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica14) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica14",$this->VveCaracteristica14,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica15) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica15",$this->VveCaracteristica15,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica16) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica16",$this->VveCaracteristica16,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica17) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica17",$this->VveCaracteristica17,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica18) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica18",$this->VveCaracteristica18,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica19) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica19",$this->VveCaracteristica19,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica20) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica20",$this->VveCaracteristica20,$this->VveId);

				}
					
			}

			if($error) {					
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
			
				$this->MtdAuditarVehiculoIngreso(1,"Se registro el vehiculo.",$this);		
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	
	/*
	public function MtdRegistrarVehiculoIngresoDeVehiculoProforma($oTransaccion=true) {
		
		global $Resultado;

		$error = false;

		$VehiculoIngresoId = $this->MtdVerificarExisteVehiculoIngreso("EinVIN",$this->EinVIN);

		if(!empty($VehiculoIngresoId)){
			$error = true;
			$Resultado.='#ERR_EIN_601';
		}

		$this->MtdGenerarVehiculoIngresoId();
			
			if($oTransaccion){
				
				$this->InsMysql->MtdTransaccionIniciar();
				
			}
			

			$sql = 'INSERT INTO tbleinvehiculoingreso (
			EinId,
			SucId,
			
			VprId,
			
			CliId,
			
			OncId,
			
			VehId,
			
			VmaId,
			VmoId,
			VveId,
			VtiId,
			
			EinVIN,
			EinFechaVenta,
			EinAnoFabricacion,
			EinAnoModelo,
			EinAnoVehiculo,
			EinNumeroMotor,
		
			EinTransmision,
			
			EinDUA,
			EinGuiaTransporte,
			EinGuiaRemision,
			EinPlaca,
			EinPoliza,
			EinZofra,
			EinNacionalizado,
			EinColor,
			EinColorInterno,
			
			EinFoto,
			
			EinNumeroProforma,
			EinAnoProforma,
			EinMesProforma,
			
			PerId,		
			
			EinArchivoDAM,
			EinArchivoDAM2,
			EinArchivoDAM3,
			
			EinFechaSalidaDAM,
			EinFechaRetornoDAM,
			EinEstadoVehicular,
			EinSolicitud,		
			EinEstadoVehicularFechaSalida,
			EinEstadoVehicularFechaLlegada,
			EinNumeroViaje,
			EinUbicacionReferencia,
			EinManualPropietario,
			EinManualGarantia,
			
			EinTipo,
			
			EinKilometraje,
			EinNombre,
			
			MonId,
			EinTipoCambio,
			EinDescuentoGerencia,
			
						
			EinRecepcionFecha,
			EinRecepcionZonaComprometida,
			EinRecepcionRepuestoDetalle,
			EinRecepcionSolucion,
			EinRecepcionObservacion,
			
			EinCaracteristica1,
			EinCaracteristica2,
			EinCaracteristica3,
			EinCaracteristica4,
			EinCaracteristica5,
			EinCaracteristica6,
			EinCaracteristica7,
			EinCaracteristica8,
			EinCaracteristica9,
			EinCaracteristica10,
			EinCaracteristica11,
			EinCaracteristica12,
			EinCaracteristica13,
			EinCaracteristica14,
			EinCaracteristica15,
			EinCaracteristica16,
			EinCaracteristica17,
			EinCaracteristica18,
			EinCaracteristica19,
			EinCaracteristica20,
			
			EinCodigoPedido,
			
			EinEstado,
			EinTiempoCreacion,
			EinTiempoModificacion
			) 
			VALUES (
			"'.($this->EinId).'", 
			"'.($this->SucId).'",
			
			NULL,
			NULL,
			'.(empty($this->OncId)?'NULL,':'"'.$this->OncId.'",').'	
			
			NULL,
			
			
			'.(empty($this->VmaId)?'NULL,':'"'.$this->VmaId.'",').'	
			'.(empty($this->VmoId)?'NULL,':'"'.$this->VmoId.'",').'	
			'.(empty($this->VveId)?'NULL,':'"'.$this->VveId.'",').'	
			
			"'.($this->VtiId).'", 
			
			"'.($this->EinVIN).'", 
			NULL,
			"'.($this->EinAnoFabricacion).'", 
			"'.($this->EinAnoModelo).'", 
			0, 
			"'.($this->EinNumeroMotor).'", 
			
			"",			
			
			"",			
			"",		
			"",		
			"",		
			"",		
			2,		
			1,		
			"'.($this->EinColor).'",
			"'.($this->EinColorInterno).'",
			"",		
						
			"",		
			0,
			0,
			
			NULL,
			
			"",
			"",
			"",
			
			NULL,
			NULL,
				
			"STOCK",
			"",
			
			NULL,
			NULL,	
			
			"",
			"",
			2,
			2,
			
			6,		
			
			0,
			"'.($this->EinNombre).'", 
			
			NULL,
			NULL,
			0,
			
			NULL,
			"",
			"",
			"",
			"",
			
			"'.($this->EinCaracteristica1).'", 
			"'.($this->EinCaracteristica2).'", 
			"'.($this->EinCaracteristica3).'",
			"'.($this->EinCaracteristica4).'",
			"'.($this->EinCaracteristica5).'",
			"'.($this->EinCaracteristica6).'",
			"'.($this->EinCaracteristica7).'",
			"'.($this->EinCaracteristica8).'",
			"'.($this->EinCaracteristica9).'",
			"'.($this->EinCaracteristica10).'",
			
			"'.($this->EinCaracteristica11).'",
			"'.($this->EinCaracteristica12).'",
			"'.($this->EinCaracteristica13).'",
			"'.($this->EinCaracteristica14).'",
			"'.($this->EinCaracteristica15).'",
			"'.($this->EinCaracteristica16).'",
			"'.($this->EinCaracteristica17).'",
			"'.($this->EinCaracteristica18).'",
			"'.($this->EinCaracteristica19).'", 
			"'.($this->EinCaracteristica20).'",
			
			
			"'.($this->EinCodigoPedido).'", 
			1,
			"'.($this->EinTiempoCreacion).'", 
			"'.($this->EinTiempoModificacion).'");';
		
			if(!$error){
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
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
				
				$this->MtdAuditarVehiculoIngreso(1,"Se registro el vehiculo desde proforma.",$this);		
				return true;
			}			
			
	}*/
	
	
	
	public function MtdEditarVehiculoIngreso() {
		
			$error = false;
		
			$this->InsMysql->MtdTransaccionIniciar();
					//'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
						
			$sql = 'UPDATE tbleinvehiculoingreso SET 
			SucId = "'.($this->SucId).'",
			
			'.(empty($this->VprId)?'VprId = NULL, ':'VprId = "'.$this->VprId.'",').'
			'.(empty($this->OncId)?'OncId = NULL, ':'OncId = "'.$this->OncId.'",').'
			VehId = "'.($this->VehId).'",
			
			VmaId = "'.($this->VmaId).'",
			VmoId = "'.($this->VmoId).'",
			VveId = "'.($this->VveId).'",
			VtiId = "'.($this->VtiId).'",
			
			EinComprobanteCompraNumero = "'.($this->EinComprobanteCompraNumero).'",	
			'.(empty($this->EinComprobanteCompraFecha)?'EinComprobanteCompraFecha = NULL, ':'EinComprobanteCompraFecha = "'.$this->EinComprobanteCompraFecha.'",').'
			
			EinVIN = "'.($this->EinVIN).'",		
			'.(empty($this->EinFechaVenta)?'EinFechaVenta = NULL, ':'EinFechaVenta = "'.$this->EinFechaVenta.'",').'
			EinAnoFabricacion = "'.($this->EinAnoFabricacion).'",
			EinAnoModelo = "'.($this->EinAnoModelo).'",
			EinAnoVehiculo = "'.($this->EinAnoVehiculo).'",
			EinNumeroMotor = "'.($this->EinNumeroMotor).'",
			
			EinTransmision = "'.($this->EinTransmision).'",

			EinDUA = "'.($this->EinDUA).'",
			EinGuiaTransporte = "'.($this->EinGuiaTransporte).'",		
			EinGuiaRemision = "'.($this->EinGuiaRemision).'",
			EinPlaca = "'.($this->EinPlaca).'",
			EinPoliza = "'.($this->EinPoliza).'",
			EinZofra = "'.($this->EinZofra).'",
			EinNacionalizado = "'.($this->EinNacionalizado).'",
			EinColor = "'.($this->EinColor).'",
			EinColorInterno = "'.($this->EinColorInterno).'",

			EinFoto = "'.($this->EinFoto).'",

			EinNotaPedido = "'.($this->EinNotaPedido).'",
			EinNumeroProforma = "'.($this->EinNumeroProforma).'",
			EinAnoProforma = "'.($this->EinAnoProforma).'",
			EinMesProforma = "'.($this->EinMesProforma).'",
			
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			
			EinArchivoDAM = "'.($this->EinArchivoDAM).'",
			EinArchivoDAM2 = "'.($this->EinArchivoDAM2).'",
			EinArchivoDAM3 = "'.($this->EinArchivoDAM3).'",
			
			'.(empty($this->EinFechaSalidaDAM)?'EinFechaSalidaDAM = NULL, ':'EinFechaSalidaDAM = "'.$this->EinFechaSalidaDAM.'",').'
			'.(empty($this->EinFechaRetornoDAM)?'EinFechaRetornoDAM = NULL, ':'EinFechaRetornoDAM = "'.$this->EinFechaRetornoDAM.'",').'
			EinEstadoVehicular = "'.($this->EinEstadoVehicular).'",
			EinSolicitud = "'.($this->EinSolicitud).'",
			
			'.(empty($this->EinEstadoVehicularFechaSalida)?'EinEstadoVehicularFechaSalida = NULL, ':'EinEstadoVehicularFechaSalida = "'.$this->EinEstadoVehicularFechaSalida.'",').'
			'.(empty($this->EinEstadoVehicularFechaLlegada)?'EinEstadoVehicularFechaLlegada = NULL, ':'EinEstadoVehicularFechaLlegada = "'.$this->EinEstadoVehicularFechaLlegada.'",').'
			
			EinNumeroViaje = "'.($this->EinNumeroViaje).'",
			EinUbicacionReferencia = "'.($this->EinUbicacionReferencia).'",
			
			EinManualPropietario = '.($this->EinManualPropietario).',
			EinManualGarantia = '.($this->EinManualGarantia).',
			
			EinTipo = '.($this->EinTipo).',
			
			EinNombre = "'.($this->EinNombre).'",
			
			'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
			'.(empty($this->EinTipoCambio)?'EinTipoCambio = NULL, ':'EinTipoCambio = "'.$this->EinTipoCambio.'",').'
			EinDescuentoGerencia = '.($this->EinDescuentoGerencia).',

			'.(empty($this->EinRecepcionFecha)?'EinRecepcionFecha = NULL, ':'EinRecepcionFecha = "'.$this->EinRecepcionFecha.'",').'
			EinRecepcionZonaComprometida = "'.($this->EinRecepcionZonaComprometida).'",
			EinRecepcionRepuestoDetalle = "'.($this->EinRecepcionRepuestoDetalle).'",
			EinRecepcionSolucion = "'.($this->EinRecepcionSolucion).'",
			EinRecepcionObservacion = "'.($this->EinRecepcionObservacion).'",
			
			EinCaracteristica1 = "'.($this->EinCaracteristica1).'",
			EinCaracteristica2 = "'.($this->EinCaracteristica2).'",
			EinCaracteristica3 = "'.($this->EinCaracteristica3).'",
			EinCaracteristica4 = "'.($this->EinCaracteristica4).'",
			EinCaracteristica5 = "'.($this->EinCaracteristica5).'",
			EinCaracteristica6 = "'.($this->EinCaracteristica6).'",
			EinCaracteristica7 = "'.($this->EinCaracteristica7).'",
			EinCaracteristica8 = "'.($this->EinCaracteristica8).'",
			EinCaracteristica9 = "'.($this->EinCaracteristica9).'",
			EinCaracteristica10 = "'.($this->EinCaracteristica10).'",
			
			EinCaracteristica11 = "'.($this->EinCaracteristica11).'",
			EinCaracteristica12 = "'.($this->EinCaracteristica12).'",
			EinCaracteristica13 = "'.($this->EinCaracteristica13).'",
			EinCaracteristica14 = "'.($this->EinCaracteristica14).'",
			EinCaracteristica15 = "'.($this->EinCaracteristica15).'",
			EinCaracteristica16 = "'.($this->EinCaracteristica16).'",
			EinCaracteristica17 = "'.($this->EinCaracteristica17).'",
			EinCaracteristica18 = "'.($this->EinCaracteristica18).'",
			EinCaracteristica19 = "'.($this->EinCaracteristica19).'",
			EinCaracteristica20 = "'.($this->EinCaracteristica20).'",
			
			EinClaveAlarma = "'.($this->EinClaveAlarma).'",
			EinEstado = '.($this->EinEstado).',
			EinTiempoModificacion = "'.($this->EinTiempoModificacion).'"		
			WHERE EinId = "'.($this->EinId).'";';
			
			/*
			EinCodigoPedido = "'.($this->EinCodigoPedido).'",
			EinFacturaNumero = "'.($this->EinFacturaNumero).'",
			EinFacturaValor = "'.($this->EinFacturaValor).'",
			EinProveedor = "'.($this->EinProveedor).'",
			*/
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
			
			if(!$error){

				if (!empty($this->VehiculoIngresoCliente)){		
						
					$validar = 0;	
					foreach ($this->VehiculoIngresoCliente as $DatVehiculoIngresoCliente){
						
						$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
						$InsVehiculoIngresoCliente->VicId = $DatVehiculoIngresoCliente->VicId;
						$InsVehiculoIngresoCliente->EinId = $this->EinId;
						$InsVehiculoIngresoCliente->CliId = $DatVehiculoIngresoCliente->CliId;
						$InsVehiculoIngresoCliente->VicFecha = $DatVehiculoIngresoCliente->VicFecha;
						$InsVehiculoIngresoCliente->VicEstado = $DatVehiculoIngresoCliente->VicEstado;
						$InsVehiculoIngresoCliente->VicTiempoCreacion = $DatVehiculoIngresoCliente->VicTiempoCreacion;
						$InsVehiculoIngresoCliente->VicTiempoModificacion = $DatVehiculoIngresoCliente->VicTiempoModificacion;
						$InsVehiculoIngresoCliente->VicEliminado = $DatVehiculoIngresoCliente->VicEliminado;
						
						if(empty($InsVehiculoIngresoCliente->VicId)){
							if($InsVehiculoIngresoCliente->VicEliminado<>2){
								if($InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoIngresoCliente->VicEliminado==2){
								if($InsVehiculoIngresoCliente->MtdEliminarVehiculoIngresoCliente($InsVehiculoIngresoCliente->VicId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_EIN_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoIngresoCliente->MtdEditarVehiculoIngresoCliente()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoIngresoCliente) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			if(!$error){

				if (!empty($this->VehiculoIngresoFoto)){		
						
					$validar = 0;	
					foreach ($this->VehiculoIngresoFoto as $DatVehiculoIngresoFoto){
						
						$InsVehiculoIngresoFoto = new ClsVehiculoIngresoFoto();
						$InsVehiculoIngresoFoto->VifId = $DatVehiculoIngresoFoto->VifId;
						$InsVehiculoIngresoFoto->EinId = $this->EinId;
						$InsVehiculoIngresoFoto->VifArchivo = $DatVehiculoIngresoFoto->VifArchivo;
						$InsVehiculoIngresoFoto->VifEstado = $DatVehiculoIngresoFoto->VifEstado;
						$InsVehiculoIngresoFoto->VifTiempoCreacion = $DatVehiculoIngresoFoto->VifTiempoCreacion;
						$InsVehiculoIngresoFoto->VifTiempoModificacion = $DatVehiculoIngresoFoto->VifTiempoModificacion;
						$InsVehiculoIngresoFoto->VifEliminado = $DatVehiculoIngresoFoto->VifEliminado;
						
						if(empty($InsVehiculoIngresoFoto->VifId)){
							if($InsVehiculoIngresoFoto->VifEliminado<>2){
								if($InsVehiculoIngresoFoto->MtdRegistrarVehiculoIngresoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoIngresoFoto->VifEliminado==2){
								if($InsVehiculoIngresoFoto->MtdEliminarVehiculoIngresoFoto($InsVehiculoIngresoFoto->VifId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_EIN_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoIngresoFoto->MtdEditarVehiculoIngresoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoIngresoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			

			if(!$error and $this->Predeterminar==true){

				if(!empty($this->VveCaracteristica1) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica1",$this->VveCaracteristica1,$this->VveId);

				}
//
				if(!empty($this->VveCaracteristica2) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica2",$this->VveCaracteristica2,$this->VveId);

				}
//				
				if(!empty($this->VveCaracteristica3) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica3",$this->VveCaracteristica3,$this->VveId);

				}							
//				
				if(!empty($this->VveCaracteristica4) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica4",$this->VveCaracteristica4,$this->VveId);

				}				
				
				if(!empty($this->VveCaracteristica5) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica5",$this->VveCaracteristica5,$this->VveId);

				}					
				
				if(!empty($this->VveCaracteristica6) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica6",$this->VveCaracteristica6,$this->VveId);

				}	
				
				if(!empty($this->VveCaracteristica7) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica7",$this->VveCaracteristica7,$this->VveId);

				}					
								
				if(!empty($this->VveCaracteristica8) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica8",$this->VveCaracteristica8,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica9) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica9",$this->VveCaracteristica9,$this->VveId);

				}				
					
				if(!empty($this->VveCaracteristica10) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica10",$this->VveCaracteristica10,$this->VveId);

				}				
				
				if(!empty($this->VveCaracteristica11) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica11",$this->VveCaracteristica11,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica12) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica12",$this->VveCaracteristica12,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica13) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica13",$this->VveCaracteristica13,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica14) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica14",$this->VveCaracteristica14,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica15) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica15",$this->VveCaracteristica15,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica16) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica16",$this->VveCaracteristica16,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica17) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica17",$this->VveCaracteristica17,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica18) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica18",$this->VveCaracteristica18,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica19) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica19",$this->VveCaracteristica19,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica20) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica20",$this->VveCaracteristica20,$this->VveId);

				}
//					
			}
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
			
				$this->MtdAuditarVehiculoIngreso(2,"Se actualizo el vehiculo.",$this);		
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
		}	
		
		
		
	public function MtdEditarVehiculoIngresoFacturacion() {
		
			$error = false;
		
			$this->InsMysql->MtdTransaccionIniciar();
						
			$sql = 'UPDATE tbleinvehiculoingreso SET 

			EinFacturaNumero = "'.($this->EinFacturaNumero).'",
			EinFacturaValor = "'.($this->EinFacturaValor).'",
			EinFacturaFecha = "'.($this->EinFacturaFecha).'",
			
			EinCodigoPedido = "'.($this->EinCodigoPedido).'",
			EinNumeroProforma = "'.($this->EinNumeroProforma).'",
			EinNotaPedido = "'.($this->EinNotaPedido).'",	
			
			EinTiempoModificacion = "'.($this->EinTiempoModificacion).'"		
			WHERE EinId = "'.($this->EinId).'";';
			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
			
				//$this->MtdAuditarVehiculoIngreso(2,"Se actualizo el vehiculo.",$this);		
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
		}	
		
		
		
	public function MtdEditarVehiculoIngresoCaracteristica() {
		
			$error = false;
		
			$this->InsMysql->MtdTransaccionIniciar();
					//'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
						
			$sql = 'UPDATE tbleinvehiculoingreso SET 
			
			EinAnoFabricacion = "'.($this->EinAnoFabricacion).'",
			EinAnoModelo = "'.($this->EinAnoModelo).'",
			
			EinNumeroMotor = "'.($this->EinNumeroMotor).'",
			
			EinDUA = "'.($this->EinDUA).'",
			EinPoliza = "'.($this->EinPoliza).'",
		
			EinColor = "'.($this->EinColor).'",
			EinColorInterno = "'.($this->EinColorInterno).'",

			EinNombre = "'.($this->EinNombre).'",
			
			EinCaracteristica1 = "'.($this->EinCaracteristica1).'",
			EinCaracteristica2 = "'.($this->EinCaracteristica2).'",
			EinCaracteristica3 = "'.($this->EinCaracteristica3).'",
			EinCaracteristica4 = "'.($this->EinCaracteristica4).'",
			EinCaracteristica5 = "'.($this->EinCaracteristica5).'",
			EinCaracteristica6 = "'.($this->EinCaracteristica6).'",
			EinCaracteristica7 = "'.($this->EinCaracteristica7).'",
			EinCaracteristica8 = "'.($this->EinCaracteristica8).'",
			EinCaracteristica9 = "'.($this->EinCaracteristica9).'",
			EinCaracteristica10 = "'.($this->EinCaracteristica10).'",
			
			EinCaracteristica11 = "'.($this->EinCaracteristica11).'",
			EinCaracteristica12 = "'.($this->EinCaracteristica12).'",
			EinCaracteristica13 = "'.($this->EinCaracteristica13).'",
			EinCaracteristica14 = "'.($this->EinCaracteristica14).'",
			EinCaracteristica15 = "'.($this->EinCaracteristica15).'",
			EinCaracteristica16 = "'.($this->EinCaracteristica16).'",
			EinCaracteristica17 = "'.($this->EinCaracteristica17).'",
			EinCaracteristica18 = "'.($this->EinCaracteristica18).'",
			EinCaracteristica19 = "'.($this->EinCaracteristica19).'",
			EinCaracteristica20 = "'.($this->EinCaracteristica20).'",
			
			EinTiempoModificacion = "'.($this->EinTiempoModificacion).'"		
			WHERE EinId = "'.($this->EinId).'";';
			
		
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			

			if(!$error and $this->Predeterminar==true){

				if(!empty($this->VveCaracteristica1) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica1",$this->VveCaracteristica1,$this->VveId);

				}
//
				if(!empty($this->VveCaracteristica2) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica2",$this->VveCaracteristica2,$this->VveId);

				}
//				
				if(!empty($this->VveCaracteristica3) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica3",$this->VveCaracteristica3,$this->VveId);

				}							
//				
				if(!empty($this->VveCaracteristica4) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica4",$this->VveCaracteristica4,$this->VveId);

				}				
				
				if(!empty($this->VveCaracteristica5) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica5",$this->VveCaracteristica5,$this->VveId);

				}					
				
				if(!empty($this->VveCaracteristica6) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica6",$this->VveCaracteristica6,$this->VveId);

				}	
				
				if(!empty($this->VveCaracteristica7) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica7",$this->VveCaracteristica7,$this->VveId);

				}					
								
				if(!empty($this->VveCaracteristica8) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica8",$this->VveCaracteristica8,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica9) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica9",$this->VveCaracteristica9,$this->VveId);

				}				
					
				if(!empty($this->VveCaracteristica10) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica10",$this->VveCaracteristica10,$this->VveId);

				}				
				
				if(!empty($this->VveCaracteristica11) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica11",$this->VveCaracteristica11,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica12) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica12",$this->VveCaracteristica12,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica13) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica13",$this->VveCaracteristica13,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica14) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica14",$this->VveCaracteristica14,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica15) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica15",$this->VveCaracteristica15,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica16) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica16",$this->VveCaracteristica16,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica17) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica17",$this->VveCaracteristica17,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica18) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica18",$this->VveCaracteristica18,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica19) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica19",$this->VveCaracteristica19,$this->VveId);

				}
				
				if(!empty($this->VveCaracteristica20) and !empty($this->VveId)){

					$InsVehiculoVersion = new ClsVehiculoVersion();
					$InsVehiculoVersion->MtdEditarVehiculoVersionDato("VveCaracteristica20",$this->VveCaracteristica20,$this->VveId);

				}
//					
			}
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
			
				$this->MtdAuditarVehiculoIngreso(2,"Se actualizo el vehiculo.",$this);		
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
		}	
		
		
		
		/*
		* SIMPLE
		*/
		
		
	public function MtdRegistrarVehiculoIngresoSimple() {
		
		global $Resultado;
		
		$error = false;
		
		$VehiculoIngresoId = $this->MtdVerificarExisteVehiculoIngreso("EinVIN",$this->EinVIN);

		if(!empty($VehiculoIngresoId)){
			$error = true;
			$Resultado.='#ERR_EIN_601';
		}

		$this->MtdGenerarVehiculoIngresoId();

			$this->InsMysql->MtdTransaccionIniciar();

			//'.(empty($this->CliId)?'NULL,':'"'.$this->CliId.'",').'	
			$sql = 'INSERT INTO tbleinvehiculoingreso (
			EinId,
			SucId,
			
			VprId,
			
			CliId,
			
			OncId,
			
			VehId,
			
			VmaId,
			VmoId,
			VveId,
			VtiId,
			
			EinVIN,
			EinFechaVenta,
			EinAnoFabricacion,
			EinAnoModelo,
			EinAnoVehiculo,
			EinNumeroMotor,
		
			EinTransmision,
			
			EinDUA,
			EinGuiaTransporte,
			EinGuiaRemision,
			EinPlaca,
			EinPoliza,
			EinZofra,
			EinNacionalizado,
			EinColor,
			EinColorInterno,
			
			EinFoto,
			
			EinNumeroProforma,
			EinAnoProforma,
			EinMesProforma,
			
			PerId,		
			
			EinArchivoDAM,
			EinArchivoDAM2,
			EinArchivoDAM3,
			
			EinFechaSalidaDAM,
			EinFechaRetornoDAM,
			EinEstadoVehicular,
			EinSolicitud,		
			EinEstadoVehicularFechaSalida,
			EinEstadoVehicularFechaLlegada,
			EinNumeroViaje,
			EinUbicacionReferencia,
			EinManualPropietario,
			EinManualGarantia,
			
			EinTipo,
			
			EinKilometraje,
			EinNombre,
				
			MonId,
			EinTipoCambio,
			EinDescuentoGerencia,
			
			EinRecepcionFecha,
			EinRecepcionZonaComprometida,
			EinRecepcionRepuestoDetalle,
			EinRecepcionSolucion,
			EinRecepcionObservacion,
			
		
			
			EinComprobanteCompraNumero,
			EinComprobanteCompraFecha,
			
			EinClaveAlarma,
			EinCodigoPedido,
			
			EinFacturaNumero,
			EinFacturaValor,
			EinProveedor,
			
			
			
			EinCancelado,
			EinEstado,			
			EinTiempoCreacion,
			EinTiempoModificacion
			) 
			VALUES (
			"'.($this->EinId).'", 
			"'.($this->SucId).'", 
			
			'.(empty($this->VprId)?'NULL,':'"'.$this->VprId.'",').'	
			'.(empty($this->CliId)?'NULL,':'"'.$this->CliId.'",').'	
			'.(empty($this->OncId)?'NULL,':'"'.$this->OncId.'",').'	
			
			'.(empty($this->VehId)?'NULL,':'"'.$this->VehId.'",').'	
		
			
			"'.($this->VmaId).'", 
			"'.($this->VmoId).'", 
			"'.($this->VveId).'", 
			"'.($this->VtiId).'", 
			
			"'.($this->EinVIN).'", 
			'.(empty($this->EinFechaVenta)?'NULL,':'"'.$this->EinFechaVenta.'",').'	
			"'.($this->EinAnoFabricacion).'", 
			"'.($this->EinAnoModelo).'", 
			"'.($this->EinAnoVehiculo).'", 
			"'.($this->EinNumeroMotor).'", 
			
			"'.($this->EinTransmision).'",			
			
			"'.($this->EinDUA).'",			
			"'.($this->EinGuiaTransporte).'",
			"'.($this->EinGuiaRemision).'",			
			"'.($this->EinPlaca).'",
			"'.($this->EinPoliza).'",
			"'.($this->EinZofra).'",			
			"'.($this->EinNacionalizado).'",
			"'.($this->EinColor).'",
			"'.($this->EinColorInterno).'",
			
			"'.($this->EinFoto).'",
		
			"'.($this->EinNumeroProforma).'",
			"'.($this->EinAnoProforma).'",
			"'.($this->EinMesProforma).'",
			
			'.(empty($this->PerId)?'NULL,':'"'.$this->PerId.'",').'	
			
			"'.($this->EinArchivoDAM).'",
			"'.($this->EinArchivoDAM2).'",
			"'.($this->EinArchivoDAM3).'",
			
			'.(empty($this->EinFechaSalidaDAM)?'NULL,':'"'.$this->EinFechaSalidaDAM.'",').'	
			'.(empty($this->EinFechaRetornoDAM)?'NULL,':'"'.$this->EinFechaRetornoDAM.'",').'	
				
			"'.($this->EinEstadoVehicular).'",
			"'.($this->EinSolicitud).'",
			
			'.(empty($this->EinEstadoVehicularFechaSalida)?'NULL,':'"'.$this->EinEstadoVehicularFechaSalida.'",').'	
			'.(empty($this->EinEstadoVehicularFechaLlegada)?'NULL,':'"'.$this->EinEstadoVehicularFechaLlegada.'",').'	
			
			"'.($this->EinNumeroViaje).'",
			"'.($this->EinUbicacionReferencia).'",
			2,
			2,
			
			'.($this->EinTipo).',		
			
			0,
			"'.($this->EinNombre).'",
			
			'.(empty($this->MonId)?'NULL,':'"'.$this->MonId.'",').'	
			'.(empty($this->EinTipoCambio)?'NULL,':'"'.$this->EinTipoCambio.'",').'	
			'.($this->EinDescuentoGerencia).',
			
			'.(empty($this->EinRecepcionFecha)?'NULL,':'"'.$this->EinRecepcionFecha.'",').'	
			"'.($this->EinRecepcionZonaComprometida).'",
			"'.($this->EinRecepcionRepuestoDetalle).'",
			"'.($this->EinRecepcionSolucion).'",
			"'.($this->EinRecepcionObservacion).'",
			
		
			
			"'.($this->EinComprobanteCompraNumero).'", 
			"'.($this->EinComprobanteCompraFecha).'", 
		
			"'.($this->EinClaveAlarma).'", 
			"'.($this->EinCodigoPedido).'", 
			
			"'.($this->EinFacturaNumero).'", 
			"'.($this->EinFacturaValor).'", 
			"'.($this->EinProveedor).'", 
			
			2,
			'.($this->EinEstado).',
			"'.($this->EinTiempoCreacion).'", 
			"'.($this->EinTiempoModificacion).'");';

			
			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			
			if(!$error){			
			
				if (!empty($this->VehiculoIngresoCliente)){		
						
					$validar = 0;				
					
					
					foreach ($this->VehiculoIngresoCliente as $DatVehiculoIngresoCliente){
						
						$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();		
						$InsVehiculoIngresoCliente->EinId = $this->EinId;
						$InsVehiculoIngresoCliente->CliId = $DatVehiculoIngresoCliente->CliId;
						$InsVehiculoIngresoCliente->VicFecha = $DatVehiculoIngresoCliente->VicFecha;
						$InsVehiculoIngresoCliente->VicEstado = $DatVehiculoIngresoCliente->VicEstado;								
						$InsVehiculoIngresoCliente->VicTiempoCreacion = $DatVehiculoIngresoCliente->VicTiempoCreacion;
						$InsVehiculoIngresoCliente->VicTiempoModificacion = $DatVehiculoIngresoCliente->VicTiempoModificacion;						
						$InsVehiculoIngresoCliente->VicEliminado = $DatVehiculoIngresoCliente->VicEliminado;
						
						if($InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente()){
							$validar++;	
						}else{
							$Resultado.='#ERR_EIN_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoIngresoCliente) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			
			
			if(!$error){			
			
				if (!empty($this->VehiculoIngresoFoto)){		
						
					$validar = 0;				
					
					
					foreach ($this->VehiculoIngresoFoto as $DatVehiculoIngresoFoto){
						
						$InsVehiculoIngresoFoto = new ClsVehiculoIngresoFoto();		
						$InsVehiculoIngresoFoto->EinId = $this->EinId;
						$InsVehiculoIngresoFoto->VifArchivo = $DatVehiculoIngresoFoto->VifArchivo;								
						$InsVehiculoIngresoFoto->VifEstado = $DatVehiculoIngresoFoto->VifEstado;								
						$InsVehiculoIngresoFoto->VifTiempoCreacion = $DatVehiculoIngresoFoto->VifTiempoCreacion;
						$InsVehiculoIngresoFoto->VifTiempoModificacion = $DatVehiculoIngresoFoto->VifTiempoModificacion;						
						$InsVehiculoIngresoFoto->VifEliminado = $DatVehiculoIngresoFoto->VifEliminado;
						
						if($InsVehiculoIngresoFoto->MtdRegistrarVehiculoIngresoFoto()){
							$validar++;	
						}else{
							$Resultado.='#ERR_EIN_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->VehiculoIngresoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			

			

			if($error) {					
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
			
				$this->MtdAuditarVehiculoIngreso(1,"Se registro el vehiculo.",$this);		
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
		
	public function MtdEditarVehiculoIngresoSimple() {
		
			$error = false;
		
			$this->InsMysql->MtdTransaccionIniciar();
					//'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
						
			$sql = 'UPDATE tbleinvehiculoingreso SET 
			SucId = "'.($this->SucId).'",
			
			'.(empty($this->OncId)?'OncId = NULL, ':'OncId = "'.$this->OncId.'",').'
			VehId = "'.($this->VehId).'",
			
			VmaId = "'.($this->VmaId).'",
			VmoId = "'.($this->VmoId).'",
			VveId = "'.($this->VveId).'",
			VtiId = "'.($this->VtiId).'",
			
			EinVIN = "'.($this->EinVIN).'",		
			
			EinAnoFabricacion = "'.($this->EinAnoFabricacion).'",
			EinAnoModelo = "'.($this->EinAnoModelo).'",
			EinAnoVehiculo = "'.($this->EinAnoVehiculo).'",
			EinNumeroMotor = "'.($this->EinNumeroMotor).'",
			
			EinTransmision = "'.($this->EinTransmision).'",

			EinPlaca = "'.($this->EinPlaca).'",
		
			EinZofra = "'.($this->EinZofra).'",
			EinNacionalizado = "'.($this->EinNacionalizado).'",
			EinColor = "'.($this->EinColor).'",
			EinColorInterno = "'.($this->EinColorInterno).'",

			

			EinEstadoVehicular = "'.($this->EinEstadoVehicular).'",
			EinSolicitud = "'.($this->EinSolicitud).'",
			
			EinTipo = '.($this->EinTipo).',
			
			EinClaveAlarma = "'.($this->EinClaveAlarma).'",
			EinEstado = '.($this->EinEstado).',
			EinTiempoModificacion = "'.($this->EinTiempoModificacion).'"		
			WHERE EinId = "'.($this->EinId).'";';
			
			//EinFoto = "'.($this->EinFoto).'",
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
			
			if(!$error){

				if (!empty($this->VehiculoIngresoCliente)){		
						
					$validar = 0;	
					foreach ($this->VehiculoIngresoCliente as $DatVehiculoIngresoCliente){
						
						$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
						$InsVehiculoIngresoCliente->VicId = $DatVehiculoIngresoCliente->VicId;
						$InsVehiculoIngresoCliente->EinId = $this->EinId;
						$InsVehiculoIngresoCliente->CliId = $DatVehiculoIngresoCliente->CliId;
						$InsVehiculoIngresoCliente->VicFecha = $DatVehiculoIngresoCliente->VicFecha;
						$InsVehiculoIngresoCliente->VicEstado = $DatVehiculoIngresoCliente->VicEstado;
						$InsVehiculoIngresoCliente->VicTiempoCreacion = $DatVehiculoIngresoCliente->VicTiempoCreacion;
						$InsVehiculoIngresoCliente->VicTiempoModificacion = $DatVehiculoIngresoCliente->VicTiempoModificacion;
						$InsVehiculoIngresoCliente->VicEliminado = $DatVehiculoIngresoCliente->VicEliminado;
						
						if(empty($InsVehiculoIngresoCliente->VicId)){
							if($InsVehiculoIngresoCliente->VicEliminado<>2){
								if($InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoIngresoCliente->VicEliminado==2){
								if($InsVehiculoIngresoCliente->MtdEliminarVehiculoIngresoCliente($InsVehiculoIngresoCliente->VicId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_EIN_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoIngresoCliente->MtdEditarVehiculoIngresoCliente()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoIngresoCliente) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			if(!$error){

				if (!empty($this->VehiculoIngresoFoto)){		
						
					$validar = 0;	
					foreach ($this->VehiculoIngresoFoto as $DatVehiculoIngresoFoto){
						
						$InsVehiculoIngresoFoto = new ClsVehiculoIngresoFoto();
						$InsVehiculoIngresoFoto->VifId = $DatVehiculoIngresoFoto->VifId;
						$InsVehiculoIngresoFoto->EinId = $this->EinId;
						$InsVehiculoIngresoFoto->VifArchivo = $DatVehiculoIngresoFoto->VifArchivo;
						$InsVehiculoIngresoFoto->VifEstado = $DatVehiculoIngresoFoto->VifEstado;
						$InsVehiculoIngresoFoto->VifTiempoCreacion = $DatVehiculoIngresoFoto->VifTiempoCreacion;
						$InsVehiculoIngresoFoto->VifTiempoModificacion = $DatVehiculoIngresoFoto->VifTiempoModificacion;
						$InsVehiculoIngresoFoto->VifEliminado = $DatVehiculoIngresoFoto->VifEliminado;
						
						if(empty($InsVehiculoIngresoFoto->VifId)){
							if($InsVehiculoIngresoFoto->VifEliminado<>2){
								if($InsVehiculoIngresoFoto->MtdRegistrarVehiculoIngresoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsVehiculoIngresoFoto->VifEliminado==2){
								if($InsVehiculoIngresoFoto->MtdEliminarVehiculoIngresoFoto($InsVehiculoIngresoFoto->VifId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_EIN_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsVehiculoIngresoFoto->MtdEditarVehiculoIngresoFoto()){
									$validar++;	
								}else{
									$Resultado.='#ERR_EIN_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->VehiculoIngresoFoto) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
			
				$this->MtdAuditarVehiculoIngreso(2,"Se actualizo el vehiculo.",$this);		
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
		}
		
	
	public function MtdActualizarVehiculoIngresoCliente($oVehiculoIngresoId,$oClienteId) {
		
		$sql = 'UPDATE tbleinvehiculoingreso SET 
		CliId = "'.($oClienteId).'"
		WHERE EinId = "'.($oVehiculoIngresoId).'";';
		
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
		if($error) {		
			return false;
		} else {		
			$this->MtdAuditarVehiculoIngreso(2,"Se actualizo el cliente del vehiculo.",$this);		
			return true;
		}						
				
	}	
	
	public function MtdActualizarVehiculoIngresoCostoIngreso($oVehiculoIngresoId,$oCostoIngreso,$oMoneda,$oTipoCambio=NULL) {
		
		$sql = 'UPDATE tbleinvehiculoingreso SET 
		EinCostoIngreso = "'.($oClienteId).'",
		'.(empty($oTipoCambio)?'EinTipoCambioIngreso = NULL, ':'EinTipoCambioIngreso = "'.$oTipoCambio.'",').'
		MonIdIngreso = "'.($oMoneda).'"
				
		WHERE EinId = "'.($oVehiculoIngresoId).'";';
		
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
		if($error) {		
			return false;
		} else {		
			//$this->MtdAuditarVehiculoIngreso(2,"Se actualizo el cliente del vehiculo.",$this);		
			return true;
		}						
				
	}		
	
//	public function MtdActualizarVehiculoIngresoPlaca($oVehiculoIngresoId,$oVehiculoIngresoPlaca) {
//		
//		$sql = 'UPDATE tbleinvehiculoingreso SET 
//		EinPlaca = "'.($oVehiculoIngresoPlaca).'"
//		WHERE EinId = "'.($oVehiculoIngresoId).'";';
//		
//		$error = false;
//		
//		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//		
//		if(!$resultado) {							
//			$error = true;
//		} 
//		
//		if($error) {		
//			return false;
//		} else {			
//			return true;
//		}						
//				
//	}			
			
		
	public function MtdEditarVehiculoIngresoDato($oCampo,$oVehiculoIngresoDato,$oVehiculoIngresoId) {
		
		$sql = 'UPDATE tbleinvehiculoingreso SET 
		'.(empty($oCampo)?''.$oCampo.' = NULL ':''.$oCampo.' = "'.$oVehiculoIngresoDato.'" ').'
		WHERE EinId = "'.($oVehiculoIngresoId).'";';
		//'.$oCampo.' = "'.($oVehiculoIngresoDato).'"
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
	
	
	 public function MtdObtenerVehiculoIngresoAnoFabricaciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10') {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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

		
				
				 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				DISTINCT ein.EinAnoFabricacion	
				FROM tbleinvehiculoingreso ein		
					
					WHERE ein.EinAnoFabricacion != ""
					AND ein.EinAnoFabricacion IS NOT NULL
					AND ein.EinEstadoVehicular != "EXTERNO"

			  '.$filtrar.$concesionario.$vtipo.$estado.$sucursal .$tipo.$cliente.$evehicular.$vmarca.$vmodelo.$vversion.$amodelo.$afabricacion.$color.$cproforma.$fecha.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngreso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoIngreso = new $InsVehiculoIngreso();
					
					$VehiculoIngreso->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					
                    $VehiculoIngreso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	
	 public function MtdObtenerVehiculoIngresoColores($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoVersion=NULL,$oVehiculoModelo=NULL,$oVehiculoMarca=NULL,$oSucursal=NULL,$oEstadoVehicular=NULL,$oAnoModelo=NULL,$oAnoFabricacion=NULL,$oVehiculo=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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

		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.$oVehiculoMarca.'" ';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.$oVehiculoModelo.'" ';
		}
		
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND ein.VveId = "'.$oVehiculoVersion.'" ';
		}
		
			
		if(!empty($oAnoModelo)){
			$amodelo = ' AND ein.EinAnoModelo = "'.$oAnoModelo.'" ';
		}

		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND ein.EinAnoFabricacion = "'.$oAnoFabricacion.'" ';
		}
		
		
		if(!empty($oSucursal)){

			$elementos = explode(",",$oSucursal);

			$i=1;
			$sucursal .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$sucursal .= '  (ein.SucId = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$sucursal .= ' OR ';	
				}
			$i++;		
			}

			$sucursal .= ' ) 
			)
			';

		}
		
		
		if(!empty($oEstadoVehicular)){

			$elementos = explode(",",$oEstadoVehicular);

			$i=1;
			$evehicular .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$evehicular .= '  (ein.EinEstadoVehicular = "'.($elemento).'" )';
				if($i<>count($elementos)){						
					$evehicular .= ' OR ';	
				}
			$i++;		
			}

			$evehicular .= ' ) 
			)
			';

		}
			
			
		
			
		if(!empty($oVehiculo)){
			$vehiculo = ' AND ein.VehId = "'.$oVehiculo.'" ';
		}
		
		
				 $sql = 'SELECT
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				ein.EinColor,
				COUNT(ein.EinId) AS EinTotalColor

			FROM tbleinvehiculoingreso ein
				LEFT JOIN tblvvevehiculoversion vve
				ON ein.VveId = vve.VveId
				LEFT JOIN tblvmovehiculomodelo vmo
				ON vve.VmoId = vmo.VmoId
				LEFT JOIN tblvmavehiculomarca vma
				ON vmo.VmaId = vma.VmaId
WHERE 1 = 1
			  '.$filtrar.$concesionario.$vtipo.$evehicular.$vmarca.$vehiculo.$vmodelo.$vversion.$afabricacion.$amodelo.$estado.$sucursal .$tipo.$cliente.$evehicular.$vmarca.$vmodelo.$vversion.$amodelo.$afabricacion.$color.$cproforma.$fecha.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoIngreso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoIngreso = new $InsVehiculoIngreso();
					
				
					$VehiculoIngreso->VmaNombre = $fila['VmaNombre'];
					$VehiculoIngreso->VmoNombre = $fila['VmoNombre'];
					$VehiculoIngreso->VveNombre = $fila['VveNombre'];
					
					$VehiculoIngreso->EinColor = $fila['EinColor'];
					$VehiculoIngreso->EinTotalColor = $fila['EinTotalColor'];
					
                    $VehiculoIngreso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VehiculoIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		private function MtdAuditarVehiculoIngreso($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->EinId;
			$InsAuditoria->AudCodigoExtra = NULL;
			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = NULL;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar("v2")){
				return true;
			}else{
				return false;	
			}
			
		}
		
	
		


}
?>