// JavaScript Document

function FncClienteCSIEditarImprimir(oIndice){
	var Accion = document.getElementById('FrmClienteCSIEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmClienteCSIEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = 'IfrClienteCSIEditar'+oIndice;
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion;
	
}

function FncClienteCSIEditarGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmClienteCSIEditar'+oIndice).action;
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = '_blank';
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmClienteCSIEditar'+oIndice).submit();
	
	document.getElementById('FrmClienteCSIEditar'+oIndice).target = 'IfrClienteCSIEditar'+oIndice;
	document.getElementById('FrmClienteCSIEditar'+oIndice).action = Accion;
	
}



function FncClienteCSIEditarNuevo(){


	
				
}
