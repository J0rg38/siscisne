// JavaScript Document

function FncFichaIngresoProductoNuevo(oModalidadIngreso){
	
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
	$('#CmpFichaIngreso'+oModalidadIngreso+'ProductoAccion').val("AccFichaIngresoProductoRegistrar.php");

	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').removeAttr('readonly');
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').removeAttr('readonly');
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').removeAttr('readonly');
	$('select#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaConvertir').attr('disabled', false);

}

function FncFichaIngresoProductoGuardar(oModalidadIngreso){

//alert(":3");
		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpFichaIngreso'+oModalidadIngreso+'ProductoAccion').val();		
	
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
							url: 'formularios/FichaIngreso/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ProductoCodigoOriginal='+ProductoCodigoOriginal+'&ProductoCodigoAlternativo='+ProductoCodigoAlternativo+'&ProductoNombre='+ProductoNombre+'&ProductoId='+ProductoId+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoCantidad='+ProductoCantidad+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(rpta){
								
								
								if(rpta != "" ){
									alert(rpta);
								}
								
							$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');							
								FncFichaIngresoProductoListar(oModalidadIngreso);
							}
						});
						
						FncFichaIngresoProductoNuevo(oModalidadIngreso);	
					
				}
			

	
}


function FncFichaIngresoProductoListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	var ModalidadIngresoId = $('#CmpModalidadIngresoId_'+oModalidadIngreso).val();
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoProductoListado.php',
		data: 'ModalidadIngresoId='+ModalidadIngresoId+'&Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaIngresoProductoEditar+'&Eliminar='+FichaIngresoProductoEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
//			alert("#CapFichaIngreso"+oModalidadIngreso+"Productos");
			
			$("#CapFichaIngreso"+oModalidadIngreso+"Productos").html("");
			$("#CapFichaIngreso"+oModalidadIngreso+"Productos").append(html);
		}
	});
	
}


function FncFichaIngresoProductoEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Editando...');
	$('#CmpFichaIngreso'+oModalidadIngreso+'ProductoAccion').val("AccFichaIngresoProductoEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaIngreso/acc/AccFichaIngresoProductoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaIngresoProducto){
			
				//SesionObjeto-FichaIngresoProducto
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
	
				$('#Cmp'+oModalidadIngreso+'ProductoId').val(InsFichaIngresoProducto.Parametro2);
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').val(InsFichaIngresoProducto.Parametro3);
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').val(InsFichaIngresoProducto.Parametro17);
				$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').val(InsFichaIngresoProducto.Parametro18);
				$('#Cmp'+oModalidadIngreso+'ProductoItem').val(InsFichaIngresoProducto.Item);
				$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaEquivalente').val(1);
				$('#Cmp'+oModalidadIngreso+'ProductoCantidad').val(InsFichaIngresoProducto.Parametro9);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsFichaIngresoProducto.Parametro11+"&Tipo=1&UnidadMedidaId="+InsFichaIngresoProducto.Parametro13,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsFichaIngresoProducto.Parametro6){
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
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoOriginal').attr('readonly', true);
	$('#Cmp'+oModalidadIngreso+'ProductoCodigoAlternativo').attr('readonly', true);
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').attr('readonly', true);
	
}

function FncFichaIngresoProductoEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoProductoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html("Eliminado");	
				FncFichaIngresoProductoListar(oModalidadIngreso);
			}
		});

		FncFichaIngresoProductoNuevo(oModalidadIngreso);

	}
	
}



function FncFichaIngresoProductoEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoProductoEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminado');	
				FncFichaIngresoProductoListar(oModalidadIngreso);
			}
		});	
			
		FncFichaIngresoProductoNuevo(oModalidadIngreso);
	}
	
}
