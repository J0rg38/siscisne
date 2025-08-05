// JavaScript Document

function FncGarantiaDetalleNuevo(){
	
	$('#CmpGarantiaDetalleId').val("");

	$('#CmpProductoId').val("");
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoNombre').val("");
	
	$('#CmpGarantiaDetalleCostoTotal').val("");	
	$('#CmpGarantiaDetalleMargen').val(CalificacionMargen);
	$('#CmpGarantiaDetalleCostoMargen').val("");
	
	$('#CmpGarantiaDetalleCantidad').val("");
	$('#CmpGarantiaDetalleItem').val("");	

	$('#CapGarantiaDetalleAccion').html('Listo para registrar elementos');	
			
	$('#CmpGarantiaDetalleCodigo').select();
			
	$('#CmpGarantiaDetalleAccion').val("AccGarantiaDetalleRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncGarantiaDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpGarantiaDetalleAccion').val();		
	
			var GarantiaDetalleId = $('#CmpGarantiaDetalleId').val();
			
			var ProductoId = $('#CmpProductoId').val();
			var UnidadMedidaId = $('#CmpUnidadMedidaId').val();
			
			//var GarantiaDetalleCodigo = $('#CmpGarantiaDetalleCodigo').val();			
			//var GarantiaDetalleDescripcion = $('#CmpGarantiaDetalleDescripcion').val();
			var GarantiaDetalleCantidad = $('#CmpGarantiaDetalleCantidad').val();
			var GarantiaDetalleCostoTotal = $('#CmpGarantiaDetalleCostoTotal').val();
			
			//var GarantiaDetalleMargen = $('#CmpGarantiaDetalleMargen').val();
//			var GarantiaDetalleCostoMargen = $('#CmpGarantiaDetalleCostoMargen').val();

			var Item = $('#CmpGarantiaDetalleItem').val();

			if(ProductoId==""){
				$('#CmpProductoCodigoOriginal').select();	
			}else if(GarantiaDetalleCantidad=="" || GarantiaDetalleCantidad <=0){
				$('#CmparantiaDetalleCantidad').select();	
			}else if(GarantiaDetalleCostoTotal=="" || GarantiaDetalleCantidad <=0){
				$('#CmpGarantiaDetalleCostoTotal').select();	
			}else{
				$('#CapGarantiaDetalleAccion').html('Guardando...');

						$.ajax({
							type: 'POST',
							url: 'formularios/Garantia/acc/'+Acc,
							data: 'Identificador='+Identificador+
							'&GarantiaDetalleId='+GarantiaDetalleId+
							'&ProductoId='+ProductoId+
							'&UnidadMedidaId='+UnidadMedidaId+
							'&GarantiaDetalleCantidad='+GarantiaDetalleCantidad+
							'&GarantiaDetalleCostoTotal='+GarantiaDetalleCostoTotal+
							//'&GarantiaDetalleMargen='+GarantiaDetalleMargen+
							//'&GarantiaDetalleCostoMargen='+GarantiaDetalleCostoMargen+
							'&Item='+Item,
							success: function(){
								
							$('#CapGarantiaDetalleAccion').html('Listo');							
								FncGarantiaDetalleListar();
							}
						});
						

						FncGarantiaDetalleNuevo();	
					
					
			}
			
			
	
}


function FncGarantiaDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapGarantiaDetalleAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaDetalleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+GarantiaDetalleEditar+
'&Eliminar='+GarantiaDetalleEliminar+
'&MonedaId='+MonedaId+
'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapGarantiaDetalleAccion').html('Listo');	
			$("#CapGarantiaDetalles").html("");
			$("#CapGarantiaDetalles").append(html);
		}
	});

}



function FncGarantiaDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapGarantiaDetalleAccion').html('Editando...');
	$('#CmpGarantiaDetalleAccion').val("AccGarantiaDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Garantia/acc/AccGarantiaDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsGarantiaDetalle){

//SesionObjeto-InsGarantiaDetalle
//Parametro1 = GdeId
//Parametro2 = ProId
//Parametro3 = UmeId
//Parametro4 = GdeCodigo
//Parametro5 = GdeDescripcion
//Parametro6 = GdeCosto
//Parametro7 = GdeCantidad
//Parametro8 = GdeCostoTotal	
//Parametro9 = GdeEstado	
//Parametro10 = GdeTiempoCreacion		
//Parametro11 = GdeTiempoModificacion	
//Parametro12 = GdeMargen
//Parametro13 = GdeCostoMargen
//Parametro14 = AmdId

//Parametro15 = ProCodigoOriginal
//Parametro16 = ProNombre
//Parametro17 = UmeNombre

			$('#CmpProductoId').val(InsGarantiaDetalle.Parametro2);
			$('#CmpUnidadMedidaId').val(InsGarantiaDetalle.Parametro3);
			
			$('#CmpProductoCodigoOriginal').val(InsGarantiaDetalle.Parametro15);	
			$('#CmpProductoNombre').val(InsGarantiaDetalle.Parametro16);
			
			$('#CmpGarantiaDetalleCantidad').val(InsGarantiaDetalle.Parametro7);
			$('#CmpGarantiaDetalleCostoTotal').val(InsGarantiaDetalle.Parametro8);

			$('#CmpGarantiaDetalleItem').val(InsGarantiaDetalle.Item);
			
			$('#CmpProductoCodigoOriginal').select();
			
		}
	});
	
	
	
	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncGarantiaDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapGarantiaDetalleAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/AccGarantiaDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapGarantiaDetalleAccion').html("Eliminado");	
				FncGarantiaDetalleListar();
			}
		});

		FncGarantiaDetalleNuevo();

	}
	
}

function FncGarantiaDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapGarantiaDetalleAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/AccGarantiaDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapGarantiaDetalleAccion').html('Eliminado');	
				FncGarantiaDetalleListar();
			}
		});	
			
		FncGarantiaDetalleNuevo();
	}
	
}









function FncGarantiaDetalleCalcularCostoMargen(){

	var CostoMargen = 0;
	var Margen = $('#CmpGarantiaDetalleMargen').val();
	var CostoTotal = $('#CmpGarantiaDetalleCostoTotal').val();	

	if(Margen!=""){
		if(CostoTotal!=""){
			//CostoMargen = (( (Margen + 1 - 1)/100) * (CostoTotal + 1 - 1)) + (CostoTotal + 1 - 1);
			CostoMargen = (((Margen)/100) * CostoTotal) + CostoTotal*1 ;
			
			$('#CmpGarantiaDetalleCostoMargen').val(CostoMargen);
		}else{

		}
	}else{

	}
}


$().ready(function() {

	$("#CmpGarantiaDetalleCostoTotal").keyup(function (event) {  
		FncGarantiaDetalleCalcularCostoMargen();
	});

});


