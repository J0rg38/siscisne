// JavaScript Document
function FncReporteCotizacionVehiculoAnualValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Ano = $("#CmpAno").val();
	var Mes = $("#CmpMes").val();
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
	}else if(Ano==""){
		alert("No ha escogido un año.");
		respuesta = false;
	/*}else if(Mes==""){
		alert("No ha escogido un mes.");
		respuesta = false;*/
	}else if(Sucursal==""){
		alert("No ha escogido una sucursal.");
		respuesta = false;
	}else if(Vista==""){
		alert("No ha escogido una vista.");
		respuesta = false;
	
	}
	
	return respuesta;
	
}

function FncReporteCotizacionVehiculoAnualVer(){
	
	if(FncReporteCotizacionVehiculoAnualValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();	
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();

		$('#CapReporteCotizacionVehiculoAnual').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCotizacionVehiculoAnual.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Ano="+Ano+"&Mes="+Mes+"&Vista="+Vista+"&Personal="+Personal,
			success: function(html){
				$('#CapReporteCotizacionVehiculoAnual').html(html);	
			}
		});

	}

}


function FncReporteCotizacionVehiculoAnualImprimir(){
	
	if(FncReporteCotizacionVehiculoAnualValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();
		
		FncPopUp("formularios/Reporte/IfrReporteCotizacionVehiculoAnual.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Ano="+Ano+"&Mes="+Mes+"&Vista="+Vista+"&Personal="+Personal+"&P=1");
	
	}

}

function FncReporteCotizacionVehiculoAnualGenerarExcel(){
	
	if(FncReporteCotizacionVehiculoAnualValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Vista = $("#CmpVista").val();
		var Personal = $("#CmpPersonal").val();
		
		FncPopUp("formularios/Reporte/XLSReporteCotizacionVehiculoAnual.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Ano="+Ano+"&Mes="+Mes+"&Vista="+Vista+"&Personal="+Personal+"&P=2");
		
	}
	
}

function FncReporteCotizacionVehiculoAnualNuevo(){

}
