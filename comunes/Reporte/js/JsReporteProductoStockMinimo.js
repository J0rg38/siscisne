// JavaScript Document

function FncReporteProductoStockMinimoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteProductoStockMinimo'+oIndice).action;
	
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).target = 'IfrReporteProductoStockMinimo'+oIndice;
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).action = Accion;
	
}

function FncReporteProductoStockMinimoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteProductoStockMinimo'+oIndice).action;
	
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).target = 'IfrReporteProductoStockMinimo'+oIndice;
	document.getElementById('FrmReporteProductoStockMinimo'+oIndice).action = Accion;
	
}

function FncReporteProductoStockMinimoNuevo(){

				
}
