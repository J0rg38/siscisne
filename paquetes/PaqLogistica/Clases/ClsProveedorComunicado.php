<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsProveedorComunicado
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsProveedorComunicado {

    public $PomId;
    public $PomFecha;
	public $PrvId;
	
	public $PomCodigo;
	public $PomRemitente;
	
	public $PomAsunto;
	public $PomDescripcion;
	public $PomEstado;	
    public $PomTiempoCreacion;
    public $PomTiempoModificacion;
    public $PomEliminado;

	public $InsMysql;


	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarProveedorComunicadoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(PomId,5),unsigned)) AS "MAXIMO"
		FROM tblpomproveedorcomunicado';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->PomId = "POM-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->PomId = "POM-".$fila['MAXIMO'];					
		}	
			
	}
		
    public function MtdObtenerProveedorComunicado(){

        $sql = 'SELECT 
        pom.PomId,
		pom.PrvId,
		pom.PomCodigo,
		pom.PomRemitente,
		
		DATE_FORMAT(pom.PomFecha, "%d/%m/%Y") AS "NPomFecha",
		pom.PomAsunto,
		pom.PomDescripcion,
		pom.PomArchivo,
		
		pom.PomEstado,	
		DATE_FORMAT(pom.PomTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPomTiempoCreacion",
        DATE_FORMAT(pom.PomTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPomTiempoModificacion",
		
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		prv.PrvNumeroDocumento,
		prv.TdoId
		
        FROM tblpomproveedorcomunicado pom
			LEFT JOIN tblprvproveedor prv
			ON pom.PrvId = prv.PrvId
        WHERE PomId = "'.$this->PomId.'";';
		
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
			
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
				$this->PomId = $fila['PomId'];
				
				$this->PomCodigo = $fila['PomCodigo'];	
				$this->PomRemitente  = $fila['PomRemitente'];	
				
				$this->PrvId = $fila['PrvId'];										
				$this->PomFecha = $fila['NPomFecha'];	
				$this->PomAsunto = $fila['PomAsunto'];
				$this->PomDescripcion = $fila['PomDescripcion'];	
				$this->PomArchivo = $fila['PomArchivo'];	
												
				$this->PomEstado = $fila['PomEstado'];
				$this->PomTiempoCreacion = $fila['NPomTiempoCreacion'];
				$this->PomTiempoModificacion = $fila['NPomTiempoModificacion'];
				
				$this->PrvNombre = $fila['PrvNombre'];
				$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
				$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
				$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
				
				$this->TdoId = $fila['TdoId'];
		
			}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerProveedorComunicados($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PomId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oProveedor=NULL,$oFechaInicio=NULL,$oFechaFin=NULL) {

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
			$estado = ' AND pom.PomEstado = '.$oEstado;
		}	
		
		if(!empty($oProveedor)){
			$proveedor = ' AND pom.PrvId = "'.$oProveedor.'"';
		}	
		
		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pom.PomFecha)>="'.$oFechaInicio.'" AND DATE(pom.PomFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(pom.PomFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pom.PomFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pom.PomId,
				pom.PomCodigo,
				pom.PomRemitente,
				pom.PrvId,
				DATE_FORMAT(pom.PomFecha, "%d/%m/%Y") AS "NPomFecha",
				pom.PomAsunto,
				pom.PomDescripcion,
				pom.PomArchivo,
				pom.PomEstado,
				DATE_FORMAT(pom.PomTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPomTiempoCreacion",
                DATE_FORMAT(pom.PomTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPomTiempoModificacion",
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				
				prv.PrvNumeroDocumento,
				prv.TdoId
				
				FROM tblpomproveedorcomunicado pom	
					LEFT JOIN tblprvproveedor prv
					ON pom.PrvId = prv.PrvId
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$categoria.$fecha.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsProveedorComunicado = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ProveedorComunicado = new $InsProveedorComunicado();				
					
                    $ProveedorComunicado->PomId = $fila['PomId'];
					$ProveedorComunicado->PrvId= $fila['PrvId'];
					$ProveedorComunicado->PomCodigo = $fila['PomCodigo'];
					$ProveedorComunicado->PomRemitente = $fila['PomRemitente'];
					
                    $ProveedorComunicado->PomFecha= $fila['NPomFecha'];
					$ProveedorComunicado->PomAsunto = $fila['PomAsunto'];		
					$ProveedorComunicado->PomDescripcion = $fila['PomDescripcion'];	
					$ProveedorComunicado->PomArchivo = $fila['PomArchivo'];	
						
					$ProveedorComunicado->PomEstado = $fila['PomEstado'];					
                    $ProveedorComunicado->PomTiempoCreacion = $fila['NPomTiempoCreacion'];
                    $ProveedorComunicado->PomTiempoModificacion = $fila['NPomTiempoModificacion'];    
					
					$ProveedorComunicado->PrvNombre = $fila['PrvNombre'];    
					$ProveedorComunicado->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];    
					$ProveedorComunicado->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];    
					
					$ProveedorComunicado->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];    
					$ProveedorComunicado->TdoId = $fila['TdoId'];    

                    $ProveedorComunicado->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ProveedorComunicado;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarProveedorComunicado($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PomId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PomId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblpomproveedorcomunicado WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarProveedorComunicado($oTransaccion=true) {
	
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
			
			
			$this->MtdGenerarProveedorComunicadoId();
		
			$sql = 'INSERT INTO tblpomproveedorcomunicado (
			PomId,
			PrvId,
			
			PomCodigo,
			PomRemitente,
			
			PomFecha,
			PomAsunto,			
			PomDescripcion,
			PomArchivo,
			
			PomEstado,
			PomTiempoCreacion,
			PomTiempoModificacion
			) 
			VALUES (
			"'.($this->PomId).'", 
			'.(empty($this->PrvId)?"NULL,":'"'.$this->PrvId.'",').'
			
			"'.($this->PomCodigo).'",
			"'.($this->PomRemitente).'",
			
			"'.($this->PomFecha).'",
			"'.($this->PomAsunto).'",			
			"'.($this->PomDescripcion).'",
			"'.($this->PomArchivo).'",
			
			'.($this->PomEstado).', 
			"'.($this->PomTiempoCreacion).'", 
			"'.($this->PomTiempoModificacion).'");';					

			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
			
			
			if($error) {	
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}
				return false;
			} else {		
				if($oTransaccion){		
					$this->InsMysql->MtdTransaccionHacer();		
				}
						
				return true;
			}			
			
	}
	
	
	
	public function MtdEditarProveedorComunicado($oTransaccion=true) {
		
						if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
			
			$sql = 'UPDATE tblpomproveedorcomunicado SET 
		
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			
			PomCodigo = "'.($this->PomCodigo).'",
			PomRemitente = "'.($this->PomRemitente).'",
			
			PomFecha = "'.($this->PomFecha).'",
			PomAsunto = "'.($this->PomAsunto).'",			
			PomDescripcion = "'.($this->PomDescripcion).'",
			PomArchivo = "'.($this->PomArchivo).'",
			
			PomEstado = "'.($this->PomEstado).'",
			PomTiempoModificacion = "'.($this->PomTiempoModificacion).'"
			WHERE PomId = "'.($this->PomId).'";';
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {	
				if($oTransaccion){
					$this->InsMysql->MtdTransaccionDeshacer();			
				}
				return false;
			} else {		
				if($oTransaccion){		
					$this->InsMysql->MtdTransaccionHacer();		
				}
						
				return true;
			}							
				
		}	
		
		
		
		
	
}
?>