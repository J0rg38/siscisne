// JavaScript Document

function FncReporteOrdenCompraPendienteImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).target = 'IfrReporteOrdenCompraPendiente'+oIndice;
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).action = Accion;
	
}

function FncReporteOrdenCompraPendienteGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).action;
	
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).target = '_blank';
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).submit();
	
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).target = 'IfrReporteOrdenCompraPendiente'+oIndice;
	document.getElementById('FrmReporteOrdenCompraPendiente'+oIndice).action = Accion;
	
}



function FncReporteOrdenCompraPendienteNuevo(){


	
				
}
