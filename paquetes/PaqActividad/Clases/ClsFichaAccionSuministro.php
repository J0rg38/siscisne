<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionSuministro
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionSuministro {

    public $FasId;
	public $FccId;
	public $ProId;
	public $UmeId;
	public $FasCantidad;
	public $FasCantidadReal;

	public $FasVerificar1;
	public $FasVerificar2;
	
	public $FasEstado;
	public $FasTiempoCreacion;
	public $FasTiempoModificacion;
    public $FasEliminado;
	
	public $ProNombre;
	public $Minsigla;
	
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

	private function MtdGenerarFichaAccionSuministroId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FasId,5),unsigned)) AS "MAXIMO"
		FROM tblfasfichaaccionsuministro';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FasId = "FAS-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FasId = "FAS-".$fila['MAXIMO'];					
		}

	}
	

    public function MtdObtenerFichaAccionSuministros($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FasId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {

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
			$fingreso = ' AND fas.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fas.FasEstado = '.$oEstado.'';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fas.FasId,			
			fas.FccId,
			fas.ProId,
			fas.UmeId,
			fas.FasCantidad,
			fas.FasCantidadReal,
			
			fas.FasVerificar1,
			fas.FasVerificar2,


			fas.FasEstado,
			DATE_FORMAT(fas.FasTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFasTiempoCreacion",
	        DATE_FORMAT(fas.FasTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFasTiempoModificacion",

			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProCosto,
			pro.ProPrecio,

			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre,
					
			min.MinSigla
		
			FROM tblfasfichaaccionsuministro fas
				LEFT JOIN tblproproducto pro
				ON fas.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON pro.UmeId = ume.UmeId
						LEFT JOIN tblfccfichaaccion fcc
						ON fas.FccId = fcc.FccId
							LEFT JOIN tblfimfichaingresomodalidad fim
							ON fcc.FimId = fim.FimId
								LEFT JOIN tblminmodalidadingreso min
								ON fim.MinId = min.MinId

			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionSuministro = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionSuministro = new $InsFichaAccionSuministro();
                    $FichaAccionSuministro->FasId = $fila['FasId'];
                    $FichaAccionSuministro->FccId = $fila['FccId'];					
					$FichaAccionSuministro->ProId = $fila['ProId'];
					$FichaAccionSuministro->UmeId = $fila['UmeId'];

					$FichaAccionSuministro->FasCantidad = $fila['FasCantidad'];
					$FichaAccionSuministro->FasCantidadReal = $fila['FasCantidadReal'];


					$FichaAccionSuministro->FasVerificar1 = $fila['FasVerificar1'];
					$FichaAccionSuministro->FasVerificar2 = $fila['FasVerificar2'];
					
					$FichaAccionSuministro->FasEstado = $fila['FasEstado'];
					$FichaAccionSuministro->FasTiempoCreacion = $fila['NFasTiempoCreacion'];  
					$FichaAccionSuministro->FasTiempoModificacion = $fila['NFasTiempoModificacion']; 
					
					$FichaAccionSuministro->ProNombre = $fila['ProNombre'];
					$FichaAccionSuministro->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$FichaAccionSuministro->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					$FichaAccionSuministro->ProCosto = $fila['ProCosto'];
					$FichaAccionSuministro->ProPrecio = $fila['ProPrecio'];
					
					$FichaAccionSuministro->RtiId = $fila['RtiId'];
					$FichaAccionSuministro->UmeIdOrigen = $fila['UmeIdOrigen'];
					$FichaAccionSuministro->UmeNombre = $fila['UmeNombre'];

					$FichaAccionSuministro->MinSigla = $fila['MinSigla']; 

                    $FichaAccionSuministro->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaAccionSuministro;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionSuministro($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FasId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FasId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfasfichaaccionsuministro 
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
	
	
	public function MtdRegistrarFichaAccionSuministro() {
	
			$this->MtdGenerarFichaAccionSuministroId();
			
			$sql = 'INSERT INTO tblfasfichaaccionsuministro (
			FasId,
			FccId,	
			ProId,
			UmeId,
			FasCantidad,
			FasCantidadReal,
			FasVerificar1,
			FasVerificar2,
			FasEstado,
			FasTiempoCreacion,
			FasTiempoModificacion) 
			VALUES (
			"'.($this->FasId).'", 
			"'.($this->FccId).'", 
			"'.($this->ProId).'",
			"'.($this->UmeId).'",
			'.($this->FasCantidad).',
			'.($this->FasCantidadReal).',
			'.($this->FasVerificar1).',
			'.($this->FasVerificar2).',
			'.($this->FasEstado).',
			"'.($this->FasTiempoCreacion).'",
			"'.($this->FasTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaAccionSuministro() {

		$sql = 'UPDATE tblfasfichaaccionsuministro SET 	
		UmeId = "'.($this->UmeId).'",
		FasCantidad = '.($this->FasCantidad).',
		FasCantidadReal = '.($this->FasCantidadReal).',
		FasVerificar1 = '.($this->FasVerificar1).',
		FasVerificar2 = '.($this->FasVerificar2).'
		WHERE FasId = "'.($this->FasId).'";';
				
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