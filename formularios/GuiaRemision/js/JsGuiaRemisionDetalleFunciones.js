// JavaScript Document

function FncGuiaRemisionDetalleNuevo(){
	
	$('#CmpGuiaRemisionDetalleCodigo').val("");
	$('#CmpGuiaRemisionDetalleDescripcion').val("");
	$('#CmpGuiaRemisionDetalleCantidad').val("");
	$('#CmpGuiaRemisionDetalleUnidadMedida').val("");
	$('#CmpGuiaRemisionDetallePesoNeto').val("");
	$('#CmpGuiaRemisionDetallePesoTotal').val("");
	$('#CmpGuiaRemisionDetalleItem').val("");
	
	$('#CmpGuiaRemisionDetalleCodigo').focus();
	$('#CmpGuiaRemisionDetalleAccion').val("AccGuiaRemisionDetalleRegistrar.php");
	$('#CapGuiaRemisionDetalleAccion').html("Listo para registrar elementos");

}

function FncGuiaRemisionDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var GuiaRemisionDetalleCodigo = $('#CmpGuiaRemisionDetalleCodigo').val();
	var GuiaRemisionDetalleDescripcion = $('#CmpGuiaRemisionDetalleDescripcion').val();
	var GuiaRemisionDetalleCantidad = $('#CmpGuiaRemisionDetalleCantidad').val();
	var GuiaRemisionDetalleUnidadMedida = $('#CmpGuiaRemisionDetalleUnidadMedida').val();
	var GuiaRemisionDetallePesoNeto = $('#CmpGuiaRemisionDetallePesoNeto').val();
	var GuiaRemisionDetallePesoTotal = $('#CmpGuiaRemisionDetallePesoTotal').val();

	var Item = $('#CmpGuiaRemisionDetalleItem').val();
	var Acc = $('#CmpGuiaRemisionDetalleAccion').val();

	if(GuiaRemisionDetalleDescripcion==""){
		$('#CmpGuiaRemisionDetalleDescripcion').focus();	
	}else{
		if(GuiaRemisionDetalleCantidad=="" || GuiaRemisionDetalleCantidad <=0){
		$('#CmpGuiaRemisionDetalleCantidad').select();	
	}else{
			$('#CapGuiaRemisionDetalleAccion').html("Guardando...");	
			
				$.ajax({
					type: 'POST',
					url: 'formularios/GuiaRemision/acc/'+Acc,
					data: 'Identificador='+Identificador+'&GuiaRemisionDetalleCodigo='+GuiaRemisionDetalleCodigo+'&GuiaRemisionDetalleDescripcion='+GuiaRemisionDetalleDescripcion+'&GuiaRemisionDetalleCantidad='+GuiaRemisionDetalleCantidad+'&GuiaRemisionDetalleUnidadMedida='+GuiaRemisionDetalleUnidadMedida+'&GuiaRemisionDetallePesoTotal='+GuiaRemisionDetallePesoTotal+'&GuiaRemisionDetallePesoNeto='+GuiaRemisionDetallePesoNeto+'&Item='+Item,
					success: function(){
						$('#CapGuiaRemisionDetalleAccion').html('Listo');							
						FncGuiaRemisionDetalleListar();
					}
				});
				
						
			FncGuiaRemisionDetalleNuevo();
			
		}
	}		
	
}

function FncGuiaRemisionDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapGuiaRemisionDetalleAccion').html("Cargando...");	

	var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();

	$.ajax({
		type: 'POST',
		url: 'formularios/GuiaRemision/FrmGuiaRemisionDetalleListado.php',
		data: 'Identificador='+Identificador+'&Editar='+GuiaRemisionDetalleEditar+'&Eliminar='+GuiaRemisionDetalleEliminar+'&OrdenVentaVehiculoId='+OrdenVentaVehiculoId,
		success: function(html){
			$('#CapGuiaRemisionDetalleAccion').html('Listo');	
			$("#CapGuiaRemisionDetalles").html("");
			$("#CapGuiaRemisionDetalles").append(html);
		}
	});
	
	
}


function FncGuiaRemisionDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapGuiaRemisionDetalleAccion').html('Editando...');
	$('#CmpGuiaRemisionDetalleAccion').val("AccGuiaRemisionDetalleEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/GuiaRemision/acc/AccGuiaRemisionDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsGuiaRemisionDetalle){

/*
SesionObjeto-GuiaRemisionDetalleListado
Parametro1 = GrdId
Parametro2 = GrdCodigo
Parametro3 = GrdDescripcion
Parametro4 = GrdCantidad
Parametro5 = GrdUnidadMedida
Parametro6 = GrdPesoTotal
Parametro7 = GrdTiempoCreacion
Parametro8 = GrdTiempoModificacion
Parametro9 = GrdPesoNeto
*/

				$('#CmpGuiaRemisionDetalleCodigo').val(InsGuiaRemisionDetalle.Parametro2);	
				$('#CmpGuiaRemisionDetalleDescripcion').val(InsGuiaRemisionDetalle.Parametro3);		
				$('#CmpGuiaRemisionDetalleCantidad').val(InsGuiaRemisionDetalle.Parametro4);	
				$('#CmpGuiaRemisionDetalleUnidadMedida').val(InsGuiaRemisionDetalle.Parametro5);
				$('#CmpGuiaRemisionDetallePesoNeto').val(InsGuiaRemisionDetalle.Parametro9);
				$('#CmpGuiaRemisionDetallePesoTotal').val(InsGuiaRemisionDetalle.Parametro6);
				$('#CmpGuiaRemisionDetalleItem').val(InsGuiaRemisionDetalle.Item);
				
				$('#CmpGuiaRemisionDetalleCodigo').select();

		}
	});
	
	

}


function FncGuiaRemisionDetalleEliminar(oItem){
	
	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		document.getElementById('CapGuiaRemisionDetalleAccion').innerHTML = "Eliminando...";
		

		$.ajax({
			type: 'POST',
			url: 'formularios/GuiaRemision/acc/AccGuiaRemisionDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapGuiaRemisionDetalleAccion').html("Eliminado");	
				FncGuiaRemisionDetalleListar();
			}
		});
	
		
		FncGuiaRemisionDetalleNuevo();
	
	}


	
}



function FncGuiaRemisionDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapArticuloAccion').html('Eliminando...');	
		
		
			$.ajax({
			type: 'POST',
			url: 'formularios/GuiaRemision/acc/AccGuiaRemisionDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapGuiaRemisionDetalleAccion').html('Eliminado');	
				FncGuiaRemisionDetalleListar();
			}
		});	
			
				
		FncGuiaRemisionDetalleNuevo();
	}
	
}



