// JavaScript Document

function FncFichaAccionProductoNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'ProductoId').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoItem').val("");	
			
	//$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val("");	
	//$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val("");	
	
	$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedida').val("");
	$('select#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').html('');
	$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaEquivalente').val("");	
	
	$('#Cmp'+oModalidadIngreso+'ProductoCantidad').val("")

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo para registrar elementos');				
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').focus();			
	$('#CmpFichaAccion'+oModalidadIngreso+'ProductoAccion').val("AccFichaAccionProductoRegistrar.php");
	
//	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
//	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').removeAttr('readonly');
//	$('#CmpProductoUnidadMedidaConvertir').attr('disabled', false);
	

}

function FncFichaAccionProductoGuardar(oModalidadIngreso){

//alert(":3");
		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpFichaAccion'+oModalidadIngreso+'ProductoAccion').val();		
	
			var ProductoId = $('#Cmp'+oModalidadIngreso+'ProductoId').val();
			var ProductoNombre = $('#Cmp'+oModalidadIngreso+'ProductoNombre').val();
			var ProductoCodigoOriginal = $('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val();
			var ProductoCodigoAlternativo = $('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val();
			var Item = $('#Cmp'+oModalidadIngreso+'ProductoItem').val();
	
			var ProductoUnidadMedidaConvertir = $('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').val();
			var ProductoCantidad = $('#Cmp'+oModalidadIngreso+'ProductoCantidad').val();
			var ProductoUnidadMedida = $('#Cmp'+oModalidadIngreso+'ProductoUnidadMedida').val();
			
			if(ProductoNombre==""){
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').select();	
			}else if(ProductoUnidadMedidaConvertir==""){
				$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').focus();	
			}else if(ProductoCantidad=="" || ProductoCantidad <=0){
				$('#Cmp'+oModalidadIngreso+'ProductoCantidad').select();	
			}else{
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/FichaAccion/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ProductoCodigoOriginal='+ProductoCodigoOriginal+'&ProductoCodigoAlternativo='+ProductoCodigoAlternativo+'&ProductoNombre='+ProductoNombre+'&ProductoId='+ProductoId+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoCantidad='+ProductoCantidad+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(rpta){
								
								
								if(rpta != "" ){
									alert(rpta);
								}
								
							$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');							
								FncFichaAccionProductoListar(oModalidadIngreso);
							}
						});
						
						FncFichaAccionProductoNuevo(oModalidadIngreso);	
					
				}
			

	
}


function FncFichaAccionProductoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	var ModalidadIngresoId = $('#CmpModalidadIngresoId_'+oModalidadIngreso).val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionProductoListado.php',
		data: 'ModalidadIngresoId='+ModalidadIngresoId+'&Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionProductoEditar+'&Eliminar='+FichaAccionProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
//			alert("#CapFichaAccion"+oModalidadIngreso+"Productos");
			
			$("#CapFichaAccion"+oModalidadIngreso+"Productos").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Productos").append(html);
		}
	});
	
}


function FncFichaAccionProductoEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Editando...');
	$('#CmpFichaAccion'+oModalidadIngreso+'ProductoAccion').val("AccFichaAccionProductoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaAccion/acc/AccFichaAccionProductoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaAccionProducto){
			
	
//SesionObjeto-FichaAccionProducto
//Parametro1 = FapId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = FapVerificar1
//Parametro5 = FapVerificar2
//Parametro6 = UmeId
//Parametro7 = FapTiempoCreacion
//Parametro8 = FapTiempoModificacion
//Parametro9 = FapCantidad
//Parametro10 = FapCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
//Parametro14 = FapEstado
//Parametro15 = Tipo
//Parametro16 = FapAccion
//Parmaetro17 = ProCodigoOriginal,
//Parmaetro18 = ProCodigoAlternativo
	
				$('#Cmp'+oModalidadIngreso+'ProductoId').val(InsFichaAccionProducto.Parametro2);
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').val(InsFichaAccionProducto.Parametro3);
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val(InsFichaAccionProducto.Parametro17);
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val(InsFichaAccionProducto.Parametro18);
				$('#Cmp'+oModalidadIngreso+'ProductoItem').val(InsFichaAccionProducto.Item);
				$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaEquivalente').val(1);
				$('#Cmp'+oModalidadIngreso+'ProductoCantidad').val(InsFichaAccionProducto.Parametro9);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsFichaAccionProducto.Parametro11+"&Tipo=1&UnidadMedidaId="+InsFichaAccionProducto.Parametro13,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsFichaAccionProducto.Parametro6){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$('select#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').html(options);
				})
				
				$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').attr('disabled', true);
				
				
}
	});
	


	//$('#CmpProductoCantidad').select();
	$('#Cmp'+oModalidadIngreso+'ProductoCantidad').select();
	
	//$('#CmpProductoId').attr('readonly', true);
	//$('#CmpProductoCodigoOriginal').attr('readonly', true);
	//$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').attr('readonly', true);
	
		
	
	
}

function FncFichaAccionProductoEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionProductoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html("Eliminado");	
				FncFichaAccionProductoListar(oModalidadIngreso);
			}
		});

		FncFichaAccionProductoNuevo(oModalidadIngreso);

	}
	
}



function FncFichaAccionProductoEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionProductoEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminado');	
				FncFichaAccionProductoListar(oModalidadIngreso);
			}
		});	
			
		FncFichaAccionProductoNuevo(oModalidadIngreso);
	}
	
}
