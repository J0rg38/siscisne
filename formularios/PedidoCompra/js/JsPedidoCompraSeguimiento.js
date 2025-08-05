// JavaScript Document

function FncPedidoCompraSeguimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).action;
	
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).target = 'IfrPedidoCompraSeguimiento'+oIndice;
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).action = Accion;
	
}

function FncPedidoCompraSeguimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).action;
	
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).target = 'IfrPedidoCompraSeguimiento'+oIndice;
	document.getElementById('FrmPedidoCompraSeguimiento'+oIndice).action = Accion;
	
}


function FncPedidoCompraSeguimientoNuevo(){
	
}



