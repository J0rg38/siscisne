<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsConcesionario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsConcesionario {

    public $OncId;
	public $OncCodigoDealer;
	public $OncNumeroDocumento;
    public $OncNombre;
	public $OncDescripcion;
	public $OncEstado;
    public $OncTiempoCreacion;
    public $OncTiempoModificacion;
    public $OncEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarConcesionarioId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(OncId,5),unsigned)) AS "MAXIMO"
			FROM tbloncconcesionario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->OncId = "ONC-10000";

			}else{
				$fila['MAXIMO']++;
				$this->OncId = "ONC-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerConcesionario(){

        $sql = 'SELECT 
        onc.OncId,
		onc.OncCodigoDealer,
		onc.OncNumeroDocumento,
        onc.OncNombre,
		onc.OncDescripcion,
		onc.OncEstado,
		DATE_FORMAT(onc.OncTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOncTiempoCreacion",
        DATE_FORMAT(onc.OncTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOncTiempoModificacion"
        FROM tbloncconcesionario onc
        WHERE onc.OncId = "'.$this->OncId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->OncId = $fila['OncId'];
			$this->OncCodigoDealer = $fila['OncCodigoDealer'];
			$this->OncNumeroDocumento = $fila['OncNumeroDocumento'];
			$this->OncNombre = $fila['OncNombre'];
			$this->OncDescripcion = $fila['OncDescripcion'];
			$this->OncEstado = $fila['OncEstado'];
			$this->OncTiempoCreacion = $fila['NOncTiempoCreacion'];
			$this->OncTiempoModificacion = $fila['NOncTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerConcesionarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OncId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

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
			$estado = ' AND OncEstado = '.($oEstado).'';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				onc.OncId,
				onc.OncCodigoDealer,
				onc.OncNumeroDocumento,
				onc.OncNombre,
				onc.OncDescripcion,
				onc.OncEstado,
				DATE_FORMAT(onc.OncTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOncTiempoCreacion",
                DATE_FORMAT(onc.OncTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOncTiempoModificacion"				
				FROM tbloncconcesionario onc
				WHERE 1 = 1 '.$filtrar.$estado.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsConcesionario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Concesionario = new $InsConcesionario();
                    $Concesionario->OncId = $fila['OncId'];
					$Concesionario->OncCodigoDealer = $fila['OncCodigoDealer'];
					$Concesionario->OncNumeroDocumento = $fila['OncNumeroDocumento'];
					$Concesionario->OncNombre= $fila['OncNombre'];
					$Concesionario->OncDescripcion= $fila['OncDescripcion'];
					$Concesionario->OncEstado= $fila['OncEstado'];
                    $Concesionario->OncTiempoCreacion = $fila['NOncTiempoCreacion'];
                    $Concesionario->OncTiempoModificacion = $fila['NOncTiempoModificacion'];                    
                    $Concesionario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Concesionario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarConcesionario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (OncId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (OncId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tbloncconcesionario WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarConcesionario() {
	
			$this->MtdGenerarConcesionarioId();
		
			$sql = 'INSERT INTO tbloncconcesionario (
			OncId,
			OncCodigoDealer,
			OncNumeroDocumento,
			OncNombre, 
			OncDescripcion,
			OncEstado,
			OncTiempoCreacion,
			OncTiempoModificacion
			) 
			VALUES (
			"'.($this->OncId).'", 
			"'.($this->OncCodigoDealer).'", 
			"'.($this->OncNumeroDocumento).'", 
			"'.($this->OncNombre).'", 
			"'.($this->OncDescripcion).'", 
			'.($this->OncEstado).', 
			"'.($this->OncTiempoCreacion).'", 
			"'.($this->OncTiempoModificacion).'");';

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
	
	public function MtdEditarConcesionario() {
		
			$sql = 'UPDATE tbloncconcesionario SET 
			OncCodigoDealer = "'.($this->OncCodigoDealer).'",
			 OncNumeroDocumento = "'.($this->OncNumeroDocumento).'",
			 OncNombre = "'.($this->OncNombre).'",
			 OncDescripcion = "'.($this->OncDescripcion).'",
			 OncEstado = '.($this->OncEstado).',
			 OncTiempoModificacion = "'.($this->OncTiempoModificacion).'"
			 WHERE OncId = "'.($this->OncId).'";';
		
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