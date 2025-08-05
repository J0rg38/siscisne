// JavaScript Document

var FormularioCampos = ["CmpTipo",
"CmpAno",
"CmpMes",
"CmpCodigoDealer",
"CmpFecha",
"CmpHora",
"CmpEstado",
"CmpMonedaId",
"CmpTipoCambio",
"CmpObservacion",
"CmpProductoCodigoOriginal",
"CmpProductoCodigoAlternativo",
"CmpProductoCodigoOtro",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpProductoCantidad",
"CmpProductoPrecio",
"CmpProductoImporte"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncOrdenCompraGMEntradaNavegar(this.id);
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
//	$("select#CmpMonedaId").change(function(){
//		FncOrdenCompraGMEntradaEstablecerMoneda();
//	});
	
});
	
function FncOrdenCompraGMEntradaNavegar(oCampo){
	
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


function FncOrdenCompraGMEntradaEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncOrdenCompraGMEntradaPedidoListar();
		alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId);				
			}
		}
		FncMonedaBuscar('Id');
	}
}

//
//function FncImprmir(oId){
//	FncPopUp('formularios/OrdenCompraGMEntrada/FrmOrdenCompraGMEntradaImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
//}
//
//function FncVistaPreliminar(oId){
//	FncPopUp('formularios/OrdenCompraGMEntrada/FrmOrdenCompraGMEntradaImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
//}
//
//function FncGenerarExcel(oId){
//	FncPopUp('formularios/OrdenCompraGMEntrada/FrmOrdenCompraGMEntradaImprimir.php?Id='+oId+'&P=2',0,0,1,0,0,1,0,screen.height,screen.width);
//}