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

function FncReporteClasificacionProductoABCValidar(){
	
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

function FncReporteClasificacionProductoABCVer(){
	
	if(FncReporteClasificacionProductoABCValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var Moneda = $("#CmpMoneda").val();
		
		$('#CapReporteClasificacionProductoABC').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteClasificacionProductoABC.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&Moneda="+Moneda,
			success: function(html){
				$('#CapReporteClasificacionProductoABC').html(html);	
			}
		});

	}

}


function FncReporteClasificacionProductoABCImprimir(){
	
	if(FncReporteClasificacionProductoABCValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var Moneda = $("#CmpMoneda").val();
		
		FncPopUp("formularios/Reporte/IfrReporteClasificacionProductoABC.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&Moneda="+Moneda+"&P=1");
	
	}

}

function FncReporteClasificacionProductoABCGenerarExcel(){
	
	if(FncReporteClasificacionProductoABCValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var Personal = $("#CmpPersonal").val();
		var Moneda = $("#CmpMoneda").val();
		
		FncPopUp("formularios/Reporte/XLSReporteClasificacionProductoABC.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&Personal="+Personal+"&Moneda="+Moneda+"&P=2");
		
	}
	
}

function FncReporteClasificacionProductoABCNuevo(){

}
