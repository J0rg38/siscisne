// JavaScript Document

function FncReporteFichaIngresoMantenimientoMarcaCuadroImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice;
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoMantenimientoMarcaCuadroGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice;
	document.getElementById('FrmReporteFichaIngresoMantenimientoMarcaCuadro'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoMantenimientoMarcaCuadroNuevo(){


	
				
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
