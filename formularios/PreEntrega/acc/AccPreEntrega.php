<?php
switch($POST_acc){

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
*/
		case 'Eliminar':

//			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados)){
			if($InsFichaIngreso->MtdEliminarFichaIngreso($POST_seleccionados)){
				$Resultado .= "#SAS_FIN_105";
			}else{
				$Resultado .= "#ERR_FIN_105";
			}

		break;

//		case 'EnviarOrdenTrabajoContabilidad':
//
//			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,75)){
//				$Resultado .= "#SAS_FIN_106";
//			}else{
//				$Resultado .= "#ERR_FIN_106";
//			}
//		
//		break;

		case 'EnviarOrdenTrabajoTaller':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,11,true)){
				$Resultado .= "#SAS_FIN_107";
			}else{
				$Resultado .= "#ERR_FIN_107";
			}

		break;
		
		
		case 'EnviarOrdenTrabajoAlmacen':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,4,true)){
				$Resultado .= "#SAS_FIN_110";
			}else{
				$Resultado .= "#ERR_FIN_110";
			}

		break;


		case 'EnviarOrdenTrabajoRecepcion':

			if($InsFichaIngreso->MtdActualizarEstadoFichaIngreso($POST_seleccionados,1)){
				$Resultado .= "#SAS_FIN_107";
			}else{
				$Resultado .= "#ERR_FIN_107";
			}
		
		break;



	}
?>