<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoHerramienta
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoHerramienta {

    public $FihId;
	public $FinId;
	public $ProId;
	public $UmeId;
	public $FihCantidad;
	public $FihCantidadReal;
	public $FihEstado;
	public $FihTiempoCreacion;
	public $FihTiempoModificacion;
    public $FihEliminado;
	
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $ProNombre;
	public $RtiId;
	public $UmeIdOrigen;
	public $UmeNombre;
	
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

	private function MtdGenerarFichaIngresoHerramientaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FihId,5),unsigned)) AS "MAXIMO"
		FROM tblfihfichaingresoherramienta';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FihId = "FIH-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FihId = "FIH-".$fila['MAXIMO'];					
		}

	}
	

    	public function MtdObtenerFichaIngresoHerramientas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FihId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL) {
		
		// Inicializar variables para evitar warnings
		$fingreso = '';
		$estado = '';
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
		
		if(!empty($oFichaIngreso)){
			$fingreso = ' AND fih.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fih.FihEstado = '.$oEstado.'';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fih.FihId,			
			fih.FinId,
			fih.ProId,
			fih.UmeId,
			fih.FihCantidad,
			fih.FihCantidadReal,
			
			fih.FihEstado,
			DATE_FORMAT(fih.FihTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFihTiempoCreacion",
	        DATE_FORMAT(fih.FihTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFihTiempoModificacion",
		
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.ProNombre,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			ume.UmeNombre
					
			FROM tblfihfichaingresoherramienta fih
				LEFT JOIN tblproproducto pro
				ON fih.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON pro.UmeId = ume.UmeId
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoHerramienta = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoHerramienta = new $InsFichaIngresoHerramienta();
                    $FichaIngresoHerramienta->FihId = $fila['FihId'];
                    $FichaIngresoHerramienta->FinId = $fila['FinId'];					
					$FichaIngresoHerramienta->ProId = $fila['ProId'];
					$FichaIngresoHerramienta->UmeId = $fila['UmeId'];

					$FichaIngresoHerramienta->FihCantidad = $fila['FihCantidad'];
					$FichaIngresoHerramienta->FihCantidadReal = $fila['FihCantidadReal'];

					$FichaIngresoHerramienta->FihEstado = $fila['FihEstado'];
					$FichaIngresoHerramienta->FihTiempoCreacion = $fila['NFihTiempoCreacion'];  
					$FichaIngresoHerramienta->FihTiempoModificacion = $fila['NFihTiempoModificacion']; 

					$FichaIngresoHerramienta->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$FichaIngresoHerramienta->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
                    $FichaIngresoHerramienta->ProNombre = (($fila['ProNombre']));
					$FichaIngresoHerramienta->RtiId = (($fila['RtiId']));
					$FichaIngresoHerramienta->UmeIdOrigen = (($fila['UmeIdOrigen']));
					
					$FichaIngresoHerramienta->UmeNombre = (($fila['UmeNombre']));

                    $FichaIngresoHerramienta->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoHerramienta;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoHerramienta($oElementos) {

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
		
				
				$sql = 'DELETE FROM tblfihfichaingresoherramienta 
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
	
	
	public function MtdRegistrarFichaIngresoHerramienta() {
	
			$this->MtdGenerarFichaIngresoHerramientaId();
			
			$sql = 'INSERT INTO tblfihfichaingresoherramienta (
			FihId,
			FinId,	
			ProId,
			UmeId,
			FihCantidad,
			FihCantidadReal,
			FihEstado,
			FihTiempoCreacion,
			FihTiempoModificacion) 
			VALUES (
			"'.($this->FihId).'", 
			"'.($this->FinId).'", 
			"'.($this->ProId).'",
			"'.($this->UmeId).'",
			'.($this->FihCantidad).',
			'.($this->FihCantidadReal).',
			'.($this->FihEstado).',
			"'.($this->FihTiempoCreacion).'",
			"'.($this->FihTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaIngresoHerramienta() {

		$sql = 'UPDATE tblfihfichaingresoherramienta SET 	
		UmeId = "'.($this->UmeId).'",
		FihCantidad = '.($this->FihCantidad).',
		FihCantidadReal = '.($this->FihCantidadReal).'
		WHERE FihId = "'.($this->FihId).'";';
				
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