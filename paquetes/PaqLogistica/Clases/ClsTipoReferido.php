<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTipoReferido
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTipoReferido {

    public $TrfId;	
    public $TrfNombre;
	public $TrfDescripcion;
	public $TrfUso;
	public $TrfEstado;
    public $TrfTiempoCreacion;
    public $TrfTiempoModificacion;
    public $TrfEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	public function MtdVerificarExisteTipoReferido() {
		
		$Id = NULL;
		
		$sql = 'SELECT
		trf.TrfId
		FROM tbltrftiporeferido trf 
		WHERE trf.TrfNombre = "'.$this->TrfNombre.'" LIMIT 1';

		$resultado = $this->InsMysql->MtdConsultar($sql);
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);
		
		if(!empty($fila['TrfId'])){
			$Id = $fila['TrfId'];
		}
		
		
		return $Id;			
	}
	
	
	public function MtdGenerarTipoReferidoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TrfId,5),unsigned)) AS "MAXIMO"
			FROM tbltrftiporeferido';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TrfId = "TRF-10000";

			}else{
				$fila['MAXIMO']++;
				$this->TrfId = "TRF-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerTipoReferido(){

        $sql = 'SELECT 
        TrfId,
        TrfNombre,
		TrfDescripcion,
		
		TrfEstado,
		DATE_FORMAT(TrfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTrfTiempoCreacion",
        DATE_FORMAT(TrfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTrfTiempoModificacion"
        FROM tbltrftiporeferido
        WHERE TrfId = "'.$this->TrfId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TrfId = $fila['TrfId'];
			$this->TrfNombre = $fila['TrfNombre'];
			$this->TrfDescripcion = $fila['TrfDescripcion'];
		
			$this->TrfEstado = $fila['TrfEstado'];
			$this->TrfTiempoCreacion = $fila['NTrfTiempoCreacion'];
			$this->TrfTiempoModificacion = $fila['NTrfTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTipoReferidos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TrfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

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
			$uso = ' AND trf.TrfUso = '.($oUso).'';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND trf.TrfEstado = '.($oEstado).'';
		}
		
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				trf.TrfId,
				trf.TrfNombre,
				trf.TrfDescripcion,
			
				trf.TrfEstado,
				DATE_FORMAT(trf.TrfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTrfTiempoCreacion",
                DATE_FORMAT(trf.TrfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTrfTiempoModificacion"				
				FROM tbltrftiporeferido trf
				WHERE 1 = 1 '.$filtrar.$uso.$estado.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTipoReferido = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$TipoReferido = new $InsTipoReferido();
                    $TipoReferido->TrfId = $fila['TrfId'];
					$TipoReferido->TrfNombre= $fila['TrfNombre'];
					$TipoReferido->TrfDescripcion= $fila['TrfDescripcion'];
					
					$TipoReferido->TrfEstado = $fila['TrfEstado'];
                    $TipoReferido->TrfTiempoCreacion = $fila['NTrfTiempoCreacion'];
                    $TipoReferido->TrfTiempoModificacion = $fila['NTrfTiempoModificacion'];                    
                    $TipoReferido->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TipoReferido;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarTipoReferido($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (TrfId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (TrfId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tbltrftiporeferido WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarTipoReferido() {
	
			$this->MtdGenerarTipoReferidoId();
		
			$sql = 'INSERT INTO tbltrftiporeferido (
			TrfId,
			TrfNombre, 
			TrfDescripcion,
		
			TrfEstado,
			TrfTiempoCreacion,
			TrfTiempoModificacion,
			TrfEliminado) 
			VALUES (
			"'.($this->TrfId).'", 
			"'.($this->TrfNombre).'", 
			"'.($this->TrfDescripcion).'", 
			, 
			'.($this->TrfEstado).', 
			"'.($this->TrfTiempoCreacion).'",
			"'.($this->TrfTiempoModificacion).'");';					

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
	
	public function MtdEditarTipoReferido() {
		
			$sql = 'UPDATE tbltrftiporeferido SET 
			 TrfNombre = "'.($this->TrfNombre).'",
			 TrfDescripcion = "'.($this->TrfDescripcion).'",
			
			 TrfEstado = '.($this->TrfEstado).',
			 TrfTiempoModificacion = "'.($this->TrfTiempoModificacion).'"
			 WHERE TrfId = "'.($this->TrfId).'";';
			
		
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