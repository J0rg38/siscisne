// JavaScript Document

function FncPagoFacturaExportacionBuscar(){


}


function FncGuardar(){
	
	//HACK
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');
	
}


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
"CmpFacturaExportacionDetalleUnidadMedida",
"CmpFacturaExportacionDetallePrecio",
"CmpFacturaExportacionDetalleCantidad",
"CmpFacturaExportacionDetalleImporte",

"CmpRegimenComprobanteNumero",
"CmpRegimenComprobanteFecha",
"CmpRegimenId",
"CmpRegimenPorcentaje",
"CmpRegimenMonto"

];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncFacturaExportacionNavegar(this.id);
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
	$("#CmpFacturaExportacionDetalleCantidad").keyup(function (event) {  
		FncFacturaExportacionDetalleCalcularImporte();
	});
	
	$("#CmpFacturaExportacionDetalleImporte").keyup(function (event) {  
		FnccFacturaExportacionDetalleCalcularPrecio();
	});
	
	$("#CmpFacturaExportacionDetallePrecio").keyup(function (event) {  
		FncFacturaExportacionDetalleCalcularImporte();
	});
	
	$("select#CmpMonedaId").change(function(){
		FncFacturaExportacionEstablecerMoneda();
	});

	$("select#CmpCondicionPago").change(function(){
		FncFacturaExportacionEstablecerCondicionPago();
	});

	$("select#CmpRegimenId").change(function(){
		FncFacturaExportacionEstablecerRegimen();
	});
	
});

	
function FncFacturaExportacionNavegar(oCampo){
	
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

		if("CmpFacturaExportacionDetalleImporte"==oCampo){
			$("#CmpFacturaExportacionDetalleImporte").blur();		
			FncFacturaExportacionDetalleGuardar();	
		}
	
}



function FncGenerarFacturaExportacionId(oTalonario){

	if(oTalonario!=""){
		$.ajax({
			type: 'POST',
			url: 'formularios/FacturaExportacion/acc/AccFacturaExportacionGenerarId.php',
			data: 'Talonario='+oTalonario,
			success: function(data){
				$('#CmpId').val(lTrim(data));	
			}
		});
	}else{
		$('#CmpId').val("");	
	}
		
}


function FncFacturaExportacionEstablecerCondicionPago(){
	
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


function FncFacturaExportacionEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFechaEmision').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		$('#CmpTipoCambio').attr('readonly', true);	
		
		FncFacturaExportacionDetalleListar();

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

function FncFacturaExportacionEstablecerRegimen(){

	var Regimen = $('#CmpRegimenId').val();

	if(Regimen==""){
		$('#CmpRegimenPorcentaje').attr('readonly', true).val("");
		$('#CmpRegimenMonto').attr('readonly', true).val("");
		$('#CmpRegimenComprobanteFecha').attr('readonly', true).val("");
		$('#CmpRegimenComprobanteNumero').attr('readonly', true).val("");
		FncFacturaExportacionDetalleListar();
	}else{
		$('#CmpRegimenPorcentaje').removeAttr('readonly');
		$('#CmpRegimenMonto').removeAttr('readonly');
		$('#CmpRegimenComprobanteFecha').removeAttr('readonly');
		$('#CmpRegimenComprobanteNumero').removeAttr('readonly');
		FncRegimenBuscar('Id');
	}

}

function FncMonedaFuncion(){

	FncFacturaExportacionDetalleListar();
	
}








function FncImprmir(oId,oTalonario,oOpcion){
	
	if(oOpcion==null){
		oOpcion = "1";
	}
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)",
oOpcion);
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/FacturaExportacion/FrmFacturaExportacionImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/FacturaExportacion/FrmFacturaExportacionImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


function FncVistaPreliminar(oId,oTalonario,oOpcion){
	
	if(oOpcion==null){
		oOpcion = "1";
	}
	
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)",
oOpcion);
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/FacturaExportacion/FrmFacturaExportacionImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/FacturaExportacion/FrmFacturaExportacionImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}







function FncPagoFacturaExportacionCargarFormulario(oForm,oFacturaExportacionId,oFacturaExportacionTalonarioId){

	tb_show(this.title,'principal2.php?Mod=PagoFacturaExportacion&Form='+oForm+'&Dia=1&FexId='+oFacturaExportacionId+'&FetId='+oFacturaExportacionTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){
	
	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

function FncVehiculoIngresoBuscar (){
	
	FncFacturaExportacionDetalleListar();
	
}



function FncFacturaExportacionDetalleCalcularImporte(){

	var Cantidad = $('#CmpFacturaExportacionDetalleCantidad').val();
	var Precio = $('#CmpFacturaExportacionDetallePrecio').val();
	var Importe = 0.00;

	if(Cantidad!="" && Precio!=""){
		Importe = parseFloat(Precio) * parseFloat(Cantidad);
		document.getElementById('CmpFacturaExportacionDetalleImporte').value = Importe;
	}

}

function FnccFacturaExportacionDetalleCalcularPrecio(){

	var Cantidad = $('#CmpFacturaExportacionDetalleCantidad').val();
	var Importe = $('#CmpFacturaExportacionDetalleImporte').val();
	var Precio = 0.00;

	if(Cantidad!="" && Importe!=""){
		Precio = parseFloat(Importe) / parseFloat(Cantidad);
		document.getElementById('CmpFacturaExportacionDetallePrecio').value = Precio;
	}

}
