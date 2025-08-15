<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoProforma
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoProforma
{

	public $VprId;
	public $VprAno;
	public $VprMes;

	public $VprCodigo;
	public $VprFecha;

	public $VmaId;

	public $MonId;
	public $VprTipoCambio;
	public $VprObservacion;
	public $VprAdicional;

	public $VprTotal;
	public $VprEstado;
	public $VprTiempoCreacion;
	public $VprTiempoModificacion;
	public $VprEliminado;

	public $MonSimbolo;
	public $MonNombre;

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


	public function MtdGenerarVehiculoProformaId()
	{

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(VprId,5),unsigned)) AS "MAXIMO"
		FROM tblvprvehiculoproforma';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);

		if (empty($fila['MAXIMO'])) {
			$this->VprId = "VPR-10000";
		} else {
			$fila['MAXIMO']++;
			$this->VprId = "VPR-" . $fila['MAXIMO'];
		}
	}

	public function MtdObtenerVehiculoProforma($oCompleto = true)
	{

		$sql = 'SELECT 
        vpr.VprId,
		
		vpr.VprAno,
		vpr.VprMes,
		
		vpr.VprCodigo,		
		DATE_FORMAT(vpr.VprFecha, "%d/%m/%Y") AS "NVprFecha",

		vpr.VmaId,
		
		vpr.MonId,
		vpr.VprTipoCambio,		
		vpr.VprObservacion,
		vpr.VprAdicional,
		
		vpr.VprTotal,
		vpr.VprEstado,
		
		DATE_FORMAT(vpr.VprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVprTiempoCreacion",
        DATE_FORMAT(vpr.VprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVprTiempoModificacion"
        FROM tblvprvehiculoproforma vpr
        WHERE vpr.VprId = "' . $this->VprId . '";';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
				$this->VprId = $fila['VprId'];
				$this->VprAno = $fila['VprAno'];
				$this->VprMes = $fila['VprMes'];
				$this->VprCodigo = $fila['VprCodigo'];
				$this->VprFecha = $fila['NVprFecha'];

				$this->VmaId = $fila['VmaId'];

				$this->MonId = $fila['MonId'];
				$this->VprTipoCambio = $fila['VprTipoCambio'];
				$this->VprObservacion = $fila['VprObservacion'];
				$this->VprAdicional = $fila['VprAdicional'];

				$this->VprEstado = $fila['VprEstado'];
				$this->VprTiempoCreacion = $fila['NVprTiempoCreacion'];
				$this->VprTiempoModificacion = $fila['NVprTiempoModificacion'];

				if ($oCompleto) {
					$InsVehiculoProformaDetalle = new ClsVehiculoProformaDetalle();
					$ResVehiculoProformaDetalle = $InsVehiculoProformaDetalle->MtdObtenerVehiculoProformaDetalles(NULL, NULL, 'VpdId', 'ASC', NULL, $this->VprId);
					$this->VehiculoProformaDetalle = $ResVehiculoProformaDetalle['Datos'];
				}
			}

			$Respuesta =  $this;
		} else {
			$Respuesta =   NULL;
		}

		return $Respuesta;
	}

	public function MtdObtenerVehiculoProformas($oCampo = NULL, $oCondicion = NULL, $oFiltro = NULL, $oOrden = 'VprId', $oSentido = 'Desc', $oPaginacion = '0,10', $oFechaInicio = NULL, $oFechaFin = NULL)
	{

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

		if (!empty($oOrden)) {
			$orden = ' ORDER BY ' . ($oOrden) . ' ' . ($oSentido);
		}

		if (!empty($oPaginacion)) {
			$paginacion = ' LIMIT ' . ($oPaginacion);
		}

		if (!empty($oFechaInicio)) {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(vpr.' . $oFecha . ')>="' . $oFechaInicio . '" AND DATE(vpr.' . $oFecha . ')<="' . $oFechaFin . '"';
			} else {
				$fecha = ' AND DATE(vpr.' . $oFecha . ')>="' . $oFechaInicio . '"';
			}
		} else {

			if (!empty($oFechaFin)) {
				$fecha = ' AND DATE(vpr.' . $oFecha . ')<="' . $oFechaFin . '"';
			}
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vpr.VprId,
		
				vpr.VprAno,
				vpr.VprMes,
		
				vpr.VprCodigo,
				DATE_FORMAT(vpr.VprFecha, "%d/%m/%Y") AS "NVprFecha",
				
				vpr.VmaId,
				
				vpr.MonId,
				vpr.VprTipoCambio,
				vpr.VprObservacion,
				vpr.VprAdicional,
				
				vpr.VprTotal,
				vpr.VprEstado,
				DATE_FORMAT(vpr.VprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVprTiempoCreacion",
                DATE_FORMAT(vpr.VprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVprTiempoModificacion",
				
				mon.MonNombre,
				mon.MonSimbolo
				
				FROM tblvprvehiculoproforma vpr
					LEFT JOIN tblmonmoneda mon
					ON vpr.MonId = mon.MonId
					
				WHERE 1 = 1' . $filtrar . $vversion . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsVehiculoProforma = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$VehiculoProforma = new $InsVehiculoProforma();
			$VehiculoProforma->VprId = $fila['VprId'];
			$VehiculoProforma->VprAno = $fila['VprAno'];
			$VehiculoProforma->VprMes = $fila['VprMes'];
			$VehiculoProforma->VprMesDescripcion = FncConvertirMes($fila['VprMes']);
			$VehiculoProforma->VprCodigo = $fila['VprCodigo'];
			$VehiculoProforma->VprFecha = $fila['NVprFecha'];

			$VehiculoProforma->VmaId = $fila['VmaId'];

			$VehiculoProforma->MonId = $fila['MonId'];
			$VehiculoProforma->VprTipoCambio = $fila['VprTipoCambio'];

			$VehiculoProforma->VprObservacion = $fila['VprObservacion'];
			$VehiculoProforma->VprAdicional = $fila['VprAdicional'];


			$VehiculoProforma->VprTotal = $fila['VprTotal'];
			$VehiculoProforma->VprEstado = $fila['VprEstado'];
			$VehiculoProforma->VprTiempoCreacion = $fila['NVprTiempoCreacion'];
			$VehiculoProforma->VprTiempoModificacion = $fila['NVprTiempoModificacion'];

			$VehiculoProforma->MonNombre = $fila['MonNombre'];
			$VehiculoProforma->MonSimbolo = $fila['MonSimbolo'];


			$Respuesta['Datos'][] = $VehiculoProforma;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);



		return $Respuesta;
	}





	//Accion eliminar	 

	public function MtdEliminarVehiculoProforma($oElementos)
	{

		$elementos = explode("#", $oElementos);

		$i = 1;
		foreach ($elementos as $elemento) {
			if (!empty($elemento)) {

				if ($i == count($elementos)) {
					$eliminar .= '  (VprId = "' . ($elemento) . '")';
				} else {
					$eliminar .= '  (VprId = "' . ($elemento) . '")  OR';
				}
			}
			$i++;
		}

		$sql = 'DELETE FROM tblvprvehiculoproforma WHERE ' . $eliminar;

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


	public function MtdRegistrarVehiculoProforma()
	{

		global $Resultado;

		$error = false;


		$VehiculoProformaId = $this->MtdVerificarExisteVehiculoProforma("VprCodigo", $this->VprCodigo);

		if (!empty($VehiculoProformaId)) {
			$error = true;
			$Resultado .= '#ERR_VPR_601';
		}


		$this->MtdGenerarVehiculoProformaId();

		$this->InsMysql->MtdTransaccionIniciar();


		$sql = 'INSERT INTO tblvprvehiculoproforma (
			VprId,
		
			VprAno,
			VprMes,
			
			VprCodigo,
			VprFecha,
		
			VmaId,
			
			MonId,
			VprTipoCambio,
			
			VprObservacion,
			VprAdicional,
			
			VprTotal,
			VprEstado,
			VprTiempoCreacion,
			VprTiempoModificacion
			) 
			VALUES (
			"' . ($this->VprId) . '", 
			
			"' . ($this->VprAno) . '", 
			"' . ($this->VprMes) . '", 
			
			"' . ($this->VprCodigo) . '", 
			"' . ($this->VprFecha) . '", 
						
			' . (empty($this->VmaId) ? 'NULL, ' : '"' . $this->VmaId . '",') . '
			
			"' . ($this->MonId) . '", 			
			' . (empty($this->VprTipoCambio) ? 'NULL, ' : '' . $this->VprTipoCambio . ',') . '
			
			"' . ($this->VprObservacion) . '", 
			' . ($this->VprAdicional) . ', 
			
			' . ($this->VprTotal) . ', 
			' . ($this->VprEstado) . ', 
			"' . ($this->VprTiempoCreacion) . '", 
			"' . ($this->VprTiempoModificacion) . '");';


		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}


		if (!$error) {

			if (!empty($this->VehiculoProformaDetalle)) {

				$validar = 0;


				foreach ($this->VehiculoProformaDetalle as $DatVehiculoProformaDetalle) {

					$InsVehiculoProformaDetalle = new ClsVehiculoProformaDetalle();
					$InsVehiculoProformaDetalle->VprId = $this->VprId;
					$InsVehiculoProformaDetalle->EinId = $DatVehiculoProformaDetalle->EinId;
					$InsVehiculoProformaDetalle->VpdCosto = $DatVehiculoProformaDetalle->VpdCosto;
					$InsVehiculoProformaDetalle->VpdEstado = $DatVehiculoProformaDetalle->VpdEstado;
					$InsVehiculoProformaDetalle->VpdTiempoCreacion = $DatVehiculoProformaDetalle->VpdTiempoCreacion;
					$InsVehiculoProformaDetalle->VpdTiempoModificacion = $DatVehiculoProformaDetalle->VpdTiempoModificacion;
					$InsVehiculoProformaDetalle->VpdEliminado = $DatVehiculoProformaDetalle->VpdEliminado;

					//deb($InsVehiculoProformaDetalle->EinId);
					if (empty($InsVehiculoProformaDetalle->EinId)) {

						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						$InsVehiculoIngreso->EinId = "";
						$InsVehiculoIngreso->CliId = NULL;
						$InsVehiculoIngreso->OncId = "ONC-10000";

						$InsVehiculoIngreso->EinVIN = $DatVehiculoProformaDetalle->EinVIN;

						$InsVehiculoIngreso->VmaId = $DatVehiculoProformaDetalle->VmaId;
						$InsVehiculoIngreso->VmoId = $DatVehiculoProformaDetalle->VmoId;
						$InsVehiculoIngreso->VveId = $DatVehiculoProformaDetalle->VveId;

						$InsVehiculoIngreso->EinAnoFabricacion = $DatVehiculoProformaDetalle->EinAnoFabricacion;
						$InsVehiculoIngreso->EinAnoModelo = $DatVehiculoProformaDetalle->EinAnoModelo;
						$InsVehiculoIngreso->EinNumeroMotor = $DatVehiculoProformaDetalle->EinNumeroMotor;
						$InsVehiculoIngreso->EinColor = $DatVehiculoProformaDetalle->EinColor;

						$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
						$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");
						$InsVehiculoIngreso->EinEliminado = 1;

						if ($InsVehiculoIngreso->MtdRegistrarVehiculoIngresoDeVehiculoProforma(false)) {

							$InsVehiculoProformaDetalle->EinId = $InsVehiculoIngreso->EinId;
						}
					} else {

						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmaId", $DatVehiculoProformaDetalle->VmaId, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmoId", $DatVehiculoProformaDetalle->VmoId, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VveId", $DatVehiculoProformaDetalle->VveId, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoFabricacion", $DatVehiculoProformaDetalle->EinAnoFabricacion, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoModelo", $DatVehiculoProformaDetalle->EinAnoModelo, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroMotor", $DatVehiculoProformaDetalle->EinNumeroMotor, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinColor", $DatVehiculoProformaDetalle->EinColor, $InsVehiculoProformaDetalle->EinId);
					}

					if ($InsVehiculoProformaDetalle->MtdRegistrarVehiculoProformaDetalle()) {

						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VprId", $this->VprId, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoProforma", $this->VprAno, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinMesProforma", $this->VprMes, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroProforma", $this->VprCodigo, $InsVehiculoProformaDetalle->EinId);

						$validar++;
					} else {
						$Resultado .= '#ERR_VPR_201';
						$Resultado .= '#Item Numero: ' . ($validar + 1);
					}
				}

				if (count($this->VehiculoProformaDetalle) <> $validar) {
					$error = true;
				}
			}
		}




		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			$this->MtdAuditarVehiculoProforma(1, "Se registro la Proforma de Vehiculos", $this);
			return true;
		}
	}

	public function MtdEditarVehiculoProforma()
	{

		$this->InsMysql->MtdTransaccionIniciar();

		$sql = 'UPDATE tblvprvehiculoproforma SET 
		
		VprAno = "' . ($this->VprAno) . '",
		VprMes = "' . ($this->VprMes) . '",
		
		VprCodigo = "' . ($this->VprCodigo) . '",
		VprFecha = "' . ($this->VprFecha) . '",
		
		' . (empty($this->VmaId) ? 'VmaId = NULL, ' : 'VmaId = "' . $this->VmaId . '",') . '
		
		MonId = "' . ($this->MonId) . '",
		' . (empty($this->VprTipoCambio) ? 'VprTipoCambio = NULL, ' : 'VprTipoCambio = ' . $this->VprTipoCambio . ',') . '

		VprObservacion = "' . ($this->VprObservacion) . '",
		VprAdicional = ' . ($this->VprAdicional) . ',
		
		VprTotal = ' . ($this->VprTotal) . ',
		VprEstado = ' . ($this->VprEstado) . ',
		VprTiempoModificacion = "' . ($this->VprTiempoModificacion) . '"
		WHERE VprId = "' . ($this->VprId) . '";';

		$error = false;

		$resultado = $this->InsMysql->MtdEjecutar($sql, false);

		if (!$resultado) {
			$error = true;
		}

		if (!$error) {

			if (!empty($this->VehiculoProformaDetalle)) {

				$validar = 0;


				foreach ($this->VehiculoProformaDetalle as $DatVehiculoProformaDetalle) {

					$InsVehiculoProformaDetalle = new ClsVehiculoProformaDetalle();
					$InsVehiculoProformaDetalle->VpdId = $DatVehiculoProformaDetalle->VpdId;
					$InsVehiculoProformaDetalle->VprId = $this->VprId;
					$InsVehiculoProformaDetalle->EinId = $DatVehiculoProformaDetalle->EinId;
					$InsVehiculoProformaDetalle->VpdCosto = $DatVehiculoProformaDetalle->VpdCosto;
					$InsVehiculoProformaDetalle->VpdEstado = $DatVehiculoProformaDetalle->VpdEstado;
					$InsVehiculoProformaDetalle->VpdTiempoCreacion = $DatVehiculoProformaDetalle->VpdTiempoCreacion;
					$InsVehiculoProformaDetalle->VpdTiempoModificacion = $DatVehiculoProformaDetalle->VpdTiempoModificacion;
					$InsVehiculoProformaDetalle->VpdEliminado = $DatVehiculoProformaDetalle->VpdEliminado;

					if (empty($InsVehiculoProformaDetalle->EinId)) {

						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						$InsVehiculoIngreso->EinId = "";
						$InsVehiculoIngreso->CliId = NULL;
						$InsVehiculoIngreso->OncId = "ONC-10000";

						$InsVehiculoIngreso->EinVIN = $DatVehiculoProformaDetalle->EinVIN;

						$InsVehiculoIngreso->VmaId = $DatVehiculoProformaDetalle->VmaId;
						$InsVehiculoIngreso->VmoId = $DatVehiculoProformaDetalle->VmoId;
						$InsVehiculoIngreso->VveId = $DatVehiculoProformaDetalle->VveId;

						$InsVehiculoIngreso->EinAnoFabricacion = $DatVehiculoProformaDetalle->EinAnoFabricacion;
						$InsVehiculoIngreso->EinAnoModelo = $DatVehiculoProformaDetalle->EinAnoModelo;
						$InsVehiculoIngreso->EinNumeroMotor = $DatVehiculoProformaDetalle->EinNumeroMotor;
						$InsVehiculoIngreso->EinColor = $DatVehiculoProformaDetalle->EinColor;

						$InsVehiculoIngreso->EinTiempoCreacion = date("Y-m-d H:i:s");
						$InsVehiculoIngreso->EinTiempoModificacion = date("Y-m-d H:i:s");
						$InsVehiculoIngreso->EinEliminado = 1;

						if ($InsVehiculoIngreso->MtdRegistrarVehiculoIngresoDeVehiculoProforma(false)) {

							$InsVehiculoProformaDetalle->EinId = $InsVehiculoIngreso->EinId;
						}
					} else {

						$InsVehiculoIngreso = new ClsVehiculoIngreso();
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmaId", $DatVehiculoProformaDetalle->VmaId, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VmoId", $DatVehiculoProformaDetalle->VmoId, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VveId", $DatVehiculoProformaDetalle->VveId, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoFabricacion", $DatVehiculoProformaDetalle->EinAnoFabricacion, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoModelo", $DatVehiculoProformaDetalle->EinAnoModelo, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroMotor", $DatVehiculoProformaDetalle->EinNumeroMotor, $InsVehiculoProformaDetalle->EinId);
						$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinColor", $DatVehiculoProformaDetalle->EinColor, $InsVehiculoProformaDetalle->EinId);
					}



					if (empty($InsVehiculoProformaDetalle->VpdId)) {
						if ($InsVehiculoProformaDetalle->VpdEliminado <> 2) {
							if ($InsVehiculoProformaDetalle->MtdRegistrarVehiculoProformaDetalle()) {

								$InsVehiculoIngreso = new ClsVehiculoIngreso();

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VprId", $this->VprId, $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoProforma", $this->VprAno, $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinMesProforma", $this->VprMes, $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroProforma", $this->VprCodigo, $InsVehiculoProformaDetalle->EinId);



								$validar++;
							} else {
								$Resultado .= '#ERR_VPR_201';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							$validar++;
						}
					} else {
						if ($InsVehiculoProformaDetalle->VpdEliminado == 2) {
							if ($InsVehiculoProformaDetalle->MtdEliminarVehiculoProformaDetalle($InsVehiculoProformaDetalle->VpdId)) {

								$InsVehiculoIngreso = new ClsVehiculoIngreso();

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VprId", "", $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoProforma", "", $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinMesProforma", "", $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroProforma", "", $InsVehiculoProformaDetalle->EinId);



								$validar++;
							} else {
								$Resultado .= '#ERR_VPR_203';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						} else {
							if ($InsVehiculoProformaDetalle->MtdEditarVehiculoProformaDetalle()) {


								$InsVehiculoIngreso = new ClsVehiculoIngreso();

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("VprId", $this->VprId, $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinAnoProforma", $this->VprAno, $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinMesProforma", $this->VprMes, $InsVehiculoProformaDetalle->EinId);

								$InsVehiculoIngreso->MtdEditarVehiculoIngresoDato("EinNumeroProforma", $this->VprCodigo, $InsVehiculoProformaDetalle->EinId);

								$validar++;
							} else {
								$Resultado .= '#ERR_VPR_202';
								$Resultado .= '#Item Numero: ' . ($validar + 1);
							}
						}
					}
				}

				if (count($this->VehiculoProformaDetalle) <> $validar) {
					$error = true;
				}
			}
		}


		if ($error) {
			$this->InsMysql->MtdTransaccionDeshacer();
			return false;
		} else {
			$this->InsMysql->MtdTransaccionHacer();
			$this->MtdAuditarVehiculoProforma(1, "Se edito la Proforma de Vehiculos", $this);
			return true;
		}
	}



	private function MtdAuditarVehiculoProforma($oAccion, $oDescripcion, $oDatos, $oCodigo = NULL, $oUsuario = NULL, $oPersonal = NULL)
	{

		$InsAuditoria = new ClsAuditoria($this->InsMysql);
		$InsAuditoria->AudCodigo = $this->VprId;

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



	public function MtdVerificarExisteVehiculoProforma($oCampo, $oDato)
	{

		$Respuesta =   NULL;

		$sql = 'SELECT 
			VprId
			FROM tblvprvehiculoproforma
			WHERE ' . $oCampo . ' = "' . $oDato . '" LIMIT 1;';

		$resultado = $this->InsMysql->MtdConsultar($sql);

		if ($this->InsMysql->MtdObtenerDatosTotal($resultado) > 0) {

			$fila = $this->InsMysql->MtdObtenerDatos($resultado);
			$Respuesta = $fila['VprId'];
		}

		return $Respuesta;
	}
}
