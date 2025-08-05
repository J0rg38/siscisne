// JavaScript Document
function FncGeneralMotorReporteCOSDiarioValidar(){
	
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

function FncGeneralMotorReporteCOSDiarioVer(){
	
	if(FncGeneralMotorReporteCOSDiarioValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('#CapGeneralMotorReporteCOSDiario').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/GeneralMotor/IfrGeneralMotorReporteCOSDiario.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapGeneralMotorReporteCOSDiario').html(html);	
			}
		});

	}

}


function FncGeneralMotorReporteCOSDiarioImprimir(){
	
	if(FncGeneralMotorReporteCOSDiarioValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
			
		FncPopUp("formularios/GeneralMotor/IfrGeneralMotorReporteCOSDiario.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncGeneralMotorReporteCOSDiarioGenerarExcel(){
	
	if(FncGeneralMotorReporteCOSDiarioValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
	
		FncPopUp("formularios/GeneralMotor/XLSGeneralMotorReporteCOSDiario.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncGeneralMotorReporteCOSDiarioNuevo(){

}
