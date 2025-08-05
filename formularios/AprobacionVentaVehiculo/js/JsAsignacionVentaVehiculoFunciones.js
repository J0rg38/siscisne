// JavaScript Document


function FncValidar(){


	var Fecha = $("#CmpFecha").val();

	var VehiculoIngresoId = $("#CmpVehiculoIngresoId").val();
	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();

	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
	var VehiculoVersion = $("#CmpVehiculoVersion").val();
	var AnoFabricacion = $("#CmpOrdenVentaVehiculoAnoFabricacion").val();

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
		
			
		}else if(FncValidarFecha(Fecha) == false){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha valida",
					callback: function(result){
						$("#CmpFecha").focus();
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
			
			
			}else if(VehiculoIngresoVIN == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un VIN",
					callback: function(result){
						$("#CmpOrdenVentaVehiculoVIN").focus();
					}
				});
				
			return false;
			
		}else if(AnoFabricacion == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un año de fabricacion",
					callback: function(result){
						$("#CmpOrdenVentaVehiculoAnoFabricacion").focus();
					}
				});
				
			return false;
				
		}else if(VehiculoIngresoId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No haz escogido bien el VIN, intenta nuevamente",
					callback: function(result){
						$("#CmpOrdenVentaVehiculoVIN").focus();
					}
				});
				
			return false;
		
				
		}else{
			return true;
		}
		
	
		

}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		
		$("#CmpMonedaId").removeAttr('disabled');		
		$("#CmpPersonalVendedor").removeAttr('disabled');		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpMonedaId").removeAttr('disabled');		
		$("#CmpPersonalVendedor").removeAttr('disabled');		
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	//AGREAGO POR JORGE
	FncVehiculoDetalle();
	//AGREGADO POR JORGE
	
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
//	FncAsignacionVentaVehiculoEstablecerMantenimiento();
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
		FncAsignacionVentaVehiculoEstablecerMoneda();
	});

	$("select#CmpVehiculoMarca").change(function(){

		$("#CapVehiculoIngreso").html("");
		FncVehiculoModelosCargar();
		FncAsignacionVentaVehiculoEstablecerMantenimiento();
		
	});

	$("select#CmpVehiculoModelo").change(function(){
		FncVehiculoVersionesCargar();
		FncVehiculoIngresoListar();
	});

	$("select#CmpVehiculoVersion").change(function(){
		FncVehiculoIngresoListar();
	});
	

	$("#CmpOrdenVentaVehiculoAnoModelo").keyup(function () {  
		FncVehiculoIngresoListar();
	}); 

	//$("#VehiculoIngresoColor").keyup(function () {  
//		FncVehiculoIngresoListar();
//	}); 

		
	$("#CmpOrdenVentaVehiculoDescuento").keyup(function () {  
		FncAsignacionVentaVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpBonoGM").keyup(function () {  
		FncAsignacionVentaVehiculoDetalleCalcularTotal();
	}); 

	$("#CmpBonoDealer").keyup(function () {  
		FncAsignacionVentaVehiculoDetalleCalcularTotal();
	}); 


	$("#CmpOrdenVentaVehiculoTotal").keyup(function () {  
		FncAsignacionVentaVehiculoDetalleCalcularDescuento();
	}); 
	
	
	$("#CmpSucursal").change(function () {  
	
		FncVehiculoIngresoListar();
		
	}); 
	
	
	$("#BtnBuscarVIN").click(function () {  
		
		var VehiculoMarca = $("#CmpVehiculoMarca").val();
		var VehiculoModelo = $("#CmpVehiculoModelo").val();
		var VehiculoVersion = $("#CmpVehiculoVersion").val();
		var AnoModelo = $("#CmpOrdenVentaVehiculoAnoModelo").val();
		var Color = $("#VehiculoIngresoColor").val();
		
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
			
			
		}else if(AnoModelo==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un año de modelo",
				callback: function(result){
					$("#CmpOrdenVentaVehiculoAnoModelo").focus();
				}
			});
			
			
		}else if(Color==""){
			
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un año de modelo",
				callback: function(result){
					$("#VehiculoIngresoColor").focus();
				}
			});
			
		}else{
			
			
		
			dhtmlx.confirm("¿Realmente desea buscar un VIN autoasignado?", function(result){
			if(result==true){		
				
				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/AsignacionVentaVehiculo/AccAsignacionVentaVehiculoBuscarVIN.php',
					data: 'VehiculoMarca='+VehiculoMarca+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&AnoModelo='+AnoModelo+'&Color='+Color,
					success: function(InsVehiculoIngreso){
						
						if(InsVehiculoIngreso.EinId != null){
							
							$("#CmpVehiculoIngresoId").vin(InsVehiculoIngreso.EinId);
							$("#CmpVehiculoIngresoVIN").vin(InsVehiculoIngreso.EinVIN);
							$("#CmpMotor").vin(InsVehiculoIngreso.EinNumeroMotor);
							$("#VehiculoIngresoColor").vin(InsVehiculoIngreso.EinColor);
							$("#CmpVehiculoIngresoAnoFabricacion").vin(InsVehiculoIngreso.EinAnoFabricacion);
							$("#CmpOrdenVentaVehiculoAnoModelo").vin(InsVehiculoIngreso.EinAnoModelo);
							
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
		
		
		
		
		
	}); 

			
});

/*
*** FUNCIONES
*/	

function FncAsignacionVentaVehiculoNavegar(oCampo){
	
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
		FncAsignacionVentaVehiculoDetalleGuardar();
	}
		
}

/*
* FUNCIONES - AUXILIARES
*/
function FncAsignacionVentaVehiculoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncAsignacionVentaVehiculoDetalleListar();
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

/*
* FUNCIONES - COMUNES
*/

function FncClienteBuscar(){

	FncAsignacionVentaVehiculoPropietarioGuardar();

}

function FncVehiculoModeloFuncion(){
	
	FncVehiculoVersionesCargar();
	
}

function FncVehiculoVersionFuncion(){
	
	FncVehiculoIngresoListar();
	
}

function FncVehiculoIngresoFuncion(InsVehiculoIngreso){
	
	console.log("FncVehiculoIngresoFuncion");
	
	
	var VehiculoMarca = $("#CmpVehiculoMarcaId").val();;
	var VehiculoModelo = $("#CmpVehiculoModeloId").val();;
	var VehiculoVersion = $("#CmpVehiculoVersionId").val();;
	var VehiculoIngresoVINInicial = $("#CmpVehiculoIngresoVINInicial").val();;
	var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();;	
	var OrdenVentaVehiculoAnoModelo = $("#CmpOrdenVentaVehiculoAnoModelo").val();;
	
	var Observado = false;
	
	var Mensaje = "Los datos del VIN \""+VehiculoIngresoVIN+"\" ingresado tienen las siguientes observaciones: \n";
	
	if(VehiculoMarca!=InsVehiculoIngreso.VmaId){
		Mensaje += "La marca no es la misma a la solicitada \n";	
		Observado = true;
	}else if(VehiculoModelo!=InsVehiculoIngreso.Vmo){
		Mensaje += "El modelo no es la misma a la solicitada \n";	
		Observado = true;
	}else if(VehiculoModelo!=InsVehiculoIngreso.Vmo){
		Mensaje += "La version no es la misma a la solicitada \n";	
		Observado = true;
	}else if(OrdenVentaVehiculoAnoModelo!=InsVehiculoIngreso.EinAnoModelo){
		Mensaje += "El año de modelo no es la misma a la solicitada \n";	
		Observado = true;
	}
	
	if(Observado){
		
		dhtmlx.confirm(Mensaje+" ¿Desea continuar de todas formas?", function(result){
			if(result==true){		

				$("#CmpVehiculoIngresoVIN").attr('readonly', true);
				
				$("#CmpVehiculoMarca").attr('disabled', true);
				$("#CmpVehiculoModelo").attr('disabled', true);
				$("#CmpVehiculoVersion").attr('disabled', true);
					
				$("#VehiculoIngresoColor").attr('readonly', true);
				
				$("#CmpOrdenVentaVehiculoAnoFabricacion").attr('readonly', true);
				$("#CmpOrdenVentaVehiculoAnoModelo").attr('readonly', true);
				
				
				$("#CmpOrdenVentaVehiculoAnoFabricacion").val(InsVehiculoIngreso.EinAnoFabricacion);
				$("#CmpOrdenVentaVehiculoAnoModelo").val(InsVehiculoIngreso.EinAnoModelo)
				
							
				$("#CmpVehiculoMarca").val(InsVehiculoIngreso.VmaId);
				$("#CmpVehiculoModelo").val(InsVehiculoIngreso.VmoId)
				$("#CmpVehiculoVersion").val(InsVehiculoIngreso.VveId)
				
				$("#CmpVehiculoMarcaId").val(InsVehiculoIngreso.VmaId)
				$("#CmpVehiculoModeloId").val(InsVehiculoIngreso.VmoId)
				$("#CmpVehiculoVersionId").val(InsVehiculoIngreso.VveId)	


				var VehiculoModeloHabilitado = 2;
				var VehiculoVersionHabilitado = 2;
				
				FncVehiculoModelosCargar();
				
				FncVerificarVIN();
				
				

			}else{
				
					var VehiculoMarcaIdInicial = $("#CmpVehiculoMarcaIdInicial").val();
					var VehiculoModeloIdInicial = $("#CmpVehiculoModeloIdInicial").val();
					var VehiculoVersionIdInicial = $("#CmpVehiculoVersionIdInicial").val();
					
					var VehiculoIngresoIdInicial = $("#CmpVehiculoIngresoIdInicial").val();
					var VehiculoIngresoVINInicial = $("#CmpVehiculoIngresoVINInicial").val();
					var VehiculoIngresoNumeroMotorInicial = $("#CmpVehiculoIngresoNumeroMotorInicial").val();
					var VehiculoIngresoColorInicial = $("#CmpVehiculoIngresoColorInicial").val();
					
					var OrdenVentaVehiculoAnoFabricacionInicial = $("#CmpOrdenVentaVehiculoAnoFabricacionInicial").val();
					var OrdenVentaVehiculoAnoModeloInicial = $("#CmpOrdenVentaVehiculoAnoModeloInicial").val();
					

					$("#CmpVehiculoMarcaId").val(VehiculoMarcaIdInicial);
					$("#CmpVehiculoModeloId").val(VehiculoModeloIdInicial);
					$("#CmpVehiculoVersionId").val(VehiculoVersionIdInicial);
					
					
					$("#CmpVehiculoMarca").val(VehiculoMarcaIdInicial);
					$("#CmpVehiculoModelo").val(VehiculoModeloIdInicial);
					$("#CmpVehiculoVersion").val(VehiculoVersionIdInicial);

					$("#CmpVehiculoIngresoId").val(VehiculoIngresoIdInicial);
					$("#CmpVehiculoIngresoVIN").val(VehiculoIngresoVINInicial);
					$("#CmpVehiculoIngresoNumeroMotor").val(VehiculoIngresoNumeroMotorInicial);
					$("#CmpVehiculoIngresoColor").val(VehiculoIngresoColorInicial);
					
					$("#CmpOrdenVentaVehiculoAnoFabricacion").val(OrdenVentaVehiculoAnoFabricacionInicial);
					$("#CmpOrdenVentaVehiculoAnoModelo").val(OrdenVentaVehiculoAnoModeloInicial);
					
					FncVehiculoModelosCargar();
					
					
			}
		});
	
	}else{
		
		
						
				$("#CmpVehiculoIngresoVIN").attr('readonly', true);
				
				$("#CmpVehiculoMarca").attr('disabled', true);
				$("#CmpVehiculoModelo").attr('disabled', true);
				$("#CmpVehiculoVersion").attr('disabled', true);
					
				$("#VehiculoIngresoColor").attr('readonly', true);
				
				$("#CmpOrdenVentaVehiculoAnoFabricacion").attr('readonly', true);
				$("#CmpOrdenVentaVehiculoAnoModelo").attr('readonly', true);
				
				
				$("#CmpOrdenVentaVehiculoAnoFabricacion").val(InsVehiculoIngreso.EinAnoFabricacion);
				$("#CmpOrdenVentaVehiculoAnoModelo").val(InsVehiculoIngreso.EinAnoModelo)
				
							
				$("#CmpVehiculoMarca").val(InsVehiculoIngreso.VmaId);
				$("#CmpVehiculoModelo").val(InsVehiculoIngreso.VmoId)
				$("#CmpVehiculoVersion").val(InsVehiculoIngreso.VveId)
				
				$("#CmpVehiculoMarcaId").val(InsVehiculoIngreso.VmaId)
				$("#CmpVehiculoModeloId").val(InsVehiculoIngreso.VmoId)
				$("#CmpVehiculoVersionId").val(InsVehiculoIngreso.VveId)	


				var VehiculoModeloHabilitado = 2;
				var VehiculoVersionHabilitado = 2;
				
				FncVehiculoModelosCargar();
				
				FncVerificarVIN();
				
				
				

		
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



function FncVerificarVIN(){

console.log("FncVerificarVIN");

		var VehiculoIngresoVIN = $("#CmpVehiculoIngresoVIN").val();
	
		if(VehiculoIngresoVIN!=""){
			
				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: 'formularios/AsignacionVentaVehiculo/acc/AccAsignacionVentaVehiculoVerificarVIN.php',
					data: 'VehiculoIngresoVIN='+VehiculoIngresoVIN,
					success: function(InsAsignacionVentaVehiculo){
						
						if(InsAsignacionVentaVehiculo.AvvId != null && InsAsignacionVentaVehiculo.AvvId != ""){
							
							var Mensaje = "";
							
							Mensaje += "<b>Id:</b> "+InsAsignacionVentaVehiculo.AvvId+"";
							Mensaje += "</br>";
							Mensaje += "<b>Fecha:</b> "+InsAsignacionVentaVehiculo.AvvFecha+"";
							Mensaje += "</br>";
							
							if(InsAsignacionVentaVehiculo.PerIdVendedor != null){
								Mensaje += "<b>Asesor de Ventas:</b> "+InsAsignacionVentaVehiculo.PerNombreVendedor+" "+InsAsignacionVentaVehiculo.PerApellidoPaternoVendedor+" "+InsAsignacionVentaVehiculo.PerApellidoMaternoVendedor;
								Mensaje += "</br>";
							}
							
							if(InsAsignacionVentaVehiculo.PerId != null){
								Mensaje += "<b>Aprobado por:</b> "+InsAsignacionVentaVehiculo.PerNombre+" "+InsAsignacionVentaVehiculo.PerApellidoPaterno+" "+InsAsignacionVentaVehiculo.PerApellidoMaterno;
								Mensaje += "</br>";
							}
							
							dhtmlx.alert({
								title:"Aviso",
								type:"alert-error",
								text:"El VIN ingresado tiene asignacion previamente registrada." + "</br>"+ Mensaje,
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
* FUNCIONES - FORMULARIOS
*/

function FncVehiculoIngresoFormularioFuncion(){
	
	FncVehiculoIngresoBuscar("Id");

}


function FncVehiculoIngresoCargarFormularioListado(oForm,oVehiculoIngresoId){
	
	FncCargarVentana("VehiculoIngreso",oForm,oVehiculoIngresoId);

}


function FncCargarVehiculoInstalar(oId){

	tb_show(this.title,'formulario/VehiculoIngreso/DiaVehiculoIngresoVehiculoInstalarphp?EinId='+oId+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=620&width=890&modal=true',this.rel);		

	
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
	FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId){
	FncPopUp('formularios/AsignacionVentaVehiculo/FrmAsignacionVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}

function FncOrdenVentaVehiculoVistaPreliminar(oId){

	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}

function FncOrdenVentaVehiculoVistaPreliminarOV(oId){

	FncPopUp('formularios/OrdenVentaVehiculo/FrmOrdenVentaVehiculoImprimirOV.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}












function FncVehiculoIngresoListar(){
	
	var Sucursal = $('#CmpSucursal').val();
	var VehiculoMarca = $('#CmpVehiculoMarca').val();
	var VehiculoModelo = $('#CmpVehiculoModelo').val();
	var VehiculoVersion = $('#CmpVehiculoVersion').val();
	
	var AnoModelo = $('#CmpOrdenVentaVehiculoAnoModelo').val();
	//var Color = $('#VehiculoIngresoColor').val();
	var Color = "";

	$("#CapVehiculoIngreso").html("Cargando...");

	$.ajax({
		type: 'POST',
		url: 'formularios/AsignacionVentaVehiculo/CapVehiculoIngresoListado.php',
		data: 'VehiculoMarca='+VehiculoMarca+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&AnoModelo='+AnoModelo+'&Color='+Color+'&Sucursal='+Sucursal,
		success: function(html){
			$("#CapVehiculoIngreso").html("");
			$("#CapVehiculoIngreso").append(html);
		}
	});
	
}

function FncVehiculoIngresoListadoEscoger(oIndice,oVehiculoVersionId,oPrecioLista,oPrecioCierre,oColor,oVehiculoIngresoId,oAnoModelo,oVIN,oVehiculoIngresoDescuentoGerencia,oAnoFabricacion,oNumeroMotor){

	$('#CmpVehiculoIngresoId').val(oVehiculoIngresoId);
	$('#CmpVehiculoIngresoVIN').val(oVIN);
	$('#CmpVehiculoVersion').val(oVehiculoVersionId);

	$('#CmpVehiculoIngresoNumeroMotor').val(oNumeroMotor);
	$('#VehiculoIngresoColor').val(oColor);
	$('#CmpVehiculoIngresoAnoFabricacion').val(oAnoFabricacion);
	$('#CmpOrdenVentaVehiculoAnoModelo').val(oAnoModelo);


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
	
	FncAsignacionVentaVehiculoDetalleCalcularTotal();
}








//AGREGADO POR JORGE

function FncVehiculoDetalle(){

		var VehiculoId = $("#CmpOrdenVentaVehiculoId").val();

		$.ajax({
			type: 'POST',
			url: 'formularios/AsignacionVentaVehiculo/CapVehiculoDetalle.php',
			data: 'VehiculoId='+VehiculoId,
			success: function(html){
				$('#CapVehiculoDetalle').html('Listo');	
				$("#CapVehiculoDetalle").append(html);

			}
		});

}

//FIN AGREGADOP POR JORGE
