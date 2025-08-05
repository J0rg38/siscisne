<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenCodificacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenCodificacion {

    public $OciId;
	
	public $PrvId;
	public $OciFecha;
	public $OciFechaRespuesta;
	public $OciHora;
	
	public $OciSolicitante;
	public $OciSolicitanteCargo;
	
	public $OciDealerSucursal;
	public $OciDescripcionPN;
	
    public $OciObservacion;
	
	public $OciVIN;
	public $OciVehiculoModelo;
	public $OciVehiculoAnoFabricacion;
	
	public $OciVehiculoMotorCilindrada;
	public $OciOrigen;
	public $OciEstado;
	public $OciTiempoCreacion;
	public $OciTiempoModificacion;
    public $OciEliminado;
	
	public $PrvNombreCompleto;
	public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;

	public $TdoId;
	public $PrvNumeroDocumento;
	
	public $LtiNombre;
	public $TdoNombre;
	
	public $MonNombre;
	public $MonSimbolo;
				
	public $OciTotalItems;
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarOrdenCodificacionId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(oci.OciId,10),unsigned)) AS "MAXIMO"
		FROM tblociordencodificacion oci
			WHERE YEAR(oci.OciFecha) = '.$this->OciAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->OciId = "OCI-".$this->OciAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->OciId = "OCI-".$this->OciAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}
				
	}
		
    public function MtdObtenerOrdenCodificacion(){

        $sql = 'SELECT 
        oci.OciId,
		oci.PrvId,
		oci.PerId,
		
		DATE_FORMAT(oci.OciFecha, "%d/%m/%Y") AS "NOciFecha",
		DATE_FORMAT(oci.OciFechaRespuesta, "%d/%m/%Y") AS "NOciFechaRespuesta",
		oci.OciHora,

		oci.OciSolicitante,
		oci.OciSolicitanteCargo,
		
		oci.OciDealerSucursal,
		oci.OciDescripcionPN,
	
		oci.OciObservacion,
		oci.OciObservacionImpresa,
		oci.OciObservacionCorreo,
		
		oci.OciVIN,
		oci.OciVehiculoModelo,
		oci.OciVehiculoAnoFabricacion,
		oci.OciVehiculoMotorCilindrada,
		
		oci.OciFoto,
		oci.OciOrigen,		
		oci.OciEstado,
		DATE_FORMAT(oci.OciTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOciTiempoCreacion",
        DATE_FORMAT(oci.OciTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOciTiempoModificacion",

		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		
		prv.TdoId,
		prv.PrvNumeroDocumento,
		tdo.TdoNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerEmail
		
        FROM tblociordencodificacion oci
			
			LEFT JOIN tblprvproveedor prv
			ON oci.PrvId = prv.PrvId
			
				LEFT JOIN tbltdotipodocumento tdo
				ON prv.TdoId = tdo.TdoId
					
					LEFT JOIN tblperpersonal per
					ON oci.PerId = per.PerId
					
        WHERE oci.OciId = "'.$this->OciId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
		
			$this->OciId = $fila['OciId'];
			$this->PrvId = $fila['PrvId'];
			$this->PerId = $fila['PerId'];
			
			$this->OciFecha = $fila['NOciFecha'];
			$this->OciFechaRespuesta = $fila['NOciFechaRespuesta'];
			$this->OciHora = $fila['OciHora'];

			$this->OciSolicitante = $fila['OciSolicitante'];
			$this->OciSolicitanteCargo = $fila['OciSolicitanteCargo'];

			$this->OciDealerSucursal = $fila['OciDealerSucursal'];
			$this->OciDescripcionPN = $fila['OciDescripcionPN'];

			$this->OciVIN = $fila['OciVIN'];
			$this->OciVehiculoModelo = $fila['OciVehiculoModelo'];
			$this->OciVehiculoAnoFabricacion = $fila['OciVehiculoAnoFabricacion'];		
			$this->OciVehiculoMotorCilindrada = $fila['OciVehiculoMotorCilindrada'];
			$this->OciFoto = $fila['OciFoto'];
			
			$this->OciObservacion = $fila['OciObservacion'];
			$this->OciObservacionImpresa = $fila['OciObservacionImpresa'];
			$this->OciObservacionCorreo = $fila['OciObservacionCorreo'];
			
			$this->OciOrigen = $fila['OciOrigen'];
			
			
			$this->OciEstado = $fila['OciEstado'];
			$this->OciTiempoCreacion = $fila['NOciTiempoCreacion']; 
			$this->OciTiempoModificacion = $fila['NOciTiempoModificacion']; 	
			
			
			
			$this->PrvNombreCompleto = $fila['PrvNombreCompleto'];		
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			$this->TdoId = $fila['TdoId'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			
			$this->TdoNombre = $fila['TdoNombre'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerEmail = $fila['PerEmail'];

			
			switch($this->OciEstado){

				case 1:
					$this->OciEstadoDescripcion = "Pendiente";
				break;

				case 3:
					$this->OciEstadoDescripcion = "Realizado";
				break;	
				
				case 31:
					$this->OciEstadoDescripcion = "Enviado/Correo";
				break;	
				
				case 6:
					$this->OciEstadoDescripcion = "Anulado";
				break;	

				default:
					$this->OciEstadoDescripcion = "";
				break;

			}	
				

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerOrdenCodificaciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OciId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL) {

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
				
				//
//				$filtrar .= '  OR EXISTS( 
//					
//					SELECT 
//					ood.OodId
//					
//					FROM tbloodordencotizaciondetalle ood
//						
//						LEFT JOIN tblproproducto pro
//						ON ood.ProId = pro.ProId
//						
//							
//								
//								
//					WHERE 
//					
//						ood.OciId = oci.OciId
//						AND
//						(
//							pro.ProNombre LIKE "%'.$oFiltro.'%" OR
//							pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%"  OR
//							pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 
//						)
//						
//
//					) ';
					
					
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
				$fecha = ' AND DATE(oci.OciFecha)>="'.$oFechaInicio.'" AND DATE(oci.OciFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(oci.OciFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(oci.OciFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND oci.OciEstado = '.$oEstado;
		}

	
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				oci.OciId,
				oci.PrvId,	
				oci.PerId,
				
				DATE_FORMAT(oci.OciFecha, "%d/%m/%Y") AS "NOciFecha",
				DATE_FORMAT(oci.OciFechaRespuesta, "%d/%m/%Y") AS "NOciFechaRespuesta",
				oci.OciHora,
				
				oci.OciSolicitante,
				oci.OciSolicitanteCargo,
				
				oci.OciDealerSucursal,
				oci.OciDescripcionPN,
		
				oci.OciVIN,
				oci.OciVehiculoModelo,				
				oci.OciVehiculoAnoFabricacion,
				oci.OciVehiculoMotorCilindrada,
				oci.OciFoto,
				
				oci.OciObservacion,
				oci.OciObservacionImpresa,
				oci.OciObservacionCorreo,
				
				oci.OciOrigen,
				oci.OciEstado,
				DATE_FORMAT(oci.OciTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOciTiempoCreacion",
	        	DATE_FORMAT(oci.OciTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOciTiempoModificacion",
				
				
				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.TdoId,
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre,
				
				
					per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerEmail
		
		
				FROM tblociordencodificacion oci
			
						LEFT JOIN tblprvproveedor prv
						ON oci.PrvId = prv.PrvId
							
								LEFT JOIN tbltdotipodocumento tdo
								ON prv.TdoId = tdo.TdoId
								
										LEFT JOIN tblperpersonal per
										ON oci.PerId = per.PerId
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$stipo.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenCodificacion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenCodificacion = new $InsOrdenCodificacion();
                    $OrdenCodificacion->OciId = $fila['OciId'];
					
					$OrdenCodificacion->PrvId = $fila['PrvId'];
					$OrdenCodificacion->PerId = $fila['PerId'];
					
					$OrdenCodificacion->OciFecha = $fila['NOciFecha'];
					$OrdenCodificacion->OciFechaRespuesta = $fila['NOciFechaRespuesta'];
					$OrdenCodificacion->OciHora = $fila['OciHora'];
					
					$OrdenCodificacion->OciSolicitante = $fila['OciSolicitante'];
					$OrdenCodificacion->OciSolicitanteCargo = $fila['OciSolicitanteCargo'];
					
					$OrdenCodificacion->OciDealerSucursal = $fila['OciDealerSucursal'];
					$OrdenCodificacion->OciDescripcionPN = $fila['OciDescripcionPN'];					
					

					$OrdenCodificacion->OciVIN = $fila['OciVIN'];			
					$OrdenCodificacion->OciVehiculoModelo = $fila['OciVehiculoModelo'];
					$OrdenCodificacion->OciVehiculoAnoFabricacion = $fila['OciVehiculoAnoFabricacion'];
					$OrdenCodificacion->OciVehiculoMotorCilindrada = $fila['OciVehiculoMotorCilindrada'];
					$OrdenCodificacion->OciFoto = $fila['OciFoto'];

					
					
					
					$OrdenCodificacion->OciObservacion = $fila['OciObservacion'];
					$OrdenCodificacion->OciObservacionImpresa = $fila['OciObservacionImpresa'];
					$OrdenCodificacion->OciObservacionCorreo = $fila['OciObservacionCorreo'];
					
					
					$OrdenCodificacion->OciOrigen = $fila['OciOrigen'];
					$OrdenCodificacion->OciEstado = $fila['OciEstado'];
					$OrdenCodificacion->OciTiempoCreacion = $fila['NOciTiempoCreacion'];  
					$OrdenCodificacion->OciTiempoModificacion = $fila['NOciTiempoModificacion']; 

					$OrdenCodificacion->PrvNombreCompleto = $fila['PrvNombreCompleto'];
					$OrdenCodificacion->PrvNombre = $fila['PrvNombre'];
					$OrdenCodificacion->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$OrdenCodificacion->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$OrdenCodificacion->TdoId = $fila['TdoId'];
					$OrdenCodificacion->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];

					$OrdenCodificacion->TdoNombre = $fila['TdoNombre'];
					
					$OrdenCodificacion->PerNombre = $fila['PerNombre'];
					$OrdenCodificacion->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$OrdenCodificacion->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$OrdenCodificacion->PerEmail = $fila['PerEmail'];
					
		
					switch($OrdenCodificacion->OciEstado){
					
					case 1:
							$OrdenCodificacion->OciEstadoDescripcion = "Pendiente";
						break;
					
						case 3:
							$OrdenCodificacion->OciEstadoDescripcion = "Realizado";
						break;	
						
						case 31:
							$OrdenCodificacion->OciEstadoDescripcion = "Enviado/Correo";
						break;	
						
						case 6:
							$OrdenCodificacion->OciEstadoDescripcion = "Anulado";
						break;	
					
						default:
							$OrdenCodificacion->OciEstadoDescripcion = "";
						break;
					
					}
						

                    $OrdenCodificacion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenCodificacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}

	//Accion eliminar	 
	public function MtdEliminarOrdenCodificacion($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();


		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					$aux = explode("%",$elemento);	
					
						
						$sql = 'DELETE FROM tblociordencodificacion WHERE  (OciId = "'.($aux[0]).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarOrdenCodificacion(3,"Se elimino el Orden de Codificacion",$aux);		
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
	public function MtdActualizarEstadoOrdenCodificacion($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsOrdenCodificacion = new ClsOrdenCodificacion();
		

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblociordencodificacion SET OciEstado = '.$oEstado.' WHERE OciId = "'.$aux[0].'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarOrdenCodificacion(2,"Se actualizo el Estado del Orden de Codificacion",$aux);
				
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
	
	
	public function MtdRegistrarOrdenCodificacion($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarOrdenCodificacionId();
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
				
			
			$sql = 'INSERT INTO tblociordencodificacion (
			OciId,
			PrvId,
			PerId,
			
			OciFecha,
			OciFechaRespuesta,
			OciHora,
			
			OciSolicitante,
			OciSolicitanteCargo,
			OciDealerSucursal,
			OciDescripcionPN,
		
			OciVIN,
			OciVehiculoModelo,				
			OciVehiculoAnoFabricacion,
			OciVehiculoMotorCilindrada,
			OciFoto,
			
			OciObservacion,
			OciObservacionImpresa,
			OciObservacionCorreo,
			
			OciOrigen,
			OciEstado,			
			OciTiempoCreacion,
			OciTiempoModificacion) 
			VALUES (
			"'.($this->OciId).'", 
			
			'.(empty($this->PrvId)?"NULL,":'"'.$this->PrvId.'",').'
			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			
			"'.($this->OciFecha).'", 
			'.(empty($this->OciFechaRespuesta)?"NULL,":'"'.$this->OciFechaRespuesta.'",').'
			"'.($this->OciHora).'", 
			
			"'.($this->OciSolicitante).'", 
			"'.($this->OciSolicitanteCargo).'", 
			"'.($this->OciDealerSucursal).'",
			"'.($this->OciDescripcionPN).'",
			
			"'.($this->OciVIN).'",
			"'.($this->OciVehiculoModelo).'",
			"'.($this->OciVehiculoAnoFabricacion).'",
			"'.($this->OciVehiculoMotorCilindrada).'",
			"'.($this->OciFoto).'",
			
			"'.($this->OciObservacion).'",
			"'.($this->OciObservacionImpresa).'",
			"'.($this->OciObservacionCorreo).'",
			
			"'.($this->OciOrigen).'",			
			'.($this->OciEstado).',
			"'.($this->OciTiempoCreacion).'", 				
			"'.($this->OciTiempoModificacion).'");';			
				
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
				
			//	deb($this->InsMysql->MtdObtenerErrorCodigo());
				
				switch($this->InsMysql->MtdObtenerErrorCodigo()){
				
						case 1452:
							
							$cadena_error = $this->InsMysql->MtdObtenerError();
							$pos = strpos($cadena_error, "tblprvproveedor");

							if ($pos !== false) {
								$Resultado.="#ERR_OOT_1000";	
							}
							
						break;

				}
					
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
				$this->MtdAuditarOrdenCodificacion(1,"Se registro el Orden de Codificacion",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarOrdenCodificacion() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblociordencodificacion SET
			
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			
			OciFecha = "'.($this->OciFecha).'",
			'.(empty($this->OciFechaRespuesta)?'OciFechaRespuesta = NULL, ':'OciFechaRespuesta = "'.$this->OciFechaRespuesta.'",').'
			OciHora = "'.($this->OciHora).'",
			
			OciSolicitante = "'.($this->OciSolicitante).'",
			OciSolicitanteCargo = "'.($this->OciSolicitanteCargo).'",
			
			
			OciDealerSucursal = "'.($this->OciDealerSucursal).'",
			OciDescripcionPN = "'.($this->OciDescripcionPN).'",	
			
			
			OciVIN = "'.($this->OciVIN).'",
			OciVehiculoModelo = "'.($this->OciVehiculoModelo).'",
			OciVehiculoAnoFabricacion = "'.($this->OciVehiculoAnoFabricacion).'",	
			OciVehiculoMotorCilindrada = "'.($this->OciVehiculoMotorCilindrada).'",		
			OciFoto = "'.($this->OciFoto).'",			

			OciObservacion = "'.($this->OciObservacion).'",
			OciObservacionImpresa = "'.($this->OciObservacionImpresa).'",
			OciObservacionCorreo = "'.($this->OciObservacionCorreo).'",
			
			OciEstado = '.($this->OciEstado).',
			OciTiempoModificacion = "'.($this->OciTiempoModificacion).'"
			WHERE OciId = "'.($this->OciId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarOrdenCodificacion(2,"Se edito el Orden de Codificacion",$this);		
				return true;
			}	
				
		}	
		
		
		public function MtdEditarOrdenCodificacionDato($oCampo,$oDato,$oOrdenCodificacionId) {

			$error = false;

			$sql = 'UPDATE tblociordencodificacion SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			OciTiempoModificacion = NOW()
			WHERE OciId = "'.($oOrdenCodificacionId).'";';			

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
		
	
	
		private function MtdAuditarOrdenCodificacion($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->OciId;

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
		
		
		
		
		
		
		
		public function MtdGenerarExcelOrdenCodificacion($oOrdenCodificacion,$oRuta=NULL){
			
			global $EmpresaMonedaId;
			
			$Generado = true;
			
			if(!empty($oOrdenCodificacion)){

				$this->OciId = $oOrdenCodificacion;
				$this->MtdObtenerOrdenCodificacion();
					
					
				$objPHPExcel = new PHPExcel();
					
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load($oRuta."plantilla/TemOrdenCodificacionGM.xls");
					
					// Set document properties
					$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
												 ->setLastModifiedBy("Maarten Balliauw")
												 ->setTitle("PHPExcel Test Document")
												 ->setSubject("PHPExcel Test Document")
												 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
												 ->setKeywords("office PHPExcel php")
												 ->setCategory("Test result file");
					
					
												   
					$objPHPExcel->setActiveSheetIndex(0) 
								->setCellValue('C13', $this->OciId);
					$objPHPExcel->getActiveSheet()->getStyle('C13')->getFont()->setBold(true)->setSize(14);		
					
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C14', $this->OciFecha);		
								
					 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C15', $this->OciHora);		  
								
					 $objPHPExcel->setActiveSheetIndex(0)
            					->setCellValue('C16', $this->PerNombre.' '.$this->PerApellidoPaterno.' '.$this->PerApellidoMaterno);	
			
								
									
					 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C17', $this->OciSolicitanteCargo);	
								
					 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C18', $this->OciDealerSucursal);	
			
								
					 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C19', $this->OciDescripcionPN);				
									
					 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C20', $this->OciVIN);								
					
					 $objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C21', $this->OciVehiculoModelo);	
								
					 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('C22', $this->OciVehiculoAnoFabricacion);	
						
					 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('C23', $this->OciVehiculoMotorCilindrada);		

					 $objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('C24', $this->OciObservacionImpresa);		
					
					
					if(!empty($this->OciFoto)){
	
	
						$objDrawing = new PHPExcel_Worksheet_Drawing();
						$objDrawing->setName('Thumb');
						$objDrawing->setDescription('Thumbnail Image');
						$objDrawing->setPath('subidos/orden_codificacion_fotos/'.$this->OciFoto);
						$objDrawing->setHeight(180);
						$objDrawing->setWidth(180);
						$objDrawing->setCoordinates('B28');
						$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						
						
					}



					// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle('Codificacion GM ');
					
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save($oRuta."generados/".$this->OciId.".xls");
					
					
					
					
			}else{
				$Generado = false;
			}

			return $Generado;
		
		}
		
				
		
		public function MtdEnviarCorreoPedidoOrdenCodificacion($oOrdenCodificacion,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->OciId = $oOrdenCodificacion;
			$this->MtdObtenerOrdenCodificacion();

			$mensaje = "";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			
			
			$mensaje .= "<br>";
			$mensaje .= "<b>Estimados Señores.-</b>";
			$mensaje .= "<br><br>";
			
			$mensaje .= "Se envia consulta tecnica";
			$mensaje .= "<br><br>";
			
			if(!empty($this->OciDescripcionPN)){

				$mensaje .= "<b>Descripcion de PN Solicitado:</b> ".$this->OciDescripcionPN;
				$mensaje .= "<br>";
			
			}
			
			if(!empty($this->OciVIN)){

				$mensaje .= "<b>VIN:</b> ".$this->OciVIN;
				$mensaje .= "<br>";
			
			}
			
			if(!empty($this->OciVehiculoModelo)){

				$mensaje .= "<b>Modelo:</b> ".$this->OciVehiculoModelo;
				$mensaje .= "<br>";
			
			}
			if(!empty($this->OciVehiculoAnoFabricacion)){

				$mensaje .= "<b>Año de Fabricacion:</b> ".$this->OciVehiculoAnoFabricacion;
				$mensaje .= "<br>";
			
			}
			
			
			if(!empty($this->OciObservacionCorreo)){

				$mensaje .= $this->OciObservacionCorreo;
				$mensaje .= "<br>";
				$mensaje .= "<br>";
	
			}
			
			$mensaje .= "Estare a la espera de su pronta respuesta.";
			$mensaje .= "<br><br>";
			//$mensaje .= "Saludos";
			
			if(!empty($oRemitente)){

				$mensaje .= "<br><br>";
				$mensaje .= "Atte.";
				
				$mensaje .= "<br><br>";
				$mensaje .= $oRemitente;
	
			}
			
			
			$mensaje .= "<br><br>";
			$mensaje .= "Gracias";
			$mensaje .= "<br><br>";

			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');

			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,"SISTEMA CYC","CONSULTA TECNICA PN: ".$this->OciId,$mensaje,$oRuta."generados/",$this->OciId.".xls");
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","iquezada@cyc.com.pe",$SistemaCorreoRemitente,"PEDIDO CYC-STK-2015-01-001 2",$Mensaje,"generados/","CYC-STK-2015-01-001.xls");

		}





}
?>