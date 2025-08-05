// JavaScript Document


function FncBoletaDetalleNuevo(){
	
	$('#CmpArticuloDescripcion').val("");
	$('#CmpArticuloId').val("");
	
	$('#CmpBoletaDetalleTipo').val("");
	
	$('#CmpBoletaDetalleCodigo').val("");
	$('#CmpBoletaDetalleUnidadMedida').val("");
	$('#CmpBoletaDetallePrecio').val("");
	$('#CmpBoletaDetalleCantidad').val("");
	$('#CmpBoletaDetalleImporte').val("");
	$('#CmpBoletaDetalleDescuento').val("");
	$('#CmpBoletaDetalleItem').val("");
	
	$("#CmpBoletaDetalleGratuito").attr('checked', false);
	$("#CmpBoletaDetalleExonerado").attr('checked', false);
	$("#CmpBoletaDetalleIncluyeSelectivo").attr('checked', false);
	
	
	$('#CmpBoletaDetalleAccion').val("AccBoletaDetalleRegistrar.php");
	
	$('#CmpBoletaDetalleCantidad').select();
	
	$('#CapBoletaDetalleAccion').html("Listo para registrar elementos");

}

function FncBoletaDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();
	
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var IncluyeImpuesto = 1;
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();	
	
	var BoletaDetalleTipo = $('#CmpBoletaDetalleTipo').val();
	
	var Descripcion = $('#CmpArticuloDescripcion').val();
	var Codigo = $('#CmpBoletaDetalleCodigo').val();
	var UnidadMedida = $('#CmpBoletaDetalleUnidadMedida').val();
	
	var Precio = $('#CmpBoletaDetallePrecio').val();
	var Cantidad = $('#CmpBoletaDetalleCantidad').val();
	var Importe = $('#CmpBoletaDetalleImporte').val();
	var Descuento = $('#CmpBoletaDetalleDescuento').val();
	
	if($("#CmpBoletaDetalleGratuito").is(':checked')){
		var Gratuito = 1;
	}else{
		var Gratuito = 2;
	}
	
	if($("#CmpBoletaDetalleExonerado").is(':checked')){
		var Exonerado = 1;
	}else{
		var Exonerado = 2;
	}
	
	if($("#CmpBoletaDetalleIncluyeSelectivo").is(':checked')){
		var IncluyeSelectivo = 1;
	}else{
		var IncluyeSelectivo = 2;
	}
	
	var Item = $('#CmpBoletaDetalleItem').val();

	var Acc = $('#CmpBoletaDetalleAccion').val();

		if(Descripcion==""){
			$('#CmpArticuloDescripcion').select();
		}else if(Precio==""){
			$('#CmpBoletaDetallePrecio').select();
		}else if(Cantidad=="" || Cantidad <=0){
				$('#CmpBoletaDetalleCantidad').select();	
		}else if(Importe==""){
			$('#CmpBoletaDetalleImporte').select();
		}else{
		
			$('#CapBoletaDetalleAccion').html('guardando...');
		
				$.ajax({
					type: 'POST',
					url: 'formularios/Boleta/acc/'+Acc,
					data: 'Identificador='+Identificador+
					'&Descripcion='+Descripcion+
					'&Codigo='+Codigo+
					'&UnidadMedida='+UnidadMedida+
										
					'&Precio='+Precio+
					'&Cantidad='+Cantidad+
					'&Importe='+Importe+
					'&Descuento='+Descuento+
						
					'&BoletaDetalleTipo='+BoletaDetalleTipo+
					
					'&Gratuito='+Gratuito+
					'&Exonerado='+Exonerado+
					'&IncluyeImpuesto='+IncluyeImpuesto+
					'&IncluyeSelectivo='+IncluyeSelectivo+
					
					'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
					'&PorcentajeImpuestoSelectivo='+PorcentajeImpuestoSelectivo+
					
					'&Item='+Item,
					
					success: function(){
						$('#CapBoletaDetalleAccion').html('Listo');							
						FncBoletaDetalleListar();
					}
				});

			//	if(confirm("Desea seguir agregando mas items?")==false){
//					if(confirm("Desea guardar el registro ahora?")){
//						$('#Guardar').val("1");
//						$('#'+Formulario).submit();
//					}
//				}

			FncBoletaDetalleNuevo();

		}
	
}


function FncBoletaDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapBoletaDetalleAccion').html('Cargando...');

	
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();	
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();
	
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var IncluyeImpuesto =1 ;
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var TotalDescuento = $('#CmpTotalDescuento').val();

	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();
	var TotalDescuentoGlobal = $('#CmpTotalDescuento').val();

	var ImpuestoVenta = 0;
	
	if(PorcentajeImpuestoVenta!=""){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}


	if(TipoCambio==""){
		TipoCambio = 1;
	}
	
	$.ajax({
		type: 'POST',
		url: 'formularios/Boleta/FrmBoletaDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&ImpuestoVenta='+ImpuestoVenta+
		'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
		'&PorcentajeImpuestoSelectivo='+PorcentajeImpuestoSelectivo+
		'&PorcentajeDescuento='+PorcentajeDescuento+
		
		'&IncluyeImpuesto='+IncluyeImpuesto+

		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio+
		'&Editar='+BoletaDetalleEditar+
		'&Eliminar='+BoletaDetalleEliminar+
		'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+
		'&TotalDescuento='+TotalDescuento+
	
		'&Editar='+BoletaDetalleEditar+
		'&Eliminar='+BoletaDetalleEliminar,
		
		
		success: function(html){
			$('#CapBoletaDetalleAccion').html('Listo');	
			$("#CapBoletaDetalles").html("");
			$("#CapBoletaDetalles").append(html);
		}
	});


//alert(MonedaSimbolo);
	$('#CapMonedaArticuloImporte').html(MonedaSimbolo);
	$('#CapMonedaArticuloPrecio').html(MonedaSimbolo);
	
}



function FncBoletaDetalleEscoger(oItem){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapBoletaDetalleAccion').html('Editando...');
	$('#CmpBoletaDetalleAccion').val("AccBoletaDetalleEditar.php");


/*
SesionObjeto-BoletaDetalleListado
Parametro1 = BdeId
Parametro2 = BdeDescripcion
Parametro3
Parametro4 = BdePrecio
Parametro5 = BdeCantidad
Parametro6 = BdeImporte
Parametro7 = BdeTiempoCreacion
Parametro8 = BdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = BdeTipo
Parametro13 = BdeUnidadMedida
Parametro14 = VcdReingreso
Parametro15 = AmdId
Parametro16 = FatId
Parametro17 = OvvId

Parametro18 = BdeCodigo
Parametro19 = BdeValorVenta
Parametro20 = BdeImpuesto
Parametro21 = BdeDescuentom
Parametro22 = BdeGratuito
Parametro23 = BdeExonerado					
*/

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Boleta/acc/AccBoletaDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsBoletaDetalle){
		
				$('#CmpBoletaDetalleTipo').val(InsBoletaDetalle.Parametro12);	
				$('#CmpArticuloDescripcion').val(InsBoletaDetalle.Parametro2);	
				
				$('#CmpBoletaDetalleCodigo').val(InsBoletaDetalle.Parametro18);		
				$('#CmpBoletaDetalleUnidadMedida').val(InsBoletaDetalle.Parametro13);	
					
				$('#CmpBoletaDetallePrecio').val(InsBoletaDetalle.Parametro4);		
				$('#CmpBoletaDetalleCantidad').val(InsBoletaDetalle.Parametro5);	
				$('#CmpBoletaDetalleImporte').val(InsBoletaDetalle.Parametro6);	
				$('#CmpBoletaDetalleValorVenta').val(InsBoletaDetalle.Parametro19);
				$('#CmpBoletaDetalleDescuento').val(InsBoletaDetalle.Parametro21);	
				$('#CmpBoletaDetalleImporte').select();
				
				if(InsBoletaDetalle.Parametro22=="1"){
					$("#CmpBoletaDetalleGratuito").attr('checked', true);
				}else{
					$("#CmpBoletaDetalleGratuito").attr('checked', false);
				}
				
				if(InsBoletaDetalle.Parametro23=="1"){
					$("#CmpBoletaDetalleExonerado").attr('checked', true);
				}else{
					$("#CmpBoletaDetalleExonerado").attr('checked', false);
				}
				
				if(InsBoletaDetalle.Parametro24=="1"){
					$("#CmpBoletaDetalleIncluyeSelectivo").attr('checked', true);
				}else{
					$("#CmpBoletaDetalleIncluyeSelectivo").attr('checked', false);
				}

				
				$('#CmpBoletaDetalleItem').val(InsBoletaDetalle.Item);

		}
	});
		
	$('#CmpBoletaDetalleCantidad').focus();
	
}


function FncBoletaDetalleEliminar(oItem){
	
	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapBoletaDetalleAccion').html('Eliminando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/Boleta/acc/AccBoletaDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapBoletaDetalleAccion').html("Eliminado");	
				FncBoletaDetalleListar();
			}
		});
		
		FncBoletaDetalleNuevo();

	}
	
}



function FncBoletaDetalleEliminarTodo(){
	
	var Identificador = $('#Identificador').val();
			
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapBoletaDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Boleta/acc/AccBoletaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapBoletaDetalleAccion').html('Eliminado');	
				FncBoletaDetalleListar();
			}
		});	
		
		FncBoletaDetalleNuevo();
	}
	
}

