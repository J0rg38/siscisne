// JavaScript Document

/*
*** EVENTOS
*/	
$().ready(function() {

	
});


function FncAprobacionVentaVehiculoPropietarioNuevo(){
	
	$('#CmpPropietarioNombre').val("");
	$('#CmpPropietarioNumeroDocumento').val("");
	$('#CmpPropietarioTipoDocumento').val("");
	
	$('#CmpPropietarioTelefono').val("");
	$('#CmpPropietarioCelular').val("");
	$('#CmpPropietarioEmail').val("");
	
	$('#CmpAprobacionVentaVehiculoPropietarioFirmaDJ').val("1");
	$('#CmpAprobacionVentaVehiculoPropietarioItem').val("");
	
	$('#CmpAprobacionVentaVehiculoPropietarioAccion').val("AccAprobacionVentaVehiculoPropietarioRegistrar.php");
	$('#CmpPropietarioNombre').select();
	$('#CapAprobacionVentaVehiculoPropietarioAccion').html("Listo para registrar elementos");
	
	
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

function FncAprobacionVentaVehiculoPropietarioGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var PropietarioId = $('#CmpPropietarioId').val();
	var PropietarioNombre = $('#CmpPropietarioNombre').val();
	var PropietarioNumeroDocumento = $('#CmpPropietarioNumeroDocumento').val();
	var PropietarioTipoDocumento = $('#CmpPropietarioTipoDocumento').val();
	var PropietarioPropietarioFirmaDJ = $('#CmpAprobacionVentaVehiculoPropietarioFirmaDJ').val();
	
	var PropietarioTelefono = $('#CmpPropietarioTelefono').val();
	var PropietarioCelular = $('#CmpPropietarioCelular').val();
	var PropietarioEmail = $('#CmpPropietarioEmail').val();

	var Item = $('#CmpAprobacionVentaVehiculoPropietarioItem').val();
	var Acc = $('#CmpAprobacionVentaVehiculoPropietarioAccion').val();
	
	if(PropietarioNombre == ""){
		$('#CmpPropietarioNombre').select();	
	}else if(PropietarioTipoDocumento == ""){
		$('#CmpPropietarioTipoDocumento').focus();
	}else{
		
		$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/AprobacionVentaVehiculo/acc/'+Acc,
			data: 'Identificador='+Identificador
			+'&PropietarioId='+(PropietarioId)
			+'&PropietarioNombre='+(PropietarioNombre)
			+'&PropietarioNumeroDocumento='+(PropietarioNumeroDocumento)
			+'&PropietarioTipoDocumento='+PropietarioTipoDocumento
			+'&PropietarioPropietarioFirmaDJ='+PropietarioPropietarioFirmaDJ
			+'&Item='+Item,
			success: function(){
				$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Listo');							
				FncAprobacionVentaVehiculoPropietarioListar();
			}
		});

		FncAprobacionVentaVehiculoPropietarioNuevo();
	}		
}


function FncAprobacionVentaVehiculoPropietarioListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/AprobacionVentaVehiculo/FrmAprobacionVentaVehiculoPropietarioListado.php',
		data: 'Identificador='+Identificador+'&Editar='+AprobacionVentaVehiculoPropietarioEditar+'&Eliminar='+AprobacionVentaVehiculoPropietarioEliminar,
		success: function(html){
			$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Listo');	
			$("#CapAprobacionVentaVehiculoPropietarios").html("");
			$("#CapAprobacionVentaVehiculoPropietarios").append(html);
			
			
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


function FncAprobacionVentaVehiculoPropietarioEscoger(oItem){


//SesionObjeto-AprobacionVentaVehiculoPropietario
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

	$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Editando...');
	$('#CmpAprobacionVentaVehiculoPropietarioAccion').val("AccAprobacionVentaVehiculoPropietarioEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/AprobacionVentaVehiculo/acc/AccAprobacionVentaVehiculoPropietarioEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsAprobacionVentaVehiculoPropietario){

			//alert(InsAprobacionVentaVehiculoPropietario.Parametro6);
			$('#CmpPropietarioId').val(InsAprobacionVentaVehiculoPropietario.Parametro6);
			
			$('#CmpPropietarioTipoDocumento').val(InsAprobacionVentaVehiculoPropietario.Parametro5);
			
			$('#CmpPropietarioNombre').val(InsAprobacionVentaVehiculoPropietario.Parametro3);
			$('#CmpPropietarioNumeroDocumento').val(InsAprobacionVentaVehiculoPropietario.Parametro4);
			$('#CmpPropietarioTipoDocumento').val(InsAprobacionVentaVehiculoPropietario.Parametro5);
			$('#CmpAprobacionVentaVehiculoPropietarioFirmarDJ').val(InsAprobacionVentaVehiculoPropietario.Parametro16);
			
			$('#CmpPropietarioTelefono').val(InsAprobacionVentaVehiculoPropietario.Parametro10);
			$('#CmpPropietarioCelular').val(InsAprobacionVentaVehiculoPropietario.Parametro11);
			$('#CmpPropietarioEmail').val(InsAprobacionVentaVehiculoPropietario.Parametro12);
			
			$('#CmpAprobacionVentaVehiculoPropietarioItem').val(InsAprobacionVentaVehiculoPropietario.Item);
			
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
						
						

			tb_show(this.title,'principal2.php?Mod=Cliente&Form=Editar&Dia=1&Id='+InsAprobacionVentaVehiculoPropietario.Parametro6+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

		}
	});



	/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnPropietarioEditar").show();
	$("#BtnPropietarioRegistrar").hide();

}



function FncAprobacionVentaVehiculoPropietarioEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/AprobacionVentaVehiculo/acc/AccAprobacionVentaVehiculoPropietarioEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapAprobacionVentaVehiculoPropietarioAccion').html("Eliminado");	
				FncAprobacionVentaVehiculoPropietarioListar();
			}
		});

		FncAprobacionVentaVehiculoPropietarioNuevo();
		
	}

}

function FncAprobacionVentaVehiculoPropietarioEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/AprobacionVentaVehiculo/acc/AccAprobacionVentaVehiculoPropietarioEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapAprobacionVentaVehiculoPropietarioAccion').html('Eliminado');	
				FncAprobacionVentaVehiculoPropietarioListar();
			}
		});	
		
		FncAprobacionVentaVehiculoPropietarioNuevo();
	}
	
}



