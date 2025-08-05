// JavaScript Document


/*
* Funciones complementarias
*/
$().ready(function() {

	

	$('#CmpSucursal').on('change', function() {
	
		FncPersonalesCargar();	
	
	});

});
	
	
function FncReporteOrdenVentaVehiculoPagoValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Personal = $("#CmpPersonal").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	//}else if(VehiculoMarca==""){
//		alert("No ha escogido una marca de vehiculo.");
//		respuesta = false;
	//}else if(Sucursal==""){
	//	alert("No ha escogido una sucursal.");
	//	respuesta = false;
	
	}
	
	return respuesta;
	
}

function FncReporteOrdenVentaVehiculoPagoVer(){
	
	if(FncReporteOrdenVentaVehiculoPagoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
		
		$('#CapReporteOrdenVentaVehiculoPago').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculoPago.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculoPago').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoPagoImprimir(){
	
	if(FncReporteOrdenVentaVehiculoPagoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();

		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculoPago.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoPagoGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoPagoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Personal = $("#CmpPersonal").val();
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculoPago.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Personal="+Personal+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoPagoNuevo(){

}
