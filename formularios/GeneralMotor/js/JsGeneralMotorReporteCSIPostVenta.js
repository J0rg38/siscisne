// JavaScript Document
function FncGeneralMotorReporteCSIPostVentaValidar(){
	
	var respuesta = true
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
	//	var Sucursal = $("#CmpSucursal").val();
	
	if(Orden==""){
		alert("Debe escoger un orden.");
		respuesta = false;
	}else if(Sentido==""){
		alert("Debe escoger un sentido.");
		respuesta = false;
	}else if(FechaInicio==""){
		alert("Debe ingresar una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("Debes ingresar una fecha de termino.");
	/*	respuesta = false;
	}else if(Sucursal==""){
		alert("No ha escogido una sucursal.");*/
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncGeneralMotorReporteCSIPostVentaVer(){
	
	if(FncGeneralMotorReporteCSIPostVentaValidar()){
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('#CapGeneralMotorReporteCSIPostVenta').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/GeneralMotor/IfrGeneralMotorReporteCSIPostVenta.php',
			data: 'Orden='+Orden+
			"&Sentido="+Sentido+
			"&FechaInicio="+FechaInicio+
			"&VehiculoMarca="+VehiculoMarca+
			"&FechaFin="+FechaFin+
			"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapGeneralMotorReporteCSIPostVenta').html(html);	
			}
		});

	}

}


function FncGeneralMotorReporteCSIPostVentaImprimir(){
	
	if(FncGeneralMotorReporteCSIPostVentaValidar()){
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/GeneralMotor/IfrGeneralMotorReporteCSIPostVenta.php?Orden="+Orden+"&Sentido="+Sentido+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncGeneralMotorReporteCSIPostVentaGenerarExcel(){
	
	if(FncGeneralMotorReporteCSIPostVentaValidar()){
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
	
		FncPopUp("formularios/GeneralMotor/XLSGeneralMotorReporteCSIPostVenta.php?Orden="+Orden+"&Sentido="+Sentido+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncGeneralMotorReporteCSIPostVentaNuevo(){

}
