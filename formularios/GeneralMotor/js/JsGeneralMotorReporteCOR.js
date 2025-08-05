// JavaScript Document
function FncGeneralMotorReporteCORValidar(){
	
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

function FncGeneralMotorReporteCORVer(){
	
	if(FncGeneralMotorReporteCORValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('#CapGeneralMotorReporteCOR').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/GeneralMotor/IfrGeneralMotorReporteCOR.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapGeneralMotorReporteCOR').html(html);	
			}
		});

	}

}


function FncGeneralMotorReporteCORImprimir(){
	
	if(FncGeneralMotorReporteCORValidar()){

		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();

		FncPopUp("formularios/GeneralMotor/IfrGeneralMotorReporteCOR.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=1");
	
	}

}

function FncGeneralMotorReporteCORGenerarExcel(){
	
	if(FncGeneralMotorReporteCORValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/GeneralMotor/XLSGeneralMotorReporteCOR.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncGeneralMotorReporteCORNuevo(){

}
