<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionTarea
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionTarea {

    public $FatId;
	public $FccId;
	public $FitId;
	
	public $FatDescripcion;
	public $FatEspecificacion;
	public $FatCosto;
	
	public $FatAccion;	
	public $FatVerificar1;
	public $FatVerificar2;
	public $FatEstado;	
	public $FatTiempoCreacion;
	public $FatTiempoModificacion;
    public $FatEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaAccionTareaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FatId,5),unsigned)) AS "MAXIMO"
			FROM tblfatfichaacciontarea';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FatId = "FAT-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FatId = "FAT-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerFichaAccionTareas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FatId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {

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
		
		if(!empty($oFichaAccion)){
			$faccion = ' AND fat.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fat.FatEstado = '.$oEstado.' ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fat.FatId,			
			fat.FccId,
			fat.FitId,

			fat.FatDescripcion,
			fat.FatEspecificacion,
			fat.FatCosto,

			fat.FatAccion,
			fat.FatVerificar1,
			fat.FatVerificar2,
			fat.FatEstado,
			DATE_FORMAT(fat.FatTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFatTiempoCreacion",
	        DATE_FORMAT(fat.FatTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFatTiempoModificacion",
			
			CASE
				WHEN (
					EXISTS (
						SELECT 
						fde.FdeId
						FROM tblfdefacturadetalle fde
						WHERE fde.FatId = fat.FatId
						LIMIT 1
					) 
					OR
					EXISTS (
						SELECT 
						bde.bdeId
						FROM tblbdeboletadetalle bde
						WHERE bde.FatId = fat.FatId
						LIMIT 1
					) 
				)
				
				THEN "Si"
				ELSE "No"
				END AS FatPendienteFacturar
				
				
			
			
			FROM tblfatfichaacciontarea fat
			WHERE  1 = 1 '.$faccion.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionTarea = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionTarea = new $InsFichaAccionTarea();
                    $FichaAccionTarea->FatId = $fila['FatId'];
					$FichaAccionTarea->FccId = $fila['FccId'];
					$FichaAccionTarea->FitId = $fila['FitId'];
					
					$FichaAccionTarea->FatDescripcion = $fila['FatDescripcion'];	
					$FichaAccionTarea->FatEspecificacion = $fila['FatEspecificacion'];	
					$FichaAccionTarea->FatCosto = $fila['FatCosto'];	
					
					$FichaAccionTarea->FatAccion = $fila['FatAccion'];
					$FichaAccionTarea->FatVerificar1 = $fila['FatVerificar1'];
					$FichaAccionTarea->FatVerificar2 = $fila['FatVerificar2'];
					$FichaAccionTarea->FatEstado = $fila['FatEstado'];
					$FichaAccionTarea->FatTiempoCreacion = $fila['NFatTiempoCreacion'];  
					$FichaAccionTarea->FatTiempoModificacion = $fila['NFatTiempoModificacion']; 					
                    $FichaAccionTarea->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaAccionTarea;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionTarea($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FatId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FatId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfatfichaacciontarea 
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
	
	
	public function MtdRegistrarFichaAccionTarea() {
	
			$this->MtdGenerarFichaAccionTareaId();
			
			$sql = 'INSERT INTO tblfatfichaacciontarea (
			FatId,
			FccId,	
			FitId,
			FatDescripcion,
			FatEspecificacion,
			FatCosto,
			FatAccion,
			FatVerificar1,
			FatVerificar2,
			FatEstado,
			FatTiempoCreacion,
			FatTiempoModificacion
			) 
			VALUES (
			"'.($this->FatId).'", 
			"'.($this->FccId).'", 
			
			'.(empty($this->FitId)?'NULL, ':'"'.$this->FitId.'",').'		
			
			"'.($this->FatDescripcion).'", 
			"'.($this->FatEspecificacion).'", 
			'.($this->FatCosto).', 
			
			"'.($this->FatAccion).'",
			'.($this->FatVerificar1).',
			'.($this->FatVerificar2).',
			'.($this->FatEstado).',
			"'.($this->FatTiempoCreacion).'",
			"'.($this->FatTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaAccionTarea() {

		$sql = 'UPDATE tblfatfichaacciontarea SET 	
		FatDescripcion = "'.($this->FatDescripcion).'",
		
		FatEspecificacion = "'.($this->FatEspecificacion).'",
		FatCosto = '.($this->FatCosto).',
		
		FatAccion = "'.($this->FatAccion).'",
		FatVerificar1 = '.($this->FatVerificar1).',
		FatVerificar2 = '.($this->FatVerificar2).'

		WHERE FatId = "'.($this->FatId).'";';
				
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