<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSucursal
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsSucursal
{

	public $SucId;
	public $SucNombre;

	public $SucDireccion;
	public $SucDistrito;
	public $SucProvincia;
	public $SucDepartamento;
	public $SucCodigoUbigeo;

	public $SucEstado;
	public $SucTiempoCreacion;
	public $SucTiempoModificacion;
	public $SucEliminado;

	public $InsMysql;

	public function __construct()
	{
		$this->InsMysql = new ClsMysql();
	}

	public function __destruct() {}


	public function MtdGenerarSucursalId()
	{

		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(SucId,5),unsigned)) AS "MAXIMO"
			FROM tblsucsucursal';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->SucId = "SUC-10000";
		} else {
			$fila['MAXIMO']++;
			$this->SucId = "SUC-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerSucursal()
	{

		$sql = 'SELECT 
        suc.SucId,
		suc.SucNombre,
		suc.SucEtiqueta,
		
		suc.SucSiglas,
		
		suc.SucDireccion,
		suc.SucDistrito,
		suc.SucProvincia,
		suc.SucDepartamento,
		suc.SucCodigoUbigeo,
		suc.SucCodigoAnexo,
		
		DATE_FORMAT(suc.SucInventarioFechaInicio, "%d/%m/%Y") AS "NSucInventarioFechaInicio",
		
		suc.SucEstado,
		DATE_FORMAT(suc.SucTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSucTiempoCreacion",
        DATE_FORMAT(suc.SucTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSucTiempoModificacion"
        FROM tblsucsucursal suc
        WHERE suc.SucId = "' . $this->SucId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$this->SucId = $fila['SucId'];
				$this->SucNombre = $fila['SucNombre'];
				$this->SucEtiqueta = $fila['SucEtiqueta'];

				$this->SucSiglas = $fila['SucSiglas'];

				$this->SucDireccion = $fila['SucDireccion'];
				$this->SucDistrito = $fila['SucDistrito'];
				$this->SucProvincia = $fila['SucProvincia'];
				$this->SucDepartamento = $fila['SucDepartamento'];
				$this->SucCodigoUbigeo = $fila['SucCodigoUbigeo'];
				$this->SucCodigoAnexo = $fila['SucCodigoAnexo'];



				$this->SucInventarioFechaInicio = $fila['NSucInventarioFechaInicio'];

				$this->SucEstado = $fila['SucEstado'];
				$this->SucTiempoCreacion = $fila['NSucTiempoCreacion'];
				$this->SucTiempoModificacion = $fila['NSucTiempoModificacion'];
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}

		return $Respuesta;
	}

	public function MtdIdentificarSucursal($oCampo, $oFiltro)
	{

		$SucursalId = "";

		$ResSucursal = $this->MtdObtenerSucursales($oCampo, $oFiltro, 'SucId', 'Desc', '1');
		$ArrSucursales = $ResSucursal['Datos'];

		if (!empty($ArrSucursales)) {
			foreach ($ArrSucursales as $DatSucursal) {

				$SucursalId = $DatSucursal->SucId;
			}
		}

		return $SucursalId;
	}


	public function MtdObtenerSucursales($oCampo = NULL, $oFiltro = NULL, $oOrden = 'SucId', $oSentido = 'Desc', $oPaginacion = '0,10', $oUso = NULL)
	{

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$uso = '';
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


		//	if(!empty($oUso){
		//			$uso = ' AND suc.SucUso = "'.($oUso).'"';
		//		}


		if (!empty($oUso)) {

			$elementos = explode(",", $oUso);

			$i = 1;
			$uso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach ($elementos as $elemento) {
				$uso .= '  (suc.SucUso = "' . ($elemento) . '")';
				if ($i <> count($elementos)) {
					$uso .= ' OR ';
				}
				$i++;
			}

			$uso .= ' ) 
				
			)
			';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				suc.SucId,
				suc.SucNombre,
				suc.SucEtiqueta,
				
				suc.SucSiglas,
				
				suc.SucDireccion,
				suc.SucDistrito,
				suc.SucProvincia,
				suc.SucDepartamento,
				suc.SucCodigoUbigeo,

				suc.SucEstado,
				DATE_FORMAT(suc.SucTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSucTiempoCreacion",
                DATE_FORMAT(suc.SucTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSucTiempoModificacion"
				FROM tblsucsucursal suc
				WHERE 1 = 1' . $filtrar . $uso . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsSucursal = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$Sucursal = new $InsSucursal();
			$Sucursal->SucId = $fila['SucId'];
			$Sucursal->SucNombre = $fila['SucNombre'];
			$Sucursal->SucEtiqueta = $fila['SucEtiqueta'];

			$Sucursal->SucSiglas = $fila['SucSiglas'];

			$Sucursal->SucDireccion = $fila['SucDireccion'];
			$Sucursal->SucDistrito = $fila['SucDistrito'];
			$Sucursal->SucProvincia = $fila['SucProvincia'];
			$Sucursal->SucDepartamento = $fila['SucDepartamento'];
			$Sucursal->SucCodigoUbigeo = $fila['SucCodigoUbigeo'];


			$Sucursal->SucEstado = $fila['SucEstado'];
			$Sucursal->SucTiempoCreacion = $fila['NSucTiempoCreacion'];
			$Sucursal->SucTiempoModificacion = $fila['NSucTiempoModificacion'];

			$Respuesta['Datos'][] = $Sucursal;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);



		return $Respuesta;
	}





	//Accion eliminar	 

	public function MtdEliminarSucursal($oElementos)
	{

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				if ($i == count($elementos)) {
					$eliminar .= '  (SucId = "' . ($elemento) . '")';
				} else {
					$eliminar .= '  (SucId = "' . ($elemento) . '")  OR';
				}
			}
			$i++;
		}

		$sql = 'DELETE FROM tblsucsucursal WHERE ' . $eliminar;

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


	public function MtdRegistrarSucursal()
	{

		$this->MtdGenerarSucursalId();


		$sql = 'INSERT INTO tblsucsucursal (
				SucId,
				SucNombre,
				SucEtiqueta,
				 
				SucSiglas,
				
				SucDireccion,
				
				SucDireccion,
				
				SucDistrito,
				SucProvincia,
				SucDepartamento,
				SucCodigoUbigeo,
				
				SucEstado,
				SucTiempoCreacion,
				SucTiempoModificacion
				) 
				VALUES (
				"' . ($this->SucId) . '", 
				"' . htmlentities($this->SucNombre) . '", 
				"' . ($this->SucEtiqueta) . '", 
				
				"' . ($this->SucSiglas) . '", 
				
				"' . htmlentities($this->SucDireccion) . '", 
				
				"' . htmlentities($this->SucDistrito) . '", 
				"' . htmlentities($this->SucProvincia) . '", 
				"' . htmlentities($this->SucDepartamento) . '", 
				"' . ($this->SucCodigoUbigeo) . '", 
		
				' . ($this->SucEstado) . ', 
				"' . ($this->SucTiempoCreacion) . '", 
				"' . ($this->SucTiempoModificacion) . '"				
				);';

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

	public function MtdEditarSucursal()
	{

		$sql = 'UPDATE tblsucsucursal SET 
			 SucNombre = "' . ($this->SucNombre) . '",
			 SucSiglas = "' . ($this->SucSiglas) . '",
			 SucNombre = "' . ($this->SucNombre) . '",
			  SucEtiqueta = "' . ($this->SucEtiqueta) . '",
			 
			 
			  SucDireccion = "' . ($this->SucDireccion) . '",
			  
			 SucDistrito = "' . ($this->SucDistrito) . '",
			 SucProvincia = "' . ($this->SucProvincia) . '",
			 SucDepartamento = "' . ($this->SucDepartamento) . '",
			 SucCodigoUbigeo = "' . ($this->SucCodigoUbigeo) . '",
			 
			 SucEstado = ' . ($this->SucEstado) . ',
			 SucTiempoModificacion = "' . ($this->SucTiempoModificacion) . '"
			 WHERE SucId = "' . ($this->SucId) . '";';

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
