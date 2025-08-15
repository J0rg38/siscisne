<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoManoObra
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoManoObra {

    public $FmoId;
	public $FinId;
	public $FmoDescripcion;
	public $FmoImporte;
	
	public $FmoEstado;
	public $FmoTiempoCreacion;
	public $FmoTiempoModificacion;
    public $FmoEliminado;

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

	private function MtdGenerarFichaIngresoManoObraId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FmoId,5),unsigned)) AS "MAXIMO"
		FROM tblfmofichaingresomanoobra';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FmoId = "FMO-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FmoId = "FMO-".$fila['MAXIMO'];					
		}

	}
	

    public function MtdObtenerFichaIngresoManoObras($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL) {

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
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fmo.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fmo.FmoEstado = '.$oEstado.'';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fmo.FmoId,			
			fmo.FinId,
			fmo.FmoDescripcion,
			fmo.FmoImporte,
			
			fmo.FmoEstado,
			DATE_FORMAT(fmo.FmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFmoTiempoCreacion",
	        DATE_FORMAT(fmo.FmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFmoTiempoModificacion"
			
			FROM tblfmofichaingresomanoobra fmo
				
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoManoObra = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoManoObra = new $InsFichaIngresoManoObra();
                    $FichaIngresoManoObra->FmoId = $fila['FmoId'];
                    $FichaIngresoManoObra->FinId = $fila['FinId'];					
					$FichaIngresoManoObra->FmoDescripcion = $fila['FmoDescripcion'];
					$FichaIngresoManoObra->FmoImporte = $fila['FmoImporte'];
					
					$FichaIngresoManoObra->FmoEstado = $fila['FmoEstado'];
					$FichaIngresoManoObra->FmoTiempoCreacion = $fila['NFmoTiempoCreacion'];  
					$FichaIngresoManoObra->FmoTiempoModificacion = $fila['NFmoTiempoModificacion']; 
					
                    $FichaIngresoManoObra->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoManoObra;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoManoObra($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FmoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FmoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfmofichaingresomanoobra 
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
	
	
	public function MtdRegistrarFichaIngresoManoObra() {
	
			$this->MtdGenerarFichaIngresoManoObraId();
			
			$sql = 'INSERT INTO tblfmofichaingresomanoobra (
			FmoId,
			FinId,	
			FmoDescripcion,
			FmoImporte,
			
			FmoEstado,
			FmoTiempoCreacion,
			FmoTiempoModificacion) 
			VALUES (
			"'.($this->FmoId).'", 
			"'.($this->FinId).'", 
			"'.($this->FmoDescripcion).'",
			'.($this->FmoImporte).',
			
			'.($this->FmoEstado).',
			"'.($this->FmoTiempoCreacion).'",
			"'.($this->FmoTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaIngresoManoObra() {

		$sql = 'UPDATE tblfmofichaingresomanoobra SET 	
		FmoDescripcion = "'.($this->FmoDescripcion).'",
		FmoImporte = '.($this->FmoImporte).',
		
		FmoTiempoModificacion = '.($this->FmoTiempoModificacion).'
		WHERE FmoId = "'.($this->FmoId).'";';
				
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