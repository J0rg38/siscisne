<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoModalidad
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoModalidad
{

	public $FimId;
	public $FinId;
	public $MinId;
	public $FimObsequio;
	public $FimEstado;
	public $FimTiempoCreacion;
	public $FimTiempoModificacion;
	public $FimEliminado;

	public $FichaIngresoProducto;
	public $FichaIngresoTarea;
	public $FichaIngresoManoObra;
	public $FichaIngresoSuministro;
	public $FichaIngresoMantenimiento;

	public $FichaAccion;

	public $MinNombre;
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

	public function MtdGenerarFichaIngresoModalidadId()
	{

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FimId,5),unsigned)) AS "MAXIMO"
		FROM tblfimfichaingresomodalidad';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->FimId = "FIM-10000";
		} else {
			$fila['MAXIMO']++;
			$this->FimId = "FIM-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerFichaIngresoModalidad()
	{

		$sql = 'SELECT 
        fim.FimId,
        fim.FinId,
		fim.MinId,
		fim.FimObsequio,
		fim.FimEstado,
		DATE_FORMAT(fim.FimTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFimTiempoCreacion",
        DATE_FORMAT(fim.FimTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFimTiempoModificacion"	
        FROM tblfimfichaingresomodalidad fim
		WHERE fim.FimId = "' . $this->FimId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$InsFichaIngresoTarea = new ClsFichaIngresoTarea($this->InsMysql);
				$InsFichaIngresoProducto = new ClsFichaIngresoProducto($this->InsMysql);
				$InsFichaIngresoManoObra = new ClsFichaIngresoManoObra($this->InsMysql);
				$InsFichaIngresoSuministro = new ClsFichaIngresoSuministro($this->InsMysql);
				$InsFichaIngresoMantenimiento = new ClsFichaIngresoMantenimiento($this->InsMysql);

				$this->FimId = $fila['FimId'];
				$this->FinId = $fila['FinId'];
				$this->MinId = $fila['MinId'];
				$this->FimObsequio = $fila['FimObsequio'];
				$this->FimEstado = $fila['FimEstado'];
				$this->FimTiempoCreacion = $fila['NFimTiempoCreacion'];
				$this->FimTiempoModificacion = $fila['NFimTiempoModificacion'];

				$ResFichaIngresoTarea = $InsFichaIngresoTarea->MtdObtenerFichaIngresoTareas(NULL, NULL, 'FitId', 'ASC', NULL, $this->FimId, NULL);
				$this->FichaIngresoTarea = $ResFichaIngresoTarea['Datos'];

				$ResFichaIngresoProducto = $InsFichaIngresoProducto->MtdObtenerFichaIngresoProductos(NULL, NULL, 'FipId', 'ASC', NULL, $this->FimId, NULL);
				$this->FichaIngresoProducto = $ResFichaIngresoProducto['Datos'];

				$ResFichaIngresoSuministro = $InsFichaIngresoSuministro->MtdObtenerFichaIngresoSuministros(NULL, NULL, 'FisId', 'ASC', NULL, $this->FimId, NULL);
				$this->FichaIngresoSuministro = $ResFichaIngresoSuministro['Datos'];

				$ResFichaIngresoManoObra = $InsFichaIngresoManoObra->MtdObtenerFichaIngresoManoObras(NULL, NULL, 'FmoId', 'ASC', NULL, $this->FimId, NULL);
				$this->FichaIngresoManoObra = $ResFichaIngresoManoObra['Datos'];

				$ResFichaIngresoMantenimiento = $InsFichaIngresoMantenimiento->MtdObtenerFichaIngresoMantenimientos(NULL, NULL, 'FiaId', 'ASC', NULL, $this->FimId, NULL, NULL, false, NULL);
				$this->FichaIngresoMantenimiento = $ResFichaIngresoMantenimiento['Datos'];
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}


		return $Respuesta;
	}

	public function MtdObtenerFichaIngresoModalidades($oCampo = NULL, $oFiltro = NULL, $oOrden = 'FimId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFichaIngreso = NULL, $oEstado = NULL)
	{

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$fingreso = '';
		$estado = '';

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

		if (!empty($oFichaIngreso)) {
			$fingreso = ' AND fim.FinId = "' . ($oFichaIngreso) . '"';
		}

		if (!empty($oEstado)) {
			$estado = ' AND fim.FinEstado = ' . ($oEstado);
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fim.FimId,
				fim.FinId,
				fim.MinId,
				fim.FimObsequio,
				fim.FimEstado,
				DATE_FORMAT(fim.FimTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFimTiempoCreacion",
                DATE_FORMAT(fim.FimTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFimTiempoModificacion",
				min.MinNombre,
				min.MinSigla,
				fcc.FccId

				FROM tblfimfichaingresomodalidad fim
					LEFT JOIN tblminmodalidadingreso min
					ON fim.MinId = min.MinId
						LEFT JOIN tblfccfichaaccion fcc
						ON fcc.FimId = fim.FimId
				WHERE 1  = 1 ' . $filtrar . $fingreso . $estado . $paginacion;



		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsFichaIngresoModalidad = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {

			$FichaIngresoModalidad = new $InsFichaIngresoModalidad();
			$FichaIngresoModalidad->FimId = $fila['FimId'];
			$FichaIngresoModalidad->FinId = $fila['FinId'];
			$FichaIngresoModalidad->MinId = $fila['MinId'];
			$FichaIngresoModalidad->FimObsequio = $fila['FimObsequio'];
			$FichaIngresoModalidad->FimEstado = $fila['FimEstado'];
			$FichaIngresoModalidad->FimTiempoCreacion = $fila['NFimTiempoCreacion'];
			$FichaIngresoModalidad->FimTiempoModificacion = $fila['NFimTiempoModificacion'];

			$FichaIngresoModalidad->MinNombre = $fila['MinNombre'];
			$FichaIngresoModalidad->MinSigla = $fila['MinSigla'];

			$FichaIngresoModalidad->FccId = $fila['FccId'];

			$FichaIngresoModalidad->InsMysql = NULL;

			$Respuesta['Datos'][] = $FichaIngresoModalidad;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);

		return $Respuesta;
	}




	//Accion eliminar	 

	public function MtdEliminarFichaIngresoModalidad($oElementos)
	{

		$elementos = explode("#", $oElementos);

		// Inicializar variable para evitar warnings
		$eliminar = '';

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				if ($i == count($elementos)) {
					$eliminar .= '  (FimId = "' . ($elemento) . '")';
				} else {
					$eliminar .= '  (FimId = "' . ($elemento) . '")  OR';
				}
			}
			$i++;
		}

		$sql = 'DELETE FROM tblfimfichaingresomodalidad WHERE ' . $eliminar;

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


	public function MtdRegistrarFichaIngresoModalidad()
	{

		$this->MtdGenerarFichaIngresoModalidadId();

		$sql = 'INSERT INTO tblfimfichaingresomodalidad (
		FimId,
		FinId, 
		MinId,
		FimObsequio,
		FimEstado,
		FimTiempoCreacion,
		FimTiempoModificacion
		) 
		VALUES (
		"' . ($this->FimId) . '", 
		"' . ($this->FinId) . '", 
		"' . ($this->MinId) . '",
		' . ($this->FimObsequio) . ',
		' . ($this->FimEstado) . ',
		"' . ($this->FimTiempoCreacion) . '", 
		"' . ($this->FimTiempoModificacion) . '");';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}


		if (!$error) {

			if (!empty($this->FichaIngresoProducto)) {

				$validar = 0;
				$InsFichaIngresoProducto = new ClsFichaIngresoProducto($this->InsMysql);

				foreach ($this->FichaIngresoProducto as $DatFichaIngresoProducto) {

					$InsFichaIngresoProducto->FimId = $this->FimId;
					$InsFichaIngresoProducto->ProId = $DatFichaIngresoProducto->ProId;
					$InsFichaIngresoProducto->UmeId = $DatFichaIngresoProducto->UmeId;
					$InsFichaIngresoProducto->FipCantidad = $DatFichaIngresoProducto->FipCantidad;

					$InsFichaIngresoProducto->FipEstado = $DatFichaIngresoProducto->FipEstado;
					$InsFichaIngresoProducto->FipTiempoCreacion = $DatFichaIngresoProducto->FipTiempoCreacion;
					$InsFichaIngresoProducto->FipTiempoModificacion = $DatFichaIngresoProducto->FipTiempoModificacion;
					$InsFichaIngresoProducto->FipEliminado = $DatFichaIngresoProducto->FipEliminado;

					if ($InsFichaIngresoProducto->MtdRegistrarFichaIngresoProducto()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_FIM_201';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->FichaIngresoProducto) <> $validar) {
					$error = true;
				}
			}
		}

		if (!$error) {

			if (!empty($this->FichaIngresoTarea)) {

				$validar = 0;
				$InsFichaIngresoTarea = new ClsFichaIngresoTarea($this->InsMysql);

				foreach ($this->FichaIngresoTarea as $DatFichaIngresoTarea) {

					$InsFichaIngresoTarea->FimId = $this->FimId;
					$InsFichaIngresoTarea->FitDescripcion = $DatFichaIngresoTarea->FitDescripcion;
					$InsFichaIngresoTarea->FitAccion = $DatFichaIngresoTarea->FitAccion;
					$InsFichaIngresoTarea->FitEstado = $DatFichaIngresoTarea->FitEstado;
					$InsFichaIngresoTarea->FitTiempoCreacion = $DatFichaIngresoTarea->FitTiempoCreacion;
					$InsFichaIngresoTarea->FitTiempoModificacion = $DatFichaIngresoTarea->FitTiempoModificacion;
					$InsFichaIngresoTarea->FitEliminado = $DatFichaIngresoTarea->FitEliminado;

					if ($InsFichaIngresoTarea->MtdRegistrarFichaIngresoTarea()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_FIM_211';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->FichaIngresoTarea) <> $validar) {
					$error = true;
				}
			}
		}



		if (!$error) {

			if (!empty($this->FichaIngresoSuministro)) {

				$validar = 0;
				$InsFichaIngresoSuministro = new ClsFichaIngresoSuministro($this->InsMysql);

				foreach ($this->FichaIngresoSuministro as $DatFichaIngresoSuministro) {
					$InsFichaIngresoSuministro->FimId = $this->FimId;
					$InsFichaIngresoSuministro->ProId = $DatFichaIngresoSuministro->ProId;
					$InsFichaIngresoSuministro->UmeId = $DatFichaIngresoSuministro->UmeId;
					$InsFichaIngresoSuministro->FisCantidad = $DatFichaIngresoSuministro->FisCantidad;
					$InsFichaIngresoSuministro->FisEstado = $DatFichaIngresoSuministro->FisEstado;
					$InsFichaIngresoSuministro->FisTiempoCreacion = $DatFichaIngresoSuministro->FisTiempoCreacion;
					$InsFichaIngresoSuministro->FisTiempoModificacion = $DatFichaIngresoSuministro->FisTiempoModificacion;
					$InsFichaIngresoSuministro->FisEliminado = $DatFichaIngresoSuministro->FisEliminado;

					if ($InsFichaIngresoSuministro->MtdRegistrarFichaIngresoSuministro()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_FIM_221';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->FichaIngresoSuministro) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FichaIngresoMantenimiento)) {

				$validar = 0;
				$InsFichaIngresoMantenimiento = new ClsFichaIngresoMantenimiento($this->InsMysql);

				foreach ($this->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento) {

					$InsFichaIngresoMantenimiento->FimId = $this->FimId;
					$InsFichaIngresoMantenimiento->PmtId = $DatFichaIngresoMantenimiento->PmtId;
					$InsFichaIngresoMantenimiento->ProId = $DatFichaIngresoMantenimiento->ProId;

					$InsFichaIngresoMantenimiento->FiaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
					$InsFichaIngresoMantenimiento->FiaNivel = $DatFichaIngresoMantenimiento->FiaNivel;
					$InsFichaIngresoMantenimiento->FiaVerificar1 = $DatFichaIngresoMantenimiento->FiaVerificar1;
					$InsFichaIngresoMantenimiento->FiaVerificar2 = $DatFichaIngresoMantenimiento->FiaVerificar2;
					$InsFichaIngresoMantenimiento->FiaEstado = $DatFichaIngresoMantenimiento->FiaEstado;
					$InsFichaIngresoMantenimiento->FiaTiempoCreacion = $DatFichaIngresoMantenimiento->FiaTiempoCreacion;
					$InsFichaIngresoMantenimiento->FiaTiempoModificacion = $DatFichaIngresoMantenimiento->FiaTiempoModificacion;
					$InsFichaIngresoMantenimiento->FiaEliminado = $DatFichaIngresoMantenimiento->FiaEliminado;

					if ($InsFichaIngresoMantenimiento->MtdRegistrarFichaIngresoMantenimiento()) {
						$validar++;
					} else {
						$Resultado .= '#ERR_FIM_241';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->FichaIngresoMantenimiento) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FichaAccion)) {

				$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
				$InsFichaAccion->FimId = $this->FimId;
				$InsFichaAccion->FccFecha = $this->FichaAccion->FccFecha;
				$InsFichaAccion->FccEstado = $this->FichaAccion->FccEstado;

				$InsFichaAccion->FccCausa = $this->FichaAccion->FccCausa;
				$InsFichaAccion->FccPedido = $this->FichaAccion->FccPedido;
				$InsFichaAccion->FccSolucion = $this->FichaAccion->FccSolucion;

				$InsFichaAccion->FccManoObra = 0;
				$InsFichaAccion->FccDescuento = 0;
				$InsFichaAccion->FccTiempoCreacion = $this->FichaAccion->FccTiempoCreacion;
				$InsFichaAccion->FccTiempoModificacion = $this->FichaAccion->FccTiempoModificacion;

				if (!$InsFichaAccion->MtdRegistrarFichaAccion()) {
					$Resultado .= '#ERR_FIM_231';
					$error = true;
				}
			}
		}



		if ($error) {
			return false;
		} else {
			return true;
		}
	}

	public function MtdEditarFichaIngresoModalidad()
	{

		$sql = 'UPDATE tblfimfichaingresomodalidad SET 
			MinId = "' . ($this->MinId) . '",
			FimObsequio = ' . ($this->FimObsequio) . ',
			FimTiempoModificacion = "' . ($this->FimTiempoModificacion) . '"
			WHERE FimId = "' . ($this->FimId) . '";';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
		$FichaAccionId = $InsFichaAccion->MtdVerificarExisteFichaAcciones("fcc.FimId", $this->FimId);

		//			deb($FichaAccionId);
		if (!$error) {

			if (!empty($this->FichaIngresoProducto)) {


				$validar = 0;
				$InsFichaIngresoProducto = new ClsFichaIngresoProducto($this->InsMysql);

				foreach ($this->FichaIngresoProducto as $DatFichaIngresoProducto) {

					$InsFichaIngresoProducto->FipId = $DatFichaIngresoProducto->FipId;
					$InsFichaIngresoProducto->FimId = $this->FimId;
					$InsFichaIngresoProducto->ProId = $DatFichaIngresoProducto->ProId;
					$InsFichaIngresoProducto->UmeId = $DatFichaIngresoProducto->UmeId;
					$InsFichaIngresoProducto->FipCantidad = $DatFichaIngresoProducto->FipCantidad;

					$InsFichaIngresoProducto->FipEstado = $DatFichaIngresoProducto->FipEstado;
					$InsFichaIngresoProducto->FipTiempoCreacion = $DatFichaIngresoProducto->FipTiempoCreacion;
					$InsFichaIngresoProducto->FipTiempoModificacion = $DatFichaIngresoProducto->FipTiempoModificacion;
					$InsFichaIngresoProducto->FipEliminado = $DatFichaIngresoProducto->FipEliminado;

					if (empty($InsFichaIngresoProducto->FipId)) {
						if ($InsFichaIngresoProducto->FipEliminado <> 2) {
							if ($InsFichaIngresoProducto->MtdRegistrarFichaIngresoProducto()) {

								//$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
								//									$FichaAccionId = $InsFichaAccion->MtdVerificarExisteFichaAcciones("FimId",$InsFichaIngresoProducto->FimId,$this->FccId);							
								//									
								//deb($FichaAccionId);


								if (!empty($FichaAccionId)) {

									$InsFichaAccionProducto1 = new ClsFichaAccionProducto($this->InsMysql);
									$InsFichaAccionProducto1->FapId = NULL;
									$InsFichaAccionProducto1->FccId = $FichaAccionId;
									$InsFichaAccionProducto1->ProId = $InsFichaIngresoProducto->ProId;
									$InsFichaAccionProducto1->UmeId = $InsFichaIngresoProducto->UmeId;
									$InsFichaAccionProducto1->FapAccion = "";
									$InsFichaAccionProducto1->FapVerificar1 = 1;
									$InsFichaAccionProducto1->FapVerificar2 = 1;
									$InsFichaAccionProducto1->FapCantidad = $InsFichaIngresoProducto->FipCantidad;
									$InsFichaAccionProducto1->FapCantidadReal = 0;

									$InsFichaAccionProducto1->FapEstado = 1;
									$InsFichaAccionProducto1->FapTiempoCreacion = date("Y-m-d H:i:s");
									$InsFichaAccionProducto1->FapTiempoModificacion = date("Y-m-d H:i:s");
									$InsFichaAccionProducto1->FapEliminado = 1;

									$InsFichaAccionProducto1->MtdRegistrarFichaAccionProducto();
								}

								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_201';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoProducto->FipEliminado == 2) {
							if ($InsFichaIngresoProducto->MtdEliminarFichaIngresoProducto($InsFichaIngresoProducto->FipId)) {


								////MtdObtenerFichaAccionProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FapId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL,$oFichaAccionMantenimiento=NULL,$oEstricto=1,$oAccion=NULL,$oVehiculoMarca=NULL)
								//										//234
								//										$InsFichaAccionProducto->MtdEliminarFichaAccionProducto();		
								//										
								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_203';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsFichaIngresoProducto->MtdEditarFichaIngresoProducto()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_202';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}

				if (count($this->FichaIngresoProducto) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FichaIngresoTarea)) {


				$validar = 0;
				$InsFichaIngresoTarea = new ClsFichaIngresoTarea($this->InsMysql);

				foreach ($this->FichaIngresoTarea as $DatFichaIngresoTarea) {

					$InsFichaIngresoTarea->FitId = $DatFichaIngresoTarea->FitId;
					$InsFichaIngresoTarea->FimId = $this->FimId;
					$InsFichaIngresoTarea->FitDescripcion = $DatFichaIngresoTarea->FitDescripcion;
					$InsFichaIngresoTarea->FitAccion = $DatFichaIngresoTarea->FitAccion;
					$InsFichaIngresoTarea->FitEstado = $DatFichaIngresoTarea->FitEstado;
					$InsFichaIngresoTarea->FitTiempoCreacion = $DatFichaIngresoTarea->FitTiempoCreacion;
					$InsFichaIngresoTarea->FitTiempoModificacion = $DatFichaIngresoTarea->FitTiempoModificacion;
					$InsFichaIngresoTarea->FitEliminado = $DatFichaIngresoTarea->FitEliminado;

					if (empty($InsFichaIngresoTarea->FitId)) {
						if ($InsFichaIngresoTarea->FitEliminado <> 2) {
							if ($InsFichaIngresoTarea->MtdRegistrarFichaIngresoTarea()) {




								if (empty($FichaAccionId)) {


									$InsFichaAccionTarea1 = new ClsFichaAccionTarea($this->InsMysql);
									$InsFichaAccionTarea1->FatId = NULL;
									$InsFichaAccionTarea1->FatDescripcion = $InsFichaIngresoTarea->FitDescripcion;
									$InsFichaAccionTarea1->FatAccion = "C";
									$InsFichaAccionTarea1->FatVerificar1 = 2;
									$InsFichaAccionTarea1->FatVerificar2 = 2;
									$InsFichaAccionTarea1->FitId = $InsFichaIngresoTarea->FitId;
									$InsFichaAccionTarea1->FatEspecificacion = "";
									$InsFichaAccionTarea1->FatCosto = 0;
									$InsFichaAccionTarea1->FatEstado = 1;
									$InsFichaAccionTarea1->FatTiempoCreacion = date("Y-m-d H:i:s");
									$InsFichaAccionTarea1->FatTiempoModificacion = date("Y-m-d H:i:s");
									$InsFichaAccionTarea1->FatEliminado = 1;
									//$InsFichaAccionTarea1->InsMysql = NULL;
									$InsFichaAccionTarea1->MtdRegistrarFichaAccionTarea();
								}

								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_211';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoTarea->FitEliminado == 2) {
							if ($InsFichaIngresoTarea->MtdEliminarFichaIngresoTarea($InsFichaIngresoTarea->FitId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_213';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsFichaIngresoTarea->MtdEditarFichaIngresoTarea()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_212';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}

				if (count($this->FichaIngresoTarea) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FichaIngresoSuministro)) {


				$validar = 0;
				$InsFichaIngresoSuministro = new ClsFichaIngresoSuministro($this->InsMysql);

				foreach ($this->FichaIngresoSuministro as $DatFichaIngresoSuministro) {

					$InsFichaIngresoSuministro->FisId = $DatFichaIngresoSuministro->FisId;
					$InsFichaIngresoSuministro->FimId = $this->FimId;
					$InsFichaIngresoSuministro->ProId = $DatFichaIngresoSuministro->ProId;
					$InsFichaIngresoSuministro->UmeId = $DatFichaIngresoSuministro->UmeId;
					$InsFichaIngresoSuministro->FisCantidad = $DatFichaIngresoSuministro->FisCantidad;
					$InsFichaIngresoSuministro->FisEstado = $DatFichaIngresoSuministro->FisEstado;
					$InsFichaIngresoSuministro->FisTiempoCreacion = $DatFichaIngresoSuministro->FisTiempoCreacion;
					$InsFichaIngresoSuministro->FisTiempoModificacion = $DatFichaIngresoSuministro->FisTiempoModificacion;
					$InsFichaIngresoSuministro->FisEliminado = $DatFichaIngresoSuministro->FisEliminado;

					if (empty($InsFichaIngresoSuministro->FisId)) {
						if ($InsFichaIngresoSuministro->FisEliminado <> 2) {
							if ($InsFichaIngresoSuministro->MtdRegistrarFichaIngresoSuministro()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_221';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoSuministro->FisEliminado == 2) {
							if ($InsFichaIngresoSuministro->MtdEliminarFichaIngresoSuministro($InsFichaIngresoSuministro->FisId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_223';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsFichaIngresoSuministro->MtdEditarFichaIngresoSuministro()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIM_222';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}

				if (count($this->FichaIngresoSuministro) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FichaIngresoMantenimiento)) {


				$validar = 0;
				$InsFichaIngresoMantenimiento = new ClsFichaIngresoMantenimiento($this->InsMysql);

				foreach ($this->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento) {

					$InsFichaIngresoMantenimiento->FiaId = $DatFichaIngresoMantenimiento->FiaId;
					$InsFichaIngresoMantenimiento->FimId = $this->FimId;
					$InsFichaIngresoMantenimiento->PmtId = $DatFichaIngresoMantenimiento->PmtId;
					$InsFichaIngresoMantenimiento->ProId = $DatFichaIngresoMantenimiento->ProId;

					$InsFichaIngresoMantenimiento->FiaNivel = $DatFichaIngresoMantenimiento->FiaNivel;
					$InsFichaIngresoMantenimiento->FiaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
					$InsFichaIngresoMantenimiento->FiaNivel = $DatFichaIngresoMantenimiento->FiaNivel;
					$InsFichaIngresoMantenimiento->FiaVerificar1 = $DatFichaIngresoMantenimiento->FiaVerificar1;
					$InsFichaIngresoMantenimiento->FiaVerificar2 = $DatFichaIngresoMantenimiento->FiaVerificar2;

					$InsFichaIngresoMantenimiento->FiaEstado = $DatFichaIngresoMantenimiento->FiaEstado;
					$InsFichaIngresoMantenimiento->FiaTiempoCreacion = $DatFichaIngresoMantenimiento->FiaTiempoCreacion;
					$InsFichaIngresoMantenimiento->FiaTiempoModificacion = $DatFichaIngresoMantenimiento->FiaTiempoModificacion;
					$InsFichaIngresoMantenimiento->FiaEliminado = $DatFichaIngresoMantenimiento->FiaEliminado;

					if (empty($InsFichaIngresoMantenimiento->FiaId)) {
						if ($InsFichaIngresoMantenimiento->FiaEliminado <> 2) {
							if ($InsFichaIngresoMantenimiento->MtdRegistrarFichaIngresoMantenimiento()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_241';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsFichaIngresoMantenimiento->FiaEliminado == 2) {
							if ($InsFichaIngresoMantenimiento->MtdEliminarFichaIngresoMantenimiento($InsFichaIngresoMantenimiento->FiaId)) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_243';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsFichaIngresoMantenimiento->MtdEditarFichaIngresoMantenimiento()) {
								$validar++;
							} else {
								$Resultado .= '#ERR_FIN_242';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}

				if (count($this->FichaIngresoMantenimiento) <> $validar) {
					$error = true;
				}
			}
		}


		if (!$error) {

			if (!empty($this->FichaAccion)) {

				$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
				$InsFichaAccion->FccId = $this->FichaAccion->FccId;
				$InsFichaAccion->FimId = $this->FimId;
				$InsFichaAccion->FccFecha = $this->FichaAccion->FccFecha;

				$InsFichaAccion->FccCausa = $this->FichaAccion->FccCausa;
				$InsFichaAccion->FccPedido = $this->FichaAccion->FccPedido;
				$InsFichaAccion->FccSolucion = $this->FichaAccion->FccSolucion;

				$InsFichaAccion->FccManoObra =  $this->FichaAccion->FccManoObra;
				$InsFichaAccion->FccDescuento = $this->FichaAccion->FccDescuento;

				$InsFichaAccion->FccEstado = $this->FichaAccion->FccEstado;
				$InsFichaAccion->FccTiempoCreacion = $this->FichaAccion->FccTiempoCreacion;
				$InsFichaAccion->FccTiempoModificacion = $this->FichaAccion->FccTiempoModificacion;

				$InsFichaAccion->FichaAccionTarea = $this->FichaAccion->FichaAccionTarea;
				$InsFichaAccion->FichaAccionProducto = $this->FichaAccion->FichaAccionProducto;
				$InsFichaAccion->FichaAccionMantenimiento = $this->FichaAccion->FichaAccionMantenimiento;

				if (!$InsFichaAccion->MtdEditarFichaAccion()) {
					$Resultado .= '#ERR_FIM_231';
					$error = true;
				}
			}
		}


		if ($error) {
			return false;
		} else {
			return true;
		}
	}



	public function MtdEditarFichaIngresoModalidadDato($oCampo, $oDato, $oId)
	{

		$sql = 'UPDATE tblfimfichaingresomodalidad SET 
			' . $oCampo . ' = "' . ($oDato) . '",
			FimTiempoModificacion = NOW()
			WHERE FimId = "' . ($oId) . '";';

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



	public function MtdVerificarExisteFichaIngresoModalidad($oCampo, $oDato, $oFichaIngresoId)
	{

		$Respuesta =   NULL;

		$sql = 'SELECT 
        FimId
        FROM tblfimfichaingresomodalidad
        WHERE ' . $oCampo . ' = "' . $oDato . '" 
		AND FinId = "' . $oFichaIngresoId . '"LIMIT 1;';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			$fila = $this->InsMysql->MtdObtenerDatos($resultado);

			if (!empty($fila['FimId'])) {
				$Respuesta = $fila['FimId'];
			}
		}

		return $Respuesta;
	}


	public function FncFichaIngresoModalidadGenerarFichaAccion($oFichaIngresoModalidadId)
	{


		global $EmpresaImpuestoVenta;
		global $EmpresaMonedaId;

		$respuesta = 0;
		$Generar = true;

		if (!empty($oFichaIngresoModalidadId)) {

			$this->FimId = $oFichaIngresoModalidadId;
			$this->MtdObtenerFichaIngresoModalidad();

			$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
			$FichaAccionId = $InsFichaAccion->MtdVerificarExisteFichaAccion("FimId", $oFichaIngresoModalidadId);

			if (empty($FichaAccionId)) {

				$InsFichaAccion = new ClsFichaAccion($this->InsMysql);
				$InsFichaAccion->FimId = $this->FimId;
				$InsFichaAccion->FccFecha = date("Y-m-d");
				$InsFichaAccion->FccObservacion = date("d/m/Y H:i:s") . " - Sub OT autogenerada de O.T.: " . $this->FinId;

				$InsFichaAccion->FccManoObra = 0;
				$InsFichaAccion->FccDescuento = 0;
				$InsFichaAccion->FccEstado = 1;
				$InsFichaAccion->FccTiempoCreacion = date("Y-m-d H:i:s");
				$InsFichaAccion->FccTiempoModificacion = date("Y-m-d H:i:s");

				$InsFichaAccion->MinSigla = $this->MinSigla;

				$InsFichaAccion->FichaAccionTarea = array();
				$InsFichaAccion->FichaAccionProducto = array();
				$InsFichaAccion->FichaAccionMantenimiento = array();

				if (!empty($this->FichaIngresoTarea)) {
					foreach ($this->FichaIngresoTarea as $DatFichaIngresoTarea) {

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


				if (!empty($this->FichaIngresoProducto)) {
					foreach ($this->FichaIngresoProducto as $DatFichaIngresoProducto) {

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


				if (!empty($this->FichaIngresoSuministro)) {
					foreach ($this->FichaIngresoSuministro as $DatFichaIngresoSuministro) {

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


				if ($this->MinId == "MIN-10001") {

					if (!empty($this->FichaIngresoMantenimiento)) {
						foreach ($this->FichaIngresoMantenimiento as $DatFichaIngresoMantenimiento) {

							if (!empty($DatFichaIngresoMantenimiento->MinSigla)) { //AUX

								$InsFichaAccionMantenimiento1 = new ClsFichaAccionMantenimiento($this->InsMysql);

								$InsFichaAccionMantenimiento1->PmtId = $DatFichaIngresoMantenimiento->PmtId;
								$InsFichaAccionMantenimiento1->FaaAccion = $DatFichaIngresoMantenimiento->FiaAccion;
								$InsFichaAccionMantenimiento1->FaaNivel = (($DatFichaIngresoMantenimiento->FidAccion == "X")) ? '2' : '1';
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

						$RepPlanMantenimientoSeccion = $InsPlanMantenimientoSeccion->MtdObtenerPlanMantenimientoSecciones(NULL, NULL, "PmsId", "ASC", NULL);
						$ArrPlanMantenimientoSecciones = $RepPlanMantenimientoSeccion['Datos'];

						$InsPlanMantenimiento->PmaId = $ArrPlanMantenimientos[0]->PmaId;
						unset($ArrPlanMantenimientos);
						$InsPlanMantenimiento->MtdObtenerPlanMantenimiento();

						$this->PmaId = $InsPlanMantenimiento->PmaId;

						foreach ($ArrPlanMantenimientoSecciones as $DatPlanMantenimientoSeccion) {

							$PlanMantenimientoDetalleAccion = '';

							$ResPlanMantenimientoTarea = $InsPlanMantenimientoTarea->MtdObtenerPlanMantenimientoTareas(NULL, NULL, 'PmtNombre', 'ASC', NULL, $DatPlanMantenimientoSeccion->PmsId);
							$ArrPlanMantenimientoTareas = $ResPlanMantenimientoTarea['Datos'];

							foreach ($ArrPlanMantenimientoTareas as $DatPlanMantenimientoTarea) {

								switch ($InsPlanMantenimiento->VmaId) {

									//case "VMA-10017"://CHEVROLET
									default: //CHEVROLET
										foreach ($this->PmaChevroletKilometrajes as $DatKilometroEtiqueta => $DatKilometro) {

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


				if ($this->MinSigla == "CA") {

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


				if ($this->MinSigla == "PP") {

					$InsFichaAccionSalidaExterna1 = new ClsFichaAccionSalidaExterna($this->InsMysql);
					$InsFichaAccionSalidaExterna1->FsxFechaSalida = date("Y-m-d");
					$InsFichaAccionSalidaExterna1->FsxEstado = 1;
					$InsFichaAccionSalidaExterna1->FsxTiempoCreacion = date("Y-m-d H:i:s");
					$InsFichaAccionSalidaExterna1->FsxTiempoModificacion = date("Y-m-d H:i:s");

					$InsFichaAccion->FichaAccionSalidaExterna[] = $InsFichaAccionSalidaExterna1;
				}

				if (!$InsFichaAccion->MtdRegistrarFichaAccion()) {
					$Generar = false;
					$respuesta = 2;
				} else {
					$respuesta = 1;
				}
			} else {
				$respuesta = 3;
				$Generar = false;
			}
		} else {
			$respuesta = 4;
			$Generar = false;
		}

		return $Generar;
	}
}
