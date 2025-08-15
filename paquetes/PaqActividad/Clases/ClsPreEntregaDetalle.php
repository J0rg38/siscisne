<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPreEntregaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPreEntregaDetalle {

    public $RedId;
	public $FinId;
	public $PetId;
	public $RedAccion;	
	public $RedEstado;	
	public $RedTiempoCreacion;
	public $RedTiempoModificacion;
    public $RedEliminado;
	
	public $PetNombre;

	public $MinSigla;
	
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

	private function MtdGenerarPreEntregaDetalleId() {
			
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(RedId,5),unsigned)) AS "MAXIMO"
		FROM tblredpreentregadetalle';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->RedId = "RED-10000";
		}else{
			$fila['MAXIMO']++;
			$this->RedId = "RED-".$fila['MAXIMO'];					
		}
				
	}
		

    public function MtdObtenerPreEntregaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RedId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oAccion=NULL) {
		
		// Inicializar variables para evitar warnings
		$faccion = '';
		$estado = '';
		$nivel = '';
		$severo = '';
		$accion = '';
		$filtrar = '';
		$orden = '';
		$paginacion = '';

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
		
		if(!empty($oAccion)){
			$accion = ' AND red.RedAccion = "'.$oAccion.'"';
		}	
		
		
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND red.FinId = "'.$oFichaIngreso.'"';
		}		
		
		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			red.RedId,			
			red.FinId,
			red.PetId,
			red.RedAccion,
			DATE_FORMAT(red.RedTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRedTiempoCreacion",
			DATE_FORMAT(red.RedTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRedTiempoModificacion",

			pet.PetNombre,
			min.MinSigla

			FROM tblredpreentregadetalle red
				LEFT JOIN tblpetpreentregatarea pet
				ON red.PetId = pet.PetId		
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON red.FinId = fim.FinId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
								
			WHERE  1 = 1 '.$faccion.$estado.$nivel.$severo.$accion.$fingreso.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPreEntregaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$PreEntregaDetalle = new $InsPreEntregaDetalle();
                    $PreEntregaDetalle->RedId = $fila['RedId'];
                    $PreEntregaDetalle->FinId = $fila['FinId'];					
					$PreEntregaDetalle->PetId = $fila['PetId'];	
					$PreEntregaDetalle->RedAccion = $fila['RedAccion'];

					$PreEntregaDetalle->RedTiempoCreacion = $fila['NRedTiempoCreacion'];  
					$PreEntregaDetalle->RedTiempoModificacion = $fila['NRedTiempoModificacion'];  
					
					$PreEntregaDetalle->PetNombre = $fila['PetNombre'];
					
					$PreEntregaDetalle->MinSigla = $fila['MinSigla'];

					$PreEntregaDetalle->InsMysql = NULL;

					$Respuesta['Datos'][]= $PreEntregaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarPreEntregaDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
		$i=1;
		foreach($elementos as $elemento){
			if(!empty($elemento)){				
				if($i==count($elementos)){						
					$eliminar .= '  (RedId = "'.($elemento).'")';	
				}else{
					$eliminar .= '  (RedId = "'.($elemento).'")  OR';	
				}	
			}
		$i++;
		
		}
		
		$sql = 'DELETE FROM tblredpreentregadetalle 
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
	
	
	public function MtdRegistrarPreEntregaDetalle() {
	
		$this->MtdGenerarPreEntregaDetalleId();
		
		$sql = 'INSERT INTO tblredpreentregadetalle (
		RedId,
		FinId,	
		PetId,
		RedAccion,	
		RedTiempoCreacion,
		RedTiempoModificacion) 
		VALUES (
		"'.($this->RedId).'", 
		"'.($this->FinId).'", 
		"'.($this->PetId).'", 
		"'.($this->RedAccion).'",
		"'.($this->RedTiempoCreacion).'",
		"'.($this->RedTiempoModificacion).'");';
		
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
	
	public function MtdEditarPreEntregaDetalle() {
	
		$sql = 'UPDATE tblredpreentregadetalle SET 	
		 RedAccion = "'.($this->RedAccion).'",
		 RedTiempoModificacion = "'.($this->RedTiempoModificacion).'"
		 WHERE RedId = "'.($this->RedId).'";';
				
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