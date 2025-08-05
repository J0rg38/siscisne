// JavaScript Document


function FncFacturaExportacionDetalleNuevo(){
	
	$('#CmpArticuloDescripcion').val("");
	$('#CmpArticuloId').val("");
	
	$('#CmpFacturaExportacionDetalleTipo').val("");
	$('#CmpFacturaExportacionDetalleUnidadMedida').val("");
	$('#CmpFacturaExportacionDetallePrecio').val("");
	$('#CmpFacturaExportacionDetalleCantidad').val("");
	$('#CmpFacturaExportacionDetalleImporte').val("");
	$('#CmpFacturaExportacionDetalleItem').val("");
	
	$('#CmpFacturaExportacionDetalleAccion').val("AccFacturaExportacionDetalleRegistrar.php");
	
	$('#CmpFacturaExportacionDetalleCantidad').select();
	
	$('#CapFacturaExportacionDetalleAccion').html("Listo para registrar elementos");

}

function FncFacturaExportacionDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();

	var FacturaExportacionDetalleTipo = $('#CmpFacturaExportacionDetalleTipo').val();
	
	var Descripcion = $('#CmpArticuloDescripcion').val();
	var UnidadMedida = $('#CmpFacturaExportacionDetalleUnidadMedida').val();
	var Precio = $('#CmpFacturaExportacionDetallePrecio').val();
	var Cantidad = $('#CmpFacturaExportacionDetalleCantidad').val();
	var Importe = $('#CmpFacturaExportacionDetalleImporte').val();
	
	var Item = $('#CmpFacturaExportacionDetalleItem').val();

	var Acc = $('#CmpFacturaExportacionDetalleAccion').val();

		if(Descripcion==""){
			$('#CmpArticuloDescripcion').select();
		}else if(Precio==""){
			$('#CmpFacturaExportacionDetallePrecio').select();
		}else if(Cantidad=="" || Cantidad <=0){
				$('#CmpFacturaExportacionDetalleCantidad').select();	
		}else if(Importe==""){
			$('#CmpFacturaExportacionDetalleImporte').select();
		}else{
		
			$('#CapFacturaExportacionDetalleAccion').html('guardando...');
		
				$.ajax({
					type: 'POST',
					url: 'formularios/FacturaExportacion/acc/'+Acc,
					data: 'Identificador='+Identificador+'&Descripcion='+Descripcion+'&UnidadMedida='+UnidadMedida+'&Precio='+Precio+'&Cantidad='+Cantidad+'&Importe='+Importe+'&FacturaExportacionDetalleTipo='+FacturaExportacionDetalleTipo+'&Item='+Item,
					success: function(){
						$('#CapFacturaExportacionDetalleAccion').html('Listo');							
						FncFacturaExportacionDetalleListar();
					}
				});

			//	if(confirm("Desea seguir agregando mas items?")==false){
//					if(confirm("Desea guardar el registro ahora?")){
//						$('#Guardar').val("1");
//						$('#'+Formulario).submit();
//					}
//				}

			FncFacturaExportacionDetalleNuevo();

		}
	
}


function FncFacturaExportacionDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapFacturaExportacionDetalleAccion').html('Cargando...');

	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();

	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	var ImpuestoVenta = 0;
	
	if(PorcentajeImpuestoVenta!=""){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/FacturaExportacion/FrmFacturaExportacionDetalleListado.php',
		data: 'Identificador='+Identificador+'&ImpuestoVenta='+ImpuestoVenta+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio+'&Editar='+FacturaExportacionDetalleEditar+'&Eliminar='+FacturaExportacionDetalleEliminar+'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapFacturaExportacionDetalleAccion').html('Listo');	
			$("#CapFacturaExportacionDetalles").html("");
			$("#CapFacturaExportacionDetalles").append(html);
		}
	});


//alert(MonedaSimbolo);
	$('#CapMonedaArticuloImporte').html(MonedaSimbolo);
	$('#CapMonedaArticuloPrecio').html(MonedaSimbolo);
	
}



function FncFacturaExportacionDetalleEscoger(oItem){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapFacturaExportacionDetalleAccion').html('Editando...');
	$('#CmpFacturaExportacionDetalleAccion').val("AccFacturaExportacionDetalleEditar.php");


/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FedId
Parametro2 = FedDescripcion
Parametro3
Parametro4 = FedPrecio
Parametro5 = FedCantidad
Parametro6 = FedImporte
Parametro7 = FedTiempoCreacion
Parametro8 = FedTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FedTipo
Parametro13 = FedUnidadMedida
*/

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FacturaExportacion/acc/AccFacturaExportacionDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsFacturaExportacionDetalle){
		
				$('#CmpFacturaExportacionDetalleTipo').val(InsFacturaExportacionDetalle.Parametro12);	
				$('#CmpArticuloDescripcion').val(InsFacturaExportacionDetalle.Parametro2);	
				$('#CmpFacturaExportacionDetalleUnidadMedida').val(InsFacturaExportacionDetalle.Parametro13);		
				$('#CmpFacturaExportacionDetallePrecio').val(InsFacturaExportacionDetalle.Parametro4);		
				$('#CmpFacturaExportacionDetalleCantidad').val(InsFacturaExportacionDetalle.Parametro5);		
				$('#CmpFacturaExportacionDetalleImporte').val(InsFacturaExportacionDetalle.Parametro6);	
				$('#CmpFacturaExportacionDetalleItem').val(InsFacturaExportacionDetalle.Item);

		}
	});
		
	$('#CmpFacturaExportacionDetalleCantidad').focus();
	
}


function FncFacturaExportacionDetalleEliminar(oItem){
	
	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFacturaExportacionDetalleAccion').html('Eliminando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/FacturaExportacion/acc/AccFacturaExportacionDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapFacturaExportacionDetalleAccion').html("Eliminado");	
				FncFacturaExportacionDetalleListar();
			}
		});
		
		FncFacturaExportacionDetalleNuevo();

	}
	
}



function FncFacturaExportacionDetalleEliminarTodo(){
	
	var Identificador = $('#Identificador').val();
			
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapFacturaExportacionDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FacturaExportacion/acc/AccFacturaExportacionDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFacturaExportacionDetalleAccion').html('Eliminado');	
				FncFacturaExportacionDetalleListar();
			}
		});	
		
		FncFacturaExportacionDetalleNuevo();
	}
	
}

