// JavaScript Document


function FncValidar(){

	var ClienteNombre = $("#CmpNombre").val();
	var ClienteNumeroDocumento = $("#CmpNumeroDocumento").val();
	var TipoDocumento = $("#CmpTipoDocumento").val();
	var Tipo = $("#CmpTipo").val();
	
	var CSIIncluir = $("#CmpCSIIncluir").val();	
	var CSIExcluirMotivo = $("#CmpCSIExcluirMotivo").val();
		
		
		if(ClienteNombre == ""){		
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un nombre de cliente",
					callback: function(result){
						$("#CmpNombre").focus();
					}
				});
				
			return false;
		}else if(TipoDocumento == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de documento",
					callback: function(result){
						$("#CmpTipoDocumento").focus();
					}
				});

		}else if(Tipo == ""){			

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de cliente",
					callback: function(result){
						$("#CmpTipo").focus();
					}
				});

			return false;
		}else if(TipoDocumento=="TDO-10003" && (ClienteNumeroDocumento.strlength < 11 || ClienteNumeroDocumento.strlength > 11) ){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"El numero de documento debe tener 11 digitos",
					callback: function(result){
						$("#CmpNumeroDocumento").focus();
					}
				});

			return false;
		}else if(TipoDocumento =="TDO-10001" && (ClienteNumeroDocumento.strlength < 8 || ClienteNumeroDocumento.strlength > 8) ){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"El numero de documento debe tener 8 digitos",
					callback: function(result){
						$("#CmpNumeroDocumento").focus();
					}
				});

			return false;
			
			
			
			
		}else if(CSIIncluir =="No" && CSIExcluirMotivo==""){

				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar un motivo de exclusion",
					callback: function(result){
						$("#CmpCSIExcluirMotivo").focus();
					}
				});

			return false;
			
			
		}else{
			return true;
		}
		
	
}

$().ready(function() {

	
	$('#FrmRegistrar').on('submit', function() {
		
//		alert("abc");
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {

		return FncValidar();

	});
	
/*
* EVENTOS - NAVEGACION
*/		


	var ClienteUso = $("#CmpClienteUso").val();
	var ClienteBloquear = $("#CmpClienteBloquear").val();
	
	if(ClienteUso == "PRINCIPAL" || ClienteUso == "RESTRINGIDO"){
		
		$("input,select,textarea").keypress(function (event) {  
		
			alert("Este CLIENTE no puede ser editado");
			
		}); 
		
		
		$("input").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
	
		$("select").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
		
		$("textarea").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
			
	}
	
	
	if(ClienteBloquear == "1"){
		
		$("input,select,textarea").keypress(function (event) {  
		
			alert("Este cliente  ha sido bloqueado y no puede ser editado");
			
		}); 
		
		
		$("input").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
	
		$("select").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
		
		$("textarea").keypress(function (event) {  
		
			$(this).attr('readonly', true);	
			
		}); 
		
	
	}
	
});

