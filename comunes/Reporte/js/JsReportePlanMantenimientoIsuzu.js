// JavaScript Document

function FncReportePlanMantenimientoStockImprimir(oIndice){
	var Accion = document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).action;
	
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).target = '_blank';
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).submit();
	
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).target = 'IfrReportePlanMantenimientoStock'+oIndice;
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).action = Accion;
	
}

function FncReportePlanMantenimientoStockGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).action;
	
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).target = '_blank';
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).submit();
	
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).target = 'IfrReportePlanMantenimientoStock'+oIndice;
	document.getElementById('FrmReportePlanMantenimientoStock'+oIndice).action = Accion;
	
}



function FncReportePlanMantenimientoStockNuevo(){


	
				
}
