<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaCreditoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaCreditoDetalle {

    public $NcdId;
    public $NcrId;
	public $NctId;
	public $NcdDescripcion;
	public $NcdCantidad;	
	public $NcdPrecio;
	public $NcdImporte;
	public $NcdEstado;
	public $NcdTiempoCreacion;
	public $NcdTiempoModificacion;
    public $NcdEliminado;

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

	private function MtdGenerarNotaCreditoDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(NcdId,5),unsigned)) AS "MAXIMO"
			FROM tblncdnotacreditodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->NcdId = "NCD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->NcdId = "NCD-".$fila['MAXIMO'];					
			}
			
					
		}
		
    public function MtdObtenerNotaCreditoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NcdId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oNotaCredito=NULL,$oTalonario=NULL) {

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
		
		if(!empty($oNotaCredito) and !empty($oTalonario)){
			$ncredito = ' AND ncd.NcrId="'.$oNotaCredito.'" AND ncd.NctId = "'.$oTalonario.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ncd.NcdId,
				
				ncd.NcdCodigo,
				ncd.NcdDescripcion,
				ncd.NcdUnidadMedida,
				
                ncd.NcdCantidad,
				ncd.NcdPrecio,
				ncd.NcdImporte,
				
				(ncd.NcdValorVenta/ncd.NcdCantidad) AS NcdValorVentaUnitario,
				ncd.NcdValorVenta,
				ncd.NcdImpuesto,
				ncd.NcdDescuento,
				
				ncd.NcdGratuito,
				ncd.NcdExonerado,
				
				DATE_FORMAT(ncd.NcdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNcdTiempoCreacion",
	        	DATE_FORMAT(ncd.NcdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNcdTiempoModificacion"

				FROM tblncdnotacreditodetalle ncd

				WHERE 1 = 1 '.$ncredito.$filtrar.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaCreditoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$NotaCreditoDetalle = new $InsNotaCreditoDetalle();
                    $NotaCreditoDetalle->NcdId = $fila['NcdId'];
               
					$NotaCreditoDetalle->NcdCodigo = (($fila['NcdCodigo']));	
					$NotaCreditoDetalle->NcdDescripcion = (($fila['NcdDescripcion']));	
					$NotaCreditoDetalle->NcdUnidadMedida = $fila['NcdUnidadMedida'];
					
                    $NotaCreditoDetalle->NcdPrecio = $fila['NcdPrecio'];
					$NotaCreditoDetalle->NcdCantidad = $fila['NcdCantidad'];
					$NotaCreditoDetalle->NcdImporte = $fila['NcdImporte'];	
					$NotaCreditoDetalle->NcdValorVentaUnitario = $fila['NcdValorVentaUnitario'];	
					
					$NotaCreditoDetalle->NcdValorVenta = $fila['NcdValorVenta'];	
					$NotaCreditoDetalle->NcdImpuesto = $fila['NcdImpuesto'];	
					$NotaCreditoDetalle->NcdDescuento = $fila['NcdDescuento'];	
					
					$NotaCreditoDetalle->NcdGratuito = $fila['NcdGratuito'];	
					$NotaCreditoDetalle->NcdExonerado = $fila['NcdExonerado'];
						
					$NotaCreditoDetalle->NcdEstado = $fila['NcdEstado'];
					$NotaCreditoDetalle->NcdTiempoCreacion = $fila['NNcdTiempoCreacion'];  
					$NotaCreditoDetalle->NcdTiempoModificacion = $fila['NNcdTiempoModificacion']; 
									 
                    $NotaCreditoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $NotaCreditoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	//Accion eliminar	 
	
	public function MtdEliminarNotaCreditoDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' NcdId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (NcdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (NcdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblncdnotacreditodetalle 
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
	
	
	public function MtdRegistrarNotaCreditoDetalle() {
	
			$this->MtdGenerarNotaCreditoDetalleId();
		
			$sql = 'INSERT INTO tblncdnotacreditodetalle (
			NcdId,
			NcrId, 
			NctId,
			
			NcdCantidad,
			
			NcdCodigo,
			NcdDescripcion,
			NcdUnidadMedida,
			
			NcdPrecio,
			NcdImporte,
			
			NcdValorVenta,
			NcdImpuesto,
			NcdDescuento,
			
			NcdGratuito,
			NcdExonerado,
			
			NcdTiempoCreacion,			
			NcdTiempoModificacion) 
			VALUES (
			"'.($this->NcdId).'", 
			"'.($this->NcrId).'", 
			"'.($this->NctId).'", 
			
			'.($this->NcdCantidad).',
			
			"'.($this->NcdCodigo).'",	
			"'.($this->NcdDescripcion).'",
			"'.($this->NcdUnidadMedida).'",
			
			'.($this->NcdPrecio).',
			'.($this->NcdImporte).',
			
			'.($this->NcdValorVenta).',
			'.($this->NcdImpuesto).',
			'.($this->NcdDescuento).',
			
			'.($this->NcdGratuito).',
			'.($this->NcdExonerado).',
			
			"'.($this->NcdTiempoCreacion).'", 				
			"'.($this->NcdTiempoModificacion).'");';					

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
	
	public function MtdEditarNotaCreditoDetalle() {
		
			
			$sql = 'UPDATE tblncdnotacreditodetalle SET
			
			 NcdCantidad = '.($this->NcdCantidad).',
			 NcdCodigo = "'.($this->NcdCodigo).'",
			 NcdDescripcion = "'.($this->NcdDescripcion).'",
			 NcdUnidadMedida = "'.($this->NcdUnidadMedida).'",
			 
			 NcdPrecio = '.($this->NcdPrecio).',
			 NcdImporte = '.($this->NcdImporte).',
			 
			 NcdValorVenta = '.($this->NcdValorVenta).',
			 NcdImpuesto = '.($this->NcdImpuesto).',
			 NcdDescuento = '.($this->NcdDescuento).',
			 
			 NcdGratuito = '.($this->NcdGratuito).',
			 NcdExonerado = '.($this->NcdExonerado).',
			 
			 NcdTiempoModificacion = "'.($this->NcdTiempoModificacion).'"
			 WHERE NcdId = "'.($this->NcdId).'";';
					
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