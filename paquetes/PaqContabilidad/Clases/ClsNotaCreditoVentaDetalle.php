<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNotaCreditoCompraDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsNotaCreditoCompraDetalle {

    public $NodId;
    public $NccId;

	public $ProId;
	public $UmeId;
	
	public $AmdId;
	
	public $NodCantidad;	
	public $NodPrecio;
	public $NodImporte;	
	public $NodEstado;
	public $NodTiempoCreacion;
	public $NodTiempoModificacion;
    public $NodEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarNotaCreditoCompraDetalleId() {
	
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AmdId,5),unsigned)) AS "MAXIMO"
			FROM tblamdalmacenmovimientodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->NodId = "NOD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->NodId = "NOD-".$fila['MAXIMO'];					
			}
			
					
		}
		

    public function MtdObtenerNotaCreditoCompraDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'NodId',$oSentido = 'Desc',$oPaginacion = '0,10',$oNotaCreditoCompra=NULL,$oAlmacenMovimientoDetalleIdOrigen=NULL,$oNotaCreditoCompraEstado=NULL) {

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
		
		if(!empty($oNotaCreditoCompra)){
			$boleta = ' AND amd.AmoId = "'.$oNotaCreditoCompra.'" ';
		}
		
		if(!empty($oAlmacenMovimientoDetalleIdOrigen)){
			$amdetalle = ' AND amd.AmdIdOrigen = "'.$oAlmacenMovimientoDetalleIdOrigen.'" ';
		}	
		
		if(!empty($oNotaCreditoCompraEstado)){
			$bestado = ' AND amo.AmoEstado = '.$oNotaCreditoCompraEstado.' ';
		}
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				amd.AmdId AS "NodId",
				amd.AmoId AS "NccId",
				
				amd.AmdIdOrigen,
				
				amd.ProId,
				amd.UmeId,
				
                amd.AmdCantidad AS "NodCantidad",
				amd.AmdCantidadReal AS "NodCantidadReal",
				
				amd.AmdCosto AS "NodPrecio",
				amd.AmdImporte AS "NodImporte",
				amd.AmdEstado AS "NodEstado",
				DATE_FORMAT(amd.AmdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NNodTiempoCreacion",
	        	DATE_FORMAT(amd.AmdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NNodTiempoModificacion",

				pro.ProNombre,
				pro.ProCodigoOriginal,
				pro.UmeId AS UmeIdOrigen,
				pro.RtiId,
				
				ume.UmeNombre,
				ume.UmeAbreviacion
				
				FROM tblamdalmacenmovimientodetalle amd

					LEFT JOIN tblproproducto pro
					ON amd.ProId = pro.ProId

						LEFT JOIN tblumeunidadmedida ume
						ON pro.UmeId = ume.UmeId

							LEFT JOIN tblamoalmacenmovimiento amo
							ON (amd.AmoId = amo.AmoId)

				WHERE 1 = 1'.$boleta.$filtrar.$amdetalle.$bestado.$vddetale.$orden.$paginacion;
								
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsNotaCreditoCompraDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$NotaCreditoCompraDetalle = new $InsNotaCreditoCompraDetalle();
                    $NotaCreditoCompraDetalle->NodId = $fila['NodId'];
					$NotaCreditoCompraDetalle->NccId = $fila['NccId']; 

					$NotaCreditoCompraDetalle->AmdIdOrigen = $fila['AmdIdOrigen'];

					$NotaCreditoCompraDetalle->ProId = $fila['ProId'];
					$NotaCreditoCompraDetalle->UmeId = $fila['UmeId'];

                    $NotaCreditoCompraDetalle->NodPrecio = $fila['NodPrecio'];
					$NotaCreditoCompraDetalle->NodCantidad = $fila['NodCantidad'];
					$NotaCreditoCompraDetalle->NodCantidadReal = $fila['NodCantidadReal'];
					
					$NotaCreditoCompraDetalle->NodImporte = $fila['NodImporte'];
					
					$NotaCreditoCompraDetalle->NodEstado = $fila['NodEstado'];					
					$NotaCreditoCompraDetalle->NodTiempoCreacion = $fila['NNodTiempoCreacion'];  
					$NotaCreditoCompraDetalle->NodTiempoModificacion = $fila['NNodTiempoModificacion']; 

					$NotaCreditoCompraDetalle->ProNombre = $fila['ProNombre']; 
					$NotaCreditoCompraDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal']; 
					$NotaCreditoCompraDetalle->UmeIdOrigen = $fila['UmeIdOrigen']; 
					$NotaCreditoCompraDetalle->RtiId = $fila['RtiId']; 
					
					$NotaCreditoCompraDetalle->UmeNombre = $fila['UmeNombre']; 
					$NotaCreditoCompraDetalle->UmeAbreviatura = $fila['UmeAbreviatura']; 
					
                    $NotaCreditoCompraDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $NotaCreditoCompraDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	
	//Accion eliminar	 
	
	public function MtdEliminarNotaCreditoCompraDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (AmdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AmdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM tblamdalmacenmovimientodetalle 
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
	
	
	public function MtdRegistrarNotaCreditoCompraDetalle() {

			$this->MtdGenerarNotaCreditoCompraDetalleId();

			$sql = 'INSERT INTO tblamdalmacenmovimientodetalle (
			AmdId,
			AmoId, 

			AmdIdOrigen,

			ProId,
			UmeId,			

			AmdCantidad,	
			AmdCantidadReal,		
			
			AmdCosto,
			AmdImporte,
			
			AmdEstado,
			AmdTiempoCreacion,
			AmdTiempoModificacion
			) 
			VALUES (
			"'.($this->NodId).'", 
			"'.($this->NccId).'", 
			
			'.(empty($this->AmdIdOrigen)?'NULL, ':'"'.$this->AmdIdOrigen.'",').'
			
			"'.($this->ProId).'",
			"'.($this->UmeId).'",
			
			'.($this->NodCantidad).',
			'.($this->NodCantidadReal).',
			
			'.($this->NodPrecio).',
			'.($this->NodImporte).',
			
			'.($this->NodEstado).',
			"'.($this->NodTiempoCreacion).'", 				
			"'.($this->NodTiempoModificacion).'");';					

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
	
	public function MtdEditarNotaCreditoCompraDetalle() {
		
		$sql = 'UPDATE tblamdalmacenmovimientodetalle SET

		ProId = "'.($this->ProId).'",
		UmeId = "'.($this->UmeId).'",

		AmdCantidad = '.($this->NodCantidad).',
		AmdCantidadReal = '.($this->NodCantidadReal).',
	
		AmdCosto = '.($this->NodPrecio).',
		AmdImporte = '.($this->NodImporte).',
		AmdEstado = '.($this->NodEstado).',
		
		AmdTiempoModificacion = "'.($this->NodTiempoModificacion).'"
		WHERE AmdId = "'.($this->NodId).'";';
				
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