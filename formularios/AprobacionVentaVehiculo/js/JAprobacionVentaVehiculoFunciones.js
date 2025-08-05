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
//	FncAprobacionVentaVehiculoEstablecerMantenimiento();
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
		FncAprobacionVentaVehiculoEstablecerMoneda();
	});

	$("select#CmpVehiculoMarca").change(function(){

		$("#CapVehiculoIngreso").html("");
		FncVehiculoModelosCargar();
		FncAprobacionVentaVehiculoEstablecerMantenimiento();
		
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
		FncAprobacionVentaVehiculoDetalleCalcularTotal();
	}); 
	
	$("#CmpBonoGM").keyup(function () {  
		FncAprobacionVentaVehiculoDetalleCalcularTotal();
	}); 

	$("#CmpBonoDealer").keyup(function () {  
		FncAprobacionVentaVehiculoDetalleCalcularTotal();
	}); 


	$("#CmpOrdenVentaVehiculoTotal").keyup(function () {  
		FncAprobacionVentaVehiculoDetalleCalcularDescuento();
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
					url: 'formularios/AprobacionVentaVehiculo/AccAprobacionVentaVehiculoBuscarVIN.php',
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

function FncAprobacionVentaVehiculoNavegar(oCampo){
	
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
		FncAprobacionVentaVehiculoDetalleGuardar();
	}
		
}

/*
* FUNCIONES - AUXILIARES
*/
function FncAprobacionVentaVehiculoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncAprobacionVentaVehiculoDetalleListar();
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

	FncAprobacionVentaVehiculoPropietarioGuardar();

}

function FncVehiculoModeloFuncion(){
	
	FncVehiculoVersionesCargar();
	
}

function FncVehiculoVersionFuncion(){
	
	FncVehiculoIngresoListar();
	
}

function FncVehiculoIngresoFuncion(){
	
	$("#CmpVehiculoIngresoVIN").attr('readonly', true);
	
	$("#CmpVehiculoMarca").attr('disabled', true);
	$("#CmpVehiculoModelo").attr('disabled', true);
	$("#CmpVehiculoVersion").attr('disabled', true);
		
	$("#VehiculoIngresoColor").attr('readonly', true);
	$("#CmpOrdenVentaVehiculoAnoModelo").attr('readonly', true);
	
	var VehiculoModeloHabilitado = 2;
	var VehiculoVersionHabilitado = 2;
	
	FncVehiculoModelosCargar();
	
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
	FncPopUp('formularios/AprobacionVentaVehiculo/FrmAprobacionVentaVehiculoImprimir.php?Id='+oId+'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId){
	FncPopUp('formularios/AprobacionVentaVehiculo/FrmAprobacionVentaVehiculoImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}













function FncVehiculoIngresoListar(){
	
	var VehiculoMarca = $('#CmpVehiculoMarca').val();
	var VehiculoModelo = $('#CmpVehiculoModelo').val();
	var VehiculoVersion = $('#CmpVehiculoVersion').val();
	
	var AnoModelo = $('#CmpOrdenVentaVehiculoAnoModelo').val();
	//var Color = $('#VehiculoIngresoColor').val();
	var Color = "";

	$("#CapVehiculoIngreso").html("Cargando...");

	$.ajax({
		type: 'POST',
		url: 'formularios/AprobacionVentaVehiculo/CapVehiculoIngresoListado.php',
		data: 'VehiculoMarca='+VehiculoMarca+'&VehiculoModelo='+VehiculoModelo+'&VehiculoVersion='+VehiculoVersion+'&AnoModelo='+AnoModelo+'&Color='+Color,
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
	
	FncAprobacionVentaVehiculoDetalleCalcularTotal();
}





