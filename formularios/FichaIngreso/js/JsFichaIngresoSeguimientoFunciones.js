// JavaScript Document

function FncFichaIngresoSeguimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).target = 'IfrFichaIngresoSeguimiento'+oIndice;
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).action = Accion;
	
}

function FncFichaIngresoSeguimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).target = 'IfrFichaIngresoSeguimiento'+oIndice;
	document.getElementById('FrmFichaIngresoSeguimiento'+oIndice).action = Accion;
	
}



function FncFichaIngresoSeguimientoNuevo(){


				
}
