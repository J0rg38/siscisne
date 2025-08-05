<?php
//deb($_POST);
//echo $POST_acc;
switch($POST_acc){

		
		case 'EnviarPedidoAlmacen':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,4)){
				$Resultado .= "#SAS_FCC_106";
			}else{
				$Resultado .= "#ERR_FCC_106";
			}
		
		break;
		
		case 'CancelarPedidoAlmacen':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,3)){
				$Resultado .= "#SAS_FCC_107";
			}else{
				$Resultado .= "#ERR_FCC_107";
			}
		
		break;









		case 'EnviarPedidoTallerExterno':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,4)){
				$Resultado .= "#SAS_FCC_114";
			}else{
				$Resultado .= "#ERR_FCC_114";
			}
		
		break;
		
		case 'CancelarPedidoTallerExterno':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,3)){
				$Resultado .= "#SAS_FCC_115";
			}else{
				$Resultado .= "#ERR_FCC_115";
			}
		
		break;
		
		
		
				
		
		
		case 'RetornarPedidoTallerExterno':

			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,5);
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,6);
			$InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,7);
			
			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,71)){//REVISAR
					
				$ArrSeleccionados = explode("#",$POST_seleccionados);
				
				if(!$_SESSION['MysqlDeb']){
					
					$InsMensaje->MtdRedireccionar("principal.php?Mod=".$GET_mod."&Form=Trabajar&Id=".$ArrSeleccionados [1],true,1500);
				}

				$Resultado .= "#SAS_FCC_116";
			}else{
				$Resultado .= "#ERR_FCC_116";
			}
		
		break;		









		case 'MarcarTrabajoTerminado':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,73)){
				$Resultado .= "#SAS_FCC_108";
			}else{
				$Resultado .= "#ERR_FCC_108";
			}
		
		break;

		case 'DesmarcarTrabajoTerminado':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,71)){
				$Resultado .= "#SAS_FCC_110";
			}else{
				$Resultado .= "#ERR_FCC_110";
			}
		
		break;







		case 'EnviarFichaAccionRecepcion':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,1)){
				$Resultado .= "#SAS_FCC_109";
			}else{
				$Resultado .= "#ERR_FCC_109";
			}
		
		break;
		
		
		case 'AnularRecepcionFichaAccion':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,11)){	
				$Resultado .= "#SAS_FCC_111";
			}else{
				$Resultado .= "#ERR_FCC_111";
			}
		
		break;
		
		
		
		
		
		
	

	}
?>