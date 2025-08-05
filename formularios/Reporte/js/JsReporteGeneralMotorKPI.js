// JavaScript Document


function FncReporteGeneralMotorKPIImprimir(oIndice){
	
	var Accion = document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action;
	
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).target = '_blank';
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).submit();
	
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).target = 'IfrReporteGeneralMotorKPI'+oIndice;
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action = Accion;
	
}

//function FncReporteGeneralMotorKPIGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action;
//	
//	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).submit();
//	
//	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).target = 'IfrReporteGeneralMotorKPI'+oIndice;
//	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action = Accion;
//	
//}

function FncReporteGeneralMotorKPIGenerarExcel(oIndice){
	
	var Accion = document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action;
	
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).target = '_blank';
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).submit();
	
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).target = 'IfrReporteGeneralMotorKPI'+oIndice;
	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).action = Accion;
	
}


//function FncReporteGeneralMotorKPIGenerarExcel(oIndice){
//	
//	document.getElementById('FrmReporteGeneralMotorKPI'+oIndice).submit();
//
//}


function FncReporteGeneralMotorKPINuevo(){


	
				
}
