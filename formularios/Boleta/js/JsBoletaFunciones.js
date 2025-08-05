// JavaScript Document
var Variables = "";



function FncValidar(){

		var Id = $("#CmpId").val();
		var ClienteId = $("#CmpClienteId").val();
		var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
		var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
		var ClienteEmail = $("#CmpClienteEmail").val();
		
		var FechaEmision = $("#CmpFechaEmision").val();
		
		var Talonario = $("#CmpTalonario").val();
		var MonedaId = $("#CmpMonedaId").val();
		var TipoCambio = $("#CmpTipoCambio").val();
		var FechaVencimiento = $("#CmpFechaVencimiento").val();
		var CondicionPago = $("#CmpCondicionPago").val();
		
		var ClienteTipoDocumento = $("#CmpClienteTipoDocumento").val();
		var OrdenVentaVehiculoId = $("#CmpOrdenVentaVehiculoId").val();
		
		console.log("ClienteTipoDocumento: "+ClienteTipoDocumento);
		
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
					
		}else if(ClienteNumeroDocumento.length != 11 && ClienteTipoDocumento=="TDO-10003"){
			
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero de documento de 11 digitos",
					callback: function(result){
						$("#CmpClienteNumeroDocumento").focus();
					}
				});
				return false;
				
	}else if(ClienteNumeroDocumento.length != 8 && ClienteTipoDocumento=="TDO-10001"){
			
			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero de documento de 8 digitos",
					callback: function(result){
						$("#CmpClienteNumeroDocumento").focus();
					}
				});
				return false;
		
		
		
		
		
		
		}else if(ClienteEmail == "" && OrdenVentaVehiculoId != ""){	

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un correo electronico",
					callback: function(result){
						$("#CmpClienteEmail").focus();
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

		}else if(MonedaId != EmpresaMonedaId && (TipoCambio == "" || TipoCambio == "0.00" || TipoCambio == "0") ){			

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
		
		//HACK
		$("#CmpClienteTipoDocumento").removeAttr('disabled');		
		$("#CmpIncluyeImpuesto").removeAttr('disabled');
		
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		
		//HACK
		$("#CmpClienteTipoDocumento").removeAttr('disabled');		
		$("#CmpIncluyeImpuesto").removeAttr('disabled');
		
	
		return FncValidar();
	});
	
	
		
	$('#CmpFechaEmision').on('keyup', function() {
		
		FncBoletaCalcularFechaVencimiento();
		
	});
	
	
	$('#CmpCantidadDia').on('keyup', function() {

		FncBoletaCalcularFechaVencimiento();
		
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});




function FncPagoBoletaBuscar(){

}

//function FncGuardar(){
//	
//	//HACK
//	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
//	$("#CmpIncluyeImpuesto").removeAttr('disabled');
//	
//}


var FormularioCampos = ["CmpTalonario",
"CmpId",
"CmpClienteNombre",
"CmpClienteTipoDocumento",
"CmpClienteNumeroDocumento",
"CmpClienteDireccion",
"CmpFechaEmision",
"CmpObservacion",
"CmpObservacionImpresa",
"CmpPorcentajeImpuestoVenta",
"CmpMonedaId",
"CmpTipoCambio",

"CmpCondicionPago",
"CmpCantidadDia",
"CmpEstado",

"CmpArticuloDescripcion",
"CmpBoletaDetalleUnidadMedida",
"CmpBoletaDetallePrecio",
"CmpBoletaDetalleCantidad",
"CmpBoletaDetalleImporte",

"CmpRegimenComprobanteNumero",
"CmpRegimenComprobanteFecha",
"CmpRegimenId",
"CmpRegimenPorcentaje",
"CmpRegimenMonto"

];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncBoletaNavegar(this.id);
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
	$("#CmpBoletaDetalleCantidad").keyup(function (event) {  
		FncBoletaDetalleCalcularImporte();
	});
	
	$("#CmpBoletaDetalleImporte").keyup(function (event) {  
		FnccBoletaDetalleCalcularPrecio();
	});
	
	$("#CmpBoletaDetallePrecio").keyup(function (event) {  
		FncBoletaDetalleCalcularImporte();
	});
	
	$("select#CmpMonedaId").change(function(){
		FncBoletaEstablecerMoneda();
	});

	$("select#CmpCondicionPago").change(function(){
		FncBoletaEstablecerCondicionPago();
	});

	$("select#CmpRegimenId").change(function(){
		FncBoletaEstablecerRegimen();
	});
	
});

	
function FncBoletaNavegar(oCampo){
	
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
	
	if("CmpBoletaDetalleImporte"==oCampo){
		$("#CmpBoletaDetalleImporte").blur();		
		FncBoletaDetalleGuardar();	
	}
	
}



function FncGenerarBoletaId(oTalonario){

	if(oTalonario!=""){
		$.ajax({
			type: 'POST',
			url: 'formularios/Boleta/acc/AccBoletaGenerarId.php',
			data: 'Talonario='+oTalonario,
			success: function(data){
				$('#CmpId').val(lTrim(data));	
			}
		});
	}else{
		$('#CmpId').val("");	
	}
		
}


function FncBoletaEstablecerCondicionPago(){
	
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


function FncBoletaEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFechaEmision').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		$('#CmpTipoCambio').attr('readonly', true);	
		
		FncBoletaDetalleListar();

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

}

function FncBoletaEstablecerRegimen(){

	var Regimen = $('#CmpRegimenId').val();

	if(Regimen==""){
		$('#CmpRegimenPorcentaje').attr('readonly', true).val("");
		$('#CmpRegimenMonto').attr('readonly', true).val("");
		$('#CmpRegimenComprobanteFecha').attr('readonly', true).val("");
		$('#CmpRegimenComprobanteNumero').attr('readonly', true).val("");
		FncBoletaDetalleListar();
	}else{
		$('#CmpRegimenPorcentaje').removeAttr('readonly');
		$('#CmpRegimenMonto').removeAttr('readonly');
		$('#CmpRegimenComprobanteFecha').removeAttr('readonly');
		$('#CmpRegimenComprobanteNumero').removeAttr('readonly');
		FncRegimenBuscar('Id');
	}

}

function FncMonedaFuncion(){

	FncBoletaDetalleListar();
	
}

function FncClienteFuncion(){

	FncClienteNotaVerificar();
	
}

function FncVehiculoIngresoBuscar (){
	
	FncBoletaDetalleListar();
	
}



function FncImprmir(oId,oTalonario,oOpcion){
	
	if(oOpcion==null){
		oOpcion = "1";
	}
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)",
oOpcion);
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/Boleta/FrmBoletaImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

						FncPopUp('formularios/Boleta/FrmBoletaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
				}
				
			}

}


function FncVistaPreliminar(oId,oTalonario,oOpcion){
	
	if(oOpcion==null){
		oOpcion = "1";
	}
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)",
oOpcion);
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
						FncPopUp('formularios/Boleta/FrmBoletaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

						FncPopUp('formularios/Boleta/FrmBoletaImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

						FncPopUp('formularios/Boleta/FrmBoletaGenerarPDF.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}



/*
* VISTA PRELIMINARES
*/

function FncVentaConcretadaVistaPreliminar(oId){
	
	FncPopUp('formularios/VentaConcretada/FrmVentaConcretadaImprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}



function FncPagoVistaPreliminar(oId,oTipo){
		
	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato) \n 3 = Formato 3 (Impresion PDF)", "1");			
	
	
	switch(oTipo.toUpperCase()){
			case "VDI":
				oTipo = "VentaDirecta";
			break;
			
			case "OVV":
				oTipo = "OrdenVentaVehiculo";
			break;
			
			case "FAC":
				oTipo = "Factura";
			break;
			
			case "BOL":
				oTipo = "Boleta";
			break;
			
			default:
				oTipo = "";
			break;
		}
		
	if(Tipo !== null){	
		switch(Tipo.toUpperCase()){
			case "1":
				FncPopUp('formularios/Pago'+oTipo+'/FrmPago'+oTipo+'Imprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "2":
				FncPopUp('formularios/Pago'+oTipo+'/FrmPago'+oTipo+'Imprimir2.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			case "3":
				FncPopUp('formularios/Pago'+oTipo+'/acc/AccGenerarPago'+oTipo+'PDF.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
			break;
			
			default:
				alert("Opcion incorrecta");
			break;
		}
	}	

}





/*
* FORMULARIOS
*/

function FncPagoVentaDirectaCargarFormulario(oVentaDirectaId){
	
	//tb_show(this.title,'principal2.php?Mod=PagoBoleta&Form='+oForm+'&Dia=1&FacId='+oBoletaId+'&FtaId='+oBoletaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=PagoVentaDirecta&Form=Listado&","true","true","savedValues","","Dia=1&VdiId="+oVentaDirectaId)
	
	
}


function FncPagoOrdenVentaVehiculoCargarFormulario(oOrdenVentaVehiculoId){
	
	//tb_show(this.title,'principal2.php?Mod=PagoBoleta&Form='+oForm+'&Dia=1&FacId='+oBoletaId+'&FtaId='+oBoletaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
	//FncCargarVentanaFullv2(oModo,oRuta,oIframe,oModal,oValues,oTitulo,oVariables){
	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=PagoOrdenVentaVehiculo&Form=Listado&","true","true","savedValues","","Dia=1&OvvId="+oOrdenVentaVehiculoId)
	
	
}




function FncPagoBoletaCargarFormulario(oForm,oBoletaId,oBoletaTalonarioId){

	tb_show(this.title,'principal2.php?Mod=PagoBoleta&Form='+oForm+'&Dia=1&BolId='+oBoletaId+'&BtaId='+oBoletaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){
	
	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

function FncVehiculoIngresoCaracteristicaCargar(oId){
	
	//tb_show(this.title,'principal2.php?Mod=VehiculoIngreso&Form=EditarCaracteristica&Dia=1&BolId='+oId+'&BtaId='+oBoletaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		



	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=VehiculoIngreso&Form=EditarCaracteristica","true","true","savedValues","","Dia=1&Id="+oId);
	//	FncCargarVentanaFullv2("Avanzado","principal2.php?Mod=Cliente&Form="+oForm,"true","true","savedValues","","Dia=1&Id="+oClienteId);

}


/*
* CALCULO
*/

function FncBoletaDetalleCalcularImporte(){

	var Cantidad = $('#CmpBoletaDetalleCantidad').val();
	var Precio = $('#CmpBoletaDetallePrecio').val();
	var VDescuento = $('#CmpBoletaDetalleDescuento').val();
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
		document.getElementById('CmpBoletaDetalleImporte').value = Importe;
	}

}

function FncBoletaDetalleCalcularPrecio(){

	var Cantidad = $('#CmpBoletaDetalleCantidad').val();
	var Importe = $('#CmpBoletaDetalleImporte').val();
	var Precio = 0.00;

	if(Cantidad!="" && Importe!=""){
		Precio = parseFloat(Importe) / parseFloat(Cantidad);
		document.getElementById('CmpBoletaDetallePrecio').value = Precio;
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
	
	FncBoletaActualizarVehiculoIngresoCaracteristicas();
			
}

function FncBoletaActualizarVehiculoIngresoCaracteristicas(){
		
		var OrdenVentaVehiculoId = $('#CmpOrdenVentaVehiculoId').val();
		var Identificador = $('#Identificador').val();
		
		$('#CapBoletaDetalleAccion').html('Actualizando caracteristicas de vehiculo');					
		
			$.ajax({
					type: 'POST',
					url: 'formularios/Boleta/acc/AccBoletaActualizarVehiculoIngresoCaracteristica.php',
					data: 'Identificador='+Identificador+
				
					'&OvvId='+OrdenVentaVehiculoId,
					
					success: function(){
						$('#CapBoletaDetalleAccion').html('Listo');							
						FncBoletaDetalleListar();
					}
				});

}


/*
* SUNAT
*/

/*function FncBoletaGenerarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){

			}
		});

	}else{
		FncPopUp('formularios/Boleta/FrmBoletaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
	}

}*/
function FncBoletaGenerarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){

	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"La boleta ya se encuentra procesada",
			callback: function(result){

			}
		});

	}else{

//		FncPopUp('formularios/Boleta/FrmBoletaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
		tb_show(this.title,'formularios/Boleta/FrmBoletaGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

	}

}



function FncBoletaCalcularFechaVencimiento(){
	
	console.log("FncBoletaCalcularFechaVencimiento");
	
	var FechaHoy = $("#CmpFechaEmision").val();
	var CantidadDias = $("#CmpCantidadDia").val();
	var FechaVencimiento = "";
	

	if(FechaHoy!=""){
		if(CantidadDias!=""){
			var FechaVencimiento = FncSumarDias(FechaHoy,CantidadDias);
			
			$("#CmpFechaVencimiento").val(FechaVencimiento);
		}else{
			console.log("No hay Dias");
			$("#CmpFechaVencimiento").val("");
		}
	}else{
			console.log("No hay Fecha");
			$("#CmpFechaVencimiento").val("");
		}
	
	


	
}