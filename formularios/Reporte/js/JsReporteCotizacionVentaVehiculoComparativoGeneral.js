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



function FncReporteCotizacionVentaVehiculoComparativoGeneralValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Personal = $("#CmpPersonal").val();
	var Vista = $("#CmpVista").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}else if(VehiculoMarca==""){
		alert("No ha escogido una marca de vehiculo.");
	}else if(Vista==""){
		alert("No ha escogido una vista.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteCotizacionVentaVehiculoComparativoGeneralVer(){
	
	if(FncReporteCotizacionVentaVehiculoComparativoGeneralValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
		var Vista = $("#CmpVista").val();
		
		$('#CapReporteCotizacionVentaVehiculoComparativoGeneral').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCotizacionVentaVehiculoComparativoGeneral.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Vista="+Vista,
			success: function(html){
				$('#CapReporteCotizacionVentaVehiculoComparativoGeneral').html(html);	
			}
		});

	}

}


function FncReporteCotizacionVentaVehiculoComparativoGeneralImprimir(){
	
	if(FncReporteCotizacionVentaVehiculoComparativoGeneralValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
var Vista = $("#CmpVista").val();

		FncPopUp("formularios/Reporte/IfrReporteCotizacionVentaVehiculoComparativoGeneral.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Vista="+Vista+"&P=1");
	
	}

}

function FncReporteCotizacionVentaVehiculoComparativoGeneralGenerarExcel(){
	
	if(FncReporteCotizacionVentaVehiculoComparativoGeneralValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
		var Vista = $("#CmpVista").val();
		
		
		FncPopUp("formularios/Reporte/XLSReporteCotizacionVentaVehiculoComparativoGeneral.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Vista="+Vista+"&P=2");
		
	}
	
}

function FncReporteCotizacionVentaVehiculoComparativoGeneralNuevo(){

}
