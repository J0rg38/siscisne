// JavaScript Document
var Ventas = "1";
var Libres = "1";

$().ready(function() {

	$('#CmpSucursal').on('change', function() {
	
		FncPersonalesCargar();	
	
	});

	
/*
* EVENTOS - NAVEGACION
*/		
	
});

function FncReporteOrdenVentaVehiculoSinEntregaValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var Personal = $("#CmpPersonal").val();
	var DiasTranscurridos = $("#CmpDiasTranscurridos").val();

	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteOrdenVentaVehiculoSinEntregaVer(){
	
	if(FncReporteOrdenVentaVehiculoSinEntregaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		$('#CapReporteOrdenVentaVehiculoSinEntrega').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculoSinEntrega.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&DiasTranscurridos="+DiasTranscurridos,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculoSinEntrega').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoSinEntregaImprimir(){
	
	if(FncReporteOrdenVentaVehiculoSinEntregaValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculoSinEntrega.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&DiasTranscurridos="+DiasTranscurridos+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoSinEntregaGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoSinEntregaValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var DiasTranscurridos = $("#CmpDiasTranscurridos").val();
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculoSinEntrega.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Persona+"&DiasTranscurridos="+DiasTranscurridosl+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoSinEntregaNuevo(){

}
