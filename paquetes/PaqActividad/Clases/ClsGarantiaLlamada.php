<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGarantiaLlamada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGarantiaLlamada {

    public $GllId;
	public $GarId;
	public $GllNumero;
	public $GllFecha;
	public $GllObservacion;
	public $GllEstado;	
	public $GllTiempoCreacion;
	public $GllTiempoModificacion;
    public $GllEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	private function MtdGenerarGarantiaLlamadaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(GllId,5),unsigned)) AS "MAXIMO"
		FROM tblgllgarantiallamada';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->GllId = "GLL-10000";
		}else{
			$fila['MAXIMO']++;
			$this->GllId = "GLL-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerGarantiaLlamadas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GllId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGarantia=NULL,$oEstado=NULL) {

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
		
		if(!empty($oGarantia)){
			$garantia = ' AND gll.GarId = "'.$oGarantia.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND gll.GllEstado = '.$oEstado.' ';
		}
			
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			gll.GllId,			
			gll.GarId,
			gll.GllNumero,
			gll.GllFecha,
			gll.GllObservacion,
			gll.GllEstado,
			DATE_FORMAT(gll.GllTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGllTiempoCreacion",
	        DATE_FORMAT(gll.GllTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGllTiempoModificacion"
			
			FROM tblgllgarantiallamada gll
			WHERE  1 = 1 '.$garantia.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGarantiaLlamada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GarantiaLlamada = new $InsGarantiaLlamada();
                    $GarantiaLlamada->GllId = $fila['GllId'];
                    $GarantiaLlamada->GarId = $fila['GarId'];

					$GarantiaLlamada->GllNumero = $fila['GllNumero'];  

					$GarantiaLlamada->GllFecha = $fila['GllFecha'];  
					$GarantiaLlamada->GllObservacion = $fila['GllObservacion'];
			      
					  
					$GarantiaLlamada->GllEstado = $fila['GllEstado'];
					$GarantiaLlamada->GllTiempoCreacion = $fila['NGllTiempoCreacion'];  
					$GarantiaLlamada->GllTiempoModificacion = $fila['NGllTiempoModificacion']; 					

                    $GarantiaLlamada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GarantiaLlamada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarGarantiaLlamada($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (GllId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GllId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblgllgarantiallamada 
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
	
	
	public function MtdRegistrarGarantiaLlamada() {
	
			$this->MtdGenerarGarantiaLlamadaId();
			
			
			$sql = 'INSERT INTO tblgllgarantiallamada (
			GllId,
			GarId,
			
			GllNumero,
			
			GllFecha,			
			GllObservacion,
			
			GllEstado,
			GllTiempoCreacion,
			GllTiempoModificacion) 
			VALUES (
			"'.($this->GllId).'", 
			"'.($this->GarId).'", 
			"'.($this->GllNumero).'", 

			"'.($this->GllFecha).'", 
			"'.($this->GllObservacion).'", 	
			
			'.($this->GllEstado).',
			"'.($this->GllTiempoCreacion).'",
			"'.($this->GllTiempoModificacion).'");';
		
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
	
	public function MtdEditarGarantiaLlamada() {

			$sql = 'UPDATE tblgllgarantiallamada SET 	
			
			GllNumero = "'.($this->GllNumero).'",

			GllFecha = "'.($this->GllFecha).'",			 
			GllObservacion = "'.($this->GllObservacion).'",
		
			GllTiempoModificacion = "'.($this->GllTiempoModificacion).'"
			 
			WHERE GllId = "'.($this->GllId).'";';
					
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