<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTipoReparacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTipoReparacion {

    public $TreId;
    public $TreNombre;
	public $TreDescripcion;	
	public $TreOrden;
	public $TreEstado;
    public $TreTiempoCreacion;
    public $TreTiempoModificacion;
    public $TreElitreado;

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

	public function MtdGenerarTipoReparacionId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(TreId,5),unsigned)) AS "MAXIMO"
			FROM tbltretiporeparacion';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->TreId = "TRE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->TreId = "TRE-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerTipoReparacion(){

        $sql = 'SELECT 
        tre.TreId,
        tre.TreNombre,
		tre.TreDescripcion,
		tre.TreOrden,
		DATE_FORMAT(tre.TreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTreTiempoCreacion",
        DATE_FORMAT(tre.TreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTreTiempoModificacion"	
        FROM tbltretiporeparacion tre
		WHERE tre.TreId = "'.$this->TreId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->TreId = $fila['TreId'];
            $this->TreNombre = $fila['TreNombre'];
			$this->TreDescripcion = $fila['TreDescripcion'];
			$this->TreOrden = $fila['TreOrden'];
			$this->TreEstado = $fila['TreEstado'];
			$this->TreTiempoCreacion = $fila['NTreTiempoCreacion'];
			$this->TreTiempoModificacion = $fila['NTreTiempoModificacion']; 

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTipoReparaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'TreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$estado = '';
		$uso = '';

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
			$estado = ' AND TreEstado = '.($oEstado).' ';
		}

		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				TreId,
				TreNombre,
				TreDescripcion,
				TreOrden,
				TreEstado,
				DATE_FORMAT(TreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTreTiempoCreacion",
                DATE_FORMAT(TreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTreTiempoModificacion"				
				FROM tbltretiporeparacion
				WHERE 1  = 1 '.$filtrar.$uso.$estado.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTipoReparacion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
				
					$TipoReparacion = new $InsTipoReparacion();
                    $TipoReparacion->TreId = $fila['TreId'];
                    $TipoReparacion->TreNombre= $fila['TreNombre'];
					$TipoReparacion->TreDescripcion= $fila['TreDescripcion'];
					$TipoReparacion->TreOrden= $fila['TreOrden'];
					$TipoReparacion->TreEstado= $fila['TreEstado'];
                    $TipoReparacion->TreTiempoCreacion = $fila['NTreTiempoCreacion'];
                    $TipoReparacion->TreTiempoModificacion = $fila['NTreTiempoModificacion'];    
					
					$TipoReparacion->InsMysql = NULL;                    
					
					$Respuesta['Datos'][]=$TipoReparacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal ? $filaTotal['TOTAL'] : 0;
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	
	//Accion elitrear	 
	
	public function MtdEliminarTipoReparacion($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		// Inicializar variable para evitar warnings
		$elitrear = '';

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$elitrear .= '  (TreId = "'.($elemento).'")';	
					}else{
						$elitrear .= '  (TreId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
	
			$sql = 'DELETE FROM tbltretiporeparacion WHERE '.$elitrear;
		
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
	
	
	public function MtdRegistrarTipoReparacion() {
	
			$this->MtdGenerarTipoReparacionId();
			
			$sql = 'INSERT INTO tbltretiporeparacion (
			TreId,
			TreNombre, 
			
			TreDescripcion,
			TreOrden,
			TreEstado,
			TreTiempoCreacion,
			TreTiempoModificacion
			) 
			VALUES (
			"'.($this->TreId).'", 
			"'.($this->TreNombre).'", 
			
			"'.($this->TreDescripcion).'", 
			'.($this->TreOrden).', 
			'.($this->TreEstado).', 
			"'.($this->TreTiempoCreacion).'", 
			"'.($this->TreTiempoModificacion).'");';					

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
	
	public function MtdEditarTipoReparacion() {
		
			$sql = 'UPDATE tbltretiporeparacion SET 
			 TreNombre = "'.($this->TreNombre).'",
			 
			 TreDescripcion = "'.($this->TreDescripcion).'",
			 TreOrden = '.($this->TreOrden).',			 
			 TreEstado = '.($this->TreEstado).',
			 TreTiempoModificacion = "'.($this->TreTiempoModificacion).'"
			 WHERE TreId = "'.($this->TreId).'";';
		
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