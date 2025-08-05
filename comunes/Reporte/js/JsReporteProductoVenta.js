// JavaScript Document

function FncReporteProductoVentaImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteProductoVenta'+oIndice).action;
	
	document.getElementById('FrmReporteProductoVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoVenta'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteProductoVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoVenta'+oIndice).target = 'IfrReporteProductoVenta'+oIndice;
	document.getElementById('FrmReporteProductoVenta'+oIndice).action = Accion;
	
}

function FncReporteProductoVentaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteProductoVenta'+oIndice).action;
	
	document.getElementById('FrmReporteProductoVenta'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoVenta'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteProductoVenta'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoVenta'+oIndice).target = 'IfrReporteProductoVenta'+oIndice;
	document.getElementById('FrmReporteProductoVenta'+oIndice).action = Accion;
	
}



function FncReporteProductoVentaNuevo(){


	
				
}
