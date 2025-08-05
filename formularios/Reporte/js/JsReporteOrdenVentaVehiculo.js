// JavaScript Document
function FncReporteOrdenVentaVehiculoValidar(){
	
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

function FncReporteOrdenVentaVehiculoVer(){
	
	if(FncReporteOrdenVentaVehiculoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		$('#CapReporteOrdenVentaVehiculo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculo.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculo').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoImprimir(){
	
	if(FncReporteOrdenVentaVehiculoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();

		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoNuevo(){

}
