<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoMantenimientoObsequio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoMantenimientoObsequio
{

	public $OvmId;
	public $OvvId;
	public $EinId;

	public $OvmKilometraje;
	public $VmbFechaVenta;
	public $VmbFechaVencimiento;

	public $VmbDiaTranscurrido;
	public $VmbVehiculoKilometraje;
	public $VmbMantenimientoKilometraje;
	public $VmbCantidadMantenimientos;

	public $VmbEstado;
	public $VmbTiempoCreacion;
	public $VmbTiempoModificacion;
	public $VmbEliminado;

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


	public function MtdObtenerVehiculoMantenimientoObsequios($oCampo = NULL, $oFiltro = NULL, $oOrden = 'OvmId', $oSentido = 'Desc', $oPaginacion = '0,10', $oVehiculoIngresoId = NULL)
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



		if (!empty($oVehiculoIngresoId)) {
			$vingreso = ' AND EinId = "' . $oVehiculoIngresoId . '"';
		}

		$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				ovm.OvmId,
				ovm.OvvId,
				ovm.EinId,
	
				ovm.OvmKilometraje,
				DATE_FORMAT(ovm.VmbFechaVenta, "%d/%m/%Y") AS "NVmbFechaVenta",
				ovm.VmbFechaVencimiento,
				
				ovm.VmbDiaTranscurrido,
				ovm.VmbVehiculoKilometraje,
				ovm.VmbMantenimientoKilometraje,
				ovm.VmbCantidadMantenimientos
				
				FROM visvmbvehiculomantenimientoobsequio
				WHERE  1 = 1' . $filtrar . $vingreso . $orden . $paginacion;

		$resultado = $this->InsMysql->MtdConsultar($sql);

		$Respuesta['Datos'] = array();

		$InsVehiculoMantenimientoObsequio = get_class($this);

		while ($fila = $this->InsMysql->MtdObtenerDatos($resultado)) {
			$VehiculoMantenimientoObsequio = new $InsVehiculoMantenimientoObsequio();
			$VehiculoMantenimientoObsequio->OvmId = $fila['OvmId'];
			$VehiculoMantenimientoObsequio->OvvId = $fila['OvvId'];
			$VehiculoMantenimientoObsequio->EinId = $fila['EinId'];
			$VehiculoMantenimientoObsequio->OvmKilometraje = $fila['OvmKilometraje'];
			$VehiculoMantenimientoObsequio->VmbFechaVenta = $fila['NVmbFechaVenta'];

			$VehiculoMantenimientoObsequio->VmbFechaVencimiento = $fila['VmbFechaVencimiento'];
			$VehiculoMantenimientoObsequio->VmbDiaTranscurrido = $fila['VmbDiaTranscurrido'];
			$VehiculoMantenimientoObsequio->VmbVehiculoKilometraje = $fila['VmbVehiculoKilometraje'];

			$VehiculoMantenimientoObsequio->VmbMantenimientoKilometraje = $fila['VmbMantenimientoKilometraje'];
			$VehiculoMantenimientoObsequio->VmbCantidadMantenimientos = $fila['VmbCantidadMantenimientos'];

			$VehiculoMantenimientoObsequio->InsMysql = NULL;
			$Respuesta['Datos'][] = $VehiculoMantenimientoObsequio;
		}

		$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL', true);

		$Respuesta['Total'] = $filaTotal['TOTAL'];
		$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);



		return $Respuesta;
	}
}
