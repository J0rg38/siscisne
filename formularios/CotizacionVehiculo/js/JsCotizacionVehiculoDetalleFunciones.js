// JavaScript Document

/*
*** EVENTOS
*/	
$().ready(function() {


/*
* MODELO 1
*/

	$("#CmpCantidad").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpPrecio").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpDescuento").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpTotal").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularDescuento();
	}); 
	

/*
* MODELO 2
*/
	$("#CmpCantidad2").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularTotal2();
	}); 
	
	$("#CmpPrecio2").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularTotal2();
	}); 
	
	$("#CmpDescuento2").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularTotal2();
	}); 
	
	$("#CmpTotal2").keyup(function () {  
		FncCotizacionVehiculoDetalleCalcularDescuento2();
	}); 
	
	
	
});	
	
	
	
/*
*  MODELO 1
*/
	
function FncCotizacionVehiculoDetalleNuevo(){
	
	$("#CmpVehiculoModelo").html("");
	$("#CmpVehiculoVersion").html("");
	
	$("#CmpColor").val("");
	
	$("#CmpCantidad").val("1");
	$("#CmpPrecio").val("");
	$("#CmpDescuento").val("");
	$("#CmpPrecioCierre").val("");
	$("#CmpTotal").val("");
	
	$("#CmpAnoFabricacion").val("");
	$("#CmpAnoModelo").val("");
	
}


function FncCotizacionVehiculoDetalleCalcularTotal(){

	var Precio  = $("#CmpPrecio").val().replace(",", "");
	var Cantidad  = $("#CmpCantidad").val().replace(",", "");
	
	var Descuento = $("#CmpDescuento").val().replace(",", "");
	var PrecioCierre  = $("#CmpPrecioCierre").val().replace(",", "");
	
	var Total = 0;

	if(Precio == ""){
		Precio = 0;
	}

	if(Descuento == ""){
		Descuento = 0;
	}
	
	if(Cantidad == ""){
		Cantidad = 0;
	}

	Total = (Precio * Cantidad) - Descuento;
	
	if(PrecioCierre <= Total){
		$("#CmpTotal").val(Total);
	}else{
		$("#CmpTotal").val(0);
		alert("El total no puede ser menor al PRECIO CIERRE");	
	}


}



function FncCotizacionVehiculoDetalleCalcularDescuento(){

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
		Descuento = Precio - Total;
	}
	
	$("#CmpDescuento").val(Descuento);

}


/*
* MODELO 2
*/


function FncCotizacionVehiculoDetalleNuevo2(){
	
	$("#CmpVehiculoModelo2").html("");
	$("#CmpVehiculoVersion2").html("");
	
	$("#CmpColor2").val("");
	
	$("#CmpCantidad2").val("1");
	$("#CmpPrecio2").val("");
	$("#CmpDescuento2").val("");
	$("#CmpPrecioCierre2").val("");
	$("#CmpTotal2").val("");
	
	$("#CmpAnoFabricacion2").val("");
	$("#CmpAnoModelo2").val("");
	
}


function FncCotizacionVehiculoDetalleCalcularTotal2(){

	var Precio  = $("#CmpPrecio2").val().replace(",", "");
	var Cantidad  = $("#CmpCantidad2").val().replace(",", "");
	
	var Descuento = $("#CmpDescuento2").val().replace(",", "");
	var PrecioCierre  = $("#CmpPrecioCierre2").val().replace(",", "");
	
	var Total = 0;

	if(Precio == ""){
		Precio = 0;
	}

	if(Descuento == ""){
		Descuento = 0;
	}
	
	if(Cantidad == ""){
		Cantidad = 0;
	}

	Total = (Precio * Cantidad) - Descuento;
	
	if(PrecioCierre <= Total){
		$("#CmpTotal2").val(Total);
	}else{
		$("#CmpTotal2").val(0);
		alert("El total no puede ser menor al PRECIO CIERRE");	
	}


}



function FncCotizacionVehiculoDetalleCalcularDescuento2(){

	var Precio  = $("#CmpPrecio2").val().replace(",", "");
	var Total = $("#CmpTotal2").val().replace(",", "");
	var PrecioCierre  = $("#CmpPrecioCierre2").val().replace(",", "");
	var PrecioLista  = $("#CmpPrecioLista2").val().replace(",", "");
	var Descuento = 0;

	if(Precio == ""){
		Precio = 0;
	}

	if(Total == ""){
		Total = 0;
	}
	
	if(Precio==0){
		
	}else{
		Descuento = Precio - Total;
	}
	
	$("#CmpDescuento2").val(Descuento);

}






/*
* **
*/


function FncCotizacionVehiculoDetalleEscoger(oIndice,oVehiculoVersionId,oPrecioLista,oPrecioCierre,oColor,oVehiculoIngresoId,oAnoModelo,oFechaVigencia,oAnoFabricacion){

	$('#CmpVehiculoVersion').val(oVehiculoVersionId);

	$('#CmpPrecio').val(oPrecioLista);
	$('#CmpTotal').val(oPrecioLista);

	
	$('#CmpDescuento').val("0");
	$('#CmpPrecioLista').val(oPrecioLista);
	$('#CmpPrecioCierre').val(oPrecioCierre);

	//$('#CmpColor').val(oColor);
	//$('#CmpVehiculoIngreso').val(oVehiculoIngresoId);
	
	//$('#CmpAnoModelo').val(oAnoModelo);
	//$('#CmpAnoFabricacion').val(oAnoFabricacion);
	
	/*if(oFechaVigencia!=""){
		$('#CmpFechaVigencia').val(oFechaVigencia);		
	}*/

	var c = 1;
	$('input[type=radio]').each(function () {
		if($(this).attr('name')=="RbuVehiculoIngreso"){

			if($(this).is(":checked")) {
				$('#Fila_'+c).css('background-color', '#FFCC00');
			}else{
				$('#Fila_'+c).css('background-color', '#E6E6E6');
			}
			
			c = c + 1;

		}	
	});











}