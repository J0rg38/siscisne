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

class ClsClienteListaPrecio {

	public $ClpId;
	public $CliId;
	public $MonId;
	public $ClpTipoCambio;
	public $ClpCodigo;
	public $ClpNombre;
	public $ClpMarca;
	public $ClpPrecio;
	public $ClpPrecioReal;
	public $ClpEstado;
	public $ClpTiempoCreacion;
		
    
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

	public function MtdGenerarClienteListaPrecioId() {
	
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(ClpId,5),unsigned)) AS "MAXIMO"
		FROM tblclpclientelistaprecio';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->ClpId = "CLP-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->ClpId = "CLP-".$fila['MAXIMO'];					
		}
			
	}
		
	
    public function MtdObtenerClienteListaPrecio(){

        $sql = 'SELECT 
		clp.ClpId,
		clp.CliId,
		
		clp.MonId,
		clp.ClpTipoCambio,
		clp.ClpCodigo,
		clp.ClpNombre,
		clp.ClpMarca,
		clp.ClpPrecio,
		clp.ClpPrecioReal,
		clp.ClpEstado,
		DATE_FORMAT(clp.ClpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NClpTiempoCreacion"
        FROM tblclpclientelistaprecio clp
        WHERE clp.ClpId = "'.$this->ClpId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->ClpId = $fila['ClpId'];
			$this->CliId = $fila['CliId'];
			$this->MonId = $fila['MonId'];
			$this->ClpTipoCambio = $fila['ClpTipoCambio'];
			$this->ClpCodigo = $fila['ClpCodigo'];
			$this->ClpNombre = $fila['ClpNombre'];
			$this->ClpMarca = $fila['ClpMarca'];
			$this->ClpPrecio = $fila['ClpPrecio'];
			$this->ClpPrecioReal = $fila['ClpPrecioReal'];
			$this->ClpEstado = $fila['ClpEstado'];
			$this->ClpTiempoCreacion = $fila['NClpTiempoCreacion'];
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	public function MtdObtenerClienteListaPrecios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ClpId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oCliente=NULL) {


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
			$estado = ' AND clp.ClpEstado = '.$oEstado.' ';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND clp.CliId = "'.$oCliente.'" ';
		}

		
		 $sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		clp.ClpId,
		clp.CliId,
		clp.MonId,
		clp.ClpTipoCambio,
		clp.ClpCodigo,
		clp.ClpNombre,
		clp.ClpMarca,
		clp.ClpPrecio,
		clp.ClpPrecioReal,
		clp.ClpEstado,
		DATE_FORMAT(clp.ClpTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NClpTiempoCreacion"
      
        FROM tblclpclientelistaprecio clp	
				
				WHERE  1 = 1  '.$filtrar.$estado.$cliente.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Producto = new $InsProducto();
					
					$Producto->ClpId = $fila['ClpId'];
					$Producto->CliId = $fila['CliId'];
					$Producto->MonId = $fila['MonId'];
					$Producto->ClpTipoCambio = $fila['ClpTipoCambio'];
					$Producto->ClpCodigo = $fila['ClpCodigo'];
					$Producto->ClpNombre = $fila['ClpNombre'];
					$Producto->ClpMarca = $fila['ClpMarca'];
					$Producto->ClpPrecio = $fila['ClpPrecio'];
					$Producto->ClpPrecioReal = $fila['ClpPrecioReal'];
					$Producto->ClpEstado = $fila['ClpEstado'];
					$Producto->ClpTiempoCreacion = $fila['NClpTiempoCreacion'];

                    $Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarClienteListaPrecio($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (ClpId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (ClpId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblclpclientelistaprecio WHERE '.$eliminar;			
		
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
	
	public function MtdEliminarTodoClienteListaPrecio($oClienteId) {
		
		$sql = 'DELETE FROM tblclpclientelistaprecio WHERE CliId = "'.$oClienteId.'"';			
		
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
	
	
	public function MtdRegistrarClienteListaPrecio() {
			
			$this->MtdGenerarClienteListaPrecioId();

			$sql = 'INSERT INTO tblclpclientelistaprecio (
			ClpId,
			CliId,
			MonId,
			ClpTipoCambio,
			ClpCodigo,
			ClpNombre,
			ClpMarca,
			ClpPrecio,
			ClpPrecioReal,
			ClpEstado,
			ClpTiempoCreacion
			) 
			VALUES (
			"'.($this->ClpId).'", 
			"'.($this->CliId).'", 
			"'.($this->MonId).'", 
			'.(empty($this->ClpTipoCambio)?'NULL, ':''.$this->ClpTipoCambio.',').'
			"'.($this->ClpCodigo).'", 
			"'.($this->ClpNombre).'", 
			"'.($this->ClpMarca).'", 
			'.($this->ClpPrecio).',
			'.($this->ClpPrecioReal).',
			'.($this->ClpEstado).',
			"'.($this->ClpTiempoCreacion).'");';

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
	
	public function MtdEditarClienteListaPrecio() {

			$sql = 'UPDATE tblclpclientelistaprecio SET 
			ClpId = "'.($this->ClpId).'",	
			CliId = "'.($this->CliId).'",	
			MonId = "'.($this->MonId).'",	
			'.(empty($this->LtiId)?'ClpTipoCambio = NULL, ':'ClpTipoCambio = '.$this->ClpTipoCambio.',').'
			ClpCodigo = "'.($this->ClpCodigo).'",
			ClpNombre = "'.($this->ClpNombre).'",
			ClpMarca = "'.($this->ClpMarca).'",
			ClpPrecio = '.($this->ClpPrecio).',
			ClpPrecioReal = '.($this->ClpPrecioReal).',
			ClpEstado = '.($this->ClpEstado).'
			WHERE ClpId = "'.($this->ClpId).'";';

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
	
	
	
	public function MtdObtenerClienteListaPrecioClientes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'ClpId',$oSentido = 'Desc',$oPaginacion = '0,10') {


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

		

		
		 $sql = 'SELECT
		SQL_CALC_FOUND_ROWS 
		clp.CliId,
		cli.CliNombre,
		cli.CliNombreCompleto,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
		cli.TdoId,
		tdo.TdoNombre
		
        FROM tblclpclientelistaprecio clp	
			LEFT JOIN tblclicliente cli
			ON clp.CliId = cli.CliId
				LEFT JOIN tbltdotipodocumento tdo
				ON cli.TdoId = tdo.TdoId

		WHERE  1 = 1  '.$filtrar." GROUP BY cli.CliId ".$orden."  ".$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Producto = new $InsProducto();
					
					
					$Producto->CliId = $fila['CliId'];
					
					$Producto->CliNombre = $fila['CliNombre'];
					$Producto->CliNombreCompleto = $fila['CliNombreCompleto'];
					$Producto->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$Producto->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$Producto->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$Producto->TdoId = $fila['TdoId'];
					$Producto->TdoNombre = $fila[''];


                    $Producto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Producto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
}
?>