// JavaScript Document




function FncTallerPedidoCotizacionesListar(){

	var VehiculoIngresoVIN = $("#CmpFichaIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpFichaIngresoId").val();	

	$('#CapTallerPedidoCotizacionesAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoCotizaciones.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapTallerPedidoCotizacionesAccion').html('Listo');	
			$("#CapTallerPedidoCotizaciones").html("");
			$("#CapTallerPedidoCotizaciones").append(html);
		}
	});
	
	


}


