// JavaScript Document

function FncOrdenCompraEntradaPedidoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapProductoAccion').html('Cargando...');
	
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	var ImpuestoVenta = 0;

	if(PorcentajeImpuestoVenta!="" ){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}

	if(TipoCambio==""){
		TipoCambio = 1;
	}
	
	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenCompraEntrada/FrmOrdenCompraEntradaPedidoListado.php',
		data: 'Identificador='+Identificador+'&Editar='+OrdenCompraEntradaPedidoEditar+'&Eliminar='+OrdenCompraEntradaPedidoEliminar+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapProductoAccion').html('Listo');	
			$("#CapOrdenCompraEntradaPedidos").html("");
			$("#CapOrdenCompraEntradaPedidos").append(html);	
		}
	});
	
}
