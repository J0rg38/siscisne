<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAuditoria
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAuditoria
{

	public $AudId;
	public $SucId;
	public $UsuId;
	public $AudCodigo;
	public $AudCodigoExtra;
	public $AudAccion;
	public $AudDescripcion;
	public $AudDatos;
	public $AudTiempoCreacion;

	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;


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


	/*
	1 - Registrar
	2 - Editar
	3 - Eliminar
	*/

	public function MtdGenerarAuditoriaId($oTablaTipo)
	{


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(AudId,5),unsigned)) AS "MAXIMO"
		FROM tblaudauditoria' . $oTablaTipo;

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->AudId = "AUD-10000";
		} else {
			$fila['MAXIMO']++;
			$this->AudId = "AUD-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerAuditorias($oTablaTipo = NULL, $oCampo = NULL, $oFiltro = NULL, $oOrden = 'ZonId', $oSentido = 'Desc', $oPaginacion = '0,10', $oCodigo = NULL)
	{

		// Initialize variables with default values to avoid undefined variable warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fecha = '';
		$codigo = '';
		$cextra = '';

		if (!empty($oCampo) && !empty($oFiltro)) {
			$oFiltro = str_replace(" ", "%", $oFiltro);
			$filtrar = ' WHERE ' . ($oCampo) . ' LIKE "%' . ($oFiltro) . '%"';
		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oFecha)) {
			$fecha = ' AND DATE(aud.AudTiempoCreacion)="' . $oFecha . '"';
		}

		if (!empty($oCodigo)) {
			$codigo = ' AND aud.AudCodigo = "' . $oCodigo . '"';
		}


		$sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			aud.AudId,

			aud.UsuId,
			aud.AudCodigo,

			aud.AudAccion,
			aud.AudDescripcion,
			aud.AudDatos,
			DATE_FORMAT(aud.AudTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAudTiempoCreacion",
			usu.UsuUsuario,
			per.PerNombre,
			per.PerApellidoPaterno,
			per.PerApellidoMaterno
			
			FROM tblaudauditoria' . $oTablaTipo . ' aud
				LEFT JOIN tblusuusuario usu
				ON aud.UsuId = usu.UsuId
					LEFT JOIN tblperpersonal per
					ON per.UsuId = usu.UsuId WHERE 1 = 1 ' . $filtrar . $codigo . $cextra . $fecha . $orden . $paginacion;


		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsAuditoria = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$Auditoria = new $InsAuditoria();
			$Auditoria->AudId = $fila['AudId'];

			$Auditoria->UsuId = $fila['UsuId'];
			$Auditoria->AudCodigo = $fila['AudCodigo'];

			$Auditoria->AudAccion = $fila['AudAccion'];

			switch ($Auditoria->AudAccion) {
				case 1:
					$Auditoria->AudAccionDescripcion = "Registro";
					break;

				case 2:
					$Auditoria->AudAccionDescripcion = "Edicion";
					break;

				case 3:
					$Auditoria->AudAccionDescripcion = "Eliminacion";
					break;
			}

			$Auditoria->AudDescripcion = $fila['AudDescripcion'];
			$Auditoria->AudDatos = $fila['AudDatos'];
			$Auditoria->AudTiempoCreacion = $fila['NAudTiempoCreacion'];

			$Auditoria->UsuUsuario = $fila['UsuUsuario'];
			$Auditoria->PerNombre = $fila['PerNombre'];
			$Auditoria->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$Auditoria->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			//$Auditoria->InsMysql = NULL;                    
			$Respuesta['Datos'][] = $Auditoria;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}

	public function MtdAuditoriaRegistrar($oTablaTipo = NULL)
	{


		/*
		$json = new JSON;
		$var = $json->serialize($this->AudDatos);
		$json->unserialize($var);
		$this->AudDatos = $var;*/

		$this->AudDatos = json_encode($this->AudDatos);

		$this->MtdGenerarAuditoriaId($oTablaTipo);

		$sql = 'INSERT INTO tblaudauditoria' . $oTablaTipo . ' (


		UsuId,
		AudCodigo,

		AudIp ,

		AudAccion,
		AudDescripcion,
		AudDatos,
		AudTiempoCreacion
		) 
		VALUES (


		"' . ($this->UsuId) . '", 
		"' . ($this->AudCodigo) . '", 

		"' . FncObtenerIp() . '", 

		' . ($this->AudAccion) . ', 
		"' . ($this->AudDescripcion) . '", 
		"' . addslashes($this->AudDatos) . '", 
		"' . ($this->AudTiempoCreacion) . '");';


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
}
