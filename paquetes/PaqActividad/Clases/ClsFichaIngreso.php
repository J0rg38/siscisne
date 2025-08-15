<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngreso
{

	public $Ruta;
	public $FinId;
	public $FinId2;
	public $CitId;

	public $FinAno;
	public $CliId;
	public $EinId;
	public $CamId;
	public $OvvId;
	public $ObsId;
	public $OvmId;

	public $TreId;

	public $MonId;
	public $FinTipoCambio;

	public $PerId;
	public $PerIdAsesor;

	public $FinManoObraPrecio;

	public $FinConductor;
	public $FinTelefono;
	public $FinDireccion;
	public $FinContacto;

	public $FinFecha;
	public $FinVentaFechaEntrega;
	public $FinFechaActividad;
	public $FinFechaGarantia;
	public $FinFechaCita;

	public $FinFechaEntrega;
	public $FinHoraEntrega;

	public $FinFechaEntregaExtendida;
	public $FinHoraEntregaExtendida;

	public $FinHora;
	public $FinPlaca;

	public $MinIdDescripcion;

	public $FinMantenimientoKilometraje;
	public $FinObservacion;
	public $FinVehiculoKilometraje;

	public $FinExteriorDelantero1;
	public $FinExteriorDelantero2;
	public $FinExteriorDelantero3;
	public $FinExteriorDelantero4;
	public $FinExteriorDelantero5;
	public $FinExteriorDelantero6;
	public $FinExteriorDelantero7;
	public $FinExteriorPosterior2;
	public $FinExteriorPosterior3;
	public $FinExteriorPosterior4;
	public $FinExteriorPosterior5;

	public $FinExteriorPosterior1;
	public $FinExteriorPosterior6;

	public $FinExteriorDerecho1;
	public $FinExteriorDerecho2;
	public $FinExteriorDerecho3;
	public $FinExteriorDerecho4;
	public $FinExteriorDerecho5;
	public $FinExteriorDerecho6;
	public $FinExteriorDerecho7;
	public $FinExteriorDerecho8;

	public $FinExteriorIzquierdo1;
	public $FinExteriorIzquierdo2;
	public $FinExteriorIzquierdo3;
	public $FinExteriorIzquierdo4;
	public $FinExteriorIzquierdo5;
	public $FinExteriorIzquierdo6;
	public $FinExteriorIzquierdo7;


	public $FinInterior1;
	public $FinInterior2;
	public $FinInterior3;
	public $FinInterior4;
	public $FinInterior5;

	// Propiedades adicionales para evitar warnings
	public $VmaNombre;
	public $VmoNombre;
	public $VveNombre;
	public $FinFechaVenta;
	public $FinCantidadMantenimientos;
	public $CamFecha;
	public $PmaId;
	public $PmaNombre;
	public $CprId;
	public $ObsNombre;
	public $OvmKilometraje;
	public $FinCita;
	public $FinIndicacionTecnico;
	public $FinReferencia;
	public $FinClienteEmail;
	public $CliNombreCompleto;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $SucId;
	public $FinInterior6;
	public $FinInterior7;
	public $FinInterior8;
	public $FinInterior9;
	public $FinInterior10;
	public $FinInterior11;
	public $FinInterior12;
	public $FinInterior13;
	public $FinInterior14;
	public $FinInterior15;
	public $FinInterior16;
	public $FinInterior17;
	public $FinInterior18;
	public $FinInterior19;
	public $FinInterior20;
	public $FinInterior21;
	public $FinInterior22;
	public $FinInterior23;
	public $FinInterior24;
	public $FinInterior25;
	public $FinInterior26;
	public $FinInterior27;

	public $FinNota;

	public $FinInformeTecnicoMantenimiento;
	public $FinInformeTecnicoRevision;
	public $FinInformeTecnicoDiagnostico;

	public $FinSalidaFecha;
	public $FinSalidaHora;
	public $FinSalidaObservacion;
	public $FinTerminadoObservacion;
	public $FinAlmacenObservacion;
	public $FinTallerObservacion;
	public $FinActaEntrega;

	public $FinInformeTecnico;

	public $FinPrioridad;

	public $FinTiempoTallerConcluido;
	public $FinTiempoTallerRevisando;
	public $FinTiempoTrabajoTerminado;

	public $FinFotoVIN;
	public $FinFotoFrontal;
	public $FinFotoCupon;
	public $FinFotoMantenimiento;

	public $FinOrigenEntrega;
	public $FinMontoPresupuesto;
	public $FinTipo;
	public $FinModalidad;
	public $FinEstado;
	public $FinTiempoCreacion;
	public $FinTiempoModificacion;
	public $FinEliminado;

	public $MinNombre;
	public $MinId;

	public $TdoId;
	public $CliNombre;
	public $CliNumeroDocumento;
	public $TdoNombre;
	public $LtiId;

	public $LtiUtilidad;
	public $LtiNombre;
	public $LtiAbreviatura;

	public $EinVIN;
	public $VmaId;
	public $VmoId;
	public $EinAnoFabricacion;
	public $EinPlaca;
	public $EinColor;

	public $IteId;

	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;


	public $PerNombreAsesor;
	public $PerApellidoPaternoAsesor;
	public $PerApellidoMaternoAsesor;
	public $PerNumeroDocumentoAsesor;

	public $PerCelularAsesor;
	public $PerEmailAsesor;


	public $CamCodigo;
	public $CamNombre;
	public $CamBoletin;

	public $OncNombre;

	public $InsMysql;

	public $FichaIngresoProducto;
	public $FichaIngresoTarea;
	public $FichaIngresoModalidad;
	public $FichaIngresoHerramienta;
	public $PreEntregaDetalle;


	public function __construct($oInsMysql = NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}
	}

	public function __destruct() {}

	public function MtdGenerarFichaIngresoId()
	{

		//deb($this->FinTipo);

		switch ($this->FinTipo) {

			case 2:

				$sql = 'SELECT	
				suc.SucSiglas AS SIGLA,
				MAX(CONVERT(SUBSTR(fin.FinId,10),unsigned)) AS "MAXIMO"
				FROM tblfinfichaingreso fin
					LEFT JOIN tblsucsucursal suc
					ON fin.SucId = suc.SucId
					
					WHERE YEAR(fin.FinFecha) = ' . $this->FinAno . '
					AND fin.SucId = "' . $this->SucId . '"
					AND fin.FinTipo = 2
                                           AND fin.FinMigrado IS NULL;';

				$resultado = $this->InsMysql->MtdConsultar($sql);
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);

				if (empty($fila['MAXIMO'])) {
					$this->FinId = "PDS-" . $this->FinAno . "-00001-" . (empty($fila['SIGLA']) ? $_SESSION['SesionSucursalSiglas'] : $fila['SIGLA']);
				} else {
					$fila['MAXIMO']++;
					$this->FinId = "PDS-" . $this->FinAno . "-" . str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT) . "-" . (empty($fila['SIGLA']) ? $_SESSION['SesionSucursalSiglas'] : $fila['SIGLA']);
				}

				break;

			default:

				$sql = 'SELECT	
				suc.SucSiglas AS SIGLA,
				MAX(CONVERT(SUBSTR(fin.FinId,10),unsigned)) AS "MAXIMO"
				FROM tblfinfichaingreso fin
					LEFT JOIN tblsucsucursal suc
					ON fin.SucId = suc.SucId
										
					WHERE YEAR(fin.FinFecha) = ' . $this->FinAno . '
					AND fin.SucId = "' . $this->SucId . '"
					AND fin.FinTipo = 1
                       AND fin.FinMigrado IS NULL
                       ;';

				$resultado = $this->InsMysql->MtdConsultar($sql);
				$fila = $this->InsMysql->MtdObtenerDatos($resultado);

				if (empty($fila['MAXIMO'])) {
					$this->FinId = "OT-" . $this->FinAno . "-00001-" . (empty($fila['SIGLA']) ? $_SESSION['SesionSucursalSiglas'] : $fila['SIGLA']);
				} else {
					$fila['MAXIMO']++;
					$this->FinId = "OT-" . $this->FinAno . "-" . str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT) . "-" . (empty($fila['SIGLA']) ? $_SESSION['SesionSucursalSiglas'] : $fila['SIGLA']);
				}

				break;
		}
	}

	public function MtdObtenerFichaIngreso($oCompleto = true)
	{

		$sql = 'SELECT 
        fin.FinId,
		fin.FinId2,  
		fin.SucId,
		
		fin.CitId,
		 
		fin.CliId,
		fin.EinId,
		fin.CamId,
		fin.OvvId,
		fin.ObsId,
		fin.OvmId,
		
		fin.PmaId,
		
		fin.TreId,
		
		fin.MonId,
		fin.FinTipoCambio,
		
		fin.PerId,
		fin.PerIdAsesor,
		
		fin.FinManoObraPrecio,

		fin.FinConductor,
		fin.FinTelefono,
		fin.FinDireccion,
		fin.FinContacto,
		
		fin.FinClienteEmail,
		
		DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",	
		DATE_FORMAT(fin.FinVentaFechaEntrega, "%d/%m/%Y") AS "NFinVentaFechaEntrega",	
			
		DATE_FORMAT(fin.FinFechaGarantia, "%d/%m/%Y") AS "NFinFechaGarantia",
		DATE_FORMAT(fin.FinFechaActividad, "%d/%m/%Y") AS "NFinFechaActividad",
		
		DATE_FORMAT(fin.FinFechaCita, "%d/%m/%Y") AS "NFinFechaCita",
		
		DATE_FORMAT(fin.FinFechaEntrega, "%d/%m/%Y") AS "NFinFechaEntrega",
		fin.FinHoraEntrega,

		DATE_FORMAT(fin.FinFechaEntregaExtendida, "%d/%m/%Y") AS "NFinFechaEntregaExtendida",
		fin.FinHoraEntregaExtendida,
		
		fin.FinHora,
		fin.FinPlaca,

		fin.FinMantenimientoKilometraje,
		fin.FinObservacion,
		fin.FinVehiculoKilometraje,

		fin.FinExteriorDelantero1,
		fin.FinExteriorDelantero2,
		fin.FinExteriorDelantero3,
		fin.FinExteriorDelantero4,
		fin.FinExteriorDelantero5,
		fin.FinExteriorDelantero6,
		fin.FinExteriorDelantero7,
		
		fin.FinExteriorPosterior1,
		fin.FinExteriorPosterior2,
		fin.FinExteriorPosterior3,
		fin.FinExteriorPosterior4,
		fin.FinExteriorPosterior5,
		fin.FinExteriorPosterior6,
		
		fin.FinExteriorDerecho1,
		fin.FinExteriorDerecho2,
		fin.FinExteriorDerecho3,
		fin.FinExteriorDerecho4,
		fin.FinExteriorDerecho5,
		fin.FinExteriorDerecho6,
		fin.FinExteriorDerecho7,
		fin.FinExteriorDerecho8,
		
		fin.FinExteriorIzquierdo1,
		fin.FinExteriorIzquierdo2,
		fin.FinExteriorIzquierdo3,
		fin.FinExteriorIzquierdo4,
		fin.FinExteriorIzquierdo5,
		fin.FinExteriorIzquierdo6,
		fin.FinExteriorIzquierdo7,		

		fin.FinInterior1,
		fin.FinInterior2,
		fin.FinInterior3,
		fin.FinInterior4,
		fin.FinInterior5,
		fin.FinInterior6,
		fin.FinInterior7,
		fin.FinInterior8,
		fin.FinInterior9,
		fin.FinInterior10,
		fin.FinInterior11,
		fin.FinInterior12,
		fin.FinInterior13,
		fin.FinInterior14,
		fin.FinInterior15,
		fin.FinInterior16,
		fin.FinInterior17,
		fin.FinInterior18,
		fin.FinInterior19,
		fin.FinInterior20,
		fin.FinInterior21,
		fin.FinInterior22,
		fin.FinInterior23,
		fin.FinInterior24,
		fin.FinInterior25,
		fin.FinInterior26,
		fin.FinInterior27,
		
		fin.FinNota,
		
		fin.FinInformeTecnicoMantenimiento,
		fin.FinInformeTecnicoRevision,
		fin.FinInformeTecnicoDiagnostico,
		
		DATE_FORMAT(fin.FinSalidaFecha, "%d/%m/%Y") AS "NFinSalidaFecha",
		fin.FinSalidaHora,
		fin.FinSalidaObservacion,
		fin.FinSalidaObservacionInterna,
		
		fin.FinTerminadoObservacion,
		fin.FinAlmacenObservacion,
		fin.FinTallerObservacion,
		
		fin.FinActaEntrega,
		DATE_FORMAT(fin.FinActaEntregaFecha, "%d/%m/%Y") AS "NFinActaEntregaFecha",	
		
		CASE
		WHEN EXISTS (
			SELECT 
			ite.IteId 
			FROM tbliteinformetecnico ite
			WHERE ite.FinId = fin.FinId LIMIT 1
		) THEN "Si"
		ELSE "No"
		END AS FinInformeTecnico,
				
		fin.FinPrioridad,
		
		DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
		DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
		DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",	
	
		CONCAT(
		TIMESTAMPDIFF(day,fin.FinTiempoTallerRevisando,fin.FinTiempoTallerConcluido) , " Dias ",
		MOD( TIMESTAMPDIFF(hour,fin.FinTiempoTallerRevisando,fin.FinTiempoTallerConcluido), 24), " Horas ",
		MOD( TIMESTAMPDIFF(minute,fin.FinTiempoTallerRevisando,fin.FinTiempoTallerConcluido), 60), " Minutos "
		) AS FinTiempoTallerTrabajado,
		
		
		fin.FinFotoVIN,
		fin.FinFotoFrontal,
		fin.FinFotoCupon,
		fin.FinFotoMantenimiento,
		
		fin.FinOrigenEntrega,
		
		fin.FinMontoPresupuesto,
		fin.FinTipo,
		
		fin.FinReferencia,
		fin.FinIndicacionTecnico,
		fin.FinCierre,
		fin.FinCita,
		
		fin.FinEstado,
		DATE_FORMAT(fin.FinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoCreacion",
        DATE_FORMAT(fin.FinTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoModificacion",
				
				
		
		cli.CliCSIIncluir,
				
		cli.TdoId,
		
		cli.CliNombreCompleto,
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		cli.CliDireccion,
		cli.CliDepartamento,
		cli.CliProvincia,
		cli.CliDistrito,
		cli.CliTelefono,
		cli.CliCelular,
		
		cli.CliNumeroDocumento,
		tdo.TdoNombre,
		cli.LtiId,
		lti.LtiUtilidad,
		lti.LtiNombre,
		lti.LtiAbreviatura,
		
		ein.EinVIN,
		vmo.VmaId,
		vve.VmoId,
		
		ein.VveId,
		ein.EinAnoFabricacion,
		ein.EinPlaca,
		ein.EinColor,
		
		vma.VmaNombre,
		vmo.VmoNombre,
		vve.VveNombre,
		
		per.PerFoto,
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		
		per2.PerNombre AS PerNombreAsesor,
		per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
		per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
		per2.PerNumeroDocumento AS PerNumeroDocumentoAsesor,
		
		per2.PerCelular AS PerCelularAsesor,
		per2.PerEmail AS PerEmailAsesor,
		
		cam.CamCodigo,
		cam.CamNombre,
		cam.CamBoletin,
		
		onc.OncNombre,
		
		CASE
		WHEN EXISTS (
			SELECT 

			fsx.FsxId
			
			FROM tblfsxfichaaccionsalidaexterna fsx

				LEFT JOIN tblfccfichaaccion fcc
				ON fsx.FccId = fcc.FccId
					
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fcc.FimId = fim.FimId
					
					
		WHERE 
			 fim.FinId = fin.FinId
			AND fsx.FsxId IS NOT NULL
		
		) THEN "Si"
		ELSE "No"
		END AS FinTallerExterno,
		
		
		CASE
		WHEN EXISTS (
			SELECT 

			cpr.CprId
			
			FROM tblcprcotizacionproducto cpr
	
		WHERE 
			cpr.FinId = fin.FinId
			AND  cpr.CprEstado <> 6
		) THEN "Si"
		ELSE "No"
		END AS FinCotizacionProducto,
		


		
		(
		SELECT
		DATE_FORMAT(IFNULL(bol.BolFechaEmision,fac.FacFechaEmision), "%d/%m/%Y")
		FROM tblovvordenventavehiculo ovv
			LEFT JOIN tblfacfactura fac
			ON fac.OvvId = ovv.OvvId
			LEFT JOIN tblbolboleta bol
			ON bol.OvvId = ovv.OvvId
		WHERE ovv.EinId = fin.EinId
		LIMIT 1
		) AS FinFechaVenta,
		
		
		DATE_FORMAT(adddate((
		SELECT
		IFNULL(bol.BolFechaEmision,fac.FacFechaEmision)
		FROM tblovvordenventavehiculo ovv
			LEFT JOIN tblfacfactura fac
			ON fac.OvvId = ovv.OvvId
			LEFT JOIN tblbolboleta bol
			ON bol.OvvId = ovv.OvvId
		WHERE ovv.EinId = fin.EinId
		LIMIT 1
		),730), "%d/%m/%Y") AS FinPromocionFechaVencimiento,
		
		
		(
			SELECT 
			COUNT(fin2.FinId)
			FROM tblfinfichaingreso fin2
			WHERE fin2.EinId = fin.EinId
			AND EXISTS (
				SELECT 
				fim.FimId 
				FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = fin2.FinId
				AND fim.MinId = "MIN-10001"
			)
			ORDER BY fin2.FinFecha DESC LIMIT 1
		
		) AS FinCantidadMantenimientos,
		
		ovv.OvvId AS FinOrdenVentaVehiculo,
		
		(
		SELECT 
			cpr.CprId
				FROM tblcprcotizacionproducto cpr
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprId,
		
		
		
		(
		SELECT 
		
		CONCAT(IFNULL(seg.CliNombre,"")," ",IFNULL(seg.CliApellidoPaterno,"")," ",IFNULL(seg.CliApellidoMaterno,""))
		
        FROM tblcprcotizacionproducto cpr
		
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						
						
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprSeguro,
		
		
		(
		SELECT 
		
		seg.CliArchivo
		
        FROM tblcprcotizacionproducto cpr
		
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						
						
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprSeguroFoto,
		
		
		tre.TreNombre,
		
		obs.ObsNombre,
		obs.ObsArchivo,
		obs.ObsFoto,
		
		
		
		(
		SELECT 
		
		vre.VreId
		
        FROM tblvrevehiculorecepcion vre
			
		WHERE vre.EinId = ein.EinId
		AND vre.VreEstado = 3
			ORDER BY vre.VreTiempoCreacion DESC
		LIMIT 1
		)  AS VreId,

		onc.OncNombre,
		ovm.OvmKilometraje,
		min.MinNombre,
		fim.MinId
		
        FROM tblfinfichaingreso fin
				LEFT JOIN tblclicliente cli
				ON fin.CliId = cli.CliId
					LEFT JOIN tbllticlientetipo lti
					ON cli.LtiId = lti.LtiId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
								LEFT JOIN tbloncconcesionario onc
								ON ein.OncId = onc.OncId
								
								LEFT JOIN tblvehvehiculo veh
								ON ein.VehId = veh.VehId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
											LEFT JOIN tblvmavehiculomarca vma
											ON vmo.VmaId = vma.VmaId
											
												LEFT JOIN tblperpersonal per2
												ON fin.PerIdAsesor = per2.PerId

													LEFT JOIN tblcamcampana cam
													ON fin.CamId = cam.CamId

														LEFT JOIN tblovvordenventavehiculo ovv
														ON fin.EinId = ovv.EinId
															
															LEFT JOIN tblobsobsequio obs
															ON fin.ObsId = obs.ObsId
			LEFT JOIN tblperpersonal per
			ON fin.PerId = per.PerId
			
			LEFT JOIN tbltretiporeparacion tre
			ON fin.TreId = tre.TreId
			
			LEFT JOIN tblovmordenventavehiculomantenimiento ovm
			ON fin.OvmId = ovm.OvmId
			
			LEFT JOIN tblfimfichaingresomodalidad fim
			ON fin.FinId = fim.FinId
				LEFT JOIN tblminmodalidadingreso min
				ON fim.MinId = min.MinId
			
        WHERE fin.FinId = "' . $this->FinId . '"';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			//002 SERVICIOS
			//001 REPUESTOS
			//000

			//OT-2018-0002-AQPPI
			//OT-2018-0002-AQPPA
			//OT-2018-0002-PUNJU
			//OT-2018-0002-PUNJU

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$this->FinId = $fila['FinId'];
				$this->FinId2 = $fila['FinId2'];
				$this->SucId = $fila['SucId'];

				$this->CliId = $fila['CliId'];
				$this->EinId = $fila['EinId'];
				$this->CamId = $fila['CamId'];
				$this->OvvId = $fila['OvvId'];
				$this->ObsId = $fila['ObsId'];
				$this->OvmId = $fila['OvmId'];

				$this->PmaId = $fila['PmaId'];

				$this->TreId = $fila['TreId'];

				$this->MonId = $fila['MonId'];
				$this->FinTipoCambio = $fila['FinTipoCambio'];


				$this->PerId = $fila['PerId'];
				$this->PerIdAsesor = $fila['PerIdAsesor'];

				$this->FinManoObraPrecio = $fila['FinManoObraPrecio'];

				$this->FinConductor = $fila['FinConductor'];
				$this->FinTelefono = $fila['FinTelefono'];
				//$this->FinCelular = $fila['FinCelular'];
				$this->FinDireccion = $fila['FinDireccion'];
				$this->FinContacto = $fila['FinContacto'];

				$this->FinClienteEmail = $fila['FinClienteEmail'];

				$this->FinFecha = $fila['NFinFecha'];
				$this->FinVentaFechaEntrega = $fila['NFinVentaFechaEntrega'];

				$this->FinFechaGarantia = $fila['NFinFechaGarantia'];
				$this->FinFechaActividad = $fila['NFinFechaActividad'];
				$this->FinFechaCita = $fila['NFinFechaCita'];

				$this->FinFechaEntrega = $fila['NFinFechaEntrega'];
				$this->FinHoraEntrega = $fila['FinHoraEntrega'];

				$this->FinFechaEntregaExtendida = $fila['NFinFechaEntregaExtendida'];
				$this->FinHoraEntregaExtendida = $fila['FinHoraEntregaExtendida'];

				$this->FinHora = $fila['FinHora'];
				$this->FinPlaca = $fila['FinPlaca'];

				$this->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];
				$this->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
				$this->FinObservacion = $fila['FinObservacion'];

				$this->FinExteriorDelantero1 = $fila['FinExteriorDelantero1'];
				$this->FinExteriorDelantero2 = $fila['FinExteriorDelantero2'];
				$this->FinExteriorDelantero3 = $fila['FinExteriorDelantero3'];
				$this->FinExteriorDelantero4 = $fila['FinExteriorDelantero4'];
				$this->FinExteriorDelantero5 = $fila['FinExteriorDelantero5'];
				$this->FinExteriorDelantero6 = $fila['FinExteriorDelantero6'];
				$this->FinExteriorDelantero7 = $fila['FinExteriorDelantero7'];

				$this->FinExteriorPosterior1 = $fila['FinExteriorPosterior1'];
				$this->FinExteriorPosterior2 = $fila['FinExteriorPosterior2'];
				$this->FinExteriorPosterior3 = $fila['FinExteriorPosterior3'];
				$this->FinExteriorPosterior4 = $fila['FinExteriorPosterior4'];
				$this->FinExteriorPosterior5 = $fila['FinExteriorPosterior5'];
				$this->FinExteriorPosterior6 = $fila['FinExteriorPosterior6'];

				$this->FinExteriorDerecho1 = $fila['FinExteriorDerecho1'];
				$this->FinExteriorDerecho2 = $fila['FinExteriorDerecho2'];
				$this->FinExteriorDerecho3 = $fila['FinExteriorDerecho3'];
				$this->FinExteriorDerecho4 = $fila['FinExteriorDerecho4'];
				$this->FinExteriorDerecho5 = $fila['FinExteriorDerecho5'];
				$this->FinExteriorDerecho6 = $fila['FinExteriorDerecho6'];
				$this->FinExteriorDerecho7 = $fila['FinExteriorDerecho7'];
				$this->FinExteriorDerecho8 = $fila['FinExteriorDerecho8'];

				$this->FinExteriorIzquierdo1 = $fila['FinExteriorIzquierdo1'];
				$this->FinExteriorIzquierdo2 = $fila['FinExteriorIzquierdo2'];
				$this->FinExteriorIzquierdo3 = $fila['FinExteriorIzquierdo3'];
				$this->FinExteriorIzquierdo4 = $fila['FinExteriorIzquierdo4'];
				$this->FinExteriorIzquierdo5 = $fila['FinExteriorIzquierdo5'];
				$this->FinExteriorIzquierdo6 = $fila['FinExteriorIzquierdo6'];
				$this->FinExteriorIzquierdo7 = $fila['FinExteriorIzquierdo7'];

				$this->FinInterior1 = $fila['FinInterior1'];
				$this->FinInterior2 = $fila['FinInterior2'];
				$this->FinInterior3 = $fila['FinInterior3'];
				$this->FinInterior4 = $fila['FinInterior4'];
				$this->FinInterior5 = $fila['FinInterior5'];
				$this->FinInterior6 = $fila['FinInterior6'];
				$this->FinInterior7 = $fila['FinInterior7'];
				$this->FinInterior8 = $fila['FinInterior8'];
				$this->FinInterior9 = $fila['FinInterior9'];
				$this->FinInterior10 = $fila['FinInterior10'];
				$this->FinInterior11 = $fila['FinInterior11'];
				$this->FinInterior12 = $fila['FinInterior12'];
				$this->FinInterior13 = $fila['FinInterior13'];
				$this->FinInterior14 = $fila['FinInterior14'];
				$this->FinInterior15 = $fila['FinInterior15'];
				$this->FinInterior16 = $fila['FinInterior16'];
				$this->FinInterior17 = $fila['FinInterior17'];
				$this->FinInterior18 = $fila['FinInterior18'];
				$this->FinInterior19 = $fila['FinInterior19'];
				$this->FinInterior20 = $fila['FinInterior20'];
				$this->FinInterior21 = $fila['FinInterior21'];
				$this->FinInterior22 = $fila['FinInterior22'];
				$this->FinInterior23 = $fila['FinInterior23'];
				$this->FinInterior24 = $fila['FinInterior24'];
				$this->FinInterior25 = $fila['FinInterior25'];
				$this->FinInterior26 = $fila['FinInterior26'];
				$this->FinInterior27 = $fila['FinInterior27'];

				$this->FinNota = $fila['FinNota'];

				$this->FinInformeTecnicoMantenimiento = $fila['FinInformeTecnicoMantenimiento'];
				$this->FinInformeTecnicoRevision = $fila['FinInformeTecnicoRevision'];
				$this->FinInformeTecnicoDiagnostico = $fila['FinInformeTecnicoDiagnostico'];
				$this->FinTiempoTallerTrabajado = $fila['FinTiempoTallerTrabajado'];

				$this->FinSalidaFecha = $fila['NFinSalidaFecha'];
				$this->FinSalidaHora = $fila['FinSalidaHora'];
				$this->FinSalidaObservacion = $fila['FinSalidaObservacion'];
				$this->FinSalidaObservacionInterna = $fila['FinSalidaObservacionInterna'];
				$this->FinTerminadoObservacion = $fila['FinTerminadoObservacion'];
				$this->FinAlmacenObservacion = $fila['FinAlmacenObservacion'];
				$this->FinTallerObservacion = $fila['FinTallerObservacion'];

				$this->FinActaEntrega = $fila['FinActaEntrega'];
				$this->FinActaEntregaFecha = $fila['NFinActaEntregaFecha'];



				$this->FinPrioridad = $fila['FinPrioridad'];

				$this->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];
				$this->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
				$this->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];

				$this->FinInformeTecnico = $fila['FinInformeTecnico'];


				$this->FinFotoVIN = $fila['FinFotoVIN'];
				$this->FinFotoFrontal = $fila['FinFotoFrontal'];
				$this->FinFotoCupon = $fila['FinFotoCupon'];
				$this->FinFotoMantenimiento = $fila['FinFotoMantenimiento'];

				$this->FinMontoPresupuesto = $fila['FinMontoPresupuesto'];
				$this->FinTipo = $fila['FinTipo'];
				$this->FinOrigenEntrega = $fila['FinOrigenEntrega'];
				$this->FinIndicacionTecnico = $fila['FinIndicacionTecnico'];
				$this->FinReferencia = $fila['FinReferencia'];

				$this->FinCierre = $fila['FinCierre'];
				$this->FinCita = $fila['FinCita'];

				$this->FinEstado = $fila['FinEstado'];
				$this->FinTiempoCreacion = $fila['NFinTiempoCreacion'];
				$this->FinTiempoModificacion = $fila['NFinTiempoModificacion'];

				$this->FinFechaVenta = $fila['FinFechaVenta'];
				$this->FinPromocionFechaVencimiento = $fila['FinPromocionFechaVencimiento'];
				$this->FinCantidadMantenimientos = $fila['FinCantidadMantenimientos'];

				$this->MinNombre = $fila['MinNombre'] ?? '';
				$this->MinId = $fila['MinId'] ?? '';



				$this->CliCSIIncluir = $fila['CliCSIIncluir'];

				$this->TdoId = $fila['TdoId'];
				$this->CliNombreCompleto = $fila['CliNombreCompleto'];
				$this->CliNombre = $fila['CliNombre'];
				$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];

				$this->CliDireccion = $fila['CliDireccion'];
				$this->CliDepartamento = $fila['CliDepartamento'];
				$this->CliProvincia = $fila['CliProvincia'];
				$this->CliDistrito = $fila['CliDistrito'];
				$this->CliTelefono = $fila['CliTelefono'];
				$this->CliCelular = $fila['CliCelular'];

				$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];

				$this->TdoNombre = $fila['TdoNombre'];
				$this->LtiId = $fila['LtiId'];

				$this->LtiUtilidad = $fila['LtiUtilidad'];
				$this->LtiNombre = $fila['LtiNombre'];
				$this->LtiAbreviatura = $fila['LtiAbreviatura'];



				$this->EinVIN = $fila['EinVIN'];
				$this->VmaId = $fila['VmaId'];
				$this->VmoId = $fila['VmoId'];
				$this->VveId = $fila['VveId'];
				$this->EinAnoFabricacion = $fila['EinAnoFabricacion'];
				$this->EinPlaca = $fila['EinPlaca'];
				$this->EinColor = $fila['EinColor'];

				$this->VmaNombre = $fila['VmaNombre'];
				$this->VmoNombre = $fila['VmoNombre'];
				$this->VveNombre = $fila['VveNombre'];

				$this->PerFoto = $fila['PerFoto'];
				$this->PerNombre = $fila['PerNombre'];
				$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
				$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];

				$this->PerNombreAsesor = $fila['PerNombreAsesor'];
				$this->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
				$this->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];
				$this->PerNumeroDocumentoAsesor = $fila['PerNumeroDocumentoAsesor'];
				$this->PerCelularAsesor = $fila['PerCelularAsesor'];
				$this->PerEmailAsesor = $fila['PerEmailAsesor'];

				$this->CamCodigo = $fila['CamCodigo'];
				$this->CamNombre = $fila['CamNombre'];
				$this->CamBoletin = $fila['CamBoletin'];

				$this->OncNombre = $fila['OncNombre'];

				$this->FinTallerExterno = $fila['FinTallerExterno'];

				$this->FinCotizacionProducto = $fila['FinCotizacionProducto'];

				$this->FinOrdenVentaVehiculo = $fila['FinOrdenVentaVehiculo'];

				$this->CprId = $fila['CprId'];
				$this->CprSeguro = $fila['CprSeguro'];
				$this->CprSeguroFoto = $fila['CprSeguroFoto'];

				$this->TreNombre = $fila['TreNombre'];

				$this->ObsNombre = $fila['ObsNombre'];
				$this->ObsArchivo = $fila['ObsArchivo'];
				$this->ObsFoto = $fila['ObsFoto'];

				$this->VreId = $fila['VreId'];

				$this->OncNombre = $fila['OncNombre'];
				$this->OvmKilometraje = $fila['OvmKilometraje'];


				switch ($this->FinPrioridad) {

					case 1:
						$this->FinPrioridadColor  = "#FFFFFF";
						break;

					case 2:
						$this->FinPrioridadColor  = "#FF0000";
						break;
				}

				$Estado = "";

				switch ($this->FinEstado) {

					case 777:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/anulado.png' alt='ANULADO' border='0' width='20' height='20' title='Anulado' > [Anulado]";
						break;


					case 1:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Pendiente]";
						break;

					case 11:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Enviado]";
						break;

					case 2:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Revisando]";
						break;

					case 3:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Preparando Pedido]";
						break;

					case 4:

						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller" . (($this->FinTallerExterno == "Si") ? "2" : "") . ".png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Pedido Enviado]";

						break;

					case 5:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisado Pedido]";
						break;

					case 6:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Preparando Pedido]";
						break;

					case 7:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Pedido Enviado]";
						break;


					case 71:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller" . (($this->FinTallerExterno == "Si") ? "3" : "") . ".png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Pedido Recibido]";
						break;


					case 72:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Pedido Extornado]";
						break;


					case 73:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Trabajo Terminado]";
						break;

					case 74:
						//$Estado = "<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Revisando]";
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Trabajo Terminado]";
						break;

					case 75:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Conforme/Por Facturar]";
						break;


					case 8:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Por Facturar]";
						break;

					case 89:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Parcialmente Facturado]"; //OJO
						break;

					case 9:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";
						break;

					case 10:
						$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/no_facturable.png' alt='NO FACTURABLE' border='0' width='20' height='20' title='NO FACTURABLE' > [No Boletable]";
						break;

					default:
						$Estado = "";
						break;
				}

				$this->FinEstadoDescripcion = $Estado;


				if ($oCompleto) {

					$InsFichaIngresoLlamada = new ClsFichaIngresoLlamada($this->InsMysql);
					$ResFichaIngresoLlamada =  $InsFichaIngresoLlamada->MtdObtenerFichaIngresoLlamadas(NULL, NULL, "FllId", "ASC", NULL, $this->FinId, NULL);
					$this->FichaIngresoLlamada = 	$ResFichaIngresoLlamada['Datos'];


					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
					$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL, NULL, 'FimId', 'ASC', NULL, $this->FinId, NULL);
					$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];



					$InsFichaIngresoHerramienta = new ClsFichaIngresoHerramienta($this->InsMysql);
					$ResFichaIngresoHerramienta = $InsFichaIngresoHerramienta->MtdObtenerFichaIngresoHerramientas(NULL, NULL, 'FihId', 'ASC', NULL, $this->FinId, NULL);
					$this->FichaIngresoHerramienta = $ResFichaIngresoHerramienta['Datos'];

					$InsFichaIngresoGasto = new ClsFichaIngresoGasto($this->InsMysql);
					$ResFichaIngresoGasto = $InsFichaIngresoGasto->MtdObtenerFichaIngresoGastos(NULL, NULL, 'FigId', 'ASC', NULL, $this->FinId, NULL);
					$this->FichaIngresoGasto = $ResFichaIngresoGasto['Datos'];

					//	$InsFichaIngresoAlmacenMovimientoEntrada = new ClsFichaIngresoAlmacenMovimientoEntrada();
					//			$ResFichaIngresoAlmacenMovimientoEntrada = $InsFichaIngresoAlmacenMovimientoEntrada->MtdObtenerFichaIngresoAlmacenMovimientoEntradas(NULL,NULL,'FilId','ASC',NULL,$this->FinId,NULL);
					//			$this->FichaIngresoAlmacenMovimientoEntrada = $ResFichaIngresoAlmacenMovimientoEntrada['Datos'];
					//			

					//			$InsFichaIngresoManoObra = new ClsFichaIngresoManoObra();
					//			//MtdObtenerFichaIngresoManoObras($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL)
					//			$ResFichaIngresoManoObra = $InsFichaIngresoManoObra->MtdObtenerFichaIngresoManoObras(NULL,NULL,'FmoId','ASC',NULL,$this->FinId,NULL);
					//			$this->FichaIngresoManoObra = $ResFichaIngresoManoObra['Datos'];
					//			

					$InsFichaIngresoTarea = new ClsFichaIngresoTarea($this->InsMysql);
					$InsFichaIngresoProducto = new ClsFichaIngresoProducto($this->InsMysql);
					$InsFichaIngresoSuministro = new ClsFichaIngresoSuministro($this->InsMysql);
					$InsFichaIngresoMantenimiento = new ClsFichaIngresoMantenimiento($this->InsMysql);
					$InsPreEntregaDetalle = new ClsPreEntregaDetalle($this->InsMysql);
					$InsFichaAccion = new ClsFichaAccion($this->InsMysql);

					$InsFichaAccionSalidaExterna = new ClsFichaAccionSalidaExterna($this->InsMysql);
					$InsFichaAccionFoto = new ClsFichaAccionFoto($this->InsMysql);
					$InsFichaAccionTarea = new ClsFichaAccionTarea($this->InsMysql);
					$InsFichaAccionTempario = new ClsFichaAccionTempario($this->InsMysql);
					$InsFichaAccionProducto = new ClsFichaAccionProducto($this->InsMysql);
					$InsFichaAccionMantenimiento = new ClsFichaAccionMantenimiento($this->InsMysql);
					$InsFichaAccionSuministro = new ClsFichaAccionSuministro($this->InsMysql);

					$InsTallerPedido = new ClsTallerPedido($this->InsMysql);
					$InsTallerPedidoDetalle = new ClsTallerPedidoDetalle($this->InsMysql);

					//echo "<h1>".count($ArrFichaIngresoModalidades )."</h1>";

					$i = 1;

					$this->FichaIngresoModalidad = array();

					// MtdObtenerPreEntregaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RedId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oAccion=NULL) 
					//MtdObtenerPreEntregaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RedId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oAccion=NULL
					$ResPreEntregaDetalle = $InsPreEntregaDetalle->MtdObtenerPreEntregaDetalles(NULL, NULL, 'RedId', 'ASC', NULL, $this->FinId, NULL);
					$this->PreEntregaDetalle = $ResPreEntregaDetalle['Datos'];



					foreach ($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad) {



						$ResFichaIngresoTarea = $InsFichaIngresoTarea->MtdObtenerFichaIngresoTareas(NULL, NULL, 'FitId', 'ASC', NULL, $DatFichaIngresoModalidad->FimId, NULL);
						$DatFichaIngresoModalidad->FichaIngresoTarea = $ResFichaIngresoTarea['Datos'];


						$ResFichaIngresoProducto = $InsFichaIngresoProducto->MtdObtenerFichaIngresoProductos(NULL, NULL, 'FipId', 'ASC', NULL, $DatFichaIngresoModalidad->FimId, NULL);
						$DatFichaIngresoModalidad->FichaIngresoProducto = $ResFichaIngresoProducto['Datos'];

						$ResFichaIngresoSuministro = $InsFichaIngresoSuministro->MtdObtenerFichaIngresoSuministros(NULL, NULL, 'FisId', 'ASC', NULL, $DatFichaIngresoModalidad->FimId, NULL);
						$DatFichaIngresoModalidad->FichaIngresoSuministro = $ResFichaIngresoSuministro['Datos'];

						$ResFichaIngresoMantenimiento = $InsFichaIngresoMantenimiento->MtdObtenerFichaIngresoMantenimientos(NULL, NULL, 'FiaId', 'ASC', NULL, $DatFichaIngresoModalidad->FimId, NULL, NULL, false, NULL);
						$DatFichaIngresoModalidad->FichaIngresoMantenimiento = $ResFichaIngresoMantenimiento['Datos'];






						$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL, NULL, NULL, 'FccId', 'ASC', '1', $DatFichaIngresoModalidad->FimId, NULL, NULL, NULL);
						$ArrFichaAcciones = $ResFichaAccion['Datos'];




						foreach ($ArrFichaAcciones as $DatFichaAccion) {

							$ResFichaAccionSalidaExterna = $InsFichaAccionSalidaExterna->MtdObtenerFichaAccionSalidaExternas(NULL, NULL, 'FsxId', 'ASC', NULL, $DatFichaAccion->FccId, NULL);
							$DatFichaAccion->FichaAccionSalidaExterna = $ResFichaAccionSalidaExterna['Datos'];


							$ResFichaAccionFoto = $InsFichaAccionFoto->MtdObtenerFichaAccionFotos(NULL, NULL, 'FafId', 'ASC', NULL, $DatFichaAccion->FccId, NULL);
							$DatFichaAccion->FichaAccionFoto = $ResFichaAccionFoto['Datos'];

							$ResFichaAccionTarea = $InsFichaAccionTarea->MtdObtenerFichaAccionTareas(NULL, NULL, 'FatId', 'ASC', NULL, $DatFichaAccion->FccId, NULL);
							$DatFichaAccion->FichaAccionTarea = $ResFichaAccionTarea['Datos'];

							$ResFichaAccionTempario = $InsFichaAccionTempario->MtdObtenerFichaAccionTemparios(NULL, NULL, NULL, 'FaeId', 'ASC', NULL, $DatFichaAccion->FccId, NULL);
							$DatFichaAccion->FichaAccionTempario = $ResFichaAccionTempario['Datos'];

							////MtdObtenerFichaAccionProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FapId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oFichaAccionMantenimiento=NULL,$oEstricto=1)
							$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL, NULL, 'FapId', 'ASC', NULL, $DatFichaAccion->FccId, NULL, NULL, 1);
							$DatFichaAccion->FichaAccionProducto = $ResFichaAccionProducto['Datos'];


							//MtdObtenerFichaAccionMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FaaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oNivel=NULL,$oSevero=false,$oAccion=NULL)

							//deb($DatFichaAccion->FccId);
							$ResFichaAccionMantenimiento = $InsFichaAccionMantenimiento->MtdObtenerFichaAccionMantenimientos(NULL, NULL, 'pmt.PmtOrden', 'ASC', NULL, $DatFichaAccion->FccId, NULL, NULL, false, NULL);
							$DatFichaAccion->FichaAccionMantenimiento = $ResFichaAccionMantenimiento['Datos'];

							$ResFichaAccionSuministro = $InsFichaAccionSuministro->MtdObtenerFichaAccionSuministros(NULL, NULL, 'FasId', 'Desc', NULL, $DatFichaAccion->FccId, NULL);
							$DatFichaAccion->FichaAccionSuministro = $ResFichaAccionSuministro['Datos'];

							$DatFichaIngresoModalidad->FichaAccion = $DatFichaAccion;


							$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL, NULL, NULL, 'AmoFecha', 'DESC', NULL, NULL, NULL, NULL, $DatFichaAccion->FccId);
							$ArrTallerPedidos = $ResTallerPedido['Datos'];

							$DatFichaIngresoModalidad->FichaAccion->TallerPedidoFicha = $ArrTallerPedidos;





							$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL, NULL, NULL, 'AmoFecha', 'DESC', '1', NULL, NULL, NULL, $DatFichaAccion->FccId);
							$ArrTallerPedidos = $ResTallerPedido['Datos'];
							//deb($ArrTallerPedidos);


							foreach ($ArrTallerPedidos as $DatTallerPedido) {

								$DatFichaIngresoModalidad->FichaAccion->TallerPedido = $DatTallerPedido;

								//MtdObtenerTallerPedidoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTallerPedido=NULL,$oEstado=NULL,$oProducto=NULL,$oTallerPedidoEstado=NULL,$oVehiculoMarca=NULL,$oProductoTipo=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {
								$ResTallerPedidoDetalle =  $InsTallerPedidoDetalle->MtdObtenerTallerPedidoDetalles(NULL, NULL, NULL, NULL, NULL, NULL, $DatTallerPedido->AmoId);
								$DatFichaIngresoModalidad->FichaAccion->TallerPedido->TallerPedidoDetalle = $ResTallerPedidoDetalle['Datos'];
							}
						}

						//echo "<h3>".$i."</h3>";

						$this->FichaIngresoModalidad[] = $DatFichaIngresoModalidad;
						$i++;
					}
					//
				}
			}

			//echo "<h1>:::".count($this->FichaIngresoModalidad )."</h1>";

			//deb($this->FichaIngresoModalidad);


			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}



	public function MtdObtenerFichaIngresoEstado()
	{


		$sql = 'SELECT 
        fin.FinId,  	
		fin.FinEstado
		
        FROM tblfinfichaingreso fin
				LEFT JOIN tblclicliente cli
				ON fin.CliId = cli.CliId
					LEFT JOIN tbllticlientetipo lti
					ON cli.LtiId = lti.LtiId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
								LEFT JOIN tblvehvehiculo veh
								ON ein.VehId = veh.VehId
									LEFT JOIN tblvvevehiculoversion vve
									ON ein.VveId = vve.VveId
										LEFT JOIN tblvmovehiculomodelo vmo
										ON vve.VmoId = vmo.VmoId
											LEFT JOIN tblvmavehiculomarca vma
											ON vmo.VmaId = vma.VmaId
												
			LEFT JOIN tblperpersonal per
			ON fin.PerId = per.PerId
			
        WHERE fin.FinId = "' . $this->FinId . '"';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$this->FinId = $fila['FinId'];
				$this->FinEstado = $fila['FinEstado'];
			}



			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerFichaIngresoMantenimientos($oVehiculoIngreso, $oMantenimientoKilometraje)
	{

		$ResFichaIngreso = $this->MtdObtenerFichaIngresos("FinMantenimientoKilometraje", "esigual", $oMantenimientoKilometraje, 'FinId', 'DESC', '1', NULL, NULL, NULL, NULL, "MIN-10001", NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, $oVehiculoIngreso, 0, NULL);
		$ArrFichaIngresos = $ResFichaIngreso['Datos'];

		if (!empty($ArrFichaIngresos)) {
			foreach ($ArrFichaIngresos as $DatFichaIngreso) {
				$this->FinId = $DatFichaIngreso->FinId;
				$this->FinFecha = $DatFichaIngreso->FinFecha;
				$this->SucNombre = $DatFichaIngreso->SucNombre;
			}
		}
	} //454545 alo 45

	public function MtdObtenerFichaIngresos($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FinId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oEstado = NULL, $oPrioridad = NULL, $oModalidadIngreso = NULL, $oVIN = NULL, $oCliente = NULL, $oPersonalId = NULL, $oTrabajoConcluido = 0, $oCampana = NULL, $oClienteTipo = NULL, $oTipo = NULL, $oSalidaExterna = 0, $oConCampana = NULL, $oVehiculoIngreso = NULL, $oConConcluido = 0, $oTipoReparacion = NULL, $oPersonalIdAsesor = NULL, $oVehiculoMarca = NULL, $oCodigoOriginal = NULL, $oSucursal = NULL, $oMigrado = true)
	{

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fecha = '';
		$estado = '';
		$prioridad = '';
		$mingreso = '';
		$vin = '';
		$cliente = '';
		$personal = '';
		$campana = '';
		$tconcluido = '';
		$treparacion = '';
		$cltipo = '';
		$tipo = '';
		$sexterna = '';
		$ccampana = '';
		$eingreso = '';
		$vmarca = '';
		$pasesor = '';
		$coriginal = '';
		$sucursal = '';
		$migrado = '';

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
					amd.AmdId
					FROM tblamdalmacenmovimientodetalle amd
						LEFT JOIN tblamoalmacenmovimiento amo
						ON amd.AmoId = amo.AmoId
							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
									LEFT JOIN tblproproducto pro
									ON amd.ProId = pro.ProId
						
					WHERE 
						fim.FinId = fin.FinId
						AND 
						(
						pro.ProCodigoOriginal LIKE "%' . $oFiltro . '%" OR
						pro.ProNombre LIKE "%' . $oFiltro . '%" 
						
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

				' . (($oTrabajoConcluido == 1) ? ' OR fin.FinTiempoTallerConcluido IS NOT NULL' : '') . '
			)
			';
		}

		//		if(!empty($oEstado)){
		//			$estado = ' AND fin.FinEstado = '.$oEstado;
		//		}


		if (!empty($oPrioridad)) {
			$prioridad = ' AND fin.FinPrioridad = ' . $oPrioridad;
		}

		/*		if(!empty($oModalidadIngresos)){
			$mingreso = ' AND EXISTS (
				SELECT fim.FimId
					FROM tblfimfichaingresomodalidad fim
					WHERE fim.MinId = "'.$oModalidadIngreso.'"
					AND fim.FinId = fin.FinId
				LIMIT 1
			) ';
		}	*/


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


		if (!empty($oVIN)) {
			$vin = ' AND ein.EinVIN = "' . $oVIN . '"';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND fin.CliId = "' . $oCliente . '"';
		}

		if (!empty($oPersonalId)) {
			$personal = ' AND fin.PerId = "' . $oPersonalId . '"';
		}

		if (!empty($oCampana)) {
			$campana = ' AND fin.CamId = "' . $oCampana . '"';
		}

		if (!empty($oConConcluido)) {

			switch ($oConConcluido) {
				case 1:
					$tconcluido = ' AND fin.FinTiempoTallerConcluido IS NOT NULL';
					break;
				case 2:
					$tconcluido = ' AND fin.FinTiempoTallerConcluido IS NULL';
					break;
			}
		}

		if (!empty($oClienteTipo)) {

			$elementos = explode(",", $oClienteTipo);

			$i = 1;
			$cltipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$cltipo .= '  (cli.LtiId = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$cltipo .= ' OR ';
				}
				$i++;
			}

			$cltipo .= ' ) 
			)
			';
		}

		if (!empty($oTipo)) {
			$tipo = ' AND fin.FinTipo = "' . $oTipo . '"';
		}




		if (!empty($oSalidaExterna)) {

			switch ($oSalidaExterna) {
				case 1:

					$sexterna = ' AND 
						
								EXISTS (
									SELECT 
						
									fsx.FsxId
									
									FROM tblfsxfichaaccionsalidaexterna fsx
			
										LEFT JOIN tblfccfichaaccion fcc
										ON fsx.FccId = fcc.FccId
											
											LEFT JOIN tblfimfichaingresomodalidad fim
											ON fcc.FimId = fim.FimId
											
											
								WHERE 
									 fim.FinId = fin.FinId
									AND fsx.FsxId IS NOT NULL
								
								)
								
						';



					break;

				case 2:

					$sexterna = ' AND 
						
								NOT EXISTS (
									SELECT 
						
									fsx.FsxId
									
									FROM tblfsxfichaaccionsalidaexterna fsx
			
										LEFT JOIN tblfccfichaaccion fcc
										ON fsx.FccId = fcc.FccId
											
											LEFT JOIN tblfimfichaingresomodalidad fim
											ON fcc.FimId = fim.FimId
											
											
								WHERE 
									 fim.FinId = fin.FinId
									AND fsx.FsxId IS NOT NULL
								
								)
								
						';

					break;

				default:

					break;
			}
		}


		if (!empty($oConCampana)) {

			switch ($oConCampana) {
				case 1:
					$ccampana = ' AND fin.CamId IS NOT NULL';
					break;

				case 2:
					$ccampana = ' AND fin.CamId IS  NULL';
					break;
			}
		}

		if (!empty($oVehiculoIngreso)) {
			$eingreso = ' AND fin.EinId = "' . $oVehiculoIngreso . '"';
		}

		if (!empty($oTipoReparacion)) {
			$treparacion = ' AND fin.TreId = "' . $oTipoReparacion . '"';
		}


		if (!empty($oPersonalIdAsesor)) {
			$pasesor = ' AND fin.PerIdAsesor = "' . $oPersonalIdAsesor . '"';
		}



		if (!empty($oCodigoOriginal)) {
			$coriginal = ' 
			
				
			AND EXISTS(
			
				SELECT 
				amd.AmdId
				FROM tblamdalmacenmovimientodetalle amd
				LEFT JOIN tblproproducto pro
				ON amd.ProId = pro .ProId
				LEFT JOIN tblamoalmacenmovimiento amo
				ON amd.AmoId = amo.AmoId
				LEFT JOIN tblfccfichaaccion fcc
				ON amo.FccId = fcc.FccId
				LEFT JOIN tblfimfichaingresomodalidad fim
				ON fcc.FimId = fim.FimId
				WHERE fim.FinId = fin.FinId
				AND pro.ProCodigoOriginal LIKE "%' . $oCodigoOriginal . '%"
			
			LIMIT 1
			
			)
			';
		}


		if (!empty($oSucursal)) {
			$sucursal = ' AND fin.SucId = "' . $oSucursal . '"';
		}


		if ($oMigrado) {
			$migrado = '  AND FinMigrado IS NULL ';
		}

		if (!empty($oVehiculoMarca)) {
			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fin.FinId,
				fin.SucId,
				
				fin.CitId,
				
				fin.CliId,				
				fin.EinId,
				fin.CamId,
				fin.OvvId,
				fin.ObsId,
				fin.OvmId,

				fin.TreId,
				
				fin.MonId,
				fin.FinTipoCambio,
				
				fin.PerId,
				fin.PerIdAsesor,
				
				fin.FinManoObraPrecio,

				fin.FinConductor,
				fin.FinTelefono,
				fin.FinDireccion,
				fin.FinContacto,
				fin.FinClienteEmail,
				
				DATE_FORMAT(fin.FinFecha, "%d/%m/%Y") AS "NFinFecha",
				DATE_FORMAT(fin.FinVentaFechaEntrega, "%d/%m/%Y") AS "NFinVentaFechaEntrega",
				DATEDIFF(DATE(NOW()),fin.FinFecha) AS FinDiaTranscurrido,
				
				DATE_FORMAT(fin.FinFechaActividad, "%d/%m/%Y") AS "NFinFechaActividad",
				DATE_FORMAT(fin.FinFechaGarantia, "%d/%m/%Y") AS "NFinFechaGarantia",				
				DATEDIFF(DATE(NOW()),fin.FinFechaGarantia) AS FinGarantiaDiaTranscurrido,			
				DATE_FORMAT(fin.FinFechaCita, "%d/%m/%Y") AS "NFinFechaCita",
				
				DATE_FORMAT(fin.FinFechaEntrega, "%d/%m/%Y") AS "NFinFechaEntrega",
				fin.FinHoraEntrega,

				DATE_FORMAT(fin.FinFechaEntregaExtendida, "%d/%m/%Y") AS "NFinFechaEntregaExtendida",
				fin.FinHoraEntregaExtendida,
				
				fin.FinHora,
				fin.FinPlaca,

				fin.FinMantenimientoKilometraje,
				fin.FinVehiculoKilometraje,
				fin.FinObservacion,				
				
				
				fin.FinExteriorDelantero1,
				fin.FinExteriorDelantero2,
				fin.FinExteriorDelantero3,
				fin.FinExteriorDelantero4,
				fin.FinExteriorDelantero5,
				fin.FinExteriorDelantero6,
				fin.FinExteriorDelantero7,
				
				fin.FinExteriorPosterior1,
				fin.FinExteriorPosterior2,
				fin.FinExteriorPosterior3,
				fin.FinExteriorPosterior4,
				fin.FinExteriorPosterior5,
				fin.FinExteriorPosterior6,
				
				fin.FinExteriorDerecho1,
				fin.FinExteriorDerecho2,
				fin.FinExteriorDerecho3,
				fin.FinExteriorDerecho4,
				fin.FinExteriorDerecho5,
				fin.FinExteriorDerecho6,
				fin.FinExteriorDerecho7,
				fin.FinExteriorDerecho8,
				
				fin.FinExteriorIzquierdo1,
				fin.FinExteriorIzquierdo2,
				fin.FinExteriorIzquierdo3,
				fin.FinExteriorIzquierdo4,
				fin.FinExteriorIzquierdo5,
				fin.FinExteriorIzquierdo6,
				fin.FinExteriorIzquierdo7,
				
				
				fin.FinInterior1,
				fin.FinInterior2,
				fin.FinInterior3,
				fin.FinInterior4,
				fin.FinInterior5,
				fin.FinInterior6,
				fin.FinInterior7,
				fin.FinInterior8,
				fin.FinInterior9,
				fin.FinInterior10,
				fin.FinInterior11,
				fin.FinInterior12,
				fin.FinInterior13,
				fin.FinInterior14,
				fin.FinInterior15,
				fin.FinInterior16,
				fin.FinInterior17,
				fin.FinInterior18,
				fin.FinInterior19,
				fin.FinInterior20,
				fin.FinInterior21,
				fin.FinInterior22,
				fin.FinInterior23,
				fin.FinInterior24,
				fin.FinInterior25,
				fin.FinInterior26,
				fin.FinInterior27,

				fin.FinNota,
				
				fin.FinInformeTecnicoMantenimiento,
				fin.FinInformeTecnicoRevision,
				fin.FinInformeTecnicoDiagnostico,
				
				DATE_FORMAT(fin.FinSalidaFecha, "%d/%m/%Y") AS "NFinSalidaFecha",
				fin.FinSalidaHora,
				fin.FinSalidaObservacion,
				fin.FinSalidaObservacionInterna,
				
				fin.FinTerminadoObservacion,
				fin.FinAlmacenObservacion,
				fin.FinTallerObservacion,
				
				fin.FinActaEntrega,
				DATE_FORMAT(fin.FinActaEntregaFecha, "%d/%m/%Y") AS "NFinActaEntregaFecha",	
				
				CASE
				WHEN EXISTS (
					SELECT 
					ite.IteId 
					FROM tbliteinformetecnico ite
					WHERE ite.FinId = fin.FinId LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FinInformeTecnico,
		
				fin.FinPrioridad,
				
				DATE_FORMAT(fin.FinTiempoTallerConcluido, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerConcluido",
				DATE_FORMAT(fin.FinTiempoTallerRevisando, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTallerRevisando",
				DATE_FORMAT(fin.FinTiempoTrabajoTerminado, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoTrabajoTerminado",
				
				fin.FinFotoVIN,
				fin.FinFotoFrontal,
				fin.FinFotoCupon,
				fin.FinFotoMantenimiento,
				
				fin.FinMontoPresupuesto,
				fin.FinTipo,
				fin.FinOrigenEntrega,
				fin.FinIndicacionTecnico,
				
				fin.FinReferencia,
				fin.FinCierre,
				fin.FinCita,
				
				fin.FinEstado,
				DATE_FORMAT(fin.FinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoCreacion",
	        	DATE_FORMAT(fin.FinTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFinTiempoModificacion",

				cli.CliCSIIncluir,		
				cli.TdoId,
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliDireccion,
				cli.CliDepartamento,
				cli.CliProvincia,
				cli.CliDistrito,
				
				cli.CliNumeroDocumento,
				cli.CliCelular,
				cli.CliTelefono,
				
				
				lti.LtiUtilidad,
				lti.LtiNombre,
				lti.LtiAbreviatura,
				
				ein.EinVIN,
				ein.VmaId,
			vmo.VmaId,
		vve.VmoId,
		
				ein.EinAnoFabricacion,
				ein.EinPlaca,
				ein.EinColor,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre,
				
				
				per.PerFoto,
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				per2.PerNombre AS PerNombreAsesor,
				per2.PerApellidoPaterno AS PerApellidoPaternoAsesor,
				per2.PerApellidoMaterno AS PerApellidoMaternoAsesor,
				
				cam.CamCodigo,
				cam.CamNombre,
				cam.CamBoletin,
				


				
				CASE
				WHEN EXISTS (
					SELECT 
					fim.FimId
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblminmodalidadingreso min
						ON fim.MinId = min.MinId

					WHERE fim.FinId = fin.FinId
					AND min.MinSigla = "PP"
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FinPlanchadoPintado,
				
				
			
					(SELECT 
						COUNT(fim.FimId )
					FROM tblfimfichaingresomodalidad fim
					WHERE fim.FinId = fin.FinId)
					
				 AS FinModalidadCantidad,
				
				
				
				
				
				
				
					CASE
					WHEN EXISTS (
						SELECT 
			
						fsx.FsxId
						
						FROM tblfsxfichaaccionsalidaexterna fsx

							LEFT JOIN tblfccfichaaccion fcc
							ON fsx.FccId = fcc.FccId
								
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
								
					WHERE 
						 fim.FinId = fin.FinId
						AND fsx.FsxId IS NOT NULL
					
					) THEN "Si"
					ELSE "No"
					END AS FinTallerExterno,
					
		
					CASE
					WHEN EXISTS (
						SELECT 
			
						cpr.CprId
						
						FROM tblcprcotizacionproducto cpr
				
					WHERE 
						cpr.FinId = fin.FinId
					) THEN "Si"
					ELSE "No"
					END AS FinCotizacionProducto,
					
					
		
					CASE
					WHEN EXISTS (
						SELECT 
			
						amo.AmoId
						
						FROM tblamoalmacenmovimiento amo

							LEFT JOIN tblfccfichaaccion fcc
							ON amo.FccId = fcc.FccId
								
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
								
					WHERE 
						 fim.FinId = fin.FinId
					) THEN "Si"
					ELSE "No"
					END AS FinAlmacenMovimientoSalida,
					
					
					
					
					CASE
					WHEN EXISTS (
						SELECT 
			
						gar.GarId
						
						FROM tblgargarantia gar

							LEFT JOIN tblfccfichaaccion fcc
							ON gar.FccId = fcc.FccId
								
								
								LEFT JOIN tblfimfichaingresomodalidad fim
								ON fcc.FimId = fim.FimId
								
								
					WHERE 
						 fim.FinId = fin.FinId
					) THEN "Si"
					ELSE "No"
					END AS FinGarantia,
		
CASE
				WHEN EXISTS (
					SELECT 
					fim.FimId
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblminmodalidadingreso min
						ON fim.MinId = min.MinId

					WHERE fim.FinId = fin.FinId
					AND (min.MinSigla = "CA" OR min.MinSigla = "GA" OR min.MinSigla = "PO" OR min.MinSigla = "IF" OR min.MinSigla = "PP" OR min.MinSigla = "GR")
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FinGarantiaGenerar,
				
				
				
				
				
				
				(
					SELECT 
					DATE_FORMAT(fsx.FsxFechaFinalizacion, "%d/%m/%Y")
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblfsxfichaaccionsalidaexterna fsx
							ON fsx.FccId = fcc.FccId
						
					WHERE fim.FinId = fin.FinId
					LIMIT 1
				) AS FinFichaAccionSalidaExternaFechaFinalizacion,
				

				(
					SELECT 
					DATE_FORMAT(fsx.FsxFechaSalida, "%d/%m/%Y")
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblfsxfichaaccionsalidaexterna fsx
							ON fsx.FccId = fcc.FccId
						
					WHERE fim.FinId = fin.FinId
					LIMIT 1
				) AS FinFichaAccionSalidaExternaFechaSalida,
				
				

				(
					SELECT 
					fcc.FccComprobanteNumero
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
					WHERE fim.FinId = fin.FinId
					LIMIT 1
				) AS FinFichaAccionComprobanteNumero,	
				
				
				(
					SELECT 
					DATE_FORMAT(fcc.FccComprobanteFecha, "%d/%m/%Y")
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
					WHERE fim.FinId = fin.FinId
					LIMIT 1
				) AS FinFichaAccionComprobanteFecha		,
				
				
				
						(
			SELECT 
			COUNT(fin2.FinId)
			FROM tblfinfichaingreso fin2
			WHERE fin2.EinId = fin.EinId
			AND EXISTS (
				SELECT 
				fim.FimId 
				FROM tblfimfichaingresomodalidad fim
				WHERE fim.FinId = fin2.FinId
				AND fim.MinId = "MIN-10001"
			)
			ORDER BY fin2.FinFecha DESC LIMIT 1
		
		) AS FinCantidadMantenimientos,
		
		
				CASE
				WHEN EXISTS (
					SELECT 
					avi.AviId
					FROM tblaviaviso avi
						
					WHERE avi.EinId = fin.EinId
					AND avi.AviEstado = 3
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS FinTieneNota,
			
			
			
					
		(
		SELECT 
			cpr.CprId
				FROM tblcprcotizacionproducto cpr
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprId,
		
		
		
		(
		SELECT 
		
		CONCAT(IFNULL(seg.CliNombre,"")," ",IFNULL(seg.CliApellidoPaterno,"")," ",IFNULL(seg.CliApellidoMaterno,""))
		
        FROM tblcprcotizacionproducto cpr
		
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						
						
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprSeguro,
		
		
		(
		SELECT 
		
		seg.CliArchivo
		
        FROM tblcprcotizacionproducto cpr
		
						LEFT JOIN tblclicliente seg
						ON cpr.CliIdSeguro = seg.CliId
						
						
						
		WHERE cpr.FinId = fin.FinId
		AND cpr.CprEstado <> 6
			ORDER BY cpr.CprTiempoCreacion DESC
		LIMIT 1
		)  AS CprSeguroFoto,
		
		
		obs.ObsNombre,
		obs.ObsArchivo,
		obs.ObsFoto	,
		
		(
		SELECT 		
		enc.EncId		
        FROM tblencencuesta enc			
			WHERE enc.FinId = fin.FinId
			AND enc.EncEstado = 3
				ORDER BY enc.EncTiempoCreacion DESC
			LIMIT 1
		)  AS EncId,
		
		
				
		(
		SELECT 
		
		vre.VreId
		
        FROM tblvrevehiculorecepcion vre
			
		WHERE vre.EinId = ein.EinId
		AND vre.VreEstado = 3
			ORDER BY vre.VreTiempoCreacion DESC
		LIMIT 1
		)  AS VreId,
		
		onc.OncNombre,
		
		(
		SELECT
		SUM(IFNULL(fcc.FccManoObra,0))
		FROM tblfccfichaaccion fcc
		LEFT JOIN tblfimfichaingresomodalidad fim
		ON fcc.FimId = fim.fimId
		WHERE fim.FinId = fin.FinId
		LIMIT 1
		) AS FinFichaAccionManoObra,
		
		suc.SucNombre
				
				FROM tblfinfichaingreso fin
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
									
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvehvehiculo veh
										ON ein.VehId = veh.VehId
										
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
					
						LEFT JOIN tblcamcampana cam
						ON fin.CamId = cam.CamId
						
							LEFT JOIN tblobsobsequio obs
							ON fin.ObsId = obs.ObsId
						
						
							    LEFT JOIN tbloncconcesionario onc
								ON ein.OncId = onc.OncId
								
									LEFT JOIN tblsucsucursal suc
									ON fin.SucId = suc.SucId
			
			
				WHERE 1 = 1  ' . $migrado . $filtrar . $fecha . $estado . $coriginal . $prioridad . $vmarca . $pasesor . $mingreso . $vin . $cliente . $personal . $tconcluido . $campana . $treparacion . $sucursal . $cltipo . $tipo . $sexterna . $ccampana . $eingreso . $orden . $paginacion;
		//AND FinMigrado IS NULL	
		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsFichaIngreso = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$FichaIngreso = new $InsFichaIngreso();
			$FichaIngreso->FinId = $fila['FinId'];
			$FichaIngreso->SucId = $fila['SucId'];

			$FichaIngreso->CitId = $fila['CitId'];

			$FichaIngreso->CliId = $fila['CliId'];
			$FichaIngreso->EinId = $fila['EinId'];
			$FichaIngreso->CamId = $fila['CamId'];
			$FichaIngreso->OvvId = $fila['OvvId'];
			$FichaIngreso->ObsId = $fila['ObsId'];
			$FichaIngreso->OvmId = $fila['OvmId'];

			$FichaIngreso->TreId = $fila['TreId'];

			$FichaIngreso->MonId = $fila['MonId'];
			$FichaIngreso->FinTipoCambio = $fila['FinTipoCambio'];

			$FichaIngreso->PerId = $fila['PerId'];
			$FichaIngreso->PerIdAsesor = $fila['PerIdAsesor'];

			$FichaIngreso->FinManoObraPrecio = $fila['FinManoObraPrecio'];

			$FichaIngreso->FinConductor = $fila['FinConductor'];
			$FichaIngreso->FinTelefono = $fila['FinTelefono'];
			$FichaIngreso->FinDireccion = $fila['FinDireccion'];
			$FichaIngreso->FinContacto = $fila['FinContacto'];
			$FichaIngreso->FinClienteEmail = $fila['FinClienteEmail'];



			$FichaIngreso->FinFecha = $fila['NFinFecha'];
			$FichaIngreso->FinVentaFechaEntrega = $fila['NFinVentaFechaEntrega'];
			$FichaIngreso->FinDiaTranscurrido = $fila['FinDiaTranscurrido'];

			$FichaIngreso->FinFechaActividad = $fila['NFinFechaActividad'];
			$FichaIngreso->FinFechaGarantia = $fila['NFinFechaGarantia'];
			$FichaIngreso->FinGarantiaDiaTranscurrido = $fila['FinGarantiaDiaTranscurrido'];

			$FichaIngreso->FinFechaEntrega = $fila['NFinFechaEntrega'];
			$FichaIngreso->FinHoraEntrega = $fila['FinHoraEntrega'];

			$FichaIngreso->FinFechaEntregaExtendida = $fila['NFinFechaEntregaExtendida'];
			$FichaIngreso->FinHoraEntregaExtendida = $fila['FinHoraEntregaExtendida'];

			$FichaIngreso->FinFechaCita = $fila['NFinFechaCita'];

			$FichaIngreso->FinHora = $fila['FinHora'];
			$FichaIngreso->FinPlaca = $fila['FinPlaca'];

			$FichaIngreso->FinMantenimientoKilometraje = $fila['FinMantenimientoKilometraje'];
			$FichaIngreso->FinObservacion = $fila['FinObservacion'];
			$FichaIngreso->FinVehiculoKilometraje = $fila['FinVehiculoKilometraje'];

			$FichaIngreso->FinExteriorDelantero1 = $fila['FinExteriorDelantero1'];
			$FichaIngreso->FinExteriorDelantero2 = $fila['FinExteriorDelantero2'];
			$FichaIngreso->FinExteriorDelantero3 = $fila['FinExteriorDelantero3'];
			$FichaIngreso->FinExteriorDelantero4 = $fila['FinExteriorDelantero4'];
			$FichaIngreso->FinExteriorDelantero5 = $fila['FinExteriorDelantero5'];
			$FichaIngreso->FinExteriorDelantero6 = $fila['FinExteriorDelantero6'];
			$FichaIngreso->FinExteriorDelantero7 = $fila['FinExteriorDelantero7'];

			$FichaIngreso->FinExteriorPosterior1 = $fila['FinExteriorPosterior1'];
			$FichaIngreso->FinExteriorPosterior2 = $fila['FinExteriorPosterior2'];
			$FichaIngreso->FinExteriorPosterior3 = $fila['FinExteriorPosterior3'];
			$FichaIngreso->FinExteriorPosterior4 = $fila['FinExteriorPosterior4'];
			$FichaIngreso->FinExteriorPosterior5 = $fila['FinExteriorPosterior5'];
			$FichaIngreso->FinExteriorPosterior6 = $fila['FinExteriorPosterior6'];

			$FichaIngreso->FinExteriorDerecho1 = $fila['FinExteriorDerecho1'];
			$FichaIngreso->FinExteriorDerecho2 = $fila['FinExteriorDerecho2'];
			$FichaIngreso->FinExteriorDerecho3 = $fila['FinExteriorDerecho3'];
			$FichaIngreso->FinExteriorDerecho4 = $fila['FinExteriorDerecho4'];
			$FichaIngreso->FinExteriorDerecho5 = $fila['FinExteriorDerecho5'];
			$FichaIngreso->FinExteriorDerecho6 = $fila['FinExteriorDerecho6'];
			$FichaIngreso->FinExteriorDerecho7 = $fila['FinExteriorDerecho7'];
			$FichaIngreso->FinExteriorDerecho8 = $fila['FinExteriorDerecho8'];

			$FichaIngreso->FinExteriorIzquierdo1 = $fila['FinExteriorIzquierdo1'];
			$FichaIngreso->FinExteriorIzquierdo2 = $fila['FinExteriorIzquierdo2'];
			$FichaIngreso->FinExteriorIzquierdo3 = $fila['FinExteriorIzquierdo3'];
			$FichaIngreso->FinExteriorIzquierdo4 = $fila['FinExteriorIzquierdo4'];
			$FichaIngreso->FinExteriorIzquierdo5 = $fila['FinExteriorIzquierdo5'];
			$FichaIngreso->FinExteriorIzquierdo6 = $fila['FinExteriorIzquierdo6'];
			$FichaIngreso->FinExteriorIzquierdo7 = $fila['FinExteriorIzquierdo7'];


			$FichaIngreso->FinInterior1 = $fila['FinInterior1'];
			$FichaIngreso->FinInterior2 = $fila['FinInterior2'];
			$FichaIngreso->FinInterior3 = $fila['FinInterior3'];
			$FichaIngreso->FinInterior4 = $fila['FinInterior4'];
			$FichaIngreso->FinInterior5 = $fila['FinInterior5'];
			$FichaIngreso->FinInterior6 = $fila['FinInterior6'];
			$FichaIngreso->FinInterior7 = $fila['FinInterior7'];
			$FichaIngreso->FinInterior8 = $fila['FinInterior8'];
			$FichaIngreso->FinInterior9 = $fila['FinInterior9'];
			$FichaIngreso->FinInterior10 = $fila['FinInterior10'];
			$FichaIngreso->FinInterior11 = $fila['FinInterior11'];
			$FichaIngreso->FinInterior12 = $fila['FinInterior12'];
			$FichaIngreso->FinInterior13 = $fila['FinInterior13'];
			$FichaIngreso->FinInterior14 = $fila['FinInterior14'];
			$FichaIngreso->FinInterior15 = $fila['FinInterior15'];
			$FichaIngreso->FinInterior16 = $fila['FinInterior16'];
			$FichaIngreso->FinInterior17 = $fila['FinInterior17'];
			$FichaIngreso->FinInterior18 = $fila['FinInterior18'];
			$FichaIngreso->FinInterior19 = $fila['FinInterior19'];
			$FichaIngreso->FinInterior20 = $fila['FinInterior20'];
			$FichaIngreso->FinInterior21 = $fila['FinInterior21'];
			$FichaIngreso->FinInterior22 = $fila['FinInterior22'];
			$FichaIngreso->FinInterior23 = $fila['FinInterior23'];
			$FichaIngreso->FinInterior24 = $fila['FinInterior24'];
			$FichaIngreso->FinInterior25 = $fila['FinInterior25'];
			$FichaIngreso->FinInterior26 = $fila['FinInterior26'];
			$FichaIngreso->FinInterior27 = $fila['FinInterior27'];

			$FichaIngreso->FinNota = $fila['FinNota'];

			$FichaIngreso->FinInformeTecnicoMantenimiento = $fila['FinInformeTecnicoMantenimiento'];
			$FichaIngreso->FinInformeTecnicoRevision = $fila['FinInformeTecnicoRevision'];
			$FichaIngreso->FinInformeTecnicoDiagnostico = $fila['FinInformeTecnicoDiagnostico'];

			$FichaIngreso->FinSalidaFecha = $fila['NFinSalidaFecha'];
			$FichaIngreso->FinSalidaHora = $fila['FinSalidaHora'];
			$FichaIngreso->FinSalidaObservacion = $fila['FinSalidaObservacion'];
			$FichaIngreso->FinSalidaObservacionInterna = $fila['FinSalidaObservacionInterna'];


			$FichaIngreso->FinTerminadoObservacion = $fila['FinTerminadoObservacion'];
			$FichaIngreso->FinAlmacenObservacion = $fila['FinAlmacenObservacion'];
			$FichaIngreso->FinTallerObservacion = $fila['FinTallerObservacion'];

			$FichaIngreso->FinActaEntrega = $fila['FinActaEntrega'];
			$FichaIngreso->FinActaEntregaFecha = $fila['NFinActaEntregaFecha'];

			$FichaIngreso->FinInformeTecnico = $fila['FinInformeTecnico'];

			$FichaIngreso->FinPrioridad = $fila['FinPrioridad'];

			$FichaIngreso->FinTiempoTallerConcluido = $fila['NFinTiempoTallerConcluido'];
			$FichaIngreso->FinTiempoTallerRevisando = $fila['NFinTiempoTallerRevisando'];
			$FichaIngreso->FinTiempoTrabajoTerminado = $fila['NFinTiempoTrabajoTerminado'];


			$FichaIngreso->FinFotoVIN = $fila['FinFotoVIN'];
			$FichaIngreso->FinFotoFrontal = $fila['FinFotoFrontal'];
			$FichaIngreso->FinFotoCupon = $fila['FinFotoCupon'];
			$FichaIngreso->FinFotoMantenimiento = $fila['FinFotoMantenimiento'];

			$FichaIngreso->FinMontoPresupuesto = $fila['FinMontoPresupuesto'];
			$FichaIngreso->FinTipo = $fila['FinTipo'];
			$FichaIngreso->FinOrigenEntrega = $fila['FinOrigenEntrega'];
			$FichaIngreso->FinIndicacionTecnico = $fila['FinIndicacionTecnico'];

			$FichaIngreso->FinCierre = $fila['FinCierre'];
			$FichaIngreso->FinCita = $fila['FinCita'];


			$FichaIngreso->FinEstado = $fila['FinEstado'];
			$FichaIngreso->FinTiempoCreacion = $fila['NFinTiempoCreacion'];
			$FichaIngreso->FinTiempoModificacion = $fila['NFinTiempoModificacion'];

			$FichaIngreso->MinNombre = $fila['MinNombre'] ?? '';



			$FichaIngreso->CliCSIIncluir = $fila['CliCSIIncluir'];

			$FichaIngreso->TdoId = $fila['TdoId'];
			$FichaIngreso->CliNombreCompleto = $fila['CliNombreCompleto'];
			$FichaIngreso->CliNombre = $fila['CliNombre'];
			$FichaIngreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$FichaIngreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];

			$FichaIngreso->CliDireccion = $fila['CliDireccion'];
			$FichaIngreso->CliDepartamento = $fila['CliDepartamento'];
			$FichaIngreso->CliProvincia = $fila['CliProvincia'];
			$FichaIngreso->CliDistrito = $fila['CliDistrito'];


			$FichaIngreso->CliNumeroDocumento = $fila['CliNumeroDocumento'];

			$FichaIngreso->CliCelular = $fila['CliCelular'];
			$FichaIngreso->CliTelefono = $fila['CliTelefono'];


			$FichaIngreso->LtiUtilidad = $fila['LtiUtilidad'];
			$FichaIngreso->LtiNombre = $fila['LtiNombre'];
			$FichaIngreso->LtiAbreviatura = $fila['LtiAbreviatura'];

			$FichaIngreso->EinVIN = $fila['EinVIN'];
			$FichaIngreso->VmaId = $fila['VmaId'];
			$FichaIngreso->VmoId = $fila['VmoId'];
			$FichaIngreso->VveId = $fila['VveId'] ?? '';
			$FichaIngreso->EinAnoFabricacion = $fila['EinAnoFabricacion'];
			$FichaIngreso->EinPlaca = $fila['EinPlaca'];
			$FichaIngreso->EinColor = $fila['EinColor'];

			$FichaIngreso->VmaNombre = $fila['VmaNombre'];
			$FichaIngreso->VmoNombre = $fila['VmoNombre'];
			$FichaIngreso->VveNombre = $fila['VveNombre'];
			$FichaIngreso->FinReferencia = $fila['FinReferencia'];

			$FichaIngreso->PerFoto = $fila['PerFoto'];
			$FichaIngreso->PerNombre = $fila['PerNombre'];
			$FichaIngreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$FichaIngreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];

			$FichaIngreso->PerNombreAsesor = $fila['PerNombreAsesor'];
			$FichaIngreso->PerApellidoPaternoAsesor = $fila['PerApellidoPaternoAsesor'];
			$FichaIngreso->PerApellidoMaternoAsesor = $fila['PerApellidoMaternoAsesor'];

			$FichaIngreso->CamCodigo = $fila['CamCodigo'];
			$FichaIngreso->CamNombre = $fila['CamNombre'];
			$FichaIngreso->CamBoletin = $fila['CamBoletin'];

			$FichaIngreso->FinGarantia = $fila['FinGarantia'];
			$FichaIngreso->FinPlanchadoPintado = $fila['FinPlanchadoPintado'];
			$FichaIngreso->FinModalidadCantidad = $fila['FinModalidadCantidad'];

			$FichaIngreso->FinTallerExterno = $fila['FinTallerExterno'];

			$FichaIngreso->FinCotizacionProducto = $fila['FinCotizacionProducto'];

			$FichaIngreso->FinAlmacenMovimientoSalida = $fila['FinAlmacenMovimientoSalida'];

			$FichaIngreso->FinGarantiaGenerar = $fila['FinGarantiaGenerar'];

			$FichaIngreso->FinFichaAccionSalidaExternaFechaFinalizacion = $fila['FinFichaAccionSalidaExternaFechaFinalizacion'];
			$FichaIngreso->FinFichaAccionSalidaExternaFechaSalida = $fila['FinFichaAccionSalidaExternaFechaSalida'];



			$FichaIngreso->FinFichaAccionComprobanteNumero = $fila['FinFichaAccionComprobanteNumero'];
			$FichaIngreso->FinFichaAccionComprobanteFecha = $fila['FinFichaAccionComprobanteFecha'];

			$FichaIngreso->FinCantidadMantenimientos = $fila['FinCantidadMantenimientos'];
			$FichaIngreso->FinTieneNota = $fila['FinTieneNota'];


			$FichaIngreso->CprId = $fila['CprId'];
			$FichaIngreso->CprSeguro = $fila['CprSeguro'];
			$FichaIngreso->CprSeguroFoto = $fila['CprSeguroFoto'];

			$FichaIngreso->IteId = $fila['IteId'] ?? '';
			$FichaIngreso->ObsNombre = $fila['ObsNombre'];
			$FichaIngreso->ObsArchivo = $fila['ObsArchivo'];
			$FichaIngreso->ObsFoto = $fila['ObsFoto'];


			$FichaIngreso->EncId = $fila['EncId'];

			$FichaIngreso->VreId = $fila['VreId'];

			$FichaIngreso->OncNombre = $fila['OncNombre'];

			$FichaIngreso->FinFichaAccionManoObra = $fila['FinFichaAccionManoObra'];

			$FichaIngreso->SucNombre = $fila['SucNombre'];




			$Prioridad = "";

			switch ($FichaIngreso->FinPrioridad) {

				case 1:
					$Prioridad =  "#FF0000";
					break;

				case 2:
					$Prioridad =  "#FFFFFF";
					break;
			}

			if (!empty($FichaIngreso->FinFechaGarantia)) {
				$Prioridad = "#FFFF33";
			}

			$FichaIngreso->FinPrioridadColor = $Prioridad;


			$Estado = "";

			switch ($FichaIngreso->FinEstado) {

				case 777:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/anulado.png' alt='ANULADO' border='0' width='20' height='20' title='Anulado' > [Anulado]";
					break;

				case 1:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Pendiente]";
					break;

				case 11:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Enviado]";
					break;

				case 2:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Revisando]";
					break;

				case 3:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Preparando Pedido]";
					break;

				case 4:

					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller" . (($FichaIngreso->FinTallerExterno == "Si") ? "2" : "") . ".png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Pedido Enviado]";
					//$Estado ="<img src='".$this->Ruta."imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Pedido Enviado]";
					break;

				case 5:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Revisado Pedido]";
					break;

				case 6:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Preparando Pedido]";
					break;

				case 7:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Pedido Enviado]";
					break;

				case 71:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller" . (($FichaIngreso->FinTallerExterno == "Si") ? "3" : "") . ".png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Pedido Recibido]";
					break;

				case 72:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/almacen.png' alt='ALMACEN' border='0' width='20' height='20' title='ALMACEN'> [Pedido Extornado]";
					break;

				case 73:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Trabajo Terminado]";
					break;

				case 74:
					//$Estado ="<img src='".$this->Ruta."imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Revisando]";
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Trabajo Terminado]";
					break;

				case 75:
					$Estado = "<img src='" . $this->Ruta . "imagenes/iconos/recepcion.png' alt='RECEPCION' border='0' width='20' height='20' title='Recepcion' > [Conforme/Por Facturar]";
					break;

				case 8:
					$Estado = "<img src='" . ($this->Ruta ?? '../../') . "imagenes/iconos/taller.png' alt='TALLER' border='0' width='20' height='20' title='Taller' > [Por Facturar]";
					break;

				case 9:
					$Estado = "<img src='" . ($this->Ruta ?? '../../') . "imagenes/iconos/contabilidad.png' alt='CONTABILIDAD' border='0' width='20' height='20' title='CONTABILIDAD' > [Facturado]";
					break;

				case 10:
					$Estado = "<img src='" . ($this->Ruta ?? '../../') . "imagenes/iconos/no_facturable.png' alt='NO FACTURABLE' border='0' width='20' height='20' title='NO FACTURABLE' > [No Boletable]";
					break;

				default:
					$Estado = "";
					break;
			}




			$FichaIngreso->FinEstadoDescripcion = $Estado;

			$FichaIngreso->InsMysql = NULL;

			$Respuesta['Datos'][] = $FichaIngreso;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}





	/***/

	public function  MtdObtenerFichaIngresosValor($oFuncion = "SUM", $oParametro = "FinId", $oMes = NULL, $oAno = NULL, $oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FinId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oEstado = NULL, $oPrioridad = NULL, $oModalidadIngreso = NULL, $oVIN = NULL, $oCliente = NULL, $oPersonalId = NULL, $oTrabajoConcluido = 0, $oCampana = NULL, $oClienteTipo = NULL, $oTipo = NULL, $oSalidaExterna = 0, $oConCampana = NULL, $oVehiculoIngreso = NULL, $oConConcluido = 0, $oVehiculoMarca = NULL, $oVehiculoModelo = NULL, $oFinMantenimientoKilometraje = NULL, $oTipoReparacion = NULL, $oPersonalIdAsesor = NULL, $oIgnorarPrimerMantenimiento = false, $oIgnorarReparacionesSinCosto = false, $oSucursal = NULL, $oCita = NULL)
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

				' . (($oTrabajoConcluido == 1) ? ' OR fin.FinTiempoTallerConcluido IS NOT NULL' : '') . '
			)
			';
		}

		//		if(!empty($oEstado)){
		//			$estado = ' AND fin.FinEstado = '.$oEstado;
		//		}


		if (!empty($oPrioridad)) {
			$prioridad = ' AND fin.FinPrioridad = ' . $oPrioridad;
		}

		/*		if(!empty($oModalidadIngresos)){
			$mingreso = ' AND EXISTS (
				SELECT fim.FimId
					FROM tblfimfichaingresomodalidad fim
					WHERE fim.MinId = "'.$oModalidadIngreso.'"
					AND fim.FinId = fin.FinId
				LIMIT 1
			) ';
		}	*/


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


		if (!empty($oVIN)) {
			$vin = ' AND ein.EinVIN = "' . $oVIN . '"';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND fin.CliId = "' . $oCliente . '"';
		}

		if (!empty($oPersonalId)) {
			$personal = ' AND fin.PerId = "' . $oPersonalId . '"';
		}

		if (!empty($oCampana)) {
			$campana = ' AND fin.CamId = "' . $oCampana . '"';
		}

		if (!empty($oConConcluido)) {

			switch ($oConConcluido) {
				case 1:
					$tconcluido = ' AND fin.FinTiempoTallerConcluido IS NOT NULL';
					break;
				case 2:
					$tconcluido = ' AND fin.FinTiempoTallerConcluido IS NULL';
					break;
			}
		}

		if (!empty($oClienteTipo)) {

			$elementos = explode(",", $oClienteTipo);

			$i = 1;
			$cltipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$cltipo .= '  (cli.LtiId = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$cltipo .= ' OR ';
				}
				$i++;
			}

			$cltipo .= ' ) 
			)
			';
		}

		if (!empty($oTipo)) {
			$tipo = ' AND fin.FinTipo = "' . $oTipo . '"';
		}




		if (!empty($oSalidaExterna)) {

			switch ($oSalidaExterna) {
				case 1:

					$sexterna = ' AND 
						
								EXISTS (
									SELECT 
						
									fsx.FsxId
									
									FROM tblfsxfichaaccionsalidaexterna fsx
			
										LEFT JOIN tblfccfichaaccion fcc
										ON fsx.FccId = fcc.FccId
											
											LEFT JOIN tblfimfichaingresomodalidad fim
											ON fcc.FimId = fim.FimId
											
											
								WHERE 
									 fim.FinId = fin.FinId
									AND fsx.FsxId IS NOT NULL
								
								)
								
						';



					break;

				case 2:

					$sexterna = ' AND 
						
								NOT EXISTS (
									SELECT 
						
									fsx.FsxId
									
									FROM tblfsxfichaaccionsalidaexterna fsx
			
										LEFT JOIN tblfccfichaaccion fcc
										ON fsx.FccId = fcc.FccId
											
											LEFT JOIN tblfimfichaingresomodalidad fim
											ON fcc.FimId = fim.FimId
											
											
								WHERE 
									 fim.FinId = fin.FinId
									AND fsx.FsxId IS NOT NULL
								
								)
								
						';

					break;

				default:

					break;
			}
		}


		if (!empty($oConCampana)) {

			switch ($oConCampana) {
				case 1:
					$ccampana = ' AND fin.CamId IS NOT NULL';
					break;

				case 2:
					$ccampana = ' AND fin.CamId IS  NULL';
					break;
			}
		}

		if (!empty($oVehiculoIngreso)) {
			$eingreso = ' AND fin.EinId = "' . $oVehiculoIngreso . '"';
		}


		if (!empty($oVehiculoMarca)) {
			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '"';
		}

		if (!empty($oVehiculoModelo)) {
			$vmodelo = ' AND vve.VmoId = "' . $oVehiculoModelo . '"';
		}

		if (!empty($oFinMantenimientoKilometraje)) {
			$mmkilometraje = ' AND fin.FinMantenimientoKilometraje = "' . $oFinMantenimientoKilometraje . '"';
		}

		if (!empty($oTipoReparacion)) {
			$treparacion = ' AND fin.TreId = "' . $oTipoReparacion . '"';
		}


		if (!empty($oPersonalIdAsesor)) {
			$pasesor = ' AND fin.PerIdAsesor = "' . $oPersonalIdAsesor . '"';
		}

		if ($oIgnorarPrimerMantenimiento) {
			$excluir = ' AND (fin.FinMantenimientoKilometraje <> "1500" AND fin.FinMantenimientoKilometraje <> "1000") ';
		}

		if ($oIgnorarReparacionesSinCosto) {

			$sincosto = ' 
				
				AND NOT EXISTS(

					SELECT 
					fim.FimId
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId	

					WHERE fim.FinId = fin.FinId

						AND NOT EXISTS(
							SELECT 
							fam.FamId
							FROM tblfamfacturaalmacenmovimiento fam
							WHERE fam.AmoId = amo.AmoId								
						)
						
						AND NOT EXISTS(
							SELECT
							bam.BamId
							FROM tblbamboletaalmacenmovimiento bam
							WHERE bam.AmoId = amo.AmoId
						)
						
					)
				
			';
		}




		if (!empty($oSucursal)) {
			$sucursal = ' AND fin.SucId = "' . $oSucursal . '"';
		}


		if (!empty($oCita)) {

			$elementos = explode(",", $oCita);

			$i = 1;
			$cita .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$cita .= '  (fin.FinCita = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$cita .= ' OR ';
				}
				$i++;
			}

			$cita .= ' ) 
			)
			';
		}



		if (!empty($oFuncion) & !empty($oParametro)) {
			$funcion = $oFuncion . '(' . $oParametro . ')';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fin.FinFecha) ="' . ($oMes) . '"';
		}

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fin.FinFecha) ="' . ($oAno) . '"';
		}



		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				' . $funcion . ' AS "RESULTADO"
				
				FROM tblfinfichaingreso fin
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
									
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvehvehiculo veh
										ON ein.VehId = veh.VehId
										
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON vve.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
													ON vmo.VmaId = vma.VmaId	
													
														LEFT JOIN tbliteinformetecnico ite
														ON ite.FinId = fin.FinId
																
															LEFT JOIN tblperpersonal per2
															ON fin.PerIdAsesor = per2.PerId
					LEFT JOIN tblperpersonal per
					ON fin.PerId = per.PerId
					
						LEFT JOIN tblcamcampana cam
						ON fin.CamId = cam.CamId
						
				WHERE  FinMigrado IS NULL ' . $ano . $mes . $cita . $filtrar . $sincosto . $sucursal . $fecha . $estado . $excluir . $prioridad . $mingreso . $vin . $cliente . $personal . $tconcluido . $campana . $cltipo . $tipo . $sexterna . $ccampana . $eingreso . $vmarca . $vmodelo . $mmkilometraje . $pasesor . $treparacion . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		settype($fila['RESULTADO'], "float");

		return $fila['RESULTADO'];
	}




	/***/

	public function MtdObtenerFichaIngresosTotal($oFuncion = "SUM", $oParametro = "FacId", $oMes = NULL, $oAno = NULL, $oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'FinId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oEstado = NULL, $oPrioridad = NULL, $oModalidadIngreso = NULL, $oVIN = NULL, $oClienteId = NULL, $oPersonalId = NULL, $oTrabajoConcluido = 0, $oCampana = NULL, $oClienteTipo = NULL, $oVehiculoMarca = NULL, $oTipo = NULL, $oVehiculoTipo = NULL, $oVehiculoModelo = NULL, $oIgnorarReparacionesSinCosto = false, $oSucursal = NULL, $oDia = NULL, $oTieneCita = false)
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

				' . (($oTrabajoConcluido == 1) ? ' OR fin.FinTiempoTallerConcluido IS NOT NULL' : '') . '
			)
			';
		}

		//		if(!empty($oEstado)){
		//			$estado = ' AND fin.FinEstado = '.$oEstado;
		//		}


		if (!empty($oPrioridad)) {
			$prioridad = ' AND fin.FinPrioridad = ' . $oPrioridad;
		}



		if (!empty($oModalidadIngreso)) {

			$elementos = explode(",", $oModalidadIngreso);

			$i = 1;
			$mingreso .= ' AND (
			
			
				 EXISTS (
					SELECT fim.FimId
						FROM tblfimfichaingresomodalidad fim
						WHERE
				
					(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$mingreso .= '  (fim.MinId = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$mingreso .= ' OR ';
				}
				$i++;
			}

			$mingreso .= ' ) 
			
				AND fim.FinId = fin.FinId
				LIMIT 1
				)
			)
			';
		}
		//echo $mingreso;
		//
		//
		//		if(!empty($oModalidadIngreso)){
		//			$mingreso = ' AND EXISTS (
		//				SELECT fim.FimId
		//					FROM tblfimfichaingresomodalidad fim
		//					WHERE fim.MinId = "'.$oModalidadIngreso.'"
		//					AND fim.FinId = fin.FinId
		//				LIMIT 1
		//			) ';
		//		}		

		if (!empty($oVIN)) {
			$vin = ' AND ein.EinVIN = "' . $oVIN . '"';
		}

		if (!empty($oCliente)) {
			$cliente = ' AND fin.CliId = "' . $oCliente . '"';
		}

		if (!empty($oPersonalId)) {
			$personal = ' AND fin.PerId = "' . $oPersonalId . '"';
		}

		if (!empty($oCampana)) {
			$campana = ' AND fin.CamId = "' . $oCampana . '"';
		}


		if (!empty($oClienteTipo)) {

			$elementos = explode(",", $oClienteTipo);

			$i = 1;
			$cltipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$cltipo .= '  (cli.LtiId = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$cltipo .= ' OR ';
				}
				$i++;
			}

			$cltipo .= ' ) 
			)
			';
		}

		if (!empty($oVehiculoMarca)) {
			//$vmarca = ' AND ein.VmaId = "'.$oVehiculoMarca.'"';
			$vmarca = ' AND vmo.VmaId = "' . $oVehiculoMarca . '"';
		}

		if (!empty($oTipo)) {
			$tipo = ' AND fin.FinTipo = "' . $oTipo . '"';
		}


		if (!empty($oVehiculoTipo)) {

			$elementos = explode(",", $oVehiculoTipo);

			$i = 1;
			$vtipo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$vtipo .= '  (vmo.VtiId = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$vtipo .= ' OR ';
				}
				$i++;
			}

			$vtipo .= ' ) 
			)
			';
		}

		if (!empty($oVehiculoModelo)) {

			$elementos = explode(",", $oVehiculoModelo);

			$i = 1;
			$vmodelo .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$vmodelo .= '  (vve.VmoId = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$vmodelo .= ' OR ';
				}
				$i++;
			}

			$vmodelo .= ' ) 
			)
			';
		}

		if ($oIgnorarReparacionesSinCosto) {

			$sincosto = ' 
				
				AND NOT EXISTS(

					SELECT 
					fim.FimId
					FROM tblfimfichaingresomodalidad fim
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
							LEFT JOIN tblamoalmacenmovimiento amo
							ON amo.FccId = fcc.FccId	

					WHERE fim.FinId = fin.FinId

						AND NOT EXISTS(
							SELECT 
							fam.FamId
							FROM tblfamfacturaalmacenmovimiento fam
							WHERE fam.AmoId = amo.AmoId								
						)
						
						AND NOT EXISTS(
							SELECT
							bam.BamId
							FROM tblbamboletaalmacenmovimiento bam
							WHERE bam.AmoId = amo.AmoId
						)

				)
				
			';
		}


		if ($oTieneCita) {
			$tcita = ' AND fin.CitId IS NOT NULL ';
		}

		if (!empty($oFuncion) & !empty($oParametro)) {
			$funcion = $oFuncion . '(' . $oParametro . ')';
		}

		if (!empty($oMes)) {
			$mes = ' AND MONTH(fin.FinFecha) ="' . ($oMes) . '"';
		}

		if (!empty($oAno)) {
			$ano = ' AND YEAR(fin.FinFecha) ="' . ($oAno) . '"';
		}


		if (!empty($oDia)) {
			$dia = ' AND DAY(fin.FinFecha) ="' . ($oDia) . '"';
		}

		if (!empty($oSucursal)) {
			$sucursal = ' AND (fin.SucId) ="' . ($oSucursal) . '"';
		}

		//echo "<br>";echo "<br>";
		$sql = 'SELECT
				' . $funcion . ' AS "RESULTADO"
				
				FROM tblfinfichaingreso fin
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbllticlientetipo lti
							ON cli.LtiId = lti.LtiId
								LEFT JOIN tbltdotipodocumento tdo
								ON cli.TdoId = tdo.TdoId
									
									LEFT JOIN tbleinvehiculoingreso ein
									ON fin.EinId = ein.EinId
										LEFT JOIN tblvehvehiculo veh
										ON ein.VehId = veh.VehId
										
											LEFT JOIN tblvvevehiculoversion vve
											ON ein.VveId = vve.VveId
												LEFT JOIN tblvmovehiculomodelo vmo
												ON vve.VmoId = vmo.VmoId
													LEFT JOIN tblvmavehiculomarca vma
													ON vmo.VmaId = vma.VmaId	
													
														LEFT JOIN tbliteinformetecnico ite
														ON ite.FinId = fin.FinId
																
															LEFT JOIN tblperpersonal per2
															ON fin.PerIdAsesor = per2.PerId
					LEFT JOIN tblperpersonal per
					ON fin.PerId = per.PerId
					
						LEFT JOIN tblcamcampana cam
						ON fin.CamId = cam.CamId
						
				WHERE 1 = 1 ' . $ano . $mes . $dia . $filtrar . $fecha . $tcita . $vtipo . $sucursal . $dia . $estado . $prioridad . $sincosto . $mingreso . $vin . $cliente . $personal . $tconcluido . $campana . $cltipo . $vmarca . $vmodelo . $tipo . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);


		settype($fila['RESULTADO'], "float");

		return $fila['RESULTADO'];
	}

	//Accion eliminar	 
	public function MtdEliminarFichaIngreso($oElementos)
	{



		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {

			if (!empty($elemento)) {

				$this->FinId = $elemento;
				//
				//						$this->MtdObtenerFichaIngreso();
				//							
				//							$validar = 0;
				//							if(!empty($this->FichaIngresoModalidad)){
				//								foreach($this->FichaIngresoModalidad as $DatFichaIngresoModalidad){
				//
				//									$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
				//									if($InsFichaIngresoModalidad->MtdEliminarFichaIngresoModalidad($DatFichaIngresoModalidad->FimId)){
				//										$validar++;
				//									}else{
				//										$error = true;	
				//									}
				//									
				//								}
				//							}

				if (!$error) {

					$sql = 'DELETE FROM tblfinfichaingreso WHERE  (FinId = "' . ($this->FinId) . '" ) ';

					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {
						//$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
						//$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$oFichaIngreso=NULL,$oEstado=NULL);
						$this->MtdAuditarFichaIngreso(3, "Se elimino la Orden de Trabajo", $aux);
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



	//Accion eliminar	 
	public function MtdDesmarcarConcluidoFichaIngreso($oElementos)
	{

		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {

			if (!empty($elemento)) {

				if (!$error) {

					$sql = 'UPDATE tblfinfichaingreso SET FinTiempoTallerConcluido = NULL WHERE  (FinId = "' . ($elemento) . '" ) ';

					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {
						//$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
						//$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$oFichaIngreso=NULL,$oEstado=NULL);
						$this->MtdAuditarFichaIngreso(2, "Se edito trabajo concluido de la Orden de Trabajo", $elemento);
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


	public function MtdMarcarConcluidoFichaIngreso($oElementos)
	{

		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {

			if (!empty($elemento)) {

				if (!$error) {

					$sql = 'UPDATE tblfinfichaingreso SET FinTiempoTallerConcluido = NOW() WHERE  (FinId = "' . ($elemento) . '" ) ';

					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {
						//$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
						//$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$oFichaIngreso=NULL,$oEstado=NULL);
						$this->MtdAuditarFichaIngreso(2, "Se edito trabajo concluido de la Orden de Trabajo", $elemento);
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


	//Accion eliminar	 
	public function MtdActualizarCierreFichaIngreso($oElementos, $oCierre, $oTransaccion = true)
	{

		global $Resultado;


		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#", $oElementos);


		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$sql = 'UPDATE tblfinfichaingreso SET 
					FinCierre = ' . $oCierre . ',
					FinTiempoModificacion = "' . date("Y-m-d H:i:s") . '"
					WHERE FinId = "' . $elemento . '"';

				$resultado = $this->InsMysql->MtdEjecutar($sql, false);

				if (!$resultado) {
					$error = true;
				}

				if (!$error) {

					//deb($oCierre);
					$Auditoria = "";

					switch ($oCierre) {
						case 1:
							$Auditoria = "Se cambio a Abierto la Orden de Trabajo";
							break;

						case 2:
							$Auditoria = "Se cambio a Cerrado la Orden de Trabajo";
							break;
					}
					//deb($elemento);
					$this->FinId = $elemento;
					//MtdAuditarFichaIngreso($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL)
					$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento, $elemento, $_SESSION['SesionUsuario'], $_SESSION['SesionNombre']);
				}
			}
			$i++;
		}

		if ($error) {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}
			return false;
		} else {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}




			return true;
		}
	}


	//Accion eliminar	 
	public function MtdActualizarEstadoFichaIngreso($oElementos, $oEstado, $oTransaccion = true, $oMotivo = NULL)
	{

		global $Resultado;
		global $EmpresaImpuestoVenta;
		global $EmpresaMonedaId;

		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#", $oElementos);

		//$InsFichaIngreso = new ClsFichaIngreso();
		//$InsFichaIngresoTareas = new ClsFichaIngresoTarea($this->InsMysql);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$this->FinId = $elemento;
				$this->MtdObtenerFichaIngreso();

				switch ($oEstado) {


					case 777: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ANULADO [Anulado]";

						//if($this->FinEstado == 1 or $this->FinEstado == 11){
						if ($this->FinEstado != 9) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinEstadoMotivo = "' . $oMotivo . '",
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {

								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_915';
						}

						break;


					case 1: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: RECEPCION [Pendiente]";

						if ($this->FinEstado == 11) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {

								$this->FinTiempoTallerRevisando = NULL;
								$this->FinTiempoModificacion = date("Y-m-d H:i:s");
								$this->MtdEditarFichaIngresoTallerRevisando();


								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_913';
						}

						break;

					case 11: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: RECEPCION [Enviado]";

						//deb($this->FinEstado);

						/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						
*/

						if (
							$this->FinEstado == 1
							|| $this->FinEstado == 2
							|| $this->FinEstado == 3
							|| $this->FinEstado == 4
						) {

							if (
								$this->FinEstado == 2
								|| $this->FinEstado == 3
								|| $this->FinEstado == 4
							) {

								$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
								$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
								$InsFichaAccionProducto = new ClsFichaAccionProducto($this->InsMysql);

								$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL, NULL, 'FimId', 'ASC', NULL, $this->FinId, NULL);
								$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];

								//deb($ArrFichaIngresoModalidades);	
								foreach ($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad) {

									$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL, NULL, NULL, 'FccId', 'ASC', '1', $DatFichaIngresoModalidad->FimId, NULL, NULL, NULL);
									$ArrFichaAcciones = $ResFichaAccion['Datos'];


									//deb($ArrFichaAcciones);

									if (!empty($ArrFichaAcciones)) {
										$faccion = '';
										foreach ($ArrFichaAcciones as $DatFichaAccion) {
											$faccion .= '#' . $DatFichaAccion->FccId;
										}

										if (!$InsFichaAccion->MtdEliminarFichaAccion($faccion)) {
											$error = true;
										}
									}
								}


								$this->FinTiempoTallerRevisando = NULL;
								$this->FinTiempoModificacion = date("Y-m-d H:i:s");
								$this->MtdEditarFichaIngresoTallerRevisando();
							}


							if (!$error) {

								$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

								$resultado = $this->InsMysql->MtdEjecutar($sql, false);

								if (!$resultado) {
									$error = true;
								} else {
									$Auditoria = $this->MtdDefinirAuditoria($oEstado);
									$this->FinId = $elemento;
									$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
								}
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_900';
						}

						break;

					case 2: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Revisando]";

						if ($this->FinEstado == 11) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_901';
						}

						break;

					case 3: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Preparando Pedido]";

						if ($this->FinEstado == 2 || $this->FinEstado == 4) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_902';
						}



						break;

					case 4: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Pedido Enviado]";

						//deb($this->FinEstado);
						//								if($this->FinEstado == 3 || $this->FinEstado == 5 || $this->FinEstado == 6){
						if (
							$this->FinEstado == 1
							|| $this->FinEstado == 11
							|| $this->FinEstado == 3
							|| $this->FinEstado == 5
							|| $this->FinEstado == 6
							|| $this->FinEstado == 7
							|| $this->FinEstado == 71
							|| $this->FinEstado == 72
							|| $this->FinEstado == 73
							|| $this->FinEstado == 74

						) {

							if ($this->FinEstado == 3) {

								//	$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
								//										$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
								//										$InsFichaAccionProducto = new ClsFichaAccionProducto($this->InsMysql);
								//										
								//										$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$this->FinId,NULL);
								//										$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
								//												

								//foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){

								//$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL);
								//$ArrFichaAcciones = $ResFichaAccion['Datos'];

								//foreach($ArrFichaAcciones as $DatFichaAccion){

								//$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,1,"C");
								//												$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
								//												
								//												if(!empty($ArrFichaAccionProductos)){
								//													foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
								//														
								//														$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
								//														$InsFichaAccionProducto->FapVerificar2 = 2;
								//														$InsFichaAccionProducto->MtdEditarFichaAccionProductoVerificar2();
								//		
								//													}
								//												}


								//	$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,2);
								//												$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
								//												
								//												if(!empty($ArrFichaAccionProductos)){
								//													foreach($ArrFichaAccionProductos as $DatFichaAccionProducto){
								//														
								//														$InsFichaAccionProducto->FapId = $DatFichaAccionProducto->FapId;
								//														$InsFichaAccionProducto->FapVerificar2 = 2;
								//														$InsFichaAccionProducto->MtdEditarFichaAccionProductoVerificar2();
								//		
								//													}
								//												}



								//	}
								//}

							} else {

								if ($this->FinEstado <> 1) {

									$InsTallerPedido = new ClsTallerPedido($this->InsMysql);

									//MtdObtenerTallerPedidos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'AmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaAccion=NULL,$oFichaIngreso=NULL,$oConBoleta=0,$oConFicha=0,$oFichaIngresoEstado=NULL,$oConBoleta=NULL,$oPorFacturar=false,$oModalidad=NULL,$oSubTipo=NULL) 
									$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL, NULL, NULL, 'AmoId', 'ASC', NULL, NULL, NULL, NULL, NULL, $this->FinId);
									$ArrTallerPedidos = $ResTallerPedido['Datos'];

									//deb($ArrTallerPedidos);
									if (!empty($ArrTallerPedidos)) {

										$tpedido = "";
										foreach ($ArrTallerPedidos as $DatTallerPedido) {
											$tpedido .= "#" . $DatTallerPedido->AmoId;
										}

										//deb($tpedido);
										if (!($InsTallerPedido->MtdEliminarTallerPedido($tpedido, false))) {
											$error = true;
										}
									}
								} else {

									//$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
									//											$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$this->FinId,NULL);
									//											$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];

									//foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
									foreach ($this->FichaIngresoModalidad as $DatFichaIngresoModalidad) {


										//MtdObtenerFichaAcciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'FccId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngresoModalidad=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFichaIngresoEstado=NULL,$oPorFacturar=false,$oPorGenerarGarantia=false,$oFichaIngresoModalidadIngreso=NULL,$oIgnorarTotalVacio=false)


										//ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','Desc',NULL,$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL,NULL,false,false,NULL,false);
										//												$ArrFichaAcciones = $ResFichaAccion['Datos'];
										$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
										$FichaAccionId = $InsFichaAccion->MtdVerificarExisteFichaAccion("FimId", $DatFichaIngresoModalidad->FimId);


										if (empty($FichaAccionId)) {


											$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
											$InsFichaAccion->FimId = $DatFichaIngresoModalidad->FimId;
											$InsFichaAccion->FccFecha = date("Y-m-d");
											$InsFichaAccion->FccObservacion = date("d/m/Y H:i:s") . " - Sub OT autogenerada de O.T.: " . $InsFichaIngreso->FinId;

											$InsFichaAccion->FccManoObra = 0;
											$InsFichaAccion->FccDescuento = 0;
											$InsFichaAccion->FccEstado = 1;
											$InsFichaAccion->FccTiempoCreacion = date("Y-m-d H:i:s");
											$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");

											$InsFichaAccion->MinSigla = $DatFichaIngresoModalidad->MinSigla;

											$InsFichaAccion->FichaAccionTarea = array();
											$InsFichaAccion->FichaAccionProducto = array();
											$InsFichaAccion->FichaAccionMantenimiento = array();


											if (!empty($DatFichaIngresoModalidad->FichaIngresoTarea)) {
												foreach ($DatFichaIngresoModalidad->FichaIngresoTarea as $DatFichaIngresoTarea) {

													if (!empty($DatFichaIngresoTarea->MinSigla)) { //AUX

														$InsFichaAccionTarea1 = new ClsFichaAccionTarea($this->InsMysql);
														$InsFichaAccionTarea1->FitId = $DatFichaIngresoTarea->FitId;
														$InsFichaAccionTarea1->FatDescripcion = $DatFichaIngresoTarea->FitDescripcion;
														$InsFichaAccionTarea1->FatAccion = $DatFichaIngresoTarea->FitAccion;

														$InsFichaAccionTarea1->FatEspecificacion = NULL;
														$InsFichaAccionTarea1->FatCosto = 0;

														$InsFichaAccionTarea1->FatVerificar1 = 2;
														$InsFichaAccionTarea1->FatVerificar2 = 2;
														$InsFichaAccionTarea1->FatEstado = 2;
														$InsFichaAccionTarea1->FatTiempoCreacion = date("Y-m-d H:i:s");
														$InsFichaAccionTarea1->FatTiempoModificacion = date("Y-m-d H:i:s");
														$InsFichaAccionTarea1->FatEliminado = 1;
														$InsFichaAccionTarea1->InsMysql = NULL;

														$InsFichaAccion->FichaAccionTarea[] = $InsFichaAccionTarea1;
													}
												}
											}



											if (!empty($DatFichaIngresoModalidad->FichaIngresoProducto)) {
												foreach ($DatFichaIngresoModalidad->FichaIngresoProducto as $DatFichaIngresoProducto) {

													if (!empty($DatFichaIngresoProducto->MinSigla)) { //AUX

														if (!empty($DatFichaIngresoProducto->ProId)) {

															$InsFichaAccionProducto1 = new ClsFichaAccionProducto($this->InsMysql);
															$InsFichaAccionProducto1->ProId = $DatFichaIngresoProducto->ProId;
															$InsFichaAccionProducto1->UmeId = NULL;
															$InsFichaAccionProducto1->FapAccion = "C";

															$InsFichaAccionProducto1->FapVerificar1 = 2; //SECAMBIO PRO DEFECTO 
															$InsFichaAccionProducto1->FapVerificar2 = 1;
															$InsFichaAccionProducto1->FapCantidad = 0;
															$InsFichaAccionProducto1->FapCantidadReal = 0;
															$InsFichaAccionProducto1->FapEstado = 2;
															$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
															$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
															$InsFichaAccionProducto1->FapEliminado = 1;
															$InsFichaAccionProducto1->InsMysql = NULL;

															$InsFichaAccion->FichaAccionProducto[] = $InsFichaAccionProducto1;
														}
													}
												}
											}



											if (!empty($DatFichaIngresoModalidad->FichaIngresoSuministro)) {
												foreach ($DatFichaIngresoModalidad->FichaIngresoSuministro as $DatFichaIngresoSuministro) {

													if (!empty($DatFichaIngresoSuministro->MinSigla)) { //AUX

														if (!empty($DatFichaIngresoSuministro->ProId)) {

															$InsFichaAccionSuministro1 = new ClsFichaAccionSuministro($this->InsMysql);
															$InsFichaAccionSuministro1->ProId = $DatFichaIngresoSuministro->ProId;
															$InsFichaAccionSuministro1->UmeId = $DatFichaIngresoSuministro->UmeId;

															$InsFichaAccionSuministro1->FasAccion = "C";
															$InsFichaAccionSuministro1->FasVerificar1 = 1; //SE CAMBI POR DEFECTO
															$InsFichaAccionSuministro1->FasVerificar2 = 2;
															$InsFichaAccionSuministro1->FasCantidad = $DatFichaIngresoSuministro->FisCantidad;
															$InsFichaAccionSuministro1->FasCantidadReal = 0;
															$InsFichaAccionSuministro1->FasEstado = 2;
															$InsFichaAccionSuministro1->FasTiempoCreacion = date("Y-m-d H:i:s");
															$InsFichaAccionSuministro1->FasTiempoModificacion = date("Y-m-d H:i:s");
															$InsFichaAccionSuministro1->FasEliminado = 1;
															$InsFichaAccionSuministro1->InsMysql = NULL;

															$InsFichaAccion->FichaAccionSuministro[] = $InsFichaAccionSuministro1;
														}
													}
												}
											}


											if ($DatFichaIngresoModalidad->MinId == "MIN-10001") {

												if (!empty($this->VmoId)) {

													$InsPlanMantenimiento = new ClsPlanMantenimiento();
													$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL, NULL, NULL, 'PmaId', 'ASC', 1, NULL, NULL, $this->VmoId);
													$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

													$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
													unset($ArrPlanMantenimientos);
													$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();
												}











												if (!empty($DatFichaIngresoModalidad->FichaIngresoMantenimiento)) {
													foreach ($DatFichaIngresoModalidad->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento) {

														if (!empty($DatFichaIngresoMantenimiento->MinSigla)) { //AUX

															$ProductoId = "";
															$TareaProductoCantidad = 0;
															$UnidadMedidaId = "";

															if (!empty($InsPlanMantenimiento->VmaId)) {

																switch ($InsPlanMantenimiento->VmaId) {

																	//case "VMA-10017"://CHEVROLET
																	default: //CHEVROLET

																		$InsTareaProducto = new ClsTareaProducto();
																		$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL, NULL, NULL, 'TprId', 'Desc', NULL, $InsPlanMantenimiento->PmaId, $InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$this->FinMantenimientoKilometraje]['eq'], $DatFichaIngresoMantenimiento->PmtId);

																		$ArrTareaProductos = $ResTareaProducto['Datos'];
																		$InsTareaProducto->TprId = $ArrTareaProductos[0]->TprId;
																		unset($ArrTareaProductos);
																		$InsTareaProducto->MtdObtenerTareaProducto();

																		$ProductoId = $InsTareaProducto->ProId;
																		$TareaProductoCantidad = $InsTareaProducto->TprCantidad;
																		$UnidadMedidaId = $InsTareaProducto->UmeId;

																		break;

																	case "VMA-10018": //ISUZU

																		$InsTareaProducto = new ClsTareaProducto();
																		$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL, NULL, NULL, 'TprId', 'Desc', NULL, $InsPlanMantenimiento->PmaId, $InsPlanMantenimiento->PmaIsuzuKilometrajesNuevo[$this->FinMantenimientoKilometraje]['eq'], $DatFichaIngresoMantenimiento->PmtId);

																		$ArrTareaProductos = $ResTareaProducto['Datos'];
																		$InsTareaProducto->TprId = $ArrTareaProductos[0]->TprId;
																		unset($ArrTareaProductos);
																		$InsTareaProducto->MtdObtenerTareaProducto();

																		$ProductoId = $InsTareaProducto->ProId;
																		$TareaProductoCantidad = $InsTareaProducto->TprCantidad;
																		$UnidadMedidaId = $InsTareaProducto->UmeId;

																		break;
																}
															}


															$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento($this->InsMysql);

															$InsFichaAccionMantenimiento1->PmtId = $DatFichaIngresoMantenimiento->PmtId;
															$InsFichaAccionMantenimiento1->FaaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
															$InsFichaAccionMantenimiento1->FaaNivel = (($DatFichaIngresoMantenimiento->FidAccion == "X")) ? '2' : '1';

															$InsFichaAccionMantenimiento1->ProId = $ProductoId;
															$InsFichaAccionMantenimiento1->FaaCantidad = $TareaProductoCantidad;
															$InsFichaAccionMantenimiento1->UmeId = $UnidadMedidaId;

															$InsFichaAccionMantenimiento1->FaaVerificar1 = 1;
															$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
															$InsFichaAccionMantenimiento1->FaaEstado = 2;
															$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
															$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");

															$InsFichaAccionMantenimiento1->FiaId = $DatFichaIngresoMantenimiento->FiaId;

															$InsFichaAccionMantenimiento1->InsMysql = NULL;

															$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
														}
													}
												} else {

													$InsPlanMantenimiento = new ClsPlanMantenimiento();
													$ResPlanMantenimiento = $InsPlanMantenimiento->MtdObtenerPlanMantenimientos(NULL, NULL, NULL, 'PmaId', 'ASC', 1, NULL, NULL, $InsFichaIngreso->VmoId);
													$ArrPlanMantenimientos = $ResPlanMantenimiento['Datos'];

													$InsPlanMantenimientoSeccion = new ClsPlanMantenimientoSeccion();
													$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL, NULL, "PmsId", "ASC", NULL);
													$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

													$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
													unset($ArrPlanMantenimientos);
													$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

													$this->PmaId = $InsPlanMantenimiento->PmaId;

													foreach ($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion) {

														$PlanMantenimientoDetalleAccion = '';

														$InsPlanMantenimientoTarea = new ClsPlanMantenimientoTarea();
														$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL, NULL, 'PmtNombre', 'ASC', NULL, $DatPlanMantenimientoSeccion->PmsId);
														$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

														foreach ($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea) {

															switch ($InsPlanMantenimiento->VmaId) {

																//case "VMA-10017"://CHEVROLET
																default: //CHEVROLET

																	//foreach($this->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro){
																	foreach ($InsPlanMantenimiento->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro) {

																		$PlanMantenimientoDetalleAccion = '';

																		if ($this->FinMantenimientoKilometraje == $DatKilometro['km']) {

																			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
																			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId, $DatKilometro['eq'], $DatPlanMantenimientoSeccion->PmsId, $DatPlanMantenimientoTarea->PmtId);
																		}

																		if (!empty($PlanMantenimientoDetalleAccion)) {


																			$ProductoId = "";
																			$TareaProductoCantidad = 0;
																			$UnidadMedidaId = "";

																			if (!empty($InsPlanMantenimiento->VmaId)) {

																				switch ($InsPlanMantenimiento->VmaId) {

																					//case "VMA-10017"://CHEVROLET
																					default: //CHEVROLET

																						$InsTareaProducto = new ClsTareaProducto();
																						$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL, NULL, NULL, 'TprId', 'Desc', NULL, $InsPlanMantenimiento->PmaId, $InsPlanMantenimiento->PmaChevroletKilometrajesNuevo[$this->FinMantenimientoKilometraje]['eq'], $DatPlanMantenimientoTarea->PmtId);

																						$ArrTareaProductos = $ResTareaProducto['Datos'];
																						$InsTareaProducto->TprId = $ArrTareaProductos[0]->TprId;
																						unset($ArrTareaProductos);
																						$InsTareaProducto->MtdObtenerTareaProducto();

																						$ProductoId = $InsTareaProducto->ProId;
																						$TareaProductoCantidad = $InsTareaProducto->TprCantidad;
																						$UnidadMedidaId = $InsTareaProducto->UmeId;

																						break;

																					case "VMA-10018": //ISUZU

																						$InsTareaProducto = new ClsTareaProducto();
																						$ResTareaProducto = $InsTareaProducto->MtdObtenerTareaProductos(NULL, NULL, NULL, 'TprId', 'Desc', NULL, $InsPlanMantenimiento->PmaId, $InsPlanMantenimiento->PmaIsuzuKilometrajesNuevo[$this->FinMantenimientoKilometraje]['eq'], $DatPlanMantenimientoTarea->PmtId);

																						$ArrTareaProductos = $ResTareaProducto['Datos'];
																						$InsTareaProducto->TprId = $ArrTareaProductos[0]->TprId;
																						unset($ArrTareaProductos);
																						$InsTareaProducto->MtdObtenerTareaProducto();

																						$ProductoId = $InsTareaProducto->ProId;
																						$TareaProductoCantidad = $InsTareaProducto->TprCantidad;
																						$UnidadMedidaId = $InsTareaProducto->UmeId;

																						break;
																				}
																			}




																			$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento($this->InsMysql);

																			$InsFichaAccionMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
																			$InsFichaAccionMantenimiento1->FaaAccion = $PlanMantenimientoDetalleAccion;
																			$InsFichaAccionMantenimiento1->FaaNivel = (($PlanMantenimientoDetalleAccion == "X")) ? '2' : '1';

																			$InsFichaAccionMantenimiento1->ProId = $ProductoId;
																			$InsFichaAccionMantenimiento1->FaaCantidad = $TareaProductoCantidad;
																			$InsFichaAccionMantenimiento1->UmeId = $UnidadMedidaId;


																			$InsFichaAccionMantenimiento1->FaaVerificar1 = 1;
																			$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
																			$InsFichaAccionMantenimiento1->FaaEstado = 2;
																			$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
																			$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");

																			$InsFichaAccionMantenimiento1->FiaId = NULL;

																			$InsFichaAccionMantenimiento1->InsMysql = NULL;

																			$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
																		}
																	}

																	break;

																case "VMA-10018": //ISUZU

																	foreach ($InsPlanMantenimiento->PmaIsuzuKilometrajes as $DatKilometroEtiqueta => $DatKilometro) {

																		$PlanMantenimientoDetalleAccion = '';

																		if ($this->FinMantenimientoKilometraje == $DatKilometro['km']) {

																			$InsPlanMantenimientoDetalle = new ClsPlanMantenimientoDetalle();
																			$PlanMantenimientoDetalleAccion = $InsPlanMantenimientoDetalle->MtObtenerPlanMantenimientoDetalleAccion($InsPlanMantenimiento->PmaId, $DatKilometro['eq'], $DatPlanMantenimientoSeccion->PmsId, $DatPlanMantenimientoTarea->PmtId);
																		}

																		if (!empty($PlanMantenimientoDetalleAccion)) {


																			$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento($this->InsMysql);

																			$InsFichaAccionMantenimiento1->PmtId = $DatPlanMantenimientoTarea->PmtId;
																			$InsFichaAccionMantenimiento1->FaaAccion = $PlanMantenimientoDetalleAccion;
																			$InsFichaAccionMantenimiento1->FaaNivel = (($PlanMantenimientoDetalleAccion == "X")) ? '2' : '1';

																			$InsFichaAccionMantenimiento1->ProId = $ProductoId;
																			$InsFichaAccionMantenimiento1->FaaCantidad = $TareaProductoCantidad;
																			$InsFichaAccionMantenimiento1->UmeId = $UnidadMedidaId;



																			$InsFichaAccionMantenimiento1->FaaVerificar1 = 1;
																			$InsFichaAccionMantenimiento1->FaaVerificar2 = 1;
																			$InsFichaAccionMantenimiento1->FaaEstado = 2;
																			$InsFichaAccionMantenimiento1->FaaTiempoCreacion = date("Y-m-d H:i:s");
																			$InsFichaAccionMantenimiento1->FaaTiempoModificacion = date("Y-m-d H:i:s");

																			$InsFichaAccionMantenimiento1->FiaId = NULL;

																			$InsFichaAccionMantenimiento1->InsMysql = NULL;

																			$InsFichaAccion->FichaAccionMantenimiento[] = $InsFichaAccionMantenimiento1;
																		}
																	}

																	break;

																case "":
																	//die("No se encontro la MARCA DEL VEHICULO");
																	break;
															}
														}
													}
												}
											}




											if ($DatFichaIngresoModalidad->MinSigla == "CA") {

												if (!empty($InsFichaIngreso->CamId)) {

													$InsCampana = new ClsCampana();
													$InsCampana->CamId = $InsFichaIngreso->CamId;
													$InsCampana->MtdObtenerCampana(false);

													if (!empty($InsCampana->CamOperacionCodigo)) { //AUX

														$InsFichaAccionTempario1 = new ClsFichaAccionTempario($this->InsMysql);
														$InsFichaAccionTempario1->FaeId = NULL;
														$InsFichaAccionTempario1->FaeCodigo = $InsCampana->CamOperacionCodigo;
														$InsFichaAccionTempario1->FaeTiempo = $InsCampana->CamOperacionTiempo;
														$InsFichaAccionTempario1->FaeEstado = 1;
														$InsFichaAccionTempario1->FaeTiempoCreacion = date("Y-m-d H:i:s");
														$InsFichaAccionTempario1->FaeTiempoModificacion = date("Y-m-d H:i:s");
														$InsFichaAccionTempario1->FaeEliminado = 1;

														$InsFichaAccionTempario1->InsMysql = NULL;

														$InsFichaAccion->FichaAccionTempario[] = $InsFichaAccionTempario1;
													}
												}
											}







											if ($DatFichaIngresoModalidad->MinSigla == "PP") {

												$InsFichaAccionSalidaExterna1 = new ClsFichaAccionSalidaExterna($this->InsMysql);
												$InsFichaAccionSalidaExterna1->FsxFechaSalida = date("Y-m-d");
												$InsFichaAccionSalidaExterna1->FsxEstado = 1;
												$InsFichaAccionSalidaExterna1->FsxTiempoCreacion = date("Y-m-d H:i:s");
												$InsFichaAccionSalidaExterna1->FsxTiempoModificacion = date("Y-m-d H:i:s");

												$InsFichaAccion->FichaAccionSalidaExterna[] = $InsFichaAccionSalidaExterna1;
											}


											if ($InsFichaAccion->MtdRegistrarFichaAccion()) {
											}
										}
									}
								}
							}


							//deb($error);


							if (!$error) {

								$sql = 'UPDATE tblfinfichaingreso SET 
										FinEstado = ' . $oEstado . ',
										FinTiempoModificacion = NOW()					
										WHERE FinId = "' . $elemento . '"';

								$resultado = $this->InsMysql->MtdEjecutar($sql, false);

								if (!$resultado) {
									$error = true;
								} else {
									$Auditoria = $this->MtdDefinirAuditoria($oEstado);
									$this->FinId = $elemento;
									$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
								}
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_903';
						}

						break;

					case 5: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ALMACEN [Revisado Pedido]";

						if ($this->FinEstado == 4) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_904';
						}



						break;

					case 6: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ALMACEN [Preparando Pedido]";

						if (
							$this->FinEstado == 5 ||
							$this->FinEstado == 73 ||
							$this->FinEstado == 74

						) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_905';
						}


						break;

					case 7: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ALMACEN [Pedido Enviado]";

						if ($this->FinEstado == 6 || $this->FinEstado == 72) {


							//							$InsTallerPedido = new ClsTallerPedido($this->InsMysql);
							//									
							//									$ResTallerPedido = $InsTallerPedido->MtdObtenerTallerPedidos(NULL,NULL,NULL,'AmoId','ASC',NULL,NULL,NULL,NULL,NULL,$this->FinId);
							//									$ArrTallerPedidos = $ResTallerPedido['Datos'];				
							//
							//									if(!empty($ArrTallerPedidos)){
							//										
							//										$tpedido = "";
							//										foreach($ArrTallerPedidos as $DatTallerPedido){										
							//											$tpedido.="#".$DatTallerPedido->AmoId;
							//										}
							//										
							//										if(!$InsTallerPedido->MtdActualizarEstadoTallerPedido($tpedido,3,false)){
							//											$error = true;
							//										}
							//
							//									}

							//	if(!$error){

							$sql = 'UPDATE tblfinfichaingreso SET 
										FinEstado = ' . $oEstado . ',
										FinTiempoModificacion = NOW()					
										WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}


							//	}


							if (!$error) {

								if ($this->FinEstado == 6) {

									if (!empty($this->FinTiempoTallerConcluido)) {

										if (!$this->MtdActualizarEstadoFichaIngreso($this->FinId, 71, false)) {
											$error = true;
										}
									}
								}
							}

							//deb("xd");

							if (!$error) {

								//deb($this->FinEstado);
								//deb(":33");
								if ($this->FinEstado == 7) {

									if (!empty($this->FinTiempoTallerConcluido)) {

										if (!$this->MtdActualizarEstadoFichaIngreso($this->FinId, 73, false)) {
											$error = true;
										}
									}
								}
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_906';
						}

						break;

					case 71: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:TALLER [Pedido Recibido]";

						if (
							$this->FinEstado == 7
							|| $this->FinEstado == 73
							|| $this->FinEstado == 74
						) {

							if ($this->FinEstado == 73) {

								//									$ActualizarEstado = true;
								//	
								//									$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
								//									$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
								//									$InsFichaAccionProducto = new ClsFichaAccionProducto($this->InsMysql);
								//
								//
								//$ResFichaIngresoModalidad = $InsFichaIngresoModalidad->MtdObtenerFichaIngresoModalidades(NULL,NULL,'FimId','ASC',NULL,$this->FinId,NULL);
								//$ArrFichaIngresoModalidades = $ResFichaIngresoModalidad['Datos'];
								//												
								//foreach($ArrFichaIngresoModalidades as $DatFichaIngresoModalidad){
								//
								//	$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL,NULL,NULL,'FccId','ASC','1',$DatFichaIngresoModalidad->FimId,NULL,NULL,NULL);
								//	$ArrFichaAcciones = $ResFichaAccion['Datos'];
								//	
								//	foreach($ArrFichaAcciones as $DatFichaAccion){
								//			
								//		$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,1,"C");
								//		$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
								//		
								//		if(!empty($ArrFichaAccionProductos)){
								//			$ActualizarEstado = false;
								//		}
								//		
								//		$ResFichaAccionProducto = $InsFichaAccionProducto->MtdObtenerFichaAccionProductos(NULL,NULL,'FapId','ASC',NULL,$DatFichaAccion->FccId,NULL,NULL,2);
								//		$ArrFichaAccionProductos = $ResFichaAccionProducto['Datos'];
								//		
								//		if(!empty($ArrFichaAccionProductos)){
								//			$ActualizarEstado = false;
								//		}
								//		
								//	}
								//}
								//									
								//									
								//									if($ActualizarEstado){
								//										$oEstado = 3;
								//									}

								$this->FinTiempoTrabajoTerminado = NULL;
								$this->FinTiempoModificacion = date("Y-m-d H:i:s");
								$this->MtdEditarFichaIngresoTrabajoTerminado();
							}

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_907';
						}


						break;

					case 72: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:ALMACEN [Pedido Extornado]";

						if (
							$this->FinEstado == 7
							|| $this->FinEstado == 71
							|| $this->FinEstado == 72
						) {

							$sql = 'UPDATE tblfinfichaingreso SET 
								FinEstado = ' . $oEstado . ',
								FinTiempoModificacion = NOW()					
								WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_908';
						}

						break;




					case 73: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:TALLER [Trabajo Terminado]";

						//deb($this->FinEstado);
						if (
							$this->FinEstado == 7
							|| $this->FinEstado == 71
							|| $this->FinEstado == 72
							|| $this->FinEstado == 3
						) {

							$ActualizarEstado = true;

							if ($ActualizarEstado) {

								$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

								$resultado = $this->InsMysql->MtdEjecutar($sql, false);

								if (!$resultado) {
									$error = true;
									$Resultado .= '#OT: ' . $this->FinId;
									$Resultado .= '#ERR_FIN_9090';
								} else {

									if (!empty($this->FichaIngresoModalidad)) {
										foreach ($this->FichaIngresoModalidad as $DatFichaIngresoModalidad) {

											$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
											$InsFichaAccion->FncFichaAccionGenerarTallerPedido($DatFichaIngresoModalidad->FichaAccion->FccId);
										}
									}

									$this->FinTiempoTrabajoTerminado = date("Y-m-d H:i:s");
									$this->FinTiempoModificacion = date("Y-m-d H:i:s");
									$this->MtdEditarFichaIngresoTrabajoTerminado();

									if (empty($this->FinTiempoTallerConcluido)) {

										$this->FinTiempoTallerConcluido = date("Y-m-d H:i:s");
										$this->MtdEditarFichaIngresoTallerConcluido();
									}

									$this->MtdActualizarCierreFichaIngreso($this->FinId, 1, false);


									$Auditoria = $this->MtdDefinirAuditoria($oEstado);
									$this->FinId = $elemento;
									$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
								}
							} else {
								$error = true;
								$Resultado .= '#OT: ' . $this->FinId;
								$Resultado .= '#ERR_FIN_9090';
							}
						} else {

							//								deb($this->FinEstado);
							if ($this->FinEstado == 1  || $this->FinEstado == 11) {

								$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

								$resultado = $this->InsMysql->MtdEjecutar($sql, false);

								if (!$resultado) {
									$error = true;
									$Resultado .= '#OT: ' . $this->FinId;
									$Resultado .= '#ERR_FIN_9090';
								} else {

									foreach ($this->FichaIngresoModalidad as $DatFichaIngresoModalidad) {

										$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);
										$InsFichaIngresoModalidad->FncFichaIngresoModalidadGenerarFichaAccion($DatFichaIngresoModalidad->FimId);

										$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
										$ResFichaAccion = $InsFichaAccion->MtdObtenerFichaAcciones(NULL, NULL, NULL, 'FccId', 'ASC', '1', $DatFichaIngresoModalidad->FimId, NULL, NULL, NULL);
										$ArrFichaAcciones = $ResFichaAccion['Datos'];

										if (!empty($ArrFichaAcciones)) {
											foreach ($ArrFichaAcciones  as $DatFichaAccion) {

												$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
												$InsFichaAccion->FncFichaAccionGenerarTallerPedido($DatFichaAccion->FccId);
											}
										}
									}
								}
							} else {
								$error = true;
								$Resultado .= '#OT: ' . $this->FinId;
								$Resultado .= '#ERR_FIN_9090';
							}
						}


						break;

					case 74: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:RECEPCION [Revisando]";

						if ($this->FinEstado == 73 || $this->FinEstado == 75 || $this->FinEstado == 10) {

							$sql = 'UPDATE tblfinfichaingreso SET 
								FinEstado = ' . $oEstado . ',
								FinTiempoModificacion = NOW()					
								WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_910';
						}


						break;

					case 75: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:RECEPCION [Conforme/Por Facturar]";

						if ($this->FinEstado == 74 || $this->FinEstado == 9 || $this->FinEstado == 10) {

							$sql = 'UPDATE tblfinfichaingreso SET 
								FinEstado = ' . $oEstado . ',
								FinTiempoModificacion = NOW()					
								WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_911';
						}

						break;

					case 8: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Por Facturar]";

						break;

					case 9: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: CONTABILIDAD [Facturado]";						

						if ($this->FinEstado == 75) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_912';
						}


						break;


					case 10: //$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: CONTABILIDAD [Facturado]";						

						if ($this->FinEstado == 73 || $this->FinEstado == 74) {

							$sql = 'UPDATE tblfinfichaingreso SET 
									FinEstado = ' . $oEstado . ',
									FinTiempoModificacion = NOW()					
									WHERE FinId = "' . $elemento . '"';

							$resultado = $this->InsMysql->MtdEjecutar($sql, false);

							if (!$resultado) {
								$error = true;
							} else {
								$Auditoria = $this->MtdDefinirAuditoria($oEstado);
								$this->FinId = $elemento;
								$this->MtdAuditarFichaIngreso(2, $Auditoria, $elemento);
							}
						} else {

							$error = true;
							$Resultado .= '#OT: ' . $this->FinId;
							$Resultado .= '#ERR_FIN_914';
						}

						break;

					default:
						$Auditoria = "Error";
						break;
				}
			}
			$i++;
		}

		//deb($Auditoria);
		//deb($error);
		//deb($oTransaccion);
		if ($error) {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}
			return false;
		} else {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}
			return true;
		}
	}

	private function MtdDefinirAuditoria($oEstado)
	{

		$Auditoria = "";

		switch ($oEstado) {


			case 777:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ANULADO [Anulado]";
				break;


			case 1:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: RECEPCION [Pendiente]";
				break;

			case 11:

				//								$this->FinId = $elemento;
				//								$this->MtdObtenerFichaIngreso(false);
				//									
				//								$this->FinEstado = 1;
				//								
				//								if($this->FinEstado == 1){
				//									
				//									
				//								}


				//									if(!empty($this->FichaIngresoModalidad)){
				//										foreach($this->FichaIngresoModalidad as $DatFichaIngresoModalidad){
				//
				//											if(!empty($DatFichaIngresoModalidad->FichaAccion->FccId)){
				//
				//												$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
				//	
				//												if(!$InsFichaAccion->MtdEliminarFichaAccion($DatFichaIngresoModalidad->FichaAccion->FccId)){
				//													$error = true;
				//													break;
				//												}
				//
				//												
				//											}
				////											foreach($DatFichaIngresoModalidad->FichaAccion as $DatFichaAccion){
				////												deb($DatFichaAccion);
				////												echo "<hr>";
				////												$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
				////												//$InsFichaAccion->FccId = $DatFichaAccion->FccId;
				////												if(!$InsFichaAccion->MtdEliminarFichaAccion($DatFichaAccion->FccId)){
				////													$error = true;
				////													break;
				////												}
				////
				////											}
				//											
				//										}
				//									}

				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: RECEPCION [Enviado]";

				break;

			case 2:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Revisando]";
				break;

			case 3:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Preparando Pedido]";


				break;

			case 4:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Pedido Enviado]";
				break;

			case 5:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ALMACEN [Revisado Pedido]";
				break;

			case 6:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ALMACEN [Preparando Pedido]";
				break;

			case 7:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: ALMACEN [Pedido Enviado]";
				break;



			case 71:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:TALLER [Pedido Recibido]";
				break;

			case 72:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:ALMACEN [Pedido Extornado]";
				break;




			case 73:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:TALLER [Trabajo Terminado]";
				break;

			case 74:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:RECEPCION [Revisando]";
				break;

			case 75:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a:RECEPCION [Conforme/Por Facturar]";
				break;


			case 8:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: TALLER [Por Facturar]";
				break;

			case 9:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: CONTABILIDAD [Facturado]";
				break;


			case 10:
				$Auditoria = "Se actualizo el Estado de la Orden de Trabajo a: RECEPCION [No Facturable]";
				break;

			default:
				$Auditoria = "Error";
				break;
		}

		return $Auditoria;
	}


	public function MtdRegistrarFichaIngreso()
	{

		global $Resultado;
		$error = false;

		$this->MtdGenerarFichaIngresoId();

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'INSERT INTO tblfinfichaingreso (
			FinId,
			FinId2,
			SucId,
					
			CitId,
					
			EinId,
			CamId,
			OvvId,
			ObsId,
			OvmId,
			
			CliId,
			PerId,
			PerIdAsesor,
			PmaId,
			
			TreId,
						
			MonId,
			FinTipoCambio,
			
			FinManoObraPrecio,
			FinPrecioEstimado,
			
			FinConductor,
			FinTelefono,
			FinClienteEmail,
			
			FinDireccion,
			FinContacto,
			
			FinFecha,
			FinVentaFechaEntrega,
			
			FinFechaActividad,
			FinFechaGarantia,
			
			FinFechaEntrega,
			FinHoraEntrega,

			FinFechaEntregaExtendida,
			FinHoraEntregaExtendida,

			FinFechaCita,
			
			FinHora,
			FinPlaca,

			FinMantenimientoKilometraje,			
			FinVehiculoKilometraje,			
			FinObservacion,		
			
			FinExteriorDelantero1,
			FinExteriorDelantero2,
			FinExteriorDelantero3,
			FinExteriorDelantero4,
			FinExteriorDelantero5,
			FinExteriorDelantero6,
			FinExteriorDelantero7,
			
			FinExteriorPosterior1,
			FinExteriorPosterior2,
			FinExteriorPosterior3,
			FinExteriorPosterior4,
			FinExteriorPosterior5,
			FinExteriorPosterior6,
			
			FinExteriorDerecho1,
			FinExteriorDerecho2,
			FinExteriorDerecho3,
			FinExteriorDerecho4,
			FinExteriorDerecho5,
			FinExteriorDerecho6,
			FinExteriorDerecho7,
			FinExteriorDerecho8,
			
			FinExteriorIzquierdo1,
			FinExteriorIzquierdo2,
			FinExteriorIzquierdo3,
			FinExteriorIzquierdo4,
			FinExteriorIzquierdo5,
			FinExteriorIzquierdo6,
			FinExteriorIzquierdo7,
			
			
			FinInterior1,
			FinInterior2,
			FinInterior3,
			FinInterior4,
			FinInterior5,
			FinInterior6,
			FinInterior7,
			FinInterior8,
			FinInterior9,
			FinInterior10,
			FinInterior11,
			FinInterior12,
			FinInterior13,
			FinInterior14,
			FinInterior15,
			FinInterior16,
			FinInterior17,
			FinInterior18,
			FinInterior19,
			FinInterior20,
			FinInterior21,
			FinInterior22,
			FinInterior23,
			FinInterior24,
			FinInterior25,
			FinInterior26,
			FinInterior27,
			
			FinNota,
			
			FinActaEntregaFecha,
		
			FinInformeTecnicoMantenimiento,
			FinInformeTecnicoRevision,
			FinInformeTecnicoDiagnostico,
			
			FinSalidaFecha,
			FinSalidaHora,
			FinSalidaObservacion,
			FinTerminadoObservacion,
			FinAlmacenObservacion,
			FinPrioridad,
			
			FinTiempoTallerConcluido,
			FinTiempoTallerRevisando,
			FinTiempoTrabajoTerminado,
			
			
			FinMontoPresupuesto,
			FinTipo,
			FinModalidad,
			FinOrigenEntrega,
			FinIndicacionTecnico,
			
			FinCierre,
			FinReferencia,
			
			FinCita,
			FinEstado,
			FinTiempoCreacion,
			FinTiempoModificacion
			) 
			VALUES (
			"' . ($this->FinId) . '",
			"' . ($this->FinId2) . '",
			"' . ($this->SucId) . '",
			
			' . (empty($this->CitId) ? "NULL," : '"' . $this->CitId . '",') . '
			
			' . (empty($this->EinId) ? "NULL," : '"' . $this->EinId . '",') . '
			' . (empty($this->CamId) ? "NULL," : '"' . $this->CamId . '",') . '
			' . (empty($this->OvvId) ? "NULL," : '"' . $this->OvvId . '",') . '
			' . (empty($this->ObsId) ? "NULL," : '"' . $this->ObsId . '",') . '
			' . (empty($this->OvmId) ? "NULL," : '"' . $this->OvmId . '",') . '
			
			' . (empty($this->CliId) ? 'NULL,' : '"' . $this->CliId . '",') . '
			' . (empty($this->PerId) ? 'NULL,' : '"' . $this->PerId . '",') . '
			' . (empty($this->PerIdAsesor) ? 'NULL,' : '"' . $this->PerIdAsesor . '",') . '
			
			' . (empty($this->PmaId) ? 'NULL,' : '"' . $this->PmaId . '",') . '
			
			' . (empty($this->TreId) ? 'NULL,' : '"' . $this->TreId . '",') . '


			' . (empty($this->MonId) ? 'NULL,' : '"' . $this->MonId . '",') . '
			NULL,

			0,
			' . ($this->FinPrecioEstimado) . ',
			
			"' . ($this->FinConductor) . '",
			"' . ($this->FinTelefono) . '",
			"' . ($this->FinClienteEmail) . '",
			
			
			
			"' . ($this->FinDireccion) . '",
			"' . ($this->FinContacto) . '",
			
			"' . ($this->FinFecha) . '", 
			NULL,
			' . (empty($this->FinFechaActividad) ? 'NULL,' : '"' . $this->FinFechaActividad . '",') . '
			' . (empty($this->FinFechaGarantia) ? 'NULL,' : '"' . $this->FinFechaGarantia . '",') . '		
			
			' . (empty($this->FinFechaEntrega) ? 'NULL,' : '"' . $this->FinFechaEntrega . '",') . '		
			' . (empty($this->FinHoraEntrega) ? 'NULL,' : '"' . $this->FinHoraEntrega . '",') . ' 

			' . (empty($this->FinFechaEntregaExtendida) ? 'NULL,' : '"' . $this->FinFechaEntregaExtendida . '",') . '		
			' . (empty($this->FinHoraEntregaExtendida) ? 'NULL,' : '"' . $this->FinHoraEntregaExtendida . '",') . '
			
			' . (empty($this->FinFechaCita) ? 'NULL,' : '"' . $this->FinFechaCita . '",') . '		
			
			' . (empty($this->FinHora) ? 'NULL,' : '"' . $this->FinHora . '",') . '
			"' . ($this->FinPlaca) . '", 

			' . ($this->FinMantenimientoKilometraje) . ',
			' . ($this->FinVehiculoKilometraje) . ',
			"' . ($this->FinObservacion) . '",
			
			' . ($this->FinExteriorDelantero1) . ',
			' . ($this->FinExteriorDelantero2) . ',
			' . ($this->FinExteriorDelantero3) . ',
			' . ($this->FinExteriorDelantero4) . ',
			' . ($this->FinExteriorDelantero5) . ',
			' . ($this->FinExteriorDelantero6) . ',
			' . ($this->FinExteriorDelantero7) . ',
			
			' . ($this->FinExteriorPosterior1) . ',
			' . ($this->FinExteriorPosterior2) . ',
			' . ($this->FinExteriorPosterior3) . ',
			' . ($this->FinExteriorPosterior4) . ',
			' . ($this->FinExteriorPosterior5) . ',
			' . ($this->FinExteriorPosterior6) . ',
			
			' . ($this->FinExteriorDerecho1) . ',
			' . ($this->FinExteriorDerecho2) . ',
			' . ($this->FinExteriorDerecho3) . ',
			' . ($this->FinExteriorDerecho4) . ',
			' . ($this->FinExteriorDerecho5) . ',
			' . ($this->FinExteriorDerecho6) . ',
			' . ($this->FinExteriorDerecho7) . ',
			' . ($this->FinExteriorDerecho8) . ',
			
			' . ($this->FinExteriorIzquierdo1) . ',
			' . ($this->FinExteriorIzquierdo2) . ',
			' . ($this->FinExteriorIzquierdo3) . ',
			' . ($this->FinExteriorIzquierdo4) . ',
			' . ($this->FinExteriorIzquierdo5) . ',
			' . ($this->FinExteriorIzquierdo6) . ',
			' . ($this->FinExteriorIzquierdo7) . ',
			
			' . ($this->FinInterior1) . ',
			' . ($this->FinInterior2) . ',
			' . ($this->FinInterior3) . ',
			' . ($this->FinInterior4) . ',
			' . ($this->FinInterior5) . ',
			' . ($this->FinInterior6) . ',
			' . ($this->FinInterior7) . ',
			' . ($this->FinInterior8) . ',
			' . ($this->FinInterior9) . ',
			' . ($this->FinInterior10) . ',
			' . ($this->FinInterior11) . ',
			' . ($this->FinInterior12) . ',
			' . ($this->FinInterior13) . ',
			' . ($this->FinInterior14) . ',
			' . ($this->FinInterior15) . ',
			' . ($this->FinInterior16) . ',
			' . ($this->FinInterior17) . ',
			' . ($this->FinInterior18) . ',
			' . ($this->FinInterior19) . ',
			' . ($this->FinInterior20) . ',
			' . ($this->FinInterior21) . ',
			' . ($this->FinInterior22) . ',
			' . ($this->FinInterior23) . ',
			' . ($this->FinInterior24) . ',
			' . ($this->FinInterior25) . ',
			' . ($this->FinInterior26) . ',
			' . ($this->FinInterior27) . ',
			
			"' . ($this->FinNota) . '",
			
			NULL,
			
			"' . ($this->FinInformeTecnicoMantenimiento) . '",
			"' . ($this->FinInformeTecnicoRevision) . '",
			"' . ($this->FinInformeTecnicoDiagnostico) . '",
			
			' . (empty($this->FinSalidaFecha) ? 'NULL,' : '"' . $this->FinSalidaFecha . '",') . '	
			' . (empty($this->FinSalidaHora) ? 'NULL,' : '"' . $this->FinSalidaHora . '",') . '	

			"' . ($this->FinSalidaObservacion) . '",
			"' . ($this->FinTerminadoObservacion) . '",
			"' . ($this->FinAlmacenObservacion) . '",
			
			
			' . ($this->FinPrioridad) . ',
			
			NULL,
			NULL,
			NULL,
			
			' . ($this->FinMontoPresupuesto) . ',
			' . ($this->FinTipo) . ',
			
				"' . ($this->FinModalidad) . '",

			"' . ($this->FinOrigenEntrega) . '",
			"' . ($this->FinIndicacionTecnico) . '",
			
			2,
			
			"' . ($this->FinReferencia) . '",
			
			"' . ($this->FinCita) . '",
			' . ($this->FinEstado) . ',
			"' . ($this->FinTiempoCreacion) . '", 				
			"' . ($this->FinTiempoModificacion) . '");';



		//			'.(empty($this->MonId)?'NULL,':'"'.$this->MonId.'",').'
		//			'.(empty($this->FinTipoCambio)?'NULL,':'"'.$this->FinTipoCambio.'",').'


		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if (!$error) {
			if (!empty($this->EinId)) {
				if (!empty($this->CliId)) {

					$InsVehiculoIngreso = new ClsVehiculoIngreso($this->InsMysql);

					if (!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId, $this->CliId)) {
						$error = true;
						$Resultado .= '#ERR_FIN_604';
					}

					$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente($this->InsMysql);
					$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL, NULL, 'VicId', 'ASC', NULL, $this->EinId, $this->CliId);

					$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];

					if (empty($ArrVehiculoIngresoClientes)) {

						$InsVehiculoIngresoCliente->CliId = $this->CliId;
						$InsVehiculoIngresoCliente->EinId = $this->EinId;
						$InsVehiculoIngresoCliente->VicEstado = 3;
						$InsVehiculoIngresoCliente->VicTiempoCreacion = date("Y-m-d H:i:s");
						$InsVehiculoIngresoCliente->VicTiempoModificacion = date("Y-m-d H:i:s");
						$InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();

						$InsVehiculoIngresoCliente->MtdEditarVehiculoIngresoDato("VicObservacion", "Desde registrar OT", $InsVehiculoIngresoCliente->VicId);
					}


					//$InsVehiculoIngresoCliente->CliId = $this->CliId;
					//						$InsVehiculoIngresoCliente->EinId = $this->EinId;
					//						$InsVehiculoIngresoCliente->VicEstado = 3;
					//						$InsVehiculoIngresoCliente->VicTiempoCreacion = date("d/m/Y H:i:s");
					//						$InsVehiculoIngresoCliente->VicTiempoModificacion = date("d/m/Y H:i:s");
					//						 
					//						 $ResVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();


					//			$this->MtdGenerarVehiculoIngresoClienteId();
					//			
					//			$sql = 'INSERT INTO tblvicvehiculoingresocliente (
					//				VicId,
					//				CliId,
					//				EinId, 
					//				VicEstado,
					//				VicTiempoCreacion,
					//				VicTiempoModificacion) 
					//				VALUES (
					//				"'.($this->VicId).'", 
					//				"'.($this->CliId).'", 
					//				"'.($this->EinId).'", 
					//				'.($this->VicEstado).', 
					//				"'.($this->VicTiempoCreacion).'", 
					//				"'.($this->VicTiempoModificacion).'");';	


				} else {
					$error = true;
					$Resultado .= '#ERR_FIN_602';
				}
			} else {
				$error = true;
				$Resultado .= '#ERR_FIN_601';
			}
		}

		if (!$error) {
			$InsVehiculoIngreso = new ClsVehiculoIngreso($this->InsMysql);

			if (!$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinPlaca", $this->FinPlaca, $this->EinId)) {
				$Resultado .= '#ERR_FIN_605';
				$error = true;
			}

			//if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoPlaca($this->EinId,$this->FinPlaca)){
			//					$Resultado.='#ERR_FIN_605';		
			//					$error = true;
			//				}
		}


		if (!$error) {

			if (!empty($this->PreEntregaDetalle)) {

				$validar = 0;
				$InsPreEntregaDetalle = new ClsPreEntregaDetalle($this->InsMysql);

				foreach ($this->PreEntregaDetalle as $DatPreEntregaDetalle) {

					$InsPreEntregaTarea = new ClsPreEntregaTarea($this->InsMysql);
					$InsPreEntregaTarea->PetId = $DatPreEntregaDetalle->PetId;
					$InsPreEntregaTarea->MtdObtenerPreEntregaTarea();

					$InsPreEntregaDetalle->FinId = $this->FinId;
					$InsPreEntregaDetalle->PetId = $DatPreEntregaDetalle->PetId;
					$InsPreEntregaDetalle->RedAccion = $DatPreEntregaDetalle->RedAccion;
					$InsPreEntregaDetalle->RedTiempoCreacion = $DatPreEntregaDetalle->RedTiempoCreacion;
					$InsPreEntregaDetalle->RedTiempoCreacion = $DatPreEntregaDetalle->RedTiempoModificacion;

					$InsPreEntregaDetalle->RedEliminado = $DatPreEntregaDetalle->RedEliminado;

					if ($InsPreEntregaDetalle->MtdRegistrarPreEntregaDetalle()) {
						$validar++;
					} else {
						$Resultado .= '#Tarea: ' . strtoupper($InsPreEntregaTarea->PetNombre);
						$Resultado .= '#ERR_FIN_301'; //REVISAR
					}
				}

				if (count($this->PreEntregaDetalle) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FichaIngresoModalidad)) {

				$validar = 0;
				$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);

				foreach ($this->FichaIngresoModalidad as $DatFichaIngresoModalidad) {

					$InsModalidadIngreso = new ClsModalidadIngreso();
					$InsModalidadIngreso->MinId = $DatFichaIngresoModalidad->MinId;
					$InsModalidadIngreso->MtdObtenerModalidadIngreso();

					$InsFichaIngresoModalidad->FinId = $this->FinId;
					$InsFichaIngresoModalidad->MinId = $DatFichaIngresoModalidad->MinId;
					$InsFichaIngresoModalidad->FimObsequio = $DatFichaIngresoModalidad->FimObsequio;

					$InsFichaIngresoModalidad->FimEstado = $DatFichaIngresoModalidad->FimEstado;
					$InsFichaIngresoModalidad->FichaIngresoProducto = $DatFichaIngresoModalidad->FichaIngresoProducto;
					$InsFichaIngresoModalidad->FichaIngresoTarea = $DatFichaIngresoModalidad->FichaIngresoTarea;
					$InsFichaIngresoModalidad->FichaIngresoManoObra = $DatFichaIngresoModalidad->FichaIngresoManoObra;
					$InsFichaIngresoModalidad->FichaIngresoSuministro = $DatFichaIngresoModalidad->FichaIngresoSuministro;
					$InsFichaIngresoModalidad->FichaIngresoMantenimiento = $DatFichaIngresoModalidad->FichaIngresoMantenimiento;

					$InsFichaIngresoModalidad->FimTiempoCreacion = $DatFichaIngresoModalidad->FimTiempoCreacion;
					$InsFichaIngresoModalidad->FimTiempoModificacion = $DatFichaIngresoModalidad->FimTiempoModificacion;
					$InsFichaIngresoModalidad->FimEliminado = $DatFichaIngresoModalidad->FimEliminado;

					$InsFichaIngresoModalidad->FichaAccion = $DatFichaIngresoModalidad->FichaAccion;

					if ($InsFichaIngresoModalidad->MtdRegistrarFichaIngresoModalidad()) {
						$validar++;
					} else {
						$Resultado .= '#Modalidad: ' . strtoupper($InsModalidadIngreso->MinNombre);
						$Resultado .= '#ERR_FIN_201';
					}
				}

				if (count($this->FichaIngresoModalidad) <> $validar) {
					$error = true;
				}
			}
		}


		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			$this->MtdAuditarFichaIngreso(1, "Se registro la Orden de Trabajo", $this);
			return true;
		}
	}

	public function MtdEditarFichaIngreso()
	{

		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		//	'.(empty($this->MonId)?'MonId = NULL, ':'MonId = "'.$this->MonId.'",').'
		//			'.(empty($this->FinTipoCambio)?'FinTipoCambio = NULL, ':'FinTipoCambio = "'.$this->FinTipoCambio.'",').'

		$sql = 'UPDATE tblfinfichaingreso SET
		
			' . (empty($this->CliId) ? 'CliId = NULL, ' : 'CliId = "' . $this->CliId . '",') . '
			' . (empty($this->EinId) ? 'EinId = NULL, ' : 'EinId = "' . $this->EinId . '",') . '
			' . (empty($this->CamId) ? 'CamId = NULL, ' : 'CamId = "' . $this->CamId . '",') . '
			' . (empty($this->OvvId) ? 'OvvId = NULL, ' : 'OvvId = "' . $this->OvvId . '",') . '
			' . (empty($this->ObsId) ? 'ObsId = NULL, ' : 'ObsId = "' . $this->ObsId . '",') . '
			' . (empty($this->OvmId) ? 'OvmId = NULL, ' : 'OvmId = "' . $this->OvmId . '",') . '
			
			' . (empty($this->PerId) ? 'PerId = NULL, ' : 'PerId = "' . $this->PerId . '",') . '
			' . (empty($this->PerIdAsesor) ? 'PerIdAsesor = NULL, ' : 'PerIdAsesor = "' . $this->PerIdAsesor . '",') . '
			
			' . (empty($this->PmaId) ? 'PmaId = NULL, ' : 'PmaId = "' . $this->PmaId . '",') . '
			
			' . (empty($this->TreId) ? 'TreId = NULL, ' : 'TreId = "' . $this->TreId . '",') . '
			
			
			FinPrecioEstimado = ' . ($this->FinPrecioEstimado) . ',

			FinConductor = "' . ($this->FinConductor) . '",
			FinTelefono = "' . ($this->FinTelefono) . '",
			FinClienteEmail = "' . ($this->FinClienteEmail) . '",
			FinDireccion = "' . ($this->FinDireccion) . '",
			FinContacto = "' . ($this->FinContacto) . '",
			
			FinFecha = "' . ($this->FinFecha) . '",
			
			' . (empty($this->FinFechaEntrega) ? 'FinFechaEntrega = NULL, ' : 'FinFechaEntrega = "' . $this->FinFechaEntrega . '",') . '
			' . (empty($this->FinHoraEntrega) ? 'FinHoraEntrega = NULL, ' : 'FinHoraEntrega = "' . $this->FinHoraEntrega . '",') . '

		

			' . (empty($this->FinFechaEntregaExtendida) ? 'FinFechaEntregaExtendida = NULL, ' : 'FinFechaEntregaExtendida = "' . $this->FinFechaEntregaExtendida . '",') . '
		

			' . (empty($this->FinHoraEntregaExtendida) ? 'FinHoraEntregaExtendida = NULL, ' : 'FinHoraEntregaExtendida = "' . $this->FinHoraEntregaExtendida . '",') . '

			
			' . (empty($this->FinFechaCita) ? 'FinFechaCita = NULL, ' : 'FinFechaCita = "' . $this->FinFechaCita . '",') . '
			
			FinHora = "' . ($this->FinHora) . '",
			FinPlaca = "' . ($this->FinPlaca) . '",

			FinMantenimientoKilometraje = ' . ($this->FinMantenimientoKilometraje) . ',						
			FinVehiculoKilometraje = ' . ($this->FinVehiculoKilometraje) . ',			
			FinObservacion = "' . ($this->FinObservacion) . '",
			
			FinExteriorDelantero1 = ' . ($this->FinExteriorDelantero1) . ',
			FinExteriorDelantero2 = ' . ($this->FinExteriorDelantero2) . ',
			FinExteriorDelantero3 = ' . ($this->FinExteriorDelantero3) . ',
			FinExteriorDelantero4 = ' . ($this->FinExteriorDelantero4) . ',
			FinExteriorDelantero5 = ' . ($this->FinExteriorDelantero5) . ',
			FinExteriorDelantero6 = ' . ($this->FinExteriorDelantero6) . ',
			FinExteriorDelantero7 = ' . ($this->FinExteriorDelantero7) . ',
			
			FinExteriorPosterior1 = ' . ($this->FinExteriorPosterior1) . ',
			FinExteriorPosterior2 = ' . ($this->FinExteriorPosterior2) . ',
			FinExteriorPosterior3 = ' . ($this->FinExteriorPosterior3) . ',
			FinExteriorPosterior4 = ' . ($this->FinExteriorPosterior4) . ',
			FinExteriorPosterior5 = ' . ($this->FinExteriorPosterior5) . ',
			FinExteriorPosterior6 = ' . ($this->FinExteriorPosterior6) . ',
			
			FinExteriorDerecho1 = ' . ($this->FinExteriorDerecho1) . ',
			FinExteriorDerecho2 = ' . ($this->FinExteriorDerecho2) . ',
			FinExteriorDerecho3 = ' . ($this->FinExteriorDerecho3) . ',
			FinExteriorDerecho4 = ' . ($this->FinExteriorDerecho4) . ',
			FinExteriorDerecho5 = ' . ($this->FinExteriorDerecho5) . ',
			FinExteriorDerecho6 = ' . ($this->FinExteriorDerecho6) . ',
			FinExteriorDerecho7 = ' . ($this->FinExteriorDerecho7) . ',
			FinExteriorDerecho8 = ' . ($this->FinExteriorDerecho8) . ',
			
			FinExteriorIzquierdo1 = ' . ($this->FinExteriorIzquierdo1) . ',
			FinExteriorIzquierdo2 = ' . ($this->FinExteriorIzquierdo2) . ',
			FinExteriorIzquierdo3 = ' . ($this->FinExteriorIzquierdo3) . ',
			FinExteriorIzquierdo4 = ' . ($this->FinExteriorIzquierdo4) . ',
			FinExteriorIzquierdo5 = ' . ($this->FinExteriorIzquierdo5) . ',
			FinExteriorIzquierdo6 = ' . ($this->FinExteriorIzquierdo6) . ',
			FinExteriorIzquierdo7 = ' . ($this->FinExteriorIzquierdo7) . ',
			
			
			FinInterior1 = ' . ($this->FinInterior1) . ',
			FinInterior2 = ' . ($this->FinInterior2) . ',
			FinInterior3 = ' . ($this->FinInterior3) . ',
			FinInterior4 = ' . ($this->FinInterior4) . ',
			FinInterior5 = ' . ($this->FinInterior5) . ',
			FinInterior6 = ' . ($this->FinInterior6) . ',
			FinInterior7 = ' . ($this->FinInterior7) . ',
			FinInterior8 = ' . ($this->FinInterior8) . ',
			FinInterior9 = ' . ($this->FinInterior9) . ',
			FinInterior10 = ' . ($this->FinInterior10) . ',
			FinInterior11 = ' . ($this->FinInterior11) . ',
			FinInterior12 = ' . ($this->FinInterior12) . ',
			FinInterior13 = ' . ($this->FinInterior13) . ',
			FinInterior14 = ' . ($this->FinInterior14) . ',
			FinInterior15 = ' . ($this->FinInterior15) . ',
			FinInterior16 = ' . ($this->FinInterior16) . ',
			FinInterior17 = ' . ($this->FinInterior17) . ',
			FinInterior18 = ' . ($this->FinInterior18) . ',
			FinInterior19 = ' . ($this->FinInterior19) . ',
			FinInterior20 = ' . ($this->FinInterior20) . ',
			FinInterior21 = ' . ($this->FinInterior21) . ',
			FinInterior22 = ' . ($this->FinInterior22) . ',
			FinInterior23 = ' . ($this->FinInterior23) . ',
			FinInterior24 = ' . ($this->FinInterior24) . ',
			FinInterior25 = ' . ($this->FinInterior25) . ',
			FinInterior26 = ' . ($this->FinInterior26) . ',
			FinInterior27 = ' . ($this->FinInterior27) . ',
			
			FinNota = "' . ($this->FinNota) . '",
		
			FinInformeTecnicoMantenimiento = "' . ($this->FinInformeTecnicoMantenimiento) . '",
			FinInformeTecnicoRevision = "' . ($this->FinInformeTecnicoRevision) . '",
			FinInformeTecnicoDiagnostico = "' . ($this->FinInformeTecnicoDiagnostico) . '",
			' . (empty($this->FinSalidaFecha) ? 'FinSalidaFecha = NULL, ' : 'FinSalidaFecha = "' . $this->FinSalidaFecha . '",') . '
		
			' . (empty($this->FinSalidaHora) ? 'FinSalidaHora = NULL, ' : 'FinSalidaHora = "' . $this->FinSalidaHora . '",') . '

			FinSalidaObservacion = "' . ($this->FinSalidaObservacion) . '",
	
			FinPrioridad = ' . ($this->FinPrioridad) . ',
			FinOrigenEntrega = "' . ($this->FinOrigenEntrega) . '",
			
			FinMontoPresupuesto = ' . ($this->FinMontoPresupuesto) . ',
			
			
			FinIndicacionTecnico = "' . ($this->FinIndicacionTecnico) . '",
			FinReferencia = "' . ($this->FinReferencia) . '",
			
			
			FinCita = "' . ($this->FinCita) . '",
			FinEstado = ' . ($this->FinEstado) . ',
			FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
			WHERE FinId = "' . ($this->FinId) . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		//			if(!$error){
		//				
		//				$InsVehiculoIngreso = new ClsVehiculoIngreso();
		//				if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId,$this->CliId)){
		//					$error = true;
		//				}
		//			}

		if (!$error) {
			if (!empty($this->EinId)) {
				if (!empty($this->CliId)) {


					$InsVehiculoIngreso = new ClsVehiculoIngreso();

					if (!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoCliente($this->EinId, $this->CliId)) {
						$error = true;
						$Resultado .= '#ERR_FIN_604';
					}


					$InsVehiculoIngresoCliente = new ClsVehiculoIngresoCliente();
					$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL, NULL, 'VicId', 'ASC', NULL, $this->EinId, $this->CliId);

					$ArrVehiculoIngresoClientes = $ResVehiculoIngresoCliente['Datos'];

					if (empty($ArrVehiculoIngresoClientes)) {

						$InsVehiculoIngresoCliente->CliId = $this->CliId;
						$InsVehiculoIngresoCliente->EinId = $this->EinId;
						$InsVehiculoIngresoCliente->VicEstado = 3;
						$InsVehiculoIngresoCliente->VicTiempoCreacion = date("Y-m-d H:i:s");
						$InsVehiculoIngresoCliente->VicTiempoModificacion = date("Y-m-d H:i:s");
						$InsVehiculoIngresoCliente->MtdRegistrarVehiculoIngresoCliente();

						$InsVehiculoIngresoCliente->MtdEditarVehiculoIngresoDato("VicObservacion", "Desde editar OT", $InsVehiculoIngresoCliente->VicId);
					}
				} else {
					$Resultado .= '#ERR_FIN_602';
				}
			} else {
				$Resultado .= '#ERR_FIN_601';
			}
		}

		if (!$error) {
			$InsVehiculoIngreso = new ClsVehiculoIngreso();


			if (!$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinPlaca", $this->FinPlaca, $this->EinId)) {
				$Resultado .= '#ERR_FIN_605';
				$error = true;
			}

			//if(!$InsVehiculoIngreso->MtdActualizarVehiculoIngresoPlaca($this->EinId,$this->FinPlaca)){
			//					$error = true;
			//					$Resultado.='#ERR_FIN_605';
			//				}
		}

		if (!$error) {
			if (!empty($this->FichaIngresoModalidad)) {

				$validar = 0;

				$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);

				foreach ($this->FichaIngresoModalidad as $DatFichaIngresoModalidad) {

					$InsModalidadIngreso = new ClsModalidadIngreso();
					$InsModalidadIngreso->MinId = $DatFichaIngresoModalidad->MinId;
					$InsModalidadIngreso->MtdObtenerModalidadIngreso();

					$InsFichaIngresoModalidad->FimId = $DatFichaIngresoModalidad->FimId;
					$InsFichaIngresoModalidad->FinId = $this->FinId;
					$InsFichaIngresoModalidad->MinId = $DatFichaIngresoModalidad->MinId;
					$InsFichaIngresoModalidad->FimObsequio = $DatFichaIngresoModalidad->FimObsequio;
					$InsFichaIngresoModalidad->FimEstado = $DatFichaIngresoModalidad->FimEstado;

					$InsFichaIngresoModalidad->FichaIngresoProducto = $DatFichaIngresoModalidad->FichaIngresoProducto;
					$InsFichaIngresoModalidad->FichaIngresoTarea = $DatFichaIngresoModalidad->FichaIngresoTarea;
					$InsFichaIngresoModalidad->FichaIngresoManoObra = $DatFichaIngresoModalidad->FichaIngresoManoObra;
					$InsFichaIngresoModalidad->FichaIngresoSuministro = $DatFichaIngresoModalidad->FichaIngresoSuministro;
					$InsFichaIngresoModalidad->FichaIngresoMantenimiento = $DatFichaIngresoModalidad->FichaIngresoMantenimiento;

					$InsFichaIngresoModalidad->FimTiempoCreacion = $DatFichaIngresoModalidad->FimTiempoCreacion;
					$InsFichaIngresoModalidad->FimTiempoModificacion = $DatFichaIngresoModalidad->FimTiempoModificacion;
					$InsFichaIngresoModalidad->FimEliminado = $DatFichaIngresoModalidad->FimEliminado;

					$InsFichaIngresoModalidad->FichaAccion = $DatFichaIngresoModalidad->FichaAccion;

					if (empty($InsFichaIngresoModalidad->FimId)) {
						if ($InsFichaIngresoModalidad->FimEliminado <> 2) {
							if ($InsFichaIngresoModalidad->MtdRegistrarFichaIngresoModalidad()) {
								$validar++;
							} else {
								$Resultado .= '#Modalidad: ' . strtoupper($InsModalidadIngreso->MinNombre);
								$Resultado .= '#ERR_FIN_201';
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoModalidad->FimEliminado == 2) {
							if ($InsFichaIngresoModalidad->MtdEliminarFichaIngresoModalidad($InsFichaIngresoModalidad->FimId)) {
								$validar++;
							} else {
								$Resultado .= '#Modalidad: ' . strtoupper($InsModalidadIngreso->MinNombre);
								$Resultado .= '#ERR_FIN_203';
							}
						} else {
							if ($InsFichaIngresoModalidad->MtdEditarFichaIngresoModalidad()) {
								$validar++;
							} else {
								$Resultado .= '#Modalidad: ' . strtoupper($InsModalidadIngreso->MinNombre);
								$Resultado .= '#ERR_FIN_202';
							}
						}
					}
				}

				if (count($this->FichaIngresoModalidad) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {
			if (!empty($this->PreEntregaDetalle)) {

				$validar = 0;

				$InsPreEntregaDetalle = new ClsPreEntregaDetalle($this->InsMysql);

				foreach ($this->PreEntregaDetalle as $DatPreEntregaDetalle) {

					$InsPreEntregaTarea = new ClsPreEntregaTarea();
					$InsPreEntregaTarea->PetId = $DatPreEntregaDetalle->PetId;
					$InsPreEntregaTarea->MtdObtenerPreEntregaTarea();

					$InsPreEntregaDetalle->RedId = $DatPreEntregaDetalle->RedId;
					$InsPreEntregaDetalle->FinId = $this->FinId;
					$InsPreEntregaDetalle->PetId = $DatPreEntregaDetalle->PetId;
					$InsPreEntregaDetalle->RedAccion = $DatPreEntregaDetalle->RedAccion;

					$InsPreEntregaDetalle->RedTiempoCreacion = $DatPreEntregaDetalle->RedTiempoCreacion;
					$InsPreEntregaDetalle->RedTiempoModificacion = $DatPreEntregaDetalle->RedTiempoModificacion;
					$InsPreEntregaDetalle->RedEliminado = $DatPreEntregaDetalle->RedEliminado;

					$InsPreEntregaDetalle->FichaAccion = $DatPreEntregaDetalle->FichaAccion;

					if (empty($InsPreEntregaDetalle->RedId)) {
						if ($InsPreEntregaDetalle->RedEliminado <> 2) {
							if ($InsPreEntregaDetalle->MtdRegistrarPreEntregaDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#Tarea: ' . strtoupper($InsModalidadIngreso->PetNombre);
								$Resultado .= '#ERR_FIN_301';
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsPreEntregaDetalle->RedEliminado == 2) {
							if ($InsPreEntregaDetalle->MtdEliminarPreEntregaDetalle($InsPreEntregaDetalle->RedId)) {
								$validar++;
							} else {
								$Resultado .= '#Tarea: ' . strtoupper($InsModalidadIngreso->PetNombre);
								$Resultado .= '#ERR_FIN_303';
							}
						} else {
							if ($InsPreEntregaDetalle->MtdEditarPreEntregaDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#Tarea: ' . strtoupper($InsModalidadIngreso->PetNombre);
								$Resultado .= '#ERR_FIN_302';
							}
						}
					}
				}

				if (count($this->PreEntregaDetalle) <> $validar) {
					$error = true;
				}
			}
		}



		if (!$error) {
			if (!empty($this->FichaIngresoHerramienta)) {

				$validar = 0;
				$item = 1;
				$InsFichaIngresoHerramienta = new ClsFichaIngresoHerramienta($this->InsMysql);

				foreach ($this->FichaIngresoHerramienta as $DatFichaIngresoHerramienta) {

					$InsProducto = new ClsProducto();
					$InsProducto->ProId = $DatFichaIngresoHerramienta->ProId;
					$InsProducto->MtdObtenerProducto(false);

					$InsFichaIngresoHerramienta->FihId = $DatFichaIngresoHerramienta->FihId;
					$InsFichaIngresoHerramienta->FinId = $this->FinId;
					$InsFichaIngresoHerramienta->ProId = $DatFichaIngresoHerramienta->ProId;
					$InsFichaIngresoHerramienta->UmeId = $DatFichaIngresoHerramienta->UmeId;
					$InsFichaIngresoHerramienta->FihCantidad = $DatFichaIngresoHerramienta->FihCantidad;
					$InsFichaIngresoHerramienta->FihCantidadReal = $DatFichaIngresoHerramienta->FihCantidadReal;
					$InsFichaIngresoHerramienta->FihEstado = $DatFichaIngresoHerramienta->FihEstado;
					$InsFichaIngresoHerramienta->FihTiempoCreacion = $DatFichaIngresoHerramienta->FihTiempoCreacion;
					$InsFichaIngresoHerramienta->FihTiempoModificacion = $DatFichaIngresoHerramienta->FihTiempoModificacion;
					$InsFichaIngresoHerramienta->FimEliminado = $DatFichaIngresoHerramienta->FimEliminado;

					if (empty($InsFichaIngresoHerramienta->FihId)) {
						if ($InsFichaIngresoHerramienta->FinEliminado <> 2) {

							if (!empty($InsFichaIngresoHerramienta->ProId)) {
								if (!empty($InsFichaIngresoHerramienta->UmeId)) {
									if (!empty($InsFichaIngresoHerramienta->FihCantidad)) {
										if (!empty($InsFichaIngresoHerramienta->FihCantidadReal)) {

											if ($InsFichaIngresoHerramienta->MtdRegistrarFichaIngresoHerramienta()) {
												$validar++;
											} else {
												$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
												$Resultado .= '#ERR_FIN_211';
											}
										} else {
											$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
											$Resultado .= '#ERR_FIN_217';
										}
									} else {
										$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
										$Resultado .= '#ERR_FIN_216';
									}
								} else {
									$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
									$Resultado .= '#ERR_FIN_214';
								}
							} else {
								$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
								$Resultado .= '#ERR_FIN_215';
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoHerramienta->FinEliminado == 2) {
							if ($InsFichaIngresoHerramienta->MtdEliminarFichaIngresoHerramienta($InsFichaIngresoHerramienta->FihId)) {
								$validar++;
							} else {
								$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
								$Resultado .= '#ERR_FIN_213';
							}
						} else {


							if (!empty($InsFichaIngresoHerramienta->ProId)) {
								if (!empty($InsFichaIngresoHerramienta->UmeId)) {
									if (!empty($InsFichaIngresoHerramienta->FihCantidad)) {
										if (!empty($InsFichaIngresoHerramienta->FihCantidadReal)) {

											if ($InsFichaIngresoHerramienta->MtdEditarFichaIngresoHerramienta()) {
												$validar++;
											} else {
												$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
												$Resultado .= '#ERR_FIN_212';
											}
										} else {
											$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
											$Resultado .= '#ERR_FIN_217';
										}
									} else {
										$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
										$Resultado .= '#ERR_FIN_216';
									}
								} else {
									$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
									$Resultado .= '#ERR_FIN_214';
								}
							} else {
								$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
								$Resultado .= '#ERR_FIN_215';
							}
						}
					}

					$item++;
				}

				if (count($this->FichaIngresoHerramienta) <> $validar) {
					$error = true;
				}
			}
		}



		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarFichaIngreso(2, "Se edito la Orden de Trabajo", $this);
			return true;
		}
	}


	public function MtdTrabajarFichaIngreso()
	{

		//deb("asdf");
		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblfinfichaingreso SET
		
			
			' . (empty($this->EinId) ? 'EinId = NULL, ' : 'EinId = "' . $this->EinId . '",') . '
			
			' . (empty($this->CliId) ? 'CliId = NULL, ' : 'CliId = "' . $this->CliId . '",') . '
			
			' . (empty($this->ObsId) ? 'ObsId = NULL, ' : 'ObsId = "' . $this->ObsId . '",') . '
			' . (empty($this->OvmId) ? 'OvmId = NULL, ' : 'OvmId = "' . $this->OvmId . '",') . '

			' . (empty($this->PmaId) ? 'PmaId = NULL, ' : 'PmaId = "' . $this->PmaId . '",') . '
			
			' . (empty($this->FinFechaEntrega) ? 'FinFechaEntrega = NULL, ' : 'FinFechaEntrega = "' . $this->FinFechaEntrega . '",') . '
			' . (empty($this->FinFechaCita) ? 'FinFechaCita = NULL, ' : 'FinFechaCita = "' . $this->FinFechaCita . '",') . '
			' . (empty($this->FinHoraEntrega) ? 'FinHoraEntrega = NULL, ' : 'FinHoraEntrega = "' . $this->FinHoraEntrega . '",') . '
						
			
			' . (empty($this->CamId) ? 'CamId = NULL, ' : 'CamId = "' . $this->CamId . '",') . '
			' . (empty($this->OvvId) ? 'OvvId = NULL, ' : 'OvvId = "' . $this->OvvId . '",') . '
			' . (empty($this->PerId) ? 'PerId = NULL, ' : 'PerId = "' . $this->PerId . '",') . '
			
			
			FinVehiculoKilometraje = ' . ($this->FinVehiculoKilometraje) . ',			
			FinMantenimientoKilometraje = ' . ($this->FinMantenimientoKilometraje) . ',			
			
			
			
			FinConductor = "' . ($this->FinConductor) . '",
			FinTelefono = "' . ($this->FinTelefono) . '",
			FinClienteEmail = "' . ($this->FinClienteEmail) . '",
			FinDireccion = "' . ($this->FinDireccion) . '",
			FinContacto = "' . ($this->FinContacto) . '",
			
			
			FinExteriorDelantero1 = ' . ($this->FinExteriorDelantero1) . ',
			FinExteriorDelantero2 = ' . ($this->FinExteriorDelantero2) . ',
			FinExteriorDelantero3 = ' . ($this->FinExteriorDelantero3) . ',
			FinExteriorDelantero4 = ' . ($this->FinExteriorDelantero4) . ',
			FinExteriorDelantero5 = ' . ($this->FinExteriorDelantero5) . ',
			FinExteriorDelantero6 = ' . ($this->FinExteriorDelantero6) . ',
			FinExteriorDelantero7 = ' . ($this->FinExteriorDelantero7) . ',
			
			FinExteriorPosterior1 = ' . ($this->FinExteriorPosterior1) . ',
			FinExteriorPosterior2 = ' . ($this->FinExteriorPosterior2) . ',
			FinExteriorPosterior3 = ' . ($this->FinExteriorPosterior3) . ',
			FinExteriorPosterior4 = ' . ($this->FinExteriorPosterior4) . ',
			FinExteriorPosterior5 = ' . ($this->FinExteriorPosterior5) . ',
			FinExteriorPosterior6 = ' . ($this->FinExteriorPosterior6) . ',
			
			FinExteriorDerecho1 = ' . ($this->FinExteriorDerecho1) . ',
			FinExteriorDerecho2 = ' . ($this->FinExteriorDerecho2) . ',
			FinExteriorDerecho3 = ' . ($this->FinExteriorDerecho3) . ',
			FinExteriorDerecho4 = ' . ($this->FinExteriorDerecho4) . ',
			FinExteriorDerecho5 = ' . ($this->FinExteriorDerecho5) . ',
			FinExteriorDerecho6 = ' . ($this->FinExteriorDerecho6) . ',
			FinExteriorDerecho7 = ' . ($this->FinExteriorDerecho7) . ',
			FinExteriorDerecho8 = ' . ($this->FinExteriorDerecho8) . ',
			
			FinExteriorIzquierdo1 = ' . ($this->FinExteriorIzquierdo1) . ',
			FinExteriorIzquierdo2 = ' . ($this->FinExteriorIzquierdo2) . ',
			FinExteriorIzquierdo3 = ' . ($this->FinExteriorIzquierdo3) . ',
			FinExteriorIzquierdo4 = ' . ($this->FinExteriorIzquierdo4) . ',
			FinExteriorIzquierdo5 = ' . ($this->FinExteriorIzquierdo5) . ',
			FinExteriorIzquierdo6 = ' . ($this->FinExteriorIzquierdo6) . ',
			FinExteriorIzquierdo7 = ' . ($this->FinExteriorIzquierdo7) . ',
			
			FinInterior1 = ' . ($this->FinInterior1) . ',
			FinInterior2 = ' . ($this->FinInterior2) . ',
			FinInterior3 = ' . ($this->FinInterior3) . ',
			FinInterior4 = ' . ($this->FinInterior4) . ',
			FinInterior5 = ' . ($this->FinInterior5) . ',
			FinInterior6 = ' . ($this->FinInterior6) . ',
			FinInterior7 = ' . ($this->FinInterior7) . ',
			FinInterior8 = ' . ($this->FinInterior8) . ',
			FinInterior9 = ' . ($this->FinInterior9) . ',
			FinInterior10 = ' . ($this->FinInterior10) . ',
			FinInterior11 = ' . ($this->FinInterior11) . ',
			FinInterior12 = ' . ($this->FinInterior12) . ',
			FinInterior13 = ' . ($this->FinInterior13) . ',
			FinInterior14 = ' . ($this->FinInterior14) . ',
			FinInterior15 = ' . ($this->FinInterior15) . ',
			FinInterior16 = ' . ($this->FinInterior16) . ',
			FinInterior17 = ' . ($this->FinInterior17) . ',
			FinInterior18 = ' . ($this->FinInterior18) . ',
			FinInterior19 = ' . ($this->FinInterior19) . ',
			FinInterior20 = ' . ($this->FinInterior20) . ',
			FinInterior21 = ' . ($this->FinInterior21) . ',
			FinInterior22 = ' . ($this->FinInterior22) . ',
			FinInterior23 = ' . ($this->FinInterior23) . ',
			FinInterior24 = ' . ($this->FinInterior24) . ',
			FinInterior25 = ' . ($this->FinInterior25) . ',
			FinInterior26 = ' . ($this->FinInterior26) . ',
			FinInterior27 = ' . ($this->FinInterior27) . ',
			FinObservacion = "' . ($this->FinObservacion) . '",
			FinNota = "' . ($this->FinNota) . '",
			FinReferencia = "' . ($this->FinReferencia) . '",
			
			FinCita = "' . ($this->FinCita) . '",
			FinObservacion = "' . ($this->FinObservacion) . '",
			FinIndicacionTecnico = "' . ($this->FinIndicacionTecnico) . '",
			FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
			
			WHERE FinId = "' . ($this->FinId) . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}



		if (!$error) {
			if (!empty($this->FichaIngresoModalidad)) {

				$validar = 0;

				$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);

				foreach ($this->FichaIngresoModalidad as $DatFichaIngresoModalidad) {

					$InsModalidadIngreso = new ClsModalidadIngreso();
					$InsModalidadIngreso->MinId = $DatFichaIngresoModalidad->MinId;
					$InsModalidadIngreso->MtdObtenerModalidadIngreso();

					$InsFichaIngresoModalidad->FimId = $DatFichaIngresoModalidad->FimId;
					$InsFichaIngresoModalidad->FinId = $this->FinId;
					$InsFichaIngresoModalidad->MinId = $DatFichaIngresoModalidad->MinId;
					$InsFichaIngresoModalidad->FimObsequio = $DatFichaIngresoModalidad->FimObsequio;
					$InsFichaIngresoModalidad->FimEstado = $DatFichaIngresoModalidad->FimEstado;

					$InsFichaIngresoModalidad->FichaIngresoProducto = $DatFichaIngresoModalidad->FichaIngresoProducto;
					$InsFichaIngresoModalidad->FichaIngresoTarea = $DatFichaIngresoModalidad->FichaIngresoTarea;
					$InsFichaIngresoModalidad->FichaIngresoSuministro = $DatFichaIngresoModalidad->FichaIngresoSuministro;
					$InsFichaIngresoModalidad->FichaIngresoMantenimiento = $DatFichaIngresoModalidad->FichaIngresoMantenimiento;

					$InsFichaIngresoModalidad->FimTiempoCreacion = $DatFichaIngresoModalidad->FimTiempoCreacion;
					$InsFichaIngresoModalidad->FimTiempoModificacion = $DatFichaIngresoModalidad->FimTiempoModificacion;
					$InsFichaIngresoModalidad->FimEliminado = $DatFichaIngresoModalidad->FimEliminado;

					$InsFichaIngresoModalidad->FichaAccion = $DatFichaIngresoModalidad->FichaAccion;

					if (empty($InsFichaIngresoModalidad->FimId)) {
						if ($InsFichaIngresoModalidad->FimEliminado <> 2) {
							if ($InsFichaIngresoModalidad->MtdRegistrarFichaIngresoModalidad()) {
								$validar++;
							} else {
								$Resultado .= '#Modalidad: ' . strtoupper($InsModalidadIngreso->MinNombre);
								$Resultado .= '#ERR_FIN_201';
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoModalidad->FimEliminado == 2) {
							if ($InsFichaIngresoModalidad->MtdEliminarFichaIngresoModalidad($InsFichaIngresoModalidad->FimId)) {
								$validar++;
							} else {
								$Resultado .= '#Modalidad: ' . strtoupper($InsModalidadIngreso->MinNombre);
								$Resultado .= '#ERR_FIN_203';
							}
						} else {
							if ($InsFichaIngresoModalidad->MtdEditarFichaIngresoModalidad()) {
								$validar++;
							} else {
								$Resultado .= '#Modalidad: ' . strtoupper($InsModalidadIngreso->MinNombre);
								$Resultado .= '#ERR_FIN_202';
							}
						}
					}
				}

				if (count($this->FichaIngresoModalidad) <> $validar) {
					$error = true;
				}
			}
		}

		/*
if(!$error){
				if (!empty($this->FichaIngresoModalidad)){		

					$validar = 0;	
						
					$InsFichaIngresoModalidad = new ClsFichaIngresoModalidad($this->InsMysql);		

					foreach ($this->FichaIngresoModalidad as $DatFichaIngresoModalidad){
						
						$InsModalidadIngreso = new ClsModalidadIngreso();
						$InsModalidadIngreso->MinId = $DatFichaIngresoModalidad->MinId;
						$InsModalidadIngreso->MtdObtenerModalidadIngreso();
						
						$InsFichaIngresoModalidad->FimId = $DatFichaIngresoModalidad->FimId;
						$InsFichaIngresoModalidad->FinId = $this->FinId;
						$InsFichaIngresoModalidad->MinId = $DatFichaIngresoModalidad->MinId;
						$InsFichaIngresoModalidad->FimObsequio = $DatFichaIngresoModalidad->FimObsequio;
						$InsFichaIngresoModalidad->FimEstado = $DatFichaIngresoModalidad->FimEstado;
						
						$InsFichaIngresoModalidad->FichaIngresoProducto = $DatFichaIngresoModalidad->FichaIngresoProducto;
						$InsFichaIngresoModalidad->FichaIngresoTarea = $DatFichaIngresoModalidad->FichaIngresoTarea;
						$InsFichaIngresoModalidad->FichaIngresoSuministro = $DatFichaIngresoModalidad->FichaIngresoSuministro;
						$InsFichaIngresoModalidad->FichaIngresoMantenimiento = $DatFichaIngresoModalidad->FichaIngresoMantenimiento;
						
						$InsFichaIngresoModalidad->FimTiempoCreacion = $DatFichaIngresoModalidad->FimTiempoCreacion;
						$InsFichaIngresoModalidad->FimTiempoModificacion = $DatFichaIngresoModalidad->FimTiempoModificacion;
						$InsFichaIngresoModalidad->FimEliminado = $DatFichaIngresoModalidad->FimEliminado;
						
						$InsFichaIngresoModalidad->FichaAccion = $DatFichaIngresoModalidad->FichaAccion;
						
						
						
						if(empty($InsFichaIngresoModalidad->FimId)){
							if($InsFichaIngresoModalidad->FimEliminado<>2){
								if($InsFichaIngresoModalidad->MtdRegistrarFichaIngresoModalidad()){
									$validar++;					
								}else{
									$Resultado.='#Modalidad: '.strtoupper($InsModalidadIngreso->MinNombre);		
									$Resultado.='#ERR_FIN_201';									
								}
							}else{
								$validar++;	
							}
							
						}else{						
							if($InsFichaIngresoModalidad->FimEliminado==2){
								if($InsFichaIngresoModalidad->MtdEliminarFichaIngresoModalidad($InsFichaIngresoModalidad->FimId)){
									$validar++;					
								}else{
									$Resultado.='#Modalidad: '.strtoupper($InsModalidadIngreso->MinNombre);
									$Resultado.='#ERR_FIN_203';									
								}
							}else{
								if($InsFichaIngresoModalidad->MtdEditarFichaIngresoModalidad()){
									$validar++;					
								}else{
									$Resultado.='#Modalidad: '.strtoupper($InsModalidadIngreso->MinNombre);
									$Resultado.='#ERR_FIN_202';									
								}
							}
						}	
						
					}					
					
					if(count($this->FichaIngresoModalidad) <> $validar ){
						$error = true;
					}	
					
				}
			}*/



		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarFichaIngreso(2, "Se corrigio la Orden de Trabajo", $this);
			return true;
		}
	}





	public function MtdEditarFichaIngresoGasto($oTransaccion = true)
	{

		global $Resultado;
		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}

		if (!empty($this->FichaIngresoGasto)) {


			$validar = 0;
			$item = 1;
			$InsFichaIngresoGasto = new ClsFichaIngresoGasto($this->InsMysql);

			foreach ($this->FichaIngresoGasto as $DatFichaIngresoGasto) {

				$InsFichaIngresoGasto->FigId = $DatFichaIngresoGasto->FigId;
				$InsFichaIngresoGasto->FinId = $this->FinId;
				$InsFichaIngresoGasto->GasId = $DatFichaIngresoGasto->GasId;
				$InsFichaIngresoGasto->FigEstado = $DatFichaIngresoGasto->FigEstado;
				$InsFichaIngresoGasto->FigTiempoCreacion = $DatFichaIngresoGasto->FigTiempoCreacion;
				$InsFichaIngresoGasto->FigTiempoModificacion = $DatFichaIngresoGasto->FigTiempoModificacion;
				$InsFichaIngresoGasto->FigEliminado = $DatFichaIngresoGasto->FigEliminado;

				if (empty($InsFichaIngresoGasto->FigId)) {
					if ($InsFichaIngresoGasto->FigEliminado <> 2) {

						if (!empty($InsFichaIngresoGasto->GasId)) {

							if ($InsFichaIngresoGasto->MtdRegistrarFichaIngresoGasto()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_221';
							}
						} else {
							$Resultado .= '#ERR_FIN_225';
						}
					} else {
						$validar++;
					}
				} else {
					if ($InsFichaIngresoGasto->FigEliminado == 2) {
						if ($InsFichaIngresoGasto->MtdEliminarFichaIngresoGasto($InsFichaIngresoGasto->FigId)) {
							$validar++;
						} else {
							$Resultado .= '#ERR_FIN_223';
						}
					} else {

						if (!empty($InsFichaIngresoGasto->FigId)) {
							if ($InsFichaIngresoGasto->MtdEditarFichaIngresoGasto()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_222';
							}
						} else {
							$Resultado .= '#ERR_FIN_225';
						}
					}
				}

				$item++;
			}

			if (count($this->FichaIngresoGasto) <> $validar) {
				$error = true;
			}
		}


		if ($error) {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}

			return false;
		} else {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}
			//$this->MtdAuditarFichaIngreso(2,"Se edito la Orden de Trabajo",$this);		
			return true;
		}
	}




	public function MtdEditarFichaIngresoAlmacenMovimientoEntrada($oTransaccion = true)
	{

		global $Resultado;
		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}

		if (!empty($this->FichaIngresoAlmacenMovimientoEntrada)) {


			$validar = 0;
			$item = 1;
			$InsFichaIngresoAlmacenMovimientoEntrada = new ClsFichaIngresoAlmacenMovimientoEntrada();

			foreach ($this->FichaIngresoAlmacenMovimientoEntrada as $DatFichaIngresoAlmacenMovimientoEntrada) {

				$InsFichaIngresoAlmacenMovimientoEntrada->FilId = $DatFichaIngresoAlmacenMovimientoEntrada->FilId;
				$InsFichaIngresoAlmacenMovimientoEntrada->FinId = $this->FinId;
				$InsFichaIngresoAlmacenMovimientoEntrada->AmoId = $DatFichaIngresoAlmacenMovimientoEntrada->AmoId;
				$InsFichaIngresoAlmacenMovimientoEntrada->FilEstado = $DatFichaIngresoAlmacenMovimientoEntrada->FilEstado;
				$InsFichaIngresoAlmacenMovimientoEntrada->FilTiempoCreacion = $DatFichaIngresoAlmacenMovimientoEntrada->FilTiempoCreacion;
				$InsFichaIngresoAlmacenMovimientoEntrada->FilTiempoModificacion = $DatFichaIngresoAlmacenMovimientoEntrada->FilTiempoModificacion;
				$InsFichaIngresoAlmacenMovimientoEntrada->FilEliminado = $DatFichaIngresoAlmacenMovimientoEntrada->FilEliminado;

				if (empty($InsFichaIngresoAlmacenMovimientoEntrada->FilId)) {
					if ($InsFichaIngresoAlmacenMovimientoEntrada->FilEliminado <> 2) {

						if (!empty($InsFichaIngresoAlmacenMovimientoEntrada->AmoId)) {

							if ($InsFichaIngresoAlmacenMovimientoEntrada->MtdRegistrarFichaIngresoAlmacenMovimientoEntrada()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_231';
							}
						} else {
							$Resultado .= '#ERR_FIN_235';
						}
					} else {
						$validar++;
					}
				} else {
					if ($InsFichaIngresoAlmacenMovimientoEntrada->FilEliminado == 2) {
						if ($InsFichaIngresoAlmacenMovimientoEntrada->MtdEliminarFichaIngresoAlmacenMovimientoEntrada($InsFichaIngresoAlmacenMovimientoEntrada->FilId)) {
							$validar++;
						} else {
							$Resultado .= '#ERR_FIN_233';
						}
					} else {

						if (!empty($InsFichaIngresoAlmacenMovimientoEntrada->FilId)) {
							if ($InsFichaIngresoAlmacenMovimientoEntrada->MtdEditarFichaIngresoAlmacenMovimientoEntrada()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_232';
							}
						} else {
							$Resultado .= '#ERR_FIN_235';
						}
					}
				}

				$item++;
			}

			if (count($this->FichaIngresoAlmacenMovimientoEntrada) <> $validar) {
				$error = true;
			}
		}


		if ($error) {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}

			return false;
		} else {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}
			//$this->MtdAuditarFichaIngreso(2,"Se edito la Orden de Trabajo",$this);		
			return true;
		}
	}




	public function MtdEditarFichaIngresoManoObra($oTransaccion = true)
	{

		global $Resultado;
		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}

		if (!empty($this->FichaIngresoManoObra)) {


			$validar = 0;
			$item = 1;
			$InsFichaIngresoManoObra = new ClsFichaIngresoManoObra();

			foreach ($this->FichaIngresoManoObra as $DatFichaIngresoManoObra) {

				$InsFichaIngresoManoObra->FmoId = $DatFichaIngresoManoObra->FigId;
				$InsFichaIngresoManoObra->FinId = $this->FinId;
				$InsFichaIngresoManoObra->FmoDescripcion = $DatFichaIngresoManoObra->FmoDescripcion;
				$InsFichaIngresoManoObra->FmoImporte = $DatFichaIngresoManoObra->FmoImporte;

				$InsFichaIngresoManoObra->FmoEstado = $DatFichaIngresoManoObra->FmoEstado;
				$InsFichaIngresoManoObra->FmoTiempoCreacion = $DatFichaIngresoManoObra->FmoTiempoCreacion;
				$InsFichaIngresoManoObra->FmomTiempoModificacion = $DatFichaIngresoGasto->FmomTiempoModificacion;
				$InsFichaIngresoManoObra->FmoEliminado = $DatFichaIngresoManoObra->FmoEliminado;

				if (empty($InsFichaIngresoManoObra->FmoId)) {
					if ($InsFichaIngresoManoObra->FmoEliminado <> 2) {

						if ($InsFichaIngresoManoObra->MtdRegistrarFichaIngresoManoObra()) {
							$validar++;
						} else {
							$Resultado .= '#ERR_FIN_231';
						}
					} else {
						$validar++;
					}
				} else {
					if ($InsFichaIngresoManoObra->FmoEliminado == 2) {
						if ($InsFichaIngresoManoObra->MtdEliminarFichaIngresoManoObra($InsFichaIngresoManoObra->FmoId)) {
							$validar++;
						} else {
							$Resultado .= '#ERR_FIN_233';
						}
					} else {

						if (!empty($InsFichaIngresoManoObra->FmoId)) {
							if ($InsFichaIngresoManoObra->MtdEditarFichaIngresoManoObra()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_232';
							}
						} else {
							$Resultado .= '#ERR_FIN_235';
						}
					}
				}

				$item++;
			}

			if (count($this->FichaIngresoManoObra) <> $validar) {
				$error = true;
			}
		}


		if ($error) {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}

			return false;
		} else {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}
			//$this->MtdAuditarFichaIngreso(2,"Se edito la Orden de Trabajo",$this);		
			return true;
		}
	}



	public function MtdEditarFichaIngresoHerramienta($oTransaccion = true)
	{

		global $Resultado;
		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}


		if (!empty($this->FichaIngresoHerramienta)) {


			$validar = 0;
			$item = 1;
			$InsFichaIngresoHerramienta = new ClsFichaIngresoHerramienta($this->InsMysql);

			foreach ($this->FichaIngresoHerramienta as $DatFichaIngresoHerramienta) {

				$InsProducto = new ClsProducto();
				$InsProducto->ProId = $DatFichaIngresoHerramienta->ProId;
				$InsProducto->MtdObtenerProducto(false);

				$InsFichaIngresoHerramienta->FihId = $DatFichaIngresoHerramienta->FihId;
				$InsFichaIngresoHerramienta->FinId = $this->FinId;
				$InsFichaIngresoHerramienta->ProId = $DatFichaIngresoHerramienta->ProId;
				$InsFichaIngresoHerramienta->UmeId = $DatFichaIngresoHerramienta->UmeId;
				$InsFichaIngresoHerramienta->FihCantidad = $DatFichaIngresoHerramienta->FihCantidad;
				$InsFichaIngresoHerramienta->FihCantidadReal = $DatFichaIngresoHerramienta->FihCantidadReal;
				$InsFichaIngresoHerramienta->FihEstado = $DatFichaIngresoHerramienta->FihEstado;
				$InsFichaIngresoHerramienta->FihTiempoCreacion = $DatFichaIngresoHerramienta->FihTiempoCreacion;
				$InsFichaIngresoHerramienta->FihTiempoModificacion = $DatFichaIngresoHerramienta->FihTiempoModificacion;
				$InsFichaIngresoHerramienta->FimEliminado = $DatFichaIngresoHerramienta->FimEliminado;

				if (empty($InsFichaIngresoHerramienta->FihId)) {
					if ($InsFichaIngresoHerramienta->FinEliminado <> 2) {

						if (!empty($InsFichaIngresoHerramienta->ProId)) {
							if (!empty($InsFichaIngresoHerramienta->UmeId)) {
								if (!empty($InsFichaIngresoHerramienta->FihCantidad)) {
									if (!empty($InsFichaIngresoHerramienta->FihCantidadReal)) {

										if ($InsFichaIngresoHerramienta->MtdRegistrarFichaIngresoHerramienta()) {
											$validar++;
										} else {
											$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
											$Resultado .= '#ERR_FIN_211';
										}
									} else {
										$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
										$Resultado .= '#ERR_FIN_217';
									}
								} else {
									$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
									$Resultado .= '#ERR_FIN_216';
								}
							} else {
								$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
								$Resultado .= '#ERR_FIN_214';
							}
						} else {
							$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
							$Resultado .= '#ERR_FIN_215';
						}
					} else {
						$validar++;
					}
				} else {
					if ($InsFichaIngresoHerramienta->FinEliminado == 2) {
						if ($InsFichaIngresoHerramienta->MtdEliminarFichaIngresoHerramienta($InsFichaIngresoHerramienta->FihId)) {
							$validar++;
						} else {
							$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
							$Resultado .= '#ERR_FIN_213';
						}
					} else {


						if (!empty($InsFichaIngresoHerramienta->ProId)) {
							if (!empty($InsFichaIngresoHerramienta->UmeId)) {
								if (!empty($InsFichaIngresoHerramienta->FihCantidad)) {
									if (!empty($InsFichaIngresoHerramienta->FihCantidadReal)) {

										if ($InsFichaIngresoHerramienta->MtdEditarFichaIngresoHerramienta()) {
											$validar++;
										} else {
											$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
											$Resultado .= '#ERR_FIN_212';
										}
									} else {
										$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
										$Resultado .= '#ERR_FIN_217';
									}
								} else {
									$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
									$Resultado .= '#ERR_FIN_216';
								}
							} else {
								$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
								$Resultado .= '#ERR_FIN_214';
							}
						} else {
							$Resultado .= '#Herramienta: ' . ($InsProducto->ProNombre) . ' (' . $item . ')';
							$Resultado .= '#ERR_FIN_215';
						}
					}
				}

				$item++;
			}

			if (count($this->FichaIngresoHerramienta) <> $validar) {
				$error = true;
			}
		}


		if ($error) {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}

			return false;
		} else {
			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}
			//$this->MtdAuditarFichaIngreso(2,"Se edito la Orden de Trabajo",$this);		
			return true;
		}
	}

	public function MtdEditarFichaIngresoPreEntregaDetalle($oTransaccion = true)
	{

		global $Resultado;
		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}


		if (!$error) {

			if (!empty($this->PreEntregaDetalle)) {

				$validar = 0;

				$InsPreEntregaDetalle = new ClsPreEntregaDetalle($this->InsMysql);

				foreach ($this->PreEntregaDetalle as $DatPreEntregaDetalle) {

					$InsPreEntregaTarea = new ClsPreEntregaTarea();
					$InsPreEntregaTarea->PetId = $DatPreEntregaDetalle->PetId;
					$InsPreEntregaTarea->MtdObtenerPreEntregaTarea();

					$InsPreEntregaDetalle->RedId = $DatPreEntregaDetalle->RedId;
					$InsPreEntregaDetalle->FinId = $this->FinId;
					$InsPreEntregaDetalle->PetId = $DatPreEntregaDetalle->PetId;
					$InsPreEntregaDetalle->RedAccion = $DatPreEntregaDetalle->RedAccion;

					$InsPreEntregaDetalle->RedTiempoCreacion = $DatPreEntregaDetalle->RedTiempoCreacion;
					$InsPreEntregaDetalle->RedTiempoModificacion = $DatPreEntregaDetalle->RedTiempoModificacion;
					$InsPreEntregaDetalle->RedEliminado = $DatPreEntregaDetalle->RedEliminado;

					$InsPreEntregaDetalle->FichaAccion = $DatPreEntregaDetalle->FichaAccion;

					if (empty($InsPreEntregaDetalle->RedId)) {
						if ($InsPreEntregaDetalle->RedEliminado <> 2) {
							if ($InsPreEntregaDetalle->MtdRegistrarPreEntregaDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#Tarea: ' . strtoupper($InsModalidadIngreso->PetNombre);
								$Resultado .= '#ERR_FIN_301';
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsPreEntregaDetalle->RedEliminado == 2) {
							if ($InsPreEntregaDetalle->MtdEliminarPreEntregaDetalle($InsPreEntregaDetalle->RedId)) {
								$validar++;
							} else {
								$Resultado .= '#Tarea: ' . strtoupper($InsModalidadIngreso->PetNombre);
								$Resultado .= '#ERR_FIN_303';
							}
						} else {
							if ($InsPreEntregaDetalle->MtdEditarPreEntregaDetalle()) {
								$validar++;
							} else {
								$Resultado .= '#Tarea: ' . strtoupper($InsModalidadIngreso->PetNombre);
								$Resultado .= '#ERR_FIN_302';
							}
						}
					}
				}

				if (count($this->PreEntregaDetalle) <> $validar) {
					$error = true;
				}
			}
		}




		if ($error) {

			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}
			return false;
		} else {

			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}

			//$this->MtdAuditarFichaIngreso(2,"Se edito la Orden de Trabajo",$this);		
			return true;
		}
	}



	private function MtdAuditarFichaIngreso($oAccion, $oDescripcion, $oDatos, $oCodigo = NULL, $oUsuario = NULL, $oPersonal = NULL)
	{

		$InsAuditoria = new ClsAuditoria($this->InsMysql);
		$InsAuditoria->AudCodigo = (!empty($this->FinId) ? $this->FinId : $oCodigo);

		$InsAuditoria->UsuId = $this->UsuId;
		$InsAuditoria->SucId = $this->SucId;

		$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;

		$InsAuditoria->AudAccion = $oAccion;
		$InsAuditoria->AudDescripcion = $oDescripcion;
		$InsAuditoria->AudDatos = $oDatos;
		$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");

		if ($InsAuditoria->MtdAuditoriaRegistrar()) {
			return true;
		} else {
			return false;
		}
	}




	public function MtdEditarFichaIngresoDato($oCampo, $oDato, $oId)
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
		' . (empty($oDato) ? $oCampo . ' = NULL, ' : $oCampo . ' = "' . $oDato . '",') . '
		FinTiempoModificacion = NOW()
		WHERE FinId = "' . ($oId) . '";';

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




	public function MtdEditarFichaIngresoObservacionCallcenter()
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
		FinObservacionCallcenter = "' . ($this->FinObservacionCallcenter) . '",
		FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
		WHERE FinId = "' . ($this->FinId) . '";';

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


	public function MtdEditarFichaIngresoObservacionSalida()
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
			FinSalidaObservacion = "' . ($this->FinSalidaObservacion) . '",
			FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
			WHERE FinId = "' . ($this->FinId) . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			//$this->MtdAuditarFichaIngreso(2,"Se edito la Observacion de Salida de la Orden de Trabajo",$this->FinId);		
			return true;
		}
	}

	public function MtdEditarFichaIngresoObservacionTerminado()
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
			FinTerminadoObservacion = "' . ($this->FinTerminadoObservacion) . '",
			FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
			WHERE FinId = "' . ($this->FinId) . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			//$this->MtdAuditarFichaIngreso(2,"Se edito la Observacion Final de la Orden de Trabajo",$this->FinId);		
			return true;
		}
	}


	public function MtdEditarFichaIngresoMantenimientoKilometraje()
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
			FinMantenimientoKilometraje = "' . ($this->FinMantenimientoKilometraje) . '",
			FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
			WHERE FinId = "' . ($this->FinId) . '";';

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			//$this->MtdAuditarFichaIngreso(2,"Se edito el Kilometraje de Plan de Mantenimiento de la Orden de Trabajo",NULL);		
			return true;
		}
	}











	public function MtdEditarFichaIngresoTallerRevisando()
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
		' . (empty($this->FinTiempoTallerRevisando) ? 'FinTiempoTallerRevisando = NULL, ' : 'FinTiempoTallerRevisando = "' . $this->FinTiempoTallerRevisando . '",') . '
		FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
		WHERE FinId = "' . ($this->FinId) . '";';

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


	public function MtdEditarFichaIngresoTallerConcluido()
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
		' . (empty($this->FinTiempoTallerConcluido) ? 'FinTiempoTallerConcluido = NULL, ' : 'FinTiempoTallerConcluido = "' . $this->FinTiempoTallerConcluido . '",') . '
		
		FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
		WHERE FinId = "' . ($this->FinId) . '";';

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

	public function MtdEditarFichaIngresoTrabajoTerminado()
	{

		global $Resultado;
		$error = false;

		$sql = 'UPDATE tblfinfichaingreso SET
		' . (empty($this->FinTiempoTrabajoTerminado) ? 'FinTiempoTrabajoTerminado = NULL, ' : 'FinTiempoTrabajoTerminado = "' . $this->FinTiempoTrabajoTerminado . '",') . '
		FinTiempoModificacion = "' . ($this->FinTiempoModificacion) . '"
		WHERE FinId = "' . ($this->FinId) . '";';

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



	public function MtdSeguimientoClienteFichaIngreso($oTransaccion = true)
	{

		global $Resultado;
		$error = false;


		if (!$error) {

			if (!empty($this->FichaIngresoLlamada)) {

				$validar = 0;

				$InsFichaIngresoLlamada = new ClsFichaIngresoLlamada($this->InsMysql);

				foreach ($this->FichaIngresoLlamada as $DatFichaIngresoLlamada) {

					$InsFichaIngresoLlamada->FllId = $DatFichaIngresoLlamada->FllId;
					$InsFichaIngresoLlamada->FinId = $this->FinId;

					$InsFichaIngresoLlamada->FllFecha = $DatFichaIngresoLlamada->FllFecha;
					$InsFichaIngresoLlamada->FllObservacion = $DatFichaIngresoLlamada->FllObservacion;
					$InsFichaIngresoLlamada->FllEstado = $DatFichaIngresoLlamada->FllEstado;
					$InsFichaIngresoLlamada->FllTiempoCreacion = $DatFichaIngresoLlamada->FllTiempoCreacion;
					$InsFichaIngresoLlamada->FllTiempoModificacion = $DatFichaIngresoLlamada->FllTiempoModificacion;
					$InsFichaIngresoLlamada->FllEliminado = $DatFichaIngresoLlamada->FllEliminado;

					if (empty($InsFichaIngresoLlamada->FllId)) {
						if ($InsFichaIngresoLlamada->FllEliminado <> 2) {
							if ($InsFichaIngresoLlamada->MtdRegistrarFichaIngresoLlamada()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_401';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoLlamada->FllEliminado == 2) {
							if ($InsFichaIngresoLlamada->MtdEliminarFichaIngresoLlamada($InsFichaIngresoLlamada->FllId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_403';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsFichaIngresoLlamada->MtdEditarFichaIngresoLlamada()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_402';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}

				if (count($this->FichaIngresoLlamada) <> $validar) {
					$error = true;
				}
			}
		}


		if ($error) {

			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionDeshacer();
			}

			return false;
		} else {

			if ($oTransaccion) {
				$this->InsMysql->MtdTransaccionHacer();
			}

			$this->MtdAuditarFichaIngreso(2, "Se edito el seguimiento de la Orden de Trabajo", $this);
			return true;
		}
	}

	public function MtdNotificarFichaIngresoMensaje($oFichaIngreso, $oDestinatario, $oTitulo, $oMensaje)
	{

		global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;

		$this->FinId = $oFichaIngreso;
		$this->MtdObtenerFichaIngreso(false);

		$mensaje .= "NOTIFICACION DE Orden de Trabajo:";
		$mensaje .= "<br>";
		$mensaje .= "<br>";

		$mensaje .= "Datos de la Orden de TRbajo.";
		$mensaje .= "<br>";

		$mensaje .= "Codigo Interno: <b>" . $this->FinId . "</b>";
		$mensaje .= "<br>";
		$mensaje .= "Cliente: <b>" . $this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno . "</b>";
		$mensaje .= "<br>";
		$mensaje .= "Fecha Registro: <b>" . $this->FinFecha . "</b>";
		$mensaje .= "<br>";

		$mensaje .= "<hr>";
		$mensaje .= "<br>";

		$mensaje .= "<b>" . $oMensaje . "</b>";	//"Su pedido ha sido procesado correctamente."

		$mensaje .= "<br>";

		$mensaje .= "<br>";
		$mensaje .= "<br>";
		$mensaje .= "Mensaje autogenerado por sistema " . $SistemaNombreAbreviado . " a las " . date('d/m/Y H:i:s');

		//echo $mensaje;

		$InsCorreo = new ClsCorreo();
		$InsCorreo->MtdEnviarCorreo($oDestinatario, $SistemaCorreoUsuario, $SistemaCorreoRemitente, "NOTIFICACION " . $oTitulo . ": O.T.:" . $this->FinId . " - " . $this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno, $mensaje);


		//$InsCorreo = new ClsCorreo();	
		//$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"VERIFICAR STOCK: ORD. VEN. Nro.: ".$this->VdiId.(!empty($this->VdiOrdenCompraNumero)?" - O.C. REF: ".$this->VdiOrdenCompraNumero." ":"")." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);


	}
}
