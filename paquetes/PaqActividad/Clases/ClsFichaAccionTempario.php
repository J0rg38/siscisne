<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionTempario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionTempario {

    public $FaeId;
	public $FccId;
	public $FaeCodigo;
	public $FaeTiempo;
	public $FaeEstado;	
	public $FaeTiempoCreacion;
	public $FaeTiempoModificacion;
    public $FaeEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaAccionTemparioId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FaeId,5),unsigned)) AS "MAXIMO"
			FROM tblfaefichaacciontempario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FaeId = "FAE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FaeId = "FAE-".$fila['MAXIMO'];					
			}
				
	}
		
		
	 public function MtdVerificarExisteFichaAccionTemparios($oCampo,$oDato,$oFichaAccion){
		 
		 $FichaAccionTemparioId = "";
		 
		 $ResFichaAccionTempario = $this->MtdObtenerFichaAccionTemparios($oCampo,"esigual",$oDato,'FaeId','ASC','1',$oFichaAccion,NULL);
		 $ArrFichaAccionTemparios = $ResFichaAccionTempario['Datos'];
		 
		 if(!empty($ArrFichaAccionTemparios)){
			 foreach($ArrFichaAccionTemparios as $DatFichaAccionTempario){
				 
				 $FichaAccionTemparioId = $DatFichaAccionTempario->FaeId;
				 
			 }
		 }
		 
		 return $FichaAccionTemparioId;
	 }
	 

    public function MtdObtenerFichaAccionTemparios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'FaeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {

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
			$faccion = ' AND fae.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fae.FaeEstado = '.$oEstado.' ';
		}
		
		
		 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fae.FaeId,			
			fae.FccId,
			fae.FaeCodigo,
			fae.FaeTiempo,
			fae.FaeEstado,
			DATE_FORMAT(fae.FaeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFaeTiempoCreacion",
	        DATE_FORMAT(fae.FaeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFaeTiempoModificacion"
			FROM tblfaefichaacciontempario fae
			WHERE  1 = 1 '.$faccion.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionTempario = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionTempario = new $InsFichaAccionTempario();
                    $FichaAccionTempario->FaeId = $fila['FaeId'];
					$FichaAccionTempario->FccId = $fila['FccId'];
					$FichaAccionTempario->FaeCodigo = $fila['FaeCodigo'];
					$FichaAccionTempario->FaeTiempo = $fila['FaeTiempo'];	
					$FichaAccionTempario->FaeEstado = $fila['FaeEstado'];
					$FichaAccionTempario->FaeTiempoCreacion = $fila['NFaeTiempoCreacion'];  
					$FichaAccionTempario->FaeTiempoModificacion = $fila['NFaeTiempoModificacion']; 					
                    $FichaAccionTempario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaAccionTempario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionTempario($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FaeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FaeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfaefichaacciontempario 
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
	
	
	public function MtdRegistrarFichaAccionTempario() {
	
			$this->MtdGenerarFichaAccionTemparioId();
			
			$sql = 'INSERT INTO tblfaefichaacciontempario (
			FaeId,
			FccId,	
			FaeCodigo,
			FaeTiempo,
			FaeEstado,
			FaeTiempoCreacion,
			FaeTiempoModificacion
			) 
			VALUES (
			"'.($this->FaeId).'", 
			"'.($this->FccId).'", 
			"'.($this->FaeCodigo).'", 
			"'.($this->FaeTiempo).'", 
			'.($this->FaeEstado).',
			"'.($this->FaeTiempoCreacion).'",
			"'.($this->FaeTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaAccionTempario() {

		$sql = 'UPDATE tblfaefichaacciontempario SET 	
		FaeCodigo = "'.($this->FaeCodigo).'",
		FaeTiempo = "'.($this->FaeTiempo).'",
		FaeEstado = '.($this->FaeEstado).',
		FaeTiempoCreacion = "'.($this->FaeTiempoCreacion).'",
		FaeTiempoModificacion = "'.($this->FaeTiempoModificacion).'"

		WHERE FaeId = "'.($this->FaeId).'";';
				
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