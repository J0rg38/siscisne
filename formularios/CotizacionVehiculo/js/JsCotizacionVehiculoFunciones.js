// JavaScript Document



				
	
				

	
/* 
* VARIABLES
*/

var VehiculoIngresoColorCampo = "CmpColor";

/*
* VALIDACIONES
*/
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
	var AnoModelo = $("#CmpAnoModelo").val();
	var AnoFabricacion = $("#CmpAnoFabricacion").val();
	var Total = $("#CmpTotal").val();
	var Precio = $("#CmpPrecio").val();
	var CondicionPago = $("#CmpCondicionPago").val();
	
	var Personal = $("#CmpPersonal").val();
	var TipoReferido = $("#CmpTipoReferido").val();
	
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
					text:"Debes ingresar un numero de documento de identidad",
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
		
		}else if(TipoReferido == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes determinado el campo ¿Como llego el concesionario?, en la ficha del cliente",
					callback: function(result){
						$("#CmpTipoReferido").focus();
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
			
		/*}else if(AnoModelo == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un año de modelo",
					callback: function(result){
						$("#CmpAnoModelo").focus();
					}
				});
				
			return false;*/
			
			}else if(AnoModelo == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un año de modelo",
					callback: function(result){
						$("#CmpAnoModelo").focus();
					}
				});
				
			return false;	
			
			
		/*}else if(AnoFabricacion == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un año de fabricacion",
					callback: function(result){
						$("#CmpAnoFabricacion").focus();
					}
				});
				
			return false;	*/	
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
		
/*	}else if(CondicionPago == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una forma de pago",
					callback: function(result){
						$("#CmpCondicionPago").focus();
					}
				});
				
			return false;	*/	
		}else if(Personal == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger a un asesor de ventas",
					callback: function(result){
						$("#CmpPersonal").focus();
					}
				});
				
			return false;	
				
		
				
		}else if(FncValidarAccesorios() == false){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No puedes escoger mas de 7 accesorios",
					callback: function(result){
						
					}
				});
				
			return false;
		
		}else{
			return true;
		}
		

		

}

function FncValidarAccesorios(){

	var total_accesorios = 0;
	var respuesta = true;
		
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="accesorio"){
			
			if($(this).is(':checked')){

				total_accesorios = total_accesorios + 1;
				
			}
			
		}			 
	});

	if(total_accesorios>7){
		respuesta = false;
	}

					
	return respuesta;
	
}


$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		$('#CmpPersonalReferente').removeAttr('disabled');	
		$('#CmpTipoReferido').removeAttr('disabled');	
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
			$('#CmpPersonalReferente').removeAttr('disabled');	
			$('#CmpTipoReferido').removeAttr('disabled');	
			
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});




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
	$("input,select").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncAlmacenMovimientoNavegar(this.id);
		 }
	}); 
	
	$("input,select").focus(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
		$(this).removeClass("EstFormularioCaja").addClass("EstFormularioCajaEnfocado");
		}
	}); 
	
	$("input,select").blur(function () {  
		if (this.type !== "hidden" & this.type !=="image") {
			$(this).removeClass("EstFormularioCajaEnfocado").addClass("EstFormularioCaja");
		}
	}); 
	
	
/*
* EVENTOS - INICIALES
*/

	$("select#CmpMonedaId").change(function(){
		FncCotizacionVehiculoEstablecerMoneda();
		
		FncVehiculoIngresoListar();
	});

	$("select#CmpVehiculoMarca").change(function(){

		$("#CapVehiculoIngreso").html("");
		FncVehiculoModelosCargar();
		FncVehiculoColorAutocompletarCargar();
		
	});

	$("select#CmpVehiculoModelo").change(function(){
		
		FncVehiculoVersionesCargar();
		FncVehiculoIngresoListar();
		FncVehiculoColorAutocompletarCargar();
		
	});

	$("select#CmpVehiculoVersion").change(function(){
		FncVehiculoIngresoListar();
			FncVehiculoColorAutocompletarCargar();
	});
	
	$("#CmpAnoModelo").keyup(function () {  
		
		var aux = $(this).val();
		
		if(aux.length==4){
			FncVehiculoIngresoListar();			
		}
		
	}); 

	$("#CmpAnoFabricacion").keyup(function () {  
		
		var aux = $(this).val();
		
		if(aux.length==4){
			FncVehiculoIngresoListar();			
		}
		
	}); 

	$("#CmpColor").keyup(function () {  
		FncVehiculoIngresoListar();
	}); 

	$("#CmpTipoCambio").keyup(function () {  
		FncVehiculoIngresoListar();
	}); 

//	$("select#CmpVehiculoVersion").change(function(){
//		FncVehiculoColoresCargar();
//		FncCotizacionVehiculoVerCaracteristica();
//	});
//	
//	$("select#CmpVehiculoColor").change(function(){
//		FncCotizacionVehiculoEstablecerVehiculoFoto();
//	});

//	$("select#CmpCondicionVenta").change(function(){
//
//	});
//	
//	$("select#CmpObsequio").change(function(){
//
//	});
	
});

/*
*** FUNCIONES
*/	

function FncCotizacionVehiculoNavegar(oCampo){
	
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
		FncCotizacionVehiculoDetalleGuardar();
	}
		
}

/*
* FUNCIONES - AUXILIARES
*/
function FncCotizacionVehiculoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
		FncCotizacionVehiculoDetalleListar();
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


function FncVehiculoIngresoListar(){
	
	var VehiculoMarca = $('#CmpVehiculoMarca').val();
	var VehiculoModelo = $('#CmpVehiculoModelo').val();
	var VehiculoVersion = $('#CmpVehiculoVersion').val();
	
	var AnoModelo = $('#CmpAnoModelo').val();
	var AnoFabricacion = $('#CmpAnoFabricacion').val();
	
	var Color = $('#CmpColor').val();
	
	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();

	$("#CapVehiculoIngreso").html("Cargando...");

	$.ajax({
		type: 'POST',
		url: 'formularios/CotizacionVehiculo/CapVehiculoIngresoListado.php',
		data: 'VehiculoMarca='+VehiculoMarca+
			'&VehiculoModelo='+VehiculoModelo+
			'&VehiculoVersion='+VehiculoVersion+
			
			'&AnoModelo='+AnoModelo+
			//'&AnoFabricacion='+AnoFabricacion+
			
			'&Color='+Color+
			'&MonedaId='+MonedaId+
			'&TipoCambio='+TipoCambio,
		success: function(html){
			$("#CapVehiculoIngreso").html("");
			$("#CapVehiculoIngreso").append(html);
		}
	});
	
}
//
//function FncVehiculoIngresoSeleccionar(oIndice,oVehiculoVersionId,oPrecioLista,oPrecioCierre,oColor,oVehiculoIngresoId,oAnoModelo,oFechaVigencia,oAnoFabricacion){
//
//	$('#CmpVehiculoVersion').val(oVehiculoVersionId);
//
//	$('#CmpPrecio').val(oPrecioLista);
//
//	$('#CmpTotal').val(oPrecioLista);
//
//	$('#CmpPrecioLista').val(oPrecioLista);
//	$('#CmpPrecioCierre').val(oPrecioCierre);
//
//	$('#CmpColor').val(oColor);
//	
//	$('#CmpVehiculoIngreso').val(oVehiculoIngresoId);
//	
//	$('#CmpAnoModelo').val(oAnoModelo);
//	$('#CmpAnoFabricacion').val(oAnoFabricacion);
//	
//	/*if(oFechaVigencia!=""){
//		$('#CmpFechaVigencia').val(oFechaVigencia);		
//	}*/
//
//	var c = 1;
//	$('input[type=radio]').each(function () {
//		if($(this).attr('name')=="RbuVehiculoIngreso"){
//
//			if($(this).is(":checked")) {
//				$('#Fila_'+c).css('background-color', '#FFCC00');
//			}else{
//				$('#Fila_'+c).css('background-color', '#E6E6E6');
//			}
//			
//			c = c + 1;
//
//		}	
//	});
//
//}

//
//function FncCotizacionVehiculoEstablecerVehiculoFoto(){
//
//	var VehiculoId = $("#CmpVehiculoColor").val();
//	
//	if(VehiculoId != ""){
//
//		$.ajax({
//		type: 'POST',
//		url: 'comunes/Vehiculo/CapVehiculoFoto.php',
//		data: 'VehiculoId='+VehiculoId,
//		success: function(html){
//				$("#CapVehiculoVersionFoto").html(html);	
//			}
//		});
//		
//	}else{
//				$("#CapVehiculoVersionFoto").html("");	
//	}
//
//}
//
//function FncCotizacionVehiculoVerCaracteristica(){
//	
//	var VehiculoVersionId = $("#CmpVehiculoVersion").val();
//
//	if(VehiculoVersionId!=""){
//
//		$.ajax({
//		type: 'POST',
//		url: 'comunes/Vehiculo/CapVehiculoVersionCaracteristica.php',
//		data: 'VehiculoVersionId='+VehiculoVersionId,
//		success: function(html){
//				$("#CapVehiculoVersionCaracteristica").html(html);	
//			}
//		});	
//		
//	}else{
//		$("#CapVehiculoVersionCaracteristica").html("");	
//	}
//	
//}

//function FncCotizacionVehiculoEstablecerObsequio(){
//
//	var Obsequio = $('#CmoObsequio').val();
//
//	if(Obsequio=="0"){
//		$('#CmpObsequiOtro').removeAttr('readonly');
//	}else{
//		$('#CmpObsequiOtro').attr('readonly', true).val("");
//	}
//
//}
//
//function FncContizacionVehiculoEstablecerCondicionVenta(){
//
//	var CondicionVenta = $('#CmpCondicionVenta').val();
//
//	if(CondicionVenta=="0"){
//		$('#CmpCondicionVenta').removeAttr('readonly');
//	}else{
//		$('#CmpCondicionVenta').attr('readonly', true).val("");
//	}
//
//}

/*
* FUNCIONES - COMUNES
*/

function FncVehiculoModeloFuncion(){

	FncVehiculoVersionesCargar();
	
	FncVehiculoIngresoListar();
}

function FncVehiculoVersionFuncion(){
	


}

function FncClienteNuevoFuncion(){
console.log("FncClienteNuevoFuncion");
	$('#CmpPersonalReferente').removeAttr('disabled');			
	$("#CmpPersonalReferente").val("");			
	$('#CmpPersonalReferente').attr('disabled', true);

}


function FncClienteFuncion(InsCliente){
	
	console.log("FncClienteFuncion");
	
	if(InsCliente.TrfId!=null){
		$("#CmpTipoReferido").val(InsCliente.TrfId);
	}else{
		$("#CmpTipoReferido").val("");
	}
	


	var PersonalId = $("#CmpPersonal").val();
	
	if(InsCliente.PerId!=null){
		console.log("FncClienteFuncion111");
		
		if(PersonalId != InsCliente.PerId){
			
			console.log("FncClienteFuncion222");
			$('#CmpPersonalReferente').removeAttr('disabled');			
			$("#CmpPersonalReferente").val(InsCliente.PerId);			
			$('#CmpPersonalReferente').attr('disabled', true);
			
			var Personal = "";
			var FechaRegistro = "";
			
			if(InsCliente.PerNombre!=null){
				Personal = Personal + " " +InsCliente.PerNombre;
			}
			
			if(InsCliente.PerApellidoPaterno!=null){
				Personal = Personal + " " +InsCliente.PerApellidoPaterno;
			}
			
			if(InsCliente.PerApellidoMaterno!=null){
				Personal = Personal + " " +InsCliente.PerApellidoMaterno;
			}
			
			/*if(InsCliente.PerApellidoMaterno!=null){
				FechaRegistro = FechaRegistro + " " +InsCliente.CliTiempoCreacion;
			}*/
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Este cliente fue registrado por : "+Personal,
					callback: function(result){
						
					}
				});
				
		}
		
	}
	
	
	
//	$("#CmpClienteTipoDocumento").click(function (event) {  
//		
//		FncClienteCargarFormulario("Editar");
//		
//	}); 
//	
//	
//	$("#CmpClienteTelefono").keyup(function (event) {  
//		 if (event.keyCode >= 48 && event.keyCode <= 90) {
//	
//			FncClienteCargarFormulario("Editar");
//	
//		 }
//	}); 
//	
//	
//	$("#CmpClienteCelular").keyup(function (event) {  
//		 if (event.keyCode >= 48 && event.keyCode <= 90) {
//	
//			FncClienteCargarFormulario("Editar");
//	
//		 }
//	}); 
//	
//	$("#CmpClienteDireccion").keyup(function (event) {  
//		 if (event.keyCode >= 48 && event.keyCode <= 90) {
//	
//			FncClienteCargarFormulario("Editar");
//	
//		 }
//	}); 
//	
//	$("#CmpClienteEmail").keyup(function (event) {  
//		 if (event.keyCode >= 48 && event.keyCode <= 90) {
//	
//			FncClienteCargarFormulario("Editar");
//	
//		 }
//	}); 
		FncClienteNotaVerificar();
}



/*
function FncClienteNuevoFuncion(){


	//$("#CmpClienteTipoDocumento").unbind();
//	
//	$("#CmpClienteTelefono").unbind();
//	
//	$("#CmpClienteCelular").unbind();
//	
//	$("#CmpClienteDireccion").unbind();
//	
//	$("#CmpClienteEmail").unbind();
	
}
*/

/*
*
*/


/*
* FUNCIONES - IMPRESION
*/

function FncImprmir(oId){
	FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir3.php?Id='+oId+
'&P=1',0,0,1,0,0,1,0,screen.height,screen.width);
}


function FncVistaPreliminar(oId){
	FncPopUp('formularios/CotizacionVehiculo/FrmCotizacionVehiculoImprimir3.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);
}




function FncVehiculoVersionVistaPreliminar(oId){

	FncPopUp('formularios/VehiculoVersion/FrmVehiculoVersionImprimir.php?Id='+oId,0,0,1,0,0,1,0,screen.height,screen.width);

}