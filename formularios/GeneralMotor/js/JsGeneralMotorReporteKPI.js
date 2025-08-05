// JavaScript Document


function FncGeneralMotorReporteKPIImprimir(oIndice){
	
	var Accion = document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action;
	
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).target = '_blank';
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).submit();
	
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).target = 'IfrGeneralMotorReporteKPI'+oIndice;
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action = Accion;
	
}

//function FncGeneralMotorReporteKPIGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action;
//	
//	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).target = '_blank';
//	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).submit();
//	
//	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).target = 'IfrGeneralMotorReporteKPI'+oIndice;
//	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action = Accion;
//	
//}

function FncGeneralMotorReporteKPIGenerarExcel(oIndice){
	
	var Accion = document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action;
	
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).target = '_blank';
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).submit();
	
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).target = 'IfrGeneralMotorReporteKPI'+oIndice;
	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).action = Accion;
	
}


//function FncGeneralMotorReporteKPIGenerarExcel(oIndice){
//	document.getElementById('FrmGeneralMotorReporteKPI'+oIndice).submit();
//}


function FncGeneralMotorReporteKPINuevo(){


	
				
}
