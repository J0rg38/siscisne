// JavaScript Document

// JavaScript Document

function FncPagoCierreDiaImprimir(oIndice){
	var Accion = document.getElementById('FrmPagoCierreDia'+oIndice).action;
	
	document.getElementById('FrmPagoCierreDia'+oIndice).target = '_blank';
	document.getElementById('FrmPagoCierreDia'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmPagoCierreDia'+oIndice).submit();
	
	document.getElementById('FrmPagoCierreDia'+oIndice).target = 'IfrPagoCierreDia'+oIndice;
	document.getElementById('FrmPagoCierreDia'+oIndice).action = Accion;
	
}

function FncPagoCierreDiaGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmPagoCierreDia'+oIndice).action;
	
	document.getElementById('FrmPagoCierreDia'+oIndice).target = '_blank';
	document.getElementById('FrmPagoCierreDia'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmPagoCierreDia'+oIndice).submit();
	
	document.getElementById('FrmPagoCierreDia'+oIndice).target = 'IfrPagoCierreDia'+oIndice;
	document.getElementById('FrmPagoCierreDia'+oIndice).action = Accion;
	
}



function FncPagoCierreDiaNuevo(){

}
