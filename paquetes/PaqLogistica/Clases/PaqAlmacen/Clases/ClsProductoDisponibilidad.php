<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoDisponibilidad {


	public 	$PdiId;
	public 	$PdiCodigo;
	public 	$PdiNombre;
	public 	$PdiDisponible;
	public	$PdiCantidad;
	public 	$PdiEstado;
	public 	$PdiTiempoCreacion;
	
		
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarProductoDisponibilidadId() {
	
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PdiId,5),unsigned)) AS "MAXIMO"
		FROM tblpdiproductodisponibilidad';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->PdiId = "PDI-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->PdiId = "PDI-".$fila['MAXIMO'];					
		}
			
	}
	
    public function MtdObtenerProductoDisponibilidad(){

        $sql = 'SELECT 
		pdi.PdiId,
		pdi.PdiCodigo,
		pdi.PdiNombre,
		pdi.PdiDisponible,
		pdi.PdiCantidad,
		pdi.PdiEstado,
		DATE_FORMAT(pdi.PdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPdiTiempoCreacion"
      
        FROM tblpdiproductodisponibilidad pdi
	
        WHERE pdi.PdiId = "'.$this->PdiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PdiId = $fila['PdiId'];
			$this->PdiCodigo = $fila['PdiCodigo'];
			$this->PdiNombre = $fila['PdiNombre'];
			$this->PdiDisponible = $fila['PdiDisponible'];
			$this->PdiCantidad = $fila['PdiCantidad'];
			$this->PdiEstado = $fila['PdiEstado'];
			$this->PdiTiempoCreacion = $fila['NPdiTiempoCreacion'];
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	public function MtdObtenerProductoDisponibilidades($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oDisponible=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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

		if(!empty($oEstado)){
			$estado = ' AND pdi.PdiEstado = '.$oEstado.' ';
		}
		
		if(!empty($oDisponible)){
			$disponible = ' AND pdi.PdiDisponible = '.$oDisponible.' ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pdi.PdiId,
		pdi.PdiCodigo,
		pdi.PdiNombre,
		pdi.PdiDisponible,
		pdi.PdiCantidad,
		pdi.PdiEstado,
		DATE_FORMAT(pdi.PdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPdiTiempoCreacion"
      
        FROM tblpdiproductodisponibilidad pdi	
				
				WHERE  1 = 1  '.$filtrar.$disponible.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Producto = new $InsProducto();
					
					$Producto->PdiId = $fila['PdiId'];
					$Producto->PdiCodigo = $fila['PdiCodigo'];
					$Producto->PdiNombre = $fila['PdiNombre'];
					$Producto->PdiDisponible = $fila['PdiDisponible'];
					$Producto->PdiCantidad = $fila['PdiCantidad'];
					$Producto->PdiEstado = $fila['PdiEstado'];
					$Producto->PdiTiempoCreacion = $fila['NPdiTiempoCreacion'];

                    $Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	//Accion eliminar	 
	
	public function MtdEliminarProductoDisponibilidad($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PdiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PdiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblpdiproductodisponibilidad WHERE '.$eliminar;			
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	public function MtdEliminarTodoProductoDisponibilidad() {

			$sql = 'DELETE FROM tblpdiproductodisponibilidad ';			
		
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarProductoDisponibilidad() {
			
			$this->MtdGenerarProductoDisponibilidadId();
			
			$sql = 'INSERT INTO tblpdiproductodisponibilidad (
		
			PdiCodigo,
			PdiNombre,
			PdiDisponible,
			PdiCantidad,
			PdiEstado,
			PdiTiempoCreacion
			) 
			VALUES (
			
			"'.($this->PdiCodigo).'", 
			"'.($this->PdiNombre).'", 
			'.($this->PdiDisponible).',
			'.($this->PdiCantidad).',
			'.($this->PdiEstado).',
			"'.($this->PdiTiempoCreacion).'");';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	public function MtdEditarProductoDisponibilidad() {

			
			$sql = 'UPDATE tblpdiproductodisponibilidad SET 
			PdiId = "'.($this->PdiId).'",	
			PdiCodigo = "'.($this->PdiCodigo).'",
			PdiNombre = "'.($this->PdiNombre).'",
			PdiDisponible = '.($this->PdiDisponible).',
			PdiCantidad = '.($this->PdiCantidad).',
			PdiEstado = '.($this->PdiEstado).'
			WHERE PdiId = "'.($this->PdiId).'";';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
	}	
	
}
?>