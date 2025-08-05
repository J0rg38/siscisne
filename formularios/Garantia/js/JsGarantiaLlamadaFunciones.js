// JavaScript Document

function FncGarantiaLlamadaNuevo(){
	
	$('#CmpGarantiaLlamadaId').val("");

	//$('#CmpGarantiaLlamadaNumero').val("");
	$('#CmpGarantiaLlamadaFecha').val("");

	$('#CmpGarantiaLlamadaObservacion').val("");
	$('#CmpGarantiaLlamadaItem').val("");	

	$('#CapGarantiaLlamadaAccion').html('Listo para registrar elementos');	
			
	$('#CmpGarantiaLlamadaNumero').select();
			
	$('#CmpGarantiaLlamadaAccion').val("AccGarantiaLlamadaRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncGarantiaLlamadaGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpGarantiaLlamadaAccion').val();		

	var GarantiaLlamadaId = $('#CmpGarantiaLlamadaId').val();
	//var GarantiaLlamadaNumero = $('#CmpGarantiaLlamadaNumero').val();			
	var GarantiaLlamadaFecha = $('#CmpGarantiaLlamadaFecha').val();
	var GarantiaLlamadaObservacion = $('#CmpGarantiaLlamadaObservacion').val();
	var GarantiaLlamadaValor = $('#CmpGarantiaLlamadaValor').val();
				
	var Item = $('#CmpGarantiaLlamadaItem').val();
	
	if(GarantiaLlamadaFecha==""){
		$('#CmpGarantiaLlamadaFecha').select();
	}else if(GarantiaLlamadaObservacion=="" || GarantiaLlamadaObservacion <=0){
		$('#CmpGarantiaLlamadaObservacion').select();	
	}else{
		$('#CapGarantiaLlamadaAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/'+Acc,
			data: 'Identificador='+Identificador+'&GarantiaLlamadaId='+GarantiaLlamadaId+'&GarantiaLlamadaFecha='+GarantiaLlamadaFecha+'&GarantiaLlamadaObservacion='+GarantiaLlamadaObservacion+'&Item='+Item,
			success: function(){
				
			$('#CapGarantiaLlamadaAccion').html('Listo');							
				FncGarantiaLlamadaListar();
			}
		});
		
		FncGarantiaLlamadaNuevo();
	}
	
}


function FncGarantiaLlamadaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapGarantiaLlamadaAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaLlamadaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+GarantiaLlamadaEditar+'&Eliminar='+GarantiaLlamadaEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapGarantiaLlamadaAccion').html('Listo');	
			$("#CapGarantiaLlamadas").html("");
			$("#CapGarantiaLlamadas").append(html);
		}
	});

}



function FncGarantiaLlamadaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapGarantiaLlamadaAccion').html('Editando...');
	$('#CmpGarantiaLlamadaAccion').val("AccGarantiaLlamadaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Garantia/acc/AccGarantiaLlamadaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsGarantiaLlamada){

		//SesionObjeto-InsGarantiaLlamada
		//Parametro1 = GopId
		//Parametro2 = 
		//Parametro3 = GopFecha
		//Parametro4 = 
		//Parametro5 = GopObservacion
		//Parametro6 = GopEstado
		//Parametro7 = GopFechaCreacion
		//Parametro8 = GopFechaModificacion

			$('#CmpGarantiaLlamadaFecha').val(InsGarantiaLlamada.Parametro3);
			$('#CmpGarantiaLlamadaObservacion').val(InsGarantiaLlamada.Parametro5);

			$('#CmpGarantiaLlamadaItem').val(InsGarantiaLlamada.Item);

			$('#CmpGarantiaLlamadaFecha').select();

		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncGarantiaLlamadaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapGarantiaLlamadaAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/AccGarantiaLlamadaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapGarantiaLlamadaAccion').html("Eliminado");	
				FncGarantiaLlamadaListar();
			}
		});

		FncGarantiaLlamadaNuevo();

	}
	
}

function FncGarantiaLlamadaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapGarantiaLlamadaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/AccGarantiaLlamadaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapGarantiaLlamadaAccion').html('Eliminado');	
				FncGarantiaLlamadaListar();
			}
		});	
			
		FncGarantiaLlamadaNuevo();
	}
	
}





