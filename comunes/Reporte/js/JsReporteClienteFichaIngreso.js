// JavaScript Document

function FncReporteClienteFichaIngresoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action;
	
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = '_blank';
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).submit();
	
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = 'IfrReporteClienteFichaIngreso'+oIndice;
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion;
	
}

function FncReporteClienteFichaIngresoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action;
	
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = '_blank';
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).submit();
	
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = 'IfrReporteClienteFichaIngreso'+oIndice;
	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion;
	
}



function FncReporteClienteFichaIngresoNuevo(){

}
