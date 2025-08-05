<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoPromocion20k
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoPromocion20k {

    public $P20Id;
    public $P20Nombre;
	public $P20NombreComercial;
	public $P20Foto;
	public $P20VigenciaVenta;
	public $P20Estado;
    public $P20TiempoCreacion;
    public $P20TiempoModificacion;
    public $P20Eliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	


    public function MtdObtenerVehiculoPromocion20ks($oCampo=NULL,$oFiltro=NULL,$oOrden = 'P20Id',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoIngresoId=NULL) {

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
		
		if(!empty($oVigenciaVenta)){
			$vventa = ' AND P20VigenciaVenta = '.$oVigenciaVenta;
		}
		
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND EinId = "'.$oVehiculoIngresoId.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				OvvId,
				DATE_FORMAT(OvvFecha, "%d/%m/%Y") AS "NOvvFecha",
				CliNombre,
				CliApellidoPaterno,
				CliApellidoMaterno,
				
				VmaNombre,
				VmoNombre,
				VveNombre,
				
				EinVIN,
				EinPlaca,
				
				FinId1000,
				DATE_FORMAT(FinFecha1000, "%d/%m/%Y") AS "NFinFecha1000",
				
				FinId5000,
				DATE_FORMAT(FinFecha5000, "%d/%m/%Y") AS "NFinFecha5000",
				
				FinId10000,
				DATE_FORMAT(FinFecha10000, "%d/%m/%Y") AS "NFinFecha10000",
				
				FinId15000,
				DATE_FORMAT(FinFecha15000, "%d/%m/%Y") AS "NFinFecha15000",
				
				FinId20000,
				DATE_FORMAT(FinFecha20000, "%d/%m/%Y") AS "NFinFecha20000"
				
				FROM visp20promocion20k
				WHERE  1 = 1'.$filtrar.$vingreso.$estado.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoPromocion20k = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoPromocion20k = new $InsVehiculoPromocion20k();
                    $VehiculoPromocion20k->OvvId = $fila['OvvId'];
                    $VehiculoPromocion20k->OvvFecha = $fila['NOvvFecha'];
					$VehiculoPromocion20k->CliNombre = $fila['CliNombre'];
					$VehiculoPromocion20k->CliApellidoPaterno = $fila['CliApellidoPaterno'];					
					$VehiculoPromocion20k->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$VehiculoPromocion20k->VmaNombre = $fila['VmaNombre'];
                    $VehiculoPromocion20k->VmoNombre = $fila['VmoNombre'];
                    $VehiculoPromocion20k->VveNombre = $fila['VveNombre'];
					
					$VehiculoPromocion20k->EinVIN = $fila['EinVIN'];
					$VehiculoPromocion20k->EinPlaca = $fila['EinPlaca'];
					
					$VehiculoPromocion20k->FinId1000 = $fila['FinId1000'];
					$VehiculoPromocion20k->FinFecha1000 = $fila['NFinFecha1000'];
					
					$VehiculoPromocion20k->FinId5000 = $fila['FinId5000'];
					$VehiculoPromocion20k->FinFecha5000 = $fila['NFinFecha5000'];
					
					$VehiculoPromocion20k->FinId10000 = $fila['FinId10000'];
					$VehiculoPromocion20k->FinFecha10000 = $fila['NFinFecha10000'];
					
					$VehiculoPromocion20k->FinId15000 = $fila['FinId15000'];
					$VehiculoPromocion20k->FinFecha15000 = $fila['NFinFecha15000'];
					
					$VehiculoPromocion20k->FinId20000 = $fila['FinId20000'];
					$VehiculoPromocion20k->FinFecha20000 = $fila['NFinFecha20000'];
					
					$VehiculoPromocion20k->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoPromocion20k;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
}
?>