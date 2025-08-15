<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsZonaPrivilegio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsZonaPrivilegio
{

	public $ZprId;
	public $ZonId;
	public $PriId;


	public $ZonNombre;
	public $ZonAlias;

	public $PriNombre;
	public $PriAlias;

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

	private function MtdGenerarZonaPrivilegioId()
	{


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ZprId,5),unsigned)) AS "MAXIMO"
		FROM tblzprzonaprivilegio';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->ZprId = "ZPR-10000";
		} else {
			$fila['MAXIMO']++;
			$this->ZprId = "ZPR-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerZonaPrivilegio()
	{


		$sql = 'SELECT 
        ZprId,
		ZonId,
		PriId
        FROM tblzprzonaprivilegio
        WHERE ZprId = "' . $this->ZprId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$this->ZprId = $fila['ZprId'];
			$this->ZonId = $fila['ZonId'];
			$this->PriId = $fila['PriId'];
		}

		return $this;
	}

	public function MtdObtenerZonaPrivilegios($oCampo = NULL, $oFiltro = NULL, $oOrden = 'ZprId', $oSentido = 'Desc', $oPaginacion = '0,10', $oZona = NULL)
	{


		// Initialize variables with default values to avoid undefined variable warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$zona = '';

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

		if (!empty($oZona)) {
			$zona = 'AND  zpr.ZonId = "' . $oZona . '"';
		}

		$sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			zpr.ZprId,
			zpr.ZonId,
			zpr.PriId,
			zon.ZonNombre,
			zon.ZonAlias,
			pri.PriNombre,
			pri.PriAlias
			FROM tblzprzonaprivilegio zpr
			LEFT JOIN tblzonzona zon
			ON zpr.ZonId = zon.ZonId
			LEFT JOIN tblpriprivilegio pri
			ON zpr.PriId = pri.PriId
			WHERE 1 = 1 ' . $filtrar . $zona . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsZonaPrivilegio = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$ZonaPrivilegio = new $InsZonaPrivilegio();
			$ZonaPrivilegio->ZprId = $fila['ZprId'];
			$ZonaPrivilegio->ZonId = $fila['ZonId'];
			$ZonaPrivilegio->PriId = $fila['PriId'];
			$ZonaPrivilegio->ZonNombre = $fila['ZonNombre'];
			$ZonaPrivilegio->ZonAlias = $fila['ZonAlias'];
			$ZonaPrivilegio->PriNombre = $fila['PriNombre'];
			$ZonaPrivilegio->PriAlias = $fila['PriAlias'];

			$ZonaPrivilegio->InsMysql = NULL;
			$Respuesta['Datos'][] = $ZonaPrivilegio;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}


	//Accion eliminar	 

	public function MtdEliminarZonaPrivilegio($oElementos)
	{


		$elementos = explode("#", $oElementos);
		$eliminar = ''; // Initialize variable to avoid undefined variable warning

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				if ($i == count($elementos)) {
					$eliminar .= '  (ZprId = "' . ($elemento) . '")';
				} else {
					$eliminar .= '  (ZprId = "' . ($elemento) . '")  OR';
				}
			}
			$i++;
		}

		$sql = 'DELETE from tblzprzonaprivilegio WHERE ' . $eliminar;

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


	public function MtdRegistrarZonaPrivilegio()
	{


		$this->MtdGenerarZonaPrivilegioId();

		$sql = 'INSERT INTO tblzprzonaprivilegio (
			ZprId,			
			ZonId,
			PriId) 
			VALUES (
			"' . ($this->ZprId) . '", 
			"' . ($this->ZonId) . '", 			
			"' . ($this->PriId) . '");';

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

	//	public function MtdEditarZonaPrivilegio() {
	//
	//			$sql = 'UPDATE tblzprzonaprivilegio SET 			
	//			 PriId = "'.($this->PriId).'"			
	//			 WHERE ZprId = "'.($this->ZprId).'"';
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


}
?>