// JavaScript Document

function FncGeneralMotorReporteMSIImprimir(oIndice){
	var Accion = document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).action;
	
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).target = '_blank';
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).submit();
	
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).target = 'IfrGeneralMotorReporteMSI'+oIndice;
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).action = Accion;
	
}

function FncGeneralMotorReporteMSIGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).action;
	
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).target = '_blank';
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).submit();
	
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).target = 'IfrGeneralMotorReporteMSI'+oIndice;
	document.getElementById('FrmGeneralMotorReporteMSI'+oIndice).action = Accion;
	
}



function FncGeneralMotorReporteMSINuevo(){


	
				
}
