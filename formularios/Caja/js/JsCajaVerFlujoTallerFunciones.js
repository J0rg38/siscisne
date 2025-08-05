// JavaScript Document


$().ready(function() {

	$('#BtnVer').on('click', function() {
		if(FncCajaVerFlujoTallerValidar()){
			FncCajaVerFlujoTallerVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncCajaVerFlujoTallerValidar()){
			FncCajaVerFlujoTallerImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncCajaVerFlujoTallerValidar()){
			FncCajaVerFlujoTallerGenerarExcel('');
		}
	});

});



function FncCajaVerFlujoTallerValidar(){
	
	var respuesta = true
	
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = $("#CmpMoneda").val();
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

function FncCajaVerFlujoTallerVer(){
	
	if(FncCajaVerFlujoTallerValidar()){
		
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = $("#CmpMoneda").val();
	var Sucursal = $("#CmpSucursal").val();
		
		
		$('#CapCaja').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Caja/IfrCajaVerFlujoTaller.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapCaja').html(html);	
			}
		});

	}

}

function FncCajaVerFlujoTallerImprimir(){
	
	if(FncCajaVerFlujoTallerValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/Caja/IfrCajaVerFlujoTaller.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncCajaVerFlujoTallerGenerarExcel(){
	
	if(FncCajaVerFlujoTallerValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/Caja/XLSCajaResumen.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncCajaVerFlujoTallerNuevo(){

}
