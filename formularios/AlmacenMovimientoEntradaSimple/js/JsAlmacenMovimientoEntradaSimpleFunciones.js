// JavaScript Document

var FormularioCampos = [
"CmpFecha",

"CmpTipoOperacion",

"CmpAlmacen",
"CmpProveedorNumeroDocumento",
"CmpProveedorNombre",
"CmpComprobanteTipo",
"CmpComprobanteNumeroSerie",
"CmpComprobanteNumeroNumero",
"CmpComprobanteFecha",

"CmpCondicionPago",
"CmpCantidadDia",
"CmpMonedaId",

"CmpTipoCambio",
"CmpObservacion",

"CmpEstado",

"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoNombre",

"CmpProductoCantidad",
"CmpProductoCostoIngresoNeto",
"CmpProductoImporte"
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
		FncAlmacenMovimientoEntradaSimpleEstablecerMoneda();
	});
	
	$("#CmpComprobanteFecha").keyup(function(){
		FncTipoCambioCargarAux();	
	});
	
	$("select#CmpCondicionPago").change(function(){
		FncAlmacenMovimientoEntradaSimpleEstablecerCondicionPago();
	});
});


function FncTipoCambioCargarAux(){

	var MonedaId = $('#CmpMonedaId').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	FncTipoCambioCargar(MonedaId,Fecha,"Venta");

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
		FncAlmacenMovimientoEntradaSimpleDetalleGuardar();
	}
		
}


function FncAlmacenMovimientoEntradaSimpleEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		
		FncAlmacenMovimientoEntradaSimpleDetalleListar();
		
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

function FncAlmacenMovimientoEntradaSimpleEstablecerCondicionPago(){
	
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



function FncMonedaFuncion(){
	FncAlmacenMovimientoEntradaSimpleDetalleListar();
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