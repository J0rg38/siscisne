<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsMantenimientoTarea
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsMantenimientoTarea {

    public $VmaNombre;
	public $VmoNombre;
    public $FinMantenimientoKilometraje;
    public $PmtNombre;
    public $ProCodigoOriginal;
    public $ProNombre;
	
	public $UmeNombre;
	public $AmdCantidad;
	public $FinId;
	public $FinFecha;
	public $ProId;
	public $UmeId;
	public $PmtId;
	public $VmaId;
	public $VmoId;

	
    public $InsMysql;

    public function __construct($oInsMysql=NULL)
	{

		if ($oInsMysql) {
			$this->InsMysql = $oInsMysql;
		} else {
			$this->InsMysql = new ClsMysql();
		}

	}
	
	public function __destruct(){

	}
	

    public function MtdObtenerMantenimientoTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmtId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoModelo=NULL,$oMantenimientoKilometraje=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND VmoId = "'.($oVehiculoModelo).'"';
		}
		
		if(!empty($oMantenimientoKilometraje)){
			$mkilometraje = ' AND FinMantenimientoKilometraje = "'.($oMantenimientoKilometraje).'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 

			mta.VmaNombre,
			mta.VmoNombre,
			mta.FinMantenimientoKilometraje,
			mta.PmtNombre,
			mta.ProCodigoOriginal,
			mta.ProNombre,
			
			mta.UmeNombre,
			mta.AmdCantidad,
			mta.FinId,
			mta.FinFecha,
			mta.ProId,
			mta.UmeId,
			mta.PmtId,
			mta.VmaId,
			mta.VmoId
			FROM vismtamantenimientotarea mta
				WHERE 1 = 1 '.$filtrar.$vmodelo.$mkilometraje.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsMantenimientoTarea = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$MantenimientoTarea = new $InsMantenimientoTarea();
                    $MantenimientoTarea->VmaNombre = $fila['VmaNombre'];
					$MantenimientoTarea->VmoNombre= $fila['VmoNombre'];
					$MantenimientoTarea->FinMantenimientoKilometraje= $fila['FinMantenimientoKilometraje'];
                    $MantenimientoTarea->ProCodigoOriginal = $fila['ProCodigoOriginal'];
                    $MantenimientoTarea->ProNombre = $fila['ProNombre'];
					
					$MantenimientoTarea->UmeNombre = $fila['UmeNombre'];
					$MantenimientoTarea->AmdCantidad = $fila['AmdCantidad'];
					$MantenimientoTarea->FinId = $fila['FinId'];
					$MantenimientoTarea->FinFecha = $fila['FinFecha'];
					$MantenimientoTarea->ProId = $fila['ProId'];
					$MantenimientoTarea->UmeId = $fila['UmeId'];
					$MantenimientoTarea->PmtId = $fila['PmtId'];
					$MantenimientoTarea->VmaId = $fila['VmaId'];
					$MantenimientoTarea->VmoId = $fila['VmoId'];
                    $MantenimientoTarea->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $MantenimientoTarea;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		
}
?>