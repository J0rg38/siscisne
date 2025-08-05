<?php
//deb($POST_acc);

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




	
		//case 'EnviarPedidoTaller':
//
//			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,7)){
//				$Resultado .= "#SAS_TPE_106";
//			}else{
//				$Resultado .= "#ERR_TPE_106";
//			}
//			
//		
//		break;
		
		
		//case 'CancelarPedidoAlmacen':
//			//RECHAZAR las ORDENES DE TRABAJO seleccionadas de TALLER
//			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,3)){
//				$Resultado .= "#SAS_TPE_107";
//			}else{
//				$Resultado .= "#ERR_TPE_107";
//			}
//		
//		break;
		
		
				
		case 'AnularRecepcionPedidoTaller':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,4,true)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);	
				$Resultado .= "#SAS_TPE_108";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_TPE_108";
				
			}
		
		break;
		
		
		
		
		
		
		

		case 'MarcarTrabajoTerminado':
			
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,7);
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,71);
				
			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,73)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_TPE_109";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
				$Resultado .= "#ERR_TPE_109";
			}

			
		break;
		
		
		
		case 'MarcarTrabajoTerminadoRapido':
			
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,7);
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,71);
				
			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,73)){
				
				if($PrivilegioRapido){
					
					$Id = "";
					
					$Elementos = explode("#",$POST_seleccionados);
					
					if(!empty($Elementos)){
						foreach($Elementos as $elemento){
							
							if(!empty($elemento)){
								$Id = $elemento;								
							}
						
						}
					}
					
					if(!empty($Id)){
						$InsMensaje->MtdRedireccionar("principal.php?Mod=TrabajoTerminado&Form=Registrar&Id=".$Id,true,1500);						
					}

					//http://179.43.96.147:81/sistema/principal.php?Mod=TallerPedido&Form=Registrar&FinId=OT-2018-00001-UM
					
				}else{
					
					$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);			
					
				}
				
				$Resultado .= "#SAS_TPE_109";
				
			}else{
			
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);		
				$Resultado .= "#ERR_TPE_109";
					
			}

		break;
		

		//case 'DesmarcarTrabajoTerminado':
//
//			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,6)){//ANTES71
//				$Resultado .= "#SAS_TPE_110";
//			}else{
//				$Resultado .= "#ERR_TPE_110";
//			}
//		
//		break;
		
			
	
	//case 'GenerarGarantia':
//
//		if($InsGarantia->MtdGenerarGarantia($POST_seleccionados,true,false)){
//			$Resultado .= "#SAS_TPE_200";
//		}else{
//			$Resultado .= "#ERR_TPE_200";
//		}
//		
//	break;
	
	//case 'DesmarcarTrabajoConcluido':
//
//			if($InsFichaIngreso->MtdDesmarcarConcluidoFichaIngreso($POST_seleccionados)){
//				$Resultado .= "#SAS_TPE_111";
//			}else{
//				$Resultado .= "#ERR_TPE_111";
//			}
//		
//		break;
//		
		
	
		
		
		
	
	}
?>