<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descritdoon of ClsTipoDocumento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTipoDocumento {

    public $TdoId;
	public $TdoCodigo;
    public $TdoNombre;
	public $TdoDescripcion;
	public $TdoEstado;
    public $TdoTiempoCreacion;
    public $TdoTiempoModificacion;
    public $TdoEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	public function MtdGenerarTipoDocumentoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TdoId,5),unsigned)) AS "MAXIMO"
			FROM tbltdotipodocumento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TdoId = "TDO-10000";

			}else{
				$fila['MAXIMO']++;
				$this->TdoId = "TDO-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerTipoDocumento(){

        $sql = 'SELECT 
        TdoId,
		TdoCodigo,
        TdoNombre,
		TdoDescripcion,
		TdoEstado,
		DATE_FORMAT(TdoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTdoTiempoCreacion",
        DATE_FORMAT(TdoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTdoTiempoModificacion"
        FROM tbltdotipodocumento
        WHERE TdoId = "'.$this->TdoId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TdoId = $fila['TdoId'];
			$this->TdoCodigo = $fila['TdoCodigo'];
			$this->TdoNombre = $fila['TdoNombre'];
			$this->TdoDescripcion = $fila['TdoDescripcion'];
			$this->TdoEstado = $fila['TdoEstado'];
			$this->TdoTiempoCreacion = $fila['NTdoTiempoCreacion'];
			$this->TdoTiempoModificacion = $fila['NTdoTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTipoDocumentos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TdoId',$oSentido = 'Desc',$oPaginacion = '0,10') {

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
				tdo.TdoId,
				tdo.TdoCodigo,
				tdo.TdoNombre,
				tdo.TdoDescripcion,
				tdo.TdoEstado,
				DATE_FORMAT(tdo.TdoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTdoTiempoCreacion",
                DATE_FORMAT(tdo.TdoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTdoTiempoModificacion"				
				FROM tbltdotipodocumento tdo
				WHERE 1 = 1 '.$filtrar.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTipoDocumento = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$TipoDocumento = new $InsTipoDocumento();
                    $TipoDocumento->TdoId = $fila['TdoId'];
					$TipoDocumento->TdoCodigo = $fila['TdoCodigo'];
					$TipoDocumento->TdoNombre= $fila['TdoNombre'];
					$TipoDocumento->TdoDescripcion= $fila['TdoDescripcion'];
					$TipoDocumento->TdoEstado= $fila['TdoEstado'];
                    $TipoDocumento->TdoTiempoCreacion = $fila['NTdoTiempoCreacion'];
                    $TipoDocumento->TdoTiempoModificacion = $fila['NTdoTiempoModificacion'];                    
                    $TipoDocumento->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TipoDocumento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarTipoDocumento($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (TdoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TdoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tbltdotipodocumento WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarTipoDocumento() {
	
			$this->MtdGenerarTipoDocumentoId();
		
			$sql = 'INSERT INTO tbltdotipodocumento (
			TdoId,
			TdoCodigo,
			TdoNombre, 
			TdoDescripcion,
			TdoEstado,
			TdoTiempoCreacion,
			TdoTiempoModificacion
			) 
			VALUES (
			"'.($this->TdoId).'",
			"'.($this->TdoCodigo).'", 
			"'.($this->TdoNombre).'",
			"'.($this->TdoDescripcion).'",
			'.($this->TdoEstado).',
			"'.($this->TdoTiempoCreacion).'",
			"'.($this->TdoTiempoModificacion).'");';

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
	
	public function MtdEditarTipoDocumento() {
		
		$sql = 'UPDATE tbltdotipodocumento SET 
		TdoCodigo = "'.($this->TdoCodigo).'",
		TdoNombre = "'.($this->TdoNombre).'",
		TdoDescripcion = "'.($this->TdoDescripcion).'",
		TdoEstado = '.($this->TdoEstado).',
		TdoTiempoModificacion = "'.($this->TdoTiempoModificacion).'"
		WHERE TdoId = "'.($this->TdoId).'";';
		
		
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