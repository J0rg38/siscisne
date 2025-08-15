<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProduccionProductoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProduccionProductoDetalle {

    public $PpdId;
	public $PprId;
	public $ProId;
	public $UmeId;
	public $PpdCantidad;
	public $PpdEstado;
	public $PpdTiempoCreacion;
	public $PpdTiempoModificacion;
    public $PpdEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	
	public $UmeNombre;
	public $UmeIdOrigen;
	
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

	private function MtdGenerarProduccionProductoDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(PpdId,5),unsigned)) AS "MAXIMO"
			FROM tblppdproduccionproductodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->PpdId = "PPD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->PpdId = "PPD-".$fila['MAXIMO'];					
			}
				
	}
	
	
	  public function MtdObtenerProduccionProductoDetalle(){

        $sql = 'SELECT
			SQL_CALC_FOUND_ROWS 
			ppd.PpdId,	
			ppd.PprId,
			
			ppd.ProId,
			ppd.UmeId,
			ppd.PpdCantidad,
			ppd.PpdCantidadReal,
			
			ppd.PpdCosto,
			ppd.PpdImporte,
			ppd.PpdTipo,
			
			ppd.PpdEstado,
			DATE_FORMAT(ppd.PpdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPpdTiempoCreacion",
	        DATE_FORMAT(ppd.PpdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPpdTiempoModificacion",
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			
			ume.UmeNombre
	
			FROM tblppdproduccionproductodetalle ppd
				
				LEFT JOIN tblpprproduccionproducto ppr
				ON ppd.PprId = ppr.PprId
				
					LEFT JOIN tblproproducto pro
					ON ppd.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON ppd.UmeId = ume.UmeId
			
        WHERE ppd.PpdId = "'.$this->PpdId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsProduccionProductoDetalle = new ClsProduccionProductoDetalle();
			
				
			$this->PpdId = $fila['PpdId'];			
			$this->PprId = $fila['PprId'];
			
			$this->PpdEstado = $fila['PpdEstado'];
			$this->PpdTiempoCreacion = $fila['NPpdTiempoCreacion'];
			$this->PpdTiempoModificacion = $fila['NPpdTiempoModificacion'];
				
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerProduccionProductoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'PpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoAlmacen=NULL,$oEstado=NULL,$oProducto=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTipo=NULL) {

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
		
		if(!empty($oTrasladoAlmacen)){
			$amovimiento = ' AND ppd.PprId = "'.$oTrasladoAlmacen.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ppd.PpdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (ppd.ProId = "'.$oProducto.'") ';
		}
		
		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ppr.PprFecha)>="'.$oFechaInicio.'" AND DATE(ppr.PprFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ppr.PprFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ppr.PprFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		
		if(!empty($oTipo)){
			$tipo = ' AND (ppd.PpdTipo = "'.$oTipo.'") ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ppd.PpdId,	
			ppd.PprId,
			
			ppd.ProId,
			ppd.UmeId,
			ppd.PpdCantidad,
			ppd.PpdCantidadReal,
			
			ppd.PpdCosto,
			ppd.PpdImporte,
			ppd.PpdTipo,
			
			ppd.PpdEstado,
			DATE_FORMAT(ppd.PpdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPpdTiempoCreacion",
	        DATE_FORMAT(ppd.PpdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPpdTiempoModificacion",
			
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			
			ume.UmeNombre
	
			FROM tblppdproduccionproductodetalle ppd
				
				LEFT JOIN tblpprproduccionproducto ppr
				ON ppd.PprId = ppr.PprId
				
					LEFT JOIN tblproproducto pro
					ON ppd.ProId = pro.ProId
					
						LEFT JOIN tblumeunidadmedida ume
						ON ppd.UmeId = ume.UmeId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$tipo.$fecha.$ocompra.$cocompra.$cliente.$vddetalle.$pcestado.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProduccionProductoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ProduccionProductoDetalle = new $InsProduccionProductoDetalle();
                    $ProduccionProductoDetalle->PpdId = $fila['PpdId'];
                    $ProduccionProductoDetalle->PprId = $fila['PprId'];
					
					$ProduccionProductoDetalle->ProId = $fila['ProId'];
					$ProduccionProductoDetalle->UmeId = $fila['UmeId'];
					$ProduccionProductoDetalle->PpdCantidad = $fila['PpdCantidad'];
					$ProduccionProductoDetalle->PpdCantidadReal = $fila['PpdCantidadReal'];
					$ProduccionProductoDetalle->PpdCosto = $fila['PpdCosto'];
					$ProduccionProductoDetalle->PpdImporte = $fila['PpdImporte'];
					$ProduccionProductoDetalle->PpdTipo = $fila['PpdTipo'];
	
					$ProduccionProductoDetalle->PpdEstado = $fila['PpdEstado'];
					$ProduccionProductoDetalle->PpdTiempoCreacion = $fila['NPpdTiempoCreacion'];  
					$ProduccionProductoDetalle->PpdTiempoModificacion = $fila['NPpdTiempoModificacion']; 	
					
					
					$ProduccionProductoDetalle->ProNombre = $fila['ProNombre'];
					$ProduccionProductoDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
					$ProduccionProductoDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
					
					$ProduccionProductoDetalle->RtiId = $fila['RtiId'];
					$ProduccionProductoDetalle->UmeIdOrigen = $fila['UmeIdOrigen'];
					
					$ProduccionProductoDetalle->UmeNombre = $fila['UmeNombre'];
					
				
					$ProduccionProductoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ProduccionProductoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarProduccionProductoDetalle($oElementos) {
		
//		$InsProduccionProductoDetalleOrigen = new ClsProduccionProductoDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (PpdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PpdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblppdproduccionproductodetalle 
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
	
	
	public function MtdRegistrarProduccionProductoDetalle() {
		
		$this->MtdGenerarProduccionProductoDetalleId();

		$sql = 'INSERT INTO tblppdproduccionproductodetalle (
		PpdId,
		PprId,	
		ProId,			
		UmeId,			
		
		PpdCosto,
		PpdImporte,
		
		PpdCantidad,		
		PpdCantidadReal,	
		PpdTipo,
			
		PpdEstado,
		PpdTiempoCreacion,
		PpdTiempoModificacion) 
		VALUES (
		"'.($this->PpdId).'", 
		"'.($this->PprId).'", 
		"'.($this->ProId).'", 			
		"'.($this->UmeId).'", 	
		
		'.($this->PpdCosto).',	
		'.($this->PpdImporte).',	
						
		'.($this->PpdCantidad).',	
		'.($this->PpdCantidadReal).',	
		'.($this->PpdTipo).',
		
		'.($this->PpdEstado).',
		"'.($this->PpdTiempoCreacion).'",
		"'.($this->PpdTiempoModificacion).'");';
		
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
	
	public function MtdEditarProduccionProductoDetalle() {

			$sql = 'UPDATE tblppdproduccionproductodetalle SET 
			ProId = "'.($this->ProId).'",
			UmeId = "'.($this->UmeId).'",
			
			PpdCosto = '.($this->PpdCosto).',
			PpdImporte = '.($this->PpdImporte).',
			
			PpdCantidad = '.($this->PpdCantidad).',
			PpdCantidadReal = '.($this->PpdCantidadReal).',
			
			PpdEstado = '.($this->PpdEstado).',
			PpdTiempoModificacion = "'.($this->PpdTiempoModificacion).'"
			WHERE PpdId = "'.($this->PpdId).'";';

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
		
		
		public function MtdEditarProduccionProductoDetalleDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblppdproduccionproductodetalle SET 
	
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			
			PpdTiempoModificacion = NOW()
			WHERE PpdId = "'.($oId).'";';
			
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