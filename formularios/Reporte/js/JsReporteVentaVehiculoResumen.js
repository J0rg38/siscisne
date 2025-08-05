// JavaScript Document

function FncReporteVentaVehiculoResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).target = 'IfrReporteVentaVehiculoResumen'+oIndice;
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).action = Accion;
	
}

function FncReporteVentaVehiculoResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).action;
	
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).target = 'IfrReporteVentaVehiculoResumen'+oIndice;
	document.getElementById('FrmReporteVentaVehiculoResumen'+oIndice).action = Accion;
	
}



function FncReporteVentaVehiculoResumenNuevo(){


	
				
}
