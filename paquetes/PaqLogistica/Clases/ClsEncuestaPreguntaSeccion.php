<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsEncuestaPreguntaSeccion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsEncuestaPreguntaSeccion {

    public $EpsId;
    public $EpsNombre;
	public $EpsTipo;
	public $EpsEstado;	
    public $EpsTiempoCreacion;
    public $EpsTiempoModificacion;
    public $EpsEliminado;

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
		
	public function MtdGenerarEncuestaPreguntaSeccionId() {

	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(EpsId,5),unsigned)) AS "MAXIMO"
			FROM tblepsencuestapreguntaseccion';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->EpsId = "EPS-10000";

			}else{
				$fila['MAXIMO']++;
				$this->EpsId = "EPS-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerEncuestaPreguntaSeccion(){

        $sql = 'SELECT 
        EpsId,
		EpsNombre,
		
		EpsTipo,
		EpsEstado,	
		DATE_FORMAT(EpsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEpsTiempoCreacion",
        DATE_FORMAT(EpsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEpsTiempoModificacion"
        FROM tblepsencuestapreguntaseccion
        WHERE EpsId = "'.$this->EpsId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->EpsId = $fila['EpsId'];
            $this->EpsNombre = $fila['EpsNombre'];	
			 $this->EpsTipo = $fila['EpsTipo'];		
			 								
			$this->EpsEstado = $fila['EpsEstado'];
			$this->EpsTiempoCreacion = $fila['NEpsTiempoCreacion'];
			$this->EpsTiempoModificacion = $fila['NEpsTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerEncuestaPreguntaSecciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EpsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL) {

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
			$estado = ' AND eps.EpsEstado = '.$oEstado;
		}	
		if(!empty($oTipo)){
			$tipo = ' AND eps.EpsTipo = "'.$oTipo.'"';
		}	
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				eps.EpsId,
				eps.EpsNombre,
				eps.EpsTipo,
				eps.EpsEstado,
				DATE_FORMAT(eps.EpsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEpsTiempoCreacion",
                DATE_FORMAT(eps.EpsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEpsTiempoModificacion"
				FROM tblepsencuestapreguntaseccion eps	
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$categoria.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsEncuestaPreguntaSeccion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$EncuestaPreguntaSeccion = new $InsEncuestaPreguntaSeccion();				
					
                    $EncuestaPreguntaSeccion->EpsId = $fila['EpsId'];
					
                    $EncuestaPreguntaSeccion->EpsNombre= $fila['EpsNombre'];
					 $EncuestaPreguntaSeccion->EpsTipo= $fila['EpsTipo'];
					$EncuestaPreguntaSeccion->EpsEstado = $fila['EpsEstado'];					
                    $EncuestaPreguntaSeccion->EpsTiempoCreacion = $fila['NEpsTiempoCreacion'];
                    $EncuestaPreguntaSeccion->EpsTiempoModificacion = $fila['NEpsTiempoModificacion'];    

					
                    $EncuestaPreguntaSeccion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $EncuestaPreguntaSeccion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarEncuestaPreguntaSeccion($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (EpsId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (EpsId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblepsencuestapreguntaseccion WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarEncuestaPreguntaSeccion() {
	
			$this->MtdGenerarEncuestaPreguntaSeccionId();
		
			$sql = 'INSERT INTO tblepsencuestapreguntaseccion (
			EpsId,
			
			EpsNombre,
			EpsTipo,
			
			EpsEstado,
			EpsTiempoCreacion,
			EpsTiempoModificacion
			) 
			VALUES (
			"'.($this->EpsId).'", 
			
			"'.($this->EpsNombre).'",
			"'.($this->EpsTipo).'",
			
			'.($this->EpsEstado).', 
			"'.($this->EpsTiempoCreacion).'", 
			"'.($this->EpsTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarEncuestaPreguntaSeccion() {
		
			$sql = 'UPDATE tblepsencuestapreguntaseccion SET 
		
			EpsNombre = "'.($this->EpsNombre).'",
			EpsTipo = "'.($this->EpsTipo).'",
			
			EpsEstado = "'.($this->EpsEstado).'",
			EpsTiempoModificacion = "'.($this->EpsTiempoModificacion).'"
			WHERE EpsId = "'.($this->EpsId).'";';
			
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