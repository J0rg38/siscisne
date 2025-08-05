// JavaScript Document
function FncReporteVenta12MesesValidar(){
	
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

function FncReporteVenta12MesesVer(){
	
	if(FncReporteVenta12MesesValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		$('#CapReporteVenta12Meses').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteVenta12Meses.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista,
			success: function(html){
				$('#CapReporteVenta12Meses').html(html);	
			}
		});

	}

}


function FncReporteVenta12MesesImprimir(){
	
	if(FncReporteVenta12MesesValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();

		FncPopUp("formularios/Reporte/IfrReporteVenta12Meses.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=1");
	
	}

}

function FncReporteVenta12MesesGenerarExcel(){
	
	if(FncReporteVenta12MesesValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		FncPopUp("formularios/Reporte/XLSReporteVenta12Meses.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=2");
		
	}
	
}

function FncReporteVenta12MesesNuevo(){

}
