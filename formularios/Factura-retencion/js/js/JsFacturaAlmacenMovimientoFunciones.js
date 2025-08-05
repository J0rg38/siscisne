// JavaScript Document

function FncFacturaAlmacenMovimientoNuevo(){

	$('#CmpFacturaAlmacenMovimientoItem').val("");
	$('#CmpFacturaAlmacenMovimientoId').val("");
	$('#CmpAlmacenMovimientoId').val("");
	
	$('#CmpAlmacenMovimiento').val("");
	
	$('#CmpFacturaAlmacenMovimientoAccion').val("AccFacturaAlmacenMovimientoRegistrar.php");

	$('#CapFacturaAlmacenMovimientoAccion').html("Listo para registrar elementos");
	
	
	$('#CmpAlmacenMovimiento').removeAttr('readonly');
}

function FncFacturaAlmacenMovimientoGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var AlmacenMovimientoId = $('#CmpAlmacenMovimientoId').val();
	var FacturaAlmacenMovimientoId = $('#CmpFacturaAlmacenMovimientoId').val();
	
	var Item = $('#CmpFacturaAlmacenMovimientoItem').val();
	var Acc = $('#CmpFacturaAlmacenMovimientoAccion').val();
	
	if(AlmacenMovimientoId==""){
		$('#CmpAlmacenMovimientoId').select();	
	}else{

		$('#CapFacturaAlmacenMovimientoAccion').html('Guardando...');
						
			$.ajax({
				type: 'POST',
				url: 'formularios/Factura/acc/'+Acc,
				data: 'Identificador='+Identificador
				+'&AlmacenMovimientoId='+escape(AlmacenMovimientoId)
				+'&FacturaAlmacenMovimientoId='+(FacturaAlmacenMovimientoId)
				+'&Item='+Item,
				success: function(){
					$('#CapFacturaAlmacenMovimientoAccion').html('Listo');							
					FncFacturaAlmacenMovimientoListar();
				}
			});

			FncFacturaAlmacenMovimientoNuevo();
	}		
}


function FncFacturaAlmacenMovimientoListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapFacturaAlmacenMovimientoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/Factura/FrmFacturaAlmacenMovimientoListado.php',
		//data: 'Identificador='+Identificador+'&Editar='+FacturaAlmacenMovimientoEditar+'&Eliminar='+FacturaAlmacenMovimientoEliminar,
		data: 'Identificador='+Identificador+'&Editar=&Eliminar='+FacturaAlmacenMovimientoEliminar,
		success: function(html){
			$('#CapFacturaAlmacenMovimientoAccion').html('Listo');	
			$("#CapFacturaAlmacenMovimientos").html("");
			$("#CapFacturaAlmacenMovimientos").append(html);
		}
	});
	
}


function FncFacturaAlmacenMovimientoEscoger(oItem){
	
	//SesionObjeto-FacturaAlmacenMovimiento
	//Parametro1 = FamId
	//Parametro2 = AmoId
	//Parametro3 = 
	//Parametro4 = 
	//Parametro5 = FamEstado
	//Parametro6 = FamTiempoCreacion
	//Parametro7 = FamTiempoModificacion

	var Identificador = $('#Identificador').val();

	$('#CapFacturaAlmacenMovimientoAccion').html('Editando...');
	$('#CmpFacturaAlmacenMovimientoAccion').val("AccFacturaAlmacenMovimientoEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Factura/acc/AccFacturaAlmacenMovimientoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsFacturaAlmacenMovimiento){
			
			$('#CmpAlmacenMovimiento').val(InsFacturaAlmacenMovimiento.Parametro2);
			$('#CmpAlmacenMovimientoId').val(InsFacturaAlmacenMovimiento.Parametro2);
			$('#CmpFacturaAlmacenMovimientoId').val(InsFacturaAlmacenMovimiento.Parametro1);
			
			$('#CmpFacturaAlmacenMovimientoItem').val(InsFacturaAlmacenMovimiento.Item);
			
			$('#CmpAlmacenMovimiento').select();
			$('#CmpAlmacenMovimiento').attr('readonly', true);
			
		}
	});
	
}



function FncFacturaAlmacenMovimientoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFacturaAlmacenMovimientoAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/Factura/acc/AccFacturaAlmacenMovimientoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapFacturaAlmacenMovimientoAccion').html("Eliminado");	
				FncFacturaAlmacenMovimientoListar();
			}
		});

		FncFacturaAlmacenMovimientoNuevo();
		
	}

}

function FncFacturaAlmacenMovimientoEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapFacturaAlmacenMovimientoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Factura/acc/AccFacturaAlmacenMovimientoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFacturaAlmacenMovimientoAccion').html('Eliminado');	
				FncFacturaAlmacenMovimientoListar();
			}
		});	
		
		FncFacturaAlmacenMovimientoNuevo();
	}
	
}