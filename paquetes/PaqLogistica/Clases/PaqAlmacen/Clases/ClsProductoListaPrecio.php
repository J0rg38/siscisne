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

class ClsProductoListaPrecio {

    
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarProductoListaPrecioId() {
	
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PlpId,5),unsigned)) AS "MAXIMO"
		FROM tblplpproductolistaprecio';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->PlpId = "PLP-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->PlpId = "PLP-".$fila['MAXIMO'];					
		}
			
	}
		
	
    public function MtdObtenerProductoListaPrecio(){

        $sql = 'SELECT 
		plp.PlpId,
		plp.MonId,
		plp.PlpTipoCambio,
		plp.PlpCodigo,
		plp.PlpNombre,
		plp.PlpMarca,
		plp.PlpPrecio,
		plp.PlpPrecioReal,
		plp.PlpEstado,
		DATE_FORMAT(plp.PlpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPlpTiempoCreacion"
        FROM tblplpproductolistaprecio plp
        WHERE plp.PlpId = "'.$this->PlpId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PlpId = $fila['PlpId'];
			$this->MonId = $fila['MonId'];
			$this->PlpTipoCambio = $fila['PlpTipoCambio'];
			$this->PlpCodigo = $fila['PlpCodigo'];
			$this->PlpNombre = $fila['PlpNombre'];
			$this->PlpMarca = $fila['PlpMarca'];
			$this->PlpPrecio = $fila['PlpPrecio'];
			$this->PlpPrecioReal = $fila['PlpPrecioReal'];
			$this->PlpEstado = $fila['PlpEstado'];
			$this->PlpTiempoCreacion = $fila['NPlpTiempoCreacion'];
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	public function MtdObtenerProductoListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PlpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {


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
			$estado = ' AND plp.PlpEstado = '.$oEstado.' ';
		}

		
		 $sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		plp.PlpId,
		plp.MonId,
		plp.PlpTipoCambio,
		plp.PlpCodigo,
		plp.PlpNombre,
		plp.PlpMarca,
		plp.PlpPrecio,
		plp.PlpPrecioReal,
		plp.PlpEstado,
		DATE_FORMAT(plp.PlpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPlpTiempoCreacion",
		
		mon.MonSimbolo,
		mon.MonNombre
      
        FROM tblplpproductolistaprecio plp	
			LEFT JOIN tblmonmoneda mon
			ON plp.MonId = mon.MonId
				
				WHERE  1 = 1  '.$filtrar.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Producto = new $InsProducto();
					
					$Producto->PlpId = $fila['PlpId'];
					$Producto->MonId = $fila['MonId'];
					$Producto->PlpTipoCambio = $fila['PlpTipoCambio'];
					$Producto->PlpCodigo = $fila['PlpCodigo'];
					$Producto->PlpNombre = $fila['PlpNombre'];
					$Producto->PlpMarca = $fila['PlpMarca'];
					$Producto->PlpPrecio = $fila['PlpPrecio'];
					$Producto->PlpPrecioReal = $fila['PlpPrecioReal'];
					$Producto->PlpEstado = $fila['PlpEstado'];
					$Producto->PlpTiempoCreacion = $fila['NPlpTiempoCreacion'];
					
					$Producto->MonSimbolo = $fila['MonSimbolo'];
					$Producto->MonNombre = $fila['MonNombre'];


		
                    $Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarProductoListaPrecio($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PlpId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PlpId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblplpproductolistaprecio WHERE '.$eliminar;			
		
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
	
	public function MtdEliminarTodoProductoListaPrecio() {
		
	
			$sql = 'DELETE FROM tblplpproductolistaprecio ';			
		
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
	
	
	public function MtdRegistrarProductoListaPrecio() {
			
			//$this->MtdGenerarProductoListaPrecioId();

			$sql = 'INSERT INTO tblplpproductolistaprecio (
			
			MonId,
			PlpTipoCambio,
			PlpCodigo,
			PlpNombre,
			PlpMarca,
			PlpPrecio,
			PlpPrecioReal,
			PlpEstado,
			PlpTiempoCreacion
			) 
			VALUES (
			
			"'.($this->MonId).'", 
			'.(empty($this->PlpTipoCambio)?'NULL, ':''.$this->PlpTipoCambio.',').'
			"'.($this->PlpCodigo).'", 
			"'.($this->PlpNombre).'", 
			"'.($this->PlpMarca).'", 
			'.($this->PlpPrecio).',
			'.($this->PlpPrecioReal).',
			'.($this->PlpEstado).',
			"'.($this->PlpTiempoCreacion).'");';

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
	
	public function MtdEditarProductoListaPrecio() {

			$sql = 'UPDATE tblplpproductolistaprecio SET 
			PlpId = "'.($this->PlpId).'",	
			MonId = "'.($this->MonId).'",	
			'.(empty($this->LtiId)?'PlpTipoCambio = NULL, ':'PlpTipoCambio = '.$this->PlpTipoCambio.',').'
			PlpCodigo = "'.($this->PlpCodigo).'",
			PlpNombre = "'.($this->PlpNombre).'",
			PlpMarca = "'.($this->PlpMarca).'",
			PlpPrecio = '.($this->PlpPrecio).',
			PlpPrecioReal = '.($this->PlpPrecioReal).',
			PlpEstado = '.($this->PlpEstado).'
			WHERE PlpId = "'.($this->PlpId).'";';

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