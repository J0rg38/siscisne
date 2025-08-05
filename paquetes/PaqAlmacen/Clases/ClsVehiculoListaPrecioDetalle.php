<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoListaPrecioDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoListaPrecioDetalle {

    public $VldId;
	public $VlpId;
	public $VveId;

	public $VlpDescripcion;	
    public $VldFuente;
	public $VldCosto;
	public $VldPrecioCierre;
	public $VldPrecioLista;
	
	public $VldBonoGM;
	public $VldBonoDealer;
	public $VldDescuentoGerencia;
		
	public $VldEstado;
    public $VldTiempoCreacion;
    public $VldTiempoModificacion;
    public $VldEliminado;

	public $VlpAno;
	public $VlpMes;
	
	public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarVehiculoListaPrecioDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VldId,5),unsigned)) AS "MAXIMO"
			FROM tblvldvehiculolistapreciodetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VldId ="VLD-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VldId = "VLD-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerVehiculoListaPrecioDetalle(){

        $sql = 'SELECT 
        vld.VldId,
		vld.VlpId,
		vld.VveId,
		
		vld.VldFuente,
		vld.VldCosto,
		vld.VldPrecioCierre,
		vld.VldPrecioLista,
		
		vdl.VldBonoGM,
		vld.VldBonoDealer,
		vdl.VldDescuentoGerencia,
		
		vld.VldEstado,
		DATE_FORMAT(vld.VldTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVldTiempoCreacion",
        DATE_FORMAT(vld.VldTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVldTiempoModificacion"
        FROM tblvldvehiculolistapreciodetalle vld
        WHERE vld.VldId = "'.$this->VldId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VldId = $fila['VldId'];
			$this->VlpId = $fila['VlpId'];
			$this->VveId = $fila['VveId'];
			
			$this->VldFuente = $fila['VldFuente'];
			$this->VldCosto = $fila['VldCosto'];
			$this->VldPrecioCierre = $fila['VldPrecioCierre'];
			$this->VldPrecioLista = $fila['VldPrecioLista'];
			
			$this->VldBonoGM = $fila['VldBonoGM'];
			$this->VldBonoDealer = $fila['VldBonoDealer'];
			$this->VldDescuentoGerencia = $fila['VldDescuentoGerencia'];

			$this->VldEstado = $fila['VldEstado'];
			$this->VldTiempoCreacion = $fila['NVldTiempoCreacion'];
			$this->VldTiempoModificacion = $fila['NVldTiempoModificacion']; 
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;

    }

    public function MtdObtenerVehiculoListaPrecioDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VldId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoListaPrecio=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL,$oPrecioEstricto=false,$oVehiculoModelo=NULL,$oVehiculoMarca=NULL) {

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

		if(!empty($oVehiculoListaPrecio)){
			$vlprecio = ' AND vld.VlpId = "'.($oVehiculoListaPrecio).'"';
		}

		if(!empty($oVehiculoVersion)){
			$vversion = ' AND vld.VveId = "'.($oVehiculoVersion).'"';
		}

		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND vlp.VlpAnoFabricacion = "'.($oAnoFabricacion).'"';
		}
		
		if(($oPrecioEstricto)){
			$pestricto = ' AND  ( vld.VldPrecioCierre > 0 OR vld.VldPrecioLista > 0 ) ';
		}

		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.($oVehiculoMarca).'"';
		}
	
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.($oVehiculoModelo).'"';
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vld.VldId,
				vld.VlpId,
				vld.VveId,
				
				vld.VldFuente,
				vld.VldCosto,
				vld.VldPrecioCierre,
				vld.VldPrecioLista,
				
				vld.VldBonoGM,
				vld.VldBonoDealer,
				vld.VldDescuentoGerencia,
		
				vld.VldEstado,
				DATE_FORMAT(vld.VldTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVldTiempoCreacion",
                DATE_FORMAT(vld.VldTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVldTiempoModificacion",
				
				
				vve.VveFoto,
				
				vmo.VmaId,
				
				vve.VmoId,
				vve.VveNombre,
				vmo.VmoNombre,
				vma.VmaNombre,
				
				vlp.VlpAno,
				vlp.VlpMes,
				vlp.VlpAnoFabricacion,
				
				vlp.VlpTipoCambio,
				vlp.MonId,
				
				DATE_FORMAT(vlp.VlpFechaVigencia, "%d/%m/%Y") AS "NVlpFechaVigencia"
				
				FROM tblvldvehiculolistapreciodetalle vld
					
					LEFT JOIN tblvlpvehiculolistaprecio vlp
					ON vld.VlpId = vlp.VlpId
					
					LEFT JOIN tblvvevehiculoversion vve
					ON vld.VveId = vve.VveId
						
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
						
							LEFT JOIN tblvmavehiculomarca vma
							ON vmo.VmaId = vma.VmaId
				
				WHERE 1 = 1'.$filtrar.$vmarca.$vmodelo.$vlprecio.$vversion.$afabricacion.$pestricto.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsVehiculoListaPrecioDetalle = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					
					$VehiculoListaPrecioDetalle = new $InsVehiculoListaPrecioDetalle();
					$VehiculoListaPrecioDetalle->VldId = $fila['VldId'];
					$VehiculoListaPrecioDetalle->VlpId = $fila['VlpId'];
					$VehiculoListaPrecioDetalle->VveId = $fila['VveId'];
					
					$VehiculoListaPrecioDetalle->VldFuente = $fila['VldFuente'];
					$VehiculoListaPrecioDetalle->VldCosto = $fila['VldCosto'];
					$VehiculoListaPrecioDetalle->VldPrecioCierre = $fila['VldPrecioCierre'];
					$VehiculoListaPrecioDetalle->VldPrecioLista = $fila['VldPrecioLista'];
					
					$VehiculoListaPrecioDetalle->VldBonoGM = $fila['VldBonoGM'];
					$VehiculoListaPrecioDetalle->VldBonoDealer = $fila['VldBonoDealer'];
					$VehiculoListaPrecioDetalle->VldDescuentoGerencia = $fila['VldDescuentoGerencia'];

					$VehiculoListaPrecioDetalle->VldEstado = $fila['VldEstado'];
                    $VehiculoListaPrecioDetalle->VldTiempoCreacion = $fila['NVldTiempoCreacion'];
					$VehiculoListaPrecioDetalle->VldTiempoModificacion = $fila['NVldTiempoModificacion'];
	
					$VehiculoListaPrecioDetalle->VmoId = $fila['VmoId'];
					$VehiculoListaPrecioDetalle->VmaId = $fila['VmaId'];
					
					$VehiculoListaPrecioDetalle->VveFoto = $fila['VveFoto'];
					$VehiculoListaPrecioDetalle->VveNombre = $fila['VveNombre'];
					$VehiculoListaPrecioDetalle->VmoNombre = $fila['VmoNombre'];
					$VehiculoListaPrecioDetalle->VmaNombre = $fila['VmaNombre'];
					
					$VehiculoListaPrecioDetalle->VlpAno = $fila['VlpAno'];
					$VehiculoListaPrecioDetalle->VlpMes = $fila['VlpMes'];
					$VehiculoListaPrecioDetalle->VlpAnoFabricacion = $fila['VlpAnoFabricacion'];
					
					$VehiculoListaPrecioDetalle->VlpTipoCambio = $fila['VlpTipoCambio'];
					
					$VehiculoListaPrecioDetalle->MonId = $fila['MonId'];
					
					$VehiculoListaPrecioDetalle->VlpFechaVigencia = $fila['NVlpFechaVigencia'];
					
					
					
					
					
					$Respuesta['Datos'][]= $VehiculoListaPrecioDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoListaPrecioDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VldId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VldId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblvldvehiculolistapreciodetalle WHERE '.$eliminar;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}							
	}
	
	
	public function MtdRegistrarVehiculoListaPrecioDetalle() {
	
		$this->MtdGenerarVehiculoListaPrecioDetalleId();
			
		
			$sql = 'INSERT INTO tblvldvehiculolistapreciodetalle (
				VldId,
				VlpId,
				VveId,
				
				VldFuente,
				VldCosto,
				VldPrecioCierre,
				VldPrecioLista,
				
				VldBonoGM,
				VldBonoDealer,
				VldDescuentoGerencia,
			
				VldEstado,
				VldTiempoCreacion,
				VldTiempoModificacion
				) 
				VALUES (
				"'.($this->VldId).'", 
				"'.($this->VlpId).'", 
				"'.($this->VveId).'", 				

				"'.($this->VldFuente).'", 
				'.($this->VldCosto).', 
				'.($this->VldPrecioCierre).', 
				'.($this->VldPrecioLista).', 
				
				'.($this->VldBonoGM).',
				'.($this->VldBonoDealer).',
				'.($this->VldDescuentoGerencia).',

				'.($this->VldEstado).', 
				"'.($this->VldTiempoCreacion).'", 
				"'.($this->VldTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoListaPrecioDetalle() {
					
		$sql = 'UPDATE tblvldvehiculolistapreciodetalle SET 
				
				VveId = "'.($this->VveId).'",								

				VldFuente = "'.($this->VldFuente).'",
				VldCosto = '.($this->VldCosto).',
				VldPrecioCierre = '.($this->VldPrecioCierre).',
				VldPrecioLista = '.($this->VldPrecioLista).',
				
				VldBonoGM = '.($this->VldBonoGM).',
				VldBonoDealer = '.($this->VldBonoDealer).',
				VldDescuentoGerencia = '.($this->VldDescuentoGerencia).',
				

				VldEstado = '.($this->VldEstado).',
				VldTiempoModificacion = "'.($this->VldTiempoModificacion).'"
				WHERE VldId = "'.($this->VldId).'";';
				 
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