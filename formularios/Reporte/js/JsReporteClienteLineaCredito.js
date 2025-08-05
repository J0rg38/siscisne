// JavaScript Document

function FncReporteClienteLineaCreditoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action;
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = '_blank';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).submit();
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = 'IfrReporteClienteLineaCredito'+oIndice;
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion;
	
}

function FncReporteClienteLineaCreditoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action;
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = '_blank';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).submit();
	
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).target = 'IfrReporteClienteLineaCredito'+oIndice;
	document.getElementById('FrmReporteClienteLineaCredito'+oIndice).action = Accion;
	
}



function FncReporteClienteLineaCreditoNuevo(){


	
				
}
