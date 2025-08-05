// JavaScript Document

function FncReporteFichaIngresoMantenimientoCuadroImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoCuadro'+oIndice;
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoMantenimientoCuadroGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).target = 'IfrReporteFichaIngresoMantenimientoCuadro'+oIndice;
	document.getElementById('FrmReporteFichaIngresoMantenimientoCuadro'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoMantenimientoCuadroNuevo(){


	
				
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
