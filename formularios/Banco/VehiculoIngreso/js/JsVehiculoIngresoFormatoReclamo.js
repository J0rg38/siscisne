// JavaScript Document

function FncVehiculoIngresoFormatoReclamoImprimir(oIndice){
	var Accion = document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).action;
	
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).target = '_blank';
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).submit();
	
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).target = 'IfrVehiculoIngresoFormatoReclamo'+oIndice;
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).action = Accion;
	
}

function FncVehiculoIngresoFormatoReclamoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).action;
	
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).target = '_blank';
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).submit();
	
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).target = 'IfrVehiculoIngresoFormatoReclamo'+oIndice;
	document.getElementById('FrmVehiculoIngresoFormatoReclamo'+oIndice).action = Accion;
	
}


function FncVehiculoIngresoFormatoReclamoNuevo(){
	
}



