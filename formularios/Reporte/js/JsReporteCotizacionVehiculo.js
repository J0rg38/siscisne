// JavaScript Document
function FncReporteCotizacionVehiculoValidar(){
	
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

function FncReporteCotizacionVehiculoVer(){
	
	if(FncReporteCotizacionVehiculoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();
		
		$('#CapReporteCotizacionVehiculo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCotizacionVehiculo.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&Personal="+Personal,
			success: function(html){
				$('#CapReporteCotizacionVehiculo').html(html);	
			}
		});

	}

}


function FncReporteCotizacionVehiculoImprimir(){
	
	if(FncReporteCotizacionVehiculoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
var Personal = $("#CmpPersonal").val();

		FncPopUp("formularios/Reporte/IfrReporteCotizacionVehiculo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&Personal="+Personal+"&P=1");
	
	}

}

function FncReporteCotizacionVehiculoGenerarExcel(){
	
	if(FncReporteCotizacionVehiculoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();
		
		FncPopUp("formularios/Reporte/XLSReporteCotizacionVehiculo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&Personal="+Personal+"&P=2");
		
	}
	
}

function FncReporteCotizacionVehiculoNuevo(){

}
