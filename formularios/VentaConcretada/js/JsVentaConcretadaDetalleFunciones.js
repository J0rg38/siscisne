// JavaScript Document

function FncVentaConcretadaDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");

	$('#CmpProductoCosto').val("");
	$('#CmpProductoPrecio').val("");
	$('#CmpProductoPrecioAux').val("");
	
	$('#CmpProductoCantidad').val("");

	$('#CmpProductoImporte').val("");
	$('#CmpProductoItem').val("");	

	$('#CmpVentaConcretadaDetalleReingreso').val("");	


	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpVentaConcretadaDetalleAccion').val("AccVentaConcretadaDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");
	
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
}

function FncVentaConcretadaDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpVentaConcretadaDetalleAccion').val();		
	
			var AlmacenId = $('#CmpAlmacen').val();
			
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCosto = $('#CmpProductoCosto').val();
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var VentaConcretadaDetalleReingreso = $('#CmpVentaConcretadaDetalleReingreso').val();
			
			var Item = $('#CmpProductoItem').val();
	
			if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#CmpProductoCantidad').select();	
			}else if(ProductoPrecio=="" || ProductoPrecio=="0"){
				$('#CmpProductoPrecio').select();				
			}else if(AlmacenId==""){				
				$('#CmpAlmacen').select();									
			}else if(ProductoImporte==""){
				$('#CmpProductoImporte').select();						
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/VentaConcretada/acc/'+Acc,
							data: 'Identificador='+Identificador+
							'&ProductoId='+ProductoId+
							'&ProductoCosto='+ProductoCosto+
							'&ProductoPrecio='+ProductoPrecio+
							'&ProductoCantidad='+ProductoCantidad+
							'&ProductoImporte='+ProductoImporte+
							'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
							'&ProductoUnidadMedida='+ProductoUnidadMedida+
							'&VentaConcretadaDetalleReingreso='+VentaConcretadaDetalleReingreso+
							'&AlmacenId='+AlmacenId+
							'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncVentaConcretadaDetalleListar();
							}
						});
						
								//if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}


							FncVentaConcretadaDetalleNuevo();	
					
					
				}
			

	
}


function FncVentaConcretadaDetalleListar(){

	var Identificador = $('#Identificador').val();

	var PorcentajeImpuestoVenta  = $('#CmpPorcentajeImpuestoVenta').val();
	
	$('#CapProductoAccion').html('Cargando...');
	
	var ManoObra = $('#CmpManoObra').val();
	var Descuento = $('#CmpDescuento').val();
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var AlmacenId = $('#CmpAlmacen').val();


	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/VentaConcretada/FrmVentaConcretadaDetalleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+VentaConcretadaDetalleEditar+
'&Eliminar='+VentaConcretadaDetalleEliminar+
'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
'&Descuento='+Descuento+
'&ManoObra='+ManoObra+
'&MonedaId='+MonedaId+
'&TipoCambio='+TipoCambio+
'&AlmacenId='+AlmacenId+
'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapVentaConcretadaDetalles").html("");
			$("#CapVentaConcretadaDetalles").append(html);
			
				$('input[type=checkbox]').each(function () {
					if($(this).attr('etiqueta')=="detalle"){
					
					
						$("#CmpVentaConcretadaDetalleEstado_"+$(this).val()).change(function(){
							
							if($(this).val()=="1"){
								$(this).removeClass("EstFormularioCombo").addClass("EstFormularioComboAnulado");	
							}else{
								$(this).removeClass("EstFormularioComboAnulado").addClass("EstFormularioCombo");
							}
							
						});
						
						
					
					}			 
				});
	
						
						
		}
	});
	
}



function FncVentaConcretadaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpVentaConcretadaDetalleAccion').val("AccVentaConcretadaDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VentaConcretada/acc/AccVentaConcretadaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVentaConcretadaDetalle){
			

//				SesionObjeto-VentaConcretadaDetalle
//				Parametro1 = VcdId
//				Parametro2 = ProId
//				Parametro3 = ProNombre
//				Parametro4 = VcdPrecio
//				Parametro5 = VcdCantidad
//				Parametro6 = VcdImporte
//				Parametro7 = VcdTiempoCreacion
//				Parametro8 = VcdTiempoModificacion
//				Parametro9 = UmeNombre
//				Parametro10 = UmeId
//				Parametro11 = RtiId
//				Parametro12 = VcdCantidadReal
//				Parametro13 = ProCodigoOriginal,
//				Parametro14 = ProCodigoAlternativo
//				Parametro15 = UmeIdOrigen
//				Parametro16 = VerificarStock
//				Parametro17 = VcdCosto
//				Parametro18 = VddId

				$('#CmpProductoId').val(InsVentaConcretadaDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsVentaConcretadaDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsVentaConcretadaDetalle.Parametro14);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoNombre').val(InsVentaConcretadaDetalle.Parametro3);		
				$('#CmpProductoCosto').val(InsVentaConcretadaDetalle.Parametro17);
				$('#CmpProductoPrecio').val(InsVentaConcretadaDetalle.Parametro4);	
				$('#CmpProductoCantidad').val(InsVentaConcretadaDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsVentaConcretadaDetalle.Parametro6);
				$('#CmpVentaConcretadaDetalleReingreso').val(InsVentaConcretadaDetalle.Parametro21);
				$('#CmpProductoItem').val(InsVentaConcretadaDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsVentaConcretadaDetalle.Parametro11+"&Tipo=2&UnidadMedidaId="+InsVentaConcretadaDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsVentaConcretadaDetalle.Parametro10){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$("select#CmpProductoUnidadMedidaConvertir").html(options);
				})
				
				$('#CmpProductoUnidadMedidaConvertir').attr('disabled', true);
				
				$('#CmpProductoCantidad').select();
				
		}
	});
	
	
	
	
	$('#CmpProductoId').attr('readonly', true);
	//$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);

}

function FncVentaConcretadaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaConcretada/acc/AccVentaConcretadaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncVentaConcretadaDetalleListar();
			}
		});

		FncVentaConcretadaDetalleNuevo();

	}
	
}


function FncVentaConcretadaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VentaConcretada/acc/AccVentaConcretadaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncVentaConcretadaDetalleListar();
			}
		});	
			
		FncVentaConcretadaDetalleNuevo();
	}
	
}



$().ready(function() {

	$("#CmpProductoImporte").keyup(function (event) {  
		FncProductoCalcularMonto("Precio")
	});
	
		$("#CmpProductoCantidad").keyup(function (event) {  
		FncProductoCalcularImporte("Precio")
	});

	$("#CmpProductoId").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("Id");
		 }
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
