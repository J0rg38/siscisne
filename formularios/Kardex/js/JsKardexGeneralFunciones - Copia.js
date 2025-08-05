// JavaScript Document

function FncKardexGeneralImprimir(oIndice){
	var Accion = document.getElementById('FrmKardexGeneral'+oIndice).action;

	document.getElementById('FrmKardexGeneral'+oIndice).target = '_blank';
	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmKardexGeneral'+oIndice).submit();

	document.getElementById('FrmKardexGeneral'+oIndice).target = 'IfrKardexGeneral'+oIndice;
	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion;
}

function FncKardexGeneralGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmKardexGeneral'+oIndice).action;

	document.getElementById('FrmKardexGeneral'+oIndice).target = '_blank';
	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmKardexGeneral'+oIndice).submit();

	document.getElementById('FrmKardexGeneral'+oIndice).target = 'IfrKardexGeneral'+oIndice;
	document.getElementById('FrmKardexGeneral'+oIndice).action = Accion;
}



function FncKardexGeneralNuevo(){

	
				
}

