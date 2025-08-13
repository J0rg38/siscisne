<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsObsequio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsObsequio {

    public $ObsId;
    public $ObsNombre;
	public $ObsSigla;
	public $ObsDescripcion;	
	public $ObsUso;
	public $ProId;
	
	public $ObsArchivo;
	public $ObsFoto;
	public $ObsEstado;
    public $ObsTiempoCreacion;
    public $ObsTiempoModificacion;
    public $ObsEliminado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarObsequioId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(ObsId,5),unsigned)) AS "MAXIMO"
			FROM tblobsobsequio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->ObsId = "OBS-10000";
			}else{
				$fila['MAXIMO']++;
				$this->ObsId = "OBS-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerObsequio(){

        $sql = 'SELECT 
        obs.ObsId,
        obs.ObsNombre,
		obs.ObsSigla,
		obs.ObsDescripcion,
		obs.ObsUso,
		obs.ProId,
		obs.ObsArchivo,
		obs.ObsFoto,
		obs.ObsEstado,
		DATE_FORMAT(obs.ObsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NObsTiempoCreacion",
        DATE_FORMAT(obs.ObsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NObsTiempoModificacion"	
        FROM tblobsobsequio obs
		WHERE obs.ObsId = "'.$this->ObsId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->ObsId = $fila['ObsId'];
            $this->ObsNombre = $fila['ObsNombre'];
			$this->ObsSigla = $fila['ObsSigla'];
			$this->ObsDescripcion = $fila['ObsDescripcion'];
			$this->ObsUso = $fila['ObsUso'];
			$this->ProId = $fila['ProId'];
			$this->ObsEstado = $fila['ObsEstado'];
			$this->ObsTiempoCreacion = $fila['NObsTiempoCreacion'];
			$this->ObsTiempoModificacion = $fila['NObsTiempoModificacion']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerObsequios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ObsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oUso=NULL,$oEstado=NULL) {

		// Inicializar variables de filtro para evitar warnings
		$filtrar = '';
		$uso = '';
		$estado = '';
		$orden = '';
		$paginacion = '';

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
				$uso .= '  (ObsUso = "'.($elemento).'")';
				if($i<>count($elementos)){						
					$uso .= ' OR ';	
				}
			$i++;		
			}

			$uso .= ' ) 
			)
			';

		}
		
		
		if(!empty($oEstado)){
			$estado = ' AND obs.ObsEstado = '.($oEstado);
		}
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				obs.ObsId,
				obs.ObsNombre,
				obs.ObsSigla,
				obs.ObsDescripcion,
				obs.ObsUso,
				obs.ProId,
				obs.ObsArchivo,
				obs.ObsFoto,
				obs.ObsEstado,						
				DATE_FORMAT(obs.ObsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NObsTiempoCreacion",
                DATE_FORMAT(obs.ObsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NObsTiempoModificacion"				
				FROM tblobsobsequio obs
				WHERE 1  = 1 '.$filtrar.$uso.$estado.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsObsequio = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$Obsequio = new $InsObsequio();
                    $Obsequio->ObsId = $fila['ObsId'];
                    $Obsequio->ObsNombre= $fila['ObsNombre'];
					$Obsequio->ObsSigla = $fila['ObsSigla'];
					$Obsequio->ObsDescripcion= $fila['ObsDescripcion'];
					$Obsequio->ObsUso= $fila['ObsUso'];
					$Obsequio->ProId= $fila['ProId'];
					$Obsequio->ObsArchivo= $fila['ObsArchivo'];
					$Obsequio->ObsFoto= $fila['ObsFoto'];
					$Obsequio->ObsEstado= $fila['ObsEstado'];
                    $Obsequio->ObsTiempoCreacion = $fila['NObsTiempoCreacion'];
                    $Obsequio->ObsTiempoModificacion = $fila['NObsTiempoModificacion'];    
					
					$Obsequio->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$Obsequio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion eliminar	 
	
	public function MtdEliminarObsequio($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (ObsId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (ObsId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tblobsobsequio WHERE '.$eliminar;
		
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
	
	
	public function MtdRegistrarObsequio() {
	
			$this->MtdGenerarObsequioId();
			
			$sql = 'INSERT INTO tblobsobsequio (
			ObsId,
			ObsNombre, 
			ObsSigla,
			ObsDescripcion,
			ObsUso,
			ObsArchivo,
			ObsFoto,
			ObsEstado,
			ObsTiempoCreacion,
			ObsTiempoModificacion) 
			VALUES (
			"'.($this->ObsId).'", 
			"'.($this->ObsNombre).'", 
			"'.($this->ObsSigla).'", 
			"'.($this->ObsDescripcion).'", 
			'.($this->ObsUso).', 
			"'.($this->ObsArchivo).'", 
			"'.($this->ObsFoto).'", 
			'.($this->ObsEstado).', 
			"'.($this->ObsTiempoCreacion).'", 
			"'.($this->ObsTiempoModificacion).'");';

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
	
	public function MtdEditarObsequio() {
		
			$sql = 'UPDATE tblobsobsequio SET 
			 ObsNombre = "'.($this->ObsNombre).'",
			 ObsSigla = "'.($this->ObsSigla).'",
			 ObsDescripcion = "'.($this->ObsDescripcion).'",
			 ObsUso = '.($this->ObsUso).',		
			 
			ObsArchivo = "'.($this->ObsArchivo).'",
			ObsFoto = "'.($this->ObsFoto).'",
			   	 
			 ObsEstado = '.($this->ObsEstado).',
			 ObsTiempoModificacion = "'.($this->ObsTiempoModificacion).'"
			 WHERE ObsId = "'.($this->ObsId).'";';
		
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