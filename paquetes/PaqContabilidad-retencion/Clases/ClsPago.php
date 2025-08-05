<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsPago
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsPago {

    public $PagId;
	public $CliId;
	
	
	public $FpaId;
	public $AreId;
	public $CueId;
	public $TarId;
		
    public $PagFecha;
    public $MonId;


	
	public $PagTipoCambio;
	public $PagObservacion;
	public $PagConcepto;
	
	public $PagNumeroTransaccion;
	public $PagFechaTransaccion;
	public $PagNumeroRecibo;
	public $PagMonto;
	public $PagTipo;
	public $PagFoto1;
	public $PagFoto2;
	
	public $PagUtilizado;	
	
	public $PagReferencia;
	public $PagEstado;	
    public $PagTiempoCreacion;
    public $PagTiempoModificacion;
    public $PagEliminado;

	public $CliNumeroDocumento;
	public $TdoId;
	
	public $CliNombre;
	public $CliApellidoPaterno;
	public $CliApellidoMaterno;
	
	public $TdoNombre;
	
	
	public $MonNombre;
	
		
	public $PagoComprobante;
	
	
	
	public $InsMysql;

    public function __construct(){
		$this->InsMysql = new ClsMysql();
    }
	
	public function __destruct(){

	}
		
	public function MtdGenerarPagoId() {

		$sql = 'SELECT	
		suc.SucSiglas,
		MAX(CONVERT(SUBSTR(PagId,5),unsigned)) AS "MAXIMO"
		FROM tblpagpago pag
			LEFT JOIN tblsucsucursal suc
			ON pag.SucId = suc.SucId
			
		WHERE pag.SucId = "'.$this->SucId.'"
		';
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->PagId = "PAG-10000-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);
		
		}else{
			$fila['MAXIMO']++;
			$this->PagId = "PAG-".$fila['MAXIMO']."-".(empty($fila['SIGLA'])?$_SESSION['SesionSucursalSiglas']:$fila['SIGLA']);				
		}

	}
	
	
		public function MtdGenerarPagoNumeroRecibo() {

		$sql = 'SELECT	
		MAX(PagNumeroRecibo) AS "MAXIMO"
		FROM tblpagpago';
		
		//MAX(CONVERT(SUBSTR(PagNumeroRecibo,5),unsigned)) AS "MAXIMO"
		
		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
		
		if(empty($fila['MAXIMO'])){			
			$this->PagNumeroRecibo = "000001";
		}else{
			$fila['MAXIMO']++;
			$this->PagNumeroRecibo = str_pad($fila['MAXIMO'], 6, "0", STR_PAD_LEFT);;					
		}

	}
		
    public function MtdObtenerPago($oCompleto=true){

        $sql = 'SELECT 
        pag.PagId,
		pag.SucId,
		
		pag.CliId,

		pag.FpaId,
		pag.AreId,
		pag.CueId,
		pag.TarId,
		pag.BanId,
		pag.PerId,
		
		DATE_FORMAT(pag.PagFecha, "%d/%m/%Y") AS "NPagFecha",
		pag.MonId,
		pag.PagTipoCambio,
		pag.PagObservacion,
pag.PagObservacionCaja,
		pag.PagConcepto,
		
		pag.PagNumeroTransaccion,
		DATE_FORMAT(pag.PagFechaTransaccion, "%d/%m/%Y") AS "NPagFechaTransaccion",
		
		pag.PagNumeroRecibo,
		pag.PagCantidadLetras,
		
		pag.PagMonto,
		pag.PagTipo,
		pag.PagFoto1,
		pag.PagFoto2,
		
		pag.PagUtilizado,
		
		pag.PagReferencia,
		pag.PagEstado,	
		DATE_FORMAT(pag.PagTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPagTiempoCreacion",
        DATE_FORMAT(pag.PagTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPagTiempoModificacion",
		
		(
			SELECT
			(vdi.VdiId)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblvdiventadirecta vdi
				ON pac.VdiId = vdi.VdiId
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS VdiId,
		
		(
			SELECT
			SUM(vdi.VdiTotal)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblvdiventadirecta vdi
				ON pac.VdiId = vdi.VdiId
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS VdiTotal,
		
		(
			SELECT
			(vdi.VdiTipoCambio)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblvdiventadirecta vdi
				ON pac.VdiId = vdi.VdiId
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS VdiTipoCambio,
		
		

		
		(
			SELECT
			ovv.MonId
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblovvordenventavehiculo ovv
				ON pac.OvvId = ovv.OvvId
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS PagoMonId,


		(
			SELECT
			(ovv.OvvId)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblovvordenventavehiculo ovv
				ON pac.OvvId = ovv.OvvId
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS OvvId,
		
				
		(
			SELECT
			SUM(ovv.OvvTotal)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblovvordenventavehiculo ovv
				ON pac.OvvId = ovv.OvvId
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS OvvTotal,
		
		(
			SELECT
			(ovv.OvvTipoCambio)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblovvordenventavehiculo ovv
				ON pac.OvvId = ovv.OvvId
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS OvvTipoCambio,
		
		
		
		

		(
			SELECT
			SUM(fac.FacTotal)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblfacfactura fac
				ON ( pac.FacId = fac.FacId AND  pac.FtaId = fac.FtaId)
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS FacTotal,
		
		(
			SELECT
			(fac.FacTipoCambio)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblfacfactura fac
				ON ( pac.FacId = fac.FacId AND  pac.FtaId = fac.FtaId)
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS FacTipoCambio,
		
	
	



		(
			SELECT
			SUM(bol.BolTotal)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblbolboleta bol
				ON ( pac.BolId = bol.BolId AND  pac.BtaId = bol.BtaId)
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS BolTotal,
		
		(
			SELECT
			(bol.BolTipoCambio)
			FROM tblpacpagocomprobante pac
				LEFT JOIN tblbolboleta bol
				ON ( pac.BolId = bol.BolId AND  pac.BtaId = bol.BtaId)
			WHERE pac.PagId = pag.PagId
			ORDER BY pac.PacId DESC
			LIMIT 1
		) AS BolTipoCambio,
		
		
			
		
				
		cli.CliNumeroDocumento,
		cli.TdoId,
		
		cli.CliNombre,
		cli.CliApellidoPaterno,
		cli.CliApellidoMaterno,
		
		tdo.TdoNombre,
		
		mon.MonNombre,
		mon.MonSimbolo,
		
		fpa.FpaNombre,
		ban.BanNombre,
		
		suc.SucNombre,
		suc.SucDepartamento
		
        FROM tblpagpago pag
			LEFT JOIN tblclicliente cli
			ON pag.CliId = cli.CliId
				LEFT JOIN tbltdotipodocumento tdo
				ON cli.TdoId = tdo.TdoId
					LEFT JOIN tblmonmoneda mon
					ON pag.MonId = mon.MonId
					
						
									LEFT JOIN tblfpaformapago fpa
									ON pag.FpaId = fpa.FpaId
									
									LEFT JOIN tblcuecuenta cue
									ON pag.CueId = cue.CueId
									LEFT JOIN tblbanbanco ban
									ON cue.BanId = ban.BanId
									LEFT JOIN tblsucsucursal suc
									ON pag.SucId = suc.SucId
					
        WHERE PagId = "'.$this->PagId.'";';
		
        $resultado = $this->InsMysql->MtdConsultar($sql);

		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){

        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->PagId = $fila['PagId'];
			$this->SucId = $fila['SucId'];
			$this->CliId = $fila['CliId'];
			
			
			$this->FpaId = $fila['FpaId'];
			$this->AreId = $fila['AreId'];
			$this->CueId = $fila['CueId'];
			$this->TarId = $fila['TarId'];
			$this->BanId = $fila['BanId'];
			$this->PerId = $fila['PerId'];

			$this->PagFecha = $fila['NPagFecha'];
			$this->MonId = $fila['MonId'];
			$this->PagTipoCambio = $fila['PagTipoCambio'];
			$this->PagObservacion = $fila['PagObservacion'];
			list($this->PagObservacion,$this->PagObservacionImpresa) = explode("###",$fila['PagObservacion']);
			$this->PagObservacionCaja = $fila['PagObservacionCaja'];
			$this->PagConcepto = $fila['PagConcepto'];
			$this->PagNumeroTransaccion = $fila['PagNumeroTransaccion'];
			$this->PagFechaTransaccion = $fila['NPagFechaTransaccion'];
			
			$this->PagNumeroRecibo = $fila['PagNumeroRecibo'];
			$this->PagCantidadLetras = $fila['PagCantidadLetras'];
			
			$this->PagMonto = $fila['PagMonto'];
			$this->PagTipo = $fila['PagTipo'];	
			
	
			$this->PagFoto1 = $fila['PagFoto1'];
			$this->PagFoto2 = $fila['PagFoto2'];
									
			$this->PagUtilizado = $fila['PagUtilizado'];	
			
			$this->PagReferencia = $fila['PagReferencia'];	
			$this->PagEstado = $fila['PagEstado'];
			$this->PagTiempoCreacion = $fila['NPagTiempoCreacion'];
			$this->PagTiempoModificacion = $fila['NPagTiempoModificacion'];
			
			$this->VdiId = $fila['VdiId'];
			$this->VdiTotal = $fila['VdiTotal'];
			$this->VdiTipoCambio = $fila['VdiTipoCambio'];
			
			$this->OvvId = $fila['OvvId'];
			$this->PagoMonId = $fila['PagoMonId'];
			$this->OvvTotal = $fila['OvvTotal'];
			$this->OvvTipoCambio = $fila['OvvTipoCambio'];
			

			$this->FacTotal = $fila['FacTotal'];
			$this->FacTipoCambio = $fila['FacTipoCambio'];
			
			$this->BolTotal = $fila['BolTotal'];
			$this->BolTipoCambio = $fila['BolTipoCambio'];		
			
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento'];
			$this->TdoId = $fila['TdoId'];
			
			$this->CliNombre = $fila['CliNombre'];
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno'];
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno'];
			
			$this->TdoNombre = $fila['TdoNombre'];
			
			$this->MonNombre = $fila['MonNombre'];
			$this->MonSimbolo = $fila['MonSimbolo'];
			
			$this->FpaNombre = $fila['FpaNombre'];
				$this->BanNombre = $fila['BanNombre'];
				
				$this->SucNombre = $fila['SucNombre'];
				$this->SucDepartamento = $fila['SucDepartamento'];

			if($oCompleto){

				$InsPagoComprobante = new ClsPagoComprobante();
				$ResPagoComprobante =  $InsPagoComprobante->MtdObtenerPagoComprobantes(NULL,NULL,"PacId","ASC",NULL,$this->PagId);
				$this->PagoComprobante = $ResPagoComprobante['Datos'];	

			}
				
				switch($this->PagEstado){
					case 1:
						$this->PagEstadoDescripcion = "Pendiente";
					break;
										
					case 3:
						$this->PagEstadoDescripcion = "Realizado";
					break;
					
					case 6:
						$this->PagEstadoDescripcion = "Anulado";
				
					break;
					
				}	
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

//MtdObtenerPagos
    public function MtdObtenerPagos($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'PagId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oVentaDirecta=NULL,$oPago=NULL,$oCondicionPago=NULL,$oMoneda=NULL,$oFactura=NULL,$oFacturaTalonario=NULL,$oBoleta=NULL,$oBoletaTalonario=NULL,$oArea=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oFecha="PagFecha",$oOrigen=NULL,$oFormaPago=NULL,$oSucursal=NULL,$oFichaIngresoId=NULL,$oPersonalId=NULL,$oTipo=NULL,$oFacturado=0,$oNoTieneComprobante=false) {
		
		
		
			
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
					pac.PacId
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblvdiventadirecta vdi
						ON pac.VdiId = vdi.VdiId
							LEFT JOIN tblclicliente cli
							ON vdi.CliId = cli.CliId
								LEFT JOIN tblovvordenventavehiculo ovv
								ON pac.OvvId = ovv.OvvId
									LEFT JOIN tblclicliente cli2
									ON ovv.CliId = cli2.CliId
							
					WHERE 
						pac.PagId = pag.PagId AND
						
						(
						cli.CliNombreCompleto LIKE "%'.$oFiltro.'%" OR
						cli.CliNombre LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoPaterno LIKE "%'.$oFiltro.'%" OR
						cli.CliApellidoMaterno LIKE "%'.$oFiltro.'%" OR
						cli.CliNumeroDocumento LIKE "%'.$oFiltro.'%" OR
						
						cli2.CliNombreCompleto LIKE "%'.$oFiltro.'%" OR
						cli2.CliNombre LIKE "%'.$oFiltro.'%" OR
						cli2.CliApellidoPaterno LIKE "%'.$oFiltro.'%" OR
						cli2.CliApellidoMaterno LIKE "%'.$oFiltro.'%" OR
						cli2.CliNumeroDocumento LIKE "%'.$oFiltro.'%" OR 
						pac.VdiId LIKE "%'.$oFiltro.'%" OR
						pac.OvvId LIKE "%'.$oFiltro.'%" 
						
						)
						
					) ';
					
					
				$filtrar .= '  ) ';



		}
		
		
		//if(!empty($oCampo) && !empty($oFiltro)){
//			$oFiltro = str_replace(" ","%",$oFiltro);
//			switch($oCondicion){
//				case "esigual":
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'"';	
//				break;
//
//				case "noesigual":
//					$filtrar = ' AND '.($oCampo).' <> "'.($oFiltro).'"';
//				break;
//				
//				case "comienza":
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//				break;
//				
//				case "termina":
//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'"';
//				break;
//				
//				case "contiene":
//					$filtrar = ' AND '.($oCampo).' LIKE "%'.($oFiltro).'%"';
//				break;
//				
//				case "nocontiene":
//					$filtrar = ' AND '.($oCampo).' NOT LIKE "%'.($oFiltro).'%"';
//				break;
//				
//				default:
//					$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//				break;
//				
//			}
//			
//			//$filtrar = ' AND '.($oCampo).' LIKE "'.($oFiltro).'%"';
//		}

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}
			
				
		/*if(!empty($oEstado)){
			$estado = ' AND pag.PagEstado = '.$oEstado;
		}	*/
		
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (pag.PagEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		
		
		
		if(!empty($oVentaDirecta)){
			
			$vdirecta = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.PagId = pag.PagId
				AND pac.VdIId = "'.$oVentaDirecta.'"
			
			)
			';
		}
		
		if(!empty($oPago)){
			
			$ovvehiculo = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.PagId = pag.PagId
				AND pac.OvvId = "'.$oPago.'"
			
			)
			';
		}	
		
	
			
		if(!empty($oMoneda)){
			$moneda = ' AND pag.MonId = "'.$oMoneda.'"';
		}	
		
	
		if(!empty($oFactura) and !empty($oFacturaTalonario)){
			
			$factura = '
			AND EXISTS(
				SELECT 
				pac.PacId
				FROM tblpacpagocomprobante pac
				WHERE pac.PagId = pag.PagId
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
				WHERE pac.PagId = pag.PagId
				AND pac.BolId = "'.$oBoleta.'"
				AND pac.BtaId = "'.$oBoletaTalonario.'"			
			)
			';

		}	
		
			
		if(!empty($oArea)){
			$area = ' AND pag.AreId = "'.$oArea.'"';
		}	
		
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pag.'.$oFecha.')>="'.$oFechaInicio.'" AND DATE(pag.'.$oFecha.')<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(pag.'.$oFecha.')>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(pag.'.$oFecha.')<="'.$oFechaFin.'"';		
			}			
		}

		if(!empty($oOrigen)){
			
			switch($oOrigen){
				
				case "REPUESTOS":
					
					$origen = ' AND EXISTS(					
					SELECT
					pac.VdiId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					AND pac.VdiId IS NOT NULL
					ORDER BY pac.VdiId DESC
					LIMIT 1					
					)';
					
				break;
				
				case "VEHICULOS":
				
					$origen = ' AND EXISTS(
						SELECT
						pac.OvvId
						FROM tblpacpagocomprobante pac
						WHERE pac.PagId = pag.PagId
						AND pac.OvvId IS NOT NULL
						ORDER BY pac.OvvId DESC
						LIMIT 1
					) ';
					
				break;
				
				default:
				
				break;
				
			}
			
		}	
		
		
		if(!empty($oFormaPago)){
			$fpago = ' AND pag.FpaId = "'.$oFormaPago.'"';
		}		


		if(!empty($oSucursal)){
			$sucursal = ' AND pag.SucId = "'.$oSucursal.'"';
		}
		
		if(!empty($oFichaIngresoId)){

			//$personal = ' AND pag.SucId = "'.$oSucursal.'"';
			
			$fingreso = ' AND 
			
					EXISTS(SELECT
					pac.VdiId
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblvdiventadirecta vdi
						ON pac.VdiId = vdi.VdiId
							LEFT JOIN tblfinfichaingreso fin
							ON vdi.FinId = fin.FinId
					WHERE pac.PagId = pag.PagId
						AND pac.VdiId IS NOT NULL
						AND vdi.FinId = "'.$oFichaIngresoId.'"
					ORDER BY pac.VdiId DESC
					LIMIT 1					
					)';
					
			
		}		
		
		if(!empty($oPersonalId)){

			//$personal = ' AND pag.SucId = "'.$oSucursal.'"';
			
			$personal = ' AND 
			
					EXISTS(SELECT
					pac.VdiId
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblvdiventadirecta vdi
						ON pac.VdiId = vdi.VdiId
							LEFT JOIN tblfinfichaingreso fin
							ON vdi.FinId = fin.FinId
					WHERE pac.PagId = pag.PagId
						AND pac.VdiId IS NOT NULL
						AND fin.PerId = "'.$oPersonalId.'"
					ORDER BY pac.VdiId DESC
					LIMIT 1					
					)';
					
			
		}		

		if(!empty($oTipo)){
			$tipo = ' AND pag.PagTipo = "'.$oTipo.'"';
		}
		
		if(!empty($oFacturado)){
			switch($oFacturado){
				case 1:
					$facturado = '
					
					AND 
					
					(
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblfacfactura fac
								LEFT JOIN tblfamfacturaalmacenmovimiento fam
								ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
									LEFT JOIN tblamoalmacenmovimiento amo
									ON fam.AmoId = amo.AmoId
										LEFT JOIN tblvdiventadirecta vdi
										ON amo.VdiId = vdi.VdiId
											LEFT JOIN tblpacpagocomprobante pac
											ON pac.VdiId = vdi.VdiId	
							WHERE pac.PagId = pag.PagId
							AND fac.FacEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
						AND
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblbolboleta bol
								LEFT JOIN tblbamboletaalmacenmovimiento bam
								ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
									LEFT JOIN tblamoalmacenmovimiento amo
									ON bam.AmoId = amo.AmoId
										LEFT JOIN tblvdiventadirecta vdi
										ON amo.VdiId = vdi.VdiId
											LEFT JOIN tblpacpagocomprobante pac
											ON pac.VdiId = vdi.VdiId	
							WHERE pac.PagId = pag.PagId
							AND bol.BolEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
												
					)';
					
				break;
				
				case 2:
				
				break;
			}
		}else{
			
		}
		
		
		if(($oNoTieneComprobante)){

			//$personal = ' AND pag.SucId = "'.$oSucursal.'"';
			
			$tcomprobante = '
					
					AND 
					
					(
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblfacfactura fac
							WHERE fac.PagId = pag.PagId
							AND fac.FacEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.FacId = fac.FacId AND ncr.FtaId = fac.FtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
						AND
						
						NOT EXISTS(
						
							SELECT 
							* 
							FROM tblbolboleta bol							
							WHERE bol.PagId = pag.PagId
							AND bol.BolEstado <> 6
	
									AND NOT EXISTS(
										SELECT 	
										ncr.NcrId
										FROM tblncrnotacredito ncr
										WHERE ncr.BolId = bol.BolId AND ncr.BtaId = bol.BtaId
										AND ncr.NcrEstado <> 6
										AND ncr.NcrMotivoCodigo<> "04"
										AND ncr.NcrMotivoCodigo<> "05"
										AND ncr.NcrMotivoCodigo<> "09"
										
									) 
									
							
						) 
						
												
					)';
					
			
		}		

		
			  $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				pag.PagId,
				pag.SucId,
				
				pag.FpaId,
				pag.AreId,
				pag.CueId,
				pag.TarId,
				pag.BanId,
				pag.PerId,
			
				DATE_FORMAT(pag.PagFecha, "%d/%m/%Y") AS "NPagFecha",
				pag.MonId,
				pag.PagTipoCambio,
				pag.PagObservacion,
pag.PagObservacionCaja,
				pag.PagConcepto,
				pag.PagNumeroTransaccion,
				DATE_FORMAT(pag.PagFechaTransaccion, "%d/%m/%Y") AS "NPagFechaTransaccion",
				pag.PagNumeroRecibo,
				 pag.PagCantidadLetras,
				 
				pag.PagMonto,
				pag.PagTipo,
				
				pag.PagFoto1,
				pag.PagFoto2,
				
				pag.PagUtilizado,
				
				pag.PagReferencia,
				pag.PagEstado,	
				DATE_FORMAT(pag.PagTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NPagTiempoCreacion",
                DATE_FORMAT(pag.PagTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NPagTiempoModificacion",
				
				cli.CliNumeroDocumento,
				cli.TdoId,
				
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				tdo.TdoNombre,
		
				(
					SELECT
					pac.VdiId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					ORDER BY pac.VdiId DESC
					LIMIT 1
				) AS VdiId,
				
				
				(
					SELECT
					pac.OvvId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					ORDER BY pac.OvvId DESC
					LIMIT 1
				) AS OvvId,
				
				
				(
					SELECT
					pac.FacId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					ORDER BY pac.FacId DESC
					LIMIT 1
				) AS FacId,
				
				(
					SELECT
					pac.FtaId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					ORDER BY pac.FtaId DESC
					LIMIT 1
				) AS FtaId,
				
				(
					SELECT
					fta.FtaNumero
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblftafacturatalonario fta
						ON pac.FtaId = fta.FtaId
					WHERE pac.PagId = pag.PagId
					ORDER BY fta.FtaNumero DESC
					LIMIT 1
				) AS FtaNumero,
				
				
				
				
				
				(
					SELECT
					pac.BolId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					ORDER BY pac.BolId DESC
					LIMIT 1
				) AS BolId,
				
				(
					SELECT
					pac.BtaId
					FROM tblpacpagocomprobante pac
					WHERE pac.PagId = pag.PagId
					ORDER BY pac.BtaId DESC
					LIMIT 1
				) AS BtaId,
				
				(
					SELECT
					bta.BtaNumero
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblbtaboletatalonario bta
						ON pac.BtaId = bta.BtaId
					WHERE pac.PagId = pag.PagId
					ORDER BY bta.BtaNumero DESC
					LIMIT 1
				) AS BtaNumero,
				
				
				(
					SELECT
					vdi.FinId
					FROM tblpacpagocomprobante pac
						LEFT JOIN tblvdiventadirecta vdi
						ON pac.VdiId = vdi.VdiId
					WHERE pac.PagId = pag.PagId
					ORDER BY pac.VdiId DESC
					LIMIT 1
				) AS FinId,
				
				mon.MonNombre,
				mon.MonSimbolo,
				
				cue.CueNumero,
				ban.BanNombre,
				fpa.FpaNombre,
				
				
				
(
				IFNULL(
					(
					
					SELECT
					CONCAT(fta.FtaNumero,"-",fac.FacId)
					FROM tblfacfactura fac
						LEFT JOIN tblftafacturatalonario fta
						ON fac.FtaId = fta.FtaId
							LEFT JOIN tblfamfacturaalmacenmovimiento fam
							ON fam.FacId = fac.FacId AND fam.FtaId = fac.FtaId
								LEFT JOIN tblamoalmacenmovimiento amo
								ON fam.AmoId = amo.AmoId
									LEFT JOIN tblpacpagocomprobante pac
									ON amo.VdiId = pac.VdiId
					WHERE pac.PagId = pag.PagId

					AND fac.FacEstado <> 6

					LIMIT 1
					),IFNULL(
						(
							SELECT
							CONCAT(bta.BtaNumero,"-",bol.BolId)
							FROM tblbolboleta bol
							
								LEFT JOIN tblbtaboletatalonario bta
								ON bol.BtaId = bta.BtaId
								
									LEFT JOIN tblbamboletaalmacenmovimiento bam
									ON bam.BolId = bol.BolId AND bam.BtaId = bol.BtaId
									
										LEFT JOIN tblamoalmacenmovimiento amo
										ON bam.AmoId = amo.AmoId

											LEFT JOIN tblpacpagocomprobante pac
											ON amo.VdiId = pac.VdiId
												
							WHERE pac.PagId = pag.PagId 
							AND bol.BolEstado <> 6
						LIMIT 1
						),"-")
				)
				
				) AS PagComprobante

				FROM tblpagpago pag

					LEFT JOIN tblclicliente cli
					ON pag.CliId = cli.CliId
						LEFT JOIN tbltdotipodocumento tdo
						ON cli.TdoId = tdo.TdoId
				
							LEFT JOIN tblcuecuenta cue
							ON pag.CueId = cue.CueId
								
								LEFT JOIN tblbanbanco ban
								ON cue.BanId = ban.BanId
									
									LEFT JOIN tblfpaformapago fpa
									ON pag.FpaId = fpa.FpaId
										
										
						LEFT JOIN tblmonmoneda mon
						ON pag.MonId = mon.MonId
						
				WHERE 1 = 1 '.$filtrar.$tipo.$estado.$tipo.$facturado.$tcomprobante .$sucursal.$fingreso.$personal.$vdirecta.$ovvehiculo.$cpago.$moneda.$factura.$boleta.$area.$fecha.$origen.$fpago.$orden.$paginacion;
								

											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsPago = get_class($this);
				
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$Pago = new $InsPago();				
					
                    $Pago->PagId = $fila['PagId'];
					$Pago->SucId = $fila['SucId'];
					
					$Pago->FpaId = $fila['FpaId'];
					$Pago->AreId = $fila['AreId'];
					$Pago->CueId = $fila['CueId'];
					$Pago->TarId = $fila['TarId'];
					$Pago->BanId = $fila['BanId'];
					$Pago->PerId = $fila['PerId'];
					
                    $Pago->PagFecha= $fila['NPagFecha'];
					$Pago->MonId= $fila['MonId'];
					$Pago->PagTipoCambio= $fila['PagTipoCambio'];
					$Pago->PagObservacion = $fila['PagObservacion'];
					$Pago->PagObservacionCaja = $fila['PagObservacionCaja'];
					
					$Pago->PagConcepto = $fila['PagConcepto'];
					$Pago->PagNumeroTransaccion = $fila['PagNumeroTransaccion'];
					$Pago->PagFechaTransaccion = $fila['NPagFechaTransaccion'];
					$Pago->PagNumeroRecibo = $fila['PagNumeroRecibo'];
					$Pago->PagCantidadLetras = $fila['PagCantidadLetras'];
					
					$Pago->PagMonto = $fila['PagMonto'];
					$Pago->PagTipo = $fila['PagTipo'];
					
					$Pago->PagFoto1 = $fila['PagFoto1'];
					$Pago->PagFoto2 = $fila['PagFoto2'];
					
					$Pago->PagUtilizado = $fila['PagUtilizado'];
					
					
					$Pago->PagReferencia = $fila['PagReferencia'];
					$Pago->PagEstado = $fila['PagEstado'];
                    $Pago->PagTiempoCreacion = $fila['NPagTiempoCreacion'];
					$Pago->PagTiempoModificacion = $fila['NPagTiempoModificacion'];
					
						
					$Pago->CliNumeroDocumento = $fila['CliNumeroDocumento'];
					$Pago->TdoId = $fila['TdoId'];
					
					$Pago->CliNombre = $fila['CliNombre'];
					$Pago->CliApellidoPaterno = $fila['CliApellidoPaterno'];
					$Pago->CliApellidoMaterno = $fila['CliApellidoMaterno'];
					$Pago->TdoNombre = $fila['TdoNombre'];
					
					$Pago->VdiId = $fila['VdiId'];
					$Pago->OvvId = $fila['OvvId'];
					
					$Pago->FacId = $fila['FacId'];
					$Pago->FtaId = $fila['FtaId'];
					$Pago->FtaNumero = $fila['FtaNumero'];
					
						$Pago->BolId = $fila['BolId'];
					$Pago->BtaId = $fila['BtaId'];
					$Pago->BtaNumero = $fila['BtaNumero'];
					
					$Pago->FinId = $fila['FinId'];
					
					$Pago->MonNombre = $fila['MonNombre'];
					$Pago->MonSimbolo = $fila['MonSimbolo'];
					
					$Pago->CueNumero = $fila['CueNumero'];
					$Pago->BanNombre = $fila['BanNombre'];
					$Pago->FpaNombre = $fila['FpaNombre'];
					$Pago->PagComprobante = $fila['PagComprobante'];
					
					switch($Pago->PagEstado){
						case 1:
							$Pago->PagEstadoDescripcion = "Pendiente";
						break;
											
						case 3:
							$Pago->PagEstadoDescripcion = "Realizado";
						break;
						
						case 6:
							$Pago->PagEstadoDescripcion = "Anulado";
					
						break;
						
					}	
					/*
					switch($Pago->PagEstado){
						case 1:
							$Pago->PagEstadoDescripcion = "Orden de Cobro";
						break;
											
						case 3:
							$Pago->PagEstadoDescripcion = "Abono";
						break;
						
						case 6:
							$Pago->PagEstadoDescripcion = "Anulado";
					
						break;
						
					}	*/
				
                    $Pago->InsMysql = NULL;                    
					$Respuesta['Datos'][]= $Pago;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
			
	//Accion eliminar	 
	
	public function MtdActualizarUtilizadoPago($oElementos,$oUtilizado) {
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PagId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PagId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'UPDATE tblpagpago SET PagUtilizado = '.$oUtilizado.' WHERE '.$eliminar;
			
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
	
	
		//Accion eliminar	 
	
	public function MtdEliminarPago($oElementos) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$elementos = explode("#",$oElementos);
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					if($i==count($elementos)){						
						$eliminar .= '  (PagId = "'.($elemento).'")';	
					}else{
						$eliminar .= '  (PagId = "'.($elemento).'")  OR';	
					}	
				}
			$i++;
	
			}

			$sql = 'DELETE FROM  tblpagpago WHERE '.$eliminar;
			
			$error = false;

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 		
			
			if($error) {
				
				$this->InsMysql->MtdTransaccionDeshacer();							
				return false;
			} else {		
			
				$this->InsMysql->MtdTransaccionHacer();	
				
				$this->MtdAuditarPago(3,"Se elimino el Pago",$this);	
						
				return true;
			}		
			
								
	}	
	
	public function MtdRegistrarPago() {
	
	
		$this->InsMysql->MtdTransaccionIniciar();
	
		$error = false;
	
			$this->MtdGenerarPagoId();
		
			$sql = 'INSERT INTO tblpagpago (
			PagId,
			SucId,
			
			CliId,
			
			FpaId,
			AreId,
			CueId,
			TarId,
			BanId,
			PerId,
			
			PagNumeroTransaccion,
			PagFechaTransaccion,
			PagNumeroRecibo,
			PagCantidadLetras,
			
			
			PagFecha,
			MonId,
			PagTipoCambio,
			PagObservacion,
			PagObservacionCaja,
			
			PagConcepto,
			
			PagMonto,
			PagTipo,
			PagFoto1,
			PagFoto2,
			
			PagUtilizado,
			
			PagReferencia,
			PagEstado,
			PagTiempoCreacion,
			PagTiempoModificacion
			) 
			VALUES (
			"'.($this->PagId).'", 
			"'.($this->SucId).'", 
			
			"'.($this->CliId).'", 

			'.(empty($this->FpaId)?'NULL, ':'"'.$this->FpaId.'",').'	
			'.(empty($this->AreId)?'NULL, ':'"'.$this->AreId.'",').'					
			
			'.(empty($this->CueId)?'NULL, ':'"'.$this->CueId.'",').'
			'.(empty($this->TarId)?'NULL, ':'"'.$this->TarId.'",').'
			'.(empty($this->BanId)?'NULL, ':'"'.$this->BanId.'",').'
			'.(empty($this->PerId)?'NULL, ':'"'.$this->PerId.'",').'
			
			"'.($this->PagNumeroTransaccion).'",
			'.(empty($this->PagFechaTransaccion)?'NULL, ':'"'.$this->PagFechaTransaccion.'",').'
			"'.($this->PagNumeroRecibo).'",
			"'.($this->PagCantidadLetras).'",
			
			"'.($this->PagFecha).'",
			"'.($this->MonId).'",
			'.(empty($this->PagTipoCambio)?'NULL, ':''.$this->PagTipoCambio.',').'
			"'.($this->PagObservacion).'",
			"'.($this->PagObservacionCaja).'",
			
			
			"'.($this->PagConcepto).'", 
			'.($this->PagMonto).',
			"'.($this->PagTipo).'",
			
			"'.($this->PagFoto1).'",
			"'.($this->PagFoto2).'",
			 
			'.($this->PagUtilizado).',
			
			"'.($this->PagReferencia).'",			
			'.($this->PagEstado).', 
			"'.($this->PagTiempoCreacion).'", 
			"'.($this->PagTiempoModificacion).'");';					

			

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			
			if(!$resultado) {						
				$error = true;
			} 	

//deb($this->PagoComprobante);

//deb($error);
			if(!$error){			
			//echo "aaaa";
				if (!empty($this->PagoComprobante)){		
						
						//echo "bbbb";
				$validar = 0;		
				$InsPagoComprobante = new ClsPagoComprobante();	
											
					foreach ($this->PagoComprobante as $DatPagoComprobante){
						//echo "ccc";						
						$DatPagoComprobante->PagId = $this->PagId;
						$DatPagoComprobante->OvvId = $DatPagoComprobante->OvvId;
						$DatPagoComprobante->VdiId = $DatPagoComprobante->VdiId;

						$InsPagoComprobante->FacId = $DatPagoComprobante->FacId;
						$InsPagoComprobante->FtaId = $DatPagoComprobante->FtaId;

						$InsPagoComprobante->BolId = $DatPagoComprobante->BolId;
						$InsPagoComprobante->BtaId = $DatPagoComprobante->BtaId;
						
						$InsPagoComprobante->FexId = $DatPagoComprobante->FexId;
						$InsPagoComprobante->FetId = $DatPagoComprobante->FetId;

						$DatPagoComprobante->OccEstado = $DatPagoComprobante->OccEstado;							
						$DatPagoComprobante->OccTiempoCreacion = $DatPagoComprobante->OccTiempoCreacion;
						$DatPagoComprobante->OccTiempoModificacion = $DatPagoComprobante->OccTiempoModificacion;						
						$DatPagoComprobante->OccEliminado = $DatPagoComprobante->OccEliminado;

						if($DatPagoComprobante->MtdRegistrarPagoComprobante()){
							$validar++;	
						}else{
							$Resultado.='#ERR_PAG_201';
							$Resultado.='#Item Numero: '.($validar+1);
						}
					}					

					if(count($this->PagoComprobante) <> $validar ){
						$error = true;
					}					
		
				}				
			}
			
			
		
		if($error) {	
			$this->InsMysql->MtdTransaccionDeshacer();			
			return false;
		} else {				
		
			
			$this->InsMysql->MtdTransaccionHacer();
			
			$this->MtdAuditarPago(1,"Se registro el Pago",$this);	
			return true;
		}		
				
			
	}
	
	
	
	
	//Accion eliminar	 
	public function MtdActualizarEstadoPago($oElementos,$oEstado) {

		$error = false;

		$this->InsMysql->MtdTransaccionIniciar();

		$elementos = explode("#",$oElementos);

		$InsPago = new ClsPago();

		
			$i=1;
			foreach($elementos as $elemento){

				if(!empty($elemento)){
			
					$sql = 'UPDATE tblpagpago SET PagEstado = '.$oEstado.' WHERE PagId = "'.$elemento.'"';
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
	
	
	
	
	public function MtdEditarPago() {
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$sql = 'UPDATE tblpagpago SET 
		CliId = "'.($this->CliId).'",
		
		'.(empty($this->FpaId)?'FpaId = NULL, ':'FpaId = "'.$this->FpaId.'",').'
		'.(empty($this->AreId)?'AreId = NULL, ':'AreId = "'.$this->AreId.'",').'
		
		
		'.(empty($this->CueId)?'CueId = NULL, ':'CueId = "'.$this->CueId.'",').'
		'.(empty($this->TarId)?'TarId = NULL, ':'TarId = "'.$this->TarId.'",').'
		'.(empty($this->BanId)?'BanId = NULL, ':'BanId = "'.$this->BanId.'",').'
		'.(empty($this->PerId)?'PerId = NULL, ':'PerId = "'.$this->PerId.'",').'
		
		PagNumeroTransaccion = "'.$this->PagNumeroTransaccion.'",
		'.(empty($this->PagFechaTransaccion)?'PagFechaTransaccion = NULL, ':'PagFechaTransaccion = "'.$this->PagFechaTransaccion.'",').'
		PagNumeroRecibo = "'.$this->PagNumeroRecibo.'",
		PagCantidadLetras = "'.$this->PagCantidadLetras.'",
		
		PagFecha = "'.($this->PagFecha).'",
		MonId = "'.($this->MonId).'",
		'.(empty($this->PagTipoCambio)?'PagTipoCambio = NULL, ':'PagTipoCambio = '.$this->PagTipoCambio.',').'
		PagObservacion = "'.($this->PagObservacion).'",
		PagObservacionCaja = "'.($this->PagObservacionCaja).'",
		
		
		PagConcepto = "'.($this->PagConcepto).'",

		PagMonto = '.($this->PagMonto).',
		PagTipo = "'.($this->PagTipo).'",
		
		PagFoto1 = "'.($this->PagFoto1).'",
		PagFoto2 = "'.($this->PagFoto2).'",
		
		PagReferencia = "'.($this->PagReferencia).'",
		PagEstado = '.($this->PagEstado).',
		PagTiempoModificacion = "'.($this->PagTiempoModificacion).'"
		WHERE PagId = "'.($this->PagId).'";';
			
		$error = false;
		
		$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
	
		if(!$resultado) {						
		  $error = true;
		} 	

		if(!$error){

				if (!empty($this->PagoComprobante)){		
						
					$validar = 0;				
					$InsPagoComprobante = new ClsPagoComprobante();

					foreach ($this->PagoComprobante as $DatPagoComprobante){

						$InsPagoComprobante->PacId = $DatPagoComprobante->PacId;
						$InsPagoComprobante->PagId = $this->PagId;
						$InsPagoComprobante->OvvId = $DatPagoComprobante->OvvId;
						$InsPagoComprobante->VdiId = $DatPagoComprobante->VdiId;
						
						$InsPagoComprobante->FacId = $DatPagoComprobante->FacId;
						$InsPagoComprobante->FtaId = $DatPagoComprobante->FtaId;
						
						$InsPagoComprobante->BolId = $DatPagoComprobante->BolId;
						$InsPagoComprobante->BtaId = $DatPagoComprobante->BtaId;
						
						$InsPagoComprobante->FexId = $DatPagoComprobante->FexId;
						$InsPagoComprobante->FetId = $DatPagoComprobante->FetId;
						
						$InsPagoComprobante->OccEstado = $DatPagoComprobante->OccEstado;
						$InsPagoComprobante->OccTiempoCreacion = $DatPagoComprobante->OccTiempoCreacion;
						$InsPagoComprobante->OccTiempoModificacion = $DatPagoComprobante->OccTiempoModificacion;
						$InsPagoComprobante->OccEliminado = $DatPagoComprobante->OccEliminado;
						
						if(empty($InsPagoComprobante->PacId)){
							if($InsPagoComprobante->OccEliminado<>2){
								if($InsPagoComprobante->MtdRegistrarPagoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PAG_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;
							}
						}else{						
							if($InsPagoComprobante->OccEliminado==2){
								if($InsPagoComprobante->MtdEliminarPagoPlanchadoPintado($InsPagoComprobante->PacId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_PAG_203';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								if($InsPagoComprobante->MtdEditarPagoPlanchadoPintado()){
									$validar++;	
								}else{
									$Resultado.='#ERR_PAG_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					if(count($this->PagoComprobante) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
			

			
			if($error) {	
			
				$this->InsMysql->MtdTransaccionDeshacer();								
				return false;
			} else {		
			
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarPago(2,"Se edito el Pago",$this);				
				return true;
			}						
				
		}	
		
		
		
		public function MtdEditarPagoDato($oCampo,$oDato,$oId) {

			$sql = 'UPDATE tblpagpago SET 
			'.$oCampo.' = "'.($oDato).'",
			PagTiempoModificacion = NOW()
			WHERE PagId = "'.($oId).'";';
			
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
		
			
		private function MtdAuditarPago($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->PagId;
			$InsAuditoria->AudCodigoExtra = NULL;
			$InsAuditoria->UsuId = $this->UsuId;
			$InsAuditoria->SucId = NULL;
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
		
		

	function FncNotificarOrdenCobroVentaDirecta($oVentaDirectaId,$oPago,$oUsuarioId,$oUsuario,$oDescripcionAdicional=NULL){
	
		$InsVentaDirecta = new ClsVentaDirecta();
	
		$InsNotificacion = new ClsNotificacion();
		$InsNotificacion->UsuId = NULL;
		$InsNotificacion->UsuIdOrigen = $oUsuarioId;
		$InsNotificacion->NfnUsuario = $oUsuario;
									
		$InsNotificacion->NfnModulo = "Pago";
		$InsNotificacion->NfnFormulario = "Monitoreo";
		$InsNotificacion->NfnDescripcion = "<b>".$oUsuario."</b> te ha enviado una orden de cobro. - ".$oDescripcionAdicional;
		//$InsNotificacion->NfnEnlace = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."/sistema/principal.phpMod=Pago&Form=Monitoreo&Area=ARE-10000&Moneda=MON-10000&Origen=REPUESTOS";
		//$InsNotificacion->NfnEnlace = $_SESSION['SesionUsuario']"principal.phpMod=Pago&Form=Monitoreo&Area=ARE-10000&Moneda=MON-10000&Origen=REPUESTOS";
		$InsNotificacion->NfnEnlace = "principal.php?Mod=Pago&Form=AtenderOrdenCobro&Id=".$oPago."&VdiId=".$oVentaDirectaId."&Leido=1";
		$InsNotificacion->NfnEnlaceNombre = "Mostrar";
		
		$InsNotificacion->NfnTipo = 1;
		$InsNotificacion->NfnEstado = 1;
		$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
		$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");
		
		$InsNotificacion->MtdRegistrarNotificacion();
								
	}
}
?>