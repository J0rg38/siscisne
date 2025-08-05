// JavaScript Document

function FncCotizacionProductoTotalNuevo(){
	
	
}

function FncCotizacionProductoTotalGuardar(){

	
	
}


function FncCotizacionProductoTotalListar(){

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
		url: 'formularios/CotizacionProducto/FrmCotizacionProductoTotalListado.php',
		data: 'MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&ManoObra='+ManoObra+'&IncluyeImpuesto='+IncluyeImpuesto+'&DescuentoPorcentaje='+DescuentoPorcentaje+'&PorcentajeImpuestoVenta='+PorcentajeImpuestoVenta+'&Identificador='+Identificador,
		success: function(html){
			
			$("#CapCotizacionProductoTotals").html("");
			$("#CapCotizacionProductoTotals").append(html);
		}
	});

}



function FncCotizacionProductoTotalEscoger(oItem){
		
	

}

function FncCotizacionProductoTotalEliminar(oItem){

	
	
}

function FncCotizacionProductoTotalEliminarTodo(){
	
}
