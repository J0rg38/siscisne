// JavaScript Document



function FncReporteVentaDirectaResumenMensualImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).target = 'IfrReporteVentaDirectaResumenMensual'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaResumenMensualGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).action;
	
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).target = 'IfrReporteVentaDirectaResumenMensual'+oIndice;
	document.getElementById('FrmReporteVentaDirectaResumenMensual'+oIndice).action = Accion;
	
}

function FncReporteVentaDirectaResumenMensualNuevo(){

				
}


