// JavaScript Document



function FncValidar(){

	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();

	if(FechaInicio == ""){		
		
			dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de inicio",
					callback: function(result){
						$("#CmpFechaInicio").focus();
					}
				});
				
			return false;
			
	}else if(FechaFin == ""){	
			
				dhtmlx.alert({
					title:"Aviso",
					type:"alert-error",
					text:"Debes ingresar una fecha de termino",
					callback: function(result){
						$("#CmpFechaFin").focus();
					}
				});
				
		return false;
			
	}else{
		return true;
	}
		
//		alert("adfsasdf");
	
}

$().ready(function() {

	
	$('#FrmReporteClienteFichaIngreso').on('submit', function() {
	
		return FncValidar();

	});

	
/*
* EVENTOS - NAVEGACION
*/		

	
});


function FncReporteClienteFichaIngresoImprimir(oIndice){
	
	//var Accion = document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action;
//	
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).submit();
//	
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = 'IfrReporteClienteFichaIngreso'+oIndice;
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion;
	
	var Accion = $('#FrmReporteClienteFichaIngreso'+oIndice).attr('action')
		
	$('#FrmReporteClienteFichaIngreso'+oIndice).attr('target', '_blank').attr('action', Accion+'?P=1').submit();
	 
}

function FncReporteClienteFichaIngresoGenerarExcel(oIndice){
	
	//var Accion = document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action;	
	var Accion = $('#FrmReporteClienteFichaIngreso'+oIndice).attr('action')
		
	$('#FrmReporteClienteFichaIngreso'+oIndice).attr('target', '_blank').attr('action', Accion+'?P=2').submit();
	 	 
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).submit();
//	
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = 'IfrReporteClienteFichaIngreso'+oIndice;
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion;
	
}



function FncReporteClienteFichaIngresoNuevo(){


	
				
}




//
//function FncReporteClienteFichaIngresoImprimir(oIndice){
//	var Accion = document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action;
//	
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion+'?P=1';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).submit();
//	
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = 'IfrReporteClienteFichaIngreso'+oIndice;
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion;
//	
//}
//
//function FncReporteClienteFichaIngresoGenerarExcel(oIndice){
//	var Accion = document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action;
//	
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = '_blank';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion+'?P=2';
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).submit();
//	
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).target = 'IfrReporteClienteFichaIngreso'+oIndice;
//	document.getElementById('FrmReporteClienteFichaIngreso'+oIndice).action = Accion;
//	
//}
//
//
//
//function FncReporteClienteFichaIngresoNuevo(){
//
//}
