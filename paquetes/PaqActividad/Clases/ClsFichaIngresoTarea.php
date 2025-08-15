<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoTarea
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoTarea
{

	public $FitId;
	public $FimId;
	public $FitDescripcion;
	public $FitAccion;
	public $FitEstado;
	public $FitTiempoCreacion;
	public $FitTiempoModificacion;
	public $FitEliminado;

	public $MinSigla;

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

	private function MtdGenerarFichaIngresoTareaId()
	{

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FitId,5),unsigned)) AS "MAXIMO"
			FROM tblfitfichaingresotarea';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->FitId = "FIT-10000";
		} else {
			$fila['MAXIMO']++;
			$this->FitId = "FIT-" . $fila['MAXIMO'];
		}
	}


	public function MtdObtenerFichaIngresoTareas($oCampo = NULL, $oFiltro = NULL, $oOrden = 'FitId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFichaIngresoModalidad = NULL, $oEstado = NULL)
	{
		// Inicializar variables para evitar warnings
		$fimodalidad = '';
		$estado = '';
		$filtrar = '';
		$orden = '';
		$paginacion = '';

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

		if (!empty($oFichaIngresoModalidad)) {
			$fimodalidad = ' AND fit.FimId = "' . $oFichaIngresoModalidad . '"';
		}

		if (!empty($oEstado)) {
			$estado = ' AND fit.FitEstado = ' . $oEstado . ' ';
		}


		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fit.FitId,			
			fit.FimId,
			fit.FitDescripcion,
			fit.FitAccion,
			fit.FitEstado,
			DATE_FORMAT(fit.FitTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFitTiempoCreacion",
	        DATE_FORMAT(fit.FitTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFitTiempoModificacion",
			min.MinSigla,
			fat.FatVerificar1
			
			FROM tblfitfichaingresotarea fit
				LEFT JOIN tblfimfichaingresomodalidad fim
				ON fit.FimId = fim.FimId
					LEFT JOIN tblminmodalidadingreso min
					ON fim.MinId = min.MinId
						LEFT JOIN tblfatfichaacciontarea fat
						ON fat.FitId = fit.FitId
			WHERE  1 = 1 ' . $fimodalidad . $estado . $filtrar . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsFichaIngresoTarea = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$FichaIngresoTarea = new $InsFichaIngresoTarea();
			$FichaIngresoTarea->FitId = $fila['FitId'];
			$FichaIngresoTarea->FimId = $fila['FimId'];
			$FichaIngresoTarea->FitDescripcion = $fila['FitDescripcion'];
			$FichaIngresoTarea->FitAccion = $fila['FitAccion'];
			$FichaIngresoTarea->FitEstado = $fila['FitEstado'];
			$FichaIngresoTarea->FitTiempoCreacion = $fila['NFitTiempoCreacion'];
			$FichaIngresoTarea->FitTiempoModificacion = $fila['NFitTiempoModificacion'];

			$FichaIngresoTarea->MinSigla = $fila['MinSigla'];

			$FichaIngresoTarea->FatVerificar1 = $fila['FatVerificar1'];

			$FichaIngresoTarea->InsMysql = NULL;
			$Respuesta['Datos'][] = $FichaIngresoTarea;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}




	//Accion eliminar	 

	public function MtdEliminarFichaIngresoTarea($oElementos)
	{

		$error = false;

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {
				if ($i == count($elementos)) {
					$eliminar .= '  (FitId = "' . ($elemento) . '")';
				} else {
					$eliminar .= '  (FitId = "' . ($elemento) . '")  OR';
				}
			}
			$i++;
		}


		$sql = 'DELETE FROM tblfitfichaingresotarea 
				WHERE ' . $eliminar;

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


	public function MtdRegistrarFichaIngresoTarea()
	{

		$this->MtdGenerarFichaIngresoTareaId();

		$sql = 'INSERT INTO tblfitfichaingresotarea (
			FitId,
			FimId,	
			FitDescripcion,
			FitAccion,
			FitEstado,
			FitTiempoCreacion,
			FitTiempoModificacion
			) 
			VALUES (
			"' . ($this->FitId) . '", 
			"' . ($this->FimId) . '", 
			"' . ($this->FitDescripcion) . '", 
			"' . ($this->FitAccion) . '",
			' . ($this->FitEstado) . ',
			"' . ($this->FitTiempoCreacion) . '",
			"' . ($this->FitTiempoModificacion) . '");';

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

	public function MtdEditarFichaIngresoTarea()
	{

		$sql = 'UPDATE tblfitfichaingresotarea SET 	
		 FitDescripcion = "' . ($this->FitDescripcion) . '",
		 FitAccion = "' . ($this->FitAccion) . '"
		 WHERE FitId = "' . ($this->FitId) . '";';

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
