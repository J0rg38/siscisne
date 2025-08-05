// JavaScript Document
function FncGeneralMotorReporteCOSIsuzuValidar(){
	
	var respuesta = true
	var Ano = $("#CmpAno").val();
	var Mes = $("#CmpMes").val();
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

function FncGeneralMotorReporteCOSIsuzuVer(){
	
	if(FncGeneralMotorReporteCOSIsuzuValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('#CapGeneralMotorReporteCOSIsuzu').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/GeneralMotor/IfrGeneralMotorReporteCOSIsuzu.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapGeneralMotorReporteCOSIsuzu').html(html);	
			}
		});

	}

}


function FncGeneralMotorReporteCOSIsuzuImprimir(){
	
	if(FncGeneralMotorReporteCOSIsuzuValidar()){

		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();

		FncPopUp("formularios/GeneralMotor/IfrGeneralMotorReporteCOSIsuzu.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=1");

	}

}

function FncGeneralMotorReporteCOSIsuzuGenerarExcel(){
	
	if(FncGeneralMotorReporteCOSIsuzuValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/GeneralMotor/XLSGeneralMotorReporteCOSIsuzu.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncGeneralMotorReporteCOSIsuzuNuevo(){

}
