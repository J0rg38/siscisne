// JavaScript Document

function FncReporteGeneralMotorMSIImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).action;
	
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).target = '_blank';
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).submit();
	
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).target = 'IfrReporteGeneralMotorMSI'+oIndice;
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).action = Accion;
	
}

function FncReporteGeneralMotorMSIGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).action;
	
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).target = '_blank';
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).submit();
	
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).target = 'IfrReporteGeneralMotorMSI'+oIndice;
	document.getElementById('FrmReporteGeneralMotorMSI'+oIndice).action = Accion;
	
}



function FncReporteGeneralMotorMSINuevo(){


	
				
}
