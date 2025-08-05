// JavaScript Document

$().ready(function() {
	
	var EntregaVentaVehiculoId = $("#CmpEntregaVentaVehiculoId").val();

	$('#BtnEntregaVentaVehiculoReprogramar').on('click', function() {
		$(location).attr('href', 'DiaEntregaVentaVehiculoReprogramar.php?EvvId='+EntregaVentaVehiculoId);
	});
	
	$('#BtnEntregaVentaVehiculoActualizar').on('click', function() {
		
		
	//	var FechaProgramada = $("#CmpEntregaVentaVehiculoFechaProgramada").val();
	//	var HoraProgramada = $("#CmpEntregaVentaVehiculoHoraProgramada").val();
		var Duracion = $("#CmpEntregaVentaVehiculoDuracion").val();
		var ObservacionSalida = $("#CmpEntregaVentaVehiculoObservacionSalida").val();
		var Notificar = "2";
		
		//if($('#CmpNotificar').is(':checked')){
//			Notificar = "1";
//		}
		
		console.log("Duracion: "+Duracion);
		console.log("ObservacionSalida: "+ObservacionSalida);

		self.parent.FncEntregaVehiculoActualizar(EntregaVentaVehiculoId,Duracion,ObservacionSalida);
	});
	
	
	$('#BtnEntregaVentaVehiculoPendiente').on('click', function() {
		
		var Notificar = "2";
		
		if($('#CmpNotificar').is(':checked')){
			Notificar = "1";
		}
		
		self.parent.FncEntregaVehiculoPendiente(EntregaVentaVehiculoId,Notificar);
	});
	
	$('#BtnEntregaVentaVehiculoAtendido').on('click', function() {
		
		var Notificar = "2";
		
		if($('#CmpNotificar').is(':checked')){
			Notificar = "1";
		}
		
		self.parent.FncEntregaVehiculoRealizado(EntregaVentaVehiculoId,Notificar);
	});
	
	$('#BtnEntregaVentaVehiculoAnulado').on('click', function() {
		
		var Notificar = "2";
		
		if($('#CmpNotificar').is(':checked')){
			Notificar = "1";
		}
		
		self.parent.FncEntregaVehiculoAnulado(EntregaVentaVehiculoId,Notificar);
	});
	
	$('#BtnEntregaVentaVehiculoCerrar').on('click', function() {
		self.parent.tb_remove();
	});

});


