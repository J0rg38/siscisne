<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOrdenCotizacion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsOrdenCotizacion {

    public $OotId;
	
	public $PrvId;
	public $OotFecha;
	public $OotFechaRespuesta;
	public $OotHora;
	
	public $MonId;
	public $OotTipoCambio;
	
	public $OotIncluyeImpuesto;
	public $OotPorcentajeImpuestoVenta;
	
    public $OotObservacion;
	
	public $OotSubTotal;
	public $OotImpuesto;
	public $OotTotal;
	
	public $OotCodigoExterno;
	public $OotOrigen;
	public $OotEstado;
	public $OotTiempoCreacion;
	public $OotTiempoModificacion;
    public $OotEliminado;
	
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
				
	public $OotTotalItems;
	public $OrdenCotizacionDetalle;

    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarOrdenCotizacionId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(oot.OotId,10),unsigned)) AS "MAXIMO"
		FROM tblootordencotizacion oot
			WHERE YEAR(oot.OotFecha) = '.$this->OotAno.';';
			
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
		if(empty($fila['MAXIMO'])){			
			$this->OotId = "CCO-".$this->OotAno."-00001";
		}else{
			$fila['MAXIMO']++;
			$this->OotId = "CCO-".$this->OotAno."-".str_pad($fila['MAXIMO'], 5, "0", STR_PAD_LEFT);	
		}
				
	}
		
    public function MtdObtenerOrdenCotizacion(){

        $sql = 'SELECT 
        oot.OotId,
		oot.PrvId,
		oot.PerId,
		
		DATE_FORMAT(oot.OotFecha, "%d/%m/%Y") AS "NOotFecha",
		DATE_FORMAT(oot.OotFechaRespuesta, "%d/%m/%Y") AS "NOotFechaRespuesta",
		oot.OotHora,

		oot.MonId,
		oot.OotTipoCambio,
		
		oot.OotIncluyeImpuesto,
		oot.OotPorcentajeImpuestoVenta,
	
		oot.OotObservacion,

		oot.OotSubTotal,
		oot.OotImpuesto,
		oot.OotTotal,

		oot.OotOrigen,
		oot.OotCodigoExterno,
		oot.OotCodigoReferencia,
		oot.OotEstado,
		DATE_FORMAT(oot.OotTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOotTiempoCreacion",
        DATE_FORMAT(oot.OotTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOotTiempoModificacion",

		(SELECT COUNT(ood.OodId) FROM tbloodordencotizaciondetalle ood WHERE ood.OotId = oot.OotId ) AS "OotTotalItems",

		prv.PrvNombreCompleto,
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		
		prv.TdoId,
		prv.PrvNumeroDocumento,
		tdo.TdoNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		per.PerEmail
		
        FROM tblootordencotizacion oot
			
			LEFT JOIN tblperpersonal per
			ON oot.PerId = per.PerId
			
			LEFT JOIN tblprvproveedor prv
			ON oot.PrvId = prv.PrvId
			
				LEFT JOIN tbltdotipodocumento tdo
				ON prv.TdoId = tdo.TdoId
					
					LEFT JOIN tblmonmoneda mon
					ON oot.MonId = mon.MonId
							
        WHERE oot.OotId = "'.$this->OotId.'"';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			$InsOrdenCotizacionDetalle = new ClsOrdenCotizacionDetalle();
			
				
			$this->OotId = $fila['OotId'];
			$this->PrvId = $fila['PrvId'];
			$this->PerId = $fila['PerId'];
			
			$this->OotFecha = $fila['NOotFecha'];
			$this->OotFechaRespuesta = $fila['NOotFechaRespuesta'];
			$this->OotHora = $fila['OotHora'];

			$this->MonId = $fila['MonId'];
			$this->OotTipoCambio = $fila['OotTipoCambio'];

			$this->OotIncluyeImpuesto = $fila['OotIncluyeImpuesto'];
			$this->OotPorcentajeImpuestoVenta = $fila['OotPorcentajeImpuestoVenta'];

			$this->OotObservacion = $fila['OotObservacion'];

			$this->OotSubTotal = $fila['OotSubTotal'];
			$this->OotImpuesto = $fila['OotImpuesto'];
			$this->OotTotal = $fila['OotTotal'];

			$this->OotOrigen = $fila['OotOrigen'];
			$this->OotCodigoExterno = $fila['OotCodigoExterno'];
			
			$this->OotCodigoReferencia = $fila['OotCodigoReferencia'];
			$this->OotEstado = $fila['OotEstado'];
			$this->OotTiempoCreacion = $fila['NOotTiempoCreacion']; 
			$this->OotTiempoModificacion = $fila['NOotTiempoModificacion']; 	
			
			$this->OotTotalItems = $fila['OotTotalItems'];

			$this->PrvNombreCompleto = $fila['PrvNombreCompleto'];		
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			$this->TdoId = $fila['TdoId'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			
			$this->TdoNombre = $fila['TdoNombre'];

			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->PerEmail = $fila['PerEmail'];
			
			switch($this->OotEstado){

				case 1:
					$this->OotEstadoDescripcion = "Pendiente";
				break;

				case 3:
					$this->OotEstadoDescripcion = "Realizado";
				break;	
				
				case 31:
					$this->OotEstadoDescripcion = "Enviado/Correo";
				break;	
				
				case 6:
					$this->OotEstadoDescripcion = "Anulado";
				break;	

				default:
					$this->OotEstadoDescripcion = "";
				break;

			}	
				
			switch($this->OotEstado){
					
				case 1:
					$this->OotEstadoIcono = '<img width="15" height="15" alt="[Armado]" title="En Armado" src="imagenes/estado/pendiente.gif" />';
				break;
			
				case 3:
					$this->OotEstadoIcono = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';
				break;	
				
				case 31:
					$this->OotEstadoIcono = '<img width="15" height="15" alt="[Correo Enviado]" title="Correo Enviado" src="imagenes/estado/correo_enviado.png" />';
				break;	
				
				case 6:
					$this->OotEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src=" imagenes/estado/anulado.png" />';
				break;	
			
				default:
					$this->OotEstadoIcono = "";
				break;
			
			}
					
						
			$ResOrdenCotizacionDetalle =  $InsOrdenCotizacionDetalle->MtdObtenerOrdenCotizacionDetalles(NULL,NULL,NULL,NULL,NULL,$this->OotId);
			$this->OrdenCotizacionDetalle = 	$ResOrdenCotizacionDetalle['Datos'];	

		}
        
		$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }


    public function MtdObtenerOrdenCotizaciones($oCampo=NULL,$oCondicion="contiene",$oFiltro=NULL,$oOrden = 'OotId',$oSentido = 'Desc',$oPaginacion = '0,10',$oFechaInicio=NULL,$oFechaFin=NULL,$oEstado=NULL,$oMoneda=NULL,$oSucursal=NULL) {

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
					ood.OodId
					
					FROM tbloodordencotizaciondetalle ood
						
						LEFT JOIN tblproproducto pro
						ON ood.ProId = pro.ProId
						
							
								
								
					WHERE 
					
						ood.OotId = oot.OotId
						AND
						(
							pro.ProNombre LIKE "%'.$oFiltro.'%" OR
							pro.ProCodigoOriginal LIKE "%'.$oFiltro.'%"  OR
							pro.ProCodigoAlternativo LIKE "%'.$oFiltro.'%" 
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
				$fecha = ' AND DATE(oot.OotFecha)>="'.$oFechaInicio.'" AND DATE(oot.OotFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(oot.OotFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(oot.OotFecha)<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oEstado)){
			$estado = ' AND oot.OotEstado = '.$oEstado;
		}

		if(!empty($oMoneda)){
			$moneda = ' AND oot.MonId = "'.$oMoneda.'"';
		}
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND oot.SucId = "'.$oSucursal.'"';
		}
		
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				oot.OotId,
				oot.SucId,
				
				oot.PrvId,	
				oot.PerId,
				
				DATE_FORMAT(oot.OotFecha, "%d/%m/%Y") AS "NOotFecha",
				DATE_FORMAT(oot.OotFechaRespuesta, "%d/%m/%Y") AS "NOotFechaRespuesta",
				oot.OotHora,
				
				oot.MonId,
				oot.OotTipoCambio,
				
				oot.OotIncluyeImpuesto,
				oot.OotPorcentajeImpuestoVenta,
		
				oot.OotObservacion,

				oot.OotSubTotal,
				oot.OotImpuesto,				
				oot.OotTotal,
				
				oot.OotOrigen,
				oot.OotCodigoExterno,
				oot.OotCodigoReferencia,
				oot.OotEstado,
				DATE_FORMAT(oot.OotTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NOotTiempoCreacion",
	        	DATE_FORMAT(oot.OotTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NOotTiempoModificacion",
				
				(SELECT COUNT(ood.OodId) FROM tbloodordencotizaciondetalle ood WHERE ood.OotId = oot.OotId ) AS "OotTotalItems",
				
				prv.PrvNombreCompleto,
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.TdoId,
				prv.PrvNumeroDocumento,
				
				tdo.TdoNombre,
				
				mon.MonNombre,
				mon.MonSimbolo
				
				FROM tblootordencotizacion oot
			
					LEFT JOIN tblmonmoneda mon
					ON oot.MonId = mon.MonId
						
						LEFT JOIN tblprvproveedor prv
						ON oot.PrvId = prv.PrvId
							
							LEFT JOIN tbltdotipodocumento tdo
							ON prv.TdoId = tdo.TdoId
										
				WHERE 1 = 1 '.$filtrar.$fecha.$tipo.$sucursal.$stipo.$estado.$moneda.$cocompra.$vdirecta.$ocompra.$faccion.$fingreso.$orden.$paginacion;
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsOrdenCotizacion = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$OrdenCotizacion = new $InsOrdenCotizacion();
                    $OrdenCotizacion->OotId = $fila['OotId'];
					 $OrdenCotizacion->SucId = $fila['SucId'];
					
					$OrdenCotizacion->PrvId = $fila['PrvId'];
					$OrdenCotizacion->PerId = $fila['PerId'];
					
					$OrdenCotizacion->OotFecha = $fila['NOotFecha'];
					$OrdenCotizacion->OotFechaRespuesta = $fila['NOotFechaRespuesta'];
					$OrdenCotizacion->OotHora = $fila['OotHora'];
					
					$OrdenCotizacion->MonId = $fila['MonId'];
					$OrdenCotizacion->OotTipoCambio = $fila['OotTipoCambio'];
					
					$OrdenCotizacion->OotIncluyeImpuesto = $fila['OotIncluyeImpuesto'];
					$OrdenCotizacion->OotPorcentajeImpuestoVenta = $fila['OotPorcentajeImpuestoVenta'];					
					$OrdenCotizacion->OotObservacion = $fila['OotObservacion'];

					$OrdenCotizacion->OotSubTotal = $fila['OotSubTotal'];			
					$OrdenCotizacion->OotImpuesto = $fila['OotImpuesto'];
					$OrdenCotizacion->OotTotal = $fila['OotTotal'];

					$OrdenCotizacion->OotOrigen = $fila['OotOrigen'];
					$OrdenCotizacion->OotCodigoExterno = $fila['OotCodigoExterno'];
					$OrdenCotizacion->OotCodigoReferencia = $fila['OotCodigoReferencia'];
					$OrdenCotizacion->OotEstado = $fila['OotEstado'];
					$OrdenCotizacion->OotTiempoCreacion = $fila['NOotTiempoCreacion'];  
					$OrdenCotizacion->OotTiempoModificacion = $fila['NOotTiempoModificacion']; 

					$OrdenCotizacion->OotTotalItems = $fila['OotTotalItems']; 

					$OrdenCotizacion->CprId = $fila['CprId'];

					$OrdenCotizacion->PrvNombreCompleto = $fila['PrvNombreCompleto'];
					$OrdenCotizacion->PrvNombre = $fila['PrvNombre'];
					$OrdenCotizacion->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$OrdenCotizacion->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$OrdenCotizacion->TdoId = $fila['TdoId'];
					$OrdenCotizacion->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];

					$OrdenCotizacion->TdoNombre = $fila['TdoNombre'];
					
					$OrdenCotizacion->MonNombre = $fila['MonNombre'];
					$OrdenCotizacion->MonSimbolo = $fila['MonSimbolo'];
					
					switch($OrdenCotizacion->OotEstado){
					
					case 1:
							$OrdenCotizacion->OotEstadoDescripcion = "Pendiente";
						break;
					
						case 3:
							$OrdenCotizacion->OotEstadoDescripcion = "Realizado";
						break;	
						
						case 31:
							$OrdenCotizacion->OotEstadoDescripcion = "Enviado/Correo";
						break;	
						
						case 6:
							$OrdenCotizacion->OotEstadoDescripcion = "Anulado";
						break;	
					
						default:
							$OrdenCotizacion->OotEstadoDescripcion = "";
						break;
					
					}
										
					switch($OrdenCotizacion->OotEstado){
					
						case 1:
							$OrdenCotizacion->OotEstadoIcono = '<img width="15" height="15" alt="[Armado]" title="En Armado" src="imagenes/estado/pendiente.gif" />';
						break;
					
						case 3:
							$OrdenCotizacion->OotEstadoIcono = '<img width="15" height="15" alt="[Enviado]" title="Enviado" src="imagenes/estado/realizado.gif" />';
						break;	
						
						case 31:
							$OrdenCotizacion->OotEstadoIcono = '<img width="15" height="15" alt="[Correo Enviado]" title="Correo Enviado" src="imagenes/estado/correo_enviado.png" />';
						break;	
						
						case 6:
							$OrdenCotizacion->OotEstadoIcono = '<img width="15" height="15" alt="[Anulado]" title="Anulado" src=" imagenes/estado/anulado.png" />';
						break;	
					
						default:
							$OrdenCotizacion->OotEstadoIcono = "";
						break;
					
					}

					$OrdenCotizacion->FinId = $fila['FinId'];
					$OrdenCotizacion->MinNombre = $fila['MinNombre'];

                    $OrdenCotizacion->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $OrdenCotizacion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}

	//Accion eliminar	 
	public function MtdEliminarOrdenCotizacion($oElementos) {

		$this->InsMysql->MtdTransaccionIniciar();

		$InsOrdenCotizacionDetalle = new ClsOrdenCotizacionDetalle();

		$error = false;
		
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				
				if(!empty($elemento)){
					$aux = explode("%",$elemento);	
					
					$ResOrdenCotizacionDetalle = $InsOrdenCotizacionDetalle->MtdObtenerOrdenCotizacionDetalles(NULL,NULL,'OodId','Desc',NULL,$aux[0]);
					$ArrOrdenCotizacionDetalles = $ResOrdenCotizacionDetalle['Datos'];

					if(!empty($ArrOrdenCotizacionDetalles)){
						$amdetalle = '';

						foreach($ArrOrdenCotizacionDetalles as $DatOrdenCotizacionDetalle){
							$amdetalle .= '#'.$DatOrdenCotizacionDetalle->OodId;
						}

						if(!$InsOrdenCotizacionDetalle->MtdEliminarOrdenCotizacionDetalle($amdetalle)){								
							$error = true;
						}
							
					}
					
					if(!$error) {		
						$sql = 'DELETE FROM tblootordencotizacion WHERE  (OotId = "'.($aux[0]).'" ) ';
													
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarOrdenCotizacion(3,"Se elimino el Orden de Cotizacion",$aux);		
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
	public function MtdActualizarEstadoOrdenCotizacion($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsOrdenCotizacion = new ClsOrdenCotizacion();
		$InsOrdenCotizacionDetalles = new ClsOrdenCotizacionDetalle();

			$i=1;
			foreach($elementos as $elemento){

				
				if(!empty($elemento)){
				$aux = explode("%",$elemento);	

					$sql = 'UPDATE tblootordencotizacion SET OotEstado = '.$oEstado.' WHERE OotId = "'.$aux[0].'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarOrdenCotizacion(2,"Se actualizo el Estado del Orden de Cotizacion",$aux);
				
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
	
	
	public function MtdRegistrarOrdenCotizacion($oTransaccion=true) {
	
		global $Resultado;
		$error = false;

			$this->MtdGenerarOrdenCotizacionId();
			
			if($oTransaccion){
				$this->InsMysql->MtdTransaccionIniciar();	
			}
			
			$sql = 'INSERT INTO tblootordencotizacion (
			OotId,
			SucId,
			
			PrvId,
			PerId,
			
			OotFecha,
			OotFechaRespuesta,
			OotHora,
			MonId,
			OotTipoCambio,
			OotIncluyeImpuesto,
			OotPorcentajeImpuestoVenta,
			OotObservacion,
			
			OotSubTotal,
			OotImpuesto,				
			OotTotal,
			OotOrigen,
			
			OotCodigoExterno,
			OotEstado,			
			OotTiempoCreacion,
			OotTiempoModificacion) 
			VALUES (
			"'.($this->OotId).'", 
			"'.($this->SucId).'", 
			
			'.(empty($this->PrvId)?"NULL,":'"'.$this->PrvId.'",').'
			'.(empty($this->PerId)?"NULL,":'"'.$this->PerId.'",').'
			
			"'.($this->OotFecha).'", 
			'.(empty($this->OotFechaRespuesta)?"NULL,":'"'.$this->OotFechaRespuesta.'",').'
			"'.($this->OotHora).'", 
			
			"'.($this->MonId).'", 
			'.(empty($this->OotTipoCambio)?"NULL,":''.$this->OotTipoCambio.',').'
			
			'.($this->OotIncluyeImpuesto).',
			'.($this->OotPorcentajeImpuestoVenta).',

			"'.($this->OotObservacion).'",
			
			'.($this->OotSubTotal).',
			'.($this->OotImpuesto).',
			'.($this->OotTotal).',
			"'.($this->OotOrigen).'",
			
			"'.($this->OotCodigoExterno).'",
			'.($this->OotEstado).',
			"'.($this->OotTiempoCreacion).'", 				
			"'.($this->OotTiempoModificacion).'");';			
				
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
						
						
					
			if(!$error){			
			
				if (!empty($this->OrdenCotizacionDetalle)){		
						
					$validar = 0;				
					$InsOrdenCotizacionDetalle = new ClsOrdenCotizacionDetalle();		
					
					foreach ($this->OrdenCotizacionDetalle as $DatOrdenCotizacionDetalle){
					
						$InsOrdenCotizacionDetalle->OotId = $this->OotId;
						$InsOrdenCotizacionDetalle->ProId = $DatOrdenCotizacionDetalle->ProId;
						$InsOrdenCotizacionDetalle->UmeId = $DatOrdenCotizacionDetalle->UmeId;
						
						$InsOrdenCotizacionDetalle->OodAno = $DatOrdenCotizacionDetalle->OodAno;
						$InsOrdenCotizacionDetalle->OodModelo = $DatOrdenCotizacionDetalle->OodModelo;
						$InsOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio;
						
						$InsOrdenCotizacionDetalle->OodEstado = $DatOrdenCotizacionDetalle->OodEstado;									
						$InsOrdenCotizacionDetalle->OodTiempoCreacion = $DatOrdenCotizacionDetalle->OodTiempoCreacion;
						$InsOrdenCotizacionDetalle->OodTiempoModificacion = $DatOrdenCotizacionDetalle->OodTiempoModificacion;						
						$InsOrdenCotizacionDetalle->OodEliminado = $DatOrdenCotizacionDetalle->OodEliminado;
						
						if($InsOrdenCotizacionDetalle->MtdRegistrarOrdenCotizacionDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_OOT_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->OrdenCotizacionDetalle) <> $validar ){
						$error = true;
					}					
								
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
				$this->MtdAuditarOrdenCotizacion(1,"Se registro el Orden de Cotizacion",$this);			
				return true;
			}			
					
	}
	
	public function MtdEditarOrdenCotizacion() {

		global $Resultado;
		$error = false;

			$sql = 'UPDATE tblootordencotizacion SET
			SucId = "'.($this->SucId).'",
			
			'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
			'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
			
			OotFecha = "'.($this->OotFecha).'",
			'.(empty($this->OotFechaRespuesta)?'OotFechaRespuesta = NULL, ':'OotFechaRespuesta = "'.$this->OotFechaRespuesta.'",').'
			OotHora = "'.($this->OotHora).'",
			
			MonId = "'.($this->MonId).'",
			
			'.(empty($this->OotTipoCambio)?'OotTipoCambio = NULL, ':'OotTipoCambio = '.$this->OotTipoCambio.',').'
			
			OotIncluyeImpuesto = '.($this->OotIncluyeImpuesto).',
			OotPorcentajeImpuestoVenta = '.($this->OotPorcentajeImpuestoVenta).',	
			OotObservacion = "'.($this->OotObservacion).'",
			
			OotSubTotal = '.($this->OotSubTotal).',
			OotImpuesto = '.($this->OotImpuesto).',
			OotTotal = '.($this->OotTotal).',			
			OotEstado = '.($this->OotEstado).',
			OotTiempoModificacion = "'.($this->OotTiempoModificacion).'"
			WHERE OotId = "'.($this->OotId).'";';			
		
			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 		
			
			if(!$error){
			
				if (!empty($this->OrdenCotizacionDetalle)){		
						
						
					$validar = 0;				
					$InsOrdenCotizacionDetalle = new ClsOrdenCotizacionDetalle();
							
					foreach ($this->OrdenCotizacionDetalle as $DatOrdenCotizacionDetalle){
										
						$InsOrdenCotizacionDetalle->OodId = $DatOrdenCotizacionDetalle->OodId;
						$InsOrdenCotizacionDetalle->OotId = $this->OotId;
						$InsOrdenCotizacionDetalle->ProId = $DatOrdenCotizacionDetalle->ProId;
						$InsOrdenCotizacionDetalle->UmeId = $DatOrdenCotizacionDetalle->UmeId;
					
						$InsOrdenCotizacionDetalle->OodAno = $DatOrdenCotizacionDetalle->OodAno;
						$InsOrdenCotizacionDetalle->OodModelo = $DatOrdenCotizacionDetalle->OodModelo;
						$InsOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio;
						
						$InsOrdenCotizacionDetalle->OodEstado = $DatOrdenCotizacionDetalle->OodEstado;
						$InsOrdenCotizacionDetalle->OodTiempoCreacion = $DatOrdenCotizacionDetalle->OodTiempoCreacion;
						$InsOrdenCotizacionDetalle->OodTiempoModificacion = $DatOrdenCotizacionDetalle->OodTiempoModificacion;
						$InsOrdenCotizacionDetalle->OodEliminado = $DatOrdenCotizacionDetalle->OodEliminado;
						
						if(empty($InsOrdenCotizacionDetalle->OodId)){
							if($InsOrdenCotizacionDetalle->OodEliminado<>2){
								if($InsOrdenCotizacionDetalle->MtdRegistrarOrdenCotizacionDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OOT_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsOrdenCotizacionDetalle->OodEliminado==2){
								if($InsOrdenCotizacionDetalle->MtdEliminarOrdenCotizacionDetalle($InsOrdenCotizacionDetalle->OodId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_OOT_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsOrdenCotizacionDetalle->MtdEditarOrdenCotizacionDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_OOT_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->OrdenCotizacionDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();				
				
				$this->MtdAuditarOrdenCotizacion(2,"Se edito el Orden de Cotizacion",$this);		
				return true;
			}	
				
		}	
		
		
		public function MtdEditarOrdenCotizacionOrdenCotizacion() {

			$error = false;

			$sql = 'UPDATE tblootordencotizacion SET
			'.(empty($this->OotId)?'OotId = NULL, ':'OotId = "'.$this->OotId.'",').'
			OotTiempoModificacion = "'.($this->OotTiempoModificacion).'"
			WHERE OotId = "'.($this->OotId).'";';			

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
		
		public function MtdEditarOrdenCotizacionDato($oCampo,$oDato,$oOrdenCotizacionId) {

			$error = false;

			$sql = 'UPDATE tblootordencotizacion SET
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			OotTiempoModificacion = NOW()
			WHERE OotId = "'.($oOrdenCotizacionId).'";';			

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
		
	
	
		private function MtdAuditarOrdenCotizacion($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->OotId;

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
		
		
		
		
		
		
		
		public function MtdGenerarExcelOrdenCotizacion($oOrdenCotizacion,$oRuta=NULL){
			
			global $EmpresaMonedaId;
			
			$Generado = true;
			
			if(!empty($oOrdenCotizacion)){

				$this->OotId = $oOrdenCotizacion;
				$this->MtdObtenerOrdenCotizacion();
					
					
				$objPHPExcel = new PHPExcel();
					
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load($oRuta."plantilla/TemOrdenCotizacion".(($this->OotTipo<>"ALM")?"GM":"").".xls");
					
					// Set document properties
					$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
												 ->setLastModifiedBy("Maarten Balliauw")
												 ->setTitle("PHPExcel Test Document")
												 ->setSubject("PHPExcel Test Document")
												 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
												 ->setKeywords("office PHPExcel php")
												 ->setCategory("Test result file");
					
					// Miscellaneous glyphs, UTF-8
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F8', 'COTIZACION - C&C');
					$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true)->setSize(14);
								
																				   
												   
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('F9', $this->OotId);
					$objPHPExcel->getActiveSheet()->getStyle('F9')->getFont()->setBold(true)->setSize(14);		
					
					
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C11', 'CÓDIGO SAP');
					$objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
						
						
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
								
								
								
								
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('C12', 'Codigo Dealer');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E12', '8001200006');
								
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C13', 'Fecha');
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E13', $this->OotFecha);
					
					
					$objPHPExcel->getActiveSheet()->getStyle('C12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('E12')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
						
						
						
						
					$objPHPExcel->getActiveSheet()->getStyle('C13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					$objPHPExcel->getActiveSheet()->getStyle('D13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('E13')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					
					
						
					
					
					
					$objPHPExcel->getActiveSheet()->getStyle("C12")->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle("D12")->getAlignment()->setWrapText(true);
					
					$objPHPExcel->getActiveSheet()->getStyle("C13")->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getStyle("D13")->getAlignment()->setWrapText(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
					
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
					
					$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('C14', 'Hora');	
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('E14', $this->OotHora);						
							
							
					$objPHPExcel->getActiveSheet()->getStyle('C14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
						
					$objPHPExcel->getActiveSheet()->getStyle('D14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
						
					
					$objPHPExcel->getActiveSheet()->getStyle('E14')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);	
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
					$objPHPExcel->getActiveSheet()->getStyle('C17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('C17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								
													
													
													
						
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('D17', 'GM PN Replace');		
					$objPHPExcel->getActiveSheet()->getStyle('D17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('D17')->getFont()->setBold(true);	
					$objPHPExcel->getActiveSheet()->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 								                             
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E16', 'DEALER');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('E17', 'Cantidad de Pedido');
					$objPHPExcel->getActiveSheet()->getStyle('E17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('E17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 							   
												  
													
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('F16', 'GM');
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('F17', 'Partes a Atender');
					$objPHPExcel->getActiveSheet()->getStyle('F17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('F17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												   
															
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('G16', 'GM');	
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('G17', 'B/O');
					$objPHPExcel->getActiveSheet()->getStyle('G17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					
					$objPHPExcel->getActiveSheet()->getStyle('G17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('G17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
													
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('H16', 'GM');			
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('H17', 'Descripcion');
					$objPHPExcel->getActiveSheet()->getStyle('H17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('H17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('H17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
												   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('I17', 'Año');
					$objPHPExcel->getActiveSheet()->getStyle('I17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('I17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('I17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('J17', 'Modelo');
					$objPHPExcel->getActiveSheet()->getStyle('J17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('J17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('J17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   
												   
						
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('K16', 'GM');	
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('K17', 'Precio');
					$objPHPExcel->getActiveSheet()->getStyle('K17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);
					$objPHPExcel->getActiveSheet()->getStyle('K17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('K17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);							   							   
												   
																
					//$objPHPExcel->setActiveSheetIndex(0)
					//            ->setCellValue('L17', 'Total');
					$objPHPExcel->getActiveSheet()->getStyle('L17')->applyFromArray(
						array(
							  'borders' => array(
													'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
													'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
												)
							 )
						);			
					$objPHPExcel->getActiveSheet()->getStyle('L17')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					$objPHPExcel->getActiveSheet()->getStyle('C17:L17')->applyFromArray(
						array('fill' 	=> array(
													'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
													'color'		=> array('rgb' => '8DB4E3')
												)
													
							 )
						);
					
					
					
					
					
					$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G14', 'Notas:');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H14', $InsOrdenCotizacion->OotObservacion);
			
					
					
					$fila = 18;
					$indice = 1;
					
					
					$TotalReal = 0;
					$Total = 0;
					if(!empty($this->OrdenCotizacionDetalle)){
						foreach($this->OrdenCotizacionDetalle as $DatOrdenCotizacionDetalle){
							
				
									//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila, $indice);
									
									//C
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $DatOrdenCotizacionDetalle->ProCodigoOriginal);
									$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
										$objPHPExcel->getActiveSheet()->getStyle('C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										
										//D
										
										$objPHPExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
						
						
						
						
									//E
						
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila, $DatOrdenCotizacionDetalle->OodCantidad);
									$objPHPExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//F
									
									$objPHPExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//G
									
									$objPHPExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//H
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila, $DatOrdenCotizacionDetalle->ProNombre);
									$objPHPExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//I
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila, $DatOrdenCotizacionDetalle->OodAno);
									$objPHPExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
									//J
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila, $DatOrdenCotizacionDetalle->OodModelo);
									$objPHPExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
										
										
									//K
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, 0);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
										
									//L
									
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, 0);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
						
									
									$Total += $DatOrdenCotizacionDetalle->OodImporte;
									
									$fila++;
									$indice++;
								
								
					
							
						}
						
					}
					
					$objPHPExcel->getActiveSheet()->getStyle('C'.$fila.':K'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array('fill' 	=> array(
																	'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
																	'color'		=> array('rgb' => '8DB4E3')
																)
																	
											 )
										);
					
					
					//
					//$objPHPExcel->getActiveSheet()->getStyle('B20:L'.$fila)->applyFromArray(
					//	array(
					//		  'borders' => array(
					//		  						'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
					//								'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
					//								
					//								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
					//								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
					//							)
					//		 )
					//	);
						
					//$objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':L'.$fila)->applyFromArray(
					//	array('fill' 	=> array(
					//								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
					//								'color'		=> array('argb' => 'FFFFFF00')
					//							),
					//		 )
					//	);
						
					//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila, "TOTAL:");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila, $Total);
					
									$objPHPExcel->getActiveSheet()->getStyle('L'.$fila)->applyFromArray(
										array(
											  'borders' => array(
																	'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'right'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN ),
																	'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN )
																)
											 )
										);
					
//					$this->MtdEditarOrdenCotizacionDato("OotTotal",$TotalReal,$this->OotId);
					
					
					//$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
					//$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
					//$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
					
					// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle('Cotizacion GM ');
					
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save($oRuta."generados/".$this->OotId.".xls");
					
					
					
					
			}else{
				$Generado = false;
			}

			return $Generado;
		
		}
		
				
//		$oPedidoCompraId,$oDestinatario,$oRuta="",$oRemitente=NULL
		public function MtdEnviarCorreoPedidoOrdenCotizacion($oOrdenCotizacion,$oDestinatario,$oRuta="",$oRemitente=NULL){
			
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;

			$this->OotId = $oOrdenCotizacion;
			$this->MtdObtenerOrdenCotizacion();

			$mensaje = "";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<b>Estimados Señores.-</b>";
			$mensaje .= "<br><br>";
			
			$mensaje .= "Se envia solicitud de cotizacion adjunta";
			$mensaje .= "<br><br>";
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
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"COTIZACION: ".$this->OotId,$mensaje,$oRuta."generados/",$this->OotId.".xls");
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","iquezada@cyc.com.pe",$SistemaCorreoRemitente,"PEDIDO CYC-STK-2015-01-001 2",$Mensaje,"generados/","CYC-STK-2015-01-001.xls");

		}





}
?>