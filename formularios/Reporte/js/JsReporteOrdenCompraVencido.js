// JavaScript Document

function FncReporteOrdenCompraVencidoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).target = 'IfrReporteOrdenCompraVencido'+oIndice;
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).action = Accion;
	
}

function FncReporteOrdenCompraVencidoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).target = 'IfrReporteOrdenCompraVencido'+oIndice;
	document.getElementById('FrmReporteOrdenCompraVencido'+oIndice).action = Accion;
	
}



function FncReporteOrdenCompraVencidoNuevo(){


	
				
}
