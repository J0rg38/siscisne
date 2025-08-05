// JavaScript Document

function FncGuardar(){
	
	//HACK
	
	$("#CmpMonedaId").removeAttr('disabled');	
	$("#CmpClienteTipoDocumento").removeAttr('disabled');		
	
}


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
			FncDesembolsoNavegar(this.id);
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
		FncDesembolsoEstablecerMoneda();
		FncCuentaCargar();
	});
	
	$("select#CmpCuenta").change(function(){
		FncDesembolsoEstablecerCuenta();
	});


	$("select#CmpTipoDestino").change(function(){
		FncDesembolsoEstablecerTipoDestino($(this).val());
	});

});
	
function FncDesembolsoNavegar(oCampo){
	
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

function FncDesembolsoEstablecerMoneda(){

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

function FncDesembolsoEstablecerCuenta(){
	
	var CuentaId = $('#CmpCuentaId').val();
	
	$.getJSON("comunes/Moneda/JnCuenta.php?CuentaId="+CuentaId,{}, 
		function(j){
			$("#CmpMonedaId").val(j.MonId);
			FncDesembolsoEstablecerMoneda();

	});

}


function FncDesembolsoEstablecerTipoDestino(oValor){

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