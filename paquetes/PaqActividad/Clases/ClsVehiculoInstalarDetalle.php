<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculoInstalarDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculoInstalarDetalle {

    public $VsdId;
	public $VisId;
    public $ProId;
	public $VsdEstado;
    public $VsdTiempoCreacion;
    public $VsdTiempoModificacion;
    public $VsdEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	public function MtdGenerarVehiculoInstalarDetalleId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VsdId,5),unsigned)) AS "MAXIMO"
			FROM tblvsdvehiculoinstalardetalle';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VsdId ="VSD-10000";
			}else{
				$fila['MAXIMO']++;
				$this->VsdId = "VSD-".$fila['MAXIMO'];					
			}		
					
		}
		
    public function MtdObtenerVehiculoInstalarDetalle(){

        $sql = 'SELECT 
        vsd.VsdId,
		vsd.VisId,
        vsd.ProId,
		
		vsd.VsdCantidad,
		vsd.UmeId,
		vsd.VsdObservacion,
		
		vsd.VsdEstado,
		DATE_FORMAT(vsd.VsdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVsdTiempoCreacion",
        DATE_FORMAT(vsd.VsdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVsdTiempoModificacion",
		
		pro.ProNombre,
		
		ume.UmeNombre
		
        FROM tblvsdvehiculoinstalardetalle vsd
			
			LEFT JOIN tblproproducto pro
			ON vsd.ProId = pro.ProId
				LEFT JOIN tblumeunidadmedida ume
				ON vsd.UmeId = ume.UmeId
						
        WHERE vsd.VsdId = "'.$this->VsdId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VsdId = $fila['VsdId'];
			$this->VisId = $fila['VisId'];
			$this->ProId = $fila['ProId'];
			
			$this->VsdCantidad = $fila['VsdCantidad'];
			$this->UmeId = $fila['UmeId'];
			$this->VsdObservacion = $fila['VsdObservacion'];

			$this->VsdEstado = $fila['VsdEstado'];
			$this->VsdTiempoCreacion = $fila['NVsdTiempoCreacion'];
			$this->VsdTiempoModificacion = $fila['NVsdTiempoModificacion']; 
						
			$this->ProNombre = $fila['ProNombre']; 
			
			$this->UmeNombre = $fila['UmeNombre']; 
		
		
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerVehiculoInstalarDetalles($oCampo=NULL,$oFiltro=NULL,$oOrden = 'VsdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoInstalar=NULL,$oProducto=NULL) {

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
		
		
		if(!empty($oVehiculoInstalar)){
			$vingreso = ' AND vsd.VisId = "'.($oVehiculoInstalar).'"';
		}
		
		if(!empty($oProducto)){
			$cliente = ' AND vsd.ProId = "'.($oProducto).'"';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				vsd.VsdId,
				vsd.VisId,
				vsd.ProId,
				
				vsd.VsdCantidad,
				vsd.UmeId,
				vsd.VsdObservacion,
		
				vsd.VsdEstado,
				DATE_FORMAT(vsd.VsdTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVsdTiempoCreacion",
                DATE_FORMAT(vsd.VsdTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVsdTiempoModificacion",
				
				pro.ProNombre,
				pro.ProCodigoOriginal,
				pro.ProCodigoAlternativo,
				
				pro.RtiId,
				
				ume.UmeNombre
								
				FROM tblvsdvehiculoinstalardetalle vsd
					LEFT JOIN tblproproducto pro
					ON vsd.ProId = pro.ProId
						LEFT JOIN tblumeunidadmedida ume
						ON vsd.UmeId = ume.UmeId
					
				WHERE  1 = 1 '.$filtrar.$vingreso.$cliente.$orden.$paginacion;
	
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculoInstalarDetalle = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$VehiculoInstalarDetalle = new $InsVehiculoInstalarDetalle();
                    $VehiculoInstalarDetalle->VsdId = $fila['VsdId'];
					$VehiculoInstalarDetalle->VisId = $fila['VisId'];
                    $VehiculoInstalarDetalle->ProId = $fila['ProId'];
					
					
					$VehiculoInstalarDetalle->VsdCantidad = $fila['VsdCantidad'];
					$VehiculoInstalarDetalle->UmeId = $fila['UmeId'];
					$VehiculoInstalarDetalle->VsdObservacion = $fila['VsdObservacion'];
					
					$VehiculoInstalarDetalle->VsdEstado = $fila['VsdEstado'];
					
                    $VehiculoInstalarDetalle->VsdTiempoCreacion = $fila['NVsdTiempoCreacion'];
					$VehiculoInstalarDetalle->VsdTiempoModificacion = $fila['NVsdTiempoModificacion'];
					
				 $VehiculoInstalarDetalle->ProNombre = $fila['ProNombre'];
				  $VehiculoInstalarDetalle->ProCodigoOriginal = $fila['ProCodigoOriginal'];
				  $VehiculoInstalarDetalle->ProCodigoAlternativo = $fila['ProCodigoAlternativo'];
				 
				 
				 $VehiculoInstalarDetalle->UmeNombre = $fila['UmeNombre'];
				 
				  $VehiculoInstalarDetalle->RtiId = $fila['RtiId'];
				 
			
				
					switch($VehiculoInstalarDetalle->EinEstado){
						
						case 1:
							$VehiculoInstalarDetalle->EinEstadoDescripcion = "Activo";
						break;
						
						case 2:
							$VehiculoInstalarDetalle->EinEstadoDescripcion = "Inactivo";
						break;
					}
					
					$VehiculoInstalarDetalle->InsMysql = NULL;      
					$Respuesta['Datos'][]= $VehiculoInstalarDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			

			
			return $Respuesta;			
		}
		
		


	
	//Accion eliminar	 
	
	public function MtdEliminarVehiculoInstalarDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
		if(!count($elementos)){
			$eliminar .= ' VsdId = "'.($oElementos).'"';
		}else{
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VsdId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VsdId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		}
		
			$sql = 'DELETE FROM tblvsdvehiculoinstalardetalle WHERE '.$eliminar;
			
		
			
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
	
	
	public function MtdRegistrarVehiculoInstalarDetalle() {
	
		$this->MtdGenerarVehiculoInstalarDetalleId();
			
			$sql = 'INSERT INTO tblvsdvehiculoinstalardetalle (
				VsdId,
				VisId,
				ProId, 
				
				VsdCantidad,
				UmeId,
				VsdObservacion,				
				
				VsdEstado,
				VsdTiempoCreacion,
				VsdTiempoModificacion) 
				VALUES (
				"'.($this->VsdId).'", 
				"'.($this->VisId).'", 
				"'.($this->ProId).'", 
				
				'.($this->VsdCantidad).', 
				"'.($this->UmeId).'", 
				"'.($this->VsdObservacion).'", 
			
				'.($this->VsdEstado).', 
				"'.($this->VsdTiempoCreacion).'", 
				"'.($this->VsdTiempoModificacion).'");';	
				
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
	
	
		public function MtdEditarVehiculoInstalarDetalle() {
		
			$sql = 'UPDATE tblvsdvehiculoinstalardetalle SET 
				VisId = "'.($this->VisId).'",
			
				
				VsdCantidad = '.($this->VsdCantidad).',
				UmeId = "'.($this->UmeId).'",
				VsdObservacion = "'.($this->VsdObservacion).'",
				
				VsdEstado = '.($this->VsdEstado).',
				 
				VsdTiempoModificacion = "'.($this->VsdTiempoModificacion).'"
				WHERE VsdId = "'.($this->VsdId).'";';
				 
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
		
		


	public function MtdEditarVehiculoIngresoDato($oCampo,$oDato,$oVehiculoInstalarId) {
	
		global $Resultado;
	
		$sql = 'UPDATE tblvsdvehiculoinstalardetalle SET 
		'.$oCampo.' = "'.($oDato).'"
		WHERE VsdId = "'.($oVehiculoInstalarId).'";';
		
		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

		if(!$resultado) {							
			$error = true;
		} 

		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						

	}	
	

		
}
?>