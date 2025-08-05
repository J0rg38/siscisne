// JavaScript Document


function FncTallerPedidoTotalListar(oModalidadIngreso){
	
	console.log("Cargando taller pedido detalle");
	console.log("Modalidad: "+oModalidadIngreso);
	
	var Identificador = $('#Identificador').val();

	//$('#CapProductoAccion').html('Cargando...');
	
	var MonedaId = $('#CmpMonedaId_'+oModalidadIngreso).val();
	var TipoCambio = $('#CmpTipoCambio_'+oModalidadIngreso).val();
	var AlmacenId = $('#CmpAlmacen_'+oModalidadIngreso).val();
	
	var Descuento = 0;
	var ManoObra = 0;
	var Total = 0;
	
	try {
		 Total = $('#CmpMantenimientoTotal').val();
	}catch(err) {
		 Total = 0;
	}
	
	try {
		 ManoObra = $('#CmpFichaAccionManoObra_'+oModalidadIngreso).val();
	}catch(err) {
		 ManoObra = 0;
	}
	
	try {
		Descuento = $('#CmpDescuento_'+oModalidadIngreso).val();
	}catch(err) {
		Descuento = 0;
	}
	
	
	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}
	
	//$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoTotalListado.php',
		data: 'Identificador='+Identificador+'&ModalidadIngreso='+oModalidadIngreso+'&AlmacenId='+AlmacenId+'&MonedaId='+MonedaId+'&TipoCambio='+TipoCambio+'&Descuento='+Descuento+'&ManoObra='+ManoObra+'&Total='+Total+'&Editar='+'&Eliminar=',
		success: function(html){
			
			//$('#Cap'+oModalidadIngreso+'ProductoAccion').html('Listo');	
			
			$("#CapTallerPedido"+oModalidadIngreso+"Totales").html("");
			$("#CapTallerPedido"+oModalidadIngreso+"Totales").append(html);
			

		}
	});
	

}

