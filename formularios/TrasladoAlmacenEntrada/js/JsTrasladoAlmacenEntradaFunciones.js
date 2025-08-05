// JavaScript Document


function FncGuardar(){
	
	//HACK
	$("#CmpComprobanteTipo").removeAttr('disabled');		
	$("#CmpTipoOperacion").removeAttr('disabled');		
	$("#CmpAlmacen").removeAttr('disabled');
}

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
"CmpTrasladoAlmacenEntradaDetalleUbicacion",
"CmpTrasladoAlmacenEntradaDetalleEstado"
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

	
	
});


	
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

	if("CmpTrasladoAlmacenEntradaDetalleEstado"==oCampo){
		$('#CmpTrasladoAlmacenEntradaDetalleEstado').blur();
		FncTrasladoAlmacenEntradaDetalleGuardar();
	}
		
}




$().ready(function() {
		
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
