// JavaScript Document

$().ready(function() {

	$('#BtnVer').on('click', function() {
		if(FncCajaVerEfectivoValidar()){
			FncCajaVerEfectivoVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncCajaVerEfectivoValidar()){
			FncCajaVerEfectivoImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncCajaVerEfectivoValidar()){
			FncCajaVerEfectivoGenerarExcel('');
		}
	});

});



function FncCajaVerEfectivoValidar(){
	
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

function FncCajaVerEfectivoVer(){
	
	if(FncCajaVerEfectivoValidar()){
		
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = $("#CmpMoneda").val();
	var Sucursal = $("#CmpSucursal").val();
	var FormaPago = $("#CmpFormaPago").val();
		
		$('#CapCaja').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Caja/IfrCajaVerEfectivo.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&FormaPago="+FormaPago,
			success: function(html){
				$('#CapCaja').html(html);	
			}
		});

	}

}

function FncCajaVerEfectivoImprimir(){
	
	if(FncCajaVerEfectivoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		var FormaPago = $("#CmpFormaPago").val();
		FncPopUp("formularios/Caja/IfrCajaVerEfectivo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&FormaPago="+FormaPago+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncCajaVerEfectivoGenerarExcel(){
	
	if(FncCajaVerEfectivoValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		var FormaPago = $("#CmpFormaPago").val();
		FncPopUp("formularios/Caja/XLSCajaVerEfectivo.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&FormaPago="+FormaPago+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncCajaVerEfectivoNuevo(){

}
