// JavaScript Document

function FncGarantiaOperacionNuevo(){
	
	var MonedaId = $('#CmpMonedaId').val();
	
	var Costo = 0;
	if(EmpresaMonedaId == MonedaId){
		$('#CmpGarantiaOperacionValor').val(CalificacionCosto);
	}else{
		Costo = CalificacionCosto / CalificacionTipoCambio;
		$('#CmpGarantiaOperacionValor').val(Costo);
	}
			
			
	$('#CmpGarantiaOperacionId').val("");

	$('#CmpGarantiaOperacionNumero').val("");
	$('#CmpGarantiaOperacionTiempo').val("");
	//$('#CmpGarantiaOperacionValor').val(CalificacionCosto);
	$('#CmpGarantiaOperacionCosto').val("");
	
	//$('#CmpGarantiaOperacionTransaccionNumero').val("");
//	$('#CmpGarantiaOperacionTransaccionFecha').val("");
//	
//	$('#CmpGarantiaOperacionFechaAprobacion').val("");
//	$('#CmpGarantiaOperacionFechaPago').val("");
//	$('#CmpGarantiaOperacionEstado').val("");
//	$('#CmpGarantiaOperacionComprobanteNumero').val("");
	
	$('#CmpGarantiaOperacionItem').val("");	

	$('#CapGarantiaOperacionAccion').html('Listo para registrar elementos');	
			
	$('#CmpGarantiaOperacionNumero').select();
			
	$('#CmpGarantiaOperacionAccion').val("AccGarantiaOperacionRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncGarantiaOperacionGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpGarantiaOperacionAccion').val();		

	var GarantiaOperacionId = $('#CmpGarantiaOperacionId').val();
	var GarantiaOperacionNumero = $('#CmpGarantiaOperacionNumero').val();			
	var GarantiaOperacionTiempo = $('#CmpGarantiaOperacionTiempo').val();
	var GarantiaOperacionCosto = $('#CmpGarantiaOperacionCosto').val();
	var GarantiaOperacionValor = $('#CmpGarantiaOperacionValor').val();
	
	//var GarantiaOperacionTransaccionNumero = $('#CmpGarantiaOperacionTransaccionNumero').val();
//	var GarantiaOperacionTransaccionFecha = $('#CmpGarantiaOperacionTransaccionFecha').val();
//	
//	var GarantiaOperacionFechaAprobacion = $('#CmpGarantiaOperacionFechaAprobacion').val();
//	var GarantiaOperacionFechaPago = $('#CmpGarantiaOperacionFechaPago').val();
//	
//	var GarantiaOperacionComprobanteNumero = $('#CmpGarantiaOperacionTransaccionNumero').val();
//	
//	var GarantiaOperacionEstado = $('#CmpGarantiaOperacionEstado').val();

	var Item = $('#CmpGarantiaOperacionItem').val();
	
	if(GarantiaOperacionNumero==""){
		$('#CmpGarantiaOperacionNumero').select();
	}else if(GarantiaOperacionTiempo==""){
		$('#CmpGarantiaOperacionTiempo').select();
	}else if(GarantiaOperacionCosto=="" ){
		$('#CmpGarantiaOperacionCosto').select();	
	}else if(GarantiaOperacionValor==""){
		$('#CmpGarantiaOperacionValor').select();	
	}else{
		$('#CapGarantiaOperacionAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/'+Acc,
			data: 'Identificador='+Identificador+
'&GarantiaOperacionId='+GarantiaOperacionId+
'&GarantiaOperacionNumero='+GarantiaOperacionNumero+
'&GarantiaOperacionTiempo='+GarantiaOperacionTiempo+
'&GarantiaOperacionCosto='+GarantiaOperacionCosto+
'&GarantiaOperacionValor='+GarantiaOperacionValor+

//'&GarantiaOperacionTransaccionNumero='+GarantiaOperacionTransaccionNumero+
//'&GarantiaOperacionTransaccionFecha='+GarantiaOperacionTransaccionFecha+
//'&GarantiaOperacionFechaAprobacion='+GarantiaOperacionFechaAprobacion+
//'&GarantiaOperacionFechaPago='+GarantiaOperacionFechaPago+
//'&GarantiaOperacionComprobanteNumero='+GarantiaOperacionComprobanteNumero+
//
//'&GarantiaOperacionEstado='+GarantiaOperacionEstado+

'&Item='+Item,
			success: function(){
				
			$('#CapGarantiaOperacionAccion').html('Listo');							
				FncGarantiaOperacionListar();
			}
		});
		
		FncGarantiaOperacionNuevo();
	}
	
}


function FncGarantiaOperacionListar(){

	var Identificador = $('#Identificador').val();

	$('#CapGarantiaOperacionAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/Garantia/FrmGarantiaOperacionListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+GarantiaOperacionEditar+
'&Eliminar='+GarantiaOperacionEliminar+
'&MonedaId='+MonedaId+
'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapGarantiaOperacionAccion').html('Listo');	
			$("#CapGarantiaOperaciones").html("");
			$("#CapGarantiaOperaciones").append(html);
		}
	});

}



function FncGarantiaOperacionEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapGarantiaOperacionAccion').html('Editando...');
	$('#CmpGarantiaOperacionAccion').val("AccGarantiaOperacionEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/Garantia/acc/AccGarantiaOperacionEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsGarantiaOperacion){

	//SesionObjeto-InsGarantiaOperacion
	//Parametro1 = GopId
	//Parametro2 = GopNumero
	//Parametro3 = GopTiempo
	//Parametro4 = GopValor
	//Parametro5 = GopCosto
	//Parametro6 = GopEstado
	//Parametro7 = GopTiempoCreacion
	//Parametro8 = GopTiempoModificacion
	
	//Parametro9 = GopTransaccionNumero
	//Parametro10 = GopTransaccionFecha
	//Parametro11 = GopFechaAprobacion
	//Parametro12 = GopFechaPago
	//Parametro13 = GopComprobanteNumero
	
			
			$('#CmpGarantiaOperacionNumero').val(InsGarantiaOperacion.Parametro2);	
			$('#CmpGarantiaOperacionTiempo').val(InsGarantiaOperacion.Parametro3);
			$('#CmpGarantiaOperacionCosto').val(InsGarantiaOperacion.Parametro5);
			$('#CmpGarantiaOperacionValor').val(InsGarantiaOperacion.Parametro4);
			
//			$('#CmpGarantiaOperacionTransaccionNumero').val(InsGarantiaOperacion.Parametro9);
//			$('#CmpGarantiaOperacionTransaccionFecha').val(InsGarantiaOperacion.Parametro10);
//			$('#CmpGarantiaOperacionFechaAprobacion').val(InsGarantiaOperacion.Parametro11);
//			$('#CmpGarantiaOperacionFechaPago').val(InsGarantiaOperacion.Parametro12);
//			
//			$('#CmpGarantiaOperacionComprobanteNumero').val(InsGarantiaOperacion.Parametro13);
//			
//			
//			$('#CmpGarantiaOperacionEstado').val(InsGarantiaOperacion.Parametro6);
//			
			$('#CmpGarantiaOperacionItem').val(InsGarantiaOperacion.Item);
			
			$('#CmpGarantiaOperacionNumero').select();
				
		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncGarantiaOperacionEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapGarantiaOperacionAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/AccGarantiaOperacionEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapGarantiaOperacionAccion').html("Eliminado");	
				FncGarantiaOperacionListar();
			}
		});

		FncGarantiaOperacionNuevo();

	}
	
}

function FncGarantiaOperacionEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapGarantiaOperacionAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Garantia/acc/AccGarantiaOperacionEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapGarantiaOperacionAccion').html('Eliminado');	
				FncGarantiaOperacionListar();
			}
		});	
			
		FncGarantiaOperacionNuevo();
	}
	
}













//function FncGarantiaOperacionCalcularCostoMargen(){
//
//	var CostoMargen = 0;
//	var CostoTotal = $('#CmpGarantiaDetalleCostoTotal').val();
//	var Margen = $('#CmpGarantiaDetalleMargen').val();	
//
//	if(CostoTotal!=""){
//		if(Margen!=""){
//			CostoMargen = CostoTotal * Margen;
//			$('#CmpGarantiaDetalleCostoMargen').val(CostoMargen);
//		}else{
//
//		}
//	}else{
//
//	}
//
//}
//



function FncGarantiaOperacionCalcularCosto(){

	var Costo = 0;
	var Tiempo = $('#CmpGarantiaOperacionTiempo').val();
	var Valor = $('#CmpGarantiaOperacionValor').val();	

//alert(Cantidad);

	if(Tiempo!=""){
		if(Valor!=""){
			Costo = Tiempo * Valor;
			$('#CmpGarantiaOperacionCosto').val(Costo);
		}else{

		}
	}else{

	}
}

function FncGarantiaOperacionCalcularTiempo(){

	var Tiempo = 0;
	var Costo = $('#CmpGarantiaOperacionCosto').val();
	var Valor = $('#CmpGarantiaOperacionValor').val();	

//alert(Cantidad);

	if(Costo!=""){
		if(Valor!=""){
			Tiempo = Costo / Valor;
			$('#CmpGarantiaOperacionTiempo').val(Tiempo);
		}else{

		}
	}else{

	}
}

//function FncGarantiaOperacionCalcularValor(){
//
//	var Valor = 0;
//	var Tiempo = $('#CmpGarantiaOperacionTiempo').val();
//	var Costo = $('#CmpGarantiaOperacionCosto').val();	
//
//	if(Tiempo!=""){
//		if(Costo!=""){
//			Valor = Costo / Tiempo;
//			$('#CmpGarantiaOperacionValor').val(Valor);
//		}else{
//
//		}
//	}else{
//
//	}
//
//}

$().ready(function() {

	$("#CmpGarantiaOperacionCosto").keyup(function (event) {  
		FncGarantiaOperacionCalcularTiempo();
	});

	$("#CmpGarantiaOperacionTiempo").keyup(function (event) {  
		FncGarantiaOperacionCalcularCosto();
	});


	//$("#CmpGarantiaOperacionValor").keyup(function (event) {  
	//	FncGarantiaOperacionCalcularCosto();
	//});
	
//	$("#CmpGarantiaOperacionTiempo").keyup(function (event) {  
//		FncGarantiaOperacionCalcularCosto();
//	});
	
});






//function FncGarantiaOperacionCalcularCostoMargen(){
//
//	var CostoMargen = 0;
//	var CostoTotal = $('#CmpGarantiaDetalleCostoTotal').val();
//	var Margen = $('#CmpGarantiaDetalleMargen').val();	
//
//	if(CostoTotal!=""){
//		if(Margen!=""){
//			CostoMargen = CostoTotal * Margen;
//			$('#CmpGarantiaDetalleCostoMargen').val(CostoMargen);
//		}else{
//
//		}
//	}else{
//
//	}
//
//}
//
//$().ready(function() {
//
//	$("#CmpGarantiaOperacionCosto").keyup(function (event) {  
//		FncGarantiaOperacionCalcularCostoMargen();
//	});
//
//});
