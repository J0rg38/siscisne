// JavaScript Document

function FncReportePredictivoMantenimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).action;
	
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).target = '_blank';
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).submit();
	
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).target = 'IfrReportePredictivoMantenimiento'+oIndice;
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).action = Accion;
	
}

function FncReportePredictivoMantenimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).action;
	
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).target = '_blank';
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).submit();
	
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).target = 'IfrReportePredictivoMantenimiento'+oIndice;
	document.getElementById('FrmReportePredictivoMantenimiento'+oIndice).action = Accion;
	
}



function FncReportePredictivoMantenimientoNuevo(){


	
				
}
