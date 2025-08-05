// JavaScript Document

function FncTrasladoProductoDetalleNuevo(){
	
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
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpTrasladoProductoDetalleAccion').val("AccTrasladoProductoDetalleRegistrar.php");

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

function FncTrasladoProductoDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpTrasladoProductoDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCosto = $('#CmpProductoCosto').val();
			var ProductoPrecio = $('#CmpProductoPrecio').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var ProductoImporte = $('#CmpProductoImporte').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
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
							url: 'formularios/TrasladoProducto/acc/'+Acc,
							data: 'Identificador='+Identificador+
'&ProductoId='+ProductoId+
'&ProductoCosto='+ProductoCosto+
'&ProductoPrecio='+ProductoPrecio+
'&ProductoCantidad='+ProductoCantidad+
'&ProductoImporte='+ProductoImporte+
'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
'&ProductoUnidadMedida='+ProductoUnidadMedida+
'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncTrasladoProductoDetalleListar();
							}
						});
						
//								if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}


							FncTrasladoProductoDetalleNuevo();	
					
					
				}
			

	
}


function FncTrasladoProductoDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');

	var Descuento = $('#CmpDescuento').val();
	var AlmacenId = $('#CmpAlmacen').val();
	var Sucursal = $('#CmpSucursal').val();

	$.ajax({
		type: 'POST',
		url: 'formularios/TrasladoProducto/FrmTrasladoProductoDetalleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+TrasladoProductoDetalleEditar+
'&Eliminar='+TrasladoProductoDetalleEliminar+
'&SucursalId='+Sucursal+
'&AlmacenId='+AlmacenId+
'&Descuento='+Descuento,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapTrasladoProductoDetalles").html("");
			$("#CapTrasladoProductoDetalles").append(html);
		}
	});
	
}

function FncTrasladoProductoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpTrasladoProductoDetalleAccion').val("AccTrasladoProductoDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TrasladoProducto/acc/AccTrasladoProductoDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsTrasladoProductoDetalle){
			
			
	/*
	SesionObjeto-TrasladoProductoDetalle
	Parametro1 = TpdId
	Parametro2 = ProId
	Parametro3 = ProNombre
	Parametro4 = TpdPrecio
	Parametro5 = TpdCantidad
	Parametro6 = TpdImporte
	Parametro7 = TpdTiempoCreacion
	Parametro8 = TpdTiempoModificacion
	Parametro9 = UmeNombre
	Parametro10 = UmeId
	Parametro11 = RtiId
	Parametro12 = TpdCantidadReal
	Parametro13 = ProCodigoOriginal,
	Parametro14 = ProCodigoAlternativo
	Parametro15 = UmeIdOrigen
	Parametro16 = VerificarStock
	Parametro17 = TpdCosto
	*/
	
				$('#CmpProductoId').val(InsTrasladoProductoDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsTrasladoProductoDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsTrasladoProductoDetalle.Parametro14);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoNombre').val(InsTrasladoProductoDetalle.Parametro3);		
				$('#CmpProductoCosto').val(InsTrasladoProductoDetalle.Parametro17);
				$('#CmpProductoPrecio').val(InsTrasladoProductoDetalle.Parametro4);	
				$('#CmpProductoCantidad').val(InsTrasladoProductoDetalle.Parametro5);
				$('#CmpProductoImporte').val(InsTrasladoProductoDetalle.Parametro6);
				$('#CmpProductoItem').val(InsTrasladoProductoDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsTrasladoProductoDetalle.Parametro11+"&Tipo=2&UnidadMedidaId="+InsTrasladoProductoDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsTrasladoProductoDetalle.Parametro10){
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

function FncTrasladoProductoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoProducto/acc/AccTrasladoProductoDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncTrasladoProductoDetalleListar();
			}
		});

		FncTrasladoProductoDetalleNuevo();

	}
	
}


function FncTrasladoProductoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoProducto/acc/AccTrasladoProductoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncTrasladoProductoDetalleListar();
			}
		});	
			
		FncTrasladoProductoDetalleNuevo();
	}
	
}


function FncTrasladoProductoDetalleActualizarPrecio(){

	var Identificador = $('#Identificador').val();
	var ClienteTipoId = $('#CmpClienteTipo').val();

		$('#CapProductoAccion').html('Actualizando Precios...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoProducto/acc/AccTrasladoProductoDetalleActualizarPrecio.php',
			data: 'Identificador='+Identificador+
'&ClienteTipoId='+ClienteTipoId,
			success: function(){
				$('#CapProductoAccion').html('Listo');	
				FncTrasladoProductoDetalleListar();
			}
		});	

	FncTrasladoProductoDetalleNuevo();
	
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


