// JavaScript Document

function FncGarantiaRepuestoIsuzuDetalleNuevo(){
	
	$('#CmpGarantiaRepuestoIsuzuDetalleId').val("");

	$('#CmpProductoId').val("");
	$('#CmpProductoCodigoOriginal').val("");
	$('#CmpProductoNombre').val("");
	
	$('#CmpGarantiaRepuestoIsuzuDetalleCostoTotal').val("");	
	$('#CmpGarantiaRepuestoIsuzuDetalleMargen').val(CalificacionMargen);
	$('#CmpGarantiaRepuestoIsuzuDetalleCostoMargen').val("");
	
	$('#CmpGarantiaRepuestoIsuzuDetalleCantidad').val("");
	$('#CmpGarantiaRepuestoIsuzuDetalleItem').val("");	

	$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Listo para registrar elementos');	
			
	$('#CmpGarantiaRepuestoIsuzuDetalleCodigo').select();
			
	$('#CmpGarantiaRepuestoIsuzuDetalleAccion').val("AccGarantiaRepuestoIsuzuDetalleRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncGarantiaRepuestoIsuzuDetalleGuardar(){

		var Identificador = $('#Identificador').val();

		var Acc = $('#CmpGarantiaRepuestoIsuzuDetalleAccion').val();		
	
			var GarantiaRepuestoIsuzuDetalleId = $('#CmpGarantiaRepuestoIsuzuDetalleId').val();
			
			var ProductoId = $('#CmpProductoId').val();
			var UnidadMedidaId = $('#CmpUnidadMedidaId').val();
			
			//var GarantiaRepuestoIsuzuDetalleCodigo = $('#CmpGarantiaRepuestoIsuzuDetalleCodigo').val();			
			//var GarantiaRepuestoIsuzuDetalleDescripcion = $('#CmpGarantiaRepuestoIsuzuDetalleDescripcion').val();
			var GarantiaRepuestoIsuzuDetalleCantidad = $('#CmpGarantiaRepuestoIsuzuDetalleCantidad').val();
			var GarantiaRepuestoIsuzuDetalleCostoTotal = $('#CmpGarantiaRepuestoIsuzuDetalleCostoTotal').val();
			
			//var GarantiaRepuestoIsuzuDetalleMargen = $('#CmpGarantiaRepuestoIsuzuDetalleMargen').val();
//			var GarantiaRepuestoIsuzuDetalleCostoMargen = $('#CmpGarantiaRepuestoIsuzuDetalleCostoMargen').val();

			var Item = $('#CmpGarantiaRepuestoIsuzuDetalleItem').val();

			if(ProductoId==""){
				$('#CmpProductoCodigoOriginal').select();	
			}else if(GarantiaRepuestoIsuzuDetalleCantidad=="" || GarantiaRepuestoIsuzuDetalleCantidad <=0){
				$('#CmparantiaDetalleCantidad').select();	
			}else if(GarantiaRepuestoIsuzuDetalleCostoTotal=="" || GarantiaRepuestoIsuzuDetalleCantidad <=0){
				$('#CmpGarantiaRepuestoIsuzuDetalleCostoTotal').select();	
			}else{
				$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Guardando...');

						$.ajax({
							type: 'POST',
							url: 'formularios/GarantiaRepuestoIsuzu/acc/'+Acc,
							data: 'Identificador='+Identificador+
'&GarantiaRepuestoIsuzuDetalleId='+GarantiaRepuestoIsuzuDetalleId+
'&ProductoId='+ProductoId+
'&UnidadMedidaId='+UnidadMedidaId+
'&GarantiaRepuestoIsuzuDetalleCantidad='+GarantiaRepuestoIsuzuDetalleCantidad+
'&GarantiaRepuestoIsuzuDetalleCostoTotal='+GarantiaRepuestoIsuzuDetalleCostoTotal+
//'&GarantiaRepuestoIsuzuDetalleMargen='+GarantiaRepuestoIsuzuDetalleMargen+
//'&GarantiaRepuestoIsuzuDetalleCostoMargen='+GarantiaRepuestoIsuzuDetalleCostoMargen+
'&Item='+Item,
							success: function(){
								
							$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Listo');							
								FncGarantiaRepuestoIsuzuDetalleListar();
							}
						});
						

						FncGarantiaRepuestoIsuzuDetalleNuevo();	
					
					
			}
			
			
	
}


function FncGarantiaRepuestoIsuzuDetalleListar(){

	var Identificador = $('#Identificador').val();

	$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/GarantiaRepuestoIsuzu/FrmGarantiaRepuestoIsuzuDetalleListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+GarantiaRepuestoIsuzuDetalleEditar+
'&Eliminar='+GarantiaRepuestoIsuzuDetalleEliminar+
'&MonedaId='+MonedaId+
'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Listo');	
			$("#CapGarantiaRepuestoIsuzuDetalles").html("");
			$("#CapGarantiaRepuestoIsuzuDetalles").append(html);
		}
	});

}



function FncGarantiaRepuestoIsuzuDetalleEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Editando...');
	$('#CmpGarantiaRepuestoIsuzuDetalleAccion').val("AccGarantiaRepuestoIsuzuDetalleEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/GarantiaRepuestoIsuzu/acc/AccGarantiaRepuestoIsuzuDetalleEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsGarantiaRepuestoIsuzuDetalle){

//SesionObjeto-InsGarantiaRepuestoIsuzuDetalle
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

			$('#CmpProductoId').val(InsGarantiaRepuestoIsuzuDetalle.Parametro2);
			$('#CmpUnidadMedidaId').val(InsGarantiaRepuestoIsuzuDetalle.Parametro3);
			
			$('#CmpProductoCodigoOriginal').val(InsGarantiaRepuestoIsuzuDetalle.Parametro15);	
			$('#CmpProductoNombre').val(InsGarantiaRepuestoIsuzuDetalle.Parametro16);
			
			$('#CmpGarantiaRepuestoIsuzuDetalleCantidad').val(InsGarantiaRepuestoIsuzuDetalle.Parametro7);
			$('#CmpGarantiaRepuestoIsuzuDetalleCostoTotal').val(InsGarantiaRepuestoIsuzuDetalle.Parametro8);

			$('#CmpGarantiaRepuestoIsuzuDetalleItem').val(InsGarantiaRepuestoIsuzuDetalle.Item);
			
			$('#CmpProductoCodigoOriginal').select();
			
		}
	});
	
	
	
	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncGarantiaRepuestoIsuzuDetalleEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/GarantiaRepuestoIsuzu/acc/AccGarantiaRepuestoIsuzuDetalleEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapGarantiaRepuestoIsuzuDetalleAccion').html("Eliminado");	
				FncGarantiaRepuestoIsuzuDetalleListar();
			}
		});

		FncGarantiaRepuestoIsuzuDetalleNuevo();

	}
	
}

function FncGarantiaRepuestoIsuzuDetalleEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/GarantiaRepuestoIsuzu/acc/AccGarantiaRepuestoIsuzuDetalleEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapGarantiaRepuestoIsuzuDetalleAccion').html('Eliminado');	
				FncGarantiaRepuestoIsuzuDetalleListar();
			}
		});	
			
		FncGarantiaRepuestoIsuzuDetalleNuevo();
	}
	
}









function FncGarantiaRepuestoIsuzuDetalleCalcularCostoMargen(){

	var CostoMargen = 0;
	var Margen = $('#CmpGarantiaRepuestoIsuzuDetalleMargen').val();
	var CostoTotal = $('#CmpGarantiaRepuestoIsuzuDetalleCostoTotal').val();	

	if(Margen!=""){
		if(CostoTotal!=""){
			//CostoMargen = (( (Margen + 1 - 1)/100) * (CostoTotal + 1 - 1)) + (CostoTotal + 1 - 1);
			CostoMargen = (((Margen)/100) * CostoTotal) + CostoTotal*1 ;
			
			$('#CmpGarantiaRepuestoIsuzuDetalleCostoMargen').val(CostoMargen);
		}else{

		}
	}else{

	}
}


$().ready(function() {

	$("#CmpGarantiaRepuestoIsuzuDetalleCostoTotal").keyup(function (event) {  
		FncGarantiaRepuestoIsuzuDetalleCalcularCostoMargen();
	});

});


