<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoTipo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoTipo {

    public $VtiId;
    public $VtiNombre;
	public $VtiEstado;
    public $VtiTiempoCreacion;
    public $VtiTiempoModificacion;
    public $VtiEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarVehiculoTipoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VtiId,5),unsigned)) AS "MAXIMO"
			FROM tblvtivehiculotipo';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VtiId ="VTI-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VtiId = "VTI-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoTipo(){

        $sql = 'SELECT 
        vti.VtiId,
        vti.VtiNombre,
		vti.VtiEstado,
		DATE_FORMAT(vti.VtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVtiTiempoCreacion",
        DATE_FORMAT(vti.VtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVtiTiempoModificacion"
        FROM tblvtivehiculotipo vti
        WHERE vti.VtiId = "'.$this->VtiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VtiId = $fila['VtiId'];
			$this->VtiNombre = $fila['VtiNombre'];
			$this->VtiEstado = $fila['VtiEstado'];
			$this->VtiTiempoCreacion = $fila['NVtiTiempoCreacion'];
			$this->VtiTiempoModificacion = $fila['NVtiTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoTipos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VtiId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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
				VtiId,
				VtiNombre,
				VtiEstado,
				DATE_FORMAT(VtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVtiTiempoCreacion",
                DATE_FORMAT(VtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVtiTiempoModificacion"				
				FROM tblvtivehiculotipo
				WHERE  1 = 1'.$filtrar.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoTipo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoTipo = new $InsVehiculoTipo();
                    $VehiculoTipo->VtiId = $fila['VtiId'];
                    $VehiculoTipo->VtiNombre = $fila['VtiNombre'];
					$VehiculoTipo->VtiEstado = $fila['VtiEstado'];
                    $VehiculoTipo->VtiTiempoCreacion = $fila['NVtiTiempoCreacion'];
                    $VehiculoTipo->VtiTiempoModificacion = $fila['NVtiTiempoModificacion'];
					$VehiculoTipo->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoTipo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoTipo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VtiId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VtiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VtiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvtivehiculotipo WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoTipo() {
	
		$this->MtdGenerarVehiculoTipoId();
			
			$sql = 'INSERT INTO tblvtivehiculotipo (
				VtiId,
				VtiNombre, 
				VtiEstado,
				VtiTiempoCreacion,
				VtiTiempoModificacion) 
				VALUES (
				"'.($this->VtiId).'", 
				"'.($this->VtiNombre).'", 
				'.($this->VtiEstado).', 
				"'.($this->VtiTiempoCreacion).'", 
				"'.($this->VtiTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoTipo() {
		
			$sql = 'UPDATE tblvtivehiculotipo SET 
				 VtiNombre = "'.($this->VtiNombre).'",
				 VtiEstado = '.($this->VtiEstado).',
				 VtiTiempoModificacion = "'.($this->VtiTiempoModificacion).'"
				 WHERE VtiId = "'.($this->VtiId).'";';
				 
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
		
	
	
	 public function MtdIdentificarVehiculoTipo(){
		
        $sql = 'SELECT 
        VtiId
        FROM tblvtivehiculotipo
        WHERE VtiNombre = "'.htmlentities($this->VtiNombre).'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->VtiId = $fila['VtiId'];
			}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
}
?>