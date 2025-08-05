// JavaScript Document

function FncPedidoCompraDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");
	$('#CmpProductoCantidad').val("");

	$('#CmpProductoItem').val("");	

	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpPedidoCompraDetalleAccion').val("AccPedidoCompraDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");

	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
}

function FncPedidoCompraDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpPedidoCompraDetalleAccion').val();		
	
		var ProductoCantidad = $('#CmpProductoCantidad').val();

		var Item = $('#CmpProductoItem').val();
				
			if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidad').select();	
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
				$.ajax({
				  type: 'POST',
				  url: 'formularios/PedidoCompra/acc/'+Acc,
				  data: 'Identificador='+Identificador+'&ProductoCantidad='+ProductoCantidad+'&Item='+Item,
				  success: function(){
					  $('#CapProductoAccion').html('Listo');							
					  FncPedidoCompraDetalleListar();
				  }
				});
					
						FncPedidoCompraDetalleNuevo();	
							
					
			}
			

	
}



function FncPedidoCompraDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	var VentaDirectaId = $('#CmpVentaDirectaId').val();
	
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpPedidoCompraDetalleAccion').val("AccPedidoCompraDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PedidoCompra/acc/AccPedidoCompraDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsPedidoCompraDetalle){
			
			
						/*
						SesionObjeto-PedidoCompraDetalle
						Parametro1 = PcdId
						Parametro2 = ProId
						Parametro3 = ProNombre
						Parametro4 = PcdPrecio
						Parametro5 = PcdCantidad
						Parametro6 = PcdImporte
						Parametro7 = PcdTiempoCreacion
						Parametro8 = PcdTiempoModificacion
						Parametro9 = UmeNombre
						Parametro10 = UmeId
						Parametro11 = RtiId
						Parametro12 = PcdCodigo
						Parametro13 = ProCodigoOriginal,
						Parametro14 = ProCodigoAlternativo
						Parametro15 = UmeIdOrigen
						Parametro16 = VerificarStock
						Parametro17 = 
						Parametro18 = VddId
						Parametro19 = PcdAno
						Parametro20 = PcdModelo
						*/
						
				$('#CmpProductoId').val(InsPedidoCompraDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsPedidoCompraDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsPedidoCompraDetalle.Parametro14);
				$('#CmpProductoNombre').val(InsPedidoCompraDetalle.Parametro3);		
				$('#CmpProductoCantidad').val(InsPedidoCompraDetalle.Parametro5);
				
				$('#CmpProductoItem').val(InsPedidoCompraDetalle.Item);
				

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsPedidoCompraDetalle.Parametro11+"&Tipo=1&UnidadMedidaId="+InsPedidoCompraDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsPedidoCompraDetalle.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
					$('#CmpProductoCantidad').select();
				})
				
				$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);

		}
	});
	
	
	
	
	$('#CmpProductoId').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);



}


