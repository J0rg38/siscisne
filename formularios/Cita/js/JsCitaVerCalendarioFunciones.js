// JavaScript Document

$().ready(function() {
	
	FncCitaVerCalendarioVer();
	
	$('#BtnVer').on('click', function() {
		FncCitaVerCalendarioVer();
	});

	$('#BtnImprimir').on('click', function() {
		FncCitaVerCalendarioImprimir();
	});

	$('#BtnExcel').on('click', function() {
		FncCitaVerCalendarioGenerarExcel();
	});

});



function FncCitaVerCalendarioValidar(){
	
	console.log("FncCitaVerCalendarioValidar");
	
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




function FncCitaVerCalendarioVer(){
	
	console.log("FncCitaVerCalendarioVer");
	
	if(FncCitaVerCalendarioValidar()){
			
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
			
		$('#CapCitaVerCalendario').html("Cargando...");	
		//$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		//$('#CapCitaVerCalendario').html(html);	
		
		$.ajax({
			type: 'GET',
			url: 'formularios/Cita/IfrCitaVerCalendario.php',
			data: 'FechaInicio='+FechaInicio+'&FechaFin='+FechaFin+'&Sucursal='+Sucursal,
			success: function(html){
			
				$('.error').text("Listo").fadeIn(400).delay(1500).fadeOut(400);
				$('#CapCitaVerCalendario').html(html);	
				
			}
		});

	}

}


function FncCitaVerCalendarioImprimir(oIndice){
	
	if(FncCitaVerCalendarioValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		
		FncPopUp("formularios/Cita/IfrCitaVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+'&Sucursal='+Sucursal+"&P=1");
		
	}

}

function FncCitaVerCalendarioGenerarExcel(oIndice){
	
	if(FncCitaVerCalendarioValidar()){
		
		var FechaInicio = $("#CmpFechaInicio").val();
		var FechaFin = $("#CmpFechaFin").val();
		var Sucursal = $("#CmpSucursal").val();
		
//		FncPopUp("formularios/Producto/IfrCitaVerCalendario.php?ProductoCodigoOriginal="+ProductoCodigoOriginal+"&P=2");
		FncPopUp("formularios/Cita/IfrCitaVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+'&Sucursal='+Sucursal+"&P=2");
		
	}
	
}



function FncCitaVerCalendarioNuevo(){
				
}





