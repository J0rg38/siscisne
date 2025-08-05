// JavaScript Document

function FncFichaIngresoSeguimientoCotizacionNoPedidoImprimir(oIndice){
	var Accion = document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).action;
	
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).target = '_blank';
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).submit();
	
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).target = 'IfrFichaIngresoSeguimientoCotizacionNoPedido'+oIndice;
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).action = Accion;
	
}

function FncFichaIngresoSeguimientoCotizacionNoPedidoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).action;
	
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).target = '_blank';
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).submit();
	
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).target = 'IfrFichaIngresoSeguimientoCotizacionNoPedido'+oIndice;
	document.getElementById('FrmFichaIngresoSeguimientoCotizacionNoPedido'+oIndice).action = Accion;
	
}



function FncFichaIngresoSeguimientoCotizacionNoPedidoNuevo(){

				
}
