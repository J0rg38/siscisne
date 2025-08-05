// JavaScript Document

function FncPagoFacturaBuscar(){


}


function FncGuardar(){
	
	//HACK
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	$("#CmpCancelado").removeAttr('disabled');		
	$("#CmpIncluyeImpuesto").removeAttr('disabled');
}



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

	$("#CmpFacturaDetalleCantidad").keyup(function (event) {  
		FncFacturaDetalleCalcularImporte();
	});
	
	$("#CmpFacturaDetalleImporte").keyup(function (event) {  
		FnccFacturaDetalleCalcularPrecio();
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
				FncTipoCambioCargar(MonedaId,Fecha);				
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


function FncImprmir(oId,oTalonario){
	
	var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


function FncVistaPreliminar(oId,oTalonario){

	var Tipo = prompt("Escoja el tipo de vista preliminar \n 1 = Formato 1 (Impresion s/ formato) \n 2 = Formato 2 (Impresion c/ formato)", "1");			
	
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/Factura/FrmFacturaImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "2":

FncPopUp('formularios/Factura/FrmFacturaImprimir2.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


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


function FncMonedaFuncion(){
	FncFacturaDetalleListar();
}






//function FncClientePagoCargarFormulario(oForm,oFacturaId,oFacturaTalonarioId){
//	
//	
//	tb_show(this.title,'principal2.php?Mod=ClientePagoFactura&Form='+oForm+'&Dia=1&FacId='+oFacturaId+'&FtaId='+oFacturaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		
//
//}
function FncPagoFacturaCargarFormulario(oForm,oFacturaId,oFacturaTalonarioId){
	
	tb_show(this.title,'principal2.php?Mod=PagoFactura&Form='+oForm+'&Dia=1&FacId='+oFacturaId+'&FtaId='+oFacturaTalonarioId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}


function FncVehiculoIngresoCargarFormulario(oForm,oVehiculoIngresoId){
	
	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

function FncVehiculoIngresoBuscar (){
	
	FncFacturaDetalleListar();
	
}














function FncFacturaDetalleCalcularImporte(){

	var Cantidad = $('#CmpFacturaDetalleCantidad').val();
	var Precio = $('#CmpFacturaDetallePrecio').val();
	var Importe = 0.00;

	if(Cantidad!="" && Precio!=""){
		Importe = parseFloat(Precio) * parseFloat(Cantidad);
		document.getElementById('CmpFacturaDetalleImporte').value = Importe;
	}

}

function FnccFacturaDetalleCalcularPrecio(){

	var Cantidad = $('#CmpFacturaDetalleCantidad').val();
	var Importe = $('#CmpFacturaDetalleImporte').val();
	var Precio = 0.00;

	if(Cantidad!="" && Importe!=""){
		Precio = parseFloat(Importe) / parseFloat(Cantidad);
		document.getElementById('CmpFacturaDetallePrecio').value = Precio;
	}
	
}
