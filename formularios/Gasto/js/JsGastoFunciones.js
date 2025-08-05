// JavaScript Document
//function FncGuardar(){
//	
//	//HACK
//	$("#CmpProveedorTipoDocumento").removeAttr('disabled');
//
//			
//}


function FncValidar(){

		var ProveedorId = $("#CmpProveedorId").val();
		var ProveedorNombre = $("#CmpProveedorNombre").val();
		var ComprobanteNumeroNumero = $("#CmpComprobanteNumeroNumero").val();
		
		var ComprobanteFecha = $("#CmpComprobanteFecha").val();
		var ComprobanteNumeroNumero = $("#CmpComprobanteNumeroNumero").val();
		var ComprobanteNumeroSerie = $("#CmpComprobanteNumeroSerie").val();
		
		var Fecha = $("#CmpFecha").val();
		
		var Almacen = $("#CmpAlmacen").val();
		var Sucursal = $("#CmpSucursal").val();
		
		if(ProveedorId == "" && ProveedorNombre !=""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No has ingresado correctamente al proveedor",
					callback: function(result){
						$("#CmpFechaInicio").focus();
					}
				});
							
			
			return false;
		
		}else if(ProveedorNombre == ""){			
//			alert("Debes ingresar una fecha de termino");			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un proveedor",
					callback: function(result){
						$("#CmpFechaFin").focus();
					}
				});
	
			return false;

		}else if(ComprobanteNumeroNumero == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar un numero de comprobante",
					callback: function(result){
						$("#CmpComprobanteNumeroNumero").focus();
					}
				});

			return false;

		}else if(ComprobanteNumeroSerie == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar un numero de serie de comprobante",
					callback: function(result){
						$("#CmpComprobanteNumeroSerie").focus();
					}
				});

			return false;
			
			
		}else if(ComprobanteFecha == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar una fecha de comprobante",
					callback: function(result){
						$("#CmpComprobanteFecha").focus();
					}
				});

			return false;
			
			}else if(ComprobanteFecha == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar una fecha de comprobante",
					callback: function(result){
						$("#CmpComprobanteFecha").focus();
					}
				});

			return false;
			
			
			}else if(Fecha == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar una fecha",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});

			return false;
				
			
			
		}else{
			return true;
		}
		
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');		
		$("#CmpEstado").removeAttr('disabled');	
		$("#CmpPersonalRegistro").removeAttr('disabled');	
		$("#CmpTipoOperacion").removeAttr('disabled');	
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpClienteTipoDocumento").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
		$("#CmpPersonalRegistro").removeAttr('disabled');			
		$("#CmpTipoOperacion").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});





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
			FncGastoNavegar(this.id);
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

	//$("select#CmpMonedaId").change(function(){
//		FncGastoEstablecerMoneda();
//	});
	
	$("#CmpComprobanteFecha").keyup(function(){
		FncTipoCambioCargarAux();	
	});
	
	$("select#CmpCondicionPago").change(function(){
		FncGastoEstablecerCondicionPago();
	});
	
	
});




function FncGastoNavegar(oCampo){
	
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


function FncTipoCambioCargarAux(){

	var MonedaId = $('#CmpMonedaId').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	FncTipoCambioCargar(MonedaId,Fecha,"Venta");

}
	
function FncGastoEstablecerCondicionPago(){
	
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
	
}




/*
* FUNCIOENS VISUALIZACION
*/


