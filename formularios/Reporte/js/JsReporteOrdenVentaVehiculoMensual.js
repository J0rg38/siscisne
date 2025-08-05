// JavaScript Document
function FncReporteOrdenVentaVehiculoMensualValidar(){
	
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
	}else if(Sucursal==""){
		alert("No ha escogido una sucursal.");
	//	respuesta = false;
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteOrdenVentaVehiculoMensualVer(){
	
	if(FncReporteOrdenVentaVehiculoMensualValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		$('#CapReporteOrdenVentaVehiculoMensual').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculoMensual.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculoMensual').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoMensualImprimir(){
	
	if(FncReporteOrdenVentaVehiculoMensualValidar()){

		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculoMensual.php?Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoMensualGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoMensualValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculoMensual.php?Ano="+Ano+"&Mes="+Mes+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoMensualNuevo(){

}
