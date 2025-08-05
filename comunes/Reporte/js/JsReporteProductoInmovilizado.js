// JavaScript Document

function FncReporteProductoInmovilizadoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteProductoInmovilizado'+oIndice).action;
	
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).target = 'IfrReporteProductoInmovilizado'+oIndice;
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).action = Accion;
	
}

function FncReporteProductoInmovilizadoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteProductoInmovilizado'+oIndice).action;
	
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).target = 'IfrReporteProductoInmovilizado'+oIndice;
	document.getElementById('FrmReporteProductoInmovilizado'+oIndice).action = Accion;
	
}



function FncReporteProductoInmovilizadoNuevo(){


	
				
}
