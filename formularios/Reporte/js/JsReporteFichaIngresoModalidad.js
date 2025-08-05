// JavaScript Document

function FncReporteFichaIngresoModalidadImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).target = 'IfrReporteFichaIngresoModalidad'+oIndice;
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoModalidadGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).target = 'IfrReporteFichaIngresoModalidad'+oIndice;
	document.getElementById('FrmReporteFichaIngresoModalidad'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoModalidadNuevo(){


	
				
}
