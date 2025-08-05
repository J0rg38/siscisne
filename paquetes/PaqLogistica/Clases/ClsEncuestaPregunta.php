<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsEncuestaPregunta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsEncuestaPregunta {

    public $EprId;
    public $EprNombre;
	public $EprTipo;
	public $EprUso;
	
	public $EprEstado;	
    public $EprTiempoCreacion;
    public $EprTiempoModificacion;
    public $EprEliminado;

	public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarEncuestaPreguntaId() {

		
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(EprId,5),unsigned)) AS "MAXIMO"
		FROM tbleprencuestapregunta';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->EprId = "EPR-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->EprId = "EPR-".$fila['MAXIMO'];					
		}	
				
	}
		
    public function MtdObtenerEncuestaPregunta(){

        $sql = 'SELECT 
        EprId,
		EprNombre,
		EprTipo,
		EprSubTipo,
		
		EprUso,
		
		EprEstado,	
		DATE_FORMAT(EprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEprTiempoCreacion",
        DATE_FORMAT(EprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEprTiempoModificacion"
        FROM tbleprencuestapregunta
        WHERE EprId = "'.$this->EprId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->EprId = $fila['EprId'];
			$this->EprNombre = $fila['EprNombre'];
			$this->EprTipo = $fila['EprTipo'];	
			$this->EprSubTipo = $fila['EprSubTipo'];	
												
            $this->EprUso = $fila['EprUso'];
													
			$this->EprEstado = $fila['EprEstado'];
			$this->EprTiempoCreacion = $fila['NEprTiempoCreacion'];
			$this->EprTiempoModificacion = $fila['NEprTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerEncuestaPreguntas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oUso=NULL,$oTipo=NULL,$oSeccion=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oEncuestaSeccionTipo=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
		if(!empty($oEstado)){
			$estado = ' AND epr.EprEstado = '.$oEstado;
		}	

		if(!empty($oUso)){
			$uso = ' AND epr.EprUso = '.$oUso;
		}	
		
		if(!empty($oTipo)){
			$tipo = ' AND epr.EprTipo = '.$oTipo;
		}	
		
		
		if(!empty($oSeccion)){
			$seccion = ' AND epr.EpsId = "'.$oSeccion.'"';
		}	
	
	
		
		if(!empty($oFechaInicio)){			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(epr.EprTiempoCreacion)>="'.$oFechaInicio.'" AND DATE(epr.EprTiempoCreacion)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(epr.EprTiempoCreacion)>="'.$oFechaInicio.'"';
			}			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(epr.EprTiempoCreacion)<="'.$oFechaFin.'"';		
			}			
		}
		
			if(!empty($oEncuestaSeccionTipo)){
			$estipo = ' AND eps.EpsTipo = "'.$oEncuestaSeccionTipo.'"';
		}	
	
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				epr.EprId,		
				epr.EpsId,
				
				epr.EprNombre,
				epr.EprTipo,
				epr.EprSubTipo,
				
				epr.EprUso,
				
				epr.EprEstado,
				DATE_FORMAT(epr.EprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEprTiempoCreacion",
                DATE_FORMAT(epr.EprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEprTiempoModificacion",
				eps.EpsTipo
				
				FROM tbleprencuestapregunta epr	
					LEFT JOIN tblepsencuestapreguntaseccion eps
					ON epr.EpsId = eps.EpsId
				WHERE 1 = 1 '.$filtrar.$tipo.$estipo.$fecha.$uso.$tipo.$seccion.$estado.$categoria.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsEncuestaPregunta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$EncuestaPregunta = new $InsEncuestaPregunta();				
					
                    $EncuestaPregunta->EprId = $fila['EprId'];
					
                    $EncuestaPregunta->EprNombre= $fila['EprNombre'];
					$EncuestaPregunta->EprTipo= $fila['EprTipo'];
					$EncuestaPregunta->EprSubTipo= $fila['EprSubTipo'];
					
					
					$EncuestaPregunta->EprUso= $fila['EprUso'];
					
					$EncuestaPregunta->EprEstado = $fila['EprEstado'];					
                    $EncuestaPregunta->EprTiempoCreacion = $fila['NEprTiempoCreacion'];
                    $EncuestaPregunta->EprTiempoModificacion = $fila['NEprTiempoModificacion'];    
					$EncuestaPregunta->EpsTipo = $fila['EpsTipo'];    

					
                    $EncuestaPregunta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $EncuestaPregunta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarEncuestaPregunta($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (EprId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (EprId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tbleprencuestapregunta WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarEncuestaPregunta() {
	
			$this->MtdGenerarEncuestaPreguntaId();
		
			$sql = 'INSERT INTO tbleprencuestapregunta (
			EprId,
			
			EprNombre,
			EprTipo,
			EprSubTipo,
			
			EprUso,
			
			EprEstado,
			EprTiempoCreacion,
			EprTiempoModificacion) 
			VALUES (
			"'.($this->EprId).'", 
			
			"'.($this->EprNombre).'",
			"'.($this->EprTipo).'", 
			"'.($this->EprSubTipo).'", 
			
			"'.($this->EprUso).'", 
			
			'.($this->EprEstado).', 
			"'.($this->EprTiempoCreacion).'", 
			"'.($this->EprTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarEncuestaPregunta() {
		
			$sql = 'UPDATE tbleprencuestapregunta SET 
			EprNombre = "'.($this->EprNombre).'",
			EprTipo = "'.($this->EprTipo).'",
			EprSubTipo = "'.($this->EprSubTipo).'",
			
			
			EprUso = "'.($this->EprUso).'",
			
			EprEstado = "'.($this->EprEstado).'",
			EprTiempoModificacion = "'.($this->EprTiempoModificacion).'"
			WHERE EprId = "'.($this->EprId).'";';
			
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