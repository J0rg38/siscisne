<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCotizacionProductoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsCotizacionProductoDetalle {

    public $CrdId;
	public $CprId;
	public $ProId;
	public $UmeId;
	
	public $CrdCodigo;
	public $CrdDescripcion;
	
    public $CrdCantidad;
	public $CrdCantidadReal;	
	public $CrdCosto;
	
	public $CrdMargenPorcentaje;
	public $CrdMantenimientoPorcentaje;
	public $CrdFletePorcentaje;
	public $CrdDescuentoPorcentaje;
	
	public $CrdPrecioBruto;
	public $CrdDescuento;
	public $CrdPrecio;

	public $CrdValorVenta;
	
	public $CrdImporte;	
	public $CrdEstado;	
	public $CrdTiempoCreacion;
	public $CrdTiempoModificacion;
    public $CrdEliminado;
	
	public $ProNombre;
	public $ProCodigoOriginal;
	public $ProCodigoAlternativo;
	public $RtiId;
	public $UmeIdOrigen;

	public $ProStock;
	public $ProStockReal;

	public $UmeNombre;
					
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarCotizacionProductoDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CrdId,5),unsigned)) AS "MAXIMO"
			FROM tblcrdcotizacionproductodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CrdId = "CRD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CrdId = "CRD-".$fila['MAXIMO'];					
			}
				
	}
	


		public function MtdObtenerCotizacionProductoDetalle(){

        $sql = 'SELECT 
			crd.CrdId,			
			crd.CprId,
			crd.ProId,
			crd.UmeId,
			
			crd.CrdCodigo,
			crd.CrdDescripcion,
			
			crd.CrdPorcentajeUtilidad,
			crd.CrdPorcentajeOtroCosto,
			crd.CrdPorcentajeManoObra,
			crd.CrdPorcentajePedido,
			
			crd.CrdPorcentajeAdicional,
			crd.CrdPorcentajeDescuento,
			
			crd.CrdCosto,
			crd.CrdPrecioBruto,
			crd.CrdDescuento,
			crd.CrdPrecio,
		
			crd.CrdValorVenta,
			crd.CrdCantidad,
			crd.CrdCantidadReal,
			crd.CrdImporte,
			
			crd.CrdObservacion,
			DATE_FORMAT(crd.CrdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrdTiempoCreacion",
	        DATE_FORMAT(crd.CrdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCrdTiempoModificacion",
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			pro.ProStock,
			pro.ProStockReal,
			ume.UmeNombre
			FROM tblcrdcotizacionproductodetalle crd
				LEFT JOIN tblproproducto pro
				ON crd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON crd.UmeId = ume.UmeId
        WHERE crd.CrdId = "'.$this->CrdId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->CrdId = $fila['CrdId'];
			$this->CprId = $fila['CprId'];
			$this->UmeId = $fila['UmeId'];
			
			$this->CrdCodigo = $fila['CrdCodigo'];  
			$this->CrdDescripcion = $fila['CrdDescripcion']; 

			$this->CrdPorcentajeUtilidad = $fila['CrdPorcentajeUtilidad'];  
			$this->CrdPorcentajeOtroCosto = $fila['CrdPorcentajeOtroCosto'];  
			$this->CrdPorcentajeManoObra = $fila['CrdPorcentajeManoObra'];  
			$this->CrdPorcentajePedido = $fila['CrdPorcentajePedido'];  
			
			$this->CrdPorcentajeAdicional = $fila['CrdPorcentajeAdicional'];  
			$this->CrdPorcentajeDescuento = $fila['CrdPorcentajeDescuento'];  
			
			$this->CrdCosto = $fila['CrdCosto'];
		
			$this->CrdPrecioBruto = $fila['CrdPrecioBruto'];
			$this->CrdDescuento = $fila['CrdDescuento'];
			$this->CrdPrecio = $fila['CrdPrecio'];
		
			$this->CrdValorVenta = $fila['CrdValorVenta'];
			
			$this->CrdCantidad = $fila['CrdCantidad'];  
			$this->CrdCantidadReal = $fila['CrdCantidadReal'];  
			$this->CrdImporte = $fila['CrdImporte'];
			$this->CrdObservacion = $fila['CrdObservacion'];
			
			$this->CrdTiempoCreacion = $fila['NCrdTiempoCreacion'];  
			$this->CrdTiempoModificacion = $fila['NCrdTiempoModificacion']; 					
			$this->ProId = $fila['ProId'];	
			$this->ProNombre = (($fila['ProNombre']));
			$this->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
			$this->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
			$this->RtiId = (($fila['RtiId']));
			$this->UmeIdOrigen = (($fila['UmeIdOrigen']));
			$this->ProStock = (($fila['ProStock']));
			$this->ProStockReal = (($fila['ProStockReal']));
			
			$this->UmeNombre = (($fila['UmeNombre']));
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerCotizacionProductoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CrdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oCotizacion=NULL,$oEstado=NULL,$oProducto=NULL) {

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
		
		if(!empty($oCotizacion)){
			$amovimiento = ' AND crd.CprId = "'.$oCotizacion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND crd.CrdEstado = '.$oEstado.' ';
		}
		
		if(!empty($oProducto)){
			$producto = ' AND (crd.ProId = "'.$oProducto.'") ';
		}
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			crd.CrdId,			
			crd.CprId,
			crd.ProId,
			crd.UmeId,
			
			crd.CrdCodigo,
			crd.CrdDescripcion,
			
			crd.CrdPorcentajeUtilidad,
			crd.CrdPorcentajeOtroCosto,
			crd.CrdPorcentajeManoObra,
			crd.CrdPorcentajePedido,
			
			crd.CrdPorcentajeAdicional,
			crd.CrdPorcentajeDescuento,
			
			crd.CrdCosto,
			
			crd.CrdPrecioBruto,
			(crd.CrdPrecioBruto*crd.CrdCantidad) AS CrdImporteBruto,
				
			crd.CrdDescuento,
			(crd.CrdDescuento/crd.CrdCantidad) AS CrdDescuentoUnitario,
				
			crd.CrdAdicional,
			(crd.CrdAdicional/crd.CrdCantidad) AS CrdAdicionalUnitario,
			
			crd.CrdPrecio,	
			(crd.CrdPrecio * ((crd.CrdDescuentoPorcentaje/100)+1)) AS CrdPrecioNeto,
			crd.CrdValorVenta,
			
			crd.CrdCantidad,
			crd.CrdCantidadReal,
			crd.CrdImporte,
			
			crd.CrdTipoPedido,
			crd.CrdEstado,
			
			crd.CrdObservacion,
			DATE_FORMAT(crd.CrdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrdTiempoCreacion",
	        DATE_FORMAT(crd.CrdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCrdTiempoModificacion",
			pro.ProNombre,
			pro.ProCodigoOriginal,
			pro.ProCodigoAlternativo,
			pro.RtiId,
			pro.UmeId AS "UmeIdOrigen",
			pro.ProStock,
			pro.ProStockReal,
			ume.UmeNombre,
			ume.UmeAbreviacion,
			
			(
				SELECT 
				vdd.VddId 
				FROM tblvddventadirectadetalle vdd
				
					LEFT JOIN tblvdiventadirecta vdi
					ON vdd.VdiId = vdi.VdiId
						
				WHERE vdd.CrdId = crd.CrdId
					AND vdi.VdiEstado = 3
				LIMIT 1
			) AS VddId,

			@Cantidad:=(
				SELECT 
				SUM(vdd.VddCantidad)
				FROM tblvddventadirectadetalle vdd
				
					LEFT JOIN tblvdiventadirecta vdi
					ON vdd.VdiId = vdi.VdiId
						
				WHERE vdd.CrdId = crd.CrdId
					AND vdi.VdiEstado = 3
				LIMIT 1
			) AS VddCantidad ,
			
			(
			IFNULL(crd.CrdCantidad,0) - IFNULL(@Cantidad,0)
			) AS CrdCantidadPendiente
			
			
			FROM tblcrdcotizacionproductodetalle crd
				LEFT JOIN tblproproducto pro
				ON crd.ProId = pro.ProId
					LEFT JOIN tblumeunidadmedida ume
					ON crd.UmeId = ume.UmeId
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsCotizacionProductoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$CotizacionProductoDetalle = new $InsCotizacionProductoDetalle();
                    $CotizacionProductoDetalle->CrdId = $fila['CrdId'];
                    $CotizacionProductoDetalle->CprId = $fila['CprId'];
					$CotizacionProductoDetalle->UmeId = $fila['UmeId'];

					$CotizacionProductoDetalle->CrdCodigo = $fila['CrdCodigo'];  
					$CotizacionProductoDetalle->CrdDescripcion = $fila['CrdDescripcion'];  
					
					$CotizacionProductoDetalle->CrdMargenPorcentaje = $fila['CrdMargenPorcentaje'];  
					$CotizacionProductoDetalle->CrdMantenimientoPorcentaje = $fila['CrdMantenimientoPorcentaje'];  
					$CotizacionProductoDetalle->CrdFletePorcentaje = $fila['CrdFletePorcentaje'];  
					$CotizacionProductoDetalle->CrdDescuentoPorcentaje = $fila['CrdDescuentoPorcentaje'];  
					
					$CotizacionProductoDetalle->CrdPorcentajeUtilidad = $fila['CrdPorcentajeUtilidad'];  
					$CotizacionProductoDetalle->CrdPorcentajeOtroCosto = $fila['CrdPorcentajeOtroCosto'];  
					$CotizacionProductoDetalle->CrdPorcentajeManoObra = $fila['CrdPorcentajeManoObra'];  
					$CotizacionProductoDetalle->CrdPorcentajePedido = $fila['CrdPorcentajePedido'];  
					
					$CotizacionProductoDetalle->CrdPorcentajeAdicional = $fila['CrdPorcentajeAdicional'];  
					$CotizacionProductoDetalle->CrdPorcentajeDescuento = $fila['CrdPorcentajeDescuento'];  

					$CotizacionProductoDetalle->CrdCosto = $fila['CrdCosto'];
					$CotizacionProductoDetalle->CrdPrecio = $fila['CrdPrecio'];
					$CotizacionProductoDetalle->CrdPrecioNeto = $fila['CrdPrecioNeto'];
					
					$CotizacionProductoDetalle->CrdPrecioBruto = $fila['CrdPrecioBruto'];
					$CotizacionProductoDetalle->CrdImporteBruto = $fila['CrdImporteBruto'];
					
					$CotizacionProductoDetalle->CrdDescuento = $fila['CrdDescuento'];
					$CotizacionProductoDetalle->CrdDescuentoUnitario = $fila['CrdDescuentoUnitario'];
					
					$CotizacionProductoDetalle->CrdAdicional = $fila['CrdAdicional'];
					$CotizacionProductoDetalle->CrdAdicionalUnitario = $fila['CrdAdicionalUnitario'];
					
					$CotizacionProductoDetalle->CrdPrecio = $fila['CrdPrecio'];
						
					$CotizacionProductoDetalle->CrdValorVenta = $fila['CrdValorVenta'];
					
			        $CotizacionProductoDetalle->CrdCantidad = $fila['CrdCantidad'];  
					$CotizacionProductoDetalle->CrdCantidadReal = $fila['CrdCantidadReal'];  
					$CotizacionProductoDetalle->CrdImporte = $fila['CrdImporte'];
					
					$CotizacionProductoDetalle->CrdTipoPedido = $fila['CrdTipoPedido'];
					$CotizacionProductoDetalle->CrdEstado = $fila['CrdEstado'];
					
					
					$CotizacionProductoDetalle->CrdObservacion = $fila['CrdObservacion'];
					
					$CotizacionProductoDetalle->CrdTiempoCreacion = $fila['NCrdTiempoCreacion'];  
					$CotizacionProductoDetalle->CrdTiempoModificacion = $fila['NCrdTiempoModificacion']; 					
					$CotizacionProductoDetalle->ProId = $fila['ProId'];	
                    $CotizacionProductoDetalle->ProNombre = (($fila['ProNombre']));
					$CotizacionProductoDetalle->ProCodigoOriginal = (($fila['ProCodigoOriginal']));
					$CotizacionProductoDetalle->ProCodigoAlternativo = (($fila['ProCodigoAlternativo']));
					$CotizacionProductoDetalle->RtiId = (($fila['RtiId']));
					$CotizacionProductoDetalle->UmeIdOrigen = (($fila['UmeIdOrigen']));
					$CotizacionProductoDetalle->ProStock = (($fila['ProStock']));
					$CotizacionProductoDetalle->ProStockReal = (($fila['ProStockReal']));
					
					$CotizacionProductoDetalle->UmeNombre = (($fila['UmeNombre']));
					$CotizacionProductoDetalle->UmeAbreviacion = (($fila['UmeAbreviacion']));
					
					$CotizacionProductoDetalle->VddId = (($fila['VddId']));
					
					$CotizacionProductoDetalle->VddCantidad = (($fila['VddCantidad']));
					
					$CotizacionProductoDetalle->CrdCantidadPendiente = (($fila['CrdCantidadPendiente']));
					
                    $CotizacionProductoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $CotizacionProductoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarCotizacionProductoDetalle($oElementos) {
		
//		$InsCotizacionProductoDetalleOrigen = new ClsCotizacionProductoDetalleOrigen();
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (CrdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CrdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblcrdcotizacionproductodetalle 
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
	
	
	public function MtdRegistrarCotizacionProductoDetalle() {
	
			$this->MtdGenerarCotizacionProductoDetalleId();
		  
					
			$sql = 'INSERT INTO tblcrdcotizacionproductodetalle (
			CrdId,
			CprId,
			
			ProId,
			UmeId,
			
			CrdCodigo,
			CrdDescripcion,
			
			CrdPorcentajeUtilidad,
			CrdPorcentajeOtroCosto,
			CrdPorcentajeManoObra,
			CrdPorcentajePedido,
			
			CrdPorcentajeAdicional,
			CrdPorcentajeDescuento,
					
			CrdCosto,
			CrdValorVenta,
			CrdAdicional,
			CrdDescuento,
			
			CrdPrecioBruto,
			CrdPrecio,	
					
			CrdCantidad,
			CrdCantidadReal,
			CrdImporte,
			
			CrdTipoPedido,
			
			CrdObservacion,
			CrdEstado,
			CrdTiempoCreacion,
			CrdTiempoModificacion) 
			VALUES (
			"'.($this->CrdId).'", 
			"'.($this->CprId).'", 

			'.(empty($this->ProId)?'NULL,':'"'.$this->ProId.'",').'	
			'.(empty($this->UmeId)?'NULL,':'"'.$this->UmeId.'",').'				

			"'.($this->CrdCodigo).'", 
			"'.($this->CrdDescripcion).'", 

			'.($this->CrdPorcentajeUtilidad).', 
			'.($this->CrdPorcentajeOtroCosto).', 
			'.($this->CrdPorcentajeManoObra).', 
			'.($this->CrdPorcentajePedido).', 
			
			'.($this->CrdPorcentajeAdicional).', 
			'.($this->CrdPorcentajeDescuento).', 
		
			'.($this->CrdCosto).', 				
			'.($this->CrdValorVenta).',
			'.($this->CrdAdicional).', 				
			'.($this->CrdDescuento).',
			
			'.($this->CrdPrecioBruto).',
			'.($this->CrdPrecio).',
		
			'.($this->CrdCantidad).',
			'.($this->CrdCantidadReal).',
			'.($this->CrdImporte).', 
			
			"'.($this->CrdTipoPedido).'",	
			
			"'.($this->CrdObservacion).'",	
			'.($this->CrdEstado).',
			"'.($this->CrdTiempoCreacion).'",
			"'.($this->CrdTiempoModificacion).'");';
		
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
	
	public function MtdEditarCotizacionProductoDetalle() {

			 $sql = 'UPDATE tblcrdcotizacionproductodetalle SET 	
			
			'.(empty($this->UmeId)?'UmeId = NULL, ':'UmeId = "'.$this->UmeId.'",').'
			
			CrdCodigo = "'.($this->CrdCodigo).'",
			CrdDescripcion = "'.($this->CrdDescripcion).'",
			 
			CrdPorcentajeUtilidad = '.($this->CrdPorcentajeUtilidad).',
			CrdPorcentajeOtroCosto = '.($this->CrdPorcentajeOtroCosto).',
			CrdPorcentajeManoObra = '.($this->CrdPorcentajeManoObra).',
			CrdPorcentajePedido = '.($this->CrdPorcentajePedido).',
			
			CrdPorcentajeAdicional = '.($this->CrdPorcentajeAdicional).',
			CrdPorcentajeDescuento = '.($this->CrdPorcentajeDescuento).',
			
			CrdCosto = '.($this->CrdCosto).',
			CrdValorVenta = '.($this->CrdValorVenta).',
			CrdAdicional = '.($this->CrdAdicional).',
			CrdDescuento = '.($this->CrdDescuento).',
			
			CrdPrecioBruto = '.($this->CrdPrecioBruto).',
			CrdDescuento = '.($this->CrdDescuento).',
			CrdPrecio = '.($this->CrdPrecio).',
			
			 CrdCantidad = '.($this->CrdCantidad).',
			 CrdCantidadReal = '.($this->CrdCantidadReal).',
			 
			 CrdTipoPedido = "'.($this->CrdTipoPedido).'",
			 
			 CrdObservacion = "'.($this->CrdObservacion).'",
			 
			 
			 CrdEstado = '.($this->CrdEstado).',
			 CrdImporte = '.($this->CrdImporte).',
			 CrdTiempoModificacion = "'.($this->CrdTiempoModificacion).'"
			 WHERE CrdId = "'.($this->CrdId).'";';
					
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
		
		
		public function MtdEditarCotizacionProductoDetalleDato($oCampo,$oDato,$oCotizacionProductoDetalleId) {

			 $sql = 'UPDATE tblcrdcotizacionproductodetalle SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			CrdTiempoModificacion = NOW()		
			
			WHERE CrdId = "'.($oCotizacionProductoDetalleId).'";';
					
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