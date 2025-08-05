<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoHistorial
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoHistorial {

    public $FihId;
	public $FinId;
	public $FihDescripcion;
	public $FihEstado;	
	public $FihTiempoCreacion;

    public $FihEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaIngresoHistorialId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FihId,5),unsigned)) AS "MAXIMO"
			FROM tblfihfichaingresohistorial';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FihId = "FIH-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FihId = "FIH-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerFichaIngresoHistoriales($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FihId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL) {

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
			$fingreso = ' AND fih.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fih.FihEstado = '.$oEstado.' ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fih.FihId,			
			fih.FinId,
			fih.FihDescripcion,
			fih.FihEstado,
			DATE_FORMAT(fih.FihTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFihTiempoCreacion"
			FROM tblfihfichaingresohistorial fih
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoHistorial = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoHistorial = new $InsFichaIngresoHistorial();
                    $FichaIngresoHistorial->FihId = $fila['FihId'];
                    $FichaIngresoHistorial->FinId = $fila['FinId'];					
					$FichaIngresoHistorial->FihDescripcion = $fila['FihDescripcion'];	
					$FichaIngresoHistorial->FihEstado = $fila['FihEstado'];
					$FichaIngresoHistorial->FihTiempoCreacion = $fila['NFihTiempoCreacion'];  

                    $FichaIngresoHistorial->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoHistorial;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoHistorial($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FihId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FihId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfihfichaingresohistorial 
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
	
	
	public function MtdRegistrarFichaIngresoHistorial() {
	
			$this->MtdGenerarFichaIngresoHistorialId();
			
			$sql = 'INSERT INTO tblfihfichaingresohistorial (
			FihId,
			FinId,	
			FihDescripcion,
			FihEstado,
			FihTiempoModificacion
			) 
			VALUES (
			"'.($this->FihId).'", 
			"'.($this->FinId).'", 
			"'.($this->FihDescripcion).'", 
			'.($this->FihEstado).',
			"'.($this->FihTiempoCreacion).'");';
		
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
	
//	public function MtdEditarFichaIngresoHistorial() {
//
//		$sql = 'UPDATE tblfihfichaingresohistorial SET 	
//		FihDescripcion = "'.($this->FihDescripcion).'",
//		FihAccion = "'.($this->FihAccion).'",
//		FihVerificar1 = '.($this->FihVerificar1).',
//		FihVerificar2 = '.($this->FihVerificar2).'
//
//		WHERE FihId = "'.($this->FihId).'";';
//				
//		$error = false;
//		
//		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//		
//		if(!$resultado) {						
//			$error = true;
//		} 		
//		
//		if($error) {						
//			return false;
//		} else {				
//			return true;
//		}						
//			
//	}	
		
	
}
?>