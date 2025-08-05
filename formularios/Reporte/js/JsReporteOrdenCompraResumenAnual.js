// JavaScript Document



function FncReporteOrdenCompraResumenAnualImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).target = 'IfrReporteOrdenCompraResumenAnual'+oIndice;
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).action = Accion;
	
}

function FncReporteOrdenCompraResumenAnualGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).target = 'IfrReporteOrdenCompraResumenAnual'+oIndice;
	document.getElementById('FrmReporteOrdenCompraResumenAnual'+oIndice).action = Accion;
	
}

function FncReporteOrdenCompraResumenAnualNuevo(){

				
}


