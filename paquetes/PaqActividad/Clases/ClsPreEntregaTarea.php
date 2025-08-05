<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPreEntregaTarea
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPreEntregaTarea {

    public $PetId;
    public $PetNombre;
	public $PesId;
	public $PetOrden;
	
    public $PetEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
//		
    public function MtdObtenerPreEntregaTarea(){

        $sql = 'SELECT 
        pet.PetId,
        pet.PetNombre,
		pet.PesId,
		pet.PetOrden
        FROM tblpetpreentregatarea pet
        WHERE pet.PetId = "'.$this->PetId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PetId = $fila['PetId'];
			$this->PetNombre = $fila['PetNombre'];
			$this->PesId = $fila['PesId'];

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPreEntregaTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PetId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSeccion=NULL) {

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
		
		if(!empty($oSeccion)){
			$seccion = ' AND PesId = "'.$oSeccion.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				PetId,
				PetNombre,
				PesId,
				PetOrden
				FROM tblpetpreentregatarea
				WHERE  1 = 1'.$filtrar.$seccion.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPreEntregaTarea = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$PreEntregaTarea = new $InsPreEntregaTarea();
                    $PreEntregaTarea->PetId = $fila['PetId'];
                    $PreEntregaTarea->PetNombre = $fila['PetNombre'];
					$PreEntregaTarea->PesId = $fila['PesId'];
					$PreEntregaTarea->PetOrden = $fila['PetOrden'];

					$PreEntregaTarea->InsMysql = NULL;      
					$Respuesta['Datos'][]= $PreEntregaTarea;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		

	
	
}
?>