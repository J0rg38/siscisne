<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAviso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsAviso {

    public $AviId;
	public $CliId;
	public $EinId;
    public $AviObservacion;
	public $AviFecha;
	public $AviEstado;
    public $AviTiempoCreacion;
    public $AviTiempoModificacion;
    public $AviEliminado;
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

	public function MtdGenerarAvisoId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(AviId,5),unsigned)) AS "MAXIMO"
			FROM tblaviaviso';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->AviId = "AVI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->AviId = "AVI-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerAviso(){

        $sql = 'SELECT 
        avi.AviId,
		avi.CliId,
		avi.EinId,
        avi.AviObservacion,
		DATE_FORMAT(avi.AviFecha, "%d/%m/%Y") AS "NAviFecha",
		
		avi.AviEstado,
		DATE_FORMAT(avi.AviTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAviTiempoCreacion",
        DATE_FORMAT(avi.AviTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAviTiempoModificacion",
     
		
		ein.EinVIN,
				ein.EinPlaca,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre
				FROM tblaviaviso avi
				
							LEFT JOIN tbleinvehiculoingreso ein
					ON avi.EinId = ein.EinId
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
								
        WHERE avi.AviId = "'.$this->AviId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->AviId = $fila['AviId'];
			$this->CliId = $fila['CliId'];
			$this->EinId = $fila['EinId'];
			$this->AviObservacion = $fila['AviObservacion'];
			$this->AviFecha = $fila['NAviFecha'];
			$this->AviEstado = $fila['AviEstado'];
			$this->AviTiempoCreacion = $fila['NAviTiempoCreacion'];
			$this->AviTiempoModificacion = $fila['NAviTiempoModificacion']; 
			
			$this->EinVIN = $fila['EinVIN']; 
			$this->EinPlaca = $fila['EinPlaca']; 
			
			$this->VmaNombre = $fila['VmaNombre']; 
			$this->VmoNombre = $fila['VmoNombre']; 
			$this->VveNombre = $fila['VveNombre']; 
	
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerAvisos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'AviId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVehiculoIngresoId=NULL) {

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
		
		if(!empty($oEstado)){
			$estado = ' AND avi.AviEstado = '.($oEstado).'';
		}
		
		if(!empty($oVehiculoIngresoId)){
			$vingreso = ' AND avi.EinId = "'.($oVehiculoIngresoId).'" ';
		}
		

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				avi.AviId,
				avi.CliId,
				avi.EinId,
				avi.AviObservacion,
				DATE_FORMAT(avi.AviFecha, "%d/%m/%Y") AS "NAviFecha",
				avi.AviEstado,
				DATE_FORMAT(avi.AviTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NAviTiempoCreacion",
                DATE_FORMAT(avi.AviTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NAviTiempoModificacion",
				
				ein.EinVIN,
				ein.EinPlaca,
				
				vma.VmaNombre,
				vmo.VmoNombre,
				vve.VveNombre
				
				FROM tblaviaviso avi
					LEFT JOIN tbleinvehiculoingreso ein
					ON avi.EinId = ein.EinId
						LEFT JOIN tblvvevehiculoversion vve
						ON ein.VveId = vve.VveId
							LEFT JOIN tblvmovehiculomodelo vmo
							ON vve.VmoId = vmo.VmoId
								LEFT JOIN tblvmavehiculomarca vma
								ON vmo.VmaId = vma.VmaId
				WHERE 1 = 1 '.$filtrar.$estado.$vingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsAviso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Aviso = new $InsAviso();
                    $Aviso->AviId = $fila['AviId'];
					$Aviso->CliId = $fila['CliId'];
					$Aviso->EinId = $fila['EinId'];
					$Aviso->AviObservacion= $fila['AviObservacion'];
					$Aviso->AviFecha= $fila['NAviFecha'];
					$Aviso->AviEstado= $fila['AviEstado'];
                    $Aviso->AviTiempoCreacion = $fila['NAviTiempoCreacion'];
                    $Aviso->AviTiempoModificacion = $fila['NAviTiempoModificacion'];  
					
					$Aviso->EinVIN = $fila['EinVIN'];  
					$Aviso->EinPlaca = $fila['EinPlaca'];  
					
					$Aviso->VmaNombre = $fila['VmaNombre'];  
					$Aviso->VmoNombre = $fila['VmoNombre'];  
					$Aviso->VveNombre = $fila['VveNombre'];  
					
					 
                    $Aviso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Aviso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarAviso($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (AviId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (AviId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblaviaviso WHERE '.$eliminar;

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
	
	
	public function MtdRegistrarAviso() {
	
			$this->MtdGenerarAvisoId();
		
			$sql = 'INSERT INTO tblaviaviso (
			AviId,
			CliId,
			EinId,
			AviObservacion, 
			AviFecha,
			AviEstado,
			AviTiempoCreacion,
			AviTiempoModificacion
			) 
			VALUES (
			"'.($this->AviId).'", 
			
			'.(empty($this->CliId)?"NULL,":'"'.$this->CliId.'",').'
			'.(empty($this->EinId)?"NULL,":'"'.$this->EinId.'",').'
			
			"'.($this->AviObservacion).'", 
			"'.($this->AviFecha).'", 
			'.($this->AviEstado).', 
			"'.($this->AviTiempoCreacion).'", 
			"'.($this->AviTiempoModificacion).'");';

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
	
	public function MtdEditarAviso() {
		
			$sql = 'UPDATE tblaviaviso SET 
			
			'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
			'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
		
			 AviObservacion = "'.($this->AviObservacion).'",
			 AviFecha = "'.($this->AviFecha).'",
			 AviEstado = '.($this->AviEstado).',
			 AviTiempoModificacion = "'.($this->AviTiempoModificacion).'"
			 WHERE AviId = "'.($this->AviId).'";';
		
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
		
	
		
	
}
?>