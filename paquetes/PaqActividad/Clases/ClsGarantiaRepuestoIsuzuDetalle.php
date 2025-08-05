<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGarantiaRepuestoIsuzuDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGarantiaRepuestoIsuzuDetalle {

    public $GdiId;
	public $GriId;
	
	public $ProId;
	public $UmeId;
	public $AmdId;
	
	public $GdiCodigo;
	public $GdiNombre;
	
	public $GdiCosto;
    public $GdiCantidad;
	public $GdiValorTotal;
	public $GdiMargen;
	public $GdiCostoMagen;
	
	public $GdiEstado;	
	public $GdiTiempoCreacion;
	public $GdiTiempoModificacion;
    public $GdiEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarGarantiaRepuestoIsuzuDetalleId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(GdiId,5),unsigned)) AS "MAXIMO"
		FROM tblgdigarantiarepuestoisuzudetalle';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->GdiId = "GDI-10000";
		}else{
			$fila['MAXIMO']++;
			$this->GdiId = "GDI-".$fila['MAXIMO'];					
		}
				
	}

    public function MtdObtenerGarantiaRepuestoIsuzuDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGarantia=NULL,$oEstado=NULL,$oProducto=NULL) {

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
		
		if(!empty($oGarantia)){
			$garantia = ' AND gdi.GriId = "'.$oGarantia.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND gdi.GdiEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (gdi.ProId = "'.$oProducto.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			gdi.GdiId,			
			gdi.GriId,
			
			gdi.AmdId,
			gdi.ProId,
			gdi.UmeId,
			
			gdi.GdiCodigo,
			gdi.GdiNombre,
			gdi.GdiCantidad,
			gdi.GdiValorTotal,
			
			gdi.GdiEstado,
			DATE_FORMAT(gdi.GdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGdiTiempoCreacion",
	        DATE_FORMAT(gdi.GdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGdiTiempoModificacion",
			
			pro.ProCodigoOriginal,
			pro.ProNombre,
			ume.UmeNombre
			
			FROM tblgdigarantiarepuestoisuzudetalle gdi
				LEFT JOIN tblproproducto pro
				ON gdi.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON gdi.UmeId = ume.UmeId
					
			WHERE  1 = 1 '.$garantia.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGarantiaRepuestoIsuzuDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GarantiaRepuestoIsuzuDetalle = new $InsGarantiaRepuestoIsuzuDetalle();
                    $GarantiaRepuestoIsuzuDetalle->GdiId = $fila['GdiId'];
                    $GarantiaRepuestoIsuzuDetalle->GriId = $fila['GriId'];
					
					$GarantiaRepuestoIsuzuDetalle->AmdId = $fila['AmdId'];
					$GarantiaRepuestoIsuzuDetalle->ProId = $fila['ProId'];
					$GarantiaRepuestoIsuzuDetalle->UmeId = $fila['UmeId'];

					$GarantiaRepuestoIsuzuDetalle->GdiCodigo = $fila['GdiCodigo'];  
					$GarantiaRepuestoIsuzuDetalle->GdiNombre = $fila['GdiNombre'];  
			        $GarantiaRepuestoIsuzuDetalle->GdiCantidad = $fila['GdiCantidad'];  
					$GarantiaRepuestoIsuzuDetalle->GdiValorTotal = $fila['GdiValorTotal'];
					
					$GarantiaRepuestoIsuzuDetalle->GdiEstado = $fila['GdiEstado'];
					$GarantiaRepuestoIsuzuDetalle->GdiTiempoCreacion = $fila['NGdiTiempoCreacion'];  
					$GarantiaRepuestoIsuzuDetalle->GdiTiempoModificacion = $fila['NGdiTiempoModificacion'];
					
					$GarantiaRepuestoIsuzuDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$GarantiaRepuestoIsuzuDetalle->ProNombre = $fila['ProNombre']; 
					$GarantiaRepuestoIsuzuDetalle->UmeNombre = $fila['UmeNombre'];  					
	
                    $GarantiaRepuestoIsuzuDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GarantiaRepuestoIsuzuDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarGarantiaRepuestoIsuzuDetalle($oElementos) {
		
//		$InsGarantiaRepuestoIsuzuDetalleOrigen = new ClsGarantiaRepuestoIsuzuDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (GdiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GdiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblgdigarantiarepuestoisuzudetalle 
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
	
	
	public function MtdRegistrarGarantiaRepuestoIsuzuDetalle() {
	
			$this->MtdGenerarGarantiaRepuestoIsuzuDetalleId();
			
			$sql = 'INSERT INTO tblgdigarantiarepuestoisuzudetalle (
			GdiId,
			GriId,
			
			AmdId,
			ProId,
			UmeId,
			
			GdiCodigo,
			GdiNombre,
			GdiCantidad,
			GdiValorTotal,
			
			GdiEstado,
			GdiTiempoCreacion,
			GdiTiempoModificacion) 
			VALUES (
			"'.($this->GdiId).'", 
			"'.($this->GriId).'", 
			
			'.(empty($this->AmdId)?'NULL,':'"'.$this->AmdId.'",').'	
			'.(empty($this->ProId)?'NULL,':'"'.$this->ProId.'",').'	
			'.(empty($this->UmeId)?'NULL,':'"'.$this->UmeId.'",').'				

			"'.($this->GdiCodigo).'", 
			"'.($this->GdiNombre).'", 
			'.($this->GdiCantidad).',
			'.($this->GdiValorTotal).', 	
			
			'.($this->GdiEstado).',
			"'.($this->GdiTiempoCreacion).'",
			"'.($this->GdiTiempoModificacion).'");';
		
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
	
	public function MtdEditarGarantiaRepuestoIsuzuDetalle() {

			$sql = 'UPDATE tblgdigarantiarepuestoisuzudetalle SET 	
			
			'.(empty($this->ProId)?'ProId = NULL, ':'ProId = "'.$this->ProId.'",').'
			'.(empty($this->UmeId)?'UmeId = NULL, ':'UmeId = "'.$this->UmeId.'",').'
		
			GdiCodigo = "'.($this->GdiCodigo).'",
			GdiNombre = "'.($this->GdiNombre).'",
			GdiCantidad = '.($this->GdiCantidad).',
			GdiValorTotal = '.($this->GdiValorTotal).',
			
			GdiTiempoModificacion = "'.($this->GdiTiempoModificacion).'"
			
			WHERE GdiId = "'.($this->GdiId).'";';
					
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