// JavaScript Document



function FncReporteAlmacenMovimientoEntradaReclamoVer(){
	
	//doIframe();
	
}

function FncReporteAlmacenMovimientoEntradaReclamoImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).action;
	
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).target = '_blank';
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).submit();
	
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).target = 'IfrReporteAlmacenMovimientoEntradaReclamo'+oIndice;
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).action = Accion;
	
}

function FncReporteAlmacenMovimientoEntradaReclamoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).action;
	
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).target = '_blank';
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).submit();
	
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).target = 'IfrReporteAlmacenMovimientoEntradaReclamo'+oIndice;
	document.getElementById('FrmReporteAlmacenMovimientoEntradaReclamo'+oIndice).action = Accion;
	
}

function FncReporteAlmacenMovimientoEntradaReclamoNuevo(){

				
}


