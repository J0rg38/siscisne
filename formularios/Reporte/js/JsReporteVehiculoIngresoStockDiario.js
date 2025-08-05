// JavaScript Document
function FncReporteVehiculoIngresoStockDiarioValidar(){
	
	var respuesta = true
	var Ano = $("#CmpAno").val();
	var Mes = $("#CmpMes").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	
	if(VehiculoMarca==""){
		alert("No ha escogido una marca de vehiculo.");
		respuesta = false;
	//}else if(Sucursal==""){
	//	alert("No ha escogido una sucursal.");
	//	respuesta = false;
	
	}
	
	return respuesta;
	
}

function FncReporteVehiculoIngresoStockDiarioVer(){
	
	if(FncReporteVehiculoIngresoStockDiarioValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		$('#CapReporteVehiculoIngresoStockDiario').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteVehiculoIngresoStockDiario.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca,
			success: function(html){
				$('#CapReporteVehiculoIngresoStockDiario').html(html);	
			}
		});

	}

}


function FncReporteVehiculoIngresoStockDiarioImprimir(){
	
	if(FncReporteVehiculoIngresoStockDiarioValidar()){

		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/IfrReporteVehiculoIngresoStockDiario.php?Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=1");
	
	}

}

function FncReporteVehiculoIngresoStockDiarioGenerarExcel(){
	
	if(FncReporteVehiculoIngresoStockDiarioValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/XLSReporteVehiculoIngresoStockDiario.php?Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=2");
		
	}
	
}

function FncReporteVehiculoIngresoStockDiarioNuevo(){

}
