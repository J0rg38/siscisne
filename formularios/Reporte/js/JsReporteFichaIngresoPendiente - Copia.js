// JavaScript Document

function FncReporteFichaIngresoPendienteImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).target = 'IfrReporteFichaIngresoPendiente'+oIndice;
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoPendienteGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).target = 'IfrReporteFichaIngresoPendiente'+oIndice;
	document.getElementById('FrmReporteFichaIngresoPendiente'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoPendienteNuevo(){


	
				
}
