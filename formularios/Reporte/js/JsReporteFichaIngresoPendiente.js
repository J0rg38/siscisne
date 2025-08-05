// JavaScript Document


$().ready(function() {

	$('#BtnVer').on('click', function() {
		if(FncReporteFichaIngresoPendienteValidar()){
			FncReporteFichaIngresoPendienteVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncReporteFichaIngresoPendienteValidar()){
			FncReporteFichaIngresoPendienteImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncReporteFichaIngresoPendienteValidar()){
			FncReporteFichaIngresoPendienteGenerarExcel('');
		}
	});

});



function FncReporteFichaIngresoPendienteValidar(){
	
	var respuesta = true
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	
	
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	
	}
	
	return respuesta;
	
}




function FncReporteFichaIngresoPendienteVer(){
	
	if(FncReporteFichaIngresoPendienteValidar()){
		
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	
	var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	
		
		$('#CapReporteFichaIngresoPendiente').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteFichaIngresoPendiente.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Orden="+Orden+"&Sentido="+Sentido,
			success: function(html){
				$('#CapReporteFichaIngresoPendiente').html(html);	
			}
		});

	}

}

function FncReporteFichaIngresoPendienteImprimir(){
	
	if(FncReporteFichaIngresoPendienteValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	
		FncPopUp("formularios/Reporte/IfrReporteFichaIngresoPendiente.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Orden="+Orden+"&Sentido="+Sentido+"&P=1");
		
	}

}

function FncReporteFichaIngresoPendienteGenerarExcel(){
	
	if(FncReporteFichaIngresoPendienteValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = "";
		var Sucursal = $("#CmpSucursal").val();
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		
		var Orden = $("#CmpOrden").val();
	var Sentido = $("#CmpSentido").val();
	
	
		FncPopUp("formularios/Reporte/XLSReporteFichaIngresoPendiente.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&VehiculoMarca="+VehiculoMarca+"&Orden="+Orden+"&Sentido="+Sentido+"&P=2");
		
	}
	
}

function FncReporteFichaIngresoPendienteNuevo(){

}
