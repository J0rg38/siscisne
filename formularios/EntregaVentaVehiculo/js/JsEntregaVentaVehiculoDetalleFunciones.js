// JavaScript Document

/*
*** EVENTOS
*/	
$().ready(function() {

	
});



function FncEntregaVentaVehiculoDetalleNuevo(){
	
	$("#CmpVehiculoIngresoId").val("");
	
	$("#CmpVehiculoIngresoVIN").val("");
	
	//$("#CmpVehiculoMarca").html("");
	$("#CmpVehiculoModelo").html("");
	$("#CmpVehiculoVersion").html("");
	
	$("#VehiculoIngresoColor").val("");
	
	$("#CmpPrecio").val("");
	$("#CmpOrdenVentaVehiculoDescuento").val("");
	$("#CmpPrecioCierre").val("");
	$("#CmpOrdenVentaVehiculoTotal").val("");
	
	
		
	$("#CmpVehiculoIngresoVIN").attr('readonly', false);
	
	$("#CmpVehiculoMarca").attr('disabled', false);
	$("#CmpVehiculoModelo").attr('disabled', false);
	$("#CmpVehiculoVersion").attr('disabled', false);
		
	$("#VehiculoIngresoColor").attr('readonly', false);
	$("#CmpOrdenVentaVehiculoAnoModelo").attr('readonly', false);



	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnVehiculoIngresoEditar").hide();
	$("#BtnVehiculoIngresoRegistrar").show();
		
}


function FncEntregaVentaVehiculoDetalleCalcularTotal(){

	var Precio  = $("#CmpPrecio").val().replace(",", "");
	var Descuento = $("#CmpOrdenVentaVehiculoDescuento").val().replace(",", "");
	
	var BonoGM = $("#CmpBonoGM").val().replace(",", "");
	var BonoDealer = $("#CmpBonoDealer").val().replace(",", "");
	var DescuentoGerencia = $("#CmpOrdenVentaVehiculoDescuentoGerencia").val().replace(",", "");
	
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
		$("#CmpOrdenVentaVehiculoTotal").val(Total);
	}else{
		$("#CmpOrdenVentaVehiculoTotal").val(0);
		alert("El total no puede ser menor al PRECIO CIERRE");	
	}


}



function FncEntregaVentaVehiculoDetalleCalcularDescuento(){

	var Precio  = $("#CmpPrecio").val().replace(",", "");
	var Total = $("#CmpOrdenVentaVehiculoTotal").val().replace(",", "");
	var PrecioCierre  = $("#CmpPrecioCierre").val().replace(",", "");
	var PrecioLista  = $("#CmpPrecioLista").val().replace(",", "");
	var Descuento = 0;

	if(Precio == ""){
		Precio = 0;
	}

	if(Total == ""){
		Total = 0;
	}

	Descuento = Precio - Total ;

	$("#CmpOrdenVentaVehiculoDescuento").val(Descuento);

}

