// JavaScript Document

function FncReporteFichaIngresoReparacionCuadroImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).target = 'IfrReporteFichaIngresoReparacionCuadro'+oIndice;
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoReparacionCuadroGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).target = 'IfrReporteFichaIngresoReparacionCuadro'+oIndice;
	document.getElementById('FrmReporteFichaIngresoReparacionCuadro'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoReparacionCuadroNuevo(){


	
				
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
