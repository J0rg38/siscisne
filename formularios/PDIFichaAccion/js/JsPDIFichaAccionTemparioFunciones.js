// JavaScript Document

function FncFichaAccionTemparioNuevo(oModalidadIngreso){
	
	$('#Cmp'+oModalidadIngreso+'TemparioId').val("");
	$('#Cmp'+oModalidadIngreso+'TemparioCodigo').val("");
	$('#Cmp'+oModalidadIngreso+'TemparioTiempo').val("");
	$('#Cmp'+oModalidadIngreso+'TemparioItem').val("");	
			
	$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Listo para registrar elementos');	
			
	$('#Cmp'+oModalidadIngreso+'TemparioCodigo').select();
			
	$('#CmpFichaAccion'+oModalidadIngreso+'TemparioAccion').val("AccPDIFichaAccionTemparioRegistrar.php");

}

function FncFichaAccionTemparioGuardar(oModalidadIngreso){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpFichaAccion'+oModalidadIngreso+'TemparioAccion').val();		

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
				url: 'formularios/PDIFichaAccion/acc/'+Acc,
				data: 'Identificador='+Identificador+'&TemparioCodigo='+TemparioCodigo+'&TemparioTiempo='+TemparioTiempo+'&Item='+Item+'&ModalidadIngreso='+oModalidadIngreso,
				success: function(){

				$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Listo');							
					FncFichaAccionTemparioListar(oModalidadIngreso);
				}
			});

			FncFichaAccionTemparioNuevo(oModalidadIngreso);	

		}

}


function FncFichaAccionTemparioListar(oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/PDIFichaAccion/FrmPDIFichaAccionTemparioListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&Editar='+FichaAccionTemparioEditar+'&Eliminar='+FichaAccionTemparioEliminar,
		success: function(html){
			$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Listo');	
			$("#CapFichaAccion"+oModalidadIngreso+"Temparios").html("");
			$("#CapFichaAccion"+oModalidadIngreso+"Temparios").append(html);
		}
	});
	
}

function FncFichaAccionTemparioEscoger(oItem,oModalidadIngreso){
		
	var Identificador = $('#Identificador').val();
	
	$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Editando...');
	$('#CmpFichaAccion'+oModalidadIngreso+'TemparioAccion').val("AccPDIFichaAccionTemparioEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionTemparioEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
		success: function(InsFichaAccionTempario){

//SesionObjeto-FichaAccionTempario
//Parametro1 = FaeId
//Parametro2 =
//Parametro3 = FaeCodigo
//Parametro4 = FaeTiempo
//Parametro5 = 
//Parametro6 = FaeEstado
//Parametro7 = FaeTiempoCreacion
//Parametro8 = FaeTiempoModificacion

				$('#Cmp'+oModalidadIngreso+'TemparioCodigo').val(InsFichaAccionTempario.Parametro3);		
				$('#Cmp'+oModalidadIngreso+'TemparioTiempo').val(InsFichaAccionTempario.Parametro4);
				$('#Cmp'+oModalidadIngreso+'TemparioItem').val(InsFichaAccionTempario.Item);
				
				$('#Cmp'+oModalidadIngreso+'TemparioCodigo').select();
		}
	});
	
	
	
	
}

function FncFichaAccionTemparioEliminar(oItem,oModalidadIngreso){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionTemparioEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TemparioAccion').html("Eliminado");	
				FncFichaAccionTemparioListar(oModalidadIngreso);
			}
		});

		FncFichaAccionTemparioNuevo(oModalidadIngreso);
		
	}
	
}



function FncFichaAccionTemparioEliminarTodo(oModalidadIngreso){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/PDIFichaAccion/acc/AccPDIFichaAccionTemparioEliminarTodo.php',
			data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso,
			success: function(){
				$('#Cap'+oModalidadIngreso+'TemparioAccion').html('Eliminado');	
				FncFichaAccionTemparioListar(oModalidadIngreso);
			}
		});	
			
		FncFichaAccionTemparioNuevo(oModalidadIngreso);
	}
	
}
