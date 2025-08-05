// JavaScript Document

function FncVehiculoRecepcionDetalleNuevo(){
	
	$('#CmpVehiculoRecepcionDetalleId').val("");
	
	$('#CmpVehiculoRecepcionDetalleZonaComprometida').val("");
	$('#CmpVehiculoRecepcionDetalleRepuestoDetalle').val("");
	$('#CmpVehiculoRecepcionDetalleSolucion').val("");		
	$('#CmpVehiculoRecepcionDetalleObservacion').val("");	
	
	$('#CmpVehiculoRecepcionDetalleItem').val("");	
	
	$('#CapVehiculoRecepcionDetalleAccion').html('Listo para registrar elementos');	
			
	$('#CmpVehiculoRecepcionDetalleZonaComprometida').select();
			
	$('#CmpVehiculoRecepcionDetalleAccion').val("AccVehiculoRecepcionDetalleRegistrar.php");

	
/*
* POPUP REGISTRAR/EDITAR
*/

	
}

function FncVehiculoRecepcionDetalleGuardar(){

			var Identificador = $('#Identificador').val();
			
			var Acc = $('#CmpVehiculoRecepcionDetalleAccion').val();		
			
			var VehiculoRecepcionDetalleZonaComprometida = $('#CmpVehiculoRecepcionDetalleZonaComprometida').val();						
			var VehiculoRecepcionDetalleRepuestoDetalle = $('#CmpVehiculoRecepcionDetalleRepuestoDetalle').val();
			var VehiculoRecepcionDetalleSolucion = $('#CmpVehiculoRecepcionDetalleSolucion').val();
			var VehiculoRecepcionDetalleObservacion = $('#CmpVehiculoRecepcionDetalleObservacion').val();
			
			var Item = $('#CmpVehiculoRecepcionDetalleItem').val();
			
			if(VehiculoRecepcionDetalleZonaComprometida == ""){	
			
				$('#CmpVehiculoRecepcionDetalleZonaComprometida').select();	
					
			}else if(VehiculoRecepcionDetalleRepuestoDetalle==""){
				
				$('#CmpVehiculoRecepcionDetalleRepuestoDetalle').select();	
					
			}else{
				$('#CapVehiculoRecepcionDetalleAccion').html('Guardando...');
				
						$.ajax({
							type: 'POST',
							url: 'formularios/VehiculoRecepcion/acc/'+Acc,
							
							data: 'VehiculoRecepcionDetalleZonaComprometida='+VehiculoRecepcionDetalleZonaComprometida+
							'&VehiculoRecepcionDetalleRepuestoDetalle='+VehiculoRecepcionDetalleRepuestoDetalle+
							'&VehiculoRecepcionDetalleSolucion='+VehiculoRecepcionDetalleSolucion+
							'&VehiculoRecepcionDetalleObservacion='+VehiculoRecepcionDetalleObservacion+
							'&Identificador='+Identificador+'&Item='+Item,
							success: function(){
								
							$('#CapVehiculoRecepcionDetalleAccion').html('Listo');							
								FncVehiculoRecepcionDetalleListar();
							}
						});
						
						FncVehiculoRecepcionDetalleNuevo();	
					
					
			}
			
			
	
}


function FncVehiculoRecepcionDetalleListar(){

	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoRecepcionDetalleAccion').html('Cargando...');

	$.ajax({
		type: 'POST',
		url: 'formularios/VehiculoRecepcion/FrmVehiculoRecepcionDetalleListado.php',
		data: 'Editar='+VehiculoRecepcionDetalleEditar+
		'&Eliminar='+VehiculoRecepcionDetalleEliminar+		
		'&Identificador='+Identificador,
		success: function(html){
			
			$('#CapVehiculoRecepcionDetalleAccion').html('Listo');	
			$("#CapVehiculoRecepcionDetalles").html("");
			$("#CapVehiculoRecepcionDetalles").append(html);
			
			$('input[type=checkbox]').each(function () {
					
				if($(this).attr('etiqueta')=="detalle"){
					FncVehiculoRecepcionDetalleFotoListar($(this).val());	
				}		
						 
			});
				
		}
	});

}


function FncVehiculoRecepcionDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapVehiculoRecepcionDetalleAccion').html('Editando...');
	$('#CmpVehiculoRecepcionDetalleAccion').val("AccVehiculoRecepcionDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleEscoger.php',
		data: 'Item='+oItem+'&Identificador='+Identificador,
		success: function(InsVehiculoRecepcionDetalle){

//						SesionObjeto-VehiculoRecepcionDetalle
//						Parametro1 = VrdId
//						Parametro2 = VreId
//						Parametro3 = VrdZonaComprometida
//						Parametro4 = VrdRepuestoDetalle
//						Parametro5 = VrdSolucion
//						Parametro6 = VrdObservacion
//						Parametro7 = VrdTiempoCreacion
//						Parametro8 = VrdTiempoModificacion
//						Parametro9 = VrdEstado

				$('#CmpVehiculoRecepcionDetalleId').val(InsVehiculoRecepcionDetalle.Parametro1);

				$('#CmpVehiculoRecepcionDetalleZonaComprometida').val(InsVehiculoRecepcionDetalle.Parametro3);	
				$('#CmpVehiculoRecepcionDetalleRepuestoDetalle').val(InsVehiculoRecepcionDetalle.Parametro4);
				$('#CmpVehiculoRecepcionDetalleSolucion').val(InsVehiculoRecepcionDetalle.Parametro5);
				$('#CmpVehiculoRecepcionDetalleObservacion').val(InsVehiculoRecepcionDetalle.Parametro6);

				$('#CmpVehiculoRecepcionDetalleItem').val(InsVehiculoRecepcionDetalle.Item);
								
				$('#CmpVehiculoRecepcionDetalleZonaComprometida').select();
				
		}
	});
	
	
	
/*
* POPUP REGISTRAR/EDITAR
*/
	

}

function FncVehiculoRecepcionDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapVehiculoRecepcionDetalleAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapVehiculoRecepcionDetalleAccion').html("Eliminado");	
				FncVehiculoRecepcionDetalleListar();
			}
		});

		FncVehiculoRecepcionDetalleNuevo();

	}
	
}

function FncVehiculoRecepcionDetalleEliminarTodo(){
	
	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapVehiculoRecepcionDetalleAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/VehiculoRecepcion/acc/AccVehiculoRecepcionDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapVehiculoRecepcionDetalleAccion').html('Eliminado');	
				FncVehiculoRecepcionDetalleListar();
			}
		});	
			
		FncVehiculoRecepcionDetalleNuevo();
	}
	
}
