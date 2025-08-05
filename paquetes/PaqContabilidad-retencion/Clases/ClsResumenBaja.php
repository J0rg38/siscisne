<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsResumenBaja
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsResumenBaja {

    public $RbaId;
	
	public $FacId;
	public $FtaId;
	
    public $BolId;
	public $BtaId;
	
	public $NcrId;
	public $NctId;
	
	public $NdbId;
	public $NdtId;
	
	public $RbaFecha;
	public $RbaNumeracion;
	
    public $RbaTiempoCreacion;
    public $RbaTiempoModificacion;
    public $RbaEliminado;
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
	
	
	
	
	public function MtdGenerarResumenBajaId() {
			
			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(RbaId,5),unsigned)) AS "MAXIMO"
			FROM tblrbaresumenbaja';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->RbaId = "RBA-10000";

			}else{
				$fila['MAXIMO']++;
				$this->RbaId = "RBA-".$fila['MAXIMO'];					
			}	
			
				
		}
		
		
	public function MtdGenerarResumenBajaNumeracion() {

	/*	$sql = 'SELECT	
		MAX(CONVERT(rba.RbaNumeracion,unsigned)) AS "MAXIMO"
		FROM tblrbaresumenbaja rba 
		WHERE rba.RbaFecha = DATE(NOW());';			*/
		
			$sql = 'SELECT	
		MAX((rba.RbaNumeracion)) AS "MAXIMO"
		FROM tblrbaresumenbaja rba 
		WHERE rba.RbaFecha = DATE(NOW());';			
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){	
			$this->RbaNumeracion = "1";			
		}else{
			$fila['MAXIMO']++;
			$this->RbaNumeracion = ($fila['MAXIMO']);	
		}
		
		return $this->RbaNumeracion;
			
	}
	
	
	
		
    public function MtdObtenerResumenBaja(){

        $sql = 'SELECT 
        rba.RbaId,
		
        rba.FacId,
		rba.FtaId,

		rba.BolId,
		rba.BtaId,

		rba.NcrId,
		rba.NctId,

		rba.NdbId,
		rba.NdtId,

		DATE_FORMAT(rba.RbaFecha, "%d/%m/%Y") AS "NRbaFecha",
		rba.RbaNumeracion,
		rba.RbaArchivo,
		rba.RbaEstado,

		rba.RbaSunatRespuestaResumenTicket,
		DATE_FORMAT(rba.RbaSunatRespuestaResumenFecha, "%d/%m/%Y") AS "NRbaSunatRespuestaResumenFecha",
		rba.RbaSunatRespuestaResumenHora,
		rba.RbaSunatRespuestaResumenCodigo,
		rba.RbaSunatRespuestaResumenContenido,
		DATE_FORMAT(rba.RbaSunatRespuestaResumenTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRbaSunatRespuestaResumenTiempoCreacion",
		rba.RbaSunatRespuestaObservacion,
		rba.RbaSunatRespuestaTicket,
		rba.RbaSunatRespuestaTicketEstado,

		DATE_FORMAT(rba.RbaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRbaTiempoCreacion",
        DATE_FORMAT(rba.RbaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRbaTiempoModificacion"
		
        FROM tblrbaresumenbaja rba
        WHERE rba.RbaId = "'.$this->RbaId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->RbaId = $fila['RbaId'];
			
			$this->FacId = $fila['FacId'];
			$this->FtaId = $fila['FtaId'];
			
			$this->BolId = $fila['BolId'];
			$this->BtaId = $fila['BtaId'];
			
			$this->NcrId = $fila['NcrId'];
			$this->NctId = $fila['NctId'];
			
			$this->NdbId = $fila['NdbId'];
			$this->NdtId = $fila['NdtId'];
			
			$this->RbaFecha = $fila['NRbaFecha'];
			$this->RbaNumeracion = $fila['RbaNumeracion'];
			
			$this->RbaArchivo = $fila['RbaArchivo'];
			$this->RbaEstado = $fila['RbaEstado'];
			
			$this->RbaSunatRespuestaResumenTicket = $fila['RbaSunatRespuestaResumenTicket'];
			$this->RbaSunatRespuestaResumenFecha = $fila['NRbaSunatRespuestaResumenFecha'];
			$this->RbaSunatRespuestaResumenHora = $fila['RbaSunatRespuestaResumenHora'];
			$this->RbaSunatRespuestaResumenCodigo = $fila['RbaSunatRespuestaResumenCodigo'];
			$this->RbaSunatRespuestaResumenContenido = $fila['RbaSunatRespuestaResumenContenido'];
			$this->RbaSunatRespuestaResumenTiempoCreacion = $fila['NRbaSunatRespuestaResumenTiempoCreacion'];
			$this->RbaSunatRespuestaObservacion = $fila['RbaSunatRespuestaObservacion'];
			$this->RbaSunatRespuestaTicket = $fila['RbaSunatRespuestaTicket'];
			$this->RbaSunatRespuestaTicketEstado = $fila['RbaSunatRespuestaTicketEstado'];

			$this->RbaTiempoCreacion = $fila['NRbaTiempoCreacion'];
			$this->RbaTiempoModificacion = $fila['NRbaTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerResumenBajas($oCampo=NULL,$oFiltro=NULL,$oOrden = 'RbaId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL) {

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
				$fecha = ' AND DATE(rba.RbaFecha)>="'.$oFechaInicio.'" AND DATE(rba.RbaFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(rba.RbaFecha)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(rba.RbaFecha)<="'.$oFechaFin.'"';		
			}			
		}

			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				
				rba.FacId,
				rba.FtaId,
				
				rba.BolId,
				rba.BtaId,
				
				rba.NcrId,
				rba.NctId,
				
				rba.NdbId,
				rba.NdtId
				
				DATE_FORMAT(rba.RbaFecha, "%d/%m/%Y") AS "NRbaFecha",
				rba.RbaNumeracion,
				rba.RbaArchivo,
				
				rba.RbaSunatRespuestaResumenTicket,
				DATE_FORMAT(rba.RbaSunatRespuestaResumenFecha, "%d/%m/%Y") AS "NRbaSunatRespuestaResumenFecha",
				rba.RbaSunatRespuestaResumenHora,
				rba.RbaSunatRespuestaResumenCodigo,
				rba.RbaSunatRespuestaResumenContenido,
				DATE_FORMAT(rba.RbaSunatRespuestaResumenTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRbaSunatRespuestaResumenTiempoCreacion",
				rba.RbaSunatRespuestaObservacion,
				rba.RbaSunatRespuestaTicket,
				rba.RbaSunatRespuestaTicketEstado,
				
				rba.RbaEstado,
				
				DATE_FORMAT(rba.RbaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NRbaTiempoCreacion",
				DATE_FORMAT(rba.RbaTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NRbaTiempoModificacion"
				
				FROM tblrbaresumenbaja rba
					
				WHERE 1 = 1 '.$filtrar.$fecha.$moneda.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsResumenBaja = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$ResumenBaja = new $InsResumenBaja();
                    $ResumenBaja->RbaId = $fila['RbaId'];
					
					$ResumenBaja->FacId = $fila['FacId'];
					$ResumenBaja->FtaId = $fila['FtaId'];
					
					$ResumenBaja->BolId = $fila['BolId'];
					$ResumenBaja->BtaId = $fila['BtaId'];
					
					$ResumenBaja->NcrId = $fila['NcrId'];
					$ResumenBaja->NctId = $fila['NctId'];
					
					$ResumenBaja->NdbId = $fila['NdbId'];
					$ResumenBaja->NdtId = $fila['NdtId'];
					
					$ResumenBaja->RbaFecha = $fila['NRbaFecha'];
					$ResumenBaja->RbaNumeracion = $fila['RbaNumeracion'];
					
					$ResumenBaja->RbaArchivo = $fila['RbaArchivo'];
					
					$ResumenBaja->RbaSunatRespuestaResumenTicket = $fila['RbaSunatRespuestaResumenTicket'];
					$ResumenBaja->RbaSunatRespuestaResumenFecha = $fila['NRbaSunatRespuestaResumenFecha'];
					$ResumenBaja->RbaSunatRespuestaResumenHora = $fila['RbaSunatRespuestaResumenHora'];
					$ResumenBaja->RbaSunatRespuestaResumenCodigo = $fila['RbaSunatRespuestaResumenCodigo'];
					$ResumenBaja->RbaSunatRespuestaResumenContenido = $fila['RbaSunatRespuestaResumenContenido'];
					$ResumenBaja->RbaSunatRespuestaResumenTiempoCreacion = $fila['NRbaSunatRespuestaResumenTiempoCreacion'];
					$ResumenBaja->RbaSunatRespuestaObservacion = $fila['RbaSunatRespuestaObservacion'];
					$ResumenBaja->RbaSunatRespuestaTicket = $fila['RbaSunatRespuestaTicket'];
					$ResumenBaja->RbaSunatRespuestaTicketEstado = $fila['RbaSunatRespuestaTicketEstado'];

					$ResumenBaja->RbaEstado = $fila['RbaEstado'];					
					$ResumenBaja->RbaTiempoCreacion = $fila['NRbaTiempoCreacion'];
					$ResumenBaja->RbaTiempoModificacion = $fila['NRbaTiempoModificacion'];
			
			
                    $ResumenBaja->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ResumenBaja;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
				
		

	
	//Accion eliminar	 
	
	public function MtdEliminarResumenBaja($oElementos) {
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (RbaId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (RbaId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

		
			$sql = 'DELETE FROM tblrbaresumenbaja WHERE '.$eliminar;

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
	
	
				
	public function MtdRegistrarResumenBaja() {
	
			$this->MtdGenerarResumenBajaId();
		
			 $sql = 'INSERT INTO tblrbaresumenbaja (
			RbaId,
			
			FacId,			
			FtaId, 
			
			BolId,
			BtaId,
			
			NcrId,
			NctId,
			
			NdbId,
			NdtId,
			
			RbaFecha,
			RbaNumeracion,
			
			RbaArchivo,
			RbaEstado,
			
			RbaSunatRespuestaResumenTicket,
			RbaSunatRespuestaResumenFecha,
			RbaSunatRespuestaResumenHora,
			RbaSunatRespuestaResumenCodigo,
			RbaSunatRespuestaResumenContenido,
			RbaSunatRespuestaResumenTiempoCreacion,
			RbaSunatRespuestaObservacion,
			RbaSunatRespuestaTicket,
			RbaSunatRespuestaTicketEstado,
				
			RbaTiempoCreacion,
			RbaTiempoModificacion
			) 
			VALUES (
			"'.($this->RbaId).'", 
			'.(empty($this->FacId)?'NULL, ':'"'.$this->FacId.'",').'
			'.(empty($this->FtaId)?'NULL, ':'"'.$this->FtaId.'",').'
			
			'.(empty($this->BolId)?'NULL, ':'"'.$this->BolId.'",').'
			'.(empty($this->BtaId)?'NULL, ':'"'.$this->BtaId.'",').'
			
			'.(empty($this->NcrId)?'NULL, ':'"'.$this->NcrId.'",').'
			'.(empty($this->NctId)?'NULL, ':'"'.$this->NctId.'",').'
			
			'.(empty($this->NdbId)?'NULL, ':'"'.$this->NdbId.'",').'
			'.(empty($this->NdtId)?'NULL, ':'"'.$this->NdtId.'",').'
			
			"'.($this->RbaFecha).'", 
			"'.($this->RbaNumeracion).'", 
			
			"'.($this->RbaArchivo).'", 
			'.($this->RbaEstado).', 
			
			
			"'.($this->RbaSunatRespuestaResumenTicket).'", 
			'.(empty($this->RbaSunatRespuestaResumenFecha)?'NULL, ':'"'.$this->RbaSunatRespuestaResumenFecha.'",').'
			"'.($this->RbaSunatRespuestaResumenHora).'", 
			"'.($this->RbaSunatRespuestaResumenCodigo).'", 
			"'.($this->RbaSunatRespuestaResumenContenido).'", 
			"'.($this->RbaSunatRespuestaResumenTiempoCreacion).'", 
			"'.($this->RbaSunatRespuestaObservacion).'", 
			"'.($this->RbaSunatRespuestaTicket).'", 
			"'.($this->RbaSunatRespuestaTicketEstado).'", 
			
			
			"'.($this->RbaTiempoCreacion).'", 
			"'.($this->RbaTiempoModificacion).'");';					

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
	
	public function MtdEdicbjResumenBaja() {
		
			$sql = 'UPDATE tblrbaresumenbaja SET 
			
			'.(empty($this->FacId)?'FacId = NULL, ':'FacId = "'.$this->FacId.'",').'
			'.(empty($this->FtaId)?'FtaId = NULL, ':'FtaId = "'.$this->FtaId.'",').'
			
			'.(empty($this->BolId)?'BolId = NULL, ':'BolId = "'.$this->BolId.'",').'
			'.(empty($this->BtaId)?'BtaId = NULL, ':'BtaId = "'.$this->BtaId.'",').'
			
			'.(empty($this->NcrId)?'NcrId = NULL, ':'NcrId = "'.$this->NcrId.'",').'
			'.(empty($this->NctId)?'NctId = NULL, ':'NctId = "'.$this->NctId.'",').'
			
			'.(empty($this->NdbId)?'NdbId = NULL, ':'NdbId = "'.$this->NdbId.'",').'
			'.(empty($this->NdtId)?'NdtId = NULL, ':'NdtId = "'.$this->NdtId.'",').'
			
			RbaFecha = "'.($this->RbaFecha).'",
			RbaNumeracion = "'.($this->RbaNumeracion).'",
			
			RbaArchivo = "'.($this->RbaArchivo).'",
			RbaEstado = '.($this->RbaEstado).',
			
			RbaSunatRespuestaResumenTicket = "'.($this->RbaSunatRespuestaResumenTicket).'",
			'.(empty($this->RbaSunatRespuestaResumenFecha)?'RbaSunatRespuestaResumenFecha = NULL, ':'RbaSunatRespuestaResumenFecha = "'.$this->RbaSunatRespuestaResumenFecha.'",').'
			RbaSunatRespuestaResumenHora = "'.($this->RbaSunatRespuestaResumenHora).'",
			RbaSunatRespuestaResumenCodigo = "'.($this->RbaSunatRespuestaResumenCodigo).'",
			RbaSunatRespuestaResumenContenido = "'.($this->RbaSunatRespuestaResumenContenido).'",
			RbaSunatRespuestaResumenTiempoCreacion = "'.($this->RbaSunatRespuestaResumenTiempoCreacion).'",
			RbaSunatRespuestaObservacion = "'.($this->RbaSunatRespuestaObservacion).'",
			RbaSunatRespuestaTicket = "'.($this->RbaSunatRespuestaTicket).'",
			RbaSunatRespuestaTicketEstado = "'.($this->RbaSunatRespuestaTicketEstado).'",

			RbaTiempoModificacion = "'.($this->RbaTiempoModificacion).'"
			
			WHERE RbaId = "'.($this->RbaId).'";';
			
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
		
		
		
		public function MtdEditarResumenBajaDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblrbaresumenbaja SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			RbaTiempoModificacion = NOW()
			WHERE RbaId = "'.($oId).'";';
			
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