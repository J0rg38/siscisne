<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsSolicitudDesembolso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsSolicitudDesembolso {

    public $SdsId;
	
	public $PerId;	
	public $EinId;
	
	public $MonId;
	public $SdsTipoCambio;
	public $SdsMonto;
	
	public $SdsAsunto;
	public $SdsObservacion;
    public $SdsObservacionImpresa;
	public $FinId;
	
	public $SdsPlaca;
	public $SdsVIN;
	public $SdsAprobado;
	public $SdsFecha;
	
	public $SdsEstado;
  
	
    public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}

	public function MtdGenerarSolicitudDesembolsoId() {
//	-- MAX(CONVERT(SUBSTR(SdsId,5),unsigned)) AS "MAXIMO"
			$sql = 'SELECT	
			suc.SucSiglas,
			MAX(CONVERT(SUBSTR(sds.SdsId,10),unsigned)) AS "MAXIMO"
			
			FROM tblsdssolicituddesembolso sds
				LEFT JOIN tblsucsucursal suc
				ON sds.SucId = suc.SucId
			WHERE YEAR(sds.SdsFecha) = '.$this->SdsAno.'
			AND sds.SucId = "'.$this->SucId.'"
			;';
			
					   
			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			
			if(empty($fila['MAXIMO'])){			
				$this->SdsId = "SDS-".$this->SdsAno."-10000-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);

			}else{
				$fila['MAXIMO']++;
				$this->SdsId = "SDS-".$this->SdsAno."-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);					
			}		
			
	}
		
    public function MtdObtenerSolicitudDesembolso($oCompleto=true){

        $sql = 'SELECT 
		sds.SdsId,
		sds.SucId,
		
		sds.PerId,
		sds.FinId,		
		sds.EinId,
		sds.TgaId,
		
		DATE_FORMAT(sds.SdsFecha, "%d/%m/%Y") AS "NSdsFecha",
		sds.SdsAsunto,
		sds.SdsObservacion,
		sds.SdsObservacionImpresa,
sds.SdsObservacionCorreo,
		sds.SdsCliente,		
		sds.SdsPlaca,		
		sds.SdsVIN,
		sds.SdsAprobado,
		sds.SdsSolicitudAprobacionRespuesta,
		
		sds.AreId,
		sds.MonId,
		sds.SdsTipoCambio,
		
		sds.SdsGastoAsumido,
		sds.SdsDescripcion,
		sds.SdsMonto,
		
		sds.SdsEstado,
		DATE_FORMAT(sds.SdsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSdsTiempoCreacion",
        DATE_FORMAT(sds.SdsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSdsTiempoModificacion",
		
		tga.TgaNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		are.AreNombre,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerEmail
		
        FROM tblsdssolicituddesembolso sds
			LEFT JOIN tbleinvehiculoingreso ein
			ON sds.EinId = ein.EinId
				LEFT JOIN tbltgatipogasto tga
				ON sds.TgaId = tga.TgaId
					LEFT JOIN tblmonmoneda mon
					ON sds.MonId = mon.MonId
						LEFT JOIN tblarearea are
						ON sds.AreId = are.AreId
							LEFT JOIN tblperpersonal per
							ON sds.PerId = per.PerId
			
        WHERE  sds.SdsId = "'.$this->SdsId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
			while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
			{
	
				$this->SdsId = $fila['SdsId'];
				$this->SucId = $fila['SucId'];
				
				$this->PerId = $fila['PerId'];
				$this->FinId = $fila['FinId'];			
				$this->EinId = $fila['EinId']; 
				$this->TgaId = $fila['TgaId']; 
				
				$this->SdsFecha = (($fila['NSdsFecha']));
				$this->SdsAsunto = (($fila['SdsAsunto']));
				$this->SdsObservacion = $fila['SdsObservacion'];				
				$this->SdsObservacionImpresa = (($fila['SdsObservacionImpresa']));
				$this->SdsObservacionCorreo = (($fila['SdsObservacionCorreo']));
				
				$this->SdsCliente = (($fila['SdsCliente']));
				$this->SdsPlaca = (($fila['SdsPlaca']));			
				$this->SdsVIN = (($fila['SdsVIN']));
				$this->SdsAprobado = (($fila['SdsAprobado']));	
				$this->SdsSolicitudAprobacionRespuesta = (($fila['SdsSolicitudAprobacionRespuesta']));	
				
				$this->AreId = (($fila['AreId']));	
				$this->MonId = (($fila['MonId']));	
				$this->SdsTipoCambio = (($fila['SdsTipoCambio']));	
				
				$this->SdsGastoAsumido = (($fila['SdsGastoAsumido']));
				$this->SdsDescripcion = (($fila['SdsDescripcion']));	
				$this->SdsMonto = (($fila['SdsMonto']));	
				
				$this->SdsEstado = $fila['SdsEstado'];					
				$this->SdsTiempoCreacion = $fila['NSdsTiempoCreacion'];
				$this->SdsTiempoModificacion = $fila['NSdsTiempoModificacion']; 

				$this->TgaNombre = $fila['TgaNombre']; 

				$this->MonNombre = $fila['MonNombre']; 
				$this->MonSimbolo = $fila['MonSimbolo']; 

				$this->AreNombre = $fila['AreNombre']; 

				$this->PerNombre = $fila['PerNombre']; 
				$this->PerApellidoPaterno = $fila['PerApellidoPaterno']; 
				$this->PerApellidoMaterno = $fila['PerApellidoMaterno']; 
				$this->PerEmail = $fila['PerEmail']; 
				
				if($oCompleto){
				
					//MtdObtenerSolicitudDesembolsoDetalles($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SddId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oSolicituDesembolso=NULL,$oServicioRepuesto=NULL)
					$InsSolicitudDesembolsoDetalle = new ClsSolicitudDesembolsoDetalle();
					$ResSolicitudDesembolsoDetalle =  $InsSolicitudDesembolsoDetalle->MtdObtenerSolicitudDesembolsoDetalles(NULL,NULL,NULL,"SddTiempoCreacion","ASC",NULL,NULL,$this->SdsId,NULL);
					
					$this->SolicitudDesembolsoDetalle = $ResSolicitudDesembolsoDetalle['Datos'];	
		
				}
			}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

  // public function MtdVerificarExisteSolicitudDesembolso($oCampo,$oDato){
//		
//		$SolicitudDesembolsoId = "";
//		
//	//MtdObtenerSolicitudDesembolsos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SdsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oTipo=NULL,$oValidarStock=1,$oVehiculoMarca=NULL,$oVehiculoModelo=NULL,$oVehiculoVersion=NULL,$oVehiculoAno=NULL,$oTieneIngreso=false,$oReferencia=NULL,$oFecha=NULL,$oTieneSock=0,$oSolicitudDesembolsoCategoria=NULL)
//		$ResSolicitudDesembolso = $this->MtdObtenerSolicitudDesembolsos($oCampo,"esigual",$oDato,"SdsId,SdsEstado","ASC","1",NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);
//		$ArrSolicitudDesembolsos = $ResSolicitudDesembolso['Datos'];
//		
//		if(!empty($ArrSolicitudDesembolsos)){
//			foreach($ArrSolicitudDesembolsos as $DatSolicitudDesembolso){
//					
//				$SolicitudDesembolsoId = $DatSolicitudDesembolso->SdsId;
//			}
//		}
//		
//		return $SolicitudDesembolsoId;
//   }
//   
//   public function MtdIdentificarSolicitudDesembolsoCampo($oCampo,$oDato){
//		
//		$SolicitudDesembolsoId = "";
//		
//		$ResSolicitudDesembolso = $this->MtdObtenerSolicitudDesembolsos($oCampo,"esigual",$oDato,"SdsId","DESC","1",NULL,NULL,1,NULL,NULL,NULL,NULL,false,NULL,NULL,0,NULL);   
//		$ArrSolicitudDesembolsos = $ResSolicitudDesembolso['Datos'];
//		
//		if(!$ArrSolicitudDesembolsos){
//			foreach($ArrSolicitudDesembolsos as $DatSolicitudDesembolso){
//				$SolicitudDesembolsoId = $DatSolicitudDesembolso->SdsId;
//			}
//		}
//		
//		return $SolicitudDesembolsoId;
//   }
   
	public function MtdObtenerSolicitudDesembolsos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'SdsId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oPersonal=NULL,$oVehiculoIngreso=NULL,$oMoneda=NULL,$oArea=NULL,$oTipoGasto=NULL,$oSucursal=NULL) {

		if(!empty($oCampo) and !empty($oFiltro)){
			
			//$oFiltro = str_replace("*","%",$oFiltro);
			//$oFiltro = str_replace(" ","%",$oFiltro);
			
			$elementos_buscar = explode(",",$oFiltro);///
			
			$elementos_campo = explode(",",$oCampo);

				$i=1;
				$filtrar .= '  AND (';
				foreach($elementos_campo as $elemento_campo){
					if(!empty($elemento_campo)){	
					
					
								
						if($i==count($elementos_campo)){	

							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
							}
										
							$filtrar .= ' )';
							
						}else{
							
							
							$filtrar .= ' (';
							
							$j = 1;
							foreach($elementos_buscar as $elemento_buscar){
								if(!empty($elemento_buscar)){	
									
									if($j==count($elementos_buscar)){	
										
										$filtrar .= ' (';
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										$filtrar .= ' )';
										
									}else{
										
										$filtrar .= ' (';
										
										switch($oCondicion){
						
											case "esigual":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'"';	
											break;
							
											case "noesigual":
												$filtrar .= '  '.($elemento_campo).' <> "'.($elemento_buscar).'"';
											break;
											
											case "comienza":
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
											
											case "termina":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'"';
											break;
											
											case "contiene":
												$filtrar .= '  '.($elemento_campo).' LIKE "%'.($elemento_buscar).'%"';
											break;
											
											case "nocontiene":
												$filtrar .= '  '.($elemento_campo).' NOT LIKE "%'.($elemento_buscar).'%"';
											break;
											
											default:
												$filtrar .= '  '.($elemento_campo).' LIKE "'.($elemento_buscar).'%"';
											break;
										
										}
										
										$filtrar .= ' ) OR';
									}
									
								}
								
								$j++;
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
			$estado = ' AND sds.SdsEstado = '.$oEstado.' ';
		}
		
		if(!empty($oPersonal)){
			$personal = ' AND sds.PerId = "'.$oPersonal.'"';
		}
		
		if(!empty($oVehiculoIngreso)){
			$vingreso = ' AND sds.EinId = '.$oVehiculoIngreso.' ';
		}

		if(!empty($oFechaInicio)){
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(sds.SdsFecha)>="'.$oFechaInicio.'" AND DATE(sds.SdsFecha)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(sds.SdsFecha)>="'.$oFechaInicio.'"';
			}
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(sds.SdsFecha)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oArea)){
			$area = ' AND sds.AreId = "'.$oArea.'" ';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND sds.MonId = "'.$oMoneda.'" ';
		}

		if(!empty($oTipoGasto)){
			$tgasto = ' AND sds.TgaId = "'.$oTipoGasto.'" ';
		}

		if(!empty($oSucursal)){
			$sucursal = ' AND sds.SucId = "'.$oSucursal.'" ';
		}
		
			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				sds.SdsId,
				sds.SucId,
				
				
				sds.PerId,
				sds.EinId,
				sds.FinId,
				sds.TgaId,
				
				DATE_FORMAT(sds.SdsFecha, "%d/%m/%Y") AS "NSdsFecha",
				sds.SdsAsunto,
				sds.SdsObservacionImpresa,
sds.SdsObservacionCorreo,
				sds.SdsObservacion,
				
				sds.SdsCliente,
				sds.SdsPlaca,
				sds.SdsVIN,
				sds.SdsAprobado,
				
				sds.AreId,
				sds.MonId,
				sds.SdsTipoCambio,
				
				sds.SdsGastoAsumido,
				sds.SdsDescripcion,
				sds.SdsMonto,
				
				sds.SdsEstado,
				DATE_FORMAT(sds.SdsTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NSdsTiempoCreacion",
                DATE_FORMAT(sds.SdsTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NSdsTiempoModificacion",
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				
				ein.EinPlaca,
				ein.EinVIN,
				
				tga.TgaNombre,
				mon.MonNombre,
				mon.MonSimbolo
							
				FROM tblsdssolicituddesembolso sds		
					LEFT JOIN tbleinvehiculoingreso ein
					ON sds.EinId = ein.EinId
						LEFT JOIN tblperpersonal per
						ON sds.PerId = per.PerId
							LEFT JOIN tbltgatipogasto tga
							ON sds.TgaId = tga.TgaId
								LEFT JOIN tblmonmoneda mon
								ON sds.MonId = mon.MonId
							
				WHERE  1 = 1  '.$filtrar.$categoria.$personal.$sucursal.$tgasto.$fecha.$moneda.$cprecio.$vingreso.$estado.$tipo.$area.$vmarca.$vmodelo.$vversion.$vano.$tingreso.$tstock.$pcategoria.$orden.$paginacion;
							
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsSolicitudDesembolso = get_class($this);

				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){
					$SolicitudDesembolso = new $InsSolicitudDesembolso();
                    $SolicitudDesembolso->SdsId = $fila['SdsId'];
					 $SolicitudDesembolso->SucId = $fila['SucId'];
					 
					$SolicitudDesembolso->PerId = $fila['PerId']; 
					$SolicitudDesembolso->EinId = $fila['EinId']; 
					$SolicitudDesembolso->FinId = $fila['FinId']; 
						$SolicitudDesembolso->TgaId = $fila['TgaId']; 
					
					$SolicitudDesembolso->SdsFecha = ($fila['NSdsFecha']);
					$SolicitudDesembolso->SdsAsunto = ($fila['SdsAsunto']);
					$SolicitudDesembolso->SdsObservacion = $fila['SdsObservacion'];
                    $SolicitudDesembolso->SdsObservacionImpresa= ($fila['SdsObservacionImpresa']);
					$SolicitudDesembolso->SdsObservacionCorreo= ($fila['SdsObservacionCorreo']);
					
					
                    $SolicitudDesembolso->SdsCliente= ($fila['SdsCliente']);
					$SolicitudDesembolso->SdsPlaca= ($fila['SdsPlaca']);					
					$SolicitudDesembolso->SdsVIN= ($fila['SdsVIN']);
					$SolicitudDesembolso->SdsAprobado= ($fila['SdsAprobado']);
					
					$SolicitudDesembolso->AreId= ($fila['AreId']);
					$SolicitudDesembolso->MonId= ($fila['MonId']);
					$SolicitudDesembolso->SdsTipoCambio= ($fila['SdsTipoCambio']);
					
					
					$SolicitudDesembolso->SdsGastoAsumido= ($fila['SdsGastoAsumido']);
					$SolicitudDesembolso->SdsDescripcion= ($fila['SdsDescripcion']);
					$SolicitudDesembolso->SdsMonto= ($fila['SdsMonto']);
					
					$SolicitudDesembolso->SdsEstado = $fila['SdsEstado'];	
                    $SolicitudDesembolso->SdsTiempoCreacion = $fila['NSdsTiempoCreacion'];
                    $SolicitudDesembolso->SdsTiempoModificacion = $fila['NSdsTiempoModificacion'];
					
					$SolicitudDesembolso->PerNombre = $fila['PerNombre'];
					$SolicitudDesembolso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$SolicitudDesembolso->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					
					$SolicitudDesembolso->EinPlaca = $fila['EinPlaca'];
					$SolicitudDesembolso->EinVIN = $fila['EinVIN'];
					
					$SolicitudDesembolso->TgaNombre = $fila['TgaNombre'];
					
					$SolicitudDesembolso->MonNombre = $fila['MonNombre'];
					$SolicitudDesembolso->MonSimbolo = $fila['MonSimbolo'];
			
					$SolicitudDesembolso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $SolicitudDesembolso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
		
			
	//Accion eliminar	 
	public function MtdActualizarEstadoSolicitudDesembolso($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsSolicitudDesembolso = new ClsSolicitudDesembolso();
		$InsSolicitudDesembolsoDetalles = new ClsSolicitudDesembolsoDetalle();

			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
				
					$sql = 'UPDATE tblsdssolicituddesembolso SET SdsEstado = '.$oEstado.' WHERE SdsId = "'.$elemento.'"';
		
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarSolicitudDesembolso(2,"Se actualizo el Estado de la Solicitud de Desembolso",$elemento);
				
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
	
	public function MtdEliminarSolicitudDesembolso($oElementos) {
		
		
			
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'DELETE FROM tblsdssolicituddesembolso WHERE ( SdsId = "'.($elemento).'" )';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarSolicitudDesembolso(3,"Se elimino la solicitud de desembolso",$aux);		
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
	
	public function MtdActualizarSolicitudDesembolsoEstado($oElementos,$oEstado) {
		
		$error = false;	
		
		$this->InsMysql->MtdTransaccionIniciar();
				
		$elementos = explode("#",$oElementos);

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if(!$error){

						$sql = 'UPDATE tblsdssolicituddesembolso SET SdsEstado = '.$oEstado.' WHERE ( SdsId = "'.($elemento).'" )';
						
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarSolicitudDesembolso(2,"Se actualizo el estado del producto",$aux);		
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
	
	public function MtdRegistrarSolicitudDesembolso() {
		
		global $Resultado;
		
			$this->MtdGenerarSolicitudDesembolsoId();
			
			$sql = 'INSERT INTO tblsdssolicituddesembolso (
			SdsId,
			SucId,
			
			PerId,
			FinId,
			EinId,
			TgaId,
			
			SdsAsunto,
			SdsObservacion,
			SdsObservacionImpresa, 
			SdsObservacionCorreo,
			
			SdsCliente,
			SdsPlaca,
			SdsVIN,
			SdsAprobado,
			SdsFecha,
			
			AreId,
			MonId,
			SdsTipoCambio,
			
			SdsGastoAsumido,
			SdsDescripcion,
			SdsMonto,
			
			SdsEstado,
			SdsTiempoCreacion,
			SdsTiempoModificacion
			) 
			VALUES (
			"'.($this->SdsId).'", 
			"'.($this->SucId).'", 
			
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->FinId)?'NULL, ':'"'.$this->FinId.'",').'
			'.(empty($this->EinId)?'NULL, ':'"'.$this->EinId.'",').'
			'.(empty($this->TgaId)?'NULL, ':'"'.$this->TgaId.'",').'
			
			"'.($this->SdsAsunto).'", 
			"'.($this->SdsObservacion).'", 
			"'.($this->SdsObservacionImpresa).'", 
			"'.($this->SdsObservacionCorreo).'", 
			
			"'.($this->SdsCliente).'",
			"'.($this->SdsPlaca).'",
			"'.($this->SdsVIN).'",
			'.($this->SdsAprobado).',
			"'.($this->SdsFecha).'",
			
			'.(empty($this->AreId)?'NULL, ':'"'.$this->AreId.'",').'
			"'.($this->MonId).'",
			'.(empty($this->SdsTipoCambio)?'NULL, ':'"'.$this->SdsTipoCambio.'",').'
			
			
			"'.($this->SdsGastoAsumido).'", 
			"'.($this->SdsDescripcion).'", 
			'.($this->SdsMonto).',
			
			'.($this->SdsEstado).',
			"'.($this->SdsTiempoCreacion).'", 
			"'.($this->SdsTiempoModificacion).'");';

			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();
			
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {							
				$error = true;
			} 
			
			
			if(!$error){			

				if (!empty($this->SolicitudDesembolsoDetalle)){		
						
					$validar = 0;				
					$InsSolicitudDesembolsoDetalle = new ClsSolicitudDesembolsoDetalle();		
					
					foreach ($this->SolicitudDesembolsoDetalle as $DatSolicitudDesembolsoDetalle){
					
						$InsSolicitudDesembolsoDetalle->SdsId = $this->SdsId;
						$InsSolicitudDesembolsoDetalle->SreId = $DatSolicitudDesembolsoDetalle->SreId;
						
						$InsSolicitudDesembolsoDetalle->SddDescripcion = $DatSolicitudDesembolsoDetalle->SddDescripcion;
						$InsSolicitudDesembolsoDetalle->SddCantidad = $DatSolicitudDesembolsoDetalle->SddCantidad;
						$InsSolicitudDesembolsoDetalle->SddImporte = $DatSolicitudDesembolsoDetalle->SddImporte;
						$InsSolicitudDesembolsoDetalle->SddEstado = $DatSolicitudDesembolsoDetalle->SddEstado;
					
						$InsSolicitudDesembolsoDetalle->SddTiempoCreacion = $DatSolicitudDesembolsoDetalle->SddTiempoCreacion;
						$InsSolicitudDesembolsoDetalle->SddTiempoModificacion = $DatSolicitudDesembolsoDetalle->SddTiempoModificacion;						
						$InsSolicitudDesembolsoDetalle->SddEliminado = $DatSolicitudDesembolsoDetalle->SddEliminado;
						
						if($InsSolicitudDesembolsoDetalle->MtdRegistrarSolicitudDesembolsoDetalle()){
							$validar++;	
						}else{
							$Resultado.='#ERR_SDS_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					
					
					if(count($this->SolicitudDesembolsoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				$this->MtdAuditarSolicitudDesembolso(1,"Se registro la solicitud de desembolso.",$this);	
				$this->InsMysql->MtdTransaccionHacer();					
				return true;
			}			
			
	}
	
	public function MtdEditarSolicitudDesembolso() {
	
		global $Resultado;
		
		$sql = 'UPDATE tblsdssolicituddesembolso SET 
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		'.(empty($this->EinId)?'EinId = NULL, ':'EinId = "'.$this->EinId.'",').'
		'.(empty($this->FinId)?'FinId = NULL, ':'FinId = "'.$this->FinId.'",').'
		'.(empty($this->TgaId)?'TgaId = NULL, ':'TgaId = "'.$this->TgaId.'",').'
		
		SdsAsunto = "'.($this->SdsAsunto).'",			
		SdsObservacion = "'.($this->SdsObservacion).'",
		SdsObservacionImpresa = "'.($this->SdsObservacionImpresa).'",
		SdsObservacionCorreo = "'.($this->SdsObservacionCorreo).'",

		SdsCliente = "'.($this->SdsCliente).'",
		SdsPlaca = "'.($this->SdsPlaca).'",		
		SdsVIN = "'.($this->SdsVIN).'",
	
		SdsFecha = "'.($this->SdsFecha).'",
		
		'.(empty($this->AreId)?'AreId = NULL, ':'AreId = "'.$this->AreId.'",').'
		MonId = "'.($this->MonId).'",
		'.(empty($this->SdsTipoCambio)?'SdsTipoCambio = NULL, ':'SdsTipoCambio = "'.$this->SdsTipoCambio.'",').'
		
		SdsGastoAsumido = "'.($this->SdsGastoAsumido).'",
		SdsDescripcion = "'.($this->SdsDescripcion).'",
		SdsMonto = '.($this->SdsMonto).',
		
		SdsEstado = '.($this->SdsEstado).',
		SdsTiempoModificacion = "'.($this->SdsTiempoModificacion).'"		
		WHERE SdsId = "'.($this->SdsId).'";';
	
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
		
		if(!$resultado) {							
			$error = true;
		} 
		
		

		if(!$error){
			
				if (!empty($this->SolicitudDesembolsoDetalle)){		

					$validar = 0;				
					$InsSolicitudDesembolsoDetalle = new ClsSolicitudDesembolsoDetalle();
							
					foreach ($this->SolicitudDesembolsoDetalle as $DatSolicitudDesembolsoDetalle){
										
						$InsSolicitudDesembolsoDetalle->SddId = $DatSolicitudDesembolsoDetalle->SddId;
						$InsSolicitudDesembolsoDetalle->SdsId = $this->SdsId;
						$InsSolicitudDesembolsoDetalle->SreId = $DatSolicitudDesembolsoDetalle->SreId;
						
						$InsSolicitudDesembolsoDetalle->SddDescripcion = $DatSolicitudDesembolsoDetalle->SddDescripcion;
						$InsSolicitudDesembolsoDetalle->SddCantidad = $DatSolicitudDesembolsoDetalle->SddCantidad;
						$InsSolicitudDesembolsoDetalle->SddImporte = $DatSolicitudDesembolsoDetalle->SddImporte;
					
						$InsSolicitudDesembolsoDetalle->SddEstado = $DatSolicitudDesembolsoDetalle->SddEstado;
						$InsSolicitudDesembolsoDetalle->SddTiempoCreacion = $DatSolicitudDesembolsoDetalle->SddTiempoCreacion;
						$InsSolicitudDesembolsoDetalle->SddTiempoModificacion = $DatSolicitudDesembolsoDetalle->SddTiempoModificacion;
						$InsSolicitudDesembolsoDetalle->SddEliminado = $DatSolicitudDesembolsoDetalle->SddEliminado;
						
						if(empty($InsSolicitudDesembolsoDetalle->SddId)){
							if($InsSolicitudDesembolsoDetalle->SddEliminado<>2){
								if($InsSolicitudDesembolsoDetalle->MtdRegistrarSolicitudDesembolsoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_SDS_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsSolicitudDesembolsoDetalle->SddEliminado==2){
								if($InsSolicitudDesembolsoDetalle->MtdEliminarSolicitudDesembolsoDetalle($InsSolicitudDesembolsoDetalle->SddId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_SDS_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsSolicitudDesembolsoDetalle->MtdEditarSolicitudDesembolsoDetalle()){
									$validar++;	
								}else{
									$Resultado.='#ERR_SDS_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->SolicitudDesembolsoDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}	
			
			
		if($error) {		
			$this->InsMysql->MtdTransaccionDeshacer();					
			return false;
		} else {			
		
			$this->MtdAuditarSolicitudDesembolso(2,"Se edito la solicitud de desembolso.",$this);	
			$this->InsMysql->MtdTransaccionHacer();				
			return true;
		}						
			
	}	
		
		
		
	

	public function MtdEditarSolicitudDesembolsoDato($oCampo,$oDato,$oSolicitudDesembolsoId) {
	
		global $Resultado;
	
		$sql = 'UPDATE tblsdssolicituddesembolso SET 
		'.$oCampo.' = "'.($oDato).'"
		WHERE SdsId = "'.($oSolicitudDesembolsoId).'";';
		
		$error = false;

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
			return true;
		}						

	}	
	
	
	
		
		private function MtdAuditarSolicitudDesembolso($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->SdsId;
			$InsAuditoria->AudCodigoExtra = NULL;
			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = NULL;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudDescripcion = $oDescripcion;
$InsAuditoria->AudUsuario = $oUsuario;
		$InsAuditoria->AudPersonal = $oPersonal;
			$InsAuditoria->AudDatos = $oDatos;
			$InsAuditoria->AudTiempoCreacion = date("Y-m-d H:i:s");
			
			if($InsAuditoria->MtdAuditoriaRegistrar("v2")){
				return true;
			}else{
				return false;	
			}
			
		}
		
		
		
	//MtdGenerarExcelSolicitudDesembolsoAutorizacion
	public function MtdGenerarExcelSolicitudDesembolsoAutorizacion($oSolicitudDesembolso,$oRuta=NULL){
			
			global $EmpresaMonedaId;
			global $EmpresaMonedaId;
			
			$Generado = true;
			
			if(!empty($oSolicitudDesembolso)){

				$this->SdsId = $oSolicitudDesembolso;
				$this->MtdObtenerSolicitudDesembolso();
					
					if($EmpresaMonedaId<>$this->MonId){
						$this->SdsMonto = $this->SdsMonto/$this->SdsTipoCambio;
					}
					
					$objPHPExcel = new PHPExcel();
					
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader->load($oRuta."plantilla/TemSolicitudDesembolsoAutorizacion.xls");
					
							$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("PHPExcel Test Document")
									 ->setSubject("PHPExcel Test Document")
									 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Test result file");

							// Miscellaneous glyphs, UTF-8
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D6', $this->SdsFecha);
							$objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(true)->setSize(14);		
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D7', $this->MonNombre);
							$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(false)->setSize(12);	
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F7', $this->SdsTipoCambio);
							$objPHPExcel->getActiveSheet()->getStyle('F7')->getFont()->setBold(false)->setSize(12);	
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D8', $this->TgaNombre);
							$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F8', $this->AreNombre);
							$objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(false)->setSize(12);
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D9', $this->SdsCliente);
							$objPHPExcel->getActiveSheet()->getStyle('D9')->getFont()->setBold(false)->setSize(12);
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D10', $this->SdsVIN);
							$objPHPExcel->getActiveSheet()->getStyle('D10')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F10', $this->SdsPlaca);
							$objPHPExcel->getActiveSheet()->getStyle('F10')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D11', $this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno);
							$objPHPExcel->getActiveSheet()->getStyle('D11')->getFont()->setBold(false)->setSize(12);
						
							$i = 1;
							$detalle = "";
							if(!empty($this->SolicitudDesembolsoDetalle)){
								
								foreach($this->SolicitudDesembolsoDetalle as $DatSolicitudDesembolsoDetalle){
									
										if($this->MonId<>$EmpresaMonedaId ){
											$DatSolicitudDesembolsoDetalle->SddImporte = round($DatSolicitudDesembolsoDetalle->SddImporte / $InsSolicitudDesembolso->SdsTipoCambio,2);
										}
		
									$detalle .= " - ". $DatSolicitudDesembolsoDetalle->SreNombre." ".number_format($DatSolicitudDesembolsoDetalle->SddCantidad,2)." ".number_format($DatSolicitudDesembolsoDetalle->SddImporte,2)."\n";	
									
									$i++;
								}
							}
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D12', $detalle);
							$objPHPExcel->getActiveSheet()->getStyle('D12')->getFont()->setBold(false)->setSize(12);
							
							
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('D13', $this->SdsObservacionImpresa);
							$objPHPExcel->getActiveSheet()->getStyle('D13')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F11', $this->FinId);
							$objPHPExcel->getActiveSheet()->getStyle('F11')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('E15', $this->MonSimbolo);
							$objPHPExcel->getActiveSheet()->getStyle('E15')->getFont()->setBold(false)->setSize(12);
							
							$objPHPExcel->setActiveSheetIndex(0)
										->setCellValue('F15', $this->SdsMonto);
							$objPHPExcel->getActiveSheet()->getStyle('F15')->getFont()->setBold(false)->setSize(12);
								
										
									
					// Rename worksheet
					$objPHPExcel->getActiveSheet()->setTitle($this->SdsId);
					
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save($oRuta."generados/solicitud_desembolso/".$this->SdsId.".xls");
				
				
			}else{
				
				$Generado = false;
					
			}

			return $Generado;
		
		}
		
		
	public function MtdEnviarCorreoSolicitarAutorizacionSolicitudDesembolso($oOrdenCompra,$oDestinatario,$oRemitente,$oAdjunto=array()){
			
			$Envio = false;
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		global $SistemaCorreoRemitente;
		
			$this->SdsId = $oOrdenCompra;
			$this->MtdObtenerSolicitudDesembolso();
			
			if($EmpresaMonedaId<>$this->MonId){
				$this->SdsMonto = $this->SdsMonto/$this->SdsTipoCambio;
			}
					
			$mensaje = "";
			
			if(date("A") == "PM"){
				$mensaje .= "Buenas tardes";
			}else{
				$mensaje .= "Buenos dias";
			}

			$mensaje .= "<br>";
			$mensaje .= "<br>";

			$mensaje .= "Se solicita autorizacion de desembolso <b>".$this->SdsId."</b>";
			$mensaje .= "<br>";
			
			if(!empty($this->SdsCliente)){
			
				$mensaje .= "<br>";
				$mensaje .= "<b>Cliente: </b> ".$this->SdsCliente;
				
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<b>Fecha:</b> ".$this->SdsFecha;
			
			if(!empty($this->SdsVIN)){
			
				$mensaje .= "<br>";
				$mensaje .= "<b>VIN:</b> ".$this->SdsVIN;
				
			}
			
			if(!empty($this->SdsPlaca)){
			
				$mensaje .= "<br>";
				$mensaje .= "<b>Placa:</b> ".$this->SdsPlaca;
				
			}

			if(!empty($this->AreId)){
			
				$mensaje .= "<br>";
				$mensaje .= "<b>Area:</b> ".$this->AreNombre;
				
			}

			if(!empty($this->TgaId)){
			
				$mensaje .= "<br>";
				$mensaje .= "<b>Tipo:</b> ".$this->TgaNombre;
				
			}

			if(!empty($this->FinId)){
			
				$mensaje .= "<br>";
				$mensaje .= "<b>O.T.:</b> ".$this->FinId;
				
			}

			$mensaje .= "<br>";
			$mensaje .= "<b>Solicitante:</b> ".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno;
			$mensaje .= "<br>";

			if(!empty($this->SdsGastoAsumido)){
				
				$mensaje .= "<br>";
				$mensaje .= "<b>Monto asumido por :</b> ".$this->SdsGastoAsumido;
				$mensaje .= "<br>";
				
			}

			$mensaje .= "<br>";
			$mensaje .= "<b>Detalle:</b> ";
			$mensaje .= "<br>";
			
			$i = 1;
			if(!empty($this->SolicitudDesembolsoDetalle)){
				
				foreach($this->SolicitudDesembolsoDetalle as $DatSolicitudDesembolsoDetalle){
					
					if($this->MonId<>$EmpresaMonedaId ){
						$DatSolicitudDesembolsoDetalle->SddImporte = round($DatSolicitudDesembolsoDetalle->SddImporte / $InsSolicitudDesembolso->SdsTipoCambio,2);
					}
										
					$mensaje .=" - ".number_format($DatSolicitudDesembolsoDetalle->SddCantidad,2)."  &nbsp;&nbsp;&nbsp; ". $DatSolicitudDesembolsoDetalle->SreNombre." &nbsp;&nbsp;&nbsp; ".$this->MonSimbolo." ".number_format($DatSolicitudDesembolsoDetalle->SddImporte,2);	
					$mensaje .= "<br>";
					
					$i++;
				}
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<b>Monto:</b> ".$this->MonSimbolo." ".number_format($this->SdsMonto,2);
			$mensaje .= "<br>";
			
			if(!empty($this->SdsObservacionCorreo)){
			
				$mensaje .= "<br>";
				$mensaje .= "".$this->SdsObservacionCorreo;
				$mensaje .= "<br>";
					
			}
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
			
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

//deb($oAdjunto);
			$InsCorreo = new ClsCorreo();	
			//MtdEnviarCorreo($CorDestinatario,$CorRemitenteCorreo,$CorRemitenteNombre,$CorAsunto,$CorContenido,$oCorRutaAdjunto=NULL,$oCorAdjunto=NULL){
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"SOLICITUD DE DESEMBOLSO: ".$this->SdsId." / ".strtoupper($this->SdsAsunto),$mensaje,"",$oAdjunto);
			//$InsCorreo->MtdEnviarCorreo("jblanco@cyc.com.pe","iquezada@cyc.com.pe",$SistemaCorreoRemitente,"PEDIDO CYC-STK-2015-01-001 2",$Mensaje,"generados/","CYC-STK-2015-01-001.xls");
			
			$Envio = true;
			
			return $Envio;
			
	}
		
		//
//		
//		
//		public function MtdEnviarSolicitudDesembolso($oSolicitudDesembolsoId,$oDestinatario,$oRemitente=NULL){
//		
//			$this->SdsId = $oSolicitudDesembolsoId;
//			$this->MtdObtenerSolicitudDesembolso(false);
//			
//			
//			$mensaje .= "SOLICITUD DE DESEMBOLSO:";	
//			$mensaje .= "<br>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Registro de notificacion de producto por revisar stock.";	
//			$mensaje .= "<br>";	
//
//			$mensaje .= "Codigo Interno: <b>".$this->SdsId."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Codigo Original: <b>".$this->SdsAsunto."</b>";	
//			$mensaje .= "<br>";	
//			
//			$mensaje .= "Fecha de notificacion: <b>".$this->SdsRevisadoFecha."</b>";	
//			$mensaje .= "<br>";	
//
//			$mensaje .= "Stock actual: <b>".$this->SdsStockReal."</b>";	
//			$mensaje .= "<br>";
//
//			$mensaje .= "Notificado por: <b>".$Usuario."</b>";	
//			$mensaje .= "<br>";
//			
//			$mensaje .= "<hr>";
//			$mensaje .= "<br>";
//			
//			$mensaje .= "<br>";
//			$mensaje .= "<br>";
//			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
//			
//			$InsCorreo = new ClsCorreo();	
//			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REVISAR SDSDUCTO STOCK. Cod.: ".$this->SdsId." - ".$this->SdsAsunto." - ".$this->SdsObservacionImpresa,$mensaje);
//
//		
//		}
		
					
	
}
?>