
// JavaScript Document



var FormularioCampos = ["CmpCodigo",
"CmpFecha",
"CmpFechaVigencia",
"CmpMonedaId",
"CmpTipoCambio",
"CmpVehiculoMarca",
"CmpAnoFabricacion",
"CmpObservacion",

"CmpEstado",

"CmpVehiculoModelo",
"CmpVehiculoVersion",
"CmpVehiculoListaPrecioDetalleFuente",
"CmpVehiculoListaPrecioDetalleCosto",
"CmpVehiculoListaPrecioDetallePrecioCierre",

"CmpVehiculoListaPrecioDetallePrecioLista",
"CmpVehiculoListaPrecioDetalleBonoGM",
"CmpVehiculoListaPrecioDetalleBonoDealer",
"CmpVehiculoListaPrecioDetalleDescuentoGerencia"

];


$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden" && this.type !=="image") {
			FncVentaDirectaNavegar(this.id);
		 }
	}); 

	$("input,select,textarea").focus(function () {  
		if (this.type !== "hidden" && this.type !=="image") {
			$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 

	$("input,select,textarea").blur(function () {  
		if (this.type !== "hidden" && this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 

/*
Agregando Eventos
*/
	$("select#CmpVehiculoMarca").change(function(){
		FncVehiculoModelosCargar();
		$('#CmpVehiculoVersion').html('');	
	});

	$("select#CmpVehiculoModelo").change(function(){
		FncVehiculoVersionesCargar();
	});

	
});
	
function FncVentaDirectaNavegar(oCampo){

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

	if("CmpVehiculoListaPrecioDetalleDescuentoGerencia"==oCampo){
		$('#CmpVehiculoListaPrecioDetalleDescuentoGerencia').blur();
		FncVehiculoListaPrecioDetalleGuardar();		
	}

	//alert(oCampo);
}



