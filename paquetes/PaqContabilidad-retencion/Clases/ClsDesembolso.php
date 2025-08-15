<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsDesembolso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsDesembolso {

    public $DesId;
	
	public $PrvId;
	public $CliId;
	public $PerId;
	
	public $CueId;
    public $DesFecha;
    public $MonId;
	
	public $AreId;
	
	public $DesTipoCambio;
	public $DesObservacion;
	public $DesObservacionImpresa;
	public $DesConcepto;
	
	public $DesNumeroCheque;
	public $DesReferencia;

	public $DesMonto;
	public $DesTipo;
	public $DesFoto;
	
	public $DesTipoDestino;
	
	public $DesEstado;	
    public $DesTiempoCreacion;
    public $DesTiempoModificacion;
    public $DesEliminado;

	
	
	
	public $PrvNombre;
	public $PrvApellidoPaterno;
	public $PrvApellidoMaterno;
	public $PrvNumeroDocumento;
	public $TdoIdProveedr;
	
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	public $CliNumeroDocumento;
	public $TdoIdCliente;
	
	public $PerNombre;
	public $PerApellidoPaterno;
	public $PerApellidoMaterno;
	public $PerNumeroDocumento;
	public $TdoIdPersonal;
	
	public $MonNombre;
	
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
		
	public function MtdGenerarDesembolsoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(DesId,5),unsigned)) AS "MAXIMO"
		FROM tbldesdesembolso';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->DesId = "DES-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->DesId = "DES-".$fila['MAXIMO'];					
		}

	}
		
    public function MtdObtenerDesembolso($oCompleto=true){

        $sql = 'SELECT 
        des.DesId,
		des.SucId,
		
		des.PrvId,
		des.CliId,
		des.PerId,
		
		des.CueId,
		DATE_FORMAT(des.DesFecha, "%d/%m/%Y") AS "NDesFecha",
		des.MonId,
		
		des.AreId,
		des.FpaId,
		
		des.DesTipoCambio,
		des.DesObservacion,
		des.DesObservacionImpresa,
		des.DesConcepto,
		
		des.DesNumeroCheque,
		des.DesReferencia,
	
		des.DesMonto,
		des.DesTipo,
		des.DesFoto,
		
		des.DesTipoDestino,
		
		des.DesEstado,	
		DATE_FORMAT(des.DesTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NDesTiempoCreacion",
        DATE_FORMAT(des.DesTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NDesTiempoModificacion",
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		prv.PrvNombre,
		prv.PrvApellidoPaterno,
		prv.PrvApellidoMaterno,
		prv.PrvNumeroDocumento,
		prv.TdoId AS TdoIdProveedor,
		
		tdo.TdoNombre AS TdoNombreProveedor,
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		cli.CliNumeroDocumento,
		cli.TdoId AS TdoIdCliente,
		tdo2.TdoNombre AS TdoNombreCliente,
		
		per.PerNombre,
		per.PerApellidoPaterno,
		per.PerApellidoMaterno,
		per.PerNumeroDocumento,
		per.TdoId AS TdoIdPersonal,
		tdo3.TdoNombre AS TdoNombrePersonal,
		
		cue.CueNumero,
		ban.BanNombre
		
        FROM tbldesdesembolso des
			
			LEFT JOIN tblprvproveedor prv
			ON des.PrvId = prv.PrvId
			
				LEFT JOIN tblcuecuenta cue
				ON des.CueId = cue.CueId
					
					LEFT JOIN tblbanbanco ban
					ON cue.BanId = ban.BanId
					
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
					
						LEFT JOIN tblclicliente cli
						ON des.CliId = cli.CliId
						
							LEFT JOIN tbltdotipodocumento tdo2
							ON cli.TdoId = tdo2.TdoId
	
								LEFT JOIN tblperpersonal per
								ON des.PerId = per.PerId
								
									LEFT JOIN tbltdotipodocumento tdo3
									ON per.TdoId = tdo3.TdoId
						
						
					LEFT JOIN tblmonmoneda mon
					ON des.MonId = mon.MonId
					
					
        WHERE DesId = "'.$this->DesId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->DesId = $fila['DesId'];
			$this->SucId = $fila['SucId'];
			
			$this->PrvId = $fila['PrvId'];
			$this->PerId = $fila['PerId'];
			$this->CliId = $fila['CliId'];
			
			
			$this->CueId = $fila['CueId'];
			$this->DesFecha = $fila['NDesFecha'];
			$this->MonId = $fila['MonId'];
			
			$this->AreId = $fila['AreId'];
			$this->FpaId = $fila['FpaId'];
			
			
			$this->DesTipoCambio = $fila['DesTipoCambio'];
			$this->DesObservacion = $fila['DesObservacion'];
			$this->DesObservacionImpresa = $fila['DesObservacionImpresa'];
			$this->DesConcepto = $fila['DesConcepto'];
			$this->DesNumeroCheque = $fila['DesNumeroCheque'];
			$this->DesReferencia = $fila['DesReferencia'];

			$this->DesMonto = $fila['DesMonto'];
			$this->DesTipo = $fila['DesTipo'];	
	
			$this->DesFoto = $fila['DesFoto'];
			
			$this->DesTipoDestino = $fila['DesTipoDestino'];				
			
			$this->DesEstado = $fila['DesEstado'];
			$this->DesTiempoCreacion = $fila['NDesTiempoCreacion'];
			$this->DesTiempoModificacion = $fila['NDesTiempoModificacion'];
			
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->PrvNombre = $fila['PrvNombre'];
			$this->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
			$this->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
			$this->TdoIdProveedor = $fila['TdoIdProveedor'];
			$this->TdoNombreProveedor = $fila['TdoNombreProveedor'];
			
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoIdCliente = $fila['TdoIdCliente'];
			$this->TdoNombreCliente = $fila['TdoNombreCliente'];
			
			$this->PerNombre = $fila['PerNombre'];
			$this->PerApellidoPaterno = $fila['PerApellidoPaterno'];
			$this->PerApellidoMaterno = $fila['PerApellidoMaterno'];
			$this->PerNumeroDocumento = $fila['PerNumeroDocumento'];
			$this->TdoIdPersonal = $fila['TdoIdPersonal'];
			$this->TdoNombrePersonal = $fila['TdoNombrePersonal'];
			
			$this->CueNumero = $fila['CueNumero'];
			$this->BanNombre = $fila['BanNombre'];
		
			if($oCompleto){

				// MtdObtenerDesembolsoComprobantes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DcoId',$oSentido = 'Desc',$oPaginacion = '0,10',$oDesembolso=NULL)
				$InsDesembolsoComprobante = new ClsDesembolsoComprobante();
				$ResDesembolsoComprobante = $InsDesembolsoComprobante->MtdObtenerDesembolsoComprobantes(NULL,NULL,NULL,'DcoId','ASC',NULL,$this->DesId);
				$this->DesembolsoComprobante = $ResDesembolsoComprobante['Datos'];
				
			}


				switch($this->DesEstado){
					case 1:
						$this->DesEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->DesEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->DesEstadoDescripcion = "Anulado";
				
					break;
					
				}	
				
				if($oCompleto){
					
					
				}
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerDesembolsos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'DesId',$oSentido = 'Desc',$oDesinacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="DesFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL,$oFormaPago=NULL) {
		
		
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
				
				
				
					
					
				$filtrar .= '  ) ';



		}
		

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oDesinacion)){
			$paginacion = ' LIMIT '.($oDesinacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND des.DesEstado = '.$oEstado;
		}	
		
		if(!empty($oVentaDirecta)){
			
			$vdirecta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.DesId = des.DesId
				AND pac.VdIId = "'.$oVentaDirecta.'"
			
			)
			';
		}
		
		if(!empty($oOrdenVentaVehiculo)){
			
			$ovvehiculo = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.DesId = des.DesId
				AND pac.DesId = "'.$oOrdenVentaVehiculo.'"
			
			)
			';
		}	
		
	
			
		if(!empty($oMoneda)){
			$moneda = ' AND des.MonId = "'.$oMoneda.'"';
		}	
		
	
		if(!empty($oFactura) and !empty($oFacturaTalonario)){
			
			$factura = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.DesId = des.DesId
				AND pac.FacId = "'.$oFactura.'"
				AND pac.FtaId = "'.$oFacturaTalonario.'"
			
			)
			';
		}	
		
		if(!empty($oBoleta) and !empty($oBoletaTalonario)){
			
			$boleta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.DesId = des.DesId
				AND pac.BolId = "'.$oBoleta.'"
				AND pac.BtaId = "'.$oBoletaTalonario.'"			
			)
			';

		}	
		
			
		if(!empty($oArea)){
			$area = ' AND des.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(des.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(des.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(des.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(des.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oCuenta)){
			$cuenta = ' AND des.CueId = "'.$oCuenta.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND des.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oTipoDestino)){
			$tdestino = ' AND des.DesTipoDestino = "'.$oTipoDestino.'"';
		}
		
		if(!empty($oArea)){
			$area = ' AND des.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND des.SucId = "'.$oSucursal.'"';
		}	
		
		
		
		if(!empty($oFormaPago)){
			$fpago = ' AND des.FpaId = "'.$oFormaPago.'"';
		}	

			  $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				des.DesId,
				des.SucId,
				
				des.PrvId,
				
				des.PerId,
				des.CueId,

				DATE_FORMAT(des.DesFecha, "%d/%m/%Y") AS "NDesFecha",
				des.MonId,
				
				des.AreId,
				des.FpaId,
				
				des.DesTipoCambio,
				des.DesObservacion,
				des.DesObservacionImpresa,
				des.DesConcepto,
				des.DesNumeroCheque,
				des.DesReferencia,
				
				des.DesMonto,
				des.DesTipo,
				
				des.DesFoto,
			
				des.DesTipoDestino,

				des.DesEstado,	
				DATE_FORMAT(des.DesTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NDesTiempoCreacion",
                DATE_FORMAT(des.DesTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NDesTiempoModificacion",

				mon.MonNombre,
				mon.MonSimbolo,
				
				cue.CueNumero,
				ban.BanNombre,
				
				prv.PrvNombre,
				prv.PrvApellidoPaterno,
				prv.PrvApellidoMaterno,
				prv.PrvNumeroDocumento,
				prv.TdoId AS TdoIdProveedor,
				
				tdo.TdoNombre AS TdoNombreProveedor,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				cli.TdoId AS TdoIdCliente,
				tdo2.TdoNombre AS TdoNombreCliente,
				
				per.PerNombre,
				per.PerApellidoPaterno,
				per.PerApellidoMaterno,
				per.PerNumeroDocumento,
				per.TdoId AS TdoIdPersonal,
				tdo3.TdoNombre AS TdoNombrePersonal,
				
				fpa.FpaNombre
				
				FROM tbldesdesembolso des

					LEFT JOIN tblprvproveedor prv
					ON des.PrvId = prv.PrvId
				
						LEFT JOIN tbltdotipodocumento tdo
						ON prv.TdoId = tdo.TdoId
						
							LEFT JOIN tblclicliente cli
							ON des.CliId = cli.CliId
							
								LEFT JOIN tbltdotipodocumento tdo2
								ON cli.TdoId = tdo2.TdoId
		
									LEFT JOIN tblperpersonal per
									ON des.PerId = per.PerId
									
										LEFT JOIN tbltdotipodocumento tdo3
										ON per.TdoId = tdo3.TdoId
								
											LEFT JOIN tblcuecuenta cue
											ON des.CueId = cue.CueId
												
												LEFT JOIN tblbanbanco ban
												ON cue.BanId = ban.BanId
													
													LEFT JOIN tblmonmoneda mon
													ON des.MonId = mon.MonId
														
														LEFT JOIN tblfpaformapago fpa
														ON des.FpaId = fpa.FpaId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$sucursal.$fpago.$vdirecta.$ovvehiculo.$cpago.$moneda.$tdestino.$factura.$boleta.$area.$fecha.$cuenta.$area.$orden.$paginacion;
										
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsDesembolso = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Desembolso = new $InsDesembolso();				
					
                    $Desembolso->DesId = $fila['DesId'];
					  $Desembolso->SucId = $fila['SucId'];
					
					$Desembolso->PrvId = $fila['PrvId'];
					$Desembolso->PerId = $fila['PerId'];
					$Desembolso->CueId = $fila['CueId'];
					
                    $Desembolso->DesFecha = $fila['NDesFecha'];
					$Desembolso->MonId = $fila['MonId'];
					
					$Desembolso->AreId = $fila['AreId'];
					$Desembolso->FpaId = $fila['FpaId'];
					
					$Desembolso->DesTipoCambio= $fila['DesTipoCambio'];
					$Desembolso->DesObservacion = $fila['DesObservacion'];
					$Desembolso->DesObservacionImpresa = $fila['DesObservacionImpresa'];
					$Desembolso->DesConcepto = $fila['DesConcepto'];
					$Desembolso->DesNumeroCheque = $fila['DesNumeroCheque'];
					$Desembolso->DesReferencia = $fila['DesReferencia'];
					
					$Desembolso->DesMonto = $fila['DesMonto'];
					$Desembolso->DesTipo = $fila['DesTipo'];
					
					$Desembolso->DesFoto = $fila['DesFoto'];
					
					$Desembolso->DesTipoDestino = $fila['DesTipoDestino'];
					
					$Desembolso->DesEstado = $fila['DesEstado'];
                    $Desembolso->DesTiempoCreacion = $fila['NDesTiempoCreacion'];
					$Desembolso->DesTiempoModificacion = $fila['NDesTiempoModificacion'];

					$Desembolso->MonNombre = $fila['MonNombre'];
					$Desembolso->MonSimbolo = $fila['MonSimbolo'];
					
					$Desembolso->CueNumero = $fila['CueNumero'];
					$Desembolso->BanNombre = $fila['BanNombre'];
					
					$Desembolso->PrvNombre = $fila['PrvNombre'];
					$Desembolso->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$Desembolso->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$Desembolso->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$Desembolso->TdoIdProveedor = $fila['TdoIdProveedor'];					
					$Desembolso->TdoNombreProveedor = $fila['TdoNombreProveedor'];
					
					$Desembolso->CliNombre = $fila['CliNombre'];
					$Desembolso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$Desembolso->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$Desembolso->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$Desembolso->TdoIdCliente = $fila['TdoIdCliente'];
					$Desembolso->TdoNombreCliente = $fila['TdoNombreCliente'];
				
					$Desembolso->PerNombre = $fila['PerNombre'];
					$Desembolso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$Desembolso->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$Desembolso->PerNumeroDocumento = $fila['PerNumeroDocumento'];
					$Desembolso->TdoIdPersonal = $fila['TdoIdPersonal'];
					$Desembolso->TdoNombrePersonal = $fila['TdoNombrePersonal'];		

					$Desembolso->FpaNombre = $fila['FpaNombre'];		

	
					switch($Desembolso->DesEstado){
						case 1:
							$Desembolso->DesEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$Desembolso->DesEstadoDescripcion = "Realizado";
						break;
						
						case 6:
							$Desembolso->DesEstadoDescripcion = "Anulado";
					
						break;
						
					}	
				
                    $Desembolso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Desembolso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarDesembolso($oElementos) {
		
		
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					//$sql = 'UPDATE tbldesdesembolso SET DesEstado = '.$oEstado.' WHERE   DesId = "'.($elemento).'" ';
					$sql = 'DELETE FROM  tbldesdesembolso WHERE  DesId = "'.($elemento).'" ';
					
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarDesembolso(3,"Se elimino el Desembolso",$aux);	
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
			
			
			
			/*
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (DesId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (DesId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tbldesdesembolso WHERE '.$eliminar;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {						
				return false;
			} else {				
				return true;
			}	*/						
	}
	
	

	public function MtdActualizarEstadoDesembolso($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					
					$sql = 'UPDATE tbldesdesembolso SET DesEstado = '.$oEstado.' WHERE   DesId = "'.($elemento).'" ';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarDesembolso(2,"Se actualizo el Estado del Desembolso",$elemento);	
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



	public function MtdRegistrarDesembolso() {
	
	
	$this->InsMysql->MtdTransaccionIniciar();
	
	$error = false;
	
			$this->MtdGenerarDesembolsoId();
		
			$sql = 'INSERT INTO tbldesdesembolso (
			DesId,
			SucId,
			
			PerId,
			PrvId,
			CliId,
			
			CueId,
		
			DesNumeroCheque,
			DesReferencia,
			
			DesFecha,
			MonId,
			
			AreId,
			FpaId,
			
			DesTipoCambio,
			DesObservacion,
			DesObservacionImpresa,
			DesConcepto,
			
			DesMonto,
			DesTipo,
			DesFoto,
			
			DesTipoDestino,
			
			DesEstado,
			DesTiempoCreacion,
			DesTiempoModificacion
			) 
			VALUES (
			"'.($this->DesId).'", 
			"'.($this->SucId).'", 

			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			
			'.(empty($this->CueId)?'NULL, ':'"'.$this->CueId.'",').'

			"'.($this->DesNumeroCheque).'",
			"'.($this->DesReferencia).'",
						
			"'.($this->DesFecha).'",
			"'.($this->MonId).'",
			
			'.(empty($this->AreId)?'NULL, ':'"'.$this->AreId.'",').'
			'.(empty($this->FpaId)?'NULL, ':'"'.$this->FpaId.'",').'
			
			'.(empty($this->DesTipoCambio)?'NULL, ':''.$this->DesTipoCambio.',').'
			"'.($this->DesObservacion).'",
			"'.($this->DesObservacionImpresa).'",
			"'.($this->DesConcepto).'", 
			
			'.($this->DesMonto).',
			"'.($this->DesTipo).'",
			"'.($this->DesFoto).'",
			
			"'.($this->DesTipoDestino).'",
			
			'.($this->DesEstado).', 
			"'.($this->DesTiempoCreacion).'", 
			"'.($this->DesTiempoModificacion).'");';					

			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
//
//			if(!$error){			
//	
//				if (!empty($this->DesembolsoComprobante)){		
//
//				$validar = 0;		
//				$InsDesembolsoComprobante = new ClsDesembolsoComprobante();	
//
//					foreach ($this->DesembolsoComprobante as $DatDesembolsoComprobante){
//
//				//	deb($this->DesId);
//					$InsDesembolsoComprobante->DesId = $this->DesId;
//
//					$InsDesembolsoComprobante->CliId = $DatDesembolsoComprobante->CliId;
//					$InsDesembolsoComprobante->PrvId = $DatDesembolsoComprobante->PrvId;
//					$InsDesembolsoComprobante->PadId = $DatDesembolsoComprobante->PadId;
//
//					$InsDesembolsoComprobante->DdeEstado = $DatDesembolsoComprobante->DdeEstado;							
//					$InsDesembolsoComprobante->DdeTiempoCreacion = $DatDesembolsoComprobante->DdeTiempoCreacion;
//					$InsDesembolsoComprobante->DdeTiempoModificacion = $DatDesembolsoComprobante->DdeTiempoModificacion;						
//					$InsDesembolsoComprobante->DdeEliminado = $DatDesembolsoComprobante->DdeEliminado;
//
//					//deb($InsDesembolsoComprobante->DesId);					
//					if($InsDesembolsoComprobante->MtdRegistrarDesembolsoComprobante()){
//						$validar++;	
//					}else{
//						$Resultado.='#ERR_DES_201';
//						$Resultado.='#Item Numero: '.($validar+1);
//					}
//
//					}					
//
//					if(count($this->DesembolsoComprobante) <> $validar ){
//						$error = true;
//					}					
//		
//				}				
//			}
			
			
			if(!$error){			
	
				if (!empty($this->DesembolsoComprobante)){		

				$validar = 0;		
				$InsDesembolsoComprobante = new ClsDesembolsoComprobante();	
											
					foreach ($this->DesembolsoComprobante as $DatDesembolsoComprobante){

						$InsDesembolsoComprobante->DesId = $this->DesId;
						
						$DatDesembolsoComprobante->AmoId = $DatDesembolsoComprobante->AmoId;
						
						$DatDesembolsoComprobante->DcoEstado = $DatDesembolsoComprobante->DcoEstado;							
						$DatDesembolsoComprobante->DcoTiempoCreacion = $DatDesembolsoComprobante->DcoTiempoCreacion;
						$DatDesembolsoComprobante->DcoTiempoModificacion = $DatDesembolsoComprobante->DcoTiempoModificacion;						
						$DatDesembolsoComprobante->DcoEliminado = $DatDesembolsoComprobante->DcoEliminado;

						if($InsDesembolsoComprobante->MtdRegistrarDesembolsoComprobante()){
							$validar++;	
						}else{
							$Resultado.='#ERR_DES_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}

					}					

					if(count($this->DesembolsoComprobante) <> $validar ){
						$error = true;
					}					
		
				}				
			}
			
			
		
		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();
			
			$this->MtdAuditarDesembolso(1,"Se registro el Desembolso",$this);	
			return true;
		}		
				
			
	}
	
	
	
	public function MtdEditarDesembolso() {
		
		$sql = 'UPDATE tbldesdesembolso SET 
		
		
		'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
		'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		
		'.(empty($this->CueId)?'CueId = NULL, ':'CueId = "'.$this->CueId.'",').'
		
		DesFecha = "'.($this->DesFecha).'",
		
		DesNumeroCheque = "'.$this->DesNumeroCheque.'",
		DesReferencia = "'.$this->DesReferencia.'",
	
		MonId = "'.($this->MonId).'",
		'.(empty($this->DesTipoCambio)?'DesTipoCambio = NULL, ':'DesTipoCambio = '.$this->DesTipoCambio.',').'
		
		'.(empty($this->AreId)?'AreId = NULL, ':'AreId = "'.$this->AreId.'",').'
		'.(empty($this->FpaId)?'FpaId = NULL, ':'FpaId = "'.$this->FpaId.'",').'
		
		DesObservacion = "'.($this->DesObservacion).'",
		DesObservacionImpresa = "'.($this->DesObservacionImpresa).'",
		DesConcepto = "'.($this->DesConcepto).'",

		DesMonto = '.($this->DesMonto).',
		DesTipo = "'.($this->DesTipo).'",
		
		DesFoto = "'.($this->DesFoto).'",
	
		DesTipoDestino = "'.($this->DesTipoDestino).'",
	
		DesEstado = '.($this->DesEstado).',
		DesTiempoModificacion = "'.($this->DesTiempoModificacion).'"
		WHERE DesId = "'.($this->DesId).'";';
			
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
	
		if(!$resultado) {						
		  $error = true;
		} 	


		//deb($this->DesembolsoComprobante);
//
//		if(!$error){
//
//				if (!empty($this->DesembolsoComprobante)){		
//						
//					$validar = 0;				
//					$InsDesembolsoComprobante = new ClsDesembolsoComprobante();
//
//					foreach ($this->DesembolsoComprobante as $DatDesembolsoComprobante){
//
//						$InsDesembolsoComprobante->DdeId = $DatDesembolsoComprobante->DdeId;
//						$InsDesembolsoComprobante->DesId = $this->DesId;
//
//						$InsDesembolsoComprobante->CliId = $DatDesembolsoComprobante->CliId;
//						$InsDesembolsoComprobante->PrvId = $DatDesembolsoComprobante->PrvId;						
//						$InsDesembolsoComprobante->PadId = $DatDesembolsoComprobante->PadId;
//						
//						$InsDesembolsoComprobante->DdeEstado = $DatDesembolsoComprobante->DdeEstado;
//						$InsDesembolsoComprobante->DdeTiempoCreacion = $DatDesembolsoComprobante->DdeTiempoCreacion;
//						$InsDesembolsoComprobante->DdeTiempoModificacion = $DatDesembolsoComprobante->DdeTiempoModificacion;
//						$InsDesembolsoComprobante->DdeEliminado = $DatDesembolsoComprobante->DdeEliminado;
//						
//						if(empty($InsDesembolsoComprobante->DdeId)){
//							if($InsDesembolsoComprobante->DdeEliminado<>2){
//								if($InsDesembolsoComprobante->MtdRegistrarDesembolsoComprobante()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_DES_201';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								$validar++;
//							}
//						}else{						
//							if($InsDesembolsoComprobante->DdeEliminado==2){
//								if($InsDesembolsoComprobante->MtdEliminarDesembolsoComprobante($InsDesembolsoComprobante->DdeId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_DES_203';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								if($InsDesembolsoComprobante->MtdEditarDesembolsoComprobante()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_DES_202';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}
//						}									
//					}
//					
//					if(count($this->DesembolsoComprobante) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}
//			
			if(!$error){

				if (!empty($this->DesembolsoComprobante)){		
						
					$validar = 0;				
					$InsDesembolsoComprobante = new ClsDesembolsoComprobante();

					foreach ($this->DesembolsoComprobante as $DatDesembolsoComprobante){

						$InsDesembolsoComprobante->DcoId = $DatDesembolsoComprobante->DcoId;
						$InsDesembolsoComprobante->DesId = $DatDesembolsoComprobante->DesId;
						
						$InsDesembolsoComprobante->AmoId = $DatDesembolsoComprobante->AmoId;
						
						$InsDesembolsoComprobante->DcoEstado = $DatDesembolsoComprobante->DcoEstado;
						$InsDesembolsoComprobante->DcoTiempoCreacion = $DatDesembolsoComprobante->DcoTiempoCreacion;
						$InsDesembolsoComprobante->DcoTiempoModificacion = $DatDesembolsoComprobante->DcoTiempoModificacion;
						$InsDesembolsoComprobante->DcoEliminado = $DatDesembolsoComprobante->DcoEliminado;
						
						if(empty($InsDesembolsoComprobante->DcoId)){
							if($InsDesembolsoComprobante->DcoEliminado<>2){
								if($InsDesembolsoComprobante->MtdRegistrarDesembolsoComprobante()){
									$validar++;	
								}else{
									$Resultado.='#ERR_DES_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsDesembolsoComprobante->DcoEliminado==2){
								if($InsDesembolsoComprobante->MtdEliminarDesembolsoComprobante($InsDesembolsoComprobante->DcoId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_DES_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsDesembolsoComprobante->MtdEditarDesembolsoComprobante()){
									$validar++;	
								}else{
									$Resultado.='#ERR_DES_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->DesembolsoComprobante) <> $validar ){
						$error = true;
					}					
								
				}				
			}

			
			if($error) {						
				return false;
			} else {	
			
				$this->MtdAuditarDesembolso(2,"Se edito el Desembolso",$this);					
				return true;
			}						
				
		}	
		
		
		
		public function MtdEditarDesembolsoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tbldesdesembolso SET 
			'.$oCampo.' = "'.($oDato).'",
			DesTiempoModificacion = NOW()
			WHERE DesId = "'.($oId).'";';
			
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
	






		public function MtdNotificarDesembolsoRegistro($oDesembolso,$oDestinatario){
			
			$this->OcoId = $oDesembolso;
			$this->MtdObtenerDesembolso();
			
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Datos del Desembolso.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->DesId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Fecha Desembolso: <b>".$this->DesFecha."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "A la Orden de: <b>";	
			$mensaje .= "".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."";	
			$mensaje .= "".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."";	
			$mensaje .= "</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Numero de Cheque: <b>".$this->DesNumeroCheque."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Cuenta Afecta: <b>".$this->BanNombre."/".$this->CueNumero."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Moneda: <b>".$this->MonNombre."</b>";	
			$mensaje .= "<br>";	
			
			if($this->MonId<>$EmpresaMonedaId ){
				$this->DesMonto = round($this->DesMonto / $this->DesTipoCambio,2);
			}		

			$mensaje .= "Monto: <b>".number_format($this->DesMonto,2)."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "Concepto: <b>".$this->DesConcepto."</b>";	
			$mensaje .= "<br>";	

					
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
					
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//echo $mensaje;
			$InsCorreo = new ClsCorreo();	
			//$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO DESEMBOLSO: ".$this->DesId." - ".$this->DesNumeroCheque." - ".$this->DesFecha,$mensaje);
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO DESEMBOLSO: ".$this->DesNumeroCheque." - ".$this->DesFecha,$mensaje);
			
		}
		
		
		
		private function MtdAuditarDesembolso($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->DesId;
			$InsAuditoria->AudCodigoExtra = "";
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
	
}
?>