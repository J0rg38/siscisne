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



function FncReporteCotizacionVehiculoVentaComparativoValidar(){
	
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

function FncReporteCotizacionVehiculoVentaComparativoVer(){
	
	if(FncReporteCotizacionVehiculoVentaComparativoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
		var Vista = $("#CmpVista").val();
		
		$('#CapReporteCotizacionVehiculoVentaComparativo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCotizacionVehiculoVentaComparativo.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Vista="+Vista,
			success: function(html){
				$('#CapReporteCotizacionVehiculoVentaComparativo').html(html);	
			}
		});

	}

}


function FncReporteCotizacionVehiculoVentaComparativoImprimir(){
	
	if(FncReporteCotizacionVehiculoVentaComparativoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
var Vista = $("#CmpVista").val();

		FncPopUp("formularios/Reporte/IfrReporteCotizacionVehiculoVentaComparativo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Vista="+Vista+"&P=1");
	
	}

}

function FncReporteCotizacionVehiculoVentaComparativoGenerarExcel(){
	
	if(FncReporteCotizacionVehiculoVentaComparativoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
		var Vista = $("#CmpVista").val();
		
		
		FncPopUp("formularios/Reporte/XLSReporteCotizacionVehiculoVentaComparativo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&Vista="+Vista+"&P=2");
		
	}
	
}

function FncReporteCotizacionVehiculoVentaComparativoNuevo(){

}
