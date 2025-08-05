<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAlmacenProducto
 *
 * @author Ing. Jonathan Blanco Alave
 */
class ClsAlmacenProducto {

    public $AprId;
	public $AlmId;
    public $ProId;
	public $AprStock;
	public $AprStockReal;
	public $AprEstado;
    public $AprTiempoCreacion;
    public $AprTiempoModificacion;
    public $AprEliminado;

	public $InsMysql;
	
	public $AlmacenProductoCaracteristica;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarAlmacenProductoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AprId,5),unsigned)) AS "MAXIMO"
			FROM tblapralmacenproducto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->AprId ="APR-10000";
			}else{
				$fila['MAXIMO']++;
				$this->AprId = "APR-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerAlmacenProducto($oCompleto=true){

       $sql = 'SELECT 
        apr.AprId,
		apr.AlmId,
        apr.ProId,
		apr.AprStock,
		apr.AprStockReal,
		
		apr.AprEstado,
		DATE_FORMAT(apr.AprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAprTiempoCreacion",
        DATE_FORMAT(apr.AprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAprTiempoModificacion"

        FROM tblapralmacenproducto apr
			
				
        WHERE apr.AprId = "'.$this->AprId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->AprId = $fila['AprId'];
			$this->AlmId = $fila['AlmId'];
			$this->ProId = $fila['ProId'];
			
			$this->AprStock = $fila['AprStock'];
			$this->AprStockReal = $fila['AprStockReal'];
			
			$this->AprEstado = $fila['AprEstado'];
			$this->AprTiempoCreacion = $fila['NAprTiempoCreacion'];
			$this->AprTiempoModificacion = $fila['NAprTiempoModificacion']; 
		
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	
	public function MtdVerificarExisteAlmacenProducto($oProducto,$oAlmacen,$oAno,$oSucursal){
		
		$AlmacenProductoId = "";
		
		$ResAlmacenProducto = $this->MtdObtenerAlmacenProductos(NULL,NULL,"AprId","ASC","1",NULL,$oAlmacen,$oProducto,$oAno,$oSucursal);
		$ArrAlmacenProductos = $ResAlmacenProducto['Datos'];
		
		if(!empty($ArrAlmacenProductos)){
			foreach($ArrAlmacenProductos as $DatAlmacenProducto){
				
				$AlmacenProductoId = $DatAlmacenProducto->AprId;
				
			}
		}
		
		return $AlmacenProductoId;
		
	}
	
	public function MtdObtenerAlmacenProductoStockActual($oProducto,$oAlmacen=NULL,$oAno=NULL,$oSucursal){
		
		$Stock = 0;
		$ResAlmacenProducto = $this->MtdObtenerAlmacenProductos(NULL,NULL,"AprId","ASC",NULL,NULL,$oAlmacen,$oProducto,$oAno,$oSucursal);
		$ArrAlmacenProductos = $ResAlmacenProducto['Datos'];
		
		if(!empty($ArrAlmacenProductos)){
			foreach($ArrAlmacenProductos as $DatAlmacenProducto){
				$Stock += (empty($DatAlmacenProducto->AprStockReal)?0:$DatAlmacenProducto->AprStockReal);
			}
		}
		
		return $Stock;
		
	}
	
    public function MtdObtenerAlmacenProductos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'AprId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oAlmacen=NULL,$oProducto=NULL,$oAno=NULL,$oSucursal) {

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

		
		if(!empty($oAlmacen)){
			$almacen = ' AND apr.AlmId = "'.$oAlmacen.'"';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND apr.ProId = "'.$oProducto.'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND apr.AprAno = "'.$oAno.'"';
		}
		
		if(!empty($oSucursal)){
			$sucursal = ' AND alm.SucId = "'.$oSucursal.'"';
		}
		
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				apr.AprId,
				apr.AlmId,
				apr.ProId,
				apr.AprStockReal,
				apr.AprStock,
				apr.AprAno,
				
				apr.AprEstado,
				DATE_FORMAT(apr.AprTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAprTiempoCreacion",
                DATE_FORMAT(apr.AprTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAprTiempoModificacion",
				
				pro.ProNombre,
				pro.ProCodigoOriginal,
				ume.UmeNombre,
				ume.UmeAbreviacion
							
				FROM tblapralmacenproducto apr
					LEFT JOIN tblalmalmacen alm
					ON apr.AlmId = alm.AlmId

					LEFT JOIN tblproproducto pro
					ON apr.ProId = pro.ProId
						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId
						
				WHERE  1 = 1 '.$filtrar.$vmarca.$sucursal.$producto.$almacen.$ano.$estado.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAlmacenProducto = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$AlmacenProducto = new $InsAlmacenProducto();
                    $AlmacenProducto->AprId = $fila['AprId'];
					$AlmacenProducto->AlmId = $fila['AlmId'];
                    $AlmacenProducto->ProId = $fila['ProId'];
					$AlmacenProducto->AprStockReal = $fila['AprStockReal'];
					$AlmacenProducto->AprStock = $fila['AprStock'];
					$AlmacenProducto->AprAno = $fila['AprAno'];
				
					$AlmacenProducto->AprEstado = $fila['AprEstado'];
                    $AlmacenProducto->AprTiempoCreacion = $fila['NAprTiempoCreacion'];
                    $AlmacenProducto->AprTiempoModificacion = $fila['NAprTiempoModificacion'];
					
					$AlmacenProducto->ProNombre = $fila['ProNombre'];
					$AlmacenProducto->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$AlmacenProducto->UmeNombre = $fila['UmeNombre'];
					$AlmacenProducto->UmeAbreviacion = $fila['UmeAbreviacion'];

					$AlmacenProducto->InsMysql = NULL;
					$Respuesta['Datos'][]= $AlmacenProducto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarAlmacenProducto($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' AprId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (AprId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AprId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblapralmacenproducto WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarAlmacenProducto() {
	
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
	
		$this->MtdGenerarAlmacenProductoId();
			
			$sql = 'INSERT INTO tblapralmacenproducto (
				AprId,
				AlmId,
				ProId, 
				AprAno,
				
				AprStockReal,
				AprStock,
				
				AprEstado,
				AprTiempoCreacion,
				AprTiempoModificacion) 
				VALUES (
				"'.($this->AprId).'", 
				"'.($this->AlmId).'", 
				"'.($this->ProId).'", 
				"'.($this->AprAno).'", 
				
				"'.($this->AprStockReal).'", 
				'.($this->AprStock).', 
				
				'.($this->AprEstado).', 
				"'.($this->AprTiempoCreacion).'", 
				"'.($this->AprTiempoModificacion).'");';	
				
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
	
	public function MtdEditarAlmacenProducto() {

//ProId = "'.($this->ProId).'",
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
				$sql = 'UPDATE tblapralmacenproducto SET 
				
				AprStockReal = "'.($this->AprStockReal).'",
				AprStock = '.($this->AprStock).',
				
				AprEstado = '.($this->AprEstado).',
				AprTiempoModificacion = "'.($this->AprTiempoModificacion).'"
				WHERE AprId = "'.($this->AprId).'";';

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
		
	public function MtdEditarAlmacenProductoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblapralmacenproducto SET 
			'.$oCampo.' = "'.($oDato).'",
			AprTiempoModificacion = NOW()
			WHERE AprId = "'.($oId).'";';
			
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
	
	
		public function MtdEditarAlmacenProductoReal($oAlmacen,$oProducto,$oStock,$oAno) {
	
		global $Resultado;

		$sql = 'UPDATE tblapralmacenproducto SET 
		AprStockReal = '.$oStock.'
		
		WHERE AlmId = "'.($oAlmacen).'"
		AND  ProId = "'.($oProducto).'"
		AND AprAno = "'.$oAno.'"';
		
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
	
	
	public function MtdEditarAlmacenProductoRealIngresado($oAlmacen,$oProducto,$oStock,$oAno) {
	
		global $Resultado;

		$sql = 'UPDATE tblapralmacenproducto SET 
		AprStockRealIngresado = '.$oStock.'
		
		WHERE AlmId = "'.($oAlmacen).'"
		AND ProId = "'.($oAlmacen).'"
		AND AprAno = "'.$oAno.'"';
		
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