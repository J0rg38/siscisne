<?php
//deb($_POST);
//echo $POST_acc;
switch($POST_acc){

		
		case 'EnviarPedidoAlmacen'://OK

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,4)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_106";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_106";
				
			}
		
		break;
		
		case 'CancelarPedidoAlmacen':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,3)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_107";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_107";
				
			}
		
		break;

		/*case 'EnviarPedidoTallerExterno':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,4)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_114";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_114";
				
			}
		
		break;*/
		
	/*	case 'CancelarPedidoTallerExterno':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,3)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_115";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_115";
				
			}
		
		break;
		*/
		
		
				
		
	/*	
		case 'RetornarPedidoTallerExterno':

			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,5);
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,6);
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,7);
			
			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,71)){//REVISAR
					
				$ArrSeleccionados = explode("#",$POST_seleccionados);
				
				if(!$_SESSION['MysqlDeb']){
					$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Trabajar&Id=".$ArrSeleccionados [1],true,1500);
				}
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_116";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_116";
				
			}
		
		break;		
*/








		case 'MarcarTrabajoTerminado':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,73)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_108";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_108";
				
			}
		
		break;

		case 'DesmarcarTrabajoTerminado':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,71)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_110";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_110";
				
			}
		
		break;







		case 'EnviarFichaAccionRecepcion':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,1)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_109";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_109";
				
			}
		
		break;
		
		
		case 'AnularRecepcionFichaAccion':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,11)){	
			
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_111";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_111";
				
			}
		
		break;
		
		
		
		
		
		
		case 'MarcarTrabajoConcluido':

			if($InsFichaIngreso->MtdMarcarConcluidoFichaIngreso($POST_seleccionados)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_112";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_112";
				
			}
		
		break;
	
	
		case 'DesmarcarTrabajoConcluido':

			if($InsFichaIngreso->MtdDesmarcarConcluidoFichaIngreso($POST_seleccionados)){
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1500);		
				$Resultado .= "#SAS_FCC_112";
				
			}else{
				
				$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=".$GET_form,true,1800);	
				$Resultado .= "#ERR_FCC_113";
				
			}
		
		break;
	
		
	

	}
?>