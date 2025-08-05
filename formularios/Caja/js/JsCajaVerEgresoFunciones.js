// JavaScript Document
function FncCajaVerEgresoValidar(){
	
	var respuesta = true
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = $("#CmpMoneda").val();
	var Sucursal = $("#CmpSucursal").val();
	var FormaPago = $("#CmpFormaPago").val();
	
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

function FncCajaVerEgresoVer(){
	
	if(FncCajaVerEgresoValidar()){
		
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = $("#CmpMoneda").val();
	var Sucursal = $("#CmpSucursal").val();
	var FormaPago = $("#CmpFormaPago").val();
		
	var IncluirSaldoInicial = "";
		
	if ($('#ChkIncluirSaldoInicial').is(':checked')) {		
		IncluirSaldoInicial = "1";			
	}else{		
		IncluirSaldoInicial = "2";
	}
		
		
		$('#CapCajaVerEgreso').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Caja/IfrCajaVerEgreso.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&FormaPago="+FormaPago+"&IncluirSaldoInicial="+IncluirSaldoInicial,
			success: function(html){
				$('#CapCajaVerEgreso').html(html);	
			}
		});

	}

}

function FncCajaVerEgresoImprimir(){
	
	if(FncCajaVerEgresoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		var FormaPago = $("#CmpFormaPago").val();
		var IncluirSaldoInicial = "";
		
		if ($('#ChkIncluirSaldoInicial').is(':checked')) {		
			IncluirSaldoInicial = "1";			
		}else{		
			IncluirSaldoInicial = "2";
		}
		
		FncPopUp("formularios/Caja/IfrCajaVerEgreso.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&FormaPago="+FormaPago+"&Sucursal="+Sucursal+"&IncluirSaldoInicial="+IncluirSaldoInicial+"&P=1");
		
	}

}

function FncCajaVerEgresoGenerarExcel(){
	
	if(FncCajaVerEgresoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		var FormaPago = $("#CmpFormaPago").val();
		
		var IncluirSaldoInicial = "";
		
		if ($('#ChkIncluirSaldoInicial').is(':checked')) {		
			IncluirSaldoInicial = "1";			
		}else{		
			IncluirSaldoInicial = "2";
		}
		
		
		FncPopUp("formularios/Caja/XLSCajaVerEgreso.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&FormaPago="+FormaPago+"&Sucursal="+Sucursal+"&IncluirSaldoInicial="+IncluirSaldoInicial+"&P=2");
		
	}
	
}

function FncCajaVerEgresoNuevo(){

}
