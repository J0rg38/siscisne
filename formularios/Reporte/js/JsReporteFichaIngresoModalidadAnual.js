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

	
	$('#FrmReporteFichaIngresoModalidadAnual').on('submit', function() {
	
		return FncValidar();

	});

	
/*
* EVENTOS - NAVEGACION
*/		

	
});


function FncReporteFichaIngresoModalidadAnualImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).target = 'IfrReporteFichaIngresoModalidadAnual'+oIndice;
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).action = Accion;
	
}

function FncReporteFichaIngresoModalidadAnualGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).action;
	
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).submit();
	
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).target = 'IfrReporteFichaIngresoModalidadAnual'+oIndice;
	document.getElementById('FrmReporteFichaIngresoModalidadAnual'+oIndice).action = Accion;
	
}



function FncReporteFichaIngresoModalidadAnualNuevo(){


	
				
}
