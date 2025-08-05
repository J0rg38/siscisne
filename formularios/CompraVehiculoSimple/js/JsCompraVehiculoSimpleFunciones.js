// JavaScript Document

function FncValidar(){

		var ProveedorId = $("#CmpProveedorId").val();
		var ProveedorNombre = $("#CmpProveedorNombre").val();
		var ComprobanteNumeroNumero = $("#CmpComprobanteNumeroNumero").val();
		var Almacen = $("#CmpAlmacen").val();
		
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
//			alert("Debe escoger un responsable.");	

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe ingresar un numero de comprobante",
					callback: function(result){
						$("#CmpPersonal").focus();
					}
				});


			
			return false;
			
		}else if(Almacen == ""){
//			alert("Debe escoger un responsable.");	

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger un almacen destino",
					callback: function(result){
						$("#CmpPersonal").focus();
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
		
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpSucursal").removeAttr('disabled');	
		
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
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
"CmpCompraVehiculoDetalleCantidad",
"CmpCompraVehiculoDetalleImporte",
"CmpCompraVehiculoDetalleEstado",

"CmpProveedorNumeroDocumento",
"CmpProveedorNombre",
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
			FncCompraVehiculoNavegar(this.id);
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
		FncCompraVehiculoEstablecerMoneda();
	});
	
	$("#CmpComprobanteFecha").keyup(function(){
		FncTipoCambioCargarAux();	
	});
	
	$("select#CmpCondicionPago").change(function(){
		FncCompraVehiculoEstablecerCondicionPago();
	});
	
	
	
	
	$("#CmpCompraVehiculoDetalleImporte").keyup(function (event) {  
		FncCompraVehiculoSimpleDetalleCalcularCosto();
	});
	
	$("#CmpCompraVehiculoDetalleCantidad").keyup(function (event) {  
		FncCompraVehiculoSimpleDetalleCalcularImporte();
	});
	
	
});


	
function FncCompraVehiculoNavegar(oCampo){
	
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

	if("CmpCompraVehiculoDetalleEstado"==oCampo){
		$('#CmpCompraVehiculoDetalleEstado').blur();
		FncCompraVehiculoSimpleDetalleGuardar();
	}
		
}

function FncCompraVehiculoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		
		FncCompraVehiculoSimpleDetalleListar();
		
		alert("Debe Escoger una moneda");
	}else{
		
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			///if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			//}
		}

		FncMonedaBuscar('Id');
	}
}

function FncCompraVehiculoEstablecerCondicionPago(){
	
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
	
	FncCompraVehiculoSimpleDetalleListar();
	
}

function FncTipoCambioFuncion(InsTipoCambio){
	
	$('#CmpTipoCambioComercial').val(InsTipoCambio.TcaMontoComercial);
	
}

function FncVehiculoIngresoFuncion(InsVehiculoIngreso){
	
	$('#CmpCompraVehiculoDetalleCantidad').focus();	
	
	$('#CmpVehiculoId').val(InsVehiculoIngreso.VehId);	
	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoIngreso.VehCodigoIdentificador);
	
}

function FncVehiculoIngresoNuevoFuncion(){
	
	//FncCompraVehiculoSimpleDetalleNuevo();
	
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




 