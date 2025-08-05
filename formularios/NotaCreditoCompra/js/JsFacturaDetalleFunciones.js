// JavaScript Document

function FncFacturaDetalleNuevo(){
	$('#CmpArticuloDescripcion').val("");
	$('#CmpArticuloId').val("");
	
	$('#CmpFacturaDetalleTipo').val("");
	$('#CmpFacturaDetalleUnidadMedida').val("");
	$('#CmpFacturaDetallePrecio').val("");
	$('#CmpFacturaDetalleCantidad').val("");
	$('#CmpFacturaDetalleImporte').val("");
	
	$('#CmpFacturaDetalleItem').val("");
	$('#CmpFacturaDetalleAccion').val("AccFacturaDetalleRegistrar.php");
	$('#CmpArticuloDescripcion').select();
	$('#CapFacturaDetalleAccion').html("Listo para registrar elementos");
}

function FncFacturaDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var FacturaDetalleTipo = $('#CmpFacturaDetalleTipo').val();
	var Descripcion = $('#CmpArticuloDescripcion').val();
	var UnidadMedida = $('#CmpFacturaDetalleUnidadMedida').val();
	var Precio = $('#CmpFacturaDetallePrecio').val();
	var Cantidad = $('#CmpFacturaDetalleCantidad').val();
	var Importe = $('#CmpFacturaDetalleImporte').val();

	var Item = $('#CmpFacturaDetalleItem').val();
	var Acc = $('#CmpFacturaDetalleAccion').val();
	
	if(Descripcion==""){
		$('#CmpArticuloDescripcion').select();	
	}else if(Precio==""){
		$('#CmpFacturaDetallePrecio').select();	
	}else if(Cantidad=="" || Cantidad <=0){
		$('#CmpFacturaDetalleCantidad').select();	
	}else if(Importe==""){
		$('#CmpFacturaDetalleImporte').select();	
	}else{

		$('#CapFacturaDetalleAccion').html('Guardando...');
		//Descripcion=Descripcion.replace("+","##45##");				
			$.ajax({
				type: 'POST',
				url: 'formularios/Factura/acc/'+Acc,
				data: 'Identificador='+Identificador+'&Descripcion='+escape(Descripcion)+'&UnidadMedida='+escape(UnidadMedida)+'&Precio='+Precio+'&Cantidad='+Cantidad+'&Importe='+Importe+'&FacturaDetalleTipo='+FacturaDetalleTipo+'&Item='+Item,
				success: function(){
					$('#CapFacturaDetalleAccion').html('Listo');							
					FncFacturaDetalleListar();
				}
			});

			//if(confirm("Desea seguir agregando mas items?")==false){
//				if(confirm("Desea guardar el registro ahora?")){
//					$('#Guardar').val("1");
//					$('#'+Formulario).submit();
//				}
//			}

			FncFacturaDetalleNuevo();
	}		
}


function FncFacturaDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapFacturaDetalleAccion').html('Cargando...');

	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	var ImpuestoVenta = 0;

	if(PorcentajeImpuestoVenta!==""){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}

	if(TipoCambio==""){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/Factura/FrmFacturaDetalleListado.php',
		data: 'Identificador='+Identificador+'&ImpuestoVenta='+ImpuestoVenta+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&Editar='+FacturaDetalleEditar+'&Eliminar='+FacturaDetalleEliminar+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio+'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+'&IncluyeImpuesto='+IncluyeImpuesto,
		success: function(html){
			$('#CapFacturaDetalleAccion').html('Listo');	
			$("#CapFacturaDetalles").html("");
			$("#CapFacturaDetalles").append(html);
		}
	});
	
	//alert(MonedaSimbolo)
	$('#CapMonedaArticuloImporte').html(MonedaSimbolo);
	$('#CapMonedaArticuloPrecio').html(MonedaSimbolo);
	$('#CapMonedaRegimenMonto').html(MonedaSimbolo);
	$('#CapMonedaLetraMonto').html(MonedaSimbolo);	
	

}


function FncFacturaDetalleEscoger(oItem){



/*
SesionObjeto-FacturaDetalleListado
Parametro1 = FdeId
Parametro2 = FdeDescripcion
Parametro3
Parametro4 = FdePrecio
Parametro5 = FdeCantidad
Parametro6 = FdeImporte
Parametro7 = FdeTiempoCreacion
Parametro8 = FdeTiempoModificacion
Parametro9 = AmdId
Parametro10 = AmoId
Parametro11 =
Parametro12 = FdeTipo
Parametro13 = FdeUnidadMedida

*/

	var Identificador = $('#Identificador').val();

	$('#CapFacturaDetalleAccion').html('Editando...');
	$('#CmpFacturaDetalleAccion').val("AccFacturaDetalleEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Factura/acc/AccFacturaDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsFacturaDetalle){
		
				$('#CmpFacturaDetalleTipo').val(InsFacturaDetalle.Parametro12);
				$('#CmpArticuloDescripcion').val(InsFacturaDetalle.Parametro2);
				$('#CmpFacturaDetalleUnidadMedida').val(InsFacturaDetalle.Parametro13);
				$('#CmpFacturaDetallePrecio').val(InsFacturaDetalle.Parametro4);
				$('#CmpFacturaDetalleCantidad').val(InsFacturaDetalle.Parametro5);
				$('#CmpFacturaDetalleImporte').val(InsFacturaDetalle.Parametro6);
				$('#CmpFacturaDetalleItem').val(InsFacturaDetalle.Item);
				
				$('#CmpFacturaDetalleImporte').select();
		}
	});


	

}



function FncFacturaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFacturaDetalleAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/Factura/acc/AccFacturaDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapFacturaDetalleAccion').html("Eliminado");	
				FncFacturaDetalleListar();
			}
		});

		FncFacturaDetalleNuevo();
		

	}


	
}

function FncFacturaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapFacturaDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Factura/acc/AccFacturaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFacturaDetalleAccion').html('Eliminado');	
				FncFacturaDetalleListar();
			}
		});	
		
		FncFacturaDetalleNuevo();
	}
	
}



