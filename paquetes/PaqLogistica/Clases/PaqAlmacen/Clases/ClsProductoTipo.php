<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoTipo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoTipo {

    public $RtiId;
    public $RtiNombre;
    public $RtiTiempoCreacion;
    public $RtiTiempoModificacion;
    public $RtiEliminado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarProductoTipoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RtiId,5),unsigned)) AS "MAXIMO"
			FROM tblrtiproductotipo';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RtiId = "RTI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RtiId = "RTI-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerProductoTipo(){

        $sql = 'SELECT 
        rti.RtiId,
        rti.RtiNombre,
		DATE_FORMAT(rti.RtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRtiTiempoCreacion",
        DATE_FORMAT(rti.RtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRtiTiempoModificacion"	
        FROM tblrtiproductotipo rti
		WHERE rti.RtiId = "'.$this->RtiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->RtiId = $fila['RtiId'];
            $this->RtiNombre = $fila['RtiNombre'];
			$this->RtiTiempoCreacion = $fila['NRtiTiempoCreacion'];
			$this->RtiTiempoModificacion = $fila['NRtiTiempoModificacion']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerProductoTipos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RtiId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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
				RtiId,
				RtiNombre,
				DATE_FORMAT(RtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRtiTiempoCreacion",
                DATE_FORMAT(RtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRtiTiempoModificacion"				
				FROM tblrtiproductotipo
				WHERE 1  = 1 '.$filtrar.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoTipo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$ProductoTipo = new $InsProductoTipo();
                    $ProductoTipo->RtiId = $fila['RtiId'];
                    $ProductoTipo->RtiNombre= $fila['RtiNombre'];
                    $ProductoTipo->RtiTiempoCreacion = $fila['NRtiTiempoCreacion'];
                    $ProductoTipo->RtiTiempoModificacion = $fila['NRtiTiempoModificacion'];    
					
					$ProductoTipo->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$ProductoTipo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarProductoTipo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (RtiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (RtiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tblrtiproductotipo WHERE '.$eliminar;
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarProductoTipo() {
	
			$this->MtdGenerarProductoTipoId();
			
			$sql = 'INSERT INTO tblrtiproductotipo (
			RtiId,
			RtiNombre, 
			RtiTiempoCreacion,
			RtiTiempoModificacion,
			RtiEliminado) 
			VALUES (
			"'.($this->RtiId).'", 
			"'.htmlentities($this->RtiNombre).'", 
			"'.($this->RtiTiempoCreacion).'", 
			"'.($this->RtiTiempoModificacion).'", 				
			'.($this->RtiEliminado).');';					

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarProductoTipo() {
		
			$sql = 'UPDATE tblrtiproductotipo SET 
			 RtiNombre = "'.($this->RtiNombre).'",
			 RtiTiempoModificacion = "'.($this->RtiTiempoModificacion).'"
			 WHERE RtiId = "'.($this->RtiId).'";';
			
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}	
		
		
		
		
	
}
?>