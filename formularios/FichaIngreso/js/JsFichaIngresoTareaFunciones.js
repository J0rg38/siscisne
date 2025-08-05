// JavaScript Document

function FncFichaIngresoTareaNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'TareaId').val("");
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').val("");
	$('#Cmp'+oModalidadIngreso+'TareaAccion').val("");
	$('#Cmp'+oModalidadIngreso+'TareaItem').val("");	
			
	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo para registrar elementos');	
			
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();
			
	$('#CmpFichaIngreso'+oModalidadIngreso+'TareaAccion').val("AccFichaIngresoTareaRegistrar.php");

}

function FncFichaIngresoTareaGuardar(oModalidadIngreso){

var Identificador = $('#Identificador').val();

	var Acc = $('#CmpFichaIngreso'+oModalidadIngreso+'TareaAccion').val();		
	
			var TareaDescripcion = $('#Cmp'+oModalidadIngreso+'TareaDescripcion').val();
			var TareaAccion = $('#Cmp'+oModalidadIngreso+'TareaAccion').val();
			var Item = $('#Cmp'+oModalidadIngreso+'TareaItem').val();
			
			//alert('#Cmp'+oModalidadIngreso+'TareaDescripcion');
			
			if(TareaDescripcion==""){
				$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();	
			}else if(TareaAccion==""){
				$('#Cmp'+oModalidadIngreso+'TareaAccion').select();						
			}else{
				$('#Cap'+oModalidadIngreso+'TareaAccion').html('Guardando...');
				
				
						$.ajax({
							type: 'POST',
							url: 'formularios/FichaIngreso/acc/'+Acc,
							data: 'Identificador='+Identificador+'&TareaDescripcion='+TareaDescripcion+'&TareaAccion='+TareaAccion+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
							success: function(){
								
							$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');							
								FncFichaIngresoTareaListar(oModalidadIngreso);
							}
						});
						
						
						
								/*if(confirm("Desea seguir agregando mas items?")==false){
									if(confirm("Desea guardar el registro ahora?")){
										$('#Guardar').val("1");
										$('#'+Formulario).submit();
									}
								}*/
								
							FncFichaIngresoTareaNuevo(oModalidadIngreso);	
					
					
				}
			

	
}


function FncFichaIngresoTareaListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/FichaIngreso/FrmFichaIngresoTareaListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaIngresoTareaEditar+'&Eliminar='+FichaIngresoTareaEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TareaAccion').html('Listo');	
			$("#CapFichaIngreso"+oModalidadIngreso+"Tareas").html("");
			$("#CapFichaIngreso"+oModalidadIngreso+"Tareas").append(html);
		}
	});
	
	


}



function FncFichaIngresoTareaEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'TareaAccion').html('Editando...');
	$('#CmpFichaIngreso'+oModalidadIngreso+'TareaAccion').val("AccFichaIngresoTareaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FichaIngreso/acc/AccFichaIngresoTareaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaIngresoTarea){
			
/*
SesionObjeto-FichaIngresoTarea
Parametro1 = FitId
Parametro2 =
Parametro3 = FitDescripcion
Parametro4 =
Parametro5 =
Parametro6 = FitAccion
Parametro7 = FitTiempoCreacion
Parametro8 = FitTiempoModificacion
*/

				$('#Cmp'+oModalidadIngreso+'TareaDescripcion').val(InsFichaIngresoTarea.Parametro3);		
				$('#Cmp'+oModalidadIngreso+'TareaAccion').val(InsFichaIngresoTarea.Parametro6);
				$('#Cmp'+oModalidadIngreso+'TareaItem').val(InsFichaIngresoTarea.Item);
		}
	});
	
	
	$('#Cmp'+oModalidadIngreso+'TareaDescripcion').select();
	
}

function FncFichaIngresoTareaEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoTareaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TareaAccion').html("Eliminado");	
				FncFichaIngresoTareaListar(oModalidadIngreso);
			}
		});

		
		FncFichaIngresoTareaNuevo(oModalidadIngreso);
		

	}


	
}



function FncFichaIngresoTareaEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/FichaIngreso/acc/AccFichaIngresoTareaEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TareaAccion').html('Eliminado');	
				FncFichaIngresoTareaListar(oModalidadIngreso);
			}
		});	
			
		FncFichaIngresoTareaNuevo(oModalidadIngreso);
	}
	
}
