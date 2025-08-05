// JavaScript Document



function FncValidar(){

	var TipoGasto = $("#CmpTipoGasto").val();
	var Nombre = $("#CmpNombre").val();
		
		if(TipoGasto == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo",
					callback: function(result){
						$("#CmpTipoGasto").focus();
					}
				});
				
			return false;
		
		}else if(Nombre == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre",
					callback: function(result){
						$("#CmpNombre").focus();
					}
				});
				
			return false;
			
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/	

	
});


function FncGuardar(){
	
	//HACK
	$("#CmpProveedorTipoDocumento").removeAttr('disabled');

			
}

var FormularioCampos = [
"CmpFecha",
"CmpProveedorNumeroDocumento",
"CmpProveedorNombre",
"CmpComprobanteTipo",
"CmpTipoOperacion",
"CmpComprobanteNumeroSerie",
"CmpComprobanteNumeroNumero",
"CmpComprobanteFecha",
"CmpCondicionPago",
"CmpCantidadDia",
"CmpMonedaId",
"CmpTipoCambio",

"CmpConcepto",
"CmpObservacion",
"CmpTotal",
"CmpEstado"
];

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

	

	$("select#CmpMonedaId").change(function(){
		FncServicioRepuestoEstablecerMoneda();
	});
	
	$("#CmpComprobanteFecha").keyup(function(){
		FncTipoCambioCargarAux();	
	});
	
	$("select#CmpCondicionPago").change(function(){
		FncServicioRepuestoEstablecerCondicionPago();
	});
	
	
});


function FncTipoCambioCargarAux(){

	var MonedaId = $('#CmpMonedaId').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	FncTipoCambioCargar(MonedaId,Fecha,"Venta");

}
	
function FncServicioRepuestoNavegar(oCampo){
	
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

}


function FncServicioRepuestoEstablecerDocumentoOrigen(){

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
		$('#CmpTotalServicioRepuestoAdministrativo').attr('readonly', true);
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
		$('#CmpTotalServicioRepuestoAdministrativo').removeAttr('readonly');
		$('#CmpTotalOtroCosto1').removeAttr('readonly');
		$('#CmpTotalOtroCosto2').removeAttr('readonly');
	}



}



function FncServicioRepuestoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		
		FncServicioRepuestoDetalleListar();
		
		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
		}

		FncMonedaBuscar('Id');
	}
}

function FncServicioRepuestoEstablecerCondicionPago(){
	
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




function FncServicioRepuestoCostoVinculadoListar(){

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
	
	var TotalAduana = parseFloat($('#CmpTotalAduana').val());
	var TotalTransporte = parseFloat($('#CmpTotalTransporte').val());
	var TotalDesestiba = parseFloat($('#CmpTotalDesestiba').val());
	var TotalAlmacenaje = parseFloat($('#CmpTotalAlmacenaje').val());
	var TotalAdValorem = parseFloat($('#CmpTotalAdValorem').val());
	var TotalAduanaNacional = parseFloat($('#CmpTotalAduanaNacional').val());
	var TotalServicioRepuestoAdministrativo = parseFloat($('#CmpTotalServicioRepuestoAdministrativo').val());
	var TotalOtroCosto1 = parseFloat($('#CmpTotalOtroCosto1').val());
	var TotalOtroCosto2 = parseFloat($('#CmpTotalOtroCosto2').val());
	
	var TotalImportacion = TotalAduana + TotalTransporte + TotalDesestiba + TotalAlmacenaje + TotalAdValorem + TotalAduanaNacional + TotalServicioRepuestoAdministrativo + TotalOtroCosto1 + TotalOtroCosto2;
	
	$('#CmpTotalImportacion').val(TotalImportacion);
	
	$.ajax({
		type: 'POST',
		url: 'formularios/ServicioRepuesto/FrmServicioRepuestoCostoVinculadoListado.php',
		data: 'Identificador='+Identificador+'&TotalRecargo='+TotalRecargo+'&TotalFlete='+TotalFlete+'&TotalOtroCosto='+TotalOtroCosto+'&TotalAduana='+TotalAduana+'&TotalTransporte='+TotalTransporte+'&TotalDesestiba='+TotalDesestiba+'&TotalAlmacenaje='+TotalAlmacenaje+'&TotalAdValorem='+TotalAdValorem+'&TotalAduanaNacional='+TotalAduanaNacional+'&TotalServicioRepuestoAdministrativo='+TotalServicioRepuestoAdministrativo+'&TotalOtroCosto1='+TotalOtroCosto1+'&TotalOtroCosto2='+TotalOtroCosto+'&TotalImportacion='+TotalImportacion+'&MonedaId='+MonedaId+'&MonedaSimbolo='+MonedaSimbolo+'&TipoCambio='+TipoCambio,
		success: function(html){
			$('#CapCostoVinculadoAccion').html('Listo');	
			$("#CapServicioRepuestoCostoVinculados").html("");
			$("#CapServicioRepuestoCostoVinculados").append(html);
		}
	});
	
}

function FncMonedaFuncion(){
	
}




/*
* FUNCIOENS VISUALIZACION
*/

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


