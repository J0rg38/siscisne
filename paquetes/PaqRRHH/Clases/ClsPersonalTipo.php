<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPersonalTipo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPersonalTipo {

    public $PtiId;
    public $PtiNombre;
	public $PtiDescripcion;
	public $PtiEstado;
    public $PtiTiempoCreacion;
    public $PtiTiempoModificacion;
    public $PtiEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	public function MtdGenerarPersonalTipoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PtiId,5),unsigned)) AS "MAXIMO"
			FROM tblptipersonaltipo';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PtiId = "PTI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->PtiId = "PTI-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerPersonalTipo(){

        $sql = 'SELECT 
        PtiId,
        PtiNombre,
		PtiDescripcion,
		PtiEstado,
		DATE_FORMAT(PtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPtiTiempoCreacion",
        DATE_FORMAT(PtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPtiTiempoModificacion"
        FROM tblptipersonaltipo
        WHERE PtiId = "'.$this->PtiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PtiId = $fila['PtiId'];
			$this->PtiNombre = $fila['PtiNombre'];
			$this->PtiDescripcion = $fila['PtiDescripcion'];
			$this->PtiEstado = $fila['PtiEstado'];
			$this->PtiTiempoCreacion = $fila['NPtiTiempoCreacion'];
			$this->PtiTiempoModificacion = $fila['NPtiTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPersonalTipos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PtiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

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
		
		if(!empty($oEstado)){
			$estado = ' pti.PtiEstado = '.($oEstado);
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pti.PtiId,
				pti.PtiNombre,
				pti.PtiDescripcion,
				pti.PtiEstado,
				DATE_FORMAT(pti.PtiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPtiTiempoCreacion",
                DATE_FORMAT(pti.PtiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPtiTiempoModificacion"				
				FROM tblptipersonaltipo pti
				WHERE 1 = 1 '.$filtrar.$estado.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPersonalTipo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$PersonalTipo = new $InsPersonalTipo();
                    $PersonalTipo->PtiId = $fila['PtiId'];
					$PersonalTipo->PtiNombre= $fila['PtiNombre'];
					$PersonalTipo->PtiDescripcion= $fila['PtiDescripcion'];
					$PersonalTipo->PtiEstado= $fila['PtiEstado'];
                    $PersonalTipo->PtiTiempoCreacion = $fila['NPtiTiempoCreacion'];
                    $PersonalTipo->PtiTiempoModificacion = $fila['NPtiTiempoModificacion'];                    
                    $PersonalTipo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PersonalTipo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarPersonalTipo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PtiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PtiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblptipersonaltipo WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarPersonalTipo() {
	
			$this->MtdGenerarPersonalTipoId();
		
			$sql = 'INSERT INTO tblptipersonaltipo (
			PtiId,
			PtiNombre, 
			PtiDescripcion,
			PtiEstado,
			PtiTiempoCreacion,
			PtiTiempoModificacion
			) 
			VALUES (
			"'.($this->PtiId).'", 
			"'.($this->PtiNombre).'", 
			"'.($this->PtiDescripcion).'",
			'.($this->PtiEstado).',
			"'.($this->PtiTiempoCreacion).'", 
			"'.($this->PtiTiempoModificacion).'");';

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
	
	public function MtdEditarPersonalTipo() {
		
		$sql = 'UPDATE tblptipersonaltipo SET 
		 PtiNombre = "'.($this->PtiNombre).'",
		 PtiDescripcion = "'.($this->PtiDescripcion).'",
		 PtiEstado = '.($this->PtiEstado).',
		 PtiTiempoModificacion = "'.($this->PtiTiempoModificacion).'"
		 WHERE PtiId = "'.($this->PtiId).'";';
		
		
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