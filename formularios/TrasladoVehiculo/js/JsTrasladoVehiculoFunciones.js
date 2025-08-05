// JavaScript Document

function FncValidar(){

		var Fecha = $("#CmpFecha").val();
		var FechaLlegada = $("#CmpFechaLlegada").val();
		
		var Sucursal = $("#CmpSucursal").val();
		var SucursalDestino = $("#CmpSucursalDestino").val();
		
		if(Fecha == "" ){		

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de traslado",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
						
			return false;
			
		}else if(FechaLlegada == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de llegada",
					callback: function(result){
						$("#CmpFechaLlegada").focus();
					}
				});

			return false;
			
		}else if(FncValidarFecha(Fecha) == false){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de traslado valida",
					callback: function(result){
						$("#CmpFecha").select();
					}
				});
				
			return false;
			
		}else if(FncValidarFecha(FechaLlegada) == false){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de llegada valida",
					callback: function(result){
						$("#CmpFechaLlegada").select();
					}
				});
				
			return false;	
			
		}else if(Sucursal == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una sucursal de origen",
					callback: function(result){
						$("#CmpSucursal").focus();
					}
				});

			return false;
			
		}else if(SucursalDestino == ""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una sucursal de destino",
					callback: function(result){
						$("#CmpSucursalDestino").focus();
					}
				});

			return false;
			
		}else if(Sucursal == SucursalDestino){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"La sucursales de origen y destino no pueden ser iguaeles",
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
		
		$("#CmpSucursalDestino").removeAttr('disabled');	
		$("#CmpSucursal").removeAttr('disabled');	
		
		$("#CmpTipoOperacion").removeAttr('disabled');
		$("#CmpComprobanteTipo").removeAttr('disabled');
		$("#CmpEstado").removeAttr('disabled');
		
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpSucursalDestino").removeAttr('disabled');	
		$("#CmpSucursal").removeAttr('disabled');	
		
		$("#CmpTipoOperacion").removeAttr('disabled');
		$("#CmpComprobanteTipo").removeAttr('disabled');
		$("#CmpEstado").removeAttr('disabled');
		
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});




var FormularioCampos = [
"CmpPersonal",

"CmpFecha",
"CmpFechaLlegada",
"CmpComprobanteTipo",
"CmpReferenciaSerie",
"CmpReferenciaNumero",
"CmpSucursal",
"CmpSucursalDestino",
"CmpObservacionInterna",
"CmpObservacionImpresa",
"CmpEstado"
];

$().ready(function() {
	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncTrasladoVehiculoNavegar(this.id);
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

	$("#CmpTrasladoVehiculoDetalleImporte").keyup(function (event) {  
		FncTrasladoVehiculoDetalleCalcularCosto();
	});
	
	$("#CmpTrasladoVehiculoDetalleCantidad").keyup(function (event) {  
		FncTrasladoVehiculoDetalleCalcularImporte();
	});
	
	
});


	
function FncTrasladoVehiculoNavegar(oCampo){
	
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

	if("CmpTrasladoVehiculoDetalleEstado"==oCampo){
		$('#CmpTrasladoVehiculoDetalleEstado').blur();
		FncTrasladoVehiculoDetalleGuardar();
	}
		
}

function FncTrasladoVehiculoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpComprobanteFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		
		FncTrasladoVehiculoDetalleListar();
		
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

function FncTrasladoVehiculoEstablecerCondicionPago(){
	
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
	
	FncTrasladoVehiculoDetalleListar();
	
}

function FncTipoCambioFuncion(InsTipoCambio){
	
	$('#CmpTipoCambioComercial').val(InsTipoCambio.TcaMontoComercial);
	
}

function FncVehiculoIngresoFuncion(InsVehiculoIngreso){
	
	$('#CmpTrasladoVehiculoDetalleCantidad').focus();	
	
	$('#CmpVehiculoId').val(InsVehiculoIngreso.VehId);	
	$('#CmpVehiculoCodigoIdentificador').val(InsVehiculoIngreso.VehCodigoIdentificador);
	
}

function FncVehiculoIngresoNuevoFuncion(){
	
	//FncTrasladoVehiculoDetalleNuevo();
	
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




 