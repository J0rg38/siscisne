// JavaScript Document
function FncReporteFacturacionVehiculoCostoValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var CostoDetalle = $("#CmpCostoDetalle").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	
	}
	
	return respuesta;
	
}

function FncReporteFacturacionVehiculoCostoVer(){
	
	if(FncReporteFacturacionVehiculoCostoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var CostoDetalle = $("#CmpCostoDetalle").val();
		
		$('#CapReporteFacturacionVehiculoCosto').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteFacturacionVehiculoCosto.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&CostoDetalle="+CostoDetalle,
			success: function(html){
				$('#CapReporteFacturacionVehiculoCosto').html(html);	
			}
		});

	}

}


function FncReporteFacturacionVehiculoCostoImprimir(){
	
	if(FncReporteFacturacionVehiculoCostoValidar()){

		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var CostoDetalle = $("#CmpCostoDetalle").val();

		FncPopUp("formularios/Reporte/IfrReporteFacturacionVehiculoCosto.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&CostoDetalle="+CostoDetalle+"&P=1");
	
	}

}

function FncReporteFacturacionVehiculoCostoGenerarExcel(){
	
	if(FncReporteFacturacionVehiculoCostoValidar()){
		
			var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var CostoDetalle = $("#CmpCostoDetalle").val();
		
		FncPopUp("formularios/Reporte/XLSReporteFacturacionVehiculoCosto.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&CostoDetalle="+CostoDetalle+"&P=2");
		
	}
	
}

function FncReporteFacturacionVehiculoCostoNuevo(){

}
