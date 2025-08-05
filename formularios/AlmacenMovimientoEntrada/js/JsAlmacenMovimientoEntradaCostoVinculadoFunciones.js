// JavaScript Document

function FncAlmacenMovimientoEntradaCostoVinculadoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCostoVinculadoAccion').html('Listo');	

	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	var TotalRecargo = parseFloat($('#CmpTotalRecargo').val().replace(",",""));
	var TotalFlete = parseFloat($('#CmpTotalFlete').val().replace(",",""));
	var TotalOtroCosto = parseFloat($('#CmpTotalOtroCosto').val().replace(",",""));

	//var NacionalMonedaId1 = ($('#CmpNacionalMonedaId1').val());
	var NacionalMonedaId2 = ($('#CmpNacionalMonedaId2').val());
	var NacionalMonedaId3 = ($('#CmpNacionalMonedaId3').val());
	
	var TotalAduana = parseFloat($('#CmpTotalAduana').val());
	var TotalTransporte = parseFloat($('#CmpTotalTransporte').val());
	var TotalDesestiba = parseFloat($('#CmpTotalDesestiba').val());
	var TotalAlmacenaje = parseFloat($('#CmpTotalAlmacenaje').val());
	var TotalAdValorem = parseFloat($('#CmpTotalAdValorem').val());
	var TotalAduanaNacional = parseFloat($('#CmpTotalAduanaNacional').val());
	var TotalGastoAdministrativo = parseFloat($('#CmpTotalGastoAdministrativo').val());
	var TotalOtroCosto1 = parseFloat($('#CmpTotalOtroCosto1').val());
	var TotalOtroCosto2 = parseFloat($('#CmpTotalOtroCosto2').val());
	
	var TotalImportacion = TotalAduana + TotalTransporte + TotalDesestiba + TotalAlmacenaje + TotalAdValorem + TotalAduanaNacional + TotalGastoAdministrativo + TotalOtroCosto1 + TotalOtroCosto2;
	
	$('#CmpTotalImportacion').val(TotalImportacion);
	
	$.ajax({
		type: 'POST',
		url: 'formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaCostoVinculadoListado.php',
		data: 'Identificador='+Identificador+'&TotalRecargo='+TotalRecargo+'&TotalFlete='+TotalFlete+'&TotalOtroCosto='+TotalOtroCosto+'&TotalAduana='+TotalAduana+'&TotalTransporte='+TotalTransporte+'&TotalDesestiba='+TotalDesestiba+'&TotalAlmacenaje='+TotalAlmacenaje+'&TotalAdValorem='+TotalAdValorem+'&TotalAduanaNacional='+TotalAduanaNacional+'&TotalGastoAdministrativo='+TotalGastoAdministrativo+'&TotalOtroCosto1='+TotalOtroCosto1+'&TotalOtroCosto2='+TotalOtroCosto+'&TotalImportacion='+TotalImportacion+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio+'&NacionalMonedaId2='+NacionalMonedaId2+'&NacionalMonedaId3='+NacionalMonedaId3,
		success: function(html){
			$('#CapCostoVinculadoAccion').html('Listo');	
			$("#CapAlmacenMovimientoEntradaCostoVinculados").html("");
			$("#CapAlmacenMovimientoEntradaCostoVinculados").append(html);
		}
	});
	
}

//function FncAlmacenMovimientoEntradaCostoVinculadoListar(){
//
//	var Identificador = $('#Identificador').val();
//
//	$('#CapCostoVinculadoAccion').html('Listo');	
//
//	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
//	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
//
//	var MonedaId = $('#CmpMonedaId').val();
//	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
//	var TipoCambio = $('#CmpTipoCambio').val();
//	
//	var TotalRecargo = parseFloat($('#CmpTotalRecargo').val());
//	var TotalFlete = parseFloat($('#CmpTotalFlete').val());
//	var TotalOtroCosto = parseFloat($('#CmpTotalOtroCosto').val());
//	
//	var TotalAduana = parseFloat($('#CmpTotalAduana').val());
//	var TotalTransporte = parseFloat($('#CmpTotalTransporte').val());
//	var TotalDesestiba = parseFloat($('#CmpTotalDesestiba').val());
//	var TotalAlmacenaje = parseFloat($('#CmpTotalAlmacenaje').val());
//	var TotalAdValorem = parseFloat($('#CmpTotalAdValorem').val());
//	var TotalAduanaNacional = parseFloat($('#CmpTotalAduanaNacional').val());
//	var TotalGastoAdministrativo = parseFloat($('#CmpTotalGastoAdministrativo').val());
//	var TotalOtroCosto1 = parseFloat($('#CmpTotalOtroCosto1').val());
//	var TotalOtroCosto2 = parseFloat($('#CmpTotalOtroCosto2').val());
//	
//	var TotalImportacion = TotalAduana + TotalTransporte + TotalDesestiba + TotalAlmacenaje + TotalAdValorem + TotalAduanaNacional + TotalGastoAdministrativo + TotalOtroCosto1 + TotalOtroCosto2;
//	
//	$('#CmpTotalImportacion').val(TotalImportacion);
//	 
//	
//	$.ajax({
//		type: 'POST',
//		url: 'formularios/AlmacenMovimientoEntrada/FrmAlmacenMovimientoEntradaCostoVinculadoListado.php',
//		data: 'Identificador='+Identificador+'&TotalRecargo='+TotalRecargo+'&TotalFlete='+TotalFlete+'&TotalOtroCosto='+TotalOtroCosto+'&TotalAduana='+TotalAduana+'&TotalTransporte='+TotalTransporte+'&TotalDesestiba='+TotalDesestiba+'&TotalAlmacenaje='+TotalAlmacenaje+'&TotalAdValorem='+TotalAdValorem+'&TotalAduanaNacional='+TotalAduanaNacional+'&TotalGastoAdministrativo='+TotalGastoAdministrativo+'&TotalOtroCosto1='+TotalOtroCosto1+'&TotalOtroCosto2='+TotalOtroCosto+'&TotalImportacion='+TotalImportacion+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio,
//		success: function(html){
//			$('#CapCostoVinculadoAccion').html('Listo');	
//			$("#CapAlmacenMovimientoEntradaCostoVinculados").html("");
//			$("#CapAlmacenMovimientoEntradaCostoVinculados").append(html);
//		}
//	});
//	
//}