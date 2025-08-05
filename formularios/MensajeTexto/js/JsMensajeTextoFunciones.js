// JavaScript Document


function FncValidar(){


	var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
	var ClienteId = $("#CmpClienteId").val();
	var Destinato = $("#CmpDestino").val();
	var Fecha = $("#CmpFecha").val();
	
	var MensajeTextoContenido = $("#CmpContenido").val();
		
		if(Destinato == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un solicitante",
					callback: function(result){
						$("#CmpDestino").focus();
					}
				});
				
			return false;
			
		}else if(ClienteNombreCompleto == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un cliente",
					callback: function(result){
						$("#CmpFechaProgramada").focus();
					}
				});
				
			return false;
		}else if(ClienteId == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un cliente",
					callback: function(result){
						$("#CmpClienteNombre").focus();
					}
				});
				
			return false;
		}else if(MensajeTextoContenido == ""){
			
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha ingresado una descripcion",
					callback: function(result){
						$("#CmpDestino").focus();
					}
				});
			
			return false;
		

			}else if(Fecha == ""){
			
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"No ha ingresado una fecha",
					callback: function(result){
						$("#CmpFecha").focus();
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
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');	
			
		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		

	
});




var FormularioCampos = [


"CmpFecha",
"CmpCondicionMensajeTexto",
"CmpCuenta",
"CmpClienteId",
"CmpManoObra",
"CmpManoObra"];

$().ready(function() {

	$("input,select,textarea").keypress(function (event) {  
		 if (event.keyCode == '13' && this.type !== "hidden") {
			FncMensajeTextoNavegar(this.id);
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

});
	
function FncMensajeTextoNavegar(oCampo){
	
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




