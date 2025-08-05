// JavaScript Document

$().ready(function() {
	
	FncEntregaVentaVehiculoVerCalendarioVer();
	
	$('#BtnVer').on('click', function() {
		FncEntregaVentaVehiculoVerCalendarioVer();
	});

	$('#BtnImprimir').on('click', function() {
		FncEntregaVentaVehiculoVerCalendarioImprimir();
	});

	$('#BtnExcel').on('click', function() {
		FncEntregaVentaVehiculoVerCalendarioGenerarExcel();
	});

});



function FncEntregaVentaVehiculoVerCalendarioValidar(){
	
	console.log("FncEntregaVentaVehiculoVerCalendarioValidar");
	
	var respuesta = true
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	var Sucursal = $("#CmpSucursal").val();
	
	if(FechaInicio==""){
		alert("No ha ingresado la fecha de inicio.");
		respuesta = false;
	}else if(FechaFin==""){
		alert("No ha ingresado la fecha de termino.");
		respuesta = false;	
	}else if(Sucursal==""){
		alert("No ha escogido una sucursal.");
		respuesta = false;		
	}else{
		 respuesta = true
	}
	
	return respuesta;
	
}




function FncEntregaVentaVehiculoVerCalendarioVer(){
	
	console.log("FncEntregaVentaVehiculoVerCalendarioVer");
	
	if(FncEntregaVentaVehiculoVerCalendarioValidar()){
			
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		$('#CapEntregaVentaVehiculoVerCalendario').html("Cargando...");	
		//$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		//$('#CapEntregaVentaVehiculoVerCalendario').html(html);	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/EntregaVentaVehiculo/IfrEntregaVentaVehiculoVerCalendario.php',
			data: 'FechaInicio='+FechaInicio+'&FechaFin='+FechaFin+'&Sucursal='+Sucursal,
			success: function(html){
			
				$('.error').text("Listo").fadeIn(400).delay(1500).fadeOut(400);
				$('#CapEntregaVentaVehiculoVerCalendario').html(html);	
				
			}
		});

	}

}


function FncEntregaVentaVehiculoVerCalendarioImprimir(oIndice){
	
	if(FncEntregaVentaVehiculoVerCalendarioValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();

		FncPopUp("formularios/EntregaVentaVehiculo/IfrEntregaVentaVehiculoVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=1");
		
	}

}

function FncEntregaVentaVehiculoVerCalendarioGenerarExcel(oIndice){
	
	if(FncEntregaVentaVehiculoVerCalendarioValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();	
		
//		FncPopUp("formularios/Producto/IfrEntregaVentaVehiculoVerCalendario.php?ProductoCodigoOriginal="+ProductoCodigoOriginal+"&P=2");
		FncPopUp("formularios/EntregaVentaVehiculo/IfrEntregaVentaVehiculoVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&Sucursal="+Sucursal+"&P=2");
		
	}
	
}



function FncEntregaVentaVehiculoVerCalendarioNuevo(){
				
}





