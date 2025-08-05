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

function FncReporteOrdenVentaVehiculoEntregaValidar(){
	
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

function FncReporteOrdenVentaVehiculoEntregaVer(){
	
	if(FncReporteOrdenVentaVehiculoEntregaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		
		$('#CapReporteOrdenVentaVehiculoEntrega').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculoEntrega.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculoEntrega').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoEntregaImprimir(){
	
	if(FncReporteOrdenVentaVehiculoEntregaValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		
		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculoEntrega.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoEntregaGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoEntregaValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculoEntrega.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoEntregaNuevo(){

}
