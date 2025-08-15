<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsComprobanteRetencion
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsComprobanteRetencion {

    public $CrnId;
	public $CrtId;
    public $UsuId;	
	public $CliId;			
	public $CrnFechaEmision;
	public $CrnDireccion;	
	public $CrnTotalBruto;	
	public $CrnTotalRetenido;
	public $CrnTotalPagar;
	public $CrnObservacion;
	public $CrnObservacionImpresa;	
	public $MonId;
	public $CrnTipoCambio;
	public $CrnCancelado;
	public $CrnTipo;
	public $CrnCierre;
	
	
	public $CrnSunatRespuestaTicket;
	public $CrnSunatRespuestaTicketEstado;
	public $CrnSunatRespuestaObservacion;
	public $CrnSunatRespuestaEnvioTicket;
	public $CrnSunatRespuestaEnvioTicketEstado;
	public $CrnSunatRespuestaEnvioFecha;
	public $CrnSunatRespuestaEnvioHora;
	public $CrnSunatRespuestaEnvioCodigo;
	public $CrnSunatRespuestaEnvioContenido;
	
	public $CrnSunatRespuestaEnvioRespuesta;
	public $CrnSunatRespuestaBajaTicket;
	public $CrnSunatRespuestaBajaTicketEstado;
	public $CrnSunatRespuestaBajaFecha;
	public $CrnSunatRespuestaBajaHora;
	public $CrnSunatRespuestaBajaCodigo;
	public $CrnSunatRespuestaBajaContenido;
	public $CrnSunatRespuestaBajaId;
	public $CrnSunatRespuestaConsultaCodigo;
	public $CrnSunatRespuestaConsultaContenido;	
	public $CrnSunatRespuestaConsultaFecha;
	public $CrnSunatRespuestaConsultaHora;
	public $CrnSunatRespuestaEnvioTiempoCreacion;
	public $CrnSunatRespuestaConsultaTiempoCreacion;
	public $CrnSunatRespuestaBajaTiempoCreacion;	
	public $CrnSunatRespuestaEnvioSignatureValue;
	public $CrnSunatRespuestaEnvioDigestValue;
	public $CrnSunatUltimaAccion;
	public $CrnSunatUltimaRespuesta;
		
    public $CrnTiempoCreacion;
    public $CrnTiempoModificacion;
    public $CrnEliminado;
	
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

	public function MtdGenerarComprobanteRetencionId() {

		$sql = 'SELECT	
		MAX(SUBSTR(crn.CrnId,1)) AS "MAXIMO",
		
	
		crt.CrtInicio
		FROM tblcrncomprobanteretencion crn
		LEFT JOIN tblcrtcomprobanteretenciontalonario crt
		ON crn.CrtId = crt.CrtId
		WHERE crt.CrtId = "'.$this->CrtId.'"';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){	
			if(empty($fila['CrtInicio'])){
				$this->CrnId = "0000001";
			}else{
				$this->CrnId = str_pad($fila['CrtInicio'], 6, "0", STR_PAD_LEFT);
			}
		}else{
			$fila['MAXIMO']++;
			$this->CrnId = str_pad($fila['MAXIMO'], 6, "0", STR_PAD_LEFT);	
		}

	}
		
//
//	public function MtdGenerarComprobanteRetencionBajaId() {
//
//		$sql = 'SELECT	
//		MAX(CONVERT(crn.CrnSunatRespuestaBajaId,unsigned)) AS "MAXIMO"
//		FROM tblcrncomprobanteretencion crn ';			
//
//		$resultado = $this->InsMysql->MtdConsultar($sql);                       
//		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//		
//		if(empty($fila['MAXIMO'])){	
//			$this->CrnSunatRespuestaBajaId = "1";			
//		}else{
//			$fila['MAXIMO']++;
//			$this->CrnSunatRespuestaBajaId = ($fila['MAXIMO']);	
//		}
//			
//	}
//
//	public function MtdVerificarExisteComprobanteRetencion($oId,$oTalonario){
//		
//		$Existe = false;
//		
//		$sql = 'SELECT 
//		crn.CrnId,
//		crn.CrtId
//		FROM tblcrncomprobanteretencion crn
//		WHERE crn.CrnId = "'.$oId.'" 
//		AND crn.CrtId= "'.$oTalonario.'";';
//			
//        $resultado = $this->InsMysql->MtdConsultar($sql);
//		
//		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
//		
//			$Existe = true;
//			
//		}
//		
//		return $Existe;
//
//    }



    public function MtdObtenerComprobanteRetencion($oCompleto=true){

				 $sql = 'SELECT 
				crn.CrnId,
				crn.CrtId,
				crn.UsuId,
				crn.CliId,
				
				DATE_FORMAT(crn.CrnFechaEmision, "%d/%m/%Y") AS "NCrnFechaEmision",
				crn.CrnDireccion,
				crn.CrnTotalBruto,
				crn.CrnTotalRetenido,
				crn.CrnTotalPagar,
				
				crn.CrnObservacion,
				crn.CrnObservacionImpresa,
				
				crn.MonId,
				crn.CrnTipoCambio,
	
				crn.CrnCancelado,
				crn.CrnTipo,
				crn.CrnCierre,	
				crn.CrnEstado,	
			
				crn.CrnSunatRespuestaTicket,
				crn.CrnSunatRespuestaTicketEstado,
				crn.CrnSunatRespuestaObservacion,
				
				crn.CrnSunatRespuestaEnvioTicket,
				crn.CrnSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(crn.CrnSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NCrnSunatRespuestaEnvioFecha",
				crn.CrnSunatRespuestaEnvioHora,
				crn.CrnSunatRespuestaEnvioCodigo,
				crn.CrnSunatRespuestaEnvioContenido,
				
				crn.CrnSunatRespuestaBajaTicket,
				crn.CrnSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(crn.CrnSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NCrnSunatRespuestaBajaFecha",
				crn.CrnSunatRespuestaBajaHora,
				crn.CrnSunatRespuestaBajaCodigo,
				crn.CrnSunatRespuestaBajaContenido,
				crn.CrnSunatRespuestaBajaId,
				
				crn.CrnSunatRespuestaConsultaCodigo,
				crn.CrnSunatRespuestaConsultaContenido,
				DATE_FORMAT(crn.CrnSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NCrnSunatRespuestaConsultaFecha",
				crn.CrnSunatRespuestaConsultaHora,
				
				DATE_FORMAT(crn.CrnSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(crn.CrnSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(crn.CrnSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnSunatRespuestaBajaTiempoCreacion",
				
				crn.CrnSunatUltimaAccion,
				crn.CrnSunatUltimaRespuesta,
				
				DATE_FORMAT(crn.CrnTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnTiempoCreacion",
                DATE_FORMAT(crn.CrnTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCrnTiempoModificacion",

				crn.CrnSunatRespuestaEnvioDigestValue,
				crn.CrnSunatRespuestaEnvioSignatureValue,

				crt.CrtNumero,
				
				mon.MonSimbolo,
				mon.MonNombre,
				mon.MonSigla,
				
				tdo.TdoCodigo,
				cli.CliNombre,
				cli.CliNombreCompleto,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.TdoId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
				
				cli.CliProvincia,
				cli.CliDistrito,
				cli.CliDepartamento
				
				FROM tblcrncomprobanteretencion crn
					LEFT JOIN tblcrtcomprobanteretenciontalonario crt
					ON crn.CrtId = crt.CrtId
								LEFT JOIN tblmonmoneda mon
								ON crn.MonId = mon.MonId
									LEFT JOIN tblclicliente cli
									ON crn.CliId = cli.CliId
										LEFT JOIN tbltdotipodocumento tdo
										ON cli.TdoId = tdo.TdoId
											
				WHERE crn.CrnId = "'.$this->CrnId.'" AND crn.CrtId= "'.$this->CrtId.'";';
		

        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {

			$this->CrnId = $fila['CrnId'];
			$this->CrtId = $fila['CrtId'];
            $this->UsuId = $fila['UsuId'];
			$this->CliId = $fila['CliId'];
			$this->CrnFechaEmision = $fila['NCrnFechaEmision'];
			$this->CrnDireccion = $fila['CrnDireccion']; 
			$this->CrnTotalBruto = ($fila['CrnTotalBruto']); 
			$this->CrnTotalRetenido = $fila['CrnTotalRetenido']; 
			$this->CrnTotalPagar = $fila['CrnTotalPagar']; 
			
			$this->CrnObservacion = $fila['CrnObservacion']; 
			$this->CrnObservacionImpresa = $fila['CrnObservacionImpresa']; 
			
			$this->MonId = $fila['MonId'];
			$this->CrnTipoCambio = $fila['CrnTipoCambio'];

			$this->CrnCancelado = $fila['CrnCancelado'];
			$this->CrnTipo = $fila['CrnTipo'];
			$this->CrnCierre = $fila['CrnCierre']; 
			
			
			$this->CrnSunatRespuestaTicket = $fila['CrnSunatRespuestaTicket']; 	
			$this->CrnSunatRespuestaTicketEstado = $fila['CrnSunatRespuestaTicketEstado']; 			
			$this->CrnSunatRespuestaObservacion = $fila['CrnSunatRespuestaObservacion']; 	
			
			$this->CrnSunatRespuestaEnvioTicket = $fila['CrnSunatRespuestaEnvioTicket']; 	
			$this->CrnSunatRespuestaEnvioTicketEstado = $fila['CrnSunatRespuestaEnvioTicketEstado']; 	
			$this->CrnSunatRespuestaEnvioFecha = $fila['NCrnSunatRespuestaEnvioFecha']; 	
			$this->CrnSunatRespuestaEnvioHora = $fila['CrnSunatRespuestaEnvioHora']; 	
			$this->CrnSunatRespuestaEnvioCodigo = $fila['CrnSunatRespuestaEnvioCodigo']; 	
			$this->CrnSunatRespuestaEnvioContenido = $fila['CrnSunatRespuestaEnvioContenido']; 	
			
			$this->CrnSunatRespuestaBajaTicket = $fila['CrnSunatRespuestaBajaTicket']; 	
			$this->CrnSunatRespuestaBajaTicketEstado = $fila['CrnSunatRespuestaBajaTicketEstado']; 				
			$this->CrnSunatRespuestaBajaFecha = $fila['NCrnSunatRespuestaBajaFecha']; 	
			$this->CrnSunatRespuestaBajaHora = $fila['CrnSunatRespuestaBajaHora']; 				
			$this->CrnSunatRespuestaBajaCodigo = $fila['CrnSunatRespuestaBajaCodigo']; 	
			$this->CrnSunatRespuestaBajaContenido = $fila['CrnSunatRespuestaBajaContenido']; 	
			$this->CrnSunatRespuestaBajaId = $fila['CrnSunatRespuestaBajaId']; 	
			
			$this->CrnSunatRespuestaConsultaCodigo = $fila['CrnSunatRespuestaConsultaCodigo']; 	
			$this->CrnSunatRespuestaConsultaContenido = $fila['CrnSunatRespuestaConsultaContenido']; 	
			$this->CrnSunatRespuestaConsultaFecha = $fila['NCrnSunatRespuestaConsultaFecha']; 	
			$this->CrnSunatRespuestaConsultaHora = $fila['CrnSunatRespuestaConsultaHora']; 	
			
			$this->CrnSunatRespuestaEnvioTiempoCreacion = $fila['NCrnSunatRespuestaEnvioTiempoCreacion']; 	
			$this->CrnSunatRespuestaConsultaTiempoCreacion = $fila['NCrnSunatRespuestaConsultaTiempoCreacion']; 	
			$this->CrnSunatRespuestaBajaTiempoCreacion = $fila['NCrnSunatRespuestaBajaTiempoCreacion']; 	
			
			$this->CrnSunatRespuestaEnvioDigestValue = $fila['CrnSunatRespuestaEnvioDigestValue']; 	
			$this->CrnSunatRespuestaEnvioSignatureValue = $fila['CrnSunatRespuestaEnvioSignatureValue']; 	
			
			$this->CrnSunatUltimaAccion = $fila['CrnSunatUltimaAccion']; 	
			$this->CrnSunatUltimaRespuesta = $fila['CrnSunatUltimaRespuesta']; 	
						
			$this->CrnEstado = $fila['CrnEstado'];
			
			$this->CrnTiempoCreacion = $fila['NCrnTiempoCreacion'];
			$this->CrnTiempoModificacion = $fila['NCrnTiempoModificacion']; 
			$this->CrnAbono = $fila['CrnAbono'];
			
			$this->CrtNumero = $fila['CrtNumero']; 
			
			$this->MonNombre = $fila['MonNombre']; 
			$this->MonSimbolo = $fila['MonSimbolo']; 
			$this->MonSigla = $fila['MonSigla']; 
			
			$this->TdoCodigo = $fila['TdoCodigo']; 
			$this->CliNombreCompleto = $fila['CliNombreCompleto']; 
			$this->CliNombre = $fila['CliNombre']; 
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
			
			$this->TdoId = $fila['TdoId']; 
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
			$this->CliTelefono = $fila['CliTelefono'];
			$this->CliEmail = $fila['CliEmail'];
			$this->CliCelular = $fila['CliCelular'];
			$this->CliFax = $fila['CliFax'];	
			
			$this->CliProvincia = $fila['CliProvincia'];	
			$this->CliDistrito = $fila['CliDistrito'];	
			$this->CliDepartamento = $fila['CliDepartamento'];	
			
		
			$this->CrnCancelado = $fila['NCrnCancelado'];
			
		
			
			
			
				switch($this->CrnEstado){
					case 1:
						$this->CrnEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$this->CrnEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$this->CrnEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$this->CrnEstadoDescripcion = "Reservado";
					break;
					
					
				}
				
				
				
			switch($this->CrnEstado){
					case 1:
						$this->CrnEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 5:
						$this->CrnEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$this->CrnEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					case 7:
						$this->CrnEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
					
					
				}
				
				
			if($oCompleto){
				
				$InsComprobanteRetencionDetalle = new ClsComprobanteRetencionDetalle();
				
				$ResComprobanteRetencionDetalle =  $InsComprobanteRetencionDetalle->MtdObtenerComprobanteRetencionDetalles(NULL,NULL,NULL,NULL,NULL,$this->CrnId,$this->CrtId);
				$this->ComprobanteRetencionDetalle = $ResComprobanteRetencionDetalle['Datos'];
				
						
			}
			
		
				
		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerComprobanteRetenciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CrnId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oCliente=NULL) {
	
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
					ced.CedId
					FROM tblcedcomprobanteretenciondetalle ced
						
					WHERE 
						ced.CrnId = crn.CrnId AND
						ced.CrtId = crn.CrtId AND
						
						(
						ced.CedNumero LIKE "%'.$oFiltro.'%" 
						
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
		

		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (crn.CrnEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(crn.CrnFechaEmision)>="'.$oFechaInicio.'" AND DATE(crn.CrnFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(crn.CrnFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(crn.CrnFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}
		
						
		if(!empty($oTalonario)){
			$talonario = ' AND crn.CrtId = "'.$oTalonario.'"';
		}
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND crn.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND crn.CliId = "'.$oCliente.'"';
		}
		
		
		
			 $sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				crn.CrnId,
				crn.CrtId,
				crn.UsuId,
				crn.CliId,
				
				DATE_FORMAT(crn.CrnFechaEmision, "%d/%m/%Y") AS "NCrnFechaEmision",
				crn.CrnDireccion,
				crn.CrnTotalBruto,
				crn.CrnTotalRetenido,
				crn.CrnTotalPagar,
				
				crn.CrnObservacion,
				crn.CrnObservacionImpresa,
				
				crn.MonId,
				crn.CrnTipoCambio,
	
				crn.CrnCancelado,
				crn.CrnTipo,
				crn.CrnCierre,	
				crn.CrnEstado,	
			
				crn.CrnSunatRespuestaTicket,
				crn.CrnSunatRespuestaTicketEstado,
				crn.CrnSunatRespuestaObservacion,
				
				crn.CrnSunatRespuestaEnvioTicket,
				crn.CrnSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(crn.CrnSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NCrnSunatRespuestaEnvioFecha",
				crn.CrnSunatRespuestaEnvioHora,
				crn.CrnSunatRespuestaEnvioCodigo,
				crn.CrnSunatRespuestaEnvioContenido,
				
				crn.CrnSunatRespuestaBajaTicket,
				crn.CrnSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(crn.CrnSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NCrnSunatRespuestaBajaFecha",
				crn.CrnSunatRespuestaBajaHora,
				crn.CrnSunatRespuestaBajaCodigo,
				crn.CrnSunatRespuestaBajaContenido,
				crn.CrnSunatRespuestaBajaId,
				
				crn.CrnSunatRespuestaConsultaCodigo,
				crn.CrnSunatRespuestaConsultaContenido,
				DATE_FORMAT(crn.CrnSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NCrnSunatRespuestaConsultaFecha",
				crn.CrnSunatRespuestaConsultaHora,
				
				DATE_FORMAT(crn.CrnSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(crn.CrnSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(crn.CrnSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnSunatRespuestaBajaTiempoCreacion",
				
				crn.CrnSunatUltimaAccion,
				crn.CrnSunatUltimaRespuesta,
				
				DATE_FORMAT(crn.CrnTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NCrnTiempoCreacion",
                DATE_FORMAT(crn.CrnTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NCrnTiempoModificacion",

				(SELECT COUNT(ced.CedId) FROM tblcedcomprobanteretenciondetalle ced WHERE ced.CrnId = crn.CrnId AND ced.CrtId = crn.CrtId ) AS "CrnTotalItems",
				
				
				crn.CrnSunatRespuestaEnvioDigestValue,
				crn.CrnSunatRespuestaEnvioSignatureValue,

				crt.CrtNumero,
				
				mon.MonSimbolo,
				mon.MonNombre,
				mon.MonSigla,
				
				tdo.TdoCodigo,
				cli.CliNombre,
				cli.CliNombreCompleto,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.TdoId,
				cli.CliNumeroDocumento,
				cli.CliTelefono,
				cli.CliEmail,
				cli.CliCelular,
				cli.CliFax,
				
				cli.CliProvincia,
				cli.CliDistrito,
				cli.CliDepartamento
				
				FROM tblcrncomprobanteretencion crn
					LEFT JOIN tblcrtcomprobanteretenciontalonario crt
					ON crn.CrtId = crt.CrtId
								LEFT JOIN tblmonmoneda mon
								ON crn.MonId = mon.MonId
									LEFT JOIN tblclicliente cli
									ON crn.CliId = cli.CliId
										LEFT JOIN tbltdotipodocumento tdo
										ON cli.TdoId = tdo.TdoId

				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$fecha.$talonario.$tcexterno.$credito.$regimen.$npago.$moneda.$cliente.$ncredito.$amovimiento.$dvencer.$pagado.$ovvehiculo.$ovvehiculo.$vdirecta.$vendedor.$orden.$paginacion;
				
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsComprobanteRetencion = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$ComprobanteRetencion = new $InsComprobanteRetencion();
                   $ComprobanteRetencion->CrnId = $fila['CrnId'];
			$ComprobanteRetencion->CrtId = $fila['CrtId'];
            $ComprobanteRetencion->UsuId = $fila['UsuId'];
			$ComprobanteRetencion->CliId = $fila['CliId'];
			$ComprobanteRetencion->CrnFechaEmision = $fila['NCrnFechaEmision'];
			$ComprobanteRetencion->CrnDireccion = $fila['CrnDireccion']; 
			$ComprobanteRetencion->CrnTotalBruto = ($fila['CrnTotalBruto']); 
			$ComprobanteRetencion->CrnTotalRetenido = $fila['CrnTotalRetenido']; 
			$ComprobanteRetencion->CrnTotalPagar = $fila['CrnTotalPagar']; 
			
			$ComprobanteRetencion->CrnObservacion = $fila['CrnObservacion']; 
			$ComprobanteRetencion->CrnObservacionImpresa = $fila['CrnObservacionImpresa']; 
			
			$ComprobanteRetencion->MonId = $fila['MonId'];
			$ComprobanteRetencion->CrnTipoCambio = $fila['CrnTipoCambio'];

			$ComprobanteRetencion->CrnCancelado = $fila['CrnCancelado'];
			$ComprobanteRetencion->CrnTipo = $fila['CrnTipo'];
			$ComprobanteRetencion->CrnCierre = $fila['CrnCierre']; 
			
			
			$ComprobanteRetencion->CrnSunatRespuestaTicket = $fila['CrnSunatRespuestaTicket']; 	
			$ComprobanteRetencion->CrnSunatRespuestaTicketEstado = $fila['CrnSunatRespuestaTicketEstado']; 			
			$ComprobanteRetencion->CrnSunatRespuestaObservacion = $fila['CrnSunatRespuestaObservacion']; 	
			
			$ComprobanteRetencion->CrnSunatRespuestaEnvioTicket = $fila['CrnSunatRespuestaEnvioTicket']; 	
			$ComprobanteRetencion->CrnSunatRespuestaEnvioTicketEstado = $fila['CrnSunatRespuestaEnvioTicketEstado']; 	
			$ComprobanteRetencion->CrnSunatRespuestaEnvioFecha = $fila['NCrnSunatRespuestaEnvioFecha']; 	
			$ComprobanteRetencion->CrnSunatRespuestaEnvioHora = $fila['CrnSunatRespuestaEnvioHora']; 	
			$ComprobanteRetencion->CrnSunatRespuestaEnvioCodigo = $fila['CrnSunatRespuestaEnvioCodigo']; 	
			$ComprobanteRetencion->CrnSunatRespuestaEnvioContenido = $fila['CrnSunatRespuestaEnvioContenido']; 	
			
			$ComprobanteRetencion->CrnSunatRespuestaBajaTicket = $fila['CrnSunatRespuestaBajaTicket']; 	
			$ComprobanteRetencion->CrnSunatRespuestaBajaTicketEstado = $fila['CrnSunatRespuestaBajaTicketEstado']; 				
			$ComprobanteRetencion->CrnSunatRespuestaBajaFecha = $fila['NCrnSunatRespuestaBajaFecha']; 	
			$ComprobanteRetencion->CrnSunatRespuestaBajaHora = $fila['CrnSunatRespuestaBajaHora']; 				
			$ComprobanteRetencion->CrnSunatRespuestaBajaCodigo = $fila['CrnSunatRespuestaBajaCodigo']; 	
			$ComprobanteRetencion->CrnSunatRespuestaBajaContenido = $fila['CrnSunatRespuestaBajaContenido']; 	
			$ComprobanteRetencion->CrnSunatRespuestaBajaId = $fila['CrnSunatRespuestaBajaId']; 	
			
			$ComprobanteRetencion->CrnSunatRespuestaConsultaCodigo = $fila['CrnSunatRespuestaConsultaCodigo']; 	
			$ComprobanteRetencion->CrnSunatRespuestaConsultaContenido = $fila['CrnSunatRespuestaConsultaContenido']; 	
			$ComprobanteRetencion->CrnSunatRespuestaConsultaFecha = $fila['NCrnSunatRespuestaConsultaFecha']; 	
			$ComprobanteRetencion->CrnSunatRespuestaConsultaHora = $fila['CrnSunatRespuestaConsultaHora']; 	
			
			$ComprobanteRetencion->CrnSunatRespuestaEnvioTiempoCreacion = $fila['NCrnSunatRespuestaEnvioTiempoCreacion']; 	
			$ComprobanteRetencion->CrnSunatRespuestaConsultaTiempoCreacion = $fila['NCrnSunatRespuestaConsultaTiempoCreacion']; 	
			$ComprobanteRetencion->CrnSunatRespuestaBajaTiempoCreacion = $fila['NCrnSunatRespuestaBajaTiempoCreacion']; 	
			
			$ComprobanteRetencion->CrnSunatRespuestaEnvioDigestValue = $fila['CrnSunatRespuestaEnvioDigestValue']; 	
			$ComprobanteRetencion->CrnSunatRespuestaEnvioSignatureValue = $fila['CrnSunatRespuestaEnvioSignatureValue']; 	
			
			$ComprobanteRetencion->CrnSunatUltimaAccion = $fila['CrnSunatUltimaAccion']; 	
			$ComprobanteRetencion->CrnSunatUltimaRespuesta = $fila['CrnSunatUltimaRespuesta']; 	
						
			$ComprobanteRetencion->CrnEstado = $fila['CrnEstado'];
			
			$ComprobanteRetencion->CrnTiempoCreacion = $fila['NCrnTiempoCreacion'];
			$ComprobanteRetencion->CrnTiempoModificacion = $fila['NCrnTiempoModificacion']; 
			$ComprobanteRetencion->CrnTotalItems = $fila['CrnTotalItems'];
			
			$ComprobanteRetencion->CrtNumero = $fila['CrtNumero']; 
			
			$ComprobanteRetencion->MonNombre = $fila['MonNombre']; 
			$ComprobanteRetencion->MonSimbolo = $fila['MonSimbolo']; 
			$ComprobanteRetencion->MonSigla = $fila['MonSigla']; 
			
			$ComprobanteRetencion->TdoCodigo = $fila['TdoCodigo']; 
			$ComprobanteRetencion->CliNombreCompleto = $fila['CliNombreCompleto']; 
			$ComprobanteRetencion->CliNombre = $fila['CliNombre']; 
			$ComprobanteRetencion->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
			$ComprobanteRetencion->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
			
			$ComprobanteRetencion->TdoId = $fila['TdoId']; 
			$ComprobanteRetencion->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
			$ComprobanteRetencion->CliTelefono = $fila['CliTelefono'];
			$ComprobanteRetencion->CliEmail = $fila['CliEmail'];
			$ComprobanteRetencion->CliCelular = $fila['CliCelular'];
			$ComprobanteRetencion->CliFax = $fila['CliFax'];	
			
			$ComprobanteRetencion->CliProvincia = $fila['CliProvincia'];	
			$ComprobanteRetencion->CliDistrito = $fila['CliDistrito'];	
			$ComprobanteRetencion->CliDepartamento = $fila['CliDepartamento'];	
			
			$ComprobanteRetencion->CrnCancelado = $fila['NCrnCancelado'];
			
					
				switch($ComprobanteRetencion->CrnEstado){
					case 1:
						$ComprobanteRetencion->CrnEstadoDescripcion = "Pendiente";
					break;
										
					case 5:
						$ComprobanteRetencion->CrnEstadoDescripcion = "Entregado";
					break;
					
					case 6:
						$ComprobanteRetencion->CrnEstadoDescripcion = "Anulado";
				
					break;
					
					case 7:
						$ComprobanteRetencion->CrnEstadoDescripcion = "Reservado";
					break;
					
					
				}
				
				
				switch($ComprobanteRetencion->CrnEstado){
					case 1:
						$ComprobanteRetencion->CrnEstadoIcono = '<img src="imagenes/pendiente.gif" alt="[Pendiente]" title="Pendiente" border="0" width="15" height="15"  />';
					break;
										
					case 5:
						$ComprobanteRetencion->CrnEstadoIcono = '<img src="imagenes/entregado.jpg" alt="[Entregado]" title="Entregado" border="0" width="15" height="15"  />';
					break;
					
					case 6:
						$ComprobanteRetencion->CrnEstadoIcono = '<img src="imagenes/anulado.png" alt="[Anulado]" title="Anulado" border="0" width="15" height="15"  />';
				
					break;
					
					case 7:
						$ComprobanteRetencion->CrnEstadoIcono = '<img src="imagenes/reservado.png" alt="[Reservado]" title="Reservado" border="0" width="15" height="15"  />';
					break;
					
					
				}
				
				
					$ComprobanteRetencion->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $ComprobanteRetencion;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
	
//MtdObtenerComprobanteRetenciones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CrnId',$oSentido = 'Desc',$oPaginacion = '0,10',$oSucursal=NULL,$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oCredito=NULL,$oRegimen=NULL,$oCondicionPago=NULL,$oNotaCredito=NULL,$oMoneda=NULL,$oCliente=NULL,$oAlmacenMovimiento=NULL,$oDiaVencer=NULL,$oPagado=NULL,$oOrdenVentaVehiculo=NULL,$oVentaDirecta=NULL) 
	public function MtdObtenerComprobanteRetencionesValor($oFuncion="SUM",$oParametro="CrnId",$oMes=NULL,$oAno=NULL,$oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'CrnId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oMoneda=NULL,$oCliente=NULL,$oClienteTipo=NULL)  {

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
			
		}
		
		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (crn.CrnEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}
		
		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(crn.CrnFechaEmision)>="'.$oFechaInicio.'" AND DATE(crn.CrnFechaEmision)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(crn.CrnFechaEmision)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(crn.CrnFechaEmision)<="'.$oFechaFin.'"';		
			}			
		}


		if(!empty($oTalonario)){
			$talonario = ' AND crn.CrtId = "'.$oTalonario.'"';
		}
		
		
		if(!empty($oMoneda)){
			$moneda = ' AND crn.MonId = "'.$oMoneda.'"';
		}
		
		if(!empty($oCliente)){
			$cliente = ' AND crn.CliId = "'.$oCliente.'"';
		}

		if(!empty($oClienteTipo)){
			$ctipo = ' AND cli.LtiId = "'.$oClienteTipo.'" ';
		}
		
		
		
		if(!empty($oMes)){
			$mes = ' AND MONTH(crn.CrnFechaEmision) ="'.($oMes).'"';
		}
		
		if(!empty($oAno)){
			$ano = ' AND YEAR(crn.CrnFechaEmision) ="'.($oAno).'"';
		}

		if(!empty($oFuncion) & !empty($oParametro)){		
			$funcion = $oFuncion.'('.$oParametro.')';			
		}					
		$sql = 'SELECT

		
				'.$funcion.' AS "RESULTADO"
				FROM tblcrncomprobanteretencion crn
					LEFT JOIN tblcrtcomprobanteretenciontalonario crt
					ON crn.CrtId = crt.CrtId
						LEFT JOIN tblclicliente cli
						ON crn.CliId = cli.CliId
							LEFT JOIN tblusuusuario usu
							ON crn.UsuId = usu.UsuId
								LEFT JOIN tblperpersonal per
								ON crn.UsuId = per.UsuId

				WHERE 1 = 1 '.$filtrar.$sucursal.$estado.$fecha.$talonario.$credito.$vendedor.$ncredito.$regimen.$npago.$moneda.$cliente.$ctipo .$mes.$ano.$amovimiento.$clasificacion.$mingreso.$mkilometraje.$vmarca.$vmodelo.$tecnico.$origen.$orden.$paginacion;


			$resultado = $this->InsMysql->MtdConsultar($sql);                       
			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
			

			settype($fila['RESULTADO'],"float");
			
			return $fila['RESULTADO'];
		}
		
		
		
	public function MtdActualizarEstadoComprobanteRetencion($oElementos,$oEstado) {
		
		$error = false;
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$accion = '';
		$elementos = explode("#",$oElementos);
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
				
					$this->CrnId = $aux[0];
					$this->CrtId = $aux[1];
						
						
						if(!empty($this->CrnId) and !empty($this->CrtId)){
							
							$this->MtdObtenerComprobanteRetencion(false);
							
							
						}
						
						

					$sql = 'UPDATE tblcrncomprobanteretencion SET CrnEstado = '.$oEstado.' WHERE   (CrnId = "'.($aux[0]).'" AND CrtId = "'.($aux[1]).'")';
			
					
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					
					if(!$resultado) {						
						$error = true;
					}else{						
						$this->MtdAuditarComprobanteRetencion(2,"Se actualizo el Estado del Comprobante de Retencion",$aux);	
					}
					
				}
			$i++;
	
			}

		
			/*$sql = 'UPDATE tblcrncomprobanteretencion SET CrnEstado = '.$oEstado.' WHERE '.$accion;
			$error = false;
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			if(!$resultado) {						
				$error = true;
			} 	*/	
			
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();				
				return false;
			} else {		
				$this->InsMysql->MtdTransaccionHacer();
				return true;
			}							
	}

	//Accion eliminar	 
	
	public function MtdEliminarComprobanteRetencion($oElementos) {
		
		$error = false;		
		
		$this->InsMysql->MtdTransaccionIniciar();
		
		$elementos = explode("#",$oElementos);
		

			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
							
					$this->CrnId = $aux[0];
					$this->CrtId = $aux[1];
					
					$this->MtdObtenerComprobanteRetencion();

					
					if(!$error){

						$sql = 'DELETE FROM tblcrncomprobanteretencion WHERE (CrnId = "'.($aux[0]).'" AND CrtId = "'.($aux[1]).'")';
						$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
						if(!$resultado) {						
							$error = true;
						}else{
							$this->MtdAuditarComprobanteRetencion(3,"Se elimino el Comprobante de Retencion",$aux);		
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
	
	
	public function MtdRegistrarComprobanteRetencion() {

		global $Resultado;
		$error = false;


				$this->CrnId = trim($this->CrnId);

				$this->InsMysql->MtdTransaccionIniciar();

				//$this->MtdGenerarComprobanteRetencionId();

				$sql = 'INSERT INTO tblcrncomprobanteretencion (
				CrnId,
				CrtId,
				UsuId, 
				CliId,
				
				MonId,
				CrnTipoCambio,			
	
				CrnCancelado,	
				CrnTipo,
						
				CrnEstado,
				CrnFechaEmision,
				CrnDireccion,
				
				CrnTotalBruto,
				CrnTotalPagar,	
				CrnTotalRetenido,

				CrnObservacion,
				CrnObservacionImpresa,
				
				CrnCierre,
				CrnTiempoCreacion,
				CrnTiempoModificacion
				
				) 
				VALUES (
				"'.($this->CrnId).'", 
				"'.($this->CrtId).'",
				"'.($this->UsuId).'",
				"'.($this->CliId).'",

				"'.($this->MonId).'",
				'.(empty($this->CrnTipoCambio)?'NULL, ':''.$this->CrnTipoCambio.',').'
				'.($this->CrnCancelado).',
				'.($this->CrnTipo).',	
					
				'.($this->CrnEstado).',
				"'.($this->CrnFechaEmision).'",
				"'.($this->CrnDireccion).'",
				
				'.($this->CrnTotalBruto).',
				'.($this->CrnTotalPagar).',
				'.($this->CrnTotalRetenido).',				
				
				"'.($this->CrnObservacion).'", 
				"'.($this->CrnObservacionImpresa).'", 
				
				'.($this->CrnCierre).', 
				"'.($this->CrnTiempoCreacion).'", 
				"'.($this->CrnTiempoModificacion).'");';

				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
						
						switch($this->InsMysql->MtdObtenerErrorCodigo()){
							case 1062:					
								$Resultado.="#ERR_CRN_402";
							break;
						}
					} 
				}
			
				
				if(!$error){			
				
					if (!empty($this->ComprobanteRetencionDetalle)){		
							
						$validar = 0;				
						$InsComprobanteRetencionDetalle = new ClsComprobanteRetencionDetalle();		
								
						foreach ($this->ComprobanteRetencionDetalle as $DatComprobanteRetencionDetalle){
						
							$InsComprobanteRetencionDetalle->CrnId = $this->CrnId;
							$InsComprobanteRetencionDetalle->CrtId = $this->CrtId;
							
							$InsComprobanteRetencionDetalle->CedTipoDocumento = $DatComprobanteRetencionDetalle->CedTipoDocumento;								
							$InsComprobanteRetencionDetalle->CedSerie= $DatComprobanteRetencionDetalle->CedSerie;
							$InsComprobanteRetencionDetalle->CedNumero = $DatComprobanteRetencionDetalle->CedNumero;
							$InsComprobanteRetencionDetalle->CedFechaEmision = $DatComprobanteRetencionDetalle->CedFechaEmision;	
												
							$InsComprobanteRetencionDetalle->CedTotal = $DatComprobanteRetencionDetalle->CedTotal;							
							$InsComprobanteRetencionDetalle->CedPorcentajeRetencion = $DatComprobanteRetencionDetalle->CedPorcentajeRetencion;
							$InsComprobanteRetencionDetalle->CedRetenido = $DatComprobanteRetencionDetalle->CedRetenido;
							$InsComprobanteRetencionDetalle->CedPagado = $DatComprobanteRetencionDetalle->CedPagado;

							$InsComprobanteRetencionDetalle->CedEstado = $this->CrnEstado;
							$InsComprobanteRetencionDetalle->CedTiempoCreacion = $DatComprobanteRetencionDetalle->CedTiempoCreacion;
							$InsComprobanteRetencionDetalle->CedTiempoModificacion = $DatComprobanteRetencionDetalle->CedTiempoModificacion;						
							$InsComprobanteRetencionDetalle->CedEliminado = $DatComprobanteRetencionDetalle->CedEliminado;
							
							if($InsComprobanteRetencionDetalle->MtdRegistrarComprobanteRetencionDetalle()){
								$validar++;					
							}else{								
								$Resultado.='#ERR_CRN_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->ComprobanteRetencionDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}

			
			if($error) {	
				
				$this->InsMysql->MtdTransaccionDeshacer();			
				return false;
			} else {				
				
				$this->InsMysql->MtdTransaccionHacer();					
				
				$this->MtdAuditarComprobanteRetencion(1,"Se registro el Comprobante de Retencion",$this);
				return true;
			}			
			
	}
	
	public function MtdEditarComprobanteRetencion() {
	
		$error = false;
		global $Resultado;

//		if(FncConvetirTimestamp(date("d/m/Y"))<FncConvetirTimestamp(FncCambiaFechaANormal($this->CrnFechaEmision))){
//			$error = true;
//			$Resultado.='#ERR_CRN_400';
//		}else{
				$this->InsMysql->MtdTransaccionIniciar();

				$InsCliente = new ClsCliente($this->InsMysql);	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->CcaId = "CCA-10000";
				$InsCliente->TdoId = $this->TdoId;					
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliDireccion = $this->CrnDireccion;
				$InsCliente->CliEstado = 1;//En actividad
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
				$InsCliente->CliEliminado = 1;
			
				if(empty($InsCliente->CliId)){
					
					$InsCliente->MtdGenerarClienteId();	

					if(!$InsCliente->MtdRegistrarClienteDeComprobanteRetencion()){
						$error = true;
						$Resultado.='#ERR_CRN_301';
					}else{
						$this->CliId = $InsCliente->CliId;									
					}		
				
					
				}else{
					
					/*if(!$InsCliente->MtdEditarClienteDato("CliDireccion",$InsCliente->CliDireccion,$InsCliente->CliId)){
						$error = true;					
						$Resultado.='#ERR_CRN_302';
					}*/
					
				}	
			
			$sql = 'UPDATE tblcrncomprobanteretencion SET 
			CliId = "'.($this->CliId).'",
			
			MonId = "'.($this->MonId).'",
			'.(empty($this->CrnTipoCambio)?'CrnTipoCambio = NULL, ':'CrnTipoCambio = "'.$this->CrnTipoCambio.'",').'

			CrnCancelado = '.($this->CrnCancelado).',
			CrnTipo = '.($this->CrnTipo).',

			CrnEstado = '.($this->CrnEstado).',
			CrnFechaEmision = "'.($this->CrnFechaEmision).'",
			
			CrnDireccion = "'.($this->CrnDireccion).'",
			CrnTotalBruto = "'.($this->CrnTotalBruto).'",
			CrnTotalPagar = '.($this->CrnTotalPagar).',
			CrnTotalRetenido = '.($this->CrnTotalRetenido).',
			
			CrnObservacion = "'.($this->CrnObservacion).'",
			CrnObservacionImpresa = "'.($this->CrnObservacionImpresa).'",
			CrnTiempoModificacion = "'.($this->CrnTiempoModificacion).'"
						
			WHERE CrnId = "'.($this->CrnId).'"
			AND CrtId = "'.$this->CrtId.'";';

					
		if(!$error){
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			if(!$resultado) {							
				$error = true;
			} 
		}
			
			if(!$error){
			
				if (!empty($this->ComprobanteRetencionDetalle)){		
						
						
					$validar = 0;				
					$InsComprobanteRetencionDetalle = new ClsComprobanteRetencionDetalle();		
							
					foreach ($this->ComprobanteRetencionDetalle as $DatComprobanteRetencionDetalle){
										
						$InsComprobanteRetencionDetalle->CedId = $DatComprobanteRetencionDetalle->CedId;
						$InsComprobanteRetencionDetalle->CrnId = $this->CrnId;
						$InsComprobanteRetencionDetalle->CrtId = $this->CrtId;
						
						$InsComprobanteRetencionDetalle->CedTipoDocumento = $DatComprobanteRetencionDetalle->CedTipoDocumento;	
						$InsComprobanteRetencionDetalle->CedSerie= $DatComprobanteRetencionDetalle->CedSerie;
						$InsComprobanteRetencionDetalle->CedNumero = $DatComprobanteRetencionDetalle->CedNumero;
						$InsComprobanteRetencionDetalle->CedFechaEmision = $DatComprobanteRetencionDetalle->CedFechaEmision;
						$InsComprobanteRetencionDetalle->CedTotal = $DatComprobanteRetencionDetalle->CedTotal;						
						$InsComprobanteRetencionDetalle->CedPorcentajeRetencion = $DatComprobanteRetencionDetalle->CedPorcentajeRetencion;						
						$InsComprobanteRetencionDetalle->CedRetenido = $DatComprobanteRetencionDetalle->CedRetenido;					
						$InsComprobanteRetencionDetalle->CedPagado = $DatComprobanteRetencionDetalle->CedPagado;
						$InsComprobanteRetencionDetalle->CedEstado = $DatComprobanteRetencionDetalle->CedEstado;
							
						$InsComprobanteRetencionDetalle->CedTiempoCreacion = $DatComprobanteRetencionDetalle->CedTiempoCreacion;
						$InsComprobanteRetencionDetalle->CedTiempoModificacion = $DatComprobanteRetencionDetalle->CedTiempoModificacion;
						$InsComprobanteRetencionDetalle->CedEliminado = $DatComprobanteRetencionDetalle->CedEliminado;
						
						if(empty($InsComprobanteRetencionDetalle->CedId)){
							if($InsComprobanteRetencionDetalle->CedEliminado<>2){
								if($InsComprobanteRetencionDetalle->MtdRegistrarComprobanteRetencionDetalle()){
									$validar++;					
								}else{
									$Resultado.='#ERR_CRN_201';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}else{
								$validar++;		
							}
						}else{						
							if($InsComprobanteRetencionDetalle->CedEliminado==2){
								if($InsComprobanteRetencionDetalle->MtdEliminarComprobanteRetencionDetalle($InsComprobanteRetencionDetalle->CedId)){
									$validar++;					
								}else{
									$Resultado.='#ERR_CRN_203';
									$Resultado.='#Item Numero: '.($validar+1);	
								}
							}else{
								if($InsComprobanteRetencionDetalle->MtdEditarComprobanteRetencionDetalle()){
									$validar++;					
								}else{
									$Resultado.='#ERR_CRN_202';
									$Resultado.='#Item Numero: '.($validar+1);
								}
							}
						}									
					}
					
					
					if(count($this->ComprobanteRetencionDetalle) <> $validar ){
						$error = true;
					}					
								
				}				
			}
			
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();		
				
				$this->MtdAuditarComprobanteRetencion(2,"Se edito el Comprobante de Retencion",$this);		
				return true;
			}
			
					
				
		}	
		
	
	public function MtdEditarIdComprobanteRetencion() {
			
	$error = false;

	$this->InsMysql->MtdTransaccionIniciar();
				
			$sql = 'UPDATE tblcrncomprobanteretencion SET 
			CrnId = "'.($this->NCrnId).'",
			CrnTiempoModificacion = "'.($this->CrnTiempoModificacion).'"
			WHERE CrnId = "'.($this->CrnId).'"
			AND CrtId = "'.$this->CrtId.'";';

			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			if(!$resultado) {							
				$error = true;
			} 

			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();		
				$this->MtdAuditarComprobanteRetencion(2,"Se edito el Codigo del Comprobante de Retencion",$this);	
				return true;
			}
						
		}
		
	
		
		
		
		private function MtdAuditarComprobanteRetencion($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria($this->InsMysql);
			$InsAuditoria->AudCodigo = $this->CrnId;
			$InsAuditoria->AudCodigoExtra = $this->CrtId;
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
		
		
	
	
	
	public function MtdNotificarComprobanteRetencionRegistro($oComprobanteRetencionId,$oComprobanteRetencionTalonarioId,$oDestinatario){
		
global $SistemaCorreoUsuario;
		global $SistemaCorreoRemitente;
		global $SistemaNombreAbreviado;
		
			$this->CrnId = $oComprobanteRetencionId;
			$this->CrtId = $oComprobanteRetencionTalonarioId;
			
			$this->MtdObtenerComprobanteRetencion();
			
			global $EmpresaMonedaId;
			
			$mensaje .= "NOTIFICACION DE REGISTRO:";	
			$mensaje .= "<br>";	
			$mensaje .= "<br>";	
			
			$mensaje .= "Registro de ComprobanteRetencion.";	
			$mensaje .= "<br>";	

			$mensaje .= "<b>Codigo Interno:</b> ".$this->CrtNumero." - ".$this->CrnId."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Cliente:</b> ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Fecha de comprobante:</b> ".$this->CrnFechaEmision."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Fecha de vencimiento: </b>".$this->CrnFechaVencimiento."";	
			$mensaje .= "<br>";	
			$mensaje .= "<b>Moneda:</b> ".$this->MonSimbolo."";	

			$mensaje .= "<br>";	
			$mensaje .= "<b>Observaciones:</b> ".$this->CrnObservacionImpresa."";	
			
			$mensaje .= "<br>";	
			$mensaje .= "<b>Leyenda:</b> ".$this->CrnLeyenda."";	

			$mensaje .= "<br>";		
			$mensaje .= "<b>Usuario:</b> ".$this->UsuUsuario."";	

			$mensaje .= "<hr>";
			$mensaje .= "<br>";
			
				
			if($this->CrnTipo == "2"){
				
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cant.";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Unidad";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Descripcion";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "P. Unit";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Valor Total";
						$mensaje .= "</td>";
						
					$mensaje .= "</tr>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "1";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";	
						$mensaje .= "";						
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= stripslashes($this->CrnConcepto);
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "";					
						$mensaje .= "</td>";
					
					$mensaje .= "</tr>";
					
					$mensaje .= "</table>";
					
					//
//					if($this->CrnTipo == "2"){
//						$TotalBruto = $this->CrnTotal;
//					}
//						
//					if($this->CrnIncluyeImpuesto==2){
//					
//						$SubTotal = round($TotalBruto,6);
//						$Impuesto = round(($SubTotal * ($this->CrnPorcentajeImpuestoVenta/100)),6);
//						$Total = round($SubTotal + $Impuesto,6);
//					
//					}else{
//					
//						$Total = round($TotalBruto,6);	
//						$SubTotal = round($Total / (($this->CrnPorcentajeImpuestoVenta/100)+1),6);
//						$Impuesto = round(($Total - $SubTotal),6);
//					
//					}
				
			}else{
				
				
					if($this->MonId<>$EmpresaMonedaId and (!empty($this->CrnTipoCambio) )){
						  $this->CrnTotalBruto = round($this->CrnTotalBruto / $this->CrnTipoCambio,2);
						  $this->CrnImpuesto = round($this->CrnImpuesto  / $this->CrnTipoCambio,2);
						   $this->CrnTotal = round($this->CrnTotal  / $this->CrnTipoCambio,2);
					  }
								
					
				$mensaje .= "<table cellpadding='4' cellspacing='4' width='100%'>";
					
					$mensaje .= "<tr>";
					
						$mensaje .= "<td>";
						$mensaje .= "#";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Cant.";
						$mensaje .= "</td>";
		
						$mensaje .= "<td>";
						$mensaje .= "Unidad";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Descripcion";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "P. Unit";
						$mensaje .= "</td>";
						
						$mensaje .= "<td>";
						$mensaje .= "Valor Total";
						$mensaje .= "</td>";
						
					$mensaje .= "</tr>";
					
					$i = 1;	
				 $ArrMateriales = array();
        
					if(!empty($this->ComprobanteRetencionDetalle)){
						foreach($this->ComprobanteRetencionDetalle as $DatComprobanteRetencionDetalle){
							
						
    
								if($this->MonId<>$EmpresaMonedaId){
									$DatComprobanteRetencionDetalle->CedRetenido = round($DatComprobanteRetencionDetalle->CedRetenido / $this->CrnTipoCambio,2);
									$DatComprobanteRetencionDetalle->CedTotal = round($DatComprobanteRetencionDetalle->CedTotal  / $this->CrnTipoCambio,2);
								}
								
								
								$mensaje .= "<tr>";
										
										$mensaje .= "<td>";
										$mensaje .= $i;
										$mensaje .= "</td>";
		
		
										$mensaje .= "<td>";				
										if($DatComprobanteRetencionDetalle->CedTipoDocumento<>"T"){
											$mensaje .= $DatComprobanteRetencionDetalle->CedPorcentajeRetencion;									
										}else{
											$mensaje .= "-";
										}
										$mensaje .= "</td>";
		
										$mensaje .= "<td>";
										$mensaje .= $DatComprobanteRetencionDetalle->CedFechaEmision;
										$mensaje .= "</td>";
										
										$mensaje .= "<td>";
										$mensaje .= stripslashes( $DatComprobanteRetencionDetalle->CedNumero);
										$mensaje .= "</td>";
										
										
										$mensaje .= "<td>";				
										if($DatComprobanteRetencionDetalle->CedTipoDocumento<>"T"){
											$mensaje .= number_format(($DatComprobanteRetencionDetalle->CedTotal),2);									
										}else{
											$mensaje .= "-";
										}
										$mensaje .= "</td>";
										
										$mensaje .= "<td>";				
										if($DatComprobanteRetencionDetalle->CedTipoDocumento<>"T"){
											$mensaje .= number_format(($DatComprobanteRetencionDetalle->CedRetenido),2);									
										}else{
											$mensaje .= "-";
										}
										$mensaje .= "</td>";
										
									$mensaje .= "</tr>";
									$i++;				
						 	  $TotalBruto = $TotalBruto + $DatComprobanteRetencionDetalle->CedRetenido;		
							
												
									
						}
					}
					
					$mensaje .= "</table>";
					
					

					
					
					
				//	
//					if($this->CrnIncluyeImpuesto==2){
//				
//					$SubTotal = round($TotalBruto,6);
//					$Impuesto = round(($SubTotal * ($this->CrnPorcentajeImpuestoVenta/100)),6);
//					$Total = round($SubTotal + $Impuesto,6);
//				
//				}else{
//				
//					$Total = round($TotalBruto,6);	
//					$SubTotal = round($Total / (($this->CrnPorcentajeImpuestoVenta/100)+1),6);
//					$Impuesto = round(($Total - $SubTotal),6);
//				
//				}
						
				

				
			}
			
				
					
				 if(!empty($this->EinVIN)){
					$mensaje .= "VIN: ".$this->EinVIN." - ";	
					$mensaje .= " ".$this->EinPlaca." - ";
					$mensaje .= " ".$this->VmaNombre." - ";
					$mensaje .= " ".$this->VmoNombre." - ";
					$mensaje .= " ".$this->VveNombre." - ";
					$mensaje .= "<br>";	
				}
				
	
		
			if(!empty($this->FinId)){
					$mensaje .= "O.T.: ".$this->FinId."  ";	
					$mensaje .= "Kilom.: ".$this->FinVehiculoKilometraje." ".(!empty($this->FinVehiculoKilometraje))?'KM':'';
					$mensaje .= "<br>";	
				}
		
		
				if(!empty($this->AmoId)){
					$mensaje .= "Ficha: ".$this->AmoId." ";	
					$mensaje .= "<br>";	
				}
			
			

					$mensaje .= "<br>";		
					$mensaje .= "<br>";	
					
				//	$mensaje .= "SubTotal: ".number_format($SubTotal,2)." ";	
//					$mensaje .= "<br>";	
//					
//					$mensaje .= "Impuesto: ".number_format($Impuesto,2)." ";	
//					$mensaje .= "<br>";	
//					
//					$mensaje .= "Total: ".number_format($Total,2)." ";	
//					$mensaje .= "<br>";	
					$mensaje .= "SubTotal: ".number_format($this->CrnTotalBruto,2)." ";	
					$mensaje .= "<br>";	
					
					$mensaje .= "Impuesto: ".number_format($this->CrnImpuesto,2)." ";	
					$mensaje .= "<br>";	
					
					$mensaje .= "Total: ".number_format($this->CrnTotal,2)." ";	
					$mensaje .= "<br>";	
		
			
			$mensaje .= "<br>";
			$mensaje .= "<br>";
			$mensaje .= "Mensaje autogenerado por sistema ".$SistemaNombreAbreviado." a las ".date('d/m/Y H:i:s');
			
			
		//	echo $mensaje;
			//echo "----";
			
			$InsCorreo = new ClsCorreo();	
			$InsCorreo->MtdEnviarCorreo($oDestinatario,$SistemaCorreoUsuario,$SistemaCorreoRemitente,"NOTIFICACION: COMPROBANTE RETENCION Nro.: ".$this->CrtNumero." - ".$this->CrnId." - ".$this->CliNombre." ".$this->CliApellidoPaterno." ".$this->CliApellidoMaterno,$mensaje);
				
				
				
		}
		
	public function MtdEditarComprobanteRetencionDato($oCampo,$oDato,$oId,$oTalonario) {

			$sql = 'UPDATE tblcrncomprobanteretencion SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			CrnTiempoModificacion = NOW()
			WHERE CrnId = "'.($oId).'"
			AND CrtId = "'.($oTalonario).'"
			;';
			
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

			
}
?>