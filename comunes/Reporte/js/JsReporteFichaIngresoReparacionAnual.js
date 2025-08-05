// JavaScript Document


function FncValidar(){

	var VehiculoMarca = $("#CmpVehiculoMarca").val();
	var ModalidadIngreso = $("#CmpModalidadIngreso").val();

	if(VehiculoMarca == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una marca",
					callback: function(result){
						$("#CmpVehiculoMarca").focus();
					}
				});
				
			return false;
	}else if(ModalidadIngreso == ""){			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes escoger una modalidad de ingreso",
					callback: function(result){
						$("#CmpModalidadIngreso").focus();
					}
				});
				
		return false;
			
	}else{
		return true;
	}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmReporteFichaIngresoReparacionAnual').on('submit', function() {
	
		return FncValidar();

	});

	
/*
* EVENTOS - NAVEGACION
*/		

	
});


function FncReporteFichaIngresoReparacionAnualImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).target = 'IfrReporteFichaIngresoReparacionAnual'+oIndice;
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoReparacionAnualGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).target = 'IfrReporteFichaIngresoReparacionAnual'+oIndice;
	document.getElementById('FrmReporteFichaIngresoReparacionAnual'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoReparacionAnualNuevo(){


	
				
}
