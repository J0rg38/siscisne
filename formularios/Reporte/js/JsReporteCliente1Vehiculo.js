// JavaScript Document
var Ventas = "1";
var Libres = "1";

$().ready(function() {

	$('#CmpSucursal').on('change', function() {
	
		//FncPersonalesCargar();	
	
	});
	
	
	$('#BtnVer').on('click', function() {
	
		FncReporteCliente1VehiculoVer();
	
	});
	
	$('#BtnImprimir').on('click', function() {
	
		FncReporteCliente1VehiculoImprimir();
	
	});
	
	$('#BtnExcel').on('click', function() {
	
		FncReporteCliente1VehiculoGenerarExcel();
	
	});

	
/*
* EVENTOS - NAVEGACION
*/		
	
});

function FncReporteCliente1VehiculoValidar(){
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
//	var Personal = $("#CmpPersonal").val();
//	var Moneda = $("#CmpMoneda").val();
//
	if(FechaInicio==""){
		alert("No ha escogido una fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha escogido una fecha fin.");
		respuesta = false;
	}
	
	return respuesta;
	
}

function FncReporteCliente1VehiculoVer(){
	
	if(FncReporteCliente1VehiculoValidar()){
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
	
		$('#CapReporteCliente1Vehiculo').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Reporte/IfrReporteCliente1Vehiculo.php',
			data: "Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin,
			success: function(html){
				$('#CapReporteCliente1Vehiculo').html(html);	
			}
		});

	}

}


function FncReporteCliente1VehiculoImprimir(){
	
	if(FncReporteCliente1VehiculoValidar()){

		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
	
		FncPopUp("formularios/Reporte/IfrReporteCliente1Vehiculo.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=1");
	
	}

}

function FncReporteCliente1VehiculoGenerarExcel(){
	
	if(FncReporteCliente1VehiculoValidar()){
		
		
		var Sucursal = $("#CmpSucursal").val();
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		
		FncPopUp("formularios/Reporte/XLSReporteCliente1Vehiculo.php?Sucursal="+Sucursal+"&FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=2");
		
	}
	
}

function FncReporteCliente1VehiculoNuevo(){

}
