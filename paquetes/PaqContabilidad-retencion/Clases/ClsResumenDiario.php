<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenDiario
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsResumenDiario {

    public $RdiId;
	
	
	
	public $RdiFecha;
	public $RdiFechaReferencia;
	public $RdiNumeracion;
	
    public $RdiTiempoCreacion;
    public $RdiTiempoModificacion;
    public $RdiEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	
	
	public function MtdGenerarResumenDiarioId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RdiId,5),unsigned)) AS "MAXIMO"
			FROM tblrdiresumendiario';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RdiId = "RDI-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RdiId = "RDI-".$fila['MAXIMO'];					
			}	
			
				
	}
		
		
	public function MtdGenerarResumenDiarioNumeracion() {

	/*	$sql = 'SELECT	
		MAX(CONVERT(rdi.RdiNumeracion,unsigned)) AS "MAXIMO"
		FROM tblrdiresumendiario rdi 
		WHERE rdi.RdiFecha = DATE(NOW());';			*/
		
			$sql = 'SELECT	
		MAX((rdi.RdiNumeracion)) AS "MAXIMO"
		FROM tblrdiresumendiario rdi 
		WHERE rdi.RdiFecha = DATE(NOW());';			
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){	
			$this->RdiNumeracion = "1";			
		}else{
			$fila['MAXIMO']++;
			$this->RdiNumeracion = ($fila['MAXIMO']);	
		}
		
		return $this->RdiNumeracion;
			
	}
	
	
	
		
    public function MtdObtenerResumenDiario(){

        $sql = 'SELECT 
        rdi.RdiId,
	
		DATE_FORMAT(rdi.RdiFecha, "%d/%m/%Y") AS "NRdiFecha",
		DATE_FORMAT(rdi.RdiFechaReferencia, "%d/%m/%Y") AS "NRdiFechaReferencia",
		rdi.RdiNumeracion,
		rdi.RdiArchivo,
		rdi.RdiEstado,
		
		rdi.RdiSunatRespuestaResumenTicket,
		DATE_FORMAT(rdi.RdiSunatRespuestaResumenFecha, "%d/%m/%Y") AS "NRdiSunatRespuestaResumenFecha",
		rdi.RdiSunatRespuestaResumenHora,
		rdi.RdiSunatRespuestaResumenCodigo,
		rdi.RdiSunatRespuestaResumenContenido,
		DATE_FORMAT(rdi.RdiSunatRespuestaResumenTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRdiSunatRespuestaResumenTiempoCreacion",
		rdi.RdiSunatRespuestaObservacion,
		rdi.RdiSunatRespuestaTicket,
		rdi.RdiSunatRespuestaTicketEstado,
		
		DATE_FORMAT(rdi.RdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRdiTiempoCreacion",
        DATE_FORMAT(rdi.RdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRdiTiempoModificacion"
		
        FROM tblrdiresumendiario rdi
        WHERE rdi.RdiId = "'.$this->RdiId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->RdiId = $fila['RdiId'];
			
			$this->RdiFecha = $fila['NRdiFecha'];
			$this->RdiFechaReferencia = $fila['NRdiFechaReferencia'];
			$this->RdiNumeracion = $fila['RdiNumeracion'];
			
			$this->RdiArchivo = $fila['RdiArchivo'];
			$this->RdiEstado = $fila['RdiEstado'];
			
			$this->RdiSunatRespuestaResumenTicket = $fila['RdiSunatRespuestaResumenTicket'];
			$this->RdiSunatRespuestaResumenFecha = $fila['NRdiSunatRespuestaResumenFecha'];
			$this->RdiSunatRespuestaResumenHora = $fila['RdiSunatRespuestaResumenHora'];
			$this->RdiSunatRespuestaResumenCodigo = $fila['RdiSunatRespuestaResumenCodigo'];
			$this->RdiSunatRespuestaResumenContenido = $fila['RdiSunatRespuestaResumenContenido'];
			$this->RdiSunatRespuestaResumenTiempoCreacion = $fila['NRdiSunatRespuestaResumenTiempoCreacion'];
			$this->RdiSunatRespuestaObservacion = $fila['RdiSunatRespuestaObservacion'];
			$this->RdiSunatRespuestaTicket = $fila['RdiSunatRespuestaTicket'];
			$this->RdiSunatRespuestaTicketEstado = $fila['RdiSunatRespuestaTicketEstado'];
			
			$this->RdiTiempoCreacion = $fila['NRdiTiempoCreacion'];
			$this->RdiTiempoModificacion = $fila['NRdiTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerResumenDiarios($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RdiId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL) {

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

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(rdi.RdiFecha)>="'.$oFechaInicio.'" AND DATE(rdi.RdiFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(rdi.RdiFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(rdi.RdiFecha)<="'.$oFechaFin.'"';		
			}			
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				rdi.RdiId,
				
				DATE_FORMAT(rdi.RdiFecha, "%d/%m/%Y") AS "NRdiFecha",
				DATE_FORMAT(rdi.RdiFechaReferencia, "%d/%m/%Y") AS "NRdiFechaReferencia",
				rdi.RdiNumeracion,
				rdi.RdiArchivo,
				
				rdi.RdiSunatRespuestaResumenTicket,
				DATE_FORMAT(rdi.RdiSunatRespuestaResumenFecha, "%d/%m/%Y") AS "NRdiSunatRespuestaResumenFecha",
				rdi.RdiSunatRespuestaResumenHora,
				rdi.RdiSunatRespuestaResumenCodigo,
				rdi.RdiSunatRespuestaResumenContenido,
				DATE_FORMAT(rdi.RdiSunatRespuestaResumenTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRdiSunatRespuestaResumenTiempoCreacion",
				rdi.RdiSunatRespuestaObservacion,
				rdi.RdiSunatRespuestaTicket,
				rdi.RdiSunatRespuestaTicketEstado,
				
				rdi.RdiEstado,
				
				DATE_FORMAT(rdi.RdiTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRdiTiempoCreacion",
				DATE_FORMAT(rdi.RdiTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRdiTiempoModificacion"
				
				FROM tblrdiresumendiario rdi
					
				WHERE 1 = 1 '.$filtrar.$fecha.$moneda.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsResumenDiario = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ResumenDiario = new $InsResumenDiario();
                    $ResumenDiario->RdiId = $fila['RdiId'];
					
					$ResumenDiario->RdiFecha = $fila['NRdiFecha'];
					$ResumenDiario->RdiFechaReferencia = $fila['NRdiFechaReferencia'];
					$ResumenDiario->RdiNumeracion = $fila['RdiNumeracion'];
					
					$ResumenDiario->RdiArchivo = $fila['RdiArchivo'];
					
					$ResumenDiario->RdiSunatRespuestaResumenTicket = $fila['RdiSunatRespuestaResumenTicket'];
					$ResumenDiario->RdiSunatRespuestaResumenFecha = $fila['NRdiSunatRespuestaResumenFecha'];
					$ResumenDiario->RdiSunatRespuestaResumenHora = $fila['RdiSunatRespuestaResumenHora'];
					$ResumenDiario->RdiSunatRespuestaResumenCodigo = $fila['RdiSunatRespuestaResumenCodigo'];
					$ResumenDiario->RdiSunatRespuestaResumenContenido = $fila['RdiSunatRespuestaResumenContenido'];
					$ResumenDiario->RdiSunatRespuestaResumenTiempoCreacion = $fila['NRdiSunatRespuestaResumenTiempoCreacion'];
					$ResumenDiario->RdiSunatRespuestaObservacion = $fila['RdiSunatRespuestaObservacion'];
					$ResumenDiario->RdiSunatRespuestaTicket = $fila['RdiSunatRespuestaTicket'];
					$ResumenDiario->RdiSunatRespuestaTicketEstado = $fila['RdiSunatRespuestaTicketEstado'];

					$ResumenDiario->RdiEstado = $fila['RdiEstado'];					
					$ResumenDiario->RdiTiempoCreacion = $fila['NRdiTiempoCreacion'];
					$ResumenDiario->RdiTiempoModificacion = $fila['NRdiTiempoModificacion'];
			
			
                    $ResumenDiario->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ResumenDiario;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarResumenDiario($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (RdiId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (RdiId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblrdiresumendiario WHERE '.$eliminar;

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
	
	
				
	public function MtdRegistrarResumenDiario() {
	
			$this->MtdGenerarResumenDiarioId();
		
			 $sql = 'INSERT INTO tblrdiresumendiario (
			RdiId,
			
			RdiFecha,
			RdiFechaReferencia,
			RdiNumeracion,
			
			RdiArchivo,
			RdiEstado,
			
			RdiSunatRespuestaResumenTicket,
			RdiSunatRespuestaResumenFecha,
			RdiSunatRespuestaResumenHora,
			RdiSunatRespuestaResumenCodigo,
			RdiSunatRespuestaResumenContenido,
			RdiSunatRespuestaResumenTiempoCreacion,
			RdiSunatRespuestaObservacion,
			RdiSunatRespuestaTicket,
			RdiSunatRespuestaTicketEstado,
				
			RdiTiempoCreacion,
			RdiTiempoModificacion
			) 
			VALUES (
			"'.($this->RdiId).'", 
			
			"'.($this->RdiFecha).'", 
			"'.($this->RdiFechaReferencia).'", 
			"'.($this->RdiNumeracion).'", 
			
			"'.($this->RdiArchivo).'", 
			'.($this->RdiEstado).', 
			
			
			"'.($this->RdiSunatRespuestaResumenTicket).'", 
			'.(empty($this->RdiSunatRespuestaResumenFecha)?'NULL, ':'"'.$this->RdiSunatRespuestaResumenFecha.'",').'
			"'.($this->RdiSunatRespuestaResumenHora).'", 
			"'.($this->RdiSunatRespuestaResumenCodigo).'", 
			"'.($this->RdiSunatRespuestaResumenContenido).'", 
			"'.($this->RdiSunatRespuestaResumenTiempoCreacion).'", 
			"'.($this->RdiSunatRespuestaObservacion).'", 
			"'.($this->RdiSunatRespuestaTicket).'", 
			"'.($this->RdiSunatRespuestaTicketEstado).'", 
			
			"'.($this->RdiTiempoCreacion).'", 
			"'.($this->RdiTiempoModificacion).'");';					

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
	
	public function MtdEdicbjResumenDiario() {
		
			$sql = 'UPDATE tblrdiresumendiario SET 
			
			RdiFecha = "'.($this->RdiFecha).'",
			RdiFechaReferencia = "'.($this->RdiFechaReferencia).'",
			RdiNumeracion = "'.($this->RdiNumeracion).'",
			
			RdiArchivo = "'.($this->RdiArchivo).'",
			RdiEstado = '.($this->RdiEstado).',
			
			RdiSunatRespuestaResumenTicket = "'.($this->RdiSunatRespuestaResumenTicket).'",
			'.(empty($this->RdiSunatRespuestaResumenFecha)?'RdiSunatRespuestaResumenFecha = NULL, ':'RdiSunatRespuestaResumenFecha = "'.$this->RdiSunatRespuestaResumenFecha.'",').'
			RdiSunatRespuestaResumenHora = "'.($this->RdiSunatRespuestaResumenHora).'",
			RdiSunatRespuestaResumenCodigo = "'.($this->RdiSunatRespuestaResumenCodigo).'",
			RdiSunatRespuestaResumenContenido = "'.($this->RdiSunatRespuestaResumenContenido).'",
			RdiSunatRespuestaResumenTiempoCreacion = "'.($this->RdiSunatRespuestaResumenTiempoCreacion).'",
			RdiSunatRespuestaObservacion = "'.($this->RdiSunatRespuestaObservacion).'",
			RdiSunatRespuestaTicket = "'.($this->RdiSunatRespuestaTicket).'",
			RdiSunatRespuestaTicketEstado = "'.($this->RdiSunatRespuestaTicketEstado).'",

			RdiTiempoModificacion = "'.($this->RdiTiempoModificacion).'"
			
			WHERE RdiId = "'.($this->RdiId).'";';
			
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
		
		
		
		public function MtdEditarResumenDiarioDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblrdiresumendiario SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			RdiTiempoModificacion = NOW()
			WHERE RdiId = "'.($oId).'";';
			
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