<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGeneralMotor
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGeneralMotor {

    
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarProductoDisponibilidadId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PdiId,5),unsigned)) AS "MAXIMO"
		FROM tblpdiproductodisponibilidad';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->GmoId = "PDI-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->GmoId = "PDI-".$fila['MAXIMO'];					
		}		
			
	}
		
	public function MtdGenerarProductoReemplazoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PreId,5),unsigned)) AS "MAXIMO"
		FROM tblpreproductoreemplazo';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->GmoId = "PRE-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->GmoId = "PRE-".$fila['MAXIMO'];					
		}		
			
	}
	
	
	
	public function MtdGenerarProductoCostoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PosId,5),unsigned)) AS "MAXIMO"
		FROM tblposproductocosto';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){			
			$this->Pos = "POS-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->GmoId = "POS-".$fila['MAXIMO'];					
		}		
			
	}
	
	
    public function MtdObtenerGeneralMotor(){

        $sql = 'SELECT 
		veh.GmoId,
		veh.VveId,
		veh.GmoNombre,
		veh.GmoColor,
		veh.GmoEspecificacion,
		veh.GmoInformacion,
		veh.GmoFoto,
		veh.GmoEstado,
		DATE_FORMAT(veh.GmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGmoTiempoCreacion",
        DATE_FORMAT(veh.GmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGmoTiempoModificacion",
	
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
        WHERE veh.GmoId = "'.$this->GmoId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->GmoId = $fila['GmoId'];
			$this->VveId = $fila['VveId'];
			$this->GmoNombre = $fila['GmoNombre'];
			$this->GmoColor = $fila['GmoColor'];
			$this->GmoEspecificacion = $fila['GmoEspecificacion'];
			$this->GmoInformacion = $fila['GmoInformacion'];
			$this->GmoFoto = $fila['GmoFoto'];
			$this->GmoEstado = $fila['GmoEstado'];					
			$this->GmoTiempoCreacion = $fila['NGmoTiempoCreacion'];
			$this->GmoTiempoModificacion = $fila['NGmoTiempoModificacion']; 
			
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

	public function MtdObtenerGeneralMotors($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'GmoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGeneralMotorMarca=NULL,$oGeneralMotorModelo=NULL,$oGeneralMotorVersion=NULL,$oGeneralMotorTipo=NULL,$oEstado=NULL) {

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

		
		if(!empty($oGeneralMotorMarca)){
			$vmarca = ' AND vmo.VmaId = "'.($oGeneralMotorMarca).'"';
		}
		
		if(!empty($oGeneralMotorModelo)){
			$vmodelo = ' AND vve.VmoId = "'.($oGeneralMotorModelo).'"';
		}
		
		if(!empty($oGeneralMotorVersion)){
			$vversion = ' AND vve.VveId = "'.($oGeneralMotorVersion).'"';
		}
			
		if(!empty($oGeneralMotorTipo)){
			$vtipo = ' AND vmo.VtiId = "'.($oGeneralMotorTipo).'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND veh.GmoEstado = '.$oEstado.' ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				veh.GmoId,
				veh.VveId,
				veh.GmoNombre,
				veh.GmoColor,
				veh.GmoEspecificacion,
				veh.GmoInformacion,	
				veh.GmoFoto,
				veh.GmoEstado,
				DATE_FORMAT(veh.GmoTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGmoTiempoCreacion",
                DATE_FORMAT(veh.GmoTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGmoTiempoModificacion",
				
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
				WHERE  1 = 1  '.$filtrar.$vmarca.$vmodelo.$vversion.$vtipo.$estado.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGeneralMotor = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$GeneralMotor = new $InsGeneralMotor();
					
					$GeneralMotor->GmoId = $fila['GmoId'];
					$GeneralMotor->VveId = $fila['VveId'];
					$GeneralMotor->GmoNombre = $fila['GmoNombre'];
					$GeneralMotor->GmoColor = $fila['GmoColor'];
					$GeneralMotor->GmoEspecificacion = $fila['GmoEspecificacion'];
					$GeneralMotor->GmoInformacion = $fila['GmoInformacion'];
                    $GeneralMotor->GmoFoto = $fila['GmoFoto'];	
					$GeneralMotor->GmoTipo = $fila['GmoTipo'];	
					$GeneralMotor->GmoEstado = $fila['GmoEstado'];	
                    $GeneralMotor->GmoTiempoCreacion = $fila['NGmoTiempoCreacion'];
                    $GeneralMotor->GmoTiempoModificacion = $fila['NGmoTiempoModificacion'];
	
					$GeneralMotor->VmoId = $fila['VmoId'];
					$GeneralMotor->VmoNombre = $fila['VmoNombre'];
					
					$GeneralMotor->VmaId = $fila['VmaId'];
					$GeneralMotor->VmaNombre = $fila['VmaNombre'];
					
					$GeneralMotor->VtiId = $fila['VtiId'];
					$GeneralMotor->VtiNombre = $fila['VtiNombre'];
					$GeneralMotor->VveNombre = $fila['VveNombre'];
					
                    $GeneralMotor->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $GeneralMotor;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarGeneralMotor($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (GmoId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (GmoId = "'.($elemento).'")  OR';	
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
	
	
	
	public function MtdRegistrarGeneralMotor() {
			
			$this->MtdGenerarGeneralMotorId();
			
			$sql = 'INSERT INTO tblvehvehiculo (
			GmoId,
			VveId,
			GmoNombre,
			GmoColor,
			GmoEspecificacion,
			GmoInformacion,
			GmoFoto,
			GmoEstado,
			GmoTiempoCreacion,
			GmoTiempoModificacion
			) 
			VALUES (
			"'.($this->GmoId).'", 
			"'.($this->VveId).'", 
			"'.($this->GmoNombre).'", 
			"'.($this->GmoColor).'",
			"'.($this->GmoEspecificacion).'",
			"'.($this->GmoInformacion).'",
			"'.($this->GmoFoto).'",
			'.($this->GmoEstado).',
			"'.($this->GmoTiempoCreacion).'", 
			"'.($this->GmoTiempoModificacion).'");';

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
	
	public function MtdEditarGeneralMotor() {
		
						
			$sql = 'UPDATE tblvehvehiculo SET 
			VveId = "'.($this->VveId).'",	
			GmoNombre = "'.($this->GmoNombre).'",
			GmoColor = "'.($this->GmoColor).'",
			GmoEspecificacion = "'.($this->GmoEspecificacion).'",
			GmoInformacion = "'.($this->GmoInformacion).'",
			GmoFoto = "'.($this->GmoFoto).'",			
			GmoEstado = '.($this->GmoEstado).',
			GmoTiempoModificacion = "'.($this->GmoTiempoModificacion).'"		
			WHERE GmoId = "'.($this->GmoId).'";';

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