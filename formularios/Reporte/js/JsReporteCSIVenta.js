// JavaScript Document

function FncReporteCSIVentaImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteCSIVenta'+oIndice).action;
	
	document.getElementById('FrmReporteCSIVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCSIVenta'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteCSIVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteCSIVenta'+oIndice).target = 'IfrReporteCSIVenta'+oIndice;
	document.getElementById('FrmReporteCSIVenta'+oIndice).action = Accion;
	
}

function FncReporteCSIVentaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteCSIVenta'+oIndice).action;
	
	document.getElementById('FrmReporteCSIVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCSIVenta'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteCSIVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteCSIVenta'+oIndice).target = 'IfrReporteCSIVenta'+oIndice;
	document.getElementById('FrmReporteCSIVenta'+oIndice).action = Accion;
	
}



function FncReporteCSIVentaNuevo(){


	
				
}
