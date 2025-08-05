// JavaScript Document

function FncFichaAccionTareaNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'TareaId').val("");
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').val("");
	$('#Cmp'+oModalidadIngreso+'TareaAccion').val("");
	$('#Cmp'+oModalidadIngreso+'TareaItem').val("");	
			
	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo para registrar elementos');	
			
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();
			
	$('#CmpFichaAccion'+oModalidadIngreso+'TareaAccion').val("AccFichaAccionTareaRegistrar.php");

}

function FncFichaAccionTareaGuardar(oModalidadIngreso){

var Identificador = $('#Identificador').val();

	var Acc = $('#CmpFichaAccion'+oModalidadIngreso+'TareaAccion').val();		
	
			var TareaDescripcion = $('#Cmp'+oModalidadIngreso+'TareaDescripcion').val();
			var TareaAccion = $('#Cmp'+oModalidadIngreso+'TareaAccion').val();
			var Item = $('#Cmp'+oModalidadIngreso+'TareaItem').val();
	
			if(TareaDescripcion==""){
				$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();	
			}else if(TareaAccion==""){
				$('#Cmp'+oModalidadIngreso+'TareaAccion').select();						
			}else{
				$('#Cap'+oModalidadIngreso+'TareaAccion').html('Guardando...');
				
				
						$.ajax({
							type: 'POST',
							url: 'formularios/FichaAccion/acc/'+Acc,
							data: 'Identificador='+Identificador+'&TareaDescripcion='+TareaDescripcion+'&TareaAccion='+TareaAccion+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(){
								
							$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');							
								FncFichaAccionTareaListar(oModalidadIngreso);
							}
						});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncFichaAccionTareaNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncFichaAccionTareaListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionTareaListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionTareaEditar+'&Eliminar='+FichaAccionTareaEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	
			//alert(html);
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas").append(html);
		}
	});
	
}

function FncFichaAccionTareaListar2(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaAccion/FrmFichaAccionTareaListado2.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar=2'+'&Eliminar=2',
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	

			$("#CapFichaAccion"+oModalidadIngreso+"Tareas2").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Tareas2").append(html);
		}
	});
	
}

function FncFichaAccionTareaEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Editando...');
	$('#CmpFichaAccion'+oModalidadIngreso+'TareaAccion').val("AccFichaAccionTareaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaAccion/acc/AccFichaAccionTareaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaAccionTarea){
			
/*
SesionObjeto-FichaAccionTarea
Parametro1 = FitId
Parametro2 =
Parametro3 = FitDescripcion
Parametro4 =
Parametro5 =
Parametro6 = FitAccion
Parametro7 = FitTiempoCreacion
Parametro8 = FitTiempoModificacion
*/

				$('#Cmp'+oModalidadIngreso+'TareaDescripcion').val(InsFichaAccionTarea.Parametro3);		
				$('#Cmp'+oModalidadIngreso+'TareaAccion').val(InsFichaAccionTarea.Parametro6);
				$('#Cmp'+oModalidadIngreso+'TareaItem').val(InsFichaAccionTarea.Item);
		}
	});
	
	
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();
	
}

function FncFichaAccionTareaEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionTareaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TareaAccion').html("Eliminado");	
				FncFichaAccionTareaListar(oModalidadIngreso);
			}
		});

		
		FncFichaAccionTareaNuevo(oModalidadIngreso);
		

	}


	
}



function FncFichaAccionTareaEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaAccion/acc/AccFichaAccionTareaEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminado');	
				FncFichaAccionTareaListar(oModalidadIngreso);
			}
		});	
			
		FncFichaAccionTareaNuevo(oModalidadIngreso);
	}
	
}
