// JavaScript Document

function FncReporteOrdenCompraResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).target = 'IfrReporteOrdenCompraResumen'+oIndice;
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).action = Accion;
	
}

function FncReporteOrdenCompraResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).target = 'IfrReporteOrdenCompraResumen'+oIndice;
	document.getElementById('FrmReporteOrdenCompraResumen'+oIndice).action = Accion;
	
}



function FncReporteOrdenCompraResumenNuevo(){


	
				
}
