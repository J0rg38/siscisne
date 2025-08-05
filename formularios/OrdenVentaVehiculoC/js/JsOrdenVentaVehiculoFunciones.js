// JavaScript Document


function FncValidar(){

	var ClienteId = $("#CmpClienteId").val();
	var ClienteNombre = $("#CmpClienteNombre").val();
	var ClienteNumeroDocumento = $("#CmpClienteNumeroDocumento").val();
	var Fecha = $("#CmpFecha").val();

	var MonedaId = $("#CmpMonedaId").val();
	var TipoCambio = $("#CmpTipoCambio").val();
	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
	var VehiculoVersion = $("#CmpVehiculoVersion").val();
	var AnoModelo = $("#CmpVehiculoAnoModelo").val();
	var Total = $("#CmpTotal").val();
	var Precio = $("#CmpPrecio").val();
	var ComprobanteVenta = $("#CmpComprobanteVenta").val();	
	var PropietariosTotal = $("#CmpPropietariosTotal").val();	
	var CondicionPago = $("#CmpCondicionPago").val();
	
		if(Fecha == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha",
					callback: function(result){
						$("#CmpFecha").focus();
					}
				});
				
			return false;
		
		}else if(FncValidarFechaNormal(Fecha)==false){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha valida",
					callback: function(result){
						$("#CmpFecha").select();
					}
				});
				
			return false;
			
		}else if(ClienteNombre == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre de cliente",
					callback: function(result){
						$("#CmpClienteNombre").focus();
					}
				});
				
			return false;
			
		}else if(ClienteNumeroDocumento == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero de documento",
					callback: function(result){
						$("#CmpClienteNumeroDocumento").focus();
					}
				});
				
			return false;
			
		}else if(ClienteId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No se ha ingresado correctamente al cliente",
					callback: function(result){
						$("#CmpClienteNombre").select();
					}
				});
				
			return false;
			
		}else if(MonedaId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpMonedaId").focus();
					}
				});
				
			return false;
			
		}else if(MonedaId != EmpresaMonedaId && TipoCambio == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un tipo de cambio",
					callback: function(result){
						$("#CmpTipoCambio").focus();
					}
				});
				
			return false;
	
		}else if(VehiculoMarca == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una marca de vehiculo",
					callback: function(result){
						$("#CmpVehiculoMarca").focus();
					}
				});
				
			return false;
	
		}else if(VehiculoModelo == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un modelo de vehiculo",
					callback: function(result){
						$("#CmpVehiculoModelo").focus();
					}
				});
				
			return false;
	
		}else if(VehiculoVersion == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una version de vehiculo",
					callback: function(result){
						$("#CmpVehiculoVersion").focus();
					}
				});
				
			return false;
			
		}else if(AnoModelo == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un año de modelo",
					callback: function(result){
						$("#CmpVehiculoAnoModelo").focus();
					}
				});
				
			return false;
				
		}else if(Total == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un total",
					callback: function(result){
						$("#CmpTotal").focus();
					}
				});
				
			return false;		
		
		}else if(ComprobanteVenta == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger el tipo de comprobante a emitir",
					callback: function(result){
						$("#CmpComprobanteVenta").focus();
					}
				});
				
			return false;		
		
			}else if(PropietariosTotal == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar al menos un propietario",
					callback: function(result){
						$("#CmpPropietarioNombre").focus();
					}
				});
				
			return false;	
			
			}else if(CondicionPago == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una forma de pago",
					callback: function(result){
						$("#CmpCondicionPago").focus();
					}
				});
				
			return false;	
			
		}else{
			return true;
		}
		
	
		

}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		$("#CmpInmediata").removeAttr('disabled');		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
		$("#CmpInmediata").removeAttr('disabled');
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});


function FncGuardar(){

//HACK
//	$('#CmpClienteTipoDocumento').removeAttr('disabled');
//	
//	$('#CmpVehiculoMarca').removeAttr('disabled');
//	$('#CmpVehiculoModelo').removeAttr('disabled');
//	$('#CmpVehiculoVersion').removeAttr('disabled');
//	
//	$('#CmpEstado').removeAttr('disabled');
//	
//	FncOrdenVentaVehiculoEstablecerMantenimiento();
//			
}


/*
* CAMPOS FORMULARIO
*/
var FormularioCampos = [
"CmpFechaEmision",
"CmpClienteNumeroDocumento",
"CmpClienteNombre",
"CmpCondicionPago",
"CmpComprobanteTipo",
"CmpDocumentoNumero",
"CmpDocumentoFecha",
"CmpIncluyeImpuesto",
"CmpPorcentajeImpuestoVenta",
"CmpGuiaRemisionNumero",
"CmpGuiaRemisionFecha",
"CmpEstado",
"CmpObservacion",
"CmpProductoId",
"CmpProductoNombre",
"CmpProductoCantidad",
"CmpProductoCosto",
"CmpProductoImporte"];

/*
*** EVENTOS
*/	
$().ready(function() {

/*
* EVENTOS - NAVEGACION
*/	
	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncAlmacenMovimientoNavegar(this.id);
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
* EVENTOS - INICIALES
*/

	$("select#CmpMonedaId").change(function(){
		FncOrdenVentaVehiculoEstablecerMoneda();
	});

	$("select#CmpVehiculoMarca").change(function(){

		$("#CapVehiculoIngreso").html("");
		FncVehiculoModelosCargar();
		FncOrdenVentaVehiculoEstablecerMantenimiento();
		
	});

	$("select#CmpVehiculoModelo").change(function(){
		FncVehiculoVersionesCargar();
		FncVehiculoIngresoListar();
	});

	$("select#CmpVehiculoVersion").change(function(){
		FncVehiculoIngresoListar();
	});
	

	$("#CmpVehiculoAnoModelo").keyup(function () {  
		
		var aux = $(this).val();
		
		if(aux.length==4){
			FncVehiculoIngresoListar();			
		}
		
	}); 

	$("#CmpVehiculoAnoFabricacion").keyup(function () {  
		
		var aux = $(this).val();
		
		if(aux.length==4){
			FncVehiculoIngresoListar();			
		}
		
	}); 

	$("#CmpVehiculoColor").keyup(function () {  
		FncVehiculoIngresoListar();
	}); 

		
	$("#CmpDescuento").keyup(function () {  
		FncOrdenVentaVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpBonoGM").keyup(function () {  
		FncOrdenVentaVehiculoDetalleCalcularTotal();
	}); 

	$("#CmpBonoDealer").keyup(function () {  
		FncOrdenVentaVehiculoDetalleCalcularTotal();
	}); 


	$("#CmpTotal").keyup(function () {  
		FncOrdenVentaVehiculoDetalleCalcularDescuento();
	}); 
	
	
	
	$("#BtnBuscarVIN").click(function () {  

		FncBuscarVIN();
		
	}); 
	
	
	
	
	
	
	
//	$("#BtnBuscarVIN").click(function () {  
//		
//		var VehiculoMarca = $("#CmpVehiculoMarca").val();
//		var VehiculoModelo = $("#CmpVehiculoModelo").val();
//		var VehiculoVersion = $("#CmpVehiculoVersion").val();
//		var AnoModelo = $("#CmpVehiculoAnoModelo").val();
//		var Color = $("#CmpVehiculoColor").val();
//		
//		if(VehiculoMarca==""){
//			
//			dhtmlx.alert({
//				title:"Aviso",
//				type:"alert-error",
//				text:"Debes escoger una marca de vehiculo",
//				callback: function(result){
//					$("#CmpVehiculoMarca").focus();
//				}
//			});
//				
//		}else if(VehiculoModelo==""){
//			
//			dhtmlx.alert({
//				title:"Aviso",
//				type:"alert-error",
//				text:"Debes escoger un modelo de vehiculo",
//				callback: function(result){
//					$("#CmpVehiculoModelo").focus();
//				}
//			});
//			
//			
//		}else if(VehiculoVersion==""){
//			
//			dhtmlx.alert({
//				title:"Aviso",
//				type:"alert-error",
//				text:"Debes escoger una version de vehiculo",
//				callback: function(result){
//					$("#CmpVehiculoVersion").focus();
//				}
//			});
//			
//			
//		}else if(AnoModelo==""){
//			
//			dhtmlx.alert({
//				title:"Aviso",
//				type:"alert-error",
//				text:"Debes ingresar un año de modelo",
//				callback: function(result){
//					$("#CmpVehiculoAnoModelo").focus();
//				}
//			});
//			
//			
//		}else if(Color==""){
//			
//			dhtmlx.alert({
//				title:"Aviso",
//				type:"alert-error",
//				text:"Debes ingresar un año de modelo",
//				callback: function(result){
//					$("#CmpVehiculoColor").focus();
//				}
//			});
//			
//		}else{
//			
//			
//		
//			dhtmlx.confirm("¿Realmente desea buscar un VIN autoasignado?", function(result){
//			if(result==true){		
//				
//				$.ajax({
//					dataType: 'json',
//					type: 'POST',
//					url: 'formularios/OrdenVentaVehiculoC/AccOrdenVentaVehiculoBuscarVIN.php',
//					data: 'VehiculoMarca='+VehiculoMarca+
//					'&VehiculoModelo='+VehiculoModelo+
//					'&VehiculoVersion='+VehiculoVersion+
//					'&AnoModelo='+AnoModelo+
//					'&Color='+Color,
//					success: function(InsVehiculoIngreso){
//						
//						if(InsVehiculoIngreso.EinId != null){
//							
//							$("#CmpVehiculoIngresoId").vin(InsVehiculoIngreso.EinId);
//							$("#CmpVehiculoIngresoVIN").vin(InsVehiculoIngreso.EinVIN);
//							$("#CmpVehiculoMotor").vin(InsVehiculoIngreso.EinNumeroMotor);
//							$("#CmpVehiculoColor").vin(InsVehiculoIngreso.EinColor);
//							$("#CmpVehiculoAnoFabricacion").vin(InsVehiculoIngreso.EinAnoFabricacion);
//							$("#CmpVehiculoAnoModelo").vin(InsVehiculoIngreso.EinAnoModelo);
//							
//						}else{
//							dhtmlx.alert({
//								title:"Aviso",
//								type:"alert-error",
//								text:"No se encontraron unidades disponibles",
//								callback: function(result){
//									
//								}
//							});
//						}
//						
//					},
//					error: function(InsVehiculoIngreso){
//						dhtmlx.alert({
//							title:"Aviso",
//							type:"alert-error",
//							text:"Ha ocurrido un error interno, intente nuevamente",
//							callback: function(result){
//								
//							}
//						});
//					}
//				});
//				
//			}else{
//				
//			}
//		});
//		
//		}
//		
//		
//		
//		
//		
//	}); 

			
});

/*
*** FUNCIONES
*/	

function FncOrdenVentaVehiculoNavegar(oCampo){
	
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
		FncOrdenVentaVehiculoDetalleGuardar();
	}
		
}

/*
* FUNCIONES - AUXILIARES
*/
function FncOrdenVentaVehiculoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncOrdenVentaVehiculoDetalleListar();
		alert("Debe Escoger una moneda");
	}else{
		if(EmpresaMonedaId == MonedaId ){
			$('#CmpTipoCambio').val('');
		}else{
			if(TipoCambio==""){
				FncTipoCambioCargar(MonedaId,Fecha,"Venta");				
			}
		}
		FncMonedaBuscar('Id');
	}

}

function FncOrdenVentaVehiculoEstablecerMantenimiento(){

	var VehiculoMarcaId = $('#CmpVehiculoMarca').val();
	
	switch(VehiculoMarcaId){
		case "VMA-10018":
			$('#CapPlanMantenimientoIsuzu').show();
			$('#CapPlanMantenimientoChevrolet').hide();
			
			//
//			$('input[type=checkbox]').each(function () {
//				if($(this).attr('etiqueta')=="mant_isuzu"){
//					$(this).attr('checked', true);
//				}
//				
//			});
			
			$('input[type=checkbox]').each(function () {
				if($(this).attr('etiqueta')=="mant_chevrolet"){
					$(this).attr('checked', false);
				}
				
			});
	
	
		break;
		
		default:
		
			$('input[type=checkbox]').each(function () {
				if($(this).attr('etiqueta')=="mant_isuzu"){
					$(this).attr('checked', false);
				}
				
			});
			
			//$('input[type=checkbox]').each(function () {
//				if($(this).attr('etiqueta')=="mant_chevrolet"){
//					$(this).attr('checked', true);
//				}
//				
//			});
			
			
			$('#CapPlanMantenimientoIsuzu').hide();
			$('#CapPlanMantenimientoChevrolet').show();
		break;
	}
}

function FncBuscarVIN(){

		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var VehiculoModelo = $("#CmpVehiculoModelo").val();
		var VehiculoVersion = $("#CmpVehiculoVersion").val();
		var AnoModelo = $("#CmpVehiculoAnoModelo").val();
		var Color = $("#CmpVehiculoColor").val();
		
		if(VehiculoMarca==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una marca de vehiculo",
				callback: function(result){
					$("#CmpVehiculoMarca").focus();
				}
			});
				
		}else if(VehiculoModelo==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un modelo de vehiculo",
				callback: function(result){
					$("#CmpVehiculoModelo").focus();
				}
			});
			
			
		}else if(VehiculoVersion==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una version de vehiculo",
				callback: function(result){
					$("#CmpVehiculoVersion").focus();
				}
			});
			
			
		/*}else if(AnoModelo==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un año de modelo",
				callback: function(result){
					$("#CmpVehiculoAnoModelo").focus();
				}
			});*/
			
			
		/*}else if(Color==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un color",
				callback: function(result){
					$("#CmpVehiculoColor").focus();
				}
			});*/
			
		}else{
			
			
		
			dhtmlx.confirm("¿Realmente desea buscar un VIN autoasignado?", function(result){
			if(result==true){		
				
				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/OrdenVentaVehiculoC/acc/AccOrdenVentaVehiculoBuscarVIN.php',
					data: 'VehiculoMarca='+VehiculoMarca+
					'&VehiculoModelo='+VehiculoModelo+
					'&VehiculoVersion='+VehiculoVersion+
					'&AnoModelo='+AnoModelo+
					'&Color='+Color,
					success: function(InsVehiculoIngreso){
						
						if(InsVehiculoIngreso.EinId != null){
							
							$("#CmpVehiculoIngresoId").val(InsVehiculoIngreso.EinId);
							$("#CmpVehiculoIngresoVIN").val(InsVehiculoIngreso.EinVIN);
							$("#CmpVehiculoMotor").val(InsVehiculoIngreso.EinNumeroMotor);
							$("#CmpVehiculoColor").val(InsVehiculoIngreso.EinColor);
							$("#CmpVehiculoAnoFabricacion").val(InsVehiculoIngreso.EinAnoFabricacion);
							$("#CmpVehiculoAnoModelo").val(InsVehiculoIngreso.EinAnoModelo);
							
						}else{
							dhtmlx.alert({
								title:"Aviso",
								type:"alert-error",
								text:"No se encontraron unidades disponibles",
								callback: function(result){
									
								}
							});
						}
						
					},
					error: function(InsVehiculoIngreso){
						dhtmlx.alert({
							title:"Aviso",
							type:"alert-error",
							text:"Ha ocurrido un error interno, intente nuevamente",
							callback: function(result){
								
							}
						});
					}
				});
				
			}else{
				
			}
		});
		
		}
			
}



function FncVerificarVIN(){

console.log("FncVerificarVIN");

		var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	
		if(VehiculoIngresoVIN!=""){
			
				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/OrdenVentaVehiculoC/acc/AccOrdenVentaVehiculoVerificarVIN.php',
					data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN,
					success: function(InsOrdenVentaVehiculo){
						
						if(InsOrdenVentaVehiculo.OvvId != null && InsOrdenVentaVehiculo.OvvId != ""){
							
							var Mensaje = "";
							
							Mensaje += "<b>Id:</b> "+InsOrdenVentaVehiculo.OvvId+"";
							Mensaje += "</br>";
							Mensaje += "<b>Fecha:</b> "+InsOrdenVentaVehiculo.OvvFecha+"";
							Mensaje += "</br>";
							
							if(InsOrdenVentaVehiculo.PerId != null){
								Mensaje += "<b>Asesor de Ventas:</b> "+InsOrdenVentaVehiculo.PerNombre+" "+InsOrdenVentaVehiculo.PerApellidoPaterno+" "+InsOrdenVentaVehiculo.PerApellidoMaterno;
								Mensaje += "</br>";
							}
							
							dhtmlx.alert({
								title:"Aviso",
								type:"alert-error",
								text:"El VIN ingresado tiene orden de venta." + "</br>"+ Mensaje,
								callback: function(result){
									
								}
							});
						}else{
							
						}
						
					},
					error: function(InsVehiculoIngreso){
						
					}
				});
				
		}
			
}


/*
* FUNCIONES - COMUNES
*/

function FncClienteBuscar(oCampo){
	
	FncPropietarioBuscar(oCampo);
	
	FncOrdenVentaVehiculoPropietarioGuardar();

}

function FncVehiculoModeloFuncion(){
	
	FncVehiculoVersionesCargar();
	
}

function FncVehiculoVersionFuncion(){
	
	FncVehiculoIngresoListar();
	
}

function FncVehiculoIngresoFuncion(InsVehiculoIngreso){
	
	console.log("FncVehiculoIngresoFuncion");
	
	$("#CmpVehiculoIngresoVIN").attr('readonly', true);
	
/*	$("#CmpVehiculoMarca").attr('disabled', true);
	$("#CmpVehiculoModelo").attr('disabled', true);
	$("#CmpVehiculoVersion").attr('disabled', true);*/
		
	$("#CmpVehiculoColor").attr('readonly', true);
	$("#CmpVehiculoAnoModelo").attr('readonly', true);
	
	var VehiculoModeloHabilitado = 2;
	var VehiculoVersionHabilitado = 2;
	
	$("#CmpVehiculoMarca").val(InsVehiculoIngreso.VmaId);
	$("#CmpVehiculoModelo").val(InsVehiculoIngreso.VmoId);
	$("#CmpVehiculoVersion").val(InsVehiculoIngreso.VveId);
	
	
	$("#CmpVehiculoMarcaId").val(InsVehiculoIngreso.VmaId);
	$("#CmpVehiculoModeloId").val(InsVehiculoIngreso.VmoId);
	$("#CmpVehiculoVersionId").val(InsVehiculoIngreso.VveId);
	
	
	
	$("#CmpVehiculoMotor").val(InsVehiculoIngreso.EinNumeroMotor);
	$("#CmpVehiculoColor").val(InsVehiculoIngreso.EinColor);
	$("#CmpVehiculoAnoFabricacion").val(InsVehiculoIngreso.EinAnoFabricacion);
	$("#CmpVehiculoAnoModelo").val(InsVehiculoIngreso.EinAnoModelo);
	
	FncVehiculoModelosCargar();
	
	FncVerificarVIN();
	
	if(InsVehiculoIngreso.EinEstadoVehicular!="STOCK"){
		
		dhtmlx.alert({
			title:"Aviso",
			type:"alert-error",
			text:"El VIN ingresado se encuentra en estado " + "</br>" + "<b>"+ InsVehiculoIngreso.EinEstadoVehicular+"</b>",
			callback: function(result){
				
			}
		});
		
	}
	
	
}



function FncPropietarioFuncion(){

	$("#CmpPropietarioTipoDocumento").click(function (event) {  
		
		FncPropietarioCargarFormulario("Editar");
		
	}); 
	
	$("#CmpPropietarioTelefono").keyup(function (event) {  
		 if (event.keyCode >= 48 && event.keyCode <= 90) {
	
			FncPropietarioCargarFormulario("Editar");
	
		 }
	}); 

	$("#CmpPropietarioCelular").keyup(function (event) {  
		 if (event.keyCode >= 48 && event.keyCode <= 90) {
	
			FncPropietarioCargarFormulario("Editar");
	
		 }
	}); 

	$("#CmpPropietarioEmail").keyup(function (event) {  
		 if (event.keyCode >= 48 && event.keyCode <= 90) {
	
			FncPropietarioCargarFormulario("Editar");
	
		 }
	});

}




function FncVehiculoIngresoFormularioFuncion(){
	
	FncVehiculoIngresoBuscar("Id");

}

/*
* FUNCIONES - FORMULARIOS
*/

function FncVehiculoIngresoCargarFormularioListado(oForm,oVehiculoIngresoId){
	
	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}

//function FncVehiculoIngresoBuscar (){
//	
//	FncVehiculoIngresoListar();
//	
//}






/*
* FUNCIONES - IMPRESION
*/

function FncImprmir(oId){
	FncPopUp('formularios/OrdenVentaVehiculoC/FrmOrdenVentaVehiculoImprimir.php?Id='+oId+
'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId){
	FncPopUp('formularios/OrdenVentaVehiculoC/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}


/*
* PAGOS
*/

function FncGenerarPago(oId){

	var Tipo = prompt("Escoja el tipo de registro \n 1 = Abono (Voucher de Pago, Transferencia, etc)  \n 2 = Orden de Cobro (Recibos de Caja) \n 3 = Credito (Carta Aprobatoria)", "1");

	if(Tipo !== null){
		switch(Tipo.toUpperCase()){
			case "1":

				FncAbonoCargarFormulario('Registrar',oId);

			break;
			
			case "2":

				FncOrdenCobroCargarFormulario('Registrar',oId);

			break;
			
				case "3":

				FncCreditoCargarFormulario('Registrar',oId);

			break;
			
			default:
				alert("Opcion no encontrada");
			break;
		
		}
		
	}	

}



function FncOrdenCobroCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2C.php?Mod=PagoOrdenVentaVehiculo&Form=OrdenCobro'+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncAbonoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2C.php?Mod=PagoOrdenVentaVehiculo&Form=Abono'+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}

function FncPagoOrdenVentaVehiculoCargarFormulario(oForm,oVentaDirectaId){
	
	tb_show(this.title,'principal2C.php?Mod=PagoOrdenVentaVehiculo&Form='+oForm+'&Dia=1&OvvId='+oVentaDirectaId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

}








function FncVehiculoIngresoListar(){
	
	var VehiculoMarca = $('#CmpVehiculoMarca').val();
	var VehiculoModelo = $('#CmpVehiculoModelo').val();
	var VehiculoVersion = $('#CmpVehiculoVersion').val();
	
	var AnoModelo = $('#CmpVehiculoAnoModelo').val();
	var AnoFabricacion = $('#CmpVehiculoAnoFabricacion').val();
	
	var Color = $('#CmpVehiculoColor').val();

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	
	$("#CapVehiculoIngreso").html("Cargando...");

	$.ajax({
		type: 'POST',
		url: 'formularios/OrdenVentaVehiculoC/CapVehiculoIngresoListado.php',
		data: 'VehiculoMarca='+VehiculoMarca+
		'&VehiculoModelo='+VehiculoModelo+
		'&VehiculoVersion='+VehiculoVersion+
		
		'&AnoModelo='+AnoModelo+
		'&AnoFabricacion='+AnoFabricacion+
		
		'&Color='+Color+
		'&MonedaId='+MonedaId+
		'&TipoCambio='+TipoCambio,
		success: function(html){
			$("#CapVehiculoIngreso").html("");
			$("#CapVehiculoIngreso").append(html);
			
			
			/*var c = 1;
			$('input[type=button]').each(function () {
				if($(this).attr('name')=="BtnBuscarVIN"){
		
					$(this).click(function() {

						FncBuscarVIN();
						
					});

					c = c + 1;
		
				}	
			});*/
	
	
		}
	});
	
}

function FncVehiculoIngresoListadoEscoger(oIndice,oVehiculoVersionId,oPrecioLista,oPrecioCierre,oColor,oVehiculoIngresoId,oAnoModelo,oVIN,oVehiculoIngresoDescuentoGerencia,oAnoFabricacion){

	$('#CmpVehiculoVersion').val(oVehiculoVersionId);

	$('#CmpPrecio').val(oPrecioLista);

	$('#CmpTotal').val(oPrecioLista);

	$('#CmpPrecioLista').val(oPrecioLista);
	$('#CmpPrecioCierre').val(oPrecioCierre);

	$('#CmpVehiculoColor').val(oColor);
	
	$('#CmpVehiculoIngresoId').val(oVehiculoIngresoId);
	
	$('#CmpVehiculoAnoModelo').val(oAnoModelo);

	$('#CmpVehiculoIngresoVIN').val(oVIN);
	
	$('#CmpDescuentoGerencia').val(oVehiculoIngresoDescuentoGerencia);
	
	$('#CmpVehiculoAnoFabricacion').val(oAnoFabricacion);

	var c = 1;
	$('input[type=radio]').each(function () {
		if($(this).attr('name')=="RbuVehiculoIngreso"){

			if($(this).is(":checked")) {
				$('#Fila_'+c).css('background-color', '#FFCC00');
			}else{
				$('#Fila_'+c).css('background-color', '#E6E6E6');
			}
			
			c = c + 1;

		}	
	});


	/*
	* POPUP REGISTRAR/EDITAR
	*/	
	$("#BtnVehiculoIngresoEditar").show();
	$("#BtnVehiculoIngresoRegistrar").hide();
	
	FncOrdenVentaVehiculoDetalleCalcularTotal();
}





