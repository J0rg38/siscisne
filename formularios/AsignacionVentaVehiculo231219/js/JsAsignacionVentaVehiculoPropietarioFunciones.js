// JavaScript Document

/*
*** EVENTOS
*/	
$().ready(function() {

	
});


function FncAsignacionVentaVehiculoPropietarioNuevo(){
	
	$('#CmpPropietarioNombre').val("");
	$('#CmpPropietarioNumeroDocumento').val("");
	$('#CmpPropietarioTipoDocumento').val("");
	
	$('#CmpPropietarioTelefono').val("");
	$('#CmpPropietarioCelular').val("");
	$('#CmpPropietarioEmail').val("");
	
	$('#CmpAsignacionVentaVehiculoPropietarioFirmaDJ').val("1");
	$('#CmpAsignacionVentaVehiculoPropietarioItem').val("");
	
	$('#CmpAsignacionVentaVehiculoPropietarioAccion').val("AccAsignacionVentaVehiculoPropietarioRegistrar.php");
	$('#CmpPropietarioNombre').select();
	$('#CapAsignacionVentaVehiculoPropietarioAccion').html("Listo para registrar elementos");
	
	
	//$('#CmpPropietarioTipoDocumento').removeAttr('disabled');
	
	$('#CmpPropietarioNombre').removeAttr('readonly');
	$('#CmpPropietarioNumeroDocumento').removeAttr('readonly');
	$('#CmpPropietarioTipoDocumento').removeAttr('readonly');
	
	//$('#CmpPropietarioTelefono').removeAttr('readonly');
//	$('#CmpPropietarioCelular').removeAttr('readonly');
//	$('#CmpPropietarioEmail').removeAttr('readonly');



						$("#CmpPropietarioTipoDocumento").unbind(); 

						//$("#CmpPropietarioNumeroDocumento").unbind(); 

						$("#CmpPropietarioTelefono").unbind(); 
						
						$("#CmpPropietarioCelular").unbind(); 
						
						$("#CmpPropietarioEmail").unbind(); 

/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnPropietarioEditar").hide();
	$("#BtnPropietarioRegistrar").show();
	
}

function FncAsignacionVentaVehiculoPropietarioGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var PropietarioId = $('#CmpPropietarioId').val();
	var PropietarioNombre = $('#CmpPropietarioNombre').val();
	var PropietarioNumeroDocumento = $('#CmpPropietarioNumeroDocumento').val();
	var PropietarioTipoDocumento = $('#CmpPropietarioTipoDocumento').val();
	var PropietarioPropietarioFirmaDJ = $('#CmpAsignacionVentaVehiculoPropietarioFirmaDJ').val();
	
	var PropietarioTelefono = $('#CmpPropietarioTelefono').val();
	var PropietarioCelular = $('#CmpPropietarioCelular').val();
	var PropietarioEmail = $('#CmpPropietarioEmail').val();

	var Item = $('#CmpAsignacionVentaVehiculoPropietarioItem').val();
	var Acc = $('#CmpAsignacionVentaVehiculoPropietarioAccion').val();
	
	if(PropietarioNombre == ""){
		$('#CmpPropietarioNombre').select();	
	}else if(PropietarioTipoDocumento == ""){
		$('#CmpPropietarioTipoDocumento').focus();
	}else{
		
		$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/AsignacionVentaVehiculo/acc/'+Acc,
			data: 'Identificador='+Identificador
			+'&PropietarioId='+(PropietarioId)
			+'&PropietarioNombre='+(PropietarioNombre)
			+'&PropietarioNumeroDocumento='+(PropietarioNumeroDocumento)
			+'&PropietarioTipoDocumento='+PropietarioTipoDocumento
			+'&PropietarioPropietarioFirmaDJ='+PropietarioPropietarioFirmaDJ
			+'&Item='+Item,
			success: function(){
				$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Listo');							
				FncAsignacionVentaVehiculoPropietarioListar();
			}
		});

		FncAsignacionVentaVehiculoPropietarioNuevo();
	}		
}


function FncAsignacionVentaVehiculoPropietarioListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoPropietarioListado.php',
		data: 'Identificador='+Identificador+'&Editar='+AsignacionVentaVehiculoPropietarioEditar+'&Eliminar='+AsignacionVentaVehiculoPropietarioEliminar,
		success: function(html){
			$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Listo');	
			$("#CapAsignacionVentaVehiculoPropietarios").html("");
			$("#CapAsignacionVentaVehiculoPropietarios").append(html);
			
			
			$('input[type=checkbox]').each(function () {
				if($(this).attr('etiqueta')=="propietario"){
					
					var Sigla = $(this).val();
						
						$($(this)).click(function(){
							
						});
						
				}
			});
			
		}
	});

}


function FncAsignacionVentaVehiculoPropietarioEscoger(oItem){


//SesionObjeto-AsignacionVentaVehiculoPropietario
//Parametro1 = CviId
//Parametro2 = 
//Parametro3 = CliNombre
//Parametro4 = CliNumeroDocumento
//Parametro5 = TdoId
//Parametro6 = CliId
//Parametro7 = CviTiempoCreacion
//Parametro8 = CviTiempoModificacion
//Parametro9 = TdoNombre

//Parametro10 = CliTelefono
//Parametro11 = CliCelular
//Parametro12 = CliEmail

	var Identificador = $('#Identificador').val();

	$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Editando...');
	$('#CmpAsignacionVentaVehiculoPropietarioAccion').val("AccAsignacionVentaVehiculoPropietarioEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoPropietarioEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsAsignacionVentaVehiculoPropietario){

			//alert(InsAsignacionVentaVehiculoPropietario.Parametro6);
			$('#CmpPropietarioId').val(InsAsignacionVentaVehiculoPropietario.Parametro6);
			
			$('#CmpPropietarioTipoDocumento').val(InsAsignacionVentaVehiculoPropietario.Parametro5);
			
			$('#CmpPropietarioNombre').val(InsAsignacionVentaVehiculoPropietario.Parametro3);
			$('#CmpPropietarioNumeroDocumento').val(InsAsignacionVentaVehiculoPropietario.Parametro4);
			$('#CmpPropietarioTipoDocumento').val(InsAsignacionVentaVehiculoPropietario.Parametro5);
			$('#CmpAsignacionVentaVehiculoPropietarioFirmarDJ').val(InsAsignacionVentaVehiculoPropietario.Parametro16);
			
			$('#CmpPropietarioTelefono').val(InsAsignacionVentaVehiculoPropietario.Parametro10);
			$('#CmpPropietarioCelular').val(InsAsignacionVentaVehiculoPropietario.Parametro11);
			$('#CmpPropietarioEmail').val(InsAsignacionVentaVehiculoPropietario.Parametro12);
			
			$('#CmpAsignacionVentaVehiculoPropietarioItem').val(InsAsignacionVentaVehiculoPropietario.Item);
			
			$('#CmpPropietarioNombre').select();
			
			//$('#CmpPropietarioTipoDocumento').attr('disabled', true);
			
			$('#CmpPropietarioNombre').attr('readonly', true);
			$('#CmpPropietarioNumeroDocumento').attr('readonly', true);
			$('#CmpPropietarioTipoDocumento').attr('readonly', true);






						$("#CmpPropietarioTipoDocumento").click(function (event) {  
							
							FncPropietarioCargarFormulario("Editar");
							
						}); 

						

					//	$("#CmpPropietarioNumeroDocumento").keyup(function (event) {  
//							 if (event.keyCode >= 48 && event.keyCode <= 90) {
//
//								FncPropietarioCargarFormulario("Editar");
//
//							 }
//						}); 
//						
						

						$("#CmpPropietarioTelefono").keyup(function (event) {  
							 if (event.keyCode >= 48 && event.keyCode <= 90) {

								FncPropietarioCargarFormulario("Editar");

							 }
						}); 
						
						
						$("#CmpPropietarioCelular").keyup(function (event) {  
							 if (event.keyCode >= 48 && event.keyCode <= 90) {

								FncPropietarioCargarFormulario("Editar");

							 }
						}); 
						
						$("#CmpPropietarioEmail").keyup(function (event) {  
							 if (event.keyCode >= 48 && event.keyCode <= 90) {

								FncPropietarioCargarFormulario("Editar");

							 }
						}); 
						
						

			tb_show(this.title,'principal2.php?Mod=Cliente&Form=Editar&Dia=1&Id='+InsAsignacionVentaVehiculoPropietario.Parametro6+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

		}
	});



	/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnPropietarioEditar").show();
	$("#BtnPropietarioRegistrar").hide();

}



function FncAsignacionVentaVehiculoPropietarioEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoPropietarioEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapAsignacionVentaVehiculoPropietarioAccion').html("Eliminado");	
				FncAsignacionVentaVehiculoPropietarioListar();
			}
		});

		FncAsignacionVentaVehiculoPropietarioNuevo();
		
	}

}

function FncAsignacionVentaVehiculoPropietarioEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoPropietarioEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapAsignacionVentaVehiculoPropietarioAccion').html('Eliminado');	
				FncAsignacionVentaVehiculoPropietarioListar();
			}
		});	
		
		FncAsignacionVentaVehiculoPropietarioNuevo();
	}
	
}




