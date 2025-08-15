<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoCodigoReemplazo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoCodigoReemplazo {

    public $PcrId;
	public $ProId;
    public $PcrNumero;
    public $PcrTiempoCreacion;
    public $PcrTiempoModificacion;
    public $PcrEliminado;

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
	

	public function MtdGenerarProductoCodigoReemplazoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PcrId,5),unsigned)) AS "MAXIMO"
			FROM tblpcrproductocodigoreemplazo';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PcrId ="PCR-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PcrId = "PCR-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerProductoCodigoReemplazo(){

        $sql = 'SELECT 
        pcr.PcrId,
		pcr.ProId,
        pcr.PcrNumero,
		DATE_FORMAT(pcr.PcrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcrTiempoCreacion",
        DATE_FORMAT(pcr.PcrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcrTiempoModificacion"
        FROM tblpcrproductocodigoreemplazo pcr
        WHERE pcr.PcrId = "'.$this->PcrId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PcrId = $fila['PcrId'];
			$this->ProId = $fila['ProId'];
			$this->PcrNumero = $fila['PcrNumero'];
			$this->PcrTiempoCreacion = $fila['NPcrTiempoCreacion'];
			$this->PcrTiempoModificacion = $fila['NPcrTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerProductoCodigoReemplazos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PcrId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$producto = '';

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		if(!empty($oProducto)){
			$producto = ' AND pcr.ProId = "'.($oProducto).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pcr.PcrId,
				pcr.ProId,
				pcr.PcrNumero,
				DATE_FORMAT(pcr.PcrTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPcrTiempoCreacion",
                DATE_FORMAT(pcr.PcrTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPcrTiempoModificacion"
				FROM tblpcrproductocodigoreemplazo pcr

				WHERE  1 = 1 '.$filtrar.$producto.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoCodigoReemplazo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ProductoCodigoReemplazo = new $InsProductoCodigoReemplazo();
                    $ProductoCodigoReemplazo->PcrId = $fila['PcrId'];
					$ProductoCodigoReemplazo->ProId = $fila['ProId'];
                    $ProductoCodigoReemplazo->PcrNumero = $fila['PcrNumero'];
                    $ProductoCodigoReemplazo->PcrTiempoCreacion = $fila['NPcrTiempoCreacion'];
                    $ProductoCodigoReemplazo->PcrTiempoModificacion = $fila['NPcrTiempoModificacion'];

					$ProductoCodigoReemplazo->InsMysql = NULL;      
					$Respuesta['Datos'][]= $ProductoCodigoReemplazo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarProductoCodigoReemplazo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		if(!count($elementos)){
			$eliminar .= ' PcrId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PcrId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PcrId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblpcrproductocodigoreemplazo WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarProductoCodigoReemplazo() {
	
		$this->MtdGenerarProductoCodigoReemplazoId();
			
			$sql = 'INSERT INTO tblpcrproductocodigoreemplazo (
				PcrId,
				ProId,
				PcrNumero, 
				PcrTiempoCreacion,
				PcrTiempoModificacion) 
				VALUES (
				"'.($this->PcrId).'", 
				"'.($this->ProId).'", 
				"'.($this->PcrNumero).'", 
				"'.($this->PcrTiempoCreacion).'", 
				"'.($this->PcrTiempoModificacion).'");';	
				
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
	
	public function MtdEditarProductoCodigoReemplazo() {
		
			$sql = 'UPDATE tblpcrproductocodigoreemplazo SET 
				PcrNumero = "'.($this->PcrNumero).'",
				PcrTiempoModificacion = "'.($this->PcrTiempoModificacion).'"
				WHERE PcrId = "'.($this->PcrId).'";';
				 
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