// JavaScript Document

function FncFichaIngresoCotizacionProductoSeguimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).target = 'IfrFichaIngresoCotizacionProductoSeguimiento'+oIndice;
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).action = Accion;
	
}

function FncFichaIngresoCotizacionProductoSeguimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).target = 'IfrFichaIngresoCotizacionProductoSeguimiento'+oIndice;
	document.getElementById('FrmFichaIngresoCotizacionProductoSeguimiento'+oIndice).action = Accion;
	
}



function FncFichaIngresoCotizacionProductoSeguimientoNuevo(){

				
}
