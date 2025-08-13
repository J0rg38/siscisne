<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCampana
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCampana
{

	public $CamId;
	public $CamCodigo;
	public $CamNombre;
	public $CamFechaInicio;
	public $CamFechaFin;
	public $CamAno;

	public $CamArchivo1;
	public $CamArchivo2;
	public $CamArchivo3;
	public $CamBoletinCodigo;
	public $CamBoletin;
	public $CamOperacionCodigo;
	public $CamOperacionTiempo;

	public $VmoId;
	public $CamEstado;
	public $CamTiempoCreacion;
	public $CamTiempoModificacion;
	public $CamEliminado;
	public $VmoNombre;
	public $VmaId;

	public $CampanaVehiculo;
	public $UsuId;
	public $SucId;
	public $AudUsuario;
	public $AudPersonal;

	public $InsMysql;

	public function __construct()
	{
		$this->InsMysql = new ClsMysql();
	}

	public function __destruct() {}

	public function MtdGenerarCampanaId()
	{


		$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(cam.CamId,13),unsigned)) AS "MAXIMO"
			FROM tblcamcampana cam
			WHERE YEAR(cam.CamFechaInicio) = ("' . $this->CamAno . '")
			
';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->CamId = "CAM-" . $this->CamAno . "-00001";
		} else {
			$fila['MAXIMO']++;
			$this->CamId = "CAM-" . $this->CamAno . "-" . str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);
		}
	}

	public function MtdObtenerCampana($oCompleto = true)
	{

		$sql = 'SELECT 
		cam.CamId,
		cam.CamCodigo,
		cam.CamNombre,
		DATE_FORMAT(cam.CamFechaInicio, "%d/%m/%Y") AS "NCamFechaInicio",
		DATE_FORMAT(cam.CamFechaFin, "%d/%m/%Y") AS "NCamFechaFin",
		
		cam.CamArchivo1,
		cam.CamArchivo2,
		cam.CamArchivo3,
		cam.CamBoletinCodigo,
		cam.CamBoletin,
		cam.CamOperacionCodigo,
		cam.CamOperacionTiempo,
		
		cam.VmoId,
		cam.CamEstado,
		DATE_FORMAT(cam.CamTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCamTiempoCreacion",
        DATE_FORMAT(cam.CamTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCamTiempoModificacion",
		
		vmo.VmoNombre,
		vmo.VmaId
	
        FROM tblcamcampana cam
			LEFT JOIN tblvmovehiculomodelo vmo
			ON cam.VmoId = vmo.VmoId
			
        WHERE cam.CamId = "' . $this->CamId . '"';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

				$this->CamId = $fila['CamId'];
				$this->CamCodigo = $fila['CamCodigo'];
				$this->CamNombre = $fila['CamNombre'];
				$this->CamFechaInicio = $fila['NCamFechaInicio'];
				$this->CamFechaFin = $fila['NCamFechaFin'];

				$this->CamArchivo1 = $fila['CamArchivo1'];
				$this->CamArchivo2 = $fila['CamArchivo2'];
				$this->CamArchivo3 = $fila['CamArchivo3'];


				$this->CamBoletinCodigo = $fila['CamBoletinCodigo'];
				$this->CamBoletin = $fila['CamBoletin'];
				$this->CamOperacionCodigo = $fila['CamOperacionCodigo'];
				$this->CamOperacionTiempo = $fila['CamOperacionTiempo'];



				$this->VmoId = $fila['VmoId'];
				$this->CamEstado = $fila['CamEstado'];
				$this->CamTiempoCreacion = $fila['NCamTiempoCreacion'];
				$this->CamTiempoModificacion = $fila['NCamTiempoModificacion'];

				$this->VmoNombre = $fila['VmoNombre'];
				$this->VmaId = $fila['VmaId'];

				if ($oCompleto) {

					$InsCampanaVehiculo = new ClsCampanaVehiculo();
					$ResCampanaVehiculo =  $InsCampanaVehiculo->MtdObtenerCampanaVehiculos(NULL, NULL, NULL, "AveId", "ASC", NULL, $this->CamId, NULL, NULL);
					$this->CampanaVehiculo = 	$ResCampanaVehiculo['Datos'];
				}
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerCampanas($oCampo = NULL, $oCondicion = "contiene", $oFiltro = NULL, $oOrden = 'CamId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL, $oEstado = NULL, $oVehiculoModelo = NULL, $oConVIN = NULL)
	{
		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fecha = '';
		$estado = '';
		$vmodelo = '';
		$cvin = '';

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
				$fecha = ' AND DATE(cam.CamFechaInicio)>="' . $oFechaInicio . '" AND DATE(cam.CamFechaInicio)<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(cam.CamFechaInicio)>="' . $oFechaInicio . '"';
			}
		} else {
			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(cam.CamFechaInicio)<="' . $oFechaFin . '"';
			}
		}


		if (!empty($oEstado)) {
			$estado = ' AND cam.CamEstado = ' . $oEstado;
		}

		if (!empty($oVehiculoModelo)) {
			$vmodelo = ' AND cam.VmoId = "' . $oVehiculoModelo . '"';
		}

		switch ($oConVIN) {

			case 1:

				$cvin = ' AND 
						EXISTS (
							SELECT 
							ave.AveId
							FROM tblavecampanavehiculo ave
							WHERE ave.CamId = cam.CamId
							LIMIT 1
						)
					';

				break;

			case 2:

				$cvin = ' AND 
						NOT EXISTS (
							SELECT 
							ave.AveId
							FROM tblavecampanavehiculo ave
							WHERE ave.CamId = cam.CamId
							LIMIT 1
						)
					';

				break;

			default:

				break;
		}

		$sql = 'SELECT
					SQL_CALC_FOUND_ROWS 
					cam.CamId,
					cam.CamCodigo,
					cam.CamNombre,
					DATE_FORMAT(cam.CamFechaInicio, "%d/%m/%Y") AS "NCamFechaInicio",
					DATE_FORMAT(cam.CamFechaFin, "%d/%m/%Y") AS "NCamFechaFin",
					
					cam.CamArchivo1,
					cam.CamArchivo2,
					cam.CamArchivo3,
					cam.CamBoletinCodigo,
					cam.CamBoletin,
					cam.CamOperacionCodigo,
					cam.CamOperacionTiempo,
					
					cam.VmoId,
					cam.CamEstado,
					DATE_FORMAT(cam.CamTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCamTiempoCreacion",
					DATE_FORMAT(cam.CamTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCamTiempoModificacion",
					
					vmo.VmoNombre,
					vmo.VmaId,
					
					vma.VmaNombre,
					
						
				CASE
				WHEN EXISTS (
					SELECT 
					ave.AveId
					FROM tblavecampanavehiculo ave
					WHERE ave.CamId = cam.CamId
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS CamVIN
				
					
				FROM tblcamcampana cam
					LEFT JOIN tblvmovehiculomodelo vmo
					ON cam.VmoId = vmo.VmoId
						LEFT JOIN tblvmavehiculomarca vma
						ON vmo.VmaId = vma.VmaId
						
				WHERE 1 = 1 ' . $filtrar . $fecha . $estado . $vmodelo . $cvin . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsCampana = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$Campana = new $InsCampana();
			$Campana->CamId = $fila['CamId'];

			$Campana->CamCodigo = $fila['CamCodigo'];
			$Campana->CamNombre = $fila['CamNombre'];
			$Campana->CamFechaInicio = $fila['NCamFechaInicio'];
			$Campana->CamFechaFin = $fila['NCamFechaFin'];

			$Campana->CamArchivo1 = $fila['CamArchivo1'];
			$Campana->CamArchivo2 = $fila['CamArchivo2'];
			$Campana->CamArchivo3 = $fila['CamArchivo3'];


			$Campana->CamBoletinCodigo = $fila['CamBoletinCodigo'];
			$Campana->CamBoletin = $fila['CamBoletin'];

			$Campana->CamOperacionCodigo = $fila['CamOperacionCodigo'];
			$Campana->CamOperacionTiempo = $fila['CamOperacionTiempo'];

			$Campana->VmoId = $fila['VmoId'];
			$Campana->CamEstado = $fila['CamEstado'];
			$Campana->CamTiempoCreacion = $fila['NCamTiempoCreacion'];
			$Campana->CamTiempoModificacion = $fila['NCamTiempoModificacion'];

			$Campana->VmoNombre = $fila['VmoNombre'];
			$Campana->VmaId = $fila['VmaId'];

			$Campana->VmaNombre = $fila['VmaNombre'];

			$Campana->CamVIN = $fila['CamVIN'];

			$Campana->InsMysql = NULL;
			$Respuesta['Datos'][] = $Campana;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}




	//Accion eliminar	 
	public function MtdEliminarCampana($oElementos)
	{

		$this->InsMysql->MtdTransaccionIniciar();

		$InsCampanaVehiculo = new ClsCampanaVehiculo();

		$error = false;

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {

			if (!empty($elemento)) {


				$ResCampanaVehiculo = $InsCampanaVehiculo->MtdObtenerCampanaVehiculos(NULL, NULL, NULL, 'AveId', 'Desc', NULL, $elemento);
				$ArrCampanaVehiculos = $ResCampanaVehiculo['Datos'];

				if (!empty($ArrCampanaVehiculos)) {
					$amdetalle = '';

					foreach ($ArrCampanaVehiculos as $DatCampanaVehiculo) {
						$amdetalle .= '#' . $DatCampanaVehiculo->AveId;
					}

					if (!$InsCampanaVehiculo->MtdEliminarCampanaVehiculo($amdetalle)) {
						$error = true;
					}
				}

				if (!$error) {
					$sql = 'DELETE FROM tblcamcampana WHERE  (CamId = "' . ($elemento) . '" ) ';

					$resultado = $this->InsMysql->MtdEjecutar($sql, false);

					if (!$resultado) {
						$error = true;
					} else {
						$this->MtdAuditarCampana(3, "Se elimino la Campana", $elemento);
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
	public function MtdActualizarEstadoCampana($oElementos, $oEstado, $oTransaccion = true)
	{

		$error = false;

		if ($oTransaccion) {
			$this->InsMysql->MtdTransaccionIniciar();
		}

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				$sql = 'UPDATE tblcamcampana SET CamEstado = ' . $oEstado . ' WHERE CamId = "' . $elemento . '"';

				$resultado = $this->InsMysql->MtdEjecutar($sql, false);

				if (!$resultado) {
					$error = true;
				} else {

					$Auditoria = "Se actualizo el Estado de la Campana";

					$this->CamId = $elemento;
					$this->MtdAuditarCampana(2, $Auditoria, $elemento);
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


	public function MtdRegistrarCampana()
	{

		global $Resultado;
		$error = false;

		$this->MtdGenerarCampanaId();

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'INSERT INTO tblcamcampana (
			CamId,
			CamCodigo,
			CamNombre,
			CamFechaInicio,
			CamFechaFin,
			CamArchivo1,
			CamArchivo2,
			CamArchivo3,
			
			CamBoletinCodigo,
			CamBoletin,
			CamOperacionCodigo,
			CamOperacionTiempo,
			
			VmoId,
			CamEstado,			
			CamTiempoCreacion,
			CamTiempoModificacion) 
			VALUES (
			"' . ($this->CamId) . '", 
			"' . ($this->CamCodigo) . '", 
			"' . ($this->CamNombre) . '", 
			"' . ($this->CamFechaInicio) . '", 
			' . (empty($this->CamFechaFin) ? "NULL," : '"' . $this->CamFechaFin . '",') . '
			
			"' . ($this->CamArchivo1) . '",
			"' . ($this->CamArchivo2) . '",
			"' . ($this->CamArchivo3) . '",
			
			
			"' . ($this->CamBoletinCodigo) . '",
			"' . ($this->CamBoletin) . '",
			"' . ($this->CamOperacionCodigo) . '",
			"' . ($this->CamOperacionTiempo) . '",
			
			' . (empty($this->VmoId) ? "NULL," : '"' . $this->VmoId . '",') . '
			' . ($this->CamEstado) . ',
			"' . ($this->CamTiempoCreacion) . '",
			"' . ($this->CamTiempoModificacion) . '");';

		if (!$error) {
			$resultado = $this->InsMysql->MtdEjecutar($sql, false);

			if (!$resultado) {
				$error = true;
			}
		}

		//
		//			if(!$error){			
		//			
		//				if (!empty($this->CampanaVehiculo)){	
		//				
		//					$InsCampanaVehiculo = new ClsCampanaVehiculo();
		//					
		//					if(!$InsCampanaVehiculo->MtdEliminarCampanaVehiculoTodo($this->CamId)){
		//						$error = true;
		//					}
		//					
		//				}
		//				
		//			}
		//			
		if (!$error) {

			if (!empty($this->CampanaVehiculo)) {

				$validar = 0;

				foreach ($this->CampanaVehiculo as $DatCampanaVehiculo) {

					$InsCampanaVehiculo = new ClsCampanaVehiculo();
					$InsCampanaVehiculo->CamId = $this->CamId;
					$InsCampanaVehiculo->AveVIN = $DatCampanaVehiculo->AveVIN;
					$InsCampanaVehiculo->AveEstado = $DatCampanaVehiculo->AveEstado;
					$InsCampanaVehiculo->AveTiempoCreacion = $DatCampanaVehiculo->AveTiempoCreacion;
					$InsCampanaVehiculo->AveTiempoModificacion = $DatCampanaVehiculo->AveTiempoModificacion;
					$InsCampanaVehiculo->AveEliminado = $DatCampanaVehiculo->AveEliminado;

					if ($InsCampanaVehiculo->MtdRegistrarCampanaVehiculo()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_CAM_201';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->CampanaVehiculo) <> $validar) {
					$error = true;
				}
			}
		}


		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			$this->MtdAuditarCampana(1, "Se registro la Campana", $this);
			return true;
		}
	}

	public function MtdEditarCampana()
	{

		global $Resultado;
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblcamcampana SET
			CamCodigo = "' . ($this->CamCodigo) . '",
			CamFechaInicio = "' . ($this->CamFechaInicio) . '",
			CamNombre = "' . ($this->CamNombre) . '",
			' . (empty($this->CamFechaFin) ? 'CamFechaFin = NULL, ' : 'CamFechaFin = "' . $this->CamFechaFin . '",') . '
			CamArchivo1 = "' . ($this->CamArchivo1) . '",
			CamArchivo2 = "' . ($this->CamArchivo2) . '",
			CamArchivo3 = "' . ($this->CamArchivo3) . '",	
			
			CamBoletinCodigo = "' . ($this->CamBoletinCodigo) . '",	
			CamBoletin = "' . ($this->CamBoletin) . '",
			CamOperacionCodigo = "' . ($this->CamOperacionCodigo) . '",
			CamOperacionTiempo = "' . ($this->CamOperacionTiempo) . '",
			
			' . (empty($this->VmoId) ? 'VmoId = NULL, ' : 'VmoId = "' . $this->VmoId . '",') . '
			CamEstado = ' . ($this->CamEstado) . ',
			CamTiempoModificacion = "' . ($this->CamTiempoModificacion) . '"
			WHERE CamId = "' . ($this->CamId) . '";';


		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}



		if (!$error) {

			if (!empty($this->CampanaVehiculo)) {

				$InsCampanaVehiculo = new ClsCampanaVehiculo();

				if (!$InsCampanaVehiculo->MtdEliminarCampanaVehiculoTodo($this->CamId)) {
					$error = true;
				}
			}
		}



		if (!$error) {

			if (!empty($this->CampanaVehiculo)) {


				if (!empty($this->CampanaVehiculo)) {

					$validar = 0;

					foreach ($this->CampanaVehiculo as $DatCampanaVehiculo) {

						$InsCampanaVehiculo = new ClsCampanaVehiculo();
						$InsCampanaVehiculo->CamId = $this->CamId;
						$InsCampanaVehiculo->AveVIN = $DatCampanaVehiculo->AveVIN;
						$InsCampanaVehiculo->AveEstado = $DatCampanaVehiculo->AveEstado;
						$InsCampanaVehiculo->AveTiempoCreacion = $DatCampanaVehiculo->AveTiempoCreacion;
						$InsCampanaVehiculo->AveTiempoModificacion = $DatCampanaVehiculo->AveTiempoModificacion;
						$InsCampanaVehiculo->AveEliminado = $DatCampanaVehiculo->AveEliminado;

						if ($InsCampanaVehiculo->MtdRegistrarCampanaVehiculo()) {
							$validar++;
						} else {
							$Resultado .= '#ERR_CAM_201';
							$Resultado .= '#Item Numero: ' . ($validar + 1);
						}
					}

					if (count($this->CampanaVehiculo) <> $validar) {
						$error = true;
					}
				}
			}
		}

		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();

			$this->MtdAuditarCampana(2, "Se edito la Campana", $this);
			return true;
		}
	}



	private function MtdAuditarCampana($oAccion, $oDescripcion, $oDatos, $oCodigo = NULL, $oUsuario = NULL, $oPersonal = NULL)
	{

		$InsAuditoria = new ClsAuditoria();
		$InsAuditoria->AudCodigo = $this->CamId;

		$InsAuditoria->UsuId = $this->UsuId;
		$InsAuditoria->SucId = $this->SucId;
		$InsAuditoria->AudAccion = $oAccion;
		$InsAuditoria->AudDescripcion = $oDescripcion;
		$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
		$InsAuditoria->AudDatos = $oDatos;
		$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");

		if ($InsAuditoria->MtdAuditoriaRegistrar()) {
			return true;
		} else {
			return false;
		}
	}
}
