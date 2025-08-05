<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaIngresoMantenimiento
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaIngresoMantenimiento {

    public $FiaId;
	public $FimId;
	public $PmtId;
	public $FiaAccion;	
	public $FiaNivel;
	public $FiaVerificar1;
	public $FiaVerificar2;

	public $ProId;
	
	public $FiaEstado;	
	public $FiaTiempoCreacion;
	public $FiaTiempoModificacion;
    public $FiaEliminado;
	
	public $PmtNombre;

	public $MinSigla;
	
	public $FaaVerificar1;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	private function MtdGenerarFichaIngresoMantenimientoId() {
			
		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(FiaId,5),unsigned)) AS "MAXIMO"
		FROM tblfiafichaingresomantenimiento';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->FiaId = "FIA-10000";
		}else{
			$fila['MAXIMO']++;
			$this->FiaId = "FIA-".$fila['MAXIMO'];					
		}
				
	}
		

    public function MtdObtenerFichaIngresoMantenimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FiaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaIngreso=NULL,$oEstado=NULL,$oNivel=NULL,$oSevero=false,$oAccion=NULL) {

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
			$faccion = ' AND fia.FimId = "'.$oFichaIngreso.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fia.FiaEstado = '.$oEstado.'';
		}
		
		if(!empty($oNivel)){
			$nivel = ' AND fia.FiaNivel = '.$oNivel.'';
		}		
		
		if(($oSevero)){
			$severo = ' AND (UPPER(fia.FiaAccion) <> "X" AND fia.FiaNivel = 2)';
		}
		
		if(!empty($oAccion)){
			$accion = ' AND fia.FiaAccion = "'.$oAccion.'"';
		}		

		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fia.FiaId,			
			fia.FimId,
			fia.PmtId,
			fia.FiaAccion,
			fia.FiaNivel,
			fia.FiaVerificar1,
			fia.FiaVerificar2,
			
			fia.ProId,
			
			fia.FiaEstado,
			DATE_FORMAT(fia.FiaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFiaTiempoCreacion",
	        DATE_FORMAT(fia.FiaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFiaTiempoModificacion",
			pmt.PmtNombre,
			min.MinSigla,
			
			faa.FaaVerificar1,
			
			pro.ProNombre,
			pro.ProCodigoOriginal
			
			FROM tblfiafichaingresomantenimiento fia
				LEFT JOIN tblpmtplanmantenimientotarea pmt
				ON fia.PmtId = pmt.PmtId		
						LEFT JOIN tblfimfichaingresomodalidad fim
						ON fia.FimId = fim.FimId
							LEFT JOIN tblminmodalidadingreso min
							ON fim.MinId = min.MinId
								LEFT JOIN tblfaafichaaccionmantenimiento faa
								ON faa.FiaId = fia.FiaId
									LEFT JOIN tblproproducto pro
									ON fia.ProId = pro.ProId

			WHERE  1 = 1 '.$faccion.$estado.$nivel.$severo.$accion.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaIngresoMantenimiento = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaIngresoMantenimiento = new $InsFichaIngresoMantenimiento();
                    $FichaIngresoMantenimiento->FiaId = $fila['FiaId'];
                    $FichaIngresoMantenimiento->FimId = $fila['FimId'];					
					$FichaIngresoMantenimiento->PmtId = $fila['PmtId'];	
					$FichaIngresoMantenimiento->FiaAccion = $fila['FiaAccion'];
					$FichaIngresoMantenimiento->FiaNivel = $fila['FiaNivel'];
					$FichaIngresoMantenimiento->FiaVerificar1 = $fila['FiaVerificar1'];
					$FichaIngresoMantenimiento->FiaVerificar2 = $fila['FiaVerificar2'];
					
					$FichaIngresoMantenimiento->ProId = $fila['ProId'];
					
					$FichaIngresoMantenimiento->FiaEstado = $fila['FiaEstado'];
					$FichaIngresoMantenimiento->FiaTiempoCreacion = $fila['NFiaTiempoCreacion'];  
					$FichaIngresoMantenimiento->FiaTiempoModificacion = $fila['NFiaTiempoModificacion']; 
					
					$FichaIngresoMantenimiento->PmtNombre = $fila['PmtNombre'];
					
					$FichaIngresoMantenimiento->MinSigla = $fila['MinSigla'];
					
					$FichaIngresoMantenimiento->FaaVerificar1 = $fila['FaaVerificar1'];
					
					$FichaIngresoMantenimiento->ProNombre = $fila['ProNombre'];
					$FichaIngresoMantenimiento->ProCodigoOriginal = $fila['ProCodigoOriginal'];

					$FichaIngresoMantenimiento->InsMysql = NULL;

					$Respuesta['Datos'][]= $FichaIngresoMantenimiento;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaIngresoMantenimiento($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
		$i=1;
		foreach($elementos as $elemento){
			if(!empty($elemento)){				
				if($i==count($elementos)){						
					$eliminar .= '  (FiaId = "'.($elemento).'")';	
				}else{
					$eliminar .= '  (FiaId = "'.($elemento).'")  OR';	
				}	
			}
		$i++;
		
		}
		
		$sql = 'DELETE FROM tblfiafichaingresomantenimiento 
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
	
	
	public function MtdRegistrarFichaIngresoMantenimiento() {
	
		$this->MtdGenerarFichaIngresoMantenimientoId();
		
		$sql = 'INSERT INTO tblfiafichaingresomantenimiento (
		FiaId,
		FimId,	
		PmtId,
		FiaAccion,
		FiaNivel,
		FiaVerificar1,
		FiaVerificar2,
		
		ProId,
		
		FiaEstado,
		FiaTiempoCreacion,
		FiaTiempoModificacion) 
		VALUES (
		"'.($this->FiaId).'", 
		"'.($this->FimId).'", 
		"'.($this->PmtId).'", 
		"'.($this->FiaAccion).'",
		'.($this->FiaNivel).',
		'.($this->FiaVerificar1).',
		'.($this->FiaVerificar2).',
		
		'.(empty($this->ProId)?'NULL,':'"'.$this->ProId.'",').'	
		
		'.($this->FiaEstado).',
		"'.($this->FiaTiempoCreacion).'",
		"'.($this->FiaTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaIngresoMantenimiento() {
	
		$sql = 'UPDATE tblfiafichaingresomantenimiento SET 	
		'.(empty($this->ProId)?'ProId = NULL, ':'ProId = "'.$this->ProId.'",').'
		PmtId = "'.($this->PmtId).'",
		FiaAccion = "'.($this->FiaAccion).'",
		FiaNivel = '.($this->FiaNivel).',
		FiaVerificar1 = '.($this->FiaVerificar1).',
		FiaVerificar2 = '.($this->FiaVerificar2).'
		WHERE FiaId = "'.($this->FiaId).'";';
				
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