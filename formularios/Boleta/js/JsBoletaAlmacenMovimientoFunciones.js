// JavaScript Document

function FncBoletaAlmacenMovimientoNuevo(){

	$('#CmpBoletaAlmacenMovimientoItem').val("");
	$('#CmpBoletaAlmacenMovimientoId').val("");
	
	$('#CmpAlmacenMovimientoId').val("");
	$('#CmpVehiculoMovimientoId').val("");
	
	$('#CmpAlmacenMovimiento').val("");
	$('#CmpVehiculoMovimiento').val("");
	
	$('#CmpBoletaAlmacenMovimientoAccion').val("AccBoletaAlmacenMovimientoRegistrar.php");

	$('#CapBoletaAlmacenMovimientoAccion').html("Listo para registrar elementos");
	
	
	$('#CmpAlmacenMovimiento').removeAttr('readonly');
}

function FncBoletaAlmacenMovimientoGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var AlmacenMovimientoId = $('#CmpAlmacenMovimientoId').val();
	var VehiculoMovimientoId = $('#CmpVehiculoMovimientoId').val();
	
	var BoletaAlmacenMovimientoId = $('#CmpBoletaAlmacenMovimientoId').val();
	
	var Item = $('#CmpBoletaAlmacenMovimientoItem').val();
	var Acc = $('#CmpBoletaAlmacenMovimientoAccion').val();
	
	if(AlmacenMovimientoId==""){
		$('#CmpAlmacenMovimientoId').select();	
	}else{

		$('#CapBoletaAlmacenMovimientoAccion').html('Guardando...');
						
			$.ajax({
				type: 'POST',
				url: 'formularios/Boleta/acc/'+Acc,
				data: 'Identificador='+Identificador
				+'&AlmacenMovimientoId='+(AlmacenMovimientoId)
				+'&VehiculoMovimientoId='+(VehiculoMovimientoId)
				+'&BoletaAlmacenMovimientoId='+(BoletaAlmacenMovimientoId)
				+'&Item='+Item,
				success: function(){
					$('#CapBoletaAlmacenMovimientoAccion').html('Listo');							
					FncBoletaAlmacenMovimientoListar();
				}
			});

			FncBoletaAlmacenMovimientoNuevo();
	}		
}


function FncBoletaAlmacenMovimientoListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapBoletaAlmacenMovimientoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/Boleta/FrmBoletaAlmacenMovimientoListado.php',
		//data: 'Identificador='+Identificador+'&Editar='+BoletaAlmacenMovimientoEditar+'&Eliminar='+BoletaAlmacenMovimientoEliminar,
		data: 'Identificador='+Identificador+'&Editar=&Eliminar='+BoletaAlmacenMovimientoEliminar,
		success: function(html){
			$('#CapBoletaAlmacenMovimientoAccion').html('Listo');	
			$("#CapBoletaAlmacenMovimientos").html("");
			$("#CapBoletaAlmacenMovimientos").append(html);
		}
	});
	
}


function FncBoletaAlmacenMovimientoEscoger(oItem){
	
	
//SesionObjeto-BoletaAlmacenMovimiento
//Parametro1 = BamId
//Parametro2 = AmoId
//Parametro3 = 
//Parametro4 = 
//Parametro5 = BamEstado
//Parametro6 = BamTiempoCreacion
//Parametro7 = BamTiempoModificacion
//Parametro8 = FinId
//Parametro9 = FccId
//Parametro10 = AmoFecha
//Parametro11 = AmoSubTipo
//Parametro12 = VmvId
//Parametro13 = VmvFecha
//Parametro14 = VmvSubTipo

	var Identificador = $('#Identificador').val();

	$('#CapBoletaAlmacenMovimientoAccion').html('Editando...');
	$('#CmpBoletaAlmacenMovimientoAccion').val("AccBoletaAlmacenMovimientoEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Boleta/acc/AccBoletaAlmacenMovimientoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsBoletaAlmacenMovimiento){
			
			$('#CmpAlmacenMovimiento').val(InsBoletaAlmacenMovimiento.Parametro2);
			$('#CmpAlmacenMovimientoId').val(InsBoletaAlmacenMovimiento.Parametro2);
			
			$('#CmpVehiculoMovimiento').val(InsBoletaAlmacenMovimiento.Parametro12);
			$('#CmpVehiculoMovimientoId').val(InsBoletaAlmacenMovimiento.Parametro12);
			
			$('#CmpBoletaAlmacenMovimientoId').val(InsBoletaAlmacenMovimiento.Parametro1);
			
			$('#CmpBoletaAlmacenMovimientoItem').val(InsBoletaAlmacenMovimiento.Item);
			
			$('#CmpAlmacenMovimiento').select();
			$('#CmpAlmacenMovimiento').attr('readonly', true);
			
		}
	});
	
}



function FncBoletaAlmacenMovimientoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapBoletaAlmacenMovimientoAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/Boleta/acc/AccBoletaAlmacenMovimientoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapBoletaAlmacenMovimientoAccion').html("Eliminado");	
				FncBoletaAlmacenMovimientoListar();
			}
		});

		FncBoletaAlmacenMovimientoNuevo();
		
	}

}

function FncBoletaAlmacenMovimientoEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapBoletaAlmacenMovimientoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Boleta/acc/AccBoletaAlmacenMovimientoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapBoletaAlmacenMovimientoAccion').html('Eliminado');	
				FncBoletaAlmacenMovimientoListar();
			}
		});	
		
		FncBoletaAlmacenMovimientoNuevo();
	}
	
}