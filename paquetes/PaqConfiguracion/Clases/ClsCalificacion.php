<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCalificacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCalificacion {

    public $CalId;
	public $CalTipo;
    public $MonId;
	public $CalTipoCambio;
	public $CalCosto;
	public $CalMargen;
	public $CalRango;
	public $CalRangoInicio;
	public $CalRangoFin;

    public $CalTiempoCreacion;
    public $CalTiempoModificacion;
    public $CalEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	
	public function MtdGenerarCalificacionId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CalId,5),unsigned)) AS "MAXIMO"
			FROM tblcalcalificacion';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CalId = "CAL-10000";

			}else{
				$fila['MAXIMO']++;
				$this->CalId = "CAL-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerCalificacion(){

        $sql = 'SELECT 
        CalId,
		
		CalTipo,
		MonId,
		CalTipoCambio,
		CalCosto,
		CalMargen,
		CalRango,
		CalRangoInicio,
		CalRangoFin,

		DATE_FORMAT(CalTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCalTiempoCreacion",
        DATE_FORMAT(CalTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCalTiempoModificacion"
        FROM tblcalcalificacion
        WHERE CalId = "'.$this->CalId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CalId = $fila['CalId'];
			$this->CalTipo = $fila['CalTipo'];
			$this->MonId = $fila['MonId'];
			$this->CalTipoCambio = $fila['CalTipoCambio'];
			$this->CalCosto = $fila['CalCosto'];
			$this->CalMargen = $fila['CalMargen'];
			$this->CalRango = $fila['CalRango'];
			$this->CalRangoInicio = $fila['CalRangoInicio'];
			$this->CalRangoFin = $fila['CalRangoFin'];
			$this->CalTiempoCreacion = $fila['NCalTiempoCreacion'];
			$this->CalTiempoModificacion = $fila['NCalTiempoModificacion']; 
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCalificaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CalId',$oSentido = 'Desc',$oPaginacion = '0,10',$oMoneda=NULL) {

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
		
		if(!empty($oMoneda)){
			$moneda = ' AND cal.MonId = "'.($oMoneda).'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				cal.CalId,
				cal.CalTipo,
				cal.MonId,
				cal.CalTipoCambio,
				cal.CalCosto,
				cal.CalMargen,
				cal.CalRango,
				cal.CalRangoInicio,
				cal.CalRangoFin,
				DATE_FORMAT(cal.CalTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCalTiempoCreacion",
                DATE_FORMAT(cal.CalTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCalTiempoModificacion"				
				FROM tblcalcalificacion cal
				WHERE 1 = 1 '.$filtrar.$moneda.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCalificacion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Calificacion = new $InsCalificacion();
                    $Calificacion->CalId = $fila['CalId'];
					
					$Calificacion->CalTipo = $fila['CalTipo'];
					$Calificacion->MonId = $fila['MonId'];
					$Calificacion->CalTipoCambio = $fila['CalTipoCambio'];
					$Calificacion->CalCosto = $fila['CalCosto'];
					$Calificacion->CalMargen = $fila['CalMargen'];
					$Calificacion->CalRango = $fila['CalRango'];
					$Calificacion->CalRangoInicio = $fila['CalRangoInicio'];
					$Calificacion->CalRangoFin = $fila['CalRangoFin'];
					
                    $Calificacion->CalTiempoCreacion = $fila['NCalTiempoCreacion'];
                    $Calificacion->CalTiempoModificacion = $fila['NCalTiempoModificacion'];                    
                    $Calificacion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Calificacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarCalificacion($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CalId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CalId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblcalcalificacion WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarCalificacion() {
	
			$this->MtdGenerarCalificacionId();
		
			$sql = 'INSERT INTO tblcalcalificacion (
			CalId,
			
			CalTipo,
			MonId,
			CalTipoCambio,
			CalCosto,
			CalMargen,
			CalRango,
			CalRangoInicio,
			CalRangoFin,
				
			CalTiempoCreacion,
			CalTiempoModificacion,
			CalEliminado) 
			VALUES (
			"'.($this->CalId).'", 
			"'.($this->CalTipo).'", 
			"'.($this->MonId).'", 
			
			'.(empty($this->CalTipoCambio)?'NULL, ':''.$this->CalTipoCambio.',').'
			
			"'.($this->CalCosto).'", 
			"'.($this->CalMargen).'", 
			"'.($this->CalRango).'", 
			0, 
			0, 
			"'.($this->CalTiempoCreacion).'", 
			"'.($this->CalTiempoModificacion).'", 				
			'.($this->CalEliminado).');';					

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
	
	public function MtdEditarCalificacion() {

			
			$sql = 'UPDATE tblcalcalificacion SET 
			CalTipo = "'.($this->CalTipo).'",
			MonId = "'.($this->MonId).'",
			
			'.(empty($this->CalTipoCambio)?'CalTipoCambio = NULL, ':'CalTipoCambio = "'.$this->CalTipoCambio.'",').'
			
			CalMargen = "'.($this->CalMargen).'",
			CalRango = "'.($this->CalRango).'",
			CalRangoInicio = 0,
			CalRangoFin = 0,

			 CalDescripcion = "'.($this->CalDescripcion).'",
			 CalTiempoModificacion = "'.($this->CalTiempoModificacion).'"
			 WHERE CalId = "'.($this->CalId).'";';
			
		
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