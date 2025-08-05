// JavaScript Document




function FncPedidoCompraDetalleNuevo(oItem){
		
	var Identificador = $('#Identificador').val();

	$('#CmpOrdenCompraId_'+oItem).val("");
	$('#CmpProductoCodigoOriginal_'+oItem).val("");	
	
	$('#CmpPedidoCompraDetalleId_'+oItem).val("");	
	$('#CmpProductoId_'+oItem).val("");	
	$('#CmpPedidoCompraLlegadaDetalleId_'+oItem).val("");	
	$('#CmpProductoCodigoOriginal_'+oItem).val("");	
	$('#CmpProductoNombre_'+oItem).val("");	
	
	$('#CmpClienteNombre_'+oItem).val("");	
	$('#CmpPedidoCompraLlegadaDetalleCantidad_'+oItem).val("");	
	$('#CmpPedidoCompraLlegadaDetalleCantidadEntregada_'+oItem).val("");	
	
	$('#CmpPedidoCompraLlegadaDetalleEstado_'+oItem).val("1");	
	$('#CmpPedidoCompraLlegadaDetalleObservacion_'+oItem).val("");	
	
	$('#BtnPedidoCompraLlegadaDetalleGuardar_'+oItem).val("Identificar");	
	
	
	
	$('#CmpOrdenCompraId_'+oItem).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
	$('#CmpProductoCodigoOriginal_'+oItem).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
	$('#CmpProductoNombre_'+oItem).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
	$('#CmpClienteNombre_'+oItem).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
	$('#CmpPedidoCompraLlegadaDetalleCantidad_'+oItem).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
	$('#CmpPedidoCompraLlegadaDetalleCantidadEntregada_'+oItem).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
	



}

function FncPedidoCompraLlegadaValidarDetalleGuardar(oItem){

	var Identificador = $('#Identificador').val();
	
	var PedidoCompraLlegadaId = $('#CmpId').val();
	
	var ProductoId = $('#CmpProductoId_'+oItem).val();
	var PedidoCompraLlegadaDetalleId = $('#CmpPedidoCompraLlegadaDetalleId_'+oItem).val();
	var PedidoCompraLlegadaDetalleCantidad = $('#CmpPedidoCompraLlegadaDetalleCantidad_'+oItem).val();
	var PedidoCompraLlegadaDetalleCantidadEntregada = $('#CmpPedidoCompraLlegadaDetalleCantidadEntregada_'+oItem).val();
	
	var PedidoCompraLlegadaDetalleEstado = $('#CmpPedidoCompraLlegadaDetalleEstado_'+oItem).val();
	var PedidoCompraLlegadaDetalleObservacion = $('#CmpPedidoCompraLlegadaDetalleObservacion_'+oItem).val();
	
	var ProductoCodigoOriginal = $('#CmpProductoCodigoOriginal_'+oItem).val();
	var ProductoNombre = $('#CmpProductoNombre_'+oItem).val();
	var ProductoUnidadMedida = $('#CmpProductoUnidadMedida_'+oItem).val();
	var OrdenCompraId = $('#CmpOrdenCompraId_'+oItem).val();
	
	if(ProductoNombre==""){
		$('#CmpProductoNombre_'+oItem).focus();	
		
	}else if(PedidoCompraLlegadaDetalleCantidad=="" || PedidoCompraLlegadaDetalleCantidad <=0){
		$('#CmpPedidoCompraLlegadaDetalleCantidad_'+oItem).select();
		
	//}else if(PedidoCompraLlegadaDetalleCantidadEntregada=="" || PedidoCompraLlegadaDetalleCantidadEntregada <=0){
	}else if(PedidoCompraLlegadaDetalleCantidadEntregada=="" ){
		$('#CmpPedidoCompraLlegadaDetalleCantidadEntregada_'+oItem).select();
		
	}else if(ProductoCodigoOriginal==""){
		$('#CmpProductoCodigoOriginal_'+oItem).focus();	
		
	}else if(OrdenCompraId==""){
		$('#CmpOrdenCompraId_'+oItem).focus();	
		
	}else{
		
		$('#CapPedidoCompraLlegdaDetalleAccion_'+oItem).html('Guardando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PedidoCompraLlegada/acc/AccPedidoCompraLlegadaValidarDetalleGuardar.php',
			data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&PedidoCompraLlegadaDetalleId='+PedidoCompraLlegadaDetalleId+'&PedidoCompraLlegadaDetalleCantidad='+PedidoCompraLlegadaDetalleCantidad+'&PedidoCompraLlegadaDetalleCantidadEntregada='+PedidoCompraLlegadaDetalleCantidadEntregada+'&PedidoCompraLlegadaDetalleEstado='+PedidoCompraLlegadaDetalleEstado+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&ProductoNombre='+ProductoNombre+'&OrdenCompraId='+OrdenCompraId+'&PedidoCompraLlegadaDetalleObservacion='+PedidoCompraLlegadaDetalleObservacion+'&ProductoCodigoOriginal='+ProductoCodigoOriginal+'&PedidoCompraLlegadaId='+PedidoCompraLlegadaId,
			success: function(html){
				
				var Mensaje = "";
				
				switch(html){
					
					case "1":
						Mensaje = "La Ord. Comp. no existe";
					break;
					
					case "2":
						Mensaje = "La Ord. Comp. no tiene items";
					break;
					
					case "3":
						Mensaje = "Codigo no pertenece a orden de compra";
					break;
					
					case "5":
						Mensaje = "Correcto";
					break;
					
					case "6":
						Mensaje = "Eliminado";
						
						FncPedidoCompraDetalleNuevo(oItem);
						
					break;
					
					default:
						
						var respuesta = html.split(":::");
				
						if(respuesta[0]=="4"){
							//FncPedidoCompraDetalleCargar(respuesta[1],respuesta[2]);
							FncPedidoCompraDetalleCargar(respuesta[1],oItem);
							
							$('#CmpPedidoCompraLlegadaDetalleId_'+oItem).val(respuesta[2]);
							
							Mensaje = "Identificando...";
						}else{
							Mensaje = "Ha ocurrido un error";
						}
						
					break;
					
				}
				
				
				
				$('#BtnPedidoCompraLlegadaDetalleGuardar_'+oItem).val("Guardar");	
				
				$('#CapPedidoCompraLlegdaDetalleAccion_'+oItem).html(Mensaje);	
				
				//$('#CapPedidoCompraLlegdaDetalleAccion_'+oItem).html(html);	
				//if(html=="OK"){
				//}

				
			}
		});
				
		
			
	}
	
}




function FncPedidoCompraLlegadaValidarDetalleListar(){

	var Identificador = $('#Identificador').val();
	
	var PedidoCompraLlegadaId = $('#CmpId').val();

	$('#CapPedidoCompraLlegadaValidarDetalles').html('Cargando...');	
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PedidoCompraLlegada/FrmPedidoCompraLlegadaValidarDetalleListado.php',
		data: 'Identificador='+Identificador+'&PedidoCompraLlegadaId='+PedidoCompraLlegadaId,
		success: function(html){

			$("#CapPedidoCompraLlegadaValidarDetalles").html("");
			$("#CapPedidoCompraLlegadaValidarDetalles").append(html);
			
		}
	});
	
}




function FncPedidoCompraDetalleCargar(oPedidoCompraDetalleId,oItem){
		
	var Identificador = $('#Identificador').val();

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PedidoCompraLlegada/acc/AccPedidoCompraDetalleCargar.php',
		data: 'Identificador='+Identificador+'&PedidoCompraDetalleId='+oPedidoCompraDetalleId,
		success: function(InsPedidoCompraDetalle){
			
			$('#CmpPedidoCompraDetalleId_'+oItem).val(InsPedidoCompraDetalle.PcdId);
			$('#CmpClienteNombre_'+oItem).val(InsPedidoCompraDetalle.CliNombre+" "+InsPedidoCompraDetalle.CliApellidoPaterno+" " +InsPedidoCompraDetalle.CliApellidoPaterno);	

			$('#CmpOrdenCompraId_'+oItem).attr('readonly', true);
			$('#CmpProductoCodigoOriginal_'+oItem).attr('readonly', true);
			$('#CmpProductoNombre_'+oItem).attr('readonly', true);
			$('#CmpPedidoCompraLlegadaDetalleCantidad_'+oItem).attr('readonly', true);
			$('#CmpPedidoCompraLlegadaDetalleCantidadEntregada_'+oItem).attr('readonly', true);

			$('#CmpOrdenCompraId_'+oItem).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
			$('#CmpProductoCodigoOriginal_'+oItem).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
			$('#CmpProductoNombre_'+oItem).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
			$('#CmpPedidoCompraLlegadaDetalleCantidad_'+oItem).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
			$('#CmpPedidoCompraLlegadaDetalleCantidadEntregada_'+oItem).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");

			if(InsPedidoCompraDetalle.PcdId!=null){

				//$('#BtnPedidoCompraLlegadaIdentificar_'+oItem).hide();
//				$('#BtnPedidoCompraLlegadaGuardar_'+oItem).show();
//				$('#BtnPedidoCompraLlegadaEliminar_'+oItem).show();

				$('#CapPedidoCompraLlegdaDetalleAccion_'+oItem).html("Correcto");

			}else{
				$('#CapPedidoCompraLlegdaDetalleAccion_'+oItem).html("Error cargando");
			}
			
			
		}
	});
	


}
