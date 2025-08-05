
// JavaScript Document

function FncFacturaDetalleNuevo(){
	
	$('#CmpFacturaDetalleDescripcion').val("");
	$('#CmpArticuloId').val("");
	
	$('#CmpFacturaDetalleTipo').val("");
	
	$('#CmpFacturaDetalleCodigo').val("");
	$('#CmpFacturaDetalleUnidadMedida').val("");
	
	$('#CmpFacturaDetallePrecio').val("");
	$('#CmpFacturaDetalleCantidad').val("");
	$('#CmpFacturaDetalleDescuento').val("");
	$('#CmpFacturaDetalleImporte').val("");
	
	$("#CmpFacturaDetalleGratuito").attr('checked', false);
	$("#CmpFacturaDetalleExonerado").attr('checked', false);
	$("#CmpFacturaDetalleIncluyeSelectivo").attr('checked', false);
	
	$('#CmpFacturaDetalleItem').val("");
	$('#CmpFacturaDetalleAccion').val("AccFacturaDetalleRegistrar.php");
	$('#CmpFacturaDetalleDescripcion').select();
	$('#CapFacturaDetalleAccion').html("Listo para registrar elementos");
}

function FncFacturaDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();
	
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();

	var FacturaDetalleTipo = $('#CmpFacturaDetalleTipo').val();
	
	var Descripcion = $('#CmpFacturaDetalleDescripcion').val();
	var Codigo = $('#CmpFacturaDetalleCodigo').val();
	var UnidadMedida = $('#CmpFacturaDetalleUnidadMedida').val();
	
	var Precio = $('#CmpFacturaDetallePrecio').val();
	var Cantidad = $('#CmpFacturaDetalleCantidad').val();
	var Importe = $('#CmpFacturaDetalleImporte').val();
	var Descuento = $('#CmpFacturaDetalleDescuento').val();


	if($("#CmpFacturaDetalleGratuito").is(':checked')){
		var Gratuito = 1;
	}else{
		var Gratuito = 2;
	}
	
	if($("#CmpFacturaDetalleExonerado").is(':checked')){
		var Exonerado = 1;
	}else{
		var Exonerado = 2;
	}
	
	if($("#CmpFacturaDetalleIncluyeSelectivo").is(':checked')){
		var IncluyeSelectivo = 1;
	}else{
		var IncluyeSelectivo = 2;
	}

	
	var Item = $('#CmpFacturaDetalleItem').val();
	var Acc = $('#CmpFacturaDetalleAccion').val();
	
	if(Descripcion==""){
		$('#CmpFacturaDetalleDescripcion').select();	
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
				data: 'Identificador='+Identificador+
				'&Descripcion='+escape(Descripcion)+
				'&Codigo='+Codigo+
				'&UnidadMedida='+escape(UnidadMedida)+
				
				'&Precio='+Precio+
				'&Cantidad='+Cantidad+
				'&Importe='+Importe+				
				'&Descuento='+Descuento+
				
				'&FacturaDetalleTipo='+FacturaDetalleTipo+
				
				'&Gratuito='+Gratuito+
				'&Exonerado='+Exonerado+
				'&IncluyeImpuesto='+IncluyeImpuesto+
				'&IncluyeSelectivo='+IncluyeSelectivo+
				
				'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
				'&PorcentajeImpuestoSelectivo='+PorcentajeImpuestoSelectivo+
				
				'&Item='+Item,
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
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();	
	var PorcentajeDescuento = $('#CmpPorcentajeDescuento').val();
	
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
		
	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

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
		url: 'formularios/Factura/FrmFacturaDetalleListado.php',
		data: 'Identificador='+Identificador+
		'&ImpuestoVenta='+ImpuestoVenta+
		'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+
		'&PorcentajeImpuestoSelectivo='+PorcentajeImpuestoSelectivo+		
		'&PorcentajeDescuento='+PorcentajeDescuento+
		
		'&IncluyeImpuesto='+IncluyeImpuesto+

		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio+
		'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId+		
		'&TotalDescuentoGlobal='+TotalDescuentoGlobal+

		'&Editar='+FacturaDetalleEditar+
		'&Eliminar='+FacturaDetalleEliminar,		
		
		success: function(html){
			$('#CapFacturaDetalleAccion').html('Listo');	
			$("#CapFacturaDetalles").html("");
			$("#CapFacturaDetalles").append(html);
		}
	});
	
	//alert(MonedaSimbolo)
	//$('#CapMonedaArticuloImporte').html(MonedaSimbolo);
//	$('#CapMonedaArticuloPrecio').html(MonedaSimbolo);
//	$('#CapMonedaRegimenMonto').html(MonedaSimbolo);
//	$('#CapMonedaLetraMonto').html(MonedaSimbolo);	
	

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
		
				$('#CmpFacturaDetalleCodigo').val(InsFacturaDetalle.Parametro18);	
				$('#CmpFacturaDetalleUnidadMedida').val(InsFacturaDetalle.Parametro13);
				$('#CmpFacturaDetalleDescripcion').val(InsFacturaDetalle.Parametro2);
				
				$('#CmpFacturaDetalleTipo').val(InsFacturaDetalle.Parametro12);
				
				$('#CmpFacturaDetalleCantidad').val(InsFacturaDetalle.Parametro5);
				$('#CmpFacturaDetallePrecio').val(InsFacturaDetalle.Parametro4);
				$('#CmpFacturaDetalleImporte').val(InsFacturaDetalle.Parametro6);
				
				$('#CmpFacturaDetalleValorVenta').val(InsFacturaDetalle.Parametro19);
				$('#CmpFacturaDetalleDescuento').val(InsFacturaDetalle.Parametro21);
				$('#CmpFacturaDetalleImporte').select();
				
				if(InsFacturaDetalle.Parametro22=="1"){
					$("#CmpFacturaDetalleGratuito").attr('checked', true);
				}else{
					$("#CmpFacturaDetalleGratuito").attr('checked', false);
				}

				if(InsFacturaDetalle.Parametro23=="1"){
					$("#CmpFacturaDetalleExonerado").attr('checked', true);
				}else{
					$("#CmpFacturaDetalleExonerado").attr('checked', false);
				}

				if(InsFacturaDetalle.Parametro24=="1"){
					$("#CmpFacturaDetalleIncluyeSelectivo").attr('checked', true);
				}else{
					$("#CmpFacturaDetalleIncluyeSelectivo").attr('checked', false);
				}

				$('#CmpFacturaDetalleItem').val(InsFacturaDetalle.Item);
				
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
