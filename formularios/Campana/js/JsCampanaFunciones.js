// JavaScript Document

/*
*** EVENTOS
*/

$().ready(function() {

/*
* EVENTOS - INICIALES
*/
	$("select#CmpVehiculoMarca").change(function(){
		FncVehiculoModelosCargar();
	});

	$("select#CmpVehiculoModelo").change(function(){
		FncVehiculoVersionesCargar();
	});
	
	
	$("select#CmpVehiculoModelo").dblclick(function(){
		FncVehiculoModelosCargar();
	});

});




/*
*** FUNCIONES
*/


/*
* FUNCIONES - COMUNES
*/

function FncVehiculoMarcaFuncion(){
	FncVehiculoModelosCargar();
}

function FncVehiculoModeloFuncion(){
	
}

