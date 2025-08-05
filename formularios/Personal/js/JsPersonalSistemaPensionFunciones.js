// JavaScript Document

function FncPersonalSistemaPensionNuevo(){

	$('#CmpPersonalSistemaPension').val("");
	$('#CmpPersonalSistemaPensionCodigoUnico').val("");
	$('#CmpPersonalSistemaPensionFecha').val("");
	$('#CmpPersonalSistemaPensionItem').val("");

	$('#CmpPersonalSistemaPensionAccion').val("AccPersonalSistemaPensionRegistrar.php");
	
	$('#CmpPersonalSistemaPension').select();

	$('#CapPersonalSistemaPensionAccion').html("Listo para registrar elementos");
	$('#CmpTipoCambio').removeAttr('disabled');	
}

function FncPersonalSistemaPensionGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var SistemaPension = $('#CmpPersonalSistemaPension').val();
	var SistemaPensionNombre = 	$('#CmpPersonalSistemaPension').find("option:selected").text();
	
	var CodigoUnico = $('#CmpPersonalSistemaPensionCodigoUnico').val();
	var Fecha = $('#CmpPersonalSistemaPensionFecha').val();
	
	var Item = $('#CmpPersonalSistemaPensionItem').val();
	var Acc = $('#CmpPersonalSistemaPensionAccion').val();
	
	if(SistemaPension==""){
		$('#CmpPersonalSistemaPension').focus();	
	}else if(CodigoUnico==""){
			$('#CmpPersonalSistemaPensionCodigoUnico').select();	
		}else if(Fecha==""){
			$('#CmpPersonalSistemaPensionFecha').select();	
		}else{
			$('#CapPersonalSistemaPensionAccion').html('Guardando...');

				$.ajax({
					type: 'POST',
					url: 'formularios/Personal/acc/'+Acc,
					data: 'Identificador='+Identificador+'&SistemaPension='+SistemaPension+'&CodigoUnico='+CodigoUnico+'&Fecha='+Fecha+'&SistemaPensionNombre='+SistemaPensionNombre+'&Item='+Item,
					success: function(){
						$('#CapPersonalSistemaPensionAccion').html('Listo');							
						FncPersonalSistemaPensionListar();
					}
				});

						if(confirm("Desea seguir agregando mas items?")==false){
								if(confirm("Desea guardar el registro ahora?")){
									$('#Guardar').val("1");
									$('#'+Formulario).submit();
								}
							}
							
			FncPersonalSistemaPensionNuevo();
		
	}		
	
}


function FncPersonalSistemaPensionListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapPersonalSistemaPensionAccion').html('Cargando...');

	if(document.getElementById('CmpMostrarTiempoModificacion').checked == 1){
		var MostrarTiempoModificacion = 1;
	}else{
		var MostrarTiempoModificacion =	0;
	}
		
	$.ajax({
		type: 'POST',
		url: 'formularios/Personal/FrmPersonalSistemaPensionListado.php',
		data: 'Identificador='+Identificador+'&MostrarTiempoModificacion='+MostrarTiempoModificacion+'&Editar='+PersonalSistemaPensionEditar+'&Eliminar='+PersonalSistemaPensionEliminar,
		success: function(html){
			$('#CapPersonalSistemaPensionAccion').html('Listo');	
			$("#CapPersonalSistemaPensiones").html("");
			$("#CapPersonalSistemaPensiones").append(html);
		}
	});

}


function FncPersonalSistemaPensionEscoger(oItem){

	var Identificador = $('#Identificador').val();
	
	$('#CapPersonalSistemaPensionAccion').html('Editando...');
	$('#CmpPersonalSistemaPensionAccion').val("AccPersonalSistemaPensionEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Personal/acc/AccPersonalSistemaPensionEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsPersonalSistemaPension){
				$('#CmpPersonalSistemaPension').val(InsPersonalSistemaPension.Parametro2);		
				$('#CmpPersonalSistemaPensionCodigoUnico').val(InsPersonalSistemaPension.Parametro4);	
				$('#CmpPersonalSistemaPensionFecha').val(InsPersonalSistemaPension.Parametro3);	
				$('#CmpPersonalSistemaPensionItem').val(InsPersonalSistemaPension.Item);
				$('#CmpPersonalSistemaPension').attr('disabled', 'disabled');
				
		}
	});

	$('#CmpPersonalSistemaPensionCodigoUnico').focus();
}



function FncPersonalSistemaPensionEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapPersonalSistemaPensionAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/Personal/acc/AccPersonalSistemaPensionEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapPersonalSistemaPensionAccion').html("Eliminado");	
				FncPersonalSistemaPensionListar();
			}
		});

		FncPersonalSistemaPensionNuevo();
	}


	
}

function FncPersonalSistemaPensionEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapPersonalSistemaPensionAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Personal/acc/AccPersonalSistemaPensionEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapPersonalSistemaPensionAccion').html('Eliminado');	
				FncPersonalSistemaPensionListar();
			}
		});	
				
		FncPersonalSistemaPensionNuevo();
	}
	
}