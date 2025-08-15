<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsEncuestaDetalle
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsEncuestaDetalle {

    public $EdeId;
    public $EncId;
	public $EprId;
	public $EdeRespuesta;
	
	
	public $EdeEstado;	
    public $EdeTiempoCreacion;
    public $EdeTiempoModificacion;
    public $EdeEliminado;

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
		
	public function MtdGenerarEncuestaDetalleId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(EdeId,5),unsigned)) AS "MAXIMO"
		FROM tbledeencuestadetalle';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->EdeId = "EDE-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->EdeId = "EDE-".$fila['MAXIMO'];					
		}	
				
	}
		
    public function MtdObtenerEncuestaDetalle(){

        $sql = 'SELECT 
        EdeId,
		EncId,
		EprId,
		EdeRespuesta,
		
		EdeEstado,	
		DATE_FORMAT(EdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEdeTiempoCreacion",
        DATE_FORMAT(EdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEdeTiempoModificacion"
        FROM tbledeencuestadetalle
        WHERE EdeId = "'.$this->EdeId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			
			
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->EdeId = $fila['EdeId'];													
            $this->EncId = $fila['EncId'];
			$this->EprId = $fila['EprId'];
			$this->EdeRespuesta = $fila['EdeRespuesta'];
													
			$this->EdeEstado = $fila['EdeEstado'];
			$this->EdeTiempoCreacion = $fila['NEdeTiempoCreacion'];
			$this->EdeTiempoModificacion = $fila['NEdeTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerEncuestaDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuesta=NULL,$oEncuestaPregunta=NULL,$oSucursal=NULL,$oPersonal=NULL) {

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
			$estado = ' AND ede.EdeEstado = '.$oEstado;
		}	
		
		
		if(!empty($oEncuesta)){
			$encuesta = ' AND ede.EncId = "'.$oEncuesta.'"';
		}	
		
		
		if(!empty($oEncuestaPregunta)){
			$epregunta = ' AND ede.EprId = "'.$oEncuestaPregunta.'"';
		}	
		
		
			
		//if(!empty($oSucursal)){
//			$sucursal = ' AND enc.SucId = "'.$oSucursal.'"';
//		}	
	
		if(!empty($oSucursal)){
			$sucursal = ' AND (fin.SucId = "'.$oSucursal.'" OR ovv.SucId = "'.$oSucursal.'")';
		}

if(!empty($oPersonal)){
			$personal = ' AND (fin.PerId = "'.$oPersonal.'" OR ovv.PerId = "'.$oPersonal.'")';
		}	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ede.EdeId,
				ede.EncId,
				ede.EprId,
				ede.EdeRespuesta,
				
				ede.EdeEstado,
				DATE_FORMAT(ede.EdeTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NEdeTiempoCreacion",
                DATE_FORMAT(ede.EdeTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NEdeTiempoModificacion",
                DATE_FORMAT(enc.EncFecha, "%d/%m/%Y") AS "NEncFecha"
				
				FROM tbledeencuestadetalle ede	
					LEFT JOIN tblencencuesta enc
					ON ede.EncId = enc.EncId
						LEFT JOIN tblfinfichaingreso fin
					ON enc.FinId = fin.FinId
						LEFT JOIN tblovvordenventavehiculo ovv
								ON enc.OvvId = ovv.OvvId
				WHERE 1 = 1 '.$filtrar.$epregunta.$personal.$tipo.$sucursal.$estado.$encuesta.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsEncuestaDetalle = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$EncuestaDetalle = new $InsEncuestaDetalle();				
					
                    $EncuestaDetalle->EdeId = $fila['EdeId'];
					$EncuestaDetalle->EncId= $fila['EncId'];
					$EncuestaDetalle->EprId= $fila['EprId'];
					$EncuestaDetalle->EdeRespuesta = $fila['EdeRespuesta'];
				
					$EncuestaDetalle->EdeEstado = $fila['EdeEstado'];					
                    $EncuestaDetalle->EdeTiempoCreacion = $fila['NEdeTiempoCreacion'];
                    $EncuestaDetalle->EdeTiempoModificacion = $fila['NEdeTiempoModificacion'];    
					$EncuestaDetalle->EncFecha = $fila['NEncFecha'];    

					
                    $EncuestaDetalle->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $EncuestaDetalle;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		 public function MtdObtenerEncuestaDetallesValor($oFuncion="SUM",$oParametro="EprId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'EdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oEncuesta=NULL,$oEncuestaPregunta=NULL,$oEncuestaRespuesta=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oSucursal=NULL,$oTipoFecha="EncFecha",$oPersonal=NULL) {

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
			$estado = ' AND ede.EdeEstado = '.$oEstado;
		}	
		
		
		if(!empty($oEncuesta)){
			$encuesta = ' AND ede.EncId = "'.$oEncuesta.'"';
		}	
		
		if(!empty($oEncuestaPregunta)){
			$epregunta = ' AND ede.EprId = "'.$oEncuestaPregunta.'"';
		}	
		
		if(!empty($oEncuestaRespuesta)){
			$erespuesta = ' AND ede.EdeRespuesta = "'.$oEncuestaRespuesta.'"';
		}else if($oEncuestaRespuesta==0){
			$erespuesta = ' AND ede.EdeRespuesta = 0';
		}
		
		
		if(!empty($oFechaInicio)){			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'" AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE('.$oTipoFecha.')>="'.$oFechaInicio.'"';
			}			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE('.$oTipoFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		
		
		
		//if(!empty($oFechaInicio)){			
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(enc.EncFecha)>="'.$oFechaInicio.'" AND DATE(enc.EncFecha)<="'.$oFechaFin.'"';
//			}else{
//				$fecha = ' AND DATE(enc.EncFecha)>="'.$oFechaInicio.'"';
//			}			
//		}else{
//			if(!empty($oFechaFin)){
//				$fecha = ' AND DATE(enc.EncFecha)<="'.$oFechaFin.'"';		
//			}			
//		}
		
	//	if(!empty($oSucursal)){
//				$sucursal = ' AND (enc.SucId) = "'.$oSucursal.'"';		
//			}	
		
		if(!empty($oSucursal)){
			$sucursal = ' AND (fin.SucId = "'.$oSucursal.'" OR ovv.SucId = "'.$oSucursal.'")';
		}


if(!empty($oPersonal)){
			$personal = ' AND (fin.PerId = "'.$oPersonal.'" OR ovv.PerId = "'.$oPersonal.'")';
		}

	
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(ede.EdeTiempoCreacion) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(ede.EdeTiempoCreacion) ="'.($oAno).'"';
		}
		
	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				'.$funcion.' AS "RESULTADO"
				FROM tbledeencuestadetalle ede	
					LEFT JOIN tblencencuesta enc
					ON ede.EncId = enc.EncId
					LEFT JOIN tblfinfichaingreso fin
					ON enc.FinId = fin.FinId
						LEFT JOIN tblovvordenventavehiculo ovv
								ON enc.OvvId = ovv.OvvId
				WHERE 1 = 1 '.$filtrar.$tipo.$fecha.$epregunta.$personal.$sucursal.$erespuesta.$estado.$encuesta.$orden.$paginacion;
				
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];	
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarEncuestaDetalle($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (EdeId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (EdeId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tbledeencuestadetalle WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarEncuestaDetalle() {
	
			$this->MtdGenerarEncuestaDetalleId();
		
			$sql = 'INSERT INTO tbledeencuestadetalle (
			EdeId,
			EncId,
			
			EprId,
			EdeRespuesta,
			EdeEstado,
			
			EdeTiempoCreacion,
			EdeTiempoModificacion) 
			VALUES (
			"'.($this->EdeId).'", 
			"'.($this->EncId).'",
			
			"'.($this->EprId).'", 
			"'.($this->EdeRespuesta).'", 
			'.($this->EdeEstado).', 
			
			"'.($this->EdeTiempoCreacion).'", 
			"'.($this->EdeTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarEncuestaDetalle() {
		
		$sql = 'UPDATE tbledeencuestadetalle SET 
		EprId = "'.($this->EprId).'",
		EdeRespuesta = "'.($this->EdeRespuesta).'",
		
		EdeEstado = "'.($this->EdeEstado).'",
		EdeTiempoModificacion = "'.($this->EdeTiempoModificacion).'"
		WHERE EdeId = "'.($this->EdeId).'";';
		
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