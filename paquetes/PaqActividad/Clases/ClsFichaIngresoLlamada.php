<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoLlamada
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoLlamada {

    public $FllId;
	public $FinId;
	public $FllNumero;
	public $FllFecha;
	public $FllObservacion;
	public $FllEstado;	
	public $FllTiempoCreacion;
	public $FllTiempoModificacion;
    public $FllEliminado;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }

	public function __destruct(){

	}

	private function MtdGenerarFichaIngresoLlamadaId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FllId,5),unsigned)) AS "MAXIMO"
		FROM tblfllfichaingresollamada';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FllId = "FLL-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FllId = "FLL-".$fila['MAXIMO'];					
		}
			
	}

    public function MtdObtenerFichaIngresoLlamadas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FllId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oAsesor=NULL) {

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
		
		if(!empty($oFichaIngreso)){
			$garantia = ' AND fll.FinId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fll.FllEstado = '.$oEstado.' ';
		}
			
			
					
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fll.FllFecha)>="'.$oFechaInicio.'" AND DATE(fll.FllFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(fll.FllFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(fll.FllFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oAsesor)){
			$asesor = ' AND fin.PerIdAsesor = "'.$oAsesor.' "';
		}

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fll.FllId,			
			fll.FinId,
			fll.FllNumero,
			
			DATE_FORMAT(fll.FllFecha, "%d/%m/%Y") AS "NFllFecha",
			
			fll.FllObservacion,
			fll.FllEstado,
			DATE_FORMAT(fll.FllTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFllTiempoCreacion",
	        DATE_FORMAT(fll.FllTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFllTiempoModificacion",
			
			per.PerNombre,
			per.PerApellidoPaterno,
			per.PerApellidoMaterno,
			
			cli.CliNombre,
			cli.CliApellidoPaterno,
			cli.CliApellidoMaterno,
			
			ein.EinVIN,
			ein.EinPlaca,
			
			vma.VmaNombre,
			vmo.VmoNombre,
			vve.VveNombre
			
			FROM tblfllfichaingresollamada fll
				LEFT JOIN tblfinfichaingreso fin
				ON fll.FinId = fin.FinId
					LEFT JOIN tblperpersonal per
					ON fin.PerIdAsesor = per.PerId
						LEFT JOIN tblclicliente cli
						ON fin.CliId = cli.CliId
							LEFT JOIN tbleinvehiculoingreso ein
							ON fin.EinId = ein.EinId
								LEFT JOIN tblvvevehiculoversion vve
								ON ein.VveId = vve.VveId
									LEFT JOIN tblvmovehiculomodelo vmo
									ON vve.VmoId = vmo.VmoId
										LEFT JOIN tblvmavehiculomarca vma
										ON vmo.VmaId = vma.VmaId
						
			WHERE  1 = 1 '.$garantia.$estado.$fecha.$asesor.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoLlamada = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoLlamada = new $InsFichaIngresoLlamada();
                    $FichaIngresoLlamada->FllId = $fila['FllId'];
                    $FichaIngresoLlamada->FinId = $fila['FinId'];

					$FichaIngresoLlamada->FllNumero = $fila['FllNumero'];  

					$FichaIngresoLlamada->FllFecha = $fila['NFllFecha'];  
					$FichaIngresoLlamada->FllObservacion = $fila['FllObservacion'];
			      
					  
					$FichaIngresoLlamada->FllEstado = $fila['FllEstado'];
					$FichaIngresoLlamada->FllTiempoCreacion = $fila['NFllTiempoCreacion'];  
					$FichaIngresoLlamada->FllTiempoModificacion = $fila['NFllTiempoModificacion']; 					
					
					$FichaIngresoLlamada->PerNombre = $fila['PerNombre'];
					$FichaIngresoLlamada->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$FichaIngresoLlamada->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$FichaIngresoLlamada->CliNombre = $fila['CliNombre'];
					$FichaIngresoLlamada->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$FichaIngresoLlamada->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					
					$FichaIngresoLlamada->EinVIN = $fila['EinVIN'];
					$FichaIngresoLlamada->EinPlaca = $fila['EinPlaca'];
					
					$FichaIngresoLlamada->VmaNombre = $fila['VmaNombre'];
					$FichaIngresoLlamada->VmoNombre = $fila['VmoNombre'];
					$FichaIngresoLlamada->VveNombre = $fila['VveNombre'];

                    $FichaIngresoLlamada->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaIngresoLlamada;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoLlamada($oElementos) {
		
		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FllId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FllId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfllfichaingresollamada 
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
	
	
	public function MtdRegistrarFichaIngresoLlamada() {
	
			$this->MtdGenerarFichaIngresoLlamadaId();
			
			
			$sql = 'INSERT INTO tblfllfichaingresollamada (
			FllId,
			FinId,
			
			FllNumero,
			
			FllFecha,			
			FllObservacion,
			
			FllEstado,
			FllTiempoCreacion,
			FllTiempoModificacion) 
			VALUES (
			"'.($this->FllId).'", 
			"'.($this->FinId).'", 
			"'.($this->FllNumero).'", 

			"'.($this->FllFecha).'", 
			"'.($this->FllObservacion).'", 	
			
			'.($this->FllEstado).',
			"'.($this->FllTiempoCreacion).'",
			"'.($this->FllTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaIngresoLlamada() {

			$sql = 'UPDATE tblfllfichaingresollamada SET 	
			
			FllNumero = "'.($this->FllNumero).'",

			FllFecha = "'.($this->FllFecha).'",			 
			FllObservacion = "'.($this->FllObservacion).'",
		
			FllTiempoModificacion = "'.($this->FllTiempoModificacion).'"
			 
			WHERE FllId = "'.($this->FllId).'";';
					
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