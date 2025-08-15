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

class ClsProductoListaPromocion {

    
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

	public function MtdGenerarProductoListaPromocionId() {
	
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PloId,5),unsigned)) AS "MAXIMO"
		FROM tblploproductolistapromocion';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->PloId = "PLO-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->PloId = "PLO-".$fila['MAXIMO'];					
		}
			
	}
		
	
    public function MtdObtenerProductoListaPromocion(){

        $sql = 'SELECT 
		plo.PloId,
		plo.MonId,
		plo.PloTipoCambio,
		plo.PloCodigo,
		plo.PloNombre,
		plo.PloMarca,
		plo.PloPrecio,
		plo.PloPrecioReal,
		plo.PloEstado,
		DATE_FORMAT(plo.PloTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPloTiempoCreacion"
        FROM tblploproductolistapromocion plo
        WHERE plo.PloId = "'.$this->PloId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PloId = $fila['PloId'];
			$this->MonId = $fila['MonId'];
			$this->PloTipoCambio = $fila['PloTipoCambio'];
			$this->PloCodigo = $fila['PloCodigo'];
			$this->PloNombre = $fila['PloNombre'];
			$this->PloMarca = $fila['PloMarca'];
			$this->PloPrecio = $fila['PloPrecio'];
			$this->PloPrecioReal = $fila['PloPrecioReal'];
			$this->PloEstado = $fila['PloEstado'];
			$this->PloTiempoCreacion = $fila['NPloTiempoCreacion'];
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	public function MtdObtenerProductoListaPromociones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PloId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {


		//deb($oCampo." - ".$oFiltro);
		
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
			$estado = ' AND plo.PloEstado = '.$oEstado.' ';
		}

		
		 $sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		plo.PloId,
		plo.MonId,
		plo.PloTipoCambio,
		plo.PloCodigo,
		plo.PloNombre,
		plo.PloMarca,
		plo.PloPrecio,
		plo.PloPrecioReal,
		plo.PloEstado,
		DATE_FORMAT(plo.PloTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPloTiempoCreacion",
		
		mon.MonSimbolo,
		mon.MonNombre
      
        FROM tblploproductolistapromocion plo	
			LEFT JOIN tblmonmoneda mon
			ON plo.MonId = mon.MonId
				
				WHERE  1 = 1  '.$filtrar.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Producto = new $InsProducto();
					
					$Producto->PloId = $fila['PloId'];
					$Producto->MonId = $fila['MonId'];
					$Producto->PloTipoCambio = $fila['PloTipoCambio'];
					$Producto->PloCodigo = $fila['PloCodigo'];
					$Producto->PloNombre = $fila['PloNombre'];
					$Producto->PloMarca = $fila['PloMarca'];
					$Producto->PloPrecio = $fila['PloPrecio'];
					$Producto->PloPrecioReal = $fila['PloPrecioReal'];
					$Producto->PloEstado = $fila['PloEstado'];
					$Producto->PloTiempoCreacion = $fila['NPloTiempoCreacion'];
					
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
	
	public function MtdEliminarProductoListaPromocion($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PloId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PloId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblploproductolistapromocion WHERE '.$eliminar;			
		
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
	
	public function MtdEliminarTodoProductoListaPromocion() {
		
	
			$sql = 'DELETE FROM tblploproductolistapromocion ';			
		
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
	
	
	public function MtdRegistrarProductoListaPromocion() {
			
			$this->MtdGenerarProductoListaPromocionId();

			$sql = 'INSERT INTO tblploproductolistapromocion (
			PloId,
			MonId,
			PloTipoCambio,
			PloCodigo,
			PloNombre,
			PloMarca,
			PloPrecio,
			PloPrecioReal,
			PloEstado,
			PloTiempoCreacion
			) 
			VALUES (
			"'.($this->PloId).'", 
			"'.($this->MonId).'", 
			'.(empty($this->PloTipoCambio)?'NULL, ':''.$this->PloTipoCambio.',').'
			"'.($this->PloCodigo).'", 
			"'.($this->PloNombre).'", 
			"'.($this->PloMarca).'", 
			'.($this->PloPrecio).',
			'.($this->PloPrecioReal).',
			'.($this->PloEstado).',
			"'.($this->PloTiempoCreacion).'");';

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
	
	public function MtdEditarProductoListaPromocion() {

			$sql = 'UPDATE tblploproductolistapromocion SET 
			PloId = "'.($this->PloId).'",	
			MonId = "'.($this->MonId).'",	
			'.(empty($this->LtiId)?'PloTipoCambio = NULL, ':'PloTipoCambio = '.$this->PloTipoCambio.',').'
			PloCodigo = "'.($this->PloCodigo).'",
			PloNombre = "'.($this->PloNombre).'",
			PloMarca = "'.($this->PloMarca).'",
			PloPrecio = '.($this->PloPrecio).',
			PloPrecioReal = '.($this->PloPrecioReal).',
			PloEstado = '.($this->PloEstado).'
			WHERE PloId = "'.($this->PloId).'";';

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