<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsZona
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsZona
{

	public $ZonId;
	public $ZonNombre;
	public $ZonAlias;
	public $ZonGrupo;
	public $ZcaId;
	public $ZcaNombre;
	public $ZonaPrivilegio;
	public $ZprEliminado;

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

	private function MtdGenerarZonaId()
	{


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ZonId,5),unsigned)) AS "MAXIMO"
		FROM tblzonzona';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->ZonId = "ZON-10000";
		} else {
			$fila['MAXIMO']++;
			$this->ZonId = "ZON-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerZona()
	{


		$sql = 'SELECT 
        ZonId,
		ZonNombre,
		ZonAlias
        FROM tblzonzona
        WHERE ZonId = "' . $this->ZonId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

				$InsZonaPrivilegio = new ClsZonaPrivilegio();
				$ResZonaPrivilegio = $InsZonaPrivilegio->MtdObtenerZonaPrivilegios(NULL, NULL, "ZprId", "ASC", NULL, $fila['ZonId']);

				$this->ZonId = $fila['ZonId'];
				$this->ZonNombre = $fila['ZonNombre'];
				$this->ZonAlias = $fila['ZonAlias'];
				$this->ZonaPrivilegio = $ResZonaPrivilegio['Datos'];
			}

			$Respuesta = $this;
		} else {
			$Respuesta = NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerZonas($oCampo = NULL, $oFiltro = NULL, $oOrden = 'ZonId', $oSentido = 'Desc', $oPaginacion = '0,10', $oZonaCategoria = NULL)
	{


		// Initialize variables with default values to avoid undefined variable warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$zcategoria = '';

		if (!empty($oCampo) && !empty($oFiltro)) {
			$oFiltro = str_replace(" ", "%", $oFiltro);
			$filtrar = ' AND ' . ($oCampo) . ' LIKE "%' . ($oFiltro) . '%"';
		}

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ZonGrupo ASC, ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oZonaCategoria)) {
			$zcategoria = ' AND ZcaId = "' . ($oZonaCategoria) . '" ';
		}

		$sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			zon.ZonId,
			zon.ZonNombre,
			zon.ZonAlias,
			zon.ZonGrupo,
			zon.ZcaId,
			zca.ZcaNombre
			FROM tblzonzona zon
			LEFT JOIN tblzcazonacategoria zca
			ON zon.ZcaId = zca.ZcaId
			WHERE 1 = 1 ' . $filtrar . $zcategoria . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsZona = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$Zona = new $InsZona();
			$Zona->ZonId = $fila['ZonId'];
			$Zona->ZonNombre = $fila['ZonNombre'];
			$Zona->ZonAlias = $fila['ZonAlias'];
			$Zona->ZonGrupo = $fila['ZonGrupo'];
			$Zona->ZcaId = $fila['ZcaId'];
			$Zona->ZcaNombre = $fila['ZcaNombre'];

			$Zona->InsMysql = NULL;
			$Respuesta['Datos'][] = $Zona;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}

	public function MtdRegistrarZona()
	{


		$this->MtdGenerarZonaId();
		$Resultado = ''; // Initialize variable to avoid undefined variable warning

		$sql = 'INSERT INTO tblzonzona (
			ZonId,
			ZonNombre,
			ZonAlias,
			ZonGrupo,
			ZcaId) 
			VALUES (
			"' . ($this->ZonId) . '", 
			"' . ($this->ZonNombre) . '", 			
			"' . ($this->ZonAlias) . '",
			"' . ($this->ZonGrupo) . '",
			"' . ($this->ZcaId) . '");';

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if (!$error) {

			if (!empty($this->ZonaPrivilegio)) {

				$validar = 0;
				$InsZonaPrivilegio = new ClsZonaPrivilegio($this->InsMysql);

				foreach ($this->ZonaPrivilegio as $DatZonaPrivilegio) {

					$InsZonaPrivilegio->ZprId = $DatZonaPrivilegio->ZprId;
					$InsZonaPrivilegio->ZonId = $this->ZonId;
					$InsZonaPrivilegio->PriId = $DatZonaPrivilegio->PriId;
					$InsZonaPrivilegio->ZprEliminado = $DatZonaPrivilegio->ZprEliminado;

					if (empty($InsZonaPrivilegio->ZprId)) {
						if ($InsZonaPrivilegio->ZprEliminado <> 2) {
							if ($InsZonaPrivilegio->MtdRegistrarZonaPrivilegio()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_ZON_231';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsZonaPrivilegio->ZprEliminado == 2) {
							if ($InsZonaPrivilegio->MtdEliminarZonaPrivilegio($InsZonaPrivilegio->ZprId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_ZON_233';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							//if($InsZonaPrivilegio->MtdEditarZonaPrivilegio()){
							$validar++;
							//}else{
							//	$Resultado.='#ERR_ZON_232';
							//	$Resultado.='#Item Numero: '.($validar+1);	
							//}
						}
					}
				}

				if (count($this->ZonaPrivilegio) <> $validar) {
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

	public function MtdEditarZona()
	{


		$Resultado = ''; // Initialize variable to avoid undefined variable warning
		$sql = 'UPDATE tblzonzona SET 			
			ZonNombre = "' . ($this->ZonNombre) . '",
			ZonAlias = "' . ($this->ZonAlias) . '"				 		
			WHERE ZonId = "' . ($this->ZonId) . '";';


		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if (!$error) {
			if (!empty($this->ZonaPrivilegio)) {

				$validar = 0;
				$InsZonaPrivilegio = new ClsZonaPrivilegio($this->InsMysql);

				foreach ($this->ZonaPrivilegio as $DatZonaPrivilegio) {

					$InsZonaPrivilegio->ZprId = $DatZonaPrivilegio->ZprId;
					$InsZonaPrivilegio->ZonId = $this->ZonId;
					$InsZonaPrivilegio->PriId = $DatZonaPrivilegio->PriId;
					$InsZonaPrivilegio->ZprEliminado = $DatZonaPrivilegio->ZprEliminado;

					if (empty($InsZonaPrivilegio->ZprId)) {
						if ($InsZonaPrivilegio->ZprEliminado <> 2) {
							if ($InsZonaPrivilegio->MtdRegistrarZonaPrivilegio()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_ZON_231';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsZonaPrivilegio->ZprEliminado == 2) {
							if ($InsZonaPrivilegio->MtdEliminarZonaPrivilegio($InsZonaPrivilegio->ZprId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_ZON_233';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							//if($InsZonaPrivilegio->MtdEditarZonaPrivilegio()){
							$validar++;
							//}else{
							//	$Resultado.='#ERR_ZON_232';
							//	$Resultado.='#Item Numero: '.($validar+1);	
							//}
						}
					}
				}

				if (count($this->ZonaPrivilegio) <> $validar) {
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
