// JavaScript Document




function FncTallerPedidoHistorialListar(){

	var VehiculoIngresoVIN = $("#CmpFichaIngresoVIN").val();
	var VehiculoIngresoId = $("#CmpFichaIngresoId").val();	

	$('#CapTallerPedidoHistorialAccion').html('Cargando...');
	
	$.ajax({
		type: 'POST',
		url: 'formularios/TallerPedido/FrmTallerPedidoHistorial.php',
		data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN+'&VehiculoIngresoId='+VehiculoIngresoId,
		success: function(html){
			$('#CapTallerPedidoHistorialAccion').html('Listo');	
			$("#CapTallerPedidoHistoriales").html("");
			$("#CapTallerPedidoHistoriales").append(html);
		}
	});
	

}


