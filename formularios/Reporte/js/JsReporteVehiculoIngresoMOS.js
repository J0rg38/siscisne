// JavaScript Document
function FncReporteVehiculoIngresoMOSValidar(){
	
	var respuesta = true
	var Ano = $("#CmpAno").val();
	var Mes = $("#CmpMes").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	
	if(Ano==""){
		alert("No ha escogido un año.");
		respuesta = false;
	}else if(Mes==""){
		alert("No ha escogido un mes.");
		respuesta = false;
	}else if(VehiculoMarca==""){
		alert("No ha escogido una marca de vehiculo.");
		respuesta = false;
	//}else if(Sucursal==""){
	//	alert("No ha escogido una sucursal.");
	//	respuesta = false;
	
	}
	
	return respuesta;
	
}

function FncReporteVehiculoIngresoMOSVer(){
	
	if(FncReporteVehiculoIngresoMOSValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		$('#CapReporteVehiculoIngresoMOS').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteVehiculoIngresoMOS.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca,
			success: function(html){
				$('#CapReporteVehiculoIngresoMOS').html(html);	
			}
		});

	}

}


function FncReporteVehiculoIngresoMOSImprimir(){
	
	if(FncReporteVehiculoIngresoMOSValidar()){

		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/IfrReporteVehiculoIngresoMOS.php?Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=1");
	
	}

}

function FncReporteVehiculoIngresoMOSGenerarExcel(){
	
	if(FncReporteVehiculoIngresoMOSValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/XLSReporteVehiculoIngresoMOS.php?Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=2");
		
	}
	
}

function FncReporteVehiculoIngresoMOSNuevo(){

}
