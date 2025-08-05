// JavaScript Document

function FncReporteCotizacionVehiculoTraficoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).action;
	
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).submit();
	
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).target = 'IfrReporteCotizacionVehiculoTrafico'+oIndice;
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).action = Accion;
	
}

function FncReporteCotizacionVehiculoTraficoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).action;
	
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).submit();
	
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).target = 'IfrReporteCotizacionVehiculoTrafico'+oIndice;
	document.getElementById('FrmReporteCotizacionVehiculoTrafico'+oIndice).action = Accion;
	
}



function FncReporteCotizacionVehiculoTraficoNuevo(){


	
				
}
