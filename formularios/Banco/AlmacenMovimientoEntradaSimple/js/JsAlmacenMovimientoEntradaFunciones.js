// JavaScript Document

var FormularioCampos = [
"CmpFecha",
"CmpGuiaRemisionNumeroSerie",
"CmpGuiaRemisionNumeroNumero",
"CmpGuiaRemisionFecha",
"CmpTipoOperacion",
"CmpEstado",
"CmpObservacion",
"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",
/*"CmpProductoUnidadMedidaConvertir",*/
"CmpProductoCantidad",
"CmpProductoCostoIngresoNeto",
"CmpProductoImporte",
"CmpProveedorNumeroDocumento",
"CmpProveedorNombre",
"CmpComprobanteTipo",
"CmpDocumentoOrigen",
"CmpComprobanteNumeroSerie",
"CmpComprobanteNumeroNumero",
"CmpComprobanteFecha",
"CmpMonedaId",
"CmpTipoCambio",
"CmpValorTotal",
"CmpInternacionalNumeroComprobante1",
"CmpTotalAduana",
"CmpInternacionalMonedaId1",
"CmpInternacionalProveedorTipoDocumento1",
"CmpInternacionalProveedorNumeroDocumento1",
"CmpInternacionalProveedorNombre1",
"CmpInternacionalNumeroComprobante2",
"CmpTotalTransporte",
"CmpInternacionalMonedaId2",
"CmpInternacionalProveedorTipoDocumento2",
"CmpInternacionalProveedorNumeroDocumento2",
"CmpInternacionalProveedorNombre2",
"CmpInternacionalNumeroComprobante3",
"CmpTotalDesestiba",
"CmpInternacionalMonedaId3",
"CmpInternacionalProveedorTipoDocumento3",
"CmpInternacionalProveedorNumeroDocumento3",
"CmpInternacionalProveedorNombre3",
"CmpInternacionalNumeroComprobante4",
"CmpTotalAlmacenaje",
"CmpInternacionalMonedaId4",
"CmpInternacionalProveedorTipoDocumento4",
"CmpInternacionalProveedorNumeroDocumento4",
"CmpInternacionalProveedorNombre4",
"CmpInternacionalNumeroComprobante5",
"CmpTotalAdValorem",
"CmpInternacionalMonedaId5",
"CmpInternacionalProveedorTipoDocumento5",
"CmpInternacionalProveedorNumeroDocumento5",
"CmpInternacionalProveedorNombre5",
"CmpInternacionalNumeroComprobante6",
"CmpTotalAduanaNacional",
"CmpInternacionalMonedaId6",
"CmpInternacionalProveedorTipoDocumento6",
"CmpInternacionalProveedorNumeroDocumento6",
"CmpInternacionalProveedorNombre6",
"CmpInternacionalNumeroComprobante7",
"CmpTotalGastoAdministrativo",
"CmpInternacionalMonedaId7",
"CmpInternacionalProveedorTipoDocumento7",
"CmpInternacionalProveedorNumeroDocumento7",
"CmpInternacionalProveedorNombre7",
"CmpInternacionalNumeroComprobante8",
"CmpTotalOtroCosto1",
"CmpInternacionalMonedaId8",
"CmpInternacionalProveedorTipoDocumento8",
"CmpInternacionalProveedorNumeroDocumento8",
"CmpInternacionalProveedorNombre8",
"CmpInternacionalNumeroComprobante9",
"CmpTotalOtroCosto2",
"CmpInternacionalMonedaId9",
"CmpInternacionalProveedorTipoDocumento9",
"CmpInternacionalProveedorNumeroDocumento9",
"CmpInternacionalProveedorNombre9",
"CmpNacionalNumeroComprobante1",
"CmpTotalRecargo",
"CmpNacionalMonedaId1",
"CmpNacionalProveedorTipoDocumento1",
"CmpNacionalProveedorNumeroDocumento1",
"CmpNacionalProveedorNombre1",
"CmpNacionalNumeroComprobante2",
"CmpTotalFlete",
"CmpNacionalMonedaId2",
"CmpNacionalProveedorTipoDocumento2",
"CmpNacionalProveedorNumeroDocumento2",
"CmpNacionalProveedorNombre2",
"CmpNacionalNumeroComprobante3",
"CmpTotalOtroCosto",
"CmpNacionalMonedaId3",
"CmpNacionalProveedorTipoDocumento3",
"CmpNacionalProveedorNumeroDocumento3",
"CmpNacionalProveedorNombre3"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncAlmacenMovimientoNavegar(this.id);
		 }
	}); 

	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 

	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 
	
/*
Agregando Eventos
*/

	$("select#CmpDocumentoOrigen").change(function(){
		FncAlmacenMovimientoEntradaEstablecerDocumentoOrigen();
	});

	$("select#CmpMonedaId").change(function(){
		FncAlmacenMovimientoEntradaEstablecerMoneda();
	});
	
	$("#CmpComprobanteFecha").keyup(function(){
		FncTipoCambioCargarAux();	
	});
	
	$("#CmpTotalRecargo").keyup(function(){
		FncAlmacenMovimientoEntradaDetalleListar();	
	});


	$("select#CmpCondicionPago").change(function(){
		FncAlmacenMovimientoEntradaEstablecerCondicionPago();
	});
	
	
});


function FncTipoCambioCargarAux(){

	var MonedaId = $('#CmpMonedaId').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	FncTipoCambioCargar(MonedaId,Fecha);

}
	
function FncAlmacenMovimientoNavegar(oCampo){
	
	for(var i=0; i< FormularioCampos.length; i++) {
		if(FormularioCampos.length !== i + 1){
			if(FormularioCampos[i]==oCampo){
				if($('#'+FormularioCampos[i+1]).attr('type')=="text"){
					$('#'+FormularioCampos[i]).blur();
					$('#'+FormularioCampos[i+1]).focus();
					$('#'+FormularioCampos[i+1]).select();	
				}else{
					$('#'+FormularioCampos[i]).blur();	
					$('#'+FormularioCampos[i+1]).focus();	
				}
			}				
		}
	}

	if("CmpProductoImporte"==oCampo){
		$('#CmpProductoImporte').blur();
		FncAlmacenMovimientoEntradaDetalleGuardar();
	}
		
}


function FncAlmacenMovimientoEntradaEstablecerDocumentoOrigen(){

	var DocumentoOrigen = $('#CmpDocumentoOrigen').val();

	if(DocumentoOrigen=="1"){
		
		$('#CapCostoInternacionales').hide();
		$('#CapCostoNacionales').show();
		
		
		$('#CmpTotalRecargo').removeAttr('readonly');
		$('#CmpTotalFlete').removeAttr('readonly');
		$('#CmpTotalOtroCosto').removeAttr('readonly');

		$('#CmpTotalAduana').attr('readonly', true);
		$('#CmpTotalTransporte').attr('readonly', true);
		$('#CmpTotalDesestiba').attr('readonly', true);
		$('#CmpTotalAlmacenaje').attr('readonly', true);
		$('#CmpTotalAdValorem').attr('readonly', true);
		$('#CmpTotalAduanaNacional').attr('readonly', true);
		$('#CmpTotalGastoAdministrativo').attr('readonly', true);
		$('#CmpTotalOtroCosto1').attr('readonly', true);
		$('#CmpTotalOtroCosto2').attr('readonly', true);

	}else if(DocumentoOrigen == "2"){

		$('#CapCostoInternacionales').show();
		$('#CapCostoNacionales').hide();

		
		$('#CmpTotalRecargo').attr('readonly', true);	
		$('#CmpTotalFlete').attr('readonly', true);	
		$('#CmpTotalOtroCosto').attr('readonly', true);	

		$('#CmpTotalAduana').removeAttr('readonly');
		$('#CmpTotalTransporte').removeAttr('readonly');
		$('#CmpTotalDesestiba').removeAttr('readonly');
		$('#CmpTotalAlmacenaje').removeAttr('readonly');
		$('#CmpTotalAdValorem').removeAttr('readonly');
		$('#CmpTotalAduanaNacional').removeAttr('readonly');
		$('#CmpTotalGastoAdministrativo').removeAttr('readonly');
		$('#CmpTotalOtroCosto1').removeAttr('readonly');
		$('#CmpTotalOtroCosto2').removeAttr('readonly');
	}



}



function FncAlmacenMovimientoEntradaEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		
		FncAlmacenMovimientoEntradaDetalleListar();
		
		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha);				
			}
		}

		FncMonedaBuscar('Id');
	}
}

function FncAlmacenMovimientoEntradaEstablecerCondicionPago(){
	
	var CondicionPago = $('#CmpCondicionPago').val();

	switch(CondicionPago){
		case "NPA-10000":
			$('#CmpCantidadDia').val("0");
			$('#CmpCantidadDia').attr('disabled', 'disabled');
		break;
		
		case "NPA-10001":
			$('#CmpCantidadDia').removeAttr('disabled');
		break;
		
		default:
			$('#CmpCantidadDia').val("0");
			$('#CmpCantidadDia').attr('disabled', 'disabled');
		break;
	}
	
}


/*

function FncAlmacenMovimientoEntradaCostoVinculadoListar(){

	var Identificador = $('#Identificador').val();

	$('#CapCostoVinculadoAccion').html('Listo');	

	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();

	var MonedaId = $('#CmpMonedaId').val();
	var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	
	var TotalRecargo = parseFloat($('#CmpTotalRecargo').val());
	var TotalFlete = parseFloat($('#CmpTotalFlete').val());
	var TotalOtroCosto = parseFloat($('#CmpTotalOtroCosto').val());
	
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
	
}*/

function FncMonedaFuncion(){
	FncAlmacenMovimientoEntradaDetalleListar();
}









function FncCotizacionProductoVistaPreliminar(oId){
	FncPopUp('formularios/CotizacionProducto/FrmCotizacionProductoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncVentaDirectaVistaPreliminar(oId){
	FncPopUp('formularios/VentaDirecta/FrmVentaDirectaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}



function FncVentaConcretadaVistaPreliminar(oId){
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncPedidoCompraVistaPreliminar(oId){
	FncPopUp('formularios/PedidoCompra/FrmPedidoCompraImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}



























/*
Configuracion Autocompletar
*/
$().ready(function() {

	if($("#CmpProveedorId").val()==""){
		$("#BtnProveedorEditar").hide();
		$("#BtnProveedorRegistrar").show();
	}else{
		$("#BtnProveedorEditar").show();
		$("#BtnProveedorRegistrar").hide();
	}

	
	for(i=1;i<=9;i++){
		
		if($("#CmpInternacionalProveedorId"+i).val()==""){
			$("#BtnInternacionalProveedorEditar"+i).hide();
			$("#BtnInternacionalProveedorRegistrar"+i).show();
		}else{
			$("#BtnInternacionalProveedorEditar"+i).show();
			$("#BtnInternacionalProveedorRegistrar"+i).hide();
		}
		
	}
	

	for(i=1;i<=3;i++){
		
		if($("#CmpNacionalProveedorId"+i).val()==""){
			$("#BtnNacionalProveedorEditar"+i).hide();
			$("#BtnNacionalProveedorRegistrar"+i).show();
		}else{
			$("#BtnNacionalProveedorEditar"+i).show();
			$("#BtnNacionalProveedorRegistrar"+i).hide();
		}
		
	}




	
	$("#CmpProveedorNumeroDocumento").keyup(function (event) {  

		if($.trim($("#CmpProveedorNumeroDocumento").val())==""){
			FncProveedorNuevo("","");
		}

		if (event.keyCode == '13' && this.value != "" && $("#CmpProveedorNombre").val()=="") {
			FncProveedorBuscar("NumeroDocumento","","")	
		}

	}); 

	$("#CmpProveedorNombre").keyup(function (event) {  
		if($.trim($("#CmpProveedorNombre").val())==""){
			FncProveedorNuevo("","");
		}
	}); 
	
		

	function ProveedorFormato(row) {
		return row[1];
	}

	function ProveedorFormato2(row) {
		return row[2];
	}
		
	$("#CmpProveedorNombre").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpProveedorNombre").result(function(event, data, formatted) {
		if (data){
			$("#CmpProveedorId").val(data[0]);				
			FncProveedorBuscar("Id","","");
		}		
	});
	
	$("#CmpProveedorNumeroDocumento").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpProveedorNumeroDocumento").result(function(event, data, formatted) {
		if (data){
			$("#CmpProveedorId").val(data[0]);				
			FncProveedorBuscar("Id","","");
		}		
	});
	
	
	

/***********************************************/
/***********************************************/


	
	
	$("#CmpInternacionalProveedorNumeroDocumento1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento1").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId1").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","1");
		}		
	});
	
	$("#CmpInternacionalProveedorNombre1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre1").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId1").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","1");
		}		
	});
	

/***********************************************/


	$("#CmpInternacionalProveedorNumeroDocumento2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento2").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId2").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","2");
		}		
	});
	
	$("#CmpInternacionalProveedorNombre2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre2").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId2").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","2");
		}		
	});	
/***********************************************/	
	
	
	$("#CmpInternacionalProveedorNumeroDocumento3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento3").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId3").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","3");
		}		
	});
	
	$("#CmpInternacionalProveedorNombre3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre3").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId3").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","3");
		}		
	});	
/***********************************************/	

	$("#CmpInternacionalProveedorNumeroDocumento4").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento4").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId4").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","4");
		}		
	});	
		
	$("#CmpInternacionalProveedorNombre4").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre4").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId4").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","4");
		}		
	});		
/***********************************************/	

	$("#CmpInternacionalProveedorNumeroDocumento5").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento5").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId5").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","5");
		}		
	});
		
	$("#CmpInternacionalProveedorNombre5").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre5").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId5").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","5");
		}		
	});	
/***********************************************/		

	$("#CmpInternacionalProveedorNumeroDocumento6").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento6").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId6").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","6");
		}		
	});
			
	$("#CmpInternacionalProveedorNombre6").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre6").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId6").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","6");
		}		
	});	



	
/***********************************************/	
/***********************************************/	

	$("#CmpInternacionalProveedorNumeroDocumento7").keyup(function (event) {  

		if($.trim($("#CmpInternacionalProveedorNumeroDocumento7").val())==""){
			FncProveedorNuevo("Internacional","7");
		}

		if (event.keyCode == '13' && this.value != "" && $("#CmpInternacionalProveedorNombre7").val()=="") {
			FncProveedorBuscar("NumeroDocumento","Internacional","7")	
		}

	}); 

	$("#CmpInternacionalProveedorNombre7").keyup(function (event) {  

		if($.trim($("#CmpInternacionalProveedorNombre7").val())==""){
			FncProveedorNuevo("Internacional","7");
		}

	});	
/***********************************************/		

	$("#CmpInternacionalProveedorNumeroDocumento7").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento7").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId7").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","7");
		}		
	});
		
	$("#CmpInternacionalProveedorNombre7").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre7").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId7").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","7");
		}		
	});	
	
	
	
	
/***********************************************/	
/***********************************************/	

	$("#CmpInternacionalProveedorNumeroDocumento8").keyup(function (event) {  

		if($.trim($("#CmpInternacionalProveedorNumeroDocumento8").val())==""){
			FncProveedorNuevo("Internacional","8");
		}

		if (event.keyCode == '13' && this.value != "" && $("#CmpInternacionalProveedorNombre8").val()=="") {
			FncProveedorBuscar("NumeroDocumento","Internacional","8")	
		}

	}); 

	$("#CmpInternacionalProveedorNombre8").keyup(function (event) {  

		if($.trim($("#CmpInternacionalProveedorNombre8").val())==""){
			FncProveedorNuevo("Internacional","8");
		}

	});
	
/***********************************************/			
	
	$("#CmpInternacionalProveedorNumeroDocumento8").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento8").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId8").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","8");
		}		
	});
	
	
	$("#CmpInternacionalProveedorNombre8").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre8").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId8").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","8");
		}		
	});		
	
/***********************************************/	
/***********************************************/	

	$("#CmpInternacionalProveedorNumeroDocumento9").keyup(function (event) {  

		if($.trim($("#CmpInternacionalProveedorNumeroDocumento9").val())==""){
			FncProveedorNuevo("Internacional","9");
		}

		if (event.keyCode == '13' && this.value != "" && $("#CmpInternacionalProveedorNombre9").val()=="") {
			FncProveedorBuscar("NumeroDocumento","Internacional","9")	
		}

	}); 

	$("#CmpInternacionalProveedorNombre9").keyup(function (event) {  

		if($.trim($("#CmpInternacionalProveedorNombre9").val())==""){
			FncProveedorNuevo("Internacional","9");
		}

	});
	
/***********************************************/	

	$("#CmpInternacionalProveedorNumeroDocumento9").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpInternacionalProveedorNumeroDocumento9").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId9").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","9");
		}		
	});
	
		
	$("#CmpInternacionalProveedorNombre9").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpInternacionalProveedorNombre9").result(function(event, data, formatted) {
		if (data){
			$("#CmpInternacionalProveedorId9").val(data[0]);				
			FncProveedorBuscar("Id","Internacional","9");
		}		
	});	
	
	
	
	
	
	
	
	
	
/***********************************************/		
/***********************************************/	
	
	$("#CmpNacionalProveedorNumeroDocumento1").keyup(function (event) {  

		if($.trim($("#CmpNacionalProveedorNumeroDocumento1").val())==""){
			FncProveedorNuevo("Nacional","1");
		}

		if (event.keyCode == '13' && this.value != "" && $("#CmpNacionalProveedorNombre1").val()=="") {
			FncProveedorBuscar("NumeroDocumento","Nacional","1")	
		}

	}); 

	$("#CmpNacionalProveedorNombre1").keyup(function (event) {  
	
		if($.trim($("#CmpNacionalProveedorNombre1").val())==""){
			FncProveedorNuevo("Nacional","1");
		}
		
	});
	
/***********************************************/		
	$("#CmpNacionalProveedorNumeroDocumento1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpNacionalProveedorNumeroDocumento1").result(function(event, data, formatted) {
		if (data){
			$("#CmpNacionalProveedorId1").val(data[0]);				
			FncProveedorBuscar("Id","Nacional","1");
		}		
	});	
	
	$("#CmpNacionalProveedorNombre1").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpNacionalProveedorNombre1").result(function(event, data, formatted) {
		if (data){
			$("#CmpNacionalProveedorId1").val(data[0]);				
			FncProveedorBuscar("Id","Nacional","1");
		}		
	});
	
/***********************************************/		
/***********************************************/		

	$("#CmpNacionalProveedorNumeroDocumento2").keyup(function (event) {  

		if($.trim($("#CmpNacionalProveedorNumeroDocumento2").val())==""){
			FncProveedorNuevo("Nacional","2");
		}

		if (event.keyCode == '13' && this.value != "" && $("#CmpNacionalProveedorNombre2").val()=="") {
			FncProveedorBuscar("NumeroDocumento","Nacional","2")	
		}

	}); 

	$("#CmpNacionalProveedorNombre2").keyup(function (event) {  
	
		if($.trim($("#CmpNacionalProveedorNombre2").val())==""){
			FncProveedorNuevo("Nacional","2");
		}
		
	}); 

/***********************************************/	

	$("#CmpNacionalProveedorNumeroDocumento2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpNacionalProveedorNumeroDocumento2").result(function(event, data, formatted) {
		if (data){
			$("#CmpNacionalProveedorId2").val(data[0]);				
			FncProveedorBuscar("Id","Nacional","2");
		}		
	});	
	
	$("#CmpNacionalProveedorNombre2").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpNacionalProveedorNombre2").result(function(event, data, formatted) {
		if (data){
			$("#CmpNacionalProveedorId2").val(data[0]);				
			FncProveedorBuscar("Id","Nacional","2");
		}		
	});	
/***********************************************/		
/***********************************************/	


	$("#CmpNacionalProveedorNumeroDocumento3").keyup(function (event) {  

		if($.trim($("#CmpNacionalProveedorNumeroDocumento3").val())==""){
			FncProveedorNuevo("Nacional","3");
		}

		if (event.keyCode == '13' && this.value != "" && $("#CmpNacionalProveedorNombre3").val()=="") {
			FncProveedorBuscar("NumeroDocumento","Nacional","3")	
		}

	}); 

	$("#CmpNacionalProveedorNombre3").keyup(function (event) {  

		if($.trim($("#CmpNacionalProveedorNombre3").val())==""){
			FncProveedorNuevo("Nacional","3");
		}

	}); 

/***********************************************/		

	$("#CmpNacionalProveedorNumeroDocumento3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNumeroDocumento", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato2
	});		

	$("#CmpNacionalProveedorNumeroDocumento3").result(function(event, data, formatted) {
		if (data){
			$("#CmpNacionalProveedorId3").val(data[0]);				
			FncProveedorBuscar("Id","Nacional","3");
		}		
	});	
	
	$("#CmpNacionalProveedorNombre3").autocomplete("comunes/Proveedor/XmlProveedor.php?Campo=PrvNombre", {
		width: 500,
		max: 20,
		selectFirst: true,
		formatItem: ProveedorFormato
	});		

	$("#CmpNacionalProveedorNombre3").result(function(event, data, formatted) {
		if (data){
			$("#CmpNacionalProveedorId3").val(data[0]);				
			FncProveedorBuscar("Id","Nacional","3");
		}		
	});	

/***********************************************/		
	
	
/*
==
*/
		


});








function FncProveedorNuevo(oTipo,oRuta){
	
	$("#Cmp"+oTipo+"ProveedorId"+oRuta).val("");
	$("#Cmp"+oTipo+"ProveedorNumeroDocumento"+oRuta).val("");
	$("#Cmp"+oTipo+"ProveedorNombre"+oRuta).val("");
	$("#Cmp"+oTipo+"ProveedorDireccion"+oRuta).val("");
	$("#Cmp"+oTipo+"ProveedorTipoDocumento"+oRuta).val("");
	
	$("#Btn"+oTipo+"ProveedorEditar"+oRuta).hide();
	$("#Btn"+oTipo+"ProveedorRegistrar"+oRuta).show();
	

	
	
	
}


function FncProveedorBuscar(oCampo,oTipo,oRuta){

	var Dato = $('#Cmp'+oTipo+'Proveedor'+oCampo+oRuta).val();

	if(Dato==""){		
		$('#CmpProveedor'+oCampo).focus();
		$('#CmpProveedor'+oCampo).select();
	}else{
		$.ajax({
		type: 'POST',
		dataType : 'json',
		url: 'comunes/Proveedor/acc/AccProveedorBuscar.php',
		data: 'Campo='+oCampo+'&Dato='+Dato,
		success: function(InsProveedor){
			if(InsProveedor.PrvId!=null){
				FncProveedorEscoger(oTipo,oRuta,InsProveedor.PrvId,InsProveedor.PrvNumeroDocumento,InsProveedor.PrvNombreCompleto,InsProveedor.PrvDireccion,InsProveedor.TdoId);
			}
		}
		});			
	}

}

function FncProveedorEscoger(oTipo,oRuta,oProveedorId,oProveedorNumeroDocumento,oProveedorNombre,oProveedorDireccion,oTdoId){

	$('#CapProveedorBuscar').html('');
	$('#Cmp'+oTipo+'ProveedorId'+oRuta).val(oProveedorId);
	$('#Cmp'+oTipo+'ProveedorNumeroDocumento'+oRuta).val(oProveedorNumeroDocumento);
	$('#Cmp'+oTipo+'ProveedorNombre'+oRuta).val(oProveedorNombre);
	$('#Cmp'+oTipo+'ProveedorTipoDocumento'+oRuta).val(oTdoId);
	
	$("#Btn"+oTipo+"ProveedorEditar"+oRuta).show();
	$("#Btn"+oTipo+"ProveedorRegistrar"+oRuta).hide();
	
	
	

	
	
}






function FncProductoEscoger(oProId,oProNombre,oProPrecio,oProCosto,oProFoto,oProEspecificacion,oRtiId,oUmeId,oProCodigoOriginal,oProCodigoAlternativo,oUnidadMedidaIngreso,oProCostoIngreso,oProCostoIngresoNeto,oAmdId,oProValorVenta){	

//AccAlmacenMovimientoEntradaDetalleReemplazar.php


	var Accion = $('#CmpAlmacenMovimientoEntradaDetalleAccion').val();

	$('#CmpProductoId').val(oProId);
	$('#CmpProductoNombre').val(oProNombre);
	$('#CmpProductoCodigoOriginal').val(oProCodigoOriginal);
	$('#CmpProductoCodigoAlternativo').val(oProCodigoAlternativo);
			
	if(Accion != "AccAlmacenMovimientoEntradaDetalleReemplazar.php"){
		
			
			$('#CmpProductoCantidad').val("");
			
			$('#CmpProductoImporte').val("");
			$('#CmpProductoCostoAnterior').val(oProCostoIngreso);
			$('#CmpProductoCosto').val(oProCosto);
			$('#CmpProductoCostoIngreso').val(oProCostoIngreso);
			$('#CmpProductoCostoIngresoNeto').val(oProCostoIngresoNeto);
			$('#CmpProductoCostoAux').val(oProCosto);
			$('#CmpProductoPrecio').val(oProPrecio);
			$('#CmpProductoFoto').val(oProFoto);
			$('#CapProductoEspecificacion').html('<a target="_blank" href="subidos/producto_especificaciones/'+oProEspecificacion+'">Archivo de Especificaciones<a/>');
		
			$('#CmpProductoTipo').val(oRtiId);
			$('#CmpProductoUnidadMedida').val(oUmeId);
			$('#CmpProductoUnidadMedidaIngreso').val(oUnidadMedidaIngreso);
			
			if(oUnidadMedidaIngreso==""){
				alert("No se encontro UNIDAD DE MEDIDA (INGRESO), se recomienda revisar el PRODUCTO y establecer uno.");
			}
			
			if(oUmeId==""){
				alert("No se encontro UNIDAD DE MEDIDA (BASE), se recomienda revisar el PRODUCTO y establecer uno.");
			}
		
			
			$('#CmpProductoAlmacenMovimientoDetalleId').val(oAmdId);
		
			$.getJSON("comunes/UnidadMedida/JnProductoTipoUnidadMedida.php?RtiId="+oRtiId+"&Tipo="+UnidadMedidaTipo+"&UnidadMedidaId="+oUnidadMedidaIngreso,{}, function(j){
		
				var options = '';
		
				options += '<option value="">Escoja una opcion</option>';
				for (var i = 0; i < j.length; i++) {
					if(oUnidadMedidaIngreso == j[i].UmeId){
						options += '<option value="' + j[i].UmeId + '" selected="selected">' + j[i].UmeNombre+ '</option>';				
					}else{
						options += '<option value="' + j[i].UmeId + '" >' + j[i].UmeNombre+ '</option>';				
					}
		
				}
				$("select#CmpProductoUnidadMedidaConvertir").html(options);
			})
		
			$('#CmpProductoUnidadMedidaConvertir').unbind('change');
			$("select#CmpProductoUnidadMedidaConvertir").change(function(){
				$.getJSON("comunes/UnidadMedida/JnUnidadMedidaConversion.php?UnidadMedida1="+oUmeId+"&UnidadMedida2="+$(this).val(),{}, 
				function(j){
					$("#CmpProductoUnidadMedidaEquivalente").val(j[0].UmcEquivalente);
					$('#CmpProductoCosto').val($('#CmpProductoCosto').val() * j[0].UmcEquivalente);
					$('#CmpProductoImporte').val($('#CmpProductoCosto').val() * $('#CmpProductoCantidad').val());			
				})
			});
			
			
	}
	
	
	

}






function tb_remove(oModulo,oTipo,oRuta) {

	FncTBCerrarFunncion(oModulo,oTipo,oRuta);

 	$("#TB_imageOff").unbind("click");
	$("#TB_closeWindowButton").unbind("click");
	$("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
	$("#TB_load").remove();
	if (typeof document.body.style.maxHeight == "undefined") {//if IE 6
		$("body","html").css({height: "auto", width: "auto"});
		$("html").css("overflow","");
	}
	document.onkeydown = "";
	document.onkeyup = "";
	return false;

}













/*
* Funciones PopUp Formulario
*/

function FncProveedorCargarFormulario(oForm,oTipo,oRuta){

	var ProveedorId = $('#Cmp'+oTipo+'ProveedorId'+oRuta).val();
	var ProveedorNombre = $('#Cmp'+oTipo+'ProveedorNombre'+oRuta).val();
	var TipoDocumentoId = $('#Cmp'+oTipo+'ProveedorTipoDocumento'+oRuta).val();
	var ProveedorNumeroDocumento = $('#Cmp'+oTipo+'ProveedorNumeroDocumento'+oRuta).val();
		
//	var ProveedorId = $('#Cmp'+oTipo+'ProveedorId'+oRuta).val();
	tb_show(this.title,'principal2.php?Mod=Proveedor&Form='+oForm+'&Dia=1&Id='+ProveedorId+'&ProveedorNombre='+ProveedorNombre+'&TipoDocumentoId='+TipoDocumentoId+'&ProveedorNumeroDocumento='+ProveedorNumeroDocumento+'&Tipo='+oTipo+'&Ruta='+oRuta+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


//function FncTBCerrarFunncion(oModulo,oTipo,oRuta){
//
//	if(oModulo!=""){
//		eval("Fnc"+oModulo+"Buscar('Id','"+oTipo+"','"+oRuta+"');");
//	}
//
//}

function FncTBCerrarFunncion(oModulo,oTipo,oRuta){

	if ( (typeof oModulo == 'string' || oModulo instanceof String) && (typeof oTipo == 'string' || oTipo instanceof String) && (typeof oRuta == 'string' || oRuta instanceof String)){

		if( (oModulo!="" && oModulo!=null && oModulo!="undefined") && ( oTipo!="" && oTipo!=null && oTipo!="undefined" ) && (oRuta!="" && oRuta!=null && oRuta!="undefined") ){
			eval("Fnc"+oModulo+"Buscar('Id','"+oTipo+"','"+oRuta+"');");	
		}
		
	}

}


/*
* Funciones PopUp Listado
*/

function FncProveedorFiltrar(e){

	if(window.event)keyCode=window.event.keyCode;
	
	else if(e) keyCode=e.which;
	
	if (keyCode==13){	
		FncProveedorFiltrar2();
	}
	
}

function FncProveedorFiltrar2(){
	
	var Campo = $('#CmpProveedorCampo').val();
	var Condicion = $('#CmpProveedorCondicion').val();
	var Filtro = $('#CmpFiltro').val();
	var Ruta = $('#Ruta').val();
	var Tipo = $('#Tipo').val();
	
	$.ajax({
		type: 'POST',
		dataType : 'html',
		url: 'formularios/AlmacenMovimientoEntrada/FrmProveedorListado.php',
		data: 'Campo='+Campo+'&Condicion='+Condicion+'&Filtro='+Filtro+'&Ruta='+Ruta+'&Tipo='+Tipo,
		success: function(html){
			$("#CapProveedores").html("");
			$("#CapProveedores").append(html);
		}
	});

}

function FncProveedorListadorEscoger(oTipo,oRuta,oProveedorId){
	
	$('#Cmp'+oTipo+'ProveedorId'+oRuta).val(oProveedorId);
	FncProveedorBuscar("Id",oTipo,oRuta);
	tb_remove();

}








$().ready(function() {

	$("#CmpProductoImporte").keyup(function (event) {  
		FncProductoCalcularMonto("CostoIngresoNeto");
	});
	
	$("#CmpProductoCantidad").keyup(function (event) {  
		FncProductoCalcularImporte("CostoIngresoNeto");
	});
	
	$("#CmpProductoCodigoOriginal").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoOriginal");
		 }
	});
	
	$("#CmpProductoCodigoAlternativo").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncProductoBuscar("CodigoAlternativo");
		 }
	});
	
});


















function FncAlmacenMovimientoDetalleSeleccionar(){
	
	var seleccionados = "";
	var indice = 1;

	$('input[type=checkbox]').each(function () {
		
		if($(this).attr('name')=="CmpAgregarSeleccionado[]"){

			if($(this).is(':checked')){
				$('#Fila_'+indice).css('background-color', '#CEE7FF');
				seleccionados = seleccionados + "#" + $(this).val();
			}else{
				$('#Fila_'+indice).css('background-color', '#FFFFFF');		
			}
			indice = indice + 1;
		}
	
	});

}