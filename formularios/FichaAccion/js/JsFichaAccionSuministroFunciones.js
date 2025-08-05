// JavaScript Document

function FncFichaAccionSuministroNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'SuministroId').val("");
	$('#Cmp'+oModalidadIngreso+'SuministroNombre').val("");
	$('#Cmp'+oModalidadIngreso+'SuministroItem').val("");	
			
	//$('#Cmp'+oModalidadIngreso+'SuministroCodigoOriginal').val("");	
	//$('#Cmp'+oModalidadIngreso+'SuministroCodigoAlternativo').val("");	
	
	$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedida').val("");
	$('select#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaConvertir').html('');
	$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaEquivalente').val("");	
	
	$('#Cmp'+oModalidadIngreso+'SuministroCantidad').val("")

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo para registrar elementos');				
	$('#Cmp'+oModalidadIngreso+'SuministroNombre').focus();			
	$('#CmpFichaAccion'+oModalidadIngreso+'SuministroAccion').val("AccFichaAccionSuministroRegistrar.php");
	
//	$('#CmpProductoCodigoOriginal').removeAttr('readonly');
//	$('#CmpProductoCodigoAlternativo').removeAttr('readonly');
	$('#Cmp'+oModalidadIngreso+'SuministroNombre').removeAttr('readonly');
//	$('#CmpSuministroUnidadMedidaConvertir').attr('disabled', false);
	

}

function FncFichaAccionSuministroGuardar(oModalidadIngreso){

//alert(":3");
var Identificador = $('#Identificador').val();

	var Acc = $('#CmpFichaAccion'+oModalidadIngreso+'SuministroAccion').val();		
	
			var SuministroId = $('#Cmp'+oModalidadIngreso+'SuministroId').val();
			var SuministroNombre = $('#Cmp'+oModalidadIngreso+'SuministroNombre').val();
			var Item = $('#Cmp'+oModalidadIngreso+'SuministroItem').val();
	
			var SuministroUnidadMedidaConvertir = $('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaConvertir').val();
			var SuministroCantidad = $('#Cmp'+oModalidadIngreso+'SuministroCantidad').val();
			var SuministroUnidadMedida = $('#Cmp'+oModalidadIngreso+'SuministroUnidadMedida').val();
			
			if(SuministroNombre==""){
				$('#Cmp'+oModalidadIngreso+'SuministroNombre').select();	
			}else if(SuministroUnidadMedidaConvertir==""){
				$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaConvertir').focus();	
			}else if(SuministroCantidad=="" || SuministroCantidad <=0){
				$('#Cmp'+oModalidadIngreso+'SuministroCantidad').select();	
			}else{
				$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Guardando...');
				
				
						$.ajax({
							type: 'POST',
							url: 'formularios/FichaAccion/acc/'+Acc,
							data: 'Identificador='+Identificador+'&SuministroNombre='+SuministroNombre+'&SuministroId='+SuministroId+'&SuministroUnidadMedidaConvertir='+SuministroUnidadMedidaConvertir+'&SuministroCantidad='+SuministroCantidad+'&SuministroUnidadMedida='+SuministroUnidadMedida+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(rpta){
								
								
								if(rpta != "" ){
									alert(rpta);
								}
							$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');							
								FncFichaAccionSuministroListar(oModalidadIngreso);
							}
						});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncFichaAccionSuministroNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncFichaAccionSuministroListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionSuministroListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionSuministroEditar+'&Eliminar='+FichaAccionSuministroEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');	
//			alert("#CapFichaAccion"+oModalidadIngreso+"Suministros");
			
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros").append(html);
		}
	});
	
	


}


function FncFichaAccionSuministroListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionSuministroListado2.php',
		//data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar=2'+'&Eliminar=2',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionSuministroEditar+'&Eliminar='+FichaAccionSuministroEliminar,		
		success: function(html){
			$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros2").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Suministros2").append(html);
		}
	});
	
}


function FncFichaAccionSuministroEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Editando...');
	$('#CmpFichaAccion'+oModalidadIngreso+'SuministroAccion').val("AccFichaAccionSuministroEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaAccion/acc/AccFichaAccionSuministroEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaAccionSuministro){
			
	
//SesionObjeto-FichaAccionSuministro
//Parametro1 = FasId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = FasVerificar1
//Parametro5 = FasVeriticar2
//Parametro6 = UmeId
//Parametro7 = FasTiempoCreacion
//Parametro8 = FasTiempoModificacion
//Parametro9 = FasCantidad
//Parametro10 = FasCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen
	
				$('#Cmp'+oModalidadIngreso+'SuministroId').val(InsFichaAccionSuministro.Parametro2);
				$('#Cmp'+oModalidadIngreso+'SuministroNombre').val(InsFichaAccionSuministro.Parametro3);
				$('#Cmp'+oModalidadIngreso+'SuministroItem').val(InsFichaAccionSuministro.Item);
				$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaEquivalente').val(1);
				$('#Cmp'+oModalidadIngreso+'SuministroCantidad').val(InsFichaAccionSuministro.Parametro9);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsFichaAccionSuministro.Parametro11+"&Tipo=1&UnidadMedidaId="+InsFichaAccionSuministro.Parametro13,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsFichaAccionSuministro.Parametro6){
							options += '<option selected="selected" value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}else{
							options += '<option value="' + j[i].UmeId + '">' + j[i].UmeNombre+ '</option>';
						}
					}
					$('select#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaConvertir').html(options);
				})
				
				$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaConvertir').attr('disabled', true);
				
				
}
	});
	


	//$('#CmpSuministroCantidad').select();
	$('#Cmp'+oModalidadIngreso+'SuministroCantidad').select();
	
	//$('#CmpSuministroId').attr('readonly', true);
	//$('#CmpProductoCodigoOriginal').attr('readonly', true);
	//$('#CmpProductoCodigoAlternativo').attr('readonly', true);
	$('#Cmp'+oModalidadIngreso+'SuministroNombre').attr('readonly', true);
	
		
	
	
}

function FncFichaAccionSuministroEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionSuministroEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'SuministroAccion').html("Eliminado");	
				FncFichaAccionSuministroListar(oModalidadIngreso);
			}
		});

		FncFichaAccionSuministroNuevo(oModalidadIngreso);

	}
	
}



function FncFichaAccionSuministroEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionSuministroEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Eliminado');	
				FncFichaAccionSuministroListar(oModalidadIngreso);
			}
		});	
			
		FncFichaAccionSuministroNuevo(oModalidadIngreso);
	}
	
}
