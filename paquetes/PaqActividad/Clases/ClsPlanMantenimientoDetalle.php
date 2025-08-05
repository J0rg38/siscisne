<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPlanMantenimientoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPlanMantenimientoDetalle {

    public $PmdId;
	public $PmaId;
	public $PmtId;
	public $PmdAccion;
	public $PmdKilometraje;
    public $PmdEliminado;

	public $PmtNombre;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarPlanMantenimientoDetalleId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PmdId,5),unsigned)) AS "MAXIMO"
			FROM tblpmdplanmantenimientodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PmdId = "PMD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PmdId = "PMD-".$fila['MAXIMO'];					
			}
				
		}
		
		
  public function MtdObtenerPlanMantenimientoDetalle(){



        $sql = 'SELECT 
		pmd.PmdId,			
			pmd.PmaId,
			pmd.PmtId,
			pmd.PmdAccion,
			pmd.PmdKilometraje,
			pmt.PmtNombre,
			
			pma.VmaId
			
			FROM tblpmdplanmantenimientodetalle pmd
				LEFT JOIN tblpmtplanmantenimientotarea pmt
				ON pmd.PmtId = pmt.PmtId
					LEFT JOIN tblpmaplanmantenimiento pma
					ON pmd.PmaId = pma.PmaId
        WHERE PmdId = "'.$this->PmdId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PmdId = $fila['PmdId'];
			$this->PmaId = $fila['PmaId'];
            $this->PmtId = $fila['PmtId'];
            $this->PmdAccion = $fila['PmdAccion'];
			$this->PmdKilometraje = $fila['PmdKilometraje'];
			$this->PmtNombre = $fila['PmtNombre'];
			
			$this->VmaId = $fila['VmaId'];
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
			
	public function MtObtenerPlanMantenimientoDetalleAccion($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) {

		if(!empty($oPlanMantenimiento)){
			$pmantenimiento = ' AND pmd.PmaId = "'.$oPlanMantenimiento.'"';
		}
		
		if(!empty($oKilometraje)){
			$kilometraje = ' AND pmd.PmdKilometraje = "'.$oKilometraje.'"';
		}		
		
		if(!empty($oSeccion)){
			$seccion = ' AND pmt.PmsId = "'.$oSeccion.'"';
		}	
		
		if(!empty($oTarea)){
			$tarea = ' AND pmd.PmtId = "'.$oTarea.'"';
		}	
		
		 $sql = '
			SELECT
			pmd.PmdAccion
			FROM tblpmdplanmantenimientodetalle pmd
				LEFT JOIN tblpmtplanmantenimientotarea pmt
				ON pmd.PmtId = pmt.PmtId
			WHERE  1 = 1 '.$pmantenimiento.$kilometraje.$seccion.$tarea.' 

			ORDER BY pmd.PmdId DESC
			
			LIMIT 1';	
		
//		echo "<br><br>";
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		return  strtoupper($fila['PmdAccion']);
	}
	
	public function MtObtenerPlanMantenimientoDetalleId($oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) {

		if(!empty($oPlanMantenimiento)){
			$pmantenimiento = ' AND pmd.PmaId = "'.$oPlanMantenimiento.'"';
		}
		
		if(!empty($oKilometraje)){
			$kilometraje = ' AND pmd.PmdKilometraje = "'.$oKilometraje.'"';
		}		
		
		if(!empty($oSeccion)){
			$seccion = ' AND pmt.PmsId = "'.$oSeccion.'"';
		}	
		
		if(!empty($oTarea)){
			$tarea = ' AND pmd.PmtId = "'.$oTarea.'"';
		}	
		
		$sql = '
			SELECT
			pmd.PmdId
			FROM tblpmdplanmantenimientodetalle pmd
				LEFT JOIN tblpmtplanmantenimientotarea pmt
				ON pmd.PmtId = pmt.PmtId
			WHERE  1 = 1 '.$pmantenimiento.$kilometraje.$seccion.$tarea.'

				ORDER BY pmd.PmdId DESC
			
			LIMIT 1
			';	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		return  ($fila['PmdId']);
	}
		
		
    public function MtdObtenerPlanMantenimientoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PmdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oPlanMantenimiento=NULL,$oKilometraje=NULL,$oSeccion=NULL,$oTarea=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){

			$oFiltro = str_replace(" ","%",$oFiltro);			
			$elementos = explode(",",$oCampo);

			$i=1;
			$filtrar .= '  AND (';
			foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oPlanMantenimiento)){
			$pmantenimiento = ' AND pmd.PmaId = "'.$oPlanMantenimiento.'"';
		}
		
		if(!empty($oKilometraje)){
			$kilometraje = ' AND pmd.PmdKilometraje = "'.$oKilometraje.'"';
		}		
		
		if(!empty($oSeccion)){
			$seccion = ' AND pmt.PmsId = "'.$oSeccion.'"';
		}	
		
		if(!empty($oTarea)){
			$tarea = ' AND pmd.PmtID = "'.$oTarea.'"';
		}	
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pmd.PmdId,			
			pmd.PmaId,
			pmd.PmtId,
			pmd.PmdAccion,
			pmd.PmdKilometraje,
			pmt.PmtNombre
			FROM tblpmdplanmantenimientodetalle pmd
				LEFT JOIN tblpmtplanmantenimientotarea pmt
				ON pmd.PmtId = pmt.PmtId
					
			WHERE  1 = 1 '.$pmantenimiento.$kilometraje.$seccion.$tarea.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPlanMantenimientoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PlanMantenimientoDetalle = new $InsPlanMantenimientoDetalle();
                    $PlanMantenimientoDetalle->PmdId = $fila['PmdId'];
                    $PlanMantenimientoDetalle->PmaId = $fila['PmaId'];					
					$PlanMantenimientoDetalle->PmtId = $fila['PmtId'];	
					$PlanMantenimientoDetalle->PmdAccion = $fila['PmdAccion'];
					$PlanMantenimientoDetalle->PmdKilometraje = $fila['PmdKilometraje'];
					$PlanMantenimientoDetalle->PmtNombre = $fila['PmtNombre'];
					
                    $PlanMantenimientoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $PlanMantenimientoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarPlanMantenimientoDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (PmdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PmdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblpmdplanmantenimientodetalle 
				WHERE '.$eliminar;
							
				$error = false;
	
				$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
				
				if(!$resultado) {						
					$error = true;
				} 	
				
	
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarPlanMantenimientoDetalle() {
	
			$this->MtdGenerarPlanMantenimientoDetalleId();
			
			$sql = 'INSERT INTO tblpmdplanmantenimientodetalle (
			PmdId,
			PmaId,	
			PmtId,
			PmdAccion,
			PmdKilometraje
			) 
			VALUES (
			"'.($this->PmdId).'", 
			"'.($this->PmaId).'", 
			"'.($this->PmtId).'", 
			"'.($this->PmdAccion).'",
			"'.($this->PmdKilometraje).'");';
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
		
			if($error) {						
				return false;
			} else {				
				return true;
			}			
			
	}
	
	public function MtdEditarPlanMantenimientoDetalle() {

		$sql = 'UPDATE tblpmdplanmantenimientodetalle SET 
		PmtId = "'.($this->PmtId).'",
		PmdAccion = "'.($this->PmdAccion).'",
		PmdKilometraje = '.($this->PmdKilometraje).'
		WHERE PmdId = "'.($this->PmdId).'";';
					
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}						
				
		}	
		
		
		public function MtdEditarPlanMantenimientoDetalleDato($oPlanMantenimientoDetalleId,$oCampo,$oDato) {

		$sql = 'UPDATE tblpmdplanmantenimientodetalle SET 
		'.$oCampo.' = "'.($oDato).'"
		WHERE PmdId = "'.($oPlanMantenimientoDetalleId).'";';
					
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
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