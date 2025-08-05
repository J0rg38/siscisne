<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionFoto {

    public $FafId;
	public $FccId;
	public $FafArchivo;
	public $FafEstado;
	public $FafTiempoCreacion;
	public $FafTiempoModificacion;
    public $FafEliminado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaAccionFotoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FafId,5),unsigned)) AS "MAXIMO"
			FROM tblfaffichaaccionfoto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FafId = "FAF-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FafId = "FAF-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerFichaAccionFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FafId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {

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
			$faccion = ' AND faf.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND faf.FafEstado = '.$oEstado.' ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			faf.FafId,			
			faf.FccId,
			faf.FafArchivo,
			faf.FafEstado,
			DATE_FORMAT(faf.FafTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFafTiempoCreacion",
	        DATE_FORMAT(faf.FafTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFafTiempoModificacion"
			FROM tblfaffichaaccionfoto faf
			WHERE  1 = 1 '.$faccion.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionFoto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionFoto = new $InsFichaAccionFoto();
                    $FichaAccionFoto->FafId = $fila['FafId'];
					$FichaAccionFoto->FccId = $fila['FccId'];
					$FichaAccionFoto->FafArchivo = $fila['FafArchivo'];	
					$FichaAccionFoto->FafEstado = $fila['FafEstado'];
					$FichaAccionFoto->FafTiempoCreacion = $fila['NFafTiempoCreacion'];  
					$FichaAccionFoto->FafTiempoModificacion = $fila['NFafTiempoModificacion']; 					
                    $FichaAccionFoto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaAccionFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionFoto($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FafId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FafId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfaffichaaccionfoto 
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
	
	
	public function MtdRegistrarFichaAccionFoto() {
	
			$this->MtdGenerarFichaAccionFotoId();
			
			$sql = 'INSERT INTO tblfaffichaaccionfoto (
			FafId,
			FccId,	
			FafArchivo,
			FafEstado,
			FafTiempoCreacion,
			FafTiempoModificacion
			) 
			VALUES (
			"'.($this->FafId).'", 
			"'.($this->FccId).'", 
			"'.($this->FafArchivo).'", 
			'.($this->FafEstado).',
			"'.($this->FafTiempoCreacion).'",
			"'.($this->FafTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaAccionFoto() {

		$sql = 'UPDATE tblfaffichaaccionfoto SET 	
		FafArchivo = "'.($this->FafArchivo).'",
		FafEstado = '.($this->FafEstado).'
		WHERE FafId = "'.($this->FafId).'";';
				
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