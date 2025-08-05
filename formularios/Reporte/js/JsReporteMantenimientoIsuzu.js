// JavaScript Document

function FncReporteMantenimientoIsuzuImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).action;
	
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).target = '_blank';
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).submit();
	
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).target = 'IfrReporteMantenimientoIsuzu'+oIndice;
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).action = Accion;
	
}

function FncReporteMantenimientoIsuzuGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).action;
	
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).target = '_blank';
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).submit();
	
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).target = 'IfrReporteMantenimientoIsuzu'+oIndice;
	document.getElementById('FrmReporteMantenimientoIsuzu'+oIndice).action = Accion;
	
}



function FncReporteMantenimientoIsuzuNuevo(){


	
				
}
