// JavaScript Document

function FncReporteCotizacionProductoSeguimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).target = 'IfrReporteCotizacionProductoSeguimiento'+oIndice;
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).action = Accion;
	
}

function FncReporteCotizacionProductoSeguimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).target = 'IfrReporteCotizacionProductoSeguimiento'+oIndice;
	document.getElementById('FrmReporteCotizacionProductoSeguimiento'+oIndice).action = Accion;
	
}



function FncReporteCotizacionProductoSeguimientoNuevo(){


	
				
}
