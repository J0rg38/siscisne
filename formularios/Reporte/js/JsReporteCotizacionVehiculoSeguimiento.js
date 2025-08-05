// JavaScript Document
function FncReporteCotizacionVehiculoSeguimientoValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Vista = $("#CmpVista").val();
	
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

function FncReporteCotizacionVehiculoSeguimientoVer(){
	
	if(FncReporteCotizacionVehiculoSeguimientoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		$('#CapReporteCotizacionVehiculoSeguimiento').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCotizacionVehiculoSeguimiento.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista,
			success: function(html){
				$('#CapReporteCotizacionVehiculoSeguimiento').html(html);	
			}
		});

	}

}


function FncReporteCotizacionVehiculoSeguimientoImprimir(){
	
	if(FncReporteCotizacionVehiculoSeguimientoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();

		FncPopUp("formularios/Reporte/IfrReporteCotizacionVehiculoSeguimiento.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=1");
	
	}

}

function FncReporteCotizacionVehiculoSeguimientoGenerarExcel(){
	
	if(FncReporteCotizacionVehiculoSeguimientoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		FncPopUp("formularios/Reporte/XLSReporteCotizacionVehiculoSeguimiento.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=2");
		
	}
	
}

function FncReporteCotizacionVehiculoSeguimientoNuevo(){

}
