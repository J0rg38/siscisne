<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoProformaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoProformaDetalle {

    public $VpdId;
	public $VprId;
	public $EinId;

	public $VpdEstado;
    public $VpdTiempoCreacion;
    public $VpdTiempoModificacion;
    public $VpdEliminado;

	public $InsMysql;

	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	

	public function MtdGenerarVehiculoProformaDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VpdId,5),unsigned)) AS "MAXIMO"
			FROM tblvpdvehiculoproformadetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VpdId ="VPD-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VpdId = "VPD-".$fila['MAXIMO'];					
			}		
			
					
		}
		
    public function MtdObtenerVehiculoProformaDetalle(){

        $sql = 'SELECT 
        vpd.VpdId,
		vpd.VprId,
		vpd.EinId,
		vpd.VpdCosto,
		vpd.VpdEstado,
		DATE_FORMAT(vpd.VpdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVpdTiempoCreacion",
        DATE_FORMAT(vpd.VpdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVpdTiempoModificacion"
        FROM tblvpdvehiculoproformadetalle vpd
        WHERE vpd.VpdId = "'.$this->VpdId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VpdId = $fila['VpdId'];
			$this->VprId = $fila['VprId'];
			$this->EinId = $fila['EinId'];
			$this->VpdCosto = $fila['VpdCosto'];
			$this->VpdEstado = $fila['VpdEstado'];
			$this->VpdTiempoCreacion = $fila['NVpdTiempoCreacion'];
			$this->VpdTiempoModificacion = $fila['NVpdTiempoModificacion']; 
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
		return $Respuesta;

    }

    public function MtdObtenerVehiculoProformaDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VpdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoProforma=NULL,$oVehiculoVersion=NULL,$oAnoFabricacion=NULL) {

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

		if(!empty($oVehiculoProforma)){
			$vlprecio = ' AND vpd.VprId = "'.($oVehiculoProforma).'"';
		}

		if(!empty($oVehiculoVersion)){
			$vversion = ' AND vpd.EinId = "'.($oVehiculoVersion).'"';
		}

		if(!empty($oAnoFabricacion)){
			$afabricacion = ' AND vpr.VprAnoFabricacion = "'.($oAnoFabricacion).'"';
		}
	

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vpd.VpdId,
				vpd.VprId,
				vpd.EinId,
				
				vpd.VpdCosto,
				vpd.VpdEstado,
				DATE_FORMAT(vpd.VpdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVpdTiempoCreacion",
                DATE_FORMAT(vpd.VpdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVpdTiempoModificacion",
				
				
				vve.VmoId,
				vmo.VmaId,
				ein.VveId,
				
				vve.VveNombre,
				vmo.VmoNombre,
				vma.VmaNombre,
				
				YEAR(vpr.VprFecha) AS VprAno,
				MONTH(vpr.VprFecha) AS VprMes,
				
				vpr.VprTipoCambio,
				vpr.MonId,
				
				ein.EinVIN,
				ein.EinColor,
				
				ein.EinAnoFabricacion,
				ein.EinAnoModelo,
				ein.EinNumeroMotor
				
				FROM tblvpdvehiculoproformadetalle vpd
					
					LEFT JOIN tblvprvehiculoproforma vpr
					ON vpd.VprId = vpr.VprId
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON vpd.EinId = ein.EinId
						
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
						
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
							
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
				
				WHERE 1 = 1'.$filtrar.$vlprecio.$vversion.$afabricacion.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();

            $InsVehiculoProformaDetalle = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					
					$VehiculoProformaDetalle = new $InsVehiculoProformaDetalle();
					$VehiculoProformaDetalle->VpdId = $fila['VpdId'];
					$VehiculoProformaDetalle->VprId = $fila['VprId'];
					$VehiculoProformaDetalle->EinId = $fila['EinId'];

					$VehiculoProformaDetalle->VpdCosto = $fila['VpdCosto'];
				
					$VehiculoProformaDetalle->VpdEstado = $fila['VpdEstado'];
                    $VehiculoProformaDetalle->VpdTiempoCreacion = $fila['NVpdTiempoCreacion'];
					$VehiculoProformaDetalle->VpdTiempoModificacion = $fila['NVpdTiempoModificacion'];
	
					$VehiculoProformaDetalle->VmoId = $fila['VmoId'];
					$VehiculoProformaDetalle->VmaId = $fila['VmaId'];
					$VehiculoProformaDetalle->VveId = $fila['VveId'];

					$VehiculoProformaDetalle->VveNombre = $fila['VveNombre'];
					$VehiculoProformaDetalle->VmoNombre = $fila['VmoNombre'];
					$VehiculoProformaDetalle->VmaNombre = $fila['VmaNombre'];
					
					$VehiculoProformaDetalle->VprAno = $fila['VprAno'];
					$VehiculoProformaDetalle->VprMes = $fila['VprMes'];
	
					$VehiculoProformaDetalle->VprTipoCambio = $fila['VprTipoCambio'];
					
					
					$VehiculoProformaDetalle->EinVIN = $fila['EinVIN'];
					$VehiculoProformaDetalle->EinColor = $fila['EinColor'];
					
					$VehiculoProformaDetalle->EinAnoFabricacion = $fila['EinAnoFabricacion'];
					$VehiculoProformaDetalle->EinAnoModelo = $fila['EinAnoModelo'];
					$VehiculoProformaDetalle->EinNumeroMotor = $fila['EinNumeroMotor'];

					
					$VehiculoProformaDetalle->MonId = $fila['MonId'];
					
					$Respuesta['Datos'][]= $VehiculoProformaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoProformaDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VpdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VpdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblvpdvehiculoproformadetalle WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarVehiculoProformaDetalle() {
	
		$this->MtdGenerarVehiculoProformaDetalleId();
			
		
			$sql = 'INSERT INTO tblvpdvehiculoproformadetalle (
				VpdId,
				VprId,
				EinId,
				VpdCosto,
				VpdEstado,
				VpdTiempoCreacion,
				VpdTiempoModificacion
				) 
				VALUES (
				"'.($this->VpdId).'", 
				"'.($this->VprId).'", 
				"'.($this->EinId).'", 	
				'.($this->VpdCosto).', 
				'.($this->VpdEstado).', 
				"'.($this->VpdTiempoCreacion).'", 
				"'.($this->VpdTiempoModificacion).'");';	
				
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
	
	public function MtdEditarVehiculoProformaDetalle() {
					
		$sql = 'UPDATE tblvpdvehiculoproformadetalle SET 
				
				EinId = "'.($this->EinId).'",	
				VpdCosto = '.($this->VpdCosto).',
				VpdEstado = '.($this->VpdEstado).',
				VpdTiempoModificacion = "'.($this->VpdTiempoModificacion).'"
				WHERE VpdId = "'.($this->VpdId).'";';
				 
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