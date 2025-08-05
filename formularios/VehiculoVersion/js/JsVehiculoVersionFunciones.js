// JavaScript Document



function FncValidar(){

	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
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
	}else if(VehiculoModelo == ""){			
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"Debes escoger un modelo de vehiculo",
				callback: function(result){
					$("#CmpVehiculoModelo").focus();
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
	
	$("select#CmpAnoModelo").change(function(){
		FncVehiculoVersionCaracteristicaListar();
	});
	
});



$().ready(function() {

	$("select#CmpVehiculoMarca").change(function(){
		VehiculoModeloId = "";
		//FncVehiculoModelosCargar(VehiculoModeloHabilitado,$("#CmpVehiculoMarca").val(),$("#CmpVehiculoModelo").val());
		FncVehiculoModelosCargar();
	});
	
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="ano"){

			console.log("$(this).val(): "+$(this).val());
			
			var Ano = $(this).val();
			 
			$("#BtnMostrarAno_"+Ano).click(function(){
				FncMostrarCapaAno(Ano);
			});	
			
			$("#CapAno_"+$(this).val()).hide();
		
		}	
	});
	
	
	
//	FncVehiculoModelosCargar(VehiculoModeloHabilitado,$("#CmpVehiculoMarca").val(),$("#CmpVehiculoModelo").val());

});



function FncMostrarCapaAno(oAno){
	
	console.log("FncMostrarCapaAno: "+oAno);
	
	$('input[type=checkbox]').each(function () {
		if($(this).attr('etiqueta')=="ano"){
		
			if(oAno==$(this).val()){

				$("#CapAno_"+$(this).val()).show();
				
			}else{
				$("#CapAno_"+$(this).val()).hide();
			}
			//$(this).attr('checked', true);		
		
		}	
	});
	
}