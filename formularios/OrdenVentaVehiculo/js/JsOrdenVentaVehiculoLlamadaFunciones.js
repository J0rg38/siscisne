// JavaScript Document

function FncOrdenVentaVehiculoLlamadaNuevo(){
	
	$('#CmpOrdenVentaVehiculoLlamadaId').val("");

	//$('#CmpOrdenVentaVehiculoLlamadaNumero').val("");
	$('#CmpOrdenVentaVehiculoLlamadaFecha').val("");

	$('#CmpOrdenVentaVehiculoLlamadaObservacion').val("");
	$('#CmpOrdenVentaVehiculoLlamadaItem').val("");	

	$('#CapOrdenVentaVehiculoLlamadaAccion').html('Listo para registrar elementos');	
			
	$('#CmpOrdenVentaVehiculoLlamadaNumero').select();
			
	$('#CmpOrdenVentaVehiculoLlamadaAccion').val("AccOrdenVentaVehiculoLlamadaRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncOrdenVentaVehiculoLlamadaGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpOrdenVentaVehiculoLlamadaAccion').val();		

	var OrdenVentaVehiculoLlamadaId = $('#CmpOrdenVentaVehiculoLlamadaId').val();
	//var OrdenVentaVehiculoLlamadaNumero = $('#CmpOrdenVentaVehiculoLlamadaNumero').val();			
	var OrdenVentaVehiculoLlamadaFecha = $('#CmpOrdenVentaVehiculoLlamadaFecha').val();
	var OrdenVentaVehiculoLlamadaObservacion = $('#CmpOrdenVentaVehiculoLlamadaObservacion').val();
	var OrdenVentaVehiculoLlamadaValor = $('#CmpOrdenVentaVehiculoLlamadaValor').val();
				
	var Item = $('#CmpOrdenVentaVehiculoLlamadaItem').val();
	
	if(OrdenVentaVehiculoLlamadaFecha==""){
		$('#CmpOrdenVentaVehiculoLlamadaFecha').select();
	}else if(OrdenVentaVehiculoLlamadaObservacion=="" || OrdenVentaVehiculoLlamadaObservacion <=0){
		$('#CmpOrdenVentaVehiculoLlamadaObservacion').select();	
	}else{
		$('#CapOrdenVentaVehiculoLlamadaAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculo/acc/'+Acc,
			data: 'Identificador='+Identificador+'&OrdenVentaVehiculoLlamadaId='+OrdenVentaVehiculoLlamadaId+'&OrdenVentaVehiculoLlamadaFecha='+OrdenVentaVehiculoLlamadaFecha+'&OrdenVentaVehiculoLlamadaObservacion='+OrdenVentaVehiculoLlamadaObservacion+'&Item='+Item,
			success: function(){
				
			$('#CapOrdenVentaVehiculoLlamadaAccion').html('Listo');							
				FncOrdenVentaVehiculoLlamadaListar();
			}
		});
		
		FncOrdenVentaVehiculoLlamadaNuevo();
	}
	
}


function FncOrdenVentaVehiculoLlamadaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapOrdenVentaVehiculoLlamadaAccion').html('Cargando...');

	
	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoLlamadaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+OrdenVentaVehiculoLlamadaEditar+'&Eliminar='+OrdenVentaVehiculoLlamadaEliminar,
		success: function(html){
			$('#CapOrdenVentaVehiculoLlamadaAccion').html('Listo');	
			$("#CapOrdenVentaVehiculoLlamadas").html("");
			$("#CapOrdenVentaVehiculoLlamadas").append(html);
		}
	});

}



function FncOrdenVentaVehiculoLlamadaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapOrdenVentaVehiculoLlamadaAccion').html('Editando...');
	$('#CmpOrdenVentaVehiculoLlamadaAccion').val("AccOrdenVentaVehiculoLlamadaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoLlamadaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsOrdenVentaVehiculoLlamada){

		//SesionObjeto-InsOrdenVentaVehiculoLlamada
		//Parametro1 = GopId
		//Parametro2 = 
		//Parametro3 = GopFecha
		//Parametro4 = 
		//Parametro5 = GopObservacion
		//Parametro6 = GopEstado
		//Parametro7 = GopFechaCreacion
		//Parametro8 = GopFechaModificacion

			$('#CmpOrdenVentaVehiculoLlamadaFecha').val(InsOrdenVentaVehiculoLlamada.Parametro3);
			$('#CmpOrdenVentaVehiculoLlamadaObservacion').val(InsOrdenVentaVehiculoLlamada.Parametro5);

			$('#CmpOrdenVentaVehiculoLlamadaItem').val(InsOrdenVentaVehiculoLlamada.Item);

			$('#CmpOrdenVentaVehiculoLlamadaFecha').select();

		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncOrdenVentaVehiculoLlamadaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapOrdenVentaVehiculoLlamadaAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoLlamadaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapOrdenVentaVehiculoLlamadaAccion').html("Eliminado");	
				FncOrdenVentaVehiculoLlamadaListar();
			}
		});

		FncOrdenVentaVehiculoLlamadaNuevo();

	}
	
}

function FncOrdenVentaVehiculoLlamadaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapOrdenVentaVehiculoLlamadaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/OrdenVentaVehiculo/acc/AccOrdenVentaVehiculoLlamadaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapOrdenVentaVehiculoLlamadaAccion').html('Eliminado');	
				FncOrdenVentaVehiculoLlamadaListar();
			}
		});	
			
		FncOrdenVentaVehiculoLlamadaNuevo();
	}
	
}





