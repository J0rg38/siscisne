// JavaScript Document

function FncGarantiaRepuestoIsuzuManoObraNuevo(){
	
	var MonedaId = $('#CmpMonedaId').val();
	
	var Costo = 0;
	if(EmpresaMonedaId == MonedaId){
		$('#CmpGarantiaRepuestoIsuzuManoObraValor').val(CalificacionCosto);
	}else{
		Costo = CalificacionCosto / CalificacionTipoCambio;
		$('#CmpGarantiaRepuestoIsuzuManoObraValor').val(Costo);
	}
			
			
	$('#CmpGarantiaRepuestoIsuzuManoObraId').val("");

	$('#CmpGarantiaRepuestoIsuzuManoObraNumero').val("");
	$('#CmpGarantiaRepuestoIsuzuManoObraTiempo').val("");
	//$('#CmpGarantiaRepuestoIsuzuManoObraValor').val(CalificacionCosto);
	$('#CmpGarantiaRepuestoIsuzuManoObraCosto').val("");
	
	//$('#CmpGarantiaRepuestoIsuzuManoObraTransaccionNumero').val("");
//	$('#CmpGarantiaRepuestoIsuzuManoObraTransaccionFecha').val("");
//	
//	$('#CmpGarantiaRepuestoIsuzuManoObraFechaAprobacion').val("");
//	$('#CmpGarantiaRepuestoIsuzuManoObraFechaPago').val("");
//	$('#CmpGarantiaRepuestoIsuzuManoObraEstado').val("");
//	$('#CmpGarantiaRepuestoIsuzuManoObraComprobanteNumero').val("");
	
	$('#CmpGarantiaRepuestoIsuzuManoObraItem').val("");	

	$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Listo para registrar elementos');	
			
	$('#CmpGarantiaRepuestoIsuzuManoObraNumero').select();
			
	$('#CmpGarantiaRepuestoIsuzuManoObraAccion').val("AccGarantiaRepuestoIsuzuManoObraRegistrar.php");
	
/*
* POPUP REGISTRAR/EDITAR
*/
}

function FncGarantiaRepuestoIsuzuManoObraGuardar(){

	var Identificador = $('#Identificador').val();

	var Acc = $('#CmpGarantiaRepuestoIsuzuManoObraAccion').val();		

	var GarantiaRepuestoIsuzuManoObraId = $('#CmpGarantiaRepuestoIsuzuManoObraId').val();
	var GarantiaRepuestoIsuzuManoObraNumero = $('#CmpGarantiaRepuestoIsuzuManoObraNumero').val();			
	var GarantiaRepuestoIsuzuManoObraTiempo = $('#CmpGarantiaRepuestoIsuzuManoObraTiempo').val();
	var GarantiaRepuestoIsuzuManoObraCosto = $('#CmpGarantiaRepuestoIsuzuManoObraCosto').val();
	var GarantiaRepuestoIsuzuManoObraValor = $('#CmpGarantiaRepuestoIsuzuManoObraValor').val();
	
	//var GarantiaRepuestoIsuzuManoObraTransaccionNumero = $('#CmpGarantiaRepuestoIsuzuManoObraTransaccionNumero').val();
//	var GarantiaRepuestoIsuzuManoObraTransaccionFecha = $('#CmpGarantiaRepuestoIsuzuManoObraTransaccionFecha').val();
//	
//	var GarantiaRepuestoIsuzuManoObraFechaAprobacion = $('#CmpGarantiaRepuestoIsuzuManoObraFechaAprobacion').val();
//	var GarantiaRepuestoIsuzuManoObraFechaPago = $('#CmpGarantiaRepuestoIsuzuManoObraFechaPago').val();
//	
//	var GarantiaRepuestoIsuzuManoObraComprobanteNumero = $('#CmpGarantiaRepuestoIsuzuManoObraTransaccionNumero').val();
//	
//	var GarantiaRepuestoIsuzuManoObraEstado = $('#CmpGarantiaRepuestoIsuzuManoObraEstado').val();

	var Item = $('#CmpGarantiaRepuestoIsuzuManoObraItem').val();
	
	if(GarantiaRepuestoIsuzuManoObraNumero==""){
		$('#CmpGarantiaRepuestoIsuzuManoObraNumero').select();
	}else if(GarantiaRepuestoIsuzuManoObraTiempo==""){
		$('#CmpGarantiaRepuestoIsuzuManoObraTiempo').select();
	}else if(GarantiaRepuestoIsuzuManoObraCosto=="" ){
		$('#CmpGarantiaRepuestoIsuzuManoObraCosto').select();	
	}else if(GarantiaRepuestoIsuzuManoObraValor==""){
		$('#CmpGarantiaRepuestoIsuzuManoObraValor').select();	
	}else{
		$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Guardando...');

		$.ajax({
			type: 'POST',
			url: 'formularios/GarantiaRepuestoIsuzu/acc/'+Acc,
			data: 'Identificador='+Identificador+
'&GarantiaRepuestoIsuzuManoObraId='+GarantiaRepuestoIsuzuManoObraId+
'&GarantiaRepuestoIsuzuManoObraNumero='+GarantiaRepuestoIsuzuManoObraNumero+
'&GarantiaRepuestoIsuzuManoObraTiempo='+GarantiaRepuestoIsuzuManoObraTiempo+
'&GarantiaRepuestoIsuzuManoObraCosto='+GarantiaRepuestoIsuzuManoObraCosto+
'&GarantiaRepuestoIsuzuManoObraValor='+GarantiaRepuestoIsuzuManoObraValor+

//'&GarantiaRepuestoIsuzuManoObraTransaccionNumero='+GarantiaRepuestoIsuzuManoObraTransaccionNumero+
//'&GarantiaRepuestoIsuzuManoObraTransaccionFecha='+GarantiaRepuestoIsuzuManoObraTransaccionFecha+
//'&GarantiaRepuestoIsuzuManoObraFechaAprobacion='+GarantiaRepuestoIsuzuManoObraFechaAprobacion+
//'&GarantiaRepuestoIsuzuManoObraFechaPago='+GarantiaRepuestoIsuzuManoObraFechaPago+
//'&GarantiaRepuestoIsuzuManoObraComprobanteNumero='+GarantiaRepuestoIsuzuManoObraComprobanteNumero+
//
//'&GarantiaRepuestoIsuzuManoObraEstado='+GarantiaRepuestoIsuzuManoObraEstado+

'&Item='+Item,
			success: function(){
				
			$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Listo');							
				FncGarantiaRepuestoIsuzuManoObraListar();
			}
		});
		
		FncGarantiaRepuestoIsuzuManoObraNuevo();
	}
	
}


function FncGarantiaRepuestoIsuzuManoObraListar(){

	var Identificador = $('#Identificador').val();

	$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Cargando...');

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(TipoCambio=="" || TipoCambio=="0.000"){
		TipoCambio = 1;
	}

	$.ajax({
		type: 'POST',
		url: 'formularios/GarantiaRepuestoIsuzu/FrmGarantiaRepuestoIsuzuManoObraListado.php',
		data: 'Identificador='+Identificador+
'&Editar='+GarantiaRepuestoIsuzuManoObraEditar+
'&Eliminar='+GarantiaRepuestoIsuzuManoObraEliminar+
'&MonedaId='+MonedaId+
'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Listo');	
			$("#CapGarantiaRepuestoIsuzuManoObraes").html("");
			$("#CapGarantiaRepuestoIsuzuManoObraes").append(html);
		}
	});

}



function FncGarantiaRepuestoIsuzuManoObraEscoger(oItem){
		
	var Identificador = $('#Identificador').val();
	
	$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Editando...');
	$('#CmpGarantiaRepuestoIsuzuManoObraAccion').val("AccGarantiaRepuestoIsuzuManoObraEditar.php");
	
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'formularios/GarantiaRepuestoIsuzu/acc/AccGarantiaRepuestoIsuzuManoObraEscoger.php',
		data: 'Identificador='+Identificador+
'&Item='+oItem,
		success: function(InsGarantiaRepuestoIsuzuManoObra){

	//SesionObjeto-InsGarantiaRepuestoIsuzuManoObra
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
	
			
			$('#CmpGarantiaRepuestoIsuzuManoObraNumero').val(InsGarantiaRepuestoIsuzuManoObra.Parametro2);	
			$('#CmpGarantiaRepuestoIsuzuManoObraTiempo').val(InsGarantiaRepuestoIsuzuManoObra.Parametro3);
			$('#CmpGarantiaRepuestoIsuzuManoObraCosto').val(InsGarantiaRepuestoIsuzuManoObra.Parametro5);
			$('#CmpGarantiaRepuestoIsuzuManoObraValor').val(InsGarantiaRepuestoIsuzuManoObra.Parametro4);
			
//			$('#CmpGarantiaRepuestoIsuzuManoObraTransaccionNumero').val(InsGarantiaRepuestoIsuzuManoObra.Parametro9);
//			$('#CmpGarantiaRepuestoIsuzuManoObraTransaccionFecha').val(InsGarantiaRepuestoIsuzuManoObra.Parametro10);
//			$('#CmpGarantiaRepuestoIsuzuManoObraFechaAprobacion').val(InsGarantiaRepuestoIsuzuManoObra.Parametro11);
//			$('#CmpGarantiaRepuestoIsuzuManoObraFechaPago').val(InsGarantiaRepuestoIsuzuManoObra.Parametro12);
//			
//			$('#CmpGarantiaRepuestoIsuzuManoObraComprobanteNumero').val(InsGarantiaRepuestoIsuzuManoObra.Parametro13);
//			
//			
//			$('#CmpGarantiaRepuestoIsuzuManoObraEstado').val(InsGarantiaRepuestoIsuzuManoObra.Parametro6);
//			
			$('#CmpGarantiaRepuestoIsuzuManoObraItem').val(InsGarantiaRepuestoIsuzuManoObra.Item);
			
			$('#CmpGarantiaRepuestoIsuzuManoObraNumero').select();
				
		}
	});
	
	

	
/*
* POPUP REGISTRAR/EDITAR
*/

}

function FncGarantiaRepuestoIsuzuManoObraEliminar(oItem){

	var Identificador = $('#Identificador').val();

	if(confirm("¿Realmente desea eliminar el elemento?")){
		
		$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Eliminando...');		
		
		$.ajax({
			type: 'POST',
			url: 'formularios/GarantiaRepuestoIsuzu/acc/AccGarantiaRepuestoIsuzuManoObraEliminar.php',
			data: 'Identificador='+Identificador+
'&Item='+oItem,
			success: function(){
				$('#CapGarantiaRepuestoIsuzuManoObraAccion').html("Eliminado");	
				FncGarantiaRepuestoIsuzuManoObraListar();
			}
		});

		FncGarantiaRepuestoIsuzuManoObraNuevo();

	}
	
}

function FncGarantiaRepuestoIsuzuManoObraEliminarTodo(){

	var Identificador = $('#Identificador').val();
	
	if(confirm("¿Realmente desea eliminar todos los elementos?")){
		$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Eliminando...');	
	
		$.ajax({
			type: 'POST',
			url: 'formularios/GarantiaRepuestoIsuzu/acc/AccGarantiaRepuestoIsuzuManoObraEliminarTodo.php',
			data: 'Identificador='+Identificador,
			success: function(){
				$('#CapGarantiaRepuestoIsuzuManoObraAccion').html('Eliminado');	
				FncGarantiaRepuestoIsuzuManoObraListar();
			}
		});	
			
		FncGarantiaRepuestoIsuzuManoObraNuevo();
	}
	
}













//function FncGarantiaRepuestoIsuzuManoObraCalcularCostoMargen(){
//
//	var CostoMargen = 0;
//	var CostoTotal = $('#CmpGarantiaRepuestoIsuzuDetalleCostoTotal').val();
//	var Margen = $('#CmpGarantiaRepuestoIsuzuDetalleMargen').val();	
//
//	if(CostoTotal!=""){
//		if(Margen!=""){
//			CostoMargen = CostoTotal * Margen;
//			$('#CmpGarantiaRepuestoIsuzuDetalleCostoMargen').val(CostoMargen);
//		}else{
//
//		}
//	}else{
//
//	}
//
//}
//



function FncGarantiaRepuestoIsuzuManoObraCalcularCosto(){

	var Costo = 0;
	var Tiempo = $('#CmpGarantiaRepuestoIsuzuManoObraTiempo').val();
	var Valor = $('#CmpGarantiaRepuestoIsuzuManoObraValor').val();	

//alert(Cantidad);

	if(Tiempo!=""){
		if(Valor!=""){
			Costo = Tiempo * Valor;
			$('#CmpGarantiaRepuestoIsuzuManoObraCosto').val(Costo);
		}else{

		}
	}else{

	}
}

function FncGarantiaRepuestoIsuzuManoObraCalcularTiempo(){

	var Tiempo = 0;
	var Costo = $('#CmpGarantiaRepuestoIsuzuManoObraCosto').val();
	var Valor = $('#CmpGarantiaRepuestoIsuzuManoObraValor').val();	

//alert(Cantidad);

	if(Costo!=""){
		if(Valor!=""){
			Tiempo = Costo / Valor;
			$('#CmpGarantiaRepuestoIsuzuManoObraTiempo').val(Tiempo);
		}else{

		}
	}else{

	}
}

//function FncGarantiaRepuestoIsuzuManoObraCalcularValor(){
//
//	var Valor = 0;
//	var Tiempo = $('#CmpGarantiaRepuestoIsuzuManoObraTiempo').val();
//	var Costo = $('#CmpGarantiaRepuestoIsuzuManoObraCosto').val();	
//
//	if(Tiempo!=""){
//		if(Costo!=""){
//			Valor = Costo / Tiempo;
//			$('#CmpGarantiaRepuestoIsuzuManoObraValor').val(Valor);
//		}else{
//
//		}
//	}else{
//
//	}
//
//}

$().ready(function() {

	$("#CmpGarantiaRepuestoIsuzuManoObraCosto").keyup(function (event) {  
		FncGarantiaRepuestoIsuzuManoObraCalcularTiempo();
	});

	$("#CmpGarantiaRepuestoIsuzuManoObraTiempo").keyup(function (event) {  
		FncGarantiaRepuestoIsuzuManoObraCalcularCosto();
	});


	//$("#CmpGarantiaRepuestoIsuzuManoObraValor").keyup(function (event) {  
	//	FncGarantiaRepuestoIsuzuManoObraCalcularCosto();
	//});
	
//	$("#CmpGarantiaRepuestoIsuzuManoObraTiempo").keyup(function (event) {  
//		FncGarantiaRepuestoIsuzuManoObraCalcularCosto();
//	});
	
});






//function FncGarantiaRepuestoIsuzuManoObraCalcularCostoMargen(){
//
//	var CostoMargen = 0;
//	var CostoTotal = $('#CmpGarantiaRepuestoIsuzuDetalleCostoTotal').val();
//	var Margen = $('#CmpGarantiaRepuestoIsuzuDetalleMargen').val();	
//
//	if(CostoTotal!=""){
//		if(Margen!=""){
//			CostoMargen = CostoTotal * Margen;
//			$('#CmpGarantiaRepuestoIsuzuDetalleCostoMargen').val(CostoMargen);
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
//	$("#CmpGarantiaRepuestoIsuzuManoObraCosto").keyup(function (event) {  
//		FncGarantiaRepuestoIsuzuManoObraCalcularCostoMargen();
//	});
//
//});
