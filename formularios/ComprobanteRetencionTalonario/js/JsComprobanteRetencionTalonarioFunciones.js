// JavaScript Document

//function FncGuardar(){
//	
//	//HACK
//	$("#CmpEstado").removeAttr('disabled');		
//	
//}

function FncValidar(){

	var Numero = $("#CmpNumero").val();
		
	if(Numero == ""){		
	
		dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un numero de talonario",
				callback: function(result){
					$("#CmpNumero").focus();
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

