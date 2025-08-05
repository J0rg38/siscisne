// JavaScript Document
function FncReporteOrdenVentaVehiculoValidar(){
	
	var respuesta = true
	var Ano = $("#CmpAno").val();
	var Mes = $("#CmpMes").val();
	
	if(Ano==""){
		alert("No ha escogido un año.");
		respuesta = false;
	}else if(Mes==""){
		alert("No ha escogido un mes.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteOrdenVentaVehiculoVer(){
	
	if(FncReporteOrdenVentaVehiculoValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		$('#CapReporteOrdenVentaVehiculo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteOrdenVentaVehiculo.php',
			data: "Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca,
			success: function(html){
				$('#CapReporteOrdenVentaVehiculo').html(html);	
			}
		});

	}

}


function FncReporteOrdenVentaVehiculoImprimir(){
	
	if(FncReporteOrdenVentaVehiculoValidar()){

		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();

		FncPopUp("formularios/Reporte/IfrReporteOrdenVentaVehiculo.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&P=1");
	
	}

}

function FncReporteOrdenVentaVehiculoGenerarExcel(){
	
	if(FncReporteOrdenVentaVehiculoValidar()){
		
		var Ano = $("#CmpAno").val();
		var Mes = $("#CmpMes").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		FncPopUp("formularios/Reporte/XLSReporteOrdenVentaVehiculo.php?Ano="+Ano+"&Mes="+Mes+"&VehiculoMarca="+VehiculoMarca+"&P=2");
		
	}
	
}

function FncReporteOrdenVentaVehiculoNuevo(){

}
