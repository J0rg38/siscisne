// JavaScript Document

function FncVehiculoModeloCaracteristicaNuevo(){
	
	$('#CmpVehiculoModeloCaracteristicaId').val("");
	
	$('#CmpVehiculoModeloCaracteristicaAnoModelo').val("");
	$('#CmpVehiculoCaracteristicaSeccion').val("");
	$('#CmpVehiculoModeloCaracteristicaDescripcion').val("");
	$('#CmpVehiculoModeloCaracteristicaValor').val("");

	$('#CmpVehiculoModeloCaracteristicaItem').val("");	
			
	$('#CapVehiculoModeloAccion').html('Listo para registrar elementos');	

	$('#CmpVehiculoModeloCaracteristicaDescripcion').select();
			
	$('#CmpVehiculoModeloCaracteristicaAccion').val("AccVehiculoModeloCaracteristicaRegistrar.php");

	//$('#CmpVehiculoModeloCaracteristicaDescripcion').removeAttr('readonly');

	
/*
* POPUP REGISTRAR/EDITAR
*/
	//$("#BtnVehiculoModeloCaracteristicaEditar").hide();
	//$("#BtnVehiculoModeloCaracteristicaRegistrar").show();
	
}

function FncVehiculoModeloCaracteristicaGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpVehiculoModeloCaracteristicaAccion').val();		
	
	var VehiculoModeloCaracteristicaDescripcion = $('#CmpVehiculoModeloCaracteristicaDescripcion').val();
	var VehiculoModeloCaracteristicaValor = $('#CmpVehiculoModeloCaracteristicaValor').val();
	var VehiculoModeloCaracteristicaAnoModelo = $('#CmpVehiculoModeloCaracteristicaAnoModelo').val();
	var VehiculoCaracteristicaSeccion = $('#CmpVehiculoCaracteristicaSeccion').val();
	
	var Item = $('#CmpVehiculoModeloCaracteristicaItem').val();
	
	if(VehiculoModeloCaracteristicaDescripcion==""){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una descripcion",
					callback: function(result){
						$('#CmpVehiculoModeloCaracteristicaDescripcion').focus();	
					}
				});
				
	}else if(VehiculoModeloCaracteristicaValor==""){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un contenido",
					callback: function(result){
						$('#CmpVehiculoModeloCaracteristicaValor').focus();	
					}
				});
				
		
	}else if(VehiculoModeloCaracteristicaAnoModelo==""){
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un año",
					callback: function(result){
						$('#CmpVehiculoModeloCaracteristicaAnoModelo').focus();	
					}
				});
		
	}else if(VehiculoCaracteristicaSeccion==""){
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una seccion",
					callback: function(result){
						$('#CmpVehiculoCaracteristicaSeccion').focus();	
					}
				});
				
			
	}else{
		$('#CapVehiculoModeloAccion').html('Guardando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoModelo/acc/'+Acc,
			data: 'Identificador='+Identificador+
				'&VehiculoModeloCaracteristicaAnoModelo='+VehiculoModeloCaracteristicaAnoModelo+
			'&VehiculoCaracteristicaSeccion='+VehiculoCaracteristicaSeccion+
			'&VehiculoModeloCaracteristicaDescripcion='+VehiculoModeloCaracteristicaDescripcion+
			'&VehiculoModeloCaracteristicaValor='+VehiculoModeloCaracteristicaValor+
			
			'&Item='+Item,
			success: function(){
				
			$('#CapVehiculoModeloAccion').html('Listo');							
				FncVehiculoModeloCaracteristicaListar();
			}
		});
				
		FncVehiculoModeloCaracteristicaNuevo();	
			
	}
	
}

function FncVehiculoModeloCaracteristicaListar(){

//console.log("FncVehiculoModeloCaracteristicaListar");
	var Identificador = $('#Identificador').val();

	var VehiculoModeloCaracteristicaAnoModelo = $('#CmpVehiculoModeloCaracteristicaAnoModelo').val();
	var VehiculoCaracteristicaSeccion = $('#CmpVehiculoCaracteristicaSeccion').val();
	var AnoModelo = $('#CmpAnoModelo').val();
	
	$('#CapVehiculoModeloAccion').html('Cargando...');

	$('#CapVehiculoModeloCaracteristicas').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoModelo/FrmVehiculoModeloCaracteristicaListado.php',
		data: 'Identificador='+Identificador+
		'&VehiculoModeloCaracteristicaAnoModelo='+VehiculoModeloCaracteristicaAnoModelo+
		'&VehiculoCaracteristicaSeccion='+VehiculoCaracteristicaSeccion+
		'&AnoModelo='+AnoModelo+
		
		'&Editar='+VehiculoModeloCaracteristicaEditar+
		'&Eliminar='+VehiculoModeloCaracteristicaEliminar ,
		success: function(html){
			
			$('#CapVehiculoModeloAccion').html('Listo');	
			$("#CapVehiculoModeloCaracteristicas").html("");
			$("#CapVehiculoModeloCaracteristicas").append(html);
				
		}
	});
	
}

function FncVehiculoModeloCaracteristicaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoModeloAccion').html('Editando...');
	
	$('#CmpVehiculoModeloCaracteristicaAccion').val("AccVehiculoModeloCaracteristicaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoModelo/acc/AccVehiculoModeloCaracteristicaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		
		success: function(InsVehiculoModeloCaracteristica){

//	SesionObjeto-VehiculoModeloCaracteristica
//	Parametro1 = VvcId
//	Parametro2 = VmoId
//	Parametro3 = VcsId

//	Parametro4 = VvcDescripcion
//	Parametro5 = VvcValor
//	Parametro6 = VvcAnoModelo
//	Parametro7 = VvcTiempoCreacion
//	Parametro8 = VvcTiempoModificacion
//	Parametro9 = VcsNombre
			
		
			$('#CmpVehiculoModeloCaracteristicaDescripcion').val(InsVehiculoModeloCaracteristica.Parametro4);
			$('#CmpVehiculoModeloCaracteristicaValor').val(InsVehiculoModeloCaracteristica.Parametro5);
			$('#CmpVehiculoModeloCaracteristicaAnoModelo').val(InsVehiculoModeloCaracteristica.Parametro6);
			$('#CmpVehiculoCaracteristicaSeccion').val(InsVehiculoModeloCaracteristica.Parametro3);
			
			$('#CmpVehiculoModeloCaracteristicaItem').val(InsVehiculoModeloCaracteristica.Item);

			$('#CmpVehiculoModeloCaracteristicaDescripcion').select();
			
		}
	});

	//$('#CmpVehiculoModeloCaracteristicaId').attr('readonly', true);
	//$('#CmpVehiculoModeloCaracteristicaDescripcion').attr('readonly', true);

	
/*
* POPUP REGISTRAR/EDITAR
*/
	//$("#BtnVehiculoModeloCaracteristicaEditar").show();
	//$("#BtnVehiculoModeloCaracteristicaRegistrar").hide();
	
}

function FncVehiculoModeloCaracteristicaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoModeloAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoModelo/acc/AccVehiculoModeloCaracteristicaEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoModeloAccion').html("Eliminado");	
				FncVehiculoModeloCaracteristicaListar();
			}
		});

		FncVehiculoModeloCaracteristicaNuevo("");	

	}
	
}


function FncVehiculoModeloCaracteristicaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoModeloAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoModelo/acc/AccVehiculoModeloCaracteristicaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoModeloAccion').html('Eliminado');	
				FncVehiculoModeloCaracteristicaListar();
			}
		});	
			
		FncVehiculoModeloCaracteristicaNuevo("");	
	}
	
}
