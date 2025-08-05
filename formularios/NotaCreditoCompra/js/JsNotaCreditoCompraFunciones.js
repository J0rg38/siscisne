// JavaScript Document


function FncGuardar(){
	
	//HACK
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpCancelado").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');
	$("#CmpMonedaId").removeAttr('disabled');
	$("#CmpAlmacen").removeAttr('disabled');
}


var FormularioCampos = ["CmpFechaEmision",
"CmpObservacion",
"CmpObservacionImpresa",
"CmpEstado",

"CmpNotaCreditoCompraDetalleEstado",
"CmpProductoCodigoOriginal",
"CmpProductoNombre",
"CmpProductoUnidadMedidaConvertir",
"CmpNotaCreditoCompraDetalleCantidad",
"CmpNotaCreditoCompraDetallePrecio",
"CmpNotaCreditoCompraDetalleImporte"

];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncNotaCreditoCompraNavegar(this.id);
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

	$("#CmpNotaCreditoCompraDetalleCantidad").keyup(function (event) {  
		FncNotaCreditoCompraDetalleCalcularImporte();
	});
	
	$("#CmpNotaCreditoCompraDetalleImporte").keyup(function (event) {  
		FnccNotaCreditoCompraDetalleCalcularPrecio();
	});
	
	$("#CmpNotaCreditoCompraDetallePrecio").keyup(function (event) {  
		FncNotaCreditoCompraDetalleCalcularImporte();
	});
	
	
});
	
function FncNotaCreditoCompraNavegar(oCampo){
	
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

		if("CmpNotaCreditoCompraDetalleImporte"==oCampo){
			$("#CmpNotaCreditoCompraDetalleImporte").blur();		
			FncNotaCreditoCompraDetalleGuardar();	
			
		}
	
}


function FncNotaCreditoCompraEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFechaEmision').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		$('#CmpTipoCambio').attr('readonly', true);	
		
		FncNotaCreditoCompraDetalleListar();
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
			
		}

		FncMonedaBuscar('Id');
	}

}


function FncImprmir(oId,oTalonario){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/NotaCreditoCompra/FrmNotaCreditoCompraImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/NotaCreditoCompra/FrmNotaCreditoCompraImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


function FncVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");			
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/NotaCreditoCompra/FrmNotaCreditoCompraImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/NotaCreditoCompra/FrmNotaCreditoCompraImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}

function FncMonedaFuncion(){
	FncNotaCreditoCompraDetalleListar();
}

function FncNotaCreditoCompraDetalleCalcularImporte(){

	var Cantidad = $('#CmpNotaCreditoCompraDetalleCantidad').val();
	var Precio = $('#CmpNotaCreditoCompraDetallePrecio').val();
	var Importe = 0.00;

	if(Cantidad!="" && Precio!=""){
		Importe = parseFloat(Precio) * parseFloat(Cantidad);
		document.getElementById('CmpNotaCreditoCompraDetalleImporte').value = Importe;
	}

}

function FnccNotaCreditoCompraDetalleCalcularPrecio(){

	var Cantidad = $('#CmpNotaCreditoCompraDetalleCantidad').val();
	var Importe = $('#CmpNotaCreditoCompraDetalleImporte').val();
	var Precio = 0.00;

	if(Cantidad!="" && Importe!=""){
		Precio = parseFloat(Importe) / parseFloat(Cantidad);
		document.getElementById('CmpNotaCreditoCompraDetallePrecio').value = Precio;
	}
	
}
