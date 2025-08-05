<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsGuiaRemision
 *
 * @author Ing. Jonathan Blanco Alave
 */

class ClsGuiaRemision {

    public $GreId;
	public $GrtId;
    public $UsuId;
	
	public $CliId;
	public $PrvId;
	
	public $OvvId;
	public $GreDestinatarioNombre;
	public $GreDestinatarioNumeroDocumento1;
	public $GreDestinatarioNumeroDocumento2;
	
	public $GreFechaEmision;
	public $GreFechaInicioTraslado;
	public $GrePuntoPartida;
	public $GrePuntoLlegada;	
	
	public $GreNumeroRegistro;
	public $GreNumeroConstanciaInscripcion;
	public $GreChofer;
	public $GreNumeroLicenciaConducir;
	public $GreMarca;
	public $GrePlaca;
	public $GreMotivoTraslado;
	public $GreMotivoTrasladoOtro;
	public $GreComprobantePagoNumero;
	
	public $GreAlmacenMovimiento;
	
	public $GreObservacion;
	public $GreObservacionImpresa;
	public $GreEstado;
	public $GreCierre;
    public $GreTiempoCreacion;
    public $GreTiempoModificacion;
	
	public $GreTotalItems;
	
    public $GreEliminado;

	public $GuiaRemisionDetalle;
	public $GuiaRemisionAlmacenMovimiento;
	
	public $GrtNumero;
	
	public $CliNombre;
	public $CliNumeroDocumento;
	
	public $PrvNombre;
	public $PrvNumeroDocumento;
		
    public $InsMysql;
	public $Transaccion;	
	
    public function __construct(){
		$this->InsMysql = new ClsMysql();
		$this->Transaccion = true;
    }
	
	public function __destruct(){

	}

	public function MtdGenerarGuiaRemisionId() {


		$sql = 'SELECT	
		MAX(CONVERT(SUBSTR(gre.GreId,5),unsigned)) AS "MAXIMO",
		grt.GrtInicio
		FROM tblgreguiaremision gre
		LEFT JOIN tblgrtguiaremisiontalonario grt
		ON gre.GrtId = grt.GrtId
		WHERE grt.GrtId = "'.$this->GrtId.'"';

		$resultado = $this->InsMysql->MtdConsultar($sql);                       
		$fila = $this->InsMysql->MtdObtenerDatos($resultado);            

		if(empty($fila['MAXIMO'])){	
			if(empty($fila['GrtInicio'])){
				$this->GreId = "0000001";
			}else{
				$this->GreId = str_pad($fila['GrtInicio'], 7, "0", STR_PAD_LEFT);
			}
		}else{
			$fila['MAXIMO']++;
			$this->GreId = str_pad($fila['MAXIMO'], 7, "0", STR_PAD_LEFT);	
		}
		
		
//			$sql = 'SELECT	
//			MAX(CONVERT(SUBSTR(gre.GreId,5),unsigned)) AS "MAXIMO",
//			grt.GrtInicio
//			FROM tblgreguiaremision gre
//				LEFT JOIN tblgrtguiaremisiontalonario grt
//				ON gre.GrtId = grt.GrtId
//			WHERE grt.GrtId = "'.$this->GrtId.'"';
//			
//			$resultado = $this->InsMysql->MtdConsultar($sql);                       
//			$fila = $this->InsMysql->MtdObtenerDatos($resultado);            
//			
//			if(empty($fila['MAXIMO'])){							
//				
//				if(empty($fila['GrtInicio'])){
//					$this->GreId = "GRE-10000";
//				}else{
//					$this->GreId = "GRE-".$fila['GrtInicio'];
//				}
//			}else{
//				$fila['MAXIMO']++;
//				$this->GreId = "GRE-".$fila['MAXIMO'];
//				
//			}	
								
		}
		
    public function MtdObtenerGuiaRemision(){

//deb($this);
//deb($this->GrtId);
	
	//deb($this->GrtId."cls");
	
		 $sql = 'SELECT 
				gre.GreId,
				gre.GrtId,
				gre.UsuId,

				gre.CliId,
				gre.PrvId,
				
				gre.OvvId,
				
				gre.GreDestinatarioNombre,
				gre.GreDestinatarioNumeroDocumento1,
				gre.GreDestinatarioNumeroDocumento2,
				
				DATE_FORMAT(gre.GreFechaEmision, "%d/%m/%Y") AS "NGreFechaEmision",
				DATE_FORMAT(gre.GreTiempoCreacion, "%H:%i:%s") AS "NGreHoraInicioTraslado",
				
				
				DATE_FORMAT(gre.GreFechaInicioTraslado, "%d/%m/%Y") AS "NGreFechaInicioTraslado",

				gre.GrePuntoPartida,
				gre.GrePuntoPartidaDepartamento,
				gre.GrePuntoPartidaProvincia,
				gre.GrePuntoPartidaDistrito,

				gre.GrePuntoLlegada,	
				gre.GrePuntoLlegadaDepartamento,	
				gre.GrePuntoLlegadaProvincia,
				gre.GrePuntoLlegadaDistrito,		

				gre.GrePuntoPartidaCodigoUbigeo,
				gre.GrePuntoLlegadaCodigoUbigeo,	
				
				gre.GreNumeroRegistro,
				gre.GreNumeroConstanciaInscripcion,
				gre.GreChofer,
				gre.GreChoferNumeroDocumento,
				
				gre.GreNumeroLicenciaConducir,
				gre.GreMarca,
				gre.GrePlaca,
				gre.GreMotivoTraslado,
				gre.GreMotivoTrasladoOtro,
				gre.GreComprobantePagoNumero,
				gre.GreMotivoTrasladoCodigo,
				gre.GreMotivoTrasladoDescripcion,
				
				gre.GreObservacion,
				gre.GreObservacionImpresa,
				
				gre.GreSunatRespuestaTicket,
				gre.GreSunatRespuestaTicketEstado,
				gre.GreSunatRespuestaObservacion,
				
				gre.GreSunatRespuestaEnvioTicket,
				gre.GreSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(gre.GreSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NGreSunatRespuestaEnvioFecha",
				gre.GreSunatRespuestaEnvioHora,
				gre.GreSunatRespuestaEnvioCodigo,
				gre.GreSunatRespuestaEnvioContenido,
				
				gre.GreSunatRespuestaBajaTicket,
				gre.GreSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(gre.GreSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NGreSunatRespuestaBajaFecha",
				gre.GreSunatRespuestaBajaHora,
				gre.GreSunatRespuestaBajaCodigo,
				gre.GreSunatRespuestaBajaContenido,
				gre.GreSunatRespuestaBajaId,
				
				gre.GreSunatRespuestaConsultaCodigo,
				gre.GreSunatRespuestaConsultaContenido,
				DATE_FORMAT(gre.GreSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NGreSunatRespuestaConsultaFecha",
				gre.GreSunatRespuestaConsultaHora,
				
				DATE_FORMAT(gre.GreSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(gre.GreSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(gre.GreSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreSunatRespuestaBajaTiempoCreacion",
				
				gre.GreSunatUltimaAccion,
				gre.GreSunatUltimaRespuesta,
				
				gre.GreSunatRespuestaEnvioDigestValue,
				gre.GreSunatRespuestaEnvioSignatureValue,

				gre.GrePesoTotal,		
				gre.GreTotalPaquetes,		
				
				gre.GreEstado,					
				gre.GreCierre,
				DATE_FORMAT(gre.GreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreTiempoCreacion",
                DATE_FORMAT(gre.GreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGreTiempoModificacion",
				
				grt.GrtNumero,
				
				cli.CliNumeroDocumento,
				cli.CliNombre,
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				cli.CliNumeroDocumento,
				tdo1.TdoCodigo,
				tdo1.TdoNombre,
				
				prv.PrvNombre,
				prv.PrvNumeroDocumento,
				
				(
				SELECT 
					CONCAT(vdi.VdiModelo,"  /  ",vdi.VdiPlaca)
				FROM tblgamguiaremisionalmacenmovimiento gam

					LEFT JOIN tblamoalmacenmovimiento amo
					ON gam.AmoId = amo.AmoId
						
						LEFT JOIN tblvdiventadirecta vdi
						ON amo.VdiId = vdi.VdiId
			
				WHERE (gre.GreId = gam.GreId AND gre.GrtId = gam.GrtId)
					ORDER BY amo.AmoFecha DESC
					LIMIT 1
					
				) AS GreVehiculo,
				
				ein2.EinVIN AS OrdenVentaVehiculoEinVIN,
				ein2.EinNumeroMotor AS OrdenVentaVehiculoEinNumeroMotor,
				ein2.EinAnoFabricacion AS OrdenVentaVehiculoEinAnoFabricacion,
				ein2.EinColor AS OrdenVentaVehiculoEinColor,
				ein2.EinDUA AS OrdenVentaVehiculoEinDUA,
				
				vma2.VmaNombre AS OrdenVentaVehiculoVmaNombre,
				vmo2.VmoNombre AS OrdenVentaVehiculoVmoNombre,
				vve2.VveNombre AS OrdenVentaVehiculoVveNombre,
				
				vve2.VveCaracteristica1,
				vve2.VveCaracteristica2,
				vve2.VveCaracteristica3,
				vve2.VveCaracteristica4,
				vve2.VveCaracteristica5,
				vve2.VveCaracteristica6,
				vve2.VveCaracteristica7,
				vve2.VveCaracteristica8,
				vve2.VveCaracteristica9,
				vve2.VveCaracteristica10,
				vve2.VveCaracteristica11,
				vve2.VveCaracteristica12,
				vve2.VveCaracteristica13,
				vve2.VveCaracteristica14,
				vve2.VveCaracteristica15,
				vve2.VveCaracteristica16,
				vve2.VveCaracteristica17,
				
				tdo2.TdoNombre AS TdoNombreProveedor,
				
				sca.ScaNombre	
				

				FROM tblgreguiaremision gre
					LEFT JOIN tblgrtguiaremisiontalonario grt
					ON gre.GrtId = grt.GrtId
						LEFT JOIN tblclicliente cli
						ON gre.CliId = cli.CliId
							LEFT JOIN tbltdotipodocumento tdo1
							ON cli.TdoId = tdo1.TdoId
							
							LEFT JOIN tblprvproveedor prv
							ON gre.PrvId = prv.PrvId
								LEFT JOIN tbltdotipodocumento tdo2
								ON prv.TdoId = tdo2.TdoId

											LEFT JOIN tblovvordenventavehiculo ovv
											ON gre.OvvId = ovv.OvvId
												
												LEFT JOIN tbleinvehiculoingreso ein2
												ON ovv.EinId = ein2.EinId
												
												LEFT JOIN tblvvevehiculoversion vve2
												ON ein2.VveId = vve2.VveId
												
													LEFT JOIN tblvmovehiculomodelo vmo2
													ON vve2.VmoId = vmo2.VmoId
													
														LEFT JOIN tblvmavehiculomarca vma2
														ON vmo2.Vmaid = vma2.VmaId
														

														LEFT JOIn tblscasunatcatalogo sca
						ON gre.GreMotivoTrasladoCodigo = sca.ScaCodigo
					
				WHERE gre.GreId = "'.$this->GreId.'" AND gre.GrtId = "'.$this->GrtId.'";';
		
	
		
        $resultado = $this->InsMysql->MtdConsultar($sql);
		
		if($this->InsMysql->MtdObtenerDatosTotal($resultado)>0){
		
        while ($fila = $this->InsMysql->MtdObtenerDatos($resultado))
        {
			
			$this->GreId = $fila['GreId'];
			$this->GrtId = $fila['GrtId'];
            $this->UsuId = $fila['UsuId'];

			$this->CliId = $fila['CliId'];
			$this->PrvId = $fila['PrvId'];
			
			$this->OvvId = $fila['OvvId'];	
					
			$this->GreDestinatarioNombre = $fila['GreDestinatarioNombre'];	
			$this->GreDestinatarioNumeroDocumento1 = $fila['GreDestinatarioNumeroDocumento1'];
			$this->GreDestinatarioNumeroDocumento2 = $fila['GreDestinatarioNumeroDocumento2'];
			
			$this->GreFechaEmision = $fila['NGreFechaEmision'];	
			$this->GreHoraInicioTraslado = $fila['NGreHoraInicioTraslado'];	
			$this->GreFechaInicioTraslado = $fila['NGreFechaInicioTraslado'];	
			
			$this->GrePuntoPartida = $fila['GrePuntoPartida'];
			$this->GrePuntoPartidaDepartamento = $fila['GrePuntoPartidaDepartamento'];
			$this->GrePuntoPartidaProvincia = $fila['GrePuntoPartidaProvincia'];
			$this->GrePuntoPartidaDistrito = $fila['GrePuntoPartidaDistrito'];	
	
			$this->GrePuntoLlegada = $fila['GrePuntoLlegada'];	
			$this->GrePuntoLlegadaDepartamento = $fila['GrePuntoLlegadaDepartamento'];	
			$this->GrePuntoLlegadaProvincia = $fila['GrePuntoLlegadaProvincia'];	
			$this->GrePuntoLlegadaDistrito = $fila['GrePuntoLlegadaDistrito'];	
			
			$this->GrePuntoPartidaCodigoUbigeo = $fila['GrePuntoPartidaCodigoUbigeo'];	
			$this->GrePuntoLlegadaCodigoUbigeo = $fila['GrePuntoLlegadaCodigoUbigeo'];	
			
			$this->GreNumeroRegistro = $fila['GreNumeroRegistro'];	
			$this->GreNumeroConstanciaInscripcion = $fila['GreNumeroConstanciaInscripcion'];	
			$this->GreChofer = $fila['GreChofer'];
			$this->GreChoferNumeroDocumento = $fila['GreChoferNumeroDocumento'];	
			
			$this->GreNumeroLicenciaConducir = $fila['GreNumeroLicenciaConducir'];	
			$this->GreMarca = $fila['GreMarca'];	
			$this->GrePlaca = $fila['GrePlaca'];	
			$this->GreMotivoTraslado = $fila['GreMotivoTraslado'];	
			$this->GreMotivoTrasladoOtro = $fila['GreMotivoTrasladoOtro'];	
			$this->GreMotivoTrasladoCodigo = $fila['GreMotivoTrasladoCodigo'];
			$this->GreMotivoTrasladoDescripcion = $fila['GreMotivoTrasladoDescripcion'];
			
			$this->GreComprobantePagoNumero = $fila['GreComprobantePagoNumero'];	

			$this->GreObservacion = $fila['GreObservacion']; 
			$this->GreObservacionImpresa = $fila['GreObservacionImpresa']; 

			$this->GreSunatRespuestaTicket = $fila['GreSunatRespuestaTicket']; 	
			$this->GreSunatRespuestaTicketEstado = $fila['GreSunatRespuestaTicketEstado']; 			
			$this->GreSunatRespuestaObservacion = $fila['GreSunatRespuestaObservacion']; 	
			
			$this->GreSunatRespuestaEnvioTicket = $fila['GreSunatRespuestaEnvioTicket']; 	
			$this->GreSunatRespuestaEnvioTicketEstado = $fila['GreSunatRespuestaEnvioTicketEstado']; 	
			$this->GreSunatRespuestaEnvioFecha = $fila['NGreSunatRespuestaEnvioFecha']; 	
			$this->GreSunatRespuestaEnvioHora = $fila['GreSunatRespuestaEnvioHora']; 	
			$this->GreSunatRespuestaEnvioCodigo = $fila['GreSunatRespuestaEnvioCodigo']; 	
			$this->GreSunatRespuestaEnvioContenido = $fila['GreSunatRespuestaEnvioContenido']; 	
			
			$this->GreSunatRespuestaBajaTicket = $fila['GreSunatRespuestaBajaTicket']; 	
			$this->GreSunatRespuestaBajaTicketEstado = $fila['GreSunatRespuestaBajaTicketEstado']; 				
			$this->GreSunatRespuestaBajaFecha = $fila['NGreSunatRespuestaBajaFecha']; 	
			$this->GreSunatRespuestaBajaHora = $fila['GreSunatRespuestaBajaHora']; 				
			$this->GreSunatRespuestaBajaCodigo = $fila['GreSunatRespuestaBajaCodigo']; 	
			$this->GreSunatRespuestaBajaContenido = $fila['GreSunatRespuestaBajaContenido']; 	
			$this->GreSunatRespuestaBajaId = $fila['GreSunatRespuestaBajaId']; 	
			
			$this->GreSunatRespuestaConsultaCodigo = $fila['GreSunatRespuestaConsultaCodigo']; 	
			$this->GreSunatRespuestaConsultaContenido = $fila['GreSunatRespuestaConsultaContenido']; 	
			$this->GreSunatRespuestaConsultaFecha = $fila['NGreSunatRespuestaConsultaFecha']; 	
			$this->GreSunatRespuestaConsultaHora = $fila['GreSunatRespuestaConsultaHora']; 	
			
			$this->GreSunatRespuestaEnvioTiempoCreacion = $fila['NGreSunatRespuestaEnvioTiempoCreacion']; 	
			$this->GreSunatRespuestaConsultaTiempoCreacion = $fila['NGreSunatRespuestaConsultaTiempoCreacion']; 	
			$this->GreSunatRespuestaBajaTiempoCreacion = $fila['NGreSunatRespuestaBajaTiempoCreacion']; 	
			
			$this->GreSunatRespuestaEnvioDigestValue = $fila['GreSunatRespuestaEnvioDigestValue']; 	
			$this->GreSunatRespuestaEnvioSignatureValue = $fila['GreSunatRespuestaEnvioSignatureValue']; 	
			
			$this->GreSunatUltimaAccion = $fila['GreSunatUltimaAccion']; 	
			$this->GreSunatUltimaRespuesta = $fila['GreSunatUltimaRespuesta']; 	
			
			
			$this->GreEstado = $fila['GreEstado']; 
			$this->GreCierre = $fila['GreCierre']; 						
			$this->GreTiempoCreacion = $fila['NGreTiempoCreacion'];
			$this->GreTiempoModificacion = $fila['NGreTiempoModificacion']; 

			$this->GrtNumero = $fila['GrtNumero']; 
			
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
			$this->CliNombre = $fila['CliNombre']; 
			$this->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
			$this->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
			$this->CliNumeroDocumento = $fila['CliNumeroDocumento']; 
			$this->TdoCodigo = $fila['TdoCodigo']; 
			$this->TdoNombre = $fila['TdoNombre']; 
		
			$this->PrvNombre = $fila['PrvNombre']; 
			$this->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 
			
			$this->GreVehiculo = $fila['GreVehiculo']; 	
			
			$this->OrdenVentaVehiculoEinVIN = $fila['OrdenVentaVehiculoEinVIN']; 	
			$this->OrdenVentaVehiculoEinNumeroMotor = $fila['OrdenVentaVehiculoEinNumeroMotor']; 	
			$this->OrdenVentaVehiculoEinAnoFabricacion = $fila['OrdenVentaVehiculoEinAnoFabricacion']; 	
			$this->OrdenVentaVehiculoEinColor = $fila['OrdenVentaVehiculoEinColor']; 	
			$this->OrdenVentaVehiculoEinDUA = $fila['OrdenVentaVehiculoEinDUA']; 	
			
			$this->OrdenVentaVehiculoVmaNombre = $fila['OrdenVentaVehiculoVmaNombre']; 	
			$this->OrdenVentaVehiculoVmoNombre = $fila['OrdenVentaVehiculoVmoNombre']; 	
			$this->OrdenVentaVehiculoVveNombre = $fila['OrdenVentaVehiculoVveNombre']; 	
			
			$this->VveCaracteristica1 = $fila['VveCaracteristica1']; 	
			$this->VveCaracteristica2 = $fila['VveCaracteristica2'];
			$this->VveCaracteristica3 = $fila['VveCaracteristica3']; 	
			$this->VveCaracteristica4 = $fila['VveCaracteristica4']; 	
			$this->VveCaracteristica5 = $fila['VveCaracteristica5']; 	
			$this->VveCaracteristica6 = $fila['VveCaracteristica6']; 	
			$this->VveCaracteristica7 = $fila['VveCaracteristica7']; 	
			$this->VveCaracteristica8 = $fila['VveCaracteristica8']; 	
			$this->VveCaracteristica9 = $fila['VveCaracteristica9']; 	
			$this->VveCaracteristica10 = $fila['VveCaracteristica10']; 	
			$this->VveCaracteristica11 = $fila['VveCaracteristica11']; 	
			$this->VveCaracteristica12 = $fila['VveCaracteristica12']; 	
			$this->VveCaracteristica13 = $fila['VveCaracteristica13']; 	
			$this->VveCaracteristica14 = $fila['VveCaracteristica14']; 	
			$this->VveCaracteristica15 = $fila['VveCaracteristica15']; 	
			$this->VveCaracteristica16 = $fila['VveCaracteristica16']; 	
			$this->VveCaracteristica17 = $fila['VveCaracteristica17']; 
			
			$this->GrePesoTotal = $fila['GrePesoTotal']; 
			$this->GreTotalPaquetes = $fila['GreTotalPaquetes']; 	
			
			$this->TdoNombreProveedor = $fila['TdoNombreProveedor']; 	
			$this->ScaNombre = $fila['ScaNombre']; 	
		
			switch($this->GreEstado){
				case 1:
					$this->GreEstadoDescripcion = "Pendiente";
				break;
				
				case 5:
					$this->GreEstadoDescripcion = "Entregado";
				break;
				
				case  6:
					$this->GreEstadoDescripcion = "Anulado";
				break;
			}


		//	/*
//			01 venta
//			14 venta sujeta a confirmacion del comprador
//			02 compra
//			04 traslado entre establecimientos de la misma empresa
//			18 traslado emisor itinerante cp
//			08 importacion
//			09 exportacion
//			19 traslado a zona primaria
//			13 otros
//			*/
//			switch($InsGuiaRemision->GreMotivoTraslado){
//				
//				case 1://Venta
//					$InsGuiaRemision->GreMotivoTrasladoDescripcion = "VENTA";
//				break;
//				
//				case 2://Venta sujeto a confirmar
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "VENTA SUJETA A CONFIRMACION DEL COMPRADOR";
//				break;
//				
//				case 3://Compra
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "COMPRA";
//				break;
//				
//				case 4://Consignacion
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "OTROS";
//				break;
//				
//				case 5://Devolucion
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "OTROS";
//				break;
//				
//				case 6://Entre establecimientos
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA";
//				break;
//				
//				case 7://Para Transformación
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//				break;
//				
//				case 8://Recojo de Bienes transformados
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//				break;
//				
//				case 9://Emisor Itinerante
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "18";
//				break;
//				
//				case 10://Emisor Itinerante
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "19";
//				break;
//				
//				case 11://Importación
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "08";
//				break;
//				
//				case 12://Exportación
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "09";
//				break;
//				
//				case 13:// Venta con Entrega a Terceros
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//				break;
//				
//				case 14://Otros
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//				break;
//				
//				default:
//					$InsGuiaRemision->GreMotivoTrasladoCodigo = "13";
//				break;
//				
//			}
//	
	
	
                         
			$InsGuiaRemisionDetalle = new ClsGuiaRemisionDetalle();
			$ResGuiaRemisionDetalle =  $InsGuiaRemisionDetalle->MtdObtenerGuiaRemisionDetalles(NULL,NULL,"GrdId","ASC",NULL,$this->GreId,$this->GrtId);
			$this->GuiaRemisionDetalle = $ResGuiaRemisionDetalle['Datos'];
			
			
			//MtdObtenerGuiaRemisionAlmacenMovimientos($oCampo=NULL,$oFiltro=NULL,$oOrden = 'GamId',$oSentido = 'Desc',$oPaginacion = '0,10',$oGuiaRemision=NULL,$oTalonario=NULL) 
			
			$InsGuiaRemisionAlmacenMovimiento = new ClsGuiaRemisionAlmacenMovimiento();
			$ResGuiaRemisionAlmacenMovimiento =  $InsGuiaRemisionAlmacenMovimiento->MtdObtenerGuiaRemisionAlmacenMovimientos(NULL,NULL,"GamId","ASC",NULL,$this->GreId,$this->GrtId);
			$this->GuiaRemisionAlmacenMovimiento = $ResGuiaRemisionAlmacenMovimiento['Datos'];
			
			

		}
        
			$Respuesta =  $this;
			
		}else{
			$Respuesta =   NULL;
		}
		
        
		return $Respuesta;

    }

    public function MtdObtenerGuiaRemisiones($oCampo=NULL,$oCondicion=NULL,$oFiltro=NULL,$oOrden = 'GreId',$oSentido = 'Desc',$oPaginacion = '0,10',$oEstado=NULL,$oFechaInicio=NULL,$oFechaFin=NULL,$oTalonario=NULL,$oAlmacenMovimiento=NULL,$oVehiculoMovimiento=NULL) {
	
	
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
					gam.GreId
					FROM tblgamguiaremisionalmacenmovimiento gam
						WHERE (gam.AmoId LIKE "%'.$oFiltro.'%" OR gam.VmvId LIKE "%'.$oFiltro.'%")
							AND gam.GreId = gre.GreId 
							AND gam.GrtId = gre.GrtId
					) ';
					
					
					
				$filtrar .= '  ) ';

		}
		
	

		if(!empty($oOrden)){
			$orden = ' ORDER BY '.($oOrden).' '.($oSentido);
		}

		if(!empty($oPaginacion)){
			$paginacion = ' LIMIT '.($oPaginacion);
		}

		
		if(!empty($oSucursal)){
			$sucursal = ' AND grt.SucId = "'.$oSucursal.'"';
		}
			
		if(!empty($oEstado)){

			$elementos = explode(",",$oEstado);

				$i=1;
				$estado .= ' AND (';
				$elementos = array_filter($elementos);
				foreach($elementos as $elemento){
						$estado .= '  (gre.GreEstado = "'.($elemento).'")';	
						if($i<>count($elementos)){						
							$estado .= ' OR ';	
						}
				$i++;		
				}
				
				$estado .= ' ) ';

		}

		if(!empty($oFechaInicio)){
			
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gre.GreFechaInicioTraslado)>="'.$oFechaInicio.'" AND DATE(gre.GreFechaInicioTraslado)<="'.$oFechaFin.'"';
			}else{
				$fecha = ' AND DATE(gre.GreFechaInicioTraslado)>="'.$oFechaInicio.'"';
			}
			
		}else{
			if(!empty($oFechaFin)){
				$fecha = ' AND DATE(gre.GreFechaInicioTraslado)<="'.$oFechaFin.'"';		
			}			
		}
		
		if(!empty($oTalonario)){
			$talonario = ' AND gre.GrtId = "'.$oTalonario.'"';
		}
				
		if(!empty($oAlmacenMovimiento)){

			$amovimiento = ' AND EXISTS (
				SELECT gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
					WHERE (
					gam.GreId = gre.GreId AND
					gam.GrtId = gre.GrtId)
					AND gam.AmoId = "'.$oAlmacenMovimiento.'"
				LIMIT 1
			) ';
		}	
		
		
		if(!empty($oVehiculoMovimiento)){

			$vmovimiento = ' AND EXISTS (
				SELECT gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
					WHERE (
					gam.GreId = gre.GreId AND
					gam.GrtId = gre.GrtId)
					AND gam.VmvId = "'.$oVehiculoMovimiento.'"
				LIMIT 1
			) ';
		}	


			$sql = 'SELECT
				SQL_CALC_FOUND_ROWS 
				gre.GreId,
				gre.GrtId,
				gre.UsuId,

				gre.CliId,
				gre.PrvId,
				
				gre.OvvId,
				
				gre.GreDestinatarioNombre,
				gre.GreDestinatarioNumeroDocumento1,
				gre.GreDestinatarioNumeroDocumento2,
				
				
				DATE_FORMAT(gre.GreFechaEmision, "%d/%m/%Y") AS "NGreFechaEmision",
				DATE_FORMAT(gre.GreFechaInicioTraslado, "%d/%m/%Y") AS "NGreFechaInicioTraslado",
				
				gre.GrePuntoPartida,
				gre.GrePuntoPartidaDepartamento,
				gre.GrePuntoPartidaProvincia,
				gre.GrePuntoPartidaDistrito,
				
				gre.GrePuntoLlegada,
				gre.GrePuntoLlegadaDepartamento,
				gre.GrePuntoLlegadaProvincia,
				gre.GrePuntoLlegadaDistrito,
					
				gre.GrePuntoPartidaCodigoUbigeo,
				gre.GrePuntoLlegadaCodigoUbigeo,
				
				gre.GreNumeroRegistro,
				gre.GreNumeroConstanciaInscripcion,
				gre.GreChofer,
				gre.GreChoferNumeroDocumento,
				
				gre.GreNumeroLicenciaConducir,
				gre.GreMarca,
				gre.GrePlaca,
				gre.GreMotivoTraslado,
				gre.GreMotivoTrasladoOtro,
				gre.GreMotivoTrasladoCodigo,
				gre.GreMotivoTrasladoDescripcion,
				
				gre.GreComprobantePagoNumero,
				
				

				gre.GreObservacion,
				gre.GreObservacionImpresa,
				
					gre.GreSunatRespuestaTicket,
				gre.GreSunatRespuestaTicketEstado,
				gre.GreSunatRespuestaObservacion,
				
				gre.GreSunatRespuestaEnvioTicket,
				gre.GreSunatRespuestaEnvioTicketEstado,
				DATE_FORMAT(gre.GreSunatRespuestaEnvioFecha, "%d/%m/%Y") AS "NGreSunatRespuestaEnvioFecha",
				gre.GreSunatRespuestaEnvioHora,
				gre.GreSunatRespuestaEnvioCodigo,
				gre.GreSunatRespuestaEnvioContenido,
				
				gre.GreSunatRespuestaBajaTicket,
				gre.GreSunatRespuestaBajaTicketEstado,
				DATE_FORMAT(gre.GreSunatRespuestaBajaFecha, "%d/%m/%Y") AS "NGreSunatRespuestaBajaFecha",
				gre.GreSunatRespuestaBajaHora,
				gre.GreSunatRespuestaBajaCodigo,
				gre.GreSunatRespuestaBajaContenido,
				gre.GreSunatRespuestaBajaId,
				
				gre.GreSunatRespuestaConsultaCodigo,
				gre.GreSunatRespuestaConsultaContenido,
				DATE_FORMAT(gre.GreSunatRespuestaConsultaFecha, "%d/%m/%Y") AS "NGreSunatRespuestaConsultaFecha",
				gre.GreSunatRespuestaConsultaHora,
				
				DATE_FORMAT(gre.GreSunatRespuestaEnvioTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreSunatRespuestaEnvioTiempoCreacion",
				DATE_FORMAT(gre.GreSunatRespuestaConsultaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreSunatRespuestaConsultaTiempoCreacion",
				DATE_FORMAT(gre.GreSunatRespuestaBajaTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreSunatRespuestaBajaTiempoCreacion",
				
				gre.GreSunatUltimaAccion,
				gre.GreSunatUltimaRespuesta,
				
				gre.GreSunatRespuestaEnvioDigestValue,
				gre.GreSunatRespuestaEnvioSignatureValue,
				
				gre.GrePesoTotal,
				gre.GreTotalPaquetes,
				
				
			
			
				gre.GreEstado,			
				gre.GreCierre,
				DATE_FORMAT(gre.GreTiempoCreacion, "%d/%m/%Y %H:%i:%s") AS "NGreTiempoCreacion",
                DATE_FORMAT(gre.GreTiempoModificacion, "%d/%m/%Y %H:%i:%s") AS "NGreTiempoModificacion",

				(SELECT COUNT(grd.GrdId) FROM tblgrdguiaremisiondetalle grd WHERE grd.GreId = gre.GreId AND grd.GrtId = gre.GrtId ) AS "GreTotalItems",
				

				CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
					WHERE gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId 
					AND gam.AmoId IS NOT NULL
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS GreAlmacenMovimiento,
				
				
				CASE
				WHEN EXISTS (
					SELECT 
					gam.GamId
					FROM tblgamguiaremisionalmacenmovimiento gam
					WHERE gam.GreId = gre.GreId AND gam.GrtId = gre.GrtId 
					AND gam.VmvId IS NOT NULL
					
					LIMIT 1
				) THEN "Si"
				ELSE "No"
				END AS GreVehiculoMovimiento,
				
				
				grt.GrtNumero,
				
				cli.CliNombre,
					
				cli.CliApellidoPaterno,
				cli.CliApellidoMaterno,
				
				cli.CliNumeroDocumento,
				
				prv.PrvNombre,
				prv.PrvNumeroDocumento

				FROM tblgreguiaremision gre

					LEFT JOIN tblgrtguiaremisiontalonario grt
					ON gre.GrtId = grt.GrtId
						LEFT JOIN tblclicliente cli
						ON gre.CliId = cli.CliId
							LEFT JOIN tblprvproveedor prv
							ON gre.PrvId = prv.PrvId
				
				
				
				WHERE 1 = 1 '.$filtrar.$sucursal.$vmovimiento.$estado.$fecha.$talonario.$amovimiento.$orden.$paginacion;
						
											
			$resultado = $this->InsMysql->MtdConsultar($sql);            

			$Respuesta['Datos'] = array();
			
            $InsGuiaRemision = get_class($this);
	
				while( $fila = $this->InsMysql->MtdObtenerDatos($resultado)){

					$GuiaRemision = new $InsGuiaRemision();             
			   
					$GuiaRemision->GreId = $fila['GreId'];
					$GuiaRemision->GrtId = $fila['GrtId'];
					$GuiaRemision->UsuId = $fila['UsuId'];

					$GuiaRemision->CliId = $fila['CliId'];
					$GuiaRemision->PrvId = $fila['PrvId'];
					
					$GuiaRemision->OvvId = $fila['OvvId'];
					
					$GuiaRemision->GreDestinatarioNombre = $fila['GreDestinatarioNombre'];
					$GuiaRemision->GreDestinatarioNumeroDocumento1 = $fila['GreDestinatarioNumeroDocumento1'];
					$GuiaRemision->GreDestinatarioNumeroDocumento2 = $fila['GreDestinatarioNumeroDocumento2'];
					
					$GuiaRemision->GreFechaEmision = $fila['NGreFechaEmision'];
					$GuiaRemision->GreFechaInicioTraslado = $fila['NGreFechaInicioTraslado'];
					
					$GuiaRemision->GrePuntoPartida = $fila['GrePuntoPartida'];
					$GuiaRemision->GrePuntoPartidaDepartamento = $fila['GrePuntoPartidaDepartamento'];
					$GuiaRemision->GrePuntoPartidaProvincia = $fila['GrePuntoPartidaProvincia'];
					$GuiaRemision->GrePuntoPartidaDistrito = $fila['GrePuntoPartidaDistrito'];
					
					$GuiaRemision->GrePuntoLlegada = $fila['GrePuntoLlegada'];
					$GuiaRemision->GrePuntoLlegadaDepartamento = $fila['GrePuntoLlegadaDepartamento'];
					$GuiaRemision->GrePuntoLlegadaProvincia = $fila['GrePuntoLlegadaProvincia'];
					$GuiaRemision->GrePuntoLlegadaDistrito = $fila['GrePuntoLlegadaDistrito'];
					
					$GuiaRemision->GrePuntoPartidaCodigoUbigeo = $fila['GrePuntoPartidaCodigoUbigeo'];
					$GuiaRemision->GrePuntoLlegadaCodigoUbigeo = $fila['GrePuntoLlegadaCodigoUbigeo'];
					
					$GuiaRemision->GreNumeroRegistro = $fila['GreNumeroRegistro'];
					$GuiaRemision->GreNumeroConstanciaInscripcion = $fila['GreNumeroConstanciaInscripcion'];
					$GuiaRemision->GreChofer = $fila['GreChofer'];
					$GuiaRemision->GreChoferNumeroDocumento = $fila['GreChoferNumeroDocumento'];
					$GuiaRemision->GreNumeroLicenciaConducir = $fila['GreNumeroLicenciaConducir'];
					
					$GuiaRemision->GreMarca = $fila['GreMarca'];
					$GuiaRemision->GrePlaca = $fila['GrePlaca'];
					$GuiaRemision->GreMotivoTraslado = $fila['GreMotivoTraslado'];
					$GuiaRemision->GreMotivoTrasladoOtro = $fila['GreMotivoTrasladoOtro'];
					$GuiaRemision->GreMotivoTrasladoCodigo = $fila['GreMotivoTrasladoCodigo'];
					$GuiaRemision->GreMotivoTrasladoDescripcion = $fila['GreMotivoTrasladoDescripcion'];
					
					$GuiaRemision->GreComprobantePagoNumero = $fila['GreComprobantePagoNumero'];
					
					$GuiaRemision->GreObservacion = $fila['GreObservacion'];
					$GuiaRemision->GreObservacionImpresa = $fila['GreObservacionImpresa'];

					$GuiaRemision->GreSunatRespuestaTicket = $fila['GreSunatRespuestaTicket']; 	
					$GuiaRemision->GreSunatRespuestaTicketEstado = $fila['GreSunatRespuestaTicketEstado']; 			
					$GuiaRemision->GreSunatRespuestaObservacion = $fila['GreSunatRespuestaObservacion']; 	
					
					$GuiaRemision->GreSunatRespuestaEnvioTicket = $fila['GreSunatRespuestaEnvioTicket']; 	
					$GuiaRemision->GreSunatRespuestaEnvioTicketEstado = $fila['GreSunatRespuestaEnvioTicketEstado']; 	
					$GuiaRemision->GreSunatRespuestaEnvioFecha = $fila['NGreSunatRespuestaEnvioFecha']; 	
					$GuiaRemision->GreSunatRespuestaEnvioHora = $fila['GreSunatRespuestaEnvioHora']; 	
					$GuiaRemision->GreSunatRespuestaEnvioCodigo = $fila['GreSunatRespuestaEnvioCodigo']; 	
					$GuiaRemision->GreSunatRespuestaEnvioContenido = $fila['GreSunatRespuestaEnvioContenido']; 	
					
					$GuiaRemision->GreSunatRespuestaBajaTicket = $fila['GreSunatRespuestaBajaTicket']; 	
					$GuiaRemision->GreSunatRespuestaBajaTicketEstado = $fila['GreSunatRespuestaBajaTicketEstado']; 				
					$GuiaRemision->GreSunatRespuestaBajaFecha = $fila['NGreSunatRespuestaBajaFecha']; 	
					$GuiaRemision->GreSunatRespuestaBajaHora = $fila['GreSunatRespuestaBajaHora']; 				
					$GuiaRemision->GreSunatRespuestaBajaCodigo = $fila['GreSunatRespuestaBajaCodigo']; 	
					$GuiaRemision->GreSunatRespuestaBajaContenido = $fila['GreSunatRespuestaBajaContenido']; 	
					$GuiaRemision->GreSunatRespuestaBajaId = $fila['GreSunatRespuestaBajaId']; 	
					
					$GuiaRemision->GreSunatRespuestaConsultaCodigo = $fila['GreSunatRespuestaConsultaCodigo']; 	
					$GuiaRemision->GreSunatRespuestaConsultaContenido = $fila['GreSunatRespuestaConsultaContenido']; 	
					$GuiaRemision->GreSunatRespuestaConsultaFecha = $fila['NGreSunatRespuestaConsultaFecha']; 	
					$GuiaRemision->GreSunatRespuestaConsultaHora = $fila['GreSunatRespuestaConsultaHora']; 	
					
					$GuiaRemision->GreSunatRespuestaEnvioTiempoCreacion = $fila['NGreSunatRespuestaEnvioTiempoCreacion']; 	
					$GuiaRemision->GreSunatRespuestaConsultaTiempoCreacion = $fila['NGreSunatRespuestaConsultaTiempoCreacion']; 	
					$GuiaRemision->GreSunatRespuestaBajaTiempoCreacion = $fila['NGreSunatRespuestaBajaTiempoCreacion']; 	
					
					$GuiaRemision->GreSunatRespuestaEnvioDigestValue = $fila['GreSunatRespuestaEnvioDigestValue']; 	
					$GuiaRemision->GreSunatRespuestaEnvioSignatureValue = $fila['GreSunatRespuestaEnvioSignatureValue']; 	
					
					$GuiaRemision->GreSunatUltimaAccion = $fila['GreSunatUltimaAccion']; 	
					$GuiaRemision->GreSunatUltimaRespuesta = $fila['GreSunatUltimaRespuesta']; 	
			
					$GuiaRemision->GrePesoTotal = $fila['GrePesoTotal']; 
					$GuiaRemision->GreTotalPaquetes = $fila['GreTotalPaquetes']; 	
			
					$GuiaRemision->GreEstado = $fila['GreEstado'];
					$GuiaRemision->GreCierre = $fila['GreCierre']; 						
					$GuiaRemision->GreTiempoCreacion = $fila['NGreTiempoCreacion'];
					$GuiaRemision->GreTiempoModificacion = $fila['NGreTiempoModificacion']; 
					
					$GuiaRemision->GreTotalItems = $fila['GreTotalItems']; 					
					$GuiaRemision->GreAlmacenMovimiento = $fila['GreAlmacenMovimiento']; 					
					$GuiaRemision->GreVehiculoMovimiento = $fila['GreVehiculoMovimiento']; 		

					$GuiaRemision->GrtNumero = $fila['GrtNumero']; 

					$GuiaRemision->CliNombre = $fila['CliNombre']; 
					$GuiaRemision->CliApellidoPaterno = $fila['CliApellidoPaterno']; 
					$GuiaRemision->CliApellidoMaterno = $fila['CliApellidoMaterno']; 
					
			
				
					$GuiaRemision->CliNumeroDocumento = $fila['CliNumeroDocumento']; 

					$GuiaRemision->PrvNombre = $fila['PrvNombre']; 
					$GuiaRemision->PrvNumeroDocumento = $fila['PrvNumeroDocumento']; 					
					
					

			switch($GuiaRemision->GreEstado){
				case 1:
					$GuiaRemision->GreEstadoDescripcion = "Pendiente";
				break;
				
				case 5:
					$GuiaRemision->GreEstadoDescripcion = "Entregado";
				break;
				
				case  6:
					$GuiaRemision->GreEstadoDescripcion = "Anulado";
				break;
			}


					$GuiaRemision->InsMysql = NULL;     
					               
					$Respuesta['Datos'][]= $GuiaRemision;
                }
			
			$filaTotal = $this->InsMysql->MtdConsultar('SELECT FOUND_ROWS() AS TOTAL',true); 
			 				
			$Respuesta['Total'] = $filaTotal['TOTAL'];
			$Respuesta['TotalSeleccionado'] = $this->InsMysql->MtdObtenerDatosTotal($resultado);
			
			return $Respuesta;			
		}
		
		
	


	public function MtdActualizarEstadoGuiaRemision($oElementos,$oEstado,$oTransaccion=true) {
		
		
		$elementos = explode("#",$oElementos);
		
		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();	
		}
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){

					$aux = explode("%",$elemento);

					$sql = 'UPDATE tblgreguiaremision SET GreEstado = '.$oEstado.' WHERE   (GreId = "'.($aux[0]).'" AND GrtId = "'.($aux[1]).'")';

					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        

					if(!$resultado) {						
						$error = true;
					}else{
						$this->GreId = $aux[0];
						$this->GrtId = $aux[1];
						$this->MtdAuditarGuiaRemision(2,"Se actualizo el Estado de la Guia de Remision",$aux);	
					}
				}
			$i++;
	
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

	
	//Accion eliminar	 
	
	public function MtdEliminarGuiaRemision($oElementos,$oTransaccion=true) {
		
		$elementos = explode("#",$oElementos);

		if($oTransaccion){
			$this->InsMysql->MtdTransaccionIniciar();	
		}
		
			$i=1;
			foreach($elementos as $elemento){
				if(!empty($elemento)){
				
					$aux = explode("%",$elemento);
					
					$sql = 'DELETE FROM tblgreguiaremision WHERE (GreId = "'.($aux[0]).'" AND GrtId = "'.($aux[1]).'")';
				
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
						
					if(!$resultado) {						
						$error = true;
					}else{
						$this->GreId = $aux[0];
						$this->GrtId = $aux[1];
						$this->MtdAuditarGuiaRemision(3,"Se elimino la Guia de Remision",$aux);	
					}
				}
			$i++;
	
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
	
	
	public function MtdRegistrarGuiaRemision() {

		global $Resultado;
		$error = false;

			$this->GreId = trim($this->GreId);	
	
			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}

/*
				$InsCliente = new ClsCliente();	
	
				$InsCliente->CliId = $this->CliId;
				$InsCliente->TdoId = "TDO-10003";
				$InsCliente->CliNombre = $this->CliNombre;
				$InsCliente->CliApellidoPaterno = $this->CliApellidoPaterno;
				$InsCliente->CliApellidoMaterno = $this->CliApellidoMaterno;
				$InsCliente->CliNumeroDocumento = $this->CliNumeroDocumento;
				$InsCliente->CliTelefono = $this->CliTelefono;
				$InsCliente->CliEmail = $this->CliEmail;
				$InsCliente->CliCelular = $this->CliCelular;
				$InsCliente->CliFax = $this->CliFax;
				$InsCliente->CliEstado = 1;//En actividad
				$InsCliente->CliTiempoCreacion = date("Y-m-d H:i:s");
				$InsCliente->CliTiempoModificacion = date("Y-m-d H:i:s");
				$InsCliente->CliEliminado = 1;
			
				if(empty($InsCliente->CliId)){
					
					$InsCliente->MtdVerificarExisteCliente();

					if(empty($InsCliente->CliId)){
						$InsCliente->MtdGenerarClienteId();	
						if(!$InsCliente->MtdRegistrarCliente2()){
							$error = true;
							$Resultado.='#ERR_GRE_301';
						}else{
							$this->CliId = $InsCliente->CliId;									
						}		
					}else{
						$this->CliId = $InsCliente->CliId;
					}
					
				}else{
					if(!$InsCliente->MtdEditarCliente2()){
						$error = true;					
						$Resultado.='#ERR_GRE_302';
					}
				}	*/	
			
				$sql = 'INSERT INTO tblgreguiaremision (
				GreId,
				GrtId,
				UsuId,

				CliId,
				PrvId,

			
				OvvId,
				
				GreDestinatarioNombre,
				GreDestinatarioNumeroDocumento1,
				GreDestinatarioNumeroDocumento2,
				
				GreFechaEmision,
				GreFechaInicioTraslado,
				
				GrePuntoPartida,
				GrePuntoPartidaDepartamento,
				GrePuntoPartidaProvincia,
				GrePuntoPartidaDistrito,
				
				GrePuntoLlegada,
				GrePuntoLlegadaDepartamento,
				GrePuntoLlegadaProvincia,
				GrePuntoLlegadaDistrito,
								
				GrePuntoPartidaCodigoUbigeo,
				GrePuntoLlegadaCodigoUbigeo,	
				
				GreNumeroRegistro,
				GreNumeroConstanciaInscripcion,
				GreChofer,
				GreChoferNumeroDocumento,
				
				GreNumeroLicenciaConducir,
				GreMarca,
				GrePlaca,
			
				GreMotivoTrasladoCodigo,
				
				GreComprobantePagoNumero,

				GreObservacion,
				GreObservacionImpresa,
				
				GrePesoTotal,
				GreTotalPaquetes,
			
				GreEstado,
				GreCierre,
				GreTiempoCreacion,
				GreTiempoModificacion
				
				) 
				VALUES (
				"'.($this->GreId).'", 
				"'.($this->GrtId).'",
				"'.($this->UsuId).'",
				'.(empty($this->CliId)?'NULL, ':'"'.$this->CliId.'",').'
				'.(empty($this->PrvId)?'NULL, ':'"'.$this->PrvId.'",').'
				
				'.(empty($this->OvvId)?'NULL, ':'"'.$this->OvvId.'",').'
				
				
				"'.($this->GreDestinatarioNombre).'",
				"'.($this->GreDestinatarioNumeroDocumento1).'",
				"'.($this->GreDestinatarioNumeroDocumento2).'",
				
				'.(empty($this->GreFechaEmision)?'NULL, ':'"'.$this->GreFechaEmision.'",').'
				"'.($this->GreFechaInicioTraslado).'",
				
				"'.($this->GrePuntoPartida).'",
				"'.($this->GrePuntoPartidaDepartamento).'",
				"'.($this->GrePuntoPartidaProvincia).'",
				"'.($this->GrePuntoPartidaDistrito).'",
				
				"'.($this->GrePuntoLlegada).'",
				"'.($this->GrePuntoLlegadaDepartamento).'",
				"'.($this->GrePuntoLlegadaProvincia).'",
				"'.($this->GrePuntoLlegadaDistrito).'",
				
				"'.($this->GrePuntoPartidaCodigoUbigeo).'",
				"'.($this->GrePuntoLlegadaCodigoUbigeo).'",
				
				"'.($this->GreNumeroRegistro).'",
				"'.($this->GreNumeroConstanciaInscripcion).'",
				"'.($this->GreChofer).'",
				"'.($this->GreChoferNumeroDocumento).'",
				
				"'.($this->GreNumeroLicenciaConducir).'",
				"'.($this->GreMarca).'",
				"'.($this->GrePlaca).'",
				
				"'.($this->GreMotivoTrasladoCodigo).'",
				
				"'.($this->GreComprobantePagoNumero).'",

				"'.($this->GreObservacion).'",
				"'.($this->GreObservacionImpresa).'",
				
					
				
				'.($this->GrePesoTotal).',
				'.($this->GreTotalPaquetes).',
				
				'.($this->GreEstado).',
				'.($this->GreCierre).',											
				"'.($this->GreTiempoCreacion).'", 
				"'.($this->GreTiempoModificacion).'");';
	
				
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
						
						switch($this->InsMysql->MtdObtenerErrorCodigo()){
							case 1062:					
								$Resultado.="#ERR_GRE_402";
							break;
						}
					} 
				}
			
				
				if(!$error){			
				
					if (!empty($this->GuiaRemisionDetalle)){		
							
						$validar = 0;				
						$InsGuiaRemisionDetalle = new ClsGuiaRemisionDetalle();		
								
						foreach ($this->GuiaRemisionDetalle as $DatGuiaRemisionDetalle){
							$InsGuiaRemisionDetalle->GreId = $this->GreId;
							$InsGuiaRemisionDetalle->GrtId = $this->GrtId;
					
							$InsGuiaRemisionDetalle->GrdCodigo = $DatGuiaRemisionDetalle->GrdCodigo;
							$InsGuiaRemisionDetalle->GrdDescripcion = $DatGuiaRemisionDetalle->GrdDescripcion;
							$InsGuiaRemisionDetalle->GrdCantidad = $DatGuiaRemisionDetalle->GrdCantidad;
							$InsGuiaRemisionDetalle->GrdUnidadMedida = $DatGuiaRemisionDetalle->GrdUnidadMedida;
							$InsGuiaRemisionDetalle->GrdPesoNeto = $DatGuiaRemisionDetalle->GrdPesoNeto;						
							$InsGuiaRemisionDetalle->GrdPesoTotal = $DatGuiaRemisionDetalle->GrdPesoTotal;						
	
							$InsGuiaRemisionDetalle->GrdEstado = $this->GreEstado;
							$InsGuiaRemisionDetalle->GrdTiempoCreacion = $DatGuiaRemisionDetalle->GrdTiempoCreacion;
							$InsGuiaRemisionDetalle->GrdTiempoModificacion = $DatGuiaRemisionDetalle->GrdTiempoModificacion;						
							$InsGuiaRemisionDetalle->GrdEliminado = $DatGuiaRemisionDetalle->GrdEliminado;
							
							if($InsGuiaRemisionDetalle->MtdRegistrarGuiaRemisionDetalle()){
								$validar++;					
							}else{
								$Resultado.='#ERR_GRE_201';
								$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->GuiaRemisionDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
				
				//deb($this->GuiaRemisionAlmacenMovimiento);
				
				if(!$error){			
				
					if (!empty($this->GuiaRemisionAlmacenMovimiento)){		
							
						$validar = 0;				
						$InsGuiaRemisionAlmacenMovimiento = new ClsGuiaRemisionAlmacenMovimiento();		
								
						foreach ($this->GuiaRemisionAlmacenMovimiento as $DatGuiaRemisionAlmacenMovimiento){
							
							$InsGuiaRemisionAlmacenMovimiento->GreId = $this->GreId;
							$InsGuiaRemisionAlmacenMovimiento->GrtId = $this->GrtId;
							$InsGuiaRemisionAlmacenMovimiento->AmoId = $DatGuiaRemisionAlmacenMovimiento->AmoId;
							$InsGuiaRemisionAlmacenMovimiento->VmvId = $DatGuiaRemisionAlmacenMovimiento->VmvId;							
										
							$InsGuiaRemisionAlmacenMovimiento->GamEstado = $DatGuiaRemisionAlmacenMovimiento->GamEstado;
							$InsGuiaRemisionAlmacenMovimiento->GamTiempoCreacion = $DatGuiaRemisionAlmacenMovimiento->GamTiempoCreacion;
							$InsGuiaRemisionAlmacenMovimiento->GamTiempoModificacion = $DatGuiaRemisionAlmacenMovimiento->GamTiempoModificacion;
							
							$InsGuiaRemisionAlmacenMovimiento->GamEliminado = $DatGuiaRemisionAlmacenMovimiento->GamEliminado;
							if($InsGuiaRemisionAlmacenMovimiento->MtdRegistrarGuiaRemisionAlmacenMovimiento()){
								$validar++;					
							}else{
								$Resultado.='#ERR_GRE_301';
								$Resultado.='#Item Numero: '.($validar+1);
							}
						}					
						
						if(count($this->GuiaRemisionAlmacenMovimiento) <> $validar ){
							$error = true;
						}					
									
					}				
				}
			
				
			
			
			if($error) {	
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionDeshacer();
				}
				return false;
			} else {				
				if($this->Transaccion){
					$this->InsMysql->MtdTransaccionHacer();
					
				}
				$this->MtdAuditarGuiaRemision(1,"Se registro la Guia de Remision",$this);
				return true;
			}			
			
	}
	
	public function MtdEditarGuiaRemision() {
		
		global $Resultado;	
		$error = false;					
	
			if($this->Transaccion){
				$this->InsMysql->MtdTransaccionIniciar();
			}

				$sql = 'UPDATE tblgreguiaremision SET 
				'.(empty($this->CliId)?'CliId = NULL, ':'CliId = "'.$this->CliId.'",').'
				'.(empty($this->PrvId)?'PrvId = NULL, ':'PrvId = "'.$this->PrvId.'",').'
				

				'.(empty($this->OvvId)?'OvvId = NULL, ':'OvvId = "'.$this->OvvId.'",').'
								
				GreDestinatarioNombre = "'.($this->GreDestinatarioNombre).'",
				GreDestinatarioNumeroDocumento1	= "'.($this->GreDestinatarioNumeroDocumento1).'",
				GreDestinatarioNumeroDocumento2	= "'.($this->GreDestinatarioNumeroDocumento2).'",
				
				'.(empty($this->GreFechaEmision)?'GreFechaEmision = NULL, ':'GreFechaEmision = "'.$this->GreFechaEmision.'",').'
				GreFechaInicioTraslado = "'.($this->GreFechaInicioTraslado).'",
				
				GrePuntoPartida = "'.($this->GrePuntoPartida).'",
				GrePuntoPartidaDepartamento = "'.($this->GrePuntoPartidaDepartamento).'",
				GrePuntoPartidaProvincia = "'.($this->GrePuntoPartidaProvincia).'",
				GrePuntoPartidaDistrito = "'.($this->GrePuntoPartidaDistrito).'",
				
				GrePuntoLlegada = "'.($this->GrePuntoLlegada).'",
				GrePuntoLlegadaDepartamento = "'.($this->GrePuntoLlegadaDepartamento).'",
				GrePuntoLlegadaProvincia = "'.($this->GrePuntoLlegadaProvincia).'",
				GrePuntoLlegadaDistrito = "'.($this->GrePuntoLlegadaDistrito).'",
				
				GrePuntoPartidaCodigoUbigeo = "'.($this->GrePuntoPartidaCodigoUbigeo).'",
				GrePuntoLlegadaCodigoUbigeo = "'.($this->GrePuntoLlegadaCodigoUbigeo).'",
				
				GreNumeroRegistro = "'.($this->GreNumeroRegistro).'",
				GreNumeroConstanciaInscripcion = "'.($this->GreNumeroConstanciaInscripcion).'",
				GreChofer = "'.($this->GreChofer).'",
				GreChoferNumeroDocumento = "'.($this->GreChoferNumeroDocumento).'",
				
				
				GreNumeroLicenciaConducir = "'.($this->GreNumeroLicenciaConducir).'",
				
				GreMarca = "'.($this->GreMarca).'",
				
				GrePlaca = "'.($this->GrePlaca).'",
				GreMotivoTrasladoCodigo = "'.($this->GreMotivoTrasladoCodigo).'",
				
				GreComprobantePagoNumero = "'.($this->GreComprobantePagoNumero).'",
				
				GreObservacion = "'.($this->GreObservacion).'",
				GreObservacionImpresa = "'.($this->GreObservacionImpresa).'",
				
				
				GrePesoTotal = '.($this->GrePesoTotal).',	
				GreTotalPaquetes = '.($this->GreTotalPaquetes).',	
				
				GreEstado = '.($this->GreEstado).',		
				GreTiempoModificacion = "'.($this->GreTiempoModificacion).'"			
				WHERE GreId = "'.($this->GreId).'" AND GrtId = "'.$this->GrtId.'";';
				
				if(!$error){
					$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
					if(!$resultado) {							
						$error = true;
					} 
				}
				
				
				if(!$error){
				
					if (!empty($this->GuiaRemisionDetalle)){		
							
							
						$validar = 0;				
						$InsGuiaRemisionDetalle = new ClsGuiaRemisionDetalle();		
								
						foreach ($this->GuiaRemisionDetalle as $DatGuiaRemisionDetalle){
																
							$InsGuiaRemisionDetalle->GrdId = $DatGuiaRemisionDetalle->GrdId;
							$InsGuiaRemisionDetalle->GreId = $this->GreId;
							$InsGuiaRemisionDetalle->GrtId = $this->GrtId;

							$InsGuiaRemisionDetalle->GrdCodigo = $DatGuiaRemisionDetalle->GrdCodigo;
							$InsGuiaRemisionDetalle->GrdDescripcion = $DatGuiaRemisionDetalle->GrdDescripcion;
							$InsGuiaRemisionDetalle->GrdCantidad = $DatGuiaRemisionDetalle->GrdCantidad;
							$InsGuiaRemisionDetalle->GrdUnidadMedida = $DatGuiaRemisionDetalle->GrdUnidadMedida;
							$InsGuiaRemisionDetalle->GrdPesoNeto = $DatGuiaRemisionDetalle->GrdPesoNeto;						
							$InsGuiaRemisionDetalle->GrdPesoTotal = $DatGuiaRemisionDetalle->GrdPesoTotal;						

							$InsGuiaRemisionDetalle->GrdTiempoCreacion = $DatGuiaRemisionDetalle->GrdTiempoCreacion;
							$InsGuiaRemisionDetalle->GrdTiempoModificacion = $DatGuiaRemisionDetalle->GrdTiempoModificacion;
							$InsGuiaRemisionDetalle->GrdEliminado = $DatGuiaRemisionDetalle->GrdEliminado;
							
							if(empty($InsGuiaRemisionDetalle->GrdId)){
								if($InsGuiaRemisionDetalle->GrdEliminado<>2){
									if($InsGuiaRemisionDetalle->MtdRegistrarGuiaRemisionDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_GRE_201';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}else{
									$validar++;
								}
							}else{						
								if($InsGuiaRemisionDetalle->GrdEliminado==2){
									if($InsGuiaRemisionDetalle->MtdEliminarGuiaRemisionDetalle($InsGuiaRemisionDetalle->GrdId)){
										$validar++;					
									}else{
										$Resultado.='#ERR_GRE_203';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}else{
									if($InsGuiaRemisionDetalle->MtdEditarGuiaRemisionDetalle()){
										$validar++;					
									}else{
										$Resultado.='#ERR_GRE_202';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}
							}									
						}
						
						
						if(count($this->GuiaRemisionDetalle) <> $validar ){
							$error = true;
						}					
									
					}				
				}
				
if(!$error){
				
					if (!empty($this->GuiaRemisionAlmacenMovimiento)){		
							
							
						$validar = 0;				
						$InsGuiaRemisionAlmacenMovimiento = new ClsGuiaRemisionAlmacenMovimiento();		
								
						foreach ($this->GuiaRemisionAlmacenMovimiento as $DatGuiaRemisionAlmacenMovimiento){
																
							$InsGuiaRemisionAlmacenMovimiento->GamId = $DatGuiaRemisionAlmacenMovimiento->GamId;
							$InsGuiaRemisionAlmacenMovimiento->GreId = $this->GreId;
							$InsGuiaRemisionAlmacenMovimiento->GrtId = $this->GrtId;
							
							$InsGuiaRemisionAlmacenMovimiento->AmoId = $DatGuiaRemisionAlmacenMovimiento->AmoId;
							$InsGuiaRemisionAlmacenMovimiento->VmvId = $DatGuiaRemisionAlmacenMovimiento->VmvId;
							
							$InsGuiaRemisionAlmacenMovimiento->GamEstado = $DatGuiaRemisionAlmacenMovimiento->GamEstado;
							$InsGuiaRemisionAlmacenMovimiento->GamTiempoCreacion = $DatGuiaRemisionAlmacenMovimiento->GamTiempoCreacion;
							$InsGuiaRemisionAlmacenMovimiento->GamTiempoModificacion = $DatGuiaRemisionAlmacenMovimiento->GamTiempoModificacion;
							
							
							$InsGuiaRemisionAlmacenMovimiento->GamEliminado = $DatGuiaRemisionAlmacenMovimiento->GamEliminado;
							
							if(empty($InsGuiaRemisionAlmacenMovimiento->GamId)){
								if($InsGuiaRemisionAlmacenMovimiento->GamEliminado<>2){
									if($InsGuiaRemisionAlmacenMovimiento->MtdRegistrarGuiaRemisionAlmacenMovimiento()){
										$validar++;					
									}else{
										$Resultado.='#ERR_GRE_301';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}else{
									$validar++;
								}
							}else{						
								if($InsGuiaRemisionAlmacenMovimiento->GamEliminado==2){
									if($InsGuiaRemisionAlmacenMovimiento->MtdEliminarGuiaRemisionAlmacenMovimiento($InsGuiaRemisionAlmacenMovimiento->GamId)){
										$validar++;					
									}else{
										$Resultado.='#ERR_GRE_303';
										$Resultado.='#Item Numero: '.($validar+1);	
									}
								}else{
									if($InsGuiaRemisionAlmacenMovimiento->MtdEditarGuiaRemisionAlmacenMovimiento()){
										$validar++;					
									}else{
										$Resultado.='#ERR_GRE_302';
										$Resultado.='#Item Numero: '.($validar+1);
									}
								}
							}									
						}
						
						
						if(count($this->GuiaRemisionAlmacenMovimiento) <> $validar ){
							$error = true;
						}					
									
					}				
				}				
				
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();			
				$this->MtdAuditarGuiaRemision(2,"Se edito la Guia de Remision",$this);			
				return true;
			}
							
				
		}	
		
	
	
		public function MtdEditarIdGuiaRemision() {
		
			
			$error = false;

			$this->InsMysql->MtdTransaccionIniciar();

			$sql = 'UPDATE tblgreguiaremision SET 
			GreId = "'.($this->NGreId).'",
			GreTiempoModificacion = "'.($this->GreTiempoModificacion).'"
			WHERE GreId = "'.($this->GreId).'"
			AND GrtId = "'.$this->GrtId.'";';
						
			$resultado = $this->InsMysql->MtdEjecutar($sql,false);        
			if(!$resultado) {							
				$error = true;
			} 			
	
			if($error) {		
				$this->InsMysql->MtdTransaccionDeshacer();					
				return false;
			} else {			
				$this->InsMysql->MtdTransaccionHacer();	
				
				$this->MtdAuditarGuiaRemision(2,"Se edito el Codigo de la Guia de Remision",$this);				
				return true;
			}	
		
			
		
		}	
		
		private function MtdAuditarGuiaRemision($oAccion,$oDescripcion,$oDatos,$oCodigo=NULL,$oUsuario=NULL,$oPersonal=NULL){
			
			$InsAuditoria = new ClsAuditoria();
			$InsAuditoria->AudCodigo = $this->GreId;
			$InsAuditoria->AudCodigoExtra = $this->GrtId;
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
		
		
		
			public function MtdEditarGuiaRemisionDato($oCampo,$oDato,$oId,$oTalonario) {

			$sql = 'UPDATE tblgreguiaremision SET 
			'.(empty($oDato)?$oCampo.' = NULL, ':$oCampo.' = "'.$oDato.'",').'
			NcrTiempoModificacion = NOW()
			WHERE NcrId = "'.($oId).'"
			AND GrtId = "'.($oTalonario).'"
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