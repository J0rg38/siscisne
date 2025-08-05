// JavaScript Document



function FncReporteAlmacenMovimientoSalidaResumenVer(){
	
	//doIframe();
	
}

function FncReporteAlmacenMovimientoSalidaResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = 'IfrReporteAlmacenMovimientoSalidaResumen'+oIndice;
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion;
	
}

function FncReporteAlmacenMovimientoSalidaResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).target = 'IfrReporteAlmacenMovimientoSalidaResumen'+oIndice;
	document.getElementById('FrmReporteAlmacenMovimientoSalidaResumen'+oIndice).action = Accion;
	
}

function FncReporteAlmacenMovimientoSalidaResumenNuevo(){

				
}


