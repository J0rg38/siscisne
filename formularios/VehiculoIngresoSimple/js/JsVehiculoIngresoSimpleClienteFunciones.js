// JavaScript Document

function FncVehiculoIngresoSimpleClienteNuevo(){
	
	$('#CmpClienteNombre').val("");
	$('#CmpClienteNumeroDocumento').val("");
	$('#CmpClienteTipoDocumento').val("");
	
	$('#CmpVehiculoIngresoClienteSimpleFecha').val("");
	$('#CmpClienteEstado').val("");
	
	
	$('#CmpVehiculoIngresoClienteSimpleItem').val("");
	
	$('#CmpVehiculoIngresoClienteSimpleAccion').val("AccVehiculoIngresoSimpleClienteRegistrar.php");
	$('#CmpClienteNombre').select();
	$('#CapVehiculoIngresoClienteSimpleAccion').html("Listo para registrar elementos");
	
	$('#CmpClienteNombre').removeAttr('readonly');
	$('#CmpClienteNumeroDocumento').removeAttr('readonly');
	$('#CmpClienteTipoDocumento').removeAttr('readonly');
	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnClienteEditar").hide();
	$("#BtnClienteRegistrar").show();
	
}

function FncVehiculoIngresoSimpleClienteGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var ClienteId = $('#CmpClienteId').val();
	var ClienteNombre = $('#CmpClienteNombre').val();
	var ClienteNumeroDocumento = $('#CmpClienteNumeroDocumento').val();
	var ClienteTipoDocumento = $('#CmpClienteTipoDocumento').val();
	
	var VehiculoIngresoClienteSimpleFecha = $('#CmpVehiculoIngresoClienteSimpleFecha').val();
	var VehiculoIngresoClienteSimpleEstado = $('#CmpVehiculoIngresoClienteSimpleEstado').val();

	var Item = $('#CmpVehiculoIngresoClienteSimpleItem').val();
	var Acc = $('#CmpVehiculoIngresoClienteSimpleAccion').val();
	
	if(ClienteNombre == ""){
		$('#CmpClienteNombre').select();	
		
	}else if(ClienteTipoDocumento == ""){
		$('#CmpClienteTipoDocumento').focus();
		
	}else if(VehiculoIngresoClienteSimpleEstado == "0"){
		
			$('#CmpVehiculoIngresoClienteSimpleEstado').focus();
	}else{
		
		$('#CapVehiculoIngresoClienteSimpleAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngresoSimple/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&ClienteId='+(ClienteId)+
			'&ClienteNombre='+(ClienteNombre)+
			'&ClienteNumeroDocumento='+(ClienteNumeroDocumento)+
			'&ClienteTipoDocumento='+ClienteTipoDocumento+
			'&VehiculoIngresoClienteSimpleFecha='+VehiculoIngresoClienteSimpleFecha+
			'&VehiculoIngresoClienteSimpleEstado='+VehiculoIngresoClienteSimpleEstado+
			'&Item='+Item,
			success: function(){
				$('#CapVehiculoIngresoClienteSimpleAccion').html('Listo');							
				FncVehiculoIngresoSimpleClienteListar();
			}
		});

		FncVehiculoIngresoSimpleClienteNuevo();
	}		
}


function FncVehiculoIngresoSimpleClienteListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoIngresoClienteSimpleAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoIngresoSimple/FrmVehiculoIngresoClienteSimpleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+VehiculoIngresoClienteSimpleEditar+
'&Eliminar='+VehiculoIngresoClienteSimpleEliminar,
		success: function(html){
			$('#CapVehiculoIngresoClienteSimpleAccion').html('Listo');	
			$("#CapVehiculoIngresoClienteSimples").html("");
			$("#CapVehiculoIngresoClienteSimples").append(html);
		}
	});

}


function FncVehiculoIngresoSimpleClienteEscoger(oItem){

/*
SesionObjeto-VehiculoIngresoClienteSimple
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

	$('#CapVehiculoIngresoClienteSimpleAccion').html('Editando...');
	$('#CmpVehiculoIngresoClienteSimpleAccion').val("AccVehiculoIngresoSimpleClienteEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoIngresoSimple/acc/AccVehiculoIngresoSimpleClienteEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsVehiculoIngresoClienteSimple){
			
			$('#CmpClienteId').val(InsVehiculoIngresoClienteSimple.Parametro2);
			$('#CmpClienteNombre').val(InsVehiculoIngresoClienteSimple.Parametro3);
			$('#CmpClienteNumeroDocumento').val(InsVehiculoIngresoClienteSimple.Parametro4);
			$('#CmpClienteTipoDocumento').val(InsVehiculoIngresoClienteSimple.Parametro5);
			
			$('#CmpVehiculoIngresoClienteSimpleFecha').val(InsVehiculoIngresoClienteSimple.Parametro11);
			$('#CmpVehiculoIngresoClienteSimpleEstado').val(InsVehiculoIngresoClienteSimple.Parametro10);
			
			$('#CmpVehiculoIngresoClienteSimpleItem').val(InsVehiculoIngresoClienteSimple.Item);
			
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



function FncVehiculoIngresoSimpleClienteEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoIngresoClienteSimpleAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngresoSimple/acc/AccVehiculoIngresoSimpleClienteEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoIngresoClienteSimpleAccion').html("Eliminado");	
				FncVehiculoIngresoSimpleClienteListar();
			}
		});

		FncVehiculoIngresoSimpleClienteNuevo();
		

	}


	
}

function FncVehiculoIngresoSimpleClienteEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapVehiculoIngresoClienteSimpleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoIngresoSimple/acc/AccVehiculoIngresoSimpleClienteEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoIngresoClienteSimpleAccion').html('Eliminado');	
				FncVehiculoIngresoSimpleClienteListar();
			}
		});	
		
		FncVehiculoIngresoSimpleClienteNuevo();
	}
	
}



