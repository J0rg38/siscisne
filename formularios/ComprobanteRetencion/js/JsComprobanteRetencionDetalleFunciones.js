
// JavaScript Document

function FncComprobanteRetencionDetalleNuevo(){
	
	
	$('#CmpComprobanteRetencionDetalleTipoDocumento').val("");
	$('#CmpComprobanteRetencionDetalleSerie').val("");
	$('#CmpComprobanteRetencionDetalleNumero').val("");
	$('#CmpComprobanteRetencionDetalleFechaEmision').val("");
	$('#CmpComprobanteRetencionDetalleTotal').val("");
	$('#CmpComprobanteRetencionDetallePorcentajeRetencion').val("");
	$('#CmpComprobanteRetencionDetalleRetenido').val("");
	$('#CmpComprobanteRetencionDetallePagado').val("");
	
	$('#CmpComprobanteRetencionDetalleItem').val("");
	
	$('#CmpComprobanteRetencionDetalleAccion').val("AccComprobanteRetencionDetalleRegistrar.php");
	
	$('#CmpComprobanteRetencionDetalleTipoDocumento').focus();	
	$('#CapComprobanteRetencionDetalleAccion').html("Listo para registrar elementos");
}

function FncComprobanteRetencionDetalleGuardar(){
	
	var Identificador = $('#Identificador').val();
	
	var TipoDocumento = $('#CmpComprobanteRetencionDetalleTipoDocumento').val();
	var Serie = $('#CmpComprobanteRetencionDetalleSerie').val();	
	var Numero = $('#CmpComprobanteRetencionDetalleNumero').val();
	var FechaEmision = $('#CmpComprobanteRetencionDetalleFechaEmision').val();
	var Total = $('#CmpComprobanteRetencionDetalleTotal').val();	
	var PorcentajeRetencion = $('#CmpComprobanteRetencionDetallePorcentajeRetencion').val();	
	var Retenido = $('#CmpComprobanteRetencionDetalleRetenido').val();
	var Pagado = $('#CmpComprobanteRetencionDetallePagado').val();
	
	var Item = $('#CmpComprobanteRetencionDetalleItem').val();
	var Acc = $('#CmpComprobanteRetencionDetalleAccion').val();
	
	if(TipoDocumento==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes escoger un tipo de comprobante",
			callback: function(result){
				$('#CmpComprobanteRetencionDetalleTipoDocumento').focus();	
			}
		});
		
	}else if(Serie==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un numero de serie",
			callback: function(result){
				$('#CmpComprobanteRetencionDetalleSerie').focus();	
			}
		});
				
	}else if(Numero=="" ){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un numero de serie",
			callback: function(result){
				$('#CmpComprobanteRetencionDetalleNumero').focus();	
			}
		});
				
	}else if(FechaEmision==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un fecha de emision",
			callback: function(result){
				$('#CmpComprobanteRetencionDetalleFechaEmision').focus();	
			}
		});
		
	}else if(Total==""){

		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un total",
			callback: function(result){
				$('#CmpComprobanteRetencionDetalleTotal').focus();	
			}
		});
		
	}else if(PorcentajeRetencion==""){
			
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un porcentaje de retencion",
			callback: function(result){
				$('#CmpComprobanteRetencionDetallePorcentajeRetencion').focus();	
			}
		});		
		
	}else if(Retenido==""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un monto retenido",
			callback: function(result){
				$('#CmpComprobanteRetencionDetalleRetenido').focus();	
			}
		});
		
	}else if(Pagado==""){
			
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"Debes ingresar un monto pagado",
			callback: function(result){
				$('#CmpComprobanteRetencionDetallePagado').focus();	
			}
		});
		
	}else{

			$('#CapComprobanteRetencionDetalleAccion').html('Guardando...');
				
			$.ajax({
				type: 'POST',
				url: 'formularios/ComprobanteRetencion/acc/'+Acc,
				data: 'Identificador='+Identificador+
				'&TipoDocumento='+(TipoDocumento)+
				'&Serie='+Serie+
				'&Numero='+(Numero)+
				'&FechaEmision='+FechaEmision+
				'&Total='+Total+
				'&PorcentajeRetencion='+PorcentajeRetencion+				
				'&Retenido='+Retenido+
				'&Pagado='+Pagado+
				'&Item='+Item,
				success: function(){
					$('#CapComprobanteRetencionDetalleAccion').html('Listo');							
					FncComprobanteRetencionDetalleListar();
				}
			});

		FncComprobanteRetencionDetalleNuevo();
		
	}		
}

function FncComprobanteRetencionDetalleListar(){
	
	var Identificador = $('#Identificador').val();
	
	$('#CapComprobanteRetencionDetalleAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	$.ajax({
		type: 'POST',
		url: 'formularios/ComprobanteRetencion/FrmComprobanteRetencionDetalleListado.php',
		data: 'Identificador='+Identificador+
		
		'&MonedaId='+MonedaId+
		'&MonedaSimbolo='+MonedaSimbolo+
		'&TipoCambio='+TipoCambio+
		
		'&Editar='+ComprobanteRetencionDetalleEditar+
		'&Eliminar='+ComprobanteRetencionDetalleEliminar,		
		
		success: function(html){
			$('#CapComprobanteRetencionDetalleAccion').html('Listo');	
			$("#CapComprobanteRetencionDetalles").html("");
			$("#CapComprobanteRetencionDetalles").append(html);
		}
	});
	

}


function FncComprobanteRetencionDetalleEscoger(oItem){

/*
SesionObjeto-ComprobanteRetencionDetalleListado
Parametro1 = CedId
Parametro2 = CedTipoDocumento
Parametro3 = 
Parametro4 = CedRetenido
Parametro5 = CedPagado
Parametro6 = CedTotal
Parametro7 = CedTiempoCreacion
Parametro8 = CedTiempoModificacion
Parametro9 = CedSerie
Parametro10 = CedNumero
Parametro11 = CedPorcentajeRetencion
Parametro12 = CedFechaEmision
Parametro13 = CedEstado
*/

	
	var Identificador = $('#Identificador').val();

	$('#CapComprobanteRetencionDetalleAccion').html('Editando...');
	$('#CmpComprobanteRetencionDetalleAccion').val("AccComprobanteRetencionDetalleEditar.php");

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/ComprobanteRetencion/acc/AccComprobanteRetencionDetalleEscoger.php',
		data: 'Identificador='+Identificador+'&Item='+oItem,
		success: function(InsComprobanteRetencionDetalle){
		
				$('#CmpComprobanteRetencionDetalleTipoDocumento').val(InsComprobanteRetencionDetalle.Parametro2);	
				$('#CmpComprobanteRetencionDetalleSerie').val(InsComprobanteRetencionDetalle.Parametro9);
				$('#CmpComprobanteRetencionDetalleNumero').val(InsComprobanteRetencionDetalle.Parametro10);
				$('#CmpComprobanteRetencionDetalleFechaEmision').val(InsComprobanteRetencionDetalle.Parametro12);
				
				$('#CmpComprobanteRetencionDetalleTotal').val(InsComprobanteRetencionDetalle.Parametro6);
				$('#CmpComprobanteRetencionDetallePorcentajeRetencion').val(InsComprobanteRetencionDetalle.Parametro11);
				$('#CmpComprobanteRetencionDetalleRetenido').val(InsComprobanteRetencionDetalle.Parametro4);
				$('#CmpComprobanteRetencionDetallePagado').val(InsComprobanteRetencionDetalle.Parametro5);
				
				$('#CmpComprobanteRetencionDetallePorcentajeRetencion').select();
				
				$('#CmpComprobanteRetencionDetalleItem').val(InsComprobanteRetencionDetalle.Item);
				
		}
	});


}


function FncComprobanteRetencionDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapComprobanteRetencionDetalleAccion').html('Eliminando...');	

		$.ajax({
			type: 'POST',
			url: 'formularios/ComprobanteRetencion/acc/AccComprobanteRetencionDetalleEliminar.php',
			data: 'Identificador='+Identificador+'&Item='+oItem,
			success: function(){
				$('#CapComprobanteRetencionDetalleAccion').html("Eliminado");	
				FncComprobanteRetencionDetalleListar();
			}
		});

		FncComprobanteRetencionDetalleNuevo();

	}
	
}

function FncComprobanteRetencionDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		
		$('#CapComprobanteRetencionDetalleAccion').html('Eliminando...');	
		
		$.ajax({
			type: 'POST',
			url: 'formularios/ComprobanteRetencion/acc/AccComprobanteRetencionDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapComprobanteRetencionDetalleAccion').html('Eliminado');	
				FncComprobanteRetencionDetalleListar();
			}
		});	
		
		FncComprobanteRetencionDetalleNuevo();
	}
	
}



