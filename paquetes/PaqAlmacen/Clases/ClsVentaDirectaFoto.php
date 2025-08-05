<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVentaDirectaFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVentaDirectaFoto {

    public $VdfId;
	public $VdiId;
	public $VdfArchivo;
	public $VdfTipo;
	public $VdfEstado;	
	public $VdfCodigoExterno;
	public $VdfTiempoCreacion;
	public $VdfTiempoModificacion;
    public $VdfEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarVentaDirectaFotoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VdfId,5),unsigned)) AS "MAXIMO"
			FROM tblvdfventadirectafoto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VdfId = "VDF-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VdfId = "VDF-".$fila['MAXIMO'];					
			}
				
	}

	public function MtdObtenerVentaDirectaFoto(){

        $sql = 'SELECT 
			vdf.VdfId,			
			vdf.VdiId,
			vdf.VdfArchivo,
			vdf.VdfTipo,
			vdf.VdfCodigoExterno,
			vdf.VdfEstado,
			DATE_FORMAT(vdf.VdfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdfTiempoCreacion",
	        DATE_FORMAT(vdf.VdfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdfTiempoModificacion"
			FROM tblvdfventadirectafoto vdf
        WHERE vdf.VdfId = "'.$this->VdfId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			  $this->VdfId = $fila['VdfId'];
			  $this->VdiId = $fila['VdiId'];
			  $this->VdfArchivo = $fila['VdfArchivo']; 
			   $this->VdfTipo = $fila['VdfTipo'];  
 
 				$this->VdfCodigoExterno = $fila['VdfCodigoExterno']; 
			  $this->VdfEstado = $fila['VdfEstado'];  
			  $this->VdfTiempoCreacion = $fila['NVdfTiempoCreacion'];  
			  $this->VdfTiempoModificacion = $fila['NVdfTiempoModificacion']; 	
					
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
    public function MtdObtenerVentaDirectaFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VdfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVentaDirecta=NULL,$oEstado=NULL,$oTipo=NULL) {

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
		
		if(!empty($oVentaDirecta)){
			$cproducto = ' AND vdf.VdiId = "'.$oVentaDirecta.'"';
		}

		if(!empty($oEstado)){
			$estado = ' AND vdf.VdfEstado = '.$oEstado.' ';
		}

		if(!empty($oTipo)){
			$tipo = ' AND vdf.VdfTipo = "'.$oTipo.'" ';
		}

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			vdf.VdfId,			
			vdf.VdiId,
			vdf.VdfArchivo,
			vdf.VdfTipo,
			vdf.VdfCodigoExterno,
			vdf.VdfEstado,
			DATE_FORMAT(vdf.VdfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVdfTiempoCreacion",
	        DATE_FORMAT(vdf.VdfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVdfTiempoModificacion"
			FROM tblvdfventadirectafoto vdf
			WHERE  1 = 1 '.$cproducto.$estado.$producto.$filtrar.$tipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVentaDirectaFoto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$VentaDirectaFoto = new $InsVentaDirectaFoto();
                    $VentaDirectaFoto->VdfId = $fila['VdfId'];
                    $VentaDirectaFoto->VdiId = $fila['VdiId'];
					$VentaDirectaFoto->VdfArchivo = $fila['VdfArchivo'];  
					
					$VentaDirectaFoto->VdfTipo = $fila['VdfTipo'];  
					$VentaDirectaFoto->VdfCodigoExterno = $fila['VdfCodigoExterno'];  
					$VentaDirectaFoto->VdfEstado = $fila['VdfEstado'];  
					$VentaDirectaFoto->VdfTiempoCreacion = $fila['NVdfTiempoCreacion'];  
					$VentaDirectaFoto->VdfTiempoModificacion = $fila['NVdfTiempoModificacion']; 					
					
                    $VentaDirectaFoto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $VentaDirectaFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVentaDirectaFoto($oElementos) {
		

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (VdfId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VdfId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblvdfventadirectafoto 
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
	
	
	public function MtdRegistrarVentaDirectaFoto() {
	
			$this->MtdGenerarVentaDirectaFotoId();
			
			$sql = 'INSERT INTO tblvdfventadirectafoto (
			VdfId,
			VdiId,
			VdfArchivo,
		
			VdfTipo,
			VdfCodigoExterno,
			VdfEstado,
			VdfTiempoCreacion,
			VdfTiempoModificacion) 
			VALUES (
			"'.($this->VdfId).'", 
			"'.($this->VdiId).'", 
			"'.($this->VdfArchivo).'", 
			
			"'.($this->VdfTipo).'",
			"'.($this->VdfCodigoExterno).'",
			'.($this->VdfEstado).',
			"'.($this->VdfTiempoCreacion).'",
			"'.($this->VdfTiempoModificacion).'");';
		
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
	
	public function MtdEditarVentaDirectaFoto() {

		$sql = 'UPDATE tblvdfventadirectafoto SET 	
		VdfArchivo = "'.($this->VdfArchivo).'",
		VdfEstado = '.($this->VdfEstado).'
		WHERE VdfId = "'.($this->VdfId).'";';

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