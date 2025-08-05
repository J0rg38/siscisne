// JavaScript Document

function FncVehiculoRecepcionFormatoImprimir(oIndice){
	var Accion = document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).action;
	
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).target = '_blank';
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).submit();
	
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).target = 'IfrVehiculoRecepcionFormato'+oIndice;
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).action = Accion;
	
}

function FncVehiculoRecepcionFormatoGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).action;
	
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).target = '_blank';
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).submit();
	
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).target = 'IfrVehiculoRecepcionFormato'+oIndice;
	document.getElementById('FrmVehiculoRecepcionFormato'+oIndice).action = Accion;
	
}


function FncVehiculoRecepcionFormatoNuevo(){
	
}



