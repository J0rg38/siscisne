// JavaScript Document

function FncReporteFichaIngresoMantenimientoModeloMensualImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoModeloMensual'+oIndice;
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoMantenimientoModeloMensualGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoModeloMensual'+oIndice;
	document.getElementById('FrmReporteFichaIngresoMantenimientoModeloMensual'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoMantenimientoModeloMensualNuevo(){


	
				
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