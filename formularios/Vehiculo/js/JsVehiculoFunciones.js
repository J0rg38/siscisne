
// JavaScript Document

/*
*** EVENTOS
*/

function FncValidar(){

	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var VehiculoModelo = $("#CmpVehiculoModelo").val();
	var VehiculoVersion = $("#CmpVehiculoVersion").val();
	var UnidadMedida = $("#CmpUnidadMedida").val();

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
				
			return false;
			
		}else if(VehiculoVersion == ""){			
		
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una version de vehiculo",
					callback: function(result){
						$("#CmpVehiculoVersion").focus();
					}
				});
				
			return false;


		}else if(UnidadMedida == ""){
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debe escoger una unidad de medida ",
					callback: function(result){
						$("#CmpUnidadMedida").focus();
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
		
		$("#CmpUnidadMedida").removeAttr('disabled');		
		$("#CmpEstado").removeAttr('disabled');	
		return FncValidar();

	});

	$('#FrmEditar').on('submit', function() {
		
		$("#CmpUnidadMedida").removeAttr('disabled');	
		$("#CmpEstado").removeAttr('disabled');	
		
		return FncValidar();

	});
	
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

//function FncVehiculoModeloFuncion(){
//	FncVehiculoVersionesCargar();
//}


function FncVehiculoMarcaFuncion(){
	FncVehiculoModelosCargar();
}

function FncVehiculoModeloFuncion(){
	//alert(":3");
	FncVehiculoVersionesCargar();
}

function FncVehiculoVersionFuncion(){
	//FncVehiculoColoresCargar();
//	alert(":3");
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

