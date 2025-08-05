<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoAlmacenMovimientoEntrada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoAlmacenMovimientoEntrada {

    public $FilId;
	public $FinId;
	public $AmoId;
	
	public $FilEstado;
	public $FilTiempoCreacion;
	public $FilTiempoModificacion;
    public $FilEliminado;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaIngresoAlmacenMovimientoEntradaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FilId,5),unsigned)) AS "MAXIMO"
		FROM tblfilfichaingresoalmacenmovimiento';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FilId = "FIL-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FilId = "FIL-".$fila['MAXIMO'];					
		}

	}
	

    public function MtdObtenerFichaIngresoAlmacenMovimientoEntradas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FilId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL) {

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
			$fingreso = ' AND fil.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fil.FilEstado = '.$oEstado.'';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fil.FilId,			
			fil.FinId,
			fil.AmoId,
			
			fil.FilEstado,
			DATE_FORMAT(fil.FilTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFilTiempoCreacion",
	        DATE_FORMAT(fil.FilTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFilTiempoModificacion",
			
			amo.AmoComprobanteNumero,
			DATE_FORMAT(amo.AmoComprobanteFecha, "%d/%m/%Y") AS "NAmoComprobanteFecha",
			amo.AmoTotal,
			amo.AmoTipoCambio,
			
			
			amo.MonId,
			
			mon.MonSimbolo,
			mon.MonNombre,
			
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno
		
			FROM tblfilfichaingresoalmacenmovimiento fil
				
				LEFT JOIN tblamoalmacenmovimiento amo
				ON fil.AmoId = amo.AmoId
					LEFT JOIN tblprvproveedor prv
					ON amo.PrvId = prv.PrvId
						LEFT JOIN tblmonmoneda mon
						ON amo.MonId = mon.MonId
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoAlmacenMovimientoEntrada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoAlmacenMovimientoEntrada = new $InsFichaIngresoAlmacenMovimientoEntrada();
                    $FichaIngresoAlmacenMovimientoEntrada->FilId = $fila['FilId'];
                    $FichaIngresoAlmacenMovimientoEntrada->FinId = $fila['FinId'];					
					$FichaIngresoAlmacenMovimientoEntrada->AmoId = $fila['AmoId'];
					
					$FichaIngresoAlmacenMovimientoEntrada->FilEstado = $fila['FilEstado'];
					$FichaIngresoAlmacenMovimientoEntrada->FilTiempoCreacion = $fila['NFilTiempoCreacion'];  
					$FichaIngresoAlmacenMovimientoEntrada->FilTiempoModificacion = $fila['NFilTiempoModificacion']; 
					
					$FichaIngresoAlmacenMovimientoEntrada->AmoComprobanteNumero = $fila['AmoComprobanteNumero']; 
					$FichaIngresoAlmacenMovimientoEntrada->AmoComprobanteFecha = $fila['NAmoComprobanteFecha']; 
					$FichaIngresoAlmacenMovimientoEntrada->AmoTotal = $fila['AmoTotal'];
					$FichaIngresoAlmacenMovimientoEntrada->AmoTipoCambio = $fila['AmoTipoCambio'];
					
					
					
					$FichaIngresoAlmacenMovimientoEntrada->MonId = $fila['MonId'];
					
					$FichaIngresoAlmacenMovimientoEntrada->MonSimbolo = $fila['MonSimbolo'];
					$FichaIngresoAlmacenMovimientoEntrada->MonNombre = $fila['MonNombre'];
					
					$FichaIngresoAlmacenMovimientoEntrada->PrvNombre = $fila['PrvNombre']; 
					$FichaIngresoAlmacenMovimientoEntrada->PrvApellidoPaterno = $fila['PrvApellidoPaterno']; 		
					$FichaIngresoAlmacenMovimientoEntrada->PrvApellidoMaterno = $fila['PrvApellidoMaterno']; 

                    $FichaIngresoAlmacenMovimientoEntrada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoAlmacenMovimientoEntrada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoAlmacenMovimientoEntrada($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FilId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FilId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfilfichaingresoalmacenmovimiento 
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
	
	
	public function MtdRegistrarFichaIngresoAlmacenMovimientoEntrada() {
	
			$this->MtdGenerarFichaIngresoAlmacenMovimientoEntradaId();
			
			$sql = 'INSERT INTO tblfilfichaingresoalmacenmovimiento (
			FilId,
			FinId,	
			AmoId,
			
			FilEstado,
			FilTiempoCreacion,
			FilTiempoModificacion) 
			VALUES (
			"'.($this->FilId).'", 
			"'.($this->FinId).'", 
			"'.($this->AmoId).'",
			
			'.($this->FilEstado).',
			"'.($this->FilTiempoCreacion).'",
			"'.($this->FilTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaIngresoAlmacenMovimientoEntrada() {

		$sql = 'UPDATE tblfilfichaingresoalmacenmovimiento SET 	
		AmoId = "'.($this->AmoId).'",
		FilTiempoModificacion = "'.($this->FilTiempoModificacion).'"
		WHERE FilId = "'.($this->FilId).'";';
				
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