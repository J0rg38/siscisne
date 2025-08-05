// JavaScript Document

$().ready(function() {
	
	var EntregaVentaVehiculoId = $("#CmpEntregaVentaVehiculoId").val();

	
	$('#BtnEntregaVentaVehiculoGuardar').on('click', function() {
		
		var FechaProgramada = $("#CmpEntregaVentaVehiculoFechaProgramada").val();
		var HoraProgramada = $("#CmpEntregaVentaVehiculoHoraProgramada").val();
		var Duracion = $("#CmpEntregaVentaVehiculoDuracion").val();
		var ObservacionSalida = $("#CmpEntregaVentaVehiculoObservacionSalida").val();
	
		var Notificar = "2";
		
		if($('#CmpNotificar').is(':checked')){
			Notificar = "1";
		}
		
		self.parent.FncEntregaVehiculoReprogramar(EntregaVentaVehiculoId,FechaProgramada,HoraProgramada,Duracion,ObservacionSalida,Notificar);
		
	});
	
	$('#BtnEntregaVentaVehiculoCerrar').on('click', function() {
		//self.parent.tb_remove();
		self.parent.FncEntregaVehiculoReprogramarCerrar();
	});

});


