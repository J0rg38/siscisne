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

	var Fecha = $("#CmpFecha").val();
	var ProveedorNombre = $("#CmpProveedorNombre").val();
	var ProveedorId = $("#CmpProveedorId").val();
	var MonedaId = $("#CmpMonedaId").val();
	var Monto = $("#CmpMonto").val();
		
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
			
		}else if(ProveedorId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un proveedor",
					callback: function(result){
						$("#CmpProveedorNombre").focus();
					}
				});
				
			return false;
		}else if(ProveedorId == "" && ProveedorNombre!=""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un proveedor",
					callback: function(result){
						$("#CmpPersonal").focus();
					}
				});

			return false;
			
		}else if(MonedaId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpProveedorNombre").focus();
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
			
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
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
			FncPagoProveedorNavegar(this.id);
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
		FncPagoProveedorEstablecerMoneda();
		FncCuentaCargar();
	});
	
	$("select#CmpCuenta").change(function(){
		FncPagoProveedorEstablecerCuenta();
	});


	$("select#CmpTipoDestino").change(function(){
		FncPagoProveedorEstablecerTipoDestino($(this).val());
	});

});
	
function FncPagoProveedorNavegar(oCampo){
	
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

function FncPagoProveedorEstablecerMoneda(){

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

function FncPagoProveedorEstablecerCuenta(){
	
	var CuentaId = $('#CmpCuentaId').val();
	
	$.getJSON("comunes/Moneda/JnCuenta.php?CuentaId="+CuentaId,{}, 
		function(j){
			$("#CmpMonedaId").val(j.MonId);
			FncPagoProveedorEstablecerMoneda();

	});

}


function FncPagoProveedorEstablecerTipoDestino(oValor){

	switch(oValor){
		
		case "1":
			$("#CapProveedor").show();
			$("#CapCliente").hide();
			$("#CapPersonal").hide();
		break;
		
		case "2":
			$("#CapProveedor").hide();
			$("#CapCliente").show();
			$("#CapPersonal").hide();
		break;
		
		case "3":
			$("#CapProveedor").hide();
			$("#CapCliente").hide();
			$("#CapPersonal").show();
		break;
		
		default:
			$("#CapProveedor").hide();
			$("#CapCliente").hide();
			$("#CapPersonal").hide();
		break;
		
	}

}