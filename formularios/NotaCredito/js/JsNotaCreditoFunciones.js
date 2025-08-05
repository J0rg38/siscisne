// JavaScript Document


function FncValidar(){

		var NotaCreditoTalonario = $("#CmpTalonario").val();
		var NotaCreditoId = $("#CmpId").val();
		var FechaEmision = $("#CmpFechaEmision").val();	
		var MonedaId = $("#CmpMonedaId").val();
		
		var ClienteId = $("#CmpClienteId").val();	
		var ClienteNombre = $("#CmpClienteNombre").val();
		
		var Motivo = $("#CmpMotivo").val();
		var MotivoCodigo = $("#CmpMotivoCodigo").val();	

		if(MonedaId == ""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#NotaCreditoTalonario").focus();
					}
				});
							
			
			return false;
			
		}else if(NotaCreditoTalonario == ""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un numero de serie",
					callback: function(result){
						$("#NotaCreditoTalonario").focus();
					}
				});
							
			
			return false;
		}else if(NotaCreditoId == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero de comprobante",
					callback: function(result){
						$("#CmpId").focus();
					}
				});

			
			return false;
		}else if(FechaEmision == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar una fecha de comprobante",
					callback: function(result){
						$("#CmpFechaEmision").focus();
					}
				});

			return false;
			
			}else if(ClienteId == "" && ClienteNombre != ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha ingresado correctamente al cliente",
					callback: function(result){
						$("#CmpClienteNombre").focus();
					}
				});

			return false;
			
		}else if(ClienteNombre == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un cliente",
					callback: function(result){
						$("#CmpClienteNombre").focus();
					}
				});

			return false;
		}else if(Motivo == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un motivo",
					callback: function(result){
						$("#CmpMotivo").focus();
					}
				});

			return false;
		}else if(MotivoCodigo == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un codigo de motivo",
					callback: function(result){
						$("#CmpMotivoCodigo").focus();
					}
				});

			return false;
		}else{
			
			return true;
		}
		
	
}


var FormularioCampos = ["CmpClienteNombre",
"CmpClienteNumeroDocumento",
"CmpClienteDireccion",
"CmpGuiaRemision",
"CmpFechaEmision",
"CmpObservacion",
"CmpObservacionImpresa",
"CmpPorcentajeImpuestoVenta",
"CmpEstado",
"CmpNotaCreditoDetalleDescripcion",
"CmpNotaCreditoDetallePrecio",
"CmpNotaCreditoDetalleCantidad",
"CmpNotaCreditoDetalleImporte"];

$().ready(function() {
	
	
		
	$('#FrmRegistrar').on('submit', function() {

		$("#CmpIncluyeImpuesto").removeAttr('disabled');
		$("#CmpTipo").removeAttr('disabled');
		$("#CmpMonedaId").removeAttr('disabled');
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		$("#CmpIncluyeImpuesto").removeAttr('disabled');
		$("#CmpTipo").removeAttr('disabled');
		$("#CmpMonedaId").removeAttr('disabled');
		return FncValidar();

	});
	
	
	
	
	
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncNotaCreditoNavegar(this.id);
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

	$("#CmpNotaCreditoDetalleCantidad").keyup(function (event) {  
		FncNotaCreditoDetalleCalcularImporte();
	});
	
	$("#CmpNotaCreditoDetalleImporte").keyup(function (event) {  
		FnccNotaCreditoDetalleCalcularPrecio();
	});
	
	$("#CmpNotaCreditoDetallePrecio").keyup(function (event) {  
		FncNotaCreditoDetalleCalcularImporte();
	});
	
	
	/*$("#CmpMotivoCodigo").change(function (event) {  
		FncEstablecerSunatCatalogo();
	});*/
		

});
	
function FncNotaCreditoNavegar(oCampo){
	
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

		if(FormularioCampos[FormularioCampos.length-1]==oCampo){
			$('#'+FormularioCampos[FormularioCampos.length-1]).blur();		
			FncNotaCreditoDetalleGuardar();	
			
		}
	
}




function FncGenerarNotaCreditoId(oTalonario){

	if(oTalonario!=""){
	
		$.ajax({
			type: 'POST',
			url: 'formularios/NotaCredito/acc/AccNotaCreditoGenerarId.php',
			data: 'Talonario='+oTalonario,
			success: function(data){
				$('#CmpId').val(lTrim(data));	
			}
		});

	}else{
		$('#CmpId').val("");	
	}

}

//function FncEstablecerSunatCatalogo(){
//	
//	var MotivoCodigo = $("#CmpMotivoCodigo").val();
//	
//	if(MotivoCodigo!=""){
//			
//		$.getJSON("formularios/NotaCredito/jn/JnSunatCatalogo.php?CodigoMotivo="+MotivoCodigo,{}, 
//		function(j){
//		
//			$("#CmpMotivo").val(j.ScaDescripcion);
//				
//		});
//
//	}
//
//}






function FncImprmir(oId,oTalonario){
	
var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato A4 \n 3 = Formato PDF", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/NotaCredito/FrmNotaCreditoImprimir.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarPDF.php?Id='+oId+'&Ta='+oTalonario+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}


function FncVistaPreliminar(oId,oTalonario){
	
		var Tipo = prompt("Escoja el tipo de impresion \n 1 = Formato A4 \n 3 = Formato PDF", "1");
			
			if(Tipo !== null){
				switch(Tipo.toUpperCase()){
					case "1":
					
FncPopUp('formularios/NotaCredito/FrmNotaCreditoImprimir.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
					
					case "3":

FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarPDF.php?Id='+oId+'&Ta='+oTalonario,0,0,1,0,0,1,0,screen.height,screen.width);

					break;
				
				}
				
			}

}

function FncDocumentoFuncion(){
	FncNotaCreditoDetalleDocumentoGuardar();	
}



function FncNotaCreditoDetalleCalcularImporte(){

	var Cantidad = $('#CmpNotaCreditoDetalleCantidad').val();
	var Precio = $('#CmpNotaCreditoDetallePrecio').val();
	var Importe = 0.00;

	if(Cantidad!="" && Precio!=""){
		Importe = parseFloat(Precio) * parseFloat(Cantidad);
		document.getElementById('CmpNotaCreditoDetalleImporte').value = Importe;
	}

}

function FnccNotaCreditoDetalleCalcularPrecio(){

	var Cantidad = $('#CmpNotaCreditoDetalleCantidad').val();
	var Importe = $('#CmpNotaCreditoDetalleImporte').val();
	var Precio = 0.00;

	if(Cantidad!="" && Importe!=""){
		Precio = parseFloat(Importe) / parseFloat(Cantidad);
		document.getElementById('CmpNotaCreditoDetallePrecio').value = Precio;
	}
	
}



function FncNotaCreditoGenerarXMLv2(oId,oTalonario,oTicket,oProcesar,oSUNAT){
	
	if(oTicket!=""){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El comprobante ya se encuentra procesado",
			callback: function(result){
				
			}
		});
				
	}else{
		//FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar=1&EnviarSUNAT=1',0,0,1,0,0,1,0,350,150);
		//FncPopUp('formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT,0,0,1,0,0,1,0,350,150);
		tb_show(this.title,'formularios/NotaCredito/FrmNotaCreditoGenerarXMLv2.php?Id='+oId+'&Ta='+oTalonario+'&Procesar='+oProcesar+'&EnviarSUNAT='+oSUNAT+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=400&modal=false',this.rel);

	}
	
		
}