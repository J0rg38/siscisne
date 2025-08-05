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

function FncReporteOrdenVentaVehiculoInicialValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var Personal = $("#CmpPersonal").val();
	var Moneda = $("#CmpMoneda").val();

	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteOrdenVentaVehiculoInicialVer(){
	
	if(FncReporteOrdenVentaVehiculoInicialValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var Moneda = $("#CmpMoneda").val();
		
		$('#CapReporteOrdenVentaVehiculoInicial').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculoInicial.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&Moneda="+Moneda,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculoInicial').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoInicialImprimir(){
	
	if(FncReporteOrdenVentaVehiculoInicialValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var Moneda = $("#CmpMoneda").val();
		
		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculoInicial.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&Moneda="+Moneda+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoInicialGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoInicialValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var Moneda = $("#CmpMoneda").val();
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculoInicial.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&Moneda="+Moneda+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoInicialNuevo(){

}
