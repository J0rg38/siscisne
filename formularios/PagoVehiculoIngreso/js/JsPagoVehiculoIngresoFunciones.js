// JavaScript Document

function FncValidar(){

		var ProveedorId = $("#CmpProveedorId").val();
		var ProveedorNombre = $("#CmpProveedorNombre").val();
		var ComprobanteNumeroNumero = $("#CmpComprobanteNumeroNumero").val();
		var Sucursal = $("#CmpSucursal").val();
		
		if(ProveedorId == "" && ProveedorNombre !=""){		

				//alert("Debes ingresar una fecha de inicio");		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No has ingresado correctamente al proveedor",
					callback: function(result){
						$("#CmpProveedorNombre").select();
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
						$("#CmpProveedorNombre").focus();
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
						$("#CmpComprobanteNumeroNumero").focus();
					}
				});


			
			return false;
			
		}else if(Sucursal == ""){
//			alert("Debe escoger un responsable.");	

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger un almacen destino",
					callback: function(result){
						$("#CmpAlmacen").focus();
					}
				});


			
			return false;
		
		}else{
			return true;
		}
		
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpTipoOperacion").removeAttr('disabled');	
		$("#CmpSucursal").removeAttr('disabled');	
		
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpTipoOperacion").removeAttr('disabled');	
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

"CmpPagoVehiculoIngresoDetalleObservacion",

"CmpProveedorNumeroDocumento",
"CmpProveedorNombre",

"CmpComprobanteNumeroSerie",
"CmpComprobanteNumeroNumero",
"CmpComprobanteFecha",
"CmpMonedaId",
"CmpTipoCambio"];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncPagoVehiculoIngresoNavegar(this.id);
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
		FncPagoVehiculoIngresoEstablecerMoneda();
	});
	
	$("#CmpComprobanteFecha").keyup(function(){
		FncTipoCambioCargarAux();	
	});
	
	$("select#CmpCondicionPago").change(function(){
		FncPagoVehiculoIngresoEstablecerCondicionPago();
	});
	
	
	
	
	$("#CmpPagoVehiculoIngresoDetalleImporte").keyup(function (event) {  
		FncPagoVehiculoIngresoDetalleCalcularCosto();
	});
	
	$("#CmpPagoVehiculoIngresoDetalleCantidad").keyup(function (event) {  
		FncPagoVehiculoIngresoDetalleCalcularImporte();
	});
	
	
});


	
function FncPagoVehiculoIngresoNavegar(oCampo){
	
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

	if("CmpPagoVehiculoIngresoDetalleObservacion"==oCampo){
		$('#CmpPagoVehiculoIngresoDetalleObservacion').blur();
		FncPagoVehiculoIngresoDetalleGuardar();
	}
		
}

function FncPagoVehiculoIngresoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		
		FncPagoVehiculoIngresoDetalleListar();
		
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



/*
* FUNCIONES AUXILIARES
*/

function FncMonedaFuncion(){
	
	FncPagoVehiculoIngresoDetalleListar();
	
}

function FncTipoCambioFuncion(InsTipoCambio){
	
	$('#CmpTipoCambioComercial').val(InsTipoCambio.TcaMontoComercial);
	
}

function FncVehiculoIngresoFuncion(InsVehiculoIngreso){
	
	console.log("FncVehiculoIngresoFuncion");
	
//	$('#CmpPagoVehiculoIngresoDetalleImporte').focus();	
//	
//	$('#CmpVehiculoId').val(InsVehiculoIngreso.VehId);	
//	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoIngreso.VehCodigoIdentificador);
//	
	$('#CmpPagoVehiculoIngresoDetalleCantidad').val("1");	
	$('#CmpPagoVehiculoIngresoDetalleImporte').focus();	
	
	$('#CmpVehiculoId').val(InsVehiculoIngreso.VehId);	
	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoIngreso.VehCodigoIdentificador);
	$('#CmpPagoVehiculoIngresoDetalleUnidadMedida').val(InsVehiculoIngreso.UmeId);
	
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	if (MonedaId == InsVehiculoIngreso.MonIdIngreso){
		
		var Costo = InsVehiculoIngreso.EinCostoIngreso/InsVehiculoIngreso.EinTipoCambioIngreso;
		
		$('#CmpPagoVehiculoIngresoDetalleCostoIngreso').val(Costo);
		
	}else if(MonedaId == EmpresaMonedaId && InsVehiculoIngreso.MonIdIngreso == EmpresaMonedaId ){
		
		if(InsVehiculoIngreso.EinTipoCambioIngreso!=null){
			
//			var Costo = InsVehiculoIngreso.EinCostoIngreso/InsVehiculoIngreso.EinTipoCambioIngreso;
			var Costo = InsVehiculoIngreso.EinCostoIngreso;
			$('#CmpPagoVehiculoIngresoDetalleCostoIngreso').val(Costo);
		}
		
	}
	
	
}

function FncVehiculoIngresoNuevoFuncion(){
	
	//FncPagoVehiculoIngresoDetalleNuevo();
	
}

/*
* FUNCIONES LOCALES 
*/

function FncTipoCambioCargarAux(){

	var MonedaId = $('#CmpMonedaId').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	FncTipoCambioCargar(MonedaId,Fecha,"Venta");

}
 
function FncVehiculoIngresoFormularioFuncion(){
	FncVehiculoIngresoBuscar("Id");
}
