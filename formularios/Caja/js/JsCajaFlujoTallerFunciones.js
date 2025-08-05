// JavaScript Document
function FncCajaValidar(){
	
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

function FncCajaVer(){
	
	if(FncCajaValidar()){
		
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Moneda = $("#CmpMoneda").val();
	var Sucursal = $("#CmpSucursal").val();
		
		
		$('#CapCaja').html("Cargando...");	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Caja/IfrCajaVer.php',
			data: "FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal,
			success: function(html){
				$('#CapCaja').html(html);	
			}
		});

	}

}

function FncCajaImprimir(){
	
	if(FncCajaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/Caja/IfrCajaVer.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncCajaGenerarExcel(){
	
	if(FncCajaValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Moneda = $("#CmpMoneda").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/Caja/XLSCaja.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Moneda="+Moneda+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}

function FncCajaNuevo(){

}
