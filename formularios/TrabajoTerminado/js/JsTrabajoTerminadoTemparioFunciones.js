// JavaScript Document

function FncTrabajoTerminadoTemparioNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'TemparioId').val("");
	$('#Cmp'+oModalidadIngreso+'TemparioCodigo').val("");
	$('#Cmp'+oModalidadIngreso+'TemparioTiempo').val("");
	$('#Cmp'+oModalidadIngreso+'TemparioItem').val("");	
			
	$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Listo para registrar elementos');	
			
	$('#Cmp'+oModalidadIngreso+'TemparioCodigo').select();
			
	$('#CmpTrabajoTerminado'+oModalidadIngreso+'TemparioAccion').val("AccTrabajoTerminadoTemparioRegistrar.php");

}

function FncTrabajoTerminadoTemparioGuardar(oModalidadIngreso){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpTrabajoTerminado'+oModalidadIngreso+'TemparioAccion').val();		

		var TemparioCodigo = $('#Cmp'+oModalidadIngreso+'TemparioCodigo').val();
		var TemparioTiempo = $('#Cmp'+oModalidadIngreso+'TemparioTiempo').val();

		var Item = $('#Cmp'+oModalidadIngreso+'TemparioItem').val();

		if(TemparioCodigo==""){
			$('#Cmp'+oModalidadIngreso+'TemparioCodigo').select();	
		}else if(TemparioTiempo==""){
			$('#Cmp'+oModalidadIngreso+'TemparioTiempo').select();						
		}else{
			$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Guardando...');

			$.ajax({
				type: 'POST',
				url: 'formularios/TrabajoTerminado/acc/'+Acc,
				data: 'Identificador='+Identificador+'&TemparioCodigo='+TemparioCodigo+'&TemparioTiempo='+TemparioTiempo+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
				success: function(){

				$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Listo');							
					FncTrabajoTerminadoTemparioListar(oModalidadIngreso);
				}
			});

			FncTrabajoTerminadoTemparioNuevo(oModalidadIngreso);	

		}

}


function FncTrabajoTerminadoTemparioListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TrabajoTerminado/FrmTrabajoTerminadoTemparioListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+TrabajoTerminadoTemparioEditar+'&Eliminar='+TrabajoTerminadoTemparioEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Listo');	
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Temparios").html("");
			$("#CapTrabajoTerminado"+oModalidadIngreso+"Temparios").append(html);
		}
	});
	
}

function FncTrabajoTerminadoTemparioEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Editando...');
	$('#CmpTrabajoTerminado'+oModalidadIngreso+'TemparioAccion').val("AccTrabajoTerminadoTemparioEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoTemparioEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsTrabajoTerminadoTempario){

//SesionObjeto-TrabajoTerminadoTempario
//Parametro1 = FaeId
//Parametro2 =
//Parametro3 = FaeCodigo
//Parametro4 = FaeTiempo
//Parametro5 = 
//Parametro6 = FaeEstado
//Parametro7 = FaeTiempoCreacion
//Parametro8 = FaeTiempoModificacion

				$('#Cmp'+oModalidadIngreso+'TemparioCodigo').val(InsTrabajoTerminadoTempario.Parametro3);		
				$('#Cmp'+oModalidadIngreso+'TemparioTiempo').val(InsTrabajoTerminadoTempario.Parametro4);
				$('#Cmp'+oModalidadIngreso+'TemparioItem').val(InsTrabajoTerminadoTempario.Item);
				
				$('#Cmp'+oModalidadIngreso+'TemparioCodigo').select();
		}
	});
	
	
	
	
}

function FncTrabajoTerminadoTemparioEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoTemparioEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TemparioAccion').html("Eliminado");	
				FncTrabajoTerminadoTemparioListar(oModalidadIngreso);
			}
		});

		FncTrabajoTerminadoTemparioNuevo(oModalidadIngreso);
		
	}
	
}



function FncTrabajoTerminadoTemparioEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/TrabajoTerminado/acc/AccTrabajoTerminadoTemparioEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Eliminado');	
				FncTrabajoTerminadoTemparioListar(oModalidadIngreso);
			}
		});	
			
		FncTrabajoTerminadoTemparioNuevo(oModalidadIngreso);
	}
	
}
