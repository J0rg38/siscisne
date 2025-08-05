// JavaScript Document

function FncVehiculoIngresoClienteNuevo(){
	
	$('#CmpClienteNombre').val("");
	$('#CmpClienteNumeroDocumento').val("");
	$('#CmpClienteTipoDocumento').val("");
	
	$('#CmpVehiculoIngresoClienteFecha').val("");
	$('#CmpClienteEstado').val("");
	
	
	$('#CmpVehiculoIngresoClienteItem').val("");
	
	$('#CmpVehiculoIngresoClienteAccion').val("AccVehiculoIngresoClienteRegistrar.php");
	$('#CmpClienteNombre').select();
	$('#CapVehiculoIngresoClienteAccion').html("Listo para registrar elementos");
	
	$('#CmpClienteNombre').removeAttr('readonly');
	$('#CmpClienteNumeroDocumento').removeAttr('readonly');
	$('#CmpClienteTipoDocumento').removeAttr('readonly');
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnClienteEditar").hide();
	$("#BtnClienteRegistrar").show();
	
}

function FncVehiculoIngresoClienteGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var ClienteId = $('#CmpClienteId').val();
	var ClienteNombre = $('#CmpClienteNombre').val();
	var ClienteNumeroDocumento = $('#CmpClienteNumeroDocumento').val();
	var ClienteTipoDocumento = $('#CmpClienteTipoDocumento').val();
	
	var VehiculoIngresoClienteFecha = $('#CmpVehiculoIngresoClienteFecha').val();
	var VehiculoIngresoClienteEstado = $('#CmpVehiculoIngresoClienteEstado').val();

	var Item = $('#CmpVehiculoIngresoClienteItem').val();
	var Acc = $('#CmpVehiculoIngresoClienteAccion').val();
	
	if(ClienteNombre == ""){
		$('#CmpClienteNombre').select();	
		
	}else if(ClienteTipoDocumento == ""){
		$('#CmpClienteTipoDocumento').focus();
		
	}else if(VehiculoIngresoClienteEstado == "0"){
		
			$('#CmpVehiculoIngresoClienteEstado').focus();
	}else{
		
		$('#CapVehiculoIngresoClienteAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&ClienteId='+(ClienteId)+
			'&ClienteNombre='+(ClienteNombre)+
			'&ClienteNumeroDocumento='+(ClienteNumeroDocumento)+
			'&ClienteTipoDocumento='+ClienteTipoDocumento+
			'&VehiculoIngresoClienteFecha='+VehiculoIngresoClienteFecha+
			'&VehiculoIngresoClienteEstado='+VehiculoIngresoClienteEstado+
			'&Item='+Item,
			success: function(){
				$('#CapVehiculoIngresoClienteAccion').html('Listo');							
				FncVehiculoIngresoClienteListar();
			}
		});

		FncVehiculoIngresoClienteNuevo();
	}		
}


function FncVehiculoIngresoClienteListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoIngresoClienteAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngreso/FrmVehiculoIngresoClienteListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+VehiculoIngresoClienteEditar+
'&Eliminar='+VehiculoIngresoClienteEliminar,
		success: function(html){
			$('#CapVehiculoIngresoClienteAccion').html('Listo');	
			$("#CapVehiculoIngresoClientes").html("");
			$("#CapVehiculoIngresoClientes").append(html);
		}
	});

}


function FncVehiculoIngresoClienteEscoger(oItem){

/*
SesionObjeto-VehiculoIngresoCliente
Parametro1 = CviId
Parametro2 = CliId
Parametro3 = CliNombre
Parametro4 = CliNumeroDocumento
Parametro5 = TdoId
Parametro6 = 
Parametro7 = CviTiempoCreacion
Parametro8 = CviTiempoModificacion
Parametro9 = TdoNombre

Parametro10 = CviEstado
Parametro11 = CviFecha
*/

	var Identificador = $('#Identificador').val();

	$('#CapVehiculoIngresoClienteAccion').html('Editando...');
	$('#CmpVehiculoIngresoClienteAccion').val("AccVehiculoIngresoClienteEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoClienteEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVehiculoIngresoCliente){
			
			$('#CmpClienteId').val(InsVehiculoIngresoCliente.Parametro2);
			$('#CmpClienteNombre').val(InsVehiculoIngresoCliente.Parametro3);
			$('#CmpClienteNumeroDocumento').val(InsVehiculoIngresoCliente.Parametro4);
			$('#CmpClienteTipoDocumento').val(InsVehiculoIngresoCliente.Parametro5);
			
			$('#CmpVehiculoIngresoClienteFecha').val(InsVehiculoIngresoCliente.Parametro11);
			$('#CmpVehiculoIngresoClienteEstado').val(InsVehiculoIngresoCliente.Parametro10);
			
			$('#CmpVehiculoIngresoClienteItem').val(InsVehiculoIngresoCliente.Item);
			
			$('#CmpClienteNombre').select();
		}
	});


	$('#CmpClienteNombre').attr('readonly', true);
	$('#CmpClienteNumeroDocumento').attr('readonly', true);
	$('#CmpClienteTipoDocumento').attr('disabled', true);
	/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnClienteEditar").show();
	$("#BtnClienteRegistrar").hide();

}



function FncVehiculoIngresoClienteEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoIngresoClienteAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoClienteEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoIngresoClienteAccion').html("Eliminado");	
				FncVehiculoIngresoClienteListar();
			}
		});

		FncVehiculoIngresoClienteNuevo();
		

	}


	
}

function FncVehiculoIngresoClienteEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapVehiculoIngresoClienteAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngreso/acc/AccVehiculoIngresoClienteEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoIngresoClienteAccion').html('Eliminado');	
				FncVehiculoIngresoClienteListar();
			}
		});	
		
		FncVehiculoIngresoClienteNuevo();
	}
	
}



