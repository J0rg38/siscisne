// JavaScript Document



$().ready(function() {
	
	//FncCitaVerCalendarioVer();
	
	$('#BtnVer').on('click', function() {
		FncCitaVerCalendarioVer();
	});

	//$('#BtnImprimir').on('click', function() {
//		FncCitaVerCalendarioImprimir();
//	});
//
//	$('#BtnExcel').on('click', function() {
//		FncCitaVerCalendarioGenerarExcel();
//	});

});



function FncCitaVerCalendarioValidar(){
	
	var respuesta = true
	//var FechaInicio = $("#CmpFechaInicio").val();
//	var FechaFin = $("#CmpFechaFin").val();
//	
//	if(FechaInicio==""){
//		alert("No ha ingresado la fecha de inicio.");
//		respuesta = false;
//	}else if(FechaFin==""){
//		alert("No ha ingresado la fecha de termino.");
//		respuesta = false;		
//	}
	
	return respuesta;
	
}

function FncCitaVerCalendarioVer(){
	
	if(FncCitaVerCalendarioValidar()){
		
		var PersonalMecanico = $("#CmpPersonalMecanico").val();
		var Personal = $("#CmpPersonal").val();
		var Sucursal = $("#CmpSucursal").val();
		
		$('.error').text("Cargando informacion...").fadeIn(400).delay(2000).fadeOut(400);
		
		//init(oPersonal,oPersonalMecanico,oSucursal,oDate)
		init(Personal,PersonalMecanico,Sucursal,FechaHoy);
	
	}

}

//
//function FncCitaVerCalendarioImprimir(oIndice){
//	
//	if(FncCitaVerCalendarioValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//
//		FncPopUp("formularios/Cita/IfrCitaVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=1");
//		
//	}
//
//}
//
//function FncCitaVerCalendarioGenerarExcel(oIndice){
//	
//	if(FncCitaVerCalendarioValidar()){
//		
//		var FechaInicio = $("#CmpFechaInicio").val();
//		var FechaFin = $("#CmpFechaFin").val();
//	
////		FncPopUp("formularios/Producto/IfrCitaVerCalendario.php?ProductoCodigoOriginal="+ProductoCodigoOriginal+"&P=2");
//		FncPopUp("formularios/Cita/IfrCitaVerCalendario.php?FechaInicio="+FechaInicio+"&FechaFin="+FechaFin+"&P=2");
//		
//	}
//	
//}
//
//
//
//function FncCitaVerCalendarioNuevo(){
//				
//}
//


function FncCitaBuscar(oTest){
	
}

