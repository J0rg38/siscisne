<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoFoto {

    public $PfoId;
	public $ProId;
	public $PfoArchivo;
	public $PfoTipo;
	public $PfoEstado;	
	public $PfoCodigoExterno;
	public $PfoTiempoCreacion;
	public $PfoTiempoModificacion;
    public $PfoEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarProductoFotoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PfoId,5),unsigned)) AS "MAXIMO"
			FROM tblpfoproductofoto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PfoId = "PFO-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PfoId = "PFO-".$fila['MAXIMO'];					
			}
				
	}

	public function MtdObtenerProductoFoto(){

        $sql = 'SELECT 
			pfo.PfoId,			
			pfo.ProId,
			pfo.PfoArchivo,
			pfo.PfoTipo,
			pfo.PfoEstado,
			DATE_FORMAT(pfo.PfoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPfoTiempoCreacion",
	        DATE_FORMAT(pfo.PfoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPfoTiempoModificacion"
			FROM tblpfoproductofoto pfo
        WHERE pfo.PfoId = "'.$this->PfoId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			  $this->PfoId = $fila['PfoId'];
			  $this->ProId = $fila['ProId'];
			  $this->PfoArchivo = $fila['PfoArchivo']; 
			  $this->PfoTipo = $fila['PfoTipo'];  
			  $this->PfoEstado = $fila['PfoEstado'];  
			  $this->PfoTiempoCreacion = $fila['NPfoTiempoCreacion'];  
			  $this->PfoTiempoModificacion = $fila['NPfoTiempoModificacion']; 	
					
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
    public function MtdObtenerProductoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PfoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oEstado=NULL,$oTipo=NULL) {

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
		
		if(!empty($oProducto)){
			$cproducto = ' AND pfo.ProId = "'.$oProducto.'"';
		}

		if(!empty($oEstado)){
			$estado = ' AND pfo.PfoEstado = '.$oEstado.' ';
		}

		if(!empty($oTipo)){
			$tipo = ' AND pfo.PfoTipo = "'.$oTipo.'" ';
		}

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			pfo.PfoId,			
			pfo.ProId,
			pfo.PfoArchivo,
			pfo.PfoTipo,
			pfo.PfoEstado,
			DATE_FORMAT(pfo.PfoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPfoTiempoCreacion",
	        DATE_FORMAT(pfo.PfoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPfoTiempoModificacion"
			FROM tblpfoproductofoto pfo
			WHERE  1 = 1 '.$cproducto.$estado.$producto.$filtrar.$tipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoFoto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ProductoFoto = new $InsProductoFoto();
                    $ProductoFoto->PfoId = $fila['PfoId'];
                    $ProductoFoto->ProId = $fila['ProId'];
					$ProductoFoto->PfoArchivo = $fila['PfoArchivo']; 
					$ProductoFoto->PfoTipo = $fila['PfoTipo'];  
					$ProductoFoto->PfoEstado = $fila['PfoEstado'];  
					$ProductoFoto->PfoTiempoCreacion = $fila['NPfoTiempoCreacion'];  
					$ProductoFoto->PfoTiempoModificacion = $fila['NPfoTiempoModificacion']; 					
					
                    $ProductoFoto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ProductoFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarProductoFoto($oElementos) {
		

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (PfoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PfoId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblpfoproductofoto 
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
	
	
	public function MtdRegistrarProductoFoto() {
	
			$this->MtdGenerarProductoFotoId();
			
			$sql = 'INSERT INTO tblpfoproductofoto (
			PfoId,
			ProId,
			PfoArchivo,
		
			PfoTipo,
			PfoEstado,
			PfoTiempoCreacion,
			PfoTiempoModificacion) 
			VALUES (
			"'.($this->PfoId).'", 
			"'.($this->ProId).'", 
			"'.($this->PfoArchivo).'", 
			
			"'.($this->PfoTipo).'",
			'.($this->PfoEstado).',
			"'.($this->PfoTiempoCreacion).'",
			"'.($this->PfoTiempoModificacion).'");';
		
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
	
	public function MtdEditarProductoFoto() {

		$sql = 'UPDATE tblpfoproductofoto SET 	
		PfoArchivo = "'.($this->PfoArchivo).'",
		PfoEstado = '.($this->PfoEstado).'
		WHERE PfoId = "'.($this->PfoId).'";';

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