// JavaScript Document



function FncValidar(){

	var Moneda = $("#CmpMoneda").val();
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
		
		if(Moneda == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una moneda",
					callback: function(result){
						$("#CmpMoneda").focus();
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
				
			return false;
				
		}else if(FechaFin == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de termino",
					callback: function(result){
						$("#CmpFechaInicio").focus();
					}
				});
				
			return false;
			
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmReporteComprobanteResumen').on('submit', function() {
	
		return FncValidar();

	});

/*
* EVENTOS - NAVEGACION
*/		

	
});






function FncReporteComprobanteResumenImprimir(oIndice){
	
	var Accion = document.getElementById('FrmReporteComprobanteResumen'+oIndice).action;
	
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).target = 'IfrReporteComprobanteResumen'+oIndice;
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).action = Accion;
	
}

function FncReporteComprobanteResumenGenerarExcel(oIndice){
	
	var Accion = document.getElementById('FrmReporteComprobanteResumen'+oIndice).action;
	
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).target = 'IfrReporteComprobanteResumen'+oIndice;
	document.getElementById('FrmReporteComprobanteResumen'+oIndice).action = Accion;
	
}

function FncReporteComprobanteResumenNuevo(){

				
}
