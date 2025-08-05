// JavaScript Document
var Ventas = "1";


$().ready(function() {

	$('#CmpSucursal').on('change', function() {
	
		FncPersonalesCargar();	
	
	});


});



function FncReporteCotizacionVehiculoComparativoValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Vista = $("#CmpVista").val();
	var Personal = $("#CmpPersonal").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}else if(VehiculoMarca==""){
		alert("No ha escogido una marca de vehiculo.");
		respuesta = false;
	}else if(Vista==""){
		alert("No ha escogido una vista.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteCotizacionVehiculoComparativoVer(){
	
	if(FncReporteCotizacionVehiculoComparativoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();
		
		$('#CapReporteCotizacionVehiculoComparativo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCotizacionVehiculoComparativo.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&Personal="+Personal,
			success: function(html){
				$('#CapReporteCotizacionVehiculoComparativo').html(html);	
			}
		});

	}

}


function FncReporteCotizacionVehiculoComparativoImprimir(){
	
	if(FncReporteCotizacionVehiculoComparativoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();

		FncPopUp("formularios/Reporte/IfrReporteCotizacionVehiculoComparativo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&Personal="+Personal+"&P=1");
	
	}

}

function FncReporteCotizacionVehiculoComparativoGenerarExcel(){
	
	if(FncReporteCotizacionVehiculoComparativoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();
		
		FncPopUp("formularios/Reporte/XLSReporteCotizacionVehiculoComparativo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&Personal="+Personal+"&P=2");
		
	}
	
}

function FncReporteCotizacionVehiculoComparativoNuevo(){

}
