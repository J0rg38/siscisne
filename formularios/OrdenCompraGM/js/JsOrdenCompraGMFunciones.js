// JavaScript Document

function FncGuardar(){
	
	//HACK
	$("#CmpEstado").removeAttr('disabled');		
	$("#CmpTipo").removeAttr('disabled');		
	
	
}


var FormularioCampos = [
"CmpTipo",
"CmpCodigoDealer",
"CmpFecha",
"CmpHora",
"CmpMonedaId",
"CmpObservacion"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncOrdenCompraNavegar(this.id);
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
		FncOrdenCompraEstablecerMoneda();
	});
	
});
	
function FncOrdenCompraNavegar(oCampo){
	
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
		FncOrdenCompraDetalleGuardar();
	}
		
}




function FncOrdenCompraEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	//alert(MonedaId);

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		//FncOrdenCompraDetalleListar();

		FncOrdenCompraPedidoListar();
		
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







function FncImprmir(oId){
	FncPopUp('formularios/OrdenCompraGM/FrmOrdenCompraGMImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId){
	FncPopUp('formularios/OrdenCompraGM/FrmOrdenCompraGMImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}



function FncGenerarExcel(oId){
	FncPopUp('formularios/OrdenCompraGM/FrmOrdenCompraGMGenerarExcel.php?Id='+oId+'&P=2',0,0,1,0,0,1,0,screen.height,screen.width);
}