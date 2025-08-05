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

class ClsProductoReemplazo {

    
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarProductoReemplazoId() {
	
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PreId,5),unsigned)) AS "MAXIMO"
		FROM tblpreproductoreemplazo';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->PreId = "PRE-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->PreId = "PRE-".$fila['MAXIMO'];					
		}
			
	}
		
	
    public function MtdObtenerProductoReemplazo(){

        $sql = 'SELECT 
		pre.PreId,
		pre.PreCodigo1,
		pre.PreCodigo2,
		pre.PreCodigo3,
		pre.PreCodigo4,
		pre.PreCodigo5,
		pre.PreCodigo6,
		pre.PreCodigo7,
		pre.PreCodigo8,
		pre.PreCodigo9,
		pre.PreCodigo10,
		pre.PreEstado,
		DATE_FORMAT(pre.PreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPreTiempoCreacion"
      
        FROM tblpreproductoreemplazo pre
	
        WHERE pre.PreId = "'.$this->PreId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PreId = $fila['PreId'];
			$this->PreCodigo1 = $fila['PreCodigo1'];
			$this->PreCodigo2 = $fila['PreCodigo2'];
			$this->PreCodigo3 = $fila['PreCodigo3'];
			$this->PreCodigo4 = $fila['PreCodigo4'];
			$this->PreCodigo5 = $fila['PreCodigo5'];
			$this->PreCodigo6 = $fila['PreCodigo6'];
			$this->PreCodigo7 = $fila['PreCodigo7'];
			$this->PreCodigo8 = $fila['PreCodigo8'];
			$this->PreCodigo9 = $fila['PreCodigo9'];
			$this->PreCodigo10 = $fila['PreCodigo10'];
			$this->PreEstado = $fila['PreEstado'];
			$this->PreTiempoCreacion = $fila['NPreTiempoCreacion'];
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

	public function MtdObtenerProductoReemplazos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL) {

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
			$estado = ' AND pre.PreEstado = '.$oEstado.' ';
		}
		
	
				$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pre.PreId,
				pre.PreCodigo1,
				pre.PreCodigo2,
				pre.PreCodigo3,
				pre.PreCodigo4,
				pre.PreCodigo5,
				pre.PreCodigo6,
				pre.PreCodigo7,
				pre.PreCodigo8,
				pre.PreCodigo9,
				pre.PreCodigo10,
	
				pre.PreEstado,
				DATE_FORMAT(pre.PreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPreTiempoCreacion"
      
				FROM tblpreproductoreemplazo pre	
				
				WHERE  1 = 1  '.$filtrar.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoReemplazo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ProductoReemplazo = new $InsProductoReemplazo();
					
					$ProductoReemplazo->PreId = $fila['PreId'];
					$ProductoReemplazo->PreCodigo1 = $fila['PreCodigo1'];
					$ProductoReemplazo->PreCodigo2 = $fila['PreCodigo2'];
					$ProductoReemplazo->PreCodigo3 = $fila['PreCodigo3'];
					$ProductoReemplazo->PreCodigo4 = $fila['PreCodigo4'];
					$ProductoReemplazo->PreCodigo5 = $fila['PreCodigo5'];
					$ProductoReemplazo->PreCodigo6 = $fila['PreCodigo6'];
					$ProductoReemplazo->PreCodigo7 = $fila['PreCodigo7'];
					$ProductoReemplazo->PreCodigo8 = $fila['PreCodigo8'];
					$ProductoReemplazo->PreCodigo9 = $fila['PreCodigo9'];
					$ProductoReemplazo->PreCodigo10 = $fila['PreCodigo10'];
					
					$ProductoReemplazo->PreEstado = $fila['PreEstado'];
					$ProductoReemplazo->PreTiempoCreacion = $fila['NPreTiempoCreacion'];


                    $ProductoReemplazo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ProductoReemplazo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarProductoReemplazo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PreId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PreId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblpreproductoreemplazo WHERE '.$eliminar;			
		
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
	
	public function MtdEliminarTodoProductoReemplazo() {
		
	
			$sql = 'DELETE FROM tblpreproductoreemplazo ';			
		
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
	
	
	public function MtdRegistrarProductoReemplazo() {
			
			//$this->MtdGenerarProductoReemplazoId();
			
			$sql = 'INSERT INTO tblpreproductoreemplazo (
			
			PreCodigo1,
			PreCodigo2,
			PreCodigo3,
			PreCodigo4,
			PreCodigo5,
			PreCodigo6,
			PreCodigo7,
			PreCodigo8,
			PreCodigo9,
			PreCodigo10,
			
			PreEstado,
			PreTiempoCreacion
			) 
			VALUES (
			
			"'.($this->PreCodigo1).'", 
			"'.($this->PreCodigo2).'", 
			"'.($this->PreCodigo3).'", 
			"'.($this->PreCodigo4).'", 
			"'.($this->PreCodigo5).'", 
			"'.($this->PreCodigo6).'", 
			"'.($this->PreCodigo7).'", 
			"'.($this->PreCodigo8).'", 
			"'.($this->PreCodigo9).'", 
			"'.($this->PreCodigo10).'", 
			
			'.($this->PreEstado).',
			"'.($this->PreTiempoCreacion).'");';

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

	public function MtdEditarProductoReemplazo() {
	
			$sql = 'UPDATE tblpreproductoreemplazo SET 
			PreId = "'.($this->PreId).'",	
			PreCodigo1 = "'.($this->PreCodigo1).'",
			PreCodigo2 = "'.($this->PreCodigo2).'",
			PreCodigo3 = "'.($this->PreCodigo3).'",
			PreCodigo4 = "'.($this->PreCodigo3).'",
			PreCodigo5 = "'.($this->PreCodigo5).'",
			PreCodigo6 = "'.($this->PreCodigo6).'",
			PreCodigo7 = "'.($this->PreCodigo7).'",
			PreCodigo8 = "'.($this->PreCodigo8).'",
			PreCodigo9 = "'.($this->PreCodigo9).'",
			PreCodigo10 = "'.($this->PreCodigo10).'",

			PreEstado = '.($this->PreEstado).'
			WHERE PreId = "'.($this->PreId).'";';

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