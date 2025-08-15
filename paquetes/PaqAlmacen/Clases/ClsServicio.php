<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsServicio
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsServicio {

    public $SerId;
	public $RtiId;
	public $SerCodigoOriginal;
	public $SerCodigoAlternativo;
    public $SerNombre;
	public $SerReferencia;
	public $SerDimension;
	public $SerImporte;
	public $SerCosto;
	public $UmeId;
	public $SerCodigoBarra;

	public $SerFoto;
	public $SerStock;
	public $SerStockMinimo;
	public $SerValidarStock;
	public $SerEstado;
    public $SerTiempoCreacion;
    public $SerTiempoModificacion;
    public $SerEliminado;
	
	public $RtiNombre;
	public $UmeNombre;
	public $UmeAbreviacion;
	
	// Propiedades adicionales para evitar warnings
	public $MonId;
	public $SerDescripcion;
	public $MonNombre;
	public $MonSimbolo;
	public $MonSigla;
	
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

	public function MtdGenerarServicioId() {

			$sql = 'SELECT	
			MAX(CONVERT(SUBSTR(SerId,5),unsigned)) AS "MAXIMO"
			FROM tblserservicio';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->SerId = "SER-10000";

			}else{
				$fila['MAXIMO']++;
				$this->SerId = "SER-".$fila['MAXIMO'];					
			}		
			
	}
		
    public function MtdObtenerServicio(){

        $sql = 'SELECT 
		ser.SerId,
		ser.MonId,
		
		ser.SerNombre,
		ser.SerDescripcion,
		ser.SerImporte,
		
		ser.SerEstado,
		DATE_FORMAT(ser.SerTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSerTiempoCreacion",
        DATE_FORMAT(ser.SerTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSerTiempoModificacion",
		
		mon.MonNombre,
		mon.MonSimbolo,
		mon.MonSigla
		
        FROM tblserservicio ser
			LEFT JOIN tblmonmoneda mon
			ON ser.MonId = mon.MonId
			
	        WHERE  ser.SerId = "'.$this->SerId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$this->SerId = $fila['SerId'];
			$this->MonId = $fila['MonId'];
			
            $this->SerNombre = (($fila['SerNombre']));
			$this->SerDescripcion = (($fila['SerDescripcion']));
            $this->SerImporte = $fila['SerImporte'];	
					
			$this->SerEstado = $fila['SerEstado'];					
			$this->SerTiempoCreacion = $fila['NSerTiempoCreacion'];
			$this->SerTiempoModificacion = $fila['NSerTiempoModificacion']; 
			
			$this->MonNombre = $fila['MonNombre']; 
			$this->MonSimbolo = $fila['MonSimbolo']; 
			$this->MonSigla = $fila['MonSigla']; 
			
			$InsServicioDetalle = new ClsServicioDetalle();
			//MtdObtenerServicioDetalles($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'SdeId',$oSentido = 'Desc',$oPaginacion = '0,10',$oServicio=NULL,$oEstado=NULL,$oProducto=NULL)
			$ResServicioDetalle =  $InsServicioDetalle->MtdObtenerServicioDetalles(NULL,NULL,NULL,NULL,NULL,NULL,$this->SerId);
			$this->ServicioDetalle = $ResServicioDetalle['Datos'];
						
						
						
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerServicios($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SerId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oMoneda=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
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
			$estado = ' AND ser.SerEstado = '.$oEstado.' ';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ser.MonId = "'.$oMoneda.'" ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ser.SerId,			
				ser.MonId,
				
				ser.SerNombre,
				ser.SerDescripcion,
       			ser.SerImporte,
				
				ser.SerEstado,
				DATE_FORMAT(ser.SerTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSerTiempoCreacion",
                DATE_FORMAT(ser.SerTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSerTiempoModificacion",
				
				mon.MonNombre,
				mon.MonSimbolo,
				mon.MonSigla
				
				FROM tblserservicio ser		
					LEFT JOIN tblmonmoneda mon
					ON ser.MonId = mon.MonId
					
				WHERE  1 = 1  '.$filtrar.$categoria.$moneda.$estado.$tipo.$vstock.$orden.$paginacion;
				
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsServicio = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$Servicio = new $InsServicio();
                    $Servicio->SerId = $fila['SerId'];
					$Servicio->MonId= ($fila['MonId']);
					 
                    $Servicio->SerNombre= ($fila['SerNombre']);
                    $Servicio->SerDescripcion= ($fila['SerDescripcion']);
					$Servicio->SerImporte= $fila['SerImporte'];
					
					$Servicio->SerEstado = $fila['SerEstado'];	
                    $Servicio->SerTiempoCreacion = $fila['NSerTiempoCreacion'];
                    $Servicio->SerTiempoModificacion = $fila['NSerTiempoModificacion'];
					
					$Servicio->MonNombre = $fila['MonNombre'];
					$Servicio->MonSimbolo = $fila['MonSimbolo'];
					$Servicio->MonSigla = $fila['MonSigla'];
					
					$Servicio->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Servicio;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
	//Accion eliminar	 
	public function MtdEliminarServicio($oElementos) {
		
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (SerId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (SerId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}
		
			$sql = 'DELETE FROM tblserservicio WHERE '.$eliminar;			
		
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
	
	
	
	
	
	
	
	
	public function MtdRegistrarServicio() {
		
		
						
			$this->MtdGenerarServicioId();
			
			$sql = 'INSERT INTO tblserservicio (
			SerId,
			MonId,
			
			SerNombre, 
			SerDescripcion,
			SerImporte,
			SerEstado,
			SerTiempoCreacion,
			SerTiempoModificacion
			) 
			VALUES (
			"'.($this->SerId).'", 
			"'.($this->MonId).'", 

			"'.($this->SerNombre).'", 
			"'.($this->SerDescripcion).'", 
			'.($this->SerImporte).',
			'.($this->SerEstado).',
			"'.($this->SerTiempoCreacion).'", 
			"'.($this->SerTiempoModificacion).'");';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
				if(!$error){			

				if (!empty($this->ServicioDetalle)){		
						
					$validar = 0;				
					$InsServicioDetalle = new ClsServicioDetalle();		
					
					foreach ($this->ServicioDetalle as $DatServicioDetalle){
					
						$InsServicioDetalle->SerId = $this->SerId;
						$InsServicioDetalle->ProId = $DatServicioDetalle->ProId;
						$InsServicioDetalle->UmeId = $DatServicioDetalle->UmeId;
						$InsServicioDetalle->SdeCantidad = $DatServicioDetalle->SdeCantidad;
						$InsServicioDetalle->SdeImporte = $DatServicioDetalle->SdeImporte;
						$InsServicioDetalle->SdeEstado = $DatServicioDetalle->SdeEstado;						
						$InsServicioDetalle->SdeTiempoCreacion = $DatServicioDetalle->SdeTiempoCreacion;
						$InsServicioDetalle->SdeTiempoModificacion = $DatServicioDetalle->SdeTiempoModificacion;						
						$InsServicioDetalle->SdeEliminado = $DatServicioDetalle->SdeEliminado;
						
						if($InsServicioDetalle->MtdRegistrarServicioDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_SER_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->ServicioDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	public function MtdEditarServicio() {
		
			$sql = 'UPDATE tblserservicio SET 
			MonId = "'.($this->MonId).'",
			
			SerNombre = "'.($this->SerNombre).'",
			SerDescripcion = "'.($this->SerDescripcion).'",
			SerImporte = '.($this->SerImporte).',
			SerEstado = '.($this->SerEstado).',
			
			SerTiempoModificacion = "'.($this->SerTiempoModificacion).'"		
			WHERE SerId = "'.($this->SerId).'";';
			
			$error = false;
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
			if(!$error){
			
				if (!empty($this->ServicioDetalle)){		

					$validar = 0;				
					$InsServicioDetalle = new ClsServicioDetalle();
							
					foreach ($this->ServicioDetalle as $DatServicioDetalle){
										
						$InsServicioDetalle->SdeId = $DatServicioDetalle->SdeId;
						$InsServicioDetalle->SerId = $this->SerId;
						$InsServicioDetalle->ProId = $DatServicioDetalle->ProId;
						$InsServicioDetalle->UmeId = $DatServicioDetalle->UmeId;
						$InsServicioDetalle->SdeCantidad = $DatServicioDetalle->SdeCantidad;
						$InsServicioDetalle->SdeImporte = $DatServicioDetalle->SdeImporte;
						$InsServicioDetalle->SdeEstado = $DatServicioDetalle->SdeEstado;
						$InsServicioDetalle->SdeTiempoCreacion = $DatServicioDetalle->SdeTiempoCreacion;
						$InsServicioDetalle->SdeTiempoModificacion = $DatServicioDetalle->SdeTiempoModificacion;
						$InsServicioDetalle->SdeEliminado = $DatServicioDetalle->SdeEliminado;
						
						if(empty($InsServicioDetalle->SdeId)){
							if($InsServicioDetalle->SdeEliminado<>2){
								if($InsServicioDetalle->MtdRegistrarServicioDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_SER_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsServicioDetalle->SdeEliminado==2){
								if($InsServicioDetalle->MtdEliminarServicioDetalle($InsServicioDetalle->SdeId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_SER_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsServicioDetalle->MtdEditarServicioDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_SER_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->ServicioDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
			
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				return true;
			}						
				
		}	
		
		
		
	
}
?>