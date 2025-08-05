<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoVehiculoModelo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoVehiculoModelo {

    public $PvmId;
	public $ProId;
	public $VveId;
    public $PvmTiempoCreacion;
    public $PvmTiempoModificacion;
    public $PvmEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

    public function MtdObtenerProductoVehiculoModelos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PvmId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL) {

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
		
		
		if(!empty($oProducto)){
			$producto = ' AND pvv.ProId = "'.($oProducto).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pvv.PvvId,
				
				pvv.ProId,
				
				pvv.VveId,
				vmo.VmaId,
				vve.VmoId,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre

				FROM tblpvvproductovehiculoversion pvv
					LEFT JOIN tblvvevehiculoversion vve
					ON pvv.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId

				WHERE  1 = 1 '.$filtrar.$producto.' GROUP BY vve.VmoId '.$orden.'  '.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoVehiculoModelo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ProductoVehiculoModelo = new $InsProductoVehiculoModelo();
                    $ProductoVehiculoModelo->PvvId = $fila['PvmPvvIdId'];
					$ProductoVehiculoModelo->ProId = $fila['ProId'];
					
					
					$ProductoVehiculoModelo->VmaId = $fila['VmaId'];
					$ProductoVehiculoModelo->VmoId = $fila['VmoId'];
					$ProductoVehiculoModelo->VveId = $fila['VveId'];
					
					$ProductoVehiculoModelo->VmaNombre = $fila['VmaNombre'];
					$ProductoVehiculoModelo->VmoNombre = $fila['VmoNombre'];
					$ProductoVehiculoModelo->VveNombre = $fila['VveNombre'];

				
					$ProductoVehiculoModelo->InsMysql = NULL;      
					$Respuesta['Datos'][]= $ProductoVehiculoModelo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	
}
?>