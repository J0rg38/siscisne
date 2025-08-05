// JavaScript Document

function FncCotizacionVehiculoLlamadaNuevo(){
	
	var f = new Date();
	//document.write(f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());

	$('#CmpCotizacionVehiculoLlamadaId').val("");

	//$('#CmpCotizacionVehiculoLlamadaNumero').val("");
	$('#CmpCotizacionVehiculoLlamadaFecha').val(f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
	$('#CmpCotizacionVehiculoLlamadaFechaProgramada').val("");
	
	$('#CmpCotizacionVehiculoLlamadaObservacion').val("");
	$('#CmpCotizacionVehiculoLlamadaItem').val("");	

	$('#CapCotizacionVehiculoLlamadaAccion').html('Listo para registrar elementos');	
			
	$('#CmpCotizacionVehiculoLlamadaNumero').select();
			
	$('#CmpCotizacionVehiculoLlamadaAccion').val("AccCotizacionVehiculoLlamadaRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncCotizacionVehiculoLlamadaGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpCotizacionVehiculoLlamadaAccion').val();		

	var CotizacionVehiculoLlamadaId = $('#CmpCotizacionVehiculoLlamadaId').val();
	//var CotizacionVehiculoLlamadaNumero = $('#CmpCotizacionVehiculoLlamadaNumero').val();			
	var CotizacionVehiculoLlamadaFecha = $('#CmpCotizacionVehiculoLlamadaFecha').val();
	var CotizacionVehiculoLlamadaFechaProgramada = $('#CmpCotizacionVehiculoLlamadaFechaProgramada').val();
	var CotizacionVehiculoLlamadaObservacion = $('#CmpCotizacionVehiculoLlamadaObservacion').val();
	var CotizacionVehiculoLlamadaValor = $('#CmpCotizacionVehiculoLlamadaValor').val();
				
	var Item = $('#CmpCotizacionVehiculoLlamadaItem').val();
	
	if(CotizacionVehiculoLlamadaFecha==""){
		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de llamada",
					callback: function(result){
						$('#CmpCotizacionVehiculoLlamadaFecha').focus();
					}
				});
				
	}else if(CotizacionVehiculoLlamadaObservacion=="" ){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una nota",
					callback: function(result){
						$('#CmpCotizacionVehiculoLlamadaObservacion').focus();
					}
				});
	}else{
		$('#CapCotizacionVehiculoLlamadaAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionVehiculo/acc/'+Acc,
			data: 'Identificador='+Identificador+'&CotizacionVehiculoLlamadaId='+CotizacionVehiculoLlamadaId+'&CotizacionVehiculoLlamadaFecha='+CotizacionVehiculoLlamadaFecha+'&CotizacionVehiculoLlamadaFechaProgramada='+CotizacionVehiculoLlamadaFechaProgramada+'&CotizacionVehiculoLlamadaObservacion='+CotizacionVehiculoLlamadaObservacion+'&Item='+Item,
			success: function(){
				
			$('#CapCotizacionVehiculoLlamadaAccion').html('Listo');							
				FncCotizacionVehiculoLlamadaListar();
			}
		});
		
		FncCotizacionVehiculoLlamadaNuevo();
	}
	
}


function FncCotizacionVehiculoLlamadaListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCotizacionVehiculoLlamadaAccion').html('Cargando...');

	
	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionVehiculo/FrmCotizacionVehiculoLlamadaListado.php',
		data: 'Identificador='+Identificador+'&Editar='+CotizacionVehiculoLlamadaEditar+'&Eliminar='+CotizacionVehiculoLlamadaEliminar,
		success: function(html){
			$('#CapCotizacionVehiculoLlamadaAccion').html('Listo');	
			$("#CapCotizacionVehiculoLlamadas").html("");
			$("#CapCotizacionVehiculoLlamadas").append(html);
		}
	});

}



function FncCotizacionVehiculoLlamadaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapCotizacionVehiculoLlamadaAccion').html('Editando...');
	$('#CmpCotizacionVehiculoLlamadaAccion').val("AccCotizacionVehiculoLlamadaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoLlamadaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsCotizacionVehiculoLlamada){

		//SesionObjeto-InsCotizacionVehiculoLlamada
		//Parametro1 = GopId
		//Parametro2 = 
		//Parametro3 = GopFecha
		//Parametro4 = 
		//Parametro5 = GopObservacion
		//Parametro6 = GopEstado
		//Parametro7 = GopFechaCreacion
		//Parametro8 = GopFechaModificacion
		//Parametro9 = GopFechaProgramada

			$('#CmpCotizacionVehiculoLlamadaFecha').val(InsCotizacionVehiculoLlamada.Parametro3);
			$('#CmpCotizacionVehiculoLlamadaFechaProgramada').val(InsCotizacionVehiculoLlamada.Parametro9);
			$('#CmpCotizacionVehiculoLlamadaObservacion').val(InsCotizacionVehiculoLlamada.Parametro5);

			$('#CmpCotizacionVehiculoLlamadaItem').val(InsCotizacionVehiculoLlamada.Item);

			$('#CmpCotizacionVehiculoLlamadaFecha').select();

		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncCotizacionVehiculoLlamadaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapCotizacionVehiculoLlamadaAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoLlamadaEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapCotizacionVehiculoLlamadaAccion').html("Eliminado");	
				FncCotizacionVehiculoLlamadaListar();
			}
		});

		FncCotizacionVehiculoLlamadaNuevo();

	}
	
}

function FncCotizacionVehiculoLlamadaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapCotizacionVehiculoLlamadaAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/CotizacionVehiculo/acc/AccCotizacionVehiculoLlamadaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapCotizacionVehiculoLlamadaAccion').html('Eliminado');	
				FncCotizacionVehiculoLlamadaListar();
			}
		});	
			
		FncCotizacionVehiculoLlamadaNuevo();
	}
	
}





