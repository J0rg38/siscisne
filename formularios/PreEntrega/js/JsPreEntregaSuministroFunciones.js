// JavaScript Document
	
/******************************************************************************/
	
function FncPreEntregaSuministroNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'SuministroId').val("");
	$('#Cmp'+oModalidadIngreso+'SuministroNombre').val("");
	$('#Cmp'+oModalidadIngreso+'SuministroItem').val("");	

	$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedida').val("");
	$('select#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaConvertir').html('');
	$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaEquivalente').val("");	
	
	$('#Cmp'+oModalidadIngreso+'SuministroCantidad').val("")

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo para registrar elementos');	
			
	$('#Cmp'+oModalidadIngreso+'SuministroNombre').focus();
			
	$('#CmpPreEntrega'+oModalidadIngreso+'SuministroAccion').val("AccPreEntregaSuministroRegistrar.php");

}

function FncPreEntregaSuministroGuardar(oModalidadIngreso){

var Identificador = $('#Identificador').val();

	var Acc = $('#CmpPreEntrega'+oModalidadIngreso+'SuministroAccion').val();		
	
			var SuministroId = $('#Cmp'+oModalidadIngreso+'SuministroId').val();
			var SuministroNombre = $('#Cmp'+oModalidadIngreso+'SuministroNombre').val();
			var Item = $('#Cmp'+oModalidadIngreso+'SuministroItem').val();
	
			var SuministroUnidadMedidaConvertir = $('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaConvertir').val();
			var SuministroCantidad = $('#Cmp'+oModalidadIngreso+'SuministroCantidad').val();
			var SuministroUnidadMedida = $('#Cmp'+oModalidadIngreso+'SuministroUnidadMedida').val();
			
			
//			if(SuministroNombre==""){
//				$('#Cmp'+oModalidadIngreso+'SuministroNombre').focus();	
//			}else{
//				$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Guardando...');
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
							url: 'formularios/PreEntrega/acc/'+Acc,
							//data: 'Identificador='+Identificador+'&SuministroNombre='+SuministroNombre+'&SuministroId='+SuministroId+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							data: 'Identificador='+Identificador+'&SuministroNombre='+SuministroNombre+'&SuministroId='+SuministroId+'&SuministroUnidadMedidaConvertir='+SuministroUnidadMedidaConvertir+'&SuministroCantidad='+SuministroCantidad+'&SuministroUnidadMedida='+SuministroUnidadMedida+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(rpta){
								
								if(rpta != "" ){
									alert(rpta);
								}
								
								$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');							
								FncPreEntregaSuministroListar(oModalidadIngreso);
							}
						});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncPreEntregaSuministroNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncPreEntregaSuministroListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PreEntrega/FrmPreEntregaSuministroListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaIngresoSuministroEditar+'&Eliminar='+FichaIngresoSuministroEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Listo');	
			$("#CapPreEntrega"+oModalidadIngreso+"Suministros").html("");
			$("#CapPreEntrega"+oModalidadIngreso+"Suministros").append(html);
		}
	});
	
	


}



function FncPreEntregaSuministroEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Editando...');
	$('#CmpPreEntrega'+oModalidadIngreso+'SuministroAccion').val("AccPreEntregaSuministroEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PreEntrega/acc/AccPreEntregaSuministroEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaIngresoSuministro){
	
	
//SesionObjeto-FichaIngresoSuministro
//Parametro1 = FisId
//Parametro2 = ProId
//Parametro3 = ProNombre
//Parametro4 = 
//Parametro5 = 
//Parametro6 = UmeId
//Parametro7 = FisTiempoCreacion
//Parametro8 = FisTiempoModificacion
//Parametro9 = FisCantidad
//Parametro10 = FisCantidadReal	
//Parametro11 = RtiId
//Parametro12 = UmeNombre
//Parametro13 = UmeIdOrigen

				$('#Cmp'+oModalidadIngreso+'SuministroId').val(InsFichaIngresoSuministro.Parametro2);
				$('#Cmp'+oModalidadIngreso+'SuministroNombre').val(InsFichaIngresoSuministro.Parametro3);
				$('#Cmp'+oModalidadIngreso+'SuministroItem').val(InsFichaIngresoSuministro.Item);
				$('#Cmp'+oModalidadIngreso+'SuministroUnidadMedidaEquivalente').val(1);
				$('#Cmp'+oModalidadIngreso+'SuministroCantidad').val(InsFichaIngresoSuministro.Parametro9);
				
				$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+InsFichaIngresoSuministro.Parametro11+"&Tipo=1&UnidadMedidaId="+InsFichaIngresoSuministro.Parametro13,{}, function(j){
					var options = '';
					options += '<option value="">Escoja una opcion</option>';
					for (var i = 0; i < j.length; i++) {
						if(j[i].UmeId == InsFichaIngresoSuministro.Parametro6){
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
	
	
	$('#Cmp'+oModalidadIngreso+'SuministroNombre').select();
	
}

function FncPreEntregaSuministroEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PreEntrega/acc/AccPreEntregaSuministroEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'SuministroAccion').html("Eliminado");	
				FncPreEntregaSuministroListar(oModalidadIngreso);
			}
		});

		FncPreEntregaSuministroNuevo(oModalidadIngreso);

	}
	
}



function FncPreEntregaSuministroEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PreEntrega/acc/AccPreEntregaSuministroEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'SuministroAccion').html('Eliminado');	
				FncPreEntregaSuministroListar(oModalidadIngreso);
			}
		});	
			
		FncPreEntregaSuministroNuevo(oModalidadIngreso);
	}
	
}
