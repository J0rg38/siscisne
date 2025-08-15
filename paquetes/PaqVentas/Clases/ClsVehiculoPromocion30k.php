<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoPromocion30k
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoPromocion30k
{

	public $P30Id;
	public $P30Nombre;
	public $P30NombreComercial;
	public $P30Foto;
	public $P30VigenciaVenta;
	public $P30Estado;
	public $P30TiempoCreacion;
	public $P30TiempoModificacion;
	public $P30Eliminado;

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



	public function MtdObtenerVehiculoPromocion30ks($oCampo = NULL, $oFiltro = NULL, $oOrden = 'P30Id', $oSentido = 'Desc', $oPaginacion = '0,10', $oVehiculoIngresoId = NULL)
	{

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

		if (!empty($oVigenciaVenta)) {
			$vventa = ' AND P30VigenciaVenta = ' . $oVigenciaVenta;
		}

		if (!empty($oVehiculoIngresoId)) {
			$vingreso = ' AND EinId = "' . $oVehiculoIngresoId . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				OvvId,
				DATE_FORMAT(OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				EinId,
				
				CliNombre,
				CliApellidoPaterno,
				CliApellidoMaterno,
				
				VmaNombre,
				VmoNombre,
				VveNombre,
				
				EinVIN,
				EinPlaca
				
				FinId1000,
				DATE_FORMAT(FinFecha1000, "%d/%m/%Y") AS "NFinFecha1000",
				
				FinId5000,
				DATE_FORMAT(FinFecha5000, "%d/%m/%Y") AS "NFinFecha5000",
				
				FinId10000,
				DATE_FORMAT(FinFecha10000, "%d/%m/%Y") AS "NFinFecha10000",
				
				FinId15000,
				DATE_FORMAT(FinFecha15000, "%d/%m/%Y") AS "NFinFecha15000",
				
				FinId20000,
				DATE_FORMAT(FinFecha20000, "%d/%m/%Y") AS "NFinFecha20000",
				
				FinId25000,
				DATE_FORMAT(FinFecha25000, "%d/%m/%Y") AS "NFinFecha25000",
				
				FinId30000,
				DATE_FORMAT(FinFecha30000, "%d/%m/%Y") AS "NFinFecha30000"
				
				FROM visp30promocion30k
				WHERE  1 = 1' . $filtrar . $vingreso . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsVehiculoPromocion30k = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$VehiculoPromocion30k = new $InsVehiculoPromocion30k();
			$VehiculoPromocion30k->OvvId = $fila['OvvId'];
			$VehiculoPromocion30k->OvvFecha = $fila['NOvvFecha'];
			$VehiculoPromocion30k->CliNombre = $fila['CliNombre'];
			$VehiculoPromocion30k->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$VehiculoPromocion30k->CliApellidoMaterno = $fila['CliApellidoMaterno'];

			$VehiculoPromocion30k->VmaNombre = $fila['VmaNombre'];
			$VehiculoPromocion30k->VmoNombre = $fila['VmoNombre'];
			$VehiculoPromocion30k->VveNombre = $fila['VveNombre'];

			$VehiculoPromocion30k->EinVIN = $fila['EinVIN'];
			$VehiculoPromocion30k->EinPlaca = $fila['EinPlaca'];

			$VehiculoPromocion30k->FinId1000 = $fila['FinId1000'];
			$VehiculoPromocion30k->FinFecha1000 = $fila['NFinFecha1000'];

			$VehiculoPromocion30k->FinId5000 = $fila['FinId5000'];
			$VehiculoPromocion30k->FinFecha5000 = $fila['NFinFecha5000'];

			$VehiculoPromocion30k->FinId10000 = $fila['FinId10000'];
			$VehiculoPromocion30k->FinFecha10000 = $fila['NFinFecha10000'];

			$VehiculoPromocion30k->FinId15000 = $fila['FinId15000'];
			$VehiculoPromocion30k->FinFecha15000 = $fila['NFinFecha15000'];

			$VehiculoPromocion30k->FinId20000 = $fila['FinId20000'];
			$VehiculoPromocion30k->FinFecha20000 = $fila['NFinFecha20000'];

			$VehiculoPromocion30k->FinId25000 = $fila['FinId25000'];
			$VehiculoPromocion30k->FinFecha25000 = $fila['NFinFecha25000'];

			$VehiculoPromocion30k->FinId30000 = $fila['FinId30000'];
			$VehiculoPromocion30k->FinFecha30000 = $fila['NFinFecha30000'];

			$VehiculoPromocion30k->InsMysql = NULL;
			$Respuesta['Datos'][] = $VehiculoPromocion30k;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);



		return $Respuesta;
	}
}
