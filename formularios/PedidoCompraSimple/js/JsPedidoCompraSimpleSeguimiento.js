// JavaScript Document

function FncPedidoCompraSeguimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).action;
	
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).target = 'IfrPedidoCompraSeguimiento'+oIndice;
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).action = Accion;
	
}

function FncPedidoCompraSeguimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).action;
	
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).target = 'IfrPedidoCompraSeguimiento'+oIndice;
	document.getElementById('FrmPedidoCompraSimpleSeguimiento'+oIndice).action = Accion;
	
}


function FncPedidoCompraSeguimientoNuevo(){
	
}



