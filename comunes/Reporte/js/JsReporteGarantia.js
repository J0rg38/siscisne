// JavaScript Document

function FncReporteGarantiaImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteGarantia'+oIndice).action;
	
	document.getElementById('FrmReporteGarantia'+oIndice).target = '_blank';
	document.getElementById('FrmReporteGarantia'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteGarantia'+oIndice).submit();
	
	document.getElementById('FrmReporteGarantia'+oIndice).target = 'IfrReporteGarantia'+oIndice;
	document.getElementById('FrmReporteGarantia'+oIndice).action = Accion;
	
}

function FncReporteGarantiaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteGarantia'+oIndice).action;
	
	document.getElementById('FrmReporteGarantia'+oIndice).target = '_blank';
	document.getElementById('FrmReporteGarantia'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteGarantia'+oIndice).submit();
	
	document.getElementById('FrmReporteGarantia'+oIndice).target = 'IfrReporteGarantia'+oIndice;
	document.getElementById('FrmReporteGarantia'+oIndice).action = Accion;
	
}



function FncReporteGarantiaNuevo(){


	
				
}
