<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsRol
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsRol
{

	public $RolId;
	public $RolNombre;
	public $RolTiempoCreacion;
	public $RolTiempoModificacion;

	public $RolZonaPrivilegio;

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

	public function MtdGenerarRolId()
	{


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(RolId,5),unsigned)) AS "MAXIMO"
		FROM tblrolrol';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->RolId = "ROL-10000";
		} else {
			$fila['MAXIMO']++;
			$this->RolId = "ROL-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerRol()
	{


		$sql = 'SELECT 
        RolId,
        RolNombre,	
		DATE_FORMAT(RolTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRolTiempoCreacion",
        DATE_FORMAT(RolTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRolTiempoModificacion"
        FROM tblrolrol
        WHERE RolId = "' . $this->RolId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$InsRolZonaPrivilegio = new ClsRolZonaPrivilegio();
				$ResRolZonaPrivilegio = $InsRolZonaPrivilegio->MtdObtenerRolZonaPrivilegios(NULL, NULL, "RzpId", "ASC", NULL, $fila['RolId']);


				$this->RolId = $fila['RolId'];
				$this->RolNombre = $fila['RolNombre'];
				$this->RolTiempoCreacion = $fila['NRolTiempoCreacion'];
				$this->RolTiempoModificacion = $fila['NRolTiempoModificacion'];

				$this->RolZonaPrivilegio = $ResRolZonaPrivilegio['Datos'];
			}

			$Respuesta = $this;
		} else {
			$Respuesta = NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerRoles($oCampo = NULL, $oFiltro = NULL, $oOrden = 'RolId', $oSentido = 'Desc', $oPaginacion = '0,10')
	{


		// Initialize variables with default values to avoid undefined variable warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';

		if (!empty($oCampo) && !empty($oFiltro)) {
			$oFiltro = str_replace(" ", "%", $oFiltro);
			$filtrar = ' AND ' . ($oCampo) . ' LIKE "%' . ($oFiltro) . '%"';
		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		$sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			RolId,
			RolNombre,
			DATE_FORMAT(RolTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRolTiempoCreacion",
	        DATE_FORMAT(RolTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRolTiempoModificacion"						
			FROM tblrolrol WHERE 1 = 1 ' . $filtrar . $orden . $paginacion;


		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsRol = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$Rol = new $InsRol();
			$Rol->RolId = $fila['RolId'];
			$Rol->RolNombre = $fila['RolNombre'];
			$Rol->RolTiempoCreacion = $fila['NRolTiempoCreacion'];
			$Rol->RolTiempoModificacion = $fila['NRolTiempoModificacion'];

			$Rol->InsMysql = NULL;
			$Respuesta['Datos'][] = $Rol;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}


	//Accion eliminar	 

	public function MtdEliminarRol($oElementos)
	{


		$elementos = explode("#", $oElementos);
		$eliminar = ''; // Initialize variable to avoid undefined variable warning

		if (!count($elementos)) {
			$eliminar .= ' RolId = "' . ($oElementos) . '"';
		} else {
			$i = 1;
			foreach ($elementos as $elemento) {
				if (!empty($elemento)) {

					if ($i == count($elementos)) {
						$eliminar .= '  (RolId = "' . ($elemento) . '")';
					} else {
						$eliminar .= '  (RolId = "' . ($elemento) . '")  OR';
					}
				}
				$i++;
			}
		}

		$sql = 'DELETE FROM tblrolrol WHERE ' . $eliminar;

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


	public function MtdRegistrarRol()
	{


		$this->MtdGenerarRolId();

		$sql = 'INSERT INTO tblrolrol (
			RolId,
			RolNombre,
			RolTiempoCreacion,
			RolTiempoModificacion) 
			VALUES (
			"' . ($this->RolId) . '", 	
			"' . ($this->RolNombre) . '", 	
			"' . ($this->RolTiempoCreacion) . '",
			"' . ($this->RolTiempoModificacion) . '");';

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {

			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}
	}

	public function MtdEditarRol()
	{


		$InsRolZonaPrivilegio = new ClsRolZonaPrivilegio();

		$ResRolZonaPrivilegio = $InsRolZonaPrivilegio->MtdObtenerRolZonaPrivilegios(NULL, NULL, $oOrden = 'RzpId', $oSentido = 'ASC', NULL, $this->RolId);




		$sql = 'UPDATE tblrolrol SET 
			 RolNombre = "' . ($this->RolNombre) . '",
			 RolTiempoModificacion = "' . ($this->RolTiempoModificacion) . '"
			 WHERE RolId = "' . ($this->RolId) . '";';

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}


		if (!$error) {
			if (!empty($ResRolZonaPrivilegio['Ids'])) {
				if (!$InsRolZonaPrivilegio->MtdEliminarRolZonaPrivilegio($ResRolZonaPrivilegio['Ids'])) {
					$error = true;
				}
			}
		}

		if (!$error) {
			if (!empty($this->RolZonaPrivilegio)) {

				$validar = 0;
				$InsRolZonaPrivilegio = new ClsRolZonaPrivilegio();

				foreach ($this->RolZonaPrivilegio as $DatRolZonaPrivilegio) {

					$InsRolZonaPrivilegio->RolId = $this->RolId;
					$InsRolZonaPrivilegio->ZprId = $DatRolZonaPrivilegio->ZprId;

					if ($InsRolZonaPrivilegio->MtdRegistrarRolZonaPrivilegio()) {
						$validar++;
					}
				}

				if (count($this->RolZonaPrivilegio) <> $validar) {
					$error = true;
				}
			}
		}


		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			return true;
		}
	}
}
