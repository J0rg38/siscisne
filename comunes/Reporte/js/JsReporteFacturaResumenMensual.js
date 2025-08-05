// JavaScript Document



function FncValidar(){

	var Moneda = $("#CmpMoneda").val();
	var ClienteId = $("#CmpClienteId").val();
	var Personal = $("#CmpPersonal").val();
		
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

	
	$('#FrmReporteFacturaResumenMensual').on('submit', function() {
	
		return FncValidar();

	});

/*
* EVENTOS - NAVEGACION
*/		

	
});






function FncReporteFacturaResumenMensualImprimir(oIndice){
	
	var Accion = document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).target = 'IfrReporteFacturaResumenMensual'+oIndice;
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).action = Accion;
	
}

function FncReporteFacturaResumenMensualGenerarExcel(oIndice){
	
	var Accion = document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).target = 'IfrReporteFacturaResumenMensual'+oIndice;
	document.getElementById('FrmReporteFacturaResumenMensual'+oIndice).action = Accion;
	
}

function FncReporteFacturaResumenMensualNuevo(){

				
}
