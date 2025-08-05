// JavaScript Document

function FncServicioDetalleNuevo(){
	
	$('#CmpProductoNombre').val("");
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoUnidadMedidaConvertir').val("");
	$('#CmpServicioDetalleCantidad').val("");
	
	$("select#CmpProductoUnidadMedidaConvertir").html('');
	
	$('#CmpServicioDetalleItem').val("");
	
	$('#CmpServicioDetalleAccion').val("AccServicioDetalleRegistrar.php");
	$('#CmpProductoNombre').select();
	$('#CapServicioDetalleAccion').html("Listo para registrar elementos");
	
	$('#CmpProductoNombre').removeAttr('readonly');
	
	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").hide();
	$("#BtnProductoRegistrar").show();
	
}

function FncServicioDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var ProductoId = $('#CmpProductoId').val();
	var ProductoNombre = $('#CmpProductoNombre').val();
	var ProductoUnidadMedidaConvertir = $('#CmpProductoUnidadMedidaConvertir').val();
	var ServicioDetalleCantidad = $('#CmpServicioDetalleCantidad').val();
	
	var Item = $('#CmpServicioDetalleItem').val();
	var Acc = $('#CmpServicioDetalleAccion').val();
	
	if(ProductoId == ""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Ingresa nuevamente el producto",
			callback: function(result){
				$('#CmpProductoNombre').select();
			}
		});	
	
	}else if(ProductoNombre == ""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Ingresa nuevamente el producto",
			callback: function(result){
				$('#CmpProductoNombre').select();
			}
		});	
		
	}else if(ProductoUnidadMedidaConvertir == ""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger una unidad de medida",
			callback: function(result){
				$('#CmpProductoUnidadMedidaConvertir').select();
			}
		});	
		
	}else if(ServicioDetalleCantidad == "0.00" || ServicioDetalleCantidad == "0" || ServicioDetalleCantidad == ""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar una cantidad",
			callback: function(result){
				$('#CmpProductoUnidadMedidaConvertir').select();
			}
		});	
		
	}else{
		
		$('#CapServicioDetalleAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/Servicio/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&ProductoId='+(ProductoId)+
			'&ProductoNombre='+(ProductoNombre)+
			'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+
			'&ServicioDetalleCantidad='+ServicioDetalleCantidad+
			'&Item='+Item,
			success: function(){
				$('#CapServicioDetalleAccion').html('Listo');							
				FncServicioDetalleListar();
			}
		});

		FncServicioDetalleNuevo();
	}		
}


function FncServicioDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapServicioDetalleAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/Servicio/FrmServicioDetalleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+ServicioDetalleEditar+
'&Eliminar='+ServicioDetalleEliminar,
		success: function(html){
			$('#CapServicioDetalleAccion').html('Listo');	
			$("#CapServicioDetalles").html("");
			$("#CapServicioDetalles").append(html);
		}
	});

}


function FncServicioDetalleEscoger(oItem){

//SesionObjeto-ServicioDetalle
//Parametro1 = SdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = SdeCantidad
//Parametro5 = SdeImporte
//Parametro6 = SdeEstado
//Parametro7 = SdeTiempoCreacion
//Parametro8 = SdeTiempoModificacion
//Parametro10 = ProNombre
//Parametro11 = ProCodigoOriginal
//Parametro12 = ProCodigoAlternativo
//Parametro13 = RtiId
//Parametro14 = UmeNombre

	var Identificador = $('#Identificador').val();

	$('#CapServicioDetalleAccion').html('Editando...');
	$('#CmpServicioDetalleAccion').val("AccServicioDetalleEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Servicio/acc/AccServicioDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsServicioDetalle){
			
			$('#CmpProductoId').val(InsServicioDetalle.Parametro2);			
			$('#CmpProductoNombre').val(InsServicioDetalle.Parametro10);
			$('#CmpProductoCodigoOriginal').val(InsServicioDetalle.Parametro11);
			$('#CmpServicioDetalleCantidad').val(InsServicioDetalle.Parametro4);
		
			$('#CmpServicioDetalleItem').val(InsServicioDetalle.Item);
			
			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsServicioDetalle.Parametro13+"&Tipo=1&UnidadMedidaId="+InsServicioDetalle.Parametro3,{}, function(j){
				var options = '';
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(j[i].UmeId == InsServicioDetalle.Parametro3){
						options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}else{
						options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
					}
				}
				$("select#CmpProductoUnidadMedidaConvertir").html(options);
			})
			
			$('#CmpServicioDetalleCantidad').select();
		}
	});

	$('#CmpProductoNombre').attr('readonly', true);

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnProductoEditar").show();
	$("#BtnProductoRegistrar").hide();

}

function FncServicioDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapServicioDetalleAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/Servicio/acc/AccServicioDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapServicioDetalleAccion').html("Eliminado");	
				FncServicioDetalleListar();
			}
		});

		FncServicioDetalleNuevo();
		

	}


	
}

function FncServicioDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapServicioDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Servicio/acc/AccServicioDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapServicioDetalleAccion').html('Eliminado');	
				FncServicioDetalleListar();
			}
		});	
		
		FncServicioDetalleNuevo();
	}
	
}



