// JavaScript Document
function FncGeneralMotorReporteIOTPostVentaValidar(){
	
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

function FncGeneralMotorReporteIOTPostVentaVer(){
	
	if(FncGeneralMotorReporteIOTPostVentaValidar()){
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		
		
		$('#CapGeneralMotorReporteIOTPostVenta').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/GeneralMotor/IfrGeneralMotorReporteIOTPostVenta.php',
			data: 'Orden='+Orden+
			"&Sentido="+Sentido+
			"&FechaInicio="+FechaInicio+
			"&VehiculoMarca="+VehiculoMarca+
			"&FechaFin="+FechaFin+
			"&IncluirCSI="+IncluirCSI+
			"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapGeneralMotorReporteIOTPostVenta').html(html);	
			}
		});

	}

}


function FncGeneralMotorReporteIOTPostVentaImprimir(){
	
	if(FncGeneralMotorReporteIOTPostVentaValidar()){
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
		
		FncPopUp("formularios/GeneralMotor/IfrGeneralMotorReporteIOTPostVenta.php?Orden="+Orden+"&Sentido="+Sentido+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&IncluirCSI="+IncluirCSI+"&P=1");
		
	}

}

function FncGeneralMotorReporteIOTPostVentaGenerarExcel(){
	
	if(FncGeneralMotorReporteIOTPostVentaValidar()){
		
		var Orden = $("#CmpOrden").val();
		var Sentido = $("#CmpSentido").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		var IncluirCSI = $("#CmpIncluirCSI").val();
	
		FncPopUp("formularios/GeneralMotor/XLSGeneralMotorReporteIOTPostVenta.php?Orden="+Orden+"&Sentido="+Sentido+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&IncluirCSI="+IncluirCSI+"&P=2");
		
	}
	
}

function FncGeneralMotorReporteIOTPostVentaNuevo(){

}
