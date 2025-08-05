<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsTrasladoVehiculo
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsTrasladoVehiculo {

    public $TveId;
	
	
	public $SucIdDestino;
	public $SucId;
	
	public $TveFecha;
	
	public $TveObservacionImpresa;
	public $TveObservacionCorreo;
	public $TveReferencia;
	
	public $TveFoto;
	public $TveRevisado;
	
	public $TveEstado;
	public $TveTiempoCreacion;
	public $TveTiempoModificacion;
    public $TveEliminado;

	
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarTrasladoVehiculoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(tve.TveId,5),unsigned)) AS "MAXIMO"
		FROM tbltvetrasladovehiculo tve
		';
			
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->TveId = "TVE-10000";
		}else{
			$fila['MAXIMO']++;
			$this->TveId = "TVE-".$fila['MAXIMO'];					
		}
				
	}
		
    public function MtdObtenerTrasladoVehiculo(){

        $sql = 'SELECT 
        tve.TveId,  
		tve.SucId,
		tve.SucIdDestino,
		tve.PerId,
		
		DATE_FORMAT(tve.TveFecha, "%d/%m/%Y") AS "NTveFecha",
		
		tve.TveObservacionInterna,
		tve.TveObservacionImpresa,
		tve.TveObservacionCorreo,
		tve.TveReferencia,
		tve.TveFoto,
		
		tve.TveEstado,
		DATE_FORMAT(tve.TveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTveTiempoCreacion",
        DATE_FORMAT(tve.TveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTveTiempoModificacion",
		
		suc2.SucNombre AS SucNombreDestino,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno
		
        FROM tbltvetrasladovehiculo tve
			
				LEFT JOIN tblsucsucursal suc2
				ON tve.SucIdDestino = suc2.SucId
						
					LEFT JOIN tblperpersonal per
					ON tve.PerId = per.PerId

        WHERE tve.TveId = "'.$this->TveId.'" ';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->TveId = $fila['TveId'];
			$this->SucId = $fila['SucId'];				
			$this->SucIdDestino = $fila['SucIdDestino'];	
			$this->PerId = $fila['PerId'];	
			
			$this->TveFecha = $fila['NTveFecha'];

			$this->TveObservacionInterna = $fila['TveObservacionInterna'];
			$this->TveObservacionImpresa = $fila['TveObservacionImpresa'];
			$this->TveObservacionCorreo = $fila['TveObservacionCorreo'];
			
			$this->TveReferencia = $fila['TveReferencia'];
			list($this->TveReferenciaSerie,$this->TveReferenciaNumero) = explode("-",$this->TveReferencia);
			
			$this->TveFoto = $fila['TveFoto'];
		
			$this->TveEstado = $fila['TveEstado'];
			$this->TveTiempoCreacion = $fila['NTveTiempoCreacion']; 
			$this->TveTiempoModificacion = $fila['NTveTiempoModificacion']; 	
			
			$this->SucNombreDestino = $fila['SucNombreDestino']; 	

$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno']; 
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno']; 	
			
			$InsTrasladoVehiculoDetalle = new ClsTrasladoVehiculoDetalle();
			//MtdObtenerTrasladoVehiculoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL)
			$ResTrasladoVehiculoDetalle =  $InsTrasladoVehiculoDetalle->MtdObtenerTrasladoVehiculoDetalles(NULL,NULL,NULL,"TveId","ASC",NULL,$this->TveId);				
			$this->TrasladoVehiculoDetalle = 	$ResTrasladoVehiculoDetalle['Datos'];	



			switch($this->TveEstado){
			
				case 1:
					$Estado = "No Realizado";
				break;
			
				case 3:
					$Estado = "Realizado";						
				break;	

				default:
					$Estado = "";
				break;
			
			}
				
			$this->TveEstadoDescripcion = $Estado;
			
		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerTrasladoVehiculos($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFecha="TveFecha",$oSucursal=NULL,$oPersonal=NULL) {

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
				
				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					cvd.TvdId

					FROM tblcvdcompravehiculodetalle cvd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON cvd.EinId = ein.EinId

					WHERE 
						cvd.TveId = tve.TveId  
						
						AND 
						(
						ein.EinVIN LIKE "%'.$oFiltro.'%" OR
						ein.EinNumeroMotor LIKE "%'.$oFiltro.'%"
					
						)
						
					) ';
					
									
				$filtrar .= '  ) ';

			

				
					
					
		}


		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tve.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(tve.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(tve.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tve.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		

		if(!empty($oEstado)){
			$estado = ' AND tve.TveEstado = '.$oEstado;
		}
		

		
		if(!empty($oSucursal)){
			$sucursal = ' AND tve.SucId = "'.$oSucursal.'"';
		}
		
		
		
		if(!empty($oPersonal)){
			$personal = ' AND tve.PerId = "'.$oPersonal.'"';
		}
		
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				tve.TveId,				
				tve.SucId,
				tve.SucIdDestino,
				tve.PerId,
				
				DATE_FORMAT(tve.TveFecha, "%d/%m/%Y") AS "NTveFecha",
			
				tve.TveObservacionImpresa,
				tve.TveObservacionCorreo,				
				tve.TveReferencia,
				
				tve.TveFoto,
		
				tve.TveEstado,
				DATE_FORMAT(tve.TveTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NTveTiempoCreacion",
	        	DATE_FORMAT(tve.TveTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NTveTiempoModificacion",
				
				suc2.SucNombre AS SucNombreDestino,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				suc.SucNombre
				
				FROM tbltvetrasladovehiculo tve
					
					LEFT JOIN tblsucsucursal suc2
					ON tve.SucIdDestino = suc2.SucId
						
						LEFT JOIN tblperpersonal per
						ON tve.PerId = per.PerId
							
							LEFT JOIN tblsucsucursal suc
							ON tve.SucId = suc.SucId
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$vdirecta.$cpago.$almacen.$personal.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsTrasladoVehiculo = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$TrasladoVehiculo = new $InsTrasladoVehiculo();
                    $TrasladoVehiculo->TveId = $fila['TveId'];
					$TrasladoVehiculo->SucId = $fila['SucId'];
					$TrasladoVehiculo->SucIdDestino = $fila['SucIdDestino'];	
					$TrasladoVehiculo->PerId = $fila['PerId'];	
					$TrasladoVehiculo->TveFecha = $fila['NTveFecha'];
					
					$TrasladoVehiculo->TveObservacionImpresa = $fila['TveObservacionImpresa'];			
					$TrasladoVehiculo->TveObservacionCorreo = $fila['TveObservacionCorreo'];
					$TrasladoVehiculo->TveReferencia = $fila['TveReferencia'];
					
					$TrasladoVehiculo->TveFoto = $fila['TveFoto'];	
								
					$TrasladoVehiculo->TveEstado = $fila['TveEstado'];
					$TrasladoVehiculo->TveTiempoCreacion = $fila['NTveTiempoCreacion'];  
					$TrasladoVehiculo->TveTiempoModificacion = $fila['NTveTiempoModificacion']; 

					$TrasladoVehiculo->SucNombreDestino = $fila['SucNombreDestino']; 
					
					$TrasladoVehiculo->PerNombre = $fila['PerNombre'];
					$TrasladoVehiculo->PerApellidoPaterno = $fila['PerApellidoPaterno'];  
					$TrasladoVehiculo->PerApellidoMaterno = $fila['PerApellidoMaterno']; 

					$TrasladoVehiculo->SucNombre = $fila['SucNombre']; 
					
					switch($TrasladoVehiculo->TveEstado){
					
						case 1:
							$Estado = "No Realizado";
						break;
					
						case 3:
							$Estado = "Realizado";						
						break;	
		
						default:
							$Estado = "";
						break;
					
					}
						
					$TrasladoVehiculo->TveEstadoDescripcion = $Estado;
					
					switch($TrasladoVehiculo->TveRevisado){
					
						case 1:
							$Revisado = "Revisado";
						break;
					
						case 3:
							$Revisado = "No Revisado";						
						break;	
		
						default:
							$Revisado = "";
						break;
					
					}
						
					$TrasladoVehiculo->TveRevisadoDescripcion = $Revisado;
					
                    $TrasladoVehiculo->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $TrasladoVehiculo;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		



    public function MtdObtenerTrasladoVehiculosValor($oFuncion="SUM",$oParametro="TveReferencia",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'TveId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oFecha="TveFecha",$oSucursal=NULL,$oPersonal=NULL) {

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
				
				

				$filtrar .= '  OR EXISTS( 
					
					SELECT 
					cvd.TvdId

					FROM tblcvdcompravehiculodetalle cvd
					
						LEFT JOIN tbleinvehiculoingreso ein
						ON cvd.EinId = ein.EinId

					WHERE 
						cvd.TveId = tve.TveId AND 
						(
						ein.EinVIN LIKE "%'.$oFiltro.'%" 
						
						)
						
						
						
					) ';
					
									
				$filtrar .= '  ) ';

			

				
					
					
		}




		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
		
		
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tve.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(tve.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(tve.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(tve.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}
		

		if(!empty($oEstado)){
			$estado = ' AND tve.TveEstado = '.$oEstado;
		}
		

		if(!empty($oSucursal)){
			$sucursal = ' AND tve.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND tve.PerId = "'.$oPersonal.'"';
		}
		
		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}	
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(tve.TveFecha) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(tve.TveFecha) ="'.($oAno).'"';
		}
		
		
		
			 $sql = 'SELECT
				'.$funcion.' AS "RESULTADO" 

				FROM tbltvetrasladovehiculo tve
					
				WHERE 1 = 1 '.$ano.$mes.$filtrar.$personal.$fecha.$tipo.$stipo.$estado.$origen.$moneda.$pcompra.$ocompra.$pcompradetalle.$cliente.$cocompra.$cancelado.$einveedor.$sucursal.$vdirecta.$cpago.$almacen.$orden.$paginacion;
											
		}
		


	
	//Accion eliminar	 
	public function MtdEliminarTrasladoVehiculo($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsTrasladoVehiculoDetalle = new ClsTrasladoVehiculoDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
					
					//MtdObtenerTrasladoVehiculoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'TvdId',$oSentido = 'Desc',$oPaginacion = '0,10',$oTrasladoVehiculo=NULL,$oEstado=NULL,$oVehiculo=NULL)
					$ResTrasladoVehiculoDetalle = $InsTrasladoVehiculoDetalle->MtdObtenerTrasladoVehiculoDetalles(NULL,NULL,NULL,'TvdId','DESC',NULL,$elemento,NULL,NULL,NULL);
					$ArrTrasladoVehiculoDetalles = $ResTrasladoVehiculoDetalle['Datos'];

					if(!empty($ArrTrasladoVehiculoDetalles)){
						$cvdetalle = '';

						foreach($ArrTrasladoVehiculoDetalles as $DatTrasladoVehiculoDetalle){
							$cvdetalle .= '#'.$DatTrasladoVehiculoDetalle->TvdId;
						}

						if(!$InsTrasladoVehiculoDetalle->MtdEliminarTrasladoVehiculoDetalle($cvdetalle)){								
							$error = true;
						}

					}
					
					if(!$error) {		
					
						$this->TveId = $elemento;
						$this->MtdObtenerTrasladoVehiculo();

						$sql = 'DELETE FROM tbltvetrasladovehiculo WHERE  (TveId = "'.($elemento).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

						if(!$resultado) {						
							$error = true;
						}else{
							
							$this->MtdAuditarTrasladoVehiculo(3,"Se elimino el Traslado de Vehiculo",$aux);		
						}
					}
					
				}
			$i++;

			}

			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}							
	}
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoTrasladoVehiculo($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		//$InsTrasladoVehiculo = new ClsTrasladoVehiculo();
		//$InsTrasladoVehiculoDetalles = new ClsTrasladoVehiculoDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				//$aux = explode("%",$elemento);	

					$sql = 'UPDATE tbltvetrasladovehiculo SET TveEstado = '.$oEstado.' WHERE TveId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarTrasladoVehiculo(2,"Se actualizo el Estado del Traslado de Vehiculo",$elemento);
				
					}

					
				}
			$i++;
	
			}

		

	
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				
						
				return true;
			}									
	}
	
	
	
	public function MtdActualizarRevisadoTrasladoVehiculo($oElementos,$oRevisado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				
					$sql = 'UPDATE tbltvecompravehiculo SET TveRevisado = '.$oRevisado.' WHERE TveId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}

					
				}
			$i++;
	
			}

	
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();			
				return true;
			}									
	}
	
	
	
	public function MtdRegistrarTrasladoVehiculo() {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarTrasladoVehiculoId();
			
			
			
			$sql = 'INSERT INTO tbltvetrasladovehiculo (
			TveId,	
			SucId,
			SucIdDestino,
			PerId,
			
			TveFecha,
			
			TveObservacionInterna,
			TveObservacionImpresa,
			TveObservacionCorreo,				
			TveReferencia,
				
			TveFoto,
			TveRevisado,
			
			TveEstado,			
			TveTiempoCreacion,
			TveTiempoModificacion) 
			VALUES (
			"'.($this->TveId).'", 
			"'.($this->SucId).'", 	
			'.(empty($this->SucIdDestino)?'NULL, ':'"'.$this->SucIdDestino.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			"'.($this->TveFecha).'", 
		
			"'.($this->TveObservacionInterna).'",
			"'.($this->TveObservacionImpresa).'",
			"'.($this->TveObservacionCorreo).'",
			"'.($this->TveReferencia).'",
			
			"'.($this->TveFoto).'", 
			'.($this->TveRevisado).',
			
			'.($this->TveEstado).',
			"'.($this->TveTiempoCreacion).'", 			
			"'.($this->TveTiempoModificacion).'");';			
		
			$this->InsMysql->MtdTransaccionIniciar();
		
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 

			if(!$error){			
			
				if (!empty($this->TrasladoVehiculoDetalle)){		
						
					$validar = 0;				
					$InsTrasladoVehiculoDetalle = new ClsTrasladoVehiculoDetalle();		
					
					foreach ($this->TrasladoVehiculoDetalle as $DatTrasladoVehiculoDetalle){
					
						$InsTrasladoVehiculoDetalle->TveId = $this->TveId;
						$InsTrasladoVehiculoDetalle->EinId = $DatTrasladoVehiculoDetalle->EinId;
						$InsTrasladoVehiculoDetalle->UmeId = $DatTrasladoVehiculoDetalle->UmeId;
						
						$InsTrasladoVehiculoDetalle->TvdCantidad = $DatTrasladoVehiculoDetalle->TvdCantidad;
						$InsTrasladoVehiculoDetalle->TvdObservacion = $DatTrasladoVehiculoDetalle->TvdObservacion;
						
						$InsTrasladoVehiculoDetalle->TvdEstado = $DatTrasladoVehiculoDetalle->TvdEstado;									
						$InsTrasladoVehiculoDetalle->TvdTiempoCreacion = $DatTrasladoVehiculoDetalle->TvdTiempoCreacion;
						$InsTrasladoVehiculoDetalle->TvdTiempoModificacion = $DatTrasladoVehiculoDetalle->TvdTiempoModificacion;						
						$InsTrasladoVehiculoDetalle->TvdEliminado = $DatTrasladoVehiculoDetalle->TvdEliminado;
						
						if($InsTrasladoVehiculoDetalle->MtdRegistrarTrasladoVehiculoDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_TVE_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->TrasladoVehiculoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
					
				
			if($error) {	
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarTrasladoVehiculo(1,"Se registro el Traslado de Vehiculo",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarTrasladoVehiculo() {

		global $Resultado;
		$error = false;

			
			$sql = 'UPDATE tbltvetrasladovehiculo SET
			'.(empty($this->SucIdDestino)?'SucIdDestino = NULL, ':'SucIdDestino = "'.$this->SucIdDestino.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			TveFecha = "'.($this->TveFecha).'",
		
			TveObservacionInterna = "'.($this->TveObservacionInterna).'",
			TveObservacionImpresa = "'.($this->TveObservacionImpresa).'",
			TveObservacionCorreo = "'.($this->TveObservacionCorreo).'",
			TveReferencia = "'.($this->TveReferencia).'",
			
			TveFoto = "'.($this->TveFoto).'",
			
			TveEstado = '.($this->TveEstado).'
			WHERE TveId = "'.($this->TveId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 			


			
			if(!$error){
			
				if (!empty($this->TrasladoVehiculoDetalle)){		
						
						
					$validar = 0;				
					$InsTrasladoVehiculoDetalle = new ClsTrasladoVehiculoDetalle();
							
					foreach ($this->TrasladoVehiculoDetalle as $DatTrasladoVehiculoDetalle){
										
						$InsTrasladoVehiculoDetalle->TvdId = $DatTrasladoVehiculoDetalle->TvdId;
						$InsTrasladoVehiculoDetalle->TveId = $this->TveId;
						$InsTrasladoVehiculoDetalle->EinId = $DatTrasladoVehiculoDetalle->EinId;
						$InsTrasladoVehiculoDetalle->UmeId = $DatTrasladoVehiculoDetalle->UmeId;
						$InsTrasladoVehiculoDetalle->TvdCantidad = $DatTrasladoVehiculoDetalle->TvdCantidad;
						$InsTrasladoVehiculoDetalle->TvdObservacion = $DatTrasladoVehiculoDetalle->TvdObservacion;
						
						$InsTrasladoVehiculoDetalle->TvdEstado = $DatTrasladoVehiculoDetalle->TvdEstado;		
						$InsTrasladoVehiculoDetalle->TvdTiempoCreacion = $DatTrasladoVehiculoDetalle->TvdTiempoCreacion;
						$InsTrasladoVehiculoDetalle->TvdTiempoModificacion = $DatTrasladoVehiculoDetalle->TvdTiempoModificacion;
						$InsTrasladoVehiculoDetalle->TvdEliminado = $DatTrasladoVehiculoDetalle->TvdEliminado;
						
						
						if(empty($InsTrasladoVehiculoDetalle->TvdId)){
							if($InsTrasladoVehiculoDetalle->TvdEliminado<>2){
								if($InsTrasladoVehiculoDetalle->MtdRegistrarTrasladoVehiculoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_TVE_201';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsTrasladoVehiculoDetalle->TvdEliminado==2){
								if($InsTrasladoVehiculoDetalle->MtdEliminarTrasladoVehiculoDetalle($InsTrasladoVehiculoDetalle->TvdId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_TVE_203';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsTrasladoVehiculoDetalle->MtdEditarTrasladoVehiculoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_TVE_202';
									//$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->TrasladoVehiculoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarTrasladoVehiculo(2,"Se edito el Traslado de Vehiculo",$this);		
				return true;
			}	
				
		}
		
		
	
		public function MtdEditarTrasladoVehiculoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tbltvetrasladovehiculo SET 
			'.$oCampo.' = "'.($oDato).'",
			TveTiempoModificacion = NOW()
			WHERE TveId = "'.($oId).'";';
			
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



		private function MtdAuditarTrasladoVehiculo($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->TveId;

			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar()){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		public function MtdNotificarAlmacennMovimientoEntradaOrdenCompra($oTrasladoVehiculo,$oDestinatario,$oImportante=false){
			
global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->TveId = $oTrasladoVehiculo;
			$this->MtdObtenerTrasladoVehiculo();
			
			$InsOrdenCompra = new ClsOrdenCompra();
			$InsOrdenCompra->OcoId = $this->OcoId;
			$InsOrdenCompra->MtdObtenerOrdenCompra();
			

							
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de Ingreso a almacen c/ Orden de Compra .";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->TveId."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Proveedor: <b>".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Fecha Registro: <b>".$this->TveFecha."</b>";	
			$mensaje .= "<br>";	
			$mensaje .= "Orden de Compra: <b>".$this->OcoId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			$mensaje .= "Datos del comeinbante";	
			$mensaje .= "<br>";
			$mensaje .= "Tipo: <b>".$this->CtiNombre."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Numero : <b>".$this->TveComprobanteNumero."</b>";	
			$mensaje .= "<br>";
			$mensaje .= "Fecha : <b>".$this->TveComprobanteFecha."</b>";				
			$mensaje .= "<br>";
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";

			if(!empty($InsOrdenCompra->OrdenCompraPedido)){
				foreach($InsOrdenCompra->OrdenCompraPedido as $DatOrdenCompraPedido){
					

			
					$InsPedidoCompra = new ClsPedidoCompra();
					$InsPedidoCompra->PcoId = $DatOrdenCompraPedido->PcoId;
					$InsPedidoCompra->MtdObtenerPedidoCompra();
					
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
					$mensaje .= "<table>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Cliente: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->CliNombre." ".$InsPedidoCompra->CliApellidoPaterno." ".$InsPedidoCompra->CliApellidoMaterno;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "Fecha: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->PcoFecha;
						$mensaje .= "</b></td>";
						
						
						$mensaje .= "<td>";
						$mensaje .= "Ord. Ven.: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiId;
						$mensaje .= "</b></td>";
						
						
						$mensaje .= "<td>";
						$mensaje .= "O/C Ref: ";
						$mensaje .= "</td>";
		
						$mensaje .= "<td><b>";
						$mensaje .= $InsPedidoCompra->VdiOrdenCompraNumero." - ".$InsPedidoCompra->VdiOrdenCompraFecha;
						$mensaje .= "</b></td>";
		
					$mensaje .= "</tr>";
									
					$mensaje .= "</table>";
									
									
									


					$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cod. Original";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Nombre";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Cantidad";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Estado";
						$mensaje .= "</td>";
						
						
		
					$mensaje .= "</tr>";

					
					$i = 1;
					if(!empty($InsPedidoCompra->PedidoCompraDetalle)){
						foreach($InsPedidoCompra->PedidoCompraDetalle as $DatPedidoCompraDetalle){
							
							$mensaje .= "<tr>";


								if(empty($DatPedidoCompraDetalle->TvdCantidad)){
									$fondo = "#F30";
								}else if($DatPedidoCompraDetalle->TvdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$fondo = "#6F3";
								}else if($DatPedidoCompraDetalle->TvdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
									$fondo = "#FC0";		
								}else{
									$fondo = "";	
								}
								
								
								$mensaje .= "<td>";
								$mensaje .= $i;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProCodigoOriginal;
								$mensaje .= "</td>";
				
								$mensaje .= "<td>";
								$mensaje .= $DatPedidoCompraDetalle->ProNombre;
								$mensaje .= "</td>";
								
								$mensaje .= "<td>";
								$mensaje .= number_format($DatPedidoCompraDetalle->PcdCantidad,2);
								$mensaje .= "</td>";
				
								$mensaje .= "<td bgcolor='".$fondo."'>";
								
								if(empty($DatPedidoCompraDetalle->TvdCantidad)){
									$mensaje .= "No Atendido";
								}else if($DatPedidoCompraDetalle->TvdCantidad >= $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Ya llego";
								}else if($DatPedidoCompraDetalle->TvdCantidad < $DatPedidoCompraDetalle->PcdCantidad){
									$mensaje .= "Incompleto, aun faltan (".($DatPedidoCompraDetalle->PcdCantidad - $DatPedidoCompraDetalle->TvdCantidad).") items";
								}else{
									$mensaje .= "</td>";
								}
								
								$mensaje .= "</td>";

							$mensaje .= "</tr>";
							$i++;							
						}
					}
					
					$mensaje .= "</table>";
					

					
				}
			}
			
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			///echo $mensaje;
			
			if($oImportante){
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." [IMPORTANTE]".$this->PrvApellidoMaterno,$mensaje);
						
			}else{
			
				$InsCorreo = new ClsCorreo();	
				$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: INGRESO A ALMACEN C/ ORDEN DE COMPRA: ".$this->OcoId." - ".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno,$mensaje);
					
			}
			
				
				
			
		}
}
?>