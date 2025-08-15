<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFacturaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFacturaDetalle {

    public $FdeId;
    public $FacId;
	public $FtaId;
	public $AmdId;
	public $FatId;
	public $FdeTipo;

	public $FdeDescripcion;
	public $FdeUnidadMedida;	

	public $FdeCantidad;	
	public $FdePrecio;
	public $FdeImporte;
	public $FdeImpuestoSelectivo;
	public $FdeIncluyeSelectivo;
	
	public $FdeEstado;
	public $FdeTiempoCreacion;
	public $FdeTiempoModificacion;
    public $FdeEliminado;

	public $OdeId;
	public $OriId;
	
	public $FacFechaEmision;
	public $FacTipoCambio;
	public $FacIncluyeImpuesto;
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

	private function MtdGenerarFacturaDetalleId() {

	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FdeId,5),unsigned)) AS "MAXIMO"
			FROM tblfdefacturadetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FdeId = "FDE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FdeId = "FDE-".$fila['MAXIMO'];					
			}
			
					
		}
		
    public function MtdObtenerFacturaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFactura=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oFacturaEstado=NULL,$oVentaDirectaDetalleId=NULL) {

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
		
		if(!empty($oFactura) and !empty($oTalonario)){
			$factura = ' AND fde.FacId="'.$oFactura.'" AND fde.FtaId = "'.$oTalonario.'"';
		}
		
		if(!empty($oAlmacenMovimientoDetalleId)){
			$amdetalle = ' AND fde.AmdId="'.$oAlmacenMovimientoDetalleId.'" ';
		}	
		
		if(!empty($oFacturaEstado)){
			$festado = ' AND fac.FacEstado = '.$oFacturaEstado.' ';
		}
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetale = ' AND  amd.VddId="'.$oVentaDirectaDetalleId.'" ';
		}		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fde.FdeId,
				fde.AmdId	 AS "OdeId" ,
				amd.AmoId  AS "OriId" ,
				
				fde.AmdId,
				fde.FatId,
					
				fde.FdeTipo,
				
				fde.FdeCodigo,
				fde.FdeDescripcion,
				fde.FdeUnidadMedida,
				
                fde.FdeCantidad,
				fde.FdePrecio,
				fde.FdeImporte,
				
				(fde.FdeValorVenta/fde.FdeCantidad) AS FdeValorVentaUnitario,
				fde.FdeValorVenta,
				fde.FdeImpuesto,
				fde.FdeImpuestoSelectivo,
				fde.FdeDescuento,
				
				((fde.FdeDescuento / (fde.FdeImporte/((fac.FacPorcentajeImpuestoVenta/100)+1)))*100) AS FdePorcentajeDescuento,
				
				fde.FdeGratuito,
				fde.FdeExonerado,
				fde.FdeIncluyeSelectivo,				
				
				DATE_FORMAT(fde.FdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFdeTiempoCreacion",
	        	DATE_FORMAT(fde.FdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFdeTiempoModificacion",
				
				fde.FacId,
				fde.FtaId,
				
				fta.FtaNumero,
				
				DATE_FORMAT(fac.FacFechaEmision, "%d/%m/%Y") AS "NFacFechaEmision",
				fac.FacTipoCambio,
				fac.FacIncluyeImpuesto,
				
				amd.AmdReingreso AS VcdReingreso,
				amd.AmdCompraOrigen,
				
				IFNULL(ume.UmeCodigo,IFNULL(ume2.UmeCodigo,"ZZ")) AS FdeUnidadMedidaCodigo
				
				FROM tblfdefacturadetalle fde
					LEFT JOIN tblfacfactura fac
					ON (fde.FacId = fac.FacId  AND fde.FtaId = fac.FtaId)
				
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON fde.AmdId = amd.AmdId
					
						LEFT JOIN tblumeunidadmedida ume
						ON amd.UmeId = ume.UmeId
						
						
						LEFT JOIN tblvmdvehiculomovimientodetalle vmd
					ON fde.VmdId = vmd.VmdId
						LEFT JOIN tblumeunidadmedida ume2
						ON vmd.UmeId = ume2.UmeId
						
						
						
						LEFT JOIN tblvddventadirectadetalle vdd
						ON amd.VddId = vdd.VddId

				WHERE 1 = 1 '.$factura.$filtrar.$amdetalle.$festado.$vddetale.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFacturaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FacturaDetalle = new $InsFacturaDetalle();
                    $FacturaDetalle->FdeId = $fila['FdeId'];

					$FacturaDetalle->OdeId = $fila['OdeId'];
					$FacturaDetalle->OriId = $fila['OriId'];
					
					$FacturaDetalle->AmdId = $fila['AmdId'];
					$FacturaDetalle->FatId = $fila['FatId'];
					
					$FacturaDetalle->FdeTipo = $fila['FdeTipo'];

                    $FacturaDetalle->FdeCodigo = (($fila['FdeCodigo']));	
					$FacturaDetalle->FdeDescripcion = (($fila['FdeDescripcion']));	
					$FacturaDetalle->FdeUnidadMedida = $fila['FdeUnidadMedida'];
					
                    $FacturaDetalle->FdePrecio = $fila['FdePrecio'];
					$FacturaDetalle->FdeCantidad = $fila['FdeCantidad'];
					$FacturaDetalle->FdeImporte = $fila['FdeImporte'];	
					$FacturaDetalle->FdeValorVentaUnitario = $fila['FdeValorVentaUnitario'];	
					
					$FacturaDetalle->FdeValorVenta = $fila['FdeValorVenta'];	
					$FacturaDetalle->FdeImpuesto = $fila['FdeImpuesto'];	
					$FacturaDetalle->FdeDescuento = $fila['FdeDescuento'];	
					$FacturaDetalle->FdeImpuestoSelectivo = $fila['FdeImpuestoSelectivo'];	
					
					$FacturaDetalle->FdeGratuito = $fila['FdeGratuito'];	
					$FacturaDetalle->FdeExonerado = $fila['FdeExonerado'];	
					$FacturaDetalle->FdeIncluyeSelectivo = $fila['FdeIncluyeSelectivo'];	
							
					$FacturaDetalle->FdeTiempoCreacion = $fila['NFdeTiempoCreacion'];  
					$FacturaDetalle->FdeTiempoModificacion = $fila['NFdeTiempoModificacion']; 
					
					$FacturaDetalle->FacId = $fila['FacId']; 
					$FacturaDetalle->FtaId = $fila['FtaId'];

					$FacturaDetalle->FtaNumero = $fila['FtaNumero']; 
					
					$FacturaDetalle->FacFechaEmision = $fila['NFacFechaEmision'];
					$FacturaDetalle->FacTipoCambio = $fila['FacTipoCambio'];
					
					$FacturaDetalle->FacIncluyeImpuesto = $fila['FacIncluyeImpuesto'];
					
					$FacturaDetalle->VcdReingreso = $fila['VcdReingreso'];
					$FacturaDetalle->AmdCompraOrigen = $fila['AmdCompraOrigen'];
					
					$FacturaDetalle->FdeUnidadMedidaCodigo = $fila['FdeUnidadMedidaCodigo'];

                    $FacturaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FacturaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	//Accion eliminar	 
	
	public function MtdEliminarFacturaDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (FdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
			

		
			$sql = 'DELETE FROM tblfdefacturadetalle 
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
	
	
	public function MtdRegistrarFacturaDetalle() {
	
			$this->MtdGenerarFacturaDetalleId();

			
			$sql = 'INSERT INTO tblfdefacturadetalle (
			FdeId,
			FacId, 
			FtaId,
			
			AmdId,
			FatId,
			
			FdeTipo,
			
			FdeCantidad,
			FdeCodigo,
			FdeDescripcion,
			FdeUnidadMedida,
			
			FdePrecio,
			FdeImporte,
			
			FdeValorVenta,
			FdeImpuesto,
			FdeImpuestoSelectivo,
			FdeDescuento,
			
			FdeGratuito,
			FdeExonerado,
			FdeIncluyeSelectivo,
			
			FdeTiempoCreacion,
			FdeTiempoModificacion
			) 
			VALUES (
			"'.($this->FdeId).'", 
			"'.($this->FacId).'",
			"'.($this->FtaId).'",
			
			'.(empty($this->AmdId)?'NULL, ':'"'.$this->AmdId.'",').'
			'.(empty($this->FatId)?'NULL, ':'"'.$this->FatId.'",').'
			
			"'.($this->FdeTipo).'",	
			'.($this->FdeCantidad).',
			"'.($this->FdeCodigo).'",	
			"'.($this->FdeDescripcion).'",
			"'.($this->FdeUnidadMedida).'",
			
			'.($this->FdePrecio).',
			'.($this->FdeImporte).',
			
			'.($this->FdeValorVenta).',
			'.($this->FdeImpuesto).',
			'.($this->FdeImpuestoSelectivo).',
			'.($this->FdeDescuento).',
			
			
			'.($this->FdeGratuito).',
			'.($this->FdeExonerado).',
			'.($this->FdeIncluyeSelectivo).',
			
			"'.($this->FdeTiempoCreacion).'",
			"'.($this->FdeTiempoModificacion).'");';

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
	
	public function MtdEditarFacturaDetalle() {		

			$sql = 'UPDATE tblfdefacturadetalle SET
			
			 FdeTipo = "'.($this->FdeTipo).'",
			 
			 FdeCantidad = '.($this->FdeCantidad).',
			 FdeCodigo = "'.addslashes($this->FdeCodigo).'",
			 FdeDescripcion = "'.addslashes($this->FdeDescripcion).'",
			 FdeUnidadMedida = "'.addslashes($this->FdeUnidadMedida).'",
			 
			 FdePrecio = '.($this->FdePrecio).',
			 FdeImporte = '.($this->FdeImporte).',
			 
			 FdeValorVenta = '.($this->FdeValorVenta).',
			 FdeImpuesto = '.($this->FdeImpuesto).',
			 FdeImpuestoSelectivo = '.($this->FdeImpuestoSelectivo).',
			 FdeDescuento = '.($this->FdeDescuento).',
			 
			 FdeGratuito = '.($this->FdeGratuito).',
			 FdeExonerado = '.($this->FdeExonerado).',
			 FdeIncluyeSelectivo = '.($this->FdeIncluyeSelectivo).',
			 
			 FdeTiempoModificacion = "'.($this->FdeTiempoModificacion).'"
			 WHERE FdeId = "'.($this->FdeId).'";';
					
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