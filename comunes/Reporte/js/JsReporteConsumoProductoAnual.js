// JavaScript Document

function FncReporteConsumoProductoAnualImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).action;
	
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).target = 'IfrReporteConsumoProductoAnual'+oIndice;
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).action = Accion;
	
}

function FncReporteConsumoProductoAnualGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).action;
	
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).target = 'IfrReporteConsumoProductoAnual'+oIndice;
	document.getElementById('FrmReporteConsumoProductoAnual'+oIndice).action = Accion;
	
}



function FncReporteConsumoProductoAnualNuevo(){


	
				
}
