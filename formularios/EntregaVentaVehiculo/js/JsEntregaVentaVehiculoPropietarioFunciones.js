// JavaScript Document

/*
*** EVENTOS
*/	
$().ready(function() {

	
});


function FncEntregaVentaVehiculoPropietarioNuevo(){
	
	$('#CmpPropietarioNombre').val("");
	$('#CmpPropietarioNumeroDocumento').val("");
	$('#CmpPropietarioTipoDocumento').val("");
	
	$('#CmpPropietarioTelefono').val("");
	$('#CmpPropietarioCelular').val("");
	$('#CmpPropietarioEmail').val("");
	
	$('#CmpEntregaVentaVehiculoPropietarioFirmaDJ').val("1");
	$('#CmpEntregaVentaVehiculoPropietarioItem').val("");
	
	$('#CmpEntregaVentaVehiculoPropietarioAccion').val("AccEntregaVentaVehiculoPropietarioRegistrar.php");
	$('#CmpPropietarioNombre').select();
	$('#CapEntregaVentaVehiculoPropietarioAccion').html("Listo para registrar elementos");
	
	
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

function FncEntregaVentaVehiculoPropietarioGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var PropietarioId = $('#CmpPropietarioId').val();
	var PropietarioNombre = $('#CmpPropietarioNombre').val();
	var PropietarioNumeroDocumento = $('#CmpPropietarioNumeroDocumento').val();
	var PropietarioTipoDocumento = $('#CmpPropietarioTipoDocumento').val();
	var PropietarioPropietarioFirmaDJ = $('#CmpEntregaVentaVehiculoPropietarioFirmaDJ').val();
	
	var PropietarioTelefono = $('#CmpPropietarioTelefono').val();
	var PropietarioCelular = $('#CmpPropietarioCelular').val();
	var PropietarioEmail = $('#CmpPropietarioEmail').val();

	var Item = $('#CmpEntregaVentaVehiculoPropietarioItem').val();
	var Acc = $('#CmpEntregaVentaVehiculoPropietarioAccion').val();
	
	if(PropietarioNombre == ""){
		$('#CmpPropietarioNombre').select();	
	}else if(PropietarioTipoDocumento == ""){
		$('#CmpPropietarioTipoDocumento').focus();
	}else{
		
		$('#CapEntregaVentaVehiculoPropietarioAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/EntregaVentaVehiculo/acc/'+Acc,
			data: 'Identificador='+Identificador
			+'&PropietarioId='+(PropietarioId)
			+'&PropietarioNombre='+(PropietarioNombre)
			+'&PropietarioNumeroDocumento='+(PropietarioNumeroDocumento)
			+'&PropietarioTipoDocumento='+PropietarioTipoDocumento
			+'&PropietarioPropietarioFirmaDJ='+PropietarioPropietarioFirmaDJ
			+'&Item='+Item,
			success: function(){
				$('#CapEntregaVentaVehiculoPropietarioAccion').html('Listo');							
				FncEntregaVentaVehiculoPropietarioListar();
			}
		});

		FncEntregaVentaVehiculoPropietarioNuevo();
	}		
}


function FncEntregaVentaVehiculoPropietarioListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapEntregaVentaVehiculoPropietarioAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/EntregaVentaVehiculo/FrmEntregaVentaVehiculoPropietarioListado.php',
		data: 'Identificador='+Identificador+'&Editar='+EntregaVentaVehiculoPropietarioEditar+'&Eliminar='+EntregaVentaVehiculoPropietarioEliminar,
		success: function(html){
			$('#CapEntregaVentaVehiculoPropietarioAccion').html('Listo');	
			$("#CapEntregaVentaVehiculoPropietarios").html("");
			$("#CapEntregaVentaVehiculoPropietarios").append(html);
			
			
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


function FncEntregaVentaVehiculoPropietarioEscoger(oItem){


//SesionObjeto-EntregaVentaVehiculoPropietario
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

	$('#CapEntregaVentaVehiculoPropietarioAccion').html('Editando...');
	$('#CmpEntregaVentaVehiculoPropietarioAccion').val("AccEntregaVentaVehiculoPropietarioEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoPropietarioEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsEntregaVentaVehiculoPropietario){

			//alert(InsEntregaVentaVehiculoPropietario.Parametro6);
			$('#CmpPropietarioId').val(InsEntregaVentaVehiculoPropietario.Parametro6);
			
			$('#CmpPropietarioTipoDocumento').val(InsEntregaVentaVehiculoPropietario.Parametro5);
			
			$('#CmpPropietarioNombre').val(InsEntregaVentaVehiculoPropietario.Parametro3);
			$('#CmpPropietarioNumeroDocumento').val(InsEntregaVentaVehiculoPropietario.Parametro4);
			$('#CmpPropietarioTipoDocumento').val(InsEntregaVentaVehiculoPropietario.Parametro5);
			$('#CmpEntregaVentaVehiculoPropietarioFirmarDJ').val(InsEntregaVentaVehiculoPropietario.Parametro16);
			
			$('#CmpPropietarioTelefono').val(InsEntregaVentaVehiculoPropietario.Parametro10);
			$('#CmpPropietarioCelular').val(InsEntregaVentaVehiculoPropietario.Parametro11);
			$('#CmpPropietarioEmail').val(InsEntregaVentaVehiculoPropietario.Parametro12);
			
			$('#CmpEntregaVentaVehiculoPropietarioItem').val(InsEntregaVentaVehiculoPropietario.Item);
			
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
						
						

			tb_show(this.title,'principal2.php?Mod=Cliente&Form=Editar&Dia=1&Id='+InsEntregaVentaVehiculoPropietario.Parametro6+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

		}
	});



	/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnPropietarioEditar").show();
	$("#BtnPropietarioRegistrar").hide();

}



function FncEntregaVentaVehiculoPropietarioEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapEntregaVentaVehiculoPropietarioAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoPropietarioEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapEntregaVentaVehiculoPropietarioAccion').html("Eliminado");	
				FncEntregaVentaVehiculoPropietarioListar();
			}
		});

		FncEntregaVentaVehiculoPropietarioNuevo();
		
	}

}

function FncEntregaVentaVehiculoPropietarioEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapEntregaVentaVehiculoPropietarioAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/EntregaVentaVehiculo/acc/AccEntregaVentaVehiculoPropietarioEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapEntregaVentaVehiculoPropietarioAccion').html('Eliminado');	
				FncEntregaVentaVehiculoPropietarioListar();
			}
		});	
		
		FncEntregaVentaVehiculoPropietarioNuevo();
	}
	
}



