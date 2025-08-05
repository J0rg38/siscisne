// JavaScript Document

function FncFacturaExportacionAlmacenMovimientoNuevo(){

	$('#CmpFacturaExportacionAlmacenMovimientoItem').val("");
	$('#CmpFacturaExportacionAlmacenMovimientoAccion').val("AccFacturaExportacionAlmacenMovimientoRegistrar.php");

	$('#CapFacturaExportacionAlmacenMovimientoAccion').html("Listo para registrar elementos");
}

function FncFacturaExportacionAlmacenMovimientoGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var AlmacenMovimientoId = $('#CmpAlmacenMovimientoId').val();

	var Item = $('#CmpFacturaExportacionAlmacenMovimientoItem').val();
	var Acc = $('#CmpFacturaExportacionAlmacenMovimientoAccion').val();
	
	if(AlmacenMovimientoId==""){
		$('#CmpAlmacenMovimientoId').select();	
	}else{

		$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Guardando...');
						
			$.ajax({
				type: 'POST',
				url: 'formularios/FacturaExportacion/acc/'+Acc,
				data: 'Identificador='+Identificador+'&AlmacenMovimientoId='+escape(AlmacenMovimientoId)+'&Item='+Item,
				success: function(){
					$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Listo');							
					FncFacturaExportacionAlmacenMovimientoListar();
				}
			});

			FncFacturaExportacionAlmacenMovimientoNuevo();
	}		
}


function FncFacturaExportacionAlmacenMovimientoListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/FacturaExportacion/FrmFacturaExportacionAlmacenMovimientoListado.php',
		//data: 'Identificador='+Identificador+'&Editar='+FacturaExportacionAlmacenMovimientoEditar+'&Eliminar='+FacturaExportacionAlmacenMovimientoEliminar,
		data: 'Identificador='+Identificador+'&Editar=2&Eliminar=2',
		success: function(html){
			$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Listo');	
			$("#CapFacturaExportacionAlmacenMovimientos").html("");
			$("#CapFacturaExportacionAlmacenMovimientos").append(html);
		}
	});
	
}


function FncFacturaExportacionAlmacenMovimientoEscoger(oItem){
	
	//SesionObjeto-FacturaExportacionAlmacenMovimiento
	//Parametro1 = FeaId
	//Parametro2 = AmoId
	//Parametro3 = 
	//Parametro4 = 
	//Parametro5 = FeaEstado
	//Parametro6 = FeaTiempoCreacion
	//Parametro7 = FeaTiempoModificacion

	var Identificador = $('#Identificador').val();

	$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Editando...');
	$('#CmpFacturaExportacionAlmacenMovimientoAccion').val("AccFacturaExportacionAlmacenMovimientoEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/FacturaExportacion/acc/AccFacturaExportacionAlmacenMovimientoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsFacturaExportacionAlmacenMovimiento){
			
			$('#CmpAlmacenMovimientoId').val(InsFacturaExportacionAlmacenMovimiento.Parametro2);
			$('#CmpFacturaExportacionAlmacenMovimientoItem').val(InsFacturaExportacionAlmacenMovimiento.Item);
			$('#CmpAlmacenMovimientoId').select();
			
		}
	});
	
}



function FncFacturaExportacionAlmacenMovimientoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/FacturaExportacion/acc/AccFacturaExportacionAlmacenMovimientoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapFacturaExportacionAlmacenMovimientoAccion').html("Eliminado");	
				FncFacturaExportacionAlmacenMovimientoListar();
			}
		});

		FncFacturaExportacionAlmacenMovimientoNuevo();
		
	}

}

function FncFacturaExportacionAlmacenMovimientoEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/FacturaExportacion/acc/AccFacturaExportacionAlmacenMovimientoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapFacturaExportacionAlmacenMovimientoAccion').html('Eliminado');	
				FncFacturaExportacionAlmacenMovimientoListar();
			}
		});	
		
		FncFacturaExportacionAlmacenMovimientoNuevo();
	}
	
}