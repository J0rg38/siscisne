<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPreEntregaSeccion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPreEntregaSeccion {

    public $PesId;
    public $PesNombre;
	public $PesOrden;
	
    public $PesEliminado;

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
	


    public function MtdObtenerPreEntregaSecciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PesId',$oSentido = 'Desc',$oPaginacion = '0,10') {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';

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
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				PesId,
				PesNombre,
				PesOrden
				
				FROM tblpespreentregaseccion
				WHERE  1 = 1'.$filtrar.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPreEntregaSeccion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$PreEntregaSeccion = new $InsPreEntregaSeccion();
                    $PreEntregaSeccion->PesId = $fila['PesId'];
                    $PreEntregaSeccion->PesNombre = $fila['PesNombre'];
					$PreEntregaSeccion->PesOrden = $fila['PesOrden'];
					
					$PreEntregaSeccion->InsMysql = NULL;      
					$Respuesta['Datos'][]= $PreEntregaSeccion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	
}
?>