<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsModalidadIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsModalidadIngreso {

    public $MinId;
    public $MinNombre;
	public $MinSigla;
	public $MinDescripcion;	
	public $MinUso;
	public $MinEstado;
    public $MinTiempoCreacion;
    public $MinTiempoModificacion;
    public $MinEliminado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarModalidadIngresoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(MinId,5),unsigned)) AS "MAXIMO"
			FROM tblminmodalidadingreso';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->MinId = "MIN-10000";
			}else{
				$fila['MAXIMO']++;
				$this->MinId = "MIN-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerModalidadIngreso(){

        $sql = 'SELECT 
        min.MinId,
        min.MinNombre,
		min.MinSigla,
		min.MinDescripcion,
		min.MinUso,
		DATE_FORMAT(min.MinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMinTiempoCreacion",
        DATE_FORMAT(min.MinTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMinTiempoModificacion"	
        FROM tblminmodalidadingreso min
		WHERE min.MinId = "'.$this->MinId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->MinId = $fila['MinId'];
            $this->MinNombre = $fila['MinNombre'];
			$this->MinSigla = $fila['MinSigla'];
			$this->MinDescripcion = $fila['MinDescripcion'];
			$this->MinUso = $fila['MinUso'];
			$this->MinEstado = $fila['MinEstado'];
			$this->MinTiempoCreacion = $fila['NMinTiempoCreacion'];
			$this->MinTiempoModificacion = $fila['NMinTiempoModificacion']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerModalidadIngresos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'MinId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL,$oEstado=NULL) {

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
		

		if(!empty($oUso)){

			$elementos = explode(",",$oUso);

			$i=1;
			$uso .= ' AND (
			(';
			$elementos = array_filter($elementos);
			foreach($elementos as $elemento){
				$uso .= '  (MinUso = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$uso .= ' OR ';	
				}
			$i++;		
			}

			$uso .= ' ) 
			)
			';

		}

//		if(!empty($oUso)){
//			$uso = ' AND MinUso = '.$oUso;
//		}

		if(!empty($oEstado)){
			$estado = ' AND MinEstado = '.$oEstado;
		}


			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				MinId,
				MinNombre,
				MinSigla,
				MinDescripcion,
				MinUso,
				MinEstado,
				DATE_FORMAT(MinTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMinTiempoCreacion",
                DATE_FORMAT(MinTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMinTiempoModificacion"				
				FROM tblminmodalidadingreso
				WHERE 1  = 1 '.$filtrar.$estado.$uso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsModalidadIngreso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$ModalidadIngreso = new $InsModalidadIngreso();
                    $ModalidadIngreso->MinId = $fila['MinId'];
                    $ModalidadIngreso->MinNombre= $fila['MinNombre'];
					$ModalidadIngreso->MinSigla = $fila['MinSigla'];
					$ModalidadIngreso->MinDescripcion= $fila['MinDescripcion'];
					
					
					$ModalidadIngreso->MinUso= $fila['MinUso'];
					$ModalidadIngreso->MinEstado= $fila['MinEstado'];
                    $ModalidadIngreso->MinTiempoCreacion = $fila['NMinTiempoCreacion'];
                    $ModalidadIngreso->MinTiempoModificacion = $fila['NMinTiempoModificacion'];    
					
					$ModalidadIngreso->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$ModalidadIngreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarModalidadIngreso($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (MinId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (MinId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tblminmodalidadingreso WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarModalidadIngreso() {
	
			$this->MtdGenerarModalidadIngresoId();
			
			$sql = 'INSERT INTO tblminmodalidadingreso (
			MinId,
			MinNombre, 
			MinSigla,
			MinDescripcion,
			MinUso,
			MinEstado,
			MinTiempoCreacion,
			MinTiempoModificacion,
			MinEliminado) 
			VALUES (
			"'.($this->MinId).'", 
			"'.($this->MinNombre).'", 
			"'.($this->MinSigla).'", 
			"'.($this->MinDescripcion).'", 
			'.($this->MinUso).', 
			'.($this->MinEstado).', 
			"'.($this->MinTiempoCreacion).'", 
			"'.($this->MinTiempoModificacion).'", 				
			'.($this->MinEliminado).');';					

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
	
	public function MtdEditarModalidadIngreso() {
		
			$sql = 'UPDATE tblminmodalidadingreso SET 
			 MinNombre = "'.($this->MinNombre).'",
			 MinSigla = "'.($this->MinSigla).'",
			 MinDescripcion = "'.($this->MinDescripcion).'",
			 MinUso = '.($this->MinUso).',			 
			 MinEstado = '.($this->MinEstado).',
			 MinTiempoModificacion = "'.($this->MinTiempoModificacion).'"
			 WHERE MinId = "'.($this->MinId).'";';
		
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