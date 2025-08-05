// JavaScript Document
function FncGeneralMotorReporteCOSValidar(){
	
	var respuesta = true
	var Ano = $("#CmpAno").val();
	var Mes = $("#CmpMes").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Sucursal = $("#CmpSucursal").val();
	
	if(Ano==""){
		alert("No ha escogido un año.");
		respuesta = false;
	}else if(Mes==""){
		alert("No ha escogido un mes.");
		respuesta = false;
	}else if(Sucursal==""){
		alert("No ha escogido una sucursal.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncGeneralMotorReporteCOSVer(){
	
	if(FncGeneralMotorReporteCOSValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('#CapGeneralMotorReporteCOS').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/GeneralMotor/IfrGeneralMotorReporteCOS.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapGeneralMotorReporteCOS').html(html);	
			}
		});

	}

}


function FncGeneralMotorReporteCOSImprimir(){
	
	if(FncGeneralMotorReporteCOSValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
			
		FncPopUp("formularios/GeneralMotor/IfrGeneralMotorReporteCOS.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncGeneralMotorReporteCOSGenerarExcel(){
	
	if(FncGeneralMotorReporteCOSValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
	
		FncPopUp("formularios/GeneralMotor/XLSGeneralMotorReporteCOS.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncGeneralMotorReporteCOSNuevo(){

}
