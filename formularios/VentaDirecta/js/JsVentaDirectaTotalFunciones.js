// JavaScript Document

function FncVentaDirectaTotalNuevo(){
	
	
}

function FncVentaDirectaTotalGuardar(){

	
	
}


function FncVentaDirectaTotalListar(){

	var Identificador = $('#Identificador').val();
	
	$('#CapProductoAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var ManoObra = $('#CmpManoObra').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	var DescuentoPorcentaje = $('#CmpPorcentajeDescuento').val();
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	
	//alert(TipoCambio);
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/VentaDirecta/FrmVentaDirectaTotalListado.php',
		data: 'MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&ManoObra='+ManoObra+'&IncluyeImpuesto='+IncluyeImpuesto+'&DescuentoPorcentaje='+DescuentoPorcentaje+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&Identificador='+Identificador,
		success: function(html){
			
			$("#CapVentaDirectaTotals").html("");
			$("#CapVentaDirectaTotals").append(html);
		}
	});

}



function FncVentaDirectaTotalEscoger(oItem){
		
	

}

function FncVentaDirectaTotalEliminar(oItem){

	
	
}

function FncVentaDirectaTotalEliminarTodo(){
	
}
