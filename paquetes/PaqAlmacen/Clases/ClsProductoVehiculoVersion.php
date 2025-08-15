<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProductoVehiculoVersion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProductoVehiculoVersion {

    public $PvvId;
	public $ProId;
	public $VveId;
    public $PvvTiempoCreacion;
    public $PvvTiempoModificacion;
    public $PvvEliminado;

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
	

	public function MtdGenerarProductoVehiculoVersionId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PvvId,5),unsigned)) AS "MAXIMO"
			FROM tblpvvproductovehiculoversion';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PvvId ="PVV-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PvvId = "PVV-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerProductoVehiculoVersion(){

        $sql = 'SELECT 
        pvv.PvvId,
		pvv.ProId,
		pvv.VveId,
		DATE_FORMAT(pvv.PvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPvvTiempoCreacion",
        DATE_FORMAT(pvv.PvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPvvTiempoModificacion"
        FROM tblpvvproductovehiculoversion pvv
        WHERE pvv.PvvId = "'.$this->PvvId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->PvvId = $fila['PvvId'];
			$this->ProId = $fila['ProId'];
			$this->VveId = $fila['VveId'];
			$this->PvvTiempoCreacion = $fila['NPvvTiempoCreacion'];
			$this->PvvTiempoModificacion = $fila['NPvvTiempoModificacion']; 
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerProductoVehiculoVersiones($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PvvId',$oSentido = 'Desc',$oPaginacion = '0,10',$oProducto=NULL,$oVehiculoVersion=NULL) {

		// Inicializar variables para evitar warnings
		$filtrar = '';
		$orden = '';
		$paginacion = '';
		$producto = '';
		$vversion = '';

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
			$producto = ' AND pvv.ProId = "'.($oProducto).'"';
		}
		
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND pvv.VveId = "'.($oVehiculoVersion).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pvv.PvvId,
				pvv.ProId,
				pvv.VveId,
				DATE_FORMAT(pvv.PvvTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPvvTiempoCreacion",
                DATE_FORMAT(pvv.PvvTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPvvTiempoModificacion",
				vmo.VmaId,
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre

				FROM tblpvvproductovehiculoversion pvv
					LEFT JOIN tblvvevehiculoversion vve
					ON pvv.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId

				WHERE  1 = 1 '.$filtrar.$producto.$vversion.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProductoVehiculoVersion = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ProductoVehiculoVersion = new $InsProductoVehiculoVersion();
                    $ProductoVehiculoVersion->PvvId = $fila['PvvId'];
					$ProductoVehiculoVersion->ProId = $fila['ProId'];
					$ProductoVehiculoVersion->VveId = $fila['VveId'];
                    $ProductoVehiculoVersion->PvvTiempoCreacion = $fila['NPvvTiempoCreacion'];
                    $ProductoVehiculoVersion->PvvTiempoModificacion = $fila['NPvvTiempoModificacion'];
					
					$ProductoVehiculoVersion->VmaId = $fila['VmaId'];
					$ProductoVehiculoVersion->VmaNombre = $fila['VmaNombre'];
					$ProductoVehiculoVersion->VmoNombre = $fila['VmoNombre'];
					$ProductoVehiculoVersion->VveNombre = $fila['VveNombre'];

				
					$ProductoVehiculoVersion->InsMysql = NULL;      
					$Respuesta['Datos'][]= $ProductoVehiculoVersion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarProductoVehiculoVersion($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		// Inicializar variable para evitar warnings
		$eliminar = '';
		
		if(!count($elementos)){
			$eliminar .= ' PvvId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PvvId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PvvId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblpvvproductovehiculoversion WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarProductoVehiculoVersion() {
	
		$this->MtdGenerarProductoVehiculoVersionId();
			
			$sql = 'INSERT INTO tblpvvproductovehiculoversion (
				PvvId,
				ProId,
				VveId,
				PvvTiempoCreacion,
				PvvTiempoModificacion) 
				VALUES (
				"'.($this->PvvId).'", 
				"'.($this->ProId).'", 
				"'.($this->VveId).'", 
				"'.($this->PvvTiempoCreacion).'", 
				"'.($this->PvvTiempoModificacion).'");';	
				
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
	
//	public function MtdEditarProductoVehiculoVersion() {
//		
//			$sql = 'UPDATE tblpvvproductovehiculoversion SET 
//				VveId = "'.($this->VveId).'",
//				PvvTiempoModificacion = "'.($this->PvvTiempoModificacion).'"
//				WHERE PvvId = "'.($this->PvvId).'";';
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