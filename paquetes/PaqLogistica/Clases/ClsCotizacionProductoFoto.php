<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionProductoFoto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionProductoFoto {

    public $CpfId;
	public $CprId;
	public $CpfArchivo;
	public $CpfTipo;
	public $CpfEstado;	
	public $CpfTiempoCreacion;
	public $CpfTiempoModificacion;
    public $CpfEliminado;
	
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

	private function MtdGenerarCotizacionProductoFotoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CpfId,5),unsigned)) AS "MAXIMO"
			FROM tblcpfcotizacionproductofoto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CpfId = "CPF-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CpfId = "CPF-".$fila['MAXIMO'];					
			}
				
	}

	public function MtdObtenerCotizacionProductoFoto(){

        $sql = 'SELECT 
			cpf.CpfId,			
			cpf.CprId,
			cpf.CpfArchivo,
			cpf.CpfTipo,
		
			cpf.CpfEstado,
			DATE_FORMAT(cpf.CpfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCpfTiempoCreacion",
	        DATE_FORMAT(cpf.CpfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCpfTiempoModificacion"
			FROM tblcpfcotizacionproductofoto cpf
        WHERE cpf.CpfId = "'.$this->CpfId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			  $this->CpfId = $fila['CpfId'];
			  $this->CprId = $fila['CprId'];
			  $this->CpfArchivo = $fila['CpfArchivo']; 
			   $this->CpfTipo = $fila['CpfTipo'];  
 
			  $this->CpfEstado = $fila['CpfEstado'];  
			  $this->CpfTiempoCreacion = $fila['NCpfTiempoCreacion'];  
			  $this->CpfTiempoModificacion = $fila['NCpfTiempoModificacion']; 	
					
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
    public function MtdObtenerCotizacionProductoFotos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CpfId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacionProducto=NULL,$oEstado=NULL,$oTipo=NULL) {

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
		
		if(!empty($oCotizacionProducto)){
			$cproducto = ' AND cpf.CprId = "'.$oCotizacionProducto.'"';
		}

		if(!empty($oEstado)){
			$estado = ' AND cpf.CpfEstado = '.$oEstado.' ';
		}

		if(!empty($oTipo)){
			$tipo = ' AND cpf.CpfTipo = "'.$oTipo.'" ';
		}

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			cpf.CpfId,			
			cpf.CprId,
			cpf.CpfArchivo,
			cpf.CpfTipo,
			cpf.CpfEstado,
			DATE_FORMAT(cpf.CpfTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCpfTiempoCreacion",
	        DATE_FORMAT(cpf.CpfTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCpfTiempoModificacion"
			FROM tblcpfcotizacionproductofoto cpf
			WHERE  1 = 1 '.$cproducto.$estado.$producto.$filtrar.$tipo.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionProductoFoto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionProductoFoto = new $InsCotizacionProductoFoto();
                    $CotizacionProductoFoto->CpfId = $fila['CpfId'];
                    $CotizacionProductoFoto->CprId = $fila['CprId'];
					$CotizacionProductoFoto->CpfArchivo = $fila['CpfArchivo'];  
					
					$CotizacionProductoFoto->CpfTipo = $fila['CpfTipo'];  
					$CotizacionProductoFoto->CpfEstado = $fila['CpfEstado'];  
					$CotizacionProductoFoto->CpfTiempoCreacion = $fila['NCpfTiempoCreacion'];  
					$CotizacionProductoFoto->CpfTiempoModificacion = $fila['NCpfTiempoModificacion']; 					
					
                    $CotizacionProductoFoto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionProductoFoto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionProductoFoto($oElementos) {
		

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (CpfId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CpfId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblcpfcotizacionproductofoto 
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
	
	
	public function MtdRegistrarCotizacionProductoFoto() {
	
			$this->MtdGenerarCotizacionProductoFotoId();
			
			$sql = 'INSERT INTO tblcpfcotizacionproductofoto (
			CpfId,
			CprId,
			CpfArchivo,
		
			CpfTipo,
			CpfEstado,
			CpfTiempoCreacion,
			CpfTiempoModificacion) 
			VALUES (
			"'.($this->CpfId).'", 
			"'.($this->CprId).'", 
			"'.($this->CpfArchivo).'", 
			
			"'.($this->CpfTipo).'",
			'.($this->CpfEstado).',
			"'.($this->CpfTiempoCreacion).'",
			"'.($this->CpfTiempoModificacion).'");';
		
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
	
	public function MtdEditarCotizacionProductoFoto() {

		$sql = 'UPDATE tblcpfcotizacionproductofoto SET 	
		CpfArchivo = "'.($this->CpfArchivo).'",
		CpfEstado = '.($this->CpfEstado).'
		WHERE CpfId = "'.($this->CpfId).'";';

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