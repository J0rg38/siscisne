<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenVentaVehiculoMantenimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenVentaVehiculoMantenimiento {

    public $OvmId;
	public $OvvId;
	public $OvmKilometraje;
	public $OvmEstado;
	public $OvmTiempoCreacion;
	public $OvmTiempoModificacion;
	
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

	private function MtdGenerarOrdenVentaVehiculoMantenimientoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(OvmId,5),unsigned)) AS "MAXIMO"
			FROM tblovmordenventavehiculomantenimiento';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->OvmId = "OVM-10000";
			}else{
				$fila['MAXIMO']++;
				$this->OvmId = "OVM-".$fila['MAXIMO'];					
			}
				
	}

 public function MtdObtenerOrdenVentaVehiculoMantenimiento(){

        $sql = 'SELECT 
       ovm.OvmId,			
			ovm.OvvId,
			ovm.OvmKilometraje,
			ovm.OvmEstado,
			DATE_FORMAT(ovm.OvmTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvmTiempoCreacion",
			DATE_FORMAT(ovm.OvmTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvmTiempoModificacion",
			
			CASE
			WHEN EXISTS (
				SELECT 
				fin.FinId
				FROM tblfinfichaingreso fin
				WHERE fin.EinId = ovv.EinId
					AND fin.FinMantenimientoKilometraje = ovm.OvmKilometraje
				LIMIT 1
			) THEN "Si"
			ELSE "No"
			END AS OvmRealizado,
			
			ovv.OvvObservacion

			
			FROM tblovmordenventavehiculomantenimiento ovm		
				LEFT JOIN tblovvordenventavehiculo ovv
				ON ovm.OvvId = ovv.OvvId
		WHERE  ovm.OvmId = "'.$this->OvmId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->OvmId = $fila['OvmId'];
			$this->OvvId = $fila['OvvId'];
			$this->OvmKilometraje = (($fila['OvmKilometraje']));
			$this->OvmEstado = (($fila['OvmEstado']));
			$this->OvmTiempoCreacion = (($fila['NOvmTiempoCreacion']));
			$this->OvmTiempoModificacion = (($fila['NOvmTiempoModificacion']));
			$this->OvmRealizado = (($fila['OvmRealizado']));
			
			$this->OvvObservacion = (($fila['OvvObservacion']));
                    
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }



    public function MtdObtenerOrdenVentaVehiculoMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'OvmId',$oSentido = 'Desc',$oPaginacion = '0,10',$oOrdenVentaVehiculo=NULL,$oEstado=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){

			$oFiltro = str_replace(" ","%",$oFiltro);			
			$elementos = explode(",",$oCampo);

			$i=1;
			$filtrar .= '  AND (';
			foreach($elementos as $elemento){
					if(!empty($elemento)){				
						if($i==count($elementos)){	

						$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' )';
							
						}else{
							
							$filtrar .= ' (';
							switch($oCondicion){
					
								case "esigual":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'"';	
								break;
				
								case "noesigual":
									$filtrar .= '  '.($elemento).' <> "'.($oFiltro).'"';
								break;
								
								case "comienza":
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
								
								case "termina":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'"';
								break;
								
								case "contiene":
									$filtrar .= '  '.($elemento).' LIKE "%'.($oFiltro).'%"';
								break;
								
								case "nocontiene":
									$filtrar .= '  '.($elemento).' NOT LIKE "%'.($oFiltro).'%"';
								break;
								
								default:
									$filtrar .= '  '.($elemento).' LIKE "'.($oFiltro).'%"';
								break;
							
							}
							
							$filtrar .= ' ) OR';
							
						}
					}
				$i++;
		
				}
				
				$filtrar .= '  ) ';

		}
		
		
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			$ovvehiculo = ' AND ovm.OvvId = "'.$oOrdenVentaVehiculo.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND ovm.OvmEstado = "'.$oEstado.'"';
		}
		
	 $sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			ovm.OvmId,			
			ovm.OvvId,
			ovm.OvmKilometraje,
			ovm.OvmEstado,
			DATE_FORMAT(ovm.OvmTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOvmTiempoCreacion",
			DATE_FORMAT(ovm.OvmTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOvmTiempoModificacion",
			
			CASE
			WHEN EXISTS (
				SELECT 
				fin.FinId
				FROM tblfinfichaingreso fin
				WHERE fin.EinId = ovv.EinId
					AND fin.FinMantenimientoKilometraje = ovm.OvmKilometraje
				LIMIT 1
			) THEN "Si"
			ELSE "No"
			END AS OvmRealizado

			FROM tblovmordenventavehiculomantenimiento ovm		
				LEFT JOIN tblovvordenventavehiculo ovv
				ON ovm.OvvId = ovv.OvvId
				
			WHERE  1 = 1 '.$amovimiento.$estado.$producto.$ovvehiculo.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenVentaVehiculoMantenimiento = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenVentaVehiculoMantenimiento = new $InsOrdenVentaVehiculoMantenimiento();
                    $OrdenVentaVehiculoMantenimiento->OvmId = $fila['OvmId'];
                    $OrdenVentaVehiculoMantenimiento->OvvId = $fila['OvvId'];
					$OrdenVentaVehiculoMantenimiento->OvmKilometraje = (($fila['OvmKilometraje']));
					$OrdenVentaVehiculoMantenimiento->OvmEstado = (($fila['OvmEstado']));
					$OrdenVentaVehiculoMantenimiento->OvmTiempoCreacion = (($fila['NOvmTiempoCreacion']));
					$OrdenVentaVehiculoMantenimiento->OvmTiempoModificacion = (($fila['NOvmTiempoModificacion']));
					$OrdenVentaVehiculoMantenimiento->OvmRealizado = (($fila['OvmRealizado']));
					
                    $OrdenVentaVehiculoMantenimiento->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenVentaVehiculoMantenimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarOrdenVentaVehiculoMantenimiento($oElementos) {
		
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (OvmId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (OvmId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblovmordenventavehiculomantenimiento 
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
	
	
	public function MtdRegistrarOrdenVentaVehiculoMantenimiento() {
	
			$this->MtdGenerarOrdenVentaVehiculoMantenimientoId();
			
			$sql = 'INSERT INTO tblovmordenventavehiculomantenimiento (
			OvmId,
			OvvId,
		
			OvmKilometraje,
			OvmEstado,
			OvmTiempoCreacion,
			OvmTiempoModificacion
			) 
			VALUES (
			"'.($this->OvmId).'", 
			"'.($this->OvvId).'", 
			
			'.($this->OvmKilometraje).', 
			'.($this->OvmEstado).', 
			"'.($this->OvmTiempoCreacion).'", 
			"'.($this->OvmTiempoModificacion).'");';
		
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
	
	public function MtdEditarOrdenVentaVehiculoMantenimiento() {

			$sql = 'UPDATE tblovmordenventavehiculomantenimiento SET 	
			
			 OvmKilometraje = "'.($this->OvmKilometraje).'",
			 OvmTiempoModificacion = "'.($this->OvmTiempoModificacion).'"
			 WHERE OvmId = "'.($this->OvmId).'";';
					
					 //OvmEstado = '.($this->OvmEstado).',
					 
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