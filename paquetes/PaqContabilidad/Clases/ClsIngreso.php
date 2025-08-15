<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Ingcription of ClsIngreso
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsIngreso {

    public $IngId;
	
	public $PrvId;
	public $CliId;
	public $PerId;
	
	public $CueId;
    public $IngFecha;
    public $MonId;
	
	public $AreId;
	
	public $IngTipoCambio;
	public $IngObservacion;
	public $IngObservacionImpresa;
	public $IngConcepto;
	
	public $IngNumeroCheque;
	public $IngReferencia;

	public $IngMonto;
	public $IngTipo;
	public $IngFoto;
	
	public $IngTipoDestino;
	
	public $IngEstado;	
    public $IngTiempoCreacion;
    public $IngTiempoModificacion;
    public $IngEliminado;

	
	
	
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
	
	public function __ingtruct(){

	}
		
	public function MtdGenerarIngresoId() {

		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(IngId,5),unsigned)) AS "MAXIMO"
		FROM tblingingreso';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->IngId = "ING-10000";
		
		}else{
			$fila['MAXIMO']++;
			$this->IngId = "ING-".$fila['MAXIMO'];					
		}

	}
		
    public function MtdObtenerIngreso($oCompleto=true){

        $sql = 'SELECT 
        ing.IngId,
		ing.SucId,
		
		ing.PrvId,
		ing.CliId,
		ing.PerId,
		
		ing.CueId,
		DATE_FORMAT(ing.IngFecha, "%d/%m/%Y") AS "NIngFecha",
		ing.MonId,
		
		ing.AreId,
		ing.FpaId,
		
		ing.IngTipoCambio,
		ing.IngObservacion,
		ing.IngObservacionImpresa,
		ing.IngConcepto,
		
		ing.IngNumeroCheque,
		ing.IngReferencia,
	
		ing.IngMonto,
		ing.IngTipo,
		ing.IngFoto,
		
		ing.IngTipoDestino,
		
		ing.IngEstado,	
		DATE_FORMAT(ing.IngTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NIngTiempoCreacion",
        DATE_FORMAT(ing.IngTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NIngTiempoModificacion",
		
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
		ban.BanNombre,
		
		fpa.FpaNombre
		
        FROM tblingingreso ing
			
			LEFT JOIN tblprvproveedor prv
			ON ing.PrvId = prv.PrvId
			
				LEFT JOIN tblcuecuenta cue
				ON ing.CueId = cue.CueId
					
					LEFT JOIN tblbanbanco ban
					ON cue.BanId = ban.BanId
					
					LEFT JOIN tbltdotipodocumento tdo
					ON prv.TdoId = tdo.TdoId
					
						LEFT JOIN tblclicliente cli
						ON ing.CliId = cli.CliId
						
							LEFT JOIN tbltdotipodocumento tdo2
							ON cli.TdoId = tdo2.TdoId
	
								LEFT JOIN tblperpersonal per
								ON ing.PerId = per.PerId
								
									LEFT JOIN tbltdotipodocumento tdo3
									ON per.TdoId = tdo3.TdoId
						
						
					LEFT JOIN tblmonmoneda mon
					ON ing.MonId = mon.MonId
					
					LEFT JOIN tblfpaformapago fpa
					ON ing.FpaId = fpa.FpaId
					
					
        WHERE IngId = "'.$this->IngId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->IngId = $fila['IngId'];
			$this->SucId = $fila['SucId'];
			
			$this->PrvId = $fila['PrvId'];
			$this->PerId = $fila['PerId'];
			$this->CliId = $fila['CliId'];
			
			
			$this->CueId = $fila['CueId'];
			$this->IngFecha = $fila['NIngFecha'];
			$this->MonId = $fila['MonId'];
			
			$this->AreId = $fila['AreId'];
			$this->FpaId = $fila['FpaId'];
			
			$this->IngTipoCambio = $fila['IngTipoCambio'];
			$this->IngObservacion = $fila['IngObservacion'];
			$this->IngObservacionImpresa = $fila['IngObservacionImpresa'];
			$this->IngConcepto = $fila['IngConcepto'];
			$this->IngNumeroCheque = $fila['IngNumeroCheque'];
			$this->IngReferencia = $fila['IngReferencia'];

			$this->IngMonto = $fila['IngMonto'];
			$this->IngTipo = $fila['IngTipo'];	
	
			$this->IngFoto = $fila['IngFoto'];
			
			$this->IngTipoDestino = $fila['IngTipoDestino'];				
			
			$this->IngEstado = $fila['IngEstado'];
			$this->IngTiempoCreacion = $fila['NIngTiempoCreacion'];
			$this->IngTiempoModificacion = $fila['NIngTiempoModificacion'];
			
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
			
			$this->FpaNombre = $fila['FpaNombre'];
		
			if($oCompleto){

				// MtdObtenerIngresoComprobantes($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IcoId',$oSentido = 'Ingc',$oPaginacion = '0,10',$oIngreso=NULL)
				$InsIngresoComprobante = new ClsIngresoComprobante();
				$ResIngresoComprobante = $InsIngresoComprobante->MtdObtenerIngresoComprobantes(NULL,NULL,NULL,'IcoId','ASC',NULL,$this->IngId);
				$this->IngresoComprobante = $ResIngresoComprobante['Datos'];
				
			}


				switch($this->IngEstado){
					case 1:
						$this->IngEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->IngEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->IngEstadoDescripcion = "Anulado";
				
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

    public function MtdObtenerIngresos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'IngId',$oSentido = 'Ingc',$oInginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="IngFecha",$oCuenta=NULL,$oMoneda=NULL,$oTipoDestino=NULL,$oArea=NULL,$oSucursal=NULL,$oFormaPago=NULL,$oTipo=NULL) {
		
		
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

		if(!empty($oInginacion)){
			$paginacion = ' LIMIT '.($oInginacion);
		}
			
				
		if(!empty($oEstado)){
			$estado = ' AND ing.IngEstado = '.$oEstado;
		}	
		
		if(!empty($oVentaDirecta)){
			
			$vdirecta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.IngId = ing.IngId
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
				WHERE pac.IngId = ing.IngId
				AND pac.IngId = "'.$oOrdenVentaVehiculo.'"
			
			)
			';
		}	
		
	
			
		if(!empty($oMoneda)){
			$moneda = ' AND ing.MonId = "'.$oMoneda.'"';
		}	
		
	
		if(!empty($oFactura) and !empty($oFacturaTalonario)){
			
			$factura = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.IngId = ing.IngId
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
				WHERE pac.IngId = ing.IngId
				AND pac.BolId = "'.$oBoleta.'"
				AND pac.BtaId = "'.$oBoletaTalonario.'"			
			)
			';

		}	
		
			
		if(!empty($oArea)){
			$area = ' AND ing.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ing.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(ing.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(ing.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(ing.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oCuenta)){
			$cuenta = ' AND ing.CueId = "'.$oCuenta.'"';
		}
		
		if(!empty($oMoneda)){
			$moneda = ' AND ing.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oTipoDestino)){
			$tingtino = ' AND ing.IngTipoDestino = "'.$oTipoDestino.'"';
		}
		
		if(!empty($oArea)){
			$area = ' AND ing.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oSucursal)){
			$sucursal = ' AND ing.SucId = "'.$oSucursal.'"';
		}	
		
		
		if(!empty($oFormaPago)){
			$fpago = ' AND ing.FpaId = "'.$oFormaPago.'"';
		}	
		
		
		if(!empty($oTipo)){
			$tipo = ' AND ing.IngTipo = "'.$oTipo.'"';
		}	

			  $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				ing.IngId,
				ing.SucId,
				
				ing.PrvId,
				
				ing.PerId,
				ing.CueId,

				DATE_FORMAT(ing.IngFecha, "%d/%m/%Y") AS "NIngFecha",
				ing.MonId,
				
				ing.AreId,
				ing.FpaId,
				
				ing.IngTipoCambio,
				ing.IngObservacion,
				ing.IngObservacionImpresa,
				ing.IngConcepto,
				ing.IngNumeroCheque,
				ing.IngReferencia,
				
				ing.IngMonto,
				ing.IngTipo,
				
				ing.IngFoto,
			
				ing.IngTipoDestino,

				ing.IngEstado,	
				DATE_FORMAT(ing.IngTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NIngTiempoCreacion",
                DATE_FORMAT(ing.IngTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NIngTiempoModificacion",

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
				
				FROM tblingingreso ing

					LEFT JOIN tblprvproveedor prv
					ON ing.PrvId = prv.PrvId
				
						LEFT JOIN tbltdotipodocumento tdo
						ON prv.TdoId = tdo.TdoId
						
							LEFT JOIN tblclicliente cli
							ON ing.CliId = cli.CliId
							
								LEFT JOIN tbltdotipodocumento tdo2
								ON cli.TdoId = tdo2.TdoId
		
									LEFT JOIN tblperpersonal per
									ON ing.PerId = per.PerId
									
										LEFT JOIN tbltdotipodocumento tdo3
										ON per.TdoId = tdo3.TdoId
								
											LEFT JOIN tblcuecuenta cue
											ON ing.CueId = cue.CueId
												
												LEFT JOIN tblbanbanco ban
												ON cue.BanId = ban.BanId
													
													LEFT JOIN tblmonmoneda mon
													ON ing.MonId = mon.MonId
													
														LEFT JOIN tblfpaformapago fpa
														ON ing.FpaId = fpa.FpaId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$sucursal.$vdirecta.$ovvehiculo.$fpago.$cpago.$moneda.$tingtino.$factura.$boleta.$area.$fecha.$cuenta.$area.$orden.$paginacion;
										
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsIngreso = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Ingreso = new $InsIngreso();				
					
                    $Ingreso->IngId = $fila['IngId'];
					  $Ingreso->SucId = $fila['SucId'];
					
					$Ingreso->PrvId = $fila['PrvId'];
					$Ingreso->PerId = $fila['PerId'];
					$Ingreso->CueId = $fila['CueId'];
					
                    $Ingreso->IngFecha = $fila['NIngFecha'];
					$Ingreso->MonId = $fila['MonId'];
					
					$Ingreso->AreId = $fila['AreId'];
					$Ingreso->Fpaid = $fila['Fpaid'];
					
					
					$Ingreso->IngTipoCambio= $fila['IngTipoCambio'];
					$Ingreso->IngObservacion = $fila['IngObservacion'];
					$Ingreso->IngObservacionImpresa = $fila['IngObservacionImpresa'];
					$Ingreso->IngConcepto = $fila['IngConcepto'];
					$Ingreso->IngNumeroCheque = $fila['IngNumeroCheque'];
					$Ingreso->IngReferencia = $fila['IngReferencia'];
					
					$Ingreso->IngMonto = $fila['IngMonto'];
					$Ingreso->IngTipo = $fila['IngTipo'];
					
					$Ingreso->IngFoto = $fila['IngFoto'];
					
					$Ingreso->IngTipoDestino = $fila['IngTipoDestino'];
					
					$Ingreso->IngEstado = $fila['IngEstado'];
                    $Ingreso->IngTiempoCreacion = $fila['NIngTiempoCreacion'];
					$Ingreso->IngTiempoModificacion = $fila['NIngTiempoModificacion'];

					$Ingreso->MonNombre = $fila['MonNombre'];
					$Ingreso->MonSimbolo = $fila['MonSimbolo'];
					
					$Ingreso->CueNumero = $fila['CueNumero'];
					$Ingreso->BanNombre = $fila['BanNombre'];
					
					$Ingreso->PrvNombre = $fila['PrvNombre'];
					$Ingreso->PrvApellidoPaterno = $fila['PrvApellidoPaterno'];
					$Ingreso->PrvApellidoMaterno = $fila['PrvApellidoMaterno'];
					$Ingreso->PrvNumeroDocumento = $fila['PrvNumeroDocumento'];
					$Ingreso->TdoIdProveedor = $fila['TdoIdProveedor'];					
					$Ingreso->TdoNombreProveedor = $fila['TdoNombreProveedor'];
					
					$Ingreso->CliNombre = $fila['CliNombre'];
					$Ingreso->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$Ingreso->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$Ingreso->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$Ingreso->TdoIdCliente = $fila['TdoIdCliente'];
					$Ingreso->TdoNombreCliente = $fila['TdoNombreCliente'];
				
					$Ingreso->PerNombre = $fila['PerNombre'];
					$Ingreso->PerApellidoPaterno = $fila['PerApellidoPaterno'];
					$Ingreso->PerApellidoMaterno = $fila['PerApellidoMaterno'];
					$Ingreso->PerNumeroDocumento = $fila['PerNumeroDocumento'];
					$Ingreso->TdoIdPersonal = $fila['TdoIdPersonal'];
					$Ingreso->TdoNombrePersonal = $fila['TdoNombrePersonal'];		

					$Ingreso->FpaNombre = $fila['FpaNombre'];		

					
					switch($Ingreso->IngTipo){
						case 1:
							$Ingreso->IngTipoDescripcion = "Saldo Inicial";
						break;
											
						case 5:
							$Ingreso->IngTipoDescripcion = "Otros";
						break;
						
						default:
							$Ingreso->IngTipoDescripcion = "-";
					
						break;
						
					}	
					switch($Ingreso->IngEstado){
						case 1:
							$Ingreso->IngEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$Ingreso->IngEstadoDescripcion = "Realizado";
						break;
						
						case 6:
							$Ingreso->IngEstadoDescripcion = "Anulado";
					
						break;
						
					}	
				
                    $Ingreso->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Ingreso;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdEliminarIngreso($oElementos) {
		
		
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					//$sql = 'UPDATE tblingingreso SET IngEstado = '.$oEstado.' WHERE   IngId = "'.($elemento).'" ';
					$sql = 'DELETE FROM  tblingingreso WHERE  IngId = "'.($elemento).'" ';
					
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarIngreso(3,"Se elimino el Ingreso",$aux);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionInghacer();								
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
						$eliminar .= '  (IngId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (IngId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblingingreso WHERE '.$eliminar;
			
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
	
	

	public function MtdActualizarEstadoIngreso($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					
					$sql = 'UPDATE tblingingreso SET IngEstado = '.$oEstado.' WHERE   IngId = "'.($elemento).'" ';
			
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{
						$this->MtdAuditarIngreso(2,"Se actualizo el Estado del Ingreso",$elemento);	
					}
				}
			$i++;
	
			}
		
			if($error) {	
				$this->InsMysql->MtdTransaccionInghacer();								
				return false;
			} else {				
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}							
	}



	public function MtdRegistrarIngreso() {
	
	
	$this->InsMysql->MtdTransaccionIniciar();
	
	$error = false;
	
			$this->MtdGenerarIngresoId();
		
			$sql = 'INSERT INTO tblingingreso (
			IngId,
			SucId,
			
			PerId,
			PrvId,
			CliId,
			
			CueId,
		
			IngNumeroCheque,
			IngReferencia,
			
			IngFecha,
			MonId,
			
			AreId,
			FpaId,
			
			IngTipoCambio,
			IngObservacion,
			IngObservacionImpresa,
			IngConcepto,
			
			IngMonto,
			IngTipo,
			IngFoto,
			
			IngTipoDestino,
			
			IngEstado,
			IngTiempoCreacion,
			IngTiempoModificacion
			) 
			VALUES (
			"'.($this->IngId).'", 
			"'.($this->SucId).'", 

			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
			'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
			
			'.(empty($this->CueId)?'NULL, ':'"'.$this->CueId.'",').'

			"'.($this->IngNumeroCheque).'",
			"'.($this->IngReferencia).'",
						
			"'.($this->IngFecha).'",
			"'.($this->MonId).'",
			
			'.(empty($this->AreId)?'NULL, ':'"'.$this->AreId.'",').'
			'.(empty($this->FpaId)?'NULL, ':'"'.$this->FpaId.'",').'
			
			
			'.(empty($this->IngTipoCambio)?'NULL, ':''.$this->IngTipoCambio.',').'
			"'.($this->IngObservacion).'",
			"'.($this->IngObservacionImpresa).'",
			"'.($this->IngConcepto).'", 
			
			'.($this->IngMonto).',
			"'.($this->IngTipo).'",
			"'.($this->IngFoto).'",
			
			"'.($this->IngTipoDestino).'",
			
			'.($this->IngEstado).', 
			"'.($this->IngTiempoCreacion).'", 
			"'.($this->IngTiempoModificacion).'");';					

			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	
//
//			if(!$error){			
//	
//				if (!empty($this->IngresoComprobante)){		
//
//				$validar = 0;		
//				$InsIngresoComprobante = new ClsIngresoComprobante();	
//
//					foreach ($this->IngresoComprobante as $DatIngresoComprobante){
//
//				//	deb($this->IngId);
//					$InsIngresoComprobante->IngId = $this->IngId;
//
//					$InsIngresoComprobante->CliId = $DatIngresoComprobante->CliId;
//					$InsIngresoComprobante->PrvId = $DatIngresoComprobante->PrvId;
//					$InsIngresoComprobante->PadId = $DatIngresoComprobante->PadId;
//
//					$InsIngresoComprobante->DdeEstado = $DatIngresoComprobante->DdeEstado;							
//					$InsIngresoComprobante->DdeTiempoCreacion = $DatIngresoComprobante->DdeTiempoCreacion;
//					$InsIngresoComprobante->DdeTiempoModificacion = $DatIngresoComprobante->DdeTiempoModificacion;						
//					$InsIngresoComprobante->DdeEliminado = $DatIngresoComprobante->DdeEliminado;
//
//					//deb($InsIngresoComprobante->IngId);					
//					if($InsIngresoComprobante->MtdRegistrarIngresoComprobante()){
//						$validar++;	
//					}else{
//						$Resultado.='#ERR_ING_201';
//						$Resultado.='#Item Numero: '.($validar+1);
//					}
//
//					}					
//
//					if(count($this->IngresoComprobante) <> $validar ){
//						$error = true;
//					}					
//		
//				}				
//			}
			
			
			if(!$error){			
	
				if (!empty($this->IngresoComprobante)){		

				$validar = 0;		
				$InsIngresoComprobante = new ClsIngresoComprobante();	
											
					foreach ($this->IngresoComprobante as $DatIngresoComprobante){

						$InsIngresoComprobante->IngId = $this->IngId;
						
						$DatIngresoComprobante->AmoId = $DatIngresoComprobante->AmoId;
						
						$DatIngresoComprobante->IcoEstado = $DatIngresoComprobante->IcoEstado;							
						$DatIngresoComprobante->IcoTiempoCreacion = $DatIngresoComprobante->IcoTiempoCreacion;
						$DatIngresoComprobante->IcoTiempoModificacion = $DatIngresoComprobante->IcoTiempoModificacion;						
						$DatIngresoComprobante->IcoEliminado = $DatIngresoComprobante->IcoEliminado;

						if($InsIngresoComprobante->MtdRegistrarIngresoComprobante()){
							$validar++;	
						}else{
							$Resultado.='#ERR_ING_301';
							$Resultado.='#Item Numero: '.($validar+1);
						}

					}					

					if(count($this->IngresoComprobante) <> $validar ){
						$error = true;
					}					
		
				}				
			}
			
			
		
		if($error) {	
			$this->InsMysql->MtdTransaccionInghacer();			
			return false;
		} else {				
			$this->InsMysql->MtdTransaccionHacer();
			
			$this->MtdAuditarIngreso(1,"Se registro el Ingreso",$this);	
			return true;
		}		
				
			
	}
	
	
	
	public function MtdEditarIngreso() {
		
		$sql = 'UPDATE tblingingreso SET 
		
		
		'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
		'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		
		'.(empty($this->CueId)?'CueId = NULL, ':'CueId = "'.$this->CueId.'",').'
		
		IngFecha = "'.($this->IngFecha).'",
		
		IngNumeroCheque = "'.$this->IngNumeroCheque.'",
		IngReferencia = "'.$this->IngReferencia.'",
	
		MonId = "'.($this->MonId).'",
		'.(empty($this->IngTipoCambio)?'IngTipoCambio = NULL, ':'IngTipoCambio = '.$this->IngTipoCambio.',').'
		
		'.(empty($this->AreId)?'AreId = NULL, ':'AreId = "'.$this->AreId.'",').'
		'.(empty($this->FpaId)?'FpaId = NULL, ':'FpaId = "'.$this->FpaId.'",').'
		
		IngObservacion = "'.($this->IngObservacion).'",
		IngObservacionImpresa = "'.($this->IngObservacionImpresa).'",
		IngConcepto = "'.($this->IngConcepto).'",

		IngMonto = '.($this->IngMonto).',
		IngTipo = "'.($this->IngTipo).'",
		
		IngFoto = "'.($this->IngFoto).'",
	
		IngTipoDestino = "'.($this->IngTipoDestino).'",
	
		IngEstado = '.($this->IngEstado).',
		IngTiempoModificacion = "'.($this->IngTiempoModificacion).'"
		WHERE IngId = "'.($this->IngId).'";';
			
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,true);        
	
		if(!$resultado) {						
		  $error = true;
		} 	


		//deb($this->IngresoComprobante);
//
//		if(!$error){
//
//				if (!empty($this->IngresoComprobante)){		
//						
//					$validar = 0;				
//					$InsIngresoComprobante = new ClsIngresoComprobante();
//
//					foreach ($this->IngresoComprobante as $DatIngresoComprobante){
//
//						$InsIngresoComprobante->DdeId = $DatIngresoComprobante->DdeId;
//						$InsIngresoComprobante->IngId = $this->IngId;
//
//						$InsIngresoComprobante->CliId = $DatIngresoComprobante->CliId;
//						$InsIngresoComprobante->PrvId = $DatIngresoComprobante->PrvId;						
//						$InsIngresoComprobante->PadId = $DatIngresoComprobante->PadId;
//						
//						$InsIngresoComprobante->DdeEstado = $DatIngresoComprobante->DdeEstado;
//						$InsIngresoComprobante->DdeTiempoCreacion = $DatIngresoComprobante->DdeTiempoCreacion;
//						$InsIngresoComprobante->DdeTiempoModificacion = $DatIngresoComprobante->DdeTiempoModificacion;
//						$InsIngresoComprobante->DdeEliminado = $DatIngresoComprobante->DdeEliminado;
//						
//						if(empty($InsIngresoComprobante->DdeId)){
//							if($InsIngresoComprobante->DdeEliminado<>2){
//								if($InsIngresoComprobante->MtdRegistrarIngresoComprobante()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_ING_201';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								$validar++;
//							}
//						}else{						
//							if($InsIngresoComprobante->DdeEliminado==2){
//								if($InsIngresoComprobante->MtdEliminarIngresoComprobante($InsIngresoComprobante->DdeId)){
//									$validar++;					
//								}else{
//									$Resultado.='#ERR_ING_203';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}else{
//								if($InsIngresoComprobante->MtdEditarIngresoComprobante()){
//									$validar++;	
//								}else{
//									$Resultado.='#ERR_ING_202';
//									$Resultado.='#Item Numero: '.($validar+1);
//								}
//							}
//						}									
//					}
//					
//					if(count($this->IngresoComprobante) <> $validar ){
//						$error = true;
//					}					
//								
//				}				
//			}
//			
			if(!$error){

				if (!empty($this->IngresoComprobante)){		
						
					$validar = 0;				
					$InsIngresoComprobante = new ClsIngresoComprobante();

					foreach ($this->IngresoComprobante as $DatIngresoComprobante){

						$InsIngresoComprobante->IcoId = $DatIngresoComprobante->IcoId;
						$InsIngresoComprobante->IngId = $DatIngresoComprobante->IngId;
						
						$InsIngresoComprobante->AmoId = $DatIngresoComprobante->AmoId;
						
						$InsIngresoComprobante->IcoEstado = $DatIngresoComprobante->IcoEstado;
						$InsIngresoComprobante->IcoTiempoCreacion = $DatIngresoComprobante->IcoTiempoCreacion;
						$InsIngresoComprobante->IcoTiempoModificacion = $DatIngresoComprobante->IcoTiempoModificacion;
						$InsIngresoComprobante->IcoEliminado = $DatIngresoComprobante->IcoEliminado;
						
						if(empty($InsIngresoComprobante->IcoId)){
							if($InsIngresoComprobante->IcoEliminado<>2){
								if($InsIngresoComprobante->MtdRegistrarIngresoComprobante()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ING_301';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsIngresoComprobante->IcoEliminado==2){
								if($InsIngresoComprobante->MtdEliminarIngresoComprobante($InsIngresoComprobante->IcoId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_ING_303';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsIngresoComprobante->MtdEditarIngresoComprobante()){
									$validar++;	
								}else{
									$Resultado.='#ERR_ING_302';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->IngresoComprobante) <> $validar ){
						$error = true;
					}					
								
				}				
			}

			
			if($error) {						
				return false;
			} else {	
			
				$this->MtdAuditarIngreso(2,"Se edito el Ingreso",$this);					
				return true;
			}						
				
		}	
		
		
		
		public function MtdEditarIngresoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblingingreso SET 
			'.$oCampo.' = "'.($oDato).'",
			IngTiempoModificacion = NOW()
			WHERE IngId = "'.($oId).'";';
			
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
	






		public function MtdNotificarIngresoRegistro($oIngreso,$oIngtinatario){
			
			$this->OcoId = $oIngreso;
			$this->MtdObtenerIngreso();
			
			global $EmpresaMonedaId;
			global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Datos del Ingreso.";	
			$mensaje .= "<br>";	

			$mensaje .= "Codigo Interno: <b>".$this->IngId."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Fecha Ingreso: <b>".$this->IngFecha."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "A la Orden de: <b>";	
			$mensaje .= "".$this->PerNombre." ".$this->PerApellidoPaterno." ".$this->PerApellidoMaterno."";	
			$mensaje .= "".$this->PrvNombre." ".$this->PrvApellidoPaterno." ".$this->PrvApellidoMaterno."";	
			$mensaje .= "".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."";	
			$mensaje .= "</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Numero de Cheque: <b>".$this->IngNumeroCheque."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Cuenta Afecta: <b>".$this->BanNombre."/".$this->CueNumero."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Moneda: <b>".$this->MonNombre."</b>";	
			$mensaje .= "<br>";	
			
			if($this->MonId<>$EmpresaMonedaId ){
				$this->IngMonto = round($this->IngMonto / $this->IngTipoCambio,2);
			}		

			$mensaje .= "Monto: <b>".number_format($this->IngMonto,2)."</b>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
			$mensaje .= "Concepto: <b>".$this->IngConcepto."</b>";	
			$mensaje .= "<br>";	

					
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			
					
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			//echo $mensaje;
			$InsCorreo = new ClsCorreo();	
			//$InsCorreo->MtdEnviarCorreo($oIngtinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO INGEMBOLSO: ".$this->IngId." - ".$this->IngNumeroCheque." - ".$this->IngFecha,$mensaje);
			$InsCorreo->MtdEnviarCorreo($oIngtinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: REGISTRO INGEMBOLSO: ".$this->IngNumeroCheque." - ".$this->IngFecha,$mensaje);
			
		}
		
		
		
		private function MtdAuditarIngreso($oAccion,$oIngcripcion,$oDatos){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->IngId;
			$InsAuditoria->AudCodigoExtra = "";
			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = $this->SucId;
			$InsAuditoria->AudAccion = $oAccion;
			$InsAuditoria->AudIngcripcion = $oIngcripcion;
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