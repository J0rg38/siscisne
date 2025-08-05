<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoColor
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoColor {

	public $VehId;
    public $VcoNombre;
	
	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

    public function MtdObtenerVehiculoColores($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL) {

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
		
		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.($oVehiculoMarca).'"';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.($oVehiculoModelo).'"';
		}
		
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND vve.VveId = "'.($oVehiculoVersion).'"';
		}
			
		if(!empty($oVehiculoTipo)){
			$vtipo = ' AND vmo.VtiId = "'.($oVehiculoTipo).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				veh.VehId,
				veh.VehColor AS VcoNombre
				FROM tblvehvehiculo veh
					LEFT JOIN tblvvevehiculoversion vve
					ON veh.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
				WHERE  1 = 1 '.$filtrar.$vmarca.$vmodelo.$vversion.$vtipo.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoColor = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoColor = new $InsVehiculoColor();
                    $VehiculoColor->VehId = $fila['VehId'];
                    $VehiculoColor->VcoNombre = $fila['VcoNombre'];
					$VehiculoColor->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoColor;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	
}
?>