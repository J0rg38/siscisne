<?php
//Si se hizo click en guardar	
	

if(isset($_POST['BtnEnviarCorreo_x']) or $_POST['Guardar']=="1"){	

	$Guardar = true;
	$Resultado = '';

	$InsOrdenCotizacion->UsuId = $_SESSION['SesionId'];	
	
	$InsOrdenCotizacion->OotId = $_POST['CmpId'];
	$InsOrdenCotizacion->PrvId = $_POST['CmpProveedorId'];
	$InsOrdenCotizacion->OotFecha = FncCambiaFechaAMysql($_POST['CmpFecha']);
	$InsOrdenCotizacion->OotFechaRespuesta = FncCambiaFechaAMysql($_POST['CmpFechaRespuesta'],true);
	$InsOrdenCotizacion->OotHora = ($_POST['CmpHora']);

	$InsOrdenCotizacion->MonId = $_POST['CmpMonedaId'];
	$InsOrdenCotizacion->OotTipoCambio = $_POST['CmpTipoCambio'];

	$InsOrdenCotizacion->OotObservacion = addslashes($_POST['CmpObservacion']);
	$InsOrdenCotizacion->OotOrigen =  $_POST['CmpOrigen'];
	$InsOrdenCotizacion->OotEstado = $_POST['CmpEstado'];
	$InsOrdenCotizacion->OotTiempoModificacion = date("Y-m-d H:i:s");

	$InsOrdenCotizacion->OotPorcentajeImpuestoVenta = $_POST['CmpPorcentajeImpuestoVenta'];
	$InsOrdenCotizacion->OotMargenUtilidad = 0;
	$InsOrdenCotizacion->OotIncluyeImpuesto = 0;

	$InsOrdenCotizacion->PrvNombre = $_POST['CmpProveedorNombre'];
	$InsOrdenCotizacion->PrvNombreCompleto = $InsOrdenCotizacion->PrvNombre;
	$InsOrdenCotizacion->TdoId = $_POST['CmpProveedorTipoDocumento'];	
	$InsOrdenCotizacion->PrvNumeroDocumento = $_POST['CmpProveedorNumeroDocumento'];

	$InsOrdenCotizacion->OotSubTotal = 0;
	$InsOrdenCotizacion->OotImpuesto = 0;
	$InsOrdenCotizacion->OotTotal = 0;

	$InsOrdenCotizacion->OrdenCotizacionDetalle = array();
	
	$InsOrdenCotizacion->OotDestinatarios = $_POST['CmpDestinatario'];
	
	
	$Destinatario = preg_replace("/ /", "", $_POST['CmpDestinatario']);
	
	if(!empty($Destinatario)){
		
		if($InsOrdenCotizacion->MtdGenerarExcelOrdenCotizacion($InsOrdenCotizacion->OotId,"")){
			
			//if($InsPedidoCompra->MtdEnviarCorreoPedidoCompra($InsPedidoCompra->PcoId,$InsPedidoCompra->PcoDestinatarios,NULL,$_SESSION['SesionNombre'])){
			$InsOrdenCotizacion->MtdEnviarCorreoPedidoOrdenCotizacion($InsOrdenCotizacion->OotId,$Destinatario,"",$_SESSION['SesionNombre']);  
			
		}else{
			$Guardar = false;	
		}
			
	}else{
		$Guardar = false;	
	}
		

		
	if($Guardar){
		
		
		if($InsOrdenCotizacion->OotEstado == 1){
	
			if($InsOrdenCotizacion->MtdActualizarEstadoOrdenCotizacion($InsOrdenCotizacion->OotId,3)){
			}
	
		}else if($InsOrdenCotizacion->OotEstado == 3){
			
			if($InsOrdenCotizacion->MtdActualizarEstadoOrdenCotizacion($InsOrdenCotizacion->OotId,31)){
			}
				
		}
		
		if(!empty($GET_dia)){
?>
		<script type="text/javascript">
            self.parent.tb_remove('<?php echo $GET_mod;?>');
            self.parent.$('#CmpOrdenCotizacionId').val("<?php echo $InsOrdenCotizacion->OotId;?>");
            self.parent.FncOrdenCotizacionBuscar("Id");
        </script>
    <?php
        }
    
		$Resultado.='#SAS_OOT_109';	
		$Edito = true;
        $InsOrdenCotizacion->OotFecha = FncCambiaFechaANormal($InsOrdenCotizacion->OotFecha);	
        
		
	}else{
		$Edito = false;
		$Resultado.='#ERR_OOT_109';	
		 $InsOrdenCotizacion->OotFecha = FncCambiaFechaANormal($InsOrdenCotizacion->OotFecha);	
		 
	}
	
		
	
}else{

	FncCargarDatos();
	
}

function FncCargarDatos(){

	global $GET_id;
	global $Identificador;
	global $InsOrdenCotizacion;
	global $EmpresaMonedaId;
	global $InsProductoDisponibilidad;
	global $InsProductoReemplazo;
	global $CorreosNotificacionSolicitudCotizacion;
	
	unset($_SESSION['InsOrdenCotizacionDetalle'.$Identificador]);

	$_SESSION['InsOrdenCotizacionDetalle'.$Identificador] = new ClsSesionObjeto();
	
	$InsOrdenCotizacion->OotId = $GET_id;
	$InsOrdenCotizacion->MtdObtenerOrdenCotizacion();		
	
	$InsOrdenCotizacion->OotDestinatarios = $CorreosNotificacionSolicitudCotizacion;
	
	
	//deb($InsPedidoCompra->PerEmail);
	if(!empty($InsOrdenCotizacion->PerEmail)){
	
		$ArrCorreos = explode(",",$InsOrdenCotizacion->OotDestinatarios);
	
		if(!in_array($InsOrdenCotizacion->PerEmail,$ArrCorreos)){
			$InsOrdenCotizacion->OotDestinatarios .= ",".$InsOrdenCotizacion->PerEmail;
		}
	
	}	
	
	
	if(!empty($InsOrdenCotizacion->OrdenCotizacionDetalle)){
		foreach($InsOrdenCotizacion->OrdenCotizacionDetalle as $DatOrdenCotizacionDetalle){

			if($InsOrdenCotizacion->MonId<>$EmpresaMonedaId){
				$DatOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio / $InsOrdenCotizacion->OotTipoCambio;
			}else{
				$DatOrdenCotizacionDetalle->OodPrecio = $DatOrdenCotizacionDetalle->OodPrecio;
			}
			
/*
SesionObjeto-OrdenCotizacionDetalle
Parametro1 = OodId
Parametro2 = ProId
Parametro3 = ProNombre
Parametro4 = OodPrecio
Parametro5 = 
Parametro6 = 
Parametro7 = OodTiempoCreacion
Parametro8 = OodTiempoModificacion
Parametro9 = UmeNombre
Parametro10 = UmeId
Parametro11 = RtiId
Parametro12 = 
Parametro13 = ProCodigoOriginal,
Parametro14 = ProCodigoAlternativo
Parametro15 = UmeIdOrigen
Parametro16 = 
Parametro17 = 
Parametro18 = 
Parametro19 = OodAno
Parametro20 = OodModelo

Parametro21 - 
Parametro22 - 
Parametro23 = 

Parametro24 = 
Parametro25 = 

Parametro26 = OodEstado
*/

		
			$_SESSION['InsOrdenCotizacionDetalle'.$Identificador]->MtdAgregarSesionObjeto(1,
			$DatOrdenCotizacionDetalle->OodId,
			$DatOrdenCotizacionDetalle->ProId,
			$DatOrdenCotizacionDetalle->ProNombre,
			$DatOrdenCotizacionDetalle->OodPrecio,
			0,
			0,
			($DatOrdenCotizacionDetalle->OodTiempoCreacion),
			($DatOrdenCotizacionDetalle->OodTiempoModificacion),
			$DatOrdenCotizacionDetalle->UmeNombre,
			$DatOrdenCotizacionDetalle->UmeId,
			$DatOrdenCotizacionDetalle->RtiId,
			NULL,
			$DatOrdenCotizacionDetalle->ProCodigoOriginal,
			$DatOrdenCotizacionDetalle->ProCodigoAlternativo,
			$DatOrdenCotizacionDetalle->UmeIdOrigen,
			NULL,
			NULL,
			NULL,
			$DatOrdenCotizacionDetalle->OodAno,
			$DatOrdenCotizacionDetalle->OodModelo,
			NULL,
			NULL,
			NULL,
			
			NULL,
			NULL,
			
			$DatOrdenCotizacionDetalle->OodEstado,
			NULL,
			NULL
			);
		
		}
	}
	

	
}
?>