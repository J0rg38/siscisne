// JavaScript Document

function FncReporteCSIPostVentaImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteCSIPostVenta'+oIndice).action;
	
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).target = 'IfrReporteCSIPostVenta'+oIndice;
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).action = Accion;
	
}

function FncReporteCSIPostVentaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteCSIPostVenta'+oIndice).action;
	
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).target = 'IfrReporteCSIPostVenta'+oIndice;
	document.getElementById('FrmReporteCSIPostVenta'+oIndice).action = Accion;
	
}



function FncReporteCSIPostVentaNuevo(){


	
				
}
