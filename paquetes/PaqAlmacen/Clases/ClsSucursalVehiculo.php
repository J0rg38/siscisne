<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSucursalVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */
class ClsSucursalVehiculo {

    public $SveId;
	public $SucId;
    public $VehId;
	public $SveStock;
	public $SveStockReal;
	public $SveEstado;
    public $SveTiempoCreacion;
    public $SveTiempoModificacion;
    public $SveEliminado;

	public $InsMysql;
	
	public $SucursalVehiculoCaracteristica;

	// Propiedades adicionales para evitar warnings
	public $SveAno;

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
	

	public function MtdGenerarSucursalVehiculoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(SveId,5),unsigned)) AS "MAXIMO"
			FROM tblsvesucursalvehiculo';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->SveId ="SVE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->SveId = "SVE-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerSucursalVehiculo($oCompleto=true){

       $sql = 'SELECT 
        sve.SveId,
		sve.SucId,
        sve.VehId,
		sve.SveStock,
		sve.SveStockReal,
		
		sve.SveEstado,
		DATE_FORMAT(sve.SveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSveTiempoCreacion",
        DATE_FORMAT(sve.SveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSveTiempoModificacion"

        FROM tblsvesucursalvehiculo sve
			
				
        WHERE sve.SveId = "'.$this->SveId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->SveId = $fila['SveId'];
			$this->SucId = $fila['SucId'];
			$this->VehId = $fila['VehId'];
			
			$this->SveStock = $fila['SveStock'];
			$this->SveStockReal = $fila['SveStockReal'];
			
			$this->SveEstado = $fila['SveEstado'];
			$this->SveTiempoCreacion = $fila['NSveTiempoCreacion'];
			$this->SveTiempoModificacion = $fila['NSveTiempoModificacion']; 
		
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
	public function MtdVerificarExisteSucursalVehiculo($oProducto,$oSucacen,$oAno,$oSucursal){
		
		$SucursalVehiculoId = "";
		
		$ResSucursalVehiculo = $this->MtdObtenerSucursalVehiculos(NULL,NULL,"SveId","ASC","1",NULL,$oSucacen,$oProducto,$oAno,$oSucursal);
		$ArrSucursalVehiculos = $ResSucursalVehiculo['Datos'];
		
		if(!empty($ArrSucursalVehiculos)){
			foreach($ArrSucursalVehiculos as $DatSucursalVehiculo){
				
				$SucursalVehiculoId = $DatSucursalVehiculo->SveId;
				
			}
		}
		
		return $SucursalVehiculoId;
		
	}
	
	public function MtdObtenerSucursalVehiculoStockActual($oProducto,$oSucacen=NULL,$oAno=NULL,$oSucursal){
		
		$Stock = 0;
		$ResSucursalVehiculo = $this->MtdObtenerSucursalVehiculos(NULL,NULL,"SveId","ASC",NULL,NULL,$oSucacen,$oProducto,$oAno,$oSucursal);
		$ArrSucursalVehiculos = $ResSucursalVehiculo['Datos'];
		
		if(!empty($ArrSucursalVehiculos)){
			foreach($ArrSucursalVehiculos as $DatSucursalVehiculo){
				$Stock += (empty($DatSucursalVehiculo->SveStockReal)?0:$DatSucursalVehiculo->SveStockReal);
			}
		}
		
		return $Stock;
		
	}
	
    public function MtdObtenerSucursalVehiculos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'SveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oSucacen=NULL,$oProducto=NULL,$oAno=NULL,$oSucursal) {

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

		
		if(!empty($oSucacen)){
			$almacen = ' AND sve.SucId = "'.$oSucacen.'"';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND sve.VehId = "'.$oProducto.'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND sve.SveAno = "'.$oAno.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND suc.SucId = "'.$oSucursal.'"';
		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				sve.SveId,
				sve.SucId,
				sve.VehId,
				sve.SveStockReal,
				sve.SveStock,
				sve.SveAno,
				
				sve.SveEstado,
				DATE_FORMAT(sve.SveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSveTiempoCreacion",
                DATE_FORMAT(sve.SveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSveTiempoModificacion",
				
				veh.VehNombre,
				veh.VehCodigoOriginal,
				ume.UmeNombre,
				ume.UmeAbreviacion
							
				FROM tblsvesucursalvehiculo sve
					LEFT JOIN tblsucsucursal suc
					ON sve.SucId = suc.SucId

					LEFT JOIN tblvehvehiculo veh
					ON sve.VehId = veh.VehId
						LEFT JOIN tblumeunidadmedida ume
						ON veh.UmeId = ume.UmeId
						
				WHERE  1 = 1 '.$filtrar.$vmarca.$sucursal.$producto.$almacen.$ano.$estado.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSucursalVehiculo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$SucursalVehiculo = new $InsSucursalVehiculo();
                    $SucursalVehiculo->SveId = $fila['SveId'];
					$SucursalVehiculo->SucId = $fila['SucId'];
                    $SucursalVehiculo->VehId = $fila['VehId'];
					$SucursalVehiculo->SveStockReal = $fila['SveStockReal'];
					$SucursalVehiculo->SveStock = $fila['SveStock'];
					$SucursalVehiculo->SveAno = $fila['SveAno'];
				
					$SucursalVehiculo->SveEstado = $fila['SveEstado'];
                    $SucursalVehiculo->SveTiempoCreacion = $fila['NSveTiempoCreacion'];
                    $SucursalVehiculo->SveTiempoModificacion = $fila['NSveTiempoModificacion'];
					
					$SucursalVehiculo->VehNombre = $fila['VehNombre'];
					$SucursalVehiculo->VehCodigoOriginal = $fila['VehCodigoOriginal'];
					$SucursalVehiculo->UmeNombre = $fila['UmeNombre'];
					$SucursalVehiculo->UmeAbreviacion = $fila['UmeAbreviacion'];

					$SucursalVehiculo->InsMysql = NULL;
					$Respuesta['Datos'][]= $SucursalVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarSucursalVehiculo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' SveId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (SveId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SveId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblsvesucursalvehiculo WHERE '.$eliminar;
			
		
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
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
	
	
	public function MtdRegistrarSucursalVehiculo() {
	
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
	
		$this->MtdGenerarSucursalVehiculoId();
			
			$sql = 'INSERT INTO tblsvesucursalvehiculo (
				SveId,
				SucId,
				VehId, 
				SveAno,
				
				SveStockReal,
				SveStock,
				
				SveEstado,
				SveTiempoCreacion,
				SveTiempoModificacion) 
				VALUES (
				"'.($this->SveId).'", 
				"'.($this->SucId).'", 
				"'.($this->VehId).'", 
				"'.($this->SveAno).'", 
				
				"'.($this->SveStockReal).'", 
				'.($this->SveStock).', 
				
				'.($this->SveEstado).', 
				"'.($this->SveTiempoCreacion).'", 
				"'.($this->SveTiempoModificacion).'");';	
				
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
	
	public function MtdEditarSucursalVehiculo() {

//VehId = "'.($this->VehId).'",
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
				$sql = 'UPDATE tblsvesucursalvehiculo SET 
				
				SveStockReal = "'.($this->SveStockReal).'",
				SveStock = '.($this->SveStock).',
				
				SveEstado = '.($this->SveEstado).',
				SveTiempoModificacion = "'.($this->SveTiempoModificacion).'"
				WHERE SveId = "'.($this->SveId).'";';

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
		
	public function MtdEditarSucursalVehiculoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblsvesucursalvehiculo SET 
			'.$oCampo.' = "'.($oDato).'",
			SveTiempoModificacion = NOW()
			WHERE SveId = "'.($oId).'";';
			
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
	
	
		public function MtdEditarSucursalVehiculoReal($oSucacen,$oProducto,$oStock,$oAno) {
	
		global $Resultado;

		$sql = 'UPDATE tblsvesucursalvehiculo SET 
		SveStockReal = '.$oStock.'
		
		WHERE SucId = "'.($oSucacen).'"
		AND  VehId = "'.($oProducto).'"
		AND SveAno = "'.$oAno.'"';
		
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
	
	
	public function MtdEditarSucursalVehiculoRealIngresado($oSucacen,$oProducto,$oStock,$oAno) {
	
		global $Resultado;

		$sql = 'UPDATE tblsvesucursalvehiculo SET 
		SveStockRealIngresado = '.$oStock.'
		
		WHERE SucId = "'.($oSucacen).'"
		AND VehId = "'.($oSucacen).'"
		AND SveAno = "'.$oAno.'"';
		
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