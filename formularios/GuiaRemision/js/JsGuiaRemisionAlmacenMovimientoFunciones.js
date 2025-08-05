// JavaScript Document

function FncGuiaRemisionAlmacenMovimientoNuevo(){

	$('#CmpGuiaRemisionAlmacenMovimientoItem').val("");
	$('#CmpGuiaRemisionAlmacenMovimientoId').val("");
	
	$('#CmpAlmacenMovimientoId').val("");
	$('#CmpVehiculoMovimientoId').val("");
	
	$('#CmpAlmacenMovimientoSubTipo').val("");
	$('#CmpVehiculoMovimientoSubTipo').val("");
	
	$('#CmpAlmacenMovimientoFecha').val("");
	$('#CmpVehiculoMovimientoFecha').val("");
	
	$('#CmpAlmacenMovimiento').val("");
	$('#CmpVehiculoMovimiento').val("");
	
	$('#CmpGuiaRemisionAlmacenMovimientoAccion').val("AccGuiaRemisionAlmacenMovimientoRegistrar.php");

	$('#CapGuiaRemisionAlmacenMovimientoAccion').html("Listo para registrar elementos");
	
	
	$('#CmpAlmacenMovimiento').removeAttr('readonly');
}

function FncGuiaRemisionAlmacenMovimientoGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var AlmacenMovimientoId = $('#CmpAlmacenMovimientoId').val();
	var VehiculoMovimientoId = $('#CmpVehiculoMovimientoId').val();
	
	var GuiaRemisionAlmacenMovimientoId = $('#CmpGuiaRemisionAlmacenMovimientoId').val();
	
	var Item = $('#CmpGuiaRemisionAlmacenMovimientoItem').val();
	var Acc = $('#CmpGuiaRemisionAlmacenMovimientoAccion').val();

	var SubTipo = $('#CmpGuiaRemisionAlmacenMovimientoSubTipo').val();
	
	var AlmacenMovimientoSubTipo = $('#CmpAlmacenMovimientoSubTipo').val();
	var VehiculoMovimientoSubTipo = $('#CmpVehiculoMovimientoSubTipo').val();

	var AlmacenMovimientoFecha = $('#CmpAlmacenMovimientoFecha').val();
	var VehiculoMovimientoFecha = $('#CmpVehiculoMovimientoFecha').val();
	
	
	if(AlmacenMovimientoId=="" || VehiculoMovimientoId ==""){
		
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un codigo de movimiento",
					callback: function(result){
						if(AlmacenMovimientoId==""){
							$('#CmpAlmacenMovimiento').focus();	
						}else{
							$('#CmpVehiculoMovimiento').focus();	
						}
					}
				});
		
		
		
	}else{

		$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Guardando...');
						
			$.ajax({
				type: 'POST',
				url: 'formularios/GuiaRemision/acc/'+Acc,
				data: 'Identificador='+Identificador
				
				+'&AlmacenMovimientoId='+escape(AlmacenMovimientoId)
				+'&VehiculoMovimientoId='+escape(VehiculoMovimientoId)
				
				+'&AlmacenMovimientoSubTipo='+(AlmacenMovimientoSubTipo)
				+'&VehiculoMovimientoSubTipo='+(VehiculoMovimientoSubTipo)
				
				+'&AlmacenMovimientoFecha='+(AlmacenMovimientoFecha)
				+'&VehiculoMovimientoFecha='+(VehiculoMovimientoFecha)
				
				+'&GuiaRemisionAlmacenMovimientoId='+(GuiaRemisionAlmacenMovimientoId)
				+'&Item='+Item,
				success: function(){
					$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Listo');							
					FncGuiaRemisionAlmacenMovimientoListar();
				}
			});

			FncGuiaRemisionAlmacenMovimientoNuevo();
	}		
}


function FncGuiaRemisionAlmacenMovimientoListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/GuiaRemision/FrmGuiaRemisionAlmacenMovimientoListado.php',
		//data: 'Identificador='+Identificador+'&Editar='+GuiaRemisionAlmacenMovimientoEditar+'&Eliminar='+GuiaRemisionAlmacenMovimientoEliminar,
		data: 'Identificador='+Identificador+'&Editar=&Eliminar='+GuiaRemisionAlmacenMovimientoEliminar,
		success: function(html){
			$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Listo');	
			$("#CapGuiaRemisionAlmacenMovimientos").html("");
			$("#CapGuiaRemisionAlmacenMovimientos").append(html);
		}
	});
	
}


function FncGuiaRemisionAlmacenMovimientoEscoger(oItem){
	


	//SesionObjeto-GuiaRemisionAlmacenMovimiento
	//Parametro1 = GamId
	//Parametro2 = 
	//Parametro3 = 
	//Parametro4 = AmoId
	//Parametro5 = GamEstado
	//Parametro6 = GamTiempoCreacion
	//Parametro7 = GamTiempoModificacion
	//Parametro8 = VmvId
	//Parametro9 = VmvFecha
	//Parametro10 = AmoFecha
	//Parametro11 = AmoSubTipo
	//Parametro12 = VmvSubTipo

	var Identificador = $('#Identificador').val();

	$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Editando...');
	$('#CmpGuiaRemisionAlmacenMovimientoAccion').val("AccGuiaRemisionAlmacenMovimientoEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/GuiaRemision/acc/AccGuiaRemisionAlmacenMovimientoEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsGuiaRemisionAlmacenMovimiento){
			
			$('#CmpGuiaRemisionAlmacenMovimientoId').val(InsGuiaRemisionAlmacenMovimiento.Parametro1);
			
			$('#CmpAlmacenMovimiento').val(InsGuiaRemisionAlmacenMovimiento.Parametro4);
			$('#CmpAlmacenMovimientoId').val(InsGuiaRemisionAlmacenMovimiento.Parametro4);
			
			$('#CmpVehiculoMovimiento').val(InsGuiaRemisionAlmacenMovimiento.Parametro8);
			$('#CmpVehiculoMovimientoId').val(InsGuiaRemisionAlmacenMovimiento.Parametro8);
			
			$('#CmpAlmacenMovimientoSubTipo').val(InsGuiaRemisionAlmacenMovimiento.Parametro11);
			$('#CmpVehiculoMovimientoSubTipo').val(InsGuiaRemisionAlmacenMovimiento.Parametro12);
			
			$('#CmpAlmacenMovimientoFecha').val(InsGuiaRemisionAlmacenMovimiento.Parametro10);
			$('#CmpVehiculoMovimientoFecha').val(InsGuiaRemisionAlmacenMovimiento.Parametro9);
			
			$('#CmpGuiaRemisionAlmacenMovimientoItem').val(InsGuiaRemisionAlmacenMovimiento.Item);
			
			if(InsGuiaRemisionAlmacenMovimiento.Parametro4!="" && InsGuiaRemisionAlmacenMovimiento.Parametro4!=null){			
				$('#CmpAlmacenMovimiento').select();
				$('#CmpAlmacenMovimiento').attr('readonly', true);
				
			}else{
				$('#CmpVehiculoMovimiento').select();
				$('#CmpVehiculoMovimiento').attr('readonly', true);
			}
			
			
		}
	});
	
}



function FncGuiaRemisionAlmacenMovimientoEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/GuiaRemision/acc/AccGuiaRemisionAlmacenMovimientoEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapGuiaRemisionAlmacenMovimientoAccion').html("Eliminado");	
				FncGuiaRemisionAlmacenMovimientoListar();
			}
		});

		FncGuiaRemisionAlmacenMovimientoNuevo();
		
	}

}

function FncGuiaRemisionAlmacenMovimientoEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/GuiaRemision/acc/AccGuiaRemisionAlmacenMovimientoEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapGuiaRemisionAlmacenMovimientoAccion').html('Eliminado');	
				FncGuiaRemisionAlmacenMovimientoListar();
			}
		});	
		
		FncGuiaRemisionAlmacenMovimientoNuevo();
	}
	
}