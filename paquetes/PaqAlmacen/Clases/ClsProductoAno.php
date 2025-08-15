<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoAno
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoAno {

    public $PanId;
	public $ProId;
    public $PanAno;
    public $PanTiempoCreacion;
    public $PanTiempoModificacion;
    public $PanEliminado;

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
	

	public function MtdGenerarProductoAnoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PanId,5),unsigned)) AS "MAXIMO"
			FROM tblpanproductoano';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PanId ="PAN-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PanId = "PAN-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerProductoAno(){

        $sql = 'SELECT 
        pan.PanId,
		pan.ProId,
        pan.PanAno,
		DATE_FORMAT(pan.PanTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPanTiempoCreacion",
        DATE_FORMAT(pan.PanTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPanTiempoModificacion"
        FROM tblpanproductoano pan
        WHERE pan.PanId = "'.$this->PanId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PanId = $fila['PanId'];
			$this->ProId = $fila['ProId'];
			$this->PanAno = $fila['PanAno'];
			$this->PanTiempoCreacion = $fila['NPanTiempoCreacion'];
			$this->PanTiempoModificacion = $fila['NPanTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerProductoAnos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PanId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL) {

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
			$producto = ' AND pan.ProId = "'.($oProducto).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pan.PanId,
				pan.ProId,
				pan.PanAno,
				DATE_FORMAT(pan.PanTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPanTiempoCreacion",
                DATE_FORMAT(pan.PanTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPanTiempoModificacion"
				FROM tblpanproductoano pan

				WHERE  1 = 1 '.$filtrar.$producto.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoAno = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ProductoAno = new $InsProductoAno();
                    $ProductoAno->PanId = $fila['PanId'];
					$ProductoAno->ProId = $fila['ProId'];
                    $ProductoAno->PanAno = $fila['PanAno'];
                    $ProductoAno->PanTiempoCreacion = $fila['NPanTiempoCreacion'];
                    $ProductoAno->PanTiempoModificacion = $fila['NPanTiempoModificacion'];

					$ProductoAno->InsMysql = NULL;      
					$Respuesta['Datos'][]= $ProductoAno;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarProductoAno($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' PanId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PanId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PanId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblpanproductoano WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarProductoAno() {
	
		$this->MtdGenerarProductoAnoId();
			
			$sql = 'INSERT INTO tblpanproductoano (
				PanId,
				ProId,
				PanAno, 
				PanTiempoCreacion,
				PanTiempoModificacion) 
				VALUES (
				"'.($this->PanId).'", 
				"'.($this->ProId).'", 
				"'.($this->PanAno).'", 
				"'.($this->PanTiempoCreacion).'", 
				"'.($this->PanTiempoModificacion).'");';	
				
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
	
//	public function MtdEditarProductoAno() {
//		
//			$sql = 'UPDATE tblpanproductoano SET 
//				VveId = "'.($this->VveId).'",
//				PanTiempoModificacion = "'.($this->PanTiempoModificacion).'"
//				WHERE PanId = "'.($this->PanId).'";';
//				 
//			$error = false;
//
//			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
//			
//			if(!$resultado) {						
//				$error = true;
//			} 		
//			
//			if($error) {						
//				return false;
//			} else {				
//				return true;
//			}						
//				
//		}	
//		
	
	
	
	
}
?>