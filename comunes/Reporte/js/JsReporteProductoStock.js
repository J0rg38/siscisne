// JavaScript Document

function FncReporteProductoStockImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteProductoStock'+oIndice).action;
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteProductoStock'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = 'IfrReporteProductoStock'+oIndice;
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion;
	
}

function FncReporteProductoStockGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteProductoStock'+oIndice).action;
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteProductoStock'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoStock'+oIndice).target = 'IfrReporteProductoStock'+oIndice;
	document.getElementById('FrmReporteProductoStock'+oIndice).action = Accion;
	
}



function FncReporteProductoStockNuevo(){


	
				
}
