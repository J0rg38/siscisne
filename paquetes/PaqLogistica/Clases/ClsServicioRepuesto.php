<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsServicioRepuesto
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsServicioRepuesto {

    public $SreId;
	public $TgaId;
	
    public $SreDescripcion;
	public $SreNombre;
	public $SreOrden;
	public $SreEstado;	
    public $SreTiempoCreacion;
    public $SreTiempoModificacion;
    public $SreEliminado;

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
		
	public function MtdGenerarServicioRepuestoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(SreId,5),unsigned)) AS "MAXIMO"
		FROM tblsreserviciorepuesto';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->SreId = "SRE-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->SreId = "SRE-".$fila['MAXIMO'];					
		}	
			
	}
		
    public function MtdObtenerServicioRepuesto($oCompleto=true){

        $sql = 'SELECT 
        sre.SreId,
		sre.TgaId,
		
		sre.SreDescripcion,
		sre.SreNombre,
		sre.SreOrden,
		
		sre.SreEstado,	
		DATE_FORMAT(sre.SreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSreTiempoCreacion",
        DATE_FORMAT(sre.SreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSreTiempoModificacion"
        FROM tblsreserviciorepuesto sre
        WHERE SreId = "'.$this->SreId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->SreId = $fila['SreId'];
			$this->TgaId = $fila['TgaId'];
			
            $this->SreDescripcion = $fila['SreDescripcion'];	
			$this->SreNombre = $fila['SreNombre'];	
			$this->SreOrden = $fila['SreOrden'];	
											
			$this->SreEstado = $fila['SreEstado'];
			$this->SreTiempoCreacion = $fila['NSreTiempoCreacion'];
			$this->SreTiempoModificacion = $fila['NSreTiempoModificacion'];
			
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerServicioRepuestos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipoGasto=NULL) {

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
			$estado = ' AND sre.SreEstado = '.$oEstado;
		}	
		
		
		if(!empty($oTipoGasto)){
			$tipo = ' AND sre.TgaId = "'.$oTipoGasto.'" ';
		}	
		
		 	 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				sre.SreId,
				sre.TgaId,
				
				sre.SreDescripcion,
				sre.SreNombre,
				sre.SreOrden,
				
				sre.SreEstado,
				DATE_FORMAT(sre.SreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSreTiempoCreacion",
                DATE_FORMAT(sre.SreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSreTiempoModificacion",
				
				tga.TgaNombre
				
				FROM tblsreserviciorepuesto sre	
					LEFT JOIN tbltgatipogasto tga
					ON sre.TgaId = tga.TgaId
				WHERE 1 = 1 '.$filtrar.$tipo.$fecha .$estado.$categoria.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsServicioRepuesto = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ServicioRepuesto = new $InsServicioRepuesto();				
					
                    $ServicioRepuesto->SreId = $fila['SreId'];
					$ServicioRepuesto->TgaId= $fila['TgaId'];
				
                    $ServicioRepuesto->SreDescripcion= $fila['SreDescripcion'];
					$ServicioRepuesto->SreNombre = $fila['SreNombre'];	
					$ServicioRepuesto->SreOrden = $fila['SreOrden'];		
							
					$ServicioRepuesto->SreEstado = $fila['SreEstado'];					
                    $ServicioRepuesto->SreTiempoCreacion = $fila['NSreTiempoCreacion'];
                    $ServicioRepuesto->SreTiempoModificacion = $fila['NSreTiempoModificacion'];  
					
					$ServicioRepuesto->TgaNombre = $fila['TgaNombre'];  
					
                    $ServicioRepuesto->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $ServicioRepuesto;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarServicioRepuesto($oElementos) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (SreId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SreId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblsreserviciorepuesto WHERE '.$eliminar;
			
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
	
	
	public function MtdRegistrarServicioRepuesto($oTransaccion=true) {
	
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
			
			$this->MtdGenerarServicioRepuestoId();
		
			$sql = 'INSERT INTO tblsreserviciorepuesto (
			SreId,
			TgaId,
			
			SreDescripcion,
			SreNombre,
	
			SreEstado,
			SreTiempoCreacion,
			SreTiempoModificacion
			) 
			VALUES (
			"'.($this->SreId).'", 
			'.(empty($this->TgaId)?"NULL,":'"'.$this->TgaId.'",').'
			
			"'.($this->SreDescripcion).'",
			"'.($this->SreNombre).'",
			
			'.($this->SreEstado).', 
			"'.($this->SreTiempoCreacion).'", 
			"'.($this->SreTiempoModificacion).'");';					

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
	
	
	
	public function MtdEditarServicioRepuesto($oTransaccion=true) {
		
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
			
			$sql = 'UPDATE tblsreserviciorepuesto SET 
		
			'.(empty($this->TgaId)?'TgaId = NULL, ':'TgaId = "'.$this->TgaId.'",').'
		
			SreDescripcion = "'.($this->SreDescripcion).'",
			SreNombre = "'.($this->SreNombre).'",
			
			SreEstado = '.($this->SreEstado).',
			SreTiempoModificacion = "'.($this->SreTiempoModificacion).'"
			WHERE SreId = "'.($this->SreId).'";';
			
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