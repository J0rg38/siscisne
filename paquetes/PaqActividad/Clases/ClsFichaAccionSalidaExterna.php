<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsFichaAccionSalidaExterna
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsFichaAccionSalidaExterna {

    public $FsxId;
	public $FccId;
	public $PrvId;
	public $FsxFechaSalida;
	public $FsxFechaFinalizacion;
	public $FsxEstado;	
	public $FsxTiempoCreacion;
	public $FsxTiempoModificacion;
    public $FsxEliminado;
	
	public $PrvNombreCompleto;
	public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;
	public $TdoId;
	public $TdoNombre;
		
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

	private function MtdGenerarFichaAccionSalidaExternaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(FsxId,5),unsigned)) AS "MAXIMO"
			FROM tblfsxfichaaccionsalidaexterna';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->FsxId = "FSX-10000";
			}else{
				$fila['MAXIMO']++;
				$this->FsxId = "FSX-".$fila['MAXIMO'];					
			}
				
		}
		

    public function MtdObtenerFichaAccionSalidaExternas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'FsxId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFichaAccion=NULL,$oEstado=NULL) {

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
		
		if(!empty($oFichaAccion)){
			$faccion = ' AND fsx.FccId = "'.$oFichaAccion.'"';
		}
		
		if(!empty($oEstado)){
			$estado = ' AND fsx.FsxEstado = '.$oEstado.' ';
		}
		
		
		$sql = '
			SELECT
			SQL_CALC_FOUND_ROWS 
			fsx.FsxId,			
			fsx.FccId,
			fsx.PrvId,
			DATE_FORMAT(fsx.FsxFechaSalida, "%d/%m/%Y") AS "NFsxFechaSalida",
			DATE_FORMAT(fsx.FsxFechaFinalizacion, "%d/%m/%Y") AS "NFsxFechaFinalizacion",
		
			fsx.FsxEstado,
			DATE_FORMAT(fsx.FsxTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NFsxTiempoCreacion",
	        DATE_FORMAT(fsx.FsxTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NFsxTiempoModificacion",
			
			prv.PrvNumeroDocumento,
			prv.PrvNombreCompleto,
			prv.PrvNombre,
			prv.PrvApellidoPaterno,
			prv.PrvApellidoMaterno,
			prv.TdoId,
			tdo.TdoNombre
			
			FROM tblfsxfichaaccionsalidaexterna fsx
				LEFT JOIN tblprvproveedor prv
				ON fsx.PrvId = prv.PrvId
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
			WHERE  1 = 1 '.$faccion.$estado.$filtrar.$orden.$paginacion;	
		
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsFichaAccionSalidaExterna = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$FichaAccionSalidaExterna = new $InsFichaAccionSalidaExterna();
                    $FichaAccionSalidaExterna->FsxId = $fila['FsxId'];
					$FichaAccionSalidaExterna->FccId = $fila['FccId'];
					$FichaAccionSalidaExterna->PrvId = $fila['PrvId'];
					$FichaAccionSalidaExterna->FsxFechaSalida = $fila['NFsxFechaSalida'];
					$FichaAccionSalidaExterna->FsxFechaFinalizacion = $fila['NFsxFechaFinalizacion'];
					$FichaAccionSalidaExterna->FsxEstado = $fila['FsxEstado'];
					$FichaAccionSalidaExterna->FsxTiempoCreacion = $fila['NFsxTiempoCreacion'];  
					$FichaAccionSalidaExterna->FsxTiempoModificacion = $fila['NFsxTiempoModificacion'];

					$FichaAccionSalidaExterna->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$FichaAccionSalidaExterna->PrvNombreCompleto = $fila['PrvNombreCompleto'];
					$FichaAccionSalidaExterna->PrvNombre = $fila['PrvNombre'];
					$FichaAccionSalidaExterna->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$FichaAccionSalidaExterna->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$FichaAccionSalidaExterna->TdoId = $fila['TdoId'];
					$FichaAccionSalidaExterna->TdoNombre = $fila['TdoNombre'];

                    $FichaAccionSalidaExterna->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $FichaAccionSalidaExterna;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
		
	//Accion eliminar	 
	
	public function MtdEliminarFichaAccionSalidaExterna($oElementos) {

		$error = false;
		
		$elementos = explode("#",$oElementos);
	
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){				
					if($i==count($elementos)){						
						$eliminar .= '  (FsxId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (FsxId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
				
				$sql = 'DELETE FROM tblfsxfichaaccionsalidaexterna 
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
	
	
	public function MtdRegistrarFichaAccionSalidaExterna() {
	
			$this->MtdGenerarFichaAccionSalidaExternaId();
			
			$sql = 'INSERT INTO tblfsxfichaaccionsalidaexterna (
			FsxId,
			FccId,	
			PrvId,
			FsxFechaSalida,
			FsxFechaFinalizacion,
			FsxEstado,
			FsxTiempoCreacion,
			FsxTiempoModificacion
			) 
			VALUES (
			"'.($this->FsxId).'", 
			"'.($this->FccId).'", 
			
			
			'.(empty($this->PrvId)?'NULL,':'"'.$this->PrvId.'",').'	
		
			'.(empty($this->FsxFechaSalida)?'NULL,':'"'.$this->FsxFechaSalida.'",').'	
			'.(empty($this->FsxFechaFinalizacion)?'NULL,':'"'.$this->FsxFechaFinalizacion.'",').'	
			
			'.($this->FsxEstado).',
			"'.($this->FsxTiempoCreacion).'",
			"'.($this->FsxTiempoModificacion).'");';
		
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
	
	public function MtdEditarFichaAccionSalidaExterna() {

		$sql = 'UPDATE tblfsxfichaaccionsalidaexterna SET 	
		
		'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
		
		'.(empty($this->FsxFechaSalida)?'FsxFechaSalida = NULL, ':'FsxFechaSalida = "'.$this->FsxFechaSalida.'",').'
		'.(empty($this->FsxFechaFinalizacion)?'FsxFechaFinalizacion = NULL, ':'FsxFechaFinalizacion = "'.$this->FsxFechaFinalizacion.'",').'
		
		FsxTiempoModificacion = "'.($this->FsxTiempoModificacion).'"

		WHERE FsxId = "'.($this->FsxId).'";';
				
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