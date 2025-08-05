// JavaScript Document



function FncValidar(){

	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var Tipo = $("#CmpTipo").val();
	var Nombre = $("#CmpNombre").val();


	if(VehiculoMarca == ""){		
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger una marca de vehiculo",
				callback: function(result){
					$("#CmpVehiculoMarca").focus();
				}
			});

		return false;
		
	}else if(Tipo == "" ){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un tipo",
				callback: function(result){
					$("#CmpTipo").focus();
				}
			});	
			
	}else if(Nombre == "" ){		
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes ingresar un nombre",
				callback: function(result){
					$("#CmpNombre").focus();
				}
			});	
	
	
			
	}else{
		return true;
	}
		
	
}


$().ready(function() {

	$('#FrmRegistrar').on('submit', function() {
		return FncValidar();
	});

	$('#FrmEditar').on('submit', function() {
		return FncValidar();
	});
	
/*
* EVENTOS - NAVEGACION
*/		
	
	
	
});



$().ready(function() {

});


