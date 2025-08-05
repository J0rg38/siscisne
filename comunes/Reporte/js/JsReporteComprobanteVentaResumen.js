// JavaScript Document




function FncValidar(){
	
	var respuesta = true
	
	var Moneda = $("#CmpMoneda").val();
	var FechaInicio = $("#CmpFechaInicio").val();
	var FechaFin = $("#CmpFechaFin").val();
	
	if(Moneda==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una moneda.",
				callback: function(result){
					$("#CmpMoneda").focus();
				}
			});
			
		respuesta = false;
			
	}else if(FechaInicio==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una moneda.",
				callback: function(result){
					$("#CmpFechaInicio").focus();
				}
			});	
			
		respuesta = false;		
		
	}else if(FechaFin==""){
	
			dhtmlx.alert({
				title:"Aviso",
				type:"alert-error",
				text:"No ha escogido una moneda.",
				callback: function(result){
					$("#CmpFechaFin").focus();
				}
			});	
			
		respuesta = false;

	}
	
	return respuesta;
	
}




$().ready(function() {



	$('#FrmRegistrar').on('submit', function() {
		
		$("#CmpEstado").removeAttr('disabled');		
		
		return FncValidar();

	});
	
	
	$('#BtnVer').on('click', function() {
		if(FncValidar()){
			FncReporteFacturaResumenVer('');
		}
	});
	
	
	$('#BtnImprimir').on('click', function() {
		if(FncValidar()){
			FncReporteFacturaResumenImprimir('');
		}
	});
	
	
	$('#BtnExcel').on('click', function() {
		if(FncValidar()){
			FncReporteFacturaResumenGenerarExcel('');
		}
	});
//
});





function FncReporteFacturaResumenImprimir(oIndice){
	var Accion = document.getElementById('FrmReporteFacturaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion+'?P=1';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = 'IfrReporteFacturaResumen'+oIndice;
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion;
	
}

function FncReporteFacturaResumenGenerarExcel(oIndice){
	var Accion = document.getElementById('FrmReporteFacturaResumen'+oIndice).action;
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = '_blank';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion+'?P=2';
	document.getElementById('FrmReporteFacturaResumen'+oIndice).submit();
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).target = 'IfrReporteFacturaResumen'+oIndice;
	document.getElementById('FrmReporteFacturaResumen'+oIndice).action = Accion;
	
}

function FncReporteFacturaResumenVer(oIndice){
	
	document.getElementById('FrmReporteFacturaResumen'+oIndice).submit();
	
}


