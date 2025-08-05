// JavaScript Document

//function FncGuardar(){
//	
//	//HACK
//	
//	$("#CmpMonedaId").removeAttr('disabled');	
//	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
//	
//}

function FncValidar(){

	var AreaId = $("#CmpAreaId").val();
	var Fecha = $("#CmpFecha").val();
	var MonedaId = $("#CmpMonedaId").val();
	var FormaPago = $("#CmpFormaPago").val();
	var FechaTransaccion = $("#CmpFechaTransaccion").val();
	var NumeroTransaccion = $("#CmpNumeroTransaccion").val();
	var Monto = $("#CmpMonto").val();
	var TipoCambio = $("#CmpTipoCambio").val();	

		if(AreaId == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una area destino",
					callback: function(result){
						$("#CmpAreaId").focus();
					}
				});
				
			return false;
		
		}else if(Fecha == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de registro",
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
						$("#CmpFecha").select();
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
	
		}else if(MonedaId != EmpresaMonedaId && TipoCambio =="" ){			
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un tipo de cambio",
				callback: function(result){
					$("#CmpTipoCambio").focus();
				}
			});
				
			return false;
		}else if(FormaPago == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una forma de pago",
					callback: function(result){
						$("#CmpFormaPago").focus();
					}
				});

			return false;
		
		}else if(FechaTransaccion == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de transaccion u operacion",
					callback: function(result){
						$("#CmpFechaTransaccion").focus();
					}
				});

			return false;

		}else if(FncValidarFecha(FechaTransaccion) == false){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de transaccion u operacion valida",
					callback: function(result){
						$("#CmpFechaTransaccion").select();
					}
				});
				
				return false;
		}else if(NumeroTransaccion == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un numero de transaccion u operacion",
					callback: function(result){
						$("#CmpNumeroTransaccion").focus();
					}
				});

			return false;
		
		}else if(Monto == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un monto",
					callback: function(result){
						$("#CmpMonto").focus();
					}
				});

			return false;
		
		}else if(Monto == "0.00" || Monto == "0"  || Monto == "0.0" || Monto == "0.000"){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un monto mayor",
					callback: function(result){
						$("#CmpMonto").select();
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
		$("#CmpClienteTipoDocumento").removeAttr('disabled');
			
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpMonedaId").removeAttr('disabled');	
		$("#CmpClienteTipoDocumento").removeAttr('disabled');	
		
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

});


var FormularioCampos = [


"CmpFecha",
"CmpCondicionPago",
"CmpCuenta",
"CmpMonedaId",
"CmpManoObra",
"CmpManoObra"];

$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncPagoOrdenVentaVehiculoNavegar(this.id);
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
		FncPagoOrdenVentaVehiculoEstablecerMoneda();
		FncCuentaCargar();
		FncTarjetaCargar();
	});
	
	$("select#CmpCuenta").change(function(){
		FncPagoOrdenVentaVehiculoEstablecerCuenta();
	});

	
	$("select#CmpTarjeta").change(function(){
		FncCuentaCargar();
	});	
	
	

});
	
function FncPagoOrdenVentaVehiculoNavegar(oCampo){
	
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


/*
* FUNCIONES
*/

function FncPagoOrdenVentaVehiculoEstablecerMoneda(){

	var MonedaId = $('#CmpMonedaId').val();
	var TipoCambio = $('#CmpTipoCambio').val();
	var Fecha = $('#CmpFecha').val();

	if(MonedaId==""){
		$('#CmpTipoCambio').val('');
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


function FncPagoOrdenVentaVehiculoEstablecerCuenta(){
	
	var CuentaId = $('#CmpCuentaId').val();
	
	$.getJSON("comunes/Moneda/JnCuenta.php?CuentaId="+CuentaId,{}, 
		function(j){
			$("#CmpMonedaId").val(j.MonId);
			FncPagoOrdenVentaVehiculoEstablecerMoneda();
			
	});

}
