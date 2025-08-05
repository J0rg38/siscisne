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

	
	$('#FrmReporteSeguimientoReparacion').on('submit', function() {
	
		return FncValidar();

	});

/*
* EVENTOS - NAVEGACION
*/		

	
});




function FncReporteSeguimientoReparacionImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).action;
	
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).target = '_blank';
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).submit();
	
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).target = 'IfrReporteSeguimientoReparacion'+oIndice;
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).action = Accion;
	
}

function FncReporteSeguimientoReparacionGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).action;
	
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).target = '_blank';
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).submit();
	
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).target = 'IfrReporteSeguimientoReparacion'+oIndice;
	document.getElementById('FrmReporteSeguimientoReparacion'+oIndice).action = Accion;
	
}

function FncReporteSeguimientoReparacionNuevo(){

				
}


