// JavaScript Document
function FncGeneralMotorReporteCORIsuzuValidar(){
	
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

function FncGeneralMotorReporteCORIsuzuVer(){
	
	if(FncGeneralMotorReporteCORIsuzuValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('#CapGeneralMotorReporteCORIsuzu').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/GeneralMotor/IfrGeneralMotorReporteCORIsuzu.php',
			data: "Ano="+Ano+"&Mes="+Mes+"=&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapGeneralMotorReporteCORIsuzu').html(html);	
			}
		});

	}

}

function FncGeneralMotorReporteCORIsuzuImprimir(){
	
	if(FncGeneralMotorReporteCORIsuzuValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/GeneralMotor/IfrGeneralMotorReporteCORIsuzu.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncGeneralMotorReporteCORIsuzuGenerarExcel(){
	
	if(FncGeneralMotorReporteCORIsuzuValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/GeneralMotor/XLSGeneralMotorReporteCORIsuzu.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncGeneralMotorReporteCORIsuzuNuevo(){

}
