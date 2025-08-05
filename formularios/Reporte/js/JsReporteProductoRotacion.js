// JavaScript Document

function FncReporteProductoRotacionImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteProductoRotacion'+oIndice).action;
	
	document.getElementById('FrmReporteProductoRotacion'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoRotacion'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteProductoRotacion'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoRotacion'+oIndice).target = 'IfrReporteProductoRotacion'+oIndice;
	document.getElementById('FrmReporteProductoRotacion'+oIndice).action = Accion;
	
}

function FncReporteProductoRotacionGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteProductoRotacion'+oIndice).action;
	
	document.getElementById('FrmReporteProductoRotacion'+oIndice).target = '_blank';
	document.getElementById('FrmReporteProductoRotacion'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteProductoRotacion'+oIndice).submit();
	
	document.getElementById('FrmReporteProductoRotacion'+oIndice).target = 'IfrReporteProductoRotacion'+oIndice;
	document.getElementById('FrmReporteProductoRotacion'+oIndice).action = Accion;
	
}



function FncReporteProductoRotacionNuevo(){


	
				
}
