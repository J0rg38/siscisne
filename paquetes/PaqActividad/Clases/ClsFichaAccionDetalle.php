<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionDetalle {

    public $FadId;
	public $FccId;
	
	public $ProId;
	public $UmeId;
	
	public $FadCantidad;
	public $FadCantidadReal;
		
	public $FadEstado;	
	public $FadTiempoCreacion;
	public $FadTiempoModificacion;
    public $FadEliminado;

	public $PmtNombre;
		
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

	private function MtdGenerarFichaAccionDetalleId() {
		
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FadId,5),unsigned)) AS "MAXIMO"
		FROM tblfadfichaacciondetalle';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FadId = "FAD-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FadId = "FAD-".$fila['MAXIMO'];					
		}
			
	}
		

    public function MtdObtenerFichaAccionDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FadId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {

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
			$faccion = ' AND fad.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fad.FadEstado = '.$oEstado.' ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fad.FadId,			
			fad.FccId,
			
			fad.ProId,
			fad.UmeId,
			
			fad.FadCantidad,
			fad.FadCantidadReal,
			
			fad.FadEstado,
			DATE_FORMAT(fad.FadTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFadTiempoCreacion",
	        DATE_FORMAT(fad.FadTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFadTiempoModificacion",
			pmt.PmtNombre
			
			FROM tblfadfichaacciondetalle fad
				LEFT JOIN tblfidfichaingresodetalle fid
				ON fad.ProId = fid.ProId
					LEFT JOIN tblpmtplanmantenimientotarea pmt
					ON fid.PmtId = pmt.PmtId
			WHERE  1 = 1 '.$faccion.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionDetalle = new $InsFichaAccionDetalle();
                    $FichaAccionDetalle->FadId = $fila['FadId'];
                    $FichaAccionDetalle->FccId = $fila['FccId'];	
					
					$FichaAccionDetalle->ProId = $fila['ProId'];
					$FichaAccionDetalle->UmeId = $fila['UmeId'];
					
					$FichaAccionDetalle->FadCantidad = $fila['FadCantidad'];
					$FichaAccionDetalle->FadCantidadReal = $fila['FadCantidadReal'];
					
					$FichaAccionDetalle->FadEstado = $fila['FadEstado'];
					$FichaAccionDetalle->FadTiempoCreacion = $fila['NFadTiempoCreacion'];  
					$FichaAccionDetalle->FadTiempoModificacion = $fila['NFadTiempoModificacion']; 		
					
					
                    $FichaAccionDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaAccionDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionDetalle($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FadId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FadId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfadfichaacciondetalle 
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
	
	
	public function MtdRegistrarFichaAccionDetalle() {
	
			$this->MtdGenerarFichaAccionDetalleId();
			
			$sql = 'INSERT INTO tblfadfichaacciondetalle (
			FadId,
			FccId,	
			
			ProId,			
			UmeId,
			
			FadCantidad,
			FadCantidadReal,

			FadEstado,
			FadTiempoCreacion,
			FadTiempoModificacion
			) 
			VALUES (
			"'.($this->FadId).'", 
			"'.($this->FccId).'", 

			"'.($this->ProId).'", 
			"'.($this->UmeId).'", 

			'.($this->FadCantidad).',
			'.($this->FadCantidadReal).',

			'.($this->FadEstado).',
			"'.($this->FadTiempoCreacion).'",
			"'.($this->FadTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaAccionDetalle() {

		$sql = 'UPDATE tblfadfichaacciondetalle SET 
		UmeId = "'.($this->UmeId).'",
		FadCantidad = '.($this->FadCantidad).',
		FadCantidadReal = '.($this->FadCantidadReal).'
		WHERE FadId = "'.($this->FadId).'";';
					
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