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

function FncReporteOrdenVentaVehiculoCanceladoValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var Personal = $("#CmpPersonal").val();

	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteOrdenVentaVehiculoCanceladoVer(){
	
	if(FncReporteOrdenVentaVehiculoCanceladoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		
		$('#CapReporteOrdenVentaVehiculoCancelado').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculoCancelado.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculoCancelado').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoCanceladoImprimir(){
	
	if(FncReporteOrdenVentaVehiculoCanceladoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		
		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculoCancelado.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoCanceladoGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoCanceladoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculoCancelado.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoCanceladoNuevo(){

}
