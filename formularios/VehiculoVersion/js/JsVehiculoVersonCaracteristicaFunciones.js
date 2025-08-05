// JavaScript Document

function FncVehiculoVersionCaracteristicaNuevo(){
	
	$('#CmpVehiculoVersionCaracteristicaId').val("");
	
	$('#CmpVehiculoVersionCaracteristicaDescripcion').val("");
	$('#CmpVehiculoVersionCaracteristicaValor').val("");

	$('#CmpVehiculoVersionCaracteristicaItem').val("");	
			
	$('#CapVehiculoVersionAccion').html('Listo para registrar elementos');	

	$('#CmpVehiculoVersionCaracteristicaDescripcion').select();
			
	$('#CmpVehiculoVersionCaracteristicaAccion').val("AccVehiculoVersionCaracteristicaRegistrar.php");

	//$('#CmpVehiculoVersionCaracteristicaDescripcion').removeAttr('readonly');

	
/*
* POPUP REGISTRAR/EDITAR
*/
	//$("#BtnVehiculoVersionCaracteristicaEditar").hide();
	//$("#BtnVehiculoVersionCaracteristicaRegistrar").show();
	
}

function FncVehiculoVersionCaracteristicaGuardar(){

	var Identificador = $('#Identificador').val();
	
	var Acc = $('#CmpVehiculoVersionCaracteristicaAccion').val();		
	
	var VehiculoVersionCaracteristicaDescripcion = $('#CmpVehiculoVersionCaracteristicaDescripcion').val();
	var VehiculoVersionCaracteristicaValor = $('#CmpVehiculoVersionCaracteristicaValor').val();
	var VehiculoVersionCaracteristicaAno = $('#CmpVehiculoVersionCaracteristicaAno').val();
	var VehiculoCaracteristicaSeccion = $('#CmpVehiculoCaracteristicaSeccion').val();
	
	var Item = $('#CmpVehiculoVersionCaracteristicaItem').val();
	
	if(VehiculoVersionCaracteristicaDescripcion==""){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una descripcion",
					callback: function(result){
						$('#CmpVehiculoVersionCaracteristicaDescripcion').focus();	
					}
				});
				
	}else if(VehiculoVersionCaracteristicaValor==""){
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un contenido",
					callback: function(result){
						$('#CmpVehiculoVersionCaracteristicaValor').focus();	
					}
				});
				
		
	}else if(VehiculoVersionCaracteristicaAno==""){
		
		dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un año",
					callback: function(result){
						$('#CmpVehiculoVersionCaracteristicaAno').focus();	
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
		$('#CapVehiculoVersionAccion').html('Guardando...');
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/'+Acc,
			data: 'Identificador='+Identificador+
			'&VehiculoVersionCaracteristicaDescripcion='+VehiculoVersionCaracteristicaDescripcion+
			'&VehiculoVersionCaracteristicaValor='+VehiculoVersionCaracteristicaValor+
			
			'&Item='+Item,
			success: function(){
				
			$('#CapVehiculoVersionAccion').html('Listo');							
				FncVehiculoVersionCaracteristicaListar();
			}
		});
				
		FncVehiculoVersionCaracteristicaNuevo();	
			
	}
	
}

function FncVehiculoVersionCaracteristicaListar(){

//console.log("FncVehiculoVersionCaracteristicaListar");
	var Identificador = $('#Identificador').val();

	var VehiculoVersionCaracteristicaAno = $('#CmpVehiculoVersionCaracteristicaAno').val();
	var VehiculoCaracteristicaSeccion = $('#CmpVehiculoCaracteristicaSeccion').val();
	
	$('#CapVehiculoVersionAccion').html('Cargando...');

	$('#CapVehiculoVersionCaracteristicas').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoVersion/FrmVehiculoVersionCaracteristicaListado.php',
		data: 'Identificador='+Identificador+
		'&VehiculoVersionCaracteristicaAno='+VehiculoVersionCaracteristicaAno+
		'&VehiculoCaracteristicaSeccion='+VehiculoCaracteristicaSeccion+
		
		'&Editar='+VehiculoVersionCaracteristicaEditar+
		'&Eliminar='+VehiculoVersionCaracteristicaEliminar ,
		success: function(html){
			
			$('#CapVehiculoVersionAccion').html('Listo');	
			$("#CapVehiculoVersionCaracteristicas").html("");
			$("#CapVehiculoVersionCaracteristicas").append(html);
				
		}
	});
	
}

function FncVehiculoVersionCaracteristicaEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoVersionAccion').html('Editando...');
	
	$('#CmpVehiculoVersionCaracteristicaAccion').val("AccVehiculoVersionCaracteristicaEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionCaracteristicaEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		
		success: function(InsVehiculoVersionCaracteristica){

		//	SesionObjeto-VehiculoVersionCaracteristica
		//	Parametro1 = VvcId
		//	Parametro2 = VveId
		//	Parametro3 = VcsId
		//	Parametro4 = VvcDescripcion
		//	Parametro5 = VvcValor
		//	Parametro6 = VvcAnoModelo
		//	Parametro7 = VvcTiempoCreacion
		//	Parametro8 = VvcTiempoModificacion
			
			$('#CmpVehiculoCaracteristicaSeccion').val(InsVehiculoVersionCaracteristica.Parametro3);
			$('#CmpVehiculoVersionCaracteristicaDescripcion').val(InsVehiculoVersionCaracteristica.Parametro4);
			$('#CmpVehiculoVersionCaracteristicaValor').val(InsVehiculoVersionCaracteristica.Parametro5);
			$('#CmpVehiculoVersionCaracteristicaAnoModelo').val(InsVehiculoVersionCaracteristica.Parametro6);
			
			$('#CmpVehiculoVersionCaracteristicaItem').val(InsVehiculoVersionCaracteristica.Item);

			$('#CmpVehiculoVersionCaracteristicaDescripcion').select();
			
		}
	});

	//$('#CmpVehiculoVersionCaracteristicaId').attr('readonly', true);
	//$('#CmpVehiculoVersionCaracteristicaDescripcion').attr('readonly', true);

	
/*
* POPUP REGISTRAR/EDITAR
*/
	$("#BtnVehiculoVersionCaracteristicaEditar").show();
	$("#BtnVehiculoVersionCaracteristicaRegistrar").hide();
	
}

function FncVehiculoVersionCaracteristicaEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoVersionAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionCaracteristicaEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapVehiculoVersionAccion').html("Eliminado");	
				FncVehiculoVersionCaracteristicaListar();
			}
		});

		FncVehiculoVersionCaracteristicaNuevo("");	

	}
	
}


function FncVehiculoVersionCaracteristicaEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoVersionAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoVersion/acc/AccVehiculoVersionCaracteristicaEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoVersionAccion').html('Eliminado');	
				FncVehiculoVersionCaracteristicaListar();
			}
		});	
			
		FncVehiculoVersionCaracteristicaNuevo("");	
	}
	
}
