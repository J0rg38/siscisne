// JavaScript Document

function FncCotizacionProductoSeguimientoImprimir(oIndice){
	var Accion = document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).target = 'IfrCotizacionProductoSeguimiento'+oIndice;
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).action = Accion;
	
}

function FncCotizacionProductoSeguimientoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).action;
	
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).target = '_blank';
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).submit();
	
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).target = 'IfrCotizacionProductoSeguimiento'+oIndice;
	document.getElementById('FrmCotizacionProductoSeguimiento'+oIndice).action = Accion;
	
}



function FncCotizacionProductoSeguimientoNuevo(){


	
				
}
