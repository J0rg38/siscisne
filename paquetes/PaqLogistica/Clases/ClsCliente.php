<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCliente
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCliente
{

	public $CliId;
	public $LtiId;
	public $TdoId;
	public $CliTipoDocumentoOtro;

	public $CliNombreComercial;
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliNumeroDocumento;

	public $CliActividadEconomica;
	public $CliDireccion;

	public $CliDistrito;
	public $CliProvincia;
	public $CliDepartamento;
	public $CliPais;

	public $CliTelefono;
	public $CliCelular;
	public $CliEmail;
	public $CliFechaNacimiento;

	public $CliContactoNombre1;
	public $CliContactoCelular1;
	public $CliContactoEmail1;

	public $CliContactoNombre2;
	public $CliContactoCelular2;
	public $CliContactoEmail2;

	public $CliContactoNombre3;
	public $CliContactoCelular3;
	public $CliContactoEmail3;

	public $CliRepresentanteNombre;
	public $CliRepresentanteNumeroDocumento;
	public $CliRepresentanteNacionalidad;
	public $CliRepresentanteActividadEconomica;


	public $CliLineaCredito;

	public $CliCSIIncluir;
	public $CliCSIExcluirMotivo;
	public $CliCSIExcluirFecha;

	public $CliCSIVentaIncluir;
	public $CliCSIVentaExcluirMotivo;
	public $CliCSIVentaExcluirFecha;

	public $CliArchivo;
	public $CliClasificacion;
	public $CliEstado;
	public $CliTiempoCreacion;
	public $CliTiempoModificacion;
	public $CliEliminado;

	public $TdoNombre;

	public $LtiNombre;
	public $LtiAbreviatura;
	public $LtiUtilidad;
	public $LtiPorcentajeMargenUtilidad;
	public $LtiPorcentajeDescuento;

	public $EinId;

	public $InsMysql;

	// Propiedades adicionales que se usan en el código
	public $ClienteGenerarCodigo;
	public $TrfId;
	public $PerId;
	public $CliNombreCompleto;
	public $CliAbreviatura;
	public $CliEstadoCivil;
	public $CliSexo;
	public $MonId;
	public $CliTipoCambioFecha;
	public $CliTipoCambio;
	public $CliUso;
	public $CliBloquear;
	public $CliObservacion;
	public $CliEmailFacturacion;
	public $CliClaveElectronica;
	public $PerIdAnterior;
	public $LtiPorcentajeOtroCosto;
	public $LtiPorcentajeManoObra;
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;

	public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}
		$this->ClienteGenerarCodigo = true;
	}

	public function __destruct() {}

	public function MtdGenerarClienteId()
	{

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(CliId,5),unsigned)) AS "MAXIMO"
		FROM tblclicliente';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->CliId = "CLI-10000";
		} else {
			$fila['MAXIMO']++;
			$this->CliId = "CLI-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerCliente($oCompleto = false)
	{

		$sql = 'SELECT 
        cli.CliId,
		cli.LtiId,
		cli.TdoId,
cli.TrfId,
cli.PerId,

		cli.CliTipoDocumentoOtro,
		cli.CliNombreComercial,
		
		cli.CliAbreviatura,
		CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
	 	cli.CliActividadEconomica,
		cli.CliDireccion,
		
		cli.CliDistrito,
		cli.CliProvincia,
		cli.CliDepartamento,
		
		cli.CliPais,
		
		cli.CliTelefono,
		cli.CliCelular,
		cli.CliEmail,
		
		cli.CliEstadoCivil,
		cli.CliSexo,
		DATE_FORMAT(cli.CliFechaNacimiento, "%d/%m/%Y") AS "NCliFechaNacimiento",
		cli.CliContactoNombre1,
		cli.CliContactoCelular1,
		cli.CliContactoEmail1,
		cli.CliContactoNombre2,
		cli.CliContactoCelular2,
		cli.CliContactoEmail2,
		cli.CliContactoNombre3,
		cli.CliContactoCelular3,
		cli.CliContactoEmail3,
		
		cli.CliRepresentanteNombre,
		cli.CliRepresentanteNumeroDocumento,
		cli.CliRepresentanteNacionalidad,
		cli.CliRepresentanteActividadEconomica,
	
		cli.MonId,
		DATE_FORMAT(cli.CliTipoCambioFecha, "%d/%m/%Y") AS "NCliTipoCambioFecha",
		cli.CliTipoCambio,
		cli.CliLineaCredito,
		
		cli.CliCSIIncluir,
		cli.CliCSIExcluirMotivo,
		DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",

		cli.CliCSIVentaIncluir,
		cli.CliCSIVentaExcluirMotivo,
		DATE_FORMAT(cli.CliCSIVentaExcluirFecha, "%d/%m/%Y") AS "NCliCSIVentaExcluirFecha",

		cli.CliArchivo,
		cli.CliUso,
		cli.CliClasificacion,
		
		cli.CliBloquear,
		cli.CliObservacion,	
		cli.CliEstado,	
		cli.CliEmailFacturacion,
		cli.CliClaveElectronica,
		DATE_FORMAT(cli.CliTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCliTiempoCreacion",
        DATE_FORMAT(cli.CliTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCliTiempoModificacion",
		tdo.TdoNombre,
		
		lti.LtiNombre,
		lti.LtiAbreviatura,
		
		lti.LtiUtilidad,
		lti.LtiPorcentajeMargenUtilidad,
		lti.LtiPorcentajeDescuento,
		lti.LtiPorcentajeOtroCosto,
		lti.LtiPorcentajeManoObra,
		
		(
			SELECT ein.EinId 
			FROM tbleinvehiculoingreso ein 
			WHERE ein.CliId = cli.CliId 
			ORDER BY ein.EinTiempoCreacion DESC LIMIT 1
		) AS EinId,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno
		
        FROM tblclicliente cli
			LEFT JOIN tbltdotipodocumento tdo
			ON cli.TdoId = tdo.TdoId
				LEFT JOIN tbllticlientetipo lti
				ON cli.LtiId = lti.LtiId
					LEFT JOIN tblperpersonal per
					ON cli.PerId = per.PerId
					
        WHERE CliId = "' . $this->CliId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$this->CliId = $fila['CliId'];
				$this->LtiId = $fila['LtiId'];
				$this->TdoId = $fila['TdoId'];
				$this->TrfId = $fila['TrfId'];
				$this->PerId = $fila['PerId'];

				$this->CliTipoDocumentoOtro = $fila['CliTipoDocumentoOtro'];

				$this->CliNombreCompleto = $fila['CliNombreCompleto'];


				$this->CliNombreComercial = $fila['CliNombreComercial'];
				$this->CliAbreviatura = $fila['CliAbreviatura'];
				$this->CliNombre = $fila['CliNombre'];
				$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];

				$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
				$this->CliActividadEconomica = $fila['CliActividadEconomica'];

				$this->CliDireccion = $fila['CliDireccion'];

				$this->CliDistrito = $fila['CliDistrito'];
				$this->CliProvincia = $fila['CliProvincia'];
				$this->CliDepartamento = $fila['CliDepartamento'];

				$this->CliPais = $fila['CliPais'];

				$this->CliTelefono = $fila['CliTelefono'];
				$this->CliCelular = $fila['CliCelular'];
				$this->CliEmail = $fila['CliEmail'];

				$this->CliEstadoCivil = $fila['CliEstadoCivil'];
				$this->CliSexo = $fila['CliSexo'];
				$this->CliFechaNacimiento = $fila['NCliFechaNacimiento'];

				$this->CliContactoNombre1 = $fila['CliContactoNombre1'];
				$this->CliContactoCelular1 = $fila['CliContactoCelular1'];
				$this->CliContactoEmail1 = $fila['CliContactoEmail1'];

				$this->CliContactoNombre2 = $fila['CliContactoNombre2'];
				$this->CliContactoCelular2 = $fila['CliContactoCelular2'];
				$this->CliContactoEmail2 = $fila['CliContactoEmail2'];

				$this->CliContactoNombre3 = $fila['CliContactoNombre3'];
				$this->CliContactoCelular3 = $fila['CliContactoCelular3'];
				$this->CliContactoEmail3 = $fila['CliContactoEmail3'];

				$this->CliRepresentanteNombre = $fila['CliRepresentanteNombre'];
				$this->CliRepresentanteNumeroDocumento = $fila['CliRepresentanteNumeroDocumento'];
				$this->CliRepresentanteNacionalidad = $fila['CliRepresentanteNacionalidad'];
				$this->CliRepresentanteActividadEconomica = $fila['CliRepresentanteActividadEconomica'];


				$this->MonId = $fila['MonId'];
				$this->CliTipoCambioFecha = $fila['NCliTipoCambioFecha'];
				$this->CliTipoCambio = $fila['CliTipoCambio'];
				$this->CliLineaCredito = $fila['CliLineaCredito'];

				$this->CliCSIIncluir = $fila['CliCSIIncluir'];
				$this->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'];
				$this->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'];

				$this->CliCSIVentaIncluir = $fila['CliCSIVentaIncluir'];
				$this->CliCSIVentaExcluirMotivo = $fila['CliCSIVentaExcluirMotivo'];
				$this->CliCSIVentaExcluirFecha = $fila['NCliCSIVentaExcluirFecha'];

				$this->CliArchivo = $fila['CliArchivo'];

				$this->CliUso = $fila['CliUso'];


				$this->CliBloquear = $fila['CliBloquear'];
				$this->CliObservacion = $fila['CliObservacion'];
				$this->CliEmailFacturacion = $fila['CliEmailFacturacion'];
				$this->CliClaveElectronica = $fila['CliClaveElectronica'];
				$this->CliEstado = $fila['CliEstado'];
				$this->CliTiempoCreacion = $fila['NCliTiempoCreacion'];
				$this->CliTiempoModificacion = $fila['NCliTiempoModificacion'];

				$this->TdoNombre = $fila['TdoNombre'];

				$this->LtiNombre = $fila['LtiNombre'];
				$this->LtiAbreviatura = $fila['LtiAbreviatura'];
				$this->LtiUtilidad = $fila['LtiUtilidad'];
				$this->LtiPorcentajeMargenUtilidad = $fila['LtiPorcentajeMargenUtilidad'];
				$this->LtiPorcentajeDescuento = $fila['LtiPorcentajeDescuento'];
				$this->LtiPorcentajeOtroCosto = $fila['LtiPorcentajeOtroCosto'];
				$this->LtiPorcentajeManoObra = $fila['LtiPorcentajeManoObra'];

				$this->PerNombre = $fila['PerNombre'];
				$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
				$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];

				$this->EinId = $fila['EinId'];

				if ($oCompleto) {
					//MtdObtenerVehiculoIngresoClientes($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VicId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngreso=NULL,$oCliente=NULL)
					$InsVehiculoIngresoCliente = new  ClsVehiculoIngresoCliente();
					$ResVehiculoIngresoCliente = $InsVehiculoIngresoCliente->MtdObtenerVehiculoIngresoClientes(NULL, NULL, 'CliNombre', 'ASC', NULL, NULL, $this->CliId);
					$this->ClienteVehiculoIngreso = $ResVehiculoIngresoCliente['Datos'];
				}
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdVerificarClienteExiste($oCampo, $oDato)
	{

		$ClienteId = "";

		$ResCliente = $this->MtdObtenerClientes($oCampo, "esigual", $oDato, 'CliId', 'ASC', 1, '1', NULL, NULL, NULL, NULL);
		$ArrClientes = $ResCliente['Datos'];

		if (!empty($ArrClientes)) {
			foreach ($ArrClientes as $DatCliente) {
				$ClienteId = $DatCliente->CliId;
			}
		}

		return $ClienteId;
	}

	public function MtdObtenerClientes($oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'CliId', $oSentido = 'Desc', $oEliminado = 1, $oPaginacion = '0,10', $oEstado = NULL, $oUso = NULL, $oClienteTipo = NULL, $oClasificacion = NULL, $oTipoReferido = NULL)
	{

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$tipo = '';
		$treferido = '';
		$estado = '';
		$uso = '';
		$ctipo = '';
		$clasificacion = '';
		$orden = '';
		$paginacion = '';

		if (!empty($oCampo) and !empty($oFiltro)) {

			//$oFiltro = str_replace("*","%",$oFiltro);
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

		//		if(!empty($oCampo) && !empty($oFiltro)){
		//			$oFiltro = str_replace(" ","%",$oFiltro);
		//			switch($oCondicion){
		//				case "esigual":
		//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
		//				break;
		//
		//				case "noesigual":
		//					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
		//				break;
		//				
		//				case "comienza":
		//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		//				break;
		//				
		//				case "termina":
		//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
		//				break;
		//				
		//				case "contiene":
		//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		//				break;
		//				
		//				case "nocontiene":
		//					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
		//				break;
		//				
		//				default:
		//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		//				break;
		//				
		//			}
		//			
		//			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		//		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}


		if (!empty($oEstado)) {
			$estado = ' AND cli.CliEstado = ' . $oEstado;
		}

		if (!empty($oUso)) {
			$uso = ' AND cli.CliUso = "' . $oUso . '"';
		}


		if (!empty($oClienteTipo)) {
			$ctipo = ' AND cli.LtiId = "' . $oClienteTipo . '"';
		}


		if (!empty($oClasificacion)) {
			$clasificacion = ' AND cli.CliClasificacion = ' . $oClasificacion . '';
		}

		if (!empty($oTipoReferido)) {
			$treferido = ' AND cli.TrfId = "' . $oTipoReferido . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cli.CliId,
				cli.LtiId,
				cli.TdoId,
cli.TrfId,
cli.PerId,

				cli.CliTipoDocumentoOtro,
				
				CONCAT(IFNULL(cli.CliNombre,"")," ",IFNULL(cli.CliApellidoPaterno,"")," ",IFNULL(cli.CliApellidoMaterno,"")) AS CliNombreCompleto,
				
				cli.CliNombreComercial,
				cli.CliAbreviatura,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,	
				cli.CliActividadEconomica,	
				cli.CliDireccion,
				
				cli.CliDistrito,
				cli.CliProvincia,
				cli.CliDepartamento,
				cli.CliPais,
				
				cli.CliTelefono,
				cli.CliCelular,
				cli.CliEmail,
							
				
				cli.CliEstadoCivil,
				cli.CliSexo,
				DATE_FORMAT(cli.CliFechaNacimiento, "%d/%m/%Y") AS "NCliFechaNacimiento",
				cli.CliContactoNombre1,
				cli.CliContactoCelular1,
				cli.CliContactoEmail1,
				cli.CliContactoNombre2,
				cli.CliContactoCelular2,
				cli.CliContactoEmail2,
				cli.CliContactoNombre3,
				cli.CliContactoCelular3,
				cli.CliContactoEmail3,
				
				
				cli.CliRepresentanteNombre,
				cli.CliRepresentanteNumeroDocumento,
				cli.CliRepresentanteNacionalidad,
				cli.CliRepresentanteActividadEconomica,
				
		cli.MonId,
		DATE_FORMAT(cli.CliTipoCambioFecha, "%d/%m/%Y") AS "NCliTipoCambioFecha",
		cli.CliTipoCambio,
		cli.CliLineaCredito,
		
				cli.CliArchivo,
				cli.CliClasificacion,
				
				
				cli.CliCSIExcluirMotivo,
				cli.CliCSIIncluir,
				DATE_FORMAT(cli.CliCSIExcluirFecha, "%d/%m/%Y") AS "NCliCSIExcluirFecha",
				
				cli.CliBloquear,
				cli.CliEmailFacturacion,
				cli.CliClaveElectronica,
				cli.CliEstado,
				DATE_FORMAT(cli.CliTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCliTiempoCreacion",
                DATE_FORMAT(cli.CliTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCliTiempoModificacion",
				
				tdo.TdoNombre,
				lti.LtiNombre,
				lti.LtiAbreviatura,
				lti.LtiUtilidad,
				lti.LtiPorcentajeMargenUtilidad
				
				FROM tblclicliente cli	
					LEFT JOIN tbltdotipodocumento tdo
					ON cli.TdoId = tdo.TdoId
						LEFT JOIN tbllticlientetipo lti
						ON cli.LtiId = lti.LtiId
				WHERE 1 = 1 ' . $filtrar . $tipo . $treferido . $estado . $uso . $ctipo . $clasificacion . $orden . $paginacion;



		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsCliente = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$Cliente = new $InsCliente();
			$Cliente->CliId = $fila['CliId'];
			$Cliente->LtiId = $fila['LtiId'];
			$Cliente->TdoId = $fila['TdoId'];
			$Cliente->TrfId = $fila['TrfId'];
			$Cliente->PerId = $fila['PerId'];

			$Cliente->CliTipoDocumentoOtro = $fila['CliTipoDocumentoOtro'];

			$Cliente->CliNombreCompleto = $fila['CliNombreCompleto'];
			$Cliente->CliNombreComercial = $fila['CliNombreComercial'];
			$Cliente->CliAbreviatura = $fila['CliAbreviatura'];
			$Cliente->CliNombre = $fila['CliNombre'];
			$Cliente->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$Cliente->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$Cliente->CliNumeroDocumento = $fila['CliNumeroDocumento'];


			$Cliente->CliActividadEconomica = $fila['CliActividadEconomica'];
			$Cliente->CliDireccion = $fila['CliDireccion'];

			$Cliente->CliDistrito = $fila['CliDistrito'];
			$Cliente->CliProvincia = $fila['CliProvincia'];
			$Cliente->CliDepartamento = $fila['CliDepartamento'];

			$Cliente->CliPais = $fila['CliPais'];

			$Cliente->CliTelefono = $fila['CliTelefono'];
			$Cliente->CliCelular = $fila['CliCelular'];
			$Cliente->CliEmail = $fila['CliEmail'];


			$Cliente->CliEstadoCivil = $fila['CliEstadoCivil'];
			$Cliente->CliSexo = $fila['CliSexo'];
			$Cliente->CliFechaNacimiento = $fila['NCliFechaNacimiento'];

			$Cliente->CliContactoNombre1 = $fila['CliContactoNombre1'];
			$Cliente->CliContactoCelular1 = $fila['CliContactoCelular1'];
			$Cliente->CliContactoEmail1 = $fila['CliContactoEmail1'];

			$Cliente->CliContactoNombre2 = $fila['CliContactoNombre2'];
			$Cliente->CliContactoCelular2 = $fila['CliContactoCelular2'];
			$Cliente->CliContactoEmail2 = $fila['CliContactoEmail2'];

			$Cliente->CliContactoNombre3 = $fila['CliContactoNombre3'];
			$Cliente->CliContactoCelular3 = $fila['CliContactoCelular3'];
			$Cliente->CliContactoEmail3 = $fila['CliContactoEmail3'];

			$Cliente->CliRepresentanteNombre = $fila['CliRepresentanteNombre'];
			$Cliente->CliRepresentanteNumeroDocumento = $fila['CliRepresentanteNumeroDocumento'];
			$Cliente->CliRepresentanteNacionalidad = $fila['CliRepresentanteNacionalidad'];
			$Cliente->CliRepresentanteActividadEconomica = $fila['CliRepresentanteActividadEconomica'];

			$Cliente->MonId = $fila['MonId'];
			$Cliente->CliTipoCambioFecha = $fila['NCliTipoCambioFecha'] ?? '';
			$Cliente->CliTipoCambio = $fila['CliTipoCambio'] ?? '';
			$Cliente->CliLineaCredito = $fila['CliLineaCredito'] ?? '';

			$Cliente->CliArchivo = $fila['CliArchivo'] ?? '';
			$Cliente->CliClasificacion = $fila['CliClasificacion'] ?? '';

			$Cliente->CliCSIExcluirMotivo = $fila['CliCSIExcluirMotivo'] ?? '';
			$Cliente->CliCSIIncluir = $fila['CliCSIIncluir'] ?? '';
			$Cliente->CliCSIExcluirFecha = $fila['NCliCSIExcluirFecha'] ?? '';


			$Cliente->CliBloquear = $fila['CliBloquear'] ?? '';
			$Cliente->CliEmailFacturacion = $fila['CliEmailFacturacion'] ?? '';
			$Cliente->CliClaveElectronica = $fila['CliClaveElectronica'] ?? '';
			$Cliente->CliEstado = $fila['CliEstado'] ?? '';
			$Cliente->CliTiempoCreacion = $fila['NCliTiempoCreacion'] ?? '';
			$Cliente->CliTiempoModificacion = $fila['NCliTiempoModificacion'] ?? '';

			$Cliente->CliTdoNombre = $fila['TdoNombre'] ?? '';

			$Cliente->CliLtiNombre = $fila['LtiNombre'] ?? '';
			$Cliente->CliLtiAbreviatura = $fila['LtiAbreviatura'] ?? '';
			$Cliente->CliLtiUtilidad = $fila['LtiUtilidad'] ?? '';
			$Cliente->CliLtiPorcentajeMargenUtilidad = $fila['LtiPorcentajeMargenUtilidad'] ?? '';

			$Cliente->InsMysql = NULL;
			$Respuesta['Datos'][] = $Cliente;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}


	//Accion eliminar	
	public function MtdEliminarCliente($oElementos)
	{

		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {

			if (!empty($elemento)) {

				if (!$error) {

					$sql = 'DELETE FROM tblclicliente WHERE  (CliId = "' . ($elemento) . '" ) ';

					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {

						$this->MtdAuditarCliente(3, "Se elimino el Cliente", $elemento);
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



		/*	$elementos = explode("#",$oElementos);
		$i=1;
		foreach($elementos as $elemento){
			if(!empty($elemento)){
			
				if($i==count($elementos)){						
					$eliminar .= '  (CliId = "'.($elemento).'")';	
				}else{
					$eliminar .= '  (CliId = "'.($elemento).'")  OR';	
				}	
			}
		$i++;
		
		}
		
		$sql = 'DELETE FROM  tblclicliente WHERE '.$eliminar;
		
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
		
		if(!$resultado) {						
			$error = true;
		} 		
		
		if($error) {						
			return false;
		} else {			
			$this->MtdAuditarCliente(3,"Se elimino el Cliente",$aux);			
			return true;
		}
*/
	}




	//Accion eliminar	
	public function MtdActualizarBloquearCliente($oElementos, $oBloquear)
	{

		$this->InsMysql->MtdTransaccionIniciar();

		$error = false;

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {

			if (!empty($elemento)) {

				if (!$error) {

					$sql = 'UPDATE tblclicliente SET CliBloquear = ' . $oBloquear . ' WHERE  (CliId = "' . ($elemento) . '" ) ';

					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {

						if ($oBloquear == "1") {
							$this->MtdAuditarCliente(2, "Se bloqueo el Cliente", $elemento);
						} else {
							$this->MtdAuditarCliente(2, "Se desbloqueo el Cliente", $elemento);
						}
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


	//$this->MtdAuditarCliente(1,"Se registro el Cliente.",$this);		

	public function MtdRegistrarCliente($oTransaccion = true)
	{


		global $Resultado;
		$error = false;

		$ClienteId = $this->MtdVerificarExisteCliente();

		if (!empty($ClienteId)) {
			$error = true;
			$Resultado .= '#ERR_CLI_201';
		}

		$this->MtdGenerarClienteId();

		$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
			TrfId,
			PerId,
			
			CliTipoDocumentoOtro,
			CliNombreCompleto,
			CliNombreComercial,
			
			CliAbreviatura,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliActividadEconomica,
			
			CliDireccion,
			CliDistrito,
			CliProvincia,
			CliDepartamento,
			CliPais,
			CliTelefono,
			CliCelular,
			CliEmail,
			CliFechaNacimiento,
			CliContactoNombre1,
			CliContactoCelular1,
			CliContactoEmail1,
			CliContactoNombre2,
			CliContactoCelular2,
			CliContactoEmail2,
			CliContactoNombre3,
			CliContactoCelular3,
			CliContactoEmail3,
			
			CliRepresentanteNombre,
			CliRepresentanteNumeroDocumento,
			CliRepresentanteNacionalidad,
			CliRepresentanteActividadEconomica,
			
			MonId,
			CliTipoCambioFecha,
			CliTipoCambio,
			CliLineaCredito,
			
			CliCSIIncluir,
			CliCSIExcluirMotivo,
			CliCSIExcluirFecha,
			
			CliCSIVentaIncluir,
			CliCSIVentaExcluirMotivo,
			CliCSIVentaExcluirFecha,
			
			CliArchivo,
			CliClasificacion,
			CliBloquear,
			CliObservacion,
			
			CliClaveElectronica,
			CliEmailFacturacion,
			
			CliSexo,
			CliEstadoCivil,
			
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"' . ($this->CliId) . '", 
			' . (empty($this->LtiId) ? 'NULL, ' : '"' . $this->LtiId . '",') . '
			"' . ($this->TdoId) . '",
			' . (empty($this->TrfId) ? 'NULL, ' : '"' . $this->TrfId . '",') . '
			' . (empty($this->PerId) ? 'NULL, ' : '"' . $this->PerId . '",') . '
			
			"' . ($this->CliTipoDocumentoOtro) . '",
			"' . ($this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno) . '",
			"' . ($this->CliNombreComercial) . '",
			
			"' . ($this->CliAbreviatura) . '",
			"' . ($this->CliNombre) . '",
			"' . ($this->CliApellidoPaterno) . '",
			"' . ($this->CliApellidoMaterno) . '",			
			"' . ($this->CliNumeroDocumento) . '",		
			"' . ($this->CliActividadEconomica) . '",		
				 
			"' . ($this->CliDireccion) . '", 	
			
			"' . ($this->CliDistrito) . '", 	
			"' . ($this->CliProvincia) . '", 	
			"' . ($this->CliDepartamento) . '", 	
			"' . ($this->CliPais) . '", 	
			
			"' . ($this->CliTelefono) . '", 
			"' . ($this->CliCelular) . '", 
			"' . ($this->CliEmail) . '", 
			' . (empty($this->CliFechaNacimiento) ? 'NULL, ' : '"' . $this->CliFechaNacimiento . '",') . '
			"' . ($this->CliContactoNombre1) . '", 
			"' . ($this->CliContactoCelular1) . '", 
			"' . ($this->CliContactoEmail1) . '", 
			
			"' . ($this->CliContactoNombre2) . '", 
			"' . ($this->CliContactoCelular2) . '", 
			"' . ($this->CliContactoEmail2) . '", 

			"' . ($this->CliContactoNombre3) . '", 
			"' . ($this->CliContactoCelular3) . '", 
			"' . ($this->CliContactoEmail3) . '", 
	
			"' . ($this->CliRepresentanteNombre) . '", 
			"' . ($this->CliRepresentanteNumeroDocumento) . '", 
			"' . ($this->CliRepresentanteNacionalidad) . '", 
			"' . ($this->CliRepresentanteActividadEconomica) . '", 

			
			' . (empty($this->MonId) ? 'NULL, ' : '"' . $this->MonId . '",') . '
			' . (empty($this->CliTipoCambioFecha) ? 'NULL, ' : '"' . $this->CliTipoCambioFecha . '",') . '
			' . (empty($this->CliTipoCambio) ? 'NULL, ' : '"' . $this->CliTipoCambio . '",') . '
				' . ($this->CliLineaCredito) . ', 

			' . ($this->CliCSIIncluir) . ', 
			"' . ($this->CliCSIExcluirMotivo) . '", 
			' . (empty($this->CliCSIExcluirFecha) ? 'NULL, ' : '"' . $this->CliCSIExcluirFecha . '",') . '

			' . ($this->CliCSIVentaIncluir) . ', 
			"' . ($this->CliCSIVentaExcluirMotivo) . '",			
			' . (empty($this->CliCSIVentaExcluirFecha) ? 'NULL, ' : '"' . $this->CliCSIVentaExcluirFecha . '",') . '
			
			"' . ($this->CliArchivo) . '", 
			' . ($this->CliClasificacion) . ', 
			2,
			"' . ($this->CliObservacion) . '", 
			
			"' . ($this->CliClaveElectronica) . '", 
			"' . ($this->CliEmailFacturacion) . '", 
			
			"' . ($this->CliSexo) . '", 
			"' . ($this->CliEstadoCivil) . '", 
			
			' . ($this->CliEstado) . ', 
			"' . ($this->CliTiempoCreacion) . '", 
			"' . ($this->CliTiempoModificacion) . '");';

		if (!$error) {

			$resultado = $this->InsMysql->MtdEjecutar($sql, true);

			if (!$resultado) {
				$error = true;
			}
		}

		if ($error) {
			return false;
		} else {
			$this->MtdAuditarCliente(1, "Se registro el Cliente.", $this);
			return true;
		}
	}


	public function MtdEditarCliente()
	{


		$sql = 'UPDATE tblclicliente SET 
			' . (empty($this->LtiId) ? 'LtiId = NULL, ' : 'LtiId = "' . $this->LtiId . '",') . '
			TdoId = "' . ($this->TdoId) . '",
			' . (empty($this->TrfId) ? 'TrfId = NULL, ' : 'TrfId = "' . $this->TrfId . '",') . '
			' . (empty($this->PerId) ? 'PerId = NULL, ' : 'PerId = "' . $this->PerId . '",') . '
			
			CliTipoDocumentoOtro = "' . ($this->CliTipoDocumentoOtro) . '",
			CliNombreCompleto = "' . ($this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno) . '",
			
			CliNombreComercial = "' . ($this->CliNombreComercial) . '",
			CliAbreviatura = "' . ($this->CliAbreviatura) . '",
			CliNombre = "' . ($this->CliNombre) . '",
			CliApellidoPaterno = "' . ($this->CliApellidoPaterno) . '",
			CliApellidoMaterno = "' . ($this->CliApellidoMaterno) . '",
			CliNumeroDocumento = "' . ($this->CliNumeroDocumento) . '",
			CliActividadEconomica = "' . ($this->CliActividadEconomica) . '",
			
			
			CliDireccion = "' . ($this->CliDireccion) . '",
			
			CliDistrito = "' . ($this->CliDistrito) . '",
			CliProvincia = "' . ($this->CliProvincia) . '",
			CliDepartamento = "' . ($this->CliDepartamento) . '",
			CliPais = "' . ($this->CliPais) . '",
			
			CliTelefono = "' . ($this->CliTelefono) . '",
			CliCelular = "' . ($this->CliCelular) . '",
			CliEmail = "' . ($this->CliEmail) . '",
			' . (empty($this->CliFechaNacimiento) ? 'CliFechaNacimiento = NULL, ' : 'CliFechaNacimiento = "' . $this->CliFechaNacimiento . '",') . '
			CliContactoNombre1 = "' . ($this->CliContactoNombre1) . '",
			CliContactoCelular1 = "' . ($this->CliContactoCelular1) . '",
			CliContactoEmail1 = "' . ($this->CliContactoEmail1) . '",
			CliContactoNombre2 = "' . ($this->CliContactoNombre2) . '",
			CliContactoCelular2 = "' . ($this->CliContactoCelular2) . '",
			CliContactoEmail2 = "' . ($this->CliContactoEmail2) . '",
			CliContactoNombre3 = "' . ($this->CliContactoNombre3) . '",
			CliContactoCelular3 = "' . ($this->CliContactoCelular3) . '",
			CliContactoEmail3 = "' . ($this->CliContactoEmail3) . '",
			
			
			CliRepresentanteNombre = "' . ($this->CliRepresentanteNombre) . '",
			CliRepresentanteNumeroDocumento = "' . ($this->CliRepresentanteNumeroDocumento) . '",
			CliRepresentanteNacionalidad = "' . ($this->CliRepresentanteNacionalidad) . '",
			CliRepresentanteActividadEconomica = "' . ($this->CliRepresentanteActividadEconomica) . '",
			
			' . (empty($this->CliTipoCambioFecha) ? 'CliTipoCambioFecha = NULL, ' : 'CliTipoCambioFecha = "' . $this->CliTipoCambioFecha . '",') . '
			' . (empty($this->CliTipoCambio) ? 'CliTipoCambio = NULL, ' : 'CliTipoCambio = "' . $this->CliTipoCambio . '",') . '
			' . (empty($this->MonId) ? 'MonId = NULL, ' : 'MonId = "' . $this->MonId . '",') . '
			CliLineaCredito = ' . ($this->CliLineaCredito) . ',
			
			CliCSIIncluir = ' . ($this->CliCSIIncluir) . ',
			CliCSIExcluirMotivo = "' . ($this->CliCSIExcluirMotivo) . '",
			' . (empty($this->CliCSIExcluirFecha) ? 'CliCSIExcluirFecha = NULL, ' : 'CliCSIExcluirFecha = "' . $this->CliCSIExcluirFecha . '",') . '
			
			CliCSIVentaIncluir = ' . ($this->CliCSIVentaIncluir) . ',
			CliCSIVentaExcluirMotivo = "' . ($this->CliCSIVentaExcluirMotivo) . '",
			' . (empty($this->CliCSIVentaExcluirFecha) ? 'CliCSIVentaExcluirFecha = NULL, ' : 'CliCSIVentaExcluirFecha = "' . $this->CliCSIVentaExcluirFecha . '",') . '
		
			CliArchivo = "' . ($this->CliArchivo) . '",	
			CliClasificacion = ' . ($this->CliClasificacion) . ',		
			CliObservacion = "' . ($this->CliObservacion) . '",	
			
			CliClaveElectronica = "' . ($this->CliClaveElectronica) . '",	
			CliEmailFacturacion = "' . ($this->CliEmailFacturacion) . '",	
			
			CliSexo = "' . ($this->CliSexo) . '",
			CliEstadoCivil = "' . ($this->CliEstadoCivil) . '",
			
			CliEstado = ' . ($this->CliEstado) . ',
			CliTiempoModificacion = "' . ($this->CliTiempoModificacion) . '"
			WHERE CliId = "' . ($this->CliId) . '";';


		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, true);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {

			$this->MtdAuditarCliente(2, "Se edito el Cliente.", $this);
			return true;
		}
	}






	/*


	public function MtdRegistrarClienteSimple($oTransaccion=true) {
		

		global $Resultado;
		$error = false;
		
		$ClienteId = $this->MtdVerificarExisteCliente();
		
		if(!empty($ClienteId)){
			$error = true;
			$Resultado.='#ERR_CLI_201';
		}

			$this->MtdGenerarClienteId();
		
			$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
			CliTipoDocumentoOtro,
			CliNombreCompleto,
			CliNombreComercial,
			
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliActividadEconomica,
			
			CliDireccion,
			CliDistrito,
			CliProvincia,
			CliDepartamento,
			CliPais,
			CliTelefono,
			CliCelular,
			CliEmail,
			CliFechaNacimiento,
			CliContactoNombre1,
			CliContactoCelular1,
			CliContactoEmail1,
			CliContactoNombre2,
			CliContactoCelular2,
			CliContactoEmail2,
			CliContactoNombre3,
			CliContactoCelular3,
			CliContactoEmail3,
			
			CliRepresentanteNombre,
			CliRepresentanteNumeroDocumento,
			CliRepresentanteNacionalidad,
			CliRepresentanteActividadEconomica,
			
			MonId,
			CliTipoCambioFecha,
			CliTipoCambio,
			CliLineaCredito,
			
			CliCSIIncluir,
			CliCSIExcluirMotivo,
			CliCSIExcluirFecha,
			
			CliCSIVentaIncluir,
			CliCSIVentaExcluirMotivo,
			CliCSIVentaExcluirFecha,
			
			CliArchivo,
			CliClasificacion,
			CliBloquear,
			
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			"'.($this->TdoId).'",
			"'.($this->CliTipoDocumentoOtro).'",
			"'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			"'.($this->CliNombreComercial).'",
			
			"'.($this->CliNombre).'",
			"'.($this->CliApellidoPaterno).'",
			"'.($this->CliApellidoMaterno).'",			
			"'.($this->CliNumeroDocumento).'",		
			"'.($this->CliActividadEconomica).'",		
				 
			"'.($this->CliDireccion).'", 	
			
			"'.($this->CliDistrito).'", 	
			"'.($this->CliProvincia).'", 	
			"'.($this->CliDepartamento).'", 	
			"'.($this->CliPais).'", 	
			
			"'.($this->CliTelefono).'", 
			"'.($this->CliCelular).'", 
			"'.($this->CliEmail).'", 
			NULL,
			"'.($this->CliContactoNombre1).'", 
			"'.($this->CliContactoCelular1).'", 
			"'.($this->CliContactoEmail1).'", 
			
			"'.($this->CliContactoNombre2).'", 
			"'.($this->CliContactoCelular2).'", 
			"'.($this->CliContactoEmail2).'", 

			"'.($this->CliContactoNombre3).'", 
			"'.($this->CliContactoCelular3).'", 
			"'.($this->CliContactoEmail3).'", 
	
			"'.($this->CliRepresentanteNombre).'", 
			"'.($this->CliRepresentanteNumeroDocumento).'", 
			"'.($this->CliRepresentanteNacionalidad).'", 
			"'.($this->CliRepresentanteActividadEconomica).'", 

			
			'.(empty($this->MonId)?'NULL, ':'"'.$this->MonId.'",').'
			'.(empty($this->CliTipoCambioFecha)?'NULL, ':'"'.$this->CliTipoCambioFecha.'",').'
			'.(empty($this->CliTipoCambio)?'NULL, ':'"'.$this->CliTipoCambio.'",').'
				'.($this->CliLineaCredito).', 

			'.($this->CliCSIIncluir).', 
			"'.($this->CliCSIExcluirMotivo).'", 
			'.(empty($this->CliCSIExcluirFecha)?'NULL, ':'"'.$this->CliCSIExcluirFecha.'",').'

			'.($this->CliCSIVentaIncluir).', 
			"'.($this->CliCSIVentaExcluirMotivo).'",			
			'.(empty($this->CliCSIVentaExcluirFecha)?'NULL, ':'"'.$this->CliCSIVentaExcluirFecha.'",').'
			
			"'.($this->CliArchivo).'", 
			'.($this->CliClasificacion).', 
			2,
			
			'.($this->CliEstado).', 
			"'.($this->CliTiempoCreacion).'", 
			"'.($this->CliTiempoModificacion).'");';

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,true);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				$this->MtdAuditarCliente(1,"Se registro el Cliente.",$this);		
				return true;
			}			
			
	}*/

	public function MtdEditarClienteSimple()
	{


		$sql = 'UPDATE tblclicliente SET 
			' . (empty($this->LtiId) ? 'LtiId = NULL, ' : 'LtiId = "' . $this->LtiId . '",') . '
			TdoId = "' . ($this->TdoId) . '",
			CliTipoDocumentoOtro = "' . ($this->CliTipoDocumentoOtro) . '",
			CliNombreCompleto = "' . ($this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno) . '",
			
			CliNombreComercial = "' . ($this->CliNombreComercial) . '",
			CliNombre = "' . ($this->CliNombre) . '",
			CliApellidoPaterno = "' . ($this->CliApellidoPaterno) . '",
			CliApellidoMaterno = "' . ($this->CliApellidoMaterno) . '",
			CliNumeroDocumento = "' . ($this->CliNumeroDocumento) . '",
			
			CliDireccion = "' . ($this->CliDireccion) . '",
			CliTelefono = "' . ($this->CliTelefono) . '",
			CliCelular = "' . ($this->CliCelular) . '",
			CliEmail = "' . ($this->CliEmail) . '",

			CliEstado = ' . ($this->CliEstado) . ',
			CliTiempoModificacion = "' . ($this->CliTiempoModificacion) . '"
			WHERE CliId = "' . ($this->CliId) . '";';


		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, true);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {

			$this->MtdAuditarCliente(2, "Se edito el Cliente.", $this);
			return true;
		}
	}



	public function MtdEditarCSICliente()
	{

		$sql = 'UPDATE tblclicliente SET 
			CliCSIIncluir = ' . ($this->CliCSIIncluir) . ',
			CliCSIExcluirMotivo = "' . ($this->CliCSIExcluirMotivo) . '",
			' . (empty($this->CliCSIExcluirFecha) ? 'CliCSIExcluirFecha = NULL, ' : 'CliCSIExcluirFecha = "' . $this->CliCSIExcluirFecha . '",') . '
			
			CliTiempoModificacion = NOW()
			WHERE CliId = "' . ($this->CliId) . '";';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			$this->MtdAuditarCliente(2, "Se edito el CSI PostVenta de Cliente.", $this);
			return true;
		}
	}


	public function MtdEditarCSIVentaCliente()
	{

		$sql = 'UPDATE tblclicliente SET 
			CliCSIVentaIncluir = ' . ($this->CliCSIVentaIncluir) . ',
			CliCSIVentaExcluirMotivo = "' . ($this->CliCSIVentaExcluirMotivo) . '",

			' . (empty($this->CliCSIVentaExcluirFecha) ? 'CliCSIVentaExcluirFecha = NULL, ' : 'CliCSIVentaExcluirFecha = "' . $this->CliCSIVentaExcluirFecha . '",') . '
			
			CliTiempoModificacion = NOW()
			WHERE CliId = "' . ($this->CliId) . '";';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			$this->MtdAuditarCliente(2, "Se edito el CSI Venta de Cliente.", $this);
			return true;
		}
	}


















	public function MtdVerificarExisteCliente()
	{

		/*      $sql = 'SELECT 
        CliId
        FROM tblclicliente
        WHERE CliNombreCompleto = "'.$this->CliNombre.'" AND (CliNumeroDocumento="'.$this->CliNumeroDocumento.'") LIMIT 1 ;';
*/

		$sql = 'SELECT 
        CliId
        FROM tblclicliente
        WHERE (CliNumeroDocumento="' . $this->CliNumeroDocumento . '") LIMIT 1 ;';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			//			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)){
			//$this->CliId = $fila['CliId'];
			//$this->MtdObtenerCliente();
			//			}

			//			$Respuesta =  $this;
			$Respuesta = $fila['CliId'];
		} else {
			$Respuesta =   NULL;
		}

		return $Respuesta;
	}







	/*
	public function MtdRegistrarCliente2() {
	
			$this->MtdGenerarClienteId();
		
			$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
			CliNombreCompleto,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,	
			MonId,
			CliTipoCambio,
			CliLineaCredito,	
			
			CliCSIIncluir,
			CliCSIVentaIncluir,

			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			"'.($this->TdoId).'",
			"'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			"'.($this->CliNombre).'",
			"'.($this->CliApellidoPaterno).'",
			"'.($this->CliApellidoMaterno).'",			
			"'.($this->CliNumeroDocumento).'",			 
			NULL,
			NULL,
			0,
			
			1,
			1,
			'.($this->CliEstado).', 
			"'.($this->CliTiempoCreacion).'", 
			"'.($this->CliTiempoModificacion).'");';

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
			
	}*/
	/*
		public function MtdEditarCliente2() {

			$sql = 'UPDATE tblclicliente SET 
			TdoId = "'.($this->TdoId).'",
			CliNombreCompleto = "'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			CliNombre = "'.($this->CliNombre).'",
			CliApellidoPaterno = "'.($this->CliApellidoPaterno).'",
			CliApellidoMaterno = "'.($this->CliApellidoMaterno).'",
			CliNumeroDocumento = "'.($this->CliNumeroDocumento).'",
			CliTiempoModificacion = "'.($this->CliTiempoModificacion).'"
			WHERE CliId = "'.($this->CliId).'";';
			
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
	
		*/


	public function MtdActualizarClienteEstado($oElementos, $oEstado)
	{

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				if (!$error) {

					$sql = 'UPDATE tblclicliente SET CliEstado = ' . $oEstado . ' WHERE ( CliId = "' . ($elemento) . '" )';

					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {
						$this->MtdAuditarCliente(2, "Se actualizo el estado del cliente", $aux);
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


	public function MtdEditarClienteDato($oCampo, $oDato, $oId)
	{

		$sql = 'UPDATE tblclicliente SET 
			' . (empty($oDato) ? $oCampo . ' = NULL, ' : $oCampo . ' = "' . $oDato . '",') . '
			CliTiempoModificacion = NOW()
			WHERE CliId = "' . ($oId) . '";';

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






	//
	//		public function MtdEditarClienteDireccion() {
	//
	//			$sql = 'UPDATE tblclicliente SET 
	//			CliDireccion = "'.($this->CliDireccion).'",
	//			CliTiempoModificacion = "'.($this->CliTiempoModificacion).'"
	//			WHERE CliId = "'.($this->CliId).'";';
	//			
	//			$error = false;
	//
	//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
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
	//				
	//		}	
	//		
	//		
	//		public function MtdEditarClienteTelefono() {
	//
	//			$sql = 'UPDATE tblclicliente SET 
	//			CliTelefono = "'.($this->CliTelefono ).'",
	//			CliTiempoModificacion = "'.($this->CliTiempoModificacion).'"
	//			WHERE CliId = "'.($this->CliId).'";';
	//			
	//			$error = false;
	//
	//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
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
	//				
	//		}			
	//		
	//		public function MtdEditarClienteCelular() {
	//
	//			$sql = 'UPDATE tblclicliente SET 
	//			CliCelular = "'.($this->CliCelular ).'",
	//			CliTiempoModificacion = "'.($this->CliTiempoModificacion).'"
	//			WHERE CliId = "'.($this->CliId).'";';
	//			
	//			$error = false;
	//
	//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
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
	//				
	//		}
	//		
	//		public function MtdEditarClienteNumeroDocumento() {
	//
	//			$sql = 'UPDATE tblclicliente SET 
	//			CliNumeroDocumento = "'.($this->CliNumeroDocumento ).'",
	//			CliTiempoModificacion = "'.($this->CliTiempoModificacion).'"
	//			WHERE CliId = "'.($this->CliId).'";';
	//			
	//			$error = false;
	//
	//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
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
	//				
	//		}		

	/*
	public function MtdRegistrarClienteDeBoleta() {

		global $Resultado;
		$error = false;
		
			$this->MtdGenerarClienteId();
		
			$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
		
			CliNombreCompleto,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliDireccion,
			CliFechaNacimiento,
			
			MonId,
			CliTipoCambio,
			CliLineaCredito,
			
			CliCSIIncluir,
			CliCSIVentaIncluir,
			
			CliClasificacion,
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			"'.($this->TdoId).'",
			
			"'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			"'.($this->CliNombre).'",
			"'.($this->CliApellidoPaterno).'",
			"'.($this->CliApellidoMaterno).'",			
			"'.($this->CliNumeroDocumento).'",			 
			"'.($this->CliDireccion).'", 
			NULL,
			
			NULL,
			NULL,
			0,
			
			1,
			1,
			
			1,
			1, 
			"'.($this->CliTiempoCreacion).'", 
			"'.($this->CliTiempoModificacion).'");';

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}	
	*/
	/*
	public function MtdRegistrarClienteDeFactura() {

		global $Resultado;
		$error = false;
		
			$this->MtdGenerarClienteId();
		
			$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
		
			CliNombreCompleto,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliDireccion,
			CliFechaNacimiento,
			
			MonId,
			CliTipoCambio,
			CliLineaCredito,
			
			CliCSIIncluir,
			CliCSIVentaIncluir,
			
			CliClasificacion,
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			"'.($this->TdoId).'",
			
			"'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			"'.($this->CliNombre).'",
			"'.($this->CliApellidoPaterno).'",
			"'.($this->CliApellidoMaterno).'",			
			"'.($this->CliNumeroDocumento).'",			 
			"'.($this->CliDireccion).'", 
			NULL,
			
			NULL,
			NULL,
			0,

			1,
			1,
			
			1,
			1, 
			"'.($this->CliTiempoCreacion).'", 
			"'.($this->CliTiempoModificacion).'");';

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}		
	
	*/

	/*
	public function MtdRegistrarClienteDeVentaDirecta() {

		global $Resultado;
		$error = false;
		
			$this->MtdGenerarClienteId();
		
			$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
		
			CliNombreCompleto,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliDireccion,
			CliFechaNacimiento,
			
			MonId,
			CliTipoCambio,
			CliLineaCredito,
			
			CliCSIIncluir,
			CliCSIVentaIncluir,
			
			CliClasificacion,
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			"'.($this->TdoId).'",
			
			"'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			"'.($this->CliNombre).'",
			"'.($this->CliApellidoPaterno).'",
			"'.($this->CliApellidoMaterno).'",			
			"'.($this->CliNumeroDocumento).'",			 
			"'.($this->CliDireccion).'", 
			NULL,
			
			NULL,
			NULL,
			0,

			1,
			1,
			
			1, 
			1, 
			"'.($this->CliTiempoCreacion).'", 
			"'.($this->CliTiempoModificacion).'");';

			if(!$error){
				
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}		*/

	/*
	public function MtdRegistrarClienteDeCotizacionCliente() {

		global $Resultado;
		$error = false;
		
			$this->MtdGenerarClienteId();
		
			$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
		
			CliNombreCompleto,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliDireccion,
		
			CliTelefono,
			CliCelular,
			CliEmail,
			CliFechaNacimiento,
			
			MonId,
			CliTipoCambio,
			CliLineaCredito,
			
			CliCSIIncluir,
			CliCSIVentaIncluir,
			
			CliClasificacion,
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			"'.($this->TdoId).'",
			
			"'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			"'.($this->CliNombre).'",
			"'.($this->CliApellidoPaterno).'",
			"'.($this->CliApellidoMaterno).'",			
			"'.($this->CliNumeroDocumento).'",			 
			"'.($this->CliDireccion).'", 

			"'.($this->CliTelefono).'", 
			"'.($this->CliCelular).'", 
			"'.($this->CliEmail).'", 
			NULL,
			
			NULL,
			NULL,
			0,

			1,
			1,
			
			1,
			1, 
			"'.($this->CliTiempoCreacion).'", 
			"'.($this->CliTiempoModificacion).'");';

			if(!$error){

				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			

	}	
	
	*/
	/*
	public function MtdRegistrarClienteDeCotizacionVehiculo() {

		global $Resultado;
		$error = false;
		
			$this->MtdGenerarClienteId();
		
			$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
		
			CliNombreCompleto,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliDireccion,
		
			CliTelefono,
			CliCelular,
			CliEmail,
			CliFechaNacimiento,
			
			MonId,
			CliTipoCambio,
			CliLineaCredito,
			
			
			
			CliCSIIncluir,
			CliCSIVentaIncluir,
			
			CliClasificacion,
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"'.($this->CliId).'", 
			'.(empty($this->LtiId)?'NULL, ':'"'.$this->LtiId.'",').'
			"'.($this->TdoId).'",
			
			"'.($this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno).'",
			"'.($this->CliNombre).'",
			"'.($this->CliApellidoPaterno).'",
			"'.($this->CliApellidoMaterno).'",			
			"'.($this->CliNumeroDocumento).'",			 
			"'.($this->CliDireccion).'", 

			"'.($this->CliTelefono).'", 
			"'.($this->CliCelular).'", 
			"'.($this->CliEmail).'", 
			NULL,
			
			NULL,
			NULL,
			0,

			
			
			1,
			1,
			
			1,
			1, 
			"'.($this->CliTiempoCreacion).'", 
			"'.($this->CliTiempoModificacion).'");';

			if(!$error){

				$resultado = $this->InsMysql->MtdEjecutar($sql,false);

				if(!$resultado) {						
					$error = true;
				} 	

			}

			if($error) {						
				return false;
			} else {				
				return true;
			}			

	}*/



	public function MtdRegistrarClienteLead()
	{

		global $Resultado;
		$error = false;

		$this->MtdGenerarClienteId();

		$sql = 'INSERT INTO tblclicliente (
			CliId,
			LtiId,
			TdoId,
			PerId,
			
			CliNombreCompleto,
			CliNombre,
			CliApellidoPaterno,
			CliApellidoMaterno,
			CliNumeroDocumento,
			CliDireccion,
		
			CliTelefono,
			CliCelular,
			CliEmail,
			CliFechaNacimiento,
			
			MonId,
			CliTipoCambio,
			CliLineaCredito,
			
			CliCSIIncluir,
			CliCSIVentaIncluir,
			
			CliLeadFechaAsignado,
			CliLeadModelo,
			CliLeadObservacion,
			CliLeadEtapaFase,
			CliLeadTiempoModificacion,
			CliLead,
			
			CliClasificacion,
			CliEstado,
			CliTiempoCreacion,
			CliTiempoModificacion
			) 
			VALUES (
			"' . ($this->CliId) . '", 
			' . (empty($this->LtiId) ? 'NULL, ' : '"' . $this->LtiId . '",') . '
			"' . ($this->TdoId) . '",
			' . (empty($this->PerId) ? 'NULL, ' : '"' . $this->PerId . '",') . '
			
			"' . ($this->CliNombre . " " . $this->CliApellidoPaterno . " " . $this->CliApellidoMaterno) . '",
			"' . ($this->CliNombre) . '",
			"' . ($this->CliApellidoPaterno) . '",
			"' . ($this->CliApellidoMaterno) . '",			
			"' . ($this->CliNumeroDocumento) . '",			 
			"' . ($this->CliDireccion) . '", 

			"' . ($this->CliTelefono) . '", 
			"' . ($this->CliCelular) . '", 
			"' . ($this->CliEmail) . '", 
			NULL,
			
			NULL,
			NULL,
			0,

			
			1,
			1,
			
			
			"' . ($this->CliLeadFechaAsignado) . '", 
			"' . ($this->CliLeadModelo) . '", 
			"' . ($this->CliLeadObservacion) . '", 
			"' . ($this->CliLeadEtapaFase) . '", 
			"' . ($this->CliLeadTiempoModificacion) . '", 
			"' . ($this->CliLead) . '", 
			
			1,
			1, 
			"' . ($this->CliTiempoCreacion) . '", 
			"' . ($this->CliTiempoModificacion) . '");';

		if (!$error) {

			$resultado = $this->InsMysql->MtdEjecutar($sql, false);

			if (!$resultado) {
				$error = true;
			}
		}

		if ($error) {
			return false;
		} else {
			return true;
		}
	}



	public function MtdEditarClienteLead()
	{

		$sql = 'UPDATE tblclicliente SET 
			' . (empty($this->PerId) ? 'PerId = NULL, ' : 'PerId = "' . $this->PerId . '",') . '
			
			' . (empty($this->CliLeadFechaAsignado) ? 'CliLeadFechaAsignado = NULL, ' : 'CliLeadFechaAsignado = "' . $this->CliLeadFechaAsignado . '",') . '
			
			CliLeadModelo = "' . ($this->CliLeadModelo) . '",
			CliLeadObservacion = "' . ($this->CliLeadObservacion) . '",
			CliLeadEtapaFase = "' . ($this->CliLeadEtapaFase) . '",
			CliLeadTiempoModificacion = "' . ($this->CliLeadTiempoModificacion) . '",
			CliLead = "' . ($this->CliLead) . '",
		
			CliTiempoModificacion = "' . ($this->CliTiempoModificacion) . '"
			WHERE CliId = "' . ($this->CliId) . '";';

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

	public function MtdEditarClienteCSIPostVenta()
	{

		$sql = 'UPDATE tblclicliente SET 
			
			CliCSIIncluir = ' . ($this->CliCSIIncluir) . ',
			CliCSIExcluirMotivo = "' . ($this->CliCSIExcluirMotivo) . '",

			' . (empty($this->CliCSIExcluirFecha) ? 'CliCSIExcluirFecha = NULL, ' : 'CliCSIExcluirFecha = "' . $this->CliCSIExcluirFecha . '",') . '
			
			
			
			CliCSIExcluirUsuario = "' . ($this->CliCSIExcluirUsuario) . '",
			
			CliTiempoModificacion = "' . ($this->CliTiempoModificacion) . '"
			WHERE CliId = "' . ($this->CliId) . '";';

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
	public function MtdEditarClienteCSIVenta()
	{

		$sql = 'UPDATE tblclicliente SET 
			
			CliCSIVentaIncluir = ' . ($this->CliCSIVentaIncluir) . ',
			CliCSIVentaExcluirMotivo = "' . ($this->CliCSIVentaExcluirMotivo) . '",
		
			' . (empty($this->CliCSIVentaExcluirFecha) ? 'CliCSIVentaExcluirFecha = NULL, ' : 'CliCSIVentaExcluirFecha = "' . $this->CliCSIVentaExcluirFecha . '",') . '
			
			CliCSIVentaExcluirUsuario = "' . ($this->CliCSVentaIExcluirUsuario) . '",
			
			CliTiempoModificacion = "' . ($this->CliTiempoModificacion) . '"
			WHERE CliId = "' . ($this->CliId) . '";';

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

	private function MtdAuditarCliente($oAccion, $oDescripcion, $oDatos, $oCodigo = NULL, $oUsuario = NULL, $oPersonal = NULL)
	{

		$InsAuditoria = new ClsAuditoria($this->InsMysql);
		$InsAuditoria->AudCodigo = $this->CliId;
		$InsAuditoria->AudCodigoExtra = NULL;
		$InsAuditoria->UsuId = $this->UsuId;
		$InsAuditoria->SucId = NULL;
		$InsAuditoria->AudAccion = $oAccion;
		$InsAuditoria->AudDescripcion = $oDescripcion;
		$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
		$InsAuditoria->AudDatos = $oDatos;
		$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");

		if ($InsAuditoria->MtdAuditoriaRegistrar("v2")) {
			return true;
		} else {
			return false;
		}
	}
}
