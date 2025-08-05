<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenMovimientoEntradaExtorno
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAlmacenMovimientoEntradaExtorno {

    public $AmeId;
	public $AmoId;
	public $ProId;
	public $UmeId;
    public $AmeCantidad;	
	public $AmeCantidadReal;
	public $AmeEstado;	
	public $AmeTiempoCreacion;
	public $AmeTiempoModificacion;
    public $AmeEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $RtiId;
	public $UmeNombre;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarAlmacenMovimientoEntradaExtornoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(AmeId,5),unsigned)) AS "MAXIMO"
		FROM tblamealmacenmovimientoextorno';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->AmeId = "AME-10000";
		}else{
			$fila['MAXIMO']++;
			$this->AmeId = "AME-".$fila['MAXIMO'];					
		}

	}

    public function MtdObtenerAlmacenMovimientoEntradaExtornos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AmeId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oAlmacenMovimientoEntrada=NULL,$oEstado=NULL,$oProducto=NULL) {

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
		
		if(!empty($oAlmacenMovimientoEntrada)){
			$amovimiento = ' AND ame.AmoId = "'.$oAlmacenMovimientoEntrada.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ame.AmeEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (ame.ProId = "'.$oProducto.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ame.AmeId,			
			ame.AmoId,
			ame.ProId,
			ame.UmeId,
			ame.AmeCantidad,
			ame.AmeCantidadReal,
			DATE_FORMAT(ame.AmeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAmeTiempoCreacion",
	        DATE_FORMAT(ame.AmeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAmeTiempoModificacion",
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			ume.UmeNombre,
			DATE_FORMAT(amo.AmoFecha, "%d/%m/%Y") AS "NAmoFecha"
			FROM tblamealmacenmovimientoextorno ame
				LEFT JOIN tblproproducto pro
				ON ame.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON ame.UmeId = ume.UmeId					
						LEFT  JOIN tblamoalmacenmovimiento amo
						ON ame.AmoId = amo.AmoId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenMovimientoEntradaExtorno = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$AlmacenMovimientoEntradaExtorno = new $InsAlmacenMovimientoEntradaExtorno();
                    $AlmacenMovimientoEntradaExtorno->AmeId = $fila['AmeId'];
                    $AlmacenMovimientoEntradaExtorno->AmoId = $fila['AmoId'];
					$AlmacenMovimientoEntradaExtorno->UmeId = $fila['UmeId'];

			        $AlmacenMovimientoEntradaExtorno->AmeCantidad = $fila['AmeCantidad'];  
					$AlmacenMovimientoEntradaExtorno->AmeCantidadReal = $fila['AmeCantidadReal'];  
					
					$AlmacenMovimientoEntradaExtorno->AmeTiempoCreacion = $fila['NAmeTiempoCreacion'];  
					$AlmacenMovimientoEntradaExtorno->AmeTiempoModificacion = $fila['NAmeTiempoModificacion']; 					
					$AlmacenMovimientoEntradaExtorno->ProId = $fila['ProId'];	
					
					$AlmacenMovimientoEntradaExtorno->AmoFecha = $fila['NAmoFecha'];	
					
                    $AlmacenMovimientoEntradaExtorno->ProNombre = (($fila['ProNombre']));
					$AlmacenMovimientoEntradaExtorno->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$AlmacenMovimientoEntradaExtorno->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$AlmacenMovimientoEntradaExtorno->RtiId = (($fila['RtiId']));
					$AlmacenMovimientoEntradaExtorno->UmeNombre = (($fila['UmeNombre']));
					
                    $AlmacenMovimientoEntradaExtorno->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $AlmacenMovimientoEntradaExtorno;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarAlmacenMovimientoEntradaExtorno($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (AmeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AmeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblamealmacenmovimientoextorno 
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
	
	
	public function MtdRegistrarAlmacenMovimientoEntradaExtorno() {
	
			$this->MtdGenerarAlmacenMovimientoEntradaExtornoId();
			
			$sql = 'INSERT INTO tblamealmacenmovimientoextorno (
			AmeId,
			AmoId,	
			ProId,
			UmeId,
			AmeCantidad,
			AmeCantidadReal,
			AmeEstado,
			AmeTiempoCreacion,
			AmeTiempoModificacion,
			AmeEliminado) 
			VALUES (
			"'.($this->AmeId).'", 
			"'.($this->AmoId).'", 
			"'.($this->ProId).'",
			"'.($this->UmeId).'",
			'.($this->AmeCantidad).',
			'.($this->AmeCantidadReal).',
			'.($this->AmeEstado).',
			"'.($this->AmeTiempoCreacion).'",
			"'.($this->AmeTiempoModificacion).'", 													
			'.($this->AmeEliminado).');';					
		
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
	
	public function MtdEditarAlmacenMovimientoEntradaExtorno() {

			$sql = 'UPDATE tblamealmacenmovimientoextorno SET 	
			 UmeId = "'.($this->UmeId).'",
			 AmeCantidad = '.($this->AmeCantidad).',
			 AmeCantidadReal = '.($this->AmeCantidadReal).'
			 WHERE AmeId = "'.($this->AmeId).'";';
					
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