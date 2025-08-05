// JavaScript Document

/*
*** EVENTOS
*/	
$().ready(function() {

	$("#CmpPrecio").keyup(function () {  
		FncOrdenVentaVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpDescuento").keyup(function () {  
		FncOrdenVentaVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpTotal").keyup(function () {  
		FncOrdenVentaVehiculoDetalleCalcularDescuento();
	}); 
	
});



function FncOrdenVentaVehiculoDetalleNuevo(){
	
	$("#CmpVehiculoIngresoId").val("");
	
	$("#CmpVehiculoIngresoVIN").val("");
	
	//$("#CmpVehiculoMarca").html("");
	//$("#CmpVehiculoModelo").html("");
	//$("#CmpVehiculoVersion").html("");
	
	$("#CmpVehiculoColor").val("");
	$("#CmpVehiculoMotor").val("");
	$("#CmpVehiculoAnoFabricacion").val("");
	$("#CmpVehiculoAnoModelo").val("");
	
	$("#CmpPrecio").val("");
	$("#CmpDescuento").val("");
	$("#CmpPrecioCierre").val("");
	$("#CmpTotal").val("");
	
	$("#CmpVehiculoIngresoVIN").attr('readonly', false);
	
	$("#CmpVehiculoColor").attr('readonly', false);
	$("#CmpVehiculoMotor").attr('readonly', false);
	$("#CmpVehiculoAnoFabricacion").attr('readonly', false);
	$("#CmpVehiculoAnoModelo").attr('readonly', false);
	
//	$("#CmpVehiculoMarca").attr('disabled', false);
//	$("#CmpVehiculoModelo").attr('disabled', false);
//	$("#CmpVehiculoVersion").attr('disabled', false);
		
	//$("#CmpVehiculoColor").attr('readonly', false);
	//$("#CmpVehiculoAnoModelo").attr('readonly', false);

	/*
	* POPUP REGISTRAR/EDITAR
	*/	
//	$("#BtnVehiculoIngresoEditar").hide();
//	$("#BtnVehiculoIngresoRegistrar").show();
		
}


function FncOrdenVentaVehiculoDetalleCalcularTotal(){

	var Precio  = $("#CmpPrecio").val().replace(",", "");
	var Descuento = $("#CmpDescuento").val().replace(",", "");
	
	var BonoGM = $("#CmpBonoGM").val().replace(",", "");
	var BonoDealer = $("#CmpBonoDealer").val().replace(",", "");
	var DescuentoGerencia = $("#CmpDescuentoGerencia").val().replace(",", "");
	
	var PrecioMinimo = $("#CmpPrecioMinimo").val();
	var PrecioCierre  = $("#CmpPrecioCierre").val();
	var Total = 0;

	if(Precio == ""){
		Precio = 0;
	}

	if(Descuento == ""){
		Descuento = 0;
	}


	if(BonoGM == ""){
		BonoGM = 0;
	}

	if(BonoDealer == ""){
		BonoDealer = 0;
	}

	if(DescuentoGerencia == ""){
		DescuentoGerencia = 0;
	}


	if(PrecioMinimo == ""){
		PrecioMinimo = 0;
	}
	
	if(PrecioCierre == ""){
		PrecioCierre = 0;
	}

	//PrecioMinimo = PrecioMinimo.replace(",", "");
	//PrecioCierre  = PrecioCierre.replace(",", "");
//alert(Descuento);
	Total = Precio - Descuento- BonoGM - BonoDealer - DescuentoGerencia;

	if(PrecioCierre <= Total){
		$("#CmpTotal").val(Total);
	}else{
		$("#CmpTotal").val(0);
		alert("El total no puede ser menor al PRECIO CIERRE");	
	}


}



function FncOrdenVentaVehiculoDetalleCalcularDescuento(){

	var Precio  = $("#CmpPrecio").val().replace(",", "");
	var Total = $("#CmpTotal").val().replace(",", "");
	var PrecioCierre  = $("#CmpPrecioCierre").val().replace(",", "");
	var PrecioLista  = $("#CmpPrecioLista").val().replace(",", "");
	var Descuento = 0;

	if(Precio == ""){
		Precio = 0;
	}

	if(Total == ""){
		Total = 0;
	}

	if(Precio==0){
		
	}else{
		Descuento = Precio - Total ;
	}
	
	

	$("#CmpDescuento").val(Descuento);

}

