// JavaScript Document
function FncReporteVentaResumenValidar(){
	
	var respuesta = true
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = "";
	var Sucursal = $("#CmpSucursal").val();
	
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}else if(Moneda==""){
		alert("No ha escogido una moneda.");
		respuesta = false;
	}else if(Sucursal==""){
		alert("No ha escogido una sucursal.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteVentaResumenVer(){
	
	if(FncReporteVentaResumenValidar()){
		
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = "";
	var Sucursal = $("#CmpSucursal").val();
		
		
		$('#CapReporteVentaResumen').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/ReporteVentaResumen/IfrReporteVentaResumenVerResumen.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapReporteVentaResumen').html(html);	
			}
		});

	}

}

function FncReporteVentaResumenImprimir(){
	
	if(FncReporteVentaResumenValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = "";
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/ReporteVentaResumen/IfrReporteVentaResumenVerResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncReporteVentaResumenGenerarExcel(){
	
	if(FncReporteVentaResumenValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = "";
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/ReporteVentaResumen/XLSReporteVentaResumenResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncReporteVentaResumenNuevo(){

}
