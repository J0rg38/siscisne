// JavaScript Document
//var VehiculoIngresoBuscarVariables = "";

function FncValidar(){

		var ClienteId = $("#CmpClienteId").val();
		var ClienteNombre = $("#CmpClienteNombre").val();
		var ComprobanteNumeroNumero = $("#CmpComprobanteNumeroNumero").val();
		var SucursalDestino = $("#CmpSucursalDestino").val();
		var TipoOperacion = $("#CmpTipoOperacion").val();
		
		if(ClienteId == "" && ClienteNombre !=""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No has ingresado correctamente al proveedor",
					callback: function(result){
						$("#CmpClienteNombre").select();
					}
				});
							
			
			return false;
		}else if(ClienteNombre == ""){			
//			alert("Debes ingresar una fecha de termino");			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un proveedor",
					callback: function(result){
						$("#CmpClienteNombre").focus();
					}
				});


			
			return false;
 		}else if(TipoOperacion == ""){			
//			alert("Debes ingresar una fecha de termino");			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de operacion",
					callback: function(result){
						$("#TipoOperacion").focus();
					}
				});


			
			return false;
		}else if(TipoOperacion == "TOP-10010" && SucursalDestino == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una sucursal destino",
					callback: function(result){
						$("#CmpSucursalDestino").focus();
					}
				});

 
			
			return false;
		
		}else{
			return true;
		}
		
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		$("#CmpSucursalDestino").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		$("#CmpSucursalDestino").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	//VehiculoIngresoBuscarVariables = "Moneda="+$("#CmpMonedaId").val();
	
});




var FormularioCampos = [
"CmpFecha",

"CmpGuiaRemisionNumeroSerie",
"CmpGuiaRemisionNumeroNumero",
"CmpGuiaRemisionFecha",
"CmpTipoOperacion",
"CmpEstado",
"CmpObservacion",

"CmpVehiculoIngresoVIN",

"CmpVehiculoMovimientoSalidaDetalleImporte",
"CmpVehiculoMovimientoSalidaDetalleObservacion",


"CmpClienteNumeroDocumento",
"CmpClienteNombre",
"CmpComprobanteTipo",
"CmpDocumentoOrigen",
"CmpComprobanteNumeroSerie",
"CmpComprobanteNumeroNumero",
"CmpComprobanteFecha",
"CmpMonedaId",
"CmpTipoCambio"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncVehiculoMovimientoSalidaNavegar(this.id);
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
		FncVehiculoMovimientoSalidaEstablecerMoneda();
	});
	
	$("#CmpComprobanteFecha").keyup(function(){
		FncTipoCambioCargarAux();	
	});
	
	$("select#CmpCondicionPago").change(function(){
		FncVehiculoMovimientoSalidaEstablecerCondicionPago();
	});
	
	
	
	
	$("#CmpVehiculoMovimientoSalidaDetalleImporte").keyup(function (event) {  
		FncVehiculoMovimientoSalidaSimpleDetalleCalcularCosto();
	});
	
	$("#CmpVehiculoMovimientoSalidaDetalleCantidad").keyup(function (event) {  
		FncVehiculoMovimientoSalidaSimpleDetalleCalcularImporte();
	});
	
	
});


	
function FncVehiculoMovimientoSalidaNavegar(oCampo){
	
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

	if("CmpVehiculoMovimientoSalidaDetalleObservacion"==oCampo){
		$('#CmpVehiculoMovimientoSalidaDetalleObservacion').blur();
		FncVehiculoMovimientoSalidaSimpleDetalleGuardar();
	}
		
}

function FncVehiculoMovimientoSalidaEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		
		FncVehiculoMovimientoSalidaSimpleDetalleListar();
		
		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId== MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			///if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			//}
		}

		FncMonedaBuscar('Id');
	}
}

function FncVehiculoMovimientoSalidaEstablecerCondicionPago(){
	
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

/*
* FUNCIONES AUXILIARES
*/

function FncMonedaFuncion(){
	
	FncVehiculoMovimientoSalidaSimpleDetalleListar();
	
}

function FncTipoCambioFuncion(InsTipoCambio){
	
	$('#CmpTipoCambioComercial').val(InsTipoCambio.TcaMontoComercial);
	
}

function FncVehiculoIngresoFuncion(InsVehiculoIngreso){
	
//	$('#CmpVehiculoMovimientoSalidaDetalleImporte').focus();	
//	
//	$('#CmpVehiculoId').val(InsVehiculoIngreso.VehId);	
//	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoIngreso.VehCodigoIdentificador);
//	
	$('#CmpVehiculoMovimientoSalidaDetalleImporte').focus();	
	
	$('#CmpVehiculoId').val(InsVehiculoIngreso.VehId);	
	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoIngreso.VehCodigoIdentificador);
	$('#CmpVehiculoMovimientoSalidaSimpleDetalleUnidadMedida').val(InsVehiculoIngreso.UmeId);
	
	var MonedaId = $('#CmpMonedaId').val();
	
	if (MonedaId == InsVehiculoIngreso.MonIdIngreso){

		$('#CmpVehiculoMovimientoSalidaDetalleCostoIngreso').val(InsVehiculoIngreso.EinCostoIngreso);
		
	}else{
		
		if(InsVehiculoIngreso.EinTipoCambioIngreso!=null){
			
			var Costo = InsVehiculoIngreso.EinCostoIngreso/InsVehiculoIngreso.EinTipoCambioIngreso;
			$('#CmpVehiculoMovimientoSalidaDetalleCostoIngreso').val(Costo);
		}else{
			$('#CmpVehiculoMovimientoSalidaDetalleCostoIngreso').val("0");
		
		}
		
	}
	
	
}

function FncVehiculoIngresoNuevoFuncion(){
	
	//FncVehiculoMovimientoSalidaSimpleDetalleNuevo();
	
}

/*
* FUNCIONES LOCALES 
*/

function FncTipoCambioCargarAux(){

	var MonedaId = $('#CmpMonedaId').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	FncTipoCambioCargar(MonedaId,Fecha,"Venta");

}

function FncCotizacionVehiculoDetalleSeleccionar(){
	
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




 