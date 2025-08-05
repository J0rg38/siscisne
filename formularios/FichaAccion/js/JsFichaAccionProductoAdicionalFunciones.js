// JavaScript Document

function FncFichaAccionProductoAdicionalNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'ProductoId').val("");
	$('#Cmp'+oModalidadIngreso+'ProductoNombre').val("");
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

function FncFichaAccionProductoAdicionalGuardar(oModalidadIngreso){

	
			var Identificador = $('#Identificador').val();

			var Acc = $('#CmpFichaAccion'+oModalidadIngreso+'ProductoAccion').val();		
	
			var ProductoId = $('#Cmp'+oModalidadIngreso+'ProductoId').val();
			var ProductoNombre = $('#Cmp'+oModalidadIngreso+'ProductoNombre').val();
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
							data: 'Identificador='+Identificador+'&ProductoNombre='+ProductoNombre+'&ProductoId='+ProductoId+'&ProductoUnidadMedidaConvertir='+ProductoUnidadMedidaConvertir+'&ProductoCantidad='+ProductoCantidad+'&ProductoUnidadMedida='+ProductoUnidadMedida+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(rpta){
								
								
								if(rpta != "" ){
									alert(rpta);
								}
								
							$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');							
								FncFichaAccionProductoAdicionalListar(oModalidadIngreso);
							}
						});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncFichaAccionProductoAdicionalNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncFichaAccionProductoAdicionalListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionProductoAdicionalListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionProductoAdicionalEditar+'&Eliminar='+FichaAccionProductoAdicionalEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
//			alert("#CapFichaAccion"+oModalidadIngreso+"Productos");
			
			$("#CapFichaAccion"+oModalidadIngreso+"Productos").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Productos").append(html);
		}
	});
	
	


}


function FncFichaAccionProductoAdicionalListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionProductoAdicionalListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionProductoAdicionalEditar+'&Eliminar='+FichaAccionProductoAdicionalEliminar,
//		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Productos2").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Productos2").append(html);
			
			
			
				$('input[type=checkbox]').each(function () {
					
					if($(this).attr('etiqueta')=="producto"){
						
						
						var Sigla = $(this).val();
	
						$("#CmpFichaAccionProductoAdicionalAccion_"+$(this).val()).unbind("change");
						$("#CmpFichaAccionProductoAdicionalAccion_"+$(this).val()).change(function(){
							
							//alert($(this).val());
							switch($(this).val()){
								case "C":
								
									//$('#Btn'+Sigla+'FichaAccionProductoAdicionalNuevo').show();
								
									$('#CmpFichaAccionProductoAdicionalNombre_'+Sigla).removeAttr('readonly');
									$('#CmpFichaAccionProductoAdicionalCantidad_'+Sigla).removeAttr('readonly');
									
									$('#CmpFichaAccionProductoAdicionalUnidadMedida_'+Sigla).removeAttr('disabled');
									$('#CmpFichaAccionProductoAdicional_'+Sigla).removeAttr('disabled');
									
									
									$('#CmpFichaAccionProductoAdicionalNombre_'+Sigla).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									$('#CmpFichaAccionProductoAdicionalCantidad_'+Sigla).removeClass("EstFormularioCajaDeshabilitada").addClass("EstFormularioCaja");
									
								break;
								
								case "X":
								
									FncFichaAccionProductoAdicionalNuevo(Sigla);
								
									//$('#Btn'+Sigla+'FichaAccionProductoAdicionalNuevo').hide();
								
									$('#CmpFichaAccionProductoAdicionalNombre_'+Sigla).attr('readonly', true);
									$('#CmpFichaAccionProductoAdicionalCantidad_'+Sigla).attr('readonly', true);

									$('#CmpFichaAccionProductoAdicionalUnidadMedida_'+Sigla).attr('disabled', true);
									$('#CmpFichaAccionProductoAdicional_'+Sigla).attr('disabled', true);
									//$('#CmpFichaAccionProductoAdicional_'+Sigla).removeAttr('disabled');

									$('#CmpFichaAccionProductoAdicionalNombre_'+Sigla).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#CmpFichaAccionProductoAdicionalCantidad_'+Sigla).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
									
									
									
									
								break;
								
								default:
								
									
									
									FncFichaAccionProductoAdicionalNuevo(Sigla);
								
									//$('#Btn'+Sigla+'FichaAccionProductoAdicionalNuevo').hide();
								
									$('#CmpFichaAccionProductoAdicionalNombre_'+Sigla).attr('readonly', true);
									$('#CmpFichaAccionProductoAdicionalCantidad_'+Sigla).attr('readonly', true);

									$('#CmpFichaAccionProductoAdicionalUnidadMedida_'+Sigla).attr('disabled', true);
									$('#CmpFichaAccionProductoAdicional_'+Sigla).removeAttr('disabled');

									$('#CmpFichaAccionProductoAdicionalNombre_'+Sigla).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									$('#CmpFichaAccionProductoAdicionalCantidad_'+Sigla).removeClass("EstFormularioCaja").addClass("EstFormularioCajaDeshabilitada");
									
								break;
							}

						});
							
						
					}			 
				});
				
				
		}
	});
	
}


function FncFichaAccionProductoAdicionalEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Editando...');
	$('#CmpFichaAccion'+oModalidadIngreso+'ProductoAccion').val("AccFichaAccionProductoAdicionalEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaAccion/acc/AccFichaAccionProductoAdicionalEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaAccionProductoAdicional){
			
	
//SesionObjeto-FichaAccionProductoAdicionalAdicional
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
	
				$('#Cmp'+oModalidadIngreso+'ProductoId').val(InsFichaAccionProductoAdicional.Parametro2);
				$('#Cmp'+oModalidadIngreso+'ProductoNombre').val(InsFichaAccionProductoAdicional.Parametro3);
				$('#Cmp'+oModalidadIngreso+'ProductoItem').val(InsFichaAccionProductoAdicional.Item);
				$('#Cmp'+oModalidadIngreso+'ProductoUnidadMedidaEquivalente').val(1);
				$('#Cmp'+oModalidadIngreso+'ProductoCantidad').val(InsFichaAccionProductoAdicional.Parametro9);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsFichaAccionProductoAdicional.Parametro11+"&Tipo=1&UnidadMedidaId="+InsFichaAccionProductoAdicional.Parametro13,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsFichaAccionProductoAdicional.Parametro6){
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

function FncFichaAccionProductoAdicionalEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionProductoAdicionalEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html("Eliminado");	
				FncFichaAccionProductoAdicionalListar(oModalidadIngreso);
			}
		});

		FncFichaAccionProductoAdicionalNuevo(oModalidadIngreso);

	}
	
}



function FncFichaAccionProductoAdicionalEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionProductoAdicionalEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Eliminado');	
				FncFichaAccionProductoAdicionalListar(oModalidadIngreso);
			}
		});	
			
		FncFichaAccionProductoAdicionalNuevo(oModalidadIngreso);
	}
	
}
