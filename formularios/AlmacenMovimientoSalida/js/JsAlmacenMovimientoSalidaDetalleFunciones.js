// JavaScript Document

function FncAlmacenMovimientoSalidaDetalleNuevo(){
	
	var Almacen = $("#CmpAlmacen");
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");

	$('#CmpProductoCosto').val("");
	$('#CmpProductoPrecio').val("");
	$('#CmpProductoPrecioAux').val("");
	
	$('#CmpProductoCantidad').val("");

	$('#CmpProductoImporte').val("");
	$('#CmpProductoItem').val("");	

	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
	
	$('#CmpAlmacenId').val(Almacen);	
	$('#CmpAlmacenMovimientoSalidaFecha').val(FechaHoy);	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpAlmacenMovimientoSalidaDetalleAccion').val("AccAlmacenMovimientoSalidaDetalleRegistrar.php");

	$('#CmpProductoUnidadMedida').val("");
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	$('#CmpProductoUnidadMedidaEquivalente').val("");
	
	$('#CmpProductoId').removeAttr('readonly');
	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#CmpProductoNombre').removeAttr('readonly');
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
	
	$("#BtnListaPrecioEditar").hide();
}

function FncAlmacenMovimientoSalidaDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpAlmacenMovimientoSalidaDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCosto = $('#CmpProductoCosto').val();
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			
			var AlmacenId = $('#CmpAlmacenId').val();
			var AlmacenMovimientoSalidaDetalleFecha = $('#CmpAlmacenMovimientoSalidaDetalleFecha').val();
			
			var Item = $('#CmpProductoItem').val();
	
			if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			//}else if(ProductoCantidad=="" || ProductoCantidad <=0){
			}else if(ProductoCantidad==""){				
				$('#CmpProductoCantidad').select();	
			//}else if(ProductoPrecio==""|| ProductoPrecio=="0"){
			}else if(ProductoPrecio==""){
				$('#CmpProductoPrecio').select();	
			}else if(ProductoImporte==""){
				$('#CmpProductoImporte').select();						
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/AlmacenMovimientoSalida/acc/'+Acc,
							data: 'Identificador='+Identificador+
'&ProductoId='+ProductoId+
'&ProductoCosto='+ProductoCosto+
'&ProductoPrecio='+ProductoPrecio+
'&ProductoCantidad='+ProductoCantidad+
'&ProductoImporte='+ProductoImporte+
'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
'&ProductoUnidadMedida='+ProductoUnidadMedida+
'&AlmacenId='+AlmacenId+
'&AlmacenMovimientoSalidaDetalleFecha='+AlmacenMovimientoSalidaDetalleFecha+
'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncAlmacenMovimientoSalidaDetalleListar();
							}
						});
						
//								if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}


							FncAlmacenMovimientoSalidaDetalleNuevo();	
					
					
				}
			

	
}


function FncAlmacenMovimientoSalidaDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');

	var Descuento = $('#CmpDescuento').val();
	var AlmacenId = $('#CmpAlmacen').val();
	var SucursalId = $('#CmpSucursalId').val();

	$.ajax({
		type: 'POST',
		url: 'formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaDetalleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+AlmacenMovimientoSalidaDetalleEditar+
'&Eliminar='+AlmacenMovimientoSalidaDetalleEliminar+
'&AlmacenId='+AlmacenId+
'&SucursalId='+SucursalId+


'&Descuento='+Descuento,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapAlmacenMovimientoSalidaDetalles").html("");
			$("#CapAlmacenMovimientoSalidaDetalles").append(html);
		}
	});
	
}

function FncAlmacenMovimientoSalidaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpAlmacenMovimientoSalidaDetalleAccion').val("AccAlmacenMovimientoSalidaDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/AlmacenMovimientoSalida/acc/AccAlmacenMovimientoSalidaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsAlmacenMovimientoSalidaDetalle){
			
			
			//	SesionObjeto-AlmacenMovimientoSalidaDetalle
//	Parametro1 = AmdId
//	Parametro2 = ProId
//	Parametro3 = ProNombre
//	Parametro4 = AmdPrecio
//	Parametro5 = AmdCantidad
//	Parametro6 = AmdImporte
//	Parametro7 = AmdTiempoCreacion
//	Parametro8 = AmdTiempoModificacion
//	Parametro9 = UmeNombre
//	Parametro10 = UmeId
//	Parametro11 = RtiId
//	Parametro12 = AmdCantidadReal
//	Parametro13 = ProCodigoOriginal,
//	Parametro14 = ProCodigoAlternativo
//	Parametro15 = UmeIdOrigen
//	Parametro16 = VerificarStock
//	Parametro17 = AmdCosto
//	Parametro18 = AmdCantidadRealAnterior
//	Parametro19 = AmdEstado

//	Parametro20 = AlmId
//	Parametro21 = AmdFecha
//	
	
	
				$('#CmpProductoId').val(InsAlmacenMovimientoSalidaDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsAlmacenMovimientoSalidaDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsAlmacenMovimientoSalidaDetalle.Parametro14);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoNombre').val(InsAlmacenMovimientoSalidaDetalle.Parametro3);		
				$('#CmpProductoCosto').val(InsAlmacenMovimientoSalidaDetalle.Parametro17);
				$('#CmpProductoPrecio').val(InsAlmacenMovimientoSalidaDetalle.Parametro4);	
				$('#CmpProductoCantidad').val(InsAlmacenMovimientoSalidaDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsAlmacenMovimientoSalidaDetalle.Parametro6);
				
				$('#CmpAlmacenId').val(InsAlmacenMovimientoSalidaDetalle.Parametro20);
				$('#CmpAlmacenMovimientoSalidaDetalleFecha').val(InsAlmacenMovimientoSalidaDetalle.Parametro21);
				
				$('#CmpProductoItem').val(InsAlmacenMovimientoSalidaDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsAlmacenMovimientoSalidaDetalle.Parametro11+"&Tipo=2&UnidadMedidaId="+InsAlmacenMovimientoSalidaDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsAlmacenMovimientoSalidaDetalle.Parametro10){
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
	$('#CmpProductoCodigoOriginal').attr('readonly', true);
	$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#CmpProductoNombre').attr('readonly', true);

	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();
	
	$("#BtnListaPrecioEditar").show();


}

function FncAlmacenMovimientoSalidaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/AlmacenMovimientoSalida/acc/AccAlmacenMovimientoSalidaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncAlmacenMovimientoSalidaDetalleListar();
			}
		});

		FncAlmacenMovimientoSalidaDetalleNuevo();

	}
	
}


function FncAlmacenMovimientoSalidaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/AlmacenMovimientoSalida/acc/AccAlmacenMovimientoSalidaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncAlmacenMovimientoSalidaDetalleListar();
			}
		});	
			
		FncAlmacenMovimientoSalidaDetalleNuevo();
	}
	
}


function FncAlmacenMovimientoSalidaDetalleActualizarPrecio(){

	var Identificador = $('#Identificador').val();
	var ClienteTipoId = $('#CmpClienteTipo').val();

		$('#CapProductoAccion').html('Actualizando Precios...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/AlmacenMovimientoSalida/acc/AccAlmacenMovimientoSalidaDetalleActualizarPrecio.php',
			data: 'Identificador='+Identificador+
'&ClienteTipoId='+ClienteTipoId,
			success: function(){
				$('#CapProductoAccion').html('Listo');	
				FncAlmacenMovimientoSalidaDetalleListar();
			}
		});	

	FncAlmacenMovimientoSalidaDetalleNuevo();
	
}


$().ready(function() {

	$("#CmpProductoImporte").keyup(function (event) {  
		FncProductoCalcularMonto("Precio")
	});
	
	$("#CmpProductoPrecio").keyup(function (event) {  
		FncProductoCalcularImporte("Precio")
	
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


