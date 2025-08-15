<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaDebitoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaDebitoDetalle {

    public $NddId;
    public $NdbId;
	public $NdtId;
	public $NddDescripcion;
	public $NddCantidad;	
	public $NddPrecio;
	public $NddImporte;
	public $NddEstado;
	public $NddTiempoCreacion;
	public $NddTiempoModificacion;
    public $NddEliminado;

    	public $InsMysql;
	
	// Propiedades adicionales para evitar warnings
	public $NddCodigo;
	public $NddUnidadMedida;
	public $NddValorVenta;
	public $NddImpuesto;
	public $NddImpuestoSelectivo;
	public $NddDescuento;
	public $NddGratuito;
	public $NddExonerado;
	public $NddIncluyeSelectivo;
	public $NddValorVentaUnitario;
	public $NddTiempoCreacionFormateado;
	public $NddTiempoModificacionFormateado;
	public $NddEstadoDescripcion;
	public $NddEstadoIcono;

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

	private function MtdGenerarNotaDebitoDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(NddId,5),unsigned)) AS "MAXIMO"
			FROM tblnddnotadebitodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->NddId = "NDD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->NddId = "NDD-".$fila['MAXIMO'];					
			}
			
					
		}
		
    public function MtdObtenerNotaDebitoDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NddId',$oSentido = 'Desc',$oEliminado=1,$oPaginacion = '0,10',$oNotaDebito=NULL,$oTalonario=NULL) {

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
		
		if(!empty($oNotaDebito) and !empty($oTalonario)){
			$ncredito = ' AND ndd.NdbId="'.$oNotaDebito.'" AND ndd.NdtId = "'.$oTalonario.'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ndd.NddId,
				
				ndd.NddCodigo,
				ndd.NddDescripcion,
				ndd.NddUnidadMedida,
				
                ndd.NddCantidad,
				ndd.NddPrecio,
				ndd.NddImporte,
				ndd.NddDescuento,
				
				(ndd.NddValorVenta/ndd.NddCantidad) AS NddValorVentaUnitario,
				ndd.NddValorVenta,
				ndd.NddImpuesto,
				ndd.NddImpuestoSelectivo,
				
				ndd.NddGratuito,
				ndd.NddExonerado,
				ndd.NddIncluyeSelectivo,
				
				DATE_FORMAT(ndd.NddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNddTiempoCreacion",
	        	DATE_FORMAT(ndd.NddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNddTiempoModificacion"

				FROM tblnddnotadebitodetalle ndd

				WHERE 1 = 1 '.$ncredito.$filtrar.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaDebitoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$NotaDebitoDetalle = new $InsNotaDebitoDetalle();
                    $NotaDebitoDetalle->NddId = $fila['NddId'];
               
					$NotaDebitoDetalle->NddCodigo = (($fila['NddCodigo']));	
					$NotaDebitoDetalle->NddDescripcion = (($fila['NddDescripcion']));	
					$NotaDebitoDetalle->NddUnidadMedida = $fila['NddUnidadMedida'];
					
                    $NotaDebitoDetalle->NddPrecio = $fila['NddPrecio'];
					$NotaDebitoDetalle->NddCantidad = $fila['NddCantidad'];
					$NotaDebitoDetalle->NddImporte = $fila['NddImporte'];	
					$NotaDebitoDetalle->NddValorVentaUnitario = $fila['NddValorVentaUnitario'];	
					
					$NotaDebitoDetalle->NddValorVenta = $fila['NddValorVenta'];	
					$NotaDebitoDetalle->NddImpuesto = $fila['NddImpuesto'];	
					$NotaDebitoDetalle->NddImpuestoSelectivo = $fila['NddImpuestoSelectivo'];	
					$NotaDebitoDetalle->NddDescuento = $fila['NddDescuento'];	
					
					$NotaDebitoDetalle->NddGratuito = $fila['NddGratuito'];	
					$NotaDebitoDetalle->NddExonerado = $fila['NddExonerado'];
						
					$NotaDebitoDetalle->NddEstado = $fila['NddEstado'];
					$NotaDebitoDetalle->NddTiempoCreacion = $fila['NNddTiempoCreacion'];  
					$NotaDebitoDetalle->NddTiempoModificacion = $fila['NNddTiempoModificacion']; 
									 
                    $NotaDebitoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $NotaDebitoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	//Accion eliminar	 
	
	public function MtdEliminarNotaDebitoDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' NddId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (NddId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (NddId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblnddnotadebitodetalle 
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
	
	
	public function MtdRegistrarNotaDebitoDetalle() {
	
			$this->MtdGenerarNotaDebitoDetalleId();
		
			$sql = 'INSERT INTO tblnddnotadebitodetalle (
			NddId,
			NdbId, 
			NdtId,
			
			NddCantidad,
			
			NddCodigo,
			NddDescripcion,
			NddUnidadMedida,
			
			NddPrecio,
			NddImporte,
			
			NddValorVenta,
			NddImpuesto,
			NddImpuestoSelectivo,
			NddDescuento,
			
			NddGratuito,
			NddExonerado,
			NddIncluyeSelectivo,
			
			NddTiempoCreacion,			
			NddTiempoModificacion) 
			VALUES (
			"'.($this->NddId).'", 
			"'.($this->NdbId).'", 
			"'.($this->NdtId).'", 
			
			'.($this->NddCantidad).',
			
			"'.($this->NddCodigo).'",	
			"'.($this->NddDescripcion).'",
			"'.($this->NddUnidadMedida).'",
			
			'.($this->NddPrecio).',
			'.($this->NddImporte).',
			
			'.($this->NddValorVenta).',
			'.($this->NddImpuesto).',
			'.($this->NddImpuestoSelectivo).',
			'.($this->NddDescuento).',
			
			'.($this->NddGratuito).',
			'.($this->NddExonerado).',
			'.($this->NddIncluyeSelectivo).',
			
			"'.($this->NddTiempoCreacion).'", 				
			"'.($this->NddTiempoModificacion).'");';					

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
	
	public function MtdEditarNotaDebitoDetalle() {
		
			
			$sql = 'UPDATE tblnddnotadebitodetalle SET
			
			 NddCantidad = '.($this->NddCantidad).',
			 NddCodigo = "'.($this->NddCodigo).'",
			 NddDescripcion = "'.($this->NddDescripcion).'",
			 NddUnidadMedida = "'.($this->NddUnidadMedida).'",
			 
			 NddPrecio = '.($this->NddPrecio).',
			 NddImporte = '.($this->NddImporte).',
			 
			 NddValorVenta = '.($this->NddValorVenta).',
			 NddImpuesto = '.($this->NddImpuesto).',
			 NddImpuestoSelectivo = '.($this->NddImpuestoSelectivo).',
			 NddDescuento = '.($this->NddDescuento).',
			 
			 NddGratuito = '.($this->NddGratuito).',
			 NddExonerado = '.($this->NddExonerado).',
			 NddIncluyeSelectivo = '.($this->NddIncluyeSelectivo).',
			 
			 NddTiempoModificacion = "'.($this->NddTiempoModificacion).'"
			 WHERE NddId = "'.($this->NddId).'";';
					
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