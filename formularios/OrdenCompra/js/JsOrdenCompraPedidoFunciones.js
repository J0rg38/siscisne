// JavaScript Document
/*
function FncOrdenCompraPedidoNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoCodigoOtro').val("");
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoCodigoAlternativo').val("");
	
	$('#CmpProductoNombre').val("");
	$('#CmpProductoUnidadMedida').val("");
	$('#CmpProductoPrecio').val("");
	$('#CmpProductoCantidad').val("");
	$('#CmpProductoImporte').val("");
	$('#CmpProductoItem').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
	
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	
	$('#CmpOrdenCompraPedidoAccion').val("AccOrdenCompraGMPedidoRegistrar.php");

	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
}

function FncOrdenCompraPedidoGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpOrdenCompraPedidoAccion').val();		
	
		var Id = $('#CmpProductoId').val();
		var CodigoOtro = $('#CmpProductoCodigoOtro').val();
		var UnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
		var Precio = $('#CmpProductoPrecio').val();
		var Cantidad = $('#CmpProductoCantidad').val();
		var Importe = $('#CmpProductoImporte').val();
		var Item = $('#CmpProductoItem').val();
		
		if(Id==""){
			$('#CmpProductoCodigoOriginal').select();	
		}else if(UnidadMedidaConvertir==""){
			$('#CmpProductoUnidadMedidaConvertir').focus();	
		}else if(Cantidad=="" || Cantidad <=0){
			$('#CmpProductoCantidad').select();	
		}else if(Precio==""){
			$('#CmpProductoPrecio').select();	
		}else if(Importe==""){
			$('#CmpProductoImporte').select();						
		}else{
			$('#CapProductoAccion').html('Guardando...');
			
					$.ajax({
						type: 'POST',
						url: 'formularios/OrdenCompraGM/acc/'+Acc,
						data: 'Identificador='+Identificador+'&Id='+Id+'&CodigoOtro='+CodigoOtro+'&Precio='+Precio+'&Cantidad='+Cantidad+'&Importe='+Importe+'&UnidadMedidaConvertir='+UnidadMedidaConvertir+'&Item='+Item,
						success: function(){
							
						$('#CapProductoAccion').html('Listo');							
							FncOrdenCompraPedidoListar();
						}
					});
					
						FncOrdenCompraPedidoNuevo();	
				
			}
	
}
*/

function FncOrdenCompraPedidoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');

	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	var ImpuestoVenta = 0;

	if(PorcentajeImpuestoVenta!="" ){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}

	if(TipoCambio==""){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenCompra/FrmOrdenCompraPedidoListado.php',
		data: 'Identificador='+Identificador+
		'&Editar='+OrdenCompraPedidoEditar+
		'&Eliminar='+OrdenCompraPedidoEliminar+
		'&VerEstado='+OrdenCompraPedidoVerEstado+
		
		'&ImpuestoVenta='+ImpuestoVenta+
		'&IncluyeImpuesto='+IncluyeImpuesto+
		
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapOrdenCompraPedidos").html("");
			$("#CapOrdenCompraPedidos").append(html);	
			
			FncCargarTB();
		}
	});


}





/*
function FncOrdenCompraPedidoEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpOrdenCompraPedidoAccion').val("AccOrdenCompraGMPedidoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/OrdenCompraGM/acc/AccOrdenCompraGMPedidoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsOrdenCompraPedido){
				$('#CmpProductoId').val(InsOrdenCompraPedido.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsOrdenCompraPedido.Parametro14);
				$('#CmpProductoCodigoAlternativo').val(InsOrdenCompraPedido.Parametro15);		
				$('#CmpProductoCodigoOtro').val(InsOrdenCompraPedido.Parametro13);
				$('#CmpProductoNombre').val(InsOrdenCompraPedido.Parametro3);		
				$('#CmpProductoUnidadMedida').val(InsOrdenCompraPedido.Parametro9);						
				$('#CmpProductoPrecio').val(InsOrdenCompraPedido.Parametro4);	
				$('#CmpProductoCantidad').val(InsOrdenCompraPedido.Parametro5);
				$('#CmpProductoImporte').val(InsOrdenCompraPedido.Parametro6);
				$('#CmpProductoItem').val(InsOrdenCompraPedido.Item);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsOrdenCompraPedido.Parametro11+"&Tipo=1",{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsOrdenCompraPedido.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
				})
				
				$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);
				
				
		}
	});
	
	
	$('#CmpProductoCantidad').select();
	
	$('#CmpProductoId').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);

}

function FncOrdenCompraPedidoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');	
		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenCompraGM/acc/AccOrdenCompraGMPedidoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncOrdenCompraPedidoListar();
			}
		});

		
		FncOrdenCompraPedidoNuevo();
		

	}


	
}



function FncOrdenCompraPedidoEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenCompraGM/acc/AccOrdenCompraGMPedidoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncOrdenCompraPedidoListar();
			}
		});	
			
		FncOrdenCompraPedidoNuevo();
	}
	
}







$().ready(function() {

//	$("#CmpProductoImporte").keyup(function (event) {  
//		FncProductoCalcularMonto("Precio");
//	});
	
	$("#CmpProductoCantidad").keyup(function (event) {  
		FncProductoCalcularImporte("Precio");
	});
	
	$("#CmpProductoPrecio").keyup(function (event) {  
		FncProductoCalcularImporte("Precio");
	});
	
	
	$("#CmpProductoCodigoOriginal").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoOriginal");
		 }
	});
	
	$("#CmpProductoCodigoAlternativo").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoAlternativo");
		 }
	});
	
});
*/