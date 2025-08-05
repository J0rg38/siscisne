<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoSuministro
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoSuministro {

    public $FisId;
	public $FimId;
	public $ProId;
	public $UmeId;
	
	public $FisCantidad;
	public $FisEstado;
	public $FisTiempoCreacion;
	public $FisTiempoModificacion;
    public $FisEliminado;
	
	public $ProNombre;
	public $Minsigla;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaIngresoSuministroId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FisId,5),unsigned)) AS "MAXIMO"
		FROM tblfisfichaingresosuministro';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FisId = "FIS-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FisId = "FIS-".$fila['MAXIMO'];					
		}

	}
	

    public function MtdObtenerFichaIngresoSuministros($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FisId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL) {

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
			$fingreso = ' AND fis.FimId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fis.FisEstado = '.$oEstado.'';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fis.FisId,			
			fis.FimId,
			fis.ProId,
			fis.UmeId,
			fis.FisCantidad,
			fis.FisEstado,
			DATE_FORMAT(fis.FisTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFisTiempoCreacion",
	        DATE_FORMAT(fis.FisTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFisTiempoModificacion",

			pro.ProNombre,
		
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProCosto,
			pro.ProPrecio,
			
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
			
			min.MinSigla
		
			FROM tblfisfichaingresosuministro fis
				LEFT JOIN tblproproducto pro
				ON fis.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON fis.UmeId = ume.UmeId	
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fis.FimId = fim.FimId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoSuministro = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoSuministro = new $InsFichaIngresoSuministro();
                    $FichaIngresoSuministro->FisId = $fila['FisId'];
                    $FichaIngresoSuministro->FimId = $fila['FimId'];					
					$FichaIngresoSuministro->ProId = $fila['ProId'];
					$FichaIngresoSuministro->UmeId = $fila['UmeId'];
					$FichaIngresoSuministro->FisCantidad = $fila['FisCantidad'];					
					$FichaIngresoSuministro->FisEstado = $fila['FisEstado'];
					$FichaIngresoSuministro->FisTiempoCreacion = $fila['NFisTiempoCreacion'];  
					$FichaIngresoSuministro->FisTiempoModificacion = $fila['NFisTiempoModificacion']; 
					
					$FichaIngresoSuministro->ProNombre = $fila['ProNombre']; 
					$FichaIngresoSuministro->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$FichaIngresoSuministro->ProCodigoAlternativo = $fila['ProCodigoAlternativo']; 
					$FichaIngresoSuministro->ProCosto = $fila['ProCosto']; 
					$FichaIngresoSuministro->ProPrecio = $fila['ProPrecio']; 
					
					$FichaIngresoSuministro->RtiId = $fila['RtiId']; 
					$FichaIngresoSuministro->UmeIdOrigen = $fila['UmeIdOrigen']; 
					$FichaIngresoSuministro->UmeNombre = $fila['UmeNombre']; 
					
					$FichaIngresoSuministro->MinSigla = $fila['MinSigla']; 

                    $FichaIngresoSuministro->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoSuministro;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoSuministro($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FisId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FisId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfisfichaingresosuministro 
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
	
	
	public function MtdRegistrarFichaIngresoSuministro() {
	
			$this->MtdGenerarFichaIngresoSuministroId();
			
			$sql = 'INSERT INTO tblfisfichaingresosuministro (
			FisId,
			FimId,	
			ProId,
			UmeId,
			FisCantidad,
			FisEstado,
			FisTiempoCreacion,
			FisTiempoModificacion) 
			VALUES (
			"'.($this->FisId).'", 
			"'.($this->FimId).'", 
			"'.($this->ProId).'", 
			"'.($this->UmeId).'", 
			'.($this->FisCantidad).',
			'.($this->FisEstado).',
			"'.($this->FisTiempoCreacion).'",
			"'.($this->FisTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaIngresoSuministro() {

		$sql = 'UPDATE tblfisfichaingresosuministro SET 	
		ProId = "'.($this->ProId).'",
		UmeId = "'.($this->UmeId).'",
		FisCantidad = '.($this->FisCantidad).'
		WHERE FisId = "'.($this->FisId).'";';
		
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