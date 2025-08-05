// JavaScript Document



function FncValidar(){

	var ClienteNombreCompleto = $("#CmpClienteNombreCompleto").val();
	var Destinatarios = $("#CmpDestinatarios").val();
	var Contenido = $("#CmpContenido").val();

	if(Destinatarios == ""){		
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No se encontraron destinatarios",
				callback: function(result){
					$("#CmpDestinatarios").focus();
				}
			});

		return false;
		
	}else if(Contenido == ""){		
		
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha ingresado un contenido",
				callback: function(result){
					$("#CmpContenido").focus();
				}
			});

		return false;
		
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




/*
*** EVENTOS
*/	

$().ready(function() {
		
/*
Agregando Eventos
*/

});


$().ready(function() {
/*
* EVENTOS - NAVEGACION
*/		

/*
* EVENTOS - INICIALES
*/	
	//COMUNES VEHICULO



/*
Agregando Eventos
*/

		
/*
Agregando Eventos
*/

});

