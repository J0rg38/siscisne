// JavaScript Document

function FncReporteFichaIngresoComprobanteVentaImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).target = 'IfrReporteFichaIngresoComprobanteVenta'+oIndice;
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoComprobanteVentaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).target = 'IfrReporteFichaIngresoComprobanteVenta'+oIndice;
	document.getElementById('FrmReporteFichaIngresoComprobanteVenta'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoComprobanteVentaNuevo(){


	
				
}
