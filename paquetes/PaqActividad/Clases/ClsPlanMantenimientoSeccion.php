<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPlanMantenimientoSeccion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPlanMantenimientoSeccion {

    public $PmsId;
    public $PmsNombre;
    public $PmsEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	//public function MtdGenerarPlanMantenimientoSeccionId() {
//
//			$sql = 'SELECT	
//			MAX(CONVERT(SUBSTR(PmsId,5),unsigned)) AS "MAXIMO"
//			FROM tblpmsplanmantenimientoseccion';
//			
//			$resultado = $this->InsMysql->MtdConsultar($sql);                       
//			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//			
//			if(empty($fila['MAXIMO'])){			
//				$this->PmsId ="PMS-10000";
//			}else{
//				$fila['MAXIMO']++;
//				$this->PmsId = "PMS-".$fila['MAXIMO'];					
//			}		
//					
//		}
//		
//    public function MtdObtenerPlanMantenimientoSeccion(){
//
//        $sql = 'SELECT 
//        vti.PmsId,
//        vti.PmsNombre,
//		vti.PmsEstado,
//		DATE_FORMAT(vti.PmsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPmsTiempoCreacion",
//        DATE_FORMAT(vti.PmsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPmsTiempoModificacion"
//        FROM tblpmsplanmantenimientoseccion vti
//        WHERE vti.PmsId = "'.$this->PmsId.'";';
//		
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//
//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
//		
//        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
//        {
//			$this->PmsId = $fila['PmsId'];
//			$this->PmsNombre = $fila['PmsNombre'];
//			$this->PmsEstado = $fila['PmsEstado'];
//			$this->PmsTiempoCreacion = $fila['NPmsTiempoCreacion'];
//			$this->PmsTiempoModificacion = $fila['NPmsTiempoModificacion']; 
//				
//		}
//        
//			$Respuesta =  $this;
//			
//		}else{
//			$Respuesta =   NULL;
//		}
//		
//        
//		return $Respuesta;
//
//    }

    public function MtdObtenerPlanMantenimientoSecciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmsId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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
				PmsId,
				PmsNombre
				FROM tblpmsplanmantenimientoseccion
				WHERE  1 = 1'.$filtrar.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPlanMantenimientoSeccion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$PlanMantenimientoSeccion = new $InsPlanMantenimientoSeccion();
                    $PlanMantenimientoSeccion->PmsId = $fila['PmsId'];
                    $PlanMantenimientoSeccion->PmsNombre = $fila['PmsNombre'];
					$PlanMantenimientoSeccion->InsMysql = NULL;      
					$Respuesta['Datos'][]= $PlanMantenimientoSeccion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	//
//	//Accion eliminar	 
//	
//	public function MtdEliminarPlanMantenimientoSeccion($oElementos) {
//		
//		$elementos = explode("#",$oElementos);
//		
//		if(!count($elementos)){
//			$eliminar .= ' PmsId = "'.($oElementos).'"';
//		}else{
//			$i=1;
//			foreach($elementos as $elemento){
//				if(!empty($elemento)){
//				
//					if($i==count($elementos)){						
//						$eliminar .= '  (PmsId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (PmsId = "'.($elemento).'")  OR';	
//					}	
//				}
//			$i++;
//	
//			}
//		}
//		
//			$sql = 'DELETE FROM tblpmsplanmantenimientoseccion WHERE '.$eliminar;
//			
//		
//			
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}							
//	}
//	
//	
//	public function MtdRegistrarPlanMantenimientoSeccion() {
//	
//		$this->MtdGenerarPlanMantenimientoSeccionId();
//			
//			$sql = 'INSERT INTO tblpmsplanmantenimientoseccion (
//				PmsId,
//				PmsNombre, 
//				PmsEstado,
//				PmsTiempoCreacion,
//				PmsTiempoModificacion) 
//				VALUES (
//				"'.($this->PmsId).'", 
//				"'.($this->PmsNombre).'", 
//				'.($this->PmsEstado).', 
//				"'.($this->PmsTiempoCreacion).'", 
//				"'.($this->PmsTiempoModificacion).'");';	
//				
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}			
//			
//	}
//	
//	public function MtdEditarPlanMantenimientoSeccion() {
//		
//			$sql = 'UPDATE tblpmsplanmantenimientoseccion SET 
//				 PmsNombre = "'.($this->PmsNombre).'",
//				 PmsEstado = '.($this->PmsEstado).',
//				 PmsTiempoModificacion = "'.($this->PmsTiempoModificacion).'"
//				 WHERE PmsId = "'.($this->PmsId).'";';
//				 
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}						
//				
//		}	
//		
//	
//	
//	 public function MtdIdentificarPlanMantenimientoSeccion(){
//		
//        $sql = 'SELECT 
//        PmsId
//        FROM tblpmsplanmantenimientoseccion
//        WHERE PmsNombre = "'.htmlentities($this->PmsNombre).'"';
//		
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//
//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
//		
//			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
//			{
//				$this->PmsId = $fila['PmsId'];
//			}
//        
//			$Respuesta =  $this;
//			
//		}else{
//			$Respuesta =   NULL;
//		}
//		
//        
//		return $Respuesta;
//
//    }
	
	
}
?>