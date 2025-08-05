// JavaScript Document


function FncValidar(){

	var Tipo = $("#CmpTipo").val();
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
		if(Tipo == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger un tipo de encuesta",
					callback: function(result){
						$("#CmpTipo").focus();
					}
				});
				
			return false;
		}else if(FechaInicio == ""){			
dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de inicio",
					callback: function(result){
						$("#CmpFechaInicio").focus();
					}
				});
				
		}else if(FechaFin == ""){			
dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de termino",
					callback: function(result){
						$("#CmpFechaFin").focus();
					}
				});
			
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmReporteEncuesta').on('submit', function() {
	
		return FncValidar();

	});

	
/*
* EVENTOS - NAVEGACION
*/		

	
});


function FncReporteEncuestaImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteEncuesta'+oIndice).action;
	
	document.getElementById('FrmReporteEncuesta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteEncuesta'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteEncuesta'+oIndice).submit();
	
	document.getElementById('FrmReporteEncuesta'+oIndice).target = 'IfrReporteEncuesta'+oIndice;
	document.getElementById('FrmReporteEncuesta'+oIndice).action = Accion;
	
}

function FncReporteEncuestaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteEncuesta'+oIndice).action;
	
	document.getElementById('FrmReporteEncuesta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteEncuesta'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteEncuesta'+oIndice).submit();
	
	document.getElementById('FrmReporteEncuesta'+oIndice).target = 'IfrReporteEncuesta'+oIndice;
	document.getElementById('FrmReporteEncuesta'+oIndice).action = Accion;
	
}

function FncReporteEncuestaNuevo(){

				
}
/*
*** EVENTOS
*/

$().ready(function() {

/*
* EVENTOS - INICIALES
*/

});
