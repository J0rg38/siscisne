// JavaScript Document


function FncValidar(){

	var CodigoOriginal = $("#CmpCodigoOriginal").val();
	
	if(CodigoOriginal == ""){		
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un codigo original",
				callback: function(result){
					$("#CmpCodigoOriginal").focus();
				}
			});

		return false;
	
	}else if(CodigoOriginal == CodigoOriginalAnterior){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Los codigos son iguales",
				callback: function(result){
					$("#CmpCodigoOriginal").focus();
				}
			});	
	
		return false;
	
	}else{
		
		return true;
		
	}
		
	
}


$().ready(function() {

	$('#FrmEditar').on('submit', function() {
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
});
