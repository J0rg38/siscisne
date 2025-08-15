<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsRegistroOperacionUIF
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsRegistroOperacionUIF
{

	public $RouId;
	public $RouFecha;
	public $RouHora;
	public $PerId;

	public $CliId;
	public $RouCodigoEmpresa;
	public $RouCodigoOficialCumplimiento;
	public $MonId;

	public $RouImporte;
	public $RouTipoCambio;
	public $RouTransaccion;


	public $RouDireccion;
	public $RouTelefono;
	public $RouCelular;

	public $RouOrdenanteNombre;
	public $RouOrdenanteNumeroDocumento;
	public $RouOrdenanteDireccion;

	public $RouTramitanteNombre;
	public $RouTramitanteNumeroDocumento;
	public $RouTramitanteDireccion;

	public $RouOrigenFondo;
	public $RouObservacionInterna;
	public $RouObservacionImpresa;

	public $RouEstado;
	public $RouTiempoCreacion;
	public $RouTiempoModificacion;
	public $RouEliminado;

	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $CliNombre;
	public $CliNumeroDocumento;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliDireccion;
	public $CliDistrito;
	public $CliDepartamento;
	public $CliProvincia;
	public $TdoId;
	public $CliTelefono;
	public $CliCelular;
	public $CliPais;
	public $MonNombre;
	public $MonSimbolo;

	public $InsMysql;


	public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}

	public function __destruct() {}

	public function MtdGenerarRegistroOperacionUIFId()
	{

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RouId,5),unsigned)) AS "MAXIMO"
			FROM tblrouregistrooperacionuif';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->RouId = "ROU-10000";
		} else {
			$fila['MAXIMO']++;
			$this->RouId = "ROU-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerRegistroOperacionUIF()
	{

		$sql = 'SELECT 
        rou.RouId,
		
		DATE_FORMAT(rou.RouFecha, "%d/%m/%Y") AS "NRouFecha",
		DATE_FORMAT(rou.RouHora, "%H:%i") AS "NRouHora",
		
		rou.PerId,
		
		rou.CliId,
		rou.RouCodigoEmpresa,
		rou.RouCodigoOficialCumplimiento,
		rou.MonId,
		
		rou.RouImporte,
		rou.RouTipoCambio,
		rou.RouTransaccion,
		
		rou.RouDireccion,
		rou.RouTelefono,
		rou.RouCelular,
		
		rou.RouOrdenanteNombre,
		rou.RouOrdenanteNumeroDocumento,
		rou.RouOrdenanteDireccion,
		
		rou.RouTramitanteNombre,
		rou.RouTramitanteNumeroDocumento,
		rou.RouTramitanteDireccion,
	
		rou.RouOrigenFondo,
		rou.RouObservacionInterna,
		rou.RouObservacionImpresa,
		
		rou.RouEstado,	
		DATE_FORMAT(rou.RouTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRouTiempoCreacion",
        DATE_FORMAT(rou.RouTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRouTiempoModificacion",
		
			per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
					
					
					
					
					cli.CliNombre,
					cli.CliNumeroDocumento,
					
					cli.CliApellidoPaterno,
					cli.CliApellidoMaterno,
					cli.CliDireccion,
					cli.CliDistrito,
					cli.CliDepartamento,
					cli.CliProvincia,
					
					cli.TdoId,
					cli.CliTelefono,
					cli.CliCelular,
					
					cli.CliPais,
					
					mon.MonNombre,
					mon.MonSimbolo
					
					
					
        FROM tblrouregistrooperacionuif rou
		
					LEFT JOIN tblperpersonal per
					ON rou.PerId = per.PerId
						LEFT JOIN tblclicliente cli
						ON rou.CliId = cli.CliId
							LEFT JOIN tblmonmoneda mon
							ON rou.MonId = mon.MonId
							
							
        WHERE RouId = "' . $this->RouId . '";';


		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$this->RouId = $fila['RouId'];
				$this->RouFecha = $fila['NRouFecha'];
				$this->RouHora = $fila['NRouHora'];
				$this->PerId = $fila['PerId'];

				$this->CliId = $fila['CliId'];
				$this->RouCodigoEmpresa = $fila['RouCodigoEmpresa'];
				$this->RouCodigoOficialCumplimiento = $fila['RouCodigoOficialCumplimiento'];
				$this->MonId = $fila['MonId'];

				$this->RouImporte = $fila['RouImporte'];
				$this->RouTipoCambio = $fila['RouTipoCambio'];
				$this->RouTransaccion = $fila['RouTransaccion'];

				$this->RouDireccion = $fila['RouDireccion'];
				$this->RouTelefono = $fila['RouTelefono'];
				$this->RouCelular = $fila['RouCelular'];

				$this->RouOrdenanteNombre = $fila['RouOrdenanteNombre'];
				$this->RouOrdenanteNumeroDocumento = $fila['RouOrdenanteNumeroDocumento'];
				$this->RouOrdenanteDireccion = $fila['RouOrdenanteDireccion'];

				$this->RouTramitanteNombre = $fila['RouOrdenanteNombre'];
				$this->RouTramitanteNumeroDocumento = $fila['RouOrdenanteNumeroDocumento'];
				$this->RouTramitanteDireccion = $fila['RouOrdenanteDireccion'];

				$this->RouOrigenFondo = $fila['RouOrigenFondo'];

				$this->RouObservacionInterna = $fila['RouObservacionInterna'];
				$this->RouObservacionImpresa = $fila['RouObservacionImpresa'];

				$this->RouEstado = $fila['RouEstado'];
				$this->RouTiempoCreacion = $fila['NRouTiempoCreacion'];
				$this->RouTiempoModificacion = $fila['NRouTiempoModificacion'];


				$this->PerNombre = $fila['PerNombre'];
				$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
				$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];

				$this->CliNombre = $fila['CliNombre'];
				$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];

				$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
				$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
				$this->CliDireccion = $fila['CliDireccion'];
				$this->CliDistrito = $fila['CliDistrito'];
				$this->CliDepartamento = $fila['CliDepartamento'];
				$this->CliProvincia = $fila['CliProvincia'];

				$this->TdoId = $fila['TdoId'];
				$this->CliTelefono = $fila['CliTelefono'];
				$this->CliCelular = $fila['CliCelular'];





				$this->CliPais = $fila['CliPais'];


				$this->MonNombre = $fila['MonNombre'];
				$this->MonSimbolo = $fila['MonSimbolo'];
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerRegistroOperacionUIFs($oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'RouId', $oSentido = 'Desc', $oPaginacion = '0,10', $oEstado = NULL, $oFechaInicio = NULL, $oFechaFin = NULL, $oMoneda = NULL)
	{

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$estado = '';
		$fecha = '';
		$moneda = '';
		$tipo = '';

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

			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oEstado)) {
			$estado = ' AND rou.RouEstado = ' . $oEstado;
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(rou.RouFecha)>="' . $oFechaInicio . '" AND DATE(rou.RouFecha)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(rou.RouFecha)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFcc)) {
				$fecha = ' AND DATE(rou.RouFecha)<="' . $oFechaFin . '"';
			}
		}


		if (!empty($oMoneda)) {
			$moneda = ' AND rou.MonId = "' . $oMoneda . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				rou.RouId,
				DATE_FORMAT(rou.RouFecha, "%d/%m/%Y") AS "NRouFecha",
				DATE_FORMAT(rou.RouHora, "%H:%i") AS "NRouHora",
		
				rou.PerId,
				
				rou.CliId,
				rou.RouCodigoEmpresa,
				rou.RouCodigoOficialCumplimiento,
				rou.MonId,
		
				rou.RouImporte,
				rou.RouTipoCambio,
				rou.RouTransaccion,
			
				rou.RouDireccion,
				rou.RouTelefono,
				rou.RouCelular,
				
				rou.RouOrdenanteNombre,
				rou.RouOrdenanteNumeroDocumento,
				rou.RouOrdenanteDireccion,
				
				rou.RouTramitanteNombre,
				rou.RouTramitanteNumeroDocumento,
				rou.RouTramitanteDireccion,
			
				rou.RouOrigenFondo,
				rou.RouObservacionInterna,
				rou.RouObservacionImpresa,
				
				rou.RouEstado,
				DATE_FORMAT(rou.RouTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRouTiempoCreacion",
                DATE_FORMAT(rou.RouTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRouTiempoModificacion",
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
					
					cli.CliNombre,
					cli.CliNumeroDocumento,
					
					cli.CliApellidoPaterno,
					cli.CliApellidoMaterno,
					cli.CliDireccion,
					cli.CliDistrito,
					cli.CliDepartamento,
					cli.CliProvincia,
					
						cli.TdoId,
					cli.CliTelefono,
					cli.CliCelular,
					
					cli.CliPais,
					
					mon.MonNombre,
					mon.MonSimbolo
					
				FROM tblrouregistrooperacionuif rou
					LEFT JOIN tblperpersonal per
					ON rou.PerId = per.PerId
						LEFT JOIN tblclicliente cli
						ON rou.CliId = cli.CliId
							LEFT JOIN tblmonmoneda mon
							ON rou.MonId = mon.MonId
							
				WHERE 1 = 1 ' . $filtrar . $moneda . $tipo . $estado . $fecha . $orden . $paginacion;



		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsRegistroOperacionUIF = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$RegistroOperacionUIF = new $InsRegistroOperacionUIF();

			$RegistroOperacionUIF->RouId = $fila['RouId'];
			$RegistroOperacionUIF->RouFecha = $fila['NRouFecha'];
			$RegistroOperacionUIF->RouHora = $fila['NRouHora'];
			$RegistroOperacionUIF->PerId = $fila['PerId'];

			$RegistroOperacionUIF->CliId = $fila['CliId'];
			$RegistroOperacionUIF->RouCodigoEmpresa = $fila['RouCodigoEmpresa'];
			$RegistroOperacionUIF->RouCodigoOficialCumplimiento = $fila['RouCodigoOficialCumplimiento'];
			$RegistroOperacionUIF->MonId = $fila['MonId'];

			$RegistroOperacionUIF->RouImporte = $fila['RouImporte'];
			$RegistroOperacionUIF->RouTipoCambio = $fila['RouTipoCambio'];
			$RegistroOperacionUIF->RouTransaccion = $fila['RouTransaccion'];


			$RegistroOperacionUIF->RouDireccion = $fila['RouDireccion'];
			$RegistroOperacionUIF->RouTelefono = $fila['RouTelefono'];
			$RegistroOperacionUIF->RouCelular = $fila['RouCelular'];

			$RegistroOperacionUIF->RouOrdenanteNombre = $fila['RouOrdenanteNombre'];
			$RegistroOperacionUIF->RouOrdenanteNumeroDocumento = $fila['RouOrdenanteNumeroDocumento'];
			$RegistroOperacionUIF->RouOrdenanteDireccion = $fila['RouOrdenanteDireccion'];

			$RegistroOperacionUIF->RouTramitanteNombre = $fila['RouTramitanteNombre'];
			$RegistroOperacionUIF->RouTramitanteNumeroDocumento = $fila['RouTramitanteNumeroDocumento'];
			$RegistroOperacionUIF->RouTramitanteDireccion = $fila['RouTramitanteDireccion'];



			$RegistroOperacionUIF->RouOrigenFondo = $fila['RouOrigenFondo'];
			$RegistroOperacionUIF->RouObservacionInterna = $fila['RouObservacionInterna'];
			$RegistroOperacionUIF->RouObservacionImpresa = $fila['RouObservacionImpresa'];

			$RegistroOperacionUIF->RouEstado = $fila['RouEstado'];
			$RegistroOperacionUIF->RouTiempoCreacion = $fila['NRouTiempoCreacion'];
			$RegistroOperacionUIF->RouTiempoModificacion = $fila['NRouTiempoModificacion'];

			$RegistroOperacionUIF->PerNombre = $fila['PerNombre'];
			$RegistroOperacionUIF->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$RegistroOperacionUIF->PerApellidoMaterno = $fila['PerApellidoMaterno'];

			$RegistroOperacionUIF->CliNombre = $fila['CliNombre'];
			$RegistroOperacionUIF->CliNumeroDocumento = $fila['CliNumeroDocumento'];

			$RegistroOperacionUIF->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$RegistroOperacionUIF->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$RegistroOperacionUIF->CliDireccion = $fila['CliDireccion'];
			$RegistroOperacionUIF->CliDistrito = $fila['CliDistrito'];
			$RegistroOperacionUIF->CliDepartamento = $fila['CliDepartamento'];
			$RegistroOperacionUIF->CliProvincia = $fila['CliProvincia'];

			$RegistroOperacionUIF->TdoId = $fila['TdoId'];
			$RegistroOperacionUIF->CliTelefono = $fila['CliTelefono'];
			$RegistroOperacionUIF->CliCelular = $fila['CliCelular'];


			$RegistroOperacionUIF->CliPais = $fila['CliPais'];


			$RegistroOperacionUIF->MonNombre = $fila['MonNombre'];
			$RegistroOperacionUIF->MonSimbolo = $fila['MonSimbolo'];

			$RegistroOperacionUIF->InsMysql = NULL;
			$Respuesta['Datos'][] = $RegistroOperacionUIF;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}


	//Accion eliminar	 

	public function MtdEliminarRegistroOperacionUIF($oElementos)
	{

		// Inicializar variable para evitar warnings
		$eliminar = '';

		$elementos = explode("#", $oElementos);
		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				if ($i == count($elementos)) {
					$eliminar .= '  (RouId = "' . ($elemento) . '")';
				} else {
					$eliminar .= '  (RouId = "' . ($elemento) . '")  OR';
				}
			}
			$i++;
		}

		$sql = 'DELETE FROM  tblrouregistrooperacionuif WHERE ' . $eliminar;

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, true);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			return false;
		} else {
			return true;
		}
	}


	public function MtdRegistrarRegistroOperacionUIF()
	{

		$this->MtdGenerarRegistroOperacionUIFId();

		$sql = 'INSERT INTO tblrouregistrooperacionuif (
			RouId,
			RouFecha,
			RouHora,
			PerId,
			
			CliId,
			RouCodigoEmpresa,
			RouCodigoOficialCumplimiento,
			MonId,
		
			RouImporte,
			RouTipoCambio,
			RouTransaccion,
			
			RouDireccion,
			RouTelefono,
			RouCelular,
			
			RouOrdenanteNombre,
			RouOrdenanteNumeroDocumento,
			RouOrdenanteDireccion,
			
			RouTramitanteNombre,
			RouTramitanteNumeroDocumento,
			RouTramitanteDireccion,
			
			RouObservacionInterna,
			RouObservacionImpresa,
			RouOrigenFondo,
			RouEstado,
			RouTiempoCreacion,
			RouTiempoModificacion
			) 
			VALUES (
			"' . ($this->RouId) . '", 
			"' . ($this->RouFecha) . '",
			"' . ($this->RouHora) . '",
			
			"' . ($this->PerId) . '",
			
			"' . ($this->CliId) . '", 
			"' . ($this->RouCodigoEmpresa) . '", 
			"' . ($this->RouCodigoOficialCumplimiento) . '", 
			"' . ($this->MonId) . '", 
			
			' . ($this->RouImporte) . ', 
			' . ($this->RouTipoCambio) . ', 
			"' . ($this->RouTransaccion) . '", 
			
			"' . ($this->RouDireccion) . '", 
			"' . ($this->RouTelefono) . '", 
			"' . ($this->RouCelular) . '", 
			
			"' . ($this->RouOrdenanteNombre) . '", 
			"' . ($this->RouOrdenanteNumeroDocumento) . '", 
			"' . ($this->RouOrdenanteDireccion) . '", 
			
			"' . ($this->RouTramitanteNombre) . '", 
			"' . ($this->RouTramitanteNumeroDocumento) . '", 
			"' . ($this->RouTramitanteDireccion) . '", 
			
			"' . ($this->RouObservacionInterna) . '", 
			"' . ($this->RouObservacionImpresa) . '", 
			"' . ($this->RouOrigenFondo) . '", 
			' . ($this->RouEstado) . ', 
			"' . ($this->RouTiempoCreacion) . '", 
			"' . ($this->RouTiempoModificacion) . '");';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, true);


		if (!$resultado) {
			$error = true;
		}


		if ($error) {
			return false;
		} else {
			return true;
		}
	}



	public function MtdEditarRegistroOperacionUIF()
	{


		$sql = 'UPDATE tblrouregistrooperacionuif SET 
			RouFecha = "' . ($this->RouFecha) . '",
			RouHora = "' . ($this->RouHora) . '",
			PerId = "' . ($this->PerId) . '",
			
			CliId = "' . ($this->CliId) . '",
			RouCodigoEmpresa = "' . ($this->RouCodigoEmpresa) . '",
			RouCodigoOficialCumplimiento = "' . ($this->RouCodigoOficialCumplimiento) . '",
			MonId = "' . ($this->MonId) . '",
			
			RouImporte = ' . ($this->RouImporte) . ',
			RouTipoCambio = ' . ($this->RouTipoCambio) . ',
			RouTransaccion = "' . ($this->RouTransaccion) . '",
			
			RouDireccion = "' . ($this->RouDireccion) . '",
			RouTelefono = "' . ($this->RouTelefono) . '",
			RouCelular = "' . ($this->RouCelular) . '",
			
			RouOrdenanteNombre = "' . ($this->RouOrdenanteNombre) . '",
			RouOrdenanteNumeroDocumento = "' . ($this->RouOrdenanteNumeroDocumento) . '",
			RouOrdenanteDireccion = "' . ($this->RouOrdenanteDireccion) . '",
			
			RouTramitanteNombre = "' . ($this->RouTramitanteNombre) . '",
			RouTramitanteNumeroDocumento = "' . ($this->RouTramitanteNumeroDocumento) . '",
			RouTramitanteDireccion = "' . ($this->RouTramitanteDireccion) . '",
			
			RouObservacionInterna = "' . ($this->RouObservacionInterna) . '",
			RouObservacionImpresa = "' . ($this->RouObservacionImpresa) . '",
			  
			 RouOrigenFondo = "' . ($this->RouOrigenFondo) . '",
			 RouEstado = ' . ($this->RouEstado) . ',
			 RouTiempoModificacion = "' . ($this->RouTiempoModificacion) . '"
			 WHERE RouId = "' . ($this->RouId) . '";';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, true);

		if (!$resultado) {
			$error = true;
		}





		if ($error) {
			return false;
		} else {
			return true;
		}
	}
}
