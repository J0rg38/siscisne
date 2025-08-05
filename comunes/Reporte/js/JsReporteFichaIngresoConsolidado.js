// JavaScript Document

function FncReporteFichaIngresoConsolidadoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = 'IfrReporteFichaIngresoConsolidado'+oIndice;
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoConsolidadoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).target = 'IfrReporteFichaIngresoConsolidado'+oIndice;
	document.getElementById('FrmReporteFichaIngresoConsolidado'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoConsolidadoNuevo(){


	
				
}



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

	
});


