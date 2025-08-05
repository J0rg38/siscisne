// JavaScript Document
var ClienteNotaMostrarMensaje = false;

function FncValidar(){

		var Id = $("#CmpId").val();
		var ClienteId = $("#CmpClienteId").val();
		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
		var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
		var FechaEmision = $("#CmpFechaEmision").val();
		
		var Talonario = $("#CmpTalonario").val();
		var MonedaId = $("#CmpMonedaId").val();
		var TipoCambio = $("#CmpTipoCambio").val();
		var FechaVencimiento = $("#CmpFechaVencimiento").val();
		var CondicionPago = $("#CmpCondicionPago").val();
		
		if(ClienteId == "" && ClienteNombreCompleto !=""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No has ingresado correctamente al cliente",
					callback: function(result){
						$("#CmpClienteNombreCompleto").select();
					}
				});							
			
			return false;
			
		}else if(ClienteNombreCompleto == ""){			
//			alert("Debes ingresar una fecha de termino");			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre de cliente",
					callback: function(result){
						$("#CmpClienteNombreCompleto").focus();
					}
				});

			return false;
			
		}else if(Id == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar un numero correlativo",
					callback: function(result){
						$("#CmpId").focus();
					}
				});

			return false;
			
		}else if(ClienteNumeroDocumento == ""){	

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre de cliente",
					callback: function(result){
						$("#CmpClienteNombreCompleto").focus();
					}
				});
				return false;
					
		}else if(ClienteNumeroDocumento.length != 11){	

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero de documento de 11 digitos",
					callback: function(result){
						$("#CmpClienteNumeroDocumento").focus();
					}
				});
				return false;
					
		}else if(FechaEmision == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de emision",
					callback: function(result){
						$("#CmpFechaEmision").focus();
					}
				});

			return false;
		
		}else if(FncValidarFecha(FechaEmision) == false){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de emision valida",
					callback: function(result){
						$("#CmpFechaEmision").select();
					}
				});
				
			return false;

		}else if(Talonario == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una serie del documento",
					callback: function(result){
						$("#CmpTalonario").focus();
					}
				});

			return false;
			
		
		}else if(MonedaId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpMonedaId").focus();
					}
				});
				
			return false;
			
		}else if(MonedaId != EmpresaMonedaId && TipoCambio == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un tipo de cambio",
					callback: function(result){
						$("#CmpTipoCambio").focus();
					}
				});
				
			return false;
		
		}else if(FncValidarFecha(FechaVencimiento) == false && FechaVencimiento != ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de vencimiento valida",
					callback: function(result){
						$("#CmpFechaVencimiento").focus();
					}
				});
				
			return false;
		
		
			
		}else if(CondicionPago == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una condicion de pago",
					callback: function(result){
						$("#CmpCondicionPago").focus();
					}
				});
				
			return false;
		
		}else{	
			
			
			return true;
		}
		
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
			$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpCancelado").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');
	$("#CmpTalonario").removeAttr('disabled');
		
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpCancelado").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');
	$("#CmpTalonario").removeAttr('disabled');
		
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});



function FncPagoFacturaBuscar(){
}


//function FncGuardar(){
//	
//	//HACK
//	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
//	$("#CmpCancelado").removeAttr('disabled');		
//	$("#CmpIncluyeImpuesto").removeAttr('disabled');
//	
//}



var FormularioCampos = ["CmpTalonario",
"CmpId",
"CmpClienteNombre",
"CmpGuiaRemision",
"CmpClienteNumeroDocumento",
"CmpClienteDireccion",
"CmpFechaEmision",
"CmpObservacion",
"CmpObservacionImpresa",
"CmpIncluyeImpuesto",
"CmpPorcentajeImpuestoVenta",
"CmpMonedaId",
"CmpTipoCambio",

"CmpCondicionPago",
"CmpCantidadDia",
"CmpCancelado",
"CmpEstado",

"CmpArticuloDescripcion",
"CmpFacturaDetalleUnidadMedida",
"CmpFacturaDetallePrecio",
"CmpFacturaDetalleCantidad",
"CmpFacturaDetalleImporte",

"CmpRegimenComprobanteNumero",
"CmpRegimenComprobanteFecha",
"CmpRegimenId",
"CmpRegimenPorcentaje",
"CmpRegimenMonto"

];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncFacturaNavegar(this.id);
		 }
	}); 
	
	/*$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 
	
	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	});*/ 
	
/*
Agregando Eventos
*/

	$("#CmpFacturaDetalleCantidad").keyup(function (event) {  
		FncFacturaDetalleCalcularImporte();
	});
	
	$("#CmpFacturaDetalleImporte").keyup(function (event) {  
		FncFacturaDetalleCalcularPrecio();
	});
	
	$("#CmpFacturaDetalleDescuento").keyup(function (event) {  
		FncFacturaDetalleCalcularImporte();
	});
	
	$("input[name='CmpFacturaDetalleIncluyeSelectivo']").change(function(){
		FncFacturaDetalleCalcularImporte();
	});
	
	$("#CmpFacturaDetallePrecio").keyup(function (event) {  
		FncFacturaDetalleCalcularImporte();
	});
	
	

	$("select#CmpMonedaId").change(function(){
		FncFacturaEstablecerMoneda();
	});
	
	$("select#CmpOrdenTipo").change(function(){
		FncFacturaEstablecerOrden();
	});
	
	$("select#CmpCondicionPago").change(function(){
		FncFacturaEstablecerCondicionPago();
	});

	$("select#CmpRegimenId").change(function(){
		FncFacturaEstablecerRegimen();
	});
	
	
	
//	$("input[name='CmpTipo']").change(function(){
//		FncFacturaEstablecerTipo($(this).val());
//	});


//	$("input[name='CmpFacturaDetallePrecio']").keyup(function(){
//		FncFacturaDetalleCalcularImporte();
//	});
//	
//	$("input[name='CmpFacturaDetalleImporte']").keyup(function(){
//		FncFacturaDetalleCalcularPrecio();
//	});

});
	
function FncFacturaNavegar(oCampo){
	
	for(var i=0; i< FormularioCampos.length; i++) {
		if(FormularioCampos.length !== i + 1){
			
			if(FormularioCampos[i]==oCampo){
				
				if(document.getElementById(FormularioCampos[i+1]).type=="text"){
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
	
	if("CmpFacturaDetalleImporte"==oCampo){
		$("#CmpFacturaDetalleImporte").blur();		
		FncFacturaDetalleGuardar();	
	}
	
}




function FncGenerarFacturaId(oTalonario){

	if(oTalonario!=""){
	
		$.ajax({
			type: 'POST',
			url: 'formularios/Factura/acc/AccFacturaGenerarId.php',
			data: 'Talonario='+oTalonario,
			success: function(data){
				$('#CmpId').val(lTrim(data));	
			}
		});

	}else{
		$('#CmpId').val("");	
	}

}






function FncFacturaEstablecerOrden(){
	
	var OrdenTipo = $('#CmpOrdenTipo').val();

	if (OrdenTipo==""){
		$('#CmpOrdenFecha').val("");
		$('#CmpOrdenNumero').val("");

		$('#CmpOrdenFecha').attr('disabled', 'disabled');
		$('#CmpOrdenNumero').attr('disabled', 'disabled');
	}else{
		if($('#CmpOrdenFecha').val()==""){
			$('#CmpOrdenFecha').val(FechaHoy)
		}

		$('#CmpOrdenNumero').removeAttr('disabled');
		$('#CmpOrdenFecha').removeAttr('disabled');
	}
	/*switch(OrdenTipo){
		case "1":
			$('#CmpOrdenNumero').removeAttr('disabled');
			$('#CmpOrdenFecha').removeAttr('disabled');

			$('#CmpOrdenNumero').val("");
			$('#CmpOrdenFecha').val(FechaHoy);

		break;
		
		case "2":
			$('#CmpOrdenNumero').removeAttr('disabled');
			$('#CmpOrdenFecha').removeAttr('disabled');

			$('#CmpOrdenNumero').val("");
			$('#CmpOrdenFecha').val(FechaHoy);
		break;
		
		default:
			$('#CmpOrdenFecha').val("");
			$('#CmpOrdenNumero').val("");

			$('#CmpOrdenFecha').attr('disabled', 'disabled');
			$('#CmpOrdenNumero').attr('disabled', 'disabled');
		break;
	}*/
	
}


function FncFacturaEstablecerCondicionPago(){
	
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



function FncFacturaEstablecerMoneda(){

	//var MonedaSimbolo = $('#CmpMonedaSimbolo').val();
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFechaEmision').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		$('#CmpTipoCambio').attr('readonly', true);	
		
		FncFacturaDetalleListar();

		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
			$('#CmpTipoCambio').attr('readonly', true);	
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
			$('#CmpTipoCambio').removeAttr('readonly');	
			//$('#CmpTipoCambio').val(TcaMontoCompra)
		}

		FncMonedaBuscar('Id');
	}

//	$('#CapMonedaArticuloCosto').html(MonedaSimbolo);
//	$('#CapMonedaArticuloImporte').html(MonedaSimbolo);
	
	//FncCompraDetalleListar();
	//FncCompraGastoListar();
	//FncCompraDocumentoListar();
	
	
	//FncFacturaDetalleListar();

}


function FncFacturaEstablecerRegimen(){

	var Regimen = $('#CmpRegimenId').val();

	if(Regimen==""){
		$('#CmpRegimenPorcentaje').attr('readonly', true).val("");
		$('#CmpRegimenMonto').attr('readonly', true).val("");
		$('#CmpRegimenComprobanteFecha').attr('readonly', true).val("");
		$('#CmpRegimenComprobanteNumero').attr('readonly', true).val("");
		FncFacturaDetalleListar();
	}else{
		$('#CmpRegimenPorcentaje').removeAttr('readonly');
		$('#CmpRegimenMonto').removeAttr('readonly');
		$('#CmpRegimenComprobanteFecha').removeAttr('readonly');
		$('#CmpRegimenComprobanteNumero').removeAttr('readonly');
		FncRegimenBuscar('Id');
	}

}



function FncFacturaEstablecerTipo(oValor){
	
//	var Tipo = $("input[name='CmpTipo']").val();	
//	alert(oValor+"aaa");
	switch(oValor){
		
		case "1":
			FacturaDetalleEditar = 1;
			FncFacturaDetalleListar();
			
			$("#CapFacturaConcepto").hide();
			$("#CapFacturaDetalle").show();
		break;
		
		case "2":
			FacturaDetalleEditar = 2;
			FncFacturaDetalleListar();
			
			$("#CapFacturaConcepto").show();
			$("#CapFacturaDetalle").hide();
		break;

		default:
			FacturaDetalleEditar = 1;
			FncFacturaDetalleListar();
			
			$("#CapFacturaConcepto").hide();
			$("#CapFacturaDetalle").show();
		break;
		
	}

}

function FncClienteFuncion(){

console.log("test");
	FncClienteNotaVerificar();
	
}



/*
* IMPRESION
*/
function FncImprmir(oId,oTalonario){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");
			
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){

			case "1":
			
				FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/Factura/FrmFacturaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			default:
				
				alert("No ha escogido una opcion valida");
				
			break;
					
		}
		
	}

}


function FncVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");			
	
	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":
			
				FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "2":
	
				FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			case "3":
	
				FncPopUp('formularios/Factura/FrmFacturaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);
	
			break;
			
			default:
				
				alert("No ha escogido una opcion valida");
				
			break;
		
		}
		
	}

}


/*
* ACCIONES
*/

function FncGenerarNotaCredito(){
	document.getElementById(Formulario).action = "principal.php?Mod=NotaCredito&Form=Registrar&Tip=Factura"//1
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";
}

function FncGenerarGuiaRemision(){
	document.getElementById(Formulario).action = "principal.php?Mod=GuiaRemision&Form=Registrar&Tip=Factura"
	document.getElementById(Formulario).submit();
	document.getElementById(Formulario).action = "#";
}






//function FncClientePagoCargarFormulario(oForm,oFacturaId,oFacturaTalonarioId){
//	
//	
//	tb_show(this.title,'principal2.php?Mod=ClientePagoFactura&Form='+oForm+'&Dia=1&FacId='+oFacturaId+'&FtaId='+oFacturaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//
//}

/*
* FORMULARIOS
*/
function FncPagoFacturaCargarFormulario(oForm,oFacturaId,oFacturaTalonarioId){
	
	tb_show(this.title,'principal2.php?Mod=PagoFactura&Form='+oForm+'&Dia=1&FacId='+oFacturaId+'&FtaId='+oFacturaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){
	
	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

function FncPagoVentaDirectaCargarFormulario(oVentaDirectaId){
	
	//tb_show(this.title,'principal2.php?Mod=PagoFactura&Form='+oForm+'&Dia=1&FacId='+oFacturaId+'&FtaId='+oFacturaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=PagoVentaDirecta&Form=Listado","true","true","savedValues","","Dia=1&VdiId="+oVentaDirectaId)
	
	
}

function FncPagoOrdenVentaVehiculoCargarFormulario(oOrdenVentaVehiculoId){
	
	//tb_show(this.title,'principal2.php?Mod=PagoFactura&Form='+oForm+'&Dia=1&FacId='+oFacturaId+'&FtaId='+oFacturaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=PagoOrdenVentaVehiculo&Form=Listado","true","true","savedValues","","Dia=1&OvvId="+oOrdenVentaVehiculoId)
	
	
}

function FncVehiculoIngresoCaracteristicaCargar(oId){
	
	//tb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form=EditarCaracteristica&Dia=1&BolId='+oId+'&BtaId='+oFacturaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		



	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=VehiculoIngreso&Form=EditarCaracteristica","true","true","savedValues","","Dia=1&Id="+oId);
	//	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId);

}


/*
* COMUNES
*/
function FncVehiculoIngresoBuscar (){
	
	FncFacturaDetalleListar();
	
}

function FncMonedaFuncion(){
	FncFacturaDetalleListar();
}











/*
* CALCULO
*/



function FncFacturaDetalleCalcularImporte(){

	var Cantidad = $('#CmpFacturaDetalleCantidad').val();
	var Precio = $('#CmpFacturaDetallePrecio').val();
	var VDescuento = $('#CmpFacturaDetalleDescuento').val();
	var Importe = 0.00;
	
	var PorcentajeImpuestoVenta = $('#CmpPorcentajeImpuestoVenta').val();
	var PorcentajeImpuestoSelectivo = $('#CmpPorcentajeImpuestoSelectivo').val();	
	var IncluyeImpuesto = $('#CmpIncluyeImpuesto').val();
	
	
	var ImpuestoVenta = 0;
	var Descuento = 0;
	
	if(VDescuento==""){
		Descuento = 0;		
	}
	
	
	if(PorcentajeImpuestoVenta!=""){
		ImpuestoVenta=PorcentajeImpuestoVenta/100;
	}
	
	if(IncluyeImpuesto=="1"){		
		Descuento = parseFloat(Descuento) * ((ImpuestoVenta+1));		
	}
	
	if(Cantidad!="" && Precio!=""){
		Importe = (parseFloat(Precio) * parseFloat(Cantidad)) - parseFloat(Descuento);
		document.getElementById('CmpFacturaDetalleImporte').value = Importe;
	}

}

function FncFacturaDetalleCalcularPrecio(){

	var Cantidad = $('#CmpFacturaDetalleCantidad').val();
	var Importe = $('#CmpFacturaDetalleImporte').val();
	var Precio = 0.00;

	if(Cantidad!="" && Importe!=""){
		Precio = parseFloat(Importe) / parseFloat(Cantidad);
		document.getElementById('CmpFacturaDetallePrecio').value = Precio;
	}
	
}






/*
* VISTA PRELIMINAR
*/

function FncVentaConcretadaVistaPreliminar(oId){
		
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncAlmacenMovimientoSalidaVistaPreliminar(oId){
		
	FncPopUp('formularios/AlmacenMovimientoSalida/FrmAlmacenMovimientoSalidaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}
function FncTallerPedidoVistaPreliminar(oId){
		
	FncPopUp('formularios/TallerPedido/FrmTallerPedidoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}


function FncVehiculoMovimientoSalidaVistaPreliminar(oId){
		
	FncPopUp('formularios/VehiculoMovimientoSalida/FrmVehiculoMovimientoSalidaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncVehiculoMovimientoSalidaSimpleVistaPreliminar(oId){
		
	FncPopUp('formularios/VehiculoMovimientoSalidaSimple/FrmVehiculoMovimientoSalidaSimpleImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

/*
* FUNCIONES
*/

function tb_remove(oModulo,oTipo,oRuta) {
	
	console.log("tb_remove");
	
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

function FncTBCerrarFunncion(oModulo,oTipo,oRuta){
	
	console.log("FncTBCerrarFunncion");
	
	FncFacturaActualizarVehiculoIngresoCaracteristicas();
			
}

function FncFacturaActualizarVehiculoIngresoCaracteristicas(){
		
		var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();
		var Identificador = $('#Identificador').val();
		
		$('#CapFacturaDetalleAccion').html('Actualizando caracteristicas de vehiculo');					
		
			$.ajax({
					type: 'POST',
					url: 'formularios/Factura/acc/AccFacturaActualizarVehiculoIngresoCaracteristica.php',
					data: 'Identificador='+Identificador+
				
					'&OvvId='+OrdenVentaVehiculoId,
					
					success: function(){
						$('#CapFacturaDetalleAccion').html('Listo');							
						FncFacturaDetalleListar();
					}
				});

}



/**
* SUNAT
*/
/*
function FncFacturaGenerarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La factura ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		FncPopUp('formularios/Factura/FrmFacturaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
		
	}
		
}*/

function FncFacturaGenerarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La factura ya se encuentra procesada",
			callback: function(result){
				
			}
		});
				
	}else{
		
		//FncPopUp('formularios/Factura/FrmFacturaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
		tb_show(this.title,'formularios/Factura/FrmFacturaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

	}
		
}