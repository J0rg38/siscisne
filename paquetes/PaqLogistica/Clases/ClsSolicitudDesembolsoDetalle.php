<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSolicitudDesembolsoDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsSolicitudDesembolsoDetalle {

    public $SddId;
    public $SdsId;
	public $SreId;
	
	public $SddDescripcion;
	public $SddCantidad;
	public $SddImporte;

	public $SddEstado;	
    public $SddTiempoCreacion;
    public $SddTiempoModificacion;
    public $SddEliminado;

	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarSolicitudDesembolsoDetalleId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(SddId,5),unsigned)) AS "MAXIMO"
		FROM tblsddsolicituddesembolsodetalle';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->SddId = "SDD-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->SddId = "SDD-".$fila['MAXIMO'];					
		}	
				
	}
		
    public function MtdObtenerSolicitudDesembolsoDetalle(){

        $sql = 'SELECT 
        sdd.SddId,
		sdd.SdsId,
		sdd.SreId,
		sdd.SddDescripcion,
		sdd.SddCantidad,
		sdd.SddImporte,
		
		sdd.SddEstado,	
		DATE_FORMAT(sdd.SddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSddTiempoCreacion",
        DATE_FORMAT(sdd.SddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSddTiempoModificacion"
        FROM tblsddsolicituddesembolsodetalle sdd
        WHERE SddId = "'.$this->SddId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->SddId = $fila['SddId'];													
            $this->SdsId = $fila['SdsId'];
			$this->SreId = $fila['SreId'];
			$this->SddDescripcion = $fila['SddDescripcion'];
			$this->SddCantidad = $fila['SddCantidad'];
			$this->SddImporte = $fila['SddImporte'];
													
			$this->SddEstado = $fila['SddEstado'];
			$this->SddTiempoCreacion = $fila['NSddTiempoCreacion'];
			$this->SddTiempoModificacion = $fila['NSddTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerSolicitudDesembolsoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oSolicituDesembolso=NULL,$oServicioRepuesto=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND sdd.SddEstado = '.$oEstado;
		}	
		
		
		if(!empty($oSolicituDesembolso)){
			$encuesta = ' AND sdd.SdsId = "'.$oSolicituDesembolso.'"';
		}	
		
		if(!empty($oServicioRepuesto)){
			$epregunta = ' AND sdd.SreId = "'.$oServicioRepuesto.'"';
		}	
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				sdd.SddId,
				sdd.SdsId,
				sdd.SreId,
				
				sdd.SddDescripcion,
				sdd.SddCantidad,
				sdd.SddImporte,
				
				sdd.SddEstado,
				DATE_FORMAT(sdd.SddTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSddTiempoCreacion",
                DATE_FORMAT(sdd.SddTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSddTiempoModificacion",
                DATE_FORMAT(sds.SdsFecha, "%d/%m/%Y") AS "NSdsFecha",
				
				sre.SreNombre
				
				FROM tblsddsolicituddesembolsodetalle sdd	
					LEFT JOIN tblsdssolicituddesembolso sds
					ON sdd.SdsId = sds.SdsId
						LEFT JOIN tblsreserviciorepuesto sre
						ON sdd.SreId = sre.SreId
				WHERE 1 = 1 '.$filtrar.$epregunta.$tipo.$estado.$encuesta.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSolicitudDesembolsoDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$SolicitudDesembolsoDetalle = new $InsSolicitudDesembolsoDetalle();				
					
                    $SolicitudDesembolsoDetalle->SddId = $fila['SddId'];
					$SolicitudDesembolsoDetalle->SdsId= $fila['SdsId'];
					$SolicitudDesembolsoDetalle->SreId= $fila['SreId'];
					
					$SolicitudDesembolsoDetalle->SddDescripcion = $fila['SddDescripcion'];
					$SolicitudDesembolsoDetalle->SddCantidad = $fila['SddCantidad'];
					$SolicitudDesembolsoDetalle->SddImporte = $fila['SddImporte'];
				
					$SolicitudDesembolsoDetalle->SddEstado = $fila['SddEstado'];					
                    $SolicitudDesembolsoDetalle->SddTiempoCreacion = $fila['NSddTiempoCreacion'];
                    $SolicitudDesembolsoDetalle->SddTiempoModificacion = $fila['NSddTiempoModificacion'];    
					$SolicitudDesembolsoDetalle->SdsFecha = $fila['NSdsFecha'];    
					
					$SolicitudDesembolsoDetalle->SreNombre = $fila['SreNombre'];    

					
                    $SolicitudDesembolsoDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $SolicitudDesembolsoDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		 public function MtdObtenerSolicitudDesembolsoDetallesValor($oFuncion="SUM",$oParametro="SreId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oSolicituDesembolso=NULL,$oServicioRepuesto=NULL,$oSdsuestaRespuesta=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

		if(!empty($oCampo) && !empty($oFiltro)){
			$oFiltro = str_replace(" ","%",$oFiltro);
			switch($oCondicion){
				case "esigual":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
				break;

				case "noesigual":
					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
				break;
				
				case "comienza":
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
				case "termina":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
				break;
				
				case "contiene":
					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
				break;
				
				case "nocontiene":
					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
				break;
				
				default:
					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
				break;
				
			}
			
			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND sdd.SddEstado = '.$oEstado;
		}	
		
		
		if(!empty($oSolicituDesembolso)){
			$encuesta = ' AND sdd.SdsId = "'.$oSolicituDesembolso.'"';
		}	
		
		if(!empty($oServicioRepuesto)){
			$epregunta = ' AND sdd.SreId = "'.$oServicioRepuesto.'"';
		}	
		
		if(!empty($oSdsuestaRespuesta)){
			$erespuesta = ' AND sdd.SddDescripcion = "'.$oSdsuestaRespuesta.'"';
		}	
		
		
		if(!empty($oFechaInicio)){			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(sds.SdsFecha)>="'.$oFechaInicio.'" AND DATE(sds.SdsFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(cve.SdsFecha)>="'.$oFechaInicio.'"';
			}			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(cve.SdsFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(sdd.SddTiempoCreacion) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(sdd.SddTiempoCreacion) ="'.($oAno).'"';
		}
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				'.$funcion.' AS "RESULTADO"
				FROM tblsddsolicituddesembolsodetalle sdd	
					LEFT JOIN tblsdssolicituddesembolso sds
					ON sdd.SdsId = sds.SdsId
					
				WHERE 1 = 1 '.$filtrar.$tipo.$fecha.$epregunta.$erespuesta.$estado.$encuesta.$orden.$paginacion;
				
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];	
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarSolicitudDesembolsoDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (SddId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SddId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblsddsolicituddesembolsodetalle WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarSolicitudDesembolsoDetalle() {
	
			$this->MtdGenerarSolicitudDesembolsoDetalleId();
		
			$sql = 'INSERT INTO tblsddsolicituddesembolsodetalle (
			SddId,
			SdsId,
			
			SreId,
			SddDescripcion,
			SddCantidad,
			SddImporte,
			
			SddEstado,
			SddTiempoCreacion,
			SddTiempoModificacion) 
			VALUES (
			"'.($this->SddId).'", 
			"'.($this->SdsId).'",
			
			"'.($this->SreId).'", 
			"'.($this->SddDescripcion).'", 
			'.(empty($this->SddCantidad)?"NULL,":''.$this->SddCantidad.',').'
			'.(empty($this->SddImporte)?"NULL,":''.$this->SddImporte.',').'
			
			'.($this->SddEstado).', 			
			"'.($this->SddTiempoCreacion).'", 
			"'.($this->SddTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarSolicitudDesembolsoDetalle() {
		
		$sql = 'UPDATE tblsddsolicituddesembolsodetalle SET 
		SreId = "'.($this->SreId).'",
		SddDescripcion = "'.($this->SddDescripcion).'",
		'.(empty($this->SddCantidad)?'SddCantidad = NULL, ':'SddCantidad = '.$this->SddCantidad.',').'
		'.(empty($this->SddImporte)?'SddImporte = NULL, ':'SddImporte = '.$this->SddImporte.',').'
		
		SddEstado = "'.($this->SddEstado).'",
		SddTiempoModificacion = "'.($this->SddTiempoModificacion).'"
		WHERE SddId = "'.($this->SddId).'";';
		
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