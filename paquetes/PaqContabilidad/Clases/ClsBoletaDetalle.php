<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsBoletaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsBoletaDetalle {

    public $BdeId;
    public $BolId;
	public $BtaId;
	
	public $AmdId;
	
	public $BdeTipo;
	
	public $BdeDescripcion;
	public $BdeUnidadMedida;
	
	public $BdeCantidad;	
	public $BdePrecio;
	public $BdeImporte;	
	public $BdeEstado;
	public $BdeTiempoCreacion;
	public $BdeTiempoModificacion;
    public $BdeEliminado;
	
	public $OdeId;
	public $OriId;
	
	public $BolFechaEmision;
	public $BolTipoCambio;
	public $BolIncluyeImpuesto;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarBoletaDetalleId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(BdeId,5),unsigned)) AS "MAXIMO"
			FROM tblbdeboletadetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->BdeId = "BDE-10000";
			}else{
				$fila['MAXIMO']++;
				$this->BdeId = "BDE-".$fila['MAXIMO'];					
			}
			
					
		}
		

    public function MtdObtenerBoletaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'BdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oBoleta=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oBoletaEstado=NULL,$oVentaDirectaDetalleId=NULL) {

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
		
		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oBoleta) and !empty($oTalonario)){
			$boleta = ' AND bde.BolId = "'.$oBoleta.'" AND bde.BtaId = "'.$oTalonario.'"';
		}
		
		if(!empty($oAlmacenMovimientoDetalleId)){
			$amdetalle = ' AND bde.AmdId="'.$oAlmacenMovimientoDetalleId.'" ';
		}	
		
		if(!empty($oBoletaEstado)){
			$bestado = ' AND bol.BolEstado = '.$oBoletaEstado.' ';
		}
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetale = ' AND  amd.VddId="'.$oVentaDirectaDetalleId.'" ';
		}
		
							
							
							
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				bde.BdeId,
				bde.AmdId AS "OdeId",
				amd.AmoId AS "OriId",
				
				
				bde.AmdId,
				bde.VmdId,
				
				bde.FatId,
				
				bde.BdeTipo,
				
				bde.BdeDescripcion,				
				bde.BdeCodigo,
				bde.BdeUnidadMedida,
				bde.BdeUnidadMedidaCodigo,
                bde.BdeCantidad,
				
				bde.BdePrecio,
				bde.BdeImporte,
				
				(bde.BdeValorVenta/bde.BdeCantidad) AS BdeValorVentaUnitario,
				bde.BdeValorVenta,
				bde.BdeImpuesto,
				bde.BdeImpuestoSelectivo,
				bde.BdeDescuento,
				(bde.BdeValorVenta + bde.BdeDescuento) AS BdeValorVentaBruto,
				
				((bde.BdeDescuento / (bde.BdeImporte/((bol.BolPorcentajeImpuestoVenta/100)+1)))*100) AS BdePorcentajeDescuento,
								
				bde.BdeGratuito,
				bde.BdeExonerado,
				bde.BdeIncluyeSelectivo,
				
				DATE_FORMAT(bde.BdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NBdeTiempoCreacion",
	        	DATE_FORMAT(bde.BdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NBdeTiempoModificacion",
				
				bde.BolId,
				bde.BtaId,
				
				bta.BtaNumero,
				
				DATE_FORMAT(bol.BolFechaEmision, "%d/%m/%Y") AS "NBolFechaEmision",
				
				bol.BolTipoCambio,
				
				amd.AmdReingreso AS VcdReingreso,
				amd.AmdCompraOrigen,
				
				IFNULL(ume.UmeCodigo,IFNULL(ume2.UmeCodigo,"ZZ")) AS BdeUnidadMedidaCodigo
				
				FROM tblbdeboletadetalle bde
				
					LEFT JOIN tblbolboleta bol
					ON (bde.BolId = bol.BolId AND bde.BtaId = bol.BtaId)
					
						LEFT JOIN tblbtaboletatalonario bta
						ON bol.BtaId = bta.BtaId
						
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON bde.AmdId = amd.AmdId
						LEFT JOIN tblumeunidadmedida ume
						ON amd.UmeId = ume.UmeId
						
							
					LEFT JOIN tblvmdvehiculomovimientodetalle vmd
					ON bde.VmdId = vmd.VmdId
						LEFT JOIN tblumeunidadmedida ume2
						ON vmd.UmeId = ume2.UmeId
						
						
						
						LEFT JOIN tblvddventadirectadetalle vdd
						ON amd.VddId = vdd.VddId
						
				WHERE 1 = 1'.$boleta.$filtrar.$amdetalle.$bestado.$vddetale.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsBoletaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$BoletaDetalle = new $InsBoletaDetalle();
                    $BoletaDetalle->BdeId = $fila['BdeId'];  
					                  
					$BoletaDetalle->OdeId = $fila['OdeId'];
					$BoletaDetalle->OriId = $fila['OriId'];
					
					$BoletaDetalle->AmdId = $fila['AmdId'];
					$BoletaDetalle->VmdId = $fila['VmdId'];
					
					$BoletaDetalle->FatId = $fila['FatId'];
					
					$BoletaDetalle->BdeTipo = (($fila['BdeTipo']));
                    $BoletaDetalle->BdeDescripcion = (($fila['BdeDescripcion']));
					$BoletaDetalle->BdeCodigo = $fila['BdeCodigo'];
					$BoletaDetalle->BdeUnidadMedida = $fila['BdeUnidadMedida'];
					$BoletaDetalle->BdeUnidadMedidaCodigo = $fila['BdeUnidadMedidaCodigo'];
					
                    $BoletaDetalle->BdePrecio = $fila['BdePrecio'];
					$BoletaDetalle->BdeCantidad = $fila['BdeCantidad'];
					$BoletaDetalle->BdeImporte = $fila['BdeImporte'];
					
					$BoletaDetalle->BdeValorVentaUnitario = $fila['BdeValorVentaUnitario'];
					$BoletaDetalle->BdeValorVenta = $fila['BdeValorVenta'];
					$BoletaDetalle->BdeImpuesto = $fila['BdeImpuesto'];
					$BoletaDetalle->BdeImpuestoSelectivo = $fila['BdeImpuestoSelectivo'];
					$BoletaDetalle->BdeDescuento = $fila['BdeDescuento'];
					$BoletaDetalle->BdeValorVentaBruto = $fila['BdeValorVentaBruto'];
					
					$BoletaDetalle->BdePorcentajeDescuento = $fila['BdePorcentajeDescuento'];
					
					$BoletaDetalle->BdeExonerado = $fila['BdeExonerado'];
					$BoletaDetalle->BdeGratuito = $fila['BdeGratuito'];
					$BoletaDetalle->BdeIncluyeSelectivo = $fila['BdeIncluyeSelectivo'];
					
					$BoletaDetalle->BdeTiempoCreacion = $fila['NBdeTiempoCreacion'];  
					$BoletaDetalle->BdeTiempoModificacion = $fila['NBdeTiempoModificacion']; 
					
					$BoletaDetalle->BolId = $fila['BolId']; 
					$BoletaDetalle->BtaId = $fila['BtaId']; 
					$BoletaDetalle->BtaNumero = $fila['BtaNumero']; 
					
					$BoletaDetalle->BolFechaEmision = $fila['NBolFechaEmision']; 
					$BoletaDetalle->BolTipoCambio = $fila['BolTipoCambio']; 
					
					$BoletaDetalle->VcdReingreso = $fila['VcdReingreso']; 
					$BoletaDetalle->AmdCompraOrigen = $fila['AmdCompraOrigen']; 
					
					$BoletaDetalle->BdeUnidadMedidaCodigo = $fila['BdeUnidadMedidaCodigo']; 
				
					
                    $BoletaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $BoletaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	
	//Accion eliminar	 
	
	public function MtdEliminarBoletaDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (BdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (BdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM tblbdeboletadetalle 
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
	
	
	public function MtdRegistrarBoletaDetalle() {

			$this->MtdGenerarBoletaDetalleId();

			$sql = 'INSERT INTO tblbdeboletadetalle (
			BdeId,
			BolId, 
			BtaId,
			
			AmdId,
			VmdId,
			
			FatId,
			
			BdeTipo,
			
			BdeCantidad,
			BdeDescripcion,
			BdeCodigo,
			BdeUnidadMedida,
			BdeUnidadMedidaCodigo,
			
			BdePrecio,
			BdeImporte,
			
			BdeValorVenta,
			BdeImpuesto,
			BdeImpuestoSelectivo,
			BdeDescuento,
			
			BdeExonerado,
			BdeGratuito,
			BdeIncluyeSelectivo,
			BdeTiempoCreacion,
			BdeTiempoModificacion
			) 
			VALUES (
			"'.($this->BdeId).'", 
			"'.($this->BolId).'", 
			"'.($this->BtaId).'", 
			'.(empty($this->AmdId)?'NULL, ':'"'.$this->AmdId.'",').'
			'.(empty($this->VmdId)?'NULL, ':'"'.$this->VmdId.'",').'
			
			'.(empty($this->FatId)?'NULL, ':'"'.$this->FatId.'",').'
			
			"'.($this->BdeTipo).'",
			'.($this->BdeCantidad).',
			"'.addslashes($this->BdeDescripcion).'",
			"'.addslashes($this->BdeCodigo).'",
			"'.addslashes($this->BdeUnidadMedida).'",
			"'.addslashes($this->BdeUnidadMedidaCodigo).'",
			
			'.($this->BdePrecio).',
			'.($this->BdeImporte).',
			
			'.($this->BdeValorVenta).',
			'.($this->BdeImpuesto).',
			'.($this->BdeImpuestoSelectivo).',
			'.($this->BdeDescuento).',
			
			'.($this->BdeExonerado).',
			'.($this->BdeGratuito).',
			'.($this->BdeIncluyeSelectivo).',
			"'.($this->BdeTiempoCreacion).'", 				
			"'.($this->BdeTiempoModificacion).'");';					

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
	
	public function MtdEditarBoletaDetalle() {
		
			$sql = 'UPDATE tblbdeboletadetalle SET
			BdeTipo = "'.($this->BdeTipo).'",
			BdeCantidad = '.($this->BdeCantidad).',
			BdeDescripcion = "'.addslashes($this->BdeDescripcion).'",
			BdeCodigo = "'.addslashes($this->BdeCodigo).'",
			BdeUnidadMedida = "'.addslashes($this->BdeUnidadMedida).'",
			BdeUnidadMedidaCodigo = "'.addslashes($this->BdeUnidadMedidaCodigo).'",
			
			BdePrecio = '.($this->BdePrecio).',
			BdeImporte = '.($this->BdeImporte).',
			
			BdeValorVenta = '.($this->BdeValorVenta).',
			BdeImpuesto = '.($this->BdeImpuesto).',
			BdeImpuestoSelectivo = '.($this->BdeImpuestoSelectivo).',
			BdeDescuento = '.($this->BdeDescuento).',
			
			BdeGratuito = '.($this->BdeGratuito).',
			BdeExonerado = '.($this->BdeExonerado).',
			BdeIncluyeSelectivo = '.($this->BdeIncluyeSelectivo).',
			BdeTiempoModificacion = "'.($this->BdeTiempoModificacion).'"
			WHERE BdeId = "'.($this->BdeId).'";';
					
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