<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsMensajeTexto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsMensajeTexto {

    public $MteId;
	public $MteReferencia;
	public $MteDestino;
	
	public $MteContenido;
   
	public $MteEstado;	
    public $MteTiempoCreacion;
    public $MteTiempoModificacion;
    public $MteEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarMensajeTextoId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(MteId,5),unsigned)) AS "MAXIMO"
			FROM tblmtemensajetexto';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->MteId = "CMT-10000";

			}else{
				$fila['MAXIMO']++;
				$this->MteId = "CMT-".$fila['MAXIMO'];					
			}	
			
				
		}
		
    public function MtdObtenerMensajeTexto(){

        $sql = 'SELECT 
        mte.MteId,
		mte.MteReferencia,
		DATE_FORMAT(mte.MteFecha, "%d/%m/%Y") AS "NMteFecha",

		mte.MteDestino,
		mte.MteContenido,

		mte.MteEstado,	
		DATE_FORMAT(mte.MteTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMteTiempoCreacion",
        DATE_FORMAT(mte.MteTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMteTiempoModificacion"

        FROM tblmtemensajetexto mte
			
        WHERE MteId = "'.$this->MteId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->MteId = $fila['MteId'];
				$this->MteReferencia = $fila['MteReferencia'];
				$this->MteFecha = $fila['NMteFecha'];
				
				$this->MteDestino = $fila['MteDestino'];						
				$this->MteContenido = $fila['MteContenido'];
			
				$this->MteEstado = $fila['MteEstado'];
				$this->MteTiempoCreacion = $fila['NMteTiempoCreacion'];
				$this->MteTiempoModificacion = $fila['NMteTiempoModificacion'];
	
				switch($this->MteEstado){
					
					case 1:
						$this->MteEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->MteEstadoDescripcion = "Enviado";
					break;
							
					case 6:
						$this->MteEstadoDescripcion = "Anulado";
					break;
				
				}
				
					
			}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerMensajeTextos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'MteId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
			
				
		if(!empty($oEstado)){
			$estado = ' AND mte.MteEstado = '.$oEstado;
		}	

		
			if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(mte.MteFecha)>="'.$oFechaInicio.'" AND DATE(mte.MteFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(mte.MteFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(mte.MteFecha)<="'.$oFechaFin.'"';		
			}			
		}
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				mte.MteId,
				   mte.MteId,
					mte.MteReferencia,
					DATE_FORMAT(mte.MteFecha, "%d/%m/%Y") AS "NMteFecha",
					
					mte.MteDestino,
					mte.MteContenido,
					
					mte.MteEstado,	
					DATE_FORMAT(mte.MteTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NMteTiempoCreacion",
					DATE_FORMAT(mte.MteTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NMteTiempoModificacion"
				
				FROM tblmtemensajetexto mte	
					
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$fecha.$cliente.$categoria.$orden.$paginacion;
								
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsMensajeTexto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$MensajeTexto = new $InsMensajeTexto();				
					
                    $MensajeTexto->MteId = $fila['MteId'];
					$MensajeTexto->MteReferencia = $fila['MteReferencia'];
					
					$MensajeTexto->MteFecha= $fila['NMteFecha'];
					
					$MensajeTexto->MteDestino= $fila['MteDestino'];
					$MensajeTexto->MteContenido= $fila['MteContenido'];
					
					$MensajeTexto->MteEstado = $fila['MteEstado'];					
                    $MensajeTexto->MteTiempoCreacion = $fila['NMteTiempoCreacion'];
                    $MensajeTexto->MteTiempoModificacion = $fila['NMteTiempoModificacion'];
					
					switch($MensajeTexto->MteEstado){
				
						case 1:
							$MensajeTexto->MteEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$MensajeTexto->MteEstadoDescripcion = "Enviado";
						break;
								
						case 6:
							$MensajeTexto->MteEstadoDescripcion = "Anulado";
						break;
					
					}
				
                    $MensajeTexto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $MensajeTexto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarMensajeTexto($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (MteId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (MteId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblmtemensajetexto WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarMensajeTexto() {

			$this->MtdGenerarMensajeTextoId();
		
			$sql = 'INSERT INTO tblmtemensajetexto (
			MteId,
			MteReferencia,
			MteFecha,
			
			MteDestino,
			MteContenido,
			
			MteEstado,
			MteTiempoCreacion,
			MteTiempoModificacion
			) 
			VALUES (
			"'.($this->MteId).'", 
			"'.($this->MteReferencia).'",
			"'.($this->MteFecha).'",
			
			"'.($this->MteDestino).'",
			"'.($this->MteContenido).'",
			
			'.($this->MteEstado).', 
			"'.($this->MteTiempoCreacion).'", 
			"'.($this->MteTiempoModificacion).'");';

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
	

	public function MtdEditarMensajeTexto() {
		

			$sql = 'UPDATE tblmtemensajetexto SET 
			MteReferencia = "'.($this->MteReferencia).'",
			MteFecha = "'.($this->MteFecha).'",
			
			MteDestino = "'.($this->MteDestino).'",
			MteContenido = "'.($this->MteContenido).'",
			
			MteEstado = '.($this->MteEstado).',
			MteTiempoModificacion = "'.($this->MteTiempoModificacion).'"
			WHERE MteId = "'.($this->MteId).'";';
			
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