<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsComprobanteRetencionDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsComprobanteRetencionDetalle {

    public $CedId;
    public $CrnId;
	public $CrtId;
	public $AmdId;
	public $FatId;
	public $CedTipoDocumento;

	public $CedNumero;
	public $CedFechaEmision;	

	public $CedTotal;	
	public $CedPorcentajeRetencion;
	public $CedRetenido;
	public $CedImpuestoSelectivo;
	public $CedIncluyeSelectivo;
	
	public $CedEstado;
	public $CedTiempoCreacion;
	public $CedTiempoModificacion;
    public $CedEliminado;

	public $OdeId;
	public $OriId;
	
	public $CrnFechaEmision;
	public $CrnTipoCambio;
	public $CrnIncluyeImpuesto;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarComprobanteRetencionDetalleId() {

	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(CedId,5),unsigned)) AS "MAXIMO"
			FROM tblcedcomprobanteretenciondetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->CedId = "CED-10000";
			}else{
				$fila['MAXIMO']++;
				$this->CedId = "CED-".$fila['MAXIMO'];					
			}
			
					
		}
		
    public function MtdObtenerComprobanteRetencionDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'CedId',$oSentido = 'Desc',$oPaginacion = '0,10',$oComprobanteRetencion=NULL,$oTalonario=NULL,$oAlmacenMovimientoDetalleId=NULL,$oComprobanteRetencionEstado=NULL,$oVentaDirectaDetalleId=NULL) {

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
		
		if(!empty($oComprobanteRetencion) and !empty($oTalonario)){
			$factura = ' AND ced.CrnId="'.$oComprobanteRetencion.'" AND ced.CrtId = "'.$oTalonario.'"';
		}
		
		if(!empty($oComprobanteRetencionEstado)){
			$festado = ' AND crn.CrnEstado = '.$oComprobanteRetencionEstado.' ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ced.CedId,
			
				ced.CedTipoDocumento,
				ced.CedSerie,
				ced.CedNumero,
				ced.CedFechaEmision,
				DATE_FORMAT(ced.CedFechaEmision, "%d/%m/%Y") AS "NCedFechaEmision",
				
                ced.CedTotal,
				ced.CedPorcentajeRetencion,
				ced.CedRetenido,
				ced.CedPagado,
				ced.CedEstado,
				DATE_FORMAT(ced.CedTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCedTiempoCreacion",
	        	DATE_FORMAT(ced.CedTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCedTiempoModificacion",
				
				crt.CrtNumero,
				
				DATE_FORMAT(crn.CrnFechaEmision, "%d/%m/%Y") AS "NCrnFechaEmision",
				crn.CrnTipoCambio
				
				FROM tblcedcomprobanteretenciondetalle ced
					LEFT JOIN tblcrncomprobanteretencion crn
					ON (ced.CrnId = crn.CrnId  AND ced.CrtId = crn.CrtId)
				
						LEFT JOIN tblcrtcomprobanteretenciontalonario crt
						ON crn.CrtId = crt.CrtId
							
				WHERE 1 = 1 '.$factura.$filtrar.$amdetalle.$festado.$vddetale.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsComprobanteRetencionDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ComprobanteRetencionDetalle = new $InsComprobanteRetencionDetalle();
                    $ComprobanteRetencionDetalle->CedId = $fila['CedId'];

					$ComprobanteRetencionDetalle->CrnId = $fila['CrnId'];
					$ComprobanteRetencionDetalle->CrtId = $fila['CrtId'];
					$ComprobanteRetencionDetalle->CedTipoDocumento = $fila['CedTipoDocumento'];

                    $ComprobanteRetencionDetalle->CedSerie = (($fila['CedSerie']));	
					$ComprobanteRetencionDetalle->CedNumero = (($fila['CedNumero']));	
					$ComprobanteRetencionDetalle->CedFechaEmision = $fila['NCedFechaEmision'];
					$ComprobanteRetencionDetalle->CedTotal = $fila['CedTotal'];
                    $ComprobanteRetencionDetalle->CedPorcentajeRetencion = $fila['CedPorcentajeRetencion'];
					$ComprobanteRetencionDetalle->CedRetenido = $fila['CedRetenido'];	
					$ComprobanteRetencionDetalle->CedPagado = $fila['CedPagado'];	
					$ComprobanteRetencionDetalle->CedEstado = $fila['CedEstado'];	
							
					$ComprobanteRetencionDetalle->CedTiempoCreacion = $fila['NCedTiempoCreacion'];  
					$ComprobanteRetencionDetalle->CedTiempoModificacion = $fila['NCedTiempoModificacion']; 
					
					$ComprobanteRetencionDetalle->CrtNumero = $fila['CrtNumero']; 
				
					
                    $ComprobanteRetencionDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ComprobanteRetencionDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		

	//Accion eliminar	 
	
	public function MtdEliminarComprobanteRetencionDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (CedId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (CedId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
			

		
			$sql = 'DELETE FROM tblcedcomprobanteretenciondetalle 
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
	
	
	public function MtdRegistrarComprobanteRetencionDetalle() {
	
			$this->MtdGenerarComprobanteRetencionDetalleId();

			
			$sql = 'INSERT INTO tblcedcomprobanteretenciondetalle (
			CedId,
			CrnId, 
			CrtId,
			
			CedTipoDocumento,
			CedSerie,
			CedNumero,
			CedFechaEmision,
			
			CedTotal,
			CedPorcentajeRetencion,
			CedRetenido,
			CedPagado,
			CedEstado,
			CedTiempoCreacion,
			CedTiempoModificacion
			) 
			VALUES (
			"'.($this->CedId).'", 
			"'.($this->CrnId).'",
			"'.($this->CrtId).'",
			
			"'.($this->CedTipoDocumento).'",
			"'.($this->CedSerie).'",
			"'.($this->CedNumero).'",			
			'.(empty($this->CedFechaEmision)?'NULL, ':'"'.$this->CedFechaEmision.'",').'
			
			'.($this->CedTotal).',
			'.($this->CedPorcentajeRetencion).',
			'.($this->CedRetenido).',
			'.($this->CedPagado).',
		
			'.($this->CedEstado).',
			"'.($this->CedTiempoCreacion).'",
			"'.($this->CedTiempoModificacion).'");';

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
	
	public function MtdEditarComprobanteRetencionDetalle() {		

			$sql = 'UPDATE tblcedcomprobanteretenciondetalle SET
			
			 CedTipoDocumento = "'.($this->CedTipoDocumento).'",
			 
			 CedSerie = "'.addslashes($this->CedSerie).'",
			 CedNumero = "'.addslashes($this->CedNumero).'",
			 CedFechaEmision = "'.addslashes($this->CedFechaEmision).'",
			 CedTotal = '.($this->CedTotal).', 
			 CedPorcentajeRetencion = '.($this->CedPorcentajeRetencion).',
			 CedRetenido = '.($this->CedRetenido).',
			 CedPagado = '.($this->CedPagado).',
			 CedEstado = '.($this->CedEstado).',
			
			 CedTiempoModificacion = "'.($this->CedTiempoModificacion).'"
			 WHERE CedId = "'.($this->CedId).'";';
					
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