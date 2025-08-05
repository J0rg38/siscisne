<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFacturaExportacionDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFacturaExportacionDetalle {

    public $FedId;
    public $FexId;
	public $FetId;
	
	public $AmdId;
	
	public $FedTipo;
	
	public $FedDescripcion;
	public $FedUnidadMedida;
	
	public $FedCantidad;	
	public $FedPrecio;
	public $FedImporte;	
	public $FedEstado;
	public $FedTiempoCreacion;
	public $FedTiempoModificacion;
    public $FedEliminado;
	
	public $OdeId;
	public $OriId;
	
	public $FexFechaEmision;
	public $FexTipoCambio;
	public $FexIncluyeImpuesto;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFacturaExportacionDetalleId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FedId,5),unsigned)) AS "MAXIMO"
			FROM tblfedfacturaexportaciondetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FedId = "FED-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FedId = "FED-".$fila['MAXIMO'];					
			}
			
					
		}
		

    public function MtdObtenerFacturaExportacionDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FedId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFacturaExportacion=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oFacturaExportacionEstado=NULL,$oVentaDirectaDetalleId=NULL) {

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
		
		if(!empty($oFacturaExportacion) and !empty($oTalonario)){
			$boleta = ' AND fed.FexId = "'.$oFacturaExportacion.'" AND fed.FetId = "'.$oTalonario.'"';
		}
		
		if(!empty($oAlmacenMovimientoDetalleId)){
			$amdetalle = ' AND fed.AmdId="'.$oAlmacenMovimientoDetalleId.'" ';
		}	
		
		if(!empty($oFacturaExportacionEstado)){
			$bestado = ' AND fex.FexEstado = '.$oFacturaExportacionEstado.' ';
		}
		
		if(!empty($oVentaDirectaDetalleId)){
			$vddetale = ' AND  amd.VddId="'.$oVentaDirectaDetalleId.'" ';
		}
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				fed.FedId,
				fed.AmdId,
				amd.AmoId,
				
				fed.FedTipo,
				
				fed.FedDescripcion,
				fed.FedUnidadMedida,
                fed.FedCantidad,
				fed.FedPrecio,
				fed.FedImporte,
				DATE_FORMAT(fed.FedTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFedTiempoCreacion",
	        	DATE_FORMAT(fed.FedTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFedTiempoModificacion",
				
				fed.FexId,
				fed.FetId,
				
				fet.FetNumero,
				
				DATE_FORMAT(fex.FexFechaEmision, "%d/%m/%Y") AS "NFexFechaEmision",
				
				fex.FexTipoCambio,
				
				amd.AmdReingreso AS VcdReingreso
				
				FROM tblfedfacturaexportaciondetalle fed
				
					LEFT JOIN tblfexfacturaexportacion fex
					ON (fed.FexId = fex.FexId AND fed.FetId = fex.FetId)
					
						LEFT JOIN tblfetfacturaexportaciontalonario fet
						ON fex.FetId = fet.FetId
						
					LEFT JOIN tblamdalmacenmovimientodetalle amd
					ON fed.AmdId = amd.AmdId
						
						LEFT JOIN tblvddventadirectadetalle vdd
						ON amd.VddId = vdd.VddId
						
				WHERE 1 = 1'.$boleta.$filtrar.$amdetalle.$bestado.$vddetale.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFacturaExportacionDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FacturaExportacionDetalle = new $InsFacturaExportacionDetalle();
                    $FacturaExportacionDetalle->FedId = $fila['FedId'];  
					                  
					$FacturaExportacionDetalle->AmdId = $fila['AmdId'];
					$FacturaExportacionDetalle->AmoId = $fila['AmoId'];
					
					$FacturaExportacionDetalle->FedTipo = (($fila['FedTipo']));
                    $FacturaExportacionDetalle->FedDescripcion = (($fila['FedDescripcion']));
					$FacturaExportacionDetalle->FedUnidadMedida = $fila['FedUnidadMedida'];
					
                    $FacturaExportacionDetalle->FedPrecio = $fila['FedPrecio'];
					$FacturaExportacionDetalle->FedCantidad = $fila['FedCantidad'];
					$FacturaExportacionDetalle->FedImporte = $fila['FedImporte'];
					$FacturaExportacionDetalle->FedTiempoCreacion = $fila['NFedTiempoCreacion'];  
					$FacturaExportacionDetalle->FedTiempoModificacion = $fila['NFedTiempoModificacion']; 
					
					$FacturaExportacionDetalle->FexId = $fila['FexId']; 
					$FacturaExportacionDetalle->FetId = $fila['FetId']; 
					$FacturaExportacionDetalle->FetNumero = $fila['FetNumero']; 
					
					$FacturaExportacionDetalle->FexFechaEmision = $fila['NFexFechaEmision']; 
					$FacturaExportacionDetalle->FexTipoCambio = $fila['FexTipoCambio']; 
					
					$FacturaExportacionDetalle->VcdReingreso = $fila['VcdReingreso']; 
				
					
                    $FacturaExportacionDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FacturaExportacionDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	
	//Accion eliminar	 
	
	public function MtdEliminarFacturaExportacionDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (FedId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FedId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM tblfedfacturaexportaciondetalle 
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
	
	
	public function MtdRegistrarFacturaExportacionDetalle() {

			$this->MtdGenerarFacturaExportacionDetalleId();

			$sql = 'INSERT INTO tblfedfacturaexportaciondetalle (
			FedId,
			FexId, 
			FetId,
			AmdId,
			
			FedTipo,
			
			FedCantidad,
			FedDescripcion,
			FedUnidadMedida,
			
			FedPrecio,
			FedImporte,
			FedTiempoCreacion,
			FedTiempoModificacion
			) 
			VALUES (
			"'.($this->FedId).'", 
			"'.($this->FexId).'", 
			"'.($this->FetId).'", 
			'.(empty($this->AmdId)?'NULL, ':'"'.$this->AmdId.'",').'
			"'.($this->FedTipo).'",
			'.($this->FedCantidad).',
			"'.addslashes($this->FedDescripcion).'",
			"'.addslashes($this->FedUnidadMedida).'",
			'.($this->FedPrecio).',
			'.($this->FedImporte).',
			"'.($this->FedTiempoCreacion).'", 				
			"'.($this->FedTiempoModificacion).'");';					

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
	
	public function MtdEditarFacturaExportacionDetalle() {
		
			$sql = 'UPDATE tblfedfacturaexportaciondetalle SET
			FedTipo = "'.($this->FedTipo).'",
			FedCantidad = '.($this->FedCantidad).',
			FedDescripcion = "'.addslashes($this->FedDescripcion).'",
			FedUnidadMedida = "'.addslashes($this->FedUnidadMedida).'",
			FedPrecio = '.($this->FedPrecio).',
			FedImporte = '.($this->FedImporte).',
			FedTiempoModificacion = "'.($this->FedTiempoModificacion).'"
			WHERE FedId = "'.($this->FedId).'";';
					
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