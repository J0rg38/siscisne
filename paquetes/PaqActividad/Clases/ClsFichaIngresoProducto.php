<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoProducto {

    public $FipId;
	public $FimId;
	public $ProId;
	public $UmeId;
	public $FipCantidad;
	
	public $FipEstado;
	public $FipTiempoCreacion;
	public $FipTiempoModificacion;
    public $FipEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	
	public $Minsigla;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaIngresoProductoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FipId,5),unsigned)) AS "MAXIMO"
		FROM tblfipfichaingresoproducto';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FipId = "FIP-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FipId = "FIP-".$fila['MAXIMO'];					
		}

	}
	

    public function MtdObtenerFichaIngresoProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FipId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL) {

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
			$fingreso = ' AND fip.FimId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fip.FipEstado = '.$oEstado.'';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fip.FipId,			
			fip.FimId,
			fip.ProId,
			fip.UmeId,
			fip.FipCantidad,
			
			fip.FipEstado,
			DATE_FORMAT(fip.FipTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFipTiempoCreacion",
	        DATE_FORMAT(fip.FipTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFipTiempoModificacion",
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			pro.UmeId AS UmeIdOrigen,
			
			min.MinSigla,
			ume.UmeNombre		
		
			FROM tblfipfichaingresoproducto fip
				LEFT JOIN tblumeunidadmedida ume
				ON fip.UmeId = ume.UmeId
				
				LEFT JOIN tblproproducto pro
				ON fip.ProId = pro.ProId
					LEFT JOIN tblfimfichaingresomodalidad fim
					ON fip.FimId = fim.FimId
						LEFT JOIN tblminmodalidadingreso min
						ON fim.MinId = min.MinId
			WHERE  1 = 1 '.$fingreso.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoProducto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoProducto = new $InsFichaIngresoProducto();
                    $FichaIngresoProducto->FipId = $fila['FipId'];
                    $FichaIngresoProducto->FimId = $fila['FimId'];					
					$FichaIngresoProducto->ProId = $fila['ProId'];	
					$FichaIngresoProducto->UmeId = $fila['UmeId'];	
					$FichaIngresoProducto->FipCantidad = $fila['FipCantidad'];	
					
					$FichaIngresoProducto->FipEstado = $fila['FipEstado'];
					$FichaIngresoProducto->FipTiempoCreacion = $fila['NFipTiempoCreacion'];  
					$FichaIngresoProducto->FipTiempoModificacion = $fila['NFipTiempoModificacion']; 
					
					$FichaIngresoProducto->ProNombre = $fila['ProNombre']; 
					$FichaIngresoProducto->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$FichaIngresoProducto->ProCodigoAlternativo = $fila['ProCodigoAlternativo']; 
					$FichaIngresoProducto->RtiId = $fila['RtiId']; 
					$FichaIngresoProducto->UmeIdOrigen = $fila['UmeIdOrigen']; 
			
					$FichaIngresoProducto->MinSigla = $fila['MinSigla']; 
					$FichaIngresoProducto->UmeNombre = $fila['UmeNombre']; 
					

                    $FichaIngresoProducto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoProducto($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FipId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FipId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfipfichaingresoproducto 
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
	
	
	public function MtdRegistrarFichaIngresoProducto() {
	
			$this->MtdGenerarFichaIngresoProductoId();
			
			$sql = 'INSERT INTO tblfipfichaingresoproducto (
			FipId,
			FimId,	
			ProId,
			UmeId,
			FipCantidad,
			
			FipEstado,
			FipTiempoCreacion,
			FipTiempoModificacion) 
			VALUES (
			"'.($this->FipId).'", 
			"'.($this->FimId).'", 
			"'.($this->ProId).'", 
				'.(empty($this->UmeId)?'NULL, ':'"'.$this->UmeId.'",').'	
				'.($this->FipCantidad).',	
				
			'.($this->FipEstado).',
			"'.($this->FipTiempoCreacion).'",
			"'.($this->FipTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaIngresoProducto() {

		$sql = 'UPDATE tblfipfichaingresoproducto SET 	
		ProId = "'.($this->ProId).'",
		UmeId = "'.($this->UmeId).'",
		FipCantidad = '.($this->FipCantidad).',
		FipEstado = '.($this->FipEstado).',
		FipTiempoModificacion = "'.($this->FipTiempoModificacion).'"
		
		 WHERE FipId = "'.($this->FipId).'";';
			// FipEstado = '.($this->FipEstado).'	
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