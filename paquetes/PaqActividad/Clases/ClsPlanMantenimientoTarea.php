<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPlanMantenimientoTarea
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPlanMantenimientoTarea {

    public $PmtId;
    public $PmtNombre;
	public $PmsId;
	
    public $PmtEliminado;

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
	

	//public function MtdGenerarPlanMantenimientoTareaId() {
//
//			$sql = 'SELECT	
//			MAX(CONVERT(SUBSTR(PmtId,5),unsigned)) AS "MAXIMO"
//			FROM tblpmtplanmantenimientotarea';
//			
//			$resultado = $this->InsMysql->MtdConsultar($sql);                       
//			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//			
//			if(empty($fila['MAXIMO'])){			
//				$this->PmtId ="PMS-10000";
//			}else{
//				$fila['MAXIMO']++;
//				$this->PmtId = "PMS-".$fila['MAXIMO'];					
//			}		
//					
//		}
//		
    public function MtdObtenerPlanMantenimientoTarea(){

        $sql = 'SELECT 
        pmt.PmtId,
        pmt.PmtNombre,
		pmt.PmsId	
        FROM tblpmtplanmantenimientotarea pmt
        WHERE pmt.PmtId = "'.$this->PmtId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PmtId = $fila['PmtId'];
			$this->PmtNombre = $fila['PmtNombre'];
			$this->PmsId = $fila['PmsId'];

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerPlanMantenimientoTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmtId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSeccion=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$seccion = '';

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
			$seccion = ' AND PmsId = "'.$oSeccion.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				PmtId,
				PmtNombre,
				PmsId
				FROM tblpmtplanmantenimientotarea
				WHERE  1 = 1'.$filtrar.$seccion.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPlanMantenimientoTarea = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$PlanMantenimientoTarea = new $InsPlanMantenimientoTarea();
                    $PlanMantenimientoTarea->PmtId = $fila['PmtId'];
                    $PlanMantenimientoTarea->PmtNombre = $fila['PmtNombre'];
					$PlanMantenimientoTarea->PmsId = $fila['PmsId'];
					
					$PlanMantenimientoTarea->InsMysql = NULL;      
					$Respuesta['Datos'][]= $PlanMantenimientoTarea;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	//
//	//Accion eliminar	 
//	
//	public function MtdEliminarPlanMantenimientoTarea($oElementos) {
//		
//		$elementos = explode("#",$oElementos);
//		
//		if(!count($elementos)){
//			$eliminar .= ' PmtId = "'.($oElementos).'"';
//		}else{
//			$i=1;
//			foreach($elementos as $elemento){
//				if(!empty($elemento)){
//				
//					if($i==count($elementos)){						
//						$eliminar .= '  (PmtId = "'.($elemento).'")';	
//					}else{
//						$eliminar .= '  (PmtId = "'.($elemento).'")  OR';	
//					}	
//				}
//			$i++;
//	
//			}
//		}
//		
//			$sql = 'DELETE FROM tblpmtplanmantenimientotarea WHERE '.$eliminar;
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
//	public function MtdRegistrarPlanMantenimientoTarea() {
//	
//		$this->MtdGenerarPlanMantenimientoTareaId();
//			
//			$sql = 'INSERT INTO tblpmtplanmantenimientotarea (
//				PmtId,
//				PmtNombre, 
//				PmtEstado,
//				PmtTiempoCreacion,
//				PmtTiempoModificacion) 
//				VALUES (
//				"'.($this->PmtId).'", 
//				"'.($this->PmtNombre).'", 
//				'.($this->PmtEstado).', 
//				"'.($this->PmtTiempoCreacion).'", 
//				"'.($this->PmtTiempoModificacion).'");';	
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
//	public function MtdEditarPlanMantenimientoTarea() {
//		
//			$sql = 'UPDATE tblpmtplanmantenimientotarea SET 
//				 PmtNombre = "'.($this->PmtNombre).'",
//				 PmtEstado = '.($this->PmtEstado).',
//				 PmtTiempoModificacion = "'.($this->PmtTiempoModificacion).'"
//				 WHERE PmtId = "'.($this->PmtId).'";';
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
//	 public function MtdIdentificarPlanMantenimientoTarea(){
//		
//        $sql = 'SELECT 
//        PmtId
//        FROM tblpmtplanmantenimientotarea
//        WHERE PmtNombre = "'.htmlentities($this->PmtNombre).'"';
//		
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//
//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
//		
//			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
//			{
//				$this->PmtId = $fila['PmtId'];
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