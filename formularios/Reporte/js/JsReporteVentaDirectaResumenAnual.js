// JavaScript Document



function FncValidar(){

	var Moneda = $("#CmpMoneda").val();

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
		}else{
			return true;
		}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmReporteVentaDirectaResumenAnual').on('submit', function() {
	
		return FncValidar();

	});

/*
* EVENTOS - NAVEGACION
*/		

	
});




function FncReporteVentaDirectaResumenAnualImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).target = 'IfrReporteVentaDirectaResumenAnual'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaResumenAnualGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).target = 'IfrReporteVentaDirectaResumenAnual'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumenAnual'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaResumenAnualNuevo(){

				
}


