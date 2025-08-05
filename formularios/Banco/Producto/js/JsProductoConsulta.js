// JavaScript Document

function FncProductoConsultaImprimir(oIndice){
	var Accion = document.getElementById('FrmProductoConsulta'+oIndice).action;
	
	document.getElementById('FrmProductoConsulta'+oIndice).target = '_blank';
	document.getElementById('FrmProductoConsulta'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmProductoConsulta'+oIndice).submit();
	
	document.getElementById('FrmProductoConsulta'+oIndice).target = 'IfrProductoConsulta'+oIndice;
	document.getElementById('FrmProductoConsulta'+oIndice).action = Accion;
	
}

function FncProductoConsultaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmProductoConsulta'+oIndice).action;
	
	document.getElementById('FrmProductoConsulta'+oIndice).target = '_blank';
	document.getElementById('FrmProductoConsulta'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmProductoConsulta'+oIndice).submit();
	
	document.getElementById('FrmProductoConsulta'+oIndice).target = 'IfrProductoConsulta'+oIndice;
	document.getElementById('FrmProductoConsulta'+oIndice).action = Accion;
	
}



function FncProductoConsultaNuevo(){


	
				
}
