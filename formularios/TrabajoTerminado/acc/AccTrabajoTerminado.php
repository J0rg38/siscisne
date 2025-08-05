<?php
/*
case 1:		$Estado = "RECEPCION [Pendiente]";
case 11:	$Estado = "RECEPCION [Enviado]";
case 2:		$Estado = "TALLER [Revisando]";
case 3:		$Estado = "TALLER [Preparando Pedido]";
case 4:		$Estado = "TALLER [Pedido Enviado]";
case 5:		$Estado = "ALMACEN [Revisado Pedido]";
case 6:		$Estado = "ALMACEN [Preparando Pedido]";
case 7:		$Estado = "ALMACEN [Pedido Enviado]";
case 71:	$Estado = "TALLER [Pedido Recibido]";
case 72:	$Estado = "ALMACEN [Pedido Extornado]";

case 73:$Estado = "TALLER [Trabajo Terminado]";
case 74:$Estado = "RECEPCION [Revisando]";

case 75:$Estado = "RECEPCION [Conforme/Por Facturar]";
case 8:	$Estado = "TALLER [Por Facturar]";
case 9:	$Estado = "CONTABILIDAD [Facturado]";						

case 10: $Estado = "RECEPCION [No Facturable]"
*/	

switch($POST_acc){

	case 'EnviarOrdenTrabajoContabilidad':

		if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,75)){
			
			
			//$InsNotificacion = new ClsNotificacion();
//			$InsNotificacion->UsuId = "USU-10001";
//			$InsNotificacion->UsuIdOrigen = $_SESSION['SesionId'];
//					
//			$InsNotificacion->NfnModulo = "ComprobanteVenta";
//			$InsNotificacion->NfnFormulario = "MonitoreoFichaIngreso";
//			$InsNotificacion->NfnDescripcion = "<b>".$_SESSION['SesionUsuario']."</b> te ha enviado una Orden de Trabajo para facturar";
//			$InsNotificacion->NfnEnlace = "principal.php?Mod=ComprobanteVenta&Form=MonitoreoFichaIngreso";
//			$InsNotificacion->NfnEnlaceNombre = "Mostrar";
//							
//			$InsNotificacion->NfnTipo = 1;
//			$InsNotificacion->NfnEstado = 1;
//			$InsNotificacion->NfnTiempoCreacion =date("Y-m-d H:i:s");
//			$InsNotificacion->NfnTiempoModificacion =date("Y-m-d H:i:s");
//
//			$InsNotificacion->MtdRegistrarNotificacion();
							
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_106";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_106";
			
		}
	
	break;
	
	case 'EnviarOrdenTrabajoRecepcion':

		if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,74)){
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_107";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_107";
			
		}
	
	break;
	
	case 'EnviarOrdenTrabajoTaller':

		if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,71)){
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_108";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_108";
			
		}
	
	break;
	
	case 'EnviarOrdenTrabajoAlmacen':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,6)){//ANTES ERA 4
			
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_TTE_109";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
				$Resultado .= "#ERR_TTE_109";
				
			}
	
	break;
	
	case 'GenerarGarantia':

		if($InsGarantia->MtdGenerarGarantia($POST_seleccionados)){
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_200";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_200";
			
		}
		
	break;
	
		case 'GenerarGarantiaRepuestoIsuzu':
	
			if($InsGarantiaRepuestoIsuzu->MtdGenerarGarantiaRepuestoIsuzu($POST_seleccionados)){

				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_TTE_201";

			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
				$Resultado .= "#ERR_TTE_201";
				
			}
			
		break;
		
	case 'EnviarOrdenTrabajoNoFacturable':

		if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,10)){
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_110";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_110";
			
		}

	break;

	case 'EnviarOrdenTrabajoNoFacturableCancelar':

		if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,74)){
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_111";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_111";
		}

	break;
	
	
	
	
	case 'ActualizarCierreSi':
	
		if($InsFichaIngreso->MtdActualizarCierreFichaIngreso($POST_seleccionados,1,true)){
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_112";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_112";
		}
	
	break;
	
	case 'ActualizarCierreNo':
	
		if($InsFichaIngreso->MtdActualizarCierreFichaIngreso($POST_seleccionados,2,true)){
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
			$Resultado .= "#SAS_TTE_113";
			
		}else{
			
			$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
			$Resultado .= "#ERR_TTE_113";
			
		}
	
	break;	
	
		
	

}
?>