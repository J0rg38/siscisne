<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsEncuestaPreguntaRespuesta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsEncuestaPreguntaRespuesta {

    public $EpeId;
    public $EprId;
	public $EpeNombre;
	public $EpeValor;
	public $EpeEstado;	
    public $EpeTiempoCreacion;
    public $EpeTiempoModificacion;
    public $EpeEliminado;

	public $InsMysql;


	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarEncuestaPreguntaRespuestaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(EpeId,5),unsigned)) AS "MAXIMO"
		FROM tblepeencuestapreguntarespuesta';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->EpeId = "EPE-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->EpeId = "EPE-".$fila['MAXIMO'];					
		}	
			
	}
		
    public function MtdObtenerEncuestaPreguntaRespuesta(){

        $sql = 'SELECT 
        EpeId,
		EprId,
		EpeNombre,
		EpeValor,
		
		EpeEstado,	
		DATE_FORMAT(EpeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEpeTiempoCreacion",
        DATE_FORMAT(EpeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEpeTiempoModificacion"
        FROM tblepeencuestapreguntarespuesta
        WHERE EpeId = "'.$this->EpeId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->EpeId = $fila['EpeId'];
			$this->EprId = $fila['EprId'];
			$this->EpeNombre = $fila['EpeNombre'];		
			$this->EpeValor = $fila['EpeValor'];	
												
			$this->EpeEstado = $fila['EpeEstado'];
			$this->EpeTiempoCreacion = $fila['NEpeTiempoCreacion'];
			$this->EpeTiempoModificacion = $fila['NEpeTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

//    public function MtdObtenerEncuestaPreguntaRespuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuestaPregunta=NULL,$oEncuestaSeccionTipo=NULL) {
    public function MtdObtenerEncuestaPreguntaRespuestas($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuestaPregunta=NULL) {

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
			$estado = ' AND epe.EpeEstado = '.$oEstado;
		}	
		
		if(!empty($oEncuestaPregunta)){
			$epregunta = ' AND epe.EprId = "'.$oEncuestaPregunta.'"';
		}	
	
//	if(!empty($oEncuestaSeccionTipo)){
//			$estipo = ' AND epr.EpsId = "'.$oEncuestaSeccionTipo.'"';
//		}	
//	

	
		$sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		epe.EpeId,
		epe.EprId,
		epe.EpeNombre,
		epe.EpeValor,
		
		epe.EpeEstado,
		DATE_FORMAT(epe.EpeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEpeTiempoCreacion",
		DATE_FORMAT(epe.EpeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEpeTiempoModificacion"
		
		FROM tblepeencuestapreguntarespuesta epe	
			LEFT JOIN tbleprencuestapregunta epr
			ON epe.EprId = epr.EprId
				LEFT JOIN tblepsencuestapreguntaseccion eps
				ON epr.EpsId = eps.EpsId
				
		WHERE 1 = 1 '.$filtrar.$epregunta.$estipo.$estado.$categoria.$orden.$paginacion;
						

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsEncuestaPreguntaRespuesta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$EncuestaPreguntaRespuesta = new $InsEncuestaPreguntaRespuesta();				
					
                    $EncuestaPreguntaRespuesta->EpeId = $fila['EpeId'];
					$EncuestaPreguntaRespuesta->EprId= $fila['EprId'];
					$EncuestaPreguntaRespuesta->EpeNombre= $fila['EpeNombre'];
					$EncuestaPreguntaRespuesta->EpeValor= $fila['EpeValor'];
                   
					$EncuestaPreguntaRespuesta->EpeEstado = $fila['EpeEstado'];					
                    $EncuestaPreguntaRespuesta->EpeTiempoCreacion = $fila['NEpeTiempoCreacion'];
                    $EncuestaPreguntaRespuesta->EpeTiempoModificacion = $fila['NEpeTiempoModificacion'];    

					
                    $EncuestaPreguntaRespuesta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $EncuestaPreguntaRespuesta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarEncuestaPreguntaRespuesta($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (EpeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (EpeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblepeencuestapreguntarespuesta WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarEncuestaPreguntaRespuesta() {
	
			$this->MtdGenerarEncuestaPreguntaRespuestaId();
		
			$sql = 'INSERT INTO tblepeencuestapreguntarespuesta (
			EpeId,
			EprId,
			EpeNombre,
			EpeValor,
			
			EpeEstado,
			EpeTiempoCreacion,
			EpeTiempoModificacion,
			EpeEliminado) 
			VALUES (
			"'.($this->EpeId).'", 
			"'.($this->EprId).'",
			"'.($this->EpeNombre).'", 
			"'.($this->EpeValor).'", 
			
			'.($this->EpeEstado).', 
			"'.($this->EpeTiempoCreacion).'", 
			"'.($this->EpeTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarEncuestaPreguntaRespuesta() {
		
			$sql = 'UPDATE tblepeencuestapreguntarespuesta SET 
			EpeNombre = "'.($this->EpeNombre).'",
			EpeValor = "'.($this->EpeValor).'",
			
			EpeEstado = "'.($this->EpeEstado).'",
			EpeTiempoModificacion = "'.($this->EpeTiempoModificacion).'"
			WHERE EpeId = "'.($this->EpeId).'";';
			
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