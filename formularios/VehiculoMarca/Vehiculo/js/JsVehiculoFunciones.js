
// JavaScript Document

/*
*** EVENTOS
*/

$().ready(function() {

/*
* EVENTOS - INICIALES
*/
	$("select#CmpVehiculoMarca").change(function(){
		//VehiculoModeloId = "";
		//FncVehiculoMarcaNuevo();
		FncVehiculoModelosCargar();
	});

	$("select#CmpVehiculoModelo").change(function(){
		//VehiculoVersionId = "";
		FncVehiculoVersionesCargar();
	});

});


/*
*** FUNCIONES
*/


/*
* FUNCIONES - COMUNES
*/

function FncVehiculoModeloFuncion(){
	FncVehiculoVersionesCargar();
}



/*
* FUNCIONES - IMPRESION
*/

function FncImprimir(){
	window.print() ;
}

function FncImprimirCodigoBarra(){

	var acc = document.getElementById("FrmGenerar").action;
	document.getElementById("FrmGenerar").action = acc+'&P=1';
	//document.getElementById("FrmGenerar").target = '_blank';
	document.getElementById("FrmGenerar").submit();
	//document.getElementById("FrmGenerar").action = "#";
	//document.getElementById("FrmGenerar").target = '_self';
}

