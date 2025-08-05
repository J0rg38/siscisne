// JavaScript Document

function FncReclamoDetalleNuevo(){
	
	$('#CmpReclamoDetalleId').val("");

			
	$('#CmpReclamoDetalleCodigo').val("");
	$('#CmpReclamoDetalleDescripcion').val("");
	$('#CmpReclamoDetalleCantidad').val("");
	
	$('#CmpReclamoDetallePrecioUnitario').val("");
	$('#CmpReclamoDetalleImporte').val("");
	
	$('#CmpReclamoDetalleObservacion').val("");
	$('#CmpReclamoDetalleItem').val("");	

	$('#CapReclamoDetalleAccion').html('Listo para registrar elementos');	
			
	$('#CmpReclamoDetalleCodigo').select();
			
	$('#CmpReclamoDetalleAccion').val("AccReclamoDetalleRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncReclamoDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpReclamoDetalleAccion').val();		
	
			var ReclamoDetalleId = $('#CmpReclamoDetalleId').val();
			var ReclamoDetalleCodigo = $('#CmpReclamoDetalleCodigo').val();			
			var ReclamoDetalleDescripcion = $('#CmpReclamoDetalleDescripcion').val();
			var ReclamoDetalleCantidad = $('#CmpReclamoDetalleCantidad').val();
			var ReclamoDetallePrecioUnitario = $('#CmpReclamoDetallePrecioUnitario').val();
			var ReclamoDetalleImporte = $('#CmpReclamoDetalleImporte').val();
			var ReclamoDetalleObservacion = $('#CmpReclamoDetalleObservacion').val();

			var Item = $('#CmpReclamoDetalleItem').val();

			if(ReclamoDetalleCodigo==""){
				$('#CmpReclamoDetalleCodigo').select();	
			}else if(ReclamoDetalleDescripcion==""){
				$('#CmpReclamoDetalleDescripcion').select();
			}else if(ReclamoDetalleCantidad=="" || ReclamoDetalleCantidad <=0){
				$('#CmparantiaDetalleCantidad').select();	
			}else{
				$('#CapReclamoDetalleAccion').html('Guardando...');

						$.ajax({
							type: 'POST',
							url: 'formularios/Reclamo/acc/'+Acc,
							data: 'Identificador='+Identificador+'&ReclamoDetalleId='+ReclamoDetalleId+'&ReclamoDetalleCodigo='+ReclamoDetalleCodigo+'&ReclamoDetalleDescripcion='+ReclamoDetalleDescripcion+'&ReclamoDetalleCantidad='+ReclamoDetalleCantidad+'&ReclamoDetallePrecioUnitario='+ReclamoDetallePrecioUnitario+'&ReclamoDetalleImporte='+ReclamoDetalleImporte+'&ReclamoDetalleObservacion='+ReclamoDetalleObservacion+'&Item='+Item,
							success: function(){
								
							$('#CapReclamoDetalleAccion').html('Listo');							
								FncReclamoDetalleListar();
							}
						});
						

						FncReclamoDetalleNuevo();	
					
					
			}
			
	
}


function FncReclamoDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapReclamoDetalleAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/Reclamo/FrmReclamoDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+ReclamoDetalleEditar+'&Eliminar='+ReclamoDetalleEliminar+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapReclamoDetalleAccion').html('Listo');	
			$("#CapReclamoDetalles").html("");
			$("#CapReclamoDetalles").append(html);
		}
	});

}



function FncReclamoDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapReclamoDetalleAccion').html('Editando...');
	$('#CmpReclamoDetalleAccion').val("AccReclamoDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Reclamo/acc/AccReclamoDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsReclamoDetalle){

//SesionObjeto-InsReclamoDetalle
//Parametro1 = RdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = ProCodigoOriginal
//Parametro5 = ProNombre
//Parametro6 = AmoComprobanteNumero
//Parametro7 = 
//Parametro8 = 
//Parametro9 = AmoComprobanteFecha
//Parametro10 = OcoTipo	
//Parametro11 = AmdCantidad	
//Parametro12 = RdeCantidad	
//Parametro13 = RdePrecioUnitario
//Parametro14 = RdeImporte
//Parametro15 = RdeObservacion
//Parametro16 = RdeTiempoCreacion
//Parametro17 = RdeTiempoModificacion
			
			$('#CmpReclamoDetalleCodigo').val(InsReclamoDetalle.Parametro4);	
			$('#CmpReclamoDetalleDescripcion').val(InsReclamoDetalle.Parametro5);
			$('#CmpReclamoDetalleCantidad').val(InsReclamoDetalle.Parametro11);
			$('#CmpReclamoDetallePrecioUnitario').val(InsReclamoDetalle.Parametro13);
			$('#CmpReclamoDetalleImporte').val(InsReclamoDetalle.Parametro14);
			$('#CmpReclamoDetalleObservacion').val(InsReclamoDetalle.Parametro15);
			
			$('#CmpReclamoDetalleItem').val(InsReclamoDetalle.Item);
			
			$('#CmpReclamoDetalleObservacion').select();
			
		}
	});
	
	
	
	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncReclamoDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapReclamoDetalleAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Reclamo/acc/AccReclamoDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapReclamoDetalleAccion').html("Eliminado");	
				FncReclamoDetalleListar();
			}
		});

		FncReclamoDetalleNuevo();

	}
	
}

function FncReclamoDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapReclamoDetalleAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Reclamo/acc/AccReclamoDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapReclamoDetalleAccion').html('Eliminado');	
				FncReclamoDetalleListar();
			}
		});	
			
		FncReclamoDetalleNuevo();
	}
	
}



function FncReclamoDetalleCalcularImporte(){


	var PrecioUnitario = $('#CmpReclamoDetallePrecioUnitario').val();
	var Cantidad = $('#CmpReclamoDetalleCantidad').val();	
	var Importe = 0;
		
	if(PrecioUnitario!=""){
		
		Importe =  (Cantidad*1) * (PrecioUnitario*1);
		$('#CmpReclamoDetalleImporte').val(Importe);
		
	}else{

	}
}


$().ready(function() {

	$("#CmpReclamoDetalleCantidad").keyup(function (event) {  
		FncReclamoDetalleCalcularImporte();
	});

});