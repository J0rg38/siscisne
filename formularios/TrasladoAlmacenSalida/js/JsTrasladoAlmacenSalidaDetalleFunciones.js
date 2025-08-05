// JavaScript Document

function FncTrasladoAlmacenSalidaDetalleNuevo(){
	
	$('#CmpProductoId').val("");
	$('#CmpProductoNombre').val("");

	//$('#CmpProductoCosto').val("");
	//$('#CmpProductoPrecio').val("");
	//$('#CmpProductoPrecioAux').val("");
	
	$('#CmpProductoCantidad').val("");

	//$('#CmpProductoImporte').val("");
	$('#CmpProductoItem').val("");	

	$('#CmpProductoCodigoOriginal').val("");	
	$('#CmpProductoCodigoAlternativo').val("");	
			
	$('#CapProductoAccion').html('Listo para registrar elementos');	
			
	$('#CmpProductoCodigoOriginal').select();
			
	$('#CmpTrasladoAlmacenSalidaDetalleAccion').val("AccTrasladoAlmacenSalidaDetalleRegistrar.php");

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

function FncTrasladoAlmacenSalidaDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpTrasladoAlmacenSalidaDetalleAccion').val();		
	
			var ProductoId = $('#CmpProductoId').val();
			var ProductoNombre = $('#CmpProductoNombre').val();
			var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
			var ProductoCantidad = $('#CmpProductoCantidad').val();
			var TrasladoAlmacenSalidaDetalleEstado = $('#CmpTrasladoAlmacenSalidaDetalleEstado').val();
			var ProductoUnidadMedida = $('#CmpProductoUnidadMedida').val();
			var Item = $('#CmpProductoItem').val();
	
			if(ProductoNombre==""){
				$('#CmpProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#CmpProductoUnidadMedidaConvertir').focus();	
			//}else if(ProductoCantidad=="" || ProductoCantidad <=0){
			}else if(ProductoCantidad==""){				
				$('#CmpProductoCantidad').select();	
			}else{
				$('#CapProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/TrasladoAlmacenSalida/acc/'+Acc,
							data: 'Identificador='+Identificador+
							'&ProductoId='+ProductoId+
							'&ProductoCantidad='+ProductoCantidad+
							'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
							'&ProductoUnidadMedida='+ProductoUnidadMedida+
							'&TrasladoAlmacenSalidaDetalleEstado='+TrasladoAlmacenSalidaDetalleEstado+
							
							'&Item='+Item,
							success: function(){
								
							$('#CapProductoAccion').html('Listo');							
								FncTrasladoAlmacenSalidaDetalleListar();
							}
						});
						
//								if(confirm("Desea seguir agregando mas items?")==false){
//									if(confirm("Desea guardar el registro ahora?")){
//										$('#Guardar').val("1");
//										$('#'+Formulario).submit();
//									}
//								}


							FncTrasladoAlmacenSalidaDetalleNuevo();	
					
					
				}
			

	
}


function FncTrasladoAlmacenSalidaDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');

	var Descuento = $('#CmpDescuento').val();
	var AlmacenId = $('#CmpAlmacen').val();

	$.ajax({
		type: 'POST',
		url: 'formularios/TrasladoAlmacenSalida/FrmTrasladoAlmacenSalidaDetalleListado.php',
		data: 'Identificador='+Identificador+
				'&Editar='+TrasladoAlmacenSalidaDetalleEditar+
				'&Eliminar='+TrasladoAlmacenSalidaDetalleEliminar+
				'&AlmacenId='+AlmacenId+
				'&Descuento='+Descuento,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapTrasladoAlmacenSalidaDetalles").html("");
			$("#CapTrasladoAlmacenSalidaDetalles").append(html);
		}
	});
	
}

function FncTrasladoAlmacenSalidaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Editando...');
	$('#CmpTrasladoAlmacenSalidaDetalleAccion').val("AccTrasladoAlmacenSalidaDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TrasladoAlmacenSalida/acc/AccTrasladoAlmacenSalidaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsTrasladoAlmacenSalidaDetalle){
			
			
	/*
	SesionObjeto-TrasladoAlmacenSalidaDetalle
	Parametro1 = AmdId
	Parametro2 = ProId
	Parametro3 = ProNombre
	Parametro4 = AmdPrecio
	Parametro5 = AmdCantidad
	Parametro6 = AmdImporte
	Parametro7 = AmdTiempoCreacion
	Parametro8 = AmdTiempoModificacion
	Parametro9 = UmeNombre
	Parametro10 = UmeId
	Parametro11 = RtiId
	Parametro12 = AmdCantidadReal
	Parametro13 = ProCodigoOriginal,
	Parametro14 = ProCodigoAlternativo
	Parametro15 = UmeIdOrigen
	Parametro16 = VerificarStock
	Parametro17 = AmdCosto
	*/
	
				$('#CmpProductoId').val(InsTrasladoAlmacenSalidaDetalle.Parametro2);	
				$('#CmpProductoCodigoOriginal').val(InsTrasladoAlmacenSalidaDetalle.Parametro13);
				$('#CmpProductoCodigoAlternativo').val(InsTrasladoAlmacenSalidaDetalle.Parametro14);
				$('#CmpProductoUnidadMedidaEquivalente').val(1);
				$('#CmpProductoNombre').val(InsTrasladoAlmacenSalidaDetalle.Parametro3);		
				//$('#CmpProductoCosto').val(InsTrasladoAlmacenSalidaDetalle.Parametro17);
				//$('#CmpProductoPrecio').val(InsTrasladoAlmacenSalidaDetalle.Parametro4);	
				$('#CmpProductoCantidad').val(InsTrasladoAlmacenSalidaDetalle.Parametro5);
				//$('#CmpProductoImporte').val(InsTrasladoAlmacenSalidaDetalle.Parametro6);
				$('#CmpProductoItem').val(InsTrasladoAlmacenSalidaDetalle.Item);

				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsTrasladoAlmacenSalidaDetalle.Parametro11+"&Tipo=2&UnidadMedidaId="+InsTrasladoAlmacenSalidaDetalle.Parametro15,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsTrasladoAlmacenSalidaDetalle.Parametro10){
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

function FncTrasladoAlmacenSalidaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapProductoAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoAlmacenSalida/acc/AccTrasladoAlmacenSalidaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapProductoAccion').html("Eliminado");	
				FncTrasladoAlmacenSalidaDetalleListar();
			}
		});

		FncTrasladoAlmacenSalidaDetalleNuevo();

	}
	
}


function FncTrasladoAlmacenSalidaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoAlmacenSalida/acc/AccTrasladoAlmacenSalidaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapProductoAccion').html('Eliminado');	
				FncTrasladoAlmacenSalidaDetalleListar();
			}
		});	
			
		FncTrasladoAlmacenSalidaDetalleNuevo();
	}
	
}


function FncTrasladoAlmacenSalidaDetalleActualizarPrecio(){

	var Identificador = $('#Identificador').val();
	var ClienteTipoId = $('#CmpClienteTipo').val();

		$('#CapProductoAccion').html('Actualizando Precios...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/TrasladoAlmacenSalida/acc/AccTrasladoAlmacenSalidaDetalleActualizarPrecio.php',
			data: 'Identificador='+Identificador+
'&ClienteTipoId='+ClienteTipoId,
			success: function(){
				$('#CapProductoAccion').html('Listo');	
				FncTrasladoAlmacenSalidaDetalleListar();
			}
		});	

	FncTrasladoAlmacenSalidaDetalleNuevo();
	
}


$().ready(function() {

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


