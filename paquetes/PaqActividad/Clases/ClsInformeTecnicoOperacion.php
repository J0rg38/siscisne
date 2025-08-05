<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsInformeTecnicoOperacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsInformeTecnicoOperacion {

    public $ItoId;
	public $IteId;

	public $ItoNumero;
	
	public $ItoTiempo;
	public $ItoCostoHora;
    public $ItoValorTotal;

	public $ItoEstado;	
	public $ItoTiempoCreacion;
	public $ItoTiempoModificacion;
    public $ItoEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	private function MtdGenerarInformeTecnicoOperacionId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ItoId,5),unsigned)) AS "MAXIMO"
		FROM tblitoinformetecnicooperacion';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->ItoId = "ITO-10000";
		}else{
			$fila['MAXIMO']++;
			$this->ItoId = "ITO-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerInformeTecnicoOperaciones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'ItoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oInformeTecnico=NULL,$oEstado=NULL) {

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
		
		if(!empty($oInformeTecnico)){
			$garantia = ' AND ito.IteId = "'.$oInformeTecnico.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ito.ItoEstado = '.$oEstado.' ';
		}
			
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ito.ItoId,			
			ito.IteId,

			ito.ItoNumero,

			ito.ItoTiempo,
			ito.ItoCostoHora,
			ito.ItoValorTotal,
			
			ito.ItoEstado,
			DATE_FORMAT(ito.ItoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NItoTiempoCreacion",
	        DATE_FORMAT(ito.ItoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NItoTiempoModificacion"
			
			FROM tblitoinformetecnicooperacion ito
			WHERE  1 = 1 '.$garantia.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsInformeTecnicoOperacion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$InformeTecnicoOperacion = new $InsInformeTecnicoOperacion();
                    $InformeTecnicoOperacion->ItoId = $fila['ItoId'];
                    $InformeTecnicoOperacion->IteId = $fila['IteId'];

					$InformeTecnicoOperacion->ItoNumero = $fila['ItoNumero'];  

					$InformeTecnicoOperacion->ItoTiempo = $fila['ItoTiempo'];  
					$InformeTecnicoOperacion->ItoCostoHora = $fila['ItoCostoHora'];
			        $InformeTecnicoOperacion->ItoValorTotal = $fila['ItoValorTotal'];
					
					$InformeTecnicoOperacion->ItoEstado = $fila['ItoEstado'];
					$InformeTecnicoOperacion->ItoTiempoCreacion = $fila['NItoTiempoCreacion'];  
					$InformeTecnicoOperacion->ItoTiempoModificacion = $fila['NItoTiempoModificacion']; 					

                    $InformeTecnicoOperacion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $InformeTecnicoOperacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarInformeTecnicoOperacion($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (ItoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (ItoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblitoinformetecnicooperacion 
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
	
	
	public function MtdRegistrarInformeTecnicoOperacion() {
	
			$this->MtdGenerarInformeTecnicoOperacionId();
			
			
			$sql = 'INSERT INTO tblitoinformetecnicooperacion (
			ItoId,
			IteId,
			
			FaeId,
			
			ItoNumero,
			ItoTiempo,			
			ItoCostoHora,
			ItoValorTotal,
			
			ItoEstado,
			ItoTiempoCreacion,
			ItoTiempoModificacion) 
			VALUES (
			"'.($this->ItoId).'", 
			"'.($this->IteId).'", 

			'.(empty($this->FaeId)?'NULL,':'"'.$this->FaeId.'",').'	

			"'.($this->ItoNumero).'", 
			'.($this->ItoTiempo).', 
			'.($this->ItoCostoHora).', 	
			'.($this->ItoValorTotal).',
			
			'.($this->ItoEstado).',
			"'.($this->ItoTiempoCreacion).'",
			"'.($this->ItoTiempoModificacion).'");';
		
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
	
	public function MtdEditarInformeTecnicoOperacion() {

			$sql = 'UPDATE tblitoinformetecnicooperacion SET 	
			
			ItoNumero = "'.($this->ItoNumero).'",

			ItoTiempo = '.($this->ItoTiempo).',			 
			ItoCostoHora = '.($this->ItoCostoHora).',
			ItoValorTotal = '.($this->ItoValorTotal).',
			
			ItoTiempoModificacion = "'.($this->ItoTiempoModificacion).'"
			 
			WHERE ItoId = "'.($this->ItoId).'";';
					
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