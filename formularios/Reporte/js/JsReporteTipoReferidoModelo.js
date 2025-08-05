// JavaScript Document
function FncReporteTipoReferidoModeloValidar(){
	
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

function FncReporteTipoReferidoModeloVer(){
	
	if(FncReporteTipoReferidoModeloValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		$('#CapReporteTipoReferidoModelo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteTipoReferidoModelo.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista,
			success: function(html){
				$('#CapReporteTipoReferidoModelo').html(html);	
			}
		});

	}

}


function FncReporteTipoReferidoModeloImprimir(){
	
	if(FncReporteTipoReferidoModeloValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();

		FncPopUp("formularios/Reporte/IfrReporteTipoReferidoModelo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=1");
	
	}

}

function FncReporteTipoReferidoModeloGenerarExcel(){
	
	if(FncReporteTipoReferidoModeloValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Vista = $("#CmpVista").val();
		
		FncPopUp("formularios/Reporte/XLSReporteTipoReferidoModelo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Vista="+Vista+"&P=2");
		
	}
	
}

function FncReporteTipoReferidoModeloNuevo(){

}
