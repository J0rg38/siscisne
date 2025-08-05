// JavaScript Document

function FncReporteCompraImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteCompra'+oIndice).action;
	
	document.getElementById('FrmReporteCompra'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCompra'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteCompra'+oIndice).submit();
	
	document.getElementById('FrmReporteCompra'+oIndice).target = 'IfrReporteCompra'+oIndice;
	document.getElementById('FrmReporteCompra'+oIndice).action = Accion;
	
}

function FncReporteCompraGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteCompra'+oIndice).action;
	
	document.getElementById('FrmReporteCompra'+oIndice).target = '_blank';
	document.getElementById('FrmReporteCompra'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteCompra'+oIndice).submit();
	
	document.getElementById('FrmReporteCompra'+oIndice).target = 'IfrReporteCompra'+oIndice;
	document.getElementById('FrmReporteCompra'+oIndice).action = Accion;
	
}



function FncReporteCompraNuevo(){


	
				
}
