// JavaScript Document
var MonedaFuncion = "";

/*
Agregando Eventos
*/

function FncMonedaBuscar(oCampo){
	
	var Dato = $('#CmpMoneda'+oCampo).val();	

	if(Dato!=""){
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: Ruta+'comunes/Moneda/acc/AccMonedaBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsMoneda){
			if(InsMoneda.MonId!=""){
				FncMonedaEscoger(InsMoneda.MonId,InsMoneda.MonNombre,InsMoneda.MonSimbolo,InsMoneda.TcaMontoCompra,InsMoneda.TcaMontoVenta);
			}				
			}
		});	
	}
}

function FncMonedaEscoger(oMonedaId,oMonedaNombre,oMonedaSimbolo,oTipoCambioCompra,oTipoCambioVenta){

	$('#CapMonedaBuscar').html("");
	
	$('#CmpMonedaId').val(oMonedaId);
	//$('#CmpTipoCambio').val(oTipoCambioVenta);	
	
	var Moneda = "";
	
	if($('#CmpMonedaNombre').length > 0) {
		$('#CmpMonedaNombre').val(oMonedaNombre);
	}else{
		Moneda = Moneda + '<input size="10" type="hidden" name="CmpMonedaNombre" id="CmpMonedaNombre" value="' +oMonedaNombre +'">';
	}
	
	if($('#CmpMonedaSimbolo').length > 0) {
		$('#CmpMonedaSimbolo').val(oMonedaSimbolo);
	}else{
		Moneda = Moneda + '<input size="10" type="hidden" name="CmpMonedaSimbolo" id="CmpMonedaSimbolo" value="' +oMonedaSimbolo +'">';	
	}
	
	$('#CapMonedaBuscar').html(Moneda);

	FncMonedaFuncion();
	
//	if(MonedaFuncion!=""){
//		eval(MonedaFuncion+"();");		
//	}

}

function FncMonedaFuncion(){

}