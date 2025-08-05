// JavaScript Document

function FncPedidoCompraDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");

	$('#CmpProductoCosto').val("");
	$('#CmpProductoPrecio').val("");
	$('#CmpProductoPrecioAux').val("");
	
	$('#CmpProductoCantidad').val("");

	$('#CmpProductoImporte').val("");
	
	$('#CmpPedidoCompraDetalleEstado').val("3");
	$('#CmpPedidoCompraDetalleObservacion').val("");
	//$('#CmpPedidoCompraDetalleCodigo').val("");
	$('#CmpPedidoCompraDetalleAno').val("");
	$('#CmpPedidoCompraDetalleModelo').val("");

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
	
	var VentaDirectaId = $('#CmpVentaDirectaId').val();
	
	if(VentaDirectaId!=""){
		$('#CmpProductoCantidad').removeAttr('readonly');
	}
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
}

function FncPedidoCompraDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpPedidoCompraDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCosto = $('#CmpProductoCosto').val();
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var PedidoCompraDetalleObservacion = $('#CmpPedidoCompraDetalleObservacion').val();
			var PedidoCompraDetalleEstado = $('#CmpPedidoCompraDetalleEstado').val();

			//var PedidoCompraDetalleCodigo = $('#CmpPedidoCompraDetalleCodigo').val();
			var PedidoCompraDetalleAno = $('#CmpPedidoCompraDetalleAno').val();
			var PedidoCompraDetalleModelo = $('#CmpPedidoCompraDetalleModelo').val();
			
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var Item = $('#CmpProductoItem').val();
			
				var ProductoPromedioMensual = $('#CmpProductoPromedioMensual').val();
	
			if(ProductoId == ""){

				alert("No existe el PRODUCTO");
				FncProductoCargarFormulario("Registrar");

			}else if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidad').select();	
			}else if(ProductoPrecio==""){
				$('#CmpProductoPrecio').select();	
			}else if(ProductoImporte==""){
				$('#CmpProductoImporte').select();						
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
				$.ajax({
				  type: 'POST',
				  url: 'formularios/PedidoCompra/acc/'+Acc,
				  //data: 'Identificador='+Identificador+'&ProductoId='+ProductoId+'&ProductoCosto='+ProductoCosto+'&ProductoPrecio='+ProductoPrecio+'&ProductoCantidad='+ProductoCantidad+'&ProductoImporte='+ProductoImporte+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&PedidoCompraDetalleAno='+PedidoCompraDetalleAno+'&PedidoCompraDetalleModelo='+PedidoCompraDetalleModelo+'&PedidoCompraDetalleCodigo='+PedidoCompraDetalleCodigo+'&PedidoCompraDetalleEstado='+PedidoCompraDetalleEstado+'&Item='+Item,
				  data: 'Identificador='+Identificador
				  +'&ProductoId='+ProductoId
				  +'&ProductoCosto='+ProductoCosto
				  +'&ProductoPrecio='+ProductoPrecio
				  +'&ProductoCantidad='+ProductoCantidad
				  +'&ProductoImporte='+ProductoImporte
				  +'&PedidoCompraDetalleObservacion='+PedidoCompraDetalleObservacion
				   
				  +'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir
				  +'&ProductoUnidadMedida='+ProductoUnidadMedida
				  +'&PedidoCompraDetalleAno='+PedidoCompraDetalleAno
				  +'&PedidoCompraDetalleModelo='+PedidoCompraDetalleModelo
				  +'&PedidoCompraDetalleEstado='+PedidoCompraDetalleEstado
				  +'&ProductoPromedioMensual='+ProductoPromedioMensual
				  +'&Item='+Item,
				  success: function(){
					  $('#CapProductoAccion').html('Listo');							
					  FncPedidoCompraDetalleListar();
				  }
				});
						
								//if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}

						FncPedidoCompraDetalleNuevo();	
							
					
					
				}
			

	
}


function FncPedidoCompraDetalleListar(){

	var Identificador = $('#Identificador').val();

	var IncluyeImpuesto  = $('#CmpIncluyeImpuesto').val();
	var PorcentajeImpuestoVenta  = $('#CmpPorcentajeImpuestoVenta').val();
	var OrdenCompraId  = $('#CmpOrdenCompraId').val();
	

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$('#CapProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PedidoCompra/FrmPedidoCompraDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+PedidoCompraDetalleEditar+'&Eliminar='+PedidoCompraDetalleEliminar+'&VerEstado='+PedidoCompraDetalleVerEstado+'&IncluyeImpuesto='+IncluyeImpuesto+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&OrdenCompraId='+OrdenCompraId+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapPedidoCompraDetalles").html("");
			$("#CapPedidoCompraDetalles").append(html);
		}
	});
	
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

Parametro21 - PcdDisponibilidad
Parametro22 - PcdReemplazo
Parametro23 = AmdCantidad

Parametro24 = PcdBOFecha
Parametro25 = PcdBOEstado

Parametro26 = PcdEstado
Parametro34 = PcdObservacion
*/
						
				$('#CmpProductoId').val(InsPedidoCompraDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsPedidoCompraDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsPedidoCompraDetalle.Parametro14);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoNombre').val(InsPedidoCompraDetalle.Parametro3);		
				
				$('#CmpPedidoCompraDetalleEstado').val(InsPedidoCompraDetalle.Parametro26);		
				
				$('#CmpProductoCosto').val(InsPedidoCompraDetalle.Parametro17);
				$('#CmpProductoPrecio').val(InsPedidoCompraDetalle.Parametro4);	
				$('#CmpProductoCantidad').val(InsPedidoCompraDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsPedidoCompraDetalle.Parametro6);
				$('#CmpPedidoCompraDetalleObservacion').val(InsPedidoCompraDetalle.Parametro34);
				
				//$('#CmpPedidoCompraDetalleCodigo').val(InsPedidoCompraDetalle.Parametro12);
				$('#CmpPedidoCompraDetalleAno').val(InsPedidoCompraDetalle.Parametro19);
				$('#CmpPedidoCompraDetalleModelo').val(InsPedidoCompraDetalle.Parametro20);
				
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
					$('#CmpProductoPrecio').select();
					
				})
				
				$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);

		}
	});
	
	
	
	
	$('#CmpProductoId').attr('readonly', true);
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);
	
	//if(VentaDirectaId!=""){
//		$('#CmpProductoCantidad').attr('readonly', true);
//	}
	

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();

}

function FncPedidoCompraDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PedidoCompra/acc/AccPedidoCompraDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncPedidoCompraDetalleListar();
			}
		});

		FncPedidoCompraDetalleNuevo();
	}
	
}

function FncPedidoCompraDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PedidoCompra/acc/AccPedidoCompraDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncPedidoCompraDetalleListar();
			}
		});	
			
		FncPedidoCompraDetalleNuevo();
	}
	
}



$().ready(function() {

	$("#CmpProductoImporte").keyup(function (event) {  
		FncProductoCalcularMonto("Precio")
	});
	
	$("#CmpProductoCantidad").keyup(function (event) {  
		FncProductoCalcularImporte("Precio")
	});

	$("#CmpProductoPrecio").keyup(function (event) {  
		FncProductoCalcularImporte("Precio")
	});
	
//	$("#CmpProductoId").keypress(function (event) {  
//		 if (event.keyCode == '13' && this.type !== "hidden") {
//			FncProductoBuscar("Id");
//		 }
//	});
	
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
