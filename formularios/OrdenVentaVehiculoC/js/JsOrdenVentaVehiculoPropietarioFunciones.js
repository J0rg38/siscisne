// JavaScript Document

/*
*** EVENTOS
*/	
$().ready(function() {

	
});


function FncOrdenVentaVehiculoPropietarioNuevo(){
	
	$('#CmpPropietarioNombre').val("");
	$('#CmpPropietarioNumeroDocumento').val("");
	$('#CmpPropietarioTipoDocumento').val("");
	
	$('#CmpPropietarioTelefono').val("");
	$('#CmpPropietarioCelular').val("");
	$('#CmpPropietarioEmail').val("");
	
	$('#CmpOrdenVentaVehiculoPropietarioFirmaDJ').val("1");
	$('#CmpOrdenVentaVehiculoPropietarioItem').val("");
	
	$('#CmpOrdenVentaVehiculoPropietarioAccion').val("AccOrdenVentaVehiculoPropietarioRegistrar.php");
	$('#CmpPropietarioNombre').select();
	$('#CapOrdenVentaVehiculoPropietarioAccion').html("Listo para registrar elementos");
	
	
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

function FncOrdenVentaVehiculoPropietarioGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var PropietarioId = $('#CmpPropietarioId').val();
	var PropietarioNombre = $('#CmpPropietarioNombre').val();
	var PropietarioNumeroDocumento = $('#CmpPropietarioNumeroDocumento').val();
	var PropietarioTipoDocumento = $('#CmpPropietarioTipoDocumento').val();
	var PropietarioPropietarioFirmaDJ = $('#CmpOrdenVentaVehiculoPropietarioFirmaDJ').val();
	
	var PropietarioTelefono = $('#CmpPropietarioTelefono').val();
	var PropietarioCelular = $('#CmpPropietarioCelular').val();
	var PropietarioEmail = $('#CmpPropietarioEmail').val();

	var Item = $('#CmpOrdenVentaVehiculoPropietarioItem').val();
	var Acc = $('#CmpOrdenVentaVehiculoPropietarioAccion').val();
	
	if(PropietarioNombre == ""){
		$('#CmpPropietarioNombre').select();	
	}else if(PropietarioTipoDocumento == ""){
		$('#CmpPropietarioTipoDocumento').focus();
	}else{
		
		$('#CapOrdenVentaVehiculoPropietarioAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculoC/acc/'+Acc,
			data: 'Identificador='+Identificador
			+'&PropietarioId='+(PropietarioId)
			+'&PropietarioNombre='+(PropietarioNombre)
			+'&PropietarioNumeroDocumento='+(PropietarioNumeroDocumento)
			+'&PropietarioTipoDocumento='+PropietarioTipoDocumento
			+'&PropietarioPropietarioFirmaDJ='+PropietarioPropietarioFirmaDJ
			+'&Item='+Item,
			success: function(){
				$('#CapOrdenVentaVehiculoPropietarioAccion').html('Listo');							
				FncOrdenVentaVehiculoPropietarioListar();
			}
		});

		FncOrdenVentaVehiculoPropietarioNuevo();
	}		
}


function FncOrdenVentaVehiculoPropietarioListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapOrdenVentaVehiculoPropietarioAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenVentaVehiculoC/FrmOrdenVentaVehiculoPropietarioListado.php',
		data: 'Identificador='+Identificador+'&Editar='+OrdenVentaVehiculoPropietarioEditar+'&Eliminar='+OrdenVentaVehiculoPropietarioEliminar,
		success: function(html){
			$('#CapOrdenVentaVehiculoPropietarioAccion').html('Listo');	
			$("#CapOrdenVentaVehiculoPropietarios").html("");
			$("#CapOrdenVentaVehiculoPropietarios").append(html);
			
			
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


function FncOrdenVentaVehiculoPropietarioEscoger(oItem){


//SesionObjeto-OrdenVentaVehiculoPropietario
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

	$('#CapOrdenVentaVehiculoPropietarioAccion').html('Editando...');
	$('#CmpOrdenVentaVehiculoPropietarioAccion').val("AccOrdenVentaVehiculoPropietarioEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/OrdenVentaVehiculoC/acc/AccOrdenVentaVehiculoPropietarioEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsOrdenVentaVehiculoPropietario){

			//alert(InsOrdenVentaVehiculoPropietario.Parametro6);
			$('#CmpPropietarioId').val(InsOrdenVentaVehiculoPropietario.Parametro6);
			
			$('#CmpPropietarioTipoDocumento').val(InsOrdenVentaVehiculoPropietario.Parametro5);
			
			$('#CmpPropietarioNombre').val(InsOrdenVentaVehiculoPropietario.Parametro3);
			$('#CmpPropietarioNumeroDocumento').val(InsOrdenVentaVehiculoPropietario.Parametro4);
			$('#CmpPropietarioTipoDocumento').val(InsOrdenVentaVehiculoPropietario.Parametro5);
			$('#CmpOrdenVentaVehiculoPropietarioFirmarDJ').val(InsOrdenVentaVehiculoPropietario.Parametro16);
			
			$('#CmpPropietarioTelefono').val(InsOrdenVentaVehiculoPropietario.Parametro10);
			$('#CmpPropietarioCelular').val(InsOrdenVentaVehiculoPropietario.Parametro11);
			$('#CmpPropietarioEmail').val(InsOrdenVentaVehiculoPropietario.Parametro12);
			
			$('#CmpOrdenVentaVehiculoPropietarioItem').val(InsOrdenVentaVehiculoPropietario.Item);
			
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
						
						

			tb_show(this.title,'principal2C.php?Mod=Cliente&Form=Editar&Dia=1&Id='+InsOrdenVentaVehiculoPropietario.Parametro6+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

		}
	});



	/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnPropietarioEditar").show();
	$("#BtnPropietarioRegistrar").hide();

}



function FncOrdenVentaVehiculoPropietarioEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapOrdenVentaVehiculoPropietarioAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculoC/acc/AccOrdenVentaVehiculoPropietarioEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapOrdenVentaVehiculoPropietarioAccion').html("Eliminado");	
				FncOrdenVentaVehiculoPropietarioListar();
			}
		});

		FncOrdenVentaVehiculoPropietarioNuevo();
		
	}

}

function FncOrdenVentaVehiculoPropietarioEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapOrdenVentaVehiculoPropietarioAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculoC/acc/AccOrdenVentaVehiculoPropietarioEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapOrdenVentaVehiculoPropietarioAccion').html('Eliminado');	
				FncOrdenVentaVehiculoPropietarioListar();
			}
		});	
		
		FncOrdenVentaVehiculoPropietarioNuevo();
	}
	
}



