<?php
switch($POST_acc){


		
		case 'Eliminar':

			if($InsPedidoCompraLlegada->MtdEliminarPedidoCompraLlegada($POST_seleccionados)){
				$Resultado .= "#SAS_PLE_105";
			}else{
				$Resultado .= "#ERR_PLE_105";
			}
		
		break;
	

	}
?>