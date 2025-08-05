<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsVehiculo {

    public $VehId;
	public $VveId;
	public $VehNombre;
	public $VehColor;
	public $VehInformacion;
	public $VehEspecificacion;
	public $VehFoto;
	public $VehEstado;
    public $VehTiempoCreacion;
    public $VehTiempoModificacion;
    public $VehEliminado;
	
	public $VmoId;
	public $VmoNombre;
	
	public $VmaId;
	public $VmaNombre;
	
	public $VtiId;
	public $VtiNombre;
	
	public $VveNombre;

	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarVehiculoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(VehId,5),unsigned)) AS "MAXIMO"
			FROM tblvehvehiculo';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->VehId = "VEH-10000";

			}else{
				$fila['MAXIMO']++;
				$this->VehId = "VEH-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerVehiculo(){

        $sql = 'SELECT 
		veh.VehId,
		veh.VveId,
		
		veh.VehCodigoIdentificador,
		veh.VehNombre,
		veh.VehColor,
		veh.VehEspecificacion,
		veh.VehInformacion,
		veh.VehFoto,
		
		veh.UmeId,
		veh.VehEstado,
		DATE_FORMAT(veh.VehTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVehTiempoCreacion",
        DATE_FORMAT(veh.VehTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVehTiempoModificacion",
	
		vve.VmoId,
		vmo.VmoNombre,

		vmo.VmaId,
		vma.VmaNombre,
		
		vmo.VtiId,
		vti.VtiNombre,
		
		vve.VveNombre
		
        FROM tblvehvehiculo veh
		LEFT JOIN tblvvevehiculoversion vve
		ON veh.VveId = vve.VveId
			LEFT JOIN tblvmovehiculomodelo vmo
			ON vve.VmoId = vmo.VmoId
				LEFT JOIN tblvtivehiculotipo vti
				ON vmo.VtiId = vti.VtiId					
					LEFT JOIN tblvmavehiculomarca vma
					ON vmo.VmaId = vma.VmaId
        WHERE veh.VehId = "'.$this->VehId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->VehId = $fila['VehId'];
			$this->VveId = $fila['VveId'];
			
			
			$this->VehCodigoIdentificador = $fila['VehCodigoIdentificador'];
			$this->VehNombre = $fila['VehNombre'];
			$this->VehColor = $fila['VehColor'];
			$this->VehEspecificacion = $fila['VehEspecificacion'];
			$this->VehInformacion = $fila['VehInformacion'];
			$this->VehFoto = $fila['VehFoto'];
			
			
			$this->UmeId = $fila['UmeId'];
			$this->VehEstado = $fila['VehEstado'];					
			$this->VehTiempoCreacion = $fila['NVehTiempoCreacion'];
			$this->VehTiempoModificacion = $fila['NVehTiempoModificacion']; 
			
			$this->VmoId = $fila['VmoId'];
			$this->VmoNombre = $fila['VmoNombre']; 
			
			$this->VmaId = $fila['VmaId']; 
			$this->VmaNombre = $fila['VmaNombre']; 
			
			$this->VtiId = $fila['VtiId']; 			
			$this->VtiNombre = $fila['VtiNombre']; 
			
			$this->VveNombre = $fila['VveNombre']; 
			
		}

			$Respuesta =  $this;

		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }
	
	public function MtdIdentificarVehiculo($oBuscar){
		
		$VehiculoId = "";
		//MtdObtenerVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL,$oEstado=NULL) {		
		$ResVehiculo = $this->MtdObtenerVehiculos("VehCodigoIdentificador","esigual",$oBuscar,'VehId','Desc','1',NULL,NULL,NULL,NULL,1);
		$ArrVehiculos = $ResVehiculo['Datos'];
		
		if(!empty($ArrVehiculos)){
			foreach($ArrVehiculos as $DatVehiculo){

				$VehiculoId = $DatVehiculo->VehId;
				
			}
		}
		
		return $VehiculoId;
		
	}
	
	
	
	public function MtdObtenerVehiculos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'VehId',$oSentido = 'Desc',$oPaginacion = '0,10',$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoTipo=NULL,$oEstado=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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

		
		if(!empty($oVehiculoMarca)){
			$vmarca = ' AND vmo.VmaId = "'.($oVehiculoMarca).'"';
		}
		
		if(!empty($oVehiculoModelo)){
			$vmodelo = ' AND vve.VmoId = "'.($oVehiculoModelo).'"';
		}
		
		if(!empty($oVehiculoVersion)){
			$vversion = ' AND vve.VveId = "'.($oVehiculoVersion).'"';
		}
			
		if(!empty($oVehiculoTipo)){
			$vtipo = ' AND vmo.VtiId = "'.($oVehiculoTipo).'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND veh.VehEstado = '.$oEstado.' ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				veh.VehId,
				veh.VveId,
				
				veh.VehCodigoIdentificador,
				veh.VehNombre,
				veh.VehColor,
				veh.VehEspecificacion,
				veh.VehInformacion,	
				veh.VehFoto,
				
				veh.UmeId,
				veh.VehEstado,
				DATE_FORMAT(veh.VehTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NVehTiempoCreacion",
                DATE_FORMAT(veh.VehTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NVehTiempoModificacion",
				
				vve.VmoId,
				vmo.VmoNombre,
				
				vmo.VmaId,
				vma.VmaNombre,
				
				vmo.VtiId,
				vti.VtiNombre,
				
				vve.VveNombre,
				
				ume.UmeNombre				
		
				FROM tblvehvehiculo veh		
					LEFT JOIN tblvvevehiculoversion vve
					ON veh.VveId = vve.VveId
						LEFT JOIN tblvmovehiculomodelo vmo
						ON vve.VmoId = vmo.VmoId
							LEFT JOIN tblvtivehiculotipo vti
							ON vmo.VtiId = vti.VtiId					
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
									LEFT JOIN tblumeunidadmedida ume
									ON veh.UmeId = ume.UmeId
								
				WHERE  1 = 1  '.$filtrar.$vmarca.$vmodelo.$vversion.$vtipo.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsVehiculo = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Vehiculo = new $InsVehiculo();
					
					$Vehiculo->VehId = $fila['VehId'];
					$Vehiculo->VveId = $fila['VveId'];
					
					$Vehiculo->VehCodigoIdentificador = $fila['VehCodigoIdentificador'];
					$Vehiculo->VehNombre = $fila['VehNombre'];
					$Vehiculo->VehColor = $fila['VehColor'];
					$Vehiculo->VehEspecificacion = $fila['VehEspecificacion'];
					$Vehiculo->VehInformacion = $fila['VehInformacion'];
                    $Vehiculo->VehFoto = $fila['VehFoto'];	
					$Vehiculo->VehTipo = $fila['VehTipo'];	
					
					
					$Vehiculo->UmeId = $fila['UmeId'];	
					$Vehiculo->VehEstado = $fila['VehEstado'];	
                    $Vehiculo->VehTiempoCreacion = $fila['NVehTiempoCreacion'];
                    $Vehiculo->VehTiempoModificacion = $fila['NVehTiempoModificacion'];
	
					$Vehiculo->VmoId = $fila['VmoId'];
					$Vehiculo->VmoNombre = $fila['VmoNombre'];
					
					$Vehiculo->VmaId = $fila['VmaId'];
					$Vehiculo->VmaNombre = $fila['VmaNombre'];
					
					$Vehiculo->VtiId = $fila['VtiId'];
					$Vehiculo->VtiNombre = $fila['VtiNombre'];
					$Vehiculo->VveNombre = $fila['VveNombre'];
					
					$Vehiculo->UmeNombre = $fila['UmeNombre'];
					
                    $Vehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Vehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		 
		
		
	//Accion eliminar	 
	
	public function MtdEliminarVehiculo($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (VehId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (VehId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblvehvehiculo WHERE '.$eliminar;			
		
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
	
	
	
	public function MtdRegistrarVehiculo() {
			
			$this->MtdGenerarVehiculoId();
			
			$sql = 'INSERT INTO tblvehvehiculo (
			VehId,
			VveId,
			UmeId,
			
			VehCodigoIdentificador,
			VehNombre,
			VehColor,
			VehEspecificacion,
			VehInformacion,
			VehFoto,
			VehEstado,
			VehTiempoCreacion,
			VehTiempoModificacion
			) 
			VALUES (
			"'.($this->VehId).'", 
			"'.($this->VveId).'", 
			"'.($this->UmeId).'", 
			
			"'.($this->VehCodigoIdentificador).'", 			
			"'.($this->VehNombre).'", 
			"'.($this->VehColor).'",
			"'.($this->VehEspecificacion).'",
			"'.($this->VehInformacion).'",
			"'.($this->VehFoto).'",
			'.($this->VehEstado).',
			"'.($this->VehTiempoCreacion).'", 
			"'.($this->VehTiempoModificacion).'");';

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
	
	public function MtdEditarVehiculo() {
		
						
			$sql = 'UPDATE tblvehvehiculo SET 
			VveId = "'.($this->VveId).'",
			UmeId = "'.($this->UmeId).'",	
			
			
			VehCodigoIdentificador = "'.($this->VehCodigoIdentificador).'",
			VehNombre = "'.($this->VehNombre).'",
			VehColor = "'.($this->VehColor).'",
			VehEspecificacion = "'.($this->VehEspecificacion).'",
			VehInformacion = "'.($this->VehInformacion).'",
			VehFoto = "'.($this->VehFoto).'",			
			VehEstado = '.($this->VehEstado).',
			VehTiempoModificacion = "'.($this->VehTiempoModificacion).'"		
			WHERE VehId = "'.($this->VehId).'";';

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